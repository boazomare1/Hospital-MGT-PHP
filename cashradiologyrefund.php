<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";

$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

// Handle form inputs with proper sanitization
$searchstatus = isset($_REQUEST['searchstatus']) ? trim($_REQUEST['searchstatus']) : '';
$patienttype = isset($_REQUEST['patienttype']) ? trim($_REQUEST['patienttype']) : '';
$fromdate = isset($_POST['ADate1']) ? trim($_POST['ADate1']) : $transactiondatefrom;
$todate = isset($_POST['ADate2']) ? trim($_POST['ADate2']) : $transactiondateto;
$category_id = isset($_POST['category_id']) ? trim($_POST['category_id']) : '';

$timeonly = date('H:i:s');
$dateonly = date("Y-m-d");
$docno = $_SESSION['docno'];

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? trim($_REQUEST['location']) : '';
if ($location != '') {
    $locationcode = $location;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Radiology Refund - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/cashradiologyrefund-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Auto Suggest CSS -->
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
        <span>Cash Radiology Refund</span>
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
                        <a href="radiology1.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Radiology</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultation_radiology.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>Radiology Consultation</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="cashradiologyrefund.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Cash Refund</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <?php
            // Set location code
            if ($location != '') {
                $locationcode = $location;
            }
            ?>

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
                    <h2>Cash Radiology Refund</h2>
                    <p>Search and manage cash refunds for radiology services.</p>
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
                    <h3 class="search-form-title">Search Radiology Refunds</h3>
                </div>
                
                <form name="cbform1" method="post" action="cashradiologyrefund.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value)">
                                <?php
                                $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res = mysqli_fetch_array($exec)) {
                                    $reslocation = $res["locationname"];
                                    $reslocationanum = $res["locationcode"];
                                    $selected = ($location != '' && $location == $reslocationanum) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $reslocationanum; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($reslocation); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" class="form-input" 
                                   placeholder="Enter patient name" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="patientcode" class="form-label">Registration No</label>
                            <input name="patientcode" type="text" id="patientcode" class="form-input" 
                                   placeholder="Enter registration number" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" class="form-input" 
                                   placeholder="Enter visit code" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-input">
                                <option value="">All Categories</option>
                                <?php
                                $queryaa1 = "select categoryname,auto_number from master_categoryradiology order by categoryname";
                                $execaa1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryaa1) or die ("Error in Queryaa1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($resaa1 = mysqli_fetch_array($execaa1)) {
                                    $categoryname = $resaa1["categoryname"];
                                    $auto_number = $resaa1["auto_number"];
                                    $selected = ($auto_number == $category_id) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $auto_number; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($categoryname); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" class="form-input" 
                                   value="<?php echo htmlspecialchars($fromdate); ?>" 
                                   readonly="readonly" onKeyDown="return disableEnterKey()" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer" class="date-picker-icon"/>
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" class="form-input" 
                                   value="<?php echo htmlspecialchars($todate); ?>" 
                                   readonly="readonly" onKeyDown="return disableEnterKey()" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer" class="date-picker-icon"/>
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

            <?php
            // PHP Helper Functions
            function calculate_age($birthday) {
                if ($birthday == "0000-00-00") {
                    return "0 Days";
                }
                
                $today = new DateTime();
                $diff = $today->diff(new DateTime($birthday));

                if ($diff->y) {
                    return $diff->y . ' Years';
                } elseif ($diff->m) {
                    return $diff->m . ' Months';
                } else {
                    return $diff->d . ' Days';
                }
            }

            function get_time($g_datetime) {
                $from = date_create(date('Y-m-d H:i:s', strtotime($g_datetime)));
                $to = date_create(date('Y-m-d H:i:s'));
                $diff = date_diff($to, $from);
                
                $y = $diff->y > 0 ? $diff->y.' Years <br>' : '';
                $m = $diff->m > 0 ? $diff->m.' Months <br>' : '';
                $d = $diff->d > 0 ? $diff->d.' Days <br>' : '';
                $h = $diff->h > 0 ? $diff->h.' Hrs <br>' : '';
                $mm = $diff->i > 0 ? $diff->i.' Mins <br>' : '';
                $ss = $diff->s > 0 ? $diff->s.' Secs <br>' : '';

                echo $y.' '.$m.' '.$d.' '.$h.' '.$mm.' '.$ss.' ';
            }
            ?>

            <!-- Results Section -->
            <?php if (isset($_REQUEST["cbfrmflag1"])): ?>
                <?php 
                $cbfrmflag1 = $_REQUEST["cbfrmflag1"];
                if ($cbfrmflag1 == 'cbfrmflag1') {
                    $searchpatient = isset($_POST['patient']) ? trim($_POST['patient']) : '';
                    $searchpatientcode = isset($_POST['patientcode']) ? trim($_POST['patientcode']) : '';
                    $searchvisitcode = isset($_POST['visitcode']) ? trim($_POST['visitcode']) : '';
                    $fromdate = isset($_POST['ADate1']) ? trim($_POST['ADate1']) : $transactiondatefrom;
                    $todate = isset($_POST['ADate2']) ? trim($_POST['ADate2']) : $transactiondateto;
                ?>
                
                <div class="results-section">
                    <div class="results-header">
                        <i class="fas fa-list results-icon"></i>
                        <h3 class="results-title">Radiology Cash Refund Results</h3>
                        <div class="results-actions">
                            <button type="button" class="btn btn-outline" onclick="printReport()">
                                <i class="fas fa-print"></i> Print Report
                            </button>
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>OP Date</th>
                                    <th>OP Time</th>
                                    <th>Patient Code</th>
                                    <th>Visit Code</th>
                                    <th>Patient</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Test</th>
                                    <th>Account</th>
                                    <th>Requested by</th>
                                    <th>Ward/Department</th>
                                    <th>Action</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $colorloopcount = '';
                                $sno = '';

                                if ($category_id != '') {
                                    $queryaa1 = "select * from master_categoryradiology where auto_number='$category_id' order by categoryname";
                                } else {
                                    $queryaa1 = "select * from master_categoryradiology order by categoryname";
                                }
                                $execaa1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryaa1) or die ("Error in Queryaa1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while ($resaa1 = mysqli_fetch_array($execaa1)) {
                                    $data_count = 0;
                                    $categoryname = $resaa1["categoryname"];
                                    $auto_number = $resaa1["auto_number"];
                                ?>
                                
                                <tr class="category-header">
                                    <td colspan="14" class="category-title">
                                        <i class="fas fa-folder"></i> <?php echo htmlspecialchars($categoryname); ?>
                                    </td>
                                </tr>

                                <?php
                                $query1 = "SELECT a.* from consultation_radiology as a JOIN master_radiology as b ON a.radiologyitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.prepstatus='completed' and a.billtype='PAY NOW' and resultentry!='refund' and (a.paymentstatus='completed' OR a.paymentstatus='paid') and a.consultationdate between '$fromdate' and '$todate' and a.locationcode='".$locationcode."' group by a.patientvisitcode,a.radiologyitemcode,a.refno order by a.consultationdate";

                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1patientcode = $res1['patientcode'];
                                    $res1visitcode = $res1['patientvisitcode'];
                                    $res1patientfullname = $res1['patientname'];
                                    $res1account = $res1['accountname'];
                                    $res1consultationdate = $res1['consultationdate'];
                                    $billnumber = $res1['billnumber'];
                                    $urgent = $res1['urgentstatus'];
                                    $username = $res1['username'];
                                    $consultationtime = $res1['consultationtime'];
                                    $radiologyitemcode = $res1['radiologyitemcode'];
                                    $radiologyitemname = $res1['radiologyitemname'];
                                    $refno = $res1['refno'];

                                    $consultationdate = $res1['consultationdate'];
                                    $diff = abs(strtotime($consultationdate) - strtotime($dateonly));
                                    $years = floor($diff / (365*60*60*24));
                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                                    $waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
                                    $waitingtime = round($waitingtime);
                                    $waitingtime = abs($waitingtime);
                                    $waitingtime1 = $waitingtime;
                                    $days = $days;

                                    $userfulldetail = mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode'");
                                    $resuser = mysqli_fetch_array($userfulldetail);
                                    $userfullname = $resuser['employeename'];

                                    $query11 = "select * from master_customer where customercode = '$res1patientcode' and status = ''";
                                    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res11 = mysqli_fetch_array($exec11);
                                    
                                    $query69 = "select * from master_customer where customercode='$res1patientcode'";
                                    $exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res69 = mysqli_fetch_array($exec69);
                                    $patientdob = $res69['dateofbirth'];

                                    $res11age = $res11['age'];
                                    $res11gender = $res11['gender'];
                                    
                                    $query111 = "select * from master_visitentry where patientcode = '$res1patientcode'";
                                    $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res111 = mysqli_fetch_array($exec111);
                                    $res111consultingdoctor = $res111['consultingdoctor'];
                                    $res1111department = $res111['departmentname'];
                                    
                                    // Check if patient is external
                                    if ($res1patientcode == 'walkin') {
                                        $query11 = "select * from billing_external where billno='$billnumber'";
                                        $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res11 = mysqli_fetch_array($exec11);
                                        
                                        $res11age = $res11['age'];
                                        $res11gender = $res11['gender'];
                                        $res1111department = 'External';
                                        $res1visitcode = $res1['billnumber'];
                                    }
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1);
                                    
                                    $rowClass = '';
                                    if ($urgent == 1) {
                                        $rowClass = 'urgent-row';
                                    } else {
                                        $rowClass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                                    }
                                    $data_count++;
                                ?>
                                
                                <tr class="<?php echo $rowClass; ?>">
                                    <td><?php echo $sno = $sno + 1; ?></td>
                                    <td><?php echo htmlspecialchars($res1consultationdate); ?></td>
                                    <td><?php echo htmlspecialchars($consultationtime); ?></td>
                                    <td>
                                        <a href="emr2.php?patientcode=<?php echo $res1patientcode; ?>&visitcode=<?php echo $res1visitcode; ?>" 
                                           class="patient-link">
                                            <?php echo htmlspecialchars($res1patientcode); ?>
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($res1visitcode); ?></td>
                                    <td><?php echo htmlspecialchars($res1patientfullname); ?></td>
                                    <td><?php echo calculate_age($patientdob); ?></td>
                                    <td><?php echo htmlspecialchars($res11gender); ?></td>
                                    <td><?php echo htmlspecialchars($radiologyitemname); ?></td>
                                    <td><?php echo htmlspecialchars($res1account); ?></td>
                                    <td><?php echo htmlspecialchars($userfullname); ?></td>
                                    <td><?php echo htmlspecialchars($res1111department); ?></td>
                                    <td>
                                        <a href="cashradiologyrefund_view.php?patientcode=<?php echo $res1patientcode; ?>&visitcode=<?php echo $res1visitcode; ?>&q_itemcode=<?php echo $radiologyitemcode; ?>&q_refno=<?php echo $refno; ?>&menuid=<?php echo $menu_id; ?>" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                    <td class="<?php echo ($waitingtime1 > 15 || $days > 1) ? 'time-overdue' : ''; ?>">
                                        <?php 
                                        $datetime1 = $res1consultationdate.' '.$consultationtime; 
                                        get_time($datetime1); 
                                        ?>
                                    </td>
                                </tr>
                                
                                <?php
                                }
                                
                                if ($data_count == 0) {
                                    echo "<tr class='no-data-row'><td colspan='14' class='no-data'>No data found for this category.</td></tr>";
                                }
                                ?>
                                
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } ?>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/adddate.js"></script>
    <script src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <script src="js/cashradiologyrefund-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

