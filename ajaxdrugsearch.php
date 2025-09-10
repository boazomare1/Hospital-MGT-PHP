<?php


session_start();
include ("db/db_connect.php");



$searchmedicinename1 = trim($_REQUEST['term']);
$genericname = $_REQUEST['genericname'];


$a_json = array();

$a_json_row = array();

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
				$query23 = "SELECT b.storecode,b.store,a.defaultstore from master_employeelocation as a join master_store as b on a.storecode=b.auto_number where a.username='$username' and a.locationcode='$locationcode' and defaultstore = 'default'";
				$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num_rows = mysqli_num_rows($exec23);
				if($num_rows > 0)
				{
				  
				 	$res23 = mysqli_fetch_array($exec23);
					$storecode = trim($res23['storecode']);
				}
				if(trim($storecode)=="")
				{
					$storecode = 'STO2';
				}
if($genericname=='0')
{
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


	$a_json_row["medicinecode"] = $medicinecode;

	$a_json_row["value"] = trim($res200medicine);
	
	$a_json_row["stk"] = trim($currentstock);

	$a_json_row["label"] = $res200itemcode.'||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.'||'.$rateperunit;

	array_push($a_json, $a_json_row);

}

}
else
{
	
$query200 = "select genericname,itemcode,itemname,disease,`rateperunit` from master_medicine where genericname like '%$searchmedicinename1%' and categoryname not in ('MEDICAL SUPPLIES','GENERAL STORES') and status <> 'deleted' order by itemname";

$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res200 = mysqli_fetch_array($exec200))

{

    $res200genericname = $res200['genericname'];

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


	$a_json_row["medicinecode"] = $medicinecode;

	$a_json_row["value"] = trim($res200medicine);
	
	$a_json_row["stk"] = trim($currentstock);  

	$a_json_row["label"] = $res200medicine.'||'.$res200genericname.' ||'.$currentstock.' ||'.$disease.'||'.$rateperunit;

	array_push($a_json, $a_json_row);

}


}
//echo $stringbuild1;

echo json_encode($a_json);

?>