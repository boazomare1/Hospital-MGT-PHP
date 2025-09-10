<?php //eval(base64_decode(
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$updatedate = date("Y-m-d");
$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	$patientname = $_REQUEST["patientname"];
	$locationcode = $_REQUEST['locationcode'];
	$locationname = $_REQUEST['locationname'];
	$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$query77 = "select * from master_visitentry where visitcode='$visitcode'";
		$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res77 = mysqli_fetch_array($exec77);
		$doctor = $res77['consultingdoctor'];
		$res77doctorcode = $res77['consultingdoctorcode'];
		
		$query78 = "select * from master_doctor where doctorcode='$res77doctorcode'";
		$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res78 = mysqli_fetch_array($exec78);
		$doctorname = $res78['doctorname'];
		$doctorcode = $res78['doctorcode'];
		
		
		$query111 = "select * from billing_paylaterconsultation	 where patientcode = '$patientcode' and visitcode = '$visitcode'";
$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
$res111 = mysqli_fetch_array($exec111);
$res111billno = $res111['billno'];
 $consultationpercentage = $res111['consultation_percentage'];



	$query11 = "select * from master_doctor where doctorcode = '$res77doctorcode'";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$doctorname = $res11['doctorname'];
// $consultationpercentage = $res11['consultation_percentage'];
		
		
	$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paylaterbillprefix = 'Cr.N-';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from refund_paylater order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='Cr.N-'.'1'."-".date('y');
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'Cr.N-' .$maxanum."-".date('y');
	$openingbalance = '0.00';
	//echo $companycode;
}
$billno = $billnumbercode;
	 $accountname= $_REQUEST['accountname'];
	 $accountcode= $_REQUEST['accountcode'];
	 $accountnameano= $_REQUEST['accountnameano'];


	$totalamount=$_REQUEST['grandtotalamount'];
	$grandfxtotalamount=$_REQUEST['grandfxtotalamount'];
	$totalamount=-$totalamount;
	$totalrefundamount = $_REQUEST['grandtotalamount'];
	$totalfxrefundamount = $_REQUEST['grandfxtotalamount'];
	$billdate=$_REQUEST['billdate'];
	$finalizedbillno=$_REQUEST['finalizedbillno'];
	$labcoa = $_REQUEST['labcoa'];
	$radiologycoa = $_REQUEST['radiologycoa'];
	$servicecoa = $_REQUEST['servicecoa'];
	$pharmacycoa = $_REQUEST['pharmacycoa'];
	$referalcoa = $_REQUEST['referalcoa'];
	$fxrate = $_REQUEST['fxrate'];
	$currency = $_REQUEST['currency'];

	// echo '<br>';
		$querynw1 = "SELECT * from billing_paylater where billno='$finalizedbillno' ";
		$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resnw1=mysqli_num_rows($execnw1);
		while($resnw1 = mysqli_fetch_array($execnw1))
		{
		  $accountname = $resnw1['accountname'];
		  $accountcode = $resnw1['accountnameid'];
		 // $patientaccount1 = $resnw1['accountname'];
		// $patientaccountid1 = $resnw1['accountnameid'];
		 $accountnameano = $resnw1['accountnameano'];
		}
		// echo '<br>';

		$query1 = "SELECT * FROM `master_accountname` WHERE `auto_number` = '$accountnameano' ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1 = mysqli_num_rows($exec1);
		$res1 = mysqli_fetch_array($exec1);
		 $paymenttype_num=$res1['paymenttype'];  //paymenttype
		 $patientsubtype=$res1['subtype'];   //subtypeanum

		// echo '<br>';
		$query_subname = "SELECT * FROM `master_subtype` WHERE `auto_number` = '$patientsubtype' ";
		$exec_subname = mysqli_query($GLOBALS["___mysqli_ston"], $query_subname) or die ("Error in query_subname".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_subname = mysqli_fetch_array($exec_subname);
		 $patientsubtype1=$res_subname['subtype'];  //subtype name

		// echo '<br>';
		$query_paymtname = "SELECT * FROM `master_paymenttype` WHERE `auto_number` = '$paymenttype_num' ";
		$exec_paymtname = mysqli_query($GLOBALS["___mysqli_ston"], $query_paymtname) or die ("Error in query_paymtname".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_paymtname = mysqli_fetch_array($exec_paymtname);
		 $patienttype1=$res_paymtname['paymenttype'];  //payment name


$query10 = "select ledger_id from finance_ledger_mapping where auto_number = '6'";
	$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res10 = mysqli_fetch_array($exec10);
	$coa = $res10['ledger_id'];


// patienttype1 // payment name
// patientsubtype1 // subtype name

		// exit();
	
	if(isset($_REQUEST['reffcon']))
	{
		//$sharingamt='0';
	$conrates=$_POST['rates'];
		$confxrates=$_POST['confxrates'];
		$billstatus = 'paid';
		$doctorstatus = 'unpaid';
		
		//if($paymentmode == 'CASH'){$cashamount=$conrates;} else {$cashamount='0';}
	//if($paymentmode == 'ONLINE'){$onlineamount=$conrates;} else {$onlineamount='0';}
	//if($paymentmode == 'CHEQUE'){$chequeamount=$conrates;} else {$chequeamount='0';}
	//if($paymentmode == 'CREDIT CARD'){$ccamount=$conrates;} else {$ccamount='0';}
	//if($paymentmode == 'MPESA'){$creditamount=$conrates;} else {$creditamount='0';}
		if($consultationpercentage>0){
		$sharingamt = ($conrates*$consultationpercentage)/100; 
		}
		else {
		$sharingamt=0;
			
		}
			 $query45con = "INSERT INTO `refund_paylaterconsultation`(`billdate`, `patientcode`, `patientname`, `patientvisitcode`, `consultation`, `accountname`, `billnumber`, `username`, `locationname`, `locationcode`, `ipaddress`, `fxrate`, `fxamount`, `against_refbill`) 
					VALUES ('$updatedate','$patientcode','$patientname','$visitcode','$conrates','$accountname','$billno','$username','$locationcode','$locationname','$ipaddress','$fxrate','$confxrates','$res111billno')";			   
			$exec45con = mysqli_query($GLOBALS["___mysqli_ston"], $query45con) or die("query45con".mysqli_error($GLOBALS["___mysqli_ston"]));	

		  $query23 = "insert into billing_ipprivatedoctor_refund(docno, patientname, patientcode, visitcode, accountname, description, doccoa, coa, quantity, rate, amount, recordtime, recorddate, username, billstatus, doctorstatus, billtype, locationname, locationcode, transactionamount, cashamount, chequeamount, cardamount, onlineamount, creditamount, transactionmode, rateuhx, amountuhx, doctorcode, doctorname, visittype, original_amt, percentage, sharingamount, against_refbill)
		VALUES ('$billno', '$patientname', '$patientcode', '$visitcode', '$accountname','$doctorname','$doctorcode', '$coa', '1', '$sharingamt', '$sharingamt', '$timeonly', '$dateonly', '$username', '$billstatus', '$doctorstatus', 'PAY LATER', '$locationname', '$locationcode', '$sharingamt', '$conrates', '', '', '', '', 'CASH', '$sharingamt', '$sharingamt', '$doctorcode', '$doctorname', 'OP', '$conrates', '$consultationpercentage', '$sharingamt','$res111billno')";
	   $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			
	}
		 
		 foreach($_POST['lab'] as $key => $value)
		{
		$labname=$_POST['lab'][$key];
		$lserial=$_POST['lserialnumber'][$key];
		$labcode=$_POST['labcode1'][$key];

		if($labcode==''){
				$labquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_lab where itemname='$labname'");
				$execlab=mysqli_fetch_array($labquery);
				$labcode=$execlab['itemcode'];
			}
	    $labrate=$_POST['labrate'][$key];
		$labfxrate=$_POST['labfxrate'][$key];
		$labfxamount=$_POST['labfxamount'][$key];
		foreach($_POST['lref'] as $check1)
		{
		$refund=$check1;
		if($refund == $lserial)
	{
	$query45 = "insert into refund_paylaterlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,billnumber,username,labcoa,locationcode,locationname,currency,exchrate,fxrate,fxamount)values
	           ('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$updatedate','$billno','$username','$labcoa','$locationcode','$locationname','$currency','$fxrate','$labfxrate','$labfxamount')";
	$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die("query45".mysqli_error($GLOBALS["___mysqli_ston"]));		   
	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set labrefund='refund' where patientvisitcode='$visitcode' and labitemcode='$labcode'");
	}
	}
	}

	foreach($_POST['rad'] as $key => $value)
		{
		$radname=$_POST['rad'][$key];
		$radserial=$_POST['rserialnumber'][$key];
		$radiologycode=$_POST['radiologyitemcode204'][$key];

		if($radiologycode==''){
				$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_radiology where itemname='$radname'");
				$execradiology=mysqli_fetch_array($radiologyquery);
				$radiologycode=$execradiology['itemcode'];
			}
		$radiologyrate=$_POST['radrate'][$key];
		$radfxrate = $_POST['radfxrate'][$key];
		$radfxamount = $_POST['radfxamount'][$key];
		foreach($_POST['rref'] as $check2)
		{
		$refund2=$check2;
			if($refund2 == $radserial)
	{
	$query46 = "insert into refund_paylaterradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,billnumber,username,radiologycoa,locationcode,locationname,currency,exchrate,fxrate,fxamount)values
	           ('$patientcode','$patientname','$visitcode','$radiologycode','$radname','$radiologyrate','$accountname','$updatedate','$billno','$username','$radiologycoa','$locationcode','$locationname','$currency','$fxrate','$radfxrate','$radfxamount')";
	$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("query46".mysqli_error($GLOBALS["___mysqli_ston"]));		   
	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set radiologyrefund='refund' where patientvisitcode='$visitcode' and radiologyitemname='$radname'");
	}
	}
	}

	foreach($_POST['pharm'] as $key => $value)
		{
		$pharmname=$_POST['pharm'][$key];
		$medicinecode=$_POST['medicinecode'][$key];
		$pharserial=$_POST['pserialnumber'][$key];
		$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from pharmacysalesreturn_details where itemcode='$medicinecode' and visitcode = '$visitcode' and patientcode = '$patientcode'");
		// $radiologyquery=mysql_query("select * from pharmacysalesreturn_details where itemname='$pharmname' and visitcode = '$visitcode' and patientcode = '$patientcode'");
		$resradiology=mysqli_fetch_array($radiologyquery);

		$pharmitemcode=$resradiology['itemcode'];
		$ledgercode=$resradiology['ledgercode'];
		$ledgername=$resradiology['ledgername'];
		$incomeledgername=$resradiology['incomeledger'];
		$incomeledgercode=$resradiology['incomeledgercode'];

		$pharmitemrate=$_POST['pharmrate'][$key];
		$pharmqty=$_POST['pharmrefundqty'][$key];
		$pharmamt=$_POST['pharmtotal'][$key];
		$pharmfxrate = $_POST['pharmfxrate'][$key];
		$pharmfxamount = $_POST['pharmfxamount'][$key];

		foreach($_POST['pref'] as $check8)
		{
		$refund8=$check8;	
			if($refund8 == $pharserial)
	{
	$query46 = "insert into refund_paylaterpharmacy(patientcode,patientname,patientvisitcode,medicinecode,medicinename,quantity,rate,amount,accountname,billdate,billnumber,username,pharmacycoa,locationcode,locationname,ledgercode,ledgername,incomeledgercode,incomeledger) values
	           ('$patientcode','$patientname','$visitcode','$pharmitemcode','$pharmname','$pharmqty','$pharmitemrate','$pharmamt','$accountname','$updatedate','$billno','$username','$pharmacycoa','$locationcode','$locationname','$ledgercode','$ledgername','$incomeledgercode','$incomeledgername')";
	$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("query46".mysqli_error($GLOBALS["___mysqli_ston"]));		   
	// mysql_query("update consultation_radiology set radiologyrefund='refund' where patientvisitcode='$visitcode' and radiologyitemname='$radname'");
	}
	}
	}

	foreach($_POST['ser'] as $key => $value)
		{
		$sername=$_POST['ser'][$key];
		$servicescode=$_POST['sercode'][$key];
		$serserial=$_POST['sserialnumber'][$key];

		if($servicescode==''){
				$servicequery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_services where itemname='$sername'");
				$execservice=mysqli_fetch_array($servicequery);
				$servicescode=$execservice['itemcode'];
			}

		$servicesrate=$_POST['servicerate'][$key];
	    $serviceqty = $_POST['refundserqty'][$key];
		$serviceamt = $_POST['refseramt'][$key];
		$serfxrate = $_POST['serfxrate'][$key];
		$serfxamount = $_POST['serfxamount'][$key];
		foreach($_POST['sref'] as $check3)
		{
		$refund3=$check3;
			if($refund3 == $serserial)
	{
	 $query47 = "insert into refund_paylaterservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber,username,servicecoa, servicesitemqty, amount,locationcode,locationname,currency,exchrate,fxrate,fxamount)values
	           ('$patientcode','$patientname','$visitcode','$servicescode','$sername','$servicesrate','$accountname','$updatedate','$billno','$username','$servicecoa','$serviceqty','$serviceamt','$locationcode','$locationname','$currency','$fxrate','$serfxrate','$serfxamount')";
	$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die("query47".mysqli_error($GLOBALS["___mysqli_ston"]));	
	
	$query89 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode = '$patientcode' and servicesitemname='$sername'";
	$exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res89 = mysqli_fetch_array($exec89);	
	$refundqty89 = $res89['refundquantity'];  
	
	$refundqty = $refundqty89 + $serviceqty;
	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set refundquantity='$refundqty' where patientvisitcode='$visitcode' and servicesitemname='$sername'");
	}
	}
	}
	foreach($_POST['referalname'] as $key => $value)
		{
		$referalname=$_POST['referalname'][$key];
		$referalserial=$_POST['ref_serialnumber'][$key];
		$referalcode=$_POST['referalcode'][$key];
		$consultationpercentage=$_POST['refconsultation_percentage'][$key];

		if($referalcode==''){
				$referalquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_doctor where doctorname='$referalname'");
				$execreferal=mysqli_fetch_array($referalquery);
				$referalcode=$execreferal['doctorcode'];
				// $consultationpercentage = $execreferal['consultation_percentage'];
			}

		$referalrate=$_POST['referalrate'][$key];
		$reffxrate = $_POST['reffxrate'][$key];
		$reffxamount = $_POST['reffxamount'][$key];
		foreach($_POST['ref_ref'] as $check4)
		{
		$refund4=$check4;
			if($refund4 == $referalserial)
	{
		
		$billstatus = 'paid';
		$doctorstatus = 'unpaid';
		
		if($consultationpercentage>0){
		$sharingamt = ($reffxamount*$consultationpercentage)/100; 
		}
		else {
		$sharingamt=0;
			
		}
		
		
	 $query47 = "insert into refund_paylaterreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,billnumber,username,referalcoa,locationcode,locationname,currency,exchrate,fxrate,fxamount,against_refbill)values
	           ('$patientcode','$patientname','$visitcode','$referalcode','$referalname','$referalrate','$accountname','$updatedate','$billno','$username','$referalcoa','$locationcode','$locationname','$currency','$fxrate','$reffxrate','$reffxamount','$res111billno')";
	$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die("".mysqli_error($GLOBALS["___mysqli_ston"]));		   
	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_referal set referalrefund='refund' where patientvisitcode='$visitcode' and referalname='$referalname'");
	
	
	  $query23 = "insert into billing_ipprivatedoctor_refund(docno, patientname, patientcode, visitcode, accountname, description, doccoa, coa, quantity, rate, amount, recordtime, recorddate, username, billstatus, doctorstatus, billtype, locationname, locationcode, transactionamount, cashamount, chequeamount, cardamount, onlineamount, creditamount, transactionmode, rateuhx, amountuhx, doctorcode, doctorname, visittype, original_amt, percentage, sharingamount, against_refbill)
		VALUES ('$billno', '$patientname', '$patientcode', '$visitcode', '$accountname','$referalname','$referalcode', '$coa', '1', '$sharingamt', '$sharingamt', '$timeonly', '$dateonly', '$username', '$billstatus', '$doctorstatus', 'PAY LATER', '$locationname', '$locationcode', '$sharingamt', '$referalrate', '', '', '', '', 'CASH', '$sharingamt', '$sharingamt', '$referalcode', '$referalname', 'OP', '$referalrate', '$consultationpercentage', '$sharingamt','$res111billno')";
	   $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}
	}
	}

	foreach($_POST['ambname'] as $key => $value)
		{
		$ambname=$_POST['ambname'][$key];
		//$servicequery=mysql_query("select * from master_services where itemname='$sername'");
		//$execservice=mysql_fetch_array($servicequery);
		//$servicescode=$execservice['itemcode'];
		$ambrate=$_POST['ambrate'][$key];
	    $ambqty = $_POST['refambqty'][$key];
		$ambamt = $_POST['ambamt4'][$key];
		$ambdoc = $_POST['ambdoc'][$key];
		$ambfxrate = $_POST['ambfxrate'][$key];
		$ambfxamount = $_POST['ambfxamount'][$key];
		foreach($_POST['ref'] as $check5)
		{
		$refund5=$check5;
			if($refund5 == $ambname)
	{
	 $query47 = "insert into refund_paylaterambulance(patientcode,patientname,patientvisitcode,docno,description,rate,accountname,billdate,billnumber,username,ambulancecoa,quantity, amount,locationcode,locationname,currency,exchrate,fxrate,fxamount)values
	           ('$patientcode','$patientname','$visitcode','$ambdoc','$ambname','$ambrate','$accountname','$updatedate','$billno','$username','','$ambqty','$ambamt','$locationcode','$locationname','$currency','$fxrate','$ambfxrate','$ambfxamount')";
	$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
	
	}
	}
	}
	
	foreach($_POST['homename'] as $key => $value)
		{
		$homename=$_POST['homename'][$key];
		//$servicequery=mysql_query("select * from master_services where itemname='$sername'");
		//$execservice=mysql_fetch_array($servicequery);
		//$servicescode=$execservice['itemcode'];
		$homerate=$_POST['homerate'][$key];
	    $homeqty = $_POST['refhomeqty'][$key];
		$homeamt = $_POST['homeamt4'][$key];
		$homefxrate = $_POST['homefxrate'][$key];
		$homefxamount = $_POST['homefxamount'][$key];
		$homedoc = $_POST['homedoc'][$key];
		foreach($_POST['ref'] as $check6)
		{
		$refund6=$check6;
			if($refund6 == $homename)
	{
	 $query47 = "insert into refund_paylaterhomecare(patientcode,patientname,patientvisitcode,docno,description,rate,accountname,billdate,billnumber,username,homecarecoa,quantity, amount,locationcode,locationname,currency,exchrate,fxrate,fxamount)values
	           ('$patientcode','$patientname','$visitcode','$homedoc','$homename','$homerate','$accountname','$updatedate','$billno','$username','','$homeqty','$homeamt','$locationcode','$locationname','$currency','$fxrate','$homefxrate','$homefxamount')";
	$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die("query47".mysqli_error($GLOBALS["___mysqli_ston"]));	
	
	}
	}
	}
	$finamount = abs($totalamount);
			mysqli_query($GLOBALS["___mysqli_ston"], "insert into refund_paylater(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,referalname,doctorstatus,finalizationbillno,locationcode,locationname,accountcode,finamount,currency,exchrate,fxrate,fxamount,accountnameano,accountnameid)values('$billno','$patientname','$patientcode','$visitcode','$totalamount','$billdate','$accountname','$referalname','unpaid','$finalizedbillno','$locationcode','$locationname','$accountcode','$finamount','$currency','$fxrate','$totalfxrefundamount','$totalfxrefundamount','$accountnameano','$accountcode')") or die("refund_paylater".mysqli_error($GLOBALS["___mysqli_ston"]));
	


	$query83="INSERT into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,docno,ipaddress,companyanum,companyname,financialyear,transactiontype,paymenttype,subtype,transactionamount,receivableamount,doctorname,locationcode,locationname,currency,exchrate,fxrate,fxamount,accountnameano,accountnameid,accountcode,subtypeano)values('$patientname',
	          '$patientcode','$visitcode','$dateonly','$accountname','$billno','$ipaddress','$companyanum','$companyname','$financialyear','paylatercredit','$patienttype1','$patientsubtype1','$totalrefundamount','$totalrefundamount','$doctorname','$locationcode','$locationname','$currency','$fxrate','$totalfxrefundamount','$totalfxrefundamount','$accountnameano','$accountcode','$accountcode','$patientsubtype')";
	$exec83=mysqli_query($GLOBALS["___mysqli_ston"], $query83) or die("error in query83".mysqli_error($GLOBALS["___mysqli_ston"]));	



		

	///////////////////// FOR ALLOCATION //////////////////////////////
// $billnumbercode=$billnumbercode;

$query2 = "SELECT billbalanceamount,accountnameano from master_transactionpaylater where billnumber='$finalizedbillno' and accountcode = '$accountcode' and transactionstatus <> 'onaccount' and acc_flag = '0'  and transactiontype not in ('pharmacycredit','paylatercredit') and recordstatus<>'deallocated'  order by transactiondate ASC";
// and transactiondate between '$ADate1' and '$ADate2' and transactionmode <> 'CREDIT NOTE'
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowcount21 = $rowcount21 + $rowcount2 = mysqli_num_rows($exec2);
while ($res2 = mysqli_fetch_array($exec2)){
	$balamount1 = $res2['billbalanceamount'];
	$accountnameano = $res2['accountnameano'];
}

$query9912="update master_transactionpaylater set acc_flag='1' where billnumber='$finalizedbillno' and transactiontype='finalize' ";
$exec9912=mysqli_query($GLOBALS["___mysqli_ston"], $query9912);



$billnumberprefix = '';
$billnumber = '';
$billanum = '';
$balanceamount = '';
$remarks = '';
$transactionmodule = '';
// $doctorname = '';
$discount = '';


 

$balamount = $balamount1-$totalrefundamount;

$capitation_check=0;
$query_billno = "select capitation,totalamount from billing_paylater where billno='$finalizedbillno'";
$exec_billno = mysqli_query($GLOBALS["___mysqli_ston"], $query_billno) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num_billno=mysqli_num_rows($exec_billno);
while($res_billno = mysqli_fetch_array($exec_billno))
{
  $capitation_check=$res_billno['capitation'];
  
  if($capitation_check==1){
   $balamount = 0;
   $totalrefundamount = $res_billno['totalamount'];
  }


}

if($balamount == 0.00){ 
	$billstatus='paid'; 
	}else{ 
	$billstatus='unpaid';
	}




$query87 ="select * from master_transactionpaylater where billnumber='$finalizedbillno' and transactiontype='PAYMENT' and docno='$billnumbercode' and recordstatus = 'allocated'";
		$exec87 = mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num87 = mysqli_num_rows($exec87);

		if($num87 == 0)
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT NOTE';
		$particulars = 'BY CREDIT NOTE '.$billnumberprefix.$billnumber;		
	
		$query9 = "INSERT into master_transactionpaylater (transactiondate, transactiontime, particulars,  
		transactionmode, transactiontype, transactionamount, writeoffamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount,discount) 
		values ('$dateonly','$timeonly', '$particulars',
		'$transactionmode', '$transactiontype', '$totalrefundamount', '$totalrefundamount', 
		'$finalizedbillno',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$billno','$balamount','allocated','$totalrefundamount','$patienttype1','$patientsubtype1','$username','$accountnameano','$accountcode','$locationcode','$locationname','$patientsubtype','$accountcode','$currency','1','$totalrefundamount','$discount')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
				// }
			// }
		}
		/////////////////////////////////////////////////////////////////////////////////////////////////


		header("location:paylaterrefundlist.php?patientcode=".$patientcode."&&visitcode=".$visitcode."&&billnumber=".$billno."");
		exit();
}
//to redirect if there is no entry in masters category or item or customer or settings
//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{
$radiologyname=$_REQUEST['delete'];
mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_radiology where radiologyitemname='$radiologyname'");
}
//$defaulttax = $_REQUEST["defaulttax"];
if ($defaulttax == '')
{
	$_SESSION["defaulttax"] = '';
}
else
{
	$_SESSION["defaulttax"] = $defaulttax;
}
if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}
//This include updatation takes too long to load for hunge items database.
//To populate the autocompetelist_services1.js
//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77["allowed"];
/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());
$res99 = mysql_fetch_array($exec99);
$res99cntanum = $res99["cntanum"];
$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.
if ($totalbillandquote > $res77allowed)
{
	//header ("location:usagelimit1.php"); // redirecting.
	//exit;
}
*/
//To Edit Bill
if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
//$delbillst = $_REQUEST["delbillst"];
if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }
//$delbillautonumber = $_REQUEST["delbillautonumber"];
if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }
//$delbillnumber = $_REQUEST["delbillnumber"];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}
if ($st == '1' && $banum != '')
{
	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}
