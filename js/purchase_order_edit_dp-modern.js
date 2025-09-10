/* Purchase Order Edit DP - Modern JavaScript */
/* Enhanced functionality for purchase order editing */

$(document).ready(function() {
    // Initialize modern functionality
    initializeModernFeatures();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup table interactions
    setupTableInteractions();
    
    // Setup search functionality
    setupSearchFunctionality();
    
    // Setup auto-calculation
    setupAutoCalculation();
});

function initializeModernFeatures() {
    // Add fade-in animation to main container
    $('.main-container').addClass('fade-in');
    
    // Setup tooltips for better UX
    setupTooltips();
    
    // Setup responsive table
    setupResponsiveTable();
    
    // Setup form enhancements
    setupFormEnhancements();
}

function setupFormValidation() {
    // Real-time validation for PO number
    $('#pono').on('input', function() {
        const poNumber = $(this).val().trim();
        const submitBtn = $('input[name="Submit"]');
        
        if (poNumber.length > 0) {
            $(this).removeClass('error').addClass('valid');
            submitBtn.prop('disabled', false);
        } else {
            $(this).removeClass('valid').addClass('error');
            submitBtn.prop('disabled', true);
        }
    });
    
    // Form submission validation
    $('form[name="cbform1"]').on('submit', function(e) {
        const poNumber = $('#pono').val().trim();
        
        if (!poNumber) {
            e.preventDefault();
            showAlert('Please enter a PO number to search.', 'error');
            $('#pono').focus();
            return false;
        }
        
        // Show loading state
        showLoadingState();
    });
}

function setupTableInteractions() {
    // Enhanced table row highlighting
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('table-hover');
        },
        function() {
            $(this).removeClass('table-hover');
        }
    );
    
    // Setup editable fields enhancement
    $('.data-table input[type="text"]').on('focus', function() {
        $(this).closest('tr').addClass('editing-row');
    }).on('blur', function() {
        $(this).closest('tr').removeClass('editing-row');
    });
}

function setupSearchFunctionality() {
    // Real-time search for PO items
    $('#poSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterTableRows(searchTerm);
    });
    
    // Clear search functionality
    $('.search-bar i').on('click', function() {
        $('#poSearch').val('').trigger('input');
    });
}

function setupAutoCalculation() {
    // Enhanced amount calculation with better formatting
    $('input[id^="rate_val"], input[id^="qty_val"]').on('input', function() {
        const id = $(this).attr('id').replace(/rate_val|qty_val/, '');
        calculateAmount(id);
    });
    
    // Setup number formatting for inputs
    $('input[id^="rate_val"], input[id^="qty_val"]').on('blur', function() {
        formatNumberInput($(this));
    });
}

function calculateAmount(id) {
    const qty = parseFloat($('#qty_val' + id).val().replace(/,/g, '')) || 0;
    const rate = parseFloat($('#rate_val' + id).val().replace(/,/g, '')) || 0;
    
    if (qty > 0 && rate > 0) {
        const amount = qty * rate;
        const formattedAmount = formatCurrency(amount);
        $('#indv_amount' + id).val(formattedAmount);
        
        // Add visual feedback
        $('#indv_amount' + id).addClass('calculated');
        setTimeout(() => {
            $('#indv_amount' + id).removeClass('calculated');
        }, 1000);
    } else {
        $('#indv_amount' + id).val('0.00');
    }
    
    // Update total if needed
    updateTotalAmount();
}

function formatNumberInput(input) {
    const value = input.val().replace(/,/g, '');
    const numValue = parseFloat(value);
    
    if (!isNaN(numValue)) {
        input.val(formatNumber(numValue));
    }
}

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}

function formatCurrency(num) {
    return parseFloat(num).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}

function updateTotalAmount() {
    let total = 0;
    $('input[id^="indv_amount"]').each(function() {
        const value = parseFloat($(this).val().replace(/,/g, '')) || 0;
        total += value;
    });
    
    // Update total display if exists
    if ($('#totalAmount').length) {
        $('#totalAmount').text(formatCurrency(total));
    }
}

function filterTableRows(searchTerm) {
    $('.data-table tbody tr').each(function() {
        const rowText = $(this).text().toLowerCase();
        if (rowText.includes(searchTerm)) {
            $(this).show().addClass('search-match');
        } else {
            $(this).hide().removeClass('search-match');
        }
    });
    
    // Update search results count
    const visibleRows = $('.data-table tbody tr:visible').length;
    updateSearchResults(visibleRows);
}

function updateSearchResults(count) {
    let resultsText = $('.search-results');
    if (resultsText.length === 0) {
        resultsText = $('<div class="search-results"></div>');
        $('.table-header').append(resultsText);
    }
    
    resultsText.text(`${count} items found`);
}

function setupTooltips() {
    // Add tooltips to form elements
    $('input[title]').each(function() {
        $(this).tooltip({
            position: { my: "left+15 center", at: "right center" },
            classes: { "ui-tooltip": "modern-tooltip" }
        });
    });
}

function setupResponsiveTable() {
    // Make table responsive on mobile
    if ($(window).width() < 768) {
        $('.data-table').addClass('responsive-table');
    }
    
    $(window).on('resize', function() {
        if ($(window).width() < 768) {
            $('.data-table').addClass('responsive-table');
        } else {
            $('.data-table').removeClass('responsive-table');
        }
    });
}

