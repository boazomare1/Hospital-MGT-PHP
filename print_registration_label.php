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

function format_interval(DateInterval $interval) {
    $result = "";
    if ($interval->y) { $result .= $interval->format("%y Years "); }
    if ($interval->m) { $result .= $interval->format("%m Months "); }
    //if ($interval->d) { $result .= $interval->format("%d Days "); }

    return $result;
}

if (isset($_REQUEST["previouspatientcode"])) {$previouspatientcode = $_REQUEST["previouspatientcode"]; } else { $previouspatientcode = ""; }

$query1 = "select * from master_company where auto_number = '$companyanum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	
	$companycode = $res1["companycode"];
	$phonenumber1 = $res1["phonenumber1"];
    $companyname1 = $res1["companyname"];
	
$query2 = "select * from master_customer where customercode ='$previouspatientcode' ";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	
	$res2patientname = $res2["customerfullname"];
	$res2gender = $res2["gender"];
	$res2age = $res2["age"];
	$res2dateofbirth1 = $res2["dateofbirth"];
	$res2dateofbirth = strtotime($res2dateofbirth1);
	$res2mobilenumber = $res2["mobilenumber"];
	$date2_recorddate=date("Y-m-d");

	if($res2dateofbirth1>'0000-00-00'){
	$today = new DateTime($date2_recorddate);
	$diff = $today->diff(new DateTime($res2dateofbirth1));
	$patientage1 = format_interval($diff);
	}else{
	  $patientage1 = '<font color="red">DOB Not Found.</font>';
	}

 

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
	background-color: #ffffff;
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C;  }
</style>
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
    <td  align="left" valign="center" ><img src="images/hospital.png" width="75" height="auto" /></td>
	<td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" style="border-bottom: solid 2px #000000;" valign='bottom'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="http://<?php echo  $_SERVER['SERVER_NAME']; ?>/<?php echo basename(__DIR__); ?>/barcode/test.php?text=<?php echo $previouspatientcode; ?>" width="150" height="32" /></td>
  </tr>
		<tr>
		  <td colspan='2' align="">&nbsp;</td>
	  </tr>
		
		<tr>
			<td   align="left" valign="center" nowrap="nowrap" 
			bgcolor="#ffffff" class="bodytext31">		
			<strong>Reg No.</strong></td>
			<td  align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" id="pcode" >		
			<strong><?php echo $previouspatientcode; ?></strong></td>
			
		</tr>
		<tr>
			<td   align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" >		
			<strong>Name </strong>   </td>
			<td    align="left" valign="center" nowrap="nowrap" 
			bgcolor="#ffffff" class="bodytext31">		
			<strong><?php echo strtoupper($res2patientname); ?></strong>   </td>
		</tr>
		<tr>
			<td   align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" ><strong>Gender </strong></td>
			<td    align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" ><strong><?php echo $res2gender; ?></strong></td>
		</tr>
		
		<tr>
			<td align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" >		
			<strong>DOB </strong>   </td>
			<td   align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" >		
			<strong><?php echo date('d/m/y',$res2dateofbirth); ?></strong>   </td>
		</tr>
		<tr>
			<td   align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" >		
			<strong>Phone </strong>   </td>
			<td   align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" >		
			<strong><?php echo $res2mobilenumber; ?></strong>   </td>
		</tr>
	</table>

</td>

</tr>
 
</table>

<?php	
$content = ob_get_clean();

// convert in PDF

try
{
$html2pdf = new HTML2PDF('L', array(50,82),'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('registration Label.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>
