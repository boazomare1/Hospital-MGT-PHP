<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Handle form data
if (isset($_REQUEST['searchstatus'])) {
    $searchstatus = $_REQUEST['searchstatus'];
} else {
    $searchstatus = 'Purchase Indent';
}

if (isset($_POST['ADate1'])) {
    $fromdate = $_POST['ADate1'];
} else {
    $fromdate = $transactiondatefrom;
}

if (isset($_POST['ADate2'])) {
    $todate = $_POST['ADate2'];
} else {
    $todate = $transactiondateto;
}

if (isset($_POST['docno'])) {
    $docno = $_POST['docno'];
} else {
    $docno = '';
}

// Get approved purchase indents count
$query1 = "select * from purchase_indent where approvalstatus='1' and (date between '$fromdate' and '$todate') and docno like '%$docno%' group by docno";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw3 = mysqli_num_rows($exec1);

// Get rejected purchase indents count
$query2 = "select * from purchase_indent where approvalstatus='rejected2' and (date between '$fromdate' and '$todate') and docno like '%$docno%' group by docno";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw2 = mysqli_num_rows($exec2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Indent Approval - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/purchase-indent-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
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
        <span>Purchase Indent Approval</span>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Alert Container -->
        <div id="alertContainer">
            <?php include ("includes/alertmessages1.php"); ?>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h2>Purchase Indent Approval</h2>
                <p>Review and approve purchase indent requests from various departments.</p>
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

        <!-- Search Form Section -->
        <div class="search-form-section">
            <div class="search-form-header">
                <i class="fas fa-search search-form-icon"></i>
                <h3 class="search-form-title">Search Purchase Indents</h3>
            </div>
            
            <form name="cbform1" method="post" action="viewpurchaseindent2_modern.php" class="search-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="docno" class="form-label">Document Number</label>
                        <input type="text" name="docno" id="docno" class="form-input" 
                               value="<?php echo htmlspecialchars($docno); ?>"
                               placeholder="Enter document number..." autocomplete="off">
                    </div>
                    
                    <div class="form-group">
                        <label for="searchstatus" class="form-label">Status</label>
                        <select name="searchstatus" id="searchstatus" class="form-input">
                            <?php if($searchstatus != '') { ?>
                                <option value="<?php echo htmlspecialchars($searchstatus); ?>"><?php echo htmlspecialchars($searchstatus); ?></option>
                            <?php } ?>
                            <option value="Purchase Indent">Purchase Indent</option>
                            <option value="All">All</option>             
                            <option value="Discarded">Discarded</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="ADate1" class="form-label">Date From</label>
                        <div class="date-input-group">
                            <input name="ADate1" id="ADate1" value="<?php echo $fromdate; ?>" 
                                   class="form-input date-input" readonly onKeyDown="return disableEnterKey()">
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                 class="date-picker-icon" alt="Select Date">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="ADate2" class="form-label">Date To</label>
                        <div class="date-input-group">
                            <input name="ADate2" id="ADate2" value="<?php echo $todate; ?>" 
                                   class="form-input date-input" readonly onKeyDown="return disableEnterKey()">
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                 class="date-picker-icon" alt="Select Date">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Tables Section -->
        <div class="data-tables-section">
            <?php if($searchstatus=='Purchase Indent'||$searchstatus=='All'){?>
                <!-- Approved Purchase Indents -->
                <div class="data-table-section">
                    <div class="data-table-header">
                        <i class="fas fa-check-circle data-table-icon"></i>
                        <h3 class="data-table-title">Finance Purchase Indents Approval</h3>
                        <div class="data-table-count">Total: <strong><?php echo $resnw3; ?></strong></div>
                    </div>

                    <?php
                    // Get departments for approved indents
                    $dptqry = "select distinct departmentname from master_employee where username in (select bausername from purchase_indent where approvalstatus = '1')";
                    $dptexec = mysqli_query($GLOBALS["___mysqli_ston"], $dptqry);

                    while ($resdpt = mysqli_fetch_assoc($dptexec)) {
                        $dpt = $resdpt['departmentname'];
                        ?>
                        
                        <!-- Department Section -->
                        <div class="department-section">
                            <div class="department-header">
                                <h4 class="department-title">
                                    <i class="fas fa-building"></i>
                                    <?php echo ($dpt != '') ? htmlspecialchars($dpt) : 'OTHER DEPARTMENTS'; ?>
                                </h4>
                            </div>

                            <!-- Modern Data Table -->
                            <div class="modern-table-container">
                                <table class="modern-data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>From</th>
                                            <th>Doc No</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                            <th>Location</th>
                                            <th>Priority</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $colorloopcount = '';
                                        $sno = '';
                                        
                                        $query1 = "select * from purchase_indent where approvalstatus='1' and (date between '$fromdate' and '$todate') and docno like '%$docno%' and bausername in (select username from master_employee where departmentname like '$dpt') group by docno";
                                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

                                        while ($res1 = mysqli_fetch_array($exec1)) {
                                            $date = $res1['date'];
                                            $user = $res1['bausername'];
                                            $status = $res1['status'];
                                            $docno1 = $res1['docno'];
                                            $remarks = $res1['remarks'];
                                            $priority = $res1['priority'];
                                            $approvalstatus = $res1['approvalstatus'];
                                            $location_name = $res1['location'];

                                            $colorloopcount = $colorloopcount + 1;
                                            $sno = $sno + 1;
                                            ?>
                                            <tr class="table-row <?php echo ($colorloopcount % 2 == 0) ? 'even' : 'odd'; ?>">
                                                <td><?php echo $sno; ?></td>
                                                <td>
                                                    <span class="date-badge"><?php echo htmlspecialchars($date); ?></span>
                                                </td>
                                                <td>
                                                    <div class="user-info">
                                                        <span class="user-name"><?php echo htmlspecialchars($user); ?></span>
                                                        <span class="department-name">- <?php echo htmlspecialchars($dpt); ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="doc-no-badge"><?php echo htmlspecialchars($docno1); ?></span>
                                                </td>
                                                <td>
                                                    <span class="status-badge status-<?php echo strtolower($status); ?>">
                                                        <?php echo htmlspecialchars($status); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="remarks-text">
                                                        <?php echo htmlspecialchars($remarks); ?>
                                                        <br><small class="by-user">-By <?php echo htmlspecialchars($user); ?></small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="location-badge"><?php echo htmlspecialchars($location_name); ?></span>
                                                </td>
                                                <td>
                                                    <span class="priority-badge priority-<?php echo strtolower($priority); ?>">
                                                        <?php echo htmlspecialchars($priority); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="purchaseindentapproval2.php?docno=<?php echo urlencode($docno1); ?>&menuid=<?php echo $menu_id; ?>" 
                                                           class="action-btn view" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                            <?php echo ($approvalstatus == 1) ? 'VIEW' : 'VIEW Rejected'; ?>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            <?php } ?>

            <?php if($searchstatus=='Discarded'||$searchstatus=='All'){?>   
                <!-- Discarded Purchase Indents -->
                <div class="data-table-section">
                    <div class="data-table-header">
                        <i class="fas fa-times-circle data-table-icon"></i>
                        <h3 class="data-table-title">Discarded Purchase Indents</h3>
                        <div class="data-table-count">Total: <strong><?php echo $resnw2; ?></strong></div>
                    </div>

                    <?php
                    // Get departments for discarded indents
                    $dptqry = "select distinct departmentname from master_employee where username in (select ceousername from purchase_indent where approvalstatus = 'rejected2')";
                    $dptexec = mysqli_query($GLOBALS["___mysqli_ston"], $dptqry);

                    while ($resdpt = mysqli_fetch_assoc($dptexec)) {
                        $dpt = $resdpt['departmentname'];
                        ?>
                        
                        <!-- Department Section -->
                        <div class="department-section">
                            <div class="department-header">
                                <h4 class="department-title">
                                    <i class="fas fa-building"></i>
                                    <?php echo ($dpt != '') ? htmlspecialchars($dpt) : 'OTHER DEPARTMENTS'; ?>
                                </h4>
                            </div>

                            <!-- Modern Data Table -->
                            <div class="modern-table-container">
                                <table class="modern-data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>From</th>
                                            <th>Doc No</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                            <th>Location</th>
                                            <th>Priority</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $colorloopcount = '';
                                        $sno = '';
                                        
                                        $query1 = "select * from purchase_indent where approvalstatus='rejected2' and (date between '$fromdate' and '$todate') and docno like '%$docno%' and ceousername in (select username from master_employee where departmentname like '$dpt') group by docno";
                                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

                                        while ($res1 = mysqli_fetch_array($exec1)) {
                                            $date = $res1['date'];
                                            $user = $res1['ceousername'];
                                            $status = $res1['status'];
                                            $docno1 = $res1['docno'];
                                            $remarks = $res1['remarks'];
                                            $priority = $res1['priority'];
                                            $approvalstatus = $res1['approvalstatus'];
                                            $location_name = $res1['location'];

                                            $colorloopcount = $colorloopcount + 1;
                                            $sno = $sno + 1;
                                            ?>
                                            <tr class="table-row <?php echo ($colorloopcount % 2 == 0) ? 'even' : 'odd'; ?>">
                                                <td><?php echo $sno; ?></td>
                                                <td>
                                                    <span class="date-badge"><?php echo htmlspecialchars($date); ?></span>
                                                </td>
                                                <td>
                                                    <div class="user-info">
                                                        <span class="user-name"><?php echo htmlspecialchars($user); ?></span>
                                                        <span class="department-name">- <?php echo htmlspecialchars($dpt); ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="doc-no-badge"><?php echo htmlspecialchars($docno1); ?></span>
                                                </td>
                                                <td>
                                                    <span class="status-badge status-<?php echo strtolower($status); ?>">
                                                        <?php echo htmlspecialchars($status); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="remarks-text">
                                                        <?php echo htmlspecialchars($remarks); ?>
                                                        <br><small class="by-user">-By <?php echo htmlspecialchars($user); ?></small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="location-badge"><?php echo htmlspecialchars($location_name); ?></span>
                                                </td>
                                                <td>
                                                    <span class="priority-badge priority-<?php echo strtolower($priority); ?>">
                                                        <?php echo htmlspecialchars($priority); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="purchaseindentapproval2.php?docno=<?php echo urlencode($docno1); ?>&menuid=<?php echo $menu_id; ?>" 
                                                           class="action-btn view" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                            <?php echo ($approvalstatus == 1) ? 'VIEW' : 'VIEW Rejected'; ?>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/purchase-indent-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

