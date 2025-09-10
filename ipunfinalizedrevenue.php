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
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$packageanum1="";
$ipunfinalizeamount='';
$ipfinalizedamount='';
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



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
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
		//$ADate1='2015-01-31';
		//$ADate2='2015-02-28';
		 $query1 = "SELECT SUM(`labitemrate`) as labtotal FROM `ipconsultation_lab` WHERE `patientvisitcode` NOT IN (SELECT `visitcode` FROM `billing_ip`) AND `consultationdate` BETWEEN '$ADate1' and '$ADate2' and freestatus <> 'Yes' and labrefund = 'norefund' and paymentstatus='paid'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		$res1 = mysqli_fetch_array($exec1);
		$labtotal=$res1['labtotal'];
		
		 $query2 = "SELECT SUM(radiologyitemrate) as radiologyitemrate FROM ipconsultation_radiology WHERE `patientvisitcode` NOT IN (SELECT `visitcode` FROM `billing_ip`) AND `consultationdate` BETWEEN '$ADate1' and '$ADate2' and radiologyrefund <> 'refund' and freestatus <> 'Yes' and paymentstatus <> 'pending'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2=mysqli_num_rows($exec2);
		$res2 = mysqli_fetch_array($exec2);
		$totalradiologyitemrate=$res2['radiologyitemrate'];
		
		 $query3 = "SELECT SUM(servicesitemrate) as servicesitemrate FROM ipconsultation_services WHERE `patientvisitcode` NOT IN (SELECT `visitcode` FROM `billing_ip`) AND `consultationdate` BETWEEN '$ADate1' and '$ADate2' and servicerefund <> 'refund' and freestatus <> 'Yes' and paymentstatus='paid'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num3=mysqli_num_rows($exec3);
		$res3 = mysqli_fetch_array($exec3);
		$totalservicesitemrate=$res3['servicesitemrate'];
		
		 $query4 = "SELECT SUM(amount) as privatedoctoramount FROM ipprivate_doctor WHERE `patientvisitcode` NOT IN (SELECT `visitcode` FROM `billing_ip`) AND `consultationdate` BETWEEN '$ADate1' and '$ADate2'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num4=mysqli_num_rows($exec4);
		$res4 = mysqli_fetch_array($exec4);
		$totalprivatedoctoramount=$res4['privatedoctoramount'];
		
		
		 $query5 = "SELECT sum(totalamount) as pharmacysaleamount FROM pharmacysales_details WHERE visitcode NOT IN (SELECT `visitcode` FROM `billing_ip`) AND entrydate BETWEEN '$ADate1' and '$ADate2' and freestatus <> 'Yes' and ipdocno <> ''";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num5=mysqli_num_rows($exec5);
		$res5 = mysqli_fetch_array($exec5);
		$totalpharmacysaleamount=$res5['pharmacysaleamount'];
		
		
		 $query6 = "SELECT sum(totalamount) as pharmacysalereturnamount FROM pharmacysalesreturn_details WHERE visitcode NOT IN (SELECT `visitcode` FROM `billing_ip`) AND entrydate BETWEEN '$ADate1' and '$ADate2' and ipdocno <> '' ";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num6=mysqli_num_rows($exec6);
		$res6 = mysqli_fetch_array($exec6);
		$totalpharmacysalereturnamount=$res6['pharmacysalereturnamount'];
		
		 $query7 = "SELECT sum(amount) as ambulanceamount FROM ip_ambulance WHERE patientvisitcode NOT IN (SELECT `visitcode` FROM `billing_ip`) AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num7=mysqli_num_rows($exec7);
		$res7 = mysqli_fetch_array($exec7);
		$totalambulanceamount=$res7['ambulanceamount'];
	
		 $query8 = "SELECT sum(rate) as totalipmis FROM ipmisc_billing WHERE patientvisitcode NOT IN (SELECT `visitcode` FROM `billing_ip`) AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num8=mysqli_num_rows($exec8);
		$res8 = mysqli_fetch_array($exec8);
		$totalipmis=$res8['totalipmis'];
		
		 $query9 = "SELECT sum(rate) as discountrate FROM ip_discount WHERE patientvisitcode NOT IN (SELECT `visitcode` FROM `billing_ip`) AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num9=mysqli_num_rows($exec9);
		$res9 = mysqli_fetch_array($exec9);
		$totaldiscountrate=$res9['discountrate'];
		
