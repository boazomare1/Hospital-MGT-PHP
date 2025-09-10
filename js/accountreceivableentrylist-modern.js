// Account Receivable Entry List Modern JavaScript - Following Hospital Theme

let allAccountReceivableRecords = [];
let filteredAccountReceivableRecords = [];
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
    searchInput = document.getElementById('searchdocno');
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
    const fromDateInput = document.getElementById('fromdate');
    const toDateInput = document.getElementById('todate');
    
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
    window.location.href = 'accountreceivableentrylist_amend.php?' + searchParams.toString();
}

// Handle live search
function handleLiveSearch(event) {
    const searchTerm = event.target.value.toLowerCase();
    
    if (searchTerm.length < 2) {
        // Reset to show all records
        filteredAccountReceivableRecords = [...allAccountReceivableRecords];
        updateResultsDisplay();
        return;
    }
    
    // Filter records based on search term
    filteredAccountReceivableRecords = allAccountReceivableRecords.filter(record => {
        return (
            record.docno.toLowerCase().includes(searchTerm) ||
            record.accountname.toLowerCase().includes(searchTerm) ||
            record.subtype.toLowerCase().includes(searchTerm)
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
    
    const totalPages = Math.ceil(filteredAccountReceivableRecords.length / itemsPerPage);
    
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
    if (page < 1 || page > Math.ceil(filteredAccountReceivableRecords.length / itemsPerPage)) {
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
    const currentRecords = filteredAccountReceivableRecords.slice(startIndex, endIndex);
    
    // Update table body
    const tableBody = document.getElementById('accountReceivableTableBody');
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
        const rows = document.querySelectorAll('#accountReceivableTableBody tr');
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

// Utility function: Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

// Utility function: Format date
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
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
        link.setAttribute('download', 'account_receivable_entries.csv');
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

// Enhanced delete entry function
function deleteEntry(docno, sourceTable) {
    if (confirm('Are you sure you want to delete this entry? This action cannot be undone.')) {
        // Show loading state
        showAlert('Deleting entry...', 'info');
        
        // Create a form to submit the delete request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'accountreceivableentrylist_amend.php';
        
        const delInput = document.createElement('input');
        delInput.type = 'hidden';
        delInput.name = 'del';
        delInput.value = '1';
        form.appendChild(delInput);
        
        const tblInput = document.createElement('input');
        tblInput.type = 'hidden';
        tblInput.name = 'tbl';
        tblInput.value = sourceTable;
        form.appendChild(tblInput);
        
        const docnoInput = document.createElement('input');
        docnoInput.type = 'hidden';
        docnoInput.name = 'docno';
        docnoInput.value = docno;
        form.appendChild(docnoInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Enhanced view entry function
function viewEntry(docno, sourceTable) {
    showAlert(`Viewing entry: ${docno} from ${sourceTable}`, 'info');
    
    // This would normally open a modal or navigate to a view page
    // For now, we'll just show an alert
    console.log('Viewing entry:', docno, 'from table:', sourceTable);
}

// Enhanced edit entry function
function editEntry(docno, sourceTable) {
    showAlert(`Editing entry: ${docno} from ${sourceTable}`, 'info');
    
    // This would normally open an edit form or navigate to an edit page
    // For now, we'll just show an alert
    console.log('Editing entry:', docno, 'from table:', sourceTable);
}

// Enhanced print entry function
function printEntry(docno) {
    showAlert(`Printing entry: ${docno}`, 'info');
    
    // This would normally open a print window or navigate to a print page
    // For now, we'll just show an alert
    console.log('Printing entry:', docno);
}

// Keyboard navigation support
document.addEventListener('keydown', function(event) {
    // Ctrl/Cmd + F for search focus
    if ((event.ctrlKey || event.metaKey) && event.key === 'f') {
        event.preventDefault();
        const searchInput = document.getElementById('searchdocno');
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

// Auto-refresh functionality (optional)
function setupAutoRefresh() {
    // Refresh the page every 5 minutes to get updated data
    setInterval(() => {
        // Only refresh if user is not actively interacting
        if (!document.hasFocus()) {
            location.reload();
        }
    }, 5 * 60 * 1000);
}

// Initialize auto-refresh (uncomment if needed)
// setupAutoRefresh();

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
