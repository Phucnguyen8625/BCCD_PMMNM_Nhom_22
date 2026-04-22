<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Report.php';

class AdminReportController {
    private $report;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->report = new Report($this->db);
    }

    public function index() {
        $stats = $this->report->getOverviewStats();
        $recentRevenue = $this->report->getRecentRevenue();
        $topComics = $this->report->getTopSellingComics();
        require_once __DIR__ . '/../views/admin/reports/index.php';
    }
}
?>
