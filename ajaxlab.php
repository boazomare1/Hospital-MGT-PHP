<?php
include ("db/db_connect.php");
$tb = $_POST['tb'];
$item = $_POST['labcode'];

$qry1 = "select itemname,rateperunit from $tb where itemcode = '$item' and status <> 'deleted' group by itemcode";
$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $qry1);
$res1=mysqli_fetch_assoc($exec1);
echo addslashes($res1['itemname']).'#'.$res1['rateperunit'];

?>