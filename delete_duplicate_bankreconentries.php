<?php 
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$timeonly = date('H:i:s');

$total_deleted_rows = 0;

	$query1 = "SELECT docno,count(*) as cnt FROM `bank_record` group by docno,bankcode,bankamount having cnt > 1";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res1 = mysqli_fetch_array($exec1))

{						
		$rowsto_del = 0;
		$docno = $res1["docno"];
		$recordscount = $res1["cnt"];
		$rowsto_del = $recordscount - 1;

		$query2 = " delete from bank_record where docno='$docno' limit  $rowsto_del ";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$noof_deleted_rows = mysqli_affected_rows($GLOBALS["___mysqli_ston"]);
	
	$total_deleted_rows = $total_deleted_rows + $noof_deleted_rows;
echo $noof_deleted_rows." rows deleted for docno : ".$docno." <br>";

}

echo "Total $total_deleted_rows rows deleted ";
?>