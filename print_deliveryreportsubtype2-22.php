<?php
ob_start();
session_start();
//error_reporting(0);
set_time_limit(0);
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

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d'); }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d', strtotime('-1 month')); }

if (isset($_REQUEST["subtype"])) { $subtype = $_REQUEST["subtype"]; } else { $subtype = ''; }
if (isset($_REQUEST["accname"])) { $accname = $_REQUEST["accname"]; } else { $accname = ''; }

if (isset($_REQUEST["printno"])) { $printno = $_REQUEST["printno"]; } else { $printno = ""; }

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



if (isset($_REQUEST["printno"])) { $printno = $_REQUEST["printno"]; } else { $printno = ""; }


?>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}

</style>
<?php //include("a4pdfheader1.php"); ?>
<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">
<table width="" border="0" cellspacing="4" cellpadding="0">
 
    <tr>
      <td colspan="2" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31" width=''><?php
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
	?></td>
      <td align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31" width=''>&nbsp;</td>
      <td colspan="4" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31" width=''><?php
	echo '<strong class="bodytext33">'.$res1companyname.'</strong>';
	//echo '<br>'.$res1address1.' '.$res1area.' '.$res1city;
	//echo '<br>'.$res1pincode;
    if($res1phonenumber1 != '')
	 {
	echo '<br><strong class="bodytext34">PHONE : '.$res1phonenumber1.'</strong>';
	 }
	echo '<br><strong class="bodytext35">E-Mail : '.$res1emailid1.'</strong>'; 
	?></td>
    </tr>
    <?php
	$query31 = "select * from completed_billingpaylater where printno = '$printno' ";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num12=mysqli_num_rows($exec31);
    if($num12>0){
	$res31 = mysqli_fetch_array($exec31);
	
	$subtype = $res31['subtype'];
	$locationnameget = $res31['locationname'];
	?>
    <tr>
      <td colspan="7" align="left"><strong><?php echo $subtype; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Location : <?php echo $locationnameget?></b></td>
    </tr>
    <tr>
      <td  align="center" valign="center" 
	bgcolor="#ffffff" class="bodytext31" width="5"><strong>No.</strong></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31" width="180"><strong>Account Name  </strong></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31" width="85"><div align="left"><strong>Reg No</strong></div></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31" width="90"><strong> Patient </strong></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31" width="70"><strong> Bill No </strong></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31" width="70"><div align="left"><strong>Bill Date </strong></div></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31" width="100"><div align="right"><strong>Amount</strong></div></td>
  </tr>
  
	<?php
	$queryloc = "select locationname,locationcode from master_location where status <> 'deleted'";
	$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resloc = mysqli_fetch_array($execloc);
	$locshow=0;
		$locationcodecheck = $resloc['locationcode'];
		$locationnamecheck = $resloc['locationname'];
   ?>
	
    <?php
	$totalamount = '0.00';
	$query3 = "select * from completed_billingpaylater where printno = '$printno' group by accountname ORDER BY patientname ASC";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	while($res3 = mysqli_fetch_array($exec3))
	{
		$res3accountname = $res3['accountname'];
	?>
    <tr>
      <td colspan="7" align="left"><strong><?php echo $res3accountname; ?></strong></td>
    </tr>
    <?php
	$queryloc = "select locationname,locationcode from master_location where status <> 'deleted'";
	$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($resloc = mysqli_fetch_array($execloc))
	{$locshow=0;
		$locationcodecheck = $resloc['locationcode'];

	$query2 = "select * from completed_billingpaylater where locationcode = '".$locationcodecheck."' and subtype like '%$subtype%' and printno = '$printno' and accountname = '$res3accountname' and completed = 'completed' GROUP BY billno ORDER BY patientname ASC";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
		 $locationcodecheck = $resloc['locationcode'];
		 $locationnamecheck = $resloc['locationname'];
		 
		$patientcode = $res2['patientcode'];
		$patientname = $res2['patientname'];
		$billno = $res2['billno'];
		$billdate = $res2['billdate'];
		$amount = $res2['totalamount'];
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
	   $locshow=$locshow+1;
	?>
    <?php if($locshow==1) {?>
    <!--<tr class="delivery">
      <td colspan="6" align="left"><strong><?php //echo $locationnamecheck;?></strong></td>
    </tr>-->
    <?php }?>
    <tr <?php echo $colorcode; ?> class="page">
      <td align="center" class="bodytext3" width="5"><?php echo $colorloopcount; ?></td>
      <td align="left" class="bodytext3" width="180"><?php echo $accountname; ?></td>
      <td align="left" class="bodytext3" width="80"><?php echo $patientcode; ?></td>
      <td align="left" class="bodytext3" width="80"><?php echo $patientname; ?></td>
      <td align="left" class="bodytext3" width="30"><?php echo $billno; ?></td>
      <td align="left" class="bodytext3" width="20"><?php echo $billdate; ?></td>
      <td align="right" class="bodytext3" width="100"><?php echo number_format($amount,2,'.',','); ?></td>
    </tr>
    <?php
	 $locshow=$locshow+1;
	}
	}
	}
	?>



    <tr>
      <td colspan="6" align="right" class="bodytext3"><strong>Total :</strong></td>
      <td align="right" class="bodytext3"><strong><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
    </tr>
    <tr>
      <td align="left"><strong>&nbsp;</strong></td>
      <td align="right"><strong>&nbsp;</strong></td>
    </tr>
    <tr>
      <td align="left"><strong>Despatching Officer</strong></td>
      <td align="right"><strong>Receiving Officer</strong></td>
    </tr>
	<?php
	}
	?>
</table>
</page>
<?php	
/*
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
*/
	$content = ob_get_clean();
  // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('DeliveryReport.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
