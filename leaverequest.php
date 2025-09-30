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
$amount1 = '';
$percent1 = '';

if (isset($_REQUEST["type"])) { 
    $global = $_REQUEST["type"]; 
} else { 
    $global = ""; 
}

// Get employee details
$query23 = "select employeecode, employeename, supervisor from master_employee where status NOT IN ('Deleted','Inactive') and username = '$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$employeecode = $res23['employeecode'];
$employeename = $res23['employeename'];
$supervisor_name = $res23['supervisor'];

// Get supervisor details
$query23 = "select employeecode, employeename from master_employee where status NOT IN ('Deleted','Inactive') and employeename LIKE '%$supervisor_name%'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$supervisorcode = $res23['employeecode'];
$supervisorname = $res23['employeename'];

// Handle form submission
if (isset($_POST["frmflag1"])) { 
    $frmflag1 = $_POST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if ($frmflag1 == 'frmflag1') {
    $paynowbillprefix1 = 'LRQ-';
    $paynowbillprefix12 = strlen($paynowbillprefix1);
    $query23 = "select * from leave_request order by auto_number desc limit 0, 1";
    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res23 = mysqli_fetch_array($exec23);
    $billnumber1 = $res23["docno"];
    $billdigit1 = strlen($billnumber1);
    
    if ($billnumber1 == '') {
        $billnumbercode1 = 'LRQ-'.'1';
        $openingbalance1 = '0.00';
    } else {
        $billnumber1 = $res23["docno"];
        $billnumbercode1 = substr($billnumber1, $paynowbillprefix12, $billdigit1);
        $billnumbercode1 = intval($billnumbercode1);
        $billnumbercode1 = $billnumbercode1 + 1;
        $maxanum1 = $billnumbercode1;
        $billnumbercode1 = 'LRQ-'.$maxanum1;
        $openingbalance1 = '0.00';
    }

    $employeecode = $_REQUEST['employeecode'];
    $employeename = $_REQUEST['employeename'];
    $fromdate = $_REQUEST['fromdate'];
    $todate = $_REQUEST['todate'];
    $totaldays = $_REQUEST['totaldays'];
    $remarks = $_REQUEST['remarks'];
    $supervisor = $_REQUEST['supervisor'];
    $supervisorcode = $_REQUEST['supervisorcode'];
    $leavestype = $_REQUEST['leavestype'];
    
    $query77 = "INSERT INTO `leave_request`(`entrydate`, `docno`, `employeecode`, `employeename`, `from_date`, `to_date`, `total_days`, `remarks`, `supervisor`, `supervisorcode`, `username`, `ipaddress`, `updatedatetime`,`leavestype`) 
    VALUES ('".date('Y-m-d')."', '$billnumbercode1', '$employeecode', '$employeename', '$fromdate', '$todate', '$totaldays', '$remarks', '$supervisor', '$supervisorcode', '$username', '$ipaddress', '$updatedatetime', '$leavestype')";
    $exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $errmsg = "Leave request submitted successfully.";
    $bgcolorcode = "success";
    header("location:leaverequest.php?st=success");
    exit;
}

if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if($st == 'success') {
    $errmsg = "Leave request submitted successfully.";
    $bgcolorcode = "success";
} else {
    $errmsg = '';	
}

// Get employee gender for leave type filtering
$gendertype = "SELECT gender FROM master_employeeinfo WHERE employeecode = '$employeecode' ";
$genderexec = mysqli_query($GLOBALS["___mysqli_ston"], $gendertype);
$genderes = mysqli_fetch_array($genderexec);
$gender = strtolower($genderes['gender']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/leaverequest-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- AutoComplete styles -->
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css" />
    
    <!-- JavaScript files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
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
        <a href="hr.php">👥 HR</a>
        <span>→</span>
        <span>Leave Request</span>
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
                        <a href="hr.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>HR Management</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="leaverequest.php" class="nav-link">
                            <i class="fas fa-calendar-times"></i>
                            <span>Leave Request</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="leavehistory.php" class="nav-link">
                            <i class="fas fa-history"></i>
                            <span>Leave History</span>
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
                    <h2>Leave Request</h2>
                    <p>Submit your leave request for approval by your supervisor.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="leavehistory.php" class="btn btn-outline">
                        <i class="fas fa-history"></i> View History
                    </a>
                </div>
            </div>

            <!-- Leave Request Form Section -->
            <div class="leave-form-section">
                <div class="leave-form-header">
                    <i class="fas fa-calendar-plus leave-form-icon"></i>
                    <h3 class="leave-form-title">Submit Leave Request</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="leaverequest.php" onSubmit="return addward1process1()" class="leave-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="employeename" class="form-label">Employee Name</label>
                            <?php if($global != ''): ?>
                                <input name="employeename" id="employeename" class="form-input" 
                                       placeholder="Search employee..." autocomplete="off" />
                                <input type="hidden" name="employeecode" id="employeecode">
                            <?php else: ?>
                                <input type="hidden" name="employeecode" id="employeecode" value="<?php echo htmlspecialchars($employeecode); ?>">
                                <input name="employeename" id="employeename" class="form-input" 
                                       value="<?php echo htmlspecialchars($employeename); ?>" readonly />
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="leavestype" class="form-label">Leave Type</label>
                            <select name="leavestype" id="leavestype" class="form-input" onChange="return DateCalc()">
                                <option value="" selected>Select Leave Type</option>
                                <?php
                                $sleavestype = "SELECT annualleave,maternityleave,paternityleave,compassionateleave,absence, sickleave, unpaidleave, studyleave FROM master_employee WHERE employeecode = '$employeecode' ";
                                $sleaveexec = mysqli_query($GLOBALS["___mysqli_ston"], $sleavestype);
                                $sleaveres = mysqli_fetch_array($sleaveexec);
                                $sleaveres1 = $sleaveres['annualleave'];
                                $sleaveres2 = $sleaveres['maternityleave'];
                                $sleaveres3 = $sleaveres['paternityleave'];
                                $sleaveres4 = $sleaveres['compassionateleave'];
                                $sleaveres5 = $sleaveres['absence'];
                                $sleaveres6 = $sleaveres['sickleave'];
                                $sleaveres7 = $sleaveres['unpaidleave'];
                                $sleaveres8 = $sleaveres['studyleave'];
                                ?>
                                <option value="<?= $sleaveres1.'|'.'Annual Leave'; ?>" >Annual Leave</option>
                                <?php if($gender == 'female' || $global !== ""): ?>
                                <option value="<?= $sleaveres2.'|'.'Maternity Leave'; ?>" >Maternity Leave</option>
                                <?php endif; ?>
                                <?php if($gender == 'male' || $global !== ""): ?>
                                <option value="<?= $sleaveres3.'|'.'Paternity Leave'; ?>" >Paternity Leave</option>
                                <?php endif; ?>
                                <option value="<?= $sleaveres4.'|'.'Compassionate Leave'; ?>" >Compassionate Leave</option>
                                <option value="<?= $sleaveres5.'|'.'Absence'; ?>" >Absence</option>
                                <option value="<?= $sleaveres6.'|'.'Sick Leave'; ?>" >Sick Leave</option>
                                <option value="<?= $sleaveres7.'|'.'Unpaid Leave'; ?>" >Unpaid Leave</option>
                                <option value="<?= $sleaveres8.'|'.'Study Leave'; ?>" >Study Leave</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="fromdate" class="form-label">From Date</label>
                            <div class="date-input-group">
                                <input name="fromdate" id="fromdate" class="form-input" 
                                       value="<?= date('Y-m-d');?>" readonly onChange="return DateCalc()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('fromdate')" style="cursor:pointer" class="date-picker-icon"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="todate" class="form-label">To Date</label>
                            <div class="date-input-group">
                                <input name="todate" id="todate" class="form-input" 
                                       value="" readonly onChange="return DateCalc()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('todate')" style="cursor:pointer" class="date-picker-icon"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="totaldays" class="form-label">Total Days</label>
                            <input name="totaldays" id="totaldays" class="form-input" 
                                   value="" readonly />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group full-width">
                            <label for="remarks" class="form-label">Leave Remarks</label>
                            <textarea name="remarks" id="remarks" class="form-textarea" 
                                      rows="4" placeholder="Please provide details about your leave request..."></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="supervisor" class="form-label">Supervisor</label>
                            <input name="supervisor" id="supervisor" class="form-input" 
                                   value="<?php echo htmlspecialchars($supervisorname); ?>" 
                                   placeholder="Search supervisor..." />
                            <input type="hidden" name="supervisorcode" id="supervisorcode" 
                                   value="<?php echo htmlspecialchars($supervisorcode); ?>"/>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Submit Request
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Leave Information Section -->
            <div class="leave-info-section">
                <div class="leave-info-header">
                    <i class="fas fa-info-circle leave-info-icon"></i>
                    <h3 class="leave-info-title">Leave Information</h3>
                </div>
                
                <div class="leave-info-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <i class="fas fa-calendar-check"></i>
                            <div class="info-content">
                                <h4>Annual Leave</h4>
                                <p><?php echo $sleaveres1; ?> days available</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-heart"></i>
                            <div class="info-content">
                                <h4>Sick Leave</h4>
                                <p><?php echo $sleaveres6; ?> days available</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <div class="info-content">
                                <h4>Study Leave</h4>
                                <p><?php echo $sleaveres8; ?> days available</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div class="info-content">
                                <h4>Unpaid Leave</h4>
                                <p><?php echo $sleaveres7; ?> days available</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/leaverequest-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