if ($delbillst == "" && $delbillnumber == "")
{
	$res41customername = "";
	$res41customercode = "";
	$res41tinnumber = "";
	$res41cstnumber = "";
	$res41address1 = "";
	$res41deliveryaddress = "";
	$res41area = "";
	$res41city = "";
	$res41pincode = "";
	$res41billdate = "";
	$billnumberprefix = "";
	$billnumberpostfix = "";
}
 ?>
<?php 

$Querylab=mysqli_query($GLOBALS["___mysqli_ston"],"select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];

$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"],"select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"],"select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$patientplan=$execlab['planname'];
$queryplan=mysqli_query($GLOBALS["___mysqli_ston"],"select * from master_planname where auto_number='$patientplan'");
$execplan=mysqli_fetch_array($queryplan);
$patientplan1=$execplan['planname'];



?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];
$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];
$patientaccountid1=$execlab2['id'];
$accountnameano=$execlab2['auto_number'];
$query76 = "select * from master_financialintegration where field='labpaylaterrefund'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$labcoa = $res76['code'];
$query761 = "select * from master_financialintegration where field='radiologypaylaterrefund'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res761 = mysqli_fetch_array($exec761);
$radiologycoa = $res761['code'];
$query762 = "select * from master_financialintegration where field='servicepaylaterrefund'";
$exec762 = mysqli_query($GLOBALS["___mysqli_ston"], $query762) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res762 = mysqli_fetch_array($exec762);
$servicecoa = $res762['code'];
$query763 = "select * from master_financialintegration where field='referalpaylaterrefund'";
$exec763 = mysqli_query($GLOBALS["___mysqli_ston"], $query763) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res763 = mysqli_fetch_array($exec763);
$referalcoa = $res763['code'];
$query764 = "select * from master_financialintegration where field='pharmacypaylaterrefund'";
$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res764 = mysqli_fetch_array($exec764);
$pharmacycoa = $res764['code'];
?>
<?php 
$query54="select * from billing_paylater where patientcode='$patientcode' and visitcode='$visitcode'";
$exec54=mysqli_query($GLOBALS["___mysqli_ston"],$query54) or die(mysql_error());
$res54=mysqli_fetch_array($exec54);
$finalizedbillnumber=$res54['billno'];

?>
<?php 
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paylaterbillprefix = 'Cr.N-';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from refund_paylater order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='Cr.N-'.'1'."-".date('y');
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'Cr.N-' .$maxanum."-".date('y');
	$openingbalance = '0.00';
	//echo $companycode;
}





 ?>
<script language="javascript">
<?php 
if ($delbillst != 'billedit') // Not in edit mode or other mode.
{
 ?>
	//Function call from billnumber onBlur and Save button click.
	function billvalidation()
	{
		billnovalidation1();
	}
<?php 
}
 ?>
