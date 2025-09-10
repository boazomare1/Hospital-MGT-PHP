<?php
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					$id = $res267['id'];
					
					$queryjndr = "SELECT SUM(`debitamount`) as debit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjndr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjndr) or die ("Error in queryjndr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjndr = mysqli_fetch_array($execjndr);
					$jndebit = $resjndr['debit'];
					
					$queryjncr = "SELECT SUM(`creditamount`) as credit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjncr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjncr) or die ("Error in queryjncr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjncr = mysqli_fetch_array($execjncr);
					$jncredit = $resjncr['credit'];
					
					$journal = $jncredit - $jndebit;
					
					$i = 0;
						$drresult = array();
						
						$j = 0;
						$crresult = array();
						
						$balance = array_sum($crresult) - array_sum($drresult);
						
					$waiver = 0;
					
					if($id == '01-1014-SI')
					{
						$querypw = "SELECT SUM(`servicesfxamount`) as waiver FROM `billing_patientweivers` WHERE `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execpw = mysqli_query($GLOBALS["___mysqli_ston"], $querypw) or die ("Error in querypw".mysqli_error($GLOBALS["___mysqli_ston"]));
						$respw = mysqli_fetch_array($execpw);
						$waiver = $respw['waiver'];
					}
					
					else if($id == '01-1013-SI')                 //ser unfinal
					{     //ip income rad
			       $colorloopcount ='';
			$netamount='';
			$sno=0;
			$totalradiologyitemrate =0;
			
			$totalservicesitemrate =0;
			$totalquantity = 0;
			
		//$ADate1='2015-01-31';
		//$ADate2='2015-02-28';
		$query66 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip) and consultationdate between '$ADate1' and '$ADate2'";
		$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res66 = mysqli_fetch_array($exec66))
		{
			$patientcode = $res66['patientcode'];
			$visitcode = $res66['visitcode'];
			$sno = $sno + 1;
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
			$fxrate = $execsubtype['fxrate'];
			
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
			$servicesdoctorname = $res21['doctorname'];
			$sercode=$res21['servicesitemcode'];
			$serviceledgercode=$res21['incomeledgercode'];
			$serviceledgername=$res21['incomeledgername'];
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
			
			if($servicesfree == 'No')
			{	
			$totserrate=$res21['amount'];
			 if($totserrate==0){
			$totserrate=$serrate*$numrow2111;
			  }
			//$totserrate=$serrate*$numrow2111;
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
			$balance=$totalservicesitemrate;
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
		
		
		
		}
		}
		}           //ip income lab end
			  
			  
			  //op income lab
			  $totalamount1 = '0.00';
$totalamount2 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
$totalamount5 = '0.00';
$totalamount6 = '0.00';
$totalamount7 = '0.00';
$totalamount8 = '0.00';
$totalpharmacysalesreturn  = '0.00';
$overaltotalrefund  = '0.00';
$searchsuppliername='';
			 $query21 = "select * from master_visitentry where billtype='PAY LATER' and accountfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2' AND visitcode NOT IN (SELECT visitcode FROM billing_paylater) group by accountfullname order by accountfullname desc";
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
			$labtemplate = $execsubtype['labtemplate'];
			if($labtemplate == '') { $labtemplate = 'master_lab'; }
			$radtemplate = $execsubtype['radtemplate'];
			if($radtemplate == '') { $radtemplate = 'master_radiology'; }
			$sertemplate = $execsubtype['sertemplate'];
			if($sertemplate == '') { $sertemplate = 'master_services'; }
		  
		  $res3labitemrate = 0;
		  
		  $res4servicesitemrate = 0;
		  $query4 = "select servicesitemcode,serviceqty,refundquantity from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res4 = mysqli_fetch_array($exec4))
		  {
		  	 $sercode=$res4['servicesitemcode'];
			 $serqty=$res4['serviceqty'];
			 $serrefqty=$res4['refundquantity'];
			
			 $serqty = $serqty-$serrefqty;
			
			$queryfx = "select rateperunit from $sertemplate where itemcode = '$sercode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$serrate=$resfx['rateperunit'] * $fxrate;
			$serrate = $serrate * $serqty;
			if(($planpercentage!=0.00)&&($planforall=='yes'))
			{ 
				$serrate = $serrate - ($serrate/100)*$planpercentage;
			}
			$res4servicesitemrate = $res4servicesitemrate + $serrate;
		  }
		  
		  $res5radiologyitemrate = 0;
		  
		  
		  $totalamount = $res4servicesitemrate;
		  $totalamount3 = $totalamount3 + $res4servicesitemrate;
		  
		 // $snocount = $snocount + 1;
		
			
			//echo "hi".$totalamount4;
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
	
			}
			}
			
			}    //op income lab end
				
				//echo $totalamount5;
				//echo "   hi".$totalamount3 ."bal".$balance;
				 $balance=$balance+$totalamount3;
				
					} 
					
					
				
					
					$balance = round($balance);
					$sumbalance = $sumbalance + $balance;
				}
			
?>					
