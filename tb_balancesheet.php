
<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d'); 
$username = $_SESSION['username'];
$GLOBALS['eal'] = 0;
$GLOBALS['ieledgers'] = 0;
$GLOBALS['revenue'] = 0;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ''; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ''; }

if (isset($_REQUEST["ADate1"])) { $from_date = $_REQUEST["ADate1"]; } else { $from_date = ''; }
if (isset($_REQUEST["ADate2"])) { $to_date = $_REQUEST["ADate2"]; } else { $to_date = ''; }

if (isset($_REQUEST["ADate3"])) { $ADate3 = $_REQUEST["ADate3"]; } else { $ADate3 = date('Y-m-d', strtotime('-0 year')); }
if (isset($_REQUEST["ADate4"])) { $ADate4 = $_REQUEST["ADate4"]; } else { $ADate4 = date('Y-m-d'); }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

// Get location details
$locationdetails = "select locationcode, locationname from login_locationdetails where username='$username' and docno='$docno'";
$exeloc = mysqli_query($GLOBALS["___mysqli_ston"], $locationdetails);
$resloc = mysqli_fetch_array($exeloc);
$locationcode = $resloc['locationcode'];
$locationname = $resloc['locationname'];

// Balance Sheet Functions
function showAmount($amount, $show_rule) {
    if ($show_rule == '1') {
        if ($amount >= 0) {
            return "Dr " . number_format(abs($amount), 2);
        } else {
            return "Cr " . number_format(abs($amount), 2);
        }
    } else {
        return number_format(abs($amount), 2);
    }
}

function getAllLedgers($group_id) {
    $array_data = [];
    
    $subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where accountsmain='$group_id' order by auto_number";
    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    while ($res = mysqli_fetch_array($exec)) {
        $ledger_query1 = "select id as code from master_accountname where accountssub='".$res['code']."' order by auto_number";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query1) or die ("Error in ledger_query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        while ($res1 = mysqli_fetch_array($exec1)) {
            array_push($array_data, $res1['code']);
        }
        
        getAllLedgers($res['code']);
    }
    
    $ledger_query1 = "select id as code from master_accountname where accountssub='$group_id' order by auto_number";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query1) or die ("Error in ledger_query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    while ($res1 = mysqli_fetch_array($exec1)) {
        array_push($array_data, $res1['code']);
    }
    
    return $array_data;
}

function getGroupBalance($group_id, $from_date, $to_date, $sno, $sno2) {
    $data = "";
    $all_ledgers = getAllLedgers($group_id);
    $opening_dr_cr1 = 0;
    
    $query1 = "select auto_number as uid,id as code,accountsmain as name,section from master_accountsmain where tb_group = 'I' order by section";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    while ($res1 = mysqli_fetch_array($exec1)) {
        $array_ledgers_ids2 = array();
        
        $query_ledger_ids2 = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='".$res1['uid']."')";
        $exec_ledger_ids2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids2) or die ("Error in opening_query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        while ($res_ledger_ids2 = mysqli_fetch_array($exec_ledger_ids2)) {
            array_push($array_ledgers_ids2, $res_ledger_ids2['id']);
        }
        
        $ledger_ids2 = implode("','", $array_ledgers_ids2);
        
        $startyear = date('Y', strtotime($from_date));
        $endyear = date('Y', strtotime($to_date));		
        $financeyearstart = $startyear.'-01-01';
        
        $opening_query1 = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids2."') and ledger_id!='' and transaction_date < '".$endyear."' group by transaction_type ";
        $exec_opening1 = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query1) or die ("Error in opening_query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        // Continue with your existing logic...
    }
    
    return $data;
}

