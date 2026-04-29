<?php
$configPath = dirname(__DIR__, 2) . '/config/adminConfig.php';
if (file_exists($configPath)) {
    require_once $configPath;
    require_once dirname(__DIR__, 2) . '/config/theme.php';
}

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('requireAdminLogin')) {
    function requireAdminLogin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: ../login.php');
            exit;
        }
    }
}

if (!function_exists('adminCurrentUserName')) {
    function adminCurrentUserName(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $_SESSION['admin_name'] ?? 'Quản trị viên';
    }
}

requireAdminLogin();

$adminName = adminCurrentUserName();
$parts = preg_split('/\s+/u', trim($adminName)) ?: [];
$letters = '';

foreach ($parts as $part) {
    if ($part !== '') {
        $letters .= mb_substr($part, 0, 1, 'UTF-8');
    }

    if (mb_strlen($letters, 'UTF-8') >= 2) {
        break;
    }
}

$adminInitials = mb_strtoupper($letters !== '' ? $letters : 'AD', 'UTF-8');

$currentSection = 'dashboard';
$currentPageTitle = 'Quản trị Mực - Tổng quan';

$pageHeading = 'Tổng quan hệ thống';
$pageDescription = 'Theo dõi nội dung, người dùng và hoạt động quản trị trong một màn hình';

$stats = [
    [
        'title' => 'HỆ THỐNG HÔM NAY',
        'value' => 'Ổn định 99.9%',
        'desc' => 'Không có cảnh báo nghiêm trọng trong 24 giờ qua',
        'tone' => 'stat-orange',
        'span' => 'stat-wide',
        'noteClass' => 'note-green'
    ],
    [
        'title' => 'TỔNG NỘI DUNG',
        'value' => '248',
        'desc' => 'Bài viết và chương truyện đang hoạt động',
        'tone' => 'stat-orange',
        'span' => '',
        'noteClass' => 'note-muted'
    ],
    [
        'title' => 'NGƯỜI DÙNG MỚI',
        'value' => '1.284',
        'desc' => 'Tăng trưởng tài khoản trong 30 ngày gần nhất',
        'tone' => 'stat-dark',
        'span' => '',
        'noteClass' => 'note-muted'
    ],
    [
        'title' => 'TỶ LỆ DUYỆT',
        'value' => '96%',
        'desc' => 'Nội dung được kiểm duyệt đúng hạn',
        'tone' => 'stat-green',
        'span' => '',
        'noteClass' => 'note-muted'
    ],
];

$activities = [
    ['title' => 'Bài viết mới được xuất bản', 'meta' => 'Mục Tin tức · 10 phút trước', 'badge' => 'Mới'],
    ['title' => 'Tài khoản tác giả được xác minh', 'meta' => 'Người dùng · 35 phút trước', 'badge' => 'Xác minh'],
    ['title' => 'Chương truyện Neon Valkyrie cập nhật', 'meta' => 'Nội dung · 1 giờ trước', 'badge' => 'Cập nhật'],
    ['title' => 'Yêu cầu đổi mật khẩu đã xử lý', 'meta' => 'Bảo mật · 2 giờ trước', 'badge' => 'Hoàn tất'],
];

$quickLinks = [
    [
        'title' => 'Quản lý nội dung',
        'desc' => 'Xem danh sách, chỉnh sửa và xuất bản nội dung mới.',
        'href' => '../content/index.php'
    ],
    [
        'title' => 'Thêm nội dung',
        'desc' => 'Tạo nhanh bài viết, thông báo hoặc chương truyện.',
        'href' => '../content/create.php'
    ],
    [
        'title' => 'Quản lý người dùng',
        'desc' => 'Theo dõi thành viên, tác giả và quyền truy cập.',
        'href' => '../users/index.php'
    ],
];

