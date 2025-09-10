// Bill Transaction Edit Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    setupSidebarToggle();
    setupFormValidation();
    setupBillSearch();
    setupLocationDependency();
    setupTransactionEdit();
});

// Sidebar Toggle Functionality
function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
}

// Form Validation
function setupFormValidation() {
    const form = document.querySelector('form[name="cbform1"]');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });
    }
}

function validateForm() {
    const searchbillnumber = document.getElementById('searchbillnumber');
    const location = document.getElementById('location');
    
    let isValid = true;
    clearErrors();
    
    // Validate bill number
    if (!searchbillnumber || !searchbillnumber.value.trim()) {
        showError(searchbillnumber, 'Please enter a bill number to search');
        isValid = false;
    }
    
    // Validate location
    if (!location || !location.value) {
        showError(location, 'Please select a location');
        isValid = false;
    }
    
    return isValid;
}

function showError(field, message) {
    if (!field) return;
    
    clearError(field);
    
    field.style.borderColor = '#dc3545';
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.style.color = '#dc3545';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

function clearError(field) {
    if (!field) return;
    
    field.style.borderColor = '';
    
    const existingError = field.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
}

function clearErrors() {
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(error => error.remove());
    
    const fields = document.querySelectorAll('.form-control, .search-input');
    fields.forEach(field => {
        field.style.borderColor = '';
    });
}

// Bill Search
function setupBillSearch() {
    const searchBtn = document.getElementById('searchBtn');
    const searchbillnumber = document.getElementById('searchbillnumber');
    
    if (searchBtn) {
        searchBtn.addEventListener('click', function() {
            searchBill();
        });
    }
    
    if (searchbillnumber) {
        searchbillnumber.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchBill();
            }
        });
    }
}

function searchBill() {
    const searchbillnumber = document.getElementById('searchbillnumber');
    const location = document.getElementById('location');
    
    if (!searchbillnumber || !searchbillnumber.value.trim()) {
        showError(searchbillnumber, 'Please enter a bill number');
        return;
    }
    
    if (!location || !location.value) {
        showError(location, 'Please select a location');
        return;
    }
    
    showLoading();
    
    // Submit the form to search for the bill
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.submit();
    }
}

// Location Dependency
function setupLocationDependency() {
    const locationSelect = document.getElementById('location');
    
    if (locationSelect) {
        locationSelect.addEventListener('change', function() {
            updateLocationDisplay(this.value);
        });
        
        // Initialize location display if pre-selected
        if (locationSelect.value) {
            updateLocationDisplay(locationSelect.value);
        }
    }
}

function updateLocationDisplay(locationCode) {
    const locationDisplay = document.getElementById('ajaxlocation');
    
    if (!locationDisplay || !locationCode) return;
    
    // Fetch location name via AJAX
    fetch(`ajax/ajaxgetlocationname.php?loccode=${locationCode}`)
        .then(response => response.text())
        .then(data => {
            locationDisplay.innerHTML = `<strong>Location:</strong> ${data}`;
        })
        .catch(error => {
            console.error('Error fetching location name:', error);
            locationDisplay.innerHTML = '<strong>Location:</strong> Selected';
        });
}

// Transaction Edit
function setupTransactionEdit() {
    // Setup edit buttons
    const editButtons = document.querySelectorAll('.edit-transaction-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const transactionId = this.dataset.transactionId;
            editTransaction(transactionId);
        });
    });
    
    // Setup save buttons
    const saveButtons = document.querySelectorAll('.save-transaction-btn');
    saveButtons.forEach(button => {
        button.addEventListener('click', function() {
            const transactionId = this.dataset.transactionId;
            saveTransaction(transactionId);
        });
    });
    
    // Setup cancel buttons
    const cancelButtons = document.querySelectorAll('.cancel-transaction-btn');
    cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
            const transactionId = this.dataset.transactionId;
            cancelEdit(transactionId);
        });
    });
}

