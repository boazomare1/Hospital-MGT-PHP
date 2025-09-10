// Modern JavaScript for creditapprovallist.php

document.addEventListener('DOMContentLoaded', function() {
    initializeCreditApprovalList();
});

function initializeCreditApprovalList() {
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize date pickers
    initializeDatePickers();
    
    // Initialize table functionality
    initializeTableFeatures();
    
    // Initialize search functionality
    initializeSearchFeatures();
    
    // Initialize summary calculations
    initializeSummaryCalculations();
    
    // Add loading states
    addLoadingStates();
}

function initializeFormValidation() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                return false;
            }
            
            // Add loading state
            addLoadingState(this);
        });
        
        // Real-time validation
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', validateField);
            input.addEventListener('input', clearFieldError);
        });
    });
}

function validateForm(form) {
    let isValid = true;
    
    // Validate date range
    const fromDate = form.querySelector('input[name="fromdate"]');
    const toDate = form.querySelector('input[name="todate"]');
    
    if (fromDate && toDate && fromDate.value && toDate.value) {
        if (new Date(fromDate.value) > new Date(toDate.value)) {
            showFieldError(toDate, 'To date must be after from date');
            isValid = false;
        }
    }
    
    // Validate required fields
    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        if (!validateField({ target: field })) {
            isValid = false;
        }
    });
    
    return isValid;
}

function validateField(event) {
    const field = event.target;
    const value = field.value.trim();
    
    // Clear previous errors
    clearFieldError(event);
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Date validation
    if (field.type === 'date' && value) {
        const date = new Date(value);
        if (isNaN(date.getTime())) {
            showFieldError(field, 'Please enter a valid date');
            return false;
        }
    }
    
    return true;
}

