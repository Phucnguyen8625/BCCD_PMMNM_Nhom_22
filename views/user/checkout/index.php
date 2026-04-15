<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán | Bán Truyện Tranh</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #fdfdfd; margin: 0; padding: 0; color: #333; }
        .header { background: #fff; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center; margin-bottom: 40px; }
        .container { max-width: 900px; margin: 0 auto; display: flex; gap: 30px; }
        .form-section { flex: 2; }
        .summary-section { flex: 1; background: #f8f9fa; padding: 20px; border-radius: 8px; align-self: flex-start; }
        h2 { margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .payment-methods { margin-top: 20px; }
        .method { margin-bottom: 10px; }
        .method label { font-weight: normal; cursor: pointer; }
        .btn-submit { display: block; width: 100%; padding: 15px; background: #28a745; color: white; text-align: center; text-decoration: none; border: none; border-radius: 4px; font-size: 16px; font-weight: bold; cursor: pointer; margin-top: 20px; }
        .cart-item { display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .cart-total { display: flex; justify-content: space-between; font-size: 18px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Thanh toán an toàn</h1>
    </div>
    
    <div class="container">
        <div class="form-section">
            <h2>Thông tin giao hàng</h2>
            <form action="index.php?controller=checkout&action=process" method="POST">
                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" name="name" required placeholder="Nhập họ và tên...">
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" required placeholder="Nhập số điện thoại...">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="Nhập email...">
                </div>
                <div class="form-group">
                    <label>Địa chỉ</label>
                    <textarea name="address" rows="3" required placeholder="Nhập địa chỉ nhận hàng chi tiết..."></textarea>
                </div>

                <div class="payment-methods">
                    <h2>Phương thức thanh toán</h2>
                    <div class="method">
                        <label>
                            <input type="radio" name="payment_method" value="cod" checked>
                            Thanh toán khi nhận hàng (COD)
                        </label>
                    </div>
                    <div class="method">
                        <label>
                            <input type="radio" name="payment_method" value="vnpay">
                            Thanh toán trực tuyến (VNPAY - Sandbox)
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-submit">ĐẶT HÀNG</button>
            </form>
        </div>

        <div class="summary-section">
            <h2>Đơn hàng của bạn</h2>
            <?php foreach($cart as $item): ?>
            <div class="cart-item">
                <div class="item-name"><?= htmlspecialchars($item['name']) ?> <strong>x<?= $item['quantity'] ?></strong></div>
                <div class="item-price"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ</div>
            </div>
            <?php endforeach; ?>
            <div class="cart-total">
                <span>Tổng cộng:</span>
                <span><?= number_format($totalAmount, 0, ',', '.') ?> đ</span>
            </div>
        </div>
    </div>
</body>
</html>