function setupFormEnhancements() {
    // Auto-focus on PO number field
    $('#pono').focus();
    
    // Enter key handling for form submission
    $('#pono').on('keypress', function(e) {
        if (e.which === 13) {
            $('form[name="cbform1"]').submit();
        }
    });
    
    // Form reset functionality
    $('#resetbutton').on('click', function() {
        resetForm();
    });
}

function resetForm() {
    $('form[name="cbform1"]')[0].reset();
    $('#pono').focus();
    $('.data-table-section').hide();
    showAlert('Form has been reset.', 'info');
}

function showLoadingState() {
    $('.main-container').addClass('loading');
    $('input[type="submit"]').prop('disabled', true).val('Searching...');
}

function hideLoadingState() {
    $('.main-container').removeClass('loading');
    $('input[type="submit"]').prop('disabled', false).val('Search');
}

function showAlert(message, type = 'info') {
    const alertClass = type === 'error' ? 'error-message' : 
                      type === 'success' ? 'success-message' : 'info-message';
    
    const alert = $(`<div class="${alertClass} fade-in">${message}</div>`);
    
    // Remove existing alerts
    $('.success-message, .error-message, .info-message').remove();
    
    // Add new alert
    $('#alertContainer').append(alert);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        alert.fadeOut(() => alert.remove());
    }, 5000);
}

function refreshPage() {
    location.reload();
}

function exportToExcel() {
    // Enhanced export functionality
    showAlert('Export functionality will be implemented.', 'info');
}

// Enhanced AJAX location function
function ajaxlocationfunction(val) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
            
            // Add visual feedback
            $('#ajaxlocation').addClass('location-updated');
            setTimeout(() => {
                $('#ajaxlocation').removeClass('location-updated');
            }, 1000);
        }
    };
    
    xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
    xmlhttp.send();
}

// Enhanced amount calculation function
function calamount(id) {
    const get_qty = $("#qty_val" + id).val().replace(/,/g, '');
    const get_rate = $("#rate_val" + id).val().replace(/,/g, '');
    let amount = '0.00';
    
    if (get_qty > 0 && get_rate > 0) {
        amount = parseFloat(get_qty) * parseFloat(get_rate);
        amount = parseFloat(amount).toFixed(2);
        amount = amount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        $("#indv_amount" + id).val(amount);
        
        // Add visual feedback
        $("#indv_amount" + id).addClass('amount-calculated');
        setTimeout(() => {
            $("#indv_amount" + id).removeClass('amount-calculated');
        }, 1000);
    }
}

// Enhanced disable enter key function
function disableEnterKey() {
    if (event.keyCode == 8) {
        event.keyCode = 0;
        return event.keyCode;
        return false;
    }
    
    var key;
    if (window.event) {
        key = window.event.keyCode;
    } else {
        key = e.which;
    }
    
    if (key == 13) {
        return false;
    } else {
        return true;
    }
}

// Form validation function
function funcvalidcheck() {
    const poNumber = $('#pono').val().trim();
    
    if (!poNumber) {
        showAlert('Please enter a PO number to search.', 'error');
        $('#pono').focus();
        return false;
    }
    
    return true;
}

// Save form with enhanced feedback
function savePurchaseOrder() {
    const form = $('form[name="insertvalue"]');
    
    // Validate all required fields
    let isValid = true;
    $('input[id^="rate_val"], input[id^="qty_val"]').each(function() {
        const value = $(this).val().trim();
        if (!value || value === '0' || value === '0.00') {
            $(this).addClass('error');
            isValid = false;
        } else {
            $(this).removeClass('error');
        }
    });
    
    if (!isValid) {
        showAlert('Please fill in all rate and quantity fields.', 'error');
        return false;
    }
    
    // Show loading state
    $('input[name="Submit222"]').prop('disabled', true).val('Saving...');
    
    // Submit form
    form.submit();
}

// Initialize on page load
$(window).on('load', function() {
    // Hide loading state if form was submitted
    hideLoadingState();
    
    // Show success message if redirected after save
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('saved') === 'true') {
        showAlert('Purchase order updated successfully!', 'success');
    }
});

// Add CSS for dynamic classes
$('<style>')
    .prop('type', 'text/css')
    .html(`
        .table-hover { background-color: #e3f2fd !important; }
        .editing-row { background-color: #fff3e0 !important; }
        .search-match { background-color: #e8f5e8 !important; }
        .calculated { background-color: #e8f5e8 !important; transition: background-color 0.3s; }
        .amount-calculated { background-color: #e8f5e8 !important; transition: background-color 0.3s; }
        .location-updated { background-color: #e3f2fd !important; transition: background-color 0.3s; }
        .error { border-color: #e74c3c !important; box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.1) !important; }
        .valid { border-color: #27ae60 !important; box-shadow: 0 0 0 2px rgba(39, 174, 96, 0.1) !important; }
        .modern-tooltip { background: #2c3e50; color: white; border-radius: 4px; padding: 8px 12px; font-size: 0.9rem; }
        .responsive-table { font-size: 0.8rem; }
        .responsive-table th, .responsive-table td { padding: 6px 4px; }
        .info-message { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 8px; border: 1px solid #bee5eb; margin-bottom: 20px; }
    `)
    .appendTo('head');

