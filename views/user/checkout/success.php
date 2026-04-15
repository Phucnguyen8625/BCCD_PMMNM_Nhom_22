<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt hàng thành công</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; margin: 0; padding: 0; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .success-card { background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; max-width: 500px; width: 100%; }
        .success-icon { font-size: 60px; color: #28a745; margin-bottom: 20px; }
        h1 { margin-top: 0; color: #333; }
        p { color: #666; line-height: 1.5; }
        .btn-home { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="success-icon">✓</div>
        <h1>Đặt hàng thành công!</h1>
        <p>Cảm ơn bạn đã mua hàng. Đơn hàng <strong>#<?= htmlspecialchars($orderId) ?></strong> của bạn đã được ghi nhận.</p>
        <?php if(isset($_GET['method']) && $_GET['method'] == 'vnpay_mock'): ?>
            <p style="color: #17a2b8;">(Mô phỏng: Truy cập <a href="admin.php?controller=payment&action=index">Admin -> Khách hàng thanh toán VNPAY thành công</a>)</p>
        <?php else: ?>
            <p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận đơn hàng.</p>
        <?php endif; ?>
        <a href="index.php" class="btn-home">Tiếp tục mua sắm</a>
    </div>
</body>
</html>
