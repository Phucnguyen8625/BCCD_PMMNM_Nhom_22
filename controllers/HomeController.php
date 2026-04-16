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
                'image' => !empty($row['image_url']) ? $row['image_url'] : 'https://dummyimage.com/200x250/2c5282/ffffff&text=No+Image'
            ];
        }

        // If no real comics are added yet, fallback to some mock data to keep layout from breaking
        if(empty($newComics)) {
            $newComics = [
                ['id' => 1, 'title' => 'Dragon Ball Super Tập 10', 'price' => '22.000', 'stock' => 'Còn hàng', 'image' => 'https://dummyimage.com/200x250/2c5282/ffffff&text=New+1'],
                ['id' => 2, 'title' => 'Jujutsu Kaisen Tập 1', 'price' => '38.000', 'stock' => 'Còn hàng', 'image' => 'https://dummyimage.com/200x250/2b6cb0/ffffff&text=New+2'],
                ['id' => 3, 'title' => 'Demon Slayer Bộ Đôi', 'price' => '65.000', 'stock' => 'Sắp hết', 'image' => 'https://dummyimage.com/200x250/4299e1/ffffff&text=New+3'],
                ['id' => 4, 'title' => 'Spy x Family Tập 8', 'price' => '30.000', 'stock' => 'Còn hàng', 'image' => 'https://dummyimage.com/200x250/3182ce/ffffff&text=New+4']
            ];
        }

        // Mock data selling comics (Truyện đề cử / Nổi bật - still mock for layout)
        $featuredComics = [
            [
                'id' => 1,
                'title' => 'Conan Manga Special 28',
                'price' => '35.000',
                'old_price' => '45.000',
                'discount' => '-22%',
                'image' => 'https://cinema.momocdn.net/img/89520077420501400-conannn.png?size=M'
            ],
            [
                'id' => 2,
                'title' => 'One Piece Tập Đặc Biệt',
                'price' => '25.000',
                'old_price' => '',
                'discount' => '',
                'image' => 'https://nhasachquangloi.vn/pub/media/catalog/product/cache/3bd4b739bad1f096e12e3a82b40e551a/o/n/one_piece_t_p_100_th_ng_1.jpg'
            ],
            [
                'id' => 3,
                'title' => 'Naruto Bản Tiếng Việt',
                'price' => '20.000',
                'old_price' => '25.000',
                'discount' => '-20%',
                'image' => 'https://product.hstatic.net/1000376556/product/naruto_5_8c6f24daefd6464d9111fc6a5fa75b21_grande.jpg'
            ],
            [
                'id' => 4,
                'title' => 'Doraemon Truyện Dài',
                'price' => '18.000',
                'old_price' => '',
                'discount' => '',
                'image' => 'https://cdn.hstatic.net/products/1000376556/au_phien_ban_moi_nobita_va_binh_doan_nguoi_sat_doi_canh_thien_than_bia_6d3bfa266979410b9632e511f06d819c_1024x1024.jpg'
            ],
            [
                'id' => 1,
                'title' => 'Thám tử Kindaichi',
                'price' => '30.000',
                'old_price' => '40.000',
                'discount' => '-25%',
                'image' => 'https://www.nxbtre.com.vn/Images/Book/nxbtre_full_15142019_021426.jpg'
            ]
        ];

        // Mock data for Top chart (Bán chạy nhất - mock logic)
        $topComics = [
            ['rank' => '01', 'title' => 'Conan Tập Kỷ Niệm 100', 'sold' => '3.500', 'price' => '35.000 đ', 'image' => 'https://nhasachquangloi.vn/pub/media/catalog/product/cache/3bd4b739bad1f096e12e3a82b40e551a/c/o/conan100-limited.jpg'],
            ['rank' => '02', 'title' => 'One Piece Tập Trọn Bộ', 'sold' => '2.100', 'price' => '500.000 đ', 'image' => 'https://scontent-hkg4-1.xx.fbcdn.net/v/t39.30808-6/486157542_122136105170406878_3422918325341569612_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=e06c5d&_nc_eui2=AeFaXpjrsb5Mts6SS44holtBMED5SeWGoFgwQPlJ5YagWAaGv635DYZVSBWA8aEW-XdOonBOiWxZ1qjPY79qP_Bk&_nc_ohc=595gtmGN45UQ7kNvwHjBWEI&_nc_oc=AdoIS9CJEQh44ylX13ZJ7cKJ1LCVL8b01JA5h_MKLHHpLOBxq3IYgs3uBkg4fqtCB6e5MSApu0cijBNALunM1NpX&_nc_zt=23&_nc_ht=scontent-hkg4-1.xx&_nc_gid=p_tieI9zYXhgXaj3Dre64g&_nc_ss=7a3a8&oh=00_Af17hQhdXWufnwKXqcbomxUGWCYRSi5ZwGjmuK-kA9_jIA&oe=69E620B2'],
            ['rank' => '03', 'title' => 'Jujutsu Kaisen Combo', 'sold' => '1.800', 'price' => '150.000 đ', 'image' => 'https://cdn1.fahasa.com/media/catalog/product/c/h/chu_thuat_hoi_chien_ban_dac_biet_mockup_tap_19_3.jpg'],
            ['rank' => '04', 'title' => 'Spy x Family Tập 1-5', 'sold' => '850', 'price' => '120.000 đ', 'image' => 'https://cdn1.fahasa.com/media/flashmagazine/images/page_images/spy_x_family___tap_1_tai_ban_2025/2025_03_31_11_52_35_1-390x510.jpg']
        ];

        require_once __DIR__ . '/../views/user/home/index.php';
    }
}
?>
