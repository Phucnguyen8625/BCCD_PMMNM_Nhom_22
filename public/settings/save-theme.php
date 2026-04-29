<?php
require_once __DIR__ . '/../../config/theme.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Phương thức không hợp lệ.'
    ]);
    exit;
}

$theme = $_POST['theme'] ?? 'light';
luuTheme($theme);

echo json_encode([
    'success' => true,
    'theme' => layThemeHienTai()
]);
exit;