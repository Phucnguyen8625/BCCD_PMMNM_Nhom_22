<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/app.php';
ensureSeedSessionData();

$pageTitle = 'Kết quả thanh toán VNPAY';

function normalizeVnpayPayDate(?string $payDate): ?string
{
    $payDate = trim((string) $payDate);

    if ($payDate === '') {
        return null;
    }

    $dt = DateTime::createFromFormat('YmdHis', $payDate);

    if ($dt === false) {
        return null;
    }

    return $dt->format('Y-m-d H:i:s');
}

$input = $_GET;
$isValid = vnpayVerifyResponse($input);

$txnRef = trim($input['vnp_TxnRef'] ?? '');
$responseCode = trim($input['vnp_ResponseCode'] ?? '');
$transactionStatus = trim($input['vnp_TransactionStatus'] ?? '');
$transactionNo = trim($input['vnp_TransactionNo'] ?? '');
$payDate = trim($input['vnp_PayDate'] ?? '');
$bankCode = trim($input['vnp_BankCode'] ?? '');
$vnpAmount = (int) ($input['vnp_Amount'] ?? 0);
$paidAt = normalizeVnpayPayDate($payDate);

$pdo = db();

$payment = null;
$order = null;
$message = 'Không tìm thấy giao dịch.';
$success = false;

if ($txnRef !== '') {
    $stmt = $pdo->prepare('SELECT * FROM payments WHERE transaction_id = :transaction_code LIMIT 1');
    $stmt->execute([
        'transaction_code' => $txnRef,
    ]);
    $payment = $stmt->fetch();

    if ($payment) {
        $orderStmt = $pdo->prepare('SELECT * FROM orders WHERE id = :id LIMIT 1');
        $orderStmt->execute([
            'id' => $payment['order_id'],
        ]);
        $order = $orderStmt->fetch();
    }
}

if (!$isValid) {
    $message = 'Sai chữ ký bảo mật. Callback không hợp lệ.';
} elseif (!$payment) {
    $message = 'Không tìm thấy giao dịch.';
} else {
    $isCallbackSuccess = $responseCode === '00' && ($transactionStatus === '' || $transactionStatus === '00');
    $expectedAmount = (int) round(((float) $payment['amount']) * 100);

    if ($expectedAmount !== $vnpAmount) {
        $message = 'Số tiền thanh toán không khớp.';
    } else {
        if ((string) $payment['payment_status'] === 'pending') {
            $newPaymentStatus = $isCallbackSuccess ? 'success' : 'failed';
            $newOrderStatus = $isCallbackSuccess ? 'processing' : 'cancelled';

            $pdo->beginTransaction();

            try {
                $lockStmt = $pdo->prepare('SELECT * FROM payments WHERE id = :id LIMIT 1 FOR UPDATE');
                $lockStmt->execute([
                    'id' => $payment['id'],
                ]);
                $lockedPayment = $lockStmt->fetch();

                if ($lockedPayment && (string) $lockedPayment['payment_status'] === 'pending') {
                    $updatePayment = $pdo->prepare(
                        'UPDATE payments
                         SET payment_status = :status
                         WHERE id = :id'
                    );
                    $updatePayment->execute([
                        'status' => $newPaymentStatus,
                        'id' => $lockedPayment['id'],
                    ]);

                    $updateOrder = $pdo->prepare(
                        'UPDATE orders
                         SET status = :status,
                             updated_at = NOW()
                         WHERE id = :id'
                    );
                    $updateOrder->execute([
                        'status' => $newOrderStatus,
                        'id' => $lockedPayment['order_id'],
                    ]);
                }

                $pdo->commit();
            } catch (Throwable $exception) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }

                $message = 'Có lỗi khi cập nhật kết quả thanh toán: ' . $exception->getMessage();
            }

            $stmt = $pdo->prepare('SELECT * FROM payments WHERE transaction_id = :transaction_code LIMIT 1');
            $stmt->execute([
                'transaction_code' => $txnRef,
            ]);
            $payment = $stmt->fetch();

            if ($payment) {
                $orderStmt = $pdo->prepare('SELECT * FROM orders WHERE id = :id LIMIT 1');
                $orderStmt->execute([
                    'id' => $payment['order_id'],
                ]);
                $order = $orderStmt->fetch();
            }
        }

        $success = $payment && ((string) $payment['payment_status'] === 'success' || (string) $payment['payment_status'] === 'paid');
        $message = $success
            ? 'Thanh toán VNPAY thành công.'
            : 'Thanh toán VNPAY thất bại hoặc bị hủy.';
    }
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
        <li><strong>Trạng thái payment:</strong> <?= e($payment['payment_status'] ?? 'unknown') ?></li>
        <li><strong>Trạng thái order:</strong> <?= e($order['status'] ?? 'unknown') ?></li>
    </ul>

    <div class="actions" style="margin-top: 14px;">
        <a class="p-2 bg-blue-500 text-white rounded" href="<?= e(buildBasePath('../admin.php?controller=order')) ?>">Vào quản lý đơn hàng</a>
        <a class="p-2 bg-gray-500 text-white rounded" href="<?= e(buildBasePath('../admin.php?controller=payment')) ?>">Vào quản lý thanh toán</a>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>