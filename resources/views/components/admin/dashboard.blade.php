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
            <h2 class="fw-bold mb-0">150</h2>
            <p class="mb-0">CCP Employees</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h2 class="fw-bold mb-0">45</h2>
            <p class="mb-0">Recent Visits</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h2 class="fw-bold mb-0">10</h2>
            <p class="mb-0">Upcoming Checkups</p>
          </div>
        </div>
      </div>
    </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                            Quick Stats
                            <span>
                                <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-title="Traffic Overview"></iconify-icon>
                            </span>
                        </h5>
                        <div id="traffic-overview" >
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body text-center">
              <img src="../admin/images/backgrounds/bulb.png" alt="image" class="img-fluid" width="40">
              <h4 class="mt-7">Productivity Tips!</h4>
              <p class="card-subtitle mt-2 mb-3">Stay alive</p>
                <button class="btn btn-primary mb-3">View All Tips</button>
            </div>
          </div>
        </div>
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
              <tr class="employee-row" 
                  data-name="John Doe" 
                  data-department="IT" 
                  data-age="28" 
                  data-gender="Male" 
                  data-history="None" 
                  data-contact="09171234567" 
                  data-email="john@example.com">
                <td class="ps-0 fw-medium">John Doe</td>
                <td>Software Engineer</td>
                <td class="text-center fw-medium">IT</td>
                <td class="text-center fw-medium">Active</td>
              </tr>

              <tr class="employee-row" 
                  data-name="Jane Smith" 
                  data-department="Human Resources" 
                  data-age="32" 
                  data-gender="Female" 
                  data-history="Asthma" 
                  data-contact="09987654321" 
                  data-email="jane@example.com">
                <td class="ps-0 fw-medium">Jane Smith</td>
                <td>HR Officer</td>
                <td class="text-center fw-medium">Human Resources</td>
                <td class="text-center fw-medium">Active</td>
              </tr>

              <tr class="employee-row" 
                  data-name="Michael Johnson" 
                  data-department="Finance" 
                  data-age="30" 
                  data-gender="Male" 
                  data-history="None" 
                  data-contact="09179874512" 
                  data-email="michael@example.com">
                <td class="ps-0 fw-medium">Michael Johnson</td>
                <td>Accountant</td>
                <td class="text-center fw-medium">Finance</td>
                <td class="text-center fw-medium">On Leave</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>

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
    </div>
  </div>
</div>

        <div class="col-lg-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title d-flex align-items-center gap-2 mb-5 pb-3">Sessions by
                device<span><iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-title="Locations"></iconify-icon></span>
              </h5>
              <div class="row">
                <div class="col-4">
                  <iconify-icon icon="solar:laptop-minimalistic-line-duotone" class="fs-7 d-flex text-primary"></iconify-icon>
                  <span class="fs-11 mt-2 d-block text-nowrap">Computers</span>
                  <h4 class="mb-0 mt-1">87%</h4>
                </div>
                <div class="col-4">
                  <iconify-icon icon="solar:smartphone-line-duotone" class="fs-7 d-flex text-secondary"></iconify-icon>
                  <span class="fs-11 mt-2 d-block text-nowrap">Smartphone</span>
                  <h4 class="mb-0 mt-1">9.2%</h4>
                </div>
                <div class="col-4">
                  <iconify-icon icon="solar:tablet-line-duotone" class="fs-7 d-flex text-success"></iconify-icon>
                  <span class="fs-11 mt-2 d-block text-nowrap">Tablets</span>
                  <h4 class="mb-0 mt-1">3.1%</h4>
                </div>
              </div>

              <div class="vstack gap-4 mt-7 pt-2">
                <div>
                  <div class="hstack justify-content-between">
                    <span class="fs-3 fw-medium">Computers</span>
                    <h6 class="fs-3 fw-medium text-dark lh-base mb-0">87%</h6>
                  </div>
                  <div class="progress mt-6" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                  </div>
                </div>

                <div>
                  <div class="hstack justify-content-between">
                    <span class="fs-3 fw-medium">Smartphones</span>
                    <h6 class="fs-3 fw-medium text-dark lh-base mb-0">9.2%</h6>
                  </div>
                  <div class="progress mt-6" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-secondary" style="width: 50%"></div>
                  </div>
                </div>

                <div>
                  <div class="hstack justify-content-between">
                    <span class="fs-3 fw-medium">Tablets</span>
                    <h6 class="fs-3 fw-medium text-dark lh-base mb-0">3.1%</h6>
                  </div>
                  <div class="progress mt-6" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-success" style="width: 35%"></div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card overflow-hidden hover-img">
            <div class="position-relative">
              <span class="badge text-bg-light text-dark fs-2 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">2
                min Read</span>
              <img src="../admin/images/profile/world.png" alt="matdash-img" class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9" width="30" height="20" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Georgeanna Ramero">
            </div>
            <div class="card-body p-4">
              <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3">Social</span>
              <a class="d-block my-4 fs-5 text-dark fw-semibold link-primary" href="">As yen tumbles, gadget-loving
                Japan goes
                for secondhand iPhones</a>
              <div class="d-flex align-items-center gap-4">
                <div class="d-flex align-items-center gap-2">
                  <i class="ti ti-eye text-dark fs-5"></i>9,125
                </div>
                <div class="d-flex align-items-center gap-2">
                  <i class="ti ti-message-2 text-dark fs-5"></i>3
                </div>
                <div class="d-flex align-items-center fs-2 ms-auto">
                  <i class="ti ti-point text-dark"></i>Mon, Dec 19
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card overflow-hidden hover-img">
            <div class="position-relative">
              <span class="badge text-bg-light text-dark fs-2 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">2
                min Read</span>
              <img src="../admin/images/profile/electronics.png" alt="matdash-img" class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9" width="30" height="20" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Georgeanna Ramero">
            </div>
            <div class="card-body p-4">
              <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3">Gadget</span>
              <a class="d-block my-4 fs-5 text-dark fw-semibold link-primary" href="">Intel loses bid to revive
                antitrust case
                against patent foe Fortress</a>
              <div class="d-flex align-items-center gap-4">
                <div class="d-flex align-items-center gap-2">
                  <i class="ti ti-eye text-dark fs-5"></i>4,150
                </div>
                <div class="d-flex align-items-center gap-2">
                  <i class="ti ti-message-2 text-dark fs-5"></i>38
                </div>
                <div class="d-flex align-items-center fs-2 ms-auto">
                  <i class="ti ti-point text-dark"></i>Sun, Dec 18
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card overflow-hidden hover-img">
            <div class="position-relative"> 
              <span class="badge text-bg-light text-dark fs-2 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">2
                min Read</span>
              <img src="../admin/images/profile/health-care.png" alt="matdash-img" class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9" width="30" height="20" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Georgeanna Ramero">
            </div>
            <div class="card-body p-4">
              <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3">Health</span>
              <a class="d-block my-4 fs-5 text-dark fw-semibold link-primary" href="">COVID outbreak deepens as more
                lockdowns
                loom in China</a>
              <div class="d-flex align-items-center gap-4">
                <div class="d-flex align-items-center gap-2">
                  <i class="ti ti-eye text-dark fs-5"></i>9,480
                </div>
                <div class="d-flex align-items-center gap-2">
                  <i class="ti ti-message-2 text-dark fs-5"></i>12
                </div>
                <div class="d-flex align-items-center fs-2 ms-auto">
                  <i class="ti ti-point text-dark"></i>Sat, Dec 17
                </div>
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


