// ============================================
// GLOBAL STATE
// ============================================
let editingVitalSignIndex = null;
let editingPhysicalExamIndex = null;
let editingConsultationIndex = null;
let editingDoctorOrderIndex = null;
let editingLaboratoryIndex = null;
let employeeId = null;

// Store records in memory for quick access
let vitalSignsData = [];
let physicalExamsData = [];
let consultationsData = [];
let doctorOrdersData = [];
let laboratoriesData = [];

// ============================================
// INITIALIZATION
// ============================================
document.addEventListener('DOMContentLoaded', function() {
  console.log('Page loaded, initializing...');
  
  const employeeIdElement = document.querySelector('[data-employee-id]');
  if (employeeIdElement) {
    employeeId = employeeIdElement.getAttribute('data-employee-id');
    console.log('Employee ID:', employeeId);
  } else {
    console.error('Employee ID element not found!');
    return;
  }
  
  loadAllRecordsFromDatabase();
  initializeFormHandlers();
  initializeICD11Autocomplete();
  initializeDiagnosisDropdown();
});

// ============================================
// ICD-11 AUTOCOMPLETE INITIALIZATION
// ============================================
function initializeICD11Autocomplete() {
  console.log('Setting up ICD-11 autocomplete...');
  
  const doctorOrderModalEl = document.getElementById('doctorOrderModal');
  
  if (doctorOrderModalEl) {
    doctorOrderModalEl.addEventListener('shown.bs.modal', function () {
      const input = document.getElementById('icd11_codes');
      
      if (input && !input.classList.contains('lhc-autocomplete')) {
        try {
          // Set up mutation observer BEFORE initializing autocomplete
          const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
              mutation.addedNodes.forEach((node) => {
                if (node.tagName === 'UL' || node.tagName === 'DIV') {
                  const style = window.getComputedStyle(node);
                  if (style.position === 'absolute') {
                    node.style.zIndex = '999999';
                    console.log('MutationObserver fixed z-index for:', node);
                  }
                }
              });
            });
          });
          
          observer.observe(document.body, {
            childList: true,
            subtree: true
          });
          
          new Def.Autocompleter.Search(
            'icd11_codes',
            'https://clinicaltables.nlm.nih.gov/api/icd11_codes/v3/search?sf=code,title',
            {
              tableFormat: true,
              valueCols: [0],
              colHeaders: ['Code', 'Title', 'Type']
            }
          );
          
          console.log('ICD-11 autocomplete initialized successfully');
        } catch (error) {
          console.error('Error initializing ICD-11 autocomplete:', error);
        }
      }
    });
  }
}

// ============================================
// DIAGNOSIS DROPDOWN HANDLER
// ============================================
function initializeDiagnosisDropdown() {
  const diagnosisSelect = document.querySelector('#doctorOrderForm [name="diagnosis"]');
  if (diagnosisSelect) {
    diagnosisSelect.addEventListener('change', function() {
      const otherDiagContainer = document.getElementById('otherDiagnosisContainer');
      if (this.value === 'Other') {
        otherDiagContainer.style.display = 'block';
      } else {
        otherDiagContainer.style.display = 'none';
      }
    });
  }
}

// ============================================
// API HELPER FUNCTIONS
// ============================================
async function apiRequest(url, method = 'GET', data = null) {
  console.log(url, method, data);
  try {
    console.log(`API Request: ${method} ${url}`, data);
    
    const options = {
      method: method,
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      }
    };
    
    if (data && (method === 'POST' || method === 'PUT')) {
      options.body = JSON.stringify(data);
    }
    
    const response = await fetch(url, options);
    const result = await response.json();
    
    console.log('API Response:', result);
    
    if (!response.ok) {
      throw new Error(result.message || 'Request failed');
    }
    
    return result;
  } catch (error) {
    console.error('API Error:', error);
    alert('Error: ' + error.message);
    throw error;
  }
}

// ============================================
// LOCALSTORAGE HELPER (with error handling)
// ============================================
function safeLocalStorageSet(key, value) {
  try {
    localStorage.setItem(key, value);
  } catch (error) {
    console.warn('localStorage not available:', error);
  }
}

function safeLocalStorageGet(key, defaultValue = '[]') {
  try {
    return localStorage.getItem(key) || defaultValue;
  } catch (error) {
    console.warn('localStorage not available:', error);
    return defaultValue;
  }
}

// Helper function to show records section (if it exists)
function showSavedRecordsSection() {
  const section = document.getElementById('savedRecordsSection');
  if (section) {
    section.style.display = 'block';
  }
}

// ============================================
// LOAD ALL RECORDS FROM DATABASE
// ============================================
async function loadAllRecordsFromDatabase() {
  try {
    console.log('Loading all records from database...');
    const data = await apiRequest(`/admin/employee/${employeeId}/consultation/all`);
    
    vitalSignsData = data.vitalSigns || [];
    physicalExamsData = data.physicalExams || [];
    consultationsData = data.consultations || [];
    doctorOrdersData = data.doctorOrders || [];
    laboratoriesData = data.laboratories || [];
    
    safeLocalStorageSet(`vitalSigns_${employeeId}`, JSON.stringify(vitalSignsData));
    safeLocalStorageSet(`physicalExams_${employeeId}`, JSON.stringify(physicalExamsData));
    safeLocalStorageSet(`consultations_${employeeId}`, JSON.stringify(consultationsData));
    safeLocalStorageSet(`doctorOrders_${employeeId}`, JSON.stringify(doctorOrdersData));
    safeLocalStorageSet(`laboratories_${employeeId}`, JSON.stringify(laboratoriesData));
    
    loadVitalSigns();
    loadPhysicalExams();
    loadConsultations();
    loadDoctorOrders();
    loadLaboratories();
    
    console.log('All records loaded successfully');
  } catch (error) {
    console.error('Failed to load records from database:', error);
    loadFromLocalStorage();
  }
}

