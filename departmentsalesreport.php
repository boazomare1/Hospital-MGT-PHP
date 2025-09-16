<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Sales Report - MedStar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/departmentsalesreport-modern.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <script src="js/autocomplete_accounts2.js"></script>
    <script src="js/autosuggest4accounts.js"></script>
    <script src="js/adddate.js"></script>
    <script src="js/adddate2.js"></script>
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
</head>
<body>

<?php
error_reporting(0);
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$total = '0.00';
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$grandtotal = 0;

$res10username="";
$res5labusername="";

//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_account2.php");
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchsuppliername = $_POST['searchsuppliername'];
	if ($searchsuppliername != '')
	{
		$arraysupplier = explode("#", $searchsuppliername);
		$arraysuppliername = $arraysupplier[0];
		$arraysuppliername = trim($arraysuppliername);
		//$arraysuppliercode = $arraysupplier[1];
		
		//$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
		//$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		//$res1 = mysql_fetch_array($exec1);
		//$supplieranum = $res1['auto_number'];
		//$openingbalance = $res1['openingbalance'];

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
	}
	else
	{
		//$cbsuppliername = $_REQUEST['cbsuppliername'];
		//$suppliername = $_REQUEST['cbsuppliername'];
	}

	//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];

}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if (isset($_REQUEST["department"])) { $search_department = $_REQUEST["department"]; } else { $search_department = ""; }

if (isset($_REQUEST["reporttype"])) { $reporttype = $_REQUEST["reporttype"]; } else { $reporttype = ""; }
//$billstatus = $_REQUEST['billstatus'];
//echo $ADate2;

if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}

?>
<!-- Modern Hospital Header -->
<header class="hospital-header">
    <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
    <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
</header>

<!-- User Info Bar -->
<div class="user-info-bar">
    <div class="user-welcome">
        <span class="welcome-text">Welcome, <?php echo htmlspecialchars($username); ?></span>
        <span class="location-info">Company: <?php echo htmlspecialchars($companyname); ?></span>
    </div>
    <div class="user-actions">
        <a href="logout.php" class="btn btn-outline btn-sm">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>

<!-- Navigation Breadcrumb -->
<nav class="nav-breadcrumb">
    <a href="index.php">🏠 Home</a>
    <span>→</span>
    <span>Department Sales Report</span>
</nav>

<!-- Floating Menu Toggle -->
<div class="floating-menu-toggle" id="menuToggle">
    <i class="fas fa-bars"></i>
</div>
<script type="text/javascript">


function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here



window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}


function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
	}
}

function paymententry1process1()
{
	//alert ("inside if");
	if (document.getElementById("paymentamount").value == "")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("paymentamount").focus();
		document.getElementById("paymentamount").value = "0.00"
		return false;
	}
	if (document.getElementById("paymentamount").value == "0.00")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("paymentamount").focus();
		document.getElementById("paymentamount").value = "0.00"
		return false;
	}
	if (isNaN(document.getElementById("paymentamount").value))
	{
		alert ("Payment Amount Can Only Be Numbers.");
		document.getElementById("paymentamount").focus();
		return false;
	}
	if (document.getElementById("paymentmode").value == "")
	{
		alert ("Please Select Payment Mode.");
		document.getElementById("paymentmode").focus();
		return false;
	}
	if (document.getElementById("paymentmode").value == "CHEQUE")
	{
		if(document.getElementById("chequenumber").value == "")
		{
			alert ("If Payment By Cheque, Then Cheque Number Cannot Be Empty.");
			document.getElementById("chequenumber").focus();
			return false;
		} 
		else if (document.getElementById("bankname").value == "")
		{
			alert ("If Payment By Cheque, Then Bank Name Cannot Be Empty.");
			document.getElementById("bankname").focus();
			return false;
		}
	}
	
	var fRet; 
	fRet = confirm('Are you sure want to save this payment entry?'); 
	//alert(fRet); 
	//alert(document.getElementById("paymentamount").value); 
	//alert(document.getElementById("pendingamounthidden").value); 
	if (fRet == true)
	{
		var varPaymentAmount = document.getElementById("paymentamount").value; 
		var varPaymentAmount = varPaymentAmount * 1;
		var varPendingAmount = document.getElementById("pendingamounthidden").value; 
		var varPendingAmount = parseInt(varPendingAmount);
		var varPendingAmount = varPendingAmount * 1;
		//alert (varPendingAmount);
		/*
		if (varPaymentAmount > varPendingAmount)
		{
			alert('Payment Amount Is Greater Than Pending Amount. Entry Cannot Be Saved.'); 
			alert ("Payment Entry Not Completed.");
			return false;
		}
		*/
	}
	if (fRet == false)
	{
		alert ("Payment Entry Not Completed.");
		return false;
	}
		
	//return false;
	
}

function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

