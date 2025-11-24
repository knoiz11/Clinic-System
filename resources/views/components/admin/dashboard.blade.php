  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!-- Sidebar -->
    @include('components.admin.sidebar')
    <!--  Main wrapper -->
    <div class="body-wrapper">
    <!--  Header -->
    @include('components.admin.header')


      
      <div class="container-fluid">
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


<<<<<<< Updated upstream
<div class="row">
  <!-- Employee Table -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title">Employee Records</h5>
          <input type="text" id="employeeSearch" class="form-control w-50" placeholder="Search employee...">
        </div>

        <div class="table-responsive">
          <table class="table text-nowrap align-middle mb-0">
            <thead>
              <tr class="border-2 border-bottom border-primary border-0"> 
                <th scope="col" class="ps-0">Name</th>
                <th scope="col">Designation</th>
                <th scope="col" class="text-center">Department</th>
                <th scope="col" class="text-center">Status</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
            @foreach ($employees as $emp)
              <tr class="employee-row"
                  data-name="{{ $emp->name }}"
                  data-department="{{ $emp->department }}"
                  data-age="{{ $emp->age ?? 'N/A' }}"
                  data-gender="{{ $emp->gender ?? 'N/A' }}"
                  data-history="{{ $emp->medical_history ?? 'N/A' }}"
                  data-contact="{{ $emp->contact ?? 'N/A' }}"
                  data-email="{{ $emp->email ?? 'N/A' }}"
              >
                <td class="ps-0 fw-medium">{{ $emp->name }}</td>
                <td>{{ $emp->designation ?? 'N/A' }}</td>
                <td class="text-center fw-medium">{{ $emp->department }}</td>
                <td class="text-center fw-medium">{{ $emp->status ?? 'Active' }}</td>
              </tr>
            @endforeach
            </tbody>

          </table>
=======
                    <div class="table-responsive">
                        <table class="table text-nowrap align-middle mb-0 py-2">
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
                                    data-gender="{{ $emp->gender ?? 'N/A' }}"
                                    data-history="{{ $emp->medical_history ?? 'N/A' }}"
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
                    <div class="py-1">
                    <p><strong>Name:</strong> <span id="empName">N/A</span></p>
                    <p><strong>Department:</strong> <span id="empDept">N/A</span></p>
                    <p><strong>Age:</strong> <span id="empAge">N/A</span></p>
                    <p><strong>Gender:</strong> <span id="empGender">N/A</span></p>
                    <p><strong>Medical History:</strong> <span id="empHistory">N/A</span></p>
                    <p><strong>Contact No.:</strong> <span id="empContact">N/A</span></p>
                    <p><strong>Email:</strong> <span id="empEmail">N/A</span></p>
                    </div>
                </div>
            </div>
>>>>>>> Stashed changes
        </div>

      </div>
    </div>
  </div>

<<<<<<< Updated upstream
  <!-- Employee Details Panel -->
  <div class="col-lg-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Employee Details</h5>
        <p><strong>Name:</strong> <span id="empName">-</span></p>
        <p><strong>Department:</strong> <span id="empDept">-</span></p>
        <p><strong>Age:</strong> <span id="empAge">-</span></p>
        <p><strong>Gender:</strong> <span id="empGender">-</span></p>
        <p><strong>Medical History:</strong> <span id="empHistory">-</span></p>
        <p><strong>Contact No.:</strong> <span id="empContact">-</span></p>
        <p><strong>Email:</strong> <span id="empEmail">-</span></p>
      </div>
=======
    <!-- Upcoming Appointments -->
    <div class="row mt-4">
        <div class="col-lg-12 mx-auto">
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
>>>>>>> Stashed changes
    </div>
  </div>
</div>

<!-- Upcoming Appointments -->
<div class="col-lg-8 mt-4">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title mb-3">Upcoming Appointments</h5>

      <div class="table-responsive">
        <table class="table text-nowrap align-middle mb-0">
          <thead>
            <tr class="border-2 border-bottom border-primary border-0">
              <th>Employee</th>
              <th>Date</th>
              <th>Time</th>
              <th>Reason</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            @forelse ($upcomingAppointments as $appt)
              <tr>
                <td class="fw-medium">
                    {{ $appt->employee ? $appt->employee->name : $appt->employee_name }}
                </td>
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


      <!-- Footer -->
      @include('components.admin.footer')
        </div>
      </div>
    </div>
  </div>


