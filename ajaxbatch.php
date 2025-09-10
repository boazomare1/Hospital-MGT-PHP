 <?php 
 session_start();

 include ("db/db_connect.php");
 $i=0;
 $j=1;
$loopcontrol='1';
$itemcode=isset($_REQUEST['q'])?$_REQUEST['q']:'';
$locationcode=isset($_REQUEST['loc'])?$_REQUEST['loc']:'';
$storecode=isset($_REQUEST['sto'])?$_REQUEST['sto']:'';
$res1medicinename=isset($_REQUEST['strm'])?$_REQUEST['strm']:'';
$l=isset($_REQUEST['l'])?$_REQUEST['l']:'';
$qry1='';
?>

<?php
if($l!='')
{
$qry1="and a.fifo_code not in(select fifo_code from tempmedicineqty where medicinekey in(select medicinekey from tempmedicineqty where auto_number = $l))";
}
//$res1medicinename="PARACETAMOL BP 500MG TABS";
$query35=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_itempharmacy where itemname='$res1medicinename'");
$exec35=mysqli_fetch_array($query35);
if($itemcode == '')
{
$itemcode=$exec35['itemcode'];
}
/*$query36=mysql_query("select * from purchase_details where itemname='$res1medicinename'");
$exec36=mysql_fetch_array($query36);
$batch=$exec36['batchnumber'];
$query38 = mysql_query("select * from purchase_details where itemname='$res1medicinename' ");
$rowcount=mysql_num_rows($query38);*/

/*$query57 = "select itemcode,batchnumber,batch_quantity,description,fifo_code from (
            select a.itemcode as itemcode,a.batchnumber as batchnumber,a.batch_quantity as batch_quantity,a.description as description,a.fifo_code as fifo_code from transaction_stock a join materialreceiptnote_details b on (a.batchnumber = b.batchnumber and a.itemcode = b.itemcode and b.expirydate >now()) where a.storecode='".$storecode."'  AND a.itemcode = '$itemcode' and a.batch_stockstatus='1' and a.batch_quantity>0 

			UNION ALL select a.itemcode as itemcode,a.batchnumber as batchnumber,a.batch_quantity as batch_quantity,a.description as description,a.fifo_code as fifo_code from transaction_stock a join purchase_details b on (a.batchnumber = b.batchnumber and a.itemcode = b.itemcode) where a.storecode='".$storecode."'  AND a.itemcode = '$itemcode' and a.batch_stockstatus='1' and b.expirydate >now() and a.batch_quantity>0) as batchl where batch_quantity>0"; */

			$query57 = "select itemcode,batchnumber,sum(batch_quantity) as batch_quantity,description,fifo_code from transaction_stock where storecode='".$storecode."'  AND itemcode = '$itemcode' and batch_stockstatus='1' and batch_quantity >0 and TRIM(batchnumber in(select TRIM(batchnumber) from materialreceiptnote_details where expirydate>now() and itemcode ='$itemcode') or TRIM(batchnumber in(select TRIM(batchnumber) from purchase_details where expirydate>now() and itemcode ='$itemcode'))) group by batchnumber,fifo_code order by fifo_code desc";


			

$res57=mysqli_query($GLOBALS["___mysqli_ston"], $query57);
$num57=mysqli_num_rows($res57);
 $num57;?>


<?php
while($exec57 = mysqli_fetch_array($res57))
{
//if($loopcontrol != 'stop')
if(true)
{
  $batchname = $exec57['batchnumber']; 
  $batchname = $exec57['batchnumber']; 
 $fifo_code = $exec57["fifo_code"];
$companyanum = $_SESSION["companyanum"];
			$itemcode = $itemcode;
			$batchname = $batchname;
	//include ('autocompletestockbatch.php');
	$currentstock = $exec57["batch_quantity"];
	
	 $availableqty=0;
	 /*$query66 ="SELECT count(availableqty) as avl FROM tempmedicineqty WHERE medicinecode='".$itemcode."' and batchname = '".$batchname."'";		
		$exec66 = mysql_query($query66) or die(mysql_error());
		$res66 = mysql_fetch_array($exec66);
		$availableqty = $res66['avl'];
		if($availableqty > 0 && $availableqty!='')
		{
			$currentstock=$currentstock-$availableqty;
		}*/
		
	?>
    <option value="<?php echo $batchname,'((',$fifo_code;?>" selected="selected"><?php echo $batchname.'('.$fifo_code.')','(',$currentstock,')';?></option>
	
	  <?php
	  $loopcontrol='stop';
	if($currentstock > 0 )
	{
//$totalstock = $totalstock+$currentstock;
/*if($totalstock >= $res1quantity)
{

$issuequantity = $res1quantity-$oldstock;
}
 else
 {
 $issuequantity = $currentstock;
 $oldstock = $oldstock+$currentstock;

 $pending=$res1quantity-$oldstock;

 }	*/
 $res1medicinename1=$res1medicinename;
 /*if($oldmedicinename == $res1medicinename)
 {
 $res1medicinename1='';
 $res1dose='';
 $res1frequency='';
 $res1days='';
 
 }*/
 $oldmedicinename=$res1medicinename;
 }
 }
 } $loopcontrol=1;?>
