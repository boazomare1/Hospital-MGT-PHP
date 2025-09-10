<?php
session_start();
include ("db/db_connect.php");
$posearch = $_REQUEST["posearch"];

//$medicinesearch = strtoupper($medicinesearch);
$searchresult5 = "";
$posearch = trim($posearch);
$query5 = "select * from purchaseorder_details where billnumber = '$posearch' and recordstatus='generated' order by billnumber";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res5 = mysqli_fetch_array($exec5))
{
	$billnum = $res5["billnumber"];
	$suppliername = $res5['suppliername'];
	$suppliercode = $res5['suppliercode'];
    $suppliername = strtoupper($suppliername);
    $billdate = $res5['billdate'];
	
	$query66 = "select * from master_supplier where suppliercode='$suppliercode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$addressname = $res66['address1'];
$address = $addressname;
$addressname1 = $res66['address2'];
if($addressname1 != '')
{
$address = $address.','.$addressname1;
}
$area = $res66['area'];
if($area != '')
{
$address = $address.','.$area;
}
$city = $res66['city'];
if($city !='')
{
$address = $address.','.$city;
}
$state = $res66['state'];
if($state !='')
{
$address = $address.','.$state;
}
$country = $res66['country'];
if($country !='')
{
$address = $address.','.$country;
}
$telephone2 = $res66['mobilenumber'];
$tele=$telephone2;
$telephone = $res66['phonenumber1'];
if($telephone != '')
{
$tele=$tele.','.$telephone;
}
$telephone1 = $res66['phonenumber2'];
if($telephone1 != '')
{
$tele=$tele.','.$telephone1;
}
	
	
	if ($searchresult5 == '')
	{
	    $searchresult5 = ''.$billnum.'||'.$suppliername.'||'.$billdate.'||'.$address.'||'.$tele.'||';
	}
	else
	{
		$searchresult5 = $searchresult5.'||^||'.$billnum.'||'.$suppliername.'||'.$billdate.'||'.$address.'||'.$tele.'||';
	}
	
}
if ($searchresult5 != '')
{
 echo $searchresult5;
}
?>