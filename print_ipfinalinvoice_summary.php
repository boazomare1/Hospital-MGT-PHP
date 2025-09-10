<?php
ob_start();
session_start();
ini_set('max_execution_time', 3000);
ini_set('memory_limit','-1');
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
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
$temp = 0;
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$docno=$_SESSION["docno"];
$pharmacy_fxrate=2872.49;
$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res = mysqli_fetch_array($exec);
	
 	$locationname = $res["locationname"];
	$locationcode = $res["locationcode"];
//$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbers = ""; }
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where locationcode='$locationcode' and customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];
$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where locationcode='$locationcode' and auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where locationcode='$locationcode' and auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$query32 = "select * from ip_discharge where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";
$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num32 = mysqli_num_rows($exec32);
$res32 = mysqli_fetch_array($exec32);
$dischargedby = $res32['username'];
$query33 = "select * from master_employee where locationcode='$locationcode' and username = '$dischargedby'";
$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res33 = mysqli_fetch_array($exec33);
$employeename = $res33['employeename'];
?>
<?php
function roundTo($number, $to){ 
    return round($number/$to, 0)* $to; 
} 
?>
<?php
		$query2 = "select * from master_location where locationcode = '$locationcode'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		//$companyname = $res2["companyname"];
		$address1 = $res2["address1"];
		$address2 = $res2["address2"];
//		$area = $res2["area"];
//		$city = $res2["city"];
//		$pincode = $res2["pincode"];
		$emailid1 = $res2["email"];
		$phonenumber1 = $res2["phone"];
		$locationcode = $res2["locationcode"];
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
	//	$locationname =  $res2["locationname"];
		$prefix = $res2["prefix"];
		$suffix = $res2["suffix"];
		
?>
<style type="text/css">
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000;  text-decoration:none
}
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
	font-family:Arial, Helvetica, sans-serif;
}
.underline {text-decoration: underline;}
.page_footer
{
	font-family: Times;
	text-align:center;
	font-weight:bold;
	margin-bottom:25px;
	
}
</style>
<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">
 <?php  include('print_header_pdf3.php'); ?>
    
