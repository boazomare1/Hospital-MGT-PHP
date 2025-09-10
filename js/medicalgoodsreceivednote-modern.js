// Medical Goods Received Note Modern JavaScript
// Handles form validation, responsive design, and enhanced user experience for medical goods received note management

document.addEventListener('DOMContentLoaded', function() {
    initializeSidebar();
    initializeMenuToggle();
    initializeFormValidation();
    initializeResponsiveDesign();
    initializeTouchSupport();
    initializeFormEnhancements();
    initializeItemsTable();
    initializeCalculations();
    initializeFormAutoSave();
    initializeItemSearch();
    initializeQuantityValidation();
});

// Sidebar Management
function initializeSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
        });
    }
}

// Menu Toggle
function initializeMenuToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
        
        // Close sidebar when clicking outside
        document.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }
}

// Form Validation
function initializeFormValidation() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
        
        initializeRealTimeValidation(form);
    });
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    // Validate items table
    if (!validateItemsTable()) {
        isValid = false;
    }
    
    // Validate quantities
    if (!validateQuantities()) {
        isValid = false;
    }
    
    return isValid;
}

function validateItemsTable() {
    const itemRows = document.querySelectorAll('tbody tr');
    let hasItems = false;
    let isValid = true;
    
    itemRows.forEach(row => {
        const itemName = row.querySelector('input[name="itemname[]"]');
        const receivedQty = row.querySelector('input[name="receivedquantity[]"]');
        
        if (itemName && itemName.value.trim()) {
            hasItems = true;
            
            if (receivedQty && receivedQty.value.trim()) {
                const qty = parseFloat(receivedQty.value);
                if (isNaN(qty) || qty <= 0) {
                    showFieldError(receivedQty, 'Please enter a valid quantity');
                    isValid = false;
                } else {
                    clearFieldError(receivedQty);
                }
            }
        }
    });
    
    if (!hasItems) {
        showNotification('Please add at least one item to the received note', 'warning');
        isValid = false;
    }
    
    return isValid;
}

function validateQuantities() {
    const receivedQtyInputs = document.querySelectorAll('input[name="receivedquantity[]"]');
    let isValid = true;
    
    receivedQtyInputs.forEach(input => {
        if (input.value.trim()) {
            const receivedQty = parseFloat(input.value);
            const balanceQty = parseFloat(input.closest('tr').querySelector('input[name="balqty[]"]')?.value || 0);
            
            if (receivedQty > balanceQty) {
                showFieldError(input, `Received quantity cannot exceed balance quantity (${balanceQty})`);
                isValid = false;
            } else {
                clearFieldError(input);
            }
        }
    });
    
    return isValid;
}

function initializeRealTimeValidation(form) {
    const formFields = form.querySelectorAll('input, select, textarea');
    
    formFields.forEach(field => {
        field.addEventListener('change', function() {
            validateField(this);
        });
        
        field.addEventListener('blur', function() {
            validateField(this);
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Special validation for numeric fields
    if (field.type === 'number' || field.classList.contains('numeric')) {
        if (value && isNaN(parseFloat(value))) {
            showFieldError(field, 'Please enter a valid number');
            return false;
        }
    }
    
    // Special validation for date fields
    if (field.type === 'date' || field.classList.contains('datepicker')) {
        if (value && !isValidDate(value)) {
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
    
    field.classList.add('invalid');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('invalid');
    field.classList.add('valid');
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
    const tables = document.querySelectorAll('.items-table');
    tables.forEach(table => {
        if (!table.classList.contains('mobile-adjusted')) {
            table.classList.add('mobile-adjusted');
            addMobileTableEnhancements(table);
        }
    });
}

function restoreTableLayout() {
    const tables = document.querySelectorAll('.items-table');
    tables.forEach(table => {
        table.classList.remove('mobile-adjusted');
        removeMobileTableEnhancements(table);
    });
}

function addMobileTableEnhancements(table) {
    const rows = table.querySelectorAll('tbody tr');
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
    const buttons = document.querySelectorAll('.btn');
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
                this.value = 'Saving...';
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
            if (submitButton && !submitButton.disabled) {
                submitButton.click();
            }
        }
        
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            const submitButton = document.querySelector('input[type="submit"]');
            if (submitButton && !submitButton.disabled) {
                submitButton.click();
            }
        }
        
        if (e.key === 'Escape') {
            document.activeElement.blur();
        }
        
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            if (confirm('Are you sure you want to reset the form?')) {
                document.querySelector('form').reset();
            }
        }
    });
}

function addFormResetConfirmation() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('reset', function(e) {
            if (!confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
                e.preventDefault();
            }
        });
    });
}

