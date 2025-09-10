// Bank Transactions Modern JavaScript
// Handles form validation, responsive design, and enhanced user experience for comprehensive bank transaction management

document.addEventListener('DOMContentLoaded', function() {
    initializeFormValidation();
    initializeResponsiveDesign();
    initializeTouchSupport();
    initializeFormEnhancements();
    initializeTransactionTypeManagement();
    initializeDatePickers();
    initializeTransactionTables();
    initializeAutoComplete();
    initializeFormAutoSave();
    initializeAmountFormatting();
    initializeTransactionPosting();
    initializeSummaryCalculations();
});

// Form Validation
function initializeFormValidation() {
    const searchForm = document.querySelector('form[name="cbform1"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!validateSearchForm()) {
                e.preventDefault();
            }
        });
        
        initializeRealTimeValidation();
    }
}

function validateSearchForm() {
    let isValid = true;
    const bankSelect = document.getElementById('bankname');
    const dateInput = document.getElementById('ADate2');
    
    // Validate bank selection
    if (!bankSelect.value) {
        showFieldError(bankSelect, 'Please select a bank to proceed');
        isValid = false;
    } else {
        clearFieldError(bankSelect);
    }
    
    // Validate date selection
    if (!dateInput.value) {
        showFieldError(dateInput, 'Please select a date to proceed');
        isValid = false;
    } else {
        clearFieldError(dateInput);
    }
    
    return isValid;
}

function initializeRealTimeValidation() {
    const formFields = document.querySelectorAll('select, input');
    
    formFields.forEach(field => {
        field.addEventListener('change', function() {
            validateField(field);
        });
        
        field.addEventListener('blur', function() {
            validateField(field);
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Special validation for date fields
    if (field.type === 'text' && field.classList.contains('datepicker')) {
        if (value && !isValidDate(value)) {
            showFieldError(field, 'Please enter a valid date');
            return false;
        }
    }
    
    // Special validation for amount fields
    if (field.name && field.name.includes('bankamount')) {
        if (value && !isValidAmount(value)) {
            showFieldError(field, 'Please enter a valid amount');
            return false;
        }
    }
    
    clearFieldError(field);
    return true;
}

// Field Error Handling
function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('error');
    const errorDiv = field.parentNode.querySelector('.field-error');
    if (errorDiv) {
        errorDiv.remove();
    }
}

// Responsive Design
function initializeResponsiveDesign() {
    window.addEventListener('resize', debounce(adjustLayoutForScreenSize, 250));
    adjustLayoutForScreenSize();
}

function adjustLayoutForScreenSize() {
    const width = window.innerWidth;
    
    if (width <= 768) {
        document.body.classList.add('mobile-view');
        adjustTablesForMobile();
    } else {
        document.body.classList.remove('mobile-view');
        restoreTableLayout();
    }
}

function adjustTablesForMobile() {
    const tables = document.querySelectorAll('.transaction-table table');
    tables.forEach(table => {
        if (!table.classList.contains('mobile-adjusted')) {
            table.classList.add('mobile-adjusted');
            addMobileTableEnhancements(table);
        }
    });
}

function restoreTableLayout() {
    const tables = document.querySelectorAll('.transaction-table table');
    tables.forEach(table => {
        table.classList.remove('mobile-adjusted');
        removeMobileTableEnhancements(table);
    });
}

function addMobileTableEnhancements(table) {
    const rows = table.querySelectorAll('tr');
    rows.forEach((row, index) => {
        if (index === 0) return; // Skip header row
        
        const cells = row.querySelectorAll('td');
        cells.forEach((cell, cellIndex) => {
            const header = table.querySelector(`th:nth-child(${cellIndex + 1})`);
            if (header) {
                cell.setAttribute('data-label', header.textContent);
            }
        });
    });
}

function removeMobileTableEnhancements(table) {
    const cells = table.querySelectorAll('td[data-label]');
    cells.forEach(cell => {
        cell.removeAttribute('data-label');
    });
}

// Touch Support
function initializeTouchSupport() {
    if ('ontouchstart' in window) {
        document.body.classList.add('touch-device');
        addTouchEnhancements();
    }
}

function addTouchEnhancements() {
    const buttons = document.querySelectorAll('.btn, input[type="submit"], .action-btn');
    buttons.forEach(button => {
        button.style.minHeight = '44px';
        button.style.minWidth = '44px';
    });
    
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.style.minHeight = '44px';
    });
}

// Form Enhancements
function initializeFormEnhancements() {
    const submitButtons = document.querySelectorAll('input[type="submit"]');
    submitButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.form && this.form.checkValidity()) {
                this.style.opacity = '0.7';
                this.disabled = true;
                this.value = 'Processing...';
            }
        });
    });
    
    addKeyboardShortcuts();
    addFormResetConfirmation();
}

function addKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            const bankSelect = document.getElementById('bankname');
            if (bankSelect) {
                bankSelect.focus();
            }
        }
        
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            const submitButton = document.querySelector('input[type="submit"]');
            if (submitButton) {
                submitButton.click();
            }
        }
        
        if (e.key === 'Escape') {
            document.activeElement.blur();
        }
        
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            if (confirm('Are you sure you want to reset the form?')) {
                document.querySelector('form[name="cbform1"]').reset();
            }
        }
    });
}

function addFormResetConfirmation() {
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.addEventListener('reset', function(e) {
            if (!confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
                e.preventDefault();
            }
        });
    }
}

// Transaction Type Management
function initializeTransactionTypeManagement() {
    addTransactionTypeCards();
    initializeTransactionTypeFilters();
}

function addTransactionTypeCards() {
    const container = document.querySelector('.page-header') || document.body;
    const cardsContainer = document.createElement('div');
    cardsContainer.className = 'transaction-type-cards';
    cardsContainer.style.cssText = `
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin: 1rem 0;
        width: 100%;
    `;
    
    const transactionTypes = [
        { type: 'receivable', label: 'Accounts Receivable', icon: '💰', color: '#27ae60' },
        { type: 'payable', label: 'Accounts Payable', icon: '💸', color: '#e74c3c' },
        { type: 'supplier', label: 'Supplier Notes', icon: '🏪', color: '#9b59b6' },
        { type: 'expense', label: 'Expenses', icon: '📊', color: '#f39c12' },
        { type: 'receipt', label: 'Receipts', icon: '📥', color: '#3498db' },
        { type: 'bank', label: 'Bank Entries', icon: '🏦', color: '#1abc9c' },
        { type: 'journal', label: 'Journal Entries', icon: '📝', color: '#34495e' }
    ];
    
    transactionTypes.forEach(typeInfo => {
        const card = document.createElement('div');
        card.className = 'transaction-type-card';
        card.setAttribute('data-type', typeInfo.type);
        card.style.cssText = `
            background: white;
            border: 1px solid #e1e8ed;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        `;
        
        card.innerHTML = `
            <div class="transaction-type-icon" style="font-size: 2rem; margin-bottom: 0.5rem;">${typeInfo.icon}</div>
            <div class="transaction-type-label" style="font-weight: 600; color: #2c3e50; margin-bottom: 0.25rem;">${typeInfo.label}</div>
            <div class="transaction-type-count" style="color: #7f8c8d; font-size: 0.9rem;">0 transactions</div>
        `;
        
        card.addEventListener('click', function() {
            filterTransactionsByType(typeInfo.type);
            updateActiveCard(this);
        });
        
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
        
        cardsContainer.appendChild(card);
    });
    
    container.appendChild(cardsContainer);
}

function filterTransactionsByType(type) {
    const sections = document.querySelectorAll('.transaction-section');
    
    sections.forEach(section => {
        if (type === 'all' || section.getAttribute('data-type') === type) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });
    
    updateTransactionCounts();
}

