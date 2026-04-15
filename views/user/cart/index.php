<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của bạn - MangaStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#4c2d73', secondary: '#f7941d', price: '#e53e3e', }
                }
            }
        }
    </script>
    <style> body { background-color: #ededed; font-family: 'Roboto', sans-serif; } </style>
</head>
<body class="text-gray-800">

    <!-- Top Header -->
    <header class="bg-primary pt-3 pb-3 px-4 relative" style="background-image: url('https://st.nettruyen.work/Data/Sites/1/media/bn-bg.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="index.php" class="text-3xl font-bold text-white tracking-widest pl-2" style="font-family: 'Verdana'; text-shadow: 2px 2px 0px #f7941d;">MangaStore</a>
            
            <div class="flex space-x-6 text-sm">
                <!-- Shopping Cart -->
                <a href="index.php?controller=cart" class="relative text-white flex items-center space-x-1 border-b-2 border-secondary pb-1">
                    <i class="fas fa-shopping-cart text-lg text-secondary"></i>
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                        <?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : '0'; ?>
                    </span>
                    <span class="ml-2 font-bold text-secondary">Giỏ hàng</span>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto my-8 px-4">
        <div class="flex items-center text-primary mb-6">
            <a href="index.php" class="hover:underline flex items-center"><i class="fas fa-angle-left mr-2"></i> Tiếp tục mua hàng</a>
            <span class="mx-4 text-gray-400">|</span>
            <h1 class="text-2xl font-bold text-gray-800">Giỏ hàng của bạn</h1>
        </div>

        <?php if(isset($_GET['success'])): ?>
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded flex items-center">
                <i class="fas fa-check-circle mr-2"></i> <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <?php if(empty($cart_items)): ?>
            <div class="bg-white p-10 text-center shadow-sm rounded-lg border border-gray-200">
                <div class="w-32 h-32 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center text-gray-300">
                    <i class="fas fa-shopping-cart text-5xl"></i>
                </div>
                <h2 class="text-xl font-semibold mb-2">Giỏ hàng trống</h2>
                <p class="text-gray-500 mb-6">Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                <a href="index.php" class="bg-secondary text-white font-bold py-2.5 px-6 rounded hover:bg-orange-600 transition shadow">Mua sắm ngay</a>
            </div>
        <?php else: ?>
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Cart Items -->
                <div class="w-full lg:w-2/3 bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                    <form action="index.php?controller=cart&action=update" method="POST">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Sản phẩm</th>
                                    <th class="px-4 py-4 font-semibold text-center">Đơn giá</th>
                                    <th class="px-4 py-4 font-semibold text-center">Số lượng</th>
                                    <th class="px-4 py-4 font-semibold text-right">Tạm tính</th>
                                    <th class="px-4 py-4"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach($cart_items as $item): ?>
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-16 h-24 bg-gray-200 flex-shrink-0 border border-gray-100">
                                                <img src="<?php echo htmlspecialchars($item['image']); ?>" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-800 text-sm mb-1"><?php echo htmlspecialchars($item['name']); ?></h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center font-medium">
                                        <?php echo number_format($item['price'], 0, ',', '.'); ?>đ
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <input type="number" name="quantities[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="w-16 px-2 py-1 text-center border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-primary">
                                    </td>
                                    <td class="px-4 py-4 text-right font-bold text-price">
                                        <?php echo number_format($item['subtotal'], 0, ',', '.'); ?>đ
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="index.php?controller=cart&action=remove&id=<?php echo $item['id']; ?>" class="text-gray-400 hover:text-red-500 transition" title="Xóa">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                        <div class="p-4 bg-gray-50 flex justify-end">
                            <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded font-medium text-sm transition">Cập nhật Giỏ Hàng</button>
                        </div>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6 sticky top-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-4 border-b border-gray-200">Thông tin đơn hàng</h3>
                        
                        <div class="space-y-3 text-sm mb-4 border-b border-gray-200 pb-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tạm tính:</span>
                                <span class="font-medium"><?php echo number_format($total_price, 0, ',', '.'); ?>đ</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Phí vận chuyển:</span>
                                <span class="text-green-600 font-medium">Miễn phí</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between mb-6">
                            <span class="font-bold text-gray-800 text-lg">Tổng cộng:</span>
                            <span class="font-bold text-price text-2xl"><?php echo number_format($total_price, 0, ',', '.'); ?>đ</span>
                        </div>
                        
                        <a href="phuc_modules/checkout/index.php" class="w-full bg-primary hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg transition shadow-md flex items-center justify-center">
                            TIẾN HÀNH THANH TOÁN <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>
