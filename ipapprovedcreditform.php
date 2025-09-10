<?php
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("residental_doctor_func.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date('Y-m-d');
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
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
	 //get locationcode and locationname for inserting
 $locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
 $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
//get ends here
		$visitcode=$_REQUEST["visitcode"];
		$patientcode = $_REQUEST["patientcode"];
		$patientname = $_REQUEST["patientname"];
     	$slade_key_provider= $_REQUEST["slade_key_provider"];
        $keyprovider='';
		$payer_code1='';
		$payer_code= $_REQUEST["payer_code"];
		$slade_balres= $_REQUEST["slade_balres"];

$query_bill_location = "select auto_number from master_location where locationcode = '$locationcodeget'";
$exec_bill_loctation = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill_location) or die ("Error in Query_bill_location".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res_bill_loct = mysqli_fetch_array($exec_bill_loctation);
$location_num = $res_bill_loct['auto_number'];
$query_bill = "select prefix from bill_formats where description = 'bill_ipcreditapproved'";
$exec_bill = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill) or die ("Error in Query_bill".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res_bill = mysqli_fetch_array($exec_bill);
$paylaterbillprefix = $res_bill['prefix'];
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_ipcreditapproved order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1'."-".date('y')."-".$location_num;
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
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum."-".date('y')."-".$location_num;
	$openingbalance = '0.00';
	//echo $companycode;
}
 $eclaim=$_REQUEST["eclaim"];
