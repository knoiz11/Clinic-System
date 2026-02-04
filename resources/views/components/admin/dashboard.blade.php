@extends('layout.admin')

@section('dashboard')
<div class="container-fluid mt-4">

    <div class="row mb-4">
    <div class="col-md-3 d-flex">
        <div class="card shadow-sm text-center w-100">
            <div class="card-body">
                <br>
                <h2 class="fw-bold mb-0">{{ $employeeCount }}</h2>
                <p class="mb-0">CCP Employees</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 d-flex">
        <div class="card shadow-sm text-center w-100">
            <div class="card-body">
                <br>
                <h2 class="fw-bold mb-0">{{ $recentVisitsCount }}</h2>
                <p class="mb-0">Recent Visits</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 d-flex">
        <div class="card shadow-sm text-center w-100">
            <div class="card-body">
                <br>
                <h2 class="fw-bold mb-0">{{ $upcomingAppointmentsCount }}</h2>
                <p class="mb-0">Upcoming Checkups</p>
            </div>
        </div>
    </div>

        <!-- Doctor Status Card -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center" style="cursor: pointer; transition: transform 0.1s;" id="doctorStatusCard">
                <div class="card-body">
                    <h5 class="mb-3">Doctor Status</h5>
                    <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                        <i class="bi bi-circle-fill" id="statusIndicator" 
                           style="font-size: 24px; color: {{ $doctorStatus->is_in ? '#28a745' : '#dc3545' }}"></i>
                        <h3 class="mb-0" id="statusText">{{ $doctorStatus->is_in ? 'IN' : 'OUT' }}</h3>
                    </div>
                    <small class="text-muted">Click to toggle</small>
                    <input type="hidden" id="currentStatus" value="{{ $doctorStatus->is_in ? '1' : '0' }}">
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
                        <h5 class="card-title mb-0">Employee Records</h5>
                        <br>
                        <div class="d-flex gap-2 align-items-center">
                            <input type="text" id="employeeSearch" class="form-control bg-white" style="max-width: 250px;" placeholder="Search employee...">
                            <a href="{{ route('employee.index') }}" class="btn btn-primary btn-sm text-nowrap p-2" style="width: 200px;">
                                See More
                            </a>
                        </div>
                    </div>
                    

                    <div class="table-responsive">
                        <table class="table text-nowrap align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Designation</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($employees as $emp)
                                <tr class="employee-row"
                                    data-name="{{ $emp->name }}"
                                    data-department="{{ $emp->department ?? 'N/A' }}"
                                    data-age="{{ $emp->age ?? 'N/A' }}"
                                    data-sex="{{ $emp->sex ?? 'N/A' }}"
                                    data-contact="{{ $emp->contact ?? 'N/A' }}"
                                    data-email="{{ $emp->email ?? 'N/A' }}"
                                    data-photo="{{ $emp->photo ? asset('storage/' . $emp->photo) : '' }}">
                                    <td class="text-center">{{ $emp->name }}</td>
                                    <td class="text-center">{{ $emp->designation ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $emp->department ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $emp->status ?? 'Active' }}</td>
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
                    <h5 class="card-title mb-3">Employee Details</h5>
                    <br>
                    <!-- Photo Section -->
                    <div class="text-center mb-4">
                        <div class="border bg-light rounded-3 p-3 d-inline-block" style="min-width: 150px; min-height: 150px;">
                            <img id="empPhoto" 
                            @if (Auth::user()->photo)
                            data-src="{{ asset('storage/' . Auth::user()->photo)}}"
                            @else
                               src="{{ asset('admin/images/profile/user.jpg') }}" 
                            @endif
                                 alt="Employee Photo" 
                                 class="rounded-3"
                                 style="width: 140px; height: 140px; object-fit: cover; display: block;">
                        </div>
                    </div>

                    <!-- Details -->
                    <p><strong>Name:</strong> <span id="empName">{{ Auth::user()->name }}</span></p>
                    <p><strong>Department:</strong> <span id="empDept">{{ Auth::user()->department }}</span></p>
                    <p><strong>Age:</strong> <span id="empAge">{{ Auth::user()->age }}</span></p>
                    <p><strong>Sex:</strong> <span id="empSex">{{ Auth::user()->sex }}</span></p>
                    <p><strong>Contact No.:</strong> <span id="empContact">{{ Auth::user()->contact }}</span></p>
                    <p><strong>Email:</strong> <span id="empEmail">{{ Auth::user()->email }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Appointments -->
    <div class="row mt-4">
        <div class="flex justify-content-between align-items-center mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Upcoming Appointments</h5>
                    <br>
                    <div class="table-responsive">
                        <table class="table text-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="border-bottom border-primary">
                                    <th class="text-center">Employee</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Time</th>
                                    <th class="text-center">Reason</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @forelse ($upcomingAppointments as $appt)
                                <tr>
                                    <td class="text-center">{{ $appt->employee ? $appt->employee->name : $appt->employee_name }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($appt->date)->format('M d, Y') }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($appt->time)->format('h:i A') }}</td>
                                    <td class="text-center">{{ $appt->reason ?? '-' }}</td>
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

<!-- JavaScript for Doctor Status Toggle & Employee Details -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Doctor Status Toggle
    const statusCard = document.getElementById('doctorStatusCard');
    const statusIndicator = document.getElementById('statusIndicator');
    const statusText = document.getElementById('statusText');
    const currentStatusInput = document.getElementById('currentStatus');
    
    statusCard?.addEventListener('click', async function() {
        try {
            const response = await fetch('{{ route("doctor.status.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                const isIn = data.is_in;
                statusText.textContent = isIn ? 'IN' : 'OUT';
                statusIndicator.style.color = isIn ? '#28a745' : '#dc3545';
                currentStatusInput.value = isIn ? '1' : '0';
                
                // Add animation
                statusCard.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    statusCard.style.transform = 'scale(1)';
                }, 100);
            }
        } catch (error) {
            console.error('Error toggling doctor status:', error);
            alert('Failed to update doctor status');
        }
    });

    // Employee row click handler
    const rows = document.querySelectorAll('.employee-row');
    const empPhoto = document.getElementById('empPhoto');
    const empPhotoIcon = document.getElementById('empPhotoIcon');
    
    rows.forEach(row => {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function() {
            rows.forEach(r => r.classList.remove('table-active'));
            this.classList.add('table-active');
            
            const name = this.dataset.name;
            const department = this.dataset.department;
            const age = this.dataset.age;
            const sex = this.dataset.sex;
            const contact = this.dataset.contact;
            const email = this.dataset.email;
            const photo = this.dataset.photo;
            
            document.getElementById('empName').textContent = name;
            document.getElementById('empDept').textContent = department;
            document.getElementById('empAge').textContent = age;
            document.getElementById('empSex').textContent = sex;
            document.getElementById('empContact').textContent = contact;
            document.getElementById('empEmail').textContent = email;
            
            if (photo) {
                empPhoto.src = photo;
                empPhoto.style.display = 'block';
                empPhotoIcon.style.display = 'none';
            } else {
                empPhoto.style.display = 'none';
                empPhotoIcon.style.display = 'inline';
            }
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