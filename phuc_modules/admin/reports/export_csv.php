<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config/app.php';
ensureSeedSessionData();
requireAdmin();

$fromDate = $_GET['from_date'] ?? date('Y-m-01');
$toDate = $_GET['to_date'] ?? date('Y-m-d');

$stmt = db()->prepare("SELECT DATE(created_at) AS report_date, COUNT(*) AS order_count,
SUM(CASE WHEN payment_status = 'paid' THEN total_amount ELSE 0 END) AS revenue
FROM orders
WHERE created_at BETWEEN :start AND :end
GROUP BY DATE(created_at)
ORDER BY report_date ASC");
$stmt->execute([
    'start' => $fromDate . ' 00:00:00',
    'end' => $toDate . ' 23:59:59',
]);
$rows = $stmt->fetchAll();

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="bao_cao_' . $fromDate . '_' . $toDate . '.csv"');

echo "Ngay,So don,Doanh thu\n";
foreach ($rows as $row) {
    echo sprintf(
        "%s,%d,%s\n",
        $row['report_date'],
        (int) $row['order_count'],
        (string) $row['revenue']
    );
}
exit;
