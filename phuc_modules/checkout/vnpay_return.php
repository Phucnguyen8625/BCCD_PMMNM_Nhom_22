<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/app.php';
ensureSeedSessionData();
requireLogin();

$pageTitle = 'Kết quả thanh toán VNPAY';
$input = $_GET;
$isValid = vnpayVerifyResponse($input);
$txnRef = trim($_GET['vnp_TxnRef'] ?? '');
$responseCode = trim($_GET['vnp_ResponseCode'] ?? '');
$transactionNo = trim($_GET['vnp_TransactionNo'] ?? '');
$payDate = trim($_GET['vnp_PayDate'] ?? '');
$bankCode = trim($_GET['vnp_BankCode'] ?? '');

$pdo = db();
$stmt = $pdo->prepare('SELECT * FROM payments WHERE transaction_code = :transaction_code LIMIT 1');
$stmt->execute(['transaction_code' => $txnRef]);
$payment = $stmt->fetch();

$message = 'Không tìm thấy giao dịch.';
$success = false;

if ($payment && $isValid) {
    $newPaymentStatus = $responseCode === '00' ? 'paid' : 'failed';
    $newOrderStatus = $responseCode === '00' ? 'confirmed' : 'cancelled';

    $pdo->beginTransaction();
    try {
        $updatePayment = $pdo->prepare('UPDATE payments SET status = :status, response_code = :response_code, bank_code = :bank_code, paid_at = :paid_at, raw_response = :raw_response, updated_at = NOW() WHERE id = :id');
        $updatePayment->execute([
            'status' => $newPaymentStatus,
            'response_code' => $responseCode,
            'bank_code' => $bankCode,
            'paid_at' => $payDate,
            'raw_response' => json_encode($_GET, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            'id' => $payment['id'],
        ]);

        $updateOrder = $pdo->prepare('UPDATE orders SET payment_status = :payment_status, status = :status, updated_at = NOW() WHERE id = :id');
        $updateOrder->execute([
            'payment_status' => $newPaymentStatus,
            'status' => $newOrderStatus,
            'id' => $payment['order_id'],
        ]);

        $insertLog = $pdo->prepare('INSERT INTO order_logs (order_id, old_status, new_status, note, changed_by, changed_by_name) VALUES (:order_id, :old_status, :new_status, :note, :changed_by, :changed_by_name)');
        $insertLog->execute([
            'order_id' => $payment['order_id'],
            'old_status' => 'pending',
            'new_status' => $newOrderStatus,
            'note' => 'VNPAY return. TransactionNo=' . $transactionNo . ', ResponseCode=' . $responseCode,
            'changed_by' => currentUserId(),
            'changed_by_name' => currentUserName(),
        ]);

        $pdo->commit();
        unset($_SESSION['cart']);
        $success = $responseCode === '00';
        $message = $success ? 'Thanh toán VNPAY thành công.' : 'Thanh toán VNPAY thất bại hoặc bị hủy.';
    } catch (Throwable $exception) {
        $pdo->rollBack();
        $message = 'Có lỗi khi cập nhật kết quả thanh toán: ' . $exception->getMessage();
    }
} elseif (!$isValid) {
    $message = 'Sai chữ ký bảo mật. Callback không hợp lệ.';
}

require_once dirname(__DIR__) . '/layouts/header.php';
?>

<div class="card">
    <h3><?= $success ? 'Thanh toán thành công' : 'Thanh toán chưa thành công' ?></h3>
    <p><?= e($message) ?></p>

    <ul class="summary-list">
        <li><strong>Mã tham chiếu:</strong> <?= e($txnRef) ?></li>
        <li><strong>Mã phản hồi:</strong> <?= e($responseCode) ?></li>
        <li><strong>Mã giao dịch VNPAY:</strong> <?= e($transactionNo) ?></li>
        <li><strong>Ngân hàng:</strong> <?= e($bankCode) ?></li>
        <li><strong>Thời gian:</strong> <?= e($payDate) ?></li>
    </ul>

    <div class="actions" style="margin-top: 14px;">
        <a class="btn" href="<?= e(buildBasePath('admin/orders/index.php')) ?>">Vào quản lý đơn hàng</a>
        <a class="btn btn-secondary" href="<?= e(buildBasePath('admin/payments/index.php')) ?>">Vào quản lý thanh toán</a>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
