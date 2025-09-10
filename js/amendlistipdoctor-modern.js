// Amend IP Doctor List Modern JavaScript - Following VAT.php Structure
let allIPDoctorRecords = [];
let filteredIPDoctorRecords = [];
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

function initializeElements() {
    searchForm = document.getElementById('cbform1');
    searchInput = document.getElementById('patientname');
    paginationContainer = document.getElementById('paginationContainer');
}

function setupEventListeners() {
    if (searchForm) {
        searchForm.addEventListener('submit', handleSearchSubmit);
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce(performLiveSearch, 300));
    }
}

function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
}

function initializePagination() {
    // Initialize pagination if needed
    console.log('Amend IP Doctor List page initialized');
}

function setupAutoComplete() {
    // Setup autocomplete for patient search if needed
    console.log('Autocomplete setup completed');
}

function handleSearchSubmit(event) {
    // Validate search form before submission
    if (!validateSearchForm()) {
        event.preventDefault();
        return false;
    }
    
    // Show loading state
    showLoadingState('search');
    
    // Form will submit normally
    return true;
}

function validateSearchForm() {
    const errors = [];
    
    // Check if at least one search criteria is entered
    const patientName = document.getElementById('patientname');
    const patientCode = document.getElementById('patientcode');
    const visitCode = document.getElementById('visitcode');
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
    if ((!patientName || !patientName.value.trim()) && 
        (!patientCode || !patientCode.value.trim()) && 
        (!visitCode || !visitCode.value.trim()) && 
        (!dateFrom || !dateFrom.value.trim()) && 
        (!dateTo || !dateTo.value.trim())) {
        errors.push('Please enter at least one search criteria');
    }
    
    // Check date range validity
    if (dateFrom && dateFrom.value && dateTo && dateTo.value) {
        const fromDate = new Date(dateFrom.value);
        const toDate = new Date(dateTo.value);
        
        if (fromDate > toDate) {
            errors.push('Date From cannot be later than Date To');
        }
    }
    
    if (errors.length > 0) {
        errors.forEach(error => showAlert(error, 'error'));
        return false;
    }
    
    return true;
}

function showLoadingState(type) {
    const submitBtn = document.querySelector('.submit-btn');
    if (submitBtn && type === 'search') {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
        submitBtn.disabled = true;
    }
}

