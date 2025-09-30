<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

ini_set('memory_limit','-1');
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];
$errmsg = '';
$bgcolorcode = '';

$query = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];

function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
    return $line_of_text;
}

if(isset($_POST['submit'])){
    $uploaddir = 'uploads/';
    $uploadfile = $uploaddir . basename($_FILES['csvfile']['name']);
    
    if (move_uploaded_file($_FILES['csvfile']['tmp_name'], $uploadfile)) {
        $csvData = readCSV($uploadfile);
        
        $successCount = 0;
        $errorCount = 0;
        
        foreach($csvData as $row) {
            if(count($row) >= 3) {
                $packagename = $row[0];
                $packagecode = $row[1];
                $packageamount = $row[2];
                
                if(!empty($packagename) && !empty($packagecode)) {
                    $query = "INSERT INTO master_package (packagename, packagecode, packageamount, status, username, ipaddress, updatedatetime, companyanum, companyname) VALUES ('$packagename', '$packagecode', '$packageamount', '', '$username', '$ipaddress', '$updatedatetime', '$companyanum', '$companyname')";
                    
                    if(mysqli_query($GLOBALS["___mysqli_ston"], $query)) {
                        $successCount++;
                    } else {
                        $errorCount++;
                    }
                }
            }
        }
        
        $errmsg = "Upload completed! Success: $successCount, Errors: $errorCount";
        unlink($uploadfile);
    } else {
        $errmsg = "Upload failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Upload - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ippackage_upload-modern.css?v=<?php echo time(); ?>">
    
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
            <span class="location-info">📍 Location: <?php echo htmlspecialchars($locationname); ?></span>
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
        <span>Package Upload</span>
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
                        <a href="ipvisitentry_new.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>IP Visit Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipcreditaccountreport.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Credit Account Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="iplabresultsviewlist.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Results View</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipmedicineissuelist.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Medicine Issue List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlistmedicine.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ippackageanalysis.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Package Analysis</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addippackage.php" class="nav-link">
                            <i class="fas fa-plus"></i>
                            <span>Add IP Package</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ippackagereport.php" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>Package Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="packageitems.php" class="nav-link">
                            <i class="fas fa-box"></i>
                            <span>Package Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ippackage_upload.php" class="nav-link active">
                            <i class="fas fa-upload"></i>
                            <span>Package Upload</span>
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
                    <h2><i class="fas fa-upload"></i> Package Upload</h2>
                    <p>Upload CSV files to import package data</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-primary" onclick="downloadTemplate()">
                        <i class="fas fa-download"></i> Download Template
                    </button>
                    <button class="btn btn-primary" onclick="exportResults()">
                        <i class="fas fa-file-export"></i> Export Results
                    </button>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="form-container">
                <form method="post" enctype="multipart/form-data" class="upload-form">
                    <div class="form-header">
                        <h3><i class="fas fa-file-upload"></i> Upload CSV File</h3>
                    </div>
                    
                    <!-- Upload Area -->
                    <div class="upload-area" id="uploadArea">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="upload-text">Drag & Drop CSV files here</div>
                        <div class="upload-subtext">or click to browse files</div>
                        <input type="file" id="fileInput" name="csvfile" accept=".csv" style="display: none;" required>
                    </div>
                    
                    <!-- File List -->
                    <div class="file-list" id="fileList" style="display: none;">
                        <h3><i class="fas fa-list"></i> Selected Files</h3>
                        <div id="fileItems"></div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="progress-container" id="progressContainer" style="display: none;">
                        <div class="progress-bar">
                            <div class="progress-fill"></div>
                        </div>
                        <div class="progress-text">Ready to upload</div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success" id="uploadBtn" disabled>
                            <i class="fas fa-upload"></i> Upload Files
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearUpload()">
                            <i class="fas fa-trash"></i> Clear
                        </button>
                    </div>
                </form>
            </div>

            <!-- Instructions -->
            <div class="form-container">
                <div class="form-header">
                    <h3><i class="fas fa-info-circle"></i> Upload Instructions</h3>
                </div>
                
                <div class="instructions-content">
                    <h4>CSV Format Requirements:</h4>
                    <ul>
                        <li><strong>Column 1:</strong> Package Name (required)</li>
                        <li><strong>Column 2:</strong> Package Code (required)</li>
                        <li><strong>Column 3:</strong> Package Amount (optional)</li>
                    </ul>
                    
                    <h4>File Requirements:</h4>
                    <ul>
                        <li>File format: CSV (.csv)</li>
                        <li>Maximum file size: 10MB</li>
                        <li>Encoding: UTF-8 recommended</li>
                        <li>First row should contain headers</li>
                    </ul>
                    
                    <h4>Tips:</h4>
                    <ul>
                        <li>Use the template file for correct format</li>
                        <li>Ensure package codes are unique</li>
                        <li>Check for special characters in package names</li>
                        <li>Verify package amounts are numeric</li>
                    </ul>
                </div>
            </div>

        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ippackage_upload-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
