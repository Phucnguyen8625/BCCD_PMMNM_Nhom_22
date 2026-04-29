document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('togglePasswordForm');
    const passwordPanel = document.getElementById('passwordPanel');
    const toggleIcon = document.getElementById('togglePasswordIcon');

    if (toggleBtn && passwordPanel) {
        if (passwordPanel.classList.contains('open')) {
            toggleBtn.classList.add('active');
            if (toggleIcon) {
                toggleIcon.textContent = 'expand_less';
            }
        }

        toggleBtn.addEventListener('click', function () {
            passwordPanel.classList.toggle('open');
            toggleBtn.classList.toggle('active');

            if (toggleIcon) {
                toggleIcon.textContent = passwordPanel.classList.contains('open')
                    ? 'expand_less'
                    : 'expand_more';
            }
        });
    }
});