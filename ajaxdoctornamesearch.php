<?php

include ("db/db_connect.php");

$searchdoctornamename1 = trim($_REQUEST['term']);
  
$a_json = array();
$a_json_row = array();

$query200 = "select doctorcode,doctorname from master_doctor where doctorname like '%$searchdoctornamename1%' and status <> 'deleted' order by doctorname limit 0,15";
$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res200 = mysqli_fetch_array($exec200))
{
	$res200doctorcode = $res200['doctorcode'];
	$res200doctorname = $res200['doctorname'];

	$doctorcode = $res200doctorcode;
	
	$res200doctorname = addslashes($res200doctorname);

	$res200doctorname = strtoupper($res200doctorname);
	
	$res200doctorname = trim($res200doctorname);
	
	$res200doctorname = preg_replace('/,/', ' ', $res200doctorname); // To avoid comma from passing on to ajax url.
	
	$doctorcode = addslashes($doctorcode);
	$res200doctorname = addslashes($res200doctorname);
	$a_json_row["doctorcode"] = $doctorcode;
	$a_json_row["doctorname"] = $res200doctorname;
	$a_json_row["value"] = trim($res200doctorname);
	$a_json_row["label"] = $res200doctorcode.'||'.$res200doctorname;
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>