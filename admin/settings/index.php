<?php
require_once __DIR__ . '/../../config/adminConfig.php';
requireAdminLogin();

$pageTitle = 'Cài đặt';
$menuSidebar = layMenuAdmin('settings');

$pageStyles = [
    assetUrl('css/admin/settings/settingsStyle.css')
];

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = $_POST['theme'] ?? 'light';
    setTheme($theme);
    $message = 'Đã lưu cài đặt giao diện.';
}

require_once INCLUDE_PATH . '/admin/adminHeader.php';
require_once INCLUDE_PATH . '/admin/adminSidebar.php';
?>
<main class="admin-main">
    <header class="admin-topbar">
        <div>
            <h1><?= e($pageTitle) ?></h1>
            <p>Tùy chỉnh giao diện và thiết lập hệ thống</p>
        </div>
    </header>

    <section class="panel-card settings-card">
        <?php if ($message !== ''): ?>
            <div class="form-alert success"><?= e($message) ?></div>
        <?php endif; ?>

        <form method="POST" class="admin-form">
            <div class="form-group">
                <label for="theme">Chế độ giao diện</label>
                <select id="theme" name="theme">
                    <option value="light" <?= getTheme() === 'light' ? 'selected' : '' ?>>Sáng</option>
                    <option value="dark" <?= getTheme() === 'dark' ? 'selected' : '' ?>>Tối</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="primary-btn">Lưu cài đặt</button>
            </div>
        </form>
    </section>
<?php require_once INCLUDE_PATH . '/admin/adminFooter.php'; ?>