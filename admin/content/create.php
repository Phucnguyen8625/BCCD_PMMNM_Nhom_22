<?php
require_once __DIR__ . '/../../config/adminConfig.php';
requireAdminLogin();

$pageTitle = 'Thêm nội dung';
$menuSidebar = layMenuAdmin('content');

$pageStyles = [
    assetUrl('css/admin/content/createStyle.css')
];

$pageScripts = [
    assetUrl('js/admin/content/create.js')
];

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = 'Đã lưu nội dung mới thành công.';
}

require_once INCLUDE_PATH . '/admin/adminHeader.php';
require_once INCLUDE_PATH . '/admin/adminSidebar.php';
?>
<main class="admin-main">
    <header class="admin-topbar">
        <div>
            <h1><?= e($pageTitle) ?></h1>
            <p>Tạo mới truyện hoặc bài viết</p>
        </div>
    </header>

    <section class="panel-card form-card">
        <?php if ($message !== ''): ?>
            <div class="form-alert success"><?= e($message) ?></div>
        <?php endif; ?>

        <form method="POST" class="admin-form">
            <div class="form-grid">
                <div class="form-group">
                    <label for="title">Tên truyện</label>
                    <input type="text" id="title" name="title" placeholder="Nhập tên truyện">
                </div>

                <div class="form-group">
                    <label for="author">Tác giả</label>
                    <input type="text" id="author" name="author" placeholder="Nhập tên tác giả">
                </div>

                <div class="form-group">
                    <label for="category">Thể loại</label>
                    <select id="category" name="category">
                        <option value="Tình cảm">Tình cảm</option>
                        <option value="Hành động">Hành động</option>
                        <option value="Phiêu lưu">Phiêu lưu</option>
                        <option value="Đời thường">Đời thường</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Trạng thái</label>
                    <select id="status" name="status">
                        <option value="draft">Bản nháp</option>
                        <option value="publish">Đã xuất bản</option>
                    </select>
                </div>

                <div class="form-group full">
                    <label for="summary">Mô tả ngắn</label>
                    <textarea id="summary" name="summary" rows="4" placeholder="Nhập mô tả ngắn"></textarea>
                </div>

                <div class="form-group full">
                    <label for="content">Nội dung</label>
                    <textarea id="content" name="content" rows="10" placeholder="Nhập nội dung chi tiết"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?= e(adminUrl('content/index.php')) ?>" class="secondary-btn">Quay lại</a>
                <button type="submit" class="primary-btn">Lưu nội dung</button>
            </div>
        </form>
    </section>
<?php require_once INCLUDE_PATH . '/admin/adminFooter.php'; ?>