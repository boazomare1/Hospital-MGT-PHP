<?php			
		   $total = 0;
		  $query2 = "select * from master_lab group by itemname"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2itemname = $res2['itemname'];
		  $res2categoryname = $res2['categoryname'];
		  $res2rate = $res2['rateperunit'];
		  
		  $query3 = "select * from billing_externallab where labitemname = '$res2itemname' and billdate between '$transactiondatefrom' and '$transactiondateto'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec3);
		  //echo $num1;
		  $res3 = mysqli_fetch_array($exec3);
		  
		  $query4 = "select * from billing_paylaterlab where labitemname = '$res2itemname' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num2 = mysqli_num_rows($exec4);
		  //echo $num2;
		  $res4 = mysqli_fetch_array($exec4);
		  
		  $query5 = "select * from billing_paynowlab where labitemname = '$res2itemname' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num3 = mysqli_num_rows($exec5);
		  //echo $num3;
		  $res5 = mysqli_fetch_array($exec5);
		  
		  $query6 = "select * from billing_iplab where labitemname = '$res2itemname' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num6 = mysqli_num_rows($exec6);
		  //echo $num3;
		  $res6 = mysqli_fetch_array($exec6);

		  
		  $num4 = $num1 + $num2 + $num3 + $num6;
		  //$num4 = number_format($num4, '2', '.' ,''); 
		  
		  $amount = $num4 * $res2rate;
		  
		  
		  $total = $total + $amount;
		 
		  
}

