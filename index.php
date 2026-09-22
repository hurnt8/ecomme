<?php
/**
 * Passerelle Laravel pour un hébergement dont la racine web est public_html/.
 *
 * À PLACER : public_html/index.php  (racine du projet, à côté de artisan)
 *
 * Rôle : servir les fichiers de public/ et de storage/app/public/,
 * puis confier tout le reste à Laravel.
 *
 * Solution de contournement : si vous pouvez régler la racine du site sur
 * public_html/public dans hPanel, faites-le et supprimez ce fichier.
 */

$projectPath = __DIR__;
$publicBase  = $projectPath . '/public';

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$path = $path === false || $path === null ? '/' : rawurldecode($path);

/* ------------------------------------------------------------------
 * 1. Fichiers de storage/app/public/  (images produits, bannières...)
 * ---------------------------------------------------------------- */
if (strncmp($path, '/storage/', 9) === 0) {
    serveStatic(substr($path, 9), $projectPath . '/storage/app/public');
    /* Fichier absent : on laisse Laravel répondre, il affichera son propre 404. */
}

/* ------------------------------------------------------------------
 * 2. Fichiers statiques de public/  (CSS, JS, polices, build Vite...)
 * ---------------------------------------------------------------- */
if ($path !== '/' && $path !== '/index.php') {
    serveStatic(ltrim($path, '/'), $publicBase);
}

/* ------------------------------------------------------------------
 * 3. Tout le reste : Laravel
 * ---------------------------------------------------------------- */
$indexFile = $publicBase . '/index.php';

if (!is_file($indexFile)) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    exit("Erreur : public/index.php est introuvable.\nChemin attendu : $indexFile\n");
}

require $indexFile;

/* ==================================================================
 * FONCTIONS
 * ================================================================ */

/**
 * Sert $relative depuis $baseDir, si et seulement si le fichier est sûr.
 * Ne renvoie rien et laisse la main si le fichier n'est pas servable.
 */
function serveStatic(string $relative, string $baseDir): void
{
    $realBase = realpath($baseDir);
    if ($realBase === false) {
        return;
    }

    $realFile = realpath($realBase . '/' . $relative);
    if ($realFile === false || !is_file($realFile)) {
        return;
    }

    /* Anti-traversée : le fichier doit être SOUS le dossier de base.
     * Le séparateur final est indispensable, sinon un dossier voisin
     * nommé "public_backup" passerait le test. */
    if (strncmp($realFile, $realBase . DIRECTORY_SEPARATOR, strlen($realBase) + 1) !== 0) {
        return;
    }

    $ext = strtolower(pathinfo($realFile, PATHINFO_EXTENSION));

    /* Ne jamais livrer de code ni de fichier de configuration en clair. */
    static $forbidden = ['php', 'phtml', 'phar', 'env', 'ini', 'sh', 'sql', 'lock', 'log', 'htaccess'];
    if (in_array($ext, $forbidden, true) || $relative === '' || str_starts_with(basename($realFile), '.')) {
        return;
    }

    static $types = [
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'mjs'  => 'application/javascript',
        'json' => 'application/json',
        'map'  => 'application/json',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'webp' => 'image/webp',
        'avif' => 'image/avif',
        'ico'  => 'image/x-icon',
        'mp4'  => 'video/mp4',
        'webm' => 'video/webm',
        'ttf'  => 'font/ttf',
        'otf'  => 'font/otf',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'eot'  => 'application/vnd.ms-fontobject',
        'pdf'  => 'application/pdf',
        'txt'  => 'text/plain',
        'xml'  => 'application/xml',
        'webmanifest' => 'application/manifest+json',
    ];
    $mime = $types[$ext] ?? 'application/octet-stream';
    if (in_array($ext, ['css', 'js', 'mjs', 'json', 'svg', 'txt', 'xml'], true)) {
        $mime .= '; charset=utf-8';
    }

    $size  = filesize($realFile);
    $mtime = filemtime($realFile);
    $etag  = '"' . dechex($mtime) . '-' . dechex($size) . '"';

    header('Content-Type: ' . $mime);
    header('X-Content-Type-Options: nosniff');
    header('Accept-Ranges: bytes');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $mtime) . ' GMT');
    header('ETag: ' . $etag);

    /* Les fichiers de build/ portent un hachage dans leur nom : cache long.
     * Les autres peuvent être remplacés à l'identique : cache court. */
    header(str_contains($realFile, DIRECTORY_SEPARATOR . 'build' . DIRECTORY_SEPARATOR)
        ? 'Cache-Control: public, max-age=31536000, immutable'
        : 'Cache-Control: public, max-age=86400');

    /* Le navigateur a déjà le fichier : on évite de le renvoyer. */
    $ifNone = trim($_SERVER['HTTP_IF_NONE_MATCH'] ?? '');
    $ifMod  = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? '') ?: 0;
    if ($ifNone === $etag || ($ifMod !== 0 && $ifMod >= $mtime)) {
        http_response_code(304);
        exit;
    }

    if (isset($_SERVER['HTTP_RANGE'])) {
        serveRange($realFile, $size);
    }

    header('Content-Length: ' . $size);
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'HEAD') {
        readfile($realFile);
    }
    exit;
}

/**
 * Envoi partiel (lecture vidéo, reprise de téléchargement).
 * Ne renvoie rien si l'en-tête Range est inexploitable : l'appelant
 * poursuit alors avec un envoi complet.
 */
function serveRange(string $filePath, int $fileSize): void
{
    if (!preg_match('/^bytes=(\d*)-(\d*)$/', trim($_SERVER['HTTP_RANGE']), $m)) {
        return;
    }

    if ($m[1] === '' && $m[2] === '') {
        return;
    }

    if ($m[1] === '') {
        /* Forme "bytes=-500" : les 500 derniers octets. */
        $length = min((int) $m[2], $fileSize);
        $start  = $fileSize - $length;
        $end    = $fileSize - 1;
    } else {
        $start = (int) $m[1];
        $end   = $m[2] === '' ? $fileSize - 1 : min((int) $m[2], $fileSize - 1);
    }

    if ($start > $end || $start >= $fileSize) {
        http_response_code(416);
        header("Content-Range: bytes */$fileSize");
        exit;
    }

    $length = $end - $start + 1;
    http_response_code(206);
    header('Content-Length: ' . $length);
    header("Content-Range: bytes $start-$end/$fileSize");

    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'HEAD') {
        exit;
    }

    $fp = fopen($filePath, 'rb');
    if ($fp === false) {
        exit;
    }
    fseek($fp, $start);
    $sent = 0;
    while ($sent < $length && !feof($fp)) {
        $chunk = fread($fp, (int) min(8192, $length - $sent));
        if ($chunk === false || $chunk === '') {
            break;
        }
        echo $chunk;
        flush();
        $sent += strlen($chunk);
    }
    fclose($fp);
    exit;
}
