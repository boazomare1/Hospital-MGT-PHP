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
$docno1 = $_SESSION['docno'];

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

// Get user location details
$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno1' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationname"];

// Get pending indents count
$query82 = "select count(*) as total from purchase_indent where indent_approval='' and initial_approval='' and approvalstatus!='approved' and locationcode='$location'";
$exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res82 = mysqli_fetch_array($exec82);
$pendingIndentCount = isset($res82['total']) ? $res82['total'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Indent Approval - MedStar</title>
    
    <!-- External Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/branchindentapproval-modern.css">
    
    <!-- Legacy CSS for compatibility -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
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
        <span>Branch Indent Approval</span>
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
                    <li class="nav-item active">
                        <a href="branchindentapproval.php" class="nav-link">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Indent Approval</span>
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
                    <h2>
                        <i class="fas fa-clipboard-check"></i>
                        Branch Indent Approval
                    </h2>
                    <p>Manage and approve purchase indents from different departments</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i>
                        Refresh
                    </button>
                    <button class="btn btn-outline" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i>
                        Export PDF
                    </button>
                    <button class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i>
                        Export Excel
                    </button>
                    <button class="btn btn-outline" onclick="printPage()">
                        <i class="fas fa-print"></i>
                        Print
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search"></i>
                    <h3>Search Indents</h3>
                </div>
                <div class="search-form-content">
                    <form name="cbform1" method="post" action="branchindentapproval.php" id="searchForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="docno" class="form-label">Document No</label>
                                <input name="docno" type="text" id="docno" class="form-input" value="<?php echo isset($_POST['docno']) ? htmlspecialchars($_POST['docno']) : ''; ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="location" class="form-label">Location</label>
                                <select name="location" id="location" class="form-select">
                                    <option value="">Select Location</option>
                                    <?php
                                    $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno1' group by locationname order by locationname";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res1 = mysqli_fetch_array($exec1)) {
                                        $res1location = $res1["locationname"];
                                        $res1locationanum = $res1["locationcode"];
                                        $selected = ($location != '' && $location == $res1locationanum) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $res1locationanum; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($res1location); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="searchstatus" class="form-label">Status</label>
                                <select name="searchstatus" id="searchstatus" class="form-select">
                                    <?php 
                                    $searchstatus = isset($_REQUEST['searchstatus']) ? $_REQUEST['searchstatus'] : 'Purchase Indent';
                                    if($searchstatus != '') { ?>
                                    <option value="<?php echo $searchstatus; ?>"><?php echo $searchstatus; ?></option>
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
                                <input name="ADate1" id="ADate1" type="date" class="form-input" value="<?php echo isset($_POST['ADate1']) ? $_POST['ADate1'] : $transactiondatefrom; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="ADate2" class="form-label">Date To</label>
                                <input name="ADate2" id="ADate2" type="date" class="form-input" value="<?php echo isset($_POST['ADate2']) ? $_POST['ADate2'] : $transactiondateto; ?>" required>
                            </div>
                        </div>
                        <div class="form-actions">
                            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                            <button type="submit" class="submit-btn">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo"></i>
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Indents List Section -->
            <?php
            if (isset($_POST["cbfrmflag1"])) { 
                $cbfrmflag1 = $_POST["cbfrmflag1"]; 
            } else { 
                $cbfrmflag1 = ""; 
            }
            
            if ($cbfrmflag1 == 'cbfrmflag1') {
                $fromdate = isset($_POST['ADate1']) ? $_POST['ADate1'] : $transactiondatefrom;
                $todate = isset($_POST['ADate2']) ? $_POST['ADate2'] : $transactiondateto;
                $docno = isset($_POST['docno']) ? $_POST['docno'] : '';
                $searchstatus = isset($_POST['searchstatus']) ? $_POST['searchstatus'] : 'Purchase Indent';
            ?>
            <div class="indent-list-section">
                <div class="indent-list-header">
                    <h3>
                        <i class="fas fa-list"></i>
                        Purchase Indents Approval
                    </h3>
                    <div class="indent-count"><?php echo $pendingIndentCount; ?></div>
                    <div class="indent-list-actions">
                        <button class="btn btn-outline" onclick="refreshPage()">
                            <i class="fas fa-sync-alt"></i>
                            Refresh
                        </button>
                    </div>
                </div>
                
                <div class="indent-table-container">
                    <table class="indent-table" id="indentTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th>Doc No</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Store</th>
                                <th>Priority</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($searchstatus=='Purchase Indent'||$searchstatus=='All'){
                                $dptqry = "select distinct departmentname from master_employee where username in (select bausername from purchase_indent where indent_approval='' and approvalstatus!='approved' and initial_approval='' and locationcode='$location')";
                                $dptexec = mysqli_query($GLOBALS["___mysqli_ston"], $dptqry);
                                while ($resdpt = mysqli_fetch_assoc($dptexec)) {
                                    $dpt = $resdpt['departmentname'];
                                    
                                    $query1 = "select * from purchase_indent where indent_approval='' and initial_approval='' and approvalstatus!='approved' and locationcode='$location' and (date between '$fromdate' and '$todate') and docno like '%$docno%' group by docno";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $num1 = mysqli_num_rows($exec1);
                                    
                                    if ($num1 == 0) {
                                        echo '<tr><td colspan="8" class="empty-state">';
                                        echo '<div class="empty-state-icon"><i class="fas fa-inbox"></i></div>';
                                        echo '<div class="empty-state-title">No Indents Found</div>';
                                        echo '<div class="empty-state-description">No purchase indents are pending approval for the selected criteria.</div>';
                                        echo '</td></tr>';
                                    } else {
                                        $colorloopcount = 0;
                                        $sno = 0;
                                        
                                        while ($res1 = mysqli_fetch_array($exec1)) {
                                            $date = $res1['date'];
                                            $user = $res1['bausername'];
                                            $status = $res1['status'];
                                            $docno1 = $res1['docno'];
                                            $remarks = $res1['remarks'];
                                            $priority = $res1['priority'];
                                            $approvalstatus = $res1['indent_approval'];
                                            $store_name = $res1['storename'];
                                            
                                            $colorloopcount = $colorloopcount + 1;
                                            $showcolor = ($colorloopcount & 1); 
                                            
                                            if ($showcolor == 0) {
                                                $colorcode = 'bgcolor="#CBDBFA"';
                                            } else {
                                                $colorcode = 'bgcolor="#ecf0f5"';
                                            }
                            ?>
                            <tr <?php echo $colorcode; ?> data-docno="<?php echo $docno1; ?>">
                                <td class="indent-number"><?php echo $sno = $sno + 1; ?></td>
                                <td class="indent-date"><?php echo $date; ?></td>
                                <td class="indent-docno"><?php echo htmlspecialchars($docno1); ?></td>
                                <td class="indent-status"><?php echo htmlspecialchars($status); ?></td>
                                <td class="indent-remarks"><?php echo htmlspecialchars($remarks)."<br>-By ".htmlspecialchars($user); ?></td>
                                <td class="indent-store"><?php echo htmlspecialchars($store_name); ?></td>
                                <td class="indent-priority">
                                    <span class="priority-badge priority-<?php echo strtolower($priority); ?>">
                                        <?php echo htmlspecialchars($priority); ?>
                                    </span>
                                </td>
                                <td class="indent-action">
                                    <a href="purchaseindentapproval_one.php?docno=<?php echo urlencode($docno1); ?>&menuid=<?php echo urlencode($menu_id); ?>" 
                                       class="view-approve-btn"
                                       data-docno="<?php echo htmlspecialchars($docno1); ?>"
                                       data-status="<?php echo htmlspecialchars($status); ?>">
                                        <i class="fas fa-eye"></i>
                                        <?php if($approvalstatus=='') {
                                            echo 'VIEW';
                                        } else {
                                            echo 'VIEW Rejected';
                                        } ?>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                        }
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Summary Section -->
                <div class="summary-section">
                    <div class="summary-grid">
                        <div class="summary-item">
                            <span class="summary-label">Total Indents</span>
                            <span class="summary-value"><?php echo $pendingIndentCount; ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Pending Approval</span>
                            <span class="summary-value summary-pending"><?php echo $pendingIndentCount; ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Location</span>
                            <span class="summary-value"><?php echo htmlspecialchars($res1location); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/branchindentapproval-modern.js"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
</body>
</html>



