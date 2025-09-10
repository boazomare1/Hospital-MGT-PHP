/**
 * Direct Purchase - Modern Hospital Management System JavaScript
 * Enhanced functionality for purchase order management
 */

// Global variables
let itemCounter = 0;
let totalAmount = 0;
let templateItems = [];

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
    setupEventListeners();
    loadTemplateItems();
    updateTotalAmount();
});

/**
 * Initialize the application
 */
function initializeApp() {
    console.log('Initializing Direct Purchase System...');
    
    // Add fade-in animation to main container
    const mainContainer = document.querySelector('.main-container');
    if (mainContainer) {
        mainContainer.classList.add('fade-in');
    }
    
    // Initialize form validation
    initializeFormValidation();
    
    // Setup auto-save functionality
    setupAutoSave();
    
    // Initialize tooltips
    initializeTooltips();
    
    console.log('Direct Purchase System initialized successfully');
}

/**
 * Setup event listeners
 */
function setupEventListeners() {
    // Form submission
    const form = document.getElementById('frmsales');
    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }
    
    // Add item button
    const addBtn = document.getElementById('Add');
    if (addBtn) {
        addBtn.addEventListener('click', addItem);
    }
    
    // Template checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.matches('input[type="checkbox"][id^="check_template"]')) {
            handleTemplateCheckboxChange(e.target);
        }
    });
    
    // Item input changes
    document.addEventListener('input', function(e) {
        if (e.target.matches('#medicinename, #req_qty, #rate_fx, #tax_percent')) {
            calculateAmount();
        }
    });
    
    // Supplier autocomplete
    const supplierInput = document.getElementById('supplier');
    if (supplierInput) {
        supplierInput.addEventListener('input', handleSupplierSearch);
    }
    
    // Template autocomplete
    const templateInput = document.getElementById('map_template');
    if (templateInput) {
        templateInput.addEventListener('input', handleTemplateSearch);
    }
    
    // Currency change
    const currencySelect = document.getElementById('currency');
    if (currencySelect) {
        currencySelect.addEventListener('change', handleCurrencyChange);
    }
    
    // Validity date change
    const validityDate = document.getElementById('lpodate');
    if (validityDate) {
        validityDate.addEventListener('change', calculateValidityDays);
    }
    
    // Real-time validation
    document.addEventListener('blur', function(e) {
        if (e.target.matches('.form-control')) {
            validateField(e.target);
        }
    }, true);
}

/**
 * Initialize form validation
 */
function initializeFormValidation() {
    const form = document.getElementById('frmsales');
    if (!form) return;
    
    // Add validation classes to required fields
    const requiredFields = form.querySelectorAll('input[required], select[required]');
    requiredFields.forEach(field => {
        field.classList.add('required-field');
    });
    
    // Real-time validation
    form.addEventListener('input', function(e) {
        if (e.target.matches('.form-control')) {
            validateField(e.target);
        }
    });
}

/**
 * Validate individual field
 */
function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name || field.id;
    let isValid = true;
    let errorMessage = '';
    
    // Remove existing error styling
    field.classList.remove('error');
    removeErrorMessage(field);
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = `${getFieldLabel(field)} is required`;
    }
    
    // Specific field validations
    switch (fieldName) {
        case 'supplier':
            if (value && value.length < 3) {
                isValid = false;
                errorMessage = 'Supplier name must be at least 3 characters';
            }
            break;
            
        case 'req_qty':
            if (value && (isNaN(value) || parseFloat(value) <= 0)) {
                isValid = false;
                errorMessage = 'Quantity must be a positive number';
            }
            break;
            
        case 'rate_fx':
            if (value && (isNaN(value) || parseFloat(value) < 0)) {
                isValid = false;
                errorMessage = 'Rate must be a non-negative number';
            }
            break;
            
        case 'lpodate':
            if (value) {
                const selectedDate = new Date(value);
                const today = new Date();
                if (selectedDate <= today) {
                    isValid = false;
                    errorMessage = 'Validity date must be in the future';
                }
            }
            break;
    }
    
    // Apply validation result
    if (!isValid) {
        field.classList.add('error');
        showErrorMessage(field, errorMessage);
    }
    
    return isValid;
}

/**
 * Get field label
 */
function getFieldLabel(field) {
    const label = document.querySelector(`label[for="${field.id}"]`);
    return label ? label.textContent : field.name || field.id;
}

/**
 * Show error message
 */
