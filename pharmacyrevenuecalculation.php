<?php			
		   
		    $totalpharmacy232 = 0;
		   $totalpharmacyreturn=0;
		  $query231 = "select itemcode,itemname from master_medicine where status<>'deleted'"; 
		  $exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die ("Error in Query231".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res231 = mysqli_fetch_array($exec231))
		  {
     	  $res21itemname = $res231['itemname'];
		  $res21itemcode= $res231['itemcode'];
		  
		 
		  $query232 = "select totalamount from pharmacysales_details where itemcode='$res21itemcode' and itemname='$res21itemname' and  entrydate between '$transactiondatefrom' and '$transactiondateto'";
		  $exec232 = mysqli_query($GLOBALS["___mysqli_ston"], $query232) or die ("Error in Query232".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec232);
		   while ($res232 = mysqli_fetch_array($exec232))
		  {
		 // $total = $total + $amount;
		 $total232 = $res232['totalamount'];
		 //echo  $total;
		  $totalpharmacy232 = $totalpharmacy232 + $total232;
		  
		  }
		    $query233 = "select totalamount from pharmacysalesreturn_details  where itemcode='$res21itemcode' and itemname='$res21itemname' and entrydate between '$transactiondatefrom' and '$transactiondateto'";
		  $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num2 = mysqli_num_rows($exec233);
		   while ($res233 = mysqli_fetch_array($exec233))
		  {
		 // $total = $total + $amount;
		 $totalreturn = $res233['totalamount'];
		 //echo  $total;
		  $totalpharmacyreturn =  $totalpharmacyreturn + $totalreturn;
		  
		  
		  
		  
		  }
		  
	}
$total = $totalpharmacy232 - $totalpharmacyreturn ;
$totalpharmacy = $total ;
//echo  $totalpharmacy; 
?>