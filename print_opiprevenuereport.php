<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');

$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '0.00';
$looptotalpaidamount = '0.00';
$looptotalpendingamount = '0.00';
$looptotalwriteoffamount = '0.00';
$looptotalcashamount = '0.00';
$looptotalcreditamount = '0.00';
$looptotalcardamount = '0.00';
$looptotalonlineamount = '0.00';
$looptotalchequeamount = '0.00';
$looptotaltdsamount = '0.00';
$looptotalwriteoffamount = '0.00';
$pendingamount = '0.00';
$accountname = '';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="opiprevenuereport.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 
 
 $locationcode=$_REQUEST['locationcode'];
 $transactiondatefrom=$_REQUEST['ADate1'];
 $transactiondateto=$_REQUEST['ADate2'];
 

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	

}


if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];


?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none;
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>

</head>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">

  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
    
       <td width="860">	
        </td>
  </tr>
       <tr>
    <td width="1%">&nbsp;</td>
    </tr>
  <tr>
      <td colspan="7"><strong>OP-IP Revenue Report: </strong><?php echo  ' '.$transactiondatefrom.' To '.$transactiondateto;?></td>
  </tr>
  <tr>
      <td colspan="7">&nbsp;</td>
  </tr>
 
  <tr>
     <td>
        <!-- TABLE FOR OP REVENUE REPORT-->
       
       <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" align="left" border="1">
          <tbody>
            <tr>
            <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>OP Revenue </strong></td>
             <!-- <td width="10%" bgcolor="#ecf0f5" class="bodytext31">Op Renenue</td>-->
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext31">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
				}	
					?> 
                </td>
               
            </tr>
            
			
              <tr>
              	   <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Consultation</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Laboratory</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Radiology</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Service</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Referal</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Rescue</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Home Care</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
              </tr>
            <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
		        if($location!='All')
				{
					//this query for consultation
			$query1 = "select sum(consultation) as billamount1 from billing_consultation where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
			
			$query1 = "select sum(totalamount) as billamount1 from billing_paylaterconsultation where locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res2consultationamount = $res1['billamount1'];
		
			?>
		   <?php
		  // this query for pharmacy
		  	  $query8 = "select sum(amount) as amount1 from billing_paylaterpharmacy where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8pharmacyitemrate = $res8['amount1'];
			
			$query9 = "select sum(amount) as amount1 from billing_paynowpharmacy where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$res9pharmacyitemrate = $res9['amount1'];
			
			$query17 = "select sum(amount) as amount1 from billing_externalpharmacy where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$res17pharmacyitemrate = $res17['amount1'];
			
			//this query for laboratry
			$query2 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$res2labitemrate = $res2['labitemrate1'];
			
			$query3 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3labitemrate = $res3['labitemrate1'];
			
			$query14 = "select sum(labitemrate) as labitemrate1 from billing_externallab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res14 = mysqli_fetch_array($exec14);
			$res14labitemrate = $res14['labitemrate1'];
			
			$totallabitemrate = $res2labitemrate + $res3labitemrate + $res14labitemrate;
			
			?>
		   <?php
			//this query for radiology
			$query4 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4radiologyitemrate = $res4['radiologyitemrate1'];
			
			$query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5radiologyitemrate = $res5['radiologyitemrate1'];
			
			$query15 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res15 = mysqli_fetch_array($exec15);
			$res15radiologyitemrate = $res15['radiologyitemrate1'];
			
			$totalradiologyitemrate = $res4radiologyitemrate + $res5radiologyitemrate + $res15radiologyitemrate;
			
			
			?>
		   
		   <?php
			//this query for service
			$query6 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6servicesitemrate = $res6['servicesitemrate1'];
			
			$query7 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7servicesitemrate = $res7['servicesitemrate1'];
			
			$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res16 = mysqli_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate1'];
			
			$totalservicesitemrate = $res6servicesitemrate + $res7servicesitemrate + $res16servicesitemrate ;
			
			$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res10 = mysqli_fetch_array($exec10);
			$res10referalitemrate = $res10['referalrate1'];
			
			$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11referalitemrate = $res11['referalrate1'];
			
			//this query for refund consultation
			
			$query12 = "select sum(consultation) as consultation1 from refund_consultation where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res12refundconsultation = $res12['consultation1'];
			
			//this query for refund pharmacy
			
			$query21 = "select sum(amount)as amount1 from refund_paylaterpharmacy where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21) ;
			$res21refundlabitemrate = $res21['amount1'];
			$query22 = "select sum(amount)as amount1 from refund_paynowpharmacy where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundlabitemrate = $res22['amount1'];
			$totalrefundpharmacy = $res22refundlabitemrate + $res21refundlabitemrate;
			
			//this query for refund laboratory
			
			$query19 = "select sum(labitemrate)as labitemrate1 from refund_paylaterlab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res19 = mysqli_fetch_array($exec19) ;
			$res19refundlabitemrate = $res19['labitemrate1'];
			$query20 = "select sum(labitemrate)as labitemrate1 from refund_paynowlab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res20 = mysqli_fetch_array($exec20) ;
			$res20refundlabitemrate = $res20['labitemrate1'];
			$totalrefundlab = $res20refundlabitemrate + $res19refundlabitemrate;
			
			
			//this query for refund radiology
			
			$query22 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paylaterradiology where locationcode='$locationcode' and billdate between             '$transactiondatefrom' and '$transactiondateto'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundradioitemrate = $res22['radiologyitemrate1'];
			$query23 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where locationcode='$locationcode' and billdate between             '$transactiondatefrom' and '$transactiondateto'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23) ;
			$res23refundradioitemrate = $res23['radiologyitemrate1'];
			$totalrefundradio = $res23refundradioitemrate + $res22refundradioitemrate;
			
			//this query for refund service
			
			$query24 = "select sum(servicesitemrate)as servicesitemrate1 from refund_paylaterservices where locationcode='$locationcode' and billdate between             '$transactiondatefrom' and '$transactiondateto'";
			$exec24= mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res24 = mysqli_fetch_array($exec24) ;
			$res24refundserviceitemrate = $res24['servicesitemrate1'];
			$query25 = "select sum(servicesitemrate)as servicesitemrate1 from refund_paynowservices where locationcode='$locationcode' and billdate between             '$transactiondatefrom' and '$transactiondateto'";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25) ;
			$res25refundserviceitemrate = $res25['servicesitemrate1'];
			$totalrefundservice = $res25refundserviceitemrate + $res24refundserviceitemrate;
			
				//this query for refund referal
			
			$query26 = "select sum(referalrate)as referalrate1 from refund_paylaterreferal where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec26= mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res26 = mysqli_fetch_array($exec26) ;
			$res26refundreferalitemrate = $res26['referalrate1'];
			$query27 = "select sum(referalrate)as referalrate1 from refund_paynowreferal where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res27 = mysqli_fetch_array($exec27) ;
			$res27refundreferalitemrate = $res27['referalrate1'];
			$totalrefundreferal = $res27refundreferalitemrate + $res26refundreferalitemrate;
			
			//this query for home care
		$query28 = "select sum(amount) as amount1 from billing_homecare where locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
			$exec28= mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query28".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res28 = mysqli_fetch_array($exec28) ;
			$res28homecare = $res28['amount1'];
			
			$query29 = "select sum(amount) as amount1 from billing_homecarepaylater where locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
			$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res29 = mysqli_fetch_array($exec29) ;
			$res29homecare = $res29['amount1'];
			$totalhomecare = $res28homecare + $res29homecare;
			
			//this query for rescue
			$query30 = "select sum(amount) as amount1 from billing_opambulance where locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
			$exec30= mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res30 = mysqli_fetch_array($exec30) ;
			$res30rescue = $res30['amount1'];
			
			$query31 = "select sum(amount) as amount1 from billing_opambulancepaylater where locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31) ;
			$res31rescue = $res31['amount1'];
			$totalrescue = $res30rescue + $res31rescue;
			
			//this code for total
			/*$totalconsultation=$res1consultationamount+$res2consultationamount+$res12refundconsultation;
			$totalPharmacy=$res9pharmacyitemrate+$res8pharmacyitemrate+$res17pharmacyitemrate+$totalrefundpharmacy;
			$totalLaboratry	=$res3labitemrate+$res2labitemrate+$res14labitemrate+$totalrefundlab;
			$totalRadiology	=$res5radiologyitemrate+$res4radiologyitemrate+$res15radiologyitemrate+$totalrefundradio;
			$totalService=$res7servicesitemrate+$res6servicesitemrate+$totalservicesitemrate+$totalrefundservice;
			$totalRefferal=$res11referalitemrate+$res10referalitemrate+$total+$totalrefundreferal;
			*/
			/*$snocount = $snocount + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				//$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				//$colorcode = 'bgcolor="#ecf0f5"';
			}*/
			
			//for cash total
			$casetotal=$res1consultationamount+$res9pharmacyitemrate+$res3labitemrate+$res5radiologyitemrate+$res7servicesitemrate+$res11referalitemrate+$res30rescue+$res28homecare;
			//for credit total
			$credittotal=$res2consultationamount+$res8pharmacyitemrate+$res2labitemrate+$res4radiologyitemrate+$res6servicesitemrate+$res10referalitemrate+$res31rescue+$res29homecare;
			//for external total
			
			 $externaltotal=$res17pharmacyitemrate+$res14labitemrate+$res15radiologyitemrate+$res16servicesitemrate+$total;
			
			//for refund total
			$refundtotal=$res12refundconsultation+$totalrefundpharmacy+$totalrefundlab+$totalrefundradio+$totalrefundservice+$totalrefundreferal;
			
			$holetotal1=$casetotal+$credittotal+$externaltotal-$refundtotal;
			?>
              <tr>
              	  <td class="bodytext31" valign="center"  align="left"><strong>Cash</strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res1consultationamount,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo  number_format($res9pharmacyitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res3labitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res5radiologyitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res7servicesitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res11referalitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res30rescue,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res28homecare,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($casetotal,2,'.',','); ?></strong></div></td>
       
               </tr>
               
              
              <tr>
                  <td class="bodytext31" valign="center"  align="left"><strong>Credit</strong></td>	
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res2consultationamount,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res8pharmacyitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res2labitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res4radiologyitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res6servicesitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res10referalitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res31rescue,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res29homecare,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($credittotal,2,'.',','); ?></strong></div></td>
                 
              </tr>
              
              <tr>
                  <td class="bodytext31" valign="center"  align="left"><strong>External</strong></td>
                   <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res17pharmacyitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res14labitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res15radiologyitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalservicesitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($total,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($externaltotal,2,'.',','); ?></strong></div></td>
             
              </tr>
             
             <tr>
            	 <td class="bodytext31" valign="center"  align="left"><strong>Refund</strong></td>
             <td class="bodytext31" width="30" valign="center"  align="right"><div class="bodytext31"><?php echo '-'.number_format($res12refundconsultation,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo '-'.number_format($totalrefundpharmacy,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo '-'.number_format($totalrefundlab,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo '-'.number_format($totalrefundradio,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo '-'.number_format($totalrefundservice,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo '-'.number_format($totalrefundreferal,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo '-'.number_format($refundtotal,2,'.',','); ?></strong></div></td>
             </tr>
             
              <!--VENU TOTAL CALCULATION-->
                <?php
					$tot_consult = $res1consultationamount+$res2consultationamount-$res12refundconsultation;
					$tot_pharmacy = $res9pharmacyitemrate+$res8pharmacyitemrate+$res17pharmacyitemrate-$totalrefundpharmacy;
					$tot_lab = $res3labitemrate+$res2labitemrate+$res14labitemrate-$totalrefundlab;
					$tot_radiol = $res5radiologyitemrate+$res4radiologyitemrate+$res15radiologyitemrate-$totalrefundradio;
					$tot_serv = $res7servicesitemrate+$res6servicesitemrate+$res16servicesitemrate-$totalrefundservice;
					$tot_reffer = $res11referalitemrate+$res10referalitemrate+$total-$totalrefundreferal;
				?>
             
                <tr>
            	  <td class="bodytext31" valign="center"  align="left"><strong>Total</strong></td>
                  <td class="bodytext31" width="30" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_consult,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_pharmacy,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_lab,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_radiol,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_serv,2,'.',','); ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_reffer,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalrescue,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalhomecare,2,'.',','); ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($holetotal1,2,'.',','); ?></strong></div></td>
               
                </tr>              
		      <?php
				}
				}
			
			?>
          </tbody>
        </table>
     </td>
  </tr>
      
   <tr>  
     <td class="bodytext31" width="30" valign="center"align="left"><strong>&nbsp;</strong></td> 
   </tr>
      
   <tr>
      <td>
         <!--TABLE FOR IP REVENUE REPORT-->
        <table width="auto" id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4"  align="left" border="1">
          <tbody>
            <tr>
             <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Ip Renenue </strong></td>
              <!--<td width="10%" bgcolor="#ecf0f5" class="bodytext31">Ip Renenue</td>-->
              <td colspan="14" bgcolor="#ecf0f5" class="bodytext31">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
				}	
					?>
               </td>
            </tr>
            
		    <tr <?php //echo $colorcode; ?> margin='10'>
              <td width="7%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  ></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"  ><strong>Admn Fee</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Bed Charge</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Ward</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>RMO</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pvtdr</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Laboratry</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Radiology</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Service</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pkg</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Recovery</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Resuce</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Homecare</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Misc</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
             </tr>
            <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
		        if($location!='All')
				{
			//this query for consultation
			
			$query111 = "select sum(amount) from billing_ipadmissioncharge where locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num111=mysqli_num_rows($exec111);
			$res111 = mysqli_fetch_array($exec111);
			$totalipadmissionamount =$res111['sum(amount)'];
			
			$query113 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode' and description='bed charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec113 = mysqli_query($GLOBALS["___mysqli_ston"], $query113) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num113 = mysqli_num_rows($exec113);
			$res113 = mysqli_fetch_array($exec113);
			$totalbedcharges =$res113['sum(amount)'];
			
			$query115 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode' and description='Ward Dispensing Charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num115 = mysqli_num_rows($exec115);
			$res115 = mysqli_fetch_array($exec115);
			$totalwardcharges =$res115['sum(amount)'];
			
			$query117 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode' and description='Resident Doctor Charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec117 = mysqli_query($GLOBALS["___mysqli_ston"], $query117) or die ("Error in Query117".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num117 = mysqli_num_rows($exec117);
			$res117 = mysqli_fetch_array($exec117);
			$totalrmocharges =$res117['sum(amount)'];
			
			$query118 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode' and description!='Resident Doctor Charges' and description!='Ward Dispensing Charges' and description!='bed charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec118 = mysqli_query($GLOBALS["___mysqli_ston"], $query118) or die ("Error in Query118".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num118 = mysqli_num_rows($exec118);
			$res118 = mysqli_fetch_array($exec118);
			$totalpkgcharges =$res118['sum(amount)'];
			
			$query119 = "select sum(amount) from billing_ipprivatedoctor where billtype='PAY NOW' and recorddate between '$transactiondatefrom' and '$transactiondateto' and locationcode='$locationcode' ";
			$exec119 = mysqli_query($GLOBALS["___mysqli_ston"], $query119) or die ("Error in Query119".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num119=mysqli_num_rows($exec119);
	        $res119 = mysqli_fetch_array($exec119);
			$totalipprivatedoctoramount=$res119['sum(amount)'];
			
			$query121 = "select sum(amount) as pharmamount from billing_ippharmacy where billtype='PAY NOW' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in query121".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res121 = mysqli_fetch_array($exec121);
			$res121pharmamount= $res121['pharmamount'];
			
			$query123 = "select sum(labitemrate) as labitemrate1 from billing_iplab where billtype='PAY NOW' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec123 = mysqli_query($GLOBALS["___mysqli_ston"], $query123) or die ("Error in query123".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res123 = mysqli_fetch_array($exec123);
			$res123labitemrate = $res123['labitemrate1'];
			
			$query125 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_ipradiology where billtype='PAY NOW' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec125 = mysqli_query($GLOBALS["___mysqli_ston"], $query125) or die ("Error in query125".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res125 = mysqli_fetch_array($exec125);
			$res125radiologyitemrate = $res125['radiologyitemrate1'];
			
			$query127 = "select sum(servicesitemrate) as servicesitemrate1 from billing_ipservices where billtype='PAY NOW' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec127 = mysqli_query($GLOBALS["___mysqli_ston"], $query127) or die ("Error in Query127".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res127 = mysqli_fetch_array($exec127);
			$res127servicesitemrate = $res127['servicesitemrate1'];
			
			 $query135 = "select sum(amount) as homecareamountip from billing_iphomecare where locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
			$exec135 = mysqli_query($GLOBALS["___mysqli_ston"], $query135) or die ("Error in query135".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res135= mysqli_fetch_array($exec135);
		    $res135iphomecare = $res135['homecareamountip'];
			
			//VENU -- GETTING DATA FOR CASH MISLENOUS BILLING
			$querymisc = "SELECT sum(amount) AS miscamount FROM billing_ipmiscbilling where locationcode='$locationcode' and recorddate between '$ADate1' and '$ADate2'";
			$execmisc =  mysqli_query($GLOBALS["___mysqli_ston"], $querymisc) or die ("Error in querymisc".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resmisc = mysqli_fetch_array($execmisc);
			$misccashamount = $resmisc['miscamount'];
			//ENDS
			
			//this code for credit
			$query137 = "select sum(amount) from billing_ipprivatedoctor where billtype='PAY LATER' and recorddate between '$transactiondatefrom' and '$transactiondateto' and locationcode='$locationcode' ";
			$exec137 = mysqli_query($GLOBALS["___mysqli_ston"], $query137) or die ("Error in Query119".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num137=mysqli_num_rows($exec137);
	        $res137 = mysqli_fetch_array($exec137);
			$totalipprivatedoctoramount_credit=$res137['sum(amount)'];
			
			$query138 = "select sum(amount) as pharmamount from billing_ippharmacy where billtype='PAY LATER' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec138 = mysqli_query($GLOBALS["___mysqli_ston"], $query138) or die ("Error in query121".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res138 = mysqli_fetch_array($exec138);
			$pharmamount_credit= $res138['pharmamount'];
			
			$query139 = "select sum(labitemrate) as labitemrate1 from billing_iplab where billtype='PAY LATER' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec139 = mysqli_query($GLOBALS["___mysqli_ston"], $query139) or die ("Error in query123".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res139= mysqli_fetch_array($exec139);
			$labitemrate_credit = $res139['labitemrate1'];
			
			$query140 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_ipradiology where billtype='PAY LATER' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec140 = mysqli_query($GLOBALS["___mysqli_ston"], $query140) or die ("Error in query125".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res140 = mysqli_fetch_array($exec140);
			$radiologyitemrate_credit = $res140['radiologyitemrate1'];
			
			$query141 = "select sum(servicesitemrate) as servicesitemrate1 from billing_ipservices where billtype='PAY LATER' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec141 = mysqli_query($GLOBALS["___mysqli_ston"], $query141) or die ("Error in Query127".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res141= mysqli_fetch_array($exec141);
			$servicesitemrate_credit = $res141['servicesitemrate1'];
			
			//VENU-- GETTING DETAILS FOR CREDIT NOTE
			//--CREDIT NOTE FOR BED CHARGES
			//For Credit Note-- Bed Charges from ip_creditnotebrief
			$qrybedchgs = "SELECT sum(rate) AS bedchgs FROM ip_creditnotebrief WHERE description='Bed Charges' AND locationcode='$locationcode' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
			$execbedchgs = mysqli_query($GLOBALS["___mysqli_ston"], $qrybedchgs) or die ("Error in qrybedchgs".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rescbedchgs= mysqli_fetch_array($execbedchgs);
			$bedchgs = $rescbedchgs['bedchgs'];
			
			//For Credit Note Bed Charges -- discount from ip_discount
			/*$qrybedchgsdisc = "SELECT sum(rate) AS bedchgsdisc FROM ip_discount WHERE description='Bed Charges' AND locationcode='$locationcode' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
			$execbedchgsdisc = mysql_query($qrybedchgsdisc) or die ("Error in qrybedchgsdisc".mysql_error());
			$rescbedchgsdisc= mysql_fetch_array($execbedchgsdisc);
			$bedchgsdiscount = $rescbedchgsdisc['bedchgsdisc'];
			
			$bedchgcreditnote = $bedchgs + $bedchgsdiscount;*/
			$bedchgcreditnote = $bedchgs;
			
			//--CREDIT NOTE FOR WARD
			//For Credit Note-- Nursing Charges from ip_creditnotebrief
			$qrywardchgs = "SELECT sum(rate) AS wardchgs FROM ip_creditnotebrief WHERE description='Nursing Charges' AND locationcode='$locationcode' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
			$execwardchgs = mysqli_query($GLOBALS["___mysqli_ston"], $qrywardchgs) or die ("Error in qrywardchgs".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rescwardchgs= mysqli_fetch_array($execwardchgs);
			$wardchgs = $rescwardchgs['wardchgs'];
			
			/*//For Credit Note Nursing Charges  -- discount from ip_discount
			$qrywardchgsdisc = "SELECT sum(rate) AS wardchgsdisc FROM ip_discount WHERE description='Nursing Charges' AND locationcode='$locationcode' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
			$execwardchgsdisc = mysql_query($qrywardchgsdisc) or die ("Error in qrywardchgsdisc".mysql_error());
			$rescwardchgsdisc= mysql_fetch_array($execwardchgsdisc);
			$wardchgsdiscount = $rescwardchgsdisc['wardchgsdisc'];
			
			$wardchgcreditnote = $wardchgs + $wardchgsdiscount;*/
			$wardchgcreditnote = $wardchgs;
			
			//--CREDIT NOTE FOR RMO
			//For Credit Note-- RMO Charges from ip_creditnotebrief
			$qryrmochgs = "SELECT sum(rate) AS rmochgs FROM ip_creditnotebrief WHERE description='RMO Charges' AND locationcode='$locationcode' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
			$execrmochgs = mysqli_query($GLOBALS["___mysqli_ston"], $qryrmochgs) or die ("Error in qryrmochgs".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resrmochgs= mysqli_fetch_array($execrmochgs);
			$rmochgs = $resrmochgs['rmochgs'];
			
			//For Credit Note RMO Charges  -- discount from ip_discount
			/*$qryrmochgsdisc = "SELECT sum(rate) AS rmochgsdisc FROM ip_discount WHERE description='RMO Charges' AND locationcode='$locationcode' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
			$execrmochgsdisc = mysql_query($qryrmochgsdisc) or die ("Error in qryrmochgsdisc".mysql_error());
			$rescrmochgsdisc= mysql_fetch_array($execrmochgsdisc);
			$rmochgsdiscount = $rescrmochgsdisc['rmochgsdisc'];
			
			$rmochgcreditnote = $rmochgs + $rmochgsdiscount;*/
			$rmochgcreditnote = $rmochgs;
			
			//--CREDIT NOTE FOR LAB
			//For Credit Note-- Lab Charges from ip_creditnotebrief
			$qrylabchgs = "SELECT sum(rate) AS labchgs FROM ip_creditnotebrief WHERE description='Lab' AND locationcode='$locationcode' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
			$execlabchgs = mysqli_query($GLOBALS["___mysqli_ston"], $qrylabchgs) or die ("Error in qrylabchgs".mysqli_error($GLOBALS["___mysqli_ston"]));
			$reslabchgs= mysqli_fetch_array($execlabchgs);
			$labchgs = $reslabchgs['labchgs'];
			
			//For Credit Note Lab Charges  -- discount from ip_discount
			/*$qrylabchgsdisc = "SELECT sum(rate) AS labchgsdisc FROM ip_discount WHERE description='Lab' AND locationcode='$locationcode' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
			$execlabchgsdisc = mysql_query($qrylabchgsdisc) or die ("Error in qrylabchgsdisc".mysql_error());
			$reslabchgsdisc= mysql_fetch_array($execlabchgsdisc);
			$labchgsdiscount = $reslabchgsdisc['labchgsdisc'];
			
			$labchgcreditnote = $labchgs + $labchgsdiscount;*/
			$labchgcreditnote = $labchgs;
			
			//--CREDIT NOTE FOR RADIOLOGY
			//For Credit Note-- Radiology Charges from ip_creditnotebrief
			$qryradchgs = "SELECT sum(rate) AS radchgs FROM ip_creditnotebrief WHERE description='Radiology' AND locationcode='$locationcode' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
			$execradchgs = mysqli_query($GLOBALS["___mysqli_ston"], $qryradchgs) or die ("Error in qryradchgs".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resradchgs= mysqli_fetch_array($execradchgs);
			$radchgs = $resradchgs['radchgs'];
			
			/*//For Credit Note Radiology Charges  -- discount from ip_discount
			$qryradchgsdisc = "SELECT sum(rate) AS radchgsdisc FROM ip_discount WHERE description='Radiology' AND locationcode='$locationcode' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
			$execradchgsdisc = mysql_query($qryradchgsdisc) or die ("Error in qryradchgsdisc".mysql_error());
			$resradchgsdisc= mysql_fetch_array($execradchgsdisc);
			$radchgsdiscount = $resradchgsdisc['radchgsdisc'];
			
			$radchgcreditnote = $radchgs + $radchgsdiscount;*/
			$radchgcreditnote = $radchgs;
			
			//--CREDIT NOTE FOR SERVICES
			//For Credit Note-- Service Charges from ip_creditnotebrief
			$qryservchgs = "SELECT sum(rate) AS servchgs FROM ip_creditnotebrief WHERE description='Service' AND locationcode='$locationcode' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
			$execservchgs = mysqli_query($GLOBALS["___mysqli_ston"], $qryservchgs) or die ("Error in qryservchgs".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resservchgs= mysqli_fetch_array($execservchgs);
			$servchgs = $resservchgs['servchgs'];
			
			/*//For Credit Note Service Charges  -- discount from ip_discount
			$qryservchgsdisc = "SELECT sum(rate) AS servchgsdisc FROM ip_discount WHERE description='Service' AND locationcode='$locationcode' AND consultationdate BETWEEN '$ADate1' and '$ADate2'";
			$execservchgsdisc = mysql_query($qryservchgsdisc) or die ("Error in qryservchgsdisc".mysql_error());
			$resservchgsdisc= mysql_fetch_array($execservchgsdisc);
			$servchgsdiscount = $resservchgsdisc['servchgsdisc'];
			
			$servchgcreditnote = $servchgs + $servchgsdiscount;*/
			$servchgcreditnote = $servchgs;
			//ENDS
			
			//code for total 
			$admnfee=0;
			$totaladmnfee=$totalipadmissionamount+$admnfee;
			$bedcharge=0;
			//substract creditnote bed chgs
			$totalbedcharge=$totalbedcharges+$bedcharge-$bedchgcreditnote;
			$ward=0;
			//Substract creditnote ward chgs
			$totalward=$totalwardcharges+$ward-$wardchgcreditnote;
			$rmo=0;
			//Substract creditnote rmo chgs
			$totalrmo=$totalrmocharges+$rmo-$rmochgcreditnote;
			$totalpvtdr=$totalipprivatedoctoramount+$totalipprivatedoctoramount_credit;
			$totalpharmacy=$res121pharmamount+$pharmamount_credit;
			//Substract creditnote lab chgs
			$totallaboratry=$res123labitemrate+$labitemrate_credit-$labchgcreditnote; 
			//Substract creditnote Radiology chgs
			$totalradiology=$res125radiologyitemrate+$radiologyitemrate_credit-$radchgcreditnote;
			//Substract creditnote Sevice chgs
			$totalservice=$res127servicesitemrate+$servicesitemrate_credit-$servchgcreditnote;
			$pkg=0;
			$totalpkg=$totalpkgcharges+$pkg;
			$recovery=0;
			$resuce=0;
			$homecare=0;
			$totalhomecare=$res135iphomecare+$homecare;
			//MISC TOTAL (CASH+CREDIT)
			$misccreditamount = 0;
			$totmisc = $misccashamount + $misccreditamount;
			
			//CALCULATIONS FOR TOALS FOR ALL ROW WISE(CASH,CREDIT,IP CREDIT,TOTAL)
			//TOTAL FOR IP REVENUE -- CASH
			$totipcash = $totalipadmissionamount+$totalbedcharges+$totalwardcharges+$totalrmocharges+$totalipprivatedoctoramount+$res121pharmamount+$res123labitemrate+$res125radiologyitemrate+$res127servicesitemrate+$totalpkgcharges+$res135iphomecare+$misccashamount;
			
			//TOTAL FOR IP REVENUE -- CREDIT
			$totipcredit = $totalipprivatedoctoramount_credit+$pharmamount_credit+$labitemrate_credit+$radiologyitemrate_credit+$servicesitemrate_credit;
			
			//TOTAL FOR IP REVENUE -- IP CREDIT
			$totipcreditnote = $bedchgcreditnote+$wardchgcreditnote+$rmochgcreditnote+$labchgcreditnote+$radchgcreditnote+$servchgcreditnote;
			
			//HOLE TOTAL FOR IP REVENUE -- TOTAL
			$ipholetotal = $totaladmnfee+$totalbedcharge+$totalward+$totalrmo+$totalpvtdr+$totalpharmacy+$totallaboratry+$totalradiology+$totalservice+$totalpkg+$recovery+$resuce+$totalhomecare+$totmisc ;
			//ENDS
			
			
			$snocount = $snocount + 1;
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
              <tr>
              	  <td class="bodytext31" valign="center"  align="left"><strong>Cash</strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalipadmissionamount,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalbedcharges,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalwardcharges,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalrmocharges,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalipprivatedoctoramount,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res121pharmamount,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res123labitemrate,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res125radiologyitemrate,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res127servicesitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalpkgcharges,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res135iphomecare,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($misccashamount,2,'.',',');  ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totipcash,2,'.',',');?></strong></div></td>
              </tr>
              
              <tr>
              	  <td class="bodytext31" valign="center"  align="left"><strong>Credit</strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php   ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalipprivatedoctoramount_credit,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($pharmamount_credit,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($labitemrate_credit,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($radiologyitemrate_credit,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($servicesitemrate_credit,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totipcredit,2,'.',',');?></strong></div></td>
              </tr>
               <!-- VENU -- DATA DISPLAY FOR IP CREDIT-->
               <tr>
              	  <td class="bodytext31" valign="center"  align="left"><strong>IP Credit</strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo "-".number_format($bedchgcreditnote,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo "-".number_format($wardchgcreditnote ,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo "-".number_format($rmochgcreditnote ,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo "-".number_format($labchgcreditnote ,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo "-".number_format($radchgcreditnote  ,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo "-".number_format($servchgcreditnote  ,2,'.',',');?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo "-".number_format($totipcreditnote,2,'.',','); ?></strong></div></td>
              </tr>
              <!--ENDS-->
              
              <tr>
              	  <td class="bodytext31" valign="center"  align="left"><strong>Total</strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totaladmnfee,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalbedcharge,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalward,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalrmo,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalpvtdr,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalpharmacy,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totallaboratry,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalradiology,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalservice,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalpkg,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($recovery,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($resuce,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalhomecare,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totmisc,2,'.',',');  ?></strong></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($ipholetotal,2,'.',','); ?></strong></div></td>
              </tr>
              
               <tr>  
     				<td class="bodytext31" width="30" valign="center"align="left"><strong>&nbsp;</strong></td> 
   				</tr>
              
             <!--ROW TO DISPLAY CONSOLIDATION TOTALS AND PERCENTAGES FOR IP AND OP-->
                    <tr>
                        <td class="bodytext31" valign="center"  align="left"><strong>OP Revenue</strong></td>
                        <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($holetotal1,2,'.',',');  ?></strong></div></td>
                    </tr>
                    <tr>
                        <td class="bodytext31" valign="center"  align="left"><strong>IP Revenue</strong></td>
                        <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($ipholetotal,2,'.',',');   ?></strong></div></td>
                    </tr>
                    <?php
                    $totalopip = $holetotal1+$ipholetotal
                    ?>
                     <tr>
                        <td class="bodytext31" valign="center"  align="left"><strong>TOTAL</strong></td>
                        <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalopip,2,'.',',');   ?></strong></div></td>
                    </tr>
                     <tr><td class="bodytext31" width="30" valign="center"align="left"><strong>&nbsp;</strong></td></tr>
                     <tr><td class="bodytext31" width="30" valign="center"align="left"><strong>&nbsp;</strong></td></tr>
                      <?php
                      $oppercent = ($holetotal1/$totalopip)*100;
                      $ippercent = ($ipholetotal/$totalopip)*100
                      ?>
                      <tr>
                        <td class="bodytext31" valign="center"  align="left"><strong>OP %</strong></td>
                        <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo  number_format($oppercent,2,'.',',');  ?></strong></div></td>
                    </tr>
                    <tr>
                        <td class="bodytext31" valign="center"  align="left"><strong>IP %</strong></td>
                        <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo  number_format($ippercent,2,'.',','); ?></strong></div></td>
                    </tr>
             <!--ENDS--> 
              
           <?php
				}
				}
			
			?>
          </tbody>
        </table>
      </td>
   </tr>  
</table></table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

