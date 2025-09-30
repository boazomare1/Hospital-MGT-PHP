/**
 * Doctor Statement Summary - Modern JavaScript
 * Handles interactive functionality for the doctor statement summary page
 */

document.addEventListener('DOMContentLoaded', function() {
    initializePage();
    setupEventListeners();
    setupFormValidation();
    setupTableInteractions();
});

/**
 * Initialize page components
 */
function initializePage() {
    // Initialize sidebar state
    const sidebar = document.getElementById('leftSidebar');
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    // Check if sidebar should be collapsed on mobile
    if (window.innerWidth <= 768) {
        sidebar.classList.add('collapsed');
    }
    
    // Setup sidebar toggle functionality
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleSidebar);
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    // Initialize tooltips and other interactive elements
    initializeTooltips();
    
    // Setup responsive behavior
    setupResponsiveBehavior();
}

/**
 * Setup event listeners
 */
function setupEventListeners() {
    // Form submission handling
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', handleFormSubmission);
    }
    
    // Date input validation
    const dateInputs = document.querySelectorAll('.date-input');
    dateInputs.forEach(input => {
        input.addEventListener('change', validateDateRange);
        input.addEventListener('blur', validateDateRange);
    });
    
    // Doctor search input
    const doctorSearchInput = document.getElementById('searchsuppliername');
    if (doctorSearchInput) {
        doctorSearchInput.addEventListener('input', handleDoctorSearch);
        doctorSearchInput.addEventListener('keydown', handleDoctorSearchKeydown);
    }
    
    // Location selection
    const locationSelect = document.getElementById('location');
    if (locationSelect) {
        locationSelect.addEventListener('change', handleLocationChange);
    }
    
    // Export functionality
    const exportButtons = document.querySelectorAll('[onclick*="exportToExcel"]');
    exportButtons.forEach(button => {
        button.addEventListener('click', handleExportToExcel);
    });
    
    // Refresh functionality
    const refreshButtons = document.querySelectorAll('[onclick*="refreshPage"]');
    refreshButtons.forEach(button => {
        button.addEventListener('click', handleRefreshPage);
    });
}

/**
 * Setup form validation
 */
function setupFormValidation() {
    const form = document.querySelector('.search-form');
    if (!form) return;
    
    // Add real-time validation
    const inputs = form.querySelectorAll('.form-input');
    inputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', clearFieldError);
    });
    
    // Add form submission validation
    form.addEventListener('submit', validateForm);
}

/**
 * Setup table interactions
 */
function setupTableInteractions() {
    const table = document.querySelector('.modern-table');
    if (!table) return;
    
    // Add row hover effects
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', highlightRow);
        row.addEventListener('mouseleave', unhighlightRow);
    });
    
    // Add sorting functionality (if needed)
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        if (index > 1) { // Skip No. and Doctor columns
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => sortTable(index));
        }
    });
    
    // Add aging analysis visual indicators
    addAgingIndicators();
}

/**
 * Toggle sidebar visibility
 */
function toggleSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const menuToggle = document.getElementById('menuToggle');
    
    if (sidebar) {
        sidebar.classList.toggle('collapsed');
        
        // Update menu toggle icon
        if (menuToggle) {
            const icon = menuToggle.querySelector('i');
            if (icon) {
                if (sidebar.classList.contains('collapsed')) {
                    icon.className = 'fas fa-bars';
                } else {
                    icon.className = 'fas fa-times';
                }
            }
        }
    }
}

/**
 * Handle form submission
 */
function handleFormSubmission(event) {
    const form = event.target;
    
    // Show loading state
    showLoadingState();
    
    // Validate form before submission
    if (!validateForm(event)) {
        event.preventDefault();
        hideLoadingState();
        return false;
    }
    
    // Add form data to URL for better UX
    const formData = new FormData(form);
    const params = new URLSearchParams(formData);
    
    // Show success message
    showAlert('Generating doctor statement summary...', 'info');
    
    return true;
}

/**
 * Validate form
 */
function validateForm(event) {
    const form = event.target;
    let isValid = true;
    
    // Clear previous errors
    clearFormErrors();
    
    // Validate date range
    const dateFrom = form.querySelector('#ADate1');
    const dateTo = form.querySelector('#ADate2');
    
    if (dateFrom && dateTo) {
        if (!validateDateRange()) {
            isValid = false;
        }
    }
    
    // Validate doctor selection (optional)
    const doctorInput = form.querySelector('#searchsuppliername');
    if (doctorInput && doctorInput.value.trim() === '') {
        // Doctor selection is optional, so this is just a warning
        showAlert('No doctor selected - will show all doctors', 'info');
    }
    
    return isValid;
}

