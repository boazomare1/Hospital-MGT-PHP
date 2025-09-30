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

// Get request parameters with proper sanitization
$ADate1 = isset($_REQUEST["ADate1"]) ? trim($_REQUEST["ADate1"]) : '';
$ADate2 = isset($_REQUEST["ADate2"]) ? trim($_REQUEST["ADate2"]) : '';
$from_date = isset($_REQUEST["ADate1"]) ? trim($_REQUEST["ADate1"]) : '';
$to_date = isset($_REQUEST["ADate2"]) ? trim($_REQUEST["ADate2"]) : '';
$ADate3 = isset($_REQUEST["ADate3"]) ? trim($_REQUEST["ADate3"]) : date('Y-m-d', strtotime('-0 year'));
$ADate4 = isset($_REQUEST["ADate4"]) ? trim($_REQUEST["ADate4"]) : date('Y-m-d');
$cbfrmflag1 = isset($_REQUEST["cbfrmflag1"]) ? trim($_REQUEST["cbfrmflag1"]) : "";
$location = isset($_REQUEST["location"]) ? trim($_REQUEST["location"]) : "";
$frmflag2 = isset($_REQUEST["frmflag2"]) ? trim($_REQUEST["frmflag2"]) : "";

$includeopenbal = isset($_POST["includeopenbal"]) ? 1 : 0;
$includezeroballeg = isset($_POST["includezeroballeg"]) ? 1 : 0;

// Helper functions
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
    
    $subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where accountsmain='" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $group_id) . "' order by auto_number";
    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die("Error in subgroup_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
    
    while ($res = mysqli_fetch_array($exec)) {
        $ledger_query1 = "select id as code from master_accountname where accountssub='" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res['code']) . "' order by auto_number";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query1) or die("Error in ledger_query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
        
        while ($res1 = mysqli_fetch_array($exec1)) {
            array_push($array_data, $res1['code']);
        }
        
        getAllLedgers($res['code']);
    }	
    
    $ledger_query1 = "select id as code from master_accountname where accountssub='" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $group_id) . "' order by auto_number";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query1) or die("Error in ledger_query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
    
    while ($res1 = mysqli_fetch_array($exec1)) {
        array_push($array_data, $res1['code']);
    }
    
    return $array_data;
}

