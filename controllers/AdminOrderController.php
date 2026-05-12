<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Order.php';

class AdminOrderController {
    private $order;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->order = new Order($this->db);
    }

    public function index() {
        $orders = $this->order->getAllOrders(); // Lấy toàn bộ danh sách đơn hàng
        require_once __DIR__ . '/../views/admin/orders/index.php';
    }

    public function show() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $order = $this->order->getOrderById($id); // Lấy thông tin chung của đơn hàng
            $orderDetails = $this->order->getOrderDetails($id); // Lấy chi tiết các sản phẩm trong đơn
            if ($order) {
                require_once __DIR__ . '/../views/admin/orders/show.php';
            } else {
                header("Location: admin.php?controller=order&action=index&error=Không tìm thấy đơn hàng");
            }
        }
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
            $id = $_POST['id'];
            $status = $_POST['status'];
            
            $result = $this->order->updateStatus($id, $status); // Cập nhật trạng thái mới cho đơn hàng
            if ($result) {
                header("Location: admin.php?controller=order&action=show&id=$id&success=Cập nhật trạng thái thành công");
            } else {
                header("Location: admin.php?controller=order&action=show&id=$id&error=Cập nhật thất bại");
            }
            exit();
        }
    }
}
?>
