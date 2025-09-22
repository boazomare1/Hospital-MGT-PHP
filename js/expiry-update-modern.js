/**
 * Expiry Update Modern JavaScript
 * Handles interactive elements for the expiry date update system
 */

$(document).ready(function() {
    // Initialize the application
    initializeApp();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize form functionality
    initializeFormFeatures();
    
    // Initialize AJAX functionality
    initializeAjaxFeatures();
});

/**
 * Initialize the application
 */
function initializeApp() {
    console.log('Expiry Update Modern JS initialized');
    
    // Check if sidebar should be collapsed by default on mobile
    if (window.innerWidth <= 768) {
        $('.left-sidebar').addClass('collapsed');
    }
    
    // Setup form validation
    setupFormValidation();
    
    // Initialize expiry features
    initializeExpiryFeatures();
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
        
        // Alt + E to export results
        if (e.altKey && e.which === 69) {
            e.preventDefault();
            exportResults();
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
}

/**
 * Initialize AJAX features
 */
function initializeAjaxFeatures() {
    // Enhanced edit functionality
    $(document).on('click', '.edititem', function(e) {
        e.preventDefault();
        handleEditItem($(this));
    });
    
    // Enhanced save functionality
    $(document).on('click', '.saveitem', function(e) {
        e.preventDefault();
        handleSaveItem($(this));
    });
    
    // Enhanced date picker
    initializeDatePickers();
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
}

/**
 * Initialize expiry features
 */
function initializeExpiryFeatures() {
    // Add expiry status indicators
    addExpiryStatusIndicators();
    
    // Initialize inline editing
    initializeInlineEditing();
    
    // Add batch number validation
    initializeBatchValidation();
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
 * Handle edit item
 */
function handleEditItem(editBtn) {
    const clickedid = editBtn.attr('id');
    const row = $('tr#' + clickedid);
    
    // Get current values
    const current_expdate = row.find("div.expdate").text().trim();
    const current_batch = row.find("div.updatebatch").text().trim();
    
    // Show edit fields
    row.find("td.expirydatetd").show();
    row.find("td.expirydatetdstatic").hide();
    row.find("td.batchupdatetd").show();
    row.find("td.batchupdatestatic").hide();
    
    // Set current values
    $('#batchupdate_' + clickedid).val(current_batch);
    $('#expdate_' + clickedid).val(current_expdate);
    
    // Show save button
    $('#s_' + clickedid).show();
    
    // Add editing state
    row.addClass('editing-row');
    
    // Focus on expiry date field
    setTimeout(function() {
        $('#expdate_' + clickedid).focus();
    }, 100);
}

/**
 * Handle save item
 */
function handleSaveItem(saveBtn) {
    const clickedid = saveBtn.attr('id');
    const idstr = clickedid.split('s_');
    const id = idstr[1];
    const row = $('tr#' + id);
    
    // Get form values
    const expiry_date = $('#expdate_' + id).val();
    const batchnumber = $('#batchno_' + id).val();
    const itemcode = $('#itemcode_' + id).val();
    const itemname = $('#itemname_' + id).val();
    const newbatch = $('#batchupdate_' + id).val();
    
    // Validate inputs
    if (!expiry_date) {
        showAlert('error', 'Please enter an expiry date');
        $('#expdate_' + id).focus();
        return;
    }
    
    if (!newbatch) {
        showAlert('error', 'Please enter a batch number');
        $('#batchupdate_' + id).focus();
        return;
    }
    
    // Show loading state
    row.addClass('loading');
    saveBtn.prop('disabled', true);
    
    // Make AJAX request
    $.ajax({
        url: 'ajax/ajaxcommon.php',
        type: 'POST',
        dataType: 'json',
        data: { 
            itemcode: itemcode, 
            batchnumber: batchnumber,
            expirydate: expiry_date,
            itemname: itemname,
            newbatch: newbatch
        },
        success: function (data) { 
            const msg = data.msg;
            
            if (data.status == 1) {
                // Update UI
                $('#expirydate_' + id).val(expiry_date);
                $('#newbatch_' + id).val(newbatch);
                
                // Hide edit fields
                row.find("td.expirydatetd").hide();
                row.find("td.expirydatetdstatic").show();
                row.find("td.batchupdatetd").hide();
                row.find("td.batchupdatestatic").show();
                
                // Update display values
                $('#uiexpirydate_' + id).text(expiry_date);
                $('#uibatch_' + id).text(newbatch);
                
                // Hide save button
                $('#s_' + id).hide();
                
                // Remove editing state
                row.removeClass('editing-row loading').addClass('update-success');
                
                // Show success message
                showAlert('success', 'Item updated successfully');
                
                // Remove success state after delay
                setTimeout(function() {
                    row.removeClass('update-success');
                }, 3000);
                
            } else {
                // Show error message
                showAlert('error', msg);
                row.removeClass('loading').addClass('update-error');
                
                // Remove error state after delay
                setTimeout(function() {
                    row.removeClass('update-error');
                }, 5000);
            }
        },
        error: function() {
            showAlert('error', 'Failed to update item. Please try again.');
            row.removeClass('loading').addClass('update-error');
            
            // Remove error state after delay
            setTimeout(function() {
                row.removeClass('update-error');
            }, 5000);
        },
        complete: function() {
            saveBtn.prop('disabled', false);
        }
    });
}

/**
 * Initialize date pickers
 */
function initializeDatePickers() {
    // Enhanced date picker initialization
    $('.expdatepicker').on('focus', function() {
        $(this).addClass('datepicker-active');
    }).on('blur', function() {
        $(this).removeClass('datepicker-active');
    });
}

/**
 * Add expiry status indicators
 */
function addExpiryStatusIndicators() {
    $('.expdate').each(function() {
        const expiryDate = $(this).text().trim();
        const today = new Date();
        const expiry = new Date(expiryDate);
        const daysUntilExpiry = Math.ceil((expiry - today) / (1000 * 60 * 60 * 24));
        
        let statusClass = 'valid';
        let statusText = 'Valid';
        
        if (daysUntilExpiry < 0) {
            statusClass = 'expired';
            statusText = 'Expired';
        } else if (daysUntilExpiry <= 30) {
            statusClass = 'expiring-soon';
            statusText = 'Expiring Soon';
        }
        
        // Add status indicator
        $(this).after(`<span class="expiry-status ${statusClass}">${statusText}</span>`);
    });
}

/**
 * Initialize inline editing
 */
function initializeInlineEditing() {
    // Add hover effects for editable rows
    $('.data-table tbody tr').hover(
        function() {
            if (!$(this).hasClass('editing-row')) {
                $(this).addClass('hover-effect');
            }
        },
        function() {
            $(this).removeClass('hover-effect');
        }
    );
}

/**
 * Initialize batch validation
 */
function initializeBatchValidation() {
    // Real-time batch number validation
    $(document).on('input', '.batch-input', function() {
        const value = $(this).val().trim();
        
        if (value.length > 0 && value.length < 3) {
            $(this).addClass('error');
        } else {
            $(this).removeClass('error');
        }
    });
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
 * Export results
 */
function exportResults() {
    const table = document.getElementById('expiryResultsTable');
    if (!table) {
        showAlert('error', 'No results to export');
        return;
    }
    
    const rows = table.querySelectorAll('tbody tr');
    if (rows.length === 0 || (rows.length === 1 && rows[0].querySelector('.no-data'))) {
        showAlert('error', 'No results to export');
        return;
    }
    
    let csvContent = 'No,Item Code,Category,Item Name,Batch No,Expiry Date,Supplier,Quantity,Cost\n';
    
    rows.forEach(function(row) {
        const cells = row.querySelectorAll('td');
        if (cells.length > 1 && !row.querySelector('.no-data')) {
            const rowData = Array.from(cells).slice(0, -1).map(cell => {
                // Get text content, handling nested elements
                const text = cell.textContent.trim();
                return `"${text}"`;
            });
            csvContent += rowData.join(',') + '\n';
        }
    });
    
    // Create and download CSV
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'expiry_stock_report.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    showAlert('success', 'Results exported successfully');
}

/**
 * Select all items
 */
function selectAllItems() {
    // Implementation for selecting all items
    showAlert('info', 'Select all functionality not implemented yet');
}

/**
 * Clear all selections
 */
function clearAllSelections() {
    // Implementation for clearing all selections
    showAlert('info', 'Clear selections functionality not implemented yet');
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

function saveExpDate(date) {
    console.log('Date selected:', date);
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
            
            .hover-effect {
                background-color: #f8f9fa !important;
                transform: translateY(-1px);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            
            .editing-row {
                background: #fff3cd !important;
                border-left: 4px solid #ffc107;
            }
            
            .update-success {
                background: #d4edda !important;
                border-left: 4px solid #28a745;
                animation: successPulse 0.5s ease-in-out;
            }
            
            .update-error {
                background: #f8d7da !important;
                border-left: 4px solid #dc3545;
                animation: errorPulse 0.5s ease-in-out;
            }
            
            @keyframes successPulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.02); }
                100% { transform: scale(1); }
            }
            
            @keyframes errorPulse {
                0% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
                100% { transform: translateX(0); }
            }
            
            .datepicker-active {
                border-color: #2c5aa0 !important;
                box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1) !important;
            }
            
            .batch-input.error {
                border-color: #dc3545;
                box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
            }
            
            .expiry-status {
                margin-left: 0.5rem;
                font-size: 0.75rem;
                padding: 0.125rem 0.375rem;
                border-radius: 0.25rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.025em;
            }
            
            .expiry-status.expired {
                background: #dc3545;
                color: white;
            }
            
            .expiry-status.expiring-soon {
                background: #ffc107;
                color: #212529;
            }
            
            .expiry-status.valid {
                background: #28a745;
                color: white;
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

