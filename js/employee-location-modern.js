// Employee Location & Store - Modern JavaScript

$(document).ready(function() {
    // Initialize page
    initializePage();
    
    // Setup event listeners
    setupEventListeners();
    
    // Auto-hide alerts after 5 seconds
    autoHideAlerts();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Setup responsive sidebar
    setupResponsiveSidebar();
});

function initializePage() {
    // Add loading animation
    showLoadingAnimation();
    
    // Initialize tooltips
    initializeTooltips();
    
    // Setup form interactions
    setupFormInteractions();
    
    // Hide loading animation
    setTimeout(hideLoadingAnimation, 500);
}

function setupEventListeners() {
    // Employee selection form submission
    $('#selectemployee').on('submit', function(e) {
        if (!validateEmployeeSelection()) {
            e.preventDefault();
            return false;
        }
        
        showLoadingAnimation();
    });
    
    // Employee assignment form submission
    $('#form1').on('submit', function(e) {
        if (!validateEmployeeAssignment()) {
            e.preventDefault();
            return false;
        }
        
        showLoadingAnimation();
    });
    
    // Form reset
    $('.btn-secondary').on('click', function() {
        if ($(this).attr('onclick') === 'resetForm()') {
            resetForm();
        }
    });
    
    // View all assignments
    $('.btn-outline').on('click', function() {
        if ($(this).attr('onclick') === 'viewAllAssignments()') {
            viewAllAssignments();
        }
    });
    
    // Refresh functionality
    $('.btn-secondary').on('click', function() {
        if ($(this).attr('onclick') === 'refreshPage()') {
            refreshPage();
        }
    });
    
    // Employee search input
    $('#searchsuppliername').on('input', function() {
        debounceSearch();
    });
    
    // Store checkbox changes
    $(document).on('change', 'input[name="store[]"]', function() {
        handleStoreSelection();
    });
    
    // Store radio changes
    $(document).on('change', 'input[name="storecode"]', function() {
        handleDefaultStoreSelection();
    });
}

function initializeFormValidation() {
    // Add real-time validation to form inputs
    $('.form-input').on('blur', function() {
        validateField($(this));
    });
    
    $('.form-input').on('input', function() {
        clearFieldError($(this));
    });
}

function validateEmployeeSelection() {
    let isValid = true;
    
    // Clear previous errors
    $('.form-input').removeClass('error');
    $('.error-message').remove();
    
    // Validate employee name
    const employeeName = $('#searchsuppliername').val().trim();
    const employeeCode = $('#searchemployeecode').val().trim();
    
    if (employeeName && !employeeCode) {
        showFieldError($('#searchsuppliername'), 'Please select an employee from the dropdown list');
        isValid = false;
    }
    
    if (!employeeName) {
        showFieldError($('#searchsuppliername'), 'Please enter an employee name to search');
        isValid = false;
    }
    
    return isValid;
}

function validateEmployeeAssignment() {
    let isValid = true;
    
    // Clear previous errors
    $('.form-input').removeClass('error');
    $('.error-message').remove();
    
    // Validate location selection
    const location = $('#emplocation').val();
    if (!location) {
        showFieldError($('#emplocation'), 'Please select a location');
        isValid = false;
    }
    
    // Validate store selection
    const selectedStores = $('input[name="store[]"]:checked').length;
    if (selectedStores === 0) {
        showNotification('Please select at least one store for the employee', 'error');
        isValid = false;
    }
    
    // Validate default store selection
    const defaultStore = $('input[name="storecode"]:checked').length;
    if (selectedStores > 0 && defaultStore === 0) {
        showNotification('Please select a default store', 'error');
        isValid = false;
    }
    
    return isValid;
}

function validateField($field) {
    const value = $field.val().trim();
    const fieldName = $field.attr('name');
    
    clearFieldError($field);
    
    // Basic validation based on field type
    if (fieldName === 'emplocation' && !value) {
        showFieldError($field, 'Please select a location');
        return false;
    }
    
    return true;
}

function showFieldError($field, message) {
    $field.addClass('error');
    
    // Remove existing error message
    $field.siblings('.error-message').remove();
    
    // Add new error message
    $field.after(`<div class="error-message" style="color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem;">${message}</div>`);
    
    // Add error styling
    $field.css({
        'border-color': '#ef4444',
        'background-color': '#fef2f2'
    });
}

