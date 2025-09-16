// Bank Statement Update Modern JavaScript

$(document).ready(function() {
    // Initialize the application
    initializeBankStatementUpdate();
    
    // Form validation
    initializeFormValidation();
    
    // Edit functionality
    initializeEditFunctionality();
    
    // Save functionality
    initializeSaveFunctionality();
    
    // Responsive design
    initializeResponsiveDesign();
});

// Initialize the application
function initializeBankStatementUpdate() {
    console.log('Bank Statement Update initialized');
    
    // Add loading states
    addLoadingStates();
    
    // Initialize tooltips
    initializeTooltips();
    
    // Add keyboard shortcuts
    addKeyboardShortcuts();
}

// Form validation
function initializeFormValidation() {
    const form = $('#bankStatementForm');
    
    form.on('submit', function(e) {
        const referenceno = $('#referenceno').val().trim();
        
        if (referenceno === '') {
            e.preventDefault();
            showAlert('Please enter a transaction reference number', 'error');
            $('#referenceno').focus();
            return false;
        }
        
        // Show loading state
        showLoadingState();
    });
    
    // Real-time validation
    $('#referenceno').on('input', function() {
        const value = $(this).val().trim();
        const formGroup = $(this).closest('.form-group');
        
        if (value === '') {
            formGroup.removeClass('has-success').addClass('has-error');
        } else {
            formGroup.removeClass('has-error').addClass('has-success');
        }
    });
}

// Edit functionality
function initializeEditFunctionality() {
    $('.edititem').on('click', function(e) {
        e.preventDefault();
        
        const clickedid = $(this).attr('id');
        const currentExpdate = $('tr#' + clickedid).find('div.expdate').text();
        
        console.log('Edit item clicked:', clickedid);
        
        // Show edit fields
        $('tr#' + clickedid).find('td.expirydatetd').show();
        $('tr#' + clickedid).find('td.expirydatetdstatic').hide();
        
        // Set current date value
        $('#expdate_' + clickedid).val(currentExpdate);
        
        // Show save button
        $('#s_' + clickedid).show();
        
        // Add visual feedback
        $(this).closest('tr').addClass('editing');
        
        return false;
    });
}

// Save functionality
function initializeSaveFunctionality() {
    $('.saveitem').on('click', function(e) {
        e.preventDefault();
        
        const clickedid = $(this).attr('id');
        const idstr = clickedid.split('s_');
        const id = idstr[1];
        
        const expiryDate = $('#expdate_' + id).val();
        const autonumber = $('#autonumber_' + id).val();
        const chequedate = $('#chequedate_' + id).val();
        
        // Validate dates
        if (!validateDates(chequedate, expiryDate)) {
            return false;
        }
        
        // Show loading state
        showSaveLoadingState(id);
        
        // Make AJAX request
        $.ajax({
            url: 'ajax/bankstmtdateupdate.php',
            type: 'POST',
            dataType: 'json',
            data: {
                autonumber: autonumber,
                bankdate: expiryDate
            },
            success: function(data) {
                handleSaveSuccess(data, id, expiryDate);
            },
            error: function(xhr, status, error) {
                handleSaveError(xhr, status, error);
            }
        });
        
        return false;
    });
}

// Validate dates
function validateDates(chequedate, expiryDate) {
    const chequedateObj = new Date(chequedate);
    const expiryDateObj = new Date(expiryDate);
    
    if (chequedateObj > expiryDateObj) {
        showAlert('Statement Date should not be less than Transaction Date', 'error');
        return false;
    }
    
    return true;
}

// Handle save success
function handleSaveSuccess(data, id, bankdate) {
    hideSaveLoadingState(id);
    
    if (data.status == 1) {
        // Update UI
        $('#expirydate_' + id).val(bankdate);
        $('tr#' + id).find('td.expirydatetd').hide();
        $('tr#' + id).find('td.expirydatetdstatic').show();
        $('#uiexpirydate_' + id).text(bankdate);
        $('#s_' + id).hide();
        
        // Remove editing state
        $('tr#' + id).removeClass('editing');
        
        // Show success message
        showAlert('Bank statement date updated successfully', 'success');
        
        // Add success animation
        $('tr#' + id).addClass('success-update');
        setTimeout(() => {
            $('tr#' + id).removeClass('success-update');
        }, 2000);
    } else {
        showAlert(data.msg || 'Failed to update bank statement date', 'error');
    }
}

