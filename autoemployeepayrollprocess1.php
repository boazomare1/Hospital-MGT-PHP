<?php
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";
$res15amount = '0.00';
$sumoftotalearnings = '0';
$componentvalue = 0;
$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
$locationname = $res["locationname"];
$locationcode = $res["locationcode"];

$month = date('M-Y');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }
if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = ""; }
$searchyear1 = explode('-',$assignmonth);
$searchyear = $searchyear1[1];

	$totalamount = '0.00';
	$query1 = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by typecode, order_no";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];
	$componentname = $res1['componentname'];
	
	$datatotal[$componentanum] = array();
	$totnhif10 = 0;
	$totloan = 0;
	$totgross = 0;
	$totdeduct = 0;
	$totnett = 0;	
	$totinsurance = 0;
	}
	
	$query1d = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, order_no";
	$exec1d = mysqli_query($GLOBALS["___mysqli_ston"], $query1d) or die ("Error in Query1d".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1d = mysqli_fetch_array($exec1d))
	{
	$componentanum = $res1d['auto_number'];
	$componentname = $res1d['componentname'];
	$datatotal[$componentanum] = array();
	}
	$totalamount = '0.00';
	$query2 = "select a.employeecode as employeecode, a.employeename as employeename, a.departmentname as departmentname, a.payrollstatus as payrollstatus, a.dateofjoining as doj, b.dateofbirth as dob from master_employee AS a JOIN master_employeeinfo AS b ON (a.employeecode = b.employeecode) where a.employeecode = '$employeesearch' and a.employeecode <> '' and (a.payrollstatus = 'Active' or a.payrollstatus = 'Prorata') group by a.employeecode order by cast(b.payrollno as unsigned) asc";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{	
		$searchemployeename = $res2['employeename'];
		$departmentname = $res2['departmentname'];
		$res2employeecode = $res2['employeecode'];
		$employeecode = $res2['employeecode'];
		$employeename = $res2['employeename'];
		$dob = $res2['dob'];
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
		$totaldeductearning = 0;
		
		$query777 = mysqli_query($GLOBALS["___mysqli_ston"], "select payrollno from master_employeeinfo where employeecode = '$res2employeecode'") or die ("Error in Queryinfo".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res777 = mysqli_fetch_array($query777);
		$payrollno = $res777['payrollno'];
		
		$query777 = "select employeecode from payroll_assign where employeecode = '$res2employeecode'";
		$exec777 = mysqli_query($GLOBALS["___mysqli_ston"], $query777) or die ("Error in Query777".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res777 = mysqli_fetch_array($exec777);
		$res777employeecode = $res777['employeecode'];
		
		if($res777employeecode != '' && $assignmonth != '')
		{
		$res2employeename = $res2['employeename'];
		
				$query_del = "DELETE FROM details_employeepayroll WHERE employeecode = '$employeecode' and paymonth = '$assignmonth'";
				$exec_del = mysqli_query($GLOBALS["___mysqli_ston"], $query_del) or die ("Error in Query_del".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$query_in = "INSERT INTO `details_employeepayroll`(`employeecode`, `employeename`, `paymonth`, `locationname`, `locationcode`, `ipaddress`, `username`, `updatedatetime`) VALUES('$employeecode','$employeename','$assignmonth','$locationname','$locationcode','$ipaddress','$username','$updatedatetime')";
				$exec_in = mysqli_query($GLOBALS["___mysqli_ston"], $query_in) or die ("Error in Query_in".mysqli_error($GLOBALS["___mysqli_ston"]));
				
	  
	$query3 = "select auto_number,componentname,amounttype,typecode,monthly,formula,deductearning,notional from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, order_no";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res3 = mysqli_fetch_array($exec3))
	{
		$componentanum = $res3['auto_number'];
		$employeesearch = $res2employeecode;
		$assignmonth = $assignmonth;
		$componentname = $res3['componentname'];
		$amounttype = $res3['amounttype'];
		$typecode = $res3['typecode'];
		$monthly = $res3['monthly'];
		$deductearning = $res3['deductearning'];
		$notional = $res3['notional'];
		
		if($employeesearch != '')
		{	
		$query4 = "select payrollstatus, dateofjoining as doj from master_employee where employeecode = '$employeesearch'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res4 = mysqli_fetch_array($exec4);
		$payrollstatus = $res4['payrollstatus'];
		$doj = $res4['doj'];
		$enddate = date('Y-m-t', strtotime($doj));
		$from=date_create($doj);
		$to=date_create($enddate);
		$diff=date_diff($to,$from);
		//print_r($diff);
		$workdays = $diff->d;
		
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
				$componentvalue = $perdayamt * $workdays;
				$componentvalue = ceil($componentvalue);
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
						$calc1 = ceil($calc1);
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
						$calc3 = ceil($calc3);
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
					$query32 = "select componentname, amount from payroll_assignmonthwise where componentanum = '$componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted'";
					$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res32 = mysqli_fetch_array($exec32);
					$rows32 = mysqli_num_rows($exec32);
					$res32componentname = $res32['componentname'];
					
					if($res32componentname != '' && $componentvalue > 0)
					{	
						$componentamount = $res32['amount'];
						$componentvalue = $componentamount;
					}
					else
					{
						$componentvalue = 0;
					}
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
					$componentvalue = $res15amount;
					//$totdeductamount = $totdeductamount + $componentvalue;
				}
				else if($res18basedon == 'Percent')
				{
					$totalgrossnssf1 = '0';
					$totalgrossnssf1 = number_format($sumoftotalearnings,3,'.','');
					//$totalgrossnssf1 = round_calc($totalgrossnssf1);
					
					$res15amount = $totalgrossnssf1 * ($res18percent / 100);
					$res15amount = ceil($res15amount);
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
					
					
					$componentvalue = $res15amount;		
					//$totdeductamount = $totdeductamount + $componentvalue;
				}
			
			$gratuity = '0.00';
			
			$sumoftotalearnings = $sumoftotalearnings - $gratuity;
			
			if($componentanum == '64' && $componentvalue > 0)
			{
				$componentvalue = $componentvalue + $res15amount;	
			}
			if($componentanum == '62')
			{
				$query66 = "select SUM(`62`) as componentvalue from details_employeepayroll where employeecode = '$employeesearch' and status <> 'deleted'";
				$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res66 = mysqli_fetch_array($exec66);
				$value = $res66['componentvalue'];
				$totalrelief = $componentvalue + $value;
				if($totalrelief < '1408')
				{
					$componentvalue = $totalrelief + $value;
				}
				else
				{
					$componentvalue = 0;
				}
			}
			if($typecode == '10' && $notional != 'Yes')
			{
				$sumoftotalearnings = $sumoftotalearnings + $componentvalue;
			}
			else if($typecode == '20')
			{
				//$totdeductamount = $totdeductamount + $componentvalue;
			}				
			
			if($deductearning == 'Yes')
			{
				$totaldeductearning = $totaldeductearning + $componentvalue;
			}
			
			$totaldeductearning;
			$sumoftotalearnings;
			$res19absentamount = '0';
			$sumoftotalearningsfinal = $sumoftotalearnings - $res19absentamount - $totaldeductearning;
			
			$grosspay = $sumoftotalearnings;
			
			//$taxableincome = $sumoftotalearningsfinal - $nssfamount;
			$taxableincome = $sumoftotalearningsfinal;
			$nhiftaxableincome = $sumoftotalearningsfinal;
			//$taxableincome = '8000';
			$totgrossamount = $taxableincome;
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
						
						$nhifamount = number_format($nhifamount,3,'.','');
						
					}
				}	
				
				if($componentanum == '2')
				{
					$componentvalue = $nhifamount;
					//$totdeductamount = $totdeductamount + $componentvalue;
				}
			}
			$taxableincome;
			$totalpercentcalc = '0.00';
			$balance = '';
			$totalbalance = 0;
			$j = '0';
			if($taxableincome > 0){
			$query73 = "select from1, to1, percent, difference from master_paye where status <> 'deleted'";
			$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die ("Error in Query73".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res73 = mysqli_fetch_array($exec73))
			{
				$res73from = $res73['from1'];
				$res73to = $res73['to1'];
				$res73percent = $res73['percent'];
				$template = 'Kenya';
				
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
			}
			}
			
			$totalpercentcalc;
			
			$taxrelief = '0.00';
			$insurancerelief = '0';
			$query55 = "select * from master_taxrelief where status <> 'deleted' and tyear = '$searchyear'";
			$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res55 = mysqli_fetch_array($exec55);
			$res55finalamount = $res55['finalamount'];
			if($res55finalamount != '')
			{
				$taxrelief = $res55finalamount;
			}
			
			$totalpayeeamount = $totalpercentcalc - $taxrelief - $insurancerelief;
			$totalpayeeamount = ceil($totalpayeeamount);
			if($totalpayeeamount < 0)
			{
				$totalpayeeamount = 0;
			}
			$query88 = "select employeename,govt_employee from master_employee where employeecode = '$employeesearch'";
			$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res88 = mysqli_fetch_array($exec88);
			$res88employeename = $res88['employeename'];
			$govt_employee = $res88['govt_employee'];
			if($govt_employee == 'Yes')
			{
				$query6 = "select `1` as componentvalue from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res6 = mysqli_fetch_array($exec6);
				$value = $res6['componentvalue'];
				$govt_value = $value * (30/100);
				$govt_value = ceil($govt_value);
				$totalpayeeamount = $govt_value;
			}
			$totalpayeeamount = number_format($totalpayeeamount,3,'.','');
			//$totalpayeeamount = round_calc($totalpayeeamount);
			if($componentanum == '4')
			{
				$componentvalue = $totalpayeeamount;
				//$totdeductamount = $totdeductamount + $componentvalue;
			}
		}
		
		}
		
		//$totdeductamount = $totaldeductions + $nhifamount + $totalpayeeamount;
		$totnettpay = $totgrossamount - $totdeductamount;
		
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
	
		if($typecode == '10')
		{
			//array_push($datatotal[$componentanum],$componentvalue);
			array_push($datatotal[$componentanum], ['anum' => $componentanum, 'name' => $componentname, 'value' => $componentvalue, 'typecode' => $typecode, 'type' => $type, 'bgcolor' => $typecodebgcolor]);
			
			$query_in2 = "UPDATE details_employeepayroll SET `$componentanum` = '$componentvalue' WHERE employeecode = '$employeecode' AND paymonth = '$assignmonth'";
			$exec_in2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_in2) or die ("Error in Query_in2".mysqli_error($GLOBALS["___mysqli_ston"]));

			if($monthly == 'Yes'){
				$query44 = "update payroll_assign set `$componentanum` = '0' where employeecode = '$employeecode'";
				$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in query44".mysqli_error($GLOBALS["___mysqli_ston"]));
			}

		}
	}
	
	$query3d = "select auto_number,componentname,amounttype,typecode,monthly,formula,deductearning from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, order_no";
	$exec3d = mysqli_query($GLOBALS["___mysqli_ston"], $query3d) or die ("Error in Query3d".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res3d = mysqli_fetch_array($exec3d))
	{
		$componentanum = $res3d['auto_number'];
		$employeesearch = $res2employeecode;
		$assignmonth = $assignmonth;
		$componentname = $res3d['componentname'];
		$amounttype = $res3d['amounttype'];
		$typecode = $res3d['typecode'];
		$monthly = $res3d['monthly'];
		$deductearning = $res3d['deductearning'];
		
		if($employeesearch != '')
		{	
		$query4 = "select payrollstatus from master_employee where employeecode = '$employeesearch'";
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
			
				if($amounttype == 'Percent')
				{
					$formulafrom = $res3d['formula'];
					if($formulafrom == '1')
					{
						$query6 = "select `1` as componentvalue from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
						$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res6 = mysqli_fetch_array($exec6);
						$value = $res6['componentvalue'];
						
						$calc1 = $value * ($componentvalue/100);
						$calc1 = ceil($calc1);
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
						$calc3 = ceil($calc3);
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
					$query32 = "select componentname, amount from payroll_assignmonthwise where componentanum = '$componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted'";
					$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res32 = mysqli_fetch_array($exec32);
					$rows32 = mysqli_num_rows($exec32);
					$res32componentname = $res32['componentname'];
					
					if($res32componentname != '' && $componentvalue > 0)
					{	
						$componentamount = $res32['amount'];
						$componentvalue = $componentamount;
					}
					else
					{
						$componentvalue = 0;
					}
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
					
					$componentvalue = $res15amount;
					
				}
				else if($res18basedon == 'Percent')
				{
					$totalgrossnssf1 = '0';
					$totalgrossnssf1 = number_format($sumoftotalearnings,3,'.','');
					//$totalgrossnssf1 = round_calc($totalgrossnssf1);
					
					$res15amount = $totalgrossnssf1 * ($res18percent / 100);
					$res15amount = ceil($res15amount);
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
					
					$componentvalue = $res15amount;		
					
				}
				
				if($componentanum == '64' && $componentvalue > 0)
				{
					$componentvalue = $componentvalue + $res15amount;	
				}
				
				if($typecode == '10')
				{
					$sumoftotalearnings = $sumoftotalearnings + $componentvalue;
				}
				else if($typecode == '20')
				{
					$totdeductamount = $totdeductamount + $componentvalue;
				}				
			
			$gratuity = '0.00';
			
			if($deductearning == 'Yes')
			{
				$totdeductamount = $totdeductamount - (2*$componentvalue);
			}
			
			$sumoftotalearnings = $sumoftotalearnings - $gratuity;
			
			$sumoftotalearnings;
			$res19absentamount = '0';
			
			$res19absentamount = 0;
			
			$sumoftotalearningsfinal = $sumoftotalearnings - $res19absentamount;
			
			$grosspay = $sumoftotalearnings;
			
			//$taxableincome = $sumoftotalearningsfinal - $nssfamount;
			$taxableincome = $sumoftotalearningsfinal - $totaldeductearning;
			$nhiftaxableincome = $sumoftotalearningsfinal;
			//$taxableincome = '8000';
			$totgrossamount = $taxableincome;
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
						
						$nhifamount = number_format($nhifamount,3,'.','');
						
					}
				}	
				
				if($componentanum == '2')
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
			if($taxableincome > 0){
			$query73 = "select from1, to1, percent, difference from master_paye where status <> 'deleted'";
			$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die ("Error in Query73".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res73 = mysqli_fetch_array($exec73))
			{
				$res73from = $res73['from1'];
				$res73to = $res73['to1'];
				$res73percent = $res73['percent'];
				$template = 'Kenya';
				
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
			}
			}
			
			$totalpercentcalc;
			
			$taxrelief = '0.00';
			$insurancerelief = '0';
			$query861 = "select premium, taxpercent from insurance_relief where status <> 'deleted' and includepaye = 'Yes' and employeecode = '$employeesearch'";
			$exec861 = mysqli_query($GLOBALS["___mysqli_ston"], $query861) or die ("Error in Query861".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res861 = mysqli_fetch_array($exec861))
			{
				$premium = $res861['premium'];
				$taxpercent = $res861['taxpercent'];
				$tax_calc = $premium * ($taxpercent / 100);
				$insurancerelief = $insurancerelief + $tax_calc;
			}
	
			$query55 = "select * from master_taxrelief where status <> 'deleted' and tyear = '$searchyear'";
			$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res55 = mysqli_fetch_array($exec55);
			$res55finalamount = $res55['finalamount'];
			if($res55finalamount != '')
			{
				$query88 = "select employeename,excluderelief from master_employee where employeecode = '$employeecode'";
				$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res88 = mysqli_fetch_array($exec88);
				$res88employeename = $res88['employeename'];
				$res88excluderelief = $res88['excluderelief'];
				if($res88excluderelief == 'Yes')
				{
					$taxrelief = 0;
				} else {
					$taxrelief = $res55finalamount;
				}
			}
			
			$query_in32i = "UPDATE details_employeepayroll SET tax_relief = '$taxrelief' WHERE employeecode = '$employeecode' AND paymonth = '$assignmonth'";
			$exec_in32i = mysqli_query($GLOBALS["___mysqli_ston"], $query_in32i) or die ("Error in Query_in32i".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$totalpayeeamount = $totalpercentcalc - $taxrelief - $insurancerelief;
			$totalpayeeamount = ceil($totalpayeeamount);
			if($totalpayeeamount < 0)
			{
				$query_in32 = "UPDATE details_employeepayroll SET relief_bf = '$totalpayeeamount' WHERE employeecode = '$employeecode' AND paymonth = '$assignmonth'";
				$exec_in32 = mysqli_query($GLOBALS["___mysqli_ston"], $query_in32) or die ("Error in Query_in32".mysqli_error($GLOBALS["___mysqli_ston"]));
							
				$totalpayeeamount = 0;
			}
			$query88 = "select employeename,govt_employee from master_employee where employeecode = '$employeesearch'";
			$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res88 = mysqli_fetch_array($exec88);
			$res88employeename = $res88['employeename'];
			$govt_employee = $res88['govt_employee'];
			if($govt_employee == 'Yes')
			{
				$query6 = "select `1` as componentvalue from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res6 = mysqli_fetch_array($exec6);
				$value = $res6['componentvalue'];
				$govt_value = $value * (30/100);
				$govt_value = ceil($govt_value);
				$totalpayeeamount = $govt_value;
			}
			$totalpayeeamount = number_format($totalpayeeamount,3,'.','');
			//$totalpayeeamount = round_calc($totalpayeeamount);
			if($componentanum == '4')
			{
				$componentvalue = $totalpayeeamount;
				$totdeductamount = $totdeductamount + $componentvalue;
			}
		}
		
		}
		
		//$totdeductamount = $totaldeductions + $nhifamount + $totalpayeeamount;
		$totnettpay = $totgrossamount - $totdeductamount;
		
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
	
		
			//array_push($datatotal[$componentanum],$componentvalue);
			array_push($datatotal[$componentanum], ['anum' => $componentanum, 'name' => $componentname, 'value' => $componentvalue, 'typecode' => $typecode, 'type' => $type, 'bgcolor' => $typecodebgcolor]);
			
			$query_in2d = "UPDATE details_employeepayroll SET `$componentanum` = '$componentvalue' WHERE employeecode = '$employeecode' AND paymonth = '$assignmonth'";
			$exec_in2d = mysqli_query($GLOBALS["___mysqli_ston"], $query_in2d) or die ("Error in Query_in2d".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if($monthly == 'Yes'){
			$query44 = "update payroll_assign set `$componentanum` = '0' where employeecode = '$employeecode'";
			$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in query44".mysqli_error($GLOBALS["___mysqli_ston"]));
		}

	}
	?>
	<?php
	$loanamount = 0;
	$res15amount = 0;
	$insurancerelief = 0;
	$loanamount = 0;
	$insurancerelief = 0;
	$query80 = "select sum(installmentamount) as loanamount, loanname from loan_assign where status <> 'deleted' and paymonth = '$assignmonth' and employeecode = '$employeesearch'";
	$exec80 = mysqli_query($GLOBALS["___mysqli_ston"], $query80) or die ("Error in Query80".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res80 = mysqli_fetch_array($exec80);
	$loanamount = $res80['loanamount'];	
	$loanname = $res80['loanname'];
	
	$datatotal['loan'][0] = ['anum' => '0', 'name' => $loanname, 'value' => $loanamount, 'typecode' => '20', 'type' => 'D', 'bgcolor' => '#FF0000'];
	
	$query_in2 = "UPDATE details_employeepayroll SET loandeduction = '$loanamount' WHERE employeecode = '$employeecode' AND paymonth = '$assignmonth'";
	$exec_in2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_in2) or die ("Error in Query_in2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query86 = "select sum(premium * (taxpercent / 100)) as insurancerelief, 'INSURANCE RELIEF' as insname from insurance_relief where status <> 'deleted' and includededuction = 'Yes' and employeecode = '$employeesearch'";
	$exec86 = mysqli_query($GLOBALS["___mysqli_ston"], $query86) or die ("Error in Query86".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res86 = mysqli_fetch_array($exec86);
	$insurancerelief = $res86['insurancerelief'];	
	$insname = $res86['insname'];	
	
	$datatotal['loan'][1] = ['anum' => '0', 'name' => $insname, 'value' => $insurancerelief, 'typecode' => '20', 'type' => 'D', 'bgcolor' => '#FF0000'];
	
	$query_in3 = "UPDATE details_employeepayroll SET insurancerelief = '$insurancerelief' WHERE employeecode = '$employeecode' AND paymonth = '$assignmonth'";
	$exec_in3 = mysqli_query($GLOBALS["___mysqli_ston"], $query_in3) or die ("Error in Query_in3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$totdeductamount = $totdeductamount + $loanamount + $res15amount;
	$totnettpay = $totnettpay - $loanamount - $res15amount; 
	
	$totnhif10 += $res15amount;
	$totloan += $loanamount;
	$totgross += $totgrossamount;
	$totdeduct += $totdeductamount;
	$totnett += $totnettpay;
	$totinsurance += $insurancerelief;
	
	}
	}
	//print_r($datatotal);
	//echo '<br><br><br>';
	$searchresult = '';
	
	$query_f = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec_f = mysqli_query($GLOBALS["___mysqli_ston"], $query_f) or die ("Error in Query_f".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res_f = mysqli_fetch_array($exec_f))
	{
		$i = $res_f['auto_number'];	

		$componentname = $datatotal[$i][0]['name'];
		$componentrate = $datatotal[$i][0]['value'];
		$componentunit = '1';
		$componentamount = $datatotal[$i][0]['value'];	
		$componentanum = $datatotal[$i][0]['anum'];	
		$typecodebgcolor = $datatotal[$i][0]['bgcolor'];
		$type = $datatotal[$i][0]['type'];
	
	if ($searchresult == '')
	{
		$searchresult = ''.$employeecode.'||'.$employeename.'||'.$componentname.'||'.number_format($componentrate,2,'.',',').'||'.$componentunit.'||'.number_format($componentamount,2,'.',',').'||'.$componentanum.'||'.$typecodebgcolor.'||'.$type.'||'.number_format($totgross,2,'.',',').'||'.number_format($totdeduct,2,'.',',').'||'.number_format($totnett,2,'.',',').'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$employeecode.'||'.$employeename.'||'.$componentname.'||'.number_format($componentrate,2,'.',',').'||'.$componentunit.'||'.number_format($componentamount,2,'.',',').'||'.$componentanum.'||'.$typecodebgcolor.'||'.$type.'||'.number_format($totgross,2,'.',',').'||'.number_format($totdeduct,2,'.',',').'||'.number_format($totnett,2,'.',',').'';
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
			$searchresult = $searchresult.'||^||'.$employeecode.'||'.$employeename.'||'.$loanname.'||'.number_format($componentrate,2,'.',',').'||'.$componentunit.'||'.number_format($componentamount,2,'.',',').'||'.$componentanum.'||'.$typecodebgcolor.'||'.$type.'||'.number_format($totgross,2,'.',',').'||'.number_format($totdeduct,2,'.',',').'||'.number_format($totnett,2,'.',',').'';
		}
		
		$loanname1 = $datatotal['loan'][1]['name'];
		$componentrate1 = $datatotal['loan'][1]['value'];
		$componentunit1 = '1';
		$componentamount1 = $datatotal['loan'][1]['value'];	
		$componentanum1 = $datatotal['loan'][1]['anum'];	
		$typecodebgcolor1 = $datatotal['loan'][1]['bgcolor'];
		$type1 = $datatotal['loan'][1]['type'];
		if($loanname1 != '')
		{
			$searchresult = $searchresult.'||^||'.$employeecode.'||'.$employeename.'||'.$loanname1.'||'.number_format($componentrate1,2,'.',',').'||'.$componentunit1.'||'.number_format($componentamount1,2,'.',',').'||'.$componentanum1.'||'.$typecodebgcolor1.'||'.$type1.'||'.number_format($totgross,2,'.',',').'||'.number_format($totdeduct,2,'.',',').'||'.number_format($totnett,2,'.',',').'';
		}
		
		echo $searchresult;
	?>
	
