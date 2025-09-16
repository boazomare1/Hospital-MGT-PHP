// Bank Master Modern JavaScript
// Handles sidebar, form validation, search, and responsive functionality

document.addEventListener('DOMContentLoaded', function() {
    initializeSidebar();
    initializeMenuToggle();
    initializeFormValidation();
    initializeSearch();
    initializeResponsiveDesign();
    initializeTouchSupport();
    initializeFormEnhancements();
    initializeDeleteConfirmations();
});

// Sidebar Management
function initializeSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const menuToggle = document.getElementById('menuToggle');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            updateSidebarToggleIcon();
        });
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 992) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
}

function updateSidebarToggleIcon() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('leftSidebar');
    
    if (sidebarToggle) {
        const icon = sidebarToggle.querySelector('i');
        if (sidebar.classList.contains('collapsed')) {
            icon.className = 'fas fa-chevron-right';
        } else {
            icon.className = 'fas fa-chevron-left';
        }
    }
}

// Menu Toggle for Mobile
function initializeMenuToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('open');
        });
    }
}

// Search Functionality
function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            searchBanks(this.value);
        });
    }
}

function searchBanks(searchTerm) {
    const tableBody = document.getElementById('bankTableBody');
    if (!tableBody) return;
    
    const rows = tableBody.querySelectorAll('tr');
    const term = searchTerm.toLowerCase();
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(term)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
        searchBanks('');
    }
}

// Delete Confirmations
function initializeDeleteConfirmations() {
    // This will be handled by the confirmDelete function called from HTML
}

function confirmDelete(bankName, autoNumber) {
    if (confirm(`Are you sure you want to delete the bank "${bankName}"?`)) {
        window.location.href = `addbank1.php?st=del&anum=${autoNumber}`;
    }
    return false;
}

// Form Validation
function initializeFormValidation() {
    const bankForm = document.querySelector('.add-form');
    
    if (bankForm) {
        bankForm.addEventListener('submit', function(e) {
            if (!validateBankForm()) {
                e.preventDefault();
                showAlert('Please fill in all required fields correctly.', 'error');
            }
        });
        
        // Real-time validation
        const inputs = bankForm.querySelectorAll('.form-input, .form-select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearFieldValidation(this);
            });
        });
    }
}

function validateBankForm() {
    const bankname = document.getElementById('bankname');
    const branchname = document.getElementById('branchname');
    const accountnumber = document.getElementById('accountnumber');
    const accounttype = document.getElementById('accounttype');
    
    let isValid = true;
    
    // Validate bank name
    if (bankname && bankname.value.trim() === '') {
        markFieldAsInvalid(bankname, 'Bank name is required');
        isValid = false;
    }
    
    // Validate branch name
    if (branchname && branchname.value.trim() === '') {
        markFieldAsInvalid(branchname, 'Branch name is required');
        isValid = false;
    }
    
    // Validate account number
    if (accountnumber && accountnumber.value.trim() === '') {
        markFieldAsInvalid(accountnumber, 'Account number is required');
        isValid = false;
    }
    
    // Validate account type
    if (accounttype && accounttype.value.trim() === '') {
        markFieldAsInvalid(accounttype, 'Account type is required');
        isValid = false;
    }
    
    // Validate phone numbers if provided
    const contactpersonphone = document.getElementById('contactpersonphone');
    const phonenumber = document.getElementById('phonenumber');
    const mobilenumber = document.getElementById('mobilenumber');
    
    if (contactpersonphone && contactpersonphone.value.trim() !== '') {
        if (!isValidPhoneNumber(contactpersonphone.value)) {
            markFieldAsInvalid(contactpersonphone, 'Please enter a valid phone number');
            isValid = false;
        }
    }
    
    if (phonenumber && phonenumber.value.trim() !== '') {
        if (!isValidPhoneNumber(phonenumber.value)) {
            markFieldAsInvalid(phonenumber, 'Please enter a valid phone number');
            isValid = false;
        }
    }
    
    if (mobilenumber && mobilenumber.value.trim() !== '') {
        if (!isValidPhoneNumber(mobilenumber.value)) {
            markFieldAsInvalid(mobilenumber, 'Please enter a valid mobile number');
            isValid = false;
        }
    }
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && value === '') {
        markFieldAsInvalid(field, 'This field is required');
        return false;
    }
    
    // Special validation for phone numbers
    if (field.id === 'contactpersonphone' || field.id === 'phonenumber' || field.id === 'mobilenumber') {
        if (value !== '' && !isValidPhoneNumber(value)) {
            markFieldAsInvalid(field, 'Please enter a valid phone number');
            return false;
        }
    }
    
    markFieldAsValid(field);
    return true;
}

function isValidPhoneNumber(phone) {
    // Basic phone number validation - allows digits, spaces, dashes, and parentheses
    const phoneRegex = /^[\d\s\-\(\)\+]+$/;
    return phoneRegex.test(phone) && phone.replace(/[\s\-\(\)\+]/g, '').length >= 7;
}

