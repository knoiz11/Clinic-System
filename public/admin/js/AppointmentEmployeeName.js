function initEmployeeSearch() {
    const employeesDataElement = document.getElementById('employeesData');
    if (!employeesDataElement) {
        console.error('employeesData element not found');
        return;
    }

    let employees;
    try {
        employees = JSON.parse(employeesDataElement.textContent);
    } catch (e) {
        console.error('Failed to parse employees JSON:', e);
        return;
    }

    const searchInput = document.getElementById('employee_search');
    const resultsDiv = document.getElementById('employee_results');
    const hiddenInput = document.getElementById('employee_id');

    if (!searchInput || !resultsDiv || !hiddenInput) {
        console.error('Missing required elements');
        return;
    }

    // Use event delegation instead of inline onclick
    function selectEmployee(id, name) {
        searchInput.value = name;
        hiddenInput.value = id;
        resultsDiv.style.display = 'none';
    }

    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        
        if (!query) {
            resultsDiv.style.display = 'none';
            hiddenInput.value = ''; // Clear hidden input
            return;
        }

        const filtered = employees.filter(emp =>
            emp.name && emp.name.toLowerCase().includes(query)
        );

        if (filtered.length) {
            let html = '<div class="list-group list-group-flush">';
            filtered.forEach(emp => {
                html += `
                    <button type="button" 
                            class="list-group-item list-group-item-action employee-option" 
                            data-id="${emp.id}" 
                            data-name="${emp.name.replace(/"/g, '&quot;')}">
                        ${emp.name}
                    </button>`;
            });
            html += '</div>';
            resultsDiv.innerHTML = html;
            resultsDiv.style.display = 'block';

            // Event delegation for clicks
            resultsDiv.querySelectorAll('.employee-option').forEach(btn => {
                btn.addEventListener('click', function() {
                    selectEmployee(this.dataset.id, this.dataset.name);
                });
            });

        } else {
            resultsDiv.innerHTML = '<div class="p-3 text-muted">No employees found</div>';
            resultsDiv.style.display = 'block';
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
            resultsDiv.style.display = 'none';
        }
    });

    // Clear selection if input is manually cleared
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' || e.key === 'Delete') {
            hiddenInput.value = '';
        }
    });
}