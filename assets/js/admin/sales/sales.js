document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('salesSearch');
    const tableBody = document.getElementById('salesTableBody');
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
            const idCell = row.querySelector('.sales-id');
            const customerCell = row.querySelector('.sales-customer');
            const productCell = row.querySelector('.sales-product');

            const idText = idCell ? normalizeText(idCell.textContent) : '';
            const customerText = customerCell ? normalizeText(customerCell.textContent) : '';
            const productText = productCell ? normalizeText(productCell.textContent) : '';

            const isMatched =
                keyword === '' ||
                idText.includes(keyword) ||
                customerText.includes(keyword) ||
                productText.includes(keyword);

            row.style.display = isMatched ? '' : 'none';

            if (isMatched) {
                visibleCount++;
            }
        });

        emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    searchInput.addEventListener('input', filterRows);
});