// Lab Result Edit - Modern JavaScript

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
    
    // Initialize search functionality
    initializeSearchFunctionality();
});

function initializePage() {
    // Add loading animation
    showLoadingAnimation();
    
    // Initialize tooltips
    initializeTooltips();
    
    // Setup form interactions
    setupFormInteractions();
    
    // Initialize data table features
    initializeDataTable();
    
    // Hide loading animation
    setTimeout(hideLoadingAnimation, 500);
}

function setupEventListeners() {
    // Search form submission
    $('form[name="cbform1"]').on('submit', function(e) {
        if (!validateSearchForm()) {
            e.preventDefault();
            return false;
        }
        
        showLoadingAnimation();
    });
    
    // Form reset
    $('input[type="reset"]').on('click', function() {
        resetSearchForm();
    });
    
    // Refresh functionality
    $('.btn-secondary').on('click', function() {
        if ($(this).attr('onclick') === 'refreshPage()') {
            refreshPage();
        }
    });
    
    // Export functionality
    $('.btn-outline').on('click', function() {
        if ($(this).attr('onclick') === 'exportToExcel()') {
            exportToExcel();
        }
    });
    
    // Real-time search for patient fields
    $('#patient, #patientcode, #visitcode, #docnumber').on('input', function() {
        debounceSearch();
    });
    
    // Table row selection
    $(document).on('click', '.data-table tbody tr', function() {
        toggleRowSelection($(this));
    });
    
    // Action button clicks
    $(document).on('click', '.action-btn', function(e) {
        e.stopPropagation();
        handleActionClick($(this));
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
    
    // Basic validation - at least one field should be filled
    const patientName = $('#patient').val().trim();
    const patientCode = $('#patientcode').val().trim();
    const visitCode = $('#visitcode').val().trim();
    const docNumber = $('#docnumber').val().trim();
    
    if (!patientName && !patientCode && !visitCode && !docNumber) {
        showNotification('Please enter at least one search criteria', 'warning');
        isValid = false;
    }
    
    return isValid;
}

function validateField($field) {
    const value = $field.val().trim();
    const fieldName = $field.attr('name');
    
    clearFieldError($field);
    
    // Basic validation based on field type
    if (fieldName === 'patientcode' && value && !isValidPatientCode(value)) {
        showFieldError($field, 'Please enter a valid patient code format');
        return false;
    }
    
    if (fieldName === 'visitcode' && value && !isValidVisitCode(value)) {
        showFieldError($field, 'Please enter a valid visit code format');
        return false;
    }
    
    return true;
}

function isValidPatientCode(code) {
    // Basic patient code validation - adjust pattern as needed
    return /^[A-Z0-9-]+$/i.test(code);
}

function isValidVisitCode(code) {
    // Basic visit code validation - adjust pattern as needed
    return /^[A-Z0-9-]+$/i.test(code);
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
    // Add hover effects to form elements
    $('.form-input').hover(
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
    
    // Add focus effects
    $('.form-input').on('focus', function() {
        $(this).addClass('focused');
    });
    
    $('.form-input').on('blur', function() {
        $(this).removeClass('focused');
    });
}

function initializeSearchFunctionality() {
    // Add search suggestions for patient name
    $('#patient').on('input', function() {
        const query = $(this).val();
        if (query.length >= 2) {
            // TODO: Implement patient name autocomplete
            // This could use AJAX to fetch patient suggestions
        }
    });
    
    // Add search suggestions for patient code
    $('#patientcode').on('input', function() {
        const query = $(this).val();
        if (query.length >= 2) {
            // TODO: Implement patient code autocomplete
        }
    });
    
    // Add search suggestions for visit code
    $('#visitcode').on('input', function() {
        const query = $(this).val();
        if (query.length >= 2) {
            // TODO: Implement visit code autocomplete
        }
    });
}

function initializeDataTable() {
    // Add sorting functionality to table headers
    $('.data-table th').each(function() {
        if ($(this).text().trim() !== 'No.' && $(this).text().trim() !== 'Action') {
            $(this).addClass('sortable');
            $(this).append(' <i class="fas fa-sort sort-icon"></i>');
        }
    });
    
    // Add click handlers for sorting
    $('.data-table th.sortable').on('click', function() {
        const column = $(this).index();
        const $table = $(this).closest('table');
        const $tbody = $table.find('tbody');
        const $rows = $tbody.find('tr').toArray();
        
        // Toggle sort direction
        const isAscending = $(this).hasClass('sort-asc');
        $('.data-table th').removeClass('sort-asc sort-desc');
        
        if (isAscending) {
            $(this).addClass('sort-desc');
            $(this).find('.sort-icon').removeClass('fa-sort fa-sort-up').addClass('fa-sort-down');
        } else {
            $(this).addClass('sort-asc');
            $(this).find('.sort-icon').removeClass('fa-sort fa-sort-down').addClass('fa-sort-up');
        }
        
        // Sort rows
        $rows.sort(function(a, b) {
            const aVal = $(a).find('td').eq(column).text().trim();
            const bVal = $(b).find('td').eq(column).text().trim();
            
            // Try to parse as numbers first
            const aNum = parseFloat(aVal);
            const bNum = parseFloat(bVal);
            
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return isAscending ? bNum - aNum : aNum - bNum;
            } else {
                return isAscending ? bVal.localeCompare(aVal) : aVal.localeCompare(bVal);
            }
        });
        
        // Re-append sorted rows
        $tbody.empty().append($rows);
    });
    
    // Add row highlighting on hover
    $('.data-table tbody tr').on('mouseenter', function() {
        $(this).addClass('highlight');
    }).on('mouseleave', function() {
        $(this).removeClass('highlight');
    });
    
    // Add selection functionality
    $('.data-table tbody tr').on('click', function() {
        $(this).toggleClass('selected');
        updateSelectionCount();
    });
}

function toggleRowSelection($row) {
    $row.toggleClass('selected');
    updateSelectionCount();
}

function updateSelectionCount() {
    const selectedCount = $('.data-table tbody tr.selected').length;
    const totalCount = $('.data-table tbody tr').length;
    
    if (selectedCount > 0) {
        showNotification(`${selectedCount} of ${totalCount} records selected`, 'info');
    }
}

function handleActionClick($button) {
    const action = $button.attr('title') || $button.text().trim();
    const href = $button.attr('href');
    
    if (href) {
        // Add loading animation for navigation
        showLoadingAnimation();
        
        // Navigate to the edit page
        window.location.href = href;
    } else {
        showNotification(`Action: ${action}`, 'info');
    }
}

function resetSearchForm() {
    $('form[name="cbform1"]')[0].reset();
    $('.form-input').removeClass('error');
    $('.error-message').remove();
    
    // Show success message
    showNotification('Search form reset successfully', 'success');
}

function debounceSearch() {
    clearTimeout(window.searchTimeout);
    window.searchTimeout = setTimeout(() => {
        // Optional: Add real-time search functionality here
        // This could show search suggestions or validate input
    }, 300);
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

// Global functions called from HTML
function refreshPage() {
    showLoadingAnimation();
    window.location.reload();
}

function exportToExcel() {
    showNotification('Export functionality will be implemented', 'info');
    
    // TODO: Implement Excel export functionality
    // This could generate an Excel file with the current search results
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
function cbsuppliername1() {
    document.cbform1.submit();
}

function pendingfunc(visitcode) {
    var varvisitcode = visitcode;
    window.open("pendinglabs.php?visitcode="+varvisitcode+"", "OriginalWindowA5", 'width=500,height=400,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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
    
    .form-input.hover {
        border-color: #1e40af;
        background-color: #ffffff;
    }
    
    .form-input.focused {
        border-color: #1e40af;
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
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
    
    .data-table th.sortable {
        cursor: pointer;
        user-select: none;
    }
    
    .data-table th.sortable:hover {
        background: #1e3a8a;
    }
    
    .data-table tr.highlight {
        background: #e0f2fe !important;
    }
    
    .data-table tr.selected {
        background: #dbeafe !important;
        border-left: 4px solid #1e40af;
    }
    
    .sort-icon {
        opacity: 0.7;
        margin-left: 0.25rem;
    }
    
    .data-table th.sort-asc .sort-icon,
    .data-table th.sort-desc .sort-icon {
        opacity: 1;
    }
    
    .alert-warning {
        background: #fef3c7;
        color: #92400e;
        border-left: 4px solid #f59e0b;
    }
`;
document.head.appendChild(style);

