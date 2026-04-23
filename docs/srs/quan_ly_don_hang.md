# Software Requirement Specification (SRS)

Chức năng: Quản lý đơn hàng

Mã chức năng: ADMIN-ORDER-04
Trạng thái: Draft / Review
Người soạn thảo: Nhóm 2 / Nguyễn Dương Thế Bảo, Nguyễn Huy Phúc, Nguyễn Duy Khánh
Vai trò: Developer / Analyst

1. Mô tả tổng quan (Description)

Cho phép Admin theo dõi và xử lý các đơn hàng của khách hàng, bao gồm xem chi tiết đơn, cập nhật trạng thái đơn hàng, xác nhận giao hàng hoặc hủy đơn.

2. Luồng nghiệp vụ (User Workflow)
Bước	Hành động người dùng	Phản hồi hệ thống
1	Admin truy cập trang /admin/orders	Hiển thị danh sách đơn hàng.
2	Admin chọn xem chi tiết một đơn hàng	Hệ thống hiển thị thông tin chi tiết đơn hàng.
3	Admin cập nhật trạng thái đơn	Hệ thống kiểm tra điều kiện cập nhật.
4	Cập nhật hợp lệ	Lưu trạng thái mới vào Database.
5	Có lỗi	Hiển thị thông báo lỗi.
3. Yêu cầu dữ liệu (Data Requirements)
3.1. Dữ liệu đầu vào (Input Fields)
OrderID: int, bắt buộc.
Status: enum, bắt buộc. Ví dụ: Chờ xác nhận, Đang giao, Hoàn thành, Đã hủy.
Note: string, tùy chọn.
3.2. Dữ liệu lưu trữ (Database - Bảng orders)
id: khóa chính.
user_id: mã người dùng.
total_amount: tổng tiền.
status: trạng thái đơn hàng.
payment_status: trạng thái thanh toán.
created_at: thời gian đặt hàng.
4. Ràng buộc kỹ thuật & Bảo mật (Technical Constraints)
Chỉ Admin mới được cập nhật trạng thái đơn.
Không cho phép cập nhật trái logic quy trình đơn hàng.
Mọi thay đổi trạng thái phải được lưu log.
5. Trường hợp ngoại lệ & Xử lý lỗi (Edge Cases)
Trường hợp: Đơn hàng không tồn tại.
Xử lý: Hiển thị lỗi "Đơn hàng không tồn tại".
Trường hợp: Đơn hàng đã hoàn thành nhưng tiếp tục sửa trạng thái.
Xử lý: Hạn chế cập nhật hoặc yêu cầu quyền đặc biệt.
Trường hợp: Lỗi kết nối cơ sở dữ liệu.
Xử lý: Hiển thị thông báo hệ thống bận.
6. Giao diện (UI/UX)
Có bộ lọc trạng thái đơn hàng.
Có trang chi tiết đơn hàng dễ theo dõi.
Màu sắc trạng thái đơn hàng cần trực quan.