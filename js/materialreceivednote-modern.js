// Material Received Note Modern JavaScript - Consistent with vat.php

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
    const checkboxes = document.querySelectorAll('input[type="checkbox"].selectitem');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', handleCheckboxChange);
    });
    
    // Quantity input changes
    const quantityInputs = document.querySelectorAll('input[name="receivedquantity[]"]');
    quantityInputs.forEach(input => {
        input.addEventListener('input', handleQuantityChange);
    });
}

// Initialize autocomplete
function initializeAutocomplete() {
    // Supplier autocomplete
    if ($('#supplier').length) {
        $('#supplier').autocomplete({
            source: 'ajaxsuppliernewserach.php',
            select: function(event, ui) {
                var code = ui.item.id;
                var anum = ui.item.anum;
                $('#srchsuppliercode').val(code);
                $('#searchsupplieranum').val(anum);
                this.form.submit();
            },
            html: true,
            minLength: 2,
            delay: 300
        });
    }
}

// Setup form validation
function setupFormValidation() {
    // Invoice amount validation
    const invoiceAmount = document.getElementById('invoiceamount');
    if (invoiceAmount) {
        invoiceAmount.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9.]/g, '');
        });
    }
    
    // Supplier bill number validation
    const supplierBillNo = document.getElementById('supplierbillno');
    if (supplierBillNo) {
        supplierBillNo.addEventListener('blur', function() {
            validateSupplierBillNumber();
        });
    }
}

// Handle form submission
function handleFormSubmit(event) {
    const form = event.target;
    const formId = form.id;
    
    if (formId === 'cbform1') {
        // Supplier search form
        if (!validateSupplierSearch()) {
            event.preventDefault();
            return false;
        }
    } else if (formId === 'form1') {
        // Material receipt form
        if (!validateMaterialReceipt()) {
            event.preventDefault();
            return false;
        }
    }
}

// Validate supplier search
function validateSupplierSearch() {
    const supplier = document.getElementById('supplier');
    
    if (!supplier || !supplier.value.trim()) {
        showAlert('Please select a supplier', 'error');
        if (supplier) supplier.focus();
        return false;
    }
    
    return true;
}

// Validate material receipt
function validateMaterialReceipt() {
    // Check if invoice amount is entered
    const invoiceAmount = document.getElementById('invoiceamount');
    if (!invoiceAmount || !invoiceAmount.value.trim()) {
        showAlert('Please enter Invoice Amount', 'error');
        if (invoiceAmount) invoiceAmount.focus();
        return false;
    }
    
    // Check if supplier is selected
    const supplierCode = document.getElementById('srchsuppliercode');
    if (!supplierCode || !supplierCode.value.trim()) {
        showAlert('Please Select Supplier', 'error');
        return false;
    }
    
    // Check if supplier bill number is entered
    const supplierBillNo = document.getElementById('supplierbillno');
    if (!supplierBillNo || !supplierBillNo.value.trim()) {
        showAlert('Please Enter Supplier Invoice Number', 'error');
        if (supplierBillNo) supplierBillNo.focus();
        return false;
    }
    
    // Check if delivery bill number is entered
    const deliveryBillNo = document.getElementById('deliverybillno');
    if (!deliveryBillNo || !deliveryBillNo.value.trim()) {
        showAlert('Please Enter Delivery Number', 'error');
        if (deliveryBillNo) deliveryBillNo.focus();
        return false;
    }
    
    // Check if at least one item is selected
    const selectedItems = document.querySelectorAll('input[name="selectitem[]"]:checked');
    if (selectedItems.length === 0) {
        showAlert('Please Select At Least One Item', 'error');
        return false;
    }
    
    // Validate selected items
    for (let i = 0; i < selectedItems.length; i++) {
        const checkbox = selectedItems[i];
        const rowNumber = checkbox.id.replace('selectitem', '');
        
        // Check received quantity
        const receivedQty = document.getElementById('receivedquantity' + rowNumber);
        if (!receivedQty || !receivedQty.value.trim()) {
            showAlert('Please Enter Received Quantity for Item ' + rowNumber, 'error');
            if (receivedQty) receivedQty.focus();
            return false;
        }
        
        // Check batch number (for non-assets)
        const purchaseType = document.getElementById('purchasetype' + rowNumber);
        if (purchaseType && purchaseType.value !== 'ASSETS') {
            const batch = document.getElementById('batch' + rowNumber);
            if (!batch || !batch.value.trim()) {
                showAlert('Please Enter Batch Number for Item ' + rowNumber, 'error');
                if (batch) batch.focus();
                return false;
            }
        }
        
        // Check expiry date (for non-assets)
        if (purchaseType && purchaseType.value !== 'ASSETS') {
            const expiryDate = document.getElementById('expirydate' + rowNumber);
            if (!expiryDate || !expiryDate.value.trim()) {
                showAlert('Please Enter Expiry Date for Item ' + rowNumber, 'error');
                if (expiryDate) expiryDate.focus();
                return false;
            }
            
            // Validate expiry date format
            if (!validateExpiryDate(expiryDate.value)) {
                showAlert('Expiry Date must be in MM/YY format for Item ' + rowNumber, 'error');
                if (expiryDate) expiryDate.focus();
                return false;
            }
        }
    }
    
    // Check if total purchase amount matches invoice amount
    const totalPurchaseAmount = document.getElementById('totalpurchaseamount');
    const totalFxAmount = document.getElementById('totalfxamount');
    
    if (totalPurchaseAmount && totalFxAmount && invoiceAmount) {
        const totalAmount = parseFloat(totalFxAmount.value) || 0;
        const invoiceAmountValue = parseFloat(invoiceAmount.value) || 0;
        
        if (Math.abs(totalAmount - invoiceAmountValue) > 0.01) {
            showAlert('Total purchase amount does not match invoice amount', 'error');
            return false;
        }
    }
    
    return true;
}

