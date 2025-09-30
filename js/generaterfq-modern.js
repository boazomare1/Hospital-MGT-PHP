// Modern JavaScript for Generate RFQ Page

document.addEventListener('DOMContentLoaded', function() {
    // Initialize page
    initializePage();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize autocomplete if needed
    initializeAutocomplete();
});

function initializePage() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
    
    // Initialize sidebar
    initializeSidebar();
    
    // Initialize form validation
    initializeFormValidation();
}

function setupEventListeners() {
    // Menu toggle
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleSidebar);
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    // Form submission
    const form = document.querySelector('.rfq-form');
    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }
    
    // Select all checkbox
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', toggleAllCheckboxes);
    }
    
    // Individual checkboxes
    const checkboxes = document.querySelectorAll('.select-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectAllState);
    });
}

function initializeSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    // Check if sidebar should be collapsed on mobile
    if (window.innerWidth <= 768) {
        sidebar.classList.add('collapsed');
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed');
        }
    });
}

function toggleSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const icon = sidebarToggle.querySelector('i');
    
    sidebar.classList.toggle('collapsed');
    
    if (sidebar.classList.contains('collapsed')) {
        icon.className = 'fas fa-chevron-right';
    } else {
        icon.className = 'fas fa-chevron-left';
    }
}

function initializeFormValidation() {
    const form = document.querySelector('.rfq-form');
    if (!form) return;
    
    // Add real-time validation
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', clearFieldError);
    });
}

function validateField(event) {
    const field = event.target;
    const value = field.value.trim();
    
    // Remove existing error styling
    field.classList.remove('error');
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Validate based on field type
    let isValid = true;
    let errorMessage = '';
    
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'This field is required';
    }
    
    if (field.type === 'email' && value && !isValidEmail(value)) {
        isValid = false;
        errorMessage = 'Please enter a valid email address';
    }
    
    if (field.type === 'number' && value && isNaN(value)) {
        isValid = false;
        errorMessage = 'Please enter a valid number';
    }
    
    if (!isValid) {
        field.classList.add('error');
        showFieldError(field, errorMessage);
    }
    
    return isValid;
}

function clearFieldError(event) {
    const field = event.target;
    field.classList.remove('error');
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

function showFieldError(field, message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#e74c3c';
    errorDiv.style.fontSize = '0.85rem';
    errorDiv.style.marginTop = '0.25rem';
    
    field.parentNode.appendChild(errorDiv);
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function handleFormSubmit(event) {
    const form = event.target;
    const checkboxes = form.querySelectorAll('.select-checkbox:checked');
    
    if (checkboxes.length === 0) {
        event.preventDefault();
        showAlert('Please select at least one request to generate RFQ.', 'error');
        return false;
    }
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating RFQ...';
    }
    
    // Add confirmation dialog
    if (!confirm(`Are you sure you want to generate RFQ for ${checkboxes.length} selected request(s)?`)) {
        event.preventDefault();
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-file-invoice"></i> Generate RFQ';
        }
        return false;
    }
    
    return true;
}

function toggleAllCheckboxes() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.select-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    
    updateSelectAllState();
}

function updateSelectAllState() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.select-checkbox');
    const checkedCheckboxes = document.querySelectorAll('.select-checkbox:checked');
    
    if (checkedCheckboxes.length === 0) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = false;
    } else if (checkedCheckboxes.length === checkboxes.length) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = true;
    } else {
        selectAllCheckbox.indeterminate = true;
        selectAllCheckbox.checked = false;
    }
}

function initializeAutocomplete() {
    // Initialize autocomplete if the function exists
    if (typeof window.onload === 'function') {
        window.onload();
    }
    
    // Custom autocomplete initialization
    const searchInput = document.getElementById('searchcustomername');
    if (searchInput && typeof AutoSuggestControl !== 'undefined') {
        try {
            new AutoSuggestControl(searchInput, new StateSuggestions());
        } catch (error) {
            console.log('Autocomplete initialization failed:', error);
        }
    }
}

function refreshPage() {
    // Show loading indicator
    const refreshBtn = event.target;
    const originalContent = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';
    refreshBtn.disabled = true;
    
    // Reload page after short delay
    setTimeout(() => {
        window.location.reload();
    }, 500);
}

function exportToExcel() {
    // Show loading indicator
    const exportBtn = event.target;
    const originalContent = exportBtn.innerHTML;
    exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
    exportBtn.disabled = true;
    
    // Simulate export process
    setTimeout(() => {
        // Create a simple CSV export
        const table = document.querySelector('.data-table');
        if (table) {
            exportTableToCSV(table, 'rfq_requests.csv');
        }
        
        // Reset button
        exportBtn.innerHTML = originalContent;
        exportBtn.disabled = false;
        
        showAlert('Export completed successfully!', 'success');
    }, 1000);
}

function exportTableToCSV(table, filename) {
    const rows = table.querySelectorAll('tr');
    const csv = [];
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td');
        const rowData = [];
        
        cells.forEach(cell => {
            // Skip checkbox cells
            if (cell.querySelector('input[type="checkbox"]')) {
                return;
            }
            
            let cellText = cell.textContent.trim();
            // Escape quotes and wrap in quotes if contains comma
            if (cellText.includes(',') || cellText.includes('"')) {
                cellText = '"' + cellText.replace(/"/g, '""') + '"';
            }
            rowData.push(cellText);
        });
        
        if (rowData.length > 0) {
            csv.push(rowData.join(','));
        }
    });
    
    // Download CSV
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', filename);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

function resetForm() {
    const form = document.querySelector('.rfq-form');
    if (form) {
        form.reset();
        
        // Uncheck all checkboxes
        const checkboxes = form.querySelectorAll('.select-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        
        // Reset select all checkbox
        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
        }
        
        showAlert('Form has been reset.', 'info');
    }
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    
    const iconClass = type === 'success' ? 'check-circle' : 
                     type === 'error' ? 'exclamation-triangle' : 'info-circle';
    
    alert.innerHTML = `
        <i class="fas fa-${iconClass} alert-icon"></i>
        <span>${message}</span>
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }, 5000);
}

// Utility functions
function disableEnterKey(event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        return false;
    }
    return true;
}

function loadprintpage1(banum) {
    if (banum) {
        window.open(`print_bill1_op1.php?billautonumber=${banum}`, `Window${banum}`, 
                   'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
    }
}

function cbcustomername1() {
    const form = document.cbform1;
    if (form) {
        form.submit();
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(event) {
    // Ctrl + R to refresh
    if (event.ctrlKey && event.key === 'r') {
        event.preventDefault();
        refreshPage();
    }
    
    // Ctrl + E to export
    if (event.ctrlKey && event.key === 'e') {
        event.preventDefault();
        exportToExcel();
    }
    
    // Escape to close sidebar on mobile
    if (event.key === 'Escape') {
        const sidebar = document.getElementById('leftSidebar');
        if (sidebar && !sidebar.classList.contains('collapsed')) {
            toggleSidebar();
        }
    }
});

// Add smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add loading states to buttons
document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if (this.type === 'submit' || this.onclick) {
            this.style.opacity = '0.7';
            setTimeout(() => {
                this.style.opacity = '1';
            }, 1000);
        }
    });
});

// Initialize tooltips if Bootstrap is available
if (typeof bootstrap !== 'undefined') {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}


