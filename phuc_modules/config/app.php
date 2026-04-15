<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Ho_Chi_Minh');

$localConfig = [];
$localConfigFile = __DIR__ . '/app.local.php';

if (file_exists($localConfigFile)) {
    $loaded = require $localConfigFile;

    if (is_array($loaded)) {
        $localConfig = $loaded;
    }
}

function appConfig(array $config, string $key, string $default = ''): string
{
    return array_key_exists($key, $config)
        ? (string) $config[$key]
        : $default;
}

define('APP_NAME', appConfig($localConfig, 'APP_NAME', 'Comic Store - Module Nguyễn Huy Phúc'));
define('BASE_URL', appConfig($localConfig, 'BASE_URL', 'http://localhost/BCCD_Lap_trinh_web_nang_cao_Nhom_2/phuc_modules'));

define('DB_HOST', appConfig($localConfig, 'DB_HOST', '127.0.0.1'));
define('DB_NAME', appConfig($localConfig, 'DB_NAME', 'ban_truyen_tranh'));
define('DB_USER', appConfig($localConfig, 'DB_USER', 'root'));
define('DB_PASS', appConfig($localConfig, 'DB_PASS', ''));
define('DB_CHARSET', appConfig($localConfig, 'DB_CHARSET', 'utf8mb4'));

define('VNPAY_TMN_CODE', appConfig($localConfig, 'VNPAY_TMN_CODE', 'BSL0YV7*'));
define('VNPAY_HASH_SECRET', appConfig($localConfig, 'VNPAY_HASH_SECRET', 'UW14FGKMX06C7DU7GFCZJT4SALHOHDQ*'));

define('VNPAY_PAY_URL', appConfig($localConfig, 'VNPAY_PAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'));
define('VNPAY_QUERY_URL', appConfig($localConfig, 'VNPAY_QUERY_URL', 'https://sandbox.vnpayment.vn/merchant_webapi/api/transaction'));

define('VNPAY_RETURN_URL', BASE_URL . '/checkout/vnpay_return.php');
define('VNPAY_IPN_URL', BASE_URL . '/checkout/vnpay_ipn.php');

require_once __DIR__ . '/database.php';
require_once dirname(__DIR__) . '/helpers/functions.php';
require_once dirname(__DIR__) . '/helpers/auth.php';
require_once dirname(__DIR__) . '/helpers/vnpay.php';