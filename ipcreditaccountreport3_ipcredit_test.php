<?php



// include ("includes/loginverify.php");

 include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');

 $visitcode=$_REQUEST["visitcode"];
 $patientcode=$_REQUEST["patientcode"];

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";

$packageanum1="";

$date12="";

 

?>





<script>







function funcwardChange1()

{

	/*if(document.getElementById("ward").value == "1")

	{

		alert("You Cannot Add Account For CASH Type");

		document.getElementById("ward").focus();

		return false;

	}*/

	<?php 

	$query12 = "select * from master_ward where recordstatus=''";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res12 = mysqli_fetch_array($exec12))

	{

	$res12wardanum = $res12["auto_number"];

	$res12ward = $res12["ward"];

	?>

	if(document.getElementById("ward").value=="<?php echo $res12wardanum; ?>")

	{

		document.getElementById("bed").options.length=null; 

		var combo = document.getElementById('bed'); 	

		<?php 

		$loopcount=0;

		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 

		<?php

		$query10 = "select * from master_bed where ward = '$res12wardanum' and recordstatus = ''";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		$loopcount = $loopcount+1;

		$res10bedanum = $res10['auto_number'];

		$res10bed = $res10["bed"];

		

		

		

		?>

			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10bed;?>", "<?php echo $res10bedanum;?>"); 

		<?php 

		

		}

		?>

	}

	<?php

	}

	?>	

}



function funcvalidation()

{

//alert('h');

if(document.getElementById("readytodischarge").checked == false)

{

alert("Please Click on Ready To Discharge");

return false;

}



}

