// Doctor Wise Revenue Report - Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar functionality
    initializeSidebar();
    
    // Initialize form functionality
    initializeForms();
    
    // Initialize responsive features
    initializeResponsive();
    
    // Initialize table functionality
    initializeTable();
    
    // Initialize date pickers
    initializeDatePickers();
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
            sidebar.classList.toggle('collapsed');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
}

// Form functionality
function initializeForms() {
    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!validateForm(this)) {
                event.preventDefault();
            }
        });
    });
    
    // Real-time form validation
    const inputs = document.querySelectorAll('.form-input');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
    
    // Date range validation
    const dateFromInput = document.getElementById('ADate1');
    const dateToInput = document.getElementById('ADate2');
    
    if (dateFromInput && dateToInput) {
        dateFromInput.addEventListener('change', function() {
            validateDateRange();
        });
        
        dateToInput.addEventListener('change', function() {
            validateDateRange();
        });
    }
}

// Form validation
function validateForm(form) {
    let isValid = true;
    const dateFromInput = document.getElementById('ADate1');
    const dateToInput = document.getElementById('ADate2');
    
    // Check if date from is provided
    if (!dateFromInput.value.trim()) {
        showFieldError(dateFromInput, 'Please select a start date');
        isValid = false;
    }
    
    // Check if date to is provided
    if (!dateToInput.value.trim()) {
        showFieldError(dateToInput, 'Please select an end date');
        isValid = false;
    }
    
    // Validate date range
    if (dateFromInput.value && dateToInput.value) {
        const dateFrom = new Date(dateFromInput.value);
        const dateTo = new Date(dateToInput.value);
        
        if (dateFrom > dateTo) {
            showFieldError(dateToInput, 'End date must be after start date');
            isValid = false;
        }
        
        // Check if date range is not too large (e.g., more than 1 year)
        const diffTime = Math.abs(dateTo - dateFrom);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays > 365) {
            showFieldError(dateToInput, 'Date range cannot exceed 1 year');
            isValid = false;
        }
    }
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'This field is required';
    }
    
    // Date validation
    if (field.type === 'date' && value) {
        const selectedDate = new Date(value);
        const today = new Date();
        
        if (selectedDate > today) {
            isValid = false;
            errorMessage = 'Date cannot be in the future';
        }
    }
    
    if (!isValid) {
        showFieldError(field, errorMessage);
    } else {
        clearFieldError(field);
    }
    
    return isValid;
}

function validateDateRange() {
    const dateFromInput = document.getElementById('ADate1');
    const dateToInput = document.getElementById('ADate2');
    
    if (dateFromInput.value && dateToInput.value) {
        const dateFrom = new Date(dateFromInput.value);
        const dateTo = new Date(dateToInput.value);
        
        if (dateFrom > dateTo) {
            showFieldError(dateToInput, 'End date must be after start date');
        } else {
            clearFieldError(dateToInput);
        }
    }
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#dc2626';
    errorDiv.style.fontSize = '0.8rem';
    errorDiv.style.marginTop = '0.25rem';
    
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('error');
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// Responsive functionality
function initializeResponsive() {
    // Handle window resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('leftSidebar');
        if (window.innerWidth > 768) {
            sidebar.classList.remove('open');
        }
    });
    
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('menuToggle');
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            const sidebar = document.getElementById('leftSidebar');
            sidebar.classList.toggle('open');
        });
    }
}

// Table functionality
function initializeTable() {
    const table = document.querySelector('.modern-table');
    if (!table) return;
    
    // Add sorting functionality
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        // Skip first column (No.) and text columns
        if (index === 0 || index === 1 || index === 2) return;
        
        header.style.cursor = 'pointer';
        header.addEventListener('click', function() {
            sortTable(table, index);
        });
        
        // Add sort indicator
        const sortIcon = document.createElement('i');
        sortIcon.className = 'fas fa-sort sort-icon';
        sortIcon.style.marginLeft = '0.5rem';
        sortIcon.style.opacity = '0.5';
        header.appendChild(sortIcon);
    });
    
    // Add row highlighting
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const header = table.querySelectorAll('th')[columnIndex];
    const sortIcon = header.querySelector('.sort-icon');
    
    // Determine sort direction
    const isAscending = !header.classList.contains('sort-asc');
    
    // Clear all sort classes
    table.querySelectorAll('th').forEach(th => {
        th.classList.remove('sort-asc', 'sort-desc');
        const icon = th.querySelector('.sort-icon');
        if (icon) {
            icon.className = 'fas fa-sort sort-icon';
            icon.style.opacity = '0.5';
        }
    });
    
    // Set current sort direction
    header.classList.add(isAscending ? 'sort-asc' : 'sort-desc');
    sortIcon.className = isAscending ? 'fas fa-sort-up sort-icon' : 'fas fa-sort-down sort-icon';
    sortIcon.style.opacity = '1';
    
    // Sort rows
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();
        
        // Handle numeric values
        const aNum = parseFloat(aValue.replace(/[^\d.-]/g, ''));
        const bNum = parseFloat(bValue.replace(/[^\d.-]/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? aNum - bNum : bNum - aNum;
        }
        
        // Handle text values
        return isAscending ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
    });
    
    // Reorder rows in table
    rows.forEach(row => tbody.appendChild(row));
}

