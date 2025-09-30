// Radiology Image Acquisition - Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize the application
    initializeApp();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize form validation
    initializeFormValidation();
});

function initializeApp() {
    // Initialize sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const leftSidebar = document.getElementById('leftSidebar');
    const menuToggle = document.getElementById('menuToggle');
    
    if (sidebarToggle && leftSidebar) {
        sidebarToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('open');
        });
    }
    
    if (menuToggle && leftSidebar) {
        menuToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('open');
        });
    }
    
    // Close sidebar when clicking outside
    document.addEventListener('click', function(event) {
        if (leftSidebar && !leftSidebar.contains(event.target) && !menuToggle.contains(event.target)) {
            leftSidebar.classList.remove('open');
        }
    });
}

function setupEventListeners() {
    // Form submission
    const searchForm = document.querySelector('form[name="cbform1"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // Real-time form validation
    const formInputs = document.querySelectorAll('.form-input, .form-select');
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
    
    // Location change handler
    const locationSelect = document.getElementById('location');
    if (locationSelect) {
        locationSelect.addEventListener('change', function() {
            ajaxlocationfunction(this.value);
        });
    }
}

function initializeFormValidation() {
    // Add validation classes to form elements
    const requiredFields = document.querySelectorAll('input[required], select[required]');
    requiredFields.forEach(field => {
        field.classList.add('required-field');
    });
}

function validateForm() {
    let isValid = true;
    const form = document.querySelector('form[name="cbform1"]');
    
    if (!form) return true;
    
    // Clear previous errors
    clearAllErrors();
    
    // Validate required fields
    const requiredFields = form.querySelectorAll('.required-field');
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    // Validate date range
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
    if (dateFrom && dateTo) {
        if (!validateDateRange(dateFrom.value, dateTo.value)) {
            isValid = false;
        }
    }
    
    if (!isValid) {
        showAlert('Please correct the errors in the form before submitting.', 'error');
    }
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.getAttribute('name') || field.getAttribute('id');
    let isValid = true;
    let errorMessage = '';
    
    // Check if field is required
    if (field.classList.contains('required-field') && !value) {
        errorMessage = `${getFieldLabel(field)} is required.`;
        isValid = false;
    }
    
    // Specific field validations
    if (value && fieldName === 'patientcode') {
        if (!/^[A-Za-z0-9\-_]+$/.test(value)) {
            errorMessage = 'Registration number can only contain letters, numbers, hyphens, and underscores.';
            isValid = false;
        }
    }
    
    if (value && fieldName === 'visitcode') {
        if (!/^[A-Za-z0-9\-_]+$/.test(value)) {
            errorMessage = 'Visit code can only contain letters, numbers, hyphens, and underscores.';
            isValid = false;
        }
    }
    
    if (value && (fieldName === 'ADate1' || fieldName === 'ADate2')) {
        if (!isValidDate(value)) {
            errorMessage = 'Please enter a valid date.';
            isValid = false;
        }
    }
    
    if (!isValid) {
        showFieldError(field, errorMessage);
    } else {
        clearFieldError(field);
    }
    
    return isValid;
}

function validateDateRange(dateFrom, dateTo) {
    if (!dateFrom || !dateTo) return true;
    
    const fromDate = new Date(dateFrom);
    const toDate = new Date(dateTo);
    
    if (fromDate > toDate) {
        const dateFromField = document.getElementById('ADate1');
        const dateToField = document.getElementById('ADate2');
        
        showFieldError(dateFromField, 'Date From cannot be later than Date To.');
        showFieldError(dateToField, 'Date To cannot be earlier than Date From.');
        
        return false;
    }
    
    return true;
}

function isValidDate(dateString) {
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

function getFieldLabel(field) {
    const label = document.querySelector(`label[for="${field.id}"]`);
    return label ? label.textContent.replace('*', '').trim() : field.name;
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('error');
    
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

function clearAllErrors() {
    const errorFields = document.querySelectorAll('.error');
    errorFields.forEach(field => {
        clearFieldError(field);
    });
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    
    const icon = type === 'error' ? 'exclamation-triangle' : 
                 type === 'success' ? 'check-circle' : 'info-circle';
    
    alertDiv.innerHTML = `
        <i class="fas fa-${icon} alert-icon"></i>
        <span>${message}</span>
    `;
    
    alertContainer.appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.parentNode.removeChild(alertDiv);
        }
    }, 5000);
}

// AJAX function for location updates
function ajaxlocationfunction(val) {
    if (!val) return;
    
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const locationDisplay = document.getElementById('ajaxlocation');
            if (locationDisplay) {
                locationDisplay.innerHTML = xhr.responseText;
            }
        }
    };
    
    xhr.open('GET', `ajax/ajaxgetlocationname.php?loccode=${encodeURIComponent(val)}`, true);
    xhr.send();
}

// Utility functions
function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    // This would implement Excel export functionality
    showAlert('Excel export functionality would be implemented here.', 'info');
}

function disableEnterKey() {
    // Prevent Enter key from submitting form in date fields
    if (event.keyCode === 13) {
        event.preventDefault();
        return false;
    }
    return true;
}

// Legacy function support
function cbcustomername1() {
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.submit();
    }
}

function pharmacy(patientcode, visitcode) {
    if (!patientcode || !visitcode) {
        showAlert('Patient code and visit code are required.', 'error');
        return;
    }
    
    const url = `pharmacy1.php?RandomKey=${Math.random()}&patientcode=${encodeURIComponent(patientcode)}&visitcode=${encodeURIComponent(visitcode)}`;
    window.open(url, 'Pharmacy', 'width=600,height=400');
}

// Add CSS for error states
const style = document.createElement('style');
style.textContent = `
    .form-input.error,
    .form-select.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .field-error {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .field-error::before {
        content: '⚠';
        font-size: 0.75rem;
    }
    
    .required-field::after {
        content: ' *';
        color: #ef4444;
    }
`;
document.head.appendChild(style);

