<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Consultation Records - {{ $employee->first_name }} {{ $employee->last_name }}</title>
    
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href='https://clinicaltables.nlm.nih.gov/autocomplete-lhc-versions/19.2.4/autocomplete-lhc.min.css' rel="stylesheet">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}">
</head>
<body>

<div class="container-fluid py-4" data-employee-id="{{ $employee->id }}">
    
    {{-- Header Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body" style="background: linear-gradient(135deg, #7d3c4d 0%, #7D1D37 100%); color: white; border-radius: 4px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1">
                                <i class="bi bi-file-medical me-2"></i>
                                Consultation Records
                            </h2>
                            <p class="mb-0 opacity-75">
                                Employee: {{ $employee->first_name }} {{ $employee->last_name }} 
                                (ID: {{ $employee->employee_id }})
                            </p>
                        </div>
                        <a href="{{ route('employee.show', $employee->id) }}" id="back2employeeButton" class="btn">
                            <i class="bi bi-arrow-left me-2"></i>Back to Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- Action Buttons, Search & Filter --}}
<div class="row mb-4 align-items-center flex-wrap">
  <!-- Buttons -->
  <div class="col-lg-7 col-md-12 mb-2 mb-lg-1">
    <div class="btn-group flex-wrap" role="group">
      <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#vitalSignsModal" style="background-color: #7D1D37; border-color: #7D1D37;">
        <i class="bi bi-heart-pulse me-2"></i>Add Vital Signs
      </button>
      <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#physicalExamModal" style="background-color: #7D1D37; border-color: #7D1D37;">
        <i class="bi bi-clipboard-pulse me-2"></i>Add Physical Exam
      </button>
      <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#consultationModal" style="background-color: #7D1D37; border-color: #7D1D37;">
        <i class="bi bi-journal-medical me-2"></i>Add Consultation
      </button>
      <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#doctorOrderModal" style="background-color: #7D1D37; border-color: #7D1D37;">
        <i class="bi bi-prescription2 me-2"></i>Add Doctor's Order
      </button>
      <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#laboratoryModal" style="background-color: #7D1D37; border-color: #7D1D37;">
        <i class="bi bi-file-medical me-2"></i>Add Laboratory
      </button>
    </div>
  </div>

  <!-- Search -->
  <div class="col-lg-3 col-md-6 mb-2 mb-md-0">
    <div class="input-group">
      <input type="text" id="recordSearchInput" class="form-control" placeholder="Search records...">
      <button class="btn" id="searchButton"><i class="bi bi-search"></i></button>
    </div>
  </div>

  <!-- Filters -->
  <div class="col-lg-2 col-md-6 mb-2 mb-md-0">
    <div class="input-group">
      <select id="recordFilter" class="form-select">
        <option value="" hidden placeholder>Filter records...</option>
        <option value="vitalSigns">Vital Signs</option>
        <option value="physicalExam">Physical Exam</option>
        <option value="consultation">Consultation</option>
        <option value="doctorOrder">Doctor's Order</option>
        <option value="laboratory">Laboratory</option>
      </select>
      <button class="btn" id="clearFilterButton">Clear</button>
    </div>
  </div>

</div>


    {{-- Records Display Section --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #7D1D37; color: white;">
                    <h5 class="mb-0"><i class="bi bi-folder2-open me-2"></i>All Records</h5>
                </div>
                <div class="card-body">
                    <div id="vitalSignsRecords" class="mb-4" style="background-color: #7D1D37;"></div>
                    <div id="physicalExamRecords" class="mb-4" style="background-color: #7D1D37;"></div>
                    <div id="consultationRecords" class="mb-4" style="background-color: #7D1D37;"></div>
                    <div id="doctorOrderRecords" class="mb-4" style="background-color: #7D1D37;"></div>
                    <div id="laboratoryRecords" class="mb-4" style="background-color: #7D1D37;"></div>
                    <div id="emptyState" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox" style="font-size: 4rem;"></i>
                        <p class="mt-3">No records yet. Click the buttons above to add records.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- MODALS --}}

{{-- Vital Signs Modal --}}
<div class="modal fade" id="vitalSignsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #7d3c4d; color: white;">
        <h5 class="modal-title"><i class="bi bi-heart-pulse me-2"></i>Vital Signs</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="vitalSignsForm">
          <div class="row g-3">

            <div class="col-md-4">
              <label class="form-label">Body Temperature</label>
              <input type="text" class="form-control" name="body_temperature" placeholder="e.g., 36.5°C">
            </div>

            <div class="col-md-4">
              <label class="form-label">Heart Rate <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="heart_rate" placeholder="e.g., 72 bpm" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Pulse Rate</label>
              <input type="text" class="form-control" name="pulse_rate" placeholder="e.g., 72 bpm">
            </div>

            <div class="col-md-4">
              <label class="form-label">Respiratory Rate</label>
              <input type="text" class="form-control" name="respiratory_rate" placeholder="e.g., 16/min">
            </div>

            <div class="col-md-4">
              <label class="form-label">BP Systolic <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="bp_systolic" placeholder="e.g., 120 mmHg" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">BP Diastolic <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="bp_diastolic" placeholder="e.g., 80 mmHg" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">BP Assessment <span class="text-danger">*</span></label>
              <select class="form-select" name="bp_assessment" required>
                <option value="">Select Assessment</option>
                <option value="Normal">Normal</option>
                <option value="Elevated">Elevated</option>
                <option value="High (Stage 1)">High (Stage 1)</option>
                <option value="High (Stage 2)">High (Stage 2)</option>
                <option value="Hypertensive Crisis">Hypertensive Crisis</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Administered By <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="administered_by" required>
            </div>

            <div class="col-12">
              <label class="form-label">Remarks</label>
              <textarea class="form-control" name="remarks" rows="2"></textarea>
            </div>

          </div>

          <div class="mt-3 text-end">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save me-2"></i>Save
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>


{{-- Physical Exam Modal --}}
<div class="modal fade" id="physicalExamModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #7d3c4d; color: white;">
        <h5 class="modal-title"><i class="bi bi-clipboard-pulse me-2"></i>Physical Examination</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="physicalExamForm">
          <div class="row g-4">

            <!-- Head -->
            <div class="col-md-4">
              <label class="form-label">Head</label>
              <textarea name="head" class="form-control" rows="2"></textarea>
            </div>

            <!-- Conjunctiva -->
            <div class="col-md-4">
              <label class="form-label">Conjunctiva (eye anatomy)</label>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="conjunctiva_pale" value="1"> <label class="form-check-label">Pale</label></div>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="conjunctiva_yellowish" value="1"> <label class="form-check-label">Yellowish</label></div>
            </div>

            <div class="col-md-4">
              <label class="form-label">Conjunctiva Remarks</label>
              <textarea name="conjunctiva_remarks" class="form-control" rows="2"></textarea>
            </div>

            <!-- Neck -->
            <div class="col-md-4">
              <label class="form-label">Neck</label>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="neck_enlarged_thyroid" value="1"> <label class="form-check-label">Enlarged thyroid</label></div>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="neck_enlarged_lymph" value="1"> <label class="form-check-label">Enlarged lymph nodes</label></div>
            </div>

            <!-- Thorax -->
            <div class="col-md-4">
              <label class="form-label">Thorax</label>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="thorax_abnormal_cardiac" value="1"> <label class="form-check-label">Abnormal cardiac rate</label></div>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="thorax_abnormal_breathing" value="1"> <label class="form-check-label">Abnormal breathing rate</label></div>
            </div>

            <div class="col-md-4">
              <label class="form-label">Thorax Remarks</label>
              <textarea name="thorax_remarks" class="form-control" rows="2"></textarea>
            </div>

            <!-- Chest -->
            <div class="col-md-4">
              <label class="form-label">Chest</label>
              <textarea name="chest" class="form-control" rows="2"></textarea>
            </div>

            <!-- Breast -->
            <div class="col-md-4">
              <label class="form-label">Breast</label>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="breast_mass" value="1"> <label class="form-check-label">Mass</label></div>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="breast_nipple_discharge" value="1"> <label class="form-check-label">Nipple discharge</label></div>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="breast_skin_orange" value="1"> <label class="form-check-label">Skin orange/peeling</label></div>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="breast_enlarged_nodes" value="1"> <label class="form-check-label">Enlarged auxiliary lymph nodes</label></div>
            </div>

            <div class="col-md-4">
              <label class="form-label">Breast Remarks</label>
              <textarea name="breast_remarks" class="form-control" rows="2"></textarea>
            </div>

            <!-- Abdomen -->
            <div class="col-md-4">
              <label class="form-label">Abdomen</label>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="abdomen_enlarged_liver" value="1"> <label class="form-check-label">Enlarged liver</label></div>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="abdomen_mass" value="1"> <label class="form-check-label">Mass</label></div>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="abdomen_scar" value="1"> <label class="form-check-label">Scar</label></div>
              <div class="form-check"><input class="form-check-input" type="checkbox" name="abdomen_tenderness" value="1"> <label class="form-check-label">Tenderness</label></div>
            </div>

            <div class="col-md-4">
              <label class="form-label">Abdomen Remarks</label>
              <textarea name="abdomen_remarks" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label">Others</label>
              <textarea name="others" class="form-control" rows="2"></textarea>
            </div>

            <!-- Administered By & Remarks -->
            <div class="col-md-6">
              <label class="form-label">Administered by <span class="text-danger">*</span></label>
              <input name="administered_by" class="form-control" type="text" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Remarks</label>
              <textarea name="remarks" class="form-control" rows="2"></textarea>
            </div>

          </div>

          <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save me-2"></i>Save
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>


{{-- Consultation Modal --}}
<div class="modal fade" id="consultationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #7d3c4d; color: white;">
                <h5 class="modal-title"><i class="bi bi-journal-medical me-2"></i>Consultation Record</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="consultationForm">
                    <div class="mb-3">
                        <label class="form-label">Chief Complaint</label>
                        <textarea class="form-control" name="chief_complaint" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">History of Present Illness</label>
                        <textarea class="form-control" name="history_illness" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diagnosis</label>
                        <textarea class="form-control" name="diagnosis" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Treatment Plan</label>
                        <textarea class="form-control" name="treatment_plan" rows="3"></textarea>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Save
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Doctor's Order Modal --}}
<div class="modal fade" id="doctorOrderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #7d3c4d; color: white;">
                <h5 class="modal-title"><i class="bi bi-prescription2 me-2"></i>Doctor's Order</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="doctorOrderForm" class="row g-3" novalidate>
                    <input type="hidden" name="service_type" value="doctors-order" />

                    <div class="col-12">
                        <label class="form-label">Consultation Notes</label>
                        <textarea name="doctors_order" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Prescription</label>
                        <textarea id="prescriptionTextarea" name="prescription" class="form-control" rows="4" readonly disabled></textarea>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Date of Prescription</label>
                        <input name="order_date" class="form-control" type="date" />
                    </div>

                    <div class="col-12">
                        <button type="button" class="btn btn-primary" id="prescribeMedication"
                            data-bs-toggle="modal" data-bs-target="#prescriptionModal"
                            style="background-color: var(--ccp-primary-color-gold) !important; color: var(--ccp-light) !important; border-color: var(--ccp-primary-color-gold) !important;">
                            PRESCRIBE MEDICATION
                        </button>
                    </div>

                    <div class="col-md-7">
                        <label class="form-label">Diagnosis <span class="text-danger">*</span></label>
                        <select name="diagnosis" class="form-select">
                            <option value="" hidden>SELECT DIAGNOSIS</option>
                            <option value="Admitting Diagnosis">Admitting Diagnosis</option>
                            <option value="Final Diagnosis">Final Diagnosis</option>
                            <option value="Provisional Diagnosis">Provisional Diagnosis</option>
                            <option value="Unnecessary">Unnecessary</option>
                            <option value="Other">Other</option>
                        </select>
                        <div class="col-12 mt-2" id="otherDiagnosisContainer" style="display: none;">
                            <input name="other_diagnosis" class="form-control" type="text" placeholder="Other Diagnosis"/>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label">ICD-11 <span class="text-danger">*</span></label>
                        <br>
                        <input id="icd11_codes" name="icd11_codes" class="form-control" type="text" />
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Treatment Plan</label>
                        <textarea name="treatment_plan" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Disposition <span class="text-danger">*</span></label>
                        <select name="disposition" class="form-select">
                            <option value="">SELECT DISPOSITION</option>
                            <option value="admit">Admit</option>
                            <option value="observe">Observe</option>
                            <option value="refer">Refer</option>
                            <option value="discharge">Discharge</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Reasons for Discharge</label>
                        <textarea name="reasons_for_discharge" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Date & Time of Discharge</label>
                        <input name="discharge_datetime" class="form-control" type="datetime-local" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Remarks</label>
                        <textarea name="order_remarks" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Schedule Next Visit <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 align-items-center mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="schedule_next" id="schedule_yes_do" value="yes">
                                <label class="form-check-label" for="schedule_yes_do">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="schedule_next" id="schedule_no_do" value="no">
                                <label class="form-check-label" for="schedule_no_do">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-primary" style="background-color: var(--ccp-primary-color-gold) !important; color: var(--ccp-light) !important; border-color: var(--ccp-primary-color-gold) !important;">
                            APPOINT
                        </button>
                        <button type="submit" class="btn btn-primary" style="background-color: var(--ccp-primary-color-maroon) !important; color: var(--ccp-light) !important; border-color: var(--ccp-primary-color-maroon) !important;">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Prescribe Medication Modal --}}
