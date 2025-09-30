/**
 * Financial Year Modern JavaScript
 * Modern functionality for the financial year management system
 */

// Global variables
let isLoading = false;
let sidebarCollapsed = false;

// Initialize when DOM is loaded
$(document).ready(function() {
    initializePage();
    setupEventListeners();
    setupFormValidation();
    initializeTooltips();
    initializeSidebar();
    initializeDateValidation();
});

/**
 * Initialize page functionality
 */
function initializePage() {
    // Add loading states
    addLoadingStates();
    
    // Setup responsive behavior
    setupResponsiveBehavior();
    
    // Initialize form enhancements
    initializeFormEnhancements();
    
    // Add smooth scrolling
    $('a[href*="#"]').on('click', function(e) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 500);
        }
    });
    
    // Initialize date picker enhancements
    initializeDatePickerEnhancements();
}

/**
 * Setup event listeners
 */
function setupEventListeners() {
    // Form submission
    $('.add-form').on('submit', function(e) {
        e.preventDefault();
        performSubmission();
    });
    
    // Reset button
    $('.btn-secondary').on('click', function(e) {
        if ($(this).text().includes('Reset')) {
            resetForm();
        }
    });
    
    // Date input changes
    $('#fromyear, #toyear').on('change', function() {
        validateDateRange();
        updateFormState();
    });
    
    // Comments input
    $('#comments').on('input', function() {
        updateFormState();
    });
    
    // Page refresh button
    $('button[onclick="refreshPage()"]').on('click', function() {
        refreshPage();
    });
    
    // Export button
    $('button[onclick="exportToExcel()"]').on('click', function() {
        exportToExcel();
    });
}

/**
 * Setup form validation
 */
function setupFormValidation() {
    // Validate all inputs on form submission
    $('.add-form').on('submit', function() {
        return validateForm();
    });
    
    // Real-time validation
    $('#fromyear, #toyear, #comments').on('blur', function() {
        validateField(this);
    });
    
    // Add input event listeners for real-time feedback
    $('#fromyear, #toyear, #comments').on('input', function() {
        clearFieldError(this);
    });
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    // Add tooltips to form elements
    $('.form-input').each(function() {
        $(this).tooltip({
            placement: 'top',
            trigger: 'focus',
            title: getTooltipText($(this).attr('id'))
        });
    });
    
    // Add tooltips to buttons
    $('.btn').each(function() {
        $(this).tooltip({
            placement: 'top',
            trigger: 'hover'
        });
    });
}

/**
 * Get tooltip text for form elements
 */
function getTooltipText(elementId) {
    const tooltips = {
        'fromyear': 'Select the start date of the financial year',
        'toyear': 'Select the end date of the financial year',
        'comments': 'Add any additional notes or comments about this financial year'
    };
    return tooltips[elementId] || '';
}

/**
 * Initialize sidebar functionality
 */
function initializeSidebar() {
    // Sidebar toggle functionality
    $('#sidebarToggle').on('click', function() {
        toggleSidebar();
    });
    
    // Floating menu toggle
    $('#menuToggle').on('click', function() {
        toggleSidebar();
    });
    
    // Close sidebar when clicking outside on mobile
    $(document).on('click', function(e) {
        if ($(window).width() <= 1024) {
            if (!$(e.target).closest('.left-sidebar, #menuToggle').length) {
                if (!sidebarCollapsed) {
                    toggleSidebar();
                }
            }
        }
    });
    
    // Handle window resize
    $(window).on('resize', function() {
        if ($(window).width() > 1024) {
            $('.left-sidebar').removeClass('collapsed');
            $('.main-container-with-sidebar').removeClass('sidebar-collapsed');
            sidebarCollapsed = false;
        }
    });
}

/**
 * Initialize date validation
 */
function initializeDateValidation() {
    // Set minimum date to current year
    const currentYear = new Date().getFullYear();
    const minDate = currentYear - 5; // Allow 5 years back
    const maxDate = currentYear + 10; // Allow 10 years forward
    
    // Add validation attributes
    $('#fromyear').attr('data-min-year', minDate);
    $('#toyear').attr('data-min-year', minDate);
    $('#fromyear').attr('data-max-year', maxDate);
    $('#toyear').attr('data-max-year', maxDate);
}

/**
 * Initialize date picker enhancements
 */
function initializeDatePickerEnhancements() {
    // Enhance date picker styling
    $('.date-picker-icon').on('click', function() {
        const inputId = $(this).prev('input').attr('id');
        showDatePickerTooltip(inputId);
    });
    
    // Add date format validation
    $('#fromyear, #toyear').on('blur', function() {
        validateDateFormat(this);
    });
}

/**
 * Show date picker tooltip
 */
function showDatePickerTooltip(inputId) {
    const tooltipText = inputId === 'fromyear' ? 
        'Select the financial year start date' : 
        'Select the financial year end date';
    
    showTemporaryTooltip($('#' + inputId), tooltipText);
}

/**
 * Show temporary tooltip
 */
function showTemporaryTooltip(element, text) {
    element.attr('title', text).tooltip('show');
    
    setTimeout(() => {
        element.tooltip('hide');
    }, 3000);
}

