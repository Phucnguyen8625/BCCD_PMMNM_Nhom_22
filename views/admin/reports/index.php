<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống kê / Báo cáo</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .back-link { color: #007bff; text-decoration: none; }
        .kpi-row { display: flex; gap: 20px; margin-bottom: 30px; }
        .kpi-card { background: #fff; padding: 20px; border-radius: 8px; flex: 1; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; }
        .kpi-card h3 { margin: 0 0 10px 0; color: #666; font-size: 16px; }
        .kpi-card .value { font-size: 28px; font-weight: bold; color: #333; }
        .chart-row { display: flex; gap: 20px; }
        .chart-card { background: #fff; padding: 20px; border-radius: 8px; flex: 1; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <a href="admin.php" class="back-link">← Quay lại Dashboard</a>
                <h1>Thống kê / Báo cáo</h1>
            </div>
        </div>

        <div class="kpi-row">
            <div class="kpi-card">
                <h3>Tổng Đơn Hàng</h3>
                <div class="value"><?= htmlspecialchars($stats['total_orders']) ?></div>
            </div>
            <div class="kpi-card">
                <h3>Tổng Doanh Thu (Hoàn thành)</h3>
                <div class="value"><?= number_format($stats['total_revenue'], 0, ',', '.') ?> đ</div>
            </div>
        </div>

        <div class="chart-row">
            <div class="chart-card" style="flex: 2;">
                <h2>Doanh Thu 7 Ngày Gần Nhất</h2>
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="chart-card" style="flex: 1;">
                <h2>Top Truyện Bán Chạy</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Tên truyện</th>
                            <th>Đã bán</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($topComics as $comic): ?>
                        <tr>
                            <td><?= htmlspecialchars($comic['name']) ?></td>
                            <td><?= $comic['total_sold'] ?> cuốn</td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($topComics)): ?>
                        <tr><td colspan="2" style="text-align: center;">Chưa có dữ liệu</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const currData = <?= json_encode($recentRevenue) ?>;
        const labels = currData.map(item => item.date);
        const data = currData.map(item => item.revenue);

        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
