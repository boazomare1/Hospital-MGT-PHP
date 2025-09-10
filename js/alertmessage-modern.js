// Alert Message Modern JavaScript - Following VAT.php Structure
let allAlertRecords = [];
let filteredAlertRecords = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let alertForm, searchInput, paginationContainer;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializePagination();
});

function initializeElements() {
    alertForm = document.getElementById('alertForm');
    searchInput = document.getElementById('searchInput');
    paginationContainer = document.getElementById('paginationContainer');
}

function setupEventListeners() {
    if (alertForm) {
        alertForm.addEventListener('submit', handleFormSubmit);
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
    console.log('Alert Message page initialized');
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
    
    // Check required fields
    const alertMessage = document.getElementById('alertmessage');
    if (!alertMessage || !alertMessage.value.trim()) {
        errors.push('Alert message is required');
    }
    
    if (errors.length > 0) {
        errors.forEach(error => showAlert(error, 'error'));
        return false;
    }
    
    return true;
}

function showLoadingState() {
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        submitBtn.disabled = true;
    }
}

function hideLoadingState() {
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fas fa-save"></i> Add Alert Message';
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
    const tableBody = document.getElementById('alertTableBody');
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
    const tableBody = document.getElementById('alertTableBody');
    if (tableBody) {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(row => {
            row.style.display = '';
        });
    }
}

function searchMessages(searchTerm) {
    performLiveSearch(searchTerm);
}

// Utility functions
function refreshPage() {
    window.location.reload();
}

function resetForm() {
    if (alertForm) {
        alertForm.reset();
        showAlert('Form has been reset', 'info');
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
        link.setAttribute('download', 'alert_messages.csv');
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

// Delete and Activate functions
function confirmDelete(message, autoNumber) {
    if (confirm('Are you sure you want to delete this alert message? This action cannot be undone.')) {
        window.location.href = 'addalertmessage1.php?st=del&anum=' + encodeURIComponent(autoNumber);
    }
}

function confirmActivate(message, autoNumber) {
    if (confirm('Are you sure you want to activate this alert message?')) {
        window.location.href = 'addalertmessage1.php?st=activate&anum=' + encodeURIComponent(autoNumber);
    }
}

function viewMessage(message) {
    alert('Alert Message:\n\n' + message);
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
window.refreshPage = refreshPage;
window.resetForm = resetForm;
window.exportToExcel = exportToExcel;
window.searchMessages = searchMessages;
window.clearSearch = clearSearch;
window.confirmDelete = confirmDelete;
window.confirmActivate = confirmActivate;
window.viewMessage = viewMessage;
