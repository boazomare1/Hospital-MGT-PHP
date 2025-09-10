<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

//$financialyear = $_SESSION["financialyear"];

	$query6 = "select * from master_company where auto_number = '$companyanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$res6companycode = $res6["companycode"];
	
	$query7 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
	settingsname = 'CURRENT_FINANCIAL_YEAR'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7 = mysqli_fetch_array($exec7);
	$financialyear = $res7["settingsvalue"];
	$_SESSION["financialyear"] = $financialyear;
	//echo $_SESSION['financialyear'];


if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$billautonumber = $_REQUEST["billautonumber"];

//$summarynumber = $_REQUEST["banum"];
//$banum = $_REQUEST["billautonumber"];

if (isset($_REQUEST["summarynumber"])) { $summarynumber = $_REQUEST["summarynumber"]; } else { $summarynumber = ""; }
//$billautonumber = $_REQUEST["billautonumber"];


if (isset($_REQUEST["printsource"])) { $printsource = $_REQUEST["printsource"]; } else { $printsource = ""; }
//$printsource = $_REQUEST["printsource"];

	
	$query22 = "select * from master_dischargesummary where summarynumber = ".$_REQUEST["summarynumber"]." and status <> 'DELETED'";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res22 = mysqli_fetch_array($exec22);
	$res22anum = $res22["auto_number"];
	$banum = $res22anum;
	if ($banum == '')
	{
		echo "Bill Number Does Not Exist.";
		exit;
	}

//}
if (isset($_REQUEST["copy1"])) { $copy1  = $_REQUEST["copy1"]; } else { $copy1  = ""; }
//$copy1  = $_REQUEST["copy1 "];

if (isset($_REQUEST["title1"])) { $title1  = $_REQUEST["title1"]; } else { $title1  = ""; }
//$title1  = $_REQUEST["title1"];
//echo $banum;

$query2 = "select * from settings_billhospital where companyanum = '$companyanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);


	$f1 = $res2["f1"];
	$f2 = $res2["f2"];
	$f3 = $res2["f3"];
	$f4 = $res2["f4"];
	$f5 = $res2["f5"];
	$f6 = $res2["f6"];
	$f7 = $res2["f7"];
	$f8 = $res2["f8"];
	$f9 = $res2["f9"];
	$f10 = $res2["f10"];
	$f11 = $res2["f11"];
	$f12 = $res2["f12"];
	$f13 = $res2["f13"];
	$f14 = $res2["f14"];
	$f15 = $res2["f15"];
	$f16 = $res2["f16"];
	$f17 = $res2["f17"];
	$f18 = $res2["f18"];
	$f19 = $res2["f19"];
	$f20 = $res2["f20"];
	$f21 = $res2["f21"];
	$f22 = $res2["f22"];
	$f23 = $res2["f23"];
	$f24 = $res2["f24"];
	$f25 = $res2["f25"];
	$f26 = $res2["f26"];
	$f27 = $res2["f27"];
	$f28 = $res2["f28"];
	$f29 = $res2["f29"];
	$f30 = $res2["f30"];
	$f31 = $res2["f31"];
	$f32 = $res2["f32"];
	$f9size = $res2["f9size"];
	$f27size = $res2["f27size"];
	$f28size = $res2["f28size"];
	$letterheadprinting = $res2["letterheadprinting"];


$query3 = "select * from master_dischargesummary where summarynumber = ".$_REQUEST["summarynumber"]." and status <> 'DELETED'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$res3anum = $res3["auto_number"];

//$billdate = $dbdateday.' '.$billtime;
$billdate = $res3["summarydate"];

$patientcode = $res3["patientcode"];
$patientname = $res3["patientname"];
//if ($patientname != '') $patientname = 'M/s. '.$patientname;
//$address = $res3["address"];
//$location = $res3["location"];
//$city = $res3["city"];
//$state = $res3["state"];
//$pincode = $res3["pincode"];
//$city = $city.', '.$state;
//if ($pincode != '') $city = $city.' - '.$pincode;
//$deliveryaddress = $res3["deliveryaddress"];
$doctorname = $res3["doctorname"];

$dateofadmission = $res3["admissiondate"];
$billtime = substr($dateofadmission, 11, 8);
$billdateonly = substr($dateofadmission, 0, 10);
$dotarray = explode("-", $billdateonly);
$dotyear = $dotarray[0];
$dotmonth = $dotarray[1];
$dotday = $dotarray[2];
$dateofadmission = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));

