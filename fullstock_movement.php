<?php
session_start();
set_time_limit(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$searchmedicinename = "";
$colorloopcount = '';
$openingbalance = 0;
$user = ''; 
$snocount=0;   

$openingbalance_on_date1_final=0;
$quantity1_purchase_final=0;
$quantity1_preturn_final=0;
$quantity1_receipts_final=0;
$quantity2_transferout_final=0;
$quantity2_sales_final=0;
$quantity1_refunds_final=0;
$quantity2_transferout_ownusage_final=0;
$quantity1_excess_final=0;
$quantity2_Short_final=0;
$closingstock_on_date2_final=0;

//To populate the autocompetelist_services1.js
if (isset($_REQUEST["mainsearch"])) { $mainsearch = $_REQUEST["mainsearch"]; } else { $mainsearch = ""; }

$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["medicinecode"])) { $searchmedicinecode = $_REQUEST["medicinecode"]; } else { $searchmedicinecode = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')
{
    if (isset($_REQUEST["searchitemcode"])) { $searchmedicinecode = $_REQUEST["searchitemcode"]; } else { $searchmedicinecode = ""; }
    if (isset($_REQUEST["itemname"])) { $searchmedicinename = $_REQUEST["itemname"]; } else { $searchmedicinename = ""; }
    if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
    if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
    if (isset($_REQUEST["store"])) { $store_search = $_REQUEST["store"]; } else { $store_search = ""; }
} 

$docno = $_SESSION['docno'];

$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

// Initialize report data arrays
$reportData = [];
$summaryData = [
    'total_items' => 0,
    'total_opening' => 0,
    'total_purchase' => 0,
    'total_preturn' => 0,
    'total_receipts' => 0,
    'total_transferout' => 0,
    'total_sales' => 0,
    'total_refunds' => 0,
    'total_ownusage' => 0,
    'total_excess' => 0,
    'total_short' => 0,
    'total_closing' => 0
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Movement Report - MedStar</title>
    
    <!-- External CSS -->
    <link href="css/stock-movement-modern.css" rel="stylesheet" type="text/css" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- jQuery -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    
    <!-- Date Picker -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    
    <!-- Autocomplete -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script type="text/javascript" src="js/autosuggestmedicine2.js"></script>
    <?php include("js/dropdownlist1scripting1stock1.php"); ?>
    <script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>
    <script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Stock Movement Report</p>
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
        <span>Stock Movement Report</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <button class="floating-menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

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
                    <li class="nav-item active">
                        <a href="fullstock_movement.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Stock Movement Report</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Report Card -->
            <div class="report-card-container">
                <div class="report-card">
                    <div class="card-header">
                        <div class="card-title-section">
                            <i class="fas fa-chart-line card-icon"></i>
                            <h2 class="card-title">Stock Movement Report</h2>
                        </div>
                        <div class="card-actions">
                            <button type="button" class="btn btn-outline btn-sm" onclick="toggleChartView()">
                                <i class="fas fa-chart-bar"></i> Chart View
                            </button>
                            <button type="button" class="btn btn-outline btn-sm" onclick="exportToExcel()">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                            <button type="button" class="btn btn-outline btn-sm" onclick="printReport()">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <form name="stockinward" action="fullstock_movement.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return Locationcheck()" class="search-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="mainsearch">Report Type</label>
                                <select name="mainsearch" id="mainsearch" onChange="mainsearch_type();" class="form-control">
                                    <option value="">--Select Type--</option>
                                    <option value="1" <?php if($mainsearch==1){ echo 'selected';}?>>Summary</option>
                                    <option value="2" <?php if($mainsearch==2){ echo 'selected';}?>>Detail</option>
                                    <option value="3" <?php if($mainsearch==3){ echo 'selected';}?>>Detail with Batch</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="location">Location</label>
                                <select name="location" id="location" onChange="storefunction(this.value)" class="form-control">
                                    <?php
                                    $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res = mysqli_fetch_array($exec))
                                    {
                                        $reslocation = $res["locationname"];
                                        $reslocationanum = $res["locationcode"];
                                        ?>
                                        <option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>
                                        <?php 
                                    }
                                    
                                    $query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
                                    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res = mysqli_fetch_array($exec);
                                    
                                    $locationname  = $res["locationname"];
                                    $locationcode = $res["locationcode"];
                                    $res12locationanum = $res["auto_number"];
                                    ?>
                                </select>
                                <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                                <input type="hidden" name="locationcodenew" value="<?php echo $res12locationanum; ?>">
                                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="store">Store</label>
                                <?php  
                                $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
                                $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
                                $frmflag1=isset($_REQUEST['frmflag1'])?$_REQUEST['frmflag1']:'';
                                $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';
                                ?>  
                                <select name="store" id="store" class="form-control">
                                    <option value="">Select Store</option>
                                    <?php 
                                    $query5 = "SELECT storecode, store from master_store where locationcode='$locationcode'";
                                    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    
                                    while ($res5 = mysqli_fetch_array($exec5))
                                    {
                                        $res5anum = $res5["storecode"];
                                        $res5name = $res5["store"];
                                        ?>
                                        <option value="<?php echo $res5anum;?>" <?php if($store==$res5anum){ echo 'selected';}?>><?php echo $res5name;?></option>
                                        <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row" id="trcat" style="display: none;">
                            <div class="form-group">
                                <label for="categoryname">Category</label>
                                <select name="categoryname" id="categoryname" class="form-control">
                                    <?php
                                    $categoryname = isset($_REQUEST['categoryname']) ? $_REQUEST['categoryname'] : '';
                                    if ($categoryname != '')
                                    {
                                        ?>
                                        <option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>
                                        <option value="">Show All Category</option>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <option selected="selected" value="">Show All Category</option>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    $query42 = "select * from master_medicine where status = '' group by categoryname order by categoryname";
                                    $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res42 = mysqli_fetch_array($exec42))
                                    {
                                        $categoryname1 = $res42['categoryname'];
                                        ?>
                                        <option value="<?php echo $categoryname1; ?>"><?php echo $categoryname1; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row" id="trsearch" style="display: none;">
                            <div class="form-group">
                                <label for="itemname">Search Item</label>
                                <input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox">
                                <input type="hidden" name="searchitemcode" id="searchitemcode">
                                <input name="itemname" type="text" id="itemname" class="form-control" autocomplete="off" value="<?php echo $searchmedicinename; ?>" placeholder="Search for items...">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="ADate1">Date From</label>
                                <input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>" readonly="readonly" class="form-control date-picker">
                                <i class="fas fa-calendar-alt date-picker-icon" onclick="javascript:NewCssCal('ADate1')"></i>
                            </div>
                            
                            <div class="form-group">
                                <label for="ADate2">Date To</label>
                                <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>" readonly="readonly" class="form-control date-picker">
                                <i class="fas fa-calendar-alt date-picker-icon" onclick="javascript:NewCssCal('ADate2')"></i>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <input type="hidden" name="medicinecode" id="medicinecode" value="<?php echo $searchmedicinecode; ?>" readonly />
                            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                            <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <button name="resetbutton" type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                        
                        <div class="date-range-info">
                            <strong>Date Range: <?php echo $ADate1.' To '.$ADate2; ?></strong>
                        </div>
                    </form>
                </div>

                <?php
                if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

                if ($frmflag1 == 'frmflag1')
                {
                    if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
                    if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

                    $noofdays=strtotime($ADate2) - strtotime($ADate1);
                    $noofdays = $noofdays/(3600*24);

                    // Process data based on report type
                    if($_POST['mainsearch']=='1'){
                        // Summary Report Logic
                        include 'stock_movement_summary.php';
                    } else if($_POST['mainsearch']=='2'){
                        // Detail Report Logic  
                        include 'stock_movement_detail.php';
                    } else if($_POST['mainsearch']=='3'){
                        // Detail with Batch Report Logic
                        include 'stock_movement_batch.php';
                    }
                }
                ?>

                <?php if (!empty($reportData)): ?>
                    <!-- Summary Cards -->
                    <div class="summary-cards">
                        <div class="summary-card total-items">
                            <div class="summary-icon">
                                <i class="fas fa-boxes"></i>
                            </div>
                            <div class="summary-content">
                                <h3><?php echo $summaryData['total_items']; ?></h3>
                                <p>Total Items</p>
                            </div>
                        </div>

                        <div class="summary-card total-opening">
                            <div class="summary-icon">
                                <i class="fas fa-warehouse"></i>
                            </div>
                            <div class="summary-content">
                                <h3><?php echo number_format($summaryData['total_opening'], 0, '.', ','); ?></h3>
                                <p>Opening Stock</p>
                            </div>
                        </div>

                        <div class="summary-card total-purchase">
                            <div class="summary-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="summary-content">
                                <h3><?php echo number_format($summaryData['total_purchase'], 0, '.', ','); ?></h3>
                                <p>Purchase</p>
                            </div>
                        </div>

                        <div class="summary-card total-sales">
                            <div class="summary-icon">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <div class="summary-content">
                                <h3><?php echo number_format($summaryData['total_sales'], 0, '.', ','); ?></h3>
                                <p>Sales</p>
                            </div>
                        </div>

                        <div class="summary-card total-closing">
                            <div class="summary-icon">
                                <i class="fas fa-archive"></i>
                            </div>
                            <div class="summary-content">
                                <h3><?php echo number_format($summaryData['total_closing'], 0, '.', ','); ?></h3>
                                <p>Closing Stock</p>
                            </div>
                        </div>
                    </div>

                    <!-- Report Section -->
                    <div class="report-section">
                        <div class="report-header">
                            <div class="report-title-section">
                                <i class="fas fa-chart-line report-icon"></i>
                                <h3 class="report-title">Stock Movement Report</h3>
                                <div class="report-period">
                                    <span><?php echo date('d/m/Y', strtotime($ADate1)); ?> - <?php echo date('d/m/Y', strtotime($ADate2)); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Modern Data Table -->
                        <div class="modern-table-container">
                            <table class="modern-data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <?php if(isset($_POST['mainsearch']) && $_POST['mainsearch']=='3'): ?>
                                            <th>Code</th>
                                        <?php endif; ?>
                                        <th>Description</th>
                                        <?php if(isset($_POST['mainsearch']) && $_POST['mainsearch']=='3'): ?>
                                            <th>Batch</th>
                                            <th>Expiry</th>
                                        <?php endif; ?>
                                        <th>Opening Stock</th>
                                        <th>Purchase</th>
                                        <th>Purchase Returns</th>
                                        <th>Receipts</th>
                                        <th>Issued To Dept</th>
                                        <th>Sales</th>
                                        <th>Refunds</th>
                                        <th>Own Usage</th>
                                        <th>Physical Excess</th>
                                        <th>Physical Short</th>
                                        <th>Closing Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rowCount = 0;
                                    foreach ($reportData as $item):
                                        $rowCount++;
                                        $rowClass = ($rowCount % 2 == 0) ? 'even' : 'odd';
                                    ?>
                                        <tr class="table-row <?php echo $rowClass; ?>">
                                            <td><?php echo $rowCount; ?></td>
                                            <?php if(isset($_POST['mainsearch']) && $_POST['mainsearch']=='3'): ?>
                                                <td><span class="item-code"><?php echo htmlspecialchars($item['code']); ?></span></td>
                                            <?php endif; ?>
                                            <td>
                                                <span class="item-name"><?php echo htmlspecialchars($item['description']); ?></span>
                                            </td>
                                            <?php if(isset($_POST['mainsearch']) && $_POST['mainsearch']=='3'): ?>
                                                <td><span class="batch-number"><?php echo htmlspecialchars($item['batch']); ?></span></td>
                                                <td><span class="expiry-date"><?php echo htmlspecialchars($item['expiry']); ?></span></td>
                                            <?php endif; ?>
                                            <td>
                                                <span class="amount-badge opening"><?php echo number_format($item['opening'], 0, '.', ','); ?></span>
                                            </td>
                                            <td>
                                                <span class="amount-badge purchase"><?php echo number_format($item['purchase'], 0, '.', ','); ?></span>
                                            </td>
                                            <td>
                                                <span class="amount-badge purchase-return"><?php echo number_format($item['preturn'], 0, '.', ','); ?></span>
                                            </td>
                                            <td>
                                                <span class="amount-badge receipts"><?php echo number_format($item['receipts'], 0, '.', ','); ?></span>
                                            </td>
                                            <td>
                                                <span class="amount-badge transfer-out"><?php echo number_format($item['transferout'], 0, '.', ','); ?></span>
                                            </td>
                                            <td>
                                                <span class="amount-badge sales"><?php echo number_format($item['sales'], 0, '.', ','); ?></span>
                                            </td>
                                            <td>
                                                <span class="amount-badge refunds"><?php echo number_format($item['refunds'], 0, '.', ','); ?></span>
                                            </td>
                                            <td>
                                                <span class="amount-badge own-usage"><?php echo number_format($item['ownusage'], 0, '.', ','); ?></span>
                                            </td>
                                            <td>
                                                <span class="amount-badge excess"><?php echo number_format($item['excess'], 0, '.', ','); ?></span>
                                            </td>
                                            <td>
                                                <span class="amount-badge short"><?php echo number_format($item['short'], 0, '.', ','); ?></span>
                                            </td>
                                            <td>
                                                <span class="amount-badge closing"><?php echo number_format($item['closing'], 0, '.', ','); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="totals-row">
                                        <td colspan="<?php echo (isset($_POST['mainsearch']) && $_POST['mainsearch']=='3') ? '4' : '2'; ?>"><strong>Total:</strong></td>
                                        <td><strong><?php echo number_format($summaryData['total_opening'], 0, '.', ','); ?></strong></td>
                                        <td><strong><?php echo number_format($summaryData['total_purchase'], 0, '.', ','); ?></strong></td>
                                        <td><strong><?php echo number_format($summaryData['total_preturn'], 0, '.', ','); ?></strong></td>
                                        <td><strong><?php echo number_format($summaryData['total_receipts'], 0, '.', ','); ?></strong></td>
                                        <td><strong><?php echo number_format($summaryData['total_transferout'], 0, '.', ','); ?></strong></td>
                                        <td><strong><?php echo number_format($summaryData['total_sales'], 0, '.', ','); ?></strong></td>
                                        <td><strong><?php echo number_format($summaryData['total_refunds'], 0, '.', ','); ?></strong></td>
                                        <td><strong><?php echo number_format($summaryData['total_ownusage'], 0, '.', ','); ?></strong></td>
                                        <td><strong><?php echo number_format($summaryData['total_excess'], 0, '.', ','); ?></strong></td>
                                        <td><strong><?php echo number_format($summaryData['total_short'], 0, '.', ','); ?></strong></td>
                                        <td><strong><?php echo number_format($summaryData['total_closing'], 0, '.', ','); ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Chart Section (Hidden by default) -->
                    <div class="chart-section" id="chartSection" style="display: none;">
                        <div class="chart-header">
                            <i class="fas fa-chart-pie chart-icon"></i>
                            <h3 class="chart-title">Stock Movement Summary Chart</h3>
                        </div>
                        <div class="chart-container">
                            <canvas id="stockMovementChart"></canvas>
                        </div>
                    </div>
                <?php elseif ($frmflag1 == 'frmflag1'): ?>
                    <div class="no-results-message">
                        <i class="fas fa-chart-line"></i>
                        <h3>No Data Found</h3>
                        <p>No stock movement data found for the selected criteria.</p>
                        <button type="button" class="btn btn-primary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Try Different Criteria
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/stock-movement-modern.js?v=<?php echo time(); ?>"></script>

    <!-- Legacy JavaScript for compatibility -->
    <script language="javascript">
        function funcOnLoadBodyFunctionCall()
        {
            funcCustomerDropDownSearch4();
        }

        function Locationcheck()
        {
            if(document.getElementById("location").value == '')
            {
                alert("Please Select Location");
                document.getElementById("location").focus();
                return false;
            }
        }

        //ajax function to get store for corrosponding location
        function storefunction(loc)
        {
            var username=document.getElementById("username").value;
            
            var xmlhttp;

            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("store").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","ajax/ajaxstore.php?loc="+loc+"&username="+username,true);
            xmlhttp.send();
        }

        function disableEnterKey()
        {
            if (event.keyCode==8) 
            {
                event.keyCode=0; 
                return event.keyCode 
                return false;
            }
            
            var key;
            if(window.event)
            {
                key = window.event.keyCode;     //IE
            }
            else
            {
                key = e.which;     //firefox
            }
            
            if(key == 13) // if enter key press
            {
                return false;
            }
            else
            {
                return true;
            }
        }

        function Showrows(id, code, action)
        {
            if(action=='down')
            {
                $("."+code).toggle('slow'); 
                $("#down"+id).hide(0); 
                $("#up"+id).show();
            }	
            else if(action=='up')
            {
                $("."+code).toggle('slow');  
                $("#up"+id).hide(0); 
                $("#down"+id).show();
            }
        }

        function mainsearch_type() {
            var mainsearch  =  document.getElementById("mainsearch");
            var mainsearchvalue = mainsearch.options[mainsearch.selectedIndex].value;
            var trcat =  document.getElementById("trcat");
            var trsearch =  document.getElementById("trsearch");

            if (mainsearchvalue == 1) {
                trcat.style.display = "none";
                trsearch.style.display = "none";
            }
            else {
                trcat.style.display = "";
                trsearch.style.display = "";
            }  
        }

        function exportToExcel() {
            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const formData = new FormData(document.querySelector('.search-form'));

            // Build export URL
            let exportUrl = 'xl_fullstockmovement.php?';
            exportUrl += 'mainsearch=' + encodeURIComponent(formData.get('mainsearch') || '');
            exportUrl += '&frmflag1=' + encodeURIComponent(formData.get('frmflag1') || '');
            exportUrl += '&searchitemcode=' + encodeURIComponent(formData.get('searchitemcode') || '');
            exportUrl += '&categoryname=' + encodeURIComponent(formData.get('categoryname') || '');
            exportUrl += '&location=' + encodeURIComponent(formData.get('location') || '');
            exportUrl += '&store=' + encodeURIComponent(formData.get('store') || '');
            exportUrl += '&ADate1=' + encodeURIComponent(formData.get('ADate1') || '');
            exportUrl += '&ADate2=' + encodeURIComponent(formData.get('ADate2') || '');

            // Open export in new window
            window.open(exportUrl, '_blank');

            showAlert('Export initiated successfully!', 'success');
        }

        function printReport() {
            // Hide sidebar and other non-printable elements
            const sidebar = document.getElementById('leftSidebar');
            const floatingToggle = document.querySelector('.floating-menu-toggle');

            if (sidebar) sidebar.style.display = 'none';
            if (floatingToggle) floatingToggle.style.display = 'none';

            // Print
            window.print();

            // Restore elements
            if (sidebar) sidebar.style.display = '';
            if (floatingToggle) floatingToggle.style.display = '';

            showAlert('Print dialog opened.', 'info');
        }

        function resetForm() {
            const form = document.querySelector('.search-form');
            if (form) {
                form.reset();

                // Set default dates
                const today = new Date();
                const lastWeek = new Date();
                lastWeek.setDate(today.getDate() - 7);

                const dateFrom = document.getElementById('ADate1');
                const dateTo = document.getElementById('ADate2');

                if (dateFrom) {
                    dateFrom.value = lastWeek.toISOString().split('T')[0];
                }
                if (dateTo) {
                    dateTo.value = today.toISOString().split('T')[0];
                }

                showAlert('Form reset successfully!', 'info');
            }
        }
    </script>
</body>
</html>