<div class="modal fade" id="prescriptionModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #7d3c4d; color: white;">
                <h5 class="modal-title"><i class="bi bi-capsule me-2"></i>Prescribe Medication</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Search and Filter -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text">&#128269</span>
                            <input type="text" class="form-control" id="searchInput" placeholder="Search Medicine..." oninput="filterMedications()">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="filterSelect" onchange="filterMedications()">
                            <option value="">All Types</option>
                            <option value="otc">OTC Only</option>
                            <option value="prescription">Prescription Only</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">Clear Filter</button>
                    </div>
                </div>

                <!-- Medications Table -->
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Drug Name</th>
                                <th>Strength</th>
                                <th>OTC</th>
                                <th>Inventory</th>
                                <th style="width: 150px;">Quantity</th>
                            </tr>
                        </thead>
                        <tbody id="medicationTableBody">
                            <!-- Rows will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Selected Medications -->
                <div class="mt-4" id="selectedSection" style="display: none;">
                    <div class="alert alert-info">
                        <h6 class="alert-heading"><strong>Selected Medications</strong></h6>
                        <div id="selectedList"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="prescribeBtn" onclick="prescribeMedications()" disabled style="background-color: #7d3c4d; border-color: #7d3c4d;">
                    PRESCRIBE MEDICATION
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Laboratory Modal --}}
<div class="modal fade" id="laboratoryModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #7d3c4d; color: white;">
        <h5 class="modal-title"><i class="bi bi-file-medical me-2"></i>Laboratory Results</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="laboratoryForm">
          <input type="hidden" name="service_type" value="laboratory" />
          <div class="row g-3">

            <div class="col-md-4">
              <label class="form-label">Blood Chemistry</label>
              <textarea name="blood_chemistry" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label">Blood Oxygenation</label>
              <textarea name="blood_oxygenation" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label">Complete Blood Count</label>
              <textarea name="complete_blood_count" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label">Immunology</label>
              <textarea name="immunology" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label">Clinical Chemistry</label>
              <textarea name="clinical_chemistry" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label">Fecalysis</label>
              <textarea name="fecalysis" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label">Serology</label>
              <textarea name="serology" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label">Sputum Microscopy</label>
              <textarea name="sputum_microscopy" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label">Urinalysis</label>
              <textarea name="urinalysis" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label">Hematology</label>
              <textarea name="hematology" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label">Administered By <span class="text-danger">*</span></label>
              <input name="administered_by" class="form-control" type="text" required />
            </div>

            <div class="col-md-6">
              <label class="form-label">Remarks</label>
              <textarea name="remarks" class="form-control" rows="2"></textarea>
            </div>

          </div>

          <div class="mt-3 text-end">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save me-2"></i>Save
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

