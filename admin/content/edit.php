<?php
require_once __DIR__ . '/../../config/adminConfig.php';
requireAdminLogin();

$pageTitle = 'Chỉnh sửa nội dung';
$menuSidebar = layMenuAdmin('content');

$pageStyles = [
    assetUrl('css/admin/content/editStyle.css')
];

$pageScripts = [
    assetUrl('js/admin/content/edit.js')
];

$id = (int)($_GET['id'] ?? 1);
$message = '';

$data = [
    'title' => 'Ánh Sao Cuối Trời',
    'author' => 'Ngọc Lam',
    'category' => 'Tình cảm',
    'status' => 'publish',
    'summary' => 'Một câu chuyện nhẹ nhàng về tuổi trẻ và ước mơ.',
    'content' => 'Nội dung truyện đang được cập nhật...'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = 'Đã cập nhật nội dung thành công.';
    $data['title'] = trim($_POST['title'] ?? '');
    $data['author'] = trim($_POST['author'] ?? '');
    $data['category'] = trim($_POST['category'] ?? '');
    $data['status'] = trim($_POST['status'] ?? '');
    $data['summary'] = trim($_POST['summary'] ?? '');
    $data['content'] = trim($_POST['content'] ?? '');
}

require_once INCLUDE_PATH . '/admin/adminHeader.php';
require_once INCLUDE_PATH . '/admin/adminSidebar.php';
?>
<main class="admin-main">
    <header class="admin-topbar">
        <div>
            <h1><?= e($pageTitle) ?></h1>
            <p>Cập nhật thông tin truyện mã #<?= e((string)$id) ?></p>
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
                    <input type="text" id="title" name="title" value="<?= e($data['title']) ?>">
                </div>

                <div class="form-group">
                    <label for="author">Tác giả</label>
                    <input type="text" id="author" name="author" value="<?= e($data['author']) ?>">
                </div>

                <div class="form-group">
                    <label for="category">Thể loại</label>
                    <select id="category" name="category">
                        <option value="Tình cảm" <?= $data['category'] === 'Tình cảm' ? 'selected' : '' ?>>Tình cảm</option>
                        <option value="Hành động" <?= $data['category'] === 'Hành động' ? 'selected' : '' ?>>Hành động</option>
                        <option value="Phiêu lưu" <?= $data['category'] === 'Phiêu lưu' ? 'selected' : '' ?>>Phiêu lưu</option>
                        <option value="Đời thường" <?= $data['category'] === 'Đời thường' ? 'selected' : '' ?>>Đời thường</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Trạng thái</label>
                    <select id="status" name="status">
                        <option value="draft" <?= $data['status'] === 'draft' ? 'selected' : '' ?>>Bản nháp</option>
                        <option value="publish" <?= $data['status'] === 'publish' ? 'selected' : '' ?>>Đã xuất bản</option>
                    </select>
                </div>

                <div class="form-group full">
                    <label for="summary">Mô tả ngắn</label>
                    <textarea id="summary" name="summary" rows="4"><?= e($data['summary']) ?></textarea>
                </div>

                <div class="form-group full">
                    <label for="content">Nội dung</label>
                    <textarea id="content" name="content" rows="10"><?= e($data['content']) ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?= e(adminUrl('content/index.php')) ?>" class="secondary-btn">Quay lại</a>
                <button type="submit" class="primary-btn">Lưu thay đổi</button>
            </div>
        </form>
    </section>
<?php require_once INCLUDE_PATH . '/admin/adminFooter.php'; ?>