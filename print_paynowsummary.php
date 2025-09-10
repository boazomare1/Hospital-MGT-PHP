<?php

ob_start();

require_once('html2pdf/html2pdf.class.php');

session_start();

//include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$res20radiologyitemrate = '';

$res2radiologyitemrate = '';

$nettotal = ''; 

$consultationsubtotal = '';

$subtotal = '';

$consultationrefundsubtotal = '';

$labrefundsubtotal = ''; 

$pharmrefundsubtotal = '';

$radiologyrefundsubtotal='';

$servicesrefundsubtotal='';

$referalrefundsubtotal = '';

$labsubtotal ='';






include('convert_currency_to_words.php');



$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }



//$locationcode = 'LTC-1';

$queryloc = "select * from master_location where locationcode = '$locationcode'";

$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));

$resloc = mysqli_fetch_array($execloc);

$locationname = $resloc['locationname'];

$address1 = $resloc['address1'];

$address2 = $resloc['address2'];

$phone = $resloc['phone'];

$email = $resloc['email'];

$website = $resloc['website'];



$queryloc = "select tinnumber from master_company";

$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));

$resloc = mysqli_fetch_array($execloc);

$tinnumber = $resloc['tinnumber'];



$query44 = "select * from master_customer where locationcode='$locationcode' and customercode = '$patientcode' ";

$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));

$num44 = mysqli_num_rows($exec44);

$res44 = mysqli_fetch_array($exec44);

$res44accountname = $res44['accountname'];



$query5 = "select * from master_accountname where locationcode='$locationcode' and auto_number = '$res44accountname'";

$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

$res5 = mysqli_fetch_array($exec5);

$res5accountname = $res5['accountname'];





$query11 = "select * from master_visitentry where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode='$visitcode' ";

$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

$res11 = mysqli_fetch_array($exec11);

$res11patientfullname = $res11['patientfullname'];

$res11patientcode = $res11['patientcode'];

$res11visitcode = $res11['visitcode'];

?>

<style type="text/css">

<!--

.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 

}

-->

.bodytext313 {FONT-WEIGHT: bold; FONT-SIZE: 12px; vertical-align:text-bottom; 

}

.style1 {vertical-align:text-bottom; font-size: 12px;}

</style>



