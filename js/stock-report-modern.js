/**
 * Stock Report Modern JavaScript
 * Handles interactive elements for the stock report by expiry date system
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
    console.log('Stock Report Modern JS initialized');
    
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
    $('#itemname').on('input', function() {
        validateItemSearch($(this));
    });
    
    $('#location').on('change', function() {
        validateLocationSelection($(this));
    });
    
    $('#store').on('change', function() {
        validateStoreSelection($(this));
    });
    
    // Date range validation
    $('#ADate1, #ADate2').on('change', function() {
        validateDateRange();
    });
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl + / to focus item search
        if (e.ctrlKey && e.which === 191) {
            e.preventDefault();
            $('#itemname').focus();
        }
        
        // Escape to clear form
        if (e.which === 27) {
            clearForm();
        }
        
        // Ctrl + S to submit
        if (e.ctrlKey && e.which === 83) {
            e.preventDefault();
            $('form[name="stockinward"]').submit();
        }
        
        // Alt + E to export to Excel
        if (e.altKey && e.which === 69) {
            e.preventDefault();
            exportToExcel();
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
 * Initialize form features
 */
function initializeFormFeatures() {
    // Add search suggestions
    addSearchSuggestions();
    
    // Initialize tooltips
    initializeTooltips();
    
    // Auto-focus search input
    $('#itemname').focus();
    
    // Initialize location change handler
    $('#location').on('change', function() {
        const locationCode = $(this).val();
        if (locationCode) {
            updateStoreOptions(locationCode);
        }
    });
    
    // Initialize date pickers
    initializeDatePickers();
}

/**
 * Initialize report features
 */
function initializeReportFeatures() {
    // Add expiry status indicators
    addExpiryStatusIndicators();
    
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
    // Real-time validation for item search
    $('#itemname').on('blur', function() {
        validateItemSearch($(this));
    });
    
    // Real-time validation for location
    $('#location').on('blur', function() {
        validateLocationSelection($(this));
    });
    
    // Real-time validation for store
    $('#store').on('blur', function() {
        validateStoreSelection($(this));
    });
    
    // Real-time validation for date range
    $('#ADate1, #ADate2').on('blur', function() {
        validateDateRange();
    });
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    $('[data-tooltip]').each(function() {
        const element = $(this);
        const tooltip = element.attr('data-tooltip');
        element.attr('title', tooltip);
    });
}

/**
 * Validate item search
 */
function validateItemSearch(field) {
    const value = field.val().trim();
    
    clearFieldError(field);
    
    if (value.length > 0 && value.length < 2) {
        showFieldError(field, 'Item name must be at least 2 characters');
        return false;
    }
    
    return true;
}

/**
 * Validate location selection
 */
function validateLocationSelection(field) {
    const value = field.val();
    
    clearFieldError(field);
    
    if (value === '') {
        showFieldError(field, 'Please select a location');
        return false;
    }
    
    return true;
}

/**
 * Validate store selection
 */