function showFieldError(field, message) {
    // Remove existing error
    clearFieldError({ target: field });
    
    // Add error class
    field.classList.add('error');
    
    // Create error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#e74c3c';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';
    
    // Insert error message
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(event) {
    const field = event.target;
    field.classList.remove('error');
    
    const errorDiv = field.parentNode.querySelector('.field-error');
    if (errorDiv) {
        errorDiv.remove();
    }
}

function initializeDatePickers() {
    // Enhanced date picker functionality
    const dateInputs = document.querySelectorAll('input[type="date"]');
    
    dateInputs.forEach(input => {
        // Set default values if empty
        if (!input.value) {
            const today = new Date();
            const oneMonthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
            
            if (input.name === 'fromdate') {
                input.value = formatDate(oneMonthAgo);
            } else if (input.name === 'todate') {
                input.value = formatDate(today);
            }
        }
        
        // Add date validation
        input.addEventListener('change', function() {
            validateDateRange();
        });
    });
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function validateDateRange() {
    const fromDate = document.querySelector('input[name="fromdate"]');
    const toDate = document.querySelector('input[name="todate"]');
    
    if (fromDate && toDate && fromDate.value && toDate.value) {
        if (new Date(fromDate.value) > new Date(toDate.value)) {
            showFieldError(toDate, 'To date must be after from date');
        } else {
            clearFieldError({ target: toDate });
        }
    }
}

function initializeTableFeatures() {
    const tables = document.querySelectorAll('.modern-table');
    tables.forEach(table => {
        // Add sort functionality
        addTableSorting(table);
        
        // Add search functionality
        addTableSearch(table);
        
        // Add status formatting
        formatStatusBadges(table);
    });
}

function addTableSorting(table) {
    const headers = table.querySelectorAll('th');
    
    headers.forEach((header, index) => {
        if (header.textContent.trim() && !header.querySelector('.action-buttons')) {
            header.style.cursor = 'pointer';
            header.style.userSelect = 'none';
            header.innerHTML += ' <span class="sort-indicator">↕</span>';
            
            header.addEventListener('click', function() {
                sortTable(table, index);
            });
        }
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const isAscending = table.getAttribute('data-sort-direction') !== 'asc';
    
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();
        
        // Try to parse as numbers (for amounts)
        const aNum = parseFloat(aValue.replace(/[^0-9.-]/g, ''));
        const bNum = parseFloat(bValue.replace(/[^0-9.-]/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? aNum - bNum : bNum - aNum;
        }
        
        // String comparison
        return isAscending ? 
            aValue.localeCompare(bValue) : 
            bValue.localeCompare(aValue);
    });
    
    // Update table
    rows.forEach(row => tbody.appendChild(row));
    
    // Update sort direction
    table.setAttribute('data-sort-direction', isAscending ? 'asc' : 'desc');
    
    // Update sort indicators
    const indicators = table.querySelectorAll('.sort-indicator');
    indicators.forEach(indicator => indicator.textContent = '↕');
    
    const currentIndicator = table.querySelectorAll('th')[columnIndex].querySelector('.sort-indicator');
    if (currentIndicator) {
        currentIndicator.textContent = isAscending ? '↑' : '↓';
    }
}

function addTableSearch(table) {
    const searchContainer = document.createElement('div');
    searchContainer.className = 'table-search';
    searchContainer.style.marginBottom = '1rem';
    
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Search in table...';
    searchInput.className = 'form-control';
    searchInput.style.maxWidth = '300px';
    
    searchContainer.appendChild(searchInput);
    table.parentNode.insertBefore(searchContainer, table);
    
    searchInput.addEventListener('input', function() {
        filterTable(table, this.value);
    });
}

function filterTable(table, searchTerm) {
    const tbody = table.querySelector('tbody');
    const rows = tbody.querySelectorAll('tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const matches = text.includes(searchTerm.toLowerCase());
        row.style.display = matches ? '' : 'none';
    });
}

function formatStatusBadges(table) {
    const cells = table.querySelectorAll('td');
    cells.forEach(cell => {
        const text = cell.textContent.trim().toLowerCase();
        
        if (text.includes('pending')) {
            cell.innerHTML = '<span class="status-badge status-pending">Pending</span>';
        } else if (text.includes('approved')) {
            cell.innerHTML = '<span class="status-badge status-approved">Approved</span>';
        } else if (text.includes('rejected')) {
            cell.innerHTML = '<span class="status-badge status-rejected">Rejected</span>';
        } else if (text.includes('processing')) {
            cell.innerHTML = '<span class="status-badge status-processing">Processing</span>';
        }
    });
}

function initializeSearchFeatures() {
    // Initialize global search
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            performGlobalSearch(this.value);
        });
    }
    
    // Initialize filter dropdowns
    const filterSelects = document.querySelectorAll('select[name="status"], select[name="location"]');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            applyFilters();
        });
    });
}

function performGlobalSearch(searchTerm) {
    const tables = document.querySelectorAll('.modern-table');
    tables.forEach(table => {
        filterTable(table, searchTerm);
    });
}

function applyFilters() {
    const statusFilter = document.querySelector('select[name="status"]');
    const locationFilter = document.querySelector('select[name="location"]');
    const tables = document.querySelectorAll('.modern-table');
    
    tables.forEach(table => {
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let showRow = true;
            
            // Status filter
            if (statusFilter && statusFilter.value) {
                const statusCell = row.querySelector('td:nth-child(4)'); // Adjust column index as needed
                if (statusCell && !statusCell.textContent.toLowerCase().includes(statusFilter.value.toLowerCase())) {
                    showRow = false;
                }
            }
            
            // Location filter
            if (locationFilter && locationFilter.value) {
                const locationCell = row.querySelector('td:nth-child(3)'); // Adjust column index as needed
                if (locationCell && !locationCell.textContent.toLowerCase().includes(locationFilter.value.toLowerCase())) {
                    showRow = false;
                }
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    });
}

function initializeSummaryCalculations() {
    // Calculate and update summary values
    updateSummaryCards();
    
    // Recalculate on data changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                updateSummaryCards();
            }
        });
    });
    
    const tableContainer = document.querySelector('.table-container');
    if (tableContainer) {
        observer.observe(tableContainer, { childList: true, subtree: true });
    }
}

