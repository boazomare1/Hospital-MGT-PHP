/**
 * Emergency Patient Registration Modern JavaScript
 * Handles interactive elements and form functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar functionality
    initializeSidebar();
    
    // Initialize form functionality
    initializeForm();
    
    // Initialize photo upload
    initializePhotoUpload();
    
    // Initialize autocomplete
    initializeAutocomplete();
    
    // Initialize validation
    initializeValidation();
    
    // Initialize age calculation
    initializeAgeCalculation();
    
    // Initialize gender selection
    initializeGenderSelection();
    
    // Initialize plan selection
    initializePlanSelection();
});

// Sidebar functionality
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.remove('open');
        });
    }
    
    // Close sidebar when clicking outside
    document.addEventListener('click', function(e) {
        if (sidebar && !sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    });
}

// Form functionality
function initializeForm() {
    // Handle form submission
    const form = document.getElementById('emergencyPatientForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // Handle patient type change
    const patientType = document.getElementById('emer_patienttype');
    if (patientType) {
        patientType.addEventListener('change', handlePatientTypeChange);
    }
    
    // Handle gender change
    const gender = document.getElementById('gender');
    if (gender) {
        gender.addEventListener('change', handleGenderChange);
    }
    
    // Handle salutation change
    const salutation = document.getElementById('salutation');
    if (salutation) {
        salutation.addEventListener('change', handleSalutationChange);
    }
}

// Handle patient type change
function handlePatientTypeChange() {
    const patientType = document.getElementById('emer_patienttype').value;
    updatePatientTypeIndicator(patientType);
}

// Handle gender change
function handleGenderChange() {
    const gender = document.getElementById('gender').value;
    updateGenderIndicator(gender);
}

// Handle salutation change
function handleSalutationChange() {
    const salutation = document.getElementById('salutation').value;
    // Auto-select gender based on salutation
    if (salutation) {
        // This would typically make an AJAX call to get gender from salutation
        // For now, we'll use a simple mapping
        const genderMap = {
            'MR': 'Male',
            'MRS': 'Female',
            'MS': 'Female',
            'MISS': 'Female',
            'DR': '', // Could be either
            'PROF': '' // Could be either
        };
        
        if (genderMap[salutation.toUpperCase()]) {
            document.getElementById('gender').value = genderMap[salutation.toUpperCase()];
            updateGenderIndicator(genderMap[salutation.toUpperCase()]);
        }
    }
}

// Update patient type indicator
function updatePatientTypeIndicator(patientType) {
    const indicator = document.getElementById('patientTypeIndicator');
    if (indicator) {
        indicator.className = `patient-type-indicator patient-type-${patientType.toLowerCase()}`;
        indicator.innerHTML = `
            <i class="fas fa-${getPatientTypeIcon(patientType)}"></i>
            <span>${patientType}</span>
        `;
    }
}

// Update gender indicator
function updateGenderIndicator(gender) {
    const indicator = document.getElementById('genderIndicator');
    if (indicator && gender) {
        indicator.className = `gender-indicator gender-${gender.toLowerCase()}`;
        indicator.innerHTML = `
            <i class="fas fa-${getGenderIcon(gender)}"></i>
            <span>${gender}</span>
        `;
    }
}

// Get patient type icon
function getPatientTypeIcon(patientType) {
    const icons = {
        'ADULT': 'user',
        'CHILD': 'child',
        'EMERGENCY': 'exclamation-triangle'
    };
    return icons[patientType] || 'user';
}

// Get gender icon
function getGenderIcon(gender) {
    const icons = {
        'MALE': 'mars',
        'FEMALE': 'venus'
    };
    return icons[gender] || 'user';
}

// Photo upload functionality
function initializePhotoUpload() {
    const photoInput = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    const photoUploadSection = document.getElementById('photoUploadSection');
    
    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type
                if (!file.type.match('image/jpeg|image/jpg')) {
                    showAlert('Please select a valid JPEG/JPG image file', 'error');
                    photoInput.value = '';
                    return;
                }
                
                // Validate file size (100KB limit)
                if (file.size > 100000) {
                    showAlert('File size must be less than 100KB', 'error');
                    photoInput.value = '';
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (photoPreview) {
                        photoPreview.src = e.target.result;
                        photoPreview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
                
                showAlert('Photo uploaded successfully', 'success');
            }
        });
    }
    
    // Drag and drop functionality
    if (photoUploadSection) {
        photoUploadSection.addEventListener('dragover', function(e) {
            e.preventDefault();
            photoUploadSection.style.borderColor = 'var(--hospital-primary)';
            photoUploadSection.style.backgroundColor = 'rgba(44, 90, 160, 0.1)';
        });
        
        photoUploadSection.addEventListener('dragleave', function(e) {
            e.preventDefault();
            photoUploadSection.style.borderColor = 'var(--hospital-primary)';
            photoUploadSection.style.backgroundColor = 'var(--hospital-light)';
        });
        
        photoUploadSection.addEventListener('drop', function(e) {
            e.preventDefault();
            photoUploadSection.style.borderColor = 'var(--hospital-primary)';
            photoUploadSection.style.backgroundColor = 'var(--hospital-light)';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                photoInput.files = files;
                photoInput.dispatchEvent(new Event('change'));
            }
        });
    }
}

// Autocomplete functionality
function initializeAutocomplete() {
    initializePaymentTypeAutocomplete();
    initializeSubtypeAutocomplete();
    initializeAccountAutocomplete();
    initializeStateAutocomplete();
}

// Payment type autocomplete
function initializePaymentTypeAutocomplete() {
    const paymentTypeInput = document.getElementById('searchpaymenttype');
    if (paymentTypeInput && typeof AutoSuggestControl !== 'undefined') {
        new AutoSuggestControl(paymentTypeInput, new StateSuggestions());
    }
}

// Subtype autocomplete
function initializeSubtypeAutocomplete() {
    const subtypeInput = document.getElementById('searchsubtype');
    if (subtypeInput && typeof AutoSuggestControl1 !== 'undefined') {
        new AutoSuggestControl1(subtypeInput, new StateSuggestions1());
    }
}

// Account autocomplete
function initializeAccountAutocomplete() {
    const accountInput = document.getElementById('searchaccountname');
    if (accountInput && typeof AutoSuggestControl2 !== 'undefined') {
        new AutoSuggestControl2(accountInput, new StateSuggestions2());
    }
}

// State autocomplete
function initializeStateAutocomplete() {
    const stateInput = document.getElementById('state');
    if (stateInput && typeof AutoSuggestControl23 !== 'undefined') {
        new AutoSuggestControl23(stateInput, new StateSuggestions3());
    }
}

// Age calculation functionality
function initializeAgeCalculation() {
    const dateOfBirth = document.getElementById('dateofbirth');
    const age = document.getElementById('age');
    const ageDuration = document.getElementById('ageduration');
    
    if (dateOfBirth) {
        dateOfBirth.addEventListener('change', calculateAge);
    }
    
    if (age) {
        age.addEventListener('input', calculateAgeFromInput);
    }
}

// Calculate age from date of birth
function calculateAge() {
    const dateOfBirth = document.getElementById('dateofbirth').value;
    const today = new Date();
    const todayString = today.toISOString().split('T')[0];
    
    if (!dateOfBirth) return;
    
    const birthDate = new Date(dateOfBirth);
    const todayDate = new Date(todayString);
    
    // Calculate difference in months
    const monthDiff = monthsBetween(birthDate, todayDate);
    
    if (monthDiff <= 12) {
        if (monthDiff === 0) {
            // Calculate days
            const dayDiff = Math.round((todayDate - birthDate) / (1000 * 60 * 60 * 24));
            document.getElementById('age').value = dayDiff;
            document.getElementById('ageduration').value = 'DAYS';
        } else {
            document.getElementById('age').value = monthDiff;
            document.getElementById('ageduration').value = 'MONTHS';
        }
    } else {
        // Calculate years
        let years = todayDate.getFullYear() - birthDate.getFullYear();
        const monthDiff2 = todayDate.getMonth() - birthDate.getMonth();
        
        if (monthDiff2 < 0 || (monthDiff2 === 0 && todayDate.getDate() < birthDate.getDate())) {
            years--;
        }
        
        document.getElementById('age').value = years;
        document.getElementById('ageduration').value = 'YEARS';
    }
    
    updateAgeIndicator();
    toggleNationalIDField();
}

// Calculate age from input
function calculateAgeFromInput() {
    const age = parseInt(document.getElementById('age').value);
    const ageDuration = document.getElementById('ageduration').value;
    
    if (!age || !ageDuration) return;
    
    if (ageDuration === 'YEARS') {
        // Calculate approximate date of birth
        const today = new Date();
        const birthYear = today.getFullYear() - age;
        const dob = birthYear + '-01-01';
        document.getElementById('dateofbirth').value = dob;
    }
    
    updateAgeIndicator();
    toggleNationalIDField();
}

// Calculate months between two dates
function monthsBetween(date1, date2) {
    return date2.getMonth() - date1.getMonth() + (12 * (date2.getFullYear() - date1.getFullYear()));
}

// Update age indicator
function updateAgeIndicator() {
    const age = document.getElementById('age').value;
    const ageDuration = document.getElementById('ageduration').value;
    
    if (age && ageDuration) {
        const indicator = document.getElementById('ageIndicator');
        if (indicator) {
            indicator.textContent = `${age} ${ageDuration}`;
            indicator.style.display = 'inline-block';
        }
    }
}

// Toggle National ID field based on age
function toggleNationalIDField() {
    const age = parseInt(document.getElementById('age').value);
    const ageDuration = document.getElementById('ageduration').value;
    const nationalID = document.getElementById('nationalidnumber');
    
    if (nationalID) {
        if (ageDuration === 'YEARS' && age >= 18) {
            nationalID.disabled = false;
        } else {
            nationalID.disabled = true;
            nationalID.value = '';
        }
    }
}

// Plan selection functionality
function initializePlanSelection() {
    const planSelect = document.getElementById('planname');
    if (planSelect) {
        planSelect.addEventListener('change', loadPlanDetails);
    }
}

// Load plan details
function loadPlanDetails() {
    const planName = document.getElementById('planname').value;
    
    if (!planName) {
        resetPlanFields();
        return;
    }
    
    // Make AJAX request to get plan details
    const dataString = "planname=" + planName;
    
    fetch('customerplanlimit.php?' + dataString)
        .then(response => response.text())
        .then(data => {
            const dataSplit = data.split("|");
            
            if (dataSplit.length >= 7) {
                document.getElementById('planexpirydate').value = dataSplit[0] || '';
                document.getElementById('planfixedamount').value = dataSplit[1] || '';
                document.getElementById('planpercentage').value = dataSplit[2] || '';
                document.getElementById('visitlimit').value = dataSplit[3] || '';
                document.getElementById('overalllimit').value = dataSplit[4] || '';
                document.getElementById('ipvisitlimit').value = dataSplit[5] || '';
                document.getElementById('ipoveralllimit').value = dataSplit[6] || '';
            }
        })
        .catch(error => {
            console.error('Error loading plan details:', error);
            showAlert('Error loading plan details', 'error');
        });
}

// Reset plan fields
function resetPlanFields() {
    document.getElementById('planexpirydate').value = '';
    document.getElementById('planfixedamount').value = '';
    document.getElementById('planpercentage').value = '';
    document.getElementById('visitlimit').value = '';
    document.getElementById('overalllimit').value = '';
    document.getElementById('ipvisitlimit').value = '';
    document.getElementById('ipoveralllimit').value = '';
}

// Gender selection functionality
function initializeGenderSelection() {
    // This is handled by the salutation change event
    // Additional gender-specific logic can be added here
}

// Validation
function initializeValidation() {
    // Real-time validation
    const formInputs = document.querySelectorAll('.form-input, .form-select');
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
    });
    
    // Name validation (alphabets only)
    const nameInputs = document.querySelectorAll('input[name*="name"]');
    nameInputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (!isAlphaKey(e)) {
                e.preventDefault();
            }
        });
    });
    
    // Numeric validation
    const numericInputs = document.querySelectorAll('input[type="number"], input[name="age"]');
    numericInputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (!isNumericKey(e)) {
                e.preventDefault();
            }
        });
    });
}

// Validate individual field
function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.getAttribute('name') || field.getAttribute('id');
    
    // Remove existing error class
    field.classList.remove('error');
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        field.classList.add('error');
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Specific field validations
    if (fieldName === 'customername' && value) {
        if (!/^[a-zA-Z\s]+$/.test(value)) {
            field.classList.add('error');
            showFieldError(field, 'Name should contain only letters');
            return false;
        }
    }
    
    if (fieldName === 'mobilenumber' && value) {
        if (!/^\d{10,15}$/.test(value.replace(/\D/g, ''))) {
            field.classList.add('error');
            showFieldError(field, 'Please enter a valid mobile number');
            return false;
        }
    }
    
    if (fieldName === 'emailid1' && value) {
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            field.classList.add('error');
            showFieldError(field, 'Please enter a valid email address');
            return false;
        }
    }
    
    if (fieldName === 'nationalidnumber' && value) {
        if (!/^[a-zA-Z0-9]+$/.test(value)) {
            field.classList.add('error');
            showFieldError(field, 'National ID should contain only letters and numbers');
            return false;
        }
    }
    
    return true;
}

// Show field error
function showFieldError(field, message) {
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Create error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

// Validate entire form
function validateForm() {
    let isValid = true;
    
    // Required fields validation
    const requiredFields = [
        { id: 'gender', message: 'Please select gender' },
        { id: 'customername', message: 'Please enter first name' },
        { id: 'searchpaymentcode', message: 'Please select payment type' },
        { id: 'searchsubcode', message: 'Please select sub type' },
        { id: 'searchaccountcode', message: 'Please select account name' }
    ];
    
    requiredFields.forEach(field => {
        const element = document.getElementById(field.id);
        if (element && !element.value.trim()) {
            element.classList.add('error');
            showFieldError(element, field.message);
            isValid = false;
        }
    });
    
    // Bill type specific validation
    const billType = document.getElementById('billtype');
    if (billType && billType.value === 'PAY LATER') {
        const accountName = document.getElementById('searchaccountname');
        const planName = document.getElementById('planname');
        
        if (!accountName.value.trim()) {
            accountName.classList.add('error');
            showFieldError(accountName, 'Please select account name');
            isValid = false;
        }
        
        if (!planName.value.trim()) {
            planName.classList.add('error');
            showFieldError(planName, 'Please select plan name');
            isValid = false;
        }
    }
    
    return isValid;
}

// Utility functions
function isAlphaKey(e) {
    const char = String.fromCharCode(e.which);
    return /[a-zA-Z\s]/.test(char) || e.which === 8 || e.which === 9; // Allow backspace and tab
}

function isNumericKey(e) {
    return (e.which >= 48 && e.which <= 57) || e.which === 8 || e.which === 9; // Allow backspace and tab
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} fade-in`;
    alertDiv.innerHTML = `
        <i class="fas fa-${getAlertIcon(type)} alert-icon"></i>
        <span>${message}</span>
    `;
    
    alertContainer.appendChild(alertDiv);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Get alert icon
function getAlertIcon(type) {
    const icons = {
        success: 'check-circle',
        error: 'exclamation-triangle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Refresh page
function refreshPage() {
    if (confirm('Are you sure you want to refresh the page? All unsaved data will be lost.')) {
        window.location.reload();
    }
}

// Reset form
function resetForm() {
    if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
        document.getElementById('emergencyPatientForm').reset();
        
        // Reset indicators
        updatePatientTypeIndicator('ADULT');
        updateGenderIndicator('');
        
        // Reset photo preview
        const photoPreview = document.getElementById('photoPreview');
        if (photoPreview) {
            photoPreview.style.display = 'none';
        }
        
        // Reset plan fields
        resetPlanFields();
        
        showAlert('Form reset successfully', 'success');
    }
}

// Global functions for backward compatibility
window.GetDifference1 = calculateAge;
window.dobcalc = calculateAgeFromInput;
window.funcGenderAutoSelect1 = handleSalutationChange;
window.funcVistLimit = loadPlanDetails;
window.process1 = validateForm;
window.namevalid = function(e) { return isAlphaKey(e); };
window.validatenumerics = function(e) { return isNumericKey(e); };
window.idhide = toggleNationalIDField;
window.refreshPage = refreshPage;
window.resetForm = resetForm;

