// Branch Stock Request Modern JavaScript
// Handles form validation, responsive design, and enhanced user experience for branch stock request management

document.addEventListener('DOMContentLoaded', function() {
    initializeFormValidation();
    initializeResponsiveDesign();
    initializeDatePickers();
    initializeStockRequestTable();
    initializeSummaryCalculations();
    initializeRequestTypeIndicators();
    initializeStatusIndicators();
});

// Form Validation
function initializeFormValidation() {
    const searchForm = document.querySelector('form[action*="branchstockrequest.php"]');
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
    const storeCodeInput = document.getElementById('searchstorecode');
    
    // Validate date range
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
    
    // Validate store code (if required)
    if (storeCodeInput && storeCodeInput.hasAttribute('required')) {
        if (!storeCodeInput.value.trim()) {
            showFieldError(storeCodeInput, 'Store code is required');
            isValid = false;
        } else {
            clearFieldError(storeCodeInput);
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
    const tables = document.querySelectorAll('.stock-request-table');
    tables.forEach(table => {
        if (!table.classList.contains('mobile-adjusted')) {
            table.classList.add('mobile-adjusted');
            addMobileTableEnhancements(table);
        }
    });
}

function restoreTableLayout() {
    const tables = document.querySelectorAll('.stock-request-table');
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

// Stock Request Table Enhancement
function initializeStockRequestTable() {
    const tables = document.querySelectorAll('.stock-request-table');
    tables.forEach(table => {
        addTableSorting(table);
        addRequestStatusIndicators(table);
        addRowHighlighting(table);
        addRequestTypeIndicators(table);
        addQuantityIndicators(table);
        addPriorityIndicators(table);
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

function addRequestStatusIndicators(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const statusCell = row.querySelector('td:contains("pending"), td:contains("approved"), td:contains("rejected"), td:contains("completed"), td:contains("in progress"), td:contains("cancelled")');
        
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
            } else if (statusText.includes('in progress')) {
                statusClass = 'status-in-progress';
            } else if (statusText.includes('cancelled')) {
                statusClass = 'status-cancelled';
            }
            
            if (statusClass) {
                statusCell.classList.add('request-status', statusClass);
            }
        }
    });
}

function addRequestTypeIndicators(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const typeCell = row.querySelector('td:contains("1"), td:contains("0"), td:contains("transfer"), td:contains("consumable"), td:contains("return")');
        
        if (typeCell) {
            const typeValue = typeCell.textContent.trim().toLowerCase();
            let typeClass = '';
            let typeLabel = '';
            
            if (typeValue === '1' || typeValue.includes('transfer')) {
                typeClass = 'transfer';
                typeLabel = 'Transfer';
            } else if (typeValue === '0' || typeValue.includes('consumable')) {
                typeClass = 'consumable';
                typeLabel = 'Consumable';
            } else if (typeValue.includes('return')) {
                typeClass = 'return';
                typeLabel = 'Return';
            }
            
            if (typeClass) {
                typeCell.classList.add('request-type', typeClass);
                typeCell.textContent = typeLabel;
            }
        }
    });
}

function addPriorityIndicators(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        cells.forEach(cell => {
            const cellText = cell.textContent.trim().toLowerCase();
            
            if (cellText.includes('urgent') || cellText.includes('high')) {
                cell.classList.add('priority-urgent');
            } else if (cellText.includes('normal') || cellText.includes('medium')) {
                cell.classList.add('priority-normal');
            } else if (cellText.includes('low')) {
                cell.classList.add('priority-low');
            }
        });
    });
}

function addQuantityIndicators(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        cells.forEach(cell => {
            const cellText = cell.textContent.trim();
            
            // Check for quantities
            if (/^\d+$/.test(cellText)) {
                const quantity = parseInt(cellText);
                if (!isNaN(quantity)) {
                    cell.classList.add('quantity-display');
                    
                    if (quantity > 100) {
                        cell.classList.add('quantity-high');
                    } else if (quantity > 50) {
                        cell.classList.add('quantity-medium');
                    } else {
                        cell.classList.add('quantity-low');
                    }
                }
            }
        });
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
    updateStockRequestSummary();
    addSummaryCards();
}

