// Add Company Modern JavaScript - MedStar Hospital Management

$(document).ready(function() {
    // Initialize page
    initializePage();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize functionality
    initializeFunctionality();
});

function initializePage() {
    // Setup sidebar toggle
    $('#menuToggle').click(function() {
        $('#leftSidebar').toggleClass('collapsed');
        $(this).find('i').toggleClass('fa-bars fa-times');
    });
    
    // Setup sidebar toggle button
    $('#sidebarToggle').click(function() {
        $('#leftSidebar').toggleClass('collapsed');
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}

function setupEventListeners() {
    // Form validation
    $('form').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
    });
    
    // Real-time form validation
    $('#companyname, #state, #city, #emailid1, #emailid2').on('blur', function() {
        validateField($(this));
    });
    
    // Auto-format inputs
    $('#tinnumber, #cstnumber').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });
    
    $('#patientcodeprefix').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });
    
    // Phone number formatting
    $('#phonenumber1, #phonenumber2, #faxnumber1, #faxnumber2').on('input', function() {
        formatPhoneNumber($(this));
    });
}

function initializeFunctionality() {
    // Initialize any additional functionality
    console.log('Add Company page initialized');
    
    // Load saved form data
    loadFormData();
    
    // Setup state-city dependency
    setupStateCityDependency();
}

// Original functions from the legacy code
function disableEnterKey() {
    if (event.keyCode == 8) {
        event.keyCode = 0;
        return event.keyCode;
        return false;
    }
    
    var key;
    if (window.event) {
        key = window.event.keyCode; // IE
    } else {
        key = e.which; // firefox
    }
    
    if (key == 13) { // if enter key press
        return false;
    } else {
        return true;
    }
}

function process1backkeypress1() {
    if (event.keyCode == 8) {
        event.keyCode = 0;
        return event.keyCode;
        return false;
    }
}

function processflowitem(varstate) {
    var varProcessID = varstate;
    var varItemNameSelected = document.getElementById("state").value;
    ajaxprocess5(varProcessID);
}

function processflowitem1() {
    // This function is handled by the modern state-city dependency setup
}

function from1submit1() {
    // Modern form validation
    return validateForm();
}

