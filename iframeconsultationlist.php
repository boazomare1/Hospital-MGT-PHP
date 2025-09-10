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

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.number1

{

text-align:right;

padding-left:700px;

}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script language="javascript">



function cbcustomername1()

{

	document.cbform1.submit();

}



</script>

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

    <!-- Main Container -->
    <div class="main-container">



<?php $query12= "select * from master_triage where  locationcode='$locationcode' and triagestatus = 'completed' and overallpayment='' and consultationdate >= NOW() - INTERVAL 2 DAY order by consultationdate DESC";

			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res12=mysqli_num_rows($exec12);

			?>

<table width="103%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9">:&nbsp;&nbsp;</td>

  </tr>

  <tr>

                 <td colspan="2" class="modern-list-container">

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
                            <div class="loading-placeholder">
                                <i class="fas fa-spinner fa-spin"></i>
                                <p>Loading consultation list...</p>
                            </div>
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
                            <div class="loading-placeholder">
                                <i class="fas fa-spinner fa-spin"></i>
                                <p>Loading published list...</p>
                            </div>
                        </div>
                    </div>

                  </td>



			  </tr>

	

  </table>

    </div>

    <!-- Modern JavaScript -->
    <script src="js/iframeconsultationlist-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