function updateStockRequestSummary() {
    const rows = document.querySelectorAll('.stock-request-table tbody tr');
    let totalRequests = 0;
    let pendingRequests = 0;
    let approvedRequests = 0;
    let completedRequests = 0;
    let rejectedRequests = 0;
    let cancelledRequests = 0;
    let totalAmount = 0;
    let totalQuantity = 0;
    
    rows.forEach(row => {
        totalRequests++;
        
        const statusCell = row.querySelector('.request-status');
        if (statusCell) {
            if (statusCell.classList.contains('status-pending')) {
                pendingRequests++;
            } else if (statusCell.classList.contains('status-approved')) {
                approvedRequests++;
            } else if (statusCell.classList.contains('status-completed')) {
                completedRequests++;
            } else if (statusCell.classList.contains('status-rejected')) {
                rejectedRequests++;
            } else if (statusCell.classList.contains('status-cancelled')) {
                cancelledRequests++;
            }
        }
        
        // Calculate total amount and quantity
        const cells = row.querySelectorAll('td');
        cells.forEach(cell => {
            const cellText = cell.textContent.trim();
            
            // Check for amounts
            if (cellText.includes('₹') || cellText.includes('.') || /^\d+$/.test(cellText)) {
                const amount = parseFloat(cellText.replace(/[^0-9.-]+/g, ''));
                if (!isNaN(amount) && amount > 0) {
                    totalAmount += amount;
                }
            }
            
            // Check for quantities
            if (/^\d+$/.test(cellText)) {
                const quantity = parseInt(cellText);
                if (!isNaN(quantity)) {
                    totalQuantity += quantity;
                }
            }
        });
    });
    
    updateSummaryDisplay(totalRequests, pendingRequests, approvedRequests, completedRequests, rejectedRequests, cancelledRequests, totalAmount, totalQuantity);
}

function addSummaryCards() {
    const container = document.querySelector('.branchstockrequest-container') || document.body;
    const summarySection = document.createElement('section');
    summarySection.className = 'summary-section';
    summarySection.innerHTML = `
        <div class="summary-header">
            <h3><i class="fas fa-clipboard-list"></i> Stock Request Summary</h3>
        </div>
        <div class="summary-cards">
            <div class="summary-card total">
                <div class="summary-card-title">Total Requests</div>
                <div class="summary-card-value" id="totalRequests">0</div>
            </div>
            <div class="summary-card pending">
                <div class="summary-card-title">Pending</div>
                <div class="summary-card-value" id="pendingRequests">0</div>
            </div>
            <div class="summary-card approved">
                <div class="summary-card-title">Approved</div>
                <div class="summary-card-value" id="approvedRequests">0</div>
            </div>
            <div class="summary-card completed">
                <div class="summary-card-title">Completed</div>
                <div class="summary-card-value" id="completedRequests">0</div>
            </div>
            <div class="summary-card rejected">
                <div class="summary-card-title">Rejected</div>
                <div class="summary-card-value" id="rejectedRequests">0</div>
            </div>
            <div class="summary-card cancelled">
                <div class="summary-card-title">Cancelled</div>
                <div class="summary-card-value" id="cancelledRequests">0</div>
            </div>
            <div class="summary-card total">
                <div class="summary-card-title">Total Amount</div>
                <div class="summary-card-value" id="totalAmount">₹0.00</div>
            </div>
            <div class="summary-card total">
                <div class="summary-card-title">Total Quantity</div>
                <div class="summary-card-value" id="totalQuantity">0</div>
            </div>
        </div>
    `;
    
    container.appendChild(summarySection);
}

function updateSummaryDisplay(total, pending, approved, completed, rejected, cancelled, amount, quantity) {
    const totalEl = document.getElementById('totalRequests');
    const pendingEl = document.getElementById('pendingRequests');
    const approvedEl = document.getElementById('approvedRequests');
    const completedEl = document.getElementById('completedRequests');
    const rejectedEl = document.getElementById('rejectedRequests');
    const cancelledEl = document.getElementById('cancelledRequests');
    const amountEl = document.getElementById('totalAmount');
    const quantityEl = document.getElementById('totalQuantity');
    
    if (totalEl) totalEl.textContent = total;
    if (pendingEl) pendingEl.textContent = pending;
    if (approvedEl) approvedEl.textContent = approved;
    if (completedEl) completedEl.textContent = completed;
    if (rejectedEl) rejectedEl.textContent = rejected;
    if (cancelledEl) cancelledEl.textContent = cancelled;
    if (amountEl) amountEl.textContent = `₹${amount.toFixed(2)}`;
    if (quantityEl) quantityEl.textContent = quantity;
}

