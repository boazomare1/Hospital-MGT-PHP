// Edit Entries Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeSidebar();
    initializeFormValidation();
    initializeAlerts();
    initializeDataTable();
});

// Sidebar functionality
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('leftSidebar');
    const mainContainer = document.querySelector('.main-container-with-sidebar');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                mainContainer.classList.add('sidebar-collapsed');
            }
        }
    });
}

// Form validation
function initializeFormValidation() {
    const form = document.getElementById('form1');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }
}

function validateForm() {
    const entryid = document.getElementById('entryid');
    const entrydate = document.getElementById('entrydate');
    const location = document.getElementById('location');

    if (!entryid || !entryid.value.trim()) {
        showAlert('Please enter an Entry ID', 'error');
        if (entryid) entryid.focus();
        return false;
    }

    if (!entrydate || !entrydate.value.trim()) {
        showAlert('Please select an Entry Date', 'error');
        if (entrydate) entrydate.focus();
        return false;
    }

    if (!location || !location.value.trim()) {
        showAlert('Please select a Location', 'error');
        if (location) location.focus();
        return false;
    }

    return true;
}

// Alert system
function initializeAlerts() {
    // Auto-hide alerts after 5 seconds
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

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;

    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    
    const icon = getAlertIcon(type);
    alert.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; margin-left: auto; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
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

function getAlertIcon(type) {
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    return icons[type] || icons.info;
}

// Data table functionality
function initializeDataTable() {
    // Add any data table specific initialization here
    console.log('Data table initialized');
}

// Utility functions
function refreshData() {
    showAlert('Refreshing data...', 'info');
    location.reload();
}

function goToPage(page) {
    const url = new URL(window.location);
    url.searchParams.set('page', page);
    window.location.href = url.toString();
}

function nextPage() {
    const currentPage = getCurrentPage();
    const totalPages = getTotalPages();
    if (currentPage < totalPages) {
        goToPage(currentPage + 1);
    }
}

function previousPage() {
    const currentPage = getCurrentPage();
    if (currentPage > 1) {
        goToPage(currentPage - 1);
    }
}

function getCurrentPage() {
    const urlParams = new URLSearchParams(window.location.search);
    return parseInt(urlParams.get('page')) || 1;
}

function getTotalPages() {
    // This would need to be passed from PHP or calculated
    // For now, we'll use a simple approach
    return 1; // This should be updated based on actual data
}

// Original functions from the legacy code
function entries() {
    //alert ("Inside Funtion");
    if (document.form1.ledger1.value == "") {
        alert ("Please Select Ledger.");
        document.form1.ledger1.focus();
        return false;
    }
    if (document.form1.ledgerno1.value == "") {
        alert ("Please Select Ledger Properly.");
        document.form1.ledger1.focus();
        document.getElementById("ledger1").value = "";
        document.getElementById("ledgerno1").value = "";
        return false;
    }
    if (isNaN(document.form1.amount1.value == "")) {
        alert ("Please Enter Amount.");
        document.form1.amount1.focus();
        return false;
    }
    if (document.form1.amount1.value == "") {
        alert ("Please Enter Amount.");
        document.form1.amount1.focus();
        return false;
    }
    
    var TotalCreditAmt = 0.00;
    var TotalDebitAmt = 0.00;
    
    var Flg = "false";
    for(var i=1;i<=50;i++) {
        if(document.getElementById("entrytype"+i)!=null) {	
            var Flg = "false";
            
            if(document.getElementById("ledger"+i).value == "") {
                alert("Please Select Ledger");
                document.getElementById("ledger"+i).focus();
                document.getElementById("ledgerno"+i).value = "";
                return false;
            }
            if(document.getElementById("ledgerno"+i).value == "") {
                alert("Please Select Ledger Properly!");
                document.getElementById("ledger"+i).value = "";
                document.getElementById("ledgerno"+i).value = "";
                document.getElementById("ledger"+i).focus();
                return false;
            }
            
            if(document.getElementById("entrytype"+i).value == "Cr") {
                var CreditAmt = document.getElementById("amount"+i).value;
                CreditAmt=CreditAmt.replace(/,/g,'');
                TotalCreditAmt = parseFloat(TotalCreditAmt) + parseFloat(CreditAmt);
            } else {
                var DebitAmt = document.getElementById("amount"+i).value;
                DebitAmt=DebitAmt.replace(/,/g,'');
                TotalDebitAmt = parseFloat(TotalDebitAmt) + parseFloat(DebitAmt);
            }
        }
        var flag = validate_costcenter(i);
        if(flag === false) {
            return false;
        }
    }
    
    var TotalDiff = parseFloat(TotalCreditAmt) - parseFloat(TotalDebitAmt);
    TotalDiff = Math.abs(TotalDiff);
    if(TotalDiff > 0) {
        alert("Sum of Credit and Debit Mismatch");
        return false;		
    }
    
    var sno = document.getElementById("serialnumber").value;
    var rno = parseFloat(sno) - 1;
    var TotalCreditAmt = 0.00;
    var TotalDebitAmt = 0.00;
    
    var Tef = confirm("Are you Sure to Submit ?");	
    
    if(Tef == false) {
        return false;
    }	
}

function btnDeleteClickindustry(id) {
    var id = id;
    var newtotal3;
    var varDeleteID1 = id;
    var fRet4; 
    fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
    if (fRet4 == false) {
        return false;
    }
    
    var limt = parseFloat(varDeleteID1) + 10;
    for(var i=varDeleteID1;i<=limt;i++) {	
        var child1 = document.getElementById('insertrow'+i);
        var child2 = document.getElementById('tblref'+i);
        var parent1 = document.getElementById('maintableledger');
        if (child1 != null) {
            document.getElementById ('maintableledger').removeChild(child1);
            document.getElementById ('maintableledger').removeChild(child2);
        }
    }	
    
    document.getElementById("serialnumber").value = parseFloat(varDeleteID1);
    totend();
}

function numbervaild(key) {
    var keycode = (key.which) ? key.which : key.keyCode;
    if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111)) {
        return false;
    }
}