// Validate expiry date format
function validateExpiryDate(dateString) {
    const regex = /^(0[1-9]|1[0-2])\/\d{2}$/;
    if (!regex.test(dateString)) {
        return false;
    }
    
    const parts = dateString.split('/');
    const month = parseInt(parts[0]);
    const year = parseInt(parts[1]);
    
    if (month < 1 || month > 12) {
        return false;
    }
    
    const currentYear = new Date().getFullYear() % 100;
    if (year < currentYear) {
        return false;
    }
    
    return true;
}

// Validate supplier bill number
function validateSupplierBillNumber() {
    const supplierCode = document.getElementById('srchsuppliercode');
    const supplierBillNo = document.getElementById('supplierbillno');
    
    if (!supplierCode || !supplierBillNo) return;
    
    const supplierCodeValue = supplierCode.value.trim();
    const billNoValue = supplierBillNo.value.trim();
    
    if (supplierCodeValue && billNoValue) {
        // Check for duplicate invoice
        $.ajax({
            url: 'ajax/ajaxsupplierinvoicecheck.php',
            type: 'POST',
            data: {
                suppliercode: supplierCodeValue,
                invoiceno: billNoValue
            },
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    showAlert(data.msg, 'error');
                    supplierBillNo.value = '';
                    supplierBillNo.focus();
                }
            },
            error: function() {
                console.error('Error checking supplier invoice');
            }
        });
    }
}

// Handle checkbox change
function handleCheckboxChange(event) {
    const checkbox = event.target;
    const rowNumber = checkbox.id.replace('selectitem', '');
    
    enabletext(rowNumber, getTotalItemCount());
}

// Handle quantity change
function handleQuantityChange(event) {
    const input = event.target;
    const rowNumber = input.id.replace('receivedquantity', '');
    
    // Validate quantity
    const quantity = parseFloat(input.value) || 0;
    const balanceQty = parseFloat(document.getElementById('balqty' + rowNumber).value) || 0;
    
    if (quantity > balanceQty) {
        showAlert('Received quantity cannot be greater than balance quantity', 'error');
        input.value = '0';
        input.focus();
        return;
    }
    
    // Update calculations
    totalcalc(rowNumber);
    totalamount(rowNumber, getTotalItemCount());
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
    const checkboxes = document.querySelectorAll('input[name="selectitem[]"]');
    return checkboxes.length;
}

// Refresh page
function refreshPage() {
    window.location.reload();
}

// Legacy functions for compatibility
function enabletext(varserialnumber, number) {
    const checkbox = document.getElementById("selectitem" + varserialnumber);
    const receivedQty = document.getElementById("receivedquantity" + varserialnumber);
    const expiryDate = document.getElementById("expirydate" + varserialnumber);
    const batch = document.getElementById("batch" + varserialnumber);
    const free = document.getElementById("free" + varserialnumber);
    const discount = document.getElementById("discount" + varserialnumber);
    const tax = document.getElementById("tax" + varserialnumber);
    
    if (checkbox.checked) {
        receivedQty.readOnly = false;
        expiryDate.readOnly = false;
        batch.readOnly = false;
        free.readOnly = false;
        discount.readOnly = false;
        tax.readOnly = false;
    } else {
        receivedQty.readOnly = true;
        expiryDate.readOnly = true;
        batch.readOnly = true;
        free.readOnly = true;
        discount.readOnly = true;
        tax.readOnly = true;
        
        receivedQty.value = '0';
        expiryDate.value = '';
        free.value = '0';
        batch.value = '';
        discount.value = '0';
    }
    
    totalamount(varserialnumber, number);
}

