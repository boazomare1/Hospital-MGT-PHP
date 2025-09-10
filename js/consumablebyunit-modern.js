// Modern JavaScript for consumablebyunit.php

document.addEventListener('DOMContentLoaded', function() {
    initializeConsumableReport();
});

function initializeConsumableReport() {
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize date pickers
    initializeDatePickers();
    
    // Initialize print functionality
    initializePrintFunction();
    
    // Initialize responsive table
    initializeResponsiveTable();
    
    // Add loading states
    addLoadingStates();
}

function initializeFormValidation() {
    const form = document.querySelector('form[name="frmsales"]');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
        
        // Add loading state
        addLoadingState(form);
    });
    
    // Real-time validation
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', clearFieldError);
    });
}

function validateForm() {
    let isValid = true;
    const form = document.querySelector('form[name="frmsales"]');
    
    // Validate required fields
    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        if (!validateField({ target: field })) {
            isValid = false;
        }
    });
    
    // Validate date range
    const fromDate = form.querySelector('input[name="fromdate"]');
    const toDate = form.querySelector('input[name="todate"]');
    
    if (fromDate && toDate && fromDate.value && toDate.value) {
        if (new Date(fromDate.value) > new Date(toDate.value)) {
            showFieldError(toDate, 'To date must be after from date');
            isValid = false;
        }
    }
    
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
    
    // Number validation
    if (field.type === 'number' && value) {
        if (isNaN(value) || parseFloat(value) < 0) {
            showFieldError(field, 'Please enter a valid positive number');
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

function initializePrintFunction() {
    // Enhanced print functionality
    const printBtn = document.querySelector('input[value="Print"]');
    if (printBtn) {
        printBtn.addEventListener('click', function(e) {
            e.preventDefault();
            printReport();
        });
    }
}

function printReport() {
    // Show loading state
    showLoadingState();
    
    // Prepare print content
    const printContent = preparePrintContent();
    
    // Open print window
    const printWindow = window.open('', '_blank');
    printWindow.document.write(printContent);
    printWindow.document.close();
    
    // Wait for content to load then print
    printWindow.onload = function() {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
        hideLoadingState();
    };
}

function preparePrintContent() {
    const reportTitle = document.querySelector('.report-title')?.textContent || 'Consumable Report';
    const reportSubtitle = document.querySelector('.report-subtitle')?.textContent || '';
    const table = document.querySelector('.modern-table');
    
    return `
        <!DOCTYPE html>
        <html>
        <head>
            <title>${reportTitle}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1 { color: #2c3e50; text-align: center; }
                h2 { color: #7f8c8d; text-align: center; font-weight: normal; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #2c3e50; color: white; }
                tr:nth-child(even) { background-color: #f2f2f2; }
                @media print { body { margin: 0; } }
            </style>
        </head>
        <body>
            <h1>${reportTitle}</h1>
            ${reportSubtitle ? `<h2>${reportSubtitle}</h2>` : ''}
            ${table ? table.outerHTML : ''}
        </body>
        </html>
    `;
}

function initializeResponsiveTable() {
    const table = document.querySelector('.modern-table');
    if (!table) return;
    
    // Add responsive wrapper if not exists
    if (!table.parentNode.classList.contains('table-responsive')) {
        const wrapper = document.createElement('div');
        wrapper.className = 'table-responsive';
        wrapper.style.overflowX = 'auto';
        
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    }
    
    // Add sort functionality
    addTableSorting(table);
    
    // Add search functionality
    addTableSearch(table);
}

function addTableSorting(table) {
    const headers = table.querySelectorAll('th');
    
    headers.forEach((header, index) => {
        if (header.textContent.trim()) {
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
        
        // Try to parse as numbers
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
    currentIndicator.textContent = isAscending ? '↑' : '↓';
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

function addLoadingStates() {
    // Add loading states to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.type === 'submit' || this.value === 'Print') {
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
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db'};
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        z-index: 10000;
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    
    .form-control.error {
        border-color: #e74c3c;
        box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
    }
    
    .sort-indicator {
        font-size: 0.8em;
        color: #7f8c8d;
        margin-left: 0.5rem;
    }
`;
document.head.appendChild(style);