function net_profit3($from_date, $to_date) {
    $query = "select auto_number as uid,id as code,accountsmain as name from master_accountsmain where section in ('L') order by section,auto_number";
    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
    $closing_dr_cr = 0;
    
    while ($res = mysqli_fetch_array($exec)) {
        $opening_dr_cr = 0;
        $transaction_dr = 0;
        $transaction_cr = 0;
        
        $array_ledgers_ids = array();
        $query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='".$res['uid']."')";
        $exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        while ($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)) {
            array_push($array_ledgers_ids, $res_ledger_ids['id']);
        }
        
        $ledger_ids = implode("','", $array_ledgers_ids);
        
        $opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and ledger_id!='' and transaction_date < '".$from_date."' group by transaction_type";
        $exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        while ($res_opening = mysqli_fetch_array($exec_opening)) {
            if ($res_opening['transaction_type'] == "D") {
                $opening_dr_cr += $res_opening['transaction_amount'];
            } else {
                $opening_dr_cr -= $res_opening['transaction_amount'];
            }
        }
        
        $transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and ledger_id!='' and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type";
        $exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        while ($res_transaction = mysqli_fetch_array($exec_transaction)) {
            if ($res_transaction['transaction_type'] == "D") {
                $transaction_dr += $res_transaction['transaction_amount'];
            } else {
                $transaction_cr += $res_transaction['transaction_amount'];
            }
        }
    }
    
    return $closing_dr_cr;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trial Balance - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/tb_balancesheet-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <link rel="stylesheet" type="text/css" href="css/simple-grid.min.css" />
    <link rel="stylesheet" href="css/jquery-simple-tree-table.css">
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
            <span class="location-info">📍 Location: <?php echo htmlspecialchars($locationname); ?></span>
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
        <span>Trial Balance</span>
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
                        <a href="automaticpi.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Purchase Indent</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="monthlyconsumption.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Monthly Consumption</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="tb_balancesheet.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Trial Balance</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbank1.php" class="nav-link">
                            <i class="fas fa-university"></i>
                            <span>Bank Management</span>
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
                    <h2>Trial Balance</h2>
                    <p>Generate and view trial balance reports for financial analysis.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-primary" onclick="printReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="search-filter-section">
                <div class="search-filter-header">
                    <i class="fas fa-search search-filter-icon"></i>
                    <h3 class="search-filter-title">Report Parameters</h3>
                </div>
                
                <form method="post" name="form1" action="tb_balancesheet.php" class="search-filter-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" class="form-input" 
                                   value="<?php echo $ADate1; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" class="form-input" 
                                   value="<?php echo $ADate2; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">
                            <i class="fas fa-undo"></i> Clear
                        </button>
                    </div>
                </form>
            </div>

            <!-- Trial Balance Report Section -->
            <?php if($cbfrmflag1 == 'cbfrmflag1') { ?>
            <div class="trial-balance-section">
                <div class="trial-balance-header">
                    <i class="fas fa-balance-scale trial-balance-icon"></i>
                    <h3 class="trial-balance-title">Trial Balance Report</h3>
                    <div class="report-summary">
                        <span class="summary-item">
                            <i class="fas fa-calendar"></i>
                            Period: <?php echo date('d/m/Y', strtotime($from_date)); ?> - <?php echo date('d/m/Y', strtotime($to_date)); ?>
                        </span>
                    </div>
                </div>

                <div class="table-container">
                    <table class="trial-balance-table" id="tblData">
                        <thead>
                            <tr>
                                <th>Opening Balance</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Closing Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Your existing PHP logic for displaying trial balance data goes here
                            // This is a placeholder for the actual data display
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/tb_balancesheet-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script src="js/jquery-simple-tree-table.js"></script>
    <script type="text/javascript">
        $('#collapsed').simpleTreeTable({
            opened: [0]
        });

        $('#basic').simpleTreeTable({
            opened: [0]
        });

        $("#btnExport").click(function(e) {
            let file = new Blob([$('#tblData').html()], {type:"application/vnd.ms-excel"});
            let url = URL.createObjectURL(file);
            let a = $("<a />", {
                href: url,
                download: "trial_balance.xls"
            })
            .appendTo("body")
            .get(0)
            .click();
            e.preventDefault();
        });
    </script>
</body>
</html>
