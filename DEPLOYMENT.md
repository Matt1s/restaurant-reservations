# Railway Deployment Guide

This Laravel application is optimized for deployment on [Railway](https://railway.app), a modern platform that automatically detects and deploys Laravel applications.

## 🚀 Quick Deploy to Railway

### Option 1: One-Click Deploy (Recommended)
1. Go to [railway.app](https://railway.app)
2. Sign up/login with your GitHub account
3. Click "New Project" → "Deploy from GitHub repo"
4. Select this repository
5. Railway will automatically:
   - Detect it's a Laravel app
   - Install PHP and Node.js dependencies
   - Build assets with Vite
   - Run migrations
   - Deploy your app

### Option 2: Railway CLI
```bash
# Install Railway CLI
npm install -g @railway/cli

# Login
railway login

# Deploy
railway deploy
```

## ⚙️ Railway Configuration

This repository includes Railway-optimized configuration:

- **`railway.json`**: Railway project configuration
- **`nixpacks.toml`**: Build and deployment instructions
- **`.env.production`**: Production environment template

## 🛠️ Environment Variables

Railway will automatically detect most settings, but you may want to configure these in the Railway dashboard:

### Required Variables (Railway usually sets these automatically):
```bash
APP_KEY=base64:your-generated-key  # Auto-generated if not set
APP_URL=https://your-app.railway.app  # Auto-set by Railway
PORT=8080  # Set by Railway
```

### Optional Variables:
```bash
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
DB_CONNECTION=sqlite  # or pgsql if using PostgreSQL
```

### Setting Variables in Railway:
1. Go to your Railway project dashboard
2. Navigate to "Variables" tab
3. Add variables as needed (most are set automatically)

## 🗄️ Database Setup

Railway provides several database options:

### Option 1: PostgreSQL (Recommended)
1. In Railway dashboard, click "New" → "Database" → "PostgreSQL"
2. Railway automatically sets `DATABASE_URL`
3. Update your migration commands if needed

### Option 2: SQLite (Default)
- Already configured in the repository
- Works out of the box
- Good for demos and small applications

## 🔄 Automatic Deployments

Once connected to Railway:
- ✅ **Every push to `main`** triggers automatic deployment
- ✅ **Pull requests** can be configured for preview deployments
- ✅ **GitHub Actions CI** runs tests before deployment

## 📊 Monitoring

Railway provides built-in monitoring:
- **Logs**: Real-time application logs
- **Metrics**: CPU, memory, and network usage
- **Deployments**: History and rollback options

## 🔧 Local Development

Test your app locally before deploying:

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Build assets
npm run build

# Setup database
touch database/database.sqlite
php artisan migrate --seed

# Serve locally
php artisan serve
```

## 🚨 Troubleshooting

### Build Issues
- Check the "Deployments" tab for build logs
- Ensure all dependencies are in `composer.json` and `package.json`

### Environment Issues
- Verify environment variables in Railway dashboard
- Check that `APP_KEY` is set (Railway should auto-generate this)

### Database Issues
- Ensure migrations run successfully
- Check database connection in Railway variables

## 📈 Performance Tips

1. **Enable caching**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Optimize Composer autoloader**:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

3. **Use Railway's CDN** for static assets

## 🎯 Next Steps

1. **Deploy to Railway** using the steps above
2. **Configure custom domain** (optional)
3. **Set up monitoring** and alerts
4. **Add staging environment** for testing

## 💡 Why Railway?

- ✅ **Zero configuration** Laravel deployment
- ✅ **Automatic HTTPS** and custom domains
- ✅ **Built-in database** options
- ✅ **GitHub integration** for automatic deployments
- ✅ **Fair pricing** with generous free tier
- ✅ **Modern infrastructure** with fast deployment times