<!--<page_footer>
  <div class="page_footer" style="width: 100%; text-align: center">
                    <?= $footer="Blood is FREE for all @ Nakasero Hospital. Sale of blood is illegal. Should you ever be asked to pay for blood at this facility please report IMMEDIATELY to info@nhl.co.ug"; ?>
                </div>
    </page_footer>-->
	
	<table width="100%" align="center" border="0" cellspacing="4" cellpadding="0">
 
           <?php
 		$query1 = "select * from master_ipvisitentry where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";
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
		$consultingdoctor = $res1['consultingdoctor'];
		$nhifid = $res1['nhifid'];
		$subtypeanum = $res1['subtype'];
		$type = $res1['type'];
		
		$query13 = "select * from master_subtype where  auto_number = '$subtypeanum'";
		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res13 = mysqli_fetch_array($exec13);
		$subtype = $res13['subtype'];
		$fxrate=$res13['fxrate'];
		$currency=$res13['currency'];
		$bedtemplate=$res13['bedtemplate'];
		$labtemplate=$res13['labtemplate'];
		$radtemplate=$res13['radtemplate'];
		$sertemplate=$res13['sertemplate'];
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
		$query813 = "select * from ip_discharge where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res813 = mysqli_fetch_array($exec813);
		$num813 = mysqli_num_rows($exec813);
		if($num813 > 0)
		{
		$updatedate=$res813['recorddate'];
		$updatedatetime=$res813['recordtime'];
		
		}
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
	     }
		 
		$query2 = "select * from ip_bedallocation where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$admissiondate = $res2['recorddate'];
		$wardanum = $res2['ward'];
		$bed = $res2['bed'];
		$admissiontime = $res2['recordtime'];
		
		
		$query12 = "select * from master_ward where locationcode='$locationcode' and auto_number = '$wardanum'";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res12 = mysqli_fetch_array($exec12);
		$wardname = $res12['ward'];
		//No. of days calculation
		$startdate = strtotime($admissiondate);
		$enddate = strtotime($updatedate);
		$nbOfDays = $enddate - $startdate;
		$nbOfDays = ceil($nbOfDays/60/60/24);
		//billno
		$querybill = "select billno, billdate from billing_ip where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode = '$visitcode' and billno = '$billnumbers'";
		$execbill = mysqli_query($GLOBALS["___mysqli_ston"], $querybill) or die ("Error in querybill".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resbill = mysqli_fetch_array($execbill);
		$billno = $resbill['billno'];
		$billdate1 = $resbill['billdate'];
	
		$from_limit_date=$admissiondate;
		$to_limit_date =date('Y-m-d');
		$querybill = "select billdate from billing_ip where patientcode = '$patientcode' and visitcode = '$visitcode'";
		$execbill = mysqli_query($GLOBALS["___mysqli_ston"], $querybill) or die ("Error in querybill".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($resbill = mysqli_fetch_array($execbill)){
			$to_limit_date = $resbill['billdate'];		
		}
		$query813 = "select recorddate from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res813 = mysqli_fetch_array($exec813);
		$num813 = mysqli_num_rows($exec813);
		if($num813 > 0)
		{
		//$to_limit_date=$res813['recorddate'];
		}
		
		$queryicd = "select * from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number DESC";
$execicd = mysqli_query($GLOBALS["___mysqli_ston"], $queryicd) or die ("Error in queryicd".mysqli_error($GLOBALS["___mysqli_ston"]));
$resicd = mysqli_fetch_array($execicd);
$primary = $resicd['primarydiag'];
		
		?>
		    <tr>
  <td colspan="10">&nbsp;</td></tr>
		   <tr>
             <td width="110" align="left" valign="center" class="bodytext31"><strong>Name:</strong></td> 
		     <td width="250" align="left" valign="center" class="bodytext31"><?php echo $patientname; ?></td>
		     <td width="110" align="left" valign="center" class="bodytext31"><strong>Invoice No:</strong></td> 
		     <td width="160" align="left" valign="center" class="bodytext31"><?php echo $billno; ?></td>
          </tr>
		  
	       <tr>
             <td width="110" align="left" valign="center" class="bodytext31"><strong>Reg. No.:</strong></td>
	         <td width="250" align="left" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
	         <td width="110" align="left" valign="center" class="bodytext31"><strong>Bill Date:</strong></td> 
		     <td width="160" align="left" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($billdate1)); ?></td>
         </tr>
          <tr>
             <td width="110" align="left" valign="center" class="bodytext31"><strong>Bill Type:</strong></td>
	         <td width="250" align="left" valign="center" class="bodytext31"><?php echo $billtype; ?></td>
	         <td width="110" align="left" valign="center" class="bodytext31"><strong>IP Visit No.:</strong></td>
			 <td width="160" align="left" valign="left" class="bodytext31"><?php echo $visitcode; ?></td>
         </tr>
        <tr>
			<td width="110" align="left" valign="center" class="bodytext31"><strong>Account:</strong></td>
			<td width="250" align="left" valign="center" class="bodytext31"><?php echo $accname; ?></td>
			<td width="110" align="left" valign="center" class="bodytext31"><strong>Admission Date:</strong></td> 
	        <td width="160" align="left" valign="center" class="bodytext31"><?php echo  date("d/m/Y", strtotime($admissiondate))." ".$admissiontime; ?></td>
</tr>		<tr>
            <td width="110" align="left" valign="center" class="bodytext31"><strong>Covered By: </strong></td>
            <td width="250" align="left" valign="center" class="bodytext31"><?php echo $subtype; ?></td>
            <td width="110" align="left" valign="center" class="bodytext31"><strong>Discharge Date:</strong></td>
			<td width="160" align="left" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($updatedate))." ".$updatedatetime; ?></td>
		</tr>
		 <tr>
         
			<td width="110" align="left" valign="center" class="bodytext31"><strong>&nbsp;</strong></td>
             <td width="250" align="left" valign="center" class="bodytext31">&nbsp;</td>
            <td width="110" align="left" valign="center" class="bodytext31"><strong>No of Days:</strong></td>
			<td width="160" align="left" valign="left" class="bodytext31"><?php echo $nbOfDays; ?></td>
        </tr>
         <tr>
			<td width="110" align="left" valign="center" class="bodytext31">&nbsp;</td>
			<td width="250" align="left" valign="center" class="bodytext31">&nbsp;</td>
			<td width="110" align="left" valign="center" class="bodytext31"><strong>Type:</strong></td>
			<td width="160" align="left" valign="left" class="bodytext31"><?php echo $type; ?></td>
          </tr>
          <tr>
            <td width="110" align="left" valign="center" class="bodytext31">&nbsp;</td>
            <td width="250" align="left" valign="center" class="bodytext31">&nbsp;</td>
			<td width="110" align="left" valign="center" class="bodytext31"><strong>Bed No:</strong></td>
			<td width="160" align="left" valign="center" class="bodytext31"><?php echo $bed;?></td>
		</tr>
		
       
        <tr>
  <td colspan="10">&nbsp;</td></tr> 
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
			$packageanum1 = $res17['package'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			
			
			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res53 = mysqli_fetch_array($exec53);
			$refno = $res53['docno'];
			
			
			$totalop=$consultationfee;
			
			?>
       
			<tr>
				<td colspan="2" class="bodytext31"  valign="center"  align="left"><strong>Admission Fees:</strong></td>
				<td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
			</tr>	
              
			<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;
					  $packageamount = 0;
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
			
			
			if($packageanum1 != 0)
	{
	
	 $reqquantity = $packdays1;
	 
	 $reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));
	 
			  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
		
			  ?>
			<tr>
				<td colspan="2" class="bodytext31"  valign="center"  align="left"><strong><?php echo "Package Charge";?></strong></td>
				<td colspan="2" class="bodytext31" valign="center"  align="right"><?php  echo number_format($packageamount,2,'.',',');  ?></td>
			</tr>
			  <?php
			  }
			  
