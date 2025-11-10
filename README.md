# Webshop Project

A Laravel-based e-commerce webshop application with an admin panel powered by Filament.

## Features

- **Product Management**: Products with categories, tags, descriptions, pricing, and stock management
- **Order System**: Complete order processing with order items tracking
- **Admin Panel**: Filament-based admin interface for managing products, orders, and customers
- **Payment Integration**: Mollie payment gateway integration
- **Email Notifications**: Order confirmation emails for customers and admin notifications
- **User Authentication**: Laravel authentication system
- **Responsive Design**: Tailwind CSS styling

## Tech Stack

- **Framework**: Laravel 12
- **PHP**: 8.2+
- **Database**: MariaDB
- **Admin Panel**: Filament 4.0
- **Payment**: Mollie API
- **Frontend**: Tailwind CSS, Vite
- **Development Environment**: DDEV

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Copy the environment file and configure your database:
   ```bash
   cp .env.example .env
   ```

4. Set up the database (see configuration at the top of this file)

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Run migrations:
   ```bash
   php artisan migrate
   ```

7. (Optional) Seed the database:
   ```bash
   php artisan db:seed
   ```

## Running the Application

1. Start the database:
   ```bash
   ddev start
   ```

2. Start the web server:
   ```bash
   php artisan serve
   ```

3. Compile assets:
   ```bash
   npm run dev
   ```

4. Access the application at `http://localhost:8000`

## Project Structure

- `app/Models/`: Database models (Product, Order, Category, Tag, User)
- `app/Http/Controllers/`: Application controllers
- `app/Filament/Resources/`: Filament admin panel resources
- `app/Mail/`: Email notification classes
- `database/migrations/`: Database migration files
- `resources/views/`: Blade templates
- `routes/web.php`: Web routes

## License

This project is open-source software.
