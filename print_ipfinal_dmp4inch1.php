<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$patientcode = $_REQUEST['patientcode'];
$billnumbercode = $_REQUEST['billnumbercode'];
$cashmode = '';
$chequemode = '';
$mpesamode = '';
$onlinemode = '';
$cardmode = '';

?>
<style type="text/css">
.bodytext {text-decoration:underline;}
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
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000; 
}.style2 {FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000; 
}
.bodytext33{FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000; }
.bodytext312 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C;  }
</style>

<script language="javascript">
window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#';
        window.location.reload();
    }
}
</script>
<body onkeydown="escapeke11ypressed()">

<?php 
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
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
		$locationname =  $res2["locationname"];
		$prefix = $res2["prefix"];
		$suffix = $res2["suffix"];
?>	
			
<!--			<td colspan="4">
			  <div align="center">
			    <?php
			$strlen2 = strlen($locationname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$locationname = ' '.$locationname.' ';
			}
			?>			
	        </div></td>-->

		<!--<tr>
			<td colspan="4" class="bodytext32"><div align="center"><?php echo $address1; ?>
		      <?php
		/*	$address2 = $area.''.$city.'  '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}*/
			?>	
            		
		    </div></td>
		</tr>-->
<?php include ('convert_currency_to_words.php'); ?>
<?php
	$query1 = "select * from master_customer where locationcode='$locationcode' and customercode = '$patientcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		$res1 = mysqli_fetch_array($exec1);
		
		$patientname=$res1['customerfullname'];
		$patientcode=$res1['customercode'];
		$accountname = $res1['accountname'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		
		
		$query67 = "select * from master_accountname where locationcode='$locationcode' and auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		$query1 = "select * from master_transactionip where locationcode='$locationcode' and patientcode = '$patientcode' and billnumber='$billnumbercode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		$transactionamount = 0.00;
		
		$res1 = mysqli_fetch_array($exec1);
	     $patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$username = $res1['username'];
	    $transactionamount = $res1['transactionamount'];
		$cashamount = $res1['cashamount'];
		$onlineamount = $res1['onlineamount'];
		$mpesaamount = $res1['mpesaamount'];
		$chequeamount = $res1['chequeamount'];
		$cardamount = $res1['cardamount'];
		
		if($cashamount != 0.00)
		{
		$cashmode = "CASH";
		}
		if($onlineamount != 0.00)
		{
		$onlinemode = "ONLINE";
		}
		if($mpesaamount != 0.00)
		{
		$mpesamode = "MPESA";
		}
		if($chequeamount != 0.00)
		{
		$chequemode = "CHEQUE";
		}
		if($cardamount != 0.00)
		{
		$cardmode = "CARD";
		}
		
		
	    $transactiondate = $res1['transactiondate'];
		$transactiontime = $res1['transactiontime'];
	    $transactiondate = strtotime($transactiondate);
		
	  
	   $convertedwords = covert_currency_to_words(number_format($transactionamount)); 

		?>
		<?php include('print_header80x80.php'); ?>
<table width="100%" border="0" align="left" cellpadding="2" cellspacing="5">
	<tr>
    <td width="50%" class="bodytext32" >Name : </td>
    <td width="250" class="bodytext33" ><?php echo $patientname; ?></td>
	  <td width="30%" class="bodytext32">Rec No: </td>
      <td width="50%" class="bodytext33"><?php echo $billnumbercode; ?></td>
		
	</tr>
	<tr>
		<td width="50%"  align="left" class="bodytext32" >Reg No: </td>
        <td width="50%"   align="left" class="bodytext33" ><?php echo $patientcode; ?></td>
        <td width="50%"  class="bodytext32">Date: </td>
        <td width="50%" class="bodytext33"><?php echo date("d/m/Y", $transactiondate); ?></td>
	</tr>
</table>
<table width="100%" border="" align="center" cellpadding="1" cellspacing="3">
  
<tr>
    <td class="bodytext32" width="20%">Total Amount:</td>
    <td width="21%" align="right" class="bodytext33"><?php echo number_format($transactionamount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext32 bodytext" colspan="3">Payment Mode:</td>
  </tr>
  <tr>
    <td class="bodytext32">Cash Received:</td>
    <td width="21%" align="right" class="bodytext33"><?php echo number_format($cashamount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext32">Cheque Amount:</td>
    <td width="21%" align="right" class="bodytext33"><?php echo number_format($chequeamount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext32">MPESA Amount:</td>
    <td width="21%" align="right" class="bodytext33"><?php echo number_format($mpesaamount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext32">Card Amount:</td>
    <td width="21%" align="right" class="bodytext33"><?php echo number_format($cardamount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext32">Online Amount:</td>
    <td width="21%" align="right" class="bodytext33"><?php echo number_format($onlineamount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="bodytext33"><strong>Kenya Shillings </strong><?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td>
  </tr>
  <tr>
    <td  colspan="3" align="right" class="bodytext33"><strong>Served By: </strong><?php echo strtoupper($username); ?></td>
  </tr>
  <tr>
    <td  colspan="3" width="400" align="right" class="bodytext30	"><?php echo date("d/m/Y", $transactiondate). "&nbsp;". date('g.i A',strtotime($transactiontime)); ?> </td>
  </tr>
</table>
</body>
<?php	
  $content = ob_get_clean();
    // convert in PDF
    try
    {
        $html2pdf = new HTML2PDF('L', 'A6', 'en');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		
        $html2pdf->Output('print_depositcollection.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	?>