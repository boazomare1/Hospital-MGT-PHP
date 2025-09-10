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
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';
?>

<?php
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
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
</style>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
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
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="1322" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="1281" colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#ecf0f5'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td colspan="8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><table width="99%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="8" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>CASE SHEET </strong></td>
                <td align="center" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
               
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
              </tr>
              <tr>
			  <?php
				$query1="select * from master_visitentry where visitcode = '$visitcode'";
				$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1);
				$res1=mysqli_fetch_array($exec1);
				$patientfullname = $res1['patientfullname'];
				$patientfullname = strtoupper($patientfullname);
				$patientcode = $res1['patientcode'];
				$consultationdate = $res1['consultationdate'];
				$department = $res1['departmentname'];
				$age = $res1['age'];
				$gender = $res1['gender'];
				
				$query19="select * from master_triage where visitcode = '$visitcode'";
				$exec19=mysqli_query($GLOBALS["___mysqli_ston"], $query19);
				$res19=mysqli_fetch_array($exec19);
				$user = $res19['user'];
				$height = $res19['height'];
				$weight = $res19['weight'];
				$bmi = $res19['bmi'];
				$bpsystolic = $res19['bpsystolic'];
				$bpdiastolic = $res19['bpdiastolic'];
				$respiration = $res19['respiration'];
				$pulse = $res19['pulse'];
				$celsius = $res19['celsius'];
				$spo2 = $res19['spo2'];
				$intdrugs = $res19['intdrugs'];
				$dose = $res19['dose'];
				$route = $res19['route'];
			  ?>
                <td width="4%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>Patient</strong></td>
                <td width="20%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $patientfullname; ?>, <?php echo $age; ?>, <?php echo $gender; ?></td>
                <td width="6%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Reg.No</td>
                <td width="16%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $patientcode; ?></td>
                <td width="4%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Visit</td>
                <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $visitcode; ?></td>
                <td width="4%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Date</td>
                <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $consultationdate; ?></td>
                <td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Nurse</td>
                <td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo strtoupper($user); ?></td>
              </tr>
            </table>			</td>
         
			</tr>
            <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td width="58" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td width="67">&nbsp;</td>
          </tr>
          
 <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>Vitals</strong></td>
            <td align="left" class="bodytext32" colspan="7">
			<?php if($height!=0) { ?>Height(<label style="color:black;"><?php echo $height; ?>)&nbsp; </label><?php }?>
			<?php if($weight!=0) { ?>Weight(<label style="color:black;"><?php echo $weight; ?>)&nbsp; </label><?php }?>
			<?php if($bmi!=0) { ?>BMI(<label style="color:black;"><?php echo $bmi; ?>)&nbsp; </label><?php }?>
			
			<?php if($bpsystolic!=0) { ?>bp(<label style="color:black;"><?php echo $bpsystolic; ?>/</label><?php }?>

			<?php if($bpdiastolic!=0) { ?><label style="color:black;"><?php echo $bpdiastolic; ?>) </label><?php }?>
			
			<?php if($respiration!=0) { ?>Resp(<label style="color:black;"><?php echo $respiration; ?>)&nbsp; </label><?php }?>
			
			<?php if($pulse!=0) { ?>Pulse(<label style="color:black;"><?php echo $pulse; ?>)&nbsp; </label><?php }?>
			
			<?php if($celsius!=0) { ?>Celsius(<label style="color:black;"><?php echo $celsius; ?>)&nbsp; </label><?php }?>
			
			<?php if($spo2!=0) { ?>Spo2(<label style="color:black;"><?php echo $spo2; ?>)&nbsp; </label><?php }?>
			
			<?php if($height !=0 && $weight!=0 && $bmi!=0 && $bpsystolic!=0 && $bpdiastolic !=0 && $respiration !=0 && $pulse !=0 && $celsius!=0 && $spo2!=0) { echo "<br>"; } ?>
			
			<?php if($intdrugs!='') { ?>Intdrugs(<label style="color:black;"><?php echo $intdrugs; ?>)&nbsp; </label><?php }?>
			
			<?php if($dose!=0) { ?>Dose(<label style="color:black;"><?php echo $dose; ?>)&nbsp; </label><?php }?>
			
			<?php if($route!='') { ?>Route(<label style="color:black;"><?php echo $route; ?>) </label><?php }?>			</td>
          </tr>
			<tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
           <tr>
        
			<td width="103" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">Lab Tests</td>
			
            <td width="1049" colspan="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php
		    $query7="select * from consultation_lab where patientvisitcode = '$visitcode'";
			$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
			while($res7=mysqli_fetch_array($exec7))
			 {
			$labitemname = $res7['labitemname'];
			$res7username = $res7['username'];
		    ?>
			<?php echo $labitemname.' - <strong>'.strtoupper($res7username).'</strong>'; ?>
			<?php echo "<br>"; ?>
			<?php } ?></td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top"  bgcolor="#ecf0f5" class="style1">Radiology Tests</td>
            <td colspan="" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3"><?php
		    $query8="select * from consultation_radiology where patientvisitcode = '$visitcode'";
			$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8);
			while($res8=mysqli_fetch_array($exec8))
			 {
			$radiologyitemname = $res8['radiologyitemname'];
			$res8username = $res8['username'];
		    ?>
                <?php echo $radiologyitemname.' - <strong>'.strtoupper($res8username).'</strong>'; ?>
				<?php echo "<br>"; ?>
                <?php } ?></td>
          </tr>
          
            
           	
          
  </table>  <?php include ("includes/footer1.php"); ?>

</body>
</html>