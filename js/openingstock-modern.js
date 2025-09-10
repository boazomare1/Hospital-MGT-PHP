// Opening Stock Entry Modern JavaScript
let allItems = [];
let currentItemCount = 0;

// DOM Elements
let locationSelect, storeSelect, medicineNameInput, salesRateInput, quantityInput, batchInput, expiryDateInput, addButton, saveButton;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializeForm();
});

function initializeElements() {
    locationSelect = document.getElementById('location');
    storeSelect = document.getElementById('store');
    medicineNameInput = document.getElementById('medicinename');
    salesRateInput = document.getElementById('salesrate');
    quantityInput = document.getElementById('quantity');
    batchInput = document.getElementById('batch');
    expiryDateInput = document.getElementById('expirydate');
    addButton = document.getElementById('Add');
    saveButton = document.getElementById('savebutton');
}

function setupEventListeners() {
    if (addButton) {
        addButton.addEventListener('click', handleAddItem);
    }
    
    if (saveButton) {
        saveButton.addEventListener('click', handleFormSubmit);
    }
    
    // Add input event listeners for real-time validation
    if (quantityInput) {
        quantityInput.addEventListener('input', () => validateNumeric(quantityInput, 1));
    }
    
    if (expiryDateInput) {
        expiryDateInput.addEventListener('input', () => validateExpiryDate(expiryDateInput));
    }
    
    if (batchInput) {
        batchInput.addEventListener('input', () => validateBatch(batchInput));
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

function initializeForm() {
    // Set initial values
    if (document.getElementById('codevalue')) {
        document.getElementById('codevalue').value = '0';
    }
    
    if (document.getElementById('serialnumber')) {
        document.getElementById('serialnumber').value = '1';
    }
    
    // Add fade-in animation to form sections
    const formSections = document.querySelectorAll('.form-section');
    formSections.forEach((section, index) => {
        section.style.animationDelay = `${index * 0.1}s`;
        section.classList.add('fade-in');
    });
}

// Handle adding new items
function handleAddItem() {
    if (!validateItemForm()) {
        return false;
    }
    
    const item = {
        id: ++currentItemCount,
        medicineName: medicineNameInput.value.trim(),
        medicineCode: document.getElementById('medicinecode').value.trim(),
        salesRate: parseFloat(salesRateInput.value) || 0,
        quantity: parseInt(quantityInput.value) || 0,
        batch: batchInput.value.trim(),
        expiryDate: expiryDateInput.value.trim()
    };
    
    allItems.push(item);
    addItemToTable(item);
    clearItemForm();
    updateItemCount();
    
    // Show success message
    showAlert('Item added successfully!', 'success');
    
    return false; // Prevent form submission
}

function validateItemForm() {
    const errors = [];
    
    if (!medicineNameInput.value.trim()) {
        errors.push('Medicine name is required');
    }
    
    if (!document.getElementById('medicinecode').value.trim()) {
        errors.push('Medicine code is required');
    }
    
    if (!salesRateInput.value || parseFloat(salesRateInput.value) <= 0) {
        errors.push('Valid sales rate is required');
    }
    
    if (!quantityInput.value || parseInt(quantityInput.value) <= 0) {
        errors.push('Valid quantity is required');
    }
    
    if (!batchInput.value.trim()) {
        errors.push('Batch number is required');
    }
    
    if (!expiryDateInput.value.trim()) {
        errors.push('Expiry date is required');
    }
    
    if (errors.length > 0) {
        showAlert(errors.join('<br>'), 'error');
        return false;
    }
    
    return true;
}

function addItemToTable(item) {
    const insertRow = document.getElementById('insertrow');
    if (!insertRow) return;
    
    const itemRow = document.createElement('div');
    itemRow.className = 'item-entry-row';
    itemRow.id = `idTR${item.id}`;
    
    itemRow.innerHTML = `
        <div class="item-entry-cell">
            <input type="text" name="medicinename${item.id}" value="${item.medicineName}" readonly class="form-input">
        </div>
        <div class="item-entry-cell">
            <input type="text" name="salesrate${item.id}" value="${item.salesRate}" readonly class="form-input">
        </div>
        <div class="item-entry-cell">
            <input type="text" name="quantity${item.id}" value="${item.quantity}" readonly class="form-input">
        </div>
        <div class="item-entry-cell">
            <input type="text" name="batch${item.id}" value="${item.batch}" readonly class="form-input">
        </div>
        <div class="item-entry-cell">
            <input type="text" name="expirydate${item.id}" value="${item.expiryDate}" readonly class="form-input">
        </div>
        <div class="item-entry-cell">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${item.id})">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    
    insertRow.appendChild(itemRow);
    
    // Add animation
    itemRow.classList.add('slide-in');
}

function removeItem(itemId) {
    const itemRow = document.getElementById(`idTR${itemId}`);
    if (itemRow) {
        itemRow.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => {
            itemRow.remove();
            allItems = allItems.filter(item => item.id !== itemId);
            updateItemCount();
            showAlert('Item removed successfully!', 'success');
        }, 300);
    }
}

function clearItemForm() {
    medicineNameInput.value = '';
    salesRateInput.value = '';
    quantityInput.value = '';
    batchInput.value = '';
    expiryDateInput.value = '';
    document.getElementById('medicinecode').value = '';
    
    // Reset focus to medicine name
    medicineNameInput.focus();
}

function updateItemCount() {
    const codeValueElement = document.getElementById('codevalue');
    const serialNumberElement = document.getElementById('serialnumber');
    
    if (codeValueElement) {
        codeValueElement.value = allItems.length;
    }
    
    if (serialNumberElement) {
        serialNumberElement.value = allItems.length + 1;
    }
}

function clearAllItems() {
    if (allItems.length === 0) {
        showAlert('No items to clear', 'warning');
        return;
    }
    
    if (confirm('Are you sure you want to clear all items? This action cannot be undone.')) {
        const insertRow = document.getElementById('insertrow');
        if (insertRow) {
            insertRow.innerHTML = '';
        }
        
        allItems = [];
        currentItemCount = 0;
        updateItemCount();
        showAlert('All items cleared successfully!', 'success');
    }
}

// Form validation functions
function validcheck() {
    // Check if any items are added
    if (allItems.length === 0) {
        showAlert('Please add at least one item before saving', 'error');
        return false;
    }
    
    // Check if location is selected
    if (!locationSelect.value) {
        showAlert('Please select a location', 'error');
        locationSelect.focus();
        return false;
    }
    
    // Check if store is selected
    if (!storeSelect.value) {
        showAlert('Please select a store', 'error');
        storeSelect.focus();
        return false;
    }
    
    // Validate all items
    for (let i = 0; i < allItems.length; i++) {
        const item = allItems[i];
        if (!item.medicineName || !item.medicineCode || item.salesRate <= 0 || 
            item.quantity <= 0 || !item.batch || !item.expiryDate) {
            showAlert(`Please ensure all fields are filled for item ${i + 1}`, 'error');
            return false;
        }
    }
    
    // Final confirmation
    if (confirm('Are you sure you want to save the opening stock entry?')) {
        return true;
    }
    
    return false;
}

function validateNumeric(input, minValue = 0) {
    const value = parseFloat(input.value);
    if (isNaN(value) || value < minValue) {
        showAlert(`Please enter a valid number greater than ${minValue}`, 'error');
        input.focus();
        input.value = '';
        return false;
    }
    return true;
}

function validateExpiryDate(input) {
    const value = input.value.trim();
    const pattern = /^\d{2}\/\d{2}$/;
    
    if (value && !pattern.test(value)) {
        showAlert('Please enter expiry date in MM/YY format (e.g., 12/25)', 'error');
        input.focus();
        input.value = '';
        return false;
    }
    
    // Validate month (01-12)
    if (value) {
        const month = parseInt(value.split('/')[0]);
        if (month < 1 || month > 12) {
            showAlert('Month must be between 01 and 12', 'error');
            input.focus();
            input.value = '';
            return false;
        }
    }
    
    return true;
}

function validateBatch(input) {
    const value = input.value.trim();
    const pattern = /^[a-zA-Z0-9\-_]+$/;
    
    if (value && !pattern.test(value)) {
        showAlert('Batch number can only contain letters, numbers, hyphens, and underscores', 'error');
        input.focus();
        return false;
    }
    
    return true;
}

// Store and location functions
function storefunction(loc) {
    if (!loc) return;
    
    const username = document.getElementById('username').value;
    const storeSelect = document.getElementById('store');
    
    // Show loading state
    storeSelect.innerHTML = '<option value="">Loading stores...</option>';
    storeSelect.disabled = true;
    
    // Make AJAX call
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            storeSelect.disabled = false;
            if (xhr.status === 200) {
                storeSelect.innerHTML = xhr.responseText;
            } else {
                storeSelect.innerHTML = '<option value="">Error loading stores</option>';
                showAlert('Error loading stores. Please try again.', 'error');
            }
        }
    };
    
    xhr.open('GET', `ajax/ajaxstore.php?loc=${encodeURIComponent(loc)}&username=${encodeURIComponent(username)}`, true);
    xhr.send();
}

function storechk(store) {
    if (!store) return;
    
    const location = document.getElementById('location').value;
    
    $.ajax({
        type: 'get',
        url: 'store_stocktaking_chk.php',
        data: {
            storecode: store,
            locationcode: location
        },
        success: function(data) {
            if (data == 1) {
                showAlert('Stock Take in process. Transactions are Frozen.', 'warning');
                document.getElementById('store').value = '';
            }
        },
        error: function() {
            showAlert('Error checking store status. Please try again.', 'error');
        }
    });
}

// Utility functions
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} fade-in`;
    alert.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : (type === 'warning' ? 'exclamation-triangle' : (type === 'error' ? 'exclamation-circle' : 'info-circle'))} alert-icon"></i>
        <span>${message}</span>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alert.parentElement) {
            alert.remove();
        }
    }, 5000);
}

