 <?php 
 session_start();

 include ("db/db_connect.php");

 $i=0;
$loopcontrol='1';
$itemcode=isset($_REQUEST['q'])?$_REQUEST['q']:'';
$locationcode=isset($_REQUEST['loc'])?$_REQUEST['loc']:'';
$storecode=isset($_REQUEST['sto'])?$_REQUEST['sto']:'';
$res1medicinename=isset($_REQUEST['strm'])?$_REQUEST['strm']:'';
$res1fifo_code=isset($_REQUEST['fifo_code'])?$_REQUEST['fifo_code']:'';
?>

<?php

$query57 = "select itemcode,batchnumber,batch_quantity,description,fifo_code from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1' and fifo_code='$res1fifo_code'";
 $query57;
$res57=mysqli_query($GLOBALS["___mysqli_ston"], $query57);
$num57=mysqli_num_rows($res57);
while($exec57 = mysqli_fetch_array($res57))
{
$batchname = $exec57['batchnumber']; 
  $batchname = $exec57['batchnumber']; 
 $batchname;
$companyanum = $_SESSION["companyanum"];
$itemcode = $itemcode;
$batchname = $batchname;
	//include ('autocompletestockbatch.php');
$currentstock = $exec57["batch_quantity"];
$fifo_code = $exec57["fifo_code"];
 $query66 ="SELECT count(availableqty) as avl FROM tempmedicineqty WHERE medicinecode='".$itemcode."' and batchname = '".$batchname."'";		
		$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res66 = mysqli_fetch_array($exec66);
		$availableqty = $res66['avl'];
		if($availableqty > 0 && $availableqty!='')
		{
			$currentstock=$currentstock-$availableqty;
		}
echo $currentstock;
 } ?>