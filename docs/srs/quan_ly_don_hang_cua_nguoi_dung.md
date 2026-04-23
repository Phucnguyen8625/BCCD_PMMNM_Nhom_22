# Software Requirement Specification (SRS)

Chức năng: Quản lý đơn hàng của người dùng

Mã chức năng: USER-ORDER-12
Trạng thái: Draft / Review
Người soạn thảo: Nhóm 2 / Nguyễn Dương Thế Bảo, Nguyễn Huy Phúc, Nguyễn Duy Khánh
Vai trò: Developer / Analyst

1. Mô tả tổng quan (Description)

Cho phép người dùng xem lịch sử đơn hàng, kiểm tra trạng thái xử lý đơn, xem chi tiết từng đơn hàng và theo dõi tiến trình mua hàng.

2. Luồng nghiệp vụ (User Workflow)
Bước	Hành động người dùng	Phản hồi hệ thống
1	User truy cập trang /my-orders	Hiển thị danh sách đơn hàng của người dùng.
2	User chọn một đơn hàng	Hệ thống hiển thị chi tiết đơn hàng.
3	User theo dõi trạng thái đơn hàng	Hệ thống hiển thị trạng thái mới nhất.
3. Yêu cầu dữ liệu (Data Requirements)
3.1. Dữ liệu truy xuất
order_id
created_at
total_amount
status
payment_status
4. Ràng buộc kỹ thuật & Bảo mật (Technical Constraints)
Người dùng chỉ được xem đơn hàng của chính mình.
Dữ liệu phải được xác thực theo tài khoản đăng nhập.
5. Trường hợp ngoại lệ & Xử lý lỗi (Edge Cases)
Trường hợp: Người dùng chưa có đơn hàng.
Xử lý: Hiển thị thông báo chưa có lịch sử mua hàng.
Trường hợp: User cố truy cập đơn của người khác.
Xử lý: Từ chối truy cập.
6. Giao diện (UI/UX)
Danh sách đơn hàng rõ ràng.
Có hiển thị trạng thái đơn bằng nhãn màu.
Có nút xem chi tiết.