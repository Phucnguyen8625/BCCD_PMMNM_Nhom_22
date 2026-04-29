<?php
require_once __DIR__ . '/../../config/theme.php';
$themeHienTai = layThemeHienTai();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$tenTrang = 'Kinetic Ink | Tài khoản';

$menuTrai = [
    [
        'ten' => 'Tài khoản',
        'icon' => 'person',
        'link' => 'user.php',
        'active' => true,
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
        'active' => false,
    ],
    [
        'ten' => 'Cài đặt ứng dụng',
        'icon' => 'settings',
        'link' => '../header/setting.php',
        'active' => false,
    ],
];

$thongTinNguoiDung = [
    'id' => 1,
    'full_name' => 'Nguyễn Bảo',
    'username' => 'user',
    'email' => 'user@gmail.com',
    'password' => password_hash('123456', PASSWORD_DEFAULT),
    'role' => 'user',
    'status' => 'active',
    'is_verified' => true,
    'phone' => '',
    'address' => '',
    'avatar' => '/assets/images/avatars/default-avatar.png'
];

if (!isset($_SESSION['users']) || !is_array($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

if (!isset($_SESSION['user_login']) || !is_array($_SESSION['user_login'])) {
    $_SESSION['user_login'] = [
        'id' => $thongTinNguoiDung['id'],
        'full_name' => $thongTinNguoiDung['full_name'],
        'username' => $thongTinNguoiDung['username'],
        'email' => $thongTinNguoiDung['email'],
        'password' => $thongTinNguoiDung['password'],
        'role' => $thongTinNguoiDung['role'],
        'status' => $thongTinNguoiDung['status'],
        'is_verified' => $thongTinNguoiDung['is_verified'],
        'phone' => $thongTinNguoiDung['phone'],
        'address' => $thongTinNguoiDung['address'],
        'avatar' => $thongTinNguoiDung['avatar']
    ];
}

if (empty($_SESSION['users'])) {
    $_SESSION['users'][] = $_SESSION['user_login'];
}

$nguoiDungDangNhap = $_SESSION['user_login'];
$viTriNguoiDung = null;

foreach ($_SESSION['users'] as $index => $user) {
    if (($user['id'] ?? 0) == ($nguoiDungDangNhap['id'] ?? 0)) {
        $viTriNguoiDung = $index;
        break;
    }
}

if ($viTriNguoiDung === null) {
    $_SESSION['users'][] = $nguoiDungDangNhap;
    $viTriNguoiDung = array_key_last($_SESSION['users']);
}

if (!isset($_SESSION['users'][$viTriNguoiDung]['phone'])) {
    $_SESSION['users'][$viTriNguoiDung]['phone'] = '';
}
if (!isset($_SESSION['users'][$viTriNguoiDung]['address'])) {
    $_SESSION['users'][$viTriNguoiDung]['address'] = '';
}
if (!isset($_SESSION['users'][$viTriNguoiDung]['avatar']) || $_SESSION['users'][$viTriNguoiDung]['avatar'] === '') {
    $_SESSION['users'][$viTriNguoiDung]['avatar'] = '/assets/images/avatars/default-avatar.png';
}

$thongBaoHoSo = '';
$loaiThongBaoHoSo = '';
$thongBaoMatKhau = '';
$loaiThongBaoMatKhau = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cap_nhat_ho_so'])) {
        $hoTen = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $soDienThoai = trim($_POST['phone'] ?? '');
        $diaChi = trim($_POST['address'] ?? '');

        if ($hoTen === '' || $email === '') {
            $thongBaoHoSo = 'Họ tên và email không được để trống.';
            $loaiThongBaoHoSo = 'error';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $thongBaoHoSo = 'Email không hợp lệ.';
            $loaiThongBaoHoSo = 'error';
        } else {
            $emailDaTonTai = false;

            foreach ($_SESSION['users'] as $i => $user) {
                if (
                    $i !== $viTriNguoiDung &&
                    isset($user['email']) &&
                    strtolower($user['email']) === strtolower($email)
                ) {
                    $emailDaTonTai = true;
                    break;
                }
            }

            if ($emailDaTonTai) {
                $thongBaoHoSo = 'Email này đã được sử dụng.';
                $loaiThongBaoHoSo = 'error';
            } else {
                $_SESSION['users'][$viTriNguoiDung]['full_name'] = $hoTen;
                $_SESSION['users'][$viTriNguoiDung]['email'] = $email;
                $_SESSION['users'][$viTriNguoiDung]['phone'] = $soDienThoai;
                $_SESSION['users'][$viTriNguoiDung]['address'] = $diaChi;

                $_SESSION['user_login']['full_name'] = $hoTen;
                $_SESSION['user_login']['email'] = $email;
                $_SESSION['user_login']['phone'] = $soDienThoai;
                $_SESSION['user_login']['address'] = $diaChi;

                $thongBaoHoSo = 'Cập nhật hồ sơ thành công.';
                $loaiThongBaoHoSo = 'success';
            }
        }
    }

    if (isset($_POST['cap_nhat_avatar'])) {
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] === UPLOAD_ERR_NO_FILE) {
            $thongBaoHoSo = 'Vui lòng chọn ảnh đại diện.';
            $loaiThongBaoHoSo = 'error';
        } elseif ($_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            $thongBaoHoSo = 'Tải ảnh lên thất bại.';
            $loaiThongBaoHoSo = 'error';
        } else {
            $tep = $_FILES['avatar'];
            $tenTep = $tep['name'];
            $tepTam = $tep['tmp_name'];
            $kichThuoc = $tep['size'];
            $duoiTep = strtolower(pathinfo($tenTep, PATHINFO_EXTENSION));
            $duoiHopLe = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (!in_array($duoiTep, $duoiHopLe, true)) {
                $thongBaoHoSo = 'Chỉ chấp nhận JPG, JPEG, PNG, GIF, WEBP.';
                $loaiThongBaoHoSo = 'error';
            } elseif ($kichThuoc > 2 * 1024 * 1024) {
                $thongBaoHoSo = 'Ảnh đại diện không được vượt quá 2MB.';
                $loaiThongBaoHoSo = 'error';
            } else {
                $thuMucTaiLen = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/avatars/';

                if (!is_dir($thuMucTaiLen)) {
                    mkdir($thuMucTaiLen, 0777, true);
                }

                $tenMoi = 'avatar_' . ($_SESSION['users'][$viTriNguoiDung]['id'] ?? time()) . '_' . time() . '.' . $duoiTep;
                $duongDanDayDu = $thuMucTaiLen . $tenMoi;
                $duongDanLuu = '/assets/images/avatars/' . $tenMoi;

                if (move_uploaded_file($tepTam, $duongDanDayDu)) {
                    $avatarCu = $_SESSION['users'][$viTriNguoiDung]['avatar'] ?? '/assets/images/avatars/default-avatar.png';

                    $_SESSION['users'][$viTriNguoiDung]['avatar'] = $duongDanLuu;
                    $_SESSION['user_login']['avatar'] = $duongDanLuu;

                    if (
                        $avatarCu !== '/assets/images/avatars/default-avatar.png' &&
                        !empty($avatarCu) &&
                        file_exists($_SERVER['DOCUMENT_ROOT'] . $avatarCu)
                    ) {
                        @unlink($_SERVER['DOCUMENT_ROOT'] . $avatarCu);
                    }

                    $thongBaoHoSo = 'Cập nhật ảnh đại diện thành công.';
                    $loaiThongBaoHoSo = 'success';
                } else {
                    $thongBaoHoSo = 'Không thể lưu ảnh đại diện.';
                    $loaiThongBaoHoSo = 'error';
                }
            }
        }
    }

    if (isset($_POST['doi_mat_khau'])) {
        $matKhauHienTai = trim($_POST['current_password'] ?? '');
        $matKhauMoi = trim($_POST['new_password'] ?? '');
        $xacNhanMatKhau = trim($_POST['confirm_password'] ?? '');

        $matKhauDangLuu = $_SESSION['users'][$viTriNguoiDung]['password'] ?? '';

        if ($matKhauHienTai === '' || $matKhauMoi === '' || $xacNhanMatKhau === '') {
            $thongBaoMatKhau = 'Vui lòng nhập đầy đủ thông tin mật khẩu.';
            $loaiThongBaoMatKhau = 'error';
        } elseif (!password_verify($matKhauHienTai, $matKhauDangLuu)) {
            $thongBaoMatKhau = 'Mật khẩu hiện tại không đúng.';
            $loaiThongBaoMatKhau = 'error';
        } elseif (strlen($matKhauMoi) < 6) {
            $thongBaoMatKhau = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
            $loaiThongBaoMatKhau = 'error';
        } elseif ($matKhauMoi !== $xacNhanMatKhau) {
            $thongBaoMatKhau = 'Xác nhận mật khẩu không khớp.';
            $loaiThongBaoMatKhau = 'error';
        } else {
            $matKhauMaHoa = password_hash($matKhauMoi, PASSWORD_DEFAULT);
            $_SESSION['users'][$viTriNguoiDung]['password'] = $matKhauMaHoa;
            $_SESSION['user_login']['password'] = $matKhauMaHoa;

            $thongBaoMatKhau = 'Đổi mật khẩu thành công.';
            $loaiThongBaoMatKhau = 'success';
        }
    }
}

