// Billing Pending OP2 Modern JavaScript
// Handles form validation, responsive design, and enhanced user experience

document.addEventListener('DOMContentLoaded', function() {
    initializeFormValidation();
    initializeResponsiveDesign();
    initializeTouchSupport();
    initializeFormEnhancements();
    initializePatientSearch();
    initializeDatePickers();
    initializeTableEnhancements();
});

// Form Validation
function initializeFormValidation() {
    const searchForm = document.querySelector('form[name="cbform1"]');
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
    const patientInput = document.querySelector('input[name="patient"]');
    const patientCodeInput = document.querySelector('input[name="patientcode"]');
    const visitCodeInput = document.querySelector('input[name="visitcode"]');
    const dateFromInput = document.getElementById('ADate1');
    const dateToInput = document.getElementById('ADate2');
    
    // At least one search criteria should be provided
    const hasSearchCriteria = (patientInput && patientInput.value.trim()) ||
                            (patientCodeInput && patientCodeInput.value.trim()) ||
                            (visitCodeInput && visitCodeInput.value.trim()) ||
                            (dateFromInput && dateFromInput.value) ||
                            (dateToInput && dateToInput.value);
    
    if (!hasSearchCriteria) {
        showNotification('Please provide at least one search criteria', 'warning');
        isValid = false;
    }
    
    return isValid;
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
    const tables = document.querySelectorAll('.results-table table');
    tables.forEach(table => {
        if (!table.classList.contains('mobile-adjusted')) {
            table.classList.add('mobile-adjusted');
            addMobileTableEnhancements(table);
        }
    });
}

function addMobileTableEnhancements(table) {
    const rows = table.querySelectorAll('tr');
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

function restoreTableLayout() {
    const tables = document.querySelectorAll('.results-table table');
    tables.forEach(table => {
        table.classList.remove('mobile-adjusted');
        const cells = table.querySelectorAll('td[data-label]');
        cells.forEach(cell => {
            cell.removeAttribute('data-label');
        });
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
    const buttons = document.querySelectorAll('.action-btn, input[type="submit"], input[type="reset"]');
    buttons.forEach(button => {
        button.style.minHeight = '44px';
        button.style.minWidth = '44px';
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
    
    const resetButtons = document.querySelectorAll('input[type="reset"]');
    resetButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to reset the form?')) {
                e.preventDefault();
            }
        });
    });
}

// Patient Search
function initializePatientSearch() {
    const patientInput = document.querySelector('input[name="patient"]');
    const patientCodeInput = document.querySelector('input[name="patientcode"]');
    const visitCodeInput = document.querySelector('input[name="visitcode"]');
    
    if (patientInput) {
        patientInput.addEventListener('input', debounce(function() {
            const searchTerm = this.value.trim();
            if (searchTerm.length >= 2) {
                searchPatients(searchTerm, this);
            } else {
                hideSearchResults();
            }
        }, 300));
    }
    
    if (patientCodeInput) {
        patientCodeInput.addEventListener('input', debounce(function() {
            const searchTerm = this.value.trim();
            if (searchTerm.length >= 2) {
                searchPatientCodes(searchTerm, this);
            } else {
                hideSearchResults();
            }
        }, 300));
    }
    
    if (visitCodeInput) {
        visitCodeInput.addEventListener('input', debounce(function() {
            const searchTerm = this.value.trim();
            if (searchTerm.length >= 2) {
                searchVisitCodes(searchTerm, this);
            } else {
                hideSearchResults();
            }
        }, 300));
    }
}

function searchPatients(searchTerm, input) {
    const mockPatients = [
        { name: 'John Doe', code: 'P001', visitCode: 'V001' },
        { name: 'Jane Smith', code: 'P002', visitCode: 'V002' },
        { name: 'Mike Johnson', code: 'P003', visitCode: 'V003' }
    ];
    
    const filteredPatients = mockPatients.filter(patient => 
        patient.name.toLowerCase().includes(searchTerm.toLowerCase())
    );
    
    showSearchResults(filteredPatients, input, 'patient');
}

function searchPatientCodes(searchTerm, input) {
    const mockCodes = [
        { code: 'P001', name: 'John Doe', visitCode: 'V001' },
        { code: 'P002', name: 'Jane Smith', visitCode: 'V002' }
    ];
    
    const filteredCodes = mockCodes.filter(patient => 
        patient.code.toLowerCase().includes(searchTerm.toLowerCase())
    );
    
    showSearchResults(filteredCodes, input, 'code');
}

