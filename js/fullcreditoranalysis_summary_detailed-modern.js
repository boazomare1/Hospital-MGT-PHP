// Modern JavaScript for fullcreditoranalysis_summary_detailed.php

document.addEventListener('DOMContentLoaded', function() {
    initializeFullCreditorAnalysis();
});

function initializeFullCreditorAnalysis() {
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize date pickers
    initializeDatePickers();
    
    // Initialize table functionality
    initializeTableFeatures();
    
    // Initialize export functionality
    initializeExportFeatures();
    
    // Initialize charts
    initializeCharts();
    
    // Initialize analysis calculations
    initializeAnalysisCalculations();
    
    // Add loading states
    addLoadingStates();
}

function initializeFormValidation() {
    const form = document.querySelector('form[name="frmsales"]');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
        
        // Add loading state
        addLoadingState(form);
    });
    
    // Real-time validation
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', clearFieldError);
    });
}

function validateForm() {
    let isValid = true;
    
    // Validate date range
    const fromDate = document.querySelector('input[name="fromdate"]');
    const toDate = document.querySelector('input[name="todate"]');
    
    if (fromDate && toDate && fromDate.value && toDate.value) {
        if (new Date(fromDate.value) > new Date(toDate.value)) {
            showFieldError(toDate, 'To date must be after from date');
            isValid = false;
        }
    }
    
    // Validate required fields
    const requiredFields = document.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        if (!validateField({ target: field })) {
            isValid = false;
        }
    });
    
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
    
    // Date validation
    if (field.type === 'date' && value) {
        const date = new Date(value);
        if (isNaN(date.getTime())) {
            showFieldError(field, 'Please enter a valid date');
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

function initializeDatePickers() {
    // Enhanced date picker functionality
    const dateInputs = document.querySelectorAll('input[type="date"]');
    
    dateInputs.forEach(input => {
        // Set default values if empty
        if (!input.value) {
            const today = new Date();
            const oneMonthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
            
            if (input.name === 'fromdate') {
                input.value = formatDate(oneMonthAgo);
            } else if (input.name === 'todate') {
                input.value = formatDate(today);
            }
        }
        
        // Add date validation
        input.addEventListener('change', function() {
            validateDateRange();
        });
    });
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function validateDateRange() {
    const fromDate = document.querySelector('input[name="fromdate"]');
    const toDate = document.querySelector('input[name="todate"]');
    
    if (fromDate && toDate && fromDate.value && toDate.value) {
        if (new Date(fromDate.value) > new Date(toDate.value)) {
            showFieldError(toDate, 'To date must be after from date');
        } else {
            clearFieldError({ target: toDate });
        }
    }
}

function initializeTableFeatures() {
    const tables = document.querySelectorAll('.modern-table');
    tables.forEach(table => {
        // Add sort functionality
        addTableSorting(table);
        
        // Add search functionality
        addTableSearch(table);
        
        // Add financial formatting
        formatFinancialValues(table);
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
        
        // Try to parse as numbers (for financial values)
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

function formatFinancialValues(table) {
    const cells = table.querySelectorAll('td');
    cells.forEach(cell => {
        const text = cell.textContent.trim();
        const numValue = parseFloat(text.replace(/[^0-9.-]/g, ''));
        
        if (!isNaN(numValue) && text.includes('.')) {
            // Apply financial formatting
            if (numValue > 0) {
                cell.classList.add('financial-positive');
            } else if (numValue < 0) {
                cell.classList.add('financial-negative');
            } else {
                cell.classList.add('financial-neutral');
            }
        }
    });
}

function initializeExportFeatures() {
    // Initialize Excel export
    const excelBtn = document.querySelector('.export-excel');
    if (excelBtn) {
        excelBtn.addEventListener('click', function(e) {
            e.preventDefault();
            exportToExcel();
        });
    }
    
    // Initialize PDF export
    const pdfBtn = document.querySelector('.export-pdf');
    if (pdfBtn) {
        pdfBtn.addEventListener('click', function(e) {
            e.preventDefault();
            exportToPDF();
        });
    }
    
    // Initialize CSV export
    const csvBtn = document.querySelector('.export-csv');
    if (csvBtn) {
        csvBtn.addEventListener('click', function(e) {
            e.preventDefault();
            exportToCSV();
        });
    }
}

function exportToExcel() {
    showLoadingState();
    
    // Get current form data
    const formData = new FormData(document.querySelector('form[name="frmsales"]'));
    formData.append('export', 'excel');
    
    // Create download link
    const url = 'fullcreditoranalysis_summary_detailed.php?' + new URLSearchParams(formData).toString();
    const link = document.createElement('a');
    link.href = url;
    link.download = 'creditor_analysis_report.xls';
    link.click();
    
    hideLoadingState();
    showNotification('Excel export started', 'success');
}

function exportToPDF() {
    showLoadingState();
    
    // Get current form data
    const formData = new FormData(document.querySelector('form[name="frmsales"]'));
    formData.append('export', 'pdf');
    
    // Create download link
    const url = 'fullcreditoranalysis_summary_detailed.php?' + new URLSearchParams(formData).toString();
    const link = document.createElement('a');
    link.href = url;
    link.download = 'creditor_analysis_report.pdf';
    link.click();
    
    hideLoadingState();
    showNotification('PDF export started', 'success');
}

function exportToCSV() {
    showLoadingState();
    
    // Get current form data
    const formData = new FormData(document.querySelector('form[name="frmsales"]'));
    formData.append('export', 'csv');
    
    // Create download link
    const url = 'fullcreditoranalysis_summary_detailed.php?' + new URLSearchParams(formData).toString();
    const link = document.createElement('a');
    link.href = url;
    link.download = 'creditor_analysis_report.csv';
    link.click();
    
    hideLoadingState();
    showNotification('CSV export started', 'success');
}

function initializeCharts() {
    // Initialize analysis charts if Chart.js is available
    if (typeof Chart !== 'undefined') {
        createAgingChart();
        createTrendChart();
    }
}

function createAgingChart() {
    const ctx = document.getElementById('agingChart');
    if (!ctx) return;
    
    const chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Current', '1-30 Days', '31-60 Days', '61-90 Days', '91-120 Days', '121-180 Days', '181-210 Days', '211-240 Days'],
            datasets: [{
                data: [40, 20, 15, 10, 8, 4, 2, 1],
                backgroundColor: [
                    '#27ae60',
                    '#f39c12',
                    '#e67e22',
                    '#e74c3c',
                    '#8e44ad',
                    '#34495e',
                    '#2c3e50',
                    '#1a252f'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

function createTrendChart() {
    const ctx = document.getElementById('trendChart');
    if (!ctx) return;
    
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Total Outstanding',
                data: [50000, 55000, 60000, 58000, 65000, 70000],
                borderColor: '#e74c3c',
                backgroundColor: 'rgba(231, 76, 60, 0.1)',
                tension: 0.4
            }, {
                label: 'Current',
                data: [30000, 32000, 35000, 34000, 38000, 40000],
                borderColor: '#27ae60',
                backgroundColor: 'rgba(39, 174, 96, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
}

function initializeAnalysisCalculations() {
    // Calculate and update analysis values
    updateAnalysisCards();
    
    // Recalculate on data changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                updateAnalysisCards();
            }
        });
    });
    
    const tableContainer = document.querySelector('.table-container');
    if (tableContainer) {
        observer.observe(tableContainer, { childList: true, subtree: true });
    }
}

function updateAnalysisCards() {
    const table = document.querySelector('.modern-table');
    if (!table) return;
    
    let currentAmount = 0;
    let overdue30Amount = 0;
    let overdue60Amount = 0;
    let overdue90Amount = 0;
    let overdue120Amount = 0;
    let overdue180Amount = 0;
    let overdue210Amount = 0;
    let overdue240Amount = 0;
    
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 8) {
            // Assuming columns are: Customer, Current, 1-30, 31-60, 61-90, 91-120, 121-180, 181-210, 211-240
            currentAmount += parseFloat(cells[1]?.textContent.replace(/[^0-9.-]/g, '') || 0);
            overdue30Amount += parseFloat(cells[2]?.textContent.replace(/[^0-9.-]/g, '') || 0);
            overdue60Amount += parseFloat(cells[3]?.textContent.replace(/[^0-9.-]/g, '') || 0);
            overdue90Amount += parseFloat(cells[4]?.textContent.replace(/[^0-9.-]/g, '') || 0);
            overdue120Amount += parseFloat(cells[5]?.textContent.replace(/[^0-9.-]/g, '') || 0);
            overdue180Amount += parseFloat(cells[6]?.textContent.replace(/[^0-9.-]/g, '') || 0);
            overdue210Amount += parseFloat(cells[7]?.textContent.replace(/[^0-9.-]/g, '') || 0);
            overdue240Amount += parseFloat(cells[8]?.textContent.replace(/[^0-9.-]/g, '') || 0);
        }
    });
    
    // Update analysis cards
    updateAnalysisCard('current', currentAmount, 'current');
    updateAnalysisCard('overdue-30', overdue30Amount, 'overdue-30');
    updateAnalysisCard('overdue-60', overdue60Amount, 'overdue-60');
    updateAnalysisCard('overdue-90', overdue90Amount, 'overdue-90');
    updateAnalysisCard('overdue-120', overdue120Amount, 'overdue-120');
    updateAnalysisCard('overdue-180', overdue180Amount, 'overdue-180');
    updateAnalysisCard('overdue-210', overdue210Amount, 'overdue-210');
    updateAnalysisCard('overdue-240', overdue240Amount, 'overdue-240');
    
    // Update summary section
    updateSummarySection(currentAmount, overdue30Amount, overdue60Amount, overdue90Amount, 
                        overdue120Amount, overdue180Amount, overdue210Amount, overdue240Amount);
}

function updateAnalysisCard(type, value, className) {
    const card = document.querySelector(`.analysis-card.${type}`);
    if (card) {
        const valueElement = card.querySelector('.analysis-value');
        if (valueElement) {
            valueElement.textContent = formatCurrency(value);
        }
        card.className = `analysis-card ${type} ${className}`;
    }
}

function updateSummarySection(current, overdue30, overdue60, overdue90, overdue120, overdue180, overdue210, overdue240) {
    const totalOutstanding = current + overdue30 + overdue60 + overdue90 + overdue120 + overdue180 + overdue210 + overdue240;
    const totalOverdue = overdue30 + overdue60 + overdue90 + overdue120 + overdue180 + overdue210 + overdue240;
    
    // Update summary items
    updateSummaryItem('total-outstanding', totalOutstanding);
    updateSummaryItem('total-current', current);
    updateSummaryItem('total-overdue', totalOverdue);
    updateSummaryItem('overdue-percentage', totalOutstanding > 0 ? ((totalOverdue / totalOutstanding) * 100).toFixed(1) + '%' : '0%');
}

function updateSummaryItem(type, value) {
    const item = document.querySelector(`.summary-item.${type}`);
    if (item) {
        const valueElement = item.querySelector('.summary-item-value');
        if (valueElement) {
            if (type.includes('percentage')) {
                valueElement.textContent = value;
            } else {
                valueElement.textContent = formatCurrency(value);
            }
        }
    }
}

function formatCurrency(value) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(value);
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

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    .sort-indicator {
        font-size: 0.8em;
        color: #7f8c8d;
        margin-left: 0.5rem;
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
    
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        z-index: 10000;
        animation: slideIn 0.3s ease;
    }
    
    .notification-success {
        background: #27ae60;
        color: white;
    }
    
    .notification-error {
        background: #e74c3c;
        color: white;
    }
    
    .notification-info {
        background: #3498db;
        color: white;
    }
    
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
