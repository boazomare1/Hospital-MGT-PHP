<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("includes/loginverify.php");

include ("db/db_connectemr.php");
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
#tempid table tr td{
FONT-WEIGHT: normal; !important;
FONT-SIZE: 11px; 	 !important;
COLOR: #3B3B3C;		 !important;
 FONT-FAMILY: Tahoma; !important;
}
</style>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frm" id="frmsales" method="post" action="emrcasesheet.php" onKeyDown="return disableEnterKey(event)">

  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>

<table width="99%" border="0" cellspacing="0" cellpadding="2" style="padding-left:9px">
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
              <tr>
                <td colspan="8" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>CASE SHEET </strong></td>
                <td align="center" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                <td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><span class="style1"><a target="_blank" href="sick_referral1.php?visitcode=<?php echo $visitcode; ?>">Refer</a></span></td>
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
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Patient Bio Data </td>
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
                <td width="254" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><strong>Patient</strong>
				&nbsp;&nbsp;
				<?php echo $patientfullname; ?>, <?php echo $age; ?>, <?php echo $gender; ?></td>
                <td width="161" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Reg.No</td>
                <td width="80" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $patientcode; ?></td>
                <td width="25" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"> <strong> Visit </strong> &nbsp;&nbsp; <?php echo $visitcode; ?></td>
                <td width="75" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Date</td>
                <td width="128" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $consultationdate; ?></td>
                <td width="108" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Nurse</td>
                <td width="128" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo strtoupper($user); ?></td>
	                <td width="30" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"> 
                     <a target="_blank" href="print_emrcasesheet.php?visitcode=<?php echo $visitcode; ?>" > <img src="images/pdfdownload.jpg" width="30" height="30"></a>            </td>
			</tr>
			<tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td>&nbsp;</td>
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
			
			<?php if($height !=0 && $weight!=0 && $bmi!=0 && $bpsystolic!=0 && $bpdiastolic !=0 && $celsius!=0 ) { echo "<br>"; } ?>
			
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
            <td width="254" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><strong>Chief Complaint </strong></td>
            <td colspan="5" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $complaints; ?></td>
            <td width="108" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">Medical History </td>
            <td width="128">
			<span class="bodytext32">
					  <?php if($dm =='YES'){ ?>
				   DM (
				   <label style="color:black;"><?php echo $dm; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($cardiac =='YES'){ ?>
				   Cardiac (<label style="color:black;"><?php echo $cardiac; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($hypertension =='YES'){ ?>
				   Hypertension (<label style="color:black;"><?php echo $hypertension; ?></label>)&nbsp;
				   <?php } ?>
				   </span><span class="bodytext32">
				       <?php if($epilepsy =='YES'){ ?>
				   Epilepsy (<label style="color:black;"><?php echo $epilepsy; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($renal =='YES'){ ?>
				   Renal (<label style="color:black;"><?php echo $renal; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($respiratory =='YES'){ ?>
				   Respiratory (<label style="color:black;"><?php echo $respiratory; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($none =='YES'){ ?>
				   None (<label style="color:black;"><?php echo $none; ?></label>)&nbsp;
				   <?php } $other = trim($other);?>
				   <?php if($other !=''){ ?>
				   Other (<label style="color:black;"><?php echo $other; ?></label>)
				   <?php } ?>
			      </span>			</td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td width="254" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><strong>Obsterical History </strong></td>
            <td colspan="5"><span class="bodytext32">
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
            <td width="108" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><strong>Surgical History</strong></td>
            <td><span class="bodytext32">
					 <?php if($surgicalhistory !=''){ ?>
				   <label style="color:black;"><?php echo $surgicalhistory; ?></label>
				   <?php } ?>
					 </span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
          </tr>
          <tr>
            <td width="254" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32"><strong>Family History </strong></td>
            <td colspan="5" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32">
			<span class="bodytext32">
					 <?php if($familyhistory !=''){ ?>
				   <label style="color:black;"><?php echo $familyhistory; ?></label>
				   <?php } ?>
				    </span>			</td>
            <td width="108" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">Intoxications</td>
            <td width="128" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32">
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
            <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
          </tr>
          <tr>
            <td width="254" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">Transfusions</td>
            <td colspan="5" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32">
			<label class="bodytext32">
				  <?php if($transfusionhistory !=''){ ?>
				   <label style="color:black;"><?php echo $transfusionhistory; ?></label>
				   <?php } ?></label>			</td>
			<?php if(($department == 'MCH  CONSULTATION')){?>
            <td width="108" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Subsequent Visit</td>
            <td width="128" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php if($gestationage !=''){ ?>
				   GestationAge (<label style="color:black;"><?php echo $gestationage; ?></label>)&nbsp;
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
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		  <tr>
            <td width="254" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">ANC Profile</td>
            <td colspan="5" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext32">
			 <?php if($bloodgroup !=''){ ?>
				   BloodGroup (<label style="color:black;"><?php echo $bloodgroup; ?></label>)&nbsp;
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
            <td width="108" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td width="128" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?php
		  		$query100="select * from master_consultation where patientcode='$patientcode' and patientvisitcode = '$visitcode'";
				$exec100=mysqli_query($GLOBALS["___mysqli_ston"], $query100);
				$res100=mysqli_fetch_array($exec100);
				$murphing=$res100['murphing'];
				 ?>
           <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Murphing</td>
            
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><?php echo $murphing; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>


             <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Doctor Notes </td>
			</tr>

		   <tr>
            <td colspan="5" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
			<?php
		    $query10="select * from master_consultationlist where visitcode = '$visitcode'";
			$exec10=mysqli_query($GLOBALS["___mysqli_ston"], $query10);
			$num10=mysqli_num_rows($exec10);
			while($res10=mysqli_fetch_array($exec10))
			 { 
			   $count=1; 
			   $res10username = $res10['username'];
			   $res10consultation = $res10['consultation'];
			   $res10date = $res10['date'];
			?>			</td>
			<?php if(($count==1) && ($res10consultation != '')) { ?>
			<tr>
			  <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			  <td colspan="5" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			  <tr>  
				<td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Doctor : <?php echo strtoupper($res10username); ?></td>
				 <td colspan="3" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				<td colspan="2" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Date : <?php echo $res10date; ?></td>
			</tr>
			  <tr>
			    <td align="left" valign="top"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
			    <td colspan="5" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			   </tr>
			<?php  } ?>
			<tr>
			  <td colspan="6" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
			  <?php 
			   echo $res10consultation = $res10['consultation'];
			  ?></td>
			  </tr>
		    <?php $count++; } ?>		
                
			<tr>       
			<td width="254" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
            <td colspan="5" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
          </tr>

		<tr>
			<td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
			<?php
			$query3="select * from master_consultationlist where visitcode = '$visitcode'";
			$exec3=mysqli_query($GLOBALS["___mysqli_ston"], $query3);
			while($res3=mysqli_fetch_array($exec3))
			{
			echo $consultation = "<div class='bodytext3' id='tempid'>".$res3['templatedata']."</div>";
			echo "<br />\n";
			}
			?>			</td>
		</tr>


            <tr>
            <td width="254" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">ICD Codes</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext31">
            </td>
            </tr>

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
                <td width="254" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res4disease; ?></td>
                <td width="161" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res4icdcode; ?></td>
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
                <td width="254" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res5disease; ?></td>
                <td width="161" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res5icdcode; ?></td>
              </tr>
			<?php } ?>  
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>


             <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Lab Tests </td>
			</tr>

        <tr>
        
			
            <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php
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
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Lab Amends </td>
			</tr>

        <tr>
        
			
            <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php
		    $query7="select itemname,amendby from amendment_details where visitcode = '$visitcode' and amendfrom='lab'";
			$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
			while($res7=mysqli_fetch_array($exec7))
			 {
			$labitemname = $res7['itemname'];
			$res7username = $res7['amendby'];
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
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Radiology Tests </td>
			</tr>

          <tr>
            <td colspan="5" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3"><?php
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
		   <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		  
		        <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Radiology Amends </td>
			</tr>

        <tr>
        
			
            <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php
		    $query7="select itemname,amendby from amendment_details where visitcode = '$visitcode' and amendfrom='radiology'";
			$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
			while($res7=mysqli_fetch_array($exec7))
			 {
			$labitemname = $res7['itemname'];
			$res7username = $res7['amendby'];
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
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Procedures </td>
			</tr>

          <tr>
            <td colspan="5" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3"><?php
		    $query9="select * from consultation_services where patientvisitcode = '$visitcode'";
			$exec9=mysqli_query($GLOBALS["___mysqli_ston"], $query9);
			while($res9=mysqli_fetch_array($exec9))
			 {
			$servicesitemname = $res9['servicesitemname'];
			$res9username = $res9['username'];
		    ?>
                <?php echo $servicesitemname.' - <strong>'.strtoupper($res9username).'</strong>'; ?>; 
				<?php echo "<br>"; ?>
                <?php } ?></td>            <td width="128" align="left" valign="top"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
          </tr>
	

          <tr>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		  
		  
		        <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Procedures Amends </td>
			</tr>

        <tr>
        
			
            <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php
		     $query7="select itemname,amendby from amendment_details where visitcode = '$visitcode' and amendfrom='services'";
			$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
			while($res7=mysqli_fetch_array($exec7))
			 {
			$labitemname = $res7['itemname'];
			$res7username = $res7['amendby'];
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
 
              <?php //master_consultationpharmgeneric//
		     $querygeneric="select * from master_consultationpharmgeneric where patientvisitcode = '$visitcode'";
			$execgeneric=mysqli_query($GLOBALS["___mysqli_ston"], $querygeneric);
			$num6=mysqli_num_rows($execgeneric);
			while($res6=mysqli_fetch_array($execgeneric))
			 {
			$medicinecode = $res6['genericcode'];
			 $medicinename = $res6['genericname'];
			$dose = $res6['dose'];
			$frequencyauto_number = $res6['frequencyauto_number'];
			$frequencycode = $res6['frequencycode'];
			$days = $res6['days'];
			$route = $res6['route'];
			$quantity = $res6['quantity'];
			$instructions = $res6['instructions'];
			
			$dosemeasure = $res6['dosemeasure'];
			  $consultationid = $res6['consultation_id'];
			
			  $query44 = "select username from master_consultation where consultation_id = '$consultationid' and patientvisitcode='$visitcode' order by auto_number desc";
			$exec44=mysqli_query($GLOBALS["___mysqli_ston"], $query44);
			$num44=mysqli_num_rows($exec44);
			$res44=mysqli_fetch_array($exec44);
			$res44username = $res44['username'];
			
			$queryusername="select employeename from master_employee where username='$res44username'";
			$execuser=mysqli_query($GLOBALS["___mysqli_ston"], $queryusername);
			$resuser=mysqli_fetch_array($execuser);
			$employeename = $resuser['employeename'];
			
		    ?>
			<?php } ?>


              <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"><span class="bodytext32" style="color:blue;font-weight:bold;font-size:medium">Prescribed Drugs </span></td>
			</tr>               
			
              <tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Medicine</strong></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Units</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Dose.Measure</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Freq</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Days</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Quantity</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Route</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Instructions</td>
              </tr>
              
              
             
			  <?php
		    $query6="select * from master_consultationpharm where patientvisitcode = '$visitcode'";
			$exec6=mysqli_query($GLOBALS["___mysqli_ston"], $query6);
			$num6=mysqli_num_rows($exec6);
			while($res6=mysqli_fetch_array($exec6))
			 {
			$medicinecode = $res6['medicinecode'];
			$medicinename = $res6['medicinename'];
			$dose = $res6['dose'];
			$frequencyauto_number = $res6['frequencyauto_number'];
			$frequencycode = $res6['frequencycode'];
			$days = $res6['days'];
			$route = $res6['route'];
			$quantity = $res6['quantity'];
			$instructions = $res6['instructions'];
			$res6consultingdoctor = $res6['consultingdoctor'];
			$res6approver = $res6['approver_username'];
			$dosemeasure = $res6['dosemeasure'];
			if($res6approver == '')
			{
			$res6approver ='Not Yet Approved';
			}
			$query44 = "select * from pharmacysales_details where itemcode = '$medicinecode' and visitcode='$visitcode' order by auto_number desc";
			$exec44=mysqli_query($GLOBALS["___mysqli_ston"], $query44);
			$num44=mysqli_num_rows($exec44);
			$res44=mysqli_fetch_array($exec44);
			$res44username = $res44['username'];
			$queryusername="select employeename from master_employee where username='$res44username'";
			$execuser=mysqli_query($GLOBALS["___mysqli_ston"], $queryusername);
			$resuser=mysqli_fetch_array($execuser);
			$employeename = $resuser['employeename'];
		    ?>
			<tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $medicinename.'<br>Prescribed By - <strong>'.strtoupper($res6consultingdoctor).'</strong>'.'<br>Approved By - <strong>'.strtoupper($res6approver).'</strong>'; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $dose; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $dosemeasure; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $frequencycode; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $days; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $quantity; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $route; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $instructions; ?></td>
              </tr>
            <?php } ?>
          
              <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Issued Drugs </td>
			</tr>               
    
         <tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Medicine</strong></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Units</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Dose.Measure</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Freq</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Days</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Quantity</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Route</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Instructions</td>
              </tr>
			  <?php
		    $query60="select * from master_consultationpharm where patientvisitcode = '$visitcode'";
			$exec60=mysqli_query($GLOBALS["___mysqli_ston"], $query60);
			$num60=mysqli_num_rows($exec60);
			while($res60=mysqli_fetch_array($exec60))
			 {
			$medicinecode1 = $res60['medicinecode'];
			$medicinename = $res60['medicinename'];
			$dose = $res60['dose'];
			$frequencyauto_number = $res60['frequencyauto_number'];
			$frequencycode = $res60['frequencycode'];
			$days = $res60['days'];
			$route = $res60['route'];
			$quantity = $res60['quantity'];
			$instructions = $res60['instructions'];
			$res6username = $res60['username'];
			$dosemeasure = $res60['dosemeasure'];
			
			$query440 = "select username from pharmacysales_details where itemcode = '$medicinecode1' and visitcode='$visitcode' order by auto_number desc";
			$exec440=mysqli_query($GLOBALS["___mysqli_ston"], $query440);
			$num440=mysqli_num_rows($exec440);
			$res440=mysqli_fetch_array($exec440);
			$res44username = $res440['username'];
			$queryusername="select employeename from master_employee where username='$res44username'";
			$execuser=mysqli_query($GLOBALS["___mysqli_ston"], $queryusername);
			$resuser=mysqli_fetch_array($execuser);
			$employeename = $resuser['employeename'];
			if($num440!=0)
			{
		    ?>
			<tr>
                <td align="left" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $medicinename.' - <strong>'.strtoupper($res44username).'</strong>'; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $dose; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $dosemeasure; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $frequencycode; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $days; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $quantity; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $route; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $instructions; ?></td>
              </tr>
            <?php }
			 }?>
			 
			 
			    <tr>
                <td align="left" colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext32" style="color:blue;font-weight:bold;font-size:medium"> Drugs Amends </td>
			</tr>

        <tr>
        
			
            <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php
		     $query7="select itemname,amendby from amendment_details where visitcode = '$visitcode' and amendfrom='Pharmacy'";
			$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7);
			while($res7=mysqli_fetch_array($exec7))
			 {
			$labitemname = $res7['itemname'];
			$res7username = $res7['amendby'];
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
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
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