function validateStoreSelection(field) {
    const value = field.val();
    
    clearFieldError(field);
    
    if (value === '') {
        showFieldError(field, 'Please select a store');
        return false;
    }
    
    return true;
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
 * Add search suggestions
 */
function addSearchSuggestions() {
    // Enhanced autocomplete for item search
    $('#itemname').on('input', function() {
        const query = $(this).val();
        if (query.length >= 2) {
            // Trigger autocomplete functionality
            // This would integrate with existing autocomplete system
        }
    });
}

/**
 * Update store options based on location
 */
function updateStoreOptions(locationCode) {
    const username = $('#username').val();
    
    showLoadingSpinner('Loading stores...');
    
    $.ajax({
        url: 'ajax/ajaxstore.php',
        type: 'GET',
        data: {
            loc: locationCode,
            username: username
        },
        success: function(response) {
            $('#store').html(response);
            hideLoadingSpinner();
        },
        error: function() {
            hideLoadingSpinner();
            showAlert('error', 'Failed to load stores for selected location');
        }
    });
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
    
    // Set default date range if not set
    if (!$('#ADate1').val()) {
        const lastWeek = new Date();
        lastWeek.setDate(lastWeek.getDate() - 7);
        $('#ADate1').val(lastWeek.toISOString().split('T')[0]);
    }
    
    if (!$('#ADate2').val()) {
        const today = new Date();
        $('#ADate2').val(today.toISOString().split('T')[0]);
    }
}

/**
 * Add expiry status indicators
 */
function addExpiryStatusIndicators() {
    $('.expiry-date-value').each(function() {
        const expiryDate = $(this).text().trim();
        const today = new Date();
        const expiry = new Date(expiryDate);
        const daysUntilExpiry = Math.ceil((expiry - today) / (1000 * 60 * 60 * 24));
        
        let statusClass = 'expiry-valid';
        let statusText = 'Valid';
        
        if (daysUntilExpiry < 0) {
            statusClass = 'expiry-expired';
            statusText = 'Expired';
        } else if (daysUntilExpiry <= 30) {
            statusClass = 'expiry-expiring-soon';
            statusText = 'Expiring Soon';
        }
        
        // Add status indicator if not already present
        if (!$(this).siblings('.expiry-status').length) {
            $(this).after(`<span class="expiry-status ${statusClass}">${statusText}</span>`);
        }
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
        if (text === 'Item Code' || text === 'Item Name' || text === 'Expiry Date' || text === 'Quantity' || text === 'Cost') {
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
            
            if (column === 'quantity' || column === 'cost') {
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
        case 'item-code':
            cell = rowElement.find('.item-code');
            break;
        case 'item-name':
            cell = rowElement.find('.item-name');
            break;
        case 'expiry-date':
            cell = rowElement.find('.expiry-date-value');
            break;
        case 'quantity':
            cell = rowElement.find('.quantity');
            return parseFloat(cell.text().replace(/[^\d.-]/g, '')) || 0;
        case 'cost':
            cell = rowElement.find('.cost');
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
    $('.btn-export, .btn[onclick*="exportToExcel"]').on('click', function(e) {
        e.preventDefault();
        exportToExcel();
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
        const expiredCount = rows.filter(function() {
            return $(this).find('.expiry-expired').length > 0;
        }).length;
        
        const expiringSoonCount = rows.filter(function() {
            return $(this).find('.expiry-expiring-soon').length > 0;
        }).length;
        
        const validCount = rows.filter(function() {
            return $(this).find('.expiry-valid').length > 0;
        }).length;
        
        // Add statistics to summary if not already present
        if (!$('.expiry-statistics').length) {
            const statsHtml = `
                <div class="expiry-statistics">
                    <div class="summary-item">
                        <i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i>
                        <span>Expired: ${expiredCount}</span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-clock" style="color: #ffc107;"></i>
                        <span>Expiring Soon: ${expiringSoonCount}</span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-check-circle" style="color: #28a745;"></i>
                        <span>Valid: ${validCount}</span>
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
    $('form[name="stockinward"]')[0].reset();
    $('#itemname').val('');
    $('#medicinecode').val('');
    clearAllFieldErrors();
    showAlert('info', 'Form cleared');
}

/**
 * Export to Excel
 */
function exportToExcel() {
    const categoryname = document.querySelector('select[name="categoryname"]').value;
    const store = document.querySelector('select[name="store"]').value;
    const location = document.querySelector('select[name="location"]').value;
    const ADate1 = document.querySelector('input[name="ADate1"]').value;
    const ADate2 = document.querySelector('input[name="ADate2"]').value;
    const searchmedicinename = document.querySelector('input[name="itemname"]').value;
    
    if (!location || !store) {
        showAlert('error', 'Please select location and store before exporting');
        return;
    }
    
    const url = `stockreportbyexpirydatexl.php?categoryname=${encodeURIComponent(categoryname)}&store=${encodeURIComponent(store)}&location=${encodeURIComponent(location)}&ADate1=${encodeURIComponent(ADate1)}&ADate2=${encodeURIComponent(ADate2)}&searchmedicinename=${encodeURIComponent(searchmedicinename)}`;
    
    showLoadingSpinner('Generating Excel report...');
    
    // Create a temporary link to download the file
    const link = document.createElement('a');
    link.href = url;
    link.target = '_blank';
    link.click();
    
    setTimeout(function() {
        hideLoadingSpinner();
        showAlert('success', 'Excel report generated successfully');
    }, 2000);
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
    $('.page-header-actions, .data-table-actions, .form-section').hide();
    
    // Trigger print
    window.print();
    
    // Show elements back
    setTimeout(function() {
        $('.page-header-actions, .data-table-actions, .form-section').show();
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
function Locationcheck() {
    if(document.getElementById("location").value == '') {
        alert("Please Select Location");
        document.getElementById("location").focus();
        return false;
    }
    
    if(document.getElementById("store").value == '') {
        alert("Please Select Store");
        document.getElementById("store").focus();
        return false;
    }
    
    return true;
}

function storefunction(loc) {
    const username = document.getElementById("username").value;
    const xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("store").innerHTML = xmlhttp.responseText;
        }
    };
    
    xmlhttp.open("GET","ajax/ajaxstore.php?loc="+loc+"&username="+username,true);
    xmlhttp.send();
}

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

function funcOnLoadBodyFunctionCall() {
    funcCustomerDropDownSearch4();
}

// Modern functions
function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    const categoryname = document.querySelector('select[name="categoryname"]').value;
    const store = document.querySelector('select[name="store"]').value;
    const location = document.querySelector('select[name="location"]').value;
    const ADate1 = document.querySelector('input[name="ADate1"]').value;
    const ADate2 = document.querySelector('input[name="ADate2"]').value;
    const searchmedicinename = document.querySelector('input[name="itemname"]').value;
    
    const url = `stockreportbyexpirydatexl.php?categoryname=${encodeURIComponent(categoryname)}&store=${encodeURIComponent(store)}&location=${encodeURIComponent(location)}&ADate1=${encodeURIComponent(ADate1)}&ADate2=${encodeURIComponent(ADate2)}&searchmedicinename=${encodeURIComponent(searchmedicinename)}`;
    
    window.open(url, '_blank');
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
            
            .expiry-statistics {
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