/**
 * Toggle sidebar visibility
 */
function toggleSidebar() {
    sidebarCollapsed = !sidebarCollapsed;
    
    if (sidebarCollapsed) {
        $('.left-sidebar').addClass('collapsed');
        $('.main-container-with-sidebar').addClass('sidebar-collapsed');
        $('#sidebarToggle i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
    } else {
        $('.left-sidebar').removeClass('collapsed');
        $('.main-container-with-sidebar').removeClass('sidebar-collapsed');
        $('#sidebarToggle i').removeClass('fa-chevron-right').addClass('fa-chevron-left');
    }
    
    // Store sidebar state in localStorage
    localStorage.setItem('sidebarCollapsed', sidebarCollapsed);
}

/**
 * Add loading states to buttons and forms
 */
function addLoadingStates() {
    // Add loading state to submit button
    $('.add-form').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.addClass('loading');
        submitBtn.prop('disabled', true);
        
        // Simulate loading (remove in production)
        setTimeout(() => {
            submitBtn.removeClass('loading');
            submitBtn.prop('disabled', false);
        }, 2000);
    });
}

/**
 * Initialize form enhancements
 */
function initializeFormEnhancements() {
    // Add input validation classes
    $('.form-input').each(function() {
        if ($(this).val().trim() !== '') {
            $(this).addClass('has-value');
        }
    });
    
    // Add change detection
    $('.form-input').on('input', function() {
        if ($(this).val().trim() !== '') {
            $(this).addClass('has-value');
        } else {
            $(this).removeClass('has-value');
        }
    });
    
    // Add focus effects
    $('.form-input').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
}

/**
 * Setup responsive behavior
 */
function setupResponsiveBehavior() {
    // Handle window resize
    $(window).on('resize', function() {
        adjustLayout();
    });
    
    // Initial adjustment
    adjustLayout();
}

/**
 * Adjust layout for different screen sizes
 */
function adjustLayout() {
    const windowWidth = $(window).width();
    
    if (windowWidth < 768) {
        // Mobile layout adjustments
        $('.form-row').css('grid-template-columns', '1fr');
        $('.form-actions').css('flex-direction', 'column');
        $('.year-info').css('flex-direction', 'column');
    } else if (windowWidth < 1024) {
        // Tablet layout
        $('.form-row').css('grid-template-columns', 'repeat(auto-fit, minmax(280px, 1fr))');
    } else {
        // Desktop layout
        $('.form-row').css('grid-template-columns', 'repeat(auto-fit, minmax(300px, 1fr))');
    }
}

/**
 * Validate individual field
 */
function validateField(field) {
    const $field = $(field);
    const fieldId = $field.attr('id');
    let isValid = true;
    let errorMessage = '';
    
    // Clear previous errors
    clearFieldError($field);
    
    if ($field.val().trim() === '') {
        if (fieldId === 'fromyear') {
            errorMessage = 'Please select the financial year start date';
        } else if (fieldId === 'toyear') {
            errorMessage = 'Please select the financial year end date';
        } else if (fieldId === 'comments') {
            errorMessage = 'Please enter comments for this financial year';
        }
        
        isValid = false;
    } else if (fieldId === 'fromyear' || fieldId === 'toyear') {
        // Validate date format
        if (!validateDateFormat(field)) {
            isValid = false;
            errorMessage = 'Please enter a valid date format (YYYY-MM-DD)';
        }
    }
    
    if (!isValid) {
        showFieldError($field, errorMessage);
    } else {
        showFieldSuccess($field);
    }
    
    return isValid;
}

/**
 * Validate date format
 */
function validateDateFormat(field) {
    const dateValue = $(field).val().trim();
    const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
    
    if (!dateRegex.test(dateValue)) {
        return false;
    }
    
    // Check if it's a valid date
    const date = new Date(dateValue);
    return date instanceof Date && !isNaN(date);
}

/**
 * Validate date range
 */
function validateDateRange() {
    const fromDate = $('#fromyear').val().trim();
    const toDate = $('#toyear').val().trim();
    
    if (fromDate && toDate) {
        const from = new Date(fromDate);
        const to = new Date(toDate);
        
        if (from >= to) {
            showAlert('End date must be after start date', 'error');
            $('#toyear').focus();
            return false;
        }
        
        // Check if the range is reasonable (not more than 2 years)
        const diffTime = Math.abs(to - from);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays > 730) { // More than 2 years
            showAlert('Financial year should not exceed 2 years', 'warning');
        }
        
        return true;
    }
    
    return false;
}

/**
 * Validate entire form
 */
function validateForm() {
    let isValid = true;
    const fields = ['#fromyear', '#toyear', '#comments'];
    
    // Validate all fields
    fields.forEach(fieldId => {
        const field = $(fieldId)[0];
        if (field && !validateField(field)) {
            isValid = false;
        }
    });
    
    // Validate date range
    if (isValid && !validateDateRange()) {
        isValid = false;
    }
    
    return isValid;
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    const $field = $(field);
    $field.addClass('error').removeClass('success');
    
    // Remove existing error message
    $field.siblings('.error-message').remove();
    
    // Add error message
    $field.after(`<div class="error-message">${message}</div>`);
    
    // Add shake animation
    $field.addClass('shake');
    setTimeout(() => $field.removeClass('shake'), 500);
}

