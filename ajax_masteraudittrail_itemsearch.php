<?php
//session_start();
include ("db/db_connect.php");
$term = $_REQUEST['term'];
$pid = $_REQUEST['pid'];
$a_json = array();
$a_json_row = array();

$stringbuild1 = "";
if($pid=='1'){
 $query2 = "select * from master_medicine where  itemname like '%$term%'   order by itemname limit 0, 15";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2itemname = $res2['itemname'];	
	$res2itemname = preg_replace('/,/', ' ', $res2itemname); // To avoid comma from passing on to ajax url.
	$res2itemcode = $res2['itemcode'];
	
	
	
	
	
	
	$a_json_row["value"] = trim($res2itemname);
 
	$a_json_row["mobile"] = trim($res2itemcode);

    array_push($a_json, $a_json_row);
	
	
	
	
}

    }else if($pid=='4'){
	
	
	$query2 = "select * from master_services where  itemname like '%$term%'   order by itemname limit 0, 15";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2itemname = $res2['itemname'];	
	$res2itemname = preg_replace('/,/', ' ', $res2itemname); // To avoid comma from passing on to ajax url.
	$res2itemcode = $res2['itemcode'];
	
	
	
	
	
	
	$a_json_row["value"] = trim($res2itemname);
 
	$a_json_row["mobile"] = trim($res2itemcode);

    array_push($a_json, $a_json_row);
	
	
	
	
}
	
	}else if($pid=='3'){
	
	$query2 = "select * from master_radiology where  itemname like '%$term%'   order by itemname limit 0, 15";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2itemname = $res2['itemname'];	
	$res2itemname = preg_replace('/,/', ' ', $res2itemname); // To avoid comma from passing on to ajax url.
	$res2itemcode = $res2['itemcode'];
	
	
	
	
	
	
	$a_json_row["value"] = trim($res2itemname);
 
	$a_json_row["mobile"] = trim($res2itemcode);

    array_push($a_json, $a_json_row);
	
	
	
	
}
	
	}
	else if($pid=='2'){
	
	$query2 = "select * from master_lab where  itemname like '%$term%'   order by itemname limit 0, 15";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2itemname = $res2['itemname'];	
	$res2itemname = preg_replace('/,/', ' ', $res2itemname); // To avoid comma from passing on to ajax url.
	$res2itemcode = $res2['itemcode'];
	
	
	
	
	
	
	$a_json_row["value"] = trim($res2itemname);
 
	$a_json_row["mobile"] = trim($res2itemcode);

    array_push($a_json, $a_json_row);
	
	
	
	
}
	
	}

echo json_encode($a_json);
flush();


?>