function hideLoadingState() {
    const submitBtn = document.querySelector('.submit-btn');
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fas fa-search"></i> Search';
        submitBtn.disabled = false;
    }
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : (type === 'error' ? 'exclamation-triangle' : 'info-circle')} alert-icon"></i>
        <span>${message}</span>
    `;
    
    alertContainer.appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.remove();
        }
    }, 5000);
}

function performLiveSearch(searchTerm) {
    if (searchTerm.length < 2) {
        clearSearch();
        return;
    }
    
    console.log('Searching for:', searchTerm);
    
    // Get all table rows
    const tableBody = document.getElementById('ipDoctorTableBody');
    if (!tableBody) return;
    
    const rows = tableBody.querySelectorAll('tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm.toLowerCase())) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    updateRecordCount();
}

function clearSearch() {
    if (searchInput) {
        searchInput.value = '';
    }
    
    // Show all rows
    const tableBody = document.getElementById('ipDoctorTableBody');
    if (tableBody) {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(row => {
            row.style.display = '';
        });
    }
    
    updateRecordCount();
}

function updateRecordCount() {
    const totalRecords = document.getElementById('totalRecords');
    if (totalRecords) {
        const tableBody = document.getElementById('ipDoctorTableBody');
        if (tableBody) {
            const visibleRows = Array.from(tableBody.querySelectorAll('tr')).filter(row => 
                row.style.display !== 'none'
            );
            totalRecords.textContent = visibleRows.length;
        }
    }
}

// IP Doctor functions
function viewPatientDetails(patientCode, visitCode) {
    // Here you would typically show a modal or navigate to patient details
    showAlert(`Viewing details for patient: ${patientCode}, visit: ${visitCode}`, 'info');
    
    // For demo purposes, you could open a new window or show a modal
    // window.open(`patientdetails.php?patientcode=${patientCode}&visitcode=${visitCode}`, '_blank');
}

function printConsultation(patientCode, visitCode) {
    // Here you would typically print the consultation details
    showAlert(`Printing consultation for patient: ${patientCode}, visit: ${visitCode}`, 'info');
    
    // For demo purposes, you could open a print window
    // window.open(`print_consultation.php?patientcode=${patientCode}&visitcode=${visitCode}`, '_blank');
}

function loadprintpage1(billAutoNumber) {
    // Legacy function for printing bills
    if (billAutoNumber) {
        window.open(`print_bill1_op1.php?billautonumber=${billAutoNumber}`, `Window${billAutoNumber}`, 'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
    }
}

function ajaxlocationfunction(locationCode) {
    // AJAX function for location changes
    console.log('Location changed to:', locationCode);
    
    // Here you could make an AJAX call to update location-specific data
    // For example, update patient lists, doctor lists, etc.
    
    showAlert(`Location changed to: ${locationCode}`, 'info');
}

// Utility functions
function refreshPage() {
    window.location.reload();
}

function resetSearchForm() {
    if (searchForm) {
        searchForm.reset();
        
        // Reset date fields to default values
        const dateFromInput = document.getElementById('ADate1');
        const dateToInput = document.getElementById('ADate2');
        
        if (dateFromInput) {
            dateFromInput.value = new Date(Date.now() - 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
        }
        if (dateToInput) {
            dateToInput.value = new Date().toISOString().split('T')[0];
        }
        
        // Clear any filtered results
        clearSearch();
        
        showAlert('Search form has been reset', 'info');
    }
}

function exportToExcel() {
    // Get the current search results table
    const table = document.querySelector('.data-table');
    if (!table) {
        showAlert('No data to export', 'error');
        return;
    }
    
    // Create a temporary link to download the table as CSV
    const csvContent = tableToCSV(table);
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'amend_ip_doctor_list.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        showAlert('Data exported successfully to CSV', 'success');
    } else {
        showAlert('Export not supported in this browser', 'error');
    }
}

function tableToCSV(table) {
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    rows.forEach(row => {
        const rowData = [];
        const cells = row.querySelectorAll('th, td');
        
        cells.forEach(cell => {
            // Get text content, removing any HTML tags
            let text = cell.textContent || cell.innerText || '';
            // Clean up the text
            text = text.replace(/\s+/g, ' ').trim();
            // Escape quotes and wrap in quotes if contains comma
            if (text.includes(',') || text.includes('"') || text.includes('\n')) {
                text = '"' + text.replace(/"/g, '""') + '"';
            }
            rowData.push(text);
        });
        
        csv.push(rowData.join(','));
    });
    
    return csv.join('\n');
}

// Debounce function for search
function debounce(func, wait) {
    let timeout;
    return function executedFunction() {
        const later = function() {
            clearTimeout(timeout);
            func.apply(this, arguments);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Handle responsive design
function handleResize() {
    const mainContainer = document.querySelector('.main-container-with-sidebar');
    if (window.innerWidth <= 768) {
        mainContainer.classList.add('mobile-view');
    } else {
        mainContainer.classList.remove('mobile-view');
    }
}

// Add resize event listener
window.addEventListener('resize', handleResize);

// Add loading states for better UX
function addLoadingStates() {
    const buttons = document.querySelectorAll('button[type="submit"], .btn');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (!this.disabled && this.type === 'submit') {
                this.classList.add('loading');
                this.disabled = true;
                
                // Re-enable after a delay (for demo purposes)
                setTimeout(() => {
                    this.classList.remove('loading');
                    this.disabled = false;
                }, 2000);
            }
        });
    });
}

// Initialize loading states
document.addEventListener('DOMContentLoaded', function() {
    addLoadingStates();
});

// Add accessibility improvements
function improveAccessibility() {
    // Add ARIA labels to form elements
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        if (!input.getAttribute('aria-label') && !input.getAttribute('id')) {
            const label = input.previousElementSibling;
            if (label && label.tagName === 'LABEL') {
                input.setAttribute('aria-label', label.textContent);
            }
        }
    });
    
    // Add keyboard navigation to tables
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
        table.setAttribute('role', 'grid');
        table.setAttribute('aria-label', 'IP Doctor consultations data table');
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

// Initialize accessibility improvements
document.addEventListener('DOMContentLoaded', function() {
    improveAccessibility();
});

// Add performance optimizations
function optimizePerformance() {
    // Lazy load images if any
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

// Initialize performance optimizations
document.addEventListener('DOMContentLoaded', function() {
    optimizePerformance();
});

// Add error boundary for better error handling
window.addEventListener('error', function(e) {
    console.error('JavaScript error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Add unhandled promise rejection handler
window.addEventListener('unhandledrejection', function(e) {
    console.error('Unhandled promise rejection:', e.reason);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Export functions to global scope for use in HTML
window.refreshPage = refreshPage;
window.resetSearchForm = resetSearchForm;
window.exportToExcel = exportToExcel;
window.viewPatientDetails = viewPatientDetails;
window.printConsultation = printConsultation;
window.loadprintpage1 = loadprintpage1;
window.ajaxlocationfunction = ajaxlocationfunction;










