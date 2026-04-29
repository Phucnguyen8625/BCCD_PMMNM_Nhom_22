<?php
require_once __DIR__ . '/../../config/auth.php';
batBuocDangNhap();

require_once __DIR__ . '/../../config/theme.php';
$themeHienTai = layThemeHienTai();

$pageTitle = 'Trang chủ';
$currentPage = 'home';
$baseUrl = '../';

$bannerList = [
    [
        'title' => 'Khám phá thế giới truyện tranh không giới hạn',
        'subtitle' => 'Cập nhật những bộ truyện mới nhất, nổi bật nhất và được yêu thích nhất mỗi ngày.',
        'image' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=1200&q=80',
        'buttonText' => 'Khám phá ngay',
        'buttonLink' => 'library.php'
    ],
    [
        'title' => 'Kho truyện đa thể loại cho mọi độc giả',
        'subtitle' => 'Từ hành động, phiêu lưu đến tình cảm, học đường, tất cả đều có tại thư viện truyện của bạn.',
        'image' => 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=1200&q=80',
        'buttonText' => 'Xem thư viện',
        'buttonLink' => 'list.php'
    ],
    [
        'title' => 'Theo dõi truyện mới cập nhật mỗi ngày',
        'subtitle' => 'Không bỏ lỡ bất kỳ chương mới nào từ những bộ truyện bạn yêu thích.',
        'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=1200&q=80',
        'buttonText' => 'Xem cập nhật',
        'buttonLink' => '../main.php'
    ],
];

$truyenMoi = [
    ['id' => 1,'title' => 'Hành Trình Ánh Sáng','chapter' => 'Chương 12','genre' => 'Phiêu lưu','status' => 'Mới ra mắt','image' => 'https://picsum.photos/300/420?random=11'],
    ['id' => 2,'title' => 'Học Viện Dị Năng','chapter' => 'Chương 8','genre' => 'Hành động','status' => 'Hot','image' => 'https://picsum.photos/300/420?random=12'],
    ['id' => 3,'title' => 'Lời Nguyền Hoàng Gia','chapter' => 'Chương 20','genre' => 'Kỳ ảo','status' => 'Nổi bật','image' => 'https://picsum.photos/300/420?random=13'],
    ['id' => 4,'title' => 'Thành Phố Bóng Đêm','chapter' => 'Chương 5','genre' => 'Bí ẩn','status' => 'Mới','image' => 'https://picsum.photos/300/420?random=14'],
];

$truyenCapNhat = [
    ['id' => 5,'title' => 'Kiếm Sĩ Cuối Cùng','chapter' => 'Chương 45','genre' => 'Hành động','status' => 'Vừa cập nhật','image' => 'https://picsum.photos/300/420?random=21'],
    ['id' => 6,'title' => 'Công Chúa Và Bóng Tối','chapter' => 'Chương 31','genre' => 'Tình cảm','status' => 'Mới cập nhật','image' => 'https://picsum.photos/300/420?random=22'],
    ['id' => 7,'title' => 'Sát Thủ Học Đường','chapter' => 'Chương 27','genre' => 'Học đường','status' => 'Đang theo dõi','image' => 'https://picsum.photos/300/420?random=23'],
    ['id' => 8,'title' => 'Vương Quốc Trên Mây','chapter' => 'Chương 16','genre' => 'Phiêu lưu','status' => 'Mới cập nhật','image' => 'https://picsum.photos/300/420?random=24'],
];

