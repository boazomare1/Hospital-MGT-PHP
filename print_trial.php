
<?php
session_start();
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="TB.xls"');
header('Cache-Control: max-age=80');

include ("db/db_connect.php");
set_time_limit(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d'); 


//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d', strtotime('-0 year')); }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }

//echo $searchsuppliername;
if (isset($_REQUEST["ADate3"])) { $ADate3 = $_REQUEST["ADate3"]; } else { $ADate3 = date('Y-m-d', strtotime('-0 year')); }
//echo $ADate1;
if (isset($_REQUEST["ADate4"])) { $ADate4 = $_REQUEST["ADate4"]; } else { $ADate4 = date('Y-m-d'); }
//echo $amount;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

?>


</head>

 
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
   <table width="99%" border="0" cellspacing="0" cellpadding="0">

       <tr>
        <td>
<?php

$from_date = $ADate1;
$to_date = $ADate2;

$balance_sheet = 0;
$income_statement = 0;

echo "<table border='1' style='
    width: 93%;
    font-size: initial;border:0px;
' cellpadding='2' cellspacing='0'>";

	echo "<tr style='background-color: #4fc7fd;'> <td>Opening</td> <td>Code</td> <td>Ledger</td> <td>Debit</td>  <td>Credit</td> <td>Closing</td> </tr>";


$query = "select auto_number as uid,id as code,accountsmain as name from master_accountsmain where section in ('A','L')  order by auto_number";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res = mysqli_fetch_array($exec))
{

		$opening_dr_cr = 0;
		$transaction_dr = 0;
		$transaction_cr = 0;
		$closing_dr_cr = 0;

			$array_ledgers_ids = array();
			$query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='".$res['uid']."')";
				$exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
				while($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)){
					array_push($array_ledgers_ids, $res_ledger_ids['id']);
				}

			$ledger_ids = implode("','", $array_ledgers_ids);

			$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and transaction_date < '".$from_date."' group by transaction_type ";
				$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
				while($res_opening = mysqli_fetch_array($exec_opening)){
					if($res_opening['transaction_type']=="D"){
						$opening_dr_cr += $res_opening['transaction_amount'];
					}else{
						$opening_dr_cr -= $res_opening['transaction_amount'];
					}
				}
			
				$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
				$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
				while($res_transaction = mysqli_fetch_array($exec_transaction)){
					if($res_transaction['transaction_type']=="D"){
						$transaction_dr += $res_transaction['transaction_amount'];
					}else{
						$transaction_cr += $res_transaction['transaction_amount'];
					}
				}

				$closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;
				
				$balance_sheet += $closing_dr_cr;


		 echo "<tr style='background-color: tomato;'> <td  align='right'>".showAmount($opening_dr_cr,'1')."</td> <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td> <td  align='right'>".showAmount($transaction_dr,'0')."</td>  <td  align='right'>".showAmount($transaction_cr,'0')."</td> <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";

	echo getSubgroups($res['uid'],$from_date,$to_date);
}

	echo "<tr> <td colspan='5' align='right'>Net Profit : </td> <td  align='right'>".showAmount(net_profit($from_date,$to_date),1)." </td> </tr>";

	echo "<tr> <td colspan='5' align='right'> </td> <td  align='right'>".showAmount($balance_sheet+net_profit($from_date,$to_date),1)." </td> </tr>";

	echo "<tr> <td colspan='5' align='right'>Net Profit : </td> <td  align='right'>".showAmount(-1*net_profit($from_date,$to_date),1)." </td> </tr>";


$query = "select auto_number as uid,id as code,accountsmain as name from master_accountsmain where section in ('E','I')  order by auto_number";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res = mysqli_fetch_array($exec))
{

		$opening_dr_cr = 0;
		$transaction_dr = 0;
		$transaction_cr = 0;
		$closing_dr_cr = 0;

			$array_ledgers_ids = array();
			$query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='".$res['uid']."')";
				$exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
				while($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)){
					array_push($array_ledgers_ids, $res_ledger_ids['id']);
				}

			$ledger_ids = implode("','", $array_ledgers_ids);


			$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and transaction_date < '".$from_date."' group by transaction_type ";
				$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
				while($res_opening = mysqli_fetch_array($exec_opening)){
					if($res_opening['transaction_type']=="D"){
						$opening_dr_cr += $res_opening['transaction_amount'];
					}else{
						$opening_dr_cr -= $res_opening['transaction_amount'];
					}
				}
			
				$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
				$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
				while($res_transaction = mysqli_fetch_array($exec_transaction)){
					if($res_transaction['transaction_type']=="D"){
						$transaction_dr += $res_transaction['transaction_amount'];
					}else{
						$transaction_cr += $res_transaction['transaction_amount'];
					}
				}

				$closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;

				$income_statement += $closing_dr_cr;

		 echo "<tr style='background-color: tomato;'> <td  align='right'>".showAmount($opening_dr_cr,'1')."</td> <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td> <td  align='right'>".showAmount($transaction_dr,'0')."</td>  <td  align='right'>".showAmount($transaction_cr,'0')."</td> <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";

	echo getSubgroups($res['uid'],$from_date,$to_date);

}

	echo "<tr> <td colspan='5' align='right'> </td> <td  align='right'>".showAmount(-1*net_profit($from_date,$to_date)+$income_statement,1)." </td> </tr>";

echo "</table>";

function getSubgroups($account_id,$from_date,$to_date){

	$subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where accountsmain='$account_id' order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";

	while($res = mysqli_fetch_array($exec))
	{
		getGroupBalance($res['uid'],$from_date,$to_date);		
	}

	return $data;
}