function totalcalc(varserialnumber) {
    const receivedQty = document.getElementById("receivedquantity" + varserialnumber).value;
    const balanceQty = document.getElementById("balqty" + varserialnumber).value;
    
    if (receivedQty !== '') {
        if (!is_int(receivedQty, varserialnumber)) {
            return false;
        }
        
        if (parseFloat(receivedQty) > parseFloat(balanceQty)) {
            showAlert("Received quantity is greater than balance quantity. Please enter lesser quantity", 'error');
            document.getElementById("receivedquantity" + varserialnumber).value = '0';
            document.getElementById("totalquantity" + varserialnumber).value = '0';
            return false;
        }
        
        const purchaseType = document.getElementById("purchasetype" + varserialnumber).value;
        let packSize, packValue;
        
        if (purchaseType === 'ASSETS' || purchaseType === 'non-medical') {
            packSize = 1;
            packValue = 1;
        } else {
            packSize = document.getElementById("packsize" + varserialnumber).value;
            packValue = packSize.substring(0, packSize.length - 1);
        }
        
        const totalQty = parseInt(receivedQty) * parseInt(packValue);
        document.getElementById("totalquantity" + varserialnumber).value = totalQty;
    }
    
    return true;
}

function is_int(value, varserialnumber) {
    if ((parseFloat(value) == parseInt(value)) && !isNaN(value)) {
        return true;
    } else {
        showAlert("Quantity should be integer", 'error');
        document.getElementById("receivedquantity" + varserialnumber).value = '0';
        return false;
    }
}

function totalcalc1(varserialnumber) {
    const receivedQty = document.getElementById("receivedquantity" + varserialnumber).value;
    const packSize = document.getElementById("packsize" + varserialnumber).value;
    const free = document.getElementById("free" + varserialnumber).value;
    
    const freeValue = free === '' ? 0 : free;
    const packValue = packSize.substring(0, packSize.length - 1);
    const totalQty = parseInt(receivedQty) * parseInt(packValue) + parseInt(freeValue);
    
    document.getElementById("totalquantity" + varserialnumber).value = totalQty;
}

function totalamount(varserialnumber, totalcount) {
    let grandtotaladjamt = 0;
    let grandtotalfxadjamt = 0;
    
    const fxamount = document.getElementById("fxamount" + varserialnumber).value;
    const fxrate = document.getElementById("fxrate").value;
    const fxamountValue = fxamount === '' ? 0 : fxamount;
    const receivedQty = document.getElementById("receivedquantity" + varserialnumber).value;
    const priceperpack = parseFloat(fxamountValue) * parseFloat(fxrate);
    const priceperpack2 = priceperpack.toFixed(2);
    
    if (priceperpack2 !== '' && receivedQty !== '') {
        const purchaseType = document.getElementById("purchasetype" + varserialnumber).value;
        let packSize, packValue;
        
        if (purchaseType === 'ASSETS' || purchaseType === 'non-medical') {
            packSize = 1;
            packValue = 1;
        } else {
            packSize = document.getElementById("packsize" + varserialnumber).value;
            packValue = packSize.substring(0, packSize.length - 1);
        }
        
        const spmarkup = document.getElementById("spmarkup" + varserialnumber).value;
        const totalamount = parseFloat(receivedQty) * parseFloat(priceperpack2) * parseFloat(packValue);
        const totalfxamount = parseFloat(receivedQty) * parseFloat(fxamountValue) * parseFloat(packValue);
        
        const tot = parseFloat(receivedQty) * parseFloat(packValue);
        const taxper = document.getElementById("taxper" + varserialnumber).value;
        let costprice1;
        
        if (parseFloat(tot) > 0) {
            if (parseFloat(taxper) > 0) {
                costprice1 = parseFloat(totalamount) / parseFloat(tot);
                const costprice2 = costprice1 * (taxper / 100);
                costprice1 = costprice1 + costprice2;
            } else {
                costprice1 = parseFloat(totalamount) / parseFloat(tot);
            }
        } else {
            costprice1 = 0;
        }
        
        const taxamount = parseFloat(totalamount) * parseFloat((taxper / 100));
        document.getElementById("tax" + varserialnumber).value = taxamount.toFixed(2);
        
        const taxamt = document.getElementById("tax" + varserialnumber).value;
        const finalTotalAmount = parseFloat(totalamount) + parseFloat(taxamt);
        const finalTotalfxAmount = parseFloat(totalfxamount) + parseFloat(taxamt);
        
        document.getElementById("totalamount" + varserialnumber).value = finalTotalAmount.toFixed(2);
        document.getElementById("totalfxamount" + varserialnumber).value = finalTotalfxAmount.toFixed(2);
        document.getElementById("costprice" + varserialnumber).value = costprice1.toFixed(2);
        
        const salepricemarkup = (parseFloat(costprice1) * parseFloat(spmarkup)) / 100;
        const saleprice = parseFloat(costprice1) + parseFloat(salepricemarkup);
        document.getElementById("saleprice" + varserialnumber).value = saleprice.toFixed(2);
        
        if (purchaseType === 'ASSETS' || purchaseType === 'non-medical') {
            document.getElementById("saleprice" + varserialnumber).value = costprice1.toFixed(2);
        }
        
        // Calculate grand totals
        for (let i = 1; i <= totalcount; i++) {
            const totaladjamount = document.getElementById("totalamount" + i).value;
            const totaladjfxamount = document.getElementById("totalfxamount" + i).value;
            const totaladjamountValue = totaladjamount === "" ? 0 : totaladjamount;
            const totaladjfxamountValue = totaladjfxamount === "" ? 0 : totaladjfxamount;
            
            if (document.getElementById("selectitem" + i).checked) {
                grandtotaladjamt += parseFloat(totaladjamountValue);
                grandtotalfxadjamt += parseFloat(totaladjfxamountValue);
            }
        }
        
        document.getElementById("totalpurchaseamount").value = grandtotaladjamt.toFixed(2);
        document.getElementById("totalfxamount").value = grandtotalfxadjamt.toFixed(2);
        document.getElementById("priceperpack" + varserialnumber).value = priceperpack2;
    }
}

