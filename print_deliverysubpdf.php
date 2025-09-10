<?php
session_start();
//error_reporting(0);
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

$query1 = "select * from master_company where auto_number = '$companyanum'";
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

ob_start();

if (isset($_REQUEST["printno"])) { $printno = $_REQUEST["printno"]; } else { $printno = ""; }


?>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
#footer { position: fixed; left: 0px; bottom: -20px; right: 0px; height:150px; }
#footer .page:after { content: counter(page, upper-roman); }

.page { page-break-after:always; }
</style>
<?php //include("a4pdfheader1.php"); ?>	
	
	<table width="500" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr>
    <td colspan="2" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31">
	
	<?php
	$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
	$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3showlogo = mysqli_fetch_array($exec3showlogo);
	$showlogo = $res3showlogo['showlogo'];
	if ($showlogo == 'SHOW LOGO')
	{
	?>
		
	<img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="75" />
	
	<?php
	}
	?>	</td>
			
	<td align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    <td colspan="3" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext32"><?php
	echo '<strong class="bodytext33">'.$res1companyname.'</strong>';
	//echo '<br>'.$res1address1.' '.$res1area.' '.$res1city;
	//echo '<br>'.$res1pincode;
    if($res1phonenumber1 != '')
	 {
	echo '<br><strong class="bodytext34">PHONE : '.$res1phonenumber1.'</strong>';
	 }
	echo '<br><strong class="bodytext35">E-Mail : '.$res1emailid1.'</strong>'; 
	?></td>
    <td width="6" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  
	<?php
	$query31 = "select * from print_deliverysubtype where printno = '$printno' and status <> 'deleted' ORDER BY patientname ASC";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res31 = mysqli_fetch_array($exec31);
	
	$subtype = $res31['subtype'];
	?>
	<tr>
	<td colspan="7" align="left"><strong><?php echo $subtype; ?></strong></td>
	</tr>
	<tr>
	<td width="7%"  align="center" valign="center" 
	bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
  <td width="14%" align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No</strong></div></td>
  <td width="37%" align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>
  <td width="12%" align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
  <td width="11%" align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Date </strong></div></td>
  <td width="14%" align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
  <td width="5%" align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	</tr>
	<?php
	$totalamount = '0.00';
	$query3 = "select * from print_deliverysubtype where printno = '$printno' and status <> 'deleted' group by accountname ORDER BY patientname ASC";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res3 = mysqli_fetch_array($exec3))
	{
		$res3accountname = $res3['accountname'];
	?>
	<tr>
	<td colspan="7" align="left"><strong><?php echo $res3accountname; ?></strong></td>
	</tr>
	<?php	
	$query2 = "select * from print_deliverysubtype where printno = '$printno' and accountname = '$res3accountname' and status <> 'deleted' ORDER BY patientname ASC";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
		$patientcode = $res2['patientcode'];
		$patientname = $res2['patientname'];
		$billno = $res2['billno'];
		$billdate = $res2['billdate'];
		$amount = $res2['amount'];
		$accountname = $res2['accountname'];
		$subtype = $res2['subtype'];
	
	$totalamount = $totalamount + $amount;
	
	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1); 
	if ($showcolor == 0)
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	else
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	  
	?>
	<tr <?php echo $colorcode; ?>>
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td align="left" class="bodytext3"><?php echo $patientcode; ?></td>
	<td align="left" class="bodytext3"><?php echo $patientname; ?></td>
	<td align="left" class="bodytext3"><?php echo $billno; ?></td>
	<td align="left" class="bodytext3"><?php echo $billdate; ?></td>
	<td align="right" class="bodytext3"><?php echo $amount; ?></td>	
	<td align="left" class="bodytext3">&nbsp;</td>
	</tr>
	<?php
	}
	}
	?>
	<tr>
	<td colspan="5" align="right" class="bodytext3"><strong>Total :</strong></td>	
	<td align="right" class="bodytext3"><strong><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
	<td align="left" class="bodytext3">&nbsp;</td>
	</tr>
	</tbody>
	</table> 
	
	<table width="500" border="0" align="left" id="footer" cellpadding="4" cellspacing="0">
	<tbody>
	<tr>
	<td align="left"><strong>Despatching Officer</strong></td><td align="right"><strong>Receiving Officer</strong></td>
	</tr>
	</tbody>
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
$dompdf->stream("DeliveryReport.pdf", array("Attachment" => 0)); 
?>