<?php
// Modern PHP with strict error reporting and security headers
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

session_start();

$pagename = '';

include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
include ("includes/check_user_access.php");

if (!isset($_SESSION['username'])) {
    header("location:index.php");
    exit();
}

include ("db/db_connect.php");

// Initialize variables with proper validation
$ipaddress = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$errmsg = '';
$bgcolorcode = '';

// CSRF Token generation
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
}

// CSRF Token validation
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $token;
}

// Input sanitization function
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}



// Sanitize and validate search inputs
$searchsuppliername = isset($_REQUEST["searchsuppliername"]) ? sanitizeInput($_REQUEST["searchsuppliername"]) : "";
$searchdescription = isset($_REQUEST["searchdescription"]) ? sanitizeInput($_REQUEST["searchdescription"]) : "";
$searchemployeecode = isset($_REQUEST["searchemployeecode"]) ? sanitizeInput($_REQUEST["searchemployeecode"]) : "";

$frmflag1 = isset($_REQUEST["frmflag1"]) ? sanitizeInput($_REQUEST["frmflag1"]) : "";



//$frmflag1 = $_REQUEST['frmflag1'];

// Handle form submission with modern security
if ($frmflag1 == 'frmflag1') {
    // CSRF Token validation
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $errmsg = "Security validation failed. Please try again.";
        $bgcolorcode = 'failed';
    } else {
        // Sanitize and validate all form inputs
        $employeecode = sanitizeInput($_REQUEST['employeecode']);
        $employeename = strtoupper(trim(sanitizeInput($_REQUEST['employeename'])));
        $username1 = sanitizeInput($_REQUEST['username1']);
        $password = base64_encode(sanitizeInput($_REQUEST['password']));
        $status = sanitizeInput($_REQUEST['status']);
        $validitydate = sanitizeInput($_REQUEST['validitydate']);
        $location = sanitizeInput($_REQUEST['location']);
        $store = sanitizeInput($_REQUEST['store']);
        $shift = sanitizeInput($_REQUEST["shift"]);
        $jobdescription = sanitizeInput($_REQUEST['jobdescription']);
        $cashlimit = sanitizeInput($_REQUEST['cashlimit']);
        $reports_daterange_option = sanitizeInput($_REQUEST['reports_daterange_option']);
        $option_edit_delete = sanitizeInput($_REQUEST['option_edit_delete']);
        $showlocations = sanitizeInput($_REQUEST["showlocations"]);
        $statistics = sanitizeInput($_REQUEST['statistics']);
        $docType = sanitizeInput($_REQUEST['docType']);
        $mis = sanitizeInput($_REQUEST['mis']);
        $biometric = isset($_REQUEST['biometric']) ? '1' : '0';
        $labrslt = isset($_REQUEST['labrslt']) ? '1' : '0';
	

	

        // Check if employee exists using prepared statement
        $stmt = $GLOBALS["___mysqli_ston"]->prepare("SELECT COUNT(*) FROM master_employee WHERE employeecode = ?");
        $stmt->bind_param("s", $employeecode);
        $stmt->execute();
        $stmt->bind_result($res2);
        $stmt->fetch();
        $stmt->close();

        if ($res2 != 0) {

            // Update employee using prepared statement
            $stmt = $GLOBALS["___mysqli_ston"]->prepare("UPDATE master_employee SET employeename = ?, password = ?, status = ?, username = ?, lastupdate = ?, lastupdateusername = ?, lastupdateipaddress = ?, reports_daterange_option = ?, option_edit_delete = ?, location = ?, store = ?, shift = ?, jobdescription = ?, validitydate = ?, cashlimit = ?, showlocations = ?, statistics = ?, DoctorType = ?, mis = ?, biometric = ?, labrslt = ? WHERE employeecode = ?");
            $stmt->bind_param("sssssssssssssssssssss", $employeename, $password, $status, $username1, $updatedatetime, $sessionusername, $ipaddress, $reports_daterange_option, $option_edit_delete, $location, $store, $shift, $jobdescription, $validitydate, $cashlimit, $showlocations, $statistics, $docType, $mis, $biometric, $labrslt, $employeecode);
            
            if ($stmt->execute()) {
                $stmt->close();
            } else {
                $errmsg = "Failed to update employee information.";
                $bgcolorcode = 'failed';
                $stmt->close();
            }

		$query18 = "update master_employeelocation set username = '$username1' where employeecode = '$employeecode'";

		$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));

		/*

		if ($username != 'admin')

		{

		*/

			

			$query33 = "delete from master_employeerights where employeecode = '$employeecode' and mainmenuid NOT IN ('MM001','MM026') and submenuid=''";

			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));

			

			/*$query333 = "delete from master_employeelocation where employeecode = '$employeecode'";

			$exec333 = mysql_query($query333) or die ("Error in Query333".mysql_error());	*/



			$q_submenu=array();

			$query_menu="select submenuid from master_menusub where mainmenuid NOT IN ('MM001','MM026')";

			$exec_menu = mysqli_query($GLOBALS["___mysqli_ston"], $query_menu) or die ("Error in query_menu".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res_menu = mysqli_fetch_array($exec_menu)){

				array_push($q_submenu, $res_menu['submenuid']);

			}

			

			$str_submenu = implode ("','", $q_submenu);



			$query33 = "delete from master_employeerights where employeecode = '$employeecode' and mainmenuid='' and submenuid IN ('$str_submenu')";

			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));

			

			$query77 = "delete from master_employeedepartment where employeecode = '$employeecode'";

			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));	



			

			for ($i=0;$i<=1000;$i++)

			{

				if (isset($_REQUEST["cbmainmenu".$i])) { $cbmainmenu = $_REQUEST["cbmainmenu".$i]; } else { $cbmainmenu = ""; }

				//$cbmainmenu = $_REQUEST['cbmainmenu'.$i];

				if ($cbmainmenu != '')

				{

					//echo '<br>'.$cbmainmenu;

					$query5 = "select * from master_menumain where auto_number = '$cbmainmenu'";

					$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res5 = mysqli_fetch_array($exec5);

					$res5mainmenuid = $res5['mainmenuid'];

					

					$query3 = "insert into master_employeerights (employeecode, username, mainmenuid, submenuid, 

					lastupdate, lastupdateipaddress, lastupdateusername) 

					values ('$employeecode', '$username1', '$res5mainmenuid', '', 

					'$updatedatetime', '$ipaddress', '$sessionusername')";

					$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));

				}

			}

	

			//echo '<br><br>';

			for ($i=0;$i<=1000;$i++)

			{

				if (isset($_REQUEST["cbsubmenu".$i])) { $cbsubmenu = $_REQUEST["cbsubmenu".$i]; } else { $cbsubmenu = ""; }

				//$cbsubmenu = $_REQUEST['cbsubmenu'.$i];

				if ($cbsubmenu != '')

				{

					//echo '<br>'.$cbsubmenu;

					$query6 = "select * from master_menusub where auto_number = '$cbsubmenu'";

					$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res6 = mysqli_fetch_array($exec6);

					$res6submenuid = $res6['submenuid'];

	

					$query4 = "insert into master_employeerights (employeecode, username, mainmenuid, submenuid, 

					lastupdate, lastupdateipaddress, lastupdateusername) 

					values ('$employeecode', '$username1', '', '$res6submenuid', 

					'$updatedatetime', '$ipaddress', '$sessionusername')";

					$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));

				}

			}

			

			for ($i=0;$i<=1000;$i++)

		{

			if (isset($_REQUEST["cbdepartment".$i])) { $cbdepartment = $_REQUEST["cbdepartment".$i]; } else { $cbdepartment = ""; }

			//$cbsubmenu = $_REQUEST['cbsubmenu'.$i];

			if ($cbdepartment != '')

			{

				//echo '<br>'.$cbsubmenu;

				$query7 = "select * from master_department where auto_number = '$cbdepartment'";

				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res7 = mysqli_fetch_array($exec7);

				$res7departmentname = $res7['department'];



				$query8 = "insert into master_employeedepartment (employeecode, username, departmentanum, department, 

				lastupdate, lastupdateipaddress, lastupdateusername) 

				values ('$employeecode', '$username1', '$cbdepartment', '$res7departmentname', 

				'$updatedatetime', '$ipaddress', '$sessionusername')";

				$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));

			}

		}

		for ($i=0;$i<=1000;$i++)

		{

			if (isset($_REQUEST["cblocation".$i])) { $cblocation = $_REQUEST["cblocation".$i]; } else { $cblocation = ""; }

			//$cbsubmenu = $_REQUEST['cbsubmenu'.$i];

			if ($cblocation != '')

			{

				//echo '<br>'.$cbsubmenu;

				$query1 = "select * from master_location where auto_number = '$cblocation'";

				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res1 = mysqli_fetch_array($exec1);

				$res1locationname = $res1['locationname'];

				$res1locationcode = $res1['locationcode'];



				/*$query8 = "insert into master_employeelocation (employeecode, username, locationanum, locationname,locationcode, 

				lastupdate, lastupdateipaddress, lastupdateusername) 

				values ('$employeecode', '$username1', '$cblocation', '$res1locationname','$res1locationcode', 

				'$updatedatetime', '$ipaddress', '$sessionusername')";

				$exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());*/

			}

		}

	            header("location:rightsaccess.php?st=success");
        } else {
            header("location:rightsaccess.php?st=failed");
        }
    }
}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if ($st == 'success')

