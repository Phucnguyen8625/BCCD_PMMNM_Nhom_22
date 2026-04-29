<?php
require_once __DIR__ . '/../../../config/webConfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['users']) || !is_array($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

if (empty($_SESSION['users'])) {
    $_SESSION['users'][] = [
        'id' => 1,
        'full_name' => 'Nguyễn Bảo',
        'username' => 'user',
        'email' => 'user@gmail.com',
        'password' => password_hash('123456', PASSWORD_DEFAULT),
        'role' => 'user',
        'status' => 'active',
        'is_verified' => true
    ];
}

if (isset($_SESSION['user_login'])) {
    header('Location: ../../header/index.php');
    exit;
}

$message = '';
$messageType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginValue = trim($_POST['login_value'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($loginValue === '' || $password === '') {
        $message = 'Vui lòng nhập đầy đủ thông tin.';
        $messageType = 'error';
    } else {
        $foundUser = null;

        foreach ($_SESSION['users'] as $user) {
            if (
                strtolower($user['email']) === strtolower($loginValue) ||
                strtolower($user['username']) === strtolower($loginValue)
            ) {
                $foundUser = $user;
                break;
            }
        }

        if (!$foundUser) {
            $message = 'Tài khoản không tồn tại.';
            $messageType = 'error';
        } elseif ($foundUser['status'] !== 'active') {
            $message = 'Tài khoản đang bị khóa.';
            $messageType = 'error';
        } elseif (!$foundUser['is_verified']) {
            $message = 'Tài khoản chưa được xác thực.';
            $messageType = 'error';
        } elseif (!password_verify($password, $foundUser['password'])) {
            $message = 'Sai mật khẩu.';
            $messageType = 'error';
        } else {
            $_SESSION['user_login'] = [
                'id' => $foundUser['id'],
                'full_name' => $foundUser['full_name'],
                'username' => $foundUser['username'],
                'email' => $foundUser['email'],
                'role' => $foundUser['role']
            ];

            $_SESSION['user_token'] = bin2hex(random_bytes(16));

            header('Location: ../../header/index.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../../../assets/css/public/authStyle.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-box">
            <div class="auth-box__left">
                <span class="auth-badge">Chào mừng trở lại</span>
                <h1>Đăng nhập tài khoản</h1>
                <p>Đăng nhập để tiếp tục đọc truyện, quản lý hồ sơ cá nhân và theo dõi những bộ truyện yêu thích.</p>

                <?php if ($message !== ''): ?>
                    <div class="auth-alert auth-alert--<?php echo $messageType === 'error' ? 'error' : 'success'; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="auth-box__right">
                <form method="POST" class="auth-form">
                    <div class="auth-form__group">
                        <label for="login_value">Email hoặc tên đăng nhập</label>
                        <input type="text" id="login_value" name="login_value" required>
                    </div>

                    <div class="auth-form__group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="auth-form__row">
                        <a href="forgot-password.php" class="auth-link">Quên mật khẩu?</a>
                    </div>

                    <button type="submit" class="auth-btn auth-btn--primary">Đăng nhập</button>

                    <p class="auth-form__footer">
                        Chưa có tài khoản?
                        <a href="../in/register.php">Đăng ký</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script src="../../../assets/js/public/auth.js"></script>
</body>
</html>
