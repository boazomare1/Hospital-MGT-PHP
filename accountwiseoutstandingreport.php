<?php
// Enable strict error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session and include security files
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

// Set timezone
date_default_timezone_set('Asia/Calcutta'); 

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Initialize variables with proper sanitization
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$companyanum = isset($_SESSION['companyanum']) ? $_SESSION['companyanum'] : '';
$companyname = isset($_SESSION['companyname']) ? $_SESSION['companyname'] : '';

// Date range defaults
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$daysafterbilldate = "";
$totalsum = "0.00";
$searchsuppliername = '';

// Input sanitization function
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// CSRF Token generation
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
}

// CSRF Token validation function
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $token;
}

// Handle form submissions with CSRF protection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        die('CSRF token validation failed');
    }
    
    // Sanitize POST data
    $transactiondatefrom = isset($_POST['transactiondatefrom']) ? sanitizeInput($_POST['transactiondatefrom']) : $transactiondatefrom;
    $transactiondateto = isset($_POST['transactiondateto']) ? sanitizeInput($_POST['transactiondateto']) : $transactiondateto;
    $searchsuppliername = isset($_POST['searchsuppliername']) ? sanitizeInput($_POST['searchsuppliername']) : $searchsuppliername;
    $daysafterbilldate = isset($_POST['daysafterbilldate']) ? sanitizeInput($_POST['daysafterbilldate']) : $daysafterbilldate;
}

include ("autocompletebuild_account2.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Account Wise Outstanding Report - MedStar Hospital Management System">
    <meta name="robots" content="noindex, nofollow">
    <title>Account Wise Outstanding Report - MedStar Hospital</title>
    
    <!-- Preload critical resources -->
    <link rel="preload" href="css/accountwiseoutstanding-modern.css" as="style">
    <link rel="preload" href="js/accountwiseoutstanding-modern.js" as="script">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/accountwiseoutstanding-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/autosuggest.css">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "MedStar Hospital Management System",
        "description": "Advanced Healthcare Management Platform - Account Wise Outstanding Report",
        "url": "<?php echo $_SERVER['REQUEST_URI']; ?>",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "Web Browser"
    }
    </script>  

    <!-- Modern JavaScript -->
    <script src="js/accountwiseoutstanding-modern.js?v=<?php echo time(); ?>"></script>
    <script src="js/autocomplete_accounts2.js"></script>
    <script src="js/autosuggest4accounts.js"></script>
</head>



