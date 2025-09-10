<?php 
session_start();

include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly=date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$i=0;
$batchbuild = '';
//here get location code and store code
//$locationcode=$_REQUEST['locationcode'];
//$storecode=$_REQUEST["tostore22"];


 $itemcode=isset($_REQUEST['itemcode'])?$_REQUEST['itemcode']:'';
 $locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
 $storecode=isset($_REQUEST['tostore'])?$_REQUEST['tostore']:'';
 
 $loopcount = '0';
 
 $query44="select itemcode,batchnumber,companyanum from purchase_details where store='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode'";
$exec44=mysqli_query($GLOBALS["___mysqli_ston"], $query44);
$numb44=mysqli_num_rows($exec44);
while($res44=mysqli_fetch_array($exec44))
{
$i=0;
$itemcode = $res44['itemcode'];
$batchname = $res44['batchnumber']; 
$companyanum = $_SESSION["companyanum"];
$itemcode = $itemcode;
$batchname = $batchname;

include ('autocompletestockbatch.php');
$currentstock = $currentstock;		

if($batchbuild == '')
{
$batchbuild = $batchname.'||'.$currentstock.'||'.$itemcode .'';
}
else
{
$batchbuild = $batchbuild.','.$batchname.'||'.$currentstock.'||'.$itemcode .'';
}
}

echo 'Select Batch'.'||'.'0'.','.$batchbuild;

?>