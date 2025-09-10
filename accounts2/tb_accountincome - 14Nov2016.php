<?php
$sumbalance = 0;
$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res267 = mysqli_fetch_array($exec267))
{ 
	$accountsmain2 = $res267['accountname'];
	$parentid2 = $res267['auto_number'];
	$ledgeranum = $parentid2;
	$id = $res267['id'];
	$accountbank = 0;
	$i = 0;
	$opendr = 0;
	$opencr = 0;
	$accountdr = 0;
	$accountcr = 0;
	
	/* */
	
	if($id == '01-1001-1')
	{
		$i = 0;
		$crresult = array();
		$querycr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_referal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						
						UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_externallab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amount`) as income FROM `billing_externalpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_externalradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`servicesitemrate`) as income FROM `billing_externalservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterconsultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_referal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
						
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_iplab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ippharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipprivatedoctor` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						
						UNION ALL SELECT SUM(`consultation`) as income FROM `billing_consultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
					    UNION ALL SELECT SUM(`transactionamount`) as income FROM `receiptsub_details` WHERE transactionmode <> 'ADJUSTMENT' AND transactiondate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult[$i] = $rescr1['income'];
		}
		
		
		/* */
		
		$j = 0;
		$drresult = array();
		$querydr1in = "SELECT SUM(`consultation`) as incomedebit FROM `refund_consultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`labitemrate`) as incomedebit FROM `refund_paynowlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`amount`) as incomedebit FROM `refund_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`radiologyitemrate`) as incomedebit FROM `refund_paynowradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`serviceamount`) as incomedebit FROM `refund_paynowservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`referalrate`) as incomedebit FROM `refund_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		
		UNION ALL SELECT SUM(`consultation`) as incomedebit FROM `refund_paylaterconsultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`amount`) as incomedebit FROM `refund_paylaterpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`referalrate`) as incomedebit FROM `refund_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Bed Charges'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Nursing Charges'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'RMO Charges'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Lab'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Radiology'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Service'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Others'
		
		UNION ALL SELECT SUM(`amount`) as incomedebit FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult) - array_sum($drresult);
	}	
}
?>					