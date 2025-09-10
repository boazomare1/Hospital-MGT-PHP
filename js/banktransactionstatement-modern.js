// Bank Transaction Statement Modern JavaScript
// Handles form validation, responsive design, and enhanced user experience for bank transaction statement management

document.addEventListener('DOMContentLoaded', function() {
    initializeSidebar();
    initializeMenuToggle();
    initializeFormValidation();
    initializeResponsiveDesign();
    initializeTouchSupport();
    initializeFormEnhancements();
    initializeDatePickers();
    initializeBankSelection();
    initializeTransactionTable();
    initializeSummaryCalculations();
    initializeExportFunctionality();
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
    const searchForm = document.querySelector('form[action*="banktransactionstatement.php"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!validateSearchForm()) {
                e.preventDefault();
            }
        });
        
        initializeRealTimeValidation();
    }
}

function validateSearchForm() {
    let isValid = true;
    const bankSelect = document.getElementById('bankname');
    const monthSelect = document.getElementById('searchmonth');
    const yearSelect = document.getElementById('searchyear');
    
    // Validate bank selection
    if (!bankSelect.value) {
        showFieldError(bankSelect, 'Please select a bank to proceed');
        isValid = false;
    } else {
        clearFieldError(bankSelect);
    }
    
    // Validate month selection
    if (!monthSelect.value) {
        showFieldError(monthSelect, 'Please select a month');
        isValid = false;
    } else {
        clearFieldError(monthSelect);
    }
    
    // Validate year selection
    if (!yearSelect.value) {
        showFieldError(yearSelect, 'Please select a year');
        isValid = false;
    } else {
        clearFieldError(yearSelect);
    }
    
    return isValid;
}

function initializeRealTimeValidation() {
    const formFields = document.querySelectorAll('select, input');
    
    formFields.forEach(field => {
        field.addEventListener('change', function() {
            validateField(this);
        });
        
        field.addEventListener('blur', function() {
            validateField(this);
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Special validation for date fields
    if (field.type === 'text' && field.classList.contains('datepicker')) {
        if (value && !isValidDate(value)) {
            showFieldError(field, 'Please enter a valid date');
            return false;
        }
    }
    
    clearFieldError(field);
    return true;
}

// Field Error Handling
function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('invalid');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('invalid');
    field.classList.add('valid');
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
    const tables = document.querySelectorAll('.transactions-table');
    tables.forEach(table => {
        if (!table.classList.contains('mobile-adjusted')) {
            table.classList.add('mobile-adjusted');
            addMobileTableEnhancements(table);
        }
    });
}

function restoreTableLayout() {
    const tables = document.querySelectorAll('.transactions-table');
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
    const submitButtons = document.querySelectorAll('input[type="submit"]');
    submitButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.form && this.form.checkValidity()) {
                this.style.opacity = '0.7';
                this.disabled = true;
                this.value = 'Searching...';
            }
        });
    });
    
    addKeyboardShortcuts();
    addFormResetConfirmation();
}

function addKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            const bankSelect = document.getElementById('bankname');
            if (bankSelect) {
                bankSelect.focus();
            }
        }
        
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            const submitButton = document.querySelector('input[type="submit"]');
            if (submitButton) {
                submitButton.click();
            }
        }
        
        if (e.key === 'Escape') {
            document.activeElement.blur();
        }
        
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            if (confirm('Are you sure you want to reset the form?')) {
                document.querySelector('form[action*="banktransactionstatement.php"]').reset();
            }
        }
    });
}

