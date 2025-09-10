// Bank Reconciliation Update Modern JavaScript
// Handles form validation, responsive design, and enhanced user experience for bank reconciliation update management

document.addEventListener('DOMContentLoaded', function() {
    initializeSidebar();
    initializeMenuToggle();
    initializeFormValidation();
    initializeResponsiveDesign();
    initializeTouchSupport();
    initializeFormEnhancements();
    initializeDatePickers();
    initializeFormAutoSave();
    initializeTransactionTypeIndicators();
    initializeAmountFormatting();
    initializeReconciliationWorkflow();
});

// Sidebar Management
function initializeSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
        });
    }
}

// Menu Toggle
function initializeMenuToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
        
        // Close sidebar when clicking outside
        document.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }
}

// Form Validation
function initializeFormValidation() {
    const form = document.getElementById('form1');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
        
        initializeRealTimeValidation();
    }
}

function validateForm() {
    let isValid = true;
    const dateInput = document.getElementById('apdate');
    
    // Validate bank date
    if (!dateInput.value.trim()) {
        showFieldError(dateInput, 'Bank date is required for reconciliation');
        isValid = false;
    } else if (!isValidDate(dateInput.value)) {
        showFieldError(dateInput, 'Please enter a valid date');
        isValid = false;
    } else {
        clearFieldError(dateInput);
    }
    
    // Validate that at least one transaction is selected
    const transactionRows = document.querySelectorAll('.recon-table tbody tr');
    let hasTransactions = false;
    
    transactionRows.forEach(row => {
        const dateField = row.querySelector('input[class*="datepicker"]');
        if (dateField && dateField.value.trim()) {
            hasTransactions = true;
        }
    });
    
    if (!hasTransactions) {
        showNotification('Please select at least one transaction for reconciliation', 'warning');
        isValid = false;
    }
    
    return isValid;
}

function initializeRealTimeValidation() {
    const dateInputs = document.querySelectorAll('input[class*="datepicker"]');
    
    dateInputs.forEach(input => {
        input.addEventListener('change', function() {
            validateDateField(this);
        });
        
        input.addEventListener('blur', function() {
            validateDateField(this);
        });
    });
}

function validateDateField(dateInput) {
    const value = dateInput.value.trim();
    
    if (value && !isValidDate(value)) {
        showFieldError(dateInput, 'Please enter a valid date');
        return false;
    }
    
    clearFieldError(dateInput);
    return true;
}

// Field Error Handling
function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('error');
    const errorDiv = field.parentNode.querySelector('.field-error');
    if (errorDiv) {
        errorDiv.remove();
    }
}

// Responsive Design
function initializeResponsiveDesign() {
    window.addEventListener('resize', debounce(adjustLayoutForScreenSize, 250));
    adjustLayoutForScreenSize();
}

function adjustLayoutForScreenSize() {
    const width = window.innerWidth;
    
    if (width <= 768) {
        document.body.classList.add('mobile-view');
        adjustTablesForMobile();
    } else {
        document.body.classList.remove('mobile-view');
        restoreTableLayout();
    }
}

function adjustTablesForMobile() {
    const tables = document.querySelectorAll('.recon-table');
    tables.forEach(table => {
        if (!table.classList.contains('mobile-adjusted')) {
            table.classList.add('mobile-adjusted');
            addMobileTableEnhancements(table);
        }
    });
}

function restoreTableLayout() {
    const tables = document.querySelectorAll('.recon-table');
    tables.forEach(table => {
        table.classList.remove('mobile-adjusted');
        removeMobileTableEnhancements(table);
    });
}

function addMobileTableEnhancements(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        if (index === 0) return; // Skip header row
        
        const cells = row.querySelectorAll('td');
        cells.forEach((cell, cellIndex) => {
            const header = table.querySelector(`th:nth-child(${cellIndex + 1})`);
            if (header) {
                cell.setAttribute('data-label', header.textContent);
            }
        });
    });
}

function removeMobileTableEnhancements(table) {
    const cells = table.querySelectorAll('td[data-label]');
    cells.forEach(cell => {
        cell.removeAttribute('data-label');
    });
}

