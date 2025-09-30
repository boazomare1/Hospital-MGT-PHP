/**
 * Lab Map Multiple - Modern JavaScript
 * Enhanced functionality for lab item mapping interface
 */

$(document).ready(function() {
    initializePage();
    initializeEventHandlers();
    initializeFormFeatures();
    loadUserPreferences();
});

/**
 * Initialize page functionality
 */
function initializePage() {
    // Initialize autocomplete
    initializeAutocomplete();
    
    // Initialize sidebar
    initializeSidebar();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize keyboard shortcuts
    initializeKeyboardShortcuts();
    
    // Show welcome message
    showWelcomeMessage();
}

/**
 * Initialize event handlers
 */
function initializeEventHandlers() {
    // Sidebar toggle
    $('#sidebarToggle').on('click', toggleSidebar);
    $('#menuToggle').on('click', toggleSidebar);
    
    // Form submission
    $('#form1').on('submit', handleSearchForm);
    $('#form2').on('submit', handleMapForm);
    
    // Auto-refresh functionality
    initializeAutoRefresh();
    
    // Search input enhancements
    $('#search1').on('input', debounce(handleSearchInput, 300));
    
    // Location change handler
    $('#location').on('change', handleLocationChange);
    
    // Map action clicks
    $(document).on('click', '.map-action', handleMapAction);
}

/**
 * Initialize autocomplete functionality
 */
function initializeAutocomplete() {
    $('#search1').autocomplete({
        source: function(request, response) {
            const searchTerm = request.term;
            if (searchTerm.length >= 1) {
                $.ajax({
                    url: 'ajax_labmapmultiple_search.php',
                    data: { pid: searchTerm },
                    dataType: 'json',
                    success: function(data) {
                        response(data.map(function(item) {
                            return {
                                label: item.label || item.value,
                                value: item.value,
                                mobile: item.mobile || item.id
                            };
                        }));
                    },
                    error: function() {
                        response([]);
                    }
                });
            } else {
                response([]);
            }
        },
        minLength: 1,
        html: true,
        select: function(event, ui) {
            const itemValue = ui.item.value;
            const itemCode = ui.item.mobile;
            
            $('#search1').val(itemValue);
            $('#searchitemcode').val(itemCode);
            
            // Auto-submit search
            setTimeout(() => {
                $('#form1').submit();
            }, 100);
            
            return false;
        },
        focus: function(event, ui) {
            return false;
        }
    });
}

/**
 * Handle search form submission
 */
function handleSearchForm(e) {
    e.preventDefault();
    
    const form = $(this);
    const formData = form.serialize();
    
    // Show loading state
    showLoadingState();
    
    // Validate form
    if (!validateSearchForm()) {
        hideLoadingState();
        return false;
    }
    
    // Submit form
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        success: function(response) {
            hideLoadingState();
            // Page will reload with results
        },
        error: function() {
            hideLoadingState();
            showAlert('Error occurred while searching. Please try again.', 'danger');
        }
    });
    
    return false;
}

/**
 * Handle map form submission
 */
function handleMapForm(e) {
    e.preventDefault();
    
    const form = $(this);
    
    // Validate form
    if (!validateMapForm()) {
        return false;
    }
    
    // Show loading state
    showLoadingState();
    
    // Submit form
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            hideLoadingState();
            showAlert('Item mapping completed successfully!', 'success');
            
            // Refresh results
            setTimeout(() => {
                $('#form1').submit();
            }, 1000);
        },
        error: function() {
            hideLoadingState();
            showAlert('Error occurred while mapping item. Please try again.', 'danger');
        }
    });
    
    return false;
}

/**
 * Handle search input changes
 */
function handleSearchInput() {
    const searchValue = $(this).val();
    
    // Clear item code if search is cleared
    if (searchValue === '') {
        $('#searchitemcode').val('');
    }
    
    // Update search suggestions
    updateSearchSuggestions(searchValue);
}

/**
 * Handle location change
 */
function handleLocationChange() {
    const location = $(this).val();
    
    if (location) {
        showAlert(`Location changed to: ${$(this).find('option:selected').text()}`, 'info');
        
        // Clear previous search results
        clearSearchResults();
    }
}

