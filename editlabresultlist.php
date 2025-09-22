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
$transactiondatefrom = date('Y-m-d', strtotime('-1 day'));
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno'];

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

// Get location details
$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1)) {
    $res1location = $res1["locationname"];
    $locationcode = $res1["locationcode"];
}

// Handle supplier selection
if (isset($_REQUEST["canum"])) { 
    $getcanum = $_REQUEST["canum"]; 
} else { 
    $getcanum = ""; 
}

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

// Handle form submissions
if (isset($_REQUEST["cbfrmflag2"])) { 
    $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; 
} else { 
    $cbfrmflag2 = ""; 
}

if (isset($_REQUEST["frmflag2"])) { 
    $frmflag2 = $_REQUEST["frmflag2"]; 
} else { 
    $frmflag2 = ""; 
}

if ($frmflag2 == 'frmflag2') {
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
            $query65 = "insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, transactionparticular, billautonumber, billnumber, quantity, remarks, username, ipaddress, rateperunit, totalrate, companyanum, companyname, batchnumber) values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', '$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname', '$batchnumber')";
            $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        } else {
            $query65 = "insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, transactionparticular, billautonumber, billnumber, quantity, remarks, username, ipaddress, rateperunit, totalrate, companyanum, companyname, batchnumber) values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', '$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname', '$batchnumber')";
            $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }
    
    header("location:stockadjustment.php");
    exit;
}

// Handle lab result completion
if (isset($_REQUEST["frm1submit1"])) { 
    $frm1submit1 = $_REQUEST["frm1submit1"]; 
} else { 
    $frm1submit1 = ""; 
}

if ($frm1submit1 == 'frm1submit1') {
    foreach($_POST['docnumber'] as $key => $value) {
        $docno = $_POST['docnumber'][$key];
        $visitcode = $_POST['visitcode'][$key];
        
        foreach($_POST['select'] as $check) {
            $acknow = $check;
            if($acknow == $docno) {
                $query612 = "select * from consultation_lab where patientvisitcode = '$visitcode' order by auto_number desc";
                $exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $res612 = mysqli_fetch_array($exec612);
                $orderedby = $res612['username'];
                
                $query24 = "select * from master_employee where username = '$orderedby'";
                $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $res24 = mysqli_fetch_array($exec24);
                $orderedbyname = $res24['employeename'];
                
                $query76 = "update master_consultation set results='completed', username='$orderedbyname', closevisit='' where patientvisitcode='$visitcode'";
                $exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                
                $query44 = "update consultation_lab set publishstatus='completed' where resultdoc='$docno'";
                $exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                
                $query43 = "update resultentry_lab set publishstatus='completed' where docnumber='$docno'";
                $exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            }
        }
    }
    
    $errmsg = "Lab results published successfully.";
    $bgcolorcode = 'success';
}

