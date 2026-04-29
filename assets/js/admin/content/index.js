document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('contentSearch');
    const tableBody = document.getElementById('contentTableBody');
    const emptyState = document.getElementById('emptyState');

    if (!searchInput || !tableBody || !emptyState) {
        return;
    }

    const rows = Array.from(tableBody.querySelectorAll('tr'));

    function normalizeText(text) {
        return text
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim();
    }

    function filterRows() {
        const keyword = normalizeText(searchInput.value);
        let visibleCount = 0;

        rows.forEach(function (row) {
            const titleCell = row.querySelector('.content-title');
            const categoryCell = row.querySelector('.content-category');

            const titleText = titleCell ? normalizeText(titleCell.textContent) : '';
            const categoryText = categoryCell ? normalizeText(categoryCell.textContent) : '';

            const isMatched =
                keyword === '' ||
                titleText.includes(keyword) ||
                categoryText.includes(keyword);

            row.style.display = isMatched ? '' : 'none';

            if (isMatched) {
                visibleCount++;
            }
        });

        emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    searchInput.addEventListener('input', filterRows);
});