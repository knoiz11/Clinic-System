  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    @include('components.admin.sidebar')
    <!--  Main wrapper -->
    <div class="body-wrapper">
    <!--  Header -->
    @include('components.admin.header')
  
  
        <!-- Employee Table -->
        <div class="container-fluid">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title fw-bold mb-0">Employee Records</h5>
                        <input type="text" id="employeeSearch" class="form-control w-50" placeholder="Search employee...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col" class="text-center">Department</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Employee Row -->
                                <tr data-bs-toggle="collapse" data-bs-target="#emp1" class="accordion-toggle">
                                    <td class="fw-medium">John Doe</td>
                                    <td>Software Engineer</td>
                                    <td class="text-center">IT</td>
                                    <td class="text-center"><span class="badge bg-success">Active</span></td>
                                    <td class="text-center">
                                        <i class="bi bi-caret-down-fill text-muted"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="hiddenRow">
                                        <div class="accordion-body collapse p-3" id="emp1">
                                            <div class="d-flex gap-3">
                                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                                <a href="#" class="btn btn-sm btn-outline-success">Consultation</a>
                                            </div>  
                                        </div>
                                    </td>
                                </tr>

                                <!-- Employee Row -->
                                <tr data-bs-toggle="collapse" data-bs-target="#emp2" class="accordion-toggle">
                                    <td class="fw-medium">Jane Smith</td>
                                    <td>HR Officer</td>
                                    <td class="text-center">Human Resources</td>
                                    <td class="text-center"><span class="badge bg-success">Active</span></td>
                                    <td class="text-center">
                                        <i class="bi bi-caret-down-fill text-muted"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="hiddenRow">
                                        <div class="accordion-body collapse p-3" id="emp2">
                                            <div class="d-flex gap-3">
                                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                                <a href="#" class="btn btn-sm btn-outline-success">Consultation</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Employee Row -->
                                <tr data-bs-toggle="collapse" data-bs-target="#emp3" class="accordion-toggle">
                                    <td class="fw-medium">Michael Johnson</td>
                                    <td>Accountant</td>
                                    <td class="text-center">Finance</td>
                                    <td class="text-center"><span class="badge bg-warning">On Leave</span></td>
                                    <td class="text-center">
                                        <i class="bi bi-caret-down-fill text-muted"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="hiddenRow">
                                        <div class="accordion-body collapse p-3" id="emp3">
                                            <div class="d-flex gap-3">
                                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                                <a href="#" class="btn btn-sm btn-outline-success">Consultation</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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