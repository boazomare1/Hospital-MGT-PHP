<?php 

include ("db/db_connect.php");
$loc_array=array('LTC-1');

$transaction_details="select storecode,locationcode from transaction_stock  group by storecode";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_details) or die ("Error in transaction_details".mysqli_error($GLOBALS["___mysqli_ston"]));
?>
<table class="table table-bordered" border='1'>
<?php
		while($store_details = mysqli_fetch_array($exec3)) 
		{ 
		
		?>
		<tr>	
			<td colspan='2'><?php echo $store_details['locationcode'];?></td><td colspan='2'><?php echo $store_details['storecode'];?></td>
		</tr>
		<?php 

		$product_details1="select trim(itemcode) as itemcode,itemname from master_medicine where itemcode='PRDIN03463'";
		$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $product_details1) or die ("Error in product_details1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($product_details = mysqli_fetch_array($exec32)) {

            $pro_count="select auto_number as cnt  from transaction_stock where trim(itemcode)='".$product_details['itemcode']."' and storecode='".$store_details['storecode']."'";

			$exec323 = mysqli_query($GLOBALS["___mysqli_ston"], $pro_count) or die ("Error in pro_count".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num76 = mysqli_num_rows($exec323);
            
			if($num76>0)
			{ 	
				
				$pro_fifo_details1="select fifo_code  from transaction_stock where trim(itemcode)='".$product_details['itemcode']."' and storecode='".$store_details['storecode']."' group by fifo_code";
			    $exec324 = mysqli_query($GLOBALS["___mysqli_ston"], $pro_fifo_details1) or die ("Error in pro_fifo_details1".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($pro_fifo_details = mysqli_fetch_array($exec324)) 
				{

					$pro_fifo_stock_details1="select batch_quantity,batch_stockstatus,auto_number from transaction_stock where trim(itemcode)='".$product_details['itemcode']."' and storecode='".$store_details['storecode']."' and fifo_code='".$pro_fifo_details['fifo_code']."' order by auto_number desc limit 0,1";
						
					 $exec325 = mysqli_query($GLOBALS["___mysqli_ston"], $pro_fifo_stock_details1) or die ("Error in pro_fifo_stock_details1".mysqli_error($GLOBALS["___mysqli_ston"]));
					 $pro_fifo_stock_details = mysqli_fetch_array($exec325);

					$color="";
						if(($pro_fifo_stock_details["batch_quantity"]>0)&&($pro_fifo_stock_details["batch_stockstatus"]==0))
						{

								$update="update transaction_stock set batch_stockstatus='1' where auto_number='".$pro_fifo_stock_details["auto_number"]."'";
								$exec325 = mysqli_query($GLOBALS["___mysqli_ston"], $update) or die ("Error in update".mysqli_error($GLOBALS["___mysqli_ston"]));

								?>
								<tr bgcolor="<?php echo $color;?>">	
									<td><?php echo $product_details["itemname"];?></td>
									<td><?php echo $pro_fifo_details["fifo_code"];?></td>
									<td><?php echo $pro_fifo_stock_details["batch_quantity"];?></td>
									<td><?php echo $pro_fifo_stock_details["batch_stockstatus"];?></td>
								</tr>
						 <?php
						}
				} 
			}
		}
}  

?>
</table>
