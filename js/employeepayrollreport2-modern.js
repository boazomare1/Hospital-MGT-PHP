// Employee Payroll Report Modern JavaScript
let allPayrollData = [];
let filteredPayrollData = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let searchForm, employeeInput, yearSelect, searchInput, clearBtn;
let payrollTable, sidebarToggle, leftSidebar, menuToggle;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    setupFormValidation();
    setupAutoHideAlerts();
    setupEmployeeSearch();
    setupPayrollCalculations();
});

function initializeElements() {
    searchForm = document.getElementById('searchForm');
    employeeInput = document.getElementById('searchemployee');
    yearSelect = document.getElementById('searchyear');
    searchInput = document.getElementById('searchInput');
    clearBtn = document.getElementById('clearBtn');
    payrollTable = document.getElementById('payrollTable');
    sidebarToggle = document.getElementById('sidebarToggle');
    leftSidebar = document.getElementById('leftSidebar');
    menuToggle = document.getElementById('menuToggle');
}

function setupEventListeners() {
    // Form submission
    if (searchForm) {
        searchForm.addEventListener('submit', handleFormSubmit);
    }
    
    // Employee search
    if (employeeInput) {
        employeeInput.addEventListener('input', handleEmployeeSearch);
        employeeInput.addEventListener('focus', showEmployeeSuggestions);
        employeeInput.addEventListener('blur', hideEmployeeSuggestions);
    }
    
    // Year selection
    if (yearSelect) {
        yearSelect.addEventListener('change', handleYearChange);
    }
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', handleSearch);
    }
    
    if (clearBtn) {
        clearBtn.addEventListener('click', clearSearch);
    }
    
    // Payroll calculations
    setupPayrollCalculations();
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
    // Add real-time validation for employee selection
    if (employeeInput) {
        employeeInput.addEventListener('blur', validateEmployeeInput);
        employeeInput.addEventListener('input', clearValidationError);
    }
}

