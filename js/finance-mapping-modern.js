/**
 * Finance Mapping Modern JavaScript
 * Modern functionality for the finance mapping system
 */

// Global variables
let isLoading = false;
let sidebarCollapsed = false;
let mappingData = {};

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
    $('.mapping-form').on('submit', function(e) {
        e.preventDefault();
        performSubmission();
    });
    
    // Reset button
    $('.btn-secondary').on('click', function(e) {
        if ($(this).text().includes('Reset')) {
            resetForm();
        }
    });
    
    // Autocomplete input focus
    $('.autocomplete-input').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
    
    // Form input changes
    $('.autocomplete-input').on('input', function() {
        validateMappingInput(this);
    });
}

/**
 * Setup form validation
 */
function setupFormValidation() {
    // Validate all inputs on form submission
    $('.mapping-form').on('submit', function() {
        return validateAllMappings();
    });
    
    // Real-time validation
    $('.autocomplete-input').on('blur', function() {
        validateMappingInput(this);
    });
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    // Add tooltips to mapping items
    $('.mapping-item').each(function() {
        $(this).tooltip({
            placement: 'top',
            trigger: 'hover',
            title: 'Click to configure this finance mapping'
        });
    });
    
    // Add tooltips to form elements
    $('.autocomplete-input').each(function() {
        $(this).tooltip({
            placement: 'top',
            trigger: 'focus',
            title: 'Start typing to search for ledger accounts'
        });
    });
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
    // Enhanced autocomplete for all inputs
    $('.autocomplete-input').each(function() {
        const inputId = $(this).attr('id');
        if (inputId && inputId.startsWith('ledger_name')) {
            setupEnhancedAutocomplete(this);
        }
    });
}

/**
 * Setup enhanced autocomplete for an input
 */
