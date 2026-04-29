<?php
require_once __DIR__ . '/../config/adminConfig.php';

if (isAdminLoggedIn()) {
    header('Location: ' . ADMIN_URL . '/dashboard/index.php');
    exit;
}

header('Location: ' . ADMIN_URL . '/login.php');
exit;