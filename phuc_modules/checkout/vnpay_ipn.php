<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/app.php';

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'RspCode' => '99',
    'Message' => 'Localhost khong nhan duoc IPN tu VNPAY',
], JSON_UNESCAPED_UNICODE);