<?php

include ("db/db_connect.php");

	$sno=1;
	$t=1;
	$query = "SELECT * FROM transaction_stock where entrydocno='ADJ-154' group by auto_number order by auto_number asc";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res = mysqli_fetch_array($exec))
	{
	    $red_rows=0;
		$auto_number=$res['auto_number'];
		$itemcode=$res['itemcode'];
		$itemname=$res['itemname'];
		$fifo_code=$res['fifo_code'];
		$batchnumber=$res['batchnumber'];
		$batch_quantity=$res['batch_quantity'];
		$batch_stockstatus=$res['batch_stockstatus'];
		$storecode=$res['storecode'];
		
		
		
		$query1 = "SELECT * FROM transaction_stock where fifo_code='$fifo_code' and entrydocno!='ADJ-155' and itemcode='$itemcode' and storecode='$storecode' and auto_number>'$auto_number' group by auto_number order by auto_number asc";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$below_rows = mysqli_num_rows($exec1);
			if($below_rows<=0)
			{
				/*if(($batch_quantity>0)&&($batch_stockstatus==0))
				{
				echo $sno++.'--'.$fifo_code.'//'.$itemcode.'//'.$batchnumber.'//'.$batch_quantity.'//'.$batch_stockstatus.'update';
				echo '<br/>';
			
					$query4 = "DELETE FROM transaction_stock  where itemcode='$itemcode' and fifo_code='$fifo_code'and entrydocno='ADJ-155' ";
                    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
				$queryupdatecumstock2 = "update transaction_stock set batch_stockstatus='1' where itemcode='$itemcode' and fifo_code='$fifo_code' and auto_number='$auto_number'";
				mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
				}*/
			}else
			{ ?>
				
		        <?php 
		$m=0;
			
    			while($res1 = mysqli_fetch_array($exec1))
    			{
    				$auto_num=$res1['auto_number'];
    				$entrydocno=$res1['entrydocno'];
    				$transaction_quantity=$res1['transaction_quantity'];
    				$transactionfunction=$res1['transactionfunction'];
    				
    				$querybatstock2 = "SELECT batch_quantity FROM transaction_stock where fifo_code='$fifo_code' and entrydocno!='ADJ-155' and itemcode='$itemcode' and storecode='$storecode' and auto_number<'$auto_num' order by auto_number desc limit 1";
    
    				$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    				$resbatstock2 = mysqli_fetch_array($execbatstock2);
    				if($m==0){
    				$prev_quantity1 = $resbatstock2["batch_quantity"];
    				}
    				if($transactionfunction=='1')
    				{
    				$preset_qty1=$prev_quantity1+$transaction_quantity;
    				}
    				if($transactionfunction=='0')
    				{
    				$preset_qty1=$prev_quantity1-$transaction_quantity;
    				}
    			
    				
    				if($preset_qty1<0)
    				{
    				$red_rows++;
    				}
    			
    				$prev_quantity1=$preset_qty1;
    				$m++;
             }
             
    			if($red_rows>0)
    			{
    			    ?>
    			    <html>
    			    <table border="1">
    			        <tr>
    			            <td><?php echo $t++;?></td>
    			            <td>
        			 <?php echo $itemname; ?>
        			 </td>	<td>
        		<?php echo $batchnumber; ?>
        		
        			</td> </tr>
        			 </table>
        			 </html>
        		   	<?php
        		
        			$l=0;
        			$n=1;
        			//print_r($exec1);
        			$query99 = "SELECT * FROM transaction_stock where fifo_code='$fifo_code' and entrydocno!='ADJ-155' and itemcode='$itemcode' and storecode='$storecode' and auto_number>'$auto_number' group by auto_number order by auto_number asc";
		            $exec99 = mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		            	$row_count = mysqli_num_rows($exec99);
        			while($res2 = mysqli_fetch_array($exec99))
        			{
        				 $auto_num=$res2['auto_number'];
        				$entrydocno=$res2['entrydocno'];
        				$transaction_quantity=$res2['transaction_quantity'];
        				$transactionfunction=$res2['transactionfunction'];
        				
        				$querybatstock2 = "SELECT batch_quantity FROM transaction_stock where fifo_code='$fifo_code' and entrydocno!='ADJ-155' and itemcode='$itemcode' and storecode='$storecode' and auto_number<'$auto_num' order by auto_number desc limit 1";
        
        				$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        				$resbatstock2 = mysqli_fetch_array($execbatstock2);
        				if($l==0){
        				$prev_quantity = $resbatstock2["batch_quantity"];
        				}
        				if($transactionfunction=='1')
        				{
        				$preset_qty=$prev_quantity+$transaction_quantity;
        				}
        				if($transactionfunction=='0')
        				{
        				$preset_qty=$prev_quantity-$transaction_quantity;
        				}
        				$batch_status=0;
        				if($n==$row_count)
        				{
        				  $batch_status=1;
            				if($preset_qty<=0)
            				{
            				$batch_status=0;
            				}  
        				}
        			
        				/*
        				$query4 = "DELETE FROM transaction_stock  where itemcode='$itemcode' and fifo_code='$fifo_code'and entrydocno='ADJ-155' ";
                    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
        				$queryupdatecumstock3 = "update transaction_stock set batch_quantity='$preset_qty',batch_stockstatus='$batch_status' where itemcode='$itemcode' and fifo_code='$fifo_code' and auto_number='$auto_num'";
        				mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        				?>
        				<span <?php if($preset_qty<0){ ?> style="color:red" <?php } ?>> <?php echo $entrydocno.'//'.$transaction_quantity; ?> </span>
        				<?php
        				echo '<br/>';	
        				$l++;
        				$n++;
        				$prev_quantity=$preset_qty; */
                     }   
        		}
			
			}
	}

?>