function addFormResetConfirmation() {
    const form = document.querySelector('form[action*="banktransactionstatement.php"]');
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

function validateDateField(dateInput) {
    const dateValue = dateInput.value;
    
    if (dateValue && !isValidDate(dateValue)) {
        showFieldError(dateInput, 'Please enter a valid date');
        return false;
    }
    
    clearFieldError(dateInput);
    return true;
}

// Bank Selection Enhancement
function initializeBankSelection() {
    const bankSelect = document.getElementById('bankname');
    if (bankSelect) {
        addBankSearchAndQuickSelection(bankSelect);
    }
}

function addBankSearchAndQuickSelection(selectElement) {
    const container = selectElement.parentNode;
    container.classList.add('bank-select-container');
    
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Search banks...';
    searchInput.className = 'form-input bank-search-input';
    searchInput.style.display = 'none'; // Hidden by default
    container.insertBefore(searchInput, selectElement);
    
    selectElement.addEventListener('focus', function() {
        searchInput.style.display = 'block';
        searchInput.focus();
    });
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        Array.from(selectElement.options).forEach(option => {
            if (option.value === '') return;
            option.style.display = option.textContent.toLowerCase().includes(searchTerm) ? '' : 'none';
        });
    });
    
    selectElement.addEventListener('change', function() {
        searchInput.style.display = 'none';
        searchInput.value = '';
        Array.from(selectElement.options).forEach(option => option.style.display = ''); // Show all options
    });
    
    // Add quick selection buttons
    const quickActionsDiv = document.createElement('div');
    quickActionsDiv.className = 'quick-actions';
    quickActionsDiv.style.cssText = `
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
        flex-wrap: wrap;
    `;
    
    const quickBanks = [
        { label: 'Primary Bank', value: 'BNK00000001' },
        { label: 'Secondary Bank', value: 'BNK00000002' },
        { label: 'Treasury Bank', value: 'BNK00000003' }
    ];
    
    quickBanks.forEach(bank => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'quick-action-btn';
        button.textContent = bank.label;
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
            const option = selectElement.querySelector(`option[value^="${bank.value}"]`);
            if (option) {
                selectElement.value = option.value;
                selectElement.dispatchEvent(new Event('change'));
                showNotification(`Selected bank: ${bank.label}`, 'success');
            } else {
                showNotification(`Bank "${bank.label}" not found.`, 'warning');
            }
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
        
        quickActionsDiv.appendChild(button);
    });
    
    container.appendChild(quickActionsDiv);
}

// Transaction Table Enhancement
function initializeTransactionTable() {
    const tables = document.querySelectorAll('.transactions-table');
    tables.forEach(table => {
        addTableSorting(table);
        addTransactionTypeIndicators(table);
        addAmountFormatting(table);
        addRowHighlighting(table);
        addMobileEnhancements(table);
    });
}

function addTableSorting(table) {
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        if (header.textContent.trim() !== '') {
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                sortTable(table, index);
            });
            
            const sortIndicator = document.createElement('span');
            sortIndicator.className = 'sort-indicator';
            sortIndicator.innerHTML = ' ↕';
            sortIndicator.style.color = '#999';
            header.appendChild(sortIndicator);
        }
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Remove existing sort indicators
    table.querySelectorAll('.sort-indicator').forEach(indicator => {
        indicator.innerHTML = ' ↕';
        indicator.style.color = '#999';
    });
    
    // Add sort indicator to clicked header
    const clickedHeader = table.querySelector(`th:nth-child(${columnIndex + 1})`);
    const indicator = clickedHeader.querySelector('.sort-indicator');
    
    // Determine sort direction
    const currentDirection = indicator.getAttribute('data-direction') || 'none';
    const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
    
    indicator.setAttribute('data-direction', newDirection);
    indicator.innerHTML = newDirection === 'asc' ? ' ↑' : ' ↓';
    indicator.style.color = '#3498db';
    
    // Sort rows
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex]?.textContent.trim() || '';
        const bValue = b.cells[columnIndex]?.textContent.trim() || '';
        
        if (newDirection === 'asc') {
            return aValue.localeCompare(bValue);
        } else {
            return bValue.localeCompare(aValue);
        }
    });
    
    // Reorder rows
    rows.forEach(row => tbody.appendChild(row));
}

