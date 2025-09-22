<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');  
$transactiondateto = date('Y-m-d');

$errmsg = "";
$searchsuppliername = "";
$cbsuppliername = "";
$res21itemname = '';
$res21itemcode = '';
$docnumber1 = '';
$testcount = '';
$docnum = isset($_REQUEST['docnumber']) ? $_REQUEST['docnumber'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Audit - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/lab-audit-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Legacy JavaScript -->
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
        <span>Lab Audit</span>
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
                        <a href="lab_result.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Results</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="lab_audit.php" class="nav-link">
                            <i class="fas fa-search"></i>
                            <span>Lab Audit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="lab_master.php" class="nav-link">
                            <i class="fas fa-vial"></i>
                            <span>Lab Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="lab_test.php" class="nav-link">
                            <i class="fas fa-microscope"></i>
                            <span>Lab Tests</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="lab_report.php" class="nav-link">
                            <i class="fas fa-file-medical"></i>
                            <span>Lab Reports</span>
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
                    <h2>Lab Audit</h2>
                    <p>View and track edited lab results with comprehensive audit trail.</p>
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
                    <h3 class="search-form-title">View Edited Lab Results</h3>
                </div>
                
                <form name="cbform1" id="searchForm" method="post" action="lab_audit.php" class="search-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" class="form-input" 
                                   value="<?php echo htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : ''); ?>" 
                                   placeholder="Enter patient name">
                        </div>
                        
                        <div class="form-group">
                            <label for="patientcode" class="form-label">Patient Code</label>
                            <input name="patientcode" type="text" id="patientcode" class="form-input" 
                                   value="<?php echo htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : ''); ?>" 
                                   placeholder="Enter patient code">
                        </div>
                        
                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" class="form-input" 
                                   value="<?php echo htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : ''); ?>" 
                                   placeholder="Enter visit code">
                        </div>
                        
                        <div class="form-group">
                            <label for="docnumber" class="form-label">Doc Number</label>
                            <input name="docnumber" type="text" id="docnumber" class="form-input" 
                                   value="<?php echo htmlspecialchars(isset($_POST['docnumber']) ? $_POST['docnumber'] : ''); ?>" 
                                   placeholder="Enter document number">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" class="form-input" 
                                       value="<?php echo $transactiondatefrom; ?>" 
                                       readonly onKeyDown="return disableEnterKey()">
                                <button type="button" class="date-picker-icon" onclick="javascript:NewCssCal('ADate1')">
                                    <i class="fas fa-calendar-alt"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" class="form-input" 
                                       value="<?php echo $transactiondateto; ?>" 
                                       readonly onKeyDown="return disableEnterKey()">
                                <button type="button" class="date-picker-icon" onclick="javascript:NewCssCal('ADate2')">
                                    <i class="fas fa-calendar-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" id="resetBtn" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Results Section -->
            <?php if (isset($_REQUEST["cbfrmflag1"])): ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-clipboard-list data-table-icon"></i>
                    <h3 class="data-table-title">Lab Audit Results</h3>
                </div>
                
                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Action</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Reg No</th>
                                <th class="text-center">Visit No</th>
                                <th class="text-center">Patient</th>
                                <th class="text-center">Doc No</th>
                                <th>Sample ID</th>
                                <th>Test</th>
                                <th>Sample By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $colorloopcount = 0;
                            $sno = 0;
                            
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
                            
                            if ($searchvisitcode == '') {   
                                $query1 = "select * from audit_resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and recorddate between '$fromdate' and '$todate' and docnumber like '%$docnumber%' group by docnumber,itemcode,patientvisitcode order by datetime desc";
                            } else {
                                $query1 = "select * from audit_resultentry_lab where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and docnumber like '%$docnumber%' group by docnumber,itemcode,patientvisitcode order by datetime desc";
                            }
                            
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $num1 = mysqli_num_rows($exec1);
                            
                            if ($num1 > 0) {
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $itemname = '';
                                    $patientname = $res1['patientname'];
                                    $patientcode = $res1['patientcode'];
                                    $res1billnumber = ''; // $res1['billnumber'];
                                    $visitcode = $res1['patientvisitcode'];
                                    $consultationdate = $res1['recorddate'];
                                    $docnumber1 = $res1['docnumber'];
                                    $itemcode = $res1['itemcode'];
                                    $requestedbyname = $res1['username'];
                                    $itemname = $res1['itemname'];
                                    $sampleid = $res1['sampleid'];
                                    
                                    $query_checkdup = "SELECT * from audit_resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode LIKE '$itemcode' and docnumber='$docnumber1' group by audit_id,itemcode,recorddate order by itemcode,recorddate DESC";
                                    $exec_checkdup = mysqli_query($GLOBALS["___mysqli_ston"], $query_checkdup) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $num_checkdup = mysqli_num_rows($exec_checkdup);
                                    
                                    if ($num_checkdup == 1) {
                                        continue;
                                    }
                                    
                                    if ($num1 != 0) {
                                        $colorloopcount = $colorloopcount + 1;
                                        $showcolor = ($colorloopcount & 1); 
                                        if ($showcolor == 0) {
                                            $colorcode = 'bgcolor="#CBDBFA"';
                                        } else {
                                            $colorcode = 'bgcolor="#ecf0f5"';
                                        }
                                        ?>
                                        <tr <?php echo $colorcode; ?>>
                                            <td class="text-center"><?php echo $sno = $sno + 1; ?></td>
                                            <td class="text-center">
                                                <a href="lab_audit_view.php?patientcode=<?php echo urlencode($patientcode); ?>&visitcode=<?php echo urlencode($visitcode); ?>&fromdate=<?php echo urlencode($fromdate); ?>&todate=<?php echo urlencode($todate); ?>&docnumber=<?php echo urlencode($docnumber1); ?>" 
                                                   target="_blank" class="action-btn view" title="View Audit Details">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                            <td class="text-center"><?php echo date('d/m/Y', strtotime($consultationdate)); ?></td>
                                            <td class="text-center">
                                                <span class="patient-code"><?php echo htmlspecialchars($patientcode); ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="visit-code"><?php echo htmlspecialchars($visitcode); ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="patient-name"><?php echo htmlspecialchars($patientname); ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="doc-number"><?php echo htmlspecialchars($docnumber1); ?></span>
                                            </td>
                                            <td>
                                                <span class="sample-id"><?php echo htmlspecialchars($sampleid); ?></span>
                                            </td>
                                            <td>
                                                <span class="test-name"><?php echo htmlspecialchars($itemname); ?></span>
                                            </td>
                                            <td>
                                                <span class="sample-by"><?php echo htmlspecialchars($requestedbyname); ?></span>
                                            </td>
                                            <input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo htmlspecialchars($visitcode); ?>">
                                            <input type="hidden" name="docnumber[]" value="<?php echo htmlspecialchars($docnumber1); ?>"> 
                                        </tr>
                                        <?php
                                    }
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="10" class="text-center" style="padding: var(--spacing-xl); color: var(--gray);">
                                        <i class="fas fa-search" style="font-size: 2rem; margin-bottom: var(--spacing-md);"></i>
                                        <br>No lab audit records found for the specified criteria.
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/lab-audit-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
