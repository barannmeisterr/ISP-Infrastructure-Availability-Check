# ISS Altyapı Sorgulama

Address-based internet infrastructure lookup and ISP (ISS) package comparison for Turkey. Visitors pick a UAVT address, see Fiber / VDSL / ADSL availability and speeds, then get matching packages from registered providers.

Admin users manage providers, packages, coverage areas, and homepage highlights.

**Author:** Arda Baran  
**Stack:** Laravel 12 · PHP 8.2+ · MariaDB · Redis · Vite · Tailwind CSS 4

---

## Features

### Public site

- Home page with stats, featured ISPs, and featured packages
- UAVT-driven infrastructure query (`/altyapi-sorgulama`): province → district → neighborhood → street → building → apartment
- Dual lookup:
  - **Türk Telekom / xDSL-Fiber** via BBK against the internal UAVT/control API
  - **ISS own network** via `package_areas` (Fiber / VDSL / ADSL flags and max speeds)
- Package listing and detail pages
- ISP listing and profile pages (contact, services, coverage)
- Support page

### Admin panel (`/admin`)

- Session login; routes protected by `auth` + `admin` middleware (`users.is_admin`)
- CRUD for ISS providers (logo, contact, service types, coverage text)
- CRUD for packages (speed, price, commitment, quota, xDSL type)
- CSV import of package coverage areas (`il / ilce / mahalle / csbm / bina`)
- Homepage settings: stats, highlighted providers, highlighted packages
- Homepage counters stay in sync via Eloquent observers on providers, packages, and service areas

---

## How lookup works

```text
Browser  →  /uavt/* (cascade address APIs)
         →  /altyapi/altyapiHizmetSorgu/{bbk}          Türk Telekom Fiber/VDSL/ADSL
         →  /altyapi/iss-altyapi-sorgu/{il}/{ilce}/…   ISS package_areas coverage
         →  matching package pages
```

xDSL type codes (`config/xdsl.php`):

| Code | Type  |
|------|-------|
| 1    | ADSL  |
| 6    | VDSL  |
| 7    | FIBER |

---

## Requirements

- PHP 8.2+ with `ext-curl`, `ext-pdo`, `ext-mbstring`
- Composer 2
- Node.js 18+ (Vite)
- MariaDB 10 (or MySQL) — production path uses Docker MariaDB
- Redis (optional, for cache)

Internal UAVT / `controlService` API must be reachable from the app host (currently called from `AdresService` and `AltyapiService`).

---

## Local setup

```bash
cd issmanager-altyapi

cp .env.example .env
composer install
php artisan key:generate

# Point DB_* at MariaDB, then:
php artisan migrate
php artisan storage:link

npm install
npm run build   # or: npm run dev
php artisan serve
```

Quick all-in-one (Composer script):

```bash
composer setup
composer dev
```

`composer dev` runs `artisan serve`, queue listener, logs, and Vite together.

Create an admin user in `users` with `is_admin = 1`, then open `/admin/login`.

---

## Environment

Start from `.env.example`. Typical production values:

```env
APP_NAME="ISS Altyapı"
APP_URL=https://your-domain

DB_CONNECTION=mysql
DB_HOST=mariadb
DB_PORT=3306
DB_DATABASE=iss_altyapi
DB_USERNAME=...
DB_PASSWORD=...

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

Move UAVT base URL and auth headers into `.env` rather than leaving them in service classes. Do not commit real tokens.

---

## Docker

`docker-compose.yml` provides:

| Service     | Role                          | Host port (default) |
|-------------|-------------------------------|---------------------|
| `php-fpm`   | PHP-FPM + Supervisor + cron   | 9000 (internal)     |
| `nginx`     | HTTP/HTTPS                    | 80 / 443            |
| `mariadb`   | Database                      | 3307 → 3306         |
| `redis`     | Cache                         | 6379                |
| `phpmyadmin`| DB UI                         | 8081                |

Compose expects host paths such as `APP_CODE_PATH_HOST`, `NGINX_SSL_PATH`, `DATA_PATH_HOST`, and nginx site config. Fill those in `.env` before `docker compose up -d`.

MariaDB is started with `--max_allowed_packet=2G` for large UAVT/CSV imports.

---

## Main routes

| Method | Path | Description |
|--------|------|-------------|
| GET | `/` | Home |
| GET | `/altyapi-sorgulama` | Infrastructure query UI |
| GET | `/paketler`, `/paket/{id}` | Packages |
| GET | `/internet-saglayicilari`, `/internet-saglayicilari/{slug}` | ISPs |
| GET | `/destek` | Support |
| GET | `/uavt/iller` … `/uavt/daireler/{bina_id}` | UAVT cascade |
| GET | `/altyapi/altyapiHizmetSorgu/{bbk}` | TT Fiber/VDSL/ADSL JSON |
| GET | `/altyapi/iss-altyapi-sorgu/...` | ISS coverage JSON |
| GET/POST | `/admin/login` | Admin auth |
| * | `/admin/*` | Dashboard, providers, packages, home settings |

---

## Project layout

```text
app/
  Http/Controllers/     Public, UAVT, altyapı, admin, auth
  Http/Middleware/      AdminMiddleware
  Models/               IssProvider, Package, PackageArea, IssServiceArea, Home*
  Observers/            Homepage stat sync
  Services/             AdresService, AltyapiService
config/xdsl.php         ADSL / VDSL / FIBER codes
database/migrations/    Schema
resources/views/        Blade (public + admin layouts)
routes/web.php          All HTTP routes
docker-compose.yml      MariaDB, Redis, Nginx, PHP-FPM, phpMyAdmin
```

---

## Data model (core)

- **iss_providers** — ISP profile, slug, logo, contact, services JSON
- **iss_service_areas** — textual coverage for the provider
- **packages** — offer tied to a provider and `altyapi_turleri.xdsltype`
- **package_areas** — UAVT IDs where a package is sold
- **home_stats** / **home_highlighted_*** — homepage CMS

---

## Tests

```bash
composer test
# or
php artisan test
```

---

## License

Application code follows the Laravel skeleton **MIT** license unless your organization applies a different license for this product.
