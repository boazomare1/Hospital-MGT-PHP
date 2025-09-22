// Modern Employee Type Management JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar functionality
    initSidebar();
    
    // Initialize form functionality
    initFormHandlers();
    
    // Initialize permission checkboxes
    initPermissionHandlers();
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
    // Employee type selection form validation
    const selectForm = document.getElementById('selectemployee');
    if (selectForm) {
        selectForm.addEventListener('submit', function(e) {
            if (!validateEmployeeSelection()) {
                e.preventDefault();
            }
        });
    }
    
    // Main form submission
    const mainForm = document.getElementById('form1');
    if (mainForm) {
        mainForm.addEventListener('submit', function(e) {
            if (!validateMainForm()) {
                e.preventDefault();
            }
        });
    }
}

// Permission checkbox handlers
function initPermissionHandlers() {
    // Initialize all menu check functionality
    window.allmenucheck = function() {
        const mainCheckbox = document.getElementById('mainmenucheck1');
        if (!mainCheckbox) return;
        
        const isChecked = mainCheckbox.checked;
        
        // Check/uncheck all main menu items
        const mainMenuCheckboxes = document.getElementsByClassName('mainmenucheck');
        for (let i = 0; i < mainMenuCheckboxes.length; i++) {
            if (mainMenuCheckboxes[i].id !== 'mainmenucheck1') {
                mainMenuCheckboxes[i].checked = isChecked;
                // Also trigger submenu check for each main menu
                const mainMenuId = mainMenuCheckboxes[i].id;
                if (mainMenuId) {
                    submenucheck(mainMenuId);
                }
            }
        }
        
        // Check/uncheck all submenu items
        const subMenuCheckboxes = document.getElementsByClassName('submenucheck');
        for (let i = 0; i < subMenuCheckboxes.length; i++) {
            subMenuCheckboxes[i].checked = isChecked;
        }
    };
    
    // Initialize individual submenu check functionality
    window.submenucheck = function(mainmenucheck) {
        const mainCheckbox = document.getElementById(mainmenucheck);
        if (!mainCheckbox) return;
        
        const isChecked = mainCheckbox.checked;
        const subMenuCheckboxes = document.getElementsByClassName(mainmenucheck);
        
        for (let i = 0; i < subMenuCheckboxes.length; i++) {
            if (subMenuCheckboxes[i].classList.contains('submenucheck')) {
                subMenuCheckboxes[i].checked = isChecked;
            }
        }
    };
}

// Validation functions
function validateEmployeeSelection() {
    const selectElement = document.getElementById('selectemployeecode');
    if (!selectElement || selectElement.value === '') {
        showAlert('Please select an employee type to edit.', 'error');
        selectElement.focus();
        return false;
    }
    return true;
}

function validateMainForm() {
    // Check if at least one location is selected
    const locationCheckboxes = document.querySelectorAll('input[name^="cblocation"]');
    let locationSelected = false;
    for (let i = 0; i < locationCheckboxes.length; i++) {
        if (locationCheckboxes[i].checked) {
            locationSelected = true;
            break;
        }
    }
    
    if (!locationSelected) {
        showAlert('Please select at least one location permission.', 'error');
        return false;
    }
    
    // Check if at least one main menu is selected
    const mainMenuCheckboxes = document.querySelectorAll('input[name^="cbmainmenu"]');
    let mainMenuSelected = false;
    for (let i = 0; i < mainMenuCheckboxes.length; i++) {
        if (mainMenuCheckboxes[i].checked) {
            mainMenuSelected = true;
            break;
        }
    }
    
    if (!mainMenuSelected) {
        showAlert('Please select at least one main menu permission.', 'error');
        return false;
    }
    
    // Check shift access
    const shiftSelect = document.getElementById('shift');
    if (!shiftSelect || shiftSelect.value === '') {
        showAlert('Please select shift access option.', 'error');
        shiftSelect.focus();
        return false;
    }
    
    return confirm('Are you sure you want to update employee permissions? This will reset rights for all employees of this type.');
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
function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    // Placeholder for Excel export functionality
    showAlert('Excel export functionality will be implemented.', 'info');
}

function resetForm() {
    if (confirm('Are you sure you want to reset the form? All changes will be lost.')) {
        const form = document.getElementById('form1');
        if (form) {
            form.reset();
            // Uncheck all checkboxes
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            // Reset radio buttons
            const radios = form.querySelectorAll('input[type="radio"]');
            radios.forEach(radio => {
                radio.checked = false;
            });
        }
        showAlert('Form has been reset.', 'success');
    }
}

// Legacy function compatibility
function funcEmployeeSelect1() {
    return validateEmployeeSelection();
}

function from1submit1() {
    return validateMainForm();
}

// Disable enter key function (legacy compatibility)
function disableEnterKey(e) {
    if (e.keyCode === 13) {
        e.preventDefault();
        return false;
    }
}

// Auto-suggest functionality (placeholder)
function initAutoSuggest() {
    // Placeholder for autocomplete functionality
    console.log('Auto-suggest functionality initialized');
}

// Initialize autocomplete when page loads
window.onload = function() {
    initAutoSuggest();
};

// Form field validation helpers
function validateNumericInput(input) {
    const value = input.value;
    if (value && isNaN(value)) {
        input.value = value.replace(/[^0-9]/g, '');
    }
}

function validateTextInput(input) {
    const value = input.value;
    if (value) {
        input.value = value.replace(/[^a-zA-Z\s]/g, '');
    }
}

// Enhanced form interactions
function enhanceFormInteractions() {
    // Add real-time validation to form inputs
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    const fieldType = field.type;
    
    // Clear previous errors
    clearFieldError(field);
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Type-specific validation
    if (fieldType === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            showFieldError(field, 'Please enter a valid email address');
            return false;
        }
    }
    
    return true;
}

function showFieldError(field, message) {
    field.classList.add('error');
    
    let errorElement = field.parentNode.querySelector('.field-error');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'field-error';
        field.parentNode.appendChild(errorElement);
    }
    
    errorElement.textContent = message;
    errorElement.style.color = '#dc2626';
    errorElement.style.fontSize = '0.75rem';
    errorElement.style.marginTop = '0.25rem';
}

function clearFieldError(field) {
    field.classList.remove('error');
    
    const errorElement = field.parentNode.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
}

// Initialize enhanced interactions when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    enhanceFormInteractions();
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Alt + S for save
    if (e.altKey && e.key === 's') {
        e.preventDefault();
        const saveButton = document.querySelector('button[type="submit"]');
        if (saveButton) {
            saveButton.click();
        }
    }
    
    // Alt + R for reset
    if (e.altKey && e.key === 'r') {
        e.preventDefault();
        resetForm();
    }
    
    // Alt + H for refresh
    if (e.altKey && e.key === 'h') {
        e.preventDefault();
        refreshPage();
    }
});

// Print functionality
function printPage() {
    window.print();
}

// Responsive menu toggle
function toggleResponsiveMenu() {
    const sidebar = document.getElementById('leftSidebar');
    if (sidebar) {
        sidebar.classList.toggle('open');
    }
}

// Initialize all functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('Employee Type Management System initialized');
});