/**
 * Validate date range
 */
function validateDateRange() {
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
    if (!dateFrom || !dateTo) return true;
    
    const fromDate = new Date(dateFrom.value);
    const toDate = new Date(dateTo.value);
    const today = new Date();
    
    // Check if dates are valid
    if (isNaN(fromDate.getTime()) || isNaN(toDate.getTime())) {
        showFieldError(dateFrom, 'Please enter valid dates');
        showFieldError(dateTo, 'Please enter valid dates');
        return false;
    }
    
    // Check if from date is not in the future
    if (fromDate > today) {
        showFieldError(dateFrom, 'From date cannot be in the future');
        return false;
    }
    
    // Check if to date is not in the future
    if (toDate > today) {
        showFieldError(dateTo, 'To date cannot be in the future');
        return false;
    }
    
    // Check if from date is not after to date
    if (fromDate > toDate) {
        showFieldError(dateFrom, 'From date cannot be after To date');
        showFieldError(dateTo, 'To date cannot be before From date');
        return false;
    }
    
    // Check if date range is not too large (more than 2 years)
    const diffTime = Math.abs(toDate - fromDate);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    if (diffDays > 730) { // 2 years
        showAlert('Date range is quite large. This may take some time to process.', 'info');
    }
    
    return true;
}

/**
 * Validate individual field
 */
function validateField(event) {
    const field = event.target;
    const value = field.value.trim();
    
    // Clear previous errors
    clearFieldError(event);
    
    // Validate based on field type
    if (field.type === 'date') {
        if (value && isNaN(new Date(value).getTime())) {
            showFieldError(field, 'Please enter a valid date');
            return false;
        }
    }
    
    return true;
}

/**
 * Clear field error
 */
function clearFieldError(event) {
    const field = event.target;
    const errorElement = field.parentNode.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
    field.classList.remove('error');
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    // Remove existing error
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Add error class
    field.classList.add('error');
    
    // Create error message
    const errorElement = document.createElement('div');
    errorElement.className = 'field-error';
    errorElement.textContent = message;
    errorElement.style.color = '#dc2626';
    errorElement.style.fontSize = '0.8rem';
    errorElement.style.marginTop = '0.25rem';
    
    // Insert error message
    field.parentNode.appendChild(errorElement);
}

/**
 * Clear all form errors
 */
function clearFormErrors() {
    const errorElements = document.querySelectorAll('.field-error');
    errorElements.forEach(element => element.remove());
    
    const errorFields = document.querySelectorAll('.form-input.error');
    errorFields.forEach(field => field.classList.remove('error'));
}

/**
 * Handle doctor search
 */
function handleDoctorSearch(event) {
    const input = event.target;
    const value = input.value.trim();
    
    // Clear previous suggestions
    clearDoctorSuggestions();
    
    if (value.length >= 2) {
        // Show loading indicator
        showDoctorSearchLoading();
        
        // Simulate search (in real implementation, this would be an AJAX call)
        setTimeout(() => {
            hideDoctorSearchLoading();
            // The autocomplete functionality is handled by the existing autocomplete_doctor.js
        }, 500);
    }
}

/**
 * Handle doctor search keydown
 */
function handleDoctorSearchKeydown(event) {
    // Allow autocomplete to handle navigation
    if (event.key === 'ArrowDown' || event.key === 'ArrowUp' || event.key === 'Enter') {
        return; // Let autocomplete handle this
    }
    
    // Clear suggestions on escape
    if (event.key === 'Escape') {
        clearDoctorSuggestions();
    }
}

/**
 * Handle location change
 */
function handleLocationChange(event) {
    const location = event.target.value;
    
    if (location && location !== 'All') {
        showAlert(`Filtering results for location: ${event.target.options[event.target.selectedIndex].text}`, 'info');
    } else {
        showAlert('Showing results for all locations', 'info');
    }
}

/**
 * Handle export to Excel
 */
function handleExportToExcel(event) {
    event.preventDefault();
    
    const form = document.querySelector('.search-form');
    if (!form) return;
    
    // Validate form before export
    if (!validateForm({ target: form })) {
        showAlert('Please fix form errors before exporting', 'error');
        return;
    }
    
    // Show loading state
    showLoadingState();
    
    // Get form data
    const formData = new FormData(form);
    const params = new URLSearchParams(formData);
    
    // Create export URL
    const exportUrl = `fulldrstatementsummary_excel.php?${params.toString()}`;
    
    // Open export in new window
    const exportWindow = window.open(exportUrl, '_blank');
    
    if (exportWindow) {
        showAlert('Export started. Please wait for the file to download.', 'success');
    } else {
        showAlert('Please allow popups for this site to enable export functionality.', 'error');
    }
    
    hideLoadingState();
}

