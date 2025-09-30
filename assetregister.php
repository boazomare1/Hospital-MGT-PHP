<?php
error_reporting(0);
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

// Handle supplier selection
if (isset($_REQUEST["canum"])) { 
    $getcanum = $_REQUEST["canum"]; 
} else { 
    $getcanum = ""; 
}

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

if (isset($_REQUEST['searchitem'])) { 
    $searchitem = $_REQUEST['searchitem']; 
} else { 
    $searchitem = ""; 
}

if (isset($_REQUEST["cbfrmflag2"])) { 
    $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; 
} else { 
    $cbfrmflag2 = ""; 
}

if (isset($_REQUEST["frmflag2"])) { 
    $frmflag2 = $_REQUEST["frmflag2"]; 
} else { 
    $frmflag2 = ""; 
}

if ($frmflag2 == 'frmflag2') {
    // Handle form submission if needed
}

// Handle status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if (isset($_REQUEST["assetanum"])) { 
    $assetanum = $_REQUEST["assetanum"]; 
} else { 
    $assetanum = ""; 
}

if ($st == 'error') {
    $errmsg = "Asset ID already exists";
    $bgcolorcode = 'error';
} else if ($st == 'success') {
    $errmsg = "Asset operation completed successfully";
    $bgcolorcode = 'success';
}

// Handle search parameters
if (isset($_REQUEST["search_month"])) { 
    $searchmonth = $_REQUEST["search_month"]; 
} else { 
    $searchmonth = ""; 
}

if (isset($_REQUEST["search_year"])) { 
    $year_p = $_REQUEST["search_year"]; 
} else { 
    $year_p = ""; 
}

if ($searchmonth == '') {
    $year_p = date('Y');
    $month_p = date('m');
    $searchmonth = $month_p;
}

$year_present = date('Y');
$year_past = $year_p - 5;
$year_fut = $year_present + 5;
$years = range($year_past, strftime($year_fut, time()));

// Get location information
if ($location != '') {
    $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $res12 = mysqli_fetch_array($exec12);
    $res1location = $res12["locationname"];
} else {
    $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);
    $res1location = $res1["locationname"];
}

// Initialize search results
$searchResults = [];
$totalAssets = 0;

// Handle search form submission
if (isset($_REQUEST["cbfrmflag1"])) { 
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
} else { 
    $cbfrmflag1 = ""; 
}

