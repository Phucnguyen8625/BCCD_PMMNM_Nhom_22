<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config/app.php';
ensureSeedSessionData();
requireAdmin();

$pageTitle = 'Admin - Quản lý thanh toán';
$statusFilter = trim($_GET['status'] ?? '');
$methodFilter = trim($_GET['method'] ?? '');

$sql = "
    SELECT p.*, o.receiver_name, o.phone, o.total_amount, u.full_name
    FROM payments p
    INNER JOIN orders o ON o.id = p.order_id
    LEFT JOIN users u ON u.id = o.user_id
    WHERE 1 = 1
";
$params = [];

if ($statusFilter !== '') {
    $sql .= ' AND p.status = :status';
    $params['status'] = $statusFilter;
}

if ($methodFilter !== '') {
    $sql .= ' AND p.method = :method';
    $params['method'] = $methodFilter;
}

$sql .= ' ORDER BY p.created_at DESC';
$stmt = db()->prepare($sql);
$stmt->execute($params);
$payments = $stmt->fetchAll();

require_once dirname(__DIR__, 2) . '/layouts/header.php';
?>

<div class="card">
    <form method="get" class="inline-filter">
        <div>
            <label for="method">Phương thức</label>
            <select id="method" name="method">
                <option value="">Tất cả</option>
                <?php foreach (paymentMethods() as $value => $label): ?>
                    <option value="<?= e($value) ?>" <?= $methodFilter === $value ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="status">Trạng thái</label>
            <select id="status" name="status">
                <option value="">Tất cả</option>
                <?php foreach (paymentStatuses() as $value => $label): ?>
                    <option value="<?= e($value) ?>" <?= $statusFilter === $value ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <button class="btn" type="submit">Lọc dữ liệu</button>
        </div>
    </form>
</div>

<div class="card">
    <table>
        <thead>
        <tr>
            <th>Mã thanh toán</th>
            <th>Đơn hàng</th>
            <th>Khách hàng</th>
            <th>Phương thức</th>
            <th>Số tiền</th>
            <th>Trạng thái</th>
            <th>Mã giao dịch</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!$payments): ?>
            <tr><td colspan="8">Không có giao dịch phù hợp.</td></tr>
        <?php else: ?>
            <?php foreach ($payments as $payment): ?>
                <tr>
                    <td>#<?= (int) $payment['id'] ?></td>
                    <td>#<?= (int) $payment['order_id'] ?></td>
                    <td>
                        <strong><?= e($payment['full_name'] ?? $payment['receiver_name']) ?></strong><br>
                        <span class="small muted"><?= e($payment['phone']) ?></span>
                    </td>
                    <td><?= e($payment['method']) ?></td>
                    <td><?= e(formatCurrency($payment['amount'])) ?></td>
                    <td>
                        <span class="badge <?= e(statusBadgeClass($payment['status'])) ?>">
                            <?= e(paymentStatuses()[$payment['status']] ?? $payment['status']) ?>
                        </span>
                    </td>
                    <td><?= e($payment['transaction_code']) ?></td>
                    <td>
                        <a class="btn btn-secondary" href="detail.php?id=<?= (int) $payment['id'] ?>">Xem chi tiết</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>
