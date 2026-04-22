<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Payment.php';

class AdminPaymentController {
    private $payment;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->payment = new Payment($this->db);
    }

    public function index() {
        $payments = $this->payment->getAllPayments();
        require_once __DIR__ . '/../views/admin/payments/index.php';
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
            $id = $_POST['id'];
            $status = $_POST['status'];
            
            $result = $this->payment->updatePaymentStatus($id, $status);
            if ($result) {
                header("Location: admin.php?controller=payment&action=index&success=Cập nhật trạng thái thành công");
            } else {
                header("Location: admin.php?controller=payment&action=index&error=Cập nhật thất bại");
            }
            exit();
        }
    }
}
?>