{

		$errmsg = "Success. Employee Updated.";

}

else if ($st == 'failed')

{

		$errmsg = "Failed. Employee Already Exists.";

}



if (isset($_REQUEST["searchemployeecode"])) { $selectemployeecode = $_REQUEST["searchemployeecode"]; } else { $selectemployeecode = ""; }

//$selectemployeecode = $_REQUEST['selectemployeecode'];

$query7 = "select * from master_employee where employeecode = '$selectemployeecode'";

$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

$res7 = mysqli_fetch_array($exec7);



$res7employeecode=$res7['employeecode'];

$res7employeename = $res7['employeename'];

$res7employeename = strtoupper($res7employeename);

$res7employeename = trim($res7employeename);

$res7username = $res7['username'];

$res7password = $res7['password'];

$res7status = $res7['status'];

$res7lastupdate = $res7['lastupdate'];

 $res7locationanum = $res7['location'];

$res7shift = $res7["shift"];

$res7validitydate = $res7['validitydate'];

$res7jobdescription = $res7['jobdescription'];

$cashlimit = $res7['cashlimit'];

$docType = $res7['DoctorType'];

$mis = $res7['mis'];

$biometric = $res7['biometric'];

$labrslt = $res7['labrslt'];


$query55 = "select * from master_location where auto_number='$res7locationanum'";

