# Project: Project: Ambil Yuk — Barang Lelang / Give-away App

## Overview
A simple web application for the admin (owner) to post second-hand items for friends to claim/book.
Friends can register, browse items, and queue up to book an item. Admin manages the queue and confirms or rejects bookings.

## Tech Stack
- **Backend:** Laravel (latest stable)
- **Frontend:** Laravel Blade + Tailwind CSS (mobile-first)
- **Database:** MySQL
- **Storage:** Local disk (public storage, Laravel's default)
- **Realtime:** None — standard page refresh
- **Deployment:** Docker Compose (app/php-fpm + nginx + mysql)

## Users & Roles
- **Admin:** Single user, hardcoded or seeded. Manages items and bookings.
- **User (Friend):** Registers with username, password, nickname, phone number. Can browse and book items.

## Data Models

### User
- id, username (unique), password, nickname, phone_number, role (admin|user), timestamps

### Item
- id, title, description, photo (local path), stock (int), status (active|closed|done), timestamps

### Booking
- id, item_id, user_id, status (pending|confirmed|rejected), queue_position (int), timestamps

## Business Rules
1. Each user can only have ONE active booking per item.
2. Queue position is assigned in order of booking time.
3. When admin confirms a booking: stock decreases by 1.
4. When admin rejects a booking: queue positions below shift up.
5. When stock reaches 0 OR admin marks item as done: item status → closed/done.
6. User can see their own queue position on each item.

## UI Guidelines
- Tailwind CSS, mobile-first, clean and modern
- Responsive: works well on phone browser
- No JS framework — Blade + Alpine.js (for small interactions like confirm dialogs) is fine
- Keep it simple: no fancy animations, just clean layout, good spacing, readable typography

## Admin Credentials (seeded)
- Username: admin
- Password: password (changeable later)

## Out of Scope (for MVP)
- Real-time push updates (WebSocket)
- Email/SMS notifications
- Payment integration
- Chat or negotiation features inside the app

## Implementation Notes (Decisions Made)

### Auth
- Laravel auth uses `username` field instead of `email`. Do NOT add `getAuthIdentifierName()` override to the User model — it breaks session-based auth by making `User::find('username_string')` fail. `Auth::attempt(['username' => ...])` works natively by matching credential array keys.
- Password cast: User model has `'password' => 'hashed'` cast. Never wrap the value in `bcrypt()` manually in seeders — the cast handles hashing automatically.

### Session
- `SESSION_DRIVER=file` is used (not database) to avoid MySQL connection dependency for session reads.

### Docker Setup
- PHP 8.4-fpm (not 8.3) — composer.lock has Symfony 8.x packages that require PHP ≥8.4.
- Three named volumes: `mysql_data`, `storage_data`, `app_public`.
- `app_public` is shared between `app` (rw) and `nginx` (ro) so nginx can serve static files without going through PHP.
- `.env` is mounted as a volume (not baked into image) — secrets stay out of the image.
- `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` are overridden in `docker-compose.yml` environment to point to the `mysql` service, so the local `.env` can keep `DB_HOST=127.0.0.1` for local dev without conflict.
- `public/storage` symlink must be in `.dockerignore` — Docker on Windows cannot tar symlinks.
- Full deploy steps: see README.md.

