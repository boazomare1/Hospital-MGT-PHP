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

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["billnumber"]; } else { $docnumber = ""; }


$query61 = "select * from samplecollection_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and acknowledge='completed' and refund='norefund' and itemname <> '' and docnumber='$docnumber' group by itemname";
$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec61);	

while($res61 = mysqli_fetch_array($exec61))
		{
			$labname =$res61["itemname"]; 
			$patientname =$res61["patientname"];
			//$billtype = $res61["billtype"];
	?>
    <?php if($labname!= '' ) { ?>

<table width="386" border="0" cellpadding="0" cellspacing="0" align="center" class = "data">
	 <tr>
    <td colspan="2" width="13%" align="left"   valign="center" 
                bgcolor="#ffffff"><strong><?php echo date('d/m/Y ',strtotime($dateonly1)); ?>
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
	        <td colspan="4" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >		
				<div align="left"><span class="style2">
			    <?php //echo $res9instructions; ?>
		 </span></div>   </td>
	    </tr>
</table>

<?php } } ?>

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
