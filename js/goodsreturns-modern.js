// Goods Returns Modern JavaScript - Consistent with vat.php

$(document).ready(function() {
    // Initialize page
    initializePage();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize autocomplete
    initializeAutocomplete();
    
    // Setup form validation
    setupFormValidation();
});

// Initialize page components
function initializePage() {
    // Setup sidebar toggle
    setupSidebarToggle();
    
    // Setup floating menu toggle
    setupFloatingMenuToggle();
    
    // Initialize tooltips
    initializeTooltips();
    
    // Setup auto-hide alerts
    setupAutoHideAlerts();
}

// Setup sidebar toggle functionality
function setupSidebarToggle() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const leftSidebar = document.getElementById('leftSidebar');
    const menuToggle = document.getElementById('menuToggle');
    
    if (sidebarToggle && leftSidebar) {
        sidebarToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('collapsed');
            const icon = sidebarToggle.querySelector('i');
            if (leftSidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
        });
    }
    
    if (menuToggle && leftSidebar) {
        menuToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('show');
        });
    }
}

// Setup floating menu toggle
function setupFloatingMenuToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const leftSidebar = document.getElementById('leftSidebar');
    
    if (menuToggle && leftSidebar) {
        menuToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('show');
        });
    }
}

// Initialize tooltips
function initializeTooltips() {
    // Add tooltips to form elements
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

// Show tooltip
function showTooltip(event) {
    const element = event.target;
    const tooltipText = element.getAttribute('data-tooltip');
    
    if (tooltipText) {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = tooltipText;
        tooltip.style.cssText = `
            position: absolute;
            background: #333;
            color: white;
            padding: 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            z-index: 1000;
            pointer-events: none;
        `;
        
        document.body.appendChild(tooltip);
        
        const rect = element.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
        
        element.tooltipElement = tooltip;
    }
}

// Hide tooltip
function hideTooltip(event) {
    const element = event.target;
    if (element.tooltipElement) {
        element.tooltipElement.remove();
        element.tooltipElement = null;
    }
}

// Setup auto-hide alerts
function setupAutoHideAlerts() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
}

// Setup event listeners
function setupEventListeners() {
    // Form submission
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', handleFormSubmit);
    });
    
    // Input validation
    const inputs = document.querySelectorAll('input[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', validateInput);
        input.addEventListener('input', clearInputError);
    });
    
    // Checkbox changes
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="returncheckbox[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', handleCheckboxChange);
    });
    
    // Quantity input changes
    const quantityInputs = document.querySelectorAll('input[name="returnqty[]"]');
    quantityInputs.forEach(input => {
        input.addEventListener('input', handleQuantityChange);
    });
}

// Initialize autocomplete
function initializeAutocomplete() {
    // GRN autocomplete
    if ($('#grn').length) {
        $('#grn').autocomplete({
            source: 'ajaxgrnbuild.php',
            select: function(event, ui) {
                var entrydocno = ui.item.entrydocno;
                $('#grn').val(entrydocno);
                document.cbform1.submit();
            },
            html: true,
            minLength: 2,
            delay: 300
        });
    }
}

// Setup form validation
function setupFormValidation() {
    // GRN validation
    const grnInput = document.getElementById('grn');
    if (grnInput) {
        grnInput.addEventListener('blur', function() {
            validateGRN();
        });
    }
}

// Handle form submission
function handleFormSubmit(event) {
    const form = event.target;
    const formId = form.name;
    
    if (formId === 'cbform1') {
        // GRN search form
        if (!validateGRNSearch()) {
            event.preventDefault();
            return false;
        }
    } else if (formId === 'form') {
        // Goods returns form
        if (!validateGoodsReturns()) {
            event.preventDefault();
            return false;
        }
    }
}

// Validate GRN search
function validateGRNSearch() {
    const grn = document.getElementById('grn');
    
    if (!grn || !grn.value.trim()) {
        showAlert('Please enter a GRN number', 'error');
        if (grn) grn.focus();
        return false;
    }
    
    return true;
}