</script>
<script>
function updatebox(varSerialNumber,billamt,totalcount1)
{

var adjamount1;
var grandtotaladjamt2=0;
var varSerialNumber = varSerialNumber;
var totalcount1=totalcount1;
var billamt = billamt;
  var textbox = document.getElementById("adjamount"+varSerialNumber+"");
    textbox.value = "";
if(document.getElementById("acknow"+varSerialNumber+"").checked == true)
{
    if(document.getElementById("acknow"+varSerialNumber+"").checked) {
        textbox.value = billamt;
    }
	var balanceamt=billamt-billamt;
	document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);
	var totalbillamt=document.getElementById("paymentamount").value;
	if(totalbillamt == 0.00)
{
totalbillamt=0;
}
				totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);
			
		
			//alert(totalbillamt);


document.getElementById("paymentamount").value = totalbillamt.toFixed(2);
document.getElementById("totaladjamt").value=totalbillamt.toFixed(2);
}
else
{
//alert(totalcount1);
for(j=1;j<=totalcount1;j++)
{
var totaladjamount2=document.getElementById("adjamount"+j+"").value;

if(totaladjamount2 == "")
{
totaladjamount2=0;
}
grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);
}
//alert(grandtotaladjamt);
document.getElementById("paymentamount").value = grandtotaladjamt2.toFixed(2);
document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);

 }  
}
function checkboxcheck(varSerialNumber5)
{

if(document.getElementById("acknow"+varSerialNumber5+"").checked == false)
{
alert("Please click on the Select check box");
return false;
}
return true;
}
function balancecalc(varSerialNumber1,billamt1,totalcount)
{
var varSerialNumber1 = varSerialNumber1;
var billamt1 = billamt1;
var totalcount=totalcount;
var grandtotaladjamt=0;

var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
var adjamount3=parseFloat(adjamount);
if(adjamount3 > billamt1)
{
alert("Please enter correct amount");
document.getElementById("adjamount"+varSerialNumber1+"").focus();
return false;
}
var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);

document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount.toFixed(2);
for(i=1;i<=totalcount;i++)
{
var totaladjamount=document.getElementById("adjamount"+i+"").value;
if(totaladjamount == "")
{
totaladjamount=0;
}
grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);

}

document.getElementById("paymentamount").value = grandtotaladjamt.toFixed(2);
document.getElementById("totaladjamt").value=grandtotaladjamt.toFixed(2);

}

