<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config/app.php';
ensureSeedSessionData();
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$orderId = (int) ($_POST['order_id'] ?? 0);
$newStatus = trim($_POST['status'] ?? '');
$note = trim($_POST['note'] ?? '');

$pdo = db();
$stmt = $pdo->prepare('SELECT * FROM orders WHERE id = :id LIMIT 1');
$stmt->execute(['id' => $orderId]);
$order = $stmt->fetch();

if (!$order) {
    setFlash('error', 'Đơn hàng không tồn tại.');
    redirect('index.php');
}

$currentStatus = (string) $order['status'];
if ($newStatus === $currentStatus) {
    setFlash('error', 'Bạn chưa thay đổi trạng thái đơn hàng.');
    redirect('detail.php?id=' . $orderId);
}

if (!canChangeOrderStatus($currentStatus, $newStatus)) {
    setFlash('error', 'Không thể chuyển từ trạng thái hiện tại sang trạng thái bạn chọn.');
    redirect('detail.php?id=' . $orderId);
}

$paymentStatus = $order['payment_status'];
if ($newStatus === 'completed' && $order['payment_method'] === 'COD' && $paymentStatus === 'unpaid') {
    $paymentStatus = 'paid';
}

$pdo->beginTransaction();

try {
    $update = $pdo->prepare('UPDATE orders SET status = :status, payment_status = :payment_status, note = :note, updated_at = NOW() WHERE id = :id');
    $update->execute([
        'status' => $newStatus,
        'payment_status' => $paymentStatus,
        'note' => $note !== '' ? $note : $order['note'],
        'id' => $orderId,
    ]);

    $log = $pdo->prepare('INSERT INTO order_logs (order_id, old_status, new_status, note, changed_by, changed_by_name) VALUES (:order_id, :old_status, :new_status, :note, :changed_by, :changed_by_name)');
    $log->execute([
        'order_id' => $orderId,
        'old_status' => $currentStatus,
        'new_status' => $newStatus,
        'note' => $note,
        'changed_by' => currentUserId(),
        'changed_by_name' => currentUserName(),
    ]);

    $pdo->commit();
    setFlash('success', 'Đã cập nhật trạng thái đơn hàng thành công.');
} catch (Throwable $exception) {
    $pdo->rollBack();
    setFlash('error', 'Cập nhật thất bại: ' . $exception->getMessage());
}

redirect('detail.php?id=' . $orderId);
