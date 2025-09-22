/**
 * Expense Entry Modern JavaScript
 * Handles interactive elements for the expense entry system
 */

$(document).ready(function() {
    // Initialize the application
    initializeApp();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize form functionality
    initializeFormFeatures();
});

/**
 * Initialize the application
 */
function initializeApp() {
    console.log('Expense Entry Modern JS initialized');
    
    // Check if sidebar should be collapsed by default on mobile
    if (window.innerWidth <= 768) {
        $('.left-sidebar').addClass('collapsed');
    }
    
    // Setup form validation
    setupFormValidation();
    
    // Initialize expense features
    initializeExpenseFeatures();
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
    
    // Form submission
    $('#form1').on('submit', function(e) {
        if (!validateExpenseForm()) {
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
    
    // Real-time form validation
    $('#expenseamount').on('input', function() {
        validateExpenseAmount($(this));
        formatCurrency($(this));
    });
    
    $('#expensemode').on('change', function() {
        showPaymentFields();
        updatePaymentModeIndicator();
    });
    
    // Account selection
    $('#bankname').on('change', function() {
        validateAccountSelection($(this));
    });
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl + / to focus expense amount
        if (e.ctrlKey && e.which === 191) {
            e.preventDefault();
            $('#expenseamount').focus();
        }
        
        // Escape to clear form
        if (e.which === 27) {
            clearForm();
        }
        
        // Ctrl + S to submit
        if (e.ctrlKey && e.which === 83) {
            e.preventDefault();
            $('#form1').submit();
        }
        
        // Alt + B to check balance
        if (e.altKey && e.which === 66) {
            e.preventDefault();
            checkBalance();
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
    // Real-time validation for expense amount
    $('#expenseamount').on('blur', function() {
        validateExpenseAmount($(this));
    });
    
    // Real-time validation for account selection
    $('#paynowreferalcoa').on('blur', function() {
        validateAccountSelection($(this));
    });
}

/**
 * Initialize form features
 */
function initializeFormFeatures() {
    // Add payment mode indicators
    addPaymentModeIndicators();
    
    // Initialize tooltips
    initializeTooltips();
    
    // Auto-focus first input
    $('#paynowreferalcoa').focus();
    
    // Format initial values
    formatCurrency($('#expenseamount'));
}

/**
 * Initialize expense features
 */
function initializeExpenseFeatures() {
    // Add expense amount highlighting
    highlightExpenseAmount();
    
    // Initialize document number styling
    styleDocumentNumber();
    
    // Add payment mode change handlers
    setupPaymentModeHandlers();
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
 * Validate expense form
 */
function validateExpenseForm() {
    let isValid = true;
    
    // Clear previous errors
    clearAllFieldErrors();
    
    // Validate account selection
    if (!validateAccountSelection($('#paynowreferalcoa'))) {
        isValid = false;
    }
    
    // Validate expense amount
    if (!validateExpenseAmount($('#expenseamount'))) {
        isValid = false;
    }
    
    // Validate payment mode
    if (!validatePaymentMode($('#expensemode'))) {
        isValid = false;
    }
    
    // Validate bank account
    if (!validateBankAccount($('#bankname'))) {
        isValid = false;
    }
    
    // Validate cheque fields if applicable
    if ($('#expensemode').val() === 'CHEQUE') {
        if (!validateChequeNumber($('#chequenumber'))) {
            isValid = false;
        }
        if (!validateChequeDate($('#ADate1'))) {
            isValid = false;
        }
    }
    
    return isValid;
}

/**
 * Validate expense amount
 */
function validateExpenseAmount(field) {
    const value = field.val().trim();
    
    clearFieldError(field);
    
    if (value === '' || value === '0.00') {
        showFieldError(field, 'Expense amount cannot be empty or zero');
        return false;
    }
    
    if (isNaN(value)) {
        showFieldError(field, 'Expense amount must be a valid number');
        return false;
    }
    
    const amount = parseFloat(value);
    if (amount <= 0) {
        showFieldError(field, 'Expense amount must be greater than zero');
        return false;
    }
    
    return true;
}

/**
 * Validate account selection
 */
function validateAccountSelection(field) {
    const value = field.val().trim();
    
    clearFieldError(field);
    
    if (value === '') {
        showFieldError(field, 'Please select an expense account');
        return false;
    }
    
    return true;
}

/**
 * Validate payment mode
 */
function validatePaymentMode(field) {
    const value = field.val();
    
    clearFieldError(field);
    
    if (value === '') {
        showFieldError(field, 'Please select a payment mode');
        return false;
    }
    
    return true;
}

/**
 * Validate bank account
 */
function validateBankAccount(field) {
    const value = field.val();
    
    clearFieldError(field);
    
    if (value === '') {
        showFieldError(field, 'Please select an account');
        return false;
    }
    
    return true;
}

/**
 * Validate cheque number
 */
function validateChequeNumber(field) {
    const value = field.val().trim();
    
    clearFieldError(field);
    
    if (value === '') {
        showFieldError(field, 'Cheque number is required for cheque payments');
        return false;
    }
    
    return true;
}

/**
 * Validate cheque date
 */
function validateChequeDate(field) {
    const value = field.val().trim();
    
    clearFieldError(field);
    
    if (value === '') {
        showFieldError(field, 'Cheque date is required for cheque payments');
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
 * Clear all field errors
 */
function clearAllFieldErrors() {
    $('.form-input, .form-select').removeClass('error');
    $('.field-error').remove();
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
 * Format currency input
 */
function formatCurrency(field) {
    let value = field.val().replace(/[^\d.]/g, '');
    
    if (value !== '') {
        const amount = parseFloat(value);
        if (!isNaN(amount)) {
            field.val(amount.toFixed(2));
        }
    }
}

/**
 * Show payment fields based on selected mode
 */
function showPaymentFields() {
    const mode = $('#expensemode').val();
    const chequeNumberGroup = $('#chequeNumberGroup');
    const chequeDateGroup = $('#chequeDateGroup');
    
    // Hide all conditional fields first
    chequeNumberGroup.hide();
    chequeDateGroup.hide();
    
    // Show relevant fields based on payment mode
    if (mode === 'CHEQUE') {
        chequeNumberGroup.show();
        chequeDateGroup.show();
    }
    
    // Update payment mode indicator
    updatePaymentModeIndicator();
}

/**
 * Update payment mode indicator
 */
function updatePaymentModeIndicator() {
    const mode = $('#expensemode').val();
    const modeIndicator = $('#paymentModeIndicator');
    
    if (mode) {
        if (modeIndicator.length === 0) {
            $('#expensemode').after('<div id="paymentModeIndicator" class="payment-mode-indicator"></div>');
        }
        
        const indicator = $('#paymentModeIndicator');
        indicator.removeClass('cash cheque online card adjustment');
        indicator.addClass(mode.toLowerCase());
        
        let icon = '';
        switch(mode) {
            case 'CASH':
                icon = '<i class="fas fa-money-bill-wave"></i>';
                break;
            case 'CHEQUE':
                icon = '<i class="fas fa-university"></i>';
                break;
            case 'ONLINE':
                icon = '<i class="fas fa-globe"></i>';
                break;
            case 'CARD':
                icon = '<i class="fas fa-credit-card"></i>';
                break;
            case 'ADJUSTMENT':
                icon = '<i class="fas fa-exchange-alt"></i>';
                break;
        }
        
        indicator.html(`${icon} ${mode}`);
    } else {
        $('#paymentModeIndicator').remove();
    }
}

/**
 * Add payment mode indicators
 */
function addPaymentModeIndicators() {
    // Add payment mode indicators to options
    $('#expensemode option').each(function() {
        const option = $(this);
        const value = option.val();
        
        if (value) {
            let icon = '';
            switch(value) {
                case 'CASH':
                    icon = '💰';
                    break;
                case 'CHEQUE':
                    icon = '🏦';
                    break;
                case 'ONLINE':
                    icon = '🌐';
                    break;
                case 'CARD':
                    icon = '💳';
                    break;
                case 'ADJUSTMENT':
                    icon = '🔄';
                    break;
            }
            
            if (icon) {
                option.text(`${icon} ${option.text()}`);
            }
        }
    });
}

/**
 * Highlight expense amount
 */
function highlightExpenseAmount() {
    const amountField = $('#expenseamount');
    amountField.on('focus', function() {
        $(this).addClass('expense-amount-highlight');
    }).on('blur', function() {
        $(this).removeClass('expense-amount-highlight');
    });
}

/**
 * Style document number
 */
function styleDocumentNumber() {
    const docNumber = $('#docnumber');
    docNumber.addClass('document-number');
}

/**
 * Setup payment mode handlers
 */
function setupPaymentModeHandlers() {
    // Add change handler for payment mode
    $('#expensemode').on('change', function() {
        showPaymentFields();
    });
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
 * Clear form
 */
function clearForm() {
    $('#form1')[0].reset();
    $('#expenseamount').val('0.00');
    $('#paynowreferalcoa').val('');
    clearAllFieldErrors();
    $('#paymentModeIndicator').remove();
    showPaymentFields();
}

/**
 * Check balance
 */
function checkBalance() {
    balances();
}

/**
 * Print previous receipt
 */
function printPreviousReceipt() {
    funcPrintReceipt1();
}

/**
 * Show loading spinner
 */
function showLoadingSpinner() {
    const spinner = `
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
            <span>Saving Expense Entry...</span>
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
function paymententry1process1() {
    return validateExpenseForm();
}

function funcPrintReceipt1() {
    window.open("print_expense_receipt1.php?billnumber=<?php echo $billnumber; ?>","OriginalWindow1",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function balances() {
    var balance = 0;
    var mode = document.getElementById("expensemode").value;
    
    if(mode == 'CASH'){
        <?php
        $querydcash = "SELECT SUM(cash) AS totalcash FROM paymentmodedebit";
        $execdcash = mysqli_query($GLOBALS["___mysqli_ston"], $querydcash) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $resdcash= mysqli_fetch_array($execdcash);
        $debitcash = $resdcash['totalcash'];
        
        $queryccash = "SELECT SUM(cash) AS totalccash FROM paymentmodecredit";
        $execccash = mysqli_query($GLOBALS["___mysqli_ston"], $queryccash) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $resccash= mysqli_fetch_array($execccash);
        $creditcash = $resccash['totalccash'];
        $balance = $debitcash - $creditcash;
        ?>
        
        var balance = '<?php echo number_format($balance,2,'.',','); ?>';
        document.getElementById("balanceSection").style.display = 'block';
        document.getElementById("balanceAmount").textContent = balance;
        
        if((document.getElementById("expenseamount").value) >= balance) { 
            alert("The expense amount should be less than of balance amount"); 
        }
    } else {
        document.getElementById("balanceSection").style.display = 'none';
    }
}

function coasearch(varCallFrom) {
    var varCallFrom = varCallFrom;
    window.open("popup_coasearchexpense.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
}

// Modern functions
function refreshPage() {
    window.location.reload();
}

function printPreviousReceipt() {
    funcPrintReceipt1();
}

function checkBalance() {
    balances();
}

function showPaymentFields() {
    const mode = document.getElementById('expensemode').value;
    const chequeNumberGroup = document.getElementById('chequeNumberGroup');
    const chequeDateGroup = document.getElementById('chequeDateGroup');
    
    if (mode === 'CHEQUE') {
        chequeNumberGroup.style.display = 'block';
        chequeDateGroup.style.display = 'block';
    } else {
        chequeNumberGroup.style.display = 'none';
        chequeDateGroup.style.display = 'none';
    }
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
            
            .payment-mode-indicator {
                margin-top: 0.5rem;
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                font-size: 0.875rem;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .payment-mode-indicator.cash {
                background: #28a745;
                color: white;
            }
            
            .payment-mode-indicator.cheque {
                background: #17a2b8;
                color: white;
            }
            
            .payment-mode-indicator.online {
                background: #2c5aa0;
                color: white;
            }
            
            .payment-mode-indicator.card {
                background: #ffc107;
                color: #343a40;
            }
            
            .payment-mode-indicator.adjustment {
                background: #6c757d;
                color: white;
            }
            
            .expense-amount-highlight {
                border-color: #dc3545 !important;
                box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
                transform: scale(1.02);
            }
            
            .document-number {
                font-family: 'Courier New', monospace;
                font-weight: 600;
                color: #2c5aa0;
                background: #f8f9fa;
                padding: 0.5rem 0.75rem;
                border-radius: 0.375rem;
                font-size: 1.125rem;
            }
            
            .balance-display {
                animation: slideInDown 0.5s ease-out;
            }
            
            .balance-info {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                font-weight: 600;
                color: #155724;
            }
            
            .balance-info i {
                font-size: 1.25rem;
                color: #28a745;
            }
            
            .balance-amount {
                font-size: 1.25rem;
                font-weight: 700;
                color: #28a745;
            }
            
            @keyframes slideInDown {
                from {
                    transform: translateY(-100%);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
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

