<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION["username"];

$itemcode = $_POST['itemcode'];
$rate = $_POST['rate'];
$templateautocode = $_POST['tempcode'];


$date = date("Y-m-d");


$query341 = "SELECT * FROM pharma_template_map where templateid='$templateautocode' and productcode='$itemcode'";
 $exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
 $res341 = mysqli_fetch_array($exec341);
 $rowcount341 = mysqli_num_rows($exec341);
 if($rowcount341 > 0)
 {
 	// exists
 	// update
    $query = "UPDATE pharma_template_map SET rate = '$rate' WHERE productcode = '$itemcode' and templateid = '$templateautocode'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query);// or die ("Error in Query".mysql_error());
	if($exec){
		echo "yes";  
	}else{
		echo "no";
	}

 }else{
 	// not exists
 	// insert    
    $query1 = "INSERT INTO pharma_template_map(templateid, productcode, rate, username,dateadded, recordstatus) VALUES ('$templateautocode','$itemcode','$rate','$username','$date','')";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);// or die ("Error in Query".mysql_error());
	if($exec1){
		echo "yes";  
	}else{
		echo "no";
	}
 }



?>