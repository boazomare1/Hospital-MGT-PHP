<?php
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					$id = $res267['id'];
					if($id != '')
					{
						/* */
						$i = 0;
						$result = array();
						$querydr1 = "SELECT SUM(`debitamount`) as expenses FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT SUM(`totalamount`) as expenses FROM `purchase_details` WHERE `expensecode` = '$id' AND billnumber NOT LIKE 'SOP%' AND suppliername <> 'OPENINGSTOCK' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
								UNION ALL SELECT SUM(a.`totalamount`) as expenses FROM `purchase_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.billnumber NOT LIKE 'SOP%' AND a.suppliername <> 'OPENINGSTOCK' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted' and b.type <> 'assets' 
								UNION ALL SELECT SUM(`transactionamount`) as expenses FROM `expensesub_details` WHERE `expensecoa` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT SUM(a.`amount`) as expenses FROM `master_stock_transfer` AS a WHERE a.tostore = '$id' AND a.tostore NOT LIKE 'STO%' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT SUM(a.`totalcp`) as expenses FROM `pharmacysalesreturn_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(`openbalanceamount`) as expenses FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT SUM(a.`totalcp`) as expenses FROM `pharmacysales_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.incomeledgercode = '$id' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$i = $i+1;
						$result[$i] = $resdr1['expenses'];
						}
						
						$j = 0;
						$crresult = array();
						$querycr1inv = "SELECT SUM(`creditamount`) as stockcredit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(a.`totalamount`) as stockcredit FROM `purchasereturn_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted'
										UNION ALL SELECT SUM(`totalamount`) as stockcredit FROM `purchasereturn_details` WHERE expensecode = '$id' AND entrydate BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
										UNION ALL SELECT SUM(a.`totalcp`) as stockcredit FROM `pharmacysales_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`openbalanceamount`) as stockcredit FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and payablestatus ='0'
										UNION ALL SELECT SUM(a.`amount`) as stockcredit FROM `master_stock_transfer` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.tostore NOT LIKE 'STO%'  AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1inv) or die ("Error in querycr1inv".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$j = $j+1;
						$crresult[$j] = $rescr1['stockcredit'];
						}
						
					}
					else
					{
						$result = array();
						$crresult = array();
					}
					
					$balance = array_sum($result) - array_sum($crresult);
					
					$sumbalance = $sumbalance + $balance;
					
				}
				
?>					