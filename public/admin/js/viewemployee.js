  // Click to view employee details
  document.querySelectorAll('.employee-row').forEach(row => {
    row.addEventListener('click', function() {
      document.getElementById('empName').textContent = this.dataset.name;
      document.getElementById('empDept').textContent = this.dataset.department;
      document.getElementById('empAge').textContent = this.dataset.age;
      document.getElementById('empGender').textContent = this.dataset.gender;
      document.getElementById('empHistory').textContent = this.dataset.history;
      document.getElementById('empContact').textContent = this.dataset.contact;
      document.getElementById('empEmail').textContent = this.dataset.email;
    });
  });

    // Click to view employee details + highlight row
  document.querySelectorAll('.employee-row').forEach(row => {
    row.addEventListener('click', function() {
      // Remove highlight from all rows
      document.querySelectorAll('.employee-row').forEach(r => r.classList.remove('selected'));
      
      // Highlight clicked row
      this.classList.add('selected');

      // Fill details panel
      document.getElementById('empName').textContent = this.dataset.name;
      document.getElementById('empDept').textContent = this.dataset.department;
      document.getElementById('empAge').textContent = this.dataset.age;
      document.getElementById('empGender').textContent = this.dataset.gender;
      document.getElementById('empHistory').textContent = this.dataset.history;
      document.getElementById('empContact').textContent = this.dataset.contact;
      document.getElementById('empEmail').textContent = this.dataset.email;
    });
  });