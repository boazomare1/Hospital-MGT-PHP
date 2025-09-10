<?php
$journal = 0;
$external_services_add=0;
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
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`fxamount`) as income FROM `billing_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						UNION ALL SELECT SUM(`amount`) as income FROM `billing_externalpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`servicesitemrate`) as income FROM `billing_externalservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`fxamount`) as income FROM `billing_paylaterservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ippharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`servicesitemrateuhx`) as income FROM `billing_ipservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						UNION ALL SELECT SUM(`transactionamount`) as income FROM `receiptsub_details` WHERE transactionmode <> 'ADJUSTMENT' AND transactiondate BETWEEN '$ADate1' AND '$ADate2' and receiptcoa = '$id'
						UNION ALL SELECT SUM(`creditamount`) as income FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		
		
		/*
		
		 */
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`amount`) as incomedebit FROM `refund_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
		UNION ALL SELECT SUM(`serviceamount`) as incomedebit FROM `refund_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
		
		UNION ALL SELECT SUM(`amount`) as incomedebit FROM `refund_paylaterpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
		
		UNION ALL SELECT SUM(`amount`) as incomedebit FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)
		
		UNION ALL SELECT SUM(`debitamount`) as incomedebit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
		if($id == '01-7002')
		{
		$querydr1in .= " UNION ALL SELECT SUM(`pharmacyfxamount`) as incomedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'";
		}
		
		if($id == '01-2-PRI')
		{
		$querydr1in .= " UNION ALL SELECT SUM(`servicesfxamount`) as incomedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Service'";
		}
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
	if($id=='01-3001-LAB')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT SUM(a.`fxamount`) as income FROM `billing_paynowlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
						UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_externallab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
						UNION ALL SELECT SUM(`rateuhx`) as income FROM `billing_iplab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		
		
		/*
		
		 */
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`labitemrate`) as incomedebit FROM `refund_paynowlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
				
		$querydr1in .= " UNION ALL SELECT SUM(`labfxamount`) as incomedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Lab'";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
	}
	
	if($id=='01-8001-RAD')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT SUM(a.`fxamount`) as income FROM `billing_paynowradiology` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
						UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_externalradiology` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterradiology` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
						UNION ALL SELECT SUM(`radiologyitemrateuhx`) as income FROM `billing_ipradiology` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`radiologyitemrate`) as incomedebit FROM `refund_paynowradiology` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterradiology` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
		
		
		$querydr1in .= " UNION ALL SELECT SUM(`radiologyfxamount`) as incomedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Radiology'";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
	}
	/* 
	*/
	if($id == '01-1001')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Others'";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
	}
	if($id == '01-1012-IN')
	{
	$i = 0;
		$crresult1 = array();
		$querycr1in = "select SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('Bed Charges','Nursing Charges','RMO Charges')"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('Bed Charges','Nursing Charges','RMO Charges')";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
	}

	
	if($id == '01-1011-IN')
	{
	
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT SUM(`consultation`) as income FROM `billing_consultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'						
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterconsultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		
		
		/*
		
		 */
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`consultation`) as incomedebit FROM `refund_consultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`consultation`) as incomedebit FROM `refund_paylaterconsultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
	
	}
	if($id == '01-1008')
	{
	
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_referal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipprivatedoctor` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`referalrate`) as incomedebit FROM `refund_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`referalrate`) as incomedebit FROM `refund_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
	
	}
	//UNION ALL 
	if($id == '01-1002')
	{
		$i = 0;
		$crresult = array();
		$querycr1in = "SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
		
						UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult[$i] = $rescr1['income'];
		}
		
		$j = 0;
		$drresult = array();
		
		
		$sumbalance = $sumbalance + array_sum($crresult) - array_sum($drresult);
	}	
	
}
				
				$sumbalance;
?>					