<?php $currentController = $_GET['controller'] ?? 'report'; ?>
<aside class="w-64 bg-adminPrimary text-slate-300 flex-shrink-0 flex flex-col transition-all duration-300">
    <!-- Brand -->
    <div class="h-20 flex items-center px-6 border-b border-slate-800">
        <i class="fas fa-book-reader text-accent text-2xl mr-3"></i>
        <span class="text-xl font-bold text-white tracking-tight">MANGA<span class="text-accent">ADMIN</span></span>
    </div>

    <!-- User Info Short -->
    <div class="p-4 border-b border-slate-800">
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center text-white font-bold text-lg">
                <?php echo substr($_SESSION['user_login']['full_name'] ?? 'A', 0, 1); ?>
            </div>
            <div class="ml-3 overflow-hidden">
                <p class="text-sm font-semibold text-white truncate"><?php echo htmlspecialchars($_SESSION['user_login']['full_name'] ?? 'Administrator'); ?></p>
                <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Quản trị viên</p>
            </div>
        </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 overflow-y-auto custom-scrollbar py-6 space-y-1">
        <p class="px-6 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 opacity-50">Tổng quan</p>
        <a href="admin.php?controller=report" class="sidebar-link flex items-center px-6 py-3 hover:bg-slate-800 hover:text-white transition-colors <?php echo $currentController == 'report' ? 'active text-white' : ''; ?>">
            <i class="fas fa-chart-line w-5 mr-3 opacity-60"></i>
            <span class="text-sm font-medium">Bảng điều khiển</span>
        </a>

        <p class="px-6 text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-6 mb-2 opacity-50">Quản lý nội dung</p>
        <a href="admin.php?controller=category" class="sidebar-link flex items-center px-6 py-3 hover:bg-slate-800 hover:text-white transition-colors <?php echo $currentController == 'category' ? 'active text-white' : ''; ?>">
            <i class="fas fa-tags w-5 mr-3 opacity-60"></i>
            <span class="text-sm font-medium">Danh mục truyện</span>
        </a>
        <a href="admin.php?controller=comic" class="sidebar-link flex items-center px-6 py-3 hover:bg-slate-800 hover:text-white transition-colors <?php echo $currentController == 'comic' ? 'active text-white' : ''; ?>">
            <i class="fas fa-book w-5 mr-3 opacity-60"></i>
            <span class="text-sm font-medium">Kho truyện tranh</span>
        </a>

        <p class="px-6 text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-6 mb-2 opacity-50">Giao dịch & Khách hàng</p>
        <a href="admin.php?controller=order" class="sidebar-link flex items-center px-6 py-3 hover:bg-slate-800 hover:text-white transition-colors <?php echo $currentController == 'order' ? 'active text-white' : ''; ?>">
            <i class="fas fa-shopping-cart w-5 mr-3 opacity-60"></i>
            <span class="text-sm font-medium">Đơn hàng</span>
        </a>
        <a href="admin.php?controller=payment" class="sidebar-link flex items-center px-6 py-3 hover:bg-slate-800 hover:text-white transition-colors <?php echo $currentController == 'payment' ? 'active text-white' : ''; ?>">
            <i class="fas fa-credit-card w-5 mr-3 opacity-60"></i>
            <span class="text-sm font-medium">Thanh toán</span>
        </a>
        <a href="admin.php?controller=user" class="sidebar-link flex items-center px-6 py-3 hover:bg-slate-800 hover:text-white transition-colors <?php echo $currentController == 'user' ? 'active text-white' : ''; ?>">
            <i class="fas fa-users w-5 mr-3 opacity-60"></i>
            <span class="text-sm font-medium">Người dùng</span>
        </a>
    </nav>

    <!-- Bottom Actions -->
    <div class="p-4 bg-slate-950/30 border-t border-slate-800">
        <a href="index.php" class="flex items-center px-4 py-2 text-xs text-slate-400 hover:text-white transition-colors">
            <i class="fas fa-home mr-3"></i> Xem website
        </a>
        <a href="index.php?controller=auth&action=logout" class="flex items-center px-4 py-2 text-xs text-red-400 hover:text-red-300 transition-colors">
            <i class="fas fa-sign-out-alt mr-3"></i> Đăng xuất
        </a>
    </div>
</aside>

<div class="flex-1 flex flex-col overflow-hidden">
    <!-- Top Nav / Header -->
    <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 flex-shrink-0">
        <h2 class="text-xl font-bold text-slate-800 capitalize">
            <?php 
                $titles = [
                    'report' => 'Bảng điều khiển & Thống kê',
                    'category' => 'Quản lý Danh mục',
                    'comic' => 'Quản lý Truyện tranh',
                    'order' => 'Quản lý Đơn hàng',
                    'payment' => 'Quản lý Thanh toán',
                    'user' => 'Quản lý Người dùng'
                ];
                echo $titles[$currentController] ?? 'Admin Panel';
            ?>
        </h2>
        
        <div class="flex items-center space-x-6">
            <button class="text-slate-400 hover:text-slate-600 relative">
                <i class="far fa-bell text-xl"></i>
                <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
            </button>
            <div class="h-8 w-[1px] bg-slate-200"></div>
            <div class="flex items-center group cursor-pointer">
                <div class="text-right mr-3 hidden sm:block">
                    <p class="text-sm font-bold text-slate-800 leading-none mb-1"><?php echo htmlspecialchars($_SESSION['user_login']['username'] ?? 'admin'); ?></p>
                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-tighter">Đang hoạt động</p>
                </div>
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_login']['full_name'] ?? 'Admin'); ?>&background=6366f1&color=fff" class="w-10 h-10 rounded-lg shadow-sm">
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto p-8 custom-scrollbar">