// Touch Support
function initializeTouchSupport() {
    if ('ontouchstart' in window) {
        document.body.classList.add('touch-device');
        addTouchEnhancements();
    }
}

function addTouchEnhancements() {
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.style.minHeight = '44px';
        button.style.minWidth = '44px';
    });
    
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.style.minHeight = '44px';
    });
}

// Form Enhancements
function initializeFormEnhancements() {
    const submitButtons = document.querySelectorAll('button[type="submit"]');
    submitButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.form && this.form.checkValidity()) {
                this.classList.add('loading');
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            }
        });
    });
    
    addKeyboardShortcuts();
    addFormResetConfirmation();
}

function addKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            const submitButton = document.querySelector('button[type="submit"]');
            if (submitButton && !submitButton.disabled) {
                submitButton.click();
            }
        }
        
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            const submitButton = document.querySelector('button[type="submit"]');
            if (submitButton && !submitButton.disabled) {
                submitButton.click();
            }
        }
        
        if (e.key === 'Escape') {
            document.activeElement.blur();
        }
        
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            if (confirm('Are you sure you want to reset the form?')) {
                document.getElementById('form1').reset();
            }
        }
    });
}

function addFormResetConfirmation() {
    const form = document.getElementById('form1');
    if (form) {
        form.addEventListener('reset', function(e) {
            if (!confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
                e.preventDefault();
            }
        });
    }
}

// Date Picker Enhancements
function initializeDatePickers() {
    const dateInputs = document.querySelectorAll('input[class*="datepicker"]');
    
    dateInputs.forEach(input => {
        addQuickDateButtons(input);
        input.addEventListener('change', function() {
            validateDateField(this);
            updateReconciliationStatus();
        });
    });
}

function addQuickDateButtons(dateInput) {
    const container = dateInput.parentNode;
    const quickDateDiv = document.createElement('div');
    quickDateDiv.className = 'quick-date-buttons';
    quickDateDiv.style.cssText = `
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
        flex-wrap: wrap;
    `;
    
    const quickDates = [
        { label: 'Today', days: 0 },
        { label: 'Yesterday', days: -1 },
        { label: 'Last Week', days: -7 },
        { label: 'Last Month', days: -30 },
        { label: 'Start of Month', type: 'monthStart' },
        { label: 'End of Month', type: 'monthEnd' }
    ];
    
    quickDates.forEach(quickDate => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'quick-date-btn';
        button.textContent = quickDate.label;
        button.style.cssText = `
            background: #ecf0f1;
            border: 1px solid #bdc3c7;
            color: #7f8c8d;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        `;
        
        button.addEventListener('click', function() {
            let targetDate;
            
            if (quickDate.type === 'monthStart') {
                targetDate = new Date();
                targetDate.setDate(1);
            } else if (quickDate.type === 'monthEnd') {
                targetDate = new Date();
                targetDate.setMonth(targetDate.getMonth() + 1, 0);
            } else {
                targetDate = new Date();
                targetDate.setDate(targetDate.getDate() + quickDate.days);
            }
            
            dateInput.value = targetDate.toISOString().split('T')[0];
            dateInput.dispatchEvent(new Event('change'));
            
            showNotification(`Date set to: ${quickDate.label}`, 'success');
        });
        
        button.addEventListener('mouseenter', function() {
            this.style.background = '#3498db';
            this.style.color = 'white';
            this.style.borderColor = '#3498db';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.background = '#ecf0f1';
            this.style.color = '#7f8c8d';
            this.style.borderColor = '#bdc3c7';
        });
        
        quickDateDiv.appendChild(button);
    });
    
    container.appendChild(quickDateDiv);
}

// Form Auto-save
function initializeFormAutoSave() {
    const form = document.getElementById('form1');
    if (!form) return;
    
    const autoSaveKey = 'bank_recon_update_autosave';
    
    // Load auto-saved data
    const savedData = localStorage.getItem(autoSaveKey);
    if (savedData) {
        try {
            const data = JSON.parse(savedData);
            Object.keys(data).forEach(key => {
                const field = form.querySelector(`[name="${key}"]`);
                if (field) {
                    field.value = data[key];
                }
            });
            
            showNotification('Form data restored from auto-save', 'info');
        } catch (e) {
            console.error('Error loading auto-saved data:', e);
        }
    }
    
    // Auto-save on input
    form.addEventListener('change', debounce(function() {
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        
        localStorage.setItem(autoSaveKey, JSON.stringify(data));
    }, 1000));
}

