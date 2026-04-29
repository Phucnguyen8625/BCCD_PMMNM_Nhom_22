<?php
require_once __DIR__ . '/../../config/theme.php';
$themeHienTai = layThemeHienTai();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$tenTrang = 'Kinetic Ink | Riêng tư';

$menuTrai = [
    [
        'ten' => 'Tài khoản',
        'icon' => 'person',
        'link' => 'user.php',
        'active' => false,
    ],
    [
        'ten' => 'Tùy chọn',
        'icon' => 'tune',
        'link' => 'preferences.php',
        'active' => false,
    ],
    [
        'ten' => 'Riêng tư',
        'icon' => 'shield',
        'link' => 'privacy.php',
        'active' => true,
    ],
    [
        'ten' => 'Cài đặt ứng dụng',
        'icon' => 'settings',
        'link' => '../header/setting.php',
        'active' => false,
    ],
];

$tuyChonHienThi = [
    [
        'ten' => 'Công khai cộng đồng',
        'moTa' => 'Thư viện và thành tựu của bạn sẽ hiển thị với cộng đồng.',
        'checked' => true,
    ],
    [
        'ten' => 'Chế độ ẩn',
        'moTa' => 'Chỉ bạn và những biên tập viên được cấp quyền mới xem được hồ sơ đầy đủ.',
        'checked' => false,
    ],
];

$lichSuDangNhap = [
    [
        'thietBi' => 'MacBook Pro',
        'viTri' => 'New York, US',
        'loai' => 'primary',
    ],
    [
        'thietBi' => 'iPhone 15',
        'viTri' => 'London, UK',
        'loai' => 'secondary',
    ],
];

$kiemSoatDuLieu = [
    [
        'icon' => 'download',
        'ten' => 'Xuất kho lưu trữ',
        'moTa' => 'Tải xuống toàn bộ bản ghi JSON về thư viện, giao dịch mua và bình luận của bạn.',
        'thanhTienDo' => true,
    ],
    [
        'icon' => 'history_edu',
        'ten' => 'Thu hồi quyền truy cập bên thứ ba',
        'moTa' => 'Quản lý các ứng dụng đọc truyện bên ngoài và các tiện ích thư viện cộng đồng.',
        'thanhTienDo' => false,
    ],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tenTrang) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/public/settings/privacyStyle.css">
