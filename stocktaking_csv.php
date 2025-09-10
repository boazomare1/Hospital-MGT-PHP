<?php
session_start();
include ("db/db_connect.php");
//include ("includes/loginverify.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"]; 
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
$locationcode = $location;
$storecode = $store;
$query778 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$storecode'");
$res778 = mysqli_fetch_array($query778);
$storename = $res778['store'];
$storename = str_replace(' ','_',$storename);
if (isset($_REQUEST["frmflag34"])) { $frmflag34 = $_REQUEST["frmflag34"]; } else { $frmflag34 = ""; }
?>
<?php
if($frmflag34 == 'frmflag34')
{
	$snocount=0;
	header("Content-Type: application/csv");
	header("Content-Disposition: attachment;Filename=".$storename.".csv");
	
	echo "S.No".',';
	echo "Store Code".',';
	echo "Item Code".',';
	echo "Item Name".',';
	echo "Rate".',';
	echo "Exp Date".',';
	echo "Batch".',';
	echo "Phy Qty".','."\n";
	$query02="select itemcode,prodtype FROM master_medicine  GROUP BY prodtype";
	$run02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
	while($exec02=mysqli_fetch_array($run02))
	{
		$prodtype1=$exec02['prodtype'];
		?>
		<?php
		$query01="select a.auto_number as auto_number,b.itemname as itemname,a.itemcode as itemcode,a.batch_quantity as batch_quantity,a.batchnumber as batchnumber,a.rate as rate,a.locationcode,a.storecode,b.prodtype as prodtype from transaction_stock a JOIN master_medicine b ON (a.itemcode=b.itemcode) where  a.storecode='".$storecode."' AND a.locationcode='".$locationcode."' AND a.batch_quantity > '0' AND a.batch_stockstatus ='1' AND b.prodtype='$prodtype1' group by a.batchnumber,a.itemcode order by a.itemname";
		$run01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
		while($exec01=mysqli_fetch_array($run01))
		{
			$medanum=$exec01['auto_number'];
			$itemname=$exec01['itemname'];
			$itemcode=$exec01['itemcode'];
			$batchnumber=$exec01['batchnumber'];
			$query03="select SUM(batch_quantity) as batch_quantity FROM transaction_stock WHERE itemcode='$itemcode' AND storecode='".$storecode."' AND locationcode='".$locationcode."' AND batch_quantity > '0' AND batch_stockstatus ='1' and batchnumber='$batchnumber'";
			$run03=mysqli_query($GLOBALS["___mysqli_ston"], $query03);
			$exec03=mysqli_fetch_array($run03);				
			$batch_quantity=$exec03['batch_quantity'];
			$query04="select expirydate FROM purchase_details WHERE itemcode='$itemcode' and batchnumber='$batchnumber' order by expirydate asc";
			$run04=mysqli_query($GLOBALS["___mysqli_ston"], $query04);
			$exec04=mysqli_fetch_array($run04);	
			$expirydate=$exec04['expirydate'];
			if($expirydate=='')
			{
				$query05="select expirydate FROM materialreceiptnote_details WHERE itemcode='$itemcode' and batchnumber='$batchnumber' order by expirydate asc";
				$run05=mysqli_query($GLOBALS["___mysqli_ston"], $query05);
				$exec05=mysqli_fetch_array($run05);	
				$expirydate=$exec05['expirydate'];
			}
			$rate=$exec01['rate'];
			$prodtype=$exec01['prodtype'];
			$sno=0;
			$snocount = $snocount + 1;
			echo $snocount.',';
			echo $storecode.',';
			echo $itemcode.',';
			echo $itemname.',';
			echo $rate.',';
			echo $expirydate.',';
			echo "'".$batchnumber.',';
			echo "0".','."\n";
		}
	}
}
?>
