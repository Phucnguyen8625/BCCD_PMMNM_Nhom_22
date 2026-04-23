# Software Requirement Specification (SRS)

Chức năng: Thống kê / Báo cáo

Mã chức năng: ADMIN-REPORT-06
Trạng thái: Draft / Review
Người soạn thảo: Nhóm 2 / Nguyễn Dương Thế Bảo, Nguyễn Huy Phúc, Nguyễn Duy Khánh
Vai trò: Developer / Analyst

1. Mô tả tổng quan (Description)

Chức năng này hỗ trợ Admin xem số liệu thống kê về doanh thu, đơn hàng, số lượng truyện bán ra, truyện bán chạy và người dùng hoạt động trên hệ thống.

2. Luồng nghiệp vụ (User Workflow)
Bước	Hành động người dùng	Phản hồi hệ thống
1	Admin truy cập trang /admin/reports	Hiển thị giao diện thống kê tổng quan.
2	Admin chọn khoảng thời gian hoặc loại báo cáo	Hệ thống tải dữ liệu tương ứng.
3	Hệ thống xử lý dữ liệu	Hiển thị biểu đồ và bảng thống kê.
4	Admin xem hoặc xuất báo cáo	Hệ thống hỗ trợ xuất file nếu có.
3. Yêu cầu dữ liệu (Data Requirements)
3.1. Dữ liệu đầu vào (Input Fields)
FromDate: date, bắt buộc.
ToDate: date, bắt buộc.
ReportType: string, loại báo cáo.
3.2. Dữ liệu lưu trữ
Dữ liệu tổng hợp từ bảng orders, order_details, payments, users, comics.
4. Ràng buộc kỹ thuật & Bảo mật (Technical Constraints)
Chỉ Admin được quyền xem báo cáo.
Dữ liệu thống kê phải đúng và nhất quán.
Thời gian tải báo cáo không quá chậm.
5. Trường hợp ngoại lệ & Xử lý lỗi (Edge Cases)
Trường hợp: Khoảng thời gian không hợp lệ.
Xử lý: Báo lỗi yêu cầu chọn lại.
Trường hợp: Không có dữ liệu trong khoảng thời gian đã chọn.
Xử lý: Hiển thị thông báo "Không có dữ liệu".
Trường hợp: Lỗi truy vấn dữ liệu.
Xử lý: Hiển thị thông báo hệ thống.
6. Giao diện (UI/UX)
Có biểu đồ trực quan.
Có bộ lọc thời gian.
Có bảng dữ liệu chi tiết bên dưới.