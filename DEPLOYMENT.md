# Deployment Guide

This repository includes GitHub Actions workflows for automated deployment. There are two deployment options available:

## Option 1: Full Laravel Deployment (`deploy.yml`)

This workflow includes both testing and deployment phases:
- Runs all PHPUnit/Pest tests
- Builds the complete Laravel application
- Deploys to GitHub Pages with database and full functionality

### Features:
- ✅ Complete test suite execution
- ✅ Full Laravel application deployment
- ✅ Database migrations and seeding
- ✅ Production optimizations (caching, etc.)
- ✅ Asset compilation

## Option 2: Static Deployment (`static-deploy.yml`)

This is a simpler workflow that focuses only on deployment:
- Builds and deploys just the public assets
- Faster deployment time
- Better for static hosting scenarios

### Features:
- ✅ Quick deployment
- ✅ Asset compilation
- ✅ Basic Laravel setup
- ✅ Database setup

## Setup Instructions

1. **Enable GitHub Pages**:
   - Go to your repository Settings
   - Navigate to "Pages" in the left sidebar
   - Under "Source", select "GitHub Actions"

2. **Environment Variables** (if needed):
   - Go to repository Settings → Secrets and variables → Actions
   - Add any required environment variables

3. **Choose Your Workflow**:
   - Use `deploy.yml` for full functionality with testing
   - Use `static-deploy.yml` for faster, simpler deployment

4. **Trigger Deployment**:
   - Push to the `main` branch
   - Or manually trigger via Actions tab

## Configuration Files

- `.env.production`: Production environment configuration
- `public/.htaccess`: Web server configuration for proper routing

## Accessing Your Site

After successful deployment, your site will be available at:
```
https://[your-username].github.io/[repository-name]
```

For this repository:
```
https://matt1s.github.io/restaurant-reservations
```

## Troubleshooting

1. **Build Failures**: Check the Actions tab for detailed error logs
2. **Missing Assets**: Ensure `npm run build` completes successfully
3. **Database Issues**: Verify migration files are present and valid
4. **Environment Issues**: Check that `.env.production` has correct settings

## Local Testing

To test the production build locally:

```bash
# Copy production environment
cp .env.production .env

# Install dependencies
composer install --optimize-autoloader --no-dev
npm ci

# Build assets
npm run build

# Setup database
php artisan migrate:fresh --seed

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Serve
php artisan serve
```
