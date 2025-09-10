// Modern JavaScript for costcenter.php

document.addEventListener('DOMContentLoaded', function() {
    initializeCostCenter();
});

function initializeCostCenter() {
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize table functionality
    initializeTableFeatures();
    
    // Initialize search functionality
    initializeSearch();
    
    // Initialize modal functionality
    initializeModals();
    
    // Initialize CRUD operations
    initializeCRUDOperations();
    
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
    
    // Validate required fields
    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        if (!validateField({ target: field })) {
            isValid = false;
        }
    });
    
    // Validate cost center code format
    const codeField = form.querySelector('input[name="costcentercode"]');
    if (codeField && codeField.value) {
        if (!/^[A-Z0-9]{2,10}$/.test(codeField.value)) {
            showFieldError(codeField, 'Cost center code must be 2-10 uppercase letters/numbers');
            isValid = false;
        }
    }
    
    // Validate cost center name
    const nameField = form.querySelector('input[name="costcentername"]');
    if (nameField && nameField.value) {
        if (nameField.value.length < 3) {
            showFieldError(nameField, 'Cost center name must be at least 3 characters');
            isValid = false;
        }
    }
    
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
    
    // Email validation
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            showFieldError(field, 'Please enter a valid email address');
            return false;
        }
    }
    
    // Number validation
    if (field.type === 'number' && value) {
        if (isNaN(value) || parseFloat(value) < 0) {
            showFieldError(field, 'Please enter a valid positive number');
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

function initializeTableFeatures() {
    const tables = document.querySelectorAll('.modern-table');
    tables.forEach(table => {
        // Add sort functionality
        addTableSorting(table);
        
        // Add search functionality
        addTableSearch(table);
        
        // Add row selection
        addRowSelection(table);
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
        
        // Try to parse as numbers
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

function addRowSelection(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('click', function(e) {
            // Don't select if clicking on buttons or links
            if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A') {
                return;
            }
            
            // Toggle selection
            this.classList.toggle('selected');
        });
    });
}

function initializeSearch() {
    const searchForm = document.querySelector('form[name="searchform"]');
    if (!searchForm) return;
    
    const searchInput = searchForm.querySelector('input[name="search"]');
    if (searchInput) {
        // Add debounced search
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(this.value);
            }, 300);
        });
    }
}

function performSearch(searchTerm) {
    // Implement AJAX search if needed
    console.log('Searching for:', searchTerm);
}

function initializeModals() {
    // Initialize edit modal
    const editModal = document.getElementById('editModal');
    if (editModal) {
        const closeBtn = editModal.querySelector('.close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => closeModal(editModal));
        }
        
        // Close modal when clicking outside
        editModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this);
            }
        });
    }
    
    // Initialize delete confirmation modal
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        const closeBtn = deleteModal.querySelector('.close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => closeModal(deleteModal));
        }
    }
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modal) {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

function initializeCRUDOperations() {
    // Initialize edit buttons
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const costCenterId = this.getAttribute('data-id');
            openEditModal(costCenterId);
        });
    });
    
    // Initialize delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const costCenterId = this.getAttribute('data-id');
            const costCenterName = this.getAttribute('data-name');
            openDeleteModal(costCenterId, costCenterName);
        });
    });
}

function openEditModal(costCenterId) {
    // Fetch cost center data and populate edit form
    fetchCostCenterData(costCenterId)
        .then(data => {
            populateEditForm(data);
            openModal('editModal');
        })
        .catch(error => {
            showNotification('Error loading cost center data', 'error');
        });
}

function fetchCostCenterData(id) {
    // Implement AJAX call to fetch cost center data
    return new Promise((resolve, reject) => {
        // This would typically be an AJAX call
        // For now, we'll simulate it
        setTimeout(() => {
            resolve({
                id: id,
                code: 'CC001',
                name: 'Sample Cost Center',
                description: 'Sample description'
            });
        }, 500);
    });
}

function populateEditForm(data) {
    const form = document.querySelector('#editModal form');
    if (form) {
        form.querySelector('input[name="costcentercode"]').value = data.code || '';
        form.querySelector('input[name="costcentername"]').value = data.name || '';
        form.querySelector('textarea[name="description"]').value = data.description || '';
    }
}

function openDeleteModal(costCenterId, costCenterName) {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        const confirmBtn = modal.querySelector('.confirm-delete');
        const nameSpan = modal.querySelector('.cost-center-name');
        
        if (nameSpan) {
            nameSpan.textContent = costCenterName;
        }
        
        if (confirmBtn) {
            confirmBtn.onclick = () => deleteCostCenter(costCenterId);
        }
        
        openModal('deleteModal');
    }
}

function deleteCostCenter(id) {
    // Show loading state
    showLoadingState();
    
    // Implement AJAX delete
    fetch(`costcenter.php?action=delete&id=${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}&action=delete`
    })
    .then(response => response.json())
    .then(data => {
        hideLoadingState();
        if (data.success) {
            showNotification('Cost center deleted successfully', 'success');
            closeModal(document.getElementById('deleteModal'));
            // Refresh the page or update the table
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message || 'Error deleting cost center', 'error');
        }
    })
    .catch(error => {
        hideLoadingState();
        showNotification('Error deleting cost center', 'error');
    });
}

function addLoadingStates() {
    // Add loading states to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.type === 'submit') {
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

function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    .sort-indicator {
        font-size: 0.8em;
        color: #7f8c8d;
        margin-left: 0.5rem;
    }
    
    .selected {
        background-color: #e3f2fd !important;
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
`;
document.head.appendChild(style);
