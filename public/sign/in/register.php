<?php
$pageTitle = 'Đăng ký';
require_once __DIR__ . '/../../../config/webConfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['users']) || !is_array($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

$loi = [];
$thanhCong = '';
$duLieuCu = [
    'ho_ten' => '',
    'email' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $duLieuCu['ho_ten'] = trim($_POST['ho_ten'] ?? '');
    $duLieuCu['email'] = trim($_POST['email'] ?? '');
    $matKhau = trim($_POST['mat_khau'] ?? '');
    $xacNhanMatKhau = trim($_POST['xac_nhan_mat_khau'] ?? '');

    if ($duLieuCu['ho_ten'] === '') {
        $loi[] = 'Vui lòng nhập họ tên.';
    }

    if ($duLieuCu['email'] === '' || !filter_var($duLieuCu['email'], FILTER_VALIDATE_EMAIL)) {
        $loi[] = 'Vui lòng nhập email hợp lệ.';
    }

    if (strlen($matKhau) < 6) {
        $loi[] = 'Mật khẩu cần có ít nhất 6 ký tự.';
    }

    if ($matKhau !== $xacNhanMatKhau) {
        $loi[] = 'Mật khẩu xác nhận không khớp.';
    }

    foreach ($_SESSION['users'] as $user) {
        if (!empty($user['email']) && strtolower($user['email']) === strtolower($duLieuCu['email'])) {
            $loi[] = 'Email này đã được sử dụng.';
            break;
        }
    }

    if (empty($loi)) {
        $userId = count($_SESSION['users']) + 1;
        $username = strstr($duLieuCu['email'], '@', true) ?: $duLieuCu['email'];
        $newUser = [
            'id' => $userId,
            'full_name' => $duLieuCu['ho_ten'],
            'username' => $username,
            'email' => $duLieuCu['email'],
            'password' => password_hash($matKhau, PASSWORD_DEFAULT),
            'role' => 'user',
            'status' => 'active',
            'is_verified' => true,
        ];

        $_SESSION['users'][] = $newUser;
        $_SESSION['user_login'] = [
            'id' => $newUser['id'],
            'full_name' => $newUser['full_name'],
            'username' => $newUser['username'],
            'email' => $newUser['email'],
            'role' => $newUser['role'],
        ];

        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_name'] = $duLieuCu['ho_ten'];
        $_SESSION['user_email'] = $duLieuCu['email'];
        $_SESSION['user'] = [
            'name' => $duLieuCu['ho_ten'],
            'email' => $duLieuCu['email'],
        ];

        header('Location: ../../header/index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="../../../assets/css/public/sign/in/registerStyle.css">
</head>
<body>
    <div class="page-shell">
        <header class="topbar">
            <div class="topbar-inner">
                <div class="brand">Kinetic Ink</div>

                <nav class="nav">
                    <a href="../../header/index.php">Khám phá</a>
                    <a href="../../header/library.php">Thư viện</a>
                    <a href="../../header/storyMarket.php">Chợ truyện</a>
                </nav>

                <div class="tools">
                    <input class="search-box" type="text" placeholder="Tìm kiếm truyện...">
                    <span class="tool-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </span>
                    <span class="tool-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21a8 8 0 1 0-16 0"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </span>
                </div>
            </div>
        </header>

        <main class="main">
            <div class="register-card">
                <section class="visual-panel">
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAFQYYhnSnLsu3pKL_BMDkDvapwDT4V9acLwGAJyz8qKAV93u0MSNuNWntft15EwkeJrfLnEHmyy-sdgIHqQ9LUwydxet9mrMchlLXejQhj3OtAB0oQoojgp8i9WFy-E3rhoEQ19WzBWEiJrFPmSgiSZsWaExCHNzL1QxxBHYoeSeK5XXWrs02NMJBuBlb939hFbAaWDZLBn0puL1WtVE7Doh5DJoePW-yjL_egLg9kVvS-qYw4RghhlMFcQbDnee-x9sxFTP1t9VqK" alt="Minh họa nghệ sĩ truyện tranh đang làm việc bên bàn vẽ phát sáng">
                    <div class="visual-overlay"></div>

                    <div class="visual-content">
                        <div class="visual-badge">Tạo tài khoản người dùng</div>

                        <h1 class="visual-title">Bắt đầu hành trình đọc truyện theo phong cách của <span class="accent">bạn.</span></h1>
                        <p class="visual-text">
                            Sau khi đăng ký, người dùng sẽ được đưa thẳng vào giao diện người dùng để xem thư viện, truyện chi tiết, chợ truyện và tủ truyện cá nhân.
                        </p>

                        <div class="visual-lines" aria-hidden="true">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                        <p class="visual-paragraph">
                            Tạo tài khoản để bắt đầu trải nghiệm không gian đọc truyện trực quan, hiện đại và đồng bộ.
                            Sau khi đăng ký, người dùng có thể dễ dàng khám phá thư viện truyện, theo dõi nội dung yêu thích
                            và sử dụng các chức năng chính trong giao diện một cách thuận tiện hơn.
                        </p>

                        <div class="visual-note" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 4h6a4 4 0 0 1 4 4v12a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 4h-6a4 4 0 0 0-4 4v12a3 3 0 0 1 3-3h7z"></path>
                            </svg>
                            <span>Mục #402</span>
                        </div>
                    </div>
                </section>

                <section class="form-panel">
                    <div class="form-inner">
                        <h2 class="form-title">Đăng ký tài khoản</h2>
                        <p class="form-desc">Điền thông tin bên dưới để tạo tài khoản người dùng mới.</p>

                        <?php if (!empty($loi)): ?>
                            <div class="message error">
                                <ul>
                                    <?php foreach ($loi as $item): ?>
                                        <li><?php echo e($item); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if ($thanhCong !== ''): ?>
                            <div class="message success"><?php echo e($thanhCong); ?></div>
                        <?php endif; ?>

                        <form method="post">
                            <div class="field">
                                <label for="ho_ten">Họ tên</label>
                                <div class="input-wrap">
                                    <svg class="left-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21a8 8 0 1 0-16 0"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="ho_ten" type="text" name="ho_ten" value="<?php echo e($duLieuCu['ho_ten']); ?>" placeholder="Nhập họ tên của bạn">
                                </div>
                            </div>

                            <div class="field">
                                <label for="email">Email</label>
                                <div class="input-wrap">
                                    <svg class="left-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 4h16v16H4z" stroke="none"></path>
                                        <circle cx="12" cy="12" r="4"></circle>
                                        <path d="M16 8v.2a4 4 0 1 1-4-4h.2"></path>
                                    </svg>
                                    <input id="email" type="email" name="email" value="<?php echo e($duLieuCu['email']); ?>" placeholder="Nhập email của bạn">
                                </div>
                            </div>

                            <div class="field">
                                <div class="field-row">
                                    <label for="mat_khau">Mật khẩu</label>
                                </div>
                                <div class="input-wrap">
                                    <svg class="left-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="5" y="11" width="14" height="10" rx="2"></rect>
                                        <path d="M8 11V8a4 4 0 1 1 8 0v3"></path>
                                    </svg>
                                    <input id="mat_khau" class="password-input" type="password" name="mat_khau" placeholder="Tối thiểu 6 ký tự">
                                    <span class="eye" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </span>
                                </div>
                                <div class="field-help">Mật khẩu cần có ít nhất 6 ký tự.</div>
                            </div>

                            <div class="field">
                                <label for="xac_nhan_mat_khau">Xác nhận mật khẩu</label>
                                <div class="input-wrap">
                                    <svg class="left-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="5" y="11" width="14" height="10" rx="2"></rect>
                                        <path d="M8 11V8a4 4 0 1 1 8 0v3"></path>
                                    </svg>
                                    <input id="xac_nhan_mat_khau" class="password-input" type="password" name="xac_nhan_mat_khau" placeholder="Nhập lại mật khẩu">
                                    <span class="eye" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <label class="consent">
                                <input type="checkbox">
                                <span>Đã có tài khoản? <a href="../up/login.php">Đăng nhập</a></span>
                            </label>

                            <button type="submit" class="submit-btn">
                                Tạo tài khoản
                                <span class="arrow-box" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </span>
                            </button>
                        </form>

                        <div class="divider">Hoặc kết nối qua</div>

                        <div class="social-grid">
                            <div class="social-btn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.94 11A9 9 0 1 0 12 21a8.5 8.5 0 0 0 8.94-8z"></path>
                                    <path d="M12 12v5"></path>
                                    <path d="M8.5 8.5h7"></path>
                                </svg>
                                Google
                            </div>
                            <div class="social-btn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 18 12-12"></path>
                                    <path d="m14 6 4 4"></path>
                                    <path d="M5 19h4"></path>
                                </svg>
                                ArtStation
                            </div>
                        </div>

                        <div class="bottom-note">
                            Đã có tài khoản? <a href="../up/login.php">Đăng nhập</a>
                        </div>
                    </div>
                </section>
            </div>
        </main>

        <footer class="site-footer">
            <div class="site-footer-inner">
                <div>
                    <div class="footer-brand">Kinetic Ink</div>
                    <div class="footer-copy">© 2024 Kinetic Ink. Bảo lưu mọi quyền.</div>
                </div>

                <div class="footer-links">
                    <a href="#">Điều khoản</a>
                    <a href="#">Bảo mật</a>
                    <a href="#">Hỗ trợ</a>
                    <a href="#">Liên hệ</a>
                </div>
            </div>
        </footer>
    </div>

    <script src="../../../assets/js/public/register.js"></script>
</body>
</html>
