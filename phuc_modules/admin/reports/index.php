<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config/app.php';
ensureSeedSessionData();
requireAdmin();

$pageTitle = 'Admin - Thống kê / Báo cáo';
$fromDate = $_GET['from_date'] ?? date('Y-m-01');
$toDate = $_GET['to_date'] ?? date('Y-m-d');

$rangeStart = $fromDate . ' 00:00:00';
$rangeEnd = $toDate . ' 23:59:59';
$pdo = db();

$kpiRevenue = $pdo->prepare("SELECT COALESCE(SUM(total_amount), 0) AS total FROM orders WHERE payment_status = 'paid' AND created_at BETWEEN :start AND :end");
$kpiRevenue->execute(['start' => $rangeStart, 'end' => $rangeEnd]);
$totalRevenue = (float) $kpiRevenue->fetchColumn();

$kpiOrders = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE created_at BETWEEN :start AND :end");
$kpiOrders->execute(['start' => $rangeStart, 'end' => $rangeEnd]);
$totalOrders = (int) $kpiOrders->fetchColumn();

$kpiUsers = $pdo->prepare("SELECT COUNT(*) FROM users WHERE created_at BETWEEN :start AND :end");
$kpiUsers->execute(['start' => $rangeStart, 'end' => $rangeEnd]);
$totalUsers = (int) $kpiUsers->fetchColumn();

$kpiPaid = $pdo->prepare("SELECT COUNT(*) FROM payments WHERE status = 'paid' AND created_at BETWEEN :start AND :end");
$kpiPaid->execute(['start' => $rangeStart, 'end' => $rangeEnd]);
$totalPaidTransactions = (int) $kpiPaid->fetchColumn();

$topStmt = $pdo->prepare("SELECT comic_name, SUM(quantity) AS total_qty, SUM(subtotal) AS total_sales
FROM order_items oi
INNER JOIN orders o ON o.id = oi.order_id
WHERE o.created_at BETWEEN :start AND :end
GROUP BY comic_name
ORDER BY total_qty DESC, total_sales DESC
LIMIT 5");
$topStmt->execute(['start' => $rangeStart, 'end' => $rangeEnd]);
$topComics = $topStmt->fetchAll();
$maxQty = max(array_column($topComics, 'total_qty') ?: [1]);

$dailyStmt = $pdo->prepare("SELECT DATE(created_at) AS report_date, COUNT(*) AS order_count,
SUM(CASE WHEN payment_status = 'paid' THEN total_amount ELSE 0 END) AS revenue
FROM orders
WHERE created_at BETWEEN :start AND :end
GROUP BY DATE(created_at)
ORDER BY report_date ASC");
$dailyStmt->execute(['start' => $rangeStart, 'end' => $rangeEnd]);
$dailyRows = $dailyStmt->fetchAll();

require_once dirname(__DIR__, 2) . '/layouts/header.php';
?>

<div class="card">
    <form method="get" class="inline-filter">
        <div>
            <label for="from_date">Từ ngày</label>
            <input type="date" id="from_date" name="from_date" value="<?= e($fromDate) ?>">
        </div>
        <div>
            <label for="to_date">Đến ngày</label>
            <input type="date" id="to_date" name="to_date" value="<?= e($toDate) ?>">
        </div>
        <div>
            <button class="btn" type="submit">Xem báo cáo</button>
        </div>
        <div>
            <a class="btn btn-secondary" href="export_csv.php?from_date=<?= e(urlencode($fromDate)) ?>&to_date=<?= e(urlencode($toDate)) ?>">Xuất CSV</a>
        </div>
    </form>
</div>

<div class="grid grid-4">
    <div class="kpi">
        <div>Doanh thu đã thanh toán</div>
        <div class="value"><?= e(formatCurrency($totalRevenue)) ?></div>
    </div>
    <div class="kpi">
        <div>Tổng đơn hàng</div>
        <div class="value"><?= $totalOrders ?></div>
    </div>
    <div class="kpi">
        <div>User đăng ký mới</div>
        <div class="value"><?= $totalUsers ?></div>
    </div>
    <div class="kpi">
        <div>Giao dịch thành công</div>
        <div class="value"><?= $totalPaidTransactions ?></div>
    </div>
</div>

<div class="grid grid-2" style="margin-top: 20px;">
    <div class="card">
        <h3>Top truyện bán chạy</h3>
        <?php if (!$topComics): ?>
            <p>Không có dữ liệu trong khoảng thời gian đã chọn.</p>
        <?php else: ?>
            <?php foreach ($topComics as $comic): ?>
                <?php $percent = ((int) $comic['total_qty'] / $maxQty) * 100; ?>
                <div style="margin-bottom: 14px;">
                    <div style="display:flex; justify-content:space-between; gap:12px;">
                        <strong><?= e($comic['comic_name']) ?></strong>
                        <span><?= (int) $comic['total_qty'] ?> cuốn</span>
                    </div>
                    <div class="bar"><span style="width: <?= (float) $percent ?>%"></span></div>
                    <div class="small muted">Doanh thu: <?= e(formatCurrency($comic['total_sales'])) ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3>Gợi ý đánh giá nhanh</h3>
        <ul class="summary-list">
            <li><strong>Tỉ lệ đơn đã thanh toán:</strong> <?= $totalOrders > 0 ? round(($totalPaidTransactions / $totalOrders) * 100, 2) : 0 ?>%</li>
            <li><strong>Giá trị trung bình / đơn:</strong> <?= $totalOrders > 0 ? e(formatCurrency($totalRevenue / $totalOrders)) : e(formatCurrency(0)) ?></li>
            <li><strong>Khoảng ngày báo cáo:</strong> <?= e($fromDate) ?> đến <?= e($toDate) ?></li>
            <li><strong>Khuyến nghị:</strong> Với đồ án môn học, phần này đã đủ để demo doanh thu, đơn hàng, top truyện và user mới.</li>
        </ul>
    </div>
</div>

<div class="card">
    <h3>Bảng doanh thu theo ngày</h3>
    <table>
        <thead>
            <tr>
                <th>Ngày</th>
                <th class="right">Số đơn</th>
                <th class="right">Doanh thu đã thanh toán</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$dailyRows): ?>
            <tr><td colspan="3">Không có dữ liệu.</td></tr>
        <?php else: ?>
            <?php foreach ($dailyRows as $row): ?>
                <tr>
                    <td><?= e($row['report_date']) ?></td>
                    <td class="right"><?= (int) $row['order_count'] ?></td>
                    <td class="right"><?= e(formatCurrency($row['revenue'])) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>
