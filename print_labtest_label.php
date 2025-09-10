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
$dateonly1 = date("Y-m-d");

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["billnumber"])) { $docnumber = $_REQUEST["billnumber"]; } else { $docnumber = ""; }
?> 

<style type="text/css">
<!--
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Tahoma
}
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
-->

table.data
{
    height: 60;
    width: 270;
	position: relative;
	white-space: nowrap
    top: 20;
	border:1px solid;
    left: 0;
  
}
.med {font-size:10px }
.data {font-size:9px }
.data {table-layout:auto }
.style2 {font-weight: bold}
</style>
<script>
window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#externalbill';
        window.location.reload();
    }
}
</script>
<body onkeydown="escapeke11ypressed()">
<?php 
$query61 = "select * from samplecollection_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and acknowledge='completed' and refund='norefund' and itemname <> '' and docnumber='$docnumber' group by itemname";
$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec61);
		while($res61 = mysqli_fetch_array($exec61))
		{
			$labname =$res61["itemname"]; 
			$patientname =$res61["patientname"];
			$recordtime = $res61["recordtime"];
?>
     <table style="border:2px solid;" width="440" height="200" cellpadding="0" cellspacing="0" align="" >
  <tr>
    <td colspan="2" align="left"   valign="center" 
                bgcolor="#ffffff">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2" width="13%" align="left"   valign="center" 
                bgcolor="#ffffff"><strong><?php echo date('d/m/Y',strtotime($dateonly1)).' '.$recordtime; ?>
    </strong></td>
  </tr>
         <tr>
           <td align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" id="pcode">&nbsp;</td>
         </tr>
         <tr>
			<td align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" id="pcode" ><img src="http://<?php echo  $_SERVER['SERVER_NAME']; ?>/neema/barcode/test.php?text=<?php echo $docnumber; ?>" width="150" height="32" /></td>
		</tr>
		
		 <tr>
		   <td align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	   </tr>
		 <tr>
			<td colspan="2" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong><?php echo $patientname; ?> (<?php echo $patientcode; ?>, <?php echo $visitcode; ?>)</strong></td>
		</tr>
		
		 <tr>
		   <td colspan="2" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong><?php echo $labname; ?></strong></td>
	   </tr>
		 <tr>
			<td colspan="2" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
		</tr>
</table>
&nbsp;&nbsp;
<?php } ?>
<?php	
$content = ob_get_clean();

// convert in PDF

try
{
$html2pdf = new HTML2PDF('P', 'A5', 'en');
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('print_consultationbill.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>
