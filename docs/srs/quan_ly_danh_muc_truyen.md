# Software Requirement Specification (SRS)

Chức năng: Quản lý danh mục truyện

Mã chức năng: ADMIN-CATE-02
Trạng thái: Draft / Review
Người soạn thảo: Nhóm 2 / Nguyễn Dương Thế Bảo, Nguyễn Huy Phúc, Nguyễn Duy Khánh
Vai trò: Developer / Analyst

1. Mô tả tổng quan (Description)

Cho phép quản trị viên thêm mới, chỉnh sửa, xóa và quản lý các danh mục truyện trên hệ thống như hành động, tình cảm, học đường, kinh dị, phiêu lưu,...

2. Luồng nghiệp vụ (User Workflow)
Bước	Hành động người dùng	Phản hồi hệ thống
1	Admin truy cập trang /admin/categories	Hiển thị danh sách danh mục truyện.
2	Admin chọn thêm mới hoặc chỉnh sửa danh mục	Hệ thống hiển thị form nhập dữ liệu.
3	Admin nhập tên danh mục và lưu	Hệ thống kiểm tra trùng lặp và tính hợp lệ.
4	Dữ liệu hợp lệ	Hệ thống lưu vào Database.
5	Dữ liệu không hợp lệ	Hiển thị thông báo lỗi.
3. Yêu cầu dữ liệu (Data Requirements)
3.1. Dữ liệu đầu vào (Input Fields)
CategoryName: string, bắt buộc.
Description: string, tùy chọn.
Status: boolean, trạng thái hiển thị.
3.2. Dữ liệu lưu trữ (Database - Bảng categories)
id: khóa chính.
name: tên danh mục, unique.
description: mô tả.
status: trạng thái hoạt động.
created_at: thời gian tạo.
4. Ràng buộc kỹ thuật & Bảo mật (Technical Constraints)
Chỉ Admin mới có quyền thao tác.
Không cho phép tạo danh mục trùng tên.
Khi xóa danh mục đang có truyện liên kết, hệ thống phải kiểm tra ràng buộc dữ liệu.
5. Trường hợp ngoại lệ & Xử lý lỗi (Edge Cases)
Trường hợp: Tên danh mục bị để trống.
Xử lý: Hiển thị lỗi "Tên danh mục không được để trống".
Trường hợp: Danh mục đã tồn tại.
Xử lý: Hiển thị lỗi "Danh mục đã tồn tại".
Trường hợp: Danh mục đang chứa truyện.
Xử lý: Không cho phép xóa hoặc yêu cầu chuyển dữ liệu trước khi xóa.
6. Giao diện (UI/UX)
Bảng danh mục hiển thị ngắn gọn, dễ nhìn.
Có nút Thêm, Sửa, Xóa.
Có hộp thoại xác nhận trước khi xóa.