<?php

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
	$drresult = array();
	$j = 0;
	$crresult = array();
	
	$querydr1bnk = "SELECT SUM(`transactionamount`) as bankamount FROM `master_transactionpaynow` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` LIKE 'OPC%'
					UNION ALL SELECT SUM(`transactionamount`) as bankamount FROM `master_transactionexternal` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'";
	$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1bnk) or die ("Error in querydr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($resdr1 = mysqli_fetch_array($execdr1))
	{
	$i = $i+1;
	$drresult[$i] = $resdr1['bankamount'];
	}
	
	if($id == '01-1001-1')
	{
		$i=0;
		$querydr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_referal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						
						UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_externallab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`amount`) as income FROM `billing_externalpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_externalradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`servicesitemrate`) as income FROM `billing_externalservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$i = $i+1;
		$crresult[$i] = $resdr1['income'];
		}
	}
	
	$sumbalance = $sumbalance + array_sum($drresult) + array_sum($crresult);
}
?>					