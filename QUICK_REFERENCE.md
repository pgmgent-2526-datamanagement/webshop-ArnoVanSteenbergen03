# Quick Reference: Laravel Shared Hosting Deployment

## Before Upload (Local Machine)

```bash
# 1. Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# 2. Configure .env
cp .env.example .env
# Edit: APP_ENV=production, APP_DEBUG=false, set APP_URL
php artisan key:generate

# 3. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Use the deployment script
./prepare-deployment.sh
```

## Critical Files to Upload

### ✅ Must Upload to Laravel Root (outside public_html):
- [ ] `vendor/` folder (entire directory - CRITICAL!)
- [ ] `.env` file (with APP_KEY set)
- [ ] `app/` folder
- [ ] `bootstrap/` folder  
- [ ] `config/` folder
- [ ] `database/` folder
- [ ] `resources/` folder
- [ ] `routes/` folder
- [ ] `storage/` folder (with subdirectories)
- [ ] `artisan` file
- [ ] `composer.json` and `composer.lock`

### ✅ Upload to public_html (web root):
- [ ] Contents of `public/` folder:
  - `index.php` (update paths!)
  - `.htaccess`
  - `build/` folder
  - `css/`, `js/`, `images/` folders
  - `favicon.ico`, `robots.txt`

### ❌ Do NOT Upload:
- `node_modules/`
- `.git/`
- `tests/`
- `.env.example`
- `package.json`, `package-lock.json`

## After Upload - Critical Steps

### 1. Update index.php Paths
Edit `public_html/index.php`:

```php
// If Laravel is in /laravel/ folder:
$maintenance = __DIR__.'/../laravel/storage/framework/maintenance.php';
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

// OR if Laravel is in parent folder:
$maintenance = __DIR__.'/../storage/framework/maintenance.php';
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

### 2. Set Permissions (via FTP)
Right-click → File Permissions:
- `storage/` and all subdirectories: **755** or **775**
- `bootstrap/cache/`: **755** or **775**
- `.env`: **644**

### 3. Verify .env Settings
```env
APP_KEY=base64:XXXXX... (must be set!)
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
DB_HOST=localhost
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_pass
```

### 4. Database Setup
- Create database in cPanel
- Update .env with credentials
- Run migrations via SSH or import database

## Troubleshooting One-Liners

| Problem | Quick Fix |
|---------|-----------|
| "Please stand by..." | Check .env exists, APP_KEY set, vendor/ uploaded |
| 500 Error | Check error logs, verify PHP 8.2+, check .htaccess |
| 404 on all pages | Verify .htaccess uploaded, mod_rewrite enabled |
| Blank page | Enable errors in index.php, check PHP error log |
| Assets not loading | Check APP_URL in .env, verify build/ uploaded |
| Database error | Verify credentials, check DB exists, test connection |
| Permission denied | Set storage/ and bootstrap/cache/ to 755/775 |

## File Structure Example

```
Server Structure:
/home/yourusername/
├── laravel/              ← Laravel core files here
│   ├── app/
│   ├── vendor/           ← MUST upload this!
│   ├── storage/          ← Set permissions 755/775
│   ├── bootstrap/
│   │   └── cache/        ← Set permissions 755/775
│   ├── .env              ← MUST have APP_KEY
│   └── artisan
└── public_html/          ← Public web root
    ├── index.php         ← Update paths!
    ├── .htaccess
    ├── build/
    ├── css/
    └── js/
```

## Common Mistakes to Avoid

1. ❌ Forgetting to upload `vendor/` folder
2. ❌ Not setting APP_KEY in .env
3. ❌ Wrong paths in index.php
4. ❌ No write permissions on storage/
5. ❌ Uploading .env to public_html
6. ❌ Not uploading .htaccess
7. ❌ Leaving APP_DEBUG=true in production
8. ❌ Forgetting to run npm run build

## Emergency Commands (if you have SSH)

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Fix permissions
chmod -R 755 storage bootstrap/cache

# Regenerate key
php artisan key:generate

# Run migrations
php artisan migrate --force
```

## Need Help?

1. Check [TROUBLESHOOTING.md](TROUBLESHOOTING.md) for detailed solutions
2. Review [DEPLOYMENT.md](DEPLOYMENT.md) for complete guide
3. Enable APP_DEBUG=true temporarily to see errors
4. Check storage/logs/laravel.log
5. Check server error logs in cPanel

## Success Checklist

After deployment, verify:
- [ ] Homepage loads without errors
- [ ] Navigation works (no 404s)
- [ ] Database connection works
- [ ] Admin panel accessible (/admin)
- [ ] Assets (CSS/JS) loading
- [ ] Images displaying
- [ ] No errors in browser console
- [ ] No errors in Laravel logs
- [ ] HTTPS/SSL working (if applicable)
- [ ] APP_DEBUG=false in production

---

**Remember**: The most common issue is forgetting to upload the `vendor/` directory or not setting the APP_KEY in .env!
