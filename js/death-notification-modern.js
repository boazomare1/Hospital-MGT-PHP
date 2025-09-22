// Death Notification List - Modern JavaScript

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
    
    // Setup table interactions
    setupTableInteractions();
    
    // Hide loading animation
    setTimeout(hideLoadingAnimation, 500);
}

function setupEventListeners() {
    // Search form submission
    $('#searchForm').on('submit', function(e) {
        if (!validateSearchForm()) {
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
    
    // Export functionality
    $('.btn-outline').on('click', function() {
        if ($(this).attr('onclick') === 'exportToExcel()') {
            exportToExcel();
        }
    });
    
    // Refresh functionality
    $('.btn-secondary').on('click', function() {
        if ($(this).attr('onclick') === 'refreshPage()') {
            refreshPage();
        }
    });
    
    // Search input real-time filtering
    $('#patient, #patientcode, #docnumber').on('input', function() {
        debounceSearch();
    });
    
    // Date range validation
    $('#ADate1, #ADate2').on('change', function() {
        validateDateRange();
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

function validateSearchForm() {
    let isValid = true;
    
    // Clear previous errors
    $('.form-input').removeClass('error');
    $('.error-message').remove();
    
    // Validate patient name (optional but if provided, should be valid)
    const patientName = $('#patient').val().trim();
    if (patientName && patientName.length < 2) {
        showFieldError($('#patient'), 'Patient name must be at least 2 characters');
        isValid = false;
    }
    
    // Validate registration number (optional but if provided, should be valid)
    const regNumber = $('#patientcode').val().trim();
    if (regNumber && regNumber.length < 2) {
        showFieldError($('#patientcode'), 'Registration number must be at least 2 characters');
        isValid = false;
    }
    
    // Validate document number (optional but if provided, should be valid)
    const docNumber = $('#docnumber').val().trim();
    if (docNumber && docNumber.length < 2) {
        showFieldError($('#docnumber'), 'Document number must be at least 2 characters');
        isValid = false;
    }
    
    // Validate date range
    if (!validateDateRange()) {
        isValid = false;
    }
    
    return isValid;
}

function validateDateRange() {
    const dateFrom = $('#ADate1').val();
    const dateTo = $('#ADate2').val();
    
    if (dateFrom && dateTo) {
        const fromDate = new Date(dateFrom);
        const toDate = new Date(dateTo);
        
        if (fromDate > toDate) {
            showFieldError($('#ADate1'), 'Start date cannot be after end date');
            showFieldError($('#ADate2'), 'End date cannot be before start date');
            return false;
        }
        
        // Check if date range is not too far in the future
        const today = new Date();
        if (fromDate > today || toDate > today) {
            showFieldError($('#ADate1'), 'Date cannot be in the future');
            showFieldError($('#ADate2'), 'Date cannot be in the future');
            return false;
        }
        
        // Check if date range is not too far in the past (more than 10 years)
        const tenYearsAgo = new Date();
        tenYearsAgo.setFullYear(tenYearsAgo.getFullYear() - 10);
        
        if (fromDate < tenYearsAgo) {
            showFieldError($('#ADate1'), 'Date cannot be more than 10 years in the past');
            return false;
        }
    }
    
    return true;
}

function validateField($field) {
    const value = $field.val().trim();
    const fieldName = $field.attr('name');
    
    clearFieldError($field);
    
    // Basic validation based on field type
    if (fieldName === 'patient' && value && value.length < 2) {
        showFieldError($field, 'Patient name must be at least 2 characters');
        return false;
    }
    
    if (fieldName === 'patientcode' && value && value.length < 2) {
        showFieldError($field, 'Registration number must be at least 2 characters');
        return false;
    }
    
    if (fieldName === 'docnumber' && value && value.length < 2) {
        showFieldError($field, 'Document number must be at least 2 characters');
        return false;
    }
    
    return true;
}

function showFieldError($field, message) {
    $field.addClass('error');
    
    // Remove existing error message
    $field.siblings('.error-message').remove();
    
    // Add new error message
    $field.after(`<div class="error-message" style="color: #e74c3c; font-size: 0.8rem; margin-top: 0.25rem;">${message}</div>`);
    
    // Add error styling
    $field.css({
        'border-color': '#e74c3c',
        'background-color': '#fdf2f2'
    });
}

function clearFieldError($field) {
    $field.removeClass('error');
    $field.siblings('.error-message').remove();
    $field.css({
        'border-color': '#ecf0f1',
        'background-color': '#f8f9fa'
    });
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

function setupTableInteractions() {
    // Add hover effects to table rows
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );
    
    // Add click effects to action buttons
    $('.action-btn').on('click', function(e) {
        // Add ripple effect
        addRippleEffect($(this), e);
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
        background: '#2c3e50',
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
                        border: 4px solid #ecf0f1;
                        border-top: 4px solid #3498db;
                        border-radius: 50%;
                        animation: spin 1s linear infinite;
                        margin: 0 auto 1rem;
                    "></div>
                    <p style="color: #2c3e50; font-weight: 600;">Loading...</p>
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
    $('#searchForm')[0].reset();
    $('.form-input').removeClass('error');
    $('.error-message').remove();
    
    // Reset to default dates
    const today = new Date();
    const oneMonthAgo = new Date();
    oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
    
    $('#ADate1').val(oneMonthAgo.toISOString().split('T')[0]);
    $('#ADate2').val(today.toISOString().split('T')[0]);
    
    // Show success message
    showNotification('Form reset successfully', 'success');
}

function refreshPage() {
    showLoadingAnimation();
    window.location.reload();
}

function exportToExcel() {
    showNotification('Export functionality will be implemented', 'info');
    
    // TODO: Implement actual Excel export
    // This would typically involve:
    // 1. Collecting all visible table data
    // 2. Converting to Excel format
    // 3. Triggering download
}

function viewDeathNotification(patientCode) {
    showNotification(`Viewing details for patient: ${patientCode}`, 'info');
    
    // TODO: Implement view functionality
    // This could open a modal or redirect to a details page
}

function showNotification(message, type = 'info') {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'error' ? 'alert-error' : 'alert-info';
    
    const iconClass = type === 'success' ? 'fa-check-circle' : 
                     type === 'error' ? 'fa-exclamation-triangle' : 'fa-info-circle';
    
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
    
    .data-table tbody tr.hover {
        background: #e8f4fd !important;
        transform: scale(1.005);
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
`;
document.head.appendChild(style);

