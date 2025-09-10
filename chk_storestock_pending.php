<?php
include ("db/db_connect.php");
$docno=isset($_REQUEST['docno'])?$_REQUEST['docno']:'';
$query5 = "select b.store,b.storecode from store_stock_doc as a, master_store as b where a.storecode=b.auto_number and a.docno = '".$docno."' ";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$storecode = $res5["storecode"];
$pendingitem=0;
$query12 = "select a.auto_number,a.itemcode,a.itemname,a.categoryname from master_medicine as a JOIN transaction_stock as b ON a.itemcode = b.itemcode where b.storecode='$storecode' and a.itemcode not in(select itemcode from stocktaking_realtime  where docno='$docno')  group by a.itemcode";
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res12 = mysqli_fetch_array($exec12))
{

$itemcode = $res12['itemcode'];
$itemname = $res12["itemname"];

$query77 = "select batchnumber from transaction_stock where itemcode='$itemcode' and storecode='$storecode' group by batchnumber";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res77 = mysqli_fetch_array($exec77))
	{
	   $batchnumber = $res77['batchnumber'];

	   $query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and storecode='$storecode' and batchnumber = '$batchnumber' and transactionfunction='1'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$currentstock1 = $res1['currentstock'];

		$query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and storecode='$storecode' and batchnumber = '$batchnumber' and transactionfunction='0'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$currentstock2 = $res1['currentstock'];

		$currentstock= $currentstock1-$currentstock2;
		if($currentstock>0){
          $pendingitem=$pendingitem+1;
		}
	}
	if($pendingitem>0)
		break;
}
echo $pendingitem;
?>