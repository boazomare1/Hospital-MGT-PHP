<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$timeonly = date('H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$department = '';



$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	 $res12locationanum = $res["auto_number"];

	



$query1111 = "select * from master_employee where username = '$username'";

			$exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));

			 while ($res1111 = mysqli_fetch_array($exec1111))

			 {

			   $locationnumber = $res1111["location"];

			   $query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'deleted'";

				$exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));

			 while ($res1112 = mysqli_fetch_array($exec1112))

			 {

			   $locationname = $res1112["locationname"];    

				$locationcode = $res1112["locationcode"];

			 }

			 }

if(isset($_REQUEST['department']))

{

$department = $_REQUEST['department'];

}

if(isset($_POST['patient'])){$searchpatient = $_POST['patient'];}else{$searchpatient="";}

if(isset($_POST['patientcode'])){$searchpatientcode=$_POST['patientcode'];}else{$searchpatientcode="";}

if(isset($_POST['visitcode'])){$searchvisitcode = $_POST['visitcode'];}else{$searchvisitcode="";}





?>


<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>


    <!-- External JavaScript -->
    <script type="text/javascript" src="js/autocomplete_customer1.js"></script>
    <script type="text/javascript" src="js/autosuggest3.js"></script>
</head>

<script type="text/javascript">

/*

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        

}

*/



					

//ajax to get location which is selected ends here





function disableEnterKey(varPassed)

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}



	if(key == 13) // if enter key press

	{

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

}









</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/iframeconsultationlist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>



<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Consultation List</p>
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
        <span>Consultations</span>
        <span>→</span>
        <span>Consultation List</span>
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
                    <li class="nav-item">
                        <a href="paymentmodecollectionsummary.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Payment Mode Collection Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="paymentmodecollectionbyuser.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Payment Mode Collection by User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="revenuereport_summary.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Revenue Report Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="comparativereport.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Comparative Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payrollcomponentreport1.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Payroll Component Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="iframeconsultationlist.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>Consultation List</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Consultation List</h2>
                    <p>View and manage patient consultations and published medical information.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportConsultationList()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>



<?php $query12= "select * from master_triage where  locationcode='$locationcode' and triagestatus = 'completed' and overallpayment='' and consultationdate >= NOW() - INTERVAL 2 DAY order by consultationdate DESC";

			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res12=mysqli_num_rows($exec12);

			?>

            <!-- Modern List Container -->
            <div class="modern-list-container">

                    <!-- Consultation List Component -->
                    <div class="consultation-list-component">
                        <div class="list-header">
                            <h3>📋 Consultation List</h3>
                            <div class="list-actions">
                                <button class="btn btn-primary" onclick="refreshConsultationList()">🔄 Refresh</button>
                                <button class="btn btn-success" onclick="exportConsultationList()">📊 Export</button>
                            </div>
                        </div>
                        <div class="list-content" id="consultationListContent">
                            <!-- Consultation list will be loaded here -->
                            <?php
                            if($res12 > 0) {
                                $colorloopcount = 0;
                                while($res12 = mysqli_fetch_array($exec12)) {
                                    $colorloopcount++;
                                    $triageanum = $res12['auto_number'];
                                    $patientname = $res12['patientname'];
                                    $patientcode = $res12['patientcode'];
                                    $visitcode = $res12['visitcode'];
                                    $consultationdate = $res12['consultationdate'];
                                    $department = $res12['department'];
                                    $doctor = $res12['doctor'];
                            ?>
                            <div class="consultation-item">
                                <div style="font-weight: bold; color: var(--medstar-primary);"><?php echo htmlspecialchars($triageanum); ?></div>
                                <div style="margin: 0.5rem 0; font-weight: 600;"><?php echo htmlspecialchars($patientname); ?></div>
                                <div style="font-size: 0.9rem; color: var(--text-secondary);">
                                    <div>Patient Code: <?php echo htmlspecialchars($patientcode); ?></div>
                                    <div>Visit Code: <?php echo htmlspecialchars($visitcode); ?></div>
                                    <div>Date: <?php echo htmlspecialchars($consultationdate); ?></div>
                                    <div>Department: <?php echo htmlspecialchars($department); ?></div>
                                    <div>Doctor: <?php echo htmlspecialchars($doctor); ?></div>
                                </div>
                            </div>
                            <?php
                                }
                            } else {
                            ?>
                            <div class="empty-state">
                                <i class="fas fa-clipboard-list"></i>
                                <h4>No Consultations Found</h4>
                                <p>There are no pending consultations at this time.</p>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Published List Component -->
                    <div class="published-list-component">
                        <div class="list-header">
                            <h3>📰 Published List</h3>
                            <div class="list-actions">
                                <button class="btn btn-primary" onclick="refreshPublishedList()">🔄 Refresh</button>
                                <button class="btn btn-success" onclick="exportPublishedList()">📊 Export</button>
                            </div>
                        </div>
                        <div class="list-content" id="publishedListContent">
                            <!-- Published list will be loaded here -->
                            <div class="empty-state">
                                <i class="fas fa-newspaper"></i>
                                <h4>No Published Items</h4>
                                <p>There are no published items at this time.</p>
                            </div>
                        </div>
                    </div>

            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/iframeconsultationlist-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



