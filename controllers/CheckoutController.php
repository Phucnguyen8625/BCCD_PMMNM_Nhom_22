<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Comic.php';
require_once __DIR__ . '/../config/database.php';

class CheckoutController {
    private $order;
    private $payment;

    public function __construct() {
        $this->order = new Order();
        $this->payment = new Payment();
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
                $this->payment->createPayment($orderId, 'vnpay', $totalAmount, 'pending');
                header("Location: index.php?controller=checkout&action=success&order_id=$orderId&method=vnpay_mock");
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
        require_once __DIR__ . '/../views/user/checkout/success.php';
    }
}
?>
