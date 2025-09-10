<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$updatedate= date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = '';
$bgcolorcode = '';
$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname1  = $res["locationname"];
$locationcode123 = $res["locationcode"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

if (isset($_REQUEST["frmflag1"])) { 
    $frmflag1 = $_REQUEST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

// Excel upload processing
if ($frmflag1 == 'frmflag1') {
    $query31 = "SELECT * from master_location where locationcode = '$locationcode' and status = '' ";
    $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res31 = mysqli_fetch_array($exec31);
    $locationname = $res31["locationname"];

    if(!empty($_FILES['upload_file'])) {
        $inputFileName = $_FILES['upload_file']['tmp_name'];
        
        include 'phpexcel/Classes/PHPExcel/IOFactory.php';
        
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $row = 1;
            
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE)[0];
            
            foreach($rowData as $key=>$value) { 
                if($rowData[$key] == 'main subid') $subid1 = $key;
                if($rowData[$key] == 'new id') $new_id1 = $key;
                if($rowData[$key] == 'coa name') $coa_name1 = $key;
            }		

            for ($row = 2; $row <= $highestRow; $row++) { 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE)[0];
                
                $subid = $rowData[$subid1];
                $new_id = $rowData[$new_id1];
                $coa_name = $rowData[$coa_name1];
                 
                if($coa_name != "") {
                    $coa_name = trim($coa_name);
                    $coa_name = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $coa_name);
                    $coa_name = ucwords(strtolower($coa_name));

                    $query_subid = "SELECT * from master_accountssub where id = '$subid'";
                    $exec_subid = mysqli_query($GLOBALS["___mysqli_ston"], $query_subid) or die ("Error in Query_subid".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res_subid = mysqli_fetch_array($exec_subid);
                    $sub_auto_no = $res_subid["auto_number"];
                    $main_type_id = $res_subid["accountsmain"];

                    $query1 = "INSERT INTO `master_accountname`( `accountname`, `id`, `legacy_code`, `paymenttype`, `subtype`, `accountsmain`, `accountssub`, `openingbalancecredit`, `openingbalancedebit`, `currency`, `fxrate`, `recordstatus`, `expirydate`, `locationname`, `locationcode`, `ipaddress`, `recorddate`, `contact`, `username`, `misreport`, `iscapitation`,`is_receivable`,`phone`) 
                                VALUES ('$coa_name','$new_id','','','','$main_type_id','$sub_auto_no','','','KSH','1','ACTIVE','2025-12-31','$locationname','$locationcode','$ipaddress','$updatedatetime','','$username','','','','')";
 
                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
            
            $errmsg = "Data imported successfully!";
            $bgcolorcode = "success";
            
        } catch(Exception $e) {
            $errmsg = "File is Empty!.. Please retry Again";
            $bgcolorcode = "failed";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart of Accounts Upload - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/chartofaccounts-upload-modern.css?v=<?php echo time(); ?>">
    
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
            <span class="location-info">📍 Location: <?php echo htmlspecialchars($locationname1); ?></span>
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
        <span>Chart of Accounts Upload</span>
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
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="openingstockentry_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Opening Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="corporateoutstanding.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Corporate Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_acquisition_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Acquisition</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="chartofaccounts_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Chart of Accounts Upload</span>
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
                    <h2>Chart of Accounts Upload</h2>
                    <p>Import Chart of Accounts data from Excel files to streamline account management.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Reset Form
                    </button>
                </div>
            </div>

            <!-- Sample File Section -->
            <div class="sample-file-section">
                <div class="sample-file-header">
                    <i class="fas fa-download sample-file-icon"></i>
                    <h3 class="sample-file-title">Download Sample File</h3>
                </div>
                <p class="sample-file-description">
                    Download the sample Excel file to understand the required format for uploading Chart of Accounts data.
                </p>
                <a href="sample_excels/master_chartofAccounts.xls" class="sample-file-link" onclick="downloadSampleFile()">
                    <i class="fas fa-file-excel"></i>
                    Download Sample File
                </a>
            </div>

            <!-- Upload Section -->
            <div class="upload-section">
                <div class="upload-section-header">
                    <i class="fas fa-upload upload-section-icon"></i>
                    <h3 class="upload-section-title">Upload Chart of Accounts</h3>
                </div>
                
                <form id="uploadForm" method="post" enctype="multipart/form-data" class="upload-form">
                    <div class="form-group">
                        <label for="upload_file" class="form-label">Select Excel File</label>
                        <div class="file-input-wrapper">
                            <div class="file-input" onclick="document.getElementById('upload_file').click()">
                                Drag and drop Excel file here or click to browse
                            </div>
                            <button type="button" class="browse-btn" onclick="document.getElementById('upload_file').click()">
                                <i class="fas fa-folder-open"></i> Browse
                            </button>
                        </div>
                        <input type="file" id="upload_file" name="upload_file" accept=".xls,.xlsx,.csv" style="display: none;">
                    </div>

                    <!-- File Display -->
                    <div id="fileDisplay" style="display: none;"></div>

                    <div class="form-group">
                        <button type="button" id="uploadBtn" class="upload-btn" disabled>
                            <i class="fas fa-cloud-upload-alt"></i>
                            Upload Chart of Accounts
                        </button>
                    </div>

                    <input type="hidden" name="frmflag1" value="frmflag1">
                </form>
            </div>

            <!-- Progress Section -->
            <div id="progressSection" class="progress-section">
                <div class="progress-header">
                    <i class="fas fa-spinner fa-spin progress-icon"></i>
                    <h3 class="progress-title">Upload Progress</h3>
                </div>
                <div class="progress-bar">
                    <div id="progressFill" class="progress-fill"></div>
                </div>
                <div id="progressText" class="progress-text">Ready to upload</div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/chartofaccounts-upload-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



