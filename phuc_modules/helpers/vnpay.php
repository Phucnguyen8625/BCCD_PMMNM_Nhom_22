<?php

declare(strict_types=1);

function vnpayBuildSignedQuery(array $params): string
{
    ksort($params);

    $query = '';
    $hashdata = '';
    $i = 0;

    foreach ($params as $key => $value) {
        if ($value === null || $value === '') {
            continue;
        }

        if ($i === 1) {
            $hashdata .= '&' . urlencode((string) $key) . '=' . urlencode((string) $value);
        } else {
            $hashdata .= urlencode((string) $key) . '=' . urlencode((string) $value);
            $i = 1;
        }

        $query .= urlencode((string) $key) . '=' . urlencode((string) $value) . '&';
    }

    $secureHash = hash_hmac('sha512', $hashdata, trim(VNPAY_HASH_SECRET));

    return rtrim($query, '&') . '&vnp_SecureHash=' . $secureHash;
}

function vnpayVerifyResponse(array $input): bool
{
    if (!isset($input['vnp_SecureHash'])) {
        return false;
    }

    $receivedHash = (string) $input['vnp_SecureHash'];

    unset($input['vnp_SecureHash'], $input['vnp_SecureHashType']);

    ksort($input);

    $hashdata = '';
    $i = 0;

    foreach ($input as $key => $value) {
        if ($value === null || $value === '') {
            continue;
        }

        if ($i === 1) {
            $hashdata .= '&' . urlencode((string) $key) . '=' . urlencode((string) $value);
        } else {
            $hashdata .= urlencode((string) $key) . '=' . urlencode((string) $value);
            $i = 1;
        }
    }

    $calculatedHash = hash_hmac('sha512', $hashdata, trim(VNPAY_HASH_SECRET));

    return hash_equals($calculatedHash, $receivedHash);
}

function createVnpayPaymentUrl(array $order, array $payment, ?string $bankCode = null): string
{
    $clientIp = $_SERVER['HTTP_X_FORWARDED_FOR']
        ?? $_SERVER['REMOTE_ADDR']
        ?? '127.0.0.1';

    if (str_contains($clientIp, ',')) {
        $clientIp = trim(explode(',', $clientIp)[0]);
    }

    $txnRef = preg_replace('/[^A-Za-z0-9]/', '', (string) $payment['transaction_code']);

    if ($txnRef === null || $txnRef === '') {
        $txnRef = 'ORD' . (int) $order['id'] . date('YmdHis');
    }

    $orderInfo = 'Thanh toan don hang ' . (int) $order['id'];

    $params = [
        'vnp_Version'    => '2.1.0',
        'vnp_Command'    => 'pay',
        'vnp_TmnCode'    => trim(VNPAY_TMN_CODE),
        'vnp_Amount'     => (int) round(((float) $order['total_amount']) * 100),
        'vnp_CreateDate' => (string) $payment['vnp_create_date'],
        'vnp_CurrCode'   => 'VND',
        'vnp_IpAddr'     => $clientIp,
        'vnp_Locale'     => 'vn',
        'vnp_OrderInfo'  => $orderInfo,
        'vnp_OrderType'  => 'other',
        'vnp_ReturnUrl'  => trim(VNPAY_RETURN_URL),
        'vnp_TxnRef'     => $txnRef,
        'vnp_ExpireDate' => date('YmdHis', strtotime('+15 minutes')),
    ];

    if ($bankCode !== null && $bankCode !== '') {
        $params['vnp_BankCode'] = trim($bankCode);
    }

    return VNPAY_PAY_URL . '?' . vnpayBuildSignedQuery($params);
}

function queryVnpayTransaction(array $payment): array
{
    $requestId = uniqid('query_', true);
    $requestId = substr(str_replace('.', '', $requestId), 0, 32);

    $serverIp = $_SERVER['SERVER_ADDR'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

    $txnRef = preg_replace('/[^A-Za-z0-9]/', '', (string) $payment['transaction_code']);

    if ($txnRef === null || $txnRef === '') {
        $txnRef = 'ORD' . (int) $payment['order_id'] . date('YmdHis');
    }

    $payload = [
        'vnp_RequestId'       => $requestId,
        'vnp_Version'         => '2.1.0',
        'vnp_Command'         => 'querydr',
        'vnp_TmnCode'         => trim(VNPAY_TMN_CODE),
        'vnp_TxnRef'          => $txnRef,
        'vnp_OrderInfo'       => 'Truy van giao dich don hang ' . (int) $payment['order_id'],
        'vnp_TransactionDate' => (string) $payment['vnp_create_date'],
        'vnp_CreateDate'      => date('YmdHis'),
        'vnp_IpAddr'          => $serverIp,
    ];

    $hashData = implode('|', [
        $payload['vnp_RequestId'],
        $payload['vnp_Version'],
        $payload['vnp_Command'],
        $payload['vnp_TmnCode'],
        $payload['vnp_TxnRef'],
        $payload['vnp_TransactionDate'],
        $payload['vnp_CreateDate'],
        $payload['vnp_IpAddr'],
        $payload['vnp_OrderInfo'],
    ]);

    $payload['vnp_SecureHash'] = hash_hmac('sha512', $hashData, trim(VNPAY_HASH_SECRET));

    $ch = curl_init(VNPAY_QUERY_URL);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
        CURLOPT_TIMEOUT => 20,
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false) {
        return [
            'ok' => false,
            'message' => 'Không gọi được API truy vấn VNPAY: ' . $error,
            'data' => null,
            'raw' => null,
        ];
    }

    $decoded = json_decode($response, true);

    return [
        'ok' => $httpCode === 200 && is_array($decoded),
        'message' => $httpCode === 200 ? 'Truy vấn thành công.' : 'VNPAY phản hồi HTTP ' . $httpCode,
        'data' => $decoded,
        'raw' => $response,
    ];
}