function showErrorMessage(field, message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    errorDiv.style.color = '#dc3545';
    errorDiv.style.fontSize = '0.8rem';
    errorDiv.style.marginTop = '0.25rem';
    
    field.parentNode.appendChild(errorDiv);
}

/**
 * Remove error message
 */
function removeErrorMessage(field) {
    const errorMessage = field.parentNode.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
}

/**
 * Handle form submission
 */
function handleFormSubmit(e) {
    e.preventDefault();
    
    console.log('Form submission started...');
    
    // Validate all fields
    const form = e.target;
    const fields = form.querySelectorAll('.form-control');
    let isFormValid = true;
    
    fields.forEach(field => {
        if (!validateField(field)) {
            isFormValid = false;
        }
    });
    
    // Check if at least one item is added
    const itemsTable = document.getElementById('insertrow');
    if (!itemsTable || itemsTable.children.length === 0) {
        showNotification('Please add at least one item to the purchase order', 'error');
        isFormValid = false;
    }
    
    if (!isFormValid) {
        showNotification('Please fix the errors before submitting', 'error');
        return false;
    }
    
    // Show loading state
    const submitBtn = form.querySelector('input[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.value = 'Saving...';
        submitBtn.classList.add('loading');
    }
    
    // Submit form
    setTimeout(() => {
        form.submit();
    }, 1000);
    
    return true;
}

/**
 * Add item to the purchase order
 */
function addItem() {
    const medicineName = document.getElementById('medicinename').value.trim();
    const quantity = document.getElementById('req_qty').value.trim();
    const rate = document.getElementById('rate_fx').value.trim();
    const taxPercent = document.getElementById('tax_percent').value;
    const amount = document.getElementById('amount').value.trim();
    
    // Validate required fields
    if (!medicineName || !quantity || !rate || !amount) {
        showNotification('Please fill in all item details', 'error');
        return false;
    }
    
    // Validate numeric values
    if (isNaN(quantity) || parseFloat(quantity) <= 0) {
        showNotification('Please enter a valid quantity', 'error');
        return false;
    }
    
    if (isNaN(rate) || parseFloat(rate) < 0) {
        showNotification('Please enter a valid rate', 'error');
        return false;
    }
    
    itemCounter++;
    
    // Create item row
    const itemRow = createItemRow(itemCounter, {
        medicineName,
        quantity,
        rate,
        taxPercent,
        amount
    });
    
    // Add to table
    const insertRow = document.getElementById('insertrow');
    if (insertRow) {
        insertRow.appendChild(itemRow);
    }
    
    // Update total
    updateTotalAmount();
    
    // Clear form
    clearItemForm();
    
    // Show success message
    showNotification('Item added successfully', 'success');
    
    // Add animation
    itemRow.classList.add('slide-in');
    
    return true;
}

/**
 * Create item row HTML
 */
