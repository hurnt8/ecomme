# Atelier Maison

Boutique en ligne de mobilier, décoration, salle de bain et bois de chauffage — monolithe Laravel 12 (Blade + Vite + Tailwind CSS + Alpine.js), construit à partir du template statique [`shop-master`](https://freehtml5.co/) et calqué sur le schéma de données et les règles métier du projet de référence BloomShop.

## Stack

- PHP 8.2+, Laravel 12
- MySQL 8 (utf8mb4_unicode_ci)
- Node 20+, Vite, Tailwind CSS 4 (back-office), Alpine.js 3
- Bootstrap 3 + jQuery vendorisés dans `public/template/` (front public, hérité du template)
- Pest 3 pour les tests
- `barryvdh/laravel-dompdf` pour les factures/reçus PDF

## Prérequis

- PHP 8.2+ avec les extensions `pdo_mysql`, `gd`, `mbstring`, `intl`, `zip`
- Composer 2
- MySQL 8 (ou MariaDB 10.6+)
- Node.js 20+ et npm
- (optionnel) Docker Desktop + WSL2 pour l'installation via Sail

## Installation locale — XAMPP

1. **Cloner le projet dans `htdocs`**, puis créer la base :

   ```sql
   CREATE DATABASE atelier_maison CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. **Installation en une commande** — `composer setup` enchaîne `composer install`, la copie de `.env`, `key:generate`, `migrate` et le build des assets :

   ```bash
   composer setup
   ```

   Renseigner ensuite les identifiants MySQL dans `.env` (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) si les valeurs par défaut ne conviennent pas. Pour une installation manuelle :

   ```bash
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   npm run build
   ```

3. **Peupler la base** (catalogue, réglages, bannières, blog, compte admin) :

   ```bash
   php artisan db:seed
   ```

   Les seeders sont **idempotents** (`updateOrCreate`) : on peut les relancer sans dupliquer les données. `ProductSeeder` et `BlogPostSeeder` suppriment en fin d'exécution les entrées qui ne figurent plus dans leur tableau, pour qu'un ancien catalogue ne survive pas à un re-seed. L'historique de commandes n'est pas affecté : `order_items` conserve un instantané de `product_name` et `unit_price`, et sa clé `product_id` est en `nullOnDelete`.

   Pour ne rejouer qu'un seeder :

   ```bash
   php artisan db:seed --class=ProductSeeder
   ```

4. **Lien symbolique de stockage** (obligatoire pour que les images produits et bannières soient servies) :

   ```bash
   php artisan storage:link
   ```

5. **Lancer le développement** — le script `composer dev` démarre en parallèle le serveur PHP, le worker de file d'attente, les logs et Vite :

   ```bash
   composer dev
   ```

   Ou séparément :

   ```bash
   php artisan serve
   php artisan queue:listen
   npm run dev
   ```

6. Ouvrir `http://localhost:8000`. Back-office : `http://localhost:8000/admin`.

### Comptes de démonstration

| Rôle  | E-mail                      | Mot de passe |
|-------|-----------------------------|--------------|
| Admin | `admin@atelier-maison.test` | `password`   |

> ⚠️ Identifiants et coordonnées bancaires de démonstration (`SettingSeeder`) — à remplacer avant toute mise en production.

## Installation locale — Docker (Laravel Sail)

Le projet embarque une stack [Sail](https://laravel.com/docs/sail) (app + MySQL 8.4) dans `compose.yaml`. Sous Windows, Sail nécessite Docker Desktop configuré avec le backend WSL2.

```bash
composer install
cp .env.example .env
# DB_HOST=mysql, DB_DATABASE/DB_USERNAME/DB_PASSWORD au choix — Sail les reprend automatiquement
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan storage:link
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

L'application est servie sur `http://localhost` (port configurable via `APP_PORT`).

## Catalogue et photographies

Le catalogue livré par les seeders compte **58 références réparties sur 6 catégories**, dont **44 disposent d'une photographie**.

| Catégorie          | Références | Avec photo |
|--------------------|-----------:|-----------:|
| Mobilier           |         24 |         24 |
| Salle de bain      |         11 |         11 |
| Décoration         |          9 |          9 |
| Bois & Chauffage   |          8 |          0 |
| Jardin & Extérieur |          3 |          0 |
| Équipement Maison  |          3 |          0 |

### Origine des données

Les **noms et prix** des gammes Mobilier, Décoration et Salle de bain proviennent du catalogue du fournisseur `meuble-passion.com`, ainsi que leur **photographie** (800 × 800). Les **descriptions sont rédigées en interne** — elles ne sont pas reprises du fournisseur.

Les fichiers sources vivent dans `database/seeders/assets/products/`, nommés `mp-<id fournisseur>.<ext>` : le nom de fichier du fournisseur n'est pas un identifiant fiable (plusieurs produits différents partagent le même nom d'image chez lui). L'extension suit le **type MIME réel** — certaines URL en `.jpg` renvoient en fait du WebP ou du PNG. `ProductSeeder` recopie ces fichiers vers `storage/app/public/products/` au premier seed.

Deux autres fournisseurs n'ont pas fourni d'imagerie exploitable :

- **`meublespin.fr`** (bureaux en pin massif) — aucune photo par produit : toute la catégorie partage un même montage.
- **`chthibois.fr`** (bois de chauffage, granulés) — le site répond **403** aux requêtes automatisées. Les caractéristiques des produits Bois & Chauffage suivent donc les normes courantes du marché français (granulés 6 mm, humidité < 10 %, cendres < 0,7 %, ~4,8 kWh/kg, palette de 66 sacs). **Les prix et conditionnements doivent être confirmés auprès du fournisseur avant mise en production.**

### Produits sans photographie

`Product::thumbnail_url` retourne un **SVG neutre en `data:` URI** lorsqu'un produit n'a aucune image (`Product::hasPhoto()`), plutôt que d'emprunter la photo d'un autre article. Le comportement est verrouillé par `tests/Feature/ProductPhotoPlaceholderTest.php`. Pour ajouter une photo, soit l'uploader via `/admin/produits`, soit déposer le fichier dans `database/seeders/assets/products/` et le nommer dans le tableau `images` du produit dans `ProductSeeder`.

### Visuels éditoriaux

Les héros de page, les 5 bannières et les 5 couvertures d'articles sont dérivés de cette même photographie fournisseur :

- `public/images/hero-{boutique,maison,objets}.jpg` — triptyques 2400 × 800 servis par le composant `<x-shop.page-hero>`.
- `database/seeders/assets/banners/` — bannières recopiées vers `storage/app/public/banners/` par `BannerSeeder`.

Les images `public/template/images/img_bg_*.jpg` du template d'origine ne sont **plus référencées** : ce sont des photos des produits de démonstration du template (rocking-chair en béton, méridienne tressée…), qui ne figurent pas au catalogue.

> Les visuels fournisseurs sont réutilisés dans le cadre de l'accord commercial du marchand avec ses fournisseurs. À confirmer par écrit avant mise en production.

## Tests

Suite Pest — **79 tests** (`77 passed`, `2 risky`) :

```bash
php artisan test          # ou : composer test
```

- **Feature** — accueil et meilleures ventes, catalogue et filtres, fiche produit, placeholder photo, panier, tunnel de commande, confirmation, suivi de commande, page À propos, formulaire de contact, bannières promo, contrôle d'accès admin, CRUD admin, réinitialisation de mot de passe.
- **Unit** — `CartService`, `SettingsService`, `ShippingService`.

`phpunit.xml` force SQLite en mémoire (`DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`) : aucune base dédiée aux tests n'est nécessaire.

> Les 2 tests marqués *risky* (« did not close its own output buffer ») sont ceux qui frappent `/`. Leurs assertions passent ; le diagnostic vient du harnais de test, et aucune erreur n'apparaît sur la page réelle. Voir « Dette technique connue ».

Style de code (Laravel Pint) :

```bash
vendor/bin/pint          # applique les corrections
vendor/bin/pint --test   # vérifie sans modifier
```

## Structure du projet

```text
app/
├── Actions/             Logique métier unitaire (PlaceOrderAction)
├── Services/            Orchestration (CartService, CheckoutService, ShippingService,
│                        SettingsService, ReviewGenerator)
├── Enums/               OrderStatus (+ trackingSteps/trackingPosition), UserRole
├── Http/
│   ├── Controllers/
│   │   ├── Shop/        Accueil, catalogue, produit, panier, commande, compte, PDF, pages…
│   │   └── Admin/       Tableau de bord, produits, catégories, bannières, commandes, réglages
│   ├── Middleware/      EnsureUserIsAdmin, SecurityHeaders
│   └── Requests/        Form Requests (Shop/, Admin/, Auth/)
├── Mail/                ContactMessage, OrderConfirmation, NewOrderAlert
├── Models/
├── Notifications/
└── Support/             Countries, Eurozone
database/
├── migrations/          14 migrations
└── seeders/
    ├── assets/          Sources d'images versionnées (products/, banners/)
    └── *Seeder.php      Admin, Setting, Category, Product, Banner, Review, BlogPost
lang/fr/                 validation, auth, passwords, pagination (publiés puis traduits —
                         Laravel 11+ ne livre plus de dossier lang/)
resources/
├── views/
│   ├── layouts/{shop,admin}.blade.php
│   ├── partials/shop/   header, footer, announcement-bar, whatsapp-button, toasts
│   ├── components/shop/ product-card, price, badge, page-hero
│   ├── shop/            home, catalog, product, cart, checkout, tracking, account, blog, pages/*
│   ├── admin/           dashboard, products, categories, banners, orders, settings
│   └── pdf/             invoice, receipt
├── css/app.css          Surcharges du template (~2 700 lignes, commentées par motif)
└── js/app.js
public/
├── images/              Héros de page (non issus du template)
└── template/            Assets vendorisés du template shop-master, pour fidélité visuelle
routes/{web.php,admin.php}
tests/{Feature,Unit}/
```

L'architecture sépare volontairement la logique métier (Actions/Services) des controllers, pour permettre d'exposer une API `/api/v1` plus tard sans refonte.

## Fonctionnalités

**Boutique publique** : accueil (bannières dynamiques, meilleures ventes, bandeau d'annonce), catalogue avec filtres latéraux / tri / recherche / pagination, fiche produit (galerie Alpine, variantes taille/couleur, avis, produits liés), panier persistant en session, tunnel de commande (livraison zone euro/international pilotée par les réglages, paiement par virement), facture et reçu PDF, suivi de commande par numéro + e-mail avec frise de statuts, compte client (inscription, connexion, historique, profil, réinitialisation de mot de passe), blog, pages institutionnelles (mentions légales, confidentialité, cookies, accessibilité, livraison, retours, moyens de paiement, CGV, à propos, carrières, presse, aide), formulaire de contact, newsletter, `sitemap.xml`.

L'ensemble du front est **responsive** et a été vérifié à 1440 px et 375 px. Deux partis pris structurants sur mobile :

- sur le tunnel de commande et la page contact, le **formulaire précède le récapitulatif / les coordonnées** dans le DOM, pour être atteint en premier une fois les colonnes empilées ;
- les listes de produits (panier, commande, suivi) sont des **lignes flex, jamais des `<table>`** — le tableau d'origine mesurait 488 px de large dans un viewport de 375 px et rendait le bouton de suppression inatteignable.

La page **À propos** se construit à partir du catalogue réel (nombre de références, gammes en stock, gammes encore vides) : elle ne peut pas annoncer plus que ce que la boutique propose réellement.

**Back-office** (`/admin`, réservé au rôle admin) : tableau de bord (CA, panier moyen, stock faible, meilleures ventes), CRUD produits (upload multi-image, image principale, tailles/couleurs, indicateur meilleure vente, avis générés), CRUD catégories (hiérarchie, ordre), CRUD bannières, gestion des commandes (changement de statut avec machine à états et notification client), réglages boutique (devise, taxes, livraison, coordonnées bancaires, réseaux sociaux, bandeau d'annonce).

### Thème du back-office

L'admin est la seule partie du projet qui utilise les utilitaires Tailwind — le front public est du CSS écrit à la main par-dessus le Bootstrap 3 vendorisé. Deux conséquences, toutes deux gérées dans `resources/css/app.css` :

- La palette `neutral` de Tailwind est **redéfinie dans `@theme`** vers une échelle chaude tirée des couleurs de la boutique (`#d1c286` or, `#b5502e` terracotta, gris chauds). Comme aucun utilitaire Tailwind n'est employé hors de l'admin, cette redéfinition retint tout le back-office sans toucher un seul fichier Blade et ne peut pas atteindre la boutique. Les statuts de commande gardent quatre teintes distinctes (`brand`, `steel`, `sage`, `clay`) pour rester lisibles d'un coup d'œil.
- Le Preflight de Tailwind étant volontairement exclu (il entrerait en conflit avec Bootstrap sur le front), l'admin n'avait **aucun reset** : tout s'affichait en Times New Roman, les `<textarea>` en monospace, les liens en `rgb(0,0,238)` souligné, et `box-sizing: border-box` manquait — chaque champ `w-full` débordait sa carte de 5 px. Le reset qui manquait est écrit dans `@layer base`, portée par la classe `.admin-ui` du `<body>` admin. L'ordre des couches est déclaré explicitement en tête de fichier (`@layer theme, base, utilities;`) pour que ce reset perde face aux utilitaires Tailwind.

## Écarts assumés par rapport au cahier des charges générique

Décisions prises en phase d'analyse pour rester fidèle au projet de référence (BloomShop) plutôt qu'au schéma générique :

- **Pas de table `product_variants`** : tailles/couleurs sont de simples tags JSON sur `products`, sans stock ni prix par combinaison — le stock est géré au niveau du produit.
- **Avis clients synthétiques** : pas de formulaire de soumission public ni de file de modération ; l'admin fixe un nombre d'avis souhaité par produit, généré/synchronisé par `ReviewGenerator`. Reflète le comportement réel du projet de référence.
- **Paiement par virement uniquement** : pas de champ `payment_method`, un seul mode de règlement (cohérent avec la référence).
- **Panier en session**, sans persistance en base ni fusion au login (pas de table `carts`).

## Déploiement production

### Apache / PHP-FPM

- Vhost pointant sur `public/` (jamais la racine du projet).
- PHP-FPM avec `opcache` activé (`opcache.validate_timestamps=0` en prod, à vider après chaque déploiement — ou déploiement zero-downtime).
- `mod_rewrite` activé pour le `.htaccess` de `public/`.

### Nginx + PHP-FPM (exemple)

```nginx
server {
    listen 80;
    server_name votre-domaine.tld;
    root /var/www/atelier-maison/public;

    add_header X-Frame-Options "SAMEORIGIN";
    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Terminer TLS en amont (Nginx ou load balancer) — `SecurityHeaders` envoie déjà `Strict-Transport-Security`, `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy` et `Permissions-Policy`.

### Supervisor pour la file d'attente

Les e-mails (confirmation de commande, changement de statut, alertes admin, contact) sont envoyés en file d'attente (`ShouldQueue`). En production, un worker persistant est nécessaire :

```ini
; /etc/supervisor/conf.d/atelier-maison-worker.conf
[program:atelier-maison-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/atelier-maison/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/atelier-maison/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
supervisorctl reread
supervisorctl update
supervisorctl start atelier-maison-worker:*
```

Planifier également le scheduler Laravel (nettoyage des sessions expirées, etc.) via cron :

```text
* * * * * cd /var/www/atelier-maison && php artisan schedule:run >> /dev/null 2>&1
```

## Checklist avant mise en production

### Configuration

- [ ] `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` sur le domaine réel.
- [ ] `APP_KEY` régénérée pour l'environnement de prod (`php artisan key:generate`), jamais celle du dépôt/dev.
- [ ] `MAIL_MAILER` configuré sur un vrai transport SMTP/API (le local utilise `log`).
- [ ] `CACHE_STORE` et `QUEUE_CONNECTION` sur **Redis** (le projet tourne sur le driver `database` en local pour rester simple sous XAMPP).
- [ ] Un worker Supervisor actif pour `queue:work` — sans lui, **aucun e-mail ne part**.
- [ ] `php artisan storage:link` exécuté sur le serveur de prod.
- [ ] `php artisan config:cache`, `route:cache`, `view:cache` après chaque déploiement.
- [ ] Sauvegardes automatisées de la base de données.
- [ ] HTTPS forcé (redirection HTTP→HTTPS en amont).
- [ ] Revoir les limites `throttle:` des routes sensibles (connexion, inscription, contact, commande, suivi — actuellement `5,1` et `10,1`) selon le trafic réel.
- [ ] Envisager une Content-Security-Policy explicite si des scripts tiers sont ajoutés (aucun n'est chargé par défaut).

### Données et contenu

- [ ] Remplacer les identifiants admin, coordonnées bancaires et informations de contact de démonstration (`SettingSeeder`, `AdminSeeder`), ou tout reconfigurer via `/admin/reglages` après déploiement.
- [ ] **Confirmer les prix et conditionnements du bois de chauffage et des granulés** auprès de `chthibois.fr` (voir « Catalogue et photographies »).
- [ ] **Ajouter le SIRET et le numéro de TVA intracommunautaire du vendeur sur les factures** — obligatoire en France, et **aucun champ n'existe aujourd'hui** dans `settings` (voir « Dette technique connue »).
- [ ] Confirmer par écrit l'accord de réutilisation des visuels fournisseurs.
- [ ] Compléter la section « Hébergement » de la page Mentions légales (`/mentions-legales`) avec les coordonnées réelles de l'hébergeur.
- [ ] Photographier les 14 références sans visuel (Bois & Chauffage, Jardin & Extérieur, Équipement Maison), qui s'affichent aujourd'hui avec un placeholder.

## Dette technique connue

- **Factures incomplètes au regard de la loi française** : `settings` ne comporte ni SIRET, ni numéro de TVA intracommunautaire, ni forme juridique / capital social. Les gabarits `resources/views/pdf/{invoice,receipt}.blade.php` ne peuvent donc pas les afficher. Nécessite une migration ajoutant ces colonnes, les champs correspondants dans `/admin/reglages`, et leur rendu dans les PDF.
- **14 produits sans photographie** — placeholder SVG en attendant (voir plus haut).
- **2 tests *risky*** (« did not close its own output buffer ») sur les tests frappant `/`. Les assertions passent et la page réelle ne produit aucune erreur ; l'origine n'a pas été isolée (ce n'est ni les requêtes, ni le contenu de la vue, ni la route, ni l'ordre d'exécution) et pointe vers le harnais de test.
- Pas de Content-Security-Policy stricte (headers de base seulement — voir `SecurityHeaders`).
- `CACHE_STORE=database` en local (voir checklist prod pour Redis).
- Le front public repose encore sur **Bootstrap 3 + jQuery** vendorisés, avec les contraintes que cela impose (`.input-group` en `display:table`, grille non-flex) ; les surcharges nécessaires sont regroupées et commentées dans `resources/css/app.css`.
