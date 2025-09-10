<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$sno = '';
$snocount = '';
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$filename='stock_taking_csv_'.date('d_m_Y');
header("Content-Type: application/csv");
header("Content-Disposition: attachment;Filename=".$filename.".csv");
header('Cache-Control: max-age=0');
?>
        <?php
				if (isset($_REQUEST["cbfrmflag12"])) { $cbfrmflag12 = $_REQUEST["cbfrmflag12"]; } else { $cbfrmflag12 = ""; }
				
				if ($cbfrmflag12 == 'cbfrmflag12')
				{
						 $locationcode = $_REQUEST['location'];
					     $storecode = $_REQUEST['store']; 



// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
		  $query02="select itemcode,prodtype FROM master_medicine  GROUP BY prodtype";
			$run02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
			while($exec02=mysqli_fetch_array($run02))
			{
			$prodtype1=$exec02['prodtype'];
		  $query01="select a.auto_number as auto_number,a.itemname as itemname,a.itemcode as itemcode,a.batch_quantity as batch_quantity,a.batchnumber as batchnumber,a.rate as rate,a.locationcode,a.storecode,b.prodtype as prodtype from transaction_stock a JOIN master_medicine b ON (a.itemcode=b.itemcode) where  a.storecode='".$storecode."' AND a.locationcode='".$locationcode."' AND a.batch_quantity > '0' AND a.batch_stockstatus ='1' AND b.prodtype='$prodtype1' group by a.batchnumber order by a.itemname";
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
			 echo $itemcode.',';
			 echo $itemname.',';
			 echo $expirydate.',';
			 echo $batchnumber."\n";

			
			}
			}
		  }
 

