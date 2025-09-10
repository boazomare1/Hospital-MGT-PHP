<?php
include ("db/db_connect.php");
$amount1 = 0;
$amount2 = 0;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = "2017-01-01"; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
if (isset($_REQUEST["frmflag"])) { $frmflag = $_REQUEST["frmflag"]; } else { $frmflag = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
?>
<script type="text/javascript">
function totalsum()
{
	var debit = document.getElementById("debit").value;
	var credit = document.getElementById("credit").value;
	
	var diff = parseFloat(credit) - parseFloat(debit);
	var diff = parseFloat(diff);
	if(diff > 0)
	{
	debit = parseFloat(debit) + parseFloat(diff);
	diff = parseFloat(diff).toFixed(2);
	diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	//var diff = diff.substr(diff.length - 6);
	document.getElementById("suspenseleft").value = diff;
	document.getElementById("suspenseright").value = "0.00";
	}
	else
	{
	diff = Math.abs(diff);
	credit = parseFloat(credit) + parseFloat(diff);
	diff = parseFloat(diff).toFixed(2);
	diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	//var diff = diff.substr(diff.length - 6);
	document.getElementById("suspenseright").value = diff;
	document.getElementById("suspenseleft").value = "0.00";
	}
	debit = parseFloat(debit).toFixed(2);
	debit = debit.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	credit = parseFloat(credit).toFixed(2);
	credit = credit.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	
	document.getElementById("debit").value = debit;
	document.getElementById("credit").value = credit;
}
</script>
<table border="1" width="100%" style="border-collapse:collapse;">
<tr>
<td colspan="12" align="center" valign="middle"><strong>NAKASERO HOSPITAL</strong></td>
</tr>
<tr>
<td colspan="12" align="center" valign="middle"><strong>OP Unfinal Reconcile</strong></td>
</tr>
<form method="post" action="">
<tr>
<td colspan="12" align="center" valign="middle"><strong>From &nbsp; <input type="date" name="ADate1" value="<?= $ADate1; ?>" />&nbsp; To &nbsp; <input type="date" name="ADate2" value="<?= $ADate2; ?>" />&nbsp;</strong>
<input type="hidden" name="frmflag" value="frmflag" />
<input type="hidden" name="cbfrmflag1" value="cbfrmflag1" />
<input type="submit" name="submit" value="Submit" /></td>
</tr>
</form>
<?php if($frmflag == 'frmflag') { ?>
<?php 
$ipunfinalizeamount='';
$ipfinalizedamount='';
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
$depbalance = "0.00";
$sno=0;
$colorloopcount = 0;
$updatedate = date('Y-m-d');
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
		
		
		
		//deposit
			
		$colorloopcount = '';
		$orderid1 = '';
		$lid = '';
		$openingbalance = "0.00";
		$sumopeningbalance = "0.00";
		$totalamount2 = '0.00';
		$totalamount12 = '0.00';
		$depbalance = '0.00';
		$sumbalance = '0.00';
		$parentid=21;
		if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
		if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
		$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
		$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res267 = mysqli_fetch_array($exec267))
		{  
			$accountsmain2 = $res267['accountname'];
			$orderid1 = $orderid1 + 1;
			$parentid2 = $res267['auto_number'];
			$ledgeranum = $parentid2;
			//$id2 = $res2['id'];
			$id = $res267['id'];
			//$id2 = trim($id2);
			$lid = $lid + 1;
			$opening = 0;
			$depbalance = 0;

		}
			//deposit		  
}
?>
<tr>
  <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
  <td colspan="2" bgcolor="#ecf0f5" class="bodytext31"><strong>IP Unfinalized</strong></td>
  <td align="right" valign="center">&nbsp;</td>
<tr <?php //echo $colorcode; ?>>
  <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>No.</strong></td>
  <td align="left" valign="center" bgcolor="#FFFFFF" class="style3">Head</td>
  <td align="right" valign="center" bgcolor="#FFFFFF" class="style3">Value</td>
  <td align="right" valign="center">&nbsp;</td>