function Dis(sno) {	
    if($('#billwise'+sno).val() == "Yes") {
        document.getElementById("selectact"+sno).style.display = "";
    }
}

function Dissub(rid,sid) {
    $("#refamount"+rid+sid).focus(function(){
        $("#refaction"+rid+sid).show();
    });
    
    $("#refaction"+rid+sid).blur(function(){
        $("#refaction"+rid+sid).hide();
    });
}

function Buildledgers(id) {	
    $('.clientglaccountsc').autocomplete({
        source:"ajaxentriesvoucherledger.php",
        minLength:0,
        html: true, 
        select: function(event,ui){
            var code = ui.item.id;
            var billwise = ui.item.billwise;
            var ledger_groupid = ui.item.ledgergroupid;
            if(code != '') {
                var textid = $(this).attr('id');
                var res = textid.split("ledger");
                var textid1 = res[0];
                var ressno = res[1];
                
                var current_ledgerid = $(this).attr("id");
                var ledgerres = current_ledgerid.split("ledger");
                var current_id = ledgerres[1];
                var sno = $('#serialnumber').val();
                var rno = current_id;
                $("#ledgerno"+ressno).val(code);
                
                $.ajax({
                    url: 'ajax/getcostcenters.php',
                    type: 'GET',
                    dataType: 'json',
                    data: { 
                        group_id: ledger_groupid,
                        ref_no:rno
                    },   
                    success: function (data) { 
                        console.log(data.msg);
                        console.log(data.status);
                        console.log('rno'+rno)
                        var response_data = data.msg;
                        if(response_data !="") {
                            $('#showhide').show();
                            $('#costcenter_tdcontent'+rno).html('');
                            $('#costcenter_tdcontent'+rno).html(response_data);
                        } else {
                            $('#costcenter_tdcontent'+rno).html('');
                            var costcenter_entries = 0;
                            var costcenter_cnt = sno;
                            for(i=1;i<=costcenter_cnt;i++) {
                                if($("#costcenter"+i).is(":visible")){
                                    costcenter_entries = parseInt(costcenter_entries) + 1;
                                }
                            }
                            console.log(costcenter_entries);
                            if(parseInt(costcenter_entries)  == 0) {
                                $('#costcenter_tdcontent'+rno).html('');
                            }
                            showemptycenter();
                        }
                    }
                });
            }
        },
    });
}	

