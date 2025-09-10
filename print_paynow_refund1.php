<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$res21radiologyitemrate = '';
$subtotal = '';
$res19amount1 = ''; 
$res20amount1 = ''; 
$res21amount1 = ''; 
$res22amount1 = '';
$res23amount1 = '';
$res18total  = '';
$colorloopcount = '';
$totallab = '';
$sno = 1;
$labrate =0.00;

//$financialyear = $_SESSION["financialyear"];

	$query6 = "select * from master_company where auto_number = '$companyanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$res6companycode = $res6["companycode"];
	
	$query7 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
	settingsname = 'CURRENT_FINANCIAL_YEAR'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7 = mysqli_fetch_array($exec7);
	$financialyear = $res7["settingsvalue"];
	$_SESSION["financialyear"] = $financialyear;
	//echo $_SESSION['financialyear'];

if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

if (isset($_REQUEST["patientcode"])) { $patientcode1 = $_REQUEST["patientcode"]; } else { $patientcode1 = ""; }
//echo $billnumber;
if (isset($_REQUEST["visitcode"])) { $visitcode1 = $_REQUEST["visitcode"]; } else { $visitcode1 = ""; }

$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$res1phonenumber1 = $res1['phonenumber1'];


$query2 = "select * from master_transactionpaylater where billnumber = '$billnumber'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2patientname = $res2['patientname'];
$res2patientcode = $res2['patientcode'];
$res2visitcode = $res2['visitcode'];
$res2billnumber = $res2['billnumber'];
$res2transactionamount = $res2['transactionamount'];
$res2transactiondate = $res2['transactiondate'];
$res2transactiontime = $res2['transactiontime'];
$res2transactiontime = explode(":",$res2transactiontime);
$res2transactionmode = $res2['transactionmode'];
$res2username = $res2['username'];
$res2accountname = $res2['accountname'];

$res2username = strtoupper($res2username);
//$res2cashgiventocustomer = $res2['cashgiventocustomer'];
//$res2cashgivenbycustomer = $res2['cashgivenbycustomer'];

$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode1'");
$execlab1=mysqli_fetch_array($querylab1);
$res22patientname=$execlab1['customerfullname'];
$res22patientaccount=$execlab1['accountname'];

$query26 = "select * from refund_paynowlab where billnumber = '$billnumber' ";
$exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query26".mysqli_error($GLOBALS["___mysqli_ston"]));
$res26 = mysqli_fetch_array($exec26);
//$res22patientname = $res22['patientname'];
$res26patientcode = $res26['patientcode'];
$res26visitcode = $res26['patientvisitcode'];
$res26patientname = $res26['patientname'];
$res26billnumber = $res26['billnumber'];
$res26transactionamount = $res26['labitemrate'];
$res26transactiondate = $res26['billdate'];
$res26accountname = $res26['accountname'];
$res26username = $res26['username'];

$query27 = "select * from refund_paynow where billnumber = '$billnumber' ";
$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
$res27 = mysqli_fetch_array($exec27);
$res27billnumber = $res27['billnumber'];
$res27transactiontime = $res27['transactiontime'];
$res27accountname = $res27['accountname'];
$res27username = $res27['username'];
$res27transactiondate = $res27['transactiondate'];
$res27username = strtoupper($res27username);
//$res2cashgiventocustomer = $res2['cashgiventocustomer'];
//$res2cashgivenbycustomer = $res2['cashgivenbycustomer'];

  
$query4 = "select sum(totalamount) as totalamount1 from billing_paylaterconsultation where billno = '$res2billnumber' and visitcode = '$res2visitcode'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$res4totalamount = $res4['totalamount1'];

$query5 = "select sum(amount) as amount1 from billing_paylaterpharmacy where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
//echo $num = mysql_num_rows($exec5);
$res5amount = $res5['amount1'];

$query8 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$res8labitemrate = $res8['labitemrate1'];

$query9 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
$res9 = mysqli_fetch_array($exec9);
$res9radiologyitemrate = $res9['radiologyitemrate1'];

