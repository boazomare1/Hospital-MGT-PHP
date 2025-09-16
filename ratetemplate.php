<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";

// Handle form submission
if (isset($_POST["frm1submit1"])) { 
    $frm1submit1 = $_POST["frm1submit1"]; 
} else { 
    $frm1submit1 = ""; 
}

if ($frm1submit1 == 'frm1submit1') {
    // Process template creation
    $templatesCreated = [];
    $errors = [];
    
    // Lab template
    if (isset($_REQUEST['labcheck']) && !empty($_REQUEST['labname'])) {
        $labname = 'lab_' . $_REQUEST['labname'];
        if (createTemplate($labname, 'master_lab', 'lab', $errors)) {
            $templatesCreated[] = 'Lab Template';
        }
    }
    
    // Radiology template
    if (isset($_REQUEST['radcheck']) && !empty($_REQUEST['radname'])) {
        $radname = 'radiology_' . $_REQUEST['radname'];
        if (createTemplate($radname, 'master_radiology', 'radiology', $errors)) {
            $templatesCreated[] = 'Radiology Template';
        }
    }
    
    // Services template
    if (isset($_REQUEST['sercheck']) && !empty($_REQUEST['sername'])) {
        $sername = 'services_' . $_REQUEST['sername'];
        if (createTemplate($sername, 'master_services', 'services', $errors)) {
            $templatesCreated[] = 'Services Template';
        }
    }
    
    // IP Package template
    if (isset($_REQUEST['ipcheck']) && !empty($_REQUEST['ipname'])) {
        $ipname = 'package_' . $_REQUEST['ipname'];
        if (createTemplate($ipname, 'master_ippackage', 'ippackage', $errors)) {
            $templatesCreated[] = 'IP Package Template';
        }
    }
    
    // Bed template
    if (isset($_REQUEST['bedcheck']) && !empty($_REQUEST['bed'])) {
        $bedname = 'bed_' . $_REQUEST['bed'];
        if (createTemplate($bedname, 'master_bed', 'bedcharge', $errors)) {
            $templatesCreated[] = 'Bed Charges Template';
        }
    }
    
    if (!empty($templatesCreated)) {
        $errmsg = "Success. Templates created: " . implode(', ', $templatesCreated);
        $bgcolorcode = 'success';
    } else {
        $errmsg = "Failed. No templates were created. " . implode(' ', $errors);
        $bgcolorcode = 'failed';
    }
}

// Handle status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'success') {
    $errmsg = "Success. New Template Updated.";
    $bgcolorcode = 'success';
} else if ($st == 'failed') {
    $errmsg = "Failed. Employee Already Exists.";
    $bgcolorcode = 'failed';
}

// Function to create template
function createTemplate($templateName, $masterTable, $templateType, &$errors) {
    global $GLOBALS, $ipaddress, $username, $updatedatetime, $companyanum, $companyname;
    
    try {
        // Create table
        $query1 = "CREATE TABLE $templateName LIKE $masterTable";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
        if (!$exec1) {
            $errors[] = "Failed to create table $templateName";
		return false;
        }
        
        // Copy data
        $query2 = "INSERT INTO $templateName SELECT * FROM $masterTable";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2);
        if (!$exec2) {
            $errors[] = "Failed to copy data to $templateName";
        return false;
        }
        
        // Create audit triggers
        createAuditTriggers($templateName, $masterTable);
        
        // Record in master_testtemplate
        $query3 = "INSERT INTO master_testtemplate (templatename, testname, ipaddress, username, recorddatetime, companyanum, companyname) VALUES ('$templateName', '$templateType', '$ipaddress', '$username', '$updatedatetime', '$companyanum', '$companyname')";
        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3);
        
        return true;
    } catch (Exception $e) {
        $errors[] = "Error creating $templateName: " . $e->getMessage();
        return false;
    }
}

