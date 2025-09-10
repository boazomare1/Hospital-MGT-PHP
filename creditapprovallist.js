/**
 * Modern JavaScript for Credit Approval List
 * Handles search functionality, table interactions, and form management
 */

class CreditApprovalListManager {
    constructor() {
        this.form = null;
        this.searchInputs = [];
        this.locationSelect = null;
        this.table = null;
        this.currentFilters = {};
        
        this.init();
    }

    init() {
        this.initializeElements();
        this.setupEventListeners();
        this.setupFormValidation();
        this.setupTableInteractions();
        this.initializeSearch();
    }

    initializeElements() {
        // Get form
        this.form = document.querySelector('form[name="cbform1"]');
        
        // Get search inputs
        this.searchInputs = {
            patient: document.querySelector('input[name="patient"]'),
            patientcode: document.querySelector('input[name="patientcode"]'),
            visitcode: document.querySelector('input[name="visitcode"]'),
            dateFrom: document.querySelector('input[name="ADate1"]'),
            dateTo: document.querySelector('input[name="ADate2"]')
        };
        
        // Get location select
        this.locationSelect = document.querySelector('select[name="location"]');
        
        // Get table
        this.table = document.querySelector('table');
        
        // Filter out null elements
        Object.keys(this.searchInputs).forEach(key => {
            if (!this.searchInputs[key]) {
                delete this.searchInputs[key];
            }
        });
    }

    setupEventListeners() {
        // Form submission
        if (this.form) {
            this.form.addEventListener('submit', (e) => {
                if (!this.validateForm()) {
                    e.preventDefault();
                    return false;
                }
                this.showLoadingState();
            });
        }

        // Search input changes
        Object.values(this.searchInputs).forEach(input => {
            if (input) {
                input.addEventListener('input', this.debounce((e) => {
                    this.handleSearchInput(e.target);
                }, 300));
                
                input.addEventListener('blur', (e) => {
                    this.validateInput(e.target);
                });
            }
        });

        // Location change
        if (this.locationSelect) {
            this.locationSelect.addEventListener('change', (e) => {
                this.handleLocationChange(e.target.value);
            });
        }

        // Reset button
        const resetButton = document.getElementById('resetbutton');
        if (resetButton) {
            resetButton.addEventListener('click', () => {
                this.resetForm();
            });
        }

        // Action button clicks
        this.setupActionButtons();
    }

    setupFormValidation() {
        // Add CSS for validation states
        const style = document.createElement('style');
        style.textContent = `
            .form-control.is-invalid {
                border-color: #ef4444;
                box-shadow: 0 0 0 3px rgb(239 68 68 / 0.1);
            }
            
            .form-control.is-valid {
                border-color: #10b981;
                box-shadow: 0 0 0 3px rgb(16 185 129 / 0.1);
            }
            
            .invalid-feedback {
                display: block;
                width: 100%;
                margin-top: 0.25rem;
                font-size: 0.875rem;
                color: #ef4444;
            }
        `;
        document.head.appendChild(style);
    }

    setupTableInteractions() {
        if (this.table) {
            // Add hover effects to table rows
            const rows = this.table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.addEventListener('mouseenter', () => {
                    row.style.backgroundColor = '#f8fafc';
                });
                
                row.addEventListener('mouseleave', () => {
                    row.style.backgroundColor = '';
                });
            });

