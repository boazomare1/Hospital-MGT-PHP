<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

set_time_limit(0);

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

// Date variables
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');



$searchsuppliername = '';

$suppliername = '';

$cbsuppliername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$colorloopcount = '';

$sno = '';

$snocount = '';

$visitcode1 = '';

$total = '';

$looptotalpaidamount = '0.00';

$looptotalpendingamount = '0.00';

$looptotalwriteoffamount = '0.00';

$looptotalcashamount = '0.00';

$looptotalcreditamount = '0.00';

$looptotalcardamount = '0.00';

$looptotalonlineamount = '0.00';

$looptotalchequeamount = '0.00';

$looptotaltdsamount = '0.00';

$looptotalwriteoffamount = '0.00';

$pendingamount = '0.00';

$accountname = '';

$temp = '' ;	



// Handle form parameters with modern isset() checks
$accountname = isset($_REQUEST["accountname"]) ? $_REQUEST["accountname"] : "";
$consultingdoctor = isset($_REQUEST["consultingdoctor"]) ? $_REQUEST["consultingdoctor"] : "";



$query111 = "select * from master_doctor where auto_number = '$consultingdoctor'";

$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in query111".mysqli_error($GLOBALS["___mysqli_ston"]));

$res111 = mysqli_fetch_array($exec111);

$res111doctorname = $res111['doctorname'];



$getcanum = isset($_REQUEST["canum"]) ? $_REQUEST["canum"] : "";

if ($getcanum != '') {
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}



$cbfrmflag1 = isset($_REQUEST["cbfrmflag1"]) ? $_REQUEST["cbfrmflag1"] : "";

if ($cbfrmflag1 == 'cbfrmflag1') {
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	$visitcode1 = 10;
}



$task = isset($_REQUEST["task"]) ? $_REQUEST["task"] : "";

if ($task == 'deleted') {
	$errmsg = 'Payment Entry Delete Completed.';
}

$ADate1 = isset($_REQUEST["ADate1"]) ? $_REQUEST["ADate1"] : "";
$ADate2 = isset($_REQUEST["ADate2"]) ? $_REQUEST["ADate2"] : "";

if ($ADate1 != '' && $ADate2 != '') {
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
} else {
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Utilization Report - MedStar Hospital Management</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- JavaScript Files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    
    <style>
        .ui-menu .ui-menu-item { zoom: 1 !important; }
        .bal { border-style: none; background: none; text-align: right; }
        .bali { text-align: right; }
        .report-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .report-table th, .report-table td { padding: 8px; text-align: left; border: 1px solid #ddd; }
        .report-table th { background-color: #f8f9fa; font-weight: bold; }
        .report-table tr:nth-child(even) { background-color: #f8f9fa; }
        .report-table tr:nth-child(odd) { background-color: #ffffff; }
        .doctor-header { background-color: #e3f2fd !important; font-weight: bold; }
        .revenue-row { background-color: #f3e5f5 !important; }
        .count-row { background-color: #e8f5e8 !important; }
        .avg-cost-row { background-color: #fff3e0 !important; }
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
        <span>Doctor Utilization Report</span>
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
                        <a href="doctorutilizationreport.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Utilization</span>
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
                    <h2>Doctor Utilization Report</h2>
                    <p>Generate comprehensive reports on doctor utilization, revenue, and performance metrics.</p>
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

            <!-- Search Form -->
            <form name="cbform1" method="post" action="doctorutilizationreport.php" class="form-section">
                <div class="form-section-header">
                    <i class="fas fa-search form-section-icon"></i>
                    <h3 class="form-section-title">Report Criteria</h3>
                    <span class="form-section-subtitle">Select date range to generate doctor utilization report</span>
                </div>
                
                <div class="form-section-form">
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
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1" />
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Generate Report
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
                    <h3 class="data-table-title">Doctor Utilization Report Results</h3>
                    <div class="data-table-actions">
                        <a target="_blank" href="print_doctorutilizationreport.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>" class="btn btn-outline">
                            <i class="fas fa-file-pdf"></i> Print PDF
                        </a>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">Doctor</th>
                                <th class="table-header-cell">Payment Type</th>
                                <th class="table-header-cell text-right">Revenue</th>
                                <th class="table-header-cell text-right">Count</th>
                                <th class="table-header-cell text-right">Avg Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table content will be generated by PHP -->
                            <tr class="table-row-even">
                                <td class="table-cell text-center" colspan="5">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        Report results will be displayed here after search
                                    </div>
                                </td>
                            </tr>
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

        // Form validation function
        function validateForm() {
            var fromDate = document.getElementById('ADate1').value;
            var toDate = document.getElementById('ADate2').value;
            
            if(fromDate == '' || toDate == '') {
                alert('Please select both date from and date to.');
                return false;
            }
            
            if(new Date(fromDate) > new Date(toDate)) {
                alert('Date from cannot be greater than date to.');
                return false;
            }
            
            return true;
        }

        // Print receipt function
        function funcPrintReceipt1(varRecAnum) {
            var varRecAnum = varRecAnum;
            window.open("print_payment_receipt1.php?receiptanum="+varRecAnum+"","OriginalWindow",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
        }

        // Delete payment function
        function funcDeletePayment1(varPaymentSerialNumber) {
            var varPaymentSerialNumber = varPaymentSerialNumber;
            var fRet;
            fRet = confirm('Are you sure want to delete this payment entry serial number '+varPaymentSerialNumber+'?');
            
            if (fRet == true) {
                alert ("Payment Entry Delete Completed.");
            }
            
            if (fRet == false) {
                alert ("Payment Entry Delete Not Completed.");
                return false;
            }
        }

        // Supplier name function
        function cbsuppliername1() {
            document.cbform1.submit();
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

<style type="text/css">