function clearFieldError($field) {
    $field.removeClass('error');
    $field.siblings('.error-message').remove();
    $field.css({
        'border-color': '#e2e8f0',
        'background-color': '#f8fafc'
    });
}

function setupFormInteractions() {
    // Add hover effects to store items
    $('.store-item').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );
    
    // Add click effects to buttons
    $('.btn').on('click', function(e) {
        // Add ripple effect
        addRippleEffect($(this), e);
    });
}

function handleStoreSelection() {
    const selectedStores = $('input[name="store[]"]:checked').length;
    
    // Update UI based on selection
    if (selectedStores > 0) {
        $('.stores-section').addClass('has-selection');
        showNotification(`${selectedStores} store(s) selected`, 'info');
    } else {
        $('.stores-section').removeClass('has-selection');
    }
    
    // Validate default store selection
    const defaultStore = $('input[name="storecode"]:checked').val();
    if (defaultStore) {
        const isDefaultStoreSelected = $(`input[name="store[]"][value="${defaultStore}"]`).is(':checked');
        if (!isDefaultStoreSelected) {
            $('input[name="storecode"]:checked').prop('checked', false);
            showNotification('Default store must be one of the selected stores', 'warning');
        }
    }
}

function handleDefaultStoreSelection() {
    const defaultStore = $('input[name="storecode"]:checked').val();
    
    if (defaultStore) {
        // Ensure the default store is also selected
        $(`input[name="store[]"][value="${defaultStore}"]`).prop('checked', true);
        showNotification(`Store set as default`, 'success');
    }
}

function setupResponsiveSidebar() {
    const $sidebar = $('#leftSidebar');
    const $toggle = $('#sidebarToggle');
    const $menuToggle = $('#menuToggle');
    
    // Toggle sidebar
    $toggle.on('click', function() {
        $sidebar.toggleClass('collapsed');
        $(this).find('i').toggleClass('fa-chevron-left fa-chevron-right');
    });
    
    // Mobile menu toggle
    $menuToggle.on('click', function() {
        $sidebar.toggleClass('open');
    });
    
    // Close sidebar when clicking outside on mobile
    $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
            if (!$sidebar.is(e.target) && $sidebar.has(e.target).length === 0 && 
                !$menuToggle.is(e.target) && $menuToggle.has(e.target).length === 0) {
                $sidebar.removeClass('open');
            }
        }
    });
    
    // Handle window resize
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            $sidebar.removeClass('open');
        }
    });
}

function initializeTooltips() {
    // Simple tooltip implementation
    $('[title]').each(function() {
        const $this = $(this);
        const title = $this.attr('title');
        
        $this.removeAttr('title');
        
        $this.on('mouseenter', function() {
            showTooltip($this, title);
        });
        
        $this.on('mouseleave', function() {
            hideTooltip();
        });
    });
}

function showTooltip($element, text) {
    const tooltip = $(`<div class="tooltip">${text}</div>`);
    
    tooltip.css({
        position: 'absolute',
        background: '#1f2937',
        color: 'white',
        padding: '0.5rem 0.75rem',
        borderRadius: '4px',
        fontSize: '0.8rem',
        zIndex: 9999,
        pointerEvents: 'none',
        boxShadow: '0 2px 8px rgba(0,0,0,0.2)'
    });
    
    $('body').append(tooltip);
    
    const offset = $element.offset();
    tooltip.css({
        top: offset.top - tooltip.outerHeight() - 5,
        left: offset.left + ($element.outerWidth() / 2) - (tooltip.outerWidth() / 2)
    });
}

function hideTooltip() {
    $('.tooltip').remove();
}

function addRippleEffect($button, event) {
    const $ripple = $('<span class="ripple"></span>');
    const rect = $button[0].getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;
    
    $ripple.css({
        width: size,
        height: size,
        left: x,
        top: y,
        position: 'absolute',
        borderRadius: '50%',
        background: 'rgba(255,255,255,0.6)',
        transform: 'scale(0)',
        animation: 'ripple 0.6s linear',
        pointerEvents: 'none'
    });
    
    $button.css('position', 'relative').append($ripple);
    
    setTimeout(() => {
        $ripple.remove();
    }, 600);
}

