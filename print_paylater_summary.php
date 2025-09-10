<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



    ob_start();

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





if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

//echo $billautonumber;



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





$query2 = "select * from master_transactionpaylater where billnumber = '$billautonumber'";

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

$res2username = strtoupper($res2username);

//$res2cashgiventocustomer = $res2['cashgiventocustomer'];

//$res2cashgivenbycustomer = $res2['cashgivenbycustomer'];



  

$query4 = "select * from billing_paylaterconsultation where billno = '$res2billnumber' and visitcode = '$res2visitcode'";

$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

$res4 = mysqli_fetch_array($exec4);

$res4totalamount = $res4['totalamount'];



$query5 = "select * from billing_paylaterpharmacy where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

$res5 = mysqli_fetch_array($exec5);

$res5amount = $res5['amount'];



$query8 = "select * from billing_paylaterlab where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

$res8 = mysqli_fetch_array($exec8);

$res8labitemrate = $res8['labitemrate'];



$query9 = "select * from billing_paylaterradiology where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

$res9 = mysqli_fetch_array($exec9);

$res9radiologyitemrate = $res9['radiologyitemrate'];



$query10 = "select * from billing_paylaterreferal where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10". mysqli_error($GLOBALS["___mysqli_ston"]));

$res10 = mysqli_fetch_array($exec10);

$res10referalrate = $res10['referalrate'];



$query11 = "select * from billing_paylaterservices where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11". mysqli_error($GLOBALS["___mysqli_ston"]));

$res11 = mysqli_fetch_array($exec11);

$res11servicesitemrate = $res11['servicesitemrate'];



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



?>





			<table width="760" border="0" cellpadding="0" cellspacing="0">

				<tr>

					<td width="486">

					

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

					?>						  </td>

					<td colspan="2" align="right" valign="center" 

					bgcolor="#ffffff" class="bodytext31">

					<?php

					echo '<strong>'.$res1companyname.'</strong>';

					echo '<br>'.$res1address1.' '.$res1area.' '.$res1city;

					echo '<br>'.$res1pincode;

					if($res1phonenumber1 != '')

					{

					echo '<br>Phone : '.$res1phonenumber1;

					}

					?></td>

				    <td width="17" align="right" valign="center" 

					bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

				</tr>

				

				<tr>

    <td>

	<strong><?php

	echo 'Name : '.$res2patientname.'&nbsp;';

	echo '<br>Reg No. : '.$res2patientcode;

	echo '<br>Visit No. : '.$res2visitcode;

	//echo '<br>Account : '.$res2accountname;

	?></strong>	</td>

	

    <td width="123" align="right">&nbsp;</td>

    <td width="134" align="left"><strong><?php

		echo 'Bill Number : '.$res2billnumber.'&nbsp;';

		echo '<br>Bill Date : '.$res2transactiondate;

		?></strong></td>

    <td align="right">&nbsp;</td>

			  </tr>

				<tr>

				  <td colspan="4">

				   <table width="95%" border="0" cellspacing="0" cellpadding="0">

		<tr>

			<td colspan="4">&nbsp;</td>

		</tr>

		<tr>

			<td colspan="4">

			<div align="center"><U>

			<strong><?php

			echo 'SUMMARY INVOICE';

			?></strong></U>&nbsp;    </div>			</td>

		</tr>

		

		<tr>

		  <td align="right">&nbsp;</td>

		  <td align="right">&nbsp;</td>

		  <td align="right">&nbsp;</td>

		  <td>&nbsp;</td>

		  </tr>

		<tr>

		  <td width="227" align="right">&nbsp;</td>

			<td width="134" align="left"><strong>Consultation's Fee:</strong></td>

			<td width="116" align="right"><?php echo number_format($res4totalamount,2,'.',','); ?></td>

			<td width="245">&nbsp;</td>

		</tr>

		<tr>

		  <td align="right">&nbsp;</td>

			<td align="left"><strong>Pharmacy:</strong></td>

			<td align="right"><?php echo number_format($res5amount,2,'.',','); ?></td>

			<td>&nbsp;</td>

		</tr>

		<tr>

		  <td align="right">&nbsp;</td>

			<td align="left"><strong>Laboratory:</strong></td>

			<td align="right"><?php echo number_format($res8labitemrate,2,'.',','); ?></td>

			<td>&nbsp;</td>

		</tr>

		<tr>

		  <td align="right">&nbsp;</td>

			<td align="left"><strong>Radiology:</strong></td>

			<td align="right"><?php echo number_format($res9radiologyitemrate,2,'.',','); ?></td>

			<td>&nbsp;</td>

		</tr>

		<tr>

		  <td align="right">&nbsp;</td>

			<td align="left"><strong>Referral:</strong></td>

			<td align="right"><?php echo number_format($res10referalrate,2,'.',','); ?></td>

			<td>&nbsp;</td>

		</tr>

		<?php 

		$total = $res4totalamount + $res5amount + $res8labitemrate + $res9radiologyitemrate + $res10referalrate;

		$amountdue = $total - $credit; 

		?>

		<tr>

		  <td align="right">&nbsp;</td>

			<td align="left"><strong>Total Bill Amount:</strong></td>

			<td align="right"><?php echo number_format($total,2,'.',','); ?></td>

			<td>&nbsp;</td>

		</tr>

		<tr>

		  <td align="right">&nbsp;</td>

			<td align="left"><strong>Credits:</strong></td>

			<td align="right"><?php echo number_format($credit,2,'.',','); ?></td>

			<td>&nbsp;</td>

		</tr>

		<tr>

		  <td align="right">&nbsp;</td>

			<td align="left"><strong>Amount Due:</strong></td>

			<td align="right"><?php echo number_format($amountdue,2,'.',','); ?></td>

			<td>&nbsp;</td>

		</tr>

		

		

		<tr>

		  <td align="right">&nbsp;</td>

		  <td align="right">&nbsp;</td>

		  <td align="left">&nbsp;</td>

		  <td>&nbsp;</td>

		  </tr>

		  <?php
$querya = "select accountname,transactionamount from master_transactionpaylater where visitcode='$res2visitcode' and patientcode='$res2patientcode'";
$execa = mysqli_query($GLOBALS["___mysqli_ston"], $querya) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
$numrowa = mysqli_num_rows($execa);
if($numrowa>1){
?>
<tr>
	<td colspan="3"><strong>Receivable Accounts : </strong></td>
</tr>
<?php
while($resa = mysqli_fetch_array($execa)){
?>
<tr>
<td colspan="2"><?= $resa['accountname'] ?></td>
<td align="right"><?= number_format($resa['transactionamount'],2) ?></td>
</tr>
<?php
}
}
?>
		<tr>

		  <td align="right">&nbsp;</td>

		  <td align="right">&nbsp;</td>

		  <td align="left">&nbsp;</td>

		  <td>&nbsp;</td>

		  </tr>

		<tr>

		  <td align="left"><strong>Patient Sign: </strong></td>

		<td align="left">&nbsp;</td>

			<td align="right">&nbsp;</td>

			<td align="left"><strong>Served By : <?php echo strtoupper($res2username).' '; ?><?php echo $res2transactiondate; ?> <?php echo $res2transactiontime[0]; ?>:<?php echo $res2transactiontime[1]; ?></strong></td>

		</tr>

		</table>				  </td>

			  </tr>

             </table>

					

		    <?php	



    $content = ob_get_clean();



    // convert in PDF

    require_once('html2pdf/html2pdf.class.php');

    try

    {

        $html2pdf = new HTML2PDF('P', 'A4', 'en');

//      $html2pdf->setModeDebug();

        $html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('print_paylater.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

	?>

