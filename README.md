ddev start (enkel voor db)
php artisan serve (voor webserver)

DB_CONNECTION="mariadb"
DB_HOST="localhost"
DB_PORT="8008"
DB_DATABASE="db"
DB_USERNAME="db"
DB_PASSWORD="db"

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

## Deployment to Shared Hosting

This project can be deployed to shared hosting environments (like EasyHosting) using FTP clients (like FileZilla).

### Quick Start for Deployment

1. **Prepare your application**:
   ```bash
   ./prepare-deployment.sh
   ```
   This script will install dependencies, optimize Laravel, and prepare your files for upload.

2. **Read the deployment guide**:
   - See [DEPLOYMENT.md](DEPLOYMENT.md) for complete step-by-step instructions
   - Use [DEPLOYMENT_CHECKLIST.md](DEPLOYMENT_CHECKLIST.md) to track your progress

3. **Common deployment issues**:
   - See [TROUBLESHOOTING.md](TROUBLESHOOTING.md) for solutions to common problems

### Key Files for Deployment

- **DEPLOYMENT.md**: Complete guide for deploying to shared hosting via FTP
- **DEPLOYMENT_CHECKLIST.md**: Step-by-step checklist to track deployment progress
- **TROUBLESHOOTING.md**: Solutions for common deployment issues
- **prepare-deployment.sh**: Script to prepare application for deployment
- **public/index.shared-hosting.php**: Modified index.php for shared hosting environments

### Important Notes

- The `vendor/` directory **must** be uploaded (this is critical and often forgotten)
- Your `.env` file must have `APP_KEY` set (run `php artisan key:generate`)
- Update paths in `public_html/index.php` after uploading
- Set correct permissions on `storage/` and `bootstrap/cache/` directories (755 or 775)
- For the "Please stand by while configuration is in progress" message, see TROUBLESHOOTING.md

## License

This project is open-source software.
