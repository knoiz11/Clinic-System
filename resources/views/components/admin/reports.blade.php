<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    @include('components.admin.sidebar')

    <div class="body-wrapper">

        @include('components.admin.header')

        <div class="container-fluid mt-4">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">
                            <h4 class="fw-bold mb-4 text-center">Reports Dashboard</h4>

                            <!-- Tabs -->
                            <ul class="nav nav-tabs mb-4" id="reportTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#employee-reports" type="button">Employees</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#illness-reports" type="button">Common Illnesses</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#visit-reports" type="button">Visits</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="reportTabsContent">

                                <!-- Employee Reports -->
                                <div class="tab-pane fade show active" id="employee-reports">
                                    <h5 class="fw-bold mb-3">Employee Reports</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Employee ID</th>
                                                    <th class="text-center">Visits</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($employees as $employee)
                                                    <tr>
                                                        <td class="fw-medium">{{ $employee->name }}</td>
                                                        <td>{{ $employee->id }}</td>
                                                        <td class="text-center">{{ $employee->appointments_count }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted">No employees found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Common Illnesses Report (Placeholder) -->
                                <div class="tab-pane fade" id="illness-reports">
                                    <h5 class="fw-bold mb-3">Common Illnesses Report</h5>
                                    <p class="text-muted">No illness data available yet.</p>
                                </div>

                                <!-- Visit Reports -->
                                <div class="tab-pane fade" id="visit-reports">
                                    <h5 class="fw-bold mb-3">Visit Reports</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Employee</th>
                                                    <th>Reason for Visit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($visits as $visit)
                                                    <tr>
                                                        <td>{{ $visit->date }}</td>
                                                        <td>{{ $visit->time }}</td>
                                                        <td>{{ $visit->employee ? $visit->employee->name : 'N/A' }}</td>
                                                        <td>{{ $visit->reason ?? '-' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted">No visits recorded.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                            </div> <!-- end tab-content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('components.admin.footer')
    </div>
</div>
