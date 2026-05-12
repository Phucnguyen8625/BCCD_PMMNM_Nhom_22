# Đồ án môn học: Phần mềm mã nguồn mở
**Tên đề tài:** Xây dựng Website bán truyện tranh (MangaStore)

## 1. Giới thiệu website/hệ thống
MangaStore là một hệ thống website thương mại điện tử chuyên cung cấp truyện tranh. Hệ thống được xây dựng với mục tiêu cung cấp trải nghiệm mua sắm trực tuyến mượt mà cho người dùng (tìm kiếm, giỏ hàng, thanh toán VNPAY) và một hệ thống quản trị (Admin) mạnh mẽ để quản lý truyện, danh mục, đơn hàng và báo cáo doanh thu.
Đặc biệt, dự án áp dụng các tiêu chuẩn của "Phần mềm mã nguồn mở" bao gồm:
- **Kiến trúc Plugin/Module:** Các chức năng quản trị nghiệp vụ (Orders, Payments, Reports) được tách rời thành các module độc lập.
- **Tùy biến Skin (Dark/Light Mode):** Hỗ trợ đổi giao diện sáng tối linh hoạt.
- **Môi trường Ảo hóa:** Triển khai nhanh chóng qua Docker.

## 2. Danh sách thành viên
| STT | Họ và tên | MSSV |
|:---:|:---|:---|
| 1 | Nguyễn Dương Thế Bảo | 23810310087 |
| 2 | Nguyễn Duy Khánh | 23810310131 |
| 3 | Nguyễn Huy Phúc | 23810310141 |

## 3. Phân công nhiệm vụ cụ thể
- **Nguyễn Dương Thế Bảo:** Thiết kế Frontend/UI, Quản lý người dùng (CRUD, phân quyền), Trang chủ, Đăng ký/Đăng nhập, Tìm kiếm truyện, Bộ sưu tập truyện, Tùy biến Skin (Dark/Light mode).
- **Nguyễn Duy Khánh:** Quản lý danh mục, Quản lý truyện tranh (thêm/sửa/xóa, upload), Quản lý giỏ hàng, Lọc truyện theo danh mục.
- **Nguyễn Huy Phúc:** Quản lý đơn hàng (Admin), Quản lý thanh toán, Tích hợp thanh toán online VNPAY Sandbox, Thống kê/Báo cáo doanh thu (biểu đồ, xuất CSV).

## 4. Công nghệ sử dụng
- **Backend:** PHP (thuần/PDO)
- **Cơ sở dữ liệu:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript, Tailwind CSS
- **Thanh toán:** VNPAY API Sandbox
- **Môi trường/Khác:** Docker, Git/Github

## 5. Hướng dẫn cài đặt
### Cách 1: Chạy bằng XAMPP / WAMP (Khuyên dùng)
1. Clone dự án về thư mục `htdocs` (nếu dùng XAMPP) hoặc `www` (nếu dùng WAMP).
2. Khởi động Apache và MySQL trên XAMPP/WAMP.
3. Tạo một database mới tên là `ban_truyen_tranh` trong phpMyAdmin.
4. Import file `database.sql` và `seed.sql` (nếu cần dữ liệu mẫu) vào database vừa tạo.
5. Kiểm tra và cập nhật file cấu hình (ví dụ: `config/app.php` hoặc file chứa thông tin DB) với user là `root` và password để trống.
6. Truy cập dự án trên trình duyệt qua `http://localhost/BCCD_PMMNM` (hoặc tên thư mục bạn đặt).

### Cách 2: Chạy bằng Docker
Nếu máy bạn đã cài sẵn Docker và Docker Compose, chỉ cần mở terminal tại thư mục gốc của dự án và chạy:
```bash
docker-compose up -d
```
Hệ thống sẽ tự động build. Truy cập vào `http://localhost:8080`.

## 6. Hướng dẫn chạy project
- **Trang khách hàng:** Truy cập vào trang chủ qua đường dẫn gốc.
- **Trang quản trị:** Truy cập vào nút "Đăng nhập" (hoặc URL tương ứng) với tài khoản Demo bên dưới.

## 7. Tài khoản demo
- **Quyền Quản trị viên (Admin):**
  - **Tài khoản/Email:** `admin_test` hoặc `admin@test.com`
  - **Mật khẩu:** `admin123`

## 8. Hình ảnh minh họa hệ thống
- **Trang chủ:** 
  ![Trang chủ](assets/images/demo_home.png)
- **Giỏ hàng & Thanh toán:** 
  ![Giỏ hàng](assets/images/demo_cart.png)
- **Trang Admin & Thống kê:** 
  ![Trang Admin](assets/images/demo_admin.png)

## 9. Link Video Demo
- **Link Video:** [https://drive.google.com/drive/folders/1VBD3cMu2Ba7fLDVIwWwA9aJb4b5FydFQ?usp=sharing]

## 10. Link online đã deploy (nếu có)
- **Link Website:** [http://pkbcomic.io.vn](http://pkbcomic.io.vn)

## 11. Giấy phép (License)
Dự án được phân phối dưới giấy phép **MIT License**. Xem file `LICENSE` để biết thêm chi tiết.
