// Bank Entry Form1 Modern JavaScript
// Handles form validation, responsive design, and enhanced user experience for bank entry form management

document.addEventListener('DOMContentLoaded', function() {
    initializeFormValidation();
    initializeResponsiveDesign();
    initializeTouchSupport();
    initializeFormEnhancements();
    initializeBankSearch();
    initializeDatePickers();
    initializeTransactionModeHandling();
    initializeAutoComplete();
    initializeFormAutoSave();
    initializeAmountFormatting();
    initializeBalanceChecking();
});

// Form Validation
function initializeFormValidation() {
    const form = document.getElementById('form1');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
        
        initializeRealTimeValidation();
    }
}

function validateForm() {
    let isValid = true;
    const fromBankSelect = document.getElementById('frombankname');
    const toBankSelect = document.getElementById('tobankname');
    const transactionTypeSelect = document.getElementById('transactiontype');
    const transactionModeSelect = document.getElementById('transactionmode');
    const amountInput = document.getElementById('amount');
    const personNameInput = document.getElementById('personname');
    const locationSelect = document.getElementById('location');
    
    // Validate from bank selection
    if (!fromBankSelect.value) {
        showFieldError(fromBankSelect, 'Please select Credit Bank to proceed');
        isValid = false;
    } else {
        clearFieldError(fromBankSelect);
    }
    
    // Validate to bank selection
    if (!toBankSelect.value) {
        showFieldError(toBankSelect, 'Please select Debit Bank to proceed');
        isValid = false;
    } else {
        clearFieldError(toBankSelect);
    }
    
    // Check if banks are different
    if (fromBankSelect.value && toBankSelect.value && fromBankSelect.value === toBankSelect.value) {
        showFieldError(toBankSelect, 'Credit and Debit Bank should not be the same');
        isValid = false;
    }
    
    // Validate transaction type
    if (!transactionTypeSelect.value) {
        showFieldError(transactionTypeSelect, 'Please select transaction type to proceed');
        isValid = false;
    } else {
        clearFieldError(transactionTypeSelect);
    }
    
    // Validate transaction mode
    if (!transactionModeSelect.value) {
        showFieldError(transactionModeSelect, 'Please select transaction mode to proceed');
        isValid = false;
    } else {
        clearFieldError(transactionModeSelect);
    }
    
    // Validate amount
    if (!amountInput.value || parseFloat(amountInput.value.replace(/,/g, '')) <= 0) {
        showFieldError(amountInput, 'Please enter a valid amount to proceed');
        isValid = false;
    } else {
        clearFieldError(amountInput);
    }
    
    // Validate person name
    if (!personNameInput.value.trim()) {
        showFieldError(personNameInput, 'Please enter person name to proceed');
        isValid = false;
    } else {
        clearFieldError(personNameInput);
    }
    
    // Validate location
    if (!locationSelect.value) {
        showFieldError(locationSelect, 'Please select location to proceed');
        isValid = false;
    } else {
        clearFieldError(locationSelect);
    }
    
    // Validate cheque fields if cheque mode is selected
    if (transactionModeSelect.value === 'CHEQUE') {
        const chequeDateInput = document.getElementById('ADate1');
        const chequeNumberInput = document.getElementById('chequenumber');
        
        if (!chequeDateInput.value) {
            showFieldError(chequeDateInput, 'Please enter cheque date');
            isValid = false;
        } else {
            clearFieldError(chequeDateInput);
        }
        
        if (!chequeNumberInput.value.trim()) {
            showFieldError(chequeNumberInput, 'Please enter cheque number');
            isValid = false;
        } else {
            clearFieldError(chequeNumberInput);
        }
    }
    
    return isValid;
}

function initializeRealTimeValidation() {
    const formFields = document.querySelectorAll('select, input, textarea');
    
    formFields.forEach(field => {
        field.addEventListener('change', function() {
            validateField(this);
        });
        
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Special validation for amount field
    if (field.id === 'amount' && value) {
        const amount = parseFloat(value.replace(/,/g, ''));
        if (isNaN(amount) || amount <= 0) {
            showFieldError(field, 'Please enter a valid amount');
            return false;
        }
    }
    
    // Special validation for cheque date
    if (field.id === 'ADate1' && value) {
        if (!isValidDate(value)) {
            showFieldError(field, 'Please enter a valid date');
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
        adjustFormsForMobile();
    } else {
        document.body.classList.remove('mobile-view');
        restoreFormLayout();
    }
}

function adjustFormsForMobile() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        if (!form.classList.contains('mobile-adjusted')) {
            form.classList.add('mobile-adjusted');
            addMobileFormEnhancements(form);
        }
    });
}

function restoreFormLayout() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.classList.remove('mobile-adjusted');
        removeMobileFormEnhancements(form);
    });
}

function addMobileFormEnhancements(form) {
    // Add mobile-specific enhancements
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.style.fontSize = '16px'; // Prevent zoom on iOS
    });
}

