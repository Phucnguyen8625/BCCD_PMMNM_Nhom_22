# Báo cáo Đồ án Web Nâng Cao - MangaStore

## Mục lục Software Requirement Specification (SRS)

- [Quản lý người dùng](docs/srs/quan_ly_nguoi_dung.md)
- [Quản lý danh mục truyện](docs/srs/quan_ly_danh_muc_truyen.md)
- [Quản lý truyện tranh](docs/srs/quan_ly_truyen_tranh.md)
- [Quản lý đơn hàng](docs/srs/quan_ly_don_hang.md)
- [Quản lý thanh toán](docs/srs/quan_ly_thanh_toan.md)
- [Thống kê / Báo cáo](docs/srs/thong_ke_bao_cao.md)
- [Trang chủ](docs/srs/trang_chu.md)
- [Đăng ký / Đăng nhập](docs/srs/dang_ky_dang_nhap.md)
- [Tìm kiếm truyện](docs/srs/tim_kiem_truyen.md)
- [Giỏ hàng](docs/srs/gio_hang.md)
- [Thanh toán online](docs/srs/thanh_toan_online.md)
- [Quản lý đơn hàng của người dùng](docs/srs/quan_ly_don_hang_cua_nguoi_dung.md)
- [Cập nhật thông tin cá nhân](docs/srs/cap_nhat_thong_tin_ca_nhan.md)

---

## Báo cáo chuyên đề: Xây dựng Website bán truyện tranh

Dự án này đã được tối ưu để đáp ứng các tiêu chuẩn của báo cáo chuyên đề **Phần mềm mã nguồn mở**.

### 1. Tùy biến Skin (Dark Mode)
Giao diện người dùng được trang bị tính năng chuyển đổi **Light/Dark Mode** (nút bấm ở góc phải Header). 
Tính năng này tự động lưu trạng thái vào `localStorage` và ghi đè CSS Variables bằng class `.dark` của Tailwind CSS, minh chứng cho khả năng tùy biến giao diện linh hoạt.

### 2. Kiến trúc Plugin/Module
Toàn bộ nghiệp vụ Admin (Orders, Payments, Reports) được gói gọn trong thư mục `phuc_modules`. Đây là kiến trúc cho phép dễ dàng cắm (plug) hoặc tháo (unplug) các tính năng nghiệp vụ mà không ảnh hưởng sâu đến core của hệ thống.

### 3. Môi trường Ảo hóa (Docker)
Dự án cung cấp sẵn cấu hình `docker-compose.yml` và `Dockerfile` để triển khai nhanh chóng trên môi trường ảo hóa:
```bash
# Chạy dự án với Docker
docker-compose up -d
```
Ứng dụng sẽ tự động khởi tạo PHP/Apache trên cổng `8080` và kết nối với cơ sở dữ liệu MySQL chạy nền. Truy cập vào `http://localhost:8080`.

### 4. License
Dự án được phân phối dưới giấy phép **MIT License** (xem file `LICENSE`), cho phép sử dụng, sửa đổi và phân phối tự do.