function searchVisitCodes(searchTerm, input) {
    const mockVisits = [
        { visitCode: 'V001', patientName: 'John Doe', patientCode: 'P001' },
        { visitCode: 'V002', patientName: 'Jane Smith', patientCode: 'P002' }
    ];
    
    const filteredVisits = mockVisits.filter(visit => 
        visit.visitCode.toLowerCase().includes(searchTerm.toLowerCase())
    );
    
    showSearchResults(filteredVisits, input, 'visit');
}

function showSearchResults(results, input, type) {
    hideSearchResults();
    
    if (results.length === 0) return;
    
    const container = input.parentNode;
    const resultsDiv = document.createElement('div');
    resultsDiv.className = 'search-results';
    
    results.forEach(result => {
        const item = document.createElement('div');
        item.className = 'search-result-item';
        
        if (type === 'patient') {
            item.innerHTML = `
                <div><strong>${result.name}</strong><br><small>Code: ${result.code}</small></div>
            `;
            item.addEventListener('click', () => selectSearchResult(result, input, type));
        } else if (type === 'code') {
            item.innerHTML = `
                <div><strong>${result.code}</strong><br><small>${result.name}</small></div>
            `;
            item.addEventListener('click', () => selectSearchResult(result, input, type));
        } else if (type === 'visit') {
            item.innerHTML = `
                <div><strong>${result.visitCode}</strong><br><small>${result.patientName}</small></div>
            `;
            item.addEventListener('click', () => selectSearchResult(result, input, type));
        }
        
        resultsDiv.appendChild(item);
    });
    
    container.appendChild(resultsDiv);
}

function selectSearchResult(result, input, type) {
    if (type === 'patient') {
        input.value = result.name;
        autoFillOtherFields(result.code, result.visitCode);
    } else if (type === 'code') {
        input.value = result.code;
        autoFillOtherFields(result.name, result.visitCode);
    } else if (type === 'visit') {
        input.value = result.visitCode;
        autoFillOtherFields(result.patientName, result.patientCode);
    }
    
    hideSearchResults();
}

function autoFillOtherFields(value1, value2) {
    const patientInput = document.querySelector('input[name="patient"]');
    const patientCodeInput = document.querySelector('input[name="patientcode"]');
    const visitCodeInput = document.querySelector('input[name="visitcode"]');
    
    if (patientInput && !patientInput.value) patientInput.value = value1;
    if (patientCodeInput && !patientCodeInput.value) patientCodeInput.value = value2;
    if (visitCodeInput && !visitCodeInput.value) visitCodeInput.value = value2;
}

function hideSearchResults() {
    const existingResults = document.querySelectorAll('.search-results');
    existingResults.forEach(result => result.remove());
}

// Date Picker Enhancements
function initializeDatePickers() {
    const dateInputs = document.querySelectorAll('#ADate1, #ADate2');
    
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
    
    const quickDates = [
        { label: 'Today', days: 0 },
        { label: 'Yesterday', days: -1 },
        { label: 'Last Week', days: -7 }
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

function isValidDate(dateString) {
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

// Table Enhancements
function initializeTableEnhancements() {
    const tables = document.querySelectorAll('.results-table table');
    tables.forEach(table => {
        addTableSorting(table);
        addStatusIndicators(table);
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
    
    table.querySelectorAll('.sort-indicator').forEach(indicator => {
        indicator.innerHTML = ' ↕';
        indicator.style.color = '#999';
    });
    
    const clickedHeader = table.querySelector(`th:nth-child(${columnIndex + 1})`);
    const indicator = clickedHeader.querySelector('.sort-indicator');
    
    const currentDirection = indicator.getAttribute('data-direction') || 'none';
    const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
    
    indicator.setAttribute('data-direction', newDirection);
    indicator.innerHTML = newDirection === 'asc' ? ' ↑' : ' ↓';
    indicator.style.color = '#3498db';
    
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex]?.textContent.trim() || '';
        const bValue = b.cells[columnIndex]?.textContent.trim() || '';
        
        if (newDirection === 'asc') {
            return aValue.localeCompare(bValue);
        } else {
            return bValue.localeCompare(aValue);
        }
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

function addStatusIndicators(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const statusCell = row.querySelector('td:last-child');
        if (statusCell && statusCell.textContent.includes('Awaiting')) {
            const statusBadge = document.createElement('span');
            statusBadge.className = 'status-badge status-awaiting';
            statusBadge.textContent = 'Awaiting';
            statusCell.appendChild(statusBadge);
        }
    });
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
window.BillingPendingOp2Modern = {
    validateSearchForm,
    showNotification,
    searchPatients,
    searchPatientCodes,
    searchVisitCodes
};