function loadFromLocalStorage() {
  console.log('Loading from localStorage...');
  vitalSignsData = JSON.parse(safeLocalStorageGet(`vitalSigns_${employeeId}`));
  physicalExamsData = JSON.parse(safeLocalStorageGet(`physicalExams_${employeeId}`));
  consultationsData = JSON.parse(safeLocalStorageGet(`consultations_${employeeId}`));
  doctorOrdersData = JSON.parse(safeLocalStorageGet(`doctorOrders_${employeeId}`));
  laboratoriesData = JSON.parse(safeLocalStorageGet(`laboratories_${employeeId}`));
  
  loadVitalSigns();
  loadPhysicalExams();
  loadConsultations();
  loadDoctorOrders();
  loadLaboratories();
}

// ============================================
// VITAL SIGNS
// ============================================
function loadVitalSigns() {
  const container = document.getElementById('vitalSignsRecords');
  if (!container) {
    console.warn('vitalSignsRecords container not found');
    return;
  }
  
  container.innerHTML = '';
  
  vitalSignsData.forEach((data, index) => {
    const timestamp = data.created_at ? new Date(data.created_at).toLocaleString() : data.timestamp || 'N/A';
    const recordHTML = `
     <div class="accordion mb-3" id="vitalAccordion${index}">
  <div class="accordion-item border-0 shadow-sm">

    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#vitalCollapse${index}">
        <span><i class="bi bi-heart-pulse me-2"></i><strong>Vital Signs</strong> - ${timestamp}</span>
      </button>
    </h2>

    <div id="vitalCollapse${index}" class="accordion-collapse collapse" data-bs-parent="#vitalAccordion${index}">
      <div class="accordion-body bg-light">

        <div class="d-flex justify-content-end mb-3">
          <button class="btn btn-sm btn-secondary me-2" onclick="editVitalSign(${index})">
            <i class="bi bi-pencil"></i> Edit
          </button>
          <button class="btn btn-sm btn-danger" onclick="deleteVitalSign(${index})">
            <i class="bi bi-trash"></i> Delete
          </button>
        </div>

        <div class="row g-3">

          <div class="col-md-4">
            <small class="text-muted">Body Temperature:</small>
            <p class="mb-0 fw-semibold">${data.body_temperature || 'N/A'}</p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Heart Rate:</small>
            <p class="mb-0 fw-semibold">${data.heart_rate || 'N/A'} bpm</p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Pulse Rate:</small>
            <p class="mb-0 fw-semibold">${data.pulse_rate || 'N/A'}</p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">BP Systolic:</small>
            <p class="mb-0 fw-semibold">${data.bp_systolic || 'N/A'} mmHg</p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">BP Diastolic:</small>
            <p class="mb-0 fw-semibold">${data.bp_diastolic || 'N/A'} mmHg</p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Respiratory Rate:</small>
            <p class="mb-0 fw-semibold">${data.respiratory_rate || 'N/A'}</p>
          </div>

          <div class="col-md-6">
            <small class="text-muted">BP Measurement Assessment:</small>
            <p class="mb-0 fw-semibold">${data.bp_assessment || 'N/A'}</p>
          </div>

          <div class="col-md-6">
            <small class="text-muted">Administered by:</small>
            <p class="mb-0 fw-semibold">${data.administered_by || 'N/A'}</p>
          </div>

        </div>

        ${data.remarks ? `
        <hr class="my-2">
        <div>
          <small class="text-muted">Remarks:</small>
          <p class="mb-0">${data.remarks}</p>
        </div>
        ` : ''}

      </div>
    </div>

  </div>
</div>

    `;
    container.innerHTML += recordHTML;
  });
  
  if (vitalSignsData.length > 0) {
    showSavedRecordsSection();
  }
}

function editVitalSign(index) {
  const data = vitalSignsData[index];
  
  document.querySelector('#vitalSignsForm [name="body_temperature"]').value = data.body_temperature || '';
  document.querySelector('#vitalSignsForm [name="heart_rate"]').value = data.heart_rate || '';
  document.querySelector('#vitalSignsForm [name="pulse_rate"]').value = data.pulse_rate || '';
  document.querySelector('#vitalSignsForm [name="bp_systolic"]').value = data.bp_systolic || '';
  document.querySelector('#vitalSignsForm [name="bp_diastolic"]').value = data.bp_diastolic || '';
  document.querySelector('#vitalSignsForm [name="respiratory_rate"]').value = data.respiratory_rate || '';
  document.querySelector('#vitalSignsForm [name="bp_assessment"]').value = data.bp_assessment || '';
  document.querySelector('#vitalSignsForm [name="administered_by"]').value = data.administered_by || '';
  document.querySelector('#vitalSignsForm [name="remarks"]').value = data.remarks || '';
  
  editingVitalSignIndex = index;
  new bootstrap.Modal(document.getElementById('vitalSignsModal')).show();
}

async function deleteVitalSign(index) {
  if (!confirm('Are you sure you want to delete this vital signs record?')) return;
  
  const record = vitalSignsData[index];
  
  if (record.id) {
    try {
      await apiRequest(`/admin/employee/${employeeId}/consultation/vital-signs/${record.id}`, 'DELETE');
    } catch (error) {
      console.error('Delete failed:', error);
      return;
    }
  }
  
  vitalSignsData.splice(index, 1);
  safeLocalStorageSet(`vitalSigns_${employeeId}`, JSON.stringify(vitalSignsData));
  loadVitalSigns();
}

