#!/usr/bin/env bash
# setup.sh - automate creating a fresh Laravel project and copying scaffold files into it.
# Requirements: composer, npm, unzip
set -e

TARGET_DIR=backend

if [ -d "$TARGET_DIR" ]; then
  echo "Directory $TARGET_DIR already exists. Aborting to avoid overwrite."
  exit 1
fi

echo "Creating Laravel project in $TARGET_DIR..."
composer create-project laravel/laravel "$TARGET_DIR"

echo "Copying scaffold files into $TARGET_DIR..."
# Copy scaffold files (modules, themes, docker-compose, resources)
rsync -av --exclude='vendor' --exclude='node_modules' ./ "$TARGET_DIR"/

echo "Installing PHP deps..."
cd "$TARGET_DIR"
composer require spatie/laravel-permission laravel/sanctum --with-all-dependencies || true

echo "Copying .env example and generating key..."
cp .env.example .env || true
php artisan key:generate

echo "Installing JS deps and building assets..."
npm install || true
npm run build || true

echo "Running migrations..."
php artisan migrate || true

echo "Setup complete. Please edit $TARGET_DIR/.env to set DB credentials and other env vars."
