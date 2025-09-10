<?php
session_start();
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
$colorloopcount='';
$sno='';
 
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>
           <?php
            $colorloopcount ='';
			$netamount='';
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }
			if (isset($_REQUEST["ward"])) { $ward = $_REQUEST["ward"]; } else { $ward = ""; }
			if (isset($_REQUEST["name"])) { $name = $_REQUEST["name"]; } else { $name = ""; }
		//$ADate1='2015-02-01';
		//$ADate2='2015-02-28';
        $title ='';
		if($name=='admission') 
			$title = "Admission Charge";
			elseif($name=='bed')
				$title = "Bed Charge";
			elseif($name=='package')
			  $title = "Package Charge";
			elseif($name=='Nursing')
			  $title = "Nursing Charge";
			elseif($name=='mo')
			  $title = "MO Charge";
			elseif($name=='consultant')
			  $title = "Consultant Charge";
			elseif($name=='lab')
			  $title = "Lab Charge";
			elseif($name=='rad')
			  $title = "Radiology Charge";
			elseif($name=='pharma')
			  $title = "Pharma Charge";
			elseif($name=='services')
			  $title = "Services Charge";
			elseif($name=='ambulance')
			  $title = "Ambulance Charge";
			elseif($name=='homecare')
			  $title = "Homecare Charge";
			elseif($name=='pvtdr')
			  $title = "Private Doctor Charge";
			elseif($name=='misc')
			  $title = "Misc Billing";
			elseif($name=='discount')
			  $title = "Discount";
			elseif($name=='others')
			  $title = "Others";

		?>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">

        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="10%" bgcolor="#ecf0f5" class="bodytext31" colspan='6'><strong>IP <?php echo $title;?> Details From  <?php echo $ADate1;?> To <?php echo $ADate2;?></strong></td>
              </tr>            
			
             <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
              <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Doc. No</td>
			  <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Patient Name</td>
              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"> Date</td>
              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Visitcode</td>
              <td width="21%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Amount</td>
            </tr>

        <?php

	 
	   if($ward=='')
		{
		 $query1 = "select patientcode,visitcode from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip UNION ALL select visitcode from billing_ipcreditapproved)  and locationcode='$locationcode1'  and consultationdate between '$ADate1' and '$ADate2'";
		}
		else {
		 $query1 = "select patientcode,visitcode from ip_bedallocation where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered'
			UNION  select patientcode,visitcode from ip_bedtransfer where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered'";
		}

	   

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num1=mysqli_num_rows($exec1);
	$totaladmncharges = 0;
	$consultationfee=0;
	if($num1>0){
		while($res1 = mysqli_fetch_array($exec1))
		{
			
		    $visitcode=$res1['visitcode'];
			$patientcode=$res1['patientcode'];

            
			 $query66 = "select patientcode,patientfullname,visitcode,consultationdate,admissionfees,package,packagecharge,type from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip UNION ALL select visitcode from billing_ipcreditapproved) and visitcode='$visitcode' and patientcode='$patientcode'  and consultationdate between '$ADate1' and '$ADate2'"; 

			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res66 = mysqli_fetch_array($exec66))
			{
				
				$patientcode = $res66['patientcode'];
				$consultationdate = $res66['consultationdate'];
				$visitcode = $res66['visitcode'];
                $packageanum1 = $res66['package'];
				$type = $res66['type'];

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


					$query32 = "select currency,fxrate,subtype from master_subtype where auto_number = '".$menusub."'";
					$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$mastervalue = mysqli_fetch_array($exec32);
					$currency=$mastervalue['currency'];
					$fxrate=$mastervalue['fxrate'];
				
				$patientname=$res66['patientfullname'];

				if($name=='package'){
				   $consultationfee=0;
                   $package=$res66['package'];
				   $packageamount = $res66['packagecharge'];
					
					$consultationfee=$packageamount*$fxrate;
					$totaladmncharges = $totaladmncharges + $consultationfee;

				}elseif($name=='admission'){
				   $consultationfee=$res66['admissionfees'];
			       $consultationfee = number_format($consultationfee,2,'.','');
				   $totaladmncharges=$totaladmncharges+$consultationfee;
				}elseif($name=='misc'){
				  $amt=0;
                  $query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			      $exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($res69 = mysqli_fetch_array($exec69))
		          {
					  $miscbillingrate = $res69['rate'];
					  $miscbillingamount = $res69['amount'];
					  $miscbillingunit = $res69['units'];

					  $miscbillingamount = $miscbillingunit*($miscbillingrate/$fxrate);
			          $consultationfee = $miscbillingrate*$miscbillingunit;
					  $amt =$amt+($miscbillingrate*$miscbillingunit);

			          $totaladmncharges = $totaladmncharges + ($miscbillingrate*$miscbillingunit);
				  }
				  $consultationfee = $amt ;

				}elseif($name=='pvtdr'){
				  $consultationfee=0;
                  $totaladmncharges = $totaladmncharges + $consultationfee;
				}elseif($name=='homecare'){
				  $consultationfee=0;
                  $totaladmncharges = $totaladmncharges + $consultationfee;
				}elseif($name=='ambulance'){
				  $amt=0;
				    $query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";
					$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res63 = mysqli_fetch_array($exec63))
				    {
					  $ambulancerate = $res63['rate'];
					  $ambulanceamount = $res63['amount'];
			          $ambulanceunit = $res63['units'];

					  $ambulanceamount = $ambulanceunit*($ambulancerate/$fxrate);
					  $amt = $amt+($ambulancerate*$ambulanceunit);
					  $totaladmncharges = $totaladmncharges + ($ambulancerate*$ambulanceunit);
					}
                   $consultationfee = $amt ;

				}elseif($name=='services'){
				  $amt=0;
				  $totalser=0;
					$totalseruhx=0;
				  $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' group by servicesitemname,iptestdocno";
					$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res21 = mysqli_fetch_array($exec21))
					{
						$sercode=$res21['servicesitemcode'];
						$servicesfree = $res21['freestatus'];
						$querytt32 = "select * from master_testtemplate where templatename='$sertemplate'";
						$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$numtt32 = mysqli_num_rows($exectt32);
						$exectt=mysqli_fetch_array($exectt32);
						$sertable=$exectt['templatename'];
						if($sertable=='')
						{
							$sertable='master_services';
						}

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
						     $totserrate=($serqty*$serrate);
							$totalser=$totalser+$totserrate;
							
							 $amt =$amt+( ($serrate*$fxrate)*$serqty);
						  // $consultationfee = $totalseruhx + $totserrateuhx;
						   $totaladmncharges = $totaladmncharges + ( ($serrate*$fxrate)*$serqty);
						}
			        }
					$consultationfee = $amt ;

				}elseif($name=='pharma'){
					 $amt=0;
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
						$pharate=$res23['rate'];
						$quantity=$res23['quantity'];
						$refno = $res23['ipdocno'];
						$pharmfree = $res23['freestatus'];
						$phaitemcode=$res23['itemcode'];
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
							
						$resamount=$resquantity*($pharate/$fxrate);
						$totalpharm=$totalpharm+$resamount;
						
						 $resamountuhx = $pharate*$resquantity;
						 $resamountreturnuhx = $pharate*$quantity1;
					     $totalpharmuhx = $totalpharmuhx + $resamountuhx;
                         
						   $amt =$amt +( $resamountuhx - $resamountreturnuhx);

						  $totaladmncharges = $totaladmncharges + ( $resamountuhx - $resamountreturnuhx);
						
						}
						}
					 }
					 $consultationfee = $amt ;
				}elseif($name=='lab'){
                    //$consultationfee=0;
					$totallab=0;
					$totallabuhx=0;
				    $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund'";
					    $amt = 0;
						$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$num81=mysqli_num_rows($exec19);	
						while($res19 = mysqli_fetch_array($exec19))
						{
						$labdate=$res19['consultationdate'];
						$labname=$res19['labitemname'];
						$labcode=$res19['labitemcode'];
						$labrate=$res19['labitemrate'];
						$labrefno=$res19['iptestdocno'];
						$labfree = $res19['freestatus'];
						
						$querytl32 = "select * from master_testtemplate where templatename='$labtemplate'";
						$exectl32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytl32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$numtl32 = mysqli_num_rows($exectl32);
						$exectl=mysqli_fetch_array($exectl32);		
						$labtable=$exectl['templatename'];
						if($labtable=='')
						{
							$labtable='master_lab';
						}
						if($labfree == 'No')
						{
						$queryl51 = "select rateperunit from `$labtable` where itemcode='$labcode'";
						$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$resl51 = mysqli_fetch_array($execl51);
						$labrate = $resl51['rateperunit'];
						
						 $totallab=$totallab+$labrate;
						
						 $amt =$amt+( $labrate*$fxrate);
						 $totaladmncharges = $totaladmncharges + ( $labrate*$fxrate);
					    
						}
					}
					$consultationfee = $amt ;

				}elseif($name=='rad'){
                   $amt=0;
					
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
					$querytt32 = "select * from master_testtemplate where templatename='$radtemplate'";
					$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$numtt32 = mysqli_num_rows($exectt32);
					$exectt=mysqli_fetch_array($exectt32);		
					$radtable=$exectt['templatename'];
					if($radtable=='')
					{
						$radtable='master_radiology';
					}
					if($radiologyfree == 'No')
					{
					$queryr51 = "select rateperunit from `$radtable` where itemcode='$radiologyitemcode'";
					$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$resr51 = mysqli_fetch_array($execr51);
					$radrate = $resr51['rateperunit'];
					
					 $totalrad=$totalrad+$radrate;
					
					 $amt =$amt + ($radrate*$fxrate);
				     $totaladmncharges = $totaladmncharges + ($radrate*$fxrate);
					}
				  }

				  $consultationfee = $amt ;
				}elseif($name=='rmo'){
                    $consultationfee=0;
					$totaladmncharges = $totaladmncharges + $consultationfee;
				}elseif($name=='bed'){
					$amt =0;
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
						$query741 = "select * from master_ippackage where auto_number='$packageanum1'";
						$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$res741 = mysqli_fetch_array($exec741);
						$packdays1 = $res741['days'];

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
										if($charge!='Nursing Charges')
										{
										$amountuhx = $rate*$quantity;
										$amt = $amt+ ($amountuhx*$fxrate);

										$totaladmncharges = $totaladmncharges +($amountuhx*$fxrate);
										}
										
									}
								}
							}
						}

						$consultationfee = $amt ;
				}
				elseif($name=='nursing'){
                    $amt=0;
					$amt1=0;
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
						$query741 = "select * from master_ippackage where auto_number='$packageanum1'";
						$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$res741 = mysqli_fetch_array($exec741);
						$packdays1 = $res741['days'];

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
										if($charge!='Nursing Charges')
										{
										
										}
										else
										{
										$amountnuhx = $rate*$quantity;
										$amt = $amt + ($amountnuhx*$fxrate);
										$totaladmncharges = $totaladmncharges + ($amountnuhx*$fxrate);
										}
									}
								}
							}
						}
						
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
										
										if($charge!='Nursing Charges')
										{
										}
										else
										{
										
										$amountnuhx = $rate*$quantity;
										$amt1 = $amt1 + ($amountnuhx*$fxrate);
										$totaladmncharges = $totaladmncharges + ($amountnuhx*$fxrate);
										
										}
									}
								}
								
							}
						}
					}
                    
					$consultationfee = $amt+$amt1 ;
					
				}elseif($name=='others'){
                  $amt1 =0;
				  $totaldiscountrate = 0;

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
						$query741 = "select * from master_ippackage where auto_number='$packageanum1'";
						$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$res741 = mysqli_fetch_array($exec741);
						$packdays1 = $res741['days'];

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
										
										if($charge!='Nursing Charges')
										{
											$amountuhx = $rate*$quantity;
											$amt1 = $amt1 + ($amountuhx*$fxrate);
											$totaladmncharges = $totaladmncharges + ($amountuhx*$fxrate);
										}
										else
										{
										}
									}
								}
								
							}
						}
					}
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
					 $discountrateuhx = $discountrate1;
					 $totaldiscountrate = $totaldiscountrate + $discountrateuhx;
					 $totaladmncharges = $totaladmncharges -$discountrateuhx;
					
					}	

					$consultationfee = $amt1-$totaldiscountrate ;
				}

				$sno=$sno+1;			    
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
			   <tr <?php echo $colorcode; ?>>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
				   <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $patientcode;?></div> </td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $patientname;?></div> </td>
					
				   <td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
				   <td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
				<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>
			   </tr>
		<?php
			}
		}
	}
?>		
         <tr>
              <td colspan="5"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Total Charges:</strong></td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totaladmncharges,2,'.',','); ?></strong></td>
<!--				<?php if($nettotal != 0.00) { ?>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
                
			    <?php 
				}?>
-->		

          </tbody>
        </table>
        
			