<table width="742" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td colspan="2" align="left" valign="center" 

	 bgcolor="#ffffff" class="bodytext32">

	        <?php

			$query3showlogo = "select * from settings_billhospital  where companyanum = '$companyanum'";

			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3showlogo = mysqli_fetch_array($exec3showlogo);

			$showlogo = $res3showlogo['showlogo'];

			if ($showlogo == 'SHOW LOGO')

			{

			?>

				

			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="75" />

			

			<?php

			}

			?>	 </td>

			

	<td width="83" align="left" valign="center" 

	 bgcolor="#ffffff" class="bodytext32">&nbsp;</td>

    <td width="526" align="left" valign="center" 

	 bgcolor="#ffffff" class="bodytext32">

     <span style="font-size:22px"><?php echo $locationname; ?></span>

     <br />

	

    <p><?php echo $address1; ?><br />

        <?php echo $address2; ?><br />

      Tel : <?php echo $phone; ?><br />

      Email : <?php echo $email; ?></p>

      

	 </td>

    <td width="17" align="left" valign="center" 

	 bgcolor="#ffffff" class="bodytext32">&nbsp;</td>

  </tr>

  

  <tr>



    <td colspan="4">&nbsp;</td>

  </tr>

  

  <tr>

    <td width="104">

      <strong>Patient Name</strong></td>

	

    <td colspan="3"><strong><?php echo $res11patientfullname; ?></strong></td>

  </tr>

  <tr>

    <td><strong>Reg No</strong></td>

    <td colspan="3"><strong><?php echo $res11patientcode; ?></strong></td>

  </tr>

  <tr>

    <td><strong>Visit No</strong> </td>

    <td colspan="3"><strong><?php echo $res11visitcode; ?></strong></td>

  </tr>

  <tr>

    <td><strong>Account</strong></td>

    <td colspan="3"><strong><?php echo $res5accountname; ?></strong></td>

  </tr>

  

  <tr>

    <td colspan="5">

	 <table width="723" border="0" cellspacing="0" cellpadding="0">

  <tr>

	 <td colspan="6">&nbsp;</td> 

	 </tr>

  <tr>

	<td width="82" align="left" valign="center" 

	 bgcolor="#ffffff" class="bodytext31"><strong>Bill Date</strong></td>

	<td width="85" valign="center" 

	bgcolor="#ffffff" class="bodytext31"><strong>Ref.No</strong></td>

	<td width="292"  align="left" valign="center" 

	bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>

	<td width="80"align="center" valign="center" 

	bgcolor="#ffffff" class="bodytext31"><strong>Qty</strong></td>

	<td width="69"  align="right" valign="center" 

	 bgcolor="#ffffff" class="bodytext31"><strong>Rate</strong></td>

	<td width="125"  align="right" valign="center" 

	bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>

  </tr>

    <?php 

	$query11 = "select * from master_billing where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode='$visitcode' ";

	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num11= mysqli_num_rows($exec11);

	while($res11 = mysqli_fetch_array($exec11))

	 {

	$res11patientfirstname = $res11['patientfirstname'];

	$res11patientcode = $res11['patientcode'];

	$res11visitcode = $res11['visitcode'];

	$res11billnumber = $res11['billnumber'];

	$res11consultationfees = $res11['consultationfees'];

	$res11registrationfees = $res11['registrationfees'];

	$res11subtotalamount = $res11['subtotalamount'];

	$res11billingdatetime = $res11['billingdatetime'];

	$consultationsubtotal = $consultationsubtotal + $res11subtotalamount;

	?>  



    <tr>

      <td colspan="6" align="left" valign="center" 

	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

    </tr>

    <tr>

      <td colspan="6" align="left" valign="center" 

	 bgcolor="#ffffff" class="bodytext31"><strong>Consultation</strong></td>

      </tr>

    <tr>

	<td width="82" align="left" valign="center" 

	 bgcolor="#ffffff" class="bodytext31"><?php echo $res11billingdatetime; ?></td>

	<td width="85" valign="center" 

	bgcolor="#ffffff" class="bodytext31" align="left"><?php echo $res11billnumber; ?></td>

	<td width="292"  align="left" valign="center" 

	bgcolor="#ffffff" class="bodytext31">OP Consultation</td>

	<td width="80"align="center" valign="center" 

	bgcolor="#ffffff" class="bodytext31">1</td>

	<td width="69"  align="right" valign="center" 

	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res11consultationfees,2,',','.'); ?></td>

	<td width="125"  align="right" valign="center" 

	bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res11consultationfees,2,',','.'); ?></td>

 </tr> 

<?php

if($res11registrationfees > 0){

	

?>

    <tr>

	<td width="82" align="left" valign="center" 

	 bgcolor="#ffffff" class="bodytext31"><?php echo $res11billingdatetime; ?></td>

	<td width="85" valign="center" 

	bgcolor="#ffffff" class="bodytext31" align="left"><?php echo $res11billnumber; ?></td>

	<td width="292"  align="left" valign="center" 

	bgcolor="#ffffff" class="bodytext31"><?php echo strtoupper('Registration Fees'); ?></td>

	<td width="80"align="center" valign="center" 

	bgcolor="#ffffff" class="bodytext31">1</td>

	<td width="69"  align="right" valign="center" 

	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res11registrationfees,2,',','.'); ?></td>

	<td width="125"  align="right" valign="center" 

	bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res11registrationfees,2,',','.'); ?></td>

 </tr> 

<?php

}