<body>
    <!-- Modern MedStar Hospital Management Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Dashboard</a>
        <span>→</span>
        <span>Reports</span>
        <span>→</span>
        <span>Account Wise Outstanding Report</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <button class="floating-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar" id="mainContainer">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>🏥 MedStar</h3>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Account Main Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Account Sub Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountname1.php" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Account Names</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivable.php" class="nav-link">
                            <i class="fas fa-hand-holding-usd"></i>
                            <span>Receivables</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountwiseoutstandingreport.php" class="nav-link active">
                            <i class="fas fa-chart-pie"></i>
                            <span>Account Wise Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="expenses.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Expenses</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="income.php" class="nav-link">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Income</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbank1.php" class="nav-link">
                            <i class="fas fa-university"></i>
                            <span>Bank Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientmanagement.php" class="nav-link">
                            <i class="fas fa-user-injured"></i>
                            <span>Patient Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultation.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>Consultation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labitems.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="radiology.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Radiology</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employeemanagement.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Employee Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="departmentmanagement.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Department Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="rightsaccess.php" class="nav-link">
                            <i class="fas fa-shield-alt"></i>
                            <span>Employee Rights Access</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Alert Messages -->
            <?php include ("includes/alertmessages1.php"); ?>
            
            <!-- Report Form Section -->
            <section class="report-form-section">
                <div class="section-header">
                    <span class="section-icon">📊</span>
                    <h3 class="section-title">Account Wise Outstanding Report</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="accountwiseoutstandingreport.php" class="report-form">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    
                    <div class="form-layout">
                        <div class="form-group">
                            <label for="transactiondatefrom" class="form-label">From Date *</label>
                            <input name="transactiondatefrom" id="transactiondatefrom" value="<?php echo htmlspecialchars($transactiondatefrom); ?>" class="form-input" readonly>
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('transactiondatefrom')" style="cursor:pointer; margin-left: 5px;"/>
                        </div>
                        
                        <div class="form-group">
                            <label for="transactiondateto" class="form-label">To Date *</label>
                            <input name="transactiondateto" id="transactiondateto" value="<?php echo htmlspecialchars($transactiondateto); ?>" class="form-input" readonly>
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('transactiondateto')" style="cursor:pointer; margin-left: 5px;"/>
                        </div>
                        
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Account Name</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo htmlspecialchars($searchsuppliername); ?>" class="form-input" placeholder="Select account name..." autocomplete="off">
                            <input name="searchdescription" id="searchdescription" type="hidden" value="">
                            <input name="searchemployeecode" id="searchemployeecode" type="hidden" value="">
                            <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
                        </div>
                        
                        <div class="form-group">
                            <label for="daysafterbilldate" class="form-label">Days After Bill Date</label>
                            <input name="daysafterbilldate" id="daysafterbilldate" value="<?php echo htmlspecialchars($daysafterbilldate); ?>" class="form-input" placeholder="Enter days...">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                        <button type="button" onclick="window.print()" class="btn btn-secondary">
                            <i class="fas fa-print"></i> Print Report
                        </button>
                    </div>
                </form>
            </section>

            <!-- Report Results Section -->
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <section class="report-results-section">
                <div class="section-header">
                    <span class="section-icon">📈</span>
                    <h3 class="section-title">Outstanding Report Results</h3>
                </div>
                
                <div class="report-summary">
                    <div class="summary-card">
                        <div class="summary-icon">📅</div>
                        <div class="summary-content">
                            <span class="summary-label">Report Period</span>
                            <span class="summary-value"><?php echo date('M d, Y', strtotime($transactiondatefrom)); ?> - <?php echo date('M d, Y', strtotime($transactiondateto)); ?></span>
                        </div>
                    </div>
                    
                    <?php if ($searchsuppliername): ?>
                    <div class="summary-card">
                        <div class="summary-icon">🏢</div>
                        <div class="summary-content">
                            <span class="summary-label">Account</span>
                            <span class="summary-value"><?php echo htmlspecialchars($searchsuppliername); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="summary-card">
                        <div class="summary-icon">💰</div>
                        <div class="summary-content">
                            <span class="summary-label">Total Outstanding</span>
                            <span class="summary-value">₹ <?php echo number_format($totalsum, 2); ?></span>
                        </div>
                    </div>
                </div>

		   

			 <!-- <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> <strong>Date From</strong> </td>

                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> <strong>Date To</strong> </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                    </tr>	-->

            <tr>

                <!-- Report Data Table will be inserted here -->
                <div class="report-table-container">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Account Name</th>
                                <th>Bill Date</th>
                                <th>Bill Number</th>
                                <th>Amount</th>
                                <th>Outstanding</th>
                                <th>Days Overdue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Report data will be populated here -->
                        </tbody>
                    </table>
                </div>
            </section>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/accountwiseoutstanding-modern.js?v=<?php echo time(); ?>"></script>
    <script src="js/datetimepicker_css.js"></script>

    <?php include ("includes/footer1.php"); ?>
</body>
</html>

		

