# Restaurant Reservations System

A modern Laravel-based restaurant reservation system built with Livewire and Tailwind CSS.

## Features

- 🍽️ Table reservation management
- 📅 Real-time availability checking
- 👥 User authentication and management
- 📱 Responsive design
- ⚡ Built with Laravel 12 and Livewire 3

## Live Demo

Visit the live application at: [https://matt1s.github.io/restaurant-reservations](https://matt1s.github.io/restaurant-reservations)

## Technologies Used

- **Backend**: Laravel 12, PHP 8.2
- **Frontend**: Livewire 3, Tailwind CSS 4, Vite
- **Database**: SQLite (for simplicity and GitHub Pages compatibility)
- **Testing**: Pest PHP
- **Deployment**: GitHub Actions + GitHub Pages

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

This project includes automated GitHub Actions workflows for deployment to GitHub Pages. See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed deployment instructions.

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