$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res55 = mysqli_fetch_array($exec55);

$res7location = $res55['locationname'];



$res7storeanum = $res7['store'];



$query75 = "select * from master_store where auto_number='$res7storeanum'";

$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res75 = mysqli_fetch_array($exec75);

$res7store = $res75['store'];





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Employee Rights Access Management for MedStar Hospital Management System">
    <meta name="robots" content="noindex, nofollow">
    <title>Employee Rights Access - MedStar Hospital</title>
    
    <!-- Preload critical resources -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style">
    
    <!-- Modern CSS Framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/rightsaccess-modern.css?v=<?php echo time(); ?>">
    
    <!-- External JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="js/rightsaccess-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "MedStar Hospital Management System",
        "description": "Employee Rights Access Management for Hospital System"
    }
    </script>
</head>

<style type="text/css">
<!--
body {
    margin-left: 0px;
    margin-top: 0px;
    background-color: #ecf0f5;
}

.bodytext3 {
    FONT-WEIGHT: normal; 
    FONT-SIZE: 11px; 
    COLOR: #3B3B3C; 
    FONT-FAMILY: Tahoma
}

.ui-menu .ui-menu-item{ 
    zoom:1.3 !important; 
}
-->
</style>

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  

<!--<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>

<script type="text/javascript" src="js/autosuggestjobdescription1.js"></script>-->

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

  <script> 

$(function() {

	

$('#searchsuppliername').autocomplete({

		

	source:'ajaxemployeenewsearch.php', 

	//alert(source);

	minLength:3,

	delay: 0,

	html: true, 

		select: function(event,ui){

			var code = ui.item.id;

			var employeecode = ui.item.employeecode;

			var employeename = ui.item.employeename;

			$('#searchemployeecode').val(employeecode);

			$('#searchsuppliername').val(employeename);

			

			},

    });

});

</script>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script language="javascript">



function process1backkeypress1() 

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

}



</script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>

<script language="javascript">



function from1submit1()

{



	if (document.form1.employeename.value == "")

	{

		alert ("Employee Name Cannot Be Empty.");

		document.form1.employeename.focus();

		return false;

	}

	if (document.form1.username.value == "")

	{

		alert ("User Name Cannot Be Empty.");

		document.form1.username.focus();

		return false;

	}

	if (document.form1.username.value != "")

	{	

		var data = document.form1.username.value;

		//alert(data);

		// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.*

		var iChars = "!^+=[];,{}|\<>?~$'\"@#%&*()-_`. "; 

		for (var i = 0; i < data.length; i++) 

		{

			if (iChars.indexOf(data.charAt(i)) != -1) 

			{

				//alert ("Your Item Name Has Blank White Spaces Or Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ $ ' \" These are not allowed.");

				alert ("Your User Name Has Blank White Spaces Or Special Characters. These Are Not Allowed.");

				return false;

			}

		}

	}

	if (document.form1.password.value == "")

	{

		alert ("Password Cannot Be Empty.");

		document.form1.password.focus();

		return false;

	}

}