</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<!-- Main Container with Sidebar -->
<div class="main-container-with-sidebar">
    <!-- Left Sidebar -->
    <div class="left-sidebar" id="leftSidebar">
        <div class="sidebar-header">
            <h3>Navigation</h3>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item active">
                    <a href="departmentsalesreport.php" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        Department Sales Report
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="reports.php" class="nav-link">
                        <i class="fas fa-file-alt"></i>
                        Reports
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Alert Container -->
        <div id="alertContainer">
            <?php if ($errmsg != ""): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <span><?php echo htmlspecialchars($errmsg); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h2>Department Sales Report</h2>
                <p>Generate comprehensive sales reports by department</p>
            </div>
            <div class="page-header-actions">
                <button type="button" class="btn btn-outline" onclick="printReport()">
                    <i class="fas fa-print"></i> Print
                </button>
                <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                    <i class="fas fa-file-excel"></i> Export
                </button>
                <button type="button" class="btn btn-outline" onclick="refreshPage()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>

        <!-- Search Form Container -->
        <div class="search-form-container">
		
		
            <form name="cbform1" method="post" action="departmentsalesreport.php" class="search-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="location" class="form-label">Location</label>
                        <select name="location" id="location" class="form-control" onChange="ajaxlocationfunction(this.value);">
                            <option value="All">All</option>
                            <?php
                            $query1 = "select locationname,locationcode from master_location order by auto_number desc";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $locationname = $res1["locationname"];
                                $locationcode = $res1["locationcode"];
                            ?>
                                <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="department" class="form-label">Department</label>
                        <select id="department" name="department" class="form-control">
                            <option value="">--Select Department--</option>
                            <?php
                            $result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT auto_number,department FROM master_department order by department asc ");
                            while($row = mysqli_fetch_array($result)){ ?>
                                <option value="<?=$row['auto_number'];?>" <?php if($search_department==$row['auto_number']) echo 'selected'; ?>><?=$row['department'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="reporttype" class="form-label">Report Type</label>
                        <select id="reporttype" name="reporttype" class="form-control">
                            <option value="summary" <?php if($reporttype=="summary") echo 'selected'; ?>>Summary</option>
                            <option value="detailed" <?php if($reporttype=="detailed") echo 'selected'; ?>>Detailed</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="ADate1" class="form-label">Date From</label>
                        <input name="ADate1" id="ADate1" value="<?php if($ADate2!=""){ echo $ADate1;}else{ echo $paymentreceiveddateto; } ?>" class="form-control" readonly="readonly" onKeyDown="return disableEnterKey()" />
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="ADate2" class="form-label">Date To</label>
                        <input name="ADate2" id="ADate2" value="<?php if($ADate2!=""){ echo $ADate2;}else{ echo $paymentreceiveddateto; } ?>" class="form-control" readonly="readonly" onKeyDown="return disableEnterKey()" />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">&nbsp;</label>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer" title="Select Date From"/>
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer" title="Select Date To"/>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <input type="hidden" name="searchsuppliername" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>">
                    <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>">
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <button type="submit" name="Submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <button type="reset" name="resetbutton" class="btn btn-outline" onclick="clearForm()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Table Container -->
        <div class="data-table-container">
            <?php
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            if ($cbfrmflag1 == 'cbfrmflag1') {
                if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
                if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
                if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
                if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
                $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
            }
            ?>
            
            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
                <div style="text-align: right; margin-bottom: 1rem;">
                    <a target="_blank" href="xl_departmentsalesreport.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&user=<?php echo $searchsuppliername; ?>&&department=<?php echo $search_department; ?>&&reporttype=<?=$reporttype?>" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>
            <?php endif; ?>

            <table class="modern-table">
                <thead>
                    <?php if($reporttype=="detailed"): ?>
                        <tr>
                            <th>No.</th>
                            <th>Visit No</th>
                            <th>Bill No</th>
                            <th>Bill Date</th>
                            <th>Reg No.</th>
                            <th>Member No.</th>
                            <th>Patient</th>
                            <th>Account Name</th>
                            <th>Subtype</th>
                            <th>Department</th>
                            <th>Payment Type</th>
                            <th>Consultation</th>
                            <th>Lab</th>
                            <th>Service</th>
                            <th>Pharmacy</th>
                            <th>Radiology</th>
                            <th>Referral</th>
                            <th>Total</th>
                            <th>Username</th>
                            <th>View</th>
                        </tr>
                    <?php elseif($reporttype=="summary"): ?>
                        <tr>
                            <th>No.</th>
                            <th>Department</th>
                            <th>Consultation</th>
                            <th>Lab</th>
                            <th>Service</th>
                            <th>Pharmacy</th>
                            <th>Radiology</th>
                            <th>Referral</th>
                            <th>Total</th>
                        </tr>
                    <?php endif; ?>
                </thead>
                <tbody>
			<?php
			$totallab = $totalser = $totalpharm = $totalrad = $totalref = $totalcons = 0;
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					
						
		if($locationcode1=='All')
		{
		$pass_location = "locationcode !=''";
		}
		else
		{
		$pass_location = "locationcode ='$locationcode1'";
		}
	
				
				
			  // $query21 = "SELECT accountname, billdate,billno from billing_paylater where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' UNION ALL SELECT accountname, billdate,billno from billing_paynow where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2'  order by billdate ";
			  // union all SELECT accountname,billdate,  billnumber as billno from billing_consultation where $pass_location  and billdate between '$ADate1' and '$ADate2'
			// $query21 = "select accountname,billno,billdate from billing_paylater where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by accountname order by accountname desc  ";
			// $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			// while ($res21 = mysql_fetch_array($exec21))
			// {
			//  $res21accountname = $res21['accountname'];
			//  $res21billno = $res21['billno'];
			
			// $query22 = "select * from master_accountname where $pass_location and accountname = '$res21accountname' and recordstatus <>'DELETED' ";
			// // $query22 = "select * from master_accountname where $pass_location and accountname = '$res21accountname' and recordstatus <>'DELETED' ";
			// $exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			// $res22 = mysql_fetch_array($exec22);
			// $res22accountname = $res22['accountname'];

			// if( $res21accountname != '')
			// {
			// ?>
			 <!-- <tr bgcolor="#ecf0f5">
   //          <td colspan="20"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res21accountname;?></strong></td>
   //          </tr> -->
			
			 <?php
			
			// $dotarray = explode("-", $paymentreceiveddateto);
			// $dotyear = $dotarray[0];
			// $dotmonth = $dotarray[1];
			// $dotday = $dotarray[2];
			// $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
			
		 //  $query1 = "select * from master_accountname where $pass_location and accountname = '$searchsuppliername'";
		 //  $exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
		 //  $res1 = mysql_fetch_array($exec1);
		 //  $res1auto_number = $res1['auto_number'];
		 //  $res1accountname = $res1['accountname'];
			///FOR GROUPING USE THIS QUERYY2
		   // $query2 = "SELECT accountname,patientcode,visitcode,billno,billdate,patientname,subtype from billing_paylater where $pass_location and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode,visitcode,billno,billdate,patientname,subtype from billing_paynow where $pass_location  and billdate between '$ADate1' and '$ADate2'   union all SELECT accountname,patientcode, patientvisitcode as visitcode,billnumber as billno,billdate,patientname, from billing_consultation where $pass_location  and billdate between '$ADate1' and '$ADate2'
		    // order by billdate";

			 if($reporttype=="detailed")
			 {
		     $query2 = "SELECT accountname,patientcode,visitcode,billno,billdate,patientname from billing_paylater where $pass_location and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode,visitcode,billno,billdate,patientname from billing_paynow where $pass_location  and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode, patientvisitcode as visitcode, billnumber as billno,billdate,patientname from billing_consultation where $pass_location  and billdate between '$ADate1' and '$ADate2' order by billdate";

		  // echo $query2 = "SELECT accountname,patientcode,visitcode,billno,billdate,patientname,subtype from billing_paylater where $pass_location and accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode,visitcode,billno,billdate,patientname,subtype from billing_paynow where $pass_location and accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2' order by billdate"; 
		  ////////////////
		  // $query2 = "select * from billing_paylater where $pass_location  and billdate between '$ADate1' and '$ADate2' order by accountname desc "; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2accountname = $res2['accountname'];
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billno = $res2['billno'];
		  $res2billdate = $res2['billdate'];
		  $res2patientname = $res2['patientname'];
		  // $accountid = $res2['accountnameid'];

		$query11 = "SELECT department from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						
						// echo $search_department.'c';
						// if($aut_department==$search_department )
				if(($aut_department==$search_department && $search_department!="") || ($search_department=="" && $aut_department!=""))
						{
						// 	echo $aut_department."a=";
						// echo $search_department."b-----";
		  $query11 = "SELECT subtype from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$subtype_num=$res11['subtype'];
		  // $subtype = $res2['subtype'];
				$query112 = "SELECT subtype from master_subtype where auto_number='$subtype_num'";
				$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res112 = mysqli_fetch_array($exec112);
				$subtype = $res112['subtype'];
		  //echo $res2paymenttype = $res2['paymenttype'];
		  $res5labitemrate1 = '0.00';
		  $res6servicesitemrate1 = '0.00';
		  $res7pharmacyitemrate1 = '0.00';
		  $res8radiologyitemrate1 = '0.00';
		  $res9referalitemrate1 = '0.00';
		  $res10consultationitemrate1 = '0.00';
		  
		  $query12 = "SELECT username from master_transactionpaylater where $pass_location and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and billnumber='$res2billno' and transactiontype='finalize' union all SELECT username from billing_paynow where $pass_location and billno = '$res2billno' union all SELECT  username from billing_consultation where $pass_location and billnumber = '$res2billno'";
          $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res12 = mysqli_fetch_array($exec12);
		  $res12username = $res12['username'];
		  
		 $query3 = "select planname,paymenttype,memberno from master_visitentry where $pass_location and visitcode = '$res2visitcode'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  $res3planname = $res3['planname'];
		  $res10paymenttype = $res3['paymenttype'];
		  $memberno = $res3['memberno'];
		  
		  $query11 = "select paymenttype from master_paymenttype where auto_number = '$res10paymenttype'";
		  $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res11 = mysqli_fetch_array($exec11);
		  $res11paymenttype = $res11['paymenttype'];
		  
		  $query4 = "select planname from master_planname where auto_number = '$res3planname'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $res4planname = $res4['planname'];

		  // $query50 = "select accountname, misreport from master_accountname where id = '$accountid'";
		  // $exec50 = mysql_query($query50) or die ("Error in Query50".mysql_error());
		  // $res50 = mysql_fetch_array($exec50);
		  // $res50accountname = $res50['accountname'];
		  // $misid = $res50['misreport'];

		  // $query51 = "select type from mis_types where auto_number = '$misid'";
		  // $exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
		  // $res51 = mysql_fetch_array($exec51);
		  // $mistype = $res51['type'];
		  
		  $query5 = "SELECT labitemrate, username from billing_paylaterlab where $pass_location and billnumber = '$res2billno' union all SELECT labitemrate, username from billing_paynowlab where $pass_location and billnumber = '$res2billno'";
		  // $query5 = "SELECT sum(labitemrate) as labitemrate, username from billing_paylaterlab where $pass_location and billnumber = '$res2billno' union all SELECT sum(labitemrate) as labitemrate, username from billing_paynowlab where $pass_location and billnumber = '$res2billno'";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res5 = mysqli_fetch_array($exec5))
		  {

		  // $res5labusername = $res5['username'];
		  $res5labitemrate = $res5['labitemrate'];
		  $res5labitemrate1 = $res5labitemrate1 + $res5labitemrate;
		  }
		  $res5labitemrate1 = number_format($res5labitemrate1,'2','.','');


		  // $res51labusername="";

		  // $query51 = "SELECT username from billing_paylaterlab where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_paylaterpharmacy where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_paylaterradiology where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_paylaterservices where $pass_location and billnumber = '$res2billno'
		  //  union all SELECT  username from billing_paynowlab where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_consultation where $pass_location and billnumber = '$res2billno'  ";
		  // $exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
		  // while ($res51 = mysql_fetch_array($exec51))
		  // {
		  // 	$res51labusername = $res51['username'];
		  // }

		  
		  $query6 = "SELECT  amount from billing_paylaterservices where $pass_location and billnumber = '$res2billno' union all SELECT  amount from billing_paynowservices where $pass_location  and billnumber = '$res2billno'";
		  // $query6 = "SELECT sum(amount) as amount from billing_paylaterservices where $pass_location and wellnessitem <> 1 and billnumber = '$res2billno' union all SELECT sum(amount) as amount from billing_paynowservices where $pass_location and wellnessitem <> 1 and billnumber = '$res2billno'";

		  
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res6 = mysqli_fetch_array($exec6))
		  {
		  $res6servicesitemrate = $res6['amount'];
		  $res6servicesitemrate1 = $res6servicesitemrate1 + $res6servicesitemrate;
		  }
		  $res6servicesitemrate1 = number_format($res6servicesitemrate1,'2','.','');
		  
		  $query7 = "SELECT amount from billing_paylaterpharmacy where $pass_location and billnumber = '$res2billno' union all SELECT amount from billing_paynowpharmacy where $pass_location and billnumber = '$res2billno'";
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res7 = mysqli_fetch_array($exec7))
		  {
		  $res7pharmacyitemrate = $res7['amount'];
		  $res7pharmacyitemrate1 = $res7pharmacyitemrate1 + $res7pharmacyitemrate;
		  }
		  $res7pharmacyitemrate1 = number_format($res7pharmacyitemrate1,'2','.','');
		  
		  $query8 = "SELECT radiologyitemrate  from billing_paylaterradiology where $pass_location and billnumber = '$res2billno' union all SELECT radiologyitemrate from billing_paynowradiology where $pass_location and billnumber = '$res2billno' ";
		  

		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res8 = mysqli_fetch_array($exec8))
		  {
		  $res8radiologyitemrate = $res8['radiologyitemrate'];
		  $res8radiologyitemrate1 = $res8radiologyitemrate1 + $res8radiologyitemrate;
		  }
		  $res8radiologyitemrate1 = number_format($res8radiologyitemrate1,'2','.','');
		  
		  $query9 = "SELECT referalrate from billing_paylaterreferal where $pass_location and billnumber = '$res2billno' union all SELECT referalrate from billing_paynowreferal where $pass_location and billnumber = '$res2billno'";

		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res9 = mysqli_fetch_array($exec9))
		  {
		  $res9referalitemrate = $res9['referalrate'];
		  $res9referalitemrate1 = $res9referalitemrate1 + $res9referalitemrate;
		  }
		  $res9referalitemrate1 = number_format($res9referalitemrate1,'2','.','');
		  
		  $query10 = "SELECT totalamount as totalamount from billing_paylaterconsultation where $pass_location and billno = '$res2billno' union all SELECT  consultation as totalamount from billing_consultation where $pass_location and billnumber = '$res2billno'  ";
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res10 = mysqli_fetch_array($exec10))
		  {

		  // $res10username = $res10['username'];
		  $res10consultationitemrate = $res10['totalamount'];
		  $res10consultationitemrate1 = $res10consultationitemrate1 + $res10consultationitemrate;
		  }
		  $res10consultationitemrate1 = number_format($res10consultationitemrate1,'2','.','');
		 
		  $total = $res5labitemrate1 + $res6servicesitemrate1 + $res7pharmacyitemrate1 + $res8radiologyitemrate1 + $res9referalitemrate1 + $res10consultationitemrate1;

		  $totallab += $res5labitemrate1;
		  $totalser += $res6servicesitemrate1;
		  $totalpharm += $res7pharmacyitemrate1;
		  $totalrad += $res8radiologyitemrate1;
		  $totalref += $res9referalitemrate1;
		  $totalcons += $res10consultationitemrate1;


		  $total = number_format($total,'2','.','');
		  $grandtotal = $grandtotal + $total;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
			?>
			  <?php if($reporttype=="detailed")
              { ?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $memberno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $subtype; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    // echo $mistype;

			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>


				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
            

			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res10consultationitemrate1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res5labitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res6servicesitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res7pharmacyitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res8radiologyitemrate1,2,'.',','); ?></div></td>

              

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res9referalitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo number_format($total,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php  echo strtoupper($res12username); ?></td>
              <!-- <td class="bodytext31" valign="center"  align="left"><?php //if($res5labusername!=""){echo strtoupper($res5labusername); }else{ echo strtoupper($res10username);} ?></td> -->
              
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_departmentsalesreport.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res2patientcode; ?>&&visitcode=<?php echo $res2visitcode; ?>&&billautonumber=<?php echo $res2billno; ?>"><strong>Summary</strong></a></td>
             <!-- <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
              
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><a target="_blank" href="departmentsalesreport_view_summary.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&user=<?php echo $searchsuppliername; ?>&&department=<?php echo $deptid; ?>&&reporttype=<?=$reporttype?>"><?php echo $res5deparmentname; ?> </a></div></td>-->
           </tr>
			<?php 
			  }
			}
			$res21accountname ='';
			
			// }
			
			}
			$res22accountname ='';
		}
	        }
