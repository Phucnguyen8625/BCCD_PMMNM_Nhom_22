<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Comic.php';
require_once __DIR__ . '/../models/Category.php';

class SearchController {
    public function index() {
        $database = new Database();
        $db = $database->getConnection();

        $keyword = trim($_GET['q'] ?? '');
        $results = [];

        $comicModel = new Comic($db);
        if (!empty($keyword)) {
            $stmt = $comicModel->search($keyword);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $categoryModel = new Category($db);
        $categories = $categoryModel->getAllActive();

        require_once __DIR__ . '/../views/user/search/index.php';
    }

    public function ajax() {
        header('Content-Type: application/json');
        $database = new Database();
        $db = $database->getConnection();

        $keyword = trim($_GET['q'] ?? '');
        $results = [];

        if (!empty($keyword)) {
            $comicModel = new Comic($db);
            $stmt = $comicModel->search($keyword);
            $comics = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach (array_slice($comics, 0, 8) as $row) {
                $results[] = [
                    'id' => $row['id'],
                    'title' => $row['name'],
                    'price' => number_format($row['price'], 0, ',', '.') . 'đ',
                    'image' => !empty($row['image_url']) ? $row['image_url'] : 'https://dummyimage.com/50x70/2c5282/ffffff&text=Img'
                ];
            }
        }
        
        echo json_encode(['status' => 'success', 'data' => $results]);
        exit;
    }
}
?>
