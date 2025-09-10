<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
	
	$query7 = "SELECT * FROM dischargesummary where  patientcode = '$patientcode' and patientvisitcode ='$visitcode' order by auto_number desc ";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die("Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7 = mysqli_fetch_array($exec7);
	$patientname = $res7["patientname"];
	$patientcode = $res7["patientcode"];
	$patientvisitcode = $res7["patientvisitcode"];
	$summarydate = $res7["summarydate"];
	$patientage = $res7["patientage"];
	$patientgender = $res7["patientgender"];
	$wardnumber = $res7["wardnumber"];
	$bednumber = $res7['bednumber'];
	$discharged = $res7["discharged"];
	$transrefer = $res7["transrefer"];
	$transferto = $res7['transferto'];
	$admissiondate = $res7['admissiondate'];
	$dischargedate = $res7['dischargedate'];
	$leavedate = $res7['leavedate'];
	$primaryname = $res7['primaryname'];
	$secondary = $res7['secondary'];
	$opprocedure = $res7['opprocedure'];
	$opprocdate = $res7['opprocdate'];
	$otherlabimage = $res7['otherlabimage'];
	$diagnosisintraop = $res7['diagnosisintraop'];
	$incission = $res7['incission'];
	$procfind = $res7['procfind'];
	$referother = $res7['referother'];
	$asneeded = $res7["asneeded"];
	$day = $res7["day"];
	$day1 = $res7['day1'];
	$returndate = $res7['returndate'];
	$returntime = $res7['returntime'];
	$referdoctor = $res7["referdoctor"];
	$referdoctor1 = $res7['referdoctor1'];
	$rconurse = $res7["rconurse"];
	$doctor = $res7["doctor"];
	$doctor1 = $res7['doctor1'];
	$opd = $res7["opd"];
	$tb = $res7["tb"];
	$mchfp = $res7["mchfp"];
	$treatmentrun = $res7["treatmentrun"];
	$gensurg = $res7["gensurg"];
	$accord = $res7["accord"];
	$otho = $res7["otho"];
	$gynae = $res7["gynae"];
	$paesdsurg = $res7["paesdsurg"];
	$paeds = $res7["paeds"];
	$ent = $res7["ent"];
	$other = $res7["other"];
	$other1 = $res7['other1'];
	$castoff = $res7["castoff"];
	$xraylabs = $res7["xraylabs"];
	$xraylabs1 = $res7['xraylabs1'];
	$xraylabs1 = $res7["xraylabs1"];
	$patientdischarge = $res7["patientdischarge"];
	$compilefile = $res7["compilefile"];
	$informpatient = $res7["informpatient"];
	$takerelative = $res7["takerelative"];
	$returnvaluables = $res7["returnvaluables"];
	$checkreceipt = $res7["checkreceipt"];
	$educatemeds = $res7["educatemeds"];
	$schedulevisit = $res7["schedulevisit"];
	$doctorname  = $res7["doctorname"];
?>

<?php 
$query1 = "SELECT * FROM master_ipvisitentry where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode = '$visitcode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$patientname = $res1['patientfullname'];
$age = $res1['age'];
$gender = $res1['gender'];

$query2 = "SELECT * FROM ip_bedallocation where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode = '$visitcode'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$bed = $res2['bed'];
$ward = $res2['ward'];
$recorddate = $res2['recorddate'];
$query3 = "SELECT * FROM master_ward where locationcode='$locationcode' and auto_number = '$ward'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$wardname = $res3['ward'];
$query4 = "SELECT * FROM master_bed where locationcode='$locationcode' and auto_number = '$bed'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$bedname = $res4['bed'];
$query4 = "select * from  consultation_icd where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode' and primarydiag <> ''  order by auto_number desc limit 0,1";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$primarydiag = $res4['primarydiag'];
$primaryicdcode = $res4['primaryicdcode'];
$query5 = "select * from  consultation_icd where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode' and secondarydiag <> ''  order by auto_number desc limit 0,1";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$secondarydiag = $res5['secondarydiag'];
$secicdcode = $res5['secicdcode'];
$query1 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1emailid1= $res1['emailid1'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$res1phonenumber1 = $res1['phonenumber1'];
?>
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 
.bodytext31 {FONT-SIZE: 14px; COLOR: #000000; 
}
-->
</style>
<?php include('print_header.php'); ?>

<table width="64%" border="0" cellspacing="0" cellpadding="2">
 <tr>
   <td colspan="6" align="left" valign="center" 
	  class="bodytext31"><table width="100%" border="0">      
      <tr >
        <td colspan="6"  align="center" class="bodytext3"><strong>DISCHARGE SUMMARY</strong></td>
        </tr>
      <tr >
        <td colspan="6"  class="bodytext3">&nbsp;</td>
        </tr>
      <tr >
          <td width="116" class="bodytext3" ><strong>Patient  </strong></td>
          <td width="243" class="bodytext31" align="left" valign="middle" ><?php echo $patientname; ?></td>
          <td width="80"   class="bodytext3"><strong>Date </strong></td>
          <td width="80"  class="bodytext31"><?php if($summarydate != '0000-00-00') { echo $summarydate; }  ?></td>
          <td width="41" align="left" valign="middle" class="bodytext3"><strong>Ward</strong></td>
          <td width="221" align="left" valign="middle" class="bodytext31"><?php echo $wardname;?></td>
      </tr>
        <tr>
          <td width="116" align="left" valign="middle"   class="bodytext3"><strong>Patient Code</strong></td>
          <td width="243" class="bodytext31" align="left" valign="middle" ><?php echo $patientcode; ?></td>
          <td width="80" align="left" valign="middle"   class="bodytext3"><strong>Visit Code </strong></td>
          <td width="80" align="left" valign="top" class="bodytext31"><?php echo $patientvisitcode; ?><strong></strong></td>
          <td width="41" align="left" valign="top" class="bodytext3"><strong>Bed</strong></td>
          <td align="left" valign="top" class="bodytext31"><?php echo $patientgender; ?></td>
        </tr>
        <tr>
          <td width="116" align="left" valign="middle"   class="bodytext3"><strong>Age &amp; Gender </strong></td>
          <td colspan="5" align="left" valign="middle" class="bodytext31"><?php echo $patientage; ?> & <?php echo $patientgender; ?></td>
        </tr>
   </table></td>
 </tr>
 <tr>
   <td colspan="6" align="left" valign="center" 
	  class="bodytext31">&nbsp;</td>
 </tr>
 <tr>
   <td colspan="6" align="left" valign="center" 
	  class="bodytext31"><table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
     <tbody>
       <tr>
         <td colspan="4"align="left" valign="middle"   class="bodytext31"><strong>Discharged </strong>
             <?php if($discharged == '1') { echo 'Yes'; } else { echo 'No';  }?></td>
         <td colspan="8" align="left" valign="middle" class="bodytext31"><strong>Transfer/Referal to : </strong>
             <?php if($transferto != '') { echo $transferto; } ?></td>
       </tr>
       <tr>
         <td colspan="12" align="left" valign="middle"   class="bodytext3">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="middle"   class="bodytext31"><strong>Admit Date </strong><?php echo $admissiondate; ?></td>
         <td width="223" align="left" valign="middle"   class="bodytext31"><strong>Discharge Date </strong><?php echo $dischargedate; ?></td>
         <td width="25" align="left" valign="middle"   class="bodytext3">&nbsp;</td>
         <td width="42" align="right" valign="middle"   class="bodytext3">&nbsp;</td>
         <td colspan="5" align="left" valign="middle"   class="bodytext31"><strong>Leaving Date </strong><?php echo $leavedate; ?></td>
       </tr>
       <tr>
         <td colspan="12" align="left" valign="middle"   class="bodytext3">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="12" align="left" valign="middle"   class="bodytext3"><strong>Discharge Diagnosis: </strong></td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="middle"   class="bodytext3"><strong>Primary:</strong></td>
         <td colspan="5" align="left" valign="middle"   class="bodytext31">
		 <?php
					$query4p = "select primarydiag,primaryicdcode from  discharge_icd where patientcode='$patientcode' and patientvisitcode='$patientvisitcode' and primarydiag <> ''  order by auto_number desc";
					$exec4p = mysqli_query($GLOBALS["___mysqli_ston"], $query4p) or die ("Error in Query4p".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res4p = mysqli_fetch_array($exec4p)){
						$primarydiagp = $res4p['primarydiag'];
						$primaryicdcodep = $res4p['primaryicdcode'];
						if($primaryicdcodep!=''){
							 echo $primarydiagp."/ ".$primaryicdcodep."<br> ";
						}
					}
		?></td>
		 <td width="107" colspan="3" align="left" valign="middle"   class="bodytext3">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="middle"   class="bodytext3"><strong>Secondary:</strong></td>
         <td colspan="5" align="left" valign="middle"   class="bodytext31">
				<?php
				
					$query4s = "select secondarydiag,secicdcode from  discharge_icd where patientcode='$patientcode' and patientvisitcode='$patientvisitcode' and secondarydiag <> ''  order by auto_number desc";
					$exec4s = mysqli_query($GLOBALS["___mysqli_ston"], $query4s) or die ("Error in Query4s".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res4s = mysqli_fetch_array($exec4s)){
						$secondarydiags = $res4s['secondarydiag'];
						$secicdcodes = $res4s['secicdcode'];
						if($secicdcodes!=''){
							 echo $secondarydiags."/ ".$secicdcodes."<br> ";
						}
					}
				?>
		 </td>
		 <td width="107" colspan="3" align="left" valign="middle"   class="bodytext3">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="middle"   class="bodytext3"><strong>Operations/Procedure</strong></td>
         <td width="263" align="left" valign="middle"   class="bodytext31"><?php echo $opprocedure; ?></td>
         
         <td colspan="6" align="left" valign="middle"   class="bodytext31"><strong>Date </strong><?php echo $opprocdate; ?></td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="middle"   class="bodytext3"><strong>Other Laboratory/Imaging Findings </strong></td>
         <td colspan="8" align="left" valign="middle"  class="bodytext31" ><?php echo $otherlabimage; ?> </td>
       </tr>
       <tr>
         <td colspan="12" align="left" valign="middle"   class="bodytext3">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="12" align="left" valign="middle"   class="bodytext3"><strong>Discharge Medications &amp; Supplies:</strong></td>
       </tr>
       <?php 
				$query16 = "SELECT * FROM ipmedicine_issue where locationcode='$locationcode' and visitcode = '$visitcode' and dischargemedicine = 'Yes'";
				$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num16 = mysqli_num_rows($exec16);
	   ?>
       <?php
	    if($num16 != 0)
		 {
	   ?>
       <?php 
	     }
	    ?>
       <?php 
					$query6 = "SELECT * FROM ipmedicine_issue where locationcode='$locationcode' and visitcode = '$visitcode' and dischargemedicine = 'Yes'";
					$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res6 = mysqli_fetch_array($exec6))
					{
					$itemname = $res6['itemname'];
					$dose = $res6['dose'];
					$frequency = $res6['frequency'];
					$days = $res6['days'];
					$quantity = $res6['quantity'];
					$route = $res6['route'];
					?>
       <?php 
					}
				  ?>
       <tr>
         <td colspan="12" align="left" valign="middle"   class="bodytext3"><table width="500" border="0">
             <tr>
               <td width="245" align="left" valign="middle"  class="bodytext3"><strong>Medicine Name</strong></td>
               <td width="59" align="left" valign="middle"  class="bodytext3"><strong>Dose</strong></td>
               <td width="86" align="left" valign="middle"  class="bodytext3"><strong>Frequency</strong></td>
               <td width="87" align="left" valign="middle"  class="bodytext3"><strong>Days</strong></td>
               <td width="90" align="left" valign="middle"  class="bodytext3"><strong>Quantity</strong></td>
               <td width="101" align="left" valign="middle"  class="bodytext3"><strong>Route</strong></td>
             </tr>
             <?php 
					$query6 = "SELECT * FROM ipmedicine_issue where locationcode='$locationcode' and visitcode = '$visitcode' and dischargemedicine = 'Yes'";
					$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res6 = mysqli_fetch_array($exec6))
					{
					$itemname = $res6['itemname'];
					$dose = $res6['dose'];
					$frequency = $res6['frequency'];
					$days = $res6['days'];
					$quantity = $res6['quantity'];
					$route = $res6['route'];
					?>
             <tr>
               <td align="left" valign="middle" class="bodytext31"  ><?php echo $itemname; ?></td>
               <td align="left" valign="middle" class="bodytext31"  ><?php echo $dose; ?></td>
               <td align="left" valign="middle" class="bodytext31"  ><?php echo $frequency; ?></td>
               <td align="left" valign="middle" class="bodytext31"  ><?php echo $days; ?></td>
               <td align="left" valign="middle" class="bodytext31"  ><?php echo intval($quantity); ?></td>
               <td 	align="left" valign="middle" class="bodytext31"  ><?php echo $route; ?></td>
             </tr>
             <?php 
			 }
		    ?>
         </table></td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="middle"   class="bodytext3">&nbsp;</td>
         <td colspan="8" align="left" valign="middle"   class="bodytext3">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="middle"   class="bodytext3"><strong>Referral/Other Instructions</strong></td>
         <td colspan="8" align="left" valign="middle"  class="bodytext31" ><?php echo wordwrap($referother,50,"<br>\n"); ?> </td>
       </tr>
       <tr>
         <td colspan="2" align="left" valign="middle"   class="bodytext3"><strong>Doctor Name</strong></td>
         <td colspan="10" align="left" valign="middle"   class="bodytext31"><?php echo $doctorname; ?></td>
       </tr>
       <tr>
         <td colspan="12" align="left" valign="middle"   class="bodytext3">&nbsp;</td>
       </tr>
       <tr>
         <td width="116" align="left" valign="middle"   class="bodytext3"><strong>Return To Clinic </strong></td>
         <td width="104" align="left" valign="middle"   class="bodytext31"><?php if($asneeded == '1') { echo 'As Needed'; } ?></td>
         <td colspan="4" align="left" valign="middle"   class="bodytext31"><?php if($day == '1')  { echo 'Day : '; } ?>
             <?php echo $day1; ?> </td>
         <td width="42" align="left" valign="middle"  class="bodytext3" >Date</td>
         <td width="80" align="left" valign="middle"  class="bodytext31" ><?php echo $returndate; ?> </td>
         <td width="35" align="left" valign="middle"  class="bodytext3" >Time</td>
         <td width="107" align="left" valign="middle"  class="bodytext31" ><?php echo date('H:i',strtotime($returntime)); ?> </td>
       </tr>
       <tr>
         <td colspan="12" align="left" valign="middle"   class="bodytext3">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="12" align="left" valign="middle"   class="bodytext31"><strong>To See : </strong>
             <?php if($referdoctor == '1' && $referdoctor !='') { echo 'Your Referring Doctor/Hospital : '; } ?>
           <?php echo $referdoctor1; ?> </td>
       </tr>
       <tr>
         <td colspan="12" align="left" valign="middle"   class="bodytext3">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="12" align="left" valign="middle"   class="bodytext3">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="12" align="left" valign="middle"   class="bodytext3"><?php if($rconurse == '1') { echo 'RCO/Nurse'.''; } ?>
             <?php if($doctor == '1') { echo 'Dr'.''; } ?>
             <?php if($opd == '1') { echo 'OPD'.''; } ?>
             <?php if($tb == '1') { echo 'TB'.''; } ?>
             <?php if($mchfp == '1') { echo 'CH/FP'.''; } ?>
             <?php if($treatmentrun == '1') { echo 'Treatment Rm'.''; } ?>
             <?php if($gensurg == '1') { echo 'Gen Surg'.''; } ?>
             <?php if($accord == '1') { echo 'Accord'.''; } ?>
             <?php if($otho == '1') { echo 'Ortho'.''; } ?>
             <?php if($gynae == '1') { echo 'Gynae'.''; } ?>
             <?php if($paesdsurg == '1') { echo 'Paeds Surg'.''; } ?>
             <?php if($paeds == '1') { echo 'Paeds'.''; } ?>
             <?php if($ent == '1') { echo 'ENT'.''; } ?>
             <?php if($other == '1') { echo 'Other'; } ?>         </td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="middle"   class="bodytext3">&nbsp;</td>
         <td colspan="8" align="left" valign="middle"  >&nbsp;</td>
       </tr>
       <tr>
         <td align="left" valign="middle"   class="bodytext3"><strong>On Return </strong></td>
         <td colspan="2" align="left" valign="middle"   class="bodytext31"><?php if($castoff == '1') { echo 'Cast Off'; } ?></td>
         <td colspan="9" align="left" valign="middle"   class="bodytext31"><?php if($xraylabs == '1') { echo ' X-Ray Labs'; } ?></td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="left"   class="bodytext3">&nbsp;</td>
         <td colspan="8" align="left" valign="middle"  >&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="left"   class="bodytext3"><strong>Discharge Check List : </strong></td>
         <td colspan="8" align="left" valign="middle"  >&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="left"   class="bodytext3">&nbsp;</td>
         <td colspan="8" align="left" valign="middle"  >&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="left"   class="bodytext31"><?php if($patientdischarge == '1') { echo 'Inform Patient Of Discharge'; } ?>         </td>
         <td colspan="8" align="left" valign="middle"  class="bodytext31" ><?php if($patientdischarge == '1') { echo 'Check Payment Receipt; Cancel Name On Census And Enter In Discharge Book'; } ?>         </td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="left"   class="bodytext31"><?php if($compilefile == '1') { echo 'Compile Patient File'; } ?>         </td>
         <td colspan="8" align="left" valign="middle"  class="bodytext31" ><?php if($educatemeds == '1') { echo 'Educate On Meds &amp; Instructions'; } ?>         </td>
       </tr>
       <tr>
         <td colspan="4" align="left" valign="left"   class="bodytext31"><?php if($informpatient == '1') { echo 'Inform Patient Of Bill'; } ?>         </td>
         <td colspan="8" align="left" valign="middle"  class="bodytext31" ><?php if($schedulevisit == '1') { echo 'Call To Schedule Return Visit Is Made'; } ?>         </td>
       </tr>
       <tr>
         <td colspan="4" align="left"  class="bodytext31" ><?php if($takerelative == '1') { echo 'Take Patient/Relative To Billing Office'; } ?>         </td>
       </tr>
       <tr>
         <td colspan="4" align="left"  class="bodytext31" ><?php if($returnvaluables == '1') { echo 'Return Clothes And Valuables'; } ?>         </td>
         <td colspan="8" align="middle"  >&nbsp;</td>
       </tr>
       <tr>
         <td colspan="12" align="middle"  >&nbsp;</td>
       </tr>
       <tr>
         <td colspan="12" align="middle"  >&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" align="left"  class="bodytext3" ><strong>Nurse Sign:</strong></td>
         <td colspan="8" align="middle"  class="bodytext3" ><strong>Date:</strong></td>
       </tr>
     </tbody>
   </table></td>
 </tr>
</table>

<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
		//$html2pdf->setDefaultFont('Arial');
//      $html2pdf->setModeDebug();
        //$html2pdf->SetMargins('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('dischargesummary.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>