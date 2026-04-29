<?php
require_once __DIR__ . '/../../config/auth.php';
batBuocDangNhap();

require_once __DIR__ . '/../../config/theme.php';
$themeHienTai = layThemeHienTai();

$pageTitle = 'Thư viện';
$currentPage = 'library';
$baseUrl = '../';

$danhMuc = ['Tất cả', 'Hành động', 'Phiêu lưu', 'Kỳ ảo', 'Học đường', 'Tình cảm', 'Bí ẩn'];

$thuVienTruyen = [
    ['id' => 1,'title' => 'Hành Trình Ánh Sáng','chapter' => 'Chương 12','genre' => 'Phiêu lưu','status' => 'Đang đọc','category' => 'phieu-luu','rating' => '4.8','image' => 'https://picsum.photos/320/420?random=101'],
    ['id' => 2,'title' => 'Học Viện Dị Năng','chapter' => 'Chương 8','genre' => 'Hành động','status' => 'Yêu thích','category' => 'hanh-dong','rating' => '4.9','image' => 'https://picsum.photos/320/420?random=102'],
    ['id' => 3,'title' => 'Lời Nguyền Hoàng Gia','chapter' => 'Chương 20','genre' => 'Kỳ ảo','status' => 'Đã lưu','category' => 'ky-ao','rating' => '4.7','image' => 'https://picsum.photos/320/420?random=103'],
    ['id' => 4,'title' => 'Thành Phố Bóng Đêm','chapter' => 'Chương 5','genre' => 'Bí ẩn','status' => 'Theo dõi','category' => 'bi-an','rating' => '4.6','image' => 'https://picsum.photos/320/420?random=104'],
    ['id' => 5,'title' => 'Kiếm Sĩ Cuối Cùng','chapter' => 'Chương 45','genre' => 'Hành động','status' => 'Đang đọc','category' => 'hanh-dong','rating' => '4.9','image' => 'https://picsum.photos/320/420?random=105'],
    ['id' => 6,'title' => 'Công Chúa Và Bóng Tối','chapter' => 'Chương 31','genre' => 'Tình cảm','status' => 'Đã lưu','category' => 'tinh-cam','rating' => '4.5','image' => 'https://picsum.photos/320/420?random=106'],
    ['id' => 7,'title' => 'Sát Thủ Học Đường','chapter' => 'Chương 27','genre' => 'Học đường','status' => 'Theo dõi','category' => 'hoc-duong','rating' => '4.4','image' => 'https://picsum.photos/320/420?random=107'],
    ['id' => 8,'title' => 'Vương Quốc Trên Mây','chapter' => 'Chương 16','genre' => 'Phiêu lưu','status' => 'Yêu thích','category' => 'phieu-luu','rating' => '4.8','image' => 'https://picsum.photos/320/420?random=108'],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="../../assets/css/public/header/libraryStyle.css">
</head>
<body class="theme-<?= htmlspecialchars($themeHienTai) ?>">
    <?php
    if (file_exists(__DIR__ . '/../../include/user/userHeader.php')) {
        include __DIR__ . '/../../include/user/userHeader.php';
    }
    ?>

    <main class="library-page">
        <section class="library-hero">
            <div class="library-hero__content">
                <span class="library-hero__badge">Không gian cá nhân</span>
                <h1>Thư viện truyện của bạn</h1>
                <p>Lưu lại những bộ truyện yêu thích, theo dõi chương mới và tiếp tục hành trình đọc với giao diện đồng bộ cùng trang Khám phá.</p>
                <div class="library-hero__actions">
                    <a href="list.php" class="library-btn library-btn--primary">Chọn truyện</a>
                    <a href="storyMarket.php" class="library-btn library-btn--secondary">Xem đề cử</a>
                </div>
            </div>
        </section>

        <section class="library-toolbar">
            <div class="library-toolbar__search">
                <input type="text" id="librarySearchInput" placeholder="Tìm trong thư viện của bạn...">
            </div>

            <div class="library-toolbar__chips">
                <?php
                $mapDanhMuc = [
                    'Tất cả' => 'tat-ca',
                    'Hành động' => 'hanh-dong',
                    'Phiêu lưu' => 'phieu-luu',
                    'Kỳ ảo' => 'ky-ao',
                    'Học đường' => 'hoc-duong',
                    'Tình cảm' => 'tinh-cam',
                    'Bí ẩn' => 'bi-an',
                ];
                ?>
                <?php foreach ($danhMuc as $index => $item): ?>
                    <button type="button" class="library-chip <?= $index === 0 ? 'active' : '' ?>" data-filter="<?= htmlspecialchars($mapDanhMuc[$item] ?? 'tat-ca') ?>">
                        <?= htmlspecialchars($item) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="library-overview">
            <div class="library-stat"><strong>128</strong><span>Tổng truyện đã lưu</span></div>
            <div class="library-stat"><strong>34</strong><span>Đang theo dõi</span></div>
            <div class="library-stat"><strong>19</strong><span>Đang đọc</span></div>
            <div class="library-stat"><strong>92%</strong><span>Tỉ lệ hoàn thành tuần này</span></div>
        </section>

        <section class="library-section">
            <div class="section-heading">
                <div>
                    <span class="section-heading__label">Kho cá nhân</span>
                    <h2>Truyện trong thư viện</h2>
                </div>
                <a href="list.php" class="section-heading__link">Mở danh sách truyện</a>
            </div>

            <div class="story-grid">
                <div class="library-empty" id="libraryEmptyState" style="display: none;">
                    Không tìm thấy truyện phù hợp trong thư viện của bạn.
                </div>
                <?php foreach ($thuVienTruyen as $truyen): ?>
                    <article class="story-card library-filter-item"
                        data-category="<?= htmlspecialchars($truyen['category']) ?>"
                        data-title="<?= htmlspecialchars(mb_strtolower($truyen['title'])) ?>"
                        data-genre="<?= htmlspecialchars(mb_strtolower($truyen['genre'])) ?>"
                        data-status="<?= htmlspecialchars(mb_strtolower($truyen['status'])) ?>">
                        <a href="../main.php?id=<?= (int)$truyen['id'] ?>" class="story-card__image-wrap">
                            <img src="<?= htmlspecialchars($truyen['image']) ?>" alt="<?= htmlspecialchars($truyen['title']) ?>">
                            <span class="story-card__tag"><?= htmlspecialchars($truyen['status']) ?></span>
                        </a>

                        <div class="story-card__content">
                            <h3><a href="../main.php?id=<?= (int)$truyen['id'] ?>"><?= htmlspecialchars($truyen['title']) ?></a></h3>
                            <p><?= htmlspecialchars($truyen['genre']) ?></p>

                            <div class="story-card__meta">
                                <span><?= htmlspecialchars($truyen['chapter']) ?></span>
                                <strong>★ <?= htmlspecialchars($truyen['rating']) ?></strong>
                            </div>

                            <div class="story-card__actions">
                                <a href="../main.php?id=<?= (int)$truyen['id'] ?>" class="story-action story-action--primary">Đọc tiếp</a>
                                <a href="list.php?id=<?= (int)$truyen['id'] ?>" class="story-action">Chi tiết</a>
                            </div>
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
    <script src="../../assets/js/public/header/library.js"></script>
</body>
</html>