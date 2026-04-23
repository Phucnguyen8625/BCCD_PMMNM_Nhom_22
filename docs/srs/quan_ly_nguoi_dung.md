# Software Requirement Specification (SRS)

Chức năng: Quản lý người dùng

Mã chức năng: ADMIN-USER-01
Trạng thái: Draft / Review
Người soạn thảo: Nhóm 2 / Nguyễn Dương Thế Bảo, Nguyễn Huy Phúc, Nguyễn Duy Khánh
Vai trò: Developer / Analyst

1. Mô tả tổng quan (Description)

Cung cấp chức năng cho quản trị viên quản lý toàn bộ tài khoản người dùng trên hệ thống website truyện tranh. Admin có thể xem danh sách người dùng, tìm kiếm, cập nhật thông tin, khóa/mở khóa tài khoản và xóa tài khoản khi cần thiết.

2. Luồng nghiệp vụ (User Workflow)
Bước	Hành động người dùng	Phản hồi hệ thống
1	Admin truy cập trang /admin/users	Hiển thị danh sách tài khoản người dùng.
2	Admin chọn tìm kiếm, xem chi tiết hoặc chỉnh sửa người dùng	Hệ thống hiển thị kết quả tương ứng.
3	Admin cập nhật trạng thái hoặc thông tin tài khoản	Hệ thống kiểm tra dữ liệu hợp lệ.
4	Dữ liệu hợp lệ	Hệ thống lưu thay đổi vào Database.
5	Có lỗi dữ liệu hoặc tài khoản không hợp lệ	Hệ thống hiển thị thông báo lỗi.
3. Yêu cầu dữ liệu (Data Requirements)
3.1. Dữ liệu đầu vào (Input Fields)
UserID: int, bắt buộc, định danh người dùng.
FullName: string, bắt buộc.
Email: string, đúng định dạng email, bắt buộc.
Phone: string, tùy chọn.
Status: boolean / enum, trạng thái hoạt động hoặc bị khóa.
3.2. Dữ liệu lưu trữ (Database - Bảng users)
id: khóa chính.
full_name: tên người dùng.
email: unique.
password: mật khẩu đã mã hóa.
phone: số điện thoại.
status: trạng thái tài khoản.
created_at: thời gian tạo.
updated_at: thời gian cập nhật.
4. Ràng buộc kỹ thuật & Bảo mật (Technical Constraints)
Chỉ tài khoản có quyền Admin mới được truy cập chức năng này.
Toàn bộ thao tác cập nhật/xóa phải được ghi log.
Thông tin người dùng phải được bảo vệ và không hiển thị mật khẩu gốc.
Hệ thống phải kiểm tra quyền trước khi cho phép sửa hoặc xóa.
5. Trường hợp ngoại lệ & Xử lý lỗi (Edge Cases)
Trường hợp: Admin tìm kiếm người dùng không tồn tại.
Xử lý: Hiển thị thông báo "Không tìm thấy người dùng phù hợp".
Trường hợp: Email cập nhật bị trùng với tài khoản khác.
Xử lý: Hiển thị lỗi "Email đã tồn tại trong hệ thống".
Trường hợp: Admin xóa người dùng đang có đơn hàng.
Xử lý: Không cho phép xóa cứng, chỉ cho phép khóa tài khoản.
6. Giao diện (UI/UX)
Hiển thị bảng danh sách người dùng rõ ràng, có phân trang.
Có ô tìm kiếm nhanh theo tên hoặc email.
Có nút thao tác: Xem, Sửa, Khóa/Mở khóa, Xóa.
Thiết kế dễ sử dụng trên Desktop.