<?php 
session_start();
error_reporting(0);
include ("includes/loginverify.php");
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$myBase = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$consultationfees1 = '';
$availablelimit = '';
$admissionfees = '';
$photoavailable = '';
$memberno='';
$overallplandue = 0;
$currentdate = date('Y-m-d H:i:s');
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$locationcode = isset($_REQUEST["location"]) ? $_REQUEST["location"] : '';

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    visitcreate:
    $ipaddress = $_SERVER["REMOTE_ADDR"];
    $username = $_SESSION['username'];
    
    if($username != '') {
        $patientcode = $_REQUEST["patientcode"];
        $locationcode = $_REQUEST["location"]; 
        
        $query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
        $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res = mysqli_fetch_array($exec);
        
        $res12location = $res["locationname"];
        $res12locationanum = $res["auto_number"];
        $query3 = "select * from master_location where status = '' and locationcode='$locationcode'"; 
        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res3 = mysqli_fetch_array($exec3);
        $res3locationname = $res3["locationname"];
        
        $query4 = "select * from master_customer where auto_number = '$patientcode'";
        $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res4 = mysqli_fetch_array($exec4);
        $res4customername = $res4["customername"];
        $res4customercode = $res4["customercode"];
        
        $errmsg = "Visit created successfully for patient: " . $res4customername;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Visit Entry - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ipvisitentry_new-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Autocomplete -->
    <link href="autocomplete.css" rel="stylesheet">
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    
    <script language="javascript">
    function cbsuppliername1() {
        document.cbform1.submit();
    }

    function disableEnterKey(varPassed) {
        if (event.keyCode==8) {
            event.keyCode=0; 
            return event.keyCode 
            return false;
        }
        
        var key;
        if(window.event) {
            key = window.event.keyCode;     //IE
        } else {
            key = e.which;     //firefox
        }
        
        if(key == 13) // if enter key press
        {
            return false;
        } else {
            return true;
        }
    }

    function process1backkeypress1() {
        if (event.keyCode==8) {
            event.keyCode=0; 
            return event.keyCode 
            return false;
        }
    }

    function disableEnterKey() {
        if (event.keyCode==8) {
            event.keyCode=0; 
            return event.keyCode 
            return false;
        }
        
        var key;
        if(window.event) {
            key = window.event.keyCode;     //IE
        } else {
            key = e.which;     //firefox
        }
        
        if(key == 13) // if enter key press
        {
            return false;
        } else {
            return true;
        }
    }
    </script>
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
        <span>IP Visit Entry</span>
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
                        <a href="ipvisitentry_new.php" class="nav-link active">
                            <i class="fas fa-user-plus"></i>
                            <span>IP Visit Entry</span>
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
                    <h2><i class="fas fa-user-plus"></i> IP Visit Entry</h2>
                    <p>Create and manage new inpatient visit entries</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-success" onclick="createNewVisit()">
                        <i class="fas fa-plus"></i> New Visit
                    </button>
                </div>
            </div>

            <!-- Patient Search Form -->
            <div class="form-container">
                <form name="cbform1" method="post" action="ipvisitentry_new.php" class="search-form">
                    <div class="form-header">
                        <h3><i class="fas fa-search"></i> Patient Search</h3>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patientcode">Patient Code</label>
                            <input type="text" name="patientcode" id="patientcode" class="form-control" placeholder="Enter patient code" required>
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
                                    if ($location == $locationcode) {
                                        echo "<option value='$locationcode' selected>$locationname</option>";
                                    } else {
                                        echo "<option value='$locationcode'>$locationname</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-primary" onclick="searchPatient()">
                            <i class="fas fa-search"></i> Search Patient
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Patient Info Card -->
            <div class="patient-info-card" id="patientInfoCard">
                <div class="patient-info-header">
                    <div class="patient-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="patient-details">
                        <h4>No Patient Selected</h4>
                        <p>Please search for a patient to view details</p>
                    </div>
                </div>
            </div>

            <!-- Visit Form -->
            <div class="visit-form">
                <h3><i class="fas fa-clipboard-list"></i> Visit Details</h3>
                
                <form name="visitform" method="post" action="ipvisitentry_new.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="visitdate">Visit Date</label>
                            <input type="text" name="visitdate" id="visitdate" value="<?php echo date('Y-m-d'); ?>" class="form-control date-picker" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="visittime">Visit Time</label>
                            <input type="time" name="visittime" id="visittime" value="<?php echo date('H:i'); ?>" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="visittype">Visit Type</label>
                            <select name="visittype" id="visittype" class="form-control">
                                <option value="consultation">Consultation</option>
                                <option value="followup">Follow-up</option>
                                <option value="emergency">Emergency</option>
                                <option value="routine">Routine Check-up</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="department">Department</label>
                            <select name="department" id="department" class="form-control">
                                <option value="">Select Department</option>
                                <option value="cardiology">Cardiology</option>
                                <option value="neurology">Neurology</option>
                                <option value="orthopedics">Orthopedics</option>
                                <option value="pediatrics">Pediatrics</option>
                                <option value="surgery">Surgery</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="notes">Visit Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="4" placeholder="Enter visit notes..."></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="frmflag1" value="frmflag1">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Create Visit
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ipvisitentry_new-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
