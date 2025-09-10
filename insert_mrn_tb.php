<?php 

ini_set('max_execution_time', '0');
ini_set("memory_limit",'1024M');
include ("db/db_connect.php");

$cnt = 0;
$table = "materialreceiptnote_details";


 // get finance mapping ledger code - GRN Control Account
	$queryledgerf = "SELECT ledger_id 
    FROM `finance_ledger_mapping`
    WHERE map_anum = '16' 
    ORDER BY auto_number 
    DESC LIMIT 0,1";
	$execledgerf = mysqli_query($GLOBALS["___mysqli_ston"], $queryledgerf) or die ("Error in finance_ledger_mapping  Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resledgerf = mysqli_fetch_array($execledgerf);
	$financeledgercode = $resledgerf["ledger_id"];

$query = "select billnumber from materialreceiptnote_details where billnumber <>'' and itemcode <> '' and billnumber like 'MRN-%'  group by billnumber";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in materialreceiptnote_details select Query".mysqli_error($GLOBALS["___mysqli_ston"]));

 while($res = mysqli_fetch_array($exec))
 {

 	$billnumber = $res['billnumber'];
 	$querycheck = "select auto_number from tb where doc_number='$billnumber'";
	$execcheck= mysqli_query($GLOBALS["___mysqli_ston"], $querycheck) or die ("Error in checkbat".mysqli_error($GLOBALS["___mysqli_ston"]));
	$billcount = mysqli_num_rows($execcheck);
	if($billcount == 0){


		$fetchqrymrn = "select itemcode,billnumber,entrydate,costprice,quantity,username,locationcode from materialreceiptnote_details where  billnumber='$billnumber'";

		$execmrn = mysqli_query($GLOBALS["___mysqli_ston"], $fetchqrymrn) or die ("Error in $table select Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		 while($resmrn = mysqli_fetch_array($execmrn))
		 {

		 	$itemcode = $resmrn['itemcode'];

		 	$transaction_date =  $resmrn['entrydate'];
		 	$costprice =  $resmrn['costprice'];
		 	$quantity  =  $resmrn['quantity'];
		 	$user_name  =  $resmrn['username'];
		 	$locationcode  =  $resmrn['locationcode'];

		 	$transaction_amount = $costprice * $quantity;

		 	$transaction_type = 'D';

		 	$currency_code = 'CUR-1';

		 	$exchange_rate = '1';

		 	$created_at = $transaction_date." 00:00:00";

		 	// get inventory ledger code for item
			$queryledger = "select inventoryledgercode from master_medicine where itemcode='$itemcode' order by auto_number 
			desc limit 0,1";
			$execledger = mysqli_query($GLOBALS["___mysqli_ston"], $queryledger) or die ("Error in $table Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resledger = mysqli_fetch_array($execledger);
			$master_ledgercode = $resledger["inventoryledgercode"];

			// Inventory entry

			$query_insert = "INSERT INTO `tb` (`auto_number`, `doc_number`, `from_table`, `remarks`, `ledger_id`, `transaction_date`, `transaction_amount`, `transaction_type`, `currency_code`, `exchange_rate`, `created_at`,   `record_status`, `user_name`, `locationcode`) VALUES (NULL, '$billnumber', 'materialreceiptnote_details', 'Inventory', '$master_ledgercode', '$transaction_date', '$transaction_amount', '$transaction_type', '$currency_code', '$exchange_rate', '$created_at', '1', '$user_name', '$locationcode');";

 			//echo $query_insert;

			mysqli_query($GLOBALS["___mysqli_ston"], $query_insert) or die ("Error in  Insert Query".mysqli_error($GLOBALS["___mysqli_ston"]));


			// Grn Control entry

			$transaction_type = 'C';
			$query_insert1 = "INSERT INTO `tb` (`auto_number`, `doc_number`, `from_table`, `remarks`, `ledger_id`, `transaction_date`, `transaction_amount`, `transaction_type`, `currency_code`, `exchange_rate`, `created_at`,   `record_status`, `user_name`, `locationcode`) VALUES (NULL, '$billnumber', 'materialreceiptnote_details', 'GRN Control', '$financeledgercode', '$transaction_date', '$transaction_amount', '$transaction_type', '$currency_code', '$exchange_rate', '$created_at', '1', '$user_name', '$locationcode');";

 			//echo $query_insert;

			mysqli_query($GLOBALS["___mysqli_ston"], $query_insert1) or die ("Error in  Insert Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$cnt += 1;

			//echo  'Inserted Records for '.$billnumber.'<br>';
			echo  $billnumber.'<br>';
		 }

		
		
	}
 }


((mysqli_free_result($exec) || (is_object($exec) && (get_class($exec) == "mysqli_result"))) ? true : false); 
?>