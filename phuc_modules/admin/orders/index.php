<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config/app.php';
ensureSeedSessionData();
requireAdmin();

$pageTitle = 'Admin - Quản lý đơn hàng';
$statusFilter = trim($_GET['status'] ?? '');
$keyword = trim($_GET['keyword'] ?? '');

$sql = "
    SELECT o.*, u.full_name, u.email
    FROM orders o
    LEFT JOIN users u ON u.id = o.user_id
    WHERE 1 = 1
";
$params = [];

if ($statusFilter !== '') {
    $sql .= ' AND o.status = :status';
    $params['status'] = $statusFilter;
}

if ($keyword !== '') {
    $sql .= ' AND (o.id = :exact_id OR u.full_name LIKE :keyword OR u.email LIKE :keyword OR o.phone LIKE :keyword)';
    $params['exact_id'] = ctype_digit($keyword) ? (int) $keyword : 0;
    $params['keyword'] = '%' . $keyword . '%';
}

$sql .= ' ORDER BY o.created_at DESC';
$stmt = db()->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll();

require_once dirname(__DIR__, 2) . '/layouts/header.php';
?>

<div class="card">
    <form method="get" class="inline-filter">
        <div>
            <label for="keyword">Từ khóa</label>
            <input type="text" id="keyword" name="keyword" value="<?= e($keyword) ?>" placeholder="Mã đơn / tên user / email / SĐT">
        </div>
        <div>
            <label for="status">Trạng thái đơn</label>
            <select id="status" name="status">
                <option value="">Tất cả</option>
                <?php foreach (orderStatuses() as $value => $label): ?>
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
                <th>Mã đơn</th>
                <th>Người mua</th>
                <th>Người nhận</th>
                <th>Tổng tiền</th>
                <th>Thanh toán</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$orders): ?>
            <tr>
                <td colspan="8">Không có đơn hàng phù hợp.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= (int) $order['id'] ?></td>
                    <td>
                        <strong><?= e($order['full_name'] ?? 'N/A') ?></strong><br>
                        <span class="small muted"><?= e($order['email'] ?? '') ?></span>
                    </td>
                    <td>
                        <?= e($order['receiver_name']) ?><br>
                        <span class="small muted"><?= e($order['phone']) ?></span>
                    </td>
                    <td><?= e(formatCurrency($order['total_amount'])) ?></td>
                    <td>
                        <?= e($order['payment_method']) ?><br>
                        <span class="badge <?= e(statusBadgeClass($order['payment_status'])) ?>">
                            <?= e(paymentStatuses()[$order['payment_status']] ?? $order['payment_status']) ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge <?= e(statusBadgeClass($order['status'])) ?>">
                            <?= e(orderStatuses()[$order['status']] ?? $order['status']) ?>
                        </span>
                    </td>
                    <td><?= e($order['created_at']) ?></td>
                    <td>
                        <a class="btn btn-secondary" href="detail.php?id=<?= (int) $order['id'] ?>">Xem chi tiết</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>
