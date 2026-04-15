<?php
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? APP_NAME) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#4c2d73', secondary: '#f7941d', price: '#e53e3e', }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #ededed; }
        .page-header { background: #4c2d73; background-image: url('https://st.nettruyen.work/Data/Sites/1/media/bn-bg.jpg'); background-size: cover; background-position: center; padding: 1.5rem; color: white; display: flex; justify-content: space-between; align-items: center; }
        .page-header h1 { font-family: 'Verdana'; font-size: 2rem; font-weight: bold; text-shadow: 2px 2px 0px #f7941d; margin: 0; }
        .main-nav a { color: white; margin-left: 1rem; font-weight: 500; padding-bottom: 0.25rem; border-bottom: 2px solid transparent; transition: border-color 0.3s; }
        .main-nav a:hover { border-color: #f7941d; }
        .user-box { display: none; }
    </style>
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