</tr>
<tr <?php //echo $colorcode; ?>>
  <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '1'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
	<div class="bodytext31"><a target="_blank" href="ipunfinaladmncharges.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Admission Charges</a></div>              </td>
<td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totaladmncharges,2,'.',','); ?></div></td>
   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
</tr>
<tr <?php //echo $colorcode; ?>>
  <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '1'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
	<div class="bodytext31"><a target="_blank" href="ipunfinalbedcharges.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Bed Charges</a></div>              </td>
<td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalbedcharges,2,'.',','); ?></div></td>
   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
</tr>

<tr <?php //echo $colorcode; ?>>
  <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '2'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
	<div class="bodytext31"><a target="_blank" href="ipunfinalbedtransfercharges.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Bed Transfer Charges</a></div>              </td>
<td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalbedtransfercharges,2,'.',','); ?></div></td>
   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
</tr>

<tr <?php //echo $colorcode; ?>>
  <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '3'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
	<div class="bodytext31"><a target="_blank" href="ipunfinalpackagecharges.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Package Charges</a></div>              </td>
<td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalpackage,2,'.',','); ?></div></td>
   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
</tr>

<tr <?php //echo $colorcode; ?>>
  <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '4'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
	<div class="bodytext31"><a target="_blank" href="ipunfinallab.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Lab</a></div>              </td>
   <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($labtotal,2,'.',','); ?></div></td>
   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
</tr>
<tr <?php //echo $colorcode; ?>>
  <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left"><?php echo '5'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left">
	<div class="bodytext31"><a target="_blank" href="ipunfinalradio.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Radiology</a></div>              </td>
   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalradiologyitemrate,2,'.',','); ?></div></td>
   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
</tr>
<tr <?php //echo $colorcode; ?>>
  <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '6'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
	<div class="bodytext31"><a target="_blank" href="ipunfinalservice.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Service</a></div>              </td>
   <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalservicesitemrate,2,'.',','); ?></div></td>
   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
</tr>
<tr <?php //echo $colorcode; ?>>
  <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '7'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
	<div class="bodytext31"><a target="_blank" href="ipunfinalprivatedoctor.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Private Doctor</a></div>              </td>
   <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></div></td>
   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
</tr>
<tr <?php //echo $colorcode; ?>>
  <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left"><?php echo '8'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left">
	<div class="bodytext31"><a target="_blank" href="ipunfinalpharmacy.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Pharmacy</a></div>              </td>
   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalpharmacysaleamount,2,'.',','); ?></div></td>
   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
</tr>
<tr <?php //echo $colorcode; ?>>
  <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left"><?php echo '9'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left">
	<div class="bodytext31"><a target="_blank" href="ipunfinalpharmacyreturn.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Pharmacy Return</a></div>              </td>
   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div class="bodytext31"><?php echo number_format('-'.$totalpharmacysalereturnamount,2,'.',','); ?></div></td>
   <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
</tr>
<tr <?php //echo $colorcode; ?>>
  <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '10'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
	<div class="bodytext31"><a target="_blank" href="ipunfinalambulance.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Ambulance</a></div>              </td>
   <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalambulanceamount,2,'.',','); ?></div></td>
   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
</tr>
  <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '11'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
	<div class="bodytext31"><a target="_blank" href="ipunfinalipmisc.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">IPMISC</a></div>              </td>
   <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalipmis,2,'.',','); ?></div></td>
   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
</tr>
<tr <?php //echo $colorcode; ?>>
  <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '12'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
	<div class="bodytext31"><a target="_blank" href="ipunfinalipdiscount.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">IP Discount</a></div>              </td>
   <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format('-'.$totaldiscountrate,2,'.',','); ?></div></td>
   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