function setupEnhancedAutocomplete(input) {
    const inputId = $(input).attr('id');
    const lastChar = inputId.replace("ledger_name", "");
    
    $(input).autocomplete({
        source: 'accountnamefinanceajaxall.php',
        minLength: 1,
        delay: 300,
        html: true,
        autoFocus: true,
        select: function(event, ui) {
            const accountId = ui.item.account_id || ui.item.saccountid;
            $('#ledger_id' + lastChar).val(accountId);
            
            // Add visual feedback
            showInputSuccess($(input));
            
            // Track mapping
            trackMapping(lastChar, ui.item.value, accountId);
        },
        change: function(event, ui) {
            if (ui.item) {
                const accountId = ui.item.account_id || ui.item.saccountid;
                $('#ledger_id' + lastChar).val(accountId);
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
    $('.mapping-form').on('submit', function() {
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
    $('.autocomplete-input').each(function() {
        if ($(this).val().trim() !== '') {
            $(this).addClass('has-value');
        }
    });
    
    // Add change detection
    $('.autocomplete-input').on('input', function() {
        if ($(this).val().trim() !== '') {
            $(this).addClass('has-value');
        } else {
            $(this).removeClass('has-value');
        }
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
        $('.mapping-grid').css('grid-template-columns', '1fr');
        $('.form-actions').css('flex-direction', 'column');
    } else if (windowWidth < 1024) {
        // Tablet layout
        $('.mapping-grid').css('grid-template-columns', 'repeat(auto-fit, minmax(350px, 1fr))');
    } else {
        // Desktop layout
        $('.mapping-grid').css('grid-template-columns', 'repeat(auto-fit, minmax(400px, 1fr))');
    }
}

/**
 * Validate mapping input
 */
function validateMappingInput(input) {
    const value = $(input).val().trim();
    const inputId = $(input).attr('id');
    
    if (value === '') {
        $(input).removeClass('valid invalid');
        return true;
    }
    
    // Check if corresponding ledger_id exists
    const lastChar = inputId.replace("ledger_name", "");
    const ledgerId = $('#ledger_id' + lastChar).val();
    
    if (ledgerId && ledgerId !== '') {
        $(input).addClass('valid').removeClass('invalid');
        return true;
    } else {
        $(input).addClass('invalid').removeClass('valid');
        return false;
    }
}

/**
 * Validate all mappings
 */
function validateAllMappings() {
    let isValid = true;
    const invalidInputs = [];
    
    $('.autocomplete-input').each(function() {
        if (!validateMappingInput(this)) {
            isValid = false;
            invalidInputs.push(this);
        }
    });
    
    if (!isValid) {
        showAlert('Please complete all ledger mappings before saving.', 'error');
        
        // Focus on first invalid input
        if (invalidInputs.length > 0) {
            $(invalidInputs[0]).focus();
        }
    }
    
    return isValid;
}

/**
 * Perform form submission with validation
 */
function performSubmission() {
    if (isLoading) return false;
    
    if (!validateAllMappings()) {
        return false;
    }
    
    isLoading = true;
    showLoadingState();
    
    // Simulate submission delay (remove in production)
    setTimeout(() => {
        hideLoadingState();
        isLoading = false;
        
        // Show success animation
        showSuccessAnimation();
        
        // Track submission
        trackSubmission();
        
        // Submit the form
        $('.mapping-form')[0].submit();
    }, 1000);
    
    return false; // Prevent default submission
}

/**
 * Reset form to initial state
 */
function resetForm() {
    if (confirm('Are you sure you want to reset all mappings? This action cannot be undone.')) {
        // Clear all autocomplete inputs
        $('.autocomplete-input').each(function() {
            $(this).val('').removeClass('valid invalid has-value');
        });
        
        // Clear all hidden ledger_id inputs
        $('input[id^="ledger_id"]').val('');
        
        // Show reset animation
        showResetAnimation();
        
        // Track reset event
        trackResetEvent();
        
        // Focus on first input
        $('.autocomplete-input').first().focus();
    }
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
    $('.mapping-item').each(function(index) {
        $(this).css('animation-delay', `${index * 0.1}s`);
        $(this).addClass('success-animation');
    });
    
    setTimeout(() => {
        $('.mapping-item').removeClass('success-animation');
    }, 2000);
}

/**
 * Show reset animation
 */
function showResetAnimation() {
    $('.mapping-form').addClass('reset-animation');
    setTimeout(() => {
        $('.mapping-form').removeClass('reset-animation');
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
 * Track mapping selection
 */
function trackMapping(mappingId, ledgerName, ledgerId) {
    mappingData[mappingId] = {
        ledgerName: ledgerName,
        ledgerId: ledgerId,
        timestamp: new Date()
    };
    
    console.log('Mapping tracked:', mappingData[mappingId]);
}

/**
 * Track form submission
 */
function trackSubmission() {
    console.log('Form submission tracked:', {
        timestamp: new Date(),
        mappingCount: Object.keys(mappingData).length,
        mappings: mappingData
    });
}

/**
 * Track reset event
 */
function trackResetEvent() {
    console.log('Form reset tracked:', {
        timestamp: new Date(),
        previousMappings: mappingData
    });
    
    // Clear tracking data
    mappingData = {};
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
function process1() {
    return validateAllMappings();
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
    
    .valid {
        border-color: #2ecc71 !important;
        background: rgba(46, 204, 113, 0.05);
    }
    
    .invalid {
        border-color: #e74c3c !important;
        background: rgba(231, 76, 60, 0.05);
    }
    
    .autocomplete-open {
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
    
    .success-feedback {
        animation: successPulse 0.5s ease-out;
    }
    
    @keyframes successPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }
    
    .success-animation {
        animation: successGlow 2s ease-out;
    }
    
    @keyframes successGlow {
        0% { 
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7);
            transform: scale(1);
        }
        50% { 
            box-shadow: 0 0 0 10px rgba(46, 204, 113, 0.1);
            transform: scale(1.02);
        }
        100% { 
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0);
            transform: scale(1);
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
    
    .mapping-item {
        transition: all 0.3s ease;
    }
    
    .mapping-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
`;
document.head.appendChild(style);

