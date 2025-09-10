// Amend Pending Service Modern JavaScript - Following Hospital Theme

let allServiceRecords = [];
let filteredServiceRecords = [];
let currentPage = 1;
const itemsPerPage = 20;

// DOM Elements
let searchForm, searchInput, paginationContainer, totalRecordsElement;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializePagination();
    setupAutoComplete();
    updateTotalRecordsCount();
});

// Initialize DOM elements
function initializeElements() {
    searchForm = document.getElementById('searchForm');
    searchInput = document.getElementById('patientname1');
    paginationContainer = document.getElementById('paginationContainer');
    totalRecordsElement = document.getElementById('totalRecords');
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
    
    // Setup date picker functionality
    setupDatePickers();
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

// Setup date picker functionality
function setupDatePickers() {
    const fromDateInput = document.getElementById('ADate1');
    const toDateInput = document.getElementById('ADate2');
    
    if (fromDateInput && toDateInput) {
        // Set default dates if not already set
        if (!fromDateInput.value) {
            const defaultFromDate = new Date();
            defaultFromDate.setMonth(defaultFromDate.getMonth() - 1);
            fromDateInput.value = defaultFromDate.toISOString().split('T')[0];
        }
        
        if (!toDateInput.value) {
            toDateInput.value = new Date().toISOString().split('T')[0];
        }
        
        // Add date validation
        fromDateInput.addEventListener('change', function() {
            if (toDateInput.value && this.value > toDateInput.value) {
                toDateInput.value = this.value;
            }
        });
        
        toDateInput.addEventListener('change', function() {
            if (fromDateInput.value && this.value < fromDateInput.value) {
                fromDateInput.value = this.value;
            }
        });
    }
}

// Handle search form submission
function handleSearch(event) {
    event.preventDefault();
    
    // Show loading state
    showLoadingState();
    
    // Get form data
    const formData = new FormData(searchForm);
    const searchParams = new URLSearchParams();
    
    for (let [key, value] of formData.entries()) {
        if (value) {
            searchParams.append(key, value);
        }
    }
    
    // Redirect to search results
    window.location.href = 'amend_pending_service.php?' + searchParams.toString();
}

// Handle live search
function handleLiveSearch(event) {
    const searchTerm = event.target.value.toLowerCase();
    
    if (searchTerm.length < 2) {
        // Reset to show all records
        filteredServiceRecords = [...allServiceRecords];
        updateResultsDisplay();
        return;
    }
    
    // Filter records based on search term
    filteredServiceRecords = allServiceRecords.filter(record => {
        return (
            record.patientname.toLowerCase().includes(searchTerm) ||
            record.patientcode.toLowerCase().includes(searchTerm) ||
            record.visitcode.toLowerCase().includes(searchTerm)
        );
    });
    
    updateResultsDisplay();
}

// Setup form validation
function setupFormValidation() {
    const inputs = document.querySelectorAll('.form-input');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
}

// Validate individual field
function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'This field is required';
    }
    
    // Date validation
    if (field.type === 'date' && value) {
        const selectedDate = new Date(value);
        const today = new Date();
        
        if (selectedDate > today) {
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

// Show field error
function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

// Clear field error
function clearFieldError(field) {
    field.classList.remove('error');
    
    const errorDiv = field.parentNode.querySelector('.field-error');
    if (errorDiv) {
        errorDiv.remove();
    }
}

// Initialize pagination
function initializePagination() {
    if (paginationContainer) {
        updatePagination();
    }
}

// Update pagination display
function updatePagination() {
    if (!paginationContainer) return;
    
    const totalPages = Math.ceil(filteredServiceRecords.length / itemsPerPage);
    
    if (totalPages <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }
    
    let paginationHTML = '<div class="pagination-controls">';
    
    // Previous button
    paginationHTML += `<button class="pagination-btn ${currentPage === 1 ? 'disabled' : ''}" 
                                onclick="changePage(${currentPage - 1})" 
                                ${currentPage === 1 ? 'disabled' : ''}>
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>`;
    
    // Page numbers
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, currentPage + 2);
    
    if (startPage > 1) {
        paginationHTML += '<span class="pagination-ellipsis">...</span>';
    }
    
    for (let i = startPage; i <= endPage; i++) {
        paginationHTML += `<button class="pagination-btn ${i === currentPage ? 'active' : ''}" 
                                    onclick="changePage(${i})">
                                ${i}
                            </button>`;
    }
    
    if (endPage < totalPages) {
        paginationHTML += '<span class="pagination-ellipsis">...</span>';
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
    if (page < 1 || page > Math.ceil(filteredServiceRecords.length / itemsPerPage)) {
        return;
    }
    
    currentPage = page;
    updateResultsDisplay();
    updatePagination();
    
    // Scroll to top of table
    const tableSection = document.querySelector('.data-table-section');
    if (tableSection) {
        tableSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// Update results display
function updateResultsDisplay() {
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentRecords = filteredServiceRecords.slice(startIndex, endIndex);
    
    // Update table body
    const tableBody = document.getElementById('serviceTableBody');
    if (tableBody) {
        // This would normally update the table rows dynamically
        // For now, we'll just update the pagination
        updatePagination();
    }
}

// Setup autocomplete
function setupAutoComplete() {
    // This would normally set up autocomplete for search fields
    // For now, it's a placeholder for future enhancement
}

// Show loading state
function showLoadingState() {
    const submitBtn = document.querySelector('.submit-btn');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
    }
}

// Hide loading state
function hideLoadingState() {
    const submitBtn = document.querySelector('.submit-btn');
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-search"></i> Search';
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
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Get alert icon based on type
function getAlertIcon(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    
    return icons[type] || 'info-circle';
}

// Update total records count
function updateTotalRecordsCount() {
    if (totalRecordsElement) {
        const rows = document.querySelectorAll('#serviceTableBody tr');
        totalRecordsElement.textContent = rows.length;
    }
}

// Utility function: Debounce
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
    if (!table) {
        showAlert('No data to export', 'error');
        return;
    }
    
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    for (let i = 0; i < rows.length; i++) {
        let row = [], cols = rows[i].querySelectorAll('td, th');
        
        for (let j = 0; j < cols.length; j++) {
            // Get text content and clean it
            let text = cols[j].innerText.replace(/,/g, ';');
            row.push('"' + text + '"');
        }
        
        csv.push(row.join(','));
    }
    
    // Download CSV file
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'pending_services.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Print page functionality
function printPage() {
    window.print();
}

// View patient details
function viewPatientDetails(patientcode, visitcode) {
    showAlert(`Viewing patient details: ${patientcode} - ${visitcode}`, 'info');
    
    // This would normally open a modal or navigate to a view page
    console.log('Viewing patient details:', patientcode, visitcode);
}

// Print consultation
function printConsultation(patientcode, visitcode) {
    showAlert(`Printing consultation: ${patientcode} - ${visitcode}`, 'info');
    
    // This would normally open a print window or navigate to a print page
    console.log('Printing consultation:', patientcode, visitcode);
}

// View service details
function viewServiceDetails(patientcode, visitcode) {
    showAlert(`Viewing service details: ${patientcode} - ${visitcode}`, 'info');
    
    // This would normally open a modal or navigate to a view page
    console.log('Viewing service details:', patientcode, visitcode);
}

// Keyboard navigation support
document.addEventListener('keydown', function(event) {
    // Ctrl/Cmd + F for search focus
    if ((event.ctrlKey || event.metaKey) && event.key === 'f') {
        event.preventDefault();
        const searchInput = document.getElementById('patientname1');
        if (searchInput) {
            searchInput.focus();
        }
    }
    
    // Ctrl/Cmd + P for print
    if ((event.ctrlKey || event.metaKey) && event.key === 'p') {
        event.preventDefault();
        printPage();
    }
    
    // Ctrl/Cmd + S for export
    if ((event.ctrlKey || event.metaKey) && event.key === 's') {
        event.preventDefault();
        exportToCSV();
    }
});

// Performance optimization: Lazy load images and heavy content
function setupLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
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
}

// Initialize lazy loading
setupLazyLoading();









