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
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 
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
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C;  }
</style>
<body onkeydown="escapeke11ypressed()">
<?php 
	
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }


$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$dateofbirth=$res69['dateofbirth'];




function format_interval(DateInterval $interval) {
    $result = "";
    if ($interval->y) { $result .= $interval->format("%y Years "); }
    if ($interval->m) { $result .= $interval->format("%m Months "); }
    //if ($interval->d) { $result .= $interval->format("%d Days "); }

    return $result;
}


$query7 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode = '$visitcode'";
$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

while( $res7 = mysqli_fetch_array($exec7))
{
  $patientgender=$res7['gender'];
  $res7patientfullname=$res7['patientfullname'];
  $consultationdate=$res7['consultationdate'];
  $consultingdoctorName=$res7['consultingdoctorName'];
  


if($dateofbirth>'0000-00-00'){
$today = new DateTime($consultationdate);
$diff = $today->diff(new DateTime($dateofbirth));
$patientage1 = format_interval($diff);
}else{
  $patientage1 = '<font color="red">DOB Not Found.</font>';
}

$query691="SELECT * FROM `ip_bedallocation` where patientcode='$patientcode' and visitcode = '$visitcode'";
$exec691=mysqli_query($GLOBALS["___mysqli_ston"], $query691) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res691=mysqli_fetch_array($exec691);
$recorddate=$res691['recorddate'];
$ward=$res691['ward'];
$bed=$res691['bed'];

$query691="SELECT * FROM ip_bedtransfer where patientcode='$patientcode' and visitcode = '$visitcode' order by auto_number desc limit 0,1";
$exec691=mysqli_query($GLOBALS["___mysqli_ston"], $query691) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num2 = mysqli_num_rows($exec691);
if($num2>0) {
  $res691=mysqli_fetch_array($exec691);
  $ward=$res691['ward'];
  $bed=$res691['bed'];
}

$wardsql="SELECT * FROM `master_ward` where auto_number='$ward'";
$execward=mysqli_query($GLOBALS["___mysqli_ston"], $wardsql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resward=mysqli_fetch_array($execward);
$wardname=$resward['ward'];

$bedsql="SELECT * FROM `master_bed` where auto_number='$bed'";
$execbed=mysqli_query($GLOBALS["___mysqli_ston"], $bedsql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resbed=mysqli_fetch_array($execbed);
$bedname=$resbed['bed'];

 ?>

<table border="0" cellpadding="0" cellspacing="0" align=''>
  <tr>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>
 <table border="0" cellpadding="0" cellspacing="0" align=''>
 <tr>
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" colspan='2'>&nbsp;</td>
    </tr>
  <tr >
    <td  align="left" valign="center" ><img src="logofiles/1.png" width="75" height="auto" /></td>    <!--<td  align="left" valign="center" ><img src="logofiles/1.png" width="75" height="auto" /></td>-->
	<td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" style="border-bottom: solid 2px #000000;" valign='bottom'><strong >&nbsp;Registration : <?php echo $patientcode; ?><br><br>&nbsp; Visit Code &nbsp;&nbsp;&nbsp;: <?php echo $visitcode; ?></strong></td>
  </tr>
 
    <tr>
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" colspan='2'>&nbsp;</td>
    </tr>
    <tr >
               <td   class="bodytext41" valign="center"  
                bgcolor="#ffffff" colspan='2'><strong><?php echo ucwords(strtoupper($res7patientfullname)); ?></strong></td>
    </tr>

	

    <tr>
    <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext41" colspan='2'><strong>Age : <?php echo $patientage1; ?>&nbsp; Gender : <?php echo $patientgender;?></strong> </td>
    </tr>
	
   <tr>
    <td   class="bodytext41" valign="center"  
                bgcolor="#ffffff" colspan='2'><strong>DOA  : <?php echo $recorddate; ?></strong></td>
    </tr>

	<tr>
    <td   class="bodytext41" valign="center"  
                bgcolor="#ffffff" colspan='2'><strong>Ward : <?php echo $wardname; ?></strong></td>
    </tr>
	<tr>
    <td   class="bodytext41" valign="center"  
                bgcolor="#ffffff" colspan='2'><strong>Bed  : <?php echo $bedname; ?></strong></td>
    </tr>
	<tr>
    <td   class="bodytext41" valign="center"  
                bgcolor="#ffffff" colspan='2'><strong>Doctor : <?php echo $consultingdoctorName; ?></strong></td>
    </tr>

  
 
</table>
</td>

</tr>
 
</table>

<?php 
}
?>
</body>
<?php	
$content = ob_get_clean();

// convert in PDF

try
{
$html2pdf = new HTML2PDF('L', array(50,82),'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('IP Label.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>
