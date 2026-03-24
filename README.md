# Ambil Yuk

A simple web app for an admin to post second-hand items, and friends can queue up to claim them.

## Tech Stack

- **Backend:** Laravel 13 (PHP 8.4)
- **Frontend:** Blade + Tailwind CSS v4 + Alpine.js
- **Database:** MySQL 8
- **Deployment:** Docker Compose (nginx + php-fpm + mysql)

---

## Demo Accounts

| Role  | Username | Password |
|-------|----------|----------|
| Admin | `admin`  | `password` |
| User  | `budi`   | `password` |
| User  | `sari`   | `password` |
| User  | `andi`   | `password` |
| User  | `rina`   | `password` |
| User  | `doni`   | `password` |

---

## Deploy to VPS (Fresh Server)

### 1. Install Docker

```bash
curl -fsSL https://get.docker.com | sh
sudo usermod -aG docker $USER && newgrp docker
```

### 2. Clone the repository

```bash
git clone <repo-url> /srv/ambilyuk
cd /srv/ambilyuk
```

### 3. Set up environment file

```bash
cp .env.example .env
nano .env
```

Update the following values:

```env
APP_URL=http://<VPS-IP-or-domain>
DB_PASSWORD=replace_with_strong_password
```

> `DB_PASSWORD` is used by both Laravel and the MySQL container — make sure the value is the same.

### 4. Build and start containers

```bash
docker compose up -d --build
```

The first build will take a few minutes.

### 5. Initialize the application

```bash
docker compose exec app php artisan key:generate --force
docker compose exec app php artisan migrate --seed --force
docker compose exec app php artisan storage:link
```

This creates all tables and the initial admin account (`admin` / `password`). Change the password after first login.

### 6. Access the app

Open your browser at `http://<VPS-IP>` — done.

---

## Update / Redeploy

After making code changes:

```bash
git pull
docker compose up -d --build
docker compose exec app php artisan migrate --force   # if there are new migrations
```

---

## Useful Docker Commands

```bash
# Container status
docker compose ps

# Logs
docker compose logs app
docker compose logs nginx

# Enter container shell
docker compose exec app bash

# Run artisan commands
docker compose exec app php artisan <command>

# Restart all services
docker compose restart

# Stop
docker compose down

# Stop and delete all data (CAUTION)
docker compose down -v
```

---

## Volume Structure

| Volume        | Path in container                        | Contents                        |
|---------------|------------------------------------------|---------------------------------|
| `mysql_data`  | `/var/lib/mysql`                         | MySQL database data             |
| `storage_data`| `/var/www/html/storage/app/public`       | Uploaded item photos            |
| `app_public`  | `/var/www/html/public`                   | Frontend assets (shared w/ nginx)|

---

## Local Development

```bash
composer install
npm install

cp .env.example .env
# Edit .env: APP_ENV=local, APP_DEBUG=true, DB_HOST=127.0.0.1, DB_PASSWORD=<local>

php artisan key:generate
php artisan migrate --seed
php artisan storage:link

composer run dev   # starts php artisan serve + npm run dev concurrently
```
