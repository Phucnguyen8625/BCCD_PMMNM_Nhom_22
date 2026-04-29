<?php
require_once __DIR__ . '/../../config/adminConfig.php';
requireAdminLogin();

$pageTitle = 'Quản lý nội dung';
$menuSidebar = layMenuAdmin('content');

$pageStyles = [
    assetUrl('css/admin/content/indexStyle.css')
];

$stories = [
    ['id' => 1, 'ten' => 'Ánh Sao Cuối Trời', 'tacGia' => 'Ngọc Lam', 'theLoai' => 'Tình cảm', 'trangThai' => 'Đã xuất bản'],
    ['id' => 2, 'ten' => 'Bóng Tối Thành Phố', 'tacGia' => 'Hạ Vũ', 'theLoai' => 'Hành động', 'trangThai' => 'Bản nháp'],
    ['id' => 3, 'ten' => 'Ngày Em Đi Qua', 'tacGia' => 'An Nhiên', 'theLoai' => 'Đời thường', 'trangThai' => 'Đã xuất bản'],
];

require_once INCLUDE_PATH . '/admin/adminHeader.php';
require_once INCLUDE_PATH . '/admin/adminSidebar.php';
?>
<main class="admin-main">
    <header class="admin-topbar">
        <div>
            <h1><?= e($pageTitle) ?></h1>
            <p>Danh sách truyện và bài viết trong hệ thống</p>
        </div>
        <div class="topbar-actions">
            <a href="<?= e(adminUrl('content/create.php')) ?>" class="primary-btn">Thêm mới</a>
        </div>
    </header>

    <section class="panel-card">
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Tên truyện</th>
                        <th>Tác giả</th>
                        <th>Thể loại</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stories as $story): ?>
                        <tr>
                            <td>#<?= e((string)$story['id']) ?></td>
                            <td><?= e($story['ten']) ?></td>
                            <td><?= e($story['tacGia']) ?></td>
                            <td><?= e($story['theLoai']) ?></td>
                            <td><span class="status-badge"><?= e($story['trangThai']) ?></span></td>
                            <td class="table-actions">
                                <a href="<?= e(adminUrl('content/detail.php?id=' . $story['id'])) ?>">Xem</a>
                                <a href="<?= e(adminUrl('content/edit.php?id=' . $story['id'])) ?>">Sửa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
<?php require_once INCLUDE_PATH . '/admin/adminFooter.php'; ?>