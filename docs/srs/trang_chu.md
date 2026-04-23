# Software Requirement Specification (SRS)

Chức năng: Trang chủ

Mã chức năng: USER-HOME-07
Trạng thái: Draft / Review
Người soạn thảo: Nhóm 2 / Nguyễn Dương Thế Bảo, Nguyễn Huy Phúc, Nguyễn Duy Khánh
Vai trò: Developer / Analyst

1. Mô tả tổng quan (Description)

Trang chủ là nơi hiển thị thông tin tổng quan về website truyện tranh, bao gồm danh sách truyện nổi bật, truyện mới cập nhật, truyện theo danh mục và các chương trình khuyến mãi nếu có.

2. Luồng nghiệp vụ (User Workflow)
Bước	Hành động người dùng	Phản hồi hệ thống
1	User truy cập /	Hiển thị trang chủ.
2	User xem danh sách truyện nổi bật	Hệ thống tải dữ liệu truyện từ Database.
3	User chọn một truyện bất kỳ	Chuyển đến trang chi tiết truyện.
3. Yêu cầu dữ liệu (Data Requirements)
3.1. Dữ liệu đầu vào
Không bắt buộc nhập dữ liệu.
3.2. Dữ liệu hiển thị
Danh sách truyện mới.
Danh sách truyện nổi bật.
Danh mục truyện.
Banner hoặc thông báo nổi bật.
4. Ràng buộc kỹ thuật & Bảo mật (Technical Constraints)
Trang phải tải nhanh.
Hỗ trợ tốt trên desktop và mobile.
Nội dung hiển thị phải lấy từ dữ liệu hợp lệ.
5. Trường hợp ngoại lệ & Xử lý lỗi (Edge Cases)
Trường hợp: Không có dữ liệu truyện.
Xử lý: Hiển thị thông báo phù hợp.
Trường hợp: Lỗi tải dữ liệu.
Xử lý: Hiển thị trang lỗi hoặc nội dung thay thế.
6. Giao diện (UI/UX)
Thiết kế đẹp, dễ nhìn.
Các khu vực truyện được phân chia rõ ràng.
Có thanh menu, banner và danh mục nổi bật.