// List IP Misc Billing Modern JavaScript - Following VAT.php Structure
let allMiscBillingRecords = [];
let filteredMiscBillingRecords = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let searchForm, searchInput, paginationContainer;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializePagination();
    setupAutoComplete();
});

// Initialize DOM elements
function initializeElements() {
    searchForm = document.getElementById('searchForm');
    searchInput = document.getElementById('searchInput');
    paginationContainer = document.getElementById('paginationContainer');
}

// Setup event listeners
function setupEventListeners() {
    if (searchForm) {
        searchForm.addEventListener('submit', handleSearch);
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce(handleLiveSearch, 300));
    }
    
    // Setup form validation
    setupFormValidation();
}

// Setup sidebar toggle functionality
function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
}

// Handle search form submission
function handleSearch(event) {
    event.preventDefault();
    
    const formData = new FormData(searchForm);
    const searchParams = new URLSearchParams();
    
    for (let [key, value] of formData.entries()) {
        if (value) {
            searchParams.append(key, value);
        }
    }
    
    // Show loading state
    showLoadingState();
    
    // Simulate search (replace with actual AJAX call)
    setTimeout(() => {
        hideLoadingState();
        showAlert('Search completed successfully!', 'success');
        
        // Update results display
        updateResultsDisplay();
    }, 1000);
}

// Handle live search
function handleLiveSearch(event) {
    const searchTerm = event.target.value.toLowerCase();
    
    if (searchTerm.length < 2) {
        // Reset to show all records
        filteredMiscBillingRecords = [...allMiscBillingRecords];
        updateResultsDisplay();
        return;
    }
    
    // Filter records based on search term
    filteredMiscBillingRecords = allMiscBillingRecords.filter(record => {
        return (
            record.patientname.toLowerCase().includes(searchTerm) ||
            record.patientcode.toLowerCase().includes(searchTerm) ||
            record.visitcode.toLowerCase().includes(searchTerm) ||
            record.description.toLowerCase().includes(searchTerm)
        );
    });
    
    currentPage = 1;
    updateResultsDisplay();
}

// Setup form validation
function setupFormValidation() {
    const form = document.getElementById('searchForm');
    if (!form) return;
    
    const inputs = form.querySelectorAll('input[required], select[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', clearFieldError);
    });
}

// Validate individual field
function validateField(event) {
    const field = event.target;
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Additional validation rules
    if (field.type === 'email' && value && !isValidEmail(value)) {
        showFieldError(field, 'Please enter a valid email address');
        return false;
    }
    
    if (field.type === 'tel' && value && !isValidPhone(value)) {
        showFieldError(field, 'Please enter a valid phone number');
        return false;
    }
    
    return true;
}

// Clear field error
function clearFieldError(event) {
    const field = event.target;
    hideFieldError(field);
}

// Show field error
function showFieldError(field, message) {
    hideFieldError(field);
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#e74c3c';
    errorDiv.style.fontSize = '0.85rem';
    errorDiv.style.marginTop = '0.25rem';
    
    field.parentNode.appendChild(errorDiv);
    field.style.borderColor = '#e74c3c';
}

// Hide field error
function hideFieldError(field) {
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    field.style.borderColor = '#e1e8ed';
}

// Validation helper functions
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
    return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
}

// Initialize pagination
function initializePagination() {
    if (!paginationContainer) return;
    
    // Get total records count
    const totalRecords = document.querySelectorAll('#miscBillingTableBody tr').length;
    const totalPages = Math.ceil(totalRecords / itemsPerPage);
    
    if (totalPages <= 1) {
        paginationContainer.style.display = 'none';
        return;
    }
    
    renderPagination(totalPages);
}