// Items Table Enhancement
function initializeItemsTable() {
    const tables = document.querySelectorAll('.items-table');
    tables.forEach(table => {
        addTableSorting(table);
        addRowHighlighting(table);
        addMobileEnhancements(table);
        addQuantityValidation(table);
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

function addRowHighlighting(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.classList.add('item-row');
        
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

function addQuantityValidation(table) {
    const receivedQtyInputs = table.querySelectorAll('input[name="receivedquantity[]"]');
    
    receivedQtyInputs.forEach(input => {
        input.addEventListener('input', function() {
            validateQuantityField(this);
        });
        
        input.addEventListener('blur', function() {
            validateQuantityField(this);
        });
    });
}

function validateQuantityField(input) {
    const value = input.value.trim();
    
    if (value) {
        const qty = parseFloat(value);
        if (isNaN(qty) || qty < 0) {
            showFieldError(input, 'Please enter a valid quantity');
            return false;
        }
        
        // Check against balance quantity
        const row = input.closest('tr');
        const balanceQtyInput = row.querySelector('input[name="balqty[]"]');
        if (balanceQtyInput) {
            const balanceQty = parseFloat(balanceQtyInput.value) || 0;
            if (qty > balanceQty) {
                showFieldError(input, `Quantity cannot exceed balance (${balanceQty})`);
                return false;
            }
        }
        
        clearFieldError(input);
        return true;
    }
    
    return true;
}

// Calculations
function initializeCalculations() {
    // Initialize existing calculation functions
    if (typeof totalcalc === 'function') {
        // Override with enhanced version
        window.totalcalc = enhancedTotalCalc;
    }
    
    if (typeof totalamount === 'function') {
        // Override with enhanced version
        window.totalamount = enhancedTotalAmount;
    }
    
    if (typeof totalamountdisc === 'function') {
        // Override with enhanced version
        window.totalamountdisc = enhancedTotalAmountDisc;
    }
    
    if (typeof totalamount20 === 'function') {
        // Override with enhanced version
        window.totalamount20 = enhancedTotalAmount20;
    }
    
    // Add calculation event listeners
    addCalculationEventListeners();
}

function addCalculationEventListeners() {
    const receivedQtyInputs = document.querySelectorAll('input[name="receivedquantity[]"]');
    const discountInputs = document.querySelectorAll('input[name="discount[]"]');
    const taxInputs = document.querySelectorAll('input[name="tax[]"]');
    
    receivedQtyInputs.forEach(input => {
        input.addEventListener('input', function() {
            const rowIndex = this.id.replace('receivedquantity', '');
            calculateRowTotals(rowIndex);
        });
    });
    
    discountInputs.forEach(input => {
        input.addEventListener('input', function() {
            const rowIndex = this.id.replace('discount', '');
            calculateRowTotals(rowIndex);
        });
    });
    
    taxInputs.forEach(input => {
        input.addEventListener('input', function() {
            const rowIndex = this.id.replace('tax', '');
            calculateRowTotals(rowIndex);
        });
    });
}

function calculateRowTotals(rowIndex) {
    const row = document.querySelector(`#receivedquantity${rowIndex}`).closest('tr');
    
    // Get values
    const rate = parseFloat(row.querySelector('input[name="rate[]"]')?.value || 0);
    const receivedQty = parseFloat(row.querySelector(`#receivedquantity${rowIndex}`).value || 0);
    const discount = parseFloat(row.querySelector(`#discount${rowIndex}`).value || 0);
    const tax = parseFloat(row.querySelector(`#tax${rowIndex}`).value || 0);
    
    // Calculate totals
    const subtotal = rate * receivedQty;
    const discountAmount = (subtotal * discount) / 100;
    const amountAfterDiscount = subtotal - discountAmount;
    const taxAmount = (amountAfterDiscount * tax) / 100;
    const totalAmount = amountAfterDiscount + taxAmount;
    
    // Update display fields
    const totalQtyInput = row.querySelector(`#totalquantity${rowIndex}`);
    if (totalQtyInput) {
        totalQtyInput.value = receivedQty;
    }
    
    const totalAmountInput = row.querySelector(`#totalamount${rowIndex}`);
    if (totalAmountInput) {
        totalAmountInput.value = totalAmount.toFixed(2);
    }
    
    // Update summary
    updateSummaryCalculations();
}

function updateSummaryCalculations() {
    const rows = document.querySelectorAll('tbody tr');
    let totalPurchaseCost = 0;
    let totalFXCost = 0;
    
    rows.forEach(row => {
        const totalAmountInput = row.querySelector('input[name="totalamount[]"]');
        if (totalAmountInput && totalAmountInput.value) {
            totalPurchaseCost += parseFloat(totalAmountInput.value) || 0;
        }
        
        const fxAmountInput = row.querySelector('input[name="fxamount[]"]');
        if (fxAmountInput && fxAmountInput.value) {
            totalFXCost += parseFloat(fxAmountInput.value) || 0;
        }
    });
    
    // Update summary fields
    const totalPurchaseInput = document.getElementById('totalpurchaseamount');
    if (totalPurchaseInput) {
        totalPurchaseInput.value = totalPurchaseCost.toFixed(2);
    }
    
    const totalFXInput = document.getElementById('totalfxamount');
    if (totalFXInput) {
        totalFXInput.value = totalFXCost.toFixed(2);
    }
}

// Enhanced calculation functions
function enhancedTotalCalc(rowIndex) {
    calculateRowTotals(rowIndex);
}

function enhancedTotalAmount(rowIndex, number) {
    calculateRowTotals(rowIndex);
}

function enhancedTotalAmountDisc(rowIndex, number) {
    calculateRowTotals(rowIndex);
}

function enhancedTotalAmount20(rowIndex, number) {
    calculateRowTotals(rowIndex);
}

// Form Auto-save
function initializeFormAutoSave() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        const autoSaveKey = `medical_goods_received_${form.action}_autosave`;
        
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
    });
}

// Item Search Enhancement
function initializeItemSearch() {
    const itemCodeInputs = document.querySelectorAll('input[name="itemcode[]"]');
    
    itemCodeInputs.forEach(input => {
        input.addEventListener('input', function() {
            searchItems(this);
        });
        
        input.addEventListener('blur', function() {
            validateItemCode(this);
        });
    });
}

function searchItems(input) {
    const searchTerm = input.value.trim();
    if (searchTerm.length < 2) return;
    
    // Simulate item search (in real implementation, this would be an AJAX call)
    const mockItems = [
        { code: 'MED001', name: 'Paracetamol 500mg', rate: 0.50 },
        { code: 'MED002', name: 'Ibuprofen 400mg', rate: 0.75 },
        { code: 'MED003', name: 'Amoxicillin 250mg', rate: 1.25 },
        { code: 'MED004', name: 'Omeprazole 20mg', rate: 2.00 }
    ];
    
    const matchedItems = mockItems.filter(item => 
        item.code.toLowerCase().includes(searchTerm.toLowerCase()) ||
        item.name.toLowerCase().includes(searchTerm.toLowerCase())
    );
    
    if (matchedItems.length > 0) {
        showItemSuggestions(input, matchedItems);
    }
}

function showItemSuggestions(input, items) {
    // Remove existing suggestions
    const existingSuggestions = document.querySelector('.item-suggestions');
    if (existingSuggestions) {
        existingSuggestions.remove();
    }
    
    const suggestionsDiv = document.createElement('div');
    suggestionsDiv.className = 'item-suggestions';
    suggestionsDiv.style.cssText = `
        position: absolute;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        width: 300px;
    `;
    
    items.forEach(item => {
        const itemDiv = document.createElement('div');
        itemDiv.style.cssText = `
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        `;
        itemDiv.innerHTML = `
            <strong>${item.code}</strong> - ${item.name}<br>
            <small>Rate: $${item.rate}</small>
        `;
        
        itemDiv.addEventListener('click', function() {
            selectItem(input, item);
            suggestionsDiv.remove();
        });
        
        itemDiv.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f0f0f0';
        });
        
        itemDiv.addEventListener('mouseleave', function() {
            this.style.backgroundColor = 'white';
        });
        
        suggestionsDiv.appendChild(itemDiv);
    });
    
    input.parentNode.style.position = 'relative';
    input.parentNode.appendChild(suggestionsDiv);
    
    // Position suggestions below input
    const rect = input.getBoundingClientRect();
    suggestionsDiv.style.top = `${rect.height}px`;
    suggestionsDiv.style.left = '0px';
}

