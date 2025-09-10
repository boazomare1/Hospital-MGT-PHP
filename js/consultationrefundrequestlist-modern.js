/**
 * Modern JavaScript for Consultation Refund Request List
 * Handles form validation, date picker, autocomplete, and refund processing
 */

// Modern ES6+ JavaScript with enhanced functionality
class ConsultationRefundRequestList {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupDatePickers();
        this.setupFormValidation();
        this.setupAutoSuggest();
    }

    setupEventListeners() {
        // Form submission handler
        const form = document.querySelector('form[name="cbform1"]');
        if (form) {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm()) {
                    e.preventDefault();
                }
            });
        }

        // Reset button handler
        const resetButton = document.querySelector('input[name="resetbutton"]');
        if (resetButton) {
            resetButton.addEventListener('click', () => {
                this.resetForm();
            });
        }

        // Real-time validation
        this.setupRealTimeValidation();
    }

    setupDatePickers() {
        // Initialize date pickers if the library is available
        if (typeof NewCssCal !== 'undefined') {
            const dateInputs = document.querySelectorAll('input[name="ADate1"], input[name="ADate2"]');
            dateInputs.forEach(input => {
                // Date picker is already initialized via onclick handlers
                // We can add additional functionality here if needed
            });
        }
    }

    setupFormValidation() {
        // Add modern validation attributes
        const patientInput = document.querySelector('input[name="patient"]');
        if (patientInput) {
            patientInput.setAttribute('maxlength', '100');
        }

        const patientCodeInput = document.querySelector('input[name="patientcode"]');
        if (patientCodeInput) {
            patientCodeInput.setAttribute('maxlength', '50');
        }

        const visitCodeInput = document.querySelector('input[name="visitcode"]');
        if (visitCodeInput) {
            visitCodeInput.setAttribute('maxlength', '50');
        }

        const billNoInput = document.querySelector('input[name="billno"]');
        if (billNoInput) {
            billNoInput.setAttribute('maxlength', '50');
        }
    }

    setupAutoSuggest() {
        // Initialize auto-suggest if available
        if (typeof AutoSuggestControl !== 'undefined' && typeof StateSuggestions !== 'undefined') {
            const searchCustomerName = document.getElementById('searchcustomername');
            if (searchCustomerName) {
                new AutoSuggestControl(searchCustomerName, new StateSuggestions());
            }
        }
    }

    setupRealTimeValidation() {
        // Patient name validation
        const patientInput = document.querySelector('input[name="patient"]');
        if (patientInput) {
            patientInput.addEventListener('input', (e) => {
                this.validatePatientName(e.target.value);
            });
        }

        // Patient code validation
        const patientCodeInput = document.querySelector('input[name="patientcode"]');
        if (patientCodeInput) {
            patientCodeInput.addEventListener('input', (e) => {
                this.validatePatientCode(e.target.value);
            });
        }

        // Visit code validation
        const visitCodeInput = document.querySelector('input[name="visitcode"]');
        if (visitCodeInput) {
            visitCodeInput.addEventListener('input', (e) => {
                this.validateVisitCode(e.target.value);
            });
        }

        // Bill number validation
        const billNoInput = document.querySelector('input[name="billno"]');
        if (billNoInput) {
            billNoInput.addEventListener('input', (e) => {
                this.validateBillNumber(e.target.value);
            });
        }

        // Date validation
        const dateInputs = document.querySelectorAll('input[name="ADate1"], input[name="ADate2"]');
        dateInputs.forEach(input => {
            input.addEventListener('change', (e) => {
                this.validateDate(e.target);
            });
        });
    }

    validateForm() {
        const errors = [];

        // Date validation
        const fromDate = document.querySelector('input[name="ADate1"]');
        const toDate = document.querySelector('input[name="ADate2"]');

        if (fromDate && toDate) {
            if (fromDate.value && toDate.value) {
                const fromDateObj = new Date(fromDate.value);
                const toDateObj = new Date(toDate.value);

                if (fromDateObj > toDateObj) {
                    errors.push('From date cannot be greater than To date.');
                    this.showFieldError(fromDate, 'From date cannot be greater than To date.');
                    this.showFieldError(toDate, 'From date cannot be greater than To date.');
                } else {
                    this.clearFieldError(fromDate);
                    this.clearFieldError(toDate);
                }
            }
        }

        if (errors.length > 0) {
            this.showAlert(errors.join(' '), 'error');
            return false;
        }

        return true;
    }

    validatePatientName(value) {
        const field = document.querySelector('input[name="patient"]');
        if (value.length > 100) {
            this.showFieldError(field, 'Patient name must be 100 characters or less.');
        } else {
            this.clearFieldError(field);
        }
    }

    validatePatientCode(value) {
        const field = document.querySelector('input[name="patientcode"]');
        if (value && !/^[A-Za-z0-9\-_]+$/.test(value)) {
            this.showFieldError(field, 'Patient code can only contain letters, numbers, hyphens, and underscores.');
        } else {
            this.clearFieldError(field);
        }
    }

    validateVisitCode(value) {
        const field = document.querySelector('input[name="visitcode"]');
        if (value && !/^[A-Za-z0-9\-_]+$/.test(value)) {
            this.showFieldError(field, 'Visit code can only contain letters, numbers, hyphens, and underscores.');
        } else {
            this.clearFieldError(field);
        }
    }

    validateBillNumber(value) {
        const field = document.querySelector('input[name="billno"]');
        if (value && !/^[A-Za-z0-9\-_]+$/.test(value)) {
            this.showFieldError(field, 'Bill number can only contain letters, numbers, hyphens, and underscores.');
        } else {
            this.clearFieldError(field);
        }
    }

    validateDate(field) {
        if (field.value) {
            const date = new Date(field.value);
            if (isNaN(date.getTime())) {
                this.showFieldError(field, 'Please enter a valid date.');
            } else {
                this.clearFieldError(field);
            }
        }
    }

    showFieldError(field, message) {
        if (!field) return;

        field.style.borderColor = '#dc3545';
        
        // Remove existing error message
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }

        // Add error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.color = '#dc3545';
        errorDiv.style.fontSize = '12px';
        errorDiv.style.marginTop = '2px';
        errorDiv.textContent = message;
        field.parentNode.appendChild(errorDiv);
    }

    clearFieldError(field) {
        if (!field) return;

        field.style.borderColor = '';
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    showAlert(message, type = 'info') {
        // Create modern alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'error' ? 'error' : 'success'}`;
        alertDiv.textContent = message;
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.style.maxWidth = '400px';
        alertDiv.style.padding = '15px 20px';
        alertDiv.style.borderRadius = '4px';
        alertDiv.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';

        document.body.appendChild(alertDiv);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 5000);
    }

    resetForm() {
        const form = document.querySelector('form[name="cbform1"]');
        if (form) {
            form.reset();
            
            // Clear any error messages
            const errorMessages = form.querySelectorAll('.field-error');
            errorMessages.forEach(error => error.remove());
            
            // Reset field styles
            const inputs = form.querySelectorAll('input');
            inputs.forEach(input => {
                input.style.borderColor = '';
            });
        }
    }

    // Process refund request with modern confirmation
    processRefundRequest(billNumber, visitCode, remarkId) {
        const remarksTextarea = document.getElementById('remark' + remarkId);
        
        if (!remarksTextarea || !remarksTextarea.value.trim()) {
            this.showAlert('Please enter remarks before processing refund.', 'error');
            if (remarksTextarea) {
                remarksTextarea.focus();
                remarksTextarea.style.borderColor = '#dc3545';
            }
            return false;
        }

        // Clear any previous error styling
        if (remarksTextarea) {
            remarksTextarea.style.borderColor = '';
        }

        const remarks = remarksTextarea.value.trim();
        
        // Modern confirmation dialog
        if (confirm('Are you sure you want to process this refund request?')) {
            // Show loading state
            this.showAlert('Processing refund request...', 'info');
            
            // Redirect to process the refund
            window.location = `consultationrefundrequestlist.php?billnumber=${billNumber}&visitcode=${visitCode}&remark_id=${remarkId}&remarks=${encodeURIComponent(remarks)}`;
        } else {
            this.showAlert('Refund request cancelled.', 'info');
        }
        
        return false;
    }

    // Print functionality
    printRefundList() {
        window.print();
    }

    // Export functionality (if needed)
    exportToExcel() {
        // This would need to be implemented based on requirements
        console.log('Export to Excel functionality would be implemented here');
    }
}

// Legacy function compatibility
window.cbcustomername1 = function() {
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.submit();
    }
};

window.disableEnterKey = function(varPassed) {
    const key = event.keyCode || event.which;
    
    if (key === 8) { // Backspace
        event.keyCode = 0;
        return false;
    }
    
    if (key === 13) { // Enter
        return false;
    }
    
    return true;
};

window.loadprintpage1 = function(banum) {
    if (banum) {
        const printWindow = window.open(
            `print_bill1_op1.php?billautonumber=${banum}`,
            `Window${banum}`,
            'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25'
        );
        
        if (!printWindow) {
            alert('Please allow popups for this site to print bills.');
        }
    }
};

// Modern refund processing function
window.putRequest = function(billNumber, visitCode, remarkId) {
    const refundRequestList = new ConsultationRefundRequestList();
    return refundRequestList.processRefundRequest(billNumber, visitCode, remarkId);
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    new ConsultationRefundRequestList();
});

// Initialize with jQuery if available
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        new ConsultationRefundRequestList();
    });
}