$dateofdischarge = $res3["dischargedate"];
$billtime = substr($dateofdischarge, 11, 8);
$billdateonly = substr($dateofdischarge, 0, 10);
$dotarray = explode("-", $billdateonly);
$dotyear = $dotarray[0];
$dotmonth = $dotarray[1];
$dotday = $dotarray[2];
$dateofdischarge = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));

$ipnumber = $res3['ipnumber'];
$admissiontime = $res3['admissiontime'];
$dischargetime = $res3['dischargetime'];
$patientage = $res3["patientage"];
$patientgender = $res3["patientgender"];
$drugallergies = $res3["drugallergies"];
$finaldiagnosis = $res3["finaldiagnosis"];
$chiefcomplaints = $res3["chiefcomplaints"];
$temparature = $res3["temparature"];
$pulse = $res3["pulse"];
$bloodpressure = $res3["bloodpressure"];
$investigationdetails = $res3["investigationdetails"];
$treatmentgiven = $res3["treatmentgiven"];
$diet = $res3["diet"];
$physicalactivity = $res3["physicalactivity"];
$clinicalexamination = $res3['clinicalexamination'];

$wardname = $res3["wardname"];
$bednumber = $res3["bednumber"];
$surgerydate = $res3["surgerydate"];
if ($surgerydate == '0000-00-00') $surgerydate = '';
$patienthistory =$res3["patienthistory"];
$consultationreferral = $res3["consultationreferral"];
$conditionatdischarge = $res3["conditionatdischarge"];
$medication = $res3["medication"];
$followup = $res3["followup"];

$medicalofficer = $res3['medicalofficer'];
$query51 = "select * from master_doctor where doctorcode = '$medicalofficer'";
$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
$res51 = mysqli_fetch_array($exec51);
$medicalofficer = $res51["doctorname"];

$consultantofficer = $res3['consultantofficer'];
$query51 = "select * from master_doctor where doctorcode = '$consultantofficer'";
$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
$res51 = mysqli_fetch_array($exec51);
$consultantofficer = $res51["doctorname"];


$address1 = $res3["address1"];
$address2 = $res3["address2"];
$area = $res3["area"];
$city = $res3["city"];
$pincode = $res3["pincode"];


$companyanum = $_SESSION["companyanum"];
$query4 = "select * from master_company where auto_number = '$companyanum'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);


?>
<style type="text/css">
<!--
.style6 {<?php echo 'font-size: '.$fontsize4.'px'; ?>;}


/*
.style3 {
	font-family: "Times New Roman", Times, serif;
	font-weight: bold;
	font-size: 24px;
}

.style2 {font-size: 10px}
.style5 {font-family: "Times New Roman", Times, serif; font-weight: bold; font-size: 18px; }
.style6 {font-size: 14px}
.style8 {font-size: 14px; font-weight: bold; }
*/

table.sample {
	border-width: 1px;
	border-spacing: 1px;
	border-style: outset;
	border-color: gray;
	border-collapse: collapse;
	background-color: white;
}
table.sample th {
	border-width: 1px;
	border-spacing: 1px;
	border-style: outset;
	border-color: gray;
	border-collapse: collapse;
	background-color: white;
}
.style12 {font-size: 18px; font-weight: bold; }
.style27 {font-size: 14px; }
.style28 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 20px;
}
.style29 {font-family: Neuropol}

-->
</style>
<script language="javascript">

function escapekeypressed()
{
	//alert(event.keyCode);
	if(event.keyCode=='27'){ window.close(); }
}