$totalbedallocationamount=0;
$totalbedtransferamount=0;		
			$querya01 = "select *,sum(amount) as amount from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' and docno='$billno' and bed <> '0' group by description";
			$execa01 = mysqli_query($GLOBALS["___mysqli_ston"], $querya01) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numa01 = mysqli_num_rows($execa01);
			while($resca01=mysqli_fetch_array($execa01)){
				$date=$resca01['recorddate'];
				$refno =$visitcode;
				$charge=$resca01['description'];
				$bed=$resca01['bed'];
				$ward=$resca01['ward'];
				$quantity=$resca01['quantity'];
				$rate=$resca01['rate'];
				$amount=$resca01['amount'];
				
				$querybed = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from master_bed where auto_number='$bed'");
				$resbed = mysqli_fetch_array($querybed);
				$bedname = $resbed['bed'];
				
				$queryward = mysqli_query($GLOBALS["___mysqli_ston"], "select description from master_ward where auto_number='$ward'");
				$resward = mysqli_fetch_array($queryward);
				$wardname = $resward['description'];
				
				if($quantity==0){
					$quantity=1;
				}
			
				$totalbedallocationamount=$totalbedallocationamount+$amount;
			if($charge=="RMO Charges"){
					continue;
				}
								
					  ?>
		<tr>
			<td colspan="2" class="bodytext31"  valign="center"  align="left"><strong><?php echo $charge;?></strong></td>
			<td colspan="2" class="bodytext31" valign="center"  align="right"><?php  echo number_format($amount,2,'.',',');  ?></td>     
		</tr>              
		<?php	
			}
		
		
		/*	$totalbedallocationamount = 0;
			
			 $requireddate = '';
			 $quantity = '';
			 $allocatenewquantity = '';
			$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());
				while($res18 = mysql_fetch_array($exec18))
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
					$exec51 = mysql_query($query51) or die(mysql_error());
					$res51 = mysql_fetch_array($exec51);
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
					$exec91 = mysql_query($query91) or die(mysql_error());
					$num91 = mysql_num_rows($exec91);
					while($res91 = mysql_fetch_array($exec91))
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
									$colorcode = 'bgcolor="#FFFFFF"';
								}
								else
								{
									//echo "else";
									$colorcode = 'bgcolor="#FFFFFF"';
								}
								$totalbedallocationamount=$totalbedallocationamount+($quantity*($rate));
				if($charge=="RMO Charges"){
					continue;
				}
								
					  ?>
					<tr>
<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>
                        <td class="bodytext31"  valign="center"  align="left"><strong><?php echo $charge;?></strong></td>
                        <td class="bodytext31" valign="center"  align="right"><?php  echo number_format($amount,2,'.',',');  ?></td>                   
                    </tr>              
					 
					   <?php 
							}
						}
					}
				}
				$totalbedtransferamount=0;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());
				while($res18 = mysql_fetch_array($exec18))
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
					$exec51 = mysql_query($query51) or die(mysql_error());
					$res51 = mysql_fetch_array($exec51);
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
					$exec91 = mysql_query($query91) or die(mysql_error());
					$num91 = mysql_num_rows($exec91);
					while($res91 = mysql_fetch_array($exec91))
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
						if($bedcharge=='0')
						{
							if($quantity>0)
							{
								if($type=='hospital'||$charge!='Resident Doctor Charges')
								{
									$colorloopcount = $sno + 1;
									$showcolor = ($colorloopcount & 1); 
									if ($showcolor == 0)
									{
										//echo "if";
										$colorcode = 'bgcolor="#FFFFFF"';
									}
									else
									{
										//echo "else";
										$colorcode = 'bgcolor="#FFFFFF"';
									}
									$totalbedtransferamount=$totalbedtransferamount+($quantity*($rate));
				if($charge=="RMO Charges"){
					continue;
				}
						  ?>
						<tr>
<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>
							<td class="bodytext31"  valign="center"  align="left"><strong><?php echo $charge;?></strong></td>
							<td class="bodytext31" valign="center"  align="right"><?php  echo number_format($amount,2,'.',',');  ?></td>                   
						</tr>							
						 
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
			
			*/
			  ?>
			 
			   <?php 
			   
			$original_fxrate= $fxrate;
			if(strtoupper($currency)=="USD"){
				$fxrate = $pharmacy_fxrate;
			}
						   
			$totalpharm=0;
			$phaamount31=0;
			$phaamount3=0;
			
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and freestatus = 'No' GROUP BY ipdocno,itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_pharmacy = mysqli_num_rows($exec23);
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
			$quantity=$res23['quantity'];
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
						
			$resamount=($resamount/$fxrate);
			//if($resquantity != 0)
			{
			if(strtoupper($pharmfree) =='NO')
			{
			$phaamount3=$phaamount3+$phaamount;
			$phaamount31=$phaamount31+$amount1; 
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
		
			$totalpharm=$totalpharm+$resamount;
			?>		
			  
			  <?php }
			  }
			  }
			  ?>
			<tr>
				<td colspan="2" class="bodytext31"  valign="center"  align="left"><strong>Pharmacy:</strong></td>		
				<td colspan="2" class="bodytext31" valign="center"  align="right"><?php  echo number_format(($phaamount3/$fxrate),2,'.',',');  ?></td>
			</tr>
			<tr>
			<td colspan="2" class="bodytext31"  valign="center"  align="left"><strong>Pharmacy Returns:</strong></td>	
			<td colspan="2" class="bodytext31" valign="center"  align="right">-<?php  echo number_format(($phaamount31/$fxrate),2,'.',',');  ?></td>
			</tr>	
			
			  
			  <?php
			 //  }
