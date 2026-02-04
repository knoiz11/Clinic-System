// Employee search initialization
function initEmployeeSearch() {
    const employeesDataElement = document.getElementById('employeesData');
    if (!employeesDataElement) return;

    const employees = JSON.parse(employeesDataElement.textContent);
    const searchInput = document.getElementById('employee_search');
    const resultsDiv = document.getElementById('employee_results');
    const hiddenInput = document.getElementById('employee_id');

    if (!searchInput || !resultsDiv || !hiddenInput) return;

    window.selectEmployee = function(id, name) {
        searchInput.value = name;
        hiddenInput.value = id;
        resultsDiv.style.display = 'none';
    }

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        if (!query) {
            resultsDiv.style.display = 'none';
            return;
        }

        const filtered = employees.filter(emp => emp.name.toLowerCase().includes(query));

        if (filtered.length) {
            let html = '<table class="table table-hover mb-0" style="font-size:0.9rem;"><tbody>';
            filtered.forEach(emp => {
                const safeName = emp.name.replace(/'/g, "\\'");
                html += `<tr style="cursor:pointer;" onclick="selectEmployee(${emp.id}, '${safeName}')">
                            <td>${emp.name}</td>
                         </tr>`;
            });
            html += '</tbody></table>';
            resultsDiv.innerHTML = html;
            resultsDiv.style.display = 'block';
        } else {
            resultsDiv.innerHTML = '<div class="p-3 text-muted">No employees found</div>';
            resultsDiv.style.display = 'block';
        }
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
            resultsDiv.style.display = 'none';
        }
    });
}

