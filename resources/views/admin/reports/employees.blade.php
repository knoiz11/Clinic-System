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
                <div class="col-md-10 col-lg-9">

                    <!-- Employee Card -->
                    <div class="card shadow rounded-4 p-4 mb-4" style="background:#f7fdf7;">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-people fs-2 me-2"></i>
                            <h4 class="mb-0 fw-bold">Employee Records</h4>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead class="table-success">
                                    <tr>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>John Doe</td>
                                        <td>Software Engineer</td>
                                        <td>IT</td>
                                        <td>Active</td>
                                    </tr>
                                    <tr>
                                        <td>Jane Smith</td>
                                        <td>HR Officer</td>
                                        <td>HR</td>
                                        <td>Active</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('components.admin.footer')

    </div>
</div>
