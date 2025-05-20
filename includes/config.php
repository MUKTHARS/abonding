<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '1234');
define('DB_NAME', 'abonding');

// Site configuration
define('SITE_NAME', 'Abonding');
define('BASE_URL', 'http://localhost/abonding-dynamic');

// File upload paths
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('SLIDER_UPLOAD_PATH', UPLOAD_PATH . 'sliders/');
define('PRODUCT_UPLOAD_PATH', UPLOAD_PATH . 'products/');
define('AWARD_UPLOAD_PATH', UPLOAD_PATH . 'awards/');
define('INDUSTRY_UPLOAD_PATH', UPLOAD_PATH . 'industries/');

// Start session
session_start();

// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>