$thongTinNguoiDung = array_merge($thongTinNguoiDung, $_SESSION['users'][$viTriNguoiDung]);

if (!isset($thongTinNguoiDung['ten'])) {
    $thongTinNguoiDung['ten'] = $thongTinNguoiDung['full_name'] ?? 'Người dùng';
}
if (!isset($thongTinNguoiDung['vaiTro'])) {
    $thongTinNguoiDung['vaiTro'] = !empty($thongTinNguoiDung['is_verified']) ? 'ĐÃ XÁC MINH' : 'CHƯA XÁC MINH';
}
if (!isset($thongTinNguoiDung['capDo'])) {
    $thongTinNguoiDung['capDo'] = 12;
}
if (!isset($thongTinNguoiDung['phanTram'])) {
    $thongTinNguoiDung['phanTram'] = 72;
}
if (!isset($thongTinNguoiDung['xpConLai'])) {
    $thongTinNguoiDung['xpConLai'] = 'Còn 280 XP để đạt cấp độ tiếp theo.';
}

$goiThanhVien = [
    'ten' => 'PRO READER',
    'moTa' => 'Truy cập không giới hạn vào kho truyện và được xem sớm các đợt phát hành truyện hằng tuần.',
    'ngayGiaHan' => '12/10/2024',
];

