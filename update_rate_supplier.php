<?php

session_start();

include ("db/db_connect.php");

$get_rate = $_REQUEST['get_rate'];
$supplier_get=$_REQUEST['supplier_get'];
$medicine_code=$_REQUEST['medicine_code'];

$query1 = "update  master_itemmapsupplier set rate='$get_rate' where suppliercode='$supplier_get' and itemcode='$medicine_code'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));



?>

