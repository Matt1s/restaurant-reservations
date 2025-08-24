#!/bin/bash
set -e

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

# Clear all cached config to ensure runtime environment is used
# Use || true to ignore errors from cache commands when SQLite files don't exist
echo "🧹 Clearing cached configuration..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

# Only run database operations if DATABASE_URL is set (indicating database is available)
if [ -n "$DATABASE_URL" ]; then
    echo "🗄️  Database detected, setting up..."
    echo "📊 Database connection: $DB_CONNECTION"
    echo "🔗 Database URL: ${DATABASE_URL:0:20}..." # Show first 20 chars only for security
    
    # Wait for database to be ready
    echo "⏳ Waiting for database connection..."
    max_attempts=30
    attempt=1
    
    while [ $attempt -le $max_attempts ]; do
        if php artisan migrate:status > /dev/null 2>&1; then
            echo "✅ Database is ready!"
            break
        fi
        
        echo "⏳ Attempt $attempt/$max_attempts - waiting for database..."
        sleep 2
        attempt=$((attempt + 1))
    done
    
    if [ $attempt -gt $max_attempts ]; then
        echo "❌ Database connection timeout. Starting without database setup."
    else
        # Run migrations
        echo "📋 Running migrations..."
        php artisan migrate --force
        
        # Seed database (only if tables are empty)
        echo "🌱 Checking if seeding is needed..."
        if [ "$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null || echo "0")" = "0" ]; then
            echo "🌱 Seeding database..."
            php artisan db:seed --force
        else
            echo "✅ Database already seeded"
        fi
    fi
else
    echo "⚠️  No DATABASE_URL found, skipping database setup"
fi

# Cache configuration with runtime environment (after database is ready)
echo "⚡ Optimizing application with runtime config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the server
echo "🌟 Starting server on port ${PORT:-8080}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
