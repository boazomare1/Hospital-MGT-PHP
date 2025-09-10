// Modern JavaScript for Asset Monthwise - MedStar Hospital Management

$(document).ready(function() {
    console.log('Asset Monthwise Modern JS Loaded');
    
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
    $('input[type="text"], input[type="number"], select').on('blur', function() {
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
    
    // Setup depreciation input validation
    $('input[name^="depreciation"]').on('blur', function() {
        validateDepreciationInput($(this));
    });
    
    // Setup serial number input validation
    $('input[name^="serialnumbermonth"]').on('blur', function() {
        validateSerialNumber($(this));
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

function validateDepreciationInput($input) {
    const value = parseFloat($input.val()) || 0;
    const maxValue = parseFloat($input.data('max-value')) || 999999;
    
    if (value < 0) {
        $input.addClass('error');
        showFieldError($input, 'Depreciation cannot be negative');
        return false;
    }
    
    if (value > maxValue) {
        $input.addClass('error');
        showFieldError($input, 'Depreciation exceeds maximum allowed value');
        return false;
    }
    
    $input.removeClass('error');
    hideFieldError($input);
    return true;
}

function validateSerialNumber($input) {
    const value = $input.val().trim();
    
    if (value && value.length < 3) {
        $input.addClass('error');
        showFieldError($input, 'Serial number must be at least 3 characters');
        return false;
    }
    
    $input.removeClass('error');
    hideFieldError($input);
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
        showAlert('Asset data refreshed successfully', 'success');
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
function printReport() {
    window.print();
}

// Asset management functions
function calculateDepreciation(assetValue, assetLife, salvageValue) {
    if (!assetValue || !assetLife || assetLife <= 0) {
        return 0;
    }
    
    const annualDepreciation = (assetValue - salvageValue) / assetLife;
    return Math.max(0, annualDepreciation);
}

function calculateMonthlyDepreciation(annualDepreciation) {
    return annualDepreciation / 12;
}

function validateAssetData(assetValue, assetLife, salvageValue) {
    const errors = [];
    
    if (!assetValue || assetValue <= 0) {
        errors.push('Asset value must be greater than 0');
    }
    
    if (!assetLife || assetLife <= 0) {
        errors.push('Asset life must be greater than 0');
    }
    
    if (salvageValue < 0) {
        errors.push('Salvage value cannot be negative');
    }
    
    if (salvageValue >= assetValue) {
        errors.push('Salvage value must be less than asset value');
    }
    
    return errors;
}

// Form submission functions
function submitAssetData() {
    const $form = $('form[name="form1"]');
    let isValid = true;
    const errors = [];
    
    // Validate all depreciation inputs
    $form.find('input[name^="depreciation"]').each(function() {
        const $input = $(this);
        const value = parseFloat($input.val()) || 0;
        
        if (value < 0) {
            errors.push('Depreciation values cannot be negative');
            isValid = false;
        }
    });
    
    // Validate all serial number inputs
    $form.find('input[name^="serialnumbermonth"]').each(function() {
        const $input = $(this);
        const value = $input.val().trim();
        
        if (value && value.length < 3) {
            errors.push('Serial numbers must be at least 3 characters');
            isValid = false;
        }
    });
    
    if (!isValid) {
        showAlert('Please correct the following errors: ' + errors.join(', '), 'error');
        return false;
    }
    
    // Show loading indicator
    showLoadingIndicator();
    
    // Submit form
    $form.submit();
    
    return true;
}

// Auto-calculation functions
function autoCalculateDepreciation() {
    $('.data-table tbody tr').each(function() {
        const $row = $(this);
        const $depreciationInput = $row.find('input[name^="depreciation"]');
        const $assetValueInput = $row.find('input[name^="assetvalue"]');
        const $assetLifeInput = $row.find('input[name^="assetlife"]');
        const $salvageValueInput = $row.find('input[name^="salvagevalue"]');
        
        if ($depreciationInput.length && $assetValueInput.length && $assetLifeInput.length) {
            const assetValue = parseFloat($assetValueInput.val()) || 0;
            const assetLife = parseFloat($assetLifeInput.val()) || 0;
            const salvageValue = parseFloat($salvageValueInput.val()) || 0;
            
            const monthlyDepreciation = calculateMonthlyDepreciation(
                calculateDepreciation(assetValue, assetLife, salvageValue)
            );
            
            $depreciationInput.val(monthlyDepreciation.toFixed(2));
        }
    });
}

// Bulk operations
function selectAllAssets() {
    $('.data-table tbody tr input[type="checkbox"]').prop('checked', true);
}

function deselectAllAssets() {
    $('.data-table tbody tr input[type="checkbox"]').prop('checked', false);
}

function bulkUpdateDepreciation() {
    const selectedAssets = $('.data-table tbody tr input[type="checkbox"]:checked');
    
    if (selectedAssets.length === 0) {
        showAlert('Please select at least one asset to update', 'warning');
        return;
    }
    
    const newDepreciation = prompt('Enter new depreciation value:');
    
    if (newDepreciation === null) {
        return;
    }
    
    const depreciationValue = parseFloat(newDepreciation);
    
    if (isNaN(depreciationValue) || depreciationValue < 0) {
        showAlert('Please enter a valid depreciation value', 'error');
        return;
    }
    
    selectedAssets.each(function() {
        const $row = $(this).closest('tr');
        const $depreciationInput = $row.find('input[name^="depreciation"]');
        $depreciationInput.val(depreciationValue.toFixed(2));
    });
    
    showAlert(`Updated depreciation for ${selectedAssets.length} assets`, 'success');
}

// Add CSS for loading overlay and field errors
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
        
        .hover {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5) !important;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .data-table th {
            cursor: pointer;
            user-select: none;
        }
        
        .data-table th:hover {
            background: linear-gradient(135deg, #e9ecef, #dee2e6);
        }
        
        .data-table th::after {
            content: ' ↕';
            opacity: 0.5;
            font-size: 0.8em;
        }
        
        .bulk-actions {
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(255,255,255,0.9);
            border-radius: 8px;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .bulk-actions button {
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .bulk-actions .btn-select-all {
            background: #3498db;
            color: white;
        }
        
        .bulk-actions .btn-deselect-all {
            background: #95a5a6;
            color: white;
        }
        
        .bulk-actions .btn-bulk-update {
            background: #f39c12;
            color: white;
        }
        
        .bulk-actions button:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
    `)
    .appendTo('head');

