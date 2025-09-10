<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$customersearch = $_REQUEST["customersearch"];
$location= $_REQUEST["location"];
$consultationdate = date('Y-m-d');
//$customersearch = strtoupper($customersearch);
$searchresult = "";
$availablelimit = "";
  $query2 = "select * from master_customer where customercode = '$customersearch'  order by customername";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	 $customercode = $res2["customercode"];
	 $customername = $res2["customername"];
	$customername = strtoupper($customername);
	
	$patientmiddlename = $res2["customermiddlename"];
	$patientmiddlename = strtoupper($patientmiddlename);

	$patientlastname = $res2["customerlastname"];
	$patientlastname = strtoupper($patientlastname);
	
    $maintype = $res2['maintype'];
	$mrdno = $res2['mrdno'];
	$memberno = $res2['memberno'];
	$paymenttype = $res2["paymenttype"];
	
	$subtype = $res2["subtype"];
	$photoavailable = $res2['photoavailable'];
	$inactivestatus = $res2['inactivestatus'];
	$customeroveralllimit = $res2['overalllimit'];
	
    $query4 = "select * from master_paymenttype where auto_number = '$paymenttype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	//$paymenttypeanum = $res4['auto_number'];
	$res4paymenttype = $res4['paymenttype'];
	$res4auto_number = $res4['auto_number'];
	
	
	
	$query4 = "select * from master_subtype where auto_number = '$subtype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	//$subtypeanum = $res4['auto_number'];
	$res4subtype = $res4['subtype'];

	$billtype = $res2["billtype"];
	
	$query39 = "select * from master_company";
	$exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res39 = mysqli_fetch_array($exec39);
	$ipadmissionfees = $res39['ipadmissionfees'];
	$creditipadmissionfees = $res39['creditipadmissionfees'];
	
	if($billtype == 'PAY NOW')
	{
	$admissionfees = $ipadmissionfees;
	}
	else
	{
	$admissionfees = $creditipadmissionfees;
	}
	$gender = $res2["gender"];
	$dateofbirth = $res2["dateofbirth"];
	$todate = date("Y-m-d");
	$diff = abs(strtotime($todate) - strtotime($dateofbirth));
	
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	if($years == 0 && $months == 0)
	{
	$years = $days.' '.'Days';
	}
	if($years == 0 && $months != 0)
	{
	$years = $months.' '.'Months';
	}
	else 
	{
	$years = $years.' '.'Years';
	}
	
	$accountname = $res2["accountname"];
	
	$query4 = "select * from master_accountname where auto_number = '$accountname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	//$accountnameanum = $res4['auto_number'];
	$res4accountname = $res4['accountname'];
	$recordstatus = $res4['recordstatus'];
	$accountexpirydate = $res4["expirydate"];
	$planname = $res2["planname"];
	
	$query5 = "select * from master_planname where auto_number = '$planname'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res5 = mysqli_fetch_array($exec5);
	//$plannameanum = $res4['auto_number'];
	$res4planname = $res5['planname'];
	$res4planstatus = $res5['recordstatus'];
	$res4planfixedamount = $res5['planfixedamount'];
	$res4planpercentage = $res5['planpercentage'];
	$res4smartap = $res5['smartap'];
   echo '==>'. $planapplicable = $res5['planapplicable'];
	
	$planstartdate = $res5["planstartdate"];
	$planexpirydate = $res5["planexpirydate"];
	$visitlimit = $res5["opvisitlimit"];
	
	$overalllimit = $customeroveralllimit;
		
	$consultationfees1=0;
	$cashamount21=0;
	$cardamount21=0;
	$onlineamount21=0;
	$chequeamount21=0;
	$tdsamount21=0;
	$writeoffamount21=0;

	$query55 = "select * from master_billing where patientcode = '$customersearch' and billtype = 'PAY LATER' ";
	$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res55 = mysqli_fetch_array($exec55))
	{
		 $consultationfees = $res55["consultationfees"];
		 $consultationfees1 = $consultationfees1 + $consultationfees;
	}
	
	if($billtype == 'PAY LATER')
	{
	 //$availablelimit = $overalllimit - $consultationfees1;
	 }
	 
	 $query43="select * from billing_paylater where patientcode = '$customersearch' and billstatus = 'unpaid'";
	 $exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	 $num43=mysqli_num_rows($exec43);
	 		if($num43 > 0)
	 {
	 while($res43=mysqli_fetch_array($exec43))
	 {
	 $billnumber = $res43['billno'];

	 $billtotalamount = $res43['totalamount'];
	 $query3 = "select * from master_transactionpaylater where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = '' and transactiondate BETWEEN '".$planstartdate."' AND '".$planexpirydate."'";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res3 = mysqli_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
				    $cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					//echo $cashamount1;
					$cashamount21 = $cashamount21 + $cashamount1;
					
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				 $patientspent = $billtotalamount - $netpayment;
				 
				 	$patientspent=$res2['opdue'];

				 $availablelimit = $overalllimit - $patientspent;
				 if($availablelimit<0){$availablelimit = 0;}
		
	}
	}
	else
	{
	$patientspent = $res2['opdue'];
	$availablelimit = $overalllimit - $patientspent;
	}
	
	if($planapplicable=='1')
	{
		$query88 = "select sum(plandue) as overallplandue from master_customer where planname = '$planname'";
		$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res88 = mysqli_fetch_array($exec88);
		$overallplandue = $res88['overallplandue'];
		$availablelimit = $overalllimit - $overallplandue;	
	}
	else
	{
		$overallplandue = 0;	
	}

	$query5 = "select * from master_visitentry where patientcode = '$customercode' and recordstatus = ''";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowcount5 = mysqli_num_rows($exec5);
	$visitcount = $rowcount5 + 1;
	
	$query51 = "select * from master_visitentry where patientcode = '$customercode' and recordstatus = '' order by auto_number desc limit 0,1";
	$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res51 = mysqli_fetch_array($exec51);
    $lastvisitdate = $res51['consultationdate'];
	
	if($lastvisitdate == '')
	{
	$lastvisitdate = $consultationdate;
	}

	$todaysdatetime = strtotime($consultationdate);
	$lastvisitdatetime = strtotime($lastvisitdate);
	$datediff = $todaysdatetime - $lastvisitdatetime;
	$visitdays = floor($datediff/(60*60*24));
	
	
	
	 $query66 = "select * from master_consultationtype where  department = '1'  and recordstatus = '' limit 1";
	$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res66 = mysqli_fetch_array($exec66))
	{
	 $paymenttypeanum = $res66['auto_number'];
	$res66consultationtype = $res66['consultationtype'];
	
	if ($searchresult == '')
	{
		$searchresult = ''.$customercode.'#'.$customername.'#'.$patientmiddlename.'#'.$patientlastname.'#'.$paymenttype.'#'.$subtype.'#'.$billtype.'#'.$accountname.'#'.$accountexpirydate.'#'.$planname.'#'.$planexpirydate.'#'.$visitlimit.'#'.$overalllimit.'#'.$res4paymenttype.'#'.$res4subtype.'#'.$res4accountname.'#'.$res4planname.'#'.$visitcount.'#'.$res4planfixedamount.'#'.$patientspent.'#'.$res4planpercentage.'#'.$availablelimit.'#'.$years.'#'.$gender.'#'.$recordstatus.'#'.$res66consultationtype.'#'.$paymenttypeanum.'#'.$mrdno.'#'.$admissionfees.'#'.$lastvisitdate.'#'.$visitdays.'#'.$res4planstatus.'#'.$res4smartap.'#'.$photoavailable.'#'.$inactivestatus.'#'.$memberno.'#'.$overallplandue.'';
	}
	else
	{
		$searchresult = $searchresult.'#^#'.$customercode.'#'.$customername.'#'.$patientmiddlename.'#'.$patientlastname.'#'.$maintype.'#'.$subtype.'#'.$billtype.'#'.$accountname.'#'.$accountexpirydate.'#'.$planname.'#'.$planexpirydate.'#'.$visitlimit.'#'.$overalllimit.'#'.$res4paymenttype.'#'.$res4subtype.'#'.$res4accountname.'#'.$res4planname.'#'.$visitcount.'#'.$res4planfixedamount.'#'.$patientspent.'#'.$res4planpercentage.'#'.$availablelimit.'#'.$years.'#'.$gender.'#'.$recordstatus.'#'.$res66consultationtype.'#'.$paymenttypeanum.'#'.$mrdno.'#'.$admissionfees.'#'.$lastvisitdate.'#'.$visitdays.'#'.$res4planstatus.'#'.$res4smartap.'#'.$photoavailable.'#'.$inactivestatus.'#'.$memberno.'#'.$overallplandue.'';
	}
	
}
}
if ($searchresult != '')
{
	echo $searchresult;
}

?>
