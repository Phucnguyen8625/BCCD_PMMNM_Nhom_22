<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MangaStore - Cửa hàng Truyện Tranh Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4c2d73', // NetTruyen purple
                        secondary: '#f7941d', // Orange warning/accents
                        price: '#e53e3e',
                        navlink: '#333333',
                        bordercolor: '#ebebeb',
                        darkerbg: '#f9f9f9'
                    },
                    fontFamily: {
                        sans: ['Roboto', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #ededed; }
        .text-shadow { text-shadow: 1px 1px 2px rgba(0,0,0,0.8); }
        .image-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0) 100%);
        }
        .comic-card:hover { transform: translateY(-3px); box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .nav-item:hover { color: #f7941d; }
    </style>
</head>
<body class="font-sans text-gray-800">

    <!-- Top Header -->
    <header class="bg-primary pt-3 pb-3 px-4 relative" style="background-image: url('https://st.nettruyen.work/Data/Sites/1/media/bn-bg.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-6xl mx-auto flex flex-wrap items-center justify-between">
            <!-- Logo -->
            <div class="w-full md:w-1/4 mb-4 md:mb-0 text-center md:text-left flex items-center h-12">
                <a href="index.php" class="text-3xl font-bold text-white tracking-widest pl-2" style="font-family: 'Verdana', sans-serif; text-shadow: 2px 2px 0px #f7941d;">MangaStore</a>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-2/4 px-4 flex justify-center">
                <div class="relative w-full max-w-md">
                    <input type="text" class="w-full h-10 pl-4 pr-10 rounded-sm focus:outline-none focus:ring-1 focus:ring-primary text-sm" placeholder="Tìm kiếm tựa truyện, tác giả...">
                    <button class="absolute top-0 right-0 h-10 w-10 text-gray-500 hover:text-primary transition">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <!-- Right utilities -->
            <div class="w-full md:w-1/4 flex items-center justify-center md:justify-end text-yellow-300 text-sm mt-4 md:mt-0 space-x-6">
                <!-- Shopping Cart -->
                <a href="index.php?controller=cart" class="relative hover:text-white transition group flex items-center space-x-1">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                        <?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : '0'; ?>
                    </span>
                    <span class="ml-2 hidden lg:inline">Giỏ hàng</span>
                </a>
                <!-- User Account -->
                <div class="relative group cursor-pointer text-white flex items-center space-x-1 hover:text-gray-300">
                    <i class="fas fa-user mb-1"></i>
                    <span>Tài khoản</span>
                    <i class="fas fa-caret-down text-xs mb-1"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-6xl mx-auto">
            <ul class="flex flex-wrap items-center text-sm font-medium">
                <li><a href="/" class="block py-3 px-4 text-navlink hover:text-primary border-r border-bordercolor"><i class="fas fa-home"></i></a></li>
                <li><a href="#" class="block py-3 px-4 text-navlink hover:text-secondary border-r border-bordercolor">TRUYỆN SALE HOT</a></li>
                <li class="relative group">
                    <a href="#" class="block py-3 px-4 text-navlink hover:text-secondary border-r border-bordercolor flex items-center space-x-1">
                        <span>DANH MỤC TRUYỆN</span> <i class="fas fa-caret-down text-xs"></i>
                    </a>
                </li>
                <li><a href="#" class="block py-3 px-4 text-navlink hover:text-secondary border-r border-bordercolor">ĐƠN HÀNG CỦA TÔI</a></li>
                <li class="relative group">
                    <a href="#" class="block py-3 px-4 text-navlink hover:text-secondary border-r border-bordercolor flex items-center space-x-1">
                        <span>BÁN CHẠY NHẤT</span> <i class="fas fa-caret-down text-xs"></i>
                    </a>
                </li>
                <li><a href="#" class="block py-3 px-4 text-navlink hover:text-secondary border-r border-bordercolor">TÌM SÁCH</a></li>
                <li><a href="#" class="block py-3 px-4 text-navlink hover:text-secondary border-r border-bordercolor">TRUYỆN COMBO</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="max-w-6xl mx-auto my-4 bg-white p-4 shadow-sm">
        
        <!-- Warning Alert / Notification -->
        <div class="bg-green-100 border border-green-200 text-green-700 text-sm px-4 py-2 mb-6 flex items-center rounded-sm">
            <i class="fas fa-gift mr-2 text-green-600"></i>
            Đang có chương trình miễn phí giao hàng cho hóa đơn trên <strong class="mx-1">200.000đ</strong>. Nhanh tay săn sale ngay hôm nay!
        </div>

        <!-- Sản Xuất Khuyến Mãi (Featured Comics Slider/Grid) -->
        <section class="mb-8">
            <div class="flex items-center text-blue-500 font-bold text-xl mb-3">
                <h2 class="uppercase hover:text-blue-700 cursor-pointer">Sản Phẩm Khuyến Mãi <i class="fas fa-fire text-red-500 ml-1"></i></h2>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                <?php foreach($featuredComics as $comic): ?>
                <div class="relative w-full bg-gray-100 cursor-pointer group rounded-sm comic-card transition-all duration-300 border border-gray-200 overflow-hidden flex flex-col h-full">
                    <?php if($comic['discount']): ?>
                        <div class="absolute top-0 right-0 bg-red-600 text-white font-bold text-xs px-2 py-1 z-10 rounded-bl-lg">
                            <?php echo $comic['discount']; ?>
                        </div>
                    <?php endif; ?>
                    <div class="h-48 md:h-56 relative w-full">
                        <img src="<?php echo $comic['image']; ?>" alt="Cover" class="w-full h-full object-cover">
                        <!-- Add to cart overlay popup -->
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <a href="index.php?controller=cart&action=add&id=<?php echo isset($comic['id']) ? $comic['id'] : 1; ?>" class="bg-secondary text-white font-bold py-2 px-4 rounded-xl flex items-center transform scale-90 group-hover:scale-100 transition">
                                <i class="fas fa-cart-plus mr-2"></i> Mua ngay
                            </a>
                        </div>
                    </div>
                    <div class="p-2 flex-grow flex flex-col justify-between">
                        <div class="text-gray-800 text-sm font-semibold truncate hover:text-blue-600" title="<?php echo htmlspecialchars($comic['title']); ?>"><?php echo htmlspecialchars($comic['title']); ?></div>
                        <div class="mt-2 flex items-baseline space-x-2">
                            <span class="text-price font-bold text-lg"><?php echo $comic['price']; ?>đ</span>
                            <?php if($comic['old_price']): ?>
                                <span class="text-xs text-gray-500 line-through"><?php echo $comic['old_price']; ?>đ</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Main Body (Updates & Sidebar) -->
        <div class="flex flex-wrap -mx-2">
            <!-- Left Column: Sản Phẩm Mới Xuất Bản -->
            <div class="w-full lg:w-2/3 px-2">
                <div class="flex items-center justify-between text-blue-500 font-bold text-xl mb-3 border-b-2 border-blue-500 pb-1">
                    <h2 class="uppercase">Sách mới về <i class="fas fa-angle-right text-lg"></i></h2>
                    <i class="fas fa-filter text-secondary text-sm border border-secondary p-1 rounded-full cursor-pointer hover:bg-secondary hover:text-white transition"></i>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <?php foreach($newComics as $comic): ?>
                    <div class="comic-card group">
                        <div class="relative w-full h-56 bg-white overflow-hidden rounded-sm cursor-pointer border border-gray-200 shadow-sm relative">
                            <?php if($comic['stock'] == 'Sắp hết' || $comic['stock'] == 'Hết hàng'): ?>
                                <span class="absolute top-1 right-1 bg-gray-600 text-white text-[10px] px-1.5 py-0.5 font-bold rounded shadow-sm z-10"><?php echo $comic['stock']; ?></span>
                            <?php else: ?>
                                <span class="absolute top-1 right-1 bg-green-600 text-white text-[10px] px-1.5 py-0.5 font-bold rounded shadow-sm z-10">Mới</span>
                            <?php endif; ?>

                            <img src="<?php echo $comic['image']; ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="Cover">
                            
                            <div class="absolute bottom-0 left-0 w-full image-overlay px-2 pb-2 pt-6 flex justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <a href="index.php?controller=cart&action=add&id=<?php echo isset($comic['id']) ? $comic['id'] : 1; ?>" class="w-full text-center bg-white text-gray-900 border border-gray-300 font-semibold py-1 rounded text-sm hover:bg-gray-100 hover:text-primary transition block">
                                    Thêm vào giỏ
                                </a>
                            </div>
                        </div>
                        <div class="mt-2 pl-1 h-16 flex flex-col justify-between">
                            <h3 class="text-sm font-medium text-gray-800 line-clamp-2 hover:text-blue-500 cursor-pointer leading-tight" title="<?php echo htmlspecialchars($comic['title']); ?>">
                                <?php echo htmlspecialchars($comic['title']); ?>
                            </h3>
                            <div class="font-bold text-price mt-1">
                                <?php echo $comic['price']; ?>đ
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination Placeholder -->
                <div class="flex justify-center mt-6">
                    <button class="bg-white border border-gray-300 text-gray-600 hover:text-primary hover:border-primary px-4 py-2 font-medium rounded-sm text-sm transition">XEM THÊM SẢN PHẨM</button>
                </div>
            </div>

            <!-- Right Column: Sidebar Top Bán Chạy -->
            <div class="w-full lg:w-1/3 px-2 mt-6 lg:mt-0">
                <!-- Tabs -->
                <div class="flex border-b border-gray-200 text-sm font-medium mb-4">
                    <button class="w-1/3 py-2 text-primary border-b-2 border-primary focus:outline-none font-bold">Top Bán Chạy</button>
                    <button class="w-1/3 py-2 text-gray-500 focus:outline-none hover:text-gray-700">Giá rẻ</button>
                    <button class="w-1/3 py-2 text-gray-500 focus:outline-none hover:text-gray-700">Pre-order</button>
                </div>

                <!-- Top List -->
                <div class="space-y-4">
                    <?php foreach($topComics as $index => $comic): ?>
                    <div class="flex items-center justify-between border-b border-dashed border-gray-200 pb-2">
                        <div class="flex items-center space-x-3 w-[70%]">
                            <span class="text-2xl font-bold <?php echo ($index < 3) ? 'text-secondary' : 'text-gray-400'; ?> w-8 text-center">
                                <?php echo $comic['rank']; ?>
                            </span>
                            <div class="w-12 h-16 bg-gray-200 flex-shrink-0 border border-gray-100">
                                <img src="<?php echo $comic['image']; ?>" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h4 class="text-sm font-semibold text-gray-800 truncate hover:text-blue-500 cursor-pointer" title="<?php echo htmlspecialchars($comic['title']); ?>">
                                    <?php echo htmlspecialchars($comic['title']); ?>
                                </h4>
                                <div class="text-xs font-bold text-price mt-1">
                                    <p><?php echo $comic['price']; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-green-600 font-medium text-right bg-green-50 px-2 py-1 rounded">
                            Đã bán: <?php echo $comic['sold']; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-6 text-sm border-t-4 border-primary">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between px-4">
            <div class="mb-4 md:mb-0">
                <a href="#" class="text-2xl font-bold text-white tracking-widest" style="font-family: 'Verdana';">MangaStore</a>
                <p class="mt-2 w-full md:w-80 leading-relaxed text-xs">
                    Cửa hàng truyện tranh trực tuyến số 1 hiện nay. Giao hàng toàn quốc, thanh toán an toàn.
                </p>
                <div class="mt-2 text-xl space-x-2 text-white">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-cc-paypal"></i>
                </div>
            </div>
            <div class="flex flex-col space-y-2">
                <h4 class="text-white font-semibold">Chăm sóc khách hàng</h4>
                <a href="#" class="hover:text-primary transition">Giới thiệu</a>
                <a href="#" class="hover:text-primary transition">Chính sách vận chuyển</a>
                <a href="#" class="hover:text-primary transition">Đổi trả & Hoàn tiền</a>
            </div>
        </div>
    </footer>

</body>
</html>
