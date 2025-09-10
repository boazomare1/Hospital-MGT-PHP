// Bed Transfer List Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    setupSidebarToggle();
    setupFormValidation();
    setupPatientSearch();
    setupLocationDependency();
    setupExportPrint();
});

// Sidebar Toggle Functionality
function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
}

// Form Validation
function setupFormValidation() {
    const form = document.querySelector('form[name="cbform1"]');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });
    }
}

function validateForm() {
    const location = document.getElementById('location');
    const customer = document.getElementById('customer');
    
    let isValid = true;
    clearErrors();
    
    if (location && !location.value) {
        showError(location, 'Please select a location');
        isValid = false;
    }
    
    if (customer && customer.value.trim() === '') {
        showWarning(customer, 'Please enter a patient name for better results');
    }
    
    return isValid;
}

function showError(field, message) {
    clearError(field);
    field.style.borderColor = '#dc3545';
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.style.color = '#dc3545';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

function showWarning(field, message) {
    clearError(field);
    field.style.borderColor = '#ffc107';
    
    const warningDiv = document.createElement('div');
    warningDiv.className = 'warning-message';
    warningDiv.style.color = '#856404';
    warningDiv.style.fontSize = '0.875rem';
    warningDiv.style.marginTop = '0.25rem';
    warningDiv.textContent = message;
    
    field.parentNode.appendChild(warningDiv);
}

function clearError(field) {
    field.style.borderColor = '';
    
    const existingError = field.parentNode.querySelector('.error-message');
    const existingWarning = field.parentNode.querySelector('.warning-message');
    
    if (existingError) existingError.remove();
    if (existingWarning) existingWarning.remove();
}

function clearErrors() {
    const errorMessages = document.querySelectorAll('.error-message, .warning-message');
    errorMessages.forEach(error => error.remove());
    
    const fields = document.querySelectorAll('.form-control, .search-input');
    fields.forEach(field => {
        field.style.borderColor = '';
    });
}

// Patient Search Functionality
function setupPatientSearch() {
    const customerInput = document.getElementById('customer');
    const customercodeInput = document.getElementById('customercode');
    
    if (customerInput) {
        customerInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length >= 2) {
                searchPatients(query);
            } else {
                hidePatientSuggestions();
                customercodeInput.value = '';
            }
        });
        
        customerInput.addEventListener('blur', function() {
            setTimeout(() => {
                hidePatientSuggestions();
            }, 200);
        });
    }
}

function searchPatients(query) {
    let suggestionsContainer = document.getElementById('patientSuggestions');
    if (!suggestionsContainer) {
        suggestionsContainer = document.createElement('div');
        suggestionsContainer.id = 'patientSuggestions';
        suggestionsContainer.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        `;
        
        const searchContainer = document.querySelector('.search-container');
        if (searchContainer) {
            searchContainer.style.position = 'relative';
            searchContainer.appendChild(suggestionsContainer);
        }
    }
    
    const samplePatients = [
        { code: 'P001', name: 'John Doe', ward: 'General Ward' },
        { code: 'P002', name: 'Jane Smith', ward: 'ICU' },
        { code: 'P003', name: 'Bob Johnson', ward: 'Emergency' },
        { code: 'P004', name: 'Alice Brown', ward: 'Maternity' }
    ];
    
    const filteredPatients = samplePatients.filter(patient => 
        patient.name.toLowerCase().includes(query.toLowerCase())
    );
    
    if (filteredPatients.length > 0) {
        suggestionsContainer.innerHTML = filteredPatients.map(patient => `
            <div class="patient-suggestion" data-code="${patient.code}" data-name="${patient.name}" style="
                padding: 0.75rem;
                cursor: pointer;
                border-bottom: 1px solid #eee;
                transition: background-color 0.2s;
            " onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='white'">
                <div style="font-weight: 600; color: #2c5aa0;">${patient.name}</div>
                <div style="font-size: 0.875rem; color: #6c757d;">Code: ${patient.code} | Ward: ${patient.ward}</div>
            </div>
        `).join('');
        
        suggestionsContainer.querySelectorAll('.patient-suggestion').forEach(item => {
            item.addEventListener('click', function() {
                const code = this.dataset.code;
                const name = this.dataset.name;
                
                document.getElementById('customer').value = name;
                document.getElementById('customercode').value = code;
                
                hidePatientSuggestions();
            });
        });
        
        suggestionsContainer.style.display = 'block';
    } else {
        suggestionsContainer.innerHTML = '<div style="padding: 0.75rem; color: #6c757d; text-align: center;">No patients found</div>';
        suggestionsContainer.style.display = 'block';
    }
}

function hidePatientSuggestions() {
    const suggestionsContainer = document.getElementById('patientSuggestions');
    if (suggestionsContainer) {
        suggestionsContainer.style.display = 'none';
    }
}

// Location Dependency
function setupLocationDependency() {
    const locationSelect = document.getElementById('location');
    
    if (locationSelect) {
        locationSelect.addEventListener('change', function() {
            updateLocationDisplay(this.value);
        });
        
        if (locationSelect.value) {
            updateLocationDisplay(locationSelect.value);
        }
    }
}

function updateLocationDisplay(locationCode) {
    const locationDisplay = document.getElementById('ajaxlocation');
    
    if (!locationDisplay || !locationCode) return;
    
    fetch(`ajax/ajaxgetlocationname.php?loccode=${locationCode}`)
        .then(response => response.text())
        .then(data => {
            locationDisplay.innerHTML = `<strong>Location:</strong> ${data}`;
        })
        .catch(error => {
            console.error('Error fetching location name:', error);
            locationDisplay.innerHTML = '<strong>Location:</strong> Selected';
        });
}

// Export and Print Functionality
function setupExportPrint() {
    const exportBtn = document.getElementById('exportBtn');
    const printBtn = document.getElementById('printBtn');
    
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            exportReport();
        });
    }
    
    if (printBtn) {
        printBtn.addEventListener('click', function() {
            printReport();
        });
    }
}

function exportReport() {
    const form = document.querySelector('form[name="cbform1"]');
    if (!form) return;
    
    const exportForm = form.cloneNode(true);
    exportForm.action = 'export_bedtransferlist.php';
    exportForm.target = '_blank';
    exportForm.method = 'POST';
    
    const exportType = document.createElement('input');
    exportType.type = 'hidden';
    exportType.name = 'export_type';
    exportType.value = 'excel';
    exportForm.appendChild(exportType);
    
    document.body.appendChild(exportForm);
    exportForm.submit();
    document.body.removeChild(exportForm);
}

function printReport() {
    const sidebar = document.getElementById('leftSidebar');
    const btnGroup = document.querySelector('.btn-group');
    const filterContainer = document.querySelector('.filter-container');
    
    const originalSidebarDisplay = sidebar ? sidebar.style.display : '';
    const originalBtnGroupDisplay = btnGroup ? btnGroup.style.display : '';
    const originalFilterDisplay = filterContainer ? filterContainer.style.display : '';
    
    if (sidebar) sidebar.style.display = 'none';
    if (btnGroup) btnGroup.style.display = 'none';
    if (filterContainer) filterContainer.style.display = 'none';
    
    window.print();
    
    if (sidebar) sidebar.style.display = originalSidebarDisplay;
    if (btnGroup) btnGroup.style.display = originalBtnGroupDisplay;
    if (filterContainer) filterContainer.style.display = originalFilterDisplay;
}