<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$querybatstock23 = "select * from stock_track ";
$execbatstock23 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock23) or die ("Error in batQuery3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($resbatstock23 = mysqli_fetch_array($execbatstock23))
{
	
	$resitemcode=$resbatstock23['itemcode'];
	//$store=$resbatstock23['store'];
	//$resitemcode='PRDIN00269';
	$store='STO2';

	$querybatstock2 = "select fifo_code from transaction_stock where  itemcode='$resitemcode'  and storecode ='$store' GROUP BY fifo_code";
	$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($resbatstock2 = mysqli_fetch_array($execbatstock2))
	{
		$runningtotal=0;
		$fifo_code = $resbatstock2["fifo_code"];

            $sql1="SELECT storecode,itemcode,itemname,sum(IF(transactionfunction='0',-1*transaction_quantity,transaction_quantity)) as quantity FROM `transaction_stock` where itemcode='$resitemcode'  and storecode ='$store' AND fifo_code ='$fifo_code' group by itemcode,storecode HAVING quantity!=0";
			$sql1 = mysqli_query($GLOBALS["___mysqli_ston"], $sql1) or die ("Error in sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$getval = mysqli_fetch_array($sql1);
			 $fun1=$getval["quantity"];
			

			$sql2="SELECT storecode,itemcode,itemname,sum(batch_quantity) as quantity FROM `transaction_stock` WHERE batch_stockstatus='1' and itemcode='$resitemcode'  and storecode ='$store' AND fifo_code ='$fifo_code' group by itemcode,storecode";
			$sql2 = mysqli_query($GLOBALS["___mysqli_ston"], $sql2) or die ("Error in sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$getval2 = mysqli_fetch_array($sql2);
			$fun2=$getval2["quantity"];


			$totaldiff=$fun1-$fun2;	
			
        if($totaldiff!=0){
		$querybatstock3 = "select auto_number,itemname,transaction_quantity,batch_quantity,transactionfunction from transaction_stock where  itemcode='$resitemcode'  and storecode ='$store' AND fifo_code ='$fifo_code' ";
		$execbatstock3 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock3) or die ("Error in batQuery3".mysqli_error($GLOBALS["___mysqli_ston"]));	
		$numLab1 = mysqli_num_rows($execbatstock3);
		$k=0;
		while($resbatstock3 = mysqli_fetch_array($execbatstock3))
		{
			



			            $itemname = $resbatstock3["itemname"];
						$transactionquantity = $resbatstock3["transaction_quantity"];
						$batchquantity = $resbatstock3["batch_quantity"];
						$transactionfunction = $resbatstock3["transactionfunction"];
						$auto_number = $resbatstock3["auto_number"];

			if($totaldiff<0 && $k==0){
                $transactionquantity=$transactionquantity+abs($totaldiff);
				$batchquantity=$batchquantity+abs($totaldiff);

				echo $updatebatchqty = "UPDATE transaction_stock SET transaction_quantity = '$transactionquantity',batch_quantity = '$batchquantity' WHERE  auto_number = '$auto_number' ";
				$execbatchqty = mysqli_query($GLOBALS["___mysqli_ston"], $updatebatchqty) or die ("Error in updatebatchqty".mysqli_error($GLOBALS["___mysqli_ston"]));

			}

			if($totaldiff>0 && $numLab1==1){

				echo $updatebatchqty = "UPDATE transaction_stock SET  batch_stockstatus = '1'  WHERE  auto_number = '$auto_number' ";
				$execbatchqty = mysqli_query($GLOBALS["___mysqli_ston"], $updatebatchqty) or die ("Error in updatebatchqty".mysqli_error($GLOBALS["___mysqli_ston"]));

			}
			
						if($transactionfunction == 0){
							$runningtotal = $runningtotal - $transactionquantity;
						}
						else{
							$runningtotal = $runningtotal + $transactionquantity;
						}

						if($runningtotal != $batchquantity){

							 echo $updatebatchqty = "UPDATE transaction_stock SET batch_quantity = '$runningtotal' WHERE itemcode = '$resitemcode' AND fifo_code = '$fifo_code' AND storecode ='$store' AND auto_number = '$auto_number' ";
						$execbatchqty = mysqli_query($GLOBALS["___mysqli_ston"], $updatebatchqty) or die ("Error in updatebatchqty".mysqli_error($GLOBALS["___mysqli_ston"]));
						echo '<br>';
						echo '<br>'; 
			   						
						 echo $updatebatchqty2 = "UPDATE transaction_stock SET  batch_stockstatus = '1' WHERE itemcode = '$resitemcode' AND fifo_code = '$fifo_code' AND storecode ='$store' AND batch_quantity > 0 ORDER BY auto_number DESC LIMIT 1";
						$execbatchqty2 = mysqli_query($GLOBALS["___mysqli_ston"], $updatebatchqty2) or die ("Error in updatebatchqty2".mysqli_error($GLOBALS["___mysqli_ston"]));
						echo '<br>';
						echo '<br>'; 
						
						echo $updatebatchqty3 = "UPDATE transaction_stock SET  batch_stockstatus = '0' WHERE itemcode = '$resitemcode' AND fifo_code = '$fifo_code' AND storecode ='$store' AND batch_quantity > 0  AND  auto_number  != (SELECT MAX(auto_number) FROM (SELECT auto_number FROM transaction_stock WHERE itemcode = '$resitemcode' AND fifo_code = '$fifo_code' AND storecode ='$store') AS a)";
						$execbatchqty3 = mysqli_query($GLOBALS["___mysqli_ston"], $updatebatchqty3) or die ("Error in updatebatchqty3".mysqli_error($GLOBALS["___mysqli_ston"]));

						}

						$k++;
						
		}
		}
	}
}

?>