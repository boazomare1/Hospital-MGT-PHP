/**
 * External Radiology PO Report Modern JavaScript
 * Handles interactive elements for the external radiology PO report system
 */

$(document).ready(function() {
    // Initialize the application
    initializeApp();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize form functionality
    initializeFormFeatures();
    
    // Initialize report features
    initializeReportFeatures();
});

/**
 * Initialize the application
 */
function initializeApp() {
    console.log('External Radiology PO Report Modern JS initialized');
    
    // Check if sidebar should be collapsed by default on mobile
    if (window.innerWidth <= 768) {
        $('.left-sidebar').addClass('collapsed');
    }
    
    // Setup form validation
    setupFormValidation();
    
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
    
    // Auto-hide alerts
    $('.alert').each(function() {
        const alert = $(this);
        setTimeout(function() {
            alert.fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    });
    
    // Real-time form validation
    $('#ADate1, #ADate2').on('change', function() {
        validateDateRange();
    });
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl + / to focus date from
        if (e.ctrlKey && e.which === 191) {
            e.preventDefault();
            $('#ADate1').focus();
        }
        
        // Escape to clear form
        if (e.which === 27) {
            clearForm();
        }
        
        // Ctrl + S to submit
        if (e.ctrlKey && e.which === 83) {
            e.preventDefault();
            $('form[name="drugs"]').submit();
        }
        
        // Alt + E to export
        if (e.altKey && e.which === 69) {
            e.preventDefault();
            exportReport();
        }
        
        // Alt + P to print
        if (e.altKey && e.which === 80) {
            e.preventDefault();
            printReport();
        }
    });
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
 * Initialize form features
 */
function initializeFormFeatures() {
    // Initialize date pickers
    initializeDatePickers();
    
    // Auto-focus date from input
    $('#ADate1').focus();
    
    // Set default date range if not set
    if (!$('#ADate1').val()) {
        const today = new Date();
        $('#ADate1').val(today.toISOString().split('T')[0]);
    }
    
    if (!$('#ADate2').val()) {
        const today = new Date();
        $('#ADate2').val(today.toISOString().split('T')[0]);
    }
}

/**
 * Initialize report features
 */
function initializeReportFeatures() {
    // Initialize table sorting
    initializeTableSorting();
    
    // Initialize export functionality
    initializeExportFeatures();
    
    // Add report statistics
    addReportStatistics();
}

/**
 * Setup form validation
 */
function setupFormValidation() {
    // Real-time validation for date range
    $('#ADate1, #ADate2').on('blur', function() {
        validateDateRange();
    });
}

/**
 * Validate date range
 */
function validateDateRange() {
    const dateFrom = $('#ADate1').val();
    const dateTo = $('#ADate2').val();
    
    clearFieldError($('#ADate1'));
    clearFieldError($('#ADate2'));
    
    if (!dateFrom) {
        showFieldError($('#ADate1'), 'Please select a start date');
        return false;
    }
    
    if (!dateTo) {
        showFieldError($('#ADate2'), 'Please select an end date');
        return false;
    }
    
    const fromDate = new Date(dateFrom);
    const toDate = new Date(dateTo);
    
    if (fromDate > toDate) {
        showFieldError($('#ADate1'), 'Start date cannot be after end date');
        showFieldError($('#ADate2'), 'End date cannot be before start date');
        return false;
    }
    
    // Check if date range is too large (more than 1 year)
    const diffTime = Math.abs(toDate - fromDate);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    if (diffDays > 365) {
        showFieldError($('#ADate2'), 'Date range cannot exceed 1 year');
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
 * Initialize date pickers
 */
function initializeDatePickers() {
    // Enhanced date picker initialization
    $('.datepicker-input').on('focus', function() {
        $(this).addClass('datepicker-active');
    }).on('blur', function() {
        $(this).removeClass('datepicker-active');
    });
}

/**
 * Initialize table sorting
 */
function initializeTableSorting() {
    $('.data-table th').each(function() {
        const th = $(this);
        const text = th.text().trim();
        
        // Make certain columns sortable
        if (text === 'Date' || text === 'Patient Name' || text === 'Test Name' || text === 'Rate' || text === 'Amount') {
            th.addClass('sortable').attr('data-sort', text.toLowerCase().replace(' ', '-'));
        }
    });
    
    // Add click handlers for sorting
    $('.data-table th.sortable').on('click', function() {
        const column = $(this).data('sort');
        const table = $(this).closest('table');
        const tbody = table.find('tbody');
        const rows = tbody.find('tr').toArray();
        
        // Toggle sort direction
        const isAsc = $(this).hasClass('asc');
        $(this).siblings().removeClass('asc desc');
        $(this).removeClass('asc desc').addClass(isAsc ? 'desc' : 'asc');
        
        // Sort rows
        rows.sort(function(a, b) {
            const aVal = getCellValue(a, column);
            const bVal = getCellValue(b, column);
            
            if (column === 'amount' || column === 'rate') {
                return isAsc ? bVal - aVal : aVal - bVal;
            } else {
                return isAsc ? bVal.localeCompare(aVal) : aVal.localeCompare(bVal);
            }
        });
        
        // Re-append sorted rows
        rows.forEach(row => tbody.append(row));
    });
}

/**
 * Get cell value for sorting
 */
function getCellValue(row, column) {
    const rowElement = $(row);
    let cell;
    
    switch(column) {
        case 'date':
            cell = rowElement.find('.date-cell');
            break;
        case 'patient-name':
            cell = rowElement.find('.patient-name');
            break;
        case 'test-name':
            cell = rowElement.find('.test-name');
            break;
        case 'rate':
            cell = rowElement.find('.rate-cell');
            return parseFloat(cell.text().replace(/[^\d.-]/g, '')) || 0;
        case 'amount':
            cell = rowElement.find('.amount-cell');
            return parseFloat(cell.text().replace(/[^\d.-]/g, '')) || 0;
        default:
            return '';
    }
    
    return cell.text().trim();
}

/**
 * Initialize export features
 */
function initializeExportFeatures() {
    // Add export buttons with enhanced functionality
    $('.btn-export, .btn[onclick*="exportReport"]').on('click', function(e) {
        e.preventDefault();
        exportReport();
    });
    
    $('.btn-print, .btn[onclick*="printReport"]').on('click', function(e) {
        e.preventDefault();
        printReport();
    });
}

/**
 * Add report statistics
 */
function addReportStatistics() {
    // Calculate and display additional statistics
    const table = $('.data-table');
    if (table.length) {
        const rows = table.find('tbody tr');
        const totalAmount = rows.filter(function() {
            return $(this).find('.amount-cell').length > 0;
        }).toArray().reduce(function(total, row) {
            const amount = parseFloat($(row).find('.amount-cell').text().replace(/[^\d.-]/g, '')) || 0;
            return total + amount;
        }, 0);
        
        // Add statistics to summary if not already present
        if (!$('.amount-statistics').length) {
            const statsHtml = `
                <div class="amount-statistics">
                    <div class="summary-item">
                        <i class="fas fa-dollar-sign" style="color: #28a745;"></i>
                        <span>Total Amount: $${totalAmount.toFixed(2)}</span>
                    </div>
                </div>
            `;
            $('.table-summary').append(statsHtml);
        }
    }
}

/**
 * Refresh page
 */
function refreshPage() {
    showLoadingSpinner('Refreshing page...');
    setTimeout(function() {
        window.location.reload();
    }, 500);
}

/**
 * Clear form
 */
function clearForm() {
    $('form[name="drugs"]')[0].reset();
    clearAllFieldErrors();
    showAlert('info', 'Form cleared');
}

/**
 * Export to CSV
 */
function exportReport() {
    const fromdate = document.querySelector('input[name="ADate1"]').value;
    const todate = document.querySelector('input[name="ADate2"]').value;
    const location = document.querySelector('select[name="location"]').value;
    
    if (!fromdate || !todate) {
        showAlert('error', 'Please select date range before exporting');
        return;
    }
    
    // Create CSV content
    const table = document.getElementById('externalRadiologyReportTable');
    if (!table) {
        showAlert('error', 'No data to export');
        return;
    }
    
    showLoadingSpinner('Generating CSV report...');
    
    let csvContent = 'S.No,Date,Patient Name,Reg No,Visit No,PO No,Age,Gender,Sample Id,Test Name,Supplier,Rate,Tax%,Amount\n';
    
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(function(row) {
        const cells = row.querySelectorAll('td');
        if (cells.length > 1 && !row.querySelector('.no-data')) {
            const rowData = Array.from(cells).map(cell => `"${cell.textContent.trim()}"`);
            csvContent += rowData.join(',') + '\n';
        }
    });
    
    // Download CSV
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `external_radiology_po_report_${fromdate}_to_${todate}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    setTimeout(function() {
        hideLoadingSpinner();
        showAlert('success', 'CSV report generated successfully');
    }, 1000);
}

/**
 * Print report
 */
function printReport() {
    const table = $('.data-table');
    if (!table.length || table.find('tbody tr').length === 0) {
        showAlert('error', 'No data to print');
        return;
    }
    
    // Hide elements that shouldn't be printed
    $('.page-header-actions, .report-actions, .form-section').hide();
    
    // Trigger print
    window.print();
    
    // Show elements back
    setTimeout(function() {
        $('.page-header-actions, .report-actions, .form-section').show();
    }, 1000);
    
    showAlert('info', 'Print dialog opened');
}

/**
 * Show loading spinner
 */
function showLoadingSpinner(message = 'Loading...') {
    const spinner = `
        <div class="loading-overlay">
            <i class="fas fa-spinner fa-spin"></i>
            <span>${message}</span>
        </div>
    `;
    
    $('body').append(spinner);
}

/**
 * Hide loading spinner
 */
function hideLoadingSpinner() {
    $('.loading-overlay').remove();
}

/**
 * Clear all field errors
 */
function clearAllFieldErrors() {
    $('.form-input, .form-select').removeClass('error');
    $('.field-error').remove();
}

/**
 * Handle window resize
 */
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

/**
 * JavaScript functions for form validation (called from PHP)
 */
function disableEnterKey() {
    if (event.keyCode == 8) {
        event.keyCode = 0; 
        return event.keyCode 
        return false;
    }
    
    const key = event.keyCode || event.which;
    
    if(key == 13) { // if enter key press
        return false;
    } else {
        return true;
    }
}

function validcheck() {
    // Validation logic can be added here
    return true;
}

function getValidityDays() {
    var d1 = parseDate($('#todaydate').val());
    console.log(d1);
    var oneDay = 24*60*60*1000;
    var diff = 0;
    if (d1 && d2) {
        diff = Math.round(Math.abs((d2.getTime() - d1.getTime())/(oneDay)));
        console.log('diff'+diff);
    }
}

function parseDate(input) {
    var parts = input.match(/(\d+)/g);
    return new Date(parts[0], parts[1]-1, parts[2]); // months are 0-based
}

// Modern functions
function refreshPage() {
    window.location.reload();
}

function exportReport() {
    const fromdate = document.querySelector('input[name="ADate1"]').value;
    const todate = document.querySelector('input[name="ADate2"]').value;
    const location = document.querySelector('select[name="location"]').value;
    
    if (!fromdate || !todate) {
        alert('Please select date range before exporting');
        return;
    }
    
    // Create CSV content
    const table = document.getElementById('externalRadiologyReportTable');
    if (!table) {
        alert('No data to export');
        return;
    }
    
    let csvContent = 'S.No,Date,Patient Name,Reg No,Visit No,PO No,Age,Gender,Sample Id,Test Name,Supplier,Rate,Tax%,Amount\n';
    
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(function(row) {
        const cells = row.querySelectorAll('td');
        if (cells.length > 1 && !row.querySelector('.no-data')) {
            const rowData = Array.from(cells).map(cell => `"${cell.textContent.trim()}"`);
            csvContent += rowData.join(',') + '\n';
        }
    });
    
    // Download CSV
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'external_radiology_po_report.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

function printReport() {
    window.print();
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
            
            .form-input.error,
            .form-select.error {
                border-color: #dc3545;
                box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
            }
            
            .loading-overlay {
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
            
            .loading-overlay i {
                font-size: 2rem;
                margin-bottom: 1rem;
                animation: spin 1s linear infinite;
            }
            
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            
            .datepicker-active {
                border-color: #2c5aa0 !important;
                box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1) !important;
            }
            
            .amount-statistics {
                display: flex;
                gap: 1rem;
                flex-wrap: wrap;
                margin-top: 1rem;
                padding-top: 1rem;
                border-top: 1px solid #e9ecef;
            }
            
            .data-table th.sortable {
                cursor: pointer;
                position: relative;
                user-select: none;
            }
            
            .data-table th.sortable:hover {
                background: linear-gradient(135deg, #1e3f73 0%, #1a365d 100%);
            }
            
            .data-table th.sortable::after {
                content: '⇅';
                position: absolute;
                right: 0.5rem;
                opacity: 0.5;
            }
            
            .data-table th.sortable.asc::after {
                content: '↑';
                opacity: 1;
            }
            
            .data-table th.sortable.desc::after {
                content: '↓';
                opacity: 1;
            }
            
            @media print {
                .loading-overlay {
                    display: none !important;
                }
            }
        </style>
    `;
    
    $('head').append(customStyles);
});
