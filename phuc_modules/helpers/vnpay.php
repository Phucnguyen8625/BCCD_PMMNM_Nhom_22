<?php

declare(strict_types=1);

function vnpayBuildSignedQuery(array $params): string
{
    ksort($params);

    $hashData = [];
    foreach ($params as $key => $value) {
        $hashData[] = urlencode((string) $key) . '=' . urlencode((string) $value);
    }

    $query = http_build_query($params);
    $secureHash = hash_hmac('sha512', implode('&', $hashData), VNPAY_HASH_SECRET);

    return $query . '&vnp_SecureHash=' . $secureHash;
}

function vnpayVerifyResponse(array $input): bool
{
    if (!isset($input['vnp_SecureHash'])) {
        return false;
    }

    $receivedHash = $input['vnp_SecureHash'];
    unset($input['vnp_SecureHash'], $input['vnp_SecureHashType']);

    ksort($input);
    $hashData = [];
    foreach ($input as $key => $value) {
        $hashData[] = urlencode((string) $key) . '=' . urlencode((string) $value);
    }

    $calculated = hash_hmac('sha512', implode('&', $hashData), VNPAY_HASH_SECRET);

    return hash_equals($calculated, $receivedHash);
}

function createVnpayPaymentUrl(array $order, array $payment): string
{
    $params = [
        'vnp_Version' => '2.1.0',
        'vnp_Command' => 'pay',
        'vnp_TmnCode' => VNPAY_TMN_CODE,
        'vnp_Amount' => (int) round(((float) $order['total_amount']) * 100),
        'vnp_CreateDate' => $payment['vnp_create_date'],
        'vnp_CurrCode' => 'VND',
        'vnp_IpAddr' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
        'vnp_Locale' => 'vn',
        'vnp_OrderInfo' => 'Thanh toan don hang #' . $order['id'],
        'vnp_OrderType' => 'other',
        'vnp_ReturnUrl' => VNPAY_RETURN_URL,
        'vnp_TxnRef' => $payment['transaction_code'],
        'vnp_ExpireDate' => date('YmdHis', strtotime('+15 minutes')),
    ];

    if (!empty($_POST['bank_code'])) {
        $params['vnp_BankCode'] = $_POST['bank_code'];
    }

    return VNPAY_PAY_URL . '?' . vnpayBuildSignedQuery($params);
}

function queryVnpayTransaction(array $payment): array
{
    $requestId = uniqid('query_', true);
    $payload = [
        'vnp_RequestId' => substr(str_replace('.', '', $requestId), 0, 32),
        'vnp_Version' => '2.1.0',
        'vnp_Command' => 'querydr',
        'vnp_TmnCode' => VNPAY_TMN_CODE,
        'vnp_TxnRef' => $payment['transaction_code'],
        'vnp_OrderInfo' => 'Truy van giao dich don hang #' . $payment['order_id'],
        'vnp_TransactionDate' => $payment['vnp_create_date'],
        'vnp_CreateDate' => date('YmdHis'),
        'vnp_IpAddr' => $_SERVER['SERVER_ADDR'] ?? '127.0.0.1',
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

    $payload['vnp_SecureHash'] = hash_hmac('sha512', $hashData, VNPAY_HASH_SECRET);

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
