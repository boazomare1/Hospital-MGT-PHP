// Patientwise ICD Report - Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize the application
    initializeApp();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize autocomplete
    initializeAutocomplete();
});

function initializeApp() {
    // Set up sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const leftSidebar = document.getElementById('leftSidebar');
    const menuToggle = document.getElementById('menuToggle');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('open');
        });
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('open');
        });
    }
    
    // Close sidebar when clicking outside
    document.addEventListener('click', function(e) {
        if (!leftSidebar.contains(e.target) && !menuToggle.contains(e.target)) {
            leftSidebar.classList.remove('open');
        }
    });
    
    // Initialize form validation
    initializeFormValidation();
    
    // Setup date pickers
    setupDatePickers();
}

function setupEventListeners() {
    // Form submission
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
            
            // Show loading state
            showLoading();
        });
    }
    
    // Reset button
    const resetButton = document.querySelector('button[type="reset"]');
    if (resetButton) {
        resetButton.addEventListener('click', function() {
            resetForm();
        });
    }
    
    // Export Excel button
    const exportButtons = document.querySelectorAll('[onclick="exportToExcel()"]');
    exportButtons.forEach(button => {
        button.addEventListener('click', function() {
            exportToExcel();
        });
    });
    
    // Refresh button
    const refreshButtons = document.querySelectorAll('[onclick="refreshPage()"]');
    refreshButtons.forEach(button => {
        button.addEventListener('click', function() {
            refreshPage();
        });
    });
    
    // Age range change
    const rangeSelect = document.getElementById('range');
    const ageInput = document.getElementById('age');
    
    if (rangeSelect && ageInput) {
        rangeSelect.addEventListener('change', function() {
            if (this.value && !ageInput.value) {
                ageInput.focus();
                showAlert('Please enter an age value for the selected range.', 'info');
            }
        });
    }
    
    // Real-time validation
    const formInputs = document.querySelectorAll('.form-input, .form-select');
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
}

function initializeFormValidation() {
    // Add validation rules
    const validationRules = {
        'age': {
            pattern: /^\d+$/,
            message: 'Age must be a valid number'
        },
        'icdcode': {
            pattern: /^[A-Z0-9.-]+$/i,
            message: 'ICD code must contain only letters, numbers, dots, and hyphens'
        },
        'disease': {
            pattern: /^[a-zA-Z\s.-]+$/,
            message: 'Disease name must contain only letters, spaces, dots, and hyphens'
        }
    };
    
    // Store validation rules globally
    window.validationRules = validationRules;
}

function validateForm() {
    let isValid = true;
    const form = document.querySelector('.search-form');
    
    if (!form) return true;
    
    // Clear previous errors
    clearAllErrors();
    
    // Validate required fields
    const requiredFields = ['ADate1', 'ADate2'];
    requiredFields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (field && !field.value.trim()) {
            showFieldError(field, 'This field is required');
            isValid = false;
        }
    });
    
    // Validate date range
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
    if (dateFrom && dateTo && dateFrom.value && dateTo.value) {
        const fromDate = new Date(dateFrom.value);
        const toDate = new Date(dateTo.value);
        
        if (fromDate > toDate) {
            showFieldError(dateTo, 'End date must be after start date');
            isValid = false;
        }
    }
    
    // Validate individual fields
    const formInputs = form.querySelectorAll('.form-input, .form-select');
    formInputs.forEach(input => {
        if (!validateField(input)) {
            isValid = false;
        }
    });
    
    return isValid;
}

function validateField(field) {
    const fieldName = field.name || field.id;
    const rules = window.validationRules[fieldName];
    
    if (!rules) return true;
    
    const value = field.value.trim();
    
    if (value && !rules.pattern.test(value)) {
        showFieldError(field, rules.message);
        return false;
    }
    
    clearFieldError(field);
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
    
    const errorDiv = field.parentNode.querySelector('.field-error');
    if (errorDiv) {
        errorDiv.remove();
    }
}

function clearAllErrors() {
    const errorDivs = document.querySelectorAll('.field-error');
    errorDivs.forEach(div => div.remove());
    
    const errorFields = document.querySelectorAll('.form-input.error, .form-select.error');
    errorFields.forEach(field => field.classList.remove('error'));
}

function setupDatePickers() {
    // Initialize date pickers if the functions exist
    if (typeof NewCssCal === 'function') {
        // Date picker is already initialized
        console.log('Date picker functions available');
    }
}

