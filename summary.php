<?php
session_start();

include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date("d-m-Y H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$dateonly = date("Y-m-d");
$summarydate = date("Y-m-d");
$dischargedate = date("Y-m-d");

$paynowbillprefix = 'SUM-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from master_dischargesummary order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["summarynumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$summarynumber ='SUM-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["summarynumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$summarynumber = 'SUM-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

include ("sales1include1dischargesummary.php");
	$patientname = '';
	$patientcode = '';
	$patientage = '';
	$patientgender = '';
	$address1 = '';
	$address2 = '';
	$area = '';
	$city = '';
	$pincode = '';
	$dateofadmission = '';
	$dischargedate = '';
	$admissiontime = '';
	$dischargetime = '';
	$doctorcode = '';
	$doctorname = '';
	$drugallergies = '';
	$finaldiagnosis = '';
	$chiefcomplaints = '';
	$temparature = '';
	$pulse = '';
	$bloodpressure = '';
	$investigationdetails = '';
	$treatmentgiven = '';
	$diet = '';
	$physicalactivity = '';
	$status = '';
	
	$updatetime = '';
	$ipaddress = '';
	$wardname = '';
	$bednumber = '';
	$surgerydate = '';
	$patienthistory = '';
	$consultationreferral = '';
	$conditionatdischarge = '';
	$medication = '';
	$followup = '';
	$clinicalexamination = '';
	
	$medicalofficer = '';
	$consultantofficer = '';


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}
/*
if ($st == '1' && $banum != '')
{
	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}
*/
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
//$st = $_REQUEST["st"];

$query1 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode='$visitcode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$patientname = $res1["patientfullname"];
$patientcode = $res1["patientcode"];
$patientage = $res1["age"];
$patientgender = $res1["gender"];

$query34 = "select * from ip_discharge where patientcode = '$patientcode' and visitcode='$visitcode'";
$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res34 = mysqli_fetch_array($exec34);
$ward = $res34['ward'];
$bed = $res34['bed'];

           $query51 = "select * from master_bed where auto_number='$bed'";
		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res51 = mysqli_fetch_array($exec51);
		   $bedname = $res51['bed'];
		
		   $query7811 = "select * from master_ward where auto_number='$ward' and recordstatus=''";
		   $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res7811 = mysqli_fetch_array($exec7811);
		   $wardname = $res7811['ward'];
		   
$query35 = "select * from ip_bedallocation where patientcode = '$patientcode' and visitcode='$visitcode'";
$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res35 = mysqli_fetch_array($exec35);
$dateofadmission = $res35["recorddate"];
$admissiontime = $res35["recordtime"];
$dischargedate = $res34['recorddate'];
$dischargetime = $res34['recordtime'];

$query2 = "select * from master_customer where customercode = '$patientcode'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$address1 = $res2['address1'];
$address2 = $res2['address2'];
$area = $res2['area'];
$city = $res2['city'];
$state = $res2['state'];
$pincode = $res2['pincode'];

?>
<?php include ("includes/pagetitle1.php"); ?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<!--<script type="text/javascript" src="js/salesinsertitem1dischargesummary.js"></script>-->
<!--<script type="text/javascript" src="js/autoitemsearch2dischargesummary.js"></script>-->

<!--<script type="text/javascript" src="js/autosuggest2dischargesummary.js"></script>-->
<!--<script type="text/javascript" src="js/autocomplete_item1dischargesummary.js"></script>--> <!-- Drop Down List Holding File -->
<!--<script type="text/javascript" src="js/autocomplete_itemsearch3dischargesummary.js"></script>--> <!-- For mouse click event of item name drop down list. -->
<!--<script type="text/javascript" src="js/autoitemsearch3dischargesummary.js"></script>--> <!-- For enter key selection and mouse click event of item name drop down list. -->
<!--<script type="text/javascript" src="js/billnovalidation1.js"></script>-->

<style type="text/css">
<!--
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
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style7 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>

<script src="js/datetimepicker_css.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frmsales" id="frmsales" method="post" action="summary.php">
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
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3"><strong>Discharge Summary  </strong></td>
                <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>
                   
                  Doc No. 
                   
                  
                </strong></td>
                <td width="12%" bgcolor="#ecf0f5" class="bodytext3"><?php echo $summarynumber; ?>
                  <input name="summarynumber" id="summarynumber" value="<?php echo $summarynumber; ?>" style="border: 1px solid #001E6A; text-align:right" size="8" type="hidden"/>
               </td>
                <td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong> Date </strong></td>
                <td width="15%" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext312">
				
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $summarydate; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate')" style="cursor:pointer"/>
				  </span></td>
                <td width="12%" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">			</td>
              </tr>
			  <?php
				if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
				//$src = $_REQUEST["src"];
				if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
				//$st = $_REQUEST["st"];
				
     		  if (isset($_REQUEST["summarynumber"])) { $previoussummarynumber = $_REQUEST["summarynumber"]; } else { $previoussummarynumber = ""; }
			  //$previoussummarynumber = $_REQUEST["summarynumber"];
			  //if ($src == 'frm1submit1' && $st == 'success')
			  if ($st == '1')
			  {
			  ?>
              <tr>
                <td colspan="7" align="left" valign="middle"  bgcolor="#FFFF00" class="bodytext3">
				* Success. Dischare Summary Saved. Click  Print Button To Print or View	
				<!--<input name="billprint" type="button" onClick="return funcPrintDischargeSummary()" value="Print Discharge Summary" class="button" style="border: 1px solid #001E6A"/>-->
				* Please Check Your POPUP Settings & Unblock Popups.</td>
              </tr>
              <?php
			  //include ("zprintdmp1test2.php"); 
			  }
	if (isset($_REQUEST["delsummarynumber"])) { $delsummarynumber = $_REQUEST["delsummarynumber"]; } else { $delsummarynumber = ""; }
	//$delsummarynumber = $_REQUEST["delsummarynumber"];
	if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
	//$delBillSt = $_REQUEST["delbillst"];

			  //$delsummarynumber = $_REQUEST["delsummarynumber"];
			  //$delbillst = $_REQUEST["delbillst"];
			  
			  ?>
			  <tr>
                <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4">Patient  * </span></td>
                <td colspan="2" align="left" valign="middle" class="bodytext3"><?php echo $patientname; ?>
				<input name="patientname" id="patientname" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" type="hidden"/>				  </td>
                <td align="left" valign="middle"><div align="left"><span class="style4">Patient Code </span></div></td>
                <td align="left" valign="middle" class="bodytext3"><?php echo $patientcode; ?>
				<input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" readonly="readonly" size="12" rsize="20" type="hidden"/></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"  class="bodytext3"><strong>Age &amp; Gender </strong></td>
                <td align="left" valign="middle" class="bodytext3"><?php echo $patientage; ?><!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>-->
                  <input name="patientage" type="hidden" id="patientage"  value="<?php echo $patientage; ?>"size="10">
&amp;  <?php echo $patientgender; ?>
<input name="patientgender" type="hidden" value="<?php echo $patientgender; ?>" id="patientgender" size="10"></td>
			  </tr>
			  <tr>
			    <td align="left" valign="middle" ><div align="left"><span class="style4">Address 1 </span></div></td>
			    <td colspan="2" align="left" valign="middle" class="bodytext3"><?php echo $address1; ?><input name="address1" type="hidden" id="address1" style="border: 1px solid #001E6A;" value="<?php echo $address1; ?>" size="40" autocomplete="off"></td>
			    <td align="left" valign="middle" ><div align="left"><span class="style4">Visit Code</span></div></td>
			    <td align="left" valign="middle" class="bodytext3"><?php echo $visitcode; ?><input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" readonly="readonly" size="12" rsize="20" type="hidden"/></td>
			    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Ward &amp; Bed </strong></td>
			    <td align="left" valign="middle" class="bodytext3"><!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>-->
              <?php echo $wardname; ?>      <input name="wardname" type="hidden" id="wardname"  value="<?php echo $wardname; ?>"size="10">
  &amp;
 <?php echo $bedname; ?> <input name="bednumber" type="hidden" value="<?php echo $bednumber; ?>" id="bednumber" size="10"></td>
			  </tr>
			  <tr>
			    <td align="left" valign="middle" ><div align="left"><span class="style4">Address 2 </span></div></td>
			    <td colspan="2" align="left" valign="middle" class="bodytext3"><?php echo $address2; ?><input name="address2" type="hidden" id="address2" style="border: 1px solid #001E6A;" value="<?php echo $address2; ?>" size="40" autocomplete="off"></td>
			    <td align="left" valign="middle" ><div align="left"><span class="style4">Area &amp; City </span></div></td>
			    <td align="left" valign="middle" class="bodytext3"><?php echo $area; ?><input name="area" type="hidden" id="area" style="border: 1px solid #001E6A;" value="<?php echo $area; ?>" size="15" autocomplete="off">
			    &amp; <?php echo $city; ?>
			      <input name="city" type="hidden" id="city" style="border: 1px solid #001E6A;" value="<?php echo $city; ?>" size="15" autocomplete="off"></td>
			    <td align="left" valign="middle"  bgcolor="#ecf0f5"  class="bodytext3">&nbsp;</td>
			    <td align="left" valign="middle" >&nbsp;</td>
			    </tr>
			  
			  <tr>
			    <td align="left" valign="middle" ><span class="bodytext3"><strong>Admission Date </strong></span></td>
			    <td colspan="2" align="left" valign="middle" ><span class="bodytext3"><strong>
                  <input type="hidden" name="customertin" id="customertin" value="<?php echo $res41tinnumber; ?>" style="border: 1px solid #001E6A"  size="12" />
                  <span class="bodytext312"><?php echo $dateofadmission; ?>
                  <input name="dateofadmission" id="dateofadmission" type="hidden" style="border: 1px solid #001E6A" value="<?php echo $dateofadmission; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                 			  </span></strong></span></td>
			    <td align="left" valign="middle" ><span class="bodytext3"><strong>Admission Time </strong></span></td>
			    <td align="left" valign="middle" class="bodytext3"><?php echo $admissiontime; ?><input name="admissiontime" type="hidden" id="admissiontime" value="<?php echo $admissiontime; ?>" size="10"></td>
			    <td align="left" valign="top" >&nbsp;</td>
			    <td align="left" valign="top" >&nbsp;</td>
			  </tr>
			  <tr>
			    <td align="left" valign="top" ><span class="bodytext3"><strong>Discharge Date </strong></span></td>
			    <td colspan="2" align="left" valign="top" ><span class="bodytext3"><strong>
                  <input type="hidden" name="customercst" id="customercst" value="<?php echo $res41cstnumber; ?>" style="border: 1px solid #001E6A"  size="12" />
                  <span class="bodytext312"><?php echo $dischargedate; ?>
                  <input name="dateofdischarge" id="dateofdischarge" type="hidden" style="border: 1px solid #001E6A" value="<?php echo $dischargedate; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                			  </span></strong></span></td>
			    <td align="left" valign="top"  bgcolor="#ecf0f5"  class="bodytext3"><strong>Discharge Time </strong></td>
			    <td align="left" valign="top"  bgcolor="#ecf0f5"  class="bodytext3"><?php echo $dischargetime; ?><input name="dischargetime" type="hidden" id="dischargetime" value="<?php echo $dischargetime; ?>" size="10"></td>
			    <td align="left" valign="middle"  bgcolor="#ecf0f5"  class="bodytext3">&nbsp;</td>
			    <td width="26%" align="left" valign="top" >&nbsp;</td>
			  </tr>
            </tbody>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
              <td width="143" align="left" valign="center"  bgcolor="#ecf0f5" class="style7">Consultant  </td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext3"><strong>
			  
                <select name="doctorcode" id="doctorcode">
                  <?php
				if ($doctorcode == '')
				{
					echo '<option value="" selected="selected">Select Doctor Name</option>';
				}
				else
				{
					$query51 = "select * from master_doctor where doctorcode = '$doctorcode'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51doctorcode = $res51["doctorcode"];
					$res51doctorname = $res51["doctorname"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51doctorcode.'" selected="selected">'.$res51doctorname.'</option>';
				}
				
				$query5 = "select * from master_doctor where status = '' order by doctorname";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5doctorname = $res5["doctorname"];
				$res5doctorcode = $res5["doctorcode"];
				?>
                  <option value="<?php echo $res5doctorcode; ?>"><?php echo $res5doctorname; ?></option>
                  <?php
				}
				?>
                </select>
              </strong></span></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Surgery Date </strong></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext312">
                <input name="surgerydate" id="surgerydate" style="border: 1px solid #001E6A" value="<?php echo $surgerydate; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                <img src="images2/cal.gif" onClick="javascript:NewCssCal('surgerydate')" style="cursor:pointer"/> </span></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Drug Allergies </strong></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">
			  <input name="drugallergies" type="text" id="drugallergies" value="<?php echo $drugallergies; ?>" size="50"></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Final Diagnosis </strong></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
                <textarea name="finaldiagnosis" cols="75" rows="5" id="finaldiagnosis"><?php echo $finaldiagnosis; ?></textarea>
              </span></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><span class="bodytext311"><strong>Chief Complaints </strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <textarea name="chiefcomplaints" cols="75" rows="5" id="chiefcomplaints"><?php echo $chiefcomplaints; ?></textarea></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><span class="bodytext311"><strong>Patient History </strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <textarea name="patienthistory" cols="75" rows="5" id="patienthistory"><?php echo $patienthistory; ?></textarea></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Clinical Examiniation </strong></td>
              <td width="100" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Temparature</strong></td>
              <td width="77" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">
			  <input name="temparature" value="<?php echo $temparature; ?>" type="text" id="temparature" size="10"></td>
              <td width="62" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Pulse</strong></span></td>
              <td width="80" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">
			  <input name="pulse" value="<?php echo $pulse; ?>" type="text" id="pulse" size="10"></td>
              <td width="36" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>B.P.</strong></span></td>
              <td width="388" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">
			  <input name="bloodpressure" value="<?php echo $bloodpressure; ?>" type="text" id="bloodpressure" size="10"></td>
              <td width="13" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="13" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="18" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><span class="bodytext311"><strong>Clinical Examiniation </strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><span class="bodytext311">
                <textarea name="clinicalexamination" cols="75" rows="5" id="clinicalexamination"><?php echo $clinicalexamination; ?></textarea>
              </span></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><span class="bodytext311"><strong>Investigation Details </strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <textarea name="investigationdetails" cols="75" rows="5" id="investigationdetails"><?php echo $investigationdetails; ?></textarea></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Consultation Referral </strong></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
                <input name="consultationreferral" type="text" id="consultationreferral" value="<?php echo $consultationreferral; ?>" size="50">
              </span></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><span class="bodytext311"><strong>Treatment Given </strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <textarea name="treatmentgiven" cols="75" rows="5" id="treatmentgiven"><?php echo $treatmentgiven; ?></textarea></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><span class="bodytext311"><strong>Condition At Discharge </strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <textarea name="conditionatdischarge" cols="75" rows="5" id="conditionatdischarge"><?php echo $conditionatdischarge; ?></textarea></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Discharge Advice </strong></td>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Diet</strong></td>
              <td colspan="8" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">
			  <textarea name="diet" id="diet" rows="5" cols="40"><?php echo $diet; ?></textarea>
			 </td>
              </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Physical Activity </strong></span></td>
              <td colspan="8" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
			   <textarea name="physicalactivity" id="physicalactivity" rows="5" cols="40"><?php echo $physicalactivity; ?></textarea>
               
              </span></td>
              </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><span class="bodytext311"><strong>Medication </strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <textarea name="medication" cols="75" rows="5" id="medication"><?php echo $medication; ?></textarea></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Follow Up </strong></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
                <textarea name="followup" cols="75" rows="5" id="followup"><?php echo $followup; ?></textarea>
              </span></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Medical Officer </strong></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>
                <select name="medicalofficer" id="medicalofficer">
                  <?php
				if ($medicalofficer == '')
				{
					echo '<option value="" selected="selected">Select Medical Officer Name</option>';
				}
				else
				{
					$query51 = "select * from master_doctor where doctorcode = '$medicalofficer'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51doctorcode = $res51["doctorcode"];
					$res51doctorname = $res51["doctorname"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51doctorcode.'" selected="selected">'.$res51doctorname.'</option>';
				}
				
				$query5 = "select * from master_doctor where status = '' order by doctorname";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5doctorname = $res5["doctorname"];
				$res5doctorcode = $res5["doctorcode"];
				?>
                  <option value="<?php echo $res5doctorcode; ?>"><?php echo $res5doctorname; ?></option>
                  <?php
				}
				?>
                </select>
                (Signature)</strong></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Consultant</strong></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>
                <select name="consultantofficer" id="consultantofficer">
                  <?php
				if ($consultantofficer == '')
				{
					echo '<option value="" selected="selected">Select Doctor Name</option>';
				}
				else
				{
					$query51 = "select * from master_doctor where doctorcode = '$consultantofficer'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51doctorcode = $res51["doctorcode"];
					$res51doctorname = $res51["doctorname"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51doctorcode.'" selected="selected">'.$res51doctorname.'</option>';
				}
				
				$query5 = "select * from master_doctor where status = '' order by doctorname";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5doctorname = $res5["doctorname"];
				$res5doctorcode = $res5["doctorcode"];
				?>
                  <option value="<?php echo $res5doctorcode; ?>"><?php echo $res5doctorname; ?></option>
                  <?php
				}
				?>
                </select>
                (Signature)</strong></td>
            </tr>
            
            <tr>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
          </tbody>
        </table>		</td>
      </tr>
      <tr>
        <td class="bodytext31" valign="middle">
		<strong><div align="left">&nbsp;</div>
		</strong></td>
      </tr>
      <tr>
        <td><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
          <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
          <input name="delbillst" id="delbillst" type="hidden" value="<?php echo $delbillst;?>">
          <input name="delbillsummarynumber" id="delbillsummarynumber" type="hidden" value="<?php echo $delbillsummarynumber;?>">
          <input name="delsummarynumber" id="delsummarynumber" type="hidden" value="<?php echo $delsummarynumber;?>">
          <input name="Submit2223" type="submit" onClick="return funcSaveBill1()" value="Save Discharge Summary" accesskey="b" class="button" style="border: 1px solid #001E6A"/>
        </font></font></font></font></font></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
