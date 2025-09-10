<?php

include ("db/db_connect.php");

 $process=$_REQUEST['term'];
 $item=isset($_REQUEST['itemcode'])?$_REQUEST['itemcode']:'';

 $itemsearch=isset($_REQUEST['itemsearch'])?$_REQUEST['itemsearch']:'';

// $storesearch=isset($_REQUEST['storesearch'])?$_REQUEST['storesearch']:'';
  $genericsearch=isset($_REQUEST['genericsearch'])?$_REQUEST['genericsearch']:'';
  
 // $genericcode=isset($_REQUEST['genericcode'])?$_REQUEST['genericcode']:'';



if($itemsearch<>'')
{
$a_json = array();
$a_json_row = array();
   $query1 = "select itemname,itemcode from master_medicine where  (itemname like '%$process%' or itemcode like'%$process%') GROUP BY itemcode limit 0,15";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$itemname = $res1['itemname'];
	$itemcode = $res1['itemcode'];
	
	$a_json_row["itemcode"] = trim($itemcode);
	$a_json_row["value"] = trim($itemname);
	$a_json_row["label"] = trim($itemname);
	
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);

}
if($genericsearch <>'')
{
	$a_json = array();
$a_json_row = array();
  $query1 = "select genericname,itemcode from master_medicine where genericname like '%$process%' GROUP BY genericname limit 0,15";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$genericname = $res1['genericname'];
	$itemcode = $res1['itemcode'];
	
	$a_json_row["genericname"] = trim($genericname);
	$a_json_row["genericcode"] = trim($itemcode);
	$a_json_row["value"] = trim($genericname);
	$a_json_row["label"] = trim($genericname);
	
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);

}


?>