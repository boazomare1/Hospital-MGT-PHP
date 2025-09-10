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
	$opendr = 0;
	$opencr = 0;
	$accountdr = 0;
	$accountcr = 0;
$type=mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT transactionmode FROM financialaccount WHERE ledgercode = '".$id."'"))[0];
			
			switch($type){
			case 'CREDITCARD':
				$col= 'cardamount';
				break;
			case 'MPESA':
				$col= 'creditamount';
				break;
			case 'CHEQUE':
				$col= 'chequeamount';
				break;
			case 'ONLINE':
				$col= 'onlineamount';
				break;
			case 'CASH':
				$col= 'cashamount';
				break;
			default :
				$col = 'transactionamount';
				break;	
			}
	/**/
	$drresult = array();
	$querydr1bnk = "SELECT SUM(a.`totalamountuhx`) as bankamount FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`accountnameid` = '$id' AND b.billtype = 'PAY NOW' AND a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(fxamount) as bankamount FROM `billing_ipcreditapprovedtransaction` WHERE `accountcode` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'";
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
	$querycr1bnk = "SELECT SUM(fxamount) as bankcredit FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `docno` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
					UNION ALL SELECT SUM(fxamount) as bankcredit FROM `master_transactionpaylater` WHERE `accountcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'pharmacycredit' and visitcode like '%IPV%'";
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
