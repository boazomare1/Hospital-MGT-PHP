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
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$billnumbers=array();
$billnumbers1=array();
$billnumbers11=array();
$billnumbers2=array();
$billnumbers3=array();
$billnumbers4=array();
$billnumbers5=array();
$totalvisitcodes='';
$totalbillnumbers='';
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$arraysuppliername = '';
$arraysuppliercode = '';	
$totalatret = 0.00;
$totalamountgreater = 0;
		  
$docno = $_SESSION['docno'];
$query01="select locationcode from login_locationdetails where username='$username' and docno='$docno'";
$exe01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01=mysqli_fetch_array($exe01);
 $locationcode=$res01['locationcode'];
include ("autocompletebuild_doctor1.php");
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) {  $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["location"])) {  $location = $_REQUEST["location"]; } else { $location = ""; }
$searchsuppliername1=explode('#',$searchsuppliername);
$searchsuppliername=trim($searchsuppliername1[0]);
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d'); }
$paymentreceiveddatefrom=$ADate1;
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
$paymentreceiveddateto=$ADate2;
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Statement Detail - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/doctor-statement-detail-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style type="text/css">
th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }
.bodytext31:hover { font-size:14px; }
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script>
/*function funcAccount()
{
if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))
{
alert('Please Select Doctor.');
return false;
}
}*/
</script>
<script type="text/javascript" src="js/autocomplete_doctor.js"></script>
<script type="text/javascript" src="js/autosuggestdoctor_stmt.js"></script>
<script type="text/javascript">
	window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	
	window.open("showinvoice.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
function coasearch1(varCallFrom1)
{
	var varCallFrom1 = varCallFrom1;
	
	window.open("showwthinvoice.php?callfrom1="+varCallFrom1,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
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

<!-- Modern JavaScript -->
<script src="js/doctor-statement-detail-modern.js?v=<?php echo time(); ?>"></script>
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
        <span>Doctor Statement Detail</span>
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
                        <a href="fulldrstatementdetail.php" class="nav-link active">
                            <i class="fas fa-file-invoice"></i>
                            <span>Doctor Statement Detail</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fulldrstatementsummary.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Doctor Statement Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="doctorpaymententry.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Doctor Payment Entry</span>
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
                    <h2>Doctor Statement Detail</h2>
                    <p>Comprehensive detailed analysis of doctor transactions with aging analysis and payment tracking.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printPage()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
		
            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Doctor Statement Search</h3>
                </div>
                
                <form name="cbform1" method="post" action="fulldrstatementdetail.php" class="search-form">
                    <div class="form-group">
                        <label for="searchsuppliername" class="form-label">Search Doctor</label>
                        <input name="searchsuppliername" type="text" id="searchsuppliername" 
                               value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                               class="form-input" placeholder="Type doctor name to search..." autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="ADate1" class="form-label">Date From</label>
                        <div class="date-input-group">
                            <input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>" 
                                   class="form-input date-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                 class="date-picker-icon" style="cursor:pointer"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ADate2" class="form-label">Date To</label>
                        <div class="date-input-group">
                            <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>" 
                                   class="form-input date-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                 class="date-picker-icon" style="cursor:pointer"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location" class="form-label">Location</label>
                        <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" class="form-input">
                            <option value="All">All</option>
                            <?php
                            $query1 = "select locationname,locationcode from master_location order by auto_number desc";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $loccode=array();
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $locationname = $res1["locationname"];
                                $locationcode = $res1["locationcode"];
                                ?>
                                <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>>
                                    <?php echo $locationname; ?>
                                </option>
                                <?php
                            } 
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" 
                               onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" 
                               style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" />
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i>
                            Search Statements
                        </button>
                        <button name="resetbutton" type="reset" id="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div class="results-section">
                <div class="results-header">
                    <h3 class="results-title">Doctor Statement Results</h3>
                    <div class="results-actions">
                        <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                    </div>
                </div>
                
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Doctor</th>
                            <th>Patient</th>
                            <th>Bill No.</th>
                            <th>Ref No.</th>
                            <th>Account</th>
                            <th>Bill Date</th>
                            <th>Bill Type</th>
                            <th>Allotted</th>
                            <th>Org. Bill</th>
                            <th>Percentage</th>
                            <th>Doc. Share</th>
                            <th>Bal. Amt</th>
                            <th>30 days</th>
                            <th>60 days</th>
                            <th>90 days</th>
                            <th>120 days</th>
                            <th>180 days</th>
                            <th>180+ days</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php 
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
				$colorcode = "";
				$openingcreditamount = 0;
				$openingdebittamount = 0;
				$openingbalance=0;
				$fulltotal = 0;
				$fulltotalamount30 = 0;
				$fulltotalamount60 =0;
				$fulltotalamount90 = 0;
				$fulltotalamount120 = 0;
				$fulltotalamount180 = 0;
				$fulltotalamountgreater = 0;
				$snocount_main = 0;
				$snocount_invoice = 0;
				$total_debitamt = 0;
				$totalatorginal = 0;
				$fulltotalatorginal = 0;
				$doct_wise_amt = 0;
				$doct_wise_orgamt = 0;
				if($location=='All')
				{
				$pass_location = "and locationcode !=''";
				}
				else
				{
				$pass_location = "and locationcode ='$location'";
				}
					
				if (isset($_REQUEST["searchsuppliername"])) { $suppliername = $_REQUEST["searchsuppliername"]; } else { $suppliername = ""; }
				if (isset($_REQUEST["searchsuppliercode"])) {  $suppliercode = $_REQUEST["searchsuppliercode"]; } else { $suppliercode = ""; }
					$arraysupplier = explode("#", $suppliername);
					$suppliername = $arraysupplier[0];
					$suppliername = trim($suppliername);
					$res21accountname = $suppliername ;
					$snocount = 0;
					if($suppliername !="")
					{
					$query233 = "select doccoa,description as doctorname from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' $pass_location group by doccoa order by recorddate,docno ";
					}
					else
					{
					$query233 = "select doccoa,description as doctorname from billing_ipprivatedoctor where amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' $pass_location group by doccoa order by recorddate,docno ";
				    }
					
					$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
			//$num233=mysql_num_rows($exec233);
			
			while($res233 = mysqli_fetch_array($exec233))	
			{
				$snocount_invoice=0;
			$suppliercode = $res233['doccoa'];
			$doctorname = $res233['doctorname'];
			$snocount_main = $snocount_main + 1;
			
			
			?>
		<tr class="doctor-header-row">
            <td colspan="19" class="doctor-header-cell">
                <strong><?php echo htmlspecialchars($doctorname);?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>)</strong>
            </td>
        </tr>
           
			<?php
			// Get all invoices for the doctor
			
			// $doctor_invoice_qry = "select docno,billtype,patientname,visitcode,visittype from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' group by doccoa order by recorddate,docno";
			// $exec_invoice = mysql_query($doctor_invoice_qry) or die ("Error in Doctor Invoices Query".mysql_error());
			// while($res234 = mysql_fetch_array($exec_invoice))	
			if(1)	
			{
			// 	$snocount = 0;	
			// 	$invoiceno = $resinvoice['docno'];
			// 	$doccoa = $resinvoice['doccoa'];
			// 	$billtype = $resinvoice['billtype'];
			// 	$patientname = $resinvoice['patientname'];
			// 	$res45visitcode = $resinvoice['visitcode'];
			// 	$query11 = "SELECT billtype from master_visitentry where visitcode = '$res45visitcode'  ";
			// 	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
			// 	$res11 = mysql_fetch_array($exec11);
			// 	$num11 =mysql_num_rows($exec11);
			// 	if($num11 ==0)
			// 	{
			// 	$query11 = "SELECT billtype from master_ipvisitentry where  visitcode = '$res45visitcode' ";
			// 	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
			// 	$res11 = mysql_fetch_array($exec11);
			// 	$num11 =mysql_num_rows($exec11);
			// 	if($num11 ==1)
			// 	    { $billtype = $res11['billtype']; }
			// 	}else{
			// 	$billtype = $res11['billtype'];}
			// 	 // get visit type
			// 	  $visittype = $resinvoice['visittype'];
			// 	// get sub type
			// 	  $subtypename = getsubtype($res45visitcode,$visittype);
			// 		$colorloopcount = $colorloopcount + 1;
			// $showcolor = ($colorloopcount & 1); 
			// if ($showcolor == 0)
			// {
			// 	$colorcode = 'bgcolor="#CBDBFA"';
			// }
			// else
			// {
			// 	$colorcode = 'bgcolor="#ecf0f5"';
			// }
				// OB1
					
					// $querycr1op = "SELECT SUM(`transactionamount`) as openingbalance  FROM `billing_ipprivatedoctor` WHERE doccoa='$suppliercode'  AND `recorddate` <  '$ADate1' and visittype='OP' and amount <> '0.00' and amount > 0  and docno <> ''";
					// 	$execcr1 = mysql_query($querycr1op) or die ("Error in querycr1op".mysql_error());
					// 	$rescr1 = mysql_fetch_array($execcr1);
					// 	$openingbalance = $rescr1['openingbalance']; 
					// $querycr1ip = "SELECT SUM(`sharingamount`) as openingbalance1  FROM `billing_ipprivatedoctor` WHERE doccoa='$suppliercode'  AND `recorddate` <  '$ADate1' and visittype='IP' and amount <> '0.00' and amount > 0  and docno <> ''";
					// 	$execcr12 = mysql_query($querycr1ip) or die ("Error in querycr1ip".mysql_error());
					// 	$rescr12 = mysql_fetch_array($execcr12);
					// 	$openingbalance1 = $rescr12['openingbalance1']; 
					// 	$openingbalance =$openingbalance +$openingbalance1;
					// 	$query_refunds = "SELECT IFNULL(SUM(`transactionamount`),0) as openingbalance_r  FROM `billing_ipprivatedoctor_refund` WHERE doccoa='$suppliercode'  AND `recorddate` <  '$ADate1'  and amount <> '0.00' and amount > 0  and docno <> ''";
					// 	//  and visittype='OP'
					// 	$exec_refunds = mysql_query($query_refunds) or die ("Error in querycr1ip".mysql_error());
					// 	$res_refunds = mysql_fetch_array($exec_refunds);
					// 	 $openingbalance_ref = $res_refunds['openingbalance_r']; 
					//      $openingbalance =$openingbalance - $openingbalance_ref;
					//      ////////// debits and credits ////////
					//       $query = "SELECT IFNULL(sum(transactionamount), 0) as opbaldebit  from master_transactiondoctor where doctorcode='$suppliercode' and transactiondate <'$ADate1' and debit_reference_no IS NULL" ;
					//             $exec_dr = mysql_query($query) or die ("Error in querycr1ip".mysql_error());
					//             $res_dr = mysql_fetch_array($exec_dr);
					//             $openingbalance_deb = $res_dr['opbaldebit']; 
					//             // doctor debit note
					//             $query_note = "SELECT IFNULL(sum(amount), 0) as docamt  from adhoc_debitnote where billingaccountcode = '$suppliercode' and consultationdate < '$ADate1'";
					//              $exec_note = mysql_query($query_note) or die ("Error in querycr1ip".mysql_error());
					//             $res_note = mysql_fetch_array($exec_note);
					//             $openingbalance_p = $res_note['docamt']; 
					//              $query_note = "SELECT IFNULL(sum(amount), 0) as docamt  from adhoc_creditnote where billingaccountcode = '$suppliercode' and consultationdate < '$ADate1'";
					//              //echo $query_note;
					//              $exec_note = mysql_query($query_note) or die ("Error in querycr1ip".mysql_error());
					//             $res_note = mysql_fetch_array($exec_note);
					//             $openingbalance_m = $res_note['docamt']; 
					           
					//             $openingbalance_doct_debcre = $openingbalance_p - $openingbalance_m;
					//      ////////// debits and credits ////////
					//             $openingbalance =$openingbalance - $openingbalance_deb + $openingbalance_doct_debcre;
				$openingbalance=0;
				  // OB
					//$query234 = "select * from billing_ipprivatedoctor where doccoa='$suppliercode' and docno ='$doccoa' and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2' and docno <> '' order by recorddate,docno ";
					// $query234 = "select recorddate,docno,billtype,visitcode,patientname,patientcode,accountname,visittype,sum(sharingamount) as sharingamount,percentage,sum(transactionamount) as transactionamount,pvtdr_percentage,sum(original_amt) as original_amt,locationcode from billing_ipprivatedoctor where doccoa='$suppliercode' and docno ='$invoiceno'  and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' group by docno,doccoa order by recorddate,docno ";
					// $query234 = "SELECT coa, recorddate,docno,billtype,visitcode,patientname,patientcode,accountname,visittype,sum(sharingamount) as sharingamount,percentage,sum(transactionamount) as transactionamount,pvtdr_percentage,sum(original_amt) as original_amt,locationcode from billing_ipprivatedoctor where doccoa='$suppliercode' and docno ='$invoiceno' and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' group by docno,doccoa order by recorddate,docno ";
		   $openingbalance=0;
		   
		  $query234 = "SELECT mainset.* from (
		  (select recorddate as transdate,docno as documentno,billtype,visitcode,patientname,patientcode,accountname,visittype,sum(sharingamount) as sharingamount,percentage,sum(transactionamount) as transactionamount,pvtdr_percentage,sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor' as transtable,'' as against_refno   from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' $pass_location group by docno,doccoa order by recorddate,docno)
           union (select transactiondate as transdate,docno as documentno,'' as billtype,visitcode,patientname,patientcode,accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable,billnumber as against_refno  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$suppliercode' and transactiondate between '$ADate1' and '$ADate2' $pass_location order by transactiondate,auto_number) 
		   
		   union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage,amount as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_creditnote' as transtable,ref_no as against_refno from adhoc_creditnote where billingaccountcode = '$suppliercode' and consultationdate between '$ADate1' and '$ADate2' $pass_location  order by consultationdate) 
		   
		   union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage,amount as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_debitnote' as transtable,ref_no as against_refno from adhoc_debitnote where billingaccountcode = '$suppliercode' and consultationdate between '$ADate1' and '$ADate2' $pass_location order by consultationdate) 
		   -- for ADP bills
           union (select transactiondate as transdate,docno as documentno,'' as billtype,'' as visitcode,'' as patientname,'' as patientcode, '' as accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, '0' as taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable,'' as ref_no  from advance_payment_entry where  ledger_code='$suppliercode' and recordstatus<>'deleted' and transactiondate between '$ADate1' and '$ADate2' $pass_location order by transactiondate,auto_number)
          union (SELECT recorddate as transdate,docno as documentno,billtype, visitcode visitcode,patientname,patientcode,accountname,visittype as visittype,sum(sharingamount) as sharingamount,percentage as percentage,sum(transactionamount) as transactionamount,pvtdr_percentage as pvtdr_percentage, sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor_refund' as transtable,against_refbill as against_refno from billing_ipprivatedoctor_refund where doccoa = '$suppliercode' and recorddate between '$ADate1' and '$ADate2' $pass_location group by docno,doccoa order by recorddate,docno)
        ) mainset order by transdate";
		 
			$exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num234=mysqli_num_rows($exec234);
			
$res45billamount=0;	
			while($res234 = mysqli_fetch_array($exec234))
			{
			$res45patientname = $res234['patientname'];
			$res45patientcode = $res234['patientcode'];
			$res45accountname = $res234['accountname'];
			$refno = $res234['refno'];
			$res45vistype = $res234['visittype'];
			$against_refno=$res234['against_refno'];
			$transtable = $res234['transtable'];
 			 
				$invoiceno = $res234['documentno'];
				// $doccoa = $res234['doccoa'];
				$billtype = $res234['billtype'];
				$patientname = $res234['patientname'];
				$res45visitcode = $res234['visitcode'];
				////////////
					$query11 = "SELECT billtype from master_visitentry where visitcode = '$res45visitcode'  ";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
				$num11 =mysqli_num_rows($exec11);
				if($num11 ==0)
				{
				$query11 = "SELECT billtype from master_ipvisitentry where  visitcode = '$res45visitcode' ";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
				$num11 =mysqli_num_rows($exec11);
				if($num11 ==1)
				    { $billtype = $res11['billtype']; }
				}else{
				$billtype = $res11['billtype'];}
				 // get visit type
				  $visittype = $res234['visittype'];
				// get sub type
				  $subtypename = getsubtype($res45visitcode,$visittype);
				////////////
				//echo "%kkk".$res45doctorperecentage='0.00';
					
                
				$total = '0.00';
				$totalat = '0.00';
				$totalat1 = '0.00';
				$totalamount30 = 0;
			$totalamount60 = 0;
			$totalamount90 = 0;
			$totalamount120 = 0;
			$totalamount180 = 0;
      $totalamountgreater = 0;
				
				$res45transactiondate = $res234['transdate'];
				$billnumber = $res234['documentno'];
				$transtable = $res234['transtable'];
				$res45billamount = $res234['original_amt'];
				$res45vistype = $res234['visittype'];
				$res45vistype = $res234['visittype'];
				$res45transactionamount = $res234['transactionamount'];
				
				
            
        if($transtable == 'billing_ipprivatedoctor')
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
              
              $description = "Towards Bill ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname." )";
             
      
         }
         ///////////// CASH REFUNDS/////////////
         if($transtable == 'billing_ipprivatedoctor_refund')
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
              $description = "Towards Bill ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname." )";
			  
			  
         }
         ///////////// CASH REFUNDS/////////////
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
             
        }
		
		///////////date filter works likes this////
        if($res45transactiondate==''){
           $res45transactiondate = $res234['transdate'];
        }
					
         if($transtable == 'adhoc_creditnote')
        {
         $description =  "Credit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";
		$res45doctorperecentage ='100.00';
		
		
        
       }
        if($transtable == 'adhoc_debitnote')
        {
         $description =  "Debit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";
		
		$res45doctorperecentage ='100.00';
        
       }
        $res45locationcode = $res234['locationcode'];
        /////////////////
			 $t1 = strtotime($ADate2);
		  $t2 = strtotime($res45transactiondate);
		  $days_between = ceil(abs($t1 - $t2) / 86400);
	
		    $t1 = strtotime($ADate2);
       $t2 = strtotime($res45transactiondate);
       $days_between = ceil(abs($t1 - $t2) / 86400);
       $snocount = $snocount + 1;
       $res2transactionamount =  $res45transactionamount;
        $debit_total = 0;
        if($days_between < 30)
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
      else if(($days_between >=30) && ($days_between <=60))
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
      else if(($days_between >90) && ($days_between <=120))
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
$alloted_status = "No";
			  $bal_amt = $totalat - $total_debitamt;
			   if($billtype == 'PAY LATER')
			   {
			   		 $transc_amt = 0;
					$query27 = "select sum(billbalanceamount) as billbalanceamount from master_transactionpaylater where billnumber='$invoiceno' and (recordstatus='allocated' || recordstatus='') and transactionstatus <> 'onaccount' and acc_flag = '0'  and transactiontype='PAYMENT'";
					//$query27 = "select billbalanceamount from master_transactionpaylater where billnumber='$invoiceno' and (recordstatus='allocated' || recordstatus='') and transactionstatus <> 'onaccount' and acc_flag = '0'  and transactiontype='PAYMENT' order by auto_number desc limit 0,1";
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
					if($billtype == 'PAY NOW' || strpos( $billnumber, "CF-" ) !== false)
					{
					$alloted_status = "Fully";
					}
		 	//$alloted_status = "yes";
					
					 if($totalat !=0){
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
            $totalatorginal=$totalat;
					 	$doct_wise_amt = $doct_wise_amt + $totalat;
					$doct_wise_orgamt = $doct_wise_orgamt + $totalatorginal;
					//$transtable.'-'.
			?>
		 
			 <tr>
              <td><?php echo $snocount_invoice = $snocount_invoice+1; ?></td>
              <td><?php echo htmlspecialchars($doctorname); ?></td>
              <td><?php 
                  if($patientname==''){
                         echo "PAYMENT (".htmlspecialchars($res234['particulars'])." )";
                  }else{
                   echo htmlspecialchars($patientname); 
                  }
                   ?></td>
              <td><?php echo htmlspecialchars($invoiceno); ?></td>
              <td><?php echo htmlspecialchars($against_refno);?></td>
              <td><?php echo htmlspecialchars($subtypename); ?></td>
              <td class="table-date"><?php echo $res45transactiondate; ?></td>
              <td><?php echo htmlspecialchars($billtype); ?></td>
              <td><span class="table-status <?php echo strtolower($alloted_status); ?>"><?php echo $alloted_status ?></span></td>
              <td class="table-number"><?php echo number_format($res45billamount,2,'.',','); ?></td>
              <td class="table-number"><?php echo $res45doctorperecentage ?></td>
              <td class="table-number"><?php echo number_format($totalatorginal,2,'.',','); ?></td>
              <td class="table-number"><?php echo number_format($totalat,2,'.',','); ?></td>
              <td class="table-number aging-30"><?php echo number_format($totalamount30,2,'.',','); ?></td>
              <td class="table-number aging-60"><?php echo number_format($totalamount60,2,'.',','); ?></td>
              <td class="table-number aging-90"><?php echo number_format($totalamount90,2,'.',','); ?></td>
              <td class="table-number aging-120"><?php echo number_format($totalamount120,2,'.',','); ?></td>
              <td class="table-number aging-180"><?php echo number_format($totalamount180,2,'.',','); ?></td>
              <td class="table-number aging-180-plus"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>
           </tr>
           <?php  
           $grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
			
			$fulltotal = $fulltotal + $totalat;
			$fulltotalamount30 = $fulltotalamount30 + $totalamount30;
			$fulltotalamount60 = $fulltotalamount60 + $totalamount60;
			$fulltotalamount90 = $fulltotalamount90 + $totalamount90;
			$fulltotalamount120 = $fulltotalamount120 + $totalamount120;
			$fulltotalamount180 = $fulltotalamount180 + $totalamount180;
			$fulltotalamountgreater = $fulltotalamountgreater + $totalamountgreater;
			$fulltotalatorginal = $fulltotalatorginal + $totalatorginal;
       }?>
			
           <?php 
            $doctor_arr[] = $suppliercode;
          
          
          /* $grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
			
			$fulltotal = $fulltotal + $totalat;
			$fulltotalamount30 = $fulltotalamount30 + $totalamount30;
			$fulltotalamount60 = $fulltotalamount60 + $totalamount60;
			$fulltotalamount90 = $fulltotalamount90 + $totalamount90;
			$fulltotalamount120 = $fulltotalamount120 + $totalamount120;
			$fulltotalamount180 = $fulltotalamount180 + $totalamount180;
			$fulltotalamountgreater = $fulltotalamountgreater + $totalamountgreater;
			$fulltotalatorginal = $fulltotalatorginal + $totalatorginal;*/
           ?>
		   
         <?php 
			}
         	} // loop invoices
         	?>
          
            	
            <tr class="summary-row">
            	<td colspan="7">&nbsp;</td>
             	<td colspan="4">Sub Total</td>
                <td class="table-number"><?php echo number_format($doct_wise_orgamt,2,'.',','); ?></td>
				<td class="table-number"><?php echo number_format($doct_wise_amt,2,'.',','); ?></td>
                <td colspan="7">&nbsp;</td>
           </tr>
            <?php 
            $doct_wise_amt =0;$doct_wise_orgamt =0;
        	//}
            
			
			
          } // loop doctors
         
          ?>
         <tr class="total-row">
         	<td colspan="7"></td>
            <td colspan="4"><strong>Total</strong></td>
            <td class="table-number"><strong><?php echo number_format($fulltotalatorginal,2,'.',','); ?></strong></td>
            <td class="table-number"><strong><?php echo number_format($fulltotal,2,'.',','); ?></strong></td>
            <td class="table-number"><strong><?php echo number_format($fulltotalamount30,2,'.',','); ?></strong></td>
            <td class="table-number"><strong><?php echo number_format($fulltotalamount60,2,'.',','); ?></strong></td>
            <td class="table-number"><strong><?php echo number_format($fulltotalamount90,2,'.',','); ?></strong></td>
            <td class="table-number"><strong><?php echo number_format($fulltotalamount120,2,'.',','); ?></strong></td>
            <td class="table-number"><strong><?php echo number_format($fulltotalamount180,2,'.',','); ?></strong></td>
            <td class="table-number"><strong><?php echo number_format($fulltotalamountgreater,2,'.',','); ?></strong></td>
           </tr>
                    </tbody>
                </table>
                
                <!-- Export Section -->
                <div class="export-section">
                    <?php
                    $urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliercode=$suppliercode&&searchsuppliername=$suppliername&&location=$location";
                    ?>
                    <a href="fulldrstatementdetail_excel.php?<?php echo $urlpath; ?>" class="export-btn">
                        <i class="fas fa-file-excel"></i>
                        Export to Excel
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
<?php }
function getsubtype($visitcode,$visittype='')
{
	
	$subtypeid = 0;
	$subtypename = "";
	if(trim($visittype) =="")
	{
		
		$haystack = $visitcode;
		$needle   = "IPV";
		if( strpos( $haystack, $needle ) !== false) {
		    $visittype = "IP";
		}
		else
		{
			$visittype = "OP";
		}
	}
	if($visittype == 'OP')
	{
		$queryacc = "select subtype from master_visitentry where visitcode='$visitcode'";
		$execacc = mysqli_query($GLOBALS["___mysqli_ston"], $queryacc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$resacc = mysqli_fetch_array($execacc);
		$subtypeid = $resacc['subtype'];
		
	}
	else
	{
		$queryacc = "select subtype from master_ipvisitentry where visitcode='$visitcode'";
		$execacc = mysqli_query($GLOBALS["___mysqli_ston"], $queryacc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$resacc = mysqli_fetch_array($execacc);
		$subtypeid = $resacc['subtype'];
	}
	if($subtypeid > 0)
		{
			$queryaccsub = "select subtype from master_subtype where auto_number='$subtypeid'";
			$execaccsub = mysqli_query($GLOBALS["___mysqli_ston"], $queryaccsub) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resaccsub = mysqli_fetch_array($execaccsub);
			$subtypename = $resaccsub['subtype'];
		}
	return $subtypename;
}
?>