$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10". mysqli_error($GLOBALS["___mysqli_ston"]));
$res10 = mysqli_fetch_array($exec10);
$res10referalrate = $res10['referalrate1'];

$query11 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11". mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$res11servicesitemrate = $res11['servicesitemrate1'];

$query12 = "select * from master_transactionpaylater where billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactiontype = 'paylatercredit'";
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12". mysqli_error($GLOBALS["___mysqli_ston"]));
$res12 = mysqli_fetch_array($exec12);
$res12transactionamount = $res12['transactionamount'];

$query13 = "select * from master_transactionpaylater where billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactiontype = 'pharmacycredit'";
$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13". mysqli_error($GLOBALS["___mysqli_ston"]));
$res13 = mysqli_fetch_array($exec13);
$res13transactionamount = $res13['transactionamount'];

$query14 = "select * from master_transactionpaylater where billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactionmodule = 'PAYMENT'";
$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14". mysqli_error($GLOBALS["___mysqli_ston"]));
$res14 = mysqli_fetch_array($exec14);
$res14transactionamount = $res14['transactionamount'];

$credit = $res12transactionamount + $res13transactionamount;

$query200 = "select * from refund_paynowlab where billnumber = '$billnumber' ";
$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));

$totalpharm=0;
$phaname = '';

$query25 = "select * from pharmacysalesreturn_details where visitcode='$visitcode1' and patientcode='$patientcode1' and billstatus='pending'";
$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res25 = mysqli_fetch_array($exec25))
			{
			$phadate=$res25['entrydate'];
			$phaname=$res25['itemname'];
			$phaquantity=$res25['quantity'];
			$pharate=$res25['rate'];
			$phaamount=$res25['totalamount'];
			}
			
$query87="select * from master_consultationpharm where patientcode='$patientcode1' and patientvisitcode='$visitcode1' and medicinename='$phaname'";
			$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res87=mysqli_fetch_array($exec87);
			$pharefno=$res87['billnumber'];
						 
			 ?>
<script language="javascript">
window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#externalbill';
        window.location.reload();
    }
}

function escapekeypressed()
{
	//alert(event.keyCode);
	if(event.keyCode=='27'){ window.close(); }
}

</script>
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
    height: auto;
    width: 702px;
	position: absolute;
    top: 180;
    left: 8;
  
}
.data {font-size:14px }
.data {table-layout:auto }
</style>
<body onkeydown="escapekeypressed()">
<table width="702" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div align="left">&nbsp;
	<?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="75" />
			
			<?php
			}
			?>	
	</div></td>
	<td>
	<div align="right">
	<?php
	echo '<strong>'.$res1companyname.'</strong>';
	echo '<br>'.$res1address1.' '.$res1area.' '.$res1city.' '.$res1pincode;
	echo '<br>Phone : '.$res1phonenumber1;
	?>
	</div></td>
  </tr>
  
  
  <tr>
    <td>
	  <div align="left">
	<strong><?php
	echo 'Name : '.$res26patientname.'&nbsp;';
	echo '<br>Reg No. : '.$patientcode1;
	echo '<br>Visit No. : '.$visitcode1;
	?></strong>
    </div>
	</td>
	
	<td>
	<div align="right">
	<strong><?php
	echo 'Bill Number : '.$res26billnumber.'&nbsp;';
	echo '<br>Bill Date : '.$res26transactiondate;
	?></strong>&nbsp;
    </div>
	</td>
  </tr>
  
</table>
  <?php 
  $total = $res4totalamount + $res5amount + $res8labitemrate + $res9radiologyitemrate + $res10referalrate + $res11servicesitemrate;
  $amountdue = $total - $credit; 
  ?>
  <table class ="data" border="0" cellspacing="0" cellpadding="5">
  <tr>
	<td width="47" align="left" valign="center" 
 bgcolor="#ffffff" class="bodytext31"><strong>S.No. </strong></td>
<td width="268"  align="left" valign="center" 
bgcolor="#ffffff" class="bodytext31"><strong> Description</strong></td>
<td  align="left" valign="center" 
bgcolor="#ffffff" class="bodytext31"><strong>Qty </strong></td>
<td  align="left" valign="center" 
bgcolor="#ffffff" class="bodytext31"><strong> Rate</strong></td>
<td width="157"  align="left" valign="center" 
bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>
</tr>

