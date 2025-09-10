<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION['username'];  
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION['companyanum'];
$grosspay = '0.00';
$totaldeductions = '0.00';
	
if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }
if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = ""; }
if (isset($_REQUEST["workdays"])) { $workdays = $_REQUEST["workdays"]; } else { $workdays = ""; }

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];

	if ($assignmonth != '')
	{	
		$searchmonthyear = $assignmonth;
		$searchemployee = $employeesearch;
		
		$query1 = "select auto_number,componentname,typecode from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res1 = mysqli_fetch_array($exec1))
		{
			$componentanum = $res1['auto_number'];
			$componentname = $res1['componentname'];
			$typecode = $res1['typecode'];
			
			$datatotal[$componentanum] = array();
			$totnhif10 = 0;
			$totloan = 0;
			$totgross = 0;
			$totdeduct = 0;
			$totnett = 0;
		}
		
	$totalamount = '0.00';
	$query2 = "select a.employeecode as employeecode, a.employeename as employeename, a.departmentname as departmentname from master_employee a where a.employeecode = '$searchemployee' and (a.payrollstatus = 'Active' or a.payrollstatus = 'Prorata') group by a.employeecode";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{	
			$employeename = $res2['employeename'];
			$employeecode = $res2['employeecode'];
			$departmentname = $res2['departmentname'];
			$res2employeecode = $res2['employeecode'];
			
			$query6 = "select dateofbirth from master_employeeinfo where employeecode = '$res2employeecode' ORDER BY employeecode";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$dob = $res6['dateofbirth'];
			if($dob == '0000-00-00')
			{
				$dob = date('Y-m-d');
			}
			$from=date_create($dob);
			$to=date_create(date('Y-m-d'));
			$diff=date_diff($to,$from);
			//print_r($diff);
			$y = $diff->y;
			
			$totalpercentcalc = '0.00';
			$sumoftotalearningsfinal = '0.00';
			$sumoftotalearnings = '0.00';
			$totgrossamount = '0.00';
			$totdeductamount = '0.00';
			$totdeductamount1 = '0.00';
			
			$query777 = "select employeecode from payroll_assign where employeecode = '$res2employeecode'";
			$exec777 = mysqli_query($GLOBALS["___mysqli_ston"], $query777) or die ("Error in Query777".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res777 = mysqli_fetch_array($exec777);
			$res777employeecode = $res777['employeecode'];
			
			if($res777employeecode != '')
			{
				$res2employeename = $res2['employeename'];
			
			$query3 = "select auto_number,componentname,amounttype,typecode,monthly,formula from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res3 = mysqli_fetch_array($exec3))
			{
					$componentanum = $res3['auto_number'];
					$employeesearch = $res2employeecode;
					$assignmonth = $searchmonthyear;
					$componentname = $res3['componentname'];
					$amounttype = $res3['amounttype'];
					$typecode = $res3['typecode'];
					$monthly = $res3['monthly'];
					
					if($employeesearch != '')
					{	
					$query4 = "select payrollstatus, dateofjoining as doj from master_employee where employeecode = '$employeesearch'";
					$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res4 = mysqli_fetch_array($exec4);
					$payrollstatus = $res4['payrollstatus'];
					
					if($payrollstatus == 'Active' || $payrollstatus == 'Prorata')
					{
						$query5 = "select `$componentanum` as componentvalue, auto_number from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
						$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res5 = mysqli_fetch_array($exec5))
						{
							$anum = $res5['auto_number'];
							$componentanum = $componentanum;
							$componentvalue = $res5['componentvalue'];
							if($payrollstatus == 'Prorata')
							{
							$componentvalue1 = $res5['componentvalue'];
							$perdayamt = ($componentvalue1 / 30);
							$componentvalue = $perdayamt;
							$componentvalue = number_format($componentvalue,2,'.','');
							}
						
							if($amounttype == 'Percent')
							{
								$formulafrom = $res3['formula'];
								if($formulafrom == '1')
								{
									$query6 = "select `1` as componentvalue from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
									$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
									$res6 = mysqli_fetch_array($exec6);
									$value = $res6['componentvalue'];
									
									$calc1 = $value * ($componentvalue/100);
									$calc1 = number_format($calc1,3,'.','');
									//$calc1 = round_calc($calc1);
									
									$query7 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
									$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
									$res7 = mysqli_fetch_array($exec7);
									$notexceed = $res7['notexceed'];
									if($notexceed != '0.00')
									{
										if($calc1 > $notexceed)
										{
											$resamount = $notexceed;
										}
										else
										{
											$resamount = $calc1;
										}
									}
									else
									{
										$resamount = $calc1;
									}
									
									$componentvalue = $resamount;
									
								}
								
								else if($formulafrom == 'Gross')
								{
									$totalgrossper = 0;
									$query12 = "select auto_number as ganum from master_payrollcomponent where typecode = '10' and auto_number <> '$componentanum' and recordstatus <> 'deleted'";
									$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($res12 = mysqli_fetch_array($exec12))
									{
										$ganum = $res12['ganum'];
										
										$querygg = "select `$ganum` as res12value from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
										$execgg = mysqli_query($GLOBALS["___mysqli_ston"], $querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));
										$resgg = mysqli_fetch_array($execgg);
										$res12value = $resgg['res12value'];
										$totalgrossper = $totalgrossper + $res12value;
									}
									$calc3 = $totalgrossper * ($componentvalue / 100);
									$calc3 = number_format($calc3,3,'.','');
									//$calc3 = round_calc($calc3);
									
									$query13 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
									$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
									$res13 = mysqli_fetch_array($exec13);
									$notexceed = $res13['notexceed'];
									if($notexceed != '0.00')
									{
										if($calc3 > $notexceed)
										{
											$resamount = $notexceed;
										}
										else
										{
											$resamount = $calc3;
										}
									}
									else
									{
										$resamount = $calc3;
									}	
									
									$componentvalue = $resamount;
								}
								else
								{
									
								}
							}	
							else
							{
								$componentvalue = $componentvalue;
							}
							
							if($monthly == 'Yes')
							{
								$query32 = "select componentname, amount from payroll_assignmonthwise where componentanum = '$componentanum' and employeecode = '$employeesearch' and assignmonth = '$searchmonthyear' and status <> 'deleted'";
								$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
								$res32 = mysqli_fetch_array($exec32);
								$rows32 = mysqli_num_rows($exec32);
								$res32componentname = $res32['componentname'];
								
								if($res32componentname != '')
								{	
									$componentamount = $res32['amount'];
									$componentvalue = $componentamount;
								}
								else
								{
									$componentvalue = $res32['amount'];
								}
							}	
							
							if($typecode == '10')
							{
								$sumoftotalearnings = $sumoftotalearnings + $componentvalue;
							}
							else if($typecode == '20')
							{
								$totdeductamount = $totdeductamount + $componentvalue;
							}				
						
							$sumofcomponent51 = '0';				
							$sumofcomponent55 = '0';
						
							$query18 = "select amount,percent,basedon from master_nssf where componentanum = '$componentanum' and status <> 'deleted'";
							$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res18 = mysqli_fetch_array($exec18);
							$res18amount = $res18['amount'];
							$res18percent = $res18['percent'];
							$res18basedon = $res18['basedon'];
							if($res18basedon == 'Amount')
							{	
								$res15amount = number_format($res18amount,3,'.','');
								//$res15amount = round_calc($res15amount);
								
								$query88 = "select employeename,excludenssf from master_employee where employeecode = '$employeesearch'";
								$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
								$res88 = mysqli_fetch_array($exec88);
								$res88employeename = $res88['employeename'];
								$res88excludenssf = $res88['excludenssf'];
								
								if($res88excludenssf == 'Yes')
								{
								$res15amount = 0;
								}
								else
								{
								}
								if($y > '60')
								{
									$res15amount = 0;	
								}
								$componentvalue = $res15amount;
								$totdeductamount = $totdeductamount + $componentvalue;
							}
							else if($res18basedon == 'Percent')
							{
								$totalgrossnssf1 = '0';
								$totalgrossnssf1 = number_format($sumoftotalearnings,3,'.','');
								//$totalgrossnssf1 = round_calc($totalgrossnssf1);
								
								$res15amount = $totalgrossnssf1 * ($res18percent / 100);
								$res15amount = number_format($res15amount,3,'.','');
								//$res15amount = round_calc($res15amount);
								
								$query88 = "select employeename,excludenssf from master_employee where employeecode = '$employeesearch'";
								$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
								$res88 = mysqli_fetch_array($exec88);
								$res88employeename = $res88['employeename'];
								$res88excludenssf = $res88['excludenssf'];
								
								if($res88excludenssf == 'Yes')
								{
								$res15amount = 0;
								}
								else
								{
								}	
								if($y > '60')
								{
									$res15amount = 0;	
								}
								$componentvalue = $res15amount;		
								$totdeductamount = $totdeductamount + $componentvalue;
							}
						
						$gratuity = '0.00';
						
						$sumoftotalearnings = $sumoftotalearnings - $gratuity;
						
						$sumoftotalearnings;
						$res19absentamount = '0';
						
						$res19absentamount = 0;
						$totaldeductearning = 0;
						$sumoftotalearningsfinal = $sumoftotalearnings - $res19absentamount - $totaldeductearning;
						
						$grosspay = $sumoftotalearnings;
						
						//$taxableincome = $sumoftotalearningsfinal - $nssfamount;
						$taxableincome = $sumoftotalearningsfinal;
						$nhiftaxableincome = $sumoftotalearningsfinal;
						//$taxableincome = '8000';
						$totgrossamount = $taxableincome * $workdays;
						$totgrossamount = round($totgrossamount);
						$nhifamount = 0;
						
							$query72 = "select from1, to1, amount from master_nhif where status <> 'deleted'";
							$exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query72".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($res72 = mysqli_fetch_array($exec72))
							{
								$res72from = $res72['from1'];
								$res72to = $res72['to1'];
							
								if($nhiftaxableincome >= $res72from && $nhiftaxableincome <= $res72to)
								{
									$query341 = "select excludenhif from master_employee where employeecode = '$employeesearch'";
									$exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die ("Error in Query341".mysqli_error($GLOBALS["___mysqli_ston"]));
									$res341 = mysqli_fetch_array($exec341);
									$res34excludenhif = $res341['excludenhif'];
									if($res34excludenhif == 'Yes')
									{
									$nhifamount = '0';
									}
									else
									{
									$nhifamount = $res72['amount'];
									}
									
									$assignmonthsplit = explode('-',$assignmonth);
									$assignmonthnhif = $assignmonthsplit[0];
									if($assignmonthnhif == 'Jul' || $assignmonthnhif == 'Aug') {
									$nhifamount = ($nhifamount / 2);
									$nhifamount = number_format($nhifamount,3,'.','');
									} else {
									$nhifamount = '0.00';
									}
								}
							}	
							
							if($componentanum == '6')
							{
								$componentvalue = $nhifamount;
								$totdeductamount = $totdeductamount + $componentvalue;
							}
						}
						$taxableincome;
						$totalpercentcalc = '0.00';
						$balance = '';
						$totalbalance = 0;
						$j = '0';
						$query73 = "select from1, to1, percent, template, difference, addgross, deductgross from master_paye where status <> 'deleted'";
						$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die ("Error in Query73".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res73 = mysqli_fetch_array($exec73))
						{
							$res73from = $res73['from1'];
							$res73to = $res73['to1'];
							$res73percent = $res73['percent'];
							$template = $res73['template'];
							
							if($template == 'Kenya')
							{
								if($taxableincome >= $res73from && $taxableincome <= $res73to)
								{
									$difference = $res73['difference'];
									if($balance == "")
									{
										$payepercentcalc = $taxableincome * ($res73percent / 100);
									}
									else
									{
										$payepercentcalc = $balance * ($res73percent / 100);
									}
									$totalpercentcalc = $totalpercentcalc + $payepercentcalc;
									$j = '1';
								}
								else
								{
									if($j == '0')
									{
										$difference = $res73['difference'];
										if($balance == '')
										{
											$balance = $taxableincome - $difference;
										}
										else
										{
											$balance = $balance - $difference;
										}
										
										$payepercentcalc = $difference * ($res73percent / 100);
										$totalpercentcalc = $totalpercentcalc + $payepercentcalc;
									}
								}
							}
							else if($template == 'Uganda')
							{
								$res73add = $res73['addgross'];
								$res73deduct = $res73['deductgross'];
								if($taxableincome >= $res73from && $taxableincome <= $res73to)
								{
									$payepercentcalc = $res73add + (($taxableincome - $res73deduct) * ($res73percent / 100));   //10000+(Gross-335000)*20%
									$totalpercentcalc = $totalpercentcalc + $payepercentcalc;
								}
							}		
						}
						
						$totalpercentcalc;
						if($componentanum == '8')
						{
							$componentvalue = $totalpercentcalc;
							$totdeductamount = $totdeductamount + $componentvalue;
						}
						$taxrelief = '0.00';
						$insurancerelief = '0';
						
						//$totalpayeeamount = $totalpercentcalc - $taxrelief - $insurancerelief;
						$totalpayeeamount = $totalpercentcalc;
						$totalpayeeamount = number_format($totalpayeeamount,3,'.','');
						//$totalpayeeamount = round_calc($totalpayeeamount);
					}
					
					}
					
					//$totdeductamount = $totaldeductions + $nhifamount + $totalpayeeamount;
					//$totnettpay = $totgrossamount - $totdeductamount;
					
					if($typecode == 20)
					{
						$typecodebgcolor = "#FF0000";
						$type = 'D';
					}
					else
					{
						$typecodebgcolor = "#00CC00";
						$type = 'E';
					}	
					
					array_push($datatotal[$componentanum], ['anum' => $componentanum, 'name' => $componentname, 'value' => $componentvalue, 'typecode' => $typecode, 'type' => $type, 'bgcolor' => $typecodebgcolor]);
				}	
				
				$loanamount = 0;
				$query80 = "select sum(installmentamount) as loanamount, loanname from loan_assign where status <> 'deleted' and paymonth = '$assignmonth' and employeecode = '$employeesearch'";
				$exec80 = mysqli_query($GLOBALS["___mysqli_ston"], $query80) or die ("Error in Query80".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res80 = mysqli_fetch_array($exec80);
				$loanamount = $res80['loanamount'];	
				$loanname = $res80['loanname'];
				
				$datatotal['loan'][0] = ['anum' => '0', 'name' => $loanname, 'value' => $loanamount, 'typecode' => '20', 'type' => 'D', 'bgcolor' => '#FF0000'];
				
				$totdeductamount = $totdeductamount * $workdays;
				$totdeductamount = round($totdeductamount);
				$totdeductamount = $totdeductamount + $loanamount;
				$totnettpay = $totgrossamount - $totdeductamount; 
				
				$totnhif10 += $res15amount;
				$totloan += $loanamount;
				$totgross += $totgrossamount;
				$totdeduct += $totdeductamount;
				$totnett += $totnettpay;	
			}
		}
	}
	
	/*print_r($datatotal);
	echo '<br><br><br>';*/
	$totgross = $totgross;
	$totdeduct = $totdeduct;
	$totnett = $totnett;
	//echo '<br>';
	$searchresult = '';
	
	$query_f = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec_f = mysqli_query($GLOBALS["___mysqli_ston"], $query_f) or die ("Error in Query_f".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res_f = mysqli_fetch_array($exec_f))
	{
		$i = $res_f['auto_number'];	

		$componentname = $datatotal[$i][0]['name'];
		$componentrate = $datatotal[$i][0]['value'];
		$componentunit = $workdays;
		$componentamount = $componentrate * $componentunit;	
		$componentamount = round($componentamount);
		$componentanum = $datatotal[$i][0]['anum'];	
		$typecodebgcolor = $datatotal[$i][0]['bgcolor'];
		$type = $datatotal[$i][0]['type'];
	
	if ($searchresult == '')
	{
		$searchresult = ''.$employeecode.'||'.$employeename.'||'.$componentname.'||'.number_format($componentrate,3,'.',',').'||'.$componentunit.'||'.number_format($componentamount,3,'.',',').'||'.$componentanum.'||'.$typecodebgcolor.'||'.$type.'||'.number_format($totgross,3,'.',',').'||'.number_format($totdeduct,3,'.',',').'||'.number_format($totnett,3,'.',',').'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$employeecode.'||'.$employeename.'||'.$componentname.'||'.number_format($componentrate,3,'.',',').'||'.$componentunit.'||'.number_format($componentamount,3,'.',',').'||'.$componentanum.'||'.$typecodebgcolor.'||'.$type.'||'.number_format($totgross,3,'.',',').'||'.number_format($totdeduct,3,'.',',').'||'.number_format($totnett,3,'.',',').'';
	}
			
	}
	
		$loanname = $datatotal['loan'][0]['name'];
		$componentrate = $datatotal['loan'][0]['value'];
		$componentunit = '1';
		$componentamount = $datatotal['loan'][0]['value'];	
		$componentanum = $datatotal['loan'][0]['anum'];	
		$typecodebgcolor = $datatotal['loan'][0]['bgcolor'];
		$type = $datatotal['loan'][0]['type'];
		if($loanname != '')
		{
			$searchresult = $searchresult.'||^||'.$employeecode.'||'.$employeename.'||'.$loanname.'||'.number_format($componentrate,3,'.',',').'||'.$componentunit.'||'.number_format($componentamount,3,'.',',').'||'.$componentanum.'||'.$typecodebgcolor.'||'.$type.'||'.number_format($totgross,3,'.',',').'||'.number_format($totdeduct,3,'.',',').'||'.number_format($totnett,3,'.',',').'';
		}
		
		echo $searchresult;
	
	?>
