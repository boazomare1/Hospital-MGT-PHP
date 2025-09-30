<?php
session_start();
include ("includes/loginverify.php");
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename ='';
$colorloopcount = "";
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname = $res["locationname"];
$locationcode = $res["locationcode"];

if (isset($_REQUEST["pkgtemplate"])) { $pkgtemplate = $_REQUEST["pkgtemplate"]; $_SESSION['pkgtemplate']=$pkgtemplate; } else { $pkgtemplate = ''; }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    $packagename = $_REQUEST["packagename"];
    $packagename = trim($packagename);
    $packagename = addslashes($packagename);
    $selectedlocationcode = $_REQUEST["location"];
    $days = $_REQUEST["days"];
    $bedcharges = $_REQUEST["bedcharges"];
    $threshold = $_REQUEST["threshold"];
    $lab = $_REQUEST["lab"];
    $rate = $_REQUEST["rate"];
    $rate3 = $_REQUEST['rate3'];
    $radiology = $_REQUEST["radiology"];
    $doctor = $_REQUEST["doctor"];
    $admin = $_REQUEST["admin"];
    $service = $_REQUEST["service"];
    $total = $_REQUEST['total'];
    $servicesitem = $_REQUEST['servicesitem'];
    $servicescode = $_REQUEST['servicescode'];
    
    $errmsg = "IP Package created successfully: " . $packagename;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add IP Package - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/addippackage-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
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
            <span class="location-info">📍 Location: <?php echo htmlspecialchars($locationname); ?></span>
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
        <span>Add IP Package</span>
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
                        <a href="ipdischargelist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Discharge List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdischargerequestlist.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Discharge Requests</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdischargelist_tat.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>Discharge TAT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdiscountlist.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>% Discount List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdiscountreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Discount Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdocs.php" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>IP Documents</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdrugconsumptionreport.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Drug Consumption Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdrugintake.php" class="nav-link">
                            <i class="fas fa-capsules"></i>
                            <span>Drug Intake</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipmedicinestatement.php" class="nav-link">
                            <i class="fas fa-prescription"></i>
                            <span>Medicine Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="inpatientactivity.php" class="nav-link">
                            <i class="fas fa-activity"></i>
                            <span>Inpatient Activity</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipvisitentry_new.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>IP Visit Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipcreditaccountreport.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Credit Account Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="iplabresultsviewlist.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Results View</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipmedicineissuelist.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Medicine Issue List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlistmedicine.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ippackageanalysis.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Package Analysis</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addippackage.php" class="nav-link active">
                            <i class="fas fa-plus"></i>
                            <span>Add IP Package</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ippackagereport.php" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>Package Report</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div class="alert-container">
                <?php include ("includes/alertmessages1.php"); ?>
                <?php if ($errmsg != "") { ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $errmsg; ?>
                </div>
                <?php } ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2><i class="fas fa-plus"></i> Add IP Package</h2>
                    <p>Create new inpatient packages with services and pricing</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-success" onclick="previewPackage()">
                        <i class="fas fa-eye"></i> Preview Package
                    </button>
                </div>
            </div>

            <!-- Package Form -->
            <div class="form-container">
                <form name="cbform1" method="post" action="addippackage.php" class="package-form">
                    <div class="form-header">
                        <h3><i class="fas fa-clipboard-list"></i> Package Details</h3>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="packagename">Package Name</label>
                            <input type="text" name="packagename" id="packagename" class="form-control" placeholder="Enter package name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="location">Location</label>
                            <select name="location" id="location" class="form-control" required>
                                <option value="">Select Location</option>
                                <?php
                                $query1 = "select * from master_location where status = '' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    if ($selectedlocationcode == $locationcode) {
                                        echo "<option value='$locationcode' selected>$locationname</option>";
                                    } else {
                                        echo "<option value='$locationcode'>$locationname</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="days">Number of Days</label>
                            <input type="number" name="days" id="days" class="form-control" placeholder="Enter number of days" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="bedcharges">Bed Charges</label>
                            <input type="number" name="bedcharges" id="bedcharges" class="form-control" placeholder="Enter bed charges" step="0.01">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="threshold">Threshold Amount</label>
                            <input type="number" name="threshold" id="threshold" class="form-control" placeholder="Enter threshold amount" step="0.01">
                        </div>
                        
                        <div class="form-group">
                            <label for="pkgtemplate">Package Template</label>
                            <select name="pkgtemplate" id="pkgtemplate" class="form-control">
                                <option value="">Select Template</option>
                                <option value="basic">Basic Package</option>
                                <option value="standard">Standard Package</option>
                                <option value="premium">Premium Package</option>
                                <option value="custom">Custom Package</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Package Services -->
            <div class="package-services">
                <h4><i class="fas fa-list"></i> Package Services</h4>
                
                <div class="service-item">
                    <input type="checkbox" id="lab" name="lab" value="1">
                    <label for="lab">Laboratory Services</label>
                    <input type="number" name="rate" class="service-rate form-control" placeholder="Rate" step="0.01">
                </div>
                
                <div class="service-item">
                    <input type="checkbox" id="radiology" name="radiology" value="1">
                    <label for="radiology">Radiology Services</label>
                    <input type="number" name="rate3" class="service-rate form-control" placeholder="Rate" step="0.01">
                </div>
                
                <div class="service-item">
                    <input type="checkbox" id="doctor" name="doctor" value="1">
                    <label for="doctor">Doctor Consultation</label>
                    <input type="number" name="admin" class="service-rate form-control" placeholder="Rate" step="0.01">
                </div>
                
                <div class="service-item">
                    <input type="checkbox" id="service" name="service" value="1">
                    <label for="service">General Services</label>
                    <input type="number" name="service" class="service-rate form-control" placeholder="Rate" step="0.01">
                </div>
                
                <button type="button" class="btn btn-outline" onclick="addService()">
                    <i class="fas fa-plus"></i> Add Service
                </button>
            </div>

            <!-- Package Summary -->
            <div class="package-summary" id="packageSummary">
                <h4><i class="fas fa-calculator"></i> Package Summary</h4>
                <div class="selected-services"></div>
                <div class="summary-item">
                    <span>Total Amount:</span>
                    <span class="total-amount">0.00</span>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <input type="hidden" name="frmflag1" value="frmflag1">
                <button type="submit" class="btn btn-success" onclick="savePackage()">
                    <i class="fas fa-save"></i> Save Package
                </button>
                <button type="button" class="btn btn-secondary" onclick="resetPackageForm()">
                    <i class="fas fa-undo"></i> Reset
                </button>
            </div>

        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/addippackage-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
