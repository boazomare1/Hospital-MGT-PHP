// RFQ Goods Received Note Modern JavaScript - MedStar Hospital Management

$(document).ready(function() {
    // Initialize page
    initializePage();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize autocomplete
    initializeAutocomplete();
});

function initializePage() {
    // Setup sidebar toggle
    $('#menuToggle').click(function() {
        $('#leftSidebar').toggleClass('collapsed');
        $(this).find('i').toggleClass('fa-bars fa-times');
    });
    
    // Setup sidebar toggle button
    $('#sidebarToggle').click(function() {
        $('#leftSidebar').toggleClass('collapsed');
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}

function setupEventListeners() {
    // Form validation
    $('form').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
    });
    
    // Real-time calculations
    $('.form-input-small').on('input', function() {
        calculateTotals();
    });
    
    // Store assignment
    $('#store').on('change', function() {
        storeassign();
    });
    
    // Bill number transfer
    $('#supplierbillno').on('input', function() {
        billnotransfer();
    });
}

function initializeAutocomplete() {
    // MRN autocomplete
    if (typeof funcCustomerDropDownSearch3 === 'function') {
        funcCustomerDropDownSearch3();
    }
    
    // Setup MRN autocomplete
    $('#po').autocomplete({
        source: 'ajaxmrnbuild.php',
        select: function(event, ui) {
            $('#po').val(ui.item.value);
            document.cbform1.submit();
        },
        html: true
    });
}

