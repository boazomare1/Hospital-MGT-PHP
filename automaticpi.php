<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");
$docno = $_SESSION['docno'];

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["frmflag45"])) { $frmflag45 = $_REQUEST["frmflag45"]; } else { $frmflag45 = ""; }
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $suppliercode = $_REQUEST["searchsuppliercode"]; } else { $suppliercode = ""; }

if ($frm1submit1 == 'frm1submit1') {
    $locationcode = $_REQUEST['locationcode'];	
    $query7 = "select * from master_location where locationcode = '$locationcode'";
    $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res7 = mysqli_fetch_array($exec7);
    $locationname = $res7['locationname'];
    $purchasetype = 'Medical';
    $paynowbillprefix = 'PI-';
    
    $storecode = $_REQUEST['storecode'];
    $query71 = "select * from master_store where storecode = '$storecode'";
    $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die ("Error in Query71".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res71 = mysqli_fetch_array($exec71);
    $storename = $res71['store'];
    
    $paynowbillprefix1 = strlen($paynowbillprefix);
    $query2 = "select * from purchase_indent order by auto_number desc limit 0, 1";
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res2 = mysqli_fetch_array($exec2);
    $billnumber = $res2["docno"];
    $billdigit = strlen($billnumber);
    
    if ($billnumber == '') {
        $billnumbercode = $paynowbillprefix . '00001';
    } else {
        $billnumbercode = $paynowbillprefix . str_pad((intval(substr($billnumber, $paynowbillprefix1)) + 1), 5, '0', STR_PAD_LEFT);
    }
}

// Get location details
$locationdetails = "select locationcode, locationname from login_locationdetails where username='$username' and docno='$docno'";
$exeloc = mysqli_query($GLOBALS["___mysqli_ston"], $locationdetails);
$resloc = mysqli_fetch_array($exeloc);
$locationcode = $resloc['locationcode'];
$locationname = $resloc['locationname'];

if($location != '') {
    $locationcode = $location;
    $query12 = "select locationname from login_locationdetails where locationcode='$location' order by locationname";
    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res12 = mysqli_fetch_array($exec12);
    $res1location = $res12["locationname"];
} else {
    $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);
    $res1location = $res1["locationname"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automatic Purchase Indent - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/automaticpi-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
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
            <span class="location-info">📍 Location: <?php echo htmlspecialchars($res1location); ?></span>
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
        <span>Automatic Purchase Indent</span>
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
                        <a href="automaticpi.php" class="nav-link active">
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
                    <li class="nav-item">
                        <a href="balancesheet.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Balance Sheet</span>
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
                <!-- Alerts will be displayed here -->
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Automatic Purchase Indent</h2>
                    <p>Generate purchase indents automatically based on consumption patterns.</p>
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

            <!-- Search and Filter Section -->
            <div class="search-filter-section">
                <div class="search-filter-header">
                    <i class="fas fa-search search-filter-icon"></i>
                    <h3 class="search-filter-title">Search & Filter Parameters</h3>
                </div>
                
                <form method="post" name="form2" action="automaticpi.php" class="search-filter-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="locationcode" class="form-label">Location</label>
                            <select name="locationcode" id="locationcode" class="form-input" required>
                                <option value="">Select Location</option>
                                <?php
                                $query1 = "select * from master_location where status <> 'deleted' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1locationname = $res1["locationname"];
                                    $res1locationcode = $res1["locationcode"];
                                    $selected = ($locationcode == $res1locationcode) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $res1locationcode; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($res1locationname); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="storecode" class="form-label">Store</label>
                            <select name="storecode" id="storecode" class="form-input" required>
                                <option value="">Select Store</option>
                                <?php
                                $query1 = "select * from master_store where status <> 'deleted' order by store";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1store = $res1["store"];
                                    $res1storecode = $res1["storecode"];
                                    $selected = ($store == $res1storecode) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $res1storecode; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($res1store); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Select Supplier</label>
                            <input type="text" name="searchsuppliername" id="searchsuppliername" 
                                   class="form-input" placeholder="Search supplier..." autocomplete="off">
                            <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="">
                        </div>

                        <div class="form-group">
                            <label for="categoryid" class="form-label">Category</label>
                            <select name="categoryid" id="categoryid" class="form-input">
                                <option value="">Select Category</option>
                                <?php
                                if (isset($_REQUEST["categoryid"])) { $categoryid = $_REQUEST["categoryid"]; } else { $categoryid = ""; }
                                $query1 = "select * from master_categorypharmacy where status <> 'deleted' order by categoryname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1categoryname = $res1["categoryname"];
                                    $catid = $res1["auto_number"];
                                    $selected = ($categoryid == $res1categoryname) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $res1categoryname; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($res1categoryname); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date</label>
                            <input type="text" name="ADate1" id="ADate1" class="form-input" 
                                   value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="frmflag45" id="frmflag45" value="frmflag45">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">
                            <i class="fas fa-undo"></i> Clear
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <?php if($frmflag45 == 'frmflag45') { ?>
            <div class="results-section">
                <div class="results-header">
                    <i class="fas fa-list results-icon"></i>
                    <h3 class="results-title">Search Results</h3>
                </div>

                <form method="post" name="form1" action="automaticpi.php" class="results-form">
                    <div class="table-container">
                        <table class="results-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Pack Size</th>
                                    <th>Status</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Your existing PHP logic for displaying results goes here
                                // This is a placeholder for the actual data display
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="frm1submit1" value="frm1submit1" />
                        <input type="hidden" name="doccno" value="<?php echo isset($billnumbercode) ? $billnumbercode : ''; ?>">
                        <button type="submit" name="submit" class="btn btn-primary" onclick="return itemcheck();">
                            <i class="fas fa-file-invoice"></i> Generate Indent
                        </button>
                    </div>
                </form>
            </div>
            <?php } ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/automaticpi-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script language="javascript">
    function itemcheck() {
        // Implementation for item validation
        return true;
    }

    function clearForm() {
        document.getElementById('searchsuppliername').value = '';
        document.getElementById('searchsuppliercode').value = '';
        document.getElementById('categoryid').value = '';
    }
    </script>
</body>
</html>



