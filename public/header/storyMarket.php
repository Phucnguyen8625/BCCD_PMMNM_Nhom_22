<?php
require_once __DIR__ . '/../../config/auth.php';
batBuocDangNhap();

require_once __DIR__ . '/../../config/theme.php';
$themeHienTai = layThemeHienTai();

$pageTitle = 'Chợ truyện';
$currentPage = 'market';

$danhMucNoiBat = ['Tất cả','Mới phát hành','Bán chạy','Đề cử','Giảm giá','Cao cấp'];

$goiNoiBat = [
    ['id' => 1,'title' => 'Hành Trình Ánh Sáng','author' => 'Nguyễn Thiên Ân','genre' => 'Phiêu lưu','price' => '49.000đ','old_price' => '79.000đ','badge' => 'Giảm 38%','category' => 'giam-gia','image' => 'https://picsum.photos/320/420?random=301'],
    ['id' => 2,'title' => 'Học Viện Dị Năng','author' => 'Lê Quốc Bảo','genre' => 'Hành động','price' => '59.000đ','old_price' => '89.000đ','badge' => 'Hot','category' => 'ban-chay','image' => 'https://picsum.photos/320/420?random=302'],
    ['id' => 3,'title' => 'Lời Nguyền Hoàng Gia','author' => 'Trần Mỹ Linh','genre' => 'Kỳ ảo','price' => '69.000đ','old_price' => '99.000đ','badge' => 'Đề cử','category' => 'de-cu','image' => 'https://picsum.photos/320/420?random=303'],
    ['id' => 4,'title' => 'Thành Phố Bóng Đêm','author' => 'Phạm Gia Hưng','genre' => 'Bí ẩn','price' => '39.000đ','old_price' => '59.000đ','badge' => 'Mới','category' => 'moi-phat-hanh','image' => 'https://picsum.photos/320/420?random=304'],
];

$sanPhamSo = [
    ['id' => 5,'title' => 'Kiếm Sĩ Cuối Cùng','desc' => 'Bộ truyện hành động bán chạy với bản số đầy đủ chất lượng cao.','chapter' => '45 chương','price' => '89.000đ','image' => 'https://picsum.photos/320/420?random=305'],
    ['id' => 6,'title' => 'Công Chúa Và Bóng Tối','desc' => 'Phiên bản số độc quyền kèm ảnh bìa đặc biệt và trang bonus.','chapter' => '31 chương','price' => '75.000đ','image' => 'https://picsum.photos/320/420?random=306'],
    ['id' => 7,'title' => 'Sát Thủ Học Đường','desc' => 'Trọn bộ tập đầu dành cho người đọc mới tham gia nền tảng.','chapter' => '27 chương','price' => '55.000đ','image' => 'https://picsum.photos/320/420?random=307'],
];

