/**
 * Asset Register Modern JavaScript
 * Modern functionality for the asset register system
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
    initializeAssetSearch();
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
    
    // Location change
    $('#location').on('change', function() {
        handleLocationChange();
    });
    
    // Search input changes
    $('#searchitem').on('input', function() {
        updateFormState();
    });
    
    // Month/Year changes
    $('#search_month, #search_year').on('change', function() {
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
        handleTableRowClick(this);
    });
    
    // Action select changes
    $('.action-select').on('change', function() {
        handleActionSelect(this);
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
    $('#search_month, #search_year').on('blur', function() {
        validateField(this);
    });
    
    // Add input event listeners for real-time feedback
    $('#searchitem').on('input', function() {
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
    
    // Add tooltips to table elements
    $('.amount-badge').each(function() {
        $(this).tooltip({
            placement: 'top',
            trigger: 'hover',
            title: 'Click to view details'
        });
    });
}

/**
 * Get tooltip text for form elements
 */
function getTooltipText(elementId) {
    const tooltips = {
        'location': 'Select the location to filter assets',
        'searchitem': 'Search for assets by name or description',
        'search_month': 'Select the month for asset valuation',
        'search_year': 'Select the year for asset valuation'
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
 * Initialize asset search functionality
 */
function initializeAssetSearch() {
    // Enhanced search with debouncing
    let searchTimeout;
    $('#searchitem').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performLiveSearch();
        }, 500);
    });
    
    // Add search suggestions if needed
    setupSearchSuggestions();
}

/**
 * Setup search suggestions
 */
function setupSearchSuggestions() {
    // TODO: Implement asset search suggestions
    // This could be enhanced with AJAX calls to get asset suggestions
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
    
    if (fieldId === 'search_year' && $field.val() === '') {
        errorMessage = 'Please select a year';
        isValid = false;
    }
    
    if (!isValid) {
        showFieldError($field, errorMessage);
    } else {
        showFieldSuccess($field);
    }
    
    return isValid;
}

/**
 * Validate entire form
 */
function validateForm() {
    let isValid = true;
    
    // Check if at least one search criteria is provided
    const searchItem = $('#searchitem').val().trim();
    const month = $('#search_month').val().trim();
    const year = $('#search_year').val().trim();
    
    if (!searchItem && !month && !year) {
        showAlert('Please provide at least one search criteria', 'error');
        return false;
    }
    
    // Validate year if provided
    if (year && !validateField($('#search_year')[0])) {
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
    const searchItem = $('#searchitem').val().trim();
    const month = $('#search_month').val().trim();
    const year = $('#search_year').val().trim();
    
    const hasCriteria = searchItem || month || year;
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
 * Handle location change
 */
function handleLocationChange() {
    const location = $('#location').val();
    
    if (location) {
        // Update location display
        updateLocationDisplay(location);
        
        // Track location change
        trackLocationChange(location);
    }
}

/**
 * Update location display
 */
function updateLocationDisplay(locationCode) {
    // This would typically make an AJAX call to get location name
    // For now, we'll use the existing ajaxlocationfunction
    if (typeof ajaxlocationfunction === 'function') {
        ajaxlocationfunction(locationCode);
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
 * Perform live search (for real-time suggestions)
 */
function performLiveSearch() {
    const searchTerm = $('#searchitem').val().trim();
    
    if (searchTerm.length >= 2) {
        // TODO: Implement live search with AJAX
        console.log('Live search for:', searchTerm);
    }
}

/**
 * Reset form to initial state
 */
function resetForm() {
    if (confirm('Are you sure you want to reset the search form? All entered data will be lost.')) {
        // Clear all form inputs
        $('#searchitem').val('').removeClass('success error has-value');
        $('#search_year').val('').removeClass('success error');
        
        // Reset month to current month
        const currentMonth = new Date().getMonth() + 1;
        $('#search_month').val(currentMonth.toString().padStart(2, '0'));
        
        // Clear error messages
        $('.error-message').remove();
        
        // Show reset animation
        showResetAnimation();
        
        // Track reset event
        trackResetEvent();
        
        // Focus on first input
        $('#searchitem').focus();
    }
}

/**
 * Handle table row click
 */
function handleTableRowClick(row) {
    // Add visual feedback
    $(row).addClass('row-clicked');
    setTimeout(() => {
        $(row).removeClass('row-clicked');
    }, 200);
    
    // Track row click
    const assetId = $(row).find('.asset-id-badge').text();
    trackAssetRowClick(assetId);
}

/**
 * Handle action select change
 */
function handleActionSelect(select) {
    const selectedOption = $(select).find('option:selected');
    const actionUrl = selectedOption.val();
    
    if (actionUrl) {
        // Track action selection
        const actionType = selectedOption.text();
        trackAssetAction(actionType);
        
        // Open in new window
        window.open(actionUrl, '_blank');
        
        // Reset selection
        $(select).val('');
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
 * Track location change
 */
function trackLocationChange(locationCode) {
    console.log('Location change tracked:', {
        locationCode: locationCode,
        timestamp: new Date()
    });
}

/**
 * Track search event
 */
function trackSearch() {
    console.log('Search tracked:', {
        timestamp: new Date(),
        searchItem: $('#searchitem').val(),
        month: $('#search_month').val(),
        year: $('#search_year').val(),
        location: $('#location').val()
    });
}

/**
 * Track asset row click
 */
function trackAssetRowClick(assetId) {
    console.log('Asset row click tracked:', {
        assetId: assetId,
        timestamp: new Date()
    });
}

/**
 * Track asset action
 */
function trackAssetAction(actionType) {
    console.log('Asset action tracked:', {
        actionType: actionType,
        timestamp: new Date()
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
    
    .btn-disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .btn-disabled:hover {
        transform: none !important;
        box-shadow: none !important;
    }
    
    .row-clicked {
        background: var(--medstar-primary) !important;
        color: white !important;
        transform: scale(1.02);
    }
    
    .modern-data-table.mobile-table {
        font-size: 0.7rem;
        min-width: 600px;
    }
    
    .modern-data-table.mobile-table th,
    .modern-data-table.mobile-table td {
        padding: 0.25rem;
        font-size: 0.6rem;
    }
    
    .table-row {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .table-row:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .table-row:hover .amount-badge {
        transform: scale(1.05);
    }
    
    .table-row:hover .category-badge,
    .table-row:hover .asset-id-badge {
        transform: scale(1.05);
    }
`;
document.head.appendChild(style);