// Service templates with employee search input included
const templates = {
     'vital-signs': `
        <form id="serviceForm" class="row g-3" data-service="vital-signs" novalidate>
          <div class="col-md-4">
            <label class="form-label">Body Temperature</label>
            <input name="body_temperature" class="form-control" type="text" />
          </div>
          <div class="col-md-4">
            <label class="form-label">Heart Rate <span class="text-danger">*</span></label>
            <input name="heart_rate" required class="form-control" type="text" />
          </div>
          <div class="col-md-4">
            <label class="form-label">Pulse Rate</label>
            <input name="pulse_rate" class="form-control" type="text" />
          </div>

          <div class="col-md-4">
            <label class="form-label">Blood Pressure Systolic <span class="text-danger">*</span></label>
            <input name="bp_systolic" required class="form-control" type="text" />
          </div>
          <div class="col-md-4">
            <label class="form-label">Blood Pressure Diastolic <span class="text-danger">*</span></label>
            <input name="bp_diastolic" required class="form-control" type="text" />
          </div>
          <div class="col-md-4">
            <label class="form-label">Respiratory Rate</label>
            <input name="respiratory_rate" class="form-control" type="text" />
          </div>

          <div class="col-md-6">
            <label class="form-label">BP Measurement Assessment <span class="text-danger">*</span></label>
            <input name="bp_assessment" required class="form-control" type="text" />
          </div>
          <div class="col-md-6">
            <label class="form-label">Administered by <span class="text-danger">*</span></label>
            <input name="administered_by" required class="form-control" type="text" />
          </div>

          <div class="col-12">
            <label class="form-label">Remarks</label>
            <textarea name="remarks" class="form-control" rows="3"></textarea>
          </div>

          <div class="col-12 text-end">
            <button type="submit" class="btn service-btn btn-primary">Save Vital Signs</button>
          </div>
        </form>
      `,
    'physical-exam': `
        <form id="serviceForm" class="row g-3" data-service="physical-exam" novalidate>

    <div class="row g-4">
        <div class="col-md-4">
            <label class="form-label">Head</label>
            <textarea name="head" class="form-control" rows="2"></textarea>
        </div>

        <div class="col-md-4">
            <label class="form-label">Conjunctiva (eye anatomy)</label>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="conjunctiva_pale" value="1"> <label class="form-check-label">Pale</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="conjunctiva_yellowish" value="1"> <label class="form-check-label">Yellowish</label></div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Conjunctiva Remarks</label>
            <textarea name="conjunctiva_remarks" class="form-control" rows="2"></textarea>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-md-4">
            <label class="form-label">Neck</label>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="neck_enlarged_thyroid" value="1"> <label class="form-check-label">Enlarged thyroid</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="neck_enlarged_lymph" value="1"> <label class="form-check-label">Enlarged lymph nodes</label></div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Thorax</label>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="thorax_abnormal_cardiac" value="1"> <label class="form-check-label">Abnormal cardiac rate</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="thorax_abnormal_breathing" value="1"> <label class="form-check-label">Abnormal breathing rate</label></div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Thorax Remarks</label>
            <textarea name="thorax_remarks" class="form-control" rows="2"></textarea>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-md-4">
            <label class="form-label">Chest</label>
            <textarea name="chest" class="form-control" rows="2"></textarea>
        </div>

        <div class="col-md-4">
            <label class="form-label">Breast</label>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="breast_mass" value="1"> <label class="form-check-label">Mass</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="breast_nipple_discharge" value="1"> <label class="form-check-label">Nipple discharge</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="breast_skin_orange" value="1"> <label class="form-check-label">Skin orange or peeling</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="breast_enlarged_nodes" value="1"> <label class="form-check-label">Enlarged auxiliary lymph nodes</label></div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Breast Remarks</label>
            <textarea name="breast_remarks" class="form-control" rows="2"></textarea>
        </div>
    </div>

    <div class="row g-4 mt-1">
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
    </div>

    <div class="row g-4 mt-1">
        <div class="col-md-6">
            <label class="form-label">Administered by <span class="text-danger">*</span></label>
            <input name="administered_by" class="form-control" type="text" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Remarks</label>
            <textarea name="remarks" class="form-control" rows="2"></textarea>
        </div>
    </div>

    <div class="text-end mt-4">
        <button type="submit" class="btn service-btn btn-primary" style="color:white;">
            Save Physical Exam
        </button>
    </div>
</form>
      `,
    'laboratory': `
      <form id="serviceForm" class="row g-3" data-service="laboratory" novalidate>
      <input type="hidden" name="service_type" value="laboratory" />
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Blood Chemistry</label>
          <textarea name="blood_chemistry" class="form-control" rows="2"></textarea>
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
          <label class="form-label">Administered by <span class="text-danger">*</span></label>
          <input name="administered_by" class="form-control" type="text" required />
        </div>
        <div class="col-md-6">
          <label class="form-label">Remarks</label>
          <textarea name="remarks" class="form-control" rows="2"></textarea>
        </div>

        <div class="col-12 text-end">
          <button type="submit" class="btn service-btn btn-primary">Save Laboratory</button>
        </div>
      </div>
      </form>
  `,
    'doctors-order': `
        <form id="serviceForm" class="row g-3" data-service="doctors-order" novalidate>
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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#prescriptionModal" style="background-color: var(--ccp-primary-color-gold) !important; color: var(--ccp-light) !important; border-color: var(--ccp-primary-color-gold) !important;">
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
            <button type="button" class="btn btn-primary" style="background-color: var(--ccp-primary-color-gold) !important; color: var(--ccp-light) !important; border-color: var(--ccp-primary-color-gold) !important;">APPOINT</button>
            <button type="submit" class="btn btn-primary">SAVE</button>
          </div>
        </form>
      `
};
// ✅ capture form data + show read-only form preview
function attachFormSaveListener() {
    const form = document.getElementById("serviceForm");
    if (!form) return;

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const data = new FormData(form);
        const finalData = {};

        // also get checkboxes and radio properly
        form.querySelectorAll("input, textarea, select").forEach(field => {
            if (field.type === "checkbox") {
                finalData[field.name] = field.checked ? "Yes" : "No";
            } else if (field.type === "radio") {
                if (field.checked) finalData[field.name] = field.value;
            } else {
                finalData[field.name] = data.get(field.name) || "";
            }
        });

        renderPreviewForm(finalData);
    });
}

