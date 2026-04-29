document.addEventListener('DOMContentLoaded', function () {
    const switchButtons = document.querySelectorAll('.switch-btn');

    if (!switchButtons.length) {
        return;
    }

    switchButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            switchButtons.forEach(function (item) {
                item.classList.remove('active');
            });

            button.classList.add('active');
        });
    });
});