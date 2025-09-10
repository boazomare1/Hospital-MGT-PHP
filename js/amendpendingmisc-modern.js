// Amend Pending Misc Modern JavaScript - Following VAT.php Structure
let allPendingRecords = [];
let filteredPendingRecords = [];
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
});

function initializeElements() {
    searchForm = document.getElementById('searchForm');
    searchInput = document.getElementById('patientname1');
    paginationContainer = document.getElementById('paginationContainer');
}

function setupEventListeners() {
    if (searchForm) {
        searchForm.addEventListener('submit', handleFormSubmit);
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
    console.log('Amend Pending Misc page initialized');
}

function handleFormSubmit(event) {
    // Validate form before submission
    if (!validateForm()) {
        event.preventDefault();
        return false;
    }
    
    // Show loading state
    showLoadingState();
    
    // Form will submit normally
    return true;
}

function validateForm() {
    const errors = [];
    
    // Check if at least one search criteria is provided
    const patientName = document.getElementById('patientname1');
    const patientCode = document.getElementById('patientcode1');
    const visitCode = document.getElementById('visitcode1');
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
    if ((!patientName || !patientName.value.trim()) && 
        (!patientCode || !patientCode.value.trim()) && 
        (!visitCode || !visitCode.value.trim()) &&
        (!dateFrom || !dateFrom.value) &&
        (!dateTo || !dateTo.value)) {
        errors.push('Please provide at least one search criteria');
    }
    
    // Validate date range if both dates are provided
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

function showLoadingState() {
    const submitBtn = document.querySelector('.submit-btn');
    if (submitBtn) {
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
    const tableBody = document.getElementById('pendingMiscTableBody');
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
}

function clearSearch() {
    if (searchInput) {
        searchInput.value = '';
    }
    
    // Show all rows
    const tableBody = document.getElementById('pendingMiscTableBody');
    if (tableBody) {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(row => {
            row.style.display = '';
        });
    }
}

// Utility functions
function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    // Get the current report table
    const table = document.getElementById('pendingMiscTable');
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
        link.setAttribute('download', 'pending_misc_report.csv');
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
        if (searchInput) {
            searchInput.focus();
        }
    }
    
    // Escape key to clear search
    if (e.key === 'Escape') {
        if (searchInput) {
            clearSearch();
            searchInput.focus();
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
        table.setAttribute('aria-label', 'Pending Misc Data Table');
    });
    
    // Add keyboard navigation to action buttons
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(button => {
        button.setAttribute('tabindex', '0');
        button.setAttribute('role', 'button');
        
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

// Add form auto-submit functionality for better UX
function setupAutoSubmit() {
    const formInputs = document.querySelectorAll('.form-input');
    formInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Auto-submit form after a short delay when inputs change
            clearTimeout(input.autoSubmitTimer);
            input.autoSubmitTimer = setTimeout(() => {
                if (this.form && this.form.checkValidity()) {
                    this.form.submit();
                }
            }, 1000);
        });
    });
}

// Initialize auto-submit
document.addEventListener('DOMContentLoaded', function() {
    setupAutoSubmit();
});

// Add table row highlighting for better UX
function setupTableRowHighlighting() {
    const tableRows = document.querySelectorAll('.data-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
}

// Initialize table row highlighting
document.addEventListener('DOMContentLoaded', function() {
    setupTableRowHighlighting();
});

// Export functions to global scope for use in HTML
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;
window.validateSearchForm = validateForm;











