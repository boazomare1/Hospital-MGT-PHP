/**
 * Modern JavaScript for Cost Center Report
 * Handles form interactions, period selection, validation, and data export
 */

class CostCenterReportManager {
    constructor() {
        this.form = null;
        this.periodSelect = null;
        this.costCenterSelect = null;
        this.dateInputs = [];
        this.monthSelects = [];
        this.yearSelects = [];
        this.quarterSelects = [];
        
        this.init();
    }

    init() {
        this.initializeElements();
        this.setupEventListeners();
        this.initializePeriodSelection();
        this.setupFormValidation();
        this.setupDatePickers();
        this.setupExportFunctionality();
    }

    initializeElements() {
        // Get form elements
        this.form = document.querySelector('form[name="cbform1"]');
        this.periodSelect = document.getElementById('period1');
        this.costCenterSelect = document.getElementById('cc_name');
        
        // Get period-specific elements
        this.dateInputs = [
            document.getElementById('ADate1'),
            document.getElementById('ADate2')
        ];
        
        this.monthSelects = [
            document.getElementById('searchmonth'),
            document.getElementById('searchmonthto')
        ];
        
        this.yearSelects = [
            document.getElementById('searchyear'),
            document.getElementById('searchyear1')
        ];
        
        this.quarterSelects = [
            document.getElementById('searchquarter')
        ];
        
        // Get all year selects for yearly period
        this.yearlyYearSelects = [
            document.getElementById('fromyear'),
            document.getElementById('toyear')
        ];
    }

    setupEventListeners() {
        // Period selection change
        if (this.periodSelect) {
            this.periodSelect.addEventListener('change', (e) => {
                this.handlePeriodChange(e.target.value);
            });
        }

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

        // Cost center selection
        if (this.costCenterSelect) {
            this.costCenterSelect.addEventListener('change', (e) => {
                this.handleCostCenterChange(e.target.value);
            });
        }

        // Date input changes
        this.dateInputs.forEach(input => {
            if (input) {
                input.addEventListener('change', () => {
                    this.validateDateRange();
                });
            }
        });

        // Month selection changes
        this.monthSelects.forEach(select => {
            if (select) {
                select.addEventListener('change', () => {
                    this.validateMonthRange();
                });
            }
        });

        // Year selection changes
        [...this.yearSelects, ...this.yearlyYearSelects].forEach(select => {
            if (select) {
                select.addEventListener('change', () => {
                    this.validateYearRange();
                });
            }
        });

        // Quarter selection change
        this.quarterSelects.forEach(select => {
            if (select) {
                select.addEventListener('change', () => {
                    this.validateQuarterSelection();
                });
            }
        });

        // Reset button
        const resetButton = document.getElementById('resetbutton');
        if (resetButton) {
            resetButton.addEventListener('click', () => {
                this.resetForm();
            });
        }
    }

    initializePeriodSelection() {
        // Set initial period if already selected
        const currentPeriod = this.periodSelect?.value;
        if (currentPeriod) {
            this.handlePeriodChange(currentPeriod);
        }
    }

    handlePeriodChange(period) {
        // Hide all period sections
        const periodSections = [
            'dates range',
            'monthly',
            'monthly12',
            'quarterly',
            'yearly'
        ];

        periodSections.forEach(sectionId => {
            const section = document.getElementById(sectionId);
            if (section) {
                section.style.display = 'none';
                section.classList.remove('active');
            }
        });

        // Show selected period section
        if (period && period !== '') {
            const targetSection = document.getElementById(period);
            if (targetSection) {
                targetSection.style.display = '';
                targetSection.classList.add('active');
            }

            // Special handling for monthly period
            if (period === 'monthly') {
                const monthly12Section = document.getElementById('monthly12');
                if (monthly12Section) {
                    monthly12Section.style.display = '';
                    monthly12Section.classList.add('active');
                }
            }
        }

        // Update form validation based on period
        this.updateValidationRules(period);
    }

