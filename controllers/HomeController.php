<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Comic.php';

class HomeController {
    public function index() {
        // Connect to DB and fetch real comics
        $database = new Database();
        $db = $database->getConnection();
        $comicModel = new Comic($db);
        
        $stmt = $comicModel->readAll();
        $realComics = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $newComics = [];
        foreach($realComics as $row) {
            $newComics[] = [
                'id' => $row['id'],
                'title' => $row['name'],
                'price' => number_format($row['price'], 0, ',', '.'),
                'stock' => $row['quantity'] > 0 ? 'Còn hàng (' . $row['quantity'] . ')' : 'Hết hàng',
                'image' => !empty($row['image_url']) ? $row['image_url'] : 'https://via.placeholder.com/200x250/2c5282/ffffff?text=No+Image'
            ];
        }

        // If no real comics are added yet, fallback to some mock data to keep layout from breaking
        if(empty($newComics)) {
            $newComics = [
                ['id' => 1, 'title' => 'Dragon Ball Super Tập 10', 'price' => '22.000', 'stock' => 'Còn hàng', 'image' => 'https://via.placeholder.com/200x250/2c5282/ffffff?text=New+1'],
                ['id' => 2, 'title' => 'Jujutsu Kaisen Tập 1', 'price' => '38.000', 'stock' => 'Còn hàng', 'image' => 'https://via.placeholder.com/200x250/2b6cb0/ffffff?text=New+2'],
                ['id' => 3, 'title' => 'Demon Slayer Bộ Đôi', 'price' => '65.000', 'stock' => 'Sắp hết', 'image' => 'https://via.placeholder.com/200x250/4299e1/ffffff?text=New+3'],
                ['id' => 4, 'title' => 'Spy x Family Tập 8', 'price' => '30.000', 'stock' => 'Còn hàng', 'image' => 'https://via.placeholder.com/200x250/3182ce/ffffff?text=New+4']
            ];
        }

        // Mock data selling comics (Truyện đề cử / Nổi bật - still mock for layout)
        $featuredComics = [
            [
                'id' => 1,
                'title' => 'Conan Tập Kỷ Niệm 100',
                'price' => '35.000',
                'old_price' => '45.000',
                'discount' => '-22%',
                'image' => 'https://via.placeholder.com/300x400/1e1e2f/ffffff?text=Comic+1'
            ],
            [
                'id' => 2,
                'title' => 'One Piece Tập Đặc Biệt',
                'price' => '25.000',
                'old_price' => '',
                'discount' => '',
                'image' => 'https://via.placeholder.com/300x400/2d3748/ffffff?text=Comic+2'
            ],
            [
                'id' => 3,
                'title' => 'Naruto Bản Tiếng Việt',
                'price' => '20.000',
                'old_price' => '25.000',
                'discount' => '-20%',
                'image' => 'https://via.placeholder.com/300x400/4a5568/ffffff?text=Comic+3'
            ],
            [
                'id' => 4,
                'title' => 'Doraemon Truyện Dài',
                'price' => '18.000',
                'old_price' => '',
                'discount' => '',
                'image' => 'https://via.placeholder.com/300x400/718096/ffffff?text=Comic+4'
            ],
            [
                'id' => 1,
                'title' => 'Thám tử Kindaichi',
                'price' => '30.000',
                'old_price' => '40.000',
                'discount' => '-25%',
                'image' => 'https://via.placeholder.com/300x400/2b6cb0/ffffff?text=Comic+5'
            ]
        ];

        // Mock data for Top chart (Bán chạy nhất - mock logic)
        $topComics = [
            ['rank' => '01', 'title' => 'Conan Tập Kỷ Niệm 100', 'sold' => '3.500', 'price' => '35.000 đ', 'image' => 'https://via.placeholder.com/50x70/2c5282/ffffff?text=T1'],
            ['rank' => '02', 'title' => 'One Piece Tập Trọn Bộ', 'sold' => '2.100', 'price' => '500.000 đ', 'image' => 'https://via.placeholder.com/50x70/2b6cb0/ffffff?text=T2'],
            ['rank' => '03', 'title' => 'Jujutsu Kaisen Combo', 'sold' => '1.800', 'price' => '150.000 đ', 'image' => 'https://via.placeholder.com/50x70/4299e1/ffffff?text=T3'],
            ['rank' => '04', 'title' => 'Spy x Family Tập 1-5', 'sold' => '850', 'price' => '120.000 đ', 'image' => 'https://via.placeholder.com/50x70/3182ce/ffffff?text=T4']
        ];

        require_once __DIR__ . '/../views/user/home/index.php';
    }
}
?>
