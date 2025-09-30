/**
 * External Radiology PO Modern JavaScript - Following VAT.php Structure
 */

$(document).ready(function() {
    // Initialize the page
    initializePage();
    
    // Get validity days on page load
    getValidityDays();
    
    // Add smooth scrolling
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
});

/**
 * Initialize page functionality
 */
function initializePage() {
    // Initialize sidebar
    initializeSidebar();
    
    // Add loading states to buttons
    $('.btn').on('click', function() {
        if (!$(this).prop('disabled')) {
            $(this).prop('disabled', true);
            const originalText = $(this).html();
            $(this).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
            
            // Re-enable after 3 seconds
            setTimeout(() => {
                $(this).prop('disabled', false);
                $(this).html(originalText);
            }, 3000);
        }
    });
    
    // Add form validation
    initializeFormValidation();
    
    // Add table enhancements
    enhanceTable();
    
    // Add responsive behavior
    handleResponsiveBehavior();
}

/**
 * Initialize sidebar functionality
 */
function initializeSidebar() {
    // Sidebar toggle functionality
    $('#sidebarToggle').on('click', function() {
        $('#leftSidebar').toggleClass('collapsed');
        const icon = $(this).find('i');
        icon.toggleClass('fa-chevron-left fa-chevron-right');
    });
    
    // Mobile menu toggle
    $('#menuToggle').on('click', function() {
        $('#leftSidebar').toggleClass('open');
    });
    
    // Close sidebar when clicking outside on mobile
    $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
            if (!$(e.target).closest('#leftSidebar, #menuToggle').length) {
                $('#leftSidebar').removeClass('open');
            }
        }
    });
}

/**
 * Initialize form validation
 */
function initializeFormValidation() {
    // Real-time validation for required fields
    $('.form-input[required]').on('blur', function() {
        validateField($(this));
    });
    
    // Form submission validation
    $('form').on('submit', function(e) {
        if (!validateForm($(this))) {
            e.preventDefault();
            showAlert('Please fill in all required fields correctly.', 'error');
        }
    });
}

/**
 * Validate individual field
 */
function validateField($field) {
    const value = $field.val().trim();
    const isRequired = $field.prop('required');
    
    // Remove existing validation classes
    $field.removeClass('is-valid is-invalid');
    
    if (isRequired && !value) {
        $field.addClass('is-invalid');
        return false;
    }
    
    if (value) {
        $field.addClass('is-valid');
    }
    
    return true;
}

/**
 * Validate entire form
 */
function validateForm($form) {
    let isValid = true;
    
    $form.find('.form-input[required]').each(function() {
        if (!validateField($(this))) {
            isValid = false;
        }
    });
    
    return isValid;
}

/**
 * Enhance table functionality
 */
function enhanceTable() {
    // Add hover effects
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('table-row-hover');
        },
        function() {
            $(this).removeClass('table-row-hover');
        }
    );
    
    // Add row selection functionality
    $('.form-checkbox').on('change', function() {
        const row = $(this).closest('tr');
        if ($(this).prop('checked')) {
            row.addClass('selected-row');
        } else {
            row.removeClass('selected-row');
        }
    });
    
    // Add select all functionality
    addSelectAllFunctionality();
}

/**
 * Add select all functionality
 */
function addSelectAllFunctionality() {
    const table = $('.data-table');
    const headerRow = table.find('thead tr');
    const checkboxes = table.find('tbody .form-checkbox');
    
    // Add select all checkbox to header
    if (checkboxes.length > 0 && headerRow.find('.select-all-checkbox').length === 0) {
        const selectAllCell = headerRow.find('th').first();
        selectAllCell.prepend('<input type="checkbox" class="select-all-checkbox" title="Select All">');
        
        // Handle select all functionality
        headerRow.find('.select-all-checkbox').on('change', function() {
            const isChecked = $(this).prop('checked');
            checkboxes.prop('checked', isChecked);
            
            if (isChecked) {
                table.find('tbody tr').addClass('selected-row');
            } else {
                table.find('tbody tr').removeClass('selected-row');
            }
        });
    }
}

/**
 * Handle responsive behavior
 */
function handleResponsiveBehavior() {
    // Handle window resize
    $(window).on('resize', function() {
        adjustForMobile();
    });
    
    // Initial adjustment
    adjustForMobile();
}