// Modern utility functions
function showAlert(message, type) {
    var alertClass = 'alert-' + type;
    var iconClass = 'fas fa-info-circle';
    
    switch(type) {
        case 'success':
            iconClass = 'fas fa-check-circle';
            break;
        case 'error':
            iconClass = 'fas fa-exclamation-triangle';
            break;
        case 'warning':
            iconClass = 'fas fa-exclamation-circle';
            break;
    }
    
    var alertHtml = '<div class="alert ' + alertClass + '">' +
        '<i class="' + iconClass + ' alert-icon"></i>' +
        '<span>' + message + '</span>' +
        '</div>';
    
    $('#alertContainer').html(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}

function validateForm() {
    var isValid = true;
    var errors = [];
    
    // Check required fields
    if ($('#companyname').val().trim() === '') {
        errors.push('Company Name is required');
        $('#companyname').addClass('error');
        isValid = false;
    } else {
        $('#companyname').removeClass('error');
    }
    
    if ($('#state').val().trim() === '') {
        errors.push('State is required');
        $('#state').addClass('error');
        isValid = false;
    } else {
        $('#state').removeClass('error');
    }
    
    if ($('#city').val().trim() === '') {
        errors.push('City is required');
        $('#city').addClass('error');
        isValid = false;
    } else {
        $('#city').removeClass('error');
    }
    
    // Validate email addresses
    var email1 = $('#emailid1').val().trim();
    if (email1 !== '' && !isValidEmail(email1)) {
        errors.push('Primary Email is not valid');
        $('#emailid1').addClass('error');
        isValid = false;
    } else {
        $('#emailid1').removeClass('error');
    }
    
    var email2 = $('#emailid2').val().trim();
    if (email2 !== '' && !isValidEmail(email2)) {
        errors.push('Secondary Email is not valid');
        $('#emailid2').addClass('error');
        isValid = false;
    } else {
        $('#emailid2').removeClass('error');
    }
    
    // Display errors if any
    if (!isValid) {
        showAlert(errors.join('<br>'), 'error');
    }
    
    return isValid;
}

function validateField(field) {
    var fieldName = field.attr('name');
    var fieldValue = field.val().trim();
    var isValid = true;
    var errorMessage = '';
    
    switch(fieldName) {
        case 'companyname':
            if (fieldValue === '') {
                errorMessage = 'Company Name is required';
                isValid = false;
            }
            break;
            
        case 'state':
            if (fieldValue === '') {
                errorMessage = 'State is required';
                isValid = false;
            }
            break;
            
        case 'city':
            if (fieldValue === '') {
                errorMessage = 'City is required';
                isValid = false;
            }
            break;
            
        case 'emailid1':
        case 'emailid2':
            if (fieldValue !== '' && !isValidEmail(fieldValue)) {
                errorMessage = 'Please enter a valid email address';
                isValid = false;
            }
            break;
    }
    
    if (isValid) {
        field.removeClass('error');
        field.next('.field-error').remove();
    } else {
        field.addClass('error');
        if (field.next('.field-error').length === 0) {
            field.after('<div class="field-error" style="color: #dc2626; font-size: 0.8rem; margin-top: 0.25rem;">' + errorMessage + '</div>');
        }
    }
    
    return isValid;
}

function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function formatPhoneNumber(input) {
    var value = input.val().replace(/\D/g, '');
    var formattedValue = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
    input.val(formattedValue);
}

function refreshPage() {
    window.location.reload();
}

function clearForm() {
    $('#form1')[0].reset();
    $('.error').removeClass('error');
    $('.field-error').remove();
}

// State-City dependency setup
function setupStateCityDependency() {
    $('#state').on('change', function() {
        var state = $(this).val();
        if (state) {
            loadCitiesForState(state);
        } else {
            $('#city').html('<option value="">Select City</option>');
        }
    });
}

function loadCitiesForState(state) {
    $.ajax({
        url: 'ajax/getcities.php',
        method: 'POST',
        data: { state: state },
        dataType: 'json',
        success: function(cities) {
            var citySelect = $('#city');
            citySelect.html('<option value="">Select City</option>');
            
            cities.forEach(function(city) {
                citySelect.append('<option value="' + city + '">' + city + '</option>');
            });
        },
        error: function() {
            console.log('Error loading cities');
        }
    });
}

// Form auto-save functionality
function saveFormData() {
    var formData = {
        companyname: $('#companyname').val(),
        address1: $('#address1').val(),
        address2: $('#address2').val(),
        area: $('#area').val(),
        state: $('#state').val(),
        city: $('#city').val(),
        country: $('#country').val(),
        pincode: $('#pincode').val(),
        phonenumber1: $('#phonenumber1').val(),
        phonenumber2: $('#phonenumber2').val(),
        faxnumber1: $('#faxnumber1').val(),
        faxnumber2: $('#faxnumber2').val(),
        emailid1: $('#emailid1').val(),
        emailid2: $('#emailid2').val(),
        tinnumber: $('#tinnumber').val(),
        cstnumber: $('#cstnumber').val(),
        currencyname: $('#currencyname').val(),
        currencydecimalname: $('#currencydecimalname').val(),
        currencycode: $('#currencycode').val(),
        patientcodeprefix: $('#patientcodeprefix').val(),
        showlogo: $('#showlogo').val()
    };
    
    localStorage.setItem('addcompany_form_data', JSON.stringify(formData));
}

function loadFormData() {
    var savedData = localStorage.getItem('addcompany_form_data');
    if (savedData) {
        var formData = JSON.parse(savedData);
        
        // Only load if form is empty
        if ($('#companyname').val() === '') {
            Object.keys(formData).forEach(function(key) {
                $('#' + key).val(formData[key]);
            });
        }
    }
}

// Auto-save form data
$(document).ready(function() {
    $('input, select').on('change', function() {
        saveFormData();
    });
});

// Enhanced form submission
$('#form1').on('submit', function(e) {
    if (!validateForm()) {
        e.preventDefault();
        return false;
    }
    
    // Show loading state
    $(this).addClass('form-loading');
    $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
    
    // Clear form data from localStorage on successful submission
    setTimeout(function() {
        localStorage.removeItem('addcompany_form_data');
    }, 1000);
});

// Keyboard shortcuts
$(document).keydown(function(e) {
    // Ctrl + S for save
    if (e.ctrlKey && e.which === 83) {
        e.preventDefault();
        $('#form1').submit();
    }
    
    // Ctrl + R for refresh
    if (e.ctrlKey && e.which === 82) {
        e.preventDefault();
        refreshPage();
    }
    
    // Escape to clear form
    if (e.which === 27) {
        if (confirm('Are you sure you want to clear the form?')) {
            clearForm();
        }
    }
});

// Enhanced error handling
window.onerror = function(msg, url, lineNo, columnNo, error) {
    console.error('JavaScript Error:', {
        message: msg,
        source: url,
        line: lineNo,
        column: columnNo,
        error: error
    });
    
    showAlert('An error occurred. Please refresh the page.', 'error');
    return false;
};

// Form field focus management
$('input, select, textarea').on('focus', function() {
    $(this).closest('.form-group').addClass('focused');
}).on('blur', function() {
    $(this).closest('.form-group').removeClass('focused');
});

// Auto-format company code display
function updateCompanyCode() {
    var companyCode = $('#companycode').val();
    if (companyCode) {
        $('#companycode').val(companyCode.toUpperCase());
    }
}

// Initialize company code formatting
$(document).ready(function() {
    updateCompanyCode();
});

// Form section animations
function animateFormSections() {
    $('.form-group-section').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });
}