function getGroupBalance($group_id, $from_date, $to_date, $sno, $sno2, $locationwise, $includeopenbal, $includezeroballeg) {
    $data = "";
    $all_ledgers = getAllLedgers($group_id);
    
    $subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where auto_number='" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $group_id) . "'";
    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die("Error in subgroup_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
    
    while ($res = mysqli_fetch_array($exec)) {
        $opening_dr_cr = 0;
        $transaction_dr = 0;
        $transaction_cr = 0;
        $closing_dr_cr = 0;
        $opening_dr_cr1 = 0;
        
        $query0 = "SELECT accountsmain FROM master_accountssub WHERE auto_number = '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $group_id) . "'";
        $exec0 = mysqli_query($GLOBALS["___mysqli_ston"], $query0) or die("Error in query0" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $res0 = mysqli_fetch_array($exec0);
        $accountsmain = $res0['accountsmain'];
        
        $query1 = "SELECT section FROM master_accountsmain WHERE auto_number = '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $accountsmain) . "'";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $res1 = mysqli_fetch_array($exec1);
        $section = $res1['section'];
        
        $startyear = date('Y', strtotime($from_date));
        $endyear = date('Y', strtotime($to_date));
        
        if ($section == 'I' || $section == 'E') {
            if ($includeopenbal == '0') {
                $financeyearstart = $from_date;
                $openingenddate = $to_date;
            } else {
                $financeyearstart = $startyear . '-01-01';
                $openingenddate = date('Y-m-d', strtotime('-1 day', strtotime($to_date)));
            }
            
            $opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('" . implode("','", $all_ledgers) . "') and ledger_id!='' and transaction_date BETWEEN '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $financeyearstart) . "' AND '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $openingenddate) . "' " . $locationwise . " group by transaction_type";
            $exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die("Error in opening_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while ($res_opening = mysqli_fetch_array($exec_opening)) {
                if ($res_opening['transaction_type'] == "D") {
                    $opening_dr_cr += $res_opening['transaction_amount'];
                } else {
                    $opening_dr_cr -= $res_opening['transaction_amount'];
                }
            }
            
            if ($from_date == $financeyearstart) {
                $opening_dr_cr = 0;
            }
            
            if ($includeopenbal == '1') {
                $opening_query1 = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('" . implode("','", $all_ledgers) . "') and ledger_id!='' and transaction_date < '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $financeyearstart) . "' " . $locationwise . " group by transaction_type";
                $exec_opening1 = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query1) or die("Error in opening_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($res_opening1 = mysqli_fetch_array($exec_opening1)) {
                    if ($res_opening1['transaction_type'] == "D") {
                        $opening_dr_cr1 += $res_opening1['transaction_amount'];
                    } else {
                        $opening_dr_cr1 -= $res_opening1['transaction_amount'];
                    }
                }
            } else {
                $opening_dr_cr1 = 0;
            }
            
            $GLOBALS['ieledgers'] += $opening_dr_cr1;
        } else {
            if ($includeopenbal == '1') {
                $opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and (ledger_id in ('" . implode("','", $all_ledgers) . "')) and ledger_id!='' and transaction_date < '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $from_date) . "' " . $locationwise . " group by transaction_type";
                $exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die("Error in opening_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($res_opening = mysqli_fetch_array($exec_opening)) {
                    if ($res_opening['transaction_type'] == "D") {
                        $opening_dr_cr += $res_opening['transaction_amount'];
                    } else {
                        $opening_dr_cr -= $res_opening['transaction_amount'];
                    }
                }
            } else {
                $opening_dr_cr = 0;
            }
            
            if ($res['code'] == '03-4500') {
                $opening_dr_cr += $GLOBALS['ieledgers'];
            }
        }
        
        $transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('" . implode("','", $all_ledgers) . "') and ledger_id!='' and transaction_date between '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $from_date) . "' and '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $to_date) . "' " . $locationwise . " group by transaction_type";
        $exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die("Error in transaction_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res_transaction = mysqli_fetch_array($exec_transaction)) {
            if ($res_transaction['transaction_type'] == "D") {
                $transaction_dr += $res_transaction['transaction_amount'];
            } else {
                $transaction_cr += $res_transaction['transaction_amount'];
            }
        }
        
        $closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;
        if ($closing_dr_cr != 0 || $includezeroballeg == '1') {
            $uuid = $res['uid'] + 1;
            $data .= "<tr style='background-color: aquamarine;' data-node-id=" . $sno . '.' . $sno2 . " data-node-pid=" . $sno . "><td></td> <td align='right'>" . showAmount($opening_dr_cr, '1') . "</td> <td>" . htmlspecialchars($res['code']) . "</td> <td>" . htmlspecialchars(ucwords(strtolower($res['name']))) . "</td> <td align='right'>" . showAmount($transaction_dr, '0') . "</td> <td align='right'>" . showAmount($transaction_cr, '0') . "</td> <td align='right'>" . showAmount($closing_dr_cr, '1') . "</td> </tr>";
        }
        
        if ($res['show_ledger'] == "1") {
            $data .= getLedger($res['uid'], $from_date, $to_date, $sno, $sno2, $locationwise, $includeopenbal, $includezeroballeg);
        }
    }
    
    echo $data;
}

function getLedger($group_id, $from_date, $to_date, $sno, $sno2, $locationwise, $includeopenbal, $includezeroballeg) {
    $ledger_query = "select auto_number as uid, id as code,accountname as name from master_accountname where accountssub='" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $group_id) . "' order by auto_number";
    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query) or die("Error in ledger_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $data = "";
    
    $sno3 = 0;
    while ($res = mysqli_fetch_array($exec)) {
        $sno3 = $sno3 + 1;
        
        $opening_dr_cr = 0;
        $transaction_dr = 0;
        $transaction_cr = 0;
        $closing_dr_cr = 0;
        $old_opening_dr_cr = 0;
        
        $startyear = date('Y', strtotime($from_date));
        $endyear = date('Y', strtotime($to_date));
        
        if ($includeopenbal == '0') {
            $financeyearstart = $from_date;
        } else {
            $financeyearstart = $startyear . '-01-01';
        }
        
        $ledgerid = $res['code'];
        $query12 = "SELECT accountsmain FROM master_accountname WHERE id= '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $ledgerid) . "'";
        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die("Error in query12" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $res12 = mysqli_fetch_array($exec12);
        $accountsmain12 = $res12['accountsmain'];
        
        $query1 = "SELECT section FROM master_accountsmain WHERE auto_number = '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $accountsmain12) . "'";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $res1 = mysqli_fetch_array($exec1);
        $section = $res1['section'];
        
        if ($includeopenbal == '1') {
            $opening_query = "select ledger_id,transaction_date,transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id='" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res['code']) . "' and ledger_id!='' and transaction_date < '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $from_date) . "' " . $locationwise . " group by transaction_type,transaction_date";
            $exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die("Error in opening_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while ($res_opening = mysqli_fetch_array($exec_opening)) {
                $transactiondate = $res_opening['transaction_date'];
                
                if ($section == 'I' || $section == 'E') {
                    if ($transactiondate < $financeyearstart) {
                        if ($res_opening['transaction_type'] == "D") {
                            $old_opening_dr_cr += $res_opening['transaction_amount'];
                        } else {
                            $old_opening_dr_cr -= $res_opening['transaction_amount'];
                        }
                    } else {
                        if ($res_opening['transaction_type'] == "D") {
                            $opening_dr_cr += $res_opening['transaction_amount'];
                        } else {
                            $opening_dr_cr -= $res_opening['transaction_amount'];
                        }
                    }
                    if ($from_date == $financeyearstart) {
                        $opening_dr_cr = 0;
                    }
                } else {
                    if ($res_opening['transaction_type'] == "D") {
                        $opening_dr_cr += $res_opening['transaction_amount'];
                    } else {
                        $opening_dr_cr -= $res_opening['transaction_amount'];
                    }
                }
            }
        } else {
            $old_opening_dr_cr = 0;
            $opening_dr_cr = 0;
        }
        
        $query01 = "SELECT retainedearning_ledger FROM master_company";
        $exec01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01) or die("Error in query01" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $res01 = mysqli_fetch_array($exec01);
        $retainedledger = $res01['retainedearning_ledger'];
        
        if ($retainedledger == $res['code']) {
            $opening_dr_cr += $GLOBALS['ieledgers'];
        }
        
        $transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id='" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res['code']) . "' and ledger_id!='' and transaction_date between '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $from_date) . "' and '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $to_date) . "' " . $locationwise . " group by transaction_type";
        $exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die("Error in transaction_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res_transaction = mysqli_fetch_array($exec_transaction)) {
            if ($res_transaction['transaction_type'] == "D") {
                $transaction_dr += $res_transaction['transaction_amount'];
            } else {
                $transaction_cr += $res_transaction['transaction_amount'];
            }
        }
        
        $closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;
        $ledgercode = $res['code'];
        
        if ($closing_dr_cr != 0 || $includezeroballeg == '1') {
            $data .= "<tr data-node-id=" . $sno . '.' . $sno2 . '.' . $sno3 . " data-node-pid=" . $sno . '.' . $sno2 . "> <td></td><td align='right'>" . showAmount($opening_dr_cr, '1') . "</td><td width='14%'>" . htmlspecialchars($res['code']) . "</td> <td>" . htmlspecialchars(ucwords(strtolower($res['name']))) . "&nbsp;<a href='ledgerview.php?ledgerid=$ledgercode&&ADate1=$from_date&&ADate2=$to_date' target='_blank' style='font-size:14px;'>&#9432;</a>" . "</td> <td align='right'>" . showAmount($transaction_dr, '0') . "</td> <td align='right'>" . showAmount($transaction_cr, '0') . "</td> <td align='right'>" . showAmount($closing_dr_cr, '1') . "</td> </tr>";
        }
    }
    
    return $data;
}

