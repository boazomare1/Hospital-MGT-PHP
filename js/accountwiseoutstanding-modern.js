// Modern JavaScript for Account Wise Outstanding Report - MedStar Hospital Management System

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initSidebar();
    initFormValidation();
    initDatePickers();
    initAccountSearch();
    initReportGeneration();
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
    const form = document.getElementById('form1');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });
    
    // Real-time validation
    const inputs = form.querySelectorAll('input[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
}

function validateForm() {
    let isValid = true;
    const fromDate = document.getElementById('transactiondatefrom');
    const toDate = document.getElementById('transactiondateto');
    
    // Validate date range
    if (fromDate && toDate) {
        const fromDateValue = new Date(fromDate.value);
        const toDateValue = new Date(toDate.value);
        
        if (fromDateValue > toDateValue) {
            showFieldError(toDate, 'To date must be after from date');
            isValid = false;
        }
    }
    
    // Validate required fields
    const requiredFields = document.querySelectorAll('input[required]');
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
    
    // Date validation
    if (fieldName === 'transactiondatefrom' || fieldName === 'transactiondateto') {
        if (value && !isValidDate(value)) {
            showFieldError(field, 'Please enter a valid date');
            return false;
        }
    }
    
    // Days validation
    if (fieldName === 'daysafterbilldate' && value) {
        if (!/^\d+$/.test(value)) {
            showFieldError(field, 'Days must be a positive number');
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

function isValidDate(dateString) {
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

// Date picker initialization
function initDatePickers() {
    // Set default date range if not set
    const fromDate = document.getElementById('transactiondatefrom');
    const toDate = document.getElementById('transactiondateto');
    
    if (fromDate && !fromDate.value) {
        const oneMonthAgo = new Date();
        oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
        fromDate.value = oneMonthAgo.toISOString().split('T')[0];
    }
    
    if (toDate && !toDate.value) {
        const today = new Date();
        toDate.value = today.toISOString().split('T')[0];
    }
}

// Account search functionality
function initAccountSearch() {
    const searchInput = document.getElementById('searchsuppliername');
    if (!searchInput) return;
    
    // Auto-suggest functionality (placeholder for AJAX implementation)
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length >= 2) {
            // Here you would implement AJAX search for accounts
            console.log('Searching for account:', query);
        }
    });
    
    // Clear hidden fields when input is cleared
    searchInput.addEventListener('input', function() {
        if (!this.value.trim()) {
            document.getElementById('searchdescription').value = '';
            document.getElementById('searchemployeecode').value = '';
            document.getElementById('searchsuppliername1hiddentextbox').value = '';
        }
    });
}

// Report generation functionality
function initReportGeneration() {
    const form = document.getElementById('form1');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating Report...';
            
            // Re-enable button after 3 seconds (in case of errors)
            setTimeout(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-search"></i> Generate Report';
            }, 3000);
        }
    });
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

// Print functionality
function printReport() {
    const printButton = document.querySelector('button[onclick="window.print()"]');
    if (printButton) {
        printButton.addEventListener('click', function() {
            // Add print-specific styles
            const printStyles = document.createElement('style');
            printStyles.textContent = `
                @media print {
                    .sidebar, .floating-menu-toggle, .form-actions, .nav-breadcrumb {
                        display: none !important;
                    }
                    .main-content {
                        margin: 0 !important;
                        padding: 0 !important;
                    }
                    .report-table {
                        font-size: 12px !important;
                    }
                }
            `;
            document.head.appendChild(printStyles);
            
            window.print();
            
            // Remove print styles after printing
            setTimeout(() => {
                document.head.removeChild(printStyles);
            }, 1000);
        });
    }
}

// Legacy function compatibility
function funcAccount() {
    const searchInput = document.getElementById('searchsuppliername');
    if (searchInput && (!searchInput.value || searchInput.value.trim() === '')) {
        showNotification('Please select an account name', 'error');
        return false;
    }
    return true;
}

// Initialize print functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    printReport();
});