function renderPreviewForm(data) {
    const container = document.getElementById("service-view-container");
    if (!container) {
        alert("⚠ Add <div id='service-view-container'></div> in HTML!");
        return;
    }

    let html = `
      <div class="card p-4 mt-4">
        <h5 class="mb-3 text-maroon fw-bold">📁 Your Filled Up Form</h5>
        <form class="row g-3">
    `;

    for (let key in data) {
        html += `
          <div class="col-md-6">
            <label class="form-label">${key.replace(/_/g, " ")}</label>
            <input class="form-control" type="text" value="${data[key]}" readonly disabled />
          </div>
        `;
    }

    html += `</form></div>`;
    container.innerHTML = html;
}

document.querySelectorAll('.service-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const key = btn.id;

        document.getElementById('service-form-container').innerHTML = templates[key] || '';
        attachFormSaveListener(); // ✅ enables save + preview after form loads

        // Initialize ICD-11 autocompleter if the field is present and lib loaded
        (function initICDAutocomplete() {
            const icd = document.getElementById('icd11_codes') || document.querySelector('input[name="icd11_codes"], input[name="icd11"]');
            if (!icd) return;
            if (!icd.id) icd.id = 'icd11_codes';
            if (window.Def && Def.Autocompleter && typeof Def.Autocompleter.Search === 'function') {
                try {
                    new Def.Autocompleter.Search('icd11_codes', 'https://clinicaltables.nlm.nih.gov/api/icd11_codes/v3/search?sf=code,title', {
                        tableFormat: true,
                        valueCols: [0],
                        colHeaders: ['Code', 'Title', 'Type']
                    });

                    // Add change listener to capture both code and title
                    icd.addEventListener('change', function() {
                        const selectedValue = icd.value;
                        const titleInput = document.getElementById('icd11_titles') || document.querySelector('input[name="icd11_titles"]');
                        
                        if (selectedValue && titleInput) {
                            // Extract title from the autocompleter's data
                            const listItems = document.querySelectorAll('.autocomp_selected');
                            if (listItems.length > 0) {
                                const selectedItem = listItems[listItems.length - 1];
                                const title = selectedItem.getAttribute('data-title') || selectedItem.textContent.split('\n')[1] || '';
                                titleInput.value = title;
                                console.log('Code:', selectedValue, 'Title:', title);
                            }
                        }
                    });
                } catch (err) {
                    console.warn('ICD autocompleter init failed', err);
                }
            } else {
                setTimeout(initICDAutocomplete, 250);
            }
        })();
    });
});

document.addEventListener('change', function(event) {
    if (event.target.name === 'diagnosis') {
        const otherDiagnosisContainer = document.getElementById('otherDiagnosisContainer');
        if (event.target.value === 'Other') {
            otherDiagnosisContainer.style.display = 'block';
        } else {
            otherDiagnosisContainer.style.display = 'none';
        }
    }
});

// PRESCRIBE MEDICATION MODAL - Bootstrap 5 Version
const medications = [
  // connect to database pls thx
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
    const selected = medications.filter(m => m.quantity > 0);
    const prescriptionTextarea = document.querySelector('textarea[name="prescription"]');
    
    const prescriptionText = selected.map(m => `${m.name} (${m.strength}) - Qty: ${m.quantity}`).join('\n');
    
    if (prescriptionTextarea) {
        prescriptionTextarea.value = prescriptionText;
    }
    
    alert(`Prescribed ${selected.length} medication(s):\n${selected.map(m => `${m.name} x${m.quantity}`).join('\n')}`);
    
    medications.forEach(m => m.quantity = 0);
    
    const modal = bootstrap.Modal.getInstance(document.getElementById('prescriptionModal'));
    if (modal) {
        modal.hide('prescriptionModal');
    }
}

// Initialize table when modal is shown
document.addEventListener('shown.bs.modal', function (event) {
    if (event.target.id === 'prescriptionModal') {
        renderTable();
    }
});