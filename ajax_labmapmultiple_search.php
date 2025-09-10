<?php
//session_start();
include ("db/db_connect.php");
$term = $_REQUEST['term'];

$pid = $_REQUEST['pid'];
$pid = trim($pid);
$a_json = array();
$a_json_row = array();

$stringbuild1 = "";

$query222 = "select itemcode,categoryname,itemname,rateperunit,sampletype from master_lab  where itemname like '%$term%' and status <> 'deleted' and externallab = 'yes'  order by itemname";
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

	
echo json_encode($a_json);
flush();


?>