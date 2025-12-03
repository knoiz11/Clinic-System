// Employee Table Search Functionality
// Save this as: public/admin/js/employeeTableSearch.js

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('employeeTableSearch');
    
    if (!searchInput) {
        console.warn('Search input not found');
        return;
    }

    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase().trim();
        const tableRows = document.querySelectorAll('.employee-row');
        
        tableRows.forEach(row => {
            // Get the next row (collapse row)
            const collapseRow = row.nextElementSibling;
            
            // Get all text content from the row
            const lastName = row.cells[1]?.textContent.toLowerCase() || '';
            const firstName = row.cells[2]?.textContent.toLowerCase() || '';
            const middleName = row.cells[3]?.textContent.toLowerCase() || '';
            const sex = row.cells[4]?.textContent.toLowerCase() || '';
            const birthdate = row.cells[5]?.textContent.toLowerCase() || '';
            const age = row.cells[6]?.textContent.toLowerCase() || '';
            const civilStatus = row.cells[7]?.textContent.toLowerCase() || '';
            const religion = row.cells[8]?.textContent.toLowerCase() || '';
            const bloodType = row.cells[9]?.textContent.toLowerCase() || '';
            const employeeId = row.cells[10]?.textContent.toLowerCase() || '';
            const philhealth = row.cells[11]?.textContent.toLowerCase() || '';
            const status = row.cells[12]?.textContent.toLowerCase() || '';
            const designation = row.cells[13]?.textContent.toLowerCase() || '';
            const division = row.cells[14]?.textContent.toLowerCase() || '';
            const department = row.cells[15]?.textContent.toLowerCase() || '';
            
            // Combine all searchable fields
            const fullName = `${firstName} ${middleName} ${lastName}`.trim();
            const searchableText = `${fullName} ${lastName} ${firstName} ${middleName} ${sex} ${birthdate} ${age} ${civilStatus} ${religion} ${bloodType} ${employeeId} ${philhealth} ${status} ${designation} ${division} ${department}`;
            
            // Check if search term matches
            const matches = searchableText.includes(searchTerm);
            
            // Show or hide the row
            if (matches) {
                row.style.display = '';
                if (collapseRow) collapseRow.style.display = '';
            } else {
                row.style.display = 'none';
                if (collapseRow) collapseRow.style.display = 'none';
                // Also collapse any open accordion
                const collapseElement = collapseRow?.querySelector('.collapse');
                if (collapseElement && collapseElement.classList.contains('show')) {
                    collapseElement.classList.remove('show');
                }
            }
        });
        
        // Show "no results" message if no rows are visible
        updateNoResultsMessage(searchTerm);
    });
});

function updateNoResultsMessage(searchTerm) {
    const tableBody = document.querySelector('.table tbody');
    const visibleRows = document.querySelectorAll('.employee-row[style=""], .employee-row:not([style*="display: none"])');
    
    // Remove existing "no results" row
    const existingNoResults = document.getElementById('noResultsRow');
    if (existingNoResults) {
        existingNoResults.remove();
    }
    
    // If no visible rows and there's a search term, show "no results"
    if (visibleRows.length === 0 && searchTerm) {
        const noResultsRow = document.createElement('tr');
        noResultsRow.id = 'noResultsRow';
        noResultsRow.innerHTML = `
            <td colspan="16" class="text-center text-muted py-4">
                <i class="bi bi-search"></i> No employees found matching "${searchTerm}"
            </td>
        `;
        tableBody.appendChild(noResultsRow);
    }
}