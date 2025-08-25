# 🍽️ Restaurant Reservations System

A modern, restaurant reservation system built with Laravel 11, Livewire 3, and Tailwind CSS. Features a complete booking system with admin management and real-time availability checking.

## ✨ Features

### 🎯 **Core Functionality**
- **Table Reservations**: Multi-step booking process with date/time selection
- **Real-time Availability**: Dynamic table availability checking
- **User Authentication**: Secure login/registration system
- **Admin Dashboard**: Complete reservation management for restaurant staff
- **Responsive Design**: Mobile-first design that works on all devices

## 🚀 Quick Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 8.0 or higher

### Installation

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
   # Create a MySQL database named 'restaurant_reservations'
   # Update your .env file with your MySQL credentials:
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=restaurant_reservations
   # DB_USERNAME=your_username
   # DB_PASSWORD=your_password
   
   php artisan migrate --seed
   ```

5. **Build assets and start the server**
   ```bash
   npm run dev &
   php artisan serve
   ```

6. **Access the application**
   - Open your browser to `http://127.0.0.1:8000`

## 👥 User Accounts

The seeder creates two test accounts for you:

### 🔑 **Admin Account**
- **Email**: `admin@admin.com`
- **Password**: `password123`
- **Access**: Full admin dashboard with reservation management

### 👤 **Regular User Account**
- **Email**: `user@user.com`
- **Password**: `password123`
- **Access**: Make reservations and view personal bookings

## 🎛️ Application Functionality

### **For Customers**
- **Homepage**: View restaurant information and featured dishes
- **Quick Reservation**: Fast booking form on homepage (when logged in)
- **Full Reservation Flow**: Multi-step booking process with table selection
- **My Reservations**: View and manage personal bookings

### **For Administrators**
- **Admin Dashboard**: Overview of all reservations in the system
- **Reservation Management**: View, approve, or cancel any reservation

### **Reservation Process**
1. **Date & Time Selection**: Choose preferred dining date and time
2. **Party Size**: Select number of guests (1-8+ people)
3. **Table Selection**: Visual table layout with availability
4. **Special Requests**: Add dietary requirements or special occasions
5. **Confirmation**: Review and confirm reservation details

## 🧪 Testing

Run the comprehensive test suite:
```bash
php artisan test
```

The application includes **131 tests** covering:
- User authentication and authorization
- Reservation creation and validation
- Admin functionality
- Timezone handling
- Form validation
- Database operations

## 🏗️ Project Structure

```
app/
├── Http/Livewire/          # Reactive components
│   ├── ReservationForm.php # Multi-step booking form
│   ├── AdminDashboard.php  # Admin management interface
│   └── LanguageSwitcher.php # Language toggle component
├── Models/                 # Database models
│   ├── User.php           # User accounts and admin logic
│   ├── Reservation.php    # Booking records
│   └── Table.php          # Restaurant table management
└── Services/              # Business logic
    └── ReservationService.php # Booking validation and processing

resources/
├── views/                 # Blade templates

database/
├── migrations/            # Database schema
└── seeders/              # Sample data
```

## 🌟 Key Features Explained

### **Timezone Management**
- All times displayed in Prague timezone (`Europe/Prague`)
- Prevents past-date bookings
- Consistent time handling across the application

### **Admin vs User Experience**
- **Admin** (first user in database): Full system access, can manage all reservations
- **Regular Users**: Can only view and manage their own bookings
- Role-based navigation and feature access
