// Cost Center Management Modern JavaScript
let selectedLocation = '';

// DOM Elements
let locationSelect, departmentInput, submitBtn, form;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    setupFormValidation();
    setupKeyboardShortcuts();
});

function initializeElements() {
    locationSelect = document.getElementById('location');
    departmentInput = document.getElementById('department');
    submitBtn = document.querySelector('input[name="Submit"]');
    form = document.querySelector('form[name="frmsales"]');
}

function setupEventListeners() {
    if (locationSelect) {
        locationSelect.addEventListener('change', handleLocationChange);
    }
    
    if (departmentInput) {
        departmentInput.addEventListener('input', handleDepartmentInput);
    }
    
    if (submitBtn) {
        submitBtn.addEventListener('click', handleFormSubmit);
    }
    
    if (form) {
        form.addEventListener('submit', handleFormValidation);
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

function setupFormValidation() {
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
    
    // Validate location selection
    if (locationSelect && locationSelect.value === '') {
        errors.push('Please select a location');
        isValid = false;
    }
    
    // Validate department name
    if (departmentInput && departmentInput.value.trim() === '') {
        errors.push('Please enter a cost center name');
        isValid = false;
    } else if (departmentInput && departmentInput.value.trim().length > 100) {
        errors.push('Cost center name must be 100 characters or less');
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
        submitBtn.value = 'Adding...';
    }
}

function handleLocationChange() {
    if (locationSelect) {
        selectedLocation = locationSelect.value;
        updateLocationDisplay();
    }
}

function handleDepartmentInput() {
    if (departmentInput) {
        // Auto-uppercase the department name
        departmentInput.value = departmentInput.value.toUpperCase();
        
        // Update character count
        updateCharacterCount();
    }
}

function updateLocationDisplay() {
    const locationDisplay = document.getElementById('ajaxlocation');
    if (locationDisplay && selectedLocation) {
        // This would typically make an AJAX call to get location name
        // For now, we'll just show the selected location code
        locationDisplay.innerHTML = `<strong>Location: ${selectedLocation}</strong>`;
    }
}

function updateCharacterCount() {
    if (departmentInput) {
        const currentLength = departmentInput.value.length;
        const maxLength = 100;
        
        // Create or update character count display
        let countDisplay = document.getElementById('charCount');
        if (!countDisplay) {
            countDisplay = document.createElement('div');
            countDisplay.id = 'charCount';
            countDisplay.className = 'char-count';
            departmentInput.parentNode.appendChild(countDisplay);
        }
        
        countDisplay.textContent = `${currentLength}/${maxLength} characters`;
        
        // Change color based on length
        if (currentLength > maxLength * 0.9) {
            countDisplay.style.color = '#ef4444';
        } else if (currentLength > maxLength * 0.7) {
            countDisplay.style.color = '#f59e0b';
        } else {
            countDisplay.style.color = '#64748b';
        }
    }
}

function showLoadingState() {
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        alertContainer.innerHTML = `
            <div class="alert alert-info">
                <i class="fas fa-spinner fa-spin"></i>
                Adding cost center, please wait...
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

function setupKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl + S to submit
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            if (submitBtn) {
                submitBtn.click();
            }
        }
        
        // Escape to clear form
        if (e.key === 'Escape') {
            if (confirm('Are you sure you want to clear the form?')) {
                clearForm();
            }
        }
        
        // F5 to refresh
        if (e.key === 'F5') {
            e.preventDefault();
            refreshPage();
        }
    });
}

function clearForm() {
    if (locationSelect) {
        locationSelect.value = '';
    }
    
    if (departmentInput) {
        departmentInput.value = '';
    }
    
    selectedLocation = '';
    
    // Clear character count
    const countDisplay = document.getElementById('charCount');
    if (countDisplay) {
        countDisplay.remove();
    }
    
    showAlert('Form cleared successfully.', 'success');
}

function refreshPage() {
    window.location.reload();
}

function confirmDelete(costCenterName, costCenterId) {
    if (confirm(`Are you sure you want to delete the cost center "${costCenterName}"?`)) {
        // Show loading state
        showAlert('Deleting cost center, please wait...', 'info');
        
        // Redirect to delete URL
        window.location.href = `costcenter.php?st=del&anum=${costCenterId}`;
    }
}

function confirmActivate(costCenterName, costCenterId) {
    if (confirm(`Are you sure you want to activate the cost center "${costCenterName}"?`)) {
        // Show loading state
        showAlert('Activating cost center, please wait...', 'info');
        
        // Redirect to activate URL
        window.location.href = `costcenter.php?st=activate&anum=${costCenterId}`;
    }
}

// Backward compatibility functions
function ajaxlocationfunction(val) {
    // This function is called by the existing PHP-generated JavaScript
    // It's maintained for backward compatibility
    selectedLocation = val;
    updateLocationDisplay();
}

function addward1process1() {
    // This function is called by the existing form validation
    // It's maintained for backward compatibility
    return validateForm();
}

function funcDeleteDepartment1(costCenterName) {
    // This function is called by the existing delete links
    // It's maintained for backward compatibility
    return confirm(`Are you sure you want to delete the cost center "${costCenterName}"?`);
}

function noDecimal(evt) {
    // This function is for numbers only input validation
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
        return true;
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Cost Center Management page initialized');
    
    // Initialize character count display
    updateCharacterCount();
    
    // Show welcome message
    showAlert('Welcome to Cost Center Management. Add new cost centers or manage existing ones.', 'info');
    
    // Initialize location display
    if (locationSelect && locationSelect.value) {
        selectedLocation = locationSelect.value;
        updateLocationDisplay();
    }
});

// Additional utility functions
function formatCostCenterName(name) {
    return name.toUpperCase().trim();
}

function validateCostCenterName(name) {
    if (!name || name.trim() === '') {
        return { valid: false, message: 'Cost center name is required' };
    }
    
    if (name.length > 100) {
        return { valid: false, message: 'Cost center name must be 100 characters or less' };
    }
    
    // Check for special characters (optional validation)
    const specialChars = /[<>:"/\\|?*]/;
    if (specialChars.test(name)) {
        return { valid: false, message: 'Cost center name contains invalid characters' };
    }
    
    return { valid: true, message: 'Valid cost center name' };
}

function highlightTableRow(row) {
    // Remove existing highlights
    document.querySelectorAll('.modern-table tbody tr').forEach(r => {
        r.classList.remove('highlighted');
    });
    
    // Add highlight to selected row
    if (row) {
        row.classList.add('highlighted');
    }
}

function exportCostCenters() {
    // This would typically export cost center data to Excel
    showAlert('Export functionality would be implemented here.', 'info');
}