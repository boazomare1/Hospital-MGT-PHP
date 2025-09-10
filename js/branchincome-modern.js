// Branch Income Modern JavaScript
// Handles form validation, responsive design, and enhanced user experience for branch income management

document.addEventListener('DOMContentLoaded', function() {
    initializeFormValidation();
    initializeResponsiveDesign();
    initializeDatePickers();
    initializeIncomeTable();
    initializeSummaryCalculations();
    initializeFinancialIndicators();
});

// Form Validation
function initializeFormValidation() {
    const searchForm = document.querySelector('form[action*="branchincome.php"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!validateSearchForm()) {
                e.preventDefault();
            }
        });
    }
}

function validateSearchForm() {
    let isValid = true;
    const dateFromInput = document.getElementById('ADate1');
    const dateToInput = document.getElementById('ADate2');
    const dateFrom2Input = document.getElementById('ADate3');
    const dateTo2Input = document.getElementById('ADate4');
    
    // Validate first date range
    if (dateFromInput && dateToInput) {
        if (dateFromInput.value && dateToInput.value) {
            const dateFrom = new Date(dateFromInput.value);
            const dateTo = new Date(dateToInput.value);
            
            if (dateFrom > dateTo) {
                showFieldError(dateToInput, 'End date must be after start date');
                isValid = false;
            } else {
                clearFieldError(dateToInput);
            }
        }
    }
    
    // Validate second date range
    if (dateFrom2Input && dateTo2Input) {
        if (dateFrom2Input.value && dateTo2Input.value) {
            const dateFrom2 = new Date(dateFrom2Input.value);
            const dateTo2 = new Date(dateTo2Input.value);
            
            if (dateFrom2 > dateTo2) {
                showFieldError(dateTo2Input, 'End date must be after start date');
                isValid = false;
            } else {
                clearFieldError(dateTo2Input);
            }
        }
    }
    
    return isValid;
}

// Field Error Handling
function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('invalid');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.cssText = `
        color: #e74c3c;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        font-weight: 500;
    `;
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
    const tables = document.querySelectorAll('.income-table');
    tables.forEach(table => {
        if (!table.classList.contains('mobile-adjusted')) {
            table.classList.add('mobile-adjusted');
            addMobileTableEnhancements(table);
        }
    });
}

function restoreTableLayout() {
    const tables = document.querySelectorAll('.income-table');
    tables.forEach(table => {
        table.classList.remove('mobile-adjusted');
        removeMobileTableEnhancements(table);
    });
}

function addMobileTableEnhancements(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        if (index === 0) return;
        
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

// Date Picker Enhancements
function initializeDatePickers() {
    const dateInputs = document.querySelectorAll('input[class*="datepicker"], input[type="date"]');
    
    dateInputs.forEach(input => {
        addQuickDateButtons(input);
    });
}

function addQuickDateButtons(dateInput) {
    const container = dateInput.parentNode;
    const quickDateDiv = document.createElement('div');
    quickDateDiv.className = 'quick-date-buttons';
    
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
        
        quickDateDiv.appendChild(button);
    });
    
    container.appendChild(quickDateDiv);
}

// Income Table Enhancement
function initializeIncomeTable() {
    const tables = document.querySelectorAll('.income-table');
    tables.forEach(table => {
        addTableSorting(table);
        addFinancialIndicators(table);
        addRowHighlighting(table);
        addSectionHeaders(table);
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
        }
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex]?.textContent.trim() || '';
        const bValue = b.cells[columnIndex]?.textContent.trim() || '';
        
        const aNum = parseFloat(aValue.replace(/[^0-9.-]+/g, ''));
        const bNum = parseFloat(bValue.replace(/[^0-9.-]+/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return aNum - bNum;
        }
        
        return aValue.localeCompare(bValue);
    });
    
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
    
    rows.forEach(row => tbody.appendChild(row));
}

function addFinancialIndicators(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        cells.forEach(cell => {
            const cellText = cell.textContent.trim();
            
            // Check for amounts
            if (cellText.includes('₹') || cellText.includes('.') || /^\d+$/.test(cellText)) {
                const amount = parseFloat(cellText.replace(/[^0-9.-]+/g, ''));
                if (!isNaN(amount)) {
                    if (amount > 0) {
                        cell.classList.add('amount-positive');
                    } else if (amount < 0) {
                        cell.classList.add('amount-negative');
                    } else {
                        cell.classList.add('amount-neutral');
                    }
                }
            }
            
            // Check for debit/credit indicators
            if (cellText.toLowerCase().includes('dr') || cellText.toLowerCase().includes('debit')) {
                cell.classList.add('debit-amount');
            } else if (cellText.toLowerCase().includes('cr') || cellText.toLowerCase().includes('credit')) {
                cell.classList.add('credit-amount');
            }
        });
    });
}

function addSectionHeaders(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const firstCell = row.querySelector('td:first-child');
        if (firstCell && firstCell.textContent.trim() === '') {
            const secondCell = row.querySelector('td:nth-child(2)');
            if (secondCell) {
                const text = secondCell.textContent.trim();
                if (text && !text.includes('₹') && !text.includes('.') && !/^\d+$/.test(text)) {
                    row.classList.add('section-header-row');
                    secondCell.classList.add('section-header');
                    
                    if (text.toLowerCase().includes('income')) {
                        secondCell.classList.add('income');
                    } else if (text.toLowerCase().includes('expense')) {
                        secondCell.classList.add('expense');
                    } else if (text.toLowerCase().includes('balance')) {
                        secondCell.classList.add('balance');
                    }
                }
            }
        }
    });
}