?>

  <?php

   }

  ?>

 

	<?php

	$query12 = "select * from refund_consultation where locationcode='$locationcode' and patientcode = '$patientcode' and patientvisitcode='$visitcode' ";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res12 = mysqli_fetch_array($exec12))

	 {

	$res12patientfirstname = $res12['patientname'];

	$res12patientcode = $res12['patientcode'];

	$res12visitcode = $res12['patientvisitcode'];

	$res12billnumber = $res12['billnumber'];

	$res12consultation = $res12['consultation'];

	$res12billdate= $res12['billdate'];

	$consultationrefundsubtotal = $consultationrefundsubtotal + $res12consultation;

	?>

	<tr>

		<td width="82" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res12billdate; ?></td>

		<td width="85" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res12billnumber; ?></td>

		<td width="292"  align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31">Refund</td>

		<td width="80"align="center" valign="center" 

		bgcolor="#ffffff" class="bodytext31">1</td>

		<td width="69"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res12consultation,2,',','.'); ?></td>

		<td width="125"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31">-<?php echo number_format($res12consultation,2,',','.'); ?></td>

	</tr>

  <?php

   }

  ?>

  <?php $consultationsubtotal = $consultationsubtotal - $consultationrefundsubtotal; ?>

  

  <tr>

    <td colspan="4" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

    <td align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><strong>Subtotal</strong></td>

    <td align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($consultationsubtotal,2,'.',','); ?></strong></td>

  </tr>

  <tr>

    <td colspan="6" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

  </tr>

  <tr>

	  <td colspan="6" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><strong>Paynow</strong></td>

	  </tr>

	<?php  

	$query14 = "select * from master_transactionpaynow where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode='$visitcode' group by visitcode ";

	$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res14 = mysqli_fetch_array($exec14))

	 {

		$res14patientfirstname = $res14['patientname'];

		$res14patientcode = $res14['patientcode'];

		$res14visitcode = $res14['visitcode'];

		$res14billnumber = $res14['billnumber'];

		$res14billingdatetime = $res14['transactiondate'];

		$res14patientpaymentmode = $res14['transactionmode'];

		$res14username = $res14['username'];

		$res14cashamount = $res14['cashamount'];

		$res14transactionamount = $res14['transactionamount'];

		$res14chequeamount = $res14['chequeamount'];

		$res14cardamount = $res14['cardamount'];

		$res14onlineamount= $res14['onlineamount'];

		$res14creditamount= $res14['creditamount'];

		$res14updatetime= $res14['transactiontime'];

		

		$query01 = "select * from billing_paynowlab where locationcode='$locationcode' and patientvisitcode = '$res14visitcode' and patientcode = '$res14patientcode' ";

		$exec01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01) or die ("Error in Query01".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($res01 = mysqli_fetch_array($exec01))

		{

		$res01labitemname = $res01['labitemname'];

		$res01labitemrate = $res01['labitemrate'];

		$res01lbilldate= $res01['billdate'];

		$res01lbillnumber= $res01['billnumber'];

		$labsubtotal = $labsubtotal + $res01labitemrate;

    ?>

	

	<tr>

		<td width="82" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res01lbilldate; ?></td>

		<td width="85" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res01lbillnumber; ?></td>

		<td width="292"  align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res01labitemname; ?></td>

		<td width="80"align="center" valign="center" 

		bgcolor="#ffffff" class="bodytext31">1</td>

		<td width="69"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res01labitemrate; ?></td>

		<td width="125"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res01labitemrate; ?></td>

	</tr>

	<?php

		} 

		

		$query2 = "select * from billing_paynowradiology where locationcode='$locationcode' and patientvisitcode = '$res14visitcode' and patientcode = '$res14patientcode' ";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res2 = mysqli_fetch_array($exec2))

		{

		$res2radiologyitemname = $res2['radiologyitemname'];

		$res2radiologyitemrate = $res2['radiologyitemrate'];

		$res2billdate = $res2['billdate'];

		$res2billnumber = $res2['billnumber'];

		$labsubtotal = $labsubtotal + $res2radiologyitemrate;

    ?>

	

	<tr>

		<td width="82" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res2billdate; ?></td>

		<td width="85" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res2billnumber; ?></td>

		<td width="292"  align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res2radiologyitemname; ?></td>

		<td width="80"align="center" valign="center" 

		bgcolor="#ffffff" class="bodytext31">1</td>

		<td width="69"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res2radiologyitemrate; ?></td>

		<td width="125"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res2radiologyitemrate; ?></td>

	</tr>

	

	<?php  

	     }

		$query3 = "select * from billing_paynowservices where locationcode='$locationcode' and patientvisitcode = '$res14visitcode' and patientcode = '$res14patientcode' group by servicesitemcode";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

	  	$num3 = mysqli_num_rows($exec3);

		while($res3 = mysqli_fetch_array($exec3))

		{

		$res3servicesitemname= $res3['servicesitemname'];

		$res3servicesitemrate= $res3['servicesitemrate'];

		$res3servicesitemcode = $res3['servicesitemcode'];

		$res3billdate= $res3['billdate'];

		$res3billnumber= $res3['billnumber'];

		

		$res3serviceqty= $res3['serviceqty'];

		

		

		$query2111 = "select * from billing_paynowservices where locationcode='$locationcode' and patientvisitcode='$res11visitcode' and patientcode='$res11patientcode' and servicesitemcode = '$res3servicesitemcode'";

		$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));

		$numrow2111 = mysqli_num_rows($exec2111);

		$res3servicesitemamount = $res3servicesitemrate*$res3serviceqty;

		$labsubtotal = $labsubtotal + $res3servicesitemamount;

    ?>

	

	<tr>

		<td width="82" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res3billdate; ?></td>

		<td width="85" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res3billnumber; ?></td>

		<td width="292"  align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res3servicesitemname; ?></td>

		<td width="80"align="center" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res3serviceqty; ?></td>

		<td width="69"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res3servicesitemrate; ?></td>

		<td width="125"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res3servicesitemamount,2,'.',''); ?></td>

	</tr>

	

	<?php  

	     }

		$query4 = "select * from billing_paynowpharmacy where locationcode='$locationcode' and patientvisitcode = '$res14visitcode' and patientcode = '$res14patientcode' ";
		
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	  	$num4 = mysqli_num_rows($exec4);

		while($res4 = mysqli_fetch_array($exec4))

		{

		$res4medicinename= $res4['medicinename'];

		$res4quantity= $res4['quantity'];

		$res4rate= $res4['rate'];

		$res4amount= $res4['amount'];

		$res4billdate= $res4['billdate'];

		$res4billnumber= $res4['billnumber'];

		$labsubtotal = $labsubtotal + $res4amount;

    ?>

	

	<tr>

		<td width="82" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res4billdate; ?></td>

		<td width="85" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res4billnumber; ?></td>

		<td width="292"  align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res4medicinename; ?></td>

		<td width="80"align="center" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res4quantity; ?></td>

		<td width="69"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res4rate; ?></td>

		<td width="125"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res4amount; ?></td>

	</tr>

	

	<?php  

	     }

		$query6 = "select * from billing_paynowreferal where locationcode='$locationcode' and patientvisitcode = '$res14visitcode' and patientcode = '$res14patientcode' ";

		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

	  	$num6 = mysqli_num_rows($exec6);

		while($res6 = mysqli_fetch_array($exec6))

		{

		$res6referalname= $res6['referalname'];

		$res6referalrate= $res6['referalrate'];

		$res6billdate= $res6['billdate'];

		$res6billnumber= $res6['billnumber'];

		$labsubtotal = $labsubtotal + $res6referalrate;

    ?>

	

	<tr>

		<td width="82" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res6billdate; ?></td>

		<td width="85" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res6billnumber; ?></td>

		<td width="292"  align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res6referalname; ?></td>

		<td width="80"align="center" valign="center" 

		bgcolor="#ffffff" class="bodytext31">1</td>

		<td width="69"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res6referalrate; ?></td>

		<td width="125"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res6referalrate; ?></td>

	</tr>

	

	<?php

		}

	}

	?>

    <?php

	$query134 = "select * from refund_paynowpharmacy where locationcode='$locationcode' and patientcode = '$patientcode' and patientvisitcode='$visitcode' ";

	$exec134 = mysqli_query($GLOBALS["___mysqli_ston"], $query134) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res134 = mysqli_fetch_array($exec134))

	 {

	$res134billnumber = $res134['billnumber'];

	$res134abitemrate = $res134['rate'];

	$res134amount = $res134['amount'];

	$res134qty = $res134['quantity'];

	$res134abitemname= $res134['medicinename'];

	$res134billdate= $res134['billdate'];

	$pharmrefundsubtotal = $pharmrefundsubtotal + $res134amount;

	?>

	<tr>

		<td width="82" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res134billdate; ?></td>

		<td width="85" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res134billnumber; ?></td>

		<td width="292"  align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res134abitemname; ?></td>

		<td width="80"align="center" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res134qty; ?></td>

		<td width="69"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res134abitemrate; ?></td>

		<td width="125"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31">-<?php echo $res134amount; ?></td>

	</tr>

  <?php

   }

  ?>

    <?php $labsubtotal = $labsubtotal - $pharmrefundsubtotal; ?>

  <?php

	$query13 = "select * from refund_paynowlab where locationcode='$locationcode' and patientcode = '$patientcode' and patientvisitcode='$visitcode' ";

	$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res13 = mysqli_fetch_array($exec13))

	 {

	$res13billnumber = $res13['billnumber'];

	$res13labitemrate = $res13['labitemrate'];

	$res13labitemname= $res13['labitemname'];

	$res13billdate= $res13['billdate'];

	$labrefundsubtotal = $labrefundsubtotal + $res13labitemrate;

	?>

	<tr>

		<td width="82" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res13billdate; ?></td>

		<td width="85" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res13billnumber; ?></td>

		<td width="292"  align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res13labitemname; ?></td>

		<td width="80"align="center" valign="center" 

		bgcolor="#ffffff" class="bodytext31">1</td>

		<td width="69"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res13labitemrate; ?></td>

		<td width="125"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31">-<?php echo $res13labitemrate; ?></td>

	</tr>

  <?php

   }

  ?>

    <?php $labsubtotal = $labsubtotal - $labrefundsubtotal; ?>

	

  <?php

	$query20 = "select * from refund_paynowradiology where locationcode='$locationcode' and patientcode = '$patientcode' and patientvisitcode='$visitcode' ";

	$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res20 = mysqli_fetch_array($exec20))

	 {

	$res20radiologyitemrate = $res20['radiologyitemrate'];

	$res20transactiondate= $res20['billdate'];

	$res20billnumber= $res20['billnumber'];

    $res20radiologyitemname =$res20['radiologyitemname'];

	$radiologyrefundsubtotal = $radiologyrefundsubtotal + $res20radiologyitemrate;

	?>

	<tr>

		<td width="82" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res20transactiondate; ?></td>

		<td width="85" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res20billnumber; ?></td>

		<td width="292"  align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res20radiologyitemname; ?></td>

		<td width="80"align="center" valign="center" 

		bgcolor="#ffffff" class="bodytext31">1</td>

		<td width="69"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res20radiologyitemrate; ?></td>

		<td width="125"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31">-<?php echo $res20radiologyitemrate; ?></td>

	</tr>

  <?php

   }

  ?>

    <?php $labsubtotal = $labsubtotal - $radiologyrefundsubtotal; ?>	

	

   <?php

	$query21 = "select * from refund_paynowservices where locationcode='$locationcode' and patientcode = '$patientcode' and patientvisitcode='$visitcode' ";

	$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res21 = mysqli_fetch_array($exec21))

	 {

	$res21servicesitemname= $res21['servicesitemname'];

	$res21servicesitemrate = $res21['servicesitemrate'];

	$res21billdate= $res21['billdate'];

	$res21billnumber= $res21['billnumber'];

	$res21serviceqty= $res21['servicequantity'];

	$servicesrefundsubtotal = $servicesrefundsubtotal + ($res21servicesitemrate*$res21serviceqty);

	?>

	<tr>

		<td width="82" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res21billdate; ?></td>

		<td width="85" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res21billnumber; ?></td>

		<td width="292"  align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res21servicesitemname; ?></td>

		<td width="80"align="center" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res21serviceqty;?></td>

		<td width="69"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res21servicesitemrate; ?></td>

		<td width="125"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31">-<?php echo $res21servicesitemrate*$res21serviceqty; ?></td>

	</tr>

  <?php

   }

  ?>

    <?php $labsubtotal = $labsubtotal - $servicesrefundsubtotal; ?>	

	

   <?php

	$query22 = "select * from refund_paynowreferal where locationcode='$locationcode' and patientcode = '$patientcode' and patientvisitcode='$visitcode' ";

	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res22 = mysqli_fetch_array($exec22))

	 {

	$res22referalnamee= $res22['referalname'];

	$res22referalrate = $res22['referalrate'];

	$res22billdate= $res22['billdate'];

	$res22billnumber= $res22['billnumber'];

	$referalrefundsubtotal = $referalrefundsubtotal + $res22referalrate;

	?>

	<tr> 

		<td width="82" align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res22billdate; ?></td>

		<td width="85" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res22billnumber; ?></td>

		<td width="292"  align="left" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res22referalnamee; ?></td>

		<td width="80"align="center" valign="center" 

		bgcolor="#ffffff" class="bodytext31">1</td>

		<td width="69"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31"><?php echo $res22referalrate; ?></td>

		<td width="125"  align="right" valign="center" 

		bgcolor="#ffffff" class="bodytext31">-<?php echo $res22referalrate; ?></td>

	</tr>

  <?php

   }

  ?>

    <?php $labsubtotal = $labsubtotal - $referalrefundsubtotal; ?>			