// Function to create audit triggers
function createAuditTriggers($tableName, $masterTable) {
    global $GLOBALS;
    
    // This is a simplified version - you may need to customize based on your audit requirements
    $auditTable = 'audit_' . $masterTable;
    
    $triggerQuery = "CREATE TRIGGER `audit_$tableName` AFTER INSERT ON `$tableName` FOR EACH ROW BEGIN 
        INSERT INTO `$auditTable` SELECT *, 'i', '$tableName' FROM `$tableName` WHERE auto_number = NEW.auto_number; 
    END";
    
    mysqli_query($GLOBALS["___mysqli_ston"], $triggerQuery);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Template Management - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ratetemplate-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Rate Template Management</span>
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
                        <a href="radiologyitem1master.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Radiology Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="servicesitem1master.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>Services Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ippackage1master.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>IP Packages</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedcharges1master.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Bed Charges</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="ratetemplate.php" class="nav-link">
                            <i class="fas fa-copy"></i>
                            <span>Rate Templates</span>
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
                    <h2>Rate Template Management</h2>
                    <p>Create and manage rate templates for different service categories in your healthcare system.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportTemplates()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Template Creation Form Section -->
            <div class="template-form-section">
                <div class="template-form-header">
                    <i class="fas fa-plus-circle template-form-icon"></i>
                    <h3 class="template-form-title">Create New Rate Templates</h3>
                </div>
                
                <form id="templateForm" name="form1" method="post" action="ratetemplate.php" class="template-form">
                    <div class="template-grid">
                        <!-- Lab Template -->
                        <div class="template-item" data-type="lab">
                            <div class="template-checkbox">
                                <input type="checkbox" name="labcheck" id="labcheck" onchange="enableTemplateInput(this, 'labname')">
                                <span class="checkmark"></span>
                            </div>
                            <div class="template-info">
                                <div class="template-title">
                                    <i class="fas fa-flask"></i>
                                    Lab Template
                                </div>
                                <div class="template-description">Create a template for laboratory services and tests</div>
                            </div>
                            <input type="text" name="labname" id="labname" class="template-name-input" 
                                   placeholder="Enter template name" disabled>
                        </div>

                        <!-- Radiology Template -->
                        <div class="template-item" data-type="radiology">
                            <div class="template-checkbox">
                                <input type="checkbox" name="radcheck" id="radcheck" onchange="enableTemplateInput(this, 'radname')">
                                <span class="checkmark"></span>
                            </div>
                            <div class="template-info">
                                <div class="template-title">
                                    <i class="fas fa-x-ray"></i>
                                    Radiology Template
                                </div>
                                <div class="template-description">Create a template for radiology services and imaging</div>
                            </div>
                            <input type="text" name="radname" id="radname" class="template-name-input" 
                                   placeholder="Enter template name" disabled>
                        </div>

                        <!-- Services Template -->
                        <div class="template-item" data-type="services">
                            <div class="template-checkbox">
                                <input type="checkbox" name="sercheck" id="sercheck" onchange="enableTemplateInput(this, 'sername')">
                                <span class="checkmark"></span>
                            </div>
                            <div class="template-info">
                                <div class="template-title">
                                    <i class="fas fa-stethoscope"></i>
                                    Services Template
                                </div>
                                <div class="template-description">Create a template for general medical services</div>
                            </div>
                            <input type="text" name="sername" id="sername" class="template-name-input" 
                                   placeholder="Enter template name" disabled>
                        </div>

                        <!-- IP Package Template -->
                        <div class="template-item" data-type="ippackage">
                            <div class="template-checkbox">
                                <input type="checkbox" name="ipcheck" id="ipcheck" onchange="enableTemplateInput(this, 'ipname')">
                                <span class="checkmark"></span>
                            </div>
                            <div class="template-info">
                                <div class="template-title">
                                    <i class="fas fa-bed"></i>
                                    IP Package Template
                                </div>
                                <div class="template-description">Create a template for inpatient packages</div>
                            </div>
                            <input type="text" name="ipname" id="ipname" class="template-name-input" 
                                   placeholder="Enter template name" disabled>
                        </div>

                        <!-- Bed Charges Template -->
                        <div class="template-item" data-type="bedcharge">
                            <div class="template-checkbox">
                                <input type="checkbox" name="bedcheck" id="bedcheck" onchange="enableTemplateInput(this, 'bed')">
                                <span class="checkmark"></span>
                            </div>
                            <div class="template-info">
                                <div class="template-title">
                                    <i class="fas fa-bed"></i>
                                    Bed Charges Template
                                </div>
                                <div class="template-description">Create a template for bed charges and room rates</div>
                            </div>
                            <input type="text" name="bed" id="bed" class="template-name-input" 
                                   placeholder="Enter template name" disabled>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" id="submitBtn" class="submit-btn">
                            <i class="fas fa-save"></i>
                            Create Templates
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="frm1submit1" value="frm1submit1">
                </form>
            </div>

            <!-- Existing Templates Section -->
            <div class="existing-templates-section">
                <div class="existing-templates-header">
                    <i class="fas fa-list existing-templates-icon"></i>
                    <h3 class="existing-templates-title">Existing Templates</h3>
                </div>

                <!-- Search Bar -->
                <div class="search-container">
                    <input type="text" id="searchInput" class="form-input" 
                           placeholder="Search templates..." 
                           oninput="searchTemplates(this.value)">
                    <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>

                <div class="templates-list" id="templatesList">
                    <?php
                    // Display existing templates
                    $query = "SELECT * FROM master_testtemplate ORDER BY recorddatetime DESC";
                    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query);
                    
                    if ($exec && mysqli_num_rows($exec) > 0) {
                        while ($res = mysqli_fetch_array($exec)) {
                            $templateName = $res['templatename'];
                            $testName = $res['testname'];
                            $createdDate = date('M d, Y', strtotime($res['recorddatetime']));
                            $createdBy = $res['username'];
                            ?>
                            <div class="template-card">
                                <div class="template-card-header">
                                    <div class="template-type">
                                        <i class="fas fa-<?php echo getTemplateIcon($testName); ?>"></i>
                                        <?php echo ucfirst($testName); ?>
                                    </div>
                                    <div class="template-date"><?php echo $createdDate; ?></div>
                                </div>
                                <div class="template-card-body">
                                    <h4><?php echo htmlspecialchars($templateName); ?></h4>
                                    <p>Created by: <?php echo htmlspecialchars($createdBy); ?></p>
                                </div>
                                <div class="template-card-actions">
                                    <button class="btn btn-outline btn-sm" onclick="viewTemplate('<?php echo $templateName; ?>')">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteTemplate('<?php echo $templateName; ?>')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div class="no-templates">No templates found. Create your first template above.</div>';
                    }
                    
                    function getTemplateIcon($testName) {
                        $icons = [
                            'lab' => 'flask',
                            'radiology' => 'x-ray',
                            'services' => 'stethoscope',
                            'ippackage' => 'bed',
                            'bedcharge' => 'bed'
                        ];
                        return isset($icons[$testName]) ? $icons[$testName] : 'copy';
                    }
                    ?>
                </div>
            </div>
</main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ratetemplate-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
