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

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

	$query2 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$companyname = $res2["companyname"];
	$address1 = $res2["address1"];
	$area = $res2["area"];
	$city = 
	
	$res2["city"];
	$pincode = $res2["pincode"];
	$phonenumber1 = $res2["phonenumber1"];
	$phonenumber2 = $res2["phonenumber2"];
	$tinnumber1 = $res2["tinnumber"];
	$cstnumber1 = $res2["cstnumber"];
	
	include('convert_currency_to_words.php');
	
	$query11 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec11);
	$res11 = mysqli_fetch_array($exec11);
	$res11patientfirstname = $res11['patientname'];
	$res11patientcode = $res11['patientcode'];
	$res11visitcode = $res11['patientvisitcode'];
	$res11billnumber = $res11['billnumber'];
	$res11locationcode = $res11['locationcode'];
	$billamount=0;
?>

<?php 
$query2 = "select * from master_location where locationcode = '$res11locationcode'";
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

.bodytext3 {	FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext31 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext311 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none

}

.bodytext365 {FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext366 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 

}.style2 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 

}

.bodytext33{FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; }

.bodytext312 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}



.bodytext332{FONT-WEIGHT: bold; FONT-SIZE: 25px; COLOR: #000000; }

.bodytext30 { FONT-SIZE: 18px; FONT-WEIGHT: bold; COLOR: #000000; }

.bodytext{ text-decoration: underline; line-height:14px}

body {

	background-color: #ecf0f5;

}

body {

	width:421px;

	heigth:595px;

	margin:  auto;

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  }

.page_footer

{

	font-family: Times;

	text-align:center;

	font-weight:bold;

	margin-bottom:25px;

	

}



</style>
<?php include('print_header80x80.php'); ?>
<table width="100%"  border="" align="center" cellpadding="0" cellspacing="0">
<tr><td class="" colspan="4" width="300">&nbsp;</td></tr>
	<tr>
    	<td class="bodytext32" >Name: </td>
		<td colspan="" width="150" class="bodytext34"><?php echo $res11patientfirstname; ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">Patient. Code: </td>
        <td colspan="" class="bodytext34"><?php echo $res11patientcode; ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">Visit Code: </td>
        <td colspan="3" class="bodytext34"><?php echo $res11visitcode; ?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
    </table>

<table width="300"  border="0" align="center" cellpadding="5" cellspacing="5">
  <tr>
	  <td align="left" class="bodytext32 border" width="35">S.No</td>
	  <td align="left" class="bodytext32 border" width="240"><strong>Medicine Name</strong></td>
	  <td align="right" class="bodytext32 border" width="45"><strong>Qty</strong></td>

  </tr>
  
   <?php
  
			$colorloopcount = '';
			$sno = '';
	$querylab117=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'");
	$execlab117=mysqli_fetch_array($querylab117);
	$billtype=$execlab117['billtype'];
	if($billtype == 'PAY NOW')
			{
			$status='pending';
			}
			else
	{
	$status='completed';
	}
			
			$query1 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode'  and medicineissue='pending'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res17 = mysqli_fetch_array($exec1))
			{
				
				$paharmitemname=$res17['medicinename'];
				$pharmitemcode=$res17['medicinecode'];
				$pharmdose=$res17['dose'];
				$pharmfrequency=$res17['frequencycode'];
				$pharmdays=$res17['days'];
				$pharmquantity=$res17['quantity'];
			$pharmitemrate=$res17['rate'];
			$pharmamount=$res17['amount'];
			$route = $res17['route'];
			$instructions = $res17['instructions'];
			$medanum = $res17['auto_number'];
				$dosemeasure=$res17['dosemeasure'];
			
			
		   
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
			  <tr <?php //echo $colorcode; ?>>
              	<td class="bodytext366 " valign="center"  align="left">
			   <?php echo $sno; ?></td>
			   <td class="bodytext366 border" width="120" valign="center"  align="left" nowrap="nowrap" >
			   <strong><?php echo nl2br($paharmitemname); ?></strong></td>
			   
			   <td class="bodytext366 border" valign="center"  align="right">
			   <strong><?php echo  $pharmquantity; ?></strong></td>

              </tr>
			  <tr>
			  <td class="bodytext366 border" valign="center"  align="left" colspan='3'>
			   &nbsp;&nbsp;&nbsp;&nbsp;<strong>Dose: <?php echo $pharmdose; ?>&nbsp;&nbsp;
			   Measure:<?php echo $dosemeasure; ?>&nbsp;&nbsp;
			   Days:<?php echo $pharmdays; ?>&nbsp;&nbsp;
			   Frequency:<?php echo $pharmfrequency; ?>&nbsp;&nbsp;
			   Route:<?php echo  $route; ?></strong>
			   </td>
			  </tr>
			  <tr>
			  <td class="bodytext34 border" valign="center"  align="left" colspan='3'>&nbsp;
			   </td>
			  </tr>
             
			  <?php
			 $billamount+=$pharmamount;
			}
			?>
			
		<tr>
	            <td colspan='3' align='center' class="bodytext31" ></td>
	  </tr>	

	   <tr>
	            <td colspan='3' align='center' class="bodytext366" >Printed on : <?php echo date('F d, Y H:i:s');?></td>
	  </tr>
  </table>
  
	


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
        $html2pdf->Output('print_medicine.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
?>

