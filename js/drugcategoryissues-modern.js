// Drug Category Issues Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initializeSidebar();
    initializeFormValidation();
    initializeDataTable();
    initializeDatePickers();
    initializeSearch();
});

// Sidebar functionality - matches vat.php behavior
function initializeSidebar() {
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

// Form validation
function initializeFormValidation() {
    const form = document.querySelector('.search-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        const dateFrom = document.getElementById('ADate1');
        const dateTo = document.getElementById('ADate2');
        
        // Validate date range
        if (dateFrom.value && dateTo.value) {
            const fromDate = new Date(dateFrom.value);
            const toDate = new Date(dateTo.value);
            
            if (fromDate > toDate) {
                e.preventDefault();
                showAlert('Date From cannot be greater than Date To', 'error');
                dateFrom.focus();
                return false;
            }
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
            submitBtn.disabled = true;
        }
    });
}

// Data table functionality
function initializeDataTable() {
    const tables = document.querySelectorAll('.data-table');
    
    tables.forEach(table => {
        // Add hover effects
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    });
}

// Date picker initialization
function initializeDatePickers() {
    // Set default dates if not already set
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
    if (dateFrom && !dateFrom.value) {
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), 0, 1);
        dateFrom.value = firstDay.toISOString().split('T')[0];
    }
    
    if (dateTo && !dateTo.value) {
        const today = new Date();
        dateTo.value = today.toISOString().split('T')[0];
    }
}

// Search functionality
function initializeSearch() {
    const searchInput = document.querySelector('input[name="itemname"]');
    if (!searchInput) return;

    // Add search suggestions
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length >= 2) {
            // Implement autocomplete functionality here
            // This would typically make an AJAX call to get suggestions
        }
    });

    // Clear search
    const resetBtn = document.querySelector('button[type="reset"]');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            setTimeout(() => {
                clearSearch();
            }, 100);
        });
    }
}

// Utility functions
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;

    const alertClass = type === 'error' ? 'alert-error' : 
                      type === 'success' ? 'alert-success' : 'alert-info';
    
    const iconClass = type === 'error' ? 'exclamation-triangle' : 
                     type === 'success' ? 'check-circle' : 'info-circle';

    const alert = document.createElement('div');
    alert.className = `alert ${alertClass}`;
    alert.innerHTML = `
        <i class="fas fa-${iconClass} alert-icon"></i>
        <span>${message}</span>
    `;

    alertContainer.innerHTML = '';
    alertContainer.appendChild(alert);

    // Auto-hide after 5 seconds
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => {
            if (alert.parentNode) {
                alert.parentNode.removeChild(alert);
            }
        }, 300);
    }, 5000);
}

function clearSearch() {
    const form = document.querySelector('.search-form');
    if (form) {
        form.reset();
        // Reset date fields to defaults
        const dateFrom = document.getElementById('ADate1');
        const dateTo = document.getElementById('ADate2');
        
        if (dateFrom) {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), 0, 1);
            dateFrom.value = firstDay.toISOString().split('T')[0];
        }
        
        if (dateTo) {
            const today = new Date();
            dateTo.value = today.toISOString().split('T')[0];
        }
    }
}

function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    const tables = document.querySelectorAll('.data-table');
    if (tables.length === 0) {
        showAlert('No data to export', 'error');
        return;
    }

    let csv = [];
    
    tables.forEach(table => {
        const rows = Array.from(table.querySelectorAll('tr'));
        rows.forEach(row => {
            const cells = Array.from(row.querySelectorAll('th, td'));
            const rowData = cells.map(cell => {
                const text = cell.textContent.trim();
                // Escape quotes and wrap in quotes
                return `"${text.replace(/"/g, '""')}"`;
            }).join(',');
            csv.push(rowData);
        });
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'drug_category_issues.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
        
        showAlert('Data exported successfully', 'success');
    } else {
        showAlert('Export not supported in this browser', 'error');
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + R to refresh
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        refreshPage();
    }
    
    // Escape to close sidebar
    if (e.key === 'Escape') {
        const sidebar = document.getElementById('leftSidebar');
        if (sidebar && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
            document.querySelector('.sidebar-overlay').classList.remove('show');
            document.body.style.overflow = '';
        }
    }
});

// Print functionality
function printResults() {
    const printContent = document.querySelector('.results-section');
    if (!printContent) {
        showAlert('No results to print', 'error');
        return;
    }

    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Drug Category Issues Report</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; font-weight: bold; }
                    .category-header { background-color: #e3f2fd; padding: 10px; margin-bottom: 10px; }
                    .total-row { background-color: #f0f0f0; font-weight: bold; }
                </style>
            </head>
            <body>
                <h1>Drug Category Issues Report</h1>
                <p>Generated on: ${new Date().toLocaleString()}</p>
                ${printContent.innerHTML}
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

// Smooth scrolling for better UX
function smoothScrollTo(element) {
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Initialize tooltips if needed
function initializeTooltips() {
    const tooltipElements = document.querySelectorAll('[title]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            // Add custom tooltip functionality if needed
        });
    });
}

// Form auto-save functionality
function initializeAutoSave() {
    const form = document.querySelector('.search-form');
    if (!form) return;

    const formData = JSON.parse(localStorage.getItem('drugCategoryFormData') || '{}');
    
    // Restore form data
    Object.keys(formData).forEach(key => {
        const element = form.querySelector(`[name="${key}"]`);
        if (element) {
            element.value = formData[key];
        }
    });

    // Save form data on change
    form.addEventListener('input', function(e) {
        if (e.target.name) {
            const currentData = JSON.parse(localStorage.getItem('drugCategoryFormData') || '{}');
            currentData[e.target.name] = e.target.value;
            localStorage.setItem('drugCategoryFormData', JSON.stringify(currentData));
        }
    });

    // Clear saved data on successful submit
    form.addEventListener('submit', function() {
        localStorage.removeItem('drugCategoryFormData');
    });
}

// Initialize auto-save
document.addEventListener('DOMContentLoaded', function() {
    initializeAutoSave();
});

// Performance optimization: Debounce search
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

// Enhanced search with debouncing
const debouncedSearch = debounce(function(query) {
    // Implement search functionality here
    console.log('Searching for:', query);
}, 300);

// Add search input listener
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="itemname"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            debouncedSearch(this.value);
        });
    }
});