function funcOnLoadBodyFunctionCall()
{
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	
			funcPopupPrintFunctionCall();
			onloadtotals_rad();
			onloadtotals_lab();
		
}
function disableEnterKey()
{
}
function funcPopupPrintFunctionCall()
{
	///*
	//alert ("Auto Print Function Runs Here.");
	<?php 
	if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
	//$src = $_REQUEST["src"];
	if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
	//$st = $_REQUEST["st"];
	if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
	//$previousbillnumber = $_REQUEST["billnumber"];
	if (isset($_REQUEST["billautonumber"])) { $previousbillautonumber = $_REQUEST["billautonumber"]; } else { $previousbillautonumber = ""; }
	//$previousbillautonumber = $_REQUEST["billautonumber"];
	if (isset($_REQUEST["companyanum"])) { $previouscompanyanum = $_REQUEST["companyanum"]; } else { $previouscompanyanum = ""; }
	//$previouscompanyanum = $_REQUEST["companyanum"];
	if ($src == 'frm1submit1' && $st == 'success')
	{
	$query1print = "select * from master_printer where defaultstatus = 'default' and status <> 'deleted'";
	$exec1print = mysqli_query($GLOBALS["___mysqli_ston"], $query1print) or die ("Error in Query1print.".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1print = mysqli_fetch_array($exec1print);
	$papersize = $res1print["papersize"];
	$paperanum = $res1print["auto_number"];
	$printdefaultstatus = $res1print["defaultstatus"];
	if ($paperanum == '1') //For 40 Column paper
	{
	 ?>
		//quickprintbill1();
		quickprintbill1sales();
	<?php 
	}
	else if ($paperanum == '2') //For A4 Size paper
	{
	 ?>
		loadprintpage1('A4');
	<?php 
	}
	else if ($paperanum == '3') //For A4 Size paper
	{
	 ?>
		loadprintpage1('A5');
	<?php 
	}
	}
	 ?>
	//*/
}
//Print() is at bottom of this page.
</script>
<?php eval(base64_decode('IGluY2x1ZGUgKCJqcy9zYWxlczFzY3JpcHRpbmcxLnBocCIpOyA=')); ?>
<script type="text/javascript">
function loadprintpage1(varPaperSizeCatch)
{
	//var varBillNumber = document.getElementById("billnumber").value;
	var varPaperSize = varPaperSizeCatch;
	//alert (varPaperSize);
	//return false;
	<?php 
	//To previous js error if empty. 
	if ($previousbillnumber == '') 
	{ 
		$previousbillnumber = 1; 
		$previousbillautonumber = 1; 
		$previouscompanyanum = 1; 
	} 
	 ?>
	var varBillNumber = document.getElementById("quickprintbill").value;
	var varBillAutoNumber = "<?php eval(base64_decode('IC8vZWNobyAkcHJldmlvdXNiaWxsYXV0b251bWJlcjsg')); ?>";
	var varBillCompanyAnum = "<?php eval(base64_decode('IGVjaG8gJF9TRVNTSU9OWyJjb21wYW55YW51bSJdOyA=')); ?>";
	if (varBillNumber == "")
	{
		alert ("Bill Number Cannot Be Empty.");//quickprintbill
		document.getElementById("quickprintbill").focus();
		return false;
	}
	
	var varPrintHeader = "INVOICE";
	var varTitleHeader = "ORIGINAL";
	if (varTitleHeader == "")
	{
		alert ("Please Select Print Title.");
		document.getElementById("titleheader").focus();
		return false;
	}
	
	//alert (varBillNumber);
	//alert (varPrintHeader);
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
	if (varPaperSize == "A4")
	{
		window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA4<?php eval(base64_decode('IGVjaG8gJGJhbnVtOyA=')); ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_bill1_a5.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA5<?php eval(base64_decode('IGVjaG8gJGJhbnVtOyA=')); ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
}
function funcDefaultTax1() //Function to CST Taxes if required.
{
	//alert ("Default Tax");
	<?php 
	//delbillst=billedit&&delbillautonumber=13&&delbillnumber=1
	//To avoid change of bill number on edit option after selecting default tax.
	if (isset($_REQUEST["delbillst"])) { $delBillSt = $_REQUEST["delbillst"]; } else { $delBillSt = ""; }
	//$delBillSt = $_REQUEST["delbillst"];
	if (isset($_REQUEST["delbillautonumber"])) { $delBillAutonumber = $_REQUEST["delbillautonumber"]; } else { $delBillAutonumber = ""; }
	//$delBillAutonumber = $_REQUEST["delbillautonumber"];
	if (isset($_REQUEST["delbillnumber"])) { $delBillNumber = $_REQUEST["delbillnumber"]; } else { $delBillNumber = ""; }
	//$delBillNumber = $_REQUEST["delbillnumber"];
	
	 ?>
	var varDefaultTax = document.getElementById("defaulttax").value;
	if (varDefaultTax != "")
	{
		<?php 
		if ($delBillSt == 'billedit')
		{
		 ?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"&&delbillst=<?php eval(base64_decode('IGVjaG8gJGRlbEJpbGxTdDsg')); ?>&&delbillautonumber="+<?php eval(base64_decode('IGVjaG8gJGRlbEJpbGxBdXRvbnVtYmVyOyA=')); ?>+"&&delbillnumber="+<?php eval(base64_decode('IGVjaG8gJGRlbEJpbGxOdW1iZXI7IA==')); ?>+"";
		<?php 
		}
		else
		{
		 ?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"";
		<?php 
		}
		 ?>
	}
	else
	{
		window.location="sales1.php";
	}
	//return false;
}
function updatebox(varSerialNumber,varrate,totalcount)
{
	var varSerialNumber = varSerialNumber;
	var varrate = varrate;
	var totalcount = totalcount;
	//alert(totalcount);
	var grandtotal=0;
	var grandfxtotal=0;
	if(document.getElementById("reff"+varSerialNumber+"").checked == true)
	{
		for(i=1;i<=totalcount;i++)
		{
			if(document.getElementById("reff"+i+"").checked == true)
			{
				var totalamount=document.getElementById("rate"+i+"").value;
				var totalfxamount=document.getElementById("labfxamount"+i+"").value;
				if(totalamount == "")
				{
					totalamount=0;
				}
				if(totalfxamount == "")
				{
					totalfxamount=0;
				}
				
				grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);
				grandfxtotal=parseFloat(grandfxtotal)+parseFloat(totalfxamount);
			}
		}
		document.getElementById("totalamtlab").value=grandtotal.toFixed(2);
		document.getElementById("totalfxamtlab").value=grandfxtotal.toFixed(2);
		var totalamountconsultation=document.getElementById("totalamtconsultation").value;
		var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
		if(totalamountconsultation== "")
		{
			totalamountconsultation=0;
		}
		
		var totalamountlab=document.getElementById("totalamtlab").value;
		if(totalamountlab == "")
		{
			totalamountlab=0;
		}
		//alert(totalamountlab);
		var totalamountrad=document.getElementById("totalamtrad").value;
		if(totalamountrad == "")
		{
			totalamountrad=0;
		}
		//alert(totalamountrad);
		var totalamountser=document.getElementById("totalamtser").value;
		if(totalamountser == "")
		{
			totalamountser=0;
		}
		var totalamountref=document.getElementById("totalamtref").value;
		if(totalamountref == "")
		{
			totalamountref=0;
		}
		//alert(totalamountser);
		var totalamountamb=document.getElementById("totalamtamb").value;
		if(totalamountamb == "")
		{
			totalamountamb=0;
		}
		var totalamounthome=document.getElementById("totalamthome").value;
		if(totalamounthome == "")
		{
			totalamounthome=0;
		}
		var totalamountpharm=document.getElementById("totalamtpharm").value;
		if(totalamountpharm == "")
		{
		totalamountpharm=0;
		}
		//alert(totalamountser);
		// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
		var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
		document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
	
	}
	else
	{
		grandtotal=0;
		for(i=1;i<=totalcount;i++)
		{		
			if(document.getElementById("reff"+i+"").checked == false)
			{
				if(document.getElementById("reff"+i+"").checked == true)
				{
					var totalamount=document.getElementById("rate"+i+"").value;
					var totalfxamount=document.getElementById("labfxamount"+i+"").value;
				}
				else
				{
					var totalamount=0;
					var totalfxamount=0;
				}
				if(totalamount == "")
				{
					totalamount=0;
				}
				if(totalamount == "")
				{
					totalfxamount=0;
				}
				//alert(totalamount);
				grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);
				grandfxtotal=parseFloat(grandfxtotal)+parseFloat(totalfxamount);
			}
			else
			{
				if(document.getElementById("reff"+i+"").checked == true)
				{
					var totalamount=document.getElementById("rate"+i+"").value;
					var totalfxamount=document.getElementById("labfxamount"+i+"").value;
				}
				else
				{
					var totalamount=0;
					var totalfxamount=0;
				}
				if(totalamount == "")
				{
					totalamount=0;
				}
				//alert(totalamount);
				grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);
				grandfxtotal=parseFloat(grandfxtotal)+parseFloat(totalfxamount);
			}
		}
		document.getElementById("totalamtlab").value=grandtotal.toFixed(2);
		document.getElementById("totalfxamtlab").value=grandfxtotal.toFixed(2);
		var totalamountconsultation=document.getElementById("totalamtconsultation").value;
		var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
		if(totalamountconsultation== "")
		{
		totalamountconsultation=0;
		}
		
		var totalamountlab=document.getElementById("totalamtlab").value;
		if(totalamountlab == "")
		{
		totalamountlab=0;
		}
		//alert(totalamountlab);
		var totalamountrad=document.getElementById("totalamtrad").value;
		if(totalamountrad == "")
		{
		totalamountrad=0;
		}
		//alert(totalamountrad);
		var totalamountser=document.getElementById("totalamtser").value;
		if(totalamountser == "")
		{
		totalamountser=0;
		}
		var totalamountref=document.getElementById("totalamtref").value;
		if(totalamountref == "")
		{
		totalamountref=0;
		}
		//alert(totalamountser);
		var totalamountamb=document.getElementById("totalamtamb").value;
		if(totalamountamb == "")
		{
		totalamountamb=0;
		}
		var totalamounthome=document.getElementById("totalamthome").value;
		if(totalamounthome == "")
		{
		totalamounthome=0;
		}
		var totalamountpharm=document.getElementById("totalamtpharm").value;
		if(totalamountpharm == "")
		{
		totalamountpharm=0;
		}
		//alert(totalamountser);
		// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
		var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
		document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
		
	
	}
		var totalfxamtconsultation=document.getElementById("totalfxamtconsultation").value;
		if(totalfxamtconsultation == "")
		{
		totalfxamtconsultation=0;
		}
		var totalfxamtlab=document.getElementById("totalfxamtlab").value;
		if(totalfxamtlab == "")
		{
		totalfxamtlab=0;
		}
		//alert(totalamountlab);
		var totalfxamtrad=document.getElementById("totalfxamtrad").value;
		if(totalfxamtrad == "")
		{
		totalfxamtrad=0;
		}
		//alert(totalamountrad);
		var totalfxamtser=document.getElementById("totalfxamtser").value;
		if(totalfxamtser == "")
		{
		totalfxamtser=0;
		}
		var totalfxamtref=document.getElementById("totalfxamtref").value;
		if(totalfxamtref == "")
		{
		totalfxamtref=0;
		}
		//alert(totalamountser);
		var totalfxamtamb=document.getElementById("totalfxamtamb").value;
		if(totalfxamtamb == "")
		{
		totalfxamtamb=0;
		}
		var totalfxamthome=document.getElementById("totalfxamthome").value;
		if(totalfxamthome == "")
		{
		totalfxamthome=0;
		}
		var totalfxamountpharm=document.getElementById("totalfxamtpharm").value;
		if(totalfxamountpharm == "")
		{
		totalfxamountpharm=0;
		}
		//alert(totalamountser);
		var grandfxtotalamount=parseFloat(totalfxamtconsultation)+parseFloat(totalfxamtlab)+parseFloat(totalfxamtrad)+parseFloat(totalfxamtser)+parseFloat(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseFloat(totalfxamountpharm);
		// var grandfxtotalamount=parseInt(totalfxamtconsultation)+parseInt(totalfxamtlab)+parseInt(totalfxamtrad)+parseInt(totalfxamtser)+parseInt(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseInt(totalfxamountpharm);
		document.getElementById("grandfxtotalamount").value=grandfxtotalamount.toFixed(2);
}
function updatebox1(varSerialNumber1,varrate1,totalcount1)
{
var varSerialNumber1 = varSerialNumber1;
var varrate1 = varrate1;
var totalcount1 = totalcount1;
//alert(totalcount1);
var grandtotal1=0;
var grandfxtotal1=0;
if(document.getElementById("reff1"+varSerialNumber1+"").checked == true)
{
for(i=1;i<=totalcount1;i++)
{
if(document.getElementById("reff1"+i+"").checked == true)
{
//alert('h');
var totalamount1=document.getElementById("rate1"+i+"").value;
var radfxamount=document.getElementById("radfxamount"+i+"").value;
if(totalamount1 == "")
{
totalamount1=0;
}
if(radfxamount == "")
{
radfxamount=0;
}
grandtotal1=parseFloat(grandtotal1)+parseFloat(totalamount1);
grandfxtotal1=parseFloat(grandfxtotal1)+parseFloat(radfxamount);
}
}
document.getElementById("totalamtrad").value=grandtotal1.toFixed(2);
document.getElementById("totalfxamtrad").value=grandfxtotal1.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}
var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
var totalamountpharm=document.getElementById("totalamtpharm").value;
if(totalamountpharm == "")
{
totalamountpharm=0;
}
//alert(totalamountser);
// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
}
else
{
grandtotal1=0;
for(i=1;i<=totalcount1;i++)
{
if(document.getElementById("reff1"+i+"").checked == false)
{
if(document.getElementById("reff1"+i+"").checked == true)
{
var totalamount1=document.getElementById("rate1"+i+"").value;
var radfxamount=document.getElementById("radfxamount"+i+"").value;
}
else
{
var totalamount1=0;
var radfxamount=0;
}
if(totalamount1 == "")
{
totalamount1=0;
}
if(radfxamount == "")
{
radfxamount=0;
}
//alert(totalamount);
grandtotal1=parseFloat(grandtotal1)+parseFloat(totalamount1);
grandfxtotal1=parseFloat(grandfxtotal1)+parseFloat(radfxamount);
}
else
{
if(document.getElementById("reff1"+i+"").checked == true)
{
var totalamount1=document.getElementById("rate1"+i+"").value;
var radfxamount=document.getElementById("radfxamount"+i+"").value;
}
else
{
var totalamount1=0;
var radfxamount=0;
}
if(totalamount1 == "")
{
totalamount1=0;
}
if(radfxamount == "")
{
radfxamount=0;
}
//alert(totalamount);
grandtotal1=parseFloat(grandtotal1)+parseFloat(totalamount1);
grandfxtotal1=parseFloat(grandfxtotal1)+parseFloat(radfxamount);
}
}
document.getElementById("totalamtrad").value=grandtotal1.toFixed(2);
document.getElementById("totalfxamtrad").value=grandfxtotal1.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}
var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
var totalamountpharm=document.getElementById("totalamtpharm").value;
if(totalamountpharm == "")
{
totalamountpharm=0;
}
//alert(totalamountser);
// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
}
		var totalfxamtconsultation=document.getElementById("totalfxamtconsultation").value;
		if(totalfxamtconsultation == "")
		{
		totalfxamtconsultation=0;
		}
		var totalfxamtlab=document.getElementById("totalfxamtlab").value;
		if(totalfxamtlab == "")
		{
		totalfxamtlab=0;
		}
		//alert(totalamountlab);
		var totalfxamtrad=document.getElementById("totalfxamtrad").value;
		if(totalfxamtrad == "")
		{
		totalfxamtrad=0;
		}
		//alert(totalamountrad);
		var totalfxamtser=document.getElementById("totalfxamtser").value;
		if(totalfxamtser == "")
		{
		totalfxamtser=0;
		}
		var totalfxamtref=document.getElementById("totalfxamtref").value;
		if(totalfxamtref == "")
		{
		totalfxamtref=0;
		}
		//alert(totalamountser);
		var totalfxamtamb=document.getElementById("totalfxamtamb").value;
		if(totalfxamtamb == "")
		{
		totalfxamtamb=0;
		}
		var totalfxamthome=document.getElementById("totalfxamthome").value;
		if(totalfxamthome == "")
		{
		totalfxamthome=0;
		}
		var totalfxamountpharm=document.getElementById("totalfxamtpharm").value;
		if(totalfxamountpharm == "")
		{
		totalfxamountpharm=0;
		}
		//alert(totalamountser);
		var grandfxtotalamount=parseFloat(totalfxamtconsultation)+parseFloat(totalfxamtlab)+parseFloat(totalfxamtrad)+parseFloat(totalfxamtser)+parseFloat(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseFloat(totalfxamountpharm);
		// var grandfxtotalamount=parseInt(totalfxamtconsultation)+parseInt(totalfxamtlab)+parseInt(totalfxamtrad)+parseInt(totalfxamtser)+parseInt(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseInt(totalfxamountpharm);
		document.getElementById("grandfxtotalamount").value=grandfxtotalamount.toFixed(2);
}
function updatebox3con()
{
var totalamount3=document.getElementById("rates").value;
//alert(totalamount3);
totalamount3=parseFloat(totalamount3);
document.getElementById("conrate").innerHTML=totalamount3.toFixed(2);
//document.getElementById("totalamtconsultation").value=totalamount3;
var fxrate = document.getElementById("fxrate").value;
var totalamountcon3=parseFloat(totalamount3) * parseFloat(fxrate);
totalamountcon3=parseFloat(totalamountcon3);
document.getElementById("confxrates").value=totalamountcon3.toFixed(2);
//alert(totalamount3);
document.getElementById("conratefx").innerHTML=totalamountcon3.toFixed(2);
//var totalamountcon3=totalamountcon3.replace(/\,/g,'');
//document.getElementById("totalfxamtconsultation").value=totalamountcon3;
document.getElementById("reffcon").checked = false;
updatebox3();
}
function updatebox3()
{
if(document.getElementById("reffcon").checked == true)
{
var totalamount3=document.getElementById("rates").value;
//alert(totalamount3);
//var totalamount3=totalamount3.replace(/\,/g,'');
document.getElementById("totalamtconsultation").value=totalamount3;
var fxrate = document.getElementById("fxrate").value;
var totalamountcon3=parseFloat(totalamount3) * parseFloat(fxrate);
totalamountcon3=parseFloat(totalamountcon3);
document.getElementById("confxrates").value=totalamountcon3.toFixed(2);
//alert(totalamount3);
//var totalamountcon3=totalamountcon3.replace(/\,/g,'');
document.getElementById("totalfxamtconsultation").value=totalamountcon3.toFixed(2);
var totalamountconsultation = document.getElementById("totalamtconsultation").value;
if(totalamountconsultation == '')
{
totalamountconsultation = 0;
}
var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
var totalamountpharm=document.getElementById("totalamtpharm").value;
if(totalamountpharm == "")
{
totalamountpharm=0;
}
//alert(totalamountser);
// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
}
else
{
var totalamount3=0;
document.getElementById("totalamtconsultation").value=totalamount3.toFixed(2);
document.getElementById("totalfxamtconsultation").value=0.00;
var totalamountconsultation = document.getElementById("totalamtconsultation").value;
if(totalamountconsultation == '')
{
totalamountconsultation = 0;
}
var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
var totalamountpharm=document.getElementById("totalamtpharm").value;
if(totalamountpharm == "")
{
totalamountpharm=0;
}
//alert(totalamountser);
// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
}
		var totalfxamtconsultation=document.getElementById("totalfxamtconsultation").value;
		if(totalfxamtconsultation == "")
		{
		totalfxamtconsultation=0;
		}
		
		var totalfxamtlab=document.getElementById("totalfxamtlab").value;
		if(totalfxamtlab == "")
		{
		totalfxamtlab=0;
		}
		//alert(totalamountlab);
		var totalfxamtrad=document.getElementById("totalfxamtrad").value;
		if(totalfxamtrad == "")
		{
		totalfxamtrad=0;
		}
		//alert(totalamountrad);
		var totalfxamtser=document.getElementById("totalfxamtser").value;
		if(totalfxamtser == "")
		{
		totalfxamtser=0;
		}
		var totalfxamtref=document.getElementById("totalfxamtref").value;
		if(totalfxamtref == "")
		{
		totalfxamtref=0;
		}
		//alert(totalamountser);
		var totalfxamtamb=document.getElementById("totalfxamtamb").value;
		if(totalfxamtamb == "")
		{
		totalfxamtamb=0;
		}
		var totalfxamthome=document.getElementById("totalfxamthome").value;
		if(totalfxamthome == "")
		{
		totalfxamthome=0;
		}
		var totalfxamountpharm=document.getElementById("totalfxamtpharm").value;
		if(totalfxamountpharm == "")
		{
		totalfxamountpharm=0;
		}
		//alert(totalamountser);
		var grandfxtotalamount=parseFloat(totalfxamtconsultation)+parseFloat(totalfxamtlab)+parseFloat(totalfxamtrad)+parseFloat(totalfxamtser)+parseFloat(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseFloat(totalfxamountpharm);
		// var grandfxtotalamount=parseInt(totalfxamtconsultation)+parseInt(totalfxamtlab)+parseInt(totalfxamtrad)+parseInt(totalfxamtser)+parseInt(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseInt(totalfxamountpharm);
		document.getElementById("grandfxtotalamount").value=grandfxtotalamount.toFixed(2);
}
function updatebox2(varSerialNumber2,varrate2,totalcount2)
{
	var grandtotal2 = 0;
	var grandfxtotal2 = 0;
	for(var i=1;i<=totalcount2;i++)
	{
		//alert(i);
		if(document.getElementById("reff2"+i)!= null)
		{
			if(document.getElementById("reff2"+i).checked  == true)
			{
				var refseramt = document.getElementById("refseramt"+i+"").value;
				var serfxamount = document.getElementById("serfxamount"+i+"").value;
				//var totalamount2=document.getElementById("rate2"+i+"").value;
				var totalamount2=parseFloat(refseramt);
				
				if(totalamount2 == "")
				{
					totalamount2=0;
				}
				if(serfxamount == "")
				{
					serfxamount=0;
				}
				grandtotal2=parseFloat(grandtotal2)+parseFloat(totalamount2);
				grandfxtotal2=parseFloat(grandfxtotal2)+parseFloat(serfxamount);
			}
			//alert(grandtotal2);
			document.getElementById("totalamtser").value=grandtotal2.toFixed(2);
			document.getElementById("totalfxamtser").value=grandfxtotal2.toFixed(2);
			var totalamountconsultation=document.getElementById("totalamtconsultation").value;
			var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
			if(totalamountconsultation== "")
			{
			totalamountconsultation=0;
			}
			
			var totalamountlab=document.getElementById("totalamtlab").value;
			if(totalamountlab == "")
			{
			totalamountlab=0;
			}
			//alert(totalamountlab);
			var totalamountrad=document.getElementById("totalamtrad").value;
			if(totalamountrad == "")
			{
			totalamountrad=0;
			}
			//alert(totalamountrad);
			var totalamountser=document.getElementById("totalamtser").value;
			if(totalamountser == "")
			{
			totalamountser=0;
			}
			var totalamountref=document.getElementById("totalamtref").value;
			if(totalamountref == "")
			{
			totalamountref=0;
			}
			var totalamountamb=document.getElementById("totalamtamb").value;
			if(totalamountamb == "")
			{
			totalamountamb=0;
			}
			var totalamounthome=document.getElementById("totalamthome").value;
			if(totalamounthome == "")
			{
			totalamounthome=0;
			}
			var totalamountpharm=document.getElementById("totalamtpharm").value;
			if(totalamountpharm == "")
			{
			totalamountpharm=0;
			}
			//alert(totalamountser);
			// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
			var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
			document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
		}
	}
	
		var totalfxamtconsultation=document.getElementById("totalfxamtconsultation").value;
		if(totalfxamtconsultation == "")
		{
		totalfxamtconsultation=0;
		}
		var totalfxamtlab=document.getElementById("totalfxamtlab").value;
		if(totalfxamtlab == "")
		{
		totalfxamtlab=0;
		}
		//alert(totalamountlab);
		var totalfxamtrad=document.getElementById("totalfxamtrad").value;
		if(totalfxamtrad == "")
		{
		totalfxamtrad=0;
		}
		//alert(totalamountrad);
		var totalfxamtser=document.getElementById("totalfxamtser").value;
		if(totalfxamtser == "")
		{
		totalfxamtser=0;
		}
		var totalfxamtref=document.getElementById("totalfxamtref").value;
		if(totalfxamtref == "")
		{
		totalfxamtref=0;
		}
		//alert(totalamountser);
		var totalfxamtamb=document.getElementById("totalfxamtamb").value;
		if(totalfxamtamb == "")
		{
		totalfxamtamb=0;
		}
		var totalfxamthome=document.getElementById("totalfxamthome").value;
		if(totalfxamthome == "")
		{
		totalfxamthome=0;
		}
		var totalfxamountpharm=document.getElementById("totalfxamtpharm").value;
		if(totalfxamountpharm == "")
		{
		totalfxamountpharm=0;
		}
		//alert(totalamountser);
		var grandfxtotalamount=parseFloat(totalfxamtconsultation)+parseFloat(totalfxamtlab)+parseFloat(totalfxamtrad)+parseFloat(totalfxamtser)+parseFloat(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseFloat(totalfxamountpharm);
		// var grandfxtotalamount=parseInt(totalfxamtconsultation)+parseInt(totalfxamtlab)+parseInt(totalfxamtrad)+parseInt(totalfxamtser)+parseInt(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseInt(totalfxamountpharm);
		document.getElementById("grandfxtotalamount").value=grandfxtotalamount.toFixed(2);
}
function updatebox4(varSerialNumber4,varrate4,totalcount4)
{
var varSerialNumber4 = varSerialNumber4;
var varrate4 = varrate4;
var totalcount4 = totalcount4;
//alert(totalcount1);
var grandtotal4=0;
var grandfxtotal4=0;
if(document.getElementById("reff4"+varSerialNumber4+"").checked == true)
{
for(i=1;i<=totalcount4;i++)
{
if(document.getElementById("reff4"+i+"").checked == true)
{
//alert('h');
var totalamount4=document.getElementById("rate4"+i+"").value;
var reffxamount=document.getElementById("reffxamount"+i+"").value;
if(totalamount4 == "")
{
totalamount4=0;
}
if(reffxamount == "")
{
reffxamount=0;
}
grandtotal4=parseFloat(grandtotal4)+parseFloat(totalamount4);
grandfxtotal4=parseFloat(grandfxtotal4)+parseFloat(reffxamount);
}
}
document.getElementById("totalamtref").value=grandtotal4.toFixed(2);
document.getElementById("totalfxamtref").value=grandfxtotal4.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}
var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
var totalamountpharm=document.getElementById("totalamtpharm").value;
if(totalamountpharm == "")
{
totalamountpharm=0;
}
//alert(totalamountser);
// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
}
else
{
grandtotal4=0;
for(i=1;i<=totalcount4;i++)
{
if(document.getElementById("reff4"+i+"").checked == false)
{
if(document.getElementById("reff4"+i+"").checked == true)
{
var totalamount4=document.getElementById("rate4"+i+"").value;
var reffxamount=document.getElementById("reffxamount"+i+"").value;
}
else
{
var totalamount4=0;
var reffxamount=0;
}
if(totalamount4 == "")
{
totalamount4=0;
}
if(reffxamount == "")
{
reffxamount=0;
}
//alert(totalamount);
grandtotal4=parseFloat(grandtotal4)+parseFloat(totalamount4);
}
else
{
if(document.getElementById("reff4"+i+"").checked == true)
{
var totalamount4=document.getElementById("rate4"+i+"").value;
var reffxamount=document.getElementById("reffxamount"+i+"").value;
}
else
{
var totalamount4=0;
var reffxamount=0;
}
if(totalamount4 == "")
{
totalamount4=0;
}
if(reffxamount == "")
{
reffxamount=0;
}
//alert(totalamount);
grandtotal4=parseFloat(grandtotal4)+parseFloat(totalamount4);
grandfxtotal4=parseFloat(grandfxtotal4)+parseFloat(reffxamount);
}
}
document.getElementById("totalamtref").value=grandtotal4.toFixed(2);
document.getElementById("totalfxamtref").value=grandfxtotal4.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}
var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
var totalamountpharm=document.getElementById("totalamtpharm").value;
if(totalamountpharm == "")
{
totalamountpharm=0;
}
//alert(totalamountser);
// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
}
		var totalfxamtconsultation=document.getElementById("totalfxamtconsultation").value;
		if(totalfxamtconsultation == "")
		{
		totalfxamtconsultation=0;
		}
var totalfxamtlab=document.getElementById("totalfxamtlab").value;
		if(totalfxamtlab == "")
		{
		totalfxamtlab=0;
		}
		//alert(totalamountlab);
		var totalfxamtrad=document.getElementById("totalfxamtrad").value;
		if(totalfxamtrad == "")
		{
		totalfxamtrad=0;
		}
		//alert(totalamountrad);
		var totalfxamtser=document.getElementById("totalfxamtser").value;
		if(totalfxamtser == "")
		{
		totalfxamtser=0;
		}
		var totalfxamtref=document.getElementById("totalfxamtref").value;
		if(totalfxamtref == "")
		{
		totalfxamtref=0;
		}
		//alert(totalamountser);
		var totalfxamtamb=document.getElementById("totalfxamtamb").value;
		if(totalfxamtamb == "")
		{
		totalfxamtamb=0;
		}
		var totalfxamthome=document.getElementById("totalfxamthome").value;
		if(totalfxamthome == "")
		{
		totalfxamthome=0;
		}
		var totalfxamountpharm=document.getElementById("totalfxamtpharm").value;
		if(totalfxamountpharm == "")
		{
		totalfxamountpharm=0;
		}
		//alert(totalamountser);
		// var grandfxtotalamount=parseInt(totalfxamtconsultation)+parseInt(totalfxamtlab)+parseInt(totalfxamtrad)+parseInt(totalfxamtser)+parseInt(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseInt(totalfxamountpharm);
		var grandfxtotalamount=parseFloat(totalfxamtconsultation)+parseFloat(totalfxamtlab)+parseFloat(totalfxamtrad)+parseFloat(totalfxamtser)+parseFloat(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseFloat(totalfxamountpharm);
		document.getElementById("grandfxtotalamount").value=grandfxtotalamount.toFixed(2);
}

function updatebox4(varSerialNumber4,varrate4,totalcount4)
{
var varSerialNumber4 = varSerialNumber4;
var varrate4 = varrate4;
var totalcount4 = totalcount4;
//alert(totalcount1);
var grandtotal4=0;
var grandfxtotal4=0;
if(document.getElementById("reff4"+varSerialNumber4+"").checked == true)
{
for(i=1;i<=totalcount4;i++)
{
if(document.getElementById("reff4"+i+"").checked == true)
{
//alert('h');
var totalamount4=document.getElementById("rate4"+i+"").value;
var reffxamount=document.getElementById("reffxamount"+i+"").value;
if(totalamount4 == "")
{
totalamount4=0;
}
if(reffxamount == "")
{
reffxamount=0;
}
grandtotal4=parseFloat(grandtotal4)+parseFloat(totalamount4);
grandfxtotal4=parseFloat(grandfxtotal4)+parseFloat(reffxamount);
}
}
document.getElementById("totalamtref").value=grandtotal4.toFixed(2);
document.getElementById("totalfxamtref").value=grandfxtotal4.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}
var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
var totalamountpharm=document.getElementById("totalamtpharm").value;
if(totalamountpharm == "")
{
totalamountpharm=0;
}
//alert(totalamountser);
var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
}
else
{
grandtotal4=0;
for(i=1;i<=totalcount4;i++)
{
if(document.getElementById("reff4"+i+"").checked == false)
{
if(document.getElementById("reff4"+i+"").checked == true)
{
var totalamount4=document.getElementById("rate4"+i+"").value;
var reffxamount=document.getElementById("reffxamount"+i+"").value;
}
else
{
var totalamount4=0;
var reffxamount=0;
}
if(totalamount4 == "")
{
totalamount4=0;
}
if(reffxamount == "")
{
reffxamount=0;
}
//alert(totalamount);
grandtotal4=parseFloat(grandtotal4)+parseFloat(totalamount4);
}
else
{
if(document.getElementById("reff4"+i+"").checked == true)
{
var totalamount4=document.getElementById("rate4"+i+"").value;
var reffxamount=document.getElementById("reffxamount"+i+"").value;
}
else
{
var totalamount4=0;
var reffxamount=0;
}
if(totalamount4 == "")
{
totalamount4=0;
}
if(reffxamount == "")
{
reffxamount=0;
}
//alert(totalamount);
grandtotal4=parseFloat(grandtotal4)+parseFloat(totalamount4);
grandfxtotal4=parseFloat(grandfxtotal4)+parseFloat(reffxamount);
}
}
document.getElementById("totalamtref").value=grandtotal4.toFixed(2);
document.getElementById("totalfxamtref").value=grandfxtotal4.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}
var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
var totalamountpharm=document.getElementById("totalamtpharm").value;
if(totalamountpharm == "")
{
totalamountpharm=0;
}
//alert(totalamountser);
// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
}
		var totalfxamtconsultation=document.getElementById("totalfxamtconsultation").value;
		if(totalfxamtconsultation == "")
		{
		totalfxamtconsultation=0;
		}