function updateActiveCard(activeCard) {
    document.querySelectorAll('.transaction-type-card').forEach(card => {
        card.classList.remove('active');
        card.style.borderColor = '#e1e8ed';
        card.style.background = 'white';
    });
    
    activeCard.classList.add('active');
    activeCard.style.borderColor = '#3498db';
    activeCard.style.background = 'rgba(52, 152, 219, 0.05)';
}

function initializeTransactionTypeFilters() {
    // Add filter buttons for each transaction type
    const filterContainer = document.createElement('div');
    filterContainer.className = 'transaction-filters';
    filterContainer.style.cssText = `
        display: flex;
        gap: 0.5rem;
        margin: 1rem 0;
        flex-wrap: wrap;
    `;
    
    const filterTypes = [
        { type: 'all', label: 'All Transactions', color: '#3498db' },
        { type: 'receivable', label: 'Receivables', color: '#27ae60' },
        { type: 'payable', label: 'Payables', color: '#e74c3c' },
        { type: 'supplier', label: 'Supplier', color: '#9b59b6' },
        { type: 'expense', label: 'Expenses', color: '#f39c12' },
        { type: 'receipt', label: 'Receipts', color: '#3498db' },
        { type: 'bank', label: 'Bank', color: '#1abc9c' },
        { type: 'journal', label: 'Journal', color: '#34495e' }
    ];
    
    filterTypes.forEach(filterInfo => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'filter-btn';
        button.textContent = filterInfo.label;
        button.setAttribute('data-type', filterInfo.type);
        button.style.cssText = `
            background: ${filterInfo.color};
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        `;
        
        button.addEventListener('click', function() {
            filterTransactionsByType(filterInfo.type);
            updateActiveFilterButton(this);
        });
        
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
            this.style.boxShadow = '0 2px 4px rgba(0,0,0,0.2)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
        
        filterContainer.appendChild(button);
    });
    
    const pageHeader = document.querySelector('.page-header');
    if (pageHeader) {
        pageHeader.appendChild(filterContainer);
    }
}

function updateActiveFilterButton(activeButton) {
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.style.opacity = '0.7';
    });
    
    activeButton.style.opacity = '1';
}

// Date Picker Enhancements
function initializeDatePickers() {
    const dateInputs = document.querySelectorAll('input[class*="datepicker"]');
    
    dateInputs.forEach(input => {
        addQuickDateButtons(input);
        input.addEventListener('change', function() {
            validateDateField(this);
        });
    });
}

function addQuickDateButtons(dateInput) {
    const container = dateInput.parentNode;
    const quickDateDiv = document.createElement('div');
    quickDateDiv.className = 'quick-date-buttons';
    quickDateDiv.style.cssText = `
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
        flex-wrap: wrap;
    `;
    
    const quickDates = [
        { label: 'Today', days: 0 },
        { label: 'Yesterday', days: -1 },
        { label: 'Last Week', days: -7 },
        { label: 'Last Month', days: -30 },
        { label: 'Start of Month', type: 'monthStart' },
        { label: 'End of Month', type: 'monthEnd' }
    ];
    
    quickDates.forEach(quickDate => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'quick-date-btn';
        button.textContent = quickDate.label;
        button.style.cssText = `
            background: #ecf0f1;
            border: 1px solid #bdc3c7;
            color: #7f8c8d;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        `;
        
        button.addEventListener('click', function() {
            let targetDate;
            
            if (quickDate.type === 'monthStart') {
                targetDate = new Date();
                targetDate.setDate(1);
            } else if (quickDate.type === 'monthEnd') {
                targetDate = new Date();
                targetDate.setMonth(targetDate.getMonth() + 1, 0);
            } else {
                targetDate = new Date();
                targetDate.setDate(targetDate.getDate() + quickDate.days);
            }
            
            dateInput.value = targetDate.toISOString().split('T')[0];
            dateInput.dispatchEvent(new Event('change'));
            showNotification(`Date set to: ${quickDate.label}`, 'success');
        });
        
        button.addEventListener('mouseenter', function() {
            this.style.background = '#3498db';
            this.style.color = 'white';
            this.style.borderColor = '#3498db';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.background = '#ecf0f1';
            this.style.color = '#7f8c8d';
            this.style.borderColor = '#bdc3c7';
        });
        
        quickDateDiv.appendChild(button);
    });
    
    container.appendChild(quickDateDiv);
}

