document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('libraryFilterForm');
    var keywordInput = form ? form.querySelector('input[name="q"]') : null;
    var genreSelect = form ? form.querySelector('select[name="genre"]') : null;
    var authorInput = form ? form.querySelector('input[name="author"]') : null;
    var sortSelect = form ? form.querySelector('select[name="sort"]') : null;

    function autoSubmit() {
        if (form) {
            form.submit();
        }
    }

    if (genreSelect) {
        genreSelect.addEventListener('change', autoSubmit);
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', autoSubmit);
    }

    if (keywordInput) {
        keywordInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                form.submit();
            }
        });
    }

    if (authorInput) {
        authorInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                form.submit();
            }
        });
    }

    var searchInput = document.getElementById('librarySearchInput');
    var filterButtons = document.querySelectorAll('.library-chip');
    var items = document.querySelectorAll('.library-filter-item');
    var emptyState = document.getElementById('libraryEmptyState');

    if (!searchInput && filterButtons.length === 0 && items.length === 0) {
        return;
    }

    var currentFilter = 'tat-ca';

    function normalizeText(text) {
        return (text || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim();
    }

    function applyLibraryFilter() {
        var keyword = normalizeText(searchInput ? searchInput.value : '');
        var visibleCount = 0;

        items.forEach(function (item) {
            var category = item.dataset.category || '';
            var title = normalizeText(item.dataset.title || '');
            var genre = normalizeText(item.dataset.genre || '');
            var status = normalizeText(item.dataset.status || '');

            var matchCategory = currentFilter === 'tat-ca' || category === currentFilter;
            var matchKeyword =
                keyword === '' ||
                title.includes(keyword) ||
                genre.includes(keyword) ||
                status.includes(keyword);

            if (matchCategory && matchKeyword) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    filterButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            filterButtons.forEach(function (btn) {
                btn.classList.remove('active');
            });

            button.classList.add('active');
            currentFilter = button.dataset.filter || 'tat-ca';
            applyLibraryFilter();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', applyLibraryFilter);

        searchInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                applyLibraryFilter();
            }
        });
    }

    applyLibraryFilter();
});