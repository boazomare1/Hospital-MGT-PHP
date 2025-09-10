<?php

//session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');



$errmsg = "";

$totalbedcharges='0.00';

$labtotal = "0.00";

$totalradiologyitemrate = "0.00";

$totalservicesitemrate = "0.00";

$totalprivatedoctoramount = "0.00";

$totalpharmacysaleamount = "0.00";

$totalpharmacysalereturnamount = "0.00";

$totalambulanceamount = "0.00";

$totalipmis = "0.00";

$totaldiscountrate = "0.00";

$totalnhifamount = "0.00";

$totalipdepositamount = "0.00";

$totalbedcharges = "0.00";

$totalbedtransfercharges = "0.00";

$totalpackage = "0.00";

$totaladmncharges = "0.00";

$ipunfinalizeamount='';

$ipfinalizedamount='';

?>



		<?php

		$query66 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip) and consultationdate between '$ADate1' and '$ADate2'";

		$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($res66 = mysqli_fetch_array($exec66))

		{

			$patientcode = $res66['patientcode'];

			$visitcode = $res66['visitcode'];

			

			$querymenu = "select * from master_customer where customercode='$patientcode'";

			$execmenu = mysqli_query($GLOBALS["___mysqli_ston"], $querymenu) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$nummenu=mysqli_num_rows($execmenu);

			$resmenu = mysqli_fetch_array($execmenu);

			$menusub=$resmenu['subtype'];

			

			$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$menusub'");

			$execsubtype=mysqli_fetch_array($querysubtype);

			$patientsubtype1=$execsubtype['subtype'];

			$bedtemplate=$execsubtype['bedtemplate'];

			$labtemplate=$execsubtype['labtemplate'];

			$radtemplate=$execsubtype['radtemplate'];

			$sertemplate=$execsubtype['sertemplate'];

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

			$query32 = "select currency,fxrate,subtype from master_subtype where auto_number = '".$menusub."'";

			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$mastervalue = mysqli_fetch_array($exec32);

			$currency=$mastervalue['currency'];

			$fxrate=$mastervalue['fxrate'];

			$subtype=$mastervalue['subtype'];

		

		$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res17 = mysqli_fetch_array($exec17);

			$consultationfee=$res17['admissionfees'];

			$consultationfee = number_format($consultationfee,2,'.','');

			$viscode=$res17['visitcode'];

			$consultationdate=$res17['consultationdate'];

			$packchargeapply = $res17['packchargeapply'];

			$packageanum1 = $res17['package'];

			

			$totaladmncharges = $totaladmncharges + $consultationfee;

			

			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res53 = mysqli_fetch_array($exec53);

			$refno = $res53['docno'];

			

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

			$totalpackage = $totalpackage + $packageamountuhx;

			 

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

				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";

				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res18 = mysqli_fetch_array($exec18))

				{

					$ward = $res18['ward'];

					$allocateward = $res18['ward'];			

					$bed = $res18['bed'];

					$refno = $res18['docno'];

					$date = $res18['recorddate'];

					$bedallocateddate = $res18['recorddate'];

					$packagedate = $res18['recorddate'];

					$leavingdate = $res18['leavingdate'];

					$recordstatus = $res18['recordstatus'];

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

					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";

					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$num91 = mysqli_num_rows($exec91);

					while($res91 = mysqli_fetch_array($exec91))

					{

						$charge = $res91['charge'];

						$rate = $res91['rate'];	

						

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

								$quantity=$quantity1;

							}

						}

						else

						{

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

								$quantity=$quantity1;

							}

						}

						$amount = $quantity * $rate;						

						$allocatequantiy = $quantity;

						$allocatenewquantity = $quantity;

						if($quantity>0)

						{

							if($type=='hospital'||$charge!='Resident Doctor Charges')

							{

								$colorloopcount = $sno + 1;

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

								$totalbedallocationamount=$totalbedallocationamount+($amount);

								$amountuhx = $rate*$quantity;

								$totalbedallocationamountuhx = $totalbedallocationamountuhx + ($amountuhx*$fxrate);

								$totalbedcharges = $totalbedcharges + ($amountuhx*$fxrate);

					  

							}

						}

					}

				}

				$totalbedtransferamount=0;

				$totalbedtransferamountuhx=0;

				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";

				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res18 = mysqli_fetch_array($exec18))

				{

					$quantity1=0;

					$ward = $res18['ward'];

					$allocateward = $res18['ward'];			

					$bed = $res18['bed'];

					$refno = $res18['docno'];

					$date = $res18['recorddate'];

					//$bedallocateddate = $res18['recorddate'];

					$packagedate = $res18['recorddate'];



					$leavingdate = $res18['leavingdate'];

					$recordstatus = $res18['recordstatus'];

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

					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";

					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$num91 = mysqli_num_rows($exec91);

					while($res91 = mysqli_fetch_array($exec91))

					{

						$charge = $res91['charge'];

						$rate = $res91['rate'];	

						

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

								$quantity=$quantity1;

							}

						}

						else

						{

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

								$quantity=$quantity1;

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

							if($quantity>0)

							{

								if($type=='hospital'||$charge!='Resident Doctor Charges')

								{

									$colorloopcount = $sno + 1;

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

									$totalbedtransferamount=$totalbedtransferamount+($amount);

									$amountuhx = $rate*$quantity;

									$totalbedtransferamountuhx = $totalbedtransferamountuhx + ($amountuhx*$fxrate);

									$totalbedtransfercharges = $totalbedtransfercharges + ($amountuhx*$fxrate);

						  

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

			 

			$totalpharm=0;

			$totalpharmuhx=0;

			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' GROUP BY ipdocno,itemcode";

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

			

			

			$resquantity = $quantity;

			$resamount = $amount;

						

			$resamount=number_format($resamount,2,'.','');

			//if($resquantity != 0)

			{

			if($pharmfree =='No')

			{

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

			

			$resamount=$resquantity*($pharate/$fxrate);

			$totalpharm=$totalpharm+$resamount;

			

			 $resamountuhx = $pharate*$resquantity;

			 $resamountreturnuhx = $pharate*$quantity1;

		   $totalpharmuhx = $totalpharmuhx + $resamountuhx;

			$totalpharmacysaleamount = $totalpharmacysaleamount + $resamountuhx;

			$totalpharmacysalereturnamount = $totalpharmacysalereturnamount + $resamountreturnuhx;

			

			}

			  }

			  }

			

			  $totallab=0;

			    $totallabuhx=0;

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

			$queryl51 = "select rateperunit from `$labtable` where itemcode='$labcode'";

			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$resl51 = mysqli_fetch_array($execl51);

			$labrate = $resl51['rateperunit'];

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

			$totallab=$totallab+$labrate;

			

			 $labrateuhx = $labrate*$fxrate;

		   $totallabuhx = $totallabuhx + $labrateuhx;

		   $labtotal = $labtotal + $labrateuhx;

			}

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

			$radiologyitemcode = $res20['radiologyitemcode'];

			if($radiologyfree == 'No')

			{

			$queryr51 = "select rateperunit from `$radtable` where itemcode='$radiologyitemcode'";

			$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$resr51 = mysqli_fetch_array($execr51);

			$radrate = $resr51['rateperunit'];

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

			$totalrad=$totalrad+$radrate;

			

			 $radrateuhx = $radrate*$fxrate;

		   $totalraduhx = $totalraduhx + $radrateuhx;

		   $totalradiologyitemrate = $totalradiologyitemrate + $radrateuhx;

			}

			  }

			  					

					$totalser=0;

					$totalseruhx=0;

		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and wellnessitem <> '1' group by servicesitemname,iptestdocno";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res21 = mysqli_fetch_array($exec21))

			{

			$serdate=$res21['consultationdate'];

			$sername=$res21['servicesitemname'];

			$serrate=$res21['servicesitemrate'];

			$serref=$res21['iptestdocno'];

			$servicesfree = $res21['freestatus'];

			$servicesdoctorname = $res21['doctorname'];

			$sercode=$res21['servicesitemcode'];

			$serviceledgercode=$res21['incomeledgercode'];

			$serviceledgername=$res21['incomeledgername'];

			$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";

			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$ress51 = mysqli_fetch_array($execs51);

			$serrate = $ress51['rateperunit'];

			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund' and wellnessitem <> '1'";

			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));

			$numrow2111 = mysqli_num_rows($exec2111);

			$res211 = mysqli_fetch_array($exec2111);

			$serqty=$res21['serviceqty'];

			if($serqty==0){$serqty=$numrow2111;}

			

			if($servicesfree == 'No')

			{	

			$totserrate=$res21['amount'];

			 if($totserrate==0){

			$totserrate=$serrate*$numrow2111;

			  }

			/*$totserrate=$serrate*$numrow2111;*/

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

				$totserrate=($serqty*$serrate);

			$totalser=$totalser+$totserrate;

			

			 $totserrateuhx = ($serrate*$fxrate)*$serqty;

		   $totalseruhx = $totalseruhx + $totserrateuhx;

		   $totalservicesitemrate = $totalservicesitemrate + $totserrateuhx;

			 }

			  }

		

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

			$ambulanceamount = $ambulanceunit*($ambulancerate/$fxrate);

			 $ambulanceamountuhx = $ambulancerate*$ambulanceunit;

			 $totalambulanceamount = $totalambulanceamount + $ambulanceamountuhx;

		   $totalambulanceamountuhx = $totalambulanceamountuhx + $ambulanceamountuhx;

			

				}

				?>

				<?php

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

			$miscbillingamount = $miscbillingunit*($miscbillingrate/$fxrate);

			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;

			

			 $miscbillingamountuhx = $miscbillingrate*$miscbillingunit;

			 $totalipmis = $totalipmis + $miscbillingamountuhx;

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

			$discountrate1 = $discountrate;

			$discountrate = $discountrate;

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

			 $totaldiscountrate = $totaldiscountrate + $discountrateuhx;

		   $totaldiscountamountuhx = $totaldiscountamountuhx + $discountrateuhx;

			

				}		


				 $query4 = "SELECT sum(amount) as amount1 FROM ipprivate_doctor WHERE  patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg = '1' ";
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num4=mysqli_num_rows($exec4);
				$totalprivatedoctorcharges='0.00';
				while($res4 = mysqli_fetch_array($exec4)){
				// $res4 = mysql_fetch_array($exec4);
					 $privatedoctoramount = $res4['amount1'];
					$totalprivatedoctorcharges+=$privatedoctoramount;
					$totalprivatedoctoramount+=$privatedoctoramount;
				}	  	  

		} 

		

			$ipunfinalizeamount=$totaladmncharges+$labtotal+$totalradiologyitemrate+$totalservicesitemrate+$totalprivatedoctoramount+$totalpharmacysaleamount-$totalpharmacysalereturnamount+$totalambulanceamount+$totalipmis-$totaldiscountrate+$totalbedcharges+$totalbedtransfercharges+$totalpackage;

		?>

			

	

