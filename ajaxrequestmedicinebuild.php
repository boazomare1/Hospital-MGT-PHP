<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION['username'];
$searchmedicinename1 = $_REQUEST['searchmedicinename1'];
$typetransfer = $_REQUEST['typetransfer'];
if(isset($_REQUEST['status']))
{
  $status=$_REQUEST['status'];
}
else
{
  $status='';   
}
$strtype = "and transfertype = 0";
if($typetransfer == 'Consumable')
{
$strtype = "and transfertype = 1";
}
//echo $strtype;
$strtype='';

$stringbuild1 = "";
/*$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];*/
/*$query23 = "select * from master_employeelocation where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['locationcode'];
$locationcode=$res23['locationcode'];


$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['storecode'];*/
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$tolocation=isset($_REQUEST['tolocation'])?$_REQUEST['tolocation']:'';
$storecode=isset($_REQUEST['storecode'])?$_REQUEST['storecode']:'';

$query222 = "select * from master_medicine where itemname like '%$searchmedicinename1%' ".$strtype." and status <> 'Deleted' limit 0,100";
$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res222 = mysqli_fetch_array($exec222))
{
	$res2itemcode = $res222['itemcode'];
	$res2medicine = $res222['itemname'];
	$disease = $res222['disease'];
	$res2type = $res222['type'];
	$itemcode = $res2itemcode;
	
	
		if($res2type=='DRUGS'){
		$query = "select b.store,b.storecode from master_location as a join master_store as b on a.drugs_store=b.storecode where a.locationcode='$locationcode' ";
		$exec=mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res = mysqli_fetch_array($exec);
		$fromstorename = $res["store"];
		$fromstore=$storecode=$fromstorecode = $res["storecode"];
		
		$query1 = "select b.store,b.storecode from master_location  as a join master_store as b on a.drugs_store=b.storecode where a.locationcode='$tolocation' ";
		$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$tostore = $res1["store"];
		$tostorecode = $res1["storecode"];
		}elseif($res2type=='NON DRUGS'){
		$query = "select b.store,b.storecode from master_location  as a join master_store as b on a.nondrug_store=b.storecode where a.locationcode='$locationcode' ";
		$exec=mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res = mysqli_fetch_array($exec);
		$fromstorename = $res["store"];
		$fromstore=$storecode=$fromstorecode = $res["storecode"];
		
		$query1 = "select b.store,b.storecode from master_location  as a join master_store as b on a.nondrug_store=b.storecode where a.locationcode='$tolocation' ";
		$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$tostore = $res1["store"];
		$tostorecode = $res1["storecode"];
		}elseif($res2type=='ASSETS'){
		$query = "select b.store,b.storecode from master_location  as a join master_store as b on a.asset_store=b.storecode where a.locationcode='$locationcode' ";
		$exec=mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res = mysqli_fetch_array($exec);
		$fromstorename = $res["store"];
		$fromstore=$storecode=$fromstorecode = $res["storecode"];
		
		$query1 = "select b.store,b.storecode from master_location  as a join master_store as b on a.asset_store=b.storecode where a.locationcode='$tolocation' ";
		$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$tostore = $res1["store"];
		$tostorecode = $res1["storecode"];	
		}
	
	
	
	
	
	include ('autocompletestockcount1include1.php');
	 $currentstock = $currentstock;
	if(($status=='consumption')&&($currentstock<=0))
	{
	    //echo $status.$currentstock;
	 $stringbuild1='';   
	}else
	{
	$res2medicine = addslashes($res2medicine);

	$res2medicine = strtoupper($res2medicine);
	
	$res2medicine = trim($res2medicine);
	
	
	$res2medicine = preg_replace('/,/', ' ', $res2medicine); // To avoid comma from passing on to ajax url.
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$res2itemcode.' ||'.$res2medicine.' ||'.$currentstock.' ||'.$fromstorename.' ||'.$fromstorecode.' ||'.$tostore.' ||'.$tostorecode.'';
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$res2itemcode.' ||'.$res2medicine.' ||'.$currentstock.' ||'.$fromstorename.' ||'.$fromstorecode.' ||'.$tostore.' ||'.$tostorecode.'';
	}
	}
}

echo $stringbuild1;



?>