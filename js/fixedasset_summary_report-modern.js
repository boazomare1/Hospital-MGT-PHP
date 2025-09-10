// Fixed Asset Summary Report Modern JavaScript
// Handles form validation, responsive design, and enhanced user experience for fixed asset summary report management

document.addEventListener('DOMContentLoaded', function() {
    initializeSidebar();
    initializeMenuToggle();
    initializeFormValidation();
    initializeResponsiveDesign();
    initializeTouchSupport();
    initializeFormEnhancements();
    initializeDatePickers();
    initializeAssetSummaryTable();
    initializeSummaryCalculations();
    initializeExportFunctionality();
    initializeCategoryFilter();
    initializeQuickDateSelection();
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
    const searchForm = document.querySelector('form[action*="fixedasset_summary_report.php"]');
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
    const dateFromInput = document.getElementById('ADate1');
    const dateToInput = document.getElementById('ADate2');
    const categorySelect = document.getElementById('categoryid');
    
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
    
    // Validate category selection (if required)
    if (categorySelect && categorySelect.hasAttribute('required')) {
        if (!categorySelect.value) {
            showFieldError(categorySelect, 'Please select a category');
            isValid = false;
        } else {
            clearFieldError(categorySelect);
        }
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
    const tables = document.querySelectorAll('.asset-summary-table');
    tables.forEach(table => {
        if (!table.classList.contains('mobile-adjusted')) {
            table.classList.add('mobile-adjusted');
            addMobileTableEnhancements(table);
        }
    });
}

function restoreTableLayout() {
    const tables = document.querySelectorAll('.asset-summary-table');
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
                this.value = 'Generating Summary Report...';
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
            const categorySelect = document.getElementById('categoryid');
            if (categorySelect) {
                categorySelect.focus();
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
                document.querySelector('form[action*="fixedasset_summary_report.php"]').reset();
            }
        }
    });
}

function addFormResetConfirmation() {
    const form = document.querySelector('form[action*="fixedasset_summary_report.php"]');
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
        { label: 'Last Quarter', days: -90 },
        { label: 'Last Year', days: -365 },
        { label: 'Start of Month', type: 'monthStart' },
        { label: 'End of Month', type: 'monthEnd' },
        { label: 'Start of Year', type: 'yearStart' },
        { label: 'End of Year', type: 'yearEnd' }
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
            } else if (quickDate.type === 'yearStart') {
                targetDate = new Date();
                targetDate.setMonth(0, 1);
            } else if (quickDate.type === 'yearEnd') {
                targetDate = new Date();
                targetDate.setMonth(11, 31);
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

// Asset Summary Table Enhancement
function initializeAssetSummaryTable() {
    const tables = document.querySelectorAll('.asset-summary-table');
    tables.forEach(table => {
        addTableSorting(table);
        addSummaryValueFormatting(table);
        addRowHighlighting(table);
        addMobileEnhancements(table);
        addCategoryGrouping(table);
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
    
    // Sort rows (excluding category summaries and grand summary)
    const dataRows = rows.filter(row => !row.classList.contains('category-summary') && !row.classList.contains('grand-summary'));
    
    dataRows.sort((a, b) => {
        const aValue = a.cells[columnIndex]?.textContent.trim() || '';
        const bValue = b.cells[columnIndex]?.textContent.trim() || '';
        
        // Handle numeric values
        const aNum = parseFloat(aValue.replace(/[^0-9.-]+/g, ''));
        const bNum = parseFloat(bValue.replace(/[^0-9.-]+/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            if (newDirection === 'asc') {
                return aNum - bNum;
            } else {
                return bNum - aNum;
            }
        }
        
        // Handle text values
        if (newDirection === 'asc') {
            return aValue.localeCompare(bValue);
        } else {
            return bValue.localeCompare(aValue);
        }
    });
    
    // Reorder rows while preserving category summaries and grand summary
    const categorySummaries = rows.filter(row => row.classList.contains('category-summary'));
    const grandSummary = rows.filter(row => row.classList.contains('grand-summary'));
    
    // Clear tbody
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
    
    // Add sorted data rows
    dataRows.forEach(row => tbody.appendChild(row));
    
    // Add category summaries
    categorySummaries.forEach(row => tbody.appendChild(row));
    
    // Add grand summary
    grandSummary.forEach(row => tbody.appendChild(row));
}

function addSummaryValueFormatting(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const purchaseCostCell = row.querySelector('td:nth-child(2)'); // Purchase cost column
        const depreciationCell = row.querySelector('td:nth-child(3)'); // Depreciation column
        const netValueCell = row.querySelector('td:nth-child(4)'); // Net book value column
        const countCell = row.querySelector('td:nth-child(1)'); // Count column
        
        if (purchaseCostCell && purchaseCostCell.textContent.trim() !== '') {
            purchaseCostCell.classList.add('summary-purchase-cost');
        }
        
        if (depreciationCell && depreciationCell.textContent.trim() !== '') {
            depreciationCell.classList.add('summary-depreciation');
        }
        
        if (netValueCell && netValueCell.textContent.trim() !== '') {
            netValueCell.classList.add('summary-net-value');
            
            const netValue = parseFloat(netValueCell.textContent.replace(/[^0-9.-]+/g, ''));
            if (netValue < 0) {
                netValueCell.classList.add('negative');
            }
        }
        
        if (countCell && countCell.textContent.trim() !== '') {
            countCell.classList.add('summary-count');
        }
    });
}

function addRowHighlighting(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.classList.add('asset-summary-row');
        
        // Add hover effect
        row.addEventListener('mouseenter', function() {
            if (!this.classList.contains('category-summary') && !this.classList.contains('grand-summary')) {
                this.style.backgroundColor = '#f8f9fa';
            }
        });
        
        row.addEventListener('mouseleave', function() {
            if (!this.classList.contains('category-summary') && !this.classList.contains('grand-summary')) {
                this.style.backgroundColor = '';
            }
        });
    });
}

