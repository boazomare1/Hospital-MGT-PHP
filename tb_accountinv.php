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
						 /**/			
						$i = 0;
						$drresult = array();
						$querydr1inv = "SELECT SUM(`totalfxamount`) as stock FROM `purchase_details` WHERE `entrydate` BETWEEN '$ADate1' AND '$ADate2' AND (`ledgercode` = '$id' or `expensecode` = '$id') AND '$ADate2' AND billnumber NOT LIKE 'SUPO%' AND suppliername <> 'OPENINGSTOCK' AND `recordstatus` <> 'deleted'
										UNION ALL SELECT SUM(`transactionamount`) as stock FROM `expensesub_details` WHERE `expensecoa` = '$id' AND transactionmode <> 'ADJUSTMENT' AND transactiondate BETWEEN '$ADate1' AND '$ADate2'";
										//UNION ALL SELECT SUM(`debitamount`) as stock FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'"; 
									//UNION ALL SELECT SUM(`totalcp`) as stock FROM `pharmacysalesreturn_details` WHERE `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1inv) or die ("Error in querydr1inv".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$i = $i+1;
						$drresult[$i] = $resdr1['stock'];
						}
					
						$j = 0;
						$crresult = array();
						/*$querycr1inv = "SELECT SUM(`totalamount`) as stockcredit FROM `purchasereturn_details` WHERE `entrydate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`creditamount`) as stockcredit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
										//UNION ALL SELECT SUM(`totalcp`) as stockcredit FROM `pharmacysales_details` WHERE `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execcr1 = mysql_query($querycr1inv) or die ("Error in querycr1inv".mysql_error());
						while($rescr1 = mysql_fetch_array($execcr1))
						{
						$j = $j+1;
						$crresult[$j] = $rescr1['stockcredit'];
						}*/
						
						$balance = array_sum($drresult) - array_sum($crresult);
						
						$sumbalance = $sumbalance + $balance;
					}
				}
				
				$sumbalance;
?>					