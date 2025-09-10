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

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    $user = $profileid;
    $date = date('ymd');
    $uploaddir = "tab_file_dump";
    $final_filename = $username."_tabdump.txt";
    $photodate = date('y-m-d');
    $photoid = $user.$date;
    
    $fileformat = basename($_FILES['uploadedfile']['name']);
    $fileformat = substr($fileformat, -3, 3);
    
    if ($fileformat == 'txt') {
        $uploadfile123 = $uploaddir . "/" . $final_filename;
        $target_path = $uploadfile123;
        
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
            header("location:addstockopeningentry1.php?upload=success");
            exit();
        } else {
            header("location:addstockopeningentry.php?upload=failed");
            exit();
        }
    } else {
        header("location:addstockopeningentry.php?upload=failed");
        exit();
    }
}

if (isset($_REQUEST["upload"])) { $upload = $_REQUEST["upload"]; } else { $upload = ""; }

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
    <title>Stock Opening Entry - MedStar Hospital</title>
    <link rel="stylesheet" href="css/addstockopeningentry-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="js/jquery-1.11.1.min.js"></script>
</head>
<body>
    <!-- Alert Container -->
    <div id="alertContainer">
        <?php if ($errmsg): ?>
            <div class="alert alert-<?php echo $bgcolorcode == 'success' ? 'success' : ($bgcolorcode == 'failed' ? 'error' : 'info'); ?>">
                <i class="fas fa-<?php echo $bgcolorcode == 'success' ? 'check-circle' : ($bgcolorcode == 'failed' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                <span><?php echo htmlspecialchars($errmsg); ?></span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">MedStar Hospital</h1>
        <p class="hospital-subtitle">Healthcare Management System</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <?php echo htmlspecialchars($username); ?></span>
            <span class="location-info"><?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="logout.php" class="btn btn-outline">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">Home</a>
        <span>/</span>
        <span>Stock Opening Entry</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <button class="floating-menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside class="left-sidebar">
            <div class="sidebar-header">
                <h3>Navigation</h3>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <!-- PHP include for menu1.php content -->
                <?php include ("includes/menu1.php"); ?>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Stock Opening Entry</h2>
                    <p>Import opening stock data from TAB delimited files</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-outline" onclick="downloadSampleFile()">
                        <i class="fas fa-download"></i> Download Sample
                    </button>
                </div>
            </div>

            <!-- Instructions Section -->
            <div class="instructions-section">
                <div class="instructions-header">
                    <i class="fas fa-info-circle instructions-icon"></i>
                    <h3 class="instructions-title">Important Instructions</h3>
                </div>
                <ul class="instructions-list">
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Only TAB delimited files (.txt) are accepted</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Please do not try to import any other file format</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Download the sample file, populate data, save as TAB file, then import here</span>
                    </li>
                    <li>
                        <i class="fas fa-download"></i>
                        <span><a href="tab_file_dump/openingstockentry.xlsx" class="download-link" target="_blank">Download Sample File</a></span>
                    </li>
                </ul>
            </div>

            <!-- Upload Form Section -->
            <div class="upload-form-section">
                <div class="upload-form-header">
                    <i class="fas fa-upload upload-form-icon"></i>
                    <h3 class="upload-form-title">Upload TAB Delimited File</h3>
                </div>

                <form action="addstockopeningentry.php" method="post" enctype="multipart/form-data" name="form1" id="form1" class="upload-form">
                    <div class="form-group">
                        <label class="form-label">Select File to Upload</label>
                        <div class="file-upload-area" id="fileUploadArea">
                            <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                            <div class="file-upload-text">
                                <strong>Click to select file</strong> or drag and drop here<br>
                                <small>Only .txt files are accepted</small>
                            </div>
                            <button type="button" class="file-upload-button">Choose File</button>
                            <input type="file" name="uploadedfile" id="uploadedfile" class="file-upload-input" accept=".txt" />
                        </div>
                        
                        <!-- Selected File Info -->
                        <div class="selected-file" id="selectedFile">
                            <!-- File info will be displayed here -->
                        </div>
                        
                        <!-- Upload Progress -->
                        <div class="upload-progress" id="uploadProgress">
                            <div class="progress-bar">
                                <div class="progress-fill"></div>
                            </div>
                            <div class="progress-text">Ready to upload</div>
                        </div>
                    </div>

                    <input type="hidden" name="frmflag" value="addnew" />
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    
                    <button type="submit" class="submit-btn" disabled>
                        <i class="fas fa-upload"></i> Proceed to Data Import
                    </button>
                </form>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/addstockopeningentry-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



