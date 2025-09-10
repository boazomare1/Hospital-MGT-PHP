<?php

$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid' AND id = '$id'";
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

	/**/
	$drresult = array();
	$querydr1bnk = "SELECT SUM(`transactionamount`) as bankamount FROM `master_transactionpaynow` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` LIKE 'OPC%'
					UNION ALL SELECT SUM(`transactionamount`) as bankamount FROM `master_transactionexternal` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`fxamount`) as bankamount FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE 'CB%'
					UNION ALL SELECT SUM(totalamountuhx) as bankamount FROM `billing_ip` WHERE `accountcode` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(fxamount) as bankamount FROM `billing_ipcreditapprovedtransaction` WHERE `accountcode` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`transactionamount`) as bankamount FROM `master_transactionpaylater` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
					UNION ALL SELECT SUM(`transactionamount`) as bankamount FROM `master_transactionadvancedeposit` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`transactionamount`) as bankamount FROM `master_transactionipdeposit` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
					UNION ALL SELECT SUM(amount) as bankamount FROM `bankentryform` WHERE `tobankid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`consultation`) as bankamount FROM `billing_consultation` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND billdate BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`transactionamount`) as bankamount FROM `receiptsub_details` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND transactionmode <> 'ADJUSTMENT' AND transactiondate BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`debitamount`) as bankamount FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
	$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1bnk) or die ("Error in querydr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($resdr1 = mysqli_fetch_array($execdr1))
	{
	$i = $i+1;
	$drresult[$i] = $resdr1['bankamount'];
	}
	
	/* 
	*/
	
	$j = 0;
	$crresult = array();
	$querycr1bnk = "SELECT SUM(`transactionamount`) as bankcredit FROM `refund_paynow` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(fxamount) as bankcredit FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `docno` LIKE '%Cr.N%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
					UNION ALL SELECT SUM(fxamount) as bankcredit FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `docno` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
					UNION ALL SELECT SUM(fxamount) as bankcredit FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'pharmacycredit'
					UNION ALL SELECT SUM(`transactionamount`) as bankcredit FROM `master_transactionpharmacy` WHERE `bankcode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `docno` LIKE 'SP-%' AND `recordstatus` = 'allocated' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`amount`) as bankcredit FROM `deposit_refund` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `recorddate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(ABS(`deposit`)) as bankcredit FROM `billing_ip` WHERE `accountcode` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(creditamount) as bankcredit FROM `bankentryform` WHERE `frombankid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`transactionamount`) as bankcredit FROM `expensesub_details` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND transactionmode <> 'ADJUSTMENT' AND transactiondate BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`creditamount`) as bankcredit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
	$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1bnk) or die ("Error in querycr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rescr1 = mysqli_fetch_array($execcr1))
	{
	$j = $j+1;
	$crresult[$j] = $rescr1['bankcredit'];
	}
	
	$accountbank = array_sum($drresult) - array_sum($crresult);
	
	$sumbalance = $sumbalance + $accountbank;
}
?>					