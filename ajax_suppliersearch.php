<?php

header('Content-Type: application/json');

include ("db/db_connect.php");



if (isset($_REQUEST["term"])) { $coasearch = $_REQUEST["term"]; } else { $term = ""; }





$query2 = "select * from master_accountname where accountssub IN ('12') and accountname like '%$coasearch%' and recordstatus <> 'deleted' order by accountname";

$searchresult = array();

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))

{

	$data['id'] = $res2["id"];

	$data['auto_number'] = $res2["auto_number"];

	$data['name'] = $res2["accountname"];

	$data['value'] = $res2["accountname"];

	array_push($searchresult, $data);

}



if (count($searchresult)>0)

{

	echo json_encode($searchresult);

}



?>