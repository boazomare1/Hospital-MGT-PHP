<?php			
		  
		   $totalipambulance=0;
		   $totalopambulance=0;
		   $totalopambulancepaylater=0;
		   $totalambulance = 0;
		  $query221 = "select amount from billing_ipambulance where recorddate between '$transactiondatefrom' and '$transactiondateto'";
		  $exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec221);
		   while ($res221 = mysqli_fetch_array($exec221))
		  {
		 // $total = $total + $amount;
		 $total221 = $res221['amount'];
		 //echo  $total;
		  $totalipambulance  =  $totalipambulance + $total221;
		  
		  }
		  //echo  $totalipambulance; 
		    $query222= "select amount from billing_opambulance where recorddate between '$transactiondatefrom' and '$transactiondateto'";
		  $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec222);
		   while ($res222 = mysqli_fetch_array($exec222))
		  {
		 // $total = $total + $amount;
		 $total222 = $res222['amount'];
		 //echo  $total;
		   $totalopambulance  =  $totalopambulance  +  $total222;
		  
		  }
		 // echo $totalopambulance; 
		   $query223 = "select amount from billing_opambulancepaylater where recorddate between '$transactiondatefrom' and '$transactiondateto'";
		  $exec223 = mysqli_query($GLOBALS["___mysqli_ston"], $query223) or die ("Error in Query223".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec223);
		   while ($res223 = mysqli_fetch_array($exec223))
		  {
		 // $total = $total + $amount;
		 $total223 = $res223['amount'];
		 //echo  $total;
		   $totalopambulancepaylater  =  $totalopambulancepaylater  +  $total223;
		  
		  }
		  
		   $query224 = "select amount from ip_ambulance where consultationdate between '$transactiondatefrom' and '$transactiondateto'";
		   //echo $query224;
		  $exec224 = mysqli_query($GLOBALS["___mysqli_ston"], $query224) or die ("Error in Query224".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec224);
		   while ($res224 = mysqli_fetch_array($exec224))
		  {
		 // $total = $total + $amount;
		 $total224 = $res224['amount'];
		// echo  $total;
		   $totalambulance  =  $totalambulance +  $total224;
		  
		  }
		  $totalambulanceamount =   $totalipambulance + $totalopambulance +  $totalambulance + $totalopambulancepaylater; 
		  
		  //echo $totalambulance; 
		  

