/**
 * Employee Designation Modern JavaScript
 * Handles interactive elements for the employee designation management system
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
    console.log('Employee Designation Modern JS initialized');
    
    // Check if sidebar should be collapsed by default on mobile
    if (window.innerWidth <= 768) {
        $('.left-sidebar').addClass('collapsed');
    }
    
    // Setup form validation
    setupFormValidation();
    
    // Initialize search functionality
    initializeSearch();
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
    
    // Auto-hide alerts
    $('.alert').each(function() {
        const alert = $(this);
        setTimeout(function() {
            alert.fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    });
    
    // Search input functionality
    $('#searchInput').on('input', function() {
        filterTable();
    });
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl + / to focus search
        if (e.ctrlKey && e.which === 191) {
            e.preventDefault();
            $('#searchInput').focus();
        }
        
        // Escape to clear search
        if (e.which === 27) {
            clearSearch();
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
    const form = $('#form1');
    const designationInput = $('#designation');
    
    // Real-time validation
    designationInput.on('blur', function() {
        validateDesignationField();
    });
    
    designationInput.on('input', function() {
        clearFieldError($(this));
    });
}

/**
 * Validate the entire form
 */
function validateForm() {
    let isValid = true;
    
    // Validate designation field
    if (!validateDesignationField()) {
        isValid = false;
    }
    
    return isValid;
}

/**
 * Validate designation field
 */
function validateDesignationField() {
    const field = $('#designation');
    const value = field.val().trim();
    
    clearFieldError(field);
    
    if (value === '') {
        showFieldError(field, 'Designation name is required');
        return false;
    }
    
    if (value.length > 100) {
        showFieldError(field, 'Designation name must be 100 characters or less');
        return false;
    }
    
    // Check for valid characters (letters, numbers, spaces, hyphens, underscores)
    const validPattern = /^[a-zA-Z0-9\s\-_]+$/;
    if (!validPattern.test(value)) {
        showFieldError(field, 'Designation name contains invalid characters');
        return false;
    }
    
    return true;
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
    $('.btn-action').each(function() {
        const button = $(this);
        const title = button.attr('title');
        if (title) {
            button.attr('data-tooltip', title);
        }
    });
}

/**
 * Initialize search functionality
 */
function initializeSearch() {
    // Check if search container should be visible
    const hasSearchableContent = $('.data-table tbody tr').length > 5;
    if (hasSearchableContent) {
        $('#searchContainer').show();
    }
}

/**
 * Toggle search visibility
 */
function toggleSearch() {
    const container = $('#searchContainer');
    container.slideToggle(300);
    
    if (container.is(':visible')) {
        $('#searchInput').focus();
    }
}

/**
 * Filter table based on search input
 */
function filterTable() {
    const searchTerm = $('#searchInput').val().toLowerCase();
    const table = $('#designationsTable');
    const rows = table.find('tbody tr');
    
    let visibleCount = 0;
    
    rows.each(function() {
        const row = $(this);
        const designationName = row.find('.designation-name').text().toLowerCase();
        
        if (designationName.includes(searchTerm)) {
            row.show();
            visibleCount++;
        } else {
            row.hide();
        }
    });
    
    // Update table summary
    updateTableSummary(visibleCount);
    
    // Show no results message if needed
    if (visibleCount === 0 && searchTerm !== '') {
        showNoResultsMessage();
    } else {
        hideNoResultsMessage();
    }
}

/**
 * Clear search
 */
function clearSearch() {
    $('#searchInput').val('');
    filterTable();
    $('#searchInput').focus();
}

/**
 * Update table summary
 */
function updateTableSummary(count) {
    const summaryItem = $('.summary-item');
    const currentText = summaryItem.find('span').text();
    const newText = currentText.replace(/\d+/, count);
    summaryItem.find('span').text(newText);
}

/**
 * Show no results message
 */
function showNoResultsMessage() {
    if ($('.no-search-results').length === 0) {
        const table = $('#designationsTable');
        const tbody = table.find('tbody');
        
        const noResultsRow = `
            <tr class="no-search-results">
                <td colspan="3" class="no-data">
                    <i class="fas fa-search"></i>
                    <h3>No Results Found</h3>
                    <p>No designations match your search criteria.</p>
                </td>
            </tr>
        `;
        
        tbody.append(noResultsRow);
    }
}

/**
 * Hide no results message
 */
function hideNoResultsMessage() {
    $('.no-search-results').remove();
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
 * Export designations
 */
function exportDesignations() {
    // Create CSV content
    const table = $('#designationsTable');
    const rows = table.find('tbody tr:visible');
    let csvContent = 'Designation Name\n';
    
    rows.each(function() {
        const designationName = $(this).find('.designation-name').text().trim();
        if (designationName && !$(this).hasClass('no-search-results')) {
            csvContent += `"${designationName}"\n`;
        }
    });
    
    // Download CSV
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'employee_designations.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    showAlert('success', 'Designations exported successfully!');
}

/**
 * Clear form
 */
function clearForm() {
    $('#form1')[0].reset();
    clearFieldError($('#designation'));
    $('#designation').focus();
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
function Process1() {
    return validateForm();
}

function funcDeleteDesignation() {
    return confirm('Are you sure you want to delete this designation?');
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
            
            .form-input.error {
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
        </style>
    `;
    
    $('head').append(customStyles);
});

