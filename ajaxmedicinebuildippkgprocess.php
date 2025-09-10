<?php
session_start(); 
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION["username"];
$docno = $_SESSION['docno'];

$packageid = $_REQUEST['packageid'];
$searchmedicinename1 = $_REQUEST['searchmedicinename1'];
$subtypeano=isset($_REQUEST['subtype'])?$_REQUEST['subtype']:'';



$locationcode = $_REQUEST['searchlocation'];
$searchstore = $_REQUEST['searchstore'];
$stringbuild100='';

if($subtypeano=='')
{
$loccolumn = $locationcode.'_rateperunit';
}
else
{
	$loccolumn = 'subtype_'.$subtypeano;
}

$query75 = "select storecode from master_store where storecode='$searchstore'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$storecode = $res75['storecode'];

 $query200 = "select distinct(mm.itemcode),mm.itemname,mm.disease,mm.genericname,mm.pkg,mm.purchaseprice,mm.`$loccolumn` as rate from master_medicine mm inner join package_processing pp on mm.itemcode = pp.itemcode where mm.itemname like '%$searchmedicinename1%' and pp.package_id='$packageid' and pp.package_item_type ='MI' and pp.add_pkg_trackid='0' order by mm.itemname;";
$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res200 = mysqli_fetch_array($exec200))
{
	$res200itemcode = $res200['itemcode'];	
	$res200medicine = $res200['itemname'];
	$disease = $res200['disease'];
	$itemcode = $res200itemcode;
	$genericname = $res200['genericname'];
	$rateperunit = $res200['rate'];
	$rateperunit = $res200['purchaseprice'];
	$pkg = $res200['pkg'];
	$currentstock = '';

	$query57 = "select sum(batch_quantity) as currentstock from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1'";
	$res57=mysqli_query($GLOBALS["___mysqli_ston"], $query57);
	$exec57 = mysqli_fetch_array($res57);
	$currentstock = $exec57['currentstock'];

	if($currentstock>0) { 
	
	$res200medicine = addslashes($res200medicine);

	$res200medicine = strtoupper($res200medicine);
	
	$res200medicine = trim($res200medicine);
	
	$res200medicine = preg_replace('/,/', ' ', $res200medicine); // To avoid comma from passing on to ajax url.

	$stringbuild100 = ''.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'||'.$pkg.'||';

}
}
echo $stringbuild100;

	

?>