var totalfxamtlab=document.getElementById("totalfxamtlab").value;
		if(totalfxamtlab == "")
		{
		totalfxamtlab=0;
		}
		//alert(totalamountlab);
		var totalfxamtrad=document.getElementById("totalfxamtrad").value;
		if(totalfxamtrad == "")
		{
		totalfxamtrad=0;
		}
		//alert(totalamountrad);
		var totalfxamtser=document.getElementById("totalfxamtser").value;
		if(totalfxamtser == "")
		{
		totalfxamtser=0;
		}
		var totalfxamtref=document.getElementById("totalfxamtref").value;
		if(totalfxamtref == "")
		{
		totalfxamtref=0;
		}
		//alert(totalamountser);
		var totalfxamtamb=document.getElementById("totalfxamtamb").value;
		if(totalfxamtamb == "")
		{
		totalfxamtamb=0;
		}
		var totalfxamthome=document.getElementById("totalfxamthome").value;
		if(totalfxamthome == "")
		{
		totalfxamthome=0;
		}
		var totalfxamountpharm=document.getElementById("totalfxamtpharm").value;
		if(totalfxamountpharm == "")
		{
		totalfxamountpharm=0;
		}
		//alert(totalamountser);
		// var grandfxtotalamount=parseInt(totalfxamtconsultation)+parseInt(totalfxamtlab)+parseInt(totalfxamtrad)+parseInt(totalfxamtser)+parseInt(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseInt(totalfxamountpharm);
		var grandfxtotalamount=parseFloat(totalfxamtconsultation)+parseFloat(totalfxamtlab)+parseFloat(totalfxamtrad)+parseFloat(totalfxamtser)+parseFloat(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseFloat(totalfxamountpharm);
		document.getElementById("grandfxtotalamount").value=grandfxtotalamount.toFixed(2);
}

