<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = '';
$messageType = 'success';
$token = trim($_GET['token'] ?? '');

if ($token === '') {
    $message = 'Token xác thực không hợp lệ.';
    $messageType = 'error';
} elseif (!isset($_SESSION['users'])) {
    $message = 'Không có dữ liệu tài khoản.';
    $messageType = 'error';
} else {
    $found = false;

    foreach ($_SESSION['users'] as $index => $user) {
        if (!empty($user['verify_token']) && hash_equals($user['verify_token'], $token)) {
            $_SESSION['users'][$index]['is_verified'] = true;
            $_SESSION['users'][$index]['verify_token'] = null;
            $found = true;
            break;
        }
    }

    if ($found) {
        $message = 'Xác thực tài khoản thành công. Bạn có thể đăng nhập.';
    } else {
        $message = 'Token xác thực không tồn tại hoặc đã hết hiệu lực.';
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực tài khoản</title>
    <link rel="stylesheet" href="../../../assets/css/public/authStyle.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-box auth-box--single">
            <div class="auth-box__right auth-box__right--full">
                <div class="auth-result">
                    <h1>Xác thực tài khoản</h1>
                    <div class="auth-alert auth-alert--<?php echo $messageType === 'error' ? 'error' : 'success'; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                    <a href="login.php" class="auth-btn auth-btn--primary">Đi đến đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
