# Troubleshooting Guide for Laravel Shared Hosting Deployment

This guide helps you resolve common issues when deploying Laravel to shared hosting.

## Table of Contents

1. [Configuration Issues](#configuration-issues)
2. [500 Internal Server Error](#500-internal-server-error)
3. [404 Not Found](#404-not-found)
4. [Blank White Page](#blank-white-page)
5. [Assets Not Loading](#assets-not-loading)
6. [Database Connection Issues](#database-connection-issues)
7. [Permission Errors](#permission-errors)
8. [Maintenance Mode](#maintenance-mode)

---

## Configuration Issues

### Problem: "Please stand by while configuration is in progress"

This is typically shown when Laravel cannot properly initialize.

#### Causes and Solutions:

**1. Missing .env file**
- **Check**: Navigate to your Laravel root directory via FTP
- **Solution**: 
  - Verify `.env` file exists in the Laravel root (NOT in public_html)
  - If missing, upload your `.env` file
  - Make sure the file is named exactly `.env` (not `.env.txt`)

**2. Missing or Invalid APP_KEY**
- **Check**: Open your `.env` file and look for `APP_KEY=`
- **Solution**:
  ```bash
  # On your local machine:
  php artisan key:generate
  
  # This will update your .env file with:
  APP_KEY=base64:randomgeneratedkeyhere...
  ```
  - Re-upload the `.env` file to your server

**3. Missing vendor/ directory**
- **Check**: Verify `vendor/` folder exists in Laravel root via FTP
- **Solution**:
  - On local machine: `composer install --optimize-autoloader --no-dev`
  - Upload the entire `vendor/` directory via FTP
  - This can take 10-30 minutes depending on connection speed
  - **Do NOT** interrupt the upload

**4. Incorrect paths in index.php**
- **Check**: Open `public_html/index.php` in a text editor
- **Solution**: Verify these paths point to correct locations:
  ```php
  // Example for Laravel in 'laravel' folder:
  require __DIR__.'/../laravel/vendor/autoload.php';
  $app = require_once __DIR__.'/../laravel/bootstrap/app.php';
  
  // Example for Laravel in parent folder:
  require __DIR__.'/../vendor/autoload.php';
  $app = require_once __DIR__.'/../bootstrap/app.php';
  ```
  - Use the provided `index.shared-hosting.php` as a template

**5. Cached configuration conflicts**
- **Check**: Look for files in `bootstrap/cache/`
- **Solution**:
  - Delete these files via FTP:
    - `bootstrap/cache/config.php`
    - `bootstrap/cache/routes-v7.php`
    - `bootstrap/cache/packages.php`
    - `bootstrap/cache/services.php`
  - Keep `.gitignore` file
  - Visit your site again

**6. Storage directory permissions**
- **Check**: Right-click `storage/` in FileZilla → File permissions
- **Solution**: Set permissions:
  - `storage/` → 755 or 775
  - `storage/framework/` → 755 or 775
  - `storage/logs/` → 755 or 775
  - `bootstrap/cache/` → 755 or 775
  - Apply to subdirectories

---

## 500 Internal Server Error

### General Approach

1. **Enable Debug Mode (Temporarily)**
   ```env
   # In .env file:
   APP_DEBUG=true
   ```
   - Visit your site to see detailed error
   - **Important**: Set back to `false` after fixing

2. **Check Error Logs**
   - Laravel log: `storage/logs/laravel.log` (download via FTP)
   - Server error log: Usually in cPanel or `error_log` in root
   - Look for the most recent error messages

### Common Causes:

**1. .htaccess Issues**
- **Check**: Verify `.htaccess` exists in `public_html/`
- **Solution**:
  - Ensure it's uploaded from Laravel's `public/.htaccess`
  - Try renaming to test: `mv .htaccess .htaccess.bak`
  - If site works, there's an .htaccess syntax error
  - Check server's Apache version and mod_rewrite availability

**2. PHP Version Incompatibility**
- **Check**: Laravel 11+ requires PHP 8.2+
- **Solution**:
  - Log into cPanel/Plesk
  - Navigate to "Select PHP Version" or similar
  - Change to PHP 8.2 or higher
  - Enable required extensions (see below)

**3. Missing PHP Extensions**
- **Required extensions**:
  - BCMath
  - Ctype
  - cURL
  - DOM
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PCRE
  - PDO
  - Tokenizer
  - XML
- **Solution**: Enable in cPanel → Select PHP Version → Extensions

**4. File Permission Issues**
- **Check**: Files should be 644, directories 755
- **Solution**:
  ```bash
  # Via SSH if available:
  find . -type f -exec chmod 644 {} \;
  find . -type d -exec chmod 755 {} \;
  chmod -R 755 storage bootstrap/cache
  ```

**5. Memory Limit Too Low**
- **Solution**: Add to `.htaccess` in public_html:
  ```apache
  php_value memory_limit 256M
  php_value upload_max_filesize 64M
  php_value post_max_size 64M
  php_value max_execution_time 300
  ```

---

## 404 Not Found

### Problem: All pages except homepage return 404

**Cause**: URL rewriting (mod_rewrite) not working

**Solutions**:

1. **Verify .htaccess uploaded**
   - Check `public_html/.htaccess` exists
   - Ensure it wasn't renamed during upload

2. **Check mod_rewrite enabled**
   - Contact hosting support to confirm mod_rewrite is enabled
   - Some hosts require you to enable it in cPanel

3. **Try alternative .htaccess** rules:
   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteBase /
       
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteRule ^(.*)$ index.php/$1 [L]
   </IfModule>
   ```

4. **Clear route cache**:
   ```bash
   # Via SSH:
   php artisan route:clear
   
   # Or delete via FTP:
   bootstrap/cache/routes-v7.php
   ```

---

## Blank White Page

**No error message, just a white screen**

### Solutions:

1. **Enable error reporting in index.php**:
   ```php
   // Add at the top of public_html/index.php:
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);
   ```

2. **Check PHP error log**:
   - Look in cPanel Error Log viewer
   - Or check `error_log` file in your directory

3. **Verify syntax errors**:
   - A PHP syntax error can cause blank page
   - Check recently modified files

4. **Memory exhausted**:
   - Increase memory limit (see 500 error section)

5. **Check file encoding**:
   - Files must be UTF-8 encoded
   - No BOM (Byte Order Mark)

---

## Assets Not Loading

### Problem: CSS, JavaScript, or images not loading (404 errors)

**Solutions**:

1. **Check APP_URL in .env**:
   ```env
   APP_URL=https://your-actual-domain.com
   ```
   - Must match your actual URL exactly
   - Include `https://` if using SSL
   - No trailing slash

2. **Verify asset files uploaded**:
   - Check `public_html/build/` exists (from `npm run build`)
   - Check `public_html/css/` and `public_html/js/` exist
   - Verify images in `public_html/images/`

3. **Build assets for production**:
   ```bash
   # On local machine:
   npm run build
   
   # Upload public/build/ directory
   ```

4. **Check .htaccess not blocking**:
   - Ensure .htaccess doesn't block static files
   - Should have: `RewriteCond %{REQUEST_FILENAME} !-f`

5. **Clear browser cache**:
   - Hard refresh: Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)
   - Or clear browser cache completely

6. **Check asset paths in Blade templates**:
   ```php
   <!-- Use asset() helper: -->
   <link rel="stylesheet" href="{{ asset('css/app.css') }}">
   <script src="{{ asset('js/app.js') }}"></script>
   
   <!-- For Vite: -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])
   ```

---

## Database Connection Issues

### Problem: "SQLSTATE[HY000] [2002] Connection refused" or similar

**Solutions**:

1. **Verify database credentials**:
   ```env
   # In .env file:
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

2. **Check database exists**:
   - Log into cPanel → phpMyAdmin
   - Verify database name matches .env exactly

3. **Verify user privileges**:
   - In cPanel → MySQL Databases
   - Ensure user has ALL PRIVILEGES on the database

4. **Try different DB_HOST**:
   ```env
   # Try these alternatives:
   DB_HOST=localhost
   DB_HOST=127.0.0.1
   DB_HOST=mysql.your-hosting.com
   ```
   - Contact hosting support for correct host

5. **Check MySQL is running**:
   - Contact hosting support
   - Some hosts have separate database servers

6. **Test connection**:
   ```php
   // Create test-db.php in public_html:
   <?php
   $host = 'localhost';
   $db = 'your_database';
   $user = 'your_user';
   $pass = 'your_password';
   
   try {
       $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
       echo "Connection successful!";
   } catch (PDOException $e) {
       echo "Connection failed: " . $e->getMessage();
   }
   ```
   - Visit: `https://yoursite.com/test-db.php`
   - **Delete this file after testing**

7. **Run migrations**:
   ```bash
   # Via SSH if available:
   php artisan migrate --force
   
   # Or import database via phpMyAdmin
   ```

---

## Permission Errors

### Problem: "The stream or file could not be opened" or "Permission denied"

**Solutions**:

1. **Fix storage permissions**:
   ```bash
   # Via SSH:
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache
   
   # Or via FileZilla:
   # Right-click → File permissions → 755
   # Check "Recurse into subdirectories"
   ```

2. **Verify ownership** (via SSH if available):
   ```bash
   # Make sure files are owned by web server user
   chown -R www-data:www-data storage bootstrap/cache
   # Or
   chown -R apache:apache storage bootstrap/cache
   # Or the user your host specifies
   ```

3. **Create missing directories**:
   ```bash
   mkdir -p storage/framework/cache/data
   mkdir -p storage/framework/sessions
   mkdir -p storage/framework/views
   mkdir -p storage/logs
   chmod -R 755 storage
   ```

4. **Try 775 permissions if 755 doesn't work**:
   - Some hosts require 775 for directories
   - Never use 777 (security risk)

---

## Maintenance Mode

### Problem: Site stuck in maintenance mode

**Check**:
```bash
# Via FTP, check if this file exists:
storage/framework/maintenance.php
```

**Solution**:
```bash
# Via SSH:
php artisan up

# Or via FTP:
# Delete: storage/framework/maintenance.php
```

---

## Getting More Help

### Enable Full Error Logging

Add to `public_html/index.php` (top of file, temporarily):
```php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

### Enable Laravel Debug Mode

In `.env`:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

**Remember to disable debug mode after fixing!**

### Check All Logs

1. **Laravel Application Log**:
   - `storage/logs/laravel.log`
   - Download via FTP and check last entries

2. **Server Error Log**:
   - cPanel → Errors
   - Or look for `error_log` file in directories

3. **Browser Console**:
   - F12 → Console tab
   - Check for JavaScript errors

### Contact Hosting Support

When contacting support, provide:
- Exact error message
- PHP version you're using
- What you've tried so far
- Contents of error logs
- Your hosting control panel details

---

## Quick Diagnostic Checklist

Use this to quickly check common issues:

- [ ] `.env` file exists in Laravel root
- [ ] `APP_KEY` is set in `.env`
- [ ] `vendor/` directory fully uploaded
- [ ] Paths in `public_html/index.php` are correct
- [ ] `.htaccess` exists in `public_html/`
- [ ] `storage/` permissions are 755 or 775
- [ ] `bootstrap/cache/` permissions are 755 or 775
- [ ] PHP version is 8.2 or higher
- [ ] Required PHP extensions enabled
- [ ] Database credentials correct
- [ ] Database exists and user has privileges
- [ ] No cached config files causing issues
- [ ] `APP_URL` matches your domain
- [ ] `APP_DEBUG=false` for production
- [ ] Error logs checked for details

---

## Still Having Issues?

1. Review `DEPLOYMENT.md` for complete deployment guide
2. Use `DEPLOYMENT_CHECKLIST.md` to verify all steps
3. Search Laravel documentation: https://laravel.com/docs
4. Check Laravel forums: https://laracasts.com/discuss
5. Stack Overflow with tag: [laravel] [shared-hosting]

Remember: Most issues are due to:
- Missing vendor/ folder
- Incorrect paths in index.php
- Wrong permissions on storage/
- Missing or incorrect .env file
