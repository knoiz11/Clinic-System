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
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">

                    <!-- Appointment Card -->
                    <div class="card shadow rounded-4 p-4 text-center mb-4" style="background:#f7fdf7;">

                        <!-- Header -->
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-clock-history fs-2 me-2"></i>
                            <h4 class="mb-0 fw-bold">New Appointment</h4>
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

                            <!-- Book button -->
                            <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                                Book
                            </button>
                        </form>
                    </div>
                </div>
            </div>


        <!-- Footer -->
        @include('components.admin.footer')

    </div>
</div>
