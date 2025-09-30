// Doctor Statement Detail Summary - Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar functionality
    initializeSidebar();
    
    // Initialize form functionality
    initializeForms();
    
    // Initialize table functionality
    initializeTable();
    
    // Initialize responsive features
    initializeResponsive();
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
    // Auto-resize textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
    
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
}

// Table functionality
function initializeTable() {
    // Add sorting functionality to table headers
    const tableHeaders = document.querySelectorAll('.modern-table th');
    tableHeaders.forEach(header => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', function() {
            sortTable(this);
        });
    });
    
    // Add row highlighting
    const tableRows = document.querySelectorAll('.modern-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            // Remove active class from all rows
            tableRows.forEach(r => r.classList.remove('active'));
            // Add active class to clicked row
            this.classList.add('active');
        });
    });
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

// Form validation
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    const fieldType = field.type;
    let isValid = true;
    let errorMessage = '';
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'This field is required';
    }
    
    // Email validation
    if (fieldType === 'email' && value && !isValidEmail(value)) {
        isValid = false;
        errorMessage = 'Please enter a valid email address';
    }
    
    // Date validation
    if (fieldType === 'date' && value && !isValidDate(value)) {
        isValid = false;
        errorMessage = 'Please enter a valid date';
    }
    
    // Number validation
    if (fieldType === 'number' && value && isNaN(value)) {
        isValid = false;
        errorMessage = 'Please enter a valid number';
    }
    
    if (!isValid) {
        showFieldError(field, errorMessage);
    } else {
        clearFieldError(field);
    }
    
    return isValid;
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

// Utility functions
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidDate(dateString) {
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

// Table sorting
function sortTable(header) {
    const table = header.closest('table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const columnIndex = Array.from(header.parentNode.children).indexOf(header);
    const isAscending = header.classList.contains('sort-asc');
    
    // Clear all sort classes
    table.querySelectorAll('th').forEach(th => {
        th.classList.remove('sort-asc', 'sort-desc');
    });
    
    // Add appropriate sort class
    header.classList.add(isAscending ? 'sort-desc' : 'sort-asc');
    
    // Sort rows
    rows.sort((a, b) => {
        const aValue = a.children[columnIndex].textContent.trim();
        const bValue = b.children[columnIndex].textContent.trim();
        
        // Try to parse as numbers
        const aNum = parseFloat(aValue.replace(/[^0-9.-]/g, ''));
        const bNum = parseFloat(bValue.replace(/[^0-9.-]/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? bNum - aNum : aNum - bNum;
        }
        
        // Sort as strings
        return isAscending ? bValue.localeCompare(aValue) : aValue.localeCompare(bValue);
    });
    
    // Reorder rows in DOM
    rows.forEach(row => tbody.appendChild(row));
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
        }
    }
}

function exportToExcel() {
    // Create a simple CSV export
    const table = document.querySelector('.modern-table');
    if (!table) {
        alert('No data to export');
        return;
    }
    
    let csv = '';
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td');
        const rowData = Array.from(cells).map(cell => {
            return '"' + cell.textContent.replace(/"/g, '""') + '"';
        });
        csv += rowData.join(',') + '\n';
    });
    
    // Create and download file
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'doctor-statement-summary.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

// Print functionality
function printTable() {
    const printWindow = window.open('', '_blank');
    const table = document.querySelector('.modern-table');
    
    if (!table) {
        alert('No data to print');
        return;
    }
    
    const printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Doctor Statement Summary</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; font-weight: bold; }
                .header { text-align: center; margin-bottom: 20px; }
                .date { text-align: right; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Doctor Statement Detail Summary</h1>
            </div>
            <div class="date">
                Generated on: ${new Date().toLocaleDateString()}
            </div>
            ${table.outerHTML}
        </body>
        </html>
    `;
    
    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.print();
}

// Search functionality
function performSearch() {
    const searchInput = document.getElementById('searchsuppliername');
    const table = document.querySelector('.modern-table');
    
    if (!searchInput || !table) return;
    
    const searchTerm = searchInput.value.toLowerCase();
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Initialize search on input
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchsuppliername');
    if (searchInput) {
        searchInput.addEventListener('input', performSearch);
    }
});

// Loading overlay functionality
function showLoading(message = 'Loading...') {
    const overlay = document.createElement('div');
    overlay.id = 'loadingOverlay';
    overlay.style.cssText = `
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
    
    const content = document.createElement('div');
    content.style.cssText = `
        background: white;
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    `;
    
    content.innerHTML = `
        <div style="margin-bottom: 1rem;">
            <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #1e40af;"></i>
        </div>
        <p style="margin: 0; font-weight: 600;">${message}</p>
    `;
    
    overlay.appendChild(content);
    document.body.appendChild(overlay);
}

function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.remove();
    }
}

// Form submission with loading
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            showLoading('Processing request...');
        });
    });
});

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
    
    // Ctrl + P to print
    if (event.ctrlKey && event.key === 'p') {
        event.preventDefault();
        printTable();
    }
    
    // Escape to close sidebar on mobile
    if (event.key === 'Escape') {
        const sidebar = document.getElementById('leftSidebar');
        if (sidebar && window.innerWidth <= 768) {
            sidebar.classList.remove('open');
        }
    }
});

// Add CSS for sort indicators
const style = document.createElement('style');
style.textContent = `
    .modern-table th.sort-asc::after {
        content: ' ↑';
        color: #1e40af;
    }
    
    .modern-table th.sort-desc::after {
        content: ' ↓';
        color: #1e40af;
    }
    
    .modern-table tbody tr.active {
        background-color: #dbeafe !important;
        border-left: 3px solid #1e40af;
    }
    
    .form-input.error {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }
`;
document.head.appendChild(style);






