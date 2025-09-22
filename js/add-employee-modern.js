// Modern Add Employee JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar functionality
    initSidebar();
    
    // Initialize form functionality
    initFormHandlers();
    
    // Initialize date pickers
    initDatePickers();
    
    // Initialize validation
    initValidation();
    
    // Initialize department unit building
    initDepartmentUnitBuilding();
    
    // Initialize employee type and status handlers
    initEmployeeTypeHandlers();
});

// Sidebar functionality
function initSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
}

// Form handlers
function initFormHandlers() {
    // Form submission
    const form = document.getElementById('form1');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            }
        });
    }
    
    // Real-time validation
    const requiredFields = document.querySelectorAll('.form-input[required], .form-select[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
    
    // Numeric validation for leave days
    const numericFields = document.querySelectorAll('input[onKeyPress*="validatenumerics"]');
    numericFields.forEach(field => {
        field.addEventListener('keypress', function(e) {
            if (!validatenumerics(e)) {
                e.preventDefault();
            }
        });
    });
}

// Date picker initialization
function initDatePickers() {
    // Add date picker styling
    const dateInputs = document.querySelectorAll('.date-picker');
    dateInputs.forEach(input => {
        const wrapper = input.parentNode;
        wrapper.style.position = 'relative';
        
        // Add date picker button if not already present
        if (!wrapper.querySelector('.date-picker-btn')) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'date-picker-btn';
            btn.innerHTML = '<i class="fas fa-calendar-alt"></i>';
            wrapper.appendChild(btn);
        }
    });
}

// Validation functions
function validateForm() {
    let isValid = true;
    const requiredFields = document.querySelectorAll('.form-input[required], .form-select[required]');
    
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    // Additional validation based on category
    const category = document.getElementById('category');
    if (category && category.value) {
        isValid = validateCategoryFields(category.value) && isValid;
    }
    
    // Employee type validation
    const employeeType = document.getElementById('employeetype');
    if (employeeType && employeeType.value) {
        isValid = validateEmployeeTypeFields() && isValid;
    }
    
    if (!isValid) {
        showAlert('Please fill in all required fields correctly.', 'error');
        // Scroll to first error
        const firstError = document.querySelector('.form-input.error, .form-select.error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    }
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    const isRequired = field.hasAttribute('required');
    
    // Clear previous errors
    clearFieldError(field);
    
    if (isRequired && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Email validation
    if (field.type === 'email' && value && !isValidEmail(value)) {
        showFieldError(field, 'Please enter a valid email address');
        return false;
    }
    
    // Mobile validation
    if (field.id === 'mobile' && value && !isValidMobile(value)) {
        showFieldError(field, 'Please enter a valid mobile number');
        return false;
    }
    
    // PIN validation
    if (field.id === 'pinno' && value && !isValidPIN(value)) {
        showFieldError(field, 'Please enter a valid PIN number');
        return false;
    }
    
    return true;
}

function validateCategoryFields(category) {
    let isValid = true;
    
    if (category === 'Permanent' || category === 'Contract' || category === 'MCK Stationing') {
        const requiredFields = ['pinno', 'nssf', 'nhif', 'bankname', 'accountnumber'];
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field && !field.value.trim()) {
                showFieldError(field, 'This field is required for ' + category + ' employees');
                isValid = false;
            }
        });
    } else if (category === 'Casual' || category === 'Locum') {
        const requiredFields = ['pinno', 'bankname', 'accountnumber'];
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field && !field.value.trim()) {
                showFieldError(field, 'This field is required for ' + category + ' employees');
                isValid = false;
            }
        });
    }
    
    return isValid;
}

function validateEmployeeTypeFields() {
    const employeeType = document.getElementById('employeetype');
    if (!employeeType || !employeeType.value) return true;
    
    let isValid = true;
    const fromDate = document.getElementById('empfrom');
    const endDate = document.getElementById('empend');
    
    if (employeeType.value && (!fromDate.value || !endDate.value)) {
        showAlert('From Date and End Date are required when Employee Type is selected.', 'error');
        isValid = false;
    }
    
    return isValid;
}

function showFieldError(field, message) {
    field.classList.add('error');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Add error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.color = '#dc2626';
    errorDiv.style.fontSize = '0.75rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('error');
    const errorDiv = field.parentNode.querySelector('.field-error');
    if (errorDiv) {
        errorDiv.remove();
    }
}

// Alert system
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertClass = type === 'error' ? 'alert-error' : (type === 'success' ? 'alert-success' : 'alert-info');
    const iconClass = type === 'error' ? 'exclamation-triangle' : (type === 'success' ? 'check-circle' : 'info-circle');
    
    const alertHtml = `
        <div class="alert ${alertClass}">
            <i class="fas fa-${iconClass} alert-icon"></i>
            <span>${message}</span>
        </div>
    `;
    
    alertContainer.innerHTML = alertHtml;
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        alertContainer.innerHTML = '';
    }, 5000);
}

// Utility functions
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidMobile(mobile) {
    const mobileRegex = /^(\+254|0)?[17]\d{8}$/;
    return mobileRegex.test(mobile.replace(/\s/g, ''));
}

function isValidPIN(pin) {
    const pinRegex = /^[A-Z]\d{8}[A-Z]$/;
    return pinRegex.test(pin.toUpperCase());
}

function resetForm() {
    const form = document.getElementById('form1');
    if (form) {
        form.reset();
        
        // Clear all error states
        const errorFields = form.querySelectorAll('.form-input.error, .form-select.error');
        errorFields.forEach(field => {
            clearFieldError(field);
        });
        
        // Hide conditional sections
        document.getElementById('onemptype').style.display = 'none';
        document.getElementById('onempstatus').style.display = 'none';
        
        // Clear department unit dropdown
        const deptUnit = document.getElementById('deptunit');
        if (deptUnit) {
            deptUnit.innerHTML = '<option value="">Select Unit</option>';
        }
        
        showAlert('Form has been reset.', 'info');
    }
}

