/**
 * Edit Employee Info Modern JavaScript
 * Handles interactive elements for the employee editing system
 */

$(document).ready(function() {
    // Initialize the application
    initializeApp();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize form functionality
    initializeFormFeatures();
});

/**
 * Initialize the application
 */
function initializeApp() {
    console.log('Edit Employee Info Modern JS initialized');
    
    // Check if sidebar should be collapsed by default on mobile
    if (window.innerWidth <= 768) {
        $('.left-sidebar').addClass('collapsed');
    }
    
    // Setup form validation
    setupFormValidation();
    
    // Initialize autocomplete
    initializeAutocomplete();
}

/**
 * Setup event listeners
 */
function setupEventListeners() {
    // Floating menu toggle
    $('#menuToggle').on('click', function() {
        toggleSidebar();
    });
    
    // Sidebar toggle button
    $('#sidebarToggle').on('click', function() {
        toggleSidebar();
    });
    
    // Form submission
    $('#form1').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
    });
    
    // Search form submission
    $('#form2').on('submit', function(e) {
        if (!validateSearchForm()) {
            e.preventDefault();
            return false;
        }
    });
    
    // Auto-hide alerts
    $('.alert').each(function() {
        const alert = $(this);
        setTimeout(function() {
            alert.fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    });
    
    // Employee type change handler
    $('#employeetype').on('change', function() {
        handleEmployeeTypeChange();
    });
    
    // Employment status change handler
    $('#employmentstatus').on('change', function() {
        handleEmploymentStatusChange();
    });
    
    // Department change handler
    $('#department').on('change', function() {
        handleDepartmentChange();
    });
    
    // Category change handler
    $('#category').on('change', function() {
        handleCategoryChange();
    });
    
    // Photo upload preview
    $('input[name="employeeimg"]').on('change', function() {
        previewImage(this);
    });
    
    // Numeric validation for leave days
    $('.numeric-input').on('keypress', function(e) {
        validateNumeric(e);
    });
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl + / to focus search
        if (e.ctrlKey && e.which === 191) {
            e.preventDefault();
            $('#searchemployee').focus();
        }
    });
}

/**
 * Toggle sidebar visibility
 */
function toggleSidebar() {
    const sidebar = $('.left-sidebar');
    const toggleIcon = $('#sidebarToggle i');
    
    sidebar.toggleClass('collapsed');
    
    // Update toggle icon
    if (sidebar.hasClass('collapsed')) {
        toggleIcon.removeClass('fa-chevron-left').addClass('fa-chevron-right');
    } else {
        toggleIcon.removeClass('fa-chevron-right').addClass('fa-chevron-left');
    }
    
    // Store preference
    localStorage.setItem('sidebarCollapsed', sidebar.hasClass('collapsed'));
}

/**
 * Setup form validation
 */
function setupFormValidation() {
    // Real-time validation for required fields
    $('.form-input[required], .form-select[required]').on('blur', function() {
        validateField($(this));
    });
    
    // Email validation
    $('input[type="email"]').on('blur', function() {
        validateEmail($(this));
    });
    
    // Mobile number validation
    $('#mobile').on('blur', function() {
        validateMobile($(this));
    });
    
    // Date validation
    $('input[readonly]').on('change', function() {
        validateDate($(this));
    });
}

/**
 * Initialize form features
 */
function initializeFormFeatures() {
    // Setup conditional field visibility
    updateConditionalFields();
    
    // Initialize department units dropdown
    if ($('#deptunit').length) {
        updateDepartmentUnits();
    }
    
    // Setup file upload handlers
    setupFileUploadHandlers();
}

/**
 * Initialize autocomplete
 */
function initializeAutocomplete() {
    // Employee search autocomplete
    if ($('#searchemployee').length) {
        $('#searchemployee').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: 'ajax/employee_search.php',
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                $('#searchemployeecode').val(ui.item.value);
                $('#searchemployee').val(ui.item.label);
                return false;
            }
        });
    }
    
    // Bank name autocomplete
    if ($('#bankname').length) {
        $('#bankname').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: 'bankcodeajax.php',
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                $('#bankcode').val(ui.item.bankcode);
                return false;
            }
        });
    }
}

/**
 * Validate the entire form
 */
function validateForm() {
    let isValid = true;
    
    // Validate required fields
    $('.form-input[required], .form-select[required]').each(function() {
        if (!validateField($(this))) {
            isValid = false;
        }
    });
    
    // Validate employee name
    if (!validateEmployeeName()) {
        isValid = false;
    }
    
    // Validate mobile number
    if (!validateMobile($('#mobile'))) {
        isValid = false;
    }
    
    // Validate passport number
    if (!validatePassportNumber()) {
        isValid = false;
    }
    
    // Validate category-specific fields
    if (!validateCategoryFields()) {
        isValid = false;
    }
    
    return isValid;
}

/**
 * Validate search form
 */
function validateSearchForm() {
    const searchInput = $('#searchemployee');
    
    if (searchInput.val().trim() === '') {
        showFieldError(searchInput, 'Please select an employee');
        searchInput.focus();
        return false;
    }
    
    return true;
}

