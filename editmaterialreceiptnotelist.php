<?php
session_start();

include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

// Get company information
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);

// Generate bill number
$paynowbillprefix = 'PO-';
$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from purchase_ordergeneration order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);

if ($billnumber == '') {
    $billnumbercode ='PO-'.'1';
    $openingbalance = '0.00';
} else {
    $billnumber = $res2["docno"];
    $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
    $billnumbercode = intval($billnumbercode);
    $billnumbercode = $billnumbercode + 1;
    $maxanum = $billnumbercode;
    $billnumbercode = 'PO-' .$maxanum;
    $openingbalance = '0.00';
}

// Get total count of MRN records
$query1 = "select * from materialreceiptnote_details where typeofpurchase='Process' and itemstatus='' group by billnumber";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
$resnw1=mysqli_num_rows($exec1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Receipt Note List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/material-receipt-note-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/autocomplete_customer1.js"></script>
    <script type="text/javascript" src="js/autosuggest3.js"></script>
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
        <span>Material Receipt Notes</span>
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
                        <a href="purchase_order.php" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Purchase Orders</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="editmaterialreceiptnotelist.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Material Receipt Notes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="inventory.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Inventory</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="supplier_master.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Suppliers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
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
                    <h2>Material Receipt Notes (MRN)</h2>
                    <p>View and manage all material receipt notes for purchase orders.</p>
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
            
            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-clipboard-list data-table-icon"></i>
                    <h3 class="data-table-title">Material Receipt Notes List</h3>
                </div>
                
                <!-- Search Bar -->
                <div class="search-bar">
                    <input type="text" id="searchInput" class="search-input" 
                           placeholder="Search by MRN number, PO number, or date..." 
                           oninput="searchMRNRecords(this.value)">
                    <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                        <i class="fas fa-times"></i> Clear
                    </button>
                    <span class="row-count-display text-right"><?php echo $resnw1; ?> records</span>
                </div>
                
                <!-- Data Table -->
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>PO Number</th>
                            <th>MRN Number</th>
                            <th>Actions</th>
                            <th>Print</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $colorloopcount = 0;
                        $sno = 0;
                        
                        $query1 = "select * from materialreceiptnote_details where typeofpurchase='Process' and itemstatus='' group by billnumber order by entrydate desc";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
                        
                        while($res1=mysqli_fetch_array($exec1)) {
                            $date = $res1['entrydate'];
                            $mrnno = $res1['billnumber'];
                            $pono = $res1['ponumber'];
                            $colorloopcount++;
                            $sno++;
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $sno; ?></td>
                                <td class="text-center"><?php echo date('d/m/Y', strtotime($date)); ?></td>
                                <td class="text-center">
                                    <span class="status-badge status-active"><?php echo htmlspecialchars($pono); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="status-badge status-pending"><?php echo htmlspecialchars($mrnno); ?></span>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="editmaterialreceiptnote.php?ponumber=<?php echo urlencode($pono); ?>&mrnnumber=<?php echo urlencode($mrnno); ?>" 
                                           class="action-btn edit" title="Edit MRN">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="print_mrn_dmp4inch1.php?billautonumber=<?php echo urlencode($mrnno); ?>&billnum=<?php echo urlencode($pono); ?>" 
                                           target="_blank" class="action-btn print" title="Print MRN">
                                            <i class="fas fa-print"></i> Print
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                
                <!-- Pagination or Additional Info -->
                <div style="padding: var(--spacing-lg); text-align: center; background: var(--light-gray); border-top: 1px solid #e0e0e0;">
                    <p style="margin: 0; color: var(--gray); font-size: var(--font-size-sm);">
                        Showing <?php echo $resnw1; ?> Material Receipt Note(s) • Last updated: <?php echo date('d/m/Y H:i'); ?>
                    </p>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/material-receipt-note-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript -->
    <script>
    function cbcustomername1() {
        document.cbform1.submit();
    }
    
    function loadprintpage1(banum) {
        var banum = banum;
        window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
    }
    
    function disableEnterKey(varPassed) {
        if (event.keyCode==8) {
            event.keyCode=0; 
            return event.keyCode 
            return false;
        }
        
        var key;
        if(window.event) {
            key = window.event.keyCode;     //IE
        } else {
            key = e.which;     //firefox
        }
        
        if(key == 13) // if enter key press
        {
            return false;
        } else {
            return true;
        }
    }
    
    window.onload = function () {
        var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
    }
    </script>
    
    <input type="hidden" name="doccno" value="<?php echo $billnumbercode; ?>">
</body>
</html>