function selectItem(input, item) {
    const row = input.closest('tr');
    
    // Update item code
    input.value = item.code;
    
    // Update item name
    const itemNameInput = row.querySelector('input[name="itemname[]"]');
    if (itemNameInput) {
        itemNameInput.value = item.name;
    }
    
    // Update rate
    const rateInput = row.querySelector('input[name="rate[]"]');
    if (rateInput) {
        rateInput.value = item.rate;
    }
    
    // Trigger calculation
    const rowIndex = input.id.replace('itemcode', '');
    calculateRowTotals(rowIndex);
    
    showNotification(`Item selected: ${item.name}`, 'success');
}

function validateItemCode(input) {
    const code = input.value.trim();
    if (code && !isValidItemCode(code)) {
        showFieldError(input, 'Invalid item code');
        return false;
    }
    
    clearFieldError(input);
    return true;
}

function isValidItemCode(code) {
    // Simple validation - in real implementation, this would check against database
    return /^[A-Z0-9]{3,10}$/.test(code);
}

// Quantity Validation
function initializeQuantityValidation() {
    const receivedQtyInputs = document.querySelectorAll('input[name="receivedquantity[]"]');
    
    receivedQtyInputs.forEach(input => {
        input.addEventListener('input', function() {
            validateQuantityInput(this);
        });
        
        input.addEventListener('blur', function() {
            validateQuantityInput(this);
        });
    });
}