</tr>

 <tr <?php //echo $colorcode; deposit ?>>
  <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '13'; ?></td>
   <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
	<div class="bodytext31"><a href="ipunfinaldeposit.php?group=<?= $parentid; ?>&&ledgerid=<?= $id; ?>&&ledgeranum=<?= $ledgeranum; ?>&&location=<?= $location; ?>&&ADate1=<?= $ADate1; ?>&&ADate2=<?= $ADate2; ?>&&ledger=<?= $accountsmain2; ?>&&cbfrmflag1=cbfrmflag1" target="_blank">Patient Deposits</a></div>              </td>
   <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($depbalance,2,'.',','); ?></div></td>
   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
</tr>
<?php
$ipunfinalizeamount=$totaladmncharges+$labtotal+$totalradiologyitemrate+$totalservicesitemrate+$totalprivatedoctoramount+$totalpharmacysaleamount-$totalpharmacysalereturnamount+$totalambulanceamount+$totalipmis-$totaldiscountrate+$totalbedcharges+$totalbedtransfercharges+$totalpackage+$depbalance;
?>
<tr>
<td colspan="2"  class="bodytext31" valign="center"  align="right" 
bgcolor="#ecf0f5"><strong>Net Revenue:</strong></td>
<td align="right" valign="center" 
bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($ipunfinalizeamount,2,'.',','); ?></strong></td>
<td align="right" valign="center">&nbsp;</td>
</tr>	
<?php
} 
?>
</table>
<table width="100%" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
			<tr>
			<td>