//			  }
			 // }
			  ?>
			  <?php 
			 
			 
			$fxrate = $original_fxrate;
			  $totallab=0;
			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund' and freestatus='No'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_lab = mysqli_num_rows($exec19);
				
			while($res19 = mysqli_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labcode=$res19['labitemcode'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['iptestdocno'];
			$labfree = $res19['freestatus'];
			
			if(strtoupper($labfree) == 'NO')
			{
			$queryl51 = "select labitemrate as rateperunit from `billing_iplab` where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemcode='$labcode'";
			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resl51 = mysqli_fetch_array($execl51);
			$labrate = $resl51['rateperunit'];
			/*
			$queryl51 = "select rateperunit from `$labtable` where itemcode='$labcode'";
			$execl51 = mysql_query($queryl51) or die(mysql_error());
			$resl51 = mysql_fetch_array($execl51);
			$labrate = $resl51['rateperunit'];*/
			
			
			$totallab=$totallab+$labrate;
			 }
			  }
			?>
        
			<tr>
				<td colspan="2" class="bodytext31"  valign="center"  align="left"><strong>Laboratory:</strong></td>
				<td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($totallab,2,'.',','); ?></td>
			</tr>	
			  
			  <?php 
			 
			  ?>
			  
			    <?php 
				$totalrad=0;
			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and freestatus= 'No'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_radio = mysqli_num_rows($exec20);
						
			/*if($num_radio>0){
			echo "<tr><td colspan='7'><strong>RADIOLOGY</strong></td></tr>";   
			}*/
			
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['iptestdocno'];
			$radiologyfree = $res20['freestatus'];
			$radiologyitemcode = $res20['radiologyitemcode'];
			if(strtoupper($radiologyfree) == 'NO')
			{
			$queryr51 = "select radiologyitemrate rateperunit from `billing_ipradiology` where  patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemcode='$radiologyitemcode'";
			$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resr51 = mysqli_fetch_array($execr51);
			$radrate = $resr51['rateperunit'];
			/*
			$queryr51 = "select rateperunit from `$radtable` where itemcode='$radiologyitemcode'";
			$execr51 = mysql_query($queryr51) or die(mysql_error());
			$resr51 = mysql_fetch_array($execr51);
			$radrate = $resr51['rateperunit']; */
			
			
			$totalrad=$totalrad+$radrate;
			}
			}
			?>
       
			<tr>
			<td colspan="2" class="bodytext31"  valign="center"  align="left"><strong>Radiology:</strong></td>
			<td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($totalrad,2,'.',','); ?></td>
			</tr>	
			  
			  <?php 
			  $theatreamt=0;
			
		   $query199 = "select * from ipconsultation_services where servicesitemname like '%THEATRE%' AND patientvisitcode='$visitcode' and patientcode='$patientcode' and wellnessitem <> '1'";
			$exec199 = mysqli_query($GLOBALS["___mysqli_ston"], $query199) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				
			while($res199 = mysqli_fetch_array($exec199))
			{
			
			$theatrerate=$res199['amount'];
			$theatrefreestatus=$res199['freestatus'];
			
			
			if(strtoupper($theatrefreestatus) == 'NO')
			{
			
			
			//$theatreamt=$theatreamt+$theatrerate;
			  }
              }
			?>
        
		<?php /*?><tr>
<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>
			<td class="bodytext31"  valign="center"  align="left"><strong>Theatre:</strong></td>
			
				
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($theatreamt,2,'.',','); ?></td>
		</tr><?php */?>
        <?php	
            		
			  ?>
			  	    <?php 
					
			
					$totalser=0;
		    $query21 = "select consultationdate,servicesitemname,servicesitemrate,iptestdocno,freestatus,servicesitemcode,serviceqty from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and wellnessitem <> '1' group by servicesitemname, iptestdocno";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$totserrate = 0;
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$sercode=$res21['servicesitemcode'];
			$serqty=$res21['serviceqty'];
			/*
			$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";
			$execs51 = mysql_query($querys51) or die(mysql_error());
			$ress51 = mysql_fetch_array($execs51);
			$serrate = $ress51['rateperunit'];*/
			$query2111 = "select serviceqty, amount from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund' and iptestdocno = '$serref'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			$resqty = mysqli_fetch_array($exec2111);
			 $serqty=$resqty['serviceqty'];
			if($serqty==0){$serqty=$numrow2111;}
			
			
 			$querys51 = "select sum(servicesitemrate) as rateperunit from `billing_ipservices` where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode='$sercode' and wellnessitem <> '1'";
			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress51 = mysqli_fetch_array($execs51);
			$serrate = $ress51['rateperunit'];
           /*
			$query2111 = "select sum(serviceqty) as serviceqty from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund' and wellnessitem <> '1'";
			$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());
			$numrow2111 = mysql_num_rows($exec2111);
			$resqty = mysql_fetch_array($exec2111);
			 $serqty1=$resqty['serviceqty'];
			if($serqty==0){$serqty=$numrow2111;}
			$serrate = $serrate/$serqty1; */
			if(strtoupper($servicesfree) == 'NO')
			{
			 $totserrate=$resqty['amount'];
			/*   if($totserrate==0){
			$totserrate=$serrate*$numrow2111;
			  }
			$totserrate=$serrate*$serqty; */
			  $totalser=$totalser+$totserrate;
			}
			}
			?>
            
			<tr>
			<td colspan="2" class="bodytext31"  valign="center"  align="left"><strong>Services and Procedures:</strong></td>			
			<td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($totalser,2,'.',','); ?></td>
			</tr>	
			  
			 
			<?php
			$totalotbillingamount = 0;
			$query61 = "select * from ip_otbilling where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_ot = mysqli_num_rows($exec61);
			/*if($num_ot>0 ){
				echo "<tr><td colspan='7'><strong>OT SURGERY</strong></td></tr>";
			}*/
			while($res61 = mysqli_fetch_array($exec61))
		   {
			$otbillingdate = $res61['consultationdate'];
			$otbillingrefno = $res61['docno'];
			$otbillingname = $res61['surgeryname'];
			$otbillingrate = $res61['rate'];
			$otbillingrate = 1*($otbillingrate/$fxrate);
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
		   }
		   if($totalotbillingamount!=0){
			?>
		<tr>
<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>
			<td class="bodytext31"  valign="center"  align="left"><strong>OT Surgery:</strong></td>
			
			
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalotbillingamount,2,'.',','); ?></td>
		</tr>
				
				<?php
		   }
			$totalprivatedoctoramount = 0;
			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg = '1'";
			$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_pvt = mysqli_num_rows($exec62);
			
			while($res62 = mysqli_fetch_array($exec62))
		   {
			$privatedoctordate = $res62['consultationdate'];
			$privatedoctorrefno = $res62['docno'];
			$privatedoctor = $res62['doctorname'];
			$privatedoctorrate = $res62['rate'];
			$privatedoctoramount = $res62['amount'];
			$privatedoctorunit = $res62['units'];
			$description = $res62['remarks'];
			if($description != '')
			{
			$description = '-'.$description;
			}
			$privatedoctoramount = $privatedoctorunit*($privatedoctorrate/$fxrate);
			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
		   }
			?>
            
			<tr>
			<td colspan="2" class="bodytext31"  valign="center"  align="left"><strong>PVT Doctor Charges</strong></td>
			<td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></td>
			</tr>
				
				<?php
				
				
			$totalambulanceamount = 0;
			$query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_rescue = mysqli_num_rows($exec63);
			
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
		   }
			?>
            
			<tr>
			<td colspan="2" class="bodytext31"  valign="center"  align="left"><strong>Rescue Charges:</strong></td>
			<td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($totalambulanceamount,2,'.',','); ?></td>
			</tr>
				
				<?php
			$totalmiscbillingamount = 0;
			$query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_misc = mysqli_num_rows($exec69);
			/*if($num_misc>0){
			echo "<tr><td colspan='7'><strong>MISC CHARGES</strong></td></tr>";
			}*/
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
		   }
			?>
			<tr>
			<td colspan="2" class="bodytext31"  valign="center"  align="left"><strong>MISC Charges: </strong></td>		
			<td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($totalmiscbillingamount,2,'.',','); ?></td>
			</tr>
				
				<?php
				 $payoveralltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalmiscbillingamount+$theatreamt); 
				?>			
			
            
            
			<tr>
			<td colspan="2" align="left" class="bodytext31" valign="center"><strong>Total Bill Amount:</strong></td>
			<td colspan="2" align="right" class="bodytext31" valign="middle" style=""><?php echo number_format($payoveralltotal,2,'.',','); ?></td>
			</tr>
			
            
            <?php 
				
			$totalcreditamt = 0;
		  	$totaldiscountamount = 0;
			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res64 = mysqli_fetch_array($exec64))
		   {
			 $discountrate = $res64['rate']/$fxrate;
			 $discountrate = -$discountrate;
			// $discountrate = 1*($discountrate/$fxrate);
			 $totaldiscountamount = $totaldiscountamount + $discountrate;  
			   
		   }
		   $query641 = "select * from ip_nhifprocessing where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res641= mysqli_fetch_array($exec641))
		   {
			   $nhifqty = $res641['totaldays'];
			$nhifrate = $res641['nhifrebate'];
			$nhifclaim = $res641['nhifclaim'];
			//$nhifclaim = -$nhifclaim;
			$nhifclaim = $nhifqty*($nhifrate/$fxrate);
			$totaldiscountamount = $totaldiscountamount - $nhifclaim; 
		   }
		   $totalcreditamt = $totalcreditamt + $totaldiscountamount; 
			?>
			<tr>
				<td colspan="2" class="bodytext31"  valign="center"  align="left"><strong>Total Credits</strong></td>
				<td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($totalcreditamt,2,'.',','); ?></td>
			</tr>
			
            
			<?php
			
			$totaldepositfinal=0;
			$totaldepositamount=0;
			$totaldepositrefundamount = 0;	
			$depositrefundamount=0;
			$totaldeposit=0;
			$tot=0;
			$query112 = "select *,sum(transactionamount) as transactionamount from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_receipt = mysqli_num_rows($exec112);
			
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositamount = $res112['transactionamount'];
			//$depositamount = 1*($depositamount/$fxrate);
			$depositamount1 = $depositamount;
			$docno = $res112['docno'];
			$transactionmode = $res112['transactionmode'];
			$transactiondate = $res112['transactiondate'];
			$chequenumber = $res112['chequenumber'];
			
			$query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res731 = mysqli_fetch_array($exec731);
			$depositbilltype = $res731['billtype'];
			
			$totaldiscountamount = 0;
			
			 
			$query1122 = "select *,sum(amount) as amount from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec1122 = mysqli_query($GLOBALS["___mysqli_ston"], $query1122) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_receipt1 = mysqli_num_rows($exec1122);
			 while($res1122 = mysqli_fetch_array($exec1122))
			{
			$depositrefundamount = $res1122['amount'];
			
			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			 
			}
			
			$totaldepositamount = $totaldepositamount + $depositamount1;
			$tot=$tot+$depositamount1; 
			$totaldeposit=$tot-$totaldepositrefundamount-$totaldiscountamount; 
			$totaldeposit=-$totaldeposit; 
			} 
			//*****************advance deposit*******************
			$totaladvancedepositamount = 0;
			$queryadv = "select *,sum(transactionamount) as transactionamount from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$execadv = mysqli_query($GLOBALS["___mysqli_ston"], $queryadv) or die("Error in Queryadv".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_advdep = mysqli_num_rows($execadv);
			 while($resadv = mysqli_fetch_array($execadv))
			{
			$advancedepositamount = $resadv['transactionamount'];
			
			$totaladvancedepositamount += $advancedepositamount;			 
			}
			//*****************advance deposit ends*******************
			$totaldeposit += $totaladvancedepositamount;
			$totaldepositfinal=-$totaldeposit/$fxrate;
			
			?>
			<tr>
				<td class="bodytext31" colspan="2" valign="center"  align="left"><strong>Less Deposit and Deposit Refunds:</strong></td>
				<td class="bodytext31" colspan="2" valign="center"  align="right"><?php echo number_format($totaldeposit/$fxrate,2,'.',','); ?></td>
			</tr>
			   
               <?php
			
				$net_amount_summary=$payoveralltotal+$totalcreditamt+($totaldeposit/$fxrate)
			?>
			  
			<tr>
				<td class="bodytext31" colspan="2" valign="center"  align="left"><strong>Net Total:</strong></td>
				<td class="bodytext31" colspan="2" valign="center"  align="right"><?php echo number_format($net_amount_summary,2,'.',','); ?></td>
			</tr>
	</table>
						
