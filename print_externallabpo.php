<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$netamount=0.00;

if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

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

	include('convert_currency_to_words.php');
	
	$query55 = "select * from generatedpo_externallab where docno='$billnumber'";
	$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$num55=mysqli_num_rows($exec55);
	$res55=mysqli_fetch_array($exec55);
	$billdate = $res55['date'];
	$suppliername = $res55['suppliername'];
	$suppliercode = $res55['suppliercode'];
	
			function calculate_age($birthday)
{
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));

    if ($diff->y)
    {
        return $diff->y . ' Years';
    }
    elseif ($diff->m)
    {
        return $diff->m . ' Months';
    }
    else
    {
        return $diff->d . ' Days';
    }
}
	
?>
<style type="text/css">
.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000;
}
.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000;
}
.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000;
}
.bodytext36 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000;
}
.bodytext37 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000;
}
.bodytext38 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000;
}
.bodytext39 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000;
}
.bodytext40 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000;
}
.bodytext41 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000;
}
.bodytext42 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000;
}
.bodytext43 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
</style>

<table width="681" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td width="111" rowspan="4" align="left">
      <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
      <img src="logofiles/<?php echo $companyanum;?>.jpg" width="200" height="75" />
    <?php
			}
	?></td>
	<?php 
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
	$tinnumber1 = $res2["tinnumber"];
	$cstnumber1 = $res2["cstnumber"];
	?>
    <td width="285" align="left" class="bodytext33">&nbsp;</td>
    <td width="285" align="left" class="bodytext33"><?php
			$strlen2 = strlen($companyname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$companyname = ' '.$companyname.' ';
			}
			?>
    <strong><?php echo $companyname; ?></strong></td>
  </tr>
  <!--<tr>
    <td align="left" class="bodytext32">
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
	<strong><?php echo $address1; ?></strong></td>
  </tr>-->
  <!--<tr>
    <td align="left" class="bodytext32">
            <?php
			$address2 = $area.''.$city.'  '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?>
	<strong><?php echo $address2; ?></strong></td>
  </tr>-->
  
  <tr>
    <td align="left" class="bodytext34">&nbsp;</td>
    <td align="left" class="bodytext34"><?php
			$address3 = "PHONE: ".$phonenumber1;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>
    <strong><?php echo $address3; ?></strong></td>
  </tr>
  
  <tr>
    <td align="left" class="bodytext35">&nbsp;</td>
    <td align="left" class="bodytext35"><?php
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
    <strong><?php echo $address4; ?></strong></td>
  </tr>
</table>

<table width="682" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="bodytext36"><div align="center"><u>LOCAL PURCHASE ORDERS</u></div></td>
  </tr>
  <tr>
    <td colspan="4" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td width="76" class="bodytext37">PO No </td>
    <td width="488" class="bodytext37"><?php echo $billnumber; ?></td>
    <td width="38" align="right" class="bodytext37">Date &nbsp;</td>
    <td width="82" align="right" class="bodytext37"><?php echo date("d/m/Y", strtotime($billdate)); ?></td>
  </tr>
  <tr>
    <td width="76" class="bodytext37">Supplier&nbsp;</td>
    <td colspan="3" class="bodytext37"><?php echo $suppliername; ?></td>
  </tr>
  <tr>
    <td colspan="4" class="bodytext37">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="4"><table width="684" border="0">
      <tr>
        <th width="40" class="bodytext38" align="left" valign="middle"><strong>No.</strong></th>
        <td width="142" class="bodytext38" align="left" valign="middle"><strong>Patient</strong></td>
        <td width="57" class="bodytext38" align="left" valign="middle"><strong>Reg.No</strong></td>
		<td width="52" class="bodytext38" align="left" valign="middle"><strong>Visit.No</strong></td>
		<td width="59" class="bodytext38" align="left" valign="middle"><strong>Age</strong></td>
		<td width="46" class="bodytext38" align="left" valign="middle"><strong>Gender</strong></td>
		<td width="190" class="bodytext38" align="left" valign="middle"><strong>Test Name</strong></td>
        <td width="64" class="bodytext38" align="left" valign="middle"><strong>Rate</strong></td>
      </tr>
	  <?php
			$sno = '';
			$totalamount = 0;
		$query7 = "select * from generatedpo_externallab where docno='$billnumber' and status = '' order by date desc";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num7 = mysqli_num_rows($exec7);
							
while($res7 = mysqli_fetch_array($exec7))
{
$patientname6 = $res7['patientname'];
$regno = $res7['patientcode'];
$visitno = $res7['visitcode'];
$billdate6 = $res7['date'];
$test = $res7['itemname'];
$itemcode = $res7['itemcode'];
$sampleid = $res7['sampleid'];

$query751 = "select * from master_customer where customercode = '$regno'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
$dob = $res751['dateofbirth'];
$age = calculate_age($dob);
$gender = $res751['gender'];

$query68="select * from master_lab where itemcode='$itemcode' and status <> 'deleted'";
$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);
$res68=mysqli_fetch_array($exec68);
$externallab = $res68['externallab'];
$rate = $res68['externalrate'];

if($externallab == 'on')
{
$totalamount = $totalamount + $rate;
	?>
			<tr>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $patientname6; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $regno; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $visitno; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $test; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($rate,2,'.',','); ?></td>
			</tr>
			<?php
			  }
			  }
			?>
			<tr>
			  <td colspan="7" class="bodytext31" valign="center"  align="right">&nbsp;</td>
			  <td width="64" class="bodytext31" valign="center"  align="right">&nbsp;</td>
			</tr> 
			<tr>
			  <td colspan="7" class="bodytext31" valign="center"  align="right"><strong>Net Amount</strong></td>
			  <td width="64" class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
			</tr> 
    </table></td>
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
    
</table>
<?php	
$content = ob_get_clean();

// convert in PDF

try
{
$html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('helvetica');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('print_localpurchaseorder.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>
