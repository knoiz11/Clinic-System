
@extends('layout.admin')

<!-- Body Wrapper -->
<div class="page-wrapper" id="main-wrapper"
     data-layout="vertical"
     data-navbarbg="skin6"
     data-sidebartype="full"
     data-sidebar-position="fixed"
     data-header-position="fixed">

  <!-- Sidebar -->
  @include('components.admin.sidebar')

  <!-- Main wrapper -->
  <div class="body-wrapper">

    <!-- Header -->
    @include('components.admin.header')

    <!-- Page Content -->
    <div class="container-fluid">
      <div class="d-flex justify-content-between mb-4">
        <h3>Consultation Record</h3>
        <a href="{{ route('employee.index') }}" class="btn btn-secondary">Back to Employees</a>
      </div>

      <div class="card shadow-sm border-0">
        <div class="card-body" style="background-color: #f9f9f9;">
          <div class="row">
            <div class="col-md-9">
              <h6><strong>PHILHEALTH No:</strong> {{ $employee->philhealth_no ?? 'N/A' }}</h6>
              <h6><strong>Last Name:</strong> {{ $employee->last_name ?? '-' }}</h6>
              <h6><strong>First Name:</strong> {{ $employee->first_name ?? '-' }}</h6>
              <h6><strong>Middle Name:</strong> {{ $employee->middle_name ?? '-' }}</h6>
              <h6><strong>Sex:</strong> {{ $employee->sex ?? '-' }}</h6>
              <h6><strong>Birthdate:</strong> {{ $employee->birthdate ?? 'mm/dd/yyyy' }} &nbsp; <strong>Age:</strong> {{ $employee->age ?? '00' }}</h6>
              <h6><strong>Employment Status:</strong> {{ $employee->status ?? '-' }}</h6>
              <h6><strong>Designation:</strong> {{ $employee->designation ?? '-' }}</h6>
              <h6><strong>Division:</strong> {{ $employee->division ?? '-' }}</h6>
              <h6><strong>Department:</strong> {{ $employee->department ?? '-' }}</h6>
            </div>
            <div class="col-md-3 text-center">
              <div class="border bg-light rounded p-4">
                <i class="bi bi-person-circle" style="font-size: 80px; color: #b0b0b0;"></i>
              </div>
            </div>
          </div>

          <hr class="my-4">

          <div>
            <h6 class="fw-bold mb-3">— SERVICES —</h6>
            <div class="d-flex flex-wrap gap-3">
              <button class="btn btn-outline-primary btn-sm">1. Vital Signs</button>
              <button class="btn btn-outline-primary btn-sm">2. Physical Exam</button>
              <button class="btn btn-outline-primary btn-sm">3. Consultation Record</button>
              <button class="btn btn-outline-primary btn-sm">4. Doctor’s Order</button>
              <button class="btn btn-outline-primary btn-sm">5. Prescription</button>
              <button class="btn btn-outline-primary btn-sm">6. Laboratory</button>
              <button class="btn btn-outline-primary btn-sm">7. Dispense Medicine</button>
            </div>
          </div>

          <hr class="my-4">

          <div>
            <h6 class="fw-bold">[ Schedule of Next Visit ]</h6>
            <input type="date" class="form-control w-auto" />
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    @include('components.admin.footer')

  </div>
  <!-- End Main wrapper -->

</div>
<!-- End Body Wrapper -->