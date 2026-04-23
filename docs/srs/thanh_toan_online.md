# Software Requirement Specification (SRS)

Chức năng: Thanh toán online

Mã chức năng: USER-PAY-11
Trạng thái: Draft / Review
Người soạn thảo: Nhóm 2 / Nguyễn Dương Thế Bảo, Nguyễn Huy Phúc, Nguyễn Duy Khánh
Vai trò: Developer / Analyst

1. Mô tả tổng quan (Description)

Cho phép người dùng thanh toán đơn hàng thông qua các phương thức online như Momo, VNPAY hoặc COD nếu hệ thống hỗ trợ.

2. Luồng nghiệp vụ (User Workflow)
Bước	Hành động người dùng	Phản hồi hệ thống
1	User vào trang thanh toán	Hệ thống hiển thị thông tin đơn hàng.
2	User nhập địa chỉ nhận hàng và chọn phương thức thanh toán	Hệ thống kiểm tra dữ liệu hợp lệ.
3	User xác nhận thanh toán	Hệ thống tạo đơn hàng và chuyển tới cổng thanh toán nếu cần.
4	Thanh toán thành công	Hiển thị thông báo đặt hàng thành công.
5	Thanh toán thất bại	Hiển thị thông báo lỗi hoặc cho phép thử lại.
3. Yêu cầu dữ liệu (Data Requirements)
3.1. Dữ liệu đầu vào
ReceiverName: string, bắt buộc.
Address: string, bắt buộc.
Phone: string, bắt buộc.
PaymentMethod: string, bắt buộc.
3.2. Dữ liệu lưu trữ
Thông tin đơn hàng.
Phương thức thanh toán.
Trạng thái thanh toán.
Mã giao dịch nếu có.
4. Ràng buộc kỹ thuật & Bảo mật (Technical Constraints)
Kết nối cổng thanh toán phải an toàn.
Dữ liệu cá nhân và thanh toán phải được bảo vệ.
Không tạo trùng đơn hàng do bấm nhiều lần.
5. Trường hợp ngoại lệ & Xử lý lỗi (Edge Cases)
Trường hợp: Thiếu địa chỉ hoặc số điện thoại.
Xử lý: Hiển thị lỗi yêu cầu bổ sung thông tin.
Trường hợp: Thanh toán online thất bại.
Xử lý: Cập nhật trạng thái thất bại và cho phép thử lại.
Trường hợp: Mất kết nối với cổng thanh toán.
Xử lý: Báo lỗi và lưu trạng thái chờ xử lý nếu cần.
6. Giao diện (UI/UX)
Bố cục rõ ràng, dễ nhập.
Hiển thị đầy đủ sản phẩm, phí và tổng tiền.
Có nút xác nhận thanh toán nổi bật.