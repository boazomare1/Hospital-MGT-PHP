<?php
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
$res11patientcode = $patientcode;
$res11visitcode = $visitcode;

?>
<?php 
	$query11 = "select * from master_billing where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode='$visitcode' ";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num11= mysqli_num_rows($exec11);
	while($res11 = mysqli_fetch_array($exec11))
	 {
	$res11patientfirstname = $res11['patientfirstname'];
	$res11patientcode = $patientcode;
	$res11visitcode = $visitcode;
	$res11billnumber = $res11['billnumber'];
	$res11consultationfees = $res11['consultationfees'];
	$res11registrationfees = $res11['registrationfees'];
	$res11subtotalamount = $res11['subtotalamount'];
	$res11billingdatetime = $res11['billingdatetime'];
	$consultationsubtotal = $consultationsubtotal + $res11subtotalamount;
	?>  

<?php

	
	}
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
	
	}
	?>
	<?php $consultationsubtotal = $consultationsubtotal - $consultationrefundsubtotal; ?>
	
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
		}
	?>
	<?php $labsubtotal = $labsubtotal - $referalrefundsubtotal; ?>
	<?php $nettotal = $consultationsubtotal + $labsubtotal; ?>