/**
 * Validate individual field
 */
function validateField(field) {
    const value = field.val().trim();
    const isRequired = field.prop('required');
    
    clearFieldError(field);
    
    if (isRequired && value === '') {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    return true;
}

/**
 * Validate employee name
 */
function validateEmployeeName() {
    const field = $('#employeename');
    const value = field.val().trim();
    
    clearFieldError(field);
    
    if (value === '') {
        showFieldError(field, 'Employee name is required');
        return false;
    }
    
    if (value.length < 2) {
        showFieldError(field, 'Employee name must be at least 2 characters');
        return false;
    }
    
    return true;
}

/**
 * Validate mobile number
 */
function validateMobile(field) {
    const value = field.val().trim();
    
    clearFieldError(field);
    
    if (value === '') {
        showFieldError(field, 'Mobile number is required');
        return false;
    }
    
    const mobileRegex = /^[0-9]{10,15}$/;
    if (!mobileRegex.test(value.replace(/[\s\-\(\)]/g, ''))) {
        showFieldError(field, 'Please enter a valid mobile number');
        return false;
    }
    
    return true;
}

/**
 * Validate email
 */
function validateEmail(field) {
    const value = field.val().trim();
    
    if (value === '') return true; // Email is optional
    
    clearFieldError(field);
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(value)) {
        showFieldError(field, 'Please enter a valid email address');
        return false;
    }
    
    return true;
}

/**
 * Validate passport number
 */
function validatePassportNumber() {
    const field = $('#passportnumber');
    const value = field.val().trim();
    
    clearFieldError(field);
    
    if (value === '') {
        showFieldError(field, 'National ID / Passport number is required');
        return false;
    }
    
    return true;
}

/**
 * Validate category-specific fields
 */
function validateCategoryFields() {
    const category = $('#category').val();
    let isValid = true;
    
    if (category === 'Permanent' || category === 'Contract' || category === 'MCK Stationing') {
        // Validate PIN number
        if (!validateField($('#pinno'))) isValid = false;
        
        // Validate NSSF
        if (!validateField($('#nssf'))) isValid = false;
        
        // Validate NHIF
        if (!validateField($('#nhif'))) isValid = false;
        
        // Validate bank name
        if (!validateField($('#bankname'))) isValid = false;
        
        // Validate account number
        if (!validateField($('#accountnumber'))) isValid = false;
    }
    
    if (category === 'Casual' || category === 'Locum') {
        // Validate PIN number
        if (!validateField($('#pinno'))) isValid = false;
        
        // Validate bank name
        if (!validateField($('#bankname'))) isValid = false;
        
        // Validate account number
        if (!validateField($('#accountnumber'))) isValid = false;
    }
    
    return isValid;
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    clearFieldError(field);
    
    field.addClass('error');
    field.after(`<div class="field-error">${message}</div>`);
    
    // Scroll to field if not visible
    if (!isElementInViewport(field[0])) {
        $('html, body').animate({
            scrollTop: field.offset().top - 100
        }, 300);
    }
}

/**
 * Clear field error
 */
function clearFieldError(field) {
    field.removeClass('error');
    field.siblings('.field-error').remove();
}

/**
 * Handle employee type change
 */
function handleEmployeeTypeChange() {
    const employeeType = $('#employeetype').val();
    const conditionalFields = $('#onemptype');
    
    if (employeeType !== '') {
        conditionalFields.show();
    } else {
        conditionalFields.hide();
    }
}

/**
 * Handle employment status change
 */
function handleEmploymentStatusChange() {
    const employmentStatus = $('#employmentstatus').val();
    const conditionalFields = $('#onempstatus');
    
    if (employmentStatus !== '' && employmentStatus !== 'Alive') {
        conditionalFields.show();
    } else {
        conditionalFields.hide();
    }
}

/**
 * Handle department change
 */
function handleDepartmentChange() {
    updateDepartmentUnits();
}

/**
 * Update department units dropdown
 */
function updateDepartmentUnits() {
    const department = $('#department').val();
    const deptUnitSelect = $('#deptunit');
    
    // Clear existing options
    deptUnitSelect.empty();
    deptUnitSelect.append('<option value="">Select Unit</option>');
    
    if (department !== '') {
        // Fetch units for selected department
        $.ajax({
            url: 'ajax/department_units.php',
            dataType: 'json',
            data: { department: department },
            success: function(data) {
                data.forEach(function(unit) {
                    deptUnitSelect.append(`<option value="${unit}">${unit}</option>`);
                });
            }
        });
    }
}

/**
 * Handle category change
 */
function handleCategoryChange() {
    updateConditionalFields();
}

/**
 * Update conditional fields based on category
 */
function updateConditionalFields() {
    const category = $('#category').val();
    
    // Update field requirements based on category
    if (category === 'Permanent' || category === 'Contract' || category === 'MCK Stationing') {
        $('#pinno, #nssf, #nhif, #bankname, #accountnumber').prop('required', true);
    } else if (category === 'Casual' || category === 'Locum') {
        $('#pinno, #bankname, #accountnumber').prop('required', true);
        $('#nssf, #nhif').prop('required', false);
    } else {
        $('#pinno, #nssf, #nhif, #bankname, #accountnumber').prop('required', false);
    }
}

