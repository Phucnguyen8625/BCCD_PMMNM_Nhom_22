<?php
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= e(buildBasePath('assets/css/app.css')) ?>">
</head>
<body>
<div class="container">
    <header class="page-header">
        <div>
            <h1><?= e($pageTitle ?? APP_NAME) ?></h1>
            <p class="subtitle">Module xử lý đơn hàng, thanh toán, báo cáo và checkout cho Nguyễn Huy Phúc.</p>
        </div>
        <nav class="main-nav">
            <a href="<?= e(buildBasePath('admin/orders/index.php')) ?>">Admin đơn hàng</a>
            <a href="<?= e(buildBasePath('admin/payments/index.php')) ?>">Admin thanh toán</a>
            <a href="<?= e(buildBasePath('admin/reports/index.php')) ?>">Báo cáo</a>
            <a href="<?= e(buildBasePath('checkout/index.php')) ?>">Checkout</a>
        </nav>
    </header>

    <div class="user-box">
        Xin chào, <strong><?= e(currentUserName()) ?></strong>
        <span class="muted">(role: <?= e($_SESSION['user']['role'] ?? 'guest') ?>)</span>
    </div>

    <?php if ($flash): ?>
        <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
    <?php endif; ?>
