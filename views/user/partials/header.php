<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' – MangaStore' : 'MangaStore'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        // Dark mode check before render
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#4c2d73',
                        secondary: '#f7941d',
                        price: '#e53e3e',
                        navlink: '#333333',
                        bordercolor: '#ebebeb',
                    },
                    fontFamily: { sans: ['Roboto', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { background-color: #ededed; transition: background-color 0.3s, color 0.3s; }
        .dark body { background-color: #1a202c; color: #cbd5e0; }
        .dark nav { background-color: #2d3748 !important; border-color: #4a5568 !important; }
        .dark .bg-white, .dark .bg-gray-50 { background-color: #2d3748 !important; color: #cbd5e0 !important; border-color: #4a5568 !important; }
        .dark .text-navlink { color: #cbd5e0 !important; }
        .dark .text-primary { color: #d6bcfa !important; }
        .dark .text-blue-500 { color: #60a5fa !important; }
        .dark .text-gray-900, .dark .text-gray-800, .dark .text-gray-700, .dark .text-gray-600 { color: #e2e8f0 !important; }
        .dark .text-gray-500 { color: #a0aec0 !important; }
        .dark .border-gray-50, .dark .border-gray-100, .dark .border-gray-200 { border-color: #4a5568 !important; }
        .dark .hover\:bg-purple-50:hover, .dark .hover\:bg-gray-50:hover { background-color: #4a5568 !important; color: #ffffff !important; }
        .dark .comic-card { background-color: #2d3748 !important; border-color: #4a5568 !important; box-shadow: 0 4px 6px rgba(0,0,0,0.3); }
        .comic-card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
        .dark .comic-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.5); }
    </style>
</head>
<body class="font-sans text-gray-800 transition-colors duration-300">

<!-- Top Header -->
<header class="bg-primary pt-3 pb-3 px-4 relative" style="background-image:url('https://st.nettruyen.work/Data/Sites/1/media/bn-bg.jpg');background-size:cover;background-position:center;">
    <div class="max-w-6xl mx-auto flex flex-wrap items-center justify-between">
        <!-- Logo -->
        <div class="w-full md:w-auto mb-2 md:mb-0 flex items-center h-12">
            <a href="index.php" class="text-3xl font-bold text-white tracking-widest" style="font-family:'Verdana',sans-serif;text-shadow:2px 2px 0px #f7941d;">MangaStore</a>
        </div>

        <!-- Search Bar -->
        <div class="w-full md:flex-1 md:px-8 flex justify-center relative">
            <form action="index.php" method="GET" class="relative w-full max-w-lg flex z-50">
                <input type="hidden" name="controller" value="search">
                <input type="text" name="q" id="searchInput" autocomplete="off" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>"
                       class="w-full h-10 pl-4 pr-10 rounded-l-sm focus:outline-none text-sm border-0"
                       placeholder="Tìm kiếm tựa truyện, tác giả...">
                <button type="submit" class="h-10 px-3 bg-secondary text-white rounded-r-sm hover:bg-orange-500 transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- Khung Dropdown Live Search -->
            <div id="searchDropdown" class="absolute left-0 right-0 mx-4 md:mx-8 top-full mt-1 max-w-lg bg-white rounded-sm shadow-xl border border-gray-200 hidden max-h-80 overflow-y-auto z-[60]">
                <ul id="searchResults" class="divide-y divide-gray-100">
                    <!-- Dữ liệu render bằng JS -->
                </ul>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const searchDropdown = document.getElementById('searchDropdown');
                const searchResults = document.getElementById('searchResults');
                let timeoutId;

                searchInput.addEventListener('input', function() {
                    clearTimeout(timeoutId);
                    const query = this.value.trim();

                    if (query.length < 2) {
                        searchDropdown.classList.add('hidden');
                        return;
                    }

                    // Debounce 300ms
                    timeoutId = setTimeout(() => {
                        fetch('index.php?controller=search&action=ajax&q=' + encodeURIComponent(query))
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success' && data.data.length > 0) {
                                    searchResults.innerHTML = '';
                                    data.data.forEach(comic => {
                                        const li = document.createElement('li');
                                        li.innerHTML = `
                                            <a href="index.php?controller=comic&action=show&id=${comic.id}" class="flex items-center p-2 hover:bg-gray-50 transition">
                                                <img src="${comic.image}" class="w-10 h-14 object-cover rounded-sm border border-gray-200 flex-shrink-0" alt="Cover">
                                                <div class="ml-3 overflow-hidden">
                                                    <h4 class="text-sm font-semibold text-gray-800 truncate">${comic.title}</h4>
                                                    <p class="text-xs text-price font-bold mt-1">${comic.price}</p>
                                                </div>
                                            </a>
                                        `;
                                        searchResults.appendChild(li);
                                    });
                                    searchDropdown.classList.remove('hidden');
                                } else {
                                    searchResults.innerHTML = '<li class="p-4 text-center text-sm text-gray-500">Không tìm thấy truyện nào.</li>';
                                    searchDropdown.classList.remove('hidden');
                                }
                            })
                            .catch(err => console.error(err));
                    }, 300);
                });

                // Click outside to close
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                        searchDropdown.classList.add('hidden');
                    }
                });
                
                // Show dropdown again when focus if it has value
                searchInput.addEventListener('focus', function() {
                    if (this.value.trim().length >= 2 && searchResults.innerHTML !== '') {
                        searchDropdown.classList.remove('hidden');
                    }
                });
            });
        </script>

        <!-- Right: Cart + User -->
        <div class="w-full md:w-auto flex flex-nowrap items-center justify-center md:justify-end text-yellow-300 text-sm mt-2 md:mt-0 space-x-3 md:space-x-4">
            <a href="index.php?controller=cart" class="relative hover:text-white transition flex items-center space-x-1 whitespace-nowrap">
                <i class="fas fa-shopping-cart text-lg"></i>
                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                    <?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : '0'; ?>
                </span>
                <span class="ml-2 hidden lg:inline">Giỏ hàng</span>
            </a>

            <!-- Dark Mode Toggle Button -->
            <button id="themeToggle" class="text-white hover:text-yellow-300 transition focus:outline-none" title="Chuyển chế độ sáng/tối">
                <i class="fas fa-moon text-lg" id="themeIcon"></i>
            </button>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <a href="admin.php" class="bg-purple-600 border border-purple-500 text-white font-semibold px-2 py-1.5 rounded-md hover:bg-purple-700 hover:border-purple-600 transition shadow-sm text-xs hidden md:inline-flex items-center space-x-1 whitespace-nowrap">
                        <i class="fas fa-cogs"></i>
                        <span class="hidden lg:inline">Quản lý</span>
                    </a>
                <?php endif; ?>
                <div class="relative group cursor-pointer whitespace-nowrap">
                    <div class="flex items-center space-x-1 text-white hover:text-yellow-300 transition">
                        <i class="fas fa-user-circle text-lg"></i>
                        <span class="hidden lg:inline font-medium"><?php echo htmlspecialchars($_SESSION['user_login']['full_name'] ?? 'Tài khoản'); ?></span>
                        <i class="fas fa-caret-down text-xs"></i>
                    </div>
                    <div class="absolute right-0 top-full mt-2 w-52 bg-white rounded-lg shadow-xl border border-gray-100 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-xs text-gray-500">Đăng nhập với</p>
                            <p class="text-sm font-semibold text-gray-800 truncate"><?php echo htmlspecialchars($_SESSION['user_login']['email'] ?? ''); ?></p>
                        </div>
                        <a href="index.php?controller=profile" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition">
                            <i class="fas fa-user-cog w-4 mr-2 text-gray-400"></i> Hồ sơ cá nhân
                        </a>
                        <a href="index.php?controller=userorder" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition">
                            <i class="fas fa-shopping-bag w-4 mr-2 text-gray-400"></i> Đơn hàng của tôi
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <a href="index.php?controller=auth&action=logout" class="flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                            <i class="fas fa-sign-out-alt w-4 mr-2"></i> Đăng xuất
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="flex items-center space-x-2 md:space-x-3 whitespace-nowrap">
                    <a href="index.php?controller=auth&action=login" class="text-white hover:text-yellow-300 transition flex items-center space-x-1">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="hidden lg:inline">Đăng nhập</span>
                    </a>
                    <a href="index.php?controller=auth&action=register" class="bg-secondary text-white font-semibold px-2 py-1.5 rounded-lg hover:bg-orange-500 transition text-xs">
                        Đăng ký
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Main Navigation -->
<nav class="bg-white shadow">
    <div class="max-w-6xl mx-auto">
        <ul class="flex flex-wrap items-center text-sm font-medium">
            <li><a href="index.php" class="block py-3 px-4 text-navlink hover:text-primary border-r border-bordercolor"><i class="fas fa-home"></i></a></li>
            <li><a href="index.php?controller=collection&type=sale" class="block py-3 px-4 text-navlink hover:text-secondary border-r border-bordercolor font-bold text-red-600">TRUYỆN SALE HOT</a></li>

            <!-- Danh mục truyện dropdown (từ DB) -->
            <li class="relative group">
                <a href="index.php?controller=category" class="block py-3 px-4 text-navlink hover:text-secondary border-r border-bordercolor flex items-center space-x-1">
                    <span>DANH MỤC TRUYỆN</span> <i class="fas fa-caret-down text-xs"></i>
                </a>
                <div class="absolute left-0 top-full bg-white shadow-xl border border-gray-100 rounded-b-lg z-50 min-w-[200px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <a href="index.php?controller=category&id=<?php echo $cat['id']; ?>"
                               class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-primary border-b border-gray-50 transition">
                                <i class="fas fa-book-open text-xs text-secondary mr-2"></i>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="px-4 py-3 text-sm text-gray-400 italic">Chưa có danh mục</p>
                    <?php endif; ?>
                </div>
            </li>

            <li><a href="index.php?controller=userorder" class="block py-3 px-4 text-navlink hover:text-secondary border-r border-bordercolor">ĐƠN HÀNG CỦA TÔI</a></li>
            <li><a href="index.php?controller=collection&type=bestseller" class="block py-3 px-4 text-navlink hover:text-secondary border-r border-bordercolor">BÁN CHẠY NHẤT</a></li>
            <li><a href="index.php?controller=search" class="block py-3 px-4 text-navlink hover:text-secondary border-r border-bordercolor">TÌM SÁCH</a></li>
            <li><a href="index.php?controller=collection&type=combo" class="block py-3 px-4 text-navlink hover:text-secondary border-r border-bordercolor">TRUYỆN COMBO</a></li>
            <li><a href="index.php?controller=collection&type=all" class="block py-3 px-4 text-navlink hover:text-secondary font-bold text-primary">TẤT CẢ SẢN PHẨM</a></li>
        </ul>
    </div>
</nav>

<script>
    // Dark mode toggle logic
    const themeToggleBtn = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    
    function updateIcon() {
        if (document.documentElement.classList.contains('dark')) {
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        } else {
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }
    }
    
    updateIcon(); // Initial icon update
    
    themeToggleBtn.addEventListener('click', function() {
        document.documentElement.classList.toggle('dark');
        
        if (document.documentElement.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
        
        updateIcon();
    });
</script>
