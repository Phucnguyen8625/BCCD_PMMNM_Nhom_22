<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Comic.php';
require_once __DIR__ . '/../models/Category.php';

class AdminComicController {
    private $db;
    private $comic;
    private $category;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->comic = new Comic($this->db);
        $this->category = new Category($this->db);
    }

    public function index() {
        $stmt = $this->comic->readAll();
        $comics = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../views/admin/comics/index.php';
    }

    public function create() {
        $catStmt = $this->category->readAll();
        $categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../views/admin/comics/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->comic->category_ids = isset($_POST['category_ids']) ? $_POST['category_ids'] : [];
            $this->comic->name = trim($_POST['name']);
            $this->comic->author = trim($_POST['author']);
            $this->comic->price = floatval($_POST['price']);
            $this->comic->quantity = intval($_POST['quantity']);
            $this->comic->description = trim($_POST['description']);
            $this->comic->is_sale = isset($_POST['is_sale']) ? 1 : 0;
            $this->comic->is_combo = isset($_POST['is_combo']) ? 1 : 0;
            $this->comic->is_bestseller = isset($_POST['is_bestseller']) ? 1 : 0;
            $this->comic->is_preorder = isset($_POST['is_preorder']) ? 1 : 0;
            $this->comic->image_url = ""; // default empty

            // Handle Image URL Link choice
            if (!empty($_POST['image_url_link'])) {
                $this->comic->image_url = trim($_POST['image_url_link']);
            } 
            // Handle Image File Upload (only if no URL link provided)
            else if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
                $target_dir = __DIR__ . "/../public/uploads/comics/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $new_filename = time() . '_' . rand(100, 999) . '.' . $file_extension;
                $target_file = $target_dir . $new_filename;
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $this->comic->image_url = "public/uploads/comics/" . $new_filename;
                }
            }

            if (empty($this->comic->name) || $this->comic->price < 0 || $this->comic->quantity < 0) {
                // Return generic error
                header("Location: admin.php?controller=comic&action=create&error=Dữ liệu không hợp lệ");
                exit();
            }

            if ($this->comic->create()) {
                header("Location: admin.php?controller=comic&action=index&success=Tạo truyện thành công");
            } else {
                header("Location: admin.php?controller=comic&action=create&error=Có lỗi hệ thống");
            }
            exit();
        }
    }

    public function edit() {
        if (isset($_GET['id'])) {
            $this->comic->id = $_GET['id'];
            if ($this->comic->readOne()) {
                $catStmt = $this->category->readAll();
                $categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
                require_once __DIR__ . '/../views/admin/comics/edit.php';
            } else {
                header("Location: admin.php?controller=comic&action=index&error=Truyện không tồn tại");
                exit();
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
            $this->comic->id = $_POST['id'];
            $this->comic->readOne(); // to get old image first
            $old_image = $this->comic->image_url;

            $this->comic->category_ids = isset($_POST['category_ids']) ? $_POST['category_ids'] : [];
            $this->comic->name = trim($_POST['name']);
            $this->comic->author = trim($_POST['author']);
            $this->comic->price = floatval($_POST['price']);
            $this->comic->quantity = intval($_POST['quantity']);
            $this->comic->description = trim($_POST['description']);
            $this->comic->is_sale = isset($_POST['is_sale']) ? 1 : 0;
            $this->comic->is_combo = isset($_POST['is_combo']) ? 1 : 0;
            $this->comic->is_bestseller = isset($_POST['is_bestseller']) ? 1 : 0;
            $this->comic->is_preorder = isset($_POST['is_preorder']) ? 1 : 0;
            $this->comic->image_url = $old_image; // keep old by default

            // Handle Image URL Link choice
            if (!empty($_POST['image_url_link'])) {
                $this->comic->image_url = trim($_POST['image_url_link']);
                
                // If we switch to URL, delete old local file if existed
                if(!empty($old_image) && strpos($old_image, 'http') !== 0 && file_exists(__DIR__ . "/../" . $old_image)) {
                    unlink(__DIR__ . "/../" . $old_image);
                }
            }
            // Handle Image File Upload if changed (only if no URL link provided)
            else if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
                $target_dir = __DIR__ . "/../public/uploads/comics/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $new_filename = time() . '_' . rand(100, 999) . '.' . $file_extension;
                $target_file = $target_dir . $new_filename;
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $this->comic->image_url = "public/uploads/comics/" . $new_filename;
                    
                    // delete old image
                    if(!empty($old_image) && file_exists(__DIR__ . "/../" . $old_image)) {
                        unlink(__DIR__ . "/../" . $old_image);
                    }
                }
            }

            if ($this->comic->update()) {
                header("Location: admin.php?controller=comic&action=index&success=Cập nhật truyện thành công");
            } else {
                header("Location: admin.php?controller=comic&action=edit&id=" . $this->comic->id . "&error=Cập nhật lỗi");
            }
            exit();
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $this->comic->id = $_GET['id'];
            $this->comic->readOne();
            $image_to_delete = $this->comic->image_url;

            if ($this->comic->delete()) {
                // delete image
                if(!empty($image_to_delete) && file_exists(__DIR__ . "/../" . $image_to_delete)) {
                    unlink(__DIR__ . "/../" . $image_to_delete);
                }
                header("Location: admin.php?controller=comic&action=index&success=Xóa truyện thành công");
            } else {
                header("Location: admin.php?controller=comic&action=index&error=Lỗi khi xóa");
            }
            exit();
        }
    }
}
?>
