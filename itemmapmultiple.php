<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$rateperunit = "0";
$purchaseprice = "0";
$checkboxnumber = '';

if (isset($_POST["searchflag1"])) { $searchflag1 = $_POST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_POST["search1"])) { $search1 = $_POST["search1"]; } else { $search1 = ""; }
if (isset($_POST["search2"])) { $search2 = $_POST["search2"]; } else { $search2 = ""; }
if (isset($_POST["location"])) { $location = $_POST["location"]; } else { $location = ""; }
if (isset($_POST["store"])) { $store = $_POST["store"]; } else { $store = ""; }

// Check if table exists and get item mapping data
$tableExists = false;
$exec2 = null;
$sno = 0;

// Check if table exists
$checkTable = "SHOW TABLES LIKE 'master_medicine'";
$checkResult = mysqli_query($GLOBALS["___mysqli_ston"], $checkTable);
if(mysqli_num_rows($checkResult) > 0) {
    $tableExists = true;
    $query2 = "select * from master_medicine order by recorddatetime desc";
    if($location != '') {
        $query2 = "select * from master_medicine where locationcode='$location' order by recorddatetime desc";
    }
    if($store != '') {
        $query2 .= " and storecode='$store'";
    }
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2);
    if($exec2) {
        $sno = mysqli_num_rows($exec2);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Map Multiple - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/itemmapmultiple-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
</head>
<body>
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>
    
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($_SESSION['companyname']); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>
    
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Item Map Multiple</span>
    </nav>
    
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
    
    <div class="main-container-with-sidebar">
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
                        <a href="ipdischargelist.php" class="nav-link">
                            <i class="fas fa-user-check"></i>
                            <span>IP Discharge List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdischargerequestlist.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Discharge Requests</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="iptracking.php" class="nav-link">
                            <i class="fas fa-search-location"></i>
                            <span>IP Tracking</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipunrealizedreport.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Unrealized Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="itemmapmultiple.php" class="nav-link active">
                            <i class="fas fa-layer-group"></i>
                            <span>Item Mapping</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="alert-container">
                <?php if($errmsg != "") { ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $errmsg; ?>
                </div>
                <?php } ?>
            </div>
            
            <div class="page-header">
                <div class="page-header-content">
                    <h2>🔗 Item Map Multiple</h2>
                    <p>Manage multiple item mappings and associations</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-primary" onclick="refreshData()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-success" onclick="addNewMapping()">
                        <i class="fas fa-plus"></i> Add Mapping
                    </button>
                    <button class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                    <button class="btn btn-outline" onclick="printList()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
            
            <div class="search-container">
                <form method="post" action="">
                    <div class="search-row">
                        <div class="search-group">
                            <label for="search1">Item Name</label>
                            <input type="text" id="search1" name="search1" class="search-input" value="<?php echo htmlspecialchars($search1); ?>" placeholder="Search by item name">
                        </div>
                        <div class="search-group">
                            <label for="search2">Item Code</label>
                            <input type="text" id="search2" name="search2" class="search-input" value="<?php echo htmlspecialchars($search2); ?>" placeholder="Search by item code">
                        </div>
                        <div class="search-group">
                            <label for="location">Location</label>
                            <select name="location" id="location" class="search-input">
                                <option value="">All Locations</option>
                                <?php
                                $query1 = "select * from master_location where status='active' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
                                while($res1 = mysqli_fetch_array($exec1)) {
                                    $selected = ($location == $res1['locationcode']) ? 'selected' : '';
                                    echo "<option value='{$res1['locationcode']}' $selected>{$res1['locationname']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="search-group">
                            <label for="store">Store</label>
                            <select name="store" id="store" class="search-input">
                                <option value="">All Stores</option>
                                <?php
                                $query3 = "select * from master_store where status='active' order by storename";
                                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3);
                                while($res3 = mysqli_fetch_array($exec3)) {
                                    $selected = ($store == $res3['storecode']) ? 'selected' : '';
                                    echo "<option value='{$res3['storecode']}' $selected>{$res3['storename']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="search-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="form-container">
                <div class="form-header">
                    <h3><i class="fas fa-plus-circle"></i> Add New Item Mapping</h3>
                </div>
                <form method="post" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="itemname">Item Name *</label>
                            <input type="text" id="itemname" name="itemname" class="form-control" required placeholder="Enter item name">
                        </div>
                        <div class="form-group">
                            <label for="itemcode">Item Code *</label>
                            <input type="text" id="itemcode" name="itemcode" class="form-control" required placeholder="Enter item code">
                        </div>
                        <div class="form-group">
                            <label for="mappinglocation">Location *</label>
                            <select name="mappinglocation" id="mappinglocation" class="form-control" required>
                                <option value="">Select Location</option>
                                <?php
                                $query4 = "select * from master_location where status='active' order by locationname";
                                $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4);
                                while($res4 = mysqli_fetch_array($exec4)) {
                                    echo "<option value='{$res4['locationcode']}'>{$res4['locationname']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mappingstore">Store *</label>
                            <select name="mappingstore" id="mappingstore" class="form-control" required>
                                <option value="">Select Store</option>
                                <?php
                                $query5 = "select * from master_store where status='active' order by storename";
                                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5);
                                while($res5 = mysqli_fetch_array($exec5)) {
                                    echo "<option value='{$res5['storecode']}'>{$res5['storename']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="rateperunit">Rate Per Unit</label>
                            <input type="number" id="rateperunit" name="rateperunit" class="form-control" step="0.01" placeholder="0.00">
                        </div>
                        <div class="form-group">
                            <label for="purchaseprice">Purchase Price</label>
                            <input type="number" id="purchaseprice" name="purchaseprice" class="form-control" step="0.01" placeholder="0.00">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter description"></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="addmapping" class="btn btn-success">
                            <i class="fas fa-save"></i> Add Mapping
                        </button>
                        <button type="reset" class="btn btn-outline">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" onchange="selectAll()">
                            </th>
                            <th>S.No</th>
                            <th>Item Name</th>
                            <th>Item Code</th>
                            <th>Location</th>
                            <th>Store</th>
                            <th>Rate/Unit</th>
                            <th>Purchase Price</th>
                            <th>Status</th>
                            <th>Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$tableExists) { ?>
                        <tr>
                            <td colspan="11" style="text-align: center; padding: 3rem;">
                                <div style="color: #64748b; font-size: 1.1rem;">
                                    <i class="fas fa-database" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                                    <h3>Table Not Found</h3>
                                    <p>The 'master_medicine' table does not exist in the database.</p>
                                    <p>Please contact your administrator to create the required table.</p>
                                </div>
                            </td>
                        </tr>
                        <?php } else if ($exec2 && mysqli_num_rows($exec2) == 0) { ?>
                        <tr>
                            <td colspan="11" style="text-align: center; padding: 3rem;">
                                <div style="color: #64748b; font-size: 1.1rem;">
                                    <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                                    <h3>No Records Found</h3>
                                    <p>No item mappings found for the selected criteria.</p>
                                </div>
                            </td>
                        </tr>
                        <?php } else if ($exec2) {
                            $sno = 0;
                            while($res2 = mysqli_fetch_array($exec2)) {
                                $sno++;
                                $itemname = $res2['itemname'];
                                $itemcode = $res2['itemcode'];
                                $locationcode = $res2['locationcode'];
                                $storecode = $res2['storecode'];
                                $rateperunit = $res2['rateperunit'];
                                $purchaseprice = $res2['purchaseprice'];
                                $status = $res2['status'];
                                $recorddatetime = $res2['recorddatetime'];
                                
                                // Get location name
                                $locationname = '';
                                if($locationcode != '') {
                                    $query6 = "select locationname from master_location where locationcode='$locationcode'";
                                    $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6);
                                    if($res6 = mysqli_fetch_array($exec6)) {
                                        $locationname = $res6['locationname'];
                                    }
                                }
                                
                                // Get store name
                                $storename = '';
                                if($storecode != '') {
                                    $query7 = "select storename from master_store where storecode='$storecode'";
                                    $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7);
                                    if($res7 = mysqli_fetch_array($exec7)) {
                                        $storename = $res7['storename'];
                                    }
                                }
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" value="<?php echo $itemcode; ?>">
                            </td>
                            <td><?php echo $sno; ?></td>
                            <td><?php echo htmlspecialchars($itemname); ?></td>
                            <td><?php echo htmlspecialchars($itemcode); ?></td>
                            <td><?php echo htmlspecialchars($locationname); ?></td>
                            <td><?php echo htmlspecialchars($storename); ?></td>
                            <td>₹ <?php echo number_format($rateperunit, 2); ?></td>
                            <td>₹ <?php echo number_format($purchaseprice, 2); ?></td>
                            <td>
                                <span class="badge badge-<?php echo ($status == 'Active') ? 'success' : 'secondary'; ?>">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td><?php echo date('d-m-Y H:i', strtotime($recorddatetime)); ?></td>
                            <td>
                                <button class="btn btn-outline btn-sm" onclick="viewDetails('<?php echo $itemcode; ?>')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline btn-sm" onclick="editRecord('<?php echo $itemcode; ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline btn-sm" onclick="deleteRecord('<?php echo $itemcode; ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php 
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing <?php echo $sno; ?> records
                </div>
                <div class="pagination-controls">
                    <button class="pagination-btn" disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn" disabled>
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </main>
    </div>
    
    <script src="js/itemmapmultiple-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        function addNewMapping() {
            showAlert('Opening add mapping form...', 'info');
            // Add functionality to open add mapping modal or form
        }
    </script>
</body>
</html>
