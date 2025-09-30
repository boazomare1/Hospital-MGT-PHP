/**
 * External Lab PO - Modern JavaScript
 * Enhanced functionality for external lab purchase order management
 */

$(document).ready(function() {
    initializePage();
    initializeEventHandlers();
    initializeFormFeatures();
    loadUserPreferences();
});

/**
 * Initialize page functionality
 */
function initializePage() {
    // Initialize sidebar
    initializeSidebar();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize keyboard shortcuts
    initializeKeyboardShortcuts();
    
    // Initialize date calculations
    initializeDateCalculations();
    
    // Initialize table enhancements
    initializeTableFeatures();
    
    // Show welcome message
    showWelcomeMessage();
}

/**
 * Initialize event handlers
 */
function initializeEventHandlers() {
    // Sidebar toggle
    $('#sidebarToggle').on('click', toggleSidebar);
    $('#menuToggle').on('click', toggleSidebar);
    
    // Form submission
    $('form[name="drugs"]').on('submit', handleSearchForm);
    $('form[name="form1"]').on('submit', handleGeneratePOForm);
    
    // Date change handlers
    $('#ADate1, #ADate2').on('change', handleDateChange);
    $('#lpodate').on('change', calculateValidityDays);
    
    // Supplier selection handlers
    $(document).on('change', 'select[id^="suppliername"]', handleSupplierChange);
    
    // Rate calculation handlers
    $(document).on('input', 'input[id^="baserate"]', handleRateChange);
    $(document).on('change', 'select[id^="tax_percent"]', handleTaxChange);
    
    // Checkbox handlers
    $(document).on('change', 'input[id^="selectbox"]', handleCheckboxChange);
    
    // Auto-refresh functionality
    initializeAutoRefresh();
}

/**
 * Initialize sidebar functionality
 */
function initializeSidebar() {
    // Check if sidebar should be collapsed
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed) {
        $('#leftSidebar').addClass('collapsed');
        $('#sidebarToggle i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
    }
    
    // Handle window resize
    handleWindowResize();
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
 * Handle search form submission
 */
function handleSearchForm(e) {
    e.preventDefault();
    
    const form = $(this);
    const formData = form.serialize();
    
    // Show loading state
    showLoadingState();
    
    // Validate form
    if (!validateSearchForm()) {
        hideLoadingState();
        return false;
    }
    
    // Submit form
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        success: function(response) {
            hideLoadingState();
            // Page will reload with results
        },
        error: function() {
            hideLoadingState();
            showAlert('Error occurred while searching. Please try again.', 'danger');
        }
    });
    
    return false;
}

/**
 * Handle generate PO form submission
 */
function handleGeneratePOForm(e) {
    e.preventDefault();
    
    const form = $(this);
    
    // Validate form
    if (!validateGeneratePOForm()) {
        return false;
    }
    
    // Show loading state
    showLoadingState();
    
    // Submit form
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            hideLoadingState();
            showAlert('Purchase Orders generated successfully!', 'success');
            
            // Refresh page after delay
            setTimeout(() => {
                location.reload();
            }, 2000);
        },
        error: function() {
            hideLoadingState();
            showAlert('Error occurred while generating POs. Please try again.', 'danger');
        }
    });
    
    return false;
}

/**
 * Handle date changes
 */
function handleDateChange() {
    const fromDate = $('#ADate1').val();
    const toDate = $('#ADate2').val();
    
    if (fromDate && toDate) {
        // Validate date range
        if (new Date(fromDate) > new Date(toDate)) {
            showAlert('From date cannot be greater than To date.', 'warning');
            return;
        }
        
        // Calculate date difference
        const diffTime = Math.abs(new Date(toDate) - new Date(fromDate));
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays > 30) {
            showAlert('Date range should not exceed 30 days.', 'warning');
        }
    }
}

/**
 * Handle supplier selection change
 */
function handleSupplierChange() {
    const select = $(this);
    const id = select.attr('id');
    const idno = id.match(/\d+/)[0];
    
    const selectedValue = select.val();
    
    if (selectedValue && selectedValue !== '') {
        const parts = selectedValue.split('||');
        if (parts.length >= 4) {
            const supplierName = parts[0];
            const supplierCode = parts[1];
            const rate = parts[2];
            const supplierAutoNo = parts[3];
            
            // Update hidden fields
            $('#suppliername_mlpo' + idno).val(supplierName);
            $('#baserate' + idno).val(rate);
            $('#suppliercode' + idno).val(supplierCode);
            $('#supplier_autono' + idno).val(supplierAutoNo);
            
            // Calculate amount
            calculateAmount('#baserate' + idno);
            
            // Show success feedback
            showFieldSuccess(select);
        }
    } else {
        // Clear related fields
        $('#suppliername_mlpo' + idno).val('');
        $('#baserate' + idno).val('');
        $('#suppliercode' + idno).val('');
        $('#supplier_autono' + idno).val('');
        $('#amount' + idno).val('');
        
        showFieldError(select, 'Please select a supplier');
    }
}

