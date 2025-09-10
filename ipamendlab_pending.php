<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$visitcode = '';
$patientcode = '';

$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

// Get user location details
$query12 = " select * from login_locationdetails where username = '$username' "; 
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
$res12 = mysqli_fetch_array($exec12);
$locationname = $res12["locationname"]; 
$locationcode = $res12["locationcode"];

// Get pending IP lab consultations count
$querynw1 = "select * from ipconsultation_lab where labsamplecoll='pending' and locationcode='$locationcode' and paymentstatus = 'pending' group by patientvisitcode order by consultationdate desc";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_num_rows($execnw1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Amend Lab Pending - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Modern CSS - Inline Styles -->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; color: #333; }
        .hospital-header { background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); color: white; text-align: center; padding: 2rem 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .hospital-title { font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
        .hospital-subtitle { font-size: 1.1rem; opacity: 0.9; font-weight: 300; }
        .user-info-bar { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-bottom: 1px solid #e1e8ed; }
        .user-welcome { display: flex; flex-direction: column; gap: 0.25rem; }
        .welcome-text { font-weight: 600; color: #2c3e50; }
        .location-info { font-size: 0.9rem; color: #7f8c8d; }
        .user-actions { display: flex; gap: 1rem; }
        .nav-breadcrumb { background: white; padding: 1rem 2rem; border-bottom: 1px solid #e1e8ed; font-size: 0.9rem; }
        .nav-breadcrumb a { color: #3498db; text-decoration: none; transition: color 0.3s ease; }
        .nav-breadcrumb a:hover { color: #2980b9; }
        .nav-breadcrumb span { color: #7f8c8d; margin: 0 0.5rem; }
        .floating-menu-toggle { position: fixed; top: 120px; left: 20px; background: #3498db; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.2); z-index: 1000; transition: all 0.3s ease; }
        .floating-menu-toggle:hover { background: #2980b9; transform: scale(1.1); }
        .main-container-with-sidebar { display: flex; min-height: calc(100vh - 200px); transition: all 0.3s ease; }
        .left-sidebar { width: 280px; background: white; box-shadow: 2px 0 10px rgba(0,0,0,0.1); transition: transform 0.3s ease; z-index: 999; }
        .sidebar-header { background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%); color: white; padding: 1.5rem 1rem; display: flex; justify-content: space-between; align-items: center; }
        .sidebar-header h3 { font-size: 1.2rem; font-weight: 600; }
        .sidebar-toggle { background: none; border: none; color: white; cursor: pointer; font-size: 1rem; transition: transform 0.3s ease; }
        .sidebar-toggle:hover { transform: scale(1.1); }
        .sidebar-nav { padding: 1rem 0; }
        .nav-list { list-style: none; }
        .nav-item { margin: 0.25rem 0; }
        .nav-link { display: flex; align-items: center; gap: 1rem; padding: 1rem 1.5rem; color: #2c3e50; text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent; }
        .nav-link:hover { background: #f8f9fa; color: #3498db; border-left-color: #3498db; }
        .nav-link i { width: 20px; text-align: center; }
        .main-content { flex: 1; margin-left: 0; padding: 2rem; transition: margin-left 0.3s ease; }
        .page-header { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
        .page-header-content h2 { color: #2c3e50; font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem; }
        .page-header-content p { color: #7f8c8d; font-size: 1.1rem; }
        .page-header-actions { display: flex; gap: 1rem; flex-wrap: wrap; }
        .btn { padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-size: 0.95rem; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; text-align: center; }
        .btn-primary { background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; }
        .btn-primary:hover { background: linear-gradient(135deg, #2980b9 0%, #1f5f8b 100%); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(52, 152, 219, 0.3); }
        .btn-secondary { background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%); color: white; }
        .btn-secondary:hover { background: linear-gradient(135deg, #7f8c8d 0%, #6c7b7d 100%); transform: translateY(-2px); }
        .btn-outline { background: transparent; color: #3498db; border: 2px solid #3498db; }
        .btn-outline:hover { background: #3498db; color: white; transform: translateY(-2px); }
        .search-form-section { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .search-form-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; }
        .search-form-icon { font-size: 1.5rem; color: #3498db; }
        .search-form-title { color: #2c3e50; font-size: 1.5rem; font-weight: 600; }
        .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem; }
        .form-group { display: flex; flex-direction: column; }
        .form-label { font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem; font-size: 0.95rem; }
        .form-input, .form-select { padding: 0.75rem 1rem; border: 2px solid #e1e8ed; border-radius: 8px; font-size: 0.95rem; transition: all 0.3s ease; background: white; }
        .form-input:focus, .form-select:focus { outline: none; border-color: #3498db; box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1); }
        .form-actions { display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; }
        .submit-btn { background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); color: white; padding: 0.875rem 2rem; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 0.5rem; }
        .submit-btn:hover { background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(46, 204, 113, 0.3); }
        .data-table-section { background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); overflow: hidden; }
        .data-table-header { background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%); color: white; padding: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
        .data-table-icon { font-size: 1.5rem; }
        .data-table-title { font-size: 1.5rem; font-weight: 600; }
        .table-summary { display: flex; gap: 2rem; flex-wrap: wrap; }
        .summary-item { display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; opacity: 0.9; }
        .table-container { overflow-x: auto; max-width: 100%; }
        .data-table { width: 100%; border-collapse: collapse; min-width: 1000px; }
        .data-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; padding: 1rem; text-align: left; border-bottom: 2px solid #e1e8ed; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .data-table td { padding: 1rem; border-bottom: 1px solid #e1e8ed; vertical-align: middle; }
        .data-table tbody tr { transition: background-color 0.3s ease; }
        .data-table tbody tr:hover { background-color: #f8f9fa; }
        .even-row { background-color: #fafbfc; }
        .odd-row { background-color: white; }
        .serial-number { background: #3498db; color: white; padding: 0.5rem 0.75rem; border-radius: 20px; font-weight: 600; font-size: 0.85rem; display: inline-block; min-width: 30px; text-align: center; }
        .date-badge { background: #e8f4fd; color: #2980b9; padding: 0.5rem 0.75rem; border-radius: 6px; font-weight: 600; font-size: 0.85rem; }
        .patient-code { background: #f0f8ff; color: #5d6d7e; padding: 0.5rem 0.75rem; border-radius: 6px; font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.85rem; }
        .visit-code { background: #fff8e1; color: #f57c00; padding: 0.5rem 0.75rem; border-radius: 6px; font-family: 'Courier New', monospace; font-weight: 600; font-size: 0.85rem; }
        .patient-info { display: flex; flex-direction: column; gap: 0.25rem; }
        .patient-name { font-weight: 600; color: #2c3e50; }
        .account-name { background: #f3e5f5; color: #7b1fa2; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 0.85rem; font-weight: 500; }
        .action-buttons { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .action-btn { width: 36px; height: 36px; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; font-size: 0.9rem; }
        .action-btn.amend { background: #3498db; color: white; }
        .action-btn.amend:hover { background: #2980b9; transform: scale(1.1); }
        .action-btn.view { background: #27ae60; color: white; }
        .action-btn.view:hover { background: #2ecc71; transform: scale(1.1); }
        .action-btn.print { background: #95a5a6; color: white; }
        .action-btn.print:hover { background: #7f8c8d; transform: scale(1.1); }
        .action-btn.lab { background: #e67e22; color: white; }
        .action-btn.lab:hover { background: #d35400; transform: scale(1.1); }
        .no-data-message { text-align: center; padding: 3rem 2rem; color: #7f8c8d; }
        .no-data-message i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }
        .no-data-message p { margin-bottom: 0.5rem; font-size: 1.1rem; }
        .table-summary-footer { background: #f8f9fa; padding: 2rem; border-top: 1px solid #e1e8ed; }
        .summary-stats { display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap; gap: 2rem; }
        .stat-item { display: flex; align-items: center; gap: 0.75rem; color: #2c3e50; font-weight: 500; }
        .stat-item i { color: #3498db; font-size: 1.2rem; }
        
        /* Responsive Design */
        @media (max-width: 1200px) {
            .main-container-with-sidebar { flex-direction: column; }
            .left-sidebar { width: 100%; transform: none; }
            .main-content { margin-left: 0; }
            .floating-menu-toggle { display: none; }
        }
        @media (max-width: 768px) {
            .page-header { flex-direction: column; align-items: flex-start; }
            .page-header-actions { width: 100%; justify-content: stretch; }
            .btn { flex: 1; justify-content: center; }
            .form-row { grid-template-columns: 1fr; }
            .table-summary { flex-direction: column; gap: 1rem; }
            .summary-stats { flex-direction: column; gap: 1rem; }
            .action-buttons { flex-direction: column; gap: 0.25rem; }
            .action-btn { width: 100%; height: 32px; }
        }
        @media (max-width: 480px) {
            .hospital-title { font-size: 2rem; }
            .page-header-content h2 { font-size: 1.5rem; }
            .data-table-header { padding: 1.5rem; }
            .search-form-section, .data-table-section { padding: 1.5rem; }
        }
    </style>
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
        <span>IP Amend Lab Pending</span>
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
                        <a href="amend_pending_lab.php" class="nav-link">
                            <i class="fas fa-flask"></i>
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
                    <li class="nav-item">
                        <a href="amend_pending_referral.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Pending Referral</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_service.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>Pending Service</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amendlistipdoctor.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>IP Doctor List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="listipmiscbilling.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>IP Misc Billing</span>
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
                    <h2><i class="fas fa-flask"></i> IP Amend Lab Pending</h2>
                    <p>Manage and update pending IP lab consultations and sample collections</p>
                </div>
                <div class="page-header-actions">
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
                    <h3 class="search-form-title">Search IP Lab Consultations</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="ipamendlab_pending.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-select" onchange="ajaxlocationfunction(this.value);">
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
                            <label for="patientname" class="form-label">Patient Name</label>
                            <input name="patientname" type="text" id="patientname" 
                                   value="<?php echo isset($_POST['patientname']) ? htmlspecialchars($_POST['patientname']) : ''; ?>" 
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
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" 
                                   value="<?php echo htmlspecialchars($transactiondatefrom); ?>" 
                                   class="form-input" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" 
                                   value="<?php echo htmlspecialchars($transactiondateto); ?>" 
                                   class="form-input" readonly>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
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
                    <h3 class="data-table-title">Pending IP Lab Consultations</h3>
                    <div class="table-summary">
                        <div class="summary-item">
                            <i class="fas fa-calendar"></i>
                            <span>Date Range: <?php echo htmlspecialchars($_POST['ADate1']); ?> to <?php echo htmlspecialchars($_POST['ADate2']); ?></span>
                        </div>
                        <div class="summary-item">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Pending Consultations: <strong><?php echo $resnw1; ?></strong></span>
                        </div>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table" id="labTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Consultation Date</th>
                                <th>Patient Code</th>
                                <th>Visit Code</th>
                                <th>Patient Name</th>
                                <th>Account</th>
                                <th>Actions</th>
              </tr>
                        </thead>
                        <tbody id="labTableBody">
                     <?php
                            if ($cbfrmflag1 == 'cbfrmflag1') {
                                $searchlocationcode = $_POST['location'];
                                $searchadate1 = $_POST['ADate1'];
                                $searchadate2 = $_POST['ADate2'];
                                $patientnameget = isset($_POST['patientname']) ? $_POST['patientname'] : '';
                                $patientcodeget = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
                                $visitcodeget = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';

	 $filter_qry = "";
                                if (trim($patientnameget) != "") {
                                    $filter_qry .= " and patientname LIKE '%" . $patientnameget . "%' ";
                                }
                                if (trim($patientcodeget) != "") {
	 	$filter_qry .= " and patientcode ='$patientcodeget' ";
	 }
                                if (trim($visitcodeget) != "") {
	 	$filter_qry .= " and patientvisitcode ='$visitcodeget' ";
	 }

			$colorloopcount = '';
			$sno = '';

	        $query1 = "select * from ipconsultation_lab where resultentry!='completed' and locationcode='$searchlocationcode' and consultationdate between '$searchadate1'and '$searchadate2' $filter_qry group by patientvisitcode order by consultationdate desc"; 
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

                                while ($res1 = mysqli_fetch_array($exec1)) {
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientname = $res1['patientname'];
                                    $patientaccountname = $res1['accountname'];
                                    $consultationdate = $res1['consultationdate'];
			$locationcode = $res1['locationcode'];

                                    // Check if billing exists
                                    $query2 = "select sum(rows) as rows from (SELECT count(auto_number) AS rows FROM billing_ipcreditapproved WHERE visitcode = '$visitcode'
			UNION ALL 
                                    SELECT count(auto_number) AS rows FROM billing_ip WHERE visitcode = '$visitcode') as a";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$rows = $res2['rows'];
			
                                    if ($rows == 0) {
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
                                        $rowClass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                                        $sno++;
                            ?>
                            <tr class="<?php echo $rowClass; ?>">
                                <td>
                                    <div class="serial-number">
                                        <?php echo $sno; ?>
                                    </div>
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
                                    <span class="account-name">
                                        <?php echo htmlspecialchars($patientaccountname); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="ipamendlab.php?patientcode=<?php echo htmlspecialchars($patientcode); ?>&visitcode=<?php echo htmlspecialchars($visitcode); ?>&locationcode=<?php echo htmlspecialchars($locationcode); ?>" 
                                           class="action-btn amend" title="Amend Lab Consultation">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn view" 
                                                onclick="viewPatientDetails('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="View Patient Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn print" 
                                                onclick="printConsultation('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="Print Consultation">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <button class="action-btn lab" 
                                                onclick="viewLabDetails('<?php echo htmlspecialchars($patientcode); ?>', '<?php echo htmlspecialchars($visitcode); ?>')"
                                                title="View Lab Details">
                                            <i class="fas fa-flask"></i>
                                        </button>
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
                    <p>No pending IP lab consultations found for the selected criteria.</p>
                    <p>Try adjusting your search parameters or date range.</p>
                </div>
                <?php endif; ?>

                <!-- Summary Footer -->
                <div class="table-summary-footer">
                    <div class="summary-stats">
                        <div class="stat-item">
                            <i class="fas fa-flask"></i>
                            <span>Total Consultations: <strong><?php echo $sno; ?></strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-clock"></i>
                            <span>Date Range: <strong><?php echo isset($_POST['ADate1']) ? htmlspecialchars($_POST['ADate1']) : ''; ?></strong> to <strong><?php echo isset($_POST['ADate2']) ? htmlspecialchars($_POST['ADate2']) : ''; ?></strong></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Pending Consultations: <strong><?php echo $resnw1; ?></strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ipamendlabpending-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy Functions -->
    <script type="text/javascript">
        function ajaxlocationfunction(val) { 
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
                }
            }
            
            xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
            xmlhttp.send();
        }

        function cbcustomername1() {
            document.cbform1.submit();
        }

        function disableEnterKey(varPassed) {
            if (event.keyCode == 8) {
                event.keyCode = 0;
                return event.keyCode;
                return false;
            }
            
            var key;
            if (window.event) {
                key = window.event.keyCode;
            } else {
                key = e.which;
            }

            if (key == 13) {
                return false;
            } else {
                return true;
            }
        }

        function loadprintpage1(banum) {
            var banum = banum;
            window.open("print_bill1_op1.php?billautonumber=" + banum + "", "Window" + banum + "", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
        }

        function printPage() {
            window.print();
        }

        function exportToCSV() {
            const table = document.querySelector('.data-table');
            if (!table) {
                alert('No data to export');
                return;
            }
            
            let csv = [];
            const rows = table.querySelectorAll('tr');
            
            for (let i = 0; i < rows.length; i++) {
                let row = [], cols = rows[i].querySelectorAll('td, th');
                
                for (let j = 0; j < cols.length; j++) {
                    let text = cols[j].innerText.replace(/,/g, ';');
                    row.push('"' + text + '"');
                }
                
                csv.push(row.join(','));
            }
            
            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            
            if (link.download !== undefined) {
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', 'ip_lab_pending.csv');
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        function viewPatientDetails(patientcode, visitcode) {
            alert(`Viewing patient details: ${patientcode} - ${visitcode}`);
        }

        function printConsultation(patientcode, visitcode) {
            alert(`Printing consultation: ${patientcode} - ${visitcode}`);
        }

        function viewLabDetails(patientcode, visitcode) {
            alert(`Viewing lab details: ${patientcode} - ${visitcode}`);
        }
    </script>
</body>
</html>