function createItemRow(index, item) {
    const row = document.createElement('tr');
    row.id = `idTR${index}`;
    row.className = 'item-row';
    
    row.innerHTML = `
        <td>
            <div class="item-name">${item.medicineName}</div>
            <div class="item-details">
                <span class="item-qty">Qty: ${item.quantity}</span>
                <span class="item-rate">Rate: ${formatCurrency(item.rate)}</span>
            </div>
        </td>
        <td class="text-center">
            <span class="tax-badge">${item.taxPercent}%</span>
        </td>
        <td class="text-right">
            <span class="amount-display">${formatCurrency(item.amount)}</span>
        </td>
        <td class="text-center">
            <button type="button" class="btn-delete" onclick="deleteItem(${index}, ${parseFloat(item.amount.replace(/,/g, ''))})">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;
    
    return row;
}

/**
 * Delete item from the list
 */
function deleteItem(index, amount) {
    if (!confirm('Are you sure you want to delete this item?')) {
        return false;
    }
    
    const row = document.getElementById(`idTR${index}`);
    if (row) {
        // Add fade-out animation
        row.style.transition = 'all 0.3s ease';
        row.style.opacity = '0';
        row.style.transform = 'translateX(-100%)';
        
        setTimeout(() => {
            row.remove();
            updateTotalAmount();
            showNotification('Item deleted successfully', 'success');
        }, 300);
    }
    
    return true;
}

/**
 * Calculate amount for current item
 */
function calculateAmount() {
    const medicineName = document.getElementById('medicinename').value.trim();
    const quantity = parseFloat(document.getElementById('req_qty').value) || 0;
    const rate = parseFloat(document.getElementById('rate_fx').value.replace(/,/g, '')) || 0;
    const taxPercent = parseFloat(document.getElementById('tax_percent').value) || 0;
    
    if (!medicineName) {
        document.getElementById('amount').value = '';
        return;
    }
    
    if (quantity <= 0 || rate < 0) {
        document.getElementById('amount').value = '';
        return;
    }
    
    // Calculate base amount
    const baseAmount = quantity * rate;
    
    // Calculate tax
    const taxAmount = (baseAmount * taxPercent) / 100;
    
    // Calculate total amount
    const totalAmount = baseAmount + taxAmount;
    
    // Update amount field
    document.getElementById('amount').value = formatCurrency(totalAmount);
    
    // Update hidden rate field
    document.getElementById('rate').value = rate;
}

/**
 * Clear item form
 */
function clearItemForm() {
    document.getElementById('medicinename').value = '';
    document.getElementById('req_qty').value = '';
    document.getElementById('rate_fx').value = '';
    document.getElementById('tax_percent').value = '';
    document.getElementById('amount').value = '';
    document.getElementById('rate').value = '';
}

/**
 * Update total amount
 */
function updateTotalAmount() {
    const itemRows = document.querySelectorAll('.item-row');
    let total = 0;
    
    itemRows.forEach(row => {
        const amountText = row.querySelector('.amount-display').textContent;
        const amount = parseFloat(amountText.replace(/[^0-9.-]/g, '')) || 0;
        total += amount;
    });
    
    totalAmount = total;
    
    const totalElement = document.getElementById('total');
    if (totalElement) {
        totalElement.value = formatCurrency(total);
    }
    
    // Update total display
    const totalDisplay = document.querySelector('.total-amount');
    if (totalDisplay) {
        totalDisplay.textContent = formatCurrency(total);
    }
}

/**
 * Handle template checkbox change
 */
function handleTemplateCheckboxChange(checkbox) {
    const id = checkbox.id.replace('check_template', '');
    const itemName = document.getElementById(`template_item${id}`).value;
    const itemQty = document.getElementById(`template_item_size${id}`).value;
    
    if (checkbox.checked) {
        // Add to current item form
        document.getElementById('medicinename').value = itemName;
        document.getElementById('req_qty').value = itemQty;
        
        // Focus on rate field
        document.getElementById('rate_fx').focus();
        
        showNotification('Template item selected. Please enter the rate.', 'info');
    } else {
        // Remove from total if it was added
        const currentTotal = parseFloat(document.getElementById('total').value.replace(/,/g, '')) || 0;
        const itemAmount = parseFloat(document.getElementById(`template_amount${id}`).value.replace(/,/g, '')) || 0;
        
        if (itemAmount > 0) {
            const newTotal = currentTotal - itemAmount;
            document.getElementById('total').value = formatCurrency(newTotal);
        }
        
        // Clear template amount fields
        document.getElementById(`template_rate${id}`).value = '';
        document.getElementById(`template_amount${id}`).value = '';
    }
}

/**
 * Handle supplier search
 */
function handleSupplierSearch(e) {
    const query = e.target.value.trim();
    
    if (query.length < 2) {
        hideSupplierSuggestions();
        return;
    }
    
    // Simulate API call (replace with actual implementation)
    setTimeout(() => {
        const suggestions = getSupplierSuggestions(query);
        showSupplierSuggestions(suggestions);
    }, 300);
}

/**
 * Get supplier suggestions (mock data)
 */
function getSupplierSuggestions(query) {
    // This would typically be an API call
    const mockSuppliers = [
        { id: 'SUP001', name: 'ABC Medical Supplies', code: 'SUP001' },
        { id: 'SUP002', name: 'XYZ Pharmaceuticals', code: 'SUP002' },
        { id: 'SUP003', name: 'MedTech Solutions', code: 'SUP003' },
        { id: 'SUP004', name: 'HealthCare Partners', code: 'SUP004' },
        { id: 'SUP005', name: 'Global Medical Corp', code: 'SUP005' }
    ];
    
    return mockSuppliers.filter(supplier => 
        supplier.name.toLowerCase().includes(query.toLowerCase())
    );
}

/**
 * Show supplier suggestions
 */
function showSupplierSuggestions(suggestions) {
    hideSupplierSuggestions();
    
    if (suggestions.length === 0) return;
    
    const supplierInput = document.getElementById('supplier');
    const suggestionsDiv = document.createElement('div');
    suggestionsDiv.className = 'suggestions-dropdown';
    suggestionsDiv.id = 'supplier-suggestions';
    
    suggestions.forEach(supplier => {
        const suggestionItem = document.createElement('div');
        suggestionItem.className = 'suggestion-item';
        suggestionItem.innerHTML = `
            <div class="suggestion-name">${supplier.name}</div>
            <div class="suggestion-code">${supplier.code}</div>
        `;
        
        suggestionItem.addEventListener('click', () => {
            selectSupplier(supplier);
        });
        
        suggestionsDiv.appendChild(suggestionItem);
    });
    
    supplierInput.parentNode.appendChild(suggestionsDiv);
}

/**
 * Hide supplier suggestions
 */
function hideSupplierSuggestions() {
    const suggestions = document.getElementById('supplier-suggestions');
    if (suggestions) {
        suggestions.remove();
    }
}

/**
 * Select supplier
 */
function selectSupplier(supplier) {
    document.getElementById('supplier').value = supplier.name;
    document.getElementById('srchsuppliercode').value = supplier.code;
    document.getElementById('searchsupplieranum').value = supplier.id;
    
    hideSupplierSuggestions();
    
    showNotification(`Supplier ${supplier.name} selected`, 'success');
}

/**
 * Handle template search
 */
function handleTemplateSearch(e) {
    const query = e.target.value.trim();
    
    if (query.length < 2) {
        hideTemplateSuggestions();
        return;
    }
    
    // Simulate API call
    setTimeout(() => {
        const suggestions = getTemplateSuggestions(query);
        showTemplateSuggestions(suggestions);
    }, 300);
}

/**
 * Get template suggestions (mock data)
 */
function getTemplateSuggestions(query) {
    const mockTemplates = [
        { id: 'TMP001', name: 'Emergency Supplies Template', code: 'TMP001' },
        { id: 'TMP002', name: 'Surgical Equipment Template', code: 'TMP002' },
        { id: 'TMP003', name: 'Pharmacy Items Template', code: 'TMP003' },
        { id: 'TMP004', name: 'Laboratory Supplies Template', code: 'TMP004' },
        { id: 'TMP005', name: 'General Medical Template', code: 'TMP005' }
    ];
    
    return mockTemplates.filter(template => 
        template.name.toLowerCase().includes(query.toLowerCase())
    );
}

/**
 * Show template suggestions
 */
function showTemplateSuggestions(suggestions) {
    hideTemplateSuggestions();
    
    if (suggestions.length === 0) return;
    
    const templateInput = document.getElementById('map_template');
    const suggestionsDiv = document.createElement('div');
    suggestionsDiv.className = 'suggestions-dropdown';
    suggestionsDiv.id = 'template-suggestions';
    
    suggestions.forEach(template => {
        const suggestionItem = document.createElement('div');
        suggestionItem.className = 'suggestion-item';
        suggestionItem.innerHTML = `
            <div class="suggestion-name">${template.name}</div>
            <div class="suggestion-code">${template.code}</div>
        `;
        
        suggestionItem.addEventListener('click', () => {
            selectTemplate(template);
        });
        
        suggestionsDiv.appendChild(suggestionItem);
    });
    
    templateInput.parentNode.appendChild(suggestionsDiv);
}

/**
 * Hide template suggestions
 */
function hideTemplateSuggestions() {
    const suggestions = document.getElementById('template-suggestions');
    if (suggestions) {
        suggestions.remove();
    }
}

/**
 * Select template
 */
function selectTemplate(template) {
    document.getElementById('map_template').value = template.name;
    document.getElementById('map_template_code').value = template.code;
    document.getElementById('map_template_auto').value = template.id;
    
    hideTemplateSuggestions();
    
    // Load template items
    loadTemplateItems(template.id);
    
    showNotification(`Template ${template.name} selected`, 'success');
}

/**
 * Load template items
 */
function loadTemplateItems(templateId) {
    if (!templateId) return;
    
    // Simulate loading template items
    const mockItems = [
        { name: 'Surgical Gloves', quantity: 100 },
        { name: 'Syringes 10ml', quantity: 50 },
        { name: 'Bandages', quantity: 200 },
        { name: 'Antiseptic Solution', quantity: 25 }
    ];
    
    templateItems = mockItems;
    displayTemplateItems();
}

/**
 * Display template items
 */
function displayTemplateItems() {
    const templateSection = document.querySelector('.template-items');
    if (!templateSection) return;
    
    templateSection.innerHTML = '';
    
    templateItems.forEach((item, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'template-item';
        itemDiv.innerHTML = `
            <input type="checkbox" 
                   class="template-checkbox" 
                   id="check_template${index + 1}" 
                   onchange="handleTemplateCheckboxChange(this)">
            <div class="template-item-name">${item.name}</div>
            <div class="template-item-qty">${item.quantity}</div>
            <input type="hidden" 
                   name="template_item${index + 1}" 
                   id="template_item${index + 1}" 
                   value="${item.name}">
            <input type="hidden" 
                   name="template_item_size${index + 1}" 
                   id="template_item_size${index + 1}" 
                   value="${item.quantity}">
        `;
        
        templateSection.appendChild(itemDiv);
    });
}

/**
 * Handle currency change
 */
function handleCurrencyChange(e) {
    const selectedValue = e.target.value;
    if (selectedValue) {
        const [rate, currency] = selectedValue.split(',');
        document.getElementById('fxamount').value = rate;
        
        showNotification(`Currency changed to ${currency}`, 'info');
    }
}

/**
 * Calculate validity days
 */
function calculateValidityDays() {
    const today = new Date();
    const validityDate = new Date(document.getElementById('lpodate').value);
    
    if (validityDate && validityDate > today) {
        const diffTime = validityDate - today;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        document.getElementById('validityperiod').value = diffDays;
    } else {
        document.getElementById('validityperiod').value = 0;
    }
}

/**
 * Setup auto-save functionality
 */
function setupAutoSave() {
    const form = document.getElementById('frmsales');
    if (!form) return;
    
    // Auto-save every 30 seconds
    setInterval(() => {
        saveFormData();
    }, 30000);
    
    // Save on page unload
    window.addEventListener('beforeunload', () => {
        saveFormData();
    });
}

/**
 * Save form data to localStorage
 */
function saveFormData() {
    const form = document.getElementById('frmsales');
    if (!form) return;
    
    const formData = new FormData(form);
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    localStorage.setItem('direct_purchase_draft', JSON.stringify(data));
    console.log('Form data auto-saved');
}

/**
 * Load saved form data
 */
function loadFormData() {
    const savedData = localStorage.getItem('direct_purchase_draft');
    if (!savedData) return;
    
    try {
        const data = JSON.parse(savedData);
        
        Object.keys(data).forEach(key => {
            const element = document.getElementById(key) || document.querySelector(`[name="${key}"]`);
            if (element) {
                element.value = data[key];
            }
        });
        
        console.log('Form data loaded from draft');
    } catch (error) {
        console.error('Error loading saved form data:', error);
    }
}

/**
 * Clear saved form data
 */
function clearFormData() {
    localStorage.removeItem('direct_purchase_draft');
    console.log('Saved form data cleared');
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

/**
 * Show tooltip
 */
function showTooltip(e) {
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = e.target.getAttribute('data-tooltip');
    
    document.body.appendChild(tooltip);
    
    const rect = e.target.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
}

/**
 * Hide tooltip
 */
function hideTooltip() {
    const tooltip = document.querySelector('.tooltip');
    if (tooltip) {
        tooltip.remove();
    }
}

/**
 * Show notification
 */
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-icon">${getNotificationIcon(type)}</span>
            <span class="notification-message">${message}</span>
            <button class="notification-close" onclick="this.parentElement.parentElement.remove()">×</button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

/**
 * Get notification icon
 */
function getNotificationIcon(type) {
    const icons = {
        success: '✓',
        error: '✕',
        warning: '⚠',
        info: 'ℹ'
    };
    return icons[type] || icons.info;
}

/**
 * Format currency
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount);
}

/**
 * Format number with commas
 */
function formatNumber(number) {
    return new Intl.NumberFormat('en-US').format(number);
}

/**
 * Validate email
 */
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

/**
 * Validate phone number
 */
function validatePhone(phone) {
    const re = /^[\+]?[1-9][\d]{0,15}$/;
    return re.test(phone.replace(/\s/g, ''));
}

/**
 * Debounce function
 */
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

/**
 * Throttle function
 */
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Export functions for global access
window.directPurchase = {
    addItem,
    deleteItem,
    calculateAmount,
    updateTotalAmount,
    showNotification,
    formatCurrency,
    formatNumber,
    validateEmail,
    validatePhone
};

