<?php
require_once __DIR__ . '/../../config/adminConfig.php';
requireAdminLogin();

$pageTitle = 'Chi tiết nội dung';
$menuSidebar = layMenuAdmin('content');

$pageStyles = [
    assetUrl('css/admin/content/detailStyle.css')
];

$id = (int)($_GET['id'] ?? 1);

$data = [
    'id' => $id,
    'title' => 'Ánh Sao Cuối Trời',
    'author' => 'Ngọc Lam',
    'category' => 'Tình cảm',
    'status' => 'Đã xuất bản',
    'created_at' => '10/04/2026',
    'summary' => 'Một câu chuyện nhẹ nhàng về tuổi trẻ, khát vọng và ký ức.',
    'content' => 'Đây là nội dung mô phỏng cho trang chi tiết của truyện.'
];

require_once INCLUDE_PATH . '/admin/adminHeader.php';
require_once INCLUDE_PATH . '/admin/adminSidebar.php';
?>
<main class="admin-main">
    <header class="admin-topbar">
        <div>
            <h1><?= e($pageTitle) ?></h1>
            <p>Xem đầy đủ thông tin truyện</p>
        </div>
        <div class="topbar-actions">
            <a href="<?= e(adminUrl('content/edit.php?id=' . $id)) ?>" class="primary-btn">Chỉnh sửa</a>
        </div>
    </header>

    <section class="panel-card detail-card">
        <div class="detail-grid">
            <div class="detail-item">
                <span>Mã truyện</span>
                <strong>#<?= e((string)$data['id']) ?></strong>
            </div>
            <div class="detail-item">
                <span>Tên truyện</span>
                <strong><?= e($data['title']) ?></strong>
            </div>
            <div class="detail-item">
                <span>Tác giả</span>
                <strong><?= e($data['author']) ?></strong>
            </div>
            <div class="detail-item">
                <span>Thể loại</span>
                <strong><?= e($data['category']) ?></strong>
            </div>
            <div class="detail-item">
                <span>Trạng thái</span>
                <strong><?= e($data['status']) ?></strong>
            </div>
            <div class="detail-item">
                <span>Ngày tạo</span>
                <strong><?= e($data['created_at']) ?></strong>
            </div>
        </div>

        <div class="detail-block">
            <h3>Mô tả ngắn</h3>
            <p><?= e($data['summary']) ?></p>
        </div>

        <div class="detail-block">
            <h3>Nội dung</h3>
            <p><?= e($data['content']) ?></p>
        </div>
    </section>
<?php require_once INCLUDE_PATH . '/admin/adminFooter.php'; ?>