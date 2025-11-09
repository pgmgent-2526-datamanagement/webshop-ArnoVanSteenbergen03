<?php

/**
 * Laravel Application Entry Point for Shared Hosting
 * 
 * This is a modified version of the standard Laravel index.php file
 * that works with shared hosting environments where the public folder
 * is typically named 'public_html' and Laravel core files are outside
 * the web root.
 * 
 * INSTALLATION INSTRUCTIONS:
 * ==========================
 * 
 * 1. Upload this file to your public_html/ directory (your web root)
 * 
 * 2. Update the paths below based on your hosting structure:
 * 
 *    Option A - Laravel in separate folder:
 *    ├── laravel/              (Laravel core - one level up)
 *    │   ├── app/
 *    │   ├── vendor/
 *    │   ├── storage/
 *    │   └── bootstrap/
 *    └── public_html/          (this file goes here)
 *        └── index.php
 * 
 *    Use: __DIR__.'/../laravel/vendor/autoload.php'
 *    And: __DIR__.'/../laravel/bootstrap/app.php'
 * 
 *    Option B - Laravel in parent directory:
 *    ├── app/                  (Laravel core - one level up)
 *    ├── vendor/
 *    ├── storage/
 *    ├── bootstrap/
 *    └── public_html/          (this file goes here)
 *        └── index.php
 * 
 *    Use: __DIR__.'/../vendor/autoload.php'
 *    And: __DIR__.'/../bootstrap/app.php'
 * 
 * 3. Make sure the paths exist and are correct before testing
 * 
 * 4. Verify your .env file is in the Laravel root (NOT in public_html)
 * 
 * 5. Ensure storage/ and bootstrap/cache/ have write permissions (755 or 775)
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Path Configuration
|--------------------------------------------------------------------------
|
| Adjust these paths based on your server structure:
| - If Laravel is in a 'laravel' folder: use '/../laravel/'
| - If Laravel is in parent directory: use '/../'
|
*/

// OPTION A: Laravel in separate 'laravel' folder
// Uncomment these lines if your structure is: /laravel/ and /public_html/
$maintenancePath = __DIR__.'/../laravel/storage/framework/maintenance.php';
$autoloadPath = __DIR__.'/../laravel/vendor/autoload.php';
$bootstrapPath = __DIR__.'/../laravel/bootstrap/app.php';

// OPTION B: Laravel in parent directory
// Uncomment these lines if your structure has Laravel files in parent of public_html
// $maintenancePath = __DIR__.'/../storage/framework/maintenance.php';
// $autoloadPath = __DIR__.'/../vendor/autoload.php';
// $bootstrapPath = __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Maintenance Mode Check
|--------------------------------------------------------------------------
|
| Check if the application is in maintenance mode. If it is, the
| maintenance.php file will be loaded to show the maintenance page.
|
*/

if (file_exists($maintenancePath)) {
    require $maintenancePath;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

if (!file_exists($autoloadPath)) {
    die('Error: Composer autoloader not found at: ' . $autoloadPath . '<br>' .
        'Please make sure you have uploaded the vendor/ directory and updated the paths in this file.');
}

require $autoloadPath;

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

if (!file_exists($bootstrapPath)) {
    die('Error: Laravel bootstrap file not found at: ' . $bootstrapPath . '<br>' .
        'Please make sure you have uploaded the bootstrap/ directory and updated the paths in this file.');
}

/** @var Application $app */
$app = require_once $bootstrapPath;

$app->handleRequest(Request::capture());
