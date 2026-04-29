document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const themeCards = document.querySelectorAll('.theme-card');
    const saveButton = document.querySelector('.save-btn');
    const discardButton = document.querySelector('.discard-btn');
    const saveState = document.getElementById('themeSaveState');
    const allowedThemes = ['light', 'dark', 'comic'];

    if (!body || themeCards.length === 0) {
        return;
    }

    let appliedTheme = body.dataset.theme || getThemeFromBody() || 'light';
    let currentTheme = appliedTheme;

    function getThemeFromBody() {
        const className = Array.from(body.classList).find(function (item) {
            return item.indexOf('theme-') === 0;
        });

        return className ? className.replace('theme-', '') : '';
    }

    function isValidTheme(themeName) {
        return allowedThemes.includes(themeName);
    }

    function setSaveState(message, type) {
        if (!saveState) {
            return;
        }

        saveState.textContent = message || '';
        saveState.className = 'save-state';

        if (type) {
            saveState.classList.add('save-state--' + type);
        }
    }

    function applyTheme(themeName) {
        const safeTheme = isValidTheme(themeName) ? themeName : 'light';

        body.classList.remove('theme-light', 'theme-dark', 'theme-comic');
        body.classList.add('theme-' + safeTheme);
        body.dataset.theme = safeTheme;
    }

    function updateActiveCard(themeName) {
        themeCards.forEach(function (card) {
            const cardTheme = card.getAttribute('data-theme');
            const isActive = cardTheme === themeName;

            card.classList.toggle('active', isActive);

            const oldCheck = card.querySelector('.theme-check');
            if (oldCheck) {
                oldCheck.remove();
            }

            if (isActive) {
                const check = document.createElement('div');
                check.className = 'theme-check';
                check.innerHTML = '<span class="material-symbols-outlined">check</span>';
                card.appendChild(check);
            }
        });
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

    applyTheme(appliedTheme);
    updateActiveCard(appliedTheme);

    themeCards.forEach(function (card) {
        card.addEventListener('click', function () {
            const themeName = card.getAttribute('data-theme');

            if (!isValidTheme(themeName)) {
                return;
            }

            currentTheme = themeName;
            applyTheme(themeName);
            updateActiveCard(themeName);
            setSaveState('');
        });
    });

    if (saveButton) {
        saveButton.addEventListener('click', function () {
            saveButton.disabled = true;
            setSaveState('Dang luu giao dien...', 'pending');

            saveTheme(currentTheme)
                .then(function (themeName) {
                    appliedTheme = themeName;
                    currentTheme = themeName;
                    applyTheme(themeName);
                    updateActiveCard(themeName);
                    setSaveState('Da luu giao dien.', 'success');
                })
                .catch(function () {
                    currentTheme = appliedTheme;
                    applyTheme(appliedTheme);
                    updateActiveCard(appliedTheme);
                    setSaveState('Khong luu duoc giao dien.', 'error');
                })
                .finally(function () {
                    saveButton.disabled = false;
                });
        });
    }

    if (discardButton) {
        discardButton.addEventListener('click', function () {
            currentTheme = appliedTheme;
            applyTheme(appliedTheme);
            updateActiveCard(appliedTheme);
            setSaveState('Da hoan tac thay doi.', 'pending');
        });
    }
});