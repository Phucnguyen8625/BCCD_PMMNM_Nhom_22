<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = '';
$messageType = 'success';

function taoResetToken($length = 32)
{
    return bin2hex(random_bytes($length / 2));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if ($email === '') {
        $message = 'Vui lòng nhập email.';
        $messageType = 'error';
    } else {
        $found = false;

        if (isset($_SESSION['users'])) {
            foreach ($_SESSION['users'] as $index => $user) {
                if (strtolower($user['email']) === strtolower($email)) {
                    $token = taoResetToken();
                    $_SESSION['users'][$index]['reset_token'] = $token;
                    $_SESSION['last_reset_token'] = $token;
                    $_SESSION['last_reset_email'] = $email;
                    $found = true;
                    break;
                }
            }
        }

        if ($found) {
            $message = 'Yêu cầu đặt lại mật khẩu đã được tạo.';
        } else {
            $message = 'Không tìm thấy email trong hệ thống.';
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
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="../../../assets/css/public/authStyle.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-box auth-box--single">
            <div class="auth-box__right auth-box__right--full">
                <form method="POST" class="auth-form">
                    <h1>Quên mật khẩu</h1>
                    <p class="auth-note">Nhập email của bạn để tạo liên kết đặt lại mật khẩu.</p>

                    <?php if ($message !== ''): ?>
                        <div class="auth-alert auth-alert--<?php echo $messageType === 'error' ? 'error' : 'success'; ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['last_reset_token']) && !empty($_SESSION['last_reset_email']) && $messageType !== 'error'): ?>
                        <div class="auth-demo-box">
                            <strong>Liên kết đặt lại mẫu:</strong><br>
                            <a href="reset-password.php?token=<?php echo urlencode($_SESSION['last_reset_token']); ?>">
                                Đặt lại mật khẩu cho <?php echo htmlspecialchars($_SESSION['last_reset_email']); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="auth-form__group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <button type="submit" class="auth-btn auth-btn--primary">Gửi yêu cầu</button>

                    <p class="auth-form__footer">
                        <a href="login.php">Quay lại đăng nhập</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
