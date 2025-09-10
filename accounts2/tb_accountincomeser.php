<?php
				$query267 = "select id,accountssub,auto_number from master_accountssub where parentid = '$parentid'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{
				$id = $res267['id'];
				$i = 0;
	
		$crresult1 = array();
		$querycr1in = "SELECT SUM(a.`servicesitemrateuhx`) as income FROM `billing_ipservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id' and a.wellnessitem <> '1'
		union all select SUM(`amountuhx`) as income FROM `billing_ipbedcharges` as a join master_ipvisitentry as b on (a.visitcode = b.visitcode and a.ward = '0') join master_ippackage as c on (b.package = c.auto_number) join master_services as d on (c.servicescode = d.itemcode) WHERE a.description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Accommodation Charges','Admitting Specialist Review','Cafetaria Charges','Inhouse Specialist Review','Intensivist Review') and d.ledgerid = '$id' and a.recorddate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		$journal=0;
		$query2671 = "select id,accountssub,auto_number from master_accountssub where parentid = '$id'";
				$exec2671 = mysqli_query($GLOBALS["___mysqli_ston"], $query2671) or die ("Error in Query2671".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2671 = mysqli_fetch_array($exec2671))
				{
					$id1 = $res2671['id'];
		$queryjndr = "SELECT SUM(`debitamount`) as debit FROM `master_journalentries` WHERE `ledgerid` = '$id1' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjndr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjndr) or die ("Error in queryjndr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjndr = mysqli_fetch_array($execjndr);
					$jndebit = $resjndr['debit'];
					
					$queryjncr = "SELECT SUM(`creditamount`) as credit FROM `master_journalentries` WHERE `ledgerid` = '$id1' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjncr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjncr) or die ("Error in queryjncr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjncr = mysqli_fetch_array($execjncr);
					$jncredit = $resjncr['credit'];
					
					//$journal += $jncredit - $jndebit;
				}	
				$sumbalance = $sumbalance + array_sum($crresult1)+$journal;
		}
		$sumbalance = $sumbalance;
?>					