/**
 * Adjust for mobile devices
 */
function adjustForMobile() {
    if ($(window).width() < 768) {
        $('.data-table').addClass('mobile-table');
        // Add horizontal scroll indicator
        if (!$('.table-container').hasClass('scroll-indicator-added')) {
            $('.data-table').before('<div class="scroll-hint"><i class="fas fa-arrows-alt-h"></i> Scroll horizontally to see more columns</div>');
            $('.table-container').addClass('scroll-indicator-added');
        }
    } else {
        $('.data-table').removeClass('mobile-table');
        $('.scroll-hint').remove();
        $('.table-container').removeClass('scroll-indicator-added');
    }
}

/**
 * Calculate amount based on rate and tax
 */
function CalculateAmount(id) {
    const idno = id.match(/\d+/);
    const suppliername = $('#suppliername' + idno).val();
    
    const rate = ($.trim($('#baserate' + idno).val()) !== '') ? parseFloat($.trim($('#baserate' + idno).val())) : 0.00;
    const tax = parseFloat($('#tax_percent' + idno).val()) || 0;
    
    const total1 = parseFloat(rate);
    const total2 = parseFloat(total1 * tax) / 100;
    const total3 = parseFloat(total2 + total1);
    const total_amount1 = parseFloat(total3).toFixed(2);
    
    $('#amount' + idno).val(total_amount1);
    
    // Add visual feedback
    $('#amount' + idno).addClass('amount-calculated');
    setTimeout(() => {
        $('#amount' + idno).removeClass('amount-calculated');
    }, 1000);
}

/**
 * Handle supplier selection and populate related fields
 */
function calEqAmt(id) {
    const idno = id.match(/\d+/);
    const opt = $("#suppliername" + idno).val();
    
    if (opt) {
        const optsplit = opt.split('||');
        const opt1 = optsplit[0]; // supplier name
        const opt2 = optsplit[1]; // supplier code
        const opt3 = optsplit[2]; // rate
        const opt4 = optsplit[3]; // supplier auto number
        
        $('#suppliername_mlpo' + idno).val(opt1);
        $('#baserate' + idno).val(opt3);
        $('#suppliercode' + idno).val(opt2);
        $('#supplier_autono' + idno).val(opt4);
        
        // Trigger amount calculation
        CalculateAmount('#baserate' + idno);
        
        // Add visual feedback
        $('#baserate' + idno).addClass('rate-populated');
        setTimeout(() => {
            $('#baserate' + idno).removeClass('rate-populated');
        }, 1000);
    }
}

/**
 * Handle checkbox validation
 */
function validcheckbox(id) {
    const checkbox = document.getElementById("selectbox" + id);
    if (checkbox.checked) {
        $("#selectbox" + id).val(1);
        // Add visual feedback
        $(checkbox).closest('tr').addClass('row-selected');
    } else {
        $("#selectbox" + id).val(0);
        $(checkbox).closest('tr').removeClass('row-selected');
    }
}

/**
 * Validate external lab form submission
 */
function externallabvalue() {
    let checkcount_c = 0;
    const sno_new = parseInt($('#sno_new').val());
    let hasErrors = false;
    
    for (let i = 1; i <= sno_new; i++) {
        const checkbox = document.getElementById("selectbox" + i);
        
        if (checkbox && checkbox.checked) {
            // Validate required fields for selected rows
            if ($("#suppliername" + i).val() === "") {
                showAlert("Please select supplier name for row " + i, 'error');
                $('#suppliername' + i).focus();
                hasErrors = true;
                break;
            }
            
            if ($("#baserate" + i).val() === "") {
                showAlert("Please enter rate for row " + i, 'error');
                $('#baserate' + i).focus();
                hasErrors = true;
                break;
            }
        }
        
        const checkcount = checkbox ? parseInt(checkbox.value) : 0;
        checkcount_c += checkcount;
    }
    
    if (hasErrors) {
        return false;
    }
    
    if (checkcount_c < 1) {
        showAlert("Please select at least one patient", 'error');
        return false;
    }
    
    // Show confirmation dialog
    return confirmAction("Do you want to generate the purchase orders?");
}

/**
 * Get validity days between dates
 */
