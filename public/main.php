<?php
require_once __DIR__ . '/../config/auth.php';
batBuocDangNhap();

$pageTitle = 'Chi tiáº¿t truyá»‡n';
require_once __DIR__ . '/../config/webConfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/theme.php';
$themeHienTai = layThemeHienTai();

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('kiemTraDangNhapNguoiDung')) {
    function kiemTraDangNhapNguoiDung(): bool
    {
        return !empty($_SESSION['user_logged_in']) || !empty($_SESSION['user']) || !empty($_SESSION['user_login']);
    }
}

if (!kiemTraDangNhapNguoiDung()) {
    header('Location: ./sign/up/login.php');
    exit;
}

$danhSachTruyen = [
    1 => [
        'id' => 1,
        'ten' => 'Neon Drifters',
        'gia' => '119.000Ä‘',
        'theLoai' => 'Khoa há»c viá»…n tÆ°á»Ÿng',
        'tacGia' => 'Aoi Vector',
        'soChuong' => 24,
        'danhGia' => '4.9/5',
        'moTa' => 'Neon Drifters theo chÃ¢n má»™t nhÃ³m courier chuyÃªn váº­n chuyá»ƒn kÃ½ á»©c sá»‘ trong thÃ nh phá»‘ khÃ´ng bao giá» ngá»§. Khi má»™t gÃ³i dá»¯ liá»‡u bá»‹ Ä‘Ã¡nh cáº¯p, há» buá»™c pháº£i Ä‘i qua nhá»¯ng táº§ng lá»›p bÃ­ máº­t cá»§a Ä‘Ã´ thá»‹ Ä‘á»ƒ tÃ¬m ra sá»± tháº­t.',
        'anh' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAes87Fv5ozt2posbJn-K-iVS9kdI2gA2w2VgU12Fe-acGIm64WMFPwzCIQBCOXXHCGAI6Oj0rAlEVV6rgi3aG9j4ov6n2Y_9aSsHW55sZOiW6C2KIrKdnCOkAQ0-qPFLC7n8hT6zPmvo1-OEqDJspIBPIcdklGrs_83aD9K5lHfaHnGKIywWPmU6m7ASG9dVMNFvrG9S_1Fqd_SZuVT3qMURikJNjtdnhQ5Ag9Q-tvua32LaBzVcuAxMtbZ5HiThKDjsdboPIMwmaH',
        'chuongMoi' => ['ChÆ°Æ¡ng 22: Máº­t mÃ£ dÆ°á»›i chÃ¢n cáº§u', 'ChÆ°Æ¡ng 23: NgÆ°á»i giá»¯ Ã¡nh Ä‘Ã¨n', 'ChÆ°Æ¡ng 24: ThÃ nh phá»‘ pháº£n chiáº¿u'],
    ],
    2 => [
        'id' => 2,
        'ten' => 'The Ember King',
        'gia' => '299.000Ä‘',
        'theLoai' => 'Ká»³ áº£o',
        'tacGia' => 'Linh Flame',
        'soChuong' => 30,
        'danhGia' => '4.8/5',
        'moTa' => 'Trong Ä‘á»‘ng tro tÃ n cá»§a Ä‘áº¿ cháº¿ cÅ©, má»™t ngÆ°á»i thá»«a káº¿ tráº» tuá»•i phÃ¡t hiá»‡n sá»©c máº¡nh cá»§a vÆ°Æ¡ng miá»‡n lá»­a. CÃ ng tiáº¿n gáº§n ngai vÃ ng, cáº­u cÃ ng pháº£i Ä‘Ã¡nh Ä‘á»•i nhiá»u hÆ¡n giá»¯a quyá»n lá»±c vÃ  lÃ²ng tráº¯c áº©n.',
        'anh' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAF4Z1YV7iRpcusut8Rxv0dI4RD77Cn1IjLEmka9811sO_PhaOFRftDDPtxKaVLbunOeHaH-JLxN_Xx1Q5B-sF_IgPNw9lLLH3o4jeyEbcVQ-gOHXMhuLQ9LFUttFO1EzGBq4dsw4i3DlMJqSD3AnQwqY0hHCK9QAaszs0iWov-70pTJ9-9bl8uZ9cSqFlQ0rVI_WJoQrTHaUTaIyU_tWRV8FqFfuxDaMhtlvFd-2IMt2nL5qoLwQZcrg08IDuG79KUkaJ60BFcOYVE',
        'chuongMoi' => ['ChÆ°Æ¡ng 28: Ngá»n lá»­a tuyÃªn thá»‡', 'ChÆ°Æ¡ng 29: Tro tÃ n rá»±c Ä‘á»', 'ChÆ°Æ¡ng 30: Vua trá»Ÿ láº¡i'],
    ],
    3 => [
        'id' => 3,
        'ten' => 'Moss & Moonlight',
        'gia' => '79.000Ä‘',
        'theLoai' => 'PhiÃªu lÆ°u',
        'tacGia' => 'Má»™c Lam',
        'soChuong' => 18,
        'danhGia' => '4.7/5',
        'moTa' => 'Má»™t khu rá»«ng cá»• chá»©a chiáº¿c gÆ°Æ¡ng cá»§a máº·t trÄƒng. TrÃªn hÃ nh trÃ¬nh tÃ¬m sá»± tháº­t vá» gia Ä‘Ã¬nh, cÃ´ gÃ¡i tráº» káº¿t báº¡n vá»›i nhá»¯ng sinh váº­t bÃ­ áº©n vÃ  há»c cÃ¡ch láº¯ng nghe tiáº¿ng nÃ³i cá»§a thiÃªn nhiÃªn.',
        'anh' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB2Pa5W0ejbol_UBuCHJF7Qj3nlV1kYH-_GsI-iVNaUaCDfcbsG-ZkvH0gs7Rx3Cm44Br1TpnzU8DEnYhzbnlPzmxAjK6p3D8yXyq46WkTPVKOjdYb5hi1hQqZrhwUU7c0x4hoi9HZ0pmilhJS43jtSUmi6z0QkV42xRH-oBnbG9bQCKoSxMu95pOcDGBkZ1dw6Pn0TwUo77VuIYoKsVoo569KaAo6d78hn4K-P6sWpiaLiL6Bh7C1jm8DQzMjNOFOf_XOuCCcGZpWL',
        'chuongMoi' => ['ChÆ°Æ¡ng 16: CÃ¡nh cá»­a rÃªu xanh', 'ChÆ°Æ¡ng 17: GiÃ³ qua há»“ báº¡c', 'ChÆ°Æ¡ng 18: DÆ°á»›i trÄƒng Ä‘áº§u mÃ¹a'],
    ],
    4 => [
        'id' => 4,
        'ten' => 'Void Voyager',
        'gia' => '99.000Ä‘',
        'theLoai' => 'HÃ nh Ä‘á»™ng',
        'tacGia' => 'K. Orion',
        'soChuong' => 21,
        'danhGia' => '4.8/5',
        'moTa' => 'TÃ u Voyager vÆ°á»£t ra ngoÃ i quá»¹ Ä‘áº¡o an toÃ n vÃ  Ä‘i vÃ o vÃ¹ng chÃ¢n khÃ´ng nÆ¡i ná»—i sá»£ cÃ³ hÃ¬nh dáº¡ng cá»¥ thá»ƒ. Äá»ƒ sá»‘ng sÃ³t, cáº£ Ä‘á»™i pháº£i Ä‘á»‘i máº·t vá»›i nhá»¯ng pháº§n kÃ½ á»©c mÃ  há» muá»‘n chÃ´n vÃ¹i nháº¥t.',
        'anh' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAnjPfEs2MPobkLFO3nrDCZ24_0ws6hwpusSltcYtPYHqgxfGHs-EwrF0lATV8Pum1N0SoQ1XJrpFdS_STT5PU7kA27FsCKxjNT6_WVNxlCUsl7kzciCy_21lcqO_ZFeb7tTCn7WZtKogyhDBkFBEmOuwDNjHwgeDlPdpesX2pX7BgJOuqqcnddwLd-L-vcllayn0TN-r3xKUn5hNdIv2_Ud5D3bKczICfq2yKhivKwjiA2k6CFi0gu77eDUm-V4W1Ol7K-VtvpNk-nB',
        'chuongMoi' => ['ChÆ°Æ¡ng 19: Nháº­t kÃ½ khoang tá»‘i', 'ChÆ°Æ¡ng 20: Káº» Ä‘á»©ng sau máº·t náº¡', 'ChÆ°Æ¡ng 21: TÃ­n hiá»‡u cuá»‘i cÃ¹ng'],
    ],
];

