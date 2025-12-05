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
</head>
<body>

<div class="container-fluid py-4" data-employee-id="{{ $employee->id }}">
    
    {{-- Header Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body" style="background: linear-gradient(135deg, #7d3c4d 0%, #5a2c38 100%); color: white;">
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
                        <a href="{{ route('employee.show', $employee->id) }}" class="btn btn-light">
                            <i class="bi bi-arrow-left me-2"></i>Back to Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#vitalSignsModal">
                    <i class="bi bi-heart-pulse me-2"></i>Add Vital Signs
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#physicalExamModal">
                    <i class="bi bi-clipboard-pulse me-2"></i>Add Physical Exam
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#consultationModal">
                    <i class="bi bi-journal-medical me-2"></i>Add Consultation
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#doctorOrderModal">
                    <i class="bi bi-prescription2 me-2"></i>Add Doctor's Order
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#laboratoryModal">
                    <i class="bi bi-file-medical me-2"></i>Add Laboratory
                </button>
            </div>
        </div>
    </div>

    {{-- Records Display Section --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #7d3c4d; color: white;">
                    <h5 class="mb-0"><i class="bi bi-folder2-open me-2"></i>All Records</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Vital Signs Records --}}
                    <div id="vitalSignsRecords" class="mb-4"></div>
                    
                    {{-- Physical Exam Records --}}
                    <div id="physicalExamRecords" class="mb-4"></div>
                    
                    {{-- Consultation Records --}}
                    <div id="consultationRecords" class="mb-4"></div>
                    
                    {{-- Doctor's Order Records --}}
                    <div id="doctorOrderRecords" class="mb-4"></div>
                    
                    {{-- Laboratory Records --}}
                    <div id="laboratoryRecords" class="mb-4"></div>
                    
                    {{-- Empty State --}}
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
                        <div class="col-md-6">
                            <label class="form-label">Body Temperature</label>
                            <input type="text" class="form-control" name="body_temperature" placeholder="e.g., 36.5°C">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Heart Rate <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="heart_rate" placeholder="e.g., 72 bpm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pulse Rate</label>
                            <input type="text" class="form-control" name="pulse_rate" placeholder="e.g., 72 bpm">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Respiratory Rate</label>
                            <input type="text" class="form-control" name="respiratory_rate" placeholder="e.g., 16/min">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">BP Systolic <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="bp_systolic" placeholder="e.g., 120 mmHg" required>
                        </div>
                        <div class="col-md-6">
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
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">General Appearance</label>
                            <textarea class="form-control" name="general_appearance" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Head & Neck</label>
                            <textarea class="form-control" name="head_neck" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Chest & Lungs</label>
                            <textarea class="form-control" name="chest_lungs" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Heart & Cardiovascular</label>
                            <textarea class="form-control" name="heart_cardiovascular" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Abdomen</label>
                            <textarea class="form-control" name="abdomen" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Extremities</label>
                            <textarea class="form-control" name="extremities" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Additional Notes</label>
                            <textarea class="form-control" name="additional_notes" rows="2"></textarea>
                        </div>
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
                <form id="doctorOrderForm">
                    <div class="mb-3">
                        <label class="form-label">Medication Orders</label>
                        <textarea class="form-control" name="medication_orders" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Laboratory Tests Ordered</label>
                        <textarea class="form-control" name="lab_tests_ordered" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Special Instructions</label>
                        <textarea class="form-control" name="special_instructions" rows="2"></textarea>
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
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Test Type</label>
                            <input type="text" class="form-control" name="test_type">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Test</label>
                            <input type="date" class="form-control" name="test_date">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Test Results</label>
                            <textarea class="form-control" name="test_results" rows="4"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Conducted By</label>
                            <input type="text" class="form-control" name="conducted_by">
                        </div>
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

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- Consultation Records JavaScript --}}
<script src="{{ asset('js/consultation-record.js') }}"></script>
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