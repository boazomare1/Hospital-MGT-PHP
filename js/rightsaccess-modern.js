// Modern JavaScript for Employee Rights Access - MedStar Hospital Management System

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initSidebar();
    initFormValidation();
    initEmployeeSearch();
    initAccessRights();
});

// Sidebar functionality
function initSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const mainContainer = document.getElementById('mainContainer');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (!sidebar || !mainContainer) return;
    
    // Mobile menu toggle
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
    
    // Sidebar toggle button
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
                mainContainer.classList.remove('sidebar-collapsed');
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1024) {
            mainContainer.classList.remove('sidebar-collapsed');
        }
    });
}

// Form validation
function initFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
        
        // Real-time validation
        const inputs = form.querySelectorAll('input[required], select[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('input[required], select[required]');
    
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.getAttribute('name') || field.getAttribute('id');
    
    // Clear previous errors
    clearFieldError(field);
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, `${getFieldLabel(field)} is required`);
        return false;
    }
    
    // Username validation
    if (fieldName === 'username1' && value) {
        if (!/^[a-zA-Z0-9_]+$/.test(value)) {
            showFieldError(field, 'Username can only contain letters, numbers, and underscores');
            return false;
        }
        if (value.length < 3) {
            showFieldError(field, 'Username must be at least 3 characters long');
            return false;
        }
    }
    
    // Password validation
    if (fieldName === 'password' && value) {
        if (value.length < 6) {
            showFieldError(field, 'Password must be at least 6 characters long');
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
}

function clearFieldError(field) {
    field.classList.remove('error');
    const errorElement = field.parentNode.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
}

function getFieldLabel(field) {
    const label = field.parentNode.querySelector('label');
    return label ? label.textContent.replace('*', '').trim() : field.getAttribute('name') || 'Field';
}

// Employee search functionality
function initEmployeeSearch() {
    const searchInput = document.getElementById('searchsuppliername');
    if (!searchInput) return;
    
    // Auto-suggest functionality (placeholder for AJAX implementation)
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length >= 2) {
            // Here you would implement AJAX search
            console.log('Searching for:', query);
        }
    });
    
    // Form submission validation
    const searchForm = document.getElementById('selectemployee');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const searchValue = searchInput.value.trim();
            if (!searchValue) {
                e.preventDefault();
                showFieldError(searchInput, 'Please enter an employee name to search');
                return false;
            }
        });
    }
}

// Access rights functionality
function initAccessRights() {
    // Select all functionality for checkboxes
    const selectAllCheckboxes = document.querySelectorAll('input[type="checkbox"][id*="checkall"]');
    
    selectAllCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const container = this.closest('.checkbox-group, .menu-permissions, .department-permissions');
            if (container) {
                const relatedCheckboxes = container.querySelectorAll('input[type="checkbox"]:not([id*="checkall"])');
                relatedCheckboxes.forEach(relatedCheckbox => {
                    relatedCheckbox.checked = this.checked;
                });
            }
        });
    });
    
    // Individual checkbox change handling
    const individualCheckboxes = document.querySelectorAll('input[type="checkbox"]:not([id*="checkall"])');
    individualCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllState(this);
        });
    });
}

function updateSelectAllState(checkbox) {
    const container = checkbox.closest('.checkbox-group, .menu-permissions, .department-permissions');
    if (!container) return;
    
    const selectAllCheckbox = container.querySelector('input[type="checkbox"][id*="checkall"]');
    if (!selectAllCheckbox) return;
    
    const allCheckboxes = container.querySelectorAll('input[type="checkbox"]:not([id*="checkall"])');
    const checkedCheckboxes = container.querySelectorAll('input[type="checkbox"]:not([id*="checkall"]):checked');
    
    if (checkedCheckboxes.length === 0) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = false;
    } else if (checkedCheckboxes.length === allCheckboxes.length) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = true;
    } else {
        selectAllCheckbox.indeterminate = true;
        selectAllCheckbox.checked = false;
    }
}

// Utility functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${getIconForType(type)} alert-icon"></i>
        <span>${message}</span>
    `;
    
    const container = document.querySelector('.main-content');
    if (container) {
        container.insertBefore(notification, container.firstChild);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
}

function getIconForType(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-triangle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Legacy function compatibility
function check_it() {
    const checkAllCheckbox = document.getElementById("checkall");
    if (checkAllCheckbox) {
        const checkboxes = document.querySelectorAll(".check_it_class");
        checkboxes.forEach(checkbox => {
            checkbox.checked = checkAllCheckbox.checked;
        });
    }
}