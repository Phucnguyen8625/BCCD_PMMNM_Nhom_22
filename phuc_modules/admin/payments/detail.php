<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config/app.php';
ensureSeedSessionData();
requireAdmin();

$pageTitle = 'Admin - Chi tiết thanh toán';
$paymentId = (int) ($_GET['id'] ?? 0);

$stmt = db()->prepare("SELECT p.*, o.status AS order_status, o.payment_status AS order_payment_status, o.receiver_name, o.phone, o.address, o.total_amount, u.full_name, u.email
FROM payments p
INNER JOIN orders o ON o.id = p.order_id
LEFT JOIN users u ON u.id = o.user_id
WHERE p.id = :id LIMIT 1");
$stmt->execute(['id' => $paymentId]);
$payment = $stmt->fetch();

if (!$payment) {
    setFlash('error', 'Giao dịch không tồn tại.');
    redirect('index.php');
}

require_once dirname(__DIR__, 2) . '/layouts/header.php';
?>

<div class="grid grid-2">
    <div class="card">
        <h3>Thông tin giao dịch</h3>
        <ul class="summary-list">
            <li><strong>Mã thanh toán:</strong> #<?= (int) $payment['id'] ?></li>
            <li><strong>Mã đơn hàng:</strong> #<?= (int) $payment['order_id'] ?></li>
            <li><strong>Khách hàng:</strong> <?= e($payment['full_name'] ?? $payment['receiver_name']) ?></li>
            <li><strong>Email:</strong> <?= e($payment['email'] ?? '') ?></li>
            <li><strong>Số điện thoại:</strong> <?= e($payment['phone']) ?></li>
            <li><strong>Địa chỉ:</strong> <?= e($payment['address']) ?></li>
            <li><strong>Phương thức:</strong> <?= e($payment['method']) ?></li>
            <li><strong>Số tiền:</strong> <?= e(formatCurrency($payment['amount'])) ?></li>
            <li><strong>Mã giao dịch:</strong> <?= e($payment['transaction_code']) ?></li>
            <li><strong>Trạng thái payment:</strong> <span class="badge <?= e(statusBadgeClass($payment['status'])) ?>"><?= e(paymentStatuses()[$payment['status']] ?? $payment['status']) ?></span></li>
            <li><strong>Trạng thái đơn:</strong> <span class="badge <?= e(statusBadgeClass($payment['order_status'])) ?>"><?= e(orderStatuses()[$payment['order_status']] ?? $payment['order_status']) ?></span></li>
            <li><strong>Mã phản hồi:</strong> <?= e($payment['response_code'] ?? '') ?></li>
            <li><strong>Ngân hàng:</strong> <?= e($payment['bank_code'] ?? '') ?></li>
            <li><strong>Thời gian thanh toán:</strong> <?= e($payment['paid_at'] ?? '') ?></li>
        </ul>
    </div>

    <div class="card">
        <h3>Thao tác nghiệp vụ</h3>
        <form method="post" action="update_status.php">
            <input type="hidden" name="payment_id" value="<?= (int) $payment['id'] ?>">
            <div>
                <label for="status">Cập nhật trạng thái</label>
                <select id="status" name="status" required>
                    <?php foreach (paymentStatuses() as $value => $label): ?>
                        <option value="<?= e($value) ?>" <?= $value === $payment['status'] ? 'selected' : '' ?>><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="margin-top: 12px;">
                <label for="admin_note">Ghi chú</label>
                <textarea id="admin_note" name="admin_note" placeholder="Ví dụ: Đối soát callback thành công, xác nhận thủ công với COD..."></textarea>
            </div>
            <div class="actions" style="margin-top: 14px;">
                <button class="btn btn-success" type="submit">Lưu thay đổi</button>
                <a class="btn btn-secondary" href="index.php">Quay lại</a>
                <?php if ($payment['method'] === 'VNPAY'): ?>
                    <a class="btn btn-warning" href="query_vnpay.php?id=<?= (int) $payment['id'] ?>">Query VNPAY Sandbox</a>
                <?php endif; ?>
            </div>
        </form>
        <p class="small muted">Dùng nút Query VNPAY để đối soát lại trạng thái từ sandbox theo API querydr.</p>
    </div>
</div>

<div class="card">
    <h3>Dữ liệu callback / phản hồi thô</h3>
    <pre style="white-space: pre-wrap; overflow: auto; background: #111827; color: #f9fafb; padding: 16px; border-radius: 10px;"><?= e($payment['raw_response'] ?: 'Chưa có dữ liệu callback/raw response.') ?></pre>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>