<tr>

<?php 
/*
$overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref)-$totalcopay;
$overalltotal=number_format($overalltotal,2,'.','');
$consultationtotal=$totalop-$totalcopay;
$consultationtotal=number_format($consultationtotal,2,'.','');
$netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalref;
$netpay=number_format($netpay,2,'.','');
$totalamount=$overalltotal;
*/
while($res200 = mysqli_fetch_array($exec200))
 {
$labdate=$res200['billdate'];
$labname=$res200['labitemname'];
$labrate=$res200['labitemrate'];
$totallab=$totallab+$labrate;

echo '<tr>';
echo '<td width="49" align="left" valign="center" 
 bgcolor="#ffffff" class="bodytext31">'.$sno.'</td>';
echo '<td width="307"  align="left" valign="center" 
bgcolor="#ffffff" class="bodytext31">'.$labname.'</td>';
echo '<td  align="left" valign="center" 
bgcolor="#ffffff" class="bodytext31">1</td>';
echo '<td  align="left" valign="center" 
bgcolor="#ffffff" class="bodytext31">'.$labrate.'</td>';
echo '<td width="189"  align="left" valign="center" 
bgcolor="#ffffff" class="bodytext31">'.$labrate.'</td>';
echo '</tr>';
$sno++;
}
?>

<?php
if($res4totalamount !='')
{
?>

<td class="bodytext31" valign="center"  align="left">
<div align="center"></div></td>
</tr>
<?php 


$query17 = "select * from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res17 = mysqli_fetch_array($exec17))
{
$res17consultationfee=$res17['consultationfees'];
$res17viscode=$res17['visitcode'];
$res17consultationdate=$res17['consultationdate'];
$res17quantity = '1.00';
$res17total = $res17consultationfee/$res17quantity;
//$res41billdate = $res41bill['billdate'];
?>

<?php
}
?>

<?php 

$query18 = "select * from master_billing where visitcode='$visitcode1' and patientcode='$patientcode1'";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res18 = mysqli_fetch_array($exec18))
{
$res18billingdatetime=$res18['billingdatetime'];
$res18quantity = '1.00';
$res18billno = $res18['billnumber'];
$res18copayfixedamount = $res18['copayfixedamount'];
$res18total = $res18copayfixedamount/$res18quantity;

?>
<tr>


<td width = "47" class="bodytext31" valign="center"  align="left">
<div align="left"></div></td>
<td width="268"  align="left" valign="center" nowrap class="bodytext31">
<div align="left"><?php echo 'Copay Amount'; ?></div></td>
<td width="71"class="bodytext31" valign="center"  align="left"><?php echo number_format($res18copayfixedamount,2,'.',','); ?></td>
<td width="139"class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo $res18quantity; ?></div></td>
<td width="157"class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo number_format(-$res18total,2,'.',','); ?></div></td>
</tr>
<?php 
}
$subtotal = $res17total - $res18total;
?>

<tr>
<td class="bodytext31" width ="47" valign="center"  align="left">
  <div align="left"></div></td>
<td width="268"  align="left" valign="center" nowrap class="bodytext31">
  <div align="left">
    <?php //echo 'Copay Amount'; ?>
  </div></td>
<td  align="left" valign="center" class="bodytext31"><strong><?php echo 'Sub Total:'; ?></strong></td>
<td  align="left" valign="center" class="bodytext31">
<div class="bodytext31" align="center">&nbsp;</div></td>
<td class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo number_format($subtotal,2,'.',','); ?></div></td>
</tr>
<?php
}
?>

