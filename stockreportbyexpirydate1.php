<?php
session_start();
set_time_limit(0);

include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

date_default_timezone_set('Asia/Calcutta'); 

$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$companycode = $_SESSION["companycode"];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$searchmedicinename = "";
$colorloopcount = '';
$openingbalance = 0;
$user = '';

$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
$transactiondateto = date('Y-m-d');
$ADate1 = $transactiondatefrom;
$ADate2 = $transactiondateto;

// Handle form submissions
if (isset($_REQUEST["medicinecode"])) { $medicinecode = $_REQUEST["medicinecode"]; } else { $medicinecode = ""; }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    if (isset($_REQUEST["searchitemcode"])) { $medicinecode = $_REQUEST["searchitemcode"]; } else { $medicinecode = ""; }
    if (isset($_REQUEST["itemname"])) { $searchmedicinename = $_REQUEST["itemname"]; } else { $searchmedicinename = ""; }
    if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
    if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
    if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
    if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
}

// Get location details
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

$locationcode = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Report by Expiry Date - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/stock-report-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for datepicker -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script type="text/javascript" src="js/autosuggestmedicine2.js"></script>
    <script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>
    <script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    <link href="js/jquery-ui.css" rel="stylesheet">
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
        <a href="inventory_master.php">Inventory Management</a>
        <span>→</span>
        <span>Stock Report by Expiry Date</span>
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
                        <a href="inventory_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Inventory Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="expirydtupdate.php" class="nav-link">
                            <i class="fas fa-calendar-times"></i>
                            <span>Expiry Date Update</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="stockreportbyexpirydate1.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Stock Report by Expiry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stock_report.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Stock Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="inventory_reports.php" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>Inventory Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="supplier_master.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Supplier Management</span>
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
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Stock Report by Expiry Date</h2>
                    <p>Generate comprehensive reports of inventory items by their expiry date range with advanced filtering options.</p>
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
            
            <!-- Search Form Section -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-search"></i>
                    <h3>Report Criteria</h3>
                    <span class="form-help">Filter stock items by location, store, category, and expiry date range</span>
                </div>
                
                <form name="stockinward" action="stockreportbyexpirydate1.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return Locationcheck()">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="location" class="form-label required">Location</label>
                            <select name="location" id="location" class="form-select" onChange="storefunction(this.value)">
                                <option value="">-Select Location-</option>
                                <?php
                                $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res = mysqli_fetch_array($exec)) {
                                    $reslocation = $res["locationname"];
                                    $reslocationanum = $res["locationcode"];
                                ?>
                                <option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>>
                                    <?php echo htmlspecialchars($reslocation); ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="store" class="form-label required">Store</label>
                            <select name="store" id="store" class="form-select">
                                <option value="">-Select Store-</option>
                                <?php 
                                $loc = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
                                $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
                                $frmflag1 = isset($_REQUEST['frmflag1']) ? $_REQUEST['frmflag1'] : '';
                                $store = isset($_REQUEST['store']) ? $_REQUEST['store'] : '';
                                
                                if ($frmflag1 == 'frmflag1') {
                                    $loc = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
                                    $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
                                    $query5 = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
                                    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res5 = mysqli_fetch_array($exec5)) {
                                        $res5anum = $res5["storecode"];
                                        $res5name = $res5["store"];
                                ?>
                                <option value="<?php echo $res5anum;?>" <?php if($store==$res5anum){echo 'selected';}?>>
                                    <?php echo htmlspecialchars($res5name); ?>
                                </option>
                                <?php }} ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="categoryname" class="form-label">Category</label>
                            <select name="categoryname" id="categoryname" class="form-select">
                                <?php
                                $categoryname = $_REQUEST['categoryname'];
                                if ($categoryname != '') {
                                ?>
                                <option value="<?php echo htmlspecialchars($categoryname); ?>" selected="selected">
                                    <?php echo htmlspecialchars($categoryname); ?>
                                </option>
                                <option value="">Show All Category</option>
                                <?php } else { ?>
                                <option selected="selected" value="">Show All Category</option>
                                <?php } ?>
                                
                                <?php
                                $query42 = "select * from master_medicine where status = '' group by categoryname order by categoryname";
                                $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res42 = mysqli_fetch_array($exec42)) {
                                    $categoryname_option = $res42['categoryname'];
                                ?>
                                <option value="<?php echo htmlspecialchars($categoryname_option); ?>">
                                    <?php echo htmlspecialchars($categoryname_option); ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="itemname" class="form-label">Search Item</label>
                            <div class="search-input-container">
                                <input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox">
                                <input type="hidden" name="searchitemcode" id="searchitemcode">
                                <input name="itemname" type="text" id="itemname" class="form-input search-input" 
                                       autocomplete="off" value="<?php echo htmlspecialchars($searchmedicinename); ?>" 
                                       placeholder="Enter item name to search...">
                                <i class="fas fa-search search-icon"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label required">Date From</label>
                            <div class="date-input-container">
                                <input name="ADate1" id="ADate1" class="form-input datepicker-input" 
                                       value="<?php echo htmlspecialchars($ADate1); ?>" readonly />
                                <i class="fas fa-calendar-alt datepicker-icon" onClick="javascript:NewCssCal('ADate1')"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label required">Date To</label>
                            <div class="date-input-container">
                                <input name="ADate2" id="ADate2" class="form-input datepicker-input" 
                                       value="<?php echo htmlspecialchars($ADate2); ?>" readonly />
                                <i class="fas fa-calendar-alt datepicker-icon" onClick="javascript:NewCssCal('ADate2')"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="medicinecode" class="form-label">Item Code</label>
                            <input type="hidden" name="medicinecode" id="medicinecode" value="<?php echo htmlspecialchars($medicinecode); ?>" />
                            <input type="text" class="form-input readonly" value="<?php echo htmlspecialchars($medicinecode); ?>" readonly>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <input type="hidden" name="locationnamenew" value="<?php echo htmlspecialchars($locationname); ?>">
                        <input type="hidden" name="locationcodenew" value="<?php echo htmlspecialchars($res12locationanum); ?>">
                        <input type="hidden" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
                        
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Generate Report
                        </button>
                        <button type="reset" name="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                            Reset Form
                        </button>
                    </div>
                </form>
            </div>
            
            <?php if ($frmflag1 == 'frmflag1'): ?>
            <!-- Results Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <div class="data-table-title">
                        <i class="fas fa-chart-line"></i>
                        <h3>Stock Report by Expiry Date</h3>
                    </div>
                    <div class="data-table-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i>
                            Export Excel
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="printReport()">
                            <i class="fas fa-print"></i>
                            Print Report
                        </button>
                    </div>
                </div>
                
                <div class="report-summary">
                    <div class="summary-cards">
                        <div class="summary-card">
                            <div class="summary-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="summary-content">
                                <h4>Date Range</h4>
                                <p><?php echo date('M d, Y', strtotime($ADate1)); ?> - <?php echo date('M d, Y', strtotime($ADate2)); ?></p>
                            </div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="summary-content">
                                <h4>Location</h4>
                                <p><?php echo htmlspecialchars($reslocation); ?></p>
                            </div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-icon">
                                <i class="fas fa-warehouse"></i>
                            </div>
                            <div class="summary-content">
                                <h4>Store</h4>
                                <p><?php echo htmlspecialchars($res5name); ?></p>
                            </div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="summary-content">
                                <h4>Category</h4>
                                <p><?php echo htmlspecialchars($categoryname ?: 'All Categories'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table" id="stockReportTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item Code</th>
                                <th>Category</th>
                                <th>Item Name</th>
                                <th>Batch No</th>
                                <th>Expiry Date</th>
                                <th>Supplier</th>
                                <th>Quantity</th>
                                <th>Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
                            if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
                            
                            $noofdays = strtotime($ADate2) - strtotime($ADate1);
                            $noofdays = $noofdays/(3600*24);
                            
                            $loc = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
                            $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
                            $sno = 0;
                            $totalQuantity = 0;
                            $totalCost = 0;
                            
                            $query01 = "select * from (select a.auto_number as auto_number,trim(a.itemname) as itemname,a.itemcode as itemcode,sum(a.batch_quantity) as batch_quantity,a.batchnumber as batchnumber,a.rate as rate,c.categoryname as category,c.genericname,  a.locationcode,a.storecode,a.fifo_code,b.expirydate as expirydate from transaction_stock a left JOIN (select * from (
                                select billnumber,itemcode,expirydate,fifo_code from purchase_details where ((not((billnumber like 'GRN-%'))) and (itemcode <> '')) and expirydate BETWEEN '".$ADate1."' and '".$ADate2."' and itemname like '%".$searchmedicinename."%' group by itemcode,fifo_code,expirydate
                                union all 
                                select billnumber,itemcode,expirydate,fifo_code from materialreceiptnote_details where (itemcode <> '') and expirydate BETWEEN '".$ADate1."' and '".$ADate2."' and itemname like '%".$searchmedicinename."%' group by itemcode,fifo_code,expirydate
                                ) as a group by itemcode,fifo_code,expirydate) as b ON a.fifo_code=b.fifo_code left JOIN  master_medicine as c ON (a.itemcode=c.itemcode)  where a.storecode='$store' AND a.locationcode='$loc' and  c.categoryname like '%".$categoryname."%'  and a.itemcode <> ''  and b.expirydate BETWEEN '".$ADate1."' and '".$ADate2."' group by a.batchnumber,b.expirydate,a.itemcode) as final  order by IF(final.itemname RLIKE '^[a-z]', 1, 2), final.itemname";
                            
                            $run01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01);
                            
                            if (mysqli_num_rows($run01) == 0): ?>
                            <tr>
                                <td colspan="9" class="no-data">
                                    <i class="fas fa-search"></i>
                                    <h3>No Items Found</h3>
                                    <p>No stock items match your search criteria for the specified expiry date range.</p>
                                </td>
                            </tr>
                            <?php else:
                            while($exec01 = mysqli_fetch_array($run01)) {
                                $medanum = $exec01['auto_number'];
                                $itemname = $exec01['itemname'];
                                $itemcode = $exec01['itemcode']; 
                                $batchnumber = $exec01['batchnumber'];
                                $category = $exec01['category'];
                                $fifo_code = $exec01['fifo_code'];
                                
                                $batch_quantity = $exec01['batch_quantity'];
                                
                                $query04 = "select expirydate,suppliername FROM purchase_details WHERE itemcode='$itemcode' and fifo_code='$fifo_code' group by expirydate, batchnumber asc";
                                $run04 = mysqli_query($GLOBALS["___mysqli_ston"], $query04);
                                $exec04 = mysqli_fetch_array($run04);	
                                $expirydate = $exec04['expirydate'];
                                $suppliername = $exec04['suppliername'];

                                if($expirydate == '') {
                                    $query05 = "select expirydate,suppliername FROM materialreceiptnote_details WHERE itemcode='$itemcode' and fifo_code='$fifo_code' order by expirydate, batchnumber asc";
                                    $run05 = mysqli_query($GLOBALS["___mysqli_ston"], $query05);
                                    $exec05 = mysqli_fetch_array($run05);	
                                    $expirydate = $exec05['expirydate'];
                                    if($suppliername == "") $suppliername = $exec05['suppliername'];
                                }

                                $query1 = "select sum(transaction_quantity) as currentstock  from transaction_stock as a join (
                                    select itemcode, expirydate,batchnumber,fifo_code from purchase_details where itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber 
                                    union all
                                    select itemcode,expirydate,batchnumber,fifo_code FROM materialreceiptnote_details WHERE itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber
                                ) as b on a.batchnumber=b.batchnumber and a.itemcode=b.itemcode and a.fifo_code=b.fifo_code	where a.transactionfunction='1' and a.batchnumber='$batchnumber' and a.itemcode='$itemcode' and a.locationcode='$locationcode' and a.storecode='$store'";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res1 = mysqli_fetch_array($exec1);
                                $currentstock1 = $res1['currentstock'];

                                $query1 = "select sum(transaction_quantity) as currentstock  from transaction_stock as a join (
                                    select itemcode, expirydate,batchnumber,fifo_code from purchase_details where itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber 
                                    union all
                                    select itemcode,expirydate,batchnumber,fifo_code FROM materialreceiptnote_details WHERE itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber
                                ) as b on a.batchnumber=b.batchnumber and a.itemcode=b.itemcode and a.fifo_code=b.fifo_code	where a.transactionfunction='0' and a.batchnumber='$batchnumber' and a.itemcode='$itemcode' and a.locationcode='$locationcode' and a.storecode='$store'";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res1 = mysqli_fetch_array($exec1);
                                $currentstock2 = $res1['currentstock'];

                                $batch_quantity = $currentstock1 - $currentstock2;
                                if(!$batch_quantity) $batch_quantity = 0;

                                $rate = $exec01['rate'];
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                
                                if ($showcolor == 0) {
                                    $colorcode = 'bgcolor="#CBDBFA"';
                                } else {
                                    $colorcode = 'bgcolor="#ecf0f5"';
                                }
                                
                                if($batch_quantity > 0){
                                    $sno = $sno + 1;
                                    $totalQuantity += $batch_quantity;
                                    $totalCost += ($rate * $batch_quantity);
                                    
                                    // Calculate days until expiry
                                    $today = new DateTime();
                                    $expiry = new DateTime($expirydate);
                                    $daysUntilExpiry = $today->diff($expiry)->days;
                                    if ($expiry < $today) $daysUntilExpiry = -$daysUntilExpiry;
                                    
                                    // Determine expiry status
                                    $expiryStatus = '';
                                    if ($daysUntilExpiry < 0) {
                                        $expiryStatus = 'expired';
                                    } elseif ($daysUntilExpiry <= 30) {
                                        $expiryStatus = 'expiring-soon';
                                    } else {
                                        $expiryStatus = 'valid';
                                    }
                            ?>
                            <tr <?php echo $colorcode; ?>>
                                <td class="item-number"><?php echo $sno; ?></td>
                                <td class="item-code"><?php echo htmlspecialchars($itemcode); ?></td>
                                <td class="item-category"><?php echo htmlspecialchars($category); ?></td>
                                <td class="item-name"><?php echo htmlspecialchars($itemname); ?></td>
                                <td class="batch-number"><?php echo htmlspecialchars($batchnumber); ?></td>
                                <td class="expiry-date">
                                    <span class="expiry-date-value"><?php echo htmlspecialchars($expirydate); ?></span>
                                    <span class="expiry-status expiry-<?php echo $expiryStatus; ?>">
                                        <?php 
                                        if ($expiryStatus == 'expired') echo 'Expired';
                                        elseif ($expiryStatus == 'expiring-soon') echo 'Expiring Soon';
                                        else echo 'Valid';
                                        ?>
                                    </span>
                                </td>
                                <td class="supplier-name"><?php echo htmlspecialchars($suppliername); ?></td>
                                <td class="quantity"><?php echo number_format($batch_quantity); ?></td>
                                <td class="cost">$<?php echo number_format($rate, 2); ?></td>
                            </tr>
                            <?php 
                                }
                            } endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="table-summary">
                    <div class="summary-item">
                        <i class="fas fa-list"></i>
                        <span>Total Items: <?php echo $sno; ?></span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-cubes"></i>
                        <span>Total Quantity: <?php echo number_format($totalQuantity); ?></span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-dollar-sign"></i>
                        <span>Total Value: $<?php echo number_format($totalCost, 2); ?></span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-info-circle"></i>
                        <span>Report generated on <?php echo date('M d, Y H:i:s'); ?></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/stock-report-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script language="javascript">
        // Legacy functions preserved for compatibility
        function funcOnLoadBodyFunctionCall() {
            funcCustomerDropDownSearch4();
        }
        
        function Locationcheck() {
            if(document.getElementById("location").value == '') {
                alert("Please Select Location");
                document.getElementById("location").focus();
                return false;
            }
            
            if(document.getElementById("store").value == '') {
                alert("Please Select Store");
                document.getElementById("store").focus();
                return false;
            }
            
            return true;
        }
        
        function storefunction(loc) {
            const username = document.getElementById("username").value;
            const xmlhttp = new XMLHttpRequest();
            
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("store").innerHTML = xmlhttp.responseText;
                }
            };
            
            xmlhttp.open("GET","ajax/ajaxstore.php?loc="+loc+"&username="+username,true);
            xmlhttp.send();
        }
        
        function disableEnterKey() {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode 
                return false;
            }
            
            const key = event.keyCode || event.which;
            
            if(key == 13) { // if enter key press
                return false;
            } else {
                return true;
            }
        }
        
        // Modern functions
        function refreshPage() {
            window.location.reload();
        }
        
        function exportToExcel() {
            const categoryname = document.querySelector('select[name="categoryname"]').value;
            const store = document.querySelector('select[name="store"]').value;
            const location = document.querySelector('select[name="location"]').value;
            const ADate1 = document.querySelector('input[name="ADate1"]').value;
            const ADate2 = document.querySelector('input[name="ADate2"]').value;
            const searchmedicinename = document.querySelector('input[name="itemname"]').value;
            
            const url = `stockreportbyexpirydatexl.php?categoryname=${encodeURIComponent(categoryname)}&store=${encodeURIComponent(store)}&location=${encodeURIComponent(location)}&ADate1=${encodeURIComponent(ADate1)}&ADate2=${encodeURIComponent(ADate2)}&searchmedicinename=${encodeURIComponent(searchmedicinename)}`;
            
            window.open(url, '_blank');
        }
        
        function printReport() {
            window.print();
        }
    </script>
</body>
</html>
