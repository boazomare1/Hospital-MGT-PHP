<?php
session_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="IncomeStatement.xls"');
header('Cache-Control: max-age=80');

include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$currentdate = date('d-m-Y');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$paymentreceiveddateto1 = "2014-01-01";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$sno = "";
$colorloopcount1="";
$grandtotal = '';
$grandtotal1 = "0.00";
$costofgoodssold = "0.00";
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_account2.php");

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
?>
</head>
<body>
<table width="291" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="237%" colspan="4" bgcolor="#FFFFFF" class="bodytext3" align="center"><strong> Income Statement</strong></td>
            </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
          </tbody>
        </table>
	    </td>
      </tr>
      
       <tr>
        <td><table width="292" border="0" 
            align="left" cellpadding="4" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse">
          <tbody>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			$ipfinaldiscount = '';
			$ipfinaldiscountcreditapproved = '';
		  $query2 = "select sum(consultation) as consultationamount from billing_consultation where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res2 = mysqli_fetch_array($exec2);
		  $consultationamount = $res2['consultationamount'];
		  
		  /*$query15 = "select sum(totalamount) as consultationamount from billing_paylaterconsultation where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec15= mysql_query($query15) or die ("Error in Query2".mysql_error());
		  $res15 = mysql_fetch_array($exec15);
		  echo $consultationamountpaylater = $res15['consultationamount'];
	*/
		  
		  $query3 = "select sum(totalamount) as paynowamount from billing_paynow where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  $paynowamount = $res3['paynowamount'];
		  
		 	  
		  $query10 = "select sum(totalamount) as paylateramount from billing_paylater where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res10 = mysqli_fetch_array($exec10);
		  $paylateramount = $res10['paylateramount'];
		  
		  $query61 = "select sum(totalamount) as externalamount from billing_external where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res61 = mysqli_fetch_array($exec61);
		  $externalamount = $res61['externalamount'];

		  
		  $query8 = "select sum(transactionamount) as expenseamount from expensesub_details where transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res8 = mysqli_fetch_array($exec8);
		  $expenseamount = $res8['expenseamount'];
		  
		  $query9 = "select * from master_company";
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res9 = mysqli_fetch_array($exec9);
		  $incometax = $res9['incometax'];
		  
		  $query16 = "select sum(transactionamount) as receiptamount from receiptsub_details where transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res16 = mysqli_fetch_array($exec16);
		  $receiptamount = $res16['receiptamount'];
		  
		  $query17 = "select sum(consultation) as consultationrefundamount from refund_consultation where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res17 = mysqli_fetch_array($exec17);
		  $consultationrefundamount = $res17['consultationrefundamount'];
		  
		  $query18 = "select sum(labitemrate) as paynowlabrefundamount from refund_paynowlab where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res18 = mysqli_fetch_array($exec18);
		  $paynowlabrefundamount = $res18['paynowlabrefundamount'];
		  
   	      $query19 = "select sum(radiologyitemrate) as paynowradiologyrefundamount from refund_paynowradiology where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res19 = mysqli_fetch_array($exec19);
		  $paynowradiologyrefundamount = $res19['paynowradiologyrefundamount'];
		  
		  $query20 = "select sum(servicesitemrate) as paynowservicesrefundamount from refund_paynowservices where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res20 = mysqli_fetch_array($exec20);
		  $paynowservicesrefundamount = $res20['paynowservicesrefundamount'];
		  
    	  $query20 = "select sum(amount) as paynowpharmacyrefundamount from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res20 = mysqli_fetch_array($exec20);
		  $paynowpharmacyrefundamount = $res20['paynowpharmacyrefundamount'];
		  
		  $query21 = "select sum(referalrate) as paynowreferalrefundamount from refund_paynowreferal where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res21 = mysqli_fetch_array($exec21);
		  $paynowreferalrefundamount = $res21['paynowreferalrefundamount'];

		  $totalrefundpaynow = $paynowlabrefundamount + $paynowradiologyrefundamount + $paynowservicesrefundamount + $paynowpharmacyrefundamount + $paynowreferalrefundamount;
		
		  $query22 = "select sum(totalamount) as paylaterrefundamount from refund_paylater where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res22 = mysqli_fetch_array($exec22);
		  $paylaterrefundamount = $res22['paylaterrefundamount'];
		  
		   $query32 = "select sum(labitemrate) as ipfinallabamount from billing_iplab where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res32 = mysqli_fetch_array($exec32);
		  $ipfinallabamount = $res32['ipfinallabamount'];
		  
   	      $query33 = "select sum(radiologyitemrate) as ipfinalradiologyamount from billing_ipradiology where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res33 = mysqli_fetch_array($exec33);
		  $ipfinalradiologyamount = $res33['ipfinalradiologyamount'];
		  
		  $query34 = "select sum(servicesitemrate) as ipfinalservicesamount from billing_ipservices where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res34 = mysqli_fetch_array($exec34);
		  $ipfinalservicesamount = $res34['ipfinalservicesamount'];
		  
    	  $query35 = "select sum(amount) as ipfinalpharmacyamount from billing_ippharmacy where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die ("Error in Query35".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res35 = mysqli_fetch_array($exec35);
		  $ipfinalpharmacyamount = $res35['ipfinalpharmacyamount'];
		  
		  $query36 = "select sum(amount) as ipfinalprivatedoctoramount from billing_ipprivatedoctor where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec36 = mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die ("Error in Query36".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res36 = mysqli_fetch_array($exec36);
		  $ipfinalprivatedoctoramount = $res36['ipfinalprivatedoctoramount'];
		  
		  $query37 = "select sum(amount) as ipfinalotbillingamount from billing_ipotbilling where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die ("Error in Query37".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res37 = mysqli_fetch_array($exec37);
		  $ipfinalotbillingamount = $res37['ipfinalotbillingamount'];


		  $query38 = "select sum(amount) as ipfinalmiscbilling from billing_ipmiscbilling where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec38 = mysqli_query($GLOBALS["___mysqli_ston"], $query38) or die ("Error in Query38".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res38 = mysqli_fetch_array($exec38);
		  $ipfinalmiscbilling = $res38['ipfinalmiscbilling'];

  		  $query39 = "select sum(amount) as ipfinalbedcharges from billing_ipbedcharges where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die ("Error in Query39".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res39 = mysqli_fetch_array($exec39);
		 $ipfinalbedcharges = $res39['ipfinalbedcharges'];

 		  $query40 = "select sum(amount) as ipfinalambulance from billing_ipambulance where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec40= mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res40 = mysqli_fetch_array($exec40);
		 $ipfinalambulance = $res40['ipfinalambulance'];
		  
		  $query41 = "select sum(amount) as ipfinalnhif from billing_ipnhif where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec41= mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res41 = mysqli_fetch_array($exec41);
		  $ipfinalnhif = $res41['ipfinalnhif'];


		  $query43 = "select sum(amount) as ipfinaladmissioncharge from billing_ipadmissioncharge where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec43= mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die ("Error in Query43".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res43 = mysqli_fetch_array($exec43);
		 $ipfinaladmissioncharge = $res43['ipfinaladmissioncharge'];
		  
		  if($ipfinaladmissioncharge != '')
		  {
		  
		  $query42 = "select sum(discount) as ipfinaldiscount,sum(deposit) as  ipfinaldeposit from billing_ip where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec42= mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res42 = mysqli_fetch_array($exec42);
		  $ipfinaldiscount = $res42['ipfinaldiscount'];
		  $ipfinaldeposit = $res42['ipfinaldeposit'];
		  
		  $query421 = "select sum(discount) as ipfinaldiscount,sum(deposit) as  ipfinaldeposit from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec421= mysqli_query($GLOBALS["___mysqli_ston"], $query421) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res421 = mysqli_fetch_array($exec421);
		  $ipfinaldiscountcreditapproved = $res421['ipfinaldiscount'];
		  $ipfinaldepositcreditapproved = $res421['ipfinaldeposit'];
		  }

				
		$totalipamount = $ipfinallabamount  + $ipfinaladmissioncharge  + $ipfinalambulance + $ipfinalbedcharges + $ipfinalmiscbilling + $ipfinalotbillingamount +  $ipfinalpharmacyamount + $ipfinalservicesamount +  $ipfinalradiologyamount - $ipfinaldiscount - $ipfinaldiscountcreditapproved;


		
			include("costofgoodssoldcalculation.php");
		 
		  $totalrevenue = $consultationamount + $paynowamount + $paylateramount + $totalipamount + $externalamount;
		  $totalrevenue = $totalrevenue - $consultationrefundamount - $totalrefundpaynow + $paylaterrefundamount;
		  $totalpaylaterpharmrefundamount = 0;
		  $query23 = "select * from pharmacysalesreturn_details where billstatus = 'completed' and entrydate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res23 = mysqli_fetch_array($exec23))
		  {
		  $paylaterpharmrefundpatientcode = $res23['patientcode'];
		  
		  $query231 = "select * from master_customer where customercode = '$paylaterpharmrefundpatientcode'";
		  $exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res231 = mysqli_fetch_array($exec231);
		  $patientrefundtype = $res231['billtype'];
		  
		  if($patientrefundtype == 'PAY LATER')
		  {
		  $paylaterpharmrefundamount = $res23['totalamount'];
		  $totalpaylaterpharmrefundamount = $totalpaylaterpharmrefundamount + $paylaterpharmrefundamount;
		  }
		  }
	      $totalrevenue = $totalrevenue - $totalpaylaterpharmrefundamount;

		  $costofgoodssold = $grandtotalcogs;
		  if($costofgoodssold == '')
		  {
		  $costofgoodssold = "0.00";
		  }
		  
		  $query661 = "select sum(costofsales) as labcogs from cogsentry where coa='02-2003' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec661 = mysqli_query($GLOBALS["___mysqli_ston"], $query661) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res661 = mysqli_fetch_array($exec661);
		  $labcogs = $res661['labcogs'];
		  
		  $query6611 = "select sum(costofsales) as labcogs from cogsentry where coa='02-2004' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6611 = mysqli_query($GLOBALS["___mysqli_ston"], $query6611) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6611 = mysqli_fetch_array($exec6611);
		  $labcogs1 = $res6611['labcogs'];
		  
		  $totallabcogs = $labcogs + $labcogs1;

		  
		  $query663 = "select sum(costofsales) as radiologycogs from cogsentry where coa='02-2007' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec663 = mysqli_query($GLOBALS["___mysqli_ston"], $query663) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res663 = mysqli_fetch_array($exec663);
		  $radiologycogs = $res663['radiologycogs'];
		  
		  $query6631 = "select sum(costofsales) as radiologycogs from cogsentry where coa='02-2008' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6631 = mysqli_query($GLOBALS["___mysqli_ston"], $query6631) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6631 = mysqli_fetch_array($exec6631);
		  $radiologycogs1 = $res6631['radiologycogs'];
		  
		  $totalradiologycogs = $radiologycogs + $radiologycogs1;


		  $query664 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2009' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec664 = mysqli_query($GLOBALS["___mysqli_ston"], $query664) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res664 = mysqli_fetch_array($exec664);
		  $servicecogs = $res664['servicecogs'];
		  
		   $query6641 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2002' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6641 = mysqli_query($GLOBALS["___mysqli_ston"], $query6641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6641 = mysqli_fetch_array($exec6641);
		  $servicecogs1 = $res6641['servicecogs'];
		  
		   $query6642 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2006' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6642 = mysqli_query($GLOBALS["___mysqli_ston"], $query6642) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6642 = mysqli_fetch_array($exec6642);
		  $servicecogs2 = $res6642['servicecogs'];
		  
		  $query6643 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2008' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6643 = mysqli_query($GLOBALS["___mysqli_ston"], $query6643) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6643 = mysqli_fetch_array($exec6643);
		  $servicecogs3 = $res6643['servicecogs'];
		  
		  $query6644 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2010' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6644 = mysqli_query($GLOBALS["___mysqli_ston"], $query6644) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6644 = mysqli_fetch_array($exec6644);
		  $servicecogs4 = $res6644['servicecogs'];
		  
		  $query6645 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2011' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6645 = mysqli_query($GLOBALS["___mysqli_ston"], $query6645) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6645 = mysqli_fetch_array($exec6645);
		  $servicecogs5 = $res6645['servicecogs'];
		  
    	  $query6646 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2012' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6646 = mysqli_query($GLOBALS["___mysqli_ston"], $query6646) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6646 = mysqli_fetch_array($exec6646);
		  $servicecogs6 = $res6646['servicecogs'];
		  
		  $query6647 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2013' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6647 = mysqli_query($GLOBALS["___mysqli_ston"], $query6647) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6647 = mysqli_fetch_array($exec6647);
		  $servicecogs7 = $res6647['servicecogs'];
		  
		   $query6648 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2014' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6648 = mysqli_query($GLOBALS["___mysqli_ston"], $query6648) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6648 = mysqli_fetch_array($exec6648);
		  $servicecogs8 = $res6648['servicecogs'];
		  
		  $totalservicecogs = $servicecogs1 + $servicecogs2 + $servicecogs3 + $servicecogs4 + $servicecogs5 + $servicecogs6 + $servicecogs7 + $servicecogs8;



		  $query662 = "select sum(staffexpenses) as staffexpenses,sum(utility) as utility,sum(misc) as misc from cogsentry where coa='01-1003' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec662 = mysqli_query($GLOBALS["___mysqli_ston"], $query662) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res662 = mysqli_fetch_array($exec662);
		  $staffexpenses = $res662['staffexpenses'];
		   $utility = $res662['utility'];
		    $misc = $res662['misc'];
			$totalcogsentryvalue = $staffexpenses + $utility + $misc;
			
			$totalexpenseamount = $totalcogsentryvalue + $expenseamount;
			
			$query663 = "select sum(assetvalue) as totalassets from depreciation_information where recorddate between '$ADate1' and '$ADate2'";
			$exec663 = mysqli_query($GLOBALS["___mysqli_ston"], $query663) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res663 = mysqli_fetch_array($exec663);
			$totalassets = $res663['totalassets'];
			
		    $currentyear = substr($currentdate,6,10);
			$totaldepreciation = 0;
			$query664 = "select * from depreciation_information where recorddate between '$ADate1' and '$ADate2'";
			$exec664 = mysqli_query($GLOBALS["___mysqli_ston"], $query664) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res664 = mysqli_fetch_array($exec664))
			{
			$startyear = $res664['startyear'];
			$depreciation = $res664['depreciation'];
			$differenceyear = $currentyear - $startyear;
			if($startyear != $currentyear)
			{
			$depreciation = $depreciation * $differenceyear;
			}
			$totaldepreciation = $totaldepreciation + $depreciation;
			}
			
			
	
		  $grossprofit = ($totalrevenue+$receiptamount) - $costofgoodssold - $totallabcogs - $totalradiologycogs - $totalservicecogs;
		  $incomefromoperations = $grossprofit - $expenseamount - $totalcogsentryvalue - $totaldepreciation;
		  $nonoperatingitems = 0;
		  $incomebeforetaxes = $incomefromoperations - $nonoperatingitems;
		  $taxamount = $incometax * $incomebeforetaxes;
		  $taxamount = $taxamount/100;
		  $netincome = $incomebeforetaxes - $taxamount;
		  
		  
				?>
			
           <tr>
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Sales Revenue</strong></td>
              <td width="37"  align="right" valign="center" class="bodytext31" style="mso-number-format:'\@' "><?php echo number_format($totalrevenue,2,'.',','); ?> </td>
           </tr>
		   <tr >
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Other Incomes</strong></td>
              <td width="37"  align="right" valign="center" class="bodytext31" style="mso-number-format:'\@' "><?php echo number_format($receiptamount,2,'.',','); ?> </td>
           </tr>
		  <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>COGS - Pharmacy</strong></td>
              <td class="bodytext31" valign="right"  align="right" style="mso-number-format:'\@' "><?php echo number_format($costofgoodssold,2,'.',','); ?> </td>
           </tr>
		    <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>COGS - Laboratory</strong></td>
              <td class="bodytext31" valign="right"  align="right" style="mso-number-format:'\@' "><?php echo number_format($totallabcogs,2,'.',','); ?> </td>
           </tr>
		    <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>COGS - Radiology</strong></td>
              <td class="bodytext31" valign="right"  align="right" style="mso-number-format:'\@' "><?php echo number_format($totalradiologycogs,2,'.',','); ?> </td>
           </tr>
		    <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>COGS - Services</strong></td>
              <td class="bodytext31" valign="right"  align="right" style="mso-number-format:'\@' "><?php echo number_format($totalservicecogs,2,'.',','); ?> </td>
           </tr>

			<tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Gross Profit</strong></td>
              <td class="bodytext31" valign="right"  align="right" style="mso-number-format:'\@' "><?php echo number_format($grossprofit,2,'.',','); ?> </td>
           </tr>
		   <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Operating Expense</strong></td>
              <td class="bodytext31" valign="right"  align="right" style="mso-number-format:'\@' "><?php echo number_format($totalexpenseamount,2,'.',','); ?> </td>
           </tr>
		   
		    <tr >
              <td class="bodytext31" valign="center"  align="left"><strong> Depreciation </strong></td>
              <td class="bodytext31" valign="right"  align="right" style="mso-number-format:'\@' "><?php echo number_format($totaldepreciation,2,'.',','); ?> </td>
           </tr>
		   
		    <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Income from Operations</strong></td>
              <td class="bodytext31" valign="right"  align="right" style="mso-number-format:'\@' "><?php echo number_format($incomefromoperations,2,'.',','); ?> </td>
           </tr>
		   <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Non Operating Items</strong></td>
              <td class="bodytext31" valign="right"  align="right" style="mso-number-format:'\@' "><?php echo number_format($nonoperatingitems,2,'.',','); ?> </td>
           </tr>
		    <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Income Before Taxes</strong></td>
              <td class="bodytext31" valign="right"  align="right" style="mso-number-format:'\@' "><?php echo number_format($incomebeforetaxes,2,'.',','); ?> </td>
           </tr>
		   <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Income Taxes</strong></td>
              <td class="bodytext31" valign="right"  align="right" style="mso-number-format:'\@' "><?php echo number_format($taxamount,2,'.',','); ?> </td>
           </tr>
		   <tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Net Income</strong></td>
              <td class="bodytext31" valign="right"  align="right" style="mso-number-format:'\@' "><?php echo number_format($netincome,2,'.',','); ?> </td>
           </tr>
   		  </tbody>
        </table>		<?php
			}
			?>
			

</body>
</html>