function initializeAutocomplete() {
    // Initialize autocomplete for account search
    if (typeof AutoSuggestControl !== 'undefined' && typeof StateSuggestions !== 'undefined') {
        const accountInput = document.getElementById('searchsuppliername');
        if (accountInput) {
            try {
                new AutoSuggestControl(accountInput, new StateSuggestions());
            } catch (error) {
                console.warn('Autocomplete initialization failed:', error);
            }
        }
    }
}

function showLoading() {
    const form = document.querySelector('.search-form');
    if (form) {
        form.classList.add('loading');
        
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
        }
    }
}

function hideLoading() {
    const form = document.querySelector('.search-form');
    if (form) {
        form.classList.remove('loading');
        
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-search"></i> Search';
        }
    }
}

function resetForm() {
    const form = document.querySelector('.search-form');
    if (form) {
        form.reset();
        clearAllErrors();
        
        // Reset date fields to default values
        const dateFrom = document.getElementById('ADate1');
        const dateTo = document.getElementById('ADate2');
        
        if (dateFrom) {
            const oneMonthAgo = new Date();
            oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
            dateFrom.value = oneMonthAgo.toISOString().split('T')[0];
        }
        
        if (dateTo) {
            const today = new Date();
            dateTo.value = today.toISOString().split('T')[0];
        }
        
        showAlert('Form has been reset', 'info');
    }
}

function exportToExcel() {
    const form = document.querySelector('.search-form');
    if (!form) {
        showAlert('No search form found', 'error');
        return;
    }
    
    // Get form data
    const formData = new FormData(form);
    const params = new URLSearchParams();
    
    for (let [key, value] of formData.entries()) {
        if (value) {
            params.append(key, value);
        }
    }
    
    // Add additional parameters
    const urlParams = new URLSearchParams(window.location.search);
    for (let [key, value] of urlParams.entries()) {
        if (value && !params.has(key)) {
            params.append(key, value);
        }
    }
    
    // Construct export URL
    const exportUrl = `print_patientwiseicd.php?${params.toString()}`;
    
    // Open in new window
    window.open(exportUrl, '_blank');
    
    showAlert('Export initiated. Please check your downloads.', 'info');
}

function refreshPage() {
    window.location.reload();
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    // Remove existing alerts
    const existingAlerts = alertContainer.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    
    const iconClass = {
        'success': 'fas fa-check-circle',
        'error': 'fas fa-exclamation-triangle',
        'info': 'fas fa-info-circle',
        'warning': 'fas fa-exclamation-circle'
    }[type] || 'fas fa-info-circle';
    
    alertDiv.innerHTML = `
        <i class="${iconClass} alert-icon"></i>
        <span>${message}</span>
    `;
    
    alertContainer.appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Legacy function support
function funcOnLoadBodyFunctionCall1() {
    // Initialize autocomplete on page load
    initializeAutocomplete();
    
    // Set focus to first input
    const firstInput = document.querySelector('.form-input');
    if (firstInput) {
        firstInput.focus();
    }
}

// Utility functions
function disableEnterKey() {
    return false;
}

// Table enhancements
function enhanceTable() {
    const table = document.querySelector('.data-table');
    if (!table) return;
    
    // Add sorting functionality
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', () => sortTable(index));
    });
    
    // Add search functionality
    addTableSearch();
}

function sortTable(columnIndex) {
    const table = document.querySelector('.data-table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    const isAscending = table.getAttribute('data-sort-direction') !== 'asc';
    
    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();
        
        if (isAscending) {
            return aText.localeCompare(bText);
        } else {
            return bText.localeCompare(aText);
        }
    });
    
    rows.forEach(row => tbody.appendChild(row));
    table.setAttribute('data-sort-direction', isAscending ? 'asc' : 'desc');
}

function addTableSearch() {
    const table = document.querySelector('.data-table');
    if (!table) return;
    
    // Add search input above table
    const searchContainer = document.createElement('div');
    searchContainer.className = 'table-search-container';
    searchContainer.innerHTML = `
        <div class="table-search">
            <i class="fas fa-search"></i>
            <input type="text" id="tableSearch" placeholder="Search table..." class="form-input">
        </div>
    `;
    
    table.parentNode.insertBefore(searchContainer, table);
    
    // Add search functionality
    const searchInput = document.getElementById('tableSearch');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
}

// Initialize table enhancements when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(enhanceTable, 1000); // Delay to ensure table is rendered
});

// Export functions for global access
window.exportToExcel = exportToExcel;
window.refreshPage = refreshPage;
window.funcOnLoadBodyFunctionCall1 = funcOnLoadBodyFunctionCall1;
window.disableEnterKey = disableEnterKey;

