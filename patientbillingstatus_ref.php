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
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno'];

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if ($location != '') {
    $locationcode = $location;
}

// Get location details
$query1111 = "select * from master_employee where username = '$username'";
$exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1111 = mysqli_fetch_array($exec1111)) {
    $locationnumber = $res1111["location"];
    $query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'delete'";
    $exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
    while ($res1112 = mysqli_fetch_array($exec1112)) {
        $locationname = $res1112["locationname"];    
        $locationcode = $res1112["locationcode"];
    }
}

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == '1') {
    $errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2') {
    $errmsg = "Failed. Payment Entry Not Completed.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Billing Status Reference - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/patientbillingstatus_ref-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Patient Billing Status Reference</span>
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
                        <a href="cashrefundsreport.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Cash Refunds Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cashservicesrefund.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>Cash Services Refund</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ippatientdetails.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>IP Patient Details</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="patientbillingstatus_ref.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Billing Status Reference</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Patient Billing Status Reference</h2>
                    <p>Search and manage patient billing status, refunds, and payment processing.</p>
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
                    <h3 class="search-form-title">Search Patient to Bill</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="patientbillingstatus_ref.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value)">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1location = $res1["locationname"];
                                    $res1locationanum = $res1["locationcode"];
                                    $selected = ($location != '' && $location == $res1locationanum) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $res1locationanum; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($res1location); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                   class="form-input date-input" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                   class="form-input date-input" readonly="readonly">
                        </div>
                    </div>

                    <div class="form-row">
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

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Table Section -->
            <div class="results-table-section">
                <div class="results-table-header">
                    <i class="fas fa-list results-table-icon"></i>
                    <h3 class="results-table-title">Patient Billing Status Results</h3>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Reg Code</th>
                            <th>Visit Code</th>
                            <th>OP Date</th>
                            <th>Patient Name</th>
                            <th>Type</th>
                            <th>Account Name</th>
                            <th>Awaiting</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $colorloopcount = 0;
                        $sno = 0;
                        if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
                        
                        if ($cbfrmflag1 == 'cbfrmflag1') {
                            $searchpatient = $_REQUEST['patient'];
                            $searchpatientcode = $_REQUEST['patientcode'];
                            $searchvisitcode = $_REQUEST['visitcode'];
                            $fromdate = $_REQUEST['ADate1'];
                            $todate = $_REQUEST['ADate2'];

                            // Query for master billing refunds
                            $query76 = "select * from master_billing where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientfullname like '%$searchpatient%' and billingdatetime between '$fromdate' and '$todate' and refund_status='approved' group by visitcode,billnumber order by billingdatetime desc";
                            $exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while($res76 = mysqli_fetch_array($exec76)) {
                                $patientcode = $res76['patientcode'];
                                $patientvisitcode = $res76['visitcode'];
                                $consultationdate = $res76['billingdatetime'];
                                $patientname = $res76['patientfullname'];
                                $accountname = $res76['accountname'];
                                $billtype = $res76['billtype'];
                                $res761paymenttype = $res76['paymenttype'];
                                $billnumber = $res76['billnumber'];
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                $rowclass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                        ?>
                        <tr class="<?php echo $rowclass; ?>">
                            <td class="modern-cell"><?php echo $colorloopcount; ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($patientcode); ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($patientvisitcode); ?></td>
                            <td class="modern-cell"><?php echo $consultationdate; ?></td>
                            <td class="modern-cell">
                                <div class="patient-info">
                                    <strong><?php echo htmlspecialchars($patientname); ?></strong>
                                </div>
                            </td>
                            <td class="modern-cell"><?php echo htmlspecialchars($res761paymenttype); ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($accountname); ?></td>
                            <td class="modern-cell">
                                <a href="consultationrefund.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $patientvisitcode; ?>&billnumber=<?php echo $billnumber; ?>&menuid=<?php echo $menu_id; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-undo"></i> Refund
                                </a>
                            </td>
                        </tr>
                        <?php
                            }

                            // Query for item refunds
                            $query21 = "select * from master_item_refund where visitcode like '%$searchvisitcode%' and date(approved_date) between '$fromdate' and '$todate' and billstatus='approved' group by billnumber order by approved_date desc";
                            $res21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while($exec21 = mysqli_fetch_array($res21)) {
                                $billno1 = $exec21['billnumber'];
                                $billno = $exec21['billnumber'];
                                $visitcode = $exec21['visitcode'];
                                $patientcode = $exec21['patientcode'];
                                $searchpatient1 = trim($searchpatient);
                                
                                $query34 = mysqli_query($GLOBALS["___mysqli_ston"], "select patientfullname,accountfullname from master_visitentry where visitcode='$visitcode'");
                                $exec34 = mysqli_fetch_array($query34);
                                $accountname = $exec34['accountfullname'];
                                $patientname = $exec34['patientfullname'];
                                $consultationdate = date("Y-m-d", strtotime($exec21['approved_date']));
                                $res3paymenttype = 'CASH';
                                
                                if(($patientname != '')) {
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    $rowclass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                        ?>
                        <tr class="<?php echo $rowclass; ?>">
                            <td class="modern-cell"><?php echo $colorloopcount; ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($patientcode); ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($visitcode); ?></td>
                            <td class="modern-cell"><?php echo $consultationdate; ?></td>
                            <td class="modern-cell">
                                <div class="patient-info">
                                    <strong><?php echo htmlspecialchars($patientname); ?></strong>
                                </div>
                            </td>
                            <td class="modern-cell"><?php echo $res3paymenttype; ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($accountname); ?></td>
                            <td class="modern-cell">
                                <a href="refund_paynow.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $visitcode; ?>&billno=<?php echo $billno ?>&rfkey=pharma&menuid=<?php echo $menu_id; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-undo"></i> Refund
                                </a>
                            </td>
                        </tr>
                        <?php
                                }
                            }

                            // Query for pharmacy sales return details (walkin)
                            $query21 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from pharmacysalesreturn_details where billstatus<>'completed' and patientcode = 'walkin' and entrydate between '$fromdate' and '$todate' order by entrydate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($exec21 = mysqli_fetch_array($query21)) {
                                $billno = $exec21['billnumber'];
                                $visitcode = $exec21['visitcode'];
                                $searchpatient1 = trim($searchpatient);
                                $query39 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultationpharm where patientname like '%$searchpatient%' and patientvisitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res39 = mysqli_fetch_array($query39);
                                $patientname = $res39['patientname'];
                                $patientcode = $exec21['patientcode'];
                                
                                if($patientcode == 'walkin') {
                                    $billno = $exec21['billnumber'];
                                    $patientvisitcode = 'walkinvis';
                                } else {
                                    $billno = $exec21['docnumber'];
                                    $patientvisitcode = $exec21['visitcode'];
                                }
                                
                                $query34 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $exec34 = mysqli_fetch_array($query34);
                                $accname = $exec34['accountname'];
                                $consultationdate = $exec21['entrydate'];
                                $res3paymenttype = 'CASH';
                                $accountname = 'CASH';
                                
                                if($patientname != '') {
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    $rowclass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                        ?>
                        <tr class="<?php echo $rowclass; ?>">
                            <td class="modern-cell"><?php echo $colorloopcount; ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($patientcode); ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($patientvisitcode); ?></td>
                            <td class="modern-cell"><?php echo $consultationdate; ?></td>
                            <td class="modern-cell">
                                <div class="patient-info">
                                    <strong><?php echo htmlspecialchars($patientname); ?></strong>
                                </div>
                            </td>
                            <td class="modern-cell"><?php echo $res3paymenttype; ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($accountname); ?></td>
                            <td class="modern-cell">
                                <a href="refund_external.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $patientvisitcode; ?>&billno=<?php echo $billno ?>&rfkey=prm&menuid=<?php echo $menu_id; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-undo"></i> Refund
                                </a>
                            </td>
                        </tr>
                        <?php
                                }
                            }

                            // Query for consultation radiology (walkin)
                            $query21 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_radiology where patientname like '%$searchpatient%' and radiologyrefund='refund' and refundapprove = 'approved' and patientcode = 'walkin' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' group by patientvisitcode order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($exec21 = mysqli_fetch_array($query21)) {
                                $billno = $exec21['billnumber'];
                                $patientname = $exec21['patientname'];
                                $patientcode = $exec21['patientcode'];
                                
                                if($patientcode == 'walkin') {
                                    $billno = $exec21['billnumber'];
                                    $patientvisitcode = 'walkinvis';
                                } else {
                                    $billno = $exec21['docnumber'];
                                    $patientvisitcode = $exec21['patientvisitcode'];
                                }
                                
                                $query34 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $exec34 = mysqli_fetch_array($query34);
                                $accname = $exec34['accountname'];
                                $consultationdate = $exec21['consultationdate'];
                                $res3paymenttype = 'CASH';
                                $accountname = 'CASH';
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                $rowclass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                        ?>
                        <tr class="<?php echo $rowclass; ?>">
                            <td class="modern-cell"><?php echo $colorloopcount; ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($patientcode); ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($patientvisitcode); ?></td>
                            <td class="modern-cell"><?php echo $consultationdate; ?></td>
                            <td class="modern-cell">
                                <div class="patient-info">
                                    <strong><?php echo htmlspecialchars($patientname); ?></strong>
                                </div>
                            </td>
                            <td class="modern-cell"><?php echo $res3paymenttype; ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($accountname); ?></td>
                            <td class="modern-cell">
                                <a href="refund_external.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $patientvisitcode; ?>&billno=<?php echo $billno ?>&rfkey=cr&menuid=<?php echo $menu_id; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-undo"></i> Refund
                                </a>
                            </td>
                        </tr>
                        <?php
                            }

                            // Query for consultation services (walkin)
                            $query21 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_services where patientname like '%$searchpatient%' and servicerefund='refund' and refundapprove = 'approved' and patientcode = 'walkin' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' AND consultationdate between '$fromdate' and '$todate' group by patientvisitcode order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($exec21 = mysqli_fetch_array($query21)) {
                                $billno = $exec21['billnumber'];
                                $patientname = $exec21['patientname'];
                                $patientcode = $exec21['patientcode'];
                                
                                if($patientcode == 'walkin') {
                                    $billno = $exec21['billnumber'];
                                    $patientvisitcode = 'walkinvis';
                                } else {
                                    $billno = $exec21['docnumber'];
                                    $patientvisitcode = $exec21['patientvisitcode'];
                                }
                                
                                $query34 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $exec34 = mysqli_fetch_array($query34);
                                $accname = $exec34['accountname'];
                                $consultationdate = $exec21['consultationdate'];
                                $res3paymenttype = 'CASH';
                                $accountname = 'CASH';
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                $rowclass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                        ?>
                        <tr class="<?php echo $rowclass; ?>">
                            <td class="modern-cell"><?php echo $colorloopcount; ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($patientcode); ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($patientvisitcode); ?></td>
                            <td class="modern-cell"><?php echo $consultationdate; ?></td>
                            <td class="modern-cell">
                                <div class="patient-info">
                                    <strong><?php echo htmlspecialchars($patientname); ?></strong>
                                </div>
                            </td>
                            <td class="modern-cell"><?php echo $res3paymenttype; ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($accountname); ?></td>
                            <td class="modern-cell">
                                <a href="refund_external.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $patientvisitcode; ?>&billno=<?php echo $billno ?>&rfkey=cs&menuid=<?php echo $menu_id; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-undo"></i> Refund
                                </a>
                            </td>
                        </tr>
                        <?php
                            }

                            // Query for consultation lab (walkin)
                            $query21 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_lab where patientname like '%$searchpatient%' and labrefund='refund' and refundapproval = 'approved' and patientcode = 'walkin' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' GROUP BY billnumber order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($exec21 = mysqli_fetch_array($query21)) {
                                $billno = $exec21['billnumber'];
                                $patientname = $exec21['patientname'];
                                $patientcode = $exec21['patientcode'];
                                
                                if($patientcode == 'walkin') {
                                    $billno = $exec21['billnumber'];
                                    $patientvisitcode = 'walkinvis';
                                } else {
                                    $billno = $exec21['docnumber'];
                                    $patientvisitcode = $exec21['patientvisitcode'];
                                }
                                
                                $query34 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $exec34 = mysqli_fetch_array($query34);
                                $accname = $exec34['accountname'];
                                $consultationdate = $exec21['consultationdate'];
                                $res3paymenttype = 'CASH';
                                $accountname = 'CASH';
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                $rowclass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                        ?>
                        <tr class="<?php echo $rowclass; ?>">
                            <td class="modern-cell"><?php echo $colorloopcount; ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($patientcode); ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($patientvisitcode); ?></td>
                            <td class="modern-cell"><?php echo $consultationdate; ?></td>
                            <td class="modern-cell">
                                <div class="patient-info">
                                    <strong><?php echo htmlspecialchars($patientname); ?></strong>
                                </div>
                            </td>
                            <td class="modern-cell"><?php echo $res3paymenttype; ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($accountname); ?></td>
                            <td class="modern-cell">
                                <a href="refund_external.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $patientvisitcode; ?>&billno=<?php echo $billno ?>&rfkey=cl" class="btn btn-primary btn-sm">
                                    <i class="fas fa-undo"></i> Refund
                                </a>
                            </td>
                        </tr>
                        <?php
                            }

                            // Query for approved deposit refund
                            $refund = "select * from approveddeposit_refund where patientcode like '%$searchpatientcode%' and patientname like'%$searchpatient%' and status='process' and recorddate between '$fromdate' and '$todate' order by auto_number desc";
                            $exerefund = mysqli_query($GLOBALS["___mysqli_ston"], $refund) or die("Error in refund".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($resrefund = mysqli_fetch_array($exerefund)) {
                                $patientname1 = $resrefund['patientname'];
                                $patientcode1 = $resrefund['patientcode'];
                                $viscode = $resrefund['visitcode'];
                                $docnum = $resrefund['docno'];
                                
                                $query2 = "select visitcode from master_transactionip where visitcode = '$viscode' and patientcode = '$patientcode1'";
                                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $num2 = mysqli_num_rows($exec2);
                                
                                if($num2 == 0) {
                                    if($viscode == '') {
                                        $list = 1;
                                    } else {
                                        $list = '';
                                    }
                                    
                                    $accdet = "select accountname,billtype from master_customer where customercode='$patientcode1' order by auto_number desc";
                                    $exeacc = mysqli_query($GLOBALS["___mysqli_ston"], $accdet) or die("Error in accdet".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $resacc = mysqli_fetch_array($exeacc);
                                    $accountname2 = $resacc['accountname'];
                                    $billtype = $resacc['billtype'];
                                    
                                    $acc = mysqli_query($GLOBALS["___mysqli_ston"], "select accountname from master_accountname where auto_number='$accountname2' group by id order by auto_number desc") or die("Error in Acc".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $resacc1 = mysqli_fetch_array($acc);
                                    $accountdetail = $resacc1['accountname'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    $rowclass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                        ?>
                        <tr class="<?php echo $rowclass; ?>">
                            <td class="modern-cell"><?php echo $colorloopcount; ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($patientcode1); ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($viscode); ?></td>
                            <td class="modern-cell"><?php echo ""; ?></td>
                            <td class="modern-cell">
                                <div class="patient-info">
                                    <strong><?php echo htmlspecialchars($patientname1); ?></strong>
                                </div>
                            </td>
                            <td class="modern-cell"><?php echo htmlspecialchars($billtype); ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($accountdetail); ?></td>
                            <td class="modern-cell">
                                <a href="depositrefunddetail.php?patientcode=<?php echo $patientcode1; ?>&visitcode=<?php echo $viscode; ?>&list=<?php echo $list; ?>&docno1=<?php echo $docnum; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-undo"></i> ADV Refund
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
                
                <?php if($cbfrmflag1 == 'cbfrmflag1') { ?>
                <div class="export-section">
                    <a href="print_patientbillingstatus.php?patient=<?php echo $searchpatient; ?>&patientcode=<?php echo $searchpatientcode; ?>&visitcode=<?php echo $searchvisitcode; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&location=<?php echo $locationcode; ?>" class="btn btn-outline">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>
                <?php } ?>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/patientbillingstatus_ref-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Date Picker Scripts -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
</body>
</html>