// ============================================
// PHYSICAL EXAM
// ============================================
function loadPhysicalExams() {
  const container = document.getElementById('physicalExamRecords');
  if (!container) {
    console.warn('physicalExamRecords container not found');
    return;
  }
  
  container.innerHTML = '';
  
  physicalExamsData.forEach((data, index) => {
    const timestamp = data.created_at ? new Date(data.created_at).toLocaleString() : data.timestamp || 'N/A';
    const recordHTML = `
      <div class="accordion mb-3" id="physicalExamAccordion${index}">
  <div class="accordion-item border-0 shadow-sm">

    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#physicalExamCollapse${index}">
        <i class="bi bi-clipboard-pulse me-2"></i>
        <strong>Physical Exam</strong> - ${timestamp}
      </button>
    </h2>

    <div id="physicalExamCollapse${index}" class="accordion-collapse collapse" data-bs-parent="#physicalExamAccordion${index}">
      <div class="accordion-body bg-light">

        <div class="d-flex justify-content-end mb-3">
          <button class="btn btn-sm btn-secondary me-2" onclick="editPhysicalExam(${index})">
            <i class="bi bi-pencil"></i> Edit
          </button>
          <button class="btn btn-sm btn-danger" onclick="deletePhysicalExam(${index})">
            <i class="bi bi-trash"></i> Delete
          </button>
        </div>

        <div class="row g-3">
          <div class="col-md-4">
            <small class="text-muted">Head:</small>
            <p class="mb-0 fw-semibold">${data.head || 'N/A'}</p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Conjunctiva:</small>
            <p class="mb-0 fw-semibold">
              ${data.conjunctiva_pale ? 'Pale ' : ''}
              ${data.conjunctiva_yellowish ? 'Yellowish ' : ''}
              ${(data.conjunctiva_pale || data.conjunctiva_yellowish) ? '' : 'N/A'}
            </p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Conjunctiva Remarks:</small>
            <p class="mb-0 fw-semibold">${data.conjunctiva_remarks || 'N/A'}</p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Neck:</small>
            <p class="mb-0 fw-semibold">
              ${data.neck_enlarged_thyroid ? 'Enlarged thyroid ' : ''}
              ${data.neck_enlarged_lymph ? 'Enlarged lymph nodes ' : ''}
              ${(data.neck_enlarged_thyroid || data.neck_enlarged_lymph) ? '' : 'N/A'}
            </p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Thorax:</small>
            <p class="mb-0 fw-semibold">
              ${data.thorax_abnormal_cardiac ? 'Abnormal cardiac rate ' : ''}
              ${data.thorax_abnormal_breathing ? 'Abnormal breathing rate ' : ''}
              ${(data.thorax_abnormal_cardiac || data.thorax_abnormal_breathing) ? '' : 'N/A'}
            </p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Thorax Remarks:</small>
            <p class="mb-0 fw-semibold">${data.thorax_remarks || 'N/A'}</p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Chest:</small>
            <p class="mb-0 fw-semibold">${data.chest || 'N/A'}</p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Breast:</small>
            <p class="mb-0 fw-semibold">
              ${data.breast_mass ? 'Mass ' : ''}
              ${data.breast_nipple_discharge ? 'Nipple discharge ' : ''}
              ${data.breast_skin_orange ? 'Skin orange/peeling ' : ''}
              ${data.breast_enlarged_nodes ? 'Enlarged lymph nodes ' : ''}
              ${(data.breast_mass || data.breast_nipple_discharge || data.breast_skin_orange || data.breast_enlarged_nodes) ? '' : 'N/A'}
            </p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Breast Remarks:</small>
            <p class="mb-0 fw-semibold">${data.breast_remarks || 'N/A'}</p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Abdomen:</small>
            <p class="mb-0 fw-semibold">
              ${data.abdomen_enlarged_liver ? 'Enlarged liver ' : ''}
              ${data.abdomen_mass ? 'Mass ' : ''}
              ${data.abdomen_scar ? 'Scar ' : ''}
              ${data.abdomen_tenderness ? 'Tenderness ' : ''}
              ${(data.abdomen_enlarged_liver || data.abdomen_mass || data.abdomen_scar || data.abdomen_tenderness) ? '' : 'N/A'}
            </p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Abdomen Remarks:</small>
            <p class="mb-0 fw-semibold">${data.abdomen_remarks || 'N/A'}</p>
          </div>

          <div class="col-md-4">
            <small class="text-muted">Others:</small>
            <p class="mb-0 fw-semibold">${data.others || 'N/A'}</p>
          </div>

          <div class="col-md-6">
            <small class="text-muted">Administered by:</small>
            <p class="mb-0 fw-semibold">${data.administered_by || 'N/A'}</p>
          </div>

          <div class="col-md-6">
            <small class="text-muted">Remarks:</small>
            <p class="mb-0 fw-semibold">${data.remarks || 'N/A'}</p>
          </div>

        </div>

      </div>
    </div>

  </div>
</div>
    `;
    container.innerHTML += recordHTML;
  });
  
  if (physicalExamsData.length > 0) {
    showSavedRecordsSection();
  }
}