// Render pagination controls
function renderPagination(totalPages) {
    if (!paginationContainer) return;
    
    let paginationHTML = '<div class="pagination-controls">';
    
    // Previous button
    paginationHTML += `<button class="pagination-btn ${currentPage === 1 ? 'disabled' : ''}" 
                                onclick="changePage(${currentPage - 1})" 
                                ${currentPage === 1 ? 'disabled' : ''}>
                          <i class="fas fa-chevron-left"></i> Previous
                       </button>`;
    
    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            paginationHTML += `<button class="pagination-btn ${i === currentPage ? 'active' : ''}" 
                                        onclick="changePage(${i})">
                                ${i}
                              </button>`;
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            paginationHTML += '<span class="pagination-ellipsis">...</span>';
        }
    }
    
    // Next button
    paginationHTML += `<button class="pagination-btn ${currentPage === totalPages ? 'disabled' : ''}" 
                                onclick="changePage(${currentPage + 1})" 
                                ${currentPage === totalPages ? 'disabled' : ''}>
                          Next <i class="fas fa-chevron-right"></i>
                       </button>`;
    
    paginationHTML += '</div>';
    
    paginationContainer.innerHTML = paginationHTML;
}

// Change page
function changePage(page) {
    const totalRecords = document.querySelectorAll('#miscBillingTableBody tr').length;
    const totalPages = Math.ceil(totalRecords / itemsPerPage);
    
    if (page < 1 || page > totalPages) return;
    
    currentPage = page;
    updateResultsDisplay();
    renderPagination(totalPages);
    
    // Scroll to top of results
    const resultsSection = document.querySelector('.data-table-section');
    if (resultsSection) {
        resultsSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// Update results display
function updateResultsDisplay() {
    const tableBody = document.getElementById('miscBillingTableBody');
    if (!tableBody) return;
    
    const rows = tableBody.querySelectorAll('tr');
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    
    // Hide all rows
    rows.forEach((row, index) => {
        if (index >= startIndex && index < endIndex) {
            row.style.display = '';
            row.className = index % 2 === 0 ? 'even-row' : 'odd-row';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update pagination
    const totalRecords = rows.length;
    const totalPages = Math.ceil(totalRecords / itemsPerPage);
    renderPagination(totalPages);
    
    // Update summary
    updateSummary(totalRecords);
}

// Update summary information
function updateSummary(totalRecords) {
    const summaryElement = document.getElementById('totalRecords');
    if (summaryElement) {
        summaryElement.textContent = totalRecords;
    }
}

// Setup autocomplete functionality
function setupAutoComplete() {
    // Patient name autocomplete
    const patientNameInput = document.getElementById('patientname');
    if (patientNameInput) {
        setupPatientAutocomplete(patientNameInput);
    }
    
    // Patient code autocomplete
    const patientCodeInput = document.getElementById('patientcode');
    if (patientCodeInput) {
        setupPatientCodeAutocomplete(patientCodeInput);
    }
    
    // Visit code autocomplete
    const visitCodeInput = document.getElementById('visitcode');
    if (visitCodeInput) {
        setupVisitCodeAutocomplete(visitCodeInput);
    }
}

// Setup patient name autocomplete
function setupPatientAutocomplete(input) {
    let autocompleteList = null;
    
    input.addEventListener('input', function() {
        const query = this.value.trim();
        
        if (query.length < 2) {
            hideAutocomplete();
            return;
        }
        
        // Simulate AJAX call for patient names
        const suggestions = getPatientNameSuggestions(query);
        showAutocomplete(input, suggestions);
    });
    
    input.addEventListener('blur', function() {
        setTimeout(hideAutocomplete, 200);
    });
}

// Setup patient code autocomplete
function setupPatientCodeAutocomplete(input) {
    let autocompleteList = null;
    
    input.addEventListener('input', function() {
        const query = this.value.trim();
        
        if (query.length < 2) {
            hideAutocomplete();
            return;
        }
        
        // Simulate AJAX call for patient codes
        const suggestions = getPatientCodeSuggestions(query);
        showAutocomplete(input, suggestions);
    });
    
    input.addEventListener('blur', function() {
        setTimeout(hideAutocomplete, 200);
    });
}

// Setup visit code autocomplete
function setupVisitCodeAutocomplete(input) {
    let autocompleteList = null;
    
    input.addEventListener('input', function() {
        const query = this.value.trim();
        
        if (query.length < 2) {
            hideAutocomplete();
            return;
        }
        
        // Simulate AJAX call for visit codes
        const suggestions = getVisitCodeSuggestions(query);
        showAutocomplete(input, suggestions);
    });
    
    input.addEventListener('blur', function() {
        setTimeout(hideAutocomplete, 200);
    });
}

// Show autocomplete suggestions
function showAutocomplete(input, suggestions) {
    hideAutocomplete();
    
    if (suggestions.length === 0) return;
    
    const autocompleteList = document.createElement('ul');
    autocompleteList.className = 'autocomplete-list';
    autocompleteList.style.cssText = `
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #e1e8ed;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 1000;
        max-height: 200px;
        overflow-y: auto;
        list-style: none;
        margin: 0;
        padding: 0;
    `;
    
    suggestions.forEach(suggestion => {
        const li = document.createElement('li');
        li.textContent = suggestion;
        li.style.cssText = `
            padding: 0.75rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f1f3f4;
            transition: background 0.2s ease;
        `;
        
        li.addEventListener('mouseenter', function() {
            this.style.background = '#f8f9fa';
        });
        
        li.addEventListener('mouseleave', function() {
            this.style.background = 'white';
        });
        
        li.addEventListener('click', function() {
            input.value = suggestion;
            hideAutocomplete();
            input.focus();
        });
        
        autocompleteList.appendChild(li);
    });
    
    input.parentNode.style.position = 'relative';
    input.parentNode.appendChild(autocompleteList);
}

// Hide autocomplete
function hideAutocomplete() {
    const existingList = document.querySelector('.autocomplete-list');
    if (existingList) {
        existingList.remove();
    }
}

// Get patient name suggestions (simulated)
function getPatientNameSuggestions(query) {
    // This would normally come from a database
    const allNames = [
        'John Smith', 'Jane Doe', 'Michael Johnson', 'Sarah Wilson',
        'David Brown', 'Lisa Davis', 'Robert Miller', 'Jennifer Garcia'
    ];
    
    return allNames.filter(name => 
        name.toLowerCase().includes(query.toLowerCase())
    ).slice(0, 5);
}

// Get patient code suggestions (simulated)
function getPatientCodeSuggestions(query) {
    // This would normally come from a database
    const allCodes = [
        'P001', 'P002', 'P003', 'P004', 'P005',
        'P006', 'P007', 'P008', 'P009', 'P010'
    ];
    
    return allCodes.filter(code => 
        code.toLowerCase().includes(query.toLowerCase())
    ).slice(0, 5);
}

// Get visit code suggestions (simulated)
function getVisitCodeSuggestions(query) {
    // This would normally come from a database
    const allCodes = [
        'V001', 'V002', 'V003', 'V004', 'V005',
        'V006', 'V007', 'V008', 'V009', 'V010'
    ];
    
    return allCodes.filter(code => 
        code.toLowerCase().includes(query.toLowerCase())
    ).slice(0, 5);
}

// Show loading state
function showLoadingState() {
    const submitBtn = document.querySelector('.submit-btn');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
        submitBtn.classList.add('loading');
    }
}

// Hide loading state
function hideLoadingState() {
    const submitBtn = document.querySelector('.submit-btn');
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-search"></i> Search';
        submitBtn.classList.remove('loading');
    }
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = `
        <i class="alert-icon fas fa-${getAlertIcon(type)}"></i>
        <span>${message}</span>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    alertContainer.appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.remove();
        }
    }, 5000);
}

// Get alert icon based on type
function getAlertIcon(type) {
    switch (type) {
        case 'success': return 'check-circle';
        case 'error': return 'exclamation-circle';
        case 'warning': return 'exclamation-triangle';
        default: return 'info-circle';
    }
}

// Utility function: debounce
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Export to CSV functionality
function exportToCSV() {
    const table = document.querySelector('.data-table');
    if (!table) return;
    
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    rows.forEach(row => {
        const rowData = [];
        const cells = row.querySelectorAll('th, td');
        
        cells.forEach(cell => {
            // Remove action buttons and get clean text
            const cleanText = cell.textContent.trim().replace(/\s+/g, ' ');
            rowData.push(`"${cleanText}"`);
        });
        
        csv.push(rowData.join(','));
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'ip_misc_billing_data.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Print functionality
function printPage() {
    window.print();
}

// View patient details
function viewPatientDetails(patientcode, visitcode) {
    showAlert(`Viewing details for Patient: ${patientcode}, Visit: ${visitcode}`, 'info');
    // This would normally open a modal or navigate to a details page
}

// Edit patient record
function editPatientRecord(patientcode, visitcode) {
    showAlert(`Editing record for Patient: ${patientcode}, Visit: ${visitcode}`, 'info');
    // This would normally open an edit form or navigate to an edit page
}

// Delete patient record
function deletePatientRecord(patientcode, visitcode) {
    if (confirm(`Are you sure you want to delete the record for Patient: ${patientcode}, Visit: ${visitcode}?`)) {
        showAlert(`Record deleted for Patient: ${patientcode}, Visit: ${visitcode}`, 'success');
        // This would normally make an AJAX call to delete the record
    }
}

// Print patient record
function printPatientRecord(patientcode, visitcode) {
    showAlert(`Printing record for Patient: ${patientcode}, Visit: ${visitcode}`, 'info');
    // This would normally open a print dialog or generate a PDF
}

// Update remarks
function updateRemarks(patientcode, visitcode, remarks) {
    if (!remarks.trim()) {
        showAlert('Please enter remarks before updating', 'error');
        return;
    }
    
    showAlert(`Remarks updated for Patient: ${patientcode}, Visit: ${visitcode}`, 'success');
    // This would normally make an AJAX call to update the remarks
}

// Accessibility improvements
function setupAccessibility() {
    // Add ARIA labels to form elements
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        if (!input.getAttribute('aria-label') && !input.getAttribute('aria-labelledby')) {
            const label = input.parentNode.querySelector('label');
            if (label) {
                input.setAttribute('aria-labelledby', label.id || 'label-' + Math.random().toString(36).substr(2, 9));
            }
        }
    });
    
    // Add keyboard navigation to action buttons
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(button => {
        button.setAttribute('tabindex', '0');
        button.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
}

// Initialize accessibility features
document.addEventListener('DOMContentLoaded', function() {
    setupAccessibility();
});

// Performance optimization: lazy load images and heavy content
function setupLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback for older browsers
        images.forEach(img => {
            img.src = img.dataset.src;
            img.classList.remove('lazy');
        });
    }
}

// Initialize lazy loading
document.addEventListener('DOMContentLoaded', function() {
    setupLazyLoading();
});

// Error handling for AJAX calls
function handleAjaxError(error, context = '') {
    console.error('AJAX Error:', error, context);
    
    let errorMessage = 'An error occurred while processing your request.';
    
    if (error.status === 404) {
        errorMessage = 'The requested resource was not found.';
    } else if (error.status === 500) {
        errorMessage = 'A server error occurred. Please try again later.';
    } else if (error.status === 0) {
        errorMessage = 'Network error. Please check your connection.';
    }
    
    showAlert(errorMessage, 'error');
}

// Success handling for AJAX calls
function handleAjaxSuccess(response, context = '') {
    console.log('AJAX Success:', response, context);
    
    if (response.success) {
        showAlert(response.message || 'Operation completed successfully!', 'success');
    } else {
        showAlert(response.message || 'Operation failed.', 'error');
    }
}

// Form submission with AJAX
function submitFormWithAjax(form, successCallback = null) {
    const formData = new FormData(form);
    
    // Show loading state
    showLoadingState();
    
    // Simulate AJAX call (replace with actual fetch/XMLHttpRequest)
    setTimeout(() => {
        hideLoadingState();
        
        // Simulate success response
        const response = {
            success: true,
            message: 'Form submitted successfully!'
        };
        
        handleAjaxSuccess(response, 'Form submission');
        
        if (successCallback && typeof successCallback === 'function') {
            successCallback(response);
        }
    }, 1000);
}

// Initialize form submission handlers
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[data-ajax]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            submitFormWithAjax(this);
        });
    });
});










