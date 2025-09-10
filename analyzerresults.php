<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR']; 
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$updatedatetime = date('Y-m-d H:i:s');

$docno = $_SESSION['docno'];

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if ($location != '') {
    $locationcode = $location;
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

// Handle refund processing
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

if (isset($_REQUEST["frm1submit1"])) { 
    $frm1submit1 = $_REQUEST["frm1submit1"]; 
} else { 
    $frm1submit1 = ""; 
}

if (isset($_REQUEST["frmflag2"])) { 
    $frmflag2 = $_REQUEST["frmflag2"]; 
} else { 
    $frmflag2 = ""; 
}

if ($frmflag2 == 'frmflag2') {
    foreach($_POST['ref'] as $key => $value) {
        $itemcode = $_POST['itemcode'][$value];
        $sampleid = $_POST['sampleid'][$value];
        $visitcode = $_POST['visitcode'][$value];
        $remark = $_POST['remarks'][$value];
        $sampleop = 'OPS-'.$sampleid;
        $sampleip = 'IPS-'.$sampleid;
        
        $query29 = mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set labrefund='refund',remarks='$remark',refundrequestby='$username',refundrequestdate='$updatedatetime' where labitemcode='$itemcode' and patientvisitcode='$visitcode' and sampleid='$sampleop'") or die("error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
        $query29 = mysqli_query($GLOBALS["___mysqli_ston"], "update ipconsultation_lab set labrefund='refund',remarks='$remark',refundrequestby='$username',refundrequestdate='$updatedatetime' where labitemcode='$itemcode' and patientvisitcode='$visitcode' and sampleid='$sampleip'") or die("error in query".mysqli_error($GLOBALS["___mysqli_ston"]));

        $query29 = mysqli_query($GLOBALS["___mysqli_ston"], "update samplecollection_lab set refund='refund',remarks='$remark' where itemcode='$itemcode' and patientvisitcode='$visitcode' and sampleid='$sampleop'") or die("error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
        $query29 = mysqli_query($GLOBALS["___mysqli_ston"], "update ipsamplecollection_lab set refund='refund' where itemcode='$itemcode' and patientvisitcode='$visitcode' and sampleid='$sampleip'") or die("error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
}

if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == '1') {
    $errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2') {
    $errmsg = "Failed. Payment Entry Not Completed.";
}

// Get user location details
$query12 = " select * from login_locationdetails where username = '$username' "; 
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
$res12 = mysqli_fetch_array($exec12);
$locationname = $res12["locationname"]; 
$locationcode = $res12["locationcode"];

// Get pending lab test count
$querynw1 = "select * from pending_test_orders where publishstatus = '' group by sample_id order by auto_number desc";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_num_rows($execnw1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Results Analyzer - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/analyzerresults-modern.css?v=<?php echo time(); ?>">
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
        <span>Lab Results Analyzer</span>
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
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipamendser_pending.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>IP Service Pending</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="analyzerresults.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Results</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_lab.php" class="nav-link">
                            <i class="fas fa-microscope"></i>
                            <span>Pending Lab</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_ippharmacy.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Pending Pharmacy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_radiology.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Pending Radiology</span>
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
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2><i class="fas fa-flask"></i> Lab Results Analyzer</h2>
                    <p>View and manage laboratory test results and analyzer data</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-secondary" onclick="printPage()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button class="btn btn-primary" onclick="exportToCSV()">
                        <i class="fas fa-download"></i> Export CSV
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="search-form-icon fas fa-search"></i>
                    <h3 class="search-form-title">Search Lab Results</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="analyzerresults.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location <span style="color: #dc2626;">*</span></label>
                            <select name="location" id="location" class="form-select" onchange="ajaxlocationfunction(this.value);" required>
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    $selected = ($location != '' && $location == $locationcode) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo htmlspecialchars($locationcode); ?>" <?php echo $selected; ?>>
                                        <?php echo htmlspecialchars($locationname); ?>
                                    </option>
                                    <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" 
                                   value="<?php echo isset($_POST['patient']) ? htmlspecialchars($_POST['patient']) : ''; ?>" 
                                   class="form-input" autocomplete="off" placeholder="Enter patient name">
                        </div>
                        
                        <div class="form-group">
                            <label for="patientcode" class="form-label">Patient Code</label>
                            <input name="patientcode" type="text" id="patientcode" 
                                   value="<?php echo isset($_POST['patientcode']) ? htmlspecialchars($_POST['patientcode']) : ''; ?>" 
                                   class="form-input" autocomplete="off" placeholder="Enter patient code">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" 
                                   value="<?php echo isset($_POST['visitcode']) ? htmlspecialchars($_POST['visitcode']) : ''; ?>" 
                                   class="form-input" autocomplete="off" placeholder="Enter visit code">
                        </div>
                        
                        <div class="form-group">
                            <label for="docnumber" class="form-label">Document Number</label>
                            <input name="docnumber" type="text" id="docnumber" 
                                   value="<?php echo isset($_POST['docnumber']) ? htmlspecialchars($_POST['docnumber']) : ''; ?>" 
                                   class="form-input" autocomplete="off" placeholder="Enter document number">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From <span style="color: #dc2626;">*</span></label>
                            <input name="ADate1" id="ADate1" type="date"
                                   value="<?php echo htmlspecialchars($transactiondatefrom); ?>" 
                                   class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To <span style="color: #dc2626;">*</span></label>
                            <input name="ADate2" id="ADate2" type="date"
                                   value="<?php echo htmlspecialchars($transactiondateto); ?>" 
                                   class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1'): ?>
            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="data-table-icon fas fa-flask"></i>
                    <h3 class="data-table-title">Lab Results Data</h3>
                    <div class="table-summary">
                        <div class="summary-item">
                            <i class="fas fa-calendar"></i>
                            <span>Date Range: <?php echo htmlspecialchars($_POST['ADate1']); ?> to <?php echo htmlspecialchars($_POST['ADate2']); ?></span>
                        </div>
                        <div class="summary-item">
                            <i class="fas fa-flask"></i>
                            <span>Total Results: <strong><?php echo $resnw1; ?></strong></span>
                        </div>
                    </div>
                </div>
                
                <!-- Search Bar -->
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <input type="text" id="searchInput" class="form-input" 
                               placeholder="Search patient name, code, test name, or sample ID..." 
                               style="flex: 1; max-width: 300px;"
                               oninput="handleSearch(this.value)">
                        <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table" id="labTable" role="table" aria-label="Lab Results Data">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Refund</th>
                                <th scope="col">Sample Date</th>
                                <th scope="col">Patient Code</th>
                                <th scope="col">Visit Code</th>
                                <th scope="col">Patient Name</th>
                                <th scope="col">Test Name</th>
                                <th scope="col">Sample ID</th>
                                <th scope="col">Analyzer Status</th>
                                <th scope="col">Ordered By</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="labTableBody">
                            <?php
                            if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
                                $searchpatient = $_POST['patient'];
                                $searchpatientcode = $_POST['patientcode'];
                                $searchvisitcode = $_POST['visitcode'];
                                $fromdate = $_POST['ADate1'];
                                $todate = $_POST['ADate2'];
                                $docnumber = $_POST['docnumber'];

                                $query1 = "select * from pending_test_orders where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and date(sampledate) between '$fromdate' and '$todate' and sample_id like '%$docnumber%' and publishstatus = '' group by sample_id,testcode order by visitcode";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $num1 = mysqli_num_rows($exec1);
                                $sno = 0;
                                
                                while($res1 = mysqli_fetch_array($exec1)) {
                                    $itemname = '';
                                    $patientname = $res1['patientname'];
                                    $patientcode = $res1['patientcode'];
                                    $visitcode = $res1['visitcode'];
                                    $consultationdate = $res1['sampledate'];
                                    $docnumber = $res1['sample_id'];
                                    $testcode = $res1['testcode'];

                                    $query11 = "select * from pending_test_orders where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and date(sampledate) between '$fromdate' and '$todate' and sample_id like '%$docnumber%' and publishstatus = '' and testcode='$testcode' group by sample_id, testcode ";
                                    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $num11 = mysqli_num_rows($exec11);
                                    
                                    while($res11 = mysqli_fetch_array($exec11)) {
                                        $itemname = '';
                                        $item = $res11['testname'];
                                        if($num11 == '1') {
                                            $itemname = $item;
                                        } else {
                                            $itemname = $item.', '. $itemname;
                                        }
                                        $itemcode = $res11['testcode'];
                                    }
                                    
                                    $equipmentcode = $res11['resultdatetime'];

                                    $query23 = "select labrefund,username from consultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and labitemcode='$itemcode' and sampleid like '%$docnumber'";
                                    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res23 = mysqli_fetch_array($exec23);
                                    $num23 = mysqli_num_rows($exec23);
                                    
                                    if($num23 == 0) {
                                        $query23 = "select labrefund,username from ipconsultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and labitemcode='$itemcode' and sampleid like '%$docnumber'";
                                        $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res23 = mysqli_fetch_array($exec23);
                                    }
                                    
                                    $requestedby = $res23['username'];
                                    
                                    if($res23['labrefund'] == 'norefund') {
                                        $query24 = "select * from master_employee where username = '$requestedby'";
                                        $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res24 = mysqli_fetch_array($exec24);
                                        $requestedbyname = $res24['employeename'];
                                        
                                        $sno++;
                                        $rowClass = ($sno % 2 == 0) ? 'even-row' : 'odd-row';
                                        ?>
                                        <tr class="<?php echo $rowClass; ?>">
                                            <td>
                                                <div class="serial-number">
                                                    <?php echo $sno; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="ref[]" id="ref<?php echo $sno?>" 
                                                       value="<?php echo $sno; ?>" class="refund-checkbox" 
                                                       onclick="return comment('<?php echo $sno?>')">
                                                <input type="hidden" name="itemcode[<?=$sno;?>]" value="<?php echo $itemcode; ?>">
                                                <input type="hidden" name="sampleid[<?=$sno;?>]" value="<?php echo $docnumber; ?>">
                                                <input type="hidden" name="visitcode[<?=$sno;?>]" value="<?php echo $visitcode; ?>">
                                            </td>
                                            <td>
                                                <span class="date-badge">
                                                    <?php echo htmlspecialchars($consultationdate); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="patient-code">
                                                    <?php echo htmlspecialchars($patientcode); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="visit-code">
                                                    <?php echo htmlspecialchars($visitcode); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="patient-info">
                                                    <span class="patient-name"><?php echo htmlspecialchars($patientname); ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="test-name">
                                                    <?php echo htmlspecialchars($itemname); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="sample-id">
                                                    <?php echo htmlspecialchars($docnumber); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge <?php echo ($equipmentcode > '0000-00-00') ? 'status-completed' : 'status-pending'; ?>">
                                                    <?php echo ($equipmentcode > '0000-00-00') ? 'Completed' : 'Pending'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($requestedbyname); ?>
                                            </td>
                                            <td>
                                                <textarea name="remarks[<?=$sno;?>]" id="remarks<?php echo $sno; ?>" 
                                                          class="remarks-textarea" style="display:none" 
                                                          placeholder="Enter refund remarks..."></textarea>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="analyzerresultsview.php?patientcode=<?php echo htmlspecialchars($patientcode); ?>&visitcode=<?php echo htmlspecialchars($visitcode); ?>&docnumber=<?php echo htmlspecialchars($docnumber); ?>&itemcode=<?php echo htmlspecialchars($itemcode); ?>" 
                                                       class="action-btn view" title="View Lab Results" 
                                                       aria-label="View lab results for <?php echo htmlspecialchars($patientname); ?>">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
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

                <?php if ($sno == 0): ?>
                <div class="no-data-message">
                    <i class="fas fa-info-circle"></i>
                    <p>No lab results found for the selected criteria.</p>
                    <p>Try adjusting your search parameters or date range.</p>
                </div>
                <?php endif; ?>

                <!-- Refund Section -->
                <?php if ($sno > 0): ?>
                <div class="refund-section">
                    <form id="refundForm" name="form1" method="post" action="analyzerresults.php">
                        <input type="hidden" value="<?php echo $sno;?>" name="serialno" id="serialno"/>
                        <input type="hidden" name="frmflag2" value="frmflag2" />
                        <button type="submit" class="refund-btn" onclick="return remark();">
                            <i class="fas fa-undo"></i> Process Refund
                        </button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/analyzerresults-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

