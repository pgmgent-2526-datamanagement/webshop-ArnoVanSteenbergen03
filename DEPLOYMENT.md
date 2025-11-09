# Laravel Deployment Guide for Shared Hosting (EasyHosting via FileZilla)

This guide will help you deploy your Laravel webshop application to shared hosting using FileZilla as your FTP client.

## Prerequisites

Before deploying, ensure you have:
- FileZilla FTP client installed
- Your EasyHosting FTP credentials (host, username, password)
- PHP 8.2+ enabled on your hosting
- Access to your hosting control panel

## Pre-Deployment Preparation

### 1. Install Dependencies Locally

Before uploading, you must install all dependencies on your local machine:

```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node.js dependencies
npm install

# Build frontend assets
npm run build
```

### 2. Configure Environment File

Create your production `.env` file:

```bash
cp .env.example .env
```

Edit `.env` with your production settings:

```env
APP_NAME="Your Webshop"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://your-subsite.domain.com

# Database settings (from your hosting provider)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Session and Cache
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=database

# Mail settings (configure based on your hosting)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Mollie Payment Gateway
MOLLIE_KEY=your_mollie_api_key
```

### 3. Generate Application Key

**IMPORTANT:** Generate the application key before uploading:

```bash
php artisan key:generate
```

This will update your `.env` file with a secure `APP_KEY`.

### 4. Optimize for Production

```bash
# Clear and cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

## Deployment Steps

### Step 1: Connect via FileZilla

1. Open FileZilla
2. Enter your FTP credentials:
   - Host: `ftp.your-hosting.com`
   - Username: `your-ftp-username`
   - Password: `your-ftp-password`
   - Port: `21` (or `22` for SFTP)
3. Click "Quickconnect"

### Step 2: Understand Directory Structure

Most shared hosting has a structure like:
```
/home/yourusername/
├── public_html/          # Main website (www folder)
├── subsite/              # Your subsite folder
│   └── public_html/      # Public folder for subsite
└── private/              # Private files (not web-accessible)
```

**CRITICAL:** The Laravel `public` folder content should go in your subsite's `public_html` folder, and everything else should go OUTSIDE the public directory.

### Step 3: Upload Laravel Files

#### Option A: Recommended Structure

Upload files in this structure:
```
/subsite/
├── laravel/              # Create this folder for Laravel core
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/           # IMPORTANT: Upload this
│   ├── .env              # IMPORTANT: Upload this
│   ├── artisan
│   └── composer.json
└── public_html/          # Your subsite's public folder
    ├── index.php         # Modified (see below)
    ├── .htaccess         # From Laravel public folder
    ├── css/
    ├── js/
    ├── images/
    └── favicon.ico
```

#### Option B: Alternative Structure

```
/subsite/
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/               # IMPORTANT: Upload this
├── .env                  # IMPORTANT: Upload this
├── artisan
├── composer.json
└── public_html/          # Only contents of public folder
    ├── index.php         # Modified (see below)
    ├── .htaccess
    └── assets...
```

### Step 4: Update index.php

**CRITICAL STEP:** Edit `public_html/index.php` to point to the correct Laravel paths.

If using Option A structure, update these lines:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../laravel/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

$app->handleRequest(Request::capture());
```

If using Option B structure, update these lines:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
```

### Step 5: Set File Permissions

Using FileZilla, set the following permissions (right-click → File permissions):

```
storage/                  → 775 (or 755)
storage/framework/        → 775 (or 755)
storage/logs/             → 775 (or 755)
bootstrap/cache/          → 775 (or 755)
```

Make sure all subdirectories within `storage/` have write permissions.

### Step 6: Create Storage Subdirectories

Ensure these directories exist in `storage/`:
```
storage/
├── app/
│   ├── public/
├── framework/
│   ├── cache/
│   │   └── data/
│   ├── sessions/
│   └── views/
└── logs/
```

You may need to create these manually via FileZilla if they don't exist.

### Step 7: Set Up Database

1. Log in to your hosting control panel (cPanel, Plesk, etc.)
2. Create a MySQL database
3. Create a database user with full privileges
4. Note the database name, username, and password
5. Update your `.env` file with these credentials
6. Run migrations (see below)

### Step 8: Run Migrations (via SSH or Remote Command)

If your host provides SSH access:

```bash
cd /path/to/your/laravel
php artisan migrate --force
php artisan db:seed --force
```

If no SSH access, you can:
1. Run migrations locally with the same database
2. Export the database and import it to your hosting
3. Or use a web-based migration tool (create one if needed)

### Step 9: Clear Caches After Upload

If you have SSH access:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Step 10: Test Your Application

1. Visit your subsite URL: `https://your-subsite.domain.com`
2. Check that the homepage loads
3. Test routing and navigation
4. Verify database connections
5. Test admin panel access
6. Check error logs if issues occur

