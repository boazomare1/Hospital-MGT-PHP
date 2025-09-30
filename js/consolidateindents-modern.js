// Modern JavaScript for Consolidate Indents Page

$(document).ready(function() {
    // Initialize page
    initializePage();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize autocomplete
    initializeAutocomplete();
    
    // Initialize dropdowns
    initializeDropdowns();
});

// Initialize page elements
function initializePage() {
    // Hide all dropdowns initially
    $("[id^='droupid']").hide(0);
    
    // Setup sidebar toggle
    setupSidebarToggle();
    
    // Setup menu toggle
    setupMenuToggle();
}

// Setup event listeners
function setupEventListeners() {
    // Form validation
    $('form[name="form1"]').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
    });
    
    // Auto-refresh functionality
    setupAutoRefresh();
    
    // Export functionality
    setupExportFunctionality();
}

// Setup sidebar toggle
function setupSidebarToggle() {
    $('#sidebarToggle').on('click', function() {
        $('#leftSidebar').toggleClass('collapsed');
        const icon = $(this).find('i');
        if ($('#leftSidebar').hasClass('collapsed')) {
            icon.removeClass('fa-chevron-left').addClass('fa-chevron-right');
        } else {
            icon.removeClass('fa-chevron-right').addClass('fa-chevron-left');
        }
    });
}

// Setup menu toggle
function setupMenuToggle() {
    $('#menuToggle').on('click', function() {
        $('#leftSidebar').toggleClass('collapsed');
        const icon = $(this).find('i');
        if ($('#leftSidebar').hasClass('collapsed')) {
            icon.removeClass('fa-bars').addClass('fa-times');
        } else {
            icon.removeClass('fa-times').addClass('fa-bars');
        }
    });
}

// Initialize autocomplete for supplier names
function initializeAutocomplete() {
    $('.suppliername').autocomplete({
        source: 'ajaxsuppliernewserach.php',
        minLength: 3,
        delay: 0,
        html: true,
        select: function(event, ui) {
            const supplier = this.id;
            const code = ui.item.id;
            const anum = ui.item.anum;
            const suppliername = supplier.split('suppliername');
            const suppliercode = suppliername[1];
            
            $('#suppliercode' + suppliercode).val(code);
            $('#supplieranum' + suppliercode).val(anum);
        }
    });
}

// Initialize dropdown functionality
function initializeDropdowns() {
    // Dropdown functionality is handled by the existing dropdown() function
    // This is just a placeholder for any additional initialization
}

// Dropdown function (existing functionality)
function dropdown(id, action) {
    if (action === 'down') {
        $("#droupid" + id).slideDown(300);
        $("#down" + id).hide(0);
        $("#up" + id).show();
    } else if (action === 'up') {
        $("#droupid" + id).slideUp(300);
        $("#up" + id).hide(0);
        $("#down" + id).show();
    }
}

// Form validation
function validcheck() {
    document.getElementById("savepo").disabled = true;
    
    let app = 0;
    let supp = 0;
    const count = $("[type='checkbox']").length;
    
    // Check for re-approval checkboxes
    for (let i = 0; i <= count / 2; i++) {
        if ($("#reapproval" + i).attr("checked")) {
            app = 1;
            if ($("#reapproval" + i).prop("disabled")) {
                $("#reapproval" + i).prop("disabled", false);
            }
        }
    }
    
    // Check for disabled select checkboxes
    for (let i = 0; i <= count / 2; i++) {
        if ($("#select" + i).prop("disabled")) {
            supp = 1;
        }
    }
    
    // Show appropriate confirmation message
    if (app && supp) {
        if (confirm("Alterations have been made on the indent. Indent will be sent to Finance for approval \n Do you want to proceed?") === false) {
            document.getElementById("savepo").disabled = false;
            return false;
        }
    } else if (supp) {
        if (confirm("Supplier Name Needs a update so the page refreshes & other selected P/O 's will be generated. \n Do you want to proceed?") === false) {
            document.getElementById("savepo").disabled = false;
            return false;
        }
    } else {
        if (confirm("Do you want to generate P/O?") === false) {
            document.getElementById("savepo").disabled = false;
            return false;
        }
    }
    
    return true;
}

// Validate form before submission
function validateForm() {
    // Check if at least one indent is selected
    const selectedIndents = $('input[name^="select"]:checked').length;
    if (selectedIndents === 0) {
        showAlert('Please select at least one indent to process.', 'error');
        return false;
    }
    
    // Check if all required supplier names are filled
    const emptySuppliers = $('.suppliername').filter(function() {
        return $(this).val().trim() === '';
    }).length;
    
    if (emptySuppliers > 0) {
        showAlert('Please fill in all supplier names before proceeding.', 'error');
        return false;
    }
    
    return true;
}

