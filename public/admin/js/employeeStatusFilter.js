document.addEventListener('DOMContentLoaded', function () {
    const statusFilter = document.getElementById('statusFilter');
    const searchInput = document.getElementById('employeeTableSearch');
    const rows = document.querySelectorAll('.employee-row');

    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();

        const selectedStatus = statusFilter.value
            .toLowerCase()
            .replace(/\s+/g, '');

        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();

            const rowStatus = (row.dataset.status || '')
                .toLowerCase()
                .replace(/\s+/g, '');

            const matchesStatus =
                selectedStatus === '' || rowStatus === selectedStatus;

            const matchesSearch =
                rowText.includes(searchValue);

            row.style.display =
                (matchesStatus && matchesSearch) ? '' : 'none';

            // Keep accordion rows in sync
            const nextRow = row.nextElementSibling;
            if (nextRow && nextRow.classList.contains('hiddenRow')) {
                nextRow.style.display = row.style.display;
            }
        });
    }

    statusFilter.addEventListener('change', filterTable);
    searchInput.addEventListener('keyup', filterTable);
});
