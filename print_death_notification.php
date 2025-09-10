<?php
session_start();
ini_set('max_execution_time', 3000);
ini_set('memory_limit','-1');
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$currentdate = date('Y-m-d');
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$docno=$_SESSION["docno"];
ob_start();

$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res = mysqli_fetch_array($exec);
	
 	$locationname = $res["locationname"];
	$locationcode = $res["locationcode"];
//$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$emailid1 = $res2["emailid1"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$faxnumber1 = $res2["faxnumber1"];
$faxnumber2 = $res2["faxnumber2"];
$emailid1 = $res2["emailid1"];
?>
<?php
function roundTo($number, $to){ 
    return round($number/$to, 0)* $to; 
} 

?>
<?php
if(isset($_REQUEST['docno'])) { $docno = $_REQUEST["docno"];} else { $docno = ""; }
$qrydoc = "select * from death_notification where docno ='$docno'";
$execdoc = mysqli_query($GLOBALS["___mysqli_ston"], $qrydoc);
$resdoc = mysqli_fetch_array($execdoc);

	if (strlen($docno) == 1)
	{
		$maxanum1 = '00'.$docno;
	}
	else if (strlen($docno) == 2)
	{
		$maxanum1 = '0'.$docno;
	}
	else
	{
		$maxanum1 = $docno;
	}	
	
?>
<style type="text/css">
body {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 
}
.bodytext21 {FONT-WEIGHT: normal; FONT-SIZE: 18px; COLOR: #000000; 
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000;  text-decoration:none
}
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
table{
z-index:1;
}
#watermark {
  color: #EAEAEA;
  font-size: 144pt;
  font-family:"Times New Roman", Times, serif;
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  position: absolute;
  width: 100%;
  height: 100%;
  margin: 0;
  z-index: 0;
  left:-50;
  top:500px;
}
</style>
<table width="530" border="0" cellspacing="0" cellpadding="2">
	     <tr>
		    <td width="83" rowspan="4">
			  <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="55" height="55" />
			
			<?php
			}
			?></td> 
			<td width="365" colspan="4" align="center" class="bodytext21">
	        <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?>
			<strong><?php echo $companyname; ?></strong></td>
		    <td width="82" rowspan="4" align="center" class="bodytext22">
			 <strong>Serial No : <?php echo 'DN'.$maxanum1; ?></strong></td> 
        </tr>
		<tr>
		  <td colspan="4" align="center" class="bodytext23">
            <?php
			$address2 = $area.''.$pincode.' '.$city;
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?>
			<?php
			$address3 = "Tel: ".$phonenumber1.', '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>
			<?php echo $address2.','.$address3; ?></td>
  </tr>
            
            <tr>
              <td colspan="4" align="center" class="bodytext24">
			<?php
			$address5 = "Fax: ".$faxnumber1;
			$strlen3 = strlen($address5);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address5 = ' '.$address5;
			}
			?>
			<?php
			$address4 = " E-Mail: ".$emailid1;
			$strlen3 = strlen($address4);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address4 = ' '.$address4.' ';
			}
			?>
            <?php echo $address5.', '.$address4; ?></td>
	    </tr>
			<tr>
			  <td colspan="6" align="center">&nbsp;</td>
			</tr>
