// Modern JavaScript for addcurrency.php

document.addEventListener('DOMContentLoaded', function() {
    initializeAddCurrency();
});

function initializeAddCurrency() {
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize currency preview
    initializeCurrencyPreview();
    
    // Initialize table functionality
    initializeTableFeatures();
    
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
    
    // Validate currency name
    const currencyInput = document.querySelector('input[name="currency"]');
    if (currencyInput && currencyInput.value) {
        if (!/^[A-Z]{3}$/.test(currencyInput.value.toUpperCase())) {
            showFieldError(currencyInput, 'Currency code must be exactly 3 uppercase letters (e.g., USD, EUR)');
            isValid = false;
        }
    }
    
    // Validate rate
    const rateInput = document.querySelector('input[name="rate"]');
    if (rateInput && rateInput.value) {
        const rate = parseFloat(rateInput.value);
        if (isNaN(rate) || rate <= 0) {
            showFieldError(rateInput, 'Rate must be a positive number');
            isValid = false;
        }
    }
    
    // Validate symbol
    const symbolInput = document.querySelector('input[name="symbol"]');
    if (symbolInput && symbolInput.value) {
        if (symbolInput.value.length > 5) {
            showFieldError(symbolInput, 'Symbol must be 5 characters or less');
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
    
    // Currency code validation
    if (field.name === 'currency' && value) {
        if (!/^[A-Z]{3}$/.test(value.toUpperCase())) {
            showFieldError(field, 'Currency code must be exactly 3 uppercase letters');
            return false;
        }
    }
    
    // Rate validation
    if (field.name === 'rate' && value) {
        const rate = parseFloat(value);
        if (isNaN(rate) || rate <= 0) {
            showFieldError(field, 'Rate must be a positive number');
            return false;
        }
    }
    
    // Symbol validation
    if (field.name === 'symbol' && value) {
        if (value.length > 5) {
            showFieldError(field, 'Symbol must be 5 characters or less');
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

function initializeCurrencyPreview() {
    const currencyInput = document.querySelector('input[name="currency"]');
    const symbolInput = document.querySelector('input[name="symbol"]');
    const rateInput = document.querySelector('input[name="rate"]');
    
    if (currencyInput) {
        currencyInput.addEventListener('input', function() {
            // Auto-uppercase currency code
            this.value = this.value.toUpperCase();
            updateCurrencyPreview();
        });
    }
    
    if (symbolInput) {
        symbolInput.addEventListener('input', updateCurrencyPreview);
    }
    
    if (rateInput) {
        rateInput.addEventListener('input', updateCurrencyPreview);
    }
    
    // Initialize preview
    updateCurrencyPreview();
}

function updateCurrencyPreview() {
    const currencyInput = document.querySelector('input[name="currency"]');
    const symbolInput = document.querySelector('input[name="symbol"]');
    const rateInput = document.querySelector('input[name="rate"]');
    
    const currency = currencyInput ? currencyInput.value : '';
    const symbol = symbolInput ? symbolInput.value : '';
    const rate = rateInput ? parseFloat(rateInput.value) : 0;
    
    // Update symbol preview
    const symbolPreview = document.querySelector('.currency-symbol-preview');
    if (symbolPreview) {
        symbolPreview.textContent = symbol || '?';
    }
    
    // Update currency preview
    const previewContainer = document.querySelector('.currency-preview');
    if (previewContainer) {
        const amountElement = previewContainer.querySelector('.currency-preview-amount');
        const labelElement = previewContainer.querySelector('.currency-preview-label');
        
        if (amountElement && labelElement) {
            if (currency && symbol && rate > 0) {
                const sampleAmount = 1000;
                const convertedAmount = (sampleAmount * rate).toFixed(2);
                
                amountElement.textContent = `${symbol}${convertedAmount}`;
                labelElement.textContent = `${sampleAmount} ${currency} = ${symbol}${convertedAmount}`;
                
                previewContainer.style.display = 'block';
            } else {
                previewContainer.style.display = 'none';
            }
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
        
        // Add rate formatting
        formatRateValues(table);
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
        
        // Try to parse as numbers (for rates)
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
    searchInput.placeholder = 'Search currencies...';
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

function formatRateValues(table) {
    const cells = table.querySelectorAll('td');
    cells.forEach(cell => {
        const text = cell.textContent.trim();
        const numValue = parseFloat(text.replace(/[^0-9.-]/g, ''));
        
        if (!isNaN(numValue) && text.includes('.')) {
            // Apply rate formatting
            cell.classList.add('financial-neutral');
        }
    });
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
function editCurrency(currencyId) {
    window.location.href = `editcurrency.php?id=${currencyId}`;
}

function deleteCurrency(currencyId) {
    if (confirm('Are you sure you want to delete this currency? This action cannot be undone.')) {
        showLoadingState();
        
        // Simulate API call
        setTimeout(() => {
            hideLoadingState();
            showNotification('Currency deleted successfully', 'success');
            // Reload or update the table
            location.reload();
        }, 2000);
    }
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
