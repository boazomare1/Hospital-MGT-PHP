<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

//This include updatation takes too long to load for hunge items database.

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



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
    $itemname=$_REQUEST['itemname'];
	$itemcode=$_REQUEST['itemcode'];
$adjustmentdate=date('Y-m-d');
	foreach($_POST['batch'] as $key => $value)
		{
		$batchnumber=$_POST['batch'][$key];
		$addstock=$_POST['addstock'][$key];
		$minusstock=$_POST['minusstock'][$key];
		$query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";
	$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res40 = mysqli_fetch_array($exec40);
	$itemmrp = $res40['rateperunit'];
	
	$itemsubtotal = $itemmrp * $addstock;
	
		if($addstock != '')
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		}
		}
	header("location:stockadjustment.php");
	exit;
	
}

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

include ("autocompletebuild_customeripbilling.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Deposit Refund - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Date Picker Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    
    <!-- Autocomplete Scripts -->
    <?php include ("js/dropdownlistipbilling.php"); ?>
    <script type="text/javascript" src="js/autosuggestipbilling.js"></script>
    <script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>

<script language="javascript">

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




function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	//funcPopupOnLoad1();
}



</script>
<script type="text/javascript">


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


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function isNumberKey(evt, element) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57) && !(charCode == 46 || charCode == 8))
    return false;
  else {
    var len = $(element).val().length;
    var index = $(element).val().indexOf('.');
    if (index > 0 && charCode == 46) {
      return false;
    }
    if (index > 0) {
      var charAfterdot = (len + 1) - index;
      if (charAfterdot > 3) {
        return false;
      }
    }

  }
  return true;
}
function reqDepositrefund(patientCode,visitCode){
 var refund = document.getElementById("req_"+visitCode).value;
 document.getElementById("avl_"+visitCode).value;
 
 if(refund>0){
	if(parseFloat(document.getElementById("avl_"+visitCode).value) >= parseFloat(refund)) {
	refund=window.btoa('-'+refund);
	refund.replace(/=/g, '')
    window.open("depositrefundrequest.php?patientcode="+patientCode+"&visitcode="+visitCode+"&token="+refund+'',"_blank");
	document.getElementById("req_"+visitCode).value ='';
    return false;
	}else{
	 alert("Request deposit amount should be less than or equal to Available Deposit");
     document.getElementById("req_"+visitCode).value ='';
     return false;
	}
 }
 else
	{
	 alert("Please enter request deposit amount.");
	 return false;
	}
}
</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>