function validateEmployeeInput(e) {
    const input = e.target;
    const value = input.value.trim();
    
    if (value === '') {
        showFieldError(input, 'Employee selection is required');
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

function setupEmployeeSearch() {
    // Enhanced employee search with auto-suggest
    if (employeeInput) {
        employeeInput.addEventListener('input', debounce(function() {
            const searchTerm = this.value.trim();
            if (searchTerm.length >= 2) {
                searchEmployees(searchTerm);
            } else {
                hideEmployeeSuggestions();
            }
        }, 300));
    }
}

function searchEmployees(searchTerm) {
    // Simulate AJAX call to search employees
    // In real implementation, this would be an actual AJAX call
    const mockEmployees = [
        'John Doe - EMP001',
        'Jane Smith - EMP002',
        'Mike Johnson - EMP003',
        'Sarah Wilson - EMP004'
    ];
    
    const filteredEmployees = mockEmployees.filter(emp => 
        emp.toLowerCase().includes(searchTerm.toLowerCase())
    );
    
    showEmployeeSuggestions(filteredEmployees);
}

function showEmployeeSuggestions(employees = []) {
    let suggestionsList = document.getElementById('employeeSuggestions');
    
    if (!suggestionsList) {
        suggestionsList = document.createElement('div');
        suggestionsList.id = 'employeeSuggestions';
        suggestionsList.className = 'autosuggest-list';
        employeeInput.parentNode.appendChild(suggestionsList);
    }
    
    if (employees.length === 0) {
        suggestionsList.style.display = 'none';
        return;
    }
    
    suggestionsList.innerHTML = '';
    employees.forEach(employee => {
        const item = document.createElement('div');
        item.className = 'autosuggest-item';
        item.textContent = employee;
        item.addEventListener('click', function() {
            employeeInput.value = employee;
            hideEmployeeSuggestions();
        });
        suggestionsList.appendChild(item);
    });
    
    suggestionsList.style.display = 'block';
}

function hideEmployeeSuggestions() {
    const suggestionsList = document.getElementById('employeeSuggestions');
    if (suggestionsList) {
        setTimeout(() => {
            suggestionsList.style.display = 'none';
        }, 200);
    }
}

function setupPayrollCalculations() {
    // Calculate totals and summaries
    calculatePayrollTotals();
    updatePayrollSummary();
}

function calculatePayrollTotals() {
    const grossPayCells = document.querySelectorAll('.gross-pay-amount');
    const deductionCells = document.querySelectorAll('.deduction-amount');
    const netPayCells = document.querySelectorAll('.net-pay-amount');
    
    let totalGross = 0;
    let totalDeduction = 0;
    let totalNet = 0;
    
    grossPayCells.forEach(cell => {
        totalGross += parseFloat(cell.textContent.replace(/[^0-9.-]+/g, '')) || 0;
    });
    
    deductionCells.forEach(cell => {
        totalDeduction += parseFloat(cell.textContent.replace(/[^0-9.-]+/g, '')) || 0;
    });
    
    netPayCells.forEach(cell => {
        totalNet += parseFloat(cell.textContent.replace(/[^0-9.-]+/g, '')) || 0;
    });
    
    // Update summary display
    updateSummaryDisplay(totalGross, totalDeduction, totalNet);
}

function updateSummaryDisplay(gross, deduction, net) {
    const grossElement = document.getElementById('totalGross');
    const deductionElement = document.getElementById('totalDeduction');
    const netElement = document.getElementById('totalNet');
    
    if (grossElement) grossElement.textContent = formatCurrency(gross);
    if (deductionElement) deductionElement.textContent = formatCurrency(deduction);
    if (netElement) netElement.textContent = formatCurrency(net);
}

function updatePayrollSummary() {
    // Update summary cards with current data
    const summaryCards = document.querySelectorAll('.summary-item');
    summaryCards.forEach(card => {
        const value = card.querySelector('.summary-value');
        if (value) {
            // Add animation to summary values
            value.style.animation = 'pulse 0.5s ease-in-out';
            setTimeout(() => {
                value.style.animation = '';
            }, 500);
        }
    });
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
    if (!validateEmployeeInput({ target: employeeInput })) {
        return false;
    }
    
    return true;
}

function handleEmployeeSearch(value) {
    // Handle employee search input
    if (value.length >= 2) {
        searchEmployees(value);
    } else {
        hideEmployeeSuggestions();
    }
}

function handleYearChange(e) {
    const selectedYear = e.target.value;
    // Trigger report refresh with new year
    if (searchForm) {
        searchForm.submit();
    }
}

function handleSearch(value) {
    const searchTerm = value.toLowerCase();
    const rows = document.querySelectorAll('.payroll-table tbody tr');
    
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
    
    const rows = document.querySelectorAll('.payroll-table tbody tr');
    rows.forEach(row => {
        row.style.display = '';
    });
    
    updateSearchResults(rows.length);
}

function updateSearchResults(count) {
    const resultsInfo = document.getElementById('searchResults');
    if (resultsInfo) {
        resultsInfo.textContent = `Showing ${count} payroll records`;
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

function exportToPDF() {
    const url = `print_employeepayrollreportpdf.php?frmflag1=frmflag1&&searchmonth=${getCurrentMonth()}&&searchyear=${getCurrentYear()}&&searchemployee=${encodeURIComponent(employeeInput.value)}&&companycode=${getCompanyCode()}`;
    window.open(url, '_blank');
    showNotification('PDF export initiated', 'success');
}

function exportToExcel() {
    const url = `print_employeepayrollreportexl.php?frmflag1=frmflag1&&searchmonth=${getCurrentMonth()}&&searchyear=${getCurrentYear()}&&searchemployee=${encodeURIComponent(employeeInput.value)}&&companycode=${getCompanyCode()}`;
    window.open(url, '_blank');
    showNotification('Excel export initiated', 'success');
}

function printPage() {
    window.print();
}

function refreshPage() {
    window.location.reload();
}

function resetForm() {
    if (confirm('Are you sure you want to reset the form? All search criteria will be cleared.')) {
        if (employeeInput) employeeInput.value = '';
        if (yearSelect) yearSelect.value = new Date().getFullYear();
        if (searchInput) searchInput.value = '';
        
        showNotification('Form reset successfully', 'success');
    }
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

function getCurrentMonth() {
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    return months[new Date().getMonth()];
}

function getCurrentYear() {
    return new Date().getFullYear();
}

function getCompanyCode() {
    // This would typically come from a global variable or data attribute
    return document.querySelector('[data-company-code]')?.getAttribute('data-company-code') || '';
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func.apply(this, args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Enhanced form validation function
function from1submit1() {
    if (!employeeInput || employeeInput.value.trim() === '') {
        showNotification('Please Select Employee', 'error');
        if (employeeInput) {
            employeeInput.focus();
            showFieldError(employeeInput, 'Employee selection is required');
        }
        return false;
    }
    
    return true;
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + S to search
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        if (searchForm) {
            searchForm.submit();
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
    
    // Escape to clear search
    if (e.key === 'Escape') {
        clearSearch();
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
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
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
    
    .payroll-table tr.highlight {
        background: rgba(59, 130, 246, 0.1) !important;
        animation: highlight 0.5s ease-in-out;
    }
    
    @keyframes highlight {
        0% { background: rgba(59, 130, 246, 0.3); }
        100% { background: rgba(59, 130, 246, 0.1); }
    }
`;
document.head.appendChild(style);

// Auto-suggest functionality (if using existing autosuggest library)
window.onload = function() {
    // Initialize auto-suggest if the library is available
    if (typeof AutoSuggestControl !== 'undefined' && employeeInput) {
        const oTextbox = new AutoSuggestControl(employeeInput, new StateSuggestions());
    }
};