</table>
<table width="530" border="1" align="center" cellspacing="0" cellpadding="0">
  <tr>
    <td width="530" align="center" valign="middle" ><h3>DEATH NOTIFICATION </h3></td>
  </tr>
  <tr>
    <td><table width="530" cellspacing="0" cellpadding="0" >
        <tr>
          <td width="430" align="left" valign="middle" > 1. DECENDENT'S LEGAL NAME <strong><?php echo strtoupper($resdoc['patientname']);?></strong> </td>
          <td width="100" align="left" valign="middle" > 2. SEX <strong><?php echo strtoupper($resdoc['gender']);?></strong> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="530" cellspacing="0" cellpadding="0">
        <tr>
          <td width="173" align="left" valign="middle" > 3. AGE <strong> <?php echo strtoupper($resdoc['age']);?></strong> </td>
          <td width="173" align="left" valign="middle" > 4. DATE OF BIRTH <strong>
            <?php $customerdob=date_create($resdoc['dateofbirth']); echo date_format($customerdob,'d-M-Y');?>
            </strong> </td>
          <td width="173" align="left" valign="middle" > 5. PLACE OF BIRTH <strong> <?php echo strtoupper($resdoc['birth_place']);?></strong> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="530" cellspacing="0" cellpadding="0">
        <tr>
          <td width="173" align="left" valign="middle"  > 6a. RESIDENCE- CITY <strong> <?php echo strtoupper($resdoc['residence_city']);?></strong> </td>
          <td width="173" align="left" valign="middle"  > 6b. PARISH <strong> <?php echo strtoupper($resdoc['residence_parish']);?></strong> </td>
          <td width="173" align="left" valign="middle"  > 6c. DISTRICT <strong> <?php echo strtoupper($resdoc['residence_district']);?></strong> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="530" cellspacing="0" cellpadding="0">
        <tr>
          <td width="265" align="left" valign="middle"  > 7. MARITAL STATUS AT TIME OF DEATH <strong> <?php echo strtoupper($resdoc['marital_status']);?></strong> </td>
          <td width="265" align="left" valign="middle"  > 8. SURVIVING SPOUSE'S NAME (If wife, give name prior to first marriage) <strong>
            <?php if($resdoc['spousename']=='') { echo 'N/A';} else { echo strtoupper($resdoc['spousename']); }?>
            </strong> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="530" cellspacing="0" cellpadding="0">
        <tr>
          <td  width="265" align="left" valign="middle" > 9. FATHER'S NAME (First, Middle, Last) <strong> <?php echo strtoupper($resdoc['father_name']);?></strong> </td>
          <td  width="265" align="left" valign="middle" > 10. MOTHER'S NAME  PRIOR TO FIRST MARRIAGE (First, Middle, Last)<strong> <?php echo strtoupper($resdoc['mother_name']);?></strong> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="530" cellspacing="0" cellpadding="0">
        <tr>
          <td  width="173" align="left" valign="middle"  > 11a. INFORMANT'S NAME (First, Middle, Last) <strong> <?php echo strtoupper($resdoc['informant_name']);?></strong> </td>
          <td   width="173" align="left" valign="middle"  > 11b. RELATIONSHIP TO DECENDENT <strong> <?php echo strtoupper($resdoc['informant_relation']);?></strong> </td>
          <td   width="173" align="left" valign="middle"  > 11c. ADDRESS <strong> <?php echo strtoupper($resdoc['informant_address']);?></strong> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td><table width="530" cellspacing="0" cellpadding="0">
        <tr>
          <td  width="173" align="left" valign="middle"  > 12. IF DEATH OCCURED IN HOSPITAL <strong><?php echo $resdoc['deathloc']; ?></strong> </td>
          <td  width="173" align="left" valign="middle"  > 13. FACILITY NAME : <strong>NAKASERO HOSPITAL LIMITED</strong> </td>
          <td  width="173" align="left" valign="middle"  > 14. CITY : <strong>CENTRAL DIVISION </strong> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="530" cellspacing="0" cellpadding="0">
        <tr>
          <td width="265" align="left" valign="middle"  > 15. DISTRICT AND PARISH OF DEATH: <strong>KAMPALA</strong> </td>
          <td width="265" align="left" valign="middle"  > 16. DATE AND TIME PRONOUNCED DEAD <strong>&nbsp;<?php echo $resdoc['datetimeofdeath']; ?></strong> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right" valign="bottom" height="50"><table width="530" height="50" cellspacing="0" cellpadding="0">
        <tr>
          <td  width="370" align="left" valign="middle"  ></td>
          <td  width="160" align="center" valign="bottom"  > Signature of the Informant<br />
            (<?php echo strtoupper($resdoc['informant_name']);?>) </td>
        </tr>
      </table></td>
  </tr>
  <!--Signature of the informant closing -->
  <tr>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td><table width="530" height="50" cellspacing="0" cellpadding="0">
        <tr>
          <td width="450" align="left" valign="middle" style="border-right:solid;"><strong style="text-align:center"> 17. CAUSE OF DEATH (See instructions on the examples)</strong><br>
            <p style="text-align:left"><strong> PART 1.</strong> Enter the chain of events - diseases, injuries, or complaints - that directly caused the death. DO NOT enter terminal events such as cardic arrest, respiratory arrest or ventricular fibrillation without showing the etiology. DO NOT ABBREVIATE. Enter only one cause on a line.</p></td>
          <td  width="80" align="left"> Approximate interval: Onset to death </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="530" height="50" cellspacing="0" cellpadding="0" style="padding-top:5px;">
        <tr>
          <td width="120" rowspan="4" align="left"> IMMEDIATE CAUSE (Final disease or condition resulting in death) sequentially list conditions, if any leading to the cause listed on the line a.
            Enter the <strong>UNDERLYING CAUSE</strong>(disease on injury that initiated the events resulting in death) <strong>LAST</strong> </td>
          <td width="330" align="left" style="border-bottom:dashed;border-right:solid;"> a. <?php echo $resdoc['cause1']; ?> </td>
          <td align="center" width="80" style="border-bottom:dashed;"><?php echo $resdoc['interval1']; ?> </td>
        </tr>
        <tr>
          <td width="330" align="left" style="border-bottom:dashed;border-right:solid;"> b. <?php echo $resdoc['cause2']; ?> </td>
          <td align="center" width="80" style="border-bottom:dashed;"><?php echo $resdoc['interval2']; ?> </td>
        </tr>
        <tr>
          <td width="330" align="left" style="border-bottom:dashed;border-right:solid;"> c. <?php echo $resdoc['cause3']; ?> </td>
          <td align="center" width="80" style="border-bottom:dashed;"><?php echo $resdoc['interval3']; ?> </td>
        </tr>
        <tr>
          <td width="330" align="left" style="border-bottom:dashed;border-right:solid;"> d. <?php echo $resdoc['cause4']; ?> </td>
          <td align="center" width="80" style="border-bottom:dashed;"><?php echo $resdoc['interval4']; ?> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="530" height="50" cellspacing="0" cellpadding="0" style="padding-top:5px;">
        <tr>
          <td rowspan="2" width="265" align="left"><strong>PART 2.</strong>&nbsp;<span>Enter other <u>signaficant conditions contributing to death</u> but not <u>resulting in the underlying cause in <strong>PART 1</strong></u> </span> </td>
          <td  width="265" align="left"> 18. WAS AN AUTOPSY PERFORMED? <strong><?php echo $resdoc['autopsy_status']; ?></strong> </td>
        </tr>
        <tr>
          <td  width="265" align="left"> 19. WERE AUTOPSY FINDINGS AVAILABLE TO COMPLETE THE CAUSE OF DEATH? <strong><?php echo $resdoc['autopsy_finding']; ?></strong> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="530" cellspacing="0" cellpadding="0">
        <tr>
          <td width="265" align="left"> 20. IF FEMALE: <br>
            <strong>
            <?php if($resdoc['pregnant_status']!=''){echo $resdoc['pregnant_status'];}else{ echo 'N/A';} ?>
            </strong> </td>
          <td width="265" align="left"> 21. MANNER OF DEATH <br>
            <strong><?php echo $resdoc['manner_death']; ?></strong> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td width="530"> 22.Certifier<br />
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I, <strong><?php echo $resdoc['doctor_name'];?></strong> as <?php echo $resdoc['declaration'];?> </td>
  </tr>
  <tr >
    <td><table width="530" cellspacing="0" cellpadding="0">
	<tr>
	<td colspan="2" height="30">
	</td>
	<td align="left" valign="middle" >
	Record Filed On <strong> <?php $recdatetime=$resdoc['record_date'].' '.$resdoc['record_time']; echo date("d-M-Y h:i A",strtotime($recdatetime));?></strong>
	</td>
	</tr>
        <tr>
          <td width="150" align="left" valign="bottom"> Signature of Certifier </td>
          <td width="150" align="left" valign="bottom"  > License Number </td>
          <td width="160" align="left" valign="bottom" > Date & Time <strong> <?php echo trim(date("d-M-Y h:i A"));?></strong> </td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="530">
<tr>
<td width="530" style="text-align:center; font-size:12px">
Blood is FREE for all @ Nakasero Hospital. Sale of blood is illegal. Should you ever be asked to pay for blood at this facility please report IMMEDIATELY to info@nhl.co.ug 
</td>
</tr>
</table>
<?php	
/*require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("Arial", "normal");
$canvas->page_text(544, 1628,"1/21", $font, 10, array(0,0,0));
$canvas->page_text(272, 814," Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("FinalBill.pdf", array("Attachment" => 0)); */
?>
<?php
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");

$dompdf->render();
$dompdf->stream("birthnotificationcopy.pdf", array("Attachment" => 0)); 
?>
