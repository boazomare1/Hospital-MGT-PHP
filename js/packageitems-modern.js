// Package Items Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize elements
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');

    // Sidebar toggle functionality
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    // Form validation
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }

    // Initialize package items functionality
    initializePackageItems();
});

function validateForm() {
    // Add form validation logic here
    const requiredFields = document.querySelectorAll('[required]');
    for (let field of requiredFields) {
        if (!field.value.trim()) {
            showAlert(`Please fill in ${field.previousElementSibling.textContent}`, 'error');
            field.focus();
            return false;
        }
    }
    
    // Validate package selection
    const packageSelect = document.getElementById('packageid');
    if (packageSelect && !packageSelect.value) {
        showAlert('Please select a package', 'error');
        packageSelect.focus();
        return false;
    }
    
    return true;
}

function initializePackageItems() {
    // Initialize package items functionality
    const packageSelect = document.getElementById('packageid');
    if (packageSelect) {
        packageSelect.addEventListener('change', function() {
            loadPackageItems(this.value);
        });
    }
    
    // Initialize item management
    initializeItemManagement();
}

function loadPackageItems(packageId) {
    // Load items for selected package
    if (!packageId) {
        clearPackageItems();
        return;
    }
    
    console.log('Loading items for package:', packageId);
    showAlert('Loading package items...', 'info');
    
    // Here you would typically make an AJAX call to load package items
    // For now, we'll simulate loading
    setTimeout(() => {
        showAlert('Package items loaded successfully', 'success');
    }, 1000);
}

function clearPackageItems() {
    // Clear package items display
    const itemsContainer = document.getElementById('packageItemsContainer');
    if (itemsContainer) {
        itemsContainer.innerHTML = '<p>No package selected</p>';
    }
}

function initializeItemManagement() {
    // Initialize item management functionality
    const addItemBtn = document.getElementById('addItemBtn');
    if (addItemBtn) {
        addItemBtn.addEventListener('click', addNewItem);
    }
    
    // Initialize existing item rows
    const itemRows = document.querySelectorAll('.item-row');
    itemRows.forEach(row => {
        initializeItemRow(row);
    });
}

function initializeItemRow(row) {
    // Initialize individual item row
    const qtyInput = row.querySelector('input[name*="serqty"]');
    const rateInput = row.querySelector('input[name*="serrate"]');
    const amountInput = row.querySelector('input[name*="seramt"]');
    const removeBtn = row.querySelector('.remove-item-btn');
    
    if (qtyInput && rateInput && amountInput) {
        // Calculate amount when qty or rate changes
        const calculateAmount = () => {
            const qty = parseFloat(qtyInput.value) || 0;
            const rate = parseFloat(rateInput.value) || 0;
            const amount = qty * rate;
            amountInput.value = amount.toFixed(2);
            updatePackageTotal();
        };
        
        qtyInput.addEventListener('input', calculateAmount);
        rateInput.addEventListener('input', calculateAmount);
    }
    
    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            removeItem(row);
        });
    }
}

function addNewItem() {
    // Add new item row
    const itemsContainer = document.getElementById('itemsContainer');
    if (!itemsContainer) return;
    
    const itemRow = document.createElement('div');
    itemRow.className = 'item-row';
    itemRow.innerHTML = `
        <div class="form-group">
            <label>Service Name</label>
            <input type="text" name="sername" class="form-control" placeholder="Enter service name" required>
        </div>
        <div class="form-group">
            <label>Service Code</label>
            <input type="text" name="sercode" class="form-control" placeholder="Enter service code">
        </div>
        <div class="form-group">
            <label>Rate</label>
            <input type="number" name="serrate" class="form-control" placeholder="0.00" step="0.01">
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="serqty" class="form-control" placeholder="1" min="1">
        </div>
        <div class="form-group">
            <label>Amount</label>
            <input type="number" name="seramt" class="form-control" placeholder="0.00" step="0.01" readonly>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-outline remove-item-btn">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    
    itemsContainer.appendChild(itemRow);
    initializeItemRow(itemRow);
    
    // Update serial numbers
    updateSerialNumbers();
}

function removeItem(row) {
    // Remove item row
    row.remove();
    updateSerialNumbers();
    updatePackageTotal();
}

function updateSerialNumbers() {
    // Update serial numbers for all items
    const itemRows = document.querySelectorAll('.item-row');
    itemRows.forEach((row, index) => {
        const inputs = row.querySelectorAll('input[name*="sername"], input[name*="sercode"], input[name*="serrate"], input[name*="serqty"], input[name*="seramt"]');
        inputs.forEach(input => {
            const name = input.name;
            if (name.includes('sername') || name.includes('sercode') || name.includes('serrate') || name.includes('serqty') || name.includes('seramt')) {
                input.name = name.replace(/\d+$/, '') + (index + 1);
            }
        });
    });
    
    // Update hidden serial number field
    const serialInput = document.getElementById('serialnumbers');
    if (serialInput) {
        serialInput.value = itemRows.length;
    }
}

function updatePackageTotal() {
    // Update package total amount
    const amountInputs = document.querySelectorAll('input[name*="seramt"]');
    let total = 0;
    
    amountInputs.forEach(input => {
        const amount = parseFloat(input.value) || 0;
        total += amount;
    });
    
    const totalElement = document.getElementById('packageTotal');
    if (totalElement) {
        totalElement.textContent = total.toFixed(2);
    }
}

function savePackageItems() {
    // Save package items
    const packageId = document.getElementById('packageid').value;
    if (!packageId) {
        showAlert('Please select a package', 'error');
        return;
    }
    
    console.log('Saving package items for package:', packageId);
    showAlert('Saving package items...', 'info');
    
    // Here you would typically submit the form or make an AJAX call
    // document.querySelector('form[name="cbform1"]').submit();
}

function previewPackageItems() {
    // Preview package items
    const packageId = document.getElementById('packageid').value;
    if (!packageId) {
        showAlert('Please select a package', 'error');
        return;
    }
    
    console.log('Previewing package items for package:', packageId);
    showAlert('Generating preview...', 'info');
}

function exportPackageItems() {
    // Export package items
    const table = document.querySelector('.package-items-table');
    if (table) {
        // Create CSV content
        let csv = [];
        const rows = table.querySelectorAll('tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('th, td');
            const rowData = Array.from(cells).map(cell => cell.textContent.trim());
            csv.push(rowData.join(','));
        });
        
        // Download CSV
        const csvContent = csv.join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'package_items.csv';
        a.click();
        window.URL.revokeObjectURL(url);
    }
}

function clearAllItems() {
    // Clear all items
    const itemsContainer = document.getElementById('itemsContainer');
    if (itemsContainer) {
        itemsContainer.innerHTML = '';
        updateSerialNumbers();
        updatePackageTotal();
        showAlert('All items cleared', 'info');
    }
}

// Utility functions
function showAlert(message, type = 'info') {
    const alertContainer = document.querySelector('.alert-container');
    if (alertContainer) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} alert-icon"></i>
            ${message}
        `;
        alertContainer.appendChild(alert);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
}

// Export functions for global access
window.showAlert = showAlert;
window.addNewItem = addNewItem;
window.removeItem = removeItem;
window.savePackageItems = savePackageItems;
window.previewPackageItems = previewPackageItems;
window.exportPackageItems = exportPackageItems;
window.clearAllItems = clearAllItems;