function refreshPage() {
    if (confirm('Are you sure you want to refresh the page? All unsaved data will be lost.')) {
        window.location.reload();
    }
}

function exportToExcel() {
    if (allItems.length === 0) {
        showAlert('No items to export', 'warning');
        return;
    }
    
    // Create CSV content
    let csvContent = 'Medicine Name,Medicine Code,Cost Price,Quantity,Batch,Expiry Date\n';
    
    allItems.forEach(item => {
        csvContent += `"${item.medicineName}","${item.medicineCode}",${item.salesRate},${item.quantity},"${item.batch}","${item.expiryDate}"\n`;
    });
    
    // Create download link
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'opening_stock_entry.csv';
    a.click();
    window.URL.revokeObjectURL(url);
    
    showAlert('Data exported successfully!', 'success');
}

function resetForm() {
    if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
        clearAllItems();
        clearItemForm();
        
        if (locationSelect) locationSelect.value = '';
        if (storeSelect) storeSelect.value = '';
        
        showAlert('Form reset successfully!', 'success');
    }
}

// Handle form submission
function handleFormSubmit() {
    if (!validcheck()) {
        return false;
    }
    
    // Show loading state
    saveButton.disabled = true;
    saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    
    // Form will submit normally
    return true;
}

// Add CSS for slideOut animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(-100%);
        }
    }
    
    .alert-close {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        margin-left: auto;
        padding: 0;
        font-size: 1.1rem;
    }
    
    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    
    .btn-danger {
        background: #dc2626;
        color: white;
    }
    
    .btn-danger:hover {
        background: #b91c1c;
    }
`;
document.head.appendChild(style);