$truyenNoiBat = [
    ['id' => 9,'title' => 'Ma Pháp Tối Thượng','chapter' => 'Chương 88','genre' => 'Fantasy','status' => 'Top đọc nhiều','image' => 'https://picsum.photos/300/420?random=31'],
    ['id' => 10,'title' => 'Huyền Thoại Long Ấn','chapter' => 'Chương 73','genre' => 'Phiêu lưu','status' => 'Đề cử','image' => 'https://picsum.photos/300/420?random=32'],
    ['id' => 11,'title' => 'Đêm Trắng Thành Phố','chapter' => 'Chương 54','genre' => 'Trinh thám','status' => 'Nổi bật tuần','image' => 'https://picsum.photos/300/420?random=33'],
    ['id' => 12,'title' => 'Chiến Binh Huyết Nguyệt','chapter' => 'Chương 60','genre' => 'Hành động','status' => 'Xu hướng','image' => 'https://picsum.photos/300/420?random=34'],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../../assets/css/public/header/indexStyle.css">
</head>
<body class="theme-<?= htmlspecialchars($themeHienTai) ?>">
    <?php
    if (file_exists(__DIR__ . '/../../include/user/userHeader.php')) {
        include __DIR__ . '/../../include/user/userHeader.php';
    }
    ?>

    <main class="home-page">
        <section class="hero-banner">
            <div class="hero-banner__slider" id="heroSlider">
                <?php foreach ($bannerList as $index => $banner): ?>
                    <article
                        class="hero-slide <?php echo $index === 0 ? 'active' : ''; ?>"
                        style="background-image: linear-gradient(rgba(14, 19, 35, 0.55), rgba(14, 19, 35, 0.7)), url('<?php echo htmlspecialchars($banner['image']); ?>');"
                    >
                        <div class="hero-slide__content">
                            <span class="hero-slide__badge">Nền tảng đọc truyện</span>
                            <h1><?php echo htmlspecialchars($banner['title']); ?></h1>
                            <p><?php echo htmlspecialchars($banner['subtitle']); ?></p>
                            <div class="hero-slide__actions">
                                <a href="<?php echo htmlspecialchars($banner['buttonLink']); ?>" class="hero-btn hero-btn--primary">
                                    <?php echo htmlspecialchars($banner['buttonText']); ?>
                                </a>
                                <a href="storyMarket.php" class="hero-btn hero-btn--secondary">Xem đề cử</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="hero-banner__dots" id="heroDots">
                <?php foreach ($bannerList as $index => $banner): ?>
                    <button type="button" class="hero-banner__dot <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?php echo $index; ?>"></button>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="home-section">
            <div class="section-heading">
                <div>
                    <span class="section-heading__label">Mục mới</span>
                    <h2>Truyện mới</h2>
                </div>
                <a href="library.php" class="section-heading__link">Xem tất cả</a>
            </div>

            <div class="story-grid">
                <?php foreach ($truyenMoi as $truyen): ?>
                    <article class="story-card">
                        <a href="../main.php?id=<?php echo (int)$truyen['id']; ?>" class="story-card__image-wrap">
                            <img src="<?php echo htmlspecialchars($truyen['image']); ?>" alt="<?php echo htmlspecialchars($truyen['title']); ?>">
                            <span class="story-card__tag"><?php echo htmlspecialchars($truyen['status']); ?></span>
                        </a>
                        <div class="story-card__content">
                            <h3>
                                <a href="../main.php?id=<?php echo (int)$truyen['id']; ?>">
                                    <?php echo htmlspecialchars($truyen['title']); ?>
                                </a>
                            </h3>
                            <p><?php echo htmlspecialchars($truyen['genre']); ?></p>
                            <span><?php echo htmlspecialchars($truyen['chapter']); ?></span>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="home-section home-section--alt">
            <div class="section-heading">
                <div>
                    <span class="section-heading__label">Theo dõi ngay</span>
                    <h2>Truyện mới cập nhật</h2>
                </div>
                <a href="list.php" class="section-heading__link">Xem thêm</a>
            </div>

            <div class="story-grid">
                <?php foreach ($truyenCapNhat as $truyen): ?>
                    <article class="story-card">
                        <a href="../main.php?id=<?php echo (int)$truyen['id']; ?>" class="story-card__image-wrap">
                            <img src="<?php echo htmlspecialchars($truyen['image']); ?>" alt="<?php echo htmlspecialchars($truyen['title']); ?>">
                            <span class="story-card__tag"><?php echo htmlspecialchars($truyen['status']); ?></span>
                        </a>
                        <div class="story-card__content">
                            <h3>
                                <a href="../main.php?id=<?php echo (int)$truyen['id']; ?>">
                                    <?php echo htmlspecialchars($truyen['title']); ?>
                                </a>
                            </h3>
                            <p><?php echo htmlspecialchars($truyen['genre']); ?></p>
                            <span><?php echo htmlspecialchars($truyen['chapter']); ?></span>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="home-section">
            <div class="section-heading">
                <div>
                    <span class="section-heading__label">Được yêu thích</span>
                    <h2>Truyện nổi bật</h2>
                </div>
                <a href="storyMarket.php" class="section-heading__link">Khám phá</a>
            </div>

            <div class="story-grid">
                <?php foreach ($truyenNoiBat as $truyen): ?>
                    <article class="story-card">
                        <a href="../main.php?id=<?php echo (int)$truyen['id']; ?>" class="story-card__image-wrap">
                            <img src="<?php echo htmlspecialchars($truyen['image']); ?>" alt="<?php echo htmlspecialchars($truyen['title']); ?>">
                            <span class="story-card__tag"><?php echo htmlspecialchars($truyen['status']); ?></span>
                        </a>
                        <div class="story-card__content">
                            <h3>
                                <a href="../main.php?id=<?php echo (int)$truyen['id']; ?>">
                                    <?php echo htmlspecialchars($truyen['title']); ?>
                                </a>
                            </h3>
                            <p><?php echo htmlspecialchars($truyen['genre']); ?></p>
                            <span><?php echo htmlspecialchars($truyen['chapter']); ?></span>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php
    if (file_exists(__DIR__ . '/../../include/user/userFooter.php')) {
        include __DIR__ . '/../../include/user/userFooter.php';
    }
    ?>

    <script src="../../assets/js/public/header/index.js"></script>
</body>
</html>