/**
 * Handle rate input change
 */
function handleRateChange() {
    const input = $(this);
    calculateAmount(input);
    
    // Validate rate
    const rate = parseFloat(input.val());
    if (isNaN(rate) || rate < 0) {
        showFieldError(input, 'Please enter a valid rate');
    } else {
        showFieldSuccess(input);
    }
}

/**
 * Handle tax percentage change
 */
function handleTaxChange() {
    const select = $(this);
    const id = select.attr('id');
    const idno = id.match(/\d+/)[0];
    
    calculateAmount('#baserate' + idno);
}

/**
 * Handle checkbox change
 */
function handleCheckboxChange() {
    const checkbox = $(this);
    const id = checkbox.attr('id');
    const idno = id.match(/\d+/)[0];
    
    // Update checkbox value
    if (checkbox.is(':checked')) {
        checkbox.val('1');
        // Highlight row
        checkbox.closest('tr').addClass('selected');
        
        // Validate required fields for selected row
        validateSelectedRow(idno);
    } else {
        checkbox.val('0');
        // Remove highlight
        checkbox.closest('tr').removeClass('selected');
    }
    
    // Update form validation
    updateFormValidation();
}

/**
 * Calculate amount for a given rate input
 */
function calculateAmount(rateInputId) {
    const idno = rateInputId.match(/\d+/)[0];
    
    const rate = parseFloat($('#baserate' + idno).val()) || 0;
    const taxPercent = parseFloat($('#tax_percent' + idno).val()) || 0;
    
    const taxAmount = (rate * taxPercent) / 100;
    const totalAmount = rate + taxAmount;
    
    $('#amount' + idno).val(totalAmount.toFixed(2));
    
    // Update visual feedback
    const amountInput = $('#amount' + idno);
    if (totalAmount > 0) {
        showFieldSuccess(amountInput);
    }
}

/**
 * Validate search form
 */
function validateSearchForm() {
    const fromDate = $('#ADate1').val();
    const toDate = $('#ADate2').val();
    
    if (!fromDate) {
        showAlert('Please select From Date.', 'warning');
        $('#ADate1').focus();
        return false;
    }
    
    if (!toDate) {
        showAlert('Please select To Date.', 'warning');
        $('#ADate2').focus();
        return false;
    }
    
    if (new Date(fromDate) > new Date(toDate)) {
        showAlert('From date cannot be greater than To date.', 'warning');
        return false;
    }
    
    return true;
}

/**
 * Validate generate PO form
 */
function validateGeneratePOForm() {
    let hasSelectedItems = false;
    let allValid = true;
    
    // Check if any items are selected
    $('input[id^="selectbox"]:checked').each(function() {
        hasSelectedItems = true;
        const id = $(this).attr('id');
        const idno = id.match(/\d+/)[0];
        
        // Validate selected row
        if (!validateSelectedRow(idno)) {
            allValid = false;
        }
    });
    
    if (!hasSelectedItems) {
        showAlert('Please select at least one patient.', 'warning');
        return false;
    }
    
    if (!allValid) {
        showAlert('Please fill all required fields for selected items.', 'warning');
        return false;
    }
    
    // Confirm action
    return confirm('Do you want to generate Purchase Orders for selected items?');
}

/**
 * Validate selected row
 */
function validateSelectedRow(idno) {
    let isValid = true;
    
    // Check supplier selection
    const supplierSelect = $('#suppliername' + idno);
    if (!supplierSelect.val() || supplierSelect.val() === '') {
        showFieldError(supplierSelect, 'Please select a supplier');
        isValid = false;
    } else {
        showFieldSuccess(supplierSelect);
    }
    
    // Check rate
    const rateInput = $('#baserate' + idno);
    const rate = parseFloat(rateInput.val());
    if (isNaN(rate) || rate <= 0) {
        showFieldError(rateInput, 'Please enter a valid rate');
        isValid = false;
    } else {
        showFieldSuccess(rateInput);
    }
    
    return isValid;
}

