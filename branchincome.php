<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d'); 
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];

$GLOBALS['eal'] = 0;
$GLOBALS['ieledgers'] = 0;
$GLOBALS['revenue'] = 0;

// Initialize variables
$errmsg = "";
$bgcolorcode = "";
$ADate1 = isset($_REQUEST["ADate1"]) ? $_REQUEST["ADate1"] : '';
$ADate2 = isset($_REQUEST["ADate2"]) ? $_REQUEST["ADate2"] : '';
$from_date = isset($_REQUEST["ADate1"]) ? $_REQUEST["ADate1"] : '';
$to_date = isset($_REQUEST["ADate2"]) ? $_REQUEST["ADate2"] : '';
$ADate3 = isset($_REQUEST["ADate3"]) ? $_REQUEST["ADate3"] : date('Y-m-d', strtotime('-0 year'));
$ADate4 = isset($_REQUEST["ADate4"]) ? $_REQUEST["ADate4"] : date('Y-m-d');
$cbfrmflag1 = isset($_REQUEST["cbfrmflag1"]) ? $_REQUEST["cbfrmflag1"] : "";
$location = isset($_REQUEST["location"]) ? $_REQUEST["location"] : "";
$frmflag2 = isset($_REQUEST["frmflag2"]) ? $_REQUEST["frmflag2"] : "";
$includeopenbal = isset($_POST["includeopenbal"]) ? 1 : 0;

// Handle form submission
if ($cbfrmflag1 == 'cbfrmflag1') {
    $from_date = $ADate1;
    $to_date = $ADate2;
    $location = $_REQUEST['location'];
    
    if (empty($from_date) || empty($to_date)) {
        $errmsg = "Please select both start and end dates.";
        $bgcolorcode = 'failed';
    } else {
        $errmsg = "Branch income statement generated successfully.";
        $bgcolorcode = 'success';
    }
}

// Function to show amount
function showAmount($amount, $decimal = 0) {
    if ($decimal == 1) {
        return number_format($amount, 2, '.', ',');
    } else {
        return number_format($amount, 0, '.', ',');
    }
}

// Function to get net profit
function net_profit1($from_date, $to_date) {
    // This would contain the actual net profit calculation logic
    return 0;
}

