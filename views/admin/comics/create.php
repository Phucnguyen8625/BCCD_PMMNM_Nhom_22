<?php $pageTitle = 'Đăng truyện mới'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

<!-- Content Header -->
<div class="mb-8">
    <a href="admin.php?controller=comic&action=index" class="text-sm font-bold text-slate-400 hover:text-accent transition flex items-center mb-4">
        <i class="fas fa-arrow-left mr-2 text-xs"></i> DANH SÁCH TRUYỆN
    </a>
    <h1 class="text-2xl font-bold text-slate-800">Đăng truyện mới</h1>
</div>

<div class="max-w-4xl">
    <form action="admin.php?controller=comic&action=store" method="POST" enctype="multipart/form-data" class="space-y-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center">
                <div class="w-8 h-8 bg-accent/10 text-accent rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Thông tin cơ bản</h3>
            </div>
            
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Tên Truyện / Tập Truyện <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition" placeholder="Ví dụ: One Piece Tập 100">
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Thể loại <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <?php foreach($categories as $cat): ?>
                            <label class="flex items-center space-x-2 p-2 rounded-lg hover:bg-white cursor-pointer transition border border-transparent hover:border-slate-100">
                                <input type="checkbox" name="category_ids[]" value="<?php echo $cat['id']; ?>" class="w-4 h-4 text-accent border-slate-300 rounded focus:ring-accent">
                                <span class="text-xs font-bold text-slate-600 uppercase tracking-tighter"><?php echo htmlspecialchars($cat['name']); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Tác giả / NXB</label>
                    <input type="text" name="author" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition" placeholder="Tên tác giả...">
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Giá bán (VNĐ) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="price" min="0" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition pl-12" value="0">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">₫</span>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Số lượng kho <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" min="0" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition" value="1">
                </div>

                <div class="md:col-span-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Mô tả tóm tắt</label>
                    <textarea name="description" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition" placeholder="Nội dung tóm tắt cốt truyện..."></textarea>
                </div>

                <div class="md:col-span-2 grid grid-cols-2 md:grid-cols-4 gap-4 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_sale" value="1" class="w-4 h-4 text-accent border-slate-300 rounded focus:ring-accent">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-tighter">TRUYỆN SALE</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_bestseller" value="1" class="w-4 h-4 text-accent border-slate-300 rounded focus:ring-accent">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-tighter">BÁN CHẠY</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_combo" value="1" class="w-4 h-4 text-accent border-slate-300 rounded focus:ring-accent">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-tighter">TRUYỆN COMBO</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_preorder" value="1" class="w-4 h-4 text-accent border-slate-300 rounded focus:ring-accent">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-tighter">PRE-ORDER</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center">
                <div class="w-8 h-8 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-image"></i>
                </div>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Hình ảnh hiển thị</h3>
            </div>
            
            <div class="p-8 space-y-6">
                <div class="flex items-center justify-center border-2 border-dashed border-slate-200 rounded-2xl p-12 bg-slate-50/50 hover:bg-slate-50 transition cursor-pointer group relative">
                    <div class="text-center">
                        <i class="fas fa-cloud-upload-alt text-4xl text-slate-200 group-hover:text-accent transition duration-300 mb-4"></i>
                        <p class="text-sm font-bold text-slate-400">Tải ảnh bìa truyện lên</p>
                        <p class="text-[10px] text-slate-300 mt-1 uppercase tracking-widest">Hỗ trợ JPG, PNG (Tối đa 5MB)</p>
                        <input type="file" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex items-center justify-center pointer-events-none">
                        <span class="bg-white px-4 text-[10px] font-black text-slate-300 uppercase tracking-widest">Hoặc dùng link ảnh</span>
                    </div>
                    <div class="border-t border-slate-100"></div>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Dán link ảnh</label>
                    <input type="text" name="image_url_link" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition" placeholder="https://example.com/image.jpg">
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="admin.php?controller=comic" class="px-8 py-3 rounded-xl text-sm font-bold text-slate-400 hover:text-slate-600 transition">HỦY BỎ</a>
            <button type="submit" class="bg-accent hover:bg-indigo-600 text-white font-bold py-3 px-12 rounded-xl transition shadow-xl shadow-indigo-200">
                ĐĂNG TRUYỆN
            </button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
