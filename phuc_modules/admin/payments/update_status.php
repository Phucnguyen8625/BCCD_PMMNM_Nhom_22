<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config/app.php';
ensureSeedSessionData();
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$paymentId = (int) ($_POST['payment_id'] ?? 0);
$status = trim($_POST['status'] ?? '');
$adminNote = trim($_POST['admin_note'] ?? '');

$pdo = db();
$stmt = $pdo->prepare('SELECT * FROM payments WHERE id = :id LIMIT 1');
$stmt->execute(['id' => $paymentId]);
$payment = $stmt->fetch();

if (!$payment) {
    setFlash('error', 'Không tìm thấy giao dịch.');
    redirect('index.php');
}

$orderPaymentStatus = match ($status) {
    'paid' => 'paid',
    'pending' => 'pending',
    'failed' => 'failed',
    'refunded' => 'refunded',
    'mismatch' => 'pending',
    default => 'unpaid',
};

$orderStatus = null;
if ($status === 'paid') {
    $orderStatus = 'confirmed';
} elseif ($status === 'failed') {
    $orderStatus = 'cancelled';
}

$pdo->beginTransaction();

try {
    $updatePayment = $pdo->prepare('UPDATE payments SET status = :status, admin_note = :admin_note, updated_at = NOW() WHERE id = :id');
    $updatePayment->execute([
        'status' => $status,
        'admin_note' => $adminNote,
        'id' => $paymentId,
    ]);

    $sql = 'UPDATE orders SET payment_status = :payment_status, updated_at = NOW()';
    $params = [
        'payment_status' => $orderPaymentStatus,
        'id' => $payment['order_id'],
    ];

    if ($orderStatus !== null) {
        $sql .= ', status = :status';
        $params['status'] = $orderStatus;
    }

    $sql .= ' WHERE id = :id';
    $updateOrder = $pdo->prepare($sql);
    $updateOrder->execute($params);

    $pdo->commit();
    setFlash('success', 'Đã cập nhật trạng thái thanh toán.');
} catch (Throwable $exception) {
    $pdo->rollBack();
    setFlash('error', 'Cập nhật thất bại: ' . $exception->getMessage());
}

redirect('detail.php?id=' . $paymentId);
