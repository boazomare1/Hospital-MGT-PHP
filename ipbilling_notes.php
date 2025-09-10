<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
 $updatedatetime = date('Y-m-d H:m');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';

 

 

$ipvist_autonumber = $_REQUEST['ipvist_autonumber'];
 
if (isset($_REQUEST["save"]))
{
    $editor1=$_REQUEST['editor1'];
	 
		 
		 
		 
		$query65="UPDATE `master_ipvisitentry` SET `billing_notes`='$editor1' where auto_number='$ipvist_autonumber'";
		$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		?>
		<script type="text/javascript">window.close();</script>
		<?php

	// header("location:.php");
	// exit;
	
}


 
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
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<?php include ("js/dropdownlistipbilling.php"); ?>
<script type="text/javascript" src="js/autosuggestipbilling.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>
 
 
 

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
td{
	padding-left: 50px;
}
</style>
</head>

 
<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>
<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
	<br>
	<h4 align="center">Billing Notes</h4>
	 
 

	<?php
	$ipvist_autonumber = $_REQUEST['ipvist_autonumber'];
		$query82 = "SELECT * from master_ipvisitentry where auto_number='$ipvist_autonumber' ";
		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res82 = mysqli_fetch_array($exec82);
		   // $date = $res82['consultationdate'];
		   $patientcode = $res82['patientcode'];
		   $visitcode = $res82['visitcode'];
		   $patientfullname = $res82['patientfullname'];
		   // $patientlocationcode = $res82['locationcode'];
		   $billing_notes = $res82['billing_notes'];
						 
	?>
    <table>
    	<tr>
    		<td>Name : <b><?=$patientfullname?></b></td>
    		<td>Reg no. : <b><?=$patientcode; ?></b></td>
    		<td>Visit Code : <b><?=$visitcode; ?></b></td>
    	</tr>
    </table>
				<form method="POST">
				<textarea id="consultation" cols='50' rows='15' class="ckeditor" name="editor1">
					<?php if($billing_notes==""){ ?>
						<b><?php echo ucwords($username).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$updatedatetime;?></b>
						<br>
					<?php } ?>
					<?=$billing_notes;?>
					</textarea>
				 
				  
                  <p style="float: right;"> <input   type="submit" value="Save" name="save"/></p>
                  </form>
           
 
<?php include ("includes/footer1.php"); ?>
</body>
</html>