// Original functions from the legacy code
function loadprintpage1(varPaperSizeCatch) {
    var varPaperSize = varPaperSizeCatch;
    var varBillNumber = document.getElementById("quickprintbill").value;
    var varBillAutoNumber = "";
    var varBillCompanyAnum = "<?php echo $_SESSION["companyanum"]; ?>";
    
    if (varBillNumber == "") {
        alert("Bill Number Cannot Be Empty.");
        document.getElementById("quickprintbill").focus();
        return false;
    }
    
    var varPrintHeader = "INVOICE";
    var varTitleHeader = "ORIGINAL";
    
    if (varTitleHeader == "") {
        alert("Please Select Print Title.");
        document.getElementById("titleheader").focus();
        return false;
    }
    
    if (varPaperSize == "A4") {
        window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
    }
    
    if (varPaperSize == "A5") {
        window.open("print_bill1_a5.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
    }
}

function funcDefaultTax1() {
    var varDefaultTax = document.getElementById("defaulttax").value;
    
    if (varDefaultTax != "") {
        window.location = "sales1.php?defaulttax=" + varDefaultTax;
    } else {
        window.location = "sales1.php";
    }
}

function funcOnLoadBodyFunctionCall() {
    // Initialize autocomplete
    if (typeof funcCustomerDropDownSearch3 === 'function') {
        funcCustomerDropDownSearch3();
    }
    
    if (typeof funcPopupPrintFunctionCall === 'function') {
        funcPopupPrintFunctionCall();
    }
}

function totalcalc(varserialnumber) {
    var varserialnumber = varserialnumber;
    var receivedqty = document.getElementById("receivedquantity" + varserialnumber).value;
    
    if (receivedqty != '') {
        is_int(receivedqty, varserialnumber);
    }
    
    var balqty = document.getElementById("balqty" + varserialnumber).value;
    
    if (parseFloat(receivedqty) > parseFloat(balqty)) {
        showAlert("Received quantity is greater than Balance quantity. Please Enter Lesser quantity", "error");
        document.getElementById("receivedquantity" + varserialnumber).value = 0;
        return false;
    }
    
    if (receivedqty != '') {
        var packsize = document.getElementById("packsize" + varserialnumber).value;
        var packvalue = packsize.substring(0, packsize.length - 1);
        var totalqty = parseInt(receivedqty) * parseInt(packvalue);
        document.getElementById("totalquantity" + varserialnumber).value = totalqty;
    }
    
    return true;
}

function is_int(value, varserialnumber8) {
    if ((parseFloat(value) == parseInt(value)) && !isNaN(value)) {
        return true;
    } else {
        showAlert("Quantity should be integer", "error");
        document.getElementById("receivedquantity" + varserialnumber8).value = 0;
        return false;
    }
}

function totalcalc1(varserialnumber1) {
    var varserialnumber1 = varserialnumber1;
    var receivedqty1 = document.getElementById("receivedquantity" + varserialnumber1).value;
    var packsize1 = document.getElementById("packsize" + varserialnumber1).value;
    var free1 = document.getElementById("free" + varserialnumber1).value;
    
    if (free1 != '') {
        var packvalue1 = packsize1.substring(0, packsize1.length - 1);
        var totalqty1 = parseInt(receivedqty1) * parseInt(packvalue1) + parseInt(free1);
        document.getElementById("totalquantity" + varserialnumber1).value = totalqty1;
    }
}

function totalamount(varserialnumber2, totalcount) {
    var grandtotaladjamt = 0;
    var varserialnumber2 = varserialnumber2;
    var totalcount = totalcount;
    var receivedqty2 = document.getElementById("receivedquantity" + varserialnumber2).value;
    var priceperpack2 = document.getElementById("priceperpack" + varserialnumber2).value;
    
    if (priceperpack2 != '' && receivedqty2 != '') {
        var packsize1 = document.getElementById("packsize" + varserialnumber2).value;
        var packvalue1 = packsize1.substring(0, packsize1.length - 1);
        var spmarkup = document.getElementById("spmarkup" + varserialnumber2).value;
        var totalamount = parseFloat(receivedqty2) * parseFloat(priceperpack2);
        
        document.getElementById("totalamount" + varserialnumber2).value = totalamount.toFixed(2);
        var tot = parseFloat(receivedqty2) * parseFloat(packvalue1);
        var costprice1 = parseFloat(totalamount) / parseFloat(tot);
        document.getElementById("costprice" + varserialnumber2).value = costprice1.toFixed(2);
        
        var saleprice = parseFloat(costprice1) * parseFloat(spmarkup);
        document.getElementById("saleprice" + varserialnumber2).value = saleprice.toFixed(2);
        
        for (i = 1; i <= totalcount; i++) {
            var totaladjamount = document.getElementById("totalamount" + i).value;
            if (totaladjamount == "") {
                totaladjamount = 0;
            }
            grandtotaladjamt = grandtotaladjamt + parseFloat(totaladjamount);
        }
        
        document.getElementById("totalpurchaseamount").value = grandtotaladjamt.toFixed(2);
    }
}

function totalamount5(varserialnumber3, totalcount1) {
    var totalcount1 = totalcount1;
    var grandtotaladjamt1 = 0;
    var varserialnumber3 = varserialnumber3;
    var receivedqty3 = document.getElementById("receivedquantity" + varserialnumber3).value;
    var priceperpack3 = document.getElementById("priceperpack" + varserialnumber3).value;
    var totalamount3 = parseFloat(receivedqty3) * parseFloat(priceperpack3);
    var packsize3 = document.getElementById("packsize" + varserialnumber3).value;
    var packvalue3 = packsize3.substring(0, packsize3.length - 1);
    var discountpercent3 = document.getElementById("discount" + varserialnumber3).value;
    
    if (discountpercent3 != '') {
        var tax = document.getElementById("tax" + varserialnumber3).value;
        var spmarkup1 = document.getElementById("spmarkup" + varserialnumber3).value;
        
        if (tax == '') {
            var totalamount31 = parseFloat(totalamount3) * parseFloat(discountpercent3);
            var totalamount32 = parseFloat(totalamount31) / 100;
            var finalamount3 = parseFloat(totalamount3) - parseFloat(totalamount32);
            var tot1 = parseFloat(receivedqty3) * parseFloat(packvalue3);
            var costprice1 = parseFloat(finalamount3) / parseFloat(tot1);
            document.getElementById("costprice" + varserialnumber3).value = costprice1.toFixed(2);
            var saleprice = parseFloat(costprice1) * parseFloat(spmarkup1);
            document.getElementById("saleprice" + varserialnumber3).value = saleprice.toFixed(2);
        } else {
            var totalamount31 = parseFloat(totalamount3) * parseFloat(discountpercent3);
            var totalamount32 = parseFloat(totalamount31) / 100;
            var finalamount3 = parseFloat(totalamount3) - parseFloat(totalamount32);
            var finaltaxamount = parseFloat(finalamount3) * parseFloat(tax);
            var finaltaxamount1 = parseFloat(finaltaxamount) / 100;
            var finaltaxamount3 = parseFloat(finalamount3) + parseFloat(finaltaxamount1);
            var tot1 = parseFloat(receivedqty3) * parseFloat(packvalue3);
            var costprice1 = parseFloat(finaltaxamount3) / parseFloat(tot1);
            document.getElementById("costprice" + varserialnumber3).value = costprice1.toFixed(2);
            var saleprice = parseFloat(costprice1) * parseFloat(spmarkup1);
            document.getElementById("saleprice" + varserialnumber3).value = saleprice.toFixed(2);
        }
        
        document.getElementById("totalamount" + varserialnumber3).value = finalamount3.toFixed(2);
        
        for (i = 1; i <= totalcount1; i++) {
            var totaladjamount = document.getElementById("totalamount" + i).value;
            if (totaladjamount == "") {
                totaladjamount = 0;
            }
            grandtotaladjamt1 = grandtotaladjamt1 + parseFloat(totaladjamount);
        }
        
        document.getElementById("totalpurchaseamount").value = grandtotaladjamt1.toFixed(2);
    }
}

function totalamount20(varserialnumber4, totalcount2) {
    var totalcount2 = totalcount2;
    var grandtotaladjamt2 = 0;
    var varserialnumber4 = varserialnumber4;
    var receivedqty4 = document.getElementById("receivedquantity" + varserialnumber4).value;
    var priceperpack4 = document.getElementById("priceperpack" + varserialnumber4).value;
    var packsize4 = document.getElementById("packsize" + varserialnumber4).value;
    var packvalue4 = packsize4.substring(0, packsize4.length - 1);
    var totalamount4 = parseFloat(receivedqty4) * parseFloat(priceperpack4);
    var discountpercent4 = document.getElementById("discount" + varserialnumber4).value;
    var spmarkup2 = document.getElementById("spmarkup" + varserialnumber4).value;
    
    if (discountpercent4 != '') {
        var totalamount41 = parseFloat(totalamount4) * parseFloat(discountpercent4);
        var totalamount42 = parseFloat(totalamount41) / 100;
        var finalamount4 = parseFloat(totalamount4) - parseFloat(totalamount42);
        var tax = document.getElementById("tax" + varserialnumber4).value;
        
        if (tax != '') {
            var finaltaxamount = parseFloat(finalamount4) * parseFloat(tax);
            var finaltaxamount1 = parseFloat(finaltaxamount) / 100;
            var finaltaxamount2 = parseFloat(finalamount4) + parseFloat(finaltaxamount1);
            var tot2 = parseFloat(receivedqty4) * parseFloat(packvalue4);
            var costprice = parseFloat(finaltaxamount2) / parseFloat(tot2);
            document.getElementById("costprice" + varserialnumber4).value = costprice.toFixed(2);
            var saleprice = parseFloat(costprice) * parseFloat(spmarkup2);
            document.getElementById("saleprice" + varserialnumber4).value = saleprice.toFixed(2);
        }
    } else {
        var tax = document.getElementById("tax" + varserialnumber4).value;
        if (tax != '') {
            var finaltaxamount = parseFloat(totalamount4) * parseFloat(tax);
            var finaltaxamount1 = parseFloat(finaltaxamount) / 100;
            var finaltaxamount2 = parseFloat(totalamount4) + parseFloat(finaltaxamount1);
            var tot2 = parseFloat(receivedqty4) * parseFloat(packvalue4);
            var costprice = parseFloat(finaltaxamount2) / parseFloat(tot2);
            document.getElementById("costprice" + varserialnumber4).value = costprice.toFixed(2);
            var saleprice = parseFloat(costprice) * parseFloat(spmarkup2);
            document.getElementById("saleprice" + varserialnumber4).value = saleprice.toFixed(2);
        }
    }
    
    document.getElementById("totalamount" + varserialnumber4).value = finaltaxamount2.toFixed(2);
    
    for (i = 1; i <= totalcount2; i++) {
        var totaladjamount = document.getElementById("totalamount" + i).value;
        if (totaladjamount == "") {
            totaladjamount = 0;
        }
        grandtotaladjamt2 = grandtotaladjamt2 + parseFloat(totaladjamount);
    }
    
    document.getElementById("totalpurchaseamount").value = grandtotaladjamt2.toFixed(2);
}

function funcsave(totalcount5) {
    var totalcount5 = totalcount5;
    
    if (document.getElementById("po").value == '') {
        showAlert("Please Select Purchase Order", "error");
        document.getElementById("po").focus();
        return false;
    }
    
    if (document.getElementById("supplierbillno").value == '') {
        showAlert("Please Enter Supplier Invoice Number", "error");
        document.getElementById("supplierbillno").focus();
        return false;
    }
    
    if (document.getElementById("store").value == '') {
        showAlert("Please Select Store", "error");
        document.getElementById("store").focus();
        return false;
    }
    
    for (i = 1; i <= totalcount5; i++) {
        var receivedquantity = document.getElementById("receivedquantity" + i).value;
        if (receivedquantity == "") {
            showAlert("Please Enter Received Quantity", "error");
            document.getElementById("receivedquantity" + i).focus();
            return false;
        }
    }
    
    for (i = 1; i <= totalcount5; i++) {
        var batch = document.getElementById("batch" + i).value;
        if (batch == "") {
            showAlert("Please Enter batch Number", "error");
            document.getElementById("batch" + i).focus();
            return false;
        }
    }
    
    for (i = 1; i <= totalcount5; i++) {
        var varItemExpiryDate = document.getElementById("expirydate" + i).value;
        if (varItemExpiryDate == "") {
            showAlert("Please Enter Expiry Date", "error");
            document.getElementById("expirydate" + i).focus();
            return false;
        }
        
        var varItemExpiryDateLength = varItemExpiryDate.length;
        var varItemExpiryDateLength = parseInt(varItemExpiryDateLength);
        
        if (varItemExpiryDateLength != 5) {
            showAlert("Expiry Date Not In Format. Please Enter MM/YY Format. Length Should Be Five Characters.", "error");
            document.getElementById("expirydate" + i).focus();
            return false;
        }
        
        var varItemExpiryDateArray = varItemExpiryDate.split("/");
        var varItemExpiryDateArrayLength = varItemExpiryDateArray.length;
        
        if (varItemExpiryDateArrayLength != 2) {
            showAlert("Expiry Date Not In Format. Please Enter MM/YY Format. Forward Slash Is Missing.", "error");
            document.getElementById("expirydate" + i).focus();
            return false;
        }
        
        var varItemExpiryDateMonthLength = varItemExpiryDateArray[0];
        var varItemExpiryDateMonthLength = varItemExpiryDateMonthLength.length;
        var varItemExpiryDateMonthLength = parseInt(varItemExpiryDateMonthLength);
        
        if (varItemExpiryDateMonthLength != 2) {
            showAlert("Expiry Date Not In Format. Please Enter MM/YY Format. Preceding Zero Is Required Except November & December.", "error");
            document.getElementById("expirydate" + i).focus();
            return false;
        }
        
        var varItemExpiryDateYearLength = varItemExpiryDateArray[0];
        var varItemExpiryDateYearLength = varItemExpiryDateYearLength.length;
        var varItemExpiryDateYearLength = parseInt(varItemExpiryDateYearLength);
        
        if (varItemExpiryDateYearLength != 2) {
            showAlert("Expiry Date Not In Format. Please Enter MM/YY Format. Simply Give Current Year In Two Digits.", "error");
            document.getElementById("expirydate" + i).focus();
            return false;
        }
        
        var varItemExpiryDateMonth = varItemExpiryDateArray[0];
        
        if (isNaN(varItemExpiryDateMonth)) {
            showAlert("Expiry Date Not In Format. Please Enter MM/YY Format. Month Should Be Number.", "error");
            document.getElementById("expirydate" + i).focus();
            return false;
        }
        
        var varItemExpiryDateYear = varItemExpiryDateArray[1];
        
        if (isNaN(varItemExpiryDateYear)) {
            showAlert("Expiry Date Not In Format. Please Enter MM/YY Format. Year Should Be Number.", "error");
            document.getElementById("expirydate" + i).focus();
            return false;
        }
        
        var varItemExpiryDateMonth = varItemExpiryDateArray[0];
        
        if (varItemExpiryDateMonth > 12 || varItemExpiryDateMonth == 0) {
            showAlert("Expiry Month Should Be Between 1 And 12.", "error");
            document.getElementById("expirydate" + i).focus();
            return false;
        }
        
        var varItemExpiryDateYear = varItemExpiryDateArray[1];
        
        if (varItemExpiryDateYear < 13 || varItemExpiryDateYear > 23) {
            showAlert("Expiry Year Should Be Between 2013 And 2023.", "error");
            document.getElementById("expirydate" + i).focus();
            return false;
        }
    }
    
    for (i = 1; i <= totalcount5; i++) {
        var priceperpack = document.getElementById("priceperpack" + i).value;
        if (priceperpack == "") {
            showAlert("Please Enter Price Per Pack", "error");
            document.getElementById("priceperpack" + i).focus();
            return false;
        }
    }
}

function billnotransfer() {
    var billno = document.getElementById("supplierbillno").value;
    document.getElementById("supplierbillno1").value = billno;
}

function validationcheck() {
    var varUserChoice = confirm('Are you sure of saving the entry? Pl note that once saved, Inventory and Financial Data will be updated.');
    
    if (varUserChoice == false) {
        showAlert("Entry Not Saved.", "info");
        return false;
    } else {
        document.cbform1.submit();
    }
}

function storeassign() {
    var store = document.getElementById("store").value;
    document.getElementById("store1").value = store;
}

// Modern utility functions
function showAlert(message, type) {
    var alertClass = 'alert-' + type;
    var iconClass = 'fas fa-info-circle';
    
    switch(type) {
        case 'success':
            iconClass = 'fas fa-check-circle';
            break;
        case 'error':
            iconClass = 'fas fa-exclamation-triangle';
            break;
        case 'warning':
            iconClass = 'fas fa-exclamation-circle';
            break;
    }
    
    var alertHtml = '<div class="alert ' + alertClass + '">' +
        '<i class="' + iconClass + ' alert-icon"></i>' +
        '<span>' + message + '</span>' +
        '</div>';
    
    $('#alertContainer').html(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}

function validateForm() {
    // Basic form validation
    var isValid = true;
    
    // Check if MRN is selected
    if ($('#po').val() === '') {
        showAlert('Please select an MRN number', 'error');
        isValid = false;
    }
    
    // Check if store is selected
    if ($('#store').val() === '') {
        showAlert('Please select a store', 'error');
        isValid = false;
    }
    
    return isValid;
}

function calculateTotals() {
    // Recalculate totals when inputs change
    var totalAmount = 0;
    
    $('input[name="totalamount[]"]').each(function() {
        var value = parseFloat($(this).val()) || 0;
        totalAmount += value;
    });
    
    $('#totalpurchaseamount').val(totalAmount.toFixed(2));
}

function refreshPage() {
    window.location.reload();
}

// Initialize on page load
window.onload = function() {
    funcOnLoadBodyFunctionCall();
};


