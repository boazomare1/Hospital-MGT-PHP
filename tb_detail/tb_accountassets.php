<?php
$sumbalance = 0;
$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid' AND id = '$id'";
$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res267 = mysqli_fetch_array($exec267))
{  
	$accountsmain2 = $res267['accountname'];
	$parentid2 = $res267['auto_number'];
	$ledgeranum = $parentid2;
	$id = $res267['id'];
	$i = 0;
	$opendr = 0;
	$opencr = 0;
	$accountdr = 0;
	$accountcr = 0;
	
	$result = array();
	/*$querydr1 = "SELECT SUM(`assetvalue`) as assetvalue FROM `master_fixedassets` where `fixedassetcode` = '$id'
				 UNION ALL SELECT SUM(`openbalanceamount`) as assetvalue FROM `openingbalanceaccount` where `accountcode` = '$id'";
	$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
	while($resdr1 = mysql_fetch_array($execdr1))
	{
	$i = $i+1;
	$result[$i] = $resdr1['assetvalue'];
	}*/
	$balance = '0';
	
	$querydr1 = "SELECT SUM(`totalamount`) as assetvalue FROM `assetpurchase_details` WHERE `assetcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
				UNION ALL SELECT SUM(`debitamount`) as assetvalue FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
	$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($resdr1 = mysqli_fetch_array($execdr1))
	{
	$i = $i+1;
	$result[$i] = $resdr1['assetvalue'];
	}
	
	$queryop = "SELECT SUM(`creditamount`) as credit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
	$execop = mysqli_query($GLOBALS["___mysqli_ston"], $queryop) or die ("Error in queryop".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resop = mysqli_fetch_array($execop);
	$credit = $resop['credit'];
	
	$accountasset = array_sum($result) + $balance - $credit;
	
	$sumbalance = $sumbalance + $accountasset;
}
?>			