<?php
session_start();
ob_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");
include ("residental_doctor_func.php");

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
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$pharmacy_fxrate=2872.49;

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
billnumbercreate:
	//get locationcode and locationname for inserting
 $locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
 $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
//get ends here    
    
    $eclaim=$_REQUEST["eclaim"];
	$frm1submitslade=$_REQUEST["frm1submitslade"];
	$payercode=$_REQUEST["payercode"];
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["patientcode"];
	$patientname = $_REQUEST["patientname"];
	$patientbilltype = $_REQUEST['patientbilltype'];
	$packagecoa = $_REQUEST['packagecoa'];
		$labcoa = $_REQUEST['labcoa'];
		$radiologycoa = $_REQUEST['radiologycoa'];
		$servicecoa = $_REQUEST['servicecoa'];
		$pharmacycoa = $_REQUEST['pharmacycoa'];
		$referalcoa = $_REQUEST['referalcoa'];
		$cashcoa = $_REQUEST['cashcoa'];
		$chequecoa = $_REQUEST['chequecoa'];
		$cardcoa = $_REQUEST['cardcoa'];
		$mpesacoa = $_REQUEST['mpesacoa'];
		$onlinecoa = $_REQUEST['onlinecoa'];
		$bedchargescoa = $_REQUEST['bedchargescoa'];
		$rmocoa = $_REQUEST['rmocoa'];
		$nursingcoa = $_REQUEST['nursingcoa'];
		$accomodationcoa = $_REQUEST['accomodationcoa'];
		$cafeteriacoa = $_REQUEST['cafeteriacoa'];
		$privatedoctorcoa = $_REQUEST['privatedoctorcoa'];
		$ambulancecoa = $_REQUEST['ambulancecoa'];
		$nhifcoa = $_REQUEST['nhifcoa'];
		$otbillingcoa = $_REQUEST['otbillingcoa'];
		$miscbillingcoa = $_REQUEST['miscbillingcoa'];
		$admissionchargecoa = $_REQUEST['admissionchargecoa'];
		$totalrevenue = $_REQUEST['totalrevenue'];
		$discount = $_REQUEST['discount'];
		$deposit = $_REQUEST['deposit'];
		$nhif = $_REQUEST['nhif'];
		$ipdepositscoa = $_REQUEST['ipdepositscoa'];
		$returnbalance = $_REQUEST['returnbalance'];
		$authorization_code=$_REQUEST['authorization_code'];
		
	$accountcode= $_REQUEST['accountcode'];
	$accountname= $_REQUEST['accountname'];
	$accountnameano= $_REQUEST['accountnameano'];
	$subtype = $_REQUEST['subtype'];
	$subtypeano = $_REQUEST['subtypeano'];
	$paymenttype = $_REQUEST['paymenttype'];
	$totalamount= $_REQUEST['netpayable'];
	$overalltotal = $_REQUEST['overalltotal'];
	
	$preauthcode = $_REQUEST['preauthcode'];
	
	$totalamountuhx=$_REQUEST['netpayableuhx'];
	$fxrate=$_REQUEST['fxrate'];
	$curtype=$_REQUEST['curtype'];
	$currency=$curtype;

	$slade_claim_id=$_REQUEST["slade_claim_id"];
	$offpatient=$_REQUEST['offpatient'];
	
	//this is for update master_customer ipdue
	$ipduevalue=0;
	$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select ipdue, ipplandue from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
 $ipduevalue=$execlab['ipdue'];
 $ipplandue=$execlab['ipplandue'];
 $ipduevalue=$ipduevalue+$overalltotal;
 $ipplandue = $ipplandue+$overalltotal;
 $query = mysqli_query($GLOBALS["___mysqli_ston"], "select * from billing_ip where visitcode = '$visitcode'") or die("error in getting billing ".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($query)==0)
{
 mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE  master_customer SET ipdue = '".$ipduevalue."', ipplandue = '".$ipplandue."' where customercode='$patientcode'");
 //exit();
 
$query7691 = "select * from master_financialintegration where field='externaldoctors'";
$exec7691 = mysqli_query($GLOBALS["___mysqli_ston"], $query7691) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res7691 = mysqli_fetch_array($exec7691);
$debitcoa = $res7691['code'];

$query_bill_location = "select auto_number from master_location where locationcode = '$locationcodeget'";
$exec_bill_loctation = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill_location) or die ("Error in Query_bill_location".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res_bill_loct = mysqli_fetch_array($exec_bill_loctation);
$location_num = $res_bill_loct['auto_number'];
$query_bill = "select prefix from bill_formats where description = 'bill_ip'";
$exec_bill = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill) or die ("Error in Query_bill".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res_bill = mysqli_fetch_array($exec_bill);
$paylaterbillprefix = $res_bill['prefix'];
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_ip order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix."-".'1'."-".date('y')."-".$location_num;
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	//$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo $billnumbercode;
	$pieces = explode('-', $billnumber);
	$new_billnum=$pieces[1];
	$billnumbercode = intval($new_billnum);
	$billnumbercode=abs($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paylaterbillprefix."-".$maxanum."-".date('y')."-".$location_num;
	$openingbalance = '0.00';
	//echo $companycode;
}

$billno= $billnumbercode;

	
$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ip(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,patientbilltype,totalrevenue,discount,deposit,nhif,depositcoa,paymenttype,locationname,locationcode,accountcode,totalamountuhx,curtype,fxrate,accountnameano,accountnameid,slade_claim_id,preauthcode)values('$billno','$patientname','$patientcode','$visitcode','$totalamount','$currentdate','$accountname','$subtype','$patientbilltype','$totalamount','$discount','$deposit','$nhif','$ipdepositscoa','$paymenttype','".$locationnameget."','".$locationcodeget."','$accountcode','".$totalamountuhx."','".$curtype."','".$fxrate."','$accountnameano','$accountcode','$slade_claim_id','$preauthcode')");
if( mysqli_errno($GLOBALS["___mysqli_ston"]) == 1062) {
goto billnumbercreate;
}
else if(mysqli_errno($GLOBALS["___mysqli_ston"]) > 0){
die ("Error in referalquery1".mysqli_error($GLOBALS["___mysqli_ston"]));
}

	if($patientbilltype == 'PAY NOW')
	{
	$cash = $_REQUEST['cash'];
	if($cash == '')
	{
	$cash = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,source,locationname,locationcode,fxrate,curtype)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$cash','$cashcoa','ipfinalinvoice','".$locationnameget."','".$locationcodeget."','".$fxrate."','".$curtype."')";
    $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
	}
	$cheque = $_REQUEST['cheque'];
	if($cheque == '')
	{
	$cheque = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,source,locationname,locationcode,fxrate,curtype)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$cheque','$chequecoa','ipfinalinvoice','".$locationnameget."','".$locationcodeget."','".$fxrate."','".$curtype."')";
    $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
	}
	$chequenumber = $_REQUEST['chequenumber1'];
	if($chequenumber == '')
	{
	$chequenumber = 0;
	}
	
	$online = $_REQUEST['online'];
	if($online == '')
	{
	$online = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,source,locationname,locationcode,fxrate,curtype)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$online','$onlinecoa','ipfinalinvoice','".$locationnameget."','".$locationcodeget."','".$fxrate."','".$curtype."')";
    $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
	}
	$onlinenumber = $_REQUEST['onlinenumber1'];
	if($onlinenumber == '')
	{
	$onlinenumber = 0;
	}
	$creditcard = $_REQUEST['creditcard'];
	if($creditcard == '')
	{
	$creditcard = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,source,locationname,locationcode,fxrate,curtype)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$creditcard','$cardcoa','ipfinalinvoice','".$locationnameget."','".$locationcodeget."','".$fxrate."','".$curtype."')";
    $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
	}
	$creditcardnumber = $_REQUEST['creditcardnumber1'];
	if($creditcardnumber == '')
	{
	$creditcardnumber = 0;
	}
	$mpesa = $_REQUEST['mpesa'];
	if($mpesa == '')
	{
	$mpesa = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,source,locationname,locationcode,fxrate,curtype)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$mpesa','$mpesacoa','ipfinalinvoice','".$locationnameget."','".$locationcodeget."','".$fxrate."','".$curtype."')";
    $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
	}
	$mpesanumber = $_REQUEST['mpesanumber1'];
	if($mpesanumber == '')
	{
	$mpesanumber = 0;
	}
	}
	else
	{
	$cash = 0;
	$cheque = 0;
	$chequenumber = 0;
	$online = 0;
	$onlinenumber = 0;
	$creditcard = 0;
	$creditcardnumber = 0;
	$mpesa = 0;
	$mpesanumber = 0;

	}
	
	
