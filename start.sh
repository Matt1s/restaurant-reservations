#!/bin/bash

# Railway startup script for Laravel
echo "🚀 Starting Laravel application..."

# Ensure .env exists
if [ ! -f .env ]; then
    echo "📄 Copying .env.production to .env"
    cp .env.production .env
fi

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Wait for database to be ready and run migrations
echo "🗄️  Setting up database..."
echo "⏳ Waiting for database connection..."

# Wait for database to be available
until php artisan migrate:status > /dev/null 2>&1; do
    echo "⏳ Waiting for database to be ready..."
    sleep 2
done

echo "✅ Database is ready!"

# Run migrations
echo "📋 Running migrations..."
php artisan migrate --force

# Seed database if needed
echo "🌱 Seeding database..."
php artisan db:seed --force

# Clear and cache configuration
echo "⚡ Optimizing application..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the server
echo "🌟 Starting server on port ${PORT:-8080}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
