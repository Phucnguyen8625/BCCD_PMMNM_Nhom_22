<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/app.php';

ensureSeedSessionData();
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$receiverName = trim($_POST['receiver_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');
$paymentMethod = trim($_POST['payment_method'] ?? '');
$note = trim($_POST['note'] ?? '');
$bankCode = trim($_POST['bank_code'] ?? '');

$items = cartItems();
$totals = cartTotals();

if ($receiverName === '' || $phone === '' || $address === '') {
    setFlash('error', 'Vui lòng nhập đầy đủ thông tin người nhận, số điện thoại và địa chỉ.');
    redirect('index.php');
}

if (!$items) {
    setFlash('error', 'Giỏ hàng trống, không thể tạo đơn.');
    redirect('index.php');
}

if (!array_key_exists($paymentMethod, paymentMethods())) {
    setFlash('error', 'Phương thức thanh toán không hợp lệ.');
    redirect('index.php');
}

if ($paymentMethod === 'VNPAY') {
    if (
        trim(VNPAY_TMN_CODE) === '' ||
        trim(VNPAY_HASH_SECRET) === '' ||
        VNPAY_TMN_CODE === 'YOUR_TMN_CODE' ||
        VNPAY_HASH_SECRET === 'YOUR_HASH_SECRET'
    ) {
        setFlash('error', 'Chưa cấu hình tài khoản VNPAY sandbox trong app.local.php');
        redirect('index.php');
    }
}

$pdo = db();
$pdo->beginTransaction();

try {
    $orderStatus = $paymentMethod === 'VNPAY' ? 'pending' : 'pending';

    $insertOrder = $pdo->prepare(
        'INSERT INTO orders (
            customer_name,
            customer_phone,
            customer_email,
            address,
            total_amount,
            status
        ) VALUES (
            :receiver_name,
            :phone,
            :email,
            :address,
            :total_amount,
            :status
        )'
    );

    $insertOrder->execute([
        'receiver_name' => $receiverName,
        'phone' => $phone,
        'email' => currentUserName() . '@example.com', // fake email since checkout doesn't ask for it
        'address' => $address . ($note ? " (Ghi chú: $note)" : ""),
        'total_amount' => $totals['total'],
        'status' => $orderStatus,
    ]);

    $orderId = (int) $pdo->lastInsertId();

    $insertItem = $pdo->prepare(
        'INSERT INTO order_details (
            order_id,
            comic_id,
            quantity,
            price
        ) VALUES (
            :order_id,
            :comic_id,
            :quantity,
            :price
        )'
    );

    foreach ($items as $item) {
        $quantity = (int) $item['quantity'];
        $price = (float) $item['price'];

        $insertItem->execute([
            'order_id' => $orderId,
            'comic_id' => (int) $item['comic_id'],
            'quantity' => $quantity,
            'price' => $price,
        ]);
    }

    $rawTxnRef = createTxnRef($orderId);
    $txnRef = preg_replace('/[^A-Za-z0-9]/', '', (string) $rawTxnRef);

    if ($txnRef === null || $txnRef === '') {
        $txnRef = 'ORD' . $orderId . date('YmdHis');
    }

    $vnpCreateDate = date('YmdHis');

    $insertPayment = $pdo->prepare(
        'INSERT INTO payments (
            order_id,
            payment_method,
            amount,
            payment_status,
            transaction_id
        ) VALUES (
            :order_id,
            :method,
            :amount,
            :status,
            :transaction_code
        )'
    );

    $insertPayment->execute([
        'order_id' => $orderId,
        'method' => $paymentMethod === 'VNPAY' ? 'vnpay' : 'cod',
        'amount' => $totals['total'],
        'status' => $paymentMethod === 'VNPAY' ? 'pending' : 'success',
        'transaction_code' => $txnRef,
    ]);

    // MVC version doesn't use order_logs, skipping insertLog
    $paymentId = (int) $pdo->lastInsertId();

    $pdo->commit();

    if ($paymentMethod === 'VNPAY') {
        $_SESSION['last_payment_id'] = $paymentId;

        $payment = [
            'transaction_code' => $txnRef,
            'order_id' => $orderId,
            'vnp_create_date' => $vnpCreateDate,
        ];

        $order = [
            'id' => $orderId,
            'total_amount' => $totals['total'],
        ];

        $paymentUrl = createVnpayPaymentUrl($order, $payment, $bankCode);
        redirect($paymentUrl);
    }

    unset($_SESSION['cart']);
    setFlash('success', 'Đặt hàng thành công với phương thức COD.');
    redirect('../../index.php?controller=checkout&action=success&order_id=' . $orderId);
} catch (Throwable $exception) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    setFlash('error', 'Tạo đơn thất bại: ' . $exception->getMessage());
    redirect('index.php');
}