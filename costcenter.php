<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$docno = $_SESSION['docno'];

$query = "select * from master_location where status <> 'deleted' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

//get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if($location != '') {
    $locationcode = $location;
}

$frmflag1 = isset($_POST["frmflag1"]) ? $_POST["frmflag1"] : "";

if ($frmflag1 == 'frmflag1') {
    $department = $_REQUEST["department"];
    $department = strtoupper($department);
    $department = trim($department);
    $length = strlen($department);

    $query1 = "select * from master_location where status <> 'deleted' and locationcode = '".$locationcode."'";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);
    $locationname = $res1["locationname"];

    if ($length <= 100) {
        $query2 = "select * from master_costcenter where name = '$department'";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_num_rows($exec2);

        if ($res2 == 0) {
            $query1 = "insert into master_costcenter (name, ipaddress, recorddate, username, locationcode, locationname) values ('$department', '$ipaddress', '$updatedatetime', '$username','".$locationcode."','".$locationname."')";
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $errmsg = "Success. New Cost Center Updated.";
            $bgcolorcode = 'success';
        } else {
            $errmsg = "Failed. Cost Center Already Exists.";
            $bgcolorcode = 'failed';
        }
    } else {
        $errmsg = "Failed. Only 100 Characters Are Allowed.";
        $bgcolorcode = 'failed';
    }
}

$st = isset($_REQUEST["st"]) ? $_REQUEST["st"] : "";

if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_costcenter set recordstatus = 'deleted' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if ($st == 'activate') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_costcenter set recordstatus = '' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}

$svccount = isset($_REQUEST["svccount"]) ? $_REQUEST["svccount"] : "";

if ($svccount == 'firstentry') {
    $errmsg = "Please Add Department To Proceed For Billing.";
    $bgcolorcode = 'failed';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cost Center Management - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/costcenter-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Additional CSS -->
    <link href="css/three.css" rel="stylesheet" type="text/css">
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Cost Center Management System</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?> | Document No: <?php echo htmlspecialchars($docno); ?></span>
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
        <span>Cost Center Management</span>
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
                        <a href="costcenter.php" class="nav-link active">
                            <i class="fas fa-building"></i>
                            <span>Cost Center Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consumablebyunit.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Consumable Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationtype_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Upload Consultation Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addconsultationtemplate.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Template</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationrefundrequestlist.php" class="nav-link">
                            <i class="fas fa-undo"></i>
                            <span>Refund Request List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationrefundlist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Consultation Refund List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cashradiologyrefund.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Cash Radiology Refund</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cashrefundapprovallist.php" class="nav-link">
                            <i class="fas fa-check-circle"></i>
                            <span>Refund Approval List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chequescollected.php" class="nav-link">
                            <i class="fas fa-money-check"></i>
                            <span>Cheques Collected</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="claimtxnidedit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Claim Transaction Edit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payrollprocess1.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Process</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stockreportbyitem3.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Stock Report by Item</span>
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
                    <h2>Cost Center Management</h2>
                    <p>Manage cost centers for financial reporting and analysis across different locations.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportCostCenters()">
                        <i class="fas fa-file-excel"></i> Export
                    </button>
                </div>
            </div>

            <!-- Form Section -->
            <div class="form-section">
                <div class="form-header">
                    <i class="fas fa-plus-circle form-header-icon"></i>
                    <h3 class="form-header-title">Add New Cost Center</h3>
                </div>
                
                <form name="frmsales" id="frmsales" method="post" action="costcenter.php" class="form-container">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" class="form-input">
                                <option value="">Select Location</option>
                                <?php
                                $query1 = "select * from master_location where status <> 'deleted' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1))
                                {
                                    $res1location = $res1["locationname"];
                                    $res1locationanum = $res1["locationcode"];
                                    ?>
                                    <option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="department" class="form-label">Cost Center Name</label>
                            <input name="department" id="department" class="form-input" style="text-transform:uppercase;" placeholder="Enter cost center name" maxlength="100" />
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Cost Center
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">
                            <i class="fas fa-undo"></i> Clear
                        </button>
                    </div>
                </form>
            </div>

            <!-- Active Cost Centers Table -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-building data-table-icon"></i>
                    <h3 class="data-table-title">Active Cost Centers</h3>
                </div>
                
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>ID</th>
                                <th>Cost Center Name</th>
                                <th>Location</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query1 = "select * from master_costcenter where recordstatus <> 'deleted' order by auto_number";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1))
                            {
                                $costcentername = $res1["name"];
                                $costcentername = strtoupper($costcentername);
                                $auto_number = $res1["auto_number"];
                                $locationname = $res1['locationname'];
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                if ($showcolor == 0) {
                                    $colorcode = 'bgcolor="#CBDBFA"';
                                } else {
                                    $colorcode = '';
                                }
                                ?>
                                <tr <?php echo $colorcode; ?>>
                                    <td>
                                        <button class="action-btn action-btn-danger" onclick="confirmDelete('<?php echo $costcentername; ?>', '<?php echo $auto_number; ?>')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                    <td><?php echo $auto_number; ?></td>
                                    <td><?php echo $costcentername; ?></td>
                                    <td><?php echo $locationname; ?></td>
                                    <td>
                                        <a href="editcostcenter1.php?st=edit&anum=<?php echo $auto_number; ?>" class="action-btn action-btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Deleted Cost Centers Table -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-trash data-table-icon"></i>
                    <h3 class="data-table-title">Deleted Cost Centers</h3>
                </div>
                
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Cost Center Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query1 = "select * from master_costcenter where recordstatus = 'deleted' order by name";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1))
                            {
                                $costcentername = $res1["name"];
                                $auto_number = $res1["auto_number"];
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                if ($showcolor == 0) {
                                    $colorcode = 'bgcolor="#CBDBFA"';
                                } else {
                                    $colorcode = '';
                                }
                                ?>
                                <tr <?php echo $colorcode; ?>>
                                    <td>
                                        <button class="action-btn action-btn-success" onclick="confirmActivate('<?php echo $costcentername; ?>', '<?php echo $auto_number; ?>')">
                                            <i class="fas fa-undo"></i> Activate
                                        </button>
                                    </td>
                                    <td><?php echo $costcentername; ?></td>
                                    <td><span class="status-badge status-deleted">Deleted</span></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/costcenter-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Additional Scripts -->
    <script src="js/datetimepicker_css.js"></script>
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
</body>
</html>