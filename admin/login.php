<?php
require_once __DIR__ . '/../config/adminConfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$adminHomeUrl = './dashboard/index.php';

if (isAdminLoggedIn()) {
    header('Location: ' . $adminHomeUrl);
    exit;
}

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

$error = '';
$old = [
    'username' => '',
    'remember' => false,
];

$adminAccounts = [
    [
        'username' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => '123456',
        'name' => 'Quản trị viên',
    ],
];

$userAccounts = [
    [
        'username' => 'user',
        'email' => 'user@gmail.com',
        'password' => '123456',
        'name' => 'Người dùng',
    ],
];

function timTaiKhoan(array $danhSach, string $dangNhap, string $matKhau): ?array
{
    foreach ($danhSach as $taiKhoan) {
        $dungTen = strcasecmp($dangNhap, $taiKhoan['username']) === 0;
        $dungEmail = strcasecmp($dangNhap, $taiKhoan['email']) === 0;
        $dungMatKhau = $matKhau === $taiKhoan['password'];

        if (($dungTen || $dungEmail) && $dungMatKhau) {
            return $taiKhoan;
        }
    }

    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['username'] = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $old['remember'] = !empty($_POST['remember']);

    if ($old['username'] === '' || $password === '') {
        $error = 'Vui lòng nhập đầy đủ tài khoản và mật khẩu.';
    } else {
        $admin = timTaiKhoan($adminAccounts, $old['username'], $password);

        if ($admin !== null) {
            unset($_SESSION['user_logged_in'], $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user'], $_SESSION['user_library']);
            unset($_SESSION['user_login'], $_SESSION['user_token'], $_SESSION['users']);

            adminLogin([
                'username' => $admin['username'],
                'name' => $admin['name'],
            ]);

            $_SESSION['admin_email'] = $admin['email'];

            header('Location: ' . $adminHomeUrl);
            exit;
        }

        if ($user !== null) {
            unset($_SESSION['admin_logged_in'], $_SESSION['admin_username'], $_SESSION['admin_name'], $_SESSION['admin_email']);

            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user'] = [
                'name' => $user['name'],
                'email' => $user['email'],
                'username' => $user['username'],
            ];

            if (!isset($_SESSION['user_library']) || !is_array($_SESSION['user_library'])) {
                $_SESSION['user_library'] = [];
            }

            header('Location: ' . $userHomeUrl);
            exit;
        }

        $error = 'Sai tài khoản hoặc mật khẩu.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập quản trị</title>

    <link rel="stylesheet" href="../assets/css/admin/adminStyle.css">
    <link rel="stylesheet" href="../assets/css/admin/loginStyle.css">
</head>
<body>
    <div class="login-page">
        <div class="login-layout">
            <section class="login-left">
                <div class="login-left__overlay"></div>
                <div class="login-left__content">
                    <div class="login-brand">Kinetic Ink</div>

                    <div class="login-hero">
                        <h1>ADMIN <span>LOGIN</span></h1>
                        <p>
                            Truy cap khu quan tri de quan ly noi dung, doanh thu va nguoi dung tren he thong.
                        </p>
                    </div>

                    <div class="login-left__footer">
                        <div class="login-slider-dots" aria-hidden="true">
                            <span class="active"></span>
                            <span class="medium"></span>
                            <span class="small"></span>
                        </div>

                        <div class="login-issue-card">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 9v4"></path>
                                <path d="M12 17h.01"></path>
                                <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"></path>
                            </svg>
                            <strong>Admin Panel</strong>
                            <span>Secure Access</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="login-right">
                <div class="login-form-shell">
                    <div class="login-form-box">
                        <h1 class="login-title">Dang nhap</h1>
                        <p class="login-subtitle">
                            Su dung tai khoan admin de vao trang quan tri. Tai khoan nguoi dung se duoc chuyen ve giao dien public.
                        </p>

                        <?php if ($error !== ''): ?>
                            <div class="login-error"><?php echo e($error); ?></div>
                        <?php endif; ?>

                        <form method="POST" class="login-form">
                            <div class="login-field">
                                <label for="username">Ten dang nhap hoac email</label>
                                <div class="login-input-wrap">
                                    <input
                                        type="text"
                                        id="username"
                                        name="username"
                                        placeholder="Nhap ten dang nhap hoac email"
                                        value="<?php echo e($old['username']); ?>"
                                        required
                                    >
                                    <span class="login-input-icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 4h16v16H4z" stroke="none"></path>
                                            <path d="M4 7.5 12 13l8-5.5"></path>
                                            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="login-field">
                                <div class="login-field-head">
                                    <label for="password">Mat khau</label>
                                    <a href="../public/sign/up/forgot-password.php">Quen mat khau?</a>
                                </div>
                                <div class="login-input-wrap">
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        placeholder="Nhap mat khau"
                                        required
                                    >
                                    <button type="button" class="login-toggle-password" id="togglePassword" aria-label="Hien mat khau">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <label class="login-remember">
                                <input type="checkbox" name="remember" <?php echo $old['remember'] ? 'checked' : ''; ?>>
                                <span>Ghi nho dang nhap</span>
                            </label>

                            <button type="submit" class="login-submit">
                                Dang nhap
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </button>
                        </form>

                        <div class="login-divider">Hoac</div>

                        <div class="login-social-grid">
                            <a href="<?php echo e($userHomeUrl); ?>" class="login-social-btn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M3 12h18"></path>
                                    <path d="M3 6h18"></path>
                                    <path d="M3 18h18"></path>
                                </svg>
                                Trang doc
                            </a>
                            <a href="<?php echo e($registerUrl); ?>" class="login-social-btn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 5v14"></path>
                                    <path d="M5 12h14"></path>
                                </svg>
                                Dang ky
                            </a>
                        </div>

                        <div class="login-signup">
                            Muon xem giao dien nguoi dung?
                            <a href="<?php echo e($libraryUrl); ?>">Mo thu vien</a>
                        </div>
                    </div>

                    <div class="login-copyright">KINETIC INK ADMIN ACCESS</div>
                </div>
            </section>
        </div>
    </div>
    <script src="../assets/js/admin/login.js"></script>
</body>
</html>
