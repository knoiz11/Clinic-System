@extends('layout.admin')

@section('dashboard')
<div class="container-fluid mt-4">

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h2 class="fw-bold mb-0">{{ $employeeCount }}</h2>
                    <p class="mb-0">CCP Employees</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h2 class="fw-bold mb-0">{{ $recentVisitsCount }}</h2>
                    <p class="mb-0">Recent Visits</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h2 class="fw-bold mb-0">{{ $upcomingAppointmentsCount }}</h2>
                    <p class="mb-0">Upcoming Checkups</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Table -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">Employee Records</h5>
                        <input type="text" id="employeeSearch" class="form-control w-50" placeholder="Search employee...">
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap align-middle mb-0">
                            <thead>
                                <tr class="border-bottom border-primary">
                                    <th class="ps-0">Name</th>
                                    <th>Designation</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($employees as $emp)
                                <tr class="employee-row"
                                    data-name="{{ $emp->name }}"
                                    data-department="{{ $emp->department }}"
                                    data-age="{{ $emp->age ?? 'N/A' }}"
                                    data-sex="{{ $emp->sex ?? 'N/A' }}"
                                    data-contact="{{ $emp->contact ?? 'N/A' }}"
                                    data-email="{{ $emp->email ?? 'N/A' }}">
                                    <td class="ps-0 fw-medium">{{ $emp->name }}</td>
                                    <td>{{ $emp->designation ?? 'N/A' }}</td>
                                    <td class="text-center fw-medium">{{ $emp->department }}</td>
                                    <td class="text-center fw-medium">{{ $emp->status ?? 'Active' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- Employee Details Panel -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Employee Details</h5>
                    <p><strong>Name:</strong> <span id="empName">-</span></p>
                    <p><strong>Department:</strong> <span id="empDept">-</span></p>
                    <p><strong>Age:</strong> <span id="empAge">-</span></p>
                    <p><strong>Sex:</strong> <span id="empSex">-</span></p>
                    <p><strong>Contact No.:</strong> <span id="empContact">-</span></p>
                    <p><strong>Email:</strong> <span id="empEmail">-</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Appointments -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Upcoming Appointments</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap align-middle mb-0">
                            <thead>
                                <tr class="border-bottom border-primary">
                                    <th>Employee</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @forelse ($upcomingAppointments as $appt)
                                <tr>
                                    <td class="fw-medium">{{ $appt->employee ? $appt->employee->name : $appt->employee_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appt->date)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appt->time)->format('h:i A') }}</td>
                                    <td>{{ $appt->reason ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No upcoming appointments.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
// Dashboard employee row click handler
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.employee-row');
    
    rows.forEach(row => {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function() {
            // Remove active class from all rows
            rows.forEach(r => r.classList.remove('table-active'));
            // Add active class to clicked row
            this.classList.add('table-active');
            
            // Get data from row
            const name = this.dataset.name;
            const department = this.dataset.department;
            const age = this.dataset.age;
            const sex = this.dataset.sex;
            const contact = this.dataset.contact;
            const email = this.dataset.email;
            
            // Update details panel
            document.getElementById('empName').textContent = name;
            document.getElementById('empDept').textContent = department;
            document.getElementById('empAge').textContent = age;
            document.getElementById('empSex').textContent = sex;
            document.getElementById('empContact').textContent = contact;
            document.getElementById('empEmail').textContent = email;
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('employeeSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            rows.forEach(row => {
                const name = row.dataset.name.toLowerCase();
                const department = row.dataset.department.toLowerCase();
                
                if (name.includes(searchTerm) || department.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endsection