<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

foreach($_POST['docno'] as $key => $value)
{
$docno = $_POST['docno'][$key];

$query33 = "select * from purchase_indent where docno='$docno'";
$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res33 = mysqli_fetch_array($exec33))
{
$itemname = $res33['medicinename'];
$itemcode = $res33['medicinecode'];
$quantity = $res33['quantity'];
$rate = $res33['rate'];
$amount = $res33['amount'];
 
  $query45 = "select * from master_itemtosupplier where itemcode='$itemcode'";
  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $res45 = mysqli_fetch_array($exec45);
  $suppliername=$res45['suppliername'];
  $suppliercode=$res45['suppliercode'];


$paynowbillprefix = 'PO-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query3 = "select * from purchaseorder_details order by auto_number desc limit 0, 1";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num3 = mysqli_num_rows($exec3);
if($num3 >0)
{
$query2 = "select * from purchaseorder_details where suppliercode='$suppliercode' and purchaseindentdocno='$docno' order by auto_number desc limit 0, 1";
}
else
{
$query2 = "select * from purchaseorder_details order by auto_number desc limit 0, 1";
}
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	
	$query27 = "select * from purchaseorder_details where suppliercode='$suppliercode' and purchaseindentdocno='$docno' order by auto_number desc limit 0, 1";
	$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$num27 = mysqli_num_rows($exec27);
	if($num27>0)
	{
	$billnumbercode = $billnumbercode;
	}
	else
	{
	$billnumbercode = $billnumbercode + 1;
     }
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
$query56="insert into purchaseorder_details(companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username, ipaddress, billdate,purchaseindentdocno,suppliername,suppliercode)
          values('$companyanum','$billnumbercode','$itemcode','$itemname','$rate','$quantity','$amount','$username','$ipaddress','$currentdate','$docno','$suppliername','$suppliercode')";
$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		  
}
}

header("location:consolidateindents.php");


?>