$(document).ready(function() {
    animateFormSections();
});

// Enhanced phone number validation
function validatePhoneNumber(phone) {
    var phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
    return phoneRegex.test(phone.replace(/\D/g, ''));
}

// Add phone number validation to form
$('#phonenumber1, #phonenumber2, #faxnumber1, #faxnumber2').on('blur', function() {
    var phone = $(this).val().trim();
    if (phone !== '' && !validatePhoneNumber(phone)) {
        $(this).addClass('error');
        if ($(this).next('.field-error').length === 0) {
            $(this).after('<div class="field-error" style="color: #dc2626; font-size: 0.8rem; margin-top: 0.25rem;">Please enter a valid phone number</div>');
        }
    } else {
        $(this).removeClass('error');
        $(this).next('.field-error').remove();
    }
});

// Enhanced TIN/CST number validation
function validateTaxNumber(number, type) {
    var cleanNumber = number.replace(/\D/g, '');
    if (type === 'TIN') {
        return cleanNumber.length >= 10 && cleanNumber.length <= 15;
    } else if (type === 'CST') {
        return cleanNumber.length >= 8 && cleanNumber.length <= 12;
    }
    return false;
}

$('#tinnumber').on('blur', function() {
    var tin = $(this).val().trim();
    if (tin !== '' && !validateTaxNumber(tin, 'TIN')) {
        $(this).addClass('error');
        if ($(this).next('.field-error').length === 0) {
            $(this).after('<div class="field-error" style="color: #dc2626; font-size: 0.8rem; margin-top: 0.25rem;">Please enter a valid TIN number (10-15 digits)</div>');
        }
    } else {
        $(this).removeClass('error');
        $(this).next('.field-error').remove();
    }
});

$('#cstnumber').on('blur', function() {
    var cst = $(this).val().trim();
    if (cst !== '' && !validateTaxNumber(cst, 'CST')) {
        $(this).addClass('error');
        if ($(this).next('.field-error').length === 0) {
            $(this).after('<div class="field-error" style="color: #dc2626; font-size: 0.8rem; margin-top: 0.25rem;">Please enter a valid CST number (8-12 digits)</div>');
        }
    } else {
        $(this).removeClass('error');
        $(this).next('.field-error').remove();
    }
});


