<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$locationcode1 = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Discount Report - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/ipdiscountreport-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
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
        <span>IP Discount Report</span>
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
                        <a href="ipdiscountreport.php" class="nav-link active">
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
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div class="alert-container">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <h2><i class="fas fa-chart-bar"></i> IP Discount Report</h2>
                    <p>Generate and view comprehensive discount reports</p>
                </div>
                <div class="page-actions">
                    <button class="btn btn-primary" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </button>
                </div>
            </div>

            <!-- Search Form -->
            <div class="search-form-container">
                <form name="cbform1" method="post" action="ipdiscountreport.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient">Patient Name</label>
                            <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off" class="form-control" placeholder="Enter patient name">
                        </div>
                        <div class="form-group">
                            <label for="patientcode">Patient Code</label>
                            <input name="patientcode" type="text" id="patientcode" value="" size="50" autocomplete="off" class="form-control" placeholder="Enter patient code">
                        </div>
                        <div class="form-group">
                            <label for="visitcode">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off" class="form-control" placeholder="Enter visit code">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1">Date From</label>
                            <div class="date-input-wrapper">
                                <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" class="form-control date-input" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer" class="date-picker-icon"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ADate2">Date To</label>
                            <div class="date-input-wrapper">
                                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" class="form-control date-input" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer" class="date-picker-icon"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="location">Location</label>
                            <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" class="form-control">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $loccode = array();
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    ?>
                                    <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Data Table Section -->
            <div class="data-table-container">
                <?php
                $colorloopcount = 0;
                $sno = 0;
                if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
                
                if ($cbfrmflag1 == 'cbfrmflag1') {
                    $searchpatient = $_POST['patient'];
                    $searchpatientcode = $_POST['patientcode'];
                    $searchvisitcode = $_POST['visitcode'];
                    $fromdate = $_POST['ADate1'];
                    $todate = $_POST['ADate2'];
                    
                    $querynw1 = "select * from ip_discount where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate'";
                    $execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Querynw1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $resnw1 = mysqli_num_rows($execnw1);
                    ?>
                    <div class="table-header">
                        <h3>IP Discount Report</h3>
                        <div class="table-actions">
                            <span class="result-count">Total Records: <?php echo $resnw1; ?></span>
                            <a href="excel_ipdiscountreport.php?cbfrmflag1=cbfrmflag1&&fromdate=<?php echo $fromdate; ?>&&todate=<?php echo $todate; ?>&&locationcode1=<?php echo $locationcode1; ?>&&searchpatient=<?php echo $searchpatient; ?>&&searchpatientcode=<?php echo $searchpatientcode; ?>&&searchvisitcode=<?php echo $searchvisitcode; ?>" target="_blank" class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Export to Excel
                            </a>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Patient Name</th>
                                    <th>Reg. No.</th>
                                    <th>Visit Code</th>
                                    <th>Remarks</th>
                                    <th>IP Date</th>
                                    <th>Amount</th>
                                    <th>IP Address</th>
                                    <th>Username</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query1 = "select * from ip_discount where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' order by auto_number desc";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $num1 = mysqli_num_rows($exec1);
                                
                                while($res1 = mysqli_fetch_array($exec1)) {
                                    $patientname = $res1['patientname'];
                                    $patientcode = $res1['patientcode'];
                                    $visitcode = $res1['patientvisitcode'];
                                    $consultationdate = $res1['consultationdate'];
                                    $amount = $res1['rate'];
                                    $ipaddress = $res1['ipaddress'];
                                    $username = $res1['username'];
                                    $time = $res1['consultationtime'];
                                    $discount = $res1['description'];
                                    $authorizedby = $res1['authorizedby'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    if ($showcolor == 0) {
                                        $colorcode = 'class="even-row"';
                                    } else {
                                        $colorcode = 'class="odd-row"';
                                    }
                                    ?>
                                    <tr <?php echo $colorcode; ?>>
                                        <td><?php echo $sno = $sno + 1; ?></td>
                                        <td><?php echo $patientname; ?></td>
                                        <td><?php echo $patientcode; ?></td>
                                        <td><?php echo $visitcode; ?></td>
                                        <td>
                                            <div class="discount-remarks">
                                                <strong>Discount On:</strong> <?php echo $discount; ?><br>
                                                <strong>Authorized By:</strong> <?php echo $authorizedby; ?>
                                            </div>
                                        </td>
                                        <td><?php echo $consultationdate; ?></td>
                                        <td><span class="amount"><?php echo number_format($amount,2,'.',','); ?></span></td>
                                        <td><span class="ip-address"><?php echo $ipaddress; ?></span></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo $time; ?></td>
                                    </tr>
                                    <?php
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

    <script src="js/ipdiscountreport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

<script language="javascript">
function ajaxlocationfunction(val) { 
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
    xmlhttp.send();
}

function disableEnterKey(varPassed) {
    if (event.keyCode == 8) {
        event.keyCode = 0; 
        return event.keyCode 
        return false;
    }
    
    var key;
    if(window.event) {
        key = window.event.keyCode;
    } else {
        key = e.which;
    }

    if(key == 13) {
        return false;
    } else {
        return true;
    }
}

function process1backkeypress1() {
    if (event.keyCode == 8) {
        event.keyCode = 0; 
        return event.keyCode 
        return false;
    }
}

function disableEnterKey() {
    if (event.keyCode == 8) {
        event.keyCode = 0; 
        return event.keyCode 
        return false;
    }
    
    var key;
    if(window.event) {
        key = window.event.keyCode;
    } else {
        key = e.which;
    }
    
    if(key == 13) {
        return false;
    } else {
        return true;
    }
}

function paymententry1process2() {
    if (document.getElementById("cbfrmflag1").value == "") {
        alert ("Search Bill Number Cannot Be Empty.");
        document.getElementById("cbfrmflag1").focus();
        document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
        return false;
    }
}

function funcPrintReceipt1() {
    window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}
</script>