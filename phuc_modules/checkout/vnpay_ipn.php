<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/app.php';

$input = $_GET;
if (!vnpayVerifyResponse($input)) {
    echo json_encode(['RspCode' => '97', 'Message' => 'Invalid signature']);
    exit;
}

$txnRef = trim($_GET['vnp_TxnRef'] ?? '');
$responseCode = trim($_GET['vnp_ResponseCode'] ?? '');
$payDate = trim($_GET['vnp_PayDate'] ?? '');
$transactionNo = trim($_GET['vnp_TransactionNo'] ?? '');

$stmt = db()->prepare('SELECT * FROM payments WHERE transaction_code = :transaction_code LIMIT 1');
$stmt->execute(['transaction_code' => $txnRef]);
$payment = $stmt->fetch();

if (!$payment) {
    echo json_encode(['RspCode' => '01', 'Message' => 'Order not found']);
    exit;
}

$newStatus = $responseCode === '00' ? 'paid' : 'failed';
$newOrderStatus = $responseCode === '00' ? 'confirmed' : 'cancelled';

$pdo = db();
$pdo->beginTransaction();

try {
    $updatePayment = $pdo->prepare('UPDATE payments SET status = :status, response_code = :response_code, paid_at = :paid_at, raw_response = :raw_response, updated_at = NOW() WHERE id = :id');
    $updatePayment->execute([
        'status' => $newStatus,
        'response_code' => $responseCode,
        'paid_at' => $payDate,
        'raw_response' => json_encode($_GET, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        'id' => $payment['id'],
    ]);

    $updateOrder = $pdo->prepare('UPDATE orders SET payment_status = :payment_status, status = :status, updated_at = NOW() WHERE id = :id');
    $updateOrder->execute([
        'payment_status' => $newStatus,
        'status' => $newOrderStatus,
        'id' => $payment['order_id'],
    ]);

    $log = $pdo->prepare('INSERT INTO order_logs (order_id, old_status, new_status, note, changed_by, changed_by_name) VALUES (:order_id, :old_status, :new_status, :note, :changed_by, :changed_by_name)');
    $log->execute([
        'order_id' => $payment['order_id'],
        'old_status' => 'pending',
        'new_status' => $newOrderStatus,
        'note' => 'IPN VNPAY. TransactionNo=' . $transactionNo,
        'changed_by' => 0,
        'changed_by_name' => 'VNPAY_IPN',
    ]);

    $pdo->commit();
    echo json_encode(['RspCode' => '00', 'Message' => 'Confirm Success']);
} catch (Throwable $exception) {
    $pdo->rollBack();
    echo json_encode(['RspCode' => '99', 'Message' => $exception->getMessage()]);
}
