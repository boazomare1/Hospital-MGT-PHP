// Analyze Comparison Modern JavaScript
let allComparisonData = [];
let filteredComparisonData = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let comparisonForm, comparisonTable, searchInput, clearBtn;
let sidebarToggle, leftSidebar, menuToggle;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    setupFormValidation();
    setupAutoHideAlerts();
    setupPriceComparison();
    setupSupplierMapping();
});

function initializeElements() {
    comparisonForm = document.getElementById('form1');
    comparisonTable = document.getElementById('AutoNumber3');
    searchInput = document.getElementById('searchInput');
    clearBtn = document.getElementById('clearBtn');
    sidebarToggle = document.getElementById('sidebarToggle');
    leftSidebar = document.getElementById('leftSidebar');
    menuToggle = document.getElementById('menuToggle');
}

function setupEventListeners() {
    // Form submission
    if (comparisonForm) {
        comparisonForm.addEventListener('submit', handleFormSubmit);
    }
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', handleSearch);
    }
    
    if (clearBtn) {
        clearBtn.addEventListener('click', clearSearch);
    }
    
    // Price comparison highlighting
    setupPriceComparison();
    
    // Supplier mapping
    setupSupplierMapping();
}

function setupSidebarToggle() {
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('collapsed');
            const icon = sidebarToggle.querySelector('i');
            if (leftSidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
        });
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('active');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 1024) {
            if (!leftSidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                leftSidebar.classList.remove('active');
            }
        }
    });
}

function setupFormValidation() {
    // Add real-time validation for supplier selection
    const supplierInputs = document.querySelectorAll('input[name="suppliercoa[]"]');
    supplierInputs.forEach(input => {
        input.addEventListener('blur', validateSupplierInput);
        input.addEventListener('input', clearValidationError);
    });
}

function validateSupplierInput(e) {
    const input = e.target;
    const value = input.value.trim();
    
    if (value === '') {
        showFieldError(input, 'Supplier selection is required');
        return false;
    }
    
    clearFieldError(input);
    return true;
}

function clearValidationError(e) {
    clearFieldError(e.target);
}

function showFieldError(input, message) {
    clearFieldError(input);
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#dc2626';
    errorDiv.style.fontSize = '0.75rem';
    errorDiv.style.marginTop = '0.25rem';
    
    input.parentNode.appendChild(errorDiv);
    input.style.borderColor = '#dc2626';
}

function clearFieldError(input) {
    const errorDiv = input.parentNode.querySelector('.field-error');
    if (errorDiv) {
        errorDiv.remove();
    }
    input.style.borderColor = '';
}

function setupAutoHideAlerts() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
}

function setupPriceComparison() {
    // Highlight price cells based on their values
    const priceCells = document.querySelectorAll('.comparison-table td[data-price]');
    
    priceCells.forEach(cell => {
        const price = parseFloat(cell.getAttribute('data-price'));
        const itemCode = cell.getAttribute('data-item');
        
        if (price > 0) {
            // Get all prices for this item
            const itemPrices = Array.from(document.querySelectorAll(`[data-item="${itemCode}"]`))
                .map(c => parseFloat(c.getAttribute('data-price')))
                .filter(p => p > 0);
            
            const minPrice = Math.min(...itemPrices);
            const maxPrice = Math.max(...itemPrices);
            const avgPrice = itemPrices.reduce((a, b) => a + b, 0) / itemPrices.length;
            
            // Apply color coding
            if (price === minPrice) {
                cell.classList.add('price-lowest');
                cell.title = 'Lowest Price';
            } else if (price === maxPrice) {
                cell.classList.add('price-highest');
                cell.title = 'Highest Price';
            } else if (Math.abs(price - avgPrice) < 0.01) {
                cell.classList.add('price-average');
                cell.title = 'Average Price';
            }
        }
    });
}

function setupSupplierMapping() {
    // Enhanced supplier mapping functionality
    const mapButtons = document.querySelectorAll('input[onclick*="coasearch"]');
    
    mapButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const serialNo = this.getAttribute('onclick').match(/'([^']+)'/)[1];
            openSupplierSearch(serialNo);
        });
    });
}

