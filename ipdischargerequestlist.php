<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

$docno = $_SESSION['docno'];
$packagename1 = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

$query1 = "select employeecode from master_employee where status = 'Active' AND username like '%$username%'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1employeename = $res1["employeecode"];

// Get default location
$query = "select * from master_location where status <> 'deleted' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if ($location != '') {
    $locationcode = $location;
}

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

if ($frmflag2 == 'frmflag2') {
    //get locationcode and locationname for inserting
    $locationcodeget = isset($_REQUEST['locationcodeget']) ? $_REQUEST['locationcodeget'] : '';
    $locationnameget = isset($_REQUEST['locationnameget']) ? $_REQUEST['locationnameget'] : '';
    //get ends here
    $itemname = $_REQUEST['itemname'];
    $itemcode = $_REQUEST['itemcode'];
    $adjustmentdate = date('Y-m-d');
    
    foreach($_POST['batch'] as $key => $value) {
        $batchnumber = $_POST['batch'][$key];
        $addstock = $_POST['addstock'][$key];
        $minusstock = $_POST['minusstock'][$key];
        $query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";
        $exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res40 = mysqli_fetch_array($exec40);
        $itemmrp = $res40['rateperunit'];
        
        $itemsubtotal = $itemmrp * $addstock;
        
        if($addstock != '') {
            $query65 = "insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
            transactionparticular, billautonumber, billnumber, quantity, remarks, 
            username, ipaddress, rateperunit, totalrate, companyanum, companyname, batchnumber)
            values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
            'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', 
            '$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname', '$batchnumber')";
            $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        } else {
            $query65 = "insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
            transactionparticular, billautonumber, billnumber, quantity, remarks, 
            username, ipaddress, rateperunit, totalrate, companyanum, companyname, batchnumber)
            values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
            'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', 
            '$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname', '$batchnumber')";
            $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }
    header("location:stockadjustment.php");
    exit;
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == '1') {
    $errmsg = "Success. Payment Entry Update Completed.";
    $bgcolorcode = 'success';
}
if ($st == '2') {
    $errmsg = "Failed. Payment Entry Not Completed.";
    $bgcolorcode = 'failed';
}