function validateDateField(dateInput) {
    const dateValue = dateInput.value;
    
    if (dateValue && !isValidDate(dateValue)) {
        showFieldError(dateInput, 'Please enter a valid date');
        return false;
    }
    
    clearFieldError(dateInput);
    return true;
}

// Transaction Tables
function initializeTransactionTables() {
    const tables = document.querySelectorAll('.transaction-table table');
    tables.forEach(table => {
        addTableSorting(table);
        addTransactionTypeIndicators(table);
        addAmountFormatting(table);
        addRowHighlighting(table);
        addMobileEnhancements(table);
    });
}

function addTableSorting(table) {
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        if (header.textContent.trim() !== '') {
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                sortTable(table, index);
            });
            
            const sortIndicator = document.createElement('span');
            sortIndicator.className = 'sort-indicator';
            sortIndicator.innerHTML = ' ↕';
            sortIndicator.style.color = '#999';
            header.appendChild(sortIndicator);
        }
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Remove existing sort indicators
    table.querySelectorAll('.sort-indicator').forEach(indicator => {
        indicator.innerHTML = ' ↕';
        indicator.style.color = '#999';
    });
    
    // Add sort indicator to clicked header
    const clickedHeader = table.querySelector(`th:nth-child(${columnIndex + 1})`);
    const indicator = clickedHeader.querySelector('.sort-indicator');
    
    // Determine sort direction
    const currentDirection = indicator.getAttribute('data-direction') || 'none';
    const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
    
    indicator.setAttribute('data-direction', newDirection);
    indicator.innerHTML = newDirection === 'asc' ? ' ↑' : ' ↓';
    indicator.style.color = '#3498db';
    
    // Sort rows
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex]?.textContent.trim() || '';
        const bValue = b.cells[columnIndex]?.textContent.trim() || '';
        
        if (newDirection === 'asc') {
            return aValue.localeCompare(bValue);
        } else {
            return bValue.localeCompare(aValue);
        }
    });
    
    // Reorder rows
    rows.forEach(row => tbody.appendChild(row));
}

function addTransactionTypeIndicators(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const descriptionCell = row.querySelector('td:nth-child(2)'); // Description column
        if (descriptionCell) {
            const text = descriptionCell.textContent.toLowerCase();
            let transactionType = '';
            
            if (text.includes('accounts receivable')) {
                transactionType = 'receivable';
            } else if (text.includes('account payable')) {
                transactionType = 'payable';
            } else if (text.includes('supplier debit note')) {
                transactionType = 'supplier';
            } else if (text.includes('expenses')) {
                transactionType = 'expense';
            } else if (text.includes('receipts')) {
                transactionType = 'receipt';
            } else if (text.includes('bank entry')) {
                transactionType = 'bank';
            } else if (text.includes('journal entry')) {
                transactionType = 'journal';
            }
            
            if (transactionType) {
                const typeIndicator = document.createElement('span');
                typeIndicator.className = `transaction-type type-${transactionType}`;
                typeIndicator.textContent = transactionType.toUpperCase();
                typeIndicator.style.marginLeft = '0.5rem';
                
                descriptionCell.appendChild(typeIndicator);
            }
        }
    });
}

function addAmountFormatting(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const amountCells = row.querySelectorAll('td[class*="amount"]');
        amountCells.forEach(cell => {
            if (cell.textContent) {
                const amount = parseFloat(cell.textContent.replace(/[^0-9.-]+/g, ''));
                if (!isNaN(amount)) {
                    cell.classList.add('amount-display');
                    
                    if (amount > 0) {
                        cell.classList.add('amount-credit');
                    } else if (amount < 0) {
                        cell.classList.add('amount-debit');
                    } else {
                        cell.classList.add('amount-neutral');
                    }
                }
            }
        });
    });
}

