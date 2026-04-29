document.addEventListener('DOMContentLoaded', function () {
    var notice = document.querySelector('[data-notice]');
    if (notice) {
        setTimeout(function () {
            notice.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
            notice.style.opacity = '0';
            notice.style.transform = 'translateY(-8px)';

            setTimeout(function () {
                if (notice.parentNode) {
                    notice.parentNode.removeChild(notice);
                }
            }, 380);
        }, 2600);
    }

    var removeButtons = document.querySelectorAll('.js-remove-story');
    removeButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            var ok = confirm('Bạn có chắc muốn xóa truyện này khỏi tủ truyện không?');
            if (!ok) {
                event.preventDefault();
            }
        });
    });
});