/**
 * Initialize form features
 */
function initializeFormFeatures() {
    // Enhanced form inputs
    $('.form-input, .form-select').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
    
    // Real-time validation
    $('.form-input, .form-select').on('blur', function() {
        validateField($(this));
    });
    
    // Form enhancement
    enhanceFormElements();
}

/**
 * Enhance form elements
 */
function enhanceFormElements() {
    // Add loading states to buttons
    $('.btn').on('click', function() {
        if ($(this).hasClass('btn-primary') || $(this).hasClass('generate-po-btn')) {
            $(this).addClass('loading');
            setTimeout(() => {
                $(this).removeClass('loading');
            }, 2000);
        }
    });
    
    // Add tooltips
    $('[title]').each(function() {
        $(this).tooltip({
            placement: 'top',
            trigger: 'hover'
        });
    });
}

/**
 * Initialize form validation
 */
function initializeFormValidation() {
    // Custom validation rules
    $.validator.addMethod('requiredSelect', function(value, element) {
        return value !== '';
    }, 'Please select an option.');
    
    $.validator.addMethod('positiveNumber', function(value, element) {
        return parseFloat(value) > 0;
    }, 'Please enter a positive number.');
}

/**
 * Initialize keyboard shortcuts
 */
function initializeKeyboardShortcuts() {
    $(document).on('keydown', function(e) {
        // Ctrl + K: Focus search
        if (e.ctrlKey && e.keyCode === 75) {
            e.preventDefault();
            $('#ADate1').focus();
        }
        
        // Ctrl + R: Refresh
        if (e.ctrlKey && e.keyCode === 82) {
            e.preventDefault();
            refreshPage();
        }
        
        // Ctrl + Enter: Submit form
        if (e.ctrlKey && e.keyCode === 13) {
            e.preventDefault();
            const form = $('form:visible').first();
            if (form.length) {
                form.submit();
            }
        }
        
        // Escape: Clear form
        if (e.keyCode === 27) {
            clearForm();
        }
    });
}

/**
 * Initialize date calculations
 */
function initializeDateCalculations() {
    // Calculate validity days on page load
    calculateValidityDays();
    
    // Set default LPO date
    const defaultLpoDate = new Date();
    defaultLpoDate.setDate(defaultLpoDate.getDate() + 60);
    $('#lpodate').val(formatDate(defaultLpoDate));
}

/**
 * Initialize table features
 */
function initializeTableFeatures() {
    // Add row hover effects
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );
    
    // Initialize select all functionality
    initializeSelectAll();
}

/**
 * Initialize select all functionality
 */
function initializeSelectAll() {
    // Add select all checkbox to table header
    const tableHeader = $('.data-table thead tr').first();
    if (tableHeader.length && !tableHeader.find('.select-all').length) {
        tableHeader.prepend(`
            <th class="select-all-header">
                <input type="checkbox" class="select-all" id="selectAll">
            </th>
        `);
        
        // Add empty cell to all data rows
        $('.data-table tbody tr').prepend('<td class="select-all-cell"></td>');
        
        // Handle select all
        $('#selectAll').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('input[id^="selectbox"]').prop('checked', isChecked).trigger('change');
        });
    }
}

/**
 * Calculate validity days
 */
