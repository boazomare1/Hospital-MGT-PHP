<?php


session_start();
include ("db/db_connect.php");



$searchmedicinename1 = trim($_REQUEST['term']);



$a_json = array();

$a_json_row = array();

$strchk="";

$companyanum = $_SESSION['companyanum'];
$username = $_SESSION["username"];

$stocks = '';
$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	$res12locationanum = $res["auto_number"];

$storebuild = "''";

$storecode = 'STO2';


$query200 = "select itemcode,itemname,disease,`rateperunit` from master_medicine where (itemname like '%$searchmedicinename1%' or disease like '%$searchmedicinename1%' or genericname like '%$searchmedicinename1%') and categoryname not in ('MEDICAL SUPPLIES','GENERAL STORES') and status <> 'deleted' order by itemname";

$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res200 = mysqli_fetch_array($exec200))

{

	$res200itemcode = $res200['itemcode'];

	$res200medicine = $res200['itemname'];

	$disease = $res200['disease'];

	$itemcode = $res200itemcode;

	$rateperunit = $res200['rateperunit'];

	

	$res200medicine = addslashes($res200medicine);



	$res200medicine = strtoupper($res200medicine);

	

	$res200medicine = trim($res200medicine);

	

	$res200medicine = preg_replace('/,/', ' ', $res200medicine); // To avoid comma from passing on to ajax url.

	

	$disease = str_replace (',',' ',$disease);

	

	$medicinecode = addslashes($itemcode);

	$res200medicine = addslashes($res200medicine);

	$currentstock = '';

	$query57 = "select sum(batch_quantity) as currentstock from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1'";
	
	$res57=mysqli_query($GLOBALS["___mysqli_ston"], $query57);
	$exec57 = mysqli_fetch_array($res57);
	$currentstock = $exec57['currentstock'];
//$currentstockurl =10;
	$a_json_row["medicinecode"] = $medicinecode;

	$a_json_row["value"] = trim($res200medicine);
	$a_json_row["stk"] = trim($currentstock);
	
	$a_json_row["label"] = $res200itemcode.'||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.'||'.$rateperunit;

	array_push($a_json, $a_json_row);

}

//echo $stringbuild1;

echo json_encode($a_json);

?>