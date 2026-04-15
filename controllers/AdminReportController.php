<?php
require_once __DIR__ . '/../models/Report.php';

class AdminReportController {
    private $report;

    public function __construct() {
        $this->report = new Report();
    }

    public function index() {
        $stats = $this->report->getOverviewStats();
        $recentRevenue = $this->report->getRecentRevenue();
        $topComics = $this->report->getTopSellingComics();
        require_once __DIR__ . '/../views/admin/reports/index.php';
    }
}
?>
