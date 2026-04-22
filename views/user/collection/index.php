<?php require_once __DIR__ . '/../partials/header.php'; ?>

<main class="max-w-6xl mx-auto my-6 px-4">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-500 mb-6 bg-white p-3 shadow-sm rounded-sm">
        <a href="index.php" class="hover:text-primary transition flex items-center">
            <i class="fas fa-home mr-2"></i> Trang chủ
        </a>
        <span class="mx-2 text-gray-300">/</span>
        <span class="font-bold text-gray-800 uppercase tracking-tighter italic">Bộ sưu tập</span>
        <span class="mx-2 text-gray-300">/</span>
        <span class="text-secondary font-bold"><?php echo htmlspecialchars($title); ?></span>
    </nav>

    <div class="flex flex-wrap -mx-3">
        <!-- Sidebar Filter (Reuse for layout) -->
        <aside class="w-full lg:w-1/4 px-3 mb-6 lg:mb-0">
            <div class="bg-white shadow-sm p-4 sticky top-4">
                <h3 class="font-bold text-primary border-b pb-2 mb-4 uppercase tracking-tighter">Thể loại khác</h3>
                <ul class="space-y-3">
                    <?php foreach($categories as $cat): ?>
                        <li>
                            <a href="index.php?controller=category&id=<?php echo $cat['id']; ?>" class="text-sm text-gray-600 hover:text-secondary flex items-center group transition">
                                <i class="fas fa-chevron-right text-[10px] mr-2 text-gray-300 group-hover:text-secondary opacity-0 group-hover:opacity-100 transition-all -ml-2 group-hover:ml-0"></i>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                
                <div class="mt-8 pt-8 border-t border-gray-100">
                    <h3 class="font-bold text-primary border-b pb-2 mb-4 uppercase tracking-tighter">Bộ sưu tập khác</h3>
                    <ul class="space-y-3">
                        <li><a href="index.php?controller=collection&type=sale" class="text-sm text-gray-600 hover:text-secondary flex items-center"><i class="fas fa-fire text-red-500 mr-2 text-xs"></i> Truyện Sale Hot</a></li>
                        <li><a href="index.php?controller=collection&type=bestseller" class="text-sm text-gray-600 hover:text-secondary flex items-center"><i class="fas fa-crown text-yellow-500 mr-2 text-xs"></i> Bán chạy nhất</a></li>
                        <li><a href="index.php?controller=collection&type=combo" class="text-sm text-gray-600 hover:text-secondary flex items-center"><i class="fas fa-layer-group text-blue-500 mr-2 text-xs"></i> Truyện Combo</a></li>
                        <li><a href="index.php?controller=collection&type=preorder" class="text-sm text-gray-600 hover:text-secondary flex items-center"><i class="fas fa-clock text-green-500 mr-2 text-xs"></i> Pre-order</a></li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Product List -->
        <div class="w-full lg:w-3/4 px-3">
            <div class="bg-white p-4 shadow-sm mb-6 border-l-4 border-secondary flex items-center justify-between">
                <h1 class="text-xl font-bold text-gray-800 uppercase tracking-tight"><?php echo htmlspecialchars($title); ?></h1>
                <span class="text-xs text-gray-400 font-medium">Hiện có <?php echo count($comics); ?> truyện</span>
            </div>

            <?php if (!empty($comics)): ?>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach($comics as $comic): ?>
                        <div class="comic-card group bg-white border border-gray-100 p-2 shadow-sm rounded-sm flex flex-col h-full hover:shadow-md transition-all duration-300">
                            <div class="relative h-56 w-full overflow-hidden bg-gray-50 mb-3">
                                <?php if($comic['is_sale']): ?>
                                    <span class="absolute top-2 right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-sm z-10 shadow-sm uppercase italic">SALE</span>
                                <?php elseif($comic['is_preorder']): ?>
                                    <span class="absolute top-2 right-2 bg-green-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-sm z-10 shadow-sm uppercase italic">PRE</span>
                                <?php endif; ?>

                                <img src="<?php echo !empty($comic['image_url']) ? $comic['image_url'] : 'https://dummyimage.com/200x250/2c5282/ffffff&text=No+Image'; ?>" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="Cover">
                                
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center p-4">
                                    <a href="index.php?controller=cart&action=add&id=<?php echo $comic['id']; ?>" class="bg-secondary text-white font-bold py-2 px-4 rounded-xl text-xs flex items-center hover:bg-orange-500 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                        <i class="fas fa-shopping-cart mr-2"></i> MUA NGAY
                                    </a>
                                </div>
                            </div>
                            
                            <div class="flex-grow flex flex-col justify-between p-1">
                                <div class="text-[10px] text-secondary uppercase tracking-tighter mb-1 font-bold truncate"><?php echo htmlspecialchars($comic['category_name'] ?? ''); ?></div>
                                <h3 class="text-sm font-semibold text-gray-800 line-clamp-2 hover:text-primary transition leading-snug h-10 mb-2 truncate-2-lines overflow-hidden" title="<?php echo htmlspecialchars($comic['name']); ?>">
                                    <?php echo htmlspecialchars($comic['name']); ?>
                                </h3>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-price font-bold text-base"><?php echo number_format($comic['price'], 0, ',', '.'); ?>đ</span>
                                    <span class="text-[10px] text-gray-400 font-medium">Kho: <?php echo $comic['quantity']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-gray-50 border border-dashed border-gray-200 rounded-lg p-20 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-folder-open text-gray-300 text-3xl"></i>
                    </div>
                    <p class="text-gray-400 font-medium italic">Hiện chưa có truyện nào trong danh sách này.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<style>
.truncate-2-lines {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
