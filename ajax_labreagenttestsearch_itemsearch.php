<?php
//session_start();
include ("db/db_connect.php");
$term = $_REQUEST['term'];
$term = trim($term);
$pid = $_REQUEST['pid'];
$a_json = array();
$a_json_row = array();

$stringbuild1 = "";
if($pid=='1'){


	
	$query222 = "select * from master_lablinking where itemname like '%$term%' and recordstatus <> 'Deleted' group by itemcode";
$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res222 = mysqli_fetch_array($exec222))
{
	$res2itemcode = $res222['itemcode'];
	$res2medicine = $res222['itemname'];
	//$disease = $res222['disease'];
	//$itemcode = $res2itemcode;
	//include ('autocompletestockcount1include1.php');
	//$currentstock = 0;
	
	$res2medicine = addslashes($res2medicine);

	$res2medicine = strtoupper($res2medicine);
	
	$res2medicine = trim($res2medicine);
	
	$res2medicine = preg_replace('/,/', ' ', $res2medicine); // To avoid comma from passing on to ajax url.
	
	$a_json_row["value"] = trim($res2medicine);
 
	$a_json_row["mobile"] = trim($res2itemcode);

    array_push($a_json, $a_json_row);
}

	
}else if($pid=='2'){

 $query1 = "select * from master_lablinking where recordstatus <> 'Deleted'  and  labname like '%$term%'  group by labcode";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec1);
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1itemcode = $res1['labcode'];
	$res1labname = $res1['labname'];
	
	
	$res1labname = addslashes($res1labname);

	$res1labname = strtoupper($res1labname);
	
	$res1labname = trim($res1labname);
	
	$res1labname = preg_replace('/,/', ' ', $res1labname); // To avoid comma from passing on to ajax url.
	
	$a_json_row["value"] = trim($res1labname);
 
	$a_json_row["mobile"] = trim($res1itemcode);

    array_push($a_json, $a_json_row);
	
}	
	
	
}
	
echo json_encode($a_json);
flush();


?>