$billno= $billnumbercode;
		$accountname= $_REQUEST['accname'];
		$subtype = $_REQUEST['subtype'];
		$paymenttype = $_REQUEST['paymenttype'];
		$totalamount=$_REQUEST['netpayable'];
		$account1name = $_REQUEST['accountname'];
		$account2name = $_REQUEST['accountname2'];
		$account3name = $_REQUEST['accountname3'];
		$account4name = $_REQUEST['accountname4'];
		
		$account1nameid = $_REQUEST['accountnameid'];
		$account2nameid = $_REQUEST['accountnameid2'];
		$account3nameid = $_REQUEST['accountnameid3'];
		$account4nameid = $_REQUEST['accountnameid4'];
		
		$account1nameano = $_REQUEST['accountnameano'];
		$account2nameano = $_REQUEST['accountnameano2'];
		$account3nameano = $_REQUEST['accountnameano3'];
		$account4nameano = $_REQUEST['accountnameano4'];
		
		
		$subtype1id = 0; 
		$subtype1name = ""; 
		$subtype2id = 0; 
		$subtype2name = ""; 
		$subtype3id = 0; 
		$subtype3name = ""; 
		if(trim($account1nameid) !='')
		{
			$subtypeinfo = getsubtypeinfo($account1nameid);
			$subtype1id = $subtypeinfo["subtypeid"]; 
			$subtype1name = $subtypeinfo["subtypename"]; 
		}
		
		if(trim($account2nameid) !='')
		{
			$subtype2info = getsubtypeinfo($account2nameid);
			$subtype2id = $subtype2info["subtypeid"]; 
			$subtype2name = $subtype2info["subtypename"]; 
		
		}

		if(trim($account3nameid) !='')
		{

			$subtype3info = getsubtypeinfo($account3nameid);
			$subtype3id = $subtype3info["subtypeid"]; 
			$subtype3name = $subtype3info["subtypename"]; 
			
		}

		$account1amount = $_REQUEST['amount1'];
		$account2amount = $_REQUEST['amount2'];
		$account3amount = $_REQUEST['amount3'];
		$account4amount = $_REQUEST['amount4'];
		
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
		
		//$returnbalance = $_REQUEST['returnbalance'];
		
	$accountcode= $_REQUEST['acccode'];
	$accountname= $_REQUEST['accname'];
	$accountanum= $_REQUEST['accanum'];
	
	$subtype = $_REQUEST['subtype'];
	$paymenttype = $_REQUEST['paymenttype'];
	$totalamount=$_REQUEST['netpayable'];
	
	$totalamountuhx=$_REQUEST['netpayableuhx'];
	$fxrate=$_REQUEST['fxrate'];
	$curtype=$_REQUEST['curtype'];
	
	$preauthcode=$_REQUEST['preauthcode'];
	
	$slade_claim_id=$_REQUEST["slade_claim_id"];
	$authorization_code=$_REQUEST['authorization_code'];
	$offpatient=$_REQUEST['offpatient'];
	
	$account1fxamount = $account1amount * $fxrate;
	$account2fxamount = $account2amount * $fxrate;
	$account3fxamount = $account3amount * $fxrate;
	$account4fxamount = $account4amount * $fxrate;
	
	$query = mysqli_query($GLOBALS["___mysqli_ston"], "select * from billing_ipcreditapproved where visitcode = '$visitcode'") or die("error in getting billing ".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($query)==0)
	{
		
	if(($account1name == 'CASH')||($account2name == 'CASH')||($account3name == 'CASH'))
	{
	$cash = $_REQUEST['cash'];
	if($cash == '')
	{
	$cash = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,locationname,locationcode,fxrate,curtype)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$cash','$cashcoa','".$locationnameget."','".$locationcodeget."','".$fxrate."','".$curtype."')";
    $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}
	$cheque = $_REQUEST['cheque'];
	if($cheque == '')
	{
	$cheque = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,locationname,locationcode,fxrate,curtype)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$cheque','$chequecoa','".$locationnameget."','".$locationcodeget."','".$fxrate."','".$curtype."')";
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
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,locationname,locationcode,fxrate,curtype)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$online','$onlinecoa','".$locationnameget."','".$locationcodeget."','".$fxrate."','".$curtype."')";
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
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,locationname,locationcode,fxrate,curtype)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$creditcard','$cardcoa','".$locationnameget."','".$locationcodeget."','".$fxrate."','".$curtype."')";
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
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,locationname,locationcode,fxrate,curtype)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$mpesa','$mpesacoa','".$locationnameget."','".$locationcodeget."','".$fxrate."','".$curtype."')";
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
		
		$descriptionrateuhx=$_POST['descriptionrateuhx'][$key];
		$descriptionamountuhx=$_POST['descriptionamountuhx'][$key];
		
		
		if($descriptionname!="")
		{
			$query71 = "insert into billing_ipbedcharges(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,rateuhx,amountuhx)values('$descriptionname','$descriptionrate','$descriptionquantity','$descriptionamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa','".$locationnameget."','".$locationcodeget."','".$descriptionrateuhx."','".$descriptionamountuhx."')";
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
		
		$descriptionchargerateuhx=$_POST['descriptionchargerateuhx'][$key];
	    $descriptionchargeamountuhx=$_POST['descriptionchargeamountuhx'][$key];
		//this is for caftarea
		if($descriptionchargebed!="")
		{
			$query2 = "select * from master_bed where bed = '".$descriptionchargebed."' and ward = '".$descriptionchargeward."'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$caftcharge = $res2['threshold'];
	
	$bedchargerate = $descriptionchargerate-($caftcharge*$descriptionchargequantity);
		}
		
		if($descriptioncharge!="")
		{
			$query71 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,bedcharge,caftarea,rateuhx,amountuhx,curtype,fxrate)values('$descriptioncharge','$descriptionchargerate','$descriptionchargequantity','$descriptionchargeamount','$descriptionchargeward','$descriptionchargebed','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa','".$locationnameget."','".$locationcodeget."','".$bedchargerate."','".$caftcharge."','".$descriptionchargerateuhx."','".$descriptionchargeamountuhx."','".$curtype."','".$fxrate."')";
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
		
		$descriptionchargerate1uhx=$_POST['descriptionchargerate1uhx'][$key];
	    $descriptionchargeamount1uhx=$_POST['descriptionchargeamount1uhx'][$key];
		//this is for caftarea
		if($descriptionchargebed1!="")
		{
			$query2 = "select * from master_bed where bed = '".$descriptionchargebed1."' and ward = '".$descriptionchargeward1."'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$caftcharge1 = $res2['threshold'];
	
	$bedchargerate1 = $descriptionchargerate1-($caftcharge*$descriptionchargequantity1);
		}
		
		if($descriptioncharge1!="")
		{
		$query711 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,bedcharge,caftarea,rateuhx,amountuhx,curtype,fxrate)values('$descriptioncharge1','$descriptionchargerate1','$descriptionchargequantity1','$descriptionchargeamount1','$descriptionchargeward1','$descriptionchargebed1','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa','".$locationnameget."','".$locationcodeget."','".$bedchargerate1."','".$caftcharge1."','".$descriptionchargerate1uhx."','".$descriptionchargeamount1uhx."','".$curtype."','".$fxrate."')";
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
		
		$descriptionchargerate12uhx=$_POST['descriptionchargerate12uhx'][$key];
	    $descriptionchargeamount12uhx=$_POST['descriptionchargeamount12uhx'][$key];
		//this is for caftarea
		if($descriptionchargebed12!="")
		{
			$query2 = "select * from master_bed where bed = '".$descriptionchargebed12."' and ward = '".$descriptionchargeward12."'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$caftcharge12 = $res2['threshold'];
	
	$bedchargerate12 = $descriptionchargerate12-($caftcharge*$descriptionchargequantity12);
		}
		
		if($descriptioncharge12!="")
		{
		$query712 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,bedcharge,caftarea,rateuhx,amountuhx,curtype,fxrate)values('$descriptioncharge12','$descriptionchargerate12','$descriptionchargequantity12','$descriptionchargeamount12','$descriptionchargeward12','$descriptionchargebed12','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa','".$locationnameget."','".$locationcodeget."','".$bedchargerate12."','".$caftcharge12."','".$descriptionchargerate12uhx."','".$descriptionchargeamount12uhx."','".$curtype."','".$fxrate."')";
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
		    $medicinename = addslashes($medicinename);
		    $medicinecode = $_POST['itemcode'][$key];

			// $query77="select * from master_medicine where itemname='$medicinecode'";
			// $exec77=mysql_query($query77);
			// $res77=mysql_fetch_array($exec77);
			// // $medicinecode=$res77['itemcode'];
			// $rate=$res77['rateperunit'];

			$rate = $_POST['rate'][$key];
			$quantity = $_POST['quantity'][$key];
				$amount = $_POST['amount'][$key];
				
				$rate=$rate/$fxrate;
				$amountuhx = $_POST['amountuhx'][$key];
				$rateuhx = $_POST['rateuhx'][$key];
			
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
		        //echo '<br>'. 
		        $query2 = "insert into billing_ippharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,medicinecode,billnumber,pharmacycoa,locationname,locationcode,rateuhx,amountuhx,curtype,fxrate) 
				values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$currentdate','$ipaddress','$accountname','$medicinecode','$billno','$pharmacycoa','".$locationnameget."','".$locationcodeget."','".$rateuhx."','".$amountuhx."','".$curtype."','".$fxrate."')";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
							
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
				
				 $pkg_status = 'YES';
				$packageid = $_POST['packageid'];
				$pkg_process_row_id = $_POST['medicinerowidpkg'][$key];
			
			if ($medicinename != "" && $medicinecode !="")
			{

		        $query2 = "insert into billing_ippharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,medicinecode,billnumber,pharmacycoa,locationname,locationcode,rateuhx,amountuhx,curtype,fxrate,pkg_id,pkg_status,package_process_id) 
				values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$currentdate','$ipaddress','$accountname','$medicinecode','$billno','$pharmacycoa','".$locationnameget."','".$locationcodeget."','".$rateuhx."','".$amountuhx."','".$curtype."','".$fxrate."','$packageid','$pkg_status','$pkg_process_row_id')";
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

		// $labquery=mysql_query("select * from master_lab where itemname='$labname'");
		// $execlab=mysql_fetch_array($labquery);
		// $labcode=$execlab['itemcode'];

		$labcode=$_POST['labcode'][$key];


		$labrate=$_POST['rate5'][$key];
		
		$labrateuhx=$_POST['rate5uhx'][$key];
		
		if($labname!="")
		{
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_iplab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,billnumber,labcoa,locationname,locationcode,rateuhx,curtype,fxrate)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$currentdate','$billno','$labcoa','".$locationnameget."','".$locationcodeget."','".$labrateuhx."','".$curtype."','".$fxrate."')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
		
		// $radiologyquery=mysql_query("select * from master_radiology where itemname='$pairvar'");
		// $execradiology=mysql_fetch_array($radiologyquery);
		// $radiologycode=$execradiology['itemcode'];
		$radiologycode=$_POST['radiologcode'][$key];
		
		$pairs1uhx= $_POST['rate8uhx'][$key];
		
		
		if($pairvar!="")
		{
		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,billnumber,radiologycoa,locationname,locationcode,radiologyitemrateuhx,curtype,fxrate)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$currentdate','$billno','$radiologycoa','".$locationnameget."','".$locationcodeget."','".$pairs1uhx."','".$curtype."','".$fxrate."')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		}

		if(isset($_POST['radiologycodepkg']))
		{
		foreach($_POST['radiologycodepkg'] as $key=>$value){	
			
		
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
		// $servicequery=mysql_query("select * from master_services where itemname='$servicesname'");
		// $execservice=mysql_fetch_array($servicequery);
		// $servicescode=$execservice['itemcode'];

		$servicescode=$_POST["servicesitemcode"][$key];

		$sql_serv="select ledgerid,ledgername from master_services where itemcode='".$servicescode."'";
		$sql_serv34 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_serv) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_res34 = mysqli_fetch_array($sql_serv34);
		$serviceledgcode=$sql_res34['ledgerid'];
		$serviceledgname=$sql_res34['ledgername'];
		
		$servicesrate=$_POST["rate3"][$key];
		
		$servicesrateuhx=$_POST["rate3uhx"][$key];
        
			//residental doctor

	$rsltr_sharing= resident_doctor_sharing($servicedoctorcode,$updatedate,$servicesrate);

     $is_resdoc=$rsltr_sharing['is_resident'];
	 if($is_resdoc==1){
	 $sharingamount=$rsltr_sharing['sharing_amt'];
	 $ipserviceperc=$rsltr_sharing['sharing_per'];
     }
   /// residental doctor

    

		
		
		if($servicesname!="")
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber,servicecoa,locationname,locationcode,servicesitemrateuhx,curtype,fxrate,incomeledgercode,incomeledgername,doctorcode,doctorname,wellnesspkg,ipservice_percentage,sharingamount)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$currentdate','$billno','$servicecoa','".$locationnameget."','".$locationcodeget."','".$servicesrateuhx."','".$curtype."','".$fxrate."','$serviceledgcode','$serviceledgname','$servicedoctorcode','$servicedoctorname','$wellnesspkg','$ipserviceperc','$sharingamount')") or die("Error in ServiceQuery1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$ipdocquery=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipprivatedoctor(docno, patientname, patientcode, visitcode, accountname, description, doccoa, quantity, rate, amount, recordtime, ipaddress, recorddate, username, billstatus, doctorstatus, billtype, locationname, locationcode, transactionmode, transactionamount, pkg_status, visittype,coa,pvtdr_percentage,sharingamount,original_amt,is_resdoc) VALUES ( '$billno', '$patientname', '$patientcode', '$visitcode', '$accountname', '$servicedoctorname', '$servicedoctorcode', '1', '$sharingamount', '$sharingamount', '$updatedate', '$ipaddress', '$updatedate', '$username', 'paid','unpaid', 'PAY LATER', '$locationnameget', '$locationcodeget', '$transactionmode', '$sharingamount', '$pkg_status', 'IP', '$serviceledgcode','$ipserviceperc','$sharingamount','$servicesrate','$is_resdoc')") or die("Error in ipdocquery".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		}


		if(isset($_POST['servicesitemcodepkg']))
		{
		foreach($_POST['servicesitemcodepkg'] as $key => $value)
		{
				   
		//$serviceledgcode=$_POST["serviceledgcodepkg"][$key];
		//$serviceledgname=$_POST["serviceledgnamepkg"][$key];
		$servicedoctorcode=$_POST["servicedoctorcodepkg"][$key];
		$servicedoctorname=$_POST["servicedoctornamepkg"][$key];
		
		$servicesname=$_POST["servicespkg"][$key];
	
		$servicescode=$_POST["servicesitemcodepkg"][$key];

		$sql_serv="select ledgerid,ledgername from master_services where itemcode='".$servicescode."'";
			$sql_serv34 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_serv) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		    $sql_res34 = mysqli_fetch_array($sql_serv34);
            $serviceledgcode=$sql_res34['ledgerid'];
			$serviceledgname=$sql_res34['ledgername'];
		
		$servicesrate=$_POST["rate3pkg"][$key];

		//$sharingamt = $servicesrate * ($ipserviceperc/100);

		$servicesrateuhx=$_POST["rate3uhxpkg"][$key];
		
		$pkg_status = 'YES';
		$packageid = $_POST['packageid'];
		$pkg_process_row_id = $_POST['servicesrowidpkg'][$key];

		
		if($servicesname!="")
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber,servicecoa,locationname,locationcode,servicesitemrateuhx,curtype,fxrate,incomeledgercode,incomeledgername,doctorcode,doctorname,wellnesspkg,pkg_status)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$currentdate','$billno','$servicecoa','".$locationnameget."','".$locationcodeget."','".$servicesrateuhx."','".$curtype."','".$fxrate."','$serviceledgcode','$serviceledgname','$servicedoctorcode','$servicedoctorname','0','$pkg_status')") or die("Error in ServiceQuery1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		//$ipdocquery=mysql_query("insert into billing_ipprivatedoctor(docno, patientname, patientcode, visitcode, accountname, description, doccoa, quantity, rate, amount, recordtime, ipaddress, recorddate, username, billstatus, doctorstatus, billtype, locationname, locationcode, transactionmode, transactionamount, pkg_status, visittype) VALUES ( '$billno', '$patientname', '$patientcode', '$visitcode', '$accountname', '$servicedoctorname', '$servicedoctorcode', '1', '$sharingamount', '$sharingamount', '$updatedate', '$ipaddress', '$updatedate', '$username', 'paid','unpaid', 'PAY LATER', '$locationnameget', '$locationcodeget', '$transactionmode', '$sharingamount', '$pkg_status', 'IP')") or die("Error in ipdocquery".mysql_error().__LINE__);
		}
		}
		
		
		}

		if($_POST["packagemiscode"]){

			$sql_serv="select ledgerid,ledgername from master_services where itemcode='".$_POST["packagemiscode"]."'";
			$sql_serv34 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_serv) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		    $sql_res34 = mysqli_fetch_array($sql_serv34);
            $serviceledgcode=$sql_res34['ledgerid'];
			$serviceledgname=$sql_res34['ledgername'];
            $servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber,servicecoa,locationname,locationcode,servicesitemrateuhx,curtype,fxrate,incomeledgercode,incomeledgername,doctorcode,doctorname,wellnesspkg,billstatus,pkg_id,pkg_status,package_process_id)values('$patientcode','$patientname','$visitcode','".$_POST["packagemiscode"]."','".$_POST["packagemisname"]."','".$_POST["mis_amt_service"]."','$accountname','$currentdate','$billno','','".$locationnameget."','".$locationcodeget."','".$_POST["mis_amt_service"]."','".$curtype."','".$fxrate."','$serviceledgcode','$serviceledgname','','','0','$stat','$packageid','$pkg_status','')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

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

		$pvtdrperc=$_POST['pvtdrpercentage'][$key];		
		$pvtdrsharingamount=$_POST['pvtdrsharingamt'][$key];
		$doccoa=$_POST['doccoa'][$key];
		
		$privatedoctorrateuhx=$_POST['privatedoctorrateuhx'][$key];
	    $privatedoctoramountuhx=$_POST['privatedoctoramountuhx'][$key];


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
		$query52 = "insert into billing_ipprivatedoctor(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,doccoa,billstatus,doctorstatus,billtype,rateuhx,amountuhx,curtype,fxrate,pvtdr_percentage,sharingamount,transactionamount,original_amt,is_resdoc)values('$privatedoctor','$privatedoctorrate','$privatedoctorquantity','$privatedoctoramount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','','".$locationnameget."','".$locationcodeget."','$doccoa','paid','unpaid','PAY LATER','".$privatedoctorrateuhx."','".$privatedoctoramountuhx."','".$curtype."','".$fxrate."','$pvtdrperc', '$pvtdrsharingamount','$privatedoctoramount','$privatedoctoramount','$is_resdoc')";
		$exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die("Error in Query53".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			//$doccoa = $_POST['doccoa'][$key];


			
			$query78 = "select id from master_accountname where accountname = '$privatedoctor'";
			$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die ("Error in Query78".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res78 = mysqli_fetch_array($exec78);
			$doccoa = $res78['id'];

			$doccoa = $_POST['privatedoctorcode'][$key];
			$pkg_status = 'YES';
				$packageid = $_POST['packageid'];
				$pkg_process_row_id = $_POST['privatedoctorrowidpkg'][$key];
			
				
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
    				
    			$query52 = "insert into billing_ipprivatedoctor(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,doccoa,rateuhx,amountuhx,curtype,fxrate,pkg_id,pkg_status,package_process_id,transactionamount,original_amt,billstatus,doctorstatus,billtype,sharingamount)values('$privatedoctor','$privatedoctorrate','$privatedoctorquantity','$privatedoctoramount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','','".$locationnameget."','".$locationcodeget."','$doccoa','".$privatedoctorrateuhx."','".$privatedoctoramountuhx."','".$curtype."','".$fxrate."','$packageid','$pkg_status','$pkg_process_row_id','".$privatedoctoramount."','".$privatedoctoramount."','paid','unpaid','PAY LATER','$sharing_amt')";
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
		
		if($nhifquantity!="")
		{
		$query53 = "insert into billing_ipnhif(rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,finamount,accountcode,rateuhx,amountuhx,curtype,fxrate)values('$nhifrate','$nhifquantity','$nhifamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$nhifcoa','".$locationnameget."','".$locationcodeget."','$finamount','$accountcode','".$nhifrateuhx."','".$nhifamountuhx."','".$curtype."','".$fxrate."')";
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
		
		$otbillingrateuhx=$_POST['otbillingrateuhx'][$key];
	    $otbillingamountuhx=$_POST['otbillingamountuhx'][$key];
		
			
		if($otbilling!="")
		{
		$query54 = "insert into billing_ipotbilling(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,rateuhx,amountuhx,curtype,fxrate)values('$otbilling','$otbillingrate','1','$otbillingamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$otbillingcoa','".$locationnameget."','".$locationcodeget."','".$otbillingrateuhx."','".$otbillingamountuhx."','".$curtype."','".$fxrate."')";
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
		
		$miscbillingrateuhx=$_POST['miscbillingrateuhx'][$key];
	    $miscbillingamountuhx=$_POST['miscbillingamountuhx'][$key];

		$miscbillingledname=$_POST['ledname'][$key];
		$miscbillingledid=$_POST['ledid'][$key];
			
		if($miscbilling!="")
		{
		$query55 = "insert into billing_ipmiscbilling(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,rateuhx,amountuhx,curtype,fxrate,billingaccountname,billingaccountcode)values('$miscbilling','$miscbillingrate','miscbillingquantity','$miscbillingamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$miscbillingcoa','".$locationnameget."','".$locationcodeget."','".$miscbillingrateuhx."','".$miscbillingamountuhx."','".$curtype."','".$fxrate."','".$miscbillingledname."','".$miscbillingledid."')";
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
		
		$admissionchargerateuhx=$_POST['admissionchargerateuhx'][$key];
	    $admissionchargeamountuhx=$_POST['admissionchargeamountuhx'][$key];
		
			
		if($admissionchargerate!="")
		{
		$query56 = "insert into billing_ipadmissioncharge(rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode,rateuhx,amountuhx,curtype,fxrate)values('$admissionchargerate','1','$admissionchargeamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$admissionchargecoa','".$locationnameget."','".$locationcodeget."','".$admissionchargerateuhx."','".$admissionchargeamountuhx."','".$curtype."','".$fxrate."')";
		$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		}
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipcreditapproved(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,totalrevenue,discount,deposit,nhif,depositcoa,locationname,locationcode,fxamount,curtype,fxrate,accountnameid,accountnameano,preauthcode)values('$billno','$patientname','$patientcode','$visitcode','$totalamount','$currentdate','$accountname','$subtype','$totalrevenue','$discount','$deposit','$nhif','$ipdepositscoa','".$locationnameget."','".$locationcodeget."','".$totalamountuhx."','".$curtype."','".$fxrate."','$accountcode','$accountanum','$preauthcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if($account1name != '')
		{
		if($account1name == 'CASH')
		{
		$query43="insert into master_transactionipcreditapproved(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber,postingaccount,locationname,locationcode,fxamount,curtype,fxrate,accountnameid,accountnameano)values('$patientname','$patientcode','$visitcode','$currentdate','$account1name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account1amount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber','$account1name','".$locationnameget."','".$locationcodeget."','".$account1fxamount."','".$curtype."','".$fxrate."','$account1nameid','$account1nameano')";
	    $exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die("error in query43".mysqli_error($GLOBALS["___mysqli_ston"]));	
		
				  
		}else
		{
		$query43="insert into master_transactionipcreditapproved(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,postingaccount,locationname,locationcode,fxamount,curtype,fxrate,accountnameid,accountnameano)values('$patientname','$patientcode','$visitcode','$currentdate','$account1name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account1amount','$username','$updatetime','$account1name','".$locationnameget."','".$locationcodeget."','".$account1fxamount."','".$curtype."','".$fxrate."','$account1nameid','$account1nameano')";
	    $exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die("error in query43".mysqli_error($GLOBALS["___mysqli_ston"]));		  
		
		$query432="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,locationname,locationcode,fxamount,currency,fxrate,accountcode,accountnameid,accountnameano,billbalanceamount,subtypeano)values('$patientname','$patientcode','$visitcode','$currentdate','$account1name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype1name','$account1amount','$username','$updatetime','".$locationnameget."','".$locationcodeget."','".$account1fxamount."','".$curtype."','".$fxrate."','$account1nameid','$account1nameid','$account1nameano','$account1fxamount','$subtype1id')";
		$exec432=mysqli_query($GLOBALS["___mysqli_ston"], $query432) or die("error in query432".mysqli_error($GLOBALS["___mysqli_ston"]));		        
		$keyprovider='';
		$payercode1='';
		$slade_balres=0;
		if($slade_key_provider!='')
		{
			if($slade_key_provider==$account1nameid)
			{
				
				$keyprovider='yes';
				$payercode1=$payer_code;
				$slade_balres=$slade_balres+$account1fxamount;
			}
		}
		
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipcreditapprovedtransaction(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,locationname,locationcode,fxamount,currency,fxrate,accountcode,accountnameid,accountnameano,keyprovider,payer_code)values('$billno','$patientname','$patientcode','$visitcode','$account1amount','$currentdate','$account1name','$subtype','".$locationnameget."','".$locationcodeget."','".$account1fxamount."','".$curtype."','".$fxrate."','$account1nameid','$account1nameid','$account1nameano','$keyprovider','$payercode1')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		 $ipduevalue=0;
		 $Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select ipdue, ipplandue from master_customer where customercode='$patientcode'");
		 $execlab=mysqli_fetch_array($Querylab);
		 $ipduevalue=$execlab['ipdue'];
		 $ipplandue=$execlab['ipplandue'];
		 $ipduevalue=$ipduevalue+$account1fxamount;
		 $ipplandue = $ipplandue+$account1fxamount;
		 
		 mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE  master_customer SET ipdue = '".$ipduevalue."', ipplandue = '".$ipplandue."' where customercode='$patientcode'");
	
		}
		}
		if($account2name != '')
		{
		if($account2name == 'CASH')
		{
		$query431="insert into master_transactionipcreditapproved(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber,postingaccount,locationname,locationcode,fxamount,curtype,fxrate,accountnameid,accountnameano)values('$patientname','$patientcode','$visitcode','$currentdate','$account2name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account2amount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber','$account2name','".$locationnameget."','".$locationcodeget."','".$account2fxamount."','".$curtype."','".$fxrate."','$account2nameid','$account2nameano')";
	    $exec431=mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die("error in query431".mysqli_error($GLOBALS["___mysqli_ston"]));		  
		
		
		}
		else
		{
		$query431="insert into master_transactionipcreditapproved(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,postingaccount,locationname,locationcode,fxamount,curtype,fxrate,accountnameid,accountnameano)values('$patientname','$patientcode','$visitcode','$currentdate','$account2name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account2amount','$username','$updatetime','$account2name','".$locationnameget."','".$locationcodeget."','".$account2fxamount."','".$curtype."','".$fxrate."','$account2nameid','$account2nameano')";
	    $exec431=mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die("error in query431".mysqli_error($GLOBALS["___mysqli_ston"]));		  
		
		$query4312="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,locationname,locationcode,fxamount,currency,fxrate,accountcode,accountnameid,accountnameano,billbalanceamount,subtypeano)values('$patientname','$patientcode','$visitcode','$currentdate','$account2name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype2name','$account2amount','$username','$updatetime','".$locationnameget."','".$locationcodeget."','".$account2fxamount."','".$curtype."','".$fxrate."','$account2nameid','$account2nameid','$account2nameano','$account2fxamount','$subtype2id')";
	    $exec4312=mysqli_query($GLOBALS["___mysqli_ston"], $query4312) or die("error in query4312".mysqli_error($GLOBALS["___mysqli_ston"]));		   
		$keyprovider='';
		$payercode1='';
		if($slade_key_provider!='')
		{
			
			if($slade_key_provider==$account2nameid)
			{
				$keyprovider='yes';
				$payercode1=$payer_code;
				$slade_balres=$slade_balres+$account2fxamount;
			}
		}
		
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipcreditapprovedtransaction(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,locationname,locationcode,fxamount,currency,fxrate,accountcode,accountnameid,accountnameano,keyprovider,payer_code)values('$billno','$patientname','$patientcode','$visitcode','$account2amount','$currentdate','$account2name','$subtype','".$locationnameget."','".$locationcodeget."','".$account2fxamount."','".$curtype."','".$fxrate."','$account2nameid','$account2nameid','$account2nameano','$keyprovider','$payercode1')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$ipduevalue=0;
		 $Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select ipdue, ipplandue from master_customer where customercode='$patientcode'");
		 $execlab=mysqli_fetch_array($Querylab);
		 $ipduevalue=$execlab['ipdue'];
		 $ipplandue=$execlab['ipplandue'];
		 $ipduevalue=$ipduevalue+$account2fxamount;
		 $ipplandue = $ipplandue+$account2fxamount;
		 
		 mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE  master_customer SET ipdue = '".$ipduevalue."', ipplandue = '".$ipplandue."' where customercode='$patientcode'");
	
	
		}
		}
		if($account3name != '')
		{
		if($account3name == 'CASH')
		{
		$query432="insert into master_transactionipcreditapproved(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber,postingaccount,locationname,locationcode,fxamount,curtype,fxrate,accountnameid,accountnameano)values('$patientname','$patientcode','$visitcode','$currentdate','$account3name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account3amount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber','$account3name','".$locationnameget."','".$locationcodeget."','".$account3fxamount."','".$curtype."','".$fxrate."','$account3nameid','$account3nameano')";
	    $exec432=mysqli_query($GLOBALS["___mysqli_ston"], $query432) or die("error in query432".mysqli_error($GLOBALS["___mysqli_ston"]));		  
		}
		else
		{
		$query432="insert into master_transactionipcreditapproved(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,postingaccount,locationname,locationcode,fxamount,curtype,fxrate,accountnameid,accountnameano)values('$patientname','$patientcode','$visitcode','$currentdate','$account3name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account3amount','$username','$updatetime','$account3name','".$locationnameget."','".$locationcodeget."','".$account3fxamount."','".$curtype."','".$fxrate."','$account3nameid','$account3nameano')";
	    $exec432=mysqli_query($GLOBALS["___mysqli_ston"], $query432) or die("error in query432".mysqli_error($GLOBALS["___mysqli_ston"]));		  
		
		$query4321="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,locationname,locationcode,fxamount,currency,fxrate,accountcode,accountnameid,accountnameano,billbalanceamount,subtypeano)values('$patientname','$patientcode','$visitcode','$currentdate','$account3name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype3name','$account3amount','$username','$updatetime','".$locationnameget."','".$locationcodeget."','".$account3fxamount."','".$curtype."','".$fxrate."','$account3nameid','$account3nameid','$account3nameano','$account3fxamount','$subtype3id')";
	    $exec4321=mysqli_query($GLOBALS["___mysqli_ston"], $query4321) or die("error in query4321".mysqli_error($GLOBALS["___mysqli_ston"]));	
		
		$keyprovider='';
		$payercode1='';
		if($slade_key_provider!='')
		{
			
			if($slade_key_provider==$account3nameid)
			{
				$keyprovider='yes';
				$payercode1=$payer_code;
				$slade_balres=$slade_balres+$account3fxamount;
			}
		}
		
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipcreditapprovedtransaction(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,locationname,locationcode,fxamount,currency,fxrate,accountcode,accountnameid,accountnameano,keyprovider,payer_code)values('$billno','$patientname','$patientcode','$visitcode','$account3amount','$currentdate','$account3name','$subtype','".$locationnameget."','".$locationcodeget."','".$account3fxamount."','".$curtype."','".$fxrate."','$account3nameid','$account3nameid','$account3nameano','$keyprovider','$payercode1')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  
		$ipduevalue=0;
		 $Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select ipdue, ipplandue from master_customer where customercode='$patientcode'");
		 $execlab=mysqli_fetch_array($Querylab);
		 $ipduevalue=$execlab['ipdue'];
		 $ipplandue=$execlab['ipplandue'];
		 $ipduevalue=$ipduevalue+$account3fxamount;
		 $ipplandue = $ipplandue+$account3fxamount;
		 
		 mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE  master_customer SET ipdue = '".$ipduevalue."', ipplandue = '".$ipplandue."' where customercode='$patientcode'");
	
	
		}
		}
		
		
		if($account4amount != '' || $account4amount != 0 )
		{
		$query432="insert into master_transactionipcreditapproved(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,postingaccount,locationname,locationcode,fxamount,curtype,fxrate,accountnameid,accountnameano)values('$patientname','$patientcode','$visitcode','$currentdate','$account4name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account4amount','$username','$updatetime','$account4name','".$locationnameget."','".$locationcodeget."','".$account4fxamount."','".$curtype."','".$fxrate."','$account4nameid','$account4nameano')";
	    $exec432=mysqli_query($GLOBALS["___mysqli_ston"], $query432) or die("error in query432".mysqli_error($GLOBALS["___mysqli_ston"]));		  
		
		$query4321="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,locationname,locationcode,fxamount,currency,fxrate,accountcode,accountnameid,accountnameano,billbalanceamount,subtypeano)values('$patientname','$patientcode','$visitcode','$currentdate','$account4name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype3name','$account4amount','$username','$updatetime','".$locationnameget."','".$locationcodeget."','".$account4fxamount."','".$curtype."','".$fxrate."','$account4nameid','$account4nameid','$account4nameano','$account4fxamount','$subtype3id')";
	    $exec4321=mysqli_query($GLOBALS["___mysqli_ston"], $query4321) or die("error in query4321".mysqli_error($GLOBALS["___mysqli_ston"]));	
		
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipcreditapprovedtransaction(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,locationname,locationcode,fxamount,currency,fxrate,accountcode,accountnameid,accountnameano,nhifclaim_flag)values('$billno','$patientname','$patientcode','$visitcode','$account4amount','$currentdate','$account4name','$subtype','".$locationnameget."','".$locationcodeget."','".$account4fxamount."','".$curtype."','".$fxrate."','$account4nameid','$account4nameid','$account4nameano','1')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  
		$ipduevalue=0;
		 $Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select ipdue, ipplandue from master_customer where customercode='$patientcode'");
		 $execlab=mysqli_fetch_array($Querylab);
		 $ipduevalue=$execlab['ipdue'];
		 $ipplandue=$execlab['ipplandue'];
		 $ipduevalue=$ipduevalue+$account3fxamount;
		 $ipplandue = $ipplandue+$account3fxamount;
		 
		 mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE  master_customer SET ipdue = '".$ipduevalue."', ipplandue = '".$ipplandue."' where customercode='$patientcode'");	
		}
		
		
		
		
		
		
		$query64 = "update ip_bedallocation set paymentstatus='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query641 = "update master_ipvisitentry set paymentstatus='completed',finalbillno='$billno' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query6412 = "update ip_discharge set paymentstatus='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec6412 = mysqli_query($GLOBALS["___mysqli_ston"], $query6412) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query92 = "update ip_creditapproval set recordstatus='finalized' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec92 = mysqli_query($GLOBALS["___mysqli_ston"], $query92) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if($eclaim==1){
			$key_provider = $_REQUEST['key_provider'];
	       header("location:writexmlipcredit.php?billautonumber=$billno&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&&loc=$locationcodeget&&key_provider=$key_provider");
		  }
		  elseif($eclaim==2){
			 if($slade_balres<=0)
			 {
				 $slade_balres=$totalamount;
			 }
			 if($offpatient!='')
		   {
		   header("location:slade-claim.php?billno=$billno&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&slade=yes&type=ip&frmtype=ip&offpatient=$offpatient");
	 
	   exit;
		   }
		   else
		   { 
		   header("location:slade-balance.php?billautonumber=$billno&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&slade=yes&claim=$slade_claim_id&authorization_id=$authorization_code&amount=$slade_balres&type=ip");
            exit;
		  }
		  }
		  elseif($eclaim==3){
			$key_provider = $_REQUEST['key_provider'];
		   header("location:writexmlipcredit.php?billautonumber=$billno&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&&loc=$locationcodeget&&key_provider=$key_provider&&slade=yes&split_status=yes");
            exit;
		  }
		  elseif($offpatient!='')
		   {
		   header("location:slade-claim.php?billno=$billno&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&type=ip&frmtype=ip&offpatient=$offpatient");
	 
	   exit;
		   }
		  else
		  {
			  
		header("location:approvedcreditlist.php?patientcode=$patientcode&&visitcode=$visitcode&&billnumber=$billnumbercode&&st=success&&locationcode=$locationcodeget");
		  }
		exit;
		
		} else {
		
	$res = mysqli_fetch_array($query);	
	
	header("location:approvedcreditlist.php?patientcode=".$res['patientcode']."&&visitcode=".$res['visitcode']."&&billnumber=".$res['billno']."&&locationcode=".$res['locationcode']."&&st=success");
	exit;
		
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

?>
<?php

$query100 = "select locationcode,planname,eclaim_id,offpatient from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec100 = mysqli_query($GLOBALS["___mysqli_ston"], $query100) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
$num100=mysqli_num_rows($exec100);
$res100 = mysqli_fetch_array($exec100);	
$locationcodeget = $res100['locationcode'];
$plan_no = $res100['planname'];
$eclaim_id = $res100['eclaim_id'];
$offpatient=$res100['offpatient'];
if($offpatient=='1')
{
	$offpatient='offslade';
}
else
{
	$offpatient='';
}

$query128 = "select smartap from master_planname where auto_number='$plan_no'";
$exec128 = mysqli_query($GLOBALS["___mysqli_ston"], $query128) or die ("Error in Query128".mysqli_error($GLOBALS["___mysqli_ston"]));
$res128 = mysqli_fetch_array($exec128);	
$smartap = $res128['smartap'];

$query_bill_location = "select auto_number from master_location where locationcode = '$locationcodeget'";
$exec_bill_loctation = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill_location) or die ("Error in Query_bill_location".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res_bill_loct = mysqli_fetch_array($exec_bill_loctation);
$location_num = $res_bill_loct['auto_number'];
$query_bill = "select prefix from bill_formats where description = 'bill_ipcreditapproved'";
$exec_bill = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill) or die ("Error in Query_bill".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res_bill = mysqli_fetch_array($exec_bill);
$paylaterbillprefix = $res_bill['prefix'];
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_ipcreditapproved order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1'."-".date('y')."-".$location_num;
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
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum."-".date('y')."-".$location_num;
	$openingbalance = '0.00';
	//echo $companycode;
}
$query7641 = "select * from master_financialintegration where field='ipdepositscreditapproval'";
$exec7641 = mysqli_query($GLOBALS["___mysqli_ston"], $query7641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res7641 = mysqli_fetch_array($exec7641);

$ipdepositscoa = $res7641['code'];
$ipdepositscoaname = $res7641['coa'];
$ipdepositstype = $res7641['type'];
$ipdepositsselect = $res7641['selectstatus'];



$query76 = "select * from master_financialintegration where field='labipcreditapproval'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologyipcreditapproval'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res761 = mysqli_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='serviceipcreditapproval'";
$exec762 = mysqli_query($GLOBALS["___mysqli_ston"], $query762) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res762 = mysqli_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalipcreditapproval'";
$exec763 = mysqli_query($GLOBALS["___mysqli_ston"], $query763) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res763 = mysqli_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacyipcreditapproval'";
$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res764 = mysqli_fetch_array($exec764);

$pharmacycoa = $res764['code'];

$query765 = "select * from master_financialintegration where field='cashipcreditapproval'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeipcreditapproval'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaipcreditapproval'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardipcreditapproval'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineipcreditapproval'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);

$onlinecoa = $res769['code'];

$query770 = "select * from master_financialintegration where field='bedchargesipcreditapproval'";
$exec770 = mysqli_query($GLOBALS["___mysqli_ston"], $query770) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res770 = mysqli_fetch_array($exec770);

$bedchargescoa = $res770['code'];

$query771 = "select * from master_financialintegration where field='rmoipcreditapproval'";
$exec771 = mysqli_query($GLOBALS["___mysqli_ston"], $query771) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res771 = mysqli_fetch_array($exec771);

$rmocoa = $res771['code'];

$query772 = "select * from master_financialintegration where field='nursingipcreditapproval'";
$exec772 = mysqli_query($GLOBALS["___mysqli_ston"], $query772) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res772 = mysqli_fetch_array($exec772);

$nursingcoa = $res772['code'];

$query773 = "select * from master_financialintegration where field='privatedoctoripcreditapproval'";
$exec773 = mysqli_query($GLOBALS["___mysqli_ston"], $query773) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res773= mysqli_fetch_array($exec773);

$privatedoctorcoa = $res773['code'];

$query774 = "select * from master_financialintegration where field='ambulanceipcreditapproval'";
$exec774 = mysqli_query($GLOBALS["___mysqli_ston"], $query774) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res774= mysqli_fetch_array($exec774);

$ambulancecoa = $res774['code'];

$query775 = "select * from master_financialintegration where field='nhifipcreditapproval'";
$exec775 = mysqli_query($GLOBALS["___mysqli_ston"], $query775) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res775= mysqli_fetch_array($exec775);

$nhifcoa = $res775['code'];

$query776 = "select * from master_financialintegration where field='otbillingipcreditapproval'";
$exec776 = mysqli_query($GLOBALS["___mysqli_ston"], $query776) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res776= mysqli_fetch_array($exec776);

$otbillingcoa = $res776['code'];

$query777 = "select * from master_financialintegration where field='miscbillingipcreditapproval'";
$exec777 = mysqli_query($GLOBALS["___mysqli_ston"], $query777) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res777= mysqli_fetch_array($exec777);

$miscbillingcoa = $res777['code'];

$query778 = "select * from master_financialintegration where field='admissionchargeipcreditapproval'";
$exec778 = mysqli_query($GLOBALS["___mysqli_ston"], $query778) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res778= mysqli_fetch_array($exec778);

$admissionchargecoa = $res778['code'];

$query779 = "select * from master_financialintegration where field='ippackagecreditapproval'";
$exec779 = mysqli_query($GLOBALS["___mysqli_ston"], $query779) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res779= mysqli_fetch_array($exec779);

$packagecoa = $res779['code'];


?>


<?php

$query728 = "select fxamount from billing_ipcreditapprovedtransaction where patientcode='$patientcode' and visitcode='$visitcode' and keyprovider='yes'";
$exec728 = mysqli_query($GLOBALS["___mysqli_ston"], $query728) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res728 = mysqli_fetch_array($exec728);
$slade_balres = $res728['fxamount'];


$query72 = "select * from ip_creditapprovalformdata where patientcode='$patientcode' and visitcode='$visitcode'";
$exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res72 = mysqli_fetch_array($exec72);
$account1name = $res72['account1name'];
$account1nameid = $res72['account1nameid'];
$account1nameano = $res72['account1nameano'];
$approvalcomments = $res72['approvalcomments'];

$query67 = "select subtype from master_accountname where id='$account1nameid'";
$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
$res67 = mysqli_fetch_array($exec67);
$subtype = $res67['subtype'];

$query671 = "select slade_payer_code from master_subtype where auto_number='$subtype'";
$exec671 = mysqli_query($GLOBALS["___mysqli_ston"], $query671); 
$res671 = mysqli_fetch_array($exec671);
$slade_payer_code = $res671['slade_payer_code'];

if($account1name == 'nil')
{
$account1name = '';
}
$account1amount = $res72['account1amount'];
if($account1amount == '0.00')
{
$account1amount = '';
}
$account2name = $res72['account2name'];
$account2nameid = $res72['account2nameid'];
$account2nameano = $res72['account2nameano'];
if($account2name == 'nil')
{
$account2name = '';
}
$account2amount = $res72['account2amount'];
if($account2amount == '0.00')
{
$account2amount = '';
}


$query678 = "select subtype from master_accountname where id='$account2nameid'";
$exec678 = mysqli_query($GLOBALS["___mysqli_ston"], $query678); 
$res678 = mysqli_fetch_array($exec678);
$subtype = $res678['subtype'];

$query6718 = "select slade_payer_code from master_subtype where auto_number='$subtype'";
$exec6718 = mysqli_query($GLOBALS["___mysqli_ston"], $query6718); 
$res6718 = mysqli_fetch_array($exec6718);
$slade_payer_code1 = $res6718['slade_payer_code'];


$account3name = $res72['account3name'];
$account3nameid = $res72['account3nameid'];
$account3nameano = $res72['account3nameano'];
if($account3name == 'nil')
{
$account3name = '';
}
$account3amount = $res72['account3amount'];
if($account3amount == '0.00')
{
$account3amount = '';
}

$query678 = "select subtype from master_accountname where id='$account3nameid'";
$exec679 = mysqli_query($GLOBALS["___mysqli_ston"], $query679); 
$res679 = mysqli_fetch_array($exec679);
$subtype = $res679['subtype'];

$query6719 = "select slade_payer_code from master_subtype where auto_number='$subtype'";
$exec6719 = mysqli_query($GLOBALS["___mysqli_ston"], $query6719); 
$res6719 = mysqli_fetch_array($exec6719);
$slade_payer_code2 = $res6719['slade_payer_code'];


$account4name = $res72['account4name'];
$account4nameid = $res72['account4nameid'];
$account4nameano = $res72['account4nameano'];
if($account4name == 'nil')
{
$account4name = '';
}
$account4amount = $res72['account4amount'];
if($account4amount == '0.00')
{
$account4amount = '';
}



$nhif_provider=0;	
$allowsmart=0;
$other_provider=0;	
$key_provider="";
		 
$nhif_array=array('411','412','413','414','415','416','417','418','419');
if($account1nameano!='0'){
		 if(in_array($account1nameano,$nhif_array))
		 {
			$nhif_provider++;
		 }else
		 {
			 $other_provider++;
			 $key_provider=$account1nameano;
		 }
}
if($account2nameano!='0'){
		 if(in_array($account2nameano,$nhif_array))
		 {
			$nhif_provider++;
		 }else
		 {
			 $other_provider++;
			 $key_provider=$account2nameano;
		 }
}
if($account3nameano!='0'){
		 if(in_array($account3nameano,$nhif_array))
		 {
			$nhif_provider++;
		 }else
		 {
			 $other_provider++;
			 $key_provider=$account3nameano;
		 }
}
//echo 'acc2'.$acc2_nhif.'<br/>';
//echo 'acc3'.$acc3_nhif.'<br/>';
//echo 'nhif_provider'.$nhif_provider.'<br/>';
//echo 'other_provider'.$other_provider.'<br/>';
		 if(($nhif_provider==1)&&($other_provider==1))
		 {
			 
			$allowsmart=1;
		 }
		 
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
<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>
 
 <script src="js/jquery-ui.min.js"></script> 
<script>

function funfetchsavannah(smartap)
{

if(smartap==1)
{
	//alert('ok');
var customersearch=document.getElementById("patientcode").value;
	//alert(customersearch);
var registrationdate=document.getElementById("registrationdate").value;
var data = "InOut_Type=2&&customersearch="+customersearch+"&&registrationdate="+registrationdate;	
$.ajax({
  type : "get",
  url : "autocustomersmartsearch.php",
  data : data,
  cache : false,
  success : function (t){
  if(t!='')
	{
	//document.getElementById("price").innerHTML=t;
	var varCompleteStringReturned=t;
	//alert (varCompleteStringReturned);
	var varNewLineValue=varCompleteStringReturned.split("#");
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	
	var Benefitno = varNewLineValue[0];
	var BenefitAmt = varNewLineValue[1];
	var Admitid = varNewLineValue[2];
	var availablelimit = document.getElementById("availablelimit").value;
	//if(availablelimit == 0){
	document.getElementById("availablelimit").value = BenefitAmt;
	document.getElementById("smartbenefitno").value = Benefitno;
	document.getElementById("admitid").value = Admitid;
	//}
	if(Admitid=='' || Admitid==null || Admitid==0){
		alert('Admit id is not available, try to reforward and fetch.');
		return false;
	}
	else
	  alert("Smart Fetch Successfull");


	
	if(parseFloat($('#availablelimit').val()) > 0.00)
    {
     $('#submit').prop("disabled",false);
	  $('#fetch').prop("disabled",true);
    }
	
	}
	}
    
 });
}
else if(smartap==2)
{
if(document.getElementById("offpatient").value == '')
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
	    var sldeauth=jsondata['slade_authentication_token'];
      var jsonData = JSON.parse(sldeauth);
      var authorization_guid_val = jsonData.authorization_guid;
	    if(jsondata.length !=0 && jsondata['status'] == 'Success'){
	  if(jsondata['has_op'] == 'Y')
	  {
	  //$('#slade_claim_id').val(jsondata['claim_id']);  
	   $('#availablelimit').val(jsondata['visit_limit']);
	   $('#authorization_code').val(authorization_guid_val);	
	   $('#submit').prop("disabled",false);
	   $('#fetch').prop("disabled",true);
	  
	  }
	else
	{
	alert('Member not covered for Out-Patient');
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
else if(smartap==3)
{
	if(document.getElementById("offpatient").value == '')
	  {
if(document.getElementById('savannah_authid').value == '')
{
	alert("Slade auth id. can not be empty.");
	document.getElementById('savannah_authid').focus();
	return false;
}
	  }
var customersearch=document.getElementById("patientcode").value;
	//alert(customersearch);
var registrationdate=document.getElementById("registrationdate").value;
var data = "InOut_Type=2&&customersearch="+customersearch+"&&registrationdate="+registrationdate;	
$.ajax({
  type : "get",
  url : "autocustomersmartsearch.php",
  data : data,
  cache : false,
  success : function (t){
  if(t!='')
	{
	//document.getElementById("price").innerHTML=t;
	var varCompleteStringReturned=t;
	//alert (varCompleteStringReturned);
	var varNewLineValue=varCompleteStringReturned.split("#");
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	
	var Benefitno = varNewLineValue[0];
	var BenefitAmt = varNewLineValue[1];
	var Admitid = varNewLineValue[2];
	var availablelimit = document.getElementById("availablelimit").value;
	//if(availablelimit == 0){
	document.getElementById("availablelimit").value = BenefitAmt;
	document.getElementById("smartbenefitno").value = Benefitno;
	document.getElementById("admitid").value = Admitid;
	//}
	if(Admitid=='' || Admitid==null || Admitid==0){
		alert('Admit id is not available, try to reforward and fetch.');
		return false;
	}
	else
	  alert("Smart Fetch Successfull");


	
	if(parseFloat($('#availablelimit').val()) > 0.00)
    {
     $('#submit').prop("disabled",false);
	  $('#fetch').prop("disabled",true);
    }
	
	}
	}
    
 });
}
}


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



function balancecalc()
{

var netpayable = document.getElementById("netcashpayable").value;
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

var balance = netpayable - (parseFloat(cash)+parseFloat(cheque)+parseFloat(online)+parseFloat(mpesa)+parseFloat(creditcard));


if(balance < 0)
{
alert("Entered Amount is greater than Cash Amount");
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
var accountname = document.getElementById("accountname").value;
var accountname2 = document.getElementById("accountname2").value;
var accountname3 = document.getElementById("accountname3").value;
if((accountname == 'CASH')||(accountname2 == 'CASH')||(accountname3 == 'CASH'))
{
var balance = document.getElementById("balance").value;
if(balance == '')
{
alert("Please Enter the Amount");
return false;
}
if(balance != 0.00)
{
alert("Balance is still pending");
return false;
}
}
  //funcSaveBill1();
  
  if(document.getElementById('isapprovalrequired').value == '1')	
if(document.getElementById('preauthcode').value == ''   ){	
{		
alert("Pre Auth code can not be empty.");	
document.getElementById("preauthcode").focus();	
return false;		
}	
}


var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}

	FuncPopup();
	
}

function changeOffline()
{
	if(document.getElementById("offline").checked==true)
	{
	document.getElementById("fetch").disabled=true;	
	document.getElementById("submit").disabled=false;	
	document.getElementById('eclaim').value=0;
	}else
	{
	document.getElementById("fetch").disabled=false;	
	document.getElementById("submit").disabled=true;	
	document.getElementById('eclaim').value=1;
	}

}
function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}

/*function funcSaveBill1()
{

var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
	else
	{
		//alert ("Entry Saved.");
		
		
		//return true;
	}
	
	}*/
</script>


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
<form name="form1" id="form1" method="post" action="ipapprovedcreditform.php" onSubmit="return validcheck()">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="17" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="17" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="17" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="17">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
   
    <td colspan="8" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
          <?php
		  
		  $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		  
		  	
		//this is to get subtype 
		$querymenu = "select subtype,planname,admitid,overalllimit from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$execmenu = mysqli_query($GLOBALS["___mysqli_ston"], $querymenu) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$nummenu=mysqli_num_rows($execmenu);
		
		$resmenu = mysqli_fetch_array($execmenu);
		
		$menusub=$resmenu['subtype'];
		$patientplan = $resmenu['planname'];
		$admitid = $resmenu['admitid'];
		$availablelimit = $resmenu['overalllimit'];
		$availablelimit = number_format($availablelimit,2,'.','');
		
		$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");
		$execplan=mysqli_fetch_array($queryplan);
		$patientplan1=$execplan['planname'];
		$smartap=$execplan['smartap'];


		
		$query32 = "select currency,fxrate,subtype from master_subtype where auto_number = '".$menusub."'";
		$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	//	$res2 = mysql_num_rows($exec2);
		$mastervalue = mysqli_fetch_array($exec32);
		$currency=$mastervalue['currency'];
		$fxrate=$mastervalue['fxrate'];
		$subtype=$mastervalue['subtype'];
		
		
		   $query1 = "select locationcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		
		
		$locationcodeget = $res1['locationcode'];
		$query551 = "select * from master_location where locationcode='".$locationcodeget."'";
		$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res551 = mysqli_fetch_array($exec551);
		$locationnameget = $res551['locationname'];
		}?>
             <tr>
						  <td colspan="4" class="bodytext31" bgcolor="#ecf0f5"><strong>Credit Approval</strong></td>
                          <td colspan="3" class="bodytext31" bgcolor="#ecf0f5"><strong>Location &nbsp;</strong><?php echo $locationnameget;?></td>
                  <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">
				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">
						</tr>
            <tr>
              <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill No</strong></div></td>
				 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Type</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Subtype</strong></div></td>
                <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Scheme</strong></div></td>
				
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Offline</strong></div></td>
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
		$patienttype=$res1['paymenttype'];
		$pvtype = $res1['type'];		
		$savannah_authid=$res1['savannah_authid'];
		$patientfirstname=$res1['patientfirstname'];
		$patientlastname=$res1['patientlastname'];
		$patientplan = $res1['planname'];
		
		$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
		$execlab=mysqli_fetch_array($Querylab);
		//$patienttype=$execlab['maintype'];
		$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
		$exectype=mysqli_fetch_array($querytype);
		$patienttype1=$exectype['paymenttype'];
		$patientsubtype=$res1['subtype'];
		
		$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");
		$execplan=mysqli_fetch_array($queryplan);
		$patientplan1=$execplan['planname'];
		$smartap=$execplan['smartap'];
		$scheme_name=$execplan['scheme_name'];

		$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
		$execsubtype=mysqli_fetch_array($querysubtype);
		$patientsubtype1=$execsubtype['subtype'];
		$bedtemplate=$execsubtype['bedtemplate'];
		$labtemplate=$execsubtype['labtemplate'];
		$radtemplate=$execsubtype['radtemplate'];
		$sertemplate=$execsubtype['sertemplate'];
		$preauthrequired=$execsubtype['preauthrequired'];
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
		$acccode = $res67['id'];
		$accanum = $res67['auto_number'];
		
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
				<td  align="center" valign="center" class="bodytext31"><?php echo $patientsubtype1; ?></td>
                <td  align="center" valign="center" class="bodytext31"><?php echo $scheme_name; ?></td>
				<?php 
				if($allowsmart==1){ ?>
				<td  align="center" valign="center" class="bodytext31"><input type="checkbox" id="offline" name="offline" style="font-size:23px;width:15px;height:15px" onChange="changeOffline()"></td>
	<?php	} ?>
				<input type="hidden" name="isapprovalrequired" id="isapprovalrequired" value="<?php echo $preauthrequired; ?>">
			<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
			 <input type="hidden" name="packagecoa" value="<?php echo $packagecoa; ?>">
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
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="registrationdate" id="registrationdate" value="<?php echo date('Y-m-d'); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                 <input type="hidden" name="smartbenefitno" id="smartbenefitno" value="">
                <input type="hidden" name="admitid" id="admitid" value="">
				
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
					<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>">	
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
				<input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>">
                <input type="hidden" name="acccode" id="acccode" value="<?php echo $acccode; ?>">
				<input type="hidden" name="accanum" id="accanum" value="<?php echo $accanum; ?>">	
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
		<tr>
        <td>&nbsp;</td>
		</tr>
	<tr>
	
	<td>&nbsp;</td>
	<td width="6%">&nbsp;</td>
	<td colspan="4">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="140%" 
            align="left" border="0">
          <tbody id="foo">
           <tr bgcolor="#011E6A">
                <td colspan="9" bgcolor="#ecf0f5" class="bodytext31"><strong>Transaction Details</strong></td>
			 </tr>
          
            <tr>
			 
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref.No</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
                
                 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong><?php echo strtoupper($currency);?></strong></div></td>
                <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
                <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>UHX(<?php echo strtoupper($currency);?>)</strong></div></td>
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
			$totalopuhx=$consultationfee*$fxrate;
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
				  	 <input type="hidden" name="admissionchargerate[]" id="admissionchargerate" value="<?php echo $consultationfee/$fxrate; ?>">
			 <input type="hidden" name="admissionchargeamount[]" id="admissionchargeamount" value="<?php echo $consultationfee/$fxrate; ?>">
             
               	 <input type="hidden" name="admissionchargerateuhx[]" id="admissionchargerateuhx" value="<?php echo $consultationfee; ?>">
			 <input type="hidden" name="admissionchargeamountuhx[]" id="admissionchargeamountuhx" value="<?php echo $consultationfee; ?>">
			
	  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee),2,'.',','); ?></div></td>
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
				 		  	 <input type="hidden" name="admissionchargerate[]" id="admissionchargerate" value="<?php echo $consultationfee/$fxrate; ?>">
			 <input type="hidden" name="admissionchargeamount[]" id="admissionchargeamount" value="<?php echo $consultationfee/$fxrate; ?>">
             
              	 <input type="hidden" name="admissionchargerateuhx[]" id="admissionchargerateuhx" value="<?php echo $consultationfee; ?>">
			 <input type="hidden" name="admissionchargeamountuhx[]" id="admissionchargeamountuhx" value="<?php echo $consultationfee; ?>">
             
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee),2,'.',','); ?></div></td>
            </tr>
			<?php
			}
			
			?>
					  <?php
					  $packageamount = 0;
					  $packageamountuhx=0;
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
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			 <input type="hidden" name="description[]" id="description" value="<?php echo $packagename; ?>">
			 <input type="hidden" name="descriptionrate[]" id="descriptionrate" value="<?php echo $packageamount; ?>">
			 <input type="hidden" name="descriptionamount[]" id="descriptionamount" value="<?php echo $packageamount; ?>">
			 <input type="hidden" name="descriptionquantity[]" id="descriptionquantity" value="<?php echo '1'; ?>">
			  <input type="hidden" name="descriptiondocno[]" id="descriptiondocno" value="<?php echo $visitcode; ?>">
              
               <input type="hidden" name="descriptionrateuhx[]" id="descriptionrateuhx" value="<?php echo $packageamount*$fxrate; ?>">
			 <input type="hidden" name="descriptionamountuhx[]" id="descriptionamountuhx" value="<?php echo $packageamount*$fxrate; ?>">
             
                     <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($packageamount),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($packageamount),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($packageamount*$fxrate),2,'.',','); ?></div></td>
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

			$ipage = $res73['age'];
			
			
			$query74 = "select * from master_ippackage where auto_number='$packageanum'";
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
					$quantity_bedt=$quantity1 = $interval->format("%a");
					if($packdays1>$quantity1)
					{
						$quantity1=$quantity1-$packdays1; 
						$packdays1=$packdays1-$quantity_bedt;
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
										$charge1 = 'Sundries';
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
								
					  ?>
								<tr <?php echo $colorcode; ?>>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bedallocateddate; ?></div></td>
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
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($quantity*($rate)),2,'.',','); ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate*$fxrate,2,'.',','); ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount*$fxrate,2,'.',','); ?></div></td>
								</tr>              
					 
					   <?php 	} // if Qtantity !=0 close
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
										$charge1 = 'Sundries';
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
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($quantity*($rate)),2,'.',','); ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate*$fxrate,2,'.',','); ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount*$fxrate,2,'.',','); ?></div></td>
									</tr>              
						 
						   <?php 	} // if Qtantity !=0 close
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
			$totalpharm=0;
			$totalpharmuhx=0;
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' GROUP BY ipdocno,itemcode";
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
			$quantity=$res23['quantity'];
			$refno = $res23['ipdocno'];
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
			if($resquantity!=0){  
			$resamount=$resquantity*($pharate/$fxrate);
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
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($resquantity*($pharate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($pharate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($pharate*$resquantity),2,'.',','); ?></div></td>
                  
             <?php 		 } // if Qtantity !=0 close
         			}
			  }
			  }
			  ?>

			    <!-- Package processing all sections start  -->

			   <?php 

				$querypkg = "select package,package_process,packagecharge from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$execpkg = mysqli_query($GLOBALS["___mysqli_ston"], $querypkg) or die ("Error in Package Query".mysqli_error($GLOBALS["___mysqli_ston"]));
			$respkg = mysqli_fetch_array($execpkg);
			$packageid=$respkg['package']; 
			$packagecharge=$respkg['packagecharge'];
			
			$qrypackage = "select servicesitem,rate,servicescode from master_ippackage where auto_number = '$packageid'";
			$execpackage = mysqli_query($GLOBALS["___mysqli_ston"], $qrypackage);
			$respackage = mysqli_fetch_array($execpackage);
			$package_amt = $packagecharge;
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

				/* $qrylab2 = "select sum(amount) as totolamt from package_processing where package_id = '$packageid' and package_item_type IN('SI','LI','MI','RI','CT') and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> ''";
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
						$issqry1 = "select sum(qty) issuedqty from package_execution where processing_id='$rowid'";
						$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$resiss1 = mysqli_fetch_array($execiss1);
						$issuedqty = $resiss1['issuedqty'];
						if($pack_item_type == 'SI' || $pack_item_type == 'MI' )
						$used_amount = $issuedqty * $itemrate;
					
						else
						$used_amount = $itemrate;

						if($pack_item_type == 'MI' )
						{
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
							<input type="hidden" name="privatedoctorquantitypkg[]"  value="1">
							<input type="hidden" name="doccoapkg[]" id="doccoa" value="">
							<input name="privatedoctorrowidpkg[]" type="hidden" size="25" value="<?php echo $rowid; ?>">

							<input type="hidden" name="privatedoctorrateuhxpkg[]" id="privatedoctorrateuhx" value="<?php echo $itemrate; ?>">
							<input type="hidden" name="privatedoctoramountuhx[]" id="privatedoctoramountuhx" value="<?php echo $itemrate; ?>">
				  			<?php 
						} ?>
						
					<?php }

				}

			    ?>
				<input type="hidden" name="mis_amt_service" id="mis_amt_service" value="<?php echo $mis_amt_service;?>">
			    <!-- Package processing all sections end -->
			  <?php 
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
			
			if(strtoupper($labfree) == 'NO')
			{
			$queryl51 = "select rateperunit from `$labtable` where itemcode='$labcode'";
			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($labrate*$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($labrate*$fxrate),2,'.',','); ?></div></td>
                  
             <?php }
			  }
			  ?>
			  
			    <?php 
				$totalrad=0;
				$totalraduhx=0;
			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($radrate*$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($radrate*$fxrate),2,'.',','); ?></div></td>
                  
             <?php }
			  }
			  ?>	  	    <?php 
					
					$totalser=0;
					$totalseruhx=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' group by servicesitemcode,iptestdocno";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
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

			$serperc = "select ipservice_percentage from master_doctor where doctorcode = '$servicesdoctorcode'";		
			$execserperc = mysqli_query($GLOBALS["___mysqli_ston"], $serperc) or die("Error in SerPerc".mysqli_error($GLOBALS["___mysqli_ston"]));		
			$resserperc = mysqli_fetch_array($execserperc);		
			$ipserpercentage = $resserperc['ipservice_percentage'];

			$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";
			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress51 = mysqli_fetch_array($execs51);
			$serrate = $ress51['rateperunit'];
			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername." - ".$servicesdoctorname; ?></div></td>
              <input type="hidden" name="serviceledgcode[]" id="serviceledgcode" value="<?= $serviceledgercode ?>">
             <input type="hidden" name="serviceledgname[]" id="serviceledgname" value="<?= $serviceledgername ?>">
			 <input type="hidden" name="servicedoctorcode[]" id="servicedoctorcode" value="<?= $servicesdoctorcode ?>">
             <input type="hidden" name="servicedoctorname[]" id="servicedoctorname" value="<?= $servicesdoctorname ?>">

             <input name="servicesitemcode[]" type="hidden" id="servicesitemcode" size="69" value="<?php echo $sercode; ?>">

             <?php $sharingamt = $totserrate * ($ipserpercentage/100); ?>		
             <input type="hidden" name="ipserpercentage[]" id="ipserpercentage" value="<?= $ipserpercentage ?>">		
          	 <input type="hidden" name="sharingamt[]" id="sharingamt" value="<?= $sharingamt ?>">
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $totserrate; ?>">
			 <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $serqty; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
             
             <input name="rate3uhx[]" type="hidden" id="rate3uhx" readonly size="8" value="<?php echo ($totserrate*$fxrate); ?>">
             
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($totserrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($serrate*$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format((($totserrate*$fxrate)),2,'.',','); ?></div></td>
                  
             <?php 	 } // if Qtantity !=0 close
         		}
			  }
			  ?>
			<?php
			$totalotbillingamount = 0;
			$totalotbillingamountuhx=0;
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
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format((1*($otbillingrate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($otbillingrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($otbillingrate*1),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
				<?php
			$totalprivatedoctoramount = 0;
			$totalprivatedoctoramountuhx=0;
			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg = '1'";
			$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$privatedoctoramount = $privatedoctorunit*($privatedoctorrate/$fxrate);
			$pvtdrsharingamt = $privatedoctoramount * ($sharingperc/100);
			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
			
			 $privatedoctoramountuhx = $privatedoctorrate*$privatedoctorunit;
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
			 <input type="hidden" name="doccoa[]" id="doccoa" value="<?php echo $doccoa; ?>">

             <input type="hidden" name="pvtdrpercentage[]" id="pvtdrpercentage" value="<?php echo $sharingperc; ?>">		
			 <input type="hidden" name="pvtdrsharingamt[]" id="pvtdrsharingamt" value="<?php echo $pvtdrsharingamt; ?>">

              <input type="hidden" name="privatedoctorrateuhx[]" id="privatedoctorrateuhx" value="<?php echo $privatedoctorrate; ?>">
			 <input type="hidden" name="privatedoctoramountuhx[]" id="privatedoctoramountuhx" value="<?php echo $privatedoctorrate*$privatedoctorunit; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctorunit; ?></div></td>
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($privatedoctorrate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($privatedoctorunit*($privatedoctorrate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($privatedoctorrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($privatedoctorrate*$privatedoctorunit),2,'.',','); ?></div></td>
             </tr>
				<?php
				} 
				?>
				<?php
			$totalambulanceamount = 0;
			$totalambulanceamountuhx=0;
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
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($ambulanceunit*($ambulancerate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($ambulancerate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($ambulancerate*$ambulanceunit),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
				<?php
			$totalmiscbillingamount = 0;
			$totalmiscbillingamountuhx=0;
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
	
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingunit; ?></div></td>
             
              <input type="hidden" name="miscbillingrateuhx[]" id="miscbillingrateuhx" value="<?php echo $miscbillingrate; ?>">
			 <input type="hidden" name="miscbillingamountuhx[]" id="miscbillingamountuhx" value="<?php echo $miscbillingrate*$miscbillingunit; ?>">

			  <input type="hidden" name="ledname[]" id="ledname" value="<?php echo $ledname; ?>">
			 <input type="hidden" name="ledid[]" id="ledid" value="<?php echo $ledid; ?>">
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($miscbillingrate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($miscbillingunit*($miscbillingrate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($miscbillingrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($miscbillingrate*$miscbillingunit),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
				<?php
			$totaldiscountamount = 0;
			$totaldiscountamountuhx=0;
			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format((1*($discountrate1/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($discountrate1),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($discountrate1*1),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
						<?php
			$totalnhifamount = 0;
			$totalnhifamountuhx=0;
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
			$nhifclaim = $nhifqty*($nhifrate/$fxrate);
			$totalnhifamount = $totalnhifamount + $nhifclaim;
			
			 $nhifclaimuhx = $nhifrate*$nhifqty;
		   $totalnhifamountuhx = $totalnhifamountuhx + $nhifclaimuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo 'NHIF'; ?></div></td>
			 	
			 	 <input type="hidden" name="nhifrate[]" id="nhifrate" value="<?php echo $nhifrate/$fxrate; ?>">
			 <input type="hidden" name="nhifamount[]" id="nhifamount" value="<?php echo $nhifclaim; ?>">
			 <input type="hidden" name="nhifquantity[]" id="nhifquantity" value="<?php echo $nhifqty; ?>">
             
              <input type="hidden" name="nhifrateuhx[]" id="nhifrateuhx" value="<?php echo $nhifrate; ?>">
			 <input type="hidden" name="nhifamountuhx[]" id="nhifamountuhx" value="<?php echo $nhifrate*$nhifqty; ?>">
	
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifqty; ?></div></td>
                 
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($nhifrate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($nhifqty*($nhifrate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($nhifrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($nhifrate*$nhifqty),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
			<?php
			$totaldepositamount = 0;
			$totaldepositamountuhx=0;
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
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'. number_format((1*($depositamount/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.  number_format(($depositamount),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'. number_format(($depositamount*1),2,'.',','); ?></div></td>
                  
                  
             <?php }
			 $totaladvancedepositamount = 0;
			$totaladvancedepositamountuhx=0;
			$query112 = "select * from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$advancedepositamount = $res112['transactionamount'];
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
			$advancedepositamount = 1*($advancedepositamount/$fxrate);
			$totaldepositamount += $advancedepositamount;
			
			 $advancedepositamountuhx = $advancedepositamount;
		   $totaldepositamountuhx = $totaldepositamountuhx + $advancedepositamountuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Advance Deposit'; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($advancedepositamount/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format((1*($advancedepositamount/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($advancedepositamount),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($advancedepositamount*1),2,'.',','); ?></div></td>
                  
             <?php 
			  }
			  ?>
			  		  <?php
			$totaldepositrefundamount = 0;
			$totaldepositrefundamountuhx=0;
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
			$depositrefundamount = 1*($depositrefundamount/$fxrate);
			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			
			 $depositrefundamountuhx = $depositrefundamount;
		   $totaldepositrefundamountuhx = $totaldepositrefundamountuhx + $depositrefundamountuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Deposit Refund'; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($depositrefundamount/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format((1*($depositrefundamount/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($depositrefundamount),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($depositrefundamount*1),2,'.',','); ?></div></td>
                  
             <?php 
			  }
			  ?>
              
              <!--for package doctor-->
              
              
               <?php /*?><?php
			   if($res2package!=0)
			   {
			$totalprivatedoctorbill = 0;
			$query112 = "select * from privatedoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
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
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($privatedoctorbill,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($privatedoctorbill,2,'.',','); ?></div></td>
			    
			  
			  <?php 
			  }
			  ?>
              <?php
			   
			$totalresidentdoctorbill = 0;
			$query112 = "select * from residentdoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
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
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($residentdoctorbill,2,'.',','); ?></div></td>
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
			   
			   /*
			     $overalltotaluhx=($totalopuhx+$totalbedtransferamountuhx+$totalbedallocationamountuhx+$totallabuhx+$totalpharmuhx+$totalraduhx+$totalseruhx+$packageamountuhx+$totalotbillingamountuhx+$totalprivatedoctoramountuhx+$totalambulanceamountuhx+$totaldiscountamountuhx+$totalmiscbillingamountuhx-$totaldepositamountuhx+$totalnhifamountuhx);
			  $overalltotaluhx=number_format($overalltotaluhx,2,'.','');
			  $consultationtotauhxl=$totalopuhx;
			   $consultationtotaluhx=number_format($consultationtotal,2,'.','');
			   $netpayuhx= $consultationtotaluhx+$totallabuhx+$totalpharmuhx+$totalraduhx+$totalseruhx;
			   $netpayuhx=number_format($netpayuhx,2,'.','');*/
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
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5" colspan="1"><strong></strong></td>
			 </tr>
             
             <tr>
	  <td colspan="7" class="bodytext31" align="right"><strong> Grand Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
	     <td class="bodytext31" align="center">&nbsp;</td><input type="hidden" name="grandtotal" id="grandtotal" value="<?php echo $overalltotal; ?>">
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td width="10%" align="center" class="bodytext31">&nbsp;</td>
		</tr>
		<tr>
		<?php  $overalltotal = round($overalltotal); ?>
	  <td colspan="7" class="bodytext31" align="right"><strong> Net Payable&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
	   <input type="hidden" name="netpayable" id="netpayable" value="<?php echo $overalltotal; ?>">
       
        <input type="hidden" name="netpayableuhx" id="netpayableuhx" value="<?php echo $overalltotaluhx; ?>">
         <input type="hidden" name="curtype" id="curtype" value="<?php echo $currency; ?>">
         <input type="hidden" name="fxrate" id="fxrate" value="<?php echo $fxrate; ?>">
         
         
	    <input type="hidden" name="totalrevenue" value="<?php echo $totalrevenue; ?>">
	   <input type="hidden" name="discount" value="<?php echo $positivetotaldiscountamount; ?>">
	   <input type="hidden" name="deposit" value="<?php echo $positivetotaldepositamount; ?>">
	    <input type="hidden" name="nhif" value="<?php echo $positivetotalnhifamount; ?>">
        <td colspan="2" class="bodytext31" align="left"><div align="right"><strong> Net Payable&nbsp; :<?php echo number_format($overalltotaluhx,2,'.',','); ?></strong></div></td>
	   <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			if($account1name =='CASH')
			{
			$cashamount = $account1amount;
			}
			if($account2name =='CASH')
			{
			$cashamount = $account2amount;
			}
			if($account3name =='CASH')
			{
			$cashamount = $account3amount;
			}
			
			?>
			 <input type="hidden" name="netcashpayable" id="netcashpayable" value="<?php echo $cashamount; ?>">
			<?php } ?>
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td width="10%" align="center" class="bodytext31">&nbsp;</td>
		 <td width="12%" align="center" class="bodytext31">&nbsp;</td>
		</tr>
          </tbody>
        </table>		</td>
	</tr>
	
	<tr>
			<td class="bodytext31" align="center">&nbsp;</td>
			<td class="bodytext31" align="center">&nbsp;</td>
	  <td colspan="4">
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
		  <tr>
			<td width="25%" align="center" class="bodytext31"> Account</td>
			 
	
			<td width="12%" align="center" class="bodytext31">Amount</td>
		    <td width="16%" align="center" class="bodytext31"><?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>Cash<?php } ?></td>
		    <td width="17%" align="center" class="bodytext31">
			<?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			<input type="text" name="cash" id="cash" size="10" onKeyUp="return balancecalc();">
			<?php } ?>			</td>
			<td width="17%" align="center" class="bodytext31"></td>
			<td width="17%" align="right" class="bodytext31">
			<?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			Balance
			<?php } ?></td>
			<td width="17%" align="center" class="bodytext31">
			<?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			<input type="text" name="balance" id="balance" size="8" class="bal" readonly>
			<?php } ?>			</td>
            
           
		  </tr>
			<tr>
			<td align="right" class="bodytext31"><input name="accountname" type="text" id="accountname" value="<?php if($account1amount == '') { echo ''; }else { echo $account1name; } ?>" size="32" autocomplete="off" readonly>
			<input name="accountnameid" type="hidden" id="accountnameid" value="<?php echo $account1nameid; ?>" size="32" autocomplete="off" readonly>
			<input name="accountnameano" type="hidden" id="accountnameano" value="<?php echo $account1nameano; ?>" size="32" autocomplete="off" readonly>
			</td>
			 <td class="bodytext31" align="center"><input type="text" id="amount1" name="amount1" size="10" onKeyUp="return balancecalc('1')" value="<?php echo $account1amount; ?>" readonly></td>
			 <td class="bodytext31" align="center">
			 <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			Cheque
			<?php } ?>			 </td>
			 <td class="bodytext31" align="center">
			 <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			<input type="text" name="cheque" id="cheque" size="10" onKeyUp="return balancecalc();">
			<?php
			}
			?>			 </td>
			 <td width="12%" align="center" class="bodytext31" id="chequenumber"><strong>Cheque No</strong></td>
	     <td width="10%" align="center" class="bodytext31"><input type="text" name="chequenumber1" id="chequenumber1" size="10"></td>
		 <td width="8%" align="right" class="bodytext31">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right"><input name="accountname2" type="text" id="accountname2" value="<?php if($account2amount == '') { echo ''; }else { echo $account2name; } ?>" size="32" autocomplete="off" readonly>
			<input name="accountnameid2" type="hidden" id="accountnameid2" value="<?php echo $account2nameid; ?>" size="32" autocomplete="off" readonly>
			<input name="accountnameano2" type="hidden" id="accountnameano2" value="<?php echo $account2nameano; ?>" size="32" autocomplete="off" readonly></td>
			 <td class="bodytext31" align="center"><input type="text" id="amount2" name="amount2" size="10" onKeyUp="return balancecalc('2')" value="<?php echo $account2amount; ?>" readonly></td>
		 <td class="bodytext31" align="center">
		 <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			Online
			<?php } ?>		 </td>
			 <td class="bodytext31" align="center">
			  <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			<input type="text" name="online" id="online" size="10" onKeyUp="return balancecalc();">
			<?php } ?>			 </td>
		 <td class="bodytext31" align="center" id="onlinenumber"><strong>Online No</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="onlinenumber1" id="onlinenumber1" size="10"></td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right"><input name="accountname3" type="text" id="accountname3" value="<?php if($account3amount == '') { echo ''; }else { echo $account3name; } ?>" size="32" autocomplete="off" readonly>
			<input name="accountnameid3" type="hidden" id="accountnameid3" value="<?php echo $account3nameid; ?>" size="32" autocomplete="off" readonly>
			<input name="accountnameano3" type="hidden" id="accountnameano3" value="<?php echo $account3nameano; ?>" size="32" autocomplete="off" readonly></td>
			 <td class="bodytext31" align="center"><input type="text" id="amount3" name="amount3" size="10" onKeyUp="return balancecalc('3')" value="<?php echo $account3amount; ?>" readonly></td>
			 <td class="bodytext31" align="center">
			 <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			Credit Card
			
			<?php
			} ?>			 </td>
			 <td class="bodytext31" align="center">
			  <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			<input type="text" name="creditcard" id="creditcard" size="10" onKeyUp="return balancecalc();">
			<?php } ?>			 </td>
			 <td class="bodytext31" align="center" id="creditcardnumber"><strong> Card No</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="creditcardnumber1" id="creditcardnumber1" size="10"></td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			
			<tr>
			<td class="bodytext31" align="right"><input name="accountname4" type="text" id="accountname4" value="<?php if($account4amount == '') { echo ''; }else { echo $account4name; } ?>" size="32" autocomplete="off" readonly>
			<input name="accountnameid4" type="hidden" id="accountnameid4" value="<?php echo $account4nameid; ?>" size="32" autocomplete="off" readonly>
			<input name="accountnameano4" type="hidden" id="accountnameano4" value="<?php echo $account4nameano; ?>" size="32" autocomplete="off" readonly></td>
			 <td class="bodytext31" align="center"><input type="text" id="amount4" name="amount4" size="10" onKeyUp="return balancecalc('4')" value="<?php echo $account4amount; ?>" readonly></td>
             
              <td align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3" colspan="3">Slade Authentication No</td>
            <td align="left" valign="middle" bgcolor="#ecf0f5"><input name="savannah_authid" id="savannah_authid" value="<?php echo $savannah_authid;?>" size="20"><input name="savannah_authflag" id="savannah_authflag" value="" size="20" type="hidden">
            <input type="hidden" id="patientfirstname" name="patientfirstname" value="<?= $patientfirstname?>">	
            <input type="hidden" id="patientlastname" name="patientlastname" value="<?= $patientlastname?>"></td>
			 </tr>
			<tr>
			<td class="bodytext31" align="right">&nbsp;</td>
			 <td class="bodytext31" align="center"></td>
			 <td class="bodytext31" align="center">
			 <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			MPESA
			<?php } ?>			 </td>
			 <td class="bodytext31" align="center">
			 <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			<input type="text" name="mpesa" id="mpesa" size="10" onKeyUp="return balancecalc();">
			<?php } ?></td>
		 <td class="bodytext31" align="center" id="mpesanumber"><strong>MPESA No</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="mpesanumber1" id="mpesanumber1" size="10"></td>
			 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			</tbody>
			</table>	  </td>
			</tr>
			
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td width="10%" class="bodytext31" align="left">Approval Comments</td>
		  <td width="10%" class="bodytext31" align="left"><textarea name="approvalcomments" id="approvalcomments"><?php echo $approvalcomments; ?></textarea></td>
	      <td width="12%" class="bodytext31" align="center"><strong>User Name</strong></td>
          <td width="8%" class="bodytext31" align="left"><?php echo $username; ?></td>
        <td width="1%"><input type="text" name="availablelimite" id="availablelimit" value="<?php echo $availablelimit; ?>"  readonly ></td>
		<td width="21%" align="center" valign="center" class="bodytext311"> <strong>Pre Auth Code</strong> 
		<input type="text" name="preauthcode" id="preauthcode"  size="10" autocomplete="off">
        <input type='hidden' name='slade_claim_id' id='slade_claim_id' value=''>
        <input type="hidden" name="offpatient" id="offpatient" value="<?php echo $offpatient; ?>">