## Troubleshooting Common Issues

### Issue: "Please stand by while configuration is in progress"

**Causes and Solutions:**

1. **Missing .env file**
   - Solution: Upload your `.env` file to the root Laravel directory
   - Make sure it has correct permissions (644)

2. **Missing APP_KEY**
   - Solution: Run `php artisan key:generate` locally, then re-upload `.env`
   - Or manually add a 32-character key: `APP_KEY=base64:YOUR_32_CHAR_KEY_HERE`

3. **Missing vendor folder**
   - Solution: Upload the entire `vendor/` directory from your local machine
   - This is usually the #1 cause of deployment issues

4. **Wrong paths in index.php**
   - Solution: Verify the paths in `public_html/index.php` point to correct locations
   - Check both `vendor/autoload.php` and `bootstrap/app.php` paths

5. **Storage permissions**
   - Solution: Set `storage/` and `bootstrap/cache/` to 775 or 755
   - Ensure web server can write to these directories

6. **PHP version mismatch**
   - Solution: Ensure hosting has PHP 8.2+ enabled
   - Check via cPanel or contact hosting support

7. **Cached configuration files**
   - Solution: Delete these files from `bootstrap/cache/`:
     - `config.php`
     - `routes-v7.php`
     - `packages.php`
     - `services.php`

8. **Incorrect APP_URL**
   - Solution: Set `APP_URL` in `.env` to your actual subsite URL
   - Example: `APP_URL=https://subsite.yourdomain.com`

### Issue: 500 Internal Server Error

**Check:**
1. PHP error logs (usually in `error_log` file or cPanel)
2. Laravel logs in `storage/logs/laravel.log`
3. Enable debug temporarily: `APP_DEBUG=true` in `.env` (disable after fixing)

**Common Causes:**
- Syntax errors in `.htaccess`
- PHP extensions not enabled (check requirements)
- Permission issues on files/directories
- Missing PHP modules (mbstring, openssl, pdo, tokenizer, xml, ctype, json)

### Issue: Assets Not Loading (CSS/JS)

**Solutions:**
1. Check `APP_URL` is correct in `.env`
2. Run `npm run build` before uploading
3. Upload the entire `public/build/` directory
4. Verify `.htaccess` is uploaded and working
5. Clear browser cache

### Issue: Database Connection Failed

**Check:**
1. Database credentials in `.env` are correct
2. Database exists on the hosting server
3. Database user has correct privileges
4. Database host is correct (usually `localhost` for shared hosting)
5. Try using IP address instead of `localhost` if connection fails

## Security Checklist

Before going live, ensure:

- [ ] `APP_DEBUG=false` in `.env`
- [ ] `APP_ENV=production` in `.env`
- [ ] Strong `APP_KEY` is generated
- [ ] Database credentials are secure
- [ ] `.env` file is NOT in public directory
- [ ] Storage directories have correct permissions (not 777)
- [ ] Remove any development/test routes
- [ ] Enable HTTPS/SSL on your domain
- [ ] Set up regular backups

## Performance Optimization

For better performance:

```bash
# Before uploading
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev

# Build assets for production
npm run build
```

## Quick Deployment Checklist

- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `npm install && npm run build`
- [ ] Create and configure `.env` file
- [ ] Run `php artisan key:generate`
- [ ] Upload all files via FileZilla to correct locations
- [ ] Update `index.php` with correct paths
- [ ] Set storage and cache folder permissions to 775
- [ ] Create storage subdirectories if missing
- [ ] Upload `.htaccess` to public_html
- [ ] Test database connection
- [ ] Run migrations (via SSH or import database)
- [ ] Visit site and verify it works
- [ ] Check logs for errors

## Need More Help?

If you continue experiencing issues:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check server error logs (usually in cPanel)
3. Enable debug mode temporarily: `APP_DEBUG=true`
4. Contact your hosting provider's support
5. Review Laravel deployment documentation: https://laravel.com/docs/deployment

## Additional Resources

- [Laravel Deployment Documentation](https://laravel.com/docs/11.x/deployment)
- [FileZilla Documentation](https://wiki.filezilla-project.org/Documentation)
- Your hosting provider's knowledge base
