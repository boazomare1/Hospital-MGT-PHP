<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$docno = $_SESSION['docno'];

$mrp = '0.00';

if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
//$itemcode = $_REQUEST["itemcode"];
if (isset($_REQUEST["batchnumber"])) { $batchnumber = $_REQUEST["batchnumber"]; } else { $batchnumber = ""; }
//echo $batchnumber = $_REQUEST["batchnumber"];
if (isset($_REQUEST["rateapplyfrom"])) { $rateapplyfrom = $_REQUEST["rateapplyfrom"]; } else { $rateapplyfrom = ""; }
//$rateapplyfrom = $_REQUEST["rateapplyfrom"];
if (isset($_REQUEST["customercode"])) { $customercode = $_REQUEST["customercode"]; } else { $customercode = ""; }
//$customercode = $_REQUEST["customercode"];
$locationcode = $_REQUEST["locationcode"];
$storecode = isset($_REQUEST["storecode"])?$_REQUEST["storecode"]:'';

$i = 0;
$stringbuild1 = '';
$query231 = "select ms.storecode from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.username='$username' AND me.locationcode='$locationcode'";
$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res231 = mysqli_fetch_array($exec231))
{
  $storecode = $res231['storecode'];
 

 $query41="select * from purchase_details where itemcode='$itemcode' AND locationcode='$locationcode' AND store = '".$storecode."'";
 
	$query41 .=" group by batchnumber";
			$exec41=mysqli_query($GLOBALS["___mysqli_ston"], $query41);
			$numb41=mysqli_num_rows($exec41);
			while($res41=mysqli_fetch_array($exec41))
			{
				
//			$query23 = "select * from master_employee where username='$username'";
//			$exec23 = mysql_query($query23) or die(mysql_error());
//			$res23 = mysql_fetch_array($exec23);
//			$res7locationanum = $res23['location'];
//
//$query55 = "select * from master_location where auto_number='$res7locationanum'";
//$exec55 = mysql_query($query55) or die(mysql_error());
//$res55 = mysql_fetch_array($exec55);
//$location = $res55['locationname'];
//
//$res7storeanum = $res23['store'];



/*$query75 = "select * from master_store where locationcode='$locationcode'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
*/ $storecode = $res231['storecode'];
			$batchname = $res41['batchnumber']; 
			$companyanum = $_SESSION["companyanum"];
			$itemcode = $itemcode;
			$batchname = $batchname;
	include ('autocompletestockbatch.php');
	$currentstock = $currentstock;
	
	
	if($currentstock != 0 )
	{
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$citemcode.' || '.$citemname.' || '.$citemstock.'"';
		//$stringbuild1 = '"'.$citemcode.' || '.$citemname. '"'; //.' || '.$citemstock.'"';
		$stringbuild1 = $batchname.'('.$storecode; //.' || '.$citemstock.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.'||'.$batchname.'('.$storecode;
	}
}
}
}
echo $stringbuild1;

?>