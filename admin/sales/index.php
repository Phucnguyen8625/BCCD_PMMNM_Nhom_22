<?php
require_once __DIR__ . '/../../config/adminConfig.php';
requireAdminLogin();

$pageTitle = 'Doanh số';
$menuSidebar = layMenuAdmin('sales');

$pageStyles = [
    assetUrl('css/admin/sales/salesStyle.css')
];

$orders = [
    ['ma' => 'DH001', 'khach' => 'Nguyễn An', 'goi' => 'Premium', 'gia' => 199000, 'trangThai' => 'Thành công'],
    ['ma' => 'DH002', 'khach' => 'Trần Vy', 'goi' => 'VIP', 'gia' => 299000, 'trangThai' => 'Thành công'],
    ['ma' => 'DH003', 'khach' => 'Lê Khôi', 'goi' => 'Premium', 'gia' => 199000, 'trangThai' => 'Đang xử lý'],
];

require_once INCLUDE_PATH . '/admin/adminHeader.php';
require_once INCLUDE_PATH . '/admin/adminSidebar.php';
?>
<main class="admin-main">
    <header class="admin-topbar">
        <div>
            <h1><?= e($pageTitle) ?></h1>
            <p>Theo dõi đơn hàng và doanh thu hệ thống</p>
        </div>
    </header>

    <section class="sales-summary">
        <article class="summary-card">
            <h3><?= e(formatMoney(15400000)) ?></h3>
            <p>Doanh thu tháng</p>
        </article>
        <article class="summary-card">
            <h3>186</h3>
            <p>Đơn hàng thành công</p>
        </article>
        <article class="summary-card">
            <h3>23</h3>
            <p>Đơn đang xử lý</p>
        </article>
    </section>

    <section class="panel-card">
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Gói</th>
                        <th>Giá</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= e($order['ma']) ?></td>
                            <td><?= e($order['khach']) ?></td>
                            <td><?= e($order['goi']) ?></td>
                            <td><?= e(formatMoney($order['gia'])) ?></td>
                            <td><span class="status-badge"><?= e($order['trangThai']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
<?php require_once INCLUDE_PATH . '/admin/adminFooter.php'; ?>