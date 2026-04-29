<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {

    private $userModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new User($this->db);
    }

    // Hiển thị trang đăng nhập
    public function login() {
        $message = '';
        $messageType = '';
        require_once __DIR__ . '/../views/user/auth/login.php';
    }

    // Xử lý POST đăng nhập
    public function processLogin() {
        $message = '';
        $messageType = 'error';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $loginValue = trim($_POST['login_value'] ?? '');
        $password   = trim($_POST['password'] ?? '');

        if (empty($loginValue) || empty($password)) {
            $message = 'Vui lòng nhập đầy đủ thông tin.';
        } else {
            $user = $this->userModel->findByLoginValue($loginValue);
            if (!$user) {
                $message = 'Tài khoản không tồn tại hoặc đã bị khoá.';
            } elseif (!password_verify($password, $user['password'])) {
                $message = 'Sai mật khẩu.';
            } else {
                // Đăng nhập thành công → lưu session
                $_SESSION['user_id']      = $user['id'];
                $_SESSION['user_role']    = $user['role'];
                $_SESSION['user_login']   = [
                    'id'        => $user['id'],
                    'full_name' => $user['full_name'],
                    'username'  => $user['username'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],
                ];

                header('Location: index.php');
                exit;
            }
        }

        // Nếu lỗi → render lại form với thông báo
        require_once __DIR__ . '/../views/user/auth/login.php';
    }

    // Hiển thị trang đăng ký
    public function register() {
        $message = '';
        $messageType = '';
        $oldData = ['ho_ten' => '', 'email' => ''];
        require_once __DIR__ . '/../views/user/auth/register.php';
    }

    // Xử lý POST đăng ký
    public function processRegister() {
        $message = '';
        $messageType = 'error';
        $oldData = [
            'ho_ten' => trim($_POST['ho_ten'] ?? ''),
            'email'  => trim($_POST['email'] ?? ''),
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=auth&action=register');
            exit;
        }

        $ho_ten          = trim($_POST['ho_ten'] ?? '');
        $email           = trim($_POST['email'] ?? '');
        $mat_khau        = trim($_POST['mat_khau'] ?? '');
        $xac_nhan        = trim($_POST['xac_nhan_mat_khau'] ?? '');
        // Tạo username tự động từ email (phần trước @)
        $username = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', explode('@', $email)[0]));

        $errors = [];
        if (empty($ho_ten))   $errors[] = 'Vui lòng nhập họ tên.';
        if (empty($email))    $errors[] = 'Vui lòng nhập email.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email không hợp lệ.';
        if (strlen($mat_khau) < 6) $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        if ($mat_khau !== $xac_nhan) $errors[] = 'Mật khẩu xác nhận không khớp.';

        if (empty($errors)) {
            if ($this->userModel->emailExists($email)) {
                $errors[] = 'Email này đã được đăng ký. Vui lòng dùng email khác.';
            }
            if ($this->userModel->usernameExists($username)) {
                $username .= rand(10, 99); // tránh trùng username
            }
        }

        if (!empty($errors)) {
            require_once __DIR__ . '/../views/user/auth/register.php';
            return;
        }

        if ($this->userModel->register($ho_ten, $username, $email, $mat_khau)) {
            $message = 'Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.';
            $messageType = 'success';
            $oldData = ['ho_ten' => '', 'email' => ''];
        } else {
            $message = 'Đã xảy ra lỗi, vui lòng thử lại.';
        }

        require_once __DIR__ . '/../views/user/auth/register.php';
    }

    // Đăng xuất
    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
?>
