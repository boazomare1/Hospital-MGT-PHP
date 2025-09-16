<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];



$res2patientname = '';

$searchcustomername = '';

$patientfirstname = '';

$visitcode = '';

$cbvisitcode = '';

$customername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$customername = '';

$paymenttype = '';

$billstatus = '';

$res2loopcount = '';

$custid = '';

$visitcode1='';

$custname = '';

$colorloopcount = '';

$sno = '';

$customercode = '';

$totalsalesamount = '0.00';

$totalsalesreturnamount = '0.00';

$netcollectionamount = '0.00';

$netpaymentamount = '0.00';

$res2total = '0.00';



$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');





 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }



//$getcanum = $_GET['canum'];

$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if ($getcanum != '')

{

	$query4 = "select customername from master_customer where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbcustomername = $res4['customername'];

	$customername = $res4['customername'];

}



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$cbcustomername = $_REQUEST['cbcustomername'];

	$patientfirstname = $cbcustomername;

	$cbvisitcode = $_REQUEST['cbvisitcode'];

	$visitcode = $cbvisitcode;

	$visitcode1 = 10;

	

	if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

	//$cbbillnumber = $_REQUEST['cbbillnumber'];

	if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

	//$cbbillstatus = $_REQUEST['cbbillstatus'];

	

	$transactiondatefrom = $_REQUEST['ADate1'];

	$transactiondateto = $_REQUEST['ADate2'];

	

	if (isset($_REQUEST["paymenttype"])) { $paymenttype = $_REQUEST["paymenttype"]; } else { $paymenttype = ""; }

	//$paymenttype = $_REQUEST['paymenttype'];

	if (isset($_REQUEST["billstatus"])) { $billstatus = $_REQUEST["billstatus"]; } else { $billstatus = ""; }

	//$billstatus = $_REQUEST['billstatus'];

	if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }

	if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }				

$suppliername = '';

					if($searchsupplieranum !='')

					{

					$qryact = mysqli_query($GLOBALS["___mysqli_ston"], "select accountname from master_accountname where auto_number = $searchsupplieranum");

					$resact = mysqli_fetch_assoc($qryact);

					$suppliername = $resact['accountname'];

					}

					if($suppliername == '' && strtoupper($searchsuppliername)=='CASH')

					{

					$suppliername = 'CASH COLLECTIONS';

					}

}

?>

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Consultation Bills - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/viewconsultationbills-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />



</head>

					

//ajax to get location which is selected ends here





function cbcustomername1()

{

	document.cbform1.submit();

}



</script>



<script type="text/javascript" src="js/autosuggest3.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	//var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        

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

</script>

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      

<script>

$(document).ready(function(e) {

   

		$('#searchsuppliername').autocomplete({

		

	

	source:"ajaxaccount_search.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var accountname=ui.item.value;

			var accountid=ui.item.id;

			var accountanum=ui.item.anum;

			$("#searchsuppliercode").val(accountid);

			$("#searchsupplieranum").val(accountanum);

			

			},

    

	});

		

});

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        


</head>



<script>

