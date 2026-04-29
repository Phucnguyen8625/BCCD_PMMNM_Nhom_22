document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const form = document.getElementById('settingsForm');
    const siteName = document.getElementById('site_name');
    const adminEmail = document.getElementById('admin_email');
    const themeCards = document.querySelectorAll('.theme-card-option');
    const themeSaveButton = document.getElementById('themeSaveButton');
    const themeResetButton = document.getElementById('themeResetButton');
    const themeSaveState = document.getElementById('themeSaveState');
    const themeCurrentLabel = document.getElementById('themeCurrentLabel');
    const allowedThemes = ['light', 'dark', 'comic'];
    let appliedTheme = body.dataset.theme || 'light';
    let currentTheme = appliedTheme;

    function isValidTheme(themeName) {
        return allowedThemes.includes(themeName);
    }

    function setThemeState(message, type) {
        if (!themeSaveState) {
            return;
        }

        themeSaveState.textContent = message || '';
        themeSaveState.className = 'save-state';

        if (type) {
            themeSaveState.classList.add('save-state--' + type);
        }
    }

    function applyTheme(themeName) {
        const safeTheme = isValidTheme(themeName) ? themeName : 'light';

        body.classList.remove('theme-light', 'theme-dark', 'theme-comic');
        body.classList.add('theme-' + safeTheme);
        body.dataset.theme = safeTheme;
    }

    function updateThemeCards(themeName) {
        themeCards.forEach(function (card) {
            const isActive = card.getAttribute('data-theme') === themeName;
            card.classList.toggle('active', isActive);
        });
    }

    function updateThemeLabel(themeName) {
        if (!themeCurrentLabel) {
            return;
        }

        const activeCard = Array.from(themeCards).find(function (card) {
            return card.getAttribute('data-theme') === themeName;
        });

        themeCurrentLabel.textContent = activeCard
            ? (activeCard.getAttribute('data-theme-label') || 'Che do sang')
            : 'Che do sang';
    }

    function saveTheme(themeName) {
        return fetch('save-theme.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: 'theme=' + encodeURIComponent(themeName)
        }).then(function (response) {
            if (!response.ok) {
                throw new Error('save_failed');
            }

            return response.json();
        }).then(function (payload) {
            if (!payload || payload.success !== true || !isValidTheme(payload.theme)) {
                throw new Error('invalid_payload');
            }

            return payload.theme;
        });
    }

    if (form && siteName && adminEmail) {
        form.addEventListener('submit', function (event) {
            const siteNameValue = siteName.value.trim();
            const adminEmailValue = adminEmail.value.trim();
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (siteNameValue === '') {
                event.preventDefault();
                alert('Vui long nhap ten website.');
                siteName.focus();
                return;
            }

            if (adminEmailValue === '') {
                event.preventDefault();
                alert('Vui long nhap email quan tri.');
                adminEmail.focus();
                return;
            }

            if (!emailPattern.test(adminEmailValue)) {
                event.preventDefault();
                alert('Email quan tri khong hop le.');
                adminEmail.focus();
            }
        });
    }

    if (themeCards.length > 0) {
        applyTheme(appliedTheme);
        updateThemeCards(appliedTheme);
        updateThemeLabel(appliedTheme);

        themeCards.forEach(function (card) {
            card.addEventListener('click', function () {
                const themeName = card.getAttribute('data-theme');

                if (!isValidTheme(themeName)) {
                    return;
                }

                currentTheme = themeName;
                applyTheme(themeName);
                updateThemeCards(themeName);
                updateThemeLabel(themeName);
                setThemeState('');
            });
        });
    }

    if (themeSaveButton) {
        themeSaveButton.addEventListener('click', function () {
            themeSaveButton.disabled = true;
            setThemeState('Dang luu giao dien...', 'pending');

            saveTheme(currentTheme)
                .then(function (themeName) {
                    appliedTheme = themeName;
                    currentTheme = themeName;
                    applyTheme(themeName);
                    updateThemeCards(themeName);
                    updateThemeLabel(themeName);
                    setThemeState('Da luu mau giao dien.', 'success');
                })
                .catch(function () {
                    currentTheme = appliedTheme;
                    applyTheme(appliedTheme);
                    updateThemeCards(appliedTheme);
                    updateThemeLabel(appliedTheme);
                    setThemeState('Khong luu duoc giao dien.', 'error');
                })
                .finally(function () {
                    themeSaveButton.disabled = false;
                });
        });
    }

    if (themeResetButton) {
        themeResetButton.addEventListener('click', function () {
            currentTheme = appliedTheme;
            applyTheme(appliedTheme);
            updateThemeCards(appliedTheme);
            updateThemeLabel(appliedTheme);
            setThemeState('Da hoan tac thay doi.', 'pending');
        });
    }
});