// Handle save error
function handleSaveError(xhr, status, error) {
    console.error('Save error:', error);
    showAlert('An error occurred while updating the bank statement date', 'error');
}

// Show loading state
function showLoadingState() {
    const submitBtn = $('#submitBtn');
    const originalText = submitBtn.html();
    
    submitBtn.prop('disabled', true);
    submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Searching...');
    
    // Store original text for restoration
    submitBtn.data('original-text', originalText);
}

// Hide loading state
function hideLoadingState() {
    const submitBtn = $('#submitBtn');
    const originalText = submitBtn.data('original-text');
    
    submitBtn.prop('disabled', false);
    submitBtn.html(originalText);
}

// Show save loading state
function showSaveLoadingState(id) {
    const saveBtn = $('#s_' + id);
    const originalText = saveBtn.html();
    
    saveBtn.prop('disabled', true);
    saveBtn.html('<i class="fas fa-spinner fa-spin"></i> Updating...');
    
    saveBtn.data('original-text', originalText);
}

// Hide save loading state
function hideSaveLoadingState(id) {
    const saveBtn = $('#s_' + id);
    const originalText = saveBtn.data('original-text');
    
    saveBtn.prop('disabled', false);
    saveBtn.html(originalText);
}

// Show alert
function showAlert(message, type = 'info') {
    const alertClass = `alert-${type}`;
    const iconClass = getAlertIcon(type);
    
    const alertHtml = `
        <div class="alert ${alertClass}">
            <i class="fas ${iconClass} alert-icon"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Remove existing alerts
    $('.alert-container .alert').remove();
    
    // Add new alert
    $('.alert-container').html(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        $('.alert-container .alert').fadeOut();
    }, 5000);
}

// Get alert icon
function getAlertIcon(type) {
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-triangle',
        warning: 'fa-exclamation-circle',
        info: 'fa-info-circle'
    };
    
    return icons[type] || icons.info;
}

// Reset form
function resetForm() {
    $('#bankStatementForm')[0].reset();
    $('.form-group').removeClass('has-success has-error');
    $('.alert-container .alert').remove();
    $('#referenceno').focus();
}

// Add loading states
function addLoadingStates() {
    // Add loading class to buttons
    $('.btn, .submit-btn').on('click', function() {
        if (!$(this).prop('disabled')) {
            $(this).addClass('loading');
        }
    });
    
    // Remove loading class after a delay
    setTimeout(() => {
        $('.btn, .submit-btn').removeClass('loading');
    }, 1000);
}

// Initialize tooltips
function initializeTooltips() {
    // Add tooltips to buttons
    $('.edititem').attr('title', 'Edit statement date');
    $('.saveitem').attr('title', 'Save changes');
    $('.date-picker-icon').attr('title', 'Select date');
}

// Add keyboard shortcuts
function addKeyboardShortcuts() {
    $(document).on('keydown', function(e) {
        // Ctrl + Enter to submit form
        if (e.ctrlKey && e.key === 'Enter') {
            $('#bankStatementForm').submit();
        }
        
        // Escape to cancel editing
        if (e.key === 'Escape') {
            $('.editing').each(function() {
                const id = $(this).attr('id');
                $('tr#' + id).find('td.expirydatetd').hide();
                $('tr#' + id).find('td.expirydatetdstatic').show();
                $('#s_' + id).hide();
                $(this).removeClass('editing');
            });
        }
    });
}

// Responsive design
function initializeResponsiveDesign() {
    // Handle window resize
    $(window).on('resize', function() {
        adjustTableLayout();
    });
    
    // Initial adjustment
    adjustTableLayout();
}

// Adjust table layout for mobile
function adjustTableLayout() {
    if ($(window).width() < 768) {
        $('.data-table').addClass('mobile-table');
    } else {
        $('.data-table').removeClass('mobile-table');
    }
}

// Utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Export functions for global access
window.resetForm = resetForm;
window.showAlert = showAlert;