<table width="600" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
			<input type="hidden" name="ledgerid" id="ledgerid">
            <?php
			function subgroup1($parentid,$orderid,$sid,$section)
			{	
				$colorloopcount = '';
				$ledgeramount = "0.00";
				$ledgeramountsum = "0.00";
				$ledgeramountsum1 = "0.00";
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
				$query2 = "select accountssub,auto_number,tbinclude,tbledgerview,tbclosing from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted' order by accountssub";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2 = mysqli_fetch_array($exec2))
				{  
					$accountsmain2 = $res2['accountssub'];
					$orderid1 = $orderid + 1;
					$parentid2 = $res2['auto_number'];
					$sid = $sid + 1;
					$tbinclude = $res2['tbinclude'];
					$tbledgerview = $res2['tbledgerview'];
					$tbclosing = $res2['tbclosing'];
					
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
					$ledgeramount = ledgervalue($parentid2,$ADate1,$ADate2,$tbinclude,$tbclosing);
					$ledgeramountsum = $ledgeramountsum + $ledgeramount;
					?>
					<tr style="display" id="<?php echo $sid; ?>" <?php echo $colorcode; ?>> 
					<td width="695" align="left" class="bodytext3" style="text-decoration:none">
					<?php for($i=0;$i<$orderid1;$i++)
					{
						echo '&nbsp;&nbsp;&nbsp;';
					}
					echo $parentid2;
					?>
					<strong>&nbsp;<a href="javascript:subgroupview('<?php echo $parentid2.'10000';?>')" class="bodytext44"><!--<span id="arrmain<?php echo $parentid2.'10000';?>">&#9658;</span>-->&nbsp;</a></strong>
					<a href="<?= $tbledgerview; ?>?groupid=<?php echo $parentid2; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&location=<?php echo $location; ?>" target="_blank"><strong>
					<?php echo $accountsmain2; ?></strong></a></td>
					<td width="100" align="right" class="bodytext3"><strong><?php echo number_format($ledgeramount,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
					</tr>
					<?php
				}
				if($parentid == '6')
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
					$unrealized =0;
					//include 'tb_unrealized.php';
					$ledgeramountsum = $ledgeramountsum + $unrealized;
				?>
				
				<tr style="display" id="<?php echo $sid; ?>" <?php echo $colorcode; ?>> 
					<td width="695" align="left" class="bodytext3" style="text-decoration:none">
				<?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;99';?><strong>&nbsp;&nbsp;&nbsp;&nbsp;</strong><strong style="color:#0000CC; font-size:11px">UNREALIZED REVENUE</strong></td>
				<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($unrealized,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
				</tr>
				<?php
				}
				?>
				<tr bgcolor="#ecf0f5">
				<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
				<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($ledgeramountsum,2,'.',','); $GLOBALS['$ledgeramountsumtotal'] = $ledgeramountsum; + $GLOBALS['$ledgeramountsumtotal'];?></strong>&nbsp;&nbsp;</td>
				</tr>
				<?php
				
				groupleft($ledgeramountsum);
			}
			function groupleft($a)
			{
			static $ledgeramountsumtotal1='0';
			$ledgeramountsumtotal1 = $ledgeramountsumtotal1 + $a;
			return $ledgeramountsumtotal1;
			}
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			//echo $ADate1;
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			//echo $ADate2;

		  
			  $snocount = "";
			$query1 = "select accountsmain,auto_number,section from master_accountsmain where recordstatus <> 'deleted' and section IN ('A','E') order by section, auto_number, accountsmain";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			{  
			$accountsmain = $res1['accountsmain'];
			$parentid = $res1['auto_number'];
			$orderid = 1;
			$section = $res1['section'];
			//$orderid = $res1['orderid'];
			$type = substr($accountsmain,0,1);
	
			?>
			<tr bgcolor="#0033FF">
			<td width="695" align="left" class="bodytext3" style="color:#FFFFFF"><strong>&nbsp;<a href="javascript:subgroupview('<?php echo $parentid.'10000';?>')" class="bodytext44" style="color:#FFFFFF"><!--<span id="arrmain<?php echo $parentid.'10000';?>">&#9658;</span>--></a>&nbsp;<?php echo $accountsmain; ?></strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#FFFFFF"><strong><?php //echo number_format($totalamount12,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>
			<?php		
			$querygroup2 = "select accountsmain from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted'";
			$execgroup2 = mysqli_query($GLOBALS["___mysqli_ston"], $querygroup2) or die ("Error in Querygroup2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numgroup2= mysqli_num_rows($execgroup2); 
			if($numgroup2>0){ subgroup1($parentid,$orderid,$parentid.'10000',$section); }
			//$ledgeramountsum = subgroup1();
			?>
			<!--<tr bgcolor="#ecf0f5">
			<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($ttlamt,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>-->
			<?php
			}
			
			}
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			?>
			<tr bgcolor="#ecf0f5">
			<td width="695" align="left" class="bodytext3" style="color:;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><?php echo 'SUSPENSE ACCOUNT'; ?></a></strong></td>
			<td width="100" align="right" class="bodytext3" style="color:;"><input type="text" id="suspenseleft" value="" readonly="readonly" style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
			<?php
			}
			?>
			<tr bgcolor="#999999">
			<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php $groupleft12 = groupleft('0'); //echo number_format($groupleft12,2,'.',','); ?></strong>
			<input type="text" id="debit" value="<?php echo number_format($groupleft12,2,'.',''); ?>" readonly="readonly" style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
