<?php
require_once __DIR__ . '/../../config/theme.php';
$themeHienTai = layThemeHienTai();

$tenTrang = 'Kinetic Ink | Tùy chọn';

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
        'active' => true,
    ],
    [
        'ten' => 'Riêng tư',
        'icon' => 'shield',
        'link' => 'privacy.php',
        'active' => false,
    ],
    [
        'ten' => 'Cài đặt ứng dụng',
        'icon' => 'settings',
        'link' => '../header/setting.php',
        'active' => false,
    ],
];

$danhSachGiaoDien = [
    ['ten' => 'Chế độ sáng', 'lop' => 'light', 'active' => $themeHienTai === 'light'],
    ['ten' => 'Chế độ tối', 'lop' => 'dark', 'active' => $themeHienTai === 'dark'],
    ['ten' => 'Chế độ truyện tranh', 'lop' => 'comic', 'active' => $themeHienTai === 'comic'],
];

$tuyChonDoc = [
    'huongDoc' => 'LTR',
    'chuyenTrang' => 'Chế độ dẫn hướng',
    'zoomHaiLan' => true,
];

$thongBao = [
    [
        'nhom' => 'Phát hành mới',
        'muc' => [
            [
                'ten' => 'Họa sĩ đang theo dõi',
                'moTa' => 'Nhận thông báo khi tác giả bạn yêu thích ra chương mới',
                'push' => true,
                'email' => false,
            ],
        ],
    ],
    [
        'nhom' => 'Xã hội & cộng đồng',
        'muc' => [
            [
                'ten' => 'Phản hồi bình luận',
                'moTa' => 'Luôn theo kịp các cuộc trò chuyện trong từng khung truyện',
                'push' => true,
                'email' => false,
            ],
        ],
    ],
];