$taiKhoanLienKet = [
    [
        'ten' => 'Google',
        'trangThai' => 'Đã kết nối với alex.c_ink',
        'hanhDong' => 'Ngắt kết nối',
        'kieu' => 'disconnect',
        'svg' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.35,11.1H12.18V13.83H18.69C18.36,17.64 15.19,19.27 12.19,19.27C8.36,19.27 5.05,16.22 5.05,12C5.05,7.78 8.36,4.73 12.19,4.73C15.31,4.73 17.1,6.7 17.1,6.7L19,4.72C19,4.72 16.56,2 12.1,2C6.42,2 2.03,6.8 2.03,12C2.03,17.05 6.16,22 12.25,22C17.6,22 21.5,18.33 21.5,12.91C21.5,11.76 21.35,11.1 21.35,11.1V11.1Z" fill="currentColor"></path></svg>',
    ],
    [
        'ten' => 'Facebook',
        'trangThai' => 'Chưa kết nối',
        'hanhDong' => 'Kết nối',
        'kieu' => 'connect',
        'svg' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96C18.34 21.21 22 17.06 22 12.06C22 6.53 17.5 2.04 12 2.04Z" fill="currentColor"></path></svg>',
    ],
];

$baoMat = [
    [
        'icon' => 'phonelink_lock',
        'ten' => 'Xác thực hai lớp',
        'loai' => 'badge',
        'badge' => 'ĐANG BẬT',
    ],
    [
        'icon' => 'key',
        'ten' => 'Đổi mật khẩu',
        'loai' => 'toggle-password',
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
    <link rel="stylesheet" href="../../assets/css/public/settings/userStyle.css">
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
                    <h1>ACCOUNT <span class="accent">CENTER</span></h1>
                    <p>
                        Quản lý thông tin tài khoản, bảo mật và các liên kết mạng xã hội của bạn
                        trong cùng một không gian đồng bộ với hệ giao diện Kinetic Ink.
                    </p>
                </header>

                <div class="grid">
                    <section class="left-col">
                        <div class="card profile-card">
                            <div class="profile-wrap">
                                <div class="profile-photo-box">
                                    <div class="profile-photo">
                                        <img src="<?= htmlspecialchars($thongTinNguoiDung['avatar'] ?? '/assets/images/avatars/default-avatar.png') ?>" alt="Ảnh đại diện">
                                    </div>
                                    <button class="edit-photo-btn" type="button">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                </div>

                                <div class="profile-content">
                                    <div class="profile-head">
                                        <div>
                                            <h3><?= htmlspecialchars($thongTinNguoiDung['ten']) ?></h3>
                                            <p><?= htmlspecialchars($thongTinNguoiDung['email']) ?></p>
                                        </div>
                                        <span class="verified-badge"><?= htmlspecialchars($thongTinNguoiDung['vaiTro']) ?></span>
                                    </div>

                                    <div class="level-box">
                                        <div class="level-top">
                                            <span>Ink Level</span>
                                            <span>LVL <?= (int) $thongTinNguoiDung['capDo'] ?></span>
                                        </div>

                                        <div class="progress">
                                            <div class="progress-fill" style="width: <?= (int) $thongTinNguoiDung['phanTram'] ?>%;"></div>
                                        </div>

                                        <div class="level-note"><?= htmlspecialchars($thongTinNguoiDung['xpConLai']) ?></div>
                                    </div>

                                    <?php if ($thongBaoHoSo !== ''): ?>
                                        <div class="form-alert <?= htmlspecialchars($loaiThongBaoHoSo) ?>">
                                            <?= htmlspecialchars($thongBaoHoSo) ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="contact-info-box">
                                        <div class="contact-row">
                                            <span class="material-symbols-outlined">call</span>
                                            <span><?= htmlspecialchars($thongTinNguoiDung['phone'] !== '' ? $thongTinNguoiDung['phone'] : 'Chưa cập nhật số điện thoại') ?></span>
                                        </div>

                                        <div class="contact-row">
                                            <span class="material-symbols-outlined">location_on</span>
                                            <span><?= htmlspecialchars($thongTinNguoiDung['address'] !== '' ? $thongTinNguoiDung['address'] : 'Chưa cập nhật địa chỉ liên hệ') ?></span>
                                        </div>
                                    </div>

                                    <form class="profile-edit-form" method="POST">
                                        <div class="profile-form-grid">
                                            <div class="profile-form-group">
                                                <label for="full_name">Họ và tên</label>
                                                <input id="full_name" name="full_name" type="text" value="<?= htmlspecialchars($thongTinNguoiDung['full_name'] ?? '') ?>">
                                            </div>

                                            <div class="profile-form-group">
                                                <label for="email">Email liên hệ</label>
                                                <input id="email" name="email" type="email" value="<?= htmlspecialchars($thongTinNguoiDung['email'] ?? '') ?>">
                                            </div>

                                            <div class="profile-form-group">
                                                <label for="phone">Số điện thoại</label>
                                                <input id="phone" name="phone" type="text" value="<?= htmlspecialchars($thongTinNguoiDung['phone'] ?? '') ?>">
                                            </div>

                                            <div class="profile-form-group profile-form-group-full">
                                                <label for="address">Địa chỉ liên hệ</label>
                                                <input id="address" name="address" type="text" value="<?= htmlspecialchars($thongTinNguoiDung['address'] ?? '') ?>">
                                            </div>
                                        </div>

                                        <button class="profile-save-btn" type="submit" name="cap_nhat_ho_so">Lưu thông tin liên hệ</button>
                                    </form>

                                    <form class="avatar-upload-form" method="POST" enctype="multipart/form-data">
                                        <div class="profile-form-group profile-form-group-full">
                                            <label for="avatar">Cập nhật avatar</label>
                                            <input id="avatar" name="avatar" type="file" accept=".jpg,.jpeg,.png,.gif,.webp">
                                        </div>

                                        <button class="profile-save-btn secondary" type="submit" name="cap_nhat_avatar">Tải ảnh đại diện lên</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card social-card">
                            <div class="section-head">
                                <span class="material-symbols-outlined">hub</span>
                                <h3>Tài khoản liên kết</h3>
                            </div>

                            <div class="social-list">
                                <?php foreach ($taiKhoanLienKet as $taiKhoan): ?>
                                    <div class="social-item">
                                        <div class="social-left">
                                            <div class="social-icon">
                                                <?= $taiKhoan['svg'] ?>
                                            </div>

                                            <div>
                                                <div class="social-name"><?= htmlspecialchars($taiKhoan['ten']) ?></div>
                                                <div class="social-status"><?= htmlspecialchars($taiKhoan['trangThai']) ?></div>
                                            </div>
                                        </div>

                                        <button class="social-btn <?= htmlspecialchars($taiKhoan['kieu']) ?>" type="button">
                                            <?= htmlspecialchars($taiKhoan['hanhDong']) ?>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>

                    <aside class="right-col">
                        <div class="card membership-card">
                            <div class="section-head">
                                <span class="material-symbols-outlined">stars</span>
                                <h3>Gói thành viên</h3>
                            </div>

                            <div class="membership-title"><?= htmlspecialchars($goiThanhVien['ten']) ?></div>
                            <div class="membership-text"><?= htmlspecialchars($goiThanhVien['moTa']) ?></div>

                            <div class="membership-row">
                                <span>Gia hạn vào</span>
                                <span><?= htmlspecialchars($goiThanhVien['ngayGiaHan']) ?></span>
                            </div>

                            <button class="membership-btn" type="button">Quản lý gói thành viên</button>
                        </div>

                        <div class="card security-card">
                            <div class="section-head">
                                <span class="material-symbols-outlined">shield_lock</span>
                                <h3>Bảo mật</h3>
                            </div>

                            <div class="security-list">
                                <?php foreach ($baoMat as $item): ?>
                                    <?php if ($item['loai'] === 'badge'): ?>
                                        <button class="security-item" type="button">
                                            <div class="security-left">
                                                <span class="material-symbols-outlined"><?= htmlspecialchars($item['icon']) ?></span>
                                                <span><?= htmlspecialchars($item['ten']) ?></span>
                                            </div>
                                            <span class="active-badge"><?= htmlspecialchars($item['badge']) ?></span>
                                        </button>
                                    <?php elseif ($item['loai'] === 'toggle-password'): ?>
                                        <button class="security-item security-toggle-btn" type="button" id="togglePasswordForm">
                                            <div class="security-left">
                                                <span class="material-symbols-outlined"><?= htmlspecialchars($item['icon']) ?></span>
                                                <span><?= htmlspecialchars($item['ten']) ?></span>
                                            </div>
                                            <span class="material-symbols-outlined security-arrow" id="togglePasswordIcon">expand_more</span>
                                        </button>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <div class="password-panel <?= $thongBaoMatKhau !== '' ? 'open' : '' ?>" id="passwordPanel">
                                <?php if ($thongBaoMatKhau !== ''): ?>
                                    <div class="form-alert <?= htmlspecialchars($loaiThongBaoMatKhau) ?>">
                                        <?= htmlspecialchars($thongBaoMatKhau) ?>
                                    </div>
                                <?php endif; ?>

                                <form class="password-form" method="POST">
                                    <div class="profile-form-group">
                                        <label for="current_password">Mật khẩu hiện tại</label>
                                        <input id="current_password" name="current_password" type="password">
                                    </div>

                                    <div class="profile-form-group">
                                        <label for="new_password">Mật khẩu mới</label>
                                        <input id="new_password" name="new_password" type="password">
                                    </div>

                                    <div class="profile-form-group">
                                        <label for="confirm_password">Xác nhận mật khẩu mới</label>
                                        <input id="confirm_password" name="confirm_password" type="password">
                                    </div>

                                    <button class="profile-save-btn danger-soft" type="submit" name="doi_mat_khau">Cập nhật mật khẩu</button>
                                </form>
                            </div>
                        </div>

                        <div class="danger-card">
                            <div class="danger-wrap">
                                <span class="material-symbols-outlined">warning</span>

                                <div>
                                    <strong>Vùng nguy hiểm</strong>
                                    <p>Xóa vĩnh viễn tài khoản và toàn bộ thư viện truyện kỹ thuật số đã mua của bạn.</p>
                                    <button type="button">Xóa tài khoản</button>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </main>
    </div>

<script src="../../assets/js/public/settings/user.js"></script>
</body>
</html>