function updateSummaryCards() {
    const table = document.querySelector('.modern-table');
    if (!table) return;
    
    let pendingCount = 0;
    let approvedCount = 0;
    let rejectedCount = 0;
    let totalAmount = 0;
    
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 4) {
            const status = cells[3]?.textContent.toLowerCase();
            const amount = parseFloat(cells[2]?.textContent.replace(/[^0-9.-]/g, '') || 0);
            
            if (status.includes('pending')) {
                pendingCount++;
            } else if (status.includes('approved')) {
                approvedCount++;
            } else if (status.includes('rejected')) {
                rejectedCount++;
            }
            
            totalAmount += amount;
        }
    });
    
    // Update summary cards
    updateSummaryCard('pending', pendingCount, 'pending');
    updateSummaryCard('approved', approvedCount, 'approved');
    updateSummaryCard('rejected', rejectedCount, 'rejected');
    updateSummaryCard('total', totalAmount, 'total');
}

function updateSummaryCard(type, value, className) {
    const card = document.querySelector(`.summary-card.${type}`);
    if (card) {
        const valueElement = card.querySelector('.summary-value');
        if (valueElement) {
            if (type === 'total') {
                valueElement.textContent = formatCurrency(value);
            } else {
                valueElement.textContent = value;
            }
        }
        card.className = `summary-card ${type} ${className}`;
    }
}

function formatCurrency(value) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(value);
}

function addLoadingStates() {
    // Add loading states to buttons
    const buttons = document.querySelectorAll('.btn, .action-btn');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.type === 'submit' || this.classList.contains('action-btn')) {
                addLoadingState(this);
            }
        });
    });
}

function addLoadingState(element) {
    element.classList.add('loading');
    element.disabled = true;
    
    // Remove loading state after 3 seconds (fallback)
    setTimeout(() => {
        removeLoadingState(element);
    }, 3000);
}

function removeLoadingState(element) {
    element.classList.remove('loading');
    element.disabled = false;
}

// Action handlers
function approveCredit(creditId) {
    if (confirm('Are you sure you want to approve this credit request?')) {
        showLoadingState();
        
        // Simulate API call
        setTimeout(() => {
            hideLoadingState();
            showNotification('Credit request approved successfully', 'success');
            // Reload or update the table
            location.reload();
        }, 2000);
    }
}

function rejectCredit(creditId) {
    if (confirm('Are you sure you want to reject this credit request?')) {
        showLoadingState();
        
        // Simulate API call
        setTimeout(() => {
            hideLoadingState();
            showNotification('Credit request rejected', 'info');
            // Reload or update the table
            location.reload();
        }, 2000);
    }
}

function viewCreditDetails(creditId) {
    // Open credit details in a modal or new page
    window.open(`creditdetails.php?id=${creditId}`, '_blank');
}

function showLoadingState() {
    const loadingOverlay = document.createElement('div');
    loadingOverlay.id = 'loading-overlay';
    loadingOverlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    `;
    
    const spinner = document.createElement('div');
    spinner.style.cssText = `
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    `;
    
    loadingOverlay.appendChild(spinner);
    document.body.appendChild(loadingOverlay);
}

function hideLoadingState() {
    const overlay = document.getElementById('loading-overlay');
    if (overlay) {
        overlay.remove();
    }
}

// Utility functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    .sort-indicator {
        font-size: 0.8em;
        color: #7f8c8d;
        margin-left: 0.5rem;
    }
    
    .field-error {
        color: #e74c3c;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        z-index: 10000;
        animation: slideIn 0.3s ease;
    }
    
    .notification-success {
        background: #27ae60;
        color: white;
    }
    
    .notification-error {
        background: #e74c3c;
        color: white;
    }
    
    .notification-info {
        background: #3498db;
        color: white;
    }
    
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
