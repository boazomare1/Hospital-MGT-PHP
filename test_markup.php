<?php
session_start();
set_time_limit(0);
//include ("includes/loginverify.php");
include ("db/db_connect.php");


$query2 = "select * from master_medicine where  status!='deleted' order by auto_number";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res1 = mysqli_fetch_array($exec2))
{

	$query = "SELECT margin FROM `pharma_template_map` WHERE `productcode`='".$res1['itemcode']."' and margin>0 order by auto_number desc limit 0,1";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res = mysqli_fetch_array($exec);
	$margin = $res["margin"]; 
    if($margin=='' || $margin==null || $margin==0)
		$margin=50;

	echo $query3 = "update master_medicine set markup='$margin' where  itemcode='".$res1['itemcode']."'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));


}