/**
 * Setup file upload handlers
 */
function setupFileUploadHandlers() {
    // Handle multiple file uploads
    $('input[type="file"][multiple]').on('change', function() {
        showSelectedFiles(this);
    });
}

/**
 * Show selected files
 */
function showSelectedFiles(input) {
    const files = input.files;
    const container = $(input).siblings('.file-list');
    
    if (container.length === 0) {
        $(input).after('<div class="file-list"></div>');
        container = $(input).siblings('.file-list');
    }
    
    container.empty();
    
    if (files.length > 0) {
        container.append('<h4>Selected Files:</h4>');
        Array.from(files).forEach(function(file, index) {
            container.append(`<div>${index + 1}. ${file.name}</div>`);
        });
    }
}

/**
 * Preview uploaded image
 */
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = $('#imagePreview');
            if (preview.length === 0) {
                $(input).after('<img id="imagePreview" class="employee-photo" style="display: none;">');
            }
            
            $('#imagePreview')
                .attr('src', e.target.result)
                .show();
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

/**
 * Validate numeric input
 */
function validateNumeric(e) {
    const keycode = e.which ? e.which : e.keyCode;
    
    if (keycode > 31 && (keycode < 48 || keycode > 57)) {
        e.preventDefault();
        return false;
    }
    
    return true;
}

/**
 * Refresh page
 */
function refreshPage() {
    showLoadingSpinner();
    setTimeout(function() {
        window.location.reload();
    }, 500);
}

/**
 * Clear search form
 */
function clearSearchForm() {
    $('#form2')[0].reset();
    $('#searchemployeecode').val('');
}

/**
 * Show loading spinner
 */
function showLoadingSpinner() {
    const spinner = `
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
            <span>Loading...</span>
        </div>
    `;
    
    $('body').append(spinner);
}

/**
 * Hide loading spinner
 */
function hideLoadingSpinner() {
    $('.loading-spinner').remove();
}

/**
 * Show alert message
 */
function showAlert(type, message) {
    const alertClass = `alert-${type}`;
    const iconClass = type === 'success' ? 'fa-check-circle' : 
                     type === 'error' ? 'fa-exclamation-triangle' : 
                     type === 'warning' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    const alert = `
        <div class="alert ${alertClass}">
            <i class="fas ${iconClass} alert-icon"></i>
            <span>${message}</span>
        </div>
    `;
    
    $('#alertContainer').html(alert);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 5000);
}

/**
 * Check if element is in viewport
 */
function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

/**
 * Handle window resize
 */
$(window).on('resize', function() {
    // Auto-collapse sidebar on mobile
    if (window.innerWidth <= 768) {
        $('.left-sidebar').addClass('collapsed');
    } else {
        // Restore sidebar state on desktop
        const wasCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (!wasCollapsed) {
            $('.left-sidebar').removeClass('collapsed');
        }
    }
});

/**
 * JavaScript functions for form validation (called from PHP)
 */
function process1() {
    return validateForm();
}

function from1submit1() {
    return validateSearchForm();
}

function fncemptype() {
    handleEmployeeTypeChange();
}

function fncempemploymentstatus() {
    handleEmploymentStatusChange();
}

function DeptUnitBuild() {
    updateDepartmentUnits();
}

function validatenumerics(key) {
    return validateNumeric(key);
}

function WindowRedirect() {
    window.location = "editemployeeinfo1.php";
}

/**
 * Add custom CSS for dynamic elements
 */
$(document).ready(function() {
    // Add custom styles for dynamic elements
    const customStyles = `
        <style>
            .field-error {
                color: #dc3545;
                font-size: 0.875rem;
                margin-top: 0.25rem;
                display: flex;
                align-items: center;
                gap: 0.25rem;
            }
            
            .field-error::before {
                content: '⚠';
                font-size: 0.75rem;
            }
            
            .form-input.error,
            .form-select.error {
                border-color: #dc3545;
                box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
            }
            
            .loading-spinner {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.9);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                font-size: 1.125rem;
                color: #2c5aa0;
            }
            
            .loading-spinner i {
                font-size: 2rem;
                margin-bottom: 1rem;
            }
            
            .file-list {
                margin-top: 1rem;
                padding: 1rem;
                background: #f8f9fa;
                border-radius: 0.5rem;
                border: 1px solid #dee2e6;
            }
            
            .file-list h4 {
                margin-bottom: 0.5rem;
                color: #495057;
            }
            
            .file-list div {
                padding: 0.25rem 0;
                color: #6c757d;
            }
            
            .numeric-input {
                text-align: right;
            }
            
            .conditional-fields {
                transition: all 0.3s ease;
            }
            
            .conditional-fields.hidden {
                display: none !important;
            }
        </style>
    `;
    
    $('head').append(customStyles);
});