function funcEmployeeSelect1()

{

	if (document.getElementById("selectemployeecode").value == "")

	{

		alert ("Please Select Employee Code To Edit.");

		document.getElementById("selectemployeecode").focus();

		return false;

	}

}



function funclocationChange1()

{



	

	<?php 

	$query12 = "select * from master_location where status = ''";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res12 = mysqli_fetch_array($exec12))

	{

	$res12locationanum = $res12["auto_number"];

	$res12location = $res12["locationname"];

	?>

	if(document.getElementById("location").value=="<?php echo $res12locationanum; ?>")

	{

		document.getElementById("store").options.length=null; 

		var combo = document.getElementById('store'); 	

		<?php 

		$loopcount=0;

		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 

		<?php

		$query10 = "select * from master_store where location = '$res12locationanum' and recordstatus = ''";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		$loopcount = $loopcount+1;

		$res10storeanum = $res10["auto_number"];

		$res10store = $res10["store"];

		?>

			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10store;?>", "<?php echo $res10storeanum;?>"); 

		<?php 

		}

		?>

	}

	<?php

	}

	?>	

}

</script>

<script src="js/datetimepicker_css.js"></script>

<body>
    <!-- Modern MedStar Hospital Management Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Dashboard</a>
        <span>→</span>
        <span>Settings</span>
        <span>→</span>
        <span>Employee Rights Access</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <button class="floating-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar" id="mainContainer">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>🏥 MedStar</h3>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Account Main Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Account Sub Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountname1.php" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Account Names</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivable.php" class="nav-link">
                            <i class="fas fa-hand-holding-usd"></i>
                            <span>Receivables</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="expenses.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Expenses</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="income.php" class="nav-link">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Income</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbank1.php" class="nav-link">
                            <i class="fas fa-university"></i>
                            <span>Bank Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientmanagement.php" class="nav-link">
                            <i class="fas fa-user-injured"></i>
                            <span>Patient Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultation.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>Consultation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labitems.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="radiology.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Radiology</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employeemanagement.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Employee Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="departmentmanagement.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Department Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="rightsaccess.php" class="nav-link active">
                            <i class="fas fa-shield-alt"></i>
                            <span>Employee Rights Access</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Alert Messages -->
            <?php include ("includes/alertmessages1.php"); ?>
            
            <!-- Success/Error Messages -->
            <?php if ($errmsg != ''): ?>
                <div class="alert alert-<?php echo ($st == 'success') ? 'success' : 'error'; ?>">
                    <i class="fas fa-<?php echo ($st == 'success') ? 'check-circle' : 'exclamation-triangle'; ?> alert-icon"></i>
                    <span><?php echo $errmsg; ?></span>
                </div>
            <?php endif; ?>

        <!-- Employee Search Section -->
        <section class="employee-search-section">
            <div class="section-header">
                <span class="section-icon">🔍</span>
                <h3 class="section-title">Employee Search</h3>
            </div>
            
            <form name="selectemployee" id="selectemployee" method="post" action="rightsaccess.php?st=edit" onSubmit="return funcEmployeeSelect1()" class="search-form">
                <div class="search-input-group">
                    <label for="searchsuppliername" class="form-label">Select Employee To Edit *</label>
                    <input name="searchsuppliername" type="text" id="searchsuppliername" class="search-input" value="<?php echo htmlspecialchars($searchsuppliername); ?>" placeholder="Type employee name to search..." autocomplete="off" required>
                    <input name="searchdescription" id="searchdescription" type="hidden" value="">
                    <input name="searchemployeecode" id="searchemployeecode" type="hidden" value="">
                    <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
                </div>
                <button type="submit" name="Submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Search Employee
                </button>
            </form>
        </section>

	

	

	

  <tr>

    <td>&nbsp;</td>

    <td valign="top">&nbsp;</td>

    <td valign="top">  

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top">&nbsp;</td>

    <td width="97%" valign="top">



        <?php if ($selectemployeecode != ''): ?>
            <!-- Employee Form Section -->
            <section class="employee-form-section">
                <div class="employee-form-header">
                    <h2 class="employee-form-title">Employee Rights Management</h2>
                    <p class="employee-form-subtitle">Advanced Healthcare Management Platform - Employee Access Control</p>
                </div>
                
                <form name="form1" id="form1" method="post" action="rightsaccess.php" onKeyDown="return disableEnterKey()" onSubmit="return from1submit1()" novalidate>
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    
                    <div class="form-layout">
                        <!-- Basic Information -->
                        <div class="form-group">
                            <label for="employeecode" class="form-label">Employee Code *</label>
                            <input name="employeecode" id="employeecode" value="<?php echo htmlspecialchars($res7employeecode); ?>" class="form-input" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="employeename" class="form-label">Employee Name *</label>
                            <input name="employeename" id="employeename" value="<?php echo htmlspecialchars($res7employeename); ?>" class="form-input" style="text-transform: uppercase;" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="jobdescription" class="form-label">Job Description</label>
                            <input name="jobdescription" id="jobdescription" value="<?php echo htmlspecialchars($res7jobdescription); ?>" class="form-input" style="text-transform: uppercase;">
                        </div>
                        
                        <div class="form-group">
                            <label for="username1" class="form-label">Username *</label>
                            <input name="username1" id="username1" value="<?php echo htmlspecialchars($res7username); ?>" class="form-input" maxlength="20" required>
                            <small class="form-text">No spaces or special characters allowed</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="form-label">Password *</label>
                            <input name="password" type="password" id="password" value="<?php echo base64_decode($res7password); ?>" class="form-input" maxlength="20" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <?php if ($res7status != ''): ?>
                                    <option value="<?php echo htmlspecialchars($res7status); ?>" selected><?php echo htmlspecialchars($res7status); ?></option>
                                <?php endif; ?>
                                <option value="Active">Active</option>
                                <option value="Deleted">Deleted</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="validitydate" class="form-label">Validity Date</label>
                            <input name="validitydate" id="validitydate" value="<?php echo htmlspecialchars($res7validitydate); ?>" class="form-input" readonly>
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('validitydate')" style="cursor:pointer; margin-left: 5px;"/>
                            <input type="hidden" name="dateposted" id="dateposted" value="<?php echo $updatedatetime; ?>" onKeyDown="return process1backkeypress1()" readonly/>
                        </div>
                    </div>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td colspan="3" align="left" valign="middle" >&nbsp;</td>

              </tr>

              <tr>

                <td width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Employee Code   *</td>

                <td colspan="3" align="left" valign="middle" >

				<input name="employeecode" id="employeecode" value="<?php echo $res7employeecode; ?>" readonly style="border: 1px solid #001E6A" size="20"></td>

              </tr>

              <tr>

                <td width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Employee Name   *</td>

                <td colspan="3" align="left" valign="middle" >

				<input name="employeename" id="employeename"  value="<?php echo $res7employeename; ?>"style="border: 1px solid #001E6A;text-transform: uppercase;" size="60"></td>

              </tr>

			  <tr>

                <td width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Job Description</td>

                <td colspan="3" align="left" valign="middle" >

				<input name="jobdescription" id="jobdescription"  value="<?php echo $res7jobdescription; ?>"style="border: 1px solid #001E6A;text-transform: uppercase;" size="60"></td>

              </tr>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">User Name </td>

                <td colspan="3" align="left" valign="middle" >

				<input name="username1" id="username1" style="border: 1px solid #001E6A;" value="<?php echo $res7username; ?>" size="60" maxlength="20" />

                    <span class="bodytext3">(Space or special characters are not allowed.) </span></td>

              </tr>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Password</td>

                <td colspan="3" align="left" valign="middle" >

				<input name="password" type="password" id="password" style="border: 1px solid #001E6A;" value="<?php echo base64_decode($res7password); ?>" size="60" maxlength="20" /></td>

              </tr>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Status</td>

                <td valign="middle" align="left" >

				<select name="status" id="status" style="width: 130px;">

					<?php

					if ($res7status != '')

					{

					?>

					<option value="<?php echo $res7status; ?>" selected="selected"><?php echo $res7status; ?></option>

					<?php

					}

					?>

                    <option value="Active">Active</option>

                    <option value="Deleted">Deleted</option>

                </select>				</td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Validity Date </td>

                <td valign="middle" align="left">

					<input name="validitydate" id="validitydate" style="border: 1px solid #001E6A" value="<?php echo $res7validitydate; ?>"  readonly="readonly" onKeyDown="return disableEnterKey()" size="10" />

					<img src="images2/cal.gif" onClick="javascript:NewCssCal('validitydate')" style="cursor:pointer"/>					

				<input type="hidden" name="dateposted" id="dateposted" value="<?php echo $updatedatetime; ?>" onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A"  size="20"  readonly="readonly" /></td>

              </tr>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location and Stores</td>

                <td  align="left">

                <a href="#" class="bodytext3" onClick="window.open('addemployeelocationandstore.php?eid=<?php echo $selectemployeecode;?>')">Click Here for Add Location and Stores</a></td>

				<?php /*?><!--<?php

				 $checkedvalue3 = '';

				 $query1 =  "select * from master_location where status <> 'deleted' order by locationname";;

				 $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());

				 while ($res1 = mysql_fetch_array($exec1))

				 {

				  $res1anum = $res1['auto_number'];

				  $res1location = $res1['locationname'];

				   $locationcode11 = $res1['locationcode'];

				  

				 

				 ?>  <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

                <td valign="middle" align="left" ><span class="bodytext3">

                

                <input type="checkbox" name="cblocation<?php echo $res1anum; ?>" value="<?php echo $res1anum; ?>" <?php $query21 =  "select * from master_employeelocation where employeecode = '".$res7employeecode."' ";;

				 $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());

				 while ($res1 = mysql_fetch_array($exec21))

				 {

				  $locationcode12 = $res1['locationcode']; if($locationcode11==$locationcode12){echo "checked";}}?> >

                  <strong><?php echo $res1location; ?></strong>

                  </span></td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <?php 

				 $checkedvalue3 = '';

				 }

				 ?>--><?php */?>

					</tr>

                    <tr>  

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cash Limit</td>

                <td valign="middle" align="left" ><input type="text" name="cashlimit" id="cashlimit" style="border: 1px solid #001E6A" size="10" value="<?php echo $cashlimit; ?>"></td>

              </tr>

			  <?php /*?><!--<tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Store</td>

                <td valign="middle" align="left">

					  <select name="store" id="store" style="border: 1px solid #001E6A;">

                  <?php

						if ($res7store != '')

						{

						?>

						<option value="<?php echo $res7storeanum; ?>" selected="selected"><?php echo $res7store; ?></option>

						<?php

						}

						else

						{

						?>

						<option value="" selected="selected">Select Store</option>

						<?php

						}

						$query1 = "select * from master_store where recordstatus <> 'deleted' order by store";

						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());

						while ($res1 = mysql_fetch_array($exec1))

						{

						$res1store = $res1["store"];

						$res1storeanum = $res1["auto_number"];

						?>

						<option value="<?php echo $res1storeanum; ?>"><?php echo $res1store; ?></option>

						<?php

						}

						?>

                  </select></td>

				  <?php

				  $res34locations = ''; 

				  $query34 = "select * from master_employee where employeecode = '$selectemployeecode' and showlocations='on' ";

				 $exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());

				 $res34 = mysql_fetch_array($exec34);

				 $rowcount34 = mysql_num_rows($exec34);

				  if ($rowcount34 > 0)

				 {

				 	$res34locations = 'checked="checked"';

				 }

				 ?>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Show All Stores </td>

                <td valign="middle" align="left" ><input type="checkbox" name="showlocations" id="showlocations" <?php echo $res34locations; ?>></td>

              </tr>--><?php */?>

			   <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Shift Access </td>

                <td valign="middle" align="left" ><select name="shift" id="shift" >

					<?php

					if ($res7shift != '')

					{

					?>

					<option value="<?php echo $res7shift; ?>" selected="selected"><?php echo $res7shift; ?></option>

					<?php

					}

					?>

                  <option value="">SELECT ACCESS</option>

                  <option value="YES">YES</option>

                  <option value="NO">NO</option>

                </select></td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Reorder Alert</td>

                <?php

				$res341statistics='';

				 $query341 = "select * from master_employee where employeecode = '$selectemployeecode' and statistics='on'";

				 $exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));

				 $res341 = mysqli_fetch_array($exec341);

				 $rowcount341 = mysqli_num_rows($exec341);

				  if ($rowcount341 > 0)

				 {

				 	$res341statistics = 'checked="checked"';

				 }

				 ?>

                <td valign="middle" align="left" ><input type="checkbox" name="statistics" id="statistics" <?php echo $res341statistics; ?>></td>

              </tr>

 

			  <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong></td>

                <td valign="middle" align="left" >&nbsp;</td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doctor Type</td>

                <td valign="middle" align="left" >

				   <select name="docType" id="docType" >

				   <option value="">Select</option>

                  <option value="0" <?php if($docType==0) echo 'selected'; else echo '';?>>MO</option>

                  <option value="1" <?php if($docType==1) echo 'selected'; else echo '';?>>Consultant</option>

                </select>

				</td>

              </tr>



              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Menu Permissions </strong></td>

                <td valign="middle" align="left" >&nbsp;</td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">MIS</td>

                <td valign="middle" align="left" ><input type="checkbox" name="mis" id="mis" value="1" <?php if($mis==1) echo 'checked'; else echo ''; ?>></td>

              </tr>

             
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong</strong></td>
                <td valign="middle" align="left" >&nbsp;</td>

			  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Biometric</td>
                <td valign="middle" align="left" ><input type="checkbox" name="biometric" id="biometric" <?php if($biometric==1) echo 'checked="checked"'; else echo ''; ?>></td>
			 </tr>

			 

              <script>

				 function allmenucheck()

				 {

					 var inputs = document.getElementsByClassName('mainmenucheck');	

					 for (var i = 0; i < inputs.length; i++) 

					 {

						 var displayattr = document.getElementById('mainmenucheck1').checked;

						 if(displayattr==true)

						 {

							inputs[i].checked='checked';

							//document.getElementById('id'+pino).innerHTML='+';

						 }

						 else

						 {

							inputs[i].checked='';

							//document.getElementById('id'+pino).innerHTML='-';

						 }

					 }

					 var inputs = document.getElementsByClassName('submenucheck');	

					 for (var i = 0; i < inputs.length; i++) 

					 {

						 var displayattr = document.getElementById('mainmenucheck1').checked;

						 if(displayattr==true)

						 {

							inputs[i].checked='checked';

							//document.getElementById('id'+pino).innerHTML='+';

						 }

						 else

						 {

							inputs[i].checked='';

							//document.getElementById('id'+pino).innerHTML='-';

						 }

					 }

				 }

				 

				 function submenucheck(mainmenucheck)

				 {

					 var inputs = document.getElementsByClassName(mainmenucheck);	

					 for (var i = 0; i < inputs.length; i++) 

					 {

						 

						 var displayattr = document.getElementById(mainmenucheck).checked;

						 if(displayattr==true)

						 {

							inputs[i].checked='checked';

							//document.getElementById('id'+pino).innerHTML='+';

						 }

						 else

						 {

							inputs[i].checked='';

							

							//document.getElementById('id'+pino).innerHTML='-';

						 }

					 }

					

				 }

			  </script>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Main Menu <input id="mainmenucheck1" class="mainmenucheck1" type="checkbox" name="cbmainmen" onClick="allmenucheck()"></strong></td>

                <td valign="middle" align="left" ><span class="bodytext3"><strong>Sub Menu </strong></span></td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <?php

			  $checkedvalue1 = '';

			  $checkedvalue2 = '';

				 $query2 = "select * from master_menumain where mainmenuid NOT IN ('MM001','MM026') and status = '' order by mainmenuorder";

				 $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

				 while ($res2 = mysqli_fetch_array($exec2))

				 {

				 $res2anum = $res2['auto_number'];

				 $res2menuid = $res2['mainmenuid'];

				 $res2mainmenutext = $res2['mainmenutext'];

				 

				 $query31 = "select * from master_employeerights where employeecode = '$selectemployeecode' and mainmenuid = '$res2menuid'";

				 $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

				 $res31 = mysqli_fetch_array($exec31);

				 $rowcount31 = mysqli_num_rows($exec31);

				 if ($rowcount31 > 0)

				 {

				 	$checkedvalue1 = 'checked="checked"';

				 }

				 

				 ?>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

				<input class="mainmenucheck" id="<?php echo $res2anum; ?>" type="checkbox" name="cbmainmenu<?php echo $res2anum; ?>" <?php echo $checkedvalue1; ?> value="<?php echo $res2anum; ?>" onClick="submenucheck('<?php echo $res2anum; ?>')">

                    <strong><?php echo $res2mainmenutext; ?></strong></td>

                <td valign="middle" align="left" >&nbsp;</td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <?php

				 $query3 = "select * from master_menusub where mainmenuid = '$res2menuid' and status = '' order by submenuorder";

				 $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

				 while ($res3 = mysqli_fetch_array($exec3))

				 {

				 $res3anum = $res3['auto_number'];

				 $res3submenuid = $res3['submenuid'];

				 $res3submenutext = $res3['submenutext'];

				 

				 $query32 = "select * from master_employeerights where employeecode = '$selectemployeecode' and submenuid = '$res3submenuid'";

				 $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));

				 $res32 = mysqli_fetch_array($exec32);

				 $rowcount32 = mysqli_num_rows($exec32);

				 if ($rowcount32 > 0)

				 {

				 	$checkedvalue2 = 'checked="checked"';

				 }

				 ?>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" ><span class="bodytext3">

                  <input class="submenucheck <?php echo $res2anum; ?>" type="checkbox" name="cbsubmenu<?php echo $res3anum; ?>" <?php echo $checkedvalue2; ?> value="<?php echo $res3anum; ?>">

                  <strong><?php echo $res3submenutext; ?></strong></span></td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <?php

				 $checkedvalue2 = '';

				 }

				 ?>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <?php

				 $checkedvalue1 = '';

				 //}

				 }

				 ?>

              <tr>
              
                 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="checkbox" id="checkall" name="checkall" onClick="return check_it()"/> <span><strong>Department</strong></span></td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                
                 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

			     <?php

				 $checkedvalue3 = '';

				 $query7 = "select * from master_department where recordstatus <> 'deleted' order by auto_number";

				 $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

				 while ($res7 = mysqli_fetch_array($exec7))

				 {

				  $res7anum = $res7['auto_number'];

				 $res7department = $res7['department'];

				 

				 $query72 = "select * from master_employeedepartment where employeecode = '$selectemployeecode' and departmentanum = '$res7anum'";

				 $exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query72".mysqli_error($GLOBALS["___mysqli_ston"]));

				 $res72 = mysqli_fetch_array($exec72);

				 $rowcount72 = mysqli_num_rows($exec72);

				 if ($rowcount72 > 0)

				 {

				 	$checkedvalue3 = 'checked="checked"';

				 }

				 ?>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="checkbox" class="check_it_class" name="cbdepartment<?php echo $res7anum; ?>" <?php echo $checkedvalue3; ?> value="<?php echo $res7anum; ?>">

                  <strong><?php echo $res7department; ?></strong></td>

                <td valign="middle" align="left" ><span class="bodytext3">&nbsp;

                  </span></td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <?php

				 $checkedvalue3 = '';

				 }

				 ?>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Report Date Range Option </strong></td>

                <td align="left" valign="middle" ><select name="reports_daterange_option" id="reports_daterange_option">

                    <?php

				$query1daterange = "select * from master_employee where username = '$res7username'";

				$exec1daterange = mysqli_query($GLOBALS["___mysqli_ston"], $query1daterange) or die ("Error in Query1daterange".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res1daterange = mysqli_fetch_array($exec1daterange);

				$reports_daterange_option = $res1daterange["reports_daterange_option"];

				if ($reports_daterange_option == 'Show Date Range Option' || $reports_daterange_option == '')

				{

					echo '<option value="Show Date Range Option" selected="selected">Show Date Range Option</option>';

				}

				if ($reports_daterange_option == 'Hide Date Range Option')

				{	

					echo '<option value="Hide Date Range Option" selected="selected">Hide Date Range Option</option>';

				}

				?>

                    <option value="Show Date Range Option">Show Date Range Option</option>

                    <option value="Hide Date Range Option">Hide Date Range Option</option>

                  </select>                </td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Edit &amp; Delete Option </strong></td>

                <td align="left" valign="middle" >

				<select name="option_edit_delete" id="option_edit_delete">

                    <?php

				$query1editdelete = "select * from master_employee where username = '$res7username'";

				$exec1editdelete = mysqli_query($GLOBALS["___mysqli_ston"], $query1editdelete) or die ("Error in Query1editdelete".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res1editdelete = mysqli_fetch_array($exec1editdelete);

				$option_edit_delete = $res1editdelete["option_edit_delete"];

				if ($option_edit_delete == 'Edit Delete Option Available' || $option_edit_delete == '')

				{

					echo '<option value="Edit Delete Option Available" selected="selected">Edit Delete Option Available</option>';

				}

				if ($option_edit_delete == 'Edit Delete Option Denied')

				{	

					echo '<option value="Edit Delete Option Denied" selected="selected">Edit Delete Option Denied</option>';

				}

				?>

                    <option value="Edit Delete Option Available">Edit Delete Option Available</option>

                    <option value="Edit Delete Option Denied">Edit Delete Option Denied</option>

                  </select>                </td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <tr>

                <td align="middle" colspan="4" >&nbsp;</td>

              </tr>

            </tbody>

          </table></td>

        </tr>

        <tr>

          <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="95%" 

            align="left" border="1">

            <tbody>

              <tr>

                <td width="3%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="30%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="30%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="41%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right">

				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

                    <input type="hidden" name="frmflag1" value="frmflag1" />

                    <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />

                    <input name="Submit222" accesskey="s" type="submit"  value="Save Employee(Alt+S)" class="button"/>

                </font></font></font></font></font></div></td>

                </tr>

            </tbody>

          </table></td>

        </tr>

    </table>

                </form>
            </section>
        <?php endif; ?>
        </main>
    </div>

<script language="javascript">

function check_it()
{
if(document.getElementById("checkall").checked == true)
{
	$(".check_it_class").prop('checked',true);
}
else
{
	$(".check_it_class").prop('checked',false);
}
}



    </script>

    <!-- Modern JavaScript -->
    <script src="js/rightsaccess-modern.js?v=<?php echo time(); ?>"></script>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



