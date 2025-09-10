<?php

include ("db/db_connect.php");
echo $query1="SELECT * FROM `master_transactiondoctor` as a where docno not in (select doc_number FROM `tb` WHERE transaction_type='c' and from_table = 'master_transactiondoctor')";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
while($res1 = mysqli_fetch_array($exec1))
{
	$sql="INSERT INTO `tb` SET doc_number = '".$res1['docno']."', 
            ledger_id = '".$res1['bankcode']."', 
            transaction_date = '".$res1['transactiondate']."', 
            transaction_amount = '".$res1['transactionamount']."', 
            transaction_type = 'C', 
            parent_type = '', 
            currency_code = 'CUR-1',
            exchange_rate = '1',
            cost_center_code = '',
            remarks = 'Payment',
            from_table = 'master_transactiondoctor',
            narration = '',
            created_at = now(),
            updated_at = now(),
            record_status = '1',
            user_name = '".$res1['username']."',
            locationcode = '".$res1['locationcode']."'";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));

}

?>