function funcsave(totalcount) {
    const saveButton = document.getElementById("savebutton");
    saveButton.disabled = true;
    
    // Validate form
    if (!validateMaterialReceipt()) {
        saveButton.disabled = false;
        return false;
    }
    
    // Confirm save
    const userChoice = confirm('Are you sure of saving the entry? Please note that once saved, Inventory Data will be updated.');
    if (!userChoice) {
        saveButton.disabled = false;
        return false;
    }
    
    // Submit form
    document.form1.submit();
}

function billnotransfer() {
    const billno = document.getElementById("supplierbillno").value;
    document.getElementById("supplierbillno1").value = billno;
    
    const deliverybillno = document.getElementById("deliverybillno").value;
    document.getElementById("deliverybillno1").value = deliverybillno;
}

function validationcheck() {
    const saveButton = document.getElementById("savebutton");
    saveButton.disabled = true;
    
    const userChoice = confirm('Are you sure of saving the entry? Please note that once saved, Inventory Data will be updated.');
    if (!userChoice) {
        saveButton.disabled = false;
        return false;
    } else {
        document.form1.submit();
    }
}

function storeassign() {
    const store = document.getElementById("store").value;
    document.getElementById("store1").value = store;
}

// Number validation for inputs
function isNumber(evt, element) {
    const charCode = (evt.which) ? evt.which : event.keyCode;
    
    if ((charCode != 46 || $(element).val().indexOf('.') != -1) && 
        (charCode < 48 || charCode > 57)) {
        return false;
    }
    
    return true;
}

// Initialize on load
function funcOnLoadBodyFunctionCall() {
    // Initialize autocomplete
    if (typeof funcCustomerDropDownSearch3 === 'function') {
        funcCustomerDropDownSearch3();
    }
    
    if (typeof funcPopupPrintFunctionCall === 'function') {
        funcPopupPrintFunctionCall();
    }
}

// Print functionality
function loadprintpage1(varPaperSizeCatch) {
    const varBillNumber = document.getElementById("quickprintbill").value;
    const varBillCompanyAnum = "<?php echo $_SESSION["companyanum"]; ?>";
    
    if (varBillNumber === "") {
        showAlert("Bill Number Cannot Be Empty.", 'error');
        document.getElementById("quickprintbill").focus();
        return false;
    }
    
    const varTitleHeader = "ORIGINAL";
    if (varTitleHeader === "") {
        showAlert("Please Select Print Title.", 'error');
        document.getElementById("titleheader").focus();
        return false;
    }
    
    const varPaperSize = varPaperSizeCatch;
    
    if (varPaperSize === "A4") {
        window.open("print_bill1.php?printsource=billpage&&billautonumber=" + varBillAutoNumber + "&&companyanum=" + varBillCompanyAnum + "&&title1=" + varTitleHeader + "&&billnumber=" + varBillNumber + "", "OriginalWindowA4", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
    }
    if (varPaperSize === "A5") {
        window.open("print_bill1_a5.php?printsource=billpage&&billautonumber=" + varBillAutoNumber + "&&companyanum=" + varBillCompanyAnum + "&&title1=" + varTitleHeader + "&&billnumber=" + varBillNumber + "", "OriginalWindowA5", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
    }
}

// Default tax function
function funcDefaultTax1() {
    const varDefaultTax = document.getElementById("defaulttax").value;
    
    if (varDefaultTax !== "") {
        window.location = "sales1.php?defaulttax=" + varDefaultTax;
    } else {
        window.location = "sales1.php";
    }
}