// Department unit building (legacy compatibility)
function DeptUnitBuild() {
    const department = document.getElementById('department');
    const deptUnit = document.getElementById('deptunit');
    
    if (!department || !deptUnit) return;
    
    const selectedDept = department.value;
    if (!selectedDept) {
        deptUnit.innerHTML = '<option value="">Select Unit</option>';
        return;
    }
    
    // Clear existing options
    deptUnit.innerHTML = '<option value="">Loading...</option>';
    
    // This would typically make an AJAX call to get units for the selected department
    // For now, we'll simulate it with a timeout
    setTimeout(() => {
        deptUnit.innerHTML = '<option value="">Select Unit</option>';
        // Add some sample units (this should be replaced with actual AJAX call)
        const sampleUnits = ['Unit 1', 'Unit 2', 'Unit 3'];
        sampleUnits.forEach(unit => {
            const option = document.createElement('option');
            option.value = unit;
            option.textContent = unit;
            deptUnit.appendChild(option);
        });
    }, 500);
}

// Employee type handlers
function initEmployeeTypeHandlers() {
    const employeeType = document.getElementById('employeetype');
    if (employeeType) {
        employeeType.addEventListener('change', fncemptype);
    }
    
    const employmentStatus = document.getElementById('employmentstatus');
    if (employmentStatus) {
        employmentStatus.addEventListener('change', fncempemploymentstatus);
    }
}

function fncemptype() {
    const employeeType = document.getElementById('employeetype');
    const onEmpType = document.getElementById('onemptype');
    
    if (employeeType && onEmpType) {
        if (employeeType.value) {
            onEmpType.style.display = 'block';
        } else {
            onEmpType.style.display = 'none';
        }
    }
}

function fncempemploymentstatus() {
    const employmentStatus = document.getElementById('employmentstatus');
    const onEmpStatus = document.getElementById('onempstatus');
    
    if (employmentStatus && onEmpStatus) {
        if (employmentStatus.value && employmentStatus.value !== 'Alive') {
            onEmpStatus.style.display = 'block';
        } else {
            onEmpStatus.style.display = 'none';
        }
    }
}

// Initialize department unit building
function initDepartmentUnitBuilding() {
    const department = document.getElementById('department');
    if (department) {
        department.addEventListener('change', DeptUnitBuild);
    }
}

// Legacy function compatibility
function process1() {
    return validateForm();
}

function validatenumerics(event) {
    const keycode = event.which || event.keyCode;
    
    // Allow backspace, delete, tab, escape, enter
    if ([8, 9, 27, 13, 46].indexOf(keycode) !== -1 ||
        // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
        (keycode === 65 && event.ctrlKey === true) ||
        (keycode === 67 && event.ctrlKey === true) ||
        (keycode === 86 && event.ctrlKey === true) ||
        (keycode === 88 && event.ctrlKey === true)) {
        return true;
    }
    
    // Ensure that it is a number and stop the keypress
    if ((keycode < 48 || keycode > 57)) {
        event.preventDefault();
        return false;
    }
    
    return true;
}

// File upload preview
function initFileUpload() {
    const fileInput = document.getElementById('employeeimg');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    showAlert('Please select a valid image file.', 'error');
                    fileInput.value = '';
                    return;
                }
                
                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showAlert('File size must be less than 5MB.', 'error');
                    fileInput.value = '';
                    return;
                }
                
                showAlert('Image selected successfully.', 'success');
            }
        });
    }
}

// Initialize file upload
document.addEventListener('DOMContentLoaded', function() {
    initFileUpload();
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + S for save
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        const form = document.getElementById('form1');
        if (form) {
            form.submit();
        }
    }
    
    // Escape to reset form
    if (e.key === 'Escape') {
        if (confirm('Are you sure you want to reset the form?')) {
            resetForm();
        }
    }
});

// Auto-save functionality (optional)
function initAutoSave() {
    const form = document.getElementById('form1');
    if (!form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    let autoSaveTimeout;
    
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                // Auto-save logic would go here
                console.log('Auto-saving form data...');
            }, 2000);
        });
    });
}

// Initialize auto-save
document.addEventListener('DOMContentLoaded', function() {
    initAutoSave();
});

// Form progress indicator
function updateFormProgress() {
    const form = document.getElementById('form1');
    if (!form) return;
    
    const requiredFields = form.querySelectorAll('input[required], select[required]');
    const filledFields = Array.from(requiredFields).filter(field => field.value.trim() !== '');
    
    const progress = (filledFields.length / requiredFields.length) * 100;
    
    // You could add a progress bar here if needed
    console.log(`Form completion: ${Math.round(progress)}%`);
}

// Initialize form progress tracking
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form1');
    if (form) {
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('input', updateFormProgress);
        });
    }
});

// Print functionality
function printForm() {
    window.print();
}

// Export form data (optional)
function exportFormData() {
    const form = document.getElementById('form1');
    if (!form) return;
    
    const formData = new FormData(form);
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    const jsonString = JSON.stringify(data, null, 2);
    const blob = new Blob([jsonString], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    
    const a = document.createElement('a');
    a.href = url;
    a.download = 'employee_form_data.json';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

// Initialize all functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('Add Employee Form initialized');
    
    // Show success message if redirected from successful submission
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('st') === 'success') {
        showAlert('Employee added successfully!', 'success');
    } else if (urlParams.get('st') === 'failed') {
        showAlert('Failed to add employee. Employee may already exist.', 'error');
    }
});

