<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = '';
$bgcolorcode = '';

if (isset($_REQUEST["frmflag1"])) { 
    $frmflag1 = $_REQUEST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

// File upload processing
if ($frmflag1 == 'frmflag1') {
    $user = $profileid;
    $date = date('ymd');
    $uploaddir = "tab_file_dump";
    $final_filename = $username . "_tabdump.txt";
    $photodate = date('y-m-d');
    $photoid = $user . $date;
    
    $fileformat = basename($_FILES['uploadedfile']['name']);
    $fileformat = substr($fileformat, -3, 3);
    
    if ($fileformat == 'txt') {
        $uploadfile123 = $uploaddir . "/" . $final_filename;
        $target_path = $uploadfile123;
        
        if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
            header("location:chartaccountssubdataimport1.php?upload=success");
            exit;
        } else {
            header("location:chartaccountssubdataimport.php?upload=failed");
            exit;
        }
    } else {
        header("location:chartaccountssubdataimport.php?upload=failed");
        exit;
    }
}

if (isset($_REQUEST["upload"])) { 
    $upload = $_REQUEST["upload"]; 
} else { 
    $upload = ""; 
}

if ($upload == 'success') {
    $errmsg = "File Upload Completed.";
    $bgcolorcode = 'success';
}

if ($upload == 'failed') {
    $errmsg = "File Upload Failed. Make Sure You Are Uploading TAB Delimited File.";
    $bgcolorcode = 'failed';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart of Accounts Sub Data Import - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/chartaccountssub-import-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Chart of Accounts Sub Data Import</span>
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
                    <li class="nav-item">
                        <a href="chartofaccounts_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Chart of Accounts Upload</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountsmaindataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Main Import</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="chartaccountssubdataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Sub Import</span>
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
                    <h2>Chart of Accounts Sub Data Import</h2>
                    <p>Import Chart of Accounts Sub data from TAB delimited files to streamline account sub-type management.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Reset Form
                    </button>
                </div>
            </div>

            <!-- Instructions Section -->
            <div class="instructions-section">
                <div class="instructions-header">
                    <i class="fas fa-info-circle instructions-icon"></i>
                    <h3 class="instructions-title">Import Instructions</h3>
                </div>
                <ul class="instructions-list">
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Only TAB delimited files (.txt) are accepted</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Download the sample file and populate it with your data</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Save the file as a TAB delimited text file</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Upload the file here to import your data</span>
                    </li>
                </ul>
            </div>

            <!-- Sample File Section -->
            <div class="sample-file-section">
                <div class="sample-file-header">
                    <i class="fas fa-download sample-file-icon"></i>
                    <h3 class="sample-file-title">Download Sample File</h3>
                </div>
                <p class="sample-file-description">
                    Download the sample Excel file to understand the required format for importing Chart of Accounts Sub data.
                </p>
                <a href="tab_file_dump/chartofaccountssub.xlsx" class="sample-file-link" onclick="downloadSampleFile()">
                    <i class="fas fa-file-excel"></i>
                    Download Sample File
                </a>
            </div>

            <!-- Import Section -->
            <div class="import-section">
                <div class="import-section-header">
                    <i class="fas fa-database import-section-icon"></i>
                    <h3 class="import-section-title">Import Chart of Accounts Sub Data</h3>
                </div>
                
                <form id="importForm" action="chartaccountssubdataimport.php" method="post" enctype="multipart/form-data" class="import-form">
                    <div class="form-group">
                        <label for="uploadedfile" class="form-label">Select TAB Delimited File</label>
                        <div class="file-input-wrapper">
                            <div class="file-input" onclick="document.getElementById('uploadedfile').click()">
                                Drag and drop TAB delimited file here or click to browse
                            </div>
                            <button type="button" class="browse-btn" onclick="document.getElementById('uploadedfile').click()">
                                <i class="fas fa-folder-open"></i> Browse
                            </button>
                        </div>
                        <input type="file" id="uploadedfile" name="uploadedfile" accept=".txt,.tab" style="display: none;">
                    </div>

                    <!-- File Display -->
                    <div id="fileDisplay" style="display: none;"></div>

                    <div class="form-group">
                        <button type="button" id="importBtn" class="import-btn" disabled>
                            <i class="fas fa-database"></i>
                            Import Data
                        </button>
                    </div>

                    <input type="hidden" name="frmflag1" value="frmflag1">
                </form>
            </div>

            <!-- Progress Section -->
            <div id="progressSection" class="progress-section">
                <div class="progress-header">
                    <i class="fas fa-spinner fa-spin progress-icon"></i>
                    <h3 class="progress-title">Import Progress</h3>
                </div>
                <div class="progress-bar">
                    <div id="progressFill" class="progress-fill"></div>
                </div>
                <div id="progressText" class="progress-text">Ready to import</div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/chartaccountssub-import-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



