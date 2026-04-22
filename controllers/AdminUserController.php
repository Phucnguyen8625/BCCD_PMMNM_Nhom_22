<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AdminUserController {
    private $userModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new User($this->db);
    }

    // Hiển thị danh sách khách hàng & nhân viên
    public function index() {
        $users = $this->userModel->readAll();
        require_once __DIR__ . '/../views/admin/users/index.php';
    }

    // Thay đổi quyền (User <-> Admin)
    public function toggleRole() {
        if (isset($_GET['id']) && isset($_GET['role'])) {
            $id = $_GET['id'];
            $newRole = ($_GET['role'] === 'admin') ? 'user' : 'admin';
            
            // Prevent self-demotion
            if ($id == $_SESSION['user_id']) {
                header("Location: admin.php?controller=user&action=index&error=Bạn+không+thể tự hạ quyền chính mình!");
                exit;
            }

            if ($this->userModel->updateRole($id, $newRole)) {
                header("Location: admin.php?controller=user&action=index&success=Cập nhật quyền thành công");
            } else {
                header("Location: admin.php?controller=user&action=index&error=Cập nhật thất bại");
            }
            exit;
        }
    }

    // Khóa/Mở tài khoản
    public function toggleStatus() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Prevent self-banning
            if ($id == $_SESSION['user_id']) {
                header("Location: admin.php?controller=user&action=index&error=Bạn+không+thể tự khóa tài khoản của chính mình!");
                exit;
            }

            if ($this->userModel->toggleStatus($id)) {
                header("Location: admin.php?controller=user&action=index&success=Đã thay đổi trạng thái tài khoản");
            } else {
                header("Location: admin.php?controller=user&action=index&error=Thay đổi trạng thái thất bại");
            }
            exit;
        }
    }

    // Xóa tài khoản
    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            if ($id == $_SESSION['user_id']) {
                header("Location: admin.php?controller=user&action=index&error=Bạn+không+thể tự xóa chính mình!");
                exit;
            }

            if ($this->userModel->delete($id)) {
                header("Location: admin.php?controller=user&action=index&success=Đã xóa tài khoản thành công");
            } else {
                header("Location: admin.php?controller=user&action=index&error=Xóa tài khoản thất bại");
            }
            exit;
        }
    }
}
?>