    updateValidationRules(period) {
        // Remove existing validation classes
        document.querySelectorAll('.form-control').forEach(input => {
            input.classList.remove('is-invalid', 'is-valid');
        });

        // Add validation based on period
        switch (period) {
            case 'monthly':
                this.addValidationToElements([...this.monthSelects, ...this.yearSelects]);
                break;
            case 'quarterly':
                this.addValidationToElements([...this.quarterSelects, ...this.yearSelects]);
                break;
            case 'yearly':
                this.addValidationToElements(this.yearlyYearSelects);
                break;
            case 'dates range':
                this.addValidationToElements(this.dateInputs);
                break;
        }
    }

    addValidationToElements(elements) {
        elements.forEach(element => {
            if (element) {
                element.addEventListener('blur', () => {
                    this.validateElement(element);
                });
            }
        });
    }

    validateForm() {
        let isValid = true;
        const errors = [];

        // Validate cost center selection
        if (!this.costCenterSelect?.value) {
            errors.push('Please select a cost center');
            this.showFieldError(this.costCenterSelect, 'Cost center is required');
            isValid = false;
        } else {
            this.showFieldSuccess(this.costCenterSelect);
        }

        // Validate period selection
        const period = this.periodSelect?.value;
        if (!period) {
            errors.push('Please select a period');
            this.showFieldError(this.periodSelect, 'Period is required');
            isValid = false;
        } else {
            this.showFieldSuccess(this.periodSelect);
            
            // Validate period-specific fields
            switch (period) {
                case 'monthly':
                    if (!this.validateMonthlyPeriod()) {
                        isValid = false;
                    }
                    break;
                case 'quarterly':
                    if (!this.validateQuarterlyPeriod()) {
                        isValid = false;
                    }
                    break;
                case 'yearly':
                    if (!this.validateYearlyPeriod()) {
                        isValid = false;
                    }
                    break;
                case 'dates range':
                    if (!this.validateDateRangePeriod()) {
                        isValid = false;
                    }
                    break;
            }
        }

        // Show errors if any
        if (!isValid) {
            this.showAlert('Please correct the errors below', 'error');
        }

        return isValid;
    }

    validateMonthlyPeriod() {
        let isValid = true;

        if (!this.monthSelects[0]?.value) {
            this.showFieldError(this.monthSelects[0], 'From month is required');
            isValid = false;
        } else {
            this.showFieldSuccess(this.monthSelects[0]);
        }

        if (!this.monthSelects[1]?.value) {
            this.showFieldError(this.monthSelects[1], 'To month is required');
            isValid = false;
        } else {
            this.showFieldSuccess(this.monthSelects[1]);
        }

        if (!this.yearSelects[0]?.value) {
            this.showFieldError(this.yearSelects[0], 'Year is required');
            isValid = false;
        } else {
            this.showFieldSuccess(this.yearSelects[0]);
        }

        // Validate month range
        if (this.monthSelects[0]?.value && this.monthSelects[1]?.value) {
            const fromMonth = parseInt(this.monthSelects[0].value);
            const toMonth = parseInt(this.monthSelects[1].value);
            
            if (fromMonth > toMonth) {
                this.showFieldError(this.monthSelects[1], 'To month must be after from month');
                isValid = false;
            }
        }

        return isValid;
    }

    validateQuarterlyPeriod() {
        let isValid = true;

        if (!this.quarterSelects[0]?.value) {
            this.showFieldError(this.quarterSelects[0], 'Quarter is required');
            isValid = false;
        } else {
            this.showFieldSuccess(this.quarterSelects[0]);
        }

        if (!this.yearSelects[1]?.value) {
            this.showFieldError(this.yearSelects[1], 'Year is required');
            isValid = false;
        } else {
            this.showFieldSuccess(this.yearSelects[1]);
        }

        return isValid;
    }