function editPhysicalExam(index) {
  const data = physicalExamsData[index];
  const form = document.querySelector('#physicalExamForm');
  
  form.querySelector('[name="head"]').value = data.head || '';
  form.querySelector('[name="conjunctiva_remarks"]').value = data.conjunctiva_remarks || '';
  form.querySelector('[name="thorax_remarks"]').value = data.thorax_remarks || '';
  form.querySelector('[name="chest"]').value = data.chest || '';
  form.querySelector('[name="breast_remarks"]').value = data.breast_remarks || '';
  form.querySelector('[name="abdomen_remarks"]').value = data.abdomen_remarks || '';
  form.querySelector('[name="others"]').value = data.others || '';
  form.querySelector('[name="administered_by"]').value = data.administered_by || '';
  form.querySelector('[name="remarks"]').value = data.remarks || '';

  form.querySelector('[name="conjunctiva_pale"]').checked = !!data.conjunctiva_pale;
  form.querySelector('[name="conjunctiva_yellowish"]').checked = !!data.conjunctiva_yellowish;

  form.querySelector('[name="neck_enlarged_thyroid"]').checked = !!data.neck_enlarged_thyroid;
  form.querySelector('[name="neck_enlarged_lymph"]').checked = !!data.neck_enlarged_lymph;

  form.querySelector('[name="thorax_abnormal_cardiac"]').checked = !!data.thorax_abnormal_cardiac;
  form.querySelector('[name="thorax_abnormal_breathing"]').checked = !!data.thorax_abnormal_breathing;

  form.querySelector('[name="breast_mass"]').checked = !!data.breast_mass;
  form.querySelector('[name="breast_nipple_discharge"]').checked = !!data.breast_nipple_discharge;
  form.querySelector('[name="breast_skin_orange"]').checked = !!data.breast_skin_orange;
  form.querySelector('[name="breast_enlarged_nodes"]').checked = !!data.breast_enlarged_nodes;

  form.querySelector('[name="abdomen_enlarged_liver"]').checked = !!data.abdomen_enlarged_liver;
  form.querySelector('[name="abdomen_mass"]').checked = !!data.abdomen_mass;
  form.querySelector('[name="abdomen_scar"]').checked = !!data.abdomen_scar;
  form.querySelector('[name="abdomen_tenderness"]').checked = !!data.abdomen_tenderness;
  
  editingPhysicalExamIndex = index;
  new bootstrap.Modal(document.getElementById('physicalExamModal')).show();
}

async function deletePhysicalExam(index) {
  if (!confirm('Are you sure you want to delete this physical exam record?')) return;
  
  const record = physicalExamsData[index];
  
  if (record.id) {
    try {
      await apiRequest(`/admin/employee/${employeeId}/consultation/physical-exams/${record.id}`, 'DELETE');
    } catch (error) {
      console.error('Delete failed:', error);
      return;
    }
  }
  
  physicalExamsData.splice(index, 1);
  safeLocalStorageSet(`physicalExams_${employeeId}`, JSON.stringify(physicalExamsData));
  loadPhysicalExams();
}

// ============================================
// CONSULTATION
// ============================================
function loadConsultations() {
  const container = document.getElementById('consultationRecords');
  if (!container) {
    console.warn('consultationRecords container not found');
    return;
  }
  
  container.innerHTML = '';
  
  consultationsData.forEach((data, index) => {
    const timestamp = data.created_at ? new Date(data.created_at).toLocaleString() : data.timestamp || 'N/A';
    const recordHTML = `
      <div class="accordion mb-3" id="consultationAccordion${index}">
  <div class="accordion-item border-0 shadow-sm">

    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#consultationCollapse${index}">
        <i class="bi bi-journal-medical me-2"></i>
        <strong>Consultation Record</strong> - ${timestamp}
      </button>
    </h2>

    <div id="consultationCollapse${index}" class="accordion-collapse collapse" data-bs-parent="#consultationAccordion${index}">
      <div class="accordion-body bg-light">

        <div class="d-flex justify-content-end mb-3">
          <button class="btn btn-sm btn-secondary me-2" onclick="editConsultation(${index})">
            <i class="bi bi-pencil"></i> Edit
          </button>
          <button class="btn btn-sm btn-danger" onclick="deleteConsultation(${index})">
            <i class="bi bi-trash"></i> Delete
          </button>
        </div>

        <div class="mb-2">
          <small class="text-muted">Chief Complaint:</small>
          <p class="mb-0">${data.chief_complaint || 'N/A'}</p>
        </div>

        <div class="mb-2">
          <small class="text-muted">History of Present Illness:</small>
          <p class="mb-0">${data.history_illness || 'N/A'}</p>
        </div>

        <div class="mb-2">
          <small class="text-muted">Diagnosis:</small>
          <p class="mb-0">${data.diagnosis || 'N/A'}</p>
        </div>

        <div class="mb-2">
          <small class="text-muted">Treatment Plan:</small>
          <p class="mb-0">${data.treatment_plan || 'N/A'}</p>
        </div>

      </div>
    </div>

  </div>
</div>

    `;
    container.innerHTML += recordHTML;
  });
  
  if (consultationsData.length > 0) {
    showSavedRecordsSection();
  }
}

function editConsultation(index) {
  const data = consultationsData[index];
  
  document.querySelector('#consultationForm [name="chief_complaint"]').value = data.chief_complaint || '';
  document.querySelector('#consultationForm [name="history_illness"]').value = data.history_illness || '';
  document.querySelector('#consultationForm [name="diagnosis"]').value = data.diagnosis || '';
  document.querySelector('#consultationForm [name="treatment_plan"]').value = data.treatment_plan || '';
  
  editingConsultationIndex = index;
  new bootstrap.Modal(document.getElementById('consultationModal')).show();
}

async function deleteConsultation(index) {
  if (!confirm('Are you sure you want to delete this consultation record?')) return;
  
  const record = consultationsData[index];
  
  if (record.id) {
    try {
      await apiRequest(`/admin/employee/${employeeId}/consultation/consultations/${record.id}`, 'DELETE');
    } catch (error) {
      return;
    }
  }
  
  consultationsData.splice(index, 1);
  safeLocalStorageSet(`consultations_${employeeId}`, JSON.stringify(consultationsData));
  loadConsultations();
}

