<?php
$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res267 = mysqli_fetch_array($exec267))
{  
	$accountsmain2 = $res267['accountname'];
	$orderid1 = $orderid1 + 1;
	$parentid2 = $res267['auto_number'];
	$ledgeranum = $parentid2;
	//$id2 = $res2['id'];
	$id = $res267['id'];
	//$id2 = trim($id2);
	$lid = $lid + 1;
	
	if($id == '02-4001-DIS')
	{
		$i = 0;
		$crresult = array();
		$querycr1bnk = "SELECT SUM(-1*`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
						UNION ALL SELECT SUM(-1*`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billno)
						UNION ALL SELECT SUM(`openbalanceamount`) as income FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and payablestatus = '1'
						UNION ALL SELECT SUM(-1*`openbalanceamount`) as income FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`creditamount`) as income FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(-1*`debitamount`) as income FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1bnk) or die ("Error in querycr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult[$i] = $rescr1['income'];
		}
		  
		$balance = array_sum($crresult);
		$sumbalance = $sumbalance + $balance;
	}
	else if($id == '07-8001-NH')
	{
		$i = 0;
		$crresult = array();
		$querycr1bnk = "SELECT SUM(1*ABS(amount)) as income FROM `billing_ipnhif` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
						UNION ALL SELECT SUM(1*ABS(amount)) as income FROM `billing_ipnhif` WHERE visitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billno)
						UNION ALL SELECT SUM(-1*`creditamount`) as income FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`debitamount`) as income FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1bnk) or die ("Error in querycr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult[$i] = $rescr1['income'];
		}
		
		$balance = array_sum($crresult);
		$sumbalance = $sumbalance + $balance;
	}
	else 
	{
		$balance = 0;
		$sumbalance = $sumbalance + $balance;
	}
	
}
?>					