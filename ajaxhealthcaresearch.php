<?php
//session_start();
include ("db/db_connect.php");

$search_text = trim($_REQUEST['term']);

$stringbuild1 = "";
$a_json = array();
$a_json_row = array();

$stringbuild1 = "";
 $query1 = "select itemname,itemcode from master_services where status <> 'Deleted' and itemname like '%$search_text%'  AND rateperunit <> 0 and wellnesspkg = 'yes' and itemcode not in (select servicecode from healthcarepackagelinking where recordstatus <> 'deleted' group by servicecode) order by itemname limit 0,50";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec1);
while ($res1 = mysqli_fetch_array($exec1))
{
	$itemname=$res1['itemname'];
	$itemcode=$res1['itemcode'];

	$a_json_row["itemname"] = $itemname;
	$a_json_row["itemcode"] = $itemcode;
	$a_json_row["value"] = $itemname;
	$a_json_row["label"] = $itemcode.' || '.$itemname;
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>