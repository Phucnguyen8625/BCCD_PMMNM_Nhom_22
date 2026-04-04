# Module phần việc của Nguyễn Huy Phúc

## 1) Mình đã bám theo đúng phần việc nào?
Từ file Excel phân công nhóm, phần của **Nguyễn Huy Phúc** là:
- Quản lý đơn hàng (admin)
- Quản lý thanh toán
- Thống kê / Báo cáo
- Thanh toán online

Repo GitHub công khai hiện tại đã có nhiều branch tên đúng theo nhóm chức năng, nhưng nội dung public nhìn thấy trên `main` và cả các branch bạn gửi vẫn chủ yếu là tài liệu (`reports/`, `DECUONG.MD`, `README.md`), chưa thấy mã nguồn PHP ứng dụng để mình nối trực tiếp vào project đang chạy. Vì vậy mình làm theo hướng **tạo trọn bộ module PHP/MySQL độc lập, dễ paste vào repo**.

## 2) Trong gói này có gì?

### Shared / dùng chung
- `config/app.php`: cấu hình DB, BASE_URL, VNPAY sandbox
- `config/database.php`: kết nối PDO
- `helpers/functions.php`: hàm tiện ích, flash message, cart demo, format tiền
- `helpers/auth.php`: chặn quyền user/admin
- `helpers/vnpay.php`: tạo URL thanh toán VNPAY, verify checksum, query sandbox
- `layouts/header.php`, `layouts/footer.php`
- `assets/css/app.css`

### Phần 1 - Quản lý đơn hàng (admin)
- `admin/orders/index.php`
- `admin/orders/detail.php`
- `admin/orders/update_status.php`

Chức năng có sẵn:
- Xem danh sách đơn hàng
- Lọc theo trạng thái, tìm theo mã đơn / tên / email / số điện thoại
- Xem chi tiết đơn
- Cập nhật trạng thái theo luồng nghiệp vụ
- Ghi log thay đổi trạng thái

### Phần 2 - Quản lý thanh toán
- `admin/payments/index.php`
- `admin/payments/detail.php`
- `admin/payments/update_status.php`
- `admin/payments/query_vnpay.php`

Chức năng có sẵn:
- Xem danh sách giao dịch
- Lọc theo phương thức / trạng thái
- Xem chi tiết giao dịch
- Đối soát thủ công
- Query lại VNPAY sandbox bằng API `querydr`

### Phần 3 - Thống kê / Báo cáo
- `admin/reports/index.php`
- `admin/reports/export_csv.php`

Chức năng có sẵn:
- Lọc báo cáo theo ngày
- KPI: doanh thu, số đơn, user mới, giao dịch thành công
- Top truyện bán chạy
- Bảng doanh thu theo ngày
- Xuất CSV

### Phần 4 - Thanh toán online
- `checkout/index.php`
- `checkout/process_checkout.php`
- `checkout/vnpay_return.php`
- `checkout/vnpay_ipn.php`

Chức năng có sẵn:
- Form checkout
- Tạo đơn hàng + order items + payment record
- Hỗ trợ COD và VNPAY sandbox
- Xử lý return callback và IPN callback của VNPAY

## 3) Cấu trúc cart và session mình đang giả định
Vì repo chưa có source giỏ hàng thật, mình đang giả định:

```php
$_SESSION['user'] = [
    'id' => 1,
    'full_name' => 'Tên user',
    'role' => 'admin' hoặc 'user'
];

$_SESSION['cart'] = [
    [
        'comic_id' => 1,
        'name' => 'One Piece Tập 1',
        'price' => 25000,
        'quantity' => 2,
        'image_url' => ''
    ]
];
```

Nếu nhóm bạn đang lưu cart kiểu khác thì chỉ cần sửa trong `helpers/functions.php` ở hàm `cartItems()`.

## 4) Cách chạy nhanh
1. Tạo database và import:
   - `sql/phuc_modules.sql`
   - nếu muốn dữ liệu test thì import thêm `sql/demo_seed_optional.sql`
2. Sửa file `config/app.php`:
   - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`
   - `BASE_URL`
   - `VNPAY_TMN_CODE`, `VNPAY_HASH_SECRET`
3. Chép toàn bộ thư mục này vào project PHP của nhóm.
4. Mở các đường dẫn:
   - `/admin/orders/index.php`
   - `/admin/payments/index.php`
   - `/admin/reports/index.php`
   - `/checkout/index.php`

## 5) Gợi ý ghép vào branch Git của nhóm
Bạn đang có các branch:
- `feature/admin-orders`
- `feature/admin-payments`
- `feature/admin-reports`
- `feature/checkout`

Cách chia file:

### branch `feature/admin-orders`
- `admin/orders/*`
- `helpers/functions.php` (nếu chưa có)
- `helpers/auth.php`
- `layouts/*`
- `assets/css/app.css`

### branch `feature/admin-payments`
- `admin/payments/*`
- `helpers/vnpay.php`
- các file shared nếu branch chưa có

### branch `feature/admin-reports`
- `admin/reports/*`
- các file shared nếu branch chưa có

### branch `feature/checkout`
- `checkout/*`
- `helpers/vnpay.php`
- các file shared nếu branch chưa có

## 6) Lệnh git mẫu
```bash
git checkout feature/admin-orders
# copy file admin/orders + file shared cần thiết
git add .
git commit -m "feat: add admin order management module"
git push origin feature/admin-orders

git checkout feature/admin-payments
# copy file admin/payments + helpers/vnpay.php
git add .
git commit -m "feat: add admin payment management module"
git push origin feature/admin-payments

git checkout feature/admin-reports
# copy file admin/reports
git add .
git commit -m "feat: add admin reports module"
git push origin feature/admin-reports

git checkout feature/checkout
# copy file checkout/*
git add .
git commit -m "feat: add checkout and vnpay sandbox flow"
git push origin feature/checkout
```

## 7) Chỗ nào cần chỉnh khi ghép với code nhóm?
- Nếu nhóm đã có `users`, `comics`, `orders`, `payments` khác tên cột thì sửa lại SQL query trong các file PHP.
- Nếu nhóm đã có giao diện chung thì chỉ giữ logic PHP, bỏ phần `layouts`/`assets` của mình.
- Nếu nhóm đã có auth/login thì bỏ `ensureSeedSessionData()` và dùng session thật của nhóm.
- Nếu nhóm đã có giỏ hàng DB-based thì sửa `cartItems()` để lấy từ DB thay vì session.

## 8) Lưu ý riêng cho VNPAY sandbox
- Cần có tài khoản sandbox để lấy `vnp_TmnCode` và `HashSecret`.
- URL thanh toán sandbox và API query sandbox đã được mình để sẵn trong config.
- Nếu chưa có key sandbox thì module checkout vẫn chạy được với COD, còn VNPAY sẽ báo lỗi cấu hình.

## 9) Mức độ hoàn thiện
Gói này đủ để:
- demo đồ án môn học
- chia commit theo đúng branch của bạn
- có nghiệp vụ admin order / payment / report / checkout tương đối trọn luồng

Nếu repo của nhóm sau đó có source thật, bạn chỉ cần ghép logic này vào là được.