<?php
if($res5amount != '')
{
?>
<tr>
<td>
<div align="center"></div></td>
</tr>
<?php 
$res19amount1 = '0.00';
$query19 = "select * from billing_paylaterpharmacy where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res19 = mysqli_fetch_array($exec19))
{
$res19billdate = $res19['billdate'];
$res19medicinename = $res19['medicinename'];
$res19quantity = $res19['quantity'];
$res19rate = $res19['rate'];
$res19amount = $res19['amount'];
$res19amount1 = $res19amount1 + $res19amount;

$query199 = "select * from master_consultationpharm where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec199 = mysqli_query($GLOBALS["___mysqli_ston"], $query199) or die ("Error in Query199".mysqli_error($GLOBALS["___mysqli_ston"]));
$res199 = mysqli_fetch_array($exec199);
$res199referalno=$res199['refno'];
?>

<tr>
<td class="bodytext31" width ="47" valign="center"  align="left">
  <div align="left"></div></td>
<td width="268"  align="left" valign="center" nowrap class="bodytext31">
<div align="left"><?php echo $res19medicinename; ?></div></td>
<td width ="71"class="bodytext31" valign="center"  align="left"><?php echo number_format($res19rate,2,'.',','); ?></td>
<td width ="139"class="bodytext31" valign="center"  align="left">
<div class="bodytext31" align="left"><?php echo $res19quantity; ?></div></td>
<td width ="157"class="bodytext31" valign="center"  align="left">
  <div align="left"><?php echo number_format($res19amount,2,'.',','); ?></div></td>
</tr>
<?php
}
?>
<tr>
<td class="bodytext31" width ="47" valign="center"  align="left">&nbsp;</td>
<td width="268"  align="left" valign="center" nowrap class="bodytext31">
  <div align="left">
    <?php //echo 'Copay Amount'; ?>
  </div></td>
<td class="bodytext31" valign="center"  align="left"><strong><?php echo 'Sub Total:'; ?></strong></td>
<td class="bodytext31" valign="center"  align="left">
<div class="bodytext31" align="center"></div></td>
<td class="bodytext31" valign="center"  align="left">
  <div align="left"><?php echo number_format($res19amount1,2,'.',','); ?></div></td>
</tr>
<?php
}
?>

<?php 
if($res8labitemrate != '')
{
?>
<tr>
<td>
<div align="center"></div></td>
</tr>

<?php 
$res20amount1 = '0.00';
$query20 = "select * from billing_paylaterlab where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res20 = mysqli_fetch_array($exec20))
{
$res20billdate = $res20['billdate'];
$res20labitemname = $res20['labitemname'];
$res20quantity = '1.00';
$res20labitemrate = $res20['labitemrate'];
$res20amount = $res20labitemrate/$res20quantity;
$res20amount1 = $res20amount1 + $res20amount;

?>
<tr>
<td class="bodytext31" width ="47" valign="center"  align="left">
<div align="left"></div></td>
<td width="268"  align="left" valign="center" nowrap class="bodytext31">
<div align="left"><?php echo $res20labitemname; ?></div></td>
<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo number_format($res20labitemrate,2,'.',','); ?></div></td>
<td class="bodytext31" valign="center"  align="left">
<div class="bodytext31" align="left"><?php echo $res20quantity; ?></div></td>
<td class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo number_format($res20amount,2,'.',','); ?></div></td>
</tr>
<?php
}
?>
<tr>
<td class="bodytext31" width ="47" valign="center"  align="left">
  <div align="left"></div></td>
<td width="268"  align="left" valign="center" nowrap class="bodytext31">
  <div align="left">
    <?php //echo $patientcode; ?>
  </div></td>
<td class="bodytext31" valign="center"  align="left"><strong><?php echo 'Sub Total:'; ?></strong></td>
<td class="bodytext31" valign="center"  align="left">
  <div align="left">
    <?php //echo $patientcode; ?>
  </div></td>
<td class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo number_format($res20amount1,2,'.',','); ?></div></td>
</tr>
<?php
}
?>

