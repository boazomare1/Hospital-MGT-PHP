<?php
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
$journal = 0;

if($id != '')
{
	$queryjndr = "SELECT SUM(`debitamount`) as debit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
	$execjndr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjndr) or die ("Error in queryjndr".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resjndr = mysqli_fetch_array($execjndr);
	$jndebit = $resjndr['debit'];
	
	$queryjncr = "SELECT SUM(`creditamount`) as credit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
	$execjncr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjncr) or die ("Error in queryjncr".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resjncr = mysqli_fetch_array($execjncr);
	$jncredit = $resjncr['credit'];
	
	$journal = $jncredit - $jndebit;
	if($id == '04-6010-PI')
	{
	$querypw = "SELECT SUM(`pharmacyfxamount`) as waiver FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'";
	$execpw = mysqli_query($GLOBALS["___mysqli_ston"], $querypw) or die ("Error in querypw".mysqli_error($GLOBALS["___mysqli_ston"]));
	$respw = mysqli_fetch_array($execpw);
	$waiver = $respw['waiver'];
	}
	else
	{
	$waiver = 0;
	}

	$j = 0;
	$crresult = array();
	
	
	$i = 0;
	$drresult = array();
	
	
	$balance = array_sum($crresult) - array_sum($drresult) - $waiver;
	
	
if($id == '04-6009-PI')
{     //ip income lab
$phatotal=0;
$netamount='';
$sno=0;
$totalradiologyitemrate =0;
$totalpharmacysaleamount=0;
$totalquantity = 0;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$ADate1='2015-01-31';
//$ADate2='2015-02-28';
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
$query21 = "select * from master_visitentry where billtype='PAY LATER' and accountfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2' AND visitcode NOT IN (SELECT visitcode FROM billing_paylater) group by accountname order by accountfullname desc";
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
$res3labitemrate = "0.00";

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

$totalamount = $res9pharmacyrate;
$totalamount4 = $totalamount4 + $res9pharmacyrate;

// $snocount = $snocount + 1;

}


}    //op income lab end

//echo $totalamount4;

}
$balance=$balance+$totalamount4;

}

//unfinal
}



$sumbalance = $sumbalance + $balance + $journal;
				
}

?>					
