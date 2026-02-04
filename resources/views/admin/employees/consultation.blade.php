@extends('layout.admin')

<!-- Body Wrapper -->
<div class="page-wrapper" id="main-wrapper"
     data-layout="vertical"
     data-navbarbg="skin6"
     data-sidebartype="full"
     data-sidebar-position="fixed"
     data-header-position="fixed">

  @include('components.admin.sidebar')

  <div class="body-wrapper">
    @include('components.admin.header')

    <div class="container-fluid" data-employee-id="{{ $employee->id }}">
      
      <!-- Page Header -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0" style="color: #7d3c4d;">
          <i class="bi bi-journal-medical me-2"></i>Consultation Record
        </h3>
        <a href="{{ route('employee.index') }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left me-1"></i>Back to Employees
        </a>
      </div>

      <!-- Employee Information Card -->
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-body" style="background-color: #f9f9f9;">
          <div class="row">
            <div class="col-md-9">
              <div class="row g-3">
                <div class="col-md-6">
                  <small class="text-muted d-block">PHILHEALTH No:</small>
                  <h6 class="mb-0 fw-bold">{{ $employee->philhealth_no ?? 'N/A' }}</h6>
                </div>
                <div class="col-md-6">
                  <small class="text-muted d-block">Full Name:</small>
                  <h6 class="mb-0 fw-bold">{{ $employee->first_name ?? '-' }} {{ $employee->middle_name ?? '' }} {{ $employee->last_name ?? '-' }}</h6>
                </div>
                <div class="col-md-3">
                  <small class="text-muted d-block">Sex:</small>
                  <h6 class="mb-0">{{ $employee->sex ?? '-' }}</h6>
                </div>
                <div class="col-md-5">
                  <small class="text-muted d-block">Birthdate:</small>
                  <h6 class="mb-0">{{ $employee->birthdate ?? 'mm/dd/yyyy' }}</h6>
                </div>
                <div class="col-md-4">
                  <small class="text-muted d-block">Age:</small>
                  <h6 class="mb-0">{{ $employee->age ?? '00' }} years old</h6>
                </div>
                <div class="col-md-4">
                  <small class="text-muted d-block">Status:</small>
                  <h6 class="mb-0">{{ $employee->status ?? '-' }}</h6>
                </div>
                <div class="col-md-8">
                  <small class="text-muted d-block">Designation:</small>
                  <h6 class="mb-0">{{ $employee->designation ?? '-' }}</h6>
                </div>
                <div class="col-md-6">
                  <small class="text-muted d-block">Division:</small>
                  <h6 class="mb-0">{{ $employee->division ?? '-' }}</h6>
                </div>
                <div class="col-md-6">
                  <small class="text-muted d-block">Department:</small>
                  <h6 class="mb-0">{{ $employee->department ?? '-' }}</h6>
                </div>
              </div>
            </div>
            <div class="col-md-3 text-center">
              <div class="border bg-white rounded p-4 shadow-sm">
                <i class="bi bi-person-circle" style="font-size: 80px; color: #b0b0b0;"></i>
                <p class="text-muted small mb-0 mt-2">Employee Photo</p>
              </div>
            </div>
          </div>

          <hr class="my-4">

          <!-- Services Buttons -->
          <div>
            <h6 class="fw-bold mb-3 text-uppercase" style="color: #7d3c4d;">
              <i class="bi bi-hospital me-2"></i>— Services —
            </h6>
            <div class="d-flex flex-wrap gap-2">
              <button class="btn" style="background-color: #7d3c4d; color: white;" 
                      data-bs-toggle="modal" data-bs-target="#vitalSignsModal">
                <i class="bi bi-heart-pulse me-1"></i>1. Vital Signs
              </button>
              <button class="btn" style="background-color: #7d3c4d; color: white;" 
                      data-bs-toggle="modal" data-bs-target="#physicalExamModal">
                <i class="bi bi-clipboard-pulse me-1"></i>2. Physical Exam
              </button>
              <button class="btn" style="background-color: #7d3c4d; color: white;" 
                      data-bs-toggle="modal" data-bs-target="#consultationModal">
                <i class="bi bi-journal-medical me-1"></i>3. Consultation Record
              </button>
              <button class="btn" style="background-color: #7d3c4d; color: white;" 
                      data-bs-toggle="modal" data-bs-target="#doctorOrderModal">
                <i class="bi bi-prescription2 me-1"></i>4. Doctor's Order
              </button>
              <button class="btn" style="background-color: #7d3c4d; color: white;" 
                      data-bs-toggle="modal" data-bs-target="#laboratoryModal">
                <i class="bi bi-file-medical me-1"></i>6. Laboratory
              </button>
            </div>
          </div>

          <hr class="my-4">

          <!-- Schedule Next Visit -->
          <div>
            <h6 class="fw-bold mb-2">
              <i class="bi bi-calendar-check me-2"></i>[ Schedule of Next Visit ]
            </h6>
            <input type="date" class="form-control" style="max-width: 280px;" />
          </div>

          <!-- Saved Records Section -->
          <div id="savedRecordsSection" class="mt-4" style="display: none;">
            <hr class="my-4">
            <h6 class="fw-bold mb-3 text-uppercase" style="color: #7d3c4d;">
              <i class="bi bi-folder2-open me-2"></i>— Saved Records —
            </h6>
            
            <div id="vitalSignsRecords"></div>
            <div id="physicalExamRecords"></div>
            <div id="consultationRecords"></div>
            <div id="doctorOrderRecords"></div>
            <div id="laboratoryRecords"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Include the external JavaScript file -->
<script src="{{ asset('js/consultation-record.js') }}"></script>