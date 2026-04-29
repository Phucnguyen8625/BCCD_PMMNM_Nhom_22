<?php
$adminInfo = getAdminInfo();
$currentTheme = getTheme();
?>
<!DOCTYPE html>
<html lang="vi" data-theme="<?= e($currentTheme) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Quản trị hệ thống') ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="<?= e(assetUrl('css/admin/adminStyle.css')) ?>">
    <?php if (!empty($pageStyles) && is_array($pageStyles)): ?>
        <?php foreach ($pageStyles as $style): ?>
            <link rel="stylesheet" href="<?= e($style) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="admin-body">
<div class="admin-shell">