<?php 
if($res9radiologyitemrate != '')
{
?>
<tr>
<td>
<div align="center"></div></td>
</tr>
<?php 
$res21amount1 = '0.00';
$query21 = "select * from billing_paylaterradiology where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res21 = mysqli_fetch_array($exec21))
{
$res21billdate = $res21['billdate'];
$res21radiologyitemname = $res21['radiologyitemname'];
$res21quantity = '1.00';
$res21radiologyitemrate = $res21['radiologyitemrate'];
$res21amount = $res21radiologyitemrate/$res21quantity;
$res21amount1 = $res21amount1 + $res21amount;

$query211 = "select * from consultation_radiology where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die ("Error in Query211".mysqli_error($GLOBALS["___mysqli_ston"]));
$res211 = mysqli_fetch_array($exec211);
$res211referal=$res211['refno'];
?>
<tr>
<td class="bodytext31" width ="47" valign="center"  align="left">
<div align="left"></div></td>
<td width="268"  align="left" valign="center" nowrap class="bodytext31">
<div align="left"><?php echo $res21radiologyitemname; ?></div></td>
<td class="bodytext31" valign="center"  align="left"><?php echo number_format($res21radiologyitemrate,2,'.',','); ?></td>
<td class="bodytext31" valign="center"  align="left">
<div class="bodytext31" align="left"><?php echo $res21quantity; ?></div></td>
<td class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo number_format($res21amount,2,'.',','); ?></div></td>
</tr>
<?php
}
?>
<tr>
<td class="bodytext31" width ="47" valign="center"  align="left">
  <div align="left"></div></td>
<td width="268"  align="left" valign="center" nowrap class="bodytext31">
  <div align="left">
    <?php //echo 'Copay Amount'; ?>
  </div></td>
<td class="bodytext31" valign="center"  align="left"><strong><?php echo 'Sub Total:'; ?></strong></td>
<td class="bodytext31" valign="center"  align="left">
<div class="bodytext31" align="center"></div></td>
<td class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo number_format($res21amount1,2,'.',','); ?></div></td>
</tr>



<?php
}
?>

<?php
if($res10referalrate != '')
{
?>
<tr>
<td>
<div align="center"></div></td>
</tr>
<?php 
$res22amount1 = '0.00';
$query22 = "select * from billing_paylaterreferal where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res22 = mysqli_fetch_array($exec22))
{
$res22billdate = $res22['billdate'];
$res22referalname = $res22['referalname'];
$res22quantity = '1.00';
$res22referalrate = $res22['referalrate'];
$res22amount = $res22referalrate/$res22quantity;
$res22amount1 = $res22amount1 + $res22amount;

$query222 = "select * from consultation_referal where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
$res222 = mysqli_fetch_array($exec222);
$res222referalno=$res222['refno'];
?>

<tr>
<td class="bodytext31" width ="47" valign="center"  align="left">
<div align="left"></div></td>

<td width="268"  align="left" valign="center" nowrap class="bodytext31">
<div align="left"><?php echo $res22referalname; ?></div></td>
<td class="bodytext31" valign="center"  align="left"><?php echo number_format($res22referalrate,2,'.',','); ?></td>
<td class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo $res22quantity; ?></div></td>
<td class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo number_format($res22amount,2,'.',','); ?></div></td>
</tr>
<?php
}
?>
<tr>
<td class="bodytext31" width ="47" valign="center"  align="left">
  <div align="left"></div></td>
<td width="268"  align="left" valign="center" nowrap class="bodytext31">
  <div align="left">
    <?php //echo 'Copay Amount'; ?>
  </div></td>
<td class="bodytext31" valign="center"  align="left"><strong><?php echo 'Sub Total:'; ?></strong></td>
<td class="bodytext31" valign="center"  align="left">
<div class="bodytext31" align="center"></div></td>
<td class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo number_format($res22amount1,2,'.',','); ?></div></td>
</tr>
<?php
}
?>
<?php
if($res11servicesitemrate != '')
{
?>
<tr>
<td>
<div align="center"></div></td>
</tr>
<?php 
$res23amount1 = '0.00';
$query23 = "select * from billing_paylaterservices where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res23 = mysqli_fetch_array($exec23))
{
$res23billdate = $res23['billdate'];
$res23servicesitemname = $res23['servicesitemname'];
$res23quantity = '1.00';
$res23servicesitemrate = $res23['servicesitemrate'];
$res23amount = $res23servicesitemrate/$res23quantity;
$res23amount1 = $res23amount1 + $res23amount;

$query233 = "select * from consultation_services where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
$res233 = mysqli_fetch_array($exec233);
$res233referal=$res233['refno'];
?>

<tr>
<td class="bodytext31" width ="47" valign="center"  align="left">
<div align="left"></div></td>
<td width="268"  align="left" valign="center" nowrap class="bodytext31">
<div align="left"><?php echo $res23servicesitemname; ?></div></td>
<td class="bodytext31" valign="center"  align="left"><?php echo number_format($res23servicesitemrate,2,'.',','); ?></td>
<td class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo $res23quantity; ?></div></td>
<td class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo number_format($res23amount,2,'.',','); ?></div></td>
</tr>
<?php 
}
?>
<tr>
<td class="bodytext31" width ="47"  valign="center"  align="left">
  <div align="left"></div></td>
<td width="268"  align="left" valign="center" nowrap class="bodytext31">
  <div align="left">
    <?php //echo 'Copay Amount'; ?>
  </div></td>
<td class="bodytext31" valign="center"  align="left"><strong><?php echo 'Sub Total:'; ?></strong></td>
<td class="bodytext31" valign="center"  align="left">
<div class="bodytext31" align="center"></div></td>
<td class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo number_format($res23amount1,2,'.',','); ?></div></td>
</tr>
<?php
}
?>