function editTransaction(transactionId) {
    const row = document.querySelector(`tr[data-transaction-id="${transactionId}"]`);
    if (!row) return;
    
    // Make fields editable
    const fields = row.querySelectorAll('.transaction-field');
    fields.forEach(field => {
        if (field.tagName === 'INPUT' || field.tagName === 'SELECT') {
            field.disabled = false;
            field.classList.add('editing');
        } else {
            // Convert text to input
            const input = document.createElement('input');
            input.type = 'text';
            input.value = field.textContent;
            input.className = 'edit-form-control transaction-field editing';
            input.name = field.dataset.fieldName;
            field.parentNode.replaceChild(input, field);
        }
    });
    
    // Show save/cancel buttons
    const actionCell = row.querySelector('.action-cell');
    if (actionCell) {
        actionCell.innerHTML = `
            <button type="button" class="action-btn save save-transaction-btn" data-transaction-id="${transactionId}">
                <i class="fas fa-save"></i> Save
            </button>
            <button type="button" class="action-btn cancel cancel-transaction-btn" data-transaction-id="${transactionId}">
                <i class="fas fa-times"></i> Cancel
            </button>
        `;
    }
    
    // Re-setup event listeners
    setupTransactionEdit();
}

function saveTransaction(transactionId) {
    const row = document.querySelector(`tr[data-transaction-id="${transactionId}"]`);
    if (!row) return;
    
    // Collect form data
    const formData = new FormData();
    formData.append('transaction_id', transactionId);
    formData.append('action', 'update');
    
    const fields = row.querySelectorAll('.transaction-field.editing');
    fields.forEach(field => {
        if (field.name) {
            formData.append(field.name, field.value);
        }
    });
    
    showLoading();
    
    // Submit update
    fetch('ajax/ajaxupdatetransaction.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            showSuccess('Transaction updated successfully');
            // Refresh the page or update the row
            location.reload();
        } else {
            showError(null, data.message || 'Failed to update transaction');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error updating transaction:', error);
        showError(null, 'An error occurred while updating the transaction');
    });
}

function cancelEdit(transactionId) {
    const row = document.querySelector(`tr[data-transaction-id="${transactionId}"]`);
    if (!row) return;
    
    // Reload the page to reset changes
    location.reload();
}

// Utility Functions
function showLoading() {
    const loadingOverlay = document.createElement('div');
    loadingOverlay.id = 'loadingOverlay';
    loadingOverlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    `;
    
    const loadingContent = document.createElement('div');
    loadingContent.style.cssText = `
        background: white;
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    `;
    
    loadingContent.innerHTML = `
        <div class="loading-spinner"></div>
        <div>Processing...</div>
    `;
    
    loadingOverlay.appendChild(loadingContent);
    document.body.appendChild(loadingOverlay);
}

function hideLoading() {
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.remove();
    }
}

function showSuccess(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success';
    alertDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        z-index: 10000;
    `;
    alertDiv.textContent = message;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

function showError(field, message) {
    if (field) {
        clearError(field);
        field.style.borderColor = '#dc3545';
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.color = '#dc3545';
        errorDiv.style.fontSize = '0.875rem';
        errorDiv.style.marginTop = '0.25rem';
        errorDiv.textContent = message;
        
        field.parentNode.appendChild(errorDiv);
    } else if (message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger';
        alertDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #dc3545;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 10000;
        `;
        alertDiv.textContent = message;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
}

// Print Functionality
function printTransactions() {
    const sidebar = document.getElementById('leftSidebar');
    const btnGroup = document.querySelector('.btn-group');
    const actionButtons = document.querySelectorAll('.action-buttons');
    
    const originalSidebarDisplay = sidebar ? sidebar.style.display : '';
    const originalBtnGroupDisplay = btnGroup ? btnGroup.style.display : '';
    const originalActionDisplay = actionButtons.map(btn => btn.style.display);
    
    if (sidebar) sidebar.style.display = 'none';
    if (btnGroup) btnGroup.style.display = 'none';
    actionButtons.forEach(btn => btn.style.display = 'none');
    
    window.print();
    
    if (sidebar) sidebar.style.display = originalSidebarDisplay;
    if (btnGroup) btnGroup.style.display = originalBtnGroupDisplay;
    actionButtons.forEach((btn, index) => {
        btn.style.display = originalActionDisplay[index];
    });
}