</table>
</td>
 <td width="54%" valign="top"><table width="600" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
            <?php
			function subgroup12($parentid,$orderid,$sid,$section)
			{	
				$colorloopcount = '';
				$ledgeramount = '0.00';
				$ledgeramountsum = "0.00";
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
				$query2 = "select accountssub, auto_number,tbinclude,tbledgerview,tbclosing from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted' order by accountssub";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2 = mysqli_fetch_array($exec2))
				{  
					$accountsmain2 = $res2['accountssub'];
					$orderid1 = $orderid + 1;
					$parentid2 = $res2['auto_number'];
					$sid = $sid + 1;
					$tbinclude = $res2['tbinclude'];
					$tbledgerview = $res2['tbledgerview'];
					$tbclosing = $res2['tbclosing'];
					
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
					$ledgeramount = ledgervalue($parentid2,$ADate1,$ADate2,$tbinclude,$tbclosing);
					$ledgeramountsum = $ledgeramountsum + $ledgeramount;
					?>
					<tr style="display" id="<?php echo $sid; ?>" <?php echo $colorcode; ?>> 
					<td width="695" align="left" class="bodytext3" style="text-decoration:none">
					<?php for($i=0;$i<$orderid1;$i++)
					{
						echo '&nbsp;&nbsp;&nbsp;';
					}
					echo $parentid2;
					?>
					<strong>&nbsp;<a href="javascript:subgroupview('<?php echo $parentid2.'10000';?>')" class="bodytext44"><!--<span id="arrmain<?php echo $parentid2.'10000';?>">&#9658;</span>-->&nbsp;</a></strong>
					<a href="<?= $tbledgerview; ?>?groupid=<?php echo $parentid2; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&location=<?php echo $location; ?>" target="_blank"><strong><?php echo $accountsmain2; ?></strong></a></td>
					<td width="100" align="right" class="bodytext3"><strong><?php echo number_format($ledgeramount,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
					</tr>
					<?php
					
				}
				?>
				<tr bgcolor="#ecf0f5">
				<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
				<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($ledgeramountsum,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
				</tr>
				<?php
				groupright($ledgeramountsum);
			}
			
			function groupright($b)
			{
				static $ledgeramountsumtotal5 = '0';
				$ledgeramountsumtotal5 = $ledgeramountsumtotal5 + $b;
				return $ledgeramountsumtotal5;
			}
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			//echo $ADate1;
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			//echo $ADate2;

		  
			  $snocount = "";
			$query1 = "select accountsmain,auto_number,section from master_accountsmain where recordstatus <> 'deleted' and section IN ('I','L') order by section, auto_number desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			{  
			$accountsmain = $res1['accountsmain'];
			$parentid = $res1['auto_number'];
			$orderid = 1;
			$section = $res1['section'];
			$type = substr($accountsmain,'0','1');
			//$orderid = $res1['orderid'];
			?>
			<tr bgcolor="#009900">
			<td width="695" align="left" class="bodytext3" style="color:#FFFFFF"><strong>&nbsp;&nbsp;<?php echo $accountsmain; ?></strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#FFFFFF"><strong><?php //echo number_format($totalamount12,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>
			<?php		
			$querygroup2 = "select accountsmain from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted'";
			$execgroup2 = mysqli_query($GLOBALS["___mysqli_ston"], $querygroup2) or die ("Error in Querygroup2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numgroup2= mysqli_num_rows($execgroup2); 
			if($numgroup2>0){ subgroup12($parentid,$orderid,$parentid.'10000',$section); }
			
			}
			
			}
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			?>
			<tr bgcolor="#ecf0f5">
			<td width="695" align="left" class="bodytext3" style="color:;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><?php echo 'SUSPENSE ACCOUNT'; ?></a></strong></td>
			<td width="100" align="right" class="bodytext3" style="color:;"><input type="text" id="suspenseright" value="" readonly="readonly" style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
			<?php
			}
			?>
			<tr bgcolor="#999999">
			<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php $groupright12 = groupright(0); //echo number_format($groupright12,2,'.',','); ?></strong>
			<input type="text" id="credit" value="<?php echo number_format($groupright12,2,'.',''); ?>" readonly="readonly" style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			?>
			<script type="text/javascript">
			totalsum();
			</script>
			<?php
			}
			?>
