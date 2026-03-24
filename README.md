# Ambil Yuk

Aplikasi web sederhana untuk admin memposting barang bekas, dan teman-teman bisa antre untuk mengambilnya.

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

## Deploy ke VPS (Fresh Server)

### 1. Install Docker

```bash
curl -fsSL https://get.docker.com | sh
sudo usermod -aG docker $USER && newgrp docker
```

### 2. Clone repository

```bash
git clone <repo-url> /srv/ambilyuk
cd /srv/ambilyuk
```

### 3. Siapkan file environment

```bash
cp .env.example .env
nano .env
```

Sesuaikan nilai berikut:

```env
APP_URL=http://<IP-atau-domain-VPS>
DB_PASSWORD=ganti_dengan_password_kuat
```

> `DB_PASSWORD` dipakai oleh Laravel dan MySQL container — pastikan nilainya sama.

### 4. Build dan jalankan container

```bash
docker compose up -d --build
```

Proses build pertama membutuhkan beberapa menit.

### 5. Inisialisasi aplikasi

```bash
docker compose exec app php artisan key:generate --force
docker compose exec app php artisan migrate --seed --force
docker compose exec app php artisan storage:link
```

Ini membuat semua tabel dan akun admin awal (`admin` / `password`). Ganti password setelah login pertama.

### 6. Akses aplikasi

Buka browser ke `http://<IP-VPS>` — selesai.

---

## Update / Redeploy

Setelah melakukan perubahan kode:

```bash
git pull
docker compose up -d --build
docker compose exec app php artisan migrate --force   # jika ada migrasi baru
```

---

## Perintah Docker Berguna

```bash
# Status container
docker compose ps

# Log
docker compose logs app
docker compose logs nginx

# Masuk ke container
docker compose exec app bash

# Jalankan artisan command
docker compose exec app php artisan <command>

# Restart semua service
docker compose restart

# Hentikan
docker compose down

# Hentikan dan hapus semua data (HATI-HATI)
docker compose down -v
```

---

## Struktur Volume

| Volume        | Path di container                        | Isi                          |
|---------------|------------------------------------------|------------------------------|
| `mysql_data`  | `/var/lib/mysql`                         | Data database MySQL          |
| `storage_data`| `/var/www/html/storage/app/public`       | Foto barang yang diupload    |
| `app_public`  | `/var/www/html/public`                   | Asset frontend (shared nginx)|

---

## Development Lokal

```bash
composer install
npm install

cp .env.example .env
# Edit .env: APP_ENV=local, APP_DEBUG=true, DB_HOST=127.0.0.1, DB_PASSWORD=<lokal>

php artisan key:generate
php artisan migrate --seed
php artisan storage:link

composer run dev   # starts php artisan serve + npm run dev concurrently
```