function openSupplierSearch(serialNo) {
    const width = 750;
    const height = 350;
    const left = (screen.width - width) / 2;
    const top = (screen.height - height) / 2;
    
    const popup = window.open(
        `popupcoasearchcomparison.php?callfrom=${serialNo}`,
        'SupplierSearch',
        `toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=${width},height=${height},left=${left},top=${top}`
    );
    
    if (popup) {
        popup.focus();
    }
}

function handleFormSubmit(e) {
    if (!validateForm()) {
        e.preventDefault();
        return false;
    }
    
    // Show loading state
    const submitBtn = e.target.querySelector('input[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.value = 'Processing...';
        submitBtn.classList.add('loading');
    }
    
    return true;
}

function validateForm() {
    const supplierInputs = document.querySelectorAll('input[name="suppliercoa[]"]');
    let isValid = true;
    
    supplierInputs.forEach(input => {
        if (!validateSupplierInput({ target: input })) {
            isValid = false;
        }
    });
    
    if (!isValid) {
        showNotification('Please select suppliers for all items', 'error');
    }
    
    return isValid;
}

function handleSearch(value) {
    const searchTerm = value.toLowerCase();
    const rows = document.querySelectorAll('.comparison-table tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    updateSearchResults(rows.length);
}

function clearSearch() {
    if (searchInput) {
        searchInput.value = '';
    }
    
    const rows = document.querySelectorAll('.comparison-table tbody tr');
    rows.forEach(row => {
        row.style.display = '';
    });
    
    updateSearchResults(rows.length);
}

function updateSearchResults(count) {
    const resultsInfo = document.getElementById('searchResults');
    if (resultsInfo) {
        resultsInfo.textContent = `Showing ${count} items`;
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="notification-close">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'error' ? '#fee2e2' : type === 'success' ? '#d1fae5' : '#dbeafe'};
        color: ${type === 'error' ? '#991b1b' : type === 'success' ? '#065f46' : '#1e40af'};
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        z-index: 10000;
        max-width: 400px;
        animation: slideInRight 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

function exportToCSV() {
    const table = document.querySelector('.comparison-table');
    if (!table) {
        showNotification('No data to export', 'error');
        return;
    }
    
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cols = row.querySelectorAll('th, td');
        const rowData = [];
        
        cols.forEach(col => {
            // Skip hidden inputs and buttons
            if (col.tagName === 'INPUT' || col.querySelector('input, button')) {
                const input = col.querySelector('input[name="suppliercoa[]"]');
                if (input) {
                    rowData.push(`"${input.value}"`);
                } else {
                    rowData.push('""');
                }
            } else {
                rowData.push(`"${col.textContent.trim()}"`);
            }
        });
        
        csv.push(rowData.join(','));
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'supplier_comparison.csv';
    a.click();
    window.URL.revokeObjectURL(url);
    
    showNotification('CSV exported successfully', 'success');
}

function printPage() {
    window.print();
}

function refreshPage() {
    window.location.reload();
}

function resetForm() {
    if (confirm('Are you sure you want to reset the form? All supplier selections will be cleared.')) {
        const supplierInputs = document.querySelectorAll('input[name="suppliercoa[]"]');
        const supplierCodes = document.querySelectorAll('input[name="suppliercode[]"]');
        
        supplierInputs.forEach(input => {
            input.value = '';
        });
        
        supplierCodes.forEach(input => {
            input.value = '';
        });
        
        showNotification('Form reset successfully', 'success');
    }
}

// Enhanced supplier search function
function coasearch(serialNo) {
    openSupplierSearch(serialNo);
}

// Enhanced validation function
function validate() {
    const supplierInputs = document.querySelectorAll('input[name="suppliercoa[]"]');
    let hasChecked = true;
    
    supplierInputs.forEach(input => {
        if (input.value.trim() === '') {
            hasChecked = false;
        }
    });
    
    if (!hasChecked) {
        showNotification('Please select a Supplier for all items', 'error');
        return false;
    }
    
    return true;
}

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

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + S to save
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        const submitBtn = document.querySelector('input[type="submit"]');
        if (submitBtn) {
            submitBtn.click();
        }
    }
    
    // Ctrl/Cmd + P to print
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        printPage();
    }
    
    // Ctrl/Cmd + F to search
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        if (searchInput) {
            searchInput.focus();
        }
    }
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .notification-close {
        background: none;
        border: none;
        cursor: pointer;
        color: inherit;
        padding: 0;
        margin-left: auto;
    }
    
    .field-error {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
`;
document.head.appendChild(style);







