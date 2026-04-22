<?php $pageTitle = 'Sửa thông tin truyện'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

<!-- Content Header -->
<div class="mb-8">
    <a href="admin.php?controller=comic&action=index" class="text-sm font-bold text-slate-400 hover:text-accent transition flex items-center mb-4">
        <i class="fas fa-arrow-left mr-2 text-xs"></i> DANH SÁCH TRUYỆN
    </a>
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Sửa thông tin truyện</h1>
        <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold border border-slate-200 uppercase tracking-tighter italic">ID: #<?php echo htmlspecialchars($this->comic->id); ?></span>
    </div>
</div>

<div class="max-w-4xl">
    <form action="admin.php?controller=comic&action=update" method="POST" enctype="multipart/form-data" class="space-y-8">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($this->comic->id); ?>">
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center">
                <div class="w-8 h-8 bg-accent/10 text-accent rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-edit"></i>
                </div>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Cập nhật thông tin</h3>
            </div>
            
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Tên Truyện / Tập Truyện <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required value="<?php echo htmlspecialchars($this->comic->name); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition" placeholder="Ví dụ: One Piece Tập 100">
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Thể loại <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <?php foreach($categories as $cat): ?>
                            <label class="flex items-center space-x-2 p-2 rounded-lg hover:bg-white cursor-pointer transition border border-transparent hover:border-slate-100">
                                <input type="checkbox" name="category_ids[]" value="<?php echo $cat['id']; ?>" 
                                    <?php echo (in_array($cat['id'], $this->comic->category_ids)) ? 'checked' : ''; ?>
                                    class="w-4 h-4 text-accent border-slate-300 rounded focus:ring-accent">
                                <span class="text-xs font-bold text-slate-600 uppercase tracking-tighter"><?php echo htmlspecialchars($cat['name']); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Tác giả / NXB</label>
                    <input type="text" name="author" value="<?php echo htmlspecialchars($this->comic->author); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition" placeholder="Tên tác giả...">
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Giá bán (VNĐ) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="price" min="0" required value="<?php echo htmlspecialchars($this->comic->price); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition pl-12">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">₫</span>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Số lượng kho <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" min="0" required value="<?php echo htmlspecialchars($this->comic->quantity); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition">
                </div>

                <div class="md:col-span-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Mô tả tóm tắt</label>
                    <textarea name="description" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition" placeholder="Nội dung tóm tắt cốt truyện..."><?php echo htmlspecialchars($this->comic->description); ?></textarea>
                </div>

                <div class="md:col-span-2 grid grid-cols-2 md:grid-cols-4 gap-4 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_sale" value="1" <?php echo ($this->comic->is_sale == 1) ? 'checked' : ''; ?> class="w-4 h-4 text-accent border-slate-300 rounded focus:ring-accent">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-tighter">TRUYỆN SALE</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_bestseller" value="1" <?php echo ($this->comic->is_bestseller == 1) ? 'checked' : ''; ?> class="w-4 h-4 text-accent border-slate-300 rounded focus:ring-accent">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-tighter">BÁN CHẠY</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_combo" value="1" <?php echo ($this->comic->is_combo == 1) ? 'checked' : ''; ?> class="w-4 h-4 text-accent border-slate-300 rounded focus:ring-accent">
                        <label class="text-xs font-bold text-slate-600 uppercase tracking-tighter">TRUYỆN COMBO</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_preorder" value="1" <?php echo ($this->comic->is_preorder == 1) ? 'checked' : ''; ?> class="w-4 h-4 text-accent border-slate-300 rounded focus:ring-accent">
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
                <div class="flex items-center space-x-8 p-4 bg-slate-50 rounded-2xl border border-slate-100 italic">
                    <div class="w-24 h-32 bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200 shrink-0">
                        <?php if($this->comic->image_url): ?>
                            <img src="<?php echo htmlspecialchars($this->comic->image_url); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-[8px] text-slate-300 font-bold p-2 text-center">Chưa có ảnh</div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 mb-1">Ảnh bìa hiện tại</p>
                        <p class="text-[10px] text-slate-400">Tải ảnh mới bên dưới để thay thế ảnh này.</p>
                    </div>
                </div>

                <div class="flex items-center justify-center border-2 border-dashed border-slate-200 rounded-2xl p-10 bg-white hover:bg-slate-50 transition cursor-pointer group relative">
                    <div class="text-center">
                        <i class="fas fa-sync-alt text-2xl text-slate-200 group-hover:text-accent transition duration-300 mb-3"></i>
                        <p class="text-sm font-bold text-slate-400">Chọn tệp ảnh mới</p>
                        <input type="file" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex items-center justify-center pointer-events-none">
                        <span class="bg-white px-4 text-[10px] font-black text-slate-300 uppercase tracking-widest">Hoặc thay bằng link ảnh</span>
                    </div>
                    <div class="border-t border-slate-100"></div>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Dán link ảnh</label>
                    <input type="text" name="image_url_link" value="<?php echo (strpos($this->comic->image_url, 'http') === 0) ? htmlspecialchars($this->comic->image_url) : ''; ?>" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accent transition" placeholder="https://example.com/image.jpg">
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="admin.php?controller=comic" class="px-8 py-3 rounded-xl text-sm font-bold text-slate-400 hover:text-slate-600 transition">HỦY BỎ</a>
            <button type="submit" class="bg-accent hover:bg-indigo-600 text-white font-bold py-3 px-12 rounded-xl transition shadow-xl shadow-indigo-200">
                LƯU THAY ĐỔI
            </button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
