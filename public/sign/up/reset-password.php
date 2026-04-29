<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = '';
$messageType = 'success';
$token = trim($_GET['token'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = trim($_POST['token'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    if ($token === '') {
        $message = 'Token đặt lại không hợp lệ.';
        $messageType = 'error';
    } elseif ($password === '' || $confirmPassword === '') {
        $message = 'Vui lòng nhập đầy đủ mật khẩu mới.';
        $messageType = 'error';
    } elseif (strlen($password) < 6) {
        $message = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
        $messageType = 'error';
    } elseif ($password !== $confirmPassword) {
        $message = 'Mật khẩu xác nhận không khớp.';
        $messageType = 'error';
    } else {
        $found = false;

        if (isset($_SESSION['users']) && is_array($_SESSION['users'])) {
            foreach ($_SESSION['users'] as $index => $user) {
                if (!empty($user['reset_token']) && hash_equals($user['reset_token'], $token)) {
                    $_SESSION['users'][$index]['password'] = password_hash($password, PASSWORD_DEFAULT);
                    $_SESSION['users'][$index]['reset_token'] = null;
                    $found = true;
                    break;
                }
            }
        }

        if ($found) {
            $message = 'Đặt lại mật khẩu thành công. Bạn có thể đăng nhập lại.';
        } else {
            $message = 'Token đặt lại không tồn tại hoặc đã hết hiệu lực.';
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
    <link rel="stylesheet" href="../../../assets/css/public/authStyle.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-box auth-box--single">
            <div class="auth-box__right auth-box__right--full">
                <form method="POST" class="auth-form">
                    <h1>Đặt lại mật khẩu</h1>

                    <?php if ($message !== ''): ?>
                        <div class="auth-alert auth-alert--<?php echo $messageType === 'error' ? 'error' : 'success'; ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                    <div class="auth-form__group">
                        <label for="password">Mật khẩu mới</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="auth-form__group">
                        <label for="confirm_password">Xác nhận mật khẩu mới</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>

                    <button type="submit" class="auth-btn auth-btn--primary">Cập nhật mật khẩu</button>

                    <p class="auth-form__footer">
                        <a href="login.php">Quay lại đăng nhập</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