// Handle status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == '1') {
    $errmsg = "Success. Payment Entry Update Completed.";
    $bgcolorcode = 'success';
} elseif ($st == '2') {
    $errmsg = "Failed. Payment Entry Not Completed.";
    $bgcolorcode = 'failed';
} else {
    $bgcolorcode = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lab Result List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/lab-result-edit-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Date Picker Scripts -->
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
        <span>Laboratory</span>
        <span>→</span>
        <span>Edit Lab Result List</span>
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
                        <a href="addlabresult.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Add Lab Result</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labresultlist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Lab Result List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="editlabresultlist.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Edit Lab Results</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labresultsviewlist.php" class="nav-link">
                            <i class="fas fa-eye"></i>
                            <span>View Lab Results</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pendinglabs.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>Pending Labs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labtestmaster.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>Lab Test Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labequipment.php" class="nav-link">
                            <i class="fas fa-microscope"></i>
                            <span>Lab Equipment</span>
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
                    <h2>Edit Lab Result List</h2>
                    <p>Search and edit laboratory test results for patients.</p>
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
                    <h3 class="search-form-title">Search Lab Results</h3>
                </div>
                
                <form name="cbform1" method="post" action="editlabresultlist.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" class="form-input" value="" placeholder="Enter patient name..." autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="patientcode" class="form-label">Patient Code</label>
                            <input name="patientcode" type="text" id="patientcode" class="form-input" value="" placeholder="Enter patient code..." autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" class="form-input" value="" placeholder="Enter visit code..." autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="docnumber" class="form-label">Document Number</label>
                            <input name="docnumber" type="text" id="docnumber" class="form-input" value="" placeholder="Enter document number..." autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search Results
                        </button>
                        <button type="reset" name="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <input name="ADate1" id="ADate1" type="hidden" value="<?php echo $transactiondatefrom; ?>" />
                    <input name="ADate2" id="ADate2" type="hidden" value="<?php echo $transactiondateto; ?>" />
                </form>
            </div>

            <!-- Results Section -->
            <?php
            $colorloopcount = 0;
            $sno = 0;
            if (isset($_REQUEST["cbfrmflag1"])) { 
                $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
            } else { 
                $cbfrmflag1 = ""; 
            }
            
            if ($cbfrmflag1 == 'cbfrmflag1') {
                $searchpatient = $_POST['patient'];
                $searchpatientcode = $_POST['patientcode'];
                $searchvisitcode = $_POST['visitcode'];
                $fromdate = $_POST['ADate1'];
                $todate = $_POST['ADate2'];
                $docnumber = $_POST['docnumber'];
            } else {
                $searchpatient = '';
                $searchpatientcode = '';
                $searchvisitcode = '';
                $docnumber = '';
                $fromdate = $transactiondatefrom;
                $todate = $transactiondateto;
            }
            
            // Get result counts
            $querynw1 = "select * from resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumber%' and resultstatus='completed' and publishstatus = '' and locationcode='$locationcode' group by docnumber order by auto_number desc";
            $execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $resnw1 = mysqli_num_rows($execnw1);
            
            $query1 = "select * from ipresultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumber%' and locationcode='$locationcode' group by docnumber order by auto_number desc";
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $num1 = mysqli_num_rows($exec1);
            
            $query131 = "select * from pending_test_orders where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and DATE(sampledate) between '$fromdate' and '$todate' and publishstatus <> 'completed' and result <> '' group by sample_id order by auto_number desc";
            $exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
            $num131 = mysqli_num_rows($exec131);
            
            $resnw1 = $num1 + $resnw1 + $num131;
            ?>
            
            <div class="results-section">
                <div class="results-header">
                    <i class="fas fa-list results-icon"></i>
                    <h3 class="results-title">Lab Results to Edit</h3>
                    <div class="results-info">
                        <span class="results-count">Found <?php echo $resnw1; ?> record(s) matching your search criteria</span>
                    </div>
                </div>
                
                <form name="form1" id="form1" method="post" action="editlabresultlist.php">
                    <div class="data-table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Date</th>
                                    <th>Reg No</th>
                                    <th>Visit No</th>
                                    <th>Patient</th>
                                    <th>Test Name</th>
                                    <th>Ordered By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Regular lab results
                                $query1 = "select * from resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumber%' and resultstatus='completed' and locationcode='$locationcode' group by docnumber order by patientvisitcode";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while($res1 = mysqli_fetch_array($exec1)) {
                                    $itemname = '';
                                    $patientname = $res1['patientname'];
                                    $patientcode = $res1['patientcode'];
                                    $visitcode = $res1['patientvisitcode'];
                                    $consultationdate = $res1['recorddate'];
                                    $docnumber = $res1['docnumber'];
                                    $sampleid = $res1['sampleid'];
                                    
                                    $query11 = "select * from resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber = '$docnumber' and resultstatus='completed' and locationcode='$locationcode' group by itemcode";
                                    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $num11 = mysqli_num_rows($exec11);
                                    
                                    while($res11 = mysqli_fetch_array($exec11)) {
                                        $item = $res11['itemname'];
                                        if($num11 == '1') {
                                            $itemname = $item;
                                        } else {
                                            $itemname = $item.', '. $itemname;
                                        }
                                        $itemcode = $res11['itemcode'];
                                    }
                                    
                                    $query23 = "select * from consultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and labitemcode='$itemcode'";
                                    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res23 = mysqli_fetch_array($exec23);
                                    $requestedby = $res23['username'];
                                    
                                    $query24 = "select * from master_employee where username = '$requestedby'";
                                    $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res24 = mysqli_fetch_array($exec24);
                                    $requestedbyname = $res24['employeename'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1);
                                    $colorcode = ($showcolor == 0) ? 'even' : 'odd';
                                    ?>
                                    <tr class="<?php echo $colorcode; ?>">
                                        <td><?php echo $sno = $sno + 1; ?></td>
                                        <td><?php echo $consultationdate; ?></td>
                                        <td>
                                            <span class="patient-code-badge"><?php echo htmlspecialchars($patientcode); ?></span>
                                        </td>
                                        <td>
                                            <span class="visit-code-badge"><?php echo htmlspecialchars($visitcode); ?></span>
                                        </td>
                                        <td class="patient-name"><?php echo htmlspecialchars($patientname); ?></td>
                                        <td class="test-name"><?php echo htmlspecialchars($itemname); ?></td>
                                        <td><?php echo htmlspecialchars($requestedbyname); ?></td>
                                        <td>
                                            <a href="editlabresult.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $visitcode; ?>&docnumber=<?php echo $docnumber; ?>&sampleid=<?php echo $sampleid; ?>" 
                                               class="action-btn edit" title="Edit Lab Result">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                        <input type="hidden" name="visitcode[]" value="<?php echo $visitcode; ?>">
                                        <input type="hidden" name="docnumber[]" value="<?php echo $docnumber; ?>">
                                    </tr>
                                    <?php
                                }
                                
                                // IP lab results
                                $query1 = "select * from ipresultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumber%' and locationcode='$locationcode' group by docnumber order by auto_number desc";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while($res1 = mysqli_fetch_array($exec1)) {
                                    $itemname = '';
                                    $patientname = $res1['patientname'];
                                    $patientcode = $res1['patientcode'];
                                    $visitcode = $res1['patientvisitcode'];
                                    $iprecorddate = $res1['recorddate'];
                                    $docnumbernew = $res1['docnumber'];
                                    $itemcodeip = $res1['itemcode'];
                                    
                                    $query11 = "select * from ipresultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumbernew%' and locationcode='$locationcode' group by itemcode";
                                    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $num11 = mysqli_num_rows($exec11);
                                    
                                    while($res11 = mysqli_fetch_array($exec11)) {
                                        $item = $res11['itemname'];
                                        if($num11 == '1') {
                                            $itemname = $item;
                                        } else {
                                            $itemname = $item.', '. $itemname;
                                        }
                                        $itemcode = $res11['itemcode'];
                                    }
                                    
                                    $query7 = "select * from ipconsultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and labitemcode='$itemcodeip'";
                                    $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res45 = mysqli_fetch_array($exec7);
                                    $dno = $res45['iptestdocno'];
                                    
                                    $query23 = "select * from iptest_procedures where docno='$dno' and patientcode='$patientcode' and visitcode='$visitcode'";
                                    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res23 = mysqli_fetch_array($exec23);
                                    $requestedby = $res23['username'];
                                    
                                    $query24 = "select * from master_employee where username = '$requestedby'";
                                    $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res24 = mysqli_fetch_array($exec24);
                                    $requestedbyname = $res24['employeename'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1);
                                    $colorcode = ($showcolor == 0) ? 'even' : 'odd';
                                    ?>
                                    <tr class="<?php echo $colorcode; ?>">
                                        <td><?php echo $sno = $sno + 1; ?></td>
                                        <td><?php echo $iprecorddate; ?></td>
                                        <td>
                                            <span class="patient-code-badge"><?php echo htmlspecialchars($patientcode); ?></span>
                                        </td>
                                        <td>
                                            <span class="visit-code-badge"><?php echo htmlspecialchars($visitcode); ?></span>
                                        </td>
                                        <td class="patient-name"><?php echo htmlspecialchars($patientname); ?></td>
                                        <td class="test-name"><?php echo htmlspecialchars($itemname); ?></td>
                                        <td><?php echo htmlspecialchars($requestedbyname); ?></td>
                                        <td>
                                            <a href="editiplabresult.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $visitcode; ?>&docnumber=<?php echo $docnumbernew; ?>" 
                                               class="action-btn edit" title="Edit IP Lab Result">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                        <input type="hidden" name="visitcode[]" value="<?php echo $visitcode; ?>">
                                        <input type="hidden" name="docnumber[]" value="<?php echo $docnumbernew; ?>">
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="frm1submit1" value="frm1submit1" />
                        <input type="hidden" name="doccno" value="<?php echo $billnumbercode; ?>">
                    </div>
                </form>
            </div>
            }
            ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/lab-result-edit-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript -->
    <script>
    function cbsuppliername1() {
        document.cbform1.submit();
    }
    
    function pendingfunc(visitcode) {
        var varvisitcode = visitcode;
        window.open("pendinglabs.php?visitcode="+varvisitcode+"", "OriginalWindowA5", 'width=500,height=400,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
    }
    
    function disableEnterKey() {
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
    </script>
</body>
</html>
