<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Comic.php';

class CartController {
    
    private $comicModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $database = new Database();
        $db = $database->getConnection();
        $this->comicModel = new Comic($db);

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Hiển thị trang giỏ hàng
    public function index() {
        $cart_items = [];
        $total_price = 0;

        foreach ($_SESSION['cart'] as $comic_id => $quantity) {
            $this->comicModel->id = $comic_id;
            if ($this->comicModel->readOne()) {
                $subtotal = $this->comicModel->price * $quantity;
                $total_price += $subtotal;
                
                $cart_items[] = [
                    'id' => $comic_id,
                    'name' => $this->comicModel->name,
                    'price' => $this->comicModel->price,
                    'quantity' => $quantity,
                    'image' => !empty($this->comicModel->image_url) ? $this->comicModel->image_url : 'https://via.placeholder.com/100x130/2c5282/ffffff?text=No+Img',
                    'subtotal' => $subtotal
                ];
            }
        }

        require_once __DIR__ . '/../views/user/cart/index.php';
    }

    // Thêm sản phẩm vào giỏ
    public function add() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            
            // Lấy thông tin tồn kho
            $this->comicModel->id = $id;
            if ($this->comicModel->readOne() && $this->comicModel->quantity > 0) {
                if (isset($_SESSION['cart'][$id])) {
                    // Nếu quá số lượng tồn kho thì ngăn không cho cộng thêm
                    if($_SESSION['cart'][$id] < $this->comicModel->quantity) {
                        $_SESSION['cart'][$id]++;
                    }
                } else {
                    $_SESSION['cart'][$id] = 1;
                }
                header("Location: index.php?controller=cart&success=Đã thêm truyện vào giỏ hàng!");
            } else {
                header("Location: index.php?controller=home&error=Truyện này đã hết hàng hoặc không tồn tại.");
            }
            exit();
        }
    }

    // Cập nhật số lượng
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantities'])) {
            foreach ($_POST['quantities'] as $id => $quantity) {
                $id = intval($id);
                $quantity = intval($quantity);

                if ($quantity <= 0) {
                    unset($_SESSION['cart'][$id]);
                } else {
                    // Giới hạn max theo tồn kho nếu cần
                    $this->comicModel->id = $id;
                    if($this->comicModel->readOne() && $quantity <= $this->comicModel->quantity) {
                        $_SESSION['cart'][$id] = $quantity;
                    } elseif ($this->comicModel->quantity > 0) {
                        $_SESSION['cart'][$id] = $this->comicModel->quantity; // Lấy Max tồn kho
                    }
                }
            }
        }
        header("Location: index.php?controller=cart&success=Đã cập nhật giỏ hàng!");
        exit();
    }

    // Xóa một sản phẩm
    public function remove() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            if (isset($_SESSION['cart'][$id])) {
                unset($_SESSION['cart'][$id]);
            }
        }
        header("Location: index.php?controller=cart&success=Đã bỏ truyện khỏi giỏ hàng");
        exit();
    }
}
?>