<input type="hidden" name="authorization_code" id="authorization_code" value=""></td>

		<td>
		 <?php
		 if($slade_payer_code!='')
		 {
			 $slade_key_provider=$account1nameid;
			 $payer_code=$slade_payer_code;
		 }
		 else if($slade_payer_code1!='')
		 {
			  $slade_key_provider=$account2nameid;
			  $payer_code=$slade_payer_code1;
		 }
		  else if($slade_payer_code2!='')
		 {
			  $slade_key_provider=$account3nameid;
			  $payer_code=$slade_payer_code2;
		 }
		 if($eclaim_id=='3') { $allowsmart=3;?>
				  <input name="fetch" type="button" value="SMART+Slade"  id="fetch" style="height:40px; width:120px; background-color:#FFCC00;" onClick="funfetchsavannah('<?php echo $eclaim_id; ?>');" />
		 <?php } 
		 else if($eclaim_id=='2') { $allowsmart=2;?>
				  <input name="fetch" type="button" value="Slade" id="fetch" style="height:40px; width:100px; background-color:#FFCC00;" onClick="funfetchsavannah('<?php echo $eclaim_id; ?>');" />
		 <?php } 
		  else if($eclaim_id=='1') { $allowsmart=1;?>
				  <input name="fetch" type="button" value="SMART" id="fetch" style="height:40px; width:100px; background-color:#FFCC00;" onClick="funfetchsavannah('<?php echo $eclaim_id; ?>');" />
		 <?php } 
		 /*else if($slade_payer_code!='' || $slade_payer_code1!='' || $slade_payer_code2!=''){ $allowsmart=2;?>
				  <input name="fetch" type="button" value="Slade" id="fetch" style="height:40px; width:100px; background-color:#FFCC00;" onClick="funfetchsavannah('<?php echo '2'; ?>');" />
		 <?php } 
		 else if($allowsmart==1){ ?>
				  <input name="fetch" type="button" value="SMART" id="fetch" style="height:40px; width:100px; background-color:#FFCC00;" onClick="funfetchsavannah('<?php echo $allowsmart; ?>');" />
		 <?php }*/ ?>
		</td>
      </tr>
     
	  
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td colspan="4">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="21%" align="left" valign="center" class="bodytext311">         
         <input type="hidden" name="frm1submit1" value="frm1submit1" />
          <input type='hidden' name='slade_key_provider' id='slade_key_provider' value='<?php echo $slade_key_provider;?>'>
          <input type='hidden' name='payer_code' id='payer_code' value='<?php echo $payer_code;?>'>
		 <input type='hidden' name='key_provider' id='key_provider' value='<?php echo $key_provider;?>'>
		 <input type='hidden' name='eclaim' id='eclaim' value='<?php echo $eclaim_id;?>'>
          <input type='hidden' name='slade_balres' id='slade_balres' value='<?php echo $slade_balres;?>'>
		  <?php if($eclaim_id==1 || $eclaim_id==3  || $eclaim_id==2){?>
<input name="Submit222" id="submit" type="submit" value="Save and Post" class="button" disabled  style="height:40px; width:120px;"/>
		 <?php } else{?>
		<input name="Submit222" id="submit" type="submit" value="Save Bill" class="button" style="height:40px; width:120px;"/>	
		 <?php }?>		
		
		</td>
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

<?php 

function getsubtypeinfo($accountid)
{
	$data = array();
	$data['subtypename'] = "";
	$data['subtypeid'] = "0";
	if(trim($accountid) !='')
		{
			$query23 = "select  subtype from master_accountname  where id='$accountid'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23);
			$subtypeid = $res23["subtype"]; 
			if($subtypeid)
			{
				$query233 = "select  subtype from master_subtype  where auto_number='$subtypeid'";
				$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res233 = mysqli_fetch_array($exec233);
				$subtypename = $res233["subtype"]; 
				$data['subtypename'] = $subtypename;
			}
			$data['subtypeid'] = $subtypeid;
			

		}
		return $data;
}


 ?>