function addRowHighlighting(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        if (!row.classList.contains('section-header-row')) {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        }
    });
}

// Summary Calculations
function initializeSummaryCalculations() {
    updateIncomeSummary();
    addSummaryCards();
}

function updateIncomeSummary() {
    const rows = document.querySelectorAll('.income-table tbody tr');
    let totalIncome = 0;
    let totalExpense = 0;
    let totalBalance = 0;
    let totalTransactions = 0;
    
    rows.forEach(row => {
        if (!row.classList.contains('section-header-row')) {
            totalTransactions++;
            
            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                const cellText = cell.textContent.trim();
                if (cellText.includes('₹') || cellText.includes('.') || /^\d+$/.test(cellText)) {
                    const amount = parseFloat(cellText.replace(/[^0-9.-]+/g, ''));
                    if (!isNaN(amount)) {
                        if (amount > 0) {
                            totalIncome += amount;
                        } else if (amount < 0) {
                            totalExpense += Math.abs(amount);
                        }
                    }
                }
            });
        }
    });
    
    totalBalance = totalIncome - totalExpense;
    
    updateSummaryDisplay(totalIncome, totalExpense, totalBalance, totalTransactions);
}

function addSummaryCards() {
    const container = document.querySelector('.branch-income-container') || document.body;
    const summarySection = document.createElement('section');
    summarySection.className = 'summary-section';
    summarySection.innerHTML = `
        <div class="summary-header">
            <h3><i class="fas fa-chart-line"></i> Branch Income Summary</h3>
        </div>
        <div class="summary-cards">
            <div class="summary-card total">
                <div class="summary-card-title">Total Transactions</div>
                <div class="summary-card-value" id="totalTransactions">0</div>
            </div>
            <div class="summary-card income">
                <div class="summary-card-title">Total Income</div>
                <div class="summary-card-value" id="totalIncome">₹0.00</div>
            </div>
            <div class="summary-card expense">
                <div class="summary-card-title">Total Expense</div>
                <div class="summary-card-value" id="totalExpense">₹0.00</div>
            </div>
            <div class="summary-card balance">
                <div class="summary-card-title">Net Balance</div>
                <div class="summary-card-value" id="totalBalance">₹0.00</div>
            </div>
        </div>
    `;
    
    container.appendChild(summarySection);
}

function updateSummaryDisplay(income, expense, balance, transactions) {
    const totalEl = document.getElementById('totalTransactions');
    const incomeEl = document.getElementById('totalIncome');
    const expenseEl = document.getElementById('totalExpense');
    const balanceEl = document.getElementById('totalBalance');
    
    if (totalEl) totalEl.textContent = transactions;
    if (incomeEl) incomeEl.textContent = `₹${income.toFixed(2)}`;
    if (expenseEl) expenseEl.textContent = `₹${expense.toFixed(2)}`;
    if (balanceEl) balanceEl.textContent = `₹${balance.toFixed(2)}`;
    
    // Add color coding to balance
    if (balanceEl) {
        if (balance > 0) {
            balanceEl.style.color = 'var(--income-color)';
        } else if (balance < 0) {
            balanceEl.style.color = 'var(--expense-color)';
        } else {
            balanceEl.style.color = 'var(--balance-color)';
        }
    }
}

// Financial Indicators
function initializeFinancialIndicators() {
    addFinancialSummary();
}

function addFinancialSummary() {
    const container = document.querySelector('.branch-income-container') || document.body;
    const financialSection = document.createElement('section');
    financialSection.className = 'financial-summary';
    financialSection.innerHTML = `
        <h3><i class="fas fa-calculator"></i> Financial Summary</h3>
        <div class="financial-grid">
            <div class="financial-item income">
                <div class="financial-item-label">Income Analysis</div>
                <div class="financial-item-value" id="incomeAnalysis">₹0.00</div>
            </div>
            <div class="financial-item expense">
                <div class="financial-item-label">Expense Analysis</div>
                <div class="financial-item-value" id="expenseAnalysis">₹0.00</div>
            </div>
            <div class="financial-item balance">
                <div class="financial-item-label">Profit Margin</div>
                <div class="financial-item-value" id="profitMargin">0%</div>
            </div>
        </div>
    `;
    
    container.appendChild(financialSection);
    
    // Calculate and update financial metrics
    updateFinancialMetrics();
}

function updateFinancialMetrics() {
    const incomeEl = document.getElementById('totalIncome');
    const expenseEl = document.getElementById('totalExpense');
    
    if (incomeEl && expenseEl) {
        const income = parseFloat(incomeEl.textContent.replace(/[^0-9.-]+/g, ''));
        const expense = parseFloat(expenseEl.textContent.replace(/[^0-9.-]+/g, ''));
        
        if (!isNaN(income) && !isNaN(expense)) {
            const profitMargin = income > 0 ? ((income - expense) / income * 100) : 0;
            
            const profitMarginEl = document.getElementById('profitMargin');
            if (profitMarginEl) {
                profitMarginEl.textContent = `${profitMargin.toFixed(2)}%`;
                if (profitMargin > 0) {
                    profitMarginEl.style.color = 'var(--income-color)';
                } else {
                    profitMarginEl.style.color = 'var(--expense-color)';
                }
            }
        }
    }
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
        background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : type === 'warning' ? '#f39c12' : '#3498db'};
        color: white;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    
    notification.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; color: white; margin-left: 1rem; cursor: pointer;">&times;</button>
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
window.BranchIncomeModern = {
    validateSearchForm,
    showNotification,
    updateIncomeSummary,
    updateFinancialMetrics
};




