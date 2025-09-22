/**
 * Payroll Report Modern JavaScript
 * Handles interactive elements for the payroll report system
 */

$(document).ready(function() {
    // Initialize the application
    initializeApp();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize report functionality
    initializeReportFeatures();
});

/**
 * Initialize the application
 */
function initializeApp() {
    console.log('Payroll Report Modern JS initialized');
    
    // Check if sidebar should be collapsed by default on mobile
    if (window.innerWidth <= 768) {
        $('.left-sidebar').addClass('collapsed');
    }
    
    // Setup form validation
    setupFormValidation();
    
    // Initialize autocomplete
    initializeAutocomplete();
    
    // Initialize report features
    initializeReportFeatures();
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
    
    // Auto-hide alerts
    $('.alert').each(function() {
        const alert = $(this);
        setTimeout(function() {
            alert.fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
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
        
        // Ctrl + P to print
        if (e.ctrlKey && e.which === 80) {
            e.preventDefault();
            printReport();
        }
        
        // Ctrl + E to export
        if (e.ctrlKey && e.which === 69) {
            e.preventDefault();
            exportPayrollReport();
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
    
    $('#searchyear').on('change', function() {
        validateYearInput($(this));
    });
}

/**
 * Initialize report features
 */
function initializeReportFeatures() {
    // Add row hover effects
    $('.payroll-table tbody tr').hover(
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
    
    // Add number formatting to amount cells
    formatAmountCells();
    
    // Initialize chart functionality if data exists
    if ($('.payroll-table tbody tr').length > 1) {
        initializePayrollChart();
    }
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
 * Validate search form
 */
function validateSearchForm() {
    const employeeField = $('#searchemployee');
    const yearField = $('#searchyear');
    
    clearFieldError(employeeField);
    clearFieldError(yearField);
    
    let isValid = true;
    
    if (employeeField.val().trim() === '') {
        showFieldError(employeeField, 'Please select an employee');
        employeeField.focus();
        isValid = false;
    }
    
    if (yearField.val() === '') {
        showFieldError(yearField, 'Please select a year');
        yearField.focus();
        isValid = false;
    }
    
    return isValid;
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
 * Validate year input
 */
function validateYearInput(field) {
    const value = field.val();
    const currentYear = new Date().getFullYear();
    
    clearFieldError(field);
    
    if (value < 2010 || value > currentYear) {
        showFieldError(field, `Year must be between 2010 and ${currentYear}`);
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
    $('#searchyear').val(new Date().getFullYear());
}

/**
 * Export payroll report
 */
function exportPayrollReport() {
    if (document.getElementById('payrollTable')) {
        // Create CSV content
        const table = document.getElementById('payrollTable');
        const rows = table.querySelectorAll('tbody tr');
        let csvContent = 'Month,Gross Pay,Deduction,Notional Benefit,Net Pay\n';
        
        rows.forEach(function(row) {
            const cells = row.querySelectorAll('td');
            if (cells.length > 1) { // Skip the "no data" row
                const month = cells[1].textContent.trim();
                const grossPay = cells[cells.length - 4].textContent.trim();
                const deduction = cells[cells.length - 3].textContent.trim();
                const benefit = cells[cells.length - 2].textContent.trim();
                const netPay = cells[cells.length - 1].textContent.trim();
                csvContent += `"${month}","${grossPay}","${deduction}","${benefit}","${netPay}"\n`;
            }
        });
        
        // Download CSV
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'payroll_report_' + new Date().getFullYear() + '.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        showAlert('success', 'Payroll report exported successfully!');
    } else {
        showAlert('warning', 'Please generate a report first before exporting.');
    }
}

/**
 * Print report
 */
function printReport() {
    if (document.getElementById('payrollTable')) {
        // Hide non-printable elements
        const elementsToHide = [
            '.floating-menu-toggle',
            '.left-sidebar',
            '.page-header-actions',
            '.report-actions',
            '.form-actions',
            '.search-container'
        ];
        
        elementsToHide.forEach(function(selector) {
            $(selector).hide();
        });
        
        // Print
        window.print();
        
        // Show elements again
        elementsToHide.forEach(function(selector) {
            $(selector).show();
        });
        
        showAlert('success', 'Report sent to printer!');
    } else {
        showAlert('warning', 'Please generate a report first before printing.');
    }
}

/**
 * Export to PDF
 */
function exportToPDF() {
    showAlert('info', 'PDF export functionality would be implemented here using a library like jsPDF or similar.');
}

/**
 * Format amount cells
 */
function formatAmountCells() {
    $('.amount-cell').each(function() {
        const cell = $(this);
        const text = cell.text().trim();
        
        if (text && !isNaN(text.replace(/,/g, ''))) {
            const number = parseFloat(text.replace(/,/g, ''));
            if (number > 0) {
                cell.addClass('has-amount');
            }
        }
    });
}

/**
 * Initialize payroll chart
 */
function initializePayrollChart() {
    // This would integrate with a charting library like Chart.js
    // For now, we'll just add visual enhancements
    $('.payroll-table tbody tr').each(function() {
        const row = $(this);
        const netPayCell = row.find('.amount-cell.net-pay');
        const netPayValue = parseFloat(netPayCell.text().replace(/,/g, ''));
        
        if (netPayValue > 0) {
            row.addClass('has-net-pay');
        }
    });
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
    return validateSearchForm();
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
            
            .amount-cell.has-amount {
                position: relative;
            }
            
            .amount-cell.has-amount::after {
                content: '';
                position: absolute;
                right: 0;
                top: 0;
                bottom: 0;
                width: 3px;
                background: linear-gradient(to bottom, transparent, #28a745, transparent);
                opacity: 0.3;
            }
            
            .payroll-table tbody tr.has-net-pay {
                border-left: 3px solid #2c5aa0;
            }
            
            .payroll-table tbody tr.has-net-pay:hover {
                border-left-color: #1e3f73;
            }
            
            @media print {
                .loading-spinner {
                    display: none !important;
                }
            }
        </style>
    `;
    
    $('head').append(customStyles);
});

