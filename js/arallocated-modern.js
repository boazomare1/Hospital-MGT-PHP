// AR Allocated Report Modern JavaScript - Following VAT.php Structure
let allARRecords = [];
let filteredARRecords = [];
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
    searchInput = document.getElementById('searchinvoice');
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
    console.log('AR Allocated Report page initialized');
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
    const subtypeSearch = document.getElementById('searchsuppliername1');
    const invoiceSearch = document.getElementById('searchinvoice');
    
    if ((!subtypeSearch || !subtypeSearch.value.trim()) && 
        (!invoiceSearch || !invoiceSearch.value.trim())) {
        errors.push('Please provide either a subtype or invoice number to search');
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
    const tableBody = document.getElementById('arReportTableBody');
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
    const tableBody = document.getElementById('arReportTableBody');
    if (tableBody) {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(row => {
            row.style.display = '';
        });
    }
}

// Toggle functions for expandable rows
function toggleSubtype(subtypeId) {
    const subtypeDetails = document.getElementById(subtypeId);
    const subtypeHeader = document.querySelector(`tr[onclick="toggleSubtype('${subtypeId}')"]`);
    
    if (subtypeDetails && subtypeHeader) {
        const isVisible = subtypeDetails.style.display !== 'none';
        const icon = subtypeHeader.querySelector('i');
        
        if (isVisible) {
            subtypeDetails.style.display = 'none';
            if (icon) icon.className = 'fas fa-chevron-right';
        } else {
            subtypeDetails.style.display = 'table-row-group';
            if (icon) icon.className = 'fas fa-chevron-down';
        }
    }
}

function toggleAR(arDocno) {
    const arDetails = document.querySelectorAll(`.ar-${arDocno}`);
    const arHeader = document.querySelector(`tr[onclick="toggleAR('${arDocno}')"]`);
    
    if (arDetails.length > 0 && arHeader) {
        const isVisible = arDetails[0].style.display !== 'none';
        const icon = arHeader.querySelector('i');
        
        arDetails.forEach(detail => {
            if (isVisible) {
                detail.style.display = 'none';
            } else {
                detail.style.display = 'table-row';
            }
        });
        
        if (icon) {
            if (isVisible) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-down';
            }
        }
    }
}

// Utility functions
function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    // Get the current report table
    const table = document.getElementById('arReportTable');
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
        link.setAttribute('download', 'ar_allocated_report.csv');
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
        table.setAttribute('aria-label', 'AR Report Data Table');
    });
    
    // Add keyboard navigation to expandable rows
    const expandableRows = document.querySelectorAll('.subtype-header, .ar-header');
    expandableRows.forEach(row => {
        row.setAttribute('tabindex', '0');
        row.setAttribute('role', 'button');
        row.setAttribute('aria-expanded', 'false');
        
        row.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                if (this.classList.contains('subtype-header')) {
                    const subtypeId = this.getAttribute('onclick').match(/'([^']+)'/)[1];
                    toggleSubtype(subtypeId);
                    this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'false' ? 'true' : 'false');
                } else if (this.classList.contains('ar-header')) {
                    const arDocno = this.getAttribute('onclick').match(/'([^']+)'/)[1];
                    toggleAR(arDocno);
                    this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'false' ? 'true' : 'false');
                }
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
window.exportToExcel = exportToExcel;
window.toggleSubtype = toggleSubtype;
window.toggleAR = toggleAR;
window.validateSearchForm = validateForm;