/**
 * Handle refresh page
 */
function handleRefreshPage(event) {
    event.preventDefault();
    
    // Show loading state
    showLoadingState();
    
    // Reload page after a short delay
    setTimeout(() => {
        window.location.reload();
    }, 500);
}

/**
 * Reset form
 */
function resetForm() {
    const form = document.querySelector('.search-form');
    if (!form) return;
    
    // Reset all form fields
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        if (input.type === 'hidden') return;
        
        if (input.type === 'date') {
            // Set default dates
            if (input.id === 'ADate1') {
                const oneMonthAgo = new Date();
                oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
                input.value = oneMonthAgo.toISOString().split('T')[0];
            } else if (input.id === 'ADate2') {
                input.value = new Date().toISOString().split('T')[0];
            }
        } else if (input.type === 'text') {
            input.value = '';
        } else if (input.tagName === 'SELECT') {
            input.selectedIndex = 0;
        }
    });
    
    // Clear any errors
    clearFormErrors();
    
    // Clear results
    const resultsSection = document.querySelector('.results-section');
    if (resultsSection) {
        resultsSection.remove();
    }
    
    showAlert('Form has been reset', 'success');
}

/**
 * Show loading state
 */
function showLoadingState() {
    const body = document.body;
    body.classList.add('loading');
    
    // Create loading overlay
    const loadingOverlay = document.createElement('div');
    loadingOverlay.id = 'loadingOverlay';
    loadingOverlay.innerHTML = `
        <div class="loading-content">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <p><strong>Processing...</strong></p>
            <p>Please wait while we generate your report</p>
        </div>
    `;
    loadingOverlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        color: white;
        text-align: center;
    `;
    
    document.body.appendChild(loadingOverlay);
}

/**
 * Hide loading state
 */
function hideLoadingState() {
    const body = document.body;
    body.classList.remove('loading');
    
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.remove();
    }
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    // Remove existing alerts
    const existingAlerts = alertContainer.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    
    const iconClass = {
        'success': 'check-circle',
        'error': 'exclamation-triangle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    }[type] || 'info-circle';
    
    alert.innerHTML = `
        <i class="fas fa-${iconClass} alert-icon"></i>
        <span>${message}</span>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // Add close button styles
    const closeButton = alert.querySelector('.alert-close');
    closeButton.style.cssText = `
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        margin-left: auto;
        padding: 0.25rem;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    // Add tooltips to table headers
    const tableHeaders = document.querySelectorAll('.modern-table th');
    tableHeaders.forEach(header => {
        const text = header.textContent.trim();
        let tooltip = '';
        
        switch (text) {
            case '30 Days':
                tooltip = 'Outstanding amounts within 30 days';
                break;
            case '60 Days':
                tooltip = 'Outstanding amounts between 31-60 days';
                break;
            case '90 Days':
                tooltip = 'Outstanding amounts between 61-90 days';
                break;
            case '120 Days':
                tooltip = 'Outstanding amounts between 91-120 days';
                break;
            case '180 Days':
                tooltip = 'Outstanding amounts between 121-180 days';
                break;
            case '180+ Days':
                tooltip = 'Outstanding amounts over 180 days';
                break;
        }
        
        if (tooltip) {
            header.title = tooltip;
            header.style.cursor = 'help';
        }
    });
}

/**
 * Setup responsive behavior
 */
function setupResponsiveBehavior() {
    let resizeTimeout;
    
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            const sidebar = document.getElementById('leftSidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (window.innerWidth <= 768) {
                if (sidebar && !sidebar.classList.contains('collapsed')) {
                    sidebar.classList.add('collapsed');
                }
                if (menuToggle) {
                    const icon = menuToggle.querySelector('i');
                    if (icon) {
                        icon.className = 'fas fa-bars';
                    }
                }
            } else {
                if (sidebar && sidebar.classList.contains('collapsed')) {
                    sidebar.classList.remove('collapsed');
                }
            }
        }, 250);
    });
}

/**
 * Highlight table row
 */
function highlightRow(event) {
    const row = event.target.closest('tr');
    if (row && !row.classList.contains('totals-row')) {
        row.style.backgroundColor = '#e0f2fe';
        row.style.transform = 'scale(1.01)';
        row.style.transition = 'all 0.2s ease';
    }
}

/**
 * Unhighlight table row
 */
function unhighlightRow(event) {
    const row = event.target.closest('tr');
    if (row && !row.classList.contains('totals-row')) {
        row.style.backgroundColor = '';
        row.style.transform = '';
    }
}

/**
 * Sort table by column
 */
function sortTable(columnIndex) {
    const table = document.querySelector('.modern-table');
    if (!table) return;
    
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Skip totals row
    const dataRows = rows.filter(row => !row.classList.contains('totals-row'));
    const totalsRow = rows.find(row => row.classList.contains('totals-row'));
    
    // Sort data rows
    dataRows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();
        
        // Handle numeric values
        if (columnIndex >= 2) { // Amount columns
            const aNum = parseFloat(aValue.replace(/,/g, ''));
            const bNum = parseFloat(bValue.replace(/,/g, ''));
            return bNum - aNum; // Descending order for amounts
        }
        
        // Handle text values
        return aValue.localeCompare(bValue);
    });
    
    // Rebuild tbody
    tbody.innerHTML = '';
    dataRows.forEach(row => tbody.appendChild(row));
    if (totalsRow) tbody.appendChild(totalsRow);
    
    // Update header to show sort direction
    const headers = table.querySelectorAll('th');
    headers.forEach(header => header.classList.remove('sorted-asc', 'sorted-desc'));
    headers[columnIndex].classList.add('sorted-desc');
}

/**
 * Add aging indicators to table
 */
function addAgingIndicators() {
    const table = document.querySelector('.modern-table');
    if (!table) return;
    
    const rows = table.querySelectorAll('tbody tr:not(.totals-row)');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        for (let i = 3; i < cells.length; i++) { // Start from 30 days column
            const cell = cells[i];
            const value = parseFloat(cell.textContent.replace(/,/g, ''));
            
            if (value > 0) {
                const indicator = document.createElement('span');
                indicator.className = 'aging-indicator';
                
                switch (i) {
                    case 3: indicator.classList.add('aging-30'); break;
                    case 4: indicator.classList.add('aging-60'); break;
                    case 5: indicator.classList.add('aging-90'); break;
                    case 6: indicator.classList.add('aging-120'); break;
                    case 7: indicator.classList.add('aging-180'); break;
                    case 8: indicator.classList.add('aging-180-plus'); break;
                }
                
                cell.insertBefore(indicator, cell.firstChild);
            }
        }
    });
}

/**
 * Clear doctor suggestions
 */
function clearDoctorSuggestions() {
    // This would integrate with the existing autocomplete system
    const suggestions = document.querySelectorAll('.autocomplete-suggestion');
    suggestions.forEach(suggestion => suggestion.remove());
}

/**
 * Show doctor search loading
 */
function showDoctorSearchLoading() {
    const input = document.getElementById('searchsuppliername');
    if (input) {
        input.style.backgroundImage = 'url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Cpath fill=\'%23666\' d=\'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z\'/%3E%3C/svg%3E")';
        input.style.backgroundRepeat = 'no-repeat';
        input.style.backgroundPosition = 'right 10px center';
        input.style.backgroundSize = '16px';
    }
}

/**
 * Hide doctor search loading
 */
function hideDoctorSearchLoading() {
    const input = document.getElementById('searchsuppliername');
    if (input) {
        input.style.backgroundImage = '';
    }
}

/**
 * Export to Excel (alternative method)
 */
function exportToExcel() {
    const form = document.querySelector('.search-form');
    if (!form) return;
    
    // Validate form
    if (!validateForm({ target: form })) {
        showAlert('Please fix form errors before exporting', 'error');
        return;
    }
    
    // Get form data and create export URL
    const formData = new FormData(form);
    const params = new URLSearchParams(formData);
    const exportUrl = `fulldrstatementsummary_excel.php?${params.toString()}`;
    
    // Create temporary link and click it
    const link = document.createElement('a');
    link.href = exportUrl;
    link.download = 'doctor_statement_summary.xlsx';
    link.style.display = 'none';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showAlert('Export started. Please wait for the file to download.', 'success');
}

/**
 * Refresh page
 */
function refreshPage() {
    showLoadingState();
    setTimeout(() => {
        window.location.reload();
    }, 500);
}

// Global functions for backward compatibility
window.exportToExcel = exportToExcel;
window.refreshPage = refreshPage;
window.resetForm = resetForm;






