<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$res45transactionamount = 0;
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

// Date variables
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$ADate2 = date('Y-m-d');

// Array variables
$billnumbers = array();
$billnumbers1 = array();



$query01="select locationcode from login_locationdetails where username='$username' and docno='$docno'";

$exe01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);

$res01=mysqli_fetch_array($exe01);

 $locationcode=$res01['locationcode'];



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$snocount1 = 0;

//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_account2.php");



// Handle form parameters with modern isset() checks
$searchsuppliername = isset($_REQUEST["searchsuppliername"]) ? $_REQUEST["searchsuppliername"] : "";
$searchsuppliercode = isset($_REQUEST["searchsuppliercode"]) ? $_REQUEST["searchsuppliercode"] : "";
$ADate1 = isset($_REQUEST["ADate1"]) ? $_REQUEST["ADate1"] : date('Y-m-d');
$ADate2 = isset($_REQUEST["ADate2"]) ? $_REQUEST["ADate2"] : date('Y-m-d');
$range = isset($_REQUEST["range"]) ? $_REQUEST["range"] : "";
$amount = isset($_REQUEST["amount"]) ? $_REQUEST["amount"] : "";
$cbfrmflag2 = isset($_REQUEST["cbfrmflag2"]) ? $_REQUEST["cbfrmflag2"] : "";
$frmflag2 = isset($_REQUEST["frmflag2"]) ? $_REQUEST["frmflag2"] : "";

// Update date variables if form submitted
$paymentreceiveddatefrom = $ADate1;
$paymentreceiveddateto = $ADate2;



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Outstanding Report - MedStar Hospital Management</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Additional CSS -->
    <link href="autocomplete.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- JavaScript Files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    
    <style>
        th { background-color: #ffffff; position: sticky; top: 0; z-index: 1; }
        .ui-menu .ui-menu-item { zoom: 1 !important; }
        .bal { border-style: none; background: none; text-align: right; }
        .bali { text-align: right; }
    </style>
</head>
<body>
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
        <span>Reports</span>
        <span>→</span>
        <span>Doctor Outstanding Report</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="doctoroutstanding.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="masterdata.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Master Data</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Doctor Outstanding Report</h2>
                    <p>Generate comprehensive reports on doctor outstanding amounts, payments, and aging analysis.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export
                    </button>
                </div>
            </div>

<script>

function funcAccount()

{

if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))

{

alert('Please Select Doctor');

return false;

}

}

function loadprintpagepdf2(billnumber,doctorcode)

{


		window.open("print_doctorstmtbill.php?billnumber="+billnumber+'&&doctorcode='+doctorcode,"Window",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');

}
$(document).ready(function($){

    $('#searchsuppliername').autocomplete({

		

	

	source:"ajaxdoctornewserach.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var code = ui.item.customercode;

			$("#searchsuppliercode").val(code);

			

			},

    });

});

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



