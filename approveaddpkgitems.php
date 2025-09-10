<?php
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

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if ($location != '') {
    $locationcode = $location;
}

// Get user location details
$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationname"];

// Get pending package items count
$query82 = "select count(*) as total from addpkgitems where locationcode='$locationcode' and recordstatus= '' group by visitcode";
$exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res82 = mysqli_fetch_array($exec82);
$pendingPackageCount = isset($res82['total']) ? $res82['total'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Additional Package Items - MedStar</title>
    
    <!-- External Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/approveaddpkgitems-modern.css">
    
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
         <span>Package Approval</span>
     </nav>

    <!-- Floating Menu Toggle -->
    <div class="floating-menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container -->
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
                         <a href="approveaddpkgitems.php" class="nav-link">
                             <i class="fas fa-check-circle"></i>
                             <span>Package Approval</span>
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
                        <i class="fas fa-check-circle"></i>
                        Approve Additional Package Items
                    </h2>
                    <p>Manage and approve additional package items for inpatients</p>
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
                    <h3>Search Package Items</h3>
                </div>
                <div class="search-form-content">
                    <form name="cbform1" method="post" action="approveaddpkgitems.php" id="searchForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="location" class="form-label">Location <span style="color: red;">*</span></label>
                                <select name="location" id="location" class="form-select" onChange="funcSubTypeChange1(); ajaxlocationfunction(this.value);" required>
                                    <option value="">Select Location</option>
                                    <?php
                                    $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res1 = mysqli_fetch_array($exec1)) {
                                        $locationname = $res1["locationname"];
                                        $locationcode = $res1["locationcode"];
                                    ?>
                                    <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ward" class="form-label">Ward</label>
                                <div class="ward-select-group">
                                    <select name="ward" id="ward" class="form-select">
                                        <option value="">Select Ward</option>
                                    </select>
                                    <i class="fas fa-hospital ward-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">
                            <input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">
                            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                            <button type="submit" class="submit-btn" onClick="return funcvalidcheck();">
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

            <!-- Package Items List Section -->
            <?php
            $colorloopcount = 0;
            $sno = 0;
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            
            if ($cbfrmflag1 == 'cbfrmflag1') {
                $locationcode = $_REQUEST['location'];
            ?>
            <div class="package-list-section">
                <div class="package-list-header">
                    <h3>
                        <i class="fas fa-list"></i>
                        Package Items List
                    </h3>
                    <div class="package-count"><?php echo $pendingPackageCount; ?></div>
                    <div class="package-list-actions">
                        <button class="btn btn-outline" onclick="refreshPage()">
                            <i class="fas fa-sync-alt"></i>
                            Refresh
                        </button>
                    </div>
                </div>
                
                <div class="package-table-container">
                    <table class="package-table" id="packageTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Patient Name</th>
                                <th>Reg No</th>
                                <th>DOA</th>
                                <th>IP Visit</th>
                                <th>Package Name</th>
                                <th>Sub Type</th>
                                <th>Account</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query82 = "select * from addpkgitems where locationcode='$locationcode' and recordstatus= '' group by visitcode";
                            $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            $num82 = mysqli_num_rows($exec82);
                            
                            if ($num82 == 0) {
                                echo '<tr><td colspan="9" class="empty-state">';
                                echo '<div class="empty-state-icon"><i class="fas fa-inbox"></i></div>';
                                echo '<div class="empty-state-title">No Package Items Found</div>';
                                echo '<div class="empty-state-description">No additional package items are pending approval for the selected location.</div>';
                                echo '</td></tr>';
                            } else {
                                while($res82 = mysqli_fetch_array($exec82)) {
                                    $patientname = $res82['patientname'];
                                    $patientcode = $res82['patientcode'];
                                    $visitcode = $res82['visitcode'];
                                    $date = date('d/m/Y', strtotime($res82['createdon']));

                                    $query821 = "select mipv.* from master_ipvisitentry mipv inner join package_items pi on mipv.package = pi.package_id where mipv.locationcode='$locationcode' and mipv.paymentstatus!='completed' and mipv.bedallocation='completed' and mipv.visitcode='$visitcode' group by mipv.visitcode";
                                    $exec821 = mysqli_query($GLOBALS["___mysqli_ston"], $query821) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $num821 = mysqli_num_rows($exec821);

                                    $query = mysqli_query($GLOBALS["___mysqli_ston"], "select main.accountname accountname, sub.accountssub accountssub from master_accountname main inner join master_accountssub sub on main.accountssub=sub.auto_number join master_ipvisitentry as sub1 on main.auto_number=sub1.accountname where sub1.visitcode = '$visitcode'");
                                    $res = mysqli_fetch_array($query);
                                    $accoutname = $res['accountname'];
                                    $accsub = $res['accountssub'];

                                    $query401 = "select a.packagename from master_ippackage as a join package_processing as b on a.auto_number=b.package_id where b.visitcode = '$visitcode'";
                                    $exec401 = mysqli_query($GLOBALS["___mysqli_ston"], $query401) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res401 = mysqli_fetch_array($exec401);
                                    $pckrows = mysqli_num_rows($exec401);
                                    $packagename = $res401['packagename'];

                                    if($num821 > 0) {
                                        $colorloopcount = $colorloopcount + 1;
                                        $showcolor = ($colorloopcount & 1); 
                                        if ($showcolor == 0) {
                                            $colorcode = 'bgcolor="#CBDBFA"';
                                        } else {
                                            $colorcode = 'bgcolor="#ecf0f5"';
                                        }
                            ?>
                            <tr <?php echo $colorcode; ?> data-visitcode="<?php echo $visitcode; ?>">
                                <td class="package-number"><?php echo $sno = $sno + 1; ?></td>
                                <td class="package-patientname"><?php echo htmlspecialchars($patientname); ?></td>
                                <td class="package-patientcode"><?php echo htmlspecialchars($patientcode); ?></td>
                                <td class="package-date"><?php echo $date; ?></td>
                                <td class="package-visitcode"><?php echo htmlspecialchars($visitcode); ?></td>
                                <td class="package-name"><?php echo htmlspecialchars($packagename); ?></td>
                                <td class="package-subtype"><?php echo htmlspecialchars($accsub); ?></td>
                                <td class="package-account"><?php echo htmlspecialchars($accoutname); ?></td>
                                <td class="package-action">
                                    <a href="ippackageadditionalitemsapproval.php?patientcode=<?php echo urlencode($patientcode); ?>&visitcode=<?php echo urlencode($visitcode); ?>&patientlocation=<?php echo urlencode($location); ?>&menuid=<?php echo urlencode($menu_id); ?>" 
                                       class="view-approve-btn"
                                       data-patientcode="<?php echo htmlspecialchars($patientcode); ?>"
                                       data-visitcode="<?php echo htmlspecialchars($visitcode); ?>"
                                       data-patientlocation="<?php echo htmlspecialchars($location); ?>"
                                       data-menuid="<?php echo htmlspecialchars($menu_id); ?>">
                                        <i class="fas fa-eye"></i>
                                        View & Approve
                                    </a>
                                </td>
                            </tr>
                            <?php 
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
                            <span class="summary-label">Total Package Items</span>
                            <span class="summary-value"><?php echo $pendingPackageCount; ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Pending Approval</span>
                            <span class="summary-value summary-pending"><?php echo $pendingPackageCount; ?></span>
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
    <script src="js/approveaddpkgitems-modern.js"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
</body>
</html>