// ============================================
// DOCTOR'S ORDER
// ============================================
function loadDoctorOrders() {
  const container = document.getElementById('doctorOrderRecords');
  if (!container) {
    console.warn('doctorOrderRecords container not found');
    return;
  }
  
  container.innerHTML = '';
  
  doctorOrdersData.forEach((data, index) => {
    const timestamp = data.created_at ? new Date(data.created_at).toLocaleString() : data.timestamp || 'N/A';
    const recordHTML = `
      <div class="accordion mb-3" id="doctorOrderAccordion${index}">
  <div class="accordion-item border-0 shadow-sm">

    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#doctorOrderCollapse${index}">
        <i class="bi bi-prescription2 me-2"></i>
        <strong>Doctor's Order</strong> - ${timestamp}
      </button>
    </h2>

    <div id="doctorOrderCollapse${index}" class="accordion-collapse collapse" data-bs-parent="#doctorOrderAccordion${index}">
      <div class="accordion-body bg-light">

        <div class="d-flex justify-content-end mb-3">
          <button class="btn btn-sm btn-secondary me-2" onclick="editDoctorOrder(${index})">
            <i class="bi bi-pencil"></i> Edit
          </button>
          <button class="btn btn-sm btn-danger" onclick="deleteDoctorOrder(${index})">
            <i class="bi bi-trash"></i> Delete
          </button>
        </div>

        <div class="mb-2"><small class="text-muted">Consultation Notes:</small>
          <p class="mb-0">${data.doctors_order || 'N/A'}</p>
        </div>

        <div class="mb-2"><small class="text-muted">Prescription:</small>
          <p class="mb-0">${data.prescription || 'N/A'}</p>
        </div>

        <div class="mb-2"><small class="text-muted">Date of Prescription:</small>
          <p class="mb-0">${data.order_date || 'N/A'}</p>
        </div>

        <div class="mb-2"><small class="text-muted">Diagnosis:</small>
          <p class="mb-0">${data.diagnosis || data.other_diagnosis || 'N/A'}</p>
        </div>

        <div class="mb-2"><small class="text-muted">ICD-11:</small>
          <p class="mb-0">${data.icd11_codes || 'N/A'}</p>
        </div>

        <div class="mb-2"><small class="text-muted">Treatment Plan:</small>
          <p class="mb-0">${data.treatment_plan || 'N/A'}</p>
        </div>

        <div class="mb-2"><small class="text-muted">Disposition:</small>
          <p class="mb-0">${data.disposition || 'N/A'}</p>
        </div>

        <div class="mb-2"><small class="text-muted">Reasons for Discharge:</small>
          <p class="mb-0">${data.reasons_for_discharge || 'N/A'}</p>
        </div>

        <div class="mb-2"><small class="text-muted">Date & Time of Discharge:</small>
          <p class="mb-0">${data.discharge_datetime || 'N/A'}</p>
        </div>

        <div class="mb-2"><small class="text-muted">Remarks:</small>
          <p class="mb-0">${data.order_remarks || 'N/A'}</p>
        </div>

        <div class="mb-2"><small class="text-muted">Schedule Next Visit:</small>
          <p class="mb-0">${data.schedule_next || 'N/A'}</p>
        </div>

      </div>
    </div>

  </div>
</div>
    `;
    container.innerHTML += recordHTML;
  });
  
  if (doctorOrdersData.length > 0) showSavedRecordsSection();
}

function editDoctorOrder(index) {
  const data = doctorOrdersData[index];
  const form = document.querySelector('#doctorOrderForm');

  form.querySelector('[name="doctors_order"]').value = data.doctors_order || '';
  form.querySelector('[name="prescription"]').value = data.prescription || '';
  form.querySelector('[name="order_date"]').value = data.order_date || '';
  form.querySelector('[name="diagnosis"]').value = data.diagnosis || '';
  form.querySelector('[name="icd11_codes"]').value = data.icd11_codes || '';
  form.querySelector('[name="treatment_plan"]').value = data.treatment_plan || '';
  form.querySelector('[name="disposition"]').value = data.disposition || '';
  form.querySelector('[name="reasons_for_discharge"]').value = data.reasons_for_discharge || '';
  form.querySelector('[name="discharge_datetime"]').value = data.discharge_datetime || '';
  form.querySelector('[name="order_remarks"]').value = data.order_remarks || '';

  // Handle "Other" diagnosis
  const otherDiagContainer = document.getElementById('otherDiagnosisContainer');
  if (data.diagnosis === 'Other') {
    otherDiagContainer.style.display = 'block';
    form.querySelector('[name="other_diagnosis"]').value = data.other_diagnosis || '';
  } else {
    otherDiagContainer.style.display = 'none';
  }

  // Handle schedule next visit radio buttons
  if (data.schedule_next === 'yes') {
    form.querySelector('#schedule_yes_do').checked = true;
  } else if (data.schedule_next === 'no') {
    form.querySelector('#schedule_no_do').checked = true;
  } else {
    form.querySelector('#schedule_yes_do').checked = false;
    form.querySelector('#schedule_no_do').checked = false;
  }

  editingDoctorOrderIndex = index;
  new bootstrap.Modal(document.getElementById('doctorOrderModal')).show();
}

async function deleteDoctorOrder(index) {
  if (!confirm('Are you sure you want to delete this doctor\'s order?')) return;
  const record = doctorOrdersData[index];
  if (record.id) {
    try {
      await apiRequest(`/admin/employee/${employeeId}/consultation/doctor-orders/${record.id}`, 'DELETE');
    } catch (error) { return; }
  }
  doctorOrdersData.splice(index, 1);
  safeLocalStorageSet(`doctorOrders_${employeeId}`, JSON.stringify(doctorOrdersData));
  loadDoctorOrders();
}

