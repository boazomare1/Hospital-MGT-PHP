<?php			
		  
		   $totalhomecare=0;
		   $totalhomecarepaylater=0;
		   $totaliphomecare=0;
		  $query211 = "select amount from billing_homecare where recorddate between '$transactiondatefrom' and '$transactiondateto'";
		  $exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die ("Error in Query211".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec211);
		   while ($res211 = mysqli_fetch_array($exec211))
		  {
		 // $total = $total + $amount;
		 $total211 = $res211['amount'];
		 //echo  $total;
		  $totalhomecare  =  $totalhomecare + $total211;
		  
		  }
		 // echo  $totalhomecare; 
		    $query212 = "select amount from billing_homecarepaylater where recorddate between '$transactiondatefrom' and '$transactiondateto'";
		  $exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query212".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec212);
		   while ($res212 = mysqli_fetch_array($exec212))
		  {
		 // $total = $total + $amount;
		 $total212 = $res212['amount'];
		 //echo  $total;
		  $totalhomecarepaylater  =  $totalhomecarepaylater  +  $total212;
		  
		  }
		  $query213 = "select amount from billing_iphomecare where recorddate between '$transactiondatefrom' and '$transactiondateto'";
		  $exec213 = mysqli_query($GLOBALS["___mysqli_ston"], $query213) or die ("Error in Query213".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec213);
		   while ($res213 = mysqli_fetch_array($exec213))
		  {
		 // $total = $total + $amount;
		 $total213 = $res213['amount'];
		 //echo  $total;
		    $totaliphomecare  =   $totaliphomecare  +  $total213;
			
		  }
		  $totalbillhomecare = $totalhomecare  +  $totalhomecarepaylater + $totaliphomecare ;

		  //echo  $totaliphomecare; 
		 