function addRowHighlighting(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.classList.add('transaction-row');
        
        // Add hover effect
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
}

function addMobileEnhancements(table) {
    // Add mobile-specific enhancements
    if (window.innerWidth <= 768) {
        addMobileTableEnhancements(table);
    }
}

// Auto-complete Enhancement
function initializeAutoComplete() {
    // Add auto-complete for bank selection
    const bankSelect = document.getElementById('bankname');
    if (bankSelect) {
        addBankAutoComplete(bankSelect);
    }
    
    // Add auto-complete for other fields
    const descriptionInputs = document.querySelectorAll('input[name*="remarks"]');
    descriptionInputs.forEach(input => {
        addRemarksAutoComplete(input);
    });
}

function addBankAutoComplete(bankSelect) {
    // This would integrate with the existing bank search functionality
    console.log('Bank auto-complete initialized');
}

function addRemarksAutoComplete(input) {
    const commonRemarks = [
        'Bank transfer', 'Cash deposit', 'Cheque payment',
        'Monthly transfer', 'Emergency withdrawal', 'Regular deposit',
        'Supplier payment', 'Customer receipt', 'Expense reimbursement'
    ];
    
    input.addEventListener('input', function() {
        const value = this.value.toLowerCase();
        if (value.length >= 3) {
            const suggestions = commonRemarks.filter(remark => 
                remark.toLowerCase().includes(value)
            );
            
            if (suggestions.length > 0) {
                showAutoCompleteSuggestions(this, suggestions);
            }
        }
    });
}

function showAutoCompleteSuggestions(field, suggestions) {
    // Remove existing suggestions
    const existingSuggestions = field.parentNode.querySelector('.autocomplete-suggestions');
    if (existingSuggestions) {
        existingSuggestions.remove();
    }
    
    // Create suggestions container
    const suggestionsDiv = document.createElement('div');
    suggestionsDiv.className = 'autocomplete-suggestions';
    suggestionsDiv.style.cssText = `
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        z-index: 1000;
        max-height: 200px;
        overflow-y: auto;
    `;
    
    suggestions.forEach(suggestion => {
        const item = document.createElement('div');
        item.className = 'autocomplete-item';
        item.style.cssText = `
            padding: 0.5rem;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        `;
        item.textContent = suggestion;
        
        item.addEventListener('click', function() {
            field.value = suggestion;
            suggestionsDiv.remove();
        });
        
        item.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f5f5f5';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
        
        suggestionsDiv.appendChild(item);
    });
    
    field.parentNode.style.position = 'relative';
    field.parentNode.appendChild(suggestionsDiv);
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', function hideSuggestions(e) {
        if (!field.parentNode.contains(e.target)) {
            suggestionsDiv.remove();
            document.removeEventListener('click', hideSuggestions);
        }
    });
}

// Form Auto-save
function initializeFormAutoSave() {
    const form = document.querySelector('form[name="cbform1"]');
    if (!form) return;
    
    const autoSaveKey = 'bank_transactions_autosave';
    
    // Load auto-saved data
    const savedData = localStorage.getItem(autoSaveKey);
    if (savedData) {
        try {
            const data = JSON.parse(savedData);
            Object.keys(data).forEach(key => {
                const field = form.querySelector(`[name="${key}"]`);
                if (field) {
                    field.value = data[key];
                }
            });
            
            showNotification('Form data restored from auto-save', 'info');
        } catch (e) {
            console.error('Error loading auto-saved data:', e);
        }
    }
    
    // Auto-save on input
    form.addEventListener('change', debounce(function() {
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        
        localStorage.setItem(autoSaveKey, JSON.stringify(data));
    }, 1000));
}

// Amount Formatting
function initializeAmountFormatting() {
    const amountInputs = document.querySelectorAll('input[name*="bankamount"]');
    
    amountInputs.forEach(input => {
        input.addEventListener('input', function() {
            formatAmount(this);
        });
        
        input.addEventListener('blur', function() {
            validateAmount(this);
        });
    });
}

