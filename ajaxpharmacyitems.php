 <?php

include ("db/db_connect.php");

$searchmedicinename1 = trim($_REQUEST['term']);
$action = trim($_REQUEST['action']);

$a_json = array();
$a_json_row = array();
if($action == 'item'){
 $query200 = "select itemname from master_medicine where (itemname like '%$searchmedicinename1%' )  order by itemname ";
$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res200 = mysqli_fetch_array($exec200))
{

	 $res200medicine = $res200['itemname'];

	$res200medicine = addslashes($res200medicine);
	$res200medicine = strtoupper($res200medicine);
	$res200medicine = trim($res200medicine);
	$res200medicine = preg_replace('/,/', ' ', $res200medicine); // To avoid comma from passing on to ajax url.

	$res200medicine = addslashes($res200medicine);
	$a_json_row["value"] = trim($res200medicine);
	$a_json_row["label"] = $res200medicine;
	array_push($a_json, $a_json_row);

}

//echo $stringbuild1;
}
if($action == 'category'){
 $query200 = "select categoryname from master_medicine where (categoryname like '%$searchmedicinename1%' ) GROUP BY categoryname order by categoryname ";
$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res200 = mysqli_fetch_array($exec200))
{

	 $res200medicine = $res200['categoryname'];

	$res200medicine = addslashes($res200medicine);
	$res200medicine = strtoupper($res200medicine);
	$res200medicine = trim($res200medicine);
	$res200medicine = preg_replace('/,/', ' ', $res200medicine); // To avoid comma from passing on to ajax url.

	$res200medicine = addslashes($res200medicine);
	$a_json_row["value"] = trim($res200medicine);
	$a_json_row["label"] = $res200medicine;
	array_push($a_json, $a_json_row);

}

//echo $stringbuild1;
}if($action == 'generic'){
 $query200 = "select genericname from master_medicine where (genericname like '%$searchmedicinename1%' )  GROUP BY genericname order by genericname LIMIT 0,20";
$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res200 = mysqli_fetch_array($exec200))
{

	 $res200medicine = $res200['genericname'];

	$res200medicine = addslashes($res200medicine);
	$res200medicine = strtoupper($res200medicine);
	$res200medicine = trim($res200medicine);
	$res200medicine = preg_replace('/,/', ' ', $res200medicine); // To avoid comma from passing on to ajax url.

	$res200medicine = addslashes($res200medicine);
	$a_json_row["value"] = trim($res200medicine);
	$a_json_row["label"] = $res200medicine;
	array_push($a_json, $a_json_row);

}

//echo $stringbuild1;
}

echo json_encode($a_json);
?>