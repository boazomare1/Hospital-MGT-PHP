<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$docno = $_SESSION['docno'];
$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Initialize variables
$errmsg = "";
$bgcolorcode = "";
$fromdate = isset($_POST['ADate1']) ? $_POST['ADate1'] : $transactiondatefrom;
$todate = isset($_POST['ADate2']) ? $_POST['ADate2'] : $transactiondateto;
$searchstorecode = isset($_POST['searchstorecode']) ? $_POST['searchstorecode'] : '';

// Get location details
$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationname"];
$res7locationanum = $res1["locationcode"];

// Handle form submission
if (isset($_POST["cbfrmflag1"])) { 
    $cbfrmflag1 = $_POST["cbfrmflag1"]; 
} else { 
    $cbfrmflag1 = ""; 
}

if ($cbfrmflag1 == 'cbfrmflag1') {
    $fromdate = $_POST['ADate1'];
    $todate = $_POST['ADate2'];
    $searchstorecode = $_POST['searchstorecode'];
    
    $errmsg = "Branch GIT requests filtered successfully.";
    $bgcolorcode = 'success';
}

// Count pending requests
$querynw1 = "select auto_number from branch_stock_transfer where recordstatus='pending' and Date(updatedatetime) between '$fromdate' and '$todate' and tostore='$searchstorecode' and tolocationcode='$res7locationanum' group by docno order by auto_number desc";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_num_rows($execnw1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch GIT Management - MedStar</title>
    
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
        <span>Branch GIT Management</span>
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
                    <li class="nav-item active">
                        <a href="branch_git.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Branch GIT</span>
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
                    <h2>Branch GIT Management</h2>
                    <p>Manage goods-in-transit requests between branches with comprehensive tracking and approval workflow.</p>
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

            <!-- Search Filter Form -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-filter add-form-icon"></i>
                    <h3 class="add-form-title">Branch GIT Filter</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="branch_git.php" class="add-form">
                    <div class="form-group">
                        <label for="searchstorecode" class="form-label">Store</label>
                        <select name="searchstorecode" id="searchstorecode" class="form-input">
                            <option value="">Select Store</option>
                            <?php
                            $query2 = "SELECT storecode,defaultstore from master_employeelocation WHERE username='$username' and defaultstore='default' and locationcode='$res7locationanum'";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $storecode = '';
                            while ($res2 = mysqli_fetch_array($exec2)) {
                                $storecodeanum = $res2['storecode'];
                                $defaultstore = $res2['defaultstore'];
                                $query751 = "select store, storecode from master_store where auto_number='$storecodeanum'";
                                $exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res751 = mysqli_fetch_array($exec751);
                                $res2store = $res751['store'];
                                $storecode = $res751['storecode'];
                                if ($storecode != "") {
                                    $selected = ($searchstorecode == $storecode) ? "selected" : "";
                                    echo '<option value="'.$storecode.'" '.$selected.'>'.$res2store.'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="ADate1" class="form-label">Date From</label>
                        <input type="date" name="ADate1" id="ADate1" class="form-input" value="<?php echo $fromdate; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="ADate2" class="form-label">Date To</label>
                        <input type="date" name="ADate2" id="ADate2" class="form-input" value="<?php echo $todate; ?>">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                </form>
            </div>

            <!-- Requests Summary -->
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-card-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="summary-card-content">
                        <h3><?php echo $resnw1; ?></h3>
                        <p>Pending Requests</p>
                    </div>
                </div>
            </div>

            <!-- GIT Requests List -->
            <div class="data-section">
                <div class="data-section-header">
                    <h3>GIT Requests</h3>
                    <p>Date Range: <strong><?php echo date('Y-m-d', strtotime($fromdate)); ?></strong> to <strong><?php echo date('Y-m-d', strtotime($todate)); ?></strong></p>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Date</th>
                            <th>Doc No.</th>
                            <th>From Location</th>
                            <th>From Store</th>
                            <th>Amount</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $colorloopcount = '';
                        $sno = '';
                        
                        if ($searchstorecode != '') {
                            $query1 = "select sum(amount) as totamt,tolocationcode as from_location,fromstore,updatedatetime,docno,tostore,typetransfer,username,locationcode as tolctcode,requestdocno from branch_stock_transfer where recordstatus='pending' and Date(updatedatetime) between '$fromdate' and '$todate' and tostore='$searchstorecode' and tolocationcode='$res7locationanum' group by docno order by auto_number desc";
                        } else {
                            $query1 = "select sum(amount) as totamt,tolocationcode as from_location,fromstore,updatedatetime,docno,tostore,typetransfer,username,locationcode as tolctcode,requestdocno from branch_stock_transfer where recordstatus='pending' and Date(updatedatetime) between '$fromdate' and '$todate' and tostore='$searchstorecode' and tolocationcode='$res7locationanum' group by docno order by auto_number desc";
                        }
                        
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $from = $res1['fromstore'];
                            $fromlocation = $res1['from_location'];
                            $tolocation = $res1['tolctcode'];
                            $date = $res1['updatedatetime'];
                            $docno = $res1['docno'];
                            $to = $res1['tostore'];
                            $typetransfer = $res1['typetransfer'];
                            $requser = $res1['username'];
                            $requestdocno = $res1['requestdocno'];
                            $totamt = $res1['totamt'];
                            
                            // Get store name
                            $query4 = "select store from master_store WHERE storecode = '".$from."'";
                            $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res4 = mysqli_fetch_array($exec4);
                            $storename = $res4["store"];
                            
                            // Get location name
                            $query_location = "SELECT locationname from master_location WHERE locationcode = '".$tolocation."'";
                            $exec_location = mysqli_query($GLOBALS["___mysqli_ston"], $query_location) or die ("Error in Query_location".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res_location = mysqli_fetch_array($exec_location);
                            $from_location_name = $res_location["locationname"];
                            
                            // Get store details
                            $query3 = "select auto_number from master_store WHERE storecode = '".$to."'";
                            $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res3 = mysqli_fetch_array($exec3);
                            $storeanum = $res3["auto_number"];
                            
                            // Check user access
                            $query2 = "select storecode from master_employeelocation WHERE storecode = '".$storeanum."' and username='$username'";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res2 = mysqli_fetch_array($exec2);
                            $num2 = mysqli_num_rows($exec2);
                            $store = $res2["storecode"];
                            
                            // Get remarks
                            $query341 = "select * from master_branchstockrequest where docno='$requestdocno'";
                            $exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            $nums341 = mysqli_num_rows($exec341);
                            $res341 = mysqli_fetch_array($exec341);
                            $remarks = $res341['remarks'];
                            
                            $timestamp = strtotime($date);
                            $child1 = date('j/n/Y', $timestamp);
                            $child2 = date('H:i', $timestamp);
                            
                            if ($typetransfer == '1') {
                                $num2 = 1;
                            }
                            
                            if ($num2 > 0) {
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1);
                                
                                if ($showcolor == 0) {
                                    $colorcode = 'bgcolor="#CBDBFA"';
                                } else {
                                    $colorcode = 'bgcolor="#ecf0f5"';
                                }
                                
                                echo '<tr '.$colorcode.'>';
                                echo '<td>' . ($sno = $sno + 1) . '</td>';
                                echo '<td>' . $child1 . '</td>';
                                echo '<td>' . htmlspecialchars($docno) . '</td>';
                                echo '<td>' . htmlspecialchars($from_location_name) . '</td>';
                                echo '<td>' . htmlspecialchars($storename . ' - ' . $requser) . '</td>';
                                echo '<td>₹ ' . number_format($totamt, 2, '.', ',') . '</td>';
                                echo '<td>' . htmlspecialchars($remarks) . '</td>';
                                echo '<td class="action-buttons">';
                                echo '<a href="branch_git_view.php?docno=' . $docno . '" class="btn btn-info btn-sm">';
                                echo '<i class="fas fa-eye"></i> View';
                                echo '</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                        
                        if ($sno == 0) {
                            echo '<tr>';
                            echo '<td colspan="8" class="no-data">';
                            echo '<i class="fas fa-truck"></i>';
                            echo '<p>No GIT requests found for the specified criteria.</p>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for branch GIT management
        function refreshPage() {
            window.location.reload();
        }
        
        function exportToExcel() {
            // Export functionality can be implemented here
            alert('Export functionality will be implemented');
        }
        
        // Prevent default link behavior
        $(function(){
            $('a.prevent').each(function() {
                var href = $(this).attr('href');
                $(this).attr('href','javascript:void(0);');
                $(this).attr('jshref',href);
            });
            
            $('a.prevent').bind('click', function(e) {
                e.stopImmediatePropagation();           
                e.preventDefault();
                e.stopPropagation();
                var href = $(this).attr('jshref');
                if (!e.metaKey && e.ctrlKey)
                    e.metaKey = e.ctrlKey;
                if (!e.metaKey) {
                    location.href = href;
                }
                return false;
            });
            
            $("a.prevent").on("contextmenu", function(){
                if (event.button == 2) {
                    return false;
                }
            });
        });
        
        function cbcustomername1() {
            document.cbform1.submit();
        }
        
        function pharmacy(patientcode, visitcode) {
            var patientcode = patientcode;
            var visitcode = visitcode;
            var url = "pharmacy1.php?RandomKey=" + Math.random() + "&&patientcode=" + patientcode + "&&visitcode=" + visitcode;
            window.open(url, "Pharmacy", 'width=600,height=400');
        }
    </script>
</body>
</html>
