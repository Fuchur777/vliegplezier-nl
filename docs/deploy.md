# Deploy

Route B uit [`kosten-infrastructuur.md`](kosten-infrastructuur.md): een Hetzner-VPS, beheerd met Forge of Ploi, met Cloudflare ervoor. Frank richt de server en de beheertool in; deze pagina beschrijft wat de app daarvan nodig heeft.

## Server

- Ubuntu LTS, PHP 8.3+ met `pdo_pgsql` en `intl`, Nginx, Node 22 (voor de build).
- PostgreSQL 16 met de PostGIS-extensie (`CREATE EXTENSION postgis;` in de database).
- Dagelijkse back-ups van de database (Forge/Ploi-back-ups of Hetzner-snapshots).
- Een queue-worker (`php artisan queue:work`) en de scheduler (`php artisan schedule:run` elke minuut). Beide kunnen in Forge/Ploi met een klik.

## Omgevingsvariabelen (productie)

```env
APP_NAME=Vliegplezier
APP_ENV=production
APP_DEBUG=false
APP_URL=https://vliegplezier.nl
APP_LOCALE=nl

DB_CONNECTION=pgsql
DB_DATABASE=vliegplezier
DB_USERNAME=...
DB_PASSWORD=...

MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=...   # Brevo SMTP-login
MAIL_PASSWORD=...   # Brevo SMTP-sleutel
MAIL_FROM_ADDRESS=noreply@vliegplezier.nl
```

Voor Brevo moet het domein vliegplezier.nl geverifieerd zijn (SPF, DKIM en DMARC in de DNS).

## Deploy-script

Te plakken in Forge of Ploi:

```sh
cd $SITE_PATH
git pull origin main
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan optimize
php artisan queue:restart
```

## Cloudflare

- DNS van vliegplezier.nl via Cloudflare, proxy aan, SSL-modus "Full (strict)".
- Laat Laravel de juiste bezoekers-IP zien: vertrouw de Cloudflare-proxy's (nodig voor de IP-hash in WP3).
