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

	if($id != '')
	{
		$i = 0;
		$result = array();
		$querydr1 = "SELECT SUM(a.`totalcp`) as stockpurchase FROM `pharmacysales_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.incomeledgercode = '$id' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'";
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$i = $i+1;
		//print_r($resdr1);
		$result[$i] = $resdr1['stockpurchase'];
		//$paylater = $result[$i];
		}
		
		$j = 0;
		$resultcr = array();
		$querycr1 = "SELECT SUM(a.`totalcp`) as stockreturn FROM `pharmacysalesreturn_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.incomeledgercode = '$id' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'";
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in Querycr1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$j = $j+1;
		//print_r($resdr1);
		$resultcr[$j] = $rescr1['stockreturn'];
		//$paylater = $result[$i];
		}
		$balance = array_sum($result) - array_sum($resultcr);
		$sumbalance = $sumbalance + $balance;
	}
}
?>			