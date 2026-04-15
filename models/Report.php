<?php
class Report {
    private $conn;

    public function __construct() {
        $db = new \PDO("mysql:host=localhost;dbname=ban_truyen_tranh;charset=utf8", "root", "");
        $this->conn = $db;
    }

    public function getRecentRevenue() {
        // Thu nhập theo ngày (7 ngày gần nhất)
        $stmt = $this->conn->prepare("
            SELECT DATE(created_at) as date, SUM(total_amount) as revenue 
            FROM orders 
            WHERE status = 'completed' AND created_at >= DATE(NOW()) - INTERVAL 7 DAY
            GROUP BY DATE(created_at)
            ORDER BY DATE(created_at) ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopSellingComics() {
        $stmt = $this->conn->prepare("
            SELECT c.name, SUM(od.quantity) as total_sold
            FROM order_details od
            JOIN comics c ON od.comic_id = c.id
            JOIN orders o ON od.order_id = o.id
            WHERE o.status = 'completed'
            GROUP BY od.comic_id
            ORDER BY total_sold DESC
            LIMIT 5
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOverviewStats() {
        $stats = [];
        
        // Total orders
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM orders");
        $stmt->execute();
        $stats['total_orders'] = $stmt->fetchColumn();

        // Total revenue
        $stmt = $this->conn->prepare("SELECT SUM(total_amount) as total FROM orders WHERE status = 'completed'");
        $stmt->execute();
        $stats['total_revenue'] = $stmt->fetchColumn() ?: 0;
        
        return $stats;
    }
}
?>