<?php 
include('convert_currency_to_words.php');

$convertedwords = @covert_currency_to_words(number_format($net_amount_summary,2,'.',''));

?>
          
          <table align="center" cellpadding="0" cellspacing="2" width="" border="">
			<tr>
			<td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
		  </tr>
		<tr> 
            <td  width="550" class="bodytext31" align="left"><strong><?php echo $currency; ?></strong>
			<?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td> 
			<!-- <td  width="75" class="bodytext31" align="right"><strong>Balance :</strong></td>
			<td  width="90" align="right" class="bodytext31"><strong><?php echo number_format($net_amount_summary,2,'.',','); ?></strong></td> -->
		</tr>
		
         <tr>
			<td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
		  </tr>
         <tr>
			<td width="350" class="bodytext31" align="left">I Understand that my Liability to this bill is not waived.</td>
		 </tr>
		 <tr>
			<td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
		  </tr>
       
		 
</table>
<table width="530" align="center" border="0" cellspacing="0" cellpadding="2">
<tbody>
<tr>
			<td class="bodytext31" align="left">Parent / Guardian Sign ---------------------------------------</td>
			<td class="bodytext31" align="right">Discharged By : <?php echo $employeename; ?></td>
  </tr>
  </tbody>
</table>
</page>
<?php	
/*require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("Arial", "normal");
$canvas->page_text(544, 1628,"1/21", $font, 10, array(0,0,0));
$canvas->page_text(272, 814," Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("FinalBill.pdf", array("Attachment" => 0)); */
?>
<?php
$content = ob_get_clean();
    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_ip_final.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
