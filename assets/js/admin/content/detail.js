document.addEventListener('DOMContentLoaded', function () {
    const editButton = document.querySelector('a[href*="edit.php"]');

    if (editButton) {
        editButton.addEventListener('click', function () {
            console.log('Chuyển sang trang chỉnh sửa nội dung...');
        });
    }
});