// Request Type Indicators
function initializeRequestTypeIndicators() {
    const typeCells = document.querySelectorAll('td:contains("1"), td:contains("0"), td:contains("transfer"), td:contains("consumable"), td:contains("return")');
    typeCells.forEach(cell => {
        const typeValue = cell.textContent.trim().toLowerCase();
        let typeClass = '';
        let typeLabel = '';
        
        if (typeValue === '1' || typeValue.includes('transfer')) {
            typeClass = 'transfer';
            typeLabel = 'Transfer';
        } else if (typeValue === '0' || typeValue.includes('consumable')) {
            typeClass = 'consumable';
            typeLabel = 'Consumable';
        } else if (typeValue.includes('return')) {
            typeClass = 'return';
            typeLabel = 'Return';
        }
        
        if (typeClass) {
            cell.classList.add('request-type', typeClass);
            cell.textContent = typeLabel;
        }
    });
}

// Status Indicators
function initializeStatusIndicators() {
    addRequestSummary();
}

function addRequestSummary() {
    const container = document.querySelector('.branchstockrequest-container') || document.body;
    const requestSection = document.createElement('section');
    requestSection.className = 'request-summary';
    requestSection.innerHTML = `
        <h3><i class="fas fa-chart-pie"></i> Request Analysis</h3>
        <div class="request-grid">
            <div class="request-item pending">
                <div class="request-item-label">Pending Analysis</div>
                <div class="request-item-value" id="pendingAnalysis">0</div>
            </div>
            <div class="request-item approved">
                <div class="request-item-label">Approval Rate</div>
                <div class="request-item-value" id="approvalRate">0%</div>
            </div>
            <div class="request-item completed">
                <div class="request-item-label">Completion Rate</div>
                <div class="request-item-value" id="completionRate">0%</div>
            </div>
            <div class="request-item rejected">
                <div class="request-item-label">Rejection Rate</div>
                <div class="request-item-value" id="rejectionRate">0%</div>
            </div>
            <div class="request-item cancelled">
                <div class="request-item-label">Cancellation Rate</div>
                <div class="request-item-value" id="cancellationRate">0%</div>
            </div>
        </div>
    `;
    
    container.appendChild(requestSection);
    
    // Calculate and update request metrics
    updateRequestMetrics();
}

function updateRequestMetrics() {
    const totalEl = document.getElementById('totalRequests');
    const pendingEl = document.getElementById('pendingRequests');
    const approvedEl = document.getElementById('approvedRequests');
    const completedEl = document.getElementById('completedRequests');
    const rejectedEl = document.getElementById('rejectedRequests');
    const cancelledEl = document.getElementById('cancelledRequests');
    
    if (totalEl && pendingEl && approvedEl && completedEl && rejectedEl && cancelledEl) {
        const total = parseInt(totalEl.textContent);
        const pending = parseInt(pendingEl.textContent);
        const approved = parseInt(approvedEl.textContent);
        const completed = parseInt(completedEl.textContent);
        const rejected = parseInt(rejectedEl.textContent);
        const cancelled = parseInt(cancelledEl.textContent);
        
        if (!isNaN(total) && total > 0) {
            const approvalRate = ((approved + completed) / total * 100);
            const completionRate = (completed / total * 100);
            const rejectionRate = (rejected / total * 100);
            const cancellationRate = (cancelled / total * 100);
            
            const approvalRateEl = document.getElementById('approvalRate');
            const completionRateEl = document.getElementById('completionRate');
            const rejectionRateEl = document.getElementById('rejectionRate');
            const cancellationRateEl = document.getElementById('cancellationRate');
            
            if (approvalRateEl) approvalRateEl.textContent = `${approvalRate.toFixed(1)}%`;
            if (completionRateEl) completionRateEl.textContent = `${completionRate.toFixed(1)}%`;
            if (rejectionRateEl) rejectionRateEl.textContent = `${rejectionRate.toFixed(1)}%`;
            if (cancellationRateEl) cancellationRateEl.textContent = `${cancellationRate.toFixed(1)}%`;
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
window.BranchStockRequestModern = {
    validateSearchForm,
    showNotification,
    updateStockRequestSummary,
    updateRequestMetrics
};




