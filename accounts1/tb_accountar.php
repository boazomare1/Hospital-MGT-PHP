<?php
//
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$accountname = addslashes ($res267['accountname']);
					$orderid1 = $orderid1 + 1;
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					$id = $res267['id'];
					$lid = $lid + 1;
					$i = 0;
					$opendr = 0;
					$opencr = 0;
					$accountdr = 0;
					$accountcr = 0;
					$opening = '0';
					
					/*  */
					
					$result = array();
					$querydr1 = "SELECT SUM(`fxamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE 'CB%'";
					$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num = mysqli_num_rows($execdr1);
					while($resdr1 = mysqli_fetch_array($execdr1))
					{
					$i = $i+1;
					$result[$i] = $resdr1['paylater'];
					}
					
					/*

					*/
					$j = 0;
					$crresult = array();
					$querycr1 = "SELECT SUM(fxamount) as paylatercredit FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE '%Cr.N%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT SUM(`amount`) as paylatercredit FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$id' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`  and a.`visitcode` not like '%IPV%')";
					$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in Querycr1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($rescr1 = mysqli_fetch_array($execcr1))
					{
					$j = $j+1;
					$crresult[$j] = $rescr1['paylatercredit'];
					}
					$accountbank = array_sum($result) - array_sum($crresult) + $opening;
					$sumbalance = $sumbalance + $accountbank;
				}
?>					