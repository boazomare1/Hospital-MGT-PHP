<?php
session_start();
include ("db/db_connect.php");

$autonumber = "subtype_".$_POST['autoid'];
$newcatrate = $_POST['subtypeval'];
$itemcode = $_POST['itemcode'];


$cdate = date("Y-m-d");

$query = "UPDATE `master_medicine` SET $autonumber = '".$newcatrate."' WHERE `master_medicine`.`itemcode` = '$itemcode'";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query);// or die ("Error in Query".mysql_error());
if($exec){
	echo "yes";  
}else{
	echo "no";
}

?>