<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("db/db_connect.php");
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$datetime = date('Y-m-d');

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'LTC-1';

if (isset($_REQUEST["reportid"])) { $reportid = $_REQUEST["reportid"]; } else { $reportid = ""; }	

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
	<page pagegroup="new" backtop="8mm" backbottom="16mm" backleft="2mm" backright="3mm">

<?php include("print_header.php");

$querymrd = "select * from mrdmovement  where auto_number='$reportid' and status='transferred'";
$execmrd = mysqli_query($GLOBALS["___mysqli_ston"], $querymrd);
$num1 = mysqli_num_rows($execmrd);
if($num1>0){

	$res1 = mysqli_fetch_array($execmrd);
?>

<table width="780"  border="0" align="left" cellpadding="0" cellspacing="0">

	<tr>
		<td colspan="4" align="center"><strong>&nbsp;</strong></td>
	</tr>


	<tr>
		<td colspan="4" align="center"><strong>&nbsp;</strong></td>
	</tr>

	<tr>
		<td colspan="4" align="center"><strong>MRD From</strong></td>
	</tr>

<tr>
		<td colspan="4" align="center"><strong>&nbsp;</strong></td>
	</tr>


<tr><td class="" colspan="4" width="375">&nbsp;</td></tr>
	<tr>
    	<td class="bodytext32"  width="250">From Name: </td>
		<td colspan="" width="150" class="bodytext34"><?php echo $res1['patientname']; ?></td>
        <td  class="bodytext32">&nbsp; </td>
        <td valign="top" class="bodytext34"><?php //echo $res11billnumber; ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">From Reg. No: </td>
        <td colspan="" class="bodytext34"><?php echo $res1['patientcode']; ?></td>
        <td class="bodytext32">&nbsp; </td>
		<td class="bodytext34"><?php //echo date("d/m/y", strtotime($res11billingdatetime)); ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">From MRD: </td>
        <td colspan="3" class="bodytext34"><?php echo  $res1['mrdno']; ?></td>
	</tr>
	<tr>
		<td colspan="4" align="center"><strong>&nbsp;</strong></td>
	</tr>
    <tr>
		<td colspan="4" align="center"><strong>Transferred To</strong></td>
	</tr>
    <tr>
		<td colspan="4" align="center"><strong>&nbsp;</strong></td>
	</tr>

	<tr>
    	<td class="bodytext32" >To Name: </td>
		<td colspan="" width="150" class="bodytext34"><?php echo $res1['to_name']; ?></td>
        <td  class="bodytext32">&nbsp; </td>
        <td valign="top" class="bodytext34"><?php //echo $res11billnumber; ?></td>
	</tr>
    
    <tr>
    	<td  class="bodytext32">To MRD: </td>
        <td colspan="3" class="bodytext34"><?php echo  $res1['to_code']; ?></td>
	</tr>


	<tr>
		<td colspan="4" align="center"><strong>&nbsp;</strong></td>
	</tr>


	<tr>
    	<td  class="bodytext32" colspan="2">Transferred By: </td>
        <td colspan="2" class="bodytext34">Date</td>
	</tr>

	<tr>
    	<td  class="bodytext32" colspan="2"><?php echo  $res1['username']; ?></td>
        <td colspan="2" class="bodytext34"><?php echo  $res1['updatedatetime']; ?></td>
	</tr>

	<tr>
		<td colspan="4" align="center"><strong>&nbsp;</strong></td>
	</tr>

<tr>
		<td colspan="4" align="center"><strong>&nbsp;</strong></td>
	</tr>


	<tr>
    	<td  class="bodytext32" colspan="4">From Signature: -------------------------</td>
	</tr>

	<tr>
		<td colspan="4" align="center"><strong>&nbsp;</strong></td>
	</tr>

<tr>
		<td colspan="4" align="center"><strong>&nbsp;</strong></td>
	</tr>


	<tr>
    	<td  class="bodytext32" colspan="4">To Signature: -------------------------</td>
	</tr>


    </table>
   
<?php } ?>
	
</page>

<?php	
 $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('printmrn.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

	
?>