function validateQuantityInput(input) {
    const value = input.value.trim();
    
    if (value) {
        const qty = parseFloat(value);
        
        if (isNaN(qty) || qty < 0) {
            showFieldError(input, 'Please enter a valid quantity');
            return false;
        }
        
        // Check against balance quantity
        const row = input.closest('tr');
        const balanceQtyInput = row.querySelector('input[name="balqty[]"]');
        
        if (balanceQtyInput) {
            const balanceQty = parseFloat(balanceQtyInput.value) || 0;
            if (qty > balanceQty) {
                showFieldError(input, `Quantity cannot exceed available balance (${balanceQty})`);
                return false;
            }
        }
        
        clearFieldError(input);
        return true;
    }
    
    return true;
}

// Enhanced legacy functions
function funcsave(number) {
    if (validateForm(document.querySelector('form'))) {
        showNotification('Saving medical goods received note...', 'info');
        return true;
    }
    return false;
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.25rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        max-width: 400px;
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
    notification.style.color = 'white';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
        <span>${message}</span>
        <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
    `;
    
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
function isValidDate(dateString) {
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

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

// Export functions for global access
window.MedicalGoodsReceivedNoteModern = {
    validateForm,
    showNotification,
    funcsave,
    enhancedTotalCalc,
    enhancedTotalAmount,
    enhancedTotalAmountDisc,
    enhancedTotalAmount20
};




