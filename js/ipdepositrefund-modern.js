// Modern JavaScript for IP Deposit Refund - MedStar Hospital Management

$(document).ready(function() {
    console.log('IP Deposit Refund Modern JS Loaded');
    
    // Initialize modern functionality
    initializeModernFeatures();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup table interactions
    setupTableInteractions();
    
    // Setup auto-refresh
    setupAutoRefresh();
});

function initializeModernFeatures() {
    // Add loading states to buttons
    $('.btn').on('click', function() {
        const $btn = $(this);
        if (!$btn.hasClass('loading')) {
            $btn.addClass('loading');
            setTimeout(() => {
                $btn.removeClass('loading');
            }, 2000);
        }
    });
    
    // Add smooth scrolling
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        const target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 800);
        }
    });
    
    // Add tooltips
    $('[data-tooltip]').each(function() {
        $(this).attr('title', $(this).data('tooltip'));
    });
}

function setupFormValidation() {
    // Real-time form validation
    $('input[type="text"], input[type="number"]').on('blur', function() {
        validateField($(this));
    });
    
    // Form submission validation
    $('form').on('submit', function(e) {
        let isValid = true;
        const $form = $(this);
        
        // Validate required fields
        $form.find('input[required], select[required]').each(function() {
            if (!validateField($(this))) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            showAlert('Please fill in all required fields correctly.', 'error');
        }
    });
    
    // Number input validation
    $('input[type="text"][onkeypress*="isNumberKey"]').on('input', function() {
        const value = $(this).val();
        if (value && !isValidNumber(value)) {
            $(this).addClass('error');
            showFieldError($(this), 'Please enter a valid number');
        } else {
            $(this).removeClass('error');
            hideFieldError($(this));
        }
    });
}

function validateField($field) {
    const value = $field.val().trim();
    const isRequired = $field.prop('required');
    
    // Clear previous errors
    hideFieldError($field);
    $field.removeClass('error');
    
    // Check if required field is empty
    if (isRequired && !value) {
        showFieldError($field, 'This field is required');
        $field.addClass('error');
        return false;
    }
    
    // Validate number fields
    if ($field.attr('onkeypress') && $field.attr('onkeypress').includes('isNumberKey')) {
        if (value && !isValidNumber(value)) {
            showFieldError($field, 'Please enter a valid number');
            $field.addClass('error');
            return false;
        }
    }
    
    return true;
}

function showFieldError($field, message) {
    const $errorDiv = $('<div class="field-error">' + message + '</div>');
    $field.after($errorDiv);
}

function hideFieldError($field) {
    $field.siblings('.field-error').remove();
}

function isValidNumber(value) {
    return /^\d+(\.\d{1,2})?$/.test(value);
}

function setupTableInteractions() {
    // Add row hover effects
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );
    
    // Setup search functionality
    if ($('.search-bar input').length) {
        $('.search-bar input').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            filterTable(searchTerm);
        });
    }
    
    // Setup deposit request validation
    $('input[id^="req_"]').on('blur', function() {
        validateDepositRequest($(this));
    });
}

function filterTable(searchTerm) {
    $('.data-table tbody tr').each(function() {
        const $row = $(this);
        const text = $row.text().toLowerCase();
        
        if (text.includes(searchTerm)) {
            $row.show();
        } else {
            $row.hide();
        }
    });
}

function validateDepositRequest($input) {
    const visitCode = $input.attr('id').replace('req_', '');
    const requestedAmount = parseFloat($input.val()) || 0;
    const availableAmount = parseFloat($('#avl_' + visitCode).val()) || 0;
    
    if (requestedAmount > 0) {
        if (requestedAmount > availableAmount) {
            $input.addClass('error');
            showFieldError($input, 'Requested amount cannot exceed available deposit');
            return false;
        } else {
            $input.removeClass('error');
            hideFieldError($input);
            return true;
        }
    }
    
    return true;
}

function setupAutoRefresh() {
    // Auto-refresh every 5 minutes
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            refreshData();
        }
    }, 300000); // 5 minutes
}

function refreshData() {
    // Show loading indicator
    showLoadingIndicator();
    
    // Simulate data refresh (replace with actual AJAX call)
    setTimeout(function() {
        hideLoadingIndicator();
        showAlert('Data refreshed successfully', 'success');
    }, 1000);
}

function showLoadingIndicator() {
    if ($('#loadingIndicator').length === 0) {
        $('body').append('<div id="loadingIndicator" class="loading-overlay"><div class="loading-spinner"></div></div>');
    }
    $('#loadingIndicator').show();
}

function hideLoadingIndicator() {
    $('#loadingIndicator').hide();
}