<?php

	

		if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

			if ($cbfrmflag1 == 'cbfrmflag1')

			{

				if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

?>

		<table 

            cellspacing="0" cellpadding="4" width="656" 

            align="left" border="0">

          <tr>

              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong>S.No.</strong></td>

				  <td width="20%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong>Account</strong></td>

                  <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>Outstanding</strong></div></td>

                  <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>30 Days </strong></div></td>

                  <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>60 Days </strong></div></td>

                  <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>90 Days </strong></div></td>

                  <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>120 Days </strong></div></td>

	     </tr>

		 

            <?php

			$colorloopcount1=0;

	        $sno1=0;

			$totalbalance = 0.00;



			$cashamount21 = 0.00;

			$cardamount21 = '';

			$onlineamount21 = '';

			$chequeamount21 = '';

			$tdsamount21 = '';

			$writeoffamount21 = '';

		    $totalrefundedamount=0;

			$totalnumbr='';

			$totalnumb=0;

			$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$totalpurchase1=0;

			 

			$query222 = "select * from master_accountname where accountname like'%$searchsuppliername%' and recordstatus <> 'DELETED' order by accountname ";

			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res222 = mysqli_fetch_array($exec222))

			{

			$res222accountname=$res222['accountname'];

			$res222accountssub=$res222['accountssub'];

			

			$query2 = "select * from master_accountssub where auto_number = '$res222accountssub' and recordstatus <> 'DELETED' ";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		    $res2 = mysqli_fetch_array($exec2);

			$res2accountssub=$res2['auto_number'];

			$res2accountssub1=$res2['accountssub'];

			$nameofsupplier = $res222accountname;

			

			$query222ip = "select * from master_ipvisitentry where accountfullname ='$nameofsupplier' and discharge = 'completed' and billtype = 'PAY LATER'";

			$exec222ip = mysqli_query($GLOBALS["___mysqli_ston"], $query222ip) or die ("Error in Query222ip".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res222ip = mysqli_fetch_array($exec222ip))

			{

			$res222ipaccountname=$res222ip['accountfullname'];

			$res222ipvisitcode=$res222ip['visitcode'];

			$ipbilldate = $res222ip['registrationdate']; 

			$visitcode = $res222ipvisitcode;

			

			include('accountwiseoutstandingreport1.php');

			}

			

			$query2 = "select * from billing_paylater where accountname = '$nameofsupplier' ";

			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rowcount2 = mysqli_num_rows($exec2);

			

			while ($res2 = mysqli_fetch_array($exec2))

			{

				$suppliername1 = $res2['patientname'];

				$patientcode = $res2['patientcode'];

				$visitcode = $res2['visitcode'];

			    $res2accountname = $res2['accountname'];

		

				$query67="select * from master_customer where customercode='$patientcode'";

				$exec67=mysqli_query($GLOBALS["___mysqli_ston"], $query67);

				$res67=mysqli_fetch_array($exec67);

				$firstname=$res67['customername'];

				$lastname=$res67['customerlastname'];

				$name=$firstname.$lastname;

				$billnumber = $res2['billno'];

				$billdate = $res2['billdate'];

				$billtotalamount = $res2['totalamount'];

				

				$query3 = "select * from master_transactionpaylater where billnumber = '$billnumber' and companyanum='$companyanum' and transactionstatus <> 'onaccount' and transactionmodule = 'PAYMENT' and recordstatus <>'deallocated'";

				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

				$numbr=mysqli_num_rows($exec3);

				while ($res3 = mysqli_fetch_array($exec3))

				{

				    $cashamount1 = $res3['cashamount'];

					$onlineamount1 = $res3['onlineamount'];

					$chequeamount1 = $res3['chequeamount'];

					$cardamount1 = $res3['cardamount'];

					$tdsamount1 = $res3['tdsamount'];

					$writeoffamount1 = $res3['writeoffamount'];

					$cashamount21 = $cashamount21 + $cashamount1;

					

					$cardamount21 = $cardamount21 + $cardamount1;

					$onlineamount21 = $onlineamount21 + $onlineamount1;

					$chequeamount21 = $chequeamount21 + $chequeamount1;

					$tdsamount21 = $tdsamount21 + $tdsamount1;

					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;

				}

			

				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;

				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;

				$balanceamount = $billtotalamount - $netpayment;

				

				$query75="select * from refund_paylater where finalizationbillno='$billnumber' and billstatus='paid'";

			$exec75=mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$rows1=mysqli_num_rows($exec75);

			if($rows1 > 0)

			{

			$res75=mysqli_fetch_array($exec75);

			

			$refundedamount=$res75['totalamount'];

			

			

			$balanceamount=$balanceamount+$refundedamount;

			

			}

				

				$billtotalamount = number_format($billtotalamount, 2, '.', '');

				$netpayment = number_format($netpayment, 2, '.', '');

				$balanceamount = number_format($balanceamount, 2, '.', '');

				

				$billstatus = $billtotalamount.'||'.$netpayment.'||'.$balanceamount;



			

			$billdate = substr($billdate, 0, 10);

			$date1 = $billdate;



			$dotarray = explode("-", $billdate);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$billdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));



			$billtotalamount = number_format($billtotalamount, 2, '.', '');

			$netpayment = number_format($netpayment, 2, '.', '');

			$balanceamount = number_format($balanceamount, 2, '.', '');

			

			$date1 = $date1;

			$date2 = date("Y-m-d");  

			//$date2 = date("2014-10-10");  

			$diff = abs(strtotime($date2) - strtotime($date1));  

			$days = floor($diff / (60*60*24));  

			$daysafterbilldate = $days;

			//$daysafterbilldate = 32;

			//$ipdaysafterbilldate = 61;

			if($daysafterbilldate < $ipdaysafterbilldate){ $daysafterbilldate = 

			$daysafterbilldate; }else{ $daysafterbilldate = $ipdaysafterbilldate; }

			

			$query3 = "select * from master_transactionpaylater where billnumber = '$billnumber' and companyanum='$companyanum' and transactionmodule = 'PAYMENT' and transactionstatus <> 'onaccount' and recordstatus <>'deallocated' order by auto_number desc";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3 = mysqli_fetch_array($exec3);

			 $numb=mysqli_num_rows($exec3);

			 $totalnumb=$totalnumb+$numb;

			 

			$lastpaymentdate = $res3['transactiondate'];

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



			//echo $balanceamount;

			if ($balanceamount != '0.00')

			{

			//$colorloopcount = $colorloopcount + 1;

			//$showcolor = ($colorloopcount & 1); 

			//if ($showcolor == 0)

			//{

				//echo "if";

				//$colorcode = 'bgcolor="#CBDBFA"';

			//}

			//else

			//{

				//echo "else";

				//$colorcode = 'bgcolor="#ecf0f5"';

			//}

			?>

            <?php

				$totalbalance = $totalbalance + $balanceamount;

			}

			}

			

			$query5 = "select * from master_transactionpaylater where accountname = '$nameofsupplier' and transactionstatus = 'onaccount' and transactiontype = 'PAYMENT' ";

			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res5 = mysqli_fetch_array($exec5)){

			$totalbalance = $totalbalance - $res5['transactionamount'];

			}

				//echo $daysafterbilldate;	

				if($totalbalance != '' && ($res2accountssub1 == 'ACCOUNTS RECEIVABLE')) { 	

				$colorloopcount1 = $colorloopcount1 + 1;

				$showcolor1 = ($colorloopcount1 & 1); 

				if ($showcolor1 == 0)

				{

					$colorcode1 = 'bgcolor="#CBDBFA"';

				}

				else

				{

					$colorcode1 = 'bgcolor="#ecf0f5"';

				}

		?>

		         <?php   ?>

                 <tr <?php echo $colorcode1; ?>>

					<td class="bodytext311" valign="center"  align="left"><?php echo $sno1 = $sno1 + 1 ; ?></td> 

					<td class="bodytext311" valign="center"  align="left"	><?php echo $res222accountname; ?></td> 

					<td class="bodytext311" valign="center"  align="right"><?php echo number_format($totalbalance,2,'.',','); ?></td> 

					<td class="bodytext311" valign="center"  align="right"><?php if(($daysafterbilldate >= 0 || $daysafterbilldate == 0) && ($daysafterbilldate < 30)) { echo number_format($totalbalance,2,'.',','); } ?></td>

					<td class="bodytext311" valign="center"  align="right"><?php if($daysafterbilldate > 30 && ($daysafterbilldate < 60)) { echo number_format($totalbalance,2,'.',','); } ?></td>

					<td class="bodytext311" valign="center"  align="right"><?php if($daysafterbilldate > 60 && ($daysafterbilldate < 90)) { echo number_format($totalbalance,2,'.',','); } ?></td>

					<td class="bodytext311" valign="center"  align="right"><?php if($daysafterbilldate > 90 && ($daysafterbilldate < 120)) { echo number_format($totalbalance,2,'.',','); } ?></td>

				</tr>

		         <?php  } ?>

        <?php

		}

		}

		?>

		<tr>

		<?php

			

				$urlpath = "searchsuppliername=$searchsuppliername";

			

			?>

			<td colspan="7" class="bodytext31" valign="center"  align="right"><a href="print_accountwiseoutstandingreport.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>

		</tr>

        </table>

		

		<tr>

			<td>&nbsp;</td>

		</tr>

</table>	  

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



