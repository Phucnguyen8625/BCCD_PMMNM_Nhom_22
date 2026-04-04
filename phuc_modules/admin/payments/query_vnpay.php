<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config/app.php';
ensureSeedSessionData();
requireAdmin();

$paymentId = (int) ($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM payments WHERE id = :id LIMIT 1');
$stmt->execute(['id' => $paymentId]);
$payment = $stmt->fetch();

if (!$payment || $payment['method'] !== 'VNPAY') {
    setFlash('error', 'Giao dịch VNPAY không hợp lệ.');
    redirect('index.php');
}

if (VNPAY_TMN_CODE === 'YOUR_TMN_CODE' || VNPAY_HASH_SECRET === 'YOUR_HASH_SECRET') {
    setFlash('error', 'Bạn cần cấu hình TMN_CODE và HASH_SECRET trong config/app.php trước khi query sandbox.');
    redirect('detail.php?id=' . $paymentId);
}

$result = queryVnpayTransaction($payment);
if (!$result['ok']) {
    setFlash('error', $result['message']);
    redirect('detail.php?id=' . $paymentId);
}

$data = $result['data'] ?? [];
$responseCode = (string) ($data['vnp_ResponseCode'] ?? '');
$transactionStatus = (string) ($data['vnp_TransactionStatus'] ?? '');
$newStatus = 'pending';

if ($responseCode === '00' && $transactionStatus === '00') {
    $newStatus = 'paid';
} elseif ($responseCode === '00') {
    $newStatus = 'failed';
} else {
    $newStatus = 'mismatch';
}

$pdo = db();
$pdo->beginTransaction();

try {
    $updatePayment = $pdo->prepare('UPDATE payments SET status = :status, response_code = :response_code, bank_code = :bank_code, paid_at = :paid_at, raw_response = :raw_response, updated_at = NOW() WHERE id = :id');
    $updatePayment->execute([
        'status' => $newStatus,
        'response_code' => $responseCode,
        'bank_code' => $data['vnp_BankCode'] ?? $payment['bank_code'],
        'paid_at' => $data['vnp_PayDate'] ?? $payment['paid_at'],
        'raw_response' => json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        'id' => $paymentId,
    ]);

    $updateOrder = $pdo->prepare('UPDATE orders SET payment_status = :payment_status, status = :status, updated_at = NOW() WHERE id = :id');
    $updateOrder->execute([
        'payment_status' => $newStatus === 'paid' ? 'paid' : ($newStatus === 'failed' ? 'failed' : 'pending'),
        'status' => $newStatus === 'paid' ? 'confirmed' : ($newStatus === 'failed' ? 'cancelled' : 'pending'),
        'id' => $payment['order_id'],
    ]);

    $pdo->commit();
    setFlash('success', 'Đã đối soát giao dịch với VNPAY sandbox.');
} catch (Throwable $exception) {
    $pdo->rollBack();
    setFlash('error', 'Đối soát thất bại: ' . $exception->getMessage());
}

redirect('detail.php?id=' . $paymentId);