</table>
</td>
</tr>
</table>
<?php
function ledgervalue($parentid,$ADate1,$ADate2,$tbinclude,$tbclosing)
{
	$orderid1 = 0;
	$lid = 0;
	$sumbalance = 0;
	$allid = '';
	$sno =0;
	$colorloopcount='';
	
$snocount='';
$ipunfinalizeamount='';
$ipfinalizedamount='';
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
$depbalance = "0.00";
	
	if($parentid != '' && $tbinclude != '')
	{
		if($parentid == '15')
		{
			$updatedate = date('Y-m-d');
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
		
		
		
		//deposit
			
		$colorloopcount = '';
		$orderid1 = '';
		$lid = '';
		$openingbalance = "0.00";
		$sumopeningbalance = "0.00";
		$totalamount2 = '0.00';
		$totalamount12 = '0.00';
		$depbalance = '0.00';
		$sumbalance = '0.00';
		$parentid=21;
		if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
		if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
		$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
		$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res267 = mysqli_fetch_array($exec267))
		{  
			$accountsmain2 = $res267['accountname'];
			$orderid1 = $orderid1 + 1;
			$parentid2 = $res267['auto_number'];
			$ledgeranum = $parentid2;
			//$id2 = $res2['id'];
			$id = $res267['id'];
			//$id2 = trim($id2);
			$lid = $lid + 1;
			$opening = 0;
			$depbalance = 0;
		}
			//deposit		  
		}	
			$ipunfinalizeamount=$totaladmncharges+$labtotal+$totalradiologyitemrate+$totalservicesitemrate+$totalprivatedoctoramount+$totalpharmacysaleamount-$totalpharmacysalereturnamount+$totalambulanceamount+$totalipmis-$totaldiscountrate+$totalbedcharges+$totalbedtransfercharges+$totalpackage+$depbalance;

			return $ipunfinalizeamount;
		}
		else
		{
			$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid' and id IN ('01-10042-RAD','01-10032-LAB','01-1013-SI','04-6009-PI','03-3002-OI')";
			$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res267 = mysqli_fetch_array($exec267))
			{  
				$accountsmain2 = $res267['accountname'];
				$parentid2 = $res267['auto_number'];
				$ledgeranum = $parentid2;
				$id = $res267['id'];
				$searchsuppliername = '';
			
			$updatedate = date('Y-m-d');
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
		
		
		
		//deposit
			
		$colorloopcount = '';
		$orderid1 = '';
		$lid = '';
		$openingbalance = "0.00";
		$sumopeningbalance = "0.00";
		$totalamount2 = '0.00';
		$totalamount12 = '0.00';
		$depbalance = '0.00';
		$sumbalance = '0.00';
		
			//deposit		  
		}	
			$ipunfinalizeamount=$totaladmncharges+$labtotal+$totalradiologyitemrate+$totalservicesitemrate+$totalprivatedoctoramount+$totalpharmacysaleamount-$totalpharmacysalereturnamount+$totalambulanceamount+$totalipmis-$totaldiscountrate+$totalbedcharges+$totalbedtransfercharges+$totalpackage+$depbalance;

	
				$i = 0;
				$result = array();
		  			
					//echo $id;
				  if($id == '01-10042-RAD')                 //rad unfinal
				  { 
					 $sumbalance = $sumbalance + $totalradiologyitemrate;
				  }
				  else if($id == '01-10032-LAB')                 //rad unfinal
				  { 
					  $sumbalance = $sumbalance + $labtotal;
				  }
				  else if($id == '01-1013-SI')                 //rad unfinal
				  {  
					  $sumbalance = $sumbalance + $totalservicesitemrate;
				  }
				  else if($id == '04-6009-PI')                 //rad unfinal
				  { 
					  $sumbalance = $sumbalance + $totalpharmacysaleamount-$totalpharmacysalereturnamount;
				  }
				  else if($id == '03-3002-OI')                 //rad unfinal
				  {
					  //$ipunfinalizeamount=$totaladmncharges+$totalprivatedoctoramount+$totalambulanceamount+$totalipmis-$totaldiscountrate+$totalbedcharges+$totalbedtransfercharges+$totalpackage+$depbalance;
					 
					  $finamount=$totaladmncharges+$totalprivatedoctoramount+$totalambulanceamount+$totalipmis-$totaldiscountrate+$totalbedcharges+$totalbedtransfercharges+$totalpackage+$depbalance;
					  
					  $sumbalance = $sumbalance + $finamount;
				  }
			}	
			return $sumbalance;
			
			
			
		}	
	}
	else
	{
		return $sumbalance;
	}
}
?>