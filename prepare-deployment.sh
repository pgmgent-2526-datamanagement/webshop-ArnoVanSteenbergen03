#!/bin/bash

# Laravel Production Deployment Preparation Script
# This script prepares your Laravel application for deployment to shared hosting

set -e

echo "========================================"
echo "Laravel Deployment Preparation Script"
echo "========================================"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

print_info() {
    echo -e "${NC}ℹ $1${NC}"
}

# Check if we're in a Laravel project
if [ ! -f "artisan" ]; then
    print_error "This doesn't appear to be a Laravel project directory."
    print_info "Please run this script from the root of your Laravel project."
    exit 1
fi

print_success "Laravel project detected"
echo ""

# Step 1: Check for .env file
echo "Step 1: Checking environment configuration..."
if [ ! -f ".env" ]; then
    print_warning ".env file not found"
    if [ -f ".env.example" ]; then
        print_info "Copying .env.example to .env"
        cp .env.example .env
        print_success ".env file created"
    else
        print_error ".env.example not found. Cannot create .env file."
        exit 1
    fi
else
    print_success ".env file exists"
fi

# Check if APP_KEY is set
if grep -q "APP_KEY=$" .env || grep -q "APP_KEY=\s*$" .env; then
    print_warning "APP_KEY not set in .env"
    print_info "Generating application key..."
    php artisan key:generate
    print_success "Application key generated"
else
    print_success "APP_KEY is already set"
fi

# Step 2: Check environment settings
echo ""
echo "Step 2: Verifying production settings..."

# Check APP_ENV
if grep -q "APP_ENV=production" .env; then
    print_success "APP_ENV is set to production"
else
    print_warning "APP_ENV is not set to production"
    print_info "Please set APP_ENV=production in your .env file"
fi

# Check APP_DEBUG
if grep -q "APP_DEBUG=false" .env; then
    print_success "APP_DEBUG is set to false"
else
    print_warning "APP_DEBUG is not set to false"
    print_info "Please set APP_DEBUG=false in your .env file for production"
fi

# Check APP_URL
if grep -q "APP_URL=http://localhost" .env; then
    print_warning "APP_URL is still set to localhost"
    print_info "Please update APP_URL to your production domain in .env"
else
    print_success "APP_URL appears to be configured"
fi

# Step 3: Install dependencies
echo ""
echo "Step 3: Installing dependencies..."

# Check if composer is available
if ! command -v composer &> /dev/null; then
    print_error "Composer not found. Please install Composer first."
    exit 1
fi

print_info "Installing PHP dependencies (production mode)..."
composer install --optimize-autoloader --no-dev
print_success "PHP dependencies installed"

# Check if npm is available
if ! command -v npm &> /dev/null; then
    print_warning "npm not found. Skipping JavaScript dependencies."
else
    print_info "Installing JavaScript dependencies..."
    npm install
    print_success "JavaScript dependencies installed"
    
    print_info "Building production assets..."
    npm run build
    print_success "Production assets built"
fi

# Step 4: Optimize Laravel
echo ""
echo "Step 4: Optimizing Laravel for production..."

print_info "Caching configuration..."
php artisan config:cache
print_success "Configuration cached"

print_info "Caching routes..."
php artisan route:cache
print_success "Routes cached"

print_info "Caching views..."
php artisan view:cache
print_success "Views cached"

print_info "Optimizing autoloader..."
composer dump-autoload --optimize
print_success "Autoloader optimized"

# Step 5: Verify directory structure
echo ""
echo "Step 5: Verifying required directories..."

declare -a required_dirs=(
    "storage/app"
    "storage/app/public"
    "storage/framework"
    "storage/framework/cache"
    "storage/framework/cache/data"
    "storage/framework/sessions"
    "storage/framework/views"
    "storage/logs"
    "bootstrap/cache"
)

for dir in "${required_dirs[@]}"; do
    if [ ! -d "$dir" ]; then
        print_warning "Directory $dir does not exist, creating..."
        mkdir -p "$dir"
        print_success "Created $dir"
    else
        print_success "$dir exists"
    fi
done

# Step 6: Check critical files
echo ""
echo "Step 6: Verifying critical files..."

declare -a critical_files=(
    ".env"
    "vendor/autoload.php"
    "public/index.php"
    "public/.htaccess"
    "artisan"
)

for file in "${critical_files[@]}"; do
    if [ -f "$file" ]; then
        print_success "$file exists"
    else
        print_error "$file is missing!"
    fi
done

# Step 7: Create deployment package info
echo ""
echo "Step 7: Creating deployment information..."

DEPLOYMENT_INFO="deployment-info.txt"
cat > $DEPLOYMENT_INFO << EOF
Laravel Deployment Package
Generated: $(date)

IMPORTANT FILES TO UPLOAD:
==========================

1. Core Laravel Files:
   - app/
   - bootstrap/
   - config/
   - database/
   - resources/
   - routes/
   - storage/
   - vendor/ (CRITICAL - entire folder)
   - .env (CRITICAL - configure first)
   - artisan
   - composer.json
   - composer.lock

2. Public Files (goes to public_html/):
   - Contents of public/ folder:
     - index.php (update paths!)
     - .htaccess
     - css/
     - js/
     - images/
     - build/
     - favicon.ico
     - robots.txt

3. Files NOT to Upload:
   - node_modules/
   - .git/
   - tests/
   - .env.example
   - composer.phar
   - package.json
   - package-lock.json
   - README.md (optional)

CRITICAL STEPS AFTER UPLOAD:
=============================

1. Update public_html/index.php paths:
   - Update vendor/autoload.php path
   - Update bootstrap/app.php path

2. Set permissions (via FTP):
   - storage/ and subdirectories: 755 or 775
   - bootstrap/cache/: 755 or 775

3. Verify .env settings:
   - APP_KEY is set
   - APP_ENV=production
   - APP_DEBUG=false
   - APP_URL matches your domain
   - Database credentials are correct

4. Create database and run migrations:
   - Create database via hosting control panel
   - Run: php artisan migrate --force
   - Or import database dump

5. Test the application:
   - Visit your URL
   - Check for errors
   - Review logs: storage/logs/laravel.log

For detailed instructions, see DEPLOYMENT.md
EOF

print_success "Deployment information created: $DEPLOYMENT_INFO"

# Final summary
echo ""
echo "========================================"
echo "Preparation Complete!"
echo "========================================"
echo ""
print_success "Your Laravel application is ready for deployment!"
echo ""
echo "Next steps:"
echo "  1. Review and update your .env file with production settings"
echo "  2. Read DEPLOYMENT.md for detailed deployment instructions"
echo "  3. Use DEPLOYMENT_CHECKLIST.md to track your deployment progress"
echo "  4. Upload files via FileZilla according to the guide"
echo "  5. Update index.php paths after upload"
echo "  6. Set correct permissions on storage directories"
echo "  7. Create database and run migrations"
echo "  8. Test your application"
echo ""
print_warning "Important reminders:"
echo "  - Make sure to upload the entire vendor/ directory"
echo "  - Verify .env file has APP_KEY set"
echo "  - Update paths in public_html/index.php"
echo "  - Set storage/ and bootstrap/cache/ to writable"
echo ""
print_info "Review $DEPLOYMENT_INFO for a quick reference"
echo ""