<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>IP Deposit Refund</span>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Alert Container -->
        <div id="alertContainer">
            <?php include ("includes/alertmessages1.php"); ?>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h2>IP Deposit Refund</h2>
                <p>Manage patient deposit refunds with comprehensive search and validation capabilities.</p>
            </div>
            <div class="page-header-actions">
                <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
                <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>

        <!-- Search Form Section -->
        <div class="form-section">
            <h3><i class="fas fa-search"></i> Patient Search & Location</h3>
            
            <form name="cbform1" method="post" action="ipdepositrefund.php">
                <div class="form-row">
                    <div class="form-group">
                        <label for="location">Location</label>
                        <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                            <?php
                            $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1))
                            {
                                $locationname = $res1["locationname"];
                                $locationcode = $res1["locationcode"];
                                ?>
                                <option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="customer">Patient Search</label>
                        <input name="customer" id="customer" type="text" placeholder="Enter patient name, code, or visit code" autocomplete="off">
                        <input name="customercode" id="customercode" value="" type="hidden">
                        <input type="hidden" name="recordstatus" id="recordstatus">
                        <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary" onClick="return funcvalidcheck();">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
            
            <!-- Current Location Display -->
            <div class="current-location">
                <strong>Current Location: </strong>
                <span id="ajaxlocation">
                    <?php
                    if ($location!='')
                    {
                        $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res12 = mysqli_fetch_array($exec12);
                        echo $res1location = $res12["locationname"];
                    }
                    else
                    {
                        $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res1 = mysqli_fetch_array($exec1);
                        echo $res1location = $res1["locationname"];
                    }
                    ?>
                </span>
            </div>
        </div>

        <!-- Results Section -->
        <div class="data-table-section">
            <div class="table-header">
                <h3><i class="fas fa-list"></i> Patient Deposit Information</h3>
                <div class="search-bar">
                    <input type="text" placeholder="Search patients..." id="patientSearch">
                    <i class="fas fa-search"></i>
                </div>
            </div>
            
            <form name="form11" id="form11" method="post" action="ipbilling.php">
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_POST['customer'];
	$searchlocation = $_POST['location'];
	
		
?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Patient Name</th>
                            <th>Reg No</th>
                            <th>IP Visit</th>
                            <th>Total Deposits</th>
                            <th>Deposit Refunds</th>
                            <th>Available Deposit</th>
                            <th>Req. Deposit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
           <?php
		  
		  if($searchpatient != '')
		  { 
           $query34 = "select * from ip_bedallocation where locationcode='$searchlocation' and patientname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%'";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $paymentstatus = $res34['paymentstatus'];
		   $creditapprovalstatus = $res34['creditapprovalstatus'];
		  
		   $query71 = "select * from ip_discharge where locationcode='$searchlocation' and visitcode='$visitcode'";
		   $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num71 = mysqli_num_rows($exec71);
		   if($num71 == 0)
		   {
		   $status = 'Active';
		   }
		   else
		   {
		   $status = 'Discharged';
		   }
		   
		   $query82 = "select * from master_ipvisitentry where locationcode='$searchlocation' and patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res82 = mysqli_fetch_array($exec82);
		   $date = $res82['consultationdate'];
		   $accountname = $res82['accountfullname'];
		   $patientlocationcode = $res82['locationcode'];
		   $type = $res82['type'];
		   if($type=='hospital')
		   {
			$type='H';   
		   }
		   if($type=='private')
		   {
			$type='P';   
		   }

		   $deposits =0 ;
			$adv_deposits=0;
			$depositrefund= 0;
			$avilable_deposit = 0;
            $query112 = "select sum(transactionamount) as deposit from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode' and transactionmodule <> 'Adjustment'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res112 = mysqli_fetch_array($exec112);
			$deposits=$res112['deposit'];

			$query112 = "select sum(transactionamount) as deposit from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res112 = mysqli_fetch_array($exec112);
			$adv_deposits = $res112['deposit'];
			$total_deposit = $deposits + $adv_deposits;

			$query112 = "select sum(amount) as refund from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res112 = mysqli_fetch_array($exec112);
			$depositrefund = $res112['refund'];

			$avilable_deposit=$total_deposit-$depositrefund;
		 
		   if($paymentstatus == '' && $avilable_deposit>0)
		   {
		   $sno = $sno + 1;
		   ?>
			
            <tr>
              <td><?php echo $sno; ?></td>
			  <td><strong><?php echo htmlspecialchars($patientname); ?></strong></td>
			  <td><?php echo htmlspecialchars($patientcode); ?></td>
			  <td><?php echo htmlspecialchars($visitcode); ?></td>
			  <td class="number-cell currency"><?php echo number_format($total_deposit,2,'.',','); ?></td>
			  <td class="number-cell"><?php echo number_format($depositrefund,2,'.',','); ?></td>
			  <td class="number-cell currency"><?php echo number_format($avilable_deposit,2,'.',','); ?></td>
			  <td>
			    <input type="text" name="req_<?php echo $visitcode; ?>" id='req_<?php echo $visitcode; ?>' 
			           class="table-input" placeholder="0.00" onkeypress="return isNumberKey(event,this)">
			  </td>
			  <input type='hidden' name='avl_<?php echo $visitcode; ?>' id='avl_<?php echo $visitcode; ?>' value='<?php echo $avilable_deposit;?>'>
			  <td class="action-buttons">
			    <button type="button" class="btn-action btn-request" onclick='reqDepositrefund("<?php echo $patientcode; ?>","<?php echo $visitcode; ?>");return false;'>
			      <i class="fas fa-money-bill-wave"></i> Request
			    </button>
			  </td>
		  <?php
		  
		  }
		 }
		  }else
		  {
		 $query34 = "select * from ip_bedallocation where locationcode='$searchlocation' and paymentstatus = '' ";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		  
		   $query71 = "select * from ip_discharge where  locationcode='$searchlocation' and visitcode='$visitcode'";
		   $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num71 = mysqli_num_rows($exec71);
		   if($num71 == 0)
		   {
		   $status = 'Active';
		   }
		   else
		   {
		   $status = 'Discharged';
		   }
		   
		   $query82 = "select * from master_ipvisitentry where  locationcode='$searchlocation' and patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res82 = mysqli_fetch_array($exec82);
		   $date = $res82['consultationdate'];
		   $accountname = $res82['accountfullname'];
		   $type=$res82['type'];
		  if($type=='hospital')
		   {
			$type='H';   
		   }
		   if($type=='private')
		   {
			$type='P';   
		   }
            $deposits =0 ;
			$adv_deposits=0;
			$depositrefund= 0;
			$avilable_deposit = 0;
            $query112 = "select sum(transactionamount) as deposit from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode' and transactionmodule <> 'Adjustment'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res112 = mysqli_fetch_array($exec112);
			$deposits=$res112['deposit'];

			$query112 = "select sum(transactionamount) as deposit from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res112 = mysqli_fetch_array($exec112);
			$adv_deposits = $res112['deposit'];
			$total_deposit = $deposits + $adv_deposits;

			$query112 = "select sum(amount) as refund from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res112 = mysqli_fetch_array($exec112);
			$depositrefund = $res112['refund'];

			$avilable_deposit=$total_deposit-$depositrefund;
             if($avilable_deposit>0) {
	        $sno = $sno + 1;
			?>
			
          <tr>
              <td><?php echo $sno; ?></td>
			  <td><strong><?php echo htmlspecialchars($patientname); ?></strong></td>
			  <td><?php echo htmlspecialchars($patientcode); ?></td>
			  <td><?php echo htmlspecialchars($visitcode); ?></td>
			  <td class="number-cell currency"><?php echo number_format($total_deposit,2,'.',','); ?></td>
			  <td class="number-cell"><?php echo number_format($depositrefund,2,'.',','); ?></td>
			  <td class="number-cell currency"><?php echo number_format($avilable_deposit,2,'.',','); ?></td>
			  <td>
			    <input type="text" name="req_<?php echo $visitcode; ?>" id='req_<?php echo $visitcode; ?>' 
			           class="table-input" placeholder="0.00" onkeypress="return isNumberKey(event,this)">
			  </td>
			  <input type='hidden' name='avl_<?php echo $visitcode; ?>' id='avl_<?php echo $visitcode; ?>' value='<?php echo $avilable_deposit;?>'>
			  <td class="action-buttons">
			    <button type="button" class="btn-action btn-request" onclick='reqDepositrefund("<?php echo $patientcode; ?>","<?php echo $visitcode; ?>");return false;'>
			      <i class="fas fa-money-bill-wave"></i> Request
			    </button>
			  </td>
			  </tr>
		  <?php
			 }
		  }
		  }
           ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ipdepositrefund-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