if ($cbfrmflag1 == 'cbfrmflag1') {
    $searchpatient = '';
    $search_month = $_REQUEST['search_month'];
    $search_year = $_REQUEST['search_year'];
    
    $date_range_first = $search_year . '-' . $search_month . '-01';
    $d = new DateTime($date_range_first); 
    $date_range = $d->format('Y-m-t');
    
    $sno = 0;
    $depration_done_date = date('Y-m-d');
    $query34 = "select * from assets_register where itemname like '%$searchitem%' and entrydate<='$date_range'";
    
    $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $number = mysqli_num_rows($exec34);
    
    while ($res34 = mysqli_fetch_array($exec34)) {
        $itemname = $res34['itemname'];
        $itemcode = $res34['itemcode'];
        $totalamount = $res34['totalamount'];
        $entrydate = $res34['entrydate'];
        $suppliercode = $res34['suppliercode'];
        $suppliername = $res34['suppliername'];
        $anum = $res34['auto_number'];
        $asset_id = $res34['asset_id'];
        $asset_category = $res34['asset_category'];
        $asset_class = $res34['asset_class'];
        $asset_department = $res34['asset_department'];
        $asset_unit = $res34['asset_unit'];
        $asset_period = $res34['asset_period'];
        $startyear = $res34['startyear'];
        $accdepreciationvalue = $res34['accdepreciation'];
        $dep_percent = $res34['dep_percent'];
        $depreciationledgercode = $res34['depreciationledgercode'];
        $salvage = $res34['salvage'];
        
        $depreciationyearly = (($totalamount - $salvage) / $asset_period);
        $depreciationmonth = ($depreciationyearly / 12);
        $depreciationmonth = number_format($depreciationmonth, 2);
        
        $query77 = "select sum(depreciation) totdepamt from assets_depreciation where asset_id = '$asset_id' and entrydate<='$date_range'";
        $exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $res77 = mysqli_fetch_array($exec77);
        $accdepreciation = $res77['totdepamt'];
        
        $netbookvalue = $totalamount - $accdepreciation;
        $dep_yearly_per = (1 / $asset_period) * 100;
        
        // Check if the asset is disposed
        $qry_disposed = "select auto_number from assets_disposal where asset_id ='$asset_id'";
        $execdisp = mysqli_query($GLOBALS["___mysqli_ston"], $qry_disposed) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $disposed_num = mysqli_num_rows($execdisp);
        
        if ($disposed_num == 0) {
            $sno = $sno + 1;
            $searchResults[] = [
                'sno' => $sno,
                'anum' => $anum,
                'asset_id' => $asset_id,
                'asset_class' => $asset_class,
                'asset_department' => $asset_department,
                'itemname' => $itemname,
                'entrydate' => $entrydate,
                'asset_period' => $asset_period,
                'dep_yearly_per' => $dep_yearly_per,
                'startyear' => $startyear,
                'totalamount' => $totalamount,
                'salvage' => $salvage,
                'accdepreciation' => $accdepreciation,
                'netbookvalue' => $netbookvalue
            ];
        }
    }
    
    $totalAssets = $sno;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Register - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/asset-register-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Autocomplete CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <script type="text/javascript" src="js/autosuggestipbilling.js"></script>
    <script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>
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
        <span>Asset Register</span>
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
                        <a href="assetregister.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Asset Register</span>
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
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'error' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'error' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Asset Register</h2>
                    <p>Manage and track hospital assets with comprehensive register and reporting.</p>
                </div>
                <div class="page-header-actions">
                    <div class="location-display">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Location: <strong><?php echo htmlspecialchars($res1location); ?></strong></span>
                    </div>
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
                    <h3 class="search-form-title">Search Assets</h3>
                </div>
                
                <form name="cbform1" method="post" action="assetregister.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Location
                            </label>
                            <select name="location" id="location" class="form-input" onChange="ajaxlocationfunction(this.value);">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                ?>
                                    <option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo htmlspecialchars($locationname); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="searchitem" class="form-label">
                                <i class="fas fa-search"></i>
                                Asset Search
                            </label>
                            <input name="searchitem" 
                                   id="searchitem" 
                                   class="form-input"
                                   value="<?php echo htmlspecialchars($searchitem); ?>" 
                                   placeholder="Search by asset name..."
                                   autocomplete="off">
                            <input name="customercode" id="customercode" value="" type="hidden">
                            <input type="hidden" name="recordstatus" id="recordstatus">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="search_month" class="form-label">
                                <i class="fas fa-calendar-alt"></i>
                                As on Month
                            </label>
                            <select name="search_month" id="search_month" class="form-input">
                                <option <?php if($searchmonth == '01') { ?> selected = 'selected' <?php } ?> value="01">January</option>
                                <option <?php if($searchmonth == '02') { ?> selected = 'selected' <?php } ?> value="02">February</option>
                                <option <?php if($searchmonth == '03') { ?> selected = 'selected' <?php } ?> value="03">March</option>
                                <option <?php if($searchmonth == '04') { ?> selected = 'selected' <?php } ?> value="04">April</option>
                                <option <?php if($searchmonth == '05') { ?> selected = 'selected' <?php } ?> value="05">May</option>
                                <option <?php if($searchmonth == '06') { ?> selected = 'selected' <?php } ?> value="06">June</option>
                                <option <?php if($searchmonth == '07') { ?> selected = 'selected' <?php } ?> value="07">July</option>
                                <option <?php if($searchmonth == '08') { ?> selected = 'selected' <?php } ?> value="08">August</option>
                                <option <?php if($searchmonth == '09') { ?> selected = 'selected' <?php } ?> value="09">September</option>
                                <option <?php if($searchmonth == '10'){ ?> selected = 'selected' <?php } ?> value="10">October</option>
                                <option <?php if($searchmonth == '11'){ ?> selected = 'selected' <?php } ?> value="11">November</option>
                                <option <?php if($searchmonth == '12'){ ?> selected = 'selected' <?php } ?> value="12">December</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="search_year" class="form-label">
                                <i class="fas fa-calendar"></i>
                                Year
                            </label>
                            <select name="search_year" id="search_year" class="form-input">
                                <option value="">Select Year</option>
                                <?php foreach($years as $year1) : ?>
                                    <option <?php if($year_p == $year1){ ?> selected = 'selected' <?php } ?> value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-search"></i> Search Assets
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if ($cbfrmflag1 == 'cbfrmflag1' && !empty($searchResults)): ?>
                <!-- Asset Results Section -->
                <div class="results-section">
                    <div class="data-table-section">
                        <div class="data-table-header">
                            <i class="fas fa-building data-table-icon"></i>
                            <h3 class="data-table-title">Asset Register Report</h3>
                            <div class="data-table-count">Total Assets: <strong><?php echo $totalAssets; ?></strong></div>
                        </div>

                        <!-- Modern Data Table -->
                        <div class="modern-table-container">
                            <table class="modern-data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Department</th>
                                        <th>Asset ID</th>
                                        <th>Asset Name</th>
                                        <th>Acquisition Date</th>
                                        <th>Life</th>
                                        <th>Yearly Dep. %</th>
                                        <th>Dep. Start</th>
                                        <th>Purchase Cost</th>
                                        <th>Salvage</th>
                                        <th>Acc. Depreciation</th>
                                        <th>Net Book Value</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($searchResults as $result): 
                                        $row_class = ($result['sno'] % 2 == 0) ? 'even' : 'odd';
                                    ?>
                                        <tr class="table-row <?php echo $row_class; ?>">
                                            <td><?php echo $result['sno']; ?></td>
                                            <td><span class="category-badge"><?php echo htmlspecialchars($result['asset_class']); ?></span></td>
                                            <td><?php echo htmlspecialchars($result['asset_department']); ?></td>
                                            <td><span class="asset-id-badge"><?php echo htmlspecialchars($result['asset_id']); ?></span></td>
                                            <td><?php echo htmlspecialchars($result['itemname']); ?></td>
                                            <td><span class="date-badge"><?php echo htmlspecialchars($result['entrydate']); ?></span></td>
                                            <td><?php echo $result['asset_period']; ?> years</td>
                                            <td><?php echo number_format($result['dep_yearly_per'], 2); ?>%</td>
                                            <td><?php echo htmlspecialchars($result['startyear']); ?></td>
                                            <td><span class="amount-badge"><?php echo number_format($result['totalamount'], 2); ?></span></td>
                                            <td><span class="amount-badge"><?php echo number_format($result['salvage'], 2); ?></span></td>
                                            <td><span class="amount-badge"><?php echo number_format($result['accdepreciation'], 2); ?></span></td>
                                            <td><span class="amount-badge net-value"><?php echo number_format($result['netbookvalue'], 2); ?></span></td>
                                            <td>
                                                <select name="invoice" id="invoice" class="action-select" onChange="window.open(this.options[this.selectedIndex].value,'_blank')">
                                                    <option value="">Select Action</option>
                                                    <?php if($result['asset_id'] == ''): ?>
                                                        <option value="asset_recording.php?assetanum=<?php echo $result['anum']; ?>">Recording</option>
                                                    <?php else: ?>
                                                        <option value="asset_recording_1.php?assetanum=<?php echo $result['anum']; ?>">Recording</option>
                                                    <?php endif; ?>
                                                    <option value="asset_transfer.php?assetanum=<?php echo $result['anum']; ?>">Transfer</option>
                                                    <option value="asset_disposal.php?assetanum=<?php echo $result['anum']; ?>">Disposal</option>
                                                    <option value="asset_impairment.php?assetanum=<?php echo $result['anum']; ?>">Impairment</option>
                                                    <option value="asset_revaluation.php?assetanum=<?php echo $result['anum']; ?>">Revaluation</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php elseif ($cbfrmflag1 == 'cbfrmflag1' && empty($searchResults)): ?>
                <div class="no-results-message">
                    <i class="fas fa-search"></i>
                    <h3>No Assets Found</h3>
                    <p>No assets found matching your search criteria.</p>
                    <button type="button" class="btn btn-primary" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Try Different Search
                    </button>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/asset-register-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript functions -->
    <script type="text/javascript">
        function ajaxlocationfunction(val) {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
                }
            }
            
            xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
            xmlhttp.send();
        }
        
        function cbsuppliername1() {
            document.cbform1.submit();
        }
        
        function funcOnLoadBodyFunctionCall() {
            funcCustomerDropDownSearch1();
            funcPopupOnLoad1();
        }
        
        function disableEnterKey() {
            if (event.keyCode == 13) {
                return false;
            }
            return true;
        }
        
        function process1backkeypress1() {
            if (event.keyCode == 8) {
                event.keyCode = 0;
                return event.keyCode;
                return false;
            }
        }
        
        function funcPrintReceipt1() {
            window.open("print_payment_receipt1.php", "OriginalWindow<?php echo $banum; ?>", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
        }
        
        function funcvalidcheck() {
            return true; // Add validation logic if needed
        }
        
        function funcPopupOnLoad1() {
            // Popup functionality if needed
        }
    </script>
</body>
</html>
