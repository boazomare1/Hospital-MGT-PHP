<?php
include ("includes/loginverify.php");
include ("db/db_connect.php");
 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$totalsum = "0.00";
$snocount = "";
?>

<?php
	$colorloopcount=0;
	$sno=0;
?>
            <?php
			//$totalbalance = 0.00;
			$sno = 0;
			$cashamount21 = 0.00;
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$writeoffamount21 = '';
		    $totalrefundedamount=0;
			$totalnumbr='';
			$totalnumb=0;
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalpurchase1=0;
			$bal='0';
			$ipdaysafterbilldate='';
			
			if($visitcode != '')
			{
				$query3 = "select * from master_transactionpaylater where transactiontype = 'finalize' and visitcode = '$visitcode' and companyanum='$companyanum' and recordstatus <>'deallocated'";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numbr=mysqli_num_rows($exec3);
				$res3 = mysqli_fetch_array($exec3);
				
				
				
				    /*$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					$cashamount21 = $cashamount21 + $cashamount1;
					
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;*/
					$billno = $res3['billnumber'];
					$totalbalance += $res3['transactionamount'];
					
					
					if($billno != '')
					{
						$query4 = "select * from master_transactionpaylater where transactionmodule = 'PAYMENT' and transactionstatus <> 'onaccount' and billnumber = '$billno' and companyanum='$companyanum' and recordstatus <>'deallocated'";
						$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
						$numbr=mysqli_num_rows($exec4);
						while($res4 = mysqli_fetch_array($exec4))
						{					
						$totalbalance = $totalbalance - $res4['transactionamount'];
						}
					}
					$ipbilldate = $res4['transactiondate'];
					$ipbilldate = substr($ipbilldate, 0, 10);
					$date1 = $ipbilldate;
					$date1 = $date1;
					$date2 = date("Y-m-d");  
					$diff = abs(strtotime($date2) - strtotime($date1));  
					$days = floor($diff / (60*60*24));  
					$ipdaysafterbilldate = $days;
					
				
			}
			 
			
					 
			
			?>
