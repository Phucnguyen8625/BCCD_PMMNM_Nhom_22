<?php $pageTitle = 'Cửa hàng Truyện Tranh Online'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php // ==== HOME PAGE CONTENT BELOW ==== ?>


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
                        <div class="text-[10px] text-gray-500 uppercase tracking-tighter mb-1 font-bold truncate"><?php echo htmlspecialchars($comic['category'] ?? ''); ?></div>
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
                            <div class="text-[10px] text-gray-500 uppercase tracking-tighter mb-1 font-bold truncate"><?php echo htmlspecialchars($comic['category'] ?? ''); ?></div>
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
                    <a href="index.php?controller=collection&type=all" class="bg-white border border-gray-300 text-gray-600 hover:text-primary hover:border-primary px-8 py-2.5 font-bold rounded-xl text-sm transition shadow-sm uppercase italic">XEM THÊM SẢN PHẨM</a>
                </div>
            </div>

            <!-- Right Column: Sidebar Top Bán Chạy -->
            <div class="w-full lg:w-1/3 px-2 mt-6 lg:mt-0">
                <!-- Tabs -->
                <div class="flex border-b border-gray-200 text-sm font-medium mb-4">
                    <button onclick="switchTab('bestseller', this)" class="tab-btn w-1/3 py-2 text-primary border-b-2 border-primary focus:outline-none font-bold">Top Bán Chạy</button>
                    <button onclick="switchTab('cheap', this)" class="tab-btn w-1/3 py-2 text-gray-500 focus:outline-none hover:text-gray-700">Giá rẻ</button>
                    <button onclick="switchTab('preorder', this)" class="tab-btn w-1/3 py-2 text-gray-500 focus:outline-none hover:text-gray-700">Pre-order</button>
                </div>

                <!-- Top List -->
                <div class="space-y-4">
                    <div id="tab-bestseller" class="tab-content">
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
                                        <a href="index.php?controller=comic&action=show&id=<?php echo $comic['id']; ?>"><?php echo htmlspecialchars($comic['title']); ?></a>
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
                        <a href="index.php?controller=collection&type=bestseller" class="block text-center text-xs text-blue-500 mt-4 hover:underline">Xem tất cả bán chạy</a>
                    </div>

                    <div id="tab-cheap" class="tab-content hidden">
                        <?php foreach($cheapComics as $comic): ?>
                        <div class="flex items-center space-x-3 border-b border-dashed border-gray-200 pb-2">
                            <div class="w-12 h-16 bg-gray-200 flex-shrink-0 border border-gray-100">
                                <img src="<?php echo $comic['image']; ?>" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h4 class="text-sm font-semibold text-gray-800 truncate hover:text-blue-500 cursor-pointer">
                                    <a href="index.php?controller=comic&action=show&id=<?php echo $comic['id']; ?>"><?php echo htmlspecialchars($comic['title']); ?></a>
                                </h4>
                                <div class="text-xs font-bold text-price mt-1">
                                    <p><?php echo $comic['price']; ?></p>
                                </div>
                            </div>
                            <a href="index.php?controller=cart&action=add&id=<?php echo $comic['id']; ?>" class="text-[10px] bg-secondary text-white px-2 py-1 rounded font-bold uppercase transition hover:bg-orange-600">Mua ngay</a>
                        </div>
                        <?php endforeach; ?>
                        <a href="index.php?controller=collection&type=all" class="block text-center text-xs text-blue-500 mt-4 hover:underline">Xem tất cả sản phẩm</a>
                    </div>

                    <div id="tab-preorder" class="tab-content hidden">
                        <?php foreach($preComics as $comic): ?>
                        <div class="flex items-center space-x-3 border-b border-dashed border-gray-200 pb-2">
                            <div class="w-12 h-16 bg-gray-200 flex-shrink-0 border border-gray-100">
                                <img src="<?php echo $comic['image']; ?>" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h4 class="text-sm font-semibold text-gray-800 truncate hover:text-blue-500 cursor-pointer"><?php echo htmlspecialchars($comic['title']); ?></h4>
                                <div class="text-xs font-bold text-price mt-1">
                                    <p><?php echo $comic['price']; ?></p>
                                </div>
                            </div>
                            <a href="index.php?controller=cart&action=add&id=<?php echo $comic['id']; ?>" class="text-[10px] bg-green-600 text-white px-2 py-1 rounded font-bold uppercase">Đặt trước</a>
                        </div>
                        <?php endforeach; ?>
                        <a href="index.php?controller=collection&type=preorder" class="block text-center text-xs text-blue-500 mt-4 hover:underline">Xem danh sách đặt trước</a>
                    </div>
                </div>

                <script>
                    function switchTab(tabId, el) {
                        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
                        document.getElementById('tab-' + tabId).classList.remove('hidden');
                        
                        document.querySelectorAll('.tab-btn').forEach(b => {
                            b.classList.remove('text-primary', 'border-primary', 'border-b-2', 'font-bold');
                            b.classList.add('text-gray-500');
                        });
                        
                        el.classList.add('text-primary', 'border-primary', 'border-b-2', 'font-bold');
                        el.classList.remove('text-gray-500');
                    }
                </script>
            </div>
        </div>
    </main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