function removeMobileFormEnhancements(form) {
    // Remove mobile-specific enhancements
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.style.fontSize = '';
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
    const buttons = document.querySelectorAll('.btn, input[type="submit"]');
    buttons.forEach(button => {
        button.style.minHeight = '44px';
        button.style.minWidth = '44px';
    });
    
    const inputs = document.querySelectorAll('input, select, textarea');
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
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            const submitButton = document.querySelector('input[type="submit"]');
            if (submitButton) {
                submitButton.click();
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
                document.getElementById('form1').reset();
            }
        }
    });
}

function addFormResetConfirmation() {
    const form = document.getElementById('form1');
    if (form) {
        form.addEventListener('reset', function(e) {
            if (!confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
                e.preventDefault();
            }
        });
    }
}

// Bank Search Enhancement
function initializeBankSearch() {
    const fromBankSelect = document.getElementById('frombankname');
    const toBankSelect = document.getElementById('tobankname');
    
    if (fromBankSelect) {
        addBankSearchEnhancements(fromBankSelect, 'Credit');
        addQuickBankSelection(fromBankSelect, 'Credit');
    }
    
    if (toBankSelect) {
        addBankSearchEnhancements(toBankSelect, 'Debit');
        addQuickBankSelection(toBankSelect, 'Debit');
    }
}

function addBankSearchEnhancements(bankSelect, type) {
    const container = bankSelect.parentNode;
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = `Search ${type} banks...`;
    searchInput.className = 'bank-search-input';
    searchInput.style.cssText = `
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e1e8ed;
        border-radius: 4px;
        font-size: 14px;
        margin-bottom: 0.5rem;
        display: none;
    `;
    
    container.insertBefore(searchInput, bankSelect);
    
    // Show search on focus
    bankSelect.addEventListener('focus', function() {
        searchInput.style.display = 'block';
        searchInput.focus();
    });
    
    // Filter options based on search
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const options = bankSelect.querySelectorAll('option');
        
        options.forEach(option => {
            if (option.value === '') return; // Skip placeholder
            
            const text = option.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        });
    });
    
    // Hide search when bank is selected
    bankSelect.addEventListener('change', function() {
        searchInput.style.display = 'none';
        searchInput.value = '';
        
        // Show all options again
        const options = bankSelect.querySelectorAll('option');
        options.forEach(option => {
            option.style.display = '';
        });
        
        // Trigger balance check
        if (type === 'Credit') {
            check_ledger(this.value);
        } else {
            check_ledger1(this.value);
        }
    });
}

function addQuickBankSelection(bankSelect, type) {
    const container = bankSelect.parentNode;
    const quickSelectionDiv = document.createElement('div');
    quickSelectionDiv.className = 'quick-bank-selection';
    quickSelectionDiv.style.cssText = `
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
        flex-wrap: wrap;
    `;
    
    const quickBanks = [
        { label: 'Primary Bank', value: '1||Primary Bank' },
        { label: 'Secondary Bank', value: '2||Secondary Bank' },
        { label: 'Savings Bank', value: '3||Savings Bank' }
    ];
    
    quickBanks.forEach(bank => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'quick-bank-btn';
        button.textContent = bank.label;
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
            // Find and select the bank option
            const option = bankSelect.querySelector(`option[value="${bank.value}"]`);
            if (option) {
                bankSelect.value = bank.value;
                bankSelect.dispatchEvent(new Event('change'));
                showNotification(`Selected ${type} Bank: ${bank.label}`, 'success');
            } else {
                showNotification('Bank not found in list', 'warning');
            }
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
        
        quickSelectionDiv.appendChild(button);
    });
    
    container.appendChild(quickSelectionDiv);
}

// Date Picker Enhancements
function initializeDatePickers() {
    const transactionDateInput = document.getElementById('ADate');
    const chequeDateInput = document.getElementById('ADate1');
    
    if (transactionDateInput) {
        addQuickDateSelection(transactionDateInput, 'Transaction');
    }
    
    if (chequeDateInput) {
        addQuickDateSelection(chequeDateInput, 'Cheque');
    }
}

