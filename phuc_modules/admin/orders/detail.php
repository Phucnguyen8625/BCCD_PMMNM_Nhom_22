<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config/app.php';
ensureSeedSessionData();
requireAdmin();

$pageTitle = 'Admin - Chi tiết đơn hàng';
$orderId = (int) ($_GET['id'] ?? 0);

$stmt = db()->prepare("SELECT o.*, u.full_name, u.email FROM orders o LEFT JOIN users u ON u.id = o.user_id WHERE o.id = :id LIMIT 1");
$stmt->execute(['id' => $orderId]);
$order = $stmt->fetch();

if (!$order) {
    setFlash('error', 'Đơn hàng không tồn tại.');
    redirect('index.php');
}

$itemStmt = db()->prepare("SELECT * FROM order_items WHERE order_id = :order_id ORDER BY id ASC");
$itemStmt->execute(['order_id' => $orderId]);
$items = $itemStmt->fetchAll();

$logStmt = db()->prepare("SELECT * FROM order_logs WHERE order_id = :order_id ORDER BY created_at DESC");
$logStmt->execute(['order_id' => $orderId]);
$logs = $logStmt->fetchAll();

require_once dirname(__DIR__, 2) . '/layouts/header.php';
?>

<div class="grid grid-2">
    <div class="card">
        <h3>Thông tin chung</h3>
        <ul class="summary-list">
            <li><strong>Mã đơn:</strong> #<?= (int) $order['id'] ?></li>
            <li><strong>Người mua:</strong> <?= e($order['full_name'] ?? 'N/A') ?> - <?= e($order['email'] ?? '') ?></li>
            <li><strong>Người nhận:</strong> <?= e($order['receiver_name']) ?></li>
            <li><strong>Số điện thoại:</strong> <?= e($order['phone']) ?></li>
            <li><strong>Địa chỉ:</strong> <?= e($order['address']) ?></li>
            <li><strong>Phương thức thanh toán:</strong> <?= e($order['payment_method']) ?></li>
            <li><strong>Tổng tiền:</strong> <?= e(formatCurrency($order['total_amount'])) ?></li>
            <li><strong>Trạng thái đơn:</strong> <span class="badge <?= e(statusBadgeClass($order['status'])) ?>"><?= e(orderStatuses()[$order['status']] ?? $order['status']) ?></span></li>
            <li><strong>Trạng thái thanh toán:</strong> <span class="badge <?= e(statusBadgeClass($order['payment_status'])) ?>"><?= e(paymentStatuses()[$order['payment_status']] ?? $order['payment_status']) ?></span></li>
            <li><strong>Ghi chú:</strong> <?= e($order['note'] ?? '') ?></li>
        </ul>
    </div>

    <div class="card">
        <h3>Cập nhật trạng thái đơn</h3>
        <form method="post" action="update_status.php">
            <input type="hidden" name="order_id" value="<?= (int) $order['id'] ?>">

            <div>
                <label for="status">Trạng thái mới</label>
                <select id="status" name="status" required>
                    <?php foreach (orderStatuses() as $value => $label): ?>
                        <option value="<?= e($value) ?>" <?= $value === $order['status'] ? 'selected' : '' ?>><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="margin-top: 12px;">
                <label for="note">Ghi chú</label>
                <textarea id="note" name="note" placeholder="Ví dụ: Đã xác nhận đơn, chuẩn bị bàn giao đơn vị vận chuyển..."></textarea>
            </div>

            <div style="margin-top: 14px;" class="actions">
                <button class="btn btn-success" type="submit">Lưu trạng thái</button>
                <a class="btn btn-secondary" href="index.php">Quay lại danh sách</a>
            </div>
        </form>
        <p class="small muted">Luồng hợp lệ: Chờ xác nhận → Đã xác nhận → Đang giao → Hoàn thành. Chỉ cho phép hủy khi đơn chưa hoàn thành.</p>
    </div>
</div>

<div class="card">
    <h3>Sản phẩm trong đơn</h3>
    <table>
        <thead>
            <tr>
                <th>Truyện</th>
                <th class="right">Giá</th>
                <th class="right">Số lượng</th>
                <th class="right">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= e($item['comic_name']) ?></td>
                    <td class="right"><?= e(formatCurrency($item['price'])) ?></td>
                    <td class="right"><?= (int) $item['quantity'] ?></td>
                    <td class="right"><?= e(formatCurrency($item['subtotal'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="card">
    <h3>Lịch sử thay đổi</h3>
    <table>
        <thead>
            <tr>
                <th>Thời gian</th>
                <th>Từ</th>
                <th>Sang</th>
                <th>Ghi chú</th>
                <th>Người thực hiện</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!$logs): ?>
                <tr><td colspan="5">Chưa có log nào.</td></tr>
            <?php else: ?>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= e($log['created_at']) ?></td>
                        <td><?= e(orderStatuses()[$log['old_status']] ?? $log['old_status']) ?></td>
                        <td><?= e(orderStatuses()[$log['new_status']] ?? $log['new_status']) ?></td>
                        <td><?= e($log['note']) ?></td>
                        <td><?= e($log['changed_by_name']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>