</head>
<body class="theme-<?= htmlspecialchars($themeHienTai) ?>">
    <nav class="topbar">
        <div class="topbar-inner">
            <div class="brand-wrap">
                <div class="brand">KINETIC INK</div>
                <div class="topnav">
                    <a href="../main.php">Marketplace</a>
                    <a href="../header/library.php">Library</a>
                </div>
            </div>

            <div class="top-actions">
                <div class="search-box">
                    <span class="material-symbols-outlined">search</span>
                    <input type="text" placeholder="Tìm kiếm kho lưu trữ...">
                </div>
                <span class="material-symbols-outlined top-icon">notifications</span>
                <span class="material-symbols-outlined top-icon">shopping_basket</span>
                <div class="top-avatar"></div>
            </div>
        </div>
    </nav>

    <div class="layout">
        <aside class="sidebar">
            <div class="sidebar-head">
                <h2>Settings</h2>
                <p>Quản lý trải nghiệm biên tập và mức độ bảo mật dữ liệu của bạn</p>
            </div>

            <nav class="menu">
                <?php foreach ($menuTrai as $menu): ?>
                    <a href="<?= htmlspecialchars($menu['link']) ?>" class="<?= $menu['active'] ? 'active' : '' ?>">
                        <span class="material-symbols-outlined"><?= htmlspecialchars($menu['icon']) ?></span>
                        <span><?= htmlspecialchars($menu['ten']) ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>

            <div class="upgrade-wrap">
                <button class="upgrade-btn" type="button">Upgrade to Premium</button>
            </div>
        </aside>

        <main class="main">
            <header class="page-header">
                <span class="protocol">Protocol: Security</span>
                <h1>Privacy &amp; <span class="accent">Data Integrity</span></h1>
                <p>
                    Kiểm soát cách sự hiện diện sáng tạo của bạn được hiển thị.
                    Chúng tôi xử lý dữ liệu của bạn với độ chính xác như cách một họa sĩ minh họa xử lý từng nét mực trên trang truyện.
                </p>
            </header>

            <div class="grid">
                <section class="left-col">
                    <div class="card visibility-card">
                        <div class="visibility-head">
                            <div>
                                <h3>1. Quyền hiển thị hồ sơ</h3>
                                <p>Xác định ai có thể khám phá bộ sưu tập và hoạt động của bạn.</p>
                            </div>
                            <span class="material-symbols-outlined">visibility</span>
                        </div>

                        <div class="visibility-list">
                            <?php foreach ($tuyChonHienThi as $index => $tuyChon): ?>
                                <label class="visibility-option <?= $tuyChon['checked'] ? 'active' : '' ?>">
                                    <input type="radio" name="visibility" <?= $tuyChon['checked'] ? 'checked' : '' ?>>
                                    <div>
                                        <strong><?= htmlspecialchars($tuyChon['ten']) ?></strong>
                                        <span><?= htmlspecialchars($tuyChon['moTa']) ?></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="security-grid">
                        <div class="card twofa-card">
                            <div>
                                <span class="material-symbols-outlined">verified_user</span>
                                <h4>Xác thực hai lớp</h4>
                                <p>Thêm một lớp bảo vệ mã hóa cho tài khoản của bạn.</p>
                            </div>

                            <button class="twofa-btn" type="button">Bật 2FA</button>
                        </div>

                        <div class="card history-card">
                            <div class="history-top">
                                <h4>Lịch sử đăng nhập</h4>

                                <div class="history-list">
                                    <div class="history-label">
                                        <span>Thiết bị</span>
                                        <span>Vị trí</span>
                                    </div>

                                    <?php foreach ($lichSuDangNhap as $lichSu): ?>
                                        <div class="history-item">
                                            <strong><?= htmlspecialchars($lichSu['thietBi']) ?></strong>
                                            <span class="location-badge <?= htmlspecialchars($lichSu['loai']) ?>">
                                                <?= htmlspecialchars($lichSu['viTri']) ?>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <span class="material-symbols-outlined history-icon">history</span>
                        </div>
                    </div>
                </section>

                <aside class="right-col">
                    <div class="card control-card">
                        <h3>Data Controls</h3>

                        <?php foreach ($kiemSoatDuLieu as $item): ?>
                            <div class="control-item">
                                <div class="control-item-head">
                                    <span class="material-symbols-outlined"><?= htmlspecialchars($item['icon']) ?></span>
                                    <strong><?= htmlspecialchars($item['ten']) ?></strong>
                                </div>
                                <p><?= htmlspecialchars($item['moTa']) ?></p>

                                <?php if ($item['thanhTienDo']): ?>
                                    <div class="control-progress">
                                        <span></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <hr class="control-divider">

                        <div class="danger-zone">
                            <h4>Danger Zone</h4>
                            <button type="button">Permanently Erase Identity</button>
                        </div>
                    </div>

                    <div class="card visual-card">
                        <div class="visual-overlay">
                            <div class="label">Encrypted by Design</div>
                            <p>
                                Mọi khung truyện, mọi nét cọ, đều được bảo vệ bằng các giao thức bảo mật cấp công nghiệp.
                            </p>
                        </div>
                    </div>

                    <div class="card support-card">
                        <div class="support-left">
                            <div class="support-icon">
                                <span class="material-symbols-outlined">support_agent</span>
                            </div>
                            <div class="support-text">
                                <strong>Cần hỗ trợ?</strong>
                                <span>Liên hệ bộ phận vận hành bảo mật</span>
                            </div>
                        </div>

                        <span class="material-symbols-outlined right-arrow">chevron_right</span>
                    </div>
                </aside>
            </div>
        </main>
    </div>

    <script src="../../assets/js/public/settings/privacy.js"></script>
</body>
</html>