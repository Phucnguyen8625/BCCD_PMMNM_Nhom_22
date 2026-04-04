<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Ho_Chi_Minh');

const APP_NAME = 'Comic Store - Module Nguyễn Huy Phúc';
const BASE_URL = 'http://localhost/BCCD_Lap_trinh_web_nang_cao_Nhom_2/phuc_modules';

const DB_HOST = '127.0.0.1';
const DB_NAME = 'comic_store';
const DB_USER = 'root';
const DB_PASS = '';
const DB_CHARSET = 'utf8mb4';

const VNPAY_TMN_CODE = 'YOUR_TMN_CODE';
const VNPAY_HASH_SECRET = 'YOUR_HASH_SECRET';
const VNPAY_PAY_URL = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
const VNPAY_QUERY_URL = 'https://sandbox.vnpayment.vn/merchant_webapi/api/transaction';
const VNPAY_RETURN_URL = BASE_URL . '/checkout/vnpay_return.php';
const VNPAY_IPN_URL = BASE_URL . '/checkout/vnpay_ipn.php';

require_once __DIR__ . '/database.php';
require_once dirname(__DIR__) . '/helpers/functions.php';
require_once dirname(__DIR__) . '/helpers/auth.php';
require_once dirname(__DIR__) . '/helpers/vnpay.php';
