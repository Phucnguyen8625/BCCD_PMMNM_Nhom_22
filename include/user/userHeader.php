<?php
require_once __DIR__ . '/../../config/webConfig.php';

if (!isset($pageTitle) || $pageTitle === '') {
    $pageTitle = $tenWebsite;
}

if (!isset($currentPage)) {
    $currentPage = 'home';
}

function menuActiveClass($page, $currentPage)
{
    return $page === $currentPage
        ? 'text-orange-700 border-b-2 border-orange-700 pb-1'
        : 'hover:text-orange-700';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle); ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700;800&family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <style>
        body { font-family: 'Manrope', sans-serif; }
        .headline { font-family: 'Space Grotesk', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #a73300, #ff794a); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 12px 25px rgba(0,0,0,0.12); }

        .account-dropdown {
            position: relative;
            display: inline-flex;
            align-items: center;
            z-index: 60;
        }

        .account-toggle {
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 999px;
            transition: background 0.2s ease;
        }

        .account-toggle:hover {
            background: rgba(0, 0, 0, 0.06);
        }

        .account-toggle .material-symbols-outlined {
            font-size: 26px;
            color: #d45a1f;
        }

        .account-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 220px;
            background: #ffffff;
            border: 1px solid #eadfd7;
            border-radius: 14px;
            box-shadow: 0 14px 32px rgba(0, 0, 0, 0.12);
            padding: 8px;
            display: none;
            z-index: 9999;
        }

        .account-menu.show {
            display: block;
        }

        .account-dropdown:focus-within .account-menu {
            display: block;
        }

        .account-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            color: #1f2937;
            font-size: 15px;
            text-decoration: none;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .account-menu a:hover {
            background: #f8f1ec;
            color: #d45a1f;
        }

        .account-menu a .material-symbols-outlined {
            font-size: 20px;
        }

        .account-menu__logout {
            margin-top: 6px;
            border-top: 1px solid #f0e6df;
            padding-top: 12px !important;
            color: #c2410c !important;
        }
    </style>
</head>
<body class="bg-[#fff4f3] text-[#4e211e] pt-[88px]">

<nav class="fixed top-0 left-0 w-full bg-white/80 backdrop-blur-md shadow-sm z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="<?php echo PUBLIC_URL; ?>/header/index.php" class="text-2xl font-extrabold text-orange-700 headline">
            <?php echo e($tenWebsite); ?>
        </a>

        <div class="hidden md:flex items-center gap-8 font-semibold">
            <a href="<?php echo PUBLIC_URL; ?>/header/index.php" class="<?php echo menuActiveClass('home', $currentPage); ?>">Khám phá</a>
            <a href="<?php echo PUBLIC_URL; ?>/header/library.php" class="<?php echo menuActiveClass('library', $currentPage); ?>">Thư viện</a>
            <a href="<?php echo PUBLIC_URL; ?>/header/storyMarket.php" class="<?php echo menuActiveClass('market', $currentPage); ?>">Chợ truyện</a>
        </div>

        <div class="flex items-center gap-4">
            <a href="<?php echo PUBLIC_URL; ?>/header/list.php" class="hover:text-orange-700" title="Danh sách">
                <span class="material-symbols-outlined">list</span>
            </a>

            <div class="account-dropdown">
                <button type="button" class="account-toggle" id="accountToggle" aria-expanded="false" aria-haspopup="true">
                    <span class="material-symbols-outlined">account_circle</span>
                </button>

                <div class="account-menu" id="accountMenu">
                    <a href="<?php echo PUBLIC_URL; ?>/settings/user.php">
                        <span class="material-symbols-outlined">person</span>
                        <span>Tài khoản</span>
                    </a>

                    <a href="<?php echo PUBLIC_URL; ?>/settings/preferences.php">
                        <span class="material-symbols-outlined">tune</span>
                        <span>Tùy chọn</span>
                    </a>

                    <a href="<?php echo PUBLIC_URL; ?>/settings/privacy.php">
                        <span class="material-symbols-outlined">shield</span>
                        <span>Riêng tư</span>
                    </a>

                    <a href="<?php echo BASE_URL; ?>/public/sign/logout.php" class="account-menu__logout">
                        <span class="material-symbols-outlined">logout</span>
                        <span>Đăng xuất</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const accountToggle = document.getElementById('accountToggle');
    const accountMenu = document.getElementById('accountMenu');

    if (accountToggle && accountMenu) {
        accountToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            accountMenu.classList.toggle('show');
            accountToggle.setAttribute(
                'aria-expanded',
                accountMenu.classList.contains('show') ? 'true' : 'false'
            );
        });

        document.addEventListener('click', function (e) {
            if (!accountMenu.contains(e.target) && !accountToggle.contains(e.target)) {
                accountMenu.classList.remove('show');
                accountToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
});
</script>