$id = (int) ($_GET['id'] ?? 1);
$truyen = $danhSachTruyen[$id] ?? reset($danhSachTruyen);

require_once __DIR__ . '/../include/user/userHeader.php';
?>

<link rel="stylesheet" href="../assets/css/public/mainStyle.css">

<div class="theme-<?= htmlspecialchars($themeHienTai) ?>">
<section class="story-detail-section">
    <div class="story-detail-container">
        <div class="story-detail-grid">
            <div class="story-cover-card">
                <img src="<?php echo e($truyen['anh']); ?>" alt="<?php echo e($truyen['ten']); ?>" class="story-cover-image">
            </div>

            <div class="story-detail-content">
                <div class="story-badges">
                    <span class="story-badge story-badge-orange"><?php echo e($truyen['theLoai']); ?></span>
                    <span class="story-badge story-badge-blue">ÄÃ¡nh giÃ¡ <?php echo e($truyen['danhGia']); ?></span>
                </div>

                <h1 class="headline story-detail-title"><?php echo e($truyen['ten']); ?></h1>
                <p class="story-detail-desc"><?php echo e($truyen['moTa']); ?></p>

                <div class="story-stats-grid">
                    <div class="story-stat-card">
                        <p class="story-stat-label">TÃ¡c giáº£</p>
                        <p class="story-stat-value"><?php echo e($truyen['tacGia']); ?></p>
                    </div>
                    <div class="story-stat-card">
                        <p class="story-stat-label">Sá»‘ chÆ°Æ¡ng</p>
                        <p class="story-stat-value"><?php echo e((string) $truyen['soChuong']); ?></p>
                    </div>
                    <div class="story-stat-card">
                        <p class="story-stat-label">GiÃ¡ truyá»‡n</p>
                        <p class="story-stat-value"><?php echo e($truyen['gia']); ?></p>
                    </div>
                </div>

                <div class="story-detail-actions">
                    <a href="./header/list.php?add=<?php echo (int) $truyen['id']; ?>" class="story-action-btn story-action-btn-gradient">
                        ThÃªm vÃ o tá»§ truyá»‡n
                    </a>
                    <a href="./header/library.php" class="story-action-btn story-action-btn-soft">
                        Quay vá» thÆ° viá»‡n
                    </a>
                    <a href="./header/storyMarket.php" class="story-action-btn story-action-btn-blue">
                        Xem giÃ¡ táº¡i chá»£ truyá»‡n
                    </a>
                </div>

                <div class="chapter-box">
                    <div class="chapter-box-header">
                        <h2 class="headline chapter-box-title">ChÆ°Æ¡ng má»›i cáº­p nháº­t</h2>
                        <a href="./header/list.php?add=<?php echo (int) $truyen['id']; ?>" class="chapter-save-link">LÆ°u Ä‘á»ƒ Ä‘á»c sau</a>
                    </div>

                    <div class="chapter-list">
                        <?php foreach ($truyen['chuongMoi'] as $index => $chuong): ?>
                            <div class="chapter-item">
                                <div>
                                    <p class="chapter-part">Pháº§n <?php echo (int) ($index + 1); ?></p>
                                    <p class="chapter-name"><?php echo e($chuong); ?></p>
                                </div>
                                <a href="./header/list.php?add=<?php echo (int) $truyen['id']; ?>" class="chapter-read-btn">
                                    Äá»c ngay
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="../assets/js/public/main.js"></script>
</div>

<?php require_once __DIR__ . '/../include/user/userFooter.php'; ?>