<tr>

<td width="82" align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext32">    <?php //echo $res18billingdatetime; ?></td>

<td width="85" align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext32">    <?php //echo $patientcode; ?></td>

<td width="292" align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext32">    <?php //echo 'Copay Amount'; ?></td>

<td width="80" align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext32"><?php //echo $res18quantity; ?></td>

<td width="69" align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><strong>Subtotal</strong></td>

<td width="125" align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($labsubtotal,2,'.',','); ?></strong></td>

</tr>

<?php $nettotal = $consultationsubtotal + $labsubtotal; ?>

<tr>

  <td colspan="6" align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext32">&nbsp;</td>

  </tr>

<?php 

	//$convertedwords = covert_currency_to_words($nettotal); 

?>

<tr>

  <td colspan="4" align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext32">&nbsp;</td>

  <td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><strong>NetTotal</strong></td>

  <td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($nettotal,2,'.',','); ?></strong></td>

</tr>



<tr>

  <td colspan="6" class="bodytext32">&nbsp;</td>

</tr>

<tr>

  <td colspan="6" class="bodytext32"><?php //echo $convertedwords; ?></td>

</tr>

<tr>

		<td colspan="6" class="bodytext32">&nbsp;</td>

	    </tr>





<tr>

  <td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><strong>Patient Sign: </strong></td>

  <td colspan="5" align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext32">&nbsp;</td>

  </tr>

<tr>

  <td colspan="6" align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext32">&nbsp;</td>

  </tr>

</table>	</td>

  </tr>

</table>



<?php

$content = ob_get_clean();

    // convert in PDF

    try

    {

        $html2pdf = new HTML2PDF('P', 'A4', 'en');

//      $html2pdf->setModeDebug();

        $html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('print_paynowsummary.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

	?>





  

	

				  



