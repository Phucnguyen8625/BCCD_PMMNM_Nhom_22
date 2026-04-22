<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Comic.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../config/database.php';

class CheckoutController {
    private $order;
    private $payment;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->order = new Order($this->db);
        $this->payment = new Payment($this->db);
    }

    public function index() {
        $cart_session = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if (empty($cart_session)) {
            header("Location: index.php?controller=cart&action=index&error=Giỏ hàng trống!");
            exit();
        }
        
        $database = new Database();
        $db = $database->getConnection();
        $comicModel = new Comic($db);
        
        $totalAmount = 0;
        $cart = [];
        
        foreach ($cart_session as $comic_id => $quantity) {
            $comicModel->id = $comic_id;
            if ($comicModel->readOne()) {
                $cart[] = [
                    'comic_id' => $comic_id,
                    'name' => $comicModel->name,
                    'price' => $comicModel->price,
                    'quantity' => $quantity
                ];
                $totalAmount += $comicModel->price * $quantity;
            }
        }
        // Load categories for nav
        $categoryModel = new Category($db);
        $categories = $categoryModel->getAllActive();

        // Get user session for pre-filling
        $currentUser = isset($_SESSION['user_login']) ? $_SESSION['user_login'] : null;

        require_once __DIR__ . '/../views/user/checkout/index.php';
    }

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $paymentMethod = $_POST['payment_method'];
            
            $cart_session = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
            if (empty($cart_session)) {
                header("Location: index.php?controller=cart");
                exit();
            }

            $database = new Database();
            $db = $database->getConnection();
            $comicModel = new Comic($db);

            $totalAmount = 0;
            $cart = [];
            foreach ($cart_session as $comic_id => $quantity) {
                $comicModel->id = $comic_id;
                if ($comicModel->readOne()) {
                    $cart[] = [
                        'comic_id' => $comic_id,
                        'price' => $comicModel->price,
                        'quantity' => $quantity
                    ];
                    $totalAmount += $comicModel->price * $quantity;
                }
            }

            $orderId = $this->order->createOrder($name, $phone, $email, $address, $totalAmount);
            
            foreach ($cart as $item) {
                $this->order->addOrderDetail($orderId, $item['comic_id'], $item['quantity'], $item['price']);
            }

            // Xóa cart sau khi tạo đơn
            unset($_SESSION['cart']);

            if ($paymentMethod === 'vnpay') {
                $vnp_txn_ref = 'ORD' . $orderId . '_' . time();
                $this->payment->createPayment($orderId, 'vnpay', $totalAmount, 'pending', $vnp_txn_ref);
                
                // Chuẩn bị dữ liệu cho VNPay Helper
                $vnpOrder = ['id' => $orderId, 'total_amount' => $totalAmount];
                $vnpPayment = ['transaction_code' => $vnp_txn_ref, 'vnp_create_date' => date('YmdHis')];
                
                $vnpayUrl = createVnpayPaymentUrl($vnpOrder, $vnpPayment);
                header("Location: " . $vnpayUrl);
                exit();
            } else {
                $this->payment->createPayment($orderId, 'cod', $totalAmount, 'pending');
                header("Location: index.php?controller=checkout&action=success&order_id=$orderId");
                exit();
            }
        }
    }

    public function success() {
        $orderId = isset($_GET['order_id']) ? $_GET['order_id'] : '';
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        
        $database = new Database();
        $db = $database->getConnection();
        $categoryModel = new Category($db);
        $categories = $categoryModel->getAllActive();

        require_once __DIR__ . '/../views/user/checkout/success.php';
    }

    public function vnpay_return() {
        $vnp_data = $_GET;
        if (vnpayVerifyResponse($vnp_data)) {
            $order_info = explode('_', $vnp_data['vnp_TxnRef']);
            $orderId = str_replace('ORD', '', $order_info[0]);
            
            if ($vnp_data['vnp_ResponseCode'] == '00') {
                // Thanh toán thành công
                $this->payment->updateStatusByTxnRef($vnp_data['vnp_TxnRef'], 'success', $vnp_data['vnp_TransactionNo']);
                header("Location: index.php?controller=checkout&action=success&order_id=$orderId&status=success");
            } else {
                // Thanh toán thất bại hoặc hủy
                $this->payment->updateStatusByTxnRef($vnp_data['vnp_TxnRef'], 'failed', $vnp_data['vnp_TransactionNo']);
                header("Location: index.php?controller=checkout&action=success&order_id=$orderId&status=failed&message=Giao dịch không thành công");
            }
        } else {
            header("Location: index.php?controller=checkout&action=success&error=Chữ ký không hợp lệ");
        }
        exit();
    }
}
?>
