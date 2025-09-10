 <?php 
 session_start();

 include ("db/db_connect.php");

 $i=0;
$loopcontrol='1';
$itemcode=isset($_REQUEST['q'])?$_REQUEST['q']:'';
$locationcode=isset($_REQUEST['loc'])?$_REQUEST['loc']:'';
$storecode=isset($_REQUEST['sto'])?$_REQUEST['sto']:'';
$res1medicinename=isset($_REQUEST['strm'])?$_REQUEST['strm']:'';
$subtypeano=isset($_REQUEST['subtypeano'])?$_REQUEST['subtypeano']:'';
$res1fifo_code=isset($_REQUEST['fifo_code'])?$_REQUEST['fifo_code']:'';
?>

<?php
$rate = 0;
$query57 = "select itemcode,batchnumber,batch_quantity,description,fifo_code,rate from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1' and fifo_code='$res1fifo_code'";
 $query57;
$res57=mysqli_query($GLOBALS["___mysqli_ston"], $query57);
$num57=mysqli_num_rows($res57);
while($exec57 = mysqli_fetch_array($res57))
{
$batchname = $exec57['batchnumber']; 

//$query57q = "select sum(batch_quantity) as batch_quantity from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1' and batchnumber='$batchname'";
 $query57q;
//$res57q=mysql_query($query57q);
//$exec57q = mysql_fetch_array($res57q);


 //$rate=$exec57['rate']; 
$companyanum = $_SESSION["companyanum"];
$itemcode = $itemcode;
if($subtypeano=='')
{
$loccolumn = $locationcode.'_rateperunit';
}
else
{
	$loccolumn = 'subtype_'.$subtypeano;
}
$query7 = "select `$loccolumn` as rate from master_medicine where itemcode = '$itemcode'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$rate = $res7['rate'];

	//include ('autocompletestockbatch.php');
$currentstock = $exec57["batch_quantity"];
$fifo_code = $exec57["fifo_code"];
/* $query66 ="SELECT count(availableqty) as avl FROM tempmedicineqty WHERE medicinecode='".$itemcode."' and batchname = '".$batchname."'";		
		$exec66 = mysql_query($query66) or die(mysql_error());
		$res66 = mysql_fetch_array($exec66);
		$availableqty = $res66['avl'];
		if($availableqty > 0 && $availableqty!='')
		{
			//$currentstock=$currentstock-$availableqty;
		}*/
		$currentstock=''.$currentstock.'||'.$rate.'||';
echo $currentstock;
 } ?>
