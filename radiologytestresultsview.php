<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");

$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$docnumber=$_REQUEST['docnum'];

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientname=$res78['patientfullname'];
$patientgender=$res78['gender'];
$accountname=$res78['accountname'];

        $query31 = "select * from resultentry_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber = '$docnumber' and acknowledge = 'completed' group by itemname";
		$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res31 = mysqli_fetch_array($exec31);
	  
	   $labname1=$res31['itemname'];
       $templatedata=$res31['templatedata'];
	          $docnumber=$res31['docnumber'];
?>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>

<script type="text/javascript" src="ckeditor1/ckeditor.js">

</script>
</head>
<body>

<table width="101%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
		</tr>
		<tr>
			<td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
		</tr>
		<tr>
			<td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
		</tr>
</table>

<table width="963" >		
		  <tr>
		  
		  <td>
			<?php echo $templatedata;  ?>
			</td>
		</tr>
</table>
