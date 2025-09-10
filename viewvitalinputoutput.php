<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$transactiondatefrom = date('Y-m-d', strtotime('-1 day'));
$transactiondateto = date('Y-m-d');
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';
?>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber = $_REQUEST["docnumber"];
?>
<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_visitentry where patientcode='$patientcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientaccount=$res69['accountname'];

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];


$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];
?>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcrange('<?php echo $sn; ?>')">
<form name="frm" id="frmsales" method="post" action="labresultsview.php" onKeyDown="return disableEnterKey(event)">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="0%">&nbsp;</td>
	<td width="0%">&nbsp;</td>
    <td width="84%" valign="top">
	<table width="520" border="0" cellspacing="0" cellpadding="2">
    <tr>
    <td>&nbsp;</td>
	</tr>
	
     <tr>
	  <td colspan="8" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext365">
				 <strong>INPUT / OUTPUT </strong></td> 
     </tr>
				  
				   <tr>
		    <td width="10%" class="bodytext366" valign="center"  align="center" 
                bgcolor="#ffffff"><strong>Date</strong></td>
			<td width="10%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><strong>Time</strong></td>
			<td width="10%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><strong>IV</strong></td>
			<td width="10%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><strong>Fluid</strong></td>
			<td width="10%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><strong>Vomitus</strong></td>
			<td width="10%"  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext366"><strong>Urine</strong></td>
			<td width="10%"  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext366"><strong>Secretion</strong></td>
			<td width="10%"  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext366"><strong>Blood Transfusion</strong></td>
		  </tr>
				  <?php
      $query31="select * from ip_vitalio where patientcode = '$patientcode' and visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc";
	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);
	  $num=mysqli_num_rows($exec31);
	  while($res31=mysqli_fetch_array($exec31))
	  { 
       $recorddate=$res31['recorddate'];
	   $recorddate=date("d/m/Y");
	   $recordtime=$res31['recordtime'];
       $ivres=$res31['iv'];
       $iv[]=$ivres;
       $ivtotal = array_sum($iv);

	   $fluidsres=$res31['fluids'];
       $fluids[] =$fluidsres;
       $fluidstotal = array_sum($fluids);

	   $vomitusres=$res31['vomitus'];
	   $vomitus[]=$vomitusres;
       $vomitustotal = array_sum($vomitus);

	   $urineres=$res31['urine'];
       $urine[]=$urineres;
       $urinetotal = array_sum($urine);

	   $secretionres=$res31['secretion'];
	    $secretion[]=$secretionres;
       $secretiontotal = array_sum($secretion);
	   
	    $bloodres=$res31['bloodtransfusion'];
	    $blood[]=$bloodres;
       $bloodtotal = array_sum($blood);

       
	$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			?>
          <tr <?php echo $colorcode; ?>>
		 
		  <td height="10" width="12%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $recorddate; ?></td>
		   <td width="10%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $recordtime; ?></td>
		  <td width="10%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $ivres; ?></td>
		  <td width="10%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $fluidsres; ?></td>
	      <td width="10%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $vomitusres; ?></td>
		  <td width="10%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $urineres; ?></td>    
		<td width="10%"  align="center" valign="center" 
				class="bodytext366"><?php echo $secretionres; ?></td>
		<td width="40%"  align="center" valign="center" 
				class="bodytext366"><?php echo $bloodres; ?></td>
		</tr>
		  <?php
		 }
		 ?>
		  
		  	<tr>
		      <td colspan="2" align="center" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
			   <td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong><?php echo $ivtotal; ?></strong></td>
				 <td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong><?php echo $fluidstotal; ?></strong></td>
				  <td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong><?php echo $vomitustotal; ?></strong></td>
				   <td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong><?php echo $urinetotal; ?></strong></td>
			        <td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><span class="style3"><?php echo $secretiontotal; ?></span></td>
					<td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><span class="style3"><?php echo $bloodtotal; ?></span></td>
		   </tr>
           <tr><td>&nbsp;</td></tr> 
		   <tr>
		    <?php $alltotal = $ivtotal + $fluidstotal + $bloodtotal; ?>
			<?php $alltotal1 = $vomitustotal + $urinetotal + $secretiontotal; ?>
			
		      <td colspan = "2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>Total IV: <?php echo $alltotal; ?></strong></td>
		   </tr>

		   <tr>
		      <td colspan = "2"  align="right" valign="middle"  bgcolor="#ecf0f5" class="style1">Total Vo: <?php echo $alltotal1; ?></td>
		   </tr>
		     <tr>
		      <td colspan = "2"  align="right" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
		   </tr>
			   <tr>
                <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">User Name:
               <input type="hidden" name="user" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>" readonly="readonly"><?php echo strtoupper($_SESSION['username']); ?></td>
               </tr>
		  </table>
	  </td>
    <td width="16%" valign="top">&nbsp;</td>
	</tr>
  </table>   

</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>