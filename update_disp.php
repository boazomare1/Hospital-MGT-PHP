<?php
include ("db/db_connect.php");
$sno=1;
	$query211 = "SELECT * FROM `package_items` WHERE `package_id` = 132 and package_type='MI' and itemcode not in(SELECT itemcode FROM `package_processing` WHERE `visitcode` ='IPV-3038-4' and package_item_type='MI')";
	$exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die ("Error in Query211".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res211 = mysqli_fetch_array($exec211)){
	 $itemcode = $res211['itemcode'];
    $itemname = $res211['itemname'];
    $quantity = $res211['quantity'];
    $itemrate = $res211['rate'];
    $amount = $res211['amount'];
	echo $itemcode.' '.$itemname.' '.$quantity;
	echo '<br/>';

/*	
$serquery2="insert into package_processing(package_id,package_item_type,visitcode,itemcode,itemname,quantity,rate,amount)  values ('132','MI','IPV-3038-4','$itemcode','$itemname', '$quantity','$itemrate','$amount')";
$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $serquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"])); */
	}
?>