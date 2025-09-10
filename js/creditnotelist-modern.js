// Modern JavaScript for creditnotelist.php

document.addEventListener('DOMContentLoaded', function() {
    initializeCreditNoteList();
});

function initializeCreditNoteList() {
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize auto-suggest functionality
    initializeAutoSuggest();
    
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
    
    // Amount validation
    if (field.name === 'amount' && value) {
        const amount = parseFloat(value);
        if (isNaN(amount) || amount <= 0) {
            showFieldError(field, 'Please enter a valid amount');
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

function initializeAutoSuggest() {
    const autoSuggestInputs = document.querySelectorAll('input[data-autosuggest]');
    
    autoSuggestInputs.forEach(input => {
        setupAutoSuggest(input);
    });
}

function setupAutoSuggest(input) {
    const container = document.createElement('div');
    container.className = 'autosuggest-container';
    input.parentNode.insertBefore(container, input);
    container.appendChild(input);
    
    const dropdown = document.createElement('div');
    dropdown.className = 'autosuggest-dropdown';
    dropdown.style.display = 'none';
    container.appendChild(dropdown);
    
    let selectedIndex = -1;
    let suggestions = [];
    
    input.addEventListener('input', function() {
        const query = this.value.trim();
        
        if (query.length < 2) {
            dropdown.style.display = 'none';
            return;
        }
        
        // Simulate API call for suggestions
        fetchSuggestions(query, input.dataset.autosuggest).then(data => {
            suggestions = data;
            displaySuggestions(data, dropdown);
        });
    });
    
    input.addEventListener('keydown', function(e) {
        const items = dropdown.querySelectorAll('.autosuggest-item');
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
            updateSelection(items, selectedIndex);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = Math.max(selectedIndex - 1, -1);
            updateSelection(items, selectedIndex);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (selectedIndex >= 0 && items[selectedIndex]) {
                selectSuggestion(items[selectedIndex], input);
            }
        } else if (e.key === 'Escape') {
            dropdown.style.display = 'none';
            selectedIndex = -1;
        }
    });
    
    // Hide dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!container.contains(e.target)) {
            dropdown.style.display = 'none';
            selectedIndex = -1;
        }
    });
}

function fetchSuggestions(query, type) {
    // Simulate API call - replace with actual endpoint
    return new Promise((resolve) => {
        setTimeout(() => {
            let suggestions = [];
            
            if (type === 'customer') {
                suggestions = [
                    { id: 1, name: 'Customer A', code: 'CUST001' },
                    { id: 2, name: 'Customer B', code: 'CUST002' },
                    { id: 3, name: 'Customer C', code: 'CUST003' }
                ].filter(item => 
                    item.name.toLowerCase().includes(query.toLowerCase()) ||
                    item.code.toLowerCase().includes(query.toLowerCase())
                );
            } else if (type === 'supplier') {
                suggestions = [
                    { id: 1, name: 'Supplier A', code: 'SUPP001' },
                    { id: 2, name: 'Supplier B', code: 'SUPP002' },
                    { id: 3, name: 'Supplier C', code: 'SUPP003' }
                ].filter(item => 
                    item.name.toLowerCase().includes(query.toLowerCase()) ||
                    item.code.toLowerCase().includes(query.toLowerCase())
                );
            }
            
            resolve(suggestions);
        }, 300);
    });
}

function displaySuggestions(suggestions, dropdown) {
    dropdown.innerHTML = '';
    
    if (suggestions.length === 0) {
        dropdown.style.display = 'none';
        return;
    }
    
    suggestions.forEach((suggestion, index) => {
        const item = document.createElement('div');
        item.className = 'autosuggest-item';
        item.innerHTML = `
            <div style="font-weight: 500;">${suggestion.name}</div>
            <div style="font-size: 0.8rem; color: #7f8c8d;">${suggestion.code}</div>
        `;
        
        item.addEventListener('click', function() {
            selectSuggestion(this, dropdown.previousElementSibling);
        });
        
        dropdown.appendChild(item);
    });
    
    dropdown.style.display = 'block';
}

function updateSelection(items, selectedIndex) {
    items.forEach((item, index) => {
        if (index === selectedIndex) {
            item.classList.add('selected');
        } else {
            item.classList.remove('selected');
        }
    });
}

function selectSuggestion(item, input) {
    const name = item.querySelector('div:first-child').textContent;
    const code = item.querySelector('div:last-child').textContent;
    
    input.value = name;
    input.dataset.selectedId = item.dataset.id || '';
    
    // Hide dropdown
    const dropdown = input.parentNode.querySelector('.autosuggest-dropdown');
    dropdown.style.display = 'none';
    
    // Trigger change event
    input.dispatchEvent(new Event('change'));
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
        
        // Add financial formatting
        formatFinancialValues(table);
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
        
        // Try to parse as numbers (for financial values)
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

function formatFinancialValues(table) {
    const cells = table.querySelectorAll('td');
    cells.forEach(cell => {
        const text = cell.textContent.trim();
        const numValue = parseFloat(text.replace(/[^0-9.-]/g, ''));
        
        if (!isNaN(numValue) && text.includes('.')) {
            // Apply financial formatting
            if (numValue > 0) {
                cell.classList.add('financial-positive');
            } else if (numValue < 0) {
                cell.classList.add('financial-negative');
            } else {
                cell.classList.add('financial-neutral');
            }
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
    
    let totalCreditNotes = 0;
    let totalAmount = 0;
    let pendingAmount = 0;
    let approvedAmount = 0;
    
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 3) {
            const amount = parseFloat(cells[2]?.textContent.replace(/[^0-9.-]/g, '') || 0);
            const status = cells[3]?.textContent.toLowerCase();
            
            totalCreditNotes++;
            totalAmount += amount;
            
            if (status.includes('pending')) {
                pendingAmount += amount;
            } else if (status.includes('approved')) {
                approvedAmount += amount;
            }
        }
    });
    
    // Update summary cards
    updateSummaryCard('total-notes', totalCreditNotes, 'neutral');
    updateSummaryCard('total-amount', totalAmount, 'neutral');
    updateSummaryCard('pending-amount', pendingAmount, 'negative');
    updateSummaryCard('approved-amount', approvedAmount, 'positive');
}

function updateSummaryCard(type, value, className) {
    const card = document.querySelector(`.summary-card.${type}`);
    if (card) {
        const valueElement = card.querySelector('.summary-value');
        if (valueElement) {
            if (type.includes('amount')) {
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
function editCreditNote(creditId) {
    window.location.href = `editcreditnote.php?id=${creditId}`;
}

function deleteCreditNote(creditId) {
    if (confirm('Are you sure you want to delete this credit note?')) {
        showLoadingState();
        
        // Simulate API call
        setTimeout(() => {
            hideLoadingState();
            showNotification('Credit note deleted successfully', 'success');
            // Reload or update the table
            location.reload();
        }, 2000);
    }
}

function viewCreditNote(creditId) {
    window.open(`viewcreditnote.php?id=${creditId}`, '_blank');
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
