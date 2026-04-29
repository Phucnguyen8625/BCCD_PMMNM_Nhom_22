<?php
require_once __DIR__ . '/../../config/auth.php';
batBuocDangNhap();

require_once __DIR__ . '/../../config/theme.php';
$themeHienTai = layThemeHienTai();

$trangTieuDe = 'The Kinetic Ink - Cài đặt & Cấu hình';

$danhSachMenu = [
    ['ten' => 'Tài khoản','icon' => 'person','link' => '../settings/user.php','active' => false],
    ['ten' => 'Tùy chọn','icon' => 'tune','link' => '../settings/preferences.php','active' => false],
    ['ten' => 'Riêng tư','icon' => 'shield','link' => '../settings/privacy.php','active' => false],
    ['ten' => 'Cài đặt ứng dụng','icon' => 'settings','link' => '#','active' => true],
    ['ten' => 'Đăng xuất','icon' => 'logout','link' => '../sign/logout.php','active' => false],
];

$danhSachCheDoDoc = [
    ['ten' => 'Khung động','icon' => 'view_column','active' => true],
    ['ten' => 'Trang đôi','icon' => 'menu_book','active' => false],
    ['ten' => 'Cuộn webtoon','icon' => 'vertical_align_bottom','active' => false],
];

$duongDanThuVien = [
    ['icon' => 'hard_drive','ten' => 'Kho truyện chính','duongDan' => 'C:/Users/Creative/Documents/KineticInk/Library/','loai' => 'dung_luong','nhan' => 'Dung lượng','giaTri' => '428 GB / 600 GB','phanTram' => 65],
    ['icon' => 'cloud','ten' => 'Kho đồng bộ đám mây','duongDan' => '/mnt/share/cloud_comics/ink_sync','loai' => 'dong_bo','nhan' => 'Trạng thái đồng bộ','giaTri' => 'Đã đồng bộ'],
];

$ngonNguHeThong = ['Tiếng Việt','Tiếng Anh (Biên tập toàn cầu)','Tiếng Nhật','Tiếng Pháp','Tiếng Tây Ban Nha'];
$dinhDangKhuVuc = ['Việt Nam (VND)','Hoa Kỳ (USD)','Liên minh Châu Âu (EUR)','Nhật Bản (JPY)'];

