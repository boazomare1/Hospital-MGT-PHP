<?php

$totalsales = "0.00";
$cashamount2 = "0.00";
$cardamount2 = "0.00";
$onlineamount2 = "0.00";
$chequeamount2 = "0.00";
$tdsamount2 = "0.00";
$writeoffamount2 = "0.00";
$colorloopcount = "0";
$balanceamount = "0.00";
$sno = "0";

$query2 = "select * from master_transactionpaylater where patientname = '$customername' and recordstatus = '' and 
transactiondate <= '$transactiondatefrom' group by patientname";// and approvalstatus =  'APPROVED' and cstid='$custid' and cstname='$custname'";//  order by transactiondate desc";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2anum = $res2['customeranum'];
	$res2customername = $res2['customername'];
	$res2customername = $res2['customername'];
	
	$query3 = "select * from master_transactionpaylater where transactiontype = 'finalize' and patientname = '$customername' and 
	recordstatus = '' and transactiondate <= '$transactiondatefrom'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res3 = mysqli_fetch_array($exec3))
	{
		$transactionamount = $res3['transactionamount'];
		$totalsales = $totalsales + $transactionamount;
	}
	
	$query3 = "select * from master_transactionpaylater where transactiontype = 'PAYMENT' and patientname = '$customername' and 
	recordstatus = '' and transactiondate <= '$transactiondatefrom'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res3 = mysqli_fetch_array($exec3))
	{
		$cashamount1 = $res3['cashamount'];
		$onlineamount1 = $res3['onlineamount'];
		$chequeamount1 = $res3['chequeamount'];
		$cardamount1 = $res3['cardamount'];
		$tdsamount1 = $res3['tdsamount'];
		$writeoffamount1 = $res3['writeoffamount'];
		
		$cashamount2 = $cashamount2 + $cashamount1;
		$cardamount2 = $cardamount2 + $cardamount1;
		$onlineamount2 = $onlineamount2 + $onlineamount1;
		$chequeamount2 = $chequeamount2 + $chequeamount1;
		$tdsamount2 = $tdsamount2 + $tdsamount1;
		$writeoffamount2 = $writeoffamount2 + $writeoffamount1;
	}
	
	$totalpayments = $cashamount2 + $chequeamount2 + $onlineamount2 + $cardamount2;
	$netpayments = $totalpayments + $tdsamount2 + $writeoffamount2;
	$balanceamount = $totalsales - $netpayments;
}
$salesbalance = $balanceamount;



$transactionamount = "0.00";
$totalsales = "0.00";
$cashamount1 = "0.00";
$onlineamount1 = "0.00";
$chequeamount1 = "0.00";
$cardamount1 = "0.00";
$tdsamount1 = "0.00";
$writeoffamount1 = "0.00";
$cashamount2 = "0.00";
$cardamount2 = "0.00";
$onlineamount2 = "0.00";
$chequeamount2 = "0.00";
$tdsamount2 = "0.00";
$writeoffamount2 = "0.00";
$totalpayments = "0.00";
$netpayments = "0.00";
$balanceamount = "0.00";



$query2 = "select * from master_transactionpaylater where patientname = '$customername' and transactionmodule = 'SALES RETURN' and 
recordstatus = '' and transactiondate <= '$transactiondatefrom' group by patientname";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2anum = $res2['customeranum'];
	$res2customername = $res2['customername'];
	
	$query3 = "select * from master_transactionpaylater where transactiontype = 'SALES RETURN' and transactionmodule = 'SALES RETURN' and 
	patientname = '$customername' and recordstatus = '' and transactiondate <= '$transactiondatefrom'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res3 = mysqli_fetch_array($exec3))
	{
		$transactionamount = $res3['transactionamount'];
		$totalsales = $totalsales + $transactionamount;
	}
	
	$query3 = "select * from master_transactionpaylater where transactiontype = 'PAYMENT' and transactionmodule = 'SALES RETURN' and 
	patientname = '$customername' and recordstatus = '' and transactiondate <= '$transactiondatefrom'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res3 = mysqli_fetch_array($exec3))
	{
		$cashamount1 = $res3['cashamount'];
		$onlineamount1 = $res3['onlineamount'];
		$chequeamount1 = $res3['chequeamount'];
		$cardamount1 = $res3['cardamount'];
		$tdsamount1 = $res3['tdsamount'];
		$writeoffamount1 = $res3['writeoffamount'];
		
		$cashamount2 = $cashamount2 + $cashamount1;
		$cardamount2 = $cardamount2 + $cardamount1;
		$onlineamount2 = $onlineamount2 + $onlineamount1;
		$chequeamount2 = $chequeamount2 + $chequeamount1;
		$tdsamount2 = $tdsamount2 + $tdsamount1;
		$writeoffamount2 = $writeoffamount2 + $writeoffamount1;
	}
	
	$totalpayments = $cashamount2 + $chequeamount2 + $onlineamount2 + $cardamount2;
	$netpayments = $totalpayments + $tdsamount2 + $writeoffamount2;
	$balanceamount = $totalsales - $netpayments;
	
}
$salesreturnbalance = $balanceamount;

$actualbalance = $salesbalance - $salesreturnbalance;
$openingbalance = $openingbalance - $actualbalance;


?>