<?php
include ("db/db_connect.php");
$tb = $_POST['tb'];
$pkg = $_POST['pkg'];
$item = $_POST['labcode'];
$pkgcrg = 'No';
$qry1 = "select itemname,rateperunit from $tb where itemcode = '$item' and status <> 'deleted' group by itemcode";
$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $qry1);
$res1=mysqli_fetch_assoc($exec1);
if($pkg == 1)
{
$qry2 = "select pkg from master_lab where itemcode = '$item' and status <> 'deleted' group by itemcode";
$exec2=mysqli_query($GLOBALS["___mysqli_ston"], $qry2);
$res2=mysqli_fetch_assoc($exec2);
if($res2['pkg']=='yes')
{
$pkgcrg = 'Yes';
}
}

echo addslashes($res1['itemname']).'#'.$res1['rateperunit'].'#'.$pkgcrg;

?>