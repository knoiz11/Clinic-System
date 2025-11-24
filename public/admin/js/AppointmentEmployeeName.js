document.addEventListener('DOMContentLoaded', function() {
    const employeesDataElement = document.getElementById('employeesData');
    
    if (!employeesDataElement) return;
    
    const employees = JSON.parse(employeesDataElement.textContent);
    const searchInput = document.getElementById('employee_search');
    const resultsDiv = document.getElementById('employee_results');
    const hiddenInput = document.getElementById('employee_id');

    if (!searchInput || !resultsDiv || !hiddenInput) return;

    // Make selectEmployee globally accessible
    window.selectEmployee = function(id, name) {
        searchInput.value = name;
        hiddenInput.value = id;
        resultsDiv.style.display = 'none';
    }

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        
        if (query.length < 1) {
            resultsDiv.style.display = 'none';
            return;
        }
        
        const filtered = employees.filter(emp => 
            emp.name.toLowerCase().includes(query)
        );
        
        if (filtered.length > 0) {
            let html = '<table class="table table-hover mb-0" style="font-size: 0.9rem;"><tbody>';
            
            filtered.forEach(emp => {
                const safeName = emp.name.replace(/'/g, "\\'");
                html += `<tr style="cursor: pointer;" onclick="selectEmployee(${emp.id}, '${safeName}')">
                            <td>${emp.name}</td>
                        </tr>`;
            });
            
            html += '</tbody></table>';
            resultsDiv.innerHTML = html;
            resultsDiv.style.display = 'block';
        } else {
            resultsDiv.innerHTML = '<div class="p-3 text-muted">No employees found</div>';
            resultsDiv.style.display = 'block';
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
            resultsDiv.style.display = 'none';
        }
    });
});