/**
 * Handle map action clicks
 */
function handleMapAction(e) {
    e.preventDefault();
    
    const itemCode = $(this).data('item-code');
    const rate = $(this).data('rate');
    
    if (!itemCode) {
        showAlert('Invalid item code. Please try again.', 'danger');
        return;
    }
    
    // Open mapping popup
    openMappingPopup(itemCode, rate);
}

/**
 * Open mapping popup window
 */
function openMappingPopup(itemCode, rate) {
    const popupUrl = `popup_labmapmultiple.php?callfrom=7&item=${itemCode}&rate=${rate}`;
    const popupWindow = window.open(
        popupUrl,
        'MappingPopup',
        'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100'
    );
    
    if (popupWindow) {
        popupWindow.focus();
        
        // Listen for popup completion
        const checkClosed = setInterval(() => {
            if (popupWindow.closed) {
                clearInterval(checkClosed);
                
                // Refresh the page to show updated mapping
                setTimeout(() => {
                    location.reload();
                }, 500);
            }
        }, 1000);
    } else {
        showAlert('Popup blocked. Please allow popups for this site.', 'warning');
    }
}

/**
 * Validate search form
 */
function validateSearchForm() {
    const location = $('#location').val();
    
    if (!location) {
        showAlert('Please select a location.', 'warning');
        $('#location').focus();
        return false;
    }
    
    return true;
}

/**
 * Validate map form
 */
function validateMapForm() {
    const locationCode = $('#locationcode').val();
    
    if (!locationCode) {
        showAlert('Please select a location.', 'warning');
        $('#locationcode').focus();
        return false;
    }
    
    return true;
}

/**
 * Initialize form features
 */
function initializeFormFeatures() {
    // Enhanced form inputs
    $('.form-input, .form-select').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
    
    // Real-time validation
    $('.form-input').on('blur', function() {
        validateField($(this));
    });
    
    // Form enhancement
    enhanceFormElements();
}

/**
 * Enhance form elements
 */
function enhanceFormElements() {
    // Add loading states to buttons
    $('.btn').on('click', function() {
        if ($(this).hasClass('btn-primary')) {
            $(this).addClass('loading');
            setTimeout(() => {
                $(this).removeClass('loading');
            }, 2000);
        }
    });
    
    // Add tooltips
    $('[title]').each(function() {
        $(this).tooltip({
            placement: 'top',
            trigger: 'hover'
        });
    });
}

/**
 * Initialize sidebar functionality
 */
function initializeSidebar() {
    // Check if sidebar should be collapsed
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed) {
        $('#leftSidebar').addClass('collapsed');
        $('#sidebarToggle i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
    }
    
    // Handle window resize
    handleWindowResize();
}

/**
 * Toggle sidebar visibility
 */
function toggleSidebar() {
    const sidebar = $('#leftSidebar');
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
 * Initialize form validation
 */
function initializeFormValidation() {
    // Custom validation rules
    $.validator.addMethod('requiredSelect', function(value, element) {
        return value !== '';
    }, 'Please select an option.');
    
    // Setup validation
    $('#form1').validate({
        rules: {
            location: {
                requiredSelect: true
            }
        },
        messages: {
            location: 'Please select a location.'
        },
        errorClass: 'error',
        validClass: 'valid',
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('field-error');
            element.after(error);
        }
    });
}

/**
 * Initialize keyboard shortcuts
 */
function initializeKeyboardShortcuts() {
    $(document).on('keydown', function(e) {
        // Ctrl + K: Focus search
        if (e.ctrlKey && e.keyCode === 75) {
            e.preventDefault();
            $('#search1').focus();
        }
        
        // Ctrl + R: Refresh
        if (e.ctrlKey && e.keyCode === 82) {
            e.preventDefault();
            refreshPage();
        }
        
        // Escape: Clear search
        if (e.keyCode === 27) {
            clearSearch();
        }
    });
}

/**
 * Initialize auto-refresh functionality
 */
function initializeAutoRefresh() {
    // Auto-refresh every 5 minutes
    setInterval(() => {
        if (document.visibilityState === 'visible') {
            refreshSearchResults();
        }
    }, 300000);
}

/**
 * Load user preferences
 */