<body>

            <!-- Search Form -->
            <form name="cbform1" method="post" action="doctoroutstanding.php" class="form-section">
                <div class="form-section-header">
                    <i class="fas fa-search form-section-icon"></i>
                    <h3 class="form-section-title">Search Criteria</h3>
                    <span class="form-section-subtitle">Enter search parameters to generate the outstanding report</span>
                </div>
                
                <div class="form-section-form">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Search Doctor</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" class="form-input" value="<?php echo $searchsuppliername; ?>" placeholder="Search for doctor" autocomplete="off" />
                            <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" />
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="form-input-group">
                                <input name="ADate1" id="ADate1" class="form-input" value="<?php echo $paymentreceiveddatefrom; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="form-input-group">
                                <input name="ADate2" id="ADate2" class="form-input" value="<?php echo $paymentreceiveddateto; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt" onClick="javascript:NewCssCal('ADate2','yyyyMMdd','','','','','past','07-01-2019','<?php echo date('m-d-Y');?>')" style="cursor:pointer"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="subcode" value="<?php echo $searchsuppliercode; ?>" />
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1" />
                        <button type="submit" onClick="return funcAccount();" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button name="resetbutton" type="reset" id="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>
            </form>

            <!-- Results Section -->
            <?php if(isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1'){ ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <h3 class="data-table-title">Doctor Outstanding Report Results</h3>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">No.</th>
                                <th class="table-header-cell">Date</th>
                                <th class="table-header-cell">Description</th>
                                <th class="table-header-cell">Bill Number</th>
                                <th class="table-header-cell">Bill Type</th>
                                <th class="table-header-cell">Company</th>
                                <th class="table-header-cell">Allotted</th>
                                <th class="table-header-cell text-right">Debit</th>
                                <th class="table-header-cell text-right">Credit</th>
                                <th class="table-header-cell text-right">Outstanding</th>
                                <th class="table-header-cell text-center">Days</th>
                                <th class="table-header-cell text-right">Current Balance</th>
                            </tr>
                        </thead>
                        <tbody>

              <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					//$transactiondatefrom = $_REQUEST['ADate1'];

					//$transactiondateto = $_REQUEST['ADate2'];

					

					//$paymenttype = $_REQUEST['paymenttype'];

					//$billstatus = $_REQUEST['billstatus'];

					

					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";

				}

				else

				{

					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";

				}

				?>


              <script language="javascript">

				function printbillreport1()

				{

					window.open("print_paymentgivenreport1.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

				}

				function printbillreport2()

				{

					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"

				}

				</script>

              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />

&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->

</span></td>  

            </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></th>

              <th width="9%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></th>

              <th width="25%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></th>
                 <th width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill Number </strong></th>
                 <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill Type </strong></th>

				<th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Company </strong></th>

			<th width="5%" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>Allotted</strong></th>

             
              <th width="" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></th>

              <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit</strong></div></th>

                 <th width="5%" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Outstanding</strong></th>

				<th width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days</strong></div></th>


				<th width="" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Balance</strong></div></th>

            </tr>

			<?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

			if ($cbfrmflag1 == 'cbfrmflag1')

			{

				$openingcreditamount = 0;

				$openingdebittamount = 0;

/* 				$query81 = "select patientvisitcode,billnumber,referalrate from billing_paynowreferal  where referalname='$searchsuppliername' and  billdate < '$ADate1'";

				$exec81 = mysql_query($query81) or die(mysql_error());

 			  	$num81=mysql_num_rows($exec81);

				while($res81 = mysql_fetch_array($exec81))

				{

					$res81visitcode = $res81['patientvisitcode'];

					$paynowamount = $res81['referalrate'];

					$billnumber = $res81['billnumber'];

					

					$query81="select transactionamount from doctorsharing where billnumber = '$billnumber' and visitcode ='$res81visitcode' ";

					$exec81=mysql_query($query81) or die("Error in query81".mysql_error());

					$res81=mysql_fetch_array($exec81);

					$paynowamount = $res81['transactionamount'];

					

					$query5=mysql_query("select visitcode from billing_paynow where visitcode='$res81visitcode' and billstatus='paid'");

					$num05=mysql_num_rows($query5);

					if($num05 > 0)

					{

						array_push($billnumbers1, $res81['billnumber']);

						$openingcreditamount = $openingcreditamount + $paynowamount; 

					}

				}

			

				$query82 = "select patientvisitcode,billnumber,referalrate from billing_paylaterreferal  where referalname='$searchsuppliername' and   billdate < '$ADate1'";

				$exec82 = mysql_query($query82) or die(mysql_error());

				

				while($res82 = mysql_fetch_array($exec82))

				{

					$res82visitcode = $res82['patientvisitcode'];

					$paylateramount = $res82['referalrate'];

					$billnumber = $res81['billnumber'];

					

					$query82="select transactionamount from doctorsharing where billnumber = '$billnumber' and visitcode ='$res82visitcode' ";

					$exec82=mysql_query($query82) or die("Error in query82".mysql_error());

					$res82=mysql_fetch_array($exec82);

					$paylateramount = $res82['transactionamount'];

					

					$query5=mysql_query("select visitcode from billing_paylater where visitcode='$res82visitcode' and billstatus='paid'");

					$num05=mysql_num_rows($query5);

					if($num05 > 0)

					{

						array_push($billnumbers1, $res82['billnumber']);

						$openingcreditamount = $openingcreditamount + $paylateramount;

					}

				}

					

					



				$query234 = "select docno,sum(amount) as amount,visitcode from billing_ipprivatedoctor where description='$searchsuppliername' and amount <> '0.00' and amount > 0 and recorddate < '$ADate1'  and docno <> '' group by docno";

				$exec234 = mysql_query($query234) or die ("Error in Query234".mysql_error());

				$num50 = mysql_num_rows($exec234);

				

				while($res234 = mysql_fetch_array($exec234))

				{

					$visitcode1= $res234['visitcode'];

					$billnumber= $res234['docno'];

					$ipamount1= $res234['amount'];

					

					$query83="select sum(transactionamount) as transactionamount from doctorsharing where billnumber = '$billnumber' ";

					$exec83=mysql_query($query83) or die("Error in query83".mysql_error());

					$res83=mysql_fetch_array($exec82);

					$ipamount1 = $res83['transactionamount'];

					

					

					array_push($billnumbers1, $res234['docno']);

					$openingcreditamount = $openingcreditamount + $ipamount1;

					

				}

				

				

				$query833 = "select sum(totalamount) as amount1,billnumber,bill_autonumber from purchasereturn_details where suppliercode='$searchsuppliercode' and entrydate < '$ADate1' group by billnumber order by auto_number asc";

				$exec83 = mysql_query($query833) or die(mysql_error("error in query833"));

				while($query833 = mysql_fetch_array($exec83))

				{

					$ipamount = $query833['amount1'];

					$billnumber= $query833['billnumber'];

					$billanum= $query833['bill_autonumber'];

					

					$query84="select sum(transactionamount) as transactionamount from doctorsharing where billnumber = '$billnumber' ";

					$exec84=mysql_query($query84) or die("Error in query84".mysql_error());

					$res84=mysql_fetch_array($exec82);

					$ipamount = $res84['transactionamount'];

					

					$openingcreditamount = $openingcreditamount + $ipamount;

				}

					

				$totalbillnumbers1 = "'".implode("','", $billnumbers1)."'";

				if($totalbillnumbers1 =='')

				{

					$totalbillnumbers1 ="''";

				}

				//echo sizeof($billnumbers1)."first";

				

				$query50 = "select sum(transactionamount) as transactionamount,billnumber,visitcode from master_transactiondoctor where doctorcode = '$searchsuppliercode' and transactiondate < '$ADate1'  and recordstatus ='' and billnumber in ($totalbillnumbers1) group by docno order by transactiondate desc";

				

				$exec50 = mysql_query($query50) or die ("Error in Query5".mysql_error());

				$num50 = mysql_num_rows($exec50);

				while($res50 = mysql_fetch_array($exec50))

				{

					// echo $res5['docno']." && ".$res5['transactionamount']."<br>";

					$totaltransamount = $res50['transactionamount'];

					$billnumber= $res50['billnumber'];

					$visitcode= $res50['visitcode'];

					

					$query84="select sum(transactionamount) as transactionamount from doctorsharing where billnumber = '$billnumber' ";

					$exec84=mysql_query($query84) or die("Error in query84".mysql_error());

					$res84=mysql_fetch_array($exec82);

					$ipamount = $res84['transactionamount'];

					

					

					$openingdebittamount = $openingdebittamount + $totaltransamount;

				}

				

				$query5 = "select sum(transactionamount) as transactionamount,docno from doctortransaction_details where doctorcode = '$searchsuppliercode' and transactiondate < '$ADate1'  and recordstatus ='' and transactiontype='DEBIT' group by docno order by transactiondate desc";

				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());

				$num5 = mysql_num_rows($exec5);

				while($res5 = mysql_fetch_array($exec5))

				{

					

					$totaltransamount = $res5['transactionamount'];

					$billnumber= $res5['docno'];

					

					$query85="select sum(transactionamount) as transactionamount from doctorsharing where billnumber = '$billnumber' ";

					$exec85=mysql_query($query85) or die("Error in query85".mysql_error());

					$res85=mysql_fetch_array($exec82);

					$totaltransamount = $res85['transactionamount'];

					

					$openingdebittamount = $openingdebittamount + $totaltransamount;

				}

					

				$query51 = "select sum(transactionamount) as transactionamount,docno from doctortransaction_details where doctorcode = '$searchsuppliercode' and transactiondate < '$ADate1'  and recordstatus ='' and transactiontype='CREDIT' group by docno order by transactiondate desc";

				$exec51 = mysql_query($query51) or die ("Error in Query5".mysql_error());

				$num51 = mysql_num_rows($exec51);

				while($res51 = mysql_fetch_array($exec51))

				{

					

					$totaltransamount = $res51['transactionamount'];

					$billnumber= $res51['docno'];

					

					$query86="select sum(transactionamount) as transactionamount from doctorsharing where billnumber = '$billnumber' ";

					$exec86=mysql_query($query86) or die("Error in query86".mysql_error());

					$res86=mysql_fetch_array($exec86);

					$totaltransamount = $res86['transactionamount'];

					

					$openingcreditamount = $openingcreditamount + $totaltransamount;

				}

					//	echo   $openingdebittamount;

					//	echo '<br>'.$openingcreditamount;

					$openingbalance = $openingcreditamount - $openingdebittamount; */

					$openingbalance=0;

			// OB
					
					// $querycr1op = "SELECT SUM(`transactionamount`) as openingbalance  FROM `billing_ipprivatedoctor` WHERE doccoa='$searchsuppliercode'  AND `recorddate` <  '$ADate1' and visittype='OP' and amount <> '0.00' and amount > 0  and docno <> ''";
					// 	$execcr1 = mysql_query($querycr1op) or die ("Error in querycr1op".mysql_error());
					// 	$rescr1 = mysql_fetch_array($execcr1);
					// 	$openingbalance = $rescr1['openingbalance']; 

					// $querycr1ip = "SELECT SUM(`sharingamount`) as openingbalance1  FROM `billing_ipprivatedoctor` WHERE doccoa='$searchsuppliercode'  AND `recorddate` <  '$ADate1' and visittype='IP' and amount <> '0.00' and amount > 0  and docno <> ''";
					// 	$execcr12 = mysql_query($querycr1ip) or die ("Error in querycr1ip".mysql_error());
					// 	$rescr12 = mysql_fetch_array($execcr12);
					// 	$openingbalance1 = $rescr12['openingbalance1']; 

					// 	$openingbalance =$openingbalance +$openingbalance1;


					
					// if(is_null($openingbalance))
					// 	{
					// 		$openingbalance = 0;
					// 	}
					// 	else
					// 	{
					// 		$openingbalance = $openingbalance;
					// 	}
					
					// 	//echo '#'.$openingbalance_paid.'#';
					// 	//echo '#'.$openingbalance.'#';
					// $openingbalance_paid = 0;

					// $querycr1op1 = "SELECT SUM(`transactionamount`) as openingbalance  FROM `master_transactiondoctor` WHERE doctorcode='$searchsuppliercode'  AND `transactiondate` <  '$ADate1'";
					
					// $execcr11 = mysql_query($querycr1op1) or die ("Error in querycr1op1".mysql_error());
					// $rowcnt = mysql_num_rows($execcr11);
					
					// if($rowcnt)
					// {
					// 	$rescr11 = mysql_fetch_array($execcr11);
					// 	if(is_null($rescr11['openingbalance']))
					// 	{
					// 		$openingbalance_paid = 0;
							
					// 	}
					// 	else
					// 	{
					// 		$openingbalance_paid = $rescr11['openingbalance'];
					// 	}
						
					// }
					// //echo '@'.$openingbalance_paid.'@';
					
					
					// $openingbalance =  $openingbalance - $openingbalance_paid;
					// //echo $openingbalance.'<br>';		

					// $query_refunds = "SELECT IFNULL(SUM(`transactionamount`),0) as openingbalance_r  FROM `billing_ipprivatedoctor_refund` WHERE doccoa='$searchsuppliercode'  AND `recorddate` <  '$ADate1'  and amount <> '0.00' and amount > 0  and docno <> ''";
     //         //  and visittype='OP'
     //         $exec_refunds = mysql_query($query_refunds) or die ("Error in querycr1ip".mysql_error());
     //        $res_refunds = mysql_fetch_array($exec_refunds);
     //        $openingbalance_ref = $res_refunds['openingbalance_r']; 

             // $openingbalance = $openingbalance - $openingbalance_ref;

					//////////////// opening balalnce///////////////
				/*		$querycr1op = "SELECT IFNULL(SUM(`transactionamount`),0) as openingbalance  FROM `billing_ipprivatedoctor` WHERE doccoa='$searchsuppliercode'  AND `recorddate` <  '$ADate1' and visittype='OP' and amount <> '0.00' and amount > 0  and docno <> ''";
						$execcr1 = mysql_query($querycr1op) or die ("Error in querycr1op".mysql_error());
            //echo $querycr1op.'<br>';
            
						$rescr1 = mysql_fetch_array($execcr1);
						$openingbalance = $rescr1['openingbalance']; 

            //echo $openingbalance.'<br>';

					$querycr1ip = "SELECT IFNULL(SUM(`sharingamount`),0) as openingbalance1  FROM `billing_ipprivatedoctor` WHERE doccoa='$searchsuppliercode'  AND `recorddate` <  '$ADate1' and visittype='IP' and amount <> '0.00' and amount > 0  and docno <> ''";
						$execcr12 = mysql_query($querycr1ip) or die ("Error in querycr1ip".mysql_error());
           // echo $querycr1ip.'<br>';
						$rescr12 = mysql_fetch_array($execcr12);
						$openingbalance1 = $rescr12['openingbalance1']; 
           // echo $openingbalance1.'<br>';
						$openingbalance =$openingbalance +$openingbalance1;



            $query = "SELECT IFNULL(sum(transactionamount), 0) as opbaldebit  from master_transactiondoctor where doctorcode='$searchsuppliercode' and transactiondate <'$ADate1' and debit_reference_no IS NULL" ;
            $exec_dr = mysql_query($query) or die ("Error in querycr1ip".mysql_error());
            $res_dr = mysql_fetch_array($exec_dr);
            $openingbalance_deb = $res_dr['opbaldebit']; 
           
            //echo $openingbalance1.'<br>';
            $final_opening_balance = $openingbalance - $openingbalance_deb;
            //echo  $final_opening_balance .'<br>';
            //$openingbalance = $final_opening_balance;*/

			$querycr1op = "SELECT IFNULL(SUM(`transactionamount`),0) as openingbalance,visitcode,docno  FROM `billing_ipprivatedoctor` WHERE doccoa='$searchsuppliercode'  AND `recorddate` <  '$ADate1' and visittype='OP' and amount <> '0.00' and amount > 0  and docno <> '' group by docno,visitcode,doccoa 
			union all
			SELECT IFNULL(SUM(`sharingamount`),0) as openingbalance1,visitcode,docno  FROM `billing_ipprivatedoctor` WHERE doccoa='$searchsuppliercode'  AND `recorddate` <  '$ADate1' and visittype='IP' and amount <> '0.00' and amount > 0  and docno <> '' group by docno,visitcode,doccoa
			";
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1op) or die ("Error in querycr1op".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($rescr1 = mysqli_fetch_array($execcr1))
			{
			   $openingbalance = $openingbalance+$rescr1['openingbalance'];
			   $billnumber_doc=$rescr1['docno'];
			   $visitcode=$rescr1['visitcode'];

			   $query = "SELECT IFNULL(sum(transactionamount), 0) as opbaldebit  from master_transactiondoctor where doctorcode='$searchsuppliercode' and billnumber = '$billnumber_doc' and visitcode='$visitcode'  and debit_reference_no IS NULL" ;
				$exec_dr = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in querycr1ip".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res_dr = mysqli_fetch_array($exec_dr);
				$openingbalance_deb = $res_dr['opbaldebit'];  
				$openingbalance =$openingbalance -$openingbalance_deb;
			}

            // for adp bills
            $query22 = "SELECT IFNULL(sum(transactionamount), 0) as opbaldebit  from advance_payment_entry where ledger_code='$searchsuppliercode' and transactiondate <'$ADate1' " ;
            $exec_dr2 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in querycr1ip".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res_dr2 = mysqli_fetch_array($exec_dr2);
            $openingbalance_deb_adp = $res_dr2['opbaldebit']; 
           
            $final_opening_balance = $openingbalance - $openingbalance_deb_adp;


            // doctor debit note

            $query_note = "SELECT IFNULL(sum(amount), 0) as docamt  from adhoc_debitnote where billingaccountcode = '$searchsuppliercode' and consultationdate < '$ADate1'";

             $exec_note = mysqli_query($GLOBALS["___mysqli_ston"], $query_note) or die ("Error in querycr1ip".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res_note = mysqli_fetch_array($exec_note);
            $openingbalance_p = $res_note['docamt']; 

             $query_note = "SELECT IFNULL(sum(amount), 0) as docamt  from adhoc_creditnote where billingaccountcode = '$searchsuppliercode' and consultationdate < '$ADate1'";
             //echo $query_note;
             $exec_note = mysqli_query($GLOBALS["___mysqli_ston"], $query_note) or die ("Error in querycr1ip".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res_note = mysqli_fetch_array($exec_note);
            $openingbalance_m = $res_note['docamt']; 
           
            $openingbalance_doct_debcre = $openingbalance_p - $openingbalance_m;

           

            $openingbalance = $final_opening_balance + $openingbalance_doct_debcre;


             $query_refunds = "SELECT IFNULL(SUM(`transactionamount`),0) as openingbalance_r  FROM `billing_ipprivatedoctor_refund` WHERE doccoa='$searchsuppliercode'  AND `recorddate` <  '$ADate1'  and amount <> '0.00' and amount > 0  and docno <> ''";
             //  and visittype='OP'
             $exec_refunds = mysqli_query($GLOBALS["___mysqli_ston"], $query_refunds) or die ("Error in querycr1ip".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res_refunds = mysqli_fetch_array($exec_refunds);
            $openingbalance_ref = $res_refunds['openingbalance_r']; 

             $openingbalance = $openingbalance - $openingbalance_ref;
					//////////////// openinf balalnce

		  ?>

			<tr>

			<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>

				

              <td width="9%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>

              <td width="25%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><strong> Opening Balance </strong></td>
                
                <!-- <td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>	
                 <td width="9%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>

              <td width="10%" align="right" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><strong>&nbsp;</strong></td>
			<td width="10%" align="right" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><strong>&nbsp;</strong></td>

              <td width="10%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>

			 <td width="10%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	

				<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
				<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	 -->

				<td colspan="13" width="10%" align="right" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',',');  ?></strong></div></td>

			</tr>

			<?php

			}

			

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

			if ($cbfrmflag1 == 'cbfrmflag1')

			{


				

				$query21 = "select doctorname from master_doctor where doctorcode = '$searchsuppliercode'";

				$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res21 = mysqli_fetch_array($exec21);
				$res21accountname = $res21['doctorname'];

				/*while ($res21 = mysql_fetch_array($exec21))

				{*/

					//$res21accountname = $res21['doctorname'];

					

					

					//if( $res21accountname != '')

					//{

			?>

				<tr bgcolor="#ffffff">

					<td colspan="16"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res21accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2; ?>)</strong></td>

				</tr>

				

			<?php

			 $totalamount30_n =0;
			  $totalamount60_n =0;
			  $totalamount90_n =0;
			  $totalamount120_n =0;
			  $totalamount180_n =0;
			  $totalamountgreater_n=0 ;

			$total = 0;

			$totalamount30 = 0;

			$totalamount60 = 0;

			$totalamount90 = 0;

			$totalamount120 = 0;

			$totalamount180 = 0;

			$totalamountgreater = 0;

			$balanceamount = 0;

			$snocount = 0;

			

			//$cashamount21 = '0.00';
				$cashamount21 = 0;

				//$cardamount21 = '0.00';
				$cardamount21 = 0;

				//$onlineamount21 = '0.00';
				$onlineamount21 = 0;

				//$chequeamount21 = '0.00';
				$chequeamount21 = 0;

				//$tdsamount21 = '0.00';
				$tdsamount21 = 0;

				//$writeoffamount21 = '0.00';
				$writeoffamount21 = 0;

				//$taxamount21 = '0.00';
				$taxamount21 = 0;



				//$totalpayment = '0.00';
				$totalpayment = 0;

				//$netpayment = '0.00';
				$netpayment = 0;

				//$balanceamount = '0.00';
				$balanceamount = 0;

				

				//$billtotalamount = '0.00';
				$billtotalamount = 0;

				//$netpayment = '0.00';
				$netpayment = 0;

				//$balanceamount = '0.00';
				$balanceamount = 0;

				$transaction_amount21 = 0;
				
			

			//$query2 = "select patientname,patientcode,visitcode,accountname,billanum,billnumber,transactiondate from doctorsharing where doctorcode = '$searchsuppliercode' ";

			// 	--UNION ALL SELECT '' AS doctorname,patientname,patientcode,patientvisitcode as visitcode, accountname,docno as billnumber, consultationdate as recorddate, 0 as original_amt,amount, sum(amount) as transactionamount, billtype, locationcode, 0 as transactionamount1, billingaccountcode as doccoa, '' as visittype from adhoc_creditnote where billingaccountcode = '$searchsuppliercode' and consultationdate between '$ADate1' and '$ADate2'  group by visitcode

			// --UNION ALL SELECT '' AS doctorname,patientname,patientcode,patientvisitcode as visitcode, accountname,docno as billnumber, consultationdate as recorddate, 0 as original_amt,amount, sum(amount) as transactionamount, billtype, locationcode, 0 as transactionamount1, billingaccountcode as doccoa, '' as visittype from adhoc_debitnote where billingaccountcode = '$searchsuppliercode' and consultationdate between '$ADate1' and '$ADate2'  group by visitcode

				 // --  union all SELECT '' AS doctorname,patientname,patientcode,visitcode as visitcode, accountname,docno as billnumber, recorddate as recorddate, sum(original_amt) as original_amt, transactionamount as amount,
			 // -- sum(transactionamount) as transactionamount, billtype, locationcode, 0 as transactionamount1, doccoa as doccoa, visittype as visittype from billing_ipprivatedoctor_refund where doccoa = '$searchsuppliercode' and recorddate between '$ADate1' and '$ADate2' group by visitcode

				// union all SELECT '' AS doctorname,patientname,patientcode,visitcode as visitcode, accountname,billnumber as billnumber, transactiondate as recorddate, 0 as original_amt, transactionamount as amount,
			// sum(transactionamount) as transactionamount,'' as billtype, locationcode, 0 as transactionamount1, doctorcode as doccoa, '' as visittype, '' as particulars12 from advance_payment_allocation where   doctorcode='$searchsuppliercode' and transactiondate between '$ADate1' and '$ADate2' and recordstatus='allocated' group by visitcode,docno

			 $query2 = "SELECT * from (SELECT description as doctorname,patientname,patientcode,visitcode,accountname,docno as billnumber,recorddate as recorddate,original_amt,amount,sum(transactionamount) as transactionamount,billtype,locationcode,sum(sharingamount) as transactionamount1,doccoa,visittype, '' as particulars12 from billing_ipprivatedoctor where doccoa = '$searchsuppliercode' and recorddate between '$ADate1' and '$ADate2' and docno <> '' group by visitcode,docno

			-- for ADP bills
			union all SELECT '' AS doctorname,'' as patientname,'' as patientcode,'' as visitcode, '' as accountname,docno as billnumber, transactiondate as recorddate, 0 as original_amt, transactionamount as amount,
			(transactionamount) as transactionamount,'' as billtype, locationcode, (transactionamount)  as transactionamount1, ledger_code as doccoa, '' as visittype, particulars as particulars12 from advance_payment_entry where  ledger_code='$searchsuppliercode' and transactiondate between '$ADate1' and '$ADate2' and recordstatus<>'deleted'

			

			 ) as a group by visitcode,billnumber 
			 
			order by recorddate";

            $a=array();

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rowcount2 = mysqli_num_rows($exec2);

			while ($res2 = mysqli_fetch_array($exec2))

			{

				
				$suppliername1 = $res2['patientname'];

				$patientcode = $res2['patientcode'];

				$visitcode = $res2['visitcode'];

    

				//$billautonumber=$res2['billanum'];

				$billnumber = $res2['billnumber'];
				//$billtype = $res2['billtype'];

				$query11 = "SELECT billtype,subtype from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode'  ";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
				$num11 =mysqli_num_rows($exec11);
				$billtype = $res11['billtype'];
				$subtype = $res11['subtype'];
				
				if($num11 ==0)
				{
				$query11 = "SELECT billtype,subtype from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
				$billtype = $res11['billtype'];
				$subtype = $res11['subtype'];
				}

				$subtypesql="select subtype from master_subtype where auto_number='$subtype'";
				$sexec11 = mysqli_query($GLOBALS["___mysqli_ston"], $subtypesql) or die ("Error in subtypesql".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sres11 = mysqli_fetch_array($sexec11);
				$subtype = $sres11['subtype'];

				//echo 'hi'.$billnumber.'<br>';

				$billdate = $res2['recorddate'];

				$suppliername = $res2['accountname'];

				$doctorname=$res2['doctorname'];

				if($res2['visittype']=='OP')
				  $amount_topay_doc = $res2['transactionamount'];
				else
				  $amount_topay_doc = $res2['transactionamount1'];

				$res45locationcode = $res2['locationcode'];

				



			/*	$query66="select * from consultation_referal where patientvisitcode='$visitcode'";

				$exec66=mysql_query($query66);

				$res66=mysql_fetch_array($exec66);

				$num66=mysql_num_rows($exec66);

				if($num66 == 0)

				{

					$doctorname='';

				}

				else

				{

					$doctorname=$res66['referalname'];

				}*/

				

				/*$query67="select * from master_customer where customercode='$patientcode'";

				$exec67=mysql_query($query67);

				$res67=mysql_fetch_array($exec67);

				$firstname=$res67['customername'];

				$lastname=$res67['customerlastname'];

				$name=$firstname.$lastname;*/
				$name = $res2['patientname'];


				/*$query761="select transactionamount from doctorsharing where billnumber = '$billnumber' and billanum = '$billautonumber' AND visitcode ='$visitcode' ";

				$exec761=mysql_query($query761) or die("Error in query761".mysql_error());

				$res761=mysql_fetch_array($exec761);

				$billtotalamount = $res761['transactionamount'];*/

				$billtotalamount = $amount_topay_doc;

				//$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber' and acc_status <> 'deallocated'";
				// $query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''  and acc_status <> 'deallocated' and doctorcode = '$searchsuppliercode'";
				

				// $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());

				// $numb=mysql_num_rows($exec3);

				

				// while ($res3 = mysql_fetch_array($exec3))

				// {

				// 	//echo $res3['auto_number'];

				// 	$cashamount1 = $res3['cashamount'];

				// 	$onlineamount1 = $res3['onlineamount'];

				// 	$chequeamount1 = $res3['chequeamount'];

				// 	$cardamount1 = $res3['cardamount'];

				// 	$tdsamount1 = $res3['tdsamount'];

				// 	$writeoffamount1 = $res3['writeoffamount'];

					

					

				// 	$cashamount21 = $cashamount21 + $cashamount1;

				// 	$cardamount21 = $cardamount21 + $cardamount1;

				// 	$onlineamount21 = $onlineamount21 + $onlineamount1;

				// 	$chequeamount21 = $chequeamount21 + $chequeamount1;

				// 	$tdsamount21 = $tdsamount21 + $tdsamount1;

				// 	$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					
				// 	$transaction_amount21 = $transaction_amount21 + $res3['transactionamount'];
					

				// }

				
				/*$query31 = "select sum(transactionamount) as transactionamount from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber' and acc_status <> 'deallocated'";

				$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());

				$numb1=mysql_num_rows($exec31);

				if($numb1 >0 ){

					$res31 = mysql_fetch_array($exec31);

					$transactionamount1 = $res31['transactionamount'];

				}else{

					$transactionamount1 = '0';

				}*/

			
				$debit_amount=0;
				$res45transactionamount=0;
				 ///////////// CASH REFUNDS/////////////
				$query234 = "SELECT sum(sharingamount) as sharingamount, sum(transactionamount) as transactionamount, docno, percentage, pvtdr_percentage, visittype FROM `billing_ipprivatedoctor_refund` WHERE doccoa='$searchsuppliercode'  AND `visitcode` =  '$visitcode' and against_refbill='$billnumber' group by docno, visitcode 
					union all SELECT 0 as sharingamount, sum(amount) as transactionamount, docno, '' as percentage, '' as pvtdr_percentage,'adhoc_creditnote_min' as visittype FROM `adhoc_creditnote` WHERE billingaccountcode='$searchsuppliercode'  AND `patientvisitcode` =  '$visitcode' and consultationdate <= '$ADate2' group by docno, patientvisitcode 
					union ALL select 0 as sharingamount, sum(transactionamount) as transactionamount,docno,'' as percentage,'' as pvtdr_percentage, 'master_transactiondoctor' as visittype  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$searchsuppliercode' and `visitcode` =  '$visitcode' and transactiondate <='$ADate2' and billnumber='$billnumber'
					";
            $exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num234=mysqli_num_rows($exec234);
			while($res234 = mysqli_fetch_array($exec234)){
			 // $res234 = mysql_fetch_array($exec234);
			 $res45transactionamount_old=0;
				              $ref_doc = $res234['docno'];
				              $res45vistype = $res234['visittype'];
				              $res45transactionamount_old = $res234['sharingamount'];
				              if($res45vistype == "OP")
				              {
				              	$res45doctorperecentage = $res234['percentage'];
				              	 $res45transactionamount_old = $res234['transactionamount'];
				              }
				              if($res45vistype == "IP")
				              {
				              	$res45doctorperecentage = $res234['pvtdr_percentage'];
				              }

				              /// for CRN Bills
				              if($res45vistype == 'adhoc_creditnote_min'){
				              	 $res45transactionamount_old = $res234['transactionamount'];
				              }
				              /// for CRN Bills

				     if($res45vistype == 'master_transactiondoctor')
				        {
				           $res45transactionamount_old = $res234['transactionamount'];
				          // $taxamount = $res234['taxamount'];
				          // $amtwithouttax = $res45transactionamount_old - $taxamount;

				            $query124 = "select sum(original_amt) as original_amt,transactionamount, visittype,percentage,pvtdr_percentage,billtype as billtype2 from billing_ipprivatedoctor where doccoa='$searchsuppliercode' and docno='$ref_doc' and transactionamount >0";
				            $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				            $res124 = mysqli_fetch_array($exec124);
				            $res45billamount = $res124['original_amt'];
				            $res45vistype = $res124['visittype'];
							$billtype2 = $res124['billtype2'];
				             if($res45vistype == "OP")
				              {

				              $res45doctorperecentage = $res234['percentage'];

				              $res45transactionamount_old = $res234['transactionamount'];
				              }
				              else
				              {

				              $res45doctorperecentage = $res234['pvtdr_percentage'];

				              }
				              
				            
				        }

				        $res45transactionamount=$res45transactionamount+$res45transactionamount_old;
				    }


				         ///////////// for crn billls
						    $query_crnno = "SELECT  docno FROM `billing_ipprivatedoctor_refund` WHERE doccoa='$searchsuppliercode'  AND `visitcode` =  '$visitcode' and against_refbill='$billnumber' group by docno, visitcode ";
		            $exec_crnno = mysqli_query($GLOBALS["___mysqli_ston"], $query_crnno) or die ("Error in Query_crnno".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_crnno=mysqli_num_rows($exec_crnno);
					 $res_crnno = mysqli_fetch_array($exec_crnno);
					 $crnnumber=$res_crnno['docno'];

					  $query_crn2 = "SELECT  docno FROM `adhoc_creditnote` WHERE billingaccountcode='$searchsuppliercode'  AND `patientvisitcode` =  '$visitcode'  ";
		            $exec_crn2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_crn2) or die ("Error in Query_crn2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_crn2=mysqli_num_rows($exec_crn2);
					 $res_crn2 = mysqli_fetch_array($exec_crn2);
					 $crnnumber2=$res_crn2['docno'];
				    ///////////// for crn billls

					$query_adpallocaion = "SELECT  sum(transactionamount) as transactionamount,docno  from advance_payment_allocation where  doctorcode='$searchsuppliercode' and `visitcode` =  '$visitcode' and updatedate <='$ADate2' and billnumber='$billnumber' and recordstatus='allocated'";
					$exec_adpallocaion = mysqli_query($GLOBALS["___mysqli_ston"], $query_adpallocaion) or die ("Error in Query_adpallocaion".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_adpallocaion=mysqli_num_rows($exec_adpallocaion);
					$res_adpallocaion = mysqli_fetch_array($exec_adpallocaion);
					$res45transactionamount +=$res_adpallocaion['transactionamount'];
					$adpallocaionnumber=$res_adpallocaion['docno'];
 

					$query_adhocdebit = "SELECT  amount as transactionamount  from adhoc_debitnote where billingaccountcode = '$searchsuppliercode' and patientvisitcode ='$visitcode'  group by docno, patientvisitcode  ";
					$exec_adhocdebit = mysqli_query($GLOBALS["___mysqli_ston"], $query_adhocdebit) or die ("Error in Query_adhocdebit".mysqli_error($GLOBALS["___mysqli_ston"]));
					// $num_adhocdebit=mysql_num_rows($exec_adhocdebit);
					$res_adhocdebit = mysqli_fetch_array($exec_adhocdebit);
					 $amount_adhocdebit = $res_adhocdebit['transactionamount'];
         ///////////// CASH REFUNDS/////////////

				

				//$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
					 $transaction_amount21=0;
				$totalpayment = $transaction_amount21;

				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				
				//$balanceamount = $billtotalamount - $netpayment;

				//$balanceamount = $billtotalamount - $transactionamount1;
				// $balanceamount = $amount_topay_doc - $netpayment - $res45transactionamount + $amount_adhocdebit;
				 $debit_amount =  $res45transactionamount;
				$balanceamount1 =  $amount_topay_doc+$amount_adhocdebit;
				$balanceamount = $amount_topay_doc - $res45transactionamount + $amount_adhocdebit;


               
				 // ------ for total amountallocated for the doc-----------
					$haystack21 = $billnumber;
						$needle21   = "ADP";
						if( strpos( $haystack21, $needle21 ) !== false) {
							$query_adp = "SELECT sum(transactionamount) as transactionamount FROM `advance_payment_allocation` WHERE   docno='$billnumber'  and recordstatus='allocated'  ";
							$exec_adp = mysqli_query($GLOBALS["___mysqli_ston"], $query_adp) or die ("Error in Query_adp".mysqli_error($GLOBALS["___mysqli_ston"]));
							$num_adp=mysqli_num_rows($exec_adp);
							// while($res_adp = mysql_fetch_array($exec_adp)){
							$res_adp = mysqli_fetch_array($exec_adp);
							$total_adp_transactioamount = $res_adp['transactionamount'];

							 	$num234=1;
							
							$balanceamount=$amount_topay_doc-$total_adp_transactioamount;				
							$res45transactionamount =  $balanceamount;
							$balanceamount1 =  '0';
							$debit_amount =  $res45transactionamount;
						}
				// ------ for total amountallocated for the doc-----------	

				if(in_array($billnumber,$a))
				    continue;
				else if($balanceamount>=0)
					$a[]=$billnumber;
               
				

				//$billtotalamount = number_format($billtotalamount, 2, '.', '');

				//$netpayment = number_format($netpayment, 2, '.', '');

				//$balanceamount = number_format($balanceamount, 2, '.', '');

				

				$billstatus = $billtotalamount.'||'.$netpayment.'||'.$balanceamount;



				

			$billdate = substr($billdate, 0, 10);

			$date1 = $billdate;



			$dotarray = explode("-", $billdate);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$billdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));



			/*$billtotalamount = number_format($billtotalamount, 2, '.', '');

			$netpayment = number_format($netpayment, 2, '.', '');

			$balanceamount = number_format($balanceamount, 2, '.', '');
*/
			

			$date1 = $date1;

			// $date2 = date("Y-m-d");  
			// $date2 = $ADate2; 
			$date2 = date('Y-m-d', strtotime($ADate2 . ' +1 day')); 

			$diff = abs(strtotime($date2) - strtotime($date1));  

			$days = floor($diff / (60*60*24));  

			$daysafterbilldate = $days;

			

			//$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber' and acc_status <> 'deallocated' order by auto_number desc";

			$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''  and acc_status <> 'deallocated' and doctorcode = '$searchsuppliercode' order by auto_number desc";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res31 = mysqli_fetch_array($exec31);

			 $numb1=mysqli_num_rows($exec31);

			 //$totalnumb=$totalnumb+$numb1;

			 

			// $lastpaymentdate = $res31['transactiondate'];
			$lastpaymentdate = $res2['recorddate'];

			$lastpaymentdate = substr($lastpaymentdate, 0, 10);


			if ($lastpaymentdate != '')

			{

				$date1 = $lastpaymentdate;

				$date2 = date("Y-m-d");  

				$diff = abs(strtotime($date2) - strtotime($date1));  

				$days = floor($diff / (60*60*24));  

				$daysafterpaymentdate = $days;

				

				$dotarray = explode("-", $lastpaymentdate);

				$dotyear = $dotarray[0];

				$dotmonth = $dotarray[1];

				$dotday = $dotarray[2];

				$lastpaymentdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));

				

			}

			else

			{

				$daysafterpaymentdate = '';

				$lastpaymentdate = '';

			}			

			//echo $billtotalamount;

		

			

 			if($balanceamount>0 || $balanceamount<0){


			 $snocount1 = $snocount1 + 1;
				if($snocount1 == 1)	
				{
					$total = $openingbalance + $balanceamount1 - $debit_amount;
					
				}
				else
				{
					$total = $total + $balanceamount1 - $debit_amount;
				}

			if ($balanceamount == 0)

			{

				$res2transactionamount = 0;

			}

			else

			{

				$res2transactionamount = $balanceamount;

			} 


			 $query33 = "select transactionamount as debit,transactiondate  from master_transactiondoctor where billnumber = '$billnumber' and doctorcode='$searchsuppliercode' order by transactiondate,auto_number";

			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num33=mysqli_num_rows($exec33);

			$inner_sno = 0;
			$debit_total =0;
			$totalat=$total;
			$alloted_status ='';

			//$debit_amt = 0;

			while($res33 = mysqli_fetch_array($exec33))

			{
				$debit_amt = $res33['debit'];
				$totalat = $totalat - $debit_amt;
			}
            if(isset($billtype2) && $billtype2!='')
				$billtype2=$billtype2;
			else
				$billtype2=$billtype;


			      
			if($billtype2 == 'PAY LATER')
			   {
			   		 $transc_amt = 0;

					 $query27 = "select sum(billbalanceamount) as billbalanceamount from master_transactionpaylater where billnumber='$billnumber' and (recordstatus='allocated' || recordstatus='') and transactionstatus <> 'onaccount' and acc_flag = '0'  and transactiontype='PAYMENT'";


					$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));

					$num2 = mysqli_num_rows($exec27);

					if($num2==0){
						$alloted_status = "No";
					}else{
                        

						$res27 = mysqli_fetch_array($exec27);
						$transc_amt_bal = $res27['billbalanceamount'];

						if($transc_amt_bal==null || $transc_amt_bal=="")
						{
						 $alloted_status = "No";
						}
						elseif($transc_amt_bal>0 )
						{
						 $alloted_status = "Partly";
						}
						else
						{
						 $alloted_status = "Fully";
						}
					
					}

					
			}


					if($billtype2 == 'PAY NOW' || strpos( $billnumber, "CF-" ) !== false)
					{
					   $alloted_status = "Yes";
					}

			//  $totalat=0;
			// $t1 = strtotime($ADate2);
			  $date2 = date('Y-m-d', strtotime($ADate2 . ' +1 day')); 
       			$t1 = strtotime($date2);

			$t2 = strtotime($billdate);
			$days_between = ceil(abs($t1 - $t2) / 86400);
			$snocount = $snocount + 1;
			$openingbalance_n=0;

			if($days_between <= 30)

			{

				if($snocount == 1)

				{

					$totalamount30_n = $openingbalance_n + ($balanceamount1-$res45transactionamount);

				}

				else

				{

					$totalamount30_n = $totalamount30_n + ($balanceamount1-$res45transactionamount);

				}

			}

			else if(($days_between >30) && ($days_between <=60))

			{

				if($snocount == 1)

				{

					$totalamount60_n = $openingbalance_n + ($balanceamount1-$res45transactionamount);

				}

				else

				{

					$totalamount60_n = $totalamount60_n + ($balanceamount1-$res45transactionamount);

				}

			}

			else if(($days_between >60) && ($days_between <=90))

			{

				if($snocount == 1)

				{

					$totalamount90_n = $openingbalance_n + ($balanceamount1-$res45transactionamount);

				}

				else

				{

					$totalamount90_n = $totalamount90_n + ($balanceamount1-$res45transactionamount);

				}

			}

			else if(($days_between >90) && ($days_between <=120))

			{

				if($snocount == 1)

				{

					$totalamount120_n = $openingbalance_n + ($balanceamount1-$res45transactionamount);

				}

				else

				{

					$totalamount120_n = $totalamount120_n + ($balanceamount1-$res45transactionamount);

				}

			}

				else if(($days_between >120) && ($days_between <=180))

				{

					if($snocount == 1)

				{

					$totalamount180_n = $openingbalance_n + ($balanceamount1-$res45transactionamount);

				}

				else

				{

					$totalamount180_n = $totalamount180_n + ($balanceamount1-$res45transactionamount);

				}

			}

			else

			{

				if($snocount == 1)

				{

					$totalamountgreater_n = $openingbalance_n + ($balanceamount1-$res45transactionamount);

				}

				else

				{

					$totalamountgreater_n = $totalamountgreater_n + ($balanceamount1-$res45transactionamount);

				}

			}



			//if($balanceamount !='0.00'){

			//echo $balanceamount;

			//$total =$total + $balanceamount;

			

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
			if($balanceamount>0 || $balanceamount<0){
			// if($res45transactionamount > 0) {
			// if(1) {
				?>

                            <tr class="<?php echo ($colorloopcount % 2 == 0) ? 'table-row-even' : 'table-row-odd'; ?>">
                                <td class="table-cell"><?php echo $snocount; ?></td>
                                <td class="table-cell"><?php echo $billdate; ?></td>
                                <td class="table-cell">
                                    <?php 
                                    $haystack21 = $billnumber;
                                    $needle21 = "ADP";
                                    if(strpos($haystack21, $needle21) !== false) {
                                        echo "Payment (".$res2['particulars12'].")";
                                    } else {
                                        echo $name . " (" . $patientcode . ", " . $visitcode . ")";
                                    }
                                    ?>
                                </td>
                                <td class="table-cell">
                                    <?php
                                    $haystack = $billnumber;
                                    $needle = "IPFCA";
                                    $url = "";
                                    if(strpos($haystack, $needle) !== false) {
                                        $url = "print_creditapproval.php?locationcode=$res45locationcode&&patientcode=$patientcode&&visitcode=$visitcode&&billnumber=$billnumber";
                                    } else {
                                        $needle = "IPF";
                                        if(strpos($haystack, $needle) !== false) {
                                            $url = "print_ipfinalinvoice1.php?locationcode=$res45locationcode&&patientcode=$patientcode&&visitcode=$visitcode&&billnumber=$billnumber";
                                        } else {
                                            $needle = "CB";
                                            if(strpos($haystack, $needle) !== false) {
                                                $url = "print_paylater_detailed.php?locationcode=$res45locationcode&&billautonumber=$billnumber";
                                            } else {
                                                $needle = "CF";
                                                if(strpos($haystack, $needle) !== false) {
                                                    $url = "print_consultationbill_dmp4inch1.php?locationcode=$res45locationcode&&billautonumber=$billnumber";
                                                }
                                            }
                                        }
                                    }
                                    
                                    $needle = "OPR";
                                    $url1 = '';
                                    if(strpos($ref_doc, $needle) !== false) {
                                        $url1 = "print_consultationrefund_dmp4inch1.php?locationcode=$res45locationcode&&billautonumber=$ref_doc";
                                    }
                                    ?>
                                    
                                    <?php
                                    $haystack = $billnumber;
                                    $needle = "ADP";
                                    if(strpos($haystack21, $needle21) !== false) {
                                        echo $billnumber;
                                    } else { ?>
                                        <a target="_blank" href="<?=$url;?>" class="btn btn-sm btn-outline">
                                            <i class="fas fa-external-link-alt"></i> <?php echo $billnumber; ?>
                                        </a>
                                    <?php } ?>
                                    
                                    <?php if($num234 > 0) { ?>
                                        <a target="_blank" href="<?=$url1;?>" class="btn btn-sm btn-outline">
                                            <i class="fas fa-external-link-alt"></i> <?php echo $ref_doc; ?>
                                        </a>
                                    <?php } ?>
                                    
                                    <?php if($num_crnno > 0) { ?>
                                        <a target="_blank" href="<?=$url1;?>" class="btn btn-sm btn-outline">
                                            <i class="fas fa-external-link-alt"></i> <?php echo $crnnumber; ?>
                                        </a>
                                    <?php } ?>
                                    
                                    <?php if($num_crn2 > 0) { ?>
                                        <a target="_blank" href="<?=$url1;?>" class="btn btn-sm btn-outline">
                                            <i class="fas fa-external-link-alt"></i> <?php echo $crnnumber2; ?>
                                        </a>
                                    <?php } ?>
                                    
                                    <?php if($num_adpallocaion > 0) { ?>
                                        <span class="badge badge-info"><?php echo $adpallocaionnumber; ?></span>
                                    <?php } ?>
                                </td>
                                <td class="table-cell"><?php echo $billtype; ?></td>
                                <td class="table-cell"><?php echo $subtype; ?></td>
                                <td class="table-cell">
                                    <span class="badge <?php echo ($alloted_status == 'Yes' || $alloted_status == 'Fully') ? 'badge-success' : (($alloted_status == 'Partly') ? 'badge-warning' : 'badge-danger'); ?>">
                                        <?php echo $alloted_status; ?>
                                    </span>
                                </td>
                                <td class="table-cell text-right"><?php echo number_format($res45transactionamount, 2, '.', ','); ?></td>
                                <td class="table-cell text-right"><?php echo number_format($balanceamount1, 2, '.', ','); ?></td>
                                <td class="table-cell text-right"><?php echo number_format(($balanceamount1 - $res45transactionamount), 2, '.', ','); ?></td>
                                <td class="table-cell text-center">
                                    <span class="badge <?php echo ($daysafterbilldate <= 30) ? 'badge-success' : (($daysafterbilldate <= 60) ? 'badge-warning' : 'badge-danger'); ?>">
                                        <?php echo $daysafterbilldate; ?>
                                    </span>
                                </td>
                                <td class="table-cell text-right"><?php echo number_format($total, 2, '.', ','); ?></td>
                            </tr>

			<?php
					}
				

					}

					//$cashamount21 = '0.00';
				$cashamount21 = 0;

				//$cardamount21 = '0.00';
				$cardamount21 = 0;

				//$onlineamount21 = '0.00';
				$onlineamount21 = 0;

				//$chequeamount21 = '0.00';
				$chequeamount21 = 0;

				//$tdsamount21 = '0.00';
				$tdsamount21 = 0;

				//$writeoffamount21 = '0.00';
				$writeoffamount21 = 0;

				//$taxamount21 = '0.00';
				$taxamount21 = 0;



				//$totalpayment = '0.00';
				$totalpayment = 0;

				//$netpayment = '0.00';
				$netpayment = 0;

				//$balanceamount = '0.00';
				$balanceamount = 0;

				

				//$billtotalamount = '0.00';
				$billtotalamount = 0;

				//$netpayment = '0.00';
				$netpayment = 0;

				//$balanceamount = '0.00';
				$balanceamount = 0;

				

				//$billstatus = '0.00';

				$billstatus = 0;

				$transaction_amount21 = 0;

				}

			?>

			

                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>
        </main>
    </div>

    <!-- Modern JavaScript Functions -->
    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('leftSidebar');
            const toggle = document.querySelector('.sidebar-toggle i');
            
            sidebar.classList.toggle('collapsed');
            toggle.classList.toggle('fa-chevron-left');
            toggle.classList.toggle('fa-chevron-right');
        }

        // Page refresh function
        function refreshPage() {
            window.location.reload();
        }

        // Export to Excel function
        function exportToExcel() {
            // Add export functionality here
            alert('Export functionality will be implemented');
        }

        // Initialize sidebar toggle on menu button click
        document.getElementById('menuToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('leftSidebar');
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('leftSidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>

</body>
</html> 
		 
          union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage, sum(amount) as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_creditnote' as transtable from adhoc_creditnote where billingaccountcode = '$suppliercode' and consultationdate < '$ADate1' group by accountcode,ref_no order by consultationdate)

          -- for ADP bills
           union (select transactiondate as transdate,docno as documentno,'' as billtype,'' as visitcode,'' as patientname,'' as patientcode, '' as accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, '0' as taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from advance_payment_entry where  ledger_code='$suppliercode' and recordstatus<>'deleted' and transactiondate < '$ADate1' order by transactiondate,auto_number)

           union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage,sum(amount) as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_debitnote' as transtable from adhoc_debitnote where billingaccountcode = '$suppliercode' and consultationdate <'$ADate1' group by accountcode,ref_no order by consultationdate) 

          union (SELECT recorddate as transdate,docno as documentno,billtype, visitcode visitcode,patientname,patientcode,accountname,'visittype' as visittype,sum(sharingamount) as sharingamount,percentage as percentage,sum(transactionamount) as transactionamount,pvtdr_percentage as pvtdr_percentage, sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor_refund' as transtable from billing_ipprivatedoctor_refund where doccoa = '$suppliercode' and recorddate < '$ADate1' group by docno,doccoa order by recorddate,docno)
        ) mainset order by transdate";

      $exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num234=mysqli_num_rows($exec234);
      while($res234 = mysqli_fetch_array($exec234))
      {
        $res45doctorperecentage = "";
        $res45transactiondate = $res234['transdate'];
        //$n_billdate = $res234
        $billnumber = $res234['documentno'];

        $billtype = $res234['billtype'];
        $res45visitcode = $res234['visitcode'];

        $query124 = "select * from master_visitentry where visitcode = '$res45visitcode'";
        $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($exec124) == 0)
        {
        $query124 = "select * from master_ipvisitentry where visitcode = '$res45visitcode'";
        $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        }

        $res124 = mysqli_fetch_array($exec124);
        $billtype = $res124['billtype'];

        $res45patientname = $res234['patientname'];
        $res45patientcode = $res234['patientcode'];
        
        $res45accountname = $res234['accountname'];
        $res45vistype = $res234['visittype'];

        $transtable = $res234['transtable'];

        $description = "";
        $res45billamount = $res234['original_amt'];

        $refno = $res234['refno'];

        $res45transactionamount = $res234['transactionamount'];
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'billing_ipprivatedoctor_refund')
        {



              $res45transactionamount = $res234['sharingamount'];

              if($res45vistype == "OP")
              {

              $res45doctorperecentage = $res234['percentage'];

              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {

              $res45doctorperecentage = $res234['pvtdr_percentage'];

              }

			$query2341 = "select 0 as sharingamount, sum(transactionamount) as transactionamount,docno,'' as percentage,'' as pvtdr_percentage, 'master_transactiondoctor' as visittype  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$suppliercode' and `visitcode` =  '$res45visitcode' and transactiondate <='$ADate2' and billnumber='$billnumber'
					";
            $exec2341 = mysqli_query($GLOBALS["___mysqli_ston"], $query2341) or die ("Error in Query2341".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2341=mysqli_num_rows($exec234);
			while($res2341 = mysqli_fetch_array($exec2341)){
				$res45transactionamount_old = $res2341['transactionamount'];
                $res45transactionamount=$res45transactionamount-$res45transactionamount_old;
			}
              
              $description = "Towards Bill ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname." )";
             
      
         }
        
         if($transtable == 'master_transactiondoctor')
        {
			
           $res45transactionamount = $res234['transactionamount'];

          $taxamount = $res234['taxamount'];

          $amtwithouttax = $res45transactionamount - $taxamount;
          $description =  "Payment ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res234['particulars']." )";


            $query124 = "select sum(original_amt) as original_amt,visittype,percentage,pvtdr_percentage,recorddate from billing_ipprivatedoctor where doccoa='$suppliercode' and docno='$billnumber' and transactionamount >0";
            $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res124 = mysqli_fetch_array($exec124);
            $res45billamount = $res124['original_amt'];
            $res45vistype = $res124['visittype'];
			$res45transactiondate = $res124['recorddate'];
             if($res45vistype == "OP")
              {

              $res45doctorperecentage = $res234['percentage'];

              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {

              $res45doctorperecentage = $res234['pvtdr_percentage'];

              }
          // }

              /// for adp allocation
     //          $query_adpallocaion = "SELECT  sum(transactionamount) as transactionamount,docno  from advance_payment_allocation where  doctorcode='$suppliercode' and `visitcode` =  '$res45visitcode' and updatedate <='$ADate2' and billnumber='$billnumber' and recordstatus='allocated'";
					// $exec_adpallocaion = mysql_query($query_adpallocaion) or die ("Error in Query_adpallocaion".mysql_error());
					// $num_adpallocaion=mysql_num_rows($exec_adpallocaion);
					// $res_adpallocaion = mysql_fetch_array($exec_adpallocaion);
					// // $res45transactionamount +=$res_adpallocaion['transactionamount'];
					// // $adpallocaionnumber=$res_adpallocaion['docno'];
					// $res45transactionamount=$res45transactionamount-$res_adpallocaion['transactionamount'];
            
        }
        if($res45transactiondate==''){
           $res45transactiondate = $res234['transdate'];
        }


         if($transtable == 'adhoc_creditnote')
        {
         $description =  "Credit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";

        
       }

        if($transtable == 'adhoc_debitnote')
        {
         $description =  "Debit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";
        
       }
        $res45locationcode = $res234['locationcode'];
        $colorloopcount = $colorloopcount + 1;

      $showcolor = ($colorloopcount & 1); 

      if ($showcolor == 0)

      {
        $colorcode = 'bgcolor="#CBDBFA"';

      }

      else

      {

      

        $colorcode = 'bgcolor="#ecf0f5"';

      }

      

       // $t1 = strtotime($ADate2);

         $date2 = date('Y-m-d', strtotime($ADate2 . ' +1 day')); 
       $t1 = strtotime($date2);

      $t2 = strtotime($res45transactiondate);


     

      $days_between = ceil(abs($t1 - $t2) / 86400);

     
  
       $snocount = $snocount + 1;

     
      $res2transactionamount =  $res45transactionamount;

      

      $debit_total = 0;

     
      

      if($days_between <=30)

      {

      if($snocount == 1)

      {



      if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalamount30 = $openingbalance + $res2transactionamount;
     
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount30 = $openingbalance - $res2transactionamount;
           
        }
      //$totalamount30 = $openingbalance + $res2transactionamount;
     

      }

      else

      {

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalamount30 = $totalamount30 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount30 = $totalamount30 - $res2transactionamount;
        }

     //$totalamount30 = $totalamount30 + $res2transactionamount;

     

      }

      }

      else if(($days_between >30) && ($days_between <=60))

      {

      if($snocount == 1)

      {

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount60 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount60 = $openingbalance - $res2transactionamount;
        }

      //$totalamount60 = $openingbalance + $res2transactionamount;


      }

      else

      {

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount60 = $totalamount60 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount60 = $totalamount60 - $res2transactionamount;
        }
     // $totalamount60 = $totalamount60 + $res2transactionamount;

      }

      }

      else if(($days_between >60) && ($days_between <=90))

      {

      if($snocount == 1)

      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount90 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount90 = $openingbalance - $res2transactionamount;
        }

      //$totalamount90 = $openingbalance + $res2transactionamount;

      }

      else

      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount90 = $totalamount90 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount90 = $totalamount90 - $res2transactionamount;
        }

     // $totalamount90 = $totalamount90 + $res2transactionamount;

      }

      }

      else if(($days_between > 90) && ($days_between <=120))

      {

      if($snocount == 1)

      {

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount120 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount120 = $openingbalance - $res2transactionamount;
        }

      //$totalamount120 = $openingbalance + $res2transactionamount;

      }

      else

      {

         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount120 = $totalamount120 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount120 = $totalamount120 - $res2transactionamount;
        }


     // $totalamount120 = $totalamount120 + $res2transactionamount;

      }

      }

      else if(($days_between >120) && ($days_between <=180))

      {

        if($snocount == 1)

      {

         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount180 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount180 = $openingbalance - $res2transactionamount;
        }
      //$totalamount180 = $openingbalance + $res2transactionamount;

      }

      else

      {

         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount180 = $totalamount180 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount180 = $totalamount180 - $res2transactionamount;
        }
      //$totalamount180 = $totalamount180 + $res2transactionamount;

      }

      }

      else

      {

          if($snocount == 1)

      {

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamountgreater = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamountgreater = $openingbalance - $res2transactionamount;
        }
      //$totalamountgreater = $openingbalance + $res2transactionamount;

      }

      else

      {

      
       if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamountgreater = $totalamountgreater + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamountgreater = $totalamountgreater - $res2transactionamount;
        }
        //$totalamountgreater = $totalamountgreater + $res2transactionamount;

      }

      }

      
           if($snocount == 1)

      {

     // $totalat = $openingbalance + $res45amount;
      
      if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalat = $openingbalance + $res45transactionamount ;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
          $totalat = $openingbalance - $res45transactionamount;
        }
      
      


      }

      else

      {

     // $totalat = $totalat + $res45amount;
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalat = $totalat + $res45transactionamount ;
        }
        if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
        $totalat = $totalat - $res45transactionamount;
       }
        
      }

        

      }

      ?>

   
    <tr>
      <td>&nbsp;</td>
    </tr>


		

			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

			<tr>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>


              <td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

					<td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

				<td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

            	 </tr>

						<tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>30 days</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>60 days</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>90 days</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>120 days</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>180 days</strong></td>

           <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>180+ days</strong></td>

           

             	 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>Total Due</strong></td>

            </tr>

			<?php 
			$grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
			//$grandtotal = $totalat;
			$grandtotal_n = $totalamount30_n + $totalamount60_n + $totalamount90_n + $totalamount120_n + $totalamount180_n + $totalamountgreater_n ;


			?>

			<tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format(($totalamount30+$totalamount30_n),2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format(($totalamount60+$totalamount60_n),2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format(($totalamount90+$totalamount90_n),2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format(($totalamount120+$totalamount120_n),2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format(($totalamount180+$totalamount180_n),2,'.',','); ?></td>

            <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format(($totalamountgreater+$totalamountgreater_n),2,'.',','); ?></td>

             	 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format(($totalat+$grandtotal_n),2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="right"> 

                 

                </td> 

				<td class="bodytext31" valign="center"  align="right"> 

                                </td> 

		    </tr>


			

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

           <?php

				//$supp=mysql_real_escape_string($searchsuppliername);

				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliercode=$searchsuppliercode&&locationcode1=$locationcode";

			

			?>

<td class="bodytext31" valign="center"  align="right"><a href="print_doctoroutstandingpdf.php?<?php echo $urlpath; ?>" target="_blank"><img  width="40" height="40" src="images/pdfdownload.jpg" style="cursor:pointer;"></a></td> 

		   	 <td class="bodytext31" valign="center"  align="right"><a href="print_doctoroutstandingxl.php?<?php echo $urlpath; ?>" target="_blank"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;" ></a></td> 

			        

               </tr>

			  </table><!-- -->

			  

			<?php

			

			//}

			//}

			}

			?>

         

</table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>

