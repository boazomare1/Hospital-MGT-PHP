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



//here get location code and store code

 $locationcode=$_REQUEST['locationcode'];

$storecode=$_REQUEST["tostore22"];

//$storecode=$_REQUEST['storecode'];

/*$query23 = "select * from master_employee where username='$username'";

$exec23 = mysql_query($query23) or die(mysql_error());

$res23 = mysql_fetch_array($exec23);

$res7locationanum = $res23['location'];



$query55 = "select * from master_location where auto_number='$res7locationanum'";

$exec55 = mysql_query($query55) or die(mysql_error());

$res55 = mysql_fetch_array($exec55);

$location = $res55['locationname'];



$res7storeanum = $res23['store'];*/



/*$query75 = "select * from master_store where auto_number='$res7storeanum'";

$exec75 = mysql_query($query75) or die(mysql_error());

$res75 = mysql_fetch_array($exec75);

$store = $res75['store'];*/

//$financialyear = $_SESSION["financialyear"];



if (isset($_REQUEST["batch"])) { $batch = $_REQUEST["batch"]; } else { $batch = ""; }

if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }

if (isset($_REQUEST["serial1"])) { $serial1 = $_REQUEST["serial1"]; } else { $serial1 = ""; }

if (isset($_REQUEST["tostore22"])) { $tostore22 = $_REQUEST["tostore22"]; } else { $tostore22 = ""; }

//$billnumber=$_REQUEST["billnumber"];



$store = $tostore22;

$query2 = "select expirydate,costprice,fifo_code from purchase_details where recordstatus = '' and fifo_code = '$batch' and itemcode='$itemcode'";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$num2 = mysqli_num_rows($exec2);

if($num2>0)

{

 $res2 = mysqli_fetch_array($exec2);

 $expirydate = $res2['expirydate'];

 $fifo_code = $res2['fifo_code'];

}

else

{

 $query2 = "select expirydate,costprice,fifo_code from materialreceiptnote_details where recordstatus = '' and fifo_code = '$batch' and itemcode='$itemcode'";

 $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

 $num2 = mysqli_num_rows($exec2);

 $res2 = mysqli_fetch_array($exec2);

 $expirydate = $res2['expirydate'];

 $fifo_code = $res2['fifo_code'];

}

$batchname = $batch;

	//include ('autocompletestockbatch.php');

$querybatstock2 = "select batch_quantity,rate from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode' and fifo_code='$batchname' and storecode ='$storecode'";
$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

$resbatstock2 = mysqli_fetch_array($execbatstock2);

$bat_quantity = $resbatstock2["batch_quantity"];
$costprice=$resbatstock2['rate'];

$currentstock = 0;

$qrystore="SELECT `expense_ledger` FROM `master_store` WHERE `storecode`='$storecode' ";

$exestore = mysqli_query($GLOBALS["___mysqli_ston"], $qrystore) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

$resstore = mysqli_fetch_array($exestore);
$expenseledgercode = $resstore['expense_ledger'];

$qrycost="SELECT accountname FROM master_accountname WHERE id='$expenseledgercode' ";

$execost = mysqli_query($GLOBALS["___mysqli_ston"], $qrycost) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

$rescost = mysqli_fetch_array($execost);

//$costprice=$rescost['purchaseprice'];

//$expenseledgercode = $rescost['expenseledgercode'];

$expenseledgername = $rescost['accountname'];

/////////////// sum of batches /////////////
 $querycumstock2 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode' and storecode='$storecode' and batchnumber in(select batchnumber from purchase_details where expirydate>now() and itemcode ='$itemcode')";
	$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rescumstock2 = mysqli_fetch_array($execcumstock2);
	$all_batches_quantity = $rescumstock2["cum_quantity"];
/////////////// sum of batches /////////////
echo $expirydate.'||'.$bat_quantity.'||'.$costprice.'||'.$serial1.'||'.$expenseledgercode.'||'.$expenseledgername.'||'.$all_batches_quantity;

?>