function addTransactionTypeIndicators(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const descriptionCell = row.querySelector('td:nth-child(4)'); // Description column
        if (descriptionCell) {
            const text = descriptionCell.textContent.toLowerCase();
            let transactionType = '';
            
            if (text.includes('accounts receivable')) {
                transactionType = 'receivable';
            } else if (text.includes('account payable')) {
                transactionType = 'payable';
            } else if (text.includes('journal entries')) {
                transactionType = 'journal';
            } else if (text.includes('expenses')) {
                transactionType = 'expense';
            } else if (text.includes('receipts')) {
                transactionType = 'receipt';
            } else if (text.includes('bank entry')) {
                transactionType = 'bank';
            }
            
            if (transactionType) {
                const typeIndicator = document.createElement('span');
                typeIndicator.className = `transaction-type type-${transactionType}`;
                typeIndicator.textContent = transactionType.toUpperCase();
                typeIndicator.style.marginLeft = '0.5rem';
                
                descriptionCell.appendChild(typeIndicator);
            }
        }
    });
}

function addAmountFormatting(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const moneyInCell = row.querySelector('td:nth-child(6)'); // Money In column
        const moneyOutCell = row.querySelector('td:nth-child(7)'); // Money Out column
        const balanceCell = row.querySelector('td:nth-child(8)'); // Running Balance column
        
        if (moneyInCell && moneyInCell.textContent.trim() !== '0.00') {
            moneyInCell.classList.add('transaction-credit');
        }
        
        if (moneyOutCell && moneyOutCell.textContent.trim() !== '0.00') {
            moneyOutCell.classList.add('transaction-debit');
        }
        
        if (balanceCell) {
            balanceCell.classList.add('transaction-balance');
        }
    });
}

function addRowHighlighting(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.classList.add('transaction-row');
        
        // Add hover effect
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
}

function addMobileEnhancements(table) {
    // Add mobile-specific enhancements
    if (window.innerWidth <= 768) {
        addMobileTableEnhancements(table);
    }
}

// Summary Calculations
function initializeSummaryCalculations() {
    updateTransactionSummary();
    addSummaryCards();
}

function updateTransactionSummary() {
    const rows = document.querySelectorAll('.transactions-table tbody tr');
    let totalMoneyIn = 0;
    let totalMoneyOut = 0;
    let totalUnpresented = 0;
    let totalUncleared = 0;
    let transactionCount = 0;
    
    rows.forEach(row => {
        const moneyInCell = row.querySelector('td:nth-child(6)');
        const moneyOutCell = row.querySelector('td:nth-child(7)');
        const descriptionCell = row.querySelector('td:nth-child(4)');
        
        if (moneyInCell && moneyOutCell) {
            const moneyIn = parseFloat(moneyInCell.textContent.replace(/[^0-9.-]+/g, '')) || 0;
            const moneyOut = parseFloat(moneyOutCell.textContent.replace(/[^0-9.-]+/g, '')) || 0;
            
            totalMoneyIn += moneyIn;
            totalMoneyOut += moneyOut;
            transactionCount++;
            
            // Check for unpresented/uncleared transactions
            if (descriptionCell && descriptionCell.textContent.includes('Unpresented')) {
                totalUnpresented += moneyOut;
            }
            if (descriptionCell && descriptionCell.textContent.includes('Uncleared')) {
                totalUncleared += moneyIn;
            }
        }
    });
    
    // Update summary display
    updateSummaryDisplay(totalMoneyIn, totalMoneyOut, totalUnpresented, totalUncleared, transactionCount);
}

function addSummaryCards() {
    const container = document.querySelector('.transactions-container') || document.body;
    const summarySection = document.createElement('section');
    summarySection.className = 'summary-section';
    summarySection.innerHTML = `
        <div class="summary-header">
            <h3><i class="fas fa-chart-pie"></i> Transaction Summary</h3>
        </div>
        <div class="summary-cards">
            <div class="summary-card credit">
                <div class="summary-card-title">Total Money In</div>
                <div class="summary-card-value" id="totalMoneyIn">$0.00</div>
            </div>
            <div class="summary-card debit">
                <div class="summary-card-title">Total Money Out</div>
                <div class="summary-card-value" id="totalMoneyOut">$0.00</div>
            </div>
            <div class="summary-card count">
                <div class="summary-card-title">Transactions</div>
                <div class="summary-card-value" id="transactionCount">0</div>
            </div>
            <div class="summary-card balance">
                <div class="summary-card-title">Net Balance</div>
                <div class="summary-card-value" id="netBalance">$0.00</div>
            </div>
        </div>
    `;
    
    container.appendChild(summarySection);
}