/*		 $query10 = "SELECT sum(nhifclaim) as nhifamount FROM ip_nhifprocessing WHERE patientvisitcode NOT IN (SELECT `visitcode` FROM `billing_ip`) AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		$num10=mysql_num_rows($exec10);
		$res10= mysql_fetch_array($exec10);
		$totalnhifamount=$res10['nhifamount'];
		
		 $query11 = "SELECT sum(transactionamount) as ipdepositamount FROM master_transactionipdeposit WHERE visitcode NOT IN (SELECT `visitcode` FROM `billing_ip`) AND transactiondate BETWEEN '$ADate1' and '$ADate2'";
		$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		$num11=mysql_num_rows($exec11);
		$res11= mysql_fetch_array($exec11);
		$totalipdepositamount=$res11['ipdepositamount'];
		
		 $query12 = "SELECT a.`docno`, a.`patientname`,a. `patientcode`, a.`visitcode`, a.`accountname`, a.`ward`, a.`bed`, a.`recorddate` as 'Allocation Date',d.`visitcode`,d.`patientname`,d.`recorddate` as 'Discharge date' FROM `ip_bedallocation` a JOIN `ip_discharge` d ON (a.`visitcode`=d.`visitcode`) WHERE a.`recorddate` BETWEEN '$ADate1' AND '$ADate2' AND d.recorddate BETWEEN '$ADate1' AND '$ADate2' order by 'visitcode'";
*/		

		 $query12 ="SELECT * FROM ip_bedallocation WHERE visitcode not in (select visitcode from `billing_ip`) and recorddate<='$ADate1' and dischargeddate<='$ADate2' and dischargeddate>='$ADate1' ";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num12=mysqli_num_rows($exec12);
		$totalbedcharges='0.00';
		while($res12= mysqli_fetch_array($exec12))
		{
		$allocationdate=$res12['recorddate'];
		$dischargeddate=$res12['dischargeddate'];
		$bedanum=$res12['bed'];
		
		   $query51 = "select bedcharges from master_bed where auto_number='$bedanum'";
		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res51 = mysqli_fetch_array($exec51);
		   $bedcharges = $res51['bedcharges'];
		
		
		if($ADate1 < $allocationdate)
		{
			$admitteddate=$allocationdate;
			$enddate=$dischargeddate;
			
			if($ADate2 < $dischargeddate)
			{
			$enddate=$ADate2;	
			}
			
		    $diff = abs(strtotime($admitteddate) - strtotime($enddate));
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
           $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		}
		else
		{
			$admitteddate=$ADate1;
			$enddate=$dischargeddate;
			
			if($ADate2 < $dischargeddate)
			{
			$enddate=$ADate2;	
			}
			
		    $diff = abs(strtotime($admitteddate) - strtotime($enddate));
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
          $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		}
			$bedchargeamount=$days*$bedcharges;
			$totalbedcharges=$totalbedcharges+$bedchargeamount;
		
		}
		
		 $query13 ="SELECT bed FROM ip_bedtransfer WHERE visitcode not in (select visitcode from `billing_ip`) and recorddate<='$ADate1' and recorddate BETWEEN '$ADate1' and '$ADate2'";
		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num13=mysqli_num_rows($exec13);
		$totalbedtransfercharges='0.00';
		while($res13= mysqli_fetch_array($exec13))
		{
		   $bedtransferanum = $res13['bed'];
		   
		   $query501 = "select bedcharges from master_bed where auto_number='$bedtransferanum'";
		   $exec501 = mysqli_query($GLOBALS["___mysqli_ston"], $query501) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res501 = mysqli_fetch_array($exec501);
		   $bedcharges = $res501['bedcharges'];
		   
		   $totalbedtransfercharges=$totalbedtransfercharges+$bedcharges;
		}
		
			$query14 = "select package from master_ipvisitentry where visitcode not in (select visitcode from `billing_ip`) and consultationdate between '$ADate1' and '$ADate2' and package <> 0";
			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$totalpackage='0.00';
			while($res14 = mysqli_fetch_array($exec14))
			{
			$packageanum = $res14['package'];
			
			
			$query74 = "select rate from master_ippackage where auto_number='$packageanum'";
			$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res74 = mysqli_fetch_array($exec74);
			$packageamount = $res74['rate'];
			$totalpackage=$totalpackage + $packageamount;
			}
		//echo 'totallab  '.$labtotal.'<br>';
		//echo 'totalradiology  '.$totalradiologyitemrate.'<br>';
		//echo 'totalservices  '.$totalservicesitemrate.'<br>';
		//echo 'totalprivatedoctor  '.$totalprivatedoctoramount.'<br>';
		//echo 'totalpharmacysale  '.$totalpharmacysaleamount.'<br>';
		//echo 'totalpharmacyreturn  -'.$totalpharmacysalereturnamount.'<br>';
		//echo 'totalambulanceamount  '.$totalambulanceamount.'<br>';
		//echo 'totalipmis  '.$totalipmis.'<br>';
		//echo 'totaldiscountrate  -'.$totaldiscountrate.'<br>';
		//echo 'totalnhifamount  -'.$totalnhifamount.'<br>';
		//echo 'totalipdepositamount  -'.$totalipdepositamount.'<br>';
		//echo 'totalbedcharges unfinalize '.$totalbedcharges.'<br>';

			$ipunfinalizeamount=$labtotal+$totalradiologyitemrate+$totalservicesitemrate+$totalprivatedoctoramount+$totalpharmacysaleamount-$totalpharmacysalereturnamount+$totalambulanceamount+$totalipmis-$totaldiscountrate+$totalbedcharges+$totalbedtransfercharges+$totalpackage;
			  ?>
			
	
