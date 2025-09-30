// Doctors Activity Report - Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize the application
    initializeApp();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Setup responsive behavior
    setupResponsiveBehavior();
});

function initializeApp() {
    // Add fade-in animation to main content
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.classList.add('fade-in');
    }
    
    // Initialize tooltips for better UX
    initializeTooltips();
    
    // Setup auto-refresh functionality
    setupAutoRefresh();
}

function setupEventListeners() {
    // Sidebar toggle functionality
    const sidebarToggle = document.getElementById('sidebarToggle');
    const leftSidebar = document.getElementById('leftSidebar');
    const menuToggle = document.getElementById('menuToggle');
    
    if (sidebarToggle && leftSidebar) {
        sidebarToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('collapsed');
            const icon = sidebarToggle.querySelector('i');
            if (leftSidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
        });
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            if (leftSidebar) {
                leftSidebar.classList.toggle('mobile-open');
            }
        });
    }
    
    // Form submission handling
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleFormSubmission(this);
        });
    }
    
    // Date input validation
    const dateInputs = document.querySelectorAll('.date-input');
    dateInputs.forEach(input => {
        input.addEventListener('change', function() {
            validateDateRange();
        });
    });
    
    // Doctor search input handling
    const doctorInput = document.getElementById('searchsuppliername');
    if (doctorInput) {
        doctorInput.addEventListener('input', function() {
            handleDoctorSearch(this.value);
        });
    }
    
    // Location change handling
    const locationSelect = document.getElementById('slocation');
    if (locationSelect) {
        locationSelect.addEventListener('change', function() {
            handleLocationChange(this.value);
        });
    }
}

function initializeFormValidation() {
    // Real-time form validation
    const formInputs = document.querySelectorAll('.form-input');
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
}

function setupResponsiveBehavior() {
    // Handle window resize
    window.addEventListener('resize', function() {
        handleWindowResize();
    });
    
    // Close mobile sidebar when clicking outside
    document.addEventListener('click', function(e) {
        const leftSidebar = document.getElementById('leftSidebar');
        const menuToggle = document.getElementById('menuToggle');
        
        if (leftSidebar && leftSidebar.classList.contains('mobile-open')) {
            if (!leftSidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                leftSidebar.classList.remove('mobile-open');
            }
        }
    });
}

function handleFormSubmission(form) {
    // Show loading state
    showLoadingState();
    
    // Validate form before submission
    if (!validateForm(form)) {
        hideLoadingState();
        return false;
    }
    
    // Add loading class to submit button
    const submitBtn = form.querySelector('.submit-btn');
    if (submitBtn) {
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
    }
    
    // Submit form after a short delay to show loading state
    setTimeout(() => {
        form.submit();
    }, 500);
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    // Validate date range
    if (!validateDateRange()) {
        isValid = false;
    }
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    const fieldType = field.type;
    let isValid = true;
    let errorMessage = '';
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'This field is required';
    }
    
    // Date validation
    if (fieldType === 'date' && value) {
        const date = new Date(value);
        const today = new Date();
        
        if (date > today) {
            isValid = false;
            errorMessage = 'Date cannot be in the future';
        }
    }
    
    // Show/hide error
    if (!isValid) {
        showFieldError(field, errorMessage);
    } else {
        clearFieldError(field);
    }
    
    return isValid;
}

function validateDateRange() {
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
    if (!dateFrom || !dateTo) return true;
    
    const fromValue = dateFrom.value;
    const toValue = dateTo.value;
    
    if (fromValue && toValue) {
        const fromDate = new Date(fromValue);
        const toDate = new Date(toValue);
        
        if (fromDate > toDate) {
            showFieldError(dateFrom, 'Start date cannot be after end date');
            showFieldError(dateTo, 'End date cannot be before start date');
            return false;
        } else {
            clearFieldError(dateFrom);
            clearFieldError(dateTo);
        }
    }
    
    return true;
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#e74c3c';
    errorDiv.style.fontSize = '0.8rem';
    errorDiv.style.marginTop = '0.25rem';
    
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('error');
    
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

function handleDoctorSearch(value) {
    // Debounce the search
    clearTimeout(window.doctorSearchTimeout);
    window.doctorSearchTimeout = setTimeout(() => {
        if (value.length >= 3) {
            // Show loading indicator
            showSearchLoading();
        } else {
            hideSearchLoading();
        }
    }, 300);
}

function handleLocationChange(locationCode) {
    // Update any location-dependent data
    console.log('Location changed to:', locationCode);
    
    // You can add AJAX calls here to update dependent fields
    if (locationCode) {
        updateLocationDependentData(locationCode);
    }
}

function updateLocationDependentData(locationCode) {
    // This function can be used to update other form fields based on location
    // For example, updating available doctors for the selected location
    console.log('Updating data for location:', locationCode);
}

function showLoadingState() {
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.classList.add('loading');
    }
}