// ============================================
// LABORATORY
// ============================================
function loadLaboratories() {
  const container = document.getElementById('laboratoryRecords');
  if (!container) {
    console.warn('laboratoryRecords container not found');
    return;
  }
  
  container.innerHTML = '';
  
  laboratoriesData.forEach((data, index) => {
    const timestamp = data.created_at ? new Date(data.created_at).toLocaleString() : data.timestamp || 'N/A';
    const recordHTML = `
      <div class="accordion mb-3" id="laboratoryAccordion${index}">
  <div class="accordion-item border-0 shadow-sm">

    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#laboratoryCollapse${index}">
        <i class="bi bi-file-medical me-2"></i>
        <strong>Laboratory Results</strong> - ${timestamp}
      </button>
    </h2>

    <div id="laboratoryCollapse${index}" class="accordion-collapse collapse" data-bs-parent="#laboratoryAccordion${index}">
      <div class="accordion-body bg-light">

        <div class="d-flex justify-content-end mb-3">
          <button class="btn btn-sm btn-secondary me-2" onclick="editLaboratory(${index})">
            <i class="bi bi-pencil"></i> Edit
          </button>
          <button class="btn btn-sm btn-danger" onclick="deleteLaboratory(${index})">
            <i class="bi bi-trash"></i> Delete
          </button>
        </div>

        <div class="row g-3">
          <div class="col-md-4"><small class="text-muted">Blood Chemistry:</small>
            <p class="mb-0">${data.blood_chemistry || 'N/A'}</p>
          </div>
          <div class="col-md-4"><small class="text-muted">Blood Oxygenation:</small>
            <p class="mb-0">${data.blood_oxygenation || 'N/A'}</p>
          </div>
          <div class="col-md-4"><small class="text-muted">Complete Blood Count:</small>
            <p class="mb-0">${data.complete_blood_count || 'N/A'}</p>
          </div>
          <div class="col-md-4"><small class="text-muted">Immunology:</small>
            <p class="mb-0">${data.immunology || 'N/A'}</p>
          </div>
          <div class="col-md-4"><small class="text-muted">Clinical Chemistry:</small>
            <p class="mb-0">${data.clinical_chemistry || 'N/A'}</p>
          </div>
          <div class="col-md-4"><small class="text-muted">Fecalysis:</small>
            <p class="mb-0">${data.fecalysis || 'N/A'}</p>
          </div>
          <div class="col-md-4"><small class="text-muted">Serology:</small>
            <p class="mb-0">${data.serology || 'N/A'}</p>
          </div>
          <div class="col-md-4"><small class="text-muted">Sputum Microscopy:</small>
            <p class="mb-0">${data.sputum_microscopy || 'N/A'}</p>
          </div>
          <div class="col-md-4"><small class="text-muted">Urinalysis:</small>
            <p class="mb-0">${data.urinalysis || 'N/A'}</p>
          </div>
          <div class="col-md-4"><small class="text-muted">Hematology:</small>
            <p class="mb-0">${data.hematology || 'N/A'}</p>
          </div>
        </div>

        <hr class="my-2">

        <div class="row g-3">
          <div class="col-md-6"><small class="text-muted">Administered By:</small>
            <p class="mb-0">${data.administered_by || 'N/A'}</p>
          </div>
          <div class="col-md-6"><small class="text-muted">Remarks:</small>
            <p class="mb-0">${data.remarks || 'N/A'}</p>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
    `;
    container.innerHTML += recordHTML;
  });
  
  if (laboratoriesData.length > 0) showSavedRecordsSection();
}

function editLaboratory(index) {
  const data = laboratoriesData[index];
  const form = document.querySelector('#laboratoryForm');
  
  form.querySelector('[name="blood_chemistry"]').value = data.blood_chemistry || '';
  form.querySelector('[name="complete_blood_count"]').value = data.complete_blood_count || '';
  form.querySelector('[name="immunology"]').value = data.immunology || '';
  form.querySelector('[name="clinical_chemistry"]').value = data.clinical_chemistry || '';
  form.querySelector('[name="fecalysis"]').value = data.fecalysis || '';
  form.querySelector('[name="serology"]').value = data.serology || '';
  form.querySelector('[name="sputum_microscopy"]').value = data.sputum_microscopy || '';
  form.querySelector('[name="urinalysis"]').value = data.urinalysis || '';
  form.querySelector('[name="hematology"]').value = data.hematology || '';
  form.querySelector('[name="administered_by"]').value = data.administered_by || '';
  form.querySelector('[name="remarks"]').value = data.remarks || '';
  
  editingLaboratoryIndex = index;
  new bootstrap.Modal(document.getElementById('laboratoryModal')).show();
}

async function deleteLaboratory(index) {
  if (!confirm('Are you sure you want to delete this laboratory record?')) return;
  const record = laboratoriesData[index];
  if (record.id) {
    try {
      await apiRequest(`/admin/employee/${employeeId}/consultation/laboratories/${record.id}`, 'DELETE');
    } catch (error) { return; }
  }
  laboratoriesData.splice(index, 1);
  safeLocalStorageSet(`laboratories_${employeeId}`, JSON.stringify(laboratoriesData));
  loadLaboratories();
}