// Transaction Type Indicators
function initializeTransactionTypeIndicators() {
    const rows = document.querySelectorAll('.recon-table tbody tr');
    
    rows.forEach(row => {
        const docNoCell = row.querySelector('.doc-no');
        if (docNoCell) {
            const docNo = docNoCell.textContent;
            addTransactionTypeIndicator(docNoCell, docNo);
        }
    });
}

function addTransactionTypeIndicator(cell, docNo) {
    let transactionType = '';
    let typeClass = '';
    
    if (docNo.includes('AR')) {
        transactionType = 'Receivable';
        typeClass = 'type-receivable';
    } else if (docNo.includes('AP')) {
        transactionType = 'Payable';
        typeClass = 'type-payable';
    } else if (docNo.includes('EN')) {
        transactionType = 'Expense';
        typeClass = 'type-expense';
    } else if (docNo.includes('RE')) {
        transactionType = 'Receipt';
        typeClass = 'type-receipt';
    } else if (docNo.includes('BE')) {
        transactionType = 'Bank Entry';
        typeClass = 'type-bank';
    } else if (docNo.includes('JE')) {
        transactionType = 'Journal Entry';
        typeClass = 'type-journal';
    }
    
    if (transactionType) {
        const indicator = document.createElement('span');
        indicator.className = `transaction-type ${typeClass}`;
        indicator.textContent = transactionType;
        indicator.style.marginLeft = '0.5rem';
        
        cell.appendChild(indicator);
    }
}

// Amount Formatting
function initializeAmountFormatting() {
    const amountCells = document.querySelectorAll('.amount');
    
    amountCells.forEach(cell => {
        if (cell.textContent) {
            const amount = parseFloat(cell.textContent.replace(/[^0-9.-]+/g, ''));
            if (!isNaN(amount)) {
                cell.classList.add('amount-display');
                
                if (amount > 0) {
                    cell.classList.add('amount-credit');
                } else if (amount < 0) {
                    cell.classList.add('amount-debit');
                } else {
                    cell.classList.add('amount-neutral');
                }
            }
        }
    });
}

// Reconciliation Workflow
function initializeReconciliationWorkflow() {
    const dateInputs = document.querySelectorAll('input[class*="datepicker"]');
    
    dateInputs.forEach(input => {
        input.addEventListener('change', function() {
            updateReconciliationStatus();
            updateSummaryCalculations();
        });
    });
    
    // Add reconciliation status indicators
    addReconciliationStatusIndicators();
}

function updateReconciliationStatus() {
    const rows = document.querySelectorAll('.recon-table tbody tr');
    
    rows.forEach(row => {
        const dateField = row.querySelector('input[class*="datepicker"]');
        const statusCell = row.querySelector('.status-cell');
        
        if (dateField && dateField.value.trim()) {
            if (statusCell) {
                statusCell.innerHTML = '<span class="status-indicator status-posted">Reconciled</span>';
            }
            row.classList.add('reconciled');
        } else {
            if (statusCell) {
                statusCell.innerHTML = '<span class="status-indicator status-pending">Pending</span>';
            }
            row.classList.remove('reconciled');
        }
    });
}

function addReconciliationStatusIndicators() {
    const rows = document.querySelectorAll('.recon-table tbody tr');
    
    rows.forEach(row => {
        const actionCell = row.querySelector('.action');
        if (actionCell) {
            const statusCell = document.createElement('td');
            statusCell.className = 'status-cell';
            statusCell.innerHTML = '<span class="status-indicator status-pending">Pending</span>';
            
            // Insert before action cell
            actionCell.parentNode.insertBefore(statusCell, actionCell);
        }
    });
    
    // Add status header
    const headerRow = document.querySelector('.recon-table thead tr');
    if (headerRow) {
        const statusHeader = document.createElement('th');
        statusHeader.textContent = 'Status';
        statusHeader.style.minWidth = '100px';
        
        // Insert before action header
        const actionHeader = headerRow.querySelector('th:last-child');
        headerRow.insertBefore(statusHeader, actionHeader);
    }
}