function getLedger($group_id,$from_date,$to_date){
	$ledger_query = "select auto_number as uid, id as code,accountname as name from master_accountname where accountssub='$group_id' order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query) or die ("Error in ledger_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";

	while($res = mysqli_fetch_array($exec))
	{
		$opening_dr_cr = 0;
		$transaction_dr = 0;
		$transaction_cr = 0;
		$closing_dr_cr = 0;

	$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id='".$res['code']."' and transaction_date < '".$from_date."' group by transaction_type ";
		$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_opening = mysqli_fetch_array($exec_opening)){
			if($res_opening['transaction_type']=="D"){
				$opening_dr_cr += $res_opening['transaction_amount'];
			}else{
				$opening_dr_cr -= $res_opening['transaction_amount'];
			}
		}
	
		$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id='".$res['code']."' and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
		$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_transaction = mysqli_fetch_array($exec_transaction)){
			if($res_transaction['transaction_type']=="D"){
				$transaction_dr += $res_transaction['transaction_amount'];
			}else{
				$transaction_cr += $res_transaction['transaction_amount'];
			}
		}

		$closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;

		 $ledgercode = $res['code'];

		 $data .="<tr> <td  align='right'>".showAmount($opening_dr_cr,'1')."</td> <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."&nbsp;"."</td> <td  align='right'>".showAmount($transaction_dr,'0')."</td>  <td  align='right'>".showAmount($transaction_cr,'0')."</td> <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";
	}

	return $data;	
}

function showAmount($amount,$show_rule){
	if($show_rule=='1'){
		if($amount>=0){
			return "Dr ".number_format(abs($amount),2);
		}else{
			return "Cr ".number_format(abs($amount),2);
		}
	}else{
		return number_format(abs($amount),2);
	}
}

function getAllLedgers($group_id){

	$array_data = [];

$subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where accountsmain='$group_id' order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";
	while($res = mysqli_fetch_array($exec))
	{
		$ledger_query1 = "select id as code from master_accountname where accountssub='".$res['code']."' order by auto_number";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query1) or die ("Error in ledger_query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$data = "";

			while($res1 = mysqli_fetch_array($exec1))
			{
				array_push($array_data, $res1['code']);
			}

			getAllLedgers($res['code']);
	}	

	$ledger_query1 = "select id as code from master_accountname where accountssub='$group_id' order by auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query1) or die ("Error in ledger_query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";

	while($res1 = mysqli_fetch_array($exec1))
	{
		array_push($array_data, $res1['code']);
	}


	return $array_data;

}

function getGroupBalance($group_id,$from_date,$to_date){
	$data = "";
	$all_ledgers = getAllLedgers($group_id);

	$subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where auto_number='$group_id' ";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res = mysqli_fetch_array($exec))
	{

		$opening_dr_cr = 0;
		$transaction_dr = 0;
		$transaction_cr = 0;
		$closing_dr_cr = 0;

		$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".implode("','",$all_ledgers)."') and transaction_date < '".$from_date."' group by transaction_type ";
		$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_opening = mysqli_fetch_array($exec_opening)){
			if($res_opening['transaction_type']=="D"){
				$opening_dr_cr += $res_opening['transaction_amount'];
			}else{
				$opening_dr_cr -= $res_opening['transaction_amount'];
			}
		}
	
		$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and  ledger_id in ('".implode("','",$all_ledgers)."') and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
		$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_transaction = mysqli_fetch_array($exec_transaction)){
			if($res_transaction['transaction_type']=="D"){
				$transaction_dr += $res_transaction['transaction_amount'];
			}else{
				$transaction_cr += $res_transaction['transaction_amount'];
			}
		}

		$closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;

		 $data .="<tr  style='background-color: aquamarine;'> <td  align='right'>".showAmount($opening_dr_cr,'1')."</td> <td>"."'".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td> <td  align='right'>".showAmount($transaction_dr,'0')."</td>  <td  align='right'>".showAmount($transaction_cr,'0')."</td> <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";

	 if($res['show_ledger']=="1"){
		 	 $data .=getLedger($res['uid'],$from_date,$to_date);
		 }


	}

	echo $data;

}

function net_profit($from_date,$to_date){
	$query = "select auto_number as uid,id as code,accountsmain as name from master_accountsmain where section in ('E','I')  order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$closing_dr_cr = 0;

	while($res = mysqli_fetch_array($exec))
	{

			$opening_dr_cr = 0;
			$transaction_dr = 0;
			$transaction_cr = 0;

			$array_ledgers_ids = array();
			$query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='".$res['uid']."')";
				$exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
				while($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)){
					array_push($array_ledgers_ids, $res_ledger_ids['id']);
				}

			$ledger_ids = implode("','", $array_ledgers_ids);

				$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."')  and transaction_date < '".$from_date."' group by transaction_type  ";
					$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
					while($res_opening = mysqli_fetch_array($exec_opening)){
						if($res_opening['transaction_type']=="D"){
							$opening_dr_cr += $res_opening['transaction_amount'];
						}else{
							$opening_dr_cr -= $res_opening['transaction_amount'];
						}
					}
				
					$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
					$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
					while($res_transaction = mysqli_fetch_array($exec_transaction)){
						if($res_transaction['transaction_type']=="D"){
							$transaction_dr += $res_transaction['transaction_amount'];
						}else{
							$transaction_cr += $res_transaction['transaction_amount'];
						}
					}

					$closing_dr_cr += $opening_dr_cr + $transaction_dr - $transaction_cr;
	}
		return $closing_dr_cr;				
}

?>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
