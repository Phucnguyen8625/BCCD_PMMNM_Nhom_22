<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Comic.php';
require_once __DIR__ . '/../models/Category.php';

class HomeController {
    public function index() {
        $database = new Database();
        $db = $database->getConnection();
        $comicModel = new Comic($db);
        
        // 1. Featured / Sale Comics
        $saleStmt = $comicModel->readByFlag('is_sale');
        $featuredComicsRaw = $saleStmt->fetchAll(PDO::FETCH_ASSOC);
        
        $featuredComics = [];
        foreach($featuredComicsRaw as $row) {
            $featuredComics[] = [
                'id' => $row['id'],
                'title' => $row['name'],
                'price' => number_format($row['price'], 0, ',', '.'),
                'old_price' => number_format($row['price'] * 1.25, 0, ',', '.'), // Mock old price for display
                'discount' => '-20%',
                'image' => !empty($row['image_url']) ? $row['image_url'] : 'https://dummyimage.com/200x250/2c5282/ffffff&text=Sale',
                'category' => $row['category_name']
            ];
        }

        // 2. New Comics
        $allStmt = $comicModel->readAll();
        $realComics = $allStmt->fetchAll(PDO::FETCH_ASSOC);

        $newComics = [];
        foreach(array_slice($realComics, 0, 10) as $row) {
            $newComics[] = [
                'id' => $row['id'],
                'title' => $row['name'],
                'price' => number_format($row['price'], 0, ',', '.'),
                'stock' => $row['quantity'] > 0 ? 'Còn hàng' : 'Hết hàng',
                'image' => !empty($row['image_url']) ? $row['image_url'] : 'https://dummyimage.com/200x250/2c5282/ffffff&text=New',
                'category' => $row['category_name']
            ];
        }

        // 3. Top Bestseller Chart (Sidebar)
        $bestStmt = $comicModel->readByFlag('is_bestseller');
        $bestRaw = $bestStmt->fetchAll(PDO::FETCH_ASSOC);
        
        $topComics = [];
        $rank = 1;
        foreach(array_slice($bestRaw, 0, 5) as $row) {
            $topComics[] = [
                'rank' => str_pad($rank++, 2, "0", STR_PAD_LEFT),
                'id' => $row['id'],
                'title' => $row['name'],
                'price' => number_format($row['price'], 0, ',', '.') . ' đ',
                'sold' => rand(100, 5000), // Mock data as we don't track sales yet
                'image' => !empty($row['image_url']) ? $row['image_url'] : 'https://dummyimage.com/100x130/2c5282/ffffff&text=Top',
                'category' => $row['category_name']
            ];
        }

        // 4. Cheap Comics (Sidebar Tab 2)
        $cheapStmt = $comicModel->readCheap(5);
        $cheapRaw = $cheapStmt->fetchAll(PDO::FETCH_ASSOC);
        $cheapComics = [];
        foreach($cheapRaw as $row) {
            $cheapComics[] = [
                'id' => $row['id'],
                'title' => $row['name'],
                'price' => number_format($row['price'], 0, ',', '.') . ' đ',
                'image' => !empty($row['image_url']) ? $row['image_url'] : 'https://dummyimage.com/100x130/2c5282/ffffff&text=Cheap'
            ];
        }

        // 5. Pre-order (Sidebar Tab 3)
        $preStmt = $comicModel->readByFlag('is_preorder');
        $preRaw = $preStmt->fetchAll(PDO::FETCH_ASSOC);
        $preComics = [];
        foreach(array_slice($preRaw, 0, 5) as $row) {
            $preComics[] = [
                'id' => $row['id'],
                'title' => $row['name'],
                'price' => number_format($row['price'], 0, ',', '.') . ' đ',
                'image' => !empty($row['image_url']) ? $row['image_url'] : 'https://dummyimage.com/100x130/2c5282/ffffff&text=Pre'
            ];
        }

        // Load categories for nav dropdown
        $categoryModel = new Category($db);
        $categories = $categoryModel->getAllActive();

        require_once __DIR__ . '/../views/user/home/index.php';
    }
}
?>
