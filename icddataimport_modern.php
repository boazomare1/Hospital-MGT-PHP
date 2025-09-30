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

// Handle file upload
if (isset($_REQUEST["frmflag1"]) && $_REQUEST["frmflag1"] == 'frmflag1') {
    $user = $profileid ?? $username;
    $date = date('ymd');
    $uploaddir = "tab_file_dump";
    $final_filename = $username . "_tabdump.txt";
    $photodate = date('y-m-d');
    $photoid = $user . $date;
    
    // Validate file upload
    if (isset($_FILES['uploadedfile']) && $_FILES['uploadedfile']['error'] === UPLOAD_ERR_OK) {
        $fileformat = basename($_FILES['uploadedfile']['name']);
        $fileformat = substr($fileformat, -3, 3);
        
        if ($fileformat == 'txt') {
            // Ensure upload directory exists
            if (!is_dir($uploaddir)) {
                mkdir($uploaddir, 0755, true);
            }
            
            $uploadfile123 = $uploaddir . "/" . $final_filename;
            $target_path = $uploadfile123;
            
            // Validate file size (max 10MB)
            if ($_FILES['uploadedfile']['size'] > 10 * 1024 * 1024) {
                $errmsg = "File size too large. Maximum allowed size is 10MB.";
                $bgcolorcode = 'error';
            } else {
                if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
                    header("location:icddataimport1.php?upload=success");
                    exit;
                } else {
                    $errmsg = "File upload failed. Please try again.";
                    $bgcolorcode = 'error';
                }
            }
        } else {
            $errmsg = "Invalid file format. Only .txt files are allowed.";
            $bgcolorcode = 'error';
        }
    } else {
        $errmsg = "No file selected or upload error occurred.";
        $bgcolorcode = 'error';
    }
}

// Handle status messages
if (isset($_REQUEST["upload"])) {
    $upload = $_REQUEST["upload"];
    if ($upload == 'success') {
        $errmsg = "File Upload Completed Successfully.";
        $bgcolorcode = 'success';
    } elseif ($upload == 'failed') {
        $errmsg = "File Upload Failed. Please ensure you are uploading a TAB delimited file.";
        $bgcolorcode = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICD Data Import - MedStar Hospital Management</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/icddataimport-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
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
        <a href="dataimport.php">📊 Data Import</a>
        <span>→</span>
        <span>ICD Data Import</span>
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
                        <a href="dataimport.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Data Import</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="icddataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>ICD Data Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="masterdata.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>Master Data</span>
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
                    <div class="alert alert-<?php echo $bgcolorcode; ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'error' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>ICD Data Import</h2>
                    <p>Import ICD (International Classification of Diseases) data from TAB delimited files.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="dataimport.php" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Back to Data Import
                    </a>
                </div>
            </div>

            <!-- Import Form Section -->
            <div class="import-section">
                <div class="import-header">
                    <i class="fas fa-database import-icon"></i>
                    <h3 class="import-title">Import ICD Data</h3>
                    <p class="import-subtitle">Upload TAB delimited file containing ICD codes and descriptions</p>
                </div>
                
                <form action="icddataimport.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return dataimport1verify()" class="import-form">
                    <input type="hidden" name="frmflag" value="addnew" />
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    
                    <!-- Instructions Section -->
                    <div class="instructions-section">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Import Instructions
                        </h4>
                        
                        <div class="instructions-grid">
                            <div class="instruction-item">
                                <div class="instruction-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="instruction-content">
                                    <h5>File Format</h5>
                                    <p>Only TAB delimited (.txt) files are accepted</p>
                                </div>
                            </div>
                            
                            <div class="instruction-item">
                                <div class="instruction-icon">
                                    <i class="fas fa-download"></i>
                                </div>
                                <div class="instruction-content">
                                    <h5>Sample File</h5>
                                    <p>Download the sample file to understand the required format</p>
                                </div>
                            </div>
                            
                            <div class="instruction-item">
                                <div class="instruction-icon">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="instruction-content">
                                    <h5>Data Preparation</h5>
                                    <p>Open sample file, populate your data, and save as TAB file</p>
                                </div>
                            </div>
                            
                            <div class="instruction-item">
                                <div class="instruction-icon">
                                    <i class="fas fa-upload"></i>
                                </div>
                                <div class="instruction-content">
                                    <h5>Upload & Import</h5>
                                    <p>Select your prepared file and click import to process</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sample File Download -->
                    <div class="sample-section">
                        <div class="sample-header">
                            <i class="fas fa-download sample-icon"></i>
                            <h4 class="sample-title">Sample File Download</h4>
                        </div>
                        
                        <div class="sample-content">
                            <p>Download the sample file to understand the required format and structure for ICD data import.</p>
                            <a href="tab_file_dump/sample_import_file1.xls" class="btn btn-outline" download>
                                <i class="fas fa-download"></i> Download Sample File
                            </a>
                        </div>
                    </div>
                    
                    <!-- File Upload Section -->
                    <div class="upload-section">
                        <div class="upload-header">
                            <i class="fas fa-upload upload-icon"></i>
                            <h4 class="upload-title">File Upload</h4>
                        </div>
                        
                        <div class="upload-content">
                            <div class="form-group">
                                <label for="uploadedfile" class="form-label required">Select TAB Delimited File</label>
                                <div class="file-upload-container">
                                    <input name="uploadedfile" id="uploadedfile" type="file" 
                                           accept=".txt" class="file-input" />
                                    <div class="file-upload-display">
                                        <div class="file-upload-icon">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </div>
                                        <div class="file-upload-text">
                                            <span class="file-upload-title">Choose file or drag and drop</span>
                                            <span class="file-upload-subtitle">TAB delimited .txt files only (Max 10MB)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="file-info" id="fileInfo" style="display: none;">
                                    <i class="fas fa-file"></i>
                                    <span class="file-name"></span>
                                    <span class="file-size"></span>
                                </div>
                            </div>
                            
                            <!-- Upload Progress -->
                            <div class="upload-progress" id="uploadProgress" style="display: none;">
                                <div class="progress-bar">
                                    <div class="progress-fill"></div>
                                </div>
                                <div class="progress-text">Uploading...</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-upload"></i> Proceed to Data Import
                        </button>
                        <button type="reset" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset Form
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Help Section -->
            <div class="help-section">
                <div class="help-header">
                    <i class="fas fa-question-circle help-icon"></i>
                    <h4 class="help-title">Need Help?</h4>
                </div>
                
                <div class="help-content">
                    <div class="help-item">
                        <h5>File Format Requirements</h5>
                        <ul>
                            <li>File must be in TAB delimited format (.txt extension)</li>
                            <li>Maximum file size: 10MB</li>
                            <li>First row should contain column headers</li>
                            <li>Use the sample file as a template</li>
                        </ul>
                    </div>
                    
                    <div class="help-item">
                        <h5>Common Issues</h5>
                        <ul>
                            <li>Ensure file is saved as .txt format, not .xls or .xlsx</li>
                            <li>Check that columns are separated by TAB characters</li>
                            <li>Verify that all required fields are present</li>
                            <li>Remove any special characters that might cause issues</li>
                        </ul>
                    </div>
                    
                    <div class="help-item">
                        <h5>Support</h5>
                        <p>If you encounter any issues during the import process, please contact the system administrator or refer to the user manual.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/icddataimport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

