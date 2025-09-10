<?php
 session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION["username"];
$searchmedicinename1 = $_GET['term'];
$stocks = '';
$stringbuild100 = "";
$docno = $_SESSION['docno'];

$a_json = array();
$a_json_row = array();


$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationcode = $res["locationcode"];
$ratecolumn = $locationcode.'_rateperunit';
$query200 = "select itemcode,itemname,disease,genericname,pkg,`$ratecolumn` from master_medicine where (itemname like '%$searchmedicinename1%' or disease like '%$searchmedicinename1%' or genericname like '%$searchmedicinename1%') and status <> 'deleted' order by itemname limit 10";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))
{
	$itemcode = $res2["itemcode"];
	$itemname = $res2["itemname"];
    $itemname = strtoupper($itemname);
	$disease = $res2["disease"];
	$genericname = $res2['genericname'];
	$rateperunit = $res2[$locationcode.'_rateperunit'];

	
	$itemname = addslashes($itemname);

	$itemname = strtoupper($itemname);
	
	$itemname = trim($itemname);
	
	$itemname = preg_replace('/,/', ' ', $itemname); // To avoid comma from passing on to ajax url.
	
	$disease = str_replace (',',' ',$disease);

	
		$a_json_row["itemcode"] = $itemcode;
		$a_json_row["itemname"] = $itemname;
		$a_json_row["rateperunit"] = $rateperunit;
		$a_json_row["disease"] = $disease;
		$a_json_row["genericname"] = $genericname;
				
		$a_json_row["label"] = "".$itemcode." || ".$itemname." || ".$disease." || ".$rateperunit;
		$a_json_row["value"] = $itemname;

	array_push($a_json, $a_json_row);
}

     echo json_encode($a_json); 
?>