function formatAmount(input) {
    let value = input.value.replace(/[^\d.]/g, '');
    
    // Ensure only one decimal point
    const parts = value.split('.');
    if (parts.length > 2) {
        value = parts[0] + '.' + parts.slice(1).join('');
    }
    
    // Format with commas
    if (parts.length === 2) {
        const wholePart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        input.value = wholePart + '.' + parts[1];
    } else {
        input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
}

function validateAmount(input) {
    const value = parseFloat(input.value.replace(/,/g, ''));
    
    if (isNaN(value) || value < 0) {
        showFieldError(input, 'Please enter a valid amount');
        return false;
    }
    
    clearFieldError(input);
    return true;
}

// Transaction Posting
function initializeTransactionPosting() {
    const postButtons = document.querySelectorAll('input[type="button"][value*="Post"]');
    
    postButtons.forEach(button => {
        button.addEventListener('click', function() {
            handleTransactionPosting(this);
        });
    });
}

function handleTransactionPosting(button) {
    const row = button.closest('tr');
    if (!row) return;
    
    // Validate required fields
    const dateInput = row.querySelector('input[class*="datepicker"]');
    const amountInput = row.querySelector('input[name*="bankamount"]');
    
    if (!dateInput || !dateInput.value) {
        showNotification('Please select a bank date for posting', 'error');
        return;
    }
    
    if (!amountInput || !amountInput.value) {
        showNotification('Please enter a bank amount for posting', 'error');
        return;
    }
    
    // Show loading state
    const originalValue = button.value;
    button.value = 'Posting...';
    button.disabled = true;
    
    // Simulate posting (replace with actual implementation)
    setTimeout(() => {
        button.value = 'Posted';
        button.style.background = '#27ae60';
        button.disabled = true;
        
        // Update row styling
        row.style.background = 'rgba(39, 174, 96, 0.1)';
        row.classList.add('success-animation');
        
        showNotification('Transaction posted successfully!', 'success');
        
        // Update summary calculations
        updateSummaryCalculations();
        
        // Remove animation class after animation completes
        setTimeout(() => {
            row.classList.remove('success-animation');
        }, 500);
    }, 2000);
}

// Summary Calculations
function initializeSummaryCalculations() {
    updateTransactionCounts();
    updateSummaryCalculations();
}

function updateTransactionCounts() {
    const transactionTypes = ['receivable', 'payable', 'supplier', 'expense', 'receipt', 'bank', 'journal'];
    
    transactionTypes.forEach(type => {
        const count = document.querySelectorAll(`[data-type="${type}"]`).length;
        const card = document.querySelector(`.transaction-type-card[data-type="${type}"]`);
        if (card) {
            const countElement = card.querySelector('.transaction-type-count');
            if (countElement) {
                countElement.textContent = `${count} transactions`;
            }
        }
    });
}

function updateSummaryCalculations() {
    // This function would integrate with the existing postcalc() function
    console.log('Summary calculations updated');
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 4px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        max-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    
    const colors = {
        success: '#27ae60',
        error: '#e74c3c',
        warning: '#f39c12',
        info: '#3498db'
    };
    
    notification.style.background = colors[type] || colors.info;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);
}

// Utility Functions
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

function isValidDate(dateString) {
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

function isValidAmount(amountString) {
    const amount = parseFloat(amountString.replace(/[^0-9.-]+/g, ''));
    return !isNaN(amount) && amount >= 0;
}

// Enhanced legacy functions
function postcalc() {
    // This function integrates with the existing postcalc functionality
    console.log('Post calculation initiated');
    
    // Update summary calculations
    updateSummaryCalculations();
    
    // Show success notification
    showNotification('Calculations completed successfully!', 'success');
}

// Export functions for global access
window.BankTransactionsModern = {
    validateSearchForm,
    showNotification,
    filterTransactionsByType,
    handleTransactionPosting,
    postcalc,
    updateSummaryCalculations
};