function hideLoadingState() {
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.classList.remove('loading');
    }
}

function showSearchLoading() {
    const doctorInput = document.getElementById('searchsuppliername');
    if (doctorInput) {
        doctorInput.style.backgroundImage = 'url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'20\' height=\'20\' viewBox=\'0 0 24 24\'%3E%3Cpath fill=\'%233498db\' d=\'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z\'/%3E%3C/svg%3E")';
        doctorInput.style.backgroundRepeat = 'no-repeat';
        doctorInput.style.backgroundPosition = 'right 10px center';
    }
}

function hideSearchLoading() {
    const doctorInput = document.getElementById('searchsuppliername');
    if (doctorInput) {
        doctorInput.style.backgroundImage = '';
    }
}

function handleWindowResize() {
    const leftSidebar = document.getElementById('leftSidebar');
    
    if (window.innerWidth <= 768) {
        if (leftSidebar) {
            leftSidebar.classList.add('mobile');
        }
    } else {
        if (leftSidebar) {
            leftSidebar.classList.remove('mobile', 'mobile-open');
        }
    }
}

function initializeTooltips() {
    // Add tooltips to buttons and links
    const tooltipElements = document.querySelectorAll('[title]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

function showTooltip(e) {
    const element = e.target;
    const title = element.getAttribute('title');
    
    if (title) {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = title;
        tooltip.style.cssText = `
            position: absolute;
            background: #2c3e50;
            color: white;
            padding: 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            z-index: 1000;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        `;
        
        document.body.appendChild(tooltip);
        
        const rect = element.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
        
        setTimeout(() => {
            tooltip.style.opacity = '1';
        }, 10);
        
        element._tooltip = tooltip;
        element.removeAttribute('title');
    }
}

function hideTooltip(e) {
    const element = e.target;
    const tooltip = element._tooltip;
    
    if (tooltip) {
        tooltip.remove();
        delete element._tooltip;
    }
}

function setupAutoRefresh() {
    // Auto-refresh functionality for real-time data
    const refreshInterval = 5 * 60 * 1000; // 5 minutes
    
    setInterval(() => {
        if (document.visibilityState === 'visible') {
            // Only refresh if page is visible
            refreshData();
        }
    }, refreshInterval);
}

function refreshData() {
    // This function can be used to refresh data without full page reload
    console.log('Auto-refreshing data...');
    
    // You can add AJAX calls here to refresh specific data
    // For example, updating the results table
}

// Utility functions
function resetForm() {
    const form = document.querySelector('.search-form');
    if (form) {
        form.reset();
        
        // Clear all field errors
        const errorFields = form.querySelectorAll('.error');
        errorFields.forEach(field => {
            clearFieldError(field);
        });
        
        // Reset hidden fields
        const hiddenFields = form.querySelectorAll('input[type="hidden"]');
        hiddenFields.forEach(field => {
            if (field.name === 'searchemployeecode') {
                field.value = '';
            }
        });
        
        // Show success message
        showNotification('Form reset successfully', 'success');
    }
}

function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    // This function can be enhanced to trigger Excel export
    const form = document.querySelector('.search-form');
    if (form) {
        // Add export parameter and submit
        const exportInput = document.createElement('input');
        exportInput.type = 'hidden';
        exportInput.name = 'export';
        exportInput.value = 'excel';
        form.appendChild(exportInput);
        form.submit();
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        z-index: 1000;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
    `;
    
    // Set background color based on type
    switch (type) {
        case 'success':
            notification.style.background = 'linear-gradient(135deg, #27ae60 0%, #2ecc71 100%)';
            break;
        case 'error':
            notification.style.background = 'linear-gradient(135deg, #e74c3c 0%, #c0392b 100%)';
            break;
        default:
            notification.style.background = 'linear-gradient(135deg, #3498db 0%, #2980b9 100%)';
    }
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateX(0)';
    }, 10);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Global functions for backward compatibility
window.resetForm = resetForm;
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;