function addQuickDateSelection(dateInput, type) {
    const container = dateInput.parentNode;
    const quickDateDiv = document.createElement('div');
    quickDateDiv.className = 'quick-date-selection';
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
        { label: 'Last Month', days: -30 }
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
            const targetDate = new Date();
            targetDate.setDate(targetDate.getDate() + quickDate.days);
            dateInput.value = targetDate.toISOString().split('T')[0];
            dateInput.dispatchEvent(new Event('change'));
            showNotification(`${type} Date set to: ${quickDate.label}`, 'success');
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

// Transaction Mode Handling
function initializeTransactionModeHandling() {
    const transactionModeSelect = document.getElementById('transactionmode');
    if (transactionModeSelect) {
        transactionModeSelect.addEventListener('change', function() {
            handleTransactionModeChange(this.value);
        });
    }
}

function handleTransactionModeChange(mode) {
    const chequeFields = document.querySelectorAll('.hideshow');
    
    if (mode === 'CHEQUE') {
        chequeFields.forEach(field => {
            field.classList.add('show');
        });
        
        // Focus on first cheque field
        const chequeDateInput = document.getElementById('ADate1');
        if (chequeDateInput) {
            chequeDateInput.focus();
        }
        
        showNotification('Cheque mode selected. Please fill in cheque details.', 'info');
    } else {
        chequeFields.forEach(field => {
            field.classList.remove('show');
        });
        
        // Clear cheque fields
        const chequeDateInput = document.getElementById('ADate1');
        const chequeNumberInput = document.getElementById('chequenumber');
        
        if (chequeDateInput) chequeDateInput.value = '';
        if (chequeNumberInput) chequeNumberInput.value = '';
        
        showNotification(`${mode} mode selected.`, 'success');
    }
}

// Auto-complete Enhancement
function initializeAutoComplete() {
    // Add auto-complete for person name
    const personNameInput = document.getElementById('personname');
    if (personNameInput) {
        addPersonNameAutoComplete(personNameInput);
    }
    
    // Add auto-complete for remarks
    const remarksTextarea = document.getElementById('remarks');
    if (remarksTextarea) {
        addRemarksAutoComplete(remarksTextarea);
    }
}

function addPersonNameAutoComplete(input) {
    const commonNames = [
        'John Doe', 'Jane Smith', 'Mike Johnson', 'Sarah Wilson',
        'David Brown', 'Lisa Davis', 'Robert Miller', 'Emma Garcia'
    ];
    
    input.addEventListener('input', function() {
        const value = this.value.toLowerCase();
        if (value.length >= 2) {
            const suggestions = commonNames.filter(name => 
                name.toLowerCase().includes(value)
            );
            
            if (suggestions.length > 0) {
                showAutoCompleteSuggestions(this, suggestions);
            }
        }
    });
}

function addRemarksAutoComplete(textarea) {
    const commonRemarks = [
        'Bank transfer', 'Cash deposit', 'Cheque payment',
        'Monthly transfer', 'Emergency withdrawal', 'Regular deposit'
    ];
    
    textarea.addEventListener('input', function() {
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
    const form = document.getElementById('form1');
    if (!form) return;
    
    const autoSaveKey = 'bank_entry_form_autosave';
    
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
            
            // Trigger change events to update UI
            const event = new Event('change');
            form.querySelectorAll('select, input').forEach(field => {
                field.dispatchEvent(event);
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
    const amountInput = document.getElementById('amount');
    if (amountInput) {
        amountInput.addEventListener('input', function() {
            formatAmount(this);
        });
        
        amountInput.addEventListener('blur', function() {
            validateAmount(this);
        });
    }
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
    
    if (isNaN(value) || value <= 0) {
        showFieldError(input, 'Please enter a valid amount');
        return false;
    }
    
    // Check against credit balance
    const creditBalance = parseFloat(document.getElementById('crbal')?.value.replace(/,/g, '') || 0);
    if (value > creditBalance) {
        showFieldError(input, 'Amount cannot exceed credit balance');
        return false;
    }
    
    clearFieldError(input);
    return true;
}

// Balance Checking
function initializeBalanceChecking() {
    // This function integrates with the existing balance checking functionality
    console.log('Balance checking initialized');
}

// Enhanced balance checking function
function checkBalanceWithNotification() {
    const amountInput = document.getElementById('amount');
    const creditBalanceInput = document.getElementById('crbal');
    
    if (amountInput && creditBalanceInput) {
        const amount = parseFloat(amountInput.value.replace(/,/g, '') || 0);
        const creditBalance = parseFloat(creditBalanceInput.value.replace(/,/g, '') || 0);
        
        if (amount > creditBalance) {
            showNotification(`Warning: Amount (${amount.toLocaleString()}) exceeds credit balance (${creditBalance.toLocaleString()})`, 'warning');
            return false;
        }
        
        if (amount > 0) {
            showNotification(`Amount validated: ${amount.toLocaleString()}`, 'success');
        }
        
        return true;
    }
    
    return false;
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

// Enhanced legacy functions
function change123() {
    const amountInput = document.getElementById('amount');
    const creditBalanceInput = document.getElementById('crbal');
    
    if (amountInput && creditBalanceInput) {
        const amount = parseFloat(amountInput.value.replace(/,/g, '') || 0);
        const creditBalance = parseFloat(creditBalanceInput.value.replace(/,/g, '') || 0);
        
        if (amount > creditBalance) {
            showNotification('Amount cannot exceed credit balance', 'error');
            amountInput.value = '';
            amountInput.focus();
            return false;
        }
        
        if (amount > 0) {
            showNotification('Amount validated successfully', 'success');
        }
    }
    
    return true;
}

// Export functions for global access
window.BankEntryForm1Modern = {
    validateForm,
    showNotification,
    checkBalanceWithNotification,
    change123,
    addBankSearchEnhancements,
    addQuickDateSelection,
    handleTransactionModeChange
};
