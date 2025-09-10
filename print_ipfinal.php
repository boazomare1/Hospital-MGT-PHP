<?php

include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$currentdate = date('Y-m-d');
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$accname = "";

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paylaterbillprefix = 'IPF-';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_ip order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>

<?php
function roundTo($number, $to){ 
    return round($number/$to, 0)* $to; 
} 

?>

        <?php
            
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$billtype = $res1['billtype'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		
		
		$query813 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res813 = mysqli_fetch_array($exec813);
		$num813 = mysqli_num_rows($exec813);
		if($num813 > 0)
		{
		$updatedate=$res813['recorddate'];
		}
			
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		$query2 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$admissiondate = $res2['recorddate'];
			?>
		
	
		   <?php 
		   } 
		   ?>

	
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;
			$totalop =0;
			$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			$packageanum1 = $res17['package'];
			
			
			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res53 = mysqli_fetch_array($exec53);
			$refno = $res53['docno'];
			
			if($packageanum1 != 0)
			{
			if($packchargeapply == 1)
		{
			
			$totalop=$consultationfee;
			?>
		
			<?php
			}
			}
			else
			{
		
			$totalop=$consultationfee;
			?>
	
			<?php
			}
			
			?>
					  <?php
					  $packageamount = 0;
			 $query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res731 = mysqli_fetch_array($exec731);
			$packageanum1 = $res731['package'];
			$packagedate1 = $res731['consultationdate'];
			
			
			$query741 = "select * from master_ippackage where auto_number='$packageanum1'";
			$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res741 = mysqli_fetch_array($exec741);
			$packdays1 = $res741['days'];
			$packagename = $res741['packagename'];
			$packageamount = $res741['rate'];
			
			if($packageanum1 != 0)
	{
	
	 $reqquantity = $packdays1;
	 
	 $reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));
	 
			  ?>
			
			  <?php
			  }
			  ?>
			<?php 
			$totalbedallocationamount = 0;
			
			 $requireddate = '';
			 $quantity = '';
			 $allocatenewquantity = '';
			$query18 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res18 = mysqli_fetch_array($exec18);
			$ward = $res18['ward'];
			$allocateward = $res18['ward'];
			
			$bed = $res18['bed'];
			$refno = $res18['docno'];
			$date = $res18['recorddate'];
			$bedallocateddate = $res18['recorddate'];
			$packagedate = $res18['recorddate'];
			$newdate = $res18['recorddate'];
			
			
			$query73 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res73 = mysqli_fetch_array($exec73);
			$packageanum = $res73['package'];
			
			
			$query74 = "select * from master_ippackage where auto_number='$packageanum'";
			$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res74 = mysqli_fetch_array($exec74);
			$packdays = $res74['days'];
			
		   $query51 = "select * from master_bed where auto_number='$bed'";
		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res51 = mysqli_fetch_array($exec51);
		   $bedname = $res51['bed'];
		   $threshold = $res51['threshold'];
		   $thresholdvalue = $threshold/100;
		   
			$query91 = "select * from master_bedcharge where bedanum='$bed' and recordstatus =''";
			$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num91 = mysqli_num_rows($exec91);
			while($res91 = mysqli_fetch_array($exec91))
		   {
		   $charge = $res91['charge'];
		   $rate = $res91['rate'];
		   
		   if($billtype == 'PAY LATER')
		   {
		   $thresholdamount = $rate * $thresholdvalue;
		   $rate = $rate + $thresholdamount;
		   }
		    $query181 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode' and recordstatus='transfered'";
			$exec181 = mysqli_query($GLOBALS["___mysqli_ston"], $query181) or die ("Error in Query181".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num181 = mysqli_num_rows($exec181);
			if($num181 > 0)
			{
			$query79 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' order by auto_number asc limit 0,1";
			$exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res79 = mysqli_fetch_array($exec79);
			$date1 = $res79['recorddate'];
			$diff = abs(strtotime($date1) - strtotime($date));
			}
			else
			{		
		    $diff = abs(strtotime($date) - strtotime($updatedate));
			}
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			$allocatedate = $date;
			$allocate1date = $date;
			
			
		
			if($days < $packdays)
			{
			
			$quantity = $days + 1;
			 
			}
			
					if($days > $packdays)
			{
			
			
		
			$days1 = $days - $packdays;
			
		
			if($packdays == 0)
			{
			   $query1281 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' and recordstatus =''";
			$exec1281 = mysqli_query($GLOBALS["___mysqli_ston"], $query1281) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1281 = mysqli_num_rows($exec1281);
			if($num1281 > 0)
			{
			 $quantity = $days1;
			}
			else
			{
		   $quantity = $days1 + 1;
		   }
		   }
		   else
		   {
		   $query1281 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' and recordstatus =''";
			$exec1281 = mysqli_query($GLOBALS["___mysqli_ston"], $query1281) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1281 = mysqli_num_rows($exec1281);
			if($num1281 > 0)
			{
			 $quantity = $days1;
			}
			else
			{
			$quantity = $days1 + 1;
			}
		  
		   }
		  
		   if($packageanum != 0)
		   {
		    	$reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));
			}
			else
			{
			$reqdate = $date;
			}
			
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		   $allocatenewquantity = $quantity;
		   
		 
		
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
			
			  <?php 
			 
			 }
			 
		
			 if($days == $packdays)
			 {
			 
			 if($packdays != 0)
			{
			 $days = $days - $packdays;
			
			if($days != 0)
			{
		   $quantity = $days + 1;
		  
		   
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		   $allocatenewquantiy = $quantity;
		   
		
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
		
			  <?php 
			 }
			 }
			 }
			 if($packdays == 0)
			 {
			 if($days == 0)
			 {
			
		   $quantity = $days + 1;
		   
		   $reqdate = $date;
		   
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		    $allocatenewquantiy = $quantity;
		
		
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
		
			  <?php
			 }
			 }
			 }
			  ?>
		
			  <?php 
			  $snno =0;
			  $i = 0;
			  $j=0;
			 
			  $totalbedtransferamount = 0;
			  $diff5 = 0;
			  $newdate = '';
				
			 
			$query128 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' and recordstatus =''";
			$exec128 = mysqli_query($GLOBALS["___mysqli_ston"], $query128) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num128 = mysqli_num_rows($exec128);
			while($res128 = mysqli_fetch_array($exec128))
			{
			$snno = $snno + 1;
			$j = $j + 1;
			
			$ward = $res128['ward'];
			$transfer1ward = $res128['ward'];
			$bed = $res128['bed'];
			$refno = $res128['docno'];
			$date = $res128['recorddate'];
			
			$newdate = $res128['recorddate'];
			$transferanum = $res128['auto_number'];
			
		    $datediff = abs(strtotime($bedallocateddate) - strtotime($date));
			$years5 = floor($datediff / (365*60*60*24));
			$months5 = floor(($datediff - $years5 * 365*60*60*24) / (30*60*60*24));
			$days5 = floor(($datediff - $years5 * 365*60*60*24 - $months5*30*60*60*24)/ (60*60*24));
			
			$newpackdays = $packdays - $days5;
			if($newpackdays > 0)
			{
		    $date = date('Y-m-d',strtotime($date) + (24*3600*$newpackdays));
			}
		
			
			   $query512 = "select * from master_bed where auto_number='$bed'";
			   $exec512 = mysqli_query($GLOBALS["___mysqli_ston"], $query512) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			   $res512 = mysqli_fetch_array($exec512);
			   $bedname = $res512['bed'];
			   $threshold = $res512['threshold'];
			   $thresholdvalue = $threshold/100;
			   
			$query912 = "select * from master_bedcharge where bedanum='$bed' and recordstatus =''";
			$exec912 = mysqli_query($GLOBALS["___mysqli_ston"], $query912) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num912 = mysqli_num_rows($exec912);
			while($res912 = mysqli_fetch_array($exec912))
		    {
			$i = $i + 1;
		    $charge = $res912['charge'];
		    $rate = $res912['rate'];
		   
		  	 if($billtype == 'PAY LATER')
		   {
		   $thresholdamount = $rate * $thresholdvalue;
		   $rate = $rate + $thresholdamount;
		   }
			$query66 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' and auto_number > '$transferanum' order by auto_number asc limit 0,1";
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res66 = mysqli_fetch_array($exec66);
			$date1 = $res66['recorddate'];
			$transferdate = $res66['recorddate'];
		   $diff = abs(strtotime($date1) - strtotime($date));
			
			if($num128 == $snno)
			{
			$query81 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num81 = mysqli_num_rows($exec81);
			if($num81 > 0)
			{
			$res81 = mysqli_fetch_array($exec81);
			$date1 = $res81['recorddate'];
			
			$diff = abs(strtotime($date1) - strtotime($date));
		
			}else
			{
		 	$diff = abs(strtotime($updatedate) - strtotime($date));
			
			}
			}
			
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			$query811 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec811 = mysqli_query($GLOBALS["___mysqli_ston"], $query811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num811 = mysqli_num_rows($exec811);
		
			if($num811 > 0)
			{
			$date12 = $res811['recorddate'];
				if($packageanum1 != 0)
			{
			$diff5 = abs(strtotime($date12) - strtotime($packagedate));
			}
			}
			else
			{
					if($packageanum1 != 0)
			{
		    $diff5 = abs(strtotime($updatedate) - strtotime($packagedate));
			}
			}
			$years5 = floor($diff5 / (365*60*60*24));
			$months5 = floor(($diff5 - $years5 * 365*60*60*24) / (30*60*60*24));
		    $days5 = floor(($diff5 - $years5 * 365*60*60*24 - $months5*30*60*60*24)/ (60*60*24));
			if($packageanum1 != 0)
			{
			if($days5 >= $packdays)
			{
			
			if($allocateward == $ward)
			{
			if($allocatedate != '')
			{
				if($allocatedate == $allocate1date)
			{
			
			if($quantity != '')
			{
			 $quantity = $quantity - 1;
			
			 }
			
			 if($packageanum1 != 0)
			 {
			 $quantity = $quantity + $packdays;
			 }
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 else
			 {
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 }
			
		
			
			$query812 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec812 = mysqli_query($GLOBALS["___mysqli_ston"], $query812) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num812 = mysqli_num_rows($exec812);
			if($num812 > 0)
			{
			$res812 = mysqli_fetch_array($exec812);
			$date12 = $res812['recorddate'];
			
			if($date12 == $transferdate)
			{
			$days = $days - 1;
			}
		
			}else
			{
		 	if($updatedate == $transferdate)
			{
			$days = $days - 1;
			}
			
			}
				
			}
			if($j > 1)
			{
			
			if($allocateward != $ward)
			{
			$quantity = $days + 1;
			}
			else
			{
			$quantity = $days;
			}
			}
			else
			{
		 $quantity = $days + 1;
		 }
		  
		   if($quantity != 0)
		   {
		   if($i == 1)
		   {
		   
		     $reqdate = date('Y-m-d',strtotime($reqdate) + (24*3600*$allocatenewquantity));
		    }
			if($allocateward != $ward)
				{
				$reqdate = $newdate;
				}
		   $amount = $quantity * $rate;
		   $totalbedtransferamount = $totalbedtransferamount + $amount;
		   
		   $totalquantity = $totalquantity + $quantity;
		
		
			
			 ?>
		
			  <?php 
			
			  }
			  $allocatedate = '';
			 }
			 }
			 
			
			if($packageanum1 == 0)
			{
			
			if($i == 1)
		   {
		   if($reqdate == $date )
		   {
		   $reqdate2 = $date;
		   }
		   else
		   {
	    $reqdate2 = date('Y-m-d',strtotime($reqdate) + (24*3600*$allocatenewquantity) - 1);
		}
		  
		if( $reqdate2 == $date)
		{
		$reqdate = $date;
		}
		else
		{
			$reqdate = date('Y-m-d',strtotime($reqdate) + (24*3600*$quantity));
			}
			}
			
			 if($days5 == 0)
			 {
			 if($allocateward == $ward)
			{
			
			if($allocatedate != '')
			{
			if($allocatedate == $allocate1date)
			{
			 $quantity = $quantity - 1;
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 else
			 {
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 if($transdate > $updatedate)
			 {
			 $transdate = $updatedate;
			 }
			 }
			 }
			
		if($transdate == $newdate)
		{
		 $days = $days - 1;
		}
		}
		
		
		  $quantity = $days + 1;
		  
		   
		   if($quantity != 0)
		   {
		  
		
		   $amount = $quantity * $rate;
		   $totalbedtransferamount = $totalbedtransferamount + $amount;
		   
		   $totalquantity = $totalquantity + $quantity;
		
			
			 ?>
		
			  <?php 
			
			  }
			  $allocatedate = '';
			 }
			}
			 }
		 $reqdate = date('Y-m-d',strtotime($reqdate) + (24*3600*$quantity));
		 
		 if($reqdate > $updatedate)
		 {
		 $reqdate = $updatedate;
		
		 }
		
			$allocatedate = $newdate;
			$allocateward = $ward;
			 }
			  ?>
			 
			   <?php 
			$totalpharm=0;
			
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res23 = mysqli_fetch_array($exec23))
			{
			$phaquantity=0;
			$quantity1=0;
			$phaamount=0;
			$phaquantity1=0;
			$totalrefquantity=0;
			$phaamount1=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			$phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];
			$refno = $res23['ipdocno'];
			$pharmfree = $res23['freestatus'];
			$query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query331 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    while($res331 = mysqli_fetch_array($exec331))
			{
			$quantity1=$res331['quantity'];
			$phaquantity1=$phaquantity1+$quantity1;
			$amount1=$res331['totalamount'];
			$phaamount1=$phaamount1+$amount1;
			}
			
			$resquantity = $phaquantity - $phaquantity1;
			$resamount = $phaamount - $phaamount1;
						
			$resamount=number_format($resamount,2,'.','');
			if($resquantity != 0)
			{
			if($pharmfree =='No')
			{
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$totalpharm=$totalpharm+$resamount;
			?>
			  
			  <?php }
			  }
			  }
			  ?>
			  <?php 
			  $totallab=0;
			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res19 = mysqli_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labcode=$res19['labitemcode'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['iptestdocno'];
			$labfree = $res19['freestatus'];
			
			if($labfree == 'No')
			{
			
		
			$totallab=$totallab+$labrate;
			?>
			
			  
			  <?php }
			  }
			  ?>
			  
			    <?php 
				$totalrad=0;
			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['iptestdocno'];
			$radiologyfree = $res20['freestatus'];
			
			if($radiologyfree == 'No')
			{
			
		
			$totalrad=$totalrad+$radrate;
			?>
		
			  
			  <?php }
			  }
			  ?>
			  	    <?php 
					
					$totalser=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund'";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			
			if($servicesfree == 'No')
			{
			
		
		
			$totalser=$totalser+$serrate;
			?>
			
			 <?php }
			  }
			  ?>
			<?php
			$totalotbillingamount = 0;
			$query61 = "select * from ip_otbilling where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res61 = mysqli_fetch_array($exec61))
		   {
			$otbillingdate = $res61['consultationdate'];
			$otbillingrefno = $res61['docno'];
			$otbillingname = $res61['surgeryname'];
			$otbillingrate = $res61['rate'];
			$colorloopcount = $colorloopcount + 1;
			
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
			?>
			
				<?php
				}
				?>
				<?php
			$totalprivatedoctoramount = 0;
			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res62 = mysqli_fetch_array($exec62))
		   {
			$privatedoctordate = $res62['consultationdate'];
			$privatedoctorrefno = $res62['docno'];
			$privatedoctor = $res62['doctorname'];
			$privatedoctorrate = $res62['rate'];
			$privatedoctoramount = $res62['amount'];
			$privatedoctorunit = $res62['units'];
		
			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctorrate;
			?>
			
				<?php
				}
				?>
				<?php
			$totalambulanceamount = 0;
			$query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res63 = mysqli_fetch_array($exec63))
		   {
			$ambulancedate = $res63['consultationdate'];
			$ambulancerefno = $res63['docno'];
			$ambulance = $res63['description'];
			$ambulancerate = $res63['rate'];
			$ambulanceamount = $res63['amount'];
			$ambulanceunit = $res63['units'];
		
			$totalambulanceamount = $totalambulanceamount + $ambulancerate;
			?>
			
				<?php
				}
				?>
				<?php
			$totalmiscbillingamount = 0;
			$query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res69 = mysqli_fetch_array($exec69))
		   {
			$miscbillingdate = $res69['consultationdate'];
			$miscbillingrefno = $res69['docno'];
			$miscbilling = $res69['description'];
			$miscbillingrate = $res69['rate'];
			$miscbillingamount = $res69['amount'];
			$miscbillingunit = $res69['units'];
			
			
			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingrate;
			?>
			 
				<?php
				}
				?>
				<?php
			$totaldiscountamount = 0;
			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res64 = mysqli_fetch_array($exec64))
		   {
			$discountdate = $res64['consultationdate'];
			$discountrefno = $res64['docno'];
			$discount= $res64['description'];
			$discountrate = $res64['rate'];
			$discountrate1 = $discountrate;
			$discountrate = -$discountrate;
			$authorizedby = $res64['authorizedby'];
			
		
			$totaldiscountamount = $totaldiscountamount + $discountrate;
			?>
			 
				<?php
				}
				?>
						<?php
			$totalnhifamount = 0;
			$query641 = "select * from ip_nhifprocessing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res641= mysqli_fetch_array($exec641))
		   {
			$nhifdate = $res641['consultationdate'];
			$nhifrefno = $res641['docno'];
			$nhifqty = $res641['totaldays'];
			$nhifrate = $res641['nhifrebate'];
			$nhifclaim = $res641['nhifclaim'];
			$nhifclaim = -$nhifclaim;
			
		
			$totalnhifamount = $totalnhifamount + $nhifclaim;
			?>
			 
				<?php
				}
				?>
			<?php
			$totaldepositamount = 0;
			$query112 = "select * from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositamount = $res112['transactionamount'];
			$depositamount1 = -$depositamount;
			$docno = $res112['docno'];
			$transactionmode = $res112['transactionmode'];
			$transactiondate = $res112['transactiondate'];
			$chequenumber = $res112['chequenumber'];
			
			$query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res731 = mysqli_fetch_array($exec731);
			$depositbilltype = $res731['billtype'];
		
			if($depositbilltype == 'PAY NOW')
			{
			
			
			$totaldepositamount = $totaldepositamount + $depositamount1;
			?>
			
				<?php
				if($transactionmode == 'CHEQUE')
				{
				echo $chequenumber;
				}
				?>
			    
			  
			  <?php }
			  }
			  ?>
			  <?php 
			  $depositamount = 0;
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
				?>
				
       
			
					<?php  $overalltotal = round($overalltotal); ?>
					
			<?php
			if($accname == 'CASH')
			{
			?>
            <?php
			$query222 = "select * from master_transactionip where patientcode='$patientcode' and visitcode='$visitcode'; ";
			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res222 = mysqli_fetch_array($exec222);
			$res222totalamount = $res222["transactionamount"];
			$res222balanceamount = $res222["balanceamount"];
			$res222chequemount = $res222["chequeamount"];
		    $res222chequenumber = $res222["chequenumber"];
			$res222onlineamount = $res222["onlineamount"];
		    $res222onlinenumber = $res222["onlinenumber"];
			$res222creditamount= $res222["creditamount"];
		    $res222creditcardnumber = $res222["creditcardnumber"];
			$res222mpesamount= $res222["mpesaamount"];
		    $res222mpesanumber = $res222["mpesanumber"];
			?>
		  
	        <?php if($res222totalamount!= 0.00) { ?>
			
			<?php } ?>
			
			 <?php if($res222chequemount!= 0.00) { ?>
			
			<?php } ?>
			
			 <?php if($res222onlineamount!= 0.00) { ?>
			
			<?php } ?>
			
			 <?php if($res222creditamount!= 0.00) { ?>
				
			<?php } ?>
			
			<?php if($res222mpesamount!= 0.00) { ?>
			
			<?php } }?>
<?php 
			 echo $overalltotal;
			 ?>