function navItem(string $label, string $icon, string $href, string $key, string $currentSection): string
{
    $activeClass = $key === $currentSection ? 'sidebar-link active' : 'sidebar-link';

    return '
        <a href="' . e($href) . '" class="' . e($activeClass) . '">
            <span class="material-symbols-outlined sidebar-link-icon">' . e($icon) . '</span>
            <span>' . e($label) . '</span>
        </a>
    ';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($currentPageTitle) ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="../../assets/css/admin/adminStyle.css">
    <link rel="stylesheet" href="../../assets/css/admin/dashboard/dashboardStyle.css">
</head>
<body class="theme-<?= e(layThemeHienTai()) ?>" data-theme="<?= e(layThemeHienTai()) ?>">
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-top">
                <h1 class="sidebar-logo">Quản trị Mực</h1>
                <p class="sidebar-subtitle">Điều khiển hệ thống</p>
            </div>

            <nav class="sidebar-nav">
                <?= navItem('Tổng quan', 'dashboard', '../dashboard/index.php', 'dashboard', $currentSection) ?>
                <?= navItem('Nội dung', 'article', '../content/index.php', 'content', $currentSection) ?>
                <?= navItem('Doanh số', 'payments', '../sales/index.php', 'sales', $currentSection) ?>
                <?= navItem('Người dùng', 'group', '../users/index.php', 'users', $currentSection) ?>
                <?= navItem('Cài đặt', 'settings', '../settings/index.php', 'settings', $currentSection) ?>
            </nav>

            <div class="sidebar-bottom">
                <a href="../sales/index.php" class="sidebar-report-btn">Xuất báo cáo</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="topbar-left">
                    <h2 class="page-title"><?= e($pageHeading) ?></h2>
                    <p class="page-desc"><?= e($pageDescription) ?></p>
                </div>

                <div class="topbar-right">
                    <button type="button" class="icon-btn" aria-label="Thông báo">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>

                    <button type="button" class="icon-btn" aria-label="Trợ giúp">
                        <span class="material-symbols-outlined">help</span>
                    </button>

                    <a href="../logout.php" class="logout-btn">
                        <span class="material-symbols-outlined logout-icon">logout</span>
                        <span>Đăng xuất</span>
                    </a>

                    <div class="admin-avatar"><?= e($adminInitials) ?></div>
                </div>
            </header>

            <section class="dashboard-wrapper">
                <div class="stats-grid">
                    <?php foreach ($stats as $item): ?>
                        <div class="stat-card <?= e($item['span']) ?>">
                            <div class="stat-card-content">
                                <p class="stat-label"><?= e($item['title']) ?></p>
                                <h3 class="stat-value <?= e($item['tone']) ?>"><?= e($item['value']) ?></h3>
                                <p class="stat-note <?= e($item['noteClass']) ?>"><?= e($item['desc']) ?></p>
                            </div>

                            <?php if ($item['span'] !== ''): ?>
                                <div class="stat-circle"></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="dashboard-grid">
                    <div class="dashboard-card dashboard-card-large">
                        <div class="card-header">
                            <h3>Hoạt động gần đây</h3>

                            <div class="switch-group">
                                <button type="button" class="switch-btn">Trong ngày</button>
                                <button type="button" class="switch-btn active">Trong tuần</button>
                            </div>
                        </div>

                        <div class="activity-list">
                            <?php foreach ($activities as $item): ?>
                                <div class="activity-item">
                                    <div class="activity-content">
                                        <h4><?= e($item['title']) ?></h4>
                                        <p><?= e($item['meta']) ?></p>
                                    </div>

                                    <span class="activity-badge"><?= e($item['badge']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-header single">
                            <h3>Truy cập nhanh</h3>
                        </div>

                        <div class="quick-links">
                            <?php foreach ($quickLinks as $item): ?>
                                <a href="<?= e($item['href']) ?>" class="quick-link-item">
                                    <div class="quick-link-title"><?= e($item['title']) ?></div>
                                    <div class="quick-link-desc"><?= e($item['desc']) ?></div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <footer class="page-footer">
                    © <?= date('Y') ?> Mực Chuyển Động. Bảo lưu mọi quyền.
                </footer>
            </section>
        </main>
    </div>

    <script src="../../assets/js/admin/admin.js"></script>
    <script src="../../assets/js/admin/dashboard/dashboard.js"></script>
</body>
</html>