function loadUserPreferences() {
    // Load sidebar state
    const sidebarCollapsed = localStorage.getItem('sidebarCollapsed');
    if (sidebarCollapsed === 'true') {
        $('#leftSidebar').addClass('collapsed');
        $('#sidebarToggle i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
    }
    
    // Load search preferences
    const lastSearch = localStorage.getItem('lastSearch');
    if (lastSearch && !$('#search1').val()) {
        $('#search1').val(lastSearch);
    }
}

/**
 * Save user preferences
 */
function saveUserPreferences() {
    localStorage.setItem('lastSearch', $('#search1').val());
}

/**
 * Show loading state
 */
function showLoadingState() {
    $('.results-container').addClass('loading');
    $('.btn-primary').prop('disabled', true).addClass('loading');
}

/**
 * Hide loading state
 */
function hideLoadingState() {
    $('.results-container').removeClass('loading');
    $('.btn-primary').prop('disabled', false).removeClass('loading');
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            ${message}
        </div>
    `;
    
    $('#alertContainer').html(alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        $('.alert').fadeOut();
    }, 5000);
}

/**
 * Clear search results
 */
function clearSearchResults() {
    $('.data-table tbody').empty();
    $('.results-count').text('0');
}

/**
 * Update search suggestions
 */
function updateSearchSuggestions(searchTerm) {
    if (searchTerm.length < 2) return;
    
    // Update autocomplete source
    $('#search1').autocomplete('option', 'source', function(request, response) {
        $.ajax({
            url: 'ajax_labmapmultiple_search.php',
            data: { pid: request.term },
            dataType: 'json',
            success: function(data) {
                response(data.map(function(item) {
                    return {
                        label: item.label || item.value,
                        value: item.value,
                        mobile: item.mobile || item.id
                    };
                }));
            }
        });
    });
}

/**
 * Validate individual field
 */
function validateField(field) {
    const value = field.val();
    const fieldName = field.attr('name');
    
    // Clear previous errors
    field.removeClass('error');
    field.siblings('.field-error').remove();
    
    // Validate based on field type
    if (fieldName === 'location' && !value) {
        field.addClass('error');
        field.after('<span class="field-error">Please select a location.</span>');
        return false;
    }
    
    return true;
}

/**
 * Clear search form
 */
function clearSearch() {
    $('#search1').val('');
    $('#searchitemcode').val('');
    clearSearchResults();
}

/**
 * Refresh page
 */
function refreshPage() {
    location.reload();
}

/**
 * Refresh search results
 */
function refreshSearchResults() {
    if ($('#search1').val()) {
        $('#form1').submit();
    }
}

/**
 * Show welcome message
 */
function showWelcomeMessage() {
    const username = $('.welcome-text strong').text();
    if (username) {
        showAlert(`Welcome back, ${username}! Ready to map lab items to suppliers.`, 'success');
    }
}

/**
 * Handle window resize
 */
function handleWindowResize() {
    $(window).on('resize', function() {
        // Auto-collapse sidebar on mobile
        if (window.innerWidth <= 768) {
            $('#leftSidebar').addClass('collapsed');
        } else {
            // Restore sidebar state on desktop
            const wasCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (!wasCollapsed) {
                $('#leftSidebar').removeClass('collapsed');
            }
        }
    });
}

/**
 * Debounce function for search input
 */
function debounce(func, wait) {
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

/**
 * Legacy function support
 */
function coasearch(varCallFrom, item) {
    openMappingPopup(item, '');
    return false;
}

function form1valid() {
    return validateSearchForm();
}

function form2Valid() {
    return validateMapForm();
}

function auditypeearch() {
    const search1 = document.getElementById('search1').value;
    
    $('#search1').autocomplete({
        source: "ajax_labmapmultiple_search.php?pid=" + search1,
        minLength: 1,
        html: true,
        select: function(event, ui) {
            const mobile = ui.item.value;
            const excessnov = ui.item.mobile;
            
            $("#search1").val(mobile);
            $("#searchitemcode").val(excessnov);
        }
    });
}

// Export functions for global access
window.coasearch = coasearch;
window.form1valid = form1valid;
window.form2Valid = form2Valid;
window.auditypeearch = auditypeearch;
