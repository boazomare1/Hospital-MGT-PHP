// Monthly Consumption Report Modern JavaScript
// Handles sidebar, form validation, and responsive functionality

document.addEventListener('DOMContentLoaded', function() {
    initializeSidebar();
    initializeMenuToggle();
    initializeFormValidation();
    initializeResponsiveDesign();
    initializeTouchSupport();
});

// Sidebar Management
function initializeSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const menuToggle = document.getElementById('menuToggle');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            updateSidebarToggleIcon();
        });
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 992) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
}

function updateSidebarToggleIcon() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('leftSidebar');
    
    if (sidebarToggle) {
        const icon = sidebarToggle.querySelector('i');
        if (sidebar.classList.contains('collapsed')) {
            icon.className = 'fas fa-chevron-right';
        } else {
            icon.className = 'fas fa-chevron-left';
        }
    }
}

// Menu Toggle for Mobile
function initializeMenuToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('open');
        });
    }
}

// Form Validation
function initializeFormValidation() {
    const searchForm = document.querySelector('.search-filter-form');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!validateSearchForm()) {
                e.preventDefault();
                showAlert('Please fill in all required fields correctly.', 'error');
            }
        });
        
        // Real-time validation
        const inputs = searchForm.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearFieldValidation(this);
            });
        });
    }
}

function validateSearchForm() {
    const storecode1 = document.getElementById('storecode1');
    const ADate1 = document.getElementById('ADate1');
    const ADate2 = document.getElementById('ADate2');
    
    let isValid = true;
    
    // Validate store
    if (storecode1 && storecode1.value.trim() === '') {
        markFieldAsInvalid(storecode1, 'Store is required');
        isValid = false;
    }
    
    // Validate date from
    if (ADate1 && ADate1.value.trim() === '') {
        markFieldAsInvalid(ADate1, 'Date from is required');
        isValid = false;
    }
    
    // Validate date to
    if (ADate2 && ADate2.value.trim() === '') {
        markFieldAsInvalid(ADate2, 'Date to is required');
        isValid = false;
    }
    
    // Validate date range
    if (ADate1 && ADate2 && ADate1.value && ADate2.value) {
        const fromDate = new Date(ADate1.value);
        const toDate = new Date(ADate2.value);
        
        if (fromDate > toDate) {
            markFieldAsInvalid(ADate2, 'Date to must be after date from');
            isValid = false;
        }
        
        // Check if date range is not more than 1 year
        const diffTime = Math.abs(toDate - fromDate);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays > 365) {
            markFieldAsInvalid(ADate2, 'Date range cannot exceed 1 year');
            isValid = false;
        }
    }
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && value === '') {
        markFieldAsInvalid(field, 'This field is required');
        return false;
    }
    
    markFieldAsValid(field);
    return true;
}

function markFieldAsInvalid(field, message) {
    field.classList.remove('valid');
    field.classList.add('invalid');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Add error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.color = '#e74c3c';
    errorDiv.style.fontSize = '0.85rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

function markFieldAsValid(field) {
    field.classList.remove('invalid');
    field.classList.add('valid');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

function clearFieldValidation(field) {
    field.classList.remove('invalid', 'valid');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// Responsive Design
function initializeResponsiveDesign() {
    // Handle window resize
    window.addEventListener('resize', function() {
        handleResize();
    });
    
    // Initial resize handling
    handleResize();
}

function handleResize() {
    const sidebar = document.getElementById('leftSidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (window.innerWidth <= 992) {
        if (sidebar) {
            sidebar.classList.remove('collapsed');
        }
        if (mainContent) {
            mainContent.style.marginLeft = '0';
        }
    } else {
        if (sidebar && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
        }
    }
}

// Touch Support
function initializeTouchSupport() {
    // Add touch support for mobile devices
    if ('ontouchstart' in window) {
        document.body.classList.add('touch-device');
        
        // Handle touch events for sidebar
        const sidebar = document.getElementById('leftSidebar');
        if (sidebar) {
            let startX = 0;
            let currentX = 0;
            
            sidebar.addEventListener('touchstart', function(e) {
                startX = e.touches[0].clientX;
            });
            
            sidebar.addEventListener('touchmove', function(e) {
                currentX = e.touches[0].clientX;
            });
            
            sidebar.addEventListener('touchend', function(e) {
                const diff = startX - currentX;
                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        sidebar.classList.remove('open');
                    } else {
                        sidebar.classList.add('open');
                    }
                }
            });
        }
    }
}

// Utility Functions
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    
    // Remove existing alerts
    const existingAlerts = alertContainer.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `
        <i class="fas fa-${getAlertIcon(type)} alert-icon"></i>
        <span>${message}</span>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alert.parentElement) {
            alert.remove();
        }
    }, 5000);
}

function getAlertIcon(type) {
    switch (type) {
        case 'error': return 'exclamation-triangle';
        case 'success': return 'check-circle';
        case 'warning': return 'exclamation-circle';
        default: return 'info-circle';
    }
}

function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    // Implementation for Excel export
    showAlert('Export functionality will be implemented here.', 'info');
}

function printReport() {
    window.print();
}

function clearForm() {
    const searchForm = document.querySelector('.search-filter-form');
    if (searchForm) {
        searchForm.reset();
        
        // Clear validation states
        const inputs = searchForm.querySelectorAll('.form-input');
        inputs.forEach(input => {
            clearFieldValidation(input);
        });
        
        showAlert('Form cleared successfully.', 'success');
    }
}

// Global functions for legacy compatibility
function disableEnterKey() {
    return false;
}

// Add CSS for validation states
const style = document.createElement('style');
style.textContent = `
    .form-input.valid {
        border-color: #27ae60;
        box-shadow: 0 0 0 3px rgba(39,174,96,0.1);
    }
    
    .form-input.invalid {
        border-color: #e74c3c;
        box-shadow: 0 0 0 3px rgba(231,76,60,0.1);
    }
    
    .field-error {
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }
    
    .touch-device .floating-menu-toggle {
        display: none;
    }
    
    .alert-close {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        margin-left: auto;
        padding: 0.25rem;
        border-radius: 4px;
        transition: background 0.3s ease;
    }
    
    .alert-close:hover {
        background: rgba(0,0,0,0.1);
    }
`;
document.head.appendChild(style);




