// Consultation Refund Request List Modern JavaScript
let allRefundRecords = [];
let filteredRefundRecords = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let patientInput, patientcodeInput, visitcodeInput, billnoInput, dateFromInput, dateToInput, submitBtn, clearBtn;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializeFormValidation();
    setupKeyboardShortcuts();
});

function initializeElements() {
    patientInput = document.getElementById('patient');
    patientcodeInput = document.getElementById('patientcode');
    visitcodeInput = document.getElementById('visitcode');
    billnoInput = document.getElementById('billno');
    dateFromInput = document.getElementById('ADate1');
    dateToInput = document.getElementById('ADate2');
    submitBtn = document.querySelector('input[name="Submit"]');
    clearBtn = document.getElementById('resetbutton');
}

function setupEventListeners() {
    if (submitBtn) {
        submitBtn.addEventListener('click', handleFormSubmit);
    }
    
    if (clearBtn) {
        clearBtn.addEventListener('click', clearForm);
    }
    
    // Auto-suggest functionality
    if (patientInput) {
        patientInput.addEventListener('input', debounce(handlePatientSearch, 300));
    }
    
    if (patientcodeInput) {
        patientcodeInput.addEventListener('input', debounce(handlePatientCodeSearch, 300));
    }
    
    if (visitcodeInput) {
        visitcodeInput.addEventListener('input', debounce(handleVisitCodeSearch, 300));
    }
    
    if (billnoInput) {
        billnoInput.addEventListener('input', debounce(handleBillNoSearch, 300));
    }
}

function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const leftSidebar = document.getElementById('leftSidebar');
    
    if (menuToggle && leftSidebar) {
        menuToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('collapsed');
            const icon = menuToggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            }
        });
    }
    
    if (sidebarToggle && leftSidebar) {
        sidebarToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('collapsed');
            const icon = sidebarToggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-chevron-left');
                icon.classList.toggle('fa-chevron-right');
            }
        });
    }
}

function initializeFormValidation() {
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                showAlert('Please fill in all required fields correctly.', 'error');
            }
        });
    }
}

function validateForm() {
    let isValid = true;
    const errors = [];
    
    // Validate date range
    if (dateFromInput && dateToInput) {
        const fromDate = new Date(dateFromInput.value);
        const toDate = new Date(dateToInput.value);
        
        if (fromDate > toDate) {
            errors.push('From date cannot be greater than To date');
            isValid = false;
        }
    }
    
    // Validate required fields (at least one search criteria should be provided)
    const hasSearchCriteria = 
        (patientInput && patientInput.value.trim()) ||
        (patientcodeInput && patientcodeInput.value.trim()) ||
        (visitcodeInput && visitcodeInput.value.trim()) ||
        (billnoInput && billnoInput.value.trim());
    
    if (!hasSearchCriteria) {
        errors.push('Please provide at least one search criteria');
        isValid = false;
    }
    
    if (!isValid) {
        showAlert(errors.join('<br>'), 'error');
    }
    
    return isValid;
}

function handleFormSubmit(e) {
    if (!validateForm()) {
        e.preventDefault();
        return;
    }
    
    showLoadingState();
    
    // Add loading state to submit button
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.value = 'Searching...';
    }
}

function clearForm() {
    if (patientInput) patientInput.value = '';
    if (patientcodeInput) patientcodeInput.value = '';
    if (visitcodeInput) visitcodeInput.value = '';
    if (billnoInput) billnoInput.value = '';
    
    // Reset dates to default
    if (dateFromInput) dateFromInput.value = getDefaultFromDate();
    if (dateToInput) dateToInput.value = getDefaultToDate();
    
    showAlert('Form cleared successfully.', 'success');
}

function getDefaultFromDate() {
    const date = new Date();
    date.setMonth(date.getMonth() - 1);
    return date.toISOString().split('T')[0];
}

function getDefaultToDate() {
    return new Date().toISOString().split('T')[0];
}

function handlePatientSearch(value) {
    if (value.length >= 2) {
        // Implement patient search functionality
        console.log('Searching for patient:', value);
    }
}

function handlePatientCodeSearch(value) {
    if (value.length >= 2) {
        // Implement patient code search functionality
        console.log('Searching for patient code:', value);
    }
}

function handleVisitCodeSearch(value) {
    if (value.length >= 2) {
        // Implement visit code search functionality
        console.log('Searching for visit code:', value);
    }
}

function handleBillNoSearch(value) {
    if (value.length >= 2) {
        // Implement bill number search functionality
        console.log('Searching for bill number:', value);
    }
}

function showLoadingState() {
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        alertContainer.innerHTML = `
            <div class="alert alert-info">
                <i class="fas fa-spinner fa-spin"></i>
                Processing your request, please wait...
            </div>
        `;
    }
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        const alertClass = `alert-${type}`;
        const iconClass = getIconForAlertType(type);
        
        alertContainer.innerHTML = `
            <div class="alert ${alertClass}">
                <i class="${iconClass}"></i>
                ${message}
            </div>
        `;
        
        // Auto-hide success messages after 3 seconds
        if (type === 'success') {
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 3000);
        }
    }
}

function getIconForAlertType(type) {
    const icons = {
        'success': 'fas fa-check-circle',
        'error': 'fas fa-exclamation-circle',
        'warning': 'fas fa-exclamation-triangle',
        'info': 'fas fa-info-circle'
    };
    return icons[type] || icons['info'];
}

function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    showAlert('Export functionality will be implemented soon.', 'info');
}

function printReport() {
    window.print();
}

function setupKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl + Enter to submit form
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            if (submitBtn) {
                submitBtn.click();
            }
        }
        
        // Escape to clear form
        if (e.key === 'Escape') {
            if (clearBtn) {
                clearBtn.click();
            }
        }
        
        // F5 to refresh
        if (e.key === 'F5') {
            e.preventDefault();
            refreshPage();
        }
    });
}

// Utility function for debouncing
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Refund processing function
function putRequest(billnumber, visitcode, sno) {
    const remarksTextarea = document.getElementById(`remark${sno}`);
    const remarks = remarksTextarea ? remarksTextarea.value.trim() : '';
    
    if (!remarks) {
        showAlert('Please enter remarks before processing the refund request.', 'warning');
        if (remarksTextarea) {
            remarksTextarea.focus();
        }
        return false;
    }
    
    if (confirm('Are you sure you want to process this refund request?')) {
        // Create a form to submit the refund request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'consultationrefundrequestlist.php';
        
        // Add form fields
        const fields = {
            'billnumber': billnumber,
            'visitcode': visitcode,
            'remarks': remarks
        };
        
        Object.keys(fields).forEach(key => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = fields[key];
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
        
        showAlert('Processing refund request...', 'info');
        return true;
    }
    
    return false;
}

// Backward compatibility functions
function disableEnterKey() {
    return false;
}

// Initialize auto-suggest functionality
function initializeAutoSuggest() {
    // This function will be called by the external auto-suggest scripts
    console.log('Auto-suggest initialized');
}

// Page refresh functionality
function refreshPageData() {
    showLoadingState();
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

// Form reset functionality
function resetForm() {
    clearForm();
}

// Export functionality placeholder
function exportData() {
    showAlert('Export functionality will be implemented soon.', 'info');
}

// Print functionality
function printData() {
    window.print();
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Consultation Refund Request List page initialized');
    
    // Set default dates if not already set
    if (dateFromInput && !dateFromInput.value) {
        dateFromInput.value = getDefaultFromDate();
    }
    if (dateToInput && !dateToInput.value) {
        dateToInput.value = getDefaultToDate();
    }
});