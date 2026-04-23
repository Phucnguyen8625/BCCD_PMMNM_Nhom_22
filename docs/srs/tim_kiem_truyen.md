# Software Requirement Specification (SRS)

Chức năng: Tìm kiếm truyện

Mã chức năng: USER-SEARCH-09
Trạng thái: Draft / Review
Người soạn thảo: Nhóm 2 / Nguyễn Dương Thế Bảo, Nguyễn Huy Phúc, Nguyễn Duy Khánh
Vai trò: Developer / Analyst

1. Mô tả tổng quan (Description)

Cho phép người dùng tìm kiếm truyện theo tên truyện, tác giả, thể loại hoặc từ khóa liên quan để nhanh chóng tiếp cận nội dung mong muốn.

2. Luồng nghiệp vụ (User Workflow)
Bước	Hành động người dùng	Phản hồi hệ thống
1	User nhập từ khóa vào ô tìm kiếm	Hệ thống nhận dữ liệu tìm kiếm.
2	User nhấn nút tìm kiếm	Hệ thống truy vấn dữ liệu.
3	Có kết quả phù hợp	Hiển thị danh sách truyện tương ứng.
4	Không có kết quả	Hiển thị thông báo không tìm thấy.
3. Yêu cầu dữ liệu (Data Requirements)
3.1. Dữ liệu đầu vào (Input Fields)
Keyword: string, bắt buộc.
Category: string/int, tùy chọn.
Author: string, tùy chọn.
3.2. Dữ liệu truy xuất
Dữ liệu từ bảng comics, categories, authors nếu có.
4. Ràng buộc kỹ thuật & Bảo mật (Technical Constraints)
Tìm kiếm phải trả kết quả nhanh.
Cần chống lỗi nhập liệu bất thường.
Hỗ trợ tìm kiếm gần đúng nếu có.
5. Trường hợp ngoại lệ & Xử lý lỗi (Edge Cases)
Trường hợp: Người dùng để trống từ khóa.
Xử lý: Hiển thị gợi ý nhập từ khóa.
Trường hợp: Không có kết quả.
Xử lý: Thông báo không tìm thấy truyện phù hợp.
6. Giao diện (UI/UX)
Ô tìm kiếm dễ nhìn, dễ dùng.
Kết quả tìm kiếm hiển thị dạng danh sách hoặc lưới.
Có bộ lọc thể loại nếu cần.