// Check for URL messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'success') {
        $errmsg = "Operation completed successfully.";
        $bgcolorcode = 'success';
    } elseif ($_GET['msg'] == 'error') {
        $errmsg = "Operation failed.";
        $bgcolorcode = 'failed';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inpatient Discharge Request List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ipdischargerequestlist-modern.css?v=<?php echo time(); ?>">
    
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
        <a href="activeinpatientlist.php">Active IP List</a>
        <span>→</span>
        <span>Discharge Request List</span>
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
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active IP List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdischargelist.php" class="nav-link">
                            <i class="fas fa-user-times"></i>
                            <span>IP Discharge List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="ipdischargerequestlist.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Discharge Requests</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipquickview.php" class="nav-link">
                            <i class="fas fa-eye"></i>
                            <span>IP Quick View</span>
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
                    <h2>Inpatient Discharge Request List</h2>
                    <p>View and manage inpatient discharge requests by ward and location.</p>
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
                    <h3 class="search-form-title">Search Discharge Requests</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="ipdischargerequestlist.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value); funcSubTypeChange1();">
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
                            <label for="ward" class="form-label">Ward</label>
                            <select name="ward" id="ward" class="form-input">
                                <?php 
                                $query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname"; 
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res = mysqli_fetch_array($exec);
                                
                                $locationname = $res["locationname"]; 
                                $locationcode2 = $res["locationcode"];
                                
                                $query78 = "select B.auto_number,B.ward,A.wardcode from nurse_ward as A join master_ward as B on (B.auto_number=A.wardcode) where A.locationcode='$locationcode2' and B.recordstatus='' and A.employeecode='$res1employeename' order by A.defaultward desc";
                                $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res78 = mysqli_fetch_array($exec78)) {
                                    $wardanum = $res78['auto_number'];
                                    $wardname = $res78['ward'];
                                    ?>
                                    <option value="<?php echo $wardanum; ?>"><?php echo htmlspecialchars($wardname); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="submit-btn">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <input type="hidden" name="locationcodeget" value="<?php echo isset($locationcodeget) ? $locationcodeget : ''; ?>">
                    <input type="hidden" name="locationnameget" value="<?php echo isset($locationnameget) ? $locationnameget : ''; ?>">
                </form>
            </div>

            <!-- Results Section -->
            <div class="results-section">
                <?php
                $colorloopcount = 0;
                $sno = 0;
                if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
                
                if ($cbfrmflag1 == 'cbfrmflag1') {
                    $searchward = (isset($_POST['ward']) ? $_POST['ward'] : '');
                    $locationcode = $_REQUEST['location'];
                    
                    $query781 = "select * from master_ward where auto_number='$searchward' and recordstatus='' and locationcode='$locationcode'";
                    $exec781 = mysqli_query($GLOBALS["___mysqli_ston"], $query781) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res781 = mysqli_fetch_array($exec781);
                    $wardname = $res781['ward'];
                    ?>
                    
                    <div class="results-header">
                        <i class="fas fa-list results-icon"></i>
                        <h3 class="results-title">Discharge Request List - <?php echo htmlspecialchars($wardname); ?></h3>
                    </div>

                    <div class="data-table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Patient Name</th>
                                    <th>Reg No</th>
                                    <th>DOA</th>
                                    <th>IP Visit</th>
                                    <th>Ward</th>
                                    <th>Bed No</th>
                                    <th>Account</th>
                                    <th>Actions</th>
                                    <th>Package Name</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query34 = "select * from master_ward where ward = '$wardname' and locationcode='$locationcode'";
                                $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res34 = mysqli_fetch_array($exec34)) {
                                    $wardnum = $res34['auto_number'];
                                    $wardname5 = $res34['ward'];
                                    ?>
                                    <tr class="ward-header-row">
                                        <td colspan="11" class="ward-header">
                                            <i class="fas fa-hospital"></i>
                                            <?php echo htmlspecialchars($wardname5); ?>
                                        </td>
                                    </tr>
                                    <?php
                                    
                                    $query50 = "select * from master_bed where ward='$wardnum' and locationcode='$locationcode'";
                                    $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($res50 = mysqli_fetch_array($exec50)) {
                                        $bedname = $res50['bed'];
                                        $bedanum = $res50['auto_number'];
                                        $bed = '';
                                        $ward = '';
                                        $patientcode = '';
                                        $visitcode = '';
                                        $packagename = '';
                                        
                                        $query69 = "select * from master_bed where auto_number='$bedanum' and ward='$wardnum' and recordstatus='occupied' and locationcode='$locationcode' order by auto_number desc limit 0, 1";
                                        $exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $num69 = mysqli_num_rows($exec69);
                                        
                                        $query59 = "select * from ip_bedallocation where ward='$wardnum' and bed='$bedanum' and recordstatus = '' and locationcode='$locationcode' order by auto_number desc limit 0, 1";
                                        $exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res59 = mysqli_fetch_array($exec59);
                                        $num59 = mysqli_num_rows($exec59);
                                        
                                        if($num59 > 0) {
                                            $ward = $res59['ward'];
                                            $bed = $res59['bed'];
                                            $patientname = $res59['patientname'];
                                            $patientcode = $res59['patientcode'];
                                            $visitcode = $res59['visitcode'];
                                            
                                            $query49 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and locationcode='$locationcode' order by auto_number desc limit 0, 1";
                                            $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $res49 = mysqli_fetch_array($exec49);
                                            $date = $res49['consultationdate'];
                                            $accoutname = $res49['accountfullname'];
                                            $package = $res49['package'];
                                            
                                            $query401 = "select packagename from master_ippackage where auto_number = '$package'";
                                            $exec401 = mysqli_query($GLOBALS["___mysqli_ston"], $query401) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $res401 = mysqli_fetch_array($exec401);
                                            $packagename = $res401['packagename'];
                                            
                                            $type = $res49['type'];
                                        } else {
                                            $query592 = "select * from ip_bedtransfer where ward='$wardnum' and bed='$bedanum' and recordstatus = '' and locationcode='$locationcode' order by auto_number desc limit 0, 1";
                                            $exec592 = mysqli_query($GLOBALS["___mysqli_ston"], $query592) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $res592 = mysqli_fetch_array($exec592);
                                            $num592 = mysqli_num_rows($exec592);
                                            
                                            if($num592 > 0) {
                                                $ward = $res592['ward'];
                                                $bed = $res592['bed'];
                                                $patientname = $res592['patientname'];
                                                $patientcode = $res592['patientcode'];
                                                $visitcode = $res592['visitcode'];
                                                
                                                $query492 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and locationcode='$locationcode' order by auto_number desc limit 0, 1";
                                                $exec492 = mysqli_query($GLOBALS["___mysqli_ston"], $query492) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $res492 = mysqli_fetch_array($exec492);
                                                $date = $res492['consultationdate'];
                                                $accoutname = $res492['accountfullname'];
                                                $patientlocationcode = $res492['locationcode'];
                                            }
                                        }
                                        
                                        $query51 = "select * from master_bed where auto_number='$bed' and locationcode='$locationcode'";
                                        $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res51 = mysqli_fetch_array($exec51);
                                        $bedname = $res51['bed'];
                                        
                                        $query7811 = "select * from master_ward where auto_number='$ward' and recordstatus='' and locationcode='$locationcode'";
                                        $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $num69 = mysqli_num_rows($exec7811);
                                        $res7811 = mysqli_fetch_array($exec7811);
                                        $wardname1 = $res7811['ward'];
                                        
                                        if($num69 > 0) {
                                            $query82 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and discharge = '' and locationcode='$locationcode'";
                                            $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $num82 = mysqli_num_rows($exec82);
                                            $res82 = mysqli_fetch_array($exec82);
                                            $package = $res82['package'];
                                            $package_process_status = $res82['package_process'];
                                            
                                            if($num82 > 0) {
                                                $colorloopcount = $colorloopcount + 1;
                                                $showcolor = ($colorloopcount & 1);
                                                $rowClass = $showcolor == 0 ? 'even-row' : 'odd-row';
                                                ?>
                                                <tr class="<?php echo $rowClass; ?>">
                                                    <td><?php echo $sno = $sno + 1; ?></td>
                                                    <td>
                                                        <div class="patient-name">
                                                            <i class="fas fa-user"></i>
                                                            <?php echo htmlspecialchars($patientname); ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="patient-code"><?php echo htmlspecialchars($patientcode); ?></span>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($date); ?></td>
                                                    <td>
                                                        <a href="ipquickview.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $visitcode; ?>" 
                                                           target="_blank" class="visit-link">
                                                            <i class="fas fa-external-link-alt"></i>
                                                            <?php echo htmlspecialchars($visitcode); ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="ward-badge"><?php echo htmlspecialchars($wardname1); ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="bed-badge"><?php echo htmlspecialchars($bedname); ?></span>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($accoutname); ?></td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <?php 
                                                            if($package > 0) {
                                                                if($package_process_status == "completed") {
                                                                    ?>
                                                                    <a href="ipdischargerequest.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $visitcode; ?>&patientlocation=<?php echo $location; ?>" 
                                                                       class="action-btn discharge" title="Discharge">
                                                                        <i class="fas fa-user-times"></i>
                                                                        Discharge
                                                                    </a>
                                                                    <?php 
                                                                } else { 
                                                                    ?>
                                                                    <span class="action-btn disabled" title="Package processing not completed">
                                                                        <i class="fas fa-clock"></i>
                                                                        Processing
                                                                    </span>
                                                                    <?php 
                                                                }
                                                            } else {  
                                                                ?>
                                                                <a href="ipdischargerequest.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $visitcode; ?>&patientlocation=<?php echo $location; ?>" 
                                                                   class="action-btn discharge" title="Discharge">
                                                                    <i class="fas fa-user-times"></i>
                                                                    Discharge
                                                                </a>
                                                                <?php 
                                                            } 
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="package-badge"><?php echo htmlspecialchars($packagename); ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="type-badge type-<?php echo strtolower($type); ?>">
                                                            <?php echo ($type == "Hospital") ? "H" : (($type == "private") ? "P" : ""); ?>
                                                        </span>
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
                    <?php
                }
                ?>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ipdischargerequestlist-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>