// Bed Occupancy 2 Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    setupSidebarToggle();
    setupFormValidation();
    setupLocationWardDependency();
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
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });
    }
    
    if (dateFrom && dateTo) {
        dateFrom.addEventListener('change', validateDateRange);
        dateTo.addEventListener('change', validateDateRange);
    }
}

function validateForm() {
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    const location = document.getElementById('location');
    
    let isValid = true;
    clearErrors();
    
    if (!validateDateRange()) {
        isValid = false;
    }
    
    if (location && !location.value) {
        showError(location, 'Please select a location');
        isValid = false;
    }
    
    return isValid;
}

function validateDateRange() {
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
    if (!dateFrom || !dateTo) return true;
    
    const fromDate = new Date(dateFrom.value);
    const toDate = new Date(dateTo.value);
    
    if (fromDate > toDate) {
        showError(dateTo, 'End date must be after start date');
        return false;
    }
    
    clearError(dateTo);
    return true;
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

function clearError(field) {
    field.style.borderColor = '';
    const existingError = field.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
}

function clearErrors() {
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(error => error.remove());
    
    const fields = document.querySelectorAll('.form-control');
    fields.forEach(field => {
        field.style.borderColor = '';
    });
}

// Location-Ward Dependency
function setupLocationWardDependency() {
    const locationSelect = document.getElementById('location');
    const wardSelect = document.getElementById('ward');
    
    if (locationSelect && wardSelect) {
        locationSelect.addEventListener('change', function() {
            updateWardOptions(this.value);
        });
        
        if (locationSelect.value) {
            updateWardOptions(locationSelect.value);
        }
    }
}

function updateWardOptions(locationCode) {
    const wardSelect = document.getElementById('ward');
    
    if (!wardSelect) return;
    
    wardSelect.innerHTML = '<option value="">All Wards</option>';
    
    if (!locationCode) return;
    
    // Build ward options based on location
    buildWardOptions(locationCode);
}

function buildWardOptions(locationCode) {
    const wardSelect = document.getElementById('ward');
    
    // Sample ward data - replace with actual data from database
    const sampleWards = [
        { value: '1', text: 'General Ward' },
        { value: '2', text: 'ICU' },
        { value: '3', text: 'Emergency Ward' },
        { value: '4', text: 'Maternity Ward' }
    ];
    
    sampleWards.forEach(ward => {
        const option = document.createElement('option');
        option.value = ward.value;
        option.textContent = ward.text;
        wardSelect.appendChild(option);
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
    exportForm.action = 'export_bedoccupancy2.php';
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