function updateSummaryCalculations() {
    const rows = document.querySelectorAll('.recon-table tbody tr');
    let totalReconciled = 0;
    let totalPending = 0;
    let reconciledCount = 0;
    let pendingCount = 0;
    
    rows.forEach(row => {
        const dateField = row.querySelector('input[class*="datepicker"]');
        const amountCell = row.querySelector('.amount');
        
        if (dateField && amountCell) {
            const amount = parseFloat(amountCell.textContent.replace(/[^0-9.-]+/g, '')) || 0;
            
            if (dateField.value.trim()) {
                totalReconciled += Math.abs(amount);
                reconciledCount++;
            } else {
                totalPending += Math.abs(amount);
                pendingCount++;
            }
        }
    });
    
    // Update summary display if it exists
    updateSummaryDisplay(totalReconciled, totalPending, reconciledCount, pendingCount);
}

function updateSummaryDisplay(reconciled, pending, reconciledCount, pendingCount) {
    // Create or update summary section
    let summarySection = document.querySelector('.summary-section');
    
    if (!summarySection) {
        summarySection = document.createElement('section');
        summarySection.className = 'summary-section';
        summarySection.innerHTML = `
            <div class="summary-header">
                <h3><i class="fas fa-chart-pie"></i> Reconciliation Summary</h3>
            </div>
            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-amount posted">${reconciledCount}</div>
                    <div class="summary-label">Reconciled Transactions</div>
                </div>
                <div class="summary-card">
                    <div class="summary-amount pending">${pendingCount}</div>
                    <div class="summary-label">Pending Transactions</div>
                </div>
                <div class="summary-card">
                    <div class="summary-amount posted">${formatCurrency(reconciled)}</div>
                    <div class="summary-label">Reconciled Amount</div>
                </div>
                <div class="summary-card">
                    <div class="summary-amount pending">${formatCurrency(pending)}</div>
                    <div class="summary-label">Pending Amount</div>
                </div>
            </div>
        `;
        
        const mainContent = document.querySelector('.main-content');
        const bankReconSection = document.querySelector('.bank-recon-section');
        mainContent.insertBefore(summarySection, bankReconSection.nextSibling);
    } else {
        // Update existing summary
        const reconciledCountEl = summarySection.querySelector('.summary-card:nth-child(1) .summary-amount');
        const pendingCountEl = summarySection.querySelector('.summary-card:nth-child(2) .summary-amount');
        const reconciledAmountEl = summarySection.querySelector('.summary-card:nth-child(3) .summary-amount');
        const pendingAmountEl = summarySection.querySelector('.summary-card:nth-child(4) .summary-amount');
        
        if (reconciledCountEl) reconciledCountEl.textContent = reconciledCount;
        if (pendingCountEl) pendingCountEl.textContent = pendingCount;
        if (reconciledAmountEl) reconciledAmountEl.textContent = formatCurrency(reconciled);
        if (pendingAmountEl) pendingAmountEl.textContent = formatCurrency(pending);
    }
}

// Utility Functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    }).format(amount);
}

function isValidDate(dateString) {
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

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

// Enhanced legacy functions
function refreshPage() {
    if (confirm('Are you sure you want to refresh the page? All unsaved changes will be lost.')) {
        window.location.reload();
    }
}

function exportToExcel() {
    showNotification('Export functionality will be implemented here', 'info');
    // Implementation for Excel export
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 4px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        max-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    
    const colors = {
        success: '#27ae60',
        error: '#e74c3c',
        warning: '#f39c12',
        info: '#3498db'
    };
    
    notification.style.background = colors[type] || colors.info;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);
}

// Export functions for global access
window.BankReconUpdateModern = {
    validateForm,
    showNotification,
    refreshPage,
    exportToExcel,
    updateReconciliationStatus,
    updateSummaryCalculations
};
