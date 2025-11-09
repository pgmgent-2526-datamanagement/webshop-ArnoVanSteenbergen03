# Laravel Shared Hosting Deployment Checklist

Use this checklist to ensure all steps are completed when deploying to shared hosting.

## Pre-Deployment (On Your Local Machine)

### Environment Setup
- [ ] Copy `.env.example` to `.env`
- [ ] Configure database settings in `.env`
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Set correct `APP_URL` (your subsite URL)
- [ ] Run `php artisan key:generate`
- [ ] Configure mail settings
- [ ] Add Mollie API key

### Dependencies
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `npm install`
- [ ] Run `npm run build`
- [ ] Verify `vendor/` folder exists
- [ ] Verify `node_modules/` folder exists
- [ ] Verify `public/build/` folder exists

### Optimization
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Run `composer dump-autoload --optimize`

### Testing Locally
- [ ] Test application locally: `php artisan serve`
- [ ] Verify all routes work
- [ ] Test database connection
- [ ] Test admin panel login
- [ ] Check for any errors in logs

## FTP Upload (Via FileZilla)

### Connection
- [ ] Connect to FTP server with credentials
- [ ] Verify connection successful
- [ ] Navigate to correct subsite directory

### File Structure Setup
- [ ] Decide on directory structure (Option A or B from DEPLOYMENT.md)
- [ ] Create necessary folders on server
- [ ] Note the paths for later configuration

### Upload Core Files
- [ ] Upload `app/` directory
- [ ] Upload `bootstrap/` directory
- [ ] Upload `config/` directory
- [ ] Upload `database/` directory
- [ ] Upload `resources/` directory
- [ ] Upload `routes/` directory
- [ ] Upload `storage/` directory (including subdirectories)
- [ ] Upload **`vendor/`** directory (CRITICAL - this often takes longest)
- [ ] Upload `.env` file (CRITICAL)
- [ ] Upload `artisan` file
- [ ] Upload `composer.json`
- [ ] Upload `composer.lock`

### Upload Public Files
- [ ] Upload contents of `public/` to `public_html/`
- [ ] Upload `index.php`
- [ ] Upload `.htaccess`
- [ ] Upload `favicon.ico`
- [ ] Upload `css/` directory
- [ ] Upload `js/` directory
- [ ] Upload `images/` directory
- [ ] Upload `build/` directory (from npm run build)
- [ ] Upload `robots.txt`

### Configuration Files
- [ ] Update `public_html/index.php` with correct paths
- [ ] Verify `.htaccess` is in `public_html/`
- [ ] Double-check `.env` is uploaded (not in public_html)
- [ ] Verify `APP_KEY` is set in `.env`

## Server Configuration

### File Permissions (via FileZilla)
- [ ] Set `storage/` to 775 or 755
- [ ] Set `storage/framework/` to 775 or 755
- [ ] Set `storage/framework/cache/` to 775 or 755
- [ ] Set `storage/framework/sessions/` to 775 or 755
- [ ] Set `storage/framework/views/` to 775 or 755
- [ ] Set `storage/logs/` to 775 or 755
- [ ] Set `storage/app/` to 775 or 755
- [ ] Set `bootstrap/cache/` to 775 or 755
- [ ] Set `.env` to 644

### Directory Creation
Ensure these directories exist in `storage/`:
- [ ] `storage/app/`
- [ ] `storage/app/public/`
- [ ] `storage/framework/`
- [ ] `storage/framework/cache/`
- [ ] `storage/framework/cache/data/`
- [ ] `storage/framework/sessions/`
- [ ] `storage/framework/views/`
- [ ] `storage/logs/`

## Database Setup (via Hosting Control Panel)

### Database Creation
- [ ] Log in to hosting control panel (cPanel/Plesk)
- [ ] Create new MySQL database
- [ ] Create database user
- [ ] Grant all privileges to user on database
- [ ] Note database name, username, password
- [ ] Update `.env` file with database credentials
- [ ] Re-upload `.env` if changed

