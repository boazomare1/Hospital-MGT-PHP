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

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
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
		
	$accountname= $_REQUEST['accountname'];
	$subtype = $_REQUEST['subtype'];
	$paymenttype = $_REQUEST['paymenttype'];
	$totalamount=$_REQUEST['netpayable'];
	
	$paylaterbillprefix = 'IPF-';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_ip order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1';
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
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

$billno= $billnumbercode;
	if($patientbilltype == 'PAY NOW')
	{
   $cash = $_REQUEST['cash'];
	if($cash == '')
	{
	$cash = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$cash','$cashcoa','ipfinalinvoice')";
    $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}
	$cheque = $_REQUEST['cheque'];
	if($cheque == '')
	{
	$cheque = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$cheque','$chequecoa','ipfinalinvoice')";
    $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
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
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$online','$onlinecoa','ipfinalinvoice')";
    $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
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
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$creditcard','$cardcoa','ipfinalinvoice')";
    $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
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
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$mpesa','$mpesacoa','ipfinalinvoice')";
    $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
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
		else
		{
		$coa = $packagecoa;
		}
		$descriptionrate=$_POST['descriptionrate'][$key];
		$descriptionamount=$_POST['descriptionamount'][$key];
		$descriptionquantity=$_POST['descriptionquantity'][$key];
		$descriptiondocno=$_POST['descriptiondocno'][$key];
		
		
		if($descriptionname!="")
		{
		$query71 = "insert into billing_ipbedcharges(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa)values('$descriptionname','$descriptionrate','$descriptionquantity','$descriptionamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa')";
		$exec71=mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
		$descriptionchargerate=$_POST['descriptionchargerate'][$key];
	    $descriptionchargeamount=$_POST['descriptionchargeamount'][$key];
		$descriptionchargequantity=$_POST['descriptionchargequantity'][$key];
		$descriptionchargedocno=$_POST['descriptionchargedocno'][$key];
		$descriptionchargeward=$_POST['descriptionchargeward'][$key];
		$descriptionchargebed=$_POST['descriptionchargebed'][$key];
		
		if($descriptioncharge!="")
		{
		$query71 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa)values('$descriptioncharge','$descriptionchargerate','$descriptionchargequantity','$descriptionchargeamount','$descriptionchargeward','$descriptionchargebed','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa')";
		$exec71=mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
		$descriptionchargerate1=$_POST['descriptionchargerate1'][$key];
		$descriptionchargeamount1=$_POST['descriptionchargeamount1'][$key];
		$descriptionchargequantity1=$_POST['descriptionchargequantity1'][$key];
		$descriptionchargedocno1=$_POST['descriptionchargedocno1'][$key];
		$descriptionchargeward1=$_POST['descriptionchargeward1'][$key];
		$descriptionchargebed1=$_POST['descriptionchargebed1'][$key];
		
		if($descriptioncharge1!="")
		{
		$query711 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa)values('$descriptioncharge1','$descriptionchargerate1','$descriptionchargequantity1','$descriptionchargeamount1','$descriptionchargeward1','$descriptionchargebed1','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa')";
		$exec711=mysqli_query($GLOBALS["___mysqli_ston"], $query711) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
		$descriptionchargerate12=$_POST['descriptionchargerate12'][$key];
		$descriptionchargeamount12=$_POST['descriptionchargeamount12'][$key];
		$descriptionchargequantity12=$_POST['descriptionchargequantity12'][$key];
		$descriptionchargedocno12=$_POST['descriptionchargedocno12'][$key];
		$descriptionchargeward12=$_POST['descriptionchargeward12'][$key];
		$descriptionchargebed12=$_POST['descriptionchargebed12'][$key];
		
		if($descriptioncharge12!="")
		{
		$query712 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa)values('$descriptioncharge12','$descriptionchargerate12','$descriptionchargequantity12','$descriptionchargeamount12','$descriptionchargeward12','$descriptionchargebed12','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa')";
		$exec712=mysqli_query($GLOBALS["___mysqli_ston"], $query712) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
			$res77=mysqli_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			$rate=$res77['rateperunit'];
			$quantity = $_POST['quantity'][$key];
				$amount = $_POST['amount'][$key];
			
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
		        //echo '<br>'. 
		        $query2 = "insert into billing_ippharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,medicinecode,billnumber,pharmacycoa) 
				values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$currentdate','$ipaddress','$accountname','$medicinecode','$billno','$pharmacycoa')";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
							
			}
		
		}
		}
		if(isset($_POST['lab']))
		{
		foreach($_POST['lab'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$labname=$_POST['lab'][$key];
		$labquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_lab where itemname='$labname'");
		$execlab=mysqli_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate5'][$key];
		
		if($labname!="")
		{
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_iplab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,billnumber,labcoa)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$currentdate','$billno','$labcoa')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
		
		$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_radiology where itemname='$pairvar'");
		$execradiology=mysqli_fetch_array($radiologyquery);
		$radiologycode=$execradiology['itemcode'];
		
		
		if($pairvar!="")
		{
		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,billnumber,radiologycoa)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$currentdate','$billno','$radiologycoa')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		}
		if(isset($_POST['services']))
		{
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$servicesname=$_POST["services"][$key];
		$servicequery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_services where itemname='$servicesname'");
		$execservice=mysqli_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		
		$servicesrate=$_POST["rate3"][$key];
		
		if($servicesname!="")
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber,servicecoa)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$currentdate','$billno','$servicecoa')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
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
			
		if($ambulance!="")
		{
		$query51 = "insert into billing_ipambulance(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa)values('$ambulance','$ambulancerate','$ambulancequantity','$ambulanceamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$ambulancecoa')";
		$exec51=mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		}
			if(isset($_POST['privatedoctor']))
		{
		foreach($_POST['privatedoctor'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$privatedoctor=$_POST['privatedoctor'][$key];
		
		$privatedoctorrate=$_POST['privatedoctorrate'][$key];
	    $privatedoctoramount=$_POST['privatedoctoramount'][$key];
		$privatedoctorquantity=$_POST['privatedoctorquantity'][$key];
			
		if($privatedoctor!="")
		{
		$query52 = "insert into billing_ipprivatedoctor(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa)values('$privatedoctor','$privatedoctorrate','$privatedoctorquantity','$privatedoctoramount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$privatedoctorcoa')";
		$exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
			
		if($nhifquantity!="")
		{
		$query53 = "insert into billing_ipnhif(rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa)values('$nhifrate','$nhifquantity','$nhifamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$nhifcoa')";
		$exec53=mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
		
			
		if($otbilling!="")
		{
		$query54 = "insert into billing_ipotbilling(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa)values('$otbilling','$otbillingrate','1','$otbillingamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$otbillingcoa')";
		$exec54=mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
			
		if($miscbilling!="")
		{
		$query55 = "insert into billing_ipmiscbilling(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa)values('$miscbilling','$miscbillingrate','miscbillingquantity','$miscbillingamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$miscbillingcoa')";
		$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
		
			
		if($admissionchargerate!="")
		{
		$query56 = "insert into billing_ipadmissioncharge(rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa)values('$admissionchargerate','1','$admissionchargeamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$admissionchargecoa')";
		$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		}
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ip(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,patientbilltype,totalrevenue,discount,deposit,nhif,depositcoa,paymenttype)values('$billno','$patientname','$patientcode','$visitcode','$totalamount','$currentdate','$accountname','$subtype','$patientbilltype','$totalrevenue','$discount','$deposit','$nhif','$ipdepositscoa','$paymenttype')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$query43="insert into master_transactionip(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$totalamount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber')";
	    $exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die("error in query43".mysqli_error($GLOBALS["___mysqli_ston"]));	
		
		if($patientbilltype != 'PAY NOW')
		{
		$query431="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$totalamount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber')";
	    $exec431=mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die("error in query431".mysqli_error($GLOBALS["___mysqli_ston"]));		  
			  
		}
		$query64 = "update ip_bedallocation set paymentstatus='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query691 = "update master_ipvisitentry set paymentstatus='completed',finalbillno='$billno' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec691 = mysqli_query($GLOBALS["___mysqli_ston"], $query691) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query6412 = "update ip_discharge set paymentstatus='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec6412 = mysqli_query($GLOBALS["___mysqli_ston"], $query6412) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query6412c = "update newborn_motherdetails set ipbill='completed' where patientcode='$patientcode' and patientvisitcode='$visitcode'";
		$exec6412c = mysqli_query($GLOBALS["___mysqli_ston"], $query6412c) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
		
	header("location:ipbilling.php");


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

$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];
 $patientbilltype = $execlab['billtype'];

$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];

$query32 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode'";
$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num32 = mysqli_num_rows($exec32);

$queryc32 = "select * from newborn_motherdetails where mothercode='$patientcode' and mothervisitcode='$visitcode' and discharge='discharged'";
$execc32 = mysqli_query($GLOBALS["___mysqli_ston"], $queryc32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$numc32 = mysqli_num_rows($execc32);

$queryf32 = "select * from newborn_motherdetails where mothercode='$patientcode' and mothervisitcode='$visitcode' and ipbill <> '' and discharge='discharged'";
$execf32 = mysqli_query($GLOBALS["___mysqli_ston"], $queryf32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$numf32 = mysqli_num_rows($execf32);

$queryv32 = "select * from newborn_motherdetails where patientcode='$patientcode' and patientvisitcode='$visitcode'";
$execv32 = mysqli_query($GLOBALS["___mysqli_ston"], $queryv32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$numv32 = mysqli_num_rows($execv32);

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paylaterbillprefix = 'IPF-';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_ip order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1';
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
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
$query7641 = "select * from master_financialintegration where field='ipdeposits'";
$exec7641 = mysqli_query($GLOBALS["___mysqli_ston"], $query7641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res7641 = mysqli_fetch_array($exec7641);

$ipdepositscoa = $res7641['code'];
$ipdepositscoaname = $res7641['coa'];
$ipdepositstype = $res7641['type'];
$ipdepositsselect = $res7641['selectstatus'];

$query76 = "select * from master_financialintegration where field='labipfinal'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologyipfinal'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res761 = mysqli_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='serviceipfinal'";
$exec762 = mysqli_query($GLOBALS["___mysqli_ston"], $query762) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res762 = mysqli_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalipfinal'";
$exec763 = mysqli_query($GLOBALS["___mysqli_ston"], $query763) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res763 = mysqli_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacyipfinal'";
$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res764 = mysqli_fetch_array($exec764);

$pharmacycoa = $res764['code'];

$query765 = "select * from master_financialintegration where field='cashipfinal'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeipfinal'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaipfinal'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardipfinal'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineipfinal'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);

$onlinecoa = $res769['code'];

$query770 = "select * from master_financialintegration where field='bedchargesipfinal'";
$exec770 = mysqli_query($GLOBALS["___mysqli_ston"], $query770) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res770 = mysqli_fetch_array($exec770);

$bedchargescoa = $res770['code'];

$query771 = "select * from master_financialintegration where field='rmoipfinal'";
$exec771 = mysqli_query($GLOBALS["___mysqli_ston"], $query771) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res771 = mysqli_fetch_array($exec771);

$rmocoa = $res771['code'];

$query772 = "select * from master_financialintegration where field='nursingipfinal'";
$exec772 = mysqli_query($GLOBALS["___mysqli_ston"], $query772) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res772 = mysqli_fetch_array($exec772);

$nursingcoa = $res772['code'];

$query773 = "select * from master_financialintegration where field='privatedoctoripfinal'";
$exec773 = mysqli_query($GLOBALS["___mysqli_ston"], $query773) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res773= mysqli_fetch_array($exec773);

$privatedoctorcoa = $res773['code'];

$query774 = "select * from master_financialintegration where field='ambulanceipfinal'";
$exec774 = mysqli_query($GLOBALS["___mysqli_ston"], $query774) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res774= mysqli_fetch_array($exec774);

$ambulancecoa = $res774['code'];

$query775 = "select * from master_financialintegration where field='nhifipfinal'";
$exec775 = mysqli_query($GLOBALS["___mysqli_ston"], $query775) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res775= mysqli_fetch_array($exec775);

$nhifcoa = $res775['code'];

$query776 = "select * from master_financialintegration where field='otbillingipfinal'";
$exec776 = mysqli_query($GLOBALS["___mysqli_ston"], $query776) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res776= mysqli_fetch_array($exec776);

$otbillingcoa = $res776['code'];

$query777 = "select * from master_financialintegration where field='miscbillingipfinal'";
$exec777 = mysqli_query($GLOBALS["___mysqli_ston"], $query777) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res777= mysqli_fetch_array($exec777);

$miscbillingcoa = $res777['code'];

$query778 = "select * from master_financialintegration where field='admissionchargeipfinal'";
$exec778 = mysqli_query($GLOBALS["___mysqli_ston"], $query778) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res778= mysqli_fetch_array($exec778);

$admissionchargecoa = $res778['code'];

$query779 = "select * from master_financialintegration where field='ippackagefinal'";
$exec779 = mysqli_query($GLOBALS["___mysqli_ston"], $query779) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
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


if(balance < 0)
{
alert("Entered Amount is greater than Net Payable");
document.getElementById("balance").value = "";
return false;
}

document.getElementById("balance").value = balance.toFixed(2);

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
funcchequenumberhide();
funconlinenumberhide();
funccreditcardnumberhide();
funcmpesanumberhide();
}

function validcheck()
{
if(document.getElementById("accountname").value == 'CASH')
{
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
}
var discharge = document.getElementById("discharge").value;
if(discharge == 0)
{
alert("Please discharge the patient before finalization");
return false;
}

var check = confirm("Are you sure to finalize the bill?\nOnce finalized, the patient's Visit will be closed permanently");
if(check == false)
{
return false;
}
if(check == true)
{
printIPFinalInvoice();
}

}

function printIPFinalInvoice()
 {
var popWin; 
popWin = window.open("print_ipfinalinvoice.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>","_blank");
return true;
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
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
<form name="form1" id="form1" method="post" action="ipfinalinvoice.php" onSubmit="return validcheck();">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
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
   
    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             <tr>
						  <td colspan="7" class="bodytext31" bgcolor="#ecf0f5"><strong>IP Final Invoice</strong></td>
						</tr>
            <tr>
              <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Bill No</strong></div></td>
           
				 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Type</strong></div></td>
				<td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
		
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
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
		
		
		$query813 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res813 = mysqli_fetch_array($exec813);
		$num813 = mysqli_num_rows($exec813);
		if($num813 > 0)
		{
		$updatedate=$res813['recorddate'];
		}
			
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		
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
			
			  <td align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $updatedate; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $billtype; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
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
				<input type="hidden" name="privatedoctorcoa" value="<?php echo $privatedoctorcoa; ?>">
				<input type="hidden" name="ambulancecoa" value="<?php echo $ambulancecoa; ?>">
				<input type="hidden" name="nhifcoa" value="<?php echo $nhifcoa; ?>">
				<input type="hidden" name="otbillingcoa" value="<?php echo $otbillingcoa; ?>">
				<input type="hidden" name="miscbillingcoa" value="<?php echo $miscbillingcoa; ?>">
				<input type="hidden" name="admissionchargecoa" value="<?php echo $admissionchargecoa; ?>">
				<input type="hidden" name="patientbilltype" value="<?php echo $patientbilltype; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
				<input type="hidden" name="accountname" id="accountname" value="<?php echo $accname; ?>">
					<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>">	
				<input type="hidden" name="discharge" id="discharge" value="<?php echo $num32; ?>">		
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
        <td bgcolor="#FA5858" class="bodytext311" align="left">Patient is not yet discharged. Hence can not finalize the bill</td>
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
		} ?>
	<tr>
	
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td width="60%">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
           <tr bgcolor="#011E6A">
                <td colspan="8" bgcolor="#ecf0f5" class="bodytext31"><strong>Transaction Details</strong></td>
			 </tr>
          
            <tr>
			 
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref.No</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate  </strong></div></td>
					<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
                  </tr>
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
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			$packageanum1 = $res17['package'];
			
			
			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
				  	 <input type="hidden" name="admissionchargerate[]" id="admissionchargerate" value="<?php echo $consultationfee; ?>">
			 <input type="hidden" name="admissionchargeamount[]" id="admissionchargeamount" value="<?php echo $consultationfee; ?>">
			
	
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationfee; ?></div></td>
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
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
				 		  	 <input type="hidden" name="admissionchargerate[]" id="admissionchargerate" value="<?php echo $consultationfee; ?>">
			 <input type="hidden" name="admissionchargeamount[]" id="admissionchargeamount" value="<?php echo $consultationfee; ?>">
	
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationfee; ?></div></td>
           	</tr>
			<?php
			}
			
			?>
					  <?php
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
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $packagename; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			 <input type="hidden" name="description[]" id="description" value="<?php echo $packagename; ?>">
			 <input type="hidden" name="descriptionrate[]" id="descriptionrate" value="<?php echo $packageamount; ?>">
			 <input type="hidden" name="descriptionamount[]" id="descriptionamount" value="<?php echo $packageamount; ?>">
			 <input type="hidden" name="descriptionquantity[]" id="descriptionquantity" value="<?php echo '1'; ?>">
			  <input type="hidden" name="descriptiondocno[]" id="descriptiondocno" value="<?php echo $visitcode; ?>">
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packageamount,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packageamount,2,'.',','); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
			<?php 
			$totalbedallocationamount = 0;
			
			 $requireddate = '';
			 $quantity = '';
			 $allocatenewquantity = '';
			$query18 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res73 = mysqli_fetch_array($exec73);
			$packageanum = $res73['package'];
			
			
			$query74 = "select * from master_ippackage where auto_number='$packageanum'";
			$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res74 = mysqli_fetch_array($exec74);
			$packdays = $res74['days'];
			
		   $query51 = "select * from master_bed where auto_number='$bed'";
		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res51 = mysqli_fetch_array($exec51);
		   $bedname = $res51['bed'];
		   $threshold = $res51['threshold'];
		   $thresholdvalue = $threshold/100;
		   
			$query91 = "select * from master_bedcharge where bedanum='$bed' and recordstatus =''";
			$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num91 = mysqli_num_rows($exec91);
			while($res91 = mysqli_fetch_array($exec91))
		   {
		   $charge = $res91['charge'];
		   $rate = $res91['rate'];
		   
		   if($billtype == 'PAY LATER')
		   {
		   $thresholdamount = $rate * $thresholdvalue;
		   $rate = $rate + $thresholdamount;
		   }
		    $query181 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode' and recordstatus='transfered'";
			$exec181 = mysqli_query($GLOBALS["___mysqli_ston"], $query181) or die ("Error in Query181".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num181 = mysqli_num_rows($exec181);
			if($num181 > 0)
			{
			$query79 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' order by auto_number asc limit 0,1";
			$exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res79 = mysqli_fetch_array($exec79);
			$date1 = $res79['recorddate'];
			$diff = abs(strtotime($date1) - strtotime($date));
			}
			else
			{		
		    $diff = abs(strtotime($date) - strtotime($updatedate));
			}
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			$allocatedate = $date;
			$allocate1date = $date;
			
			
		
			if($days < $packdays)
			{
			
			$quantity = $days + 1;
			 
			}
			
					if($days > $packdays)
			{
			
			
		
			$days1 = $days - $packdays;
			
		
			if($packdays == 0)
			{
			   $query1281 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' and recordstatus =''";
			$exec1281 = mysqli_query($GLOBALS["___mysqli_ston"], $query1281) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1281 = mysqli_num_rows($exec1281);
			if($num1281 > 0)
			{
			 $quantity = $days1;
			}
			else
			{
		   $quantity = $days1 + 1;
		   }
		   }
		   else
		   {
		   $query1281 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' and recordstatus =''";
			$exec1281 = mysqli_query($GLOBALS["___mysqli_ston"], $query1281) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1281 = mysqli_num_rows($exec1281);
			if($num1281 > 0)
			{
			 $quantity = $days1;
			}
			else
			{
			$quantity = $days1 + 1;
			}
		  
		   }
		  
		   if($packageanum != 0)
		   {
		    	$reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));
			}
			else
			{
			$reqdate = $date;
			}
			
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		   $allocatenewquantity = $quantity;
		   
		 
		   
		
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
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $reqdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
			  <input type="hidden" name="descriptioncharge[]" id="descriptioncharge" value="<?php echo $charge; ?>">
			 <input type="hidden" name="descriptionchargerate[]" id="descriptionchargerate" value="<?php echo $rate; ?>">
			 <input type="hidden" name="descriptionchargeamount[]" id="descriptionchargeamount" value="<?php echo $amount; ?>">
			 <input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>">
			  <input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>">
			   <input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>">
			    <input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bedname; ?>">
         
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php 
			 
			 }
			 
		
			 if($days == $packdays)
			 {
			 
			 if($packdays != 0)
			{
			 $days = $days - $packdays;
			
			if($days != 0)
			{
		   $quantity = $days + 1;
		  
		   
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		   $allocatenewquantiy = $quantity;
		   
		
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
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
			 	  <input type="hidden" name="descriptioncharge[]" id="descriptioncharge" value="<?php echo $charge; ?>">
			 <input type="hidden" name="descriptionchargerate[]" id="descriptionchargerate" value="<?php echo $rate; ?>">
			 <input type="hidden" name="descriptionchargeamount[]" id="descriptionchargeamount" value="<?php echo $amount; ?>">
			 <input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>">
			  <input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>">
			    <input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>">
			    <input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bedname; ?>">
         
       
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php 
			 }
			 }
			 }
			 if($packdays == 0)
			 {
			 if($days == 0)
			 {
			
		   $quantity = $days + 1;
		   
		   $reqdate = $date;
		   
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		    $allocatenewquantiy = $quantity;
		
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
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
			 	  <input type="hidden" name="descriptioncharge[]" id="descriptioncharge" value="<?php echo $charge; ?>">
			 <input type="hidden" name="descriptionchargerate[]" id="descriptionchargerate" value="<?php echo $rate; ?>">
			 <input type="hidden" name="descriptionchargeamount[]" id="descriptionchargeamount" value="<?php echo $amount; ?>">
			 <input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>">
			  <input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>">
			    <input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>">
			    <input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bedname; ?>">
         
       
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php
			 }
			 }
			 }
			  ?>
		
			  <?php 
			  $snno =0;
			  $i = 0;
			  $j=0;
			 
			  $totalbedtransferamount = 0;
			  $diff5 = 0;
			  $newdate = '';
				
			 
			$query128 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' and recordstatus =''";
			$exec128 = mysqli_query($GLOBALS["___mysqli_ston"], $query128) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num128 = mysqli_num_rows($exec128);
			while($res128 = mysqli_fetch_array($exec128))
			{
			$snno = $snno + 1;
			$j = $j + 1;
			
			$ward = $res128['ward'];
			$transfer1ward = $res128['ward'];
			$bed = $res128['bed'];
			$refno = $res128['docno'];
			$date = $res128['recorddate'];
			
			$newdate = $res128['recorddate'];
			$transferanum = $res128['auto_number'];
			
		    $datediff = abs(strtotime($bedallocateddate) - strtotime($date));
			$years5 = floor($datediff / (365*60*60*24));
			$months5 = floor(($datediff - $years5 * 365*60*60*24) / (30*60*60*24));
			$days5 = floor(($datediff - $years5 * 365*60*60*24 - $months5*30*60*60*24)/ (60*60*24));
			
			$newpackdays = $packdays - $days5;
			if($newpackdays > 0)
			{
		    $date = date('Y-m-d',strtotime($date) + (24*3600*$newpackdays));
			}
		
			
			   $query512 = "select * from master_bed where auto_number='$bed'";
			   $exec512 = mysqli_query($GLOBALS["___mysqli_ston"], $query512) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			   $res512 = mysqli_fetch_array($exec512);
			   $bedname = $res512['bed'];
			   $threshold = $res512['threshold'];
			   $thresholdvalue = $threshold/100;
			   
			$query912 = "select * from master_bedcharge where bedanum='$bed' and recordstatus =''";
			$exec912 = mysqli_query($GLOBALS["___mysqli_ston"], $query912) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num912 = mysqli_num_rows($exec912);
			while($res912 = mysqli_fetch_array($exec912))
		    {
			$i = $i + 1;
		    $charge = $res912['charge'];
		    $rate = $res912['rate'];
		   
		  	 if($billtype == 'PAY LATER')
		   {
		   $thresholdamount = $rate * $thresholdvalue;
		   $rate = $rate + $thresholdamount;
		   }
			$query66 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' and auto_number > '$transferanum' order by auto_number asc limit 0,1";
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res66 = mysqli_fetch_array($exec66);
			$date1 = $res66['recorddate'];
			$transferdate = $res66['recorddate'];
		   $diff = abs(strtotime($date1) - strtotime($date));
			
			if($num128 == $snno)
			{
			$query81 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num81 = mysqli_num_rows($exec81);
			if($num81 > 0)
			{
			$res81 = mysqli_fetch_array($exec81);
			$date1 = $res81['recorddate'];
			
			$diff = abs(strtotime($date1) - strtotime($date));
		
			}else
			{
		 	$diff = abs(strtotime($updatedate) - strtotime($date));
			
			}
			}
			
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			$query811 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec811 = mysqli_query($GLOBALS["___mysqli_ston"], $query811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num811 = mysqli_num_rows($exec811);
		
			if($num811 > 0)
			{
			$date12 = $res811['recorddate'];
				if($packageanum1 != 0)
			{
			$diff5 = abs(strtotime($date12) - strtotime($packagedate));
			}
			}
			else
			{
					if($packageanum1 != 0)
			{
		    $diff5 = abs(strtotime($updatedate) - strtotime($packagedate));
			}
			}
			$years5 = floor($diff5 / (365*60*60*24));
			$months5 = floor(($diff5 - $years5 * 365*60*60*24) / (30*60*60*24));
		    $days5 = floor(($diff5 - $years5 * 365*60*60*24 - $months5*30*60*60*24)/ (60*60*24));
			if($packageanum1 != 0)
			{
			if($days5 >= $packdays)
			{
			
			if($allocateward == $ward)
			{
			if($allocatedate != '')
			{
				if($allocatedate == $allocate1date)
			{
			
			if($quantity != '')
			{
			 $quantity = $quantity - 1;
			
			 }
			
			 if($packageanum1 != 0)
			 {
			 $quantity = $quantity + $packdays;
			 }
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 else
			 {
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 }
			
		
			
			$query812 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec812 = mysqli_query($GLOBALS["___mysqli_ston"], $query812) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num812 = mysqli_num_rows($exec812);
			if($num812 > 0)
			{
			$res812 = mysqli_fetch_array($exec812);
			$date12 = $res812['recorddate'];
			
			if($date12 == $transferdate)
			{
			$days = $days - 1;
			}
		
			}else
			{
		 	if($updatedate == $transferdate)
			{
			$days = $days - 1;
			}
			
			}
				
			}
			if($j > 1)
			{
			
			if($allocateward != $ward)
			{
			$quantity = $days + 1;
			}
			else
			{
			$quantity = $days;
			}
			}
			else
			{
		 $quantity = $days + 1;
		 }
		  
		   if($quantity != 0)
		   {
		   if($i == 1)
		   {
		   
		     $reqdate = date('Y-m-d',strtotime($reqdate) + (24*3600*$allocatenewquantity));
		    }
			if($allocateward != $ward)
				{
				$reqdate = $newdate;
				}
		   $amount = $quantity * $rate;
		   $totalbedtransferamount = $totalbedtransferamount + $amount;
		   
		   $totalquantity = $totalquantity + $quantity;
		
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
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $reqdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
			  	  <input type="hidden" name="descriptioncharge1[]" id="descriptioncharge1" value="<?php echo $charge; ?>">
			 <input type="hidden" name="descriptionchargerate1[]" id="descriptionchargerate1" value="<?php echo $rate; ?>">
			 <input type="hidden" name="descriptionchargeamount1[]" id="descriptionchargeamount1" value="<?php echo $amount; ?>">
			 <input type="hidden" name="descriptionchargequantity1[]" id="descriptionchargequantity1" value="<?php echo $quantity; ?>">
			  <input type="hidden" name="descriptionchargedocno1[]" id="descriptionchargedocno1" value="<?php echo $refno; ?>">
			    <input type="hidden" name="descriptionchargeward1[]" id="descriptionchargeward1" value="<?php echo $ward; ?>">
			    <input type="hidden" name="descriptionchargebed1[]" id="descriptionchargebed1" value="<?php echo $bedname; ?>">
     
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php 
			
			  }
			  $allocatedate = '';
			 }
			 }
			 
			
			if($packageanum1 == 0)
			{
			
			if($i == 1)
		   {
		   if($reqdate == $date )
		   {
		   $reqdate2 = $date;
		   }
		   else
		   {
	    $reqdate2 = date('Y-m-d',strtotime($reqdate) + (24*3600*$allocatenewquantity) - 1);
		}
		  
		if( $reqdate2 == $date)
		{
		$reqdate = $date;
		}
		else
		{
			$reqdate = date('Y-m-d',strtotime($reqdate) + (24*3600*$quantity));
			}
			}
			
			 if($days5 == 0)
			 {
			 if($allocateward == $ward)
			{
			
			if($allocatedate != '')
			{
			if($allocatedate == $allocate1date)
			{
			 $quantity = $quantity - 1;
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 else
			 {
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 if($transdate > $updatedate)
			 {
			 $transdate = $updatedate;
			 }
			 }
			 }
			
		if($transdate == $newdate)
		{
		 $days = $days - 1;
		}
		}
		
		
		  $quantity = $days + 1;
		  
		   
		   if($quantity != 0)
		   {
		  
		
		   $amount = $quantity * $rate;
		   $totalbedtransferamount = $totalbedtransferamount + $amount;
		   
		   $totalquantity = $totalquantity + $quantity;
		
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
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $reqdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
			 	  	  <input type="hidden" name="descriptioncharge12[]" id="descriptioncharge12" value="<?php echo $charge; ?>">
			 <input type="hidden" name="descriptionchargerate12[]" id="descriptionchargerate12" value="<?php echo $rate; ?>">
			 <input type="hidden" name="descriptionchargeamount12[]" id="descriptionchargeamount12" value="<?php echo $amount; ?>">
			 <input type="hidden" name="descriptionchargequantity12[]" id="descriptionchargequantity12" value="<?php echo $quantity; ?>">
			  <input type="hidden" name="descriptionchargedocno12[]" id="descriptionchargedocno12" value="<?php echo $refno; ?>">
			    <input type="hidden" name="descriptionchargeward12[]" id="descriptionchargeward12" value="<?php echo $ward; ?>">
			    <input type="hidden" name="descriptionchargebed12[]" id="descriptionchargebed12" value="<?php echo $bedname; ?>">
  
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php 
			
			  }
			  $allocatedate = '';
			 }
			}
			 }
		 $reqdate = date('Y-m-d',strtotime($reqdate) + (24*3600*$quantity));
		 
		 if($reqdate > $updatedate)
		 {
		 $reqdate = $updatedate;
		
		 }
		
			$allocatedate = $newdate;
			$allocateward = $ward;
			 }
			  ?>
			 
			   <?php 
			$totalpharm=0;
			
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$pharmfree = $res23['freestatus'];
			$query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query331 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    while($res331 = mysqli_fetch_array($exec331))
			{
			$quantity1=$res331['quantity'];
			$phaquantity1=$phaquantity1+$quantity1;
			$amount1=$res331['totalamount'];
			$phaamount1=$phaamount1+$amount1;
			}
			
			$resquantity = $phaquantity - $phaquantity1;
			$resamount = $phaamount - $phaamount1;
						
			$resamount=number_format($resamount,2,'.','');
			if($resquantity != 0)
			{
			if($pharmfree =='No')
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
			$totalpharm=$totalpharm+$resamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $resquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $resamount; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $resquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $resamount; ?></div></td>
		     
			  
			  <?php }
			  }
			  }
			  ?>
			  <?php 
			  $totallab=0;
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
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2,'.',','); ?></div></td>
		       
			  
			  <?php }
			  }
			  ?>
			  
			    <?php 
				$totalrad=0;
			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['iptestdocno'];
			$radiologyfree = $res20['freestatus'];
			
			if($radiologyfree == 'No')
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
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>

			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $radrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2,'.',','); ?></div></td>
			    
			  
			  <?php }
			  }
			  ?>
			  	    <?php 
					
					$totalser=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund'";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			
			if($servicesfree == 'No')
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
			$totalser=$totalser+$serrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $serrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2,'.',','); ?></div></td>
			    
			  
			  <?php }
			  }
			  ?>
			<?php
			$totalotbillingamount = 0;
			$query61 = "select * from ip_otbilling where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $otbillingdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $otbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $otbillingname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			  		 <input type="hidden" name="otbilling[]" id="otbilling" value="<?php echo $otbillingname; ?>">
			 	 <input type="hidden" name="otbillingrate[]" id="otbillingrate" value="<?php echo $otbillingrate; ?>">
			 <input type="hidden" name="otbillingamount[]" id="otbillingamount" value="<?php echo $otbillingrate; ?>">
			 

             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				?>
				<?php
			$totalprivatedoctoramount = 0;
			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res62 = mysqli_fetch_array($exec62))
		   {
			$privatedoctordate = $res62['consultationdate'];
			$privatedoctorrefno = $res62['docno'];
			$privatedoctor = $res62['doctorname'];
			$privatedoctorrate = $res62['rate'];
			$privatedoctoramount = $res62['amount'];
			$privatedoctorunit = $res62['units'];
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
			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctordate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctorrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $privatedoctor; ?></div></td>
			 		 <input type="hidden" name="privatedoctor[]" id="privatedoctor" value="<?php echo $privatedoctor; ?>">
			 	 <input type="hidden" name="privatedoctorrate[]" id="privatedoctorrate" value="<?php echo $privatedoctorrate; ?>">
			 <input type="hidden" name="privatedoctoramount[]" id="privatedoctoramount" value="<?php echo $privatedoctoramount; ?>">
			 <input type="hidden" name="privatedoctorquantity[]" id="privatedoctorquantity" value="<?php echo $privatedoctorunit; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctorunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($privatedoctorrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				?>
				<?php
			$totalambulanceamount = 0;
			$query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancedate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancerefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $ambulance; ?></div></td>
			 <input type="hidden" name="ambulance[]" id="ambulance" value="<?php echo $ambulance; ?>">
			 	 <input type="hidden" name="ambulancerate[]" id="ambulancerate" value="<?php echo $ambulancerate; ?>">
			 <input type="hidden" name="ambulanceamount[]" id="ambulanceamount" value="<?php echo $ambulanceamount; ?>">
			 <input type="hidden" name="ambulancequantity[]" id="ambulancequantity" value="<?php echo $ambulanceunit; ?>">
	
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulanceunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ambulancerate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				?>
				<?php
			$totalmiscbillingamount = 0;
			$query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res69 = mysqli_fetch_array($exec69))
		   {
			$miscbillingdate = $res69['consultationdate'];
			$miscbillingrefno = $res69['docno'];
			$miscbilling = $res69['description'];
			$miscbillingrate = $res69['rate'];
			$miscbillingamount = $res69['amount'];
			$miscbillingunit = $res69['units'];
			
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
			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $miscbilling; ?></div></td>
			  <input type="hidden" name="miscbilling[]" id="miscbilling" value="<?php echo $miscbilling; ?>">
			 	 <input type="hidden" name="miscbillingrate[]" id="miscbillingrate" value="<?php echo $miscbillingrate; ?>">
			 <input type="hidden" name="miscbillingamount[]" id="miscbillingamount" value="<?php echo $miscbillingamount; ?>">
			 <input type="hidden" name="miscbillingquantity[]" id="miscbillingquantity" value="<?php echo $miscbillingunit; ?>">
	
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($miscbillingrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($miscbillingamount,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				?>
				<?php
			$totaldiscountamount = 0;
			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res64 = mysqli_fetch_array($exec64))
		   {
			$discountdate = $res64['consultationdate'];
			$discountrefno = $res64['docno'];
			$discount= $res64['description'];
			$discountrate = $res64['rate'];
			$discountrate1 = $discountrate;
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
			$totaldiscountamount = $totaldiscountamount + $discountrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $discountdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $discountrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($discountrate1,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($discountrate,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				?>
						<?php
			$totalnhifamount = 0;
			$query641 = "select * from ip_nhifprocessing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res641= mysqli_fetch_array($exec641))
		   {
			$nhifdate = $res641['consultationdate'];
			$nhifrefno = $res641['docno'];
			$nhifqty = $res641['totaldays'];
			$nhifrate = $res641['nhifrebate'];
			$nhifclaim = $res641['nhifclaim'];
			$nhifclaim = -$nhifclaim;
			
						
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
			$totalnhifamount = $totalnhifamount + $nhifclaim;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo 'NHIF'; ?></div></td>
			 	
			 	 <input type="hidden" name="nhifrate[]" id="nhifrate" value="<?php echo $nhifrate; ?>">
			 <input type="hidden" name="nhifamount[]" id="nhifamount" value="<?php echo $nhifclaim; ?>">
			 <input type="hidden" name="nhifquantity[]" id="nhifquantity" value="<?php echo $nhifqty; ?>">
	
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifqty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($nhifrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($nhifclaim,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				?>
			<?php
			$totaldepositamount = 0;
			$query112 = "select * from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositamount = $res112['transactionamount'];
			$depositamount1 = -$depositamount;
			$docno = $res112['docno'];
			$transactionmode = $res112['transactionmode'];
			$transactiondate = $res112['transactiondate'];
			$chequenumber = $res112['chequenumber'];
			
			$query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$totaldepositamount = $totaldepositamount + $depositamount1;
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
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($depositamount,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($depositamount,2,'.',','); ?></div></td>
			    
			  
			  <?php }
			 
			  ?>
			  		  <?php
			$totaldepositrefundamount = 0;
			$query112 = "select * from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositrefundamount = $res112['amount'];
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
			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Deposit Refund'; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></div></td>
			    
			  
			  <?php 
			  }
			  ?>
			  <?php 
			 
			  $depositamount = 0;
			  
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount+$totaldepositrefundamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $totalrevenue = $totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalmiscbillingamount;
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
			   
			   $totaldepositamount = $totaldepositamount + $totaldepositrefundamount;
			   $positivetotaldiscountamount = -($totaldiscountamount);
			   $positivetotaldepositamount = -($totaldepositamount);
			   $positivetotalnhifamount = -($totalnhifamount);
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
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
			 </tr>
          </tbody>
        </table>		</td>
	</tr>
	<tr>
	  <td colspan="3" class="bodytext31" align="right"><strong> Grand Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
		</tr>
		<tr>
		<?php  $overalltotal = round($overalltotal); ?>
	  <td colspan="3" class="bodytext31" align="right"><strong> Net Payable&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo number_format($overalltotal,2,'.',','); ?></strong></strong></td>
	   <input type="hidden" name="netpayable" id="netpayable" value="<?php echo $overalltotal; ?>">
	   <input type="hidden" name="totalrevenue" value="<?php echo $totalrevenue; ?>">
	   <input type="hidden" name="discount" value="<?php echo $positivetotaldiscountamount; ?>">
	   <input type="hidden" name="deposit" value="<?php echo $positivetotaldepositamount; ?>">
	    <input type="hidden" name="nhif" value="<?php echo $positivetotalnhifamount; ?>">
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
		</tr>
		 <td colspan="3" class="bodytext31" align="right"><strong> Receivable Account-<?php echo $accname; ?></strong></td>
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
			 if($overalltotal == 0.00)
			 {
			 $balancevalue = '0.00';
			 }
			 else
			 {
			 $balancevalue = '';
			 }
			 ?>
	
			<td width="13%" align="center" class="bodytext31"><input type="text" name="cash" id="cash" size="10" onKeyUp="return balancecalc();"></td>
		    <td width="16%" align="right" class="bodytext31"><strong>Balance</strong></td>
		    <td width="15%" align="center" class="bodytext31"><input type="text" name="balance" id="balance" size="8" class="bal" readonly="readonly" value="<?php echo $balancevalue; ?>"></td>
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
			 <td class="bodytext31" align="center"><input type="text" name="creditcard" id="creditcard" size="10" onKeyUp="return balancecalc();"></td>
			 <td class="bodytext31" align="right" id="creditcardnumber"><strong>Credit Card Number</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="creditcardnumber1" id="creditcardnumber1" size="10"></td>
		 <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right"><strong>MPESA</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="mpesa" id="mpesa" size="10" onKeyUp="return balancecalc();"></td>
			 <td class="bodytext31" align="right" id="mpesanumber"><strong>MPESA Number</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="mpesanumber1" id="mpesanumber1" size="10"></td>
		 <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			</tbody>
			</table>			</td>
			</tr>
	<?php
	}
	?>
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td width="1%" class="bodytext31" align="left">User Name<input type="text" name="username" id="username" value="<?php echo $username; ?>" class="bal1" readonly="readonly"></td>
		<td width="1%">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="31%" align="center" valign="center" class="bodytext311">         
        <input type="hidden" name="frm1submit1" value="frm1submit1" />
		<input name="Submit222" type="submit" id="submit" value="Save Bill"  class="button"/></td>
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

