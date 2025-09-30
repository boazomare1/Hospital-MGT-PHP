// Lab Category Master Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeSidebar();
    initializeFormValidation();
    initializeSearch();
    initializeAlerts();
});

// Sidebar functionality
function initializeSidebar() {
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
    
    // Close sidebar when clicking outside
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1024) {
            sidebar.classList.remove('open');
        }
    });
}

// Form validation
function initializeFormValidation() {
    const form = document.querySelector('form');
    if (!form) return;
    
    const categoryNameInput = document.querySelector('input[name="categoryname"]');
    if (!categoryNameInput) return;
    
    // Real-time validation
    categoryNameInput.addEventListener('input', function() {
        validateCategoryName(this);
    });
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });
}

function validateCategoryName(input) {
    const value = input.value.trim();
    const errorElement = input.parentNode.querySelector('.error-message');
    
    // Remove existing error message
    if (errorElement) {
        errorElement.remove();
    }
    
    // Validation rules
    if (value.length === 0) {
        showFieldError(input, 'Category name is required');
        return false;
    }
    
    if (value.length > 100) {
        showFieldError(input, 'Category name must be 100 characters or less');
        return false;
    }
    
    // Check for special characters
    const specialChars = /[!^+=[];,{}|\\<>?~]/;
    if (specialChars.test(value)) {
        showFieldError(input, 'Category name contains invalid special characters');
        return false;
    }
    
    // Clear any existing error styling
    input.classList.remove('error');
    return true;
}

function validateForm() {
    const categoryNameInput = document.querySelector('input[name="categoryname"]');
    let isValid = true;
    
    if (categoryNameInput) {
        if (!validateCategoryName(categoryNameInput)) {
            isValid = false;
        }
    }
    
    return isValid;
}

function showFieldError(input, message) {
    input.classList.add('error');
    
    // Remove existing error message
    const existingError = input.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    // Create error message element
    const errorElement = document.createElement('div');
    errorElement.className = 'error-message';
    errorElement.style.color = '#ef4444';
    errorElement.style.fontSize = '0.75rem';
    errorElement.style.marginTop = '0.25rem';
    errorElement.textContent = message;
    
    input.parentNode.appendChild(errorElement);
}

// Search functionality
function initializeSearch() {
    const searchInput = document.querySelector('input[name="search1"]');
    const searchForm = document.querySelector('form[method="get"]');
    
    if (!searchInput || !searchForm) return;
    
    // Debounced search
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch();
        }, 500);
    });
    
    // Search form submission
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        performSearch();
    });
}

function performSearch() {
    const searchInput = document.querySelector('input[name="search1"]');
    const searchForm = document.querySelector('form[method="get"]');
    
    if (!searchInput || !searchForm) return;
    
    const searchValue = searchInput.value.trim();
    
    // Add search flag
    const searchFlag = document.createElement('input');
    searchFlag.type = 'hidden';
    searchFlag.name = 'searchflag1';
    searchFlag.value = 'searchflag1';
    searchForm.appendChild(searchFlag);
    
    // Submit form
    searchForm.submit();
}

// Alert handling
function initializeAlerts() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        // Auto-hide success alerts after 5 seconds
        if (alert.classList.contains('success')) {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        }
        
        // Add close button to alerts
        const closeButton = document.createElement('button');
        closeButton.innerHTML = '&times;';
        closeButton.style.cssText = `
            position: absolute;
            top: 0.5rem;
            right: 0.75rem;
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: inherit;
            opacity: 0.7;
            transition: opacity 0.2s;
        `;
        
        closeButton.addEventListener('click', function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        });
        
        closeButton.addEventListener('mouseenter', function() {
            this.style.opacity = '1';
        });
        
        closeButton.addEventListener('mouseleave', function() {
            this.style.opacity = '0.7';
        });
        
        alert.style.position = 'relative';
        alert.appendChild(closeButton);
    });
}

// Utility functions
function showAlert(message, type = 'info') {
    const alertContainer = document.querySelector('.alert-container');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert ${type}`;
    alert.textContent = message;
    
    alertContainer.appendChild(alert);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }, 5000);
}

function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Delete confirmation
function confirmDelete(categoryName, deleteUrl) {
    confirmAction(`Are you sure you want to delete the category "${categoryName}"?`, function() {
        window.location.href = deleteUrl;
    });
}

// Activate confirmation
function confirmActivate(categoryName, activateUrl) {
    confirmAction(`Are you sure you want to activate the category "${categoryName}"?`, function() {
        window.location.href = activateUrl;
    });
}

// Set default status confirmation
function confirmSetDefault(categoryName, setDefaultUrl) {
    confirmAction(`Are you sure you want to set "${categoryName}" as the default category?`, function() {
        window.location.href = setDefaultUrl;
    });
}

// Remove default status confirmation
function confirmRemoveDefault(categoryName, removeDefaultUrl) {
    confirmAction(`Are you sure you want to remove the default status from "${categoryName}"?`, function() {
        window.location.href = removeDefaultUrl;
    });
}

// Export functions to global scope for use in HTML
window.confirmDelete = confirmDelete;
window.confirmActivate = confirmActivate;
window.confirmSetDefault = confirmSetDefault;
window.confirmRemoveDefault = confirmRemoveDefault;