function loadprintpage1(billnumber)

 {

 var printbillnumber=billnumber;



var popWin; 

popWin = window.open("print_consultationbill_dmp4inch1.php?billautonumber="+printbillnumber+"","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 

 }

</script>



<script src="js/datetimepicker_css.js"></script>



<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">View Consultation Bills</p>
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
        <span>Consultations</span>
        <span>→</span>
        <span>View Bills</span>
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
                        <a href="cashradiologyrefund.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Cash Radiology Refund</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cashrefundapprovallist.php" class="nav-link">
                            <i class="fas fa-check-circle"></i>
                            <span>Refund Approval List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chequescollected.php" class="nav-link">
                            <i class="fas fa-money-check"></i>
                            <span>Cheques Collected</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="claimtxnidedit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Claim Transaction Edit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payrollprocess1.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Process</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stockreportbyitem3.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Stock Report by Item</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="paymentmodecollectionsummary.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Payment Mode Collection Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="paymentmodecollectionbyuser.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Payment Mode Collection by User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="revenuereport_summary.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Revenue Report Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="comparativereport.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Comparative Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payrollcomponentreport1.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Payroll Component Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="iframeconsultationlist.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>Consultation List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="viewconsultationbills.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>View Consultation Bills</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>View Consultation Bills</h2>
                    <p>Search and view consultation bills with detailed billing information and payment details.</p>
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
            <div class="search-form-section">
                <div class="search-form-header">
                    <h3 class="search-form-title">🔍 Search Consultation Bills</h3>
                    <div class="search-form-actions">
                        <button type="button" class="btn btn-outline" onclick="printReport()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>

                <form name="cbform1" method="post" action="viewconsultationbills.php" class="search-form">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Search Account</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" value="" class="form-input" autocomplete="off">
                            <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="" />
                            <input name="searchsupplieranum" type="hidden" id="searchsupplieranum" value="" />
                        </div>
                        
                        <div class="form-group">
                            <label for="cbcustomername" class="form-label">Search Patient</label>
                            <input name="cbcustomername" type="text" id="cbcustomername" value="" class="form-input" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="cbvisitcode" class="form-label">Visit Code</label>
                            <input name="cbvisitcode" type="text" id="cbvisitcode" value="" class="form-input" onKeyDown="return disableEnterKey()">
                        </div>
                        
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-select" onChange="ajaxlocationfunction(this.value);">
                                <?php
                                $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                ?>
                                <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" class="form-input" readonly onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" class="form-input" readonly onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-outline">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <a target="_blank" href="print_consultationbillsreport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&user=<?php echo $cbcustomername; ?>&&visitcode=<?php echo $cbvisitcode; ?>&&locationcode=<?php echo $locationcode1; ?>&&account=<?php echo $suppliername; ?>" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Excel Export
                        </a>
                    </div>

                </form>
            </div>

            <!-- Results Section -->
            <div class="results-section">
                <div class="results-header">
                    <h3 class="results-title">📋 Consultation Bills Results</h3>
                    <div class="results-actions">
                        <button type="button" class="btn btn-outline" onclick="printReport()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>

                <?php
                if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
                
                if ($cbfrmflag1 == 'cbfrmflag1') {
                    $cbcustomername = $_REQUEST['cbcustomername'];
                    $patientfirstname = $cbcustomername;
                    $customername = $_REQUEST['cbcustomername'];
                    
                    if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
                    if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
                    if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }
                    if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
                    
                    $suppliername = '';
                    if($searchsupplieranum !='') {
                        $qryact = mysqli_query($GLOBALS["___mysqli_ston"], "select accountname from master_accountname where auto_number = $searchsupplieranum");
                        $resact = mysqli_fetch_assoc($qryact);
                        $suppliername = $resact['accountname'];
                    }
                    if($suppliername == '' && strtoupper($searchsuppliername)=='CASH') {
                        $suppliername = 'CASH COLLECTIONS';
                    }
                    
                    $transactiondatefrom = $_REQUEST['ADate1'];
                    $transactiondateto = $_REQUEST['ADate2'];
                    $locationcode1 = $_REQUEST['location'];
                }
                ?>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Print</th>
                            <th>Patient</th>
                            <th>Reg No.</th>
                            <th>Visit Code</th>
                            <th>Bill Date</th>
                            <th>Account</th>
                            <th>Department</th>
                            <th>Consultation Type</th>
                            <th>Consultation Fees</th>
                            <th>Copay Amount</th>
                            <th>Copay%</th>
                            <th>Payment Mode</th>
                        </tr>
                    </thead>
                    <tbody>

			<?php

			$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			if ( $visitcode1 == 10)

			{

			$query2 = "select patientcode,visitcode,billingdatetime,patientfirstname,patientmiddlename,patientlastname,accountname,department,consultingdoctor,consultationtype,consultationfees,totalamount,copaypercentageamount,transactionmode,billnumber from master_billing where  patientfullname like '%$patientfirstname%' and visitcode like '%$visitcode%'and billingdatetime between '$transactiondatefrom' and '$transactiondateto'  and accountname like '%$suppliername%' and  locationcode='$locationcode1'  order by billnumber desc";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res2 = mysqli_fetch_array($exec2))

			{

			$res2patientcode = $res2['patientcode'];

			$res2visitcode = $res2['visitcode'];

			$res2billingdatetime = $res2['billingdatetime'];

			$res2patientfirstname = $res2['patientfirstname'];

			$res2patientmiddlename = $res2['patientmiddlename'];

			$res2patientlastname = $res2['patientlastname'];

			$res2accountname = $res2['accountname'];

			$res2department = $res2['department'];

			$res2consultingdoctor = $res2['consultingdoctor'];

			$res2consultationtype = $res2['consultationtype'];

			$res2consultationfees = $res2['consultationfees'];

			$res2copayfixedamount = $res2['totalamount'];

			$res2copaypercentageamount = $res2['copaypercentageamount'];

			$res2patientpaymentmode = $res2['transactionmode'];

			$res2billnumber = $res2['billnumber'];

		    $res2patientname = $res2patientfirstname.' '.$res2patientmiddlename.' '.$res2patientlastname;

			

			$query4 = "select consultationtype from master_consultationtype where auto_number = '$res2consultationtype'";

		    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res4 = mysqli_fetch_array($exec4);

		    $res4consultationtype = $res4['consultationtype'];

			

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

                        <tr class="<?php echo ($showcolor == 0) ? 'even-row' : 'odd-row'; ?>">
                            <td><?php echo $sno = $sno + 1; ?></td>
                            <td>
                                <a href="javascript:loadprintpage1('<?php echo $res2billnumber; ?>')" class="print-link">
                                    <i class="fas fa-print"></i> Print
                                </a>
                            </td>
                            <td class="patient-name"><?php echo htmlspecialchars($res2patientname); ?></td>
                            <td><?php echo htmlspecialchars($res2patientcode); ?></td>
                            <td><?php echo htmlspecialchars($res2visitcode); ?></td>
                            <td class="date-badge"><?php echo htmlspecialchars($res2billingdatetime); ?></td>
                            <td><?php echo htmlspecialchars($res2accountname); ?></td>
                            <td><?php echo htmlspecialchars($res2department); ?></td>
                            <td><?php echo htmlspecialchars($res4consultationtype); ?></td>
                            <td class="amount-cell amount-positive"><?php echo number_format($res2consultationfees,2,'.',','); ?></td>
                            <td class="amount-cell"><?php echo htmlspecialchars($res2copayfixedamount); ?></td>
                            <td class="amount-cell"><?php echo htmlspecialchars($res2copaypercentageamount); ?></td>
                            <td><?php echo htmlspecialchars($res2patientpaymentmode); ?></td>
                        </tr>

			<?php

			}

			}
                ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/viewconsultationbills-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