// Date picker functionality
function initializeDatePickers() {
    // Set default date range if not already set
    const dateFromInput = document.getElementById('ADate1');
    const dateToInput = document.getElementById('ADate2');
    
    if (dateFromInput && !dateFromInput.value) {
        const oneMonthAgo = new Date();
        oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
        dateFromInput.value = oneMonthAgo.toISOString().split('T')[0];
    }
    
    if (dateToInput && !dateToInput.value) {
        const today = new Date();
        dateToInput.value = today.toISOString().split('T')[0];
    }
    
    // Add date picker enhancements
    const dateInputs = document.querySelectorAll('.date-input');
    dateInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = 'var(--medstar-primary)';
        });
        
        input.addEventListener('blur', function() {
            this.style.borderColor = 'var(--border-color)';
        });
    });
}

// Global functions for form actions
function refreshPage() {
    if (confirm('Are you sure you want to refresh the page? Any unsaved changes will be lost.')) {
        window.location.reload();
    }
}

function resetForm() {
    if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
        const form = document.querySelector('form');
        if (form) {
            form.reset();
            // Clear any error states
            const errorFields = form.querySelectorAll('.error');
            errorFields.forEach(field => clearFieldError(field));
            
            // Reset to default date range
            const dateFromInput = document.getElementById('ADate1');
            const dateToInput = document.getElementById('ADate2');
            
            if (dateFromInput) {
                const oneMonthAgo = new Date();
                oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
                dateFromInput.value = oneMonthAgo.toISOString().split('T')[0];
            }
            
            if (dateToInput) {
                const today = new Date();
                dateToInput.value = today.toISOString().split('T')[0];
            }
        }
    }
}

function exportToExcel() {
    // This would typically trigger the server-side Excel export
    // For now, we'll show a message
    const dateFromInput = document.getElementById('ADate1');
    const dateToInput = document.getElementById('ADate2');
    
    if (!dateFromInput.value || !dateToInput.value) {
        alert('Please select date range before exporting to Excel.');
        return;
    }
    
    // Show loading state
    const exportBtn = document.querySelector('[onclick="exportToExcel()"]');
    if (exportBtn) {
        const originalText = exportBtn.innerHTML;
        exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
        exportBtn.disabled = true;
        
        // Reset after 2 seconds
        setTimeout(() => {
            exportBtn.innerHTML = originalText;
            exportBtn.disabled = false;
        }, 2000);
    }
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Keyboard shortcuts
document.addEventListener('keydown', function(event) {
    // Ctrl + R to refresh
    if (event.ctrlKey && event.key === 'r') {
        event.preventDefault();
        refreshPage();
    }
    
    // Escape to close sidebar on mobile
    if (event.key === 'Escape') {
        const sidebar = document.getElementById('leftSidebar');
        if (sidebar && window.innerWidth <= 768) {
            sidebar.classList.remove('open');
        }
    }
    
    // Ctrl + E to export
    if (event.ctrlKey && event.key === 'e') {
        event.preventDefault();
        exportToExcel();
    }
    
    // Enter to submit form when focused on date inputs
    if (event.key === 'Enter') {
        const activeElement = document.activeElement;
        if (activeElement && activeElement.classList.contains('date-input')) {
            const form = document.querySelector('form');
            if (form) {
                form.submit();
            }
        }
    }
});

// Add CSS for enhanced styling
const style = document.createElement('style');
style.textContent = `
    .form-input.error {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }
    
    .sort-icon {
        transition: all 0.3s ease;
    }
    
    .modern-table th.sort-asc {
        background: linear-gradient(135deg, var(--medstar-primary) 0%, var(--medstar-primary-light) 100%);
        color: white;
    }
    
    .modern-table th.sort-desc {
        background: linear-gradient(135deg, var(--medstar-primary-light) 0%, var(--medstar-primary) 100%);
        color: white;
    }
    
    .modern-table tbody tr {
        transition: all 0.3s ease;
    }
    
    .modern-table tbody tr:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .walkins-row {
        border-left: 4px solid var(--medstar-accent) !important;
    }
    
    .totals-row {
        position: sticky;
        bottom: 0;
        z-index: 5;
    }
    
    .field-error {
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }
    
    .loading-overlay {
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
    }
    
    .loading-content {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .loading-spinner {
        margin-bottom: 1rem;
    }
    
    .loading-spinner i {
        font-size: 2rem;
        color: var(--medstar-primary);
    }
`;
document.head.appendChild(style);

// Utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatNumber(number) {
    return new Intl.NumberFormat('en-US').format(number);
}

function formatPercentage(value) {
    return new Intl.NumberFormat('en-US', {
        style: 'percent',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(value / 100);
}

// Export functions for global access
window.refreshPage = refreshPage;
window.resetForm = resetForm;
window.exportToExcel = exportToExcel;





