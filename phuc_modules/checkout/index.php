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

<main class="max-w-6xl mx-auto my-8 px-4">
    <div class="flex items-center text-primary mb-6">
        <a href="<?= buildBasePath('../../index.php?controller=cart') ?>" class="hover:underline flex items-center"><i class="fas fa-angle-left mr-2"></i> Quay lại giỏ hàng</a>
        <span class="mx-4 text-gray-400">|</span>
        <h1 class="text-2xl font-bold text-gray-800">Thanh toán an toàn</h1>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Delivery info -->
        <div class="w-full lg:w-2/3 bg-white shadow-sm rounded-lg border border-gray-200 p-8">
            <div class="flex items-center mb-6 border-b border-gray-200 pb-4">
                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold mr-3">1</div>
                <h2 class="text-xl font-bold text-gray-800">Thông tin giao hàng</h2>
            </div>
            
            <?php if (!$items): ?>
                <div class="p-4 bg-red-50 text-red-600 rounded mb-6">
                    Giỏ hàng đang trống. Hãy thêm truyện vào giỏ trước khi thanh toán.
                </div>
            <?php else: ?>
                <form method="post" action="process_checkout.php" id="checkoutForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="receiver_name" class="block text-sm font-medium text-gray-700 mb-2">Người nhận *</label>
                            <input type="text" id="receiver_name" name="receiver_name" required value="<?= e(currentUserName()) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại *</label>
                            <input type="tel" id="phone" name="phone" required placeholder="Ví dụ: 09xxxxxxxx" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ nhận hàng *</label>
                        <textarea id="address" name="address" required rows="3" placeholder="Nhập địa chỉ nhận truyện chi tiết..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"></textarea>
                    </div>

                    <div class="mb-6 border-t border-gray-200 pt-6">
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold mr-3">2</div>
                            <h2 class="text-xl font-bold text-gray-800">Phương thức thanh toán</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach (paymentMethods() as $value => $label): ?>
                                <label class="border border-gray-200 rounded-lg p-4 flex items-center cursor-pointer hover:border-primary transition relative group">
                                    <input type="radio" name="payment_method" value="<?= e($value) ?>" <?= $value === 'COD' ? 'checked' : '' ?> class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                    <span class="ml-3 font-medium text-gray-700"><?= e($label) ?></span>
                                    <?php if ($value === 'VNPAY'): ?>
                                        <img src="https://vnpay.vn/s1/statics.vnpay.vn/2023/9/06ncktiwd6dc1694418106_logo-app-vnpay.png" alt="VNPay" class="h-6 ml-auto grayscale group-hover:grayscale-0 transition">
                                    <?php else: ?>
                                        <i class="fas fa-money-bill-wave text-green-500 ml-auto text-xl"></i>
                                    <?php endif; ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="note" class="block text-sm font-medium text-gray-700 mb-2">Ghi chú (Tùy chọn)</label>
                        <textarea id="note" name="note" rows="2" placeholder="Ví dụ: Giao giờ hành chính, gọi trước khi giao..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"></textarea>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <!-- Order Summary -->
        <div class="w-full lg:w-1/3">
            <div class="bg-gray-50 shadow-sm rounded-lg border border-gray-200 p-6 sticky top-4">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-4 border-b border-gray-200">Đơn hàng của bạn</h3>
                
                <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2">
                    <?php foreach ($items as $item): ?>
                        <div class="flex justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                            <div class="flex-1 pr-4 text-sm">
                                <h4 class="font-medium text-gray-800 line-clamp-2"><?= e($item['name']) ?></h4>
                                <p class="text-gray-500 mt-1">SL: <?= (int) $item['quantity'] ?> x <?= e(formatCurrency($item['price'])) ?></p>
                            </div>
                            <div class="font-semibold text-gray-800 text-sm">
                                <?= e(formatCurrency(((float) $item['price']) * ((int) $item['quantity']))) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="space-y-3 text-sm mb-4 border-t border-b border-gray-200 py-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tạm tính:</span>
                        <span class="font-medium"><?= e(formatCurrency($totals['subtotal'])) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Phí vận chuyển:</span>
                        <span class="font-medium text-gray-800"><?= e(formatCurrency($totals['shipping_fee'])) ?></span>
                    </div>
                </div>
                
                <div class="flex justify-between mb-6">
                    <span class="font-bold text-gray-800 text-lg">Tổng cộng:</span>
                    <span class="font-bold text-price text-2xl"><?= e(formatCurrency($totals['total'])) ?></span>
                </div>
                
                <button type="submit" form="checkoutForm" class="w-full bg-secondary hover:bg-orange-600 text-white font-bold py-3.5 px-4 rounded-lg transition shadow-md flex items-center justify-center">
                    <i class="fas fa-lock mr-2 text-sm opacity-80"></i> XÁC NHẬN ĐẶT HÀNG
                </button>
            </div>
        </div>
    </div>
</main>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
