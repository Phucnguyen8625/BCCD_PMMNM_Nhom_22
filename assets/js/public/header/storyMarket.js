document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('marketSearchInput');
    const filterButtons = document.querySelectorAll('.market-chip');
    const items = document.querySelectorAll('.market-filter-item');
    const emptyState = document.getElementById('marketEmptyState');

    let currentFilter = 'tat-ca';

    function normalizeText(text) {
        return (text || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim();
    }

    function applyFilter() {
        const keyword = normalizeText(searchInput ? searchInput.value : '');
        let visibleCount = 0;

        items.forEach(function (item) {
            const category = item.dataset.category || '';
            const title = normalizeText(item.dataset.title || '');
            const author = normalizeText(item.dataset.author || '');
            const genre = normalizeText(item.dataset.genre || '');

            const matchCategory = currentFilter === 'tat-ca' || category === currentFilter;
            const matchKeyword =
                keyword === '' ||
                title.includes(keyword) ||
                author.includes(keyword) ||
                genre.includes(keyword);

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
            applyFilter();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', applyFilter);
    }

    applyFilter();
});