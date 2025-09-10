 <?php
session_start();
include ("db/db_connect.php");
date_default_timezone_set('Africa/Nairobi'); 
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly = date("Y-m-d");
$docno = $_SESSION['docno'];
$timeonly = date("H:i:s");
$username = $_SESSION["username"];

ob_start();
if(isset($_REQUEST['docno'])) { $docno = $_REQUEST["docno"];} else { $docno = ""; }
$qrydoc = "select * from birth_notification where docno ='$docno'";
$execdoc = mysqli_query($GLOBALS["___mysqli_ston"], $qrydoc);
$resdoc = mysqli_fetch_array($execdoc);
//echo "hii".$billnumber;
	$query2 = "select * from master_company where auto_number = '$companyanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$companyname = $res2["companyname"];
	$address1 = $res2["address1"];
	$area = $res2["area"];
	$city = $res2["city"];
	$pincode = $res2["pincode"];
	$phonenumber1 = $res2["phonenumber1"];
	$phonenumber2 = $res2["phonenumber2"];
	$tinnumber1 = $res2["tinnumber"];
	$cstnumber1 = $res2["cstnumber"];
	
	//include('convert_currency_to_words.php');

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
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000; 
}
.bodytext3 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 
}
</style>

<table width="530" border="0" cellpadding="0" cellspacing="0" align="center">  
	<tr>
<?php 
$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$country = $res2["country"];

$city = $res2["city"];
$pincode = $res2["pincode"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];
?>

    <td width="100" rowspan="4" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31">
	
	<?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="100" height="100" />
			
			<?php
			}
			?>	</td>
			
 
		  
  </tr>
		
		      <?php
			$address2 = $area.''.$city.' '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';    
			}
			?>			
		  
		<tr>
			<td colspan="3" class="bodytext32"><div align="left"><?php echo $companyname; ?>
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
		    </div></td><td colspan="2" class="bodytext32"></td>	
			<td width="172" colspan="2" class="bodytext32"><div align="right">Serial No : <?php echo 'BN'.$maxanum1; ?></div></td>
		</tr>

<tr><td colspan="3" class="bodytext32">
			
			  <div align="left"><?php echo $address2; ?>
		        <?php
			$address3 = "PHONE: ".$phonenumber1.' '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>			
	        </div></td>	
<td colspan="4" style="">&nbsp;</td>
</tr>
<tr>
<td colspan="5" style="">&nbsp;</td>
</tr>
<tr>
<td colspan="8" style="border-bottom:solid 1px #000000;"><div align="center" style="font-size:18px;"><strong>NOTIFICATION OF BIRTH</strong></div></td>
</tr>
</table>

<table width="530" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td style="border-bottom:solid 1px #000000;">&nbsp;</td>
</tr>
  <tr>
	  <td width="52" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;"><strong>NAME OF THE CHILD </strong></td>
	  <td width="27" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;"><strong>WEIGHT</strong></td>
	 
	
	 
  </tr>
   <tr <?php //echo $colorcode; ?>>
             
			   
				<td height="27" class="bodytext32" valign="center"  align="center" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;">
			   <?php echo strtoupper($resdoc['child_name']);?></td>
				<td  height="27" class="bodytext32" valign="center"  align="center" style="border:solid 1px #000000; background:#FFFFFF;">
			 <?php echo $resdoc['weight']; ?></td>
			 
			 </tr>
			 </table>
			 
			 
			 <table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr><tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
  
  
	</table>
	
<table width="530" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
	  <td width="52" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;"><strong>DATE OF BIRTH OF CHILD</strong></td>
	  <td width="27" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-right:none;"><strong>SEX</strong></td>
	  <td width="67" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-right:none;"><strong>DISTRICT</strong></td>
    <td width="68" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-right:none;"><strong>SUB-COUNTY</strong></td>
	 <td width="53" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-right:none;"><strong>PARISH</strong></td>
	  <td width="63" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;"><strong>VILLAGE</strong></td>
	
	 
  </tr>
   <tr <?php //echo $colorcode; ?>>
             
			   
				<td height="27" class="bodytext32" valign="center"  align="center" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;">
			   <?php echo date('d-M-Y h:i:s A',strtotime($resdoc['baby_birth']));?></td>
				<td height="27" class="bodytext32" valign="center"  align="center" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;">
			 <?php echo $resdoc['child_gender']; ?></td>
				<td height="27" align="center" valign="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;">
			   <?php echo "KAMPALA"; ?></td>
			   <td height="27" align="center" valign="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;">
			   <?php  echo "CENTRAL - DIVISION"; ?></td>
			   <td height="27" align="center" valign="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;">
			   <?php echo "NAKASERO"; ?></td>
			    <td  height="27" align="center" valign="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;">
			   <?php echo 'HOSPITAL ZONE'; ?></td>
			   
  </tr>
  
  </table>
  <table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr><tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
  
  
	</table>

  
  <table width="530" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
	  <td width="52" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;"><strong>NAME OF FATHER</strong></td>
	  <td width="27" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-right:none;"><strong>NATIONALITY OF FATHER</strong></td>
	  <td width="67" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-right:none;"><strong>NIN/AIN</strong></td>
    <td width="68" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-right:none;"><strong>NAME OF MOTHER</strong></td>
	 <td width="53" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;border-right:none;"><strong>NATIONALITY OF MOTHER</strong></td>
	  <td width="63" align="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;"><strong>NIN/AIN</strong></td>
	
	 
  </tr>
   <tr <?php //echo $colorcode; ?>>
             
			   
				<td height="27" class="bodytext32" valign="center"  align="center" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;">
			  <?php echo ucwords($resdoc['father_name']); ?></td>
				<td height="27" class="bodytext32" valign="center"  align="center" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;">
			 <?php echo strtoupper($resdoc['father_nationality']); ?></td>
				<td height="27" align="center" valign="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;">
			   <?php echo $resdoc['fnin_ain']; ?></td>
			   <td align="center" valign="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;">
			  <?php echo $resdoc['patientname']; ?></td>
			   <td height="27" align="center" valign="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;">
			   <?php echo strtoupper($resdoc['mother_nationality']); ?></td>
			    <td  height="27" align="center" valign="center" class="bodytext32" style="border:solid 1px #000000; background:#FFFFFF;">
			   <?php echo $resdoc['mnin_ain'];?></td>
			   
  </tr>
  </table>
<table width="530" border="0" align="center" cellpadding="0" cellspacing="0">

  
  
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">Record Filed On : <?php echo date('d-M-Y h:i:s A',strtotime($resdoc['record_date'].''.$resdoc['record_time'])); ?></td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">Date of print : <?php echo date('d-M-Y h:i:s A',strtotime($updatedatetime)); ?></td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>	
 
	<tr>
	
		<td colspan="4" align="left" class="bodytext32">Medical Records Officer </td>
	
		<td colspan="2" align="right" class="bodytext33"> Notifier of Birth &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>


	</tr>
<tr>
      <td colspan="4" align="left" class="bodytext32">(<?php if($resdoc['address']!=''){echo $resdoc['address'];}else{echo $resdoc['doctor_name'];} ?>)</td>
	
		<td colspan="2" align="right" class="bodytext32">(<?php echo $resdoc['doctor_name']; ?>)</td>

	</tr>
	
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="left" class="bodytext32">&nbsp;</td>
	</tr>

</table> 
	
<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");

$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("birthnotification.pdf", array("Attachment" => 0)); 
?>
 
 
 
