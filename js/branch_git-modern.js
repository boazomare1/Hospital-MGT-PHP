// Branch Git Modern JavaScript
// Handles form validation, responsive design, and enhanced user experience for branch stock transfer management

document.addEventListener('DOMContentLoaded', function() {
    initializeFormValidation();
    initializeResponsiveDesign();
    initializeDatePickers();
    initializeBranchStockTable();
    initializeSummaryCalculations();
    initializeTransferTypeIndicators();
});

// Form Validation
function initializeFormValidation() {
    const searchForm = document.querySelector('form[action*="branch_git.php"]');
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
    const tables = document.querySelectorAll('.branch-stock-table');
    tables.forEach(table => {
        if (!table.classList.contains('mobile-adjusted')) {
            table.classList.add('mobile-adjusted');
            addMobileTableEnhancements(table);
        }
    });
}

function restoreTableLayout() {
    const tables = document.querySelectorAll('.branch-stock-table');
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
    const dateInputs = document.querySelectorAll('input[class*="datepicker"]');
    
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
        { label: 'Last Month', days: -30 }
    ];
    
    quickDates.forEach(quickDate => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'quick-date-btn';
        button.textContent = quickDate.label;
        
        button.addEventListener('click', function() {
            const targetDate = new Date();
            targetDate.setDate(targetDate.getDate() + quickDate.days);
            dateInput.value = targetDate.toISOString().split('T')[0];
            dateInput.dispatchEvent(new Event('change'));
            
            showNotification(`Date set to: ${quickDate.label}`, 'success');
        });
        
        quickDateDiv.appendChild(button);
    });
    
    container.appendChild(quickDateDiv);
}

// Branch Stock Table Enhancement
function initializeBranchStockTable() {
    const tables = document.querySelectorAll('.branch-stock-table');
    tables.forEach(table => {
        addTableSorting(table);
        addTransferStatusIndicators(table);
        addRowHighlighting(table);
        addTransferTypeIndicators(table);
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

function addTransferStatusIndicators(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const statusCell = row.querySelector('td:contains("pending"), td:contains("approved"), td:contains("rejected"), td:contains("completed")');
        
        if (statusCell) {
            const statusText = statusCell.textContent.toLowerCase();
            let statusClass = '';
            
            if (statusText.includes('pending')) {
                statusClass = 'status-pending';
            } else if (statusText.includes('approved')) {
                statusClass = 'status-approved';
            } else if (statusText.includes('rejected')) {
                statusClass = 'status-rejected';
            } else if (statusText.includes('completed')) {
                statusClass = 'status-completed';
            }
            
            if (statusClass) {
                statusCell.classList.add('transfer-status', statusClass);
            }
        }
    });
}

function addTransferTypeIndicators(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const typeCell = row.querySelector('td:contains("1"), td:contains("0")');
        
        if (typeCell) {
            const typeValue = typeCell.textContent.trim();
            let typeClass = '';
            let typeLabel = '';
            
            if (typeValue === '1') {
                typeClass = 'transfer';
                typeLabel = 'Transfer';
            } else if (typeValue === '0') {
                typeClass = 'consumable';
                typeLabel = 'Consumable';
            }
            
            if (typeClass) {
                typeCell.classList.add('transfer-type', typeClass);
                typeCell.textContent = typeLabel;
            }
        }
    });
}

function addRowHighlighting(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
}

// Summary Calculations
function initializeSummaryCalculations() {
    updateBranchStockSummary();
    addSummaryCards();
}

function updateBranchStockSummary() {
    const rows = document.querySelectorAll('.branch-stock-table tbody tr');
    let totalTransfers = 0;
    let pendingTransfers = 0;
    let approvedTransfers = 0;
    let completedTransfers = 0;
    let totalAmount = 0;
    
    rows.forEach(row => {
        totalTransfers++;
        
        const statusCell = row.querySelector('.transfer-status');
        if (statusCell) {
            if (statusCell.classList.contains('status-pending')) {
                pendingTransfers++;
            } else if (statusCell.classList.contains('status-approved')) {
                approvedTransfers++;
            } else if (statusCell.classList.contains('status-completed')) {
                completedTransfers++;
            }
        }
        
        // Calculate total amount
        const amountCell = row.querySelector('td:last-child');
        if (amountCell) {
            const amountText = amountCell.textContent.replace(/[^0-9.-]+/g, '');
            const amount = parseFloat(amountText);
            if (!isNaN(amount)) {
                totalAmount += amount;
            }
        }
    });
    
    updateSummaryDisplay(totalTransfers, pendingTransfers, approvedTransfers, completedTransfers, totalAmount);
}

function addSummaryCards() {
    const container = document.querySelector('.branch-git-container') || document.body;
    const summarySection = document.createElement('section');
    summarySection.className = 'summary-section';
    summarySection.innerHTML = `
        <div class="summary-header">
            <h3><i class="fas fa-chart-bar"></i> Branch Stock Transfer Summary</h3>
        </div>
        <div class="summary-cards">
            <div class="summary-card total">
                <div class="summary-card-title">Total Transfers</div>
                <div class="summary-card-value" id="totalTransfers">0</div>
            </div>
            <div class="summary-card pending">
                <div class="summary-card-title">Pending</div>
                <div class="summary-card-value" id="pendingTransfers">0</div>
            </div>
            <div class="summary-card approved">
                <div class="summary-card-title">Approved</div>
                <div class="summary-card-value" id="approvedTransfers">0</div>
            </div>
            <div class="summary-card completed">
                <div class="summary-card-title">Completed</div>
                <div class="summary-card-value" id="completedTransfers">0</div>
            </div>
            <div class="summary-card total">
                <div class="summary-card-title">Total Amount</div>
                <div class="summary-card-value" id="totalAmount">₹0.00</div>
            </div>
        </div>
    `;
    
    container.appendChild(summarySection);
}

function updateSummaryDisplay(total, pending, approved, completed, amount) {
    const totalEl = document.getElementById('totalTransfers');
    const pendingEl = document.getElementById('pendingTransfers');
    const approvedEl = document.getElementById('approvedTransfers');
    const completedEl = document.getElementById('completedTransfers');
    const amountEl = document.getElementById('totalAmount');
    
    if (totalEl) totalEl.textContent = total;
    if (pendingEl) pendingEl.textContent = pending;
    if (approvedEl) approvedEl.textContent = approved;
    if (completedEl) completedEl.textContent = completed;
    if (amountEl) amountEl.textContent = `₹${amount.toFixed(2)}`;
}

// Transfer Type Indicators
function initializeTransferTypeIndicators() {
    const typeCells = document.querySelectorAll('td:contains("1"), td:contains("0")');
    typeCells.forEach(cell => {
        const typeValue = cell.textContent.trim();
        let typeClass = '';
        let typeLabel = '';
        
        if (typeValue === '1') {
            typeClass = 'transfer';
            typeLabel = 'Transfer';
        } else if (typeValue === '0') {
            typeClass = 'consumable';
            typeLabel = 'Consumable';
        }
        
        if (typeClass) {
            cell.classList.add('transfer-type', typeClass);
            cell.textContent = typeLabel;
        }
    });
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
window.BranchGitModern = {
    validateSearchForm,
    showNotification,
    updateBranchStockSummary
};




