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
						$querydr1 = "SELECT SUM(`accdepreciation`) as accdepreciation FROM `accumulateddepreciation` WHERE `depreciationcode` = '$id' AND `recorddate` BETWEEN '2014-01-01' AND '2014-12-31'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$i = $i+1;
						$result[$i] = $resdr1['accdepreciation'];
						}
						$balance = 0;
					} else {
						$balance = 0;
					}
			
					$sumbalance = $sumbalance + $balance;
					
			}
?>			