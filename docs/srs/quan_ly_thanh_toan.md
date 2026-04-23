# Software Requirement Specification (SRS)

Chức năng: Quản lý thanh toán

Mã chức năng: ADMIN-PAY-05
Trạng thái: Draft / Review
Người soạn thảo: Nhóm 2 / Nguyễn Dương Thế Bảo, Nguyễn Huy Phúc, Nguyễn Duy Khánh
Vai trò: Developer / Analyst

1. Mô tả tổng quan (Description)

Chức năng này giúp Admin quản lý thông tin thanh toán của đơn hàng, kiểm tra trạng thái thanh toán online, đối soát các giao dịch thành công, thất bại hoặc đang chờ xử lý.

2. Luồng nghiệp vụ (User Workflow)
Bước	Hành động người dùng	Phản hồi hệ thống
1	Admin truy cập trang /admin/payments	Hiển thị danh sách giao dịch thanh toán.
2	Admin chọn xem chi tiết giao dịch	Hiển thị thông tin phương thức và trạng thái thanh toán.
3	Admin đối chiếu trạng thái giao dịch	Hệ thống truy xuất dữ liệu giao dịch.
4	Giao dịch hợp lệ	Hiển thị kết quả thành công.
5	Giao dịch lỗi	Hiển thị trạng thái thất bại hoặc chờ xử lý.
3. Yêu cầu dữ liệu (Data Requirements)
3.1. Dữ liệu đầu vào (Input Fields)
PaymentID: int, bắt buộc.
OrderID: int, bắt buộc.
Method: string, ví dụ: Momo, VNPAY, COD.
Status: enum, bắt buộc.
3.2. Dữ liệu lưu trữ (Database - Bảng payments)
id: khóa chính.
order_id: mã đơn hàng.
method: phương thức thanh toán.
status: trạng thái giao dịch.
transaction_code: mã giao dịch.
paid_at: thời gian thanh toán.
4. Ràng buộc kỹ thuật & Bảo mật (Technical Constraints)
Dữ liệu thanh toán phải được bảo mật.
Chỉ Admin mới được truy cập màn hình quản lý thanh toán.
Kết nối với cổng thanh toán phải đảm bảo an toàn.
5. Trường hợp ngoại lệ & Xử lý lỗi (Edge Cases)
Trường hợp: Không tìm thấy giao dịch.
Xử lý: Hiển thị thông báo phù hợp.
Trường hợp: Giao dịch chưa hoàn tất.
Xử lý: Hiển thị trạng thái "Đang xử lý".
Trường hợp: Sai lệch dữ liệu đơn hàng và thanh toán.
Xử lý: Gắn cờ để Admin kiểm tra thủ công.
6. Giao diện (UI/UX)
Bảng giao dịch dễ theo dõi.
Có bộ lọc theo phương thức và trạng thái.
Hỗ trợ xem chi tiết từng giao dịch.