{{-- Medication Modal --}}
<div class="modal fade" id="prescriptionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #7d3c4d; color: white;">
                <h5 class="modal-title"><i class="bi bi-prescription2 me-2"></i>Prescription</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="doctorOrderForm" class="row g-3" novalidate>
                    <input type="hidden" name="service_type" value="doctors-order" />

                    <div class="col-12">
                        <label class="form-label">Consultation Notes</label>
                        <textarea name="doctors_order" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Prescription</label>
                        <textarea name="prescription" class="form-control" rows="4" readonly disabled></textarea>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Date of Prescription</label>
                        <input name="order_date" class="form-control" type="date" />
                    </div>

                    <div class="col-12">
                        <button type="button" class="btn btn-primary" id="prescribeMedication"
                            data-bs-toggle="modal" data-bs-target="#prescriptionModal"
                            style="background-color: var(--ccp-primary-color-gold) !important; color: var(--ccp-light) !important; border-color: var(--ccp-primary-color-gold) !important;">
                            PRESCRIBE MEDICATION
                        </button>
                    </div>

                    <div class="col-md-7">
                        <label class="form-label">Diagnosis <span class="text-danger">*</span></label>
                        <select name="diagnosis" class="form-select">
                            <option value="" hidden>SELECT DIAGNOSIS</option>
                            <option value="Admitting Diagnosis">Admitting Diagnosis</option>
                            <option value="Final Diagnosis">Final Diagnosis</option>
                            <option value="Provisional Diagnosis">Provisional Diagnosis</option>
                            <option value="Unnecessary">Unnecessary</option>
                            <option value="Other">Other</option>
                        </select>
                        <div class="col-12 mt-2" id="otherDiagnosisContainer" style="display: none;">
                            <input name="other_diagnosis" class="form-control" type="text" placeholder="Other Diagnosis"/>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label">ICD-11 <span class="text-danger">*</span></label>
                        <br>
                        <input id="icd11_codes" name="icd11_codes" class="form-control" type="text" />
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Treatment Plan</label>
                        <textarea name="treatment_plan" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Disposition <span class="text-danger">*</span></label>
                        <select name="disposition" class="form-select">
                            <option value="">SELECT DISPOSITION</option>
                            <option value="admit">Admit</option>
                            <option value="observe">Observe</option>
                            <option value="refer">Refer</option>
                            <option value="discharge">Discharge</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Reasons for Discharge</label>
                        <textarea name="reasons_for_discharge" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Date & Time of Discharge</label>
                        <input name="discharge_datetime" class="form-control" type="datetime-local" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Remarks</label>
                        <textarea name="order_remarks" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Schedule Next Visit <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 align-items-center mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="schedule_next" id="schedule_yes_do" value="yes">
                                <label class="form-check-label" for="schedule_yes_do">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="schedule_next" id="schedule_no_do" value="no">
                                <label class="form-check-label" for="schedule_no_do">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-primary" style="background-color: var(--ccp-primary-color-gold) !important; color: var(--ccp-light) !important; border-color: var(--ccp-primary-color-gold) !important;">
                            APPOINT
                        </button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- Consultation Records JavaScript --}}
<script src="{{ asset('js/consultation-record.js') }}"></script>
<script src="{{ asset('js/icdcode.js') }}"></script>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<script src='https://clinicaltables.nlm.nih.gov/autocomplete-lhc-versions/19.2.4/autocomplete-lhc.min.js'></script>
<script>
// Helper function to show saved records section
function showSavedRecordsSection() {
    const emptyState = document.getElementById('emptyState');
    if (emptyState) {
        emptyState.style.display = 'none';
    }
}
</script>

</body>
</html>