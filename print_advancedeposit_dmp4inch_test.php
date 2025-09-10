<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

 $patientcode = $_REQUEST['patientcode'];
 $billnumbercode = $_REQUEST['billnumbercode'];
 $locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
?>

<script language="javascript">
window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#';
        window.location.reload();
    }
}
</script>
<style type="text/css">
.bodytext3 {FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000; 
}
.bodytext36 {FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext37 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext38 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; text-transform:uppercase;
}
.bodytext{ text-decoration: underline; line-height:14px;
}

table{
   display: table;
   width: 100%;
   table-layout: fixed;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
</style>
<body onkeydown="escapeke11ypressed()">


		<!--<tr>
			<td colspan="4" class="bodytext32">
              <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = $address1.' ';
			}
			?></td>
		</tr>
		
		<tr>
			<td colspan="4" align="left" class="bodytext32">
            <?php
			$address2 = $area.''.$city.'  '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = $address2.' ';
			}
			?>
			<strong><?php echo $address2; ?></strong></td>
		</tr> -->
		


<?php include ('convert_currency_to_words.php'); ?>
<?php 
	$query1 = "select * from master_customer where  customercode = '$patientcode'";
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
		
		$query1 = "select * from master_transactionadvancedeposit where locationcode='$locationcode' and patientcode = '$patientcode' and docno = '$billnumbercode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		$transactionamount = 0.00;
		
		$res1 = mysqli_fetch_array($exec1);
	     $patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		 $transactionmode = $res1['transactionmode'];
	    $transactionamount = $res1['transactionamount'];
	    $transactiondate = $res1['transactiondate'];
		$transactiontime = $res1['transactiontime'];
		$locationname=$res1['locationname'];
		$billnumbercode=$res1['docno'];
		//if transaction mode is split
		 $cashamount=$res1['cashamount'];
		$onlineamount=$res1['onlineamount'];
		$creditamount=$res1['creditamount'];
		$chequeamount=$res1['chequeamount'];
		$cardamount=$res1['cardamount'];
		
		$mpesanumber=$res1['mpesanumber'];
		$chequenumber=$res1['chequenumber'];
		$chequedate=$res1['chequedate'];
		$bankname=$res1['bankname'];
		$creditcardnumber=$res1['creditcardnumber'];
		$creditcardbankname=$res1['creditcardbankname'];
		$creditcardname=$res1['creditcardname'];
		$onlinenumber=$res1['onlinenumber'];
		//ends here
		
	    $transactiondate = strtotime($transactiondate);
		
	  $transactionamount=number_format($transactionamount,2,'.',',');
	   $transactionamountinwords = covert_currency_to_words($transactionamount); 

		?>

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
<table width="auto" border="0" align="center" cellpadding="2" cellspacing="5">
		<tr>
			<td colspan="4" class="bodytext37	" align="center" valign="middle"><?php echo "".$locationname; ?>
		    </td>
		</tr>
        <tr>
			<td colspan="4" class="bodytext37" align="center" valign="top" width="500">
			<?php echo "TEL: ".$phonenumber1; ?>
		    </td>
		</tr>

	<tr>
    <td class="bodytext37" width="">Name : </td>
    <td width="250" class="bodytext36" ><?php echo $patientname; ?></td>
	  <td width="50%" class="bodytext37">Rec. No: </td>
      <td width="50%" class="bodytext36"><?php echo $billnumbercode; ?></td>
		
	</tr>
	<tr>
		<td  align="left" class="bodytext37" >Reg No: </td>
        <td width="50%"   align="left" class="bodytext36" ><?php echo $patientcode; ?></td>
        <td width="50%"  class="bodytext37">Date: </td>
        <td width="50%" class="bodytext36"><?php echo date('d/m/Y',$transactiondate); ?></td>
	</tr>
</table>
<table width="auto" align="center" border="" cellspacing="5" cellpadding="0">
<tr>
			<td class="bodytext36" colspan="3" ><strong>Deposit Amount: </strong><?php echo $transactionamount; ?></td>
  </tr>

<tr>
  <td class="bodytext bodytext37" colspan="3">Payment Mode :</td>
</tr>


<tr>
			<td class="bodytext38" >Cash: </td>
			<td nowrap="nowrap" align="right" class="bodytext36"><?php echo number_format($cashamount,2,'.',','); ?></td>
            <td colspan="" nowrap="nowrap" class="bodytext40">&nbsp;</td>
  </tr>

<tr>
			<td class="bodytext38" >Online: </td>
			<td nowrap="nowrap" align="right" class="bodytext36"><?php echo number_format($onlineamount,2,'.',','); ?></td>
            <td colspan="" nowrap="nowrap" class="bodytext40">&nbsp;</td>
  </tr>

<tr>
			<td class="bodytext38" >Mobile Money: </td>
			<td nowrap="nowrap" align="right" class="bodytext36"><?php echo number_format($creditamount,2,'.',','); ?></td>
            <td colspan="" nowrap="nowrap" class="bodytext40">&nbsp;</td>
  </tr>
<tr>
			<td class="bodytext38" >Cheque: </td>
			<td nowrap="nowrap" align="right" class="bodytext36"><?php echo number_format($chequeamount,2,'.',','); ?></td>
            <td colspan="" nowrap="nowrap" class="bodytext40">&nbsp;</td>
  </tr>

<tr>
			<td class="bodytext38" >Credit Card: </td>
			<td nowrap="nowrap" align="right" class="bodytext36"><?php echo number_format($cardamount,2,'.',','); ?></td>
            <td colspan="" nowrap="nowrap" class="bodytext40"><?php for($i=0;$i<=60;$i++){echo "&nbsp;";}?></td>
  </tr>
		<tr>
		<td class="bodytext36" colspan="3"><strong>Uganda Shillings </strong><?php echo str_replace('Kenya Shillings','',$transactionamountinwords); ?></td>
	</tr>

<tr>
  <td class="bodytext36" align="right" width="500" colspan="3"><strong>Served By: </strong><?php echo strtoupper($username); ?></td>
</tr>
</table>
</body>
<?php	

    $content = ob_get_clean();

    // convert in PDF
 
    try
    {
		$width_in_inches = 5.85;
		$height_in_inches = 3.49;
		$width_in_mm = $width_in_inches * 25.4; 
		$height_in_mm = $height_in_inches * 25.4;
        $html2pdf = new HTML2PDF('L', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0,0));
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		
        $html2pdf->Output('print_advancedeposit.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	?>