<?php 
$grandtotal = '';
$grandtotal = $subtotal + $res19amount1 + $res20amount1 + $res21amount1 + $res22amount1 + $res23amount1;
$grandtotal = number_format($grandtotal,2,'.',',');
?>
<tr>
<td class="bodytext31" width ="47" valign="center"  align="left">
  <div align="left"></div></td>
<td width="268"  align="left" valign="center" nowrap class="bodytext31">
  <div align="left">
    <?php //echo 'Copay Amount'; ?>
  </div></td>
<td class="bodytext31" valign="center"  align="left" nowrap="nowrap"><strong><?php echo 'Net Total:'; ?></strong></td>
<td class="bodytext31" valign="center"  align="left">
<div class="bodytext31" align="center">&nbsp;</div></td>
<td class="bodytext31" valign="center"  align="left">
<div align="left"><?php echo number_format($totallab,2,'.',''); ?></div></td>
</tr>
<!-- 
		  <?php
	include ('convert_currency_to_words.php');
	$convertedwords = covert_currency_to_words($totallab); ?>
-->

<tr>
<td colspan ="5" class="bodytext31"  valign="center"  align="left" 
                bgcolor="#ffffff"><strong> Amount in words:</strong> <?php echo $convertedwords; ?></td>
     </tr>
<tr>
<td class="bodytext31" width ="47" valign="center"  align="left">
  <div align="left"></div></td>
<td width="268"  align="left" valign="center" nowrap class="bodytext31">
  <div align="left">
    <?php //echo 'Copay Amount'; ?>
  </div></td>
<td class="bodytext31" valign="center"  align="left" nowrap="nowrap"><strong><?php echo 'Served By:'; ?></strong></td>
<td class="bodytext31" valign="center"  align="left">
<div class="bodytext31" align="center"></div></td>
<td class="bodytext31" valign="center"  align="left">
<div align="left"><strong><?php echo strtoupper($res27username); ?></strong></div></td>
</tr>

<tr>
<td class="bodytext31" width ="47" valign="center"  align="left">
  <div align="left"></div></td>
<td  align="left" valign="center" nowrap class="bodytext31">
  <div align="left">
    <?php //echo 'Copay Amount'; ?>
  </div></td>
<td class="bodytext31" valign="center"  align="left"><strong>
  <?php //echo 'Served By:'; ?>
</strong></td>
<td class="bodytext31" valign="center"  align="left">
<div class="bodytext31" align="center"></div></td>
<td  align="left" valign="center" nowrap class="bodytext32">
<div align="left"><strong><?php echo $res27transactiondate; ?> <?php echo $res27transactiontime[0];  ?>:<?php echo $res27transactiontime[1]; ?></strong></div></td>
</tr>
</table>
</td>
</tr>
</table>
</table>
  
	
				  

</body>