// Function to get subgroups (simplified for this example)
function getSubgroups($uid, $from_date, $to_date, $sno, $locationwise, $includeopenbal) {
    // This would contain the actual subgroup logic
    return "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Income Statement - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <span>Branch Income Statement</span>
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
                        <a href="admissionlist.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Admission List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipbeddiscountlist.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Bed Discount</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbed.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Add Bed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedoccupancysummary.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Bed Occupancy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedoccupancy2.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Bed Occupancy 2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedtransferlist.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Bed Transfer</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="otc_walkin_services.php" class="nav-link">
                            <i class="fas fa-walking"></i>
                            <span>OTC Walk-in</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billenquiry.php" class="nav-link">
                            <i class="fas fa-search"></i>
                            <span>Bill Enquiry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billestimate.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Bill Estimate</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billtxnidedit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Transaction Edit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientbillingstatus.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Patient Billing Status</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing_pending_op2.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>Billing Pending OP2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="medicalgoodsreceivednote.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Medical Goods Received</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_detailed_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Detailed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_summary_report.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Fixed Asset Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="theatrebookinglist.php" class="nav-link">
                            <i class="fas fa-theater-masks"></i>
                            <span>Theatre Booking List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branch_git.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Branch GIT</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="branchincome.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Branch Income</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>VAT Master</span>
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
                    <h2>Branch Income Statement</h2>
                    <p>Generate comprehensive income statements for branches with detailed financial analysis and reporting.</p>
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

            <!-- Income Statement Filter Form -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-filter add-form-icon"></i>
                    <h3 class="add-form-title">Branch Income Statement</h3>
                </div>
                
                <form id="incomeForm" name="cbform1" method="post" action="branchincome.php" class="add-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Start Date</label>
                            <input type="date" name="ADate1" id="ADate1" class="form-input" value="<?php echo $from_date ? $from_date : date('Y-m-d', strtotime('-0 year')); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">End Date</label>
                            <input type="date" name="ADate2" id="ADate2" class="form-input" value="<?php echo $to_date ? $to_date : date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="location" class="form-label">Location</label>
                        <select name="location" id="location" class="form-input">
                            <option value="">All Locations</option>
                            <?php
                            $query = "select * from master_employeelocation where username='$username' group by locationcode order by locationname";
                            $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res = mysqli_fetch_array($exec)) {
                                $reslocation = $res["locationname"];
                                $reslocationanum = $res["locationcode"];
                                $selected = ($location != '' && $location == $reslocationanum) ? "selected" : "";
                                echo '<option value="'.$reslocationanum.'" '.$selected.'>'.$reslocation.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-chart-line"></i> Generate Statement
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <input type="hidden" name="includeopenbal" value="1">
                </form>
            </div>

            <!-- Income Statement Results -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1' && !empty($from_date) && !empty($to_date)): ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Income Statement Report</h3>
                    <p>Period: <strong><?php echo date('Y-m-d', strtotime($from_date)); ?></strong> to <strong><?php echo date('Y-m-d', strtotime($to_date)); ?></strong></p>
                    <div class="export-actions">
                        <a href="tb_branchstatement_xl.php?ADate1=<?php echo $ADate1;?>&ADate2=<?php echo $ADate2; ?>&includeopenbal=<?php echo $includeopenbal; ?>&location=<?php echo $location; ?>" target="_blank" class="btn btn-outline">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </a>
                    </div>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Ledger</th>
                            <th>Closing Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($location == '') {
                            $locationwise = "and locationcode like '%%'";
                        } else {
                            $locationwise = "and locationcode = '$location'";
                        }
                        
                        $balance_sheet = 0;
                        $income_statement = 0;
                        
                        // Get income statement data
                        $query = "select auto_number as uid,id as code,accountsmain as name,section from master_accountsmain where tb_group = 'I' order by id";
                        $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        $sno = 0;
                        while ($res = mysqli_fetch_array($exec)) {
                            $sno = $sno + 1;
                            $opening_dr_cr = 0;
                            $opening_dr_cr1 = 0;
                            $transaction_dr = 0;
                            $transaction_cr = 0;
                            $closing_dr_cr = 0;
                            $section = $res['section'];
                            $uid = $res['uid'];
                            
                            // Get ledger IDs
                            $array_ledgers_ids = array();
                            $query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='".$res['uid']."')";
                            $exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)) {
                                array_push($array_ledgers_ids, $res_ledger_ids['id']);
                            }
                            
                            $ledger_ids = implode("','", $array_ledgers_ids);
                            
                            // Calculate transactions
                            $opening_dr_cr = 0;
                            $transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and ledger_id!='' and transaction_date between '".$from_date."' and '".$to_date."' $locationwise group by transaction_type";
                            $exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res_transaction = mysqli_fetch_array($exec_transaction)) {
                                if ($res_transaction['transaction_type'] == "D") {
                                    $transaction_dr += $res_transaction['transaction_amount'];
                                } else {
                                    $transaction_cr += $res_transaction['transaction_amount'];
                                }
                            }
                            
                            if ($uid == '4') {
                                $closing_dr_cr = -$transaction_cr;
                            } elseif ($uid == '5') {
                                $closing_dr_cr = $transaction_cr;
                            } else {
                                $closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;
                            }
                            
                            $balance_sheet += $closing_dr_cr;
                            
                            echo '<tr>';
                            echo '<td>' . $sno . '</td>';
                            echo '<td>' . htmlspecialchars($res['code']) . '</td>';
                            echo '<td>' . htmlspecialchars(ucwords(strtolower($res['name']))) . '</td>';
                            echo '<td class="text-right">₹ ' . showAmount($closing_dr_cr, 1) . '</td>';
                            echo '</tr>';
                        }
                        
                        if ($sno == 0) {
                            echo '<tr>';
                            echo '<td colspan="4" class="no-data">';
                            echo '<i class="fas fa-chart-line"></i>';
                            echo '<p>No income statement data found for the specified criteria.</p>';
                            echo '</td>';
                            echo '</tr>';
                        } else {
                            // Add total row
                            echo '<tr class="total-row">';
                            echo '<td colspan="3"><strong>P & L Total:</strong></td>';
                            echo '<td class="text-right"><strong>₹ ' . showAmount($balance_sheet, 1) . '</strong></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Ready to Generate Statement</h3>
                    <p>Select date range and location to generate the branch income statement.</p>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for branch income statement
        function refreshPage() {
            window.location.reload();
        }
        
        function exportToExcel() {
            if (document.getElementById('ADate1').value && document.getElementById('ADate2').value) {
                const fromDate = document.getElementById('ADate1').value;
                const toDate = document.getElementById('ADate2').value;
                const location = document.getElementById('location').value;
                const url = `tb_branchstatement_xl.php?ADate1=${fromDate}&ADate2=${toDate}&includeopenbal=1&location=${location}`;
                window.open(url, '_blank');
            } else {
                alert('Please select date range first to export the statement.');
            }
        }
        
        function FuncPopup() {
            window.scrollTo(0, 0);
            const loader = document.getElementById("imgloader");
            if (loader) {
                loader.style.display = "";
            }
        }
        
        // Form validation
        document.getElementById('incomeForm').addEventListener('submit', function(e) {
            const startDate = document.getElementById('ADate1').value;
            const endDate = document.getElementById('ADate2').value;
            
            if (!startDate || !endDate) {
                e.preventDefault();
                alert('Please select both start and end dates.');
                return false;
            }
            
            if (new Date(startDate) > new Date(endDate)) {
                e.preventDefault();
                alert('Start date cannot be later than end date.');
                return false;
            }
        });
    </script>
</body>
</html>