// ============================================
// FORM HANDLERS
// ============================================
function initializeFormHandlers() {
  console.log('Initializing form handlers...'); -``
  
  // Vital Signs Form
  const vitalSignsForm = document.getElementById('vitalSignsForm');
  if (vitalSignsForm) {
    vitalSignsForm.addEventListener('submit', async function(e) {
      e.preventDefault();
      console.log('Vital Signs form submitted');
      
      const formData = new FormData(this);
      const data = Object.fromEntries(formData);
      
      try {
        if (editingVitalSignIndex !== null) {
          const record = vitalSignsData[editingVitalSignIndex];
          if (record.id) {
            const result = await apiRequest(`/admin/employee/${employeeId}/consultation/vital-signs/${record.id}`, 'PUT', data);
            vitalSignsData[editingVitalSignIndex] = result.data;
          } else {
            vitalSignsData[editingVitalSignIndex] = data;
          }
          editingVitalSignIndex = null;
        } else {
          const result = await apiRequest(`/admin/employee/${employeeId}/consultation/vital-signs`, 'POST', data);
          vitalSignsData.unshift(result.data);
        }
        
        safeLocalStorageSet(`vitalSigns_${employeeId}`, JSON.stringify(vitalSignsData));
        loadVitalSigns();
        this.reset();
        bootstrap.Modal.getInstance(document.getElementById('vitalSignsModal')).hide();
        alert('Vital signs saved successfully!');
      } catch (error) {
        console.error('Error saving vital signs:', error);
      }
    });
    console.log('Vital Signs form handler attached');
  } else {
    console.warn('vitalSignsForm not found');
  }

  // Physical Exam Form
  const physicalExamForm = document.getElementById('physicalExamForm');
  if (physicalExamForm) {
    physicalExamForm.addEventListener('submit', async function(e) {
      e.preventDefault();
      console.log('Physical Exam form submitted');
      
      const formData = new FormData(this);
      const data = Object.fromEntries(formData);
      
      try {
        if (editingPhysicalExamIndex !== null) {
          const record = physicalExamsData[editingPhysicalExamIndex];
          if (record.id) {
            const result = await apiRequest(`/admin/employee/${employeeId}/consultation/physical-exams/${record.id}`, 'PUT', data);
            physicalExamsData[editingPhysicalExamIndex] = result.data;
          } else {
            physicalExamsData[editingPhysicalExamIndex] = data;
          }
          editingPhysicalExamIndex = null;
        } else {
          const result = await apiRequest(`/admin/employee/${employeeId}/consultation/physical-exams`, 'POST', data);
          physicalExamsData.unshift(result.data);
        }
        
        safeLocalStorageSet(`physicalExams_${employeeId}`, JSON.stringify(physicalExamsData));
        loadPhysicalExams();
        this.reset();
        bootstrap.Modal.getInstance(document.getElementById('physicalExamModal')).hide();
        alert('Physical exam saved successfully!');
      } catch (error) {
        console.error('Error saving physical exam:', error);
      }
    });
    console.log('Physical Exam form handler attached');
  }

  // Consultation Form
  const consultationForm = document.getElementById('consultationForm');
  if (consultationForm) {
    consultationForm.addEventListener('submit', async function(e) {
      e.preventDefault();
      console.log('Consultation form submitted');
      
      const formData = new FormData(this);
      const data = Object.fromEntries(formData);
      
      try {
        if (editingConsultationIndex !== null) {
          const record = consultationsData[editingConsultationIndex];
          if (record.id) {
            const result = await apiRequest(`/admin/employee/${employeeId}/consultation/consultations/${record.id}`, 'PUT', data);
            consultationsData[editingConsultationIndex] = result.data;
          } else {
            consultationsData[editingConsultationIndex] = data;
          } 
          editingConsultationIndex = null;
        } else {
          const result = await apiRequest(`/admin/employee/${employeeId}/consultation/consultations`, 'POST', data);
          consultationsData.unshift(result.data);
        }
        
        safeLocalStorageSet(`consultations_${employeeId}`, JSON.stringify(consultationsData));
        loadConsultations();
        this.reset();
        bootstrap.Modal.getInstance(document.getElementById('consultationModal')).hide();
        alert('Consultation saved successfully!');
      } catch (error) {
        console.error('Error saving consultation:', error);
      }
    });
    console.log('Consultation form handler attached');
  }

  // Doctor's Order Form
  const doctorOrderForm = document.getElementById('doctorOrderForm');
  if (doctorOrderForm) {
    doctorOrderForm.addEventListener('submit', async function(e) {
      e.preventDefault();
      console.log('Doctor Order form submitted');
      
      const formData = new FormData(this);
      const data = Object.fromEntries(formData);
      
      try {
        if (editingDoctorOrderIndex !== null) {
          const record = doctorOrdersData[editingDoctorOrderIndex];
          if (record.id) {
            const result = await apiRequest(`/admin/employee/${employeeId}/consultation/doctor-orders/${record.id}`, 'PUT', data);
            doctorOrdersData[editingDoctorOrderIndex] = result.data;
          } else {
            doctorOrdersData[editingDoctorOrderIndex] = data;
          }
          editingDoctorOrderIndex = null;
        } else {
          const result = await apiRequest(`/admin/employee/${employeeId}/consultation/doctor-orders`, 'POST', data);
          doctorOrdersData.unshift(result.data);
        }
        
        safeLocalStorageSet(`doctorOrders_${employeeId}`, JSON.stringify(doctorOrdersData));
        loadDoctorOrders();
        this.reset();
        bootstrap.Modal.getInstance(document.getElementById('doctorOrderModal')).hide();
        alert('Doctor\'s order saved successfully!');
      } catch (error) {
        console.error('Error saving doctor order:', error);
      }
    });
    console.log('Doctor Order form handler attached');
  }

  // Laboratory Form
  const laboratoryForm = document.getElementById('laboratoryForm');
  if (laboratoryForm) {
    laboratoryForm.addEventListener('submit', async function(e) {
      e.preventDefault();
      console.log('Laboratory form submitted');
      
      const formData = new FormData(this);
      const data = Object.fromEntries(formData);
      
      try {
        if (editingLaboratoryIndex !== null) {
          const record = laboratoriesData[editingLaboratoryIndex];
          if (record.id) {
            const result = await apiRequest(`/admin/employee/${employeeId}/consultation/laboratories/${record.id}`, 'PUT', data);
            laboratoriesData[editingLaboratoryIndex] = result.data;
          } else {
            laboratoriesData[editingLaboratoryIndex] = data;
          }
          editingLaboratoryIndex = null;
        } else {
          const result = await apiRequest(`/admin/employee/${employeeId}/consultation/laboratories`, 'POST', data);
          laboratoriesData.unshift(result.data);
        }
        
        safeLocalStorageSet(`laboratories_${employeeId}`, JSON.stringify(laboratoriesData));
        loadLaboratories();
        this.reset();
        bootstrap.Modal.getInstance(document.getElementById('laboratoryModal')).hide();
        alert('Laboratory record saved successfully!');
      } catch (error) {
        console.error('Error saving laboratory record:', error);
      }
    });
    console.log('Laboratory form handler attached');
  }
}


