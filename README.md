# Atelier Maison

Boutique en ligne de mobilier et décoration — monolithe Laravel 12 (Blade + Vite + Tailwind CSS + Alpine.js), construit à partir du template statique [`shop-master`](https://freehtml5.co/) et calqué sur le schéma de données et les règles métier du projet de référence BloomShop.

## Stack

- PHP 8.2+, Laravel 12
- MySQL 8 (utf8mb4_unicode_ci)
- Node 20+, Vite, Tailwind CSS (back-office), Alpine.js
- Pest 3 pour les tests
- `barryvdh/laravel-dompdf` pour les factures/reçus PDF

## Prérequis

- PHP 8.2+ avec les extensions `pdo_mysql`, `gd`, `mbstring`, `intl`, `zip`
- Composer 2
- MySQL 8 (ou MariaDB 10.6+)
- Node.js 20+ et npm
- (optionnel) Docker Desktop + WSL2 pour l'installation via Sail

## Installation locale — XAMPP

1. **Cloner le projet dans `htdocs`**, puis installer les dépendances :

   ```bash
   composer install
   npm install
   ```

2. **Configurer l'environnement** :

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Dans `.env`, renseigner les identifiants MySQL de votre instance XAMPP (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) et créer la base :

   ```sql
   CREATE DATABASE atelier_maison CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. **Migrer et peupler la base** (catalogue de démo, réglages, compte admin) :

   ```bash
   php artisan migrate --seed
   ```

4. **Lien symbolique de stockage** (obligatoire pour que les images uploadées soient servies) :

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

| Rôle  | E-mail                       | Mot de passe |
|-------|-------------------------------|---------------|
| Admin | `admin@atelier-maison.test`   | `password`    |

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

## Tests

Suite Pest — Feature (checkout, contrôle d'accès admin, CRUD produits, réinitialisation de mot de passe) et Unit (`ShippingService`, `CartService`, `SettingsService`) :

```bash
php artisan test
```

La configuration `phpunit.xml` utilise SQLite en mémoire : aucune base dédiée aux tests n'est nécessaire.

Style de code (Laravel Pint) :

```bash
vendor/bin/pint          # applique les corrections
vendor/bin/pint --test   # vérifie sans modifier
```

## Structure du projet

```
app/
├── Actions/            Logique métier unitaire (PlaceOrderAction…)
├── Services/            Orchestration (CartService, CheckoutService, ShippingService, SettingsService, ReviewGenerator)
├── Enums/               OrderStatus, UserRole
├── Http/
│   ├── Controllers/
│   │   ├── Shop/        Accueil, catalogue, produit, panier, commande, compte, pages…
│   │   └── Admin/       Tableau de bord, produits, catégories, bannières, commandes, réglages
│   ├── Middleware/       EnsureUserIsAdmin, SecurityHeaders
│   └── Requests/         Form Requests (Shop/, Admin/, Auth/)
├── Models/
├── Notifications/        OrderStatusChanged, NewOrderPlaced
└── Support/              Countries, Eurozone
resources/
├── views/
│   ├── layouts/{shop,admin}.blade.php
│   ├── partials/shop/    header, footer, announcement-bar, whatsapp-button, toasts
│   ├── components/shop/   product-card, price, badge, page-hero
│   ├── shop/              home, catalog, product, cart, checkout, account, blog, pages/*
│   ├── admin/              dashboard, products, categories, banners, orders, settings
│   └── pdf/                invoice, receipt
├── css/app.css, js/app.js
public/template/          Assets vendorisés du template shop-master (CSS/JS/images), pour fidélité visuelle
routes/{web.php,admin.php}
tests/{Feature,Unit}/
```

L'architecture sépare volontairement la logique métier (Actions/Services) des controllers, pour permettre d'exposer une API `/api/v1` plus tard sans refonte.

## Fonctionnalités

**Boutique publique** : accueil (bannières dynamiques, produits vedettes, bandeau d'annonce), catalogue avec filtres/tri/recherche/pagination, fiche produit (galerie, variantes taille/couleur, avis, produits liés), panier persistant en session, tunnel de commande (livraison zone euro/international pilotée par les réglages, paiement par virement), facture/reçu PDF via lien signé, suivi de commande par numéro + e-mail, compte client (inscription, connexion, historique de commandes, profil, réinitialisation de mot de passe), blog, pages institutionnelles (mentions légales, confidentialité, cookies, accessibilité, livraison, retours, moyens de paiement, CGV, à propos, carrières, presse, aide), formulaire de contact, newsletter, sitemap.xml.

**Back-office** (`/admin`, réservé au rôle admin) : tableau de bord (CA, panier moyen, stock faible, meilleures ventes), CRUD produits (upload multi-image, image principale, tailles/couleurs, avis générés), CRUD catégories (hiérarchie, ordre), CRUD bannières, gestion des commandes (changement de statut avec machine à états et notification client), réglages boutique (devise, taxes, livraison, coordonnées bancaires, réseaux sociaux, bandeau d'annonce).

## Écarts assumés par rapport au cahier des charges générique

Décisions prises en phase d'analyse pour rester fidèle au projet de référence (BloomShop) plutôt qu'au schéma générique :

- **Pas de table `product_variants`** : tailles/couleurs sont de simples tags JSON sur `products`, sans stock ni prix par combinaison — le stock est géré au niveau du produit.
- **Avis clients synthétiques** : pas de formulaire de soumission public ni de file de modération ; l'admin fixe un nombre d'avis souhaité par produit, généré/synchronisé par `ReviewGenerator`. Reflète le comportement réel du projet de référence.
- **Paiement par virement uniquement** : pas de champ `payment_method`, un seul mode de règlement (cohérent avec la référence).
- **Panier en session**, sans persistance en base ni fusion au login (pas de table `carts`).

## Déploiement production

### Apache / PHP-FPM

- Vhost pointant sur `public/` (jamais la racine du projet).
- PHP-FPM avec `opcache` activé (`opcache.validate_timestamps=0` en prod, à vider via `php artisan opcache:clear` — ou un déploiement zero-downtime — après chaque déploiement).
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

Terminer TLS en amont (Nginx ou load balancer) — `SecurityHeaders` envoie déjà `Strict-Transport-Security`.

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

```
* * * * * cd /var/www/atelier-maison && php artisan schedule:run >> /dev/null 2>&1
```

## Checklist avant mise en production

- [ ] `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` sur le domaine réel.
- [ ] `APP_KEY` régénérée pour l'environnement de prod (`php artisan key:generate`), jamais celle du dépôt/dev.
- [ ] Remplacer les identifiants admin, coordonnées bancaires et informations de contact de démonstration (`SettingSeeder`, `AdminSeeder`) par les vraies données, ou reconfigurer entièrement via `/admin/reglages` après déploiement.
- [ ] `MAIL_MAILER` configuré sur un vrai transport SMTP/API (le seeder utilise `log` en local).
- [ ] `CACHE_STORE` et `QUEUE_CONNECTION` sur **Redis** en production (le projet tourne sur le driver `database` en local pour rester simple sous XAMPP ; Redis réduit la charge DB pour les réglages/catégories mises en cache et les jobs).
- [ ] Un worker Supervisor actif pour `queue:work` (voir ci-dessus) — sans lui, aucun e-mail ne part.
- [ ] `php artisan storage:link` exécuté sur le serveur de prod (les images uploadées ne seront pas servies sinon).
- [ ] `php artisan config:cache`, `route:cache`, `view:cache` après chaque déploiement.
- [ ] Sauvegardes automatisées de la base de données.
- [ ] HTTPS forcé (redirection HTTP→HTTPS en amont) — `Strict-Transport-Security` est déjà envoyé par le middleware `SecurityHeaders`.
- [ ] Compléter la section « Hébergement » de la page Mentions légales (`/mentions-legales`) avec les coordonnées réelles de l'hébergeur.
- [ ] Envisager une Content-Security-Policy explicite si des scripts tiers sont ajoutés (aucun n'est chargé par défaut : tous les assets sont vendorisés/servis en local).
- [ ] Revoir le taux de limitation (`throttle:*`) des routes sensibles (connexion, inscription, contact, commande, suivi) selon le trafic réel attendu.

## Dette technique connue

- Pas de Content-Security-Policy stricte (headers de base seulement — voir `SecurityHeaders`).
- `CACHE_STORE=database` en local (voir checklist prod pour Redis).
- La page Mentions légales contient un espace réservé pour les coordonnées de l'hébergeur.