// Location change handler
function cbcustomername1() {
    document.cbform1.submit();
}

// Disable enter key function
function disableEnterKey(varPassed) {
    if (event.keyCode === 8) {
        event.keyCode = 0;
        return event.keyCode;
        return false;
    }
    
    let key;
    if (window.event) {
        key = window.event.keyCode; // IE
    } else {
        key = event.which; // Firefox
    }
    
    if (key === 13) { // if enter key press
        return false;
    } else {
        return true;
    }
}

// Load print page
function loadprintpage1(banum) {
    const banum = banum;
    window.open("print_bill1_op1.php?billautonumber=" + banum + "", "Window" + banum + "", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
}

// Total calculation function
function totalcalc(varserialnumber) {
    const varserialnumber = varserialnumber;
    const receivedqty = document.getElementById("receivedquantity" + varserialnumber + "").value;
    
    if (receivedqty !== '') {
        is_int(receivedqty, varserialnumber);
    }
    
    const balqty = document.getElementById("balqty" + varserialnumber + "").value;
    
    if (parseFloat(receivedqty) > parseFloat(balqty)) {
        alert("Received quantity is greater than Balance quantity. Please Enter Lesser quantity");
        document.getElementById("receivedquantity" + varserialnumber + "").value = 0;
        return false;
    }
    
    if (receivedqty !== '') {
        const packsize = document.getElementById("packsize" + varserialnumber + "").value;
        const packvalue = packsize.substring(0, packsize.length - 1);
        const totalqty = parseInt(receivedqty) * parseInt(packvalue);
        document.getElementById("totalquantity" + varserialnumber + "").value = totalqty;
    }
    
    return true;
}

// Integer validation
function is_int(value, varserialnumber8) {
    if ((parseFloat(value) === parseInt(value)) && !isNaN(value)) {
        return true;
    } else {
        alert("Quantity should be integer");
        document.getElementById("receivedquantity" + varserialnumber8 + "").value = 0;
        return false;
    }
}

// Total amount calculation
function totalamount(varserialnumber2, varserialnumber) {
    let grandtotaladjamt = 0;
    let grandtotalfxadjamt = 0;
    const varserialnumber2 = varserialnumber2;
    const totalcount = document.getElementById("numb12" + varserialnumber + "").value;
    const budgetamount = document.getElementById("budgetamount" + varserialnumber + "").value;
    let fxamount = document.getElementById("fxpkrate" + varserialnumber2 + "").value;
    const fxrate = document.getElementById("fxrate" + varserialnumber2 + "").value;
    
    if (fxamount === '') {
        fxamount = 0;
    }
    
    fxamount = fxamount.replace(/[^0-9\.]+/g, "");
    const receivedqty2 = document.getElementById("reqqty" + varserialnumber2 + "").value.replace(/[^0-9\.]+/g, "");
    let priceperpack2 = parseFloat(fxamount) / parseFloat(fxrate);
    priceperpack2 = priceperpack2.toFixed(2);
    
    if (priceperpack2 !== '' && receivedqty2 !== '') {
        const packsize1 = document.getElementById("package" + varserialnumber2 + "").value;
        const packvalue1 = packsize1.substring(0, packsize1.length - 1);
        let totalamount = parseFloat(receivedqty2) * parseFloat(priceperpack2);
        let totalfxamount = parseFloat(receivedqty2) * parseFloat(fxamount);
        
        totalamount = parseFloat(totalamount).toFixed(2);
        totalamount = totalamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        
        totalfxamount = parseFloat(totalfxamount).toFixed(2);
        totalfxamount = totalfxamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        
        document.getElementById("amount" + varserialnumber2 + "").value = totalamount;
        document.getElementById("fxamount" + varserialnumber2 + "").value = totalfxamount;
        
        const tot = parseFloat(receivedqty2) * parseFloat(packvalue1);
        const classamount = document.getElementsByClassName("amount" + varserialnumber + "");
        
        for (let i = 0; i < classamount.length; i++) {
            let totaladjamount = classamount[i].value;
            totaladjamount = totaladjamount.replace(/,/g, '');
            grandtotaladjamt = parseFloat(grandtotaladjamt) + parseFloat(totaladjamount);
        }
        
        grandtotaladjamt = parseFloat(grandtotaladjamt).toFixed(2);
        grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        document.getElementById("totalamount" + varserialnumber).value = grandtotaladjamt;
        
        priceperpack2 = priceperpack2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        document.getElementById("rate" + varserialnumber2 + "").value = priceperpack2;
        
        if (parseFloat(budgetamount) === parseFloat(grandtotaladjamt.replace(/[^0-9\.]+/g, ""))) {
            document.getElementById("select" + varserialnumber).disabled = false;
            document.getElementById("select" + varserialnumber).checked = true;
            document.getElementById("reapproval" + varserialnumber).disabled = true;
            document.getElementById("reapproval" + varserialnumber).checked = false;
            document.getElementById("reapprove").value = 0;
        } else {
            document.getElementById("select" + varserialnumber).disabled = true;
            document.getElementById("select" + varserialnumber).checked = false;
            document.getElementById("reapproval" + varserialnumber).disabled = true;
            document.getElementById("reapproval" + varserialnumber).checked = true;
            document.getElementById("reapprove").value = 1;
        }
    }
}

// Recheck function
function recheck(sno) {
    if (document.getElementById("reapproval" + sno).checked === true) {
        document.getElementById("select" + sno).disabled = true;
    } else {
        document.getElementById("select" + sno).disabled = false;
    }
}

// Checkbox select function
function checkboxselect(sno, id) {
    let nosupp = '0';
    let yessupp = '0';
    
    if (document.getElementById(id).checked === true) {
        document.getElementById("reapproval" + id.split('select')[1]).disabled = true;
        const classnames = document.getElementsByClassName(sno);
        
        for (let i = 0; i < classnames.length; i++) {
            const displayattr = classnames[i].value;
            if (displayattr === '') {
                nosupp = parseFloat(nosupp) + 1;
            } else {
                yessupp = parseFloat(yessupp) + 1;
            }
        }
        
        if (parseFloat(nosupp) > 0) {
            alert('Please Select Supplier Name For This PI');
            document.getElementById(id).checked = false;
            document.getElementById("reapproval" + id.split('select')[1]).disabled = false;
        }
    } else {
        document.getElementById("reapproval" + id.split('select')[1]).disabled = false;
    }
}

// Setup auto-refresh functionality
function setupAutoRefresh() {
    // Auto-refresh every 5 minutes if no user activity
    let lastActivity = Date.now();
    const refreshInterval = 5 * 60 * 1000; // 5 minutes
    
    $(document).on('mousemove keypress scroll', function() {
        lastActivity = Date.now();
    });
    
    setInterval(function() {
        if (Date.now() - lastActivity > refreshInterval) {
            location.reload();
        }
    }, 60000); // Check every minute
}

// Setup export functionality
function setupExportFunctionality() {
    // Export to Excel functionality
    window.exportToExcel = function() {
        const table = document.querySelector('.data-table');
        if (!table) {
            showAlert('No data to export.', 'error');
            return;
        }
        
        // Create a simple CSV export
        let csv = [];
        const rows = table.querySelectorAll('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const row = [];
            const cols = rows[i].querySelectorAll('td, th');
            
            for (let j = 0; j < cols.length; j++) {
                let cellText = cols[j].innerText || cols[j].textContent || '';
                cellText = cellText.replace(/"/g, '""');
                row.push('"' + cellText + '"');
            }
            
            csv.push(row.join(','));
        }
        
        const csvContent = csv.join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'consolidate_indents_' + new Date().toISOString().split('T')[0] + '.csv';
        a.click();
        window.URL.revokeObjectURL(url);
    };
}

// Refresh page function
function refreshPage() {
    location.reload();
}

// Show alert function
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertClass = type === 'error' ? 'alert-error' : 
                     type === 'success' ? 'alert-success' : 'alert-info';
    
    const iconClass = type === 'error' ? 'exclamation-triangle' : 
                     type === 'success' ? 'check-circle' : 'info-circle';
    
    const alertHtml = `
        <div class="alert ${alertClass}">
            <i class="fas fa-${iconClass} alert-icon"></i>
            <span>${message}</span>
        </div>
    `;
    
    alertContainer.innerHTML = alertHtml;
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        const alert = alertContainer.querySelector('.alert');
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }
    }, 5000);
}

// Utility functions
function formatCurrency(amount) {
    return parseFloat(amount).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}

function validateNumericInput(input) {
    const value = input.value.replace(/[^0-9\.]/g, '');
    input.value = value;
    return value;
}

// Initialize tooltips
function initializeTooltips() {
    $('[data-tooltip]').each(function() {
        const tooltip = $(this).attr('data-tooltip');
        $(this).attr('title', tooltip);
    });
}

// Initialize on page load
$(document).ready(function() {
    initializeTooltips();
});


