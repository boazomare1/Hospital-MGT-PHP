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


$query44="select itemcode,batchnumber,batch_quantity,description,fifo_code from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1'";
$exec44=mysqli_query($GLOBALS["___mysqli_ston"], $query44);
$numb44=mysqli_num_rows($exec44);
while($res44=mysqli_fetch_array($exec44))
{
$i=0;
$itemcode = $res44['itemcode'];
$batchname = $res44['batchnumber']; 
$currentstock = $res44["batch_quantity"];
$itemcode = $itemcode;
$batchname = $batchname;
$description = $res44["description"];
$fifo_code = $res44["fifo_code"];
if($description=='OPENINGSTOCK')
{
	$color='#cbdbfa';
}
else
{
	$color='#FFFFFF';
}
//$currentstock = $currentstock;		

if($currentstock != 0 )
{
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$citemcode.' || '.$citemname.' || '.$citemstock.'"';
		//$stringbuild1 = '"'.$citemcode.' || '.$citemname. '"'; //.' || '.$citemstock.'"';
		$stringbuild1 = $currentstock.','.$batchname; //.' || '.$citemstock.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.'||'.$currentstock.','.$batchname.'';
	}
}
}
echo 'Select Batch'.'||'.$stringbuild1;

?>