function updateSummaryDisplay(moneyIn, moneyOut, unpresented, uncleared, count) {
    const totalMoneyInEl = document.getElementById('totalMoneyIn');
    const totalMoneyOutEl = document.getElementById('totalMoneyOut');
    const transactionCountEl = document.getElementById('transactionCount');
    const netBalanceEl = document.getElementById('netBalance');
    
    if (totalMoneyInEl) totalMoneyInEl.textContent = formatCurrency(moneyIn);
    if (totalMoneyOutEl) totalMoneyOutEl.textContent = formatCurrency(moneyOut);
    if (transactionCountEl) transactionCountEl.textContent = count;
    if (netBalanceEl) {
        const netBalance = moneyIn - moneyOut;
        netBalanceEl.textContent = formatCurrency(netBalance);
        netBalanceEl.style.color = netBalance >= 0 ? '#27ae60' : '#e74c3c';
    }
}

// Export Functionality
function initializeExportFunctionality() {
    addExportButtons();
}

function addExportButtons() {
    const container = document.querySelector('.transactions-container') || document.body;
    const exportSection = document.createElement('div');
    exportSection.className = 'export-actions';
    exportSection.style.cssText = `
        background: #f8f9fa;
        padding: 1rem 1.5rem;
        border-top: 1px solid #e1e8ed;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    `;
    
    const exportButtons = [
        { label: 'Export to PDF', icon: 'fas fa-file-pdf', action: 'exportToPDF', class: 'pdf' },
        { label: 'Export to Excel', icon: 'fas fa-file-excel', action: 'exportToExcel', class: 'excel' },
        { label: 'Print Statement', icon: 'fas fa-print', action: 'printStatement', class: 'print' }
    ];
    
    exportButtons.forEach(buttonInfo => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = `export-btn ${buttonInfo.class}`;
        button.innerHTML = `<i class="${buttonInfo.icon}"></i> ${buttonInfo.label}`;
        button.style.cssText = `
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 13px;
            text-decoration: none;
        `;
        
        if (buttonInfo.class === 'pdf') {
            button.style.background = '#e74c3c';
            button.style.color = 'white';
        } else if (buttonInfo.class === 'excel') {
            button.style.background = '#27ae60';
            button.style.color = 'white';
        } else if (buttonInfo.class === 'print') {
            button.style.background = '#3498db';
            button.style.color = 'white';
        }
        
        button.addEventListener('click', function() {
            window[buttonInfo.action]();
        });
        
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
            this.style.boxShadow = '0 2px 4px rgba(0,0,0,0.2)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
        
        exportSection.appendChild(button);
    });
    
    container.appendChild(exportSection);
}

// Export Functions
function exportToPDF() {
    showNotification('PDF export functionality will be implemented here', 'info');
    // Implementation for PDF export
}

function exportToExcel() {
    showNotification('Excel export functionality will be implemented here', 'info');
    // Implementation for Excel export
}

function printStatement() {
    window.print();
}

// Enhanced legacy functions
function functiontest() {
    const bankSelect = document.getElementById('bankname');
    if (!bankSelect.value) {
        showNotification('Please select a bank to proceed', 'error');
        bankSelect.focus();
        return false;
    }
    return true;
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.25rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        max-width: 400px;
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
    notification.style.color = 'white';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
        <span>${message}</span>
        <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
    `;
    
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

// Export functions for global access
window.BankTransactionStatementModern = {
    validateSearchForm,
    showNotification,
    exportToPDF,
    exportToExcel,
    printStatement,
    functiontest
};
