document.getElementById('employeeSearch').addEventListener('keyup', function () {
    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
      let text = row.textContent.toLowerCase();
      if (text.includes(searchValue)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });

    document.getElementById('employeeSearch').addEventListener('keyup', function () {
    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll('.employee-row');

    rows.forEach(row => {
      let text = row.textContent.toLowerCase();
      row.style.display = text.includes(searchValue) ? '' : 'none';
    });
  });