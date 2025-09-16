// Modern JavaScript for Pay Later Payment Entry - MedStar Hospital Management System

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initSidebar();
    initFormValidation();
    initAccountSearch();
    initPaymentForm();
    initAmountCalculation();
});

// Sidebar functionality
function initSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const mainContainer = document.getElementById('mainContainer');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (!sidebar || !mainContainer) return;
    
    // Mobile menu toggle
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
    
    // Sidebar toggle button
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
                mainContainer.classList.remove('sidebar-collapsed');
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1024) {
            mainContainer.classList.remove('sidebar-collapsed');
        }
    });
}

// Form validation
function initFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
        
        // Real-time validation
        const inputs = form.querySelectorAll('input[required], select[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('input[required], select[required]');
    
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.getAttribute('name') || field.getAttribute('id');
    
    // Clear previous errors
    clearFieldError(field);
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, `${getFieldLabel(field)} is required`);
        return false;
    }
    
    // Amount validation
    if (fieldName === 'paymentamount' && value) {
        if (!/^\d+(\.\d{1,2})?$/.test(value)) {
            showFieldError(field, 'Please enter a valid amount');
            return false;
        }
        if (parseFloat(value) <= 0) {
            showFieldError(field, 'Amount must be greater than 0');
            return false;
        }
    }
    
    // Date validation
    if (fieldName === 'transactiondate' && value) {
        if (!isValidDate(value)) {
            showFieldError(field, 'Please enter a valid date');
            return false;
        }
    }
    
    return true;
}

function showFieldError(field, message) {
    field.classList.add('error');
    
    let errorElement = field.parentNode.querySelector('.field-error');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'field-error';
        field.parentNode.appendChild(errorElement);
    }
    
    errorElement.textContent = message;
}

function clearFieldError(field) {
    field.classList.remove('error');
    const errorElement = field.parentNode.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
}

function getFieldLabel(field) {
    const label = field.parentNode.querySelector('label');
    return label ? label.textContent.replace('*', '').trim() : field.getAttribute('name') || 'Field';
}

function isValidDate(dateString) {
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

// Account search functionality
function initAccountSearch() {
    const searchInput = document.getElementById('searchsuppliername');
    if (!searchInput) return;
    
    // Auto-suggest functionality (placeholder for AJAX implementation)
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length >= 2) {
            // Here you would implement AJAX search for accounts
            console.log('Searching for account:', query);
        }
    });
    
    // Clear account field when search is cleared
    searchInput.addEventListener('input', function() {
        if (!this.value.trim()) {
            const accountField = document.getElementById('cbsuppliername');
            if (accountField) {
                accountField.value = '';
            }
        }
    });
}

// Payment form functionality
function initPaymentForm() {
    const paymentForm = document.querySelector('form[name="form1"]');
    if (!paymentForm) return;
    
    // Set default date to today
    const dateInput = paymentForm.querySelector('input[name="transactiondate"]');
    if (dateInput && !dateInput.value) {
        const today = new Date();
        dateInput.value = today.toISOString().split('T')[0];
    }
    
    // Payment mode change handler
    const paymentModeSelect = paymentForm.querySelector('select[name="transactionmode"]');
    if (paymentModeSelect) {
        paymentModeSelect.addEventListener('change', function() {
            togglePaymentFields(this.value);
        });
    }
    
    // Form submission handler
    paymentForm.addEventListener('submit', function(e) {
        const submitButton = this.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing Payment...';
            
            // Re-enable button after 5 seconds (in case of errors)
            setTimeout(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-save"></i> Save Payment';
            }, 5000);
        }
    });
}

function togglePaymentFields(paymentMode) {
    const chequeFields = document.querySelectorAll('.cheque-field');
    const bankFields = document.querySelectorAll('.bank-field');
    
    // Hide all payment-specific fields first
    chequeFields.forEach(field => field.style.display = 'none');
    bankFields.forEach(field => field.style.display = 'none');
    
    // Show relevant fields based on payment mode
    switch (paymentMode) {
        case 'Cheque':
            chequeFields.forEach(field => field.style.display = 'block');
            break;
        case 'Bank Transfer':
        case 'Online Transfer':
            bankFields.forEach(field => field.style.display = 'block');
            break;
    }
}

// Amount calculation and formatting
function initAmountCalculation() {
    const amountInput = document.querySelector('input[name="paymentamount"]');
    if (!amountInput) return;
    
    amountInput.addEventListener('input', function() {
        const amount = parseFloat(this.value) || 0;
        updateAmountDisplay(amount);
    });
    
    // Initial amount display
    const initialAmount = parseFloat(amountInput.value) || 0;
    updateAmountDisplay(initialAmount);
}

function updateAmountDisplay(amount) {
    const amountDisplay = document.querySelector('.amount-value');
    const amountWords = document.querySelector('.amount-words');
    
    if (amountDisplay) {
        amountDisplay.textContent = `₹ ${amount.toFixed(2)}`;
    }
    
    if (amountWords) {
        amountWords.textContent = `(${numberToWords(amount)} rupees only)`;
    }
}

function numberToWords(num) {
    // Simple number to words conversion for amounts
    const ones = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    const teens = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
    const tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
    
    if (num === 0) return 'zero';
    if (num < 0) return 'negative ' + numberToWords(-num);
    
    let result = '';
    
    if (num >= 10000000) {
        result += numberToWords(Math.floor(num / 10000000)) + ' crore ';
        num %= 10000000;
    }
    
    if (num >= 100000) {
        result += numberToWords(Math.floor(num / 100000)) + ' lakh ';
        num %= 100000;
    }
    
    if (num >= 1000) {
        result += numberToWords(Math.floor(num / 1000)) + ' thousand ';
        num %= 1000;
    }
    
    if (num >= 100) {
        result += ones[Math.floor(num / 100)] + ' hundred ';
        num %= 100;
    }
    
    if (num >= 20) {
        result += tens[Math.floor(num / 10)] + ' ';
        num %= 10;
    } else if (num >= 10) {
        result += teens[num - 10] + ' ';
        num = 0;
    }
    
    if (num > 0) {
        result += ones[num] + ' ';
    }
    
    return result.trim();
}

// Utility functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${getIconForType(type)} alert-icon"></i>
        <span>${message}</span>
    `;
    
    const container = document.querySelector('.main-content');
    if (container) {
        container.insertBefore(notification, container.firstChild);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
}

function getIconForType(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-triangle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Legacy function compatibility
function funcAccount() {
    const searchInput = document.getElementById('searchsuppliername');
    if (searchInput && (!searchInput.value || searchInput.value.trim() === '')) {
        showNotification('Please enter an account name to search', 'error');
        return false;
    }
    return true;
}

