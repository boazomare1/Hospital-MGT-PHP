/**
 * Petty Cash Request Modern JavaScript
 * Modern functionality for the petty cash supervisor request system
 */

// Global variables
let isLoading = false;
let sidebarCollapsed = false;
let searchResults = [];

// Initialize when DOM is loaded
$(document).ready(function() {
    initializePage();
    setupEventListeners();
    setupFormValidation();
    initializeTooltips();
    initializeSidebar();
    initializeAutocomplete();
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
}

/**
 * Setup event listeners
 */
function setupEventListeners() {
    // Form submission
    $('.search-form').on('submit', function(e) {
        e.preventDefault();
        performSearch();
    });
    
    // Reset button
    $('.btn-secondary').on('click', function(e) {
        if ($(this).text().includes('Reset')) {
            resetForm();
        }
    });
    
    // Date input changes
    $('#ADate1, #ADate2').on('change', function() {
        validateDateRange();
        updateFormState();
    });
    
    // Search input changes
    $('#request, #empname').on('input', function() {
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
    
    // Table row clicks
    $('.modern-data-table tbody tr').on('click', function() {
        const viewLink = $(this).find('.action-btn.view');
        if (viewLink.length) {
            viewLink[0].click();
        }
    });
}

/**
 * Setup form validation
 */
function setupFormValidation() {
    // Validate all inputs on form submission
    $('.search-form').on('submit', function() {
        return validateForm();
    });
    
    // Real-time validation
    $('#request, #empname, #ADate1, #ADate2').on('blur', function() {
        validateField(this);
    });
    
    // Add input event listeners for real-time feedback
    $('#request, #empname').on('input', function() {
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
    
    // Add tooltips to action buttons
    $('.action-btn').each(function() {
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
        'request': 'Enter the request number to search for specific petty cash requests',
        'empname': 'Search for requests by username',
        'ADate1': 'Select the start date for your search range',
        'ADate2': 'Select the end date for your search range'
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
 * Initialize autocomplete functionality
 */
function initializeAutocomplete() {
    // Enhanced autocomplete for user search
    $('#empname').autocomplete({
        source: "ajaxuser_search.php",
        matchContains: true,
        minLength: 1,
        html: true,
        autoFocus: true,
        select: function(event, ui) {
            const userid = ui.item.usercode;
            const username = ui.item.username;
            
            $("#empcode").val(userid);
            $("#selectedempname").val(username);
            
            // Add visual feedback
            showInputSuccess($(this));
            
            // Track selection
            trackUserSelection(username, userid);
        },
        change: function(event, ui) {
            if (ui.item) {
                const userid = ui.item.usercode;
                const username = ui.item.username;
                $("#empcode").val(userid);
                $("#selectedempname").val(username);
            }
        },
        open: function() {
            $(this).addClass('autocomplete-open');
        },
        close: function() {
            $(this).removeClass('autocomplete-open');
        }
    });
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
    $('.search-form').on('submit', function() {
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
        $('.modern-data-table').addClass('mobile-table');
    } else if (windowWidth < 1024) {
        // Tablet layout
        $('.form-row').css('grid-template-columns', 'repeat(auto-fit, minmax(280px, 1fr))');
        $('.modern-data-table').removeClass('mobile-table');
    } else {
        // Desktop layout
        $('.form-row').css('grid-template-columns', 'repeat(auto-fit, minmax(300px, 1fr))');
        $('.modern-data-table').removeClass('mobile-table');
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
    
    const value = $field.val().trim();
    
    if (fieldId === 'ADate1' || fieldId === 'ADate2') {
        if (value === '') {
            errorMessage = 'Please select a date';
            isValid = false;
        } else if (!validateDateFormat(field)) {
            errorMessage = 'Please enter a valid date format (YYYY-MM-DD)';
            isValid = false;
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
    const fromDate = $('#ADate1').val().trim();
    const toDate = $('#ADate2').val().trim();
    
    if (fromDate && toDate) {
        const from = new Date(fromDate);
        const to = new Date(toDate);
        
        if (from > to) {
            showAlert('End date must be after or equal to start date', 'error');
            $('#ADate2').focus();
            return false;
        }
        
        // Check if the range is reasonable (not more than 1 year)
        const diffTime = Math.abs(to - from);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays > 365) { // More than 1 year
            showAlert('Date range should not exceed 1 year for better performance', 'warning');
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
    const fields = ['#request', '#empname', '#ADate1', '#ADate2'];
    
    // At least one search field should be filled
    let hasSearchCriteria = false;
    fields.forEach(fieldId => {
        if ($(fieldId).val().trim() !== '') {
            hasSearchCriteria = true;
        }
    });
    
    if (!hasSearchCriteria) {
        showAlert('Please enter at least one search criteria', 'error');
        return false;
    }
    
    // Validate date range if dates are provided
    if ($('#ADate1').val().trim() || $('#ADate2').val().trim()) {
        if (!validateDateRange()) {
            isValid = false;
        }
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
    const request = $('#request').val().trim();
    const empname = $('#empname').val().trim();
    const date1 = $('#ADate1').val().trim();
    const date2 = $('#ADate2').val().trim();
    
    const hasCriteria = request || empname || date1 || date2;
    const submitBtn = $('#submitBtn');
    
    if (hasCriteria) {
        submitBtn.prop('disabled', false);
        submitBtn.removeClass('btn-disabled');
    } else {
        submitBtn.prop('disabled', true);
        submitBtn.addClass('btn-disabled');
    }
}

/**
 * Perform search with validation
 */
function performSearch() {
    if (isLoading) return false;
    
    if (!validateForm()) {
        showAlert('Please fix the errors before searching', 'error');
        return false;
    }
    
    isLoading = true;
    showLoadingState();
    
    // Show search animation
    showSearchAnimation();
    
    // Track search
    trackSearch();
    
    // Submit the form after delay
    setTimeout(() => {
        hideLoadingState();
        isLoading = false;
        $('.search-form')[0].submit();
    }, 1000);
    
    return false; // Prevent default submission
}

/**
 * Reset form to initial state
 */
function resetForm() {
    if (confirm('Are you sure you want to reset the search form? All entered data will be lost.')) {
        // Clear all form inputs
        $('#request, #empname, #empcode, #selectedempname').val('').removeClass('success error has-value');
        
        // Reset dates to today
        const today = new Date().toISOString().split('T')[0];
        $('#ADate1, #ADate2').val(today).removeClass('success error');
        
        // Clear error messages
        $('.error-message').remove();
        
        // Show reset animation
        showResetAnimation();
        
        // Track reset event
        trackResetEvent();
        
        // Focus on first input
        $('#request').focus();
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
 * Show search animation
 */
function showSearchAnimation() {
    $('.search-form-section').addClass('search-animation');
    setTimeout(() => {
        $('.search-form-section').removeClass('search-animation');
    }, 2000);
}

/**
 * Show reset animation
 */
function showResetAnimation() {
    $('.search-form').addClass('reset-animation');
    setTimeout(() => {
        $('.search-form').removeClass('reset-animation');
    }, 300);
}

/**
 * Show input success feedback
 */
function showInputSuccess(input) {
    input.addClass('success-feedback');
    setTimeout(() => {
        input.removeClass('success-feedback');
    }, 1000);
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
 * Track user selection
 */
function trackUserSelection(username, userid) {
    console.log('User selection tracked:', {
        username: username,
        userid: userid,
        timestamp: new Date()
    });
}

/**
 * Track search event
 */
function trackSearch() {
    console.log('Search tracked:', {
        timestamp: new Date(),
        request: $('#request').val(),
        empname: $('#empname').val(),
        dateFrom: $('#ADate1').val(),
        dateTo: $('#ADate2').val()
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
 * Utility function to disable Enter key (legacy compatibility)
 */
function disableEnterKey() {
    if (event.keyCode === 13) {
        return false;
    }
    return true;
}

/**
 * Legacy function for form processing (maintained for compatibility)
 */
function additem1process1() {
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
    
    .search-animation {
        animation: searchGlow 2s ease-out;
    }
    
    @keyframes searchGlow {
        0% { 
            box-shadow: 0 0 0 0 rgba(30, 64, 175, 0.7);
        }
        50% { 
            box-shadow: 0 0 0 10px rgba(30, 64, 175, 0.1);
        }
        100% { 
            box-shadow: 0 0 0 0 rgba(30, 64, 175, 0);
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
    
    .success-feedback {
        animation: successPulse 0.5s ease-out;
    }
    
    @keyframes successPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }
    
    .btn-disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .btn-disabled:hover {
        transform: none !important;
        box-shadow: none !important;
    }
    
    .autocomplete-open {
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
    
    .modern-data-table.mobile-table {
        font-size: 0.7rem;
    }
    
    .modern-data-table.mobile-table th,
    .modern-data-table.mobile-table td {
        padding: 0.5rem 0.25rem;
    }
    
    .table-row {
        transition: all 0.3s ease;
    }
    
    .table-row:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
`;
document.head.appendChild(style);

