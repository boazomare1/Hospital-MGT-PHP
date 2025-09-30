<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$res15amount = '0.00';
$sumoftotalearnings = '0';
$componentvalue = 0;

$month = date('M-Y');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['pinnumber'];
$companyname = $res81['employername'];

// Handle form submission
if (isset($_REQUEST["frmflag1"])) { 
    $frmflag1 = $_REQUEST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if (isset($_REQUEST["searchemployee"])) { 
    $searchemployee = $_REQUEST["searchemployee"]; 
} else { 
    $searchemployee = ""; 
}

if (isset($_REQUEST["searchmonth"])) { 
    $searchmonth = $_REQUEST["searchmonth"]; 
} else { 
    $searchmonth = date('M'); 
}

if (isset($_REQUEST["searchyear"])) { 
    $searchyear = $_REQUEST["searchyear"]; 
} else { 
    $searchyear = date('Y'); 
}

if (isset($_REQUEST["searchbank"])) { 
    $searchbank = $_REQUEST["searchbank"]; 
} else { 
    $searchbank = ""; 
}

// Check for URL messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'success') {
        $errmsg = "Payroll report generated successfully.";
        $bgcolorcode = 'success';
    } elseif ($_GET['msg'] == 'failed') {
        $errmsg = "Failed to generate payroll report.";
        $bgcolorcode = 'failed';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/payroll-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
    <script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script src="js/datetimepicker1_css.js"></script>
    
    <script language="javascript">
    function process1backkeypress1() {
        if (event.keyCode==8) {
            event.keyCode=0; 
            return event.keyCode 
            return false;
        }
    }

    function captureEscapeKey1() {
        if (event.keyCode==8) {
            // Handle escape key if needed
        }
    }

    function from1submit1() {
        // Form validation if needed
        return true;
    }

    window.onload = function () {
        var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
    }
    </script>
</head>
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
        <span>Payroll Report</span>
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
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="openingstockentry_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Opening Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="corporateoutstanding.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Corporate Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_acquisition_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Acquisition</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartofaccounts_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Chart of Accounts Upload</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountsmaindataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Main Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountssubdataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Sub Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbloodgroup.php" class="nav-link">
                            <i class="fas fa-tint"></i>
                            <span>Blood Group Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addfoodallergy1.php" class="nav-link">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Food Allergy Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addgenericname.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Generic Name Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addpromotion.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Promotion Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addsalutation1.php" class="nav-link">
                            <i class="fas fa-user-tie"></i>
                            <span>Salutation Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="payrollmonthwiseinterim.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Report</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if (!empty($errmsg)): ?>
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'failed' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'failed' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Payroll Report</h2>
                    <p>Generate and view comprehensive payroll reports for employees by month and year.</p>
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
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Payroll Report Search</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="payrollmonthwiseinterim.php" onSubmit="return from1submit1()" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchbank" class="form-label">Search Bank</label>
                            <input type="text" name="searchbank" id="searchbank" class="form-input" 
                                   autocomplete="off" value="<?php echo htmlspecialchars($searchbank); ?>" 
                                   placeholder="Enter bank name to filter">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchemployee" class="form-label">Search Employee</label>
                            <input type="hidden" name="autobuildemployee" id="autobuildemployee">
                            <input type="hidden" name="searchemployeecode" id="searchemployeecode">
                            <input type="text" name="searchemployee" id="searchemployee" class="form-input" 
                                   autocomplete="off" value="<?php echo htmlspecialchars($searchemployee); ?>" 
                                   placeholder="Enter employee name to search">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchmonth" class="form-label">Month</label>
                            <select name="searchmonth" id="searchmonth" class="form-input">
                                <option value="Jan" <?php echo ($searchmonth == 'Jan') ? 'selected' : ''; ?>>January</option>
                                <option value="Feb" <?php echo ($searchmonth == 'Feb') ? 'selected' : ''; ?>>February</option>
                                <option value="Mar" <?php echo ($searchmonth == 'Mar') ? 'selected' : ''; ?>>March</option>
                                <option value="Apr" <?php echo ($searchmonth == 'Apr') ? 'selected' : ''; ?>>April</option>
                                <option value="May" <?php echo ($searchmonth == 'May') ? 'selected' : ''; ?>>May</option>
                                <option value="Jun" <?php echo ($searchmonth == 'Jun') ? 'selected' : ''; ?>>June</option>
                                <option value="Jul" <?php echo ($searchmonth == 'Jul') ? 'selected' : ''; ?>>July</option>
                                <option value="Aug" <?php echo ($searchmonth == 'Aug') ? 'selected' : ''; ?>>August</option>
                                <option value="Sep" <?php echo ($searchmonth == 'Sep') ? 'selected' : ''; ?>>September</option>
                                <option value="Oct" <?php echo ($searchmonth == 'Oct') ? 'selected' : ''; ?>>October</option>
                                <option value="Nov" <?php echo ($searchmonth == 'Nov') ? 'selected' : ''; ?>>November</option>
                                <option value="Dec" <?php echo ($searchmonth == 'Dec') ? 'selected' : ''; ?>>December</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="searchyear" class="form-label">Year</label>
                            <select name="searchyear" id="searchyear" class="form-input">
                                <?php
                                $currentYear = date('Y');
                                for ($year = $currentYear - 5; $year <= $currentYear + 1; $year++) {
                                    $selected = ($searchyear == $year) ? 'selected' : '';
                                    echo "<option value='$year' $selected>$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group form-group-submit">
                            <button type="submit" name="Search" class="submit-btn">
                                <i class="fas fa-search"></i>
                                Generate Report
                            </button>
                            <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Payroll Report Results -->
            <?php if ($frmflag1 == 'frmflag1'): ?>
            <div class="payroll-report-section">
                <?php
                if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
                if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
                if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ""; }
                if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
                if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

                $searchmonthyear = $searchmonth.'-'.$searchyear;
                $urlpath = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee&&searchbank=$searchbank";
                ?>

                <!-- Report Header -->
                <div class="report-header">
                    <div class="report-title">
                        <h3><i class="fas fa-file-invoice-dollar"></i> Payroll Report</h3>
                    </div>
                    <div class="report-info">
                        <div class="report-info-item">
                            <strong>Employer's PIN:</strong> <?php echo htmlspecialchars($companycode); ?>
                        </div>
                        <div class="report-info-item">
                            <strong>Employer's Name:</strong> <?php echo htmlspecialchars($companyname); ?>
                        </div>
                        <div class="report-info-item">
                            <strong>Report Period:</strong> <?php echo htmlspecialchars($searchmonth . ' ' . $searchyear); ?>
                        </div>
                    </div>
                </div>

                <!-- Responsive Table Container -->
                <div class="table-container">
                    <table class="payroll-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Employee Code</th>
                                <th>Employee Name</th>
                                <th>Department</th>
                                <?php
                                $totalamount = '0.00';
                                $query1 = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by auto_number";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res1 = mysqli_fetch_array($exec1))
                                {
                                    $componentanum = $res1['auto_number'];
                                    $componentname = $res1['componentname'];
                                    
                                    $datatotal[$componentanum] = array();
                                    $totnhif10 = 0;
                                    $totloan = 0;
                                    $totgross = 0;
                                    $totdeduct = 0;
                                    $totnett = 0;	
                                    $totinsurance = 0;
                                    ?>
                                    <th class="component-header"><?php echo htmlspecialchars($componentname); ?></th>
                                    <?php
                                }
                                ?>
                                <th class="total-header">Gross Pay</th>
                                <?php
                                $query1d = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by auto_number";
                                $exec1d = mysqli_query($GLOBALS["___mysqli_ston"], $query1d) or die ("Error in Query1d".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res1d = mysqli_fetch_array($exec1d))
                                {
                                    $componentanum = $res1d['auto_number'];
                                    $componentname = $res1d['componentname'];
                                    
                                    $datatotal[$componentanum] = array();
                                    ?>
                                    <th class="deduction-header"><?php echo htmlspecialchars($componentname); ?></th>
                                    <?php
                                }
                                ?>
                                <th class="deduction-header">Loan Deduction</th>
                                <th class="deduction-header">Insurance Relief</th>
                                <th class="total-header">Deductions</th>
                                <th class="total-header">Net Pay</th>
                                <th class="total-header">Amount to Bank</th>
                                <th class="account-header">Account No</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalamount = '0.00'; $old_bankname = '';$bankname = '';
                            $query2 = "select a.employeecode as employeecode, a.employeename as employeename, b.bankname, b.accountnumber, a.departmentname as departmentname, a.payrollstatus as payrollstatus, a.dateofjoining as doj, b.dateofbirth as dob from master_employee AS a JOIN master_employeeinfo AS b ON (a.employeecode = b.employeecode) where a.employeename like '%$searchemployee%' and b.bankname like '%$searchbank%' and a.employeecode <> '' and (a.payrollstatus = 'Active' or a.payrollstatus = 'Prorata') group by a.employeecode order by b.bankname, cast(b.payrollno as unsigned) asc";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($res2 = mysqli_fetch_array($exec2))
                            {	
                                $searchemployeename = $res2['employeename'];
                                $departmentname = $res2['departmentname'];
                                $res2employeecode = $res2['employeecode'];
                                $bankname = $res2['bankname'];
                                $accountnumber = $res2['accountnumber'];
                                $dob = $res2['dob'];
                                if($dob == '0000-00-00')
                                {
                                    $dob = date('Y-m-d');
                                }
                                

                                $from=date_create($dob);
                                $to=date_create(date('Y-m-d'));
                                $diff=date_diff($to,$from);
                                //print_r($diff);
                                $y = $diff->y;
                                
                                $totalpercentcalc = '0.00';
                                $sumoftotalearningsfinal = '0.00';
                                $sumoftotalearnings = '0.00';
                                $sumofnotional = '0.00';
                                $totgrossamount = '0.00';
                                $totdeductamount = '0.00';
                                $totdeductamount1 = '0.00';
                                $totaldeductearning = 0;
                                
                                $query777 = mysqli_query($GLOBALS["___mysqli_ston"], "select payrollno from master_employeeinfo where employeecode = '$res2employeecode'") or die ("Error in Queryinfo".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res777 = mysqli_fetch_array($query777);
                                $payrollno = $res777['payrollno'];
                                
                                $query777 = "select employeecode from payroll_assign where employeecode = '$res2employeecode'";
                                $exec777 = mysqli_query($GLOBALS["___mysqli_ston"], $query777) or die ("Error in Query777".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res777 = mysqli_fetch_array($exec777);
                                $res777employeecode = $res777['employeecode'];
                                
                                if($res777employeecode != '')
                                {
                                    $res2employeecode = $res777employeecode;
                                    $res2employeename = $res2['employeename'];
                                
                                $colorloopcount = $colorloopcount + 1;
                                
                                if($colorloopcount == 1 || $old_bankname != $bankname)
                                {
                                ?>
                                <tr class="bank-header-row">
                                    <td colspan="100" class="bank-header">
                                        <i class="fas fa-university"></i> Bank: <?php echo htmlspecialchars($bankname); ?>
                                    </td>
                                </tr>			
                                <?php } 
                                $old_bankname = $bankname;
                                $query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '1' order by typecode, auto_number";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res1 = mysqli_fetch_array($exec1))
                                {
                                    $componentanum = $res1['auto_number'];

                                    $query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
                                    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res3 = mysqli_fetch_array($exec3);
                                    $componentamount = $res3['componentamount'];
                                    //if($componentamount < 1){continue;}
                                } 
                                
                              
                                ?>
                                <tr class="employee-row <?php echo ($colorloopcount % 2 == 0) ? 'even' : 'odd'; ?>">
                                    <td class="serial-number"><?php echo $colorloopcount; ?></td>
                                    <td class="employee-code">
                                        <span class="code-badge"><?php echo htmlspecialchars($payrollno); ?></span>
                                    </td>
                                    <td class="employee-name"><?php echo htmlspecialchars($res2employeename); ?></td>
                                    <td class="department">
                                        <span class="department-badge"><?php echo htmlspecialchars($departmentname); ?></span>
                                    </td>
	<?php
	$query3 = "select auto_number,componentname,amounttype,typecode,monthly,formula,deductearning,notional from master_payrollcomponent where recordstatus <> 'deleted' order by auto_number";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res3 = mysqli_fetch_array($exec3))
	{
		$componentanum = $res3['auto_number'];
		$employeesearch = $res2employeecode;
		$assignmonth = $searchmonthyear;
		$componentname = $res3['componentname'];
		$amounttype = $res3['amounttype'];
		$typecode = $res3['typecode'];
		$monthly = $res3['monthly'];
		$deductearning = $res3['deductearning'];
		$notional = $res3['notional'];
		
		if($employeesearch != '')
		{	
	 	$query4 = "select payrollstatus, dateofjoining as doj from master_employee where employeecode = '$employeesearch'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res4 = mysqli_fetch_array($exec4);
	 	$payrollstatus = $res4['payrollstatus'];
		$doj = $res4['doj'];
		$enddate = date('Y-m-t', strtotime($doj));
		$from=date_create($doj);
		$to=date_create($enddate);
		$diff=date_diff($to,$from);
		//print_r($diff);
		$workdays = $diff->d;

		$query6 = "select `1` as componentvalue from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res6 = mysqli_fetch_array($exec6);
		$value = $res6['componentvalue'];
		$basic_salary = $value;

		
		if($payrollstatus == 'Active' || $payrollstatus == 'Prorata')
		{
			 $query5 = "select `$componentanum` as componentvalue, auto_number from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res5 = mysqli_fetch_array($exec5))
			{
				$anum = $res5['auto_number'];
				$componentanum = $componentanum;
			 	$componentvalue = $res5['componentvalue'];
			
				if($payrollstatus == 'Prorata')
				{
				$componentvalue1 = $res5['componentvalue'];
				$perdayamt = ($componentvalue1 / 30);
				$componentvalue = $perdayamt * $workdays;
				$componentvalue = ceil($componentvalue);
				$componentvalue = number_format($componentvalue,2,'.','');
				}
			
				if($amounttype == 'Percent')
				{
					$formulafrom = $res3['formula'];
					if($formulafrom == '1')
					{
						$query6 = "select `1` as componentvalue from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
						$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res6 = mysqli_fetch_array($exec6);
						$value = $res6['componentvalue'];
						$baic_salary = $value;
						
						$calc1 = $value * ($componentvalue/100);
						$calc1 = ceil($calc1);
						$calc1 = number_format($calc1,3,'.','');
						//$calc1 = round_calc($calc1);
						
						$query7 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
						$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res7 = mysqli_fetch_array($exec7);
						$notexceed = $res7['notexceed'];
						if($notexceed != '0.00')
						{
							if($calc1 > $notexceed)
							{
								$resamount = $notexceed;
							}
							else
							{
								$resamount = $calc1;
							}
						}
						else
						{
							$resamount = $calc1;
						}
						

						$componentvalue = $resamount;
						
					}
					
					else if($formulafrom == 'Gross')
					{
						$totalgrossper = 0;
						$query12 = "select auto_number as ganum from master_payrollcomponent where typecode = '10' and auto_number <> '$componentanum' and recordstatus <> 'deleted'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res12 = mysqli_fetch_array($exec12))
						{
							$ganum = $res12['ganum'];
							
							$querygg = "select `$ganum` as res12value from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
							$execgg = mysqli_query($GLOBALS["___mysqli_ston"], $querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));
							$resgg = mysqli_fetch_array($execgg);
							$res12value = $resgg['res12value'];
							$totalgrossper = $totalgrossper + $res12value;
						}
						$calc3 = $totalgrossper * ($componentvalue / 100);
						$calc3 = ceil($calc3);
						$calc3 = number_format($calc3,3,'.','');
						//$calc3 = round_calc($calc3);
						
						$query13 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
						$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res13 = mysqli_fetch_array($exec13);
						$notexceed = $res13['notexceed'];
						if($notexceed != '0.00')
						{
							if($calc3 > $notexceed)
							{
								$resamount = $notexceed;
							}
							else
							{
								$resamount = $calc3;
							}
						}
						else
						{
							$resamount = $calc3;
						}	
						
						$componentvalue = $resamount;
					}
					else
					{
						
					}
				}	
				else
				{
					$componentvalue = $componentvalue;
				}
				
				if($monthly == 'Yes')
				{
				 	$query32 = "select componentname, amount from payroll_assignmonthwise where componentanum = '$componentanum' and employeecode = '$employeesearch' and assignmonth = '$searchmonthyear' and status <> 'deleted'";
				
					$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res32 = mysqli_fetch_array($exec32);
					$rows32 = mysqli_num_rows($exec32);
					$res32componentname = $res32['componentname'];
					
					if($res32componentname != '')
					{	
						$componentamount = $res32['amount'];
						$componentvalue = $componentamount;
					}
					else
					{
						$componentvalue = 0;
					}
				}	
				
				$sumofcomponent51 = '0';				
				$sumofcomponent55 = '0';
			
				$query18 = "select amount,percent,basedon from master_nssf where componentanum = '$componentanum' and status <> 'deleted'";	
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));	
				$res18 = mysqli_fetch_array($exec18);	
				$res18amount = $res18['amount'];	
				$res18percent = $res18['percent'];	
				$res18basedon = $res18['basedon'];	
				if($res18basedon == 'Amount')	
				{		
					$res15amount = number_format($res18amount,3,'.','');	
					//$res15amount = round_calc($res15amount);	
						
					$query88 = "select employeename,excludenssf,excludepaye from master_employee where employeecode = '$employeesearch'";	
					$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));	
					$res88 = mysqli_fetch_array($exec88);	
					$res88employeename = $res88['employeename'];	
					$res88excludenssf = $res88['excludenssf'];
						
					if($res88excludenssf == 'Yes')	
					{	
					$res15amount = 0;	
					}	
					else	
					{	
						
					}	
						$res15amount = 0;
					$componentvalue = $res15amount;	
					$totdeductamount = $totdeductamount + $componentvalue;	
				}	
				else if($res18basedon == 'Percent')	
				{	
					$totalgrossnssf1 = '0';	
					$totalgrossnssf1 = number_format($sumoftotalearnings,3,'.','');	
					//$totalgrossnssf1 = round_calc($totalgrossnssf1);	
						
					$res15amount = $totalgrossnssf1 * ($res18percent / 100);	
					$res15amount = ceil($res15amount);	
					$res15amount = number_format($res15amount,3,'.','');	
					//$res15amount = round_calc($res15amount);	
						
					$query88 = "select employeename,excludenssf from master_employee where employeecode = '$employeesearch'";	
					$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));	
					$res88 = mysqli_fetch_array($exec88);	
					$res88employeename = $res88['employeename'];	
					$res88excludenssf = $res88['excludenssf'];	
						
					if($res88excludenssf == 'Yes')	
					{	
					$res15amount = 0;	
					}	
					else	
					{	
						
					}	
							
						
					$componentvalue = $res15amount;			
					$totdeductamount = $totdeductamount + $componentvalue;	
				}
			
			$gratuity = '0.00';
			
			$sumoftotalearnings = $sumoftotalearnings - $gratuity;
			
			/*if($componentanum == '64' && $componentvalue > 0)
			{
				$componentvalue = $componentvalue + $res15amount;	
			}
			
			if($componentanum == '62')	
			{	
				$query66 = "select SUM(`62`) as componentvalue from details_employeepayroll where employeecode = '$employeesearch' and status <> 'deleted'";	
				$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));	
				$res66 = mysqli_fetch_array($exec66);	
				$value = $res66['componentvalue'];	
				$totalrelief = $componentvalue + $value;	
				if($totalrelief < '1408')	
				{	
					$componentvalue = $totalrelief + $value;	
				}	
				else	
				{	
					$componentvalue = 0;	
				}	
			}*/	
			
			
			
			
			if($typecode == '10' && $notional != 'Yes')
			{
				$sumoftotalearnings = $sumoftotalearnings + $componentvalue;
			}
			else if($typecode == '10' && $notional == 'Yes')
			{
				$sumofnotional = $sumofnotional + $componentvalue;
			}
			else if($typecode == '20')
			{
				//$totdeductamount = $totdeductamount + $componentvalue;
			}				
			
			if($deductearning == 'Yes')
			{
				$totaldeductearning = $totaldeductearning + $componentvalue;
			}
			
		    $totaldeductearning;
			$sumoftotalearnings;
			$res19absentamount = '0';
			$sumoftotalearningsfinal = $sumoftotalearnings - $res19absentamount - $totaldeductearning;
			
			$sumoftotalearnings;
			
			
			$grosspay = $sumoftotalearnings;
			
			//$taxableincome = $sumoftotalearningsfinal - $nssfamount;
			$taxableincome = $sumoftotalearningsfinal ;
			$nhiftaxableincome = $sumoftotalearningsfinal;
			//$taxableincome = '8000';
			$totgrossamount = $taxableincome ;
			$nhifamount = 0;
			
				$query72 = "select from1, to1, amount from master_nhif where status <> 'deleted'";
				$exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query72".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res72 = mysqli_fetch_array($exec72))
				{
					$res72from = $res72['from1'];
					$res72to = $res72['to1'];
				
					if($nhiftaxableincome >= $res72from && $nhiftaxableincome <= $res72to)
					{
						$query341 = "select excludenhif from master_employee where employeecode = '$employeesearch'";
						$exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die ("Error in Query341".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res341 = mysqli_fetch_array($exec341);
						$res34excludenhif = $res341['excludenhif'];
						if($res34excludenhif == 'Yes')
						{
						$nhifamount = '0';
						}
						else
						{
						$nhifamount = $res72['amount'];
						}
						
						$nhifamount = number_format($nhifamount,3,'.','');
						
					}
				}	
				
				if($componentanum == '2')
				{
					$componentvalue = $nhifamount;
					//$totdeductamount = $totdeductamount + $componentvalue;
				}
			}
			$taxableincome;
			$totalpercentcalc = '0.00';
			$balance = '';
			$totalbalance = 0;
			$j = '0';
			if($taxableincome > 0){
			$query73 = "select from1, to1, percent, difference from master_paye where status <> 'deleted'";
			$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die ("Error in Query73".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res73 = mysqli_fetch_array($exec73))
			{
				$res73from = $res73['from1'];
				$res73to = $res73['to1'];
				$res73percent = $res73['percent'];
				$template = 'Kenya';
				
				if($template == 'Kenya')
				{
					if($taxableincome >= $res73from && $taxableincome <= $res73to)
					{
						$difference = $res73['difference'];
						if($balance == "")
						{
							$payepercentcalc = $taxableincome * ($res73percent / 100);
						}
						else
						{
							$payepercentcalc = $balance * ($res73percent / 100);
						}
						$totalpercentcalc = $totalpercentcalc + $payepercentcalc;
						$j = '1';
					}
					else
					{
						if($j == '0')
						{
							$difference = $res73['difference'];
							if($balance == '')
							{
								$balance = $taxableincome - $difference;
							}
							else
							{
								$balance = $balance - $difference;
							}
							
							$payepercentcalc = $difference * ($res73percent / 100);
							$totalpercentcalc = $totalpercentcalc + $payepercentcalc;
						}
					}
				}	
			}
			}
			
			$totalpercentcalc;
			
			$taxrelief = '0.00';
			$insurancerelief = '0';
			$query55 = "select * from master_taxrelief where status <> 'deleted' and tyear = '$searchyear'";
			$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res55 = mysqli_fetch_array($exec55);
			$res55finalamount = $res55['finalamount'];
			if($res55finalamount != '')
			{
				$taxrelief = $res55finalamount;
			}
			
			$totalpayeeamount = $totalpercentcalc - $taxrelief - $insurancerelief;
			$totalpayeeamount = ceil($totalpayeeamount);
			if($totalpayeeamount < 0)
			{
				$totalpayeeamount = 0;
			}
			

			$query88 = "select employeename,govt_employee,excludepaye from master_employee where employeecode = '$employeesearch'";
			$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res88 = mysqli_fetch_array($exec88);
			$res88employeename = $res88['employeename'];
			$govt_employee = $res88['govt_employee'];
			$res88excludepaye = $res88['excludepaye'];

			if($govt_employee == 'Yes')
			{
				$query6 = "select `1` as componentvalue from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res6 = mysqli_fetch_array($exec6);
				$value = $res6['componentvalue'];
				$govt_value = $value * (30/100);
				$govt_value = ceil($govt_value);
				$totalpayeeamount = $govt_value;
			}
			$totalpayeeamount = number_format($totalpayeeamount,3,'.','');
			//$totalpayeeamount = round_calc($totalpayeeamount);
			if($componentanum == '4')
			{
				$componentvalue = $totalpayeeamount;
				//$totdeductamount = $totdeductamount + $componentvalue;
			}

		}
		
		}
		

		//$totdeductamount = $totaldeductions + $nhifamount + $totalpayeeamount;
		$totnettpay = $totgrossamount - $totdeductamount;
		
		//$totnettpay = $totnettpay + $componentvalue;
	
		if($typecode == '10')
		{
			array_push($datatotal[$componentanum],$componentvalue);
	?>
                                    <td class="component-amount">
                                        <?php if($componentvalue > 0) { echo number_format($componentvalue,2,'.',','); } ?>
                                    </td>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <td class="total-amount gross-pay">
                                        <?php if(true) { echo number_format($totgrossamount,2,'.',','); } ?>
                                    </td>
	<?php
	$totgross += $totgrossamount;

	$query3d = "select auto_number,componentname,amounttype,typecode,monthly,formula,deductearning from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by auto_number";
	$exec3d = mysqli_query($GLOBALS["___mysqli_ston"], $query3d) or die ("Error in Query3d".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res3d = mysqli_fetch_array($exec3d))
	{
		$componentanum = $res3d['auto_number'];
		$employeesearch = $res2employeecode;
		$assignmonth = $searchmonthyear;
		$componentname = $res3d['componentname'];
		$amounttype = $res3d['amounttype'];
		$typecode = $res3d['typecode'];
		$monthly = $res3d['monthly'];
		$deductearning = $res3d['deductearning'];
		
		
		
		if($employeesearch != '')
		{	
		$query4 = "select payrollstatus from master_employee where employeecode = '$employeesearch'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res4 = mysqli_fetch_array($exec4);
		$payrollstatus = $res4['payrollstatus'];
		
		if($payrollstatus == 'Active' || $payrollstatus == 'Prorata')
		{
			$query5 = "select `$componentanum` as componentvalue, auto_number from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res5 = mysqli_fetch_array($exec5))
			{
				$anum = $res5['auto_number'];
				$componentanum = $componentanum;
				$componentvalue = $res5['componentvalue'];
				
				
			
				if($amounttype == 'Percent')
				{
					$formulafrom = $res3d['formula'];
					if($formulafrom == '1')
					{
					 	$query6 = "select `1` as componentvalue from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
					
						$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res6 = mysqli_fetch_array($exec6);
						$value = $res6['componentvalue'];
						
						$calc1 = $value * ($componentvalue/100);
						$calc1 = ceil($calc1);
						$calc1 = number_format($calc1,3,'.','');
						//$calc1 = round_calc($calc1);
						
						$query7 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
						$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res7 = mysqli_fetch_array($exec7);
						$notexceed = $res7['notexceed'];
						if($notexceed != '0.00')
						{
							if($calc1 > $notexceed)
							{
								$resamount = $notexceed;
							}
							else
							{
								$resamount = $calc1;
							}
						}
						else
						{
							$resamount = $calc1;
						}
						
						$componentvalue = $resamount;
						
					}
					
					else if($formulafrom == 'Gross')
					{
						$totalgrossper = 0;
						$query12 = "select auto_number as ganum from master_payrollcomponent where typecode = '10' and auto_number <> '$componentanum' and recordstatus <> 'deleted'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res12 = mysqli_fetch_array($exec12))
						{
							$ganum = $res12['ganum'];
							
							$querygg = "select `$ganum` as res12value from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
							$execgg = mysqli_query($GLOBALS["___mysqli_ston"], $querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));
							$resgg = mysqli_fetch_array($execgg);
							$res12value = $resgg['res12value'];
							$totalgrossper = $totalgrossper + $res12value;
						}
						$calc3 = $totalgrossper * ($componentvalue / 100);
						$calc3 = ceil($calc3);
						$calc3 = number_format($calc3,3,'.','');
						//$calc3 = round_calc($calc3);
						
						$query13 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
						$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res13 = mysqli_fetch_array($exec13);
						$notexceed = $res13['notexceed'];
						if($notexceed != '0.00')
						{
							if($calc3 > $notexceed)
							{
								$resamount = $notexceed;
							}
							else
							{
								$resamount = $calc3;
							}
						}
						else
						{
							$resamount = $calc3;
						}	
						
						$componentvalue = $resamount;
					}
					else
					{
						
					}
				}	
				else

				{
					$componentvalue = $componentvalue;
				}
				
				if($monthly == 'Yes')
				{
					$query32 = "select componentname, amount from payroll_assignmonthwise where componentanum = '$componentanum' and employeecode = '$employeesearch' and assignmonth = '$searchmonthyear' and status <> 'deleted'";
					$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res32 = mysqli_fetch_array($exec32);
					$rows32 = mysqli_num_rows($exec32);
					$res32componentname = $res32['componentname'];
					
					if($res32componentname != '')
					{	
						$componentamount = $res32['amount'];
						$componentvalue = $componentamount;
					}
					else
					{
						$componentvalue = 0;
					}
				}	
				
				
				$sumofcomponent51 = '0';				
				$sumofcomponent55 = '0';
				
				$query18 = "select amount,percent,basedon from master_nssf where componentanum = '$componentanum' and status <> 'deleted'";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res18 = mysqli_fetch_array($exec18);
				$res18amount = $res18['amount'];
				$res18percent = $res18['percent'];
				$res18basedon = $res18['basedon'];
				if($res18basedon == 'Amount')
				{	
					$res15amount = number_format($res18amount,3,'.','');
					//$res15amount = round_calc($res15amount);
					
					$query88 = "select employeename,excludenssf from master_employee where employeecode = '$employeesearch'";
					$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res88 = mysqli_fetch_array($exec88);
					$res88employeename = $res88['employeename'];
					$res88excludenssf = $res88['excludenssf'];
					
					if($res88excludenssf == 'Yes')
					{
					$res15amount = 0;
					}
					else
					{
					
					}
					/*if($y > '60')
					{
						$res15amount = 0;	
					}*/
			        //$res15amount=0;
				 	 $componentvalue = $res15amount;
					 $sumoftotalearnings = $sumoftotalearnings - $componentvalue;
					 //$totdeductamount=$totdeductamount-$componentvalue;
					//$totdeductamount = $totdeductamount  $componentvalue;
				}
				else if($res18basedon == 'Percent')
				{
					$totalgrossnssf1 = '0';
					$totalgrossnssf1 = number_format($sumoftotalearnings,3,'.','');
					//$totalgrossnssf1 = round_calc($totalgrossnssf1);
					
					$res15amount = $totalgrossnssf1 * ($res18percent / 100);
					$res15amount = ceil($res15amount);
					$res15amount = number_format($res15amount,3,'.','');
					//$res15amount = round_calc($res15amount);
					
					$query88 = "select employeename,excludenssf from master_employee where employeecode = '$employeesearch'";
					$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res88 = mysqli_fetch_array($exec88);
					$res88employeename = $res88['employeename'];
					$res88excludenssf = $res88['excludenssf'];
					
					if($res88excludenssf == 'Yes')
					{
					$res15amount = 0;
					}
					else
					{
					
					}
					/*if($y > '60')
					{
						$res15amount = 0;	
					}	
					*/
					$componentvalue = $res15amount;		
					$sumoftotalearnings = $sumoftotalearnings - $componentvalue;
					//$totdeductamount = $totdeductamount + $componentvalue;
				}
				
				
				
				if($componentanum == '64' && $componentvalue > 0)
				{
					$componentvalue = $componentvalue + $res15amount;	
				}
				
				if($componentanum == '3' && $componentvalue > 0)
				{
					$totdeductamount = $totdeductamount + $componentvalue;	
				}
				
				if($typecode == '10')
				{
				 $sumoftotalearnings = $sumoftotalearnings + $componentvalue;
				}
				else if($typecode == '20')
				{
				
				
					$totdeductamount = $totdeductamount + $componentvalue;
				}				
			
			$gratuity = '0.00';

			if($deductearning == 'Yes')
			{
				$totdeductamount = $totdeductamount - (2*$componentvalue);
			}
			
			
			
			$sumoftotalearnings = $sumoftotalearnings - $gratuity;
			
			$sumoftotalearnings;
			$res19absentamount = '0';
			
			$res19absentamount = 0;
			
			$sumoftotalearningsfinal = $sumoftotalearnings - $res19absentamount;
			
			$grosspay = $sumoftotalearnings;
		
			
			
			//$taxableincome = $sumoftotalearningsfinal - $nssfamount;
			$taxableincome = $sumoftotalearningsfinal - $totaldeductearning;
			$nhiftaxableincome = $sumoftotalearningsfinal;
			//$taxableincome = '8000';
			$totgrossamount = $taxableincome;
			$nhifamount = 0;
			
				$query72 = "select from1, to1, amount from master_nhif where status <> 'deleted'";
				$exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query72".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res72 = mysqli_fetch_array($exec72))
				{
					$res72from = $res72['from1'];
					$res72to = $res72['to1'];
				
					if($nhiftaxableincome >= $res72from && $nhiftaxableincome <= $res72to)
					{
						$query341 = "select excludenhif from master_employee where employeecode = '$employeesearch'";
						$exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die ("Error in Query341".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res341 = mysqli_fetch_array($exec341);
						$res34excludenhif = $res341['excludenhif'];
						if($res34excludenhif == 'Yes')
						{
						$nhifamount = '0';
						}
						else
						{
						$nhifamount = $res72['amount'];
						}
						
						$nhifamount = number_format($nhifamount,3,'.','');
						
					}
				}	
				
				if($componentanum == '2')
				{
					$componentvalue = $nhifamount;
					$totdeductamount = $totdeductamount + $componentvalue;
				}
			}
			
			
			
			 $taxableincome;
			$totalpercentcalc = '0.00';
			$balance = '';
			$totalbalance = 0;
			$j = '0';
			if($taxableincome > 0){
			$query73 = "select from1, to1, percent, difference from master_paye where status <> 'deleted'";
			$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die ("Error in Query73".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res73 = mysqli_fetch_array($exec73))
			{
				$res73from = $res73['from1'];
				$res73to = $res73['to1'];
				$res73percent = $res73['percent'];
				$template = 'Kenya';
				
				if($template == 'Kenya')
				{
					if($taxableincome >= $res73from && $taxableincome <= $res73to)
					{
						$difference = $res73['difference'];
						if($balance == "")
						{
							$payepercentcalc = $taxableincome * ($res73percent / 100);
						}
						else
						{
							$payepercentcalc = $balance * ($res73percent / 100);
						}
						$totalpercentcalc = $totalpercentcalc + $payepercentcalc;
						$j = '1';
					}
					else
					{
						if($j == '0')
						{
							$difference = $res73['difference'];
							if($balance == '')
							{
								$balance = $taxableincome - $difference;
							}
							else
							{
								$balance = $balance - $difference;
							}
							
							$payepercentcalc = $difference * ($res73percent / 100);
							$totalpercentcalc = $totalpercentcalc + $payepercentcalc;
						}
					}
				}	
			}
			}
			
			
			$taxrelief = '0.00';
			$insurancerelief = '0';
			$query861 = "select premium, taxpercent from insurance_relief where status <> 'deleted' and includepaye = 'Yes' and employeecode = '$employeesearch'";
			$exec861 = mysqli_query($GLOBALS["___mysqli_ston"], $query861) or die ("Error in Query861".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res861 = mysqli_fetch_array($exec861))
			{
				$premium = $res861['premium'];
				$taxpercent = $res861['taxpercent'];
				$tax_calc = $premium * ($taxpercent / 100);
				$insurancerelief = $insurancerelief + $tax_calc;
			}
	
			$query55 = "select * from master_taxrelief where status <> 'deleted' and tyear = '$searchyear'";
			$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res55 = mysqli_fetch_array($exec55);
			$res55finalamount = $res55['finalamount'];
			if($res55finalamount != '')
			{	
				$query88 = "select employeename,excluderelief from master_employee where employeecode = '$employeesearch'";
				$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res88 = mysqli_fetch_array($exec88);
				$res88employeename = $res88['employeename'];
				$res88excluderelief = $res88['excluderelief'];
				if($res88excluderelief == 'Yes')
				{
					$taxrelief = 0;
				} else {
					$taxrelief = $res55finalamount;
				}
			}
			//done
			$totalpercentcalc;
			
			$taxrelief;
			
			$totalpayeeamount = $totalpercentcalc - $taxrelief - $insurancerelief;
			$totalpayeeamount = ceil($totalpayeeamount);
			if($totalpayeeamount < 0)
			{
				$totalpayeeamount = 0;
			}
			
			if($res88excludepaye == 'Yes'){
				$totalpayeeamount = 0;
			}
			
			$query88 = "select employeename,govt_employee from master_employee where employeecode = '$employeesearch'";
			$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res88 = mysqli_fetch_array($exec88);
			$res88employeename = $res88['employeename'];
			$govt_employee = $res88['govt_employee'];
			if($govt_employee == 'Yes')
			{
				$query6 = "select `1` as componentvalue from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res6 = mysqli_fetch_array($exec6);
		     	$value = $res6['componentvalue'];
				$govt_value = $value * (30/100);
				$govt_value = ceil($govt_value);
				$totalpayeeamount = $govt_value;
			}
			
			$totalpayeeamount = number_format($totalpayeeamount,3,'.','');
			//$totalpayeeamount = round_calc($totalpayeeamount);			
			if($componentanum == '4')
			{
			$componentvalue = $totalpayeeamount;
				$totdeductamount = $totdeductamount + $componentvalue;
			}
			
			
			
		}
		
		}
		
		//$totdeductamount = $totaldeductions + $nhifamount + $totalpayeeamount;
		$totnettpay = $totgrossamount - $totdeductamount;
		//$totnettpay = $totnettpay - $componentvalue;
		
		array_push($datatotal[$componentanum],$componentvalue);
	?>
	<td align="right" class="bodytext3" width="184"><?php if($componentvalue > 0) { echo number_format($componentvalue,2,'.',','); } ?></td>
	<?php

	}
	
	
	
	?>
	<?php
	$loanamount = 0;
	$res15amount = 0;
	$insurancerelief = 0;
	$query80 = "select sum(installmentamount) as loanamount from loan_assign where status <> 'deleted' and paymonth = '$assignmonth' and employeecode = '$employeesearch'";
	$exec80 = mysqli_query($GLOBALS["___mysqli_ston"], $query80) or die ("Error in Query80".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res80 = mysqli_fetch_array($exec80);
	$loanamount = $res80['loanamount'];	
	
	$query86 = "select sum(premium) as insurancerelief from insurance_relief where status <> 'deleted' and includededuction = 'Yes' and employeecode = '$employeesearch'";
	$exec86 = mysqli_query($GLOBALS["___mysqli_ston"], $query86) or die ("Error in Query86".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res86 = mysqli_fetch_array($exec86);
	$insurancerelief = $res86['insurancerelief'];	
	
		
	
	$totdeductamount = $totdeductamount + $loanamount + $res15amount;
	
	
	
	
	
	  $totnettpay = $totnettpay - $loanamount - $res15amount + $sumofnotional; 
	
	$totnhif10 += $res15amount;
	$totloan += $loanamount;
	$totdeduct += $totdeductamount;
	$totnett += $totnettpay;
	$totinsurance += $insurancerelief;
	?>
                                    <td class="deduction-amount loan-deduction">
                                        <?php if($loanamount > 0) { echo number_format($loanamount,2,'.',','); } ?>
                                    </td>	
                                    <td class="deduction-amount insurance-relief">
                                        <?php if($insurancerelief > 0) { echo number_format($insurancerelief,2,'.',','); } ?>
                                    </td>	
                                    <td class="total-amount total-deductions">
                                        <?php if($totdeductamount > 0) { echo number_format($totdeductamount,2,'.',','); } ?>
                                    </td>	
                                    <td class="total-amount net-pay">
                                        <?php if($totnettpay > 0) { echo number_format($totnettpay,2,'.',','); } ?>
                                    </td>

                                    <?php
                                    $totaldeduct = 0;
                                    $totalgrossper = 0;
                                    $query12 = "select auto_number as ganum, typecode from master_payrollcomponent where recordstatus <> 'deleted'";
                                    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($res12 = mysqli_fetch_array($exec12))
                                    {
                                        $ganum = $res12['ganum'];
                                        $typecode = $res12['typecode'];
                                        
                                        $querygg = "select `$ganum` as res12value from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
                                        $execgg = mysqli_query($GLOBALS["___mysqli_ston"], $querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $resgg = mysqli_fetch_array($execgg);
                                        $res12value = $resgg['res12value'];
                                        if($typecode == 10){
                                        $totalgrossper = $totalgrossper + $res12value; }
                                        else  { 
                                        $totaldeduct = $totaldeduct + $res12value; }
                                    }
                                    
                                    
                                    $componentamount = $totalgrossper - $totaldeduct;
                                    $totalamount = $totalamount + $componentamount;
                                    ?>
                                    <td class="total-amount bank-amount">
                                        <?php echo number_format($componentamount,0,'.',','); ?>
                                    </td>
                                    <td class="account-number">
                                        <span class="account-badge"><?php echo htmlspecialchars($accountnumber); ?></span>
                                    </td>
                                </tr>	
	<?php
	}
	}
	?>
	
                            <tr class="totals-row">
                                <td colspan="4" class="totals-label"><strong>Total : </strong></td>
                                <?php
                                $query_f = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by auto_number";
                                $exec_f = mysqli_query($GLOBALS["___mysqli_ston"], $query_f) or die ("Error in Query_f".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res_f = mysqli_fetch_array($exec_f))
                                {
                                    $i = $res_f['auto_number'];		
                                    ?>
                                    <td class="totals-amount component-total">
                                        <strong><?php if(array_sum($datatotal[$i]) > 0) { echo number_format(array_sum($datatotal[$i]),2); } ?></strong>
                                    </td>
                                    <?php
                                }
                                ?>
                                <td class="totals-amount gross-total">
                                    <strong><?php if($totgross > 0) { echo number_format($totgross,2); } ?></strong>
                                </td>
                                <?php
                                $query_fd = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by auto_number";
                                $exec_fd = mysqli_query($GLOBALS["___mysqli_ston"], $query_fd) or die ("Error in Query_fd".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res_fd = mysqli_fetch_array($exec_fd))
                                {
                                    $j = $res_fd['auto_number'];		
                                    ?>
                                    <td class="totals-amount deduction-total">
                                        <strong><?php if(array_sum($datatotal[$j]) > 0) { echo number_format(array_sum($datatotal[$j]),2); } ?></strong>
                                    </td>
                                    <?php
                                }
                                ?>
                                <td class="totals-amount loan-total">
                                    <strong><?php if($totloan > 0) { echo number_format($totloan,2); } ?></strong>
                                </td>
                                <td class="totals-amount insurance-total">
                                    <strong><?php if($totinsurance > 0) { echo number_format($totinsurance,2); } ?></strong>
                                </td>
                                <td class="totals-amount deductions-total">
                                    <strong><?php if($totdeduct > 0) { echo number_format($totdeduct,2); } ?></strong>
                                </td>
                                <td class="totals-amount net-total">
                                    <strong><?php if($totnett > 0) { echo number_format($totnett,2); } ?></strong>
                                </td>
                                <td class="totals-amount bank-total">
                                    <strong><?php if($totalamount > 0) { echo number_format($totalamount,2); } ?></strong>
                                </td>
                                <td class="export-actions">
                                    <a href="print_payrollmonthwiseinterim.php?<?php echo $urlpath; ?>" class="export-btn" title="Export to Excel">
                                        <i class="fas fa-file-excel"></i>
                                    </a>
                                </td>
                            </tr>  
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/payroll-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



