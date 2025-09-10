
           <?php
           $colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;
			$totalop =0;
			$totalopuhx=0;
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
			$totalop=$consultationfee;
			$totalopuhx=$consultationfee*$fxrate;
			?>
			
			<?php
			}
			}
			else
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
			$totalop=$consultationfee;
			$totalopuhx=$consultationfee*$fxrate;
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
			  ?>
			 
			  <?php
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
					$query51 = "select bed,threshold from master_bed where auto_number='$bed'";
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
					$query91 = "select charge,rate from master_bedcharge where bedanum='$bed' and recordstatus ='' ";
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
								$totalbedallocationamount=$totalbedallocationamount+($amount/$fxrate);
								$amountuhx = $rate*$quantity;
								$totalbedallocationamountuhx = $totalbedallocationamountuhx + $amountuhx;
								
					  ?>
						          
					 
					   <?php 
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
					$query51 = "select bed,threshold from master_bed where auto_number='$bed'";
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
					$query91 = "select charge,rate from master_bedcharge where bedanum='$bed' and recordstatus ='' ";
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
									$totalbedtransferamount=$totalbedtransferamount+($amount/$fxrate);
									$amountuhx = $rate*$quantity;
									$totalbedtransferamountuhx = $totalbedtransferamountuhx + $amountuhx;
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
			$totalpharm=0;
			$totalpharmuhx=0;
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
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
		   $totalpharmuhx = $totalpharmuhx + $resamountuhx;
			?>
			 
                  
             <?php }
			  }
			  }
			  ?>
			  <?php 
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
			
			if($radiologyfree == 'No')
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
			$totalrad=$totalrad+$radrate;
			
			 $radrateuhx = $radrate*$fxrate;
		   $totalraduhx = $totalraduhx + $radrateuhx;
			?>
			 
             <?php }
			  }
			  ?>	  	    <?php 
					
					$totalser=0;
					$totalseruhx=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' group by servicesitemname,iptestdocno";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$sercode=$res21['servicesitemcode'];
			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund'";
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
			
			$totalser=$totalser+$totserrate;
			
			 $totserrateuhx = ($totserrate*$fxrate);
		   $totalseruhx = $totalseruhx + $totserrateuhx;
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
			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg ='1'";
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
			$privatedoctoramount = $privatedoctorunit*($privatedoctorrate/$fxrate);
			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
			
			 $privatedoctoramountuhx = $privatedoctorrate*$privatedoctorunit;
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
			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;
			
			 $ambulanceamountuhx = $ambulancerate*$ambulanceunit;
		   $totalambulanceamountuhx = $totalambulanceamountuhx + $ambulanceamountuhx;
			?>
			 
				<?php
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
		   $totalmiscbillingamountuhx = $totalmiscbillingamountuhx + $miscbillingamountuhx;
			?>
			 
				<?php
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
			$nhifclaim = -$nhifclaim;
			
						
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
			$nhifclaim = $nhifqty*($nhifrate/$fxrate);
			$totalnhifamount = $totalnhifamount + $nhifclaim;
			
			 $nhifclaimuhx = $nhifrate*$nhifqty;
		   $totalnhifamountuhx = $totalnhifamountuhx + $nhifclaimuhx;
			?>
			 
				<?php
				}
				?>
			<?php
			$totaldepositamount = 0;
			$totaldepositamountuhx=0;
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
			$depositamount1 = 1*($depositamount/$fxrate);
			$totaldepositamount = $totaldepositamount + $depositamount1;
			
			 $depositamount1uhx = $depositamount;
		   $totaldepositamountuhx = $totaldepositamountuhx + $depositamount1uhx;
			?>
			 
                  
                  
             <?php }
			 $totaladvancedepositamount = 0;
			$totaladvancedepositamountuhx=0;
			$query112 = "select * from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$advancedepositamount = $res112['transactionamount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['transactiondate'];
			
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
			$advancedepositamount = 1*($advancedepositamount/$fxrate);
			$totaldepositamount += $advancedepositamount;
			
			 $advancedepositamountuhx = $advancedepositamount;
		   $totaldepositamountuhx = $totaldepositamountuhx + $advancedepositamountuhx;
			?>
			
                  
             <?php 
			  }
			  ?>
			  		  <?php
			$totaldepositrefundamount = 0;
			$totaldepositrefundamountuhx=0;
			$query112 = "select * from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositrefundamount = $res112['amount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['recorddate'];
			
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
			$depositrefundamount = 1*($depositrefundamount/$fxrate);
			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			
			 $depositrefundamountuhx = $depositrefundamount;
		   $totaldepositrefundamountuhx = $totaldepositrefundamountuhx + $depositrefundamountuhx;
			?>
			
                  
             <?php 
			  }
			  ?>
            			  <?php 
			 
			  $depositamount = 0;
			  
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount-$totaldepositamount+$totalnhifamount+$totaldepositrefundamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $totalrevenue = $totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalmiscbillingamount;
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
			  ?>


