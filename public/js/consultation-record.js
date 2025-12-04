/**
 * Consultation Records Management System
 * Saves to DATABASE (primary) + localStorage (backup)
 */

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
  const employeeIdElement = document.querySelector('[data-employee-id]');
  if (employeeIdElement) {
    employeeId = employeeIdElement.getAttribute('data-employee-id');
  }
  
  loadAllRecordsFromDatabase();
  initializeFormHandlers();
});

// ============================================
// API HELPER FUNCTIONS
// ============================================
async function apiRequest(url, method = 'GET', data = null) {
  try {
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

// ============================================
// LOAD ALL RECORDS FROM DATABASE
// ============================================
async function loadAllRecordsFromDatabase() {
  try {
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
    
  } catch (error) {
    console.error('Failed to load records from database, using localStorage:', error);
    loadFromLocalStorage();
  }
}

function loadFromLocalStorage() {
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
  if (!container) return;
  
  container.innerHTML = '';
  
  vitalSignsData.forEach((data, index) => {
    const timestamp = data.created_at ? new Date(data.created_at).toLocaleString() : data.timestamp;
    const recordHTML = `
      <div class="card mb-3 border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #7d3c4d; color: white;">
          <span><i class="bi bi-heart-pulse me-2"></i><strong>Vital Signs</strong> - ${timestamp}</span>
          <div>
            <button class="btn btn-sm btn-light me-2" onclick="editVitalSign(${index})">
              <i class="bi bi-pencil"></i> Edit
            </button>
            <button class="btn btn-sm btn-danger" onclick="deleteVitalSign(${index})">
              <i class="bi bi-trash"></i> Delete
            </button>
          </div>
        </div>
        <div class="card-body bg-light">
          <div class="row g-3">
            <div class="col-md-4">
              <small class="text-muted">Body Temperature:</small>
              <p class="mb-0 fw-semibold">${data.body_temperature || 'N/A'}</p>
            </div>
            <div class="col-md-4">
              <small class="text-muted">Heart Rate:</small>
              <p class="mb-0 fw-semibold">${data.heart_rate} bpm</p>
            </div>
            <div class="col-md-4">
              <small class="text-muted">Pulse Rate:</small>
              <p class="mb-0 fw-semibold">${data.pulse_rate || 'N/A'}</p>
            </div>
            <div class="col-md-4">
              <small class="text-muted">BP Systolic:</small>
              <p class="mb-0 fw-semibold">${data.bp_systolic} mmHg</p>
            </div>
            <div class="col-md-4">
              <small class="text-muted">BP Diastolic:</small>
              <p class="mb-0 fw-semibold">${data.bp_diastolic} mmHg</p>
            </div>
            <div class="col-md-4">
              <small class="text-muted">Respiratory Rate:</small>
              <p class="mb-0 fw-semibold">${data.respiratory_rate || 'N/A'}</p>
            </div>
            <div class="col-md-6">
              <small class="text-muted">BP Assessment:</small>
              <p class="mb-0 fw-semibold">${data.bp_assessment}</p>
            </div>
            <div class="col-md-6">
              <small class="text-muted">Administered by:</small>
              <p class="mb-0 fw-semibold">${data.administered_by}</p>
            </div>
          </div>
          ${data.remarks ? `<hr class="my-2"><div><small class="text-muted">Remarks:</small><p class="mb-0">${data.remarks}</p></div>` : ''}
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
  if (!container) return;
  
  container.innerHTML = '';
  
  physicalExamsData.forEach((data, index) => {
    const timestamp = data.created_at ? new Date(data.created_at).toLocaleString() : data.timestamp;
    const recordHTML = `
      <div class="card mb-3 border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #7d3c4d; color: white;">
          <span><i class="bi bi-clipboard-pulse me-2"></i><strong>Physical Exam</strong> - ${timestamp}</span>
          <div>
            <button class="btn btn-sm btn-light me-2" onclick="editPhysicalExam(${index})">
              <i class="bi bi-pencil"></i> Edit
            </button>
            <button class="btn btn-sm btn-danger" onclick="deletePhysicalExam(${index})">
              <i class="bi bi-trash"></i> Delete
            </button>
          </div>
        </div>
        <div class="card-body bg-light">
          <div class="row g-3">
            <div class="col-md-6">
              <small class="text-muted">General Appearance:</small>
              <p class="mb-0">${data.general_appearance || 'N/A'}</p>
            </div>
            <div class="col-md-6">
              <small class="text-muted">Head & Neck:</small>
              <p class="mb-0">${data.head_neck || 'N/A'}</p>
            </div>
            <div class="col-md-6">
              <small class="text-muted">Chest & Lungs:</small>
              <p class="mb-0">${data.chest_lungs || 'N/A'}</p>
            </div>
            <div class="col-md-6">
              <small class="text-muted">Heart & Cardiovascular:</small>
              <p class="mb-0">${data.heart_cardiovascular || 'N/A'}</p>
            </div>
            <div class="col-md-6">
              <small class="text-muted">Abdomen:</small>
              <p class="mb-0">${data.abdomen || 'N/A'}</p>
            </div>
            <div class="col-md-6">
              <small class="text-muted">Extremities:</small>
              <p class="mb-0">${data.extremities || 'N/A'}</p>
            </div>
          </div>
          ${data.additional_notes ? `<hr class="my-2"><div><small class="text-muted">Additional Notes:</small><p class="mb-0">${data.additional_notes}</p></div>` : ''}
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
  
  document.querySelector('#physicalExamForm [name="general_appearance"]').value = data.general_appearance || '';
  document.querySelector('#physicalExamForm [name="head_neck"]').value = data.head_neck || '';
  document.querySelector('#physicalExamForm [name="chest_lungs"]').value = data.chest_lungs || '';
  document.querySelector('#physicalExamForm [name="heart_cardiovascular"]').value = data.heart_cardiovascular || '';
  document.querySelector('#physicalExamForm [name="abdomen"]').value = data.abdomen || '';
  document.querySelector('#physicalExamForm [name="extremities"]').value = data.extremities || '';
  document.querySelector('#physicalExamForm [name="additional_notes"]').value = data.additional_notes || '';
  
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
  if (!container) return;
  
  container.innerHTML = '';
  
  consultationsData.forEach((data, index) => {
    const timestamp = data.created_at ? new Date(data.created_at).toLocaleString() : data.timestamp;
    const recordHTML = `
      <div class="card mb-3 border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #7d3c4d; color: white;">
          <span><i class="bi bi-journal-medical me-2"></i><strong>Consultation Record</strong> - ${timestamp}</span>
          <div>
            <button class="btn btn-sm btn-light me-2" onclick="editConsultation(${index})">
              <i class="bi bi-pencil"></i> Edit
            </button>
            <button class="btn btn-sm btn-danger" onclick="deleteConsultation(${index})">
              <i class="bi bi-trash"></i> Delete
            </button>
          </div>
        </div>
        <div class="card-body bg-light">
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
  if (!container) return;
  
  container.innerHTML = '';
  
  doctorOrdersData.forEach((data, index) => {
    const timestamp = data.created_at ? new Date(data.created_at).toLocaleString() : data.timestamp;
    const recordHTML = `
      <div class="card mb-3 border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #7d3c4d; color: white;">
          <span><i class="bi bi-prescription2 me-2"></i><strong>Doctor's Order</strong> - ${timestamp}</span>
          <div>
            <button class="btn btn-sm btn-light me-2" onclick="editDoctorOrder(${index})">
              <i class="bi bi-pencil"></i> Edit
            </button>
            <button class="btn btn-sm btn-danger" onclick="deleteDoctorOrder(${index})">
              <i class="bi bi-trash"></i> Delete
            </button>
          </div>
        </div>
        <div class="card-body bg-light">
          <div class="mb-2"><small class="text-muted">Medication Orders:</small><p class="mb-0">${data.medication_orders || 'N/A'}</p></div>
          <div class="mb-2"><small class="text-muted">Laboratory Tests Ordered:</small><p class="mb-0">${data.lab_tests_ordered || 'N/A'}</p></div>
          <div class="mb-2"><small class="text-muted">Special Instructions:</small><p class="mb-0">${data.special_instructions || 'N/A'}</p></div>
        </div>
      </div>
    `;
    container.innerHTML += recordHTML;
  });
  
  if (doctorOrdersData.length > 0) showSavedRecordsSection();
}

function editDoctorOrder(index) {
  const data = doctorOrdersData[index];
  document.querySelector('#doctorOrderForm [name="medication_orders"]').value = data.medication_orders || '';
  document.querySelector('#doctorOrderForm [name="lab_tests_ordered"]').value = data.lab_tests_ordered || '';
  document.querySelector('#doctorOrderForm [name="special_instructions"]').value = data.special_instructions || '';
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
  if (!container) return;
  
  container.innerHTML = '';
  
  laboratoriesData.forEach((data, index) => {
    const timestamp = data.created_at ? new Date(data.created_at).toLocaleString() : data.timestamp;
    const recordHTML = `
      <div class="card mb-3 border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #7d3c4d; color: white;">
          <span><i class="bi bi-file-medical me-2"></i><strong>Laboratory Results</strong> - ${timestamp}</span>
          <div>
            <button class="btn btn-sm btn-light me-2" onclick="editLaboratory(${index})">
              <i class="bi bi-pencil"></i> Edit
            </button>
            <button class="btn btn-sm btn-danger" onclick="deleteLaboratory(${index})">
              <i class="bi bi-trash"></i> Delete
            </button>
          </div>
        </div>
        <div class="card-body bg-light">
          <div class="row g-3">
            <div class="col-md-6"><small class="text-muted">Test Type:</small><p class="mb-0 fw-semibold">${data.test_type || 'N/A'}</p></div>
            <div class="col-md-6"><small class="text-muted">Date of Test:</small><p class="mb-0 fw-semibold">${data.test_date || 'N/A'}</p></div>
          </div>
          <hr class="my-2">
          <div class="mb-2"><small class="text-muted">Test Results:</small><p class="mb-0">${data.test_results || 'N/A'}</p></div>
          <div><small class="text-muted">Conducted By:</small><p class="mb-0">${data.conducted_by || 'N/A'}</p></div>
        </div>
      </div>
    `;
    container.innerHTML += recordHTML;
  });
  
  if (laboratoriesData.length > 0) showSavedRecordsSection();
}

function editLaboratory(index) {
  const data = laboratoriesData[index];
  document.querySelector('#laboratoryForm [name="test_type"]').value = data.test_type || '';
  document.querySelector('#laboratoryForm [name="test_results"]').value = data.test_results || '';
  document.querySelector('#laboratoryForm [name="test_date"]').value = data.test_date || '';
  document.querySelector('#laboratoryForm [name="conducted_by"]').value = data.conducted_by || '';
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
  document.getElementById('vitalSignsForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
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
  });

  document.getElementById('physicalExamForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
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
  });

  document.getElementById('consultationForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
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
  });

  document.getElementById('doctorOrderForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
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
  });

  document.getElementById('laboratoryForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
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
      const result = await apiRequest(`/admin/employee/${employeeId}/consultation/laboratories  `, 'POST', data);
      laboratoriesData.unshift(result.data);
    }
    
    safeLocalStorageSet(`laboratories_${employeeId}`, JSON.stringify(laboratoriesData));
    loadLaboratories();
    this.reset();
    bootstrap.Modal.getInstance(document.getElementById('laboratoryModal')).hide();
  });
}