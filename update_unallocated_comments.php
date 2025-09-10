<?php

session_start();

include ("db/db_connect.php");

$sno = $_REQUEST['sno'];
$docno=$_REQUEST['docno'];
$unallocated_remarks=$_REQUEST['unallocated_remarks'];
$query1 = "update  master_transactionpaylater set unallocated_remarks='$unallocated_remarks' where docno='$docno' and transactionstatus='onaccount' ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));



?>