function showLoadingAnimation() {
    if ($('#loadingOverlay').length === 0) {
        const loadingOverlay = $(`
            <div id="loadingOverlay" style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255,255,255,0.9);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            ">
                <div style="
                    background: white;
                    padding: 2rem;
                    border-radius: 8px;
                    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                    text-align: center;
                ">
                    <div class="spinner" style="
                        width: 40px;
                        height: 40px;
                        border: 4px solid #e2e8f0;
                        border-top: 4px solid #1e40af;
                        border-radius: 50%;
                        animation: spin 1s linear infinite;
                        margin: 0 auto 1rem;
                    "></div>
                    <p style="color: #1f2937; font-weight: 600;">Processing...</p>
                </div>
            </div>
        `);
        
        $('body').append(loadingOverlay);
    }
}

function hideLoadingAnimation() {
    $('#loadingOverlay').fadeOut(300, function() {
        $(this).remove();
    });
}

function autoHideAlerts() {
    $('.alert').each(function() {
        const $alert = $(this);
        setTimeout(() => {
            $alert.fadeOut(500, function() {
                $(this).remove();
            });
        }, 5000);
    });
}

function debounceSearch() {
    clearTimeout(window.searchTimeout);
    window.searchTimeout = setTimeout(() => {
        // Optional: Add real-time search functionality here
    }, 300);
}

// Global functions called from HTML
function resetForm() {
    $('#form1')[0].reset();
    $('.form-input').removeClass('error');
    $('.error-message').remove();
    
    // Clear all store selections
    $('input[name="store[]"]').prop('checked', false);
    $('input[name="storecode"]').prop('checked', false);
    
    // Show success message
    showNotification('Form reset successfully', 'success');
}

function refreshPage() {
    showLoadingAnimation();
    window.location.reload();
}

function viewAllAssignments() {
    showNotification('View all assignments functionality will be implemented', 'info');
    
    // TODO: Implement view all assignments functionality
    // This could redirect to a list page or open a modal
}

function showNotification(message, type = 'info') {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'error' ? 'alert-error' : 
                      type === 'warning' ? 'alert-warning' : 'alert-info';
    
    const iconClass = type === 'success' ? 'fa-check-circle' : 
                     type === 'error' ? 'fa-exclamation-triangle' : 
                     type === 'warning' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    const notification = $(`
        <div class="alert ${alertClass}" style="
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            min-width: 300px;
            animation: slideInRight 0.3s ease;
        ">
            <i class="fas ${iconClass} alert-icon"></i>
            <span>${message}</span>
        </div>
    `);
    
    $('body').append(notification);
    
    setTimeout(() => {
        notification.fadeOut(500, function() {
            $(this).remove();
        });
    }, 3000);
}

// Legacy function compatibility
function funcEmployeeSelect1(form) {
    if (!validateEmployeeSelection()) {
        return false;
    }
    
    const employeeCode = $('#searchemployeecode').val();
    if (!employeeCode) {
        showNotification('Please select an employee from the dropdown list', 'error');
        return false;
    }
    
    form.method = "post";
    form.action = "editemployeelocationandstore.php?eid=" + employeeCode;
    form.submit();
}

function addward1process1() {
    return validateEmployeeAssignment();
}

// Legacy function for location change
function FuncBranch(values) {
    // This function is handled by the legacy PHP-generated JavaScript
    // It dynamically populates the store list based on selected location
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .store-item.hover {
        background: #e0f2fe !important;
        border-color: #1e40af !important;
    }
    
    .left-sidebar.collapsed {
        width: 60px;
    }
    
    .left-sidebar.collapsed .nav-link span {
        display: none;
    }
    
    .left-sidebar.collapsed .sidebar-header h3 {
        display: none;
    }
    
    .stores-section.has-selection .stores-header {
        border-bottom-color: #1e40af;
    }
    
    .alert-warning {
        background: #fef3c7;
        color: #92400e;
        border-left: 4px solid #f59e0b;
    }
`;
document.head.appendChild(style);