// }
			
			// }

			?>

			 <?php if($reporttype=="detailed"){ ?>

            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><!--Total--></strong></div></td>

                  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalcons,2); ?></strong></div></td>


              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totallab,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalser,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalpharm,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalrad,2); ?></strong></div></td>

            

              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalref,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></td>
			  <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			  <?php if($grandtotal != 0.00) 
			      {
				  ?>
              <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="xl_departmentsalesreport.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&user=<?php echo $searchsuppliername; ?>&&department=<?php echo $search_department; ?>&&reporttype=<?=$reporttype?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
            <?php } ?>

        <?php } ?>

              <?php


              if($reporttype=="summary")
              {
              	$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

			  // $query21 = "SELECT accountname, billdate,billno from billing_paylater where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' UNION ALL SELECT accountname, billdate,billno from billing_paynow where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2'  order by billdate ";
			  // union all SELECT accountname,billdate,  billnumber as billno from billing_consultation where $pass_location  and billdate between '$ADate1' and '$ADate2'
			// $query21 = "select accountname,billno,billdate from billing_paylater where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by accountname order by accountname desc  ";
			// $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			// while ($res21 = mysql_fetch_array($exec21))
			// {
			//  $res21accountname = $res21['accountname'];
			//  $res21billno = $res21['billno'];
			
			// $query22 = "select * from master_accountname where $pass_location and accountname = '$res21accountname' and recordstatus <>'DELETED' ";
			// // $query22 = "select * from master_accountname where $pass_location and accountname = '$res21accountname' and recordstatus <>'DELETED' ";
			// $exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			// $res22 = mysql_fetch_array($exec22);
			// $res22accountname = $res22['accountname'];

			// if( $res21accountname != '')
			// {
			// ?>
			 <!-- <tr bgcolor="#ecf0f5">
   //          <td colspan="20"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res21accountname;?></strong></td>
   //          </tr> -->
			
			 <?php


			$consgrand =0;
			// $dotarray = explode("-", $paymentreceiveddateto);
			// $dotyear = $dotarray[0];
			// $dotmonth = $dotarray[1];
			// $dotday = $dotarray[2];
			// $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
			
		 //  $query1 = "select * from master_accountname where $pass_location and accountname = '$searchsuppliername'";
		 //  $exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
		 //  $res1 = mysql_fetch_array($exec1);
		 //  $res1auto_number = $res1['auto_number'];
		 //  $res1accountname = $res1['accountname'];
			///FOR GROUPING USE THIS QUERYY2
		   // $query2 = "SELECT accountname,patientcode,visitcode,billno,billdate,patientname,subtype from billing_paylater where $pass_location and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode,visitcode,billno,billdate,patientname,subtype from billing_paynow where $pass_location  and billdate between '$ADate1' and '$ADate2'   union all SELECT accountname,patientcode, patientvisitcode as visitcode,billnumber as billno,billdate,patientname, from billing_consultation where $pass_location  and billdate between '$ADate1' and '$ADate2'
		    // order by billdate";
		     $query2 = "SELECT accountname,patientcode,visitcode,billno,billdate,patientname from billing_paylater where $pass_location and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode,visitcode,billno,billdate,patientname from billing_paynow where $pass_location  and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode, patientvisitcode as visitcode, billnumber as billno,billdate,patientname from billing_consultation where $pass_location  and billdate between '$ADate1' and '$ADate2' order by billdate";

		  // echo $query2 = "SELECT accountname,patientcode,visitcode,billno,billdate,patientname,subtype from billing_paylater where $pass_location and accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode,visitcode,billno,billdate,patientname,subtype from billing_paynow where $pass_location and accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2' order by billdate"; 
		  ////////////////
		  // $query2 = "select * from billing_paylater where $pass_location  and billdate between '$ADate1' and '$ADate2' order by accountname desc "; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2accountname = $res2['accountname'];
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billno = $res2['billno'];
		  $res2billdate = $res2['billdate'];
		  $res2patientname = $res2['patientname'];
		  // $accountid = $res2['accountnameid'];

		$query11 = "SELECT department from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						
						// echo $search_department.'c';
						// if($aut_department==$search_department )
				if(($aut_department==$search_department && $search_department!="") || ($search_department=="" && $aut_department!=""))
						{
						// 	echo $aut_department."a=";
						// echo $search_department."b-----";
		 
		  // $subtype = $res2['subtype'];
				
		  //echo $res2paymenttype = $res2['paymenttype'];
		  $res5labitemrate1 = '0.00';
		  $res6servicesitemrate1 = '0.00';
		  $res7pharmacyitemrate1 = '0.00';
		  $res8radiologyitemrate1 = '0.00';
		  $res9referalitemrate1 = '0.00';
		  $res10consultationitemrate1 = '0.00';
		  
		  
		  
		
		  
		

		  // $query50 = "select accountname, misreport from master_accountname where id = '$accountid'";
		  // $exec50 = mysql_query($query50) or die ("Error in Query50".mysql_error());
		  // $res50 = mysql_fetch_array($exec50);
		  // $res50accountname = $res50['accountname'];
		  // $misid = $res50['misreport'];

		  // $query51 = "select type from mis_types where auto_number = '$misid'";
		  // $exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
		  // $res51 = mysql_fetch_array($exec51);
		  // $mistype = $res51['type'];
		  
		  $query5 = "SELECT labitemrate, username from billing_paylaterlab where $pass_location and billnumber = '$res2billno' union all SELECT labitemrate, username from billing_paynowlab where $pass_location and billnumber = '$res2billno'";
		  // $query5 = "SELECT sum(labitemrate) as labitemrate, username from billing_paylaterlab where $pass_location and billnumber = '$res2billno' union all SELECT sum(labitemrate) as labitemrate, username from billing_paynowlab where $pass_location and billnumber = '$res2billno'";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res5 = mysqli_fetch_array($exec5))
		  {

		  // $res5labusername = $res5['username'];
		  $res5labitemrate = $res5['labitemrate'];
		  $res5labitemrate1 = $res5labitemrate1 + $res5labitemrate;
		  }
		  $res5labitemrate1 = number_format($res5labitemrate1,'2','.','');


		  // $res51labusername="";

		  // $query51 = "SELECT username from billing_paylaterlab where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_paylaterpharmacy where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_paylaterradiology where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_paylaterservices where $pass_location and billnumber = '$res2billno'
		  //  union all SELECT  username from billing_paynowlab where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_consultation where $pass_location and billnumber = '$res2billno'  ";
		  // $exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
		  // while ($res51 = mysql_fetch_array($exec51))
		  // {
		  // 	$res51labusername = $res51['username'];
		  // }

		  
		  $query6 = "SELECT  amount from billing_paylaterservices where $pass_location and billnumber = '$res2billno' union all SELECT  amount from billing_paynowservices where $pass_location  and billnumber = '$res2billno'";
		  // $query6 = "SELECT sum(amount) as amount from billing_paylaterservices where $pass_location and wellnessitem <> 1 and billnumber = '$res2billno' union all SELECT sum(amount) as amount from billing_paynowservices where $pass_location and wellnessitem <> 1 and billnumber = '$res2billno'";

		  
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res6 = mysqli_fetch_array($exec6))
		  {
		  $res6servicesitemrate = $res6['amount'];
		  $res6servicesitemrate1 = $res6servicesitemrate1 + $res6servicesitemrate;
		  }
		  $res6servicesitemrate1 = number_format($res6servicesitemrate1,'2','.','');
		  
		  $query7 = "SELECT amount from billing_paylaterpharmacy where $pass_location and billnumber = '$res2billno' union all SELECT amount from billing_paynowpharmacy where $pass_location and billnumber = '$res2billno'";
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res7 = mysqli_fetch_array($exec7))
		  {
		  $res7pharmacyitemrate = $res7['amount'];
		  $res7pharmacyitemrate1 = $res7pharmacyitemrate1 + $res7pharmacyitemrate;
		  }
		  $res7pharmacyitemrate1 = number_format($res7pharmacyitemrate1,'2','.','');
		  
		  $query8 = "SELECT radiologyitemrate  from billing_paylaterradiology where $pass_location and billnumber = '$res2billno' union all SELECT radiologyitemrate from billing_paynowradiology where $pass_location and billnumber = '$res2billno' ";
		  

		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res8 = mysqli_fetch_array($exec8))
		  {
		  $res8radiologyitemrate = $res8['radiologyitemrate'];
		  $res8radiologyitemrate1 = $res8radiologyitemrate1 + $res8radiologyitemrate;
		  }
		  $res8radiologyitemrate1 = number_format($res8radiologyitemrate1,'2','.','');
		  
		  $query9 = "SELECT referalrate from billing_paylaterreferal where $pass_location and billnumber = '$res2billno' union all SELECT referalrate from billing_paynowreferal where $pass_location and billnumber = '$res2billno'";

		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res9 = mysqli_fetch_array($exec9))
		  {
		  $res9referalitemrate = $res9['referalrate'];
		  $res9referalitemrate1 = $res9referalitemrate1 + $res9referalitemrate;
		  }
		  $res9referalitemrate1 = number_format($res9referalitemrate1,'2','.','');
		  
		  $query10 = "SELECT totalamount as totalamount from billing_paylaterconsultation where $pass_location and billno = '$res2billno' union all SELECT  consultation as totalamount from billing_consultation where $pass_location and billnumber = '$res2billno'  ";
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res10 = mysqli_fetch_array($exec10))
		  {

		  // $res10username = $res10['username'];
		  $res10consultationitemrate = $res10['totalamount'];
		  $res10consultationitemrate1 = $res10consultationitemrate1 + $res10consultationitemrate;
		  }
		  $res10consultationitemrate1 = number_format($res10consultationitemrate1,'2','.','');
		 
		  $total = $res5labitemrate1 + $res6servicesitemrate1 + $res7pharmacyitemrate1 + $res8radiologyitemrate1 + $res9referalitemrate1 + $res10consultationitemrate1;

		  $totallab += $res5labitemrate1;
		  $totalser += $res6servicesitemrate1;
		  $totalpharm += $res7pharmacyitemrate1;
		  $totalrad += $res8radiologyitemrate1;
		  $totalref += $res9referalitemrate1;
		  $totalcons += $res10consultationitemrate1;




		  $total = number_format($total,'2','.','');
		  $grandtotal = $grandtotal + $total;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
			
	
			?>
        
			<?php 

		

				$cons[$aut_department][] = $res10consultationitemrate1;
				$lab[$aut_department][] = $res5labitemrate1;

				$ser[$aut_department][] = $res6servicesitemrate1;
				$pharm[$aut_department][] = $res7pharmacyitemrate1;
				$rad[$aut_department][] = $res8radiologyitemrate1;
				$ref[$aut_department][] = $res9referalitemrate1;



			}
			$res21accountname ='';
			
			// }
			
			}

			$conamtt = 0;
			
			foreach ($cons as $key => $value) {
				
				foreach ($value as $k => $v) {
					
					$conamtt = $conamtt + $v;
				}
				
				$consultation[$key] = $conamtt;
				$conamtt = 0;
			}
			$labamtt = 0;
			foreach ($lab as $key => $value) {
				
				foreach ($value as $k => $v) {
					
					$labamtt = $labamtt + $v;
				}
				
				$labarotory[$key] = $labamtt;
				$labamtt = 0;
			}
			$seramtt = 0;
			foreach ($ser as $key => $value) {
				
				foreach ($value as $k => $v) {
					
					$seramtt = $seramtt + $v;
				}
			
				$service[$key] = $seramtt;
				$seramtt = 0;
			}
			$pharmamtt = 0;
			foreach ($pharm as $key => $value) {
				
				foreach ($value as $k => $v) {
					
					$pharmamtt = $pharmamtt + $v;
				}
				
				$pharmacy[$key] = $pharmamtt;
				$pharmamtt = 0;
			}
			$radamtt = 0;
			foreach ($rad as $key => $value) {
				
				foreach ($value as $k => $v) {
					
					$radamtt = $radamtt + $v;
				}
				
				$radiology[$key] = $radamtt;
				$radamtt = 0;
			}

			$refamtt = 0;
			foreach ($ref as $key => $value) {
				
				foreach ($value as $k => $v) {
					
					$refamtt = $refamtt + $v;
				}
				
				$referral[$key] = $refamtt;
				$refamtt = 0;
			}
			
		
			$res22accountname ='';
			
			$snocount = 0;

			foreach ($consultation as $key => $consultamt) 

			{ 

				$snocount = $snocount +1;


				$deptid = $key;

				//echo $deptid.'--'.$consamt_arr[$deptid].'<br>';

				  $query5 = "select department from master_department where auto_number = '$deptid'";

		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res5 = mysqli_fetch_array($exec5);

		  $res5deparmentname = $res5['department'];

		

		  $finallinetot = $consultamt + $labarotory[$deptid] + $service[$deptid] + $pharmacy[$deptid] +$radiology[$deptid]+$referral[$deptid];
		  $consgrand = $consgrand + $consultamt ; 

		 $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}

				?>
 
				 <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              
                      
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5deparmentname; ?></td>

             
              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($consultamt,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($labarotory[$deptid],2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($service[$deptid],2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($pharmacy[$deptid],2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($radiology[$deptid],2,'.',','); ?></div></td>

                 <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($referral[$deptid],2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($finallinetot,2,'.',','); ?></div></td>

             

           </tr> 
			<?php }
			?>


			

            <tr>
             
				
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><!--Total--></strong></div></td>

                  <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><!--Total--></strong></div></td>

                  <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($totalcons,2); ?></strong></div></td>


              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($totallab,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($totalser,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($totalpharm,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($totalrad,2); ?></strong></div></td>

            

              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($totalref,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></td>
			  <td align="right" valign="center"  class="bodytext31">&nbsp;</td>
			 

       
            
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modern JavaScript -->
<script src="js/departmentsalesreport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
