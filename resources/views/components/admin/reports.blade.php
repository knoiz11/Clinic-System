<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!-- Sidebar -->
    @include('components.admin.sidebar')

    <!--  Main wrapper -->
    <div class="body-wrapper">

        <!--  Header -->
        @include('components.admin.header')

        <!-- Report Page Content -->
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-body">

                            <h5 class="card-title fw-bold mb-3">Employee Reports</h5>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Employee ID</th>
                                            <th scope="col" class="text-center">Visits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-medium">John Doe</td>
                                            <td>EMP001</td>
                                            <td class="text-center">12</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">Jane Smith</td>
                                            <td>EMP002</td>
                                            <td class="text-center">8</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">Robert Brown</td>
                                            <td>EMP003</td>
                                            <td class="text-center">15</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">Emily Johnson</td>
                                            <td>EMP004</td>
                                            <td class="text-center">9</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('components.admin.footer')

    </div>
</div>