function calculateValidityDays() {
    const todayDate = $('#todaydate').val();
    const lpoDate = $('#lpodate').val();
    
    if (todayDate && lpoDate) {
        const d1 = parseDate(todayDate);
        const d2 = parseDate(lpoDate);
        
        if (d1 && d2) {
            const oneDay = 24 * 60 * 60 * 1000;
            const diff = Math.round(Math.abs((d2.getTime() - d1.getTime()) / oneDay));
            $('#validityperiod').val(diff);
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
 * Format date for input
 */
function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

/**
 * Initialize auto-refresh functionality
 */
function initializeAutoRefresh() {
    // Auto-refresh every 5 minutes
    setInterval(() => {
        if (document.visibilityState === 'visible') {
            // Only refresh if no forms are being filled
            if (!$('input:focus, select:focus').length) {
                refreshSearchResults();
            }
        }
    }, 300000);
}

/**
 * Load user preferences
 */
function loadUserPreferences() {
    // Load sidebar state
    const sidebarCollapsed = localStorage.getItem('sidebarCollapsed');
    if (sidebarCollapsed === 'true') {
        $('#leftSidebar').addClass('collapsed');
        $('#sidebarToggle i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
    }
    
    // Load form preferences
    const lastFromDate = localStorage.getItem('lastFromDate');
    const lastToDate = localStorage.getItem('lastToDate');
    
    if (lastFromDate && !$('#ADate1').val()) {
        $('#ADate1').val(lastFromDate);
    }
    if (lastToDate && !$('#ADate2').val()) {
        $('#ADate2').val(lastToDate);
    }
}

/**
 * Save user preferences
 */
function saveUserPreferences() {
    localStorage.setItem('lastFromDate', $('#ADate1').val());
    localStorage.setItem('lastToDate', $('#ADate2').val());
}

/**
 * Show loading state
 */
function showLoadingState() {
    $('.results-container').addClass('loading');
    $('.btn-primary, .generate-po-btn').prop('disabled', true).addClass('loading');
}

/**
 * Hide loading state
 */
function hideLoadingState() {
    $('.results-container').removeClass('loading');
    $('.btn-primary, .generate-po-btn').prop('disabled', false).removeClass('loading');
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="fas fa-${getAlertIcon(type)}"></i>
            ${message}
        </div>
    `;
    
    $('#alertContainer').html(alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        $('.alert').fadeOut();
    }, 5000);
}

/**
 * Get alert icon based on type
 */
function getAlertIcon(type) {
    const icons = {
        'success': 'check-circle',
        'danger': 'exclamation-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

/**
 * Show field success
 */
function showFieldSuccess(field) {
    field.removeClass('error').addClass('success');
    field.siblings('.field-error').remove();
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    field.removeClass('success').addClass('error');
    field.siblings('.field-error').remove();
    field.after(`<span class="field-error">${message}</span>`);
}

/**
 * Validate individual field
 */
function validateField(field) {
    const value = field.val();
    const fieldName = field.attr('name');
    
    // Clear previous errors
    field.removeClass('error');
    field.siblings('.field-error').remove();
    
    // Validate based on field type
    if (fieldName && fieldName.includes('ADate') && !value) {
        field.addClass('error');
        field.after('<span class="field-error">This field is required.</span>');
        return false;
    }
    
    return true;
}

/**
 * Update form validation
 */
function updateFormValidation() {
    const selectedCount = $('input[id^="selectbox"]:checked').length;
    const generateBtn = $('input[value="Generate PO"]');
    
    if (selectedCount > 0) {
        generateBtn.prop('disabled', false).removeClass('disabled');
    } else {
        generateBtn.prop('disabled', true).addClass('disabled');
    }
}

/**
 * Clear form
 */
function clearForm() {
    $('input[type="text"], input[type="date"]').val('');
    $('select').prop('selectedIndex', 0);
    $('input[type="checkbox"]').prop('checked', false).val('0');
    $('.field-error').remove();
    $('.error').removeClass('error');
}

/**
 * Refresh page
 */
function refreshPage() {
    location.reload();
}

/**
 * Refresh search results
 */
function refreshSearchResults() {
    const searchForm = $('form[name="drugs"]');
    if (searchForm.length && $('#ADate1').val() && $('#ADate2').val()) {
        searchForm.submit();
    }
}

/**
 * Show welcome message
 */
function showWelcomeMessage() {
    const username = $('.welcome-text strong').text();
    if (username) {
        showAlert(`Welcome back, ${username}! Ready to manage external lab purchase orders.`, 'success');
    }
}

/**
 * Handle window resize
 */
function handleWindowResize() {
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
}

/**
 * Legacy function support
 */
function calEqAmt(id) {
    handleSupplierChange.call($('#' + id)[0]);
}

function validcheckbox(id) {
    const checkbox = $('#selectbox' + id);
    if (checkbox.is(':checked')) {
        checkbox.val(1);
    } else {
        checkbox.val(0);
    }
    handleCheckboxChange.call(checkbox[0]);
}

function CalculateAmount(id) {
    calculateAmount(id);
}

function externallabvalue() {
    return validateGeneratePOForm();
}

function getValidityDays() {
    calculateValidityDays();
}

function validcheck() {
    return validateSearchForm();
}

function disableEnterKey() {
    // This function is handled by the modern event system
    return true;
}

// Export functions for global access
window.calEqAmt = calEqAmt;
window.validcheckbox = validcheckbox;
window.CalculateAmount = CalculateAmount;
window.externallabvalue = externallabvalue;
window.getValidityDays = getValidityDays;
window.validcheck = validcheck;
window.disableEnterKey = disableEnterKey;
