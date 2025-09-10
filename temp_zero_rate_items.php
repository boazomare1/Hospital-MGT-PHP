<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');


?>


<body>
<?php

			$queryaa1 = "select itemcode from temp_zero_rate_items ";

			$execaa1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryaa1) or die ("Error in Queryaa1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($resaa1 = mysqli_fetch_array($execaa1))
			{
					$itemcode = $resaa1['itemcode'];

					$i=1;
					$query40 = "SELECT rate,entrydate,billnumber FROM `materialreceiptnote_details` WHERE itemcode = '$itemcode' order by itemcode,entrydate desc limit 0,2";
					$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
			        while($res40 = mysqli_fetch_array($exec40))
					{
						$rate = $res40['rate'];
						$entrydate = $res40['entrydate'];
						$billnumber = $res40['billnumber'];
						if($i==1){
							echo $query87="update temp_zero_rate_items set pd1='$entrydate',pr1='$rate',pdn1='$billnumber' where itemcode='$itemcode'";
						}else{

							echo $query87="update temp_zero_rate_items set pd2='$entrydate',pr2='$rate',pdn2='$billnumber' where itemcode='$itemcode'";
						}					
						$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die ("Error in query87".mysqli_error($GLOBALS["___mysqli_ston"]));
					$i++;
					}

					if($i==1){

						$query40 = "SELECT rate,entrydate,billnumber FROM `purchase_details` WHERE itemcode = '$itemcode' and billnumber like 'OPS-%' and rate !='0' order by itemcode,entrydate desc limit 0,1";
						$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
				        while($res40 = mysqli_fetch_array($exec40))
						{
							$rate = $res40['rate'];
							$entrydate = $res40['entrydate'];
							$billnumber = $res40['billnumber'];
							echo $query87="update temp_zero_rate_items set pd1='$entrydate',pr1='$rate',pdn1='$billnumber' where itemcode='$itemcode'";
							$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die ("Error in query87".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}


					$query40 = "SELECT purchaseprice FROM `master_medicine` WHERE itemcode = '$itemcode'";
					$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
			        while($res40 = mysqli_fetch_array($exec40))
					{
						$purchaseprice = $res40['purchaseprice'];
						$query87="update temp_zero_rate_items set master_price='$purchaseprice' where itemcode='$itemcode'";
						$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die ("Error in query87".mysqli_error($GLOBALS["___mysqli_ston"]));
					}

			}


	 ?>

</body>

</html>



