# Software Requirement Specification (SRS)

Chức năng: Quản lý truyện tranh

Mã chức năng: ADMIN-BOOK-03
Trạng thái: Draft / Review
Người soạn thảo: Nhóm 2 / Nguyễn Dương Thế Bảo, Nguyễn Huy Phúc, Nguyễn Duy Khánh
Vai trò: Developer / Analyst

1. Mô tả tổng quan (Description)

Cho phép Admin quản lý thông tin truyện tranh trên hệ thống, bao gồm thêm truyện mới, chỉnh sửa, xóa, cập nhật giá bán, số lượng, hình ảnh, tác giả, nhà xuất bản và danh mục truyện.

2. Luồng nghiệp vụ (User Workflow)
Bước	Hành động người dùng	Phản hồi hệ thống
1	Admin truy cập trang /admin/comics	Hiển thị danh sách truyện tranh.
2	Admin chọn thêm mới hoặc chỉnh sửa truyện	Hiển thị form nhập thông tin truyện.
3	Admin nhập đầy đủ thông tin và lưu	Hệ thống kiểm tra dữ liệu hợp lệ.
4	Dữ liệu hợp lệ	Hệ thống lưu vào Database.
5	Dữ liệu lỗi	Hiển thị thông báo lỗi cho Admin.
3. Yêu cầu dữ liệu (Data Requirements)
3.1. Dữ liệu đầu vào (Input Fields)
ComicName: string, bắt buộc.
Author: string, bắt buộc.
CategoryID: int, bắt buộc.
Price: decimal, bắt buộc.
Quantity: int, bắt buộc.
Image: file/string, tùy chọn.
Description: text, tùy chọn.
3.2. Dữ liệu lưu trữ (Database - Bảng comics)
id: khóa chính.
name: tên truyện.
author: tác giả.
category_id: khóa ngoại danh mục.
price: giá bán.
quantity: tồn kho.
image_url: đường dẫn ảnh.
description: mô tả.
created_at: thời gian tạo.
4. Ràng buộc kỹ thuật & Bảo mật (Technical Constraints)
Dữ liệu giá và số lượng phải là số hợp lệ.
Ảnh tải lên phải đúng định dạng cho phép.
Chỉ Admin được phép thêm, sửa, xóa truyện.
5. Trường hợp ngoại lệ & Xử lý lỗi (Edge Cases)
Trường hợp: Thiếu tên truyện hoặc giá bán.
Xử lý: Hiển thị lỗi yêu cầu nhập đầy đủ.
Trường hợp: Giá hoặc số lượng âm.
Xử lý: Từ chối lưu và hiển thị lỗi.
Trường hợp: Upload ảnh sai định dạng.
Xử lý: Báo lỗi và yêu cầu tải lại ảnh hợp lệ.
6. Giao diện (UI/UX)
Form quản lý truyện rõ ràng, hỗ trợ xem trước ảnh.
Danh sách truyện có tìm kiếm, lọc theo danh mục.
Hiển thị phân trang để dễ quản lý.