function markFieldAsInvalid(field, message) {
    field.classList.remove('valid');
    field.classList.add('invalid');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Add error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.color = '#e74c3c';
    errorDiv.style.fontSize = '0.85rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

function markFieldAsValid(field) {
    field.classList.remove('invalid');
    field.classList.add('valid');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

function clearFieldValidation(field) {
    field.classList.remove('invalid', 'valid');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// Form Enhancements
function initializeFormEnhancements() {
    // Auto-uppercase for text inputs
    const textInputs = document.querySelectorAll('input[type="text"]');
    textInputs.forEach(input => {
        if (input.id !== 'bankcode' && input.id !== 'companyname' && input.id !== 'accountnumber') {
            input.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        }
    });
    
    // Phone number formatting
    const phoneInputs = document.querySelectorAll('#contactpersonphone, #phonenumber, #mobilenumber');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function() {
            // Remove non-digit characters except allowed ones
            this.value = this.value.replace(/[^\d\s\-\(\)\+]/g, '');
        });
    });
    
    // Account number validation
    const accountNumberInput = document.getElementById('accountnumber');
    if (accountNumberInput) {
        accountNumberInput.addEventListener('input', function() {
            // Allow only alphanumeric characters
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
        });
    }
}

// Responsive Design
function initializeResponsiveDesign() {
    // Handle window resize
    window.addEventListener('resize', function() {
        handleResize();
    });
    
    // Initial resize handling
    handleResize();
}

function handleResize() {
    const sidebar = document.getElementById('leftSidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (window.innerWidth <= 992) {
        if (sidebar) {
            sidebar.classList.remove('collapsed');
        }
        if (mainContent) {
            mainContent.style.marginLeft = '0';
        }
    } else {
        if (sidebar && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
        }
    }
}

// Touch Support
function initializeTouchSupport() {
    // Add touch support for mobile devices
    if ('ontouchstart' in window) {
        document.body.classList.add('touch-device');
        
        // Handle touch events for sidebar
        const sidebar = document.getElementById('leftSidebar');
        if (sidebar) {
            let startX = 0;
            let currentX = 0;
            
            sidebar.addEventListener('touchstart', function(e) {
                startX = e.touches[0].clientX;
            });
            
            sidebar.addEventListener('touchmove', function(e) {
                currentX = e.touches[0].clientX;
            });
            
            sidebar.addEventListener('touchend', function(e) {
                const diff = startX - currentX;
                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        sidebar.classList.remove('open');
                    } else {
                        sidebar.classList.add('open');
                    }
                }
            });
        }
    }
}

// Utility Functions
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    
    // Remove existing alerts
    const existingAlerts = alertContainer.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `
        <i class="fas fa-${getAlertIcon(type)} alert-icon"></i>
        <span>${message}</span>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alert.parentElement) {
            alert.remove();
        }
    }, 5000);
}

function getAlertIcon(type) {
    switch (type) {
        case 'error': return 'exclamation-triangle';
        case 'success': return 'check-circle';
        case 'warning': return 'exclamation-circle';
        default: return 'info-circle';
    }
}

function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    // Implementation for Excel export
    showAlert('Export functionality will be implemented here.', 'info');
}

function resetForm() {
    const bankForm = document.querySelector('.add-form');
    if (bankForm) {
        bankForm.reset();
        
        // Clear validation states
        const inputs = bankForm.querySelectorAll('.form-input, .form-select');
        inputs.forEach(input => {
            clearFieldValidation(input);
        });
        
        showAlert('Form reset successfully.', 'success');
    }
}

// Global functions for legacy compatibility
function banksearch(varCallFrom) {
    var varCallFrom = varCallFrom;
    window.open("popup_bankandcashaccount.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
}

function from1submit1() {
    const bankForm = document.querySelector('.add-form');
    if (bankForm) {
        return validateBankForm();
    }
    return false;
}

// Add CSS for validation states
const style = document.createElement('style');
style.textContent = `
    .form-input.valid,
    .form-select.valid {
        border-color: #27ae60;
        box-shadow: 0 0 0 3px rgba(39,174,96,0.1);
    }
    
    .form-input.invalid,
    .form-select.invalid {
        border-color: #e74c3c;
        box-shadow: 0 0 0 3px rgba(231,76,60,0.1);
    }
    
    .field-error {
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }
    
    .touch-device .floating-menu-toggle {
        display: none;
    }
    
    .alert-close {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        margin-left: auto;
        padding: 0.25rem;
        border-radius: 4px;
        transition: background 0.3s ease;
    }
    
    .alert-close:hover {
        background: rgba(0,0,0,0.1);
    }
    
    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52,152,219,0.1);
    }
`;
document.head.appendChild(style);




