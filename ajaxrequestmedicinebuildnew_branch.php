<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION['username'];

$docno = $_SESSION['docno'];
$action = $_REQUEST['action'];
$a_json = array();
$a_json_row = array();
$stringbuild1 = "";


if($action=='medicinesearch')
{
	$searchmedicinename1 = $_REQUEST['term'];
	$typetransfer = $_REQUEST['typetransfer'];
	$fromlocation = $_REQUEST['fromlocation'];
	$tolocation = $_REQUEST['tolocation'];

	$query222 = "select itemcode,itemname,type from master_medicine where itemname like '%$searchmedicinename1%' and status <> 'Deleted' limit 0,10";
	$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res222 = mysqli_fetch_array($exec222))
	{
		$res2itemcode = $res222['itemcode'];
		$res2medicine = $res222['itemname'];
		$res2type = $res222['type'];
		$itemcode = $res2itemcode;
		
		if($res2type=='DRUGS'){
		$query = "select b.store,b.storecode from master_location as a join master_store as b on a.drugs_store=b.storecode where a.locationcode='$fromlocation' ";
		$exec=mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res = mysqli_fetch_array($exec);
		$fromstore = $res["store"];
		$fromstorecode = $res["storecode"];
		
		$query1 = "select b.store,b.storecode from master_location  as a join master_store as b on a.drugs_store=b.storecode where a.locationcode='$tolocation' ";
		$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$tostore = $res1["store"];
		$tostorecode = $res1["storecode"];
		}elseif($res2type=='NON DRUGS'){
		$query = "select b.store,b.storecode from master_location  as a join master_store as b on a.nondrug_store=b.storecode where a.locationcode='$fromlocation' ";
		$exec=mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res = mysqli_fetch_array($exec);
		$fromstore = $res["store"];
		$fromstorecode = $res["storecode"];
		
		$query1 = "select b.store,b.storecode from master_location  as a join master_store as b on a.nondrug_store=b.storecode where a.locationcode='$tolocation' ";
		$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$tostore = $res1["store"];
		$tostorecode = $res1["storecode"];
		}elseif($res2type=='ASSETS'){
		$query = "select b.store,b.storecode from master_location  as a join master_store as b on a.asset_store=b.storecode where a.locationcode='$fromlocation' ";
		$exec=mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res = mysqli_fetch_array($exec);
		$fromstore = $res["store"];
		$fromstorecode = $res["storecode"];
		
		$query1 = "select b.store,b.storecode from master_location  as a join master_store as b on a.asset_store=b.storecode where a.locationcode='$tolocation' ";
		$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$tostore = $res1["store"];
		$tostorecode = $res1["storecode"];	
		}
		
			
		$res2medicine = addslashes($res2medicine);
		$res2medicine = strtoupper($res2medicine);
		$res2medicine = trim($res2medicine);
		//$res2medicine = preg_replace('/,/', ' ', $res2medicine); // To avoid comma from passing on to ajax url.
		$a_json_row["itemcode"] = $res2itemcode;
		$a_json_row["fromstore"] = $fromstore;
		$a_json_row["fromstorecode"] = $fromstorecode;
		$a_json_row["tostore"] = $tostore;
		$a_json_row["tostorecode"] = $tostorecode;
		$a_json_row["value"] = trim($res2medicine);
		$a_json_row["label"] = trim($res2itemcode).'#'.$res2medicine;
		array_push($a_json, $a_json_row);
		
	}
	
	echo json_encode($a_json);
}
else if($action=='medicineqty')
{
	$storecode = $_REQUEST["storecode"];
	$location = $_REQUEST["location"];
	$itemcode = $_REQUEST["itemcode"];
	 $querycumstock2 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$location' and storecode='$storecode' and batchnumber in(select batchnumber from purchase_details where expirydate>now() and itemcode ='$itemcode' union all SELECT batchnumber FROM `materialreceiptnote_details` WHERE expirydate>now() and itemcode ='$itemcode')";
	$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rescumstock2 = mysqli_fetch_array($execcumstock2);
	$cum_quantity = $rescumstock2["cum_quantity"];
	$currentstock=intval($cum_quantity);
	echo $currentstock = $currentstock;
}

?>