$canhBaoBoNho = [
    'dungLuong' => '4.2GB',
    'noiDung' => 'Chế độ đọc ngoại tuyến hiện đang sử dụng 4.2GB dung lượng. Hãy quản lý thư viện cục bộ để giải phóng thêm không gian cho các tập truyện mới.',
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tenTrang) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/public/settings/preferencesStyle.css">
</head>
<body class="theme-<?= htmlspecialchars($themeHienTai) ?>" data-theme="<?= htmlspecialchars($themeHienTai) ?>">
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
            <p>Manage your editorial experience</p>
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
            <button class="upgrade-btn" type="button">
                <span class="material-symbols-outlined upgrade-icon">workspace_premium</span>
                <span>Nâng cấp Premium</span>
            </button>
        </div>

        <div class="sidebar-bottom">
            <a href="#">
                <span class="material-symbols-outlined">help</span>
                <span>Trung tâm hỗ trợ</span>
            </a>

            <a href="../sign/logout.php">
                <span class="material-symbols-outlined">logout</span>
                <span>Đăng xuất</span>
            </a>
        </div>
    </aside>

    <main class="main">
        <div class="container">
            <header class="page-header">
                <h1>USER <span class="accent">OPTIONS</span></h1>
                <p>
                    Tinh chỉnh giao diện Kinetic Ink theo ý bạn.
                    Mọi hiệu ứng chuyển trang, cách đọc và thông báo đều nằm trong tầm kiểm soát của bạn.
                </p>
            </header>

            <div class="grid">
                <section class="left-col">
                    <div class="card">
                        <div class="section-head">
                            <span class="material-symbols-outlined">palette</span>
                            <h3>Bộ giao diện</h3>
                        </div>

                        <div class="theme-grid">
                            <?php foreach ($danhSachGiaoDien as $giaoDien): ?>
                                <div
                                    class="theme-card <?= htmlspecialchars($giaoDien['lop']) ?> <?= $giaoDien['active'] ? 'active' : '' ?>"
                                    data-theme="<?= htmlspecialchars($giaoDien['lop']) ?>"
                                >
                                    <div class="theme-preview <?= htmlspecialchars($giaoDien['lop']) ?>">
                                        <?php if ($giaoDien['lop'] === 'light'): ?>
                                            <div></div>
                                        <?php elseif ($giaoDien['lop'] === 'dark'): ?>
                                            <div></div>
                                        <?php else: ?>
                                            <div class="comic-grid">
                                                <div></div>
                                                <div></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="theme-title"><?= htmlspecialchars($giaoDien['ten']) ?></div>

                                    <?php if ($giaoDien['active']): ?>
                                        <div class="theme-check">
                                            <span class="material-symbols-outlined">check</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="card">
                        <div class="section-head">
                            <span class="material-symbols-outlined">auto_stories</span>
                            <h3>Trải nghiệm đọc</h3>
                        </div>

                        <div class="setting-list">
                            <div class="setting-row">
                                <div>
                                    <h4>Hướng đọc</h4>
                                    <p>Thiết lập luồng đọc mặc định cho các đầu truyện mới</p>
                                </div>

                                <div class="direction-switch">
                                    <button type="button" class="<?= $tuyChonDoc['huongDoc'] === 'LTR' ? 'active' : '' ?>">LTR</button>
                                    <button type="button" class="<?= $tuyChonDoc['huongDoc'] === 'RTL' ? 'active' : '' ?>">RTL</button>
                                </div>
                            </div>

                            <div class="setting-row">
                                <div>
                                    <h4>Hiệu ứng chuyển trang</h4>
                                    <p>Chuyển đổi khung truyện mượt mà hơn khi đọc</p>
                                </div>

                                <select class="transition-select">
                                    <option selected><?= htmlspecialchars($tuyChonDoc['chuyenTrang']) ?></option>
                                    <option>Lật trang cổ điển</option>
                                    <option>Cuộn dọc</option>
                                </select>
                            </div>

                            <div class="setting-row">
                                <div>
                                    <h4>Chạm hai lần để phóng to</h4>
                                    <p>Phóng to chi tiết nét mực ngay lập tức</p>
                                </div>

                                <label class="toggle">
                                    <input type="checkbox" <?= $tuyChonDoc['zoomHaiLan'] ? 'checked' : '' ?>>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </section>

                <aside class="right-col">
                    <div class="card">
                        <div class="section-head">
                            <span class="material-symbols-outlined">notifications_active</span>
                            <h3>Trung tâm cảnh báo</h3>
                        </div>

                        <?php foreach ($thongBao as $nhom): ?>
                            <div class="alert-group">
                                <h4><?= htmlspecialchars($nhom['nhom']) ?></h4>

                                <?php foreach ($nhom['muc'] as $muc): ?>
                                    <div class="alert-item">
                                        <div>
                                            <strong><?= htmlspecialchars($muc['ten']) ?></strong>
                                            <p><?= htmlspecialchars($muc['moTa']) ?></p>
                                        </div>

                                        <div class="alert-actions">
                                            <label>
                                                <input type="checkbox" <?= $muc['push'] ? 'checked' : '' ?>>
                                                <span>Push</span>
                                            </label>

                                            <?php if (array_key_exists('email', $muc)): ?>
                                                <label>
                                                    <input type="checkbox" <?= $muc['email'] ? 'checked' : '' ?>>
                                                    <span>Email</span>
                                                </label>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="visual-card">
                        <div class="tree-shape"></div>

                        <div class="visual-content">
                            <span class="visual-tag">Tính năng mới</span>
                            <h4>CUSP VIEW</h4>
                            <p>Trải nghiệm từng khung truyện theo cách hoàn toàn mới với khả năng hiển thị 4K sắc nét.</p>
                        </div>
                    </div>

                    <div class="storage-card">
                        <div class="storage-wrap">
                            <span class="material-symbols-outlined">info</span>

                            <div>
                                <strong>Cảnh báo bộ nhớ</strong>
                                <p><?= htmlspecialchars($canhBaoBoNho['noiDung']) ?></p>
                                <button type="button">Quản lý thư viện</button>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

            <div class="footer-bar">
                <span class="save-state" id="themeSaveState" aria-live="polite"></span>
                <button class="discard-btn" type="button">Hủy thay đổi</button>
                <button class="save-btn" type="button">Lưu cài đặt</button>
            </div>
        </div>
    </main>
</div>

<script src="../../assets/js/public/settings/preferences.js"></script>
</body>
</html>
