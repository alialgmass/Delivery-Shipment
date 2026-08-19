# Delivery & Shipment

A modular Laravel application for managing delivery and shipment operations, built on Laravel 13 with Inertia.js + Vue 3 for the frontend and Filament for the admin panel.

## Tech Stack

- **Backend:** PHP 8.3+, Laravel 13
- **Frontend:** Vue 3, Inertia.js v3, TypeScript, Tailwind CSS
- **Admin panel:** Filament 4 (with Spatie Media Library and Settings plugins)
- **Modules:** [hexters/laramodule](https://github.com/hexters/laramodule) for modular architecture
- **Auth:** Laravel Fortify, Sanctum
- **Other:** Laravel Reverb (websockets), Laravel Wayfinder, Spatie Data/Translatable/Media Library

## Modules

The application is organized into self-contained modules under `Modules/`:

- `Admin`
- `Auth`
- `Country`
- `Delivery`
- `Shipment`
- `User`

## Requirements

- PHP 8.3+
- Composer
- Node.js & npm (or pnpm)
- A database (MySQL/PostgreSQL/SQLite)

## Getting Started

1. Install PHP dependencies:
   ```bash
   composer install
   ```
2. Install JS dependencies:
   ```bash
   npm install
   ```
3. Copy the environment file and generate an app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Configure your database in `.env`, then run migrations:
   ```bash
   php artisan migrate
   ```
5. Start the development environment:
   ```bash
   composer run dev
   ```
   This runs the Laravel server, queue listener, and Vite dev server concurrently.

## Testing

```bash
php artisan test --compact
```

## Code Style

```bash
vendor/bin/pint --format agent
npm run lint
npm run format
```
