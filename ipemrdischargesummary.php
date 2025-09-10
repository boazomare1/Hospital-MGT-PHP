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

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

$query22 = "select * from master_customer where customercode = '$patientcode'";
$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
$res22 = mysqli_fetch_array($exec22);
$address1 = $res22['address1'];
$address2 = $res22['address2'];
$area = $res22['area'];
$city = $res22['city'];
$state = $res22['state'];
$pincode = $res22['pincode'];

$query1 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode='$visitcode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$patientname = $res1["patientfullname"];
$patientcode = $res1["patientcode"];
$patientage = $res1["age"];
$patientgender = $res1["gender"];

$query2 = "select * from master_dischargesummary where patientcode = '$patientcode' ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$consultantofficer = $res2["consultantofficer"];
$summarynumber = $res2["summarynumber"];
$summarydate = $res2["summarydate"];
$surgerydate = $res2["surgerydate"];
$res2dischargedate = $res2["dischargedate"];
$res2dischargetime = $res2["dischargetime"];
$res2drugallergies = $res2["drugallergies"];
$res2finaldiagnosis = $res2["finaldiagnosis"];
$res2chiefcomplaints= $res2["chiefcomplaints"];
$res2patienthistory= $res2["patienthistory"];
$res2temperature= $res2["temperature"];
$res2pulse= $res2["pulse"];
$res2bloodpressure= $res2["bloodpressure"];
$res2clinicalexamination= $res2["clinicalexamination"];
$res2investigationdetails= $res2["investigationdetails"];
$res2treatmentgiven= $res2["treatmentgiven"];
$res2conditionatdischarge= $res2["conditionatdischarge"];
$res2diet= $res2["diet"];
$res2physicalactivity= $res2["physicalactivity"];
$res2medicalofficer= $res2["medicalofficer"];
$res2medication= $res2["medication"];
$res2medication= $res2["medication"];
$res2followup= $res2["followup"];
$res2consultationreferral= $res2["consultationreferral"];

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
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
         	  <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
   
                <tr>
                <td colspan="34" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Discharge Summary  </strong></div></td>
                </tr>


			    <tr>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4">Patient</span></td>
			      <td colspan="2" align="left" valign="middle" class="bodytext3"><?php echo $patientname; ?></td>
			      <td width="13%" align="left" valign="middle" class="bodytext3"><span class="style4">Patient Code </span></td>
			      <td width="12%" align="left" valign="middle" class="bodytext3"><?php echo $patientcode; ?></td>
			      <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5"  class="bodytext3"><strong>Doc No.</strong></td>
			      <td width="23%" align="left" valign="middle" class="bodytext3"><?php echo $summarynumber; ?></td>
		      </tr>
		        <tr>
		          <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4">Address 1 </span></td>
		          <td colspan="2" align="left" valign="middle" class="bodytext3"><?php echo $address1; ?></td>
		          <td align="left" valign="middle"><span class="style4">Visit Code</span></td>
		          <td align="left" valign="middle" class="bodytext3"><?php echo $visitcode; ?></td>
		          <td align="left" valign="middle"  bgcolor="#ecf0f5"  class="bodytext3"><strong>Date </strong></td>
		          <td align="left" valign="middle" class="bodytext3"><?php echo $summarydate; ?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left"><span class="style4">Address 2 </span></div></td>
		          <td colspan="2" align="left" valign="middle" class="bodytext3"><?php echo $address1; ?></td>
		          <td align="left" valign="middle"><span class="style4">Area &amp; City </span></td>
		          <td align="left" valign="middle" class="bodytext3"><?php echo $area.' & '.$city; ?></td>
		          <td align="left" valign="middle"  bgcolor="#ecf0f5"  class="bodytext3"><strong>Age &amp; Gender </strong></td>
		          <td align="left" valign="middle" class="bodytext3"><?php echo $patientage.' & '.$patientgender; ?></td>
	            </tr>
		        <tr>
                <td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Admission Date</strong></td>
                <td colspan="2" align="left" valign="middle" class="bodytext3"><?php echo $dateofadmission; ?></td>
                <td align="left" valign="middle"><div align="left"><span class="bodytext3"><strong>Admission Time </strong></span></div></td>
                <td align="left" valign="middle" class="bodytext3"><?php echo $admissiontime; ?></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"  class="bodytext3"><strong>Ward &amp; Bed </strong></td>
                <td align="left" valign="middle" class="bodytext3"><?php echo $ward.' & '.$bed; ?></td>
			  </tr>

			  <tr>
			    <td align="left" valign="middle" ><span class="bodytext3"><strong>Discharge Date </strong></span></td>
			    <td colspan="2" align="left" valign="middle" class="bodytext3"><?php echo $res2dischargedate; ?></td>
			    <td align="left" valign="middle" ><span class="bodytext3"><strong>Discharge Time </strong></span></td>
			    <td align="left" valign="middle" class="bodytext3"><?php echo $res2dischargetime; ?></td>
			    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Surgery Date </strong></td>
			    <td align="left" valign="middle" class="bodytext3"><?php echo $surgerydate; ?></td>
			  </tr>
        </table>
				
         <tr>
        <td>
	    <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><strong>Drug Allergies </strong></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2drugallergies; ?></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><strong>Final Diagnosis </strong></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2finaldiagnosis; ?></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><strong>Chief Complaints </strong></span></td>
            <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2chiefcomplaints; ?></td>
            </tr>
            
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext311"><strong>Patient History </strong></span></td>
             <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2patienthistory; ?></td>
            </tr>
			 <tr>
                <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
            </tr>
			
            <tr>
              <td colspan="34" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><strong>Clinical Examiniation </strong></td>
              </tr>
          
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Clinical Examiniation </strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2clinicalexamination; ?></td>
            </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><strong>Temparature</strong></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2temperature; ?></td>
              </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Pulse</strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2pulse; ?></td>
              </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>B.P.</strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2bloodpressure; ?></td>
              </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Investigation Details </strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2investigationdetails; ?></td>
            </tr>
            
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Consultation Referral </strong></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res2consultationreferral; ?></td>
            </tr>
            
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Treatment Given </strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res2treatmentgiven; ?> </td>
            </tr>
            
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Condition At Discharge </strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><?php echo $res2conditionatdischarge; ?></span></td>
            </tr>
            <tr>
              <td colspan="10" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>
            
            <tr>
              <td colspan="34" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Discharge Advice </strong></td>
			</tr>
			<tr>  
              <td width="143" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			  <td width="143" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><strong>Diet</strong></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2diet; ?></td>
              </tr>
            
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Physical Activity </strong></span></td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"> <?php echo $res2physicalactivity; ?></td>
              </tr>
            <tr>
              <td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="34" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong>Medication </strong></span></td>
			</tr>
			<tr>  
             <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2medication; ?></td>
            </tr>
            <tr>
              <td colspan="10" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>
            <tr>
              <td colspan="34" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Follow Up </strong></td>
			  </tr>
			  <tr>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><?php echo $res2followup; ?></td>
            </tr>
            <tr>
              <td colspan="10" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>
            <tr>
              <td colspan="34" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Medical Officer </strong></td>
			  </tr>
			  <tr>
              <td colspan="9" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $res2medicalofficer; ?></td>
            </tr>
            <tr>
              <td colspan="10" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>
            <tr>
              <td colspan="34" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Consultant</strong></td>
			 </tr>
			 <tr>  
               <td  align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $consultantofficer; ?></td>
            </tr>
            <tr>
              <td colspan="10" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>
        </table>		</td>
      </tr>
      <tr>
        <td class="bodytext31" valign="middle">
		<strong><div align="left">&nbsp;</div>
		</strong></td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
  
<?php include ("includes/footer1.php"); ?>
</body>
</html>
