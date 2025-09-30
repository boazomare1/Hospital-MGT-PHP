<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];

$query1 = "select locationname, locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);

$res1location = $res1["locationname"];
$res1locationanum = $res1["locationcode"];
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }

$errmsg = "";
if ($cbfrmflag1 == 'cbfrmflag1') {
    $packageid = $_REQUEST['packageid'];
    $consultation_amt = $_REQUEST['consultationamt'];
    $package_item_type = $_REQUEST['packageType'];
    
    $serial4 = $_REQUEST['serialnumbers'];
    $number4 = $serial4;
    
    for ($p = 1; $p <= $number4; $p++) {
        if ($number4 == $p) {
            $sername = $_REQUEST['sername'];
            $sercode = $_REQUEST['sercode'];
            $serrate = $_REQUEST['serrate'];
            $serqty = $_REQUEST['serqty'];
            $seramt = $_REQUEST['seramt'];
        } else {
            $sername = $_REQUEST['sername' . $p];
            $sername = trim($sername);
            $sercode = $_REQUEST['sercode' . $p];
            $serrate = $_REQUEST['serrate' . $p];
            $serqty = $_REQUEST['serqty' . $p];
            $seramt = $_REQUEST['seramt' . $p];
        }
        
        if ($sername != '') {
            $query77 = "insert into package_items (packageid, itemname, itemcode, rate, quantity, amount, itemtype, locationcode, username, ipaddress, updatedatetime, companyanum, companyname) values ('$packageid', '$sername', '$sercode', '$serrate', '$serqty', '$seramt', '$package_item_type', '$locationcode', '$username', '$ipaddress', '$updatedatetime', '$companyanum', '$companyname')";
            $exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }
    
    $errmsg = "Package items saved successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Items - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/packageitems-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Autocomplete -->
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    <link href="js/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
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
        <span>Package Items</span>
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
                        <a href="addippackage.php" class="nav-link">
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
                    <li class="nav-item">
                        <a href="packageitems.php" class="nav-link active">
                            <i class="fas fa-box"></i>
                            <span>Package Items</span>
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
                    <h2><i class="fas fa-box"></i> Package Items</h2>
                    <p>Manage items and services for inpatient packages</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-primary" onclick="exportPackageItems()">
                        <i class="fas fa-download"></i> Export Items
                    </button>
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Items
                    </button>
                </div>
            </div>

            <!-- Package Selection Form -->
            <div class="form-container">
                <form name="cbform1" method="post" action="packageitems.php" class="package-form">
                    <div class="form-header">
                        <h3><i class="fas fa-clipboard-list"></i> Package Selection</h3>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="packageid">Select Package</label>
                            <select name="packageid" id="packageid" class="form-control" required>
                                <option value="">Select Package</option>
                                <?php
                                $query2 = "select * from master_package where status <> 'deleted' order by packagename";
                                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res2 = mysqli_fetch_array($exec2)) {
                                    $packagename = $res2["packagename"];
                                    $packagecode = $res2["auto_number"];
                                    echo "<option value='$packagecode'>$packagename</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="packageType">Item Type</label>
                            <select name="packageType" id="packageType" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="service">Service</option>
                                <option value="medicine">Medicine</option>
                                <option value="lab">Laboratory</option>
                                <option value="radiology">Radiology</option>
                                <option value="consultation">Consultation</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="consultationamt">Consultation Amount</label>
                            <input type="number" name="consultationamt" id="consultationamt" class="form-control" placeholder="0.00" step="0.01">
                        </div>
                        
                        <div class="form-group">
                            <label for="locationcode">Location</label>
                            <select name="locationcode" id="locationcode" class="form-control">
                                <option value="">Select Location</option>
                                <?php
                                $query3 = "select * from master_location where status = '' order by locationname";
                                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res3 = mysqli_fetch_array($exec3)) {
                                    $locationname = $res3["locationname"];
                                    $locationcode = $res3["locationcode"];
                                    if ($locationcode == $res1locationanum) {
                                        echo "<option value='$locationcode' selected>$locationname</option>";
                                    } else {
                                        echo "<option value='$locationcode'>$locationname</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Package Items Management -->
            <div class="item-management">
                <h3><i class="fas fa-cogs"></i> Package Items Management</h3>
                
                <div class="form-actions" style="margin-bottom: 2rem;">
                    <button type="button" class="btn btn-success" id="addItemBtn">
                        <i class="fas fa-plus"></i> Add Item
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="clearAllItems()">
                        <i class="fas fa-trash"></i> Clear All
                    </button>
                </div>
                
                <div id="itemsContainer">
                    <!-- Items will be added dynamically here -->
                </div>
                
                <input type="hidden" name="serialnumbers" id="serialnumbers" value="0">
            </div>

            <!-- Package Summary -->
            <div class="package-summary">
                <h3><i class="fas fa-calculator"></i> Package Summary</h3>
                <div class="summary-grid">
                    <div class="summary-item">
                        <h4>Total Items</h4>
                        <div class="value" id="totalItems">0</div>
                    </div>
                    <div class="summary-item">
                        <h4>Total Amount</h4>
                        <div class="value" id="packageTotal">$0.00</div>
                    </div>
                    <div class="summary-item">
                        <h4>Consultation Fee</h4>
                        <div class="value" id="consultationTotal">$0.00</div>
                    </div>
                    <div class="summary-item">
                        <h4>Grand Total</h4>
                        <div class="value" id="grandTotal">$0.00</div>
                    </div>
                </div>
            </div>

            <!-- Package Items Cards -->
            <div class="package-item-cards">
                <div class="package-item-card">
                    <h4><i class="fas fa-stethoscope"></i> Medical Services</h4>
                    <p>Doctor consultations, examinations, and medical procedures</p>
                </div>
                
                <div class="package-item-card">
                    <h4><i class="fas fa-pills"></i> Medications</h4>
                    <p>Prescribed medicines and pharmaceutical items</p>
                </div>
                
                <div class="package-item-card">
                    <h4><i class="fas fa-flask"></i> Laboratory Tests</h4>
                    <p>Blood tests, urine tests, and other diagnostic procedures</p>
                </div>
                
                <div class="package-item-card">
                    <h4><i class="fas fa-x-ray"></i> Radiology</h4>
                    <p>X-rays, CT scans, MRI, and other imaging services</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                <button type="submit" class="btn btn-success" onclick="savePackageItems()">
                    <i class="fas fa-save"></i> Save Package Items
                </button>
                <button type="button" class="btn btn-primary" onclick="previewPackageItems()">
                    <i class="fas fa-eye"></i> Preview Items
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-undo"></i> Reset
                </button>
            </div>

        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/packageitems-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