$capNhatUngDung = [
    'phienBan' => 'v.2.4.0',
    'lanKiemTraCuoi' => '12 phút trước',
    'trangThai' => 'Ổn định',
    'tinhNang' => [
        'Tăng cường hiển thị nét mực cho màn hình HDR',
        'Tối ưu hóa lập chỉ mục thư viện cục bộ',
    ],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($trangTieuDe) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/public/header/settingStyle.css">
</head>
<body class="theme-<?= htmlspecialchars($themeHienTai) ?>">
    <header class="topbar">
        <div class="logo">The Kinetic Ink</div>

        <nav class="top-nav">
            <a href="storyMarket.php">Chợ truyện</a>
            <a href="library.php">Thư viện</a>
            <a href="#">Cộng đồng</a>
        </nav>

        <div class="top-actions">
            <div class="search-box">
                <span class="material-symbols-outlined">search</span>
                <input type="text" placeholder="Tìm kiếm tùy chọn...">
            </div>

            <button class="icon-btn" type="button">
                <span class="material-symbols-outlined">notifications</span>
            </button>

            <div class="avatar">
                <span class="material-symbols-outlined">person</span>
            </div>
        </div>
    </header>

    <div class="wrapper">
        <aside class="sidebar">
            <div class="sidebar-head">
                <h2>The Comic Plate</h2>
                <p>Số #01 - Cài đặt</p>
            </div>

            <nav class="menu">
                <?php foreach ($danhSachMenu as $menu): ?>
                    <a href="<?= htmlspecialchars($menu['link']) ?>" class="<?= $menu['active'] ? 'active' : '' ?>">
                        <span class="material-symbols-outlined"><?= htmlspecialchars($menu['icon']) ?></span>
                        <span><?= htmlspecialchars($menu['ten']) ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>

            <div class="sidebar-card">
                <div class="sidebar-card-top">
                    <div class="sidebar-card-icon">
                        <span class="material-symbols-outlined">auto_stories</span>
                    </div>
                    <div>
                        <h4>Người đọc Pro</h4>
                        <p>Đăng ký đến năm 2025</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="main">
            <div class="halftone-bg"></div>
            <div class="content">
                <header class="page-header">
                    <h1>Cài đặt & Cấu hình</h1>
                    <div class="page-line"></div>
                    <p>Cấu hình bộ máy đọc truyện, quản lý kho lưu trữ truyện tranh cục bộ và luôn cập nhật nền tảng Kinetic Ink với những tính năng biên tập mới nhất.</p>
                </header>

                <div class="grid">
                    <section class="card general-card">
                        <div class="section-title">
                            <span class="material-symbols-outlined">tune</span>
                            <h2>Thiết lập chung</h2>
                        </div>

                        <div class="form-grid">
                            <div class="field">
                                <label>Ngôn ngữ hệ thống</label>
                                <div class="select-wrap">
                                    <select>
                                        <?php foreach ($ngonNguHeThong as $ngonNgu): ?>
                                            <option><?= htmlspecialchars($ngonNgu) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="material-symbols-outlined">expand_more</span>
                                </div>
                            </div>

                            <div class="field">
                                <label>Định dạng khu vực</label>
                                <div class="select-wrap">
                                    <select>
                                        <?php foreach ($dinhDangKhuVuc as $khuVuc): ?>
                                            <option><?= htmlspecialchars($khuVuc) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="material-symbols-outlined">public</span>
                                </div>
                            </div>

                            <div class="field full-width">
                                <label>Chế độ đọc mặc định</label>
                                <div class="reader-grid">
                                    <?php foreach ($danhSachCheDoDoc as $cheDo): ?>
                                        <button type="button" class="reader-btn <?= $cheDo['active'] ? 'active' : '' ?>">
                                            <span class="material-symbols-outlined"><?= htmlspecialchars($cheDo['icon']) ?></span>
                                            <span><?= htmlspecialchars($cheDo['ten']) ?></span>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="card update-card">
                        <div>
                            <div class="update-top">
                                <h2>Cập nhật ứng dụng</h2>
                                <span class="badge"><?= htmlspecialchars($capNhatUngDung['trangThai']) ?></span>
                            </div>

                            <div class="version"><?= htmlspecialchars($capNhatUngDung['phienBan']) ?></div>
                            <div class="last-check">Lần kiểm tra cuối: <?= htmlspecialchars($capNhatUngDung['lanKiemTraCuoi']) ?></div>

                            <div class="update-list">
                                <?php foreach ($capNhatUngDung['tinhNang'] as $tinhNang): ?>
                                    <div class="update-item">
                                        <span class="material-symbols-outlined">check_circle</span>
                                        <span><?= htmlspecialchars($tinhNang) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <button class="btn-update" type="button">
                            Kiểm tra cập nhật
                            <span class="material-symbols-outlined">sync</span>
                        </button>
                    </section>

                    <section class="card library-card">
                        <div class="library-head">
                            <div class="section-title section-title-inline">
                                <span class="material-symbols-outlined">folder_managed</span>
                                <h2>Đường dẫn thư viện</h2>
                            </div>

                            <button class="btn-blue" type="button">
                                <span class="material-symbols-outlined">add_circle</span>
                                Thêm thư mục nguồn
                            </button>
                        </div>

                        <div class="path-list">
                            <?php foreach ($duongDanThuVien as $muc): ?>
                                <div class="path-item">
                                    <div class="path-left">
                                        <div class="path-icon">
                                            <span class="material-symbols-outlined"><?= htmlspecialchars($muc['icon']) ?></span>
                                        </div>

                                        <div class="path-info">
                                            <h3><?= htmlspecialchars($muc['ten']) ?></h3>
                                            <code><?= htmlspecialchars($muc['duongDan']) ?></code>
                                        </div>
                                    </div>

                                    <div class="path-right">
                                        <div class="path-meta">
                                            <p><?= htmlspecialchars($muc['nhan']) ?></p>

                                            <?php if ($muc['loai'] === 'dung_luong'): ?>
                                                <div class="capacity-bar">
                                                    <div class="capacity-fill" style="width: <?= (int)$muc['phanTram'] ?>%;"></div>
                                                </div>
                                                <div class="meta-value"><?= htmlspecialchars($muc['giaTri']) ?></div>
                                            <?php else: ?>
                                                <div class="sync-status">
                                                    <span class="sync-dot"></span>
                                                    <span><?= htmlspecialchars($muc['giaTri']) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <button class="delete-btn" type="button">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>

                    <section class="action-card orange">
                        <div class="action-content">
                            <h3>Xuất<br>Cấu hình</h3>
                            <p>Sao lưu metadata và cấu trúc thư viện chỉ với một lần nhấn.</p>
                        </div>
                        <button class="action-btn" type="button">
                            <span class="material-symbols-outlined">download</span>
                        </button>
                    </section>

                    <section class="action-card blue">
                        <div class="action-content">
                            <h3>Bảng điều khiển<br>Nhà phát triển</h3>
                            <p>Truy cập tham số nâng cao của bộ máy hiển thị và nhật ký hệ thống.</p>
                        </div>
                        <button class="action-btn" type="button">
                            <span class="material-symbols-outlined">terminal</span>
                        </button>
                    </section>
                </div>

                <footer class="footer">
                    <p>Kinetic Ink Framework © 2024</p>
                    <div class="footer-links">
                        <a href="#">Chính sách riêng tư</a>
                        <a href="#">Cổng hỗ trợ</a>
                    </div>
                </footer>
            </div>
        </main>
    </div>

    <script src="../../assets/js/public/header/setting.js"></script>
</body>
</html>