/**
 * Show field success
 */
function showFieldSuccess(field) {
    const $field = $(field);
    $field.addClass('success').removeClass('error');
    $field.siblings('.error-message').remove();
}

/**
 * Clear field error
 */
function clearFieldError(field) {
    const $field = $(field);
    $field.removeClass('error');
    $field.siblings('.error-message').remove();
}

/**
 * Update form state
 */
function updateFormState() {
    const fromYear = $('#fromyear').val().trim();
    const toYear = $('#toyear').val().trim();
    const comments = $('#comments').val().trim();
    
    const isComplete = fromYear && toYear && comments;
    const submitBtn = $('#submitBtn');
    
    if (isComplete) {
        submitBtn.prop('disabled', false);
        submitBtn.removeClass('btn-disabled');
    } else {
        submitBtn.prop('disabled', true);
        submitBtn.addClass('btn-disabled');
    }
}

/**
 * Perform form submission with validation
 */
function performSubmission() {
    if (isLoading) return false;
    
    if (!validateForm()) {
        showAlert('Please fix the errors before submitting', 'error');
        return false;
    }
    
    isLoading = true;
    showLoadingState();
    
    // Show success animation
    showSuccessAnimation();
    
    // Track submission
    trackSubmission();
    
    // Submit the form after delay
    setTimeout(() => {
        hideLoadingState();
        isLoading = false;
        $('.add-form')[0].submit();
    }, 1000);
    
    return false; // Prevent default submission
}

/**
 * Reset form to initial state
 */
function resetForm() {
    if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
        // Clear all form inputs
        $('#fromyear, #toyear, #comments').val('').removeClass('success error has-value');
        
        // Clear error messages
        $('.error-message').remove();
        
        // Show reset animation
        showResetAnimation();
        
        // Track reset event
        trackResetEvent();
        
        // Focus on first input
        $('#fromyear').focus();
    }
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

/**
 * Export to Excel
 */
function exportToExcel() {
    showAlert('Export functionality will be implemented soon', 'info');
    // TODO: Implement actual export functionality
}

/**
 * Show loading state
 */
function showLoadingState() {
    $('.main-content').addClass('loading');
    $('#submitBtn').prop('disabled', true);
}

/**
 * Hide loading state
 */
function hideLoadingState() {
    $('.main-content').removeClass('loading');
    $('#submitBtn').prop('disabled', false);
}

/**
 * Show success animation
 */
function showSuccessAnimation() {
    $('.add-form-section').addClass('success-animation');
    setTimeout(() => {
        $('.add-form-section').removeClass('success-animation');
    }, 2000);
}

/**
 * Show reset animation
 */
function showResetAnimation() {
    $('.add-form').addClass('reset-animation');
    setTimeout(() => {
        $('.add-form').removeClass('reset-animation');
    }, 300);
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    const alertClass = `alert-${type}`;
    const alertHtml = `
        <div class="alert ${alertClass}">
            <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : (type === 'warning' ? 'exclamation-circle' : 'info-circle')} alert-icon"></i>
            <span>${message}</span>
        </div>
    `;
    
    $('#alertContainer').html(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        $('#alertContainer .alert').fadeOut();
    }, 5000);
}

/**
 * Track form submission
 */
function trackSubmission() {
    console.log('Form submission tracked:', {
        timestamp: new Date(),
        fromYear: $('#fromyear').val(),
        toYear: $('#toyear').val(),
        hasComments: $('#comments').val().trim() !== ''
    });
}

/**
 * Track reset event
 */
function trackResetEvent() {
    console.log('Form reset tracked:', {
        timestamp: new Date()
    });
}

/**
 * Legacy function for form processing (maintained for compatibility)
 */
function addward1process1() {
    return validateForm();
}

// Add CSS animations via JavaScript
const style = document.createElement('style');
style.textContent = `
    .focused {
        border-color: var(--medstar-primary) !important;
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1) !important;
    }
    
    .has-value {
        background: var(--background-primary);
        border-color: var(--medstar-primary-light);
    }
    
    .error {
        border-color: #e74c3c !important;
        background: rgba(231, 76, 60, 0.05);
    }
    
    .success {
        border-color: #2ecc71 !important;
        background: rgba(46, 204, 113, 0.05);
    }
    
    .error-message {
        color: #e74c3c;
        font-size: 0.8rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }
    
    .shake {
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .success-animation {
        animation: successGlow 2s ease-out;
    }
    
    @keyframes successGlow {
        0% { 
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7);
        }
        50% { 
            box-shadow: 0 0 0 10px rgba(46, 204, 113, 0.1);
        }
        100% { 
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0);
        }
    }
    
    .reset-animation {
        animation: resetShake 0.3s ease-out;
    }
    
    @keyframes resetShake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .btn-disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .btn-disabled:hover {
        transform: none !important;
        box-shadow: none !important;
    }
`;
document.head.appendChild(style);