if(isset($_POST['description']))
{
foreach($_POST['description'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$descriptionname=$_POST['description'][$key];
		if($descriptionname == 'Bed Charges')
		{
		$coa = $bedchargescoa;
		}
		else if($descriptionname == 'Nursing Charges')
		{
		$coa = $nursingcoa;
		}
		else if($descriptionname == 'RMO Charges')
		{
		$coa = $rmocoa;
		}
		else if($descriptionname == 'Accommodation Charges')
		{
		$coa = $accomodationcoa;
		}
		else if($descriptionname == 'Cafetaria Charges')
		{
		$coa = $cafeteriacoa;
		}
		else
		{
		$coa = $packagecoa;
		}
		$descriptionrate=$_POST['descriptionrate'][$key];
		$descriptionamount=$_POST['descriptionamount'][$key];
		$descriptionquantity=$_POST['descriptionquantity'][$key];
		$descriptiondocno=$_POST['descriptiondocno'][$key];
		
		$descriptionrateuhx=$_POST['descriptionrateuhx'][$key];
		$descriptionamountuhx=$_POST['descriptionamountuhx'][$key];
		
		
		if($descriptionname!="")
		{
		$query71 = "insert into billing_ipbedcharges(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,rateuhx,amountuhx)values('$descriptionname','$descriptionrate','$descriptionquantity','$descriptionamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa','".$locationnameget."','".$locationcodeget."','".$descriptionrateuhx."','".$descriptionamountuhx."')";
		$exec71=mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		}
		if(isset($_POST['descriptioncharge']))
		{
		foreach($_POST['descriptioncharge'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$descriptioncharge=$_POST['descriptioncharge'][$key];
		if($descriptioncharge == 'Bed Charges')
		{
		$coa = $bedchargescoa;
		}
		if($descriptioncharge == 'Nursing Charges')
		{
		$coa = $nursingcoa;
		}
		if($descriptioncharge == 'RMO Charges')
		{
		$coa = $rmocoa;
		}
		if($descriptioncharge == 'Accommodation Charges')
		{
		$coa = $accomodationcoa;
		}
		if($descriptioncharge == 'Cafetaria Charges')
		{
		$coa = $cafeteriacoa;
		}
		$descriptionchargerate=$_POST['descriptionchargerate'][$key];
	    $descriptionchargeamount=$_POST['descriptionchargeamount'][$key];
		$descriptionchargequantity=$_POST['descriptionchargequantity'][$key];
		$descriptionchargedocno=$_POST['descriptionchargedocno'][$key];
		$descriptionchargeward=$_POST['descriptionchargeward'][$key];
		$descriptionchargebed=$_POST['descriptionchargebed'][$key];
		
		$descriptionchargerateuhx=$_POST['descriptionchargerateuhx'][$key];
	    $descriptionchargeamountuhx=$_POST['descriptionchargeamountuhx'][$key];
		//this is for caftarea
		if($descriptionchargebed!="")
		{
			$query2 = "select * from master_bed where bed = '".$descriptionchargebed."' and ward = '".$descriptionchargeward."'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res2 = mysqli_fetch_array($exec2);
	$caftcharge = $res2['threshold'];
	
	$bedchargerate = $descriptionchargerate-($caftcharge*$descriptionchargequantity);
		}
		
		
		if($descriptioncharge!="")
		{
		$query71 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,bedcharge,caftarea,rateuhx,amountuhx,curtype,fxrate)values('$descriptioncharge','$descriptionchargerate','$descriptionchargequantity','$descriptionchargeamount','$descriptionchargeward','$descriptionchargebed','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa','".$locationnameget."','".$locationcodeget."','".$bedchargerate."','".$caftcharge."','".$descriptionchargerateuhx."','".$descriptionchargeamountuhx."','".$curtype."','".$fxrate."')";
		$exec71=mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		}
		if(isset($_POST['descriptioncharge1']))
		{
			foreach($_POST['descriptioncharge1'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$descriptioncharge1=$_POST['descriptioncharge1'][$key];
			if($descriptioncharge1 == 'Bed Charges')
		{
		$coa = $bedchargescoa;
		}
		if($descriptioncharge1 == 'Nursing Charges')
		{
		$coa = $nursingcoa;
		}
		if($descriptioncharge1 == 'RMO Charges')
		{
		$coa = $rmocoa;
		}
		if($descriptioncharge1 == 'Accommodation Charges')
		{
		$coa = $accomodationcoa;
		}
		if($descriptioncharge1 == 'Cafetaria Charges')
		{
		$coa = $cafeteriacoa;
		}
		$descriptionchargerate1=$_POST['descriptionchargerate1'][$key];
		$descriptionchargeamount1=$_POST['descriptionchargeamount1'][$key];
		$descriptionchargequantity1=$_POST['descriptionchargequantity1'][$key];
		$descriptionchargedocno1=$_POST['descriptionchargedocno1'][$key];
		$descriptionchargeward1=$_POST['descriptionchargeward1'][$key];
		$descriptionchargebed1=$_POST['descriptionchargebed1'][$key];
		
		
		$descriptionchargerate1uhx=$_POST['descriptionchargerate1uhx'][$key];
	    $descriptionchargeamount1uhx=$_POST['descriptionchargeamount1uhx'][$key];
		//this is for caftarea
		if($descriptionchargebed1!="")
		{
			$query2 = "select * from master_bed where bed = '".$descriptionchargebed1."' and ward = '".$descriptionchargeward1."'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res2 = mysqli_fetch_array($exec2);
	$caftcharge1 = $res2['threshold'];
	
	$bedchargerate1 = $descriptionchargerate1-($caftcharge*$descriptionchargequantity1);
		}
		if($descriptioncharge1!="")
		{
		$query711 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,bedcharge,caftarea,rateuhx,amountuhx,curtype,fxrate)values('$descriptioncharge1','$descriptionchargerate1','$descriptionchargequantity1','$descriptionchargeamount1','$descriptionchargeward1','$descriptionchargebed1','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa','".$locationnameget."','".$locationcodeget."','".$bedchargerate1."','".$caftcharge1."','".$descriptionchargerate1uhx."','".$descriptionchargeamount1uhx."','".$curtype."','".$fxrate."')";
		$exec711=mysqli_query($GLOBALS["___mysqli_ston"], $query711) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		}
		
		if(isset($_POST['descriptioncharge12']))
		{
			foreach($_POST['descriptioncharge12'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$descriptioncharge12=$_POST['descriptioncharge12'][$key];
				if($descriptioncharge12 == 'Bed Charges')
		{
		$coa = $bedchargescoa;
		}
		if($descriptioncharge12 == 'Nursing Charges')
		{
		$coa = $nursingcoa;
		}
		if($descriptioncharge12 == 'RMO Charges')
		{
		$coa = $rmocoa;
		}
		if($descriptioncharge12 == 'Accommodation Charges')
		{
		$coa = $accomodationcoa;
		}
		if($descriptioncharge12 == 'Cafetaria Charges')
		{
		$coa = $cafeteriacoa;
		}
		$descriptionchargerate12=$_POST['descriptionchargerate12'][$key];
		$descriptionchargeamount12=$_POST['descriptionchargeamount12'][$key];
		$descriptionchargequantity12=$_POST['descriptionchargequantity12'][$key];
		$descriptionchargedocno12=$_POST['descriptionchargedocno12'][$key];
		$descriptionchargeward12=$_POST['descriptionchargeward12'][$key];
		$descriptionchargebed12=$_POST['descriptionchargebed12'][$key];
		
		
		$descriptionchargerate12uhx=$_POST['descriptionchargerate12uhx'][$key];
	    $descriptionchargeamount12uhx=$_POST['descriptionchargeamount12uhx'][$key];
		//this is for caftarea
		if($descriptionchargebed12!="")
		{
			$query2 = "select * from master_bed where bed = '".$descriptionchargebed12."' and ward = '".$descriptionchargeward12."'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res2 = mysqli_fetch_array($exec2);
	$caftcharge12 = $res2['threshold'];
	
	$bedchargerate12 = $descriptionchargerate12-($caftcharge*$descriptionchargequantity12);
		}
		if($descriptioncharge12!="")
		{
		$query712 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,bedcharge,caftarea,rateuhx,amountuhx,curtype,fxrate)values('$descriptioncharge12','$descriptionchargerate12','$descriptionchargequantity12','$descriptionchargeamount12','$descriptionchargeward12','$descriptionchargebed12','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa','".$locationnameget."','".$locationcodeget."','".$bedchargerate12."','".$caftcharge12."','".$descriptionchargerate12uhx."','".$descriptionchargeamount12uhx."','".$curtype."','".$fxrate."')";
		$exec712=mysqli_query($GLOBALS["___mysqli_ston"], $query712) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		}
		if(isset($_POST['medicinename']))
		{
	foreach($_POST['medicinename'] as $key=>$value)
		{	
		    //echo '<br>'.$i;
			//echo '<br>'.
			//$autonumber = $_REQUEST['autonumber'.$p];	
			//echo '<br>'.
		    $medicinename = $_POST['medicinename'][$key];
			$medicinename = addslashes($medicinename);
			/*$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysql_query($query77);
			$res77=mysql_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			$rate=$res77['rateperunit'];*/
            $medicinecode = $_POST['itemcode'][$key];
			$rate = $_POST['rate'][$key];
			$quantity = $_POST['quantity'][$key];
				$amount = $_POST['amount'][$key];
				
			$rate=$rate/$fxrate;
				$amountuhx = $_POST['amountuhx'][$key];
				$rateuhx = $_POST['rateuhx'][$key];
				
			$query6 = "select ledgername, ledgercode, ledgerautonumber, incomeledger, incomeledgercode from master_medicine where itemcode = '$medicinecode'"; 
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res6 = mysqli_fetch_array($exec6);
			$ledgername = $res6['ledgername'];
			$ledgercode = $res6['ledgercode'];
			$ledgeranum = $res6['ledgerautonumber'];
			$incomeledger =$res6['incomeledger'];
			$incomeledgercode = $res6['incomeledgercode'];
			
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{

			$original_fxrate= $fxrate;
			if(strtoupper($currency)=="USD"){
				$fxrate = $pharmacy_fxrate;
			}

		        //echo '<br>'. 
		        $query2 = "insert into billing_ippharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,medicinecode,billnumber,pharmacycoa,locationname,locationcode,rateuhx,amountuhx,curtype,fxrate,ledgercode,ledgername,incomeledger,incomeledgercode) 
				values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$currentdate','$ipaddress','$accountname','$medicinecode','$billno','$pharmacycoa','".$locationnameget."','".$locationcodeget."','".$rateuhx."','".$amountuhx."','".$curtype."','".$fxrate."','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			
			$fxrate = $original_fxrate;
							
			}
		
		}
		}

		if(isset($_POST['medicinecodepkg']))
		{
	foreach($_POST['medicinecodepkg'] as $key=>$value)
		{	
		  
		    $medicinename = $_POST['medicinenamepkg'][$key];
			//$medicinename = addslashes($medicinename);
			
			$medicinecode=$_POST['medicinecodepkg'][$key];
			
			$quantity = $_POST['quantitypkg'][$key];
			$amount = $_POST['amountpkg'][$key];
			$rate = 	$_POST['ratepkg'][$key];
			//$rate=$rate/$fxrate;
				$amountuhx = $_POST['amountuhxpkg'][$key];
				$rateuhx = $_POST['rateuhxpkg'][$key];
				
			$query6 = "select ledgername, ledgercode, ledgerautonumber, incomeledger, incomeledgercode from master_medicine where itemcode = '$medicinecode'"; 
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res6 = mysqli_fetch_array($exec6);
			$ledgername = $res6['ledgername'];
			$ledgercode = $res6['ledgercode'];
			$ledgeranum = $res6['ledgerautonumber'];
			$incomeledger =$res6['incomeledger'];
			$incomeledgercode = $res6['incomeledgercode'];
			 $pkg_status = 'YES';
				$packageid = $_POST['packageid'];
				$pkg_process_row_id = $_POST['medicinerowidpkg'][$key];
			
			if ($medicinename != "" && $medicinecode !="")
			{

				$original_fxrate= $fxrate;
				if(strtoupper($currency)=="USD"){
					$fxrate = $pharmacy_fxrate;
				}

		        
		        $query2 = "insert into billing_ippharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,medicinecode,billnumber,pharmacycoa,locationname,locationcode,rateuhx,amountuhx,curtype,fxrate,ledgercode,ledgername,incomeledger,incomeledgercode,pkg_id,pkg_status,package_process_id) 
				values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$currentdate','$ipaddress','$accountname','$medicinecode','$billno','$pharmacycoa','".$locationnameget."','".$locationcodeget."','".$rateuhx."','".$amountuhx."','".$curtype."','".$fxrate."','$ledgercode','$ledgername','$incomeledger','$incomeledgercode','$packageid','$pkg_status','$pkg_process_row_id')";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			
			
							
			}
		
		}
		}

		if(isset($_POST['lab']))
		{
		foreach($_POST['lab'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$labname=$_POST['lab'][$key];

		//$labquery=mysql_query("select * from master_lab where itemname='$labname'");
		//$execlab=mysql_fetch_array($labquery);
		//$labcode=$execlab['itemcode'];
		$labcode=$_POST['labcode'][$key];
		$labrate=$_POST['rate5'][$key];
		
		$labrateuhx=$_POST['rate5uhx'][$key];
		
		if($labname!="")
		{
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_iplab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,billnumber,labcoa,locationname,locationcode,rateuhx,curtype,fxrate)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$currentdate','$billno','$labcoa','".$locationnameget."','".$locationcodeget."','".$labrateuhx."','".$curtype."','".$fxrate."')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}
		}

		if(isset($_POST['labcodepkg']))
		{
		foreach($_POST['labcodepkg'] as $key=>$value)
		{
				    

		$labname=$_POST['labpkg'][$key];

		
		$labcode=$_POST['labcodepkg'][$key];
		$labrate=$_POST['rate5pkg'][$key];
		
		$labrateuhx=$_POST['rate5uhxpkg'][$key];

		$pkg_status = 'YES';
				$packageid = $_POST['packageid'];
				$pkg_process_row_id = $_POST['labrowidpkg'][$key];
		
		
		if($labname!="")
		{
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_iplab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,billnumber,labcoa,locationname,locationcode,rateuhx,curtype,fxrate,pkg_id,pkg_status,package_process_id)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$currentdate','$billno','$labcoa','".$locationnameget."','".$locationcodeget."','".$labrateuhx."','".$curtype."','".$fxrate."','$packageid','$pkg_status','$pkg_process_row_id')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}
		}
		if(isset($_POST['radiology']))
		{
		foreach($_POST['radiology'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['radiology'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
		
		//$radiologyquery=mysql_query("select * from master_radiology where itemname='$pairvar'");
		//$execradiology=mysql_fetch_array($radiologyquery);
		//$radiologycode=$execradiology['itemcode'];
		$radiologycode=$_POST['radiologcode'][$key];

		 $pairs1uhx= $_POST['rate8uhx'][$key];
		
		if($pairvar!="")
		{
		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,billnumber,radiologycoa,locationname,locationcode,radiologyitemrateuhx,curtype,fxrate)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$currentdate','$billno','$radiologycoa','".$locationnameget."','".$locationcodeget."','".$pairs1uhx."','".$curtype."','".$fxrate."')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		}


			if(isset($_POST['radiologycodepkg']))
		{
		foreach($_POST['radiologycodepkg'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['radiologypkg'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8pkg'][$key];
		$pairvar1= $pairs1;
		
		$radiologycode=$_POST['radiologycodepkg'][$key];
		
		 $pairs1uhx= $_POST['rate8uhxpkg'][$key];
		 $pkg_status = 'YES';
				$packageid = $_POST['packageid'];
				$pkg_process_row_id = $_POST['radiologyrowidpkg'][$key];
		
		if($pairvar!="")
		{
		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,billnumber,radiologycoa,locationname,locationcode,radiologyitemrateuhx,curtype,fxrate,pkg_id,pkg_status,package_process_id)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$currentdate','$billno','$radiologycoa','".$locationnameget."','".$locationcodeget."','".$pairs1uhx."','".$curtype."','".$fxrate."','$packageid','$pkg_status','$pkg_process_row_id')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		}

		if(isset($_POST['services']))
		{
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;
		//$serviceledgcode=$_POST["serviceledgcode"][$key];
		//$serviceledgname=$_POST["serviceledgname"][$key];
		$servicedoctorcode=$_POST["servicedoctorcode"][$key];
		$servicedoctorname=$_POST["servicedoctorname"][$key];

		$ipserviceperc=$_POST["ipserpercentage"][$key];		
		$sharingamount=$_POST["sharingamt"][$key];
		
		$servicesname=$_POST["services"][$key];
	
		$servicescode=$_POST["servicesitemcode"][$key];

		$sql_serv="select ledgerid,ledgername from master_services where itemcode='".$servicescode."'";
		$sql_serv34 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_serv) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_res34 = mysqli_fetch_array($sql_serv34);
		$serviceledgcode=$sql_res34['ledgerid'];
		$serviceledgname=$sql_res34['ledgername'];
		
		$servicesrate=$_POST["rate3"][$key];
		$servicesrateuhx=$_POST["rate3uhx"][$key];
				

		$wellnesspkg=$_POST["wellnesspkg"][$key];

	//residental doctor

	$rsltr_sharing= resident_doctor_sharing($servicedoctorcode,$updatedate,$servicesrate);

     $is_resdoc=$rsltr_sharing['is_resident'];
	 if($is_resdoc==1){
	 $sharingamount=$rsltr_sharing['sharing_amt'];
	 $ipserviceperc=$rsltr_sharing['sharing_per'];
     }
   /// residental doctor



		if($patientbilltype == 'PAY NOW')
		{
		$stat = 'paid';
		}
		else
		{
		$stat = 'unpaid';
		}
		if($servicesname!="")
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber,servicecoa,locationname,locationcode,servicesitemrateuhx,curtype,fxrate,incomeledgercode,incomeledgername,doctorcode,doctorname,wellnesspkg,billstatus,ipservice_percentage,sharingamount)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$currentdate','$billno','$servicecoa','".$locationnameget."','".$locationcodeget."','".$servicesrateuhx."','".$curtype."','".$fxrate."','$serviceledgcode','$serviceledgname','$servicedoctorcode','$servicedoctorname','$wellnesspkg','$stat','$ipserviceperc','$sharingamount')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$ipdocquery=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipprivatedoctor(docno, patientname, patientcode, visitcode, accountname, description, doccoa, coa, quantity, rate, amount, recordtime, ipaddress, recorddate, username, billstatus, doctorstatus, billtype, locationname, locationcode, transactionmode, transactionamount, pkg_status, visittype,pvtdr_percentage,sharingamount,original_amt,is_resdoc) VALUES ( '$billno', '$patientname', '$patientcode', '$visitcode', '$accountname', '$servicedoctorname', '$servicedoctorcode', '$serviceledgcode', '1', '$sharingamount', '$sharingamount', '$updatedate', '$ipaddress', '$updatedate', '$username', '$stat', 'unpaid', '$patientbilltype', '$locationnameget', '$locationcodeget', '$transactionmode', '$sharingamount', '$pkg_status', 'IP','$ipserviceperc','$sharingamount','$servicesrate','$is_resdoc')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		
		  $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and wellnessitem = '1' group by servicesitemcode,iptestdocno";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res21 = mysqli_fetch_array($exec21))
			{
			
				
				
		//$serviceledgcode=$res21["incomeledgercode"];
		//$serviceledgname=$res21["incomeledgername"];
		$servicedoctorcode=$res21["doctorcode"];
		$servicedoctorname=$res21["doctorname"];
		
		$servicesname=$res21["servicesitemname"];
		
		$servicescode=$res21['servicesitemcode'];
		
		$servicesrate=$res21["servicesitemrate"];

		$sharingamt = $servicesrate * ($ipserviceperc/100);
		
		$servicesrateuhx=$res21["servicesitemrate"]*$fxrate;

		//residental doctor

	$rsltr_sharing= resident_doctor_sharing($servicedoctorcode,$updatedate,$servicesrate);

     $is_resdoc=$rsltr_sharing['is_resident'];
	 if($is_resdoc==1){
	 $sharingamt=$rsltr_sharing['sharing_amt'];
	 $ipserviceperc=$rsltr_sharing['sharing_per'];
     }
   /// residental doctor

		$sql_serv="select ledgerid,ledgername from master_services where itemcode='".$servicescode."'";
		$sql_serv34 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_serv) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_res34 = mysqli_fetch_array($sql_serv34);
		$serviceledgcode=$sql_res34['ledgerid'];
		$serviceledgname=$sql_res34['ledgername'];
		
		if($servicesname!="")
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber,servicecoa,locationname,locationcode,servicesitemrateuhx,curtype,fxrate,incomeledgercode,incomeledgername,doctorcode,doctorname,wellnessitem,billstatus,ipservice_percentage,sharingamount)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$currentdate','$billno','$servicecoa','".$locationnameget."','".$locationcodeget."','".$servicesrateuhx."','".$curtype."','".$fxrate."','$serviceledgcode','$serviceledgname','$servicedoctorcode','$servicedoctorname','1','$stat','$ipserviceperc','$sharingamt')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$ipdocquery=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipprivatedoctor(docno, patientname, patientcode, visitcode, accountname, description, doccoa, coa, quantity, rate, amount, recordtime, ipaddress, recorddate, username, billstatus, doctorstatus, billtype, locationname, locationcode, transactionmode, transactionamount, pkg_status, visittype,pvtdr_percentage,sharingamount,original_amt,is_resdoc) VALUES ( '$billno', '$patientname', '$patientcode', '$visitcode', '$accountname', '$servicedoctorname', '$servicedoctorcode', '$serviceledgcode', '1', '$sharingamt', '$sharingamt', '$updatedate', '$ipaddress', '$updatedate', '$username', '$stat', 'unpaid', '$patientbilltype', '$locationnameget', '$locationcodeget', '$transactionmode', '$sharingamt', '$pkg_status', 'IP','$ipserviceperc','$sharingamt','$servicesrate','$is_resdoc')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
			}
		
		
		
		
		
		}


		if(isset($_POST['servicesitemcodepkg']))
		{
		foreach($_POST['servicesitemcodepkg'] as $key => $value)
		{
				   
		//$serviceledgcode=$_POST["serviceledgcodepkg"][$key];
		//$serviceledgname=$_POST["serviceledgnamepkg"][$key];
		//$servicedoctorcode=$_POST["servicedoctorcodepkg"][$key];
		//$servicedoctorname=$_POST["servicedoctornamepkg"][$key];
		
		$servicesname=$_POST["servicespkg"][$key];
	
		$servicescode=$_POST["servicesitemcodepkg"][$key];

		$sql_serv="select ledgerid,ledgername from master_services where itemcode='".$servicescode."'";
			$sql_serv34 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_serv) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		    $sql_res34 = mysqli_fetch_array($sql_serv34);
            $serviceledgcode=$sql_res34['ledgerid'];
			$serviceledgname=$sql_res34['ledgername'];
		
		$servicesrate=$_POST["rate3pkg"][$key];
				$servicesrateuhx=$_POST["rate3uhxpkg"][$key];
				

		$wellnesspkg=$_POST["wellnesspkg"][$key];
		if($patientbilltype == 'PAY NOW')
		{
		$stat = 'paid';
		}
		else
		{
		$stat = 'unpaid';
		}

			$pkg_status = 'YES';
			$packageid = $_POST['packageid'];
			$pkg_process_row_id = $_POST['servicesrowidpkg'][$key];
		if($servicesname!="")
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber,servicecoa,locationname,locationcode,servicesitemrateuhx,curtype,fxrate,incomeledgercode,incomeledgername,doctorcode,doctorname,wellnesspkg,billstatus,pkg_id,pkg_status,package_process_id)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$currentdate','$billno','$serviceledgcode','".$locationnameget."','".$locationcodeget."','".$servicesrateuhx."','".$curtype."','".$fxrate."','$serviceledgcode','$serviceledgname','','','$wellnesspkg','$stat','$packageid','$pkg_status','$pkg_process_row_id')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		
		
		}

		if($_POST["packagemiscode"]){

			$sql_serv="select ledgerid,ledgername from master_services where itemcode='".$_POST["packagemiscode"]."'";
			$sql_serv34 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_serv) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		    $sql_res34 = mysqli_fetch_array($sql_serv34);
            $serviceledgcode=$sql_res34['ledgerid'];
			$serviceledgname=$sql_res34['ledgername'];
            $servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber,servicecoa,locationname,locationcode,servicesitemrateuhx,curtype,fxrate,incomeledgercode,incomeledgername,doctorcode,doctorname,wellnesspkg,billstatus,pkg_id,pkg_status,package_process_id)values('$patientcode','$patientname','$visitcode','".$_POST["packagemiscode"]."','".$_POST["packagemisname"]."','".$_POST["mis_amt_service"]."','$accountname','$currentdate','$billno','$serviceledgcode','".$locationnameget."','".$locationcodeget."','".$_POST["mis_amt_service"]."','".$curtype."','".$fxrate."','$serviceledgcode','$serviceledgname','','','0','$stat','$packageid','$pkg_status','')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		}
		
		if(isset($_POST['ambulance']))
		{
		foreach($_POST['ambulance'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$ambulance=$_POST['ambulance'][$key];
		
		$ambulancerate=$_POST['ambulancerate'][$key];
	    $ambulanceamount=$_POST['ambulanceamount'][$key];
		$ambulancequantity=$_POST['ambulancequantity'][$key];
		
		$ambulancerateuhx=$_POST['ambulancerateuhx'][$key];
	    $ambulanceamountuhx=$_POST['ambulanceamountuhx'][$key];
			
		if($ambulance!="")
		{
		$query51 = "insert into billing_ipambulance(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,rateuhx,amountuhx,curtype,fxrate)values('$ambulance','$ambulancerate','$ambulancequantity','$ambulanceamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$ambulancecoa','".$locationnameget."','".$locationcodeget."','".$ambulancerateuhx."','".$ambulanceamountuhx."','".$curtype."','".$fxrate."')";
		$exec51=mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}
		}
			if(isset($_POST['privatedoctor']))
		{
		foreach($_POST['privatedoctor'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$privatedoctor=$_POST['privatedoctor'][$key];
		$privatedoctor=trim($privatedoctor);
		$privatedoctorrate=$_POST['privatedoctorrate'][$key];
	    $privatedoctoramount=$_POST['privatedoctoramount'][$key];
		$privatedoctorquantity=$_POST['privatedoctorquantity'][$key];

		$pvtdrperc=$_POST['pvtdrpercentage'][$key];		
		$pvtdrsharingamount=$_POST['pvtdrsharingamt'][$key];
		
		$privatedoctorrateuhx=$_POST['privatedoctorrateuhx'][$key];
	    $privatedoctoramountuhx=$_POST['privatedoctoramountuhx'][$key];
		$doccoa = $_POST['pvtdrdoccoa'][$key];
		
		//$query78 = "select id from master_accountname where accountname = '$privatedoctor'";
		//$exec78 = mysql_query($query78) or die ("Error in Query78".mysql_error().__LINE__);
		//$res78 = mysql_fetch_array($exec78);
		//$doccoa = $res78['id'];
		
		if($patientbilltype == 'PAY NOW')
		{
		$stat = 'paid';
		}
		else
		{
		$stat = 'unpaid';
		}
    

	//residental doctor

	$rsltr_sharing= resident_doctor_sharing($doccoa,$updatedate,$privatedoctoramount);

     $is_resdoc=$rsltr_sharing['is_resident'];
	 if($is_resdoc==1){
	 $pvtdrsharingamount=$rsltr_sharing['sharing_amt'];
	 $pvtdrperc=$rsltr_sharing['sharing_per'];
     }
   /// residental doctor

	
			
		if($privatedoctor!="")
		{
		 $query52 = "insert into billing_ipprivatedoctor(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,billstatus,doctorstatus,billtype,creditcoa,debitcoa,locationname,locationcode,doccoa,rateuhx,amountuhx,curtype,fxrate,pvtdr_percentage,sharingamount,transactionamount,original_amt,is_resdoc)values('$privatedoctor','$privatedoctorrate','$privatedoctorquantity','$privatedoctoramount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','','$stat','unpaid','$patientbilltype','$referalcode','$debitcoa','".$locationnameget."','".$locationcodeget."','$doccoa','".$privatedoctorrateuhx."','".$privatedoctoramountuhx."','".$curtype."','".$fxrate."','$pvtdrperc', '$pvtdrsharingamount','$privatedoctoramount','$privatedoctoramount','$is_resdoc')";
		$exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}
		}

		if(isset($_POST['privatedoctorpkg']))
		{
			   
		 foreach($_POST['privatedoctorpkg'] as $key=>$value)
		 {
			$privatedoctor=$_POST['privatedoctorpkg'][$key];
			$privatedoctor=trim($privatedoctor);
			$privatedoctorrate=$_POST['privatedoctorratepkg'][$key];
		    $privatedoctoramount=$_POST['privatedoctoramountpkg'][$key];
			$privatedoctorquantity=$_POST['privatedoctorquantitypkg'][$key];
			
			$privatedoctorrateuhx=$_POST['privatedoctorrateuhxpkg'][$key];
		    $privatedoctoramountuhx=$_POST['privatedoctoramountuhxpkg'][$key];
			$doccoa = $_POST['doccoapkg'][$key];
			
			//$query78 = "select id from master_accountname where accountname = '$privatedoctor'";
			//$exec78 = mysql_query($query78) or die ("Error in Query78".mysql_error().__LINE__);
			//$res78 = mysql_fetch_array($exec78);
			$doccoa = $_POST['privatedoctorcode'][$key];
			$pkg_status = 'YES';
				$packageid = $_POST['packageid'];
				$pkg_process_row_id = $_POST['privatedoctorrowidpkg'][$key];
			
			if($patientbilltype == 'PAY NOW')
			{
			$stat = 'paid';
			}
			else
			{
			$stat = 'unpaid';
			}
				
			if($privatedoctor!="")
			{
				$sharing_amt=0;
				$query78 = "select is_staff from master_doctor where doctorcode = '$doccoa'";
				$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res78 = mysqli_fetch_array($exec78);
			$staff_doc=$res78['is_staff'];
			if($staff_doc==0)
			{
			$sharing_amt=$privatedoctoramount;
			}
			
			 $query52 = "insert into billing_ipprivatedoctor(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,billstatus,doctorstatus,billtype,creditcoa,debitcoa,locationname,locationcode,doccoa,rateuhx,amountuhx,curtype,fxrate,pkg_id,pkg_status,package_process_id,doctorcode,transactionamount,original_amt,sharingamount)values('$privatedoctor','$privatedoctorrate','$privatedoctorquantity','$privatedoctoramount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','','$stat','unpaid','$patientbilltype','$referalcode','$debitcoa','".$locationnameget."','".$locationcodeget."','$doccoa','".$privatedoctorrateuhx."','".$privatedoctoramountuhx."','".$curtype."','".$fxrate."','$packageid','$pkg_status','$pkg_process_row_id','$doccoa','".$privatedoctoramount."','".$privatedoctoramount."','".$sharing_amt."')";
			$exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				}
			}
			
		}
		
		if(isset($_POST['nhifquantity']))
		{
		foreach($_POST['nhifquantity'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		
		
		$nhifrate=$_POST['nhifrate'][$key];
	    $nhifamount=$_POST['nhifamount'][$key];
		$nhifquantity=$_POST['nhifquantity'][$key];
		
		$nhifrateuhx=$_POST['nhifrateuhx'][$key];
	    $nhifamountuhx=$_POST['nhifamountuhx'][$key];
		
		$finamount = abs($nhifamount);
			
		if($nhifquantity!="")
		{
		$query53 = "insert into billing_ipnhif(rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,finamount,accountcode,rateuhx,amountuhx,curtype,fxrate)values('$nhifrate','$nhifquantity','$nhifamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$nhifcoa','".$locationnameget."','".$locationcodeget."','$finamount','$accountcode','".$nhifrateuhx."','".$nhifamountuhx."','".$curtype."','".$fxrate."')";
		$exec53=mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}
		}
		
		if(isset($_POST['otbilling']))
		{
		foreach($_POST['otbilling'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		
		$otbilling=$_POST['otbilling'][$key];
		$otbillingrate=$_POST['otbillingrate'][$key];
	    $otbillingamount=$_POST['otbillingamount'][$key];
		
		$otbillingrateuhx=$_POST['otbillingrateuhx'][$key];
	    $otbillingamountuhx=$_POST['otbillingamountuhx'][$key];
		
			
		if($otbilling!="")
		{
		$query54 = "insert into billing_ipotbilling(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,rateuhx,amountuhx,curtype,fxrate)values('$otbilling','$otbillingrate','1','$otbillingamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$otbillingcoa','".$locationnameget."','".$locationcodeget."','".$otbillingrateuhx."','".$otbillingamountuhx."','".$curtype."','".$fxrate."')";
		$exec54=mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}
		}
		
		if(isset($_POST['miscbilling']))
		{
		foreach($_POST['miscbilling'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		
		$miscbilling=$_POST['miscbilling'][$key];
		$miscbillingrate=$_POST['miscbillingrate'][$key];
	    $miscbillingamount=$_POST['miscbillingamount'][$key];
		$miscbillingquantity=$_POST['miscbillingquantity'][$key];
		
		$miscbillingrateuhx=$_POST['miscbillingrateuhx'][$key];
	    $miscbillingamountuhx=$_POST['miscbillingamountuhx'][$key];

		$miscbillingledname=$_POST['ledname'][$key];
		$miscbillingledid=$_POST['ledid'][$key];
			
		if($miscbilling!="")
		{
		$query55 = "insert into billing_ipmiscbilling(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,rateuhx,amountuhx,curtype,fxrate,billingaccountname,billingaccountcode)values('$miscbilling','$miscbillingrate','miscbillingquantity','$miscbillingamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$miscbillingcoa','".$locationnameget."','".$locationcodeget."','".$miscbillingrateuhx."','".$miscbillingamountuhx."','".$curtype."','".$fxrate."','".$miscbillingledname."','".$miscbillingledid."')";
		$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}
		}

		if(isset($_POST['admissionchargerate']))
		{
		foreach($_POST['admissionchargerate'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$admissionchargerate=$_POST['admissionchargerate'][$key];
	    $admissionchargeamount=$_POST['admissionchargeamount'][$key];
		
		$admissionchargerateuhx=$_POST['admissionchargerateuhx'][$key];
	    $admissionchargeamountuhx=$_POST['admissionchargeamountuhx'][$key];
		
			
		if($admissionchargerate!="")
		{
		$query56 = "insert into billing_ipadmissioncharge(rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,rateuhx,amountuhx,curtype,fxrate)values('$admissionchargerate','1','$admissionchargeamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$admissionchargecoa','".$locationnameget."','".$locationcodeget."','".$admissionchargerateuhx."','".$admissionchargeamountuhx."','".$curtype."','".$fxrate."')";
		$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}
		}
		
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		 $res55 = mysqli_fetch_array($exec55);
		 $cashcode = $res55['ledgercode'];
		 
		 $query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
		 $exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die ("Error in Query551".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		 $res551 = mysqli_fetch_array($exec551);
		 $bankcode = $res551['ledgercode'];
		 
		 $query552 = "select * from financialaccount where transactionmode = 'MPESA'";
		 $exec552 = mysqli_query($GLOBALS["___mysqli_ston"], $query552) or die ("Error in Query552".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		 $res552 = mysqli_fetch_array($exec552);
		 $mpesacode = $res552['ledgercode'];
					 
		
		$query43="insert into master_transactionip(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber,locationname,locationcode,returnbalance,accountcode,cashcode,bankcode,mpesacode,totalamountuhx,curtype,fxrate,accountnameano,accountnameid,subtypeano)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$totalamount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber','".$locationnameget."','".$locationcodeget."','".$returnbalance."','$accountcode','$cashcode','$bankcode','$mpesacode','".$totalamountuhx."','".$curtype."','".$fxrate."','$accountnameano','$accountcode','$subtypeano')";
	    $exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die("error in query43".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);	


		if(isset($_POST['nhifquantity']))
		{

			$query_acc = "SELECT * FROM finance_ledger_mapping WHERE map_anum = '20' AND record_status <> 'deleted'";
            $exec_acc = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in Query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
            $ledgername = '';
            $res_acc = mysqli_fetch_array($exec_acc);
			
			$accountcode1 = $res_acc['ledger_id'];
			$accountname1 = $res_acc['ledger_name'];
		    
			$subsql='select a.auto_number as lid,b.subtype as name,b.auto_number as sid from master_accountname as a,master_subtype as b where a.subtype=b.auto_number and a.id="'.$accountcode1.'"';
			$exec456 = mysqli_query($GLOBALS["___mysqli_ston"], $subsql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res412=mysqli_fetch_array($exec456);

			$subtype1 =$res412['name'];
			$postingaccount =$res412['lid'];
			$postingsubaccount =$res412['sid'];

			foreach($_POST['nhifquantity'] as $key=>$value)
			{
						//echo '<br>'.$k;

			
			
			$nhifrate=$_POST['nhifrate'][$key];
			$nhifamount=$_POST['nhifamount'][$key];
			$nhifquantity=$_POST['nhifquantity'][$key];
			
			$nhifrateuhx=$_POST['nhifrateuhx'][$key];
			$nhifamountuhx=$_POST['nhifamountuhx'][$key];
			
			$finamount = abs($nhifamount);
				
				if($nhifquantity!="")
				{
					$query431="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber,
					locationname,locationcode,fxamount,currency,fxrate,accountcode,accountnameano,accountnameid,subtypeano,billbalanceamount)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname1','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype1','$finamount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber','".$locationnameget."','".$locationcodeget."','".$finamount."','".$curtype."','".$fxrate."','$accountcode1','$postingaccount','$accountcode1','$postingsubaccount','$finamount')";
					$exec431=mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die("error in query431".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);	
				}
			}
		}
		
		if($patientbilltype != 'PAY NOW')
		{
		$query431="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber,
		locationname,locationcode,fxamount,currency,fxrate,accountcode,accountnameano,accountnameid,subtypeano,billbalanceamount)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$totalamount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber','".$locationnameget."','".$locationcodeget."','".$totalamountuhx."','".$curtype."','".$fxrate."','$accountcode','$accountnameano','$accountcode','$subtypeano','$totalamountuhx')";
	    $exec431=mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die("error in query431".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);		  
			  
		}
		$query64 = "update ip_bedallocation set paymentstatus='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query691 = "update master_ipvisitentry set paymentstatus='completed',finalbillno='$billno' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec691 = mysqli_query($GLOBALS["___mysqli_ston"], $query691) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query6412 = "update ip_discharge set paymentstatus='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec6412 = mysqli_query($GLOBALS["___mysqli_ston"], $query6412) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query6412c = "update newborn_motherdetails set ipbill='completed' where patientcode='$patientcode' and patientvisitcode='$visitcode'";
		$exec6412c = mysqli_query($GLOBALS["___mysqli_ston"], $query6412c) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
	
	    if($patientbilltype != 'PAY NOW')
		{
		  if($eclaim==3){
            header("location:writexmlip.php?billautonumber=$billno&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&&loc=$locationcodeget&slade=yes&claim=$slade_claim_id&authorization_id=$authorization_code&amount=$totalamount&type=ip&offpatient=$offpatient");
            exit;
		  }
		  elseif($eclaim==2){
		   if($offpatient!='')
		   {
		   header("location:slade-claim.php?billno=$billno&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&slade=yes&claim=$claim&authorization_id=$authorization_id&amount=$amount&type=ip&frmtype=ip&offpatient=$offpatient");
	 
	   exit;
		   }
		   else
		   {
			   header("location:slade-balance.php?billautonumber=$billno&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&slade=yes&claim=$slade_claim_id&authorization_id=$authorization_code&amount=$totalamount&type=ip");
            exit;
		   }
		  }
		  elseif($slade_claim_id!='' && $payercode!=''){
            header("location:slade-invoiceippost.php?billno=$billno&&visitcode=$visitcode&claim=$slade_claim_id");
            exit;
		  }elseif($eclaim==1){
	       header("location:writexmlip.php?billautonumber=$billno&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&&loc=$locationcodeget");
		  }
		   elseif($offpatient!='')
		   {
		   header("location:slade-claim.php?billno=$billno&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&type=ip&frmtype=ip&offpatient=$offpatient");
	 
	   exit;
		   }
		  else{
	      header("location:ipbilling.php?savedpatientcode=$patientcode&&savedvisitcode=$visitcode&&billnumber=$billno&&loc=$locationcodeget");
			exit;
		  }
		}
		else
		{
	?>
    <script>
/*    function open_print(){
	window.open("print_ipfinalinvoice1.php?patientcode=<?php echo $patientcode;?>&&visitcode=<?php echo $visitcode?>&&billnumber=<?php echo $billno?>&&loc=<?php echo $locationcodeget?>", "_blank");
	window.location="ipbilling.php";
    }*/
    </script>
    <?php
	echo '<script>open_print()</script>';
	header("location:ipbilling.php?savedpatientcode=$patientcode&&savedvisitcode=$visitcode&&billnumber=$billno&&loc=$locationcodeget");
	exit;
	}

}
else{
$res = mysqli_fetch_array($query);

	header("location:ipbilling.php?savedpatientcode=".$res['patientcode']."&&savedvisitcode=".$res['visitcode']."&&billnumber=".$res['billno']."&&loc=$locationcodeget");	
}
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}


?>

<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'");
$execlab=mysqli_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];
 $patientbilltype = $execlab['billtype'];
 $patientbilling_notes= $execlab['billing_notes'];
$patienttype=$execlab['paymenttype'];
$loct_ipv=$execlab['locationcode'];
$offpatient=$execlab['offpatient'];
if($offpatient=='1')
{
	$offpatient='offslade';
}
else
{
	$offpatient='';
}

$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$bedtemplate=$execsubtype['bedtemplate'];
$labtemplate=$execsubtype['labtemplate'];
$radtemplate=$execsubtype['radtemplate'];
$sertemplate=$execsubtype['sertemplate'];
$payer_code=$execsubtype['slade_payer_code'];
$ippactemplate=$execsubtype['ippactemplate'];

$preauthrequired=$execsubtype['preauthrequired'];

$querytt32 = "select * from master_testtemplate where templatename='$bedtemplate'";
$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
$exectl32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytl32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$numtl32 = mysqli_num_rows($exectl32);
$exectl=mysqli_fetch_array($exectl32);		
$labtable=$exectl['templatename'];
if($labtable=='')
{
	$labtable='master_lab';
}

$querytt32 = "select * from master_testtemplate where templatename='$radtemplate'";
$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$numtt32 = mysqli_num_rows($exectt32);
$exectt=mysqli_fetch_array($exectt32);		
$radtable=$exectt['templatename'];
if($radtable=='')
{
	$radtable='master_radiology';
}

$querytt32 = "select * from master_testtemplate where templatename='$sertemplate'";
$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$numtt32 = mysqli_num_rows($exectt32);
$exectt=mysqli_fetch_array($exectt32);
$sertable=$exectt['templatename'];
if($sertable=='')
{
	$sertable='master_services';
}

$querytt32 = "select * from master_testtemplate where templatename='$ippactemplate'";
$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$numtt32 = mysqli_num_rows($exectt32);
$exectt=mysqli_fetch_array($exectt32);
$ippactemplate=$exectt['templatename'];
if($ippactemplate=='')
{
	$ippactemplate='master_ippackage';
}

$query32 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode' and req_status='discharge'";
$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$num32 = mysqli_num_rows($exec32);

$queryv32 = "select * from newborn_motherdetails where mothervisitcode='$visitcode'";
$execv32 = mysqli_query($GLOBALS["___mysqli_ston"], $queryv32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$numv32 = mysqli_num_rows($execv32);

$queryc32 = "select * from newborn_motherdetails where mothervisitcode='$visitcode' and discharge='discharged'";
$execc32 = mysqli_query($GLOBALS["___mysqli_ston"], $queryc32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$numc32 = mysqli_num_rows($execc32);

$queryf32 = "select * from newborn_motherdetails where mothervisitcode='$visitcode' and ipbill <> '' and discharge='discharged'";
$execf32 = mysqli_query($GLOBALS["___mysqli_ston"], $queryf32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$numf32 = mysqli_num_rows($execf32);


?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res3 = mysqli_fetch_array($exec3);
$query_bill_location = "select auto_number from master_location where locationcode = '$loct_ipv'";
$exec_bill_loctation = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill_location) or die ("Error in Query_bill_location".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res_bill_loct = mysqli_fetch_array($exec_bill_loctation);
$location_num = $res_bill_loct['auto_number'];
$query_bill = "select prefix from bill_formats where description = 'bill_ip'";
$exec_bill = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill) or die ("Error in Query_bill".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res_bill = mysqli_fetch_array($exec_bill);
$paylaterbillprefix = $res_bill['prefix'];
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_ip order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix."-".'1'."-".date('y')."-".$location_num;
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	//$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo "</br>";
	//echo $billnumbercode;
	//$billnumbercode = intval($billnumbercode);
	//echo "</br>";
	//echo $billnumbercode;
	$pieces = explode('-', $billnumber);
	$new_billnum=$pieces[1];
	$billnumbercode=abs($new_billnum);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;
	$billnumbercode = $paylaterbillprefix."-".$maxanum."-".date('y')."-".$location_num;
	$openingbalance = '0.00';
	//echo $companycode;
}
$query7641 = "select * from master_financialintegration where field='ipdeposits'";
$exec7641 = mysqli_query($GLOBALS["___mysqli_ston"], $query7641) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res7641 = mysqli_fetch_array($exec7641);

$ipdepositscoa = $res7641['code'];
$ipdepositscoaname = $res7641['coa'];
$ipdepositstype = $res7641['type'];
$ipdepositsselect = $res7641['selectstatus'];

$query76 = "select * from master_financialintegration where field='labipfinal'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res76 = mysqli_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologyipfinal'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res761 = mysqli_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='serviceipfinal'";
$exec762 = mysqli_query($GLOBALS["___mysqli_ston"], $query762) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res762 = mysqli_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalipfinal'";
$exec763 = mysqli_query($GLOBALS["___mysqli_ston"], $query763) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res763 = mysqli_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacyipfinal'";
$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res764 = mysqli_fetch_array($exec764);

$pharmacycoa = $res764['code'];

$query765 = "select * from master_financialintegration where field='cashipfinal'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res765= mysqli_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeipfinal'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res766 = mysqli_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaipfinal'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res767 = mysqli_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardipfinal'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res768 = mysqli_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineipfinal'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res769 = mysqli_fetch_array($exec769);

$onlinecoa = $res769['code'];

$query770 = "select * from master_financialintegration where field='bedchargesipfinal'";
$exec770 = mysqli_query($GLOBALS["___mysqli_ston"], $query770) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res770 = mysqli_fetch_array($exec770);

$bedchargescoa = $res770['code'];

$query771 = "select * from master_financialintegration where field='rmoipfinal'";
$exec771 = mysqli_query($GLOBALS["___mysqli_ston"], $query771) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res771 = mysqli_fetch_array($exec771);

$rmocoa = $res771['code'];

$query772 = "select * from master_financialintegration where field='nursingipfinal'";
$exec772 = mysqli_query($GLOBALS["___mysqli_ston"], $query772) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res772 = mysqli_fetch_array($exec772);

$nursingcoa = $res772['code'];

$query773 = "select * from master_financialintegration where field='privatedoctoripfinal'";
$exec773 = mysqli_query($GLOBALS["___mysqli_ston"], $query773) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res773= mysqli_fetch_array($exec773);

$privatedoctorcoa = $res773['code'];

$query774 = "select * from master_financialintegration where field='ambulanceipfinal'";
$exec774 = mysqli_query($GLOBALS["___mysqli_ston"], $query774) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res774= mysqli_fetch_array($exec774);

$ambulancecoa = $res774['code'];

$query775 = "select * from master_financialintegration where field='nhifipfinal'";
$exec775 = mysqli_query($GLOBALS["___mysqli_ston"], $query775) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res775= mysqli_fetch_array($exec775);

$nhifcoa = $res775['code'];

$query776 = "select * from master_financialintegration where field='otbillingipfinal'";
$exec776 = mysqli_query($GLOBALS["___mysqli_ston"], $query776) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res776= mysqli_fetch_array($exec776);

$otbillingcoa = $res776['code'];

$query777 = "select * from master_financialintegration where field='miscbillingipfinal'";
$exec777 = mysqli_query($GLOBALS["___mysqli_ston"], $query777) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res777= mysqli_fetch_array($exec777);

$miscbillingcoa = $res777['code'];

$query778 = "select * from master_financialintegration where field='admissionchargeipfinal'";
$exec778 = mysqli_query($GLOBALS["___mysqli_ston"], $query778) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res778= mysqli_fetch_array($exec778);

$admissionchargecoa = $res778['code'];

$query779 = "select * from master_financialintegration where field='ippackagefinal'";
$exec779 = mysqli_query($GLOBALS["___mysqli_ston"], $query779) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res779= mysqli_fetch_array($exec779);

$packagecoa = $res779['code'];

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
<script src="js/jquery-1.11.1.min.js"></script>

<script>



function funcwardChange1()
{
	/*if(document.getElementById("ward").value == "1")
	{
		alert("You Cannot Add Account For CASH Type");
		document.getElementById("ward").focus();
		return false;
	}*/
	<?php 
	$query12 = "select * from master_ward where recordstatus=''";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	while ($res12 = mysqli_fetch_array($exec12))
	{
	$res12wardanum = $res12["auto_number"];
	$res12ward = $res12["ward"];
	?>
	if(document.getElementById("ward").value=="<?php echo $res12wardanum; ?>")
	{
		document.getElementById("bed").options.length=null; 
		var combo = document.getElementById('bed'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_bed where ward = '$res12wardanum' and recordstatus = ''";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10bedanum = $res10['auto_number'];
		$res10bed = $res10["bed"];
		
		
		
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10bed;?>", "<?php echo $res10bedanum;?>"); 
		<?php 
		
		}
		?>
	}
	<?php
	}
	?>	
}

function funcvalidation()
{
//alert('h');
if(document.getElementById("readytodischarge").checked == false)
{
alert("Please Click on Ready To Discharge");
return false;
}

}

function balancecalc()
{

var netpayable = document.getElementById("netpayable").value;
var cash = document.getElementById("cash").value;

var cheque = document.getElementById("cheque").value;
if(cheque != '')
{
funcchequenumbershow();
}
else
{
funcchequenumberhide();
}
var online = document.getElementById("online").value;
if(online != '')
{
funconlinenumbershow();
}
else
{
funconlinenumberhide();
}
var mpesa = document.getElementById("mpesa").value;
if(mpesa != '')
{
funcmpesanumbershow();
}
else
{
funcmpesanumberhide();
}
var creditcard = document.getElementById("creditcard").value;
if(creditcard != '')
{
funccreditcardnumbershow();
}
else
{
funccreditcardnumberhide();
}

if(cash == '')
{
cash = 0;
}
if(cheque == '')
{
cheque = 0;
}
if(online == '')
{
online = 0;
}
if(mpesa == '')
{
mpesa = 0;
}
if(creditcard == '')
{
creditcard = 0;
}

var balance = netpayable - (parseInt(cash)+parseInt(cheque)+parseInt(online)+parseInt(mpesa)+parseInt(creditcard));

if(parseFloat(balance) < 0)
{
	alert("Amount greater than Bill amount");
	document.getElementById("cash").value = 0;
	document.getElementById("cheque").value = 0;
	document.getElementById("creditcard").value = 0;
	document.getElementById("online").value = 0;
	document.getElementById("mpesa").value = 0;
	document.getElementById("balance").value = netpayable;
	document.getElementById("returnbalance").value = 0;	
	return false;
}

if(balance < 0)
{
document.getElementById("balance").value = 0;
document.getElementById("returnbalance").value = balance.toFixed(2);
//return false;
}
else
{
document.getElementById("balance").value = balance.toFixed(2);
document.getElementById("returnbalance").value = 0;
//return false;
}
if(document.getElementById("balance").value ==0){
	document.getElementById("submit").disabled =false;
	}else{
		document.getElementById("submit").disabled =true;
		}

}

function funcchequenumbershow()
{

  if (document.getElementById("chequenumber") != null) 
     {
	 document.getElementById("chequenumber").style.display = 'none';
	}
	if (document.getElementById("chequenumber") != null) 
	  {
	  document.getElementById("chequenumber").style.display = '';
	 }
	  if (document.getElementById("chequenumber1") != null) 
     {
	 document.getElementById("chequenumber1").style.display = 'none';
	}
	if (document.getElementById("chequenumber1") != null) 
	  {
	  document.getElementById("chequenumber1").style.display = '';
	 }
}

function funcchequenumberhide()
{		
 if (document.getElementById("chequenumber") != null) 
	{
	document.getElementById("chequenumber").style.display = 'none';
	}	
	if (document.getElementById("chequenumber1") != null) 
	{
	document.getElementById("chequenumber1").style.display = 'none';
	}	
}

function funconlinenumbershow()
{

  if (document.getElementById("onlinenumber") != null) 
     {
	 document.getElementById("onlinenumber").style.display = 'none';
	}
	if (document.getElementById("onlinenumber") != null) 
	  {
	  document.getElementById("onlinenumber").style.display = '';
	 }
	  if (document.getElementById("onlinenumber1") != null) 
     {
	 document.getElementById("onlinenumber1").style.display = 'none';
	}
	if (document.getElementById("onlinenumber1") != null) 
	  {
	  document.getElementById("onlinenumber1").style.display = '';
	 }
}

function funconlinenumberhide()
{		
 if (document.getElementById("onlinenumber") != null) 
	{
	document.getElementById("onlinenumber").style.display = 'none';
	}	
	if (document.getElementById("onlinenumber1") != null) 
	{
	document.getElementById("onlinenumber1").style.display = 'none';
	}	
}

function funccreditcardnumbershow()
{

  if (document.getElementById("creditcardnumber") != null) 
     {
	 document.getElementById("creditcardnumber").style.display = 'none';
	}
	if (document.getElementById("creditcardnumber") != null) 
	  {
	  document.getElementById("creditcardnumber").style.display = '';
	 }
	  if (document.getElementById("creditcardnumber1") != null) 
     {
	 document.getElementById("creditcardnumber1").style.display = 'none';
	}
	if (document.getElementById("creditcardnumber1") != null) 
	  {
	  document.getElementById("creditcardnumber1").style.display = '';
	 }
}

function funccreditcardnumberhide()
{		
 if (document.getElementById("creditcardnumber") != null) 
	{
	document.getElementById("creditcardnumber").style.display = 'none';
	}	
	if (document.getElementById("creditcardnumber1") != null) 
	{
	document.getElementById("creditcardnumber1").style.display = 'none';
	}	
}

function funcmpesanumbershow()
{

  if (document.getElementById("mpesanumber") != null) 
     {
	 document.getElementById("mpesanumber").style.display = 'none';
	}
	if (document.getElementById("mpesanumber") != null) 
	  {
	  document.getElementById("mpesanumber").style.display = '';
	 }
	  if (document.getElementById("mpesanumber1") != null) 
     {
	 document.getElementById("mpesanumber1").style.display = 'none';
	}
	if (document.getElementById("mpesanumber1") != null) 
	  {
	  document.getElementById("mpesanumber1").style.display = '';
	 }
}

function funcmpesanumberhide()
{		
 if (document.getElementById("mpesanumber") != null) 
	{
	document.getElementById("mpesanumber").style.display = 'none';
	}	
	if (document.getElementById("mpesanumber1") != null) 
	{
	document.getElementById("mpesanumber1").style.display = 'none';
	}	
}

function funcOnLoadBodyFunctionCall()
{

if(document.getElementById("balance").value== 0){
	//document.getElementById("submit").disabled= false;
}
funcchequenumberhide();
funconlinenumberhide();
funccreditcardnumberhide();
funcmpesanumberhide();
}

function validcheck()
{
if(document.getElementById("accountname").value == 'CASH COLLECTIONS')
{
//alert(""+document.getElementById("returnbalance").value+"");
var balance = document.getElementById("balance").value;
if(balance == '')
{
alert("Please Enter the Amount");
return false;
}
if(balance != 0.00)
{
alert("Balance is still pending, Pl collect fully before saving");
return false;
}
if(document.getElementById("returnbalance").value != 0)
{
alert("Return Balance is Negative, Please Collect exact Change and proceed");
return false;
}
}
var discharge = document.getElementById("discharge").value;
if(discharge == 0)
{
alert("Please discharge the patient before finalization");
return false;
}

var splitbill = document.getElementById("splitbill").value;
if(discharge == 0)
{
alert("Please post Doctor bill first");
return false;
}

var mother = document.getElementById("mother").value;
var babydischarge = document.getElementById("babydischarge").value;
var babyfinalaize = document.getElementById("babyfinalaize").value;
if(mother == 1)
{
	if(babydischarge == 0)
	{
	alert("Please discharge the Baby before finalization");
	return false;
	}
	if(babyfinalaize == 0)
	{
	alert("Please finalize the Baby before finalization");
	return false;
	}	
}


if(document.getElementById('isapprovalrequired').value == '1')	
if(document.getElementById('preauthcode').value == ''   ){	
{		
alert("Claim Number can not be empty.");	
document.getElementById("preauthcode").focus();	
return false;		
}	
}


var check = confirm("Are you sure to finalize the bill?\nOnce finalized, the patient's Visit will be closed permanently");
if(check == false)
{
return false;
}
if(check == true)
{
//printIPFinalInvoice();
}

if (confirm("Do You Want To Save The Record?")==false){return false;}
if(document.getElementById("eclaim").value == 2)
{
   document.getElementById("smartfrm").disabled = true;	
   FuncPopup();
  /* create_claim(1);
   return false;*/
}if(document.getElementById("eclaim").value == 3)
{
   document.getElementById("smartfrm").disabled = true;	
   //create_claim(2);
   //return false;
    FuncPopup();
}
else if(document.getElementById("eclaim").value == 1)
{
   document.getElementById("smartfrm").disabled = true;	   
}
else if(document.getElementById("eclaim").value < 1 && document.getElementById("payercode").value!='')
{
   document.getElementById("smartfrm").disabled = true;	
   create_claim(2);
   return false;  
}
else
{
  document.getElementById("submit").disabled = true;	
}
}

function printIPFinalInvoice()
 {
var popWin; 
popWin = window.open("print_ipfinalinvoice.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&billnumber=<?php echo $billnumbercode; ?>","_blank");
return true;
 }
  
  
  function coasearch(vsc,ptc)
{
	var vsc = vsc;
	//alert('ok');
	window.open("showdoctorsplitbill.php?visitcode="+vsc+"&&patientcode="+ptc,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function funfetchsavannah(smartap)
{
	if(document.getElementById("offpatient").value == '')
	  {
  if(smartap==2)
  {

	if(document.getElementById('savannah_authid').value == '')
	{
		alert("Slade auth id. can not be empty.");
		document.getElementById('savannah_authid').focus();
		return false;
	}
	else
	{
	FuncPopup();
	memberno = document.getElementById('savannah_authid').value;
	first_name = document.getElementById('patientfirstname').value;
	last_name = document.getElementById('patientlastname').value;
	data = "auth_token="+memberno+"&first_name="+first_name+"&last_name="+last_name+"&type=ip";
	$.ajax({
	  type : "get",
	  url : "slade-check.php",
	  data : data,
	  cache : false,
	  timeout:30000,
	  success : function (data){ 
	   var jsondata = JSON.parse(data); 
	   //to extract values
	   var sldeauth=jsondata['slade_authentication_token'];
      var jsonData = JSON.parse(sldeauth);
      var authorization_guid_val = jsonData.authorization_guid;
      // end of extraction
	   if(jsondata.length !=0 && jsondata['status'] == 'Success'){
	  if(jsondata['has_op'] == 'Y')
	  {
	  //alert("check savannah");
	   $('#availablelimit').val(jsondata['visit_limit']);
	   $('#authorization_code').val(authorization_guid_val);	
	   $('#frm1submitslade').val('slade'); 
	   if(parseFloat($('#availablelimit').val()) > parseFloat($('#netpayable').val()))		
	   {
         document.getElementById("availablelimit").style.backgroundColor = "#FFF";		
		 document.getElementById("availablelimit").style.color = "#000";	
		 $('#smartfrm').prop("disabled",false);
	   }
	   else{
		   document.getElementById("availablelimit").style.backgroundColor = "#FFF";		
		   document.getElementById("availablelimit").style.color = "#000";	
		    $('#fetch').prop("disabled",false);
		   $('#smartfrm').prop("disabled",true);
	   }

	  }
	else
	{
	alert('Member not covered for In-Patient');
	}
	   } 
		else{
	     alert(jsondata['error']);
		
	   } 
	   document.getElementById("imgloader").style.display = "none";
	  },error: function(x, t, m) {
         alert("Unable to connect slade server.");	
		 document.getElementById("imgloader").style.display = "none";
		 return false;
      }
		
	 });
	}
  }
}

}

function create_claim(t)
{
  if(t==2) 
	  var url="slade-claimvisit.php"; 
  else 
	  var url="slade-claim.php";

  FuncPopup();
  $('#claim_msg').html("");
  visitcode = document.getElementById('visitcode').value;
  data = "visitcode="+visitcode+"&frmtype=ip";		
	  $.ajax({		
	  type : "get",		
	  url : url,		
	  data : data,		
	  cache : false,
	  timeout:30000,
	  success : function (data){		
	   var jsondata = JSON.parse(data);		
	   if(jsondata.length !=0 && jsondata['claim_id'] !=''){	

		  $('#slade_claim_id').val(jsondata['claim_id']);         	
          $('#claim_msg').html("<strong><font color='red'>Claim ID : "+jsondata['claim_id']+"</font></strong>");
		  setTimeout(() => {document.getElementById("imgloader").style.display = "none"; }, 2000);
		  form1.submit();
		  
	   }else{
         alert(jsondata['error']);	
		 document.getElementById("imgloader").style.display = "none";
		 return false;
	   }
	   

	  },
	  error: function(x, t, m) {
         alert("Unable to connect slade server.");	
		 document.getElementById("imgloader").style.display = "none";
		 return false;
      }
	  
	  });
}

function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}

</script>
<?php
function roundTo($number, $to){ 
    return round($number/$to, 0)* $to; 
} 



?>

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
font-weight:bold;
}
.bal1
{
border-style:none;
background:none;
text-align:center;
font-weight:bold;
}
.bali
{
text-align:right;
}
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>
<script src="js/autocustomersmartsearchip_new.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
<div align="center" class="imgloader" id="imgloader" style="display:none;">
	<div align="center" class="imgloader" id="imgloader1" style="display:;">
	    <p style="text-align:center;" id='claim_msg'></p>
		<p style="text-align:center;"><strong>Processing <br><br> Please be patient...</strong></p>
		<img src="images/ajaxloader.gif">
	</div>
</div>
<form name="form1" id="form1" method="post" action="ipfinalinvoice.php" onSubmit="return validcheck();">	
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
   
    <td colspan="5" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="95%" 
            align="left" border="0">
          <tbody>
           <?php
		  
		  $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		   $query1 = "select locationcode,package from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		
		
		$locationcodeget = $res1['locationcode'];
		$res2package = $res1["package"];
		$query551 = "select * from master_location where locationcode='".$locationcodeget."'";
		$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$res551 = mysqli_fetch_array($exec551);
		$locationnameget = $res551['locationname'];
		}
		
		
		
$query3299 = "select a.*,b.store as store from ipmedicine_prescription as a left join master_store as b on a.store=b.storecode where patientcode = '$patientcode' and visitcode = '$visitcode' and a.medicineissue='pending' group by a.store";
$exec3299 = mysqli_query($GLOBALS["___mysqli_ston"], $query3299) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 $num3299 = mysqli_num_rows($exec3299);
        $pendingstores='';
		$pending=1;
		while($respending1 = mysqli_fetch_array($exec3299))
		{
		  if($pending>1)
           $pendingstores .= ', '.$respending1['store'];
		  else
			 $pendingstores .= $respending1['store'];

		  $pending++;
		}
		
		
		?>
             <tr>
						  <td colspan="5" class="bodytext31" bgcolor="#ecf0f5"><strong>IP Final Invoice</strong></td>
                            <td colspan="5" class="bodytext31" bgcolor="#ecf0f5"><strong>Location &nbsp;</strong><?php echo $locationnameget;?></td>
                  <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">
				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">
						</tr>
            <tr>
              <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Bill No</strong></div></td>
           
				 <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				<td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Age </strong></div></td>
				 <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Date</strong></div></td>
				<td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Admit Date</strong></div></td>
				<td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Disc Date</strong></div></td>
                <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ward</strong></div></td>
				<td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Type</strong></div></td>
                <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Fxrate</strong></div></td>
				<td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
                 <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sub Type</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
		
		$querymenu1 = "select dateofbirth from master_customer where customercode='$patientcode'";
		$execmenu1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymenu1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resmenu1 = mysqli_fetch_array($execmenu1);
		$dateofbirth=$resmenu1['dateofbirth'];

		function format_interval(DateInterval $interval) {
			$result = "0";
			if ($interval->y) { $result = $interval->format("%y"); }
			return $result;
		}
		function format_interval_dob(DateInterval $interval) {
			$result = "";
			if ($interval->y) { $result .= $interval->format("%y Years "); }
			if ($interval->m) { $result .= $interval->format("%m Months "); }
			if ($interval->d) { $result .= $interval->format("%d Days "); }

			return $result;
		}

		//this is to get subtype 
		$querymenu = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$execmenu = mysqli_query($GLOBALS["___mysqli_ston"], $querymenu) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$nummenu=mysqli_num_rows($execmenu);
		
		$resmenu = mysqli_fetch_array($execmenu);
		
		$menusub=$resmenu['subtype'];
		$patientplan = $resmenu['planname'];
		$admitid = $resmenu['admitid'];
		$availablelimit = $resmenu['overalllimit'];
		$availablelimit = number_format($availablelimit,2,'.','');
		$pvtype = $resmenu['type'];

		$savannah_authid=$resmenu['savannah_authid'];
		$patientfirstname=$resmenu['patientfirstname'];
		$patientlastname=$resmenu['patientlastname'];

		$consultationdate=$resmenu['consultationdate'];

		if($dateofbirth>'0000-00-00'){
		$today = new DateTime($consultationdate);
		$diff = $today->diff(new DateTime($dateofbirth));
		$patientage = format_interval_dob($diff);
		}else{
		  $patientage = '<font color="red">DOB Not Found.</font>';
		}
		
		$query32 = "select currency,fxrate,subtype from master_subtype where auto_number = '".$menusub."'";
		$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	//	$res2 = mysql_num_rows($exec2);
		$mastervalue = mysqli_fetch_array($exec32);
		$currency=$mastervalue['currency'];
		$fxrate=$mastervalue['fxrate'];
		$subtype=$mastervalue['subtype'];
		
		$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");
		$execplan=mysqli_fetch_array($queryplan);
		$patientplan1=$execplan['planname'];
		$smartap=$execplan['smartap'];

		
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$billtype = $res1['billtype'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		$admissiondate=$res1['consultationdate'];
		$discdate='';
		$disctime='';
		$query813 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$res813 = mysqli_fetch_array($exec813);
		$num813 = mysqli_num_rows($exec813);
		if($num813 > 0)
		{
		$updatedate=$res813['recorddate'];
		$discdate=date("d/m/Y", strtotime($res813['recorddate']));
		$disctime=$res813['recordtime'];
		}
		
		$query_admit="select recorddate,recordtime,ward from ip_bedallocation where visitcode='$visitcode' ";
		$exec_admit = mysqli_query($GLOBALS["___mysqli_ston"], $query_admit); 
		$res_admit = mysqli_fetch_array($exec_admit);
		$wardno = $res_admit['ward'];
		   
 $query_1 = "select ward from master_ward where auto_number='$wardno'";
		   $exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res_1 = mysqli_fetch_array($exec_1);
		   $ward_name = $res_1['ward'];
		   
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		//$accname = $res67['accountname'];
		$acccode = $res67['id'];
		$accountnameano = $res67['auto_number'];
		
		$scheme_id = $resmenu["scheme_id"];
	$query_sc = "select scheme_name from master_planname where scheme_id = '$scheme_id'";

	$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res_sc = mysqli_fetch_array($exec_sc);

	$accname = $res_sc['scheme_name'];
		
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
             <td align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $billnumbercode; ?></div></td>

				<input type="hidden" id="savannah_authid" name="savannah_authid" value="<?= $savannah_authid?>">	
				<input type="hidden" id="patientfirstname" name="patientfirstname" value="<?= $patientfirstname?>">	
				<input type="hidden" id="patientlastname" name="patientlastname" value="<?= $patientlastname?>">
			
			  <td align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td align="center" valign="center" class="bodytext31"><?php echo $patientage; ?> </td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($admissiondate)); ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($res_admit['recorddate']))." ".$res_admit['recordtime']; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $discdate." ".$disctime; ?></td>
					<td  align="center" valign="center" class="bodytext31"><?php echo $ward_name; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $billtype; ?></td>
                <td  align="center" valign="center" class="bodytext31"><?php echo $fxrate; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
                <td  align="center" valign="center" class="bodytext31"><?php echo $subtype; ?></td>
				<input type="hidden" name="isapprovalrequired" id="isapprovalrequired" value="<?php echo $preauthrequired; ?>">
			<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 <input type="hidden" name="packagecoa" value="<?php echo $packagecoa; ?>">
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="ipdepositscoa" value="<?php echo $ipdepositscoa; ?>">
				<input type="hidden" name="labcoa" value="<?php echo $labcoa; ?>">
				<input type="hidden" name="radiologycoa" value="<?php echo $radiologycoa; ?>">
				<input type="hidden" name="servicecoa" value="<?php echo $servicecoa; ?>">
				<input type="hidden" name="pharmacycoa" value="<?php echo $pharmacycoa; ?>">
				<input type="hidden" name="referalcoa" value="<?php echo $referalcoa; ?>">
				<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
				<input type="hidden" name="bedchargescoa" value="<?php echo $bedchargescoa; ?>">
				<input type="hidden" name="rmocoa" value="<?php echo $rmocoa; ?>">
				<input type="hidden" name="nursingcoa" value="<?php echo $nursingcoa; ?>">
				<input type="hidden" name="accomodationcoa" value="<?php echo '01-1002-NHL'; ?>">
				<input type="hidden" name="cafeteriacoa" value="<?php echo '04-6009'; ?>">
				<input type="hidden" name="privatedoctorcoa" value="<?php echo $privatedoctorcoa; ?>">
				<input type="hidden" name="ambulancecoa" value="<?php echo $ambulancecoa; ?>">
				<input type="hidden" name="nhifcoa" value="<?php echo $nhifcoa; ?>">
				<input type="hidden" name="otbillingcoa" value="<?php echo $otbillingcoa; ?>">
				<input type="hidden" name="miscbillingcoa" value="<?php echo $miscbillingcoa; ?>">
				<input type="hidden" name="admissionchargecoa" value="<?php echo $admissionchargecoa; ?>">
				<input type="hidden" name="patientbilltype" value="<?php echo $patientbilltype; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
				<input type="hidden" name="accountname" id="accountname" value="<?php echo $accname; ?>">
				<input type="hidden" name="accountcode" id="accountcode" value="<?php echo $acccode; ?>">
				<input type="hidden" name="accountnameano" id="accountnameano" value="<?php echo $accountnameano; ?>">
				<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="subtypeano" id="subtypeano" value="<?php echo $patientsubtype; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>">	
				<input type="hidden" name="discharge" id="discharge" value="<?php echo $num32; ?>">	
				<input type="hidden" name="babydischarge" id="babydischarge" value="<?php echo $numc32; ?>">
				<input type="hidden" name="babyfinalaize" id="babyfinalaize" value="<?php echo $numf32; ?>">	
				<input type="hidden" name="mother" id="mother" value="<?php echo $numv32; ?>">
				<input type='hidden' name='payercode' id='payercode' value="<?= $payer_code?>">
                <input type="hidden" name="registrationdate" id="registrationdate" value="<?php echo date('Y-m-d'); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                <input type="hidden" name="smartbenefitno" id="smartbenefitno" value="">
                <input type="hidden" name="admitid" id="admitid" value="">
                	
			   </tr>
		   <?php 
		   } 
		  
		   ?>
            </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<?php if($num32 == '0') {?>
        <td bgcolor="#FA5858" class="bodytext311" align="left"><strong>Patient is not yet discharged. Hence can not finalize the bill</strong></td>
		<?php }else {?>
		<td>&nbsp;</td>
		<?php } ?>
		</tr>
		
		<?php 
		if($numv32 == '1') {
			if($numc32 == '0') { ?>
			<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td bgcolor="#cc99ff" class="bodytext311" align="left">Baby is not yet discharged. Hence can not finalize the bill</td>
			<td>&nbsp;</td>
			</tr>
			<?php } else if($numf32 == '0'){?>
			<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td bgcolor="#cc99ff" class="bodytext311" align="left">Baby is not yet Finalized. Hence can not finalize the bill</td>
			<td>&nbsp;</td>
			</tr>
			<?php }
		}
		
		?>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<?php if($num3299 != '0') {?>
        <td  bgcolor="#ffffff"  class="bodytext311" align="left" width=""><strong style="color:red; font-size:13px; " >
            <a target="_blank" href="ippharmapendings.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&location=<?php echo $locationcodeget; ?>">
            There are Pending IP Medicine Requests for this Patient. Pl Advise Pharmacy(<?php echo $pendingstores;?>) to Clear them to reflect in Bill</a></strong></td>
		<?php }else {?>
		<td>&nbsp;</td>
		<?php } ?>
		</tr>
		
		
		
		
		
		
		 
	<tr>
    
		<?php $numpr=0;
		if($res2package != 0) {
			$query112 = "select * from privatedoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$privno = mysqli_num_rows($exec112);
			
			$query112 = "select * from residentdoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$resno = mysqli_num_rows($exec112);
			$numpr = $privno+$resno;
			if($numpr == '0') { ?>
			<!--<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td bgcolor="#cc99ff" class="bodytext311" align="left">Please do the Doctor bill first</td>
			<td>&nbsp;</td>
			</tr>-->
			
			<?php }
		} ?>
         <input type="hidden" name="splitbill" id="splitbill" value="<?php echo $numpr; ?>">	
	<tr>
	
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td width="60%">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
           <tr bgcolor="#011E6A">
                <td colspan="9" bgcolor="#ecf0f5" class="bodytext31"><strong>Transaction Details</strong></td>
			 </tr>
          
            <tr>
			 
              <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref.No</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
                
                  <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong><?php echo strtoupper($currency);?></strong></div></td>
                <td width="1%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong></strong></div></td>
                <td width="1%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong></strong></div></td>
                <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
				</tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;
			$totalop =0;
			$totalopuhx=0;
			$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			$packageanum1 = $res17['package'];
			
			
			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res53 = mysqli_fetch_array($exec53);
			$refno = $res53['docno'];
			
			if($packageanum1 != 0)
			{
			if($packchargeapply == 1)
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
		$totalopuhx=$consultationfee*$fxrate;
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
				  	 <input type="hidden" name="admissionchargerate[]" id="admissionchargerate" value="<?php echo $consultationfee; ?>">
			 <input type="hidden" name="admissionchargeamount[]" id="admissionchargeamount" value="<?php echo $consultationfee; ?>">
             
               	 <input type="hidden" name="admissionchargerateuhx[]" id="admissionchargerateuhx" value="<?php echo $consultationfee*$fxrate; ?>">
			 <input type="hidden" name="admissionchargeamountuhx[]" id="admissionchargeamountuhx" value="<?php echo $consultationfee*$fxrate; ?>">
			
	  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($consultationfee),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($consultationfee*$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee*$fxrate),2,'.',','); ?></div></td>
            </tr>
			<?php
			}
			}
			else
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
			$totalopuhx=$consultationfee*$fxrate;
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
				 		  	 <input type="hidden" name="admissionchargerate[]" id="admissionchargerate" value="<?php echo $consultationfee; ?>">
			 <input type="hidden" name="admissionchargeamount[]" id="admissionchargeamount" value="<?php echo $consultationfee; ?>">
             
              	 <input type="hidden" name="admissionchargerateuhx[]" id="admissionchargerateuhx" value="<?php echo $consultationfee*$fxrate; ?>">
			 <input type="hidden" name="admissionchargeamountuhx[]" id="admissionchargeamountuhx" value="<?php echo $consultationfee*$fxrate; ?>">
             
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($consultationfee),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($consultationfee*$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee*$fxrate),2,'.',','); ?></div></td>
            </tr>
			<?php
			}
			
			?>
					  <?php
					  $packageamount = 0;
					  $packageamountuhx=0;
			 $query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res731 = mysqli_fetch_array($exec731);
			$packageanum1 = $res731['package'];
			$packagedate1 = $res731['consultationdate'];
			$packageamount = $res731['packagecharge'];
			
			$query741 = "select * from $ippactemplate where auto_number='$packageanum1'";
			$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res741 = mysqli_fetch_array($exec741);
			$packdays1 = $res741['days'];
			$packagename = $res741['packagename'];
			
			$packageamountuhx=$packageamount*$fxrate;
			if($packageanum1 != 0)
	{
	
	 $reqquantity = $packdays1;
	 
	 $reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));
	 
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
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $packagedate1; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left" <?php if($res2package!=0){?> style=" cursor:pointer"onClick="coasearch('<?php echo $visitcode?>','<?php echo $patientcode?>')" <?php }?>><?php echo $packagename; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div>
			 <input type="hidden" name="description[]" id="description" value="<?php echo $packagename; ?>">
			 <input type="hidden" name="descriptionrate[]" id="descriptionrate" value="<?php echo $packageamount; ?>">
			 <input type="hidden" name="descriptionamount[]" id="descriptionamount" value="<?php echo $packageamount; ?>">
			 <input type="hidden" name="descriptionquantity[]" id="descriptionquantity" value="<?php echo '1'; ?>">
			  <input type="hidden" name="descriptiondocno[]" id="descriptiondocno" value="<?php echo $visitcode; ?>">
              </td>
              
               <input type="hidden" name="descriptionrateuhx[]" id="descriptionrateuhx" value="<?php echo $packageamount*$fxrate; ?>">
			 <input type="hidden" name="descriptionamountuhx[]" id="descriptionamountuhx" value="<?php echo $packageamount*$fxrate; ?>">
             
                     <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($packageamount),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($packageamount),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($packageamount*$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($packageamount*$fxrate),2,'.',','); ?></div></td>
              </tr>
			  <?php
			  }
			  ?>
			<?php 
			$totalbedallocationamount = 0;
			$totalbedallocationamountuhx=0;
			 $requireddate = '';
			 $quantity = '';
			 $allocatenewquantity = '';
			$query18 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
			$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res73 = mysqli_fetch_array($exec73);
			$packageanum = $res73['package'];
			$type = $res73['type'];
			$doctorType = $res73['doctorType'];

			$consultationdate=$res73['consultationdate'];
			if($dateofbirth>'0000-00-00'){
			  $today = new DateTime($consultationdate);
			  $diff = $today->diff(new DateTime($dateofbirth));
			  $ipage = format_interval($diff);
			}else{
			  $ipage = $res73['age'];
			}
			
			
			$query74 = "select * from $ippactemplate where auto_number='$packageanum'";
			$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res74 = mysqli_fetch_array($exec74);
		 $packdays = $res74['days'];
			
		   $query51 = "select * from `$bedtable` where auto_number='$bed'";
		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		   $res51 = mysqli_fetch_array($exec51);
		   $bedname = $res51['bed'];
		   $threshold = $res51['threshold'];
		   $thresholdvalue = $threshold/100;
		   
			
			  
			   $totalbedallocationamount=0;
			   $totalbedallocationamountuhx=0;
			   $discount_bed = 0;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus,discount_amt from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				while($res18 = mysqli_fetch_array($exec18))
				{
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];			

					$ward_discount=0;
					$sql_ward_disc="select discount from ward_scheme_discount where ward_id='$ward' and account_id='$accountname' and record_status='1'";
					$warddisc73 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_ward_disc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$wardnum73 = mysqli_num_rows($warddisc73);
					if($wardnum73>0){
					$wardres73 = mysqli_fetch_array($warddisc73);
					$ward_discount=$wardres73['discount'];

					}

					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];
					$leavingdate = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					$discount_bed = $res18['discount_amt'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
					$res51 = mysqli_fetch_array($exec51);
					$bedname = $res51['bed'];
					$threshold = $res51['threshold'];
					$thresholdvalue = $threshold/100;
					$time1 = new DateTime($bedallocateddate);
					$time2 = new DateTime($leavingdate);
					$interval = $time1->diff($time2);			  
					$quantity1_bedt=$quantity1 = $interval->format("%a");
					$pack_days=$packdays1;//added by krishna
						//echo $packdays1;
					//echo $quantity1;
					if($packdays1>$quantity1)
					{
					              
						$quantity1=$quantity1-$packdays1; 
						          
						$packdays1=$packdays1-$quantity1_bedt;
						
					}
					else
					{
						$quantity1=$quantity1-$packdays1;
						$packdays1=0;
					}
			
					$quantity='0';
					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' ";
					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
					$num91 = mysqli_num_rows($exec91);

					$tmp=array();
					$tmpbed=array();
					$tmpbedcharge=array();
					while($res91 = mysqli_fetch_array($exec91))
					{
                       $tmp[]=$res91;
					}
										
					if(is_array($tmp)){
						foreach($tmp as $k =>$v){
						   if($v[0]=='Accommodation Only'){
                              $tmpbed[0]=$v[0];
							  $tmpbed['charge']=$v[0];
						      $tmpbed[1]=$v[1];
							  $tmpbed['rate']=$v[1];
                              unset($tmp[$k]);
						   }
						}

						if(is_array($tmpbed) and count($tmpbed)>0){
                           
						   foreach($tmp as $k =>$v){
                              if($v[0]=='Bed Charges'){
                                 $tmpbedcharge[]=$v;
								 $tmpbedcharge[]=$tmpbed;
							  }else
								  $tmpbedcharge[]=$v;

						   }
						   unset($tmp);
						   $tmp=$tmpbedcharge;
						}
					}
					
					foreach($tmp as $rslt)
					{
                        $charge = $rslt['charge'];
						$rate = $rslt['rate'];	
                        
						if($doctorType==1 && $charge=='Daily Review charge')
							continue;
						elseif($doctorType==0 && $charge=='Consultant Fee')
							continue;

						if($ipage>7 && $charge=='Accommodation Only' )
						  continue;
						
						
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
							$rate = $rate-$discount_bed-$ward_discount;
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
						if($quantity>0 && $amount>0)
						{
							if($type=='hospital'||$charge!='Resident Doctor Charges')
							{
								$colorloopcount = $sno + 1;
								if($charge == 'Cafetaria Charges')
									{
										$charge1 = 'Meals';
									}
									elseif($charge == 'Nursing Charges')
									{
										$charge1 = 'Nursing Care';
									}
									elseif($charge == 'RMO Charges')
									{
										$charge1 = 'Doctors Review';
									}
									elseif($charge == 'Accommodation Charges')
									{
										$charge1 = 'Non Pharms';
									}
									else{
										$charge1 = $charge;
									}
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
								 if($quantity!=0){ 
								$totalbedallocationamount=$totalbedallocationamount+($amount);
								$amountuhx = $rate*$quantity;
								$totalbedallocationamountuhx = $totalbedallocationamountuhx + ($amountuhx*$fxrate);
									$bedallocateddate1 = date('Y-m-d',strtotime($bedallocateddate) + (24*3600*$pack_days));//added by krishna	
					  ?>
								<tr <?php echo $colorcode; ?>>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bedallocateddate1; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge1; ?>(<?php echo $bedname; ?>)</div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
                                    <input type="hidden" name="descriptioncharge12[]" id="descriptioncharge12" value="<?php echo $charge; ?>">
                                     <input type="hidden" name="descriptionchargerate12[]" id="descriptionchargerate12" value="<?php echo $rate; ?>">
                                     <input type="hidden" name="descriptionchargeamount12[]" id="descriptionchargeamount12" value="<?php echo $quantity*($rate); ?>">
									
									<input type="hidden" name="descriptionchargequantity12[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>">
									<input type="hidden" name="descriptionchargedocno12[]" id="descriptionchargedocno" value="<?php echo $refno; ?>">
									<input type="hidden" name="descriptionchargeward12[]" id="descriptionchargeward" value="<?php echo $ward; ?>">
									<input type="hidden" name="descriptionchargebed12[]" id="descriptionchargebed" value="<?php echo $bed; ?>">
                                    <input type="hidden" name="descriptionchargerate12uhx[]" id="descriptionchargerate12uhx" value="<?php echo $rate*$fxrate; ?>">
			 <input type="hidden" name="descriptionchargeamount12uhx[]" id="descriptionchargeamount12uhx" value="<?php echo $rate*$quantity*$fxrate; ?>">
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($rate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($quantity*($rate)),2,'.',','); ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($rate*$fxrate,2,'.',','); ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount*$fxrate,2,'.',','); ?></div></td>
								</tr>              
					 
					   <?php  } // if quantity !=0 loop  
							}
						}
					}
				}
				$totalbedtransferamount=0;
				$totalbedtransferamountuhx=0;
				$discount_bed =0 ;
			
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus,discount_amt from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				while($res18 = mysqli_fetch_array($exec18))
				{
					$quantity1=0;
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];		
					
					$ward_discount=0;
					$sql_ward_disc="select discount from ward_scheme_discount where ward_id='$ward' and account_id='$accountname' and record_status='1'";
					$warddisc73 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_ward_disc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$wardnum73 = mysqli_num_rows($warddisc73);
					if($wardnum73>0){
					$wardres73 = mysqli_fetch_array($warddisc73);
					$ward_discount=$wardres73['discount'];

					}


					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					//$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];

					$leavingdate = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					$discount_bed = $res18['discount_amt'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' ";
					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
					$num91 = mysqli_num_rows($exec91);
					while($res91 = mysqli_fetch_array($exec91))
					{
						$charge = $res91['charge'];
						$rate = $res91['rate'];	

						if($doctorType==1 && $charge=='Daily Review charge')
							continue;
						elseif($doctorType==0 && $charge=='Consultant Fee')
							continue;
						 
						if($ipage > 7 && $charge=='Accommodation Only' ) {
						  continue;
						  }
						
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
							$rate = $rate-$discount_bed-$ward_discount;
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
							if($quantity>0 && $amount>0)
							{
								if($type=='hospital'||$charge!='Resident Doctor Charges')
								{
									$colorloopcount = $sno + 1;
									if($charge == 'Cafetaria Charges')
									{
										$charge1 = 'Meals';
									}
									elseif($charge == 'Nursing Charges')
									{
										$charge1 = 'Nursing Care';
									}
									elseif($charge == 'RMO Charges')
									{
										$charge1 = 'Doctors Review';
									}
									elseif($charge == 'Accommodation Charges')
									{
										$charge1 = 'Non Pharms';
									}
									else{
										$charge1 = $charge;
									}
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

									 if($quantity!=0){ 
									$totalbedtransferamount=$totalbedtransferamount+($amount);
									$amountuhx = $rate*$quantity;
									$totalbedtransferamountuhx = $totalbedtransferamountuhx + ($amountuhx*$fxrate);
						  ?>
									<tr <?php echo $colorcode; ?>>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge1; ?>(<?php echo $bedname; ?>)</div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
										<input type="hidden" name="descriptioncharge[]" id="descriptioncharge12" value="<?php echo $charge; ?>">
                                         <input type="hidden" name="descriptionchargerate[]" id="descriptionchargerate12" value="<?php echo $rate; ?>">
                                         <input type="hidden" name="descriptionchargeamount[]" id="descriptionchargeamount12" value="<?php echo $quantity*($rate); ?>">
										<input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>">
										<input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>">
										<input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>">
										<input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bed; ?>">
                                        <input type="hidden" name="descriptionchargerateuhx[]" id="descriptionchargerate12uhx" value="<?php echo $rate*$fxrate; ?>">
			 <input type="hidden" name="descriptionchargeamountuhx[]" id="descriptionchargeamount12uhx" value="<?php echo $rate*$quantity*$fxrate; ?>">
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($rate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($quantity*($rate)),2,'.',','); ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($rate*$fxrate,2,'.',','); ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount*$fxrate,2,'.',','); ?></div></td>
									</tr>              
						 
						   <?php  } // if quantity !=0 loop  
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
			  ?>
			 
			   <?php 

			$original_fxrate= $fxrate;
			if(strtoupper($currency)=="USD"){
				$fxrate = $pharmacy_fxrate;
			}			   

			$totalpharm=0;
			$totalpharmuhx=0;
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' GROUP BY ipdocno,itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
			$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		    $res331 = mysqli_fetch_array($exec331);
			
			$quantity1=$res331['quantity'];
			//$phaquantity1=$phaquantity1+$quantity1;
			$amount1=$res331['totalamount'];
			//$phaamount1=$phaamount1+$amount1;
			
			
			$resquantity = $quantity - $quantity1;
			$resamount = $amount - $amount1;
						
			$resamount=number_format($resamount,2,'.','');
			//if($resquantity != 0)
			{
			if(strtoupper($pharmfree) =='NO')
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
			
		//	$resamount=$resquantity*($pharate/$fxrate);
			 if($resquantity!=0){
			$resamount=number_format(($resamount/$fxrate),2,'.','');
			$totalpharm=$totalpharm+$resamount;
			
			 $resamountuhx = $pharate*$resquantity;
		   $totalpharmuhx = $totalpharmuhx + $resamountuhx;
			
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="itemcode[]" type="hidden" id="itemcode" size="25" value="<?php echo $phaitemcode; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $resquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate/$fxrate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $resamount; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo floatval($resquantity); ?></div></td>
             
              <input name="rateuhx[]" type="hidden" id="rateuhx" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amountuhx[]" type="hidden" id="amountuhx" readonly size="8" value="<?php echo $pharate*$resquantity; ?>">
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($pharate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($resquantity*($pharate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($pharate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($pharate*$resquantity),2,'.',','); ?></div></td>
                  
             <?php } } // if quantity !=0 loop  
			  }
			  }
			
			  ?>

			  <!-- Package processing all sections start  -->

			   <?php 

			$querypkg = "select package,package_process,packagecharge from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$execpkg = mysqli_query($GLOBALS["___mysqli_ston"], $querypkg) or die ("Error in Package Query".mysqli_error($GLOBALS["___mysqli_ston"]));
			$respkg = mysqli_fetch_array($execpkg);
			$packageid=$respkg['package'];
			$package_amt=$respkg['packagecharge'];
			
			$qrypackage = "select servicesitem,rate,servicescode from master_ippackage where auto_number = '$packageid'";
			$execpackage = mysqli_query($GLOBALS["___mysqli_ston"], $qrypackage);
			$respackage = mysqli_fetch_array($execpackage);
			//$package_amt = $respackage['rate'];
			$package_service = $respackage['servicesitem'];
			$package_servicecode = $respackage['servicescode'];
			$mis_amt_service=0;
			?>
			   <input name="packageid" type="hidden"  readonly value="<?php echo $packageid; ?>">
			   <input name="packagemiscode" type="hidden"  readonly value="<?php echo $package_servicecode; ?>">
			   <input name="packagemisname" type="hidden"  readonly value="<?php echo $package_service; ?>">
			  <?php  


			  	 $qrylab = "select id,itemcode,itemname,rate,amount from package_processing where package_id = '$packageid' and package_item_type IN('MI','SI') and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> '' ";
		 $service_pharmacy_used_amt = 0;
		 $execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($reslab = mysqli_fetch_array($execlab))
		{
			$itemcode = $reslab['itemcode'];
			$itemname = $reslab['itemname'];
			$itemrate = $reslab['rate'];
			$rowid     = $reslab['id'];
			
			$sno = $sno + 1;

			$issqry = "select id from package_execution where processing_id='$rowid'";
			$execiss = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$iss_num_rows = mysqli_num_rows($execiss);
			if($iss_num_rows)
			{

				$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$issqry1 = "select sum(qty) issuedqty from package_execution where processing_id='$rowid'";
				$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$resiss1 = mysqli_fetch_array($execiss1);
				$issuedqty = $resiss1['issuedqty'];
				$used_amount = $issuedqty * $itemrate;
				$service_pharmacy_used_amt = $service_pharmacy_used_amt + $used_amount;
			}
			
		 }


		$lab_rad_doc_amt = 0;
		$qrylab2 = "select sum(amount) as totolamt from package_processing where package_id = '$packageid' and package_item_type IN('LI','RI','DC') and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> ''";
					   $execlab2= mysqli_query($GLOBALS["___mysqli_ston"], $qrylab2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					   $reslab2 = mysqli_fetch_array($execlab2);
					   $lab_rad_doc_amt=$reslab2['totolamt'];
			   

			   $process_amt = $service_pharmacy_used_amt + $lab_rad_doc_amt;



			  $qrylab = "select id,itemcode,itemname,rate,amount,package_item_type from package_processing where package_id = '$packageid' and package_item_type IN('SI','LI','MI','RI','DC') and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> ''";
             
			     $package_used_amt = 0;
				 $execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			   //$qrylab2 = "select sum(amount) as totolamt from package_processing where package_id = '$packageid' and package_item_type IN('SI','LI','MI','RI','CT') and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> ''";
			   /*$qrylab2 = "select sum(amount) as totolamt from package_processing pp inner join package_execution pe on pp.id=pe.processing_id where pp.package_id = '$packageid' and pp.package_item_type IN('SI','LI','MI','RI','DC') and pp.patientcode='$patientcode' and pp.visitcode='$visitcode' and pp.recordstatus <> ''";
			   
			   $execlab2= mysql_query($qrylab2) or die(mysql_error());
			   $reslab2 = mysql_fetch_array($execlab2);
			   $process_amt=$reslab2['totolamt'];*/
			   
			   $mis_amt_service=$package_amt-$process_amt;

				while($reslab = mysqli_fetch_array($execlab))
				{
					$itemcode = $reslab['itemcode'];
					$itemname = $reslab['itemname'];
					
					$itemrate = $reslab['rate'];
					$rowid     = $reslab['id'];
					$pack_item_type = $reslab['package_item_type'];
					
					$pack_item_type = $reslab['package_item_type'];
					$item_amount = $reslab['amount'];
				
					$issqry = "select id from package_execution where processing_id='$rowid'";
					$execiss = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$iss_num_rows = mysqli_num_rows($execiss);
					
					if($iss_num_rows)
					{

						$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$issqry1 = "select sum(qty) issuedqty,date(created_on) as created_on from package_execution where processing_id='$rowid'";
						$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$resiss1 = mysqli_fetch_array($execiss1);
						$issuedqty = $resiss1['issuedqty'];
						if($issuedqty==0)
							$issuedqty=1;

						$process_date = $resiss1['created_on'];
						if($pack_item_type == 'SI' || $pack_item_type == 'MI' )
						$used_amount = $issuedqty * $itemrate;
						else
						$used_amount = $itemrate;

						if($pack_item_type == 'MI' )
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

						?>
							 <input name="medicinenamepkg[]" type="hidden" size="25" value="<?php echo $itemname; ?>">
							 <input name="medicinecodepkg[]" type="hidden" size="25" value="<?php echo $itemcode; ?>">
							  <input name="medicinerowidpkg[]" type="hidden" size="25" value="<?php echo $rowid; ?>">
							 <input name="quantitypkg[]" type="hidden"  size="8" readonly value="<?php echo $issuedqty; ?>">
							 <input name="ratepkg[]" type="hidden"  readonly size="8" value="<?php echo $itemrate; ?>">
							 <input name="amountpkg[]" type="hidden" readonly size="8" value="<?php echo $used_amount; ?>">

				  			<?php 
						} 

						if($pack_item_type == 'SI' )
						{
						?>
						 
			           
							<input name="servicespkg[]" type="hidden"  size="69" value="<?php echo $itemname; ?>">
							<input name="servicesitemcodepkg[]" type="hidden"  size="69" value="<?php echo $itemcode; ?>">
							<input name="servicesrowidpkg[]" type="hidden" size="25" value="<?php echo $rowid; ?>">
							<input name="rate3pkg[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $used_amount; ?>">
							<input name="quantityserpkg[]" type="hidden"  readonly size="8" value="<?php echo $issuedqty; ?>">
							<input name="rate3uhxpkg[]" type="hidden"  readonly size="8" value="<?php echo $used_amount; ?>">
							<input name="wellnesspkg[]" type="hidden" readonly size="8" value="0">
							<input type="hidden" name="serviceledgcodepkg[]"  value="">
							<input type="hidden" name="serviceledgnamepkg[]"  value="">
							<input type="hidden" name="servicedoctorcodepkg[]"  value="">
							<input type="hidden" name="servicedoctornamepkg[]"  value="">
				  			<?php 
						} 
						if($pack_item_type == 'LI')
						{
						?>
						 
			           
							<input name="labpkg[]"  size="69" type="hidden" value="<?php echo $itemname; ?>">
							<input name="rate5pkg[]"  readonly size="8" type="hidden" value="<?php echo $itemrate; ?>">
							<input name="labcodepkg[]"  readonly size="8" type="hidden" value="<?php echo $itemcode; ?>">
							<input name="labrowidpkg[]" type="hidden" size="25" value="<?php echo $rowid; ?>">
							<input name="rate5uhxpkg[]" id="rate5uhx" readonly size="8" type="hidden" value="<?php echo $itemrate*$fxrate; ?>"> 
				  			<?php 
						} 

						if($pack_item_type == 'RI')
						{
						?>
						 
			           
							<input name="radiologypkg[]" type="hidden" size="69" autocomplete="off" value="<?php echo $itemname; ?>">
							<input name="radiologycodepkg[]" type="hidden" size="69" autocomplete="off" value="<?php echo $itemcode; ?>">
							<input name="radiologyrowidpkg[]" type="hidden" size="25" value="<?php echo $rowid; ?>">
							<input name="rate8pkg[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $itemrate; ?>">
							<input name="rate8uhxpkg[]" type="hidden"  readonly size="8" value="<?php echo $itemrate*$fxrate; ?>">
				  			<?php 
						} 

						if($pack_item_type == 'DC')
						{
						?>
							<input type="hidden" name="privatedoctorpkg[]" id="privatedoctor" value="<?php echo $itemname; ?>">
							<input type="hidden" name="privatedoctorcode[]"  value="<?php echo $itemcode; ?>">
							<input type="hidden" name="privatedoctorratepkg[]"  value="<?php echo $itemrate; ?>">
							<input type="hidden" name="privatedoctoramountpkg[]"  value="<?php echo $itemrate; ?>">
							<input type="hidden" name="privatedoctorquantitypkg"  value="1">
							<input type="hidden" name="doccoapkg[]" id="doccoa" value="">
							<input name="privatedoctorrowidpkg[]" type="hidden" size="25" value="<?php echo $rowid; ?>">

							<input type="hidden" name="privatedoctorrateuhxpkg[]" id="privatedoctorrateuhx" value="<?php echo $itemrate; ?>">
							<input type="hidden" name="privatedoctoramountuhx[]" id="privatedoctoramountuhx" value="<?php echo $itemrate; ?>">
				  			<?php 
						} 
						} 
				}

			   
				
				?>
				<input type="hidden" name="mis_amt_service" id="mis_amt_service" value="<?php echo $mis_amt_service;?>">
			    <!-- Package processing all sections end -->
			  <?php 
			 
			 
			$fxrate = $original_fxrate;

			  $totallab=0;
			    $totallabuhx=0;
			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund' ";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
			$queryl51 = "select rateperunit from `$labtable` where itemcode='$labcode'";
			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $labrate; ?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
             
              <input name="rate5uhx[]" id="rate5uhx" readonly size="8" type="hidden" value="<?php echo $labrate*$fxrate; ?>">
              
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($labrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($labrate*$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($labrate*$fxrate),2,'.',','); ?></div></td>
                  
             <?php }
			  }
			  ?>
			
			    <?php 
				$totalrad=0;
				$totalraduhx=0;
			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
			$queryr51 = "select rateperunit from `$radtable` where itemcode='$radiologyitemcode'";
			$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>

			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="radiologcode[]" id="radiologcode" type="hidden" size="69" autocomplete="off" value="<?php echo $radiologyitemcode; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $radrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
              <input name="rate8uhx[]" type="hidden" id="rate8uhx" readonly size="8" value="<?php echo $radrate*$fxrate; ?>">
             
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($radrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($radrate*$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($radrate*$fxrate),2,'.',','); ?></div></td>
                  
             <?php }
			  }
			  ?>

		

			  	  	  <?php 
					
					$totalser=0;
					$totalseruhx=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and wellnessitem <> '1' group by servicesitemname,iptestdocno";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$servicesdoctorname = $res21['doctorname'];
			$servicesdoctorcode = $res21['doctorcode'];
			$sercode=$res21['servicesitemcode'];
			$serviceledgercode=$res21['incomeledgercode'];
			$serviceledgername=$res21['incomeledgername'];
			$wellnesspkg=$res21['wellnesspkg'];

			$serperc = "select ipservice_percentage from master_doctor where doctorcode = '$servicesdoctorcode'";		
			$execserperc = mysqli_query($GLOBALS["___mysqli_ston"], $serperc) or die("Error in SerPerc".mysqli_error($GLOBALS["___mysqli_ston"]));		
			$resserperc = mysqli_fetch_array($execserperc);		
			$ipserpercentage = $resserperc['ipservice_percentage'];


			$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";
			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$ress51 = mysqli_fetch_array($execs51);
			$serrate = $ress51['rateperunit'];
			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$numrow2111 = mysqli_num_rows($exec2111);
			$res211 = mysqli_fetch_array($exec2111);
			$serqty=$res21['serviceqty'];
			if($serqty==0){$serqty=$numrow2111;}
			
			if(strtoupper($servicesfree) == 'NO')
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
			 if($serqty!=0){
			$totalser=$totalser+$totserrate;
			
			 $totserrateuhx = ($totserrate*$fxrate);
		   $totalseruhx = $totalseruhx + $totserrateuhx;
			?>
            
            
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?>
             <input type="hidden" name="serviceledgcode[]" id="serviceledgcode" value="<?= $serviceledgercode ?>">
             <input type="hidden" name="serviceledgname[]" id="serviceledgname" value="<?= $serviceledgername ?>">
			 <input type="hidden" name="servicedoctorcode[]" id="servicedoctorcode" value="<?= $servicesdoctorcode ?>">
             <input type="hidden" name="servicedoctorname[]" id="servicedoctorname" value="<?= $servicesdoctorname ?>">
             <?php $sharingamt = $totserrate * ($ipserpercentage/100); ?>		
             <input type="hidden" name="ipserpercentage[]" id="ipserpercentage" value="<?= $ipserpercentage ?>">		
          	 <input type="hidden" name="sharingamt[]" id="sharingamt" value="<?= $sharingamt ?>">
             </div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername." - ".$servicesdoctorname; ?></div></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="servicesitemcode[]" type="hidden" id="servicesitemcode" size="69" value="<?php echo $sercode; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $totserrate; ?>">
			 <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $serqty; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
             
             <input name="rate3uhx[]" type="hidden" id="rate3uhx" readonly size="8" value="<?php echo ($totserrate*$fxrate); ?>">
             
			              <input name="wellnesspkg[]" type="hidden" id="wellnesspkg" readonly size="8" value="<?php echo $wellnesspkg; ?>">

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($totserrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($serrate*$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format((($totserrate*$fxrate)),2,'.',','); ?></div></td>
                  
             <?php }   } // if quantity !=0 loop  
			  }
			  ?>

			  
			<?php
			$totalotbillingamount = 0;
			$totalotbillingamountuhx=0;
			$query61 = "select * from ip_otbilling where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res61 = mysqli_fetch_array($exec61))
		   {
			$otbillingdate = $res61['consultationdate'];
			$otbillingrefno = $res61['docno'];
			$otbillingname = $res61['surgeryname'];
			$otbillingrate = $res61['rate'];
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
			$otbillingrate = 1*($otbillingrate/$fxrate);
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
			
			 $otbillingrateuhx = $otbillingrate;
		   $totalotbillingamountuhx = $totalotbillingamountuhx + $otbillingrateuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $otbillingdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $otbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $otbillingname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			  		 <input type="hidden" name="otbilling[]" id="otbilling" value="<?php echo $otbillingname; ?>">
			 	 <input type="hidden" name="otbillingrate[]" id="otbillingrate" value="<?php echo $otbillingrate/$fxrate; ?>">
			 <input type="hidden" name="otbillingamount[]" id="otbillingamount" value="<?php echo $otbillingrate/$fxrate; ?>">
             
              <input type="hidden" name="otbillingrateuhx[]" id="otbillingrateuhx" value="<?php echo $otbillingrate; ?>">
			 
  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($otbillingrate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format((1*($otbillingrate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($otbillingrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($otbillingrate*1),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
				<?php
			$totalprivatedoctoramount = 0;
			$totalprivatedoctoramountuhx=0;
			$copayamt =0;
			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg = '1'";
			$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res62 = mysqli_fetch_array($exec62))
		   {
			$privatedoctordate = $res62['consultationdate'];
			$privatedoctorrefno = $res62['docno'];
			$privatedoctor = $res62['doctorname'];
			$privatedoctorrate = $res62['rate'];
			$privatedoctoramount = $res62['amount'];
			$privatedoctorunit = $res62['units'];
			$description = $res62['remarks'];
			$doccoa = $res62['doccoa'];

			$query20 = "select pvtdr_percentage,ip_consultation_private_sharing from master_doctor where doctorcode = '$doccoa'";		
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));		
			$res20 = mysqli_fetch_array($exec20);		
			//$sharingperc = $res20['pvtdr_percentage'];
            
			if($pvtype=='private')
				$sharingperc = $res20['ip_consultation_private_sharing'];
			else
				$sharingperc = $res20['pvtdr_percentage'];

			if($description != '')
			{
			$description = '-'.$description;
			}
			
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

			$queryve1 = "select planfixedamount,planpercentage from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
			$execve1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryve1) or die ("Error in queryve1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $resve1 = mysqli_fetch_array($execve1);

			/*if($resve1['planfixedamount'] > 0)
				$copayamt = $resve1['planfixedamount'];
			elseif($resve1['planpercentage']>0)
			    $copayamt =( $privatedoctoramount/100)*$resve1['planpercentage'] ;
			else*/
				$copayamt =0;

			$privatedoctoramount = $privatedoctorunit*($privatedoctorrate/$fxrate)-$copayamt;
			$pvtdrsharingamt = $privatedoctoramount * ($sharingperc/100);
			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
			
			 $privatedoctoramountuhx = $privatedoctorrate*$privatedoctorunit-$copayamt;
		   $totalprivatedoctoramountuhx = $totalprivatedoctoramountuhx + $privatedoctoramountuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctordate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctorrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $privatedoctor.' '.$description; ?></div></td>
			 		 <input type="hidden" name="privatedoctor[]" id="privatedoctor" value="<?php echo $privatedoctor; ?>">
			 	 <input type="hidden" name="privatedoctorrate[]" id="privatedoctorrate" value="<?php echo $privatedoctorrate/$fxrate; ?>">
			 <input type="hidden" name="privatedoctoramount[]" id="privatedoctoramount" value="<?php echo $privatedoctoramount; ?>">
			 <input type="hidden" name="privatedoctorquantity[]" id="privatedoctorquantity" value="<?php echo $privatedoctorunit; ?>">
			 <input type="hidden" name="pvtdrdoccoa[]" id="doccoa" value="<?php echo $doccoa; ?>">
			 <input type="hidden" name="pvtdrpercentage[]" id="pvtdrpercentage" value="<?php echo $sharingperc; ?>">		
			 <input type="hidden" name="pvtdrsharingamt[]" id="pvtdrsharingamt" value="<?php echo $pvtdrsharingamt; ?>">
             
              <input type="hidden" name="privatedoctorrateuhx[]" id="privatedoctorrateuhx" value="<?php echo $privatedoctorrate; ?>">
			 <input type="hidden" name="privatedoctoramountuhx[]" id="privatedoctoramountuhx" value="<?php echo $privatedoctorrate*$privatedoctorunit; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctorunit; ?></div></td>
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($privatedoctorrate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($privatedoctorunit*($privatedoctorrate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($privatedoctorrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($privatedoctorrate*$privatedoctorunit),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				 if($copayamt > 0 ) {
			    $showcolor = (($colorloopcount+1) & 1); 
				if ($showcolor == 0)
				{
					//echo "if";
					$colorcode = 'bgcolor="#CBDBFA"';
				}
				else
				{
					//echo "else";
					$colorcode = 'bgcolor="#ecf0f5"';
				}  ?>
 <tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctordate; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="left">Copay Amount</div></td>

				<td class="bodytext31" valign="center"  align="left"><div align="center">1</div></td>
             
              <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format(($copayamt),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php //echo number_format(($copayamt),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php //echo number_format(($copayamt),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format(($copayamt),2,'.',','); ?></div></td>

				</tr>
                <?php
				}
			$totalambulanceamount = 0;
			$totalambulanceamountuhx=0;
			$query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;
			
			 $ambulanceamountuhx = $ambulancerate*$ambulanceunit;
		   $totalambulanceamountuhx = $totalambulanceamountuhx + $ambulanceamountuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancedate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancerefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $ambulance; ?></div></td>
			 <input type="hidden" name="ambulance[]" id="ambulance" value="<?php echo $ambulance; ?>">
			 	 <input type="hidden" name="ambulancerate[]" id="ambulancerate" value="<?php echo $ambulancerate/$fxrate; ?>">
			 <input type="hidden" name="ambulanceamount[]" id="ambulanceamount" value="<?php echo $ambulanceamount; ?>">
			 <input type="hidden" name="ambulancequantity[]" id="ambulancequantity" value="<?php echo $ambulanceunit; ?>">
	
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulanceunit; ?></div></td>
             
             	 <input type="hidden" name="ambulancerateuhx[]" id="ambulancerateuhx" value="<?php echo $ambulancerate; ?>">
			 <input type="hidden" name="ambulanceamountuhx[]" id="ambulanceamountuhx" value="<?php echo $ambulancerate*$ambulanceunit; ?>">
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($ambulancerate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($ambulanceunit*($ambulancerate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($ambulancerate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($ambulancerate*$ambulanceunit),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
				<?php
			$totalmiscbillingamount = 0;
			$totalmiscbillingamountuhx=0;
			$query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res69 = mysqli_fetch_array($exec69))
		   {
			$miscbillingdate = $res69['consultationdate'];
			$miscbillingrefno = $res69['docno'];
			$miscbilling = $res69['description'];
			$miscbillingrate = $res69['rate'];
			$miscbillingamount = $res69['amount'];
			$miscbillingunit = $res69['units'];

			$ledname = $res69['billingaccountname'];
			$ledid = $res69['billingaccountcode'];
			
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
		   $totalmiscbillingamountuhx = $totalmiscbillingamountuhx + $miscbillingamountuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $miscbilling; ?></div></td>
			  <input type="hidden" name="miscbilling[]" id="miscbilling" value="<?php echo $miscbilling; ?>">
			 	 <input type="hidden" name="miscbillingrate[]" id="miscbillingrate" value="<?php echo $miscbillingrate/$fxrate; ?>">
			 <input type="hidden" name="miscbillingamount[]" id="miscbillingamount" value="<?php echo $miscbillingamount; ?>">
			 <input type="hidden" name="miscbillingquantity[]" id="miscbillingquantity" value="<?php echo $miscbillingunit; ?>">

			 <input type="hidden" name="ledname[]" id="ledname" value="<?php echo $ledname; ?>">
			 <input type="hidden" name="ledid[]" id="ledid" value="<?php echo $ledid; ?>">
	
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingunit; ?></div></td>
             
              <input type="hidden" name="miscbillingrateuhx[]" id="miscbillingrateuhx" value="<?php echo $miscbillingrate; ?>">
			 <input type="hidden" name="miscbillingamountuhx[]" id="miscbillingamountuhx" value="<?php echo $miscbillingrate*$miscbillingunit; ?>">
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($miscbillingrate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($miscbillingunit*($miscbillingrate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($miscbillingrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($miscbillingrate*$miscbillingunit),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
				<?php
			$totaldiscountamount = 0;
			$totaldiscountamountuhx=0;
			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res64 = mysqli_fetch_array($exec64))
		   {
			$discountdate = $res64['consultationdate'];
			$discountrefno = $res64['docno'];
			$discount= $res64['description'];
			$discountrate = $res64['rate'];
			$discountrate1 = -$discountrate;
			$discountrate = -$discountrate;
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
		   $totaldiscountamountuhx = $totaldiscountamountuhx + $discountrateuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $discountdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $discountrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($discountrate1/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format((1*($discountrate1/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($discountrate1),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($discountrate1*1),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
						<?php
			$totalnhifamount = 0;
			$totalnhifamountuhx=0;
			$query641 = "select * from ip_nhifprocessing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res641= mysqli_fetch_array($exec641))
		   {
			$nhifdate = $res641['consultationdate'];
			$nhifrefno = $res641['docno'];
			$nhifqty = $res641['totaldays'];
			$nhifrate = $res641['nhifrebate'];
			$nhifclaim = $res641['nhifclaim'];
			$nhif_claimdays = $res641['nhif_claimdays'];
			if($nhif_claimdays=='0'){
			$nhifqty = -$nhifqty;
			$nhifclaim = -$nhifclaim;
			}
			
						
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
			$nhifclaim = $nhifqty*($nhifrate/$fxrate);
			$totalnhifamount = $totalnhifamount + $nhifclaim;
			
			 $nhifclaimuhx = $nhifrate*$nhifqty;
		   $totalnhifamountuhx = $totalnhifamountuhx + $nhifclaimuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo 'NHIF- Gain / Loss'; ?></div></td>
			 	
			 	 <input type="hidden" name="nhifrate[]" id="nhifrate" value="<?php echo $nhifrate/$fxrate; ?>">
			 <input type="hidden" name="nhifamount[]" id="nhifamount" value="<?php echo $nhifclaim; ?>">
			 <input type="hidden" name="nhifquantity[]" id="nhifquantity" value="<?php echo $nhifqty; ?>">
             
              <input type="hidden" name="nhifrateuhx[]" id="nhifrateuhx" value="<?php echo $nhifrate; ?>">
			 <input type="hidden" name="nhifamountuhx[]" id="nhifamountuhx" value="<?php echo $nhifrate*$nhifqty; ?>">
	
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifqty; ?></div></td>
                 
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($nhifrate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($nhifqty*($nhifrate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($nhifrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($nhifrate*$nhifqty),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
			<?php
			$totaldepositamount = 0;
			$totaldepositamountuhx=0;
			$query112 = "select * from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode' and transactionmodule <> 'Adjustment'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositamount = $res112['transactionamount'];
			$depositamount1 = -$depositamount;
			$docno = $res112['docno'];
			$transactionmode = $res112['transactionmode'];
			$transactiondate = $res112['transactiondate'];
			$chequenumber = $res112['chequenumber'];
			
			$query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res731 = mysqli_fetch_array($exec731);
			$depositbilltype = $res731['billtype'];
		
			
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
			$depositamount1 = 1*($depositamount/$fxrate);
			$totaldepositamount = $totaldepositamount + $depositamount1;
			
			 $depositamount1uhx = $depositamount;
		   $totaldepositamountuhx = $totaldepositamountuhx + $depositamount1uhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Deposit'; ?>&nbsp;&nbsp;<?php echo $transactionmode; ?>
             
			 <?php
			 if($transactionmode == 'CHEQUE')
			 {
			 echo $chequenumber;
			 }
			 ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'. number_format(($depositamount/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo '-'. number_format((1*($depositamount/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo '-'.  number_format(($depositamount),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'. number_format(($depositamount*1),2,'.',','); ?></div></td>
                  
                  
             <?php }
			 $totaladvancedepositamount = 0;
			$totaladvancedepositamountuhx=0;
			$query112 = "select * from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res112 = mysqli_fetch_array($exec112))
			{
			$advancedepositamountfx = $res112['transactionamount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['transactiondate'];
			
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
			$advancedepositamount = 1*($advancedepositamountfx/$fxrate);
			$totaldepositamount += $advancedepositamount;
			
			 $advancedepositamountuhx = $advancedepositamountfx;
		   $totaldepositamountuhx = $totaldepositamountuhx + $advancedepositamountuhx;
			

			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Advance Deposit'; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($advancedepositamountfx/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format((1*($advancedepositamountfx/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($advancedepositamountfx),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format(($advancedepositamountfx*1),2,'.',','); ?></div></td>
                  
             <?php 
			  }
			  ?>
			  		  <?php
			$totaldepositrefundamount = 0;
			$totaldepositrefundamountuhx=0;
			$query112 = "select * from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositrefundamountfx = $res112['amount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['recorddate'];
			
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
			$depositrefundamount = 1*($depositrefundamountfx/$fxrate);
			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			
			 $depositrefundamountuhx = $depositrefundamountfx;
		   $totaldepositrefundamountuhx = $totaldepositrefundamountuhx + $depositrefundamountuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Deposit Refund'; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($depositrefundamountfx/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format((1*($depositrefundamountfx/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format(($depositrefundamountfx),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($depositrefundamountfx*1),2,'.',','); ?></div></td>
                  
             <?php 
			  }
			  ?>
              
              <!--for package doctor-->
              
              
               <?php /*?><?php
			   if($res2package!=0)
			   {
			$totalprivatedoctorbill = 0;
			$query112 = "select * from privatedoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error().__LINE__);
			while($res112 = mysql_fetch_array($exec112))
			{
			$privatedoctorbill = $res112['amount'];
			$docno = $res112['visitcode'];
			$transactiondate = $res112['recorddate'];
			$doctorname = $res112['description'];
			
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
			$totalprivatedoctorbill = $totalprivatedoctorbill + $privatedoctorbill;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $doctorname; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($privatedoctorbill,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($privatedoctorbill,2,'.',','); ?></div></td>
			    
			  
			  <?php 
			  }
			  ?>
              <?php
			   
			$totalresidentdoctorbill = 0;
			$query112 = "select * from residentdoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error().__LINE__);
			while($res112 = mysql_fetch_array($exec112))
			{
			$residentdoctorbill = $res112['amount'];
			$docno = $res112['visitcode'];
			$transactiondate = $res112['recorddate'];
			$doctorname = $res112['description'];
			
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
			$totalresidentdoctorbill = $totalresidentdoctorbill + $residentdoctorbill;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $doctorname; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($residentdoctorbill,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($residentdoctorbill,2,'.',','); ?></div></td>
			    
			  
			  <?php 
			  }}
			  ?><?php */?>
			  <?php 
			 
			  $depositamount = 0;
			  
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount-$totaldepositamount+$totalnhifamount+$totaldepositrefundamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $totalrevenue = $totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalmiscbillingamount;
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
			   
			   $totaldepositamount = $totaldepositamount - $totaldepositrefundamount;
			   $positivetotaldiscountamount = -($totaldiscountamount);
			   $positivetotaldepositamount = -($totaldepositamount);
			   $positivetotalnhifamount = -($totalnhifamount);
			   //uhx
			   
			     $overalltotaluhx=($totalopuhx+$totalbedtransferamountuhx+$totalbedallocationamountuhx+$totallabuhx+$totalpharmuhx+$totalraduhx+$totalseruhx+$packageamountuhx+$totalotbillingamountuhx+$totalprivatedoctoramountuhx+$totalambulanceamountuhx+$totaldiscountamountuhx+$totalmiscbillingamountuhx-$totaldepositamountuhx+$totalnhifamountuhx+$totaldepositrefundamountuhx);
			  $overalltotaluhx=number_format($overalltotaluhx,2,'.','');
			  $consultationtotauhxl=$totalopuhx;
			   $consultationtotaluhx=number_format($consultationtotal,2,'.','');
			   $netpayuhx= $consultationtotaluhx+$totallabuhx+$totalpharmuhx+$totalraduhx+$totalseruhx;
			   $netpayuhx=number_format($netpayuhx,2,'.','');

			   if($overalltotal<1 && $overalltotal>-1)
			     $overalltotal ='0.00';
			  ?>
			  <tr>
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
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			 </tr>
             <tr>
              <td class="bodytext31" align="center"  valign="top"><strong>Billing Comments:-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
	     <td class="bodytext31" colspan="3"   align="left">
		 
		 <?php echo $patientbilling_notes; ?>
		 
		 </td></td>
		 
	  <td colspan="3" class="bodytext31" align="right"><strong> Grand Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 </tr>
		<tr>
         <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
          <td class="bodytext31" align="center">&nbsp;</td>
	    
		<?php  $overalltotal = round($overalltotal); ?>
	  <td colspan="3" class="bodytext31" align="right"><strong> Net Payable&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo number_format($overalltotal,2,'.',','); ?></strong></strong></td>
	   <input type="hidden" name="netpayable" id="netpayable" value="<?php echo $overalltotal; ?>">
	            <input name="overalltotal" type="hidden" id="overalltotal" readonly size="8" value="<?php  echo $overalltotal; ?>" />
       
         <input type="hidden" name="netpayableuhx" id="netpayableuhx" value="<?php echo $overalltotaluhx; ?>">
         <input type="hidden" name="curtype" id="curtype" value="<?php echo $currency; ?>">
         <input type="hidden" name="fxrate" id="fxrate" value="<?php echo $fxrate; ?>">
         
	   <input type="hidden" name="totalrevenue" value="<?php echo $totalrevenue; ?>">
	   <input type="hidden" name="discount" value="<?php echo $positivetotaldiscountamount; ?>">
	   <input type="hidden" name="deposit" value="<?php echo $positivetotaldepositamount; ?>">
	    <input type="hidden" name="nhif" value="<?php echo $positivetotalnhifamount; ?>">
	      <td colspan="2" class="bodytext31" align="left"><div align="right"><strong> Net Payable&nbsp; :<?php echo number_format($overalltotaluhx,2,'.',','); ?></strong></div></td>
	     </tr>
          </tbody>
        </table>		</td>
	</tr>
	<!--<tr>
	  <td colspan="3" class="bodytext31" align="right"><strong> Grand Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
		</tr>-->
		<!--<tr>
		<?php  $overalltotal = round($overalltotal); ?>
	  <td colspan="3" class="bodytext31" align="right"><strong> Net Payable&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo number_format($overalltotal,2,'.',','); ?></strong></strong></td>
	   <input type="hidden" name="netpayable" id="netpayable" value="<?php echo $overalltotal; ?>">
	   <input type="hidden" name="totalrevenue" value="<?php echo $totalrevenue; ?>">
	   <input type="hidden" name="discount" value="<?php echo $positivetotaldiscountamount; ?>">
	   <input type="hidden" name="deposit" value="<?php echo $positivetotaldepositamount; ?>">
	    <input type="hidden" name="nhif" value="<?php echo $positivetotalnhifamount; ?>">
	      <td colspan="2" class="bodytext31" align="left"><div align="right"><strong> Net Payable&nbsp; :<?php echo number_format($overalltotaluhx,2,'.',','); ?></strong></div></td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
		</tr>-->
		 <td colspan="3" class="bodytext31" align="right"><strong> Receivable Account-<?php echo $subtype; ?></strong></td>
	    	</tr>
			<?php
			if($patientbilltype == 'PAY NOW')
			{
			
			?>
			<tr>
			<td class="bodytext31" align="center">&nbsp;</td>
			<td class="bodytext31" align="center">&nbsp;</td>
			<td>
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
		  <tr>
			<td width="29%" align="right" class="bodytext31"><strong>Cash</strong></td>
			 <?php
			 if($overalltotal > 0)
			 {
			 $balancevalue = $overalltotal;
			 }
			 else
			 {
			 $balancevalue = '0.00';
			 }
			 if($overalltotal < 0){
			 $returnbalance = $overalltotal ;
			 }else{
			 $returnbalance = '0.00';
			 }
			 ?>
	
			<td width="13%" align="center" class="bodytext31"><input type="text" name="cash" id="cash" size="10" onKeyUp="return balancecalc();"></td>
		    <td width="16%" align="right" class="bodytext31" ><strong id="balancename">Balance</strong></td>
		    <td width="15%" align="center"  class="bodytext31"><input type="text" name="balance" id="balance" size="8" class="bal" readonly value="<?php echo $balancevalue; ?>"></td>
            <td width="16%" align="right" class="bodytext31"><strong>Return Balance</strong></td>
            <td width="15%" align="center" class="bodytext31"><input type="text" name="returnbalance" id="returnbalance" size="8" class="bal" readonly value="<?php echo $returnbalance; ?>"></td>
		  </tr>
			<tr>
			<td align="right" class="bodytext31"><strong>Cheque</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="cheque" id="cheque" size="10" onKeyUp="return balancecalc();"></td>
			 <td class="bodytext31" align="right" id="chequenumber"><strong>Cheque Number</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="chequenumber1" id="chequenumber1" size="10"></td>
			 <td width="15%" align="center" class="bodytext31">&nbsp;</td>
	     <td width="6%" align="center" class="bodytext31">&nbsp;</td>
		 <td width="6%" align="center" class="bodytext31">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right"><strong>Online</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="online" id="online" size="10" onKeyUp="return balancecalc();"></td>
		 <td class="bodytext31" align="right" id="onlinenumber"><strong>Online Number</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="onlinenumber1" id="onlinenumber1" size="10"></td>
				 <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right"><strong>Credit Card</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="creditcard" id="creditcard" size="10" onKeyUp="getBarclayAmount(); return balancecalc();"></td>
			 <td class="bodytext31" align="right" id="creditcardnumber"><strong>Transaction Number</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="creditcardnumber1" id="creditcardnumber1" size="10" <?php if($barclayscard_integration == 1){ echo "readonly"; } ?>></td>
			 <td>
				<!-- iPayments HTML/PHP Code Start -->
	            <?php
	                $barclays_amount = $overalltotaluhx;
	                $barclays_secret_key = $barclays_secret;
	                $barclays_result_field = "creditcardnumber1";
	                $barclays_amount_field = "creditcard";
	                $barclays_user_id = "1"; // Must be an interger value
	            ?>
	            <input type="hidden" name="barclayscard_url" id="barclayscard_url" value="<?= $barclayscard_url ?>" placeholder="Barclays Card Url">
	            <input type="hidden" name="barclays_result_field" id="barclays_result_field" value="<?= $barclays_result_field ?>" placeholder="Mpesa Result">
	            <input type="hidden" name="barclays_amount" id="barclays_amount" value="<?= iPayment_encrypt('$barclays_amount','$barclays_secret_key') ?>" placeholder="Amount">
	            <input type="hidden" name="barclays_amount_field" id="barclays_amount_field" value="<?= $barclays_amount_field ?>">
	            <input type="hidden" name="barclays_secret_key" id="barclays_secret_key" value="<?= $barclays_secret_key ?>" placeholder="Secret Key">
	            <input type="hidden" name="barclays_user_id" id="barclays_user_id" value="<?= $barclays_user_id ?>" placeholder="User">
	            <?php if($barclayscard_integration == 1){ ?><span onClick="OpenBarclays()" style="padding: 3px;background-color: #fff;border-radius: 20px;border: 1px solid;cursor: pointer;" id="iPaymentsIconBarclays" title="Card Payments - iPayments">⚡</span><?php } ?>
	            <!-- iPayments HTML/PHP Code End -->
				</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right"><strong>MPESA</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="mpesa" id="mpesa" size="10" onKeyUp="getEncAmount(); return balancecalc();"></td>
			 <input type="hidden" name="mpesa_fixed" id="mpesa_fixed" size="10" value="<?php echo $overalltotaluhx; ?>">
			 <td class="bodytext31" align="right" id="mpesanumber"><strong>MPESA Number</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="mpesanumber1" id="mpesanumber1" size="10" <?php if($mpesa_integration == 0){ echo "readonly"; } ?> ></td>
			 <td>
			<?php 
				$query = "select mobilenumber from master_customer where customercode = '$patientcode'";
				$execquery = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resquery = mysqli_fetch_array($execquery);
				$mobilenumber = $resquery['mobilenumber'];
			?>
            <!-- iPayments HTML/PHP Code Start -->
            <?php
            	$mpesa_amount = $overalltotaluhx;
                $mpesa_secret_key = $mpesa_secret;
                $mpesa_result_field = "mpesanumber1";
                $mpesa_amount_field = "mpesa";
                $mpesa_number = iPayment_mobileTrim($mobilenumber);
                $mpesa_user_id = $username; // Max 10 Char
            ?>    
            <input type="hidden" name="mpesa_url" id="mpesa_url" value="<?= $mpesa_url ?>" placeholder="Mpesa Amount Field">
            <input type="hidden" name="mpesa_amount_field" id="mpesa_amount_field" value="<?= $mpesa_amount_field ?>" placeholder="Mpesa Amount Field">
            <input type="hidden" name="mpesa_result_field" id="mpesa_result_field" value="<?= $mpesa_result_field ?>" placeholder="Mpesa Result Field">
            <input type="hidden" name="mpesa_amount" id="mpesa_amount" value="<?= iPayment_encrypt("$mpesa_amount","$mpesa_secret_key") ?>" placeholder="Amount">
            <input type="hidden" name="mpesa_secret_key" id="mpesa_secret_key" value="<?= $mpesa_secret_key ?>" placeholder="Secret Key">
            <input type="hidden" name="mpesa_number" id="mpesa_number" value="<?= iPayment_encrypt("$mpesa_number","$mpesa_secret_key") ?>" placeholder="Number">
            <input type="hidden" name="mpesa_user_id" id="mpesa_user_id" value="<?= $mpesa_user_id ?>" placeholder="User">
            <?php if($mpesa_integration == 1){ ?><span align="right" id="iPaymentsIcon" onClick="OpenMpesa()" style="padding: 3px;background-color: #fff;border-radius: 20px;border: 1px solid;cursor: pointer;" title="Lipa na MPESA - iPayments">⚡</span> <?php } ?>
            <!-- iPayments HTML/PHP Code End -->
			</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			</tbody>
			</table></td>
			</tr>
	<?php
	}
	?>
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td width="1%" class="bodytext31" align="left">User Name<input type="text" name="username" id="username" value="<?php echo $username; ?>" class="bal1" readonly><input type="hidden" name="offpatient" id="offpatient" value="<?php echo $offpatient; ?>" readonly>&nbsp;&nbsp;&nbsp;&nbsp;
          <?php if($patientbilltype != 'PAY NOW'){ ?>
            <b><input type="text" name="availablelimite" id="availablelimit" value="<?php echo $availablelimit;?>" <?php  if($availablelimit < $overalltotaluhx){?> style="background:#F00;color:#FFF" <?php }?> readonly ></b><?php } ?>&nbsp;&nbsp;&nbsp;<strong style="align:left">Claim Number</strong> 
				<input type="text" name="preauthcode" id="preauthcode"  size="10" autocomplete="off">
                 <input type="hidden" name="authorization_code" id="authorization_code" value=""></td>
		<td width="1%">&nbsp;</td>
		<td width="1%">&nbsp;
         <?php if($admitid!='' && ($smartap==1 || $smartap==3)){
			 if($smartap==3)
			{
				$smart_val='SMART+SLADE';
			}
			else
			{
				$smart_val='SMART';
			}
			 ?>
				  <input name="fetch" type="button" value="<?php echo $smart_val;?>" style="height:40px; width:120px; background-color:#FFCC00;" onClick="return funcCustomerSmartSearch()"/>
				  <?php }elseif(($smartap==1 || $smartap==3) && $admitid=='') { 
					if($smartap==3)
					{
					$smart_val='SMART+SLADE';
					}
					else
					{
					$smart_val='SMART';
					}
			?>
                   <input name="fetch" type="button" value="<?php echo $smart_val;?>" style="height:40px; width:120px; background-color:#FFCC00;" onClick="return funcCustomerSmartSearch_new()"/>
				  <?php }elseif($smartap==2) {?>
                   <input name="fetch" id="fetch" type="button" value="Slade" style="height:40px; width:100px; background-color:#FFCC00;" onClick="return funfetchsavannah(2)"/>
				  <?php }
				  ?>
                  </td>
                   
				
		<td width="31%" align="center" valign="center" class="bodytext311">         
        <input type="hidden" name="frm1submit1" value="frm1submit1" />
		<input type="hidden" name="frm1submitslade" id="frm1submitslade" value="no" />
		<input type='hidden' name='slade_claim_id' id='slade_claim_id' value=''>
		<input type='hidden' name='eclaim' id='eclaim' value='<?php echo $smartap;?>'>
		
		<?php if($num3299 == '0') {  ?>
        <?php  if($smartap==1) { ?>
        <input name="Submit222" id="smartfrm" type="submit" value="Save and Post To Smart" class="button" disabled /> <?php }elseif($smartap==3){
		?>
		<input name="Submit222" id="smartfrm" type="submit" value="Save and Post To Smart+Slade" class="button" disabled />
		<?php
		}elseif($smartap==2) {
		?>
        <input name="Submit222" id="smartfrm" type="submit" value="Save and Post To Slade" class="button" disabled />
		<?php
		}elseif($smartap<1 && $payer_code!=''){ 
		?>
        <input name="Submit222" id="smartfrm" type="submit" value="Save and Post To Slade" class="button" />
		<?php	
		}else { ?>
		<input name="Submit222" type="submit" <?php   if($billtype!='PAY LATER'){echo 'disabled';} else if($overalltotaluhx < '0' ){echo 'disabled';}?> id="submit" value="Save Bill" onClick="return checkFields();" class="button"/>
        <?php }} ?>
        </td>
      </tr>

	  <tr><td colspan='6'>
	  </td></tr>
	  <?php  

	  if($packageid>0){
	  ?>
	  <tr><td></td><td colspan='5'> <strong>Package Processed List</strong>
	  </td></tr>
      <tr><td></td><td colspan='5'><table width='50%'>
	  <?php  

	  	 
			 $qrylab = "select id,itemcode,itemname,rate,amount from package_processing where package_id = '$packageid' and package_item_type IN('MI','SI') and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> '' ";
		 $service_pharmacy_used_amt = 0;
		 $execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($reslab = mysqli_fetch_array($execlab))
		{
			$itemcode = $reslab['itemcode'];
			$itemname = $reslab['itemname'];
			$itemrate = $reslab['rate'];
			$rowid     = $reslab['id'];
			
			$sno = $sno + 1;

			$issqry = "select id from package_execution where processing_id='$rowid'";
			$execiss = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$iss_num_rows = mysqli_num_rows($execiss);
			if($iss_num_rows)
			{

				$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$issqry1 = "select sum(qty) issuedqty from package_execution where processing_id='$rowid'";
				$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$resiss1 = mysqli_fetch_array($execiss1);
				$issuedqty = $resiss1['issuedqty'];
				$used_amount = $issuedqty * $itemrate;
				$service_pharmacy_used_amt = $service_pharmacy_used_amt + $used_amount;
			}
			
		 }

		 
	          $sno=0;
			  $qrylab = "select id,itemcode,itemname,rate,amount,package_item_type from package_processing where package_id = '$packageid' and package_item_type IN('SI','LI','MI','RI','CT','DC') and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> ''";
             
			     $package_used_amt = 0;
				 $execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			  // $qrylab2 = "select sum(amount) as totolamt from package_processing where package_id = '$packageid' and package_item_type IN('SI','LI','MI','RI','CT') and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> ''";
			   $qrylab2 = "select sum(amount) as totolamt from package_processing where package_id = '$packageid' and package_item_type IN('LI','RI','DC') and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> ''";
			   $execlab2= mysqli_query($GLOBALS["___mysqli_ston"], $qrylab2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			   $reslab2 = mysqli_fetch_array($execlab2);
			   $lab_rad_doc_amt=$reslab2['totolamt'];
			   

			   $process_amt = $service_pharmacy_used_amt + $lab_rad_doc_amt;
			   $mis_amt_service=$package_amt-$process_amt;

				while($reslab = mysqli_fetch_array($execlab))
				{
					$itemcode = $reslab['itemcode'];
					$itemname = $reslab['itemname'];
					
					$itemrate = $reslab['rate'];
					$rowid     = $reslab['id'];
					$pack_item_type = $reslab['package_item_type'];
					
					$pack_item_type = $reslab['package_item_type'];
					$item_amount = $reslab['amount'];
				
					$issqry = "select id from package_execution where processing_id='$rowid'";
					$execiss = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$iss_num_rows = mysqli_num_rows($execiss);
					
					if($iss_num_rows)
					{

						$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$issqry1 = "select sum(qty) issuedqty,date(created_on) as created_on from package_execution where processing_id='$rowid'";
						$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$resiss1 = mysqli_fetch_array($execiss1);
						$issuedqty = $resiss1['issuedqty'];
						if($issuedqty==0)
							$issuedqty=1;

						$process_date = $resiss1['created_on'];
						if($pack_item_type == 'SI' || $pack_item_type == 'MI' )
						$used_amount = $issuedqty * $itemrate;
						else
						$used_amount = $itemrate;

						?>

						<tr bgcolor="#f3d0f5">
								 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
								  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $process_date; ?></div></td>
								 <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
								 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $itemname; ?></div></td>
								 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $issuedqty; ?></div></td>
								  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($itemrate,2,'.',','); ?></div></td>
								  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($itemrate*$issuedqty),2,'.',','); ?></div></td>
								  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($itemrate*$fxrate),2,'.',','); ?></div></td>
								  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format((($itemrate*$issuedqty)*$fxrate),2,'.',','); ?></div></td>
							</tr>
						
					<?php } 
					
					

				}

			   
				if($mis_amt_service > 0) {
					?>

					<tr bgcolor="#f3d0f5">
								 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
								  <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
								 <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
								 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $package_service; ?></div></td>
								 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
								  <td class="bodytext31" valign="center"  align="left"><div align="right"></div></td>
								  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($mis_amt_service,2,'.',','); ?></div></td>
								  <td class="bodytext31" valign="center"  align="left"><div align="right"></div></td>
								  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($mis_amt_service*$fxrate),2,'.',','); ?></div></td>
					</tr>

					<?php
					}
				?>
				</table>
				</td>
			  </tr>
     <?php } ?>
    </table>
  </table>
</form>

<script type="text/javascript">
function checkFields(){
	if(document.getElementById('mpesa').value != ''){
		if(document.getElementById('mpesanumber1').value == ''){
			alert('Please enter MPesa Number!');
			document.getElementById('mpesanumber1').focus;
			return false;
		}
	}

	if(document.getElementById('creditcard').value != ''){
		if(document.getElementById('creditcardnumber1').value == ''){
			alert('Please enter Transaction Number!');
			document.getElementById('creditcardnumber1').focus;
			return false;
		}
	}
}

function getEncAmount(){
	var amount = document.getElementById('mpesa').value;
	if(amount == ''){
		var amount = document.getElementById('mpesa_fixed').value;
	}
	$.ajax({
        type: "POST",
        url: 'mpesacalc.php',
        data : {mpesaamt: amount},
        success: function(data)
        {	
        	document.getElementById("mpesa_amount").value = data;
        }
    });
}
function OpenMpesa(){
  var mpesa_url = window.document.getElementById("mpesa_url").value;
  var mpesa_amount = window.document.getElementById("mpesa_amount").value;
  var mpesa_amount_field = window.document.getElementById("mpesa_amount_field").value;
  var mpesa_result_field = window.document.getElementById("mpesa_result_field").value;
  var mpesa_secret_key = window.document.getElementById("mpesa_secret_key").value;
  var mpesa_number = window.document.getElementById("mpesa_number").value;
  var mpesa_user_id = window.document.getElementById("mpesa_user_id").value;
  var url = mpesa_url+"?mpesa_amount="+mpesa_amount+"&mpesa_number="+mpesa_number+"&mpesa_result_field="+mpesa_result_field+"&mpesa_secret_key="+mpesa_secret_key+"&mpesa_user_id="+mpesa_user_id+"&mpesa_amount_field="+mpesa_amount_field;
   var strWindowFeatures = "directories=no,titlebar=no,toolbar=no,location=no,copyhistory=no,status=no,menubar=no,scrollbars=no,resizable=no,height=520,width=450,top=20,left=450";
   window.open(url,"LIPA NA MPESA",strWindowFeatures);
}
</script>
<!-- iPayments Javascript Code End -->

<!-- iPayments Javascript Code Start -->
<script type="text/javascript">
//***being called in sales1scripting_new.js***
function getBarclayAmount(){
var amount = document.getElementById('creditcard').value;
$.ajax({
    type: "POST",
    url: 'barclayscalc.php',
    data : {barclaysamt: amount},
    success: function(data)
    {	
    	document.getElementById("barclays_amount").value = data;
    }
});
}
function OpenBarclays(){
  var barclays_url = window.document.getElementById("barclayscard_url").value;
  var barclays_amount = window.document.getElementById("barclays_amount").value;
  var barclays_result_field = window.document.getElementById("barclays_result_field").value;
  var barclays_amount_field = window.document.getElementById("barclays_amount_field").value;
  var barclays_secret_key = window.document.getElementById("barclays_secret_key").value;
  var barclays_user_id = window.document.getElementById("barclays_user_id").value;

  var url = barclays_url+"?barclays_amount="+barclays_amount+"&barclays_result_field="+barclays_result_field+"&barclays_amount_field="+barclays_amount_field+"&barclays_secret_key="+barclays_secret_key+"&barclays_user_id="+barclays_user_id;
   var strWindowFeatures = "directories=no,titlebar=no,toolbar=no,location=no,copyhistory=no,status=no,menubar=no,scrollbars=no,resizable=no,height=520,width=450,top=20,left=450";
   window.open(url,"Barclays Card Payments",strWindowFeatures);
 }
</script>
<!-- iPayments Javascript Code End -->

<!-- iPayments Encryption Start -->
<?php function iPayment_encrypt($data, $key) {
    //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $secret_iv = 'ivkey';
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $encrypted =openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);return base64_encode($encrypted . '::' . $iv);} ?>
<!-- iPayments Encryption End -->
<!-- iPayments Mobile Start -->
<?php
    function iPayment_mobileTrim($data){
        return ($data!="")?"254".substr($data, -9):"";
    }
?>
<!-- iPayments Mobile End -->

<?php include ("includes/footer1.php"); ?>
</body>
</html>