</script>




 


 



           <?php

            $colorloopcount ='';

		

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
		$menusub=$res1['subtype'];

		$age = $res1['age'];

		$query32 = "select currency,fxrate,subtype,bedtemplate,labtemplate,radtemplate,sertemplate from master_subtype where auto_number = '".$menusub."'";
		$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	//	$res2 = mysql_num_rows($exec2);
		$mastervalue = mysqli_fetch_array($exec32);
		$currency=$mastervalue['currency'];
		$fxrate=$mastervalue['fxrate'];

		$subtype = $mastervalue['subtype'];
		$bedtemplate=$mastervalue['bedtemplate'];
		$labtemplate=$mastervalue['labtemplate'];
		$radtemplate=$mastervalue['radtemplate'];
		$sertemplate=$mastervalue['sertemplate'];
		$querytt32 = "select * from master_testtemplate where templatename='$bedtemplate'";
		$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$numtt32 = mysqli_num_rows($exectt32);
		$exectt=mysqli_fetch_array($exectt32);
		$bedtable=$exectt['referencetable'];
		if($bedtable=='')
		{
			$bedtable='master_bed';
		}
		$bedchargetable=$exectt['templatename'];
		if($bedchargetable=='')
		{
			$bedchargetable='master_bedcharge';
		}
		$querytl32 = "select * from master_testtemplate where templatename='$labtemplate'";
		$exectl32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytl32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$numtl32 = mysqli_num_rows($exectl32);
		$exectl=mysqli_fetch_array($exectl32);		
		$labtable=$exectl['templatename'];
		if($labtable=='')
		{
			$labtable='master_lab';
		}
		
		$querytt32 = "select * from master_testtemplate where templatename='$radtemplate'";
		$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$numtt32 = mysqli_num_rows($exectt32);
		$exectt=mysqli_fetch_array($exectt32);		
		$radtable=$exectt['templatename'];
		if($radtable=='')
		{
			$radtable='master_radiology';
		}
		
		$querytt32 = "select * from master_testtemplate where templatename='$sertemplate'";
		$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$numtt32 = mysqli_num_rows($exectt32);
		$exectt=mysqli_fetch_array($exectt32);
		$sertable=$exectt['templatename'];
		if($sertable=='')
		{
			$sertable='master_services';
		}

		

		

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
					$packageamountuhx=0;
					$query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
					$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res731 = mysqli_fetch_array($exec731);
					$packageanum1 = $res731['package'];
					$packagedate1 = $res731['consultationdate'];
					$packageamount = $res731['packagecharge'];

					$query741 = "select * from master_ippackage where auto_number='$packageanum1'";
					$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res741 = mysqli_fetch_array($exec741);
					$packdays1 = $res741['days'];
					$packagename = $res741['packagename'];
					
					$packageamountuhx=$packageamount*$fxrate;
					if($packageanum1 != 0)
					{

					$reqquantity = $packdays1;

					$reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));

					 }

					
			  ?>

			 

			<?php 

			$totalbedallocationamount = 0;
			$totalbedallocationamountuhx=0;
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
			$type = $res73['type'];
			$doctorType = $res73['doctorType'];
            $consultationdate=$res73['consultationdate'];
			// if($dateofbirth>'0000-00-00'){
			//   $today = new DateTime($consultationdate);
			//   $diff = $today->diff(new DateTime($dateofbirth));
			//   $ipage = format_interval($diff);
			// }else{
			  $ipage = $res73['age'];
			// }
			
			
			$query74 = "select * from master_ippackage where auto_number='$packageanum'";
			$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res74 = mysqli_fetch_array($exec74);
			$packdays = $res74['days'];
			
		   $query51 = "select * from `$bedtable` where auto_number='$bed'";
		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res51 = mysqli_fetch_array($exec51);
		   $bedname = $res51['bed'];
		   $threshold = $res51['threshold'];
		   $thresholdvalue = $threshold/100;
		   
			
			  
			   $totalbedallocationamount=0;
			   $totalbedallocationamountuhx=0;
			   $discount_bed = 0;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus,discount_amt from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res18 = mysqli_fetch_array($exec18))
				{
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];	
					
					$ward_discount=0;
					$sql_ward_disc="select discount from ward_scheme_discount where ward_id='$ward' and account_id='$accountname' and record_status='1'";
					$warddisc73 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_ward_disc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$wardnum73 = mysqli_num_rows($warddisc73);
					if($wardnum73>0){
					$wardres73 = mysqli_fetch_array($warddisc73);
					$ward_discount=$wardres73['discount'];

					}


					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];
					$leavingdate = $res18['leavingdate'];
					$leavingdate_org = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					$discount_bed = $res18['discount_amt'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$bedname = $res51['bed'];
					$threshold = $res51['threshold'];
					$thresholdvalue = $threshold/100;
					$time1 = new DateTime($bedallocateddate);
					$time2 = new DateTime($leavingdate);
					$interval = $time1->diff($time2);			  
					$quantity1 = $interval->format("%a");
					echo 'package'.$packdays1;
					exit;
					if($packdays1>$quantity1)
					{
						$quantity1=$quantity1-$packdays1; 
						$packdays1=$packdays1-$quantity1;
					}
					else
					{
						$quantity1=$quantity1-$packdays1;
						$packdays1=0;
					}
					$quantity='0';
					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' ";
					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num91 = mysqli_num_rows($exec91);

					$tmp=array();
					$tmpbed=array();
					$tmpbedcharge=array();
					while($res91 = mysqli_fetch_array($exec91))
					{
                       $tmp[]=$res91;
					}
										
					if(is_array($tmp)){
						foreach($tmp as $k =>$v){
						   if($v[0]=='Accommodation Only'){
                              $tmpbed[0]=$v[0];
							  $tmpbed['charge']=$v[0];
						      $tmpbed[1]=$v[1];
							  $tmpbed['rate']=$v[1];
                              unset($tmp[$k]);
						   }
						}

						if(is_array($tmpbed) and count($tmpbed)>0){
                           
						   foreach($tmp as $k =>$v){
                              if($v[0]=='Bed Charges'){
                                 $tmpbedcharge[]=$v;
								 $tmpbedcharge[]=$tmpbed;
							  }else
								  $tmpbedcharge[]=$v;

						   }
						   unset($tmp);
						   $tmp=$tmpbedcharge;
						}
					}
					
					foreach($tmp as $rslt)
					{
						$charge = $rslt['charge'];
						$rate = $rslt['rate'];	
                        
						if($doctorType==1 && $charge=='Daily Review charge')
							continue;
						elseif($doctorType==0 && $charge=='Consultant Fee')
							continue;

						if($ipage >7 && $charge=='Accommodation Only' )
						  continue;
						
						if($charge!='Bed Charges')
						{
							//$quantity=$quantity1+1;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								/*if($leavingdate_org=='0000-00-00')
								{ 
								$quantity=$quantity1+1;
								 } else {*/
								$quantity=$quantity1;
								//} 
							}
						}
						else
						{
							$rate = $rate-$discount_bed-$ward_discount;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								/*if($leavingdate_org=='0000-00-00')
								{ 
								$quantity=$quantity1+1;
								 } else {*/
								$quantity=$quantity1;
								//} 
							}
						}
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						if($quantity>0 && $amount>0)
						{
							if($type=='hospital'||$charge!='Resident Doctor Charges')
							{
								   $colorloopcount = $sno + 1;
								   if($charge == 'Cafetaria Charges')
									{
										$charge1 = 'Meals';
									}
									elseif($charge == 'Nursing Charges')
									{
										$charge1 = 'Nursing Care';
									}
									elseif($charge == 'RMO Charges')
									{
										$charge1 = 'Doctors Review';
									}
									elseif($charge == 'Accommodation Charges')
									{
										$charge1 = 'Sundries';
									}
									else{
										$charge1 = $charge;
									}
								
								$totalbedallocationamount=$totalbedallocationamount+($amount);
								$amountuhx = $rate*$quantity;
							echo "bed amount".	$totalbedallocationamountuhx = $totalbedallocationamountuhx + ($amountuhx*$fxrate);
								
					  ?>
								       
					 
					   <?php 
							}
						}
					}
				} ?>

		

			  <?php 
			  	$totalbedtransferamount=0;
				$totalbedtransferamountuhx=0;
				$discount_bed =0 ;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus,discount_amt from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res18 = mysqli_fetch_array($exec18))
				{
					$quantity1=0;
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];		
					
					$ward_discount=0;
					$sql_ward_disc="select discount from ward_scheme_discount where ward_id='$ward' and account_id='$accountname' and record_status='1'";
					$warddisc73 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_ward_disc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$wardnum73 = mysqli_num_rows($warddisc73);
					if($wardnum73>0){
					$wardres73 = mysqli_fetch_array($warddisc73);
					$ward_discount=$wardres73['discount'];

					}


					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					//$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];

					$leavingdate = $res18['leavingdate'];
					$leavingdate_org = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					$discount_bed = $res18['discount_amt'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$bedname = $res51['bed'];
					$threshold = $res51['threshold'];
					$thresholdvalue = $threshold/100;
					$time1 = new DateTime($date);
					$time2 = new DateTime($leavingdate);
					$interval = $time1->diff($time2);			  
					$quantity1 = $interval->format("%a");
					if($packdays1>$quantity1)
					{
						$quantity1=$quantity1-$packdays1; 
						$packdays1=$packdays1-$quantity1;
					}
					else
					{
						$quantity1=$quantity1-$packdays1;
						$packdays1=0;
					}
					$bedcharge='0';
					$quantity='0';
					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' ";
					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num91 = mysqli_num_rows($exec91);
					while($res91 = mysqli_fetch_array($exec91))
					{
						$charge = $res91['charge'];
						$rate = $res91['rate'];	

						if($doctorType==1 && $charge=='Daily Review charge')
							continue;
						elseif($doctorType==0 && $charge=='Consultant Fee')
							continue;

						if($ipage >7 && $charge=='Accommodation Only' )
						  continue;
						
						if($charge!='Bed Charges')
						{
							//$quantity=$quantity1+1;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								/*if($leavingdate_org=='0000-00-00')
								{ 
								$quantity=$quantity1+1;
								 } else {*/
								$quantity=$quantity1;
								//} 
							}
						}
						else
						{
							$rate = $rate-$discount_bed-$ward_discount;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								/*if($leavingdate_org=='0000-00-00')
								{ 
								$quantity=$quantity1+1;
								 } else {*/
								$quantity=$quantity1;
								//} 
							}
						}
						//echo $quantity;
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						//echo $bedcharge;
						if($bedcharge=='0')
						{
							//$quantity;
							if($quantity>0 && $amount>0)

							{
								if($doctorType==1 && $charge=='Daily Review charge')
									continue;
								elseif($doctorType==0 && $charge=='Consultant Fee')
									continue;
								 
								if($ipage > 7 && $charge=='Accommodation Only' ) {
								  continue;
								  }

								if($type=='hospital'||$charge!='Resident Doctor Charges')
								{
									$colorloopcount = $sno + 1;
									$showcolor = ($colorloopcount & 1); 
									if($charge == 'Cafetaria Charges')
									{
										$charge1 = 'Meals';
									}
									else{
										$charge1 = $charge;
									}
									if ($showcolor == 0)
									{
										//echo "if";
										$colorcode = 'bgcolor="#CBDBFA"';
									}
									else
									{
										//echo "else";
										$colorcode = 'bgcolor="#ecf0f5"';
									}
									$totalbedtransferamount=$totalbedtransferamount+($amount);
									$amountuhx = $rate*$quantity;
									$totalbedtransferamountuhx = $totalbedtransferamountuhx + ($amountuhx*$fxrate);
						  ?>
									
						   <?php 
								}
							}
							else
							{
								if($charge=='Bed Charges')
								{
									//$bedcharge='1';
								}
							}
						}
					}
				}
			  ?>
			 
			 

			   <?php 

			$original_fxrate= $fxrate;
			if(strtoupper($currency)=="USD"){
				$fxrate = $pharmacy_fxrate;
			}
			
			$totalpharm=0;
			$totalpharmuhx=0;
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' GROUP BY ipdocno,itemcode ";
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
			$quantity=$res23['quantity'];
			$refno = $res23['ipdocno'];
			$pharmfree = $res23['freestatus'];
			$amount=$pharate*$quantity;
			$query33 = "select quantity,totalamount from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' and ipdocno = '$refno'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
   			$quantity=$phaquantity;
			$amount=$pharate*$quantity;
			$query331 = "select sum(quantity) as quantity, sum(totalamount) as totalamount from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and docnumber='$refno' and itemcode='$phaitemcode'";
			$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res331 = mysqli_fetch_array($exec331);
			
			$quantity1=$res331['quantity'];
			//$phaquantity1=$phaquantity1+$quantity1;
			$amount1=$res331['totalamount'];
			//$phaamount1=$phaamount1+$amount1;
			
			
			$resquantity = $quantity - $quantity1;
			$resamount = $amount - $amount1;
						
			$resamount=number_format($resamount,2,'.','');
			//if($resquantity != 0)
			{
			if(strtoupper($pharmfree) =='NO')
			{
				 
			
//			$resamount=$resquantity*($pharate/$fxrate);
			$resamount=@number_format(($resamount/$fxrate),2,'.','');

			$totalpharm=$totalpharm+$resamount;
			
			 $resamountuhx = $pharate*$resquantity;
		   $totalpharmuhx = $totalpharmuhx + $resamountuhx;
			
			?>
                  
             <?php }
			  }
			  }
			
			  ?>

			  <?php 

			  $fxrate = $original_fxrate;

			  $totallab=0;
			    $totallabuhx=0;
			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund' ";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res19 = mysqli_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labcode=$res19['labitemcode'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['iptestdocno'];
			$labfree = $res19['freestatus'];
			$labsamplecoll = $res19['labsamplecoll'];
			$labstatus ='';
			if($labsamplecoll!='completed'){
              $labstatus ='<font color="red">(Sample Collection Pending)</font>';
			}
			
			if(strtoupper($labfree) == 'NO')
			{
			$queryl51 = "select rateperunit from `$labtable` where itemcode='$labcode'";
			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resl51 = mysqli_fetch_array($execl51);
			$labrate = $resl51['rateperunit'];
			 
			$totallab=$totallab+$labrate;
			
			 $labrateuhx = $labrate*$fxrate;
		   $totallabuhx = $totallabuhx + $labrateuhx;
			?>
			
                  
             <?php }
			  }
			  ?>

			  

			    <?php 

			 
				$totalrad=0;
				$totalraduhx=0;
			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['iptestdocno'];
			$radiologyfree = $res20['freestatus'];
			$radiologyitemcode = trim($res20['radiologyitemcode']);

			$resultentry = $res20['resultentry'];

			$labstatus ='';
			if($resultentry!='completed'){
              $labstatus ='<font color="red">(Results Pending)</font>';
			}
			

			if(strtoupper($radiologyfree) == 'NO')
			{
			$queryr51 = "select rateperunit from `$radtable` where itemcode='$radiologyitemcode'";
			$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resr51 = mysqli_fetch_array($execr51);
			$radrate = $resr51['rateperunit'];
			 
			$totalrad=$totalrad+$radrate;
			
			 $radrateuhx = $radrate*$fxrate;
		   $totalraduhx = $totalraduhx + $radrateuhx;
			?>
		 
                  
             <?php }
			  }
			  ?>

			  	    <?php 

					

					$totalser=0;
					 
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and wellnessitem <> '1' group by servicesitemname,iptestdocno";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesdoctorname = $res21['doctorname'];
			$servicesfree = $res21['freestatus'];
			$sercode=$res21['servicesitemcode'];
			$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";
			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress51 = mysqli_fetch_array($execs51);
			$serrate = $ress51['rateperunit'];
			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			$res211 = mysqli_fetch_array($exec2111);
			$serqty=$res21['serviceqty'];
			if($serqty==0){$serqty=$numrow2111;}
			
			if(strtoupper($servicesfree) == 'NO')
			{	
			$totserrate=$res21['amount'];
			 if($totserrate==0){
			$totserrate=$serrate*$numrow2111;
			  }
			/*$totserrate=$serrate*$numrow2111;*/
			 
				
			$totalser=$totalser+$totserrate;

			?>

			

			    

			  

			  <?php }

			  }

			  ?>

			<?php

			$totalotbillingamount = 0;
			$totalotbillingamountuhx=0;
			$query61 = "select * from ip_otbilling where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res61 = mysqli_fetch_array($exec61))
		   {
			$otbillingdate = $res61['consultationdate'];
			$otbillingrefno = $res61['docno'];
			$otbillingname = $res61['surgeryname'];
			$otbillingrate = $res61['rate'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			$otbillingrate = 1*($otbillingrate/$fxrate);
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
			
			 $otbillingrateuhx = $otbillingrate;
		   $totalotbillingamountuhx = $totalotbillingamountuhx + $otbillingrateuhx;
			?>
			 

		

				<?php

				}

				?>

				<?php

			 
			$totalprivatedoctoramount = 0;
			$totalprivatedoctoramountuhx=0;
			$copayamt =0;
			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg = '1'";
			$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res62 = mysqli_fetch_array($exec62))
		    {
			$privatedoctordate = $res62['consultationdate'];
			$privatedoctorrefno = $res62['docno'];
			$privatedoctor = $res62['doctorname'];
			$privatedoctorrate = $res62['rate'];
			$privatedoctoramount = $res62['amount'];
			$privatedoctorunit = $res62['units'];
			$description = $res62['remarks'];
			$doccoa = $res62['doccoa'];
			if($description != '')
			{
			$description = '-'.$description;
			}
			
			 
			

			$queryve1 = "select planfixedamount,planpercentage from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
			$execve1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryve1) or die ("Error in queryve1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $resve1 = mysqli_fetch_array($execve1);

			// if($resve1['planfixedamount'] > 0)
			// 	$copayamt = $resve1['planfixedamount'];
			// elseif($resve1['planpercentage']>0)
			//     $copayamt =( $privatedoctoramount/100)*$resve1['planpercentage'] ;
			// else
				$copayamt =0;

			$privatedoctoramount = @$privatedoctorunit*($privatedoctorrate/$fxrate)-$copayamt;
			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
			
			 $privatedoctoramountuhx = ($privatedoctorrate*$privatedoctorunit)-$copayamt;
		     $totalprivatedoctoramountuhx = $totalprivatedoctoramountuhx + $privatedoctoramountuhx;
			?>
			
				<?php
				}
                
				?>

				<?php
			$totalambulanceamount = 0;
			$totalambulanceamountuhx=0;
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
			 
			$ambulanceamount = $ambulanceunit*($ambulancerate/$fxrate);
			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;
			
			 $ambulanceamountuhx = $ambulancerate*$ambulanceunit;
		   $totalambulanceamountuhx = $totalambulanceamountuhx + $ambulanceamountuhx;
			?>
			  
				<?php
				}
				 

			$totalmiscbillingamount = 0;
			$totalmiscbillingamountuhx=0;
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
			
			 
			$miscbillingamount = $miscbillingunit*($miscbillingrate/$fxrate);
			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;
			
			 $miscbillingamountuhx = $miscbillingrate*$miscbillingunit;
		   $totalmiscbillingamountuhx = $totalmiscbillingamountuhx + $miscbillingamountuhx;
			
				 
				}
				?>

				<?php
			$totaldiscountamount = 0;
			$totaldiscountamountuhx=0;
			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res64 = mysqli_fetch_array($exec64))
		   {
			$discountdate = $res64['consultationdate'];
			$discountrefno = $res64['docno'];
			$discount= $res64['description'];
			$discountrate = $res64['rate'];
			$discountrate1 = -$discountrate;
			$discountrate = -$discountrate;
			$authorizedby = $res64['authorizedby'];
			
						
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			$discountrate = 1*($discountrate1/$fxrate);
			$totaldiscountamount = $totaldiscountamount + $discountrate;
			
			 $discountrateuhx = $discountrate1;
		   $totaldiscountamountuhx = $totaldiscountamountuhx + $discountrateuhx;
			?>
			
				<?php
				}
				?>

			

						<?php
			$totalnhifamount = 0;
			$totalnhifamountuhx=0;
			$query641 = "select * from ip_nhifprocessing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res641= mysqli_fetch_array($exec641))
		   {
			$nhifdate = $res641['consultationdate'];
			$nhifrefno = $res641['docno'];
			$nhifqty = $res641['totaldays'];
			$nhifrate = $res641['nhifrebate'];
			$nhifclaim = $res641['nhifclaim'];
			$nhif_claimdays = $res641['nhif_claimdays'];
			if($nhif_claimdays=='0'){
			$nhifqty = -$nhifqty;
			$nhifclaim = -$nhifclaim;
			}
			
			$nhifclaim = $nhifqty*($nhifrate/$fxrate);
			$totalnhifamount = $totalnhifamount + $nhifclaim;
			
			 $nhifclaimuhx = $nhifrate*$nhifqty;
		   $totalnhifamountuhx = $totalnhifamountuhx + $nhifclaimuhx;
			
				}

				?>

			<?php

			$totaldepositamount = 0;
			$totaldepositamountuhx=0;
			$query112 = "select * from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode' and transactionmodule <> 'Adjustment'";
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
		
			
			$depositamount1 = 1*($depositamount/$fxrate);
			$totaldepositamount = $totaldepositamount + $depositamount;
			
			 $depositamount1uhx = $depositamount;
		   $totaldepositamountuhx = $totaldepositamountuhx + $depositamount1uhx;
			}
			 $totaladvancedepositamount = 0;
			$totaladvancedepositamountuhx=0;
			$query112 = "select * from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$advancedepositamountfx = $res112['transactionamount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['transactiondate'];
			
			
			$advancedepositamount = 1*($advancedepositamountfx/$fxrate);
			$totaldepositamount += $advancedepositamount;
		}
			
			 // $advancedepositamountuhx = $advancedepositamountfx;
		  //  $totaldepositamountuhx = $totaldepositamountuhx + $advancedepositamountuhx;
		   ?>

			  <?php
			$totaldepositrefundamount = 0;
			$totaldepositrefundamountuhx=0;
			$query123444 = "select * from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec123444 = mysqli_query($GLOBALS["___mysqli_ston"], $query123444) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res123444 = mysqli_fetch_array($exec123444))
			{
			$depositrefundamountfx = $res123444['amount'];
			$docno = $res123444['docno'];
			$transactiondate = $res123444['recorddate'];
			
			 
			$depositrefundamount = 1*($depositrefundamountfx/$fxrate);
			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			}

			  ?>

			  <?php 

			  $depositamount = 0;

			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount-$totaldepositamount+$totalnhifamount+$totaldepositrefundamount);

			  // echo $totalop.'-'.$totalbedtransferamount.'-'.$totalbedallocationamount.'-'.$totallab.'-'.$totalpharm.'-'.$totalrad.'-'.$totalser.'-'.$packageamount.'-'.$totalotbillingamount.'-'.$totalprivatedoctoramount.'-'.$totalambulanceamount.'-'.$totaldiscountamount.'-'.$totalmiscbillingamount.'-'.$totaldepositamount.'-a'.$totalnhifamount.'-'.$totaldepositrefundamount ;


			   // $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount-$totaldepositamount-$totalnhifamount+$totaldepositrefundamount);

			  $overalltotal=number_format($overalltotal,2,'.','');

			  $consultationtotal=$totalop;

			   $consultationtotal=number_format($consultationtotal,2,'.','');

			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;

			   $netpay=number_format($netpay,2,'.','');

			  ?>


			

	

