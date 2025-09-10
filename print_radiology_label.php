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
?> 
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; 
}
.bodytext41 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #000000; 
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
	
if (isset($_REQUEST["patientcode"])) {  $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }
if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = "op"; }

if($type=='ip'){
    $rslttable='ipresultentry_radiology';
	$consultationtable='ipconsultation_radiology';
}
else{
	$rslttable='resultentry_radiology';
	$consultationtable='consultation_radiology';
}

$query1 = "SELECT * from $rslttable where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber = '$docnumber' ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$num1=mysqli_num_rows($exec1);

while($res1 = mysqli_fetch_array($exec1))
{

$patientname=$res1['patientname'];
$patientcode=$res1['patientcode'];
$visitcode=$res1['patientvisitcode'];
$consultationdate=$res1['recorddate'].' '.$res1['recordtime'];;

$itemcode=$res1['itemcode'];
$radiologyname=$res1['itemname'];	
$radiologyusername=$res1['username'];	
$docnumber1=$res1['docnumber'];
$billnumber=$res1['billnumber'];

$sql ="select b.employeename as name from $consultationtable as a , master_employee as b   where a.username=b.username and a.docnumber='$docnumber1'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$name = $res2['name'];
?>

   <page>
  <table border="0" cellpadding="0" cellspacing="0" align='' width='300'>
  <tr>
   <td >&nbsp;&nbsp;</td>
  <td>
   <table border="0" cellpadding="0" cellspacing="0" width='300'>
   <tr>
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >&nbsp;</td>
	<td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ></td>


  </tr>

  <tr>
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><strong>Name</strong></td>
	<td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >: <?php echo $patientname; ?></td>


  </tr>

  <tr>
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><strong>Patient Code</strong></td>
	<td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >: <?php echo $patientcode; ?></td>


  </tr>
  <tr>
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><strong>Visit Code</strong></td>
	<td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >: <?php echo $visitcode; ?></td>


  </tr>

  <tr>
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><strong>Radiology No</strong></td>
	<td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >: <?php echo $itemcode; ?></td>


  </tr>
  <tr>
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><strong>Consultant</strong></td>
	<td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >: <?php echo $name; ?></td>


  </tr>
   <tr>
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><strong>Date</strong></td>
	<td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >: <?php echo $consultationdate; ?></td>


  </tr>
  <tr>
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><strong>Examination</strong></td>
	<td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" width='200'>: <?php echo $radiologyname; ?></td>


  </tr>

 
</table>
</td>

</tr>
 
</table>
</page>
 <?php
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

$html2pdf->Output('Medicine Label.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>
