<?php
// Global Configuration File

// 1. Detection of BASE_URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];
$baseDir = explode('/', trim($uri, '/'))[0]; 

define('BASE_URL', $protocol . '://' . $host . '/' . $baseDir);

// 2. VNPay Configuration (Sandbox)
define('VNPAY_TMN_CODE', 'BSL0YV7Z'); 
define('VNPAY_HASH_SECRET', 'UW14FGKMX06C7DU7GFCZJT4SALHOHDQ1');
define('VNPAY_PAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
define('VNPAY_RETURN_URL', BASE_URL . '/index.php?controller=checkout&action=vnpay_return');

// 3. Application Constants
define('APP_NAME', 'MangaStore - Shop Truyện Tranh');

// 4. Session Setup
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 5. Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
