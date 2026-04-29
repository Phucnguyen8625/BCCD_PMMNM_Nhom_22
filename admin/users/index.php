<?php
require_once __DIR__ . '/../../config/adminConfig.php';
requireAdminLogin();

$pageTitle = 'Người dùng';
$menuSidebar = layMenuAdmin('users');

$pageStyles = [
    assetUrl('css/admin/users/usersStyle.css')
];

$users = [
    ['id' => 1, 'ten' => 'Nguyễn Bảo', 'email' => 'bao@gmail.com', 'vaiTro' => 'User', 'trangThai' => 'Hoạt động'],
    ['id' => 2, 'ten' => 'Trần Minh', 'email' => 'minh@gmail.com', 'vaiTro' => 'User', 'trangThai' => 'Tạm khóa'],
    ['id' => 3, 'ten' => 'Lê An', 'email' => 'an@gmail.com', 'vaiTro' => 'Admin', 'trangThai' => 'Hoạt động'],
];

require_once INCLUDE_PATH . '/admin/adminHeader.php';
require_once INCLUDE_PATH . '/admin/adminSidebar.php';
?>
<main class="admin-main">
    <header class="admin-topbar">
        <div>
            <h1><?= e($pageTitle) ?></h1>
            <p>Quản lý tài khoản và quyền truy cập</p>
        </div>
    </header>

    <section class="panel-card">
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>#<?= e((string)$user['id']) ?></td>
                            <td><?= e($user['ten']) ?></td>
                            <td><?= e($user['email']) ?></td>
                            <td><?= e($user['vaiTro']) ?></td>
                            <td><span class="status-badge"><?= e($user['trangThai']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
<?php require_once INCLUDE_PATH . '/admin/adminFooter.php'; ?>