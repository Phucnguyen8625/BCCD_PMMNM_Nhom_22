# Software Requirement Specification (SRS)

Chức năng: Giỏ hàng

Mã chức năng: USER-CART-10
Trạng thái: Draft / Review
Người soạn thảo: Nhóm 2 / Nguyễn Dương Thế Bảo, Nguyễn Huy Phúc, Nguyễn Duy Khánh
Vai trò: Developer / Analyst

1. Mô tả tổng quan (Description)

Cho phép người dùng thêm truyện vào giỏ hàng, cập nhật số lượng, xóa sản phẩm khỏi giỏ và xem tổng tiền trước khi thanh toán.

2. Luồng nghiệp vụ (User Workflow)
Bước	Hành động người dùng	Phản hồi hệ thống
1	User chọn truyện và nhấn "Thêm vào giỏ"	Hệ thống thêm sản phẩm vào giỏ hàng.
2	User mở trang giỏ hàng	Hiển thị danh sách sản phẩm đã chọn.
3	User cập nhật số lượng hoặc xóa sản phẩm	Hệ thống cập nhật lại tổng tiền.
4	User chọn thanh toán	Chuyển sang trang thanh toán.
3. Yêu cầu dữ liệu (Data Requirements)
3.1. Dữ liệu đầu vào
ComicID: int, bắt buộc.
Quantity: int, bắt buộc.
3.2. Dữ liệu lưu trữ
Giỏ hàng lưu theo session hoặc theo tài khoản đăng nhập.
Dữ liệu gồm mã sản phẩm, tên, giá, số lượng, thành tiền.
4. Ràng buộc kỹ thuật & Bảo mật (Technical Constraints)
Không cho phép số lượng nhỏ hơn 1.
Không cho phép vượt quá tồn kho.
Dữ liệu giỏ hàng phải đồng bộ chính xác.
5. Trường hợp ngoại lệ & Xử lý lỗi (Edge Cases)
Trường hợp: Sản phẩm hết hàng.
Xử lý: Không cho thêm vào giỏ.
Trường hợp: User nhập số lượng lớn hơn tồn kho.
Xử lý: Báo lỗi và yêu cầu nhập lại.
Trường hợp: Giỏ hàng trống.
Xử lý: Hiển thị thông báo phù hợp.
6. Giao diện (UI/UX)
Giao diện giỏ hàng rõ ràng.
Có nút tăng/giảm số lượng.
Tổng tiền được cập nhật ngay sau thao tác.