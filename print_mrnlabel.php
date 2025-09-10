<?php
ob_start();
require_once('html2pdf/html2pdf.class.php');
session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  
 // header("Content-Disposition: attachment; filename=sample.pdf");
  
 
?> 

<style type="text/css">

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext41 {FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #000000; 

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 16px; COLOR: #000000; 

}

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  }

</style>

<?php 



if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

	

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = "frmflag1"; }
if ($frmflag1 == 'frmflag1')
{
			$query11 = "select * from materialreceiptnote_details where billnumber = '$billnumber' ";

			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

			mysqli_num_rows($exec11);

			while($res11 = mysqli_fetch_array($exec11))

			 {
                 
				 $itemcode= $res11['itemcode'];
				 $res11itemname= $res11['itemname'];
				 $res11batchnumber = $res11['batchnumber'];

			     $res11expirydate = $res11['expirydate'];
				 $suppliername = $res11['suppliername'];
				 
			

			?>

   <page>

  <table border="0" cellpadding="0" cellspacing="0" align=''>
  <tr>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
   
<td>
     <table border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td  align="left" valign="center" colspan="2"  bgcolor="#ffffff" class="bodytext41">&nbsp;</td>
    </tr>
	
	 <tr>
    <td  align="left" valign="center" colspan="2"   bgcolor="#ffffff" class="bodytext41">&nbsp;</td>
    </tr>
 <?php if($itemcode!='') {?>
  <tr>
    <td  align="left" valign="center"   bgcolor="#ffffff" class=""><b>CODE  :</b></td>
	 <td  align="left" valign="center"   bgcolor="#ffffff" class=""><b><?php echo $itemcode; ?></b></td>
    </tr>
<?php } ?>
	<tr>
    <td   align="left" valign="center"   colspan="2"  bgcolor="#ffffff"  class=""><b><?php echo $res11itemname; ?></b></td>
  </tr>
  <tr>
    <td  class=""  valign="center"  align="left" bgcolor="#ffffff"><b>BATCH :</b></td>
	<td  class=""  valign="center"  align="left" bgcolor="#ffffff"><b><?php echo $res11batchnumber; ?></b></td>
  </tr>
  <tr>
    <td  class=""  valign="center"  align="left" bgcolor="#ffffff"><b>EXP DT :</b></td>
	    <td  class=""  valign="center"  align="left" bgcolor="#ffffff"><b><?php echo date('m/y',strtotime($res11expirydate));?></b></td>
  </tr>
  <tr>
    <td  class=""  valign="center"  align="left" bgcolor="#ffffff" colspan="2"><b><?php echo $billnumber.", ".$suppliername; ?></b></td>
  </tr>
</table>

</td>

</tr>
 
</table>
</page>

 <?php 
	
			
			}
}	

				

?>

<?php	

$content = ob_get_clean();
// convert in PDF
try
{
$html2pdf = new HTML2PDF('L', array(50,80),'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
$fileName = 'MRN_labels_' . $billnumber . '.pdf';
//$html2pdf->Output($fileName);
$html2pdf->Output($fileName, 'D');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
} 
?>