    validateYearlyPeriod() {
        let isValid = true;

        if (!this.yearlyYearSelects[0]?.value) {
            this.showFieldError(this.yearlyYearSelects[0], 'From year is required');
            isValid = false;
        } else {
            this.showFieldSuccess(this.yearlyYearSelects[0]);
        }

        if (!this.yearlyYearSelects[1]?.value) {
            this.showFieldError(this.yearlyYearSelects[1], 'To year is required');
            isValid = false;
        } else {
            this.showFieldSuccess(this.yearlyYearSelects[1]);
        }

        // Validate year range
        if (this.yearlyYearSelects[0]?.value && this.yearlyYearSelects[1]?.value) {
            const fromYear = parseInt(this.yearlyYearSelects[0].value);
            const toYear = parseInt(this.yearlyYearSelects[1].value);
            
            if (fromYear > toYear) {
                this.showFieldError(this.yearlyYearSelects[1], 'To year must be after from year');
                isValid = false;
            }
        }

        return isValid;
    }

    validateDateRangePeriod() {
        let isValid = true;

        if (!this.dateInputs[0]?.value) {
            this.showFieldError(this.dateInputs[0], 'From date is required');
            isValid = false;
        } else {
            this.showFieldSuccess(this.dateInputs[0]);
        }

        if (!this.dateInputs[1]?.value) {
            this.showFieldError(this.dateInputs[1], 'To date is required');
            isValid = false;
        } else {
            this.showFieldSuccess(this.dateInputs[1]);
        }

        // Validate date range
        if (this.dateInputs[0]?.value && this.dateInputs[1]?.value) {
            const fromDate = new Date(this.dateInputs[0].value);
            const toDate = new Date(this.dateInputs[1].value);
            
            if (fromDate > toDate) {
                this.showFieldError(this.dateInputs[1], 'To date must be after from date');
                isValid = false;
            }
        }

        return isValid;
    }

    validateElement(element) {
        if (!element.value.trim()) {
            this.showFieldError(element, 'This field is required');
            return false;
        } else {
            this.showFieldSuccess(element);
            return true;
        }
    }

    showFieldError(element, message) {
        if (!element) return;

        element.classList.remove('is-valid');
        element.classList.add('is-invalid');
        
        // Remove existing error message
        const existingError = element.parentNode.querySelector('.invalid-feedback');
        if (existingError) {
            existingError.remove();
        }

        // Add new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        element.parentNode.appendChild(errorDiv);
    }

    showFieldSuccess(element) {
        if (!element) return;

        element.classList.remove('is-invalid');
        element.classList.add('is-valid');
        
        // Remove existing error message
        const existingError = element.parentNode.querySelector('.invalid-feedback');
        if (existingError) {
            existingError.remove();
        }
    }

    validateDateRange() {
        if (this.dateInputs[0]?.value && this.dateInputs[1]?.value) {
            const fromDate = new Date(this.dateInputs[0].value);
            const toDate = new Date(this.dateInputs[1].value);
            
            if (fromDate > toDate) {
                this.showFieldError(this.dateInputs[1], 'To date must be after from date');
                return false;
            } else {
                this.showFieldSuccess(this.dateInputs[1]);
                return true;
            }
        }
        return true;
    }

    validateMonthRange() {
        if (this.monthSelects[0]?.value && this.monthSelects[1]?.value) {
            const fromMonth = parseInt(this.monthSelects[0].value);
            const toMonth = parseInt(this.monthSelects[1].value);
            
            if (fromMonth > toMonth) {
                this.showFieldError(this.monthSelects[1], 'To month must be after from month');
                return false;
            } else {
                this.showFieldSuccess(this.monthSelects[1]);
                return true;
            }
        }
        return true;
    }

    validateYearRange() {
        if (this.yearlyYearSelects[0]?.value && this.yearlyYearSelects[1]?.value) {
            const fromYear = parseInt(this.yearlyYearSelects[0].value);
            const toYear = parseInt(this.yearlyYearSelects[1].value);
            
            if (fromYear > toYear) {
                this.showFieldError(this.yearlyYearSelects[1], 'To year must be after from year');
                return false;
            } else {
                this.showFieldSuccess(this.yearlyYearSelects[1]);
                return true;
            }
        }
        return true;
    }

    validateQuarterSelection() {
        if (this.quarterSelects[0]?.value) {
            this.showFieldSuccess(this.quarterSelects[0]);
            return true;
        } else {
            this.showFieldError(this.quarterSelects[0], 'Please select a quarter');
            return false;
        }
    }

