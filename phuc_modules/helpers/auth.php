<?php

declare(strict_types=1);

function requireLogin(): void
{
    if (!isset($_SESSION['user'])) {
        setFlash('error', 'Bạn cần đăng nhập để tiếp tục.');
        redirect(buildBasePath('login.php'));
    }
}

function requireAdmin(): void
{
    requireLogin();

    if (($_SESSION['user']['role'] ?? '') !== 'admin') {
        http_response_code(403);
        exit('Bạn không có quyền truy cập chức năng này.');
    }
}
