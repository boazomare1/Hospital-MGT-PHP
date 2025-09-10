<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$paymentreceiveddateto1 = "2014-01-01";
$errmsg = "";   
$ttlamt = '0.00';
$banum = "1";
$gran =0;
$totalnum2 = 0 ;
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$totalamount3 = "0.00";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$sno = "";
$colorloopcount1="";
$totalamount12 = "0.00";
//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d',strtotime('-1 month')); }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if (isset($_REQUEST["groupid"])) { $parentid = $_REQUEST["groupid"]; } else { $parentid = ""; }
//$frmflag2 = $_POST['frmflag2'];
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }

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
.bodytext44 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none; font-weight:bold
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

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td valign="top"><table width="701" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
			<input type="hidden" name="ledgerid" id="ledgerid">
            <?php
				$query2 = "select accountssub from master_accountssub where auto_number = '$parentid' and recordstatus <> 'deleted'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2 = mysqli_fetch_array($exec2);
				
				$accountsmain2 = $res2['accountssub'];
				?>
				<tbody>
				<tr>
				<td colspan="5" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $accountsmain2.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
				</tr>
				<?php
				$colorloopcount = '';
				$orderid1 = '';
				$lid = '';
				$openingbalance = "0.00";
				$sumopeningbalance = "0.00";
				$totalamount2 = '0.00';
				$totalamount12 = '0.00';
				$balance = '0.00';
				$sumbalance = '0.00';
				
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
		
					$queryjndr = "SELECT SUM(`debitamount`) as debit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjndr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjndr) or die ("Error in queryjndr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjndr = mysqli_fetch_array($execjndr);
					$jndebit = $resjndr['debit'];
					
					$queryjncr = "SELECT SUM(`creditamount`) as credit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjncr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjncr) or die ("Error in queryjncr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjncr = mysqli_fetch_array($execjncr);
					$jncredit = $resjncr['credit'];
					
					$journal = $jncredit - $jndebit;
					
					if($id == '01-10031-NHL')
					{
						$j = 0;
						$crresult = array();
						$querycr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_externallab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`rateuhx`) as income FROM `billing_iplab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Lab'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$j = $j+1;
						$crresult[$j] = $rescr1['income'];
						}	
						
						$i = 0;
						$drresult = array();
						$querydr1in = "SELECT SUM(`labitemrate`) as incomedebit FROM `refund_paynowlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Lab'
									   UNION ALL SELECT SUM(`labfxamount`) as incomedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$i = $i+1;
						$drresult[$i] = $resdr1['incomedebit'];
						}
						
						$balance = array_sum($crresult) - array_sum($drresult);
					}
					else 
					{
						$balance = 0;
					}
					
					if($id == '01-10032-LAB')
					{     //ip income lab
					$labtotal=0;
		$sno=0;
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
			
			$querytl32 = "select * from master_testtemplate where templatename='$labtemplate'";
			$exectl32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytl32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numtl32 = mysqli_num_rows($exectl32);
			$exectl=mysqli_fetch_array($exectl32);		
			$labtable=$exectl['templatename'];
			if($labtable=='')
			{
				$labtable='master_lab';
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
			$balance=$labtotal;
		
		}
		}
			  }              //ip income lab end
			  
			  
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
			 $query21 = "select * from master_visitentry where billtype='PAY LATER' and overallpayment='' and accountfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2'  group by accountfullname order by accountfullname desc";
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
			
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$res3labitemrate = "0.00";
		       
		  $query2 = "select * from master_visitentry where billtype='PAY LATER' and overallpayment='' and accountname = '$res21accountnameano' and consultationdate between '$ADate1' and '$ADate2' order by accountfullname desc ";
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
		  $query3 = "select labitemcode from consultation_lab where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res3 = mysqli_fetch_array($exec3))
		  {
		  		$labcode = $res3['labitemcode']; 
				$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
				$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resfx = mysqli_fetch_array($execfx);
				$labrate=$resfx['rateperunit'] * $fxrate;
				if(($planpercentage!=0.00)&&($planforall=='yes'))
			  	{ 
					$labrate = $labrate - ($labrate/100)*$planpercentage;
				}
				$res3labitemrate = $res3labitemrate + $labrate;
		  }
		  
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
		  $query5 = "select radiologyitemcode from consultation_radiology where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res5 = mysqli_fetch_array($exec5))
		  {
		  	$radcode=$res5['radiologyitemcode'];
			
			$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$radrate=$resfx['rateperunit'] * $fxrate;
			if(($planpercentage!=0.00)&&($planforall=='yes'))
			{ 
				$radrate = $radrate - ($radrate/100)*$planpercentage;
			}
			$res5radiologyitemrate = $res5radiologyitemrate + $radrate;
		  }
		  
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
		  
		  $query9 = "select sum(totalamount) as totalamount1 from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and entrydate between '$ADate1' and '$ADate2' ";
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res9 = mysqli_fetch_array($exec9);
		  $res9pharmacyrate = $res9['totalamount1'];
		  
		  if ($res9pharmacyrate == '')
		  {
		  $res9pharmacyrate = '0.00';
		  }
		  else 
		  {
		  $res9pharmacyrate = $res9['totalamount1'];
		  }
		  
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  {
		  	$res9pharmacyrate = $res9pharmacyrate - ($res9pharmacyrate/100)*$planpercentage;
		  }
		  
			$query321 = "select sum(totalamount) as totalamount2 from pharmacysalesreturn_details where visitcode='$res2visitcode' and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
			$exec321 = mysqli_query($GLOBALS["___mysqli_ston"], $query321) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $numpharmacysalereturn=mysqli_num_rows($exec321);
		  $totalpharmacysalesreturn=$totalpharmacysalesreturn+$numpharmacysalereturn;
		  //echo '<br>Total Pharmacy Return '.mysql_num_rows($exec321);
		    $res321 = mysqli_fetch_array($exec321);

		  $res9pharmacyreturnrate = $res321['totalamount2'];
		  if(($planpercentage!=0.00)&&($planforall=='yes'))
		  {
		  	$res9pharmacyreturnrate = $res9pharmacyreturnrate - ($res9pharmacyreturnrate/100)*$planpercentage;
		  }
		  $res9pharmacyrate=$res9pharmacyrate- $res9pharmacyreturnrate;
		  
			$query322 = "select sum(totalamount) as totalrefund from refund_paylater where visitcode='$res2visitcode'";// and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
			$exec322 = mysqli_query($GLOBALS["___mysqli_ston"], $query322) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res322 = mysqli_fetch_array($exec322);
		  $totalrefund = $res322['totalrefund'];
		  
		   $overaltotalrefund=$overaltotalrefund+$totalrefund;
		  
		  
		  
		  $totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate + $overaltotalrefund;
		  $totalamount1 = $totalamount1 + $totalamount;
		  $totalamount2 = $totalamount2 + $res3labitemrate;
		  $totalamount3 = $totalamount3 + $res4servicesitemrate;
		  $totalamount4 = $totalamount4 + $res9pharmacyrate;
		  $totalamount5 = $totalamount5 + $res5radiologyitemrate;
		  $totalamount6 = $totalamount6 + $consultation;
		  $totalamount7 = $totalamount7 + $res6referalrate;
		 // $snocount = $snocount + 1;
		
			
			//echo $cashamount;
			//$colorloopcount = $colorloopcount + 1;
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
				
				//echo $totalamount2;
				$balance=$balance+$totalamount2;
					}
					$balance = round($balance);
					$sumbalance = $sumbalance + $balance + $journal;
					
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
					<tr <?php echo $colorcode; ?> style="display" id="<?php echo $lid; ?>">
					<td colspan="3" align="left" class="bodytext3"><strong><?= $id; ?>
					<a href="ledgerreport.php?group=<?= $parentid; ?>&&ledgerid=<?= $id; ?>&&ledgeranum=<?= $ledgeranum; ?>&&location=<?= $location; ?>&&ADate1=<?= $ADate1; ?>&&ADate2=<?= $ADate2; ?>&&ledger=<?= $accountsmain2; ?>&&cbfrmflag1=cbfrmflag1" target="_blank"><?php echo $colorloopcount; ?>. <?php echo $accountsmain2; ?></a></strong></td>
					<td align="right" class="bodytext3"><strong><?php echo number_format($balance,2,'.',','); ?></strong></td>
					</tr>
				
				</tbody>
				<?php
			}
			?>
		   <!-- <tr bgcolor="#999999">
			<td align="left" class="bodytext3"></td>
			<td colspan="3" align="left" class="bodytext3" style="color:#000000"><strong>Total Opening Balance:</strong></td>
			<td width="114" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($sumopeningbalance,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>-->
			<tr bgcolor="#999999">
			<td align="left" class="bodytext3"></td>
			<td colspan="2" align="left" class="bodytext3" style="color:#000000"><strong>Total Ledger:</strong></td>
			<td width="114" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($sumbalance,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>
			<!--<tr bgcolor="#999999">
			<td align="left" class="bodytext3"></td>
			<td colspan="3" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
			<td width="114" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($totalamount12+$sumopeningbalance,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>-->
</table>
</td>
</tr>

</table>
</table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>