### Migration (Choose one method)

#### Method A: Via SSH (if available)
- [ ] Connect via SSH
- [ ] Navigate to Laravel root directory
- [ ] Run `php artisan migrate --force`
- [ ] Run `php artisan db:seed --force` (if needed)

#### Method B: Import Database
- [ ] Run migrations locally with production database settings
- [ ] Export database from local using phpMyAdmin/mysqldump
- [ ] Import database to hosting via phpMyAdmin
- [ ] Verify tables created successfully

## Post-Deployment

### Clear Caches (via SSH if available)
- [ ] Run `php artisan config:clear`
- [ ] Run `php artisan cache:clear`
- [ ] Run `php artisan view:clear`
- [ ] Run `php artisan route:clear`

OR (if no SSH):
- [ ] Delete files in `bootstrap/cache/` (except .gitignore)
- [ ] Delete `config.php` if exists
- [ ] Delete `routes-v7.php` if exists

### Testing
- [ ] Visit subsite URL in browser
- [ ] Verify homepage loads without errors
- [ ] Test navigation links
- [ ] Test product pages
- [ ] Test admin panel login (`/admin`)
- [ ] Test adding items to cart
- [ ] Test checkout process (in test mode)
- [ ] Check if images/assets load correctly
- [ ] Test on mobile device/responsive

### Error Checking
- [ ] Check for PHP errors
- [ ] Review `storage/logs/laravel.log` for errors
- [ ] Check server error logs (in cPanel)
- [ ] Verify no 404 errors on assets
- [ ] Check browser console for JavaScript errors

### Security Verification
- [ ] Confirm `APP_DEBUG=false` in `.env`
- [ ] Confirm `APP_ENV=production` in `.env`
- [ ] Verify `.env` is NOT accessible via browser
- [ ] Test that direct access to `/storage` is blocked
- [ ] Verify HTTPS/SSL is working (if applicable)
- [ ] Check no sensitive files are publicly accessible

### Performance
- [ ] Test page load times
- [ ] Verify cached configs are working
- [ ] Check database queries are optimized
- [ ] Verify assets are loading from CDN (if configured)

## Troubleshooting

If you see "Please stand by while configuration is in progress":
- [ ] Verify `.env` file exists and has `APP_KEY`
- [ ] Verify `vendor/` folder is fully uploaded
- [ ] Check paths in `public_html/index.php`
- [ ] Verify storage permissions
- [ ] Check PHP version is 8.2+
- [ ] Review error logs

If you see 500 Internal Server Error:
- [ ] Enable debug: Set `APP_DEBUG=true` temporarily
- [ ] Check PHP error logs
- [ ] Check Laravel logs: `storage/logs/laravel.log`
- [ ] Verify `.htaccess` syntax
- [ ] Check required PHP extensions are enabled

If assets don't load:
- [ ] Verify `APP_URL` matches your domain
- [ ] Check `public/build/` folder uploaded
- [ ] Run `npm run build` and re-upload
- [ ] Clear browser cache
- [ ] Check `.htaccess` uploaded

## Final Verification

- [ ] All features working as expected
- [ ] No errors in logs
- [ ] Site is secure (HTTPS)
- [ ] Performance is acceptable
- [ ] Backups configured
- [ ] Monitoring set up (if applicable)

## Notes

Use this space to note any specific configurations or issues encountered:

```
Date deployed: _______________
Hosting provider: _______________
Database name: _______________
Any issues: _______________




```

---

## Quick Reference: Common File Paths

### If Laravel root is `/subsite/laravel/`:
```
Laravel app: /subsite/laravel/
Public files: /subsite/public_html/
.env location: /subsite/laravel/.env
vendor location: /subsite/laravel/vendor/
storage location: /subsite/laravel/storage/
```

### If Laravel root is `/subsite/`:
```
Laravel app: /subsite/
Public files: /subsite/public_html/
.env location: /subsite/.env
vendor location: /subsite/vendor/
storage location: /subsite/storage/
```
