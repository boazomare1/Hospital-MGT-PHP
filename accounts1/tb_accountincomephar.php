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
$opening = 0;
$journal = 0;

if($id != '')
{
	$queryjndr = "SELECT SUM(`debitamount`) as debit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
	$execjndr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjndr) or die ("Error in queryjndr".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resjndr = mysqli_fetch_array($execjndr);
	$jndebit = $resjndr['debit'];
	
	$queryjncr = "SELECT SUM(`creditamount`) as credit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
	$execjncr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjncr) or die ("Error in queryjncr".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resjncr = mysqli_fetch_array($execjncr);
	$jncredit = $resjncr['credit'];
	
	$journal = $jncredit - $jndebit;
	if($id == '04-6010-PI')
	{
	$querypw = "SELECT SUM(`pharmacyfxamount`) as waiver FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'";
	$execpw = mysqli_query($GLOBALS["___mysqli_ston"], $querypw) or die ("Error in querypw".mysqli_error($GLOBALS["___mysqli_ston"]));
	$respw = mysqli_fetch_array($execpw);
	$waiver = $respw['waiver'];
	}
	else
	{
	$waiver = 0;
	}

	$j = 0;
	$crresult = array();
	$querycr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowpharmacy` WHERE ledgercode = '$id' AND billdate BETWEEN '$ADate1' AND '$ADate2'
				   UNION ALL SELECT SUM(`amount`) as income FROM `billing_externalpharmacy` WHERE ledgercode = '$id' AND billdate BETWEEN '$ADate1' AND '$ADate2'
				   UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterpharmacy` WHERE ledgercode = '$id' AND billdate BETWEEN '$ADate1' AND '$ADate2'";
				   //UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ippharmacy` WHERE ledgercode = '$id' AND billdate BETWEEN '$ADate1' AND '$ADate2'";
	$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rescr1 = mysqli_fetch_array($execcr1))
	{
	$j = $j+1;
	$crresult[$j] = $rescr1['income'];
	}
	
	$i = 0;
	$drresult = array();
	/*$querydr1in = "SELECT SUM(`amount`) as incomedebit FROM `refund_paynowpharmacy` WHERE ledgercode = '$id' AND billdate BETWEEN '$ADate1' AND '$ADate2'
				   UNION ALL SELECT SUM(`amount`) as incomedebit FROM `refund_paylaterpharmacy` WHERE ledgercode = '$id' AND billdate BETWEEN '$ADate1' AND '$ADate2'
				   UNION ALL SELECT SUM(`amount`) as incomedebit FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)";
				 //  UNION ALL SELECT SUM(`amount`) as incomedebit FROM `paylaterpharmareturns` WHERE ledgercode = '$id' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND `patientvisitcode` NOT IN (SELECT `patientvisitcode` FROM refund_paynowpharmacy)";
	$execdr1 = mysql_query($querydr1in) or die ("Error in querydr1in".mysql_error());
	while($resdr1 = mysql_fetch_array($execdr1))
	{
	$i = $i+1;
	$drresult[$i] = $resdr1['incomedebit'];
	}*/
	
	$balance = array_sum($crresult) - array_sum($drresult) - $waiver;

//unfinal
}



$sumbalance = $sumbalance + $balance + $journal;
				
}

$sumbalance;
?>					