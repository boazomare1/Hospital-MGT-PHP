<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$datetime = date('Y-m-d');


$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'LTC-1';
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }	
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }	
$ipvisit = substr($visitcode,-3);
if($ipvisit == 'IPV')
{
	$query33 = "select * from ipsamplecollection_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and recorddate='$datetime'";
}
else
{
	$query33 = "select * from samplecollection_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and recorddate='$datetime'";
}
$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
$res33 = mysqli_fetch_array($exec33);
$patientname = $res33['patientname'];

$query2 = "select * from master_location where locationcode = '$locationcode'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		//$companyname = $res2["companyname"];
		$address1 = $res2["address1"];
		$address2 = $res2["address2"];
//		$area = $res2["area"];
//		$city = $res2["city"];
//		$pincode = $res2["pincode"];
		$emailid1 = $res2["email"];
		$phonenumber1 = $res2["phone"];
		$locationcode = $res2["locationcode"];
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
		$locationname =  $res2["locationname"];
		$prefix = $res2["prefix"];
		$suffix = $res2["suffix"];
?>
<style type="text/css">
.bodytext31 { FONT-SIZE: 14px; COLOR: #000000; }
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000; }
.bodytext35 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; }
.bodytext34 { FONT-SIZE: 12px; COLOR: #000000;FONT-WEIGHT: bold;}
table {
   display: table;
   width: 100%;
   table-layout: fixed;
   border-collapse:collapse;
}
.tableborder{
   border-collapse:collapse;
   border:1px solid black;}
.bodytext33{FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; text-decoration:underline;}
border{border:1px solid #000000; }
borderbottom{border-bottom:1px solid #000000;}
.page_footer
{
	font-family: Times;
	text-align:center;
	font-weight:bold;
	margin-bottom:25px;
	
}

</style>
<page pagegroup="new" >

<?php include('print_header80x80.php'); ?>

<table width="100%"  border="" align="left" cellpadding="0" cellspacing="0">
<tr><td class="" colspan="4" width="375">&nbsp;</td></tr>
	<tr>
    	<td class="bodytext32" >Name: </td>
		<td colspan="" width="150" class="bodytext34"><?php echo $patientname; ?></td>
        <td  class="bodytext32">&nbsp; </td>
        <td valign="top" class="bodytext34"><?php //echo $res11billnumber; ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">Reg. No: </td>
        <td colspan="" class="bodytext34"><?php echo $patientcode; ?></td>
        <td class="bodytext32">&nbsp; </td>
		<td class="bodytext34"><?php //echo date("d/m/y", strtotime($res11billingdatetime)); ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">OP Visit No: </td>
        <td colspan="3" class="bodytext34"><?php echo $visitcode; ?></td>
	</tr>
	<tr>
		<td colspan="4" align="center"><strong>&nbsp;</strong></td>
	</tr>
    <tr>
		<td colspan="4" align="center"><strong>Lab Request Form</strong></td>
	</tr>
    <tr>
		<td colspan="4" align="center"><strong>&nbsp;</strong></td>
	</tr>
    </table>
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	 <!--<td align="center" class="bodytext32 border" width="20">S.No</td>-->
	  <td align="left" class="bodytext32 border" width="255"><strong>Description</strong></td>
	  <!--<td align="center" class="bodytext32 border" width="20"><strong>Amount</strong></td>-->
	  <td align="left" class="bodytext32 border" width="120"><strong>Timestamp</strong></td>
  </tr>
  <tr>
		<td colspan="2">&nbsp;</td>
	</tr>
   <?php	
   $colorloopcount = 0;
   $sno = 0;		
   $res1labitemrate = 0;
   $labtotal = 0;
			if($ipvisit == 'IPV')
			{
				$query1 = "select * from ipsamplecollection_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and refund <> 'refund' and resultentry <> 'completed' and recorddate='$datetime'";
			}
			else
			{
				$query1 = "select * from samplecollection_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and refund <> 'refund' and resultentry <> 'completed' and recorddate='$datetime'";
			}
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
		    $res1labitemname = $res1['itemname'];
			$res1labitemcode = $res1['itemcode'];
			$recorddate = $res1['recorddate'];
			$recordtime = $res1['recordtime'];
			
			if($ipvisit == 'IPV')
			{
				$query12 = "select * from ipconsultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and labitemcode = '$res1labitemcode'";
			}
			else
			{
				$query12 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and labitemcode = '$res1labitemcode'";
			}
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res1labitemrate = $res12['labitemrate'];
			$labtotal = $labtotal + $res1labitemrate;
			
			$colorloopcount = $colorloopcount + 1;
			$sno =$sno + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			} 
			?>
			  <tr>
              	<!--<td class="bodytext34 " valign="center"  align="center"  >
			   <?php echo $sno; ?></td>-->
			   <td class="bodytext34 border" valign="center"  align="left"  width="255">
			   <?php echo nl2br($res1labitemname); ?></td>
				<!--<td class="bodytext34 border" valign="center"  align="right" >
			  <?php echo number_format($res1labitemrate,2,'.',','); ?></td>-->
				<td align="left" valign="center" class="bodytext34 border" width="120" >
			   <?php echo $recorddate.' &nbsp; '.$recordtime; ?></td>
              </tr>
             <?php
			}
			?>
			
			
	          <tr>
	            <td align="right">&nbsp;</td>
	            <td align="right">&nbsp;</td>
  </tr>
 
    
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
    </table>

	
</page>

<?php	
	$content = ob_get_clean();
   
    // convert to PDF
   
    try
    {	
		$width_in_inches = 4.38;
		$height_in_inches = 6.120;
		$width_in_mm = $width_in_inches * 25.4; 
		$height_in_mm = $height_in_inches * 25.4;
        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0,0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
	//	$html2pdf->setDefaultFont('Helvetica');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Lab Request.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
?>
