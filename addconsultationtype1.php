<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
//include ("includes/check_user_access.php");
$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



$docno = $_SESSION['docno'];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";  

$subtype = "";

$paymenttype = "";

$recorddate = "";

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }




if (isset($_REQUEST["searchdepartmentname"])) { $searchdepartmentname = $_REQUEST["searchdepartmentname"]; } else { $searchdepartmentname = ""; }

if (isset($_REQUEST["searchdepartmentcode"])) { $searchdepartmentcode = $_REQUEST["searchdepartmentcode"]; } else { $searchdepartmentcode = ""; }

if (isset($_REQUEST["searchdepartmentanum"])) { $searchdepartmentanum = $_REQUEST["searchdepartmentanum"]; } else { $searchdepartmentanum = ""; }

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

 	

	$consultationtype = $_REQUEST["consultationtype"];

	$doctorcode = $_REQUEST["consultationdoctorcode"];

	$doctorname = $_REQUEST["consultationdoctorname"];

	

	$locationcode = $_REQUEST["location"];

	$department = $_REQUEST["department"];

	$consultationfees = $_REQUEST["consultationfees"];

	$default = isset($_REQUEST['default'])?$_REQUEST['default']:'';

	$paymenttype = $_REQUEST['paymenttype'];

	$subtype = $_REQUEST['subtype'];

	$consultationtype = strtoupper($consultationtype);

	$consultationtype = trim($consultationtype);

	$length=strlen($consultationtype);

	$loccode= explode('-',$locationcode);

	

	//$location = $loccode[1];
	$location = $locationcode;

	if ($length<=100)

	{

	

		
		$depart_count=isset($_REQUEST['depart_count'])?$_REQUEST['depart_count']:'';
		
		for($i=1; $i<$depart_count; $i++)
		{
		$deptget=isset($_REQUEST['dept'.$i])?$_REQUEST['dept'.$i]:'';
		$cons_name=isset($_REQUEST['consname'.$i])?$_REQUEST['consname'.$i]:'';
				
		$query181 = "select locationcode from master_location where status <> 'deleted' order by auto_number asc";
		$exec181 = mysqli_query($GLOBALS["___mysqli_ston"], $query181) or die ("Error in Query181".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		while ($res181 = mysqli_fetch_array($exec181))
		{
		$loccodeget=$res181['locationcode'];
		
		$loc_review=isset($_REQUEST['locrate'.$i.$loccodeget])?$_REQUEST['locrate'.$i.$loccodeget]:'';
		$locrateget=$loc_review;
		if($deptget!='' && $loc_review!='')
		{
			
			 $query1s2 = "select auto_number from master_consultationtype where  department='$deptget' and paymenttype='$paymenttype' and subtype='$subtype' and condefault='0'";
		$exec1s2 = mysqli_query($GLOBALS["___mysqli_ston"], $query1s2) or die ("Error in query1s2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1s2 = mysqli_num_rows($exec1s2);
		
		if($num1s2<=0)
		{	
		  $query1 = "insert into master_consultationtype (consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$cons_name', '$deptget','$doctorcode','$doctorname','$consultationfees','$ipaddress','$recorddate', '$username','$loccodeget','$loccodeget','0','$paymenttype','$subtype')"; 

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}

		$query1s = "select auto_number from master_consultationtype where  department='$deptget'and paymenttype='$paymenttype' and subtype='$subtype' and condefault='0' order by auto_number desc limit 1";
		$exec1s = mysqli_query($GLOBALS["___mysqli_ston"], $query1s) or die ("Error in query1s".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1s = mysqli_num_rows($exec1s);
		$res1s = mysqli_fetch_array($exec1s);
		$consultation_id=$res1s['auto_number'];
		 
		if($num1s==1)
		{	
	  $query155 = "insert into  locationwise_consultation_fees (consultation_id, department, doctorcode,doctorname, locationcode, consultationfees,review,subtype,maintype) values ('$consultation_id', '$deptget', '$doctorcode','$doctorname', '$loccodeget', '$locrateget','0','$subtype','$paymenttype')";
	$exec155 = mysqli_query($GLOBALS["___mysqli_ston"], $query155) or die ("Error in Query155".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		 
		}
	  }
		
		$errmsg = "Success. New Consultation Type Updated.";

		$bgcolorcode = 'success';

		

	
		}
		
		
		for($j=1; $j<$depart_count; $j++)
		{
		$deptget=isset($_REQUEST['dept'.$j])?$_REQUEST['dept'.$j]:'';
		$cons_name1=isset($_REQUEST['consname'.$j])?$_REQUEST['consname'.$j]:'';
		$cons_name=$cons_name1.' Review';
				
		$query181 = "select locationcode from master_location where status <> 'deleted' order by auto_number asc";
		$exec181 = mysqli_query($GLOBALS["___mysqli_ston"], $query181) or die ("Error in Query181".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		while ($res181 = mysqli_fetch_array($exec181))
		{
		$loccodeget=$res181['locationcode'];
		
		$loc_review=isset($_REQUEST['locreview'.$j.$loccodeget])?$_REQUEST['locreview'.$j.$loccodeget]:'';
		$locrateget=$loc_review;
		if($deptget!='' && $loc_review!='')
		{
			
			 $query1s1 = "select auto_number from master_consultationtype where  department='$deptget' and paymenttype='$paymenttype' and subtype='$subtype' and condefault='1'";
		$exec1s1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1s1) or die ("Error in query1s1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1s1 = mysqli_num_rows($exec1s1);
		
		if($num1s1<=0)
		{	
		  $query1 = "insert into master_consultationtype (consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$cons_name', '$deptget','$doctorcode','$doctorname','$consultationfees','$ipaddress','$recorddate', '$username','$loccodeget','$loccodeget','1','$paymenttype','$subtype')"; 

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}

		$query1s = "select auto_number from master_consultationtype where  department='$deptget' and paymenttype='$paymenttype' and subtype='$subtype' and condefault='1' order by auto_number desc limit 1";
		$exec1s = mysqli_query($GLOBALS["___mysqli_ston"], $query1s) or die ("Error in query1s".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1s = mysqli_num_rows($exec1s);
		$res1s = mysqli_fetch_array($exec1s);
		$consultation_id=$res1s['auto_number'];
		if($num1s>=1 && $num1s<3)
		{ 
		$query1sw = "select auto_number from master_consultationtype where  department='$deptget'  and paymenttype='$paymenttype' and subtype='$subtype' and condefault='1'";
		$exec1sw = mysqli_query($GLOBALS["___mysqli_ston"], $query1sw) or die ("Error in query1sw".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1sw = mysqli_num_rows($exec1sw);
		}
		if($num1sw==1)
			{
	   $query155 = "insert into  locationwise_consultation_fees (consultation_id, department, doctorcode,doctorname, locationcode, consultationfees,review,subtype,maintype) values ('$consultation_id', '$deptget', '$doctorcode','$doctorname', '$loccodeget', '$locrateget','1','$subtype','$paymenttype')";
	$exec155 = mysqli_query($GLOBALS["___mysqli_ston"], $query155) or die ("Error in Query155".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		 
		}
	  }
		
		$errmsg = "Success. New Consultation Type Updated.";

		$bgcolorcode = 'success';

		

	
		}
		
		
		
		
		
	}

	else

	{

		$errmsg = "Failed. Only 100 Characters Are Allowed.";

		$bgcolorcode = 'failed';

	}
	


}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_consultationtype set recordstatus = 'deleted' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_consultationtype set recordstatus = '' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'default')

{

	$delanum = $_REQUEST["anum"];

	$query4 = "update master_consultationtype set defaultstatus = '' where cstid='$custid' and cstname='$custname'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));



	$query5 = "update master_consultationtype set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'removedefault')

{

	$delanum = $_REQUEST["anum"];

	$query6 = "update master_consultationtype set defaultstatus = '' where auto_number = '$delanum'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

}




if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }

if ($svccount == 'firstentry')

{

	$errmsg = "Please Add Consultation Type To Proceed For Billing.";

	$bgcolorcode = 'failed';

}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Consultation Type - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/addconsultationtype1-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


<link href="js/jquery-ui.css" rel="stylesheet">

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

    <!-- External JavaScript -->
    <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
</head>

<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Add Consultation Type</p>
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
        <span>Add Consultation Type</span>
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
                    <li class="nav-item">
                        <a href="iframeconsultationlist.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Consultation List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="viewconsultationbills.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>View Consultation Bills</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="addconsultationtype1.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Consultation Type</span>
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
                    <h2>Add Consultation Type</h2>
                    <p>Create and manage consultation types with department-specific pricing and location-based fees.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Loading Overlay -->
            <div align="center" class="loading-overlay" id="imgloader" style="display:none;">
                <div class="loading-content">
                    <div class="loading-spinner"></div>
                    <p id='claim_msg'></p>
                    <p><strong>Processing<br><br>Please be patient...</strong></p>
                </div>
            </div>

            <!-- Consultation Type Form Section -->
            <div class="consultation-form-section">
                <div class="form-header">
                    <div class="form-title">Consultation Type Master - Add New</div>
                </div>

                <!-- Location Management Section -->
                <div class="location-management-section">
                    <div class="section-title">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Location Management</span>
                    </div>
                    <div class="location-form-row">
                        <div class="form-group">
                            <label class="form-label">From Location</label>
                            <div class="location-display" id="ajaxlocation">
                                <?php
                                $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res1 = mysqli_fetch_array($exec1);
                                echo $res1location = $res1["locationname"];
                                $res1llocationcode = $res1["locationcode"];
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">To Location</label>
                            <select name="location_main" id="location_main" class="form-select">
                                <option value="">Select Target Location</option>
                                <?php
                                $query6 = "select * from master_location where status = '' and locationcode!='$res1llocationcode' order by auto_number asc";
                                $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res6 = mysqli_fetch_array($exec6)) {
                                    $res6anum = $res6["auto_number"];
                                    $res6location = $res6["locationname"];
                                    $locationcode = $res6["locationcode"];
                                    
                                    $query1s2 = "select auto_number from master_consultationtype where locationcode='$locationcode'";
                                    $exec1s2 = mysqli_query($GLOBALS["___mysqli_ston"], $query1s2) or die ("Error in query1s2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $num1s2 = mysqli_num_rows($exec1s2);
                                    if($num1s2<=0) {
                                ?>
                                <option value="<?php echo $locationcode; ?>"><?php echo $res6location; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" id="update_it" name="update_it" class="btn btn-primary" onClick="update_value('<?php echo $res1llocationcode;?>')">
                                <i class="fas fa-sync"></i> Update Location
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Alert Message -->
                <?php if ($errmsg != "") { ?>
                <div class="alert <?php echo ($bgcolorcode == 'success') ? 'alert-success' : (($bgcolorcode == 'failed') ? 'alert-error' : 'alert-info'); ?>">
                    <?php echo $errmsg; ?>
                </div>
                <?php } ?>

                <!-- Consultation Details Section -->
                <div class="consultation-details-section">
                    <div class="section-title">
                        <i class="fas fa-stethoscope"></i>
                        <span>Consultation Details</span>
                    </div>
                    
                    <form name="form1" id="form1" method="post" action="addconsultationtype1.php" onSubmit="return addward1process1()" class="consultation-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="paymenttype" class="form-label">
                                    <i class="fas fa-tag"></i> Main Type
                                </label>
                                <select name="paymenttype" id="paymenttype" onChange="return funcPaymentTypeChange1();" class="form-select" required>
                                    <option value="" selected="selected">Select Main Type</option>  
                                    <?php
                                    $query5 = "select * from master_paymenttype where recordstatus = '' order by paymenttype";
                                    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res5 = mysqli_fetch_array($exec5)) {
                                        $res5anum = $res5["auto_number"];
                                        $res5paymenttype = $res5["paymenttype"];
                                    ?>
                                    <option value="<?php echo $res5anum; ?>"><?php echo $res5paymenttype; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="search_subtype" class="form-label">
                                    <i class="fas fa-list"></i> Sub Type
                                </label>
                                <input type="hidden" name="subtype" id="subtype" value="" />
                                <input type="text" name="search_subtype" id="search_subtype" value="" class="form-input" autocomplete="off" placeholder="Select main type first" />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="consultationdoctorname" class="form-label">
                                    <i class="fas fa-user-md"></i> Consultation Doctor
                                </label>
                                <input type="text" name="consultationdoctorname" id="consultationdoctorname" class="form-input" autocomplete="off" placeholder="Enter doctor name" />
                                <input type="hidden" name="consultationdoctorcode" id="consultationdoctorcode" />
                            </div>
                            
                            <div class="form-group" style="display:none">
                                <label for="location" class="form-label">Location</label>
                                <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" class="form-select">
                                    <?php
                                    $query6 = "select * from master_location where status = '' order by auto_number asc";
                                    $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res6 = mysqli_fetch_array($exec6)) {
                                        $res6anum = $res6["auto_number"];
                                        $res6location = $res6["locationname"];
                                        $locationcode = $res6["locationcode"];
                                    ?>
                                    <option value="<?php echo $locationcode; ?>"><?php echo $res6location; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Department and Location Grid -->
                        <div class="department-location-grid">
                            <div class="grid-header">
                                <div class="grid-title">
                                    <i class="fas fa-building"></i>
                                    <span>Department-wise Consultation Types and Location Fees</span>
                                </div>
                                <div class="grid-description">
                                    Select departments and set consultation fees for each location
                                </div>
                            </div>
                        <table class="grid-table">
                            <thead>
                                <tr>
                                    <th>Department</th>
                                    <?php 
                                    $query1 = "select locationcode,locationname,prefix,suffix from master_location where status <> 'deleted' order by auto_number asc";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $incr=0;
                                    while ($res1 = mysqli_fetch_array($exec1)) {
                                        $locationcode = $res1["locationcode"];
                                        $locationname = $res1["locationname"];
                                        $incr=$incr+1;  
                                    ?>
                                    <th><?php echo $locationname;?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                $query12 = "select auto_number,department from master_department where recordstatus='' order by auto_number";
                                $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $dcr=1;
                                while ($res12 = mysqli_fetch_array($exec12)) {
                                    $department_code = $res12["auto_number"];
                                    $department_name = $res12["department"];
                                    $cons_type=$department_name.' Consultation';
                                ?>
                                <tr class="department-row">
                                    <td>
                                        <input type="checkbox" name="dept<?php echo $dcr;?>" id="dept<?php echo $dcr;?>" class="department-checkbox" value="<?php echo $department_code;?>"/>
                                        <span class="department-name"><?php echo $department_name;?></span>
                                        <input type="text" name="consname<?php echo $dcr;?>" id="consname<?php echo $dcr;?>" class="consultation-type-input" placeholder="Consultation Type" value="<?php echo $cons_type; ?>">
                                    </td>
                                    <?php 
                                    $query1 = "select locationcode from master_location where status <> 'deleted' order by auto_number asc";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    
                                    while ($res1 = mysqli_fetch_array($exec1)) {
                                        $locationcode = $res1["locationcode"];
                                    ?>
                                    <td>
                                        <input type="text" name="locrate<?php echo $dcr;?><?php echo $locationcode;?>" id="locrate<?php echo $dcr;?><?php echo $locationcode;?>" class="fee-input" placeholder="Main" onKeyPress="return validatenumerics(event);">
                                        <input type="text" name="locreview<?php echo $dcr;?><?php echo $locationcode;?>" id="locreview<?php echo $dcr;?><?php echo $locationcode;?>" class="fee-input" placeholder="Review" onKeyPress="return validatenumerics(event);">
                                    </td>
                                    <?php }?>
                                </tr>
                                <?php
                                $dcr++;
                                }?>
                            </tbody>
                        </table>
                    </div>

                        <input type="hidden" name="locationcount" id="locationcount" value="<?php echo $incr;?>">     
                        <input type="hidden" name="discountcount" id="discountcount" value="<?php echo $department_code;?>">			  
                        <input type="hidden" name="depart_count" id="depart_count" value="<?php echo $dcr;?>">			  

                        <div class="form-actions">
                            <input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                            <input type="hidden" name="scrollfunc" id="scrollfunc" value="getdata">
                            <input type="hidden" name="serialno" id="serialno" value="50">
                            <input type="hidden" name="department" id="department" value="">
                            
                            <div class="action-buttons">
                                <button type="button" class="btn btn-outline" onclick="clearForm()">
                                    <i class="fas fa-eraser"></i> Clear Form
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Consultation Types
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search Section -->
            <div class="search-section">
                <div class="search-header">
                    <div class="search-title">Search Existing Consultation Types</div>
                </div>
                
                <form name="form12" id="form12" method="post" action="addconsultationtype1.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Subtype</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" class="form-input" autocomplete="off" onKeyUP="clearsubtypecode()">
                            <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" />
                            <input type="hidden" name="searchsupplieranum" id="searchsupplieranum" value="<?php echo $searchsupplieranum; ?>" />
                        </div>
                        
                        <div class="form-group" style="display:none">
                            <label for="searchdepartmentname" class="form-label">Department</label>
                            <input name="searchdepartmentname" type="text" id="searchdepartmentname" value="<?php echo $searchdepartmentname; ?>" onKeyUP="cleardepartmentcode()" class="form-input" autocomplete="off">
                            <input type="hidden" name="searchdepartmentcode" id="searchdepartmentcode" value="<?php echo $searchdepartmentcode; ?>" />
                            <input type="hidden" name="searchdepartmentanum" id="searchdepartmentanum" value="<?php echo $searchdepartmentanum; ?>" />
                        </div>
                        
                        <div class="form-group">
                            <input type="hidden" name="frmflag2" value="search" />
                            <input type="hidden" name="frmflag12" value="frmflag12" />
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div class="results-section">
                <div class="results-header">
                    <div class="results-title">Consultation Types</div>
                    <div class="results-actions">
                        <button type="button" class="btn btn-outline" onclick="printReport()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>

                <!-- Pagination Controls -->
                <div class="pagination-controls">
                    <div class="pagination-info">
                        <span>Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalRecords">0</span> entries</span>
                    </div>
                    <div class="pagination-buttons">
                        <button type="button" class="btn btn-sm btn-outline" id="prevPage" onclick="changePage(-1)">
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                        <span class="page-numbers" id="pageNumbers"></span>
                        <button type="button" class="btn btn-sm btn-outline" id="nextPage" onclick="changePage(1)">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Main Type</th>
                            <th>Sub Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id='insertplan'>
                        <?php
                        // Pagination variables
                        $recordsPerPage = 10;
                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($currentPage - 1) * $recordsPerPage;
                        
                        // Build query based on search parameters
                        if($searchsupplieranum=='' && $searchdepartmentanum==''){
                            $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department Like '%$searchdepartmentanum%' and subtype Like '%$searchsupplieranum%' group by subtype order by auto_number";
                        } else {
                            if($searchdepartmentanum==''){
                                $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department Like '%$searchdepartmentanum%' and subtype = '$searchsupplieranum' group by subtype order by auto_number";
                            } else {
                                if($searchsupplieranum==''){
                                    $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department = '$searchdepartmentanum' and subtype Like '%$searchsupplieranum%' group by subtype order by auto_number";
                                } else {
                                    $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department = '$searchdepartmentanum' and subtype = '$searchsupplieranum' group by subtype order by auto_number";
                                }
                            }
                        }
                        
                        // Get total count for pagination
                        $countQuery = str_replace("select *", "select COUNT(*) as total", $query1);
                        $countResult = mysqli_query($GLOBALS["___mysqli_ston"], $countQuery) or die ("Error in Count Query".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $totalRecords = mysqli_fetch_array($countResult)['total'];
                        $totalPages = ceil($totalRecords / $recordsPerPage);
                        
                        // Add pagination to main query
                        $query1 .= " LIMIT $recordsPerPage OFFSET $offset";
                        
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $rowCount = 0;
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $rowCount++;
                            $auto_number = $res1["auto_number"];  
                            $consultationtype = $res1["consultationtype"];
                            $departmentanum = $res1["department"];
                            $consultationfees = $res1["consultationfees"];
                            $res1paymenttype = $res1["paymenttype"];
                            $res1subtype = $res1['subtype'];
                            $res1location = $res1['locationname']; 
                            $res1doctorcode = $res1['doctorcode'];
                            $res1doctor = $res1['doctorname'];
                            
                            $query = "select * from master_location where auto_number='$res1location'";
                            $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res = mysqli_fetch_array($exec);
                            $loc=$res['locationname'];
                            
                            $query2 = "select * from master_department where auto_number = '$departmentanum'";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res2 = mysqli_fetch_array($exec2);
                            $department = $res2['department'];
                            
                            $query3 = "select * from master_paymenttype where auto_number = '$res1paymenttype'";
                            $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res3 = mysqli_fetch_array($exec3);
                            $res3paymenttype = $res3['paymenttype'];
                            
                            $query4 = "select * from master_subtype where auto_number = '$res1subtype'";
                            $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res4 = mysqli_fetch_array($exec4);
                            $res4subtype = $res4['subtype'];
                        ?>
                        <tr class="<?php echo ($rowCount % 2 == 0) ? 'even-row' : 'odd-row'; ?>">
                            <td><?php echo htmlspecialchars($res3paymenttype); ?></td>
                            <td><?php echo htmlspecialchars($res4subtype); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="editconsultationtype1.php?st=edit&&anum=<?php echo $auto_number; ?>&&subtype_edit=<?php echo $res1subtype; ?>&&maintype_edit=<?php echo $res1paymenttype; ?>" class="action-link">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="cloneconsultation.php?st=edit&&anum=<?php echo $auto_number; ?>&&subtype_edit=<?php echo $res1subtype; ?>&&maintype_edit=<?php echo $res1paymenttype; ?>" class="action-link">
                                        <i class="fas fa-copy"></i> Copy
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        }
                        
                        if($rowCount == 0) {
                        ?>
                        <tr>
                            <td colspan="3" class="empty-state">
                                <i class="fas fa-search"></i>
                                <h4>No Consultation Types Found</h4>
                                <p>No consultation types match your search criteria.</p>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                
                <!-- Pagination Controls Bottom -->
                <div class="pagination-controls">
                    <div class="pagination-info">
                        <span>Showing <span id="showingStartBottom">1</span> to <span id="showingEndBottom">10</span> of <span id="totalRecordsBottom">0</span> entries</span>
                    </div>
                    <div class="pagination-buttons">
                        <button type="button" class="btn btn-sm btn-outline" id="prevPageBottom" onclick="changePage(-1)">
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                        <span class="page-numbers" id="pageNumbersBottom"></span>
                        <button type="button" class="btn btn-sm btn-outline" id="nextPageBottom" onclick="changePage(1)">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/addconsultationtype1-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>