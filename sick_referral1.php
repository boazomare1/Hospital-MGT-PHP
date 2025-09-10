<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$dateonly1 = date('Y-m-d');
$colorloopcount = '';
$sno = '';
$errmsg = '';
?>

<?php
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["complaint"])) { $complaints = $_REQUEST["complaint"]; } else { $complaints = ""; }
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }


if ($frm1submit1 =="frm1submit1")
 {
  $complaints = $_REQUEST["complaint"];
  $visitcode = $_REQUEST["visitcode"]; 
  $patientname = $_REQUEST["patientname"]; 
  $patientcode = $_REQUEST["patientcode"]; 
  $referredto = $_REQUEST["referredto"]; 
  $reason = $_REQUEST["reason"]; 
  
  $query65="insert into sick_referral(patientcode, patientname,visitcode,referredto,reason,recorddate,recordtime) values ('$patientcode', '$patientname', '$visitcode', '$referredto', '$reason','$updatedatetime','$dateonly1')";
  $exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   
   header("location:sick_referral1.php?patientcode=$patientcode&&visitcode=$visitcode");
 }
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

<script>
function funcPopupOnLoader()
{
<?php  
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
?>
var patientcodes;
var patientcodes = "<?php echo $patientcode; ?>";
var visitcodes;
var visitcodes = "<?php echo $visitcode; ?>";
//alert(visitcodes);
	if(visitcodes != "" && patientcodes != "") 
	{
		window.open("sick_referral.php?patientcode="+patientcodes+"&&visitcode="+visitcodes,"OriginalWindowA4",'width=700,height=700,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}
}
</script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="funcPopupOnLoader()">
<form name="frm" id="frmsales" method="post" action="sick_referral1.php" onKeyDown="return disableEnterKey(event)">
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

  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="1322" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="1281" colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#ecf0f5'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td colspan="8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><table width="99%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="8" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>REFERRAL</strong></td>
                <td align="center" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><span class="style1"><a href="#"></a></span></td>
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
                <td width="28%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $patientfullname; ?>, <?php echo $age; ?>, <?php echo $gender; ?></td>
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientfullname; ?>">
                <td width="4%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Reg.No</td>
                <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $patientcode; ?></td>
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
                <td width="3%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Visit</td>
                <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $visitcode; ?></td>
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
                <td width="3%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Date</td>
			    <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $consultationdate; ?></td>
            	<input type="hidden" name="date" id="date" value="<?php echo $consultationdate; ?>">
			    <td width="4%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Nurse</td>
                <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo strtoupper($user); ?></td>
				<input type="hidden" name="nurse" id="nurse" value="<?php echo $user; ?>">
              </tr>
            </table></td>
            </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td>&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>Vitals</strong></td>
            <td align="left" class="bodytext32" colspan="4">
			<?php if($height!=0) { ?>Height(<label style="color:black;"><?php echo $height; ?>)&nbsp; </label><?php }?>
			<?php if($weight!=0) { ?>Weight(<label style="color:black;"><?php echo $weight; ?>)&nbsp; </label><?php }?>
			<?php if($bmi!=0) { ?>BMI(<label style="color:black;"><?php echo $bmi; ?>)&nbsp; </label><?php }?>
			
			<?php if($bpsystolic!=0) { ?>bp(<label style="color:black;"><?php echo $bpsystolic; ?>/</label><?php }?>

			<?php if($bpdiastolic!=0) { ?><label style="color:black;"><?php echo $bpdiastolic; ?>) </label><?php }?>
			
			<?php if($respiration!=0) { ?>Resp(<label style="color:black;"><?php echo $respiration; ?>)&nbsp; </label><?php }?>
			
			<?php if($pulse!=0) { ?>Pulse(<label style="color:black;"><?php echo $pulse; ?>)&nbsp; </label><?php }?>
			
			<?php if($celsius!=0) { ?>Celsius(<label style="color:black;"><?php echo $celsius; ?>)&nbsp; </label><?php }?>
			
			<?php if($spo2!=0) { ?>Spo2(<label style="color:black;"><?php echo $spo2; ?>)&nbsp; </label><?php }?>
			
			<?php if($intdrugs!=0) { ?>Intdrugs(<label style="color:black;"><?php echo $intdrugs; ?>)&nbsp; </label><?php }?>
			
			<?php if($dose!=0) { ?>Dose(<label style="color:black;"><?php echo $dose; ?>)&nbsp; </label><?php }?>
			
			<?php if($route!=0) { ?>Route(<label style="color:black;"><?php echo $route; ?>) </label><?php }?>
			
			</td>
            
           
          </tr>
		  <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td>&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
		  <?php
			$query2="select * from master_triage where visitcode = '$visitcode'";
			$exec2=mysqli_query($GLOBALS["___mysqli_ston"], $query2);
			$res2=mysqli_fetch_array($exec2);
			$complaints = $res2['complanits'];
			$dm = $res2['dm'];
					if($dm == '1')
					{
					$dm = 'YES';
					}
					else
					{
					$dm = '';
					}
					$cardiac = $res2['cardiac'];
					if($cardiac == '1')
					{
					$cardiac = 'YES';
					}
					else
					{
					$cardiac = '';
					}
					$hypertension = $res2['hypertension'];
					if($hypertension == '1')
					{
					$hypertension = 'YES';
					}
					else
					{
					$hypertension = '';
					}
					$epilepsy = $res2['epilepsy'];
					if($epilepsy == '1')
					{
					$epilepsy = 'YES';
					}
					else
					{
					$epilepsy = '';
					}
					$respiratory = $res2['respiratory'];
					if($respiratory == '1')
					{
					$respiratory = 'YES';
					}
					else
					{
					$respiratory = '';
					}
					$renal = $res2['renal'];
					if($renal == '1')
					{
					$renal = 'YES';
					}
					else
					{
					$renal = '';
					}
					$none = $res2['none'];
					if($none == '1')
					{
					$none = 'YES';
					}
					else
					{
					$none = '';
					}
					$other = $res2['other'];
					$triagedate = $res2['registrationdate'];
					$triageuser = $res2['user'];
					$smoking = $res2['smoking'];
					if($smoking == '1')
					{
					$smoking = 'YES';
					}
					else
					{
					$smoking = '';
					}
					$alcohol = $res2['alcohol'];
					if($alcohol == '1')
					{
					$alcohol = 'YES';
					}
					else
					{
					$alcohol = '';
					}
					$drugs = $res2['drugs'];
					if($drugs == '1')
					{
					$drugs = 'YES';
					}
					else
					{
					$drugs = '';
					}
					$gravida = $res2['gravida'];
					$para = $res2['para'];
					$abortion = $res2['abortion'];
					$familyhistory = $res2['familyhistory'];
					$surgicalhistory = $res2['surgicalhistory'];
					$transfusionhistory = $res2['transfusionhistory'];
					$lmp = $res2['lmp'];
					$edt = $res2['edt'];
					$bloodgroup = $res2['bloodgroup'];
					$hblevel = $res2['hblevel'];
					$vdrl = $res2['vdrl'];
					$pmtct = $res2['pmtct'];
					$urinalysis = $res2['urinalysis'];
					$gestationage = $res2['gestationage'];
					$noofvisit = $res2['noofvisit'];
					$urinedipstict = $res2['urinedipstict'];
		  ?>
            <td width="8%" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><strong>Chief Complaint </strong></td>
            <td colspan="4" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $complaints; ?>
			<input type="hidden" name="complaint" id="complaint" value="<?php echo $complaints; ?>">
			</td>
            <td width="7%" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">Medical History </td>
            <td width="37%">
			<span class="bodytext32">
					  <?php if($dm =='YES'){ ?>
				   DM (
				   <label style="color:black;"><?php echo $dm; ?></label>)&nbsp;
				   <input type="hidden" name="dm" id="dm" value="<?php echo $dm; ?>">
				   <?php } ?>
				    <?php if($cardiac =='YES'){ ?>
				   Cardiac (<label style="color:black;"><?php echo $cardiac; ?></label>)&nbsp;
				   <input type="hidden" name="cardiac" id="cardiac" value="<?php echo $cardiac; ?>">
				   <?php } ?>
				    <?php if($hypertension =='YES'){ ?>
				   Hypertension (<label style="color:black;"><?php echo $hypertension; ?></label>)&nbsp;
				   <input type="hidden" name="hypertension" id="hypertension" value="<?php echo $hypertension; ?>">
				   <?php } ?>
				   </span><span class="bodytext32">
				       <?php if($epilepsy =='YES'){ ?>
				   Epilepsy (<label style="color:black;"><?php echo $epilepsy; ?></label>)&nbsp;
				   <input type="hidden" name="epilepsy" id="epilepsy" value="<?php echo $epilepsy; ?>">
				   <?php } ?>
				    <?php if($renal =='YES'){ ?>
				   Renal (<label style="color:black;"><?php echo $renal; ?></label>)&nbsp;
				   <input type="hidden" name="renal" id="renal" value="<?php echo $renal; ?>">
                   <?php } ?>
				    <?php if($respiratory =='YES'){ ?>
				   Respiratory (<label style="color:black;"><?php echo $respiratory; ?></label>)&nbsp;
				   <input type="hidden" name="respiratory" id="respiratory" value="<?php echo $respiratory; ?>">
				   <?php } ?>
				    <?php if($none =='YES'){ ?>
				   None (<label style="color:black;"><?php echo $none; ?></label>)&nbsp;
				   <input type="hidden" name="none" id="none" value="<?php echo $none; ?>">
				   <?php } $other = trim($other);?>
				   <?php if($other !=''){ ?>
				   Other (<label style="color:black;"><?php echo $other; ?></label>)
				   <input type="hidden" name="other" id="other" value="<?php echo $other; ?>">
				   <?php } ?>
			      </span>
	  			  </td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="8%" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><strong>Obsterical History </strong></td>
            <td colspan="4"><span class="bodytext32">
					  <?php if($gravida !=''){ ?>
				   Gravida (<label style="color:black;"><?php echo $gravida; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($para !=''){ ?>
				   Para (<label style="color:black;"><?php echo $para; ?></label>)&nbsp;
				   <?php } ?>
				   <?php if($abortion !=''){ ?>
				   Abortion (<label style="color:black;"><?php echo $abortion; ?></label>)&nbsp;
				   <?php } ?>
				   
				    <?php if($lmp !=''){ ?>
				   LMP (<label style="color:black;"><?php echo $lmp; ?></label>)&nbsp;
				   <?php } ?>
				   
				   <?php if($edt !=''){ ?>
				   EDT (<label style="color:black;"><?php echo $edt; ?></label>)&nbsp;
				   <?php } ?>

				  </span></td>
            <td width="7%" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><strong>Surgical History</strong></td>
            <td><span class="bodytext32">
					 <?php if($surgicalhistory !=''){ ?>
				   <label style="color:black;"><?php echo $surgicalhistory; ?></label>
				   <?php } ?>
					 </span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
          </tr>
          <tr>
            <td width="8%" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><strong>Family History </strong></td>
            <td colspan="4" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32">
			<span class="bodytext32">
					 <?php if($familyhistory !=''){ ?>
				   <label style="color:black;"><?php echo $familyhistory; ?></label>
				   <?php } ?>
			      </span>			</td>
            <td width="7%" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">Intoxications</td>
            <td width="37%" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32">
			<span class="bodytext32">
					  <?php if($smoking =='YES'){ ?>
				   Smoking (
				   <label style="color:black;"><?php echo $smoking; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($alcohol =='YES'){ ?>
				   Alcohol (<label style="color:black;"><?php echo $alcohol; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($drugs =='YES'){ ?>
				   Drugs (<label style="color:black;"><?php echo $drugs; ?></label>)&nbsp;
				   <?php } ?>
			      </span>			</td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
          </tr>
          <tr>
            <td width="8%" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">Transfusions</td>
            <td colspan="4" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32">
			<label class="bodytext32">
				  <?php if($transfusionhistory !=''){ ?>
				   <label style="color:black;"><?php echo $transfusionhistory; ?></label>
			      <?php } ?></label>			</td>
			<?php if(($department == 'MCH  CONSULTATION')){?>
            <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Subsequent Visit</td>
            <td width="37%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php if($gestationage !=''){ ?>
				   GestationAge (
				     <label style="color:black;"><?php echo $gestationage; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($noofvisit !=''){ ?>
				   NoofVisit (<label style="color:black;"><?php echo $noofvisit; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($urinedipstict !=''){ ?>
				   Urinedipstict (<label style="color:black;"><?php echo $urinedipstict; ?></label>)&nbsp;
			      <?php } ?>   </td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		  <tr>
            <td width="8%" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">ANC Profile</td>
            <td colspan="4" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32">
			 <?php if($bloodgroup !=''){ ?>
				   BloodGroup (
				   <label style="color:black;"><?php echo $bloodgroup; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($hblevel !=''){ ?>
				   HB Level (<label style="color:black;"><?php echo $hblevel; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($vdrl !=''){ ?>
				   VDRL (<label style="color:black;"><?php echo $vdrl; ?></label>)&nbsp;
				   <?php } ?>
				   <?php if($pmtct !=''){ ?>
				   PMTCT (<label style="color:black;"><?php echo $pmtct; ?></label>)&nbsp;
				   <?php } ?>
				   <?php if($urinalysis !=''){ ?>
				   Urinalysis (<label style="color:black;"><?php echo $urinalysis; ?></label>)&nbsp;
			  <?php } ?>			</td>
			  <?php } ?>
            <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td width="37%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
		 
               <td width="8%" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">Prescription</td>
			
            <td colspan="4" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3"><table width="99%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Medicine</strong></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Dose</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Freq</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Days</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Quantity</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Route</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Instructions</td>
              </tr>
			  <?php
		    $query6="select * from master_consultationpharm where patientvisitcode = '$visitcode'";
			$exec6=mysqli_query($GLOBALS["___mysqli_ston"], $query6);
			while($res6=mysqli_fetch_array($exec6))
			 {
			$medicinename = $res6['medicinename'];
			$dose = $res6['dose'];
			$frequencyauto_number = $res6['frequencyauto_number'];
			$frequencycode = $res6['frequencycode'];
			$days = $res6['days'];
			$route = $res6['route'];
			$quantity = $res6['quantity'];
			$instructions = $res6['instructions'];
		    ?>
			<tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $medicinename; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $dose; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $frequencycode; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $days; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $quantity; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $route; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $instructions; ?></td>
              </tr>
            <?php } ?>
            </table>			</td>
            <td width="7%" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">ICD Codes</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext31"><table width="99%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext31"><strong>Primary Diagnosis: </strong></td>
                </tr>
			  <?php
		    $query4="select * from consultation_icd where patientvisitcode = '$visitcode'";
			$exec4=mysqli_query($GLOBALS["___mysqli_ston"], $query4);
			while($res4=mysqli_fetch_array($exec4))
			 {
			$res4disease = $res4['primarydiag'];
			$res4icdcode = $res4['primaryicdcode'];
			?>	
              <tr>
                <td width="63%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res4disease; ?></td>
                <td width="37%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res4icdcode; ?></td>
              </tr>
			<?php } ?>  
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext31"><strong>Secondary Diagnosis: </strong></td>
                </tr>
			  <?php
		    $query5="select * from consultation_icd where patientvisitcode = '$visitcode'";
			$exec5=mysqli_query($GLOBALS["___mysqli_ston"], $query5);
			while($res5=mysqli_fetch_array($exec5))
			 {
			$res5disease = $res5['secondarydiag'];
			$res5icdcode = $res5['secicdcode'];
			?>	
              <tr>
                <td width="63%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res5disease; ?></td>
                <td width="37%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res5icdcode; ?></td>
              </tr>
			<?php } ?>  
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
         
		  
          <tr>
        
			<td width="8%" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">Lab Tests</td>
			
            <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php
		    $query7="select * from consultation_lab where patientvisitcode = '$visitcode'";
			$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
			while($res7=mysqli_fetch_array($exec7))
			 {
			$labitemname = $res7['labitemname'];
		    ?>
			<?php echo $labitemname; ?>
			<?php echo "<br>"; ?>
			<?php } ?></td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top"  bgcolor="#ecf0f5" class="style1">Radiology Tests</td>
            <td colspan="4" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3"><?php
		    $query8="select * from consultation_radiology where patientvisitcode = '$visitcode'";
			$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8);
			while($res8=mysqli_fetch_array($exec8))
			 {
			$radiologyitemname = $res8['radiologyitemname'];
		    ?>
                <?php echo $radiologyitemname; ?> <?php echo "<br>"; ?>
                <?php } ?></td>
          </tr>
		   <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top"  bgcolor="#ecf0f5" class="style1">Procedures</td>
            <td colspan="4" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3"><?php
		    $query9="select * from consultation_services where patientvisitcode = '$visitcode'";
			$exec9=mysqli_query($GLOBALS["___mysqli_ston"], $query9);
			while($res9=mysqli_fetch_array($exec9))
			 {
			$servicesitemname = $res9['servicesitemname'];
		    ?>
                <?php echo $servicesitemname; ?> <?php echo "<br>"; ?>
                <?php } ?></td>            <td width="7%" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
          </tr>
		   <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		   <tr>
		 
            <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">
			  <?php
		  $query3="select * from master_consultationlist where visitcode = '$visitcode'";
			$exec3=mysqli_query($GLOBALS["___mysqli_ston"], $query3);
			while($res3=mysqli_fetch_array($exec3))
			{
			 echo $consultation = $res3['templatedata'];
			 
			echo "<br />\n";
			}
		  ?>			</td>
            </tr>
		   <tr>
		     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Hospital Referred To </td>
			 <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">
			   <input name="referredto" type="text" id="referredto" value="" size="50" autocomplete="off">			 </td>
           </tr>
		   <tr>
		     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
		     <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
		     </tr>
		   <tr>
		     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Reason for Referral </td>
		     <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">
			 <input name="reason" type="text" id="reason" value="" size="50" autocomplete="off"></td>
		     </tr>
		   <tr>
		     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
		     <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
		     </tr>
		   <tr>
		     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
		     <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
		     </tr>
		   <tr>
		     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
		     <td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
		     <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
		     <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
		     <td width="23%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">
			   <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
               <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()"  accesskey="b" class="button"/></td>
		   </tr>
		   <tr>
		     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
		     <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
		     </tr>
        </table></td>
      </tr>
		  </table>
</td>
	</tr>
  </table>   

</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>