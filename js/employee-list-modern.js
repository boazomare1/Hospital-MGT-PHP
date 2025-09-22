/**
 * Employee List Modern JavaScript
 * Handles interactive elements for the employee list management system
 */

$(document).ready(function() {
    // Initialize the application
    initializeApp();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize table functionality
    initializeTableFeatures();
});

/**
 * Initialize the application
 */
function initializeApp() {
    console.log('Employee List Modern JS initialized');
    
    // Check if sidebar should be collapsed by default on mobile
    if (window.innerWidth <= 768) {
        $('.left-sidebar').addClass('collapsed');
    }
    
    // Setup form validation
    setupFormValidation();
    
    // Initialize autocomplete
    initializeAutocomplete();
    
    // Initialize bulk actions
    initializeBulkActions();
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
    
    // Search form submission
    $('#form1').on('submit', function(e) {
        if (!validateSearchForm()) {
            e.preventDefault();
            return false;
        }
    });
    
    // Bulk update form submission
    $('#form2').on('submit', function(e) {
        if (!validateBulkUpdateForm()) {
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
    
    // Checkbox change handlers
    $(document).on('change', '.employee-checkbox', function() {
        updateSelectedCount();
        updateSelectAllCheckbox();
    });
    
    $(document).on('change', '#selectAllCheckbox', function() {
        toggleSelectAll();
    });
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl + / to focus search
        if (e.ctrlKey && e.which === 191) {
            e.preventDefault();
            $('#searchemployee').focus();
        }
        
        // Escape to clear search
        if (e.which === 27) {
            clearSearchForm();
        }
        
        // Ctrl + A to select all
        if (e.ctrlKey && e.which === 65) {
            e.preventDefault();
            selectAll();
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
    // Real-time validation for search form
    $('#searchemployee').on('blur', function() {
        validateSearchInput($(this));
    });
}

/**
 * Initialize table features
 */
function initializeTableFeatures() {
    // Add row hover effects
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('hover-effect');
        },
        function() {
            $(this).removeClass('hover-effect');
        }
    );
    
    // Initialize tooltips for action buttons
    $('[title]').each(function() {
        const element = $(this);
        const title = element.attr('title');
        element.attr('data-tooltip', title);
    });
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
}

/**
 * Initialize bulk actions
 */
function initializeBulkActions() {
    // Show/hide bulk actions based on selection
    updateSelectedCount();
}

/**
 * Validate search form
 */
function validateSearchForm() {
    // Search form is optional, no validation needed
    return true;
}

/**
 * Validate search input
 */
function validateSearchInput(field) {
    const value = field.val().trim();
    
    clearFieldError(field);
    
    if (value.length > 0 && value.length < 2) {
        showFieldError(field, 'Search term must be at least 2 characters');
        return false;
    }
    
    return true;
}

/**
 * Validate bulk update form
 */
function validateBulkUpdateForm() {
    const statusSelect = $('#updatestatus');
    const checkboxes = $('.employee-checkbox:checked');
    
    clearFieldError(statusSelect);
    
    if (statusSelect.val() === '') {
        showFieldError(statusSelect, 'Please select a status to update');
        statusSelect.focus();
        return false;
    }
    
    if (checkboxes.length === 0) {
        showAlert('warning', 'Please select at least one employee to update');
        return false;
    }
    
    return confirm(`Are you sure you want to update the status of ${checkboxes.length} employee(s) to "${statusSelect.val()}"?`);
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    clearFieldError(field);
    
    field.addClass('error');
    field.after(`<div class="field-error">${message}</div>`);
}

/**
 * Clear field error
 */
function clearFieldError(field) {
    field.removeClass('error');
    field.siblings('.field-error').remove();
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
    $('#form1')[0].reset();
    $('#searchemployee').val('');
    $('#searchemployeecode').val('');
    $('#searchstatus').val('Active');
}

/**
 * Export employee list
 */
function exportEmployeeList() {
    // Create CSV content
    const table = $('#employeeTable');
    const rows = table.find('tbody tr');
    let csvContent = 'Payroll Number,Employee Code,Employee Name,Status\n';
    
    rows.each(function() {
        const row = $(this);
        const cells = row.find('td');
        
        // Skip the "no data" row
        if (cells.length > 1) {
            const payrollNo = cells.eq(2).text().trim();
            const empCode = cells.eq(3).text().trim();
            const empName = cells.eq(4).text().trim();
            const status = cells.eq(5).text().trim();
            csvContent += `"${payrollNo}","${empCode}","${empName}","${status}"\n`;
        }
    });
    
    // Download CSV
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'employee_list.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    showAlert('success', 'Employee list exported successfully!');
}

/**
 * Toggle bulk actions
 */
function toggleBulkActions() {
    const bulkActions = $('#bulkActions');
    bulkActions.slideToggle(300);
}

/**
 * Select all employees
 */
function selectAll() {
    const checkboxes = $('.employee-checkbox');
    const selectAllCheckbox = $('#selectAllCheckbox');
    const allChecked = checkboxes.filter(':checked').length === checkboxes.length;
    
    checkboxes.prop('checked', !allChecked);
    selectAllCheckbox.prop('checked', !allChecked);
    updateSelectedCount();
}

/**
 * Toggle select all checkbox
 */
function toggleSelectAll() {
    const selectAllCheckbox = $('#selectAllCheckbox');
    const checkboxes = $('.employee-checkbox');
    
    checkboxes.prop('checked', selectAllCheckbox.is(':checked'));
    updateSelectedCount();
}

/**
 * Clear selection
 */
function clearSelection() {
    const checkboxes = $('.employee-checkbox');
    const selectAllCheckbox = $('#selectAllCheckbox');
    
    checkboxes.prop('checked', false);
    selectAllCheckbox.prop('checked', false);
    updateSelectedCount();
}

/**
 * Update selected count
 */
function updateSelectedCount() {
    const checkboxes = $('.employee-checkbox:checked');
    const count = checkboxes.length;
    const countElement = $('#selectedCount');
    const bulkActions = $('#bulkActions');
    
    countElement.text(`${count} employee(s) selected`);
    
    // Show/hide bulk actions based on selection
    if (count > 0) {
        bulkActions.slideDown(300);
    } else {
        bulkActions.slideUp(300);
    }
}

/**
 * Update select all checkbox state
 */
function updateSelectAllCheckbox() {
    const checkboxes = $('.employee-checkbox');
    const checkedCheckboxes = $('.employee-checkbox:checked');
    const selectAllCheckbox = $('#selectAllCheckbox');
    
    if (checkedCheckboxes.length === 0) {
        selectAllCheckbox.prop('checked', false);
        selectAllCheckbox.prop('indeterminate', false);
    } else if (checkedCheckboxes.length === checkboxes.length) {
        selectAllCheckbox.prop('checked', true);
        selectAllCheckbox.prop('indeterminate', false);
    } else {
        selectAllCheckbox.prop('checked', false);
        selectAllCheckbox.prop('indeterminate', true);
    }
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
function from1submit1() {
    return validateBulkUpdateForm();
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
            
            .search-input.error,
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
            
            .hover-effect {
                background-color: #f8f9fa !important;
                transform: translateY(-1px);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            
            [data-tooltip] {
                position: relative;
            }
            
            [data-tooltip]:hover::after {
                content: attr(data-tooltip);
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                background: #333;
                color: white;
                padding: 0.5rem;
                border-radius: 0.25rem;
                font-size: 0.75rem;
                white-space: nowrap;
                z-index: 1000;
                margin-bottom: 0.25rem;
            }
            
            [data-tooltip]:hover::before {
                content: '';
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                border: 4px solid transparent;
                border-top-color: #333;
                z-index: 1000;
            }
            
            .bulk-actions {
                transition: all 0.3s ease;
            }
            
            .employee-checkbox:indeterminate {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }
        </style>
    `;
    
    $('head').append(customStyles);
});

