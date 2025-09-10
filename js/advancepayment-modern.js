// Advance Payment Entries Modern JavaScript
let allPaymentRecords = [];
let filteredPaymentRecords = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let searchTypeSelect, searchSupplierNameInput, searchDocNoInput, dateFromInput, dateToInput, searchForm, searchResultsTable;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializeSearch();
});

function initializeElements() {
    searchTypeSelect = document.getElementById('search_type');
    searchSupplierNameInput = document.getElementById('searchsuppliername');
    searchDocNoInput = document.getElementById('docno');
    dateFromInput = document.getElementById('ADate1');
    dateToInput = document.getElementById('ADate2');
    searchForm = document.getElementById('searchForm');
    searchResultsTable = document.querySelector('.data-table');
}

function setupEventListeners() {
    if (searchTypeSelect) {
        searchTypeSelect.addEventListener('change', handleSearchTypeChange);
    }
    
    if (searchForm) {
        searchForm.addEventListener('submit', handleFormSubmit);
    }
    
    if (dateFromInput && dateToInput) {
        dateFromInput.addEventListener('change', validateDateRange);
        dateToInput.addEventListener('change', validateDateRange);
    }
    
    // Auto-submit form when search type changes
    if (searchTypeSelect) {
        searchTypeSelect.addEventListener('change', function() {
            if (document.getElementById('cbfrmflag1').value) {
                searchForm.submit();
            }
        });
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

function initializeSearch() {
    // Initialize any search-related functionality
    console.log('Advance Payment Entries page initialized');
}

function handleSearchTypeChange() {
    const searchType = searchTypeSelect.value;
    console.log('Search type changed to:', searchType);
    
    // Auto-submit form if search type changes
    if (searchForm && document.getElementById('cbfrmflag1').value) {
        searchForm.submit();
    }
}

function handleFormSubmit(event) {
    // Validate date range before submission
    if (!validateDateRange()) {
        event.preventDefault();
        return false;
    }
    
    // Show loading state
    showLoadingState();
    
    // Form will submit normally
    return true;
}

function validateDateRange() {
    const dateFrom = dateFromInput.value;
    const dateTo = dateToInput.value;
    
    if (dateFrom && dateTo && new Date(dateFrom) > new Date(dateTo)) {
        showAlert('Date From cannot be later than Date To', 'error');
        return false;
    }
    
    return true;
}

function showLoadingState() {
    // Add loading indicator to submit button
    const submitBtn = searchForm.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
        submitBtn.disabled = true;
    }
}

function hideLoadingState() {
    // Remove loading indicator from submit button
    const submitBtn = searchForm.querySelector('button[type="submit"]');
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
        <button type="button" class="btn-close" onclick="this.parentElement.remove()">×</button>
    `;
    
    alertContainer.appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.remove();
        }
    }, 5000);
}

// Delete entry function
function confirmDelete(docNo, autoNumber) {
    if (confirm('Are you sure you want to delete this payment entry? This action cannot be undone.')) {
        const remarks = prompt('Please enter a reason for deletion:');
        if (remarks !== null) {
            // Redirect to delete action
            window.location.href = 'advancepaymententry_list.php?action=del&doc=' + encodeURIComponent(docNo) + '&anum=' + encodeURIComponent(autoNumber) + '&remarks=' + encodeURIComponent(remarks);
        }
    }
}

// Refresh page function
function refreshPage() {
    window.location.reload();
}

// Export to Excel function
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
        link.setAttribute('download', 'advance_payment_entries.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
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

// Search functionality
function performLiveSearch() {
    const searchTerm = searchSupplierNameInput.value;
    if (searchTerm.length >= 2) {
        console.log('Searching for:', searchTerm);
        // Implement live search functionality here if needed
    }
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

// Apply debouncing to search
const debouncedSearch = debounce(performLiveSearch, 300);

// Add event listener for live search
if (searchSupplierNameInput) {
    searchSupplierNameInput.addEventListener('input', debouncedSearch);
}

// Utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
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

// Initialize responsive design
handleResize();

// Add smooth scrolling for better UX
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add keyboard navigation support
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + F for search focus
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        if (searchSupplierNameInput) {
            searchSupplierNameInput.focus();
        }
    }
    
    // Escape key to clear search
    if (e.key === 'Escape') {
        if (searchSupplierNameInput) {
            searchSupplierNameInput.value = '';
            searchSupplierNameInput.focus();
        }
    }
});

// Add tooltip functionality
function initializeTooltips() {
    const tooltipElements = document.querySelectorAll('[title]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

function showTooltip(event) {
    const element = event.target;
    const tooltipText = element.getAttribute('title');
    
    if (!tooltipText) return;
    
    const tooltip = document.createElement('div');
    tooltip.className = 'custom-tooltip';
    tooltip.textContent = tooltipText;
    tooltip.style.cssText = `
        position: absolute;
        background: #333;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 1000;
        pointer-events: none;
        white-space: nowrap;
    `;
    
    document.body.appendChild(tooltip);
    
    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
    
    element.tooltip = tooltip;
}

function hideTooltip(event) {
    const element = event.target;
    if (element.tooltip) {
        element.tooltip.remove();
        element.tooltip = null;
    }
}

// Initialize tooltips when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeTooltips();
});

// Add loading states for better UX
function addLoadingStates() {
    const buttons = document.querySelectorAll('button[type="submit"], .btn');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (!this.disabled) {
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

// Add success/error message handling
function handleFormSuccess(message) {
    showAlert(message, 'success');
    // Reset form if needed
    if (searchForm) {
        searchForm.reset();
    }
}

function handleFormError(message) {
    showAlert(message, 'error');
}

// Add confirmation dialogs for destructive actions
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Add data validation
function validateForm() {
    const errors = [];
    
    if (dateFromInput && dateToInput) {
        if (dateFromInput.value && dateToInput.value) {
            if (new Date(dateFromInput.value) > new Date(dateToInput.value)) {
                errors.push('Date From cannot be later than Date To');
            }
        }
    }
    
    if (errors.length > 0) {
        errors.forEach(error => showAlert(error, 'error'));
        return false;
    }
    
    return true;
}

// Add form validation to submit
if (searchForm) {
    searchForm.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
    });
}

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
        table.setAttribute('aria-label', 'Data table');
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
window.confirmDelete = confirmDelete;
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;