// Validate goods returns
function validateGoodsReturns() {
    // Check if at least one item is selected for return
    const selectedItems = document.querySelectorAll('input[name="returncheckbox[]"]:checked');
    if (selectedItems.length === 0) {
        showAlert('Please select at least one item for return', 'error');
        return false;
    }
    
    // Validate selected items
    for (let i = 0; i < selectedItems.length; i++) {
        const checkbox = selectedItems[i];
        const rowNumber = checkbox.id.replace('returncheckbox', '');
        
        // Check return quantity
        const returnQty = document.getElementById('returnqty' + rowNumber);
        if (!returnQty || !returnQty.value.trim()) {
            showAlert('Please enter return quantity for item ' + rowNumber, 'error');
            if (returnQty) returnQty.focus();
            return false;
        }
        
        // Check if return quantity is valid
        const returnQtyValue = parseFloat(returnQty.value) || 0;
        const balanceQty = parseFloat(document.getElementById('balqty' + rowNumber).value) || 0;
        
        if (returnQtyValue > balanceQty) {
            showAlert('Return quantity cannot be greater than balance quantity for item ' + rowNumber, 'error');
            if (returnQty) returnQty.focus();
            return false;
        }
        
        if (returnQtyValue <= 0) {
            showAlert('Return quantity must be greater than zero for item ' + rowNumber, 'error');
            if (returnQty) returnQty.focus();
            return false;
        }
    }
    
    return true;
}

// Validate GRN
function validateGRN() {
    const grn = document.getElementById('grn');
    
    if (!grn || !grn.value.trim()) {
        return;
    }
    
    // Check if GRN exists and is valid
    $.ajax({
        url: 'ajax/ajaxgrncheck.php',
        type: 'POST',
        data: {
            grn: grn.value
        },
        dataType: 'json',
        success: function(data) {
            if (data.status == 0) {
                showAlert(data.msg, 'error');
                grn.value = '';
                grn.focus();
            }
        },
        error: function() {
            console.error('Error checking GRN');
        }
    });
}

// Handle checkbox change
function handleCheckboxChange(event) {
    const checkbox = event.target;
    const rowNumber = checkbox.id.replace('returncheckbox', '');
    
    checkBox(rowNumber);
}

// Handle quantity change
function handleQuantityChange(event) {
    const input = event.target;
    const rowNumber = input.id.replace('returnqty', '');
    
    // Validate quantity
    const quantity = parseFloat(input.value) || 0;
    const balanceQty = parseFloat(document.getElementById('balqty' + rowNumber).value) || 0;
    
    if (quantity > balanceQty) {
        showAlert('Return quantity cannot be greater than balance quantity', 'error');
        input.value = '0';
        input.focus();
        return;
    }
    
    // Update calculations
    amt(rowNumber, getTotalItemCount());
}

// Validate input
function validateInput(event) {
    const input = event.target;
    const value = input.value.trim();
    
    if (input.hasAttribute('required') && !value) {
        showInputError(input, 'This field is required');
        return false;
    }
    
    clearInputError(input);
    return true;
}

// Clear input error
function clearInputError(event) {
    const input = event.target;
    clearInputError(input);
}

// Show input error
function showInputError(input, message) {
    input.classList.add('error');
    
    let errorElement = input.parentNode.querySelector('.error-message');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'error-message';
        errorElement.style.cssText = 'color: #dc2626; font-size: 0.8rem; margin-top: 0.25rem;';
        input.parentNode.appendChild(errorElement);
    }
    
    errorElement.textContent = message;
}

// Clear input error
function clearInputError(input) {
    input.classList.remove('error');
    
    const errorElement = input.parentNode.querySelector('.error-message');
    if (errorElement) {
        errorElement.remove();
    }
}