function getValidityDays() {
    const d1 = parseDate($('#todaydate').val());
    const d2 = parseDate($('#lpodate').val());
    
    if (d1 && d2) {
        const oneDay = 24 * 60 * 60 * 1000;
        const diff = Math.round(Math.abs((d2.getTime() - d1.getTime()) / (oneDay)));
        $('#validityperiod').val(diff);
        
        // Add visual feedback based on validity period
        const validityInput = $('#validityperiod');
        validityInput.removeClass('validity-high validity-medium validity-low');
        
        if (diff > 90) {
            validityInput.addClass('validity-high');
        } else if (diff > 30) {
            validityInput.addClass('validity-medium');
        } else {
            validityInput.addClass('validity-low');
        }
    }
}

/**
 * Parse date string
 */
function parseDate(input) {
    if (!input) return null;
    
    const parts = input.match(/(\d+)/g);
    if (parts && parts.length >= 3) {
        return new Date(parts[0], parts[1] - 1, parts[2]);
    }
    return null;
}

/**
 * Disable enter key for forms
 */
function disableEnterKey() {
    if (event.keyCode == 8) {
        event.keyCode = 0;
        return false;
    }
    
    let key;
    if (window.event) {
        key = window.event.keyCode; // IE
    } else {
        key = event.which; // Firefox
    }
    
    if (key == 13) { // if enter key press
        return false;
    } else {
        return true;
    }
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    const alertClass = type === 'error' ? 'alert-error' : (type === 'success' ? 'alert-success' : 'alert-info');
    const iconClass = type === 'error' ? 'exclamation-triangle' : (type === 'success' ? 'check-circle' : 'info-circle');
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible">
            <i class="fas fa-${iconClass} alert-icon"></i>
            <span>${message}</span>
            <button type="button" class="alert-close" onclick="closeAlert(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    $('#alertContainer').html(alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        $('.alert-dismissible').fadeOut();
    }, 5000);
}

/**
 * Close alert
 */
function closeAlert(element) {
    $(element).closest('.alert').fadeOut();
}

/**
 * Confirm action
 */
function confirmAction(message) {
    return confirm(message);
}

/**
 * Refresh page
 */
function refreshPage() {
    location.reload();
}

/**
 * Export to Excel
 */
function exportToExcel() {
    showAlert('Export functionality will be implemented soon.', 'info');
}

/**
 * Reset form
 */
function resetForm() {
    if (confirmAction('Are you sure you want to reset the form? All data will be lost.')) {
        $('form')[0].reset();
        $('.form-input').removeClass('is-valid is-invalid');
        $('.selected-row').removeClass('selected-row');
        showAlert('Form has been reset.', 'success');
    }
}

/**
 * Form validation function
 */
function validcheck() {
    // This function is called on form submit
    // The actual validation is handled by externallabvalue()
    return externallabvalue();
}

// Add CSS for dynamic classes
const dynamicStyles = `
    <style>
        .amount-calculated {
            background-color: #d4edda !important;
            border-color: #28a745 !important;
            animation: pulse 0.5s ease-in-out;
        }
        
        .rate-populated {
            background-color: #cce5ff !important;
            border-color: #007bff !important;
            animation: pulse 0.5s ease-in-out;
        }
        
        .row-selected {
            background-color: #e3f2fd !important;
        }
        
        .selected-row {
            background-color: #e8f5e8 !important;
        }
        
        .table-row-hover {
            background-color: #f8f9fa !important;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        
        .is-valid {
            border-color: #28a745 !important;
            background-color: #d4edda !important;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
            background-color: #f8d7da !important;
        }
        
        .validity-high {
            color: #28a745 !important;
            font-weight: bold;
        }
        
        .validity-medium {
            color: #ffc107 !important;
            font-weight: bold;
        }
        
        .validity-low {
            color: #dc3545 !important;
            font-weight: bold;
        }
        
        .alert-dismissible {
            position: relative;
        }
        
        .alert-close {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            font-size: 1.2rem;
        }
        
        .mobile-table {
            font-size: 0.8rem;
        }
        
        .scroll-hint {
            background: #17a2b8;
            color: white;
            padding: 0.5rem;
            text-align: center;
            font-size: 0.9rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
`;

// Inject dynamic styles
$('head').append(dynamicStyles);