function showemptycenter() {
    var sno = $('#serialnumber').val();
    var costcenter_entries = 0;
    var costcenter_cnt = sno;
    for(i=1;i<=costcenter_cnt;i++) {
        if($("#costcenter"+i).is(":visible")){
            costcenter_entries = parseInt(costcenter_entries) + 1;
        }
    }
    console.log(costcenter_entries);
    if(parseInt(costcenter_entries)  == 0) {
        console.log('show empty cost center')
    }
}

function validate_costcenter(sno) {
    var flag = true;
    if($("#costcenter"+sno).is(":visible")){
        if($("#costcenter"+sno).val() == "") {
            alert("Please select cost center");
            $("#costcenter"+sno).focus();
            flag = false;
        }
    } else{
        flag = true;
    }
    return flag;
}

function FillAmt(id) {	
    Buildledgers(id);
    
    var Amt = $('#amount'+id).val();
    if(Amt == '') { Amt = 0.00; }
    Amt=Amt.replace(/,/g,'');
    Amt = parseFloat(Amt).toFixed(2);
    Amt = Amt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    
    if($('#entrytype'+id).val() == "Cr") {
        $('#cramount'+id).val(Amt);
        $('#dramount'+id).val("");
    } else {
        $('#dramount'+id).val(Amt);
        $('#cramount'+id).val("");
    }
    
    totend();
}

function totend() {
    var lim = document.getElementById("serialnumber").value;
    var TotalCreditAmt = 0.00;
    var TotalDebitAmt = 0.00;
    for(var i=1;i<=lim;i++) {
        if(document.getElementById("entrytype"+i)!=null) {	
            if(document.getElementById("entrytype"+i).value == "Cr") {
                var CreditAmt = document.getElementById("amount"+i).value;
                if(CreditAmt == '') { CreditAmt = 0.00; }
                CreditAmt=CreditAmt.replace(/,/g,'');
                TotalCreditAmt = parseFloat(TotalCreditAmt) + parseFloat(CreditAmt);
            } else {
                var DebitAmt = document.getElementById("amount"+i).value;
                if(DebitAmt == '') { DebitAmt = 0.00; }
                DebitAmt=DebitAmt.replace(/,/g,'');
                TotalDebitAmt = parseFloat(TotalDebitAmt) + parseFloat(DebitAmt);
            }
        }
    }
    
    TotalCreditAmt = parseFloat(TotalCreditAmt).toFixed(2);
    TotalCreditAmt = TotalCreditAmt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    
    TotalDebitAmt = parseFloat(TotalDebitAmt).toFixed(2);
    TotalDebitAmt = TotalDebitAmt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    
    document.getElementById("totalcr").value = TotalCreditAmt;
    document.getElementById("totaldr").value = TotalDebitAmt;
}

function clicklocation() {
    var location=document.getElementById("location").value;
    if(location=='') {
        alert('Please Select Location');
        document.getElementById("location").focus();
        return false;
    }
}

function addcommas(id) {
    var totalbillamt = document.getElementById(id).value;
    if(totalbillamt!='') {
        totalbillamt=totalbillamt.replace(/,/g,'');
        totalbillamt = parseFloat(totalbillamt).toFixed(2);
        totalbillamt = totalbillamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        document.getElementById(id).value=totalbillamt;
    }
}

function isNumberDecimal(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (  (charCode < 48 || charCode > 57) && charCode != 46) {
        return false;
    }
    return true;
} 

function Ledgeractiondel(varCallFrom,docno) {
    var varCallFrom = varCallFrom;
    var docno = docno;
    var ledno = document.getElementById("ledgerno"+varCallFrom).value;
    window.open("popup_ledgeraction.php?callfrom="+varCallFrom+"&&docno="+docno+"&&ledno="+ledno,"Window2",'toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,width=750,height=350,left=100,top=100');
}

function ucFirstAllWords1( str,id,key) {
    var keycode = (key.which) ? key.which : key.keyCode; 
    var pieces = str.split(" ");
    for ( var i = 0; i < pieces.length; i++ ) {
        var j = pieces[i].charAt(0).toUpperCase();
        pieces[i] = j + pieces[i].substr(1);
    }
    var word = pieces.join(" ");
    document.getElementById(id).value=word;
} 

// Initialize date picker
$(function() {
    $('.from_date').datepicker({
        autoclose: true
    });
});

// Initialize autocomplete
$(document).ready(function($){
    Buildledgers('1');
});
