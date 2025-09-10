<?php
session_start();
include ("db/db_connect.php");
$errmsg1 = '';
$errmsg2 = '';
$errmsg3 = '';

$query43 = "select * from purchase_details";
$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res43 = mysqli_fetch_array($exec43))
{

$itemcode = $res43['itemcode'];
$rate = $res43['rate'];
$receivedqty = $res43['quantity'];
$billnumber = $res43['billnumber'];

$totalamount = $receivedqty * $rate;

$query24 = "update purchase_details set subtotal='$totalamount',totalamount='$totalamount' where itemcode='$itemcode' and billnumber='$billnumber'";
$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}


$query43 = "select * from purchase_details where typeofpurchase='Process'";
$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res43 = mysqli_fetch_array($exec43))
{

$itemcode = $res43['itemcode'];
$rate = $res43['rate'];
$billnumber = $res43['billnumber'];
$packagename = $res43['packagename'];
$packagename1 = strlen($packagename);
$packsize = substr($packagename,0,$packagename1-1);
$costprice = $rate / $packsize;

$query24 = "update purchase_details set costprice='$costprice' where itemcode='$itemcode' and billnumber='$billnumber'";
$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$query241 = "update master_medicine set purchaseprice='$costprice' where itemcode='$itemcode'";
$exec241 = mysqli_query($GLOBALS["___mysqli_ston"], $query241) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$query241 = "update master_itempharmacy set purchaseprice='$costprice' where itemcode='$itemcode'";
$exec241 = mysqli_query($GLOBALS["___mysqli_ston"], $query241) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


}

$query23 = "select * from purchase_details where typeofpurchase='Process'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res23 = mysqli_fetch_array($exec23))
{

$itemcode = $res23['itemcode'];
$costprice = $res23['costprice'];

$query231 = "select * from master_medicine where itemcode='$itemcode'";
$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res231 = mysqli_fetch_array($exec231);
$spmarkup = $res231['spmarkup'];

$salespriceamount = ($costprice * $spmarkup)/100;
$salesprice = $costprice + $salespriceamount;

$query24 = "update purchase_details set salesprice='$salesprice' where itemcode='$itemcode' and costprice='$costprice'";
$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$query241 = "update master_medicine set rateperunit='$salesprice' where itemcode='$itemcode'";
$exec241 = mysqli_query($GLOBALS["___mysqli_ston"], $query241) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$query241 = "update master_itempharmacy set rateperunit='$salesprice' where itemcode='$itemcode'";
$exec241 = mysqli_query($GLOBALS["___mysqli_ston"], $query241) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


}

?>
