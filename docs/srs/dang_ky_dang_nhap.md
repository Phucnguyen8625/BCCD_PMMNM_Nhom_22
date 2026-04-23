# Software Requirement Specification (SRS)

Chức năng: Đăng ký / Đăng nhập

Mã chức năng: USER-AUTH-08
Trạng thái: Draft / Review
Người soạn thảo: Nhóm 2 / Nguyễn Dương Thế Bảo, Nguyễn Huy Phúc, Nguyễn Duy Khánh
Vai trò: Developer / Analyst

1. Mô tả tổng quan (Description)

Cho phép người dùng tạo tài khoản mới hoặc đăng nhập vào hệ thống để thực hiện mua hàng, quản lý đơn hàng và cập nhật thông tin cá nhân.

2. Luồng nghiệp vụ (User Workflow)
Bước	Hành động người dùng	Phản hồi hệ thống
1	User truy cập /login hoặc /register	Hiển thị form đăng nhập hoặc đăng ký.
2	User nhập thông tin và gửi form	Hệ thống kiểm tra tính hợp lệ của dữ liệu.
3	Dữ liệu đúng	Tạo tài khoản mới hoặc xác thực đăng nhập thành công.
4	Đăng nhập thành công	Chuyển hướng về trang chủ hoặc tài khoản cá nhân.
5	Có lỗi	Hiển thị thông báo lỗi tương ứng.
3. Yêu cầu dữ liệu (Data Requirements)
3.1. Dữ liệu đầu vào (Input Fields)
FullName: string, bắt buộc khi đăng ký.
Email: string, bắt buộc, đúng định dạng.
Password: string, bắt buộc.
ConfirmPassword: string, bắt buộc khi đăng ký.
3.2. Dữ liệu lưu trữ (Database - Bảng users)
full_name
email
password
status
created_at
4. Ràng buộc kỹ thuật & Bảo mật (Technical Constraints)
Mật khẩu phải được mã hóa.
Có validate phía client và server.
Không cho phép email trùng lặp.
Phiên đăng nhập phải được bảo mật.
5. Trường hợp ngoại lệ & Xử lý lỗi (Edge Cases)
Trường hợp: Email sai định dạng.
Xử lý: Hiển thị lỗi tại trường nhập.
Trường hợp: Mật khẩu xác nhận không khớp.
Xử lý: Hiển thị thông báo lỗi.
Trường hợp: Tài khoản bị khóa.
Xử lý: Từ chối đăng nhập và báo lý do.
6. Giao diện (UI/UX)
Form đơn giản, dễ dùng.
Có hiển thị/ẩn mật khẩu.
Hỗ trợ tốt trên điện thoại và máy tính.