function addMobileEnhancements(table) {
    // Add mobile-specific enhancements
    if (window.innerWidth <= 768) {
        addMobileTableEnhancements(table);
    }
}

function addCategoryGrouping(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        // Check if this is a category summary row
        const firstCell = row.querySelector('td:first-child');
        if (firstCell && firstCell.textContent.includes('Group Total')) {
            row.classList.add('category-summary');
        }
        
        // Check if this is a grand summary row
        if (firstCell && firstCell.textContent.includes('Total :')) {
            row.classList.add('grand-summary');
        }
    });
}

// Summary Calculations
function initializeSummaryCalculations() {
    updateAssetSummary();
    addSummaryCards();
}

function updateAssetSummary() {
    const rows = document.querySelectorAll('.asset-summary-table tbody tr');
    let totalPurchaseCost = 0;
    let totalDepreciation = 0;
    let totalNetValue = 0;
    let totalAssetCount = 0;
    
    rows.forEach(row => {
        if (!row.classList.contains('category-summary') && !row.classList.contains('grand-summary')) {
            const countCell = row.querySelector('td:nth-child(1)');
            const purchaseCostCell = row.querySelector('td:nth-child(2)');
            const depreciationCell = row.querySelector('td:nth-child(3)');
            const netValueCell = row.querySelector('td:nth-child(4)');
            
            if (countCell && countCell.textContent.trim() !== '') {
                const count = parseInt(countCell.textContent.replace(/[^0-9]+/g, '')) || 0;
                totalAssetCount += count;
            }
            
            if (purchaseCostCell && purchaseCostCell.textContent.trim() !== '') {
                const cost = parseFloat(purchaseCostCell.textContent.replace(/[^0-9.-]+/g, '')) || 0;
                totalPurchaseCost += cost;
            }
            
            if (depreciationCell && depreciationCell.textContent.trim() !== '') {
                const depreciation = parseFloat(depreciationCell.textContent.replace(/[^0-9.-]+/g, '')) || 0;
                totalDepreciation += depreciation;
            }
            
            if (netValueCell && netValueCell.textContent.trim() !== '') {
                const netValue = parseFloat(netValueCell.textContent.replace(/[^0-9.-]+/g, '')) || 0;
                totalNetValue += netValue;
            }
        }
    });
    
    // Update summary display
    updateSummaryDisplay(totalPurchaseCost, totalDepreciation, totalNetValue, totalAssetCount);
}

