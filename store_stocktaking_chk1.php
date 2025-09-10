<?php
@session_start();
error_reporting(0);
include_once ("db/db_connect.php");
$stocktake_err="Stock Take in process. Transactions are Frozen.";
//$query_stocktaking = "select storecode from master_store  where locationcode = '".$locationcode."' and storecode='".$storecode."' and is_freeze=1";
$query_stocktaking = "select storecode from master_store  where storecode='".$storecode."' and is_freeze=1";
$exec_stocktaking = mysqli_query($GLOBALS["___mysqli_ston"], $query_stocktaking) or die ("Error in query_stocktaking".mysqli_error($GLOBALS["___mysqli_ston"]));
$num_stocktaking = mysqli_num_rows($exec_stocktaking); 

?>