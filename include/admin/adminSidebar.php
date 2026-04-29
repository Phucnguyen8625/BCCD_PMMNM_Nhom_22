<?php $menuSidebar = $menuSidebar ?? layMenuAdmin(); ?>
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <div class="brand-mark">M</div>
        <div class="brand-text">
            <strong>Mực Chuyển Động</strong>
            <span>Trang quản trị</span>
        </div>
    </div>

    <nav class="sidebar-menu">
        <?php foreach ($menuSidebar as $menu): ?>
            <a href="<?= e($menu['link']) ?>" class="sidebar-link <?= $menu['active'] ? 'active' : '' ?>">
                <span class="material-symbols-outlined"><?= e($menu['icon']) ?></span>
                <span><?= e($menu['ten']) ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="sidebar-footer">
        <a href="<?= e(adminUrl('logout.php')) ?>" class="sidebar-logout">
            <span class="material-symbols-outlined">logout</span>
            <span>Đăng xuất</span>
        </a>
    </div>
</aside>