# CRM Scaffold (Laravel-style) — Starter Package

This is a lightweight scaffold to jump-start your CRM project using:
- PHP (Laravel-style structure, PSR-4 autoload)
- MySQL (intended)
- Tailwind CSS + Vite for frontend assets
- Module system (modules/ folder) with a sample `Customer` module
- Theme system (themes/) with three sample themes (company, shop, clinic)
- Asset manifest per module
- Docker Compose for development (mysql, redis, php-fpm placeholder, nginx placeholder, node for vite)

**Important**: This scaffold contains starter source files and poc service classes and migration files.
It is *not* a full Laravel installation. To convert into a working Laravel app, place files into a Laravel project or use this as a guide.

## Quick steps (how to use)
1. Unzip the package:
   ```
   unzip crm-scaffold.zip -d crm-project
   ```
2. Move contents into a Laravel project (recommended) or use as reference.
3. Install PHP dependencies in your Laravel project:
   ```
   composer install
   ```
4. Install JS deps and build assets:
   ```
   npm install
   npm run dev   # or npm run build
   ```
5. Configure `.env`, database, Redis, and run migrations.

Files included:
- composer.json (PSR-4 autoload set for Modules\)
- docker-compose.yml (dev placeholders)
- package.json + tailwind + vite config
- modules/Customer (provider, routes, migration, views, asset-manifest)
- themes/* (metadata and required_features)
- services stubs: ModuleManager.php, ThemeActivator.php, AssetManager.php
- migrations for modules, features, themes, feature_flags, assets

If you want, place these files into a fresh Laravel project root and run `composer dump-autoload` to register the PSR-4 mapping.