// PRESCRIBE MEDICATION MODAL - Bootstrap 5 Version
const medications = [
  // edit for database pls thx
    { id: 1, name: 'Acetaminophen', strength: '500mg', otc: true, inventory: 24, quantity: 0 },
    { id: 2, name: 'BENADRYL® Extra Strength Allergy Relief Antihistamine Tablets with 50 mg of Diphenhydramine HCl', strength: '50mg', otc: true, inventory: 24, quantity: 0 },
    { id: 3, name: 'Ibuprofen', strength: '500mg', otc: true, inventory: 24, quantity: 0 },
    { id: 4, name: 'Paracetamol', strength: '500mg', otc: true, inventory: 21, quantity: 0 },
    { id: 5, name: 'Amoxicillin', strength: '250mg', otc: false, inventory: 18, quantity: 0 },
    { id: 6, name: 'Aspirin', strength: '100mg', otc: true, inventory: 30, quantity: 0 }
];

let filteredMedications = [...medications];

function renderTable() {
    const tbody = document.getElementById('medicationTableBody');
    if (!tbody) return;
    
    tbody.innerHTML = '';

    filteredMedications.forEach(med => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${med.name}</td>
            <td>${med.strength}</td>
            <td>${med.otc ? '<span class="otc-badge yes">Yes</span>' : '<span class="otc-badge no">No</span>'}</td>
            <td>${med.inventory}</td>
            <td>
                <div class="quantity-controls">
                    <button class="qty-btn" onclick="decreaseQty(${med.id})" ${med.quantity === 0 ? 'disabled' : ''}>−</button>
                    <span class="qty-display">${med.quantity}</span>
                    <button class="qty-btn" onclick="increaseQty(${med.id})" ${med.quantity >= med.inventory ? 'disabled' : ''}>+</button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });

    updateSelectedSection();
}

function increaseQty(id) {
    const med = medications.find(m => m.id === id);
    if (med && med.quantity < med.inventory) {
        med.quantity++;
        renderTable();
    }
}

function decreaseQty(id) {
    const med = medications.find(m => m.id === id);
    if (med && med.quantity > 0) {
        med.quantity--;
        renderTable();
    }
}

function updateSelectedSection() {
    const selected = medications.filter(m => m.quantity > 0);
    const section = document.getElementById('selectedSection');
    const list = document.getElementById('selectedList');
    const prescribeBtn = document.getElementById('prescribeBtn');

    if (!section || !list || !prescribeBtn) return;

    if (selected.length > 0) {
        section.style.display = 'block';
        prescribeBtn.disabled = false;
        list.innerHTML = selected.map(med => `
            <div class="selected-item">
                <span><strong>${med.name}</strong> (${med.strength})</span>
                <span>x ${med.quantity}</span>
            </div>
        `).join('');
    } else {
        section.style.display = 'none';
        prescribeBtn.disabled = true;
    }
}

function filterMedications() {
    const searchInput = document.getElementById('searchInput');
    const filterSelect = document.getElementById('filterSelect');
    
    if (!searchInput || !filterSelect) return;
    
    const searchTerm = searchInput.value.toLowerCase();
    const filterType = filterSelect.value;

    filteredMedications = medications.filter(med => {
        const matchesSearch = med.name.toLowerCase().includes(searchTerm);
        const matchesFilter = 
            filterType === '' || 
            (filterType === 'otc' && med.otc) || 
            (filterType === 'prescription' && !med.otc);
        
        return matchesSearch && matchesFilter;
    });

    renderTable();
}

function clearFilters() {
    const searchInput = document.getElementById('searchInput');
    const filterSelect = document.getElementById('filterSelect');
    
    if (searchInput) searchInput.value = '';
    if (filterSelect) filterSelect.value = '';
    filterMedications();
}

function prescribeMedications() {

    // your logic...
    const selected = medications.filter(m => m.quantity > 0);
    const prescriptionTextarea = document.querySelector('textarea[name="prescription"]');

    const prescriptionText = selected
        .map(m => `${m.name} (${m.strength}) - Qty: ${m.quantity}`)
        .join('\n');

    if (prescriptionTextarea) {
        prescriptionTextarea.value = prescriptionText;
    }

    alert(`Prescribed ${selected.length} medication(s):\n${selected.map(m => `${m.name} x${m.quantity}`).join('\n')}`);

    medications.forEach(m => m.quantity = 0);

    const presEl = document.getElementById('prescriptionModal');
    const docEl = document.getElementById('doctorOrderModal');

    const presModal = bootstrap.Modal.getInstance(presEl) 
                       || new bootstrap.Modal(presEl);
    presModal.hide();

    presEl.addEventListener('hidden.bs.modal', function openNext() {
        const docModal = new bootstrap.Modal(docEl);
        docModal.show();
        presEl.removeEventListener('hidden.bs.modal', openNext);
    });
}

// Initialize table when modal is shown
document.addEventListener('shown.bs.modal', function (event) {
    if (event.target.id === 'prescriptionModal') {
        renderTable();
    }
});