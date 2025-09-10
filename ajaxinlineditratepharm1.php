<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$itemcode = $_POST['itemcode'];

$date = date("Y-m-d");

$tempData = html_entity_decode($_POST['arr']);

$content = json_decode($tempData, true);

foreach($content as $key => $value) {
	$tempid = $value['tempid'];
	$rate = $value['rate'];
	$rate = str_replace( ',', '', $rate );
	$itemmargin = $value['itemmargin'];

	//echo $rate.'<br>';
	//Get template rate markup %
	$query0 = "SELECT * from pharma_rate_template WHERE auto_number='$tempid'";
	$exec0 = mysqli_query($GLOBALS["___mysqli_ston"], $query0) or die ("Error in Query0".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res0 = mysqli_fetch_assoc($exec0)){
		$markup = $res0['markup'];
	}
    
    if($markup > 0){
    	// calc new rate
    	$query01 = "SELECT * from master_medicine WHERE itemcode='$itemcode'";
		$exec01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01) or die ("Error in Query0".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res01 = mysqli_fetch_assoc($exec01)){
			$pprice = $res01['purchaseprice'];
		}
    	$rate_perc = (($itemmargin/100)* $pprice);
    	$new_rate = ($pprice + $rate_perc);
    }else{
    	$new_rate = $rate;
    }
	$new_rate=ceil($new_rate);
	// insert data to pharma rate mapping tbl
	$query1 = "INSERT INTO pharma_template_map(templateid, productcode, rate, username,dateadded, recordstatus,margin,ipaddress) VALUES ('$tempid','$itemcode','$new_rate','$username','$date','','$itemmargin','$ipaddress')";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query3 = "UPDATE master_medicine SET markup = '$itemmargin' WHERE itemcode = '$itemcode'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	// get all subtype auto_no from master_subtypes where row matches temp id
	$arr = array();
	$query2 = "SELECT * from master_subtype WHERE pharmtemplate='$tempid'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res2 = mysqli_fetch_assoc($exec2))
	{   
		$auto_no= $res2['auto_number'];
		array_push($arr, $auto_no);
	}

	// update medicine table
	if(is_array($arr)){
		foreach ($arr as $key => $value) {
			//echo $value.'<br>';
			$col = 'subtype_'.$value;
			$query3 = "UPDATE master_medicine SET $col = '$new_rate' WHERE itemcode = '$itemcode'";
			//echo $query3;
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}

}

echo "yes";

?>