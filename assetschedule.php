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

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

if(isset($_REQUEST['searchitem'])) { $searchitem = $_REQUEST['searchitem']; } else { $searchitem = ""; }

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

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

// Search parameters
if (isset($_REQUEST["search_month"])) { $searchmonth = $_REQUEST["search_month"]; } else { $searchmonth = ""; }
if (isset($_REQUEST["search_year"])) { $year_p = $_REQUEST["search_year"]; } else { $year_p = ""; }

if($searchmonth == '') {
    $year_p = date('Y');
    $month_p = date('m');
    $searchmonth = $month_p;
}

$year_present = date('Y');
$date_range_first = $year_p.'-'.$searchmonth.'-01';
$d = new DateTime($date_range_first); 
$date_range = $d->format('Y-m-t');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Schedule - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/assetschedule-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Asset Schedule</span>
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
                        <a href="assetcategory.php" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Asset Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addassetdepartmentunit.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Asset Department</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="asset_newentry.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>New Asset Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="assetentrylist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Asset List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="assetschedule.php" class="nav-link">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Asset Schedule</span>
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
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Asset Schedule</h2>
                    <p>View asset depreciation schedules and financial information.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-primary" onclick="printSchedule()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="search-filter-section">
                <div class="search-filter-header">
                    <i class="fas fa-search search-filter-icon"></i>
                    <h3 class="search-filter-title">Search & Filter Assets</h3>
                </div>
                
                <form method="get" action="assetschedule.php" class="search-filter-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onChange="ajaxlocationfunction(this.value);">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    $selected = ($location != '' && $location == $locationcode) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $locationcode; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($locationname); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="searchitem" class="form-label">Asset Search</label>
                            <input name="searchitem" id="searchitem" class="form-input" 
                                   value="<?php echo htmlspecialchars($searchitem); ?>" 
                                   placeholder="Search by asset name..." autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="search_month" class="form-label">Month</label>
                            <select name="search_month" id="search_month" class="form-input">
                                <option value="01" <?php echo ($searchmonth == '01') ? 'selected' : ''; ?>>January</option>
                                <option value="02" <?php echo ($searchmonth == '02') ? 'selected' : ''; ?>>February</option>
                                <option value="03" <?php echo ($searchmonth == '03') ? 'selected' : ''; ?>>March</option>
                                <option value="04" <?php echo ($searchmonth == '04') ? 'selected' : ''; ?>>April</option>
                                <option value="05" <?php echo ($searchmonth == '05') ? 'selected' : ''; ?>>May</option>
                                <option value="06" <?php echo ($searchmonth == '06') ? 'selected' : ''; ?>>June</option>
                                <option value="07" <?php echo ($searchmonth == '07') ? 'selected' : ''; ?>>July</option>
                                <option value="08" <?php echo ($searchmonth == '08') ? 'selected' : ''; ?>>August</option>
                                <option value="09" <?php echo ($searchmonth == '09') ? 'selected' : ''; ?>>September</option>
                                <option value="10" <?php echo ($searchmonth == '10') ? 'selected' : ''; ?>>October</option>
                                <option value="11" <?php echo ($searchmonth == '11') ? 'selected' : ''; ?>>November</option>
                                <option value="12" <?php echo ($searchmonth == '12') ? 'selected' : ''; ?>>December</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="search_year" class="form-label">Year</label>
                            <select name="search_year" id="search_year" class="form-input">
                                <?php
                                for ($i = $year_present - 5; $i <= $year_present + 5; $i++) {
                                    $selected = ($year_p == $i) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                            <i class="fas fa-undo"></i> Clear
                        </button>
                    </div>
                </form>
            </div>

            <!-- Asset Schedule Table Section -->
            <div class="schedule-table-section">
                <div class="schedule-table-header">
                    <i class="fas fa-calendar-alt schedule-table-icon"></i>
                    <h3 class="schedule-table-title">Asset Depreciation Schedule</h3>
                    <div class="table-summary">
                        <span class="summary-item">
                            <i class="fas fa-calendar"></i>
                            Period: <?php echo date('F Y', strtotime($date_range_first)); ?>
                        </span>
                    </div>
                </div>

                <div class="table-container">
                    <table class="schedule-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Category</th>
                                <th>Department</th>
                                <th>Asset ID</th>
                                <th>Asset Name</th>
                                <th>Acquisition Date</th>
                                <th>Life</th>
                                <th>Yearly Dep. Amt</th>
                                <th>Yearly Dep. %</th>
                                <th>Dep. Start</th>
                                <th>Purchase Cost</th>
                                <th>Salvage</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="scheduleTableBody">
                            <?php
                            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
                            
                            if ($cbfrmflag1 == 'cbfrmflag1') {
                                $searchpatient = '';
                                $search_month = $_REQUEST['search_month'];
                                $search_year = $_REQUEST['search_year'];
                                
                                $date_range_first = $search_year.'-'.$search_month.'-01';
                                $d = new DateTime($date_range_first); 
                                $date_range = $d->format('Y-m-t');
                                
                                // Query for asset schedule data
                                $query34 = "select * from assets_register where itemname like '%$searchitem%' and entrydate<='$date_range'";
                                $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                $rowNumber = 1;
                                while($res34 = mysqli_fetch_array($exec34)) {
                                    $itemname = $res34['itemname'];
                                    $asset_id = $res34['asset_id'];
                                    $costprice = $res34['costprice'];
                                    $entrydate = $res34['entrydate'];
                                    $period = $res34['period'];
                                    $startyear = $res34['startyear'];
                                    $category = $res34['category'];
                                    $department = $res34['department'];
                                    $salvage = $res34['salvage'];
                                    $dep_percent = $res34['dep_percent'];
                                    $auto_number = $res34['auto_number'];
                                    
                                    // Calculate yearly depreciation amount
                                    $yearly_dep_amount = ($costprice - $salvage) * ($dep_percent / 100);
                                    ?>
                                    <tr>
                                        <td class="row-number"><?php echo $rowNumber; ?></td>
                                        <td>
                                            <span class="category-badge"><?php echo htmlspecialchars($category); ?></span>
                                        </td>
                                        <td>
                                            <span class="department-badge"><?php echo htmlspecialchars($department); ?></span>
                                        </td>
                                        <td>
                                            <span class="asset-id-badge"><?php echo htmlspecialchars($asset_id); ?></span>
                                        </td>
                                        <td class="asset-name"><?php echo htmlspecialchars($itemname); ?></td>
                                        <td class="acquisition-date">
                                            <span class="date-badge"><?php echo date('d/m/Y', strtotime($entrydate)); ?></span>
                                        </td>
                                        <td class="life-period">
                                            <span class="period-badge"><?php echo htmlspecialchars($period); ?></span>
                                        </td>
                                        <td class="yearly-dep-amount">
                                            <span class="currency-amount"><?php echo number_format($yearly_dep_amount, 2); ?></span>
                                        </td>
                                        <td class="yearly-dep-percent">
                                            <span class="percent-badge"><?php echo number_format($dep_percent, 2); ?>%</span>
                                        </td>
                                        <td class="dep-start">
                                            <span class="year-badge"><?php echo htmlspecialchars($startyear); ?></span>
                                        </td>
                                        <td class="purchase-cost">
                                            <span class="currency-amount"><?php echo number_format($costprice, 2); ?></span>
                                        </td>
                                        <td class="salvage-value">
                                            <span class="currency-amount"><?php echo number_format($salvage, 2); ?></span>
                                        </td>
                                        <td class="actions">
                                            <div class="action-buttons">
                                                <a href="editasset.php?st=edit&&anum=<?php echo $auto_number; ?>" 
                                                   class="action-btn edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="print_asset_lable.php?assetanum=<?php echo $auto_number; ?>" 
                                                   class="action-btn print" title="Print Label" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                                <button class="action-btn view" 
                                                        onclick="viewAssetDetails('<?php echo $auto_number; ?>')" 
                                                        title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $rowNumber++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div id="paginationContainer" class="pagination-container">
                    <!-- Pagination will be generated by JavaScript -->
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/assetschedule-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script language="javascript">
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
        
        xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
        xmlhttp.send();
    }

    function viewAssetDetails(assetNum) {
        // Implementation for viewing asset details
        alert('View asset details for: ' + assetNum);
    }

    function printSchedule() {
        window.print();
    }
    </script>
</body>
</html>