</script>
<body onkeydown="escapekeypressed()">
<table width="660" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4"><div align="center">
	<?php
	//for letter head printing settings
	if ($letterheadprinting == '') // to print on blank paper with headers.
	{
	//echo "inside if";
	$f9size = '4';
	?>
      <table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
		<?php include ("print_showlogo1hospital.php"); ?>
          <td width="57%"><div align="center" class="style12">
            <div align="left"><span class="style29"><font <?php echo 'size="'.$f9size.'"'; ?>><?php echo $f9; ?></font></span></div>
          </div>
            <div align="center" class="style27">
              <div align="left"><span class="style6"> <font <?php echo 'size="'.$f27size.'"'; ?>><?php echo $f10; ?></font> </span></div>
            </div>
            <div align="center" class="style27">
              <div align="left"><span class="style6"> <font <?php echo 'size="'.$f27size.'"'; ?>><?php echo $f11; ?></font> </span></div>
            </div>
            <div align="center" class="style27">
              <div align="left"><span class="style6"> <font <?php echo 'size="'.$f27size.'"'; ?>><?php echo $f12; ?></font> </span></div>
            </div></td>
          <td width="29%" valign="top">
		  <div align="right"><span class="style28">
		<?php
		/* 
		if ($copy1 == '')
		{
		echo $f28; 
		}
		else
		{
		echo $copy1; 
		//echo $title1;
		}
		*/
		echo 'DISCHARGE SUMMARY';
		?>
		     </span> <br />
		    </div>
		  <div class="style27">
		    <div align="right"><span class="style6"><?php echo $title1; ?></span>&nbsp;&nbsp;</div>
		  </div>
		<div class="style27">
		    <div align="right"><span class="style6"><?php //echo $f15.' '.$summarynumberprefix; ?></span>&nbsp;&nbsp;</div>
		  </div>
		<div class="style27">
		    <div align="right"><span class="style6"><?php echo $f16.' '.$billdate; ?></span>&nbsp;&nbsp;</div>
		  </div>			   </td>
        </tr>
      </table>
	  <?php
	}
	else if ($letterheadprinting == 'YES') // to print on letter head without headers.
	{
	//echo "inside else";
	?>
      <table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="14%" height="100">&nbsp;</td>
          <td width="57%"><div align="center" class="style12">
            <div align="left"><span class="style28"><font <?php if ($f9size != '') { echo 'size="'.$f9size.'"'; } ?>><?php //echo $f9; ?>&nbsp;</font></span></div>
          </div>
            <div align="center" class="style27">
              <div align="left"><span class="style6"> <font <?php if ($f27size != '') { echo 'size="'.$f27size.'"'; } ?>><?php //echo $f10; ?>&nbsp;</font> </span></div>
            </div>
            <div align="center" class="style27">
              <div align="left"><span class="style6"> <font <?php if ($f27size != '') { echo 'size="'.$f27size.'"'; } ?>><?php //echo $f11; ?>&nbsp;</font> </span></div>
            </div>
            <div align="center" class="style27">
              <div align="left"><span class="style6"> <font <?php if ($f27size != '') { echo 'size="'.$f27size.'"'; } ?>><?php //echo $f12; ?>&nbsp;</font> </span></div>
            </div></td>
          <td width="29%" valign="top">
		  <span class="style28">
		  <?php 
		  if ($title1 == '')
		  {
		  	//echo $f28; 
		}
		else
		{
			//echo $title1;
		}
		  ?>
		  </span><br /><?php //echo $copy1; ?></td>
        </tr>
      </table>
	<?php
	}
	//end of letter head printing settings.	  
	?>
    </div></td>
  </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><table width="98%" border="0" cellspacing="0" cellpadding="0" class="sample">
        <tr>
          <td valign="top" width="50%"><table width="97%" border="0" align="left" cellpadding="0" cellspacing="0">
              <tr>
                <td>
				<div align="left" class="style27"><span class="style6"> <?php echo 'Patient ID : '.$patientcode;//echo $f13; ?></span></div>
				<div align="left" class="style27"><span class="style6"> <?php echo 'Patient Name : '.$patientname; ?></span></div>
                   
                  <div align="left" class="style27"><span class="style6"> <?php echo 'Patient Age & Sex : '.$patientage.' / '.$patientgender;//echo $address; ?></span></div>
                  <div align="left" class="style27"><span class="style6"> <?php echo $address1; //.' '.$city; ?></span></div>
                  <div align="left" class="style27"><span class="style6"> <?php echo $address2;//.' '.$city; ?></span></div>
                  <div align="left" class="style27"><span class="style6"> <?php echo $area.' '.$city; ?></span></div>
				<?php
				$query71 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SALES' and 
				settingsname = 'PHONE_NUMBER_SALES_PRINT_SETTING'";
				$exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die ("Error in Query71".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res71 = mysqli_fetch_array($exec71);
				$phonenumbersalesprintsettings1 = $res71["settingsvalue"];
				if ($phonenumbersalesprintsettings1 == 'SHOW PHONE NUMBER ON SALES PRINTOUT')
				{
				?>
				<div align="left" class="style27"><span class="style6"> <?php //echo $phonenumber1.' '.$mobilenumber; ?></span></div>
				<?php
				}
				?>
                  <div align="left"></div></td>
              </tr>
          </table></td>
          <td width="50%" valign="top"><table width="97%" border="0" align="left" cellpadding="0" cellspacing="0">
              <tr>
                <td><?php
			if ($letterheadprinting == 'YES')
			{
			?>
                    <div align="left" class="style27"><span class="style6"><strong><?php echo $f15.' '.$summarynumberprefix.' / '.$f16.' '.$billdate; ?></strong></span></div>
                  <!--<div align="left" class="style27"><span class="style6"> <?php echo $f16.' '.$billdate; ?></span></div>-->
                    <!--<div align="left" class="style27"><span class="style6"> <?php echo $billtype.' BILL'; ?></span></div>-->
                    <?php
			}
			?>
                    <?php
			//if ($deliveryaddress != '')
			//{
			?>
					<div align="left" class="style27"><span class="style6"> <?php echo 'Doctor Name : '.$doctorname; ?></span></div>
					<div align="left" class="style27"><span class="style6"> <?php echo 'Date Of Admission : '.$dateofadmission.' Time : '.$admissiontime; ?></span></div>
					<div align="left" class="style27"><span class="style6"> <?php echo 'Date Of Discharge : '.$dateofdischarge.' Time : '.$dischargetime; ?></span></div>
					<div align="left" class="style27"><span class="style6"> <?php echo 'IP Number : '.$ipnumber; ?></span></div>
                  <?php
			//}
			?>                </td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4"><strong>Consultant Doctor :</strong> <?php echo $doctorname; ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Surgery Date :</strong> <?php echo $surgerydate; ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Drug Allergies : </strong><?php echo $drugallergies; ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4"><strong>Final Diagnosis :</strong></td>
  </tr>
  <tr>
    <td colspan="4"><?php echo nl2br($finaldiagnosis); ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Chief Complaints : </strong></td>
  </tr>
  <tr>
    <td colspan="4"><?php echo nl2br($chiefcomplaints); ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Patient History : </strong></td>
  </tr>
  <tr>
    <td colspan="4"><?php echo nl2br($patienthistory); ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="166"><strong>Clinical Examination </strong></td>
    <td width="171">Temparature : <?php echo $temparature; ?></td>
    <td width="123">Pulse : <?php echo $pulse; ?></td>
    <td width="200">B.P. : <?php echo $bloodpressure; ?></td>
  </tr>
  <tr>
    <td colspan="4"><?php echo nl2br($clinicalexamination); ?></td>
  </tr>
  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Investigation Details : </strong></td>
  </tr>
  <tr>
    <td colspan="4"><?php echo nl2br($investigationdetails); ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Consultation Referral :</strong> <?php echo $consultationreferral; ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Treatment Given : </strong></td>
  </tr>
  <tr>
    <td colspan="4"><?php echo nl2br($treatmentgiven); ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Condition At Discharge : </strong></td>
  </tr>
  <tr>
    <td colspan="4"><?php echo nl2br($conditionatdischarge); ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Discharge Advice : </strong></td>
  </tr>
  <tr>
    <td colspan="4">Diet : <?php echo $diet; ?></td>
  </tr>
  <tr>
    <td colspan="4">Physical Activity : <?php echo $physicalactivity; ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Medication : </strong></td>
  </tr>
  <tr>
    <td colspan="4"><?php echo nl2br($medication); ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Follow Up :</strong></td>
  </tr>
  <tr>
    <td colspan="4"><?php echo nl2br($followup); ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><div class="style27"></span></div></td>
  </tr>
  
  <tr>
    <td colspan="2"><table width="99%" border="0" align="left">
      <tr>
        <td><?php echo $medicalofficer;//$f26; ?></td>
      </tr>
      <tr>
        <td><div align="left"><span class="style27"><b><?php echo 'Medical Officer';//$f26; ?></b></span></div></td>
      </tr>
    </table></td>
    <td colspan="2" valign="top"><table width="99%" border="0" align="left">
      <tr>
        <td><div align="right"><?php echo $consultantofficer;//$f26; ?></div></td>
      </tr>
      <tr>
        <td><div align="right"><b><?php echo 'Consultant';//$f26; ?></b></div></td>
      </tr>
    </table></td>
  </tr>
  <?php
  if ($f31 != '')
  {
  ?>
  
  <?php
	}
  ?>

  <?php
  if ($f32 != '')
  {
  ?>
  
  <?php
	}
  ?>

  <?php
  if ($f23 != '')
  {
  ?>
  
  <?php
	}
  ?>

  <?php
  if ($f24 != '')
  {
  ?>
  
  <?php
	}
  ?>
  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><span class="style27">
	<?php 
	$query7 = "select * from master_edition where status = 'ACTIVE'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7 = mysqli_fetch_array($exec7);
	$res7edition = $res7["edition"];
	if ($res7edition == 'FREE' or $res7edition == 'SPONSORED')
	{
		echo "Free Software By: WWW.SIMPLEINDIA.COM"; 
	}
	?>
	</span></td>
  </tr>
</table>
</body>