// Show alert
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    
    const icon = type === 'success' ? 'check-circle' : 
                 type === 'error' ? 'exclamation-triangle' : 'info-circle';
    
    alert.innerHTML = `
        <i class="fas fa-${icon} alert-icon"></i>
        <span>${message}</span>
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }, 5000);
}

// Get total item count
function getTotalItemCount() {
    const checkboxes = document.querySelectorAll('input[name="returncheckbox[]"]');
    return checkboxes.length;
}

// Refresh page
function refreshPage() {
    window.location.reload();
}

// Legacy functions for compatibility
function checkBox(cno) {
    var checkno = cno;
    
    if (document.getElementById("returncheckbox" + checkno + "").checked) {
        document.getElementById("returnqty" + checkno + "").readOnly = false;
    } else {
        document.getElementById("returnqty" + checkno + "").readOnly = true;
        
        var totamt = document.getElementById("totalamount" + checkno + "").value;
        var totamt2 = document.getElementById("value").value;
        var finalamt = totamt2 - totamt;
        
        document.getElementById("value").value = finalamt;
        document.getElementById("returnqty" + checkno + "").value = '';
        document.getElementById("totalamount" + checkno + "").value = '';
    }
}

function amt(varserialnumber3, totalcount1) {
    var totalcount1 = totalcount1;
    var grandtotaladjamt1 = 0;
    var varserialnumber3 = varserialnumber3;
    
    var returnqty = document.getElementById("returnqty" + varserialnumber3 + "").value;
    
    if (true) {
        var balqty = document.getElementById("balqty" + varserialnumber3 + "").value;
        
        if (parseInt(returnqty) > parseInt(balqty)) {
            showAlert("Return quantity is greater than Balance quantity. Please Enter lesser Quantity", 'error');
            document.getElementById("returnqty" + varserialnumber3 + "").value = 0;
            document.getElementById("value").value = 0;
            document.getElementById("returnqty" + varserialnumber3 + "").focus();
            return false;
        }
        
        document.getElementById("returncheckbox" + varserialnumber3 + "").checked = true;
        var costprice = document.getElementById("costprice" + varserialnumber3 + "").value;
        var discount = document.getElementById("discount" + varserialnumber3 + "").value;
        
        if (discount != 0.00) {
            var totalamount = parseFloat(returnqty) * parseFloat(costprice);
            var totalamount1 = (parseFloat(totalamount) * parseFloat(discount)) / 100;
            var totalamount2 = parseFloat(totalamount) - parseFloat(totalamount1);
        } else {
            if (returnqty == "") { 
                returnqty = 0; 
            }
            var totalamount2 = parseFloat(returnqty) * parseFloat(costprice);
        }
        
        document.getElementById("totalamount" + varserialnumber3 + "").value = totalamount2.toFixed(2);
        
        for (i = 1; i <= totalcount1; i++) {
            var totaladjamount = document.getElementById("totalamount" + i + "").value;
            if (totaladjamount == "") {
                totaladjamount = 0;
            }
            grandtotaladjamt1 = grandtotaladjamt1 + parseFloat(totaladjamount);
        }
        
        var BalanceAmt = document.getElementById("balanceamt").value;
        if (parseFloat(grandtotaladjamt1) > parseFloat(BalanceAmt)) {
            showAlert("Total Amount is Greater than Balance Amount", 'error');
            document.getElementById("returnqty" + varserialnumber3 + "").value = 0;
            document.getElementById("value").value = 0;
            document.getElementById("totalamount" + varserialnumber3 + "").value = 0;
            document.getElementById("returnqty" + varserialnumber3 + "").focus();
            return false;
        }
        
        document.getElementById("value").value = grandtotaladjamt1.toFixed(2);
    }
}

function funcSaveBill1() {
    var varUserChoice;
    varUserChoice = confirm('Are You Sure Want To Save This Entry?');
    
    if (varUserChoice == false) {
        showAlert("Entry Not Saved.", 'error');
        return false;
    }
}

function funcsave(totalcount5) {
    var totalcount5 = totalcount5;
    
    if (document.getElementById("grn").value == '') {
        showAlert("Please Select GRN Number", 'error');
        document.getElementById("grn").focus();
        return false;
    }
    
    for (i = 1; i <= totalcount5; i++) {
        var returnqty = document.getElementById("returnqty" + i + "").value;
        if (document.getElementById("returnqty" + i + "").readOnly == false) {
            if (returnqty == "") {
                showAlert("Please Enter Return Quantity", 'error');
                document.getElementById("returnqty" + i + "").focus();
                return false;
            }
        }
    }
    
    // Confirm save
    var userChoice = confirm('Are you sure you want to save this goods return?');
    if (!userChoice) {
        return false;
    }
    
    return true;
}

// Print functionality
function funcPrintReceipt1() {
    var varBillNumber = document.getElementById("grn").value;
    
    if (varBillNumber === "") {
        showAlert("GRN Number Cannot Be Empty.", 'error');
        return false;
    }
    
    window.open("print_goodsreturns.php?grt=" + varBillNumber, "OriginalWindow" + varBillNumber, 'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

// Initialize on load
window.onload = function() {
    // Initialize autocomplete
    if (typeof funcCustomerDropDownSearch3 === 'function') {
        funcCustomerDropDownSearch3();
    }
    
    if (typeof funcPopupPrintFunctionCall === 'function') {
        funcPopupPrintFunctionCall();
    }
}


