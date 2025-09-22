<?php

session_start();   

include ("includes/loginverify.php");

include ("db/db_connect.php");

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');
// $updatedate = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{



	$drug_inst = $_REQUEST["drug_inst"];

	//$salutation = strtoupper($salutation);

	$drug_inst = trim($drug_inst);

	$length=strlen($drug_inst);

	//echo $length;

	if ($length<=100)

	{
		$drug_inst=strtolower($drug_inst);
		$drug_inst=ucwords($drug_inst);
	$query2 = "select id from dose_measure where name = '$drug_inst'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 == 0)

	{

		$query1 = "insert into dose_measure ( `name`, `ipaddress`, `username`, `created_on`) 

		values ('$drug_inst', '$ipaddress', '$username','$updatedatetime')";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. New Dose Measure was Created.";

		$bgcolorcode = 'success';

		

	}

	//exit();

	else

	{

		$errmsg = "Failed. Dose Measure Already Exists.";

		$bgcolorcode = 'failed';

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

	$query3 = "update dose_measure set status = '0' where id = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update dose_measure set status = '1' where id = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

/*if ($st == 'default')

{

	$delanum = $_REQUEST["anum"];

	$query4 = "update product_type set defaultstatus = '' where cstid='$custid' and cstname='$custname'";

	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());



	$query5 = "update master_salutation set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";

	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());

}*/

/*if ($st == 'removedefault')

{

	$delanum = $_REQUEST["anum"];

	$query6 = "update master_salutation set defaultstatus = '' where auto_number = '$delanum'";

	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());

}

*/









?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dose Measure Master - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/dose-measure-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>



<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>

<script language="javascript">



function addsalutation1process1()

{

	//alert ("Inside Funtion");

	var drug_inst = document.form1.drug_inst.value;

	drug_inst = drug_inst.replace(/^\s+|\s+$/g, '' );

	if(drug_inst == "")

	{

		alert ("Please Enter Dose Measure.");

		document.form1.drug_inst.focus();

		return false;

	}

	

}



function funcDeleteProductType(varNameAutoNumber)

{

     var varNameAutoNumber = varNameAutoNumber;

	 var fRet;

	fRet = confirm('Are you sure want to delete this Dose Measure '+varNameAutoNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Dose Measure Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Dose Measure Entry Delete Not Completed.");

		return false;

	}



}







</script>

<!-- Modern JavaScript -->
<script src="js/dose-measure-modern.js?v=<?php echo time(); ?>"></script>

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
        <span>Dose Measure Master</span>
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
                        <a href="dose_measure.php" class="nav-link active">
                            <i class="fas fa-pills"></i>
                            <span>Dose Measure Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="drug_instruction.php" class="nav-link">
                            <i class="fas fa-prescription-bottle"></i>
                            <span>Drug Instructions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="medicine_master.php" class="nav-link">
                            <i class="fas fa-capsules"></i>
                            <span>Medicine Master</span>
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
                    <h2>Dose Measure Master</h2>
                    <p>Manage dose measurement units for medication administration and prescription management.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printPage()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Add New Dose Measure Form Section -->
            <div class="form-section">
                <div class="form-header">
                    <i class="fas fa-plus-circle form-icon"></i>
                    <h3 class="form-title">Add New Dose Measure</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="dose_measure.php" onSubmit="return addsalutation1process1()">
                    <div class="form-group">
                        <label for="drug_inst" class="form-label">Dose Measure Name</label>
                        <input name="drug_inst" id="drug_inst" class="form-input" 
                               placeholder="Enter dose measure (e.g., mg, ml, tablets)" 
                               autocomplete="off" maxlength="100" />
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-save"></i>
                            Add Dose Measure
                        </button>
                    </div>
                </form>
            </div>

            <!-- Active Dose Measures Section -->
            <div class="data-section">
                <div class="data-header">
                    <h3 class="data-title">Active Dose Measures</h3>
                    <div class="data-actions">
                        <span class="status-badge status-active">Active</span>
                    </div>
                </div>
                
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Dose Measure Name</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query1 = "select id,name from dose_measure where status='1' order by id desc ";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $drug_inst = $res1["name"];
                            $auto_number = $res1["id"];
                        ?>
                        <tr>
                            <td>
                                <a href="dose_measure.php?st=del&&anum=<?php echo $auto_number; ?>" 
                                   onClick="return funcDeleteProductType('<?php echo $auto_number; ?>')" 
                                   class="action-btn action-btn-delete">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($drug_inst); ?></td>
                            <td>
                                <a href="edit_dose_measure.php?st=edit&&anum=<?php echo $auto_number; ?>" 
                                   class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Deleted Dose Measures Section -->
            <div class="data-section">
                <div class="data-header">
                    <h3 class="data-title">Deleted Dose Measures</h3>
                    <div class="data-actions">
                        <span class="status-badge status-inactive">Inactive</span>
                    </div>
                </div>
                
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Dose Measure Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query1 = "select id,name from dose_measure where status = 0 order by id desc ";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $drug_inst = $res1['name'];
                            $auto_number = $res1["id"];
                        ?>
                        <tr>
                            <td>
                                <a href="dose_measure.php?st=activate&&anum=<?php echo $auto_number; ?>" 
                                   class="action-btn action-btn-activate">
                                    <i class="fas fa-undo"></i>
                                    Activate
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($drug_inst); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>



