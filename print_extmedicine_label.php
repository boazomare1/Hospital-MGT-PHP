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
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
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
//if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
//if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $docnumber = ""; }

$itemcode = '';

$query4 = "select * from master_consultationpharmissue where billnumber = '$billnumber'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$res4itemname = $res4['medicinename'];
$res4docnumber = $res4['docnumber'];

$query13 = "select * from master_medicine where itemname='$res4itemname' ";
$exec13=mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
$res13 = mysqli_fetch_array($exec13);

/* $query9 = "select * from pharmacysales_details where billnumber = '$billnumber' ";
$exec9=mysql_query($query9) or die ("Error in Query9".mysql_error());

while ( $res9 = mysql_fetch_array($exec9))
	 {
	$res9instructions = $res9['instructions'];
	$res9batchnumber=$res9['batchnumber'];
	$res9quantity = $res9['quantity'];
	$res9billnumer = $res9['billnumer'];
	$res9quantity = intval($res9quantity);
	$res9itemname = $res9['itemname'];
	$res2medicinecode= $res9['itemcode'];
	*/
	$zero='';
	
	$query2 = "select * from master_consultationpharmissue where billnumber = '$billnumber' and recordstatus <>'deleted' ";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$recorddate='';
	while($res2 = mysqli_fetch_array($exec2)) {
	$res2dose = $res2['dose'];
	$res2patientname = $res2['patientname'];
    $res2patientcode = $res2['patientcode'];
	$res2frequencynumber = $res2['frequencynumber'];
	$res2days = $res2['days']; 
	$res2docnumber = $res2['docnumber'];
	$res2quantity = $res2['prescribed_quantity']; 
	$res2itemname = $res2['medicinename'];
	$res2itemname = ucwords(strtolower($res2itemname));
    $res2medicinecode = $res2['medicinecode'];
	$res2medicinecode = ucwords(strtolower($res2medicinecode));	

	$recorddate = $res2['recorddate'];
	$phpdate = strtotime($recorddate);
	
	$query6 = "select * from purchase_details where itemcode = '$res2medicinecode'  ";
	$exec6=mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$res6expirydate=$res6['expirydate'];
	$res6batchnumber=$res6['batchnumber'];
	$res6expirydate = strtotime($res6expirydate); 
	$res6itemname=$res6['itemname'];
	
	$query8 = "select * from master_medicine where itemcode='$res2medicinecode'";
	$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res8 = mysqli_fetch_array($exec8);
	$res8formula = $res8['formula']; 
	
	$query9 = "select * from pharmacysales_details where docnumber = '$res2docnumber' ";
	$exec9=mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res9 = mysqli_fetch_array($exec9);
	$res9instructions = $res9['instructions']; 
	
	   ?>
	   <?php //if($res9quantity!=0) { ?>
		 <table border="0" cellpadding="0" cellspacing="0" class = "data" width="126">
	  <tr>
		<td width="26%" align="left" valign="center" class="bodytext31" 
                bgcolor="#ffffff" style="border-bottom: solid 1px black; }"><div align="left"><strong>Qty. <?php echo $res2quantity; ?></strong></div></td>
					
		<td align="left" valign="center" class="bodytext31" 
                bgcolor="#ffffff" style="border-bottom: solid 1px black;"><div align="left"><strong><?php echo ucwords(strtolower($res2itemname)).' ('.$res6batchnumber.')'; ?></strong></div></td>
		<td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"  style="border-bottom: solid 1px black; }"><div align="right"><strong>Exp: <?php echo date('m/y', $res6expirydate); ?></strong></div></td> 
	  </tr>
	  <tr>
	 
		<td colspan="3"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="left"><?php if($res8formula=="INCREMENT") 
					{ 
					echo "Take"."&nbsp;".$res2dose."&nbsp;"."tab"."&nbsp;".$res2frequencynumber."&nbsp;"."times a day for"."&nbsp;".$res2days."&nbsp;"."days";
					}
					?>
					</div></td>
		</tr>
	  <tr>				      
		   <td style="border-bottom: solid 1px black; " colspan="3" align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31" >		
					<div align="left"><?php echo $res9instructions; ?></div>	   </td>
	  </tr>
	 
	  <tr>
		<td class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff" nowrap="nowrap"><strong><?php echo $res2patientname; ?></strong></td>
		<td class="bodytext31" valign="center"  align="right" 
					bgcolor="#ffffff" nowrap="nowrap"><strong><?php //echo $res2patientcode; ?></strong></td>
		<td class="bodytext31" valign="center"  align="right" 
					bgcolor="#ffffff"><strong><?php //echo $visitcode; ?></strong></td>
	  </tr>
	  <tr>
		<td class="bodytext31"  valign="center"  align="left" 
					bgcolor="#ffffff"><div align="left"><strong>Date: <?php echo date('d/m/Y ', $phpdate); ?></strong></div></td>
		<td colspan="2" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff" nowrap="nowrap"><div align="left"><strong><?php echo $companyname; ?></strong></div></td>
	  </tr>
	  <tr>
	    <td class="bodytext31"  valign="center"  align="left" 
					bgcolor="#ffffff">&nbsp;</td>
	    </tr>
	  <tr>
		<td class="bodytext31"  valign="center"  align="left" 
					bgcolor="#ffffff"><div align="left">&nbsp;</div></td>
		  </tr>
	</table>
	<?php  } ?>
	<?php 
	//}
//}
?>
</body>
<?php	
$content = ob_get_clean();

// convert in PDF

try
{
$html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('ExtMedicine Label.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>