function addSummaryCards() {
    const container = document.querySelector('.asset-summary-container') || document.body;
    const summarySection = document.createElement('section');
    summarySection.className = 'summary-section';
    summarySection.innerHTML = `
        <div class="summary-header">
            <h3><i class="fas fa-chart-pie"></i> Asset Summary Overview</h3>
        </div>
        <div class="summary-cards">
            <div class="summary-card count">
                <div class="summary-card-title">Total Asset Count</div>
                <div class="summary-card-value" id="totalAssetCount">0</div>
            </div>
            <div class="summary-card purchase-cost">
                <div class="summary-card-title">Total Purchase Cost</div>
                <div class="summary-card-value" id="totalPurchaseCost">$0.00</div>
            </div>
            <div class="summary-card depreciation">
                <div class="summary-card-title">Total Depreciation</div>
                <div class="summary-card-value" id="totalDepreciation">$0.00</div>
            </div>
            <div class="summary-card net-value">
                <div class="summary-card-title">Total Net Value</div>
                <div class="summary-card-value" id="totalNetValue">$0.00</div>
            </div>
        </div>
    `;
    
    container.appendChild(summarySection);
}

function updateSummaryDisplay(purchaseCost, depreciation, netValue, count) {
    const totalPurchaseCostEl = document.getElementById('totalPurchaseCost');
    const totalDepreciationEl = document.getElementById('totalDepreciation');
    const totalNetValueEl = document.getElementById('totalNetValue');
    const totalAssetCountEl = document.getElementById('totalAssetCount');
    
    if (totalAssetCountEl) totalAssetCountEl.textContent = count;
    if (totalPurchaseCostEl) totalPurchaseCostEl.textContent = formatCurrency(purchaseCost);
    if (totalDepreciationEl) totalDepreciationEl.textContent = formatCurrency(depreciation);
    if (totalNetValueEl) {
        totalNetValueEl.textContent = formatCurrency(netValue);
        totalNetValueEl.style.color = netValue >= 0 ? '#27ae60' : '#e74c3c';
    }
}

// Export Functionality
function initializeExportFunctionality() {
    addExportButtons();
}

function addExportButtons() {
    const container = document.querySelector('.asset-summary-container') || document.body;
    const exportSection = document.createElement('div');
    exportSection.className = 'export-section';
    exportSection.style.cssText = `
        background: #f8f9fa;
        padding: 1rem 2rem;
        border-top: 1px solid #e1e8ed;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    `;
    
    const exportTitle = document.createElement('h4');
    exportTitle.className = 'export-title';
    exportTitle.textContent = 'Export Options';
    
    const exportActions = document.createElement('div');
    exportActions.className = 'export-actions';
    exportActions.style.cssText = `
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    `;
    
    const exportButtons = [
        { label: 'Export to Excel', icon: 'fas fa-file-excel', action: 'exportToExcel', class: 'excel' },
        { label: 'Export to PDF', icon: 'fas fa-file-pdf', action: 'exportToPDF', class: 'pdf' },
        { label: 'Print Report', icon: 'fas fa-print', action: 'printReport', class: 'print' }
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
        
        if (buttonInfo.class === 'excel') {
            button.style.background = '#27ae60';
            button.style.color = 'white';
        } else if (buttonInfo.class === 'pdf') {
            button.style.background = '#e74c3c';
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
        
        exportActions.appendChild(button);
    });
    
    exportSection.appendChild(exportTitle);
    exportSection.appendChild(exportActions);
    container.appendChild(exportSection);
}

// Export Functions
function exportToExcel() {
    showNotification('Excel export functionality will be implemented here', 'info');
    // Implementation for Excel export
}

function exportToPDF() {
    showNotification('PDF export functionality will be implemented here', 'info');
    // Implementation for PDF export
}

function printReport() {
    window.print();
}

// Category Filter Enhancement
function initializeCategoryFilter() {
    const categorySelect = document.getElementById('categoryid');
    if (categorySelect) {
        addCategorySearchAndQuickSelection(categorySelect);
    }
}

function addCategorySearchAndQuickSelection(selectElement) {
    const container = selectElement.parentNode;
    container.classList.add('category-filter');
    
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Search categories...';
    searchInput.className = 'form-input category-search-input';
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
}

// Quick Date Selection
function initializeQuickDateSelection() {
    const dateInputs = document.querySelectorAll('input[type="date"], input[class*="datepicker"]');
    
    dateInputs.forEach(input => {
        if (!input.parentNode.querySelector('.quick-date-buttons')) {
            addQuickDateButtons(input);
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
window.FixedAssetSummaryReportModern = {
    validateSearchForm,
    showNotification,
    exportToExcel,
    exportToPDF,
    printReport
};




