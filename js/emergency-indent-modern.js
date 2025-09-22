/**
 * Emergency Indent Modern JavaScript
 * Handles interactive elements and form functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar functionality
    initializeSidebar();
    
    // Initialize form functionality
    initializeForm();
    
    // Initialize item entry functionality
    initializeItemEntry();
    
    // Initialize priority selection
    initializePriority();
    
    // Initialize currency functionality
    initializeCurrency();
    
    // Initialize validation
    initializeValidation();
    
    // Initialize autocomplete
    initializeAutocomplete();
});

// Sidebar functionality
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.remove('open');
        });
    }
    
    // Close sidebar when clicking outside
    document.addEventListener('click', function(e) {
        if (sidebar && !sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    });
}

// Form functionality
function initializeForm() {
    // Handle form submission
    const form = document.getElementById('emergencyIndentForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // Handle purchase type change
    const purchaseType = document.getElementById('purchasetype');
    if (purchaseType) {
        purchaseType.addEventListener('change', handlePurchaseTypeChange);
    }
    
    // Handle currency change
    const currency = document.getElementById('currency');
    if (currency) {
        currency.addEventListener('change', handleCurrencyChange);
    }
}

// Handle purchase type change
function handlePurchaseTypeChange() {
    const purchaseType = document.getElementById('purchasetype').value;
    const supplierSection = document.querySelector('.supplier-section');
    const medicineAutocomplete = document.getElementById('medicinename');
    const packSize = document.getElementById('packsize');
    const pkgQty = document.getElementById('pkgqty');
    const avlQty = document.getElementById('avlqty');
    const searchSupplierName = document.getElementById('searchsuppliername');
    const searchSupplierCode = document.getElementById('searchsuppliercode');
    
    if (purchaseType && purchaseType !== '' && 
        purchaseType !== 'non-medical' && purchaseType !== 'ASSETS' &&
        purchaseType !== 'Expenses' && purchaseType !== 'Others' &&
        purchaseType !== 'DRUGS' && purchaseType !== 'NON DRUGS') {
        
        // Medical items
        if (medicineAutocomplete) {
            medicineAutocomplete.disabled = false;
            medicineAutocomplete.style.pointerEvents = 'auto';
        }
        
        if (packSize) {
            packSize.disabled = false;
            packSize.value = '';
        }
        
        if (pkgQty) {
            pkgQty.disabled = false;
            pkgQty.value = '';
        }
        
        if (avlQty) {
            avlQty.disabled = false;
        }
        
        if (searchSupplierName) {
            searchSupplierName.disabled = true;
            searchSupplierName.value = '';
        }
        
        if (searchSupplierCode) {
            searchSupplierCode.disabled = true;
            searchSupplierCode.value = '';
        }
        
        if (supplierSection) {
            supplierSection.classList.remove('visible');
        }
        
    } else {
        // Non-medical items or assets
        if (purchaseType === 'non-medical' || purchaseType === 'ASSETS' || 
            purchaseType === 'DRUGS' || purchaseType === 'NON DRUGS') {
            
            if (medicineAutocomplete) {
                medicineAutocomplete.disabled = true;
                medicineAutocomplete.style.pointerEvents = 'none';
            }
        }
        
        if (packSize) {
            packSize.disabled = true;
            packSize.value = '1';
        }
        
        if (pkgQty) {
            pkgQty.disabled = true;
            pkgQty.value = '1';
        }
        
        if (avlQty) {
            avlQty.disabled = true;
        }
        
        if (searchSupplierName) {
            searchSupplierName.disabled = false;
            searchSupplierName.value = '';
        }
        
        if (searchSupplierCode) {
            searchSupplierCode.disabled = false;
            searchSupplierCode.value = '';
        }
        
        if (supplierSection) {
            supplierSection.classList.add('visible');
        }
    }
    
    // Reset item fields
    resetItemFields();
    
    // Reinitialize autocomplete
    initializeMedicineAutocomplete();
}

// Handle currency change
function handleCurrencyChange() {
    const currency = document.getElementById('currency');
    const fxAmount = document.getElementById('fxamount');
    
    if (currency && fxAmount) {
        const selectedValue = currency.value;
        if (selectedValue) {
            const parts = selectedValue.split(',');
            if (parts.length >= 2) {
                const rate = parts[0];
                const currencyCode = parts[1];
                fxAmount.value = rate;
            }
        }
    }
    
    // Update currency fix
    updateCurrencyFix();
}

// Item entry functionality
function initializeItemEntry() {
    // Handle add item button
    const addButton = document.getElementById('addItemBtn');
    if (addButton) {
        addButton.addEventListener('click', addItem);
    }
    
    // Handle item calculation
    const reqQty = document.getElementById('reqqty');
    const rate = document.getElementById('rate');
    
    if (reqQty) {
        reqQty.addEventListener('input', calculateAmount);
    }
    
    if (rate) {
        rate.addEventListener('input', calculateAmount);
    }
    
    // Initialize item serial number
    updateSerialNumber();
}

// Calculate amount
function calculateAmount() {
    const reqQty = parseFloat(document.getElementById('reqqty').value.replace(/[^0-9\.]+/g, "")) || 0;
    const rate = parseFloat(document.getElementById('rate').value.replace(/[^0-9\.]+/g, "")) || 0;
    const packSize = document.getElementById('packsize').value;
    const purchaseType = document.getElementById('purchasetype').value;
    const fxAmount = parseFloat(document.getElementById('fxamount').value) || 1;
    
    // Calculate amount
    const amount = reqQty * rate;
    document.getElementById('amount').value = formatMoney(amount.toFixed(2));
    
    // Calculate package quantity
    if (packSize && packSize !== '' && purchaseType && 
        purchaseType !== 'non-medical' && purchaseType !== 'ASSETS') {
        const packValue = parseFloat(packSize.substring(0, packSize.length - 1)) || 1;
        let pkgQty = reqQty / packValue;
        
        if (reqQty < packValue) {
            pkgQty = 1;
        }
        
        document.getElementById('pkgqty').value = Math.round(pkgQty);
    } else {
        document.getElementById('pkgqty').value = 1;
    }
    
    // Calculate FX rate
    const fxRate = rate * fxAmount;
    document.getElementById('fxrate').value = formatMoney(fxRate.toFixed(2));
    
    // Update total
    updateTotal();
}

// Add item to table
function addItem() {
    const medicineName = document.getElementById('medicinename').value.trim();
    const reqQty = document.getElementById('reqqty').value;
    const rate = document.getElementById('rate').value;
    const amount = document.getElementById('amount').value;
    
    if (!medicineName) {
        showAlert('Please enter item description', 'error');
        document.getElementById('medicinename').focus();
        return false;
    }
    
    if (!reqQty || reqQty === '0') {
        showAlert('Please enter required quantity', 'error');
        document.getElementById('reqqty').focus();
        return false;
    }
    
    if (!rate || rate === '0.00') {
        showAlert('Please enter rate', 'error');
        document.getElementById('rate').focus();
        return false;
    }
    
    const tableBody = document.getElementById('itemsTableBody');
    if (!tableBody) return;
    
    const serialNumber = tableBody.children.length + 1;
    const rowId = 'itemRow' + serialNumber;
    
    const row = document.createElement('tr');
    row.id = rowId;
    row.innerHTML = `
        <td>${serialNumber}</td>
        <td>${medicineName}</td>
        <td>${reqQty}</td>
        <td>${document.getElementById('packsize').value}</td>
        <td>${document.getElementById('pkgqty').value}</td>
        <td>${rate}</td>
        <td>${amount}</td>
        <td>
            <button type="button" class="item-delete-btn" onclick="deleteItem('${rowId}', ${parseFloat(amount.replace(/[^0-9\.]+/g, ""))})">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;
    
    tableBody.appendChild(row);
    
    // Add to form as hidden inputs
    addHiddenInputs(serialNumber, medicineName, reqQty, rate, amount);
    
    // Reset item fields
    resetItemFields();
    
    // Update serial number
    updateSerialNumber();
    
    // Show success message
    showAlert('Item added successfully', 'success');
}

// Add hidden inputs for form submission
function addHiddenInputs(serialNumber, medicineName, reqQty, rate, amount) {
    const form = document.getElementById('emergencyIndentForm');
    if (!form) return;
    
    // Create hidden inputs
    const medicineInput = document.createElement('input');
    medicineInput.type = 'hidden';
    medicineInput.name = 'medicinename' + serialNumber;
    medicineInput.value = medicineName;
    
    const qtyInput = document.createElement('input');
    qtyInput.type = 'hidden';
    qtyInput.name = 'reqqty' + serialNumber;
    qtyInput.value = reqQty.replace(/[^0-9\.]+/g, "");
    
    const rateInput = document.createElement('input');
    rateInput.type = 'hidden';
    rateInput.name = 'rate' + serialNumber;
    rateInput.value = rate.replace(/[^0-9\.]+/g, "");
    
    const amountInput = document.createElement('input');
    amountInput.type = 'hidden';
    amountInput.name = 'amount' + serialNumber;
    amountInput.value = amount.replace(/[^0-9\.]+/g, "");
    
    form.appendChild(medicineInput);
    form.appendChild(qtyInput);
    form.appendChild(rateInput);
    form.appendChild(amountInput);
}

// Delete item from table
function deleteItem(rowId, amount) {
    if (confirm('Are you sure you want to delete this item?')) {
        const row = document.getElementById(rowId);
        if (row) {
            row.remove();
            
            // Update serial numbers
            updateSerialNumbers();
            
            // Update total
            updateTotal();
            
            showAlert('Item deleted successfully', 'success');
        }
    }
}

// Update serial numbers in table
function updateSerialNumbers() {
    const tableBody = document.getElementById('itemsTableBody');
    if (!tableBody) return;
    
    const rows = tableBody.children;
    for (let i = 0; i < rows.length; i++) {
        rows[i].cells[0].textContent = i + 1;
        rows[i].id = 'itemRow' + (i + 1);
    }
}

// Reset item fields
function resetItemFields() {
    document.getElementById('medicinename').value = '';
    document.getElementById('medicinecode').value = '';
    document.getElementById('medicinenamel').value = '';
    document.getElementById('avlqty').value = '';
    document.getElementById('reqqty').value = '';
    document.getElementById('packsize').value = '';
    document.getElementById('pkgqty').value = '';
    document.getElementById('rate').value = '';
    document.getElementById('fxrate').value = '';
    document.getElementById('amount').value = '';
}

// Update serial number
function updateSerialNumber() {
    const tableBody = document.getElementById('itemsTableBody');
    const serialNumber = tableBody ? tableBody.children.length + 1 : 1;
    document.getElementById('serialnumber').value = serialNumber;
}

// Update total amount
function updateTotal() {
    const tableBody = document.getElementById('itemsTableBody');
    if (!tableBody) return;
    
    let total = 0;
    const rows = tableBody.children;
    
    for (let i = 0; i < rows.length; i++) {
        const amountCell = rows[i].cells[6]; // Amount column
        if (amountCell) {
            const amount = parseFloat(amountCell.textContent.replace(/[^0-9\.]+/g, "")) || 0;
            total += amount;
        }
    }
    
    document.getElementById('total').value = formatMoney(total.toFixed(2));
}

// Priority selection
function initializePriority() {
    const priorityRadios = document.querySelectorAll('input[name="priority"]');
    priorityRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove active class from all labels
            document.querySelectorAll('.priority-label').forEach(label => {
                label.classList.remove('active');
            });
            
            // Add active class to selected label
            const label = document.querySelector(`label[for="${this.id}"]`);
            if (label) {
                label.classList.add('active');
            }
        });
    });
}

// Currency functionality
function initializeCurrency() {
    updateCurrencyFix();
}

// Update currency fix
function updateCurrencyFix() {
    const tableBody = document.getElementById('itemsTableBody');
    const currency = document.getElementById('currency');
    
    if (tableBody && currency) {
        const hasItems = tableBody.children.length > 0;
        currency.disabled = hasItems;
    }
}

// Validation
function initializeValidation() {
    // Real-time validation
    const formInputs = document.querySelectorAll('.form-input, .form-select');
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
    });
}

// Validate individual field
function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.getAttribute('name') || field.getAttribute('id');
    
    // Remove existing error class
    field.classList.remove('error');
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        field.classList.add('error');
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Specific field validations
    if (fieldName === 'reqqty' && value) {
        const qty = parseFloat(value.replace(/[^0-9\.]+/g, ""));
        if (isNaN(qty) || qty <= 0) {
            field.classList.add('error');
            showFieldError(field, 'Please enter a valid quantity');
            return false;
        }
    }
    
    if (fieldName === 'rate' && value) {
        const rate = parseFloat(value.replace(/[^0-9\.]+/g, ""));
        if (isNaN(rate) || rate < 0) {
            field.classList.add('error');
            showFieldError(field, 'Please enter a valid rate');
            return false;
        }
    }
    
    return true;
}

// Show field error
function showFieldError(field, message) {
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Create error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.color = '#e74c3c';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

// Validate entire form
function validateForm() {
    let isValid = true;
    
    // Required fields validation
    const requiredFields = [
        { id: 'purchasetype', message: 'Please select purchase type' },
        { id: 'currency', message: 'Please select currency' },
        { id: 'remarks', message: 'Please enter memo/remarks' }
    ];
    
    requiredFields.forEach(field => {
        const element = document.getElementById(field.id);
        if (element && !element.value.trim()) {
            element.classList.add('error');
            showFieldError(element, field.message);
            isValid = false;
        }
    });
    
    // Check if at least one item is added
    const tableBody = document.getElementById('itemsTableBody');
    if (!tableBody || tableBody.children.length === 0) {
        showAlert('Please add at least one item', 'error');
        isValid = false;
    }
    
    // Check priority selection
    const prioritySelected = document.querySelector('input[name="priority"]:checked');
    if (!prioritySelected) {
        showAlert('Please select priority level', 'error');
        isValid = false;
    }
    
    // Check supplier for non-medical items
    const purchaseType = document.getElementById('purchasetype').value;
    if (purchaseType === 'non-medical' || purchaseType === 'ASSETS') {
        const supplierCode = document.getElementById('searchsuppliercode').value;
        if (!supplierCode) {
            showAlert('Please select supplier for non-medical items', 'error');
            document.getElementById('searchsuppliername').focus();
            isValid = false;
        }
    }
    
    return isValid;
}

// Autocomplete functionality
function initializeAutocomplete() {
    initializeSupplierAutocomplete();
    initializeMedicineAutocomplete();
}

// Supplier autocomplete
function initializeSupplierAutocomplete() {
    const supplierInput = document.getElementById('searchsuppliername');
    if (supplierInput && typeof $.fn.autocomplete !== 'undefined') {
        $(supplierInput).autocomplete({
            source: 'ajaxsuppliernewserach.php',
            select: function(event, ui) {
                const code = ui.item.id;
                const anum = ui.item.anum;
                $('#searchsuppliercode').val(code);
                $('#searchsupplieranum').val(anum);
            },
            open: function(event, ui) {
                $('#searchsuppliercode').val('');
            },
            html: true
        });
    }
}

// Medicine autocomplete
function initializeMedicineAutocomplete() {
    const medicineInput = document.getElementById('medicinename');
    const purchaseType = document.getElementById('purchasetype');
    
    if (medicineInput && purchaseType && typeof $.fn.autocomplete !== 'undefined') {
        const purchaseTypeValue = purchaseType.value || '';
        
        $(medicineInput).autocomplete({
            source: "ajax/ajaxmedicine.php?purchasetype=" + purchaseTypeValue,
            minLength: 2,
            select: function(event, ui) {
                $('#medicinecode').val(ui.item.itemcode);
                $('#medicinenamel').val(ui.item.value);
                loadMedicineDetails(ui.item.itemcode);
            },
            html: true
        });
        
        // Handle medicine name change
        $(medicineInput).keyup(function() {
            const currentValue = $(this).val().trim();
            const selectedValue = $('#medicinenamel').val().trim();
            
            if (currentValue !== selectedValue) {
                $('#medicinecode').val('');
                $('#rate').val('');
                $('#fxrate').val('');
                $('#amount').val('');
                $('#packsize').val('');
                $('#avlqty').val('');
            }
        });
    }
}

// Load medicine details
function loadMedicineDetails(medicineCode) {
    if (!medicineCode) return;
    
    // Make AJAX request to get medicine details
    fetch(`ajax/get_medicine_details.php?code=${encodeURIComponent(medicineCode)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('packsize').value = data.packsize || '';
                document.getElementById('rate').value = data.rate ? formatMoney(data.rate) : '';
                document.getElementById('avlqty').value = data.avlqty || '';
                
                // Calculate amount if quantity is entered
                const reqQty = document.getElementById('reqqty').value;
                if (reqQty) {
                    calculateAmount();
                }
            }
        })
        .catch(error => {
            console.error('Error loading medicine details:', error);
        });
}

// Utility functions
function formatMoney(number, places, thousand, decimal) {
    number = number || 0;
    places = !isNaN(places = Math.abs(places)) ? places : 2;
    
    thousand = thousand || ",";
    decimal = decimal || ".";
    var negative = number < 0 ? "-" : "",
        i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} fade-in`;
    alertDiv.innerHTML = `
        <i class="fas fa-${getAlertIcon(type)} alert-icon"></i>
        <span>${message}</span>
    `;
    
    alertContainer.appendChild(alertDiv);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Get alert icon
function getAlertIcon(type) {
    const icons = {
        success: 'check-circle',
        error: 'exclamation-triangle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Refresh page
function refreshPage() {
    if (confirm('Are you sure you want to refresh the page? All unsaved data will be lost.')) {
        window.location.reload();
    }
}

// Export to Excel
function exportToExcel() {
    // Implementation for Excel export
    showAlert('Excel export functionality will be implemented', 'info');
}

// Reset form
function resetForm() {
    if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
        document.getElementById('emergencyIndentForm').reset();
        
        // Clear items table
        const tableBody = document.getElementById('itemsTableBody');
        if (tableBody) {
            tableBody.innerHTML = '';
        }
        
        // Reset item fields
        resetItemFields();
        
        // Update total
        updateTotal();
        
        showAlert('Form reset successfully', 'success');
    }
}

// Global functions for backward compatibility
window.deleteItem = deleteItem;
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;
window.resetForm = resetForm;

