<?php
// 

//session_start();
include ("db/db_connect.php");


/**
 * Calculate an update rate
 * @var $tempcode, $markup, $username
 * @return true
 *
 * tempcode, item code , rate
 * check company rule master_company  add column pharmacyformula
 */
function updaterate($tempcode,$markup){
	$margin = $markup;
	$tempid = $tempcode;
	$username = $_SESSION["username"];
	$ipaddress = $_SERVER["REMOTE_ADDR"];
    
	// Select pharmacyformula from master_company
	$query_formula = "SELECT pharmacyformula FROM master_company";
	$exec_formula = mysqli_query($GLOBALS["___mysqli_ston"], $query_formula) or die ("Error in Query_formula".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res_formula = mysqli_fetch_array($exec_formula)){
		//
		$pharmacyformula = $res_formula['pharmacyformula'];
	}
    
    //check type of margin
    if($pharmacyformula == '1'){
    	//Fixed
    	# UPDATE PHARMA RATE TEMPLATE
    	return true;

    }elseif($pharmacyformula == '2'){
    	// Margin
    	if($margin > 0){
			//Get all medicine from master_medicine
			$query_med = "SELECT * FROM master_medicine WHERE status <> 'deleted'";
			$exec_med = mysqli_query($GLOBALS["___mysqli_ston"], $query_med) or die ("Error in Query_med".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_med = mysqli_fetch_array($exec_med)){
				$item_id = $res_med['itemcode'];
				$item_price = (float)$res_med['purchaseprice'];

				$var_price = (($margin / 100) * $item_price);
				$new_price = ($item_price + $var_price);

				$date= date("Y-m-d");

				//insert new row in template rate mapping
				$sqlquerymap= "INSERT INTO pharma_template_map(templateid, productcode, rate, username,dateadded, recordstatus, margin, ipaddress) VALUES ('$tempid','$item_id','$new_price','$username','$date','','$margin','$ipaddress')";
				//echo $sqlquerymap.'<br>';
				$exequerymap = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquerymap);

				//check subtypes linked // if any update values
				$array_subtype = array();
				$query_st = "SELECT auto_number FROM master_subtype WHERE pharmtemplate = '$tempid' ";
				$exec_st = mysqli_query($GLOBALS["___mysqli_ston"], $query_st) or die ("Error in Query_st".mysqli_error($GLOBALS["___mysqli_ston"]));
				$count=0;
				$col = "";
				//var_dump($res_st);
				while($res_st = mysqli_fetch_assoc($exec_st)){
					$count++;
					$subtype = $res_st['auto_number'];

					if($count > 1){
						$col .=',';
					}

					$col .= 'subtype_'.$subtype." = ".$new_price;

				}
				// update master med
				$sqlquery_st_med= "UPDATE master_medicine SET $col WHERE itemcode = '$item_id'";
				//echo $col.'<br>';
				//echo $sqlquery_st_med.'<br>';
			    $exequery_st_med = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquery_st_med);
			}
		}

		return true;
    }
	
	//sreturn "ok";
}
?>

<?php

/*
echo  "<h1>TEST</h1>";
$test = updaterate(1,25);
if($test){
	echo "all good";
}*/

?>