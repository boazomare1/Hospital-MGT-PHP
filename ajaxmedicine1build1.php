<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION["username"];

$searchmedicinename1 = $_REQUEST['searchmedicinename1'];
$stocks = '';
$stringbuild100 = "";

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	$res12locationanum = $res["auto_number"];
	
$query55 = "select * from master_location where auto_number='$res12locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];

$query23 = "select * from master_employeelocation where username='$username' and locationcode = '$locationcode' and defaultstore = 'default'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['locationanum'];


$query55 = "select * from master_location where locationcode='$locationcode'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['storecode'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);

$storecode = $res75['storecode'];

$ratecolumn = $locationcode.'_rateperunit';
$query200 = "select itemcode,itemname,disease,genericname,type,pkg,`$ratecolumn` from master_medicine where (itemname like '%$searchmedicinename1%' or disease like '%$searchmedicinename1%' or genericname like '%$searchmedicinename1%') and categoryname not in ('MEDICAL SUPPLIES','GENERAL STORES') and status <> 'deleted' order by itemname";
$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res200 = mysqli_fetch_array($exec200))
{
	$res200itemcode = $res200['itemcode'];
	$res200medicine = $res200['itemname'];
	$disease = $res200['disease'];
	$itemcode = $res200itemcode;
	$genericname = $res200['genericname'];
	$rateperunit = $res200[$locationcode.'_rateperunit'];
	$res2type = $res200['type'];
	
	$query6 = "select shownostockitems from master_company where auto_number = '$companyanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$stocks = $res6['shownostockitems'];
	
	
			if($res2type=='DRUGS'){
			$query1 = "select b.store,b.storecode from master_location  as a join master_store as b on a.drugs_store=b.storecode where a.locationcode='$locationcode' ";
			$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$storecode = $res1["storecode"];
			}elseif($res2type=='NON DRUGS'){
			$query1 = "select b.store,b.storecode from master_location  as a join master_store as b on a.nondrug_store=b.storecode where a.locationcode='$locationcode' ";
			$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$storecode = $res1["storecode"];
			}elseif($res2type=='ASSETS'){
			$query1 = "select b.store,b.storecode from master_location  as a join master_store as b on a.asset_store=b.storecode where a.locationcode='$locationcode' ";
			$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$storecode = $res1["storecode"];	
			}
	
	//$currentstock = $currentstock;
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
	
	$disease = str_replace (',',' ',$disease);
	
	$stocks = 'yes';
	if($stocks == 'NO')
	{
		if($currentstock > 0)
		{
			if ($stringbuild100 == '')
			{
				//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = ''.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'';
			}
			else
			{
				//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = $stringbuild100.','.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'';
			}
		}
	}
	else
	{
			if ($stringbuild100 == '')
			{
				//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = ''.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'';
			}
			else
			{
				//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = $stringbuild100.','.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'';
			}
	}
	}
}

echo $stringbuild100;



?>