function updatebox8(varSerialNumber2,varrate2,totalcount2)
{
	var grandtotal2 = 0;
	var grandfxtotal2 = 0;
	for(var i=1;i<=totalcount2;i++)
	{
		//alert(i);
		if(document.getElementById("pharmreff"+i)!= null)
		{
			if(document.getElementById("pharmreff"+i).checked  == true)
			{
				var refseramt = document.getElementById("pharmfxamount"+i+"").value;
				var ambfxamount = document.getElementById("pharmfxamount"+i+"").value;
				//var totalamount2=document.getElementById("rate2"+i+"").value;
				var totalamount2=parseFloat(refseramt);
				
				if(totalamount2 == "")
				{
					totalamount2=0;
				}
				if(ambfxamount == "")
				{
					ambfxamount=0;
				}
				
				grandtotal2=parseFloat(grandtotal2)+parseFloat(totalamount2);
				grandfxtotal2=parseFloat(grandfxtotal2)+parseFloat(ambfxamount);
			}
			//alert(grandtotal2);
			document.getElementById("totalamtpharm").value=grandtotal2.toFixed(2);
			document.getElementById("totalfxamtpharm").value=grandfxtotal2.toFixed(2);
			var totalamountconsultation=document.getElementById("totalamtconsultation").value;
			var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
			if(totalamountconsultation== "")
			{
			totalamountconsultation=0;
			}
			
			var totalamountlab=document.getElementById("totalamtlab").value;
			if(totalamountlab == "")
			{
			totalamountlab=0;
			}
			//alert(totalamountlab);
			var totalamountrad=document.getElementById("totalamtrad").value;
			if(totalamountrad == "")
			{
			totalamountrad=0;
			}
			//alert(totalamountrad);
			var totalamountser=document.getElementById("totalamtser").value;
			if(totalamountser == "")
			{
			totalamountser=0;
			}
			var totalamountref=document.getElementById("totalamtref").value;
			if(totalamountref == "")
			{
			totalamountref=0;
			}
			var totalamountamb=document.getElementById("totalamtamb").value;
			if(totalamountamb == "")
			{
			totalamountamb=0;
			}
			var totalamounthome=document.getElementById("totalamthome").value;
			if(totalamounthome == "")
			{
			totalamounthome=0;
			}
			var totalamountpharm=document.getElementById("totalamtpharm").value;
			if(totalamountpharm == "")
			{
			totalamountpharm=0;
			}
			//alert(totalamountser);
			// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
			var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
			document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
		}
	}
		var totalfxamtconsultation=document.getElementById("totalfxamtconsultation").value;
		if(totalfxamtconsultation == "")
		{
		totalfxamtconsultation=0;
		}
	var totalfxamtlab=document.getElementById("totalfxamtlab").value;
		if(totalfxamtlab == "")
		{
		totalfxamtlab=0;
		}
		//alert(totalamountlab);
		var totalfxamtrad=document.getElementById("totalfxamtrad").value;
		if(totalfxamtrad == "")
		{
		totalfxamtrad=0;
		}
		//alert(totalamountrad);
		var totalfxamtser=document.getElementById("totalfxamtser").value;
		if(totalfxamtser == "")
		{
		totalfxamtser=0;
		}
		var totalfxamtref=document.getElementById("totalfxamtref").value;
		if(totalfxamtref == "")
		{
		totalfxamtref=0;
		}
		//alert(totalamountser);
		var totalfxamtamb=document.getElementById("totalfxamtamb").value;
		if(totalfxamtamb == "")
		{
		totalfxamtamb=0;
		}
		var totalfxamthome=document.getElementById("totalfxamthome").value;
		if(totalfxamthome == "")
		{
		totalfxamthome=0;
		}
		var totalfxamountpharm=document.getElementById("totalamtpharm").value;
		if(totalfxamountpharm == "")
		{
		totalfxamountpharm=0;
		}
		//alert(totalamountser);
		var grandfxtotalamount=parseFloat(totalfxamtconsultation)+parseFloat(totalfxamtlab)+parseFloat(totalfxamtrad)+parseFloat(totalfxamtser)+parseFloat(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseFloat(totalfxamountpharm);
		// var grandfxtotalamount=parseInt(totalfxamtconsultation)+parseInt(totalfxamtlab)+parseInt(totalfxamtrad)+parseInt(totalfxamtser)+parseInt(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseFloat(totalfxamountpharm);
		document.getElementById("grandfxtotalamount").value=grandfxtotalamount.toFixed(2);
}

function updateboxamb(varSerialNumber2,varrate2,totalcount2)
{
	var grandtotal2 = 0;
	var grandfxtotal2 = 0;
	for(var i=1;i<=totalcount2;i++)
	{
		//alert(i);
		if(document.getElementById("reffamb4"+i)!= null)
		{
			if(document.getElementById("reffamb4"+i).checked  == true)
			{
				var refseramt = document.getElementById("ambamt4"+i+"").value;
				var ambfxamount = document.getElementById("ambfxamount"+i+"").value;
				//var totalamount2=document.getElementById("rate2"+i+"").value;
				var totalamount2=parseFloat(refseramt);
				
				if(totalamount2 == "")
				{
					totalamount2=0;
				}
				if(ambfxamount == "")
				{
					ambfxamount=0;
				}
				
				grandtotal2=parseFloat(grandtotal2)+parseFloat(totalamount2);
				grandfxtotal2=parseFloat(grandfxtotal2)+parseFloat(ambfxamount);
			}
			//alert(grandtotal2);
			document.getElementById("totalamtamb").value=grandtotal2.toFixed(2);
			document.getElementById("totalfxamtamb").value=grandfxtotal2.toFixed(2);
			var totalamountconsultation=document.getElementById("totalamtconsultation").value;
			var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
			if(totalamountconsultation== "")
			{
			totalamountconsultation=0;
			}
			
			var totalamountlab=document.getElementById("totalamtlab").value;
			if(totalamountlab == "")
			{
			totalamountlab=0;
			}
			//alert(totalamountlab);
			var totalamountrad=document.getElementById("totalamtrad").value;
			if(totalamountrad == "")
			{
			totalamountrad=0;
			}
			//alert(totalamountrad);
			var totalamountser=document.getElementById("totalamtser").value;
			if(totalamountser == "")
			{
			totalamountser=0;
			}
			var totalamountref=document.getElementById("totalamtref").value;
			if(totalamountref == "")
			{
			totalamountref=0;
			}
			var totalamountamb=document.getElementById("totalamtamb").value;
			if(totalamountamb == "")
			{
			totalamountamb=0;
			}
			var totalamounthome=document.getElementById("totalamthome").value;
			if(totalamounthome == "")
			{
			totalamounthome=0;
			}
			var totalamountpharm=document.getElementById("totalamtpharm").value;
			if(totalamountpharm == "")
			{
			totalamountpharm=0;
			}
			//alert(totalamountser);
			var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
			// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
			document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
		}
	}
		var totalfxamtconsultation=document.getElementById("totalfxamtconsultation").value;
		if(totalfxamtconsultation == "")
		{
		totalfxamtconsultation=0;
		}
	var totalfxamtlab=document.getElementById("totalfxamtlab").value;
		if(totalfxamtlab == "")
		{
		totalfxamtlab=0;
		}
		//alert(totalamountlab);
		var totalfxamtrad=document.getElementById("totalfxamtrad").value;
		if(totalfxamtrad == "")
		{
		totalfxamtrad=0;
		}
		//alert(totalamountrad);
		var totalfxamtser=document.getElementById("totalfxamtser").value;
		if(totalfxamtser == "")
		{
		totalfxamtser=0;
		}
		var totalfxamtref=document.getElementById("totalfxamtref").value;
		if(totalfxamtref == "")
		{
		totalfxamtref=0;
		}
		//alert(totalamountser);
		var totalfxamtamb=document.getElementById("totalfxamtamb").value;
		if(totalfxamtamb == "")
		{
		totalfxamtamb=0;
		}
		var totalfxamthome=document.getElementById("totalfxamthome").value;
		if(totalfxamthome == "")
		{
		totalfxamthome=0;
		}
		var totalfxamountpharm=document.getElementById("totalfxamtpharm").value;
		if(totalfxamountpharm == "")
		{
		totalfxamountpharm=0;
		}
		//alert(totalamountser);
		var grandfxtotalamount=parseFloat(totalfxamtconsultation)+parseFloat(totalfxamtlab)+parseFloat(totalfxamtrad)+parseFloat(totalfxamtser)+parseFloat(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseFloat(totalfxamountpharm);
		// var grandfxtotalamount=parseInt(totalfxamtconsultation)+parseInt(totalfxamtlab)+parseInt(totalfxamtrad)+parseInt(totalfxamtser)+parseInt(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseInt(totalfxamountpharm);
		document.getElementById("grandfxtotalamount").value=grandfxtotalamount.toFixed(2);
}
function updateboxhome(varSerialNumber2,varrate2,totalcount2)
{
	var grandtotal2 = 0;
	var grandfxtotal2 = 0;
	for(var i=1;i<=totalcount2;i++)
	{
		//alert(i);
		if(document.getElementById("reffhome4"+i)!= null)
		{
			if(document.getElementById("reffhome4"+i).checked  == true)
			{
				var refseramt = document.getElementById("homeamt4"+i+"").value;
				var homefxamount = document.getElementById("homefxamount"+i+"").value;
				//var totalamount2=document.getElementById("rate2"+i+"").value;
				var totalamount2=parseFloat(refseramt);
				
				if(totalamount2 == "")
				{
					totalamount2=0;
				}
				if(homefxamount == "")
				{
					homefxamount=0;
				}
				
				grandtotal2=parseFloat(grandtotal2)+parseFloat(totalamount2);
				grandfxtotal2=parseFloat(grandfxtotal2)+parseFloat(homefxamount);
			}
			//alert(grandtotal2);
			document.getElementById("totalamthome").value=grandtotal2.toFixed(2);
			document.getElementById("totalfxamthome").value=grandfxtotal2.toFixed(2);
			var totalamountconsultation=document.getElementById("totalamtconsultation").value;
			var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
			if(totalamountconsultation== "")
			{
			totalamountconsultation=0;
			}
			
			var totalamountlab=document.getElementById("totalamtlab").value;
			if(totalamountlab == "")
			{
			totalamountlab=0;
			}
			//alert(totalamountlab);
			var totalamountrad=document.getElementById("totalamtrad").value;
			if(totalamountrad == "")
			{
			totalamountrad=0;
			}
			//alert(totalamountrad);
			var totalamountser=document.getElementById("totalamtser").value;
			if(totalamountser == "")
			{
			totalamountser=0;
			}
			var totalamountref=document.getElementById("totalamtref").value;
			if(totalamountref == "")
			{
			totalamountref=0;
			}
			var totalamountamb=document.getElementById("totalamtamb").value;
			if(totalamountamb == "")
			{
			totalamountamb=0;
			}
			var totalamounthome=document.getElementById("totalamthome").value;
			if(totalamounthome == "")
			{
			totalamounthome=0;
			}
			var totalamountpharm=document.getElementById("totalamtpharm").value;
			if(totalamountpharm == "")
			{
			totalamountpharm=0;
			}
						//alert(totalamountser);
			var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
			// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
			document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
		}
	}
		var totalfxamtconsultation=document.getElementById("totalfxamtconsultation").value;
		if(totalfxamtconsultation == "")
		{
		totalfxamtconsultation=0;
		}
	var totalfxamtlab=document.getElementById("totalfxamtlab").value;
		if(totalfxamtlab == "")
		{
		totalfxamtlab=0;
		}
		//alert(totalamountlab);
		var totalfxamtrad=document.getElementById("totalfxamtrad").value;
		if(totalfxamtrad == "")
		{
		totalfxamtrad=0;
		}
		//alert(totalamountrad);
		var totalfxamtser=document.getElementById("totalfxamtser").value;
		if(totalfxamtser == "")
		{
		totalfxamtser=0;
		}
		var totalfxamtref=document.getElementById("totalfxamtref").value;
		if(totalfxamtref == "")
		{
		totalfxamtref=0;
		}
		//alert(totalamountser);
		var totalfxamtamb=document.getElementById("totalfxamtamb").value;
		if(totalfxamtamb == "")
		{
		totalfxamtamb=0;
		}
		var totalfxamthome=document.getElementById("totalfxamthome").value;
		if(totalfxamthome == "")
		{
		totalfxamthome=0;
		}
		var totalfxamountpharm=document.getElementById("totalfxamtpharm").value;
		if(totalfxamountpharm == "")
		{
		totalfxamountpharm=0;
		}
		//alert(totalamountser);
		var grandfxtotalamount=parseFloat(totalfxamtconsultation)+parseFloat(totalfxamtlab)+parseFloat(totalfxamtrad)+parseFloat(totalfxamtser)+parseFloat(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseFloat(totalfxamountpharm);
		// var grandfxtotalamount=parseInt(totalfxamtconsultation)+parseInt(totalfxamtlab)+parseInt(totalfxamtrad)+parseInt(totalfxamtser)+parseInt(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseInt(totalfxamountpharm);
		document.getElementById("grandfxtotalamount").value=grandfxtotalamount.toFixed(2);
}
function validcheck()
{

if(confirm("Are You Sure Want To Save This Entry?")==false) 
{
	return false;
} 

}
function chkser(id,totalcount)
{
 var id = id;
 var totalcount2 = totalcount;
 var reqser = document.getElementById("reqserqty"+id).value;
 var refser = document.getElementById("refundserqty"+id).value;
 var serfxrate = document.getElementById("serfxrate"+id).value;
 var serfxamount = document.getElementById("serfxamount"+id).value;
 if(refser == '') { refser = 0; }
 var refrate = document.getElementById("rate2"+id).value;
 if(parseFloat(refser) > parseFloat(reqser))
 {
 	alert("Refund Qty Greater than Balance Qty");
	document.getElementById("refundserqty"+id).value = "0";
	document.getElementById("refseramt"+id).value = "0.00";
	document.getElementById("serfxamount"+id).value = "0.00";
	document.getElementById("refundserqty"+id).focus();
	return false;
 }
 
 var Amt = parseFloat(refser) * parseFloat(refrate);
 document.getElementById("refseramt"+id).value = Amt.toFixed(2);
 var serfxamount = parseFloat(refser) * parseFloat(serfxrate);
 document.getElementById("serfxamount"+id).value = serfxamount.toFixed(2);
 var grandfxtotal2=0;
 var grandtotal2=0;
	for(var i=1;i<=totalcount2;i++)
	{
		//alert(i);
		if(document.getElementById("reff2"+i)!= null)
		{
			if(document.getElementById("reff2"+i).checked  == true)
			{
				var refseramt = document.getElementById("refseramt"+i+"").value;
				var homefxamount = document.getElementById("serfxamount"+i+"").value;
				//var totalamount2=document.getElementById("rate2"+i+"").value;
				var totalamount2=parseFloat(refseramt);
				
				if(totalamount2 == "")
				{
						totalamount2=0;
				}
				if(homefxamount == "")
				{
					homefxamount=0;
				}
				
				grandtotal2=parseFloat(grandtotal2)+parseFloat(totalamount2);
				grandfxtotal2=parseFloat(grandfxtotal2)+parseFloat(homefxamount);
			}
		}
	}
	document.getElementById("totalamtser").value = grandtotal2.toFixed(2);
	document.getElementById("totalfxamtser").value = grandfxtotal2.toFixed(2);
	
 	var totalamountconsultation=document.getElementById("totalamtconsultation").value;
	var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
	if(totalamountconsultation== "")
	{
	totalamountconsultation=0;
	}
	
	var totalamountlab=document.getElementById("totalamtlab").value;
	if(totalamountlab == "")
	{
	totalamountlab=0;
	}
	//alert(totalamountlab);
	var totalamountrad=document.getElementById("totalamtrad").value;
	if(totalamountrad == "")
	{
	totalamountrad=0;
	}
	//alert(totalamountrad);
	var totalamountser=document.getElementById("totalamtser").value;
	if(totalamountser == "")
	{
	totalamountser=0;
	}
	var totalamountref=document.getElementById("totalamtref").value;
	if(totalamountref == "")
	{
	totalamountref=0;
	}
	var totalamountamb=document.getElementById("totalamtamb").value;
	if(totalamountamb == "")
	{
	totalamountamb=0;
	}
	var totalamounthome=document.getElementById("totalamthome").value;
	if(totalamounthome == "")
	{
	totalamounthome=0;
	}
	var totalamountpharm=document.getElementById("totalamtpharm").value;
	if(totalamountpharm == "")
	{
	totalamountpharm=0;
	}
	//alert(totalamountser);
	var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
	// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
	document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
	var totalfxamtconsultation=document.getElementById("totalfxamtconsultation").value;
		if(totalfxamtconsultation == "")
		{
		totalfxamtconsultation=0;
		}
	var totalfxamtlab=document.getElementById("totalfxamtlab").value;
	if(totalfxamtlab == "")
	{
	totalfxamtlab=0;
	}
	//alert(totalamountlab);
	var totalfxamtrad=document.getElementById("totalfxamtrad").value;
	if(totalfxamtrad == "")
	{
	totalfxamtrad=0;
	}
	//alert(totalamountrad);
	var totalfxamtser=document.getElementById("totalfxamtser").value;
	if(totalfxamtser == "")
	{
	totalfxamtser=0;
	}
	var totalfxamtref=document.getElementById("totalfxamtref").value;
	if(totalfxamtref == "")
	{
	totalfxamtref=0;
	}
	//alert(totalamountser);
	var totalfxamtamb=document.getElementById("totalfxamtamb").value;
	if(totalfxamtamb == "")
	{
	totalfxamtamb=0;
	}
	var totalfxamthome=document.getElementById("totalfxamthome").value;
	if(totalfxamthome == "")
	{
	totalfxamthome=0;
	}
	var totalfxamountpharm=document.getElementById("totalfxamtpharm").value;
	if(totalfxamountpharm == "")
	{
	totalfxamountpharm=0;
	}
	//alert(totalamountser);
	var grandfxtotalamount=parseFloat(totalfxamtconsultation)+parseFloat(totalfxamtlab)+parseFloat(totalfxamtrad)+parseFloat(totalfxamtser)+parseFloat(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseFloat(totalfxamountpharm);
	// var grandfxtotalamount=parseInt(totalfxamtconsultation)+parseInt(totalfxamtlab)+parseInt(totalfxamtrad)+parseInt(totalfxamtser)+parseInt(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseInt(totalfxamountpharm);
	document.getElementById("grandfxtotalamount").value=grandfxtotalamount.toFixed(2);
}
function chkamb(id,totalcount2)
{
 var id = id;
 var totalcount2 = totalcount2;
 var reqser = document.getElementById("reqambqty"+id).value;
 var refser = document.getElementById("refambqty"+id).value;
 var ambfxrate = document.getElementById("ambfxrate"+id).value;
 var ambfxamount = document.getElementById("ambfxamount"+id).value;
 if(refser == '') { refser = 0; }
 var refrate = document.getElementById("reqambrate"+id).value;
 if(parseFloat(refser) > parseFloat(reqser))
 {
 	alert("Refund Qty Greater than Balance Qty");
	document.getElementById("refambqty"+id).value = "0";
	document.getElementById("ambamt4"+id).value = "0.00";
	 document.getElementById("ambfxamount"+id).value ='0.00';
	document.getElementById("refambqty"+id).focus();
	return false;
 }
 var Amt = parseFloat(refser) * parseFloat(refrate);
 document.getElementById("ambamt4"+id).value = Amt.toFixed(2);
 var ambfxamount = parseFloat(refser) * parseFloat(ambfxrate);
 document.getElementById("ambfxamount"+id).value = ambfxamount.toFixed(2);
 var grandfxtotal2=0;
 var grandtotal2=0;
	for(var i=1;i<=totalcount2;i++)
	{
		//alert(i);
		if(document.getElementById("reffamb4"+i)!= null)
		{
			if(document.getElementById("reffamb4"+i).checked  == true)
			{
				var refseramt = document.getElementById("ambamt4"+i+"").value;
				var homefxamount = document.getElementById("ambfxamount"+i+"").value;
				//var totalamount2=document.getElementById("rate2"+i+"").value;
				var totalamount2=parseFloat(refseramt);
				
				if(totalamount2 == "")
				{
						totalamount2=0;
				}
				if(homefxamount == "")
				{ 
					homefxamount=0;
				}
				
				grandtotal2=parseFloat(grandtotal2)+parseFloat(totalamount2);
				grandfxtotal2=parseFloat(grandfxtotal2)+parseFloat(homefxamount);
			}
		}
	}
	document.getElementById("totalamtamb").value = grandtotal2.toFixed(2);
	document.getElementById("totalfxamtamb").value = grandfxtotal2.toFixed(2);
  	var totalamountconsultation=document.getElementById("totalamtconsultation").value;
	var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
	if(totalamountconsultation== "")
	{
	totalamountconsultation=0;
	}
	
	var totalamountlab=document.getElementById("totalamtlab").value;
	if(totalamountlab == "")
	{
	totalamountlab=0;
	}
	//alert(totalamountlab);
	var totalamountrad=document.getElementById("totalamtrad").value;
	if(totalamountrad == "")
	{
	totalamountrad=0;
	}
	//alert(totalamountrad);
	var totalamountser=document.getElementById("totalamtser").value;
	if(totalamountser == "")
	{
	totalamountser=0;
	}
	var totalamountref=document.getElementById("totalamtref").value;
	if(totalamountref == "")
	{
	totalamountref=0;
	}
	var totalamountamb=document.getElementById("totalamtamb").value;
	if(totalamountamb == "")
	{
	totalamountamb=0;
	}
	var totalamounthome=document.getElementById("totalamthome").value;
	if(totalamounthome == "")
	{
	totalamounthome=0;
	}
	var totalamountpharm=document.getElementById("totalamtpharm").value;
	if(totalamountpharm == "")
	{
	totalamountpharm=0;
	}
	//alert(totalamountser);
	var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
	// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
	document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
	var totalfxamtconsultation=document.getElementById("totalfxamtconsultation").value;
		if(totalfxamtconsultation == "")
		{
		totalfxamtconsultation=0;
		}
	var totalfxamtlab=document.getElementById("totalfxamtlab").value;
	if(totalfxamtlab == "")
	{
	totalfxamtlab=0;
	}
	//alert(totalamountlab);
	var totalfxamtrad=document.getElementById("totalfxamtrad").value;
	if(totalfxamtrad == "")
	{
	totalfxamtrad=0;
	}
	//alert(totalamountrad);
	var totalfxamtser=document.getElementById("totalfxamtser").value;
	if(totalfxamtser == "")
	{
	totalfxamtser=0;
	}
	var totalfxamtref=document.getElementById("totalfxamtref").value;
	if(totalfxamtref == "")
	{
	totalfxamtref=0;
	}
	//alert(totalamountser);
	var totalfxamtamb=document.getElementById("totalfxamtamb").value;
	if(totalfxamtamb == "")
	{
	totalfxamtamb=0;
	}
	var totalfxamthome=document.getElementById("totalfxamthome").value;
	if(totalfxamthome == "")
	{
	totalfxamthome=0;
	}
	var totalfxamountpharm=document.getElementById("totalfxamtpharm").value;
	if(totalfxamountpharm == "")
	{
	totalfxamountpharm=0;
	}
	//alert(totalamountser);
	var grandfxtotalamount=parseFloat(totalfxamtconsultation)+parseFloat(totalfxamtlab)+parseFloat(totalfxamtrad)+parseFloat(totalfxamtser)+parseFloat(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseFloat(totalfxamountpharm);
	// var grandfxtotalamount=parseInt(totalfxamtconsultation)+parseInt(totalfxamtlab)+parseInt(totalfxamtrad)+parseInt(totalfxamtser)+parseInt(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseInt(totalfxamountpharm);
	document.getElementById("grandfxtotalamount").value=grandfxtotalamount.toFixed(2);
}
function chkhome(id,totalcount2)
{
 var id = id;
 var totalcount2 = totalcount2;
 var reqser = document.getElementById("reqhomeqty"+id).value;
 var refser = document.getElementById("refhomeqty"+id).value;
 var homefxrate = document.getElementById("homefxrate"+id).value;
 var homefxamount = document.getElementById("homefxamount"+id).value;
 
 if(refser == '') { refser = 0; }
 var refrate = document.getElementById("reqhomerate"+id).value;
 if(parseFloat(refser) > parseFloat(reqser))
 {
 	alert("Refund Qty Greater than Balance Qty");
	document.getElementById("refhomeqty"+id).value = "0";
	document.getElementById("homeamt4"+id).value = "0.00";
	document.getElementById("homefxamount"+id).value = "0.00";
	document.getElementById("refhomeqty"+id).focus();
	return false;
 }
 var Amt = parseFloat(refser) * parseFloat(refrate);
 document.getElementById("homeamt4"+id).value = Amt.toFixed(2);
 var homefxamount = parseFloat(refser) * parseFloat(homefxrate);
 //alert(homefxamount);
 	document.getElementById("homefxamount"+id).value = homefxamount.toFixed(2);
	var grandfxtotal2=0;
 	var grandtotal2=0;
	for(var i=1;i<=totalcount2;i++)
	{
		//alert(i);
		if(document.getElementById("reffhome4"+i)!= null)
		{
			if(document.getElementById("reffhome4"+i).checked  == true)
			{
				var refseramt = document.getElementById("homeamt4"+i+"").value;
				var homefxamount = document.getElementById("homefxamount"+i+"").value;
				//var totalamount2=document.getElementById("rate2"+i+"").value;
				var totalamount2=parseFloat(refseramt);
				
				if(totalamount2 == "")
				{
						totalamount2=0;
				}
				if(homefxamount == "")
				{ 
					homefxamount=0;
				}
				
				grandtotal2=parseFloat(grandtotal2)+parseFloat(totalamount2);
				grandfxtotal2=parseFloat(grandfxtotal2)+parseFloat(homefxamount);
			}
		}
	}
	document.getElementById("totalamthome").value = grandtotal2.toFixed(2);
	document.getElementById("totalfxamthome").value = grandfxtotal2.toFixed(2);
  	var totalamountconsultation=document.getElementById("totalamtconsultation").value;
	var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
	if(totalamountconsultation== "")
	{
	totalamountconsultation=0;
	}
	
	var totalamountlab=document.getElementById("totalamtlab").value;
	if(totalamountlab == "")
	{
	totalamountlab=0;
	}
	//alert(totalamountlab);
	var totalamountrad=document.getElementById("totalamtrad").value;
	if(totalamountrad == "")
	{
	totalamountrad=0;
	}
	//alert(totalamountrad);
	var totalamountser=document.getElementById("totalamtser").value;
	if(totalamountser == "")
	{
	totalamountser=0;
	}
	var totalamountref=document.getElementById("totalamtref").value;
	if(totalamountref == "")
	{
	totalamountref=0;
	}
	var totalamountamb=document.getElementById("totalamtamb").value;
	if(totalamountamb == "")
	{
	totalamountamb=0;
	}
	var totalamounthome=document.getElementById("totalamthome").value;
	if(totalamounthome == "")
	{
	totalamounthome=0;
	}
	var totalamountpharm=document.getElementById("totalamtpharm").value;
	if(totalamountpharm == "")
	{
	totalamountpharm=0;
	}
	//alert(totalamountser);
	var grandtotalamount=parseFloat(totalamountconsultation)+parseFloat(totalamountlab)+parseFloat(totalamountrad)+parseFloat(totalamountser)+parseFloat(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseFloat(totalamountpharm);
	// var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome)+parseInt(totalamountpharm);
	document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
	
	var totalfxamtconsultation=document.getElementById("totalfxamtconsultation").value;
		if(totalfxamtconsultation == "")
		{
		totalfxamtconsultation=0;
		}
	var totalfxamtlab=document.getElementById("totalfxamtlab").value;
	if(totalfxamtlab == "")
	{
	totalfxamtlab=0;
	}
	//alert(totalamountlab);
	var totalfxamtrad=document.getElementById("totalfxamtrad").value;
	if(totalfxamtrad == "")
	{
	totalfxamtrad=0;
	}
	//alert(totalamountrad);
	var totalfxamtser=document.getElementById("totalfxamtser").value;
	if(totalfxamtser == "")
	{
	totalfxamtser=0;
	}
	var totalfxamtref=document.getElementById("totalfxamtref").value;
	if(totalfxamtref == "")
	{
	totalfxamtref=0;
	}
	//alert(totalamountser);
	var totalfxamtamb=document.getElementById("totalfxamtamb").value;
	if(totalfxamtamb == "")
	{
	totalfxamtamb=0;
	}
	var totalfxamthome=document.getElementById("totalfxamthome").value;
	if(totalfxamthome == "")
	{
	totalfxamthome=0;
	}
	var totalfxamountpharm=document.getElementById("totalfxamtpharm").value;
	if(totalfxamountpharm == "")
	{
	totalfxamountpharm=0;
	}
	//alert(totalamountser);
	var grandfxtotalamount=parseFloat(totalfxamtconsultation)+parseFloat(totalfxamtlab)+parseFloat(totalfxamtrad)+parseFloat(totalfxamtser)+parseFloat(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseFloat(totalfxamountpharm);
	// var grandfxtotalamount=parseInt(totalfxamtconsultation)+parseInt(totalfxamtlab)+parseInt(totalfxamtrad)+parseInt(totalfxamtser)+parseInt(totalfxamtref)+parseFloat(totalfxamtamb)+parseFloat(totalfxamthome)+parseInt(totalfxamountpharm);
	document.getElementById("grandfxtotalamount").value=grandfxtotalamount.toFixed(2);
}

function calculateBal(sno){
	var sno = sno;
	var quantity = document.getElementById('pharmrefundqty'+sno).value;
	var rate = document.getElementById('pharmrate'+sno).value;
	var initialquantity = document.getElementById('pharmqty'+sno).value;

	if(parseFloat(quantity) > parseFloat(initialquantity)){
		alert("Refund Qty Greater than Balance Qty");
		document.getElementById('pharmrefundqty'+sno).focus;
		document.getElementById('pharmrefundqty'+sno).value = '';
		return false;
	}

	var balance = initialquantity - quantity;
	document.getElementById('pharmbal'+sno).innerHTML = balance;

	var amount = quantity * rate;

	document.getElementById('pharmdisptotal'+sno).innerHTML = amount.toFixed(2);
	document.getElementById('pharmfxamount'+sno).value = amount.toFixed(2);
	document.getElementById('pharmdispfxamount'+sno).innerHTML = amount.toFixed(2);
	document.getElementById('pharmtotal'+sno).value = amount.toFixed(2);

}
</script>
<script src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
	var sno = document.getElementById('pharmsno').value;
	for(var i=1; i<=sno; i++){
	    $("#pharmreff"+i).trigger('click', {
	    })

	    // document.getElementById('pharmreff'+i).disabled = true;
	     $('#pharmreff'+i).hide();
	}
});
</script>
<script type="text/javascript" src="js/insertnewitem7.js"></script>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.bal
{
border-style:none;
background:none;
text-align:right;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
<script src="js/datetimepicker_css.js"></script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="paylaterrefund.php" onKeyDown="return disableEnterKey(event)"  onSubmit="return validcheck()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9hbGVydG1lc3NhZ2VzMS5waHAiKTsg')); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy90aXRsZTEucGhwIik7IA==')); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9tZW51MS5waHAiKTsg')); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="130%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32"><strong>Pay Later Patient Details</strong></td>
			 </tr>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			  <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  </strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHBhdGllbnRuYW1lOyA=')); ?>
				<input type="hidden" name="patientname" id="customer" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRuYW1lOyA=')); ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>                  </td>
                     	<input type="hidden" name="labcoa" value="<?php eval(base64_decode('IGVjaG8gJGxhYmNvYTsg')); ?>">
				<input type="hidden" name="radiologycoa" value="<?php eval(base64_decode('IGVjaG8gJHJhZGlvbG9neWNvYTsg')); ?>">
				<input type="hidden" name="servicecoa" value="<?php eval(base64_decode('IGVjaG8gJHNlcnZpY2Vjb2E7IA==')); ?>">
				<input type="hidden" name="pharmacycoa" value="<?php eval(base64_decode('IGVjaG8gJHBoYXJtYWN5Y29hOyA=')); ?>">
				<input type="hidden" name="referalcoa" value="<?php eval(base64_decode('IGVjaG8gJHJlZmVyYWxjb2E7IA==')); ?>">
		
            
			  

			 
<?php
// eval(base64_decode('IGVjaG8gJGZpbmFsaXplZGJpbGxudW1iZXI7IA=='));
$querynw1 = "SELECT * from billing_paylater where billno='$finalizedbillnumber' ";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1=mysqli_num_rows($execnw1);
while($resnw1 = mysqli_fetch_array($execnw1))
{
$accountname = $resnw1['accountname'];
$accountcode = $resnw1['accountnameid'];
$patientaccount1 = $resnw1['accountname'];
$patientaccountid1 = $resnw1['accountnameid'];
$accountnameano = $resnw1['accountnameano'];
}
// echo '<br>';

$query1 = "SELECT * FROM `master_accountname` WHERE `auto_number` = '$accountnameano' ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$num1 = mysqli_num_rows($exec1);
$res1 = mysqli_fetch_array($exec1);
$paymenttype_num=$res1['paymenttype'];  //paymenttype
$patientsubtype=$res1['subtype'];   //subtypeanum

// echo '<br>';
$query_subname = "SELECT * FROM `master_subtype` WHERE `auto_number` = '$patientsubtype' ";
$exec_subname = mysqli_query($GLOBALS["___mysqli_ston"], $query_subname) or die ("Error in query_subname".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_subname = mysqli_fetch_array($exec_subname);
$patientsubtype1=$res_subname['subtype'];  //subtype name

// echo '<br>';
$query_paymtname = "SELECT * FROM `master_paymenttype` WHERE `auto_number` = '$paymenttype_num' ";
$exec_paymtname = mysqli_query($GLOBALS["___mysqli_ston"], $query_paymtname) or die ("Error in query_paymtname".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_paymtname = mysqli_fetch_array($exec_paymtname);
$patienttype1=$res_paymtname['paymenttype'];  //payment type name


?>
	
			 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Type</strong></td>
			 	<td colspan="3" align="left" valign="middle" class="bodytext3"><?php  echo $patienttype1; ?>
		                <!-- <td colspan="3" align="left" valign="middle" class="bodytext3"><?php //eval(base64_decode('IGVjaG8gJHBhdGllbnR0eXBlMTsg')); ?> -->
						<input type="hidden" name="account1" id="account1" value="<?php  echo $patienttype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>		
								</td>
						<!-- <input type="hidden" name="account1" id="account1" value="<?php // eval(base64_decode('IGVjaG8gJHBhdGllbnR0eXBlMTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td> -->
						<!-- ar-->
				
					
				<?php 
				$stringbigname='';
				$query3_012 = "SELECT * FROM master_transactionpaylater WHERE recordstatus='allocated' and billnumber='$finalizedbillnumber' and  visitcode='$visitcode' and docno NOT like 'AR-%'";
				$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numb_121=mysqli_num_rows($exec3_012);
				while($res3_012 = mysqli_fetch_array($exec3_012)){
				$res1docno = $res3_012['docno'];
				$transactionamount= $res3_012['transactionamount'];
				//echo $procedure_id;
				if($stringbigname=='')
				{
				$stringbigname= $res1docno.'&nbsp;&nbsp;=&nbsp;&nbsp;'.$transactionamount;
				}else
				{
				$stringbigname= $stringbigname.','. $res1docno.'='.$transactionamount;
				}
						
				}

				if($numb_121>0){ ?>
					<td width="45%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" style="color:red;" ><strong>
					
					
					<?php echo $stringbigname. '&nbsp;&nbsp;already given, pl be careful while doing the refund..' ;?>
				</strong>	</td>
				<?php } else {?>
				<td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" ></td>
				<?php } ?>
						
				
				
						
	 		</tr>
			 <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHBhdGllbnRjb2RlOyA=')); ?>
				<input type="hidden" name="customercode" id="customercode" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRjb2RlOyA=')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php // eval(base64_decode('IC8vZWNobyAkcmVzNDFkZWxpdmVyeWFkZHJlc3M7IA==')); ?></textarea>--></td>
				    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Sub Type</strong></td>
				    <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientsubtype1; ?>
                <!-- <td colspan="3" align="left" valign="middle" class="bodytext3"><?php // eval(base64_decode('IGVjaG8gJHBhdGllbnRzdWJ0eXBlMTsg')); ?> -->
				<input type="hidden" name="account2" id="account2" value="<?php echo $patientsubtype1;  ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				<!-- <input type="hidden" name="account2" id="account2" value="<?php // eval(base64_decode('IGVjaG8gJHBhdGllbnRzdWJ0eXBlMTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td> -->
				
				<?php 
				$stringbigname='';
				$query3_012 = "SELECT * FROM master_transactionpaylater WHERE recordstatus='allocated' and billnumber='$finalizedbillnumber' and  visitcode='$visitcode' and docno like 'AR-%'";
				$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numb_12=mysqli_num_rows($exec3_012);
				while($res3_012 = mysqli_fetch_array($exec3_012)){
				$res1docno = $res3_012['docno'];
				$transactionamount= $res3_012['transactionamount'];
				//echo $procedure_id;
				if($stringbigname=='')
				{
				$stringbigname= $res1docno.'&nbsp;&nbsp;for&nbsp;&nbsp;'.$transactionamount;
				}else
				{
				$stringbigname= $stringbigname.','. $res1docno.'&nbsp;&nbsp;for&nbsp;&nbsp;'.$transactionamount;
				}
						
				}
				if($numb_12>0){ ?>
					<td width="45%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" style="color:red;" ><strong>
					
				This Invoice has been allocated against&nbsp;&nbsp;&nbsp;<?php echo $stringbigname; ?>&nbsp;&nbsp;&nbsp;and Hence can not be Refunded </strong>
					</td>
				<?php } else {?>
				<td width="25%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" ></td>
				<?php } ?>
						
	
				
			  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHZpc2l0Y29kZTsg')); ?>
				<input type="hidden" name="visitcode" id="visitcode" value="<?php eval(base64_decode('IGVjaG8gJHZpc2l0Y29kZTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHBhdGllbnRhY2NvdW50MTsg')); ?>
				<input type="hidden" name="accountname" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="accountcode" id="accountcode" value="<?php echo $patientaccountid1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="accountnameano" id="accountnameano" value="<?php echo $accountnameano; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	</td>
				  </tr>
                   <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGJpbGxudW1iZXJjb2RlOyA=')); ?>
				<input type="hidden" name="billno" id="billno" value="<?php eval(base64_decode('IGVjaG8gJGJpbGxudW1iZXJjb2RlOyA=')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Plan Name</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHBhdGllbnRwbGFuMTsg')); ?>
				<input type="hidden" name="account" id="account" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRwbGFuMTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  </tr>
                   <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong> Date</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGRhdGVvbmx5OyA=')); ?>
				<input type="hidden" name="billdate" id="billdate" value="<?php eval(base64_decode('IGVjaG8gJGRhdGVvbmx5OyA=')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Bill No</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGZpbmFsaXplZGJpbGxudW1iZXI7IA==')); ?><input type="hidden" name="finalizedbillno" value="<?php eval(base64_decode('IGVjaG8gJGZpbmFsaXplZGJpbGxudW1iZXI7IA==')); ?>">
				</td>
				  </tr>
				  	<tr>
		                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
					 </tr>

					 <?php
				 $query_pharmacheck = "select * from pharmacysales_details where  patientcode = '$patientcode' and visitcode = '$visitcode'  ";
				$exec_pharmacheck = mysqli_query($GLOBALS["___mysqli_ston"], $query_pharmacheck) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num_pharmacheck=mysqli_num_rows($exec_pharmacheck);
				while($res_pharmacheck = mysqli_fetch_array($exec_pharmacheck))
				{       }

				///////////////// CHECKING THE PAHRMACY TOTALLY RETURNES ///////////
			$balanceqty1=0;
			 $query61 = "select * from pharmacysales_details where patientcode = '$patientcode' and visitcode = '$visitcode'";
					$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
					$num = mysqli_num_rows($exec61);
					while ($res61 = mysqli_fetch_array($exec61)) {
					    $totalavaquantity = 0;
					    $itemname         = $res61["itemname"];
					    $itemcode         = $res61["itemcode"];
					    $batchnumber      = $res61["batchnumber"];
					    $quantity         = $res61["quantity"];
					    $rate             = $res61["rate"];
					    $patientnames     = $res61["patientname"];
					    $fifo_code        = $res61["fifo_code"];

					    $query621         = "select * from paylaterpharmareturns where patientname='$patientnames' and patientvisitcode = '$visitcode' and medicinecode='$itemcode'";
					    $exec621 = mysqli_query($GLOBALS["___mysqli_ston"], $query621) or die("Error in Query621" . mysqli_error($GLOBALS["___mysqli_ston"]));
					    $numbr621   = mysqli_num_rows($exec621);
					    $res621     = mysqli_fetch_array($exec621);
					    $billnumber = $res621['billnumber'];

					    $query62    = "select * from pharmacysalesreturn_details where  patientcode = '$patientcode' and visitcode = '$visitcode' and itemcode='$itemcode' and batchnumber='$batchnumber'  ";
					    $exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
					    $numbr = mysqli_num_rows($exec62);
						if($numbr>0){
					    while ($res62 = mysqli_fetch_array($exec62)) {
					        $avaquantity      = $res62['quantity'];
					        $totalavaquantity = $totalavaquantity + $avaquantity;
					    }
					    $resquantity      = $quantity - $totalavaquantity;
					    $refundedquantity = $totalavaquantity;
					    $balanceqty       = $quantity - $refundedquantity;
					    $sno              = $sno + 1;
					    $quantity         = intval($quantity);


					    // $querybatstock2   = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode' and fifo_code='$fifo_code' and storecode ='$storecodeget'";
					    // $execst62 = mysql_query($querybatstock2) or die("Error in Query1" . mysql_error());
					    // $batchqty = mysql_num_rows($execst62);
					    // while ($resst62 = mysql_fetch_array($execst62)) {
					    //     $batchqty       = $resst62['batch_quantity'];
					    //     $totalabatchqty = $totalabatchqty + $batchqty;
					    // }
					     $balanceqty1+=$balanceqty;
						}
					    
					}
					// echo $balanceqty1;
				///////////////// CHECKING THE PAHRMACY TOTALLY RETURNES ///////////

				if($num_pharmacheck>0 && $balanceqty1>0){ ?>
					<tr>
		                <td colspan="7" class="bodytext32"><p style="color: red; text-align: justify; padding-bottom: 6px;"><b>Drugs are Billed for this Patient. For Returns, use Pharmacy Refund Module.</b></p></td>
					 </tr>
					<?php } ?>
					<?php if($balanceqty1=='0' && $num_pharmacheck>0){ ?>
					<tr>
		                <td colspan="7" class="bodytext32"><p style="color: red; text-align: justify; padding-bottom: 6px;"><b>Drugs are Billed for this Patient. Fully Returned as well.</b></p></td>
					 </tr>
					<?php } ?>

					<tr> 
				  	 <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> 
				  <?php
				  $capitation_check=0;
						$query_billno = "select * from billing_paylater where visitcode='$visitcode' and patientcode='$patientcode'  ";
						$exec_billno = mysqli_query($GLOBALS["___mysqli_ston"], $query_billno) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$num_billno=mysqli_num_rows($exec_billno);
						while($res_billno = mysqli_fetch_array($exec_billno))
						{
							 $capitation_check=$res_billno['capitation'];
						}
						if(($num_billno>0) && ($capitation_check=='1')){  ?>
								<p style="color: red; text-align: justify; padding-bottom: 6px;"><b>Capitation Scheme. No Partial refunds allowed. </b></p>
						<?php } ?>
					</td>
					<input type="hidden" id="capitation_checkf" value="<?=$capitation_check;?>">
				</tr>
            </tbody>
        </table></td>
      </tr>
      
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
           <tr bgcolor="#011E6A">
                <td colspan="12" bgcolor="#ecf0f5" class="bodytext32"><strong>Transaction Details</strong></td>
			 </tr>
          
            <tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill No</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bal Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>KSH Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>KSH Amount </strong></div></td>
				<td width="1%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Refund</strong></div></td>
                  </tr>
				  		<?php 
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$sso3=0;
			$query17 = "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee2=$res17['consultationfees'];
			$consultationfee2=number_format($consultationfee2,2);
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			
			$locationcode = $res17['locationcode'];
			
			$query89 = "select * from master_location where locationcode = '$locationcode'";
			$exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res89 = mysqli_fetch_array($exec89);
			
			$locationname = $res89['locationname'];
			
			$query89 = "select * from master_transactionpaylater where visitcode = '$visitcode' and transactiontype='finalize'";
			$exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res89 = mysqli_fetch_array($exec89);
			$currency = $res89['currency'];
			$fxrate = $res89['exchrate'];
			
			?>
			<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">
			<input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>">
            <input type="hidden" name="currency" id="currency" value="<?php echo $currency; ?>">
			<input type="hidden" name="fxrate" id="fxrate" value="<?php echo $fxrate; ?>">
			<?php
			$query181 = "select * from billing_paylaterconsultation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec181 = mysqli_query($GLOBALS["___mysqli_ston"], $query181) or die ("Error in Query181".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res181 = mysqli_fetch_array($exec181);
			$billingdatetime=$res181['billdate'];
			$billno=$res181['billno'];
		
			$consultationfee = $res181['totalamount'];
			$confxamount = $res181['fxamount'];
			
			$query18con = "select * from refund_paylaterconsultation where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec18con = mysqli_query($GLOBALS["___mysqli_ston"], $query18con) or die ("Error in Query18con".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res18con = mysqli_num_rows($exec18con);
			if($res18con == 0)
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
			$totalop=$consultationfee;
			$sso3=$sso3+1;
			 ?>
			  <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNubyA9ICRzbm8gKyAxOyA=')); ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJGNvbnN1bHRhdGlvbmRhdGU7IA==')); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php eval(base64_decode('IGVjaG8gJ09QIENvbnN1bHRhdGlvbic7IA==')); ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center">
				 	<?php if($capitation_check=='1'){  ?>
				 	<?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?>
				 	<input type="hidden" size="2" readonly="readonly" style="background-color:#ecf0f5;" value="<?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?>">
				 <?php  }else{ ?>
				 	<input type="text" size="2" readonly="readonly" style="background-color:#ecf0f5;" value="<?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?>">
				 		<?php  } ?>
				 </div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?></div></td>

				<td class="bodytext31" valign="center"  align="right">
				
				<?php if($capitation_check=='1'){  ?>
				 	<?php eval(base64_decode('IGVjaG8gJGNvbnN1bHRhdGlvbmZlZTsg')); ?>
				 	<input type="hidden" name="rates" id="rates" size="10" value="<?php eval(base64_decode('IGVjaG8gJGNvbnN1bHRhdGlvbmZlZTsg')); ?>" style="text-align:right;" onKeyUp="return updatebox3con()">
				 <?php  }else{ ?>
				 	<input type="" name="rates" id="rates" size="10" value="<?php eval(base64_decode('IGVjaG8gJGNvbnN1bHRhdGlvbmZlZTsg')); ?>" style="text-align:right;" onKeyUp="return updatebox3con()">
				 		<?php  } ?>
				</td>


				 <td class="bodytext31" valign="center"  align="left"><div id="conrate" align="right"><?php eval(base64_decode('IGVjaG8gJGNvbnN1bHRhdGlvbmZlZTsg')); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div id="conratefx" align="right"><?php echo $confxamount; ?></div></td>
				 <td class="bodytext31" valign="center"  align="right">
				 <input type="" name="confxrates" id="confxrates" value="<?php echo $confxamount; ?>" size="12" readonly style="text-align:right; border:none; background:transparent;"></td>


				 <td width="4%"  align="left" valign="center" class="bodytext31"><div align="right"><strong>  
				 	<?php if($capitation_check=='1'){  ?>
				 		<input type="checkbox" checked="" disabled="" >
				 	<input type="hidden" name="reffcon" id="reffcon" value="" onClick="updatebox3()" checked="" />
				 <?php  }else{ ?>
				 	<input type="checkbox" name="reffcon" id="reffcon" value="" onClick="updatebox3()"/>
				 		<?php  } ?>
               	
               </strong></div>
           </td>
             
				</tr>
			<?php 
			}
			?>
			  <?php  
			  $totallab=0;
			  $sso=0;
			  $numb=0;
			  $query19 = "select * from billing_paylaterlab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> ''";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb=mysqli_num_rows($exec19);
			while($res19 = mysqli_fetch_array($exec19))
			{
			$labdate=$res19['billdate'];
			$labname=$res19['labitemname'];
			$labcode1=$res19['labitemcode'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['billnumber'];
			$fxrate=$res19['fxrate'];
			$fxamount=$res19['fxamount'];
			
			$query80 = "select * from refund_paylaterlab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemcode = '$labcode1'";
			// $query80 = "select * from refund_paylaterlab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname = '$labname'";
			$exec80 = mysqli_query($GLOBALS["___mysqli_ston"], $query80) or die ("Error in Query80".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res80rows = mysqli_num_rows($exec80);
			if($res80rows == 0)
			{
			//$numb -= 1;
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
			$sso=$sso+1;
			 ?>
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>

			 	<input type="hidden" name="lserialnumber[]" id="lserialnumber" value="<?php echo $sso; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNubyA9ICRzbm8gKyAxOyA=')); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJGxhYmRhdGU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJGxhYnJlZm5vOyA=')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php eval(base64_decode('IGVjaG8gJGxhYm5hbWU7IA==')); ?></div></td>
			 <input type="hidden" name="lab[]" value="<?php eval(base64_decode('IGVjaG8gJGxhYm5hbWU7IA==')); ?>">
			 <input type="hidden" name="labcode1[]" value="<?php echo $labcode1;  ?>">
			 <input type="hidden" name="labrate[]" value="<?php eval(base64_decode('IGVjaG8gJGxhYnJhdGU7IA==')); ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?></div></td>


			 <td class="bodytext31" valign="center"  align="left"><div align="center">
			 		<?php if($capitation_check=='1'){  ?>
			 			<?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?>
			 				<input type="hidden" size="2" readonly style="background-color:#ecf0f5;" value="<?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?>">
			 			<?php  }else{ ?>
			 				<input type="text" size="2" readonly style="background-color:#ecf0f5;" value="<?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?>">
			 		<?php } ?>
			 </div></td>


			 <td class="bodytext31" valign="center"  align="left"><div align="center">1</div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJGxhYnJhdGU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJGxhYnJhdGU7IA==')); ?></div></td>
			  <input type="hidden" name="rate[]" id="rate<?php eval(base64_decode('IGVjaG8gJHNzbzsg')); ?>" value="<?php eval(base64_decode('IGVjaG8gJGxhYnJhdGU7IA==')); ?>">
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $fxrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $fxamount; ?>
             <input type="hidden" name="labfxrate[]" id="labfxrate<?php echo $sso;  ?>" value="<?php  echo $fxrate;  ?>">
			 <input type="hidden" name="labfxamount[]" id="labfxamount<?php echo $sso;  ?>" value="<?php  echo $fxamount;  ?>">
             </div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  
               	<?php if($capitation_check=='1'){  ?>
               		<input type="checkbox" value="" checked="checked" disabled="disabled" />
				 		<input type="hidden" name="lref[]" id="reff<?php eval(base64_decode('IGVjaG8gJHNzbzsg')); ?>" value="<?php echo $sso; ?>"  checked=''/>
				 <?php  }else{ ?>
				 		<input type="checkbox" name="lref[]" id="reff<?php eval(base64_decode('IGVjaG8gJHNzbzsg')); ?>" value="<?php echo $sso; ?>" onClick="updatebox('<?php eval(base64_decode('IGVjaG8gJHNzbzsg')); ?>','<?php eval(base64_decode('IGVjaG8gJGxhYnJhdGU7')); ?>','<?php echo $numb; ?>')"/>
               		<?php } ?>
               </strong></div></td>
			  
			  <?php  }
			  }
			   ?>
			   <input type="hidden" name="finalno_lab" id="finalno_lab" value="<?php echo $numb;?>">

			   <?php  
			  $totalpharmacy=0;
			  $sso=0;
			  $numb=0;
			  $query19 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemname <> ''";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb=mysqli_num_rows($exec19);
			while($res19 = mysqli_fetch_array($exec19))
			{
			$pharmdate=$res19['entrydate'];
			$billnumber_pharmacyreturns=$res19['billnumber'];
			$medicinename=$res19['itemname'];
			$medicinecode=$res19['itemcode'];
			$medicinerate=$res19['rate'];
			$medicineqty=$res19['quantity'];
			$medicineqty=intval($medicineqty);
			$medicineamt=$res19['totalamount'];
			$pharmrefno=$res19['docnumber'];
			$fxrate=$res19['rate'];
			$fxamount=$res19['totalamount'];

			 $query28 = "select * from billing_paylaterpharmacy where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$medicinecode' ";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res28rows = mysqli_num_rows($exec28);
			// while($res28 = mysql_fetch_array($exec28)){		
				// $bill_number=$res28['billnumber'];
			// }
			if($res28rows==0){
				continue;
			}


			//////////// checking the partial medicine returns ////////////////
			// $finalizedbillnumber;
			$query_c2 = "select * from master_transactionpaylater where billnumber='$finalizedbillnumber' and transactiontype='finalize'  ";
			$exec_c2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_c2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res_c2rows = mysqli_num_rows($exec_c2);
			while($res_c2 = mysqli_fetch_array($exec_c2)){		
				$transactiondate2=$res_c2['transactiondate'];
				$transactiontime2=$res_c2['transactiontime'];
			}

			 $query_c3 = "select * from transaction_stock where tablename='pharmacysalesreturn_details' and itemcode='$medicinecode'  and entrydocno='$billnumber_pharmacyreturns'";
			$exec_c3 = mysqli_query($GLOBALS["___mysqli_ston"], $query_c3) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res_c3rows = mysqli_num_rows($exec_c3);
			while($res_c3 = mysqli_fetch_array($exec_c3)){		
				$transactiondate3=$res_c3['recorddate'];
				$transactiontime3=$res_c3['recordtime'];
			}

			 $datetime_bill = date('Y-m-d H:i:s', strtotime("$transactiondate2 $transactiontime2"));
			 $datetime_med = date('Y-m-d H:i:s', strtotime("$transactiondate3 $transactiontime3"));

			if($datetime_bill > $datetime_med){
				continue;
			}
			//////////// checking the partial medicine returns ////////////////closes

			
			$query80 = "select * from refund_paylaterpharmacy where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode = '$medicinecode'";
			$exec80 = mysqli_query($GLOBALS["___mysqli_ston"], $query80) or die ("Error in Query80".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res80rows = mysqli_num_rows($exec80);
			if($res80rows == 0)
			{
			//$numb -= 1;
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
			$sso=$sso+1;
			 ?>
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
			 	 <input type="hidden" name="pserialnumber[]" id="pserialnumber" value="<?php echo $sso; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNubyA9ICRzbm8gKyAxOyA=')); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHBoYXJtZGF0ZTsg')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHBoYXJtcmVmbm87IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php eval(base64_decode('ICBlY2hvICRtZWRpY2luZW5hbWU7IA==')); ?></div></td>
			 <input type="hidden" name="pharmsno[]" id="pharmsno" value="<?php echo $numb; ?>">
			 <input type="hidden" name="pharm[]" value="<?php eval(base64_decode('ICBlY2hvICRtZWRpY2luZW5hbWU7IA==')); ?>">
			 <input type="hidden" name="medicinecode[]" value="<?php echo $medicinecode; ?>">
			 <input type="hidden" name="pharmrate[]" id="pharmrate<?php echo $sso; ?>" value="<?php eval(base64_decode('IGVjaG8gJG1lZGljaW5lcmF0ZTsg')); ?>">
			 <input type="hidden" name="pharmqty[]" id="pharmqty<?php echo $sso; ?>" value="<?php echo $medicineqty; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJG1lZGljaW5lcXR5OyA=')); ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="center">
			 	<?php if($capitation_check=='1'){  ?>
			 			<?php echo $medicineqty;  ?>
						<input type="hidden" size="2" name="pharmrefundqty[]" id="pharmrefundqty<?php echo $sso; ?>" readonly style="background-color:#ecf0f5;" value="<?php echo $medicineqty; ?>">
			 		<?php  }else{ ?>
			 				<input type="text" size="2" name="pharmrefundqty[]" id="pharmrefundqty<?php echo $sso; ?>" readonly style="background-color:#ecf0f5;" value="<?php echo $medicineqty; ?>">
			 		<?php } ?>
			 </div></td>


			 <td class="bodytext31" valign="center"  align="left"><div align="center" id="pharmbal<?php echo $sso; ?>">&nbsp;</div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJG1lZGljaW5lcmF0ZTsg')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right" id="pharmdisptotal<?php echo $sso; ?>"><?php echo $medicineamt; ?></div></td>
			  <input type="hidden" name="pharmtotal[]" id="pharmtotal<?php echo $sso; ?>" value="<?php echo $medicineamt; ?>">
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $fxrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right" id="pharmdispfxamount<?php echo $sso; ?>"><?php echo $medicineamt; ?>
             </div></td>
             <input type="hidden" name="pharmfxrate[]" id="pharmfxrate<?php echo $sso;  ?>" value="<?php  echo $fxrate;  ?>">
			 <input type="hidden" name="pharmfxamount[]" id="pharmfxamount<?php echo $sso;  ?>" value="<?php  echo $medicineamt;  ?>">

			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input style="" type="checkbox" name="pref[]" value="<?php echo $sso; ?>" id="pharmreff<?php eval(base64_decode('IGVjaG8gJHNzbzsg')); ?>"  onClick="updatebox8('<?php eval(base64_decode('IGVjaG8gJHNzbzsg')); ?>','<?php eval(base64_decode('IGVjaG8gJG1lZGljaW5lbmFtZTsg')); ?>','<?php echo $numb; ?>')"/>

               	<input type="checkbox" name="dummy" value="" checked="checked" disabled="disabled" />
               </strong></div></td>
             
			  
			  <?php  }
			  }
			   ?>

			   <?php  
		
			$totalpharm = '0';
			 ?>
		
			    <?php  
				$totalrad=0;
				$sso1=0;
				$numb1=0;
			 	$query204 = "select * from billing_paylaterradiology where patientvisitcode='$visitcode' and patientcode='$patientcode' group by radiologyitemname";
			$exec204 = mysqli_query($GLOBALS["___mysqli_ston"], $query204) or die ("Error in Query204".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb1=mysqli_num_rows($exec204);
			while($res204 = mysqli_fetch_array($exec204))
			{
			$radname204=$res204['radiologyitemname'];
			$radiologyitemcode204=$res204['radiologyitemcode'];
			
		    // $query20 = "select * from billing_paylaterradiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname = '$radname204'";
		    $query20 = "select * from billing_paylaterradiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemcode = '$radiologyitemcode204'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$res20 = mysqli_fetch_array($exec20);
			
			$raddate=$res20['billdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['billnumber'];
			$fxrate=$res20['fxrate'];
			$fxamount=$res20['fxamount'];
			
			$query81 = "select * from refund_paylaterradiology where patientvisitcode='$visitcode' and patientcode='$patientcode'and radiologyitemcode = '$radiologyitemcode204'";
			// $query81 = "select * from refund_paylaterradiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname = '$radname'";
			$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query80".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res81rows = mysqli_num_rows($exec81);
			
			$totnum = $numb1 - $res81rows;
			if($totnum > 0)
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
			$totalrad=$totalrad+$radrate;
			$sso1=$sso1+1;
			 ?>
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>

			 	<input type="hidden" name="rserialnumber[]" id="rserialnumber" value="<?php echo $sso1; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNubyA9ICRzbm8gKyAxOyA=')); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHJhZGRhdGU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHJhZHJlZjsg')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php eval(base64_decode('IGVjaG8gJHJhZG5hbWU7IA==')); ?></div></td>
			 <input type="hidden" name="rad[]" value="<?php eval(base64_decode('IGVjaG8gJHJhZG5hbWU7IA==')); ?>">
			 <input type="hidden" name="radiologyitemcode204[]" value="<?php echo $radiologyitemcode204; ?>">
			  <input type="hidden" name="radrate[]" value="<?php eval(base64_decode('IGVjaG8gJHJhZHJhdGU7IA==')); ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?></div></td>


			 <td class="bodytext31" valign="center"  align="left"><div align="center">
			 	<?php if($capitation_check=='1'){  ?>
			 			<?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?>
			 	<input type="hidden" size="2" readonly style="background-color:#ecf0f5;" value="<?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?>">
			 	<?php  }else{ ?>
			 		<input type="text" size="2" readonly style="background-color:#ecf0f5;" value="<?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?>">
			 		<?php } ?>
			 </div></td>


             <td class="bodytext31" valign="center"  align="left"><div align="center">1</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJHJhZHJhdGU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJHJhZHJhdGU7IA==')); ?></div></td>
			 	  <input type="hidden" name="rate[]" id="rate1<?php eval(base64_decode('IGVjaG8gJHNzbzE7IA==')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHJhZHJhdGU7IA==')); ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $fxrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $fxamount; ?>
             <input type="hidden" name="radfxrate[]" id="radfxrate<?php echo $sso1;  ?>" value="<?php  echo $fxrate;  ?>">
			 <input type="hidden" name="radfxamount[]" id="radfxamount<?php echo $sso1;  ?>" value="<?php  echo $fxamount;  ?>">
             </div></td>
			  <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  
               	<?php if($capitation_check=='1'){  ?>
               		<input type="checkbox" value="" checked="checked" disabled="disabled" />
			 		<input type="checkbox" name="rref[]" id="reff1<?php eval(base64_decode('IGVjaG8gJHNzbzE7IA==')); ?>" value="<?php echo $sso1; ?>" onClick="updatebox1('<?php eval(base64_decode('IGVjaG8gJHNzbzE7IA==')); ?>','<?php eval(base64_decode('IGVjaG8gJHJhZHJhdGU7')); ?>','<?php echo $numb1; ?>')" checked=''/>
			 	<?php  }else{ ?>
			 			<input type="checkbox" name="rref[]" id="reff1<?php eval(base64_decode('IGVjaG8gJHNzbzE7IA==')); ?>" value="<?php echo $sso1; ?>" onClick="updatebox1('<?php eval(base64_decode('IGVjaG8gJHNzbzE7IA==')); ?>','<?php eval(base64_decode('IGVjaG8gJHJhZHJhdGU7')); ?>','<?php echo $numb1; ?>')"/>
			 		<?php } ?>
               </strong></div></td>
			  <?php  }
			  }
			   ?>
			   	<input type="hidden" name="finalno_rad" id="finalno_rad" value="<?php echo $totnum;?>">
			  	    <?php  
					$sersno=0;
					$totalser=0;
					$sso2=0;
					$totserqtyref = 0;
			  $query21 = "select * from billing_paylaterservices where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb2=mysqli_num_rows($exec21);
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['billdate'];
			$sercode = $res21['servicesitemcode'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$seramount1=$res21['amount'];
			$serref=$res21['billnumber'];
			$serqtyreq = $res21['serviceqty'];
			$serqq1 = $res21['serviceqty'];
			$fxrate=$res21['fxrate'];
			$fxamount=$res21['fxamount'];
			$refundquantity = 0;

			

			// $query82 = "select * from refund_paylaterservices where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname = '$sername'";
			$query82 = "select * from refund_paylaterservices where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode'";
			$exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die ("Error in Query82".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res82 = mysqli_fetch_array($exec82))
			{
			$res82qty = $res82['servicesitemqty'];
			$refundquantity = $refundquantity + $res82qty;
			}
			$serqty = $serqtyreq - $refundquantity;
			
			
			if($serqty > 0)
			{
			
			$seramount = $serqty * $serrate;
			$seramount = number_format($seramount,2,'.','');
			
			$sersno = $sersno + 1;
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
			$totalser=$totalser+$seramount;
			$sso2=$sso2+1;
			 ?>
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>

			 	<input type="hidden" name="sserialnumber[]" id="sserialnumber" value="<?php echo $sso2; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNubyA9ICRzbm8gKyAxOyA=')); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNlcmRhdGU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNlcnJlZjsg')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php eval(base64_decode('IGVjaG8gJHNlcm5hbWU7IA==')); ?></div></td>
			 <input type="hidden" name="ser[]" value="<?php eval(base64_decode('IGVjaG8gJHNlcm5hbWU7IA==')); ?>">
			 <input type="hidden" name="sercode[]" value="<?php echo $sercode; ?>">
			  <input type="hidden" name="servicerate[]" value="<?php eval(base64_decode('IGVjaG8gJHNlcnJhdGU7IA==')); ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo round($serqq1); ?></div>
			 <input type="hidden" name="reqserqty[]" id="reqserqty<?php echo $sersno; ?>" value="<?php echo $serqty; ?>">
			 </td>

			 <td class="bodytext31" valign="center"  align="left"><div align="center">
			 	
			 	<?php if($capitation_check=='1'){  ?>
			 			<?php echo $serqty;  ?>
						<input type="hidden" name="refundserqty[]" id="refundserqty<?php echo $sersno; ?>" size="2" value="<?php echo $serqty; ?>"  >
			 		<?php  }else{ ?>
			 				<input type="text" name="refundserqty[]" id="refundserqty<?php echo $sersno; ?>" size="2" value="<?php echo $serqty; ?>" onKeyUp="return chkser(<?php echo $sersno; ?>,<?php echo $numb2; ?>)">
			 		<?php } ?>

			 </div></td>


             <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJHNlcnJhdGU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><input type="text" name="refseramt[]" id="refseramt<?php echo $sersno; ?>" value="<?php echo $seramount; ?>" readonly size="6" style="text-align:right; border:none; background-color:transparent;"></div></td>
				  <input type="hidden" name="rate[]" id="rate2<?php eval(base64_decode('IGVjaG8gJHNzbzI7IA==')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHNlcnJhdGU7IA==')); ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $fxrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">
             <input type="hidden" name="serfxrate[]" id="serfxrate<?php echo $sso2;  ?>" value="<?php  echo $fxrate;  ?>">
			 <input type="text" name="serfxamount[]" id="serfxamount<?php echo $sso2;  ?>" value="<?php  echo $fxamount;  ?>" readonly style="text-align:right; border:none; background-color:transparent;">
             </div></td>

			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong> 

               		<?php if($capitation_check=='1'){  ?>
               			<input type="checkbox" checked="checked" disabled="disabled" />
			 		 <input type="hidden" name="sref[]" id="reff2<?php eval(base64_decode('IGVjaG8gJHNzbzI7IA==')); ?>" value="<?php echo $sso2; ?>" onClick="updatebox2('<?php eval(base64_decode('IGVjaG8gJHNzbzI7IA==')); ?>','<?php eval(base64_decode('IGVjaG8gJHNlcnJhdGU7')); ?>','<?php echo $numb2; ?>')" checked=''/>
			 	<?php  }else{ ?>
			 			 <input type="checkbox" name="sref[]" id="reff2<?php eval(base64_decode('IGVjaG8gJHNzbzI7IA==')); ?>" value="<?php echo $sso2; ?>" onClick="updatebox2('<?php eval(base64_decode('IGVjaG8gJHNzbzI7IA==')); ?>','<?php eval(base64_decode('IGVjaG8gJHNlcnJhdGU7')); ?>','<?php echo $numb2; ?>')"/>
			 		<?php } ?>
               </strong></div></td>
			  
			  <?php  }
			  }
			   ?>
			   <input type="hidden" name="finalno_ser" id="finalno_ser" value="<?php echo $sso2; ?>">
			   <?php  
			   $totalref=0;
			   $sso4=0;
			  $query22 = "select * from billing_paylaterreferal where patientvisitcode='$visitcode' and patientcode='$patientcode' and referalname <> ''";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numbb=mysqli_num_rows($exec22);
			while($res22 = mysqli_fetch_array($exec22))
			{
			$refdate=$res22['billdate'];
			$refname=$res22['referalname'];
			$referalcode=$res22['referalcode'];
			$refrate=$res22['referalrate'];
			$refref=$res22['billnumber'];
			$fxrate=$res22['fxrate'];
			$fxamount=$res22['fxamount'];
			$ref_consultation_percentage=$res22['consultation_percentage'];
			
			$queryref1 = "select * from refund_paylaterreferal where referalcode = '$referalcode' and patientvisitcode='$visitcode' and patientcode='$patientcode'";
			// $queryref1 = "select * from refund_paylaterreferal where referalname = '$refname' and patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$execref1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryref1) or die ("Error in Queryref1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numref1=mysqli_num_rows($execref1);
			if($numref1 == 0)
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
			$totalref=$totalref+$refrate;
			$sso4=$sso4+1;
			 ?>
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>

			 	<input type="hidden" name="ref_serialnumber[]" id="ref_serialnumber" value="<?php echo $sso4; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNubyA9ICRzbm8gKyAxOyA=')); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHJlZmRhdGU7IA==')); ?></div></td>
			  <input type="hidden" name="referalname[]" value="<?php eval(base64_decode('IGVjaG8gJHJlZm5hbWU7IA==')); ?>">
			  <input type="hidden" name="referalcode[]" value="<?php echo $referalcode; ?>">
			  <input type="hidden" name="referalrate[]" value="<?php eval(base64_decode('IGVjaG8gJHJlZnJhdGU7IA==')); ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHJlZnJlZjsg')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php eval(base64_decode('IGVjaG8gJHJlZm5hbWU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="2" value="1" readonly style="background-color:#ecf0f5;"></div></td>

			 <td class="bodytext31" valign="center" align="left"><div align="center">1</div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJHJlZnJhdGU7IA==')); ?></div></td>
			 <input type="hidden" name="rate[]" id="rate4<?php eval(base64_decode('IGVjaG8gJHNzbzQ7IA==')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHJlZnJhdGU7IA==')); ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJHJlZnJhdGU7IA==')); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $fxrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $fxamount; ?>
             <input type="hidden" name="reffxrate[]" id="reffxrate<?php echo $sso4;  ?>" value="<?php  echo $fxrate;  ?>">
			 <input type="hidden" name="reffxamount[]" id="reffxamount<?php echo $sso4;  ?>" value="<?php  echo $fxamount;  ?>">
			 <input type="hidden" name="refconsultation_percentage[]" id="refconsultation_percentage<?php echo $sso4;  ?>" value="<?php  echo $ref_consultation_percentage;  ?>">
             </div></td>


			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  

               		<?php if($capitation_check=='1'){  ?>
						<input type="checkbox" value="" checked="checked" disabled="disabled" />
			 		<input type="hidden" name="ref_ref[]" id="reff4<?php eval(base64_decode('IGVjaG8gJHNzbzQ7IA==')); ?>" value="<?php echo $sso4; ?>" onClick="updatebox4('<?php eval(base64_decode('IGVjaG8gJHNzbzQ7IA==')); ?>','<?php eval(base64_decode('IGVjaG8gJHJlZnJhdGU7')); ?>','<?php eval(base64_decode('IGVjaG8gJG51bWJiOyA=')); ?>')" checked=''/>
			 	<?php  }else{ ?>
			 			<input type="checkbox" name="ref_ref[]" id="reff4<?php eval(base64_decode('IGVjaG8gJHNzbzQ7IA==')); ?>" value="<?php echo $sso4; ?>" onClick="updatebox4('<?php eval(base64_decode('IGVjaG8gJHNzbzQ7IA==')); ?>','<?php eval(base64_decode('IGVjaG8gJHJlZnJhdGU7')); ?>','<?php eval(base64_decode('IGVjaG8gJG51bWJiOyA=')); ?>')"/>
			 		<?php } ?>

               </strong></div></td>
             
			  
			  <?php  }
			  }
			   ?>
			    <input type="hidden" name="finalno_refer" id="finalno_refer" value="<?php echo $sso4;?>">
			    <?php  
			   $totalambulance=0;
			   $amb1=0;
			  $query22a = "select * from billing_opambulancepaylater where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec22a = mysqli_query($GLOBALS["___mysqli_ston"], $query22a) or die ("Error in Query22a".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numbba=mysqli_num_rows($exec22a);
			while($res22a = mysqli_fetch_array($exec22a))
			{
			$ambdate=$res22a['recorddate'];
			$ambname=$res22a['description'];
			$ambrate=$res22a['rate'];
			$ambamount=$res22a['amount'];
			$ambunit=$res22a['quantity'];
			$ambunit12=$res22a['quantity'];
			$ambbillno = $res22a['billnumber'];
			$ambdoc = $res22a['docno'];
			$fxrate=$res22a['fxrate'];
			$fxamount=$res22a['fxamount'];
			$refundquantity1 = 0;
			
			$query83 = "select * from refund_paylaterambulance where patientvisitcode='$visitcode' and patientcode='$patientcode' and description = '$ambname'";
			$exec83 = mysqli_query($GLOBALS["___mysqli_ston"], $query83) or die ("Error in Query83".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res83 = mysqli_fetch_array($exec83))
			{
			$res83qty = $res83['quantity'];
			$refundquantity1 = $refundquantity1 + $res83qty;
			}
			$ambunit = $ambunit - $refundquantity1;
			
			
			if($ambunit > 0)
			{
			$ambamount=$ambunit*$ambrate;
			$ambamount=number_format($ambamount,2);
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
			$totalambulance=$totalambulance+$ambamount;
			$amb1=$amb1+1;
			 ?>
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1;  ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambdate;  ?></div></td>
			  <input type="hidden" name="ambname[]" value="<?php echo $ambname; ?>">
			  <input type="hidden" name="ambrate[]" value="<?php echo $ambrate; ?>">
			  <input type="hidden" name="ambdoc[]" value="<?php echo $ambdoc; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambbillno;  ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php  echo $ambname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambunit12;  ?></div></td>


			 <td class="bodytext31" valign="center"  align="left"><div align="center">
			 		<?php if($capitation_check=='1'){  ?>
			 			<?php echo $ambunit;  ?>
						<input type="hidden" name="refambqty[]" id="refambqty<?php echo $amb1; ?>" size="2" value="<?php echo $ambunit;  ?>"  >
			 		<?php  }else{ ?>
			 				<input type="text" name="refambqty[]" id="refambqty<?php echo $amb1; ?>" size="2" value="<?php echo $ambunit;  ?>" onKeyUp="return chkamb(<?php echo $amb1; ?>,<?php echo $numbba; ?>)">
			 		<?php } ?>

			 </div></td>


             <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambunit;  ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php  echo $ambrate;  ?></div></td>
			 <input type="hidden" name="ambrate4[]" id="ambrate4<?php echo $amb1;  ?>" value="<?php  echo $ambamount;  ?>">
			 <input type="hidden" name="reqambrate[]" id="reqambrate<?php echo $amb1;  ?>" value="<?php  echo $ambrate;  ?>">
			 <input type="hidden" name="reqambqty[]" id="reqambqty<?php echo $amb1;  ?>" value="<?php  echo $ambunit;  ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><input type="text" size="5" name="ambamt4[]" id="ambamt4<?php echo $amb1;  ?>" value="<?php  echo $ambamount;  ?>" readonly style="background-color:transparent; text-align:right; border:none;"></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $fxrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">
             <input type="hidden" name="ambfxrate[]" id="ambfxrate<?php echo $amb1;  ?>" value="<?php  echo $fxrate;  ?>">
			 <input type="text" name="ambfxamount[]" id="ambfxamount<?php echo $amb1;  ?>" value="<?php  echo $fxamount;  ?>"readonly style="background-color:transparent; text-align:right; border:none;">
             </div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  


               		<?php if($capitation_check=='1'){  ?>
					<input type="checkbox"  value="" checked="checked" disabled="disabled" />
			 			<input type="hidden" name="ref[]" id="reffamb4<?php echo $amb1;  ?>" value="<?php echo $ambname;  ?>" onClick="updateboxamb('<?php echo $amb1;  ?>','<?php echo $ambrate; ?>','<?php echo $numbba;  ?>')" checked=''/>
			 	<?php  }else{ ?>
			 			<input type="checkbox" name="ref[]" id="reffamb4<?php echo $amb1;  ?>" value="<?php echo $ambname;  ?>" onClick="updateboxamb('<?php echo $amb1;  ?>','<?php echo $ambrate; ?>','<?php echo $numbba;  ?>')"/>
			 		<?php } ?>

               </strong></div></td>
             
			  
			  <?php  }
			  }
			   ?>
			    <input type="hidden" name="finalno_ambulance" id="finalno_ambulance" value="<?php echo $amb1;?>">
			    <?php  
			   $totalhome=0;
			   $home1=0;
			  $query22b = "select * from billing_homecarepaylater where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec22b = mysqli_query($GLOBALS["___mysqli_ston"], $query22b) or die ("Error in Query22b".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numbbb=mysqli_num_rows($exec22b);
			while($res22b = mysqli_fetch_array($exec22b))
			{
			$homedate=$res22b['recorddate'];
			$homename=$res22b['description'];
			$homerate=$res22b['rate'];
			$homeamount=$res22b['amount'];
			$homeunit=$res22b['quantity'];
			$homeunit12=$res22b['quantity'];
			$homebillno = $res22b['billnumber'];
			$homedoc = $res22b['docno'];
			$fxrate=$res22b['fxrate'];
			$fxamount=$res22b['fxamount'];
			$refundquantity2 = 0;
			
			$query84 = "select * from refund_paylaterhomecare where patientvisitcode='$visitcode' and patientcode='$patientcode' and description = '$homename'";
			$exec84 = mysqli_query($GLOBALS["___mysqli_ston"], $query84) or die ("Error in Query84".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res84 = mysqli_fetch_array($exec84))
			{
			$res84qty = $res84['quantity'];
			$refundquantity2 = $refundquantity2 + $res84qty;
			}
			$homeunit = $homeunit - $refundquantity2;
			
			
			if($homeunit > 0)
			{
			$homeamount=$homeunit * $homerate;
			$homeamount = number_format($homeamount,2);
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
			$totalhome=$totalhome+$homeamount;
			$home1=$home1+1;
			 ?>
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1;  ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $homedate;  ?></div></td>
			  <input type="hidden" name="homename[]" value="<?php echo $homename; ?>">
			  <input type="hidden" name="homerate[]" value="<?php echo $homerate; ?>">
			  <input type="hidden" name="homedoc[]" value="<?php echo $homedoc; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $homebillno;  ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php  echo $homename; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $homeunit12;  ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="center">
			 	<?php if($capitation_check=='1'){  ?>
			 			<?php echo $homeunit;  ?>
						<input type="hidden" name="refhomeqty[]" id="refhomeqty<?php echo $home1; ?>" size="2" value="<?php echo $homeunit;  ?>" onKeyUp="return chkhome(<?php echo $home1; ?>,<?php echo $numbbb; ?>)">
			 		<?php  }else{ ?>
			 				<input type="text" name="refhomeqty[]" id="refhomeqty<?php echo $home1; ?>" size="2" value="<?php echo $homeunit;  ?>" onKeyUp="return chkhome(<?php echo $home1; ?>,<?php echo $numbbb; ?>)">
			 		<?php } ?>
			 </div></td>


             <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $homeunit;  ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php  echo $homerate;  ?></div></td>
			 <input type="hidden" name="homerate4[]" id="homerate4<?php echo $home1;  ?>" value="<?php  echo $homeamount;  ?>">
			 <input type="hidden" name="reqhomerate[]" id="reqhomerate<?php echo $home1;  ?>" value="<?php  echo $homerate;  ?>">
			 <input type="hidden" name="reqhomeqty[]" id="reqhomeqty<?php echo $home1;  ?>" value="<?php  echo $homeunit;  ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><input type="text" size="5" name="homeamt4[]" id="homeamt4<?php echo $home1;  ?>" value="<?php  echo $homeamount;  ?>" readonly style="background-color:transparent; text-align:right; border:none;"></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $fxrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">
             <input type="hidden" name="homefxrate[]" id="homefxrate<?php echo $home1;  ?>" value="<?php  echo $fxrate;  ?>">
			 <input type="text" name="homefxamount[]" id="homefxamount<?php echo $home1;  ?>" value="<?php  echo $fxamount;  ?>" readonly style="background-color:transparent; text-align:right; border:none;">
             </div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  

               		<?php if($capitation_check=='1'){  ?>
               			<input type="checkbox" value="" checked="checked" disabled="disabled" />
						<input type="hidden" name="ref[]" id="reffhome4<?php echo $home1;  ?>" value="<?php echo $homename;  ?>" onClick="updateboxhome('<?php echo $home1;  ?>','<?php echo $homerate; ?>','<?php echo $numbbb;  ?>')" checked=''/>
			 	<?php  }else{ ?>
			 			<input type="checkbox" name="ref[]" id="reffhome4<?php echo $home1;  ?>" value="<?php echo $homename;  ?>" onClick="updateboxhome('<?php echo $home1;  ?>','<?php echo $homerate; ?>','<?php echo $numbbb;  ?>')"/>
			 		<?php } ?>
               </strong></div></td>
             
			  
			  <?php  }
			  }
			   ?>
			    <input type="hidden" name="finalno_homecare" id="finalno_homecare" value="<?php echo $home1;?>">
			  <?php 
			  // echo $colorloopcount;
			 $totalop=str_replace(',', '',$totalop);
			   
			   
			    $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhome)-$totalcopay;
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop-$totalcopay;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhome;
			   $netpay=number_format($netpay,2,'.','');
			   ?>
			  <tr>
			  	 	<input type="hidden" name="finalno" id="finalno" value="<?php echo $colorloopcount;?>">
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>
				<input type="text" name="totalrefund[]" id="totalrefund" value="<?php //eval(base64_decode('IGVjaG8gJG92ZXJhbGx0b3RhbDsg')); ?>" readonly size="6" style="text-align:right; border:none; background-color:transparent;"></strong></td>
				 <td width="4%"  align="left" valign="center" 
               class="bodytext31" bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>
             
			 </tr>
          </tbody>
        </table>		</td>
		<tr>
		 <td colspan="7" class="bodytext31" valign="center"  align="left" >&nbsp;</td>
		</tr>
		<tr>
		<td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
		 <tr bgcolor="#011E6A">
                <td colspan="7" bgcolor="#ecf0f5" class="bodytext32"><strong>Payable Details</strong></td>
			 </tr>
          <tr>
		    <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
              <td width="37%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">Total for Consultation</div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><input type="text" name="totalamtconsultation" id="totalamtconsultation" size="7" class="bal" readonly></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><input type="text" name="totalfxamtconsultation" id="totalfxamtconsultation" size="7" class="bal" readonly></div></td>
				 <td width="15%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div>
				
				</td>
			
			</tr>
				
				<tr>
				  <td width="26%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div>
				</td>
			
                <td width="31%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Pharmacy</div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><input type="text" name="totalamtpharm" id="totalamtpharm" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="right"><strong><input type="text" name="totalfxamtpharm" id="totalfxamtpharm" size="7" class="bal" readonly></strong></div></td>
			<td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div>
				</td>
				</tr>

				<tr>
				  <td width="26%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div>
				</td>
			
                <td width="31%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Laboratory</div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><input type="text" name="totalamtlab" id="totalamtlab" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong><input type="text" name="totalfxamtlab" id="totalfxamtlab" size="7" class="bal" readonly></strong></div></td>
			<td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div>
				</td>
				</tr>

				<tr>
				  <td width="26%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
					<td width="31%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Radiology </div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><input type="text" name="totalamtrad" id="totalamtrad" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="right"><strong><input type="text" name="totalfxamtrad" id="totalfxamtrad" size="7" class="bal" readonly></strong></div></td>
                <td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div>
				</td>
			
				</tr>
				<tr>
				  <td width="26%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="31%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Service	</div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><input type="text" name="totalamtser" id="totalamtser" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong><input type="text" name="totalfxamtser" id="totalfxamtser" size="7" class="bal" readonly></strong></div></td>
				<td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div>
				</td>
				</tr>
				<tr>
				  <td width="26%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="31%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Referral		</div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><input type="text" name="totalamtref" id="totalamtref" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="right"><strong><input type="text" name="totalfxamtref" id="totalfxamtref" size="7" class="bal" readonly></strong></div></td>
				<td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div>
				</td>
				</tr>
				<!-- <tr>
				  <td width="26%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td> -->
			
				<!-- <td width="31%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Ambulance		</div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"> -->
                <input type="hidden" name="totalamtamb" id="totalamtamb" size="7" class="bal" readonly>
           <!--  </div>
                </td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong> -->
                	<input type="hidden" name="totalfxamtamb" id="totalfxamtamb" size="7" class="bal" readonly>
               <!--  </strong>
                </div></td>
				<td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div>
				</td> -->
				<!-- </tr> -->
				<!-- <tr>
				  <td width="26%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="31%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Homecare		</div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"> -->
                	<input type="hidden" name="totalamthome" id="totalamthome" size="7" class="bal" readonly>
                <!-- </div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="right"><strong> -->
                	<input type="hidden" name="totalfxamthome" id="totalfxamthome" size="7" class="bal" readonly>
                <!-- </strong></div></td>
				<td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
				</tr> -->
				<tr>
				  <td width="26%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="center"><strong>&nbsp;</strong></div></td>
			
              <td width="31%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Net Payable	</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><input type="text" name="grandtotalamount" id="grandtotalamount" value="" class="bal" size="7" readonly=""></strong></div></td>
				
				  <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                	<input type="text" name="grandfxtotalamount" id="grandfxtotalamount" value="" class="bal" size="7" readonly=""></strong>
                </div></td>
                <td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="center"><strong>&nbsp;</strong></div></td>
			
            </tr>
				  </tbody>
				  </table>				  </td>
				    <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="left"><strong>User Name</strong> <span class="bodytext3">
                 <?php eval(base64_decode('IGVjaG8gJF9TRVNTSU9OWyd1c2VybmFtZSddOyA=')); ?>
                </span></div></td>
                <td height="32" colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				    </tr>
				  
      </tr>
      
     
      <tr>
        
		 	<td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		  		<input type="hidden" name="frm1submit1" value="frm1submit1" />
                  	<input type="hidden" name="loopcount" value="<?php eval(base64_decode('IGVjaG8gJGkgLSAxOyA=')); ?>" />
                  	<?php if(($balanceqty1>0) && ($capitation_check=='1')) {  ?>
                  		<input disabled="" name="Submit222" type="submit"  <?php   if($numb_12>0){ echo 'disabled'; } ?> value="Save Bill" class="button"  style="border: 1px solid #001E6A" />		
                  	<?php }else{ ?>
                  			<input name="Submit222" type="submit"  <?php   if($numb_12>0){ echo 'disabled'; } ?> value="Save Bill" class="button" style="border: 1px solid #001E6A"/>	
                  		<?php } ?>
            </td>
      </tr>
      </td>
      </tr>
    </table>
</form>
<?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9mb290ZXIxLnBocCIpOyA=')); ?>
<?php eval(base64_decode('IC8vaW5jbHVkZSAoInByaW50X2JpbGxfZG1wNGluY2gxLnBocCIpOyA=')); ?>

<script type="text/javascript">
	function onloadtotals_rad(){
		var capitation_checkf=document.getElementById("capitation_checkf").value;
					if(capitation_checkf>0){
				var k;
				var finalno_rad=document.getElementById("finalno_rad").value;
				// alert(finalno_rad);
					if(finalno_rad>0){
						for(k=1;k<=finalno_rad;k++)
						{
							var radfxamount=document.getElementById("radfxamount"+k+"").value;
									updatebox1(k,radfxamount,finalno_rad);
						}
					}
				}
			}

function onloadtotals_lab(){
var capitation_checkf=document.getElementById("capitation_checkf").value;
	// alert(capitation_checkf);
if(capitation_checkf>0){
	updatebox3();
	var k;
	var finalno_lab=document.getElementById("finalno_lab").value;
	// alert(finalno_lab);
		if(finalno_lab>0){
			for(k=1;k<=finalno_lab;k++)
			{
				var labrate=document.getElementById("labfxamount"+k+"").value;
				// alert(rate);
				updatebox(k,labrate,finalno_lab);
				
			}
		}
		

		// SERVICES
			var finalno_ser=document.getElementById("finalno_ser").value;
				// alert(finalno_ser);
			if(finalno_ser>0){
				for(k=1;k<=finalno_ser;k++)
				{
					var serrate=document.getElementById("serfxamount"+k+"").value;
					// alert(rate);
					updatebox2(k,serrate,finalno_ser);
					
				}
			}
		// SERVICES
		// REFERAL
			var finalno_refer=document.getElementById("finalno_refer").value;
				// alert(finalno_refer);
			if(finalno_refer>0){
				for(k=1;k<=finalno_refer;k++)
				{
					var refrate=document.getElementById("reffxamount"+k+"").value;
					// alert(rate);
					updatebox4(k,refrate,finalno_refer);
					
				}
			}
		// REFERAL
		// AMBULANCE
			var finalno_ambulance=document.getElementById("finalno_ambulance").value;
				// alert(finalno_ambulance);
			if(finalno_ambulance>0){
				for(k=1;k<=finalno_ambulance;k++)
				{
					var refrate=document.getElementById("ambfxamount"+k+"").value;
					updateboxamb(k,refrate,finalno_ambulance);
					
				}
			}
		// AMBULANCE

		// HOME CARE
			var finalno_homecare=document.getElementById("finalno_homecare").value;
				// alert(finalno_homecare);
			if(finalno_homecare>0){
				for(k=1;k<=finalno_homecare;k++)
				{
					var refrate=document.getElementById("homefxamount"+k+"").value;
					updateboxhome(k,refrate,finalno_homecare);
					
				}
			}
		// HOME CARE
}
}

</script>

<script type="text/javascript">
// $( document ).ready(function() {
// 	var sno = document.getElementById('pharmsno').value;
// 	for(var i=1; i<=sno; i++){
// 	    $("#pharmreff"+i).trigger('click', {
// 	    })

// 	    // document.getElementById('pharmreff'+i).disabled = true;
// 	     $('#pharmreff'+i).hide();
// 	}


// 	var finalno_rad=document.getElementById("finalno_rad").value;
// 	for(var i=1; i<=finalno_rad; i++){
// 	    $("#reff1"+i).trigger('change', {
// 	    })
// 	     // $('#reff1'+i).hide();
// 	}

// 	var finalno_lab=document.getElementById("finalno_lab").value;
// 	for(var i=1; i<=finalno_lab; i++){
// 		alert(finalno_lab);
// 	    $("#reff"+i).trigger('change', {
// 	    })
// 	     // $('#reff'+i).hide();
// 	}

// 	var finalno_ser=document.getElementById("finalno_ser").value;
// 	for(var i=1; i<=finalno_ser; i++){
// 	    $("#reff2"+i).trigger('change', {
// 	    })
// 	     // $('#reff2'+i).hide();
// 	}



// });
</script>

</body>
</html>