<?php
$updatedate = date('Y-m-d');
$colorloopcount='';
$totalconsultation = 0;
$searchsuppliername = '';

				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					$id = $res267['id'];
					$balance=0;
					$queryjndr = "SELECT SUM(`debitamount`) as debit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjndr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjndr) or die ("Error in queryjndr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjndr = mysqli_fetch_array($execjndr);
					$jndebit = $resjndr['debit'];
					
					$queryjncr = "SELECT SUM(`creditamount`) as credit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjncr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjncr) or die ("Error in queryjncr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjncr = mysqli_fetch_array($execjncr);
					$jncredit = $resjncr['credit'];
					
					$journal = $jncredit - $jndebit;
					
					
					if($id == '03-3002-NHL')
					{
						$i = 0;
						$drresult = array();
						
						
						$j = 0;
						$crresult = array();
						
						$incomeother = array_sum($crresult) - array_sum($drresult);
						$query21 = "select * from master_visitentry where billtype='PAY LATER' and accountfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2' AND visitcode NOT IN (SELECT visitcode FROM billing_paylater) group by accountname order by accountfullname desc";
						$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res21 = mysqli_fetch_array($exec21))
						{
						$res21accountnameano = $res21['accountname'];
						
						$query22 = "select * from master_accountname where auto_number = '$res21accountnameano' and recordstatus <>'DELETED' ";
						$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res22 = mysqli_fetch_array($exec22);
						$res22accountname = $res22['accountname'];
						$res21accountname = $res22['accountname'];
			
						if( $res21accountname != '')
						{
			
						$query2 = "select * from master_visitentry where billtype='PAY LATER' and accountname = '$res21accountnameano' and consultationdate between '$ADate1' and '$ADate2' AND visitcode NOT IN (SELECT visitcode FROM billing_paylater) order by accountfullname desc ";
						  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
						  while ($res2 = mysqli_fetch_array($exec2))
						  {
						  $res2patientcode = $res2['patientcode'];
						  $res2visitcode = $res2['visitcode'];
						  $res2patientfullname = $res2['patientfullname'];
						  $res2registrationdate = $res2['consultationdate'];
						  $res2accountname = $res2['accountfullname'];
						  $subtype = $res2['subtype'];
						  $plannumber = $res2['planname'];
						  
						  $queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
							$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
							$resplanname = mysqli_fetch_array($execplanname);
							$planforall = $resplanname['forall'];
							$planpercentage=$res2['planpercentage'];
							//$copay=($consultationfee/100)*$planpercentage;
							
						  
						  $Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$res2patientcode'");
							$execlab=mysqli_fetch_array($Querylab);
							$patientsubtype=$execlab['subtype'];
							$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
							$execsubtype=mysqli_fetch_array($querysubtype);
							$patientsubtype1=$execsubtype['subtype'];
							$patientsubtypeano=$execsubtype['auto_number'];
							$patientplan=$execlab['planname'];
							$currency=$execsubtype['currency'];
							$fxrate=$execsubtype['fxrate'];
							if($currency=='')
							{
								$currency='UGX';
							}
						  
					  $query7 = "select sum(consultationfees) as consultationfees1 from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
					  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
					  $res7 = mysqli_fetch_array($exec7);
					  $res7consultationfees = $res7['consultationfees1'] * $fxrate;
					  if(($planpercentage!=0.00)&&($planforall=='yes'))
					  { 
					  $copay=($res7consultationfees/100)*$planpercentage;
					  }
					  else
					  {
					  $copay = 0;
					  }
					  $res7consultationfees = $res7consultationfees - $copay;
					  
					  $query8 = "select sum(copayfixedamount) as copayfixedamount1 from master_billing where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
					  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					  $res8 = mysqli_fetch_array($exec8);
					  $res8copayfixedamount = $res8['copayfixedamount1'];
					  $res8copayfixedamount = 0;
					  
					  $consultation = $res7consultationfees - $res8copayfixedamount;
		  			  $totalconsultation = $totalconsultation + $consultation;

					  $res6referalrate = '0.00';
					  $query6 = "select sum(referalrate) as referalrate1 from consultation_referal where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
					  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
					  $res6 = mysqli_fetch_array($exec6);
					  $res6referalrate = $res6['referalrate1'];
					  if ($res6referalrate =='')
					  {
					  $res6referalrate = '0.00';
					  }
					  else 
					  {
					    $res6referalrate = $res6['referalrate1'] * $fxrate;
					  }
					  if(($planpercentage!=0.00)&&($planforall=='yes'))
					  { 
					  $res6referalrate=$res6referalrate - ($res6referalrate/100)*$planpercentage;
					  }
					  else
					  {
					    $res6referalrate = $res6['referalrate1'] * $fxrate;
					  }
					  $totalconsultation = $totalconsultation + $res6referalrate;
					  
					  }
					  }
					  }
					  
					  $balance = $totalconsultation + $incomeother;
						
					}
					else
					{
					$balance = 0;
					}
					$sumbalance = $sumbalance + $balance;
				}
?>					