function getSubgroups($account_id, $from_date, $to_date, $sno, $locationwise, $includeopenbal, $includezeroballeg) {
    $subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where accountsmain='" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $account_id) . "' order by auto_number";
    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die("Error in subgroup_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $data = "";
    
    $sno2 = 0;
    while ($res = mysqli_fetch_array($exec)) {
        $sno2 = $sno2 + 1;
        getGroupBalance($res['uid'], $from_date, $to_date, $sno, $sno2, $locationwise, $includeopenbal, $includezeroballeg);
    }
    
    return $data;
}

function net_profit1($from_date, $to_date) {
    $query = "select auto_number as uid,id as code,accountsmain as name from master_accountsmain where section in ('A','E') order by auto_number";
    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in Query" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $closing_dr_cr = 0;
    
    while ($res = mysqli_fetch_array($exec)) {
        $opening_dr_cr = 0;
        $transaction_dr = 0;
        $transaction_cr = 0;
        
        $array_ledgers_ids = array();
        $query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res['uid']) . "')";
        $exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die("Error in opening_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)) {
            array_push($array_ledgers_ids, $res_ledger_ids['id']);
        }
        
        $ledger_ids = implode("','", $array_ledgers_ids);
        
        $opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('" . $ledger_ids . "') and ledger_id!='' and transaction_date < '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $from_date) . "' group by transaction_type";
        $exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die("Error in opening_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res_opening = mysqli_fetch_array($exec_opening)) {
            if ($res_opening['transaction_type'] == "D") {
                $opening_dr_cr += $res_opening['transaction_amount'];
            } else {
                $opening_dr_cr -= $res_opening['transaction_amount'];
            }
        }
        
        $transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('" . $ledger_ids . "') and ledger_id!='' and transaction_date between '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $from_date) . "' and '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $to_date) . "' group by transaction_type";
        $exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die("Error in transaction_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res_transaction = mysqli_fetch_array($exec_transaction)) {
            if ($res_transaction['transaction_type'] == "D") {
                $transaction_dr += $res_transaction['transaction_amount'];
            } else {
                $transaction_cr += $res_transaction['transaction_amount'];
            }
        }
        
        $closing_dr_cr += $opening_dr_cr + $transaction_dr - $transaction_cr;
    }
    
    return $closing_dr_cr;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Statement - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/incomestatement-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- AutoComplete styles -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <link rel="stylesheet" type="text/css" href="css/simple-grid.min.css" />
    <link rel="stylesheet" href="css/jquery-simple-tree-table.css">
    
    <!-- JavaScript files -->
    <script src="js/datetimepicker_css.js"></script>
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
            <span class="location-info">📍 Company: MedStar Healthcare</span>
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
        <a href="reports.php">📊 Reports</a>
        <span>→</span>
        <span>Income Statement</span>
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
                        <a href="incomestatement.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Income Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="balancesheet.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Balance Sheet</span>
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
                    <h2>Income Statement</h2>
                    <p>Generate comprehensive income statement reports for financial analysis.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </div>

            <!-- Search Form -->
            <div class="search-section">
                <div class="search-header">
                    <i class="fas fa-search search-icon"></i>
                    <h3 class="search-title">Report Parameters</h3>
                </div>
                
                <form name="cbform1" method="post" action="">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Start Date</label>
                            <div class="date-input-group">
                                <input type="text" name="ADate1" id="ADate1" 
                                       class="form-input" 
                                       value="<?php echo $from_date != '' ? htmlspecialchars($from_date) : date('Y-m-d', strtotime('-0 year')); ?>" 
                                       readonly onKeyDown="return disableEnterKey()" />
                                <button type="button" class="date-picker-btn" onClick="javascript:NewCssCal('ADate1')">
                                    <i class="fas fa-calendar-alt"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">End Date</label>
                            <div class="date-input-group">
                                <input type="text" name="ADate2" id="ADate2" 
                                       class="form-input" 
                                       value="<?php echo $from_date != '' ? htmlspecialchars($to_date) : date('Y-m-d'); ?>" 
                                       readonly onKeyDown="return disableEnterKey()" />
                                <button type="button" class="date-picker-btn" onClick="javascript:NewCssCal('ADate2')">
                                    <i class="fas fa-calendar-alt"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-select">
                                <option value="">All Locations</option>
                                <?php
                                $query = "select * from master_employeelocation where username='" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $username) . "' group by locationcode order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res = mysqli_fetch_array($exec)) {
                                    $reslocation = $res["locationname"];
                                    $reslocationanum = $res["locationcode"];
                                    ?>
                                    <option value="<?php echo htmlspecialchars($reslocationanum); ?>" 
                                            <?php if ($location != '' && $location == $reslocationanum) echo "selected"; ?>>
                                        <?php echo htmlspecialchars($reslocation); ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="includeopenbal" id="includeopenbal" value='1' 
                                       <?php if ($includeopenbal == '1') echo 'checked'; ?> />
                                <span class="checkmark"></span>
                                Include Opening Balance
                            </label>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="includezeroballeg" id="includezeroballeg" value='1' 
                                       <?php if ($includezeroballeg == '1') echo 'checked'; ?> />
                                <span class="checkmark"></span>
                                Include Zero Balance Ledgers
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" value="" />
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <?php if (isset($_REQUEST["cbfrmflag1"])): ?>
            <div class="results-section">
                <div class="results-header">
                    <i class="fas fa-table results-icon"></i>
                    <h3 class="results-title">Income Statement Report</h3>
                    <div class="results-actions">
                        <a href="tb_incomestatement_xl.php?ADate1=<?php echo htmlspecialchars($ADate1); ?>&ADate2=<?php echo htmlspecialchars($ADate2); ?>&includeopenbal=<?php echo $includeopenbal; ?>&location=<?php echo htmlspecialchars($location); ?>&includezeroballeg=<?php echo $includezeroballeg; ?>" 
                           id="downloadLink" target="_blank" class="btn btn-outline">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
                
                <div class="table-container">
                    <?php
                    if ($location == '') {
                        $locationwise = "and locationcode like '%%'";
                    } else {
                        $locationwise = "and locationcode = '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $location) . "'";
                    }
                    ?>
                    
                    <table id='collapsed' class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Opening</th>
                                <th>Code</th>
                                <th>Ledger</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Closing</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $from_date = $ADate1;
                            $to_date = $ADate2;
                            
                            $balance_sheet = 0;
                            $income_statement = 0;
                            
                            $query = "select auto_number as uid,id as code,accountsmain as name,section from master_accountsmain where tb_group = 'I' order by id";
                            $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in Query" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            $sno = 0;
                            while ($res = mysqli_fetch_array($exec)) {
                                $sno = $sno + 1;
                                $opening_dr_cr = 0;
                                $opening_dr_cr1 = 0;
                                $transaction_dr = 0;
                                $transaction_cr = 0;
                                $closing_dr_cr = 0;
                                $section = $res['section'];
                                
                                $array_ledgers_ids = array();
                                $query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res['uid']) . "')";
                                $exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die("Error in opening_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)) {
                                    array_push($array_ledgers_ids, $res_ledger_ids['id']);
                                }
                                
                                $ledger_ids = implode("','", $array_ledgers_ids);
                                
                                $startyear = date('Y', strtotime($from_date));
                                $endyear = date('Y', strtotime($to_date));
                                
                                if ($section == 'E' || $section == 'I') {
                                    if ($includeopenbal == '0') {
                                        $financeyearstart = $from_date;
                                        $openingenddate = $to_date;
                                    } else {
                                        $financeyearstart = $startyear . '-01-01';
                                        $openingenddate = date('Y-m-d', strtotime('-1 day', strtotime($to_date)));
                                    }
                                    
                                    $opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('" . $ledger_ids . "') and ledger_id!='' and transaction_date BETWEEN '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $financeyearstart) . "' AND '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $openingenddate) . "' " . $locationwise . " group by transaction_type";
                                    $exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die("Error in opening_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res_opening = mysqli_fetch_array($exec_opening)) {
                                        if ($res_opening['transaction_type'] == "D") {
                                            $opening_dr_cr += $res_opening['transaction_amount'];
                                        } else {
                                            $opening_dr_cr -= $res_opening['transaction_amount'];
                                        }
                                    }
                                    
                                    if ($from_date == $financeyearstart) {
                                        $opening_dr_cr = 0;
                                    }
                                    
                                    if ($includeopenbal == '1') {
                                        $opening_query1 = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('" . $ledger_ids . "') and ledger_id!='' and transaction_date < '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $financeyearstart) . "' " . $locationwise . " group by transaction_type";
                                        $exec_opening1 = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query1) or die("Error in opening_query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while ($res_opening1 = mysqli_fetch_array($exec_opening1)) {
                                            if ($res_opening1['transaction_type'] == "D") {
                                                $opening_dr_cr1 += $res_opening1['transaction_amount'];
                                            } else {
                                                $opening_dr_cr1 -= $res_opening1['transaction_amount'];
                                            }
                                        }
                                    } else {
                                        $opening_dr_cr1 = 0;
                                    }
                                    
                                    $GLOBALS['eal'] += $opening_dr_cr1;
                                } else {
                                    if ($includeopenbal == '1') {
                                        $opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('" . $ledger_ids . "') and ledger_id!='' and transaction_date < '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $from_date) . "' " . $locationwise . " group by transaction_type";
                                        $exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die("Error in opening_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while ($res_opening = mysqli_fetch_array($exec_opening)) {
                                            if ($res_opening['transaction_type'] == "D") {
                                                $opening_dr_cr += $res_opening['transaction_amount'];
                                            } else {
                                                $opening_dr_cr -= $res_opening['transaction_amount'];
                                            }
                                        }
                                    } else {
                                        $opening_dr_cr = 0;
                                    }
                                }
                                
                                $transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('" . $ledger_ids . "') and ledger_id!='' and transaction_date between '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $from_date) . "' and '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $to_date) . "' " . $locationwise . " group by transaction_type";
                                $exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die("Error in transaction_query" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res_transaction = mysqli_fetch_array($exec_transaction)) {
                                    if ($res_transaction['transaction_type'] == "D") {
                                        $transaction_dr += $res_transaction['transaction_amount'];
                                    } else {
                                        $transaction_cr += $res_transaction['transaction_amount'];
                                    }
                                }
                                
                                $closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;
                                $balance_sheet += $closing_dr_cr;
                                
                                echo "<tr data-node-id='" . $sno . "'>";
                                echo "<td></td>";
                                echo "<td align='right'>" . showAmount($opening_dr_cr, '1') . "</td>";
                                echo "<td>" . htmlspecialchars($res['code']) . "</td>";
                                echo "<td>" . htmlspecialchars(ucwords(strtolower($res['name']))) . "</td>";
                                echo "<td align='right'>" . showAmount($transaction_dr, '0') . "</td>";
                                echo "<td align='right'>" . showAmount($transaction_cr, '0') . "</td>";
                                echo "<td align='right'>" . showAmount($closing_dr_cr, '1') . "</td>";
                                echo "</tr>";
                                
                                echo getSubgroups($res['uid'], $from_date, $to_date, $sno, $locationwise, $includeopenbal, $includezeroballeg);
                            }
                            
                            $t1 = showAmount(net_profit1($from_date, $to_date), 1);
                            echo "<tr class='total-row'>";
                            echo "<td colspan='4' align='right'><strong>P & L:</strong></td>";
                            echo "<td colspan='2' align='right'><strong>" . showAmount($balance_sheet, '1') . "</strong></td>";
                            echo "</tr>";
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/incomestatement-modern.js?v=<?php echo time(); ?>"></script>
    <script src="js/jquery-simple-tree-table.js"></script>
    
    <script type="text/javascript">
        $('#collapsed').simpleTreeTable({
            opened: [0]
        });
    </script>
    
    <?php include ("includes/footer1.php"); ?>
</body>
</html>
