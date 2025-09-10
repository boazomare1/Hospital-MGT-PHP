<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];	
$companyname = $_SESSION['companyname'];

if (isset($_REQUEST["todaytodate"])) { $todaytodate = $_REQUEST["todaytodate"]; } else { $todaytodate = ""; }
if (isset($_REQUEST["todayfromdate"])) { $todayfromdate = $_REQUEST["todayfromdate"]; } else { $todayfromdate = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode  = $_REQUEST["locationcode"]; } else { $locationcode  = ""; }

$query1112 = "select * from master_location where locationcode = '$locationcode' and status<>'delete'";
$exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1112 = mysqli_fetch_array($exec1112))
{
 $locationname = $res1112["locationname"];    
 $locationcode = $res1112["locationcode"];
}
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Front Desk"'.$todayfromdate.'"_To_"'.$todaytodate.'"Location"'.$locationname.'".xls');
header('Cache-Control: max-age=80');


?>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="50%" align="left" border="1">
     <tbody>
        <tr> <td colspan="6" align="center"><strong><u><h3>Front Desk REPORT</h3></u></strong></td></tr> 
        <tr ><td colspan="6" align="center"><strong>Date From:    <?php echo date('d/m/Y',strtotime($todayfromdate));?>   To:  <?php echo date('d/m/Y',strtotime($todaytodate));?></strong></td></tr>
        <tbody>
		
		<tr>
		<td colspan="6">
		<table width="" cellspacing="0" cellpadding="4" border="1" style="font-size:medium;">
		<tr>
		<td  colspan="6" align="middle"  style="color:blue"><strong>Collection Summary</strong></td>
		</tr>
		<?php
		$snocount = 0;
		$colorloopcount =0;
		$transactiondatefrom = $todayfromdate;
		$transactiondateto = $todaytodate;
		//   echo "hii".$locationcode1;
		   $query23 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where  transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode' "; 
		  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res23 = mysqli_fetch_array($exec23);
		  
     	  $res2cashamount1 = $res23['cashamount1'];
		  $res2onlineamount1 = $res23['onlineamount1'];
		  $res2creditamount1 = $res23['creditamount1'];
		  $res2chequeamount1 = $res23['chequeamount1'];
		  $res2cardamount1 = $res23['cardamount1'];
		  
		  // echo  "hi".$res23['creditamount1'];
	      $query3 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionexternal where  transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode' "; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  
     	  $res3cashamount1 = $res3['cashamount1'];
		  $res3onlineamount1 = $res3['onlineamount1'];
		  $res3creditamount1 = $res3['creditamount1'];
		  $res3chequeamount1 = $res3['chequeamount1'];
		  $res3cardamount1 = $res3['cardamount1'];
		  
		  
		  $query4 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_billing where  billingdatetime between '$transactiondatefrom' and '$transactiondateto' "; 
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  
     	  $res4cashamount1 = $res4['cashamount1'];
		  $res4onlineamount1 = $res4['onlineamount1'];
		  $res4creditamount1 = $res4['creditamount1'];
		  $res4chequeamount1 = $res4['chequeamount1'];
		  $res4cardamount1 = $res4['cardamount1'];
		  
		  $query5 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from refund_paynow where  transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode'"; 
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res5 = mysqli_fetch_array($exec5);
		  
     	  $res5cashamount1 = $res5['cashamount1'];
		  $res5onlineamount1 = $res5['onlineamount1'];
		  $res5creditamount1 = $res5['creditamount1'];
		  $res5chequeamount1 = $res5['chequeamount1'];
		  $res5cardamount1 = $res5['cardamount1'];
		  
		  $query54 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1  from deposit_refund where recorddate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode' "; 
		  $exec54 = mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res54 = mysqli_fetch_array($exec54))
{
		
			  $res54cashamount1 = $res54['cashamount1'];
		  $res54onlineamount1 = $res54['onlineamount1'];
		  $res54creditamount1 = $res54['creditamount1'];
		  $res54chequeamount1 = $res54['chequeamount1'];
		  $res54cardamount1 = $res54['cardamount1'];
			
			
			}  //refund adv
		  
		  $query6 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionadvancedeposit where  transactiondate between '$transactiondatefrom' and '$transactiondateto' "; 
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
		  
     	  $res6cashamount1 = $res6['cashamount1'];
		  $res6onlineamount1 = $res6['onlineamount1'];
		  $res6creditamount1 = $res6['creditamount1'];
		  $res6chequeamount1 = $res6['chequeamount1'];
		  $res6cardamount1 = $res6['cardamount1'];
		  $query7 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipdeposit where  transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode' "; 
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
		  
     	  $res7cashamount1 = $res7['cashamount1'];
		  $res7onlineamount1 = $res7['onlineamount1'];
		  $res7creditamount1 = $res7['creditamount1'];
		  $res7chequeamount1 = $res7['chequeamount1'];
		  $res7cardamount1 = $res7['cardamount1'];
		  
		  $query8 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(mpesaamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionip where  transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode'"; 
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res8 = mysqli_fetch_array($exec8);
		  
     	  $res8cashamount1 = $res8['cashamount1'];
		  $res8onlineamount1 = $res8['onlineamount1'];
		  $res8creditamount1 = $res8['creditamount1'];
		  $res8chequeamount1 = $res8['chequeamount1'];
		  $res8cardamount1 = $res8['cardamount1'];
		  
    	  $query9 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipcreditapproved where  transactiondate between '$transactiondatefrom' and '$transactiondateto' and locationcode='$locationcode' "; 
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res9 = mysqli_fetch_array($exec9);
		  
     	  $res9cashamount1 = $res9['cashamount1'];
		  $res9onlineamount1 = $res9['onlineamount1'];
		  $res9creditamount1 = $res9['creditamount1'];
		  $res9chequeamount1 = $res9['chequeamount1'];
		  $res9cardamount1 = $res9['cardamount1'];
		  $query10 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from receiptsub_details where  transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode'"; 
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res10 = mysqli_fetch_array($exec10);
		  
     	  $res10cashamount1 = $res10['cashamount1'];
		  $res10onlineamount1 = $res10['onlineamount1'];
		  $res10creditamount1 = $res10['creditamount1'];
		  $res10chequeamount1 = $res10['chequeamount1'];
		  $res10cardamount1 = $res10['cardamount1'];
			$query11 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaylater where docno like 'AR-%' and transactionstatus like 'onaccount' and transactiondate between '$transactiondatefrom' and '$transactiondateto'  and locationcode='$locationcode' "; 
		  $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res11 = mysqli_fetch_array($exec11);
		  
     	   $res11cashamount1 = $res11['cashamount1'];
		  $res11onlineamount1 = $res11['onlineamount1'];
		  $res11creditamount1 = $res11['creditamount1'];
		  $res11chequeamount1 = $res11['chequeamount1'];
		  $res11cardamount1 = $res11['cardamount1'];

		 $cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res6cashamount1 + $res7cashamount1 + $res8cashamount1 + $res9cashamount1 + $res10cashamount1+ $res11cashamount1;
		  $cardamount = $res2cardamount1 + $res3cardamount1 + $res4cardamount1 + $res6cardamount1 + $res7cardamount1 + $res8cardamount1 + $res9cardamount1 + $res10cardamount1+ $res11cardamount1;
		  $chequeamount = $res2chequeamount1 + $res3chequeamount1 + $res4chequeamount1 + $res6chequeamount1 + $res7chequeamount1 + $res8chequeamount1 + $res9chequeamount1 + $res10chequeamount1+ $res11chequeamount1;
		  $onlineamount = $res2onlineamount1 + $res3onlineamount1 + $res4onlineamount1 + $res6onlineamount1 + $res7onlineamount1 + $res8onlineamount1 + $res9onlineamount1 + $res10onlineamount1+ $res11onlineamount1;
		  $creditamount = $res2creditamount1 + $res3creditamount1 + $res4creditamount1 + $res6creditamount1 + $res7creditamount1 + $res8creditamount1 + $res9creditamount1 + $res10creditamount1+ $res11creditamount1;
		  
		  $cashamount1 = $cashamount - $res5cashamount1 - $res54cashamount1;
		  $cardamount1 = $cardamount - $res5cardamount1 - $res54cardamount1;
		  $chequeamount1 = $chequeamount - $res5chequeamount1 - $res54chequeamount1;
		  $onlineamount1 = $onlineamount - $res5onlineamount1 - $res54onlineamount1;
		  $creditamount1 = $creditamount - $res5creditamount1 - $res54creditamount1;
		  
		  $total = $cashamount1 + $onlineamount1 + $chequeamount1 + $cardamount1 + $creditamount1;
		  
			?>
			<tr>

				<td width="" align="left" valign="left"  bgcolor="#ffffff" ><strong>Cash</strong></td>
				<td width="" align="left" valign="left"  bgcolor="#ffffff" ><strong>Card</strong></td>
				<td width="" align="left" valign="left"  bgcolor="#ffffff" ><strong>Cheque</strong></td>
				<td width="" align="left" valign="left"  bgcolor="#ffffff" ><strong>Online</strong></td>
				<td width="" align="left" valign="left"  bgcolor="#ffffff" ><strong>Mobile Money</strong></td>
				<td width="" align="left" valign="left"  bgcolor="#ffffff" ><strong>Total</strong></td>

			</tr>
			
			<tr>

				<td  valign="center"  align="right"><div ><?php echo number_format($cashamount1,2,'.',','); ?>  </td>
				<td  valign="center"  align="right"><div ><?php echo number_format($cardamount1,2,'.',','); ?>  </td>
				<td  valign="center"  align="right"><?php echo number_format($chequeamount1,2,'.',','); ?></td>
				<td  valign="center"  align="right"><div align="right"><?php echo number_format($onlineamount1,2,'.',','); ?></td>
				<td  valign="center"  align="right"><div align="right"><?php echo number_format($creditamount1,2,'.',','); ?></td>
				<td  valign="center"  align="right"><div align="right"><?php echo number_format($total,2,'.',','); ?></td>

			</tr>
			
			<tr>
				<td colspan="6">&nbsp;</td>
			</tr>
			<?php
			$drresult = array();
			$j = 0;
			$crresult = array();
			$querycr1 = "SELECT SUM(`consultation`) as income FROM `billing_consultation` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowlab` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowpharmacy` WHERE billdate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowradiology` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowservices` WHERE billdate  between '$todayfromdate' and '$todaytodate' and wellnessitem <> 1 and locationcode='$locationcode'
			UNION ALL SELECT SUM(`cashamount`) as income FROM `billing_paynowreferal` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_referal` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_externallab` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`amount`) as income FROM `billing_externalpharmacy` WHERE billdate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_externalradiology` WHERE billdate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL SELECT SUM(`servicesitemrate`) as income FROM `billing_externalservices` WHERE billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$j = $j+1;
			//print_r($resdr1);
			$crresult[$j] = $rescr1['income'];
			//$paylater = $result[$i];
			}	
			//echo "total ".array_sum($crresult)." and ".array_sum($drresult);
			 $totalopcash = array_sum($crresult) - array_sum($drresult);
			 ?>
			<tr bgcolor="">
				<td colspan="4" align="middle" style="color: blue;"><strong>Cash Bills</strong></td>
			</tr>
			<tr bgcolor="">
				<td colspan="2"><strong>OP Cash Bills</strong></td>
				<td colspan="2" align="right"><?php echo number_format($totalopcash,2);?></td>
			</tr>
			<tr >
				<td colspan="4">&nbsp;</td>
			</tr>
			<?php
			$creditsales="select sum(paylateramt) as paylatertotal, sum(ipcreditamount) as ipcredittotal from(
			select sum(totalamount) as paylateramt,'0' as ipcreditamount from billing_paylater where billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'
			UNION ALL 	select '0' as paylateramt,sum(totalamount) as ipcreditamount from billing_ip where billdate  between '$todayfromdate' and '$todaytodate'	and locationcode='$locationcode'
			UNION ALL 	select '0' as paylateramt,sum(totalamount) as ipcreditamount from billing_ipcreditapproved where billdate  between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode')  u  	";
			$creditsalesex = mysqli_query($GLOBALS["___mysqli_ston"], $creditsales) or die ("Error in creditsales".mysqli_error($GLOBALS["___mysqli_ston"]));
			$creditres = mysqli_fetch_array($creditsalesex);
			$transactionamount1 = $creditres["paylatertotal"];
			$transactionamount = $creditres["ipcredittotal"];
			//$transactionamount1=$transamt;
			//$transactionamount+=$transamt;
			$credittotal=$transactionamount+$transactionamount1;
			?>
			<tr bgcolor="">
				<td colspan="4" align="middle" style="color: blue;"><strong>Current Credit Sales</strong></td>
			</tr>
			<tr bgcolor="">
				<td colspan="2"><strong>OP Credit Bills</strong></td>
				<td colspan="2" align="right"><?php echo number_format($transactionamount1,2); ?></td>
			</tr>
			<tr  bgcolor="">
				<td colspan="2"><strong>IP Credit Bills</strong></td>
				<td colspan="2" align="right"><?php echo number_format($transactionamount,2); ?> </td>
			</tr>
			<tr bgcolor="">
				<td colspan="2"><strong>Total</strong></td>
				<td colspan="2" align="right"><?php echo number_format($credittotal,2); ?></td>
			</tr>
			
			<tr >
				<td colspan="4">&nbsp;</td>
			</tr>
			<?php
		$registeredpatient=0;
		$hospitalpatient=0;
		$walkin=0;
		$querytotal="select count(customercode) as customercode from master_customer where registrationdate between '$todayfromdate' and '$todaytodate'";
		$totex=mysqli_query($GLOBALS["___mysqli_ston"], $querytotal);
		$regpatient=mysqli_fetch_array($totex);
		$registeredpatient=$regpatient['customercode'];
		$querymaster="select visitcode from master_visitentry where consultationdate between '$todayfromdate' and '$todaytodate'";
		$masterex=mysqli_query($GLOBALS["___mysqli_ston"], $querymaster);
		$numberofrow=mysqli_num_rows($masterex);
		$querymasterip="select visitcode from master_ipvisitentry where consultationdate between '$todayfromdate' and '$todaytodate'";
		$masterexip=mysqli_query($GLOBALS["___mysqli_ston"], $querymasterip);
		$numberofrowip=mysqli_num_rows($masterexip);
	?>
			<tr bgcolor="">
				<td colspan="4" align="middle" style="color: blue;"><strong>Current Statistics:</strong></td>
			</tr>
			<tr bgcolor="">
				<td colspan="2"><strong>New Registrations</strong></td>
				<td colspan="2" align="right"><?php echo number_format($registeredpatient,2); ?></td>
			</tr>
			<tr  bgcolor="">
				<td colspan="2"><strong>OP VIsits</strong></td>
				<td colspan="2" align="right"><?php echo number_format($numberofrow,2); ?> </td>
			</tr>
			<tr bgcolor="">
				<td colspan="2"><strong>IP Visits</strong></td>
				<td colspan="2" align="right"><?php echo number_format($numberofrowip,2); ?></td>
			</tr>
			
			
			 <tr><td>&nbsp;</td></tr>
			 
			 
			 
			 
		</table>
		</td>
		</tr>
  <tr>
    <td colspan="6"><table width="" cellspacing="0" cellpadding="4" border="1" style="font-size:medium;">
      <tr >
	  <td colspan="20" align="middle" style="color: blue;"><strong>OP Departmental Statisctics</strong></td>
      </tr>
	  <tr>
	  <td ><strong>Deaprtment</strong></td>
	  <td ><strong>New Visits</strong></td>
	  <td ><strong>Revisits</strong></td>
	  <td ><strong>Total Visits</strong></td>
	  <td ><strong>Triaged Patients</strong></td>
	  <td ><strong>Consulted Patients</strong></td>
	  <td ><strong>Lab Requests</strong></td>
	  <td ><strong>Lab Samples</strong></td>
	  <td ><strong>Lab Refunds</strong></td>
	  <td ><strong>Radiology Requests</strong></td>
	  <td ><strong>Radiology Processed</strong></td>
	  <td ><strong>Radiology Refunds</strong></td>
	  <td ><strong>Service Requests</strong></td>
	  <td ><strong>Service Processed</strong></td>
	  <td ><strong>Service Refunds</strong></td>
	  <td ><strong>Medicine Requests</strong></td>
	  <td ><strong>Medicine Issued</strong></td>
	  <td ><strong>Medicine Returns</strong></td>
	  <td ><strong>Realized Revenue</strong></td>
	  <td ><strong>Unrealized Revenue</strong></td>
      </tr>
	  <?php
		$snocount = 0;
		$colorloopcount = 0;
		$totalvisit =0;
		$totalvisit1 =0;
		$totaltriage = 0;
		$totalconsult = 0;
		$totallab = 0;
		$totallabsample = 0;
		$totallabrefund = 0;
		$totalrad = 0;
		$totalradsample = 0;
		$totalradrefund = 0;
		$totalser = 0;
		$totalsersample = 0;
		$totalserrefund = 0;
		$totalmed = 0;
		$totalmedissue = 0;
		$totalmedreturn = 0;
		$totalrevenue=0;
		$totalunrealized=0;
		$locationcode = 'LTC-1';
		$qrydpt = "select auto_number,department from master_department where recordstatus <> 'deleted'";
		$execdpt = mysqli_query($GLOBALS["___mysqli_ston"], $qrydpt) or die("Error in qrydpt ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdpt=mysqli_fetch_array($execdpt))
		{
		$dpt = $resdpt['auto_number'];
		$dptname =  $resdpt['department'];
		$newwalkin="select patientcode from master_visitentry where consultationdate between '$todayfromdate' and '$todaytodate' and department ='$dpt'";
		$walkex=mysqli_query($GLOBALS["___mysqli_ston"], $newwalkin);
		$walkpatient=0;
		$walkpatient1=0;
		$dptrevenue =0;
		$dptunrealized =0;
		while($totwalk=mysqli_fetch_array($walkex))
		{
			$newwalkcode=$totwalk['patientcode'];
			$querywalk="select count(patientcode) as totalwalk from master_visitentry where patientcode='$newwalkcode'";
			$querywalkex=mysqli_query($GLOBALS["___mysqli_ston"], $querywalk);
			$reswalkt=mysqli_fetch_array($querywalkex);
			$walkcount=$reswalkt['totalwalk'];
			if($walkcount>1)
			{
				$walkpatient+=1;
			}
			else if($walkcount==1)
			{
				$walkpatient1+=1;
			}
			}
			$qrytriage = "select count(auto_number) as triage from master_triage where department like '$dptname' and date(consultationdate) between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$qrytriageex=mysqli_query($GLOBALS["___mysqli_ston"], $qrytriage);
			$restriage=mysqli_fetch_array($qrytriageex);
			$triage = $restriage['triage'];
			$totaltriage += $triage;
			$qryconsult = "select count(DISTINCT patientvisitcode) as consult from master_consultation where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and recorddate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$qryconsultex=mysqli_query($GLOBALS["___mysqli_ston"], $qryconsult) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
			$resconsult=mysqli_fetch_array($qryconsultex);
			$consult = $resconsult['consult'];
			$totalconsult += $consult;
			$qrylab = "select count(auto_number) as todaylab from consultation_lab where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$qrylabex=mysqli_query($GLOBALS["___mysqli_ston"], $qrylab);
			$reslab=mysqli_fetch_array($qrylabex);
			$todaylab = $reslab['todaylab'];
			$totallab += $todaylab;
			$qrylabsample = "select count(auto_number) as labsample from consultation_lab where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and labsamplecoll like 'completed' and labrefund <> 'refund' and locationcode='$locationcode'";
			$qrylabsampleex=mysqli_query($GLOBALS["___mysqli_ston"], $qrylabsample);
			$reslabsample=mysqli_fetch_array($qrylabsampleex);
			$labsample = $reslabsample['labsample'];
			$totallabsample += $labsample;
			$qrylabrefund = "select count(auto_number) as labrefund from consultation_lab where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and labrefund like 'refund' and locationcode='$locationcode'";
			$qrylabrefundex=mysqli_query($GLOBALS["___mysqli_ston"], $qrylabrefund);
			$reslabrefund=mysqli_fetch_array($qrylabrefundex);
			$labrefund = $reslabrefund['labrefund'];
			$totallabrefund += $labrefund;
			$qryrad = "select count(auto_number) as todayrad from consultation_radiology where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$qryradex=mysqli_query($GLOBALS["___mysqli_ston"], $qryrad) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resrad=mysqli_fetch_array($qryradex);
			$todayrad = $resrad['todayrad'];
			$totalrad += $todayrad;
			$qryradsample = "select count(auto_number) as radsample from consultation_radiology where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and prepstatus like 'completed' and radiologyrefund <> 'refund' and locationcode='$locationcode'";
			$qryradsampleex=mysqli_query($GLOBALS["___mysqli_ston"], $qryradsample);
			$resradsample=mysqli_fetch_array($qryradsampleex);
			$radsample = $resradsample['radsample'];
			$totalradsample += $radsample;
			$qryradrefund = "select count(auto_number) as radrefund from consultation_radiology where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and radiologyrefund like 'refund' and locationcode='$locationcode'";
			$qryradrefundex=mysqli_query($GLOBALS["___mysqli_ston"], $qryradrefund);
			$resradrefund=mysqli_fetch_array($qryradrefundex);
			$radrefund = $resradrefund['radrefund'];
			$totalradrefund += $radrefund;
			$qryser = "select count(auto_number) as todayser from consultation_services where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and wellnessitem <> 1 and locationcode='$locationcode' ";
			$qryserex=mysqli_query($GLOBALS["___mysqli_ston"], $qryser) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resrad=mysqli_fetch_array($qryserex);
			$todayser = $resrad['todayser'];
			$totalser += $todayser;
			$qrysersample = "select count(auto_number) as sersample from consultation_services where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and process like 'completed' and servicerefund <> 'refund' and wellnessitem <> 1 and locationcode='$locationcode'";
			$qrysersampleex=mysqli_query($GLOBALS["___mysqli_ston"], $qrysersample);
			$ressersample=mysqli_fetch_array($qrysersampleex);
			$sersample = $ressersample['sersample'];
			$totalsersample += $sersample;
			$qryserrefund = "select count(auto_number) as serrefund from consultation_services where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and consultationdate between '$todayfromdate' and '$todaytodate' and servicerefund like 'refund' and wellnessitem <> 1 and locationcode='$locationcode'";
			$qryserrefundex=mysqli_query($GLOBALS["___mysqli_ston"], $qryserrefund);
			$resserrefund=mysqli_fetch_array($qryserrefundex);
			$serrefund = $resserrefund['serrefund'];
			$totalserrefund += $serrefund;
			$qrymed = "select count(auto_number) as todaymed from master_consultationpharm where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and recorddate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$qrymedex=mysqli_query($GLOBALS["___mysqli_ston"], $qrymed) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resmed=mysqli_fetch_array($qrymedex);
			$todaymed = $resmed['todaymed'];
			$totalmed += $todaymed;
			$qrymedissue = "select count(auto_number) as medissue from master_consultationpharm where patientvisitcode in (select visitcode from master_visitentry where department ='$dpt') and recorddate between '$todayfromdate' and '$todaytodate' and medicineissue like 'completed' and locationcode='$locationcode'";
			$qrymedissueex=mysqli_query($GLOBALS["___mysqli_ston"], $qrymedissue);
			$resmedissue=mysqli_fetch_array($qrymedissueex);
			$medissue = $resmedissue['medissue'];
			$totalmedissue += $medissue;
			$qrymedreturn = "select count(auto_number) as medreturn from pharmacysalesreturn_details where visitcode in (select visitcode from master_visitentry where department ='$dpt') and entrydate between '$todayfromdate' and '$todaytodate' and locationcode='$locationcode'";
			$qrymedreturnex=mysqli_query($GLOBALS["___mysqli_ston"], $qrymedreturn);
			$resmedreturn=mysqli_fetch_array($qrymedreturnex);
			$medreturn = $resmedreturn['medreturn'];
			$totalmedreturn += $medreturn;
			//revenue
			$query1 = "select sum(consultation) as billamount1 from billing_consultation where  locationcode='$locationcode' and  billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
			$query1 = "select sum(fxamount) as billamount1 from billing_paylaterconsultation where locationcode='$locationcode' and  billdate between '$todayfromdate' and '$todaytodate' and visitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res2consultationamount = $res1['billamount1'];
			
			// this query for pharmacy
		    $query8 = "select sum(fxamount) as amount1 from billing_paylaterpharmacy where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt')";
		 	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8pharmacyitemrate = $res8['amount1'];
			
			$query9 = "select sum(fxamount) as amount1 from billing_paynowpharmacy where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
		    $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$res9pharmacyitemrate = $res9['amount1'];
			
			$query17 = "select sum(amount) as amount1 from billing_externalpharmacy where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$res17pharmacyitemrate = $res17['amount1'];
			  
			//this query for laboratry
			$query2 = "select sum(fxamount) as labitemrate1 from billing_paylaterlab where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$res2labitemrate = $res2['labitemrate1'];
			
			$query3 = "select sum(fxamount) as labitemrate1 from billing_paynowlab where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3labitemrate = $res3['labitemrate1'];
			
			$query14 = "select sum(labitemrate) as labitemrate1 from billing_externallab where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res14 = mysqli_fetch_array($exec14);
			$res14labitemrate = $res14['labitemrate1'];
			
			$totallabitemrate = $res2labitemrate + $res3labitemrate + $res14labitemrate;
			
			
			//this query for radiology
			$query4 = "select sum(fxamount) as radiologyitemrate1 from billing_paylaterradiology where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4radiologyitemrate = $res4['radiologyitemrate1'];
			
			$query5 = "select sum(fxamount) as radiologyitemrate1 from billing_paynowradiology where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5radiologyitemrate = $res5['radiologyitemrate1'];
			
			$query15 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res15 = mysqli_fetch_array($exec15);
			$res15radiologyitemrate = $res15['radiologyitemrate1'];
			
			$totalradiologyitemrate = $res4radiologyitemrate + $res5radiologyitemrate + $res15radiologyitemrate; 
			
			//this query for service
			$query6 = "select sum(fxamount) as servicesitemrate1 from billing_paylaterservices where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt' and wellnessitem <> 1) and locationcode='$locationcode'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6servicesitemrate = $res6['servicesitemrate1'];
			
			$query7 = "select sum(fxamount) as servicesitemrate2 from billing_paynowservices where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt' and wellnessitem <> 1) and locationcode='$locationcode'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7servicesitemrate = $res7['servicesitemrate2'];
			
			$query16 = "select sum(servicesitemrate) as servicesitemrate3 from billing_externalservices where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res16 = mysqli_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate3'];
			
			$totalservicesitemrate = $res6servicesitemrate + $res7servicesitemrate + $res16servicesitemrate ;
			
			$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res10 = mysqli_fetch_array($exec10);
			$res10referalitemrate = $res10['referalrate1'];
			
			$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11referalitemrate = $res11['referalrate1']; 
			
			//this query for refund consultation
			
			$query12 = "select sum(consultation) as consultation1 from refund_consultation where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate'  and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res12refundconsultation = $res12['consultation1'];
			
			//this query for refund pharmacy
			
			$query21 = "select sum(amount)as amount1 from refund_paylaterpharmacy where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21) ;
			$res21refundlabitemrate = $res21['amount1'];
			$query22 = "select sum(amount)as amount1 from refund_paynowpharmacy where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundlabitemrate = $res22['amount1'];
			$totalrefundpharmacy = $res22refundlabitemrate + $res21refundlabitemrate;
			
			//this query for refund laboratory
			
			$query19 = "select sum(labitemrate)as labitemrate1 from refund_paylaterlab where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res19 = mysqli_fetch_array($exec19) ;
			$res19refundlabitemrate = $res19['labitemrate1'];
			$query20 = "select sum(labitemrate)as labitemrate1 from refund_paynowlab where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res20 = mysqli_fetch_array($exec20) ;
			$res20refundlabitemrate = $res20['labitemrate1'];
			$totalrefundlab = $res20refundlabitemrate + $res19refundlabitemrate;
			
			//this query for refund radiology
			
			$query22 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paylaterradiology where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundradioitemrate = $res22['radiologyitemrate1'];
			$query23 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23) ;
			$res23refundradioitemrate = $res23['radiologyitemrate1'];
			$totalrefundradio = $res23refundradioitemrate + $res22refundradioitemrate;
			
			//this query for refund service
			
			$query24 = "select sum(amount)as servicesitemrate1 from refund_paylaterservices where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec24= mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res24 = mysqli_fetch_array($exec24) ;
			$res24refundserviceitemrate = $res24['servicesitemrate1'];
			$query25 = "select sum(servicetotal)as servicesitemrate1 from refund_paynowservices where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25) ;
			$res25refundserviceitemrate = $res25['servicesitemrate1'];
			$totalrefundservice = $res25refundserviceitemrate + $res24refundserviceitemrate;
			
			//this query for refund referal
			
			$query26 = "select sum(referalrate)as referalrate1 from refund_paylaterreferal where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec26= mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res26 = mysqli_fetch_array($exec26) ;
			$res26refundreferalitemrate = $res26['referalrate1'];
			$query27 = "select sum(referalrate)as referalrate1 from refund_paynowreferal where locationcode='$locationcode' and billdate between '$todayfromdate' and '$todaytodate' and patientvisitcode in (select visitcode from master_visitentry where department like '$dpt') and locationcode='$locationcode'";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res27 = mysqli_fetch_array($exec27) ;
			$res27refundreferalitemrate = $res27['referalrate1'];
			$totalrefundreferal = $res27refundreferalitemrate + $res26refundreferalitemrate;
							  
			  //ENDS
			  //for cash total
			  $cashtotal1=$res1consultationamount+$res9pharmacyitemrate+$res3labitemrate+$res5radiologyitemrate+$res7servicesitemrate+$res11referalitemrate;
			  
			  //for credit total
			  $credittotal1=$res2consultationamount+$res8pharmacyitemrate+$res2labitemrate+$res4radiologyitemrate+$res6servicesitemrate+$res10referalitemrate;
			  //for external total
			 
			  //for refund total
			  $refundtotal1=$res12refundconsultation+$totalrefundpharmacy+$totalrefundlab+$totalrefundradio+$totalrefundservice+$totalrefundreferal;
			  $dptrevenue=$cashtotal1+$credittotal1-$refundtotal1;
			$totalrevenue +=$dptrevenue;
			//revenue end
			
			//unrealized
			$totalpharmacysalesreturn =0;
			$overaltotalrefund =0;
			$query2 = "select patientcode,visitcode,patientfullname,consultationdate,accountfullname,subtype,planname,planpercentage from master_visitentry where billtype='PAY LATER' and overallpayment='' and consultationdate between '$todayfromdate' and '$todaytodate' AND visitcode NOT IN (SELECT visitcode FROM billing_paylater) AND department like '$dpt' and locationcode='$locationcode' order by accountfullname desc ";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2un".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2patientfullname = $res2['patientfullname'];
		  $res2registrationdate = $res2['consultationdate'];
		  $res2accountname = $res2['accountfullname'];
		  $subtype = $res2['subtype'];
		  $plannumber = $res2['planname'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			$planpercentage=$res2['planpercentage'];
			//$copay=($consultationfee/100)*$planpercentage;
			
		  
		  $Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select subtype,planname  from master_customer where customercode='$res2patientcode'");
			$execlab=mysqli_fetch_array($Querylab);
			$patientsubtype=$execlab['subtype'];
			$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
			$execsubtype=mysqli_fetch_array($querysubtype);
			$patientsubtype1=$execsubtype['subtype'];
			$patientsubtypeano=$execsubtype['auto_number'];
			$patientplan=$execlab['planname'];
			$currency=$execsubtype['currency'];
			$fxrate=$execsubtype['fxrate'];
			if($currency=='')
			{
				$currency='UGX';
			}
			$labtemplate = $execsubtype['labtemplate'];
			if($labtemplate == '') { $labtemplate = 'master_lab'; }
			$radtemplate = $execsubtype['radtemplate'];
			if($radtemplate == '') { $radtemplate = 'master_radiology'; }
			$sertemplate = $execsubtype['sertemplate'];
			if($sertemplate == '') { $sertemplate = 'master_services'; }
		  
		  $res3labitemrate = 0;
		  $query3 = "select labitemcode from consultation_lab where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$todayfromdate' and '$todaytodate'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res3 = mysqli_fetch_array($exec3))
		  {
		  		$labcode = $res3['labitemcode']; 
				$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
				$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resfx = mysqli_fetch_array($execfx);
				$labrate=$resfx['rateperunit'] * $fxrate;
				if(($planpercentage!=0.00)&&($planforall=='yes'))
			  	{ 
					$labrate = $labrate - ($labrate/100)*$planpercentage;
				}
				$res3labitemrate = $res3labitemrate + $labrate;
		  }
		  
		  $res4servicesitemrate = 0;
		  $query4 = "select servicesitemcode,serviceqty,refundquantity from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$todayfromdate' and '$todaytodate' and wellnessitem <> 1";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res4 = mysqli_fetch_array($exec4))
		  {
		  	 $sercode=$res4['servicesitemcode'];
			 $serqty=$res4['serviceqty'];
			 $serrefqty=$res4['refundquantity'];
			
			 $serqty = $serqty-$serrefqty;
			
			$queryfx = "select rateperunit from $sertemplate where itemcode = '$sercode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$serrate=$resfx['rateperunit'] * $fxrate;
			$serrate = $serrate * $serqty;
			if(($planpercentage!=0.00)&&($planforall=='yes'))
			{ 
				$serrate = $serrate - ($serrate/100)*$planpercentage;
			}
			$res4servicesitemrate = $res4servicesitemrate + $serrate;
		  }
		  
		  $res5radiologyitemrate = 0;
		  $query5 = "select radiologyitemcode from consultation_radiology where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$todayfromdate' and '$todaytodate'";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res5 = mysqli_fetch_array($exec5))
		  {
		  	$radcode=$res5['radiologyitemcode'];
			
			$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$radrate=$resfx['rateperunit'] * $fxrate;
			if(($planpercentage!=0.00)&&($planforall=='yes'))
			{ 
				$radrate = $radrate - ($radrate/100)*$planpercentage;
			}
			$res5radiologyitemrate = $res5radiologyitemrate + $radrate;
		  }
		  
		  $query6 = "select sum(referalrate) as referalrate1 from consultation_referal where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$todayfromdate' and '$todaytodate' ";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
		  $res6referalrate = $res6['referalrate1'];
		  if ($res6referalrate =='')
		  {
		  $res6referalrate = '0.00';
		  }
		  else 
		  {
		    $res6referalrate = $res6['referalrate1'] * $fxrate;
		  }
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  { 
		  $res6referalrate=$res6referalrate - ($res6referalrate/100)*$planpercentage;
		  }
		  
		  $query7 = "select sum(consultationfees) as consultationfees1 from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$todayfromdate' and '$todaytodate'";
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
		  $res7consultationfees = $res7['consultationfees1'] * $fxrate;
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  { 
		  $copay=($res7consultationfees/100)*$planpercentage;
		  }
		  else
		  {
		  $copay = 0;
		  }
		  $res7consultationfees = $res7consultationfees - $copay;
		  
		  $query8 = "select sum(copayfixedamount) as copayfixedamount1 from master_billing where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$todayfromdate' and '$todaytodate'";
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res8 = mysqli_fetch_array($exec8);
		  $res8copayfixedamount = $res8['copayfixedamount1'];
		  $res8copayfixedamount = 0;
		  
		  $consultation = $res7consultationfees - $res8copayfixedamount;
		  
		  $query9 = "select sum(totalamount) as totalamount1 from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and entrydate between '$todayfromdate' and '$todaytodate' ";
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res9 = mysqli_fetch_array($exec9);
		  $res9pharmacyrate = $res9['totalamount1'];
		  
		  if ($res9pharmacyrate == '')
		  {
		  $res9pharmacyrate = '0.00';
		  }
		  else 
		  {
		  $res9pharmacyrate = $res9['totalamount1'];
		  }
		  
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  {
		  	$res9pharmacyrate = $res9pharmacyrate - ($res9pharmacyrate/100)*$planpercentage;
		  }
		  
			$query321 = "select sum(totalamount) as totalamount2 from pharmacysalesreturn_details where visitcode='$res2visitcode' and entrydate between '$todayfromdate' and '$todaytodate'";// and ipdocno = '$refno'";//group by itemcode";
			$exec321 = mysqli_query($GLOBALS["___mysqli_ston"], $query321) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $numpharmacysalereturn=mysqli_num_rows($exec321);
		  $totalpharmacysalesreturn=$totalpharmacysalesreturn+$numpharmacysalereturn;
		  //echo '<br>Total Pharmacy Return '.mysql_num_rows($exec321);
		    $res321 = mysqli_fetch_array($exec321);
		  $res9pharmacyreturnrate = $res321['totalamount2'];
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  {
		  	$res9pharmacyreturnrate = $res9pharmacyreturnrate - ($res9pharmacyreturnrate/100)*$planpercentage;
		  }
		  $res9pharmacyrate=$res9pharmacyrate- $res9pharmacyreturnrate;
		  
			$query322 = "select sum(totalamount) as totalrefund from refund_paylater where visitcode='$res2visitcode'";// and entrydate = '$todaydate'";// and ipdocno = '$refno'";//group by itemcode";
			$exec322 = mysqli_query($GLOBALS["___mysqli_ston"], $query322) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res322 = mysqli_fetch_array($exec322);
		  $totalrefund = $res322['totalrefund'];
		  
		   $overaltotalrefund=$overaltotalrefund+$totalrefund;
		  
		  
		  
		  $totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate + $overaltotalrefund;
		  $dptunrealized = $dptunrealized + $totalamount;
		 }
			$totalunrealized += $dptunrealized;
			//unrealized end
			
			$snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
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
	  <tr>
	  <td ><?=$resdpt['department'];?></td>
	  <td align="right" style="padding-right:8px"><?=$walkpatient;?></td>
	  <td align="right" style="padding-right:8px"><?=$walkpatient1;?></td>
	  <td align="right" style="padding-right:8px"><?=$walkpatient1+$walkpatient;?></td>
	  <td align="right" style="padding-right:8px"><?=$triage;?></td>
	  <td align="right" style="padding-right:8px"><?=$consult;?></td>
	  <td align="right" style="padding-right:8px"><?=$todaylab;?></td>
	  <td align="right" style="padding-right:8px"><?=$labsample;?></td>
	  <td align="right" style="padding-right:8px"><?=$labrefund;?></td>
	  <td align="right" style="padding-right:8px"><?=$todayrad;?></td>
	  <td align="right" style="padding-right:8px"><?=$radsample;?></td>
	  <td align="right" style="padding-right:8px"><?=$radrefund;?></td>
	  <td align="right" style="padding-right:8px"><?=$todayser;?></td>
	  <td align="right" style="padding-right:8px"><?=$sersample;?></td>
	  <td align="right" style="padding-right:8px"><?=$serrefund;?></td>
	  <td align="right" style="padding-right:8px"><?=$todaymed;?></td>
	  <td align="right" style="padding-right:8px"><?=$medissue;?></td>
	  <td align="right" style="padding-right:8px"><?=$medreturn;?></td>
	  <td align="right" style="padding-right:8px"><?= number_format($dptrevenue,'2','.',',');?></td>
	  <td align="right" style="padding-right:8px"><?= number_format($dptunrealized,'2','.',',');?></td>
      </tr>
	  <?php
	  $totalvisit +=$walkpatient; 
	  $totalvisit1 +=$walkpatient1; 
	  }
	  ?>
	  <tr bgcolor=''>
	  <td ><strong>Total :</strong></td>
	  <td align="right" style="padding-right:8px"><?=$totalvisit;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalvisit1;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalvisit1+$totalvisit;?></td>
	  <td align="right" style="padding-right:8px"><?=$totaltriage;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalconsult;?></td>
	  <td align="right" style="padding-right:8px"><?=$totallab;?></td>
	  <td align="right" style="padding-right:8px"><?=$totallabsample;?></td>
	  <td align="right" style="padding-right:8px"><?=$totallabrefund;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalrad;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalradsample;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalradrefund;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalser;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalsersample;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalserrefund;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalmed;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalmedissue;?></td>
	  <td align="right" style="padding-right:8px"><?=$totalmedreturn;?></td>
	  <td align="right" style="padding-right:8px"><?=number_format($totalrevenue,'2','.',',');?></td>
	  <td align="right" style="padding-right:8px"><?=number_format($totalunrealized,'2','.',',');?></td>
      </tr>
	  <tr >
	  <td colspan="20">&nbsp;</td>
      </tr>
			
		</table>
		</td>
		</tr>
		</tbody>
</table>
		
		