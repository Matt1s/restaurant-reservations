# Restaurant Reservations System

A modern Laravel-based restaurant reservation system built with Livewire and Tailwind CSS.

## Features

- 🍽️ Table reservation management
- 📅 Real-time availability checking
- 👥 User authentication and management
- 📱 Responsive design
- ⚡ Built with Laravel 12 and Livewire 3

## 🚀 Live Demo

**Deploy to Railway**: [![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/template/LxfO7u)

This application is optimized for [Railway](https://railway.app) deployment with zero configuration required.

### Quick Deploy Steps:
1. Click the Railway button above (or go to [railway.app](https://railway.app))
2. Connect your GitHub account
3. Select this repository
4. Railway automatically detects Laravel and deploys it

**Local demo**: `php artisan serve` after following the setup steps below.

## Technologies Used

- **Backend**: Laravel 12, PHP 8.2
- **Frontend**: Livewire 3, Tailwind CSS 4, Vite
- **Database**: SQLite (development) / PostgreSQL (Railway production)
- **Testing**: Pest PHP
- **Deployment**: Railway with automatic CI/CD

## Quick Start

### Local Development

1. **Clone the repository**
   ```bash
   git clone https://github.com/Matt1s/restaurant-reservations.git
   cd restaurant-reservations
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Build assets and serve**
   ```bash
   npm run dev
   php artisan serve
   ```

### Deployment

This project is optimized for Railway deployment. See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed instructions.

**One-click deploy**: Use the Railway button above or connect your GitHub repo at [railway.app](https://railway.app).

## Project Structure

- `app/Models/` - Eloquent models (User, Table, Reservation)
- `app/Http/Livewire/` - Livewire components
- `app/Services/` - Business logic services
- `resources/views/` - Blade templates
- `database/migrations/` - Database schema
- `tests/` - PHPUnit/Pest tests

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Testing

Run the test suite:
```bash
php artisan test
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