    handleCostCenterChange(value) {
        if (value) {
            this.showFieldSuccess(this.costCenterSelect);
        } else {
            this.showFieldError(this.costCenterSelect, 'Please select a cost center');
        }
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

    setupDatePickers() {
        // Enhanced date picker functionality
        this.dateInputs.forEach(input => {
            if (input) {
                // Set min/max dates
                const today = new Date();
                const maxDate = today.toISOString().split('T')[0];
                
                input.setAttribute('max', maxDate);
                
                // Add date validation
                input.addEventListener('change', () => {
                    const selectedDate = new Date(input.value);
                    if (selectedDate > today) {
                        this.showFieldError(input, 'Date cannot be in the future');
                    } else {
                        this.showFieldSuccess(input);
                    }
                });
            }
        });
    }

    setupExportFunctionality() {
        // Enhanced export functionality
        const exportBtn = document.querySelector('a[href*="costcenterreport_excel.php"]');
        if (exportBtn) {
            exportBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.exportToExcel();
            });
        }
    }

    exportToExcel() {
        try {
            // Get form data
            const formData = new FormData(this.form);
            const params = new URLSearchParams();
            
            // Add all form parameters
            for (const [key, value] of formData.entries()) {
                params.append(key, value);
            }
            
            // Create export URL
            const exportUrl = `costcenterreport_excel.php?${params.toString()}`;
            
            // Show loading state
            this.showLoadingState('Exporting...');
            
            // Create temporary link for download
            const link = document.createElement('a');
            link.href = exportUrl;
            link.download = this.generateFileName();
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Hide loading state
            setTimeout(() => {
                this.hideLoadingState();
                this.showAlert('Export completed successfully', 'success');
            }, 1000);
            
        } catch (error) {
            console.error('Export error:', error);
            this.showAlert('Export failed. Please try again.', 'error');
            this.hideLoadingState();
        }
    }

    generateFileName() {
        const costCenter = this.costCenterSelect?.value || 'CostCenter';
        const period = this.periodSelect?.value || 'Report';
        const date1 = this.dateInputs[0]?.value || '';
        const date2 = this.dateInputs[1]?.value || '';
        
        return `CostCenter_${costCenter}_${period}_${date1}_To_${date2}.xls`;
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

    resetForm() {
        // Reset all form fields
        if (this.form) {
            this.form.reset();
        }
        
        // Hide all period sections
        this.handlePeriodChange('');
        
        // Clear validation states
        document.querySelectorAll('.form-control').forEach(input => {
            input.classList.remove('is-invalid', 'is-valid');
        });
        
        // Remove error messages
        document.querySelectorAll('.invalid-feedback').forEach(error => {
            error.remove();
        });
        
        // Remove alerts
        document.querySelectorAll('.alert').forEach(alert => {
            alert.remove();
        });
        
        // Reset to default values
        this.setDefaultValues();
    }

    setDefaultValues() {
        // Set default date range to current month
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        
        if (this.dateInputs[0]) {
            this.dateInputs[0].value = firstDay.toISOString().split('T')[0];
        }
        if (this.dateInputs[1]) {
            this.dateInputs[1].value = lastDay.toISOString().split('T')[0];
        }
        
        // Set current month and year
        if (this.monthSelects[0]) {
            this.monthSelects[0].value = today.getMonth() + 1;
        }
        if (this.monthSelects[1]) {
            this.monthSelects[1].value = today.getMonth() + 1;
        }
        if (this.yearSelects[0]) {
            this.yearSelects[0].value = today.getFullYear();
        }
        if (this.yearSelects[1]) {
            this.yearSelects[1].value = today.getFullYear();
        }
    }

    // Utility methods
    formatCurrency(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    }

    formatNumber(number) {
        return new Intl.NumberFormat('en-US').format(number);
    }

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
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new CostCenterReportManager();
});

// Export for potential external use
window.CostCenterReportManager = CostCenterReportManager;


