<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/app.php';
ensureSeedSessionData();
requireLogin();

$pageTitle = 'User - Thanh toán online';
$items = cartItems();
$totals = cartTotals();

require_once dirname(__DIR__) . '/layouts/header.php';
?>

<div class="grid grid-2">
    <div class="card">
        <h3>Thông tin giao hàng</h3>
        <?php if (!$items): ?>
            <p>Giỏ hàng đang trống. Hãy thêm truyện vào giỏ trước khi thanh toán.</p>
        <?php else: ?>
            <form method="post" action="process_checkout.php">
                <div>
                    <label for="receiver_name">Người nhận</label>
                    <input type="text" id="receiver_name" name="receiver_name" required value="<?= e(currentUserName()) ?>">
                </div>
                <div style="margin-top: 12px;">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" required placeholder="Ví dụ: 09xxxxxxxx">
                </div>
                <div style="margin-top: 12px;">
                    <label for="address">Địa chỉ</label>
                    <textarea id="address" name="address" required placeholder="Nhập địa chỉ nhận truyện"></textarea>
                </div>
                <div style="margin-top: 12px;">
                    <label for="payment_method">Phương thức thanh toán</label>
                    <select id="payment_method" name="payment_method" required>
                        <?php foreach (paymentMethods() as $value => $label): ?>
                            <option value="<?= e($value) ?>"><?= e($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="margin-top: 12px;">
                    <label for="note">Ghi chú</label>
                    <textarea id="note" name="note" placeholder="Ví dụ: Giao giờ hành chính, gọi trước khi giao..."></textarea>
                </div>
                <div style="margin-top: 14px;">
                    <button class="btn btn-success" type="submit">Xác nhận đặt hàng</button>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3>Đơn hàng của bạn</h3>
        <table>
            <thead>
                <tr>
                    <th>Truyện</th>
                    <th class="right">Đơn giá</th>
                    <th class="right">SL</th>
                    <th class="right">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= e($item['name']) ?></td>
                        <td class="right"><?= e(formatCurrency($item['price'])) ?></td>
                        <td class="right"><?= (int) $item['quantity'] ?></td>
                        <td class="right"><?= e(formatCurrency(((float) $item['price']) * ((int) $item['quantity']))) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <ul class="summary-list" style="margin-top: 14px;">
            <li><strong>Tạm tính:</strong> <?= e(formatCurrency($totals['subtotal'])) ?></li>
            <li><strong>Phí vận chuyển:</strong> <?= e(formatCurrency($totals['shipping_fee'])) ?></li>
            <li><strong>Tổng thanh toán:</strong> <?= e(formatCurrency($totals['total'])) ?></li>
        </ul>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
