<?php

declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message,
    ];
}

function getFlash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
}

function formatCurrency(float|int|string $amount): string
{
    return number_format((float) $amount, 0, ',', '.') . ' đ';
}

function paymentMethods(): array
{
    return [
        'COD' => 'Thanh toán khi nhận hàng (COD)',
        'VNPAY' => 'VNPAY Sandbox',
    ];
}

function orderStatuses(): array
{
    return [
        'pending' => 'Chờ xác nhận',
        'confirmed' => 'Đã xác nhận',
        'shipping' => 'Đang giao',
        'completed' => 'Hoàn thành',
        'cancelled' => 'Đã hủy',
    ];
}

function paymentStatuses(): array
{
    return [
        'unpaid' => 'Chưa thanh toán',
        'pending' => 'Đang xử lý',
        'paid' => 'Đã thanh toán',
        'failed' => 'Thất bại',
        'refunded' => 'Đã hoàn tiền',
        'mismatch' => 'Sai lệch dữ liệu',
    ];
}

function canChangeOrderStatus(string $current, string $next): bool
{
    $rules = [
        'pending' => ['confirmed', 'cancelled'],
        'confirmed' => ['shipping', 'cancelled'],
        'shipping' => ['completed', 'cancelled'],
        'completed' => [],
        'cancelled' => [],
    ];

    return in_array($next, $rules[$current] ?? [], true);
}

function statusBadgeClass(string $status): string
{
    return match ($status) {
        'paid', 'completed', 'confirmed' => 'badge-success',
        'pending', 'shipping' => 'badge-warning',
        'failed', 'cancelled', 'mismatch' => 'badge-danger',
        'refunded' => 'badge-info',
        default => 'badge-muted',
    };
}

function buildBasePath(string $relativePath = ''): string
{
    $relativePath = ltrim($relativePath, '/');
    return rtrim(BASE_URL, '/') . '/' . $relativePath;
}

function currentUserId(): int
{
    return (int) ($_SESSION['user']['id'] ?? 0);
}

function currentUserName(): string
{
    return (string) ($_SESSION['user']['full_name'] ?? 'Khách');
}

function cartItems(): array
{
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return [];
    }

    $pdo = db();
    $items = [];
    foreach ($_SESSION['cart'] as $id => $qty) {
        if (is_array($qty)) {
            return $_SESSION['cart'];
        }
        $stmt = $pdo->prepare('SELECT id, name, price, image_url FROM comics WHERE id = ?');
        $stmt->execute([$id]);
        if ($comic = $stmt->fetch()) {
            $items[] = [
                'comic_id' => $comic['id'],
                'name' => $comic['name'],
                'price' => $comic['price'],
                'quantity' => $qty,
                'image_url' => $comic['image_url'],
            ];
        }
    }
    return $items;
}

function cartTotals(): array
{
    $items = cartItems();
    $subtotal = 0;

    foreach ($items as $item) {
        $subtotal += ((float) ($item['price'] ?? 0)) * ((int) ($item['quantity'] ?? 0));
    }

    $shippingFee = $subtotal >= 300000 ? 0 : 30000;
    $total = $subtotal + $shippingFee;

    return [
        'subtotal' => $subtotal,
        'shipping_fee' => $shippingFee,
        'total' => $total,
    ];
}

function createTxnRef(int $orderId): string
{
    return 'ORDER' . $orderId . date('YmdHis');
}

function ensureSeedSessionData(): void
{
    if (!isset($_SESSION['user'])) {
        $_SESSION['user'] = [
            'id' => 1,
            'full_name' => 'Nguyễn Huy Phúc Demo',
            'email' => 'phuc@example.com',
            'role' => 'admin',
        ];
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [
            1 => 2,
            2 => 1,
        ];
    }
}
