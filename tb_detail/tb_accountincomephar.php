<?php
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid' AND id = '$id'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					$id = $res267['id'];
					 
					$queryjndr = "SELECT SUM(`debitamount`) as debit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjndr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjndr) or die ("Error in queryjndr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjndr = mysqli_fetch_array($execjndr);
					$jndebit = $resjndr['debit'];
					
					$queryjncr = "SELECT SUM(`creditamount`) as credit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjncr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjncr) or die ("Error in queryjncr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjncr = mysqli_fetch_array($execjncr);
					$jncredit = $resjncr['credit'];
					
					$journal = $jncredit - $jndebit;
					
					if($id == '01-1000-1')
					{
						$j = 0;
						$crresult = array();
						$querycr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`amount`) as income FROM `billing_externalpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ippharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$j = $j+1;
						$crresult[$j] = $rescr1['income'];
						}
						
						$i = 0;
						$drresult = array();
						$querydr1in = "SELECT SUM(`amount`) as incomedebit FROM `refund_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`amount`) as incomedebit FROM `refund_paylaterpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`amount`) as incomedebit FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$i = $i+1;
						$drresult[$i] = $resdr1['incomedebit'];
						}
						
						$balance = array_sum($crresult) - array_sum($drresult);
					}
					else 
					{
						$balance = 0;
					}
					
					$balance = round($balance);
					$sumbalance = $sumbalance + $balance + $journal;
				}
				
				$sumbalance;
?>					