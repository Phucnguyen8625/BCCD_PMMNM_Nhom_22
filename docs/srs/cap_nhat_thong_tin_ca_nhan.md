# Software Requirement Specification (SRS)

Chức năng: Cập nhật thông tin cá nhân

Mã chức năng: USER-PROFILE-13
Trạng thái: Draft / Review
Người soạn thảo: Nhóm 2 / Nguyễn Dương Thế Bảo, Nguyễn Huy Phúc, Nguyễn Duy Khánh
Vai trò: Developer / Analyst

1. Mô tả tổng quan (Description)

Cho phép người dùng chỉnh sửa thông tin cá nhân như họ tên, số điện thoại, địa chỉ, ảnh đại diện và đổi mật khẩu.

2. Luồng nghiệp vụ (User Workflow)
Bước	Hành động người dùng	Phản hồi hệ thống
1	User truy cập trang /profile	Hệ thống hiển thị thông tin cá nhân hiện tại.
2	User chỉnh sửa thông tin	Hệ thống nhận dữ liệu mới.
3	User nhấn lưu	Hệ thống kiểm tra dữ liệu hợp lệ.
4	Dữ liệu đúng	Hệ thống cập nhật vào Database.
5	Có lỗi	Hiển thị thông báo lỗi.
3. Yêu cầu dữ liệu (Data Requirements)
3.1. Dữ liệu đầu vào
FullName: string, bắt buộc.
Phone: string, tùy chọn.
Address: string, tùy chọn.
Avatar: file/string, tùy chọn.
NewPassword: string, tùy chọn.
3.2. Dữ liệu lưu trữ
full_name
phone
address
avatar
password
updated_at
4. Ràng buộc kỹ thuật & Bảo mật (Technical Constraints)
Người dùng chỉ được cập nhật tài khoản của chính mình.
Mật khẩu mới phải được mã hóa.
Ảnh đại diện phải đúng định dạng cho phép.
5. Trường hợp ngoại lệ & Xử lý lỗi (Edge Cases)
Trường hợp: Số điện thoại sai định dạng.
Xử lý: Hiển thị lỗi tại trường nhập.
Trường hợp: Mật khẩu mới quá ngắn.
Xử lý: Từ chối cập nhật và báo lỗi.
Trường hợp: Upload ảnh không hợp lệ.
Xử lý: Hiển thị thông báo lỗi.
6. Giao diện (UI/UX)
Form thông tin cá nhân dễ nhìn.
Có ảnh đại diện và nút đổi ảnh.
Có nút lưu thay đổi rõ ràng.