$comboUuDai = [
    ['title' => 'Combo Tân Thủ','subtitle' => '3 bộ truyện nổi bật dành cho người mới','price' => '129.000đ'],
    ['title' => 'Combo Hành Động','subtitle' => 'Bộ sưu tập truyện chiến đấu và phiêu lưu','price' => '159.000đ'],
    ['title' => 'Combo Kỳ Ảo','subtitle' => 'Các tác phẩm phép thuật và thế giới mở rộng','price' => '145.000đ'],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="../../assets/css/public/header/storyMarketStyle.css">
</head>
<body class="theme-<?= htmlspecialchars($themeHienTai) ?>">
    <?php
    if (file_exists(__DIR__ . '/../../include/user/userHeader.php')) {
        include __DIR__ . '/../../include/user/userHeader.php';
    }
    ?>

    <main class="market-page">
        <section class="market-hero">
            <div class="market-hero__content">
                <span class="market-hero__badge">Không gian mua truyện</span>
                <h1>Chợ truyện số dành cho bạn</h1>
                <p>Khám phá các bộ truyện nổi bật, gói ưu đãi và phiên bản kỹ thuật số được chọn lọc để bạn mua nhanh, đọc ngay trên nền tảng.</p>

                <div class="market-hero__actions">
                    <a href="#featuredMarket" class="market-btn market-btn--primary">Mua ngay</a>
                    <a href="#comboMarket" class="market-btn market-btn--secondary">Xem combo</a>
                </div>
            </div>
        </section>

        <section class="market-toolbar">
            <div class="market-toolbar__search">
                <input type="text" id="marketSearchInput" placeholder="Tìm truyện, tác giả, thể loại...">
            </div>

            <div class="market-toolbar__chips">
                <?php
                $mapDanhMuc = [
                    'Tất cả' => 'tat-ca',
                    'Mới phát hành' => 'moi-phat-hanh',
                    'Bán chạy' => 'ban-chay',
                    'Đề cử' => 'de-cu',
                    'Giảm giá' => 'giam-gia',
                    'Cao cấp' => 'cao-cap',
                ];
                ?>
                <?php foreach ($danhMucNoiBat as $index => $item): ?>
                    <button type="button" class="market-chip <?= $index === 0 ? 'active' : '' ?>" data-filter="<?= htmlspecialchars($mapDanhMuc[$item] ?? 'tat-ca') ?>">
                        <?= htmlspecialchars($item) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="market-stats">
            <div class="market-stat"><strong>1.250+</strong><span>Tác phẩm đang mở bán</span></div>
            <div class="market-stat"><strong>320</strong><span>Ưu đãi trong tuần</span></div>
            <div class="market-stat"><strong>99K</strong><span>Người dùng đã mua</span></div>
            <div class="market-stat"><strong>24/7</strong><span>Mua và đọc tức thì</span></div>
        </section>

        <section class="market-section" id="featuredMarket">
            <div class="section-heading">
                <div>
                    <span class="section-heading__label">Nổi bật hôm nay</span>
                    <h2>Truyện đang được quan tâm</h2>
                </div>
                <a href="#" class="section-heading__link">Xem tất cả</a>
            </div>

            <div class="market-grid">
                <div class="market-empty" id="marketEmptyState" style="display: none;">
                    Không tìm thấy truyện phù hợp với bộ lọc hoặc từ khóa bạn nhập.
                </div>
                <?php foreach ($goiNoiBat as $truyen): ?>
                    <article class="market-card market-filter-item"
                        data-category="<?= htmlspecialchars($truyen['category']) ?>"
                        data-title="<?= htmlspecialchars(mb_strtolower($truyen['title'])) ?>"
                        data-author="<?= htmlspecialchars(mb_strtolower($truyen['author'])) ?>"
                        data-genre="<?= htmlspecialchars(mb_strtolower($truyen['genre'])) ?>">
                        <a href="../main.php?id=<?= (int)$truyen['id'] ?>" class="market-card__image-wrap">
                            <img src="<?= htmlspecialchars($truyen['image']) ?>" alt="<?= htmlspecialchars($truyen['title']) ?>">
                            <span class="market-card__tag"><?= htmlspecialchars($truyen['badge']) ?></span>
                        </a>

                        <div class="market-card__content">
                            <h3><a href="../main.php?id=<?= (int)$truyen['id'] ?>"><?= htmlspecialchars($truyen['title']) ?></a></h3>
                            <p class="market-card__author"><?= htmlspecialchars($truyen['author']) ?></p>
                            <p class="market-card__genre"><?= htmlspecialchars($truyen['genre']) ?></p>

                            <div class="market-card__price">
                                <strong><?= htmlspecialchars($truyen['price']) ?></strong>
                                <span><?= htmlspecialchars($truyen['old_price']) ?></span>
                            </div>

                            <div class="market-card__actions">
                                <a href="../main.php?id=<?= (int)$truyen['id'] ?>" class="market-action market-action--primary">Xem truyện</a>
                                <a href="library.php" class="market-action">Thêm thư viện</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="market-section market-section--alt">
            <div class="section-heading">
                <div>
                    <span class="section-heading__label">Phiên bản số</span>
                    <h2>Gói truyện kỹ thuật số</h2>
                </div>
                <a href="#" class="section-heading__link">Khám phá thêm</a>
            </div>

            <div class="product-list">
                <?php foreach ($sanPhamSo as $item): ?>
                    <article class="product-row">
                        <a href="../main.php?id=<?= (int)$item['id'] ?>" class="product-row__thumb">
                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                        </a>

                        <div class="product-row__body">
                            <h3><a href="../main.php?id=<?= (int)$item['id'] ?>"><?= htmlspecialchars($item['title']) ?></a></h3>
                            <p class="product-row__desc"><?= htmlspecialchars($item['desc']) ?></p>

                            <div class="product-row__meta">
                                <span><?= htmlspecialchars($item['chapter']) ?></span>
                                <strong><?= htmlspecialchars($item['price']) ?></strong>
                            </div>

                            <div class="product-row__actions">
                                <a href="../main.php?id=<?= (int)$item['id'] ?>" class="market-btn-inline market-btn-inline--primary">Mua ngay</a>
                                <a href="list.php" class="market-btn-inline">Xem chi tiết</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="market-section" id="comboMarket">
            <div class="section-heading">
                <div>
                    <span class="section-heading__label">Ưu đãi tiết kiệm</span>
                    <h2>Combo truyện đề cử</h2>
                </div>
            </div>

            <div class="combo-grid">
                <?php foreach ($comboUuDai as $combo): ?>
                    <article class="combo-card">
                        <span class="combo-card__badge">Combo</span>
                        <h3><?= htmlspecialchars($combo['title']) ?></h3>
                        <p><?= htmlspecialchars($combo['subtitle']) ?></p>
                        <strong><?= htmlspecialchars($combo['price']) ?></strong>
                        <a href="#" class="combo-card__button">Mua combo</a>
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
    <script src="../../assets/js/public/header/storyMarket.js"></script>
</body>
</html>