            // Add click handlers for action buttons
            this.setupActionButtons();
        }
    }

    setupActionButtons() {
        // Process buttons
        const processButtons = document.querySelectorAll('a[href*="creditapprovalform.php"]');
        processButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                this.handleProcessClick(e, button);
            });
        });

        // Cancel buttons
        const cancelButtons = document.querySelectorAll('a[href*="creditapprovalcancel.php"]');
        cancelButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                this.handleCancelClick(e, button);
            });
        });

        // Edit buttons
        const editButtons = document.querySelectorAll('a[onclick*="ipbilling_notes.php"]');
        editButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                this.handleEditClick(e, button);
            });
        });
    }

    initializeSearch() {
        // Set up search functionality
        this.updateSearchState();
        
        // Initialize date pickers
        this.setupDatePickers();
    }

    setupDatePickers() {
        // Enhanced date picker functionality
        if (this.searchInputs.dateFrom) {
            this.searchInputs.dateFrom.addEventListener('change', () => {
                this.validateDateRange();
            });
        }
        
        if (this.searchInputs.dateTo) {
            this.searchInputs.dateTo.addEventListener('change', () => {
                this.validateDateRange();
            });
        }
    }

    handleSearchInput(input) {
        const value = input.value.trim();
        const name = input.name;
        
        // Update current filters
        if (value) {
            this.currentFilters[name] = value;
        } else {
            delete this.currentFilters[name];
        }
        
        // Update search state
        this.updateSearchState();
        
        // Validate input
        this.validateInput(input);
    }

    handleLocationChange(location) {
        this.currentFilters.location = location;
        this.updateSearchState();
        
        // Show loading state for location change
        this.showLoadingState('Updating location...');
        
        // Submit form after a short delay
        setTimeout(() => {
            if (this.form) {
                this.form.submit();
            }
        }, 500);
    }

    handleProcessClick(e, button) {
        e.preventDefault();
        
        const href = button.getAttribute('href');
        const patientcode = this.extractParam(href, 'patientcode');
        const visitcode = this.extractParam(href, 'visitcode');
        
        if (this.confirmAction('process', patientcode, visitcode)) {
            this.showLoadingState('Processing credit approval...');
            window.location.href = href;
        }
    }

    handleCancelClick(e, button) {
        e.preventDefault();
        
        const href = button.getAttribute('href');
        const patientcode = this.extractParam(href, 'patientcode');
        const visitcode = this.extractParam(href, 'visitcode');
        
        if (this.confirmAction('cancel', patientcode, visitcode)) {
            this.showLoadingState('Cancelling credit approval...');
            window.location.href = href;
        }
    }

    handleEditClick(e, button) {
        // Let the default behavior handle the popup
        // Just add some visual feedback
        button.style.opacity = '0.7';
        setTimeout(() => {
            button.style.opacity = '1';
        }, 200);
    }

    extractParam(url, param) {
        const urlParams = new URLSearchParams(url.split('?')[1]);
        return urlParams.get(param);
    }

    confirmAction(action, patientcode, visitcode) {
        const messages = {
            process: `Are you sure you want to process credit approval for patient ${patientcode}?`,
            cancel: `Are you sure you want to cancel credit approval for patient ${patientcode}?`
        };
        
        return confirm(messages[action] || 'Are you sure you want to perform this action?');
    }

    validateForm() {
        let isValid = true;
        const errors = [];

        // Validate date range
        if (!this.validateDateRange()) {
            isValid = false;
        }

        // Validate search inputs
        Object.entries(this.searchInputs).forEach(([name, input]) => {
            if (input && !this.validateInput(input)) {
                isValid = false;
            }
        });

        if (!isValid) {
            this.showAlert('Please correct the errors below', 'error');
        }

        return isValid;
    }

    validateInput(input) {
        const value = input.value.trim();
        const name = input.name;
        
        // Remove existing validation classes
        input.classList.remove('is-valid', 'is-invalid');
        
        // Remove existing error message
        const existingError = input.parentNode.querySelector('.invalid-feedback');
        if (existingError) {
            existingError.remove();
        }

        // Validate based on input type
        let isValid = true;
        let errorMessage = '';

        switch (name) {
            case 'patientcode':
                if (value && !/^[A-Za-z0-9]+$/.test(value)) {
                    isValid = false;
                    errorMessage = 'Patient code should contain only letters and numbers';
                }
                break;
                
            case 'visitcode':
                if (value && !/^[A-Za-z0-9]+$/.test(value)) {
                    isValid = false;
                    errorMessage = 'Visit code should contain only letters and numbers';
                }
                break;
                
            case 'patient':
                if (value && value.length < 2) {
                    isValid = false;
                    errorMessage = 'Patient name should be at least 2 characters';
                }
                break;
        }

        // Apply validation state
        if (value && !isValid) {
            input.classList.add('is-invalid');
            this.showFieldError(input, errorMessage);
        } else if (value && isValid) {
            input.classList.add('is-valid');
        }

        return isValid;
    }

    validateDateRange() {
        const dateFrom = this.searchInputs.dateFrom?.value;
        const dateTo = this.searchInputs.dateTo?.value;
        
        if (dateFrom && dateTo) {
            const fromDate = new Date(dateFrom);
            const toDate = new Date(dateTo);
            
            if (fromDate > toDate) {
                this.showFieldError(this.searchInputs.dateTo, 'End date must be after start date');
                return false;
            } else {
                this.showFieldSuccess(this.searchInputs.dateTo);
                return true;
            }
        }
        
        return true;
    }

    showFieldError(input, message) {
        if (!input) return;

        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        
        // Remove existing error message
        const existingError = input.parentNode.querySelector('.invalid-feedback');
        if (existingError) {
            existingError.remove();
        }

        // Add new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        input.parentNode.appendChild(errorDiv);
    }

    showFieldSuccess(input) {
        if (!input) return;

        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        
        // Remove existing error message
        const existingError = input.parentNode.querySelector('.invalid-feedback');
        if (existingError) {
            existingError.remove();
        }
    }

    updateSearchState() {
        const hasFilters = Object.keys(this.currentFilters).length > 0;
        
        // Update search button state
        const searchButton = document.querySelector('input[type="submit"]');
        if (searchButton) {
            searchButton.disabled = !hasFilters;
        }
        
        // Update filter display
        this.updateFilterDisplay();
    }

    updateFilterDisplay() {
        // Remove existing filter display
        const existingFilters = document.querySelector('.filter-tags');
        if (existingFilters) {
            existingFilters.remove();
        }
        
        // Create new filter display
        if (Object.keys(this.currentFilters).length > 0) {
            const filterContainer = document.createElement('div');
            filterContainer.className = 'filter-tags';
            
            Object.entries(this.currentFilters).forEach(([key, value]) => {
                if (value) {
                    const filterTag = document.createElement('span');
                    filterTag.className = 'filter-tag';
                    filterTag.innerHTML = `
                        ${this.formatFilterLabel(key)}: ${value}
                        <span class="remove" onclick="this.parentElement.remove(); updateSearchState();">×</span>
                    `;
                    filterContainer.appendChild(filterTag);
                }
            });
            
            // Insert after form
            if (this.form) {
                this.form.parentNode.insertBefore(filterContainer, this.form.nextSibling);
            }
        }
    }

    formatFilterLabel(key) {
        const labels = {
            patient: 'Patient',
            patientcode: 'Patient Code',
            visitcode: 'Visit Code',
            dateFrom: 'From Date',
            dateTo: 'To Date',
            location: 'Location'
        };
        
        return labels[key] || key;
    }

    resetForm() {
        // Clear all inputs
        Object.values(this.searchInputs).forEach(input => {
            if (input) {
                input.value = '';
                input.classList.remove('is-valid', 'is-invalid');
            }
        });
        
        // Reset location
        if (this.locationSelect) {
            this.locationSelect.selectedIndex = 0;
        }
        
        // Clear filters
        this.currentFilters = {};
        
        // Update search state
        this.updateSearchState();
        
        // Remove error messages
        document.querySelectorAll('.invalid-feedback').forEach(error => {
            error.remove();
        });
        
        // Remove alerts
        document.querySelectorAll('.alert').forEach(alert => {
            alert.remove();
        });
        
        // Remove filter display
        const existingFilters = document.querySelector('.filter-tags');
        if (existingFilters) {
            existingFilters.remove();
        }
    }

    showLoadingState(message = 'Loading...') {
        // Create loading overlay
        const overlay = document.createElement('div');
        overlay.id = 'loading-overlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        `;
        
        const loadingDiv = document.createElement('div');
        loadingDiv.style.cssText = `
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        `;
        
        loadingDiv.innerHTML = `
            <div class="spinner" style="width: 2rem; height: 2rem; border: 3px solid #f3f4f6; border-top: 3px solid #2563eb; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 1rem;"></div>
            <p style="margin: 0; color: #374151;">${message}</p>
        `;
        
        overlay.appendChild(loadingDiv);
        document.body.appendChild(overlay);
    }

    hideLoadingState() {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.remove();
        }
    }

    showAlert(message, type = 'info') {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());
        
        // Create new alert
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.textContent = message;
        
        // Insert at the top of the form container
        const formContainer = document.querySelector('.form-container') || document.body;
        formContainer.insertBefore(alert, formContainer.firstChild);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    // Enhanced table functionality
    enhanceTable() {
        if (!this.table) return;
        
        // Add sorting functionality
        this.addTableSorting();
        
        // Add row selection
        this.addRowSelection();
        
        // Add export functionality
        this.addExportFunctionality();
    }

    addTableSorting() {
        const headers = this.table.querySelectorAll('th');
        headers.forEach((header, index) => {
            if (index > 0) { // Skip first column (No.)
                header.style.cursor = 'pointer';
                header.addEventListener('click', () => {
                    this.sortTable(index);
                });
            }
        });
    }

    sortTable(columnIndex) {
        const tbody = this.table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        rows.sort((a, b) => {
            const aText = a.cells[columnIndex].textContent.trim();
            const bText = b.cells[columnIndex].textContent.trim();
            
            // Try to parse as numbers first
            const aNum = parseFloat(aText);
            const bNum = parseFloat(bText);
            
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return aNum - bNum;
            }
            
            // Otherwise sort as strings
            return aText.localeCompare(bText);
        });
        
        // Re-append sorted rows
        rows.forEach(row => tbody.appendChild(row));
    }

    addRowSelection() {
        // Add checkboxes to table rows for bulk actions
        const tbody = this.table.querySelector('tbody');
        const rows = tbody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'row-checkbox';
            checkbox.style.marginRight = '0.5rem';
            
            const firstCell = row.cells[0];
            firstCell.insertBefore(checkbox, firstCell.firstChild);
        });
    }

    addExportFunctionality() {
        // Add export button
        const exportButton = document.createElement('button');
        exportButton.textContent = 'Export to Excel';
        exportButton.className = 'btn btn-secondary';
        exportButton.addEventListener('click', () => {
            this.exportToExcel();
        });
        
        // Insert after results header
        const resultsHeader = document.querySelector('.results-header');
        if (resultsHeader) {
            resultsHeader.appendChild(exportButton);
        }
    }

    exportToExcel() {
        try {
            // Get table data
            const tableData = this.getTableData();
            
            // Create CSV content
            const csvContent = this.convertToCSV(tableData);
            
            // Create download link
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `credit_approval_list_${new Date().toISOString().split('T')[0]}.csv`;
            
            // Trigger download
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Clean up
            window.URL.revokeObjectURL(url);
            
            this.showAlert('Export completed successfully', 'success');
            
        } catch (error) {
            console.error('Export error:', error);
            this.showAlert('Export failed. Please try again.', 'error');
        }
    }

    getTableData() {
        const data = [];
        const headers = [];
        
        // Get headers
        const headerRow = this.table.querySelector('thead tr') || this.table.querySelector('tr');
        headerRow.querySelectorAll('th, td').forEach(cell => {
            headers.push(cell.textContent.trim());
        });
        data.push(headers);
        
        // Get data rows
        const rows = this.table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const rowData = [];
            row.querySelectorAll('td').forEach(cell => {
                rowData.push(cell.textContent.trim());
            });
            data.push(rowData);
        });
        
        return data;
    }

    convertToCSV(data) {
        return data.map(row => 
            row.map(cell => `"${cell.replace(/"/g, '""')}"`).join(',')
        ).join('\n');
    }

    // Utility methods
    debounce(func, wait) {
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

    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

    formatCurrency(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const creditApprovalManager = new CreditApprovalListManager();
    
    // Enhance table functionality
    creditApprovalManager.enhanceTable();
    
    // Make it globally available for debugging
    window.creditApprovalManager = creditApprovalManager;
});

// Export for potential external use
window.CreditApprovalListManager = CreditApprovalListManager;


