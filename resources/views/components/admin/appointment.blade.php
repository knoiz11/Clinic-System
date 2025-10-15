<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" 
     data-layout="vertical" 
     data-navbarbg="skin6" 
     data-sidebartype="full"
     data-sidebar-position="fixed" 
     data-header-position="fixed">

    <!-- Sidebar -->
    @include('components.admin.sidebar')

    <!--  Main wrapper -->
    <div class="body-wrapper">

        <!--  Header -->
        @include('components.admin.header')

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">

                    <!-- Appointment Card -->
                    <div class="card shadow rounded-4 p-4 text-center mb-4" style="background:#f7fdf7;">

                        <!-- Header -->
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-clock-history fs-2 me-2"></i>
                            <h4 class="mb-0 fw-bold">Book an Appointment</h4>
                        </div>

                        <!-- Success message -->
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- Error messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger text-start">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Appointment Form -->
                        <form action="{{ route('appointment.store') }}" method="POST">
                            @csrf

                            <!-- Date & Time Pickers -->
                            <div class="p-3 mb-3 rounded" style="background:#d7f7d7;">
                                <div class="mb-3 text-start">
                                    <label for="date" class="form-label fw-bold">
                                        <i class="bi bi-calendar-date me-2"></i>Date
                                    </label>
                                    <input type="date" name="date" id="date" class="form-control" required>
                                </div>

                                <div class="mb-3 text-start">
                                    <label for="time" class="form-label fw-bold">
                                        <i class="bi bi-clock me-2"></i>Time
                                    </label>
                                    <input type="time" name="time" id="time" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3 text-start">
                                <label for="employee_id" class="form-label fw-bold">
                                    <i class="bi bi-person-fill me-2"></i>Employee
                                </label>
                                <select name="employee_id" id="employee_id" class="form-control" required>
                                    <option value="">Select Employee</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason for Visit</label>
                                <textarea name="reason" id="reason" class="form-control" rows="3" placeholder="Enter the reason for visit..."></textarea>
                            </div>



                            <!-- Book button -->
                            <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                                Book
                            </button>
                        </form>
                    </div>

                    <!-- Appointment List -->
                    <div class="card shadow rounded-4 p-4 text-center" style="background:#f9fafc;">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-list-task fs-2 me-2"></i>
                            <h4 class="mb-0 fw-bold">List of Appointments</h4>
                        </div>

                        @if($appointments->isEmpty())
                            <p class="text-muted mb-0">No appointments yet.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Employee</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                            <tr>
                                                <td>{{ $appointment->date }}</td>
                                                <td>{{ $appointment->time }}</td>
                                                <td>{{ $appointment->employee->name ?? 'N/A' }}</td>

                                                <td>
                                                    <form action="{{ route('appointment.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('components.admin.footer')

    </div>
</div>
