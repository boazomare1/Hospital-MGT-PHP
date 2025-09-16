<?php
session_start();
error_reporting(0);

include ("db/db_connect.php");
include ("includes/loginverify.php");
include ("includes/check_user_access.php");

$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$timeonly = date("H:i:s");
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");

$errmsg = "";
$errmsg = isset($_REQUEST["errmsg"]) ? $_REQUEST["errmsg"] : "";
$frm1submit1 = isset($_REQUEST["frm1submit1"]) ? $_REQUEST["frm1submit1"] : "";
$st = isset($_REQUEST["st"]) ? $_REQUEST["st"] : "";

if ($st == 'success')

{

		$errmsg = "Success. File Uploaded Successfully.";

		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }

	

}

if ($st == 'failed')

{

		$errmsg = "Upload Failed";

}



if ($frm1submit1 == 'frm1submit1')

{   

	$templatedata = $_REQUEST['editor1'];

	$templatename = $_REQUEST['templatename'];



   if($templatedata != '') 

     {  

     $query26="insert into master_consultationtemplate(templatename,templatedata,recorddate,recordtime,username)values('$templatename','$templatedata','$dateonly1','$timeonly','$username')";

     $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	  header("location:addconsultationtemplate.php?st=success");

      exit();

	 }

	 else

	{

		header ("location:addconsultationtemplate.php?st=failed");

	}

   

 

}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Consultation Template - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/addconsultationtemplate-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- CKEditor -->
    <script type="text/javascript" src="ckeditor1/ckeditor.js"></script>












    
    <!-- Auto-suggest CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
</head>

<body onLoad="return funcOnLoadBodyFunctionCall();">
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Consultation Template Management</p>
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
        <span>Add Consultation Template</span>
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
                        <a href="addconsultationtemplate.php" class="nav-link active">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Template</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationrefundrequestlist.php" class="nav-link">
                            <i class="fas fa-undo"></i>
                            <span>Refund Request List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationrefundlist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Consultation Refund List</span>
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
                        <a href="chequescollected.php" class="nav-link">
                            <i class="fas fa-money-check"></i>
                            <span>Cheques Collected</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="claimtxnidedit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Claim Transaction Edit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payrollprocess1.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Process</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stockreportbyitem3.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Stock Report by Item</span>
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
                    <h2>Add Consultation Template</h2>
                    <p>Create and manage consultation templates for medical documentation.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportTemplate()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-outline" onclick="importTemplate()">
                        <i class="fas fa-upload"></i> Import
                    </button>
          </div>
        </div>

            <!-- Form Section -->
            <div class="form-section">
                <div class="form-header">
                    <i class="fas fa-file-medical form-header-icon"></i>
                    <h3 class="form-header-title">Consultation Template Form</h3>
                </div>
                
                <form name="frmsales" id="frmsales" method="post" action="addconsultationtemplate.php" onKeyDown="return disableEnterKey(event)" enctype="multipart/form-data" class="form-container">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="templatename" class="form-label">Template Name</label>
                            <input name="templatename" id="templatename" value="" class="form-input" style="text-transform:uppercase;" placeholder="Enter template name..." required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editor1" class="form-label">Template Content</label>
                 <div class="editor-container">
                            <textarea id="editor1" name="editor1" class="ckeditor" placeholder="Enter your consultation template content here..."></textarea>
                        </div>
                 </div>

                    <div class="form-actions">
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                        <button name="Submit2223" type="submit" class="btn btn-primary" onClick="return textareacontentcheck()" accesskey="b">
                            <i class="fas fa-save"></i> Save Template
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">
                            <i class="fas fa-undo"></i> Clear Form
                        </button>
               </div>
</form>
            </div>
</main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/addconsultationtemplate-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>