function showAlert(message, type = 'info') {
    const alertClass = 'alert-' + type;
    const icon = getAlertIcon(type);
    
    const $alert = $(`
        <div class="alert ${alertClass}">
            <i class="fas ${icon}"></i>
            ${message}
        </div>
    `);
    
    $('#alertContainer').html($alert);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $alert.fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
}

function getAlertIcon(type) {
    const icons = {
        'success': 'fa-check-circle',
        'error': 'fa-exclamation-circle',
        'info': 'fa-info-circle',
        'warning': 'fa-exclamation-triangle'
    };
    return icons[type] || icons['info'];
}

// Enhanced deposit refund request function
function reqDepositrefund(patientCode, visitCode) {
    const $requestInput = $('#req_' + visitCode);
    const $availableInput = $('#avl_' + visitCode);
    
    const refund = parseFloat($requestInput.val()) || 0;
    const available = parseFloat($availableInput.val()) || 0;
    
    // Validate input
    if (refund <= 0) {
        showAlert('Please enter a valid deposit amount.', 'error');
        $requestInput.focus();
        return false;
    }
    
    if (refund > available) {
        showAlert('Requested deposit amount should be less than or equal to Available Deposit', 'error');
        $requestInput.focus();
        return false;
    }
    
    // Show confirmation dialog
    if (confirm(`Are you sure you want to request a refund of ${refund.toFixed(2)} for patient ${patientCode}?`)) {
        // Show loading
        showLoadingIndicator();
        
        // Process refund request
        const refundToken = btoa('-' + refund).replace(/=/g, '');
        const refundUrl = `depositrefundrequest.php?patientcode=${patientCode}&visitcode=${visitCode}&token=${refundToken}`;
        
        // Open in new window
        const refundWindow = window.open(refundUrl, '_blank');
        
        // Clear input
        $requestInput.val('');
        
        // Hide loading
        hideLoadingIndicator();
        
        // Show success message
        showAlert(`Refund request of ${refund.toFixed(2)} submitted successfully for patient ${patientCode}`, 'success');
        
        return false;
    }
    
    return false;
}

// Enhanced number key validation
function isNumberKey(evt, element) {
    const charCode = (evt.which) ? evt.which : event.keyCode;
    
    // Allow: backspace, delete, tab, escape, enter
    if ([8, 9, 27, 13, 46].indexOf(charCode) !== -1 ||
        // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
        (charCode === 65 && evt.ctrlKey === true) ||
        (charCode === 67 && evt.ctrlKey === true) ||
        (charCode === 86 && evt.ctrlKey === true) ||
        (charCode === 88 && evt.ctrlKey === true)) {
        return true;
    }
    
    // Ensure that it is a number and stop the keypress
    if ((charCode < 48 || charCode > 57) && charCode !== 46) {
        return false;
    }
    
    // Check for decimal point
    const len = $(element).val().length;
    const index = $(element).val().indexOf('.');
    
    if (index > 0 && charCode === 46) {
        return false; // Only one decimal point allowed
    }
    
    if (index > 0) {
        const charAfterDot = (len + 1) - index;
        if (charAfterDot > 3) {
            return false; // Only 2 decimal places allowed
        }
    }
    
    return true;
}

// Utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatNumber(number) {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(number);
}

// Export functions
function exportToExcel() {
    showLoadingIndicator();
    
    // Simulate export process
    setTimeout(function() {
        hideLoadingIndicator();
        showAlert('Export to Excel completed successfully', 'success');
    }, 2000);
}

function refreshPage() {
    showLoadingIndicator();
    window.location.reload();
}

// Print functions
function funcPrintReceipt1() {
    const printWindow = window.open("print_payment_receipt1.php", "OriginalWindow", 
        'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
    
    if (printWindow) {
        printWindow.focus();
    }
}

// AJAX location function (enhanced)
function ajaxlocationfunction(val) {
    if (!val) return;
    
    showLoadingIndicator();
    
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
            hideLoadingIndicator();
        }
    };
    
    xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
    xmlhttp.send();
}

// Form submission functions
function cbsuppliername1() {
    document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall() {
    funcCustomerDropDownSearch1();
}

// Enhanced form validation
function funcvalidcheck() {
    const customer = document.getElementById('customer').value.trim();
    const location = document.getElementById('location').value;
    
    if (!customer && !location) {
        showAlert('Please enter patient search criteria or select a location.', 'error');
        return false;
    }
    
    return true;
}

// Add CSS for loading overlay
$('<style>')
    .prop('type', 'text/css')
    .html(`
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        .field-error {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 5px;
            font-weight: 500;
        }
        
        .error {
            border-color: #e74c3c !important;
            box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.1) !important;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `)
    .appendTo('head');

