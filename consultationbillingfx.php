<?php
session_start();
ob_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("residental_doctor_func.php");
include ("includes/check_user_access.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$errmsg = 0;
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
 
$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
//	$balanceamt = $_REQUEST["balanceamt"];

visitcreate:
	$patientcode = $_REQUEST["customercode"];
	$visitcode = $_REQUEST["visitcode"];
	$patientname = $_REQUEST['customername'];
	$patientfirstname = $_REQUEST['patientfirstname'];
	$patientmiddlename=$_REQUEST['patientmiddlename'];
	$patientlastname = $_REQUEST["patientlastname"];
	$patientname = $patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
	$locationcode = $_REQUEST['locationcode'];
	$locationname = $_REQUEST['locationname'];
	$visittype = $_REQUEST['visittype'];
	$copay_forcecheck = $_REQUEST['copay_forcecheck'];
	$copay_forcebillstatus='';
	if($copay_forcecheck=='1'){
	$copay_forcebillstatus='completed';
	}
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$consultationprefix = $res3['consultationprefix'];
$query2 = "select billno as billnumber from cf_billno order by id desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
if ($billnumber == '')
{
	$billnumbercode =$consultationprefix.'1'."-".date('y');
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber, 3, 8);
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $consultationprefix.$maxanum."-".date('y');
	$openingbalance = '0.00';
	//echo $companycode;
}

    $query56="insert into cf_billno (billno) values ('$billnumbercode')"; 
	$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) ;
	if( mysqli_errno($GLOBALS["___mysqli_ston"]) == 1062) {
	   goto visitcreate;
	}
	else if(mysqli_errno($GLOBALS["___mysqli_ston"]) > 0){
	   die ("Error in query56".mysqli_error($GLOBALS["___mysqli_ston"]));
	}

	//echo $billnumbercode;
	$consultationtype = $_REQUEST["consultationtype"];
	$chequenumber = $_REQUEST['chequenumber'];
		$chequedate = $_REQUEST['chequedate'];
		$bankname = $_REQUEST['chequebank'];
		$bankbranch = $_REQUEST['bankbranch'];
		$card = $_REQUEST['cardname'];
		$cardnumber = $_REQUEST['cardnumber'];
		$bankname1 = $_REQUEST['bankname'];
	$billingdatetime  = $_REQUEST["ADate"];

	$consultingdoctor = $_REQUEST["consultingdoctor"];
	$accountname = $_REQUEST["account"];
	$accountcode = $_REQUEST["accountcode"];
	$accountnameano = $_REQUEST["accountnameano"];
	
	$paymenttype = $_REQUEST["paymenttype"];
	$subtype = $_REQUEST["subtype"];
	$planname = $_REQUEST["planname"];
	$fixedamountbalance = $_REQUEST["fixedamountbalance"];
	$patientbilltype = $_REQUEST['patientbilltype'];
	$billtype = $_REQUEST['billtype'];
	$billamount  = $_REQUEST["billamount"];
	
	$billentryby = $_REQUEST["billentryby"];
	
	$patientpaymentmode = $_REQUEST['patientpaymentmode'];
	$patientbillamount = $_REQUEST['patientbillamount'];
	$department = $_REQUEST['department'];
	
	$consultationdate = $_REQUEST['ADate'];
	
	$consultationfees = $_REQUEST['consultationfees'];
	
	
	$subtotalamount = $_REQUEST['subtotal'];
	$copayfixedamount = $_REQUEST['copayfixedamount'];
	$copaypercentageamount = $_REQUEST['copaypercentageamount'];
	$totalamountbeforediscount = $_REQUEST['totalamountbeforediscount'];
	$discountamount = $_REQUEST['totaldiscountamountonlyapply1'];
	$totalamount = $_REQUEST['totalamount'];
	$cashgivenbycustomer = $_REQUEST['cashgivenbycustomer'];
	$cashgiventocustomer = $_REQUEST['cashgiventocustomer'];
	$cashamount = $_REQUEST['cashamount'];
	$onlineamount = $_REQUEST['onlineamount'];
	$chequeamount = $_REQUEST['chequeamount'];
	$cardamount = $_REQUEST['cardamount'];
	$creditamount = $_REQUEST['creditamount'];
	$consultationcoa = $_REQUEST['consultationcoa'];
	$copaycoa = $_REQUEST['copaycoa'];
	$cashcoa = $_REQUEST['cashcoa'];
	$chequecoa = $_REQUEST['chequecoa'];
	$cardcoa = $_REQUEST['cardcoa'];
	$mpesacoa = $_REQUEST['mpesacoa'];
	$onlinecoa = $_REQUEST['onlinecoa'];

	$sharingamount = $_REQUEST['sharingamt'];
	$conspercentage = $_REQUEST['conspercentage'];

	$doctorcode = $_REQUEST['doctorcode'];

	//residental doctor

	$rsltr_sharing= resident_doctor_sharing($doctorcode,$billingdatetime,$totalamount);

     $is_resdoc=$rsltr_sharing['is_resident'];
	 if($is_resdoc==1){
	 $sharingamount=$rsltr_sharing['sharing_amt'];
	 $conspercentage=$rsltr_sharing['sharing_per'];
     }
   /// residental doctor

	$mpesanumber = $_REQUEST['mpesanumber'];
	
	$recordstatus = '';
	$copay = '';
	
	 $query2 = "select * from master_billing where billnumber = '$billnumbercode'";
	 $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
     $res2 = mysqli_num_rows($exec2);
	 
	 
	
	if ($res2 == 0)
	{
	 $query291 = "select * from master_billing where visitcode='$visitcode' and consultationtype='$consultationtype' and department='$department'";
	 $exec291 = mysqli_query($GLOBALS["___mysqli_ston"], $query291) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	  $num291 = mysqli_num_rows($exec291);
	
	if($num291 >= 0)
	{
	if($copayfixedamount != '')
	{
	$copay = $copayfixedamount;
	}
	if($copaypercentageamount != '')
	{
	$copay = $copaypercentageamount;
	}
	
	
	
		$transactionmode = $patientpaymentmode;
		if ($transactionmode == 'TDS')
		{
			$transactiontype = 'TDS';
		}
		else
		{
			$transactiontype = 'PAYMENT';
		}
		$transactionmodule = 'PAYMENT';
		
		echo '<br/><br/><br/>';
		
		if ($billtype == 'CASH')
		{ //echo "in";
			//echo $_REQUEST['currency'];
			$cashtakenfromcustomer=$cashgivenbycustomer-$cashgiventocustomer;
			if($cashtakenfromcustomer=='' || $cashtakenfromcustomer=='0' || $cashtakenfromcustomer=='0.00'){
				$cashtakenfromcustomer=$totalamount;
			}
			foreach($_REQUEST['currency'] as $key=>$value)
			{
				//echo $key,',',$value;
				$currencyamt= $_REQUEST['currencyamt'][$key];
				$fxamount= $_REQUEST['fxamount'][$key];
				$ledgercode=$_REQUEST['ledgercode'][$key];
				$ledgername=$_REQUEST['ledgername'][$key];
				$amounttot=$_REQUEST['amounttot'][$key];
				$currencyname=$_REQUEST['currency'][$key];
			//echo "<br/>";
				
			//	echo "in";
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		$particulars = 'BY CASH'.$billnumberprefix.$billnumber.'';	
	//echo '<br>';
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
	 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
	 $res55 = mysqli_fetch_array($exec55);
	 $cashcode = $res55['ledgercode'];
		
	    $queryforex = "insert into forex_billing (patientfirstname,patientmiddlename, patientlastname,patientcode, visitcode, billnumber,
		 billingdatetime, billentryby,ipaddress, username, recordstatus,patientfullname,currency,currencyrate,currencyqty,currencytotal,billtype,patienttype,locationname,locationcode) 
		values('$patientfirstname','$patientmiddlename','$patientlastname','$patientcode','$visitcode','$billnumbercode', '$billingdatetime', '$billentryby',  '$ipaddress','$username','$recordstatus','$patientname','".$currencyname."','".$currencyamt."','".$fxamount."','".$amounttot."','".$billtype."','".$paymenttype."','$locationname','$locationcode')";
		$execforex = mysqli_query($GLOBALS["___mysqli_ston"], $queryforex) or die ("Error in Queryforex".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo '<br>';
		}
		$query1 = "insert into master_billing (patientfirstname,patientmiddlename, patientlastname,patientcode, visitcode, billnumber,
		consultationtype, billingdatetime, consultingdoctor,accountname,paymenttype,subtype,planname,
		billtype,billamount,billentryby,ipaddress, username, recordstatus,paymentstatus,patientbillamount,patientpaymentmode,department,consultationdate,
		consultationfees, subtotalamount, copayfixedamount, copaypercentageamount, totalamountbeforediscount, discountamount, totalamount,triagestatus,particulars,transactionmode, transactiontype,cashamount,transactionmodule,consultationtime,patientfullname,cashgivenbycustomer,cashgiventocustomer,locationname,locationcode) 
		values('$patientfirstname','$patientmiddlename','$patientlastname','$patientcode','$visitcode','$billnumbercode','$consultationtype', '$billingdatetime','$consultingdoctor','$accountname','$paymenttype','$subtype','$planname',
		'$patientbilltype','$billamount', '$billentryby',  '$ipaddress','$username','$recordstatus','completed','$patientbillamount','$patientpaymentmode','$department','$consultationdate',
		'$consultationfees','$subtotalamount', '$copayfixedamount', '$copaypercentageamount', '$totalamountbeforediscount', '$discountamount', '$totalamount','pending','$particulars','$transactionmode','$transactiontype','".$cashtakenfromcustomer."','$transactionmodule','$timeonly','$patientname','$cashgivenbycustomer','$cashgiventocustomer','$locationname','$locationcode')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		//$idlast = mysql_insert_id($query1) ;
		
		/*$query32 = "UPDATE master_billing SET cashgiventocustomer='".$cashgiventocustomer."' WHERE auto_number='".$idlast."'";
		$exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());*/
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumbercode','$dateonly','$ipaddress','$username','$totalamount','$cashcoa','consultationbilling','$locationname','$locationcode')";
       $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$query22 = "insert into billing_consultation(billdate,patientcode,patientname,patientvisitcode,consultation,consultationcoa,copay,copaycoa,accountname,billnumber,ipaddress,transactionmode,transactionamount,cashamount,username,billtype,locationname,locationcode,cashcode,doctorcode,doctorname,consultation_percentage,sharingamount,visittype,is_resdoc)
values('$consultationdate','$patientcode','$patientname','$visitcode','$patientbillamount','$consultationcoa','$copay','$copaycoa','$accountname','$billnumbercode','$ipaddress','$transactionmode','$totalamount','$totalamount','$username','$patientbilltype','$locationname','$locationcode','$cashcode','$doctorcode','$consultingdoctor','$conspercentage','$sharingamount','$visittype','$is_resdoc')";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}		
		
		if ($billtype == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE'.$billnumberprefix.$billnumber.'';	
		
	$query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
		 
		$query1 = "insert into master_billing (patientfirstname,patientmiddlename, patientlastname,patientcode, visitcode, billnumber,
		consultationtype, billingdatetime, consultingdoctor,accountname,paymenttype,subtype,planname,
		billtype,billamount,billentryby,ipaddress, username, recordstatus,paymentstatus,patientbillamount,patientpaymentmode,department,consultationdate,
		consultationfees, subtotalamount, copayfixedamount, copaypercentageamount, totalamountbeforediscount, discountamount, totalamount,triagestatus,particulars,transactionmode, transactiontype,onlineamount,transactionmodule,consultationtime,patientfullname,cashgivenbycustomer,cashgiventocustomer,locationname,locationcode) 
		values('$patientfirstname','$patientmiddlename','$patientlastname','$patientcode','$visitcode','$billnumbercode','$consultationtype', '$billingdatetime','$consultingdoctor','$accountname','$paymenttype','$subtype','$planname',
		'$patientbilltype','$billamount', '$billentryby',  '$ipaddress','$username','$recordstatus','completed','$patientbillamount','$patientpaymentmode','$department','$consultationdate',
		'$consultationfees','$subtotalamount', '$copayfixedamount', '$copaypercentageamount', '$totalamountbeforediscount', '$discountamount', '$totalamount','pending','$particulars','$transactionmode','$transactiontype','$totalamount','$transactionmodule','$timeonly','$patientname','$cashgivenbycustomer','$cashgiventocustomer','$locationname','$locationcode')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumbercode','$dateonly','$ipaddress','$username','$totalamount','$onlinecoa','consultationbilling','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query22 = "insert into billing_consultation(billdate,patientcode,patientname,patientvisitcode,consultation,consultationcoa,copay,copaycoa,accountname,billnumber,ipaddress,transactionmode,transactionamount,onlineamount,onlinenumber,username,billtype,locationname,locationcode,bankcode,doctorcode,doctorname,consultation_percentage,sharingamount,visittype,is_resdoc)
values('$consultationdate','$patientcode','$patientname','$visitcode','$patientbillamount','$consultationcoa','$copay','$copaycoa','$accountname','$billnumbercode','$ipaddress','$transactionmode','$totalamount','$totalamount','$onlinenumber','$username','$patientbilltype','$locationname','$locationcode','$bankcode','$doctorcode','$consultingdoctor','$conspercentage','$sharingamount','$visittype','$is_resdoc')";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		if ($billtype == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE'.$billnumberprefix.$billnumber.'';	
		
	$query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode']; 
		 
		$query1 = "insert into master_billing (patientfirstname,patientmiddlename, patientlastname,patientcode, visitcode,billnumber,
		consultationtype, billingdatetime, consultingdoctor,accountname,paymenttype,subtype,planname,
		billtype,billamount,billentryby,ipaddress, username, recordstatus,paymentstatus,patientbillamount,patientpaymentmode,department,consultationdate,
		consultationfees, subtotalamount, copayfixedamount, copaypercentageamount, totalamountbeforediscount, discountamount, totalamount,triagestatus,chequeamount,chequenumber,chequedate,bankname,particulars,transactionmode,transactiontype,transactionmodule,consultationtime,patientfullname,cashgivenbycustomer,cashgiventocustomer,locationname,locationcode) 
		values('$patientfirstname','$patientmiddlename','$patientlastname','$patientcode','$visitcode','$billnumbercode','$consultationtype', '$billingdatetime','$consultingdoctor','$accountname','$paymenttype','$subtype','$planname',
		'$patientbilltype','$billamount', '$billentryby',  '$ipaddress','$username','$recordstatus','completed','$patientbillamount','$patientpaymentmode','$department','$consultationdate',
		'$consultationfees','$subtotalamount', '$copayfixedamount', '$copaypercentageamount', '$totalamountbeforediscount', '$discountamount', '$totalamount','pending','$totalamount','$chequenumber','$chequedate','$bankname','$particulars','$transactionmode','$transactiontype','$transactionmodule','$timeonly','$patientname','$cashgivenbycustomer','$cashgiventocustomer','$locationname','$locationcode')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumbercode','$dateonly','$ipaddress','$username','$totalamount','$chequecoa','consultationbilling','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query22 = "insert into billing_consultation(billdate,patientcode,patientname,patientvisitcode,consultation,consultationcoa,copay,copaycoa,accountname,billnumber,ipaddress,transactionmode,transactionamount,chequeamount,chequenumber,chequedate, bankname,username,billtype,locationname,locationcode,bankcode,doctorcode,doctorname,consultation_percentage,sharingamount,visittype,is_resdoc)
values('$consultationdate','$patientcode','$patientname','$visitcode','$patientbillamount','$consultationcoa','$copay','$copaycoa','$accountname','$billnumbercode','$ipaddress','$transactionmode','$totalamount','$totalamount','$chequenumber','$chequedate', '$bankname','$username','$patientbilltype','$locationname','$locationcode','$bankcode','$doctorcode','$consultingdoctor','$conspercentage','$sharingamount','$visittype','$is_resdoc')";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		if ($billtype == 'CREDIT CARD')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT CARD';
		$particulars = 'BY CREDIT CARD'.$billnumberprefix.$billnumber.'';	
	
	$query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
	
		$query1 = "insert into master_billing (patientfirstname,patientmiddlename, patientlastname,patientcode, visitcode,billnumber,
		consultationtype, billingdatetime, consultingdoctor,accountname,paymenttype,subtype,planname,
		billtype,billamount,billentryby,ipaddress, username, recordstatus,paymentstatus,patientbillamount,patientpaymentmode,department,consultationdate,
		consultationfees, subtotalamount, copayfixedamount, copaypercentageamount, totalamountbeforediscount, discountamount, totalamount,triagestatus,cardamount,creditcardname,creditcardnumber,creditcardbankname,particulars,transactionmode,transactiontype,transactionmodule,consultationtime,patientfullname,cashgivenbycustomer,cashgiventocustomer,locationname,locationcode) 
		values('$patientfirstname','$patientmiddlename','$patientlastname','$patientcode','$visitcode','$billnumbercode','$consultationtype', '$billingdatetime','$consultingdoctor','$accountname','$paymenttype','$subtype','$planname',
		'$patientbilltype','$billamount', '$billentryby',  '$ipaddress','$username','$recordstatus','completed','$patientbillamount','$patientpaymentmode','$department','$consultationdate',
		'$consultationfees','$subtotalamount', '$copayfixedamount', '$copaypercentageamount', '$totalamountbeforediscount', '$discountamount', '$totalamount','pending','$totalamount','$card','$cardnumber','$bankname1','$particulars','$transactionmode','$transactiontype','$transactionmodule','$timeonly','$patientname','$cashgivenbycustomer','$cashgiventocustomer','$locationname','$locationcode')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumbercode','$dateonly','$ipaddress','$username','$totalamount','$cardcoa','consultationbilling','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query22 = "insert into billing_consultation(billdate,patientcode,patientname,patientvisitcode,consultation,consultationcoa,copay,copaycoa,accountname,billnumber,ipaddress,transactionmode,transactionamount,cardamount,creditcardname,creditcardnumber,creditcardbankname,username,billtype,locationname,locationcode,bankcode,doctorcode,doctorname,consultation_percentage,sharingamount,visittype,is_resdoc)
values('$consultationdate','$patientcode','$patientname','$visitcode','$patientbillamount','$consultationcoa','$copay','$copaycoa','$accountname','$billnumbercode','$ipaddress','$transactionmode','$totalamount','$totalamount','$card','$cardnumber','$bankname1','$username','$patientbilltype','$locationname','$locationcode','$bankcode','$doctorcode','$consultingdoctor','$conspercentage','$sharingamount','$visittype','$is_resdoc')";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		if ($billtype == 'SPLIT')
		{	

			$transactiontype = 'PAYMENT';
			$transactionmode = 'SPLIT ';
			$particulars = 'BY SPLIT'.$billnumberprefix.$billnumber.'';	

			$adjustamount = $_REQUEST['adjustamount'];
			if (isset($_REQUEST["net_deposit_amt"])) 
			{ 
				$adv_dep_bal_amt = $_REQUEST["net_deposit_amt"]; 
			} 
			else 
			{ 
				$adv_dep_bal_amt = 0; 
			}
			$cashtakenfromcustomer=$cashgivenbycustomer-$cashgiventocustomer;
			foreach($_REQUEST['currency'] as $key=>$value)
			{
				//echo $key,',',$value;
				$currencyamt= $_REQUEST['currencyamt'][$key];
				$fxamount= $_REQUEST['fxamount'][$key];
				$ledgercode=$_REQUEST['ledgercode'][$key];
				$ledgername=$_REQUEST['ledgername'][$key];
				$amounttot=$_REQUEST['amounttot'][$key];
				$currencyname=$_REQUEST['currency'][$key];
				//echo "<br/>";
				
				//	echo "in";
				//echo '<br>';
		
		
				$queryforex = "insert into forex_billing (patientfirstname,patientmiddlename, patientlastname,patientcode, visitcode, billnumber,
				 billingdatetime, billentryby,ipaddress, username, recordstatus,patientfullname,currency,currencyrate,currencyqty,currencytotal,billtype,patienttype,locationname,locationcode) 
				values('$patientfirstname','$patientmiddlename','$patientlastname','$patientcode','$visitcode','$billnumbercode', '$billingdatetime', '$billentryby',  '$ipaddress','$username','$recordstatus','$patientname','".$currencyname."','".$currencyamt."','".$fxamount."','".$amounttot."','".$billtype."','".$paymenttype."','$locationname','$locationcode')";
				$execforex = mysqli_query($GLOBALS["___mysqli_ston"], $queryforex) or die ("Error in Queryforex".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo '<br>';
			}
		
		$query55 = "select * from financialaccount where transactionmode = 'SPLIT'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $cashcode = $res55['ledgercode'];
		  $bankcode = '';
		 
		 $mpesacode = '';
		 
		$query1 = "insert into master_billing (patientfirstname,patientmiddlename, patientlastname,patientcode, visitcode,billnumber,
		consultationtype, billingdatetime, consultingdoctor,accountname,paymenttype,subtype,planname,
		billtype,billamount,billentryby,ipaddress, username, recordstatus,paymentstatus,patientbillamount,patientpaymentmode,department,consultationdate,
		consultationfees, subtotalamount, copayfixedamount, copaypercentageamount, totalamountbeforediscount, discountamount, totalamount,triagestatus,cardamount,creditcardname,creditcardnumber,creditcardbankname,particulars,transactionmode,transactiontype,transactionmodule,consultationtime,patientfullname,cashgivenbycustomer,cashgiventocustomer,cashamount,onlineamount,chequeamount,chequenumber,creditamount,locationname,locationcode,mpesanumber,adjustamount) 
		values('$patientfirstname','$patientmiddlename','$patientlastname','$patientcode','$visitcode','$billnumbercode','$consultationtype', '$billingdatetime','$consultingdoctor','$accountname','$paymenttype','$subtype','$planname',
		'$patientbilltype','$billamount', '$billentryby',  '$ipaddress','$username','$recordstatus','completed','$patientbillamount','$patientpaymentmode','$department','$consultationdate',
		'$consultationfees','$subtotalamount', '$copayfixedamount', '$copaypercentageamount', '$totalamountbeforediscount', '$discountamount', '$totalamount','pending','$cardamount','$card','$cardnumber','$bankname1','$particulars','$transactionmode','$transactiontype','$transactionmodule','$timeonly','$patientname','$cashgivenbycustomer','$cashgiventocustomer','".$cashtakenfromcustomer."','$onlineamount','$chequeamount','$chequenumber','$creditamount','$locationname','$locationcode','$mpesanumber','$adjustamount')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		/*$query1 = "insert into master_billing (patientfirstname,patientmiddlename, patientlastname,patientcode, visitcode, billnumber,
		consultationtype, billingdatetime, consultingdoctor,accountname,paymenttype,subtype,planname,
		billtype,billamount,billentryby,ipaddress, username, recordstatus,paymentstatus,patientbillamount,patientpaymentmode,department,consultationdate,
		consultationfees, subtotalamount, copayfixedamount, copaypercentageamount, totalamountbeforediscount, discountamount, totalamount,triagestatus,particulars,transactionmode, transactiontype,cashamount,transactionmodule,consultationtime,patientfullname,cashgivenbycustomer,cashgiventocustomer,locationname,locationcode) 
		values('$patientfirstname','$patientmiddlename','$patientlastname','$patientcode','$visitcode','$billnumbercode','$consultationtype', '$billingdatetime','$consultingdoctor','$accountname','$paymenttype','$subtype','$planname',
		'$patientbilltype','$billamount', '$billentryby',  '$ipaddress','$username','$recordstatus','completed','$patientbillamount','$patientpaymentmode','$department','$consultationdate',
		'$consultationfees','$subtotalamount', '$copayfixedamount', '$copaypercentageamount', '$totalamountbeforediscount', '$discountamount', '$totalamount','pending','$particulars','$transactionmode','$transactiontype','".$cashtakenfromcustomer."','$transactionmodule','$timeonly','$patientname','$cashgivenbycustomer','$cashgiventocustomer','$locationname','$locationcode')";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());*/
		
		/*$query32 = "UPDATE master_billing SET cashgiventocustomer='".$cashgiventocustomer."' WHERE auto_number='".$idlast."'";
		$exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());*/
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,cash,cashcoa,cheque,chequecoa,online,onlinecoa,adjust,mpesa,mpesacoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumbercode','$dateonly','$ipaddress','$username','$cardamount','$cardcoa','$cashamount','$cashcoa','$chequeamount','$chequecoa','$onlineamount','$onlinecoa','$adjustamount','$creditamount','$mpesacoa','consultationbilling','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
$query22 = "insert into billing_consultation(billdate,patientcode,patientname,patientvisitcode,consultation,consultationcoa,copay,copaycoa,accountname,billnumber,ipaddress,transactionmode,transactionamount,cardamount,chequedate,bankname,cashamount,onlineamount,chequeamount,chequenumber,creditamount,onlinenumber,mpesanumber,creditcardnumber,locationname,locationcode,cashcode, bankcode, mpesacode,username,billtype,adjustamount,doctorcode,doctorname,consultation_percentage,sharingamount,visittype,is_resdoc)
values('$consultationdate','$patientcode','$patientname','$visitcode','$patientbillamount','$consultationcoa','$copay','$copaycoa','$accountname','$billnumbercode','$ipaddress','$transactionmode','$totalamount','$cardamount','$chequedate', '$bankname','".$cashtakenfromcustomer."','$onlineamount','$chequeamount','$chequenumber','$creditamount','$onlinenumber','$mpesanumber','$cardnumber','$locationname','$locationcode','$cashcode', '$bankcode', '$mpesacode','$username','$patientbilltype','$adjustamount','$doctorcode','$consultingdoctor','$conspercentage','$sharingamount','$visittype','$is_resdoc')";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		// Check if the patient has advance deposit amount
		 $query_dep = "select patientname,patientcode,sum(transactionamount) amt from master_transactionadvancedeposit where patientcode='$patientcode' group by patientcode";
		 $exec_dep = mysqli_query($GLOBALS["___mysqli_ston"], $query_dep) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		 $num_dep_rows = mysqli_num_rows($exec_dep);	
		 if($num_dep_rows)
		 {
			if($adjustamount > 0)
			{
				$query_adjust = "INSERT INTO `adjust_advdeposits` (`id`, `locationcode`, `patientcode`, `visitcode`, `billno`, `adjustamount`, `balamt`, `billdate`, `username`, `ipaddress`, `createdon`) VALUES (NULL, '$locationcode', '$patientcode', '$visitcode', '$billnumbercode', '$adjustamount', '$adv_dep_bal_amt', '$consultationdate', '$username', '$ipaddress', CURRENT_TIMESTAMP)";
				$exec_adjust = mysqli_query($GLOBALS["___mysqli_ston"], $query_adjust) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
	
	     }
		}
		
		if ($billtype == 'MPESA')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'MPESA';
		$particulars = 'BY MPESA'.$billnumberprefix.$billnumber.'';	
		
		$query552 = "select * from financialaccount where transactionmode = 'MPESA'";
		 $exec552 = mysqli_query($GLOBALS["___mysqli_ston"], $query552) or die ("Error in Query552".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res552 = mysqli_fetch_array($exec552);
		 $mpesacode = $res552['ledgercode'];
		
		$query1 = "insert into master_billing (patientfirstname,patientmiddlename, patientlastname,patientcode, visitcode, billnumber,
		consultationtype, billingdatetime, consultingdoctor,accountname,paymenttype,subtype,planname,
		billtype,billamount,billentryby,ipaddress, username, recordstatus,paymentstatus,patientbillamount,patientpaymentmode,department,consultationdate,
		consultationfees, subtotalamount, copayfixedamount, copaypercentageamount, totalamountbeforediscount, discountamount, totalamount,triagestatus,particulars,transactionmode, transactiontype,creditamount,transactionmodule,consultationtime,patientfullname,cashgivenbycustomer,cashgiventocustomer,locationname,locationcode,mpesanumber) 
		values('$patientfirstname','$patientmiddlename','$patientlastname','$patientcode','$visitcode','$billnumbercode','$consultationtype', '$billingdatetime','$consultingdoctor','$accountname','$paymenttype','$subtype','$planname',
		'$patientbilltype','$billamount', '$billentryby',  '$ipaddress','$username','$recordstatus','completed','$patientbillamount','$patientpaymentmode','$department','$consultationdate',
		'$consultationfees','$subtotalamount', '$copayfixedamount', '$copaypercentageamount', '$totalamountbeforediscount', '$discountamount', '$totalamount','pending','$particulars','$transactionmode','$transactiontype','$totalamount','$transactionmodule','$timeonly','$patientname','$cashgivenbycustomer','$cashgiventocustomer','$locationname','$locationcode','$mpesanumber')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumbercode','$dateonly','$ipaddress','$username','$totalamount','$mpesacoa','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
$query22 = "insert into billing_consultation(billdate,patientcode,patientname,patientvisitcode,consultation,consultationcoa,copay,copaycoa,accountname,billnumber,ipaddress,transactionmode,transactionamount,creditamount,mpesanumber,username,billtype,locationname,locationcode,bankcode,doctorcode,doctorname,consultation_percentage,sharingamount,visittype,is_resdoc)
values('$consultationdate','$patientcode','$patientname','$visitcode','$patientbillamount','$consultationcoa','$copay','$copaycoa','$accountname','$billnumbercode','$ipaddress','$transactionmode','$totalamount','$totalamount','$mpesanumber','$username','$patientbilltype','$locationname','$locationcode','$mpesacode','$doctorcode','$consultingdoctor','$conspercentage','$sharingamount','$visittype','$is_resdoc')";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		}
		
		$consultationdiscountfees = $_REQUEST['consultationdiscountfees'];
		if($consultationdiscountfees > 0)
		{
			$querypwp = "select visitcode from billing_patientweivers where patientcode = '$patientcode' and visitcode = '$visitcode'";
			$execpwp = mysqli_query($GLOBALS["___mysqli_ston"], $querypwp) or die ("Error in Querypwp".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowpwp = mysqli_num_rows($execpwp);
			if($rowpwp == 0)
			{
				$querypwp1 = "INSERT INTO `billing_patientweivers`(`billno`, `entrydate`, `patientcode`, `visitcode`, `patientname`, `billtype`, `accountnameid`, `accountnameano`, `accountname`, `consultationamount`, `consultationfxamount`, `locationcode`, `locationname`, `username`, `ipaddress`, `updatedatetime`) 
							  VALUES('$billnumbercode','$consultationdate','$patientcode','$visitcode','$patientname','PAY NOW','$accountcode','$accountnameano','$accountname','$consultationdiscountfees','$consultationdiscountfees','$locationcode','$locationname','$username','$ipaddress','$updatedatetime')";							  
				$execpwp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwp1) or die ("Error in Querypwp1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$querypwp1 = "UPDATE `billing_patientweivers` SET `consultationamount` = '$consultationdiscountfees', `consultationfxamount` = '$consultationdiscountfees' WHERE patientcode = '$patientcode' and visitcode = '$visitcode'";
				$execpwp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwp1) or die ("Error in Querypwp1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	
		$query22 = "update master_visitentry set paymentstatus = 'completed',copay_forcebillstatus='$copay_forcebillstatus' where visitcode = '$visitcode' and patientcode = '$patientcode' ";
		$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query3 = "select * from master_billing where patientcode = '$patientcode' and billingdatetime = '$billingdatetime' order by auto_number desc limit 0,1";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$res3billanum = $res3['auto_number'];
		$res3billnumber = $res3['billnumber'];
			
		$patientcode = '';
		$visitcode = '';
		$patientfirstname = '';
		$patientlastname = '';
		$consultationtype = '';
		$billingdatetime = '';
		$consultingdoctor = '';
		$accountname = '';
		$accountexpirydate = '';
		$paymenttype = '';
		$subtype = '';
		$planname = '';
		$planexpirydate = '';
		$visitlimit = '';
		$overalllimit = '';
		$paymenttype = '';
		$paymentmode = '';
		$billtype = '';
		$billamount = '';
		$billentryby = '';
		$consultationremarks = '';
		$visittype = '';	
		
		header("location:patientbillingstatus_bills.php?consbillautonumber=$res3billnumber&&st=success&&locationcode=$locationcode");
	
		/*echo '<script type="text/javascript">printConsultationBill(); </script>'; */
		exit;
		}
		else
		{
	//	header("location:patientbillingstatus_bills.php");
		}
	}
	else
	{
	//	header("location:billing_pending_op1.php?patientcode=$patientcode&&st=failed");
	}
}
else
{
	$patientcode = '';
	$visitcode = '';
	$patientfirstname = '';
	$patientlastname = '';
	$billnumber = '';
	$consultationtype = '';
	$billingdatetime = '';
	$consultingdoctor = '';
	$accountname = '';
	$accountexpirydate = '';
	$paymenttype = '';
	$subtype = '';
	$planname = '';
	$planexpirydate = '';
	$visitlimit = '';
	$overalllimit = '';
	$paymenttype = '';
	$paymentmode = '';
	$billtype = '';
	$billamount = '';
	$billentryby = '';
	$consultationremarks = '';
	$visittype = '';
}
//to redirect if there is no entry in masters category or item or customer or settings
//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
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
//include ("autocompletebuild_customer1.php");
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
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patientage=$execlab['age'];
 $patientgender=$execlab['gender'];
 
 
?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['patientfullname'];
$patientfirstname = $execlab1['patientfirstname'];
	$patientmiddlename=$execlab1['patientmiddlename'];
	$patientlastname = $execlab1["patientlastname"];
	$locationcode=$execlab1['locationcode'];
$patientaccount=$execlab1['accountname'];
$patientbilltype = $execlab1['billtype'];
$planpercentage = $execlab1["planpercentage"];

$planpercentage = $execlab1["planpercentage"];
$pvtype = $execlab1["visittype"];
$copay_forcecheck = $execlab1["copay_forcecheck"];

//echo $planpercentage;
$planfixedamount = $execlab1["planfixedamount"]; 
$query5 = "select * from master_accountname where auto_number = '$patientaccount'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$accountname = $res5['accountname'];
$accountcode = $res5['id'];
$accountnameano = $res5['auto_number'];
$plan=$execlab1['planname'];
$type=$execlab1['paymenttype'];
$subtype=$execlab1['subtype'];
$opdate=$execlab1['consultationdate'];
$consultationfees  = $execlab1["consultationfees"];
$billamount = $consultationfees;

if($copay_forcecheck=='1' &&$planfixedamount>0){
$consultationfees=$planfixedamount;
$billamount=$planfixedamount;
}else if($copay_forcecheck=='1' &&$planpercentage>0){
$consultationfees=$planpercentage;
$billamount=$planpercentage;	
}


$billentryby = strtoupper($username);
$consultationtype = $execlab1['consultationtype'];
$query26 = "select * from master_consultationtype where auto_number = '$consultationtype'";
$exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res26 = mysqli_fetch_array($exec26);
$consultationtypes = $res26['consultationtype'];
$consultingdoctor= $execlab1['consultingdoctor'];
$consultingdoctorcode= $execlab1['consultingdoctorcode'];
//echo $consultingdoctoranum;
$departmentanum = $execlab1['department'];
//echo $departmentanum;
$query5 = "select * from master_department where auto_number = '$departmentanum'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$department = $res5['department'];
//echo $department;
$query45="select * from master_planname where auto_number='$plan'";
$exec45=mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res45=mysqli_fetch_array($exec45);
$planname=$res45['planname'];
$query46="select * from master_paymenttype where auto_number='$type'";
$exec46=mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res46=mysqli_fetch_array($exec46);
$paymenttype=$res46['paymenttype'];
$query47="select * from master_subtype where auto_number='$subtype'";
$exec47=mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res47=mysqli_fetch_array($exec47);
$subtype=$res47['subtype'];
$fxrate = $res47['fxrate'];
$currency = $res47['currency'];
$query76 = "select * from master_financialintegration where field='consultationfee'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$consultationcoa = $res76['code'];
$query761 = "select * from master_financialintegration where field='copay'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res761 = mysqli_fetch_array($exec761);
$copaycoa = $res761['code'];
$query765 = "select * from master_financialintegration where field='cashconsultation'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);
$cashcoa = $res765['code'];
$query766 = "select * from master_financialintegration where field='chequeconsultation'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);
$chequecoa = $res766['code'];
$query767 = "select * from master_financialintegration where field='mpesaconsultation'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);
$mpesacoa = $res767['code'];
$query768 = "select * from master_financialintegration where field='cardconsultation'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);
$cardcoa = $res768['code'];
$query769 = "select * from master_financialintegration where field='onlineconsultation'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);
$onlinecoa = $res769['code'];
$query770 = "select * from master_doctor where doctorcode = '$consultingdoctorcode'";
$exec770 = mysqli_query($GLOBALS["___mysqli_ston"], $query770) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res770 = mysqli_fetch_array($exec770);
//$consultationpercentage = $res770['consultation_percentage'];

if($pvtype=='private')
	$consultationpercentage = $res770['op_consultation_private_sharing'];
else
	$consultationpercentage = $res770['consultation_percentage'];


?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$consultationprefix = $res3['consultationprefix'];
$query2 = "select * from master_billing order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
if ($billnumber == '')
{
	$billnumbercode =$consultationprefix.'1'."-".date('y');
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber, 3, 8);
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $consultationprefix.$maxanum."-".date('y');
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<?php 
if($patientbilltype == 'PAY NOW')
{
	$billamountpatient = $billamount;
	$billamountpatient = number_format($billamountpatient,2,'.','');
}
if($planfixedamount != 0)
{
	if($planfixedamount >= $billamount)
	{
		 $billamountpatient =  $billamount ;
		
	}
	else 
	{
		 $billamountpatient = $planfixedamount;
		 
	}
}
if($planpercentage != 0)
{
	//echo "hi";
	$percentageamount = $planpercentage /100;
	$percentagebalanceamount = $billamount * $percentageamount ;
	$billamountpatient = $percentagebalanceamount;
}
if($currency != 'UGX')
{
	$query = mysqli_query($GLOBALS["___mysqli_ston"], "select rate from master_currency where currency = '$currency'");
	$res = mysqli_fetch_array($query);
	$num = mysqli_num_rows($query);
	if($num > 0){
	$rate = $res['rate'];
	} else {
	$rate = '1';
	}
	
	$billamountpatient = $billamountpatient * $rate;
	$billamountpatient = number_format($billamountpatient,2,'.','');
}else{
	$currency = 'UGX';
	$rate = '1';
	$billamountpatient = $billamountpatient * $rate;
	$billamountpatient = number_format($billamountpatient,2,'.','');
}
$query_pw = "select `docno`, `entrydate`, `consult_discamount` from patientweivers where visitcode='$visitcode' and patientcode='$patientcode'";
$exec_pw = mysqli_query($GLOBALS["___mysqli_ston"], $query_pw) or die ("Error in Query_pw".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_pw = mysqli_fetch_array($exec_pw);
$consult_discamount = $res_pw['consult_discamount'];
$billamountpatient = $billamountpatient - $consult_discamount;
$billamountpatient = number_format($billamountpatient,2,'.','');
?>
<script>
function printConsultationBill()
 {
var popWin; 
popWin = window.open("print_consultationbill_dmp4inch1.php?patientcode=<?php echo $patientcode; ?>&&billautonumber=<?php echo $billnumbercode; ?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
 }
</script>
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
	funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
//	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	
	funcPopupPrintFunctionCall();
	defaultvalueset();
	
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
<?php include ("js/sales1scripting_new_adj.php"); ?>
<script type="text/javascript">
function quickprintbill2sales()
{
   
	var varBillNumber1 = document.getElementById("quickprintbill").value;
	
	window.open("print_consultationbill_dmp4inch1.php?billautonumber="+varBillNumber1+"","OriginalWindowA4<?php echo $banum; ?>",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
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
	var varBillAutoNumber = "<?php //echo $previousbillautonumber; ?>";
	var varBillCompanyAnum = "<?php echo $_SESSION["companyanum"]; ?>";
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
		window.open("print_consultation_billa4.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_consultation_billa5.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
}
function cashentryonfocus1()
{
	if (document.getElementById("cashgivenbycustomer").value == "0.00")
	{
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgivenbycustomer").focus();
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
		window.location="sales1.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";
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
var balance_amt = 0;
function balancecalc(mode)
{
	var mode = mode;
	
	var cashgivenbycustomer = document.getElementById("cashgivenbycustomer").value;
	if(cashgivenbycustomer == '')
	{
		cashgivenbycustomer = 0;
	}
	var billtype = document.getElementById("billtype").value;
	var cashamount = document.getElementById("cashamount").value;
	
	if(cashamount == '')
	{
	cashamount = 0;
	}
	var chequeamount = document.getElementById("chequeamount").value;
	if(chequeamount == '')
	{
	chequeamount = 0;
	}
	var cardamount = document.getElementById("cardamount").value;
	if(cardamount == '')
	{
	cardamount = 0;
	}
	var onlineamount = document.getElementById("onlineamount").value;
	if(onlineamount == '')
	{
	onlineamount = 0;
	}
	var adjustamount = document.getElementById("adjustamount").value;
	if(adjustamount == '')
	{
		adjustamount = 0;
	}
	var mpesaamount = document.getElementById("creditamount").value;
	if(mpesaamount == '')
	{
	mpesaamount = 0;
	}
	var balance_amt = parseFloat($('#hid_bal_amt').val());
	if(parseFloat(adjustamount) >parseFloat( balance_amt) )
	{
		alert('Adjust amount exceeds Available Amount');
		$('#adjustamount').val('0.00');
		//balancecalc('5');
		$('#adjustamount').keyup();
		return false;
	}
	else
	{
		
		var adv_dep_bal_amt = parseFloat(balance_amt) - parseFloat(adjustamount);
		adv_dep_bal_amt = adv_dep_bal_amt.toFixed(2);
		//var format_bal = adv_dep_bal_amt.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		$('#adv_dep_bal_amt').text(adv_dep_bal_amt.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
		$('#net_deposit_amt').val(adv_dep_bal_amt);
	}
	var balance =  document.getElementById("subtotal").value;
	var totalamount = parseFloat(cashgivenbycustomer)+parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount);
	
	var newbalance=parseFloat(balance) - parseFloat(totalamount);
	
	if(newbalance < 0)
	{
		alert("Given amount already exits the Bill amount!");
		
		/*if(mode == '1')
		{
			document.getElementById("cashamount").value = '0.00';
		}    
		if(mode == '2')
		{
			document.getElementById("creditamount").value = '0.00';
		}  
		if(mode == '3')
		{
			document.getElementById("chequeamount").value = '0.00';
		}  
		if(mode == '4')
		{
			document.getElementById("cardamount").value = '0.00';
		}  
		if(mode == '5')
		{
			document.getElementById("onlineamount").value = '0.00';
		}            
		
		var cashpay=document.getElementById("cashgivenbycustomer").value;
		var mpaypay=document.getElementById("creditamount").value;
		var cheqpay=document.getElementById("chequeamount").value;
		var cardpay=document.getElementById("cardamount").value;
		var onlipay=document.getElementById("onlineamount").value;
		
		var totalamount1 = document.getElementById("totalamount").value ;
		
		var allcash=parseFloat(cashpay)+parseFloat(mpaypay)+parseFloat(cheqpay)+parseFloat(cardpay)+parseFloat(onlipay);   
		
		var show1=parseFloat(totalamount1)-parseFloat(allcash);
		if(parseFloat(show1)<=0)
		{
			document.getElementById("tdShowTotal").innerHTML=0.00;
			document.getElementById("balanceamt").value=0.00;
		}
		else
		{
			document.getElementById("tdShowTotal").innerHTML=show1.toFixed(2);
			document.getElementById("balanceamt").value=show1.toFixed(2);
		}
		return false;*/
	}
	
	var balance =  document.getElementById("subtotal").value;
	
	// check if adjust amount is more than deposit amount
	
	var cashpay=document.getElementById("cashgivenbycustomer").value;
	if(cashpay==''){
		cashpay=0.00;
		}
	var mpaypay=document.getElementById("creditamount").value;
	var cheqpay=document.getElementById("chequeamount").value;
	var cardpay=document.getElementById("cardamount").value;
	var onlipay=document.getElementById("onlineamount").value;
	
	var totalamount = parseFloat(cashpay)+parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount) + parseFloat(adjustamount);
	if(billtype=='SPLIT')
	{
		//alert(balance);
		document.getElementById("cashamount").value = parseFloat(balance) - (parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount) + parseFloat(adjustamount));
		//alert(parseFloat(totalamount) - (parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount)));
	}
	
	//alert(balance);
	var newbalance=parseFloat(balance) - parseFloat(totalamount);
	if(parseFloat(newbalance)<=0)
	{
		document.getElementById("tdShowTotal").innerHTML=0.00;
		document.getElementById("balanceamt").value=0.00;
	}
	else
	{
		document.getElementById("tdShowTotal").innerHTML=newbalance.toFixed(2);
		document.getElementById("balanceamt").value=newbalance.toFixed(2);
	}
	/*if( (document.getElementById("adjustamount").value !=undefined )  && (!isNaN(document.getElementById("adjustamount").value)) && adjustamount !="")
	{
			var adv_dep_total_amt = parseFloat($('#adv_dep_total_amt').text());
			if(parseFloat(adjustamount) > adv_dep_total_amt )
			{
				alert('Adjust amount exceeds Deposit Amount');
				//$('#adv_dep_bal_amt').text('');
			}
			else
			{
				var adv_dep_bal_amt = adv_dep_total_amt - parseFloat(adjustamount);
				adv_dep_bal_amt = adv_dep_bal_amt.toFixed(2);
				$('#adv_dep_bal_amt').text(adv_dep_bal_amt);
				$('#net_deposit_amt').val(adv_dep_bal_amt);
			}
			
	} */
	//if( (document.getElementById("adjustamount").value !=undefined )  && (!isNaN(document.getElementById("adjustamount").value)) && adjustamount !="")
	//{
			
			
	//}
document.getElementById("tdShowTotal").innerHTML=(document.getElementById("tdShowTotal").innerHTML).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
/*function updateBalAmtMode()
{
	var adjustamount = document.getElementById("adjustamount").value;
	if(adjustamount !="" && adjustamount !=undefined)
	{
		var adv_dep_total_amt = parseFloat($('#adv_dep_total_amt').text());
		adv_dep_total_amt = adv_dep_total_amt.toFixed(2);
		$('#adv_dep_bal_amt').text(adv_dep_total_amt);
		$('#net_deposit_amt').val(adv_dep_total_amt);
	}
}*/
</script>
<script>
function functioncurrencyfx(val)
{	
	var myarr = val.split(",");
	var currate=myarr[0];
	var currency=myarr[1];
	
	var ledgername=myarr[2];
	var ledgercode=myarr[3];
	//alert(currate);
	//alert(currency);
	document.getElementById("fxamount").value=  currate;
	
	document.getElementById("ledgername").value=  ledgername;
	document.getElementById("ledgercode").value=  ledgercode;
	
	document.getElementById("amounttot").value='';
	document.getElementById("currencyamt").value='';
	
	
}
function funcamountcalc()
{
if(document.getElementById("currencyamt").value != '')
{
var currency = document.getElementById("currencyamt").value;
var rate = document.getElementById("fxamount").value;
var amount = currency * rate;
document.getElementById("amounttot").value = amount.toFixed(2);
}
}
</script>
<script>
/*function btnDeleteClick4(delID)
{
	console.log('hii in delete333')
//var pharmamount=pharmamount;
	//alert ("Inside btnDeleteClick.");
	var newtotal4;
	//alert(pharmamount);
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert('amounttot['+varDeleteID+']');
		var curamount = document.getElementById('amounttot['+varDeleteID+']').value; // currency amount
		
		document.getElementById("cashgivenbycustomer").value=parseFloat(document.getElementById("cashgivenbycustomer").value)-parseFloat(curamount);
		document.getElementById("cashamount").value=document.getElementById("cashgivenbycustomer").value;
		//funcbillamountcalc1();
		var totalamount = document.getElementById("totalamount").value ;
		if (document.getElementById("billtype").value == "CASH")
		{
			var cashgiventocustomer=document.getElementById("cashgiventocustomer").value;
			var totalamt=document.getElementById("totalamount").value;
			if(parseFloat(totalamt)<=parseFloat(document.getElementById("cashgivenbycustomer").value))
			{
				document.getElementById("cashgiventocustomer").value=parseFloat(document.getElementById("cashgivenbycustomer").value)-parseFloat(totalamt);
			}
			else {document.getElementById("cashgiventocustomer").value=0;}
			
			var balanceinfo=parseFloat(totalamount)-parseFloat(document.getElementById("cashgivenbycustomer").value);
			if(parseFloat(balanceinfo)>0)
			{
				document.getElementById("balanceamt").value=balanceinfo;
				document.getElementById("tdShowTotal").innerHTML =balanceinfo;
			}
			else
			{
				document.getElementById("balanceamt").value=0.00;
				document.getElementById("tdShowTotal").innerHTML =0.00;			
			}
							
		}
	
		if (document.getElementById("billtype").value == "SPLIT")
		{
			var cashgiventocustomer=document.getElementById("cashgiventocustomer").value;
			var totalamt=document.getElementById("totalamount").value;
			
			var cashpay=document.getElementById("cashgivenbycustomer").value;
			var mpaypay=document.getElementById("creditamount").value;
			var cheqpay=document.getElementById("chequeamount").value;
			var cardpay=document.getElementById("cardamount").value;
			var onlipay=document.getElementById("onlineamount").value;
			var adjustpay=document.getElementById("adjustamount").value;
			
			var allcash=parseFloat(cashpay)+parseFloat(mpaypay)+parseFloat(cheqpay)+parseFloat(cardpay)+parseFloat(onlipay)+parseFloat(adjustpay);
			//alert(allcash);
			if(parseFloat(totalamt)<=parseFloat(allcash))
			{
				var cashgtocst=parseFloat(document.getElementById("cashgivenbycustomer").value)-parseFloat(totalamt);
				document.getElementById("cashgiventocustomer").value=parseFloat(cashgtocst);
				if(parseFloat(cashgtocst)>=parseFloat(cashpay))
				{
					alert("Change is more than cash taken!");
					document.getElementById("cashgiventocustomer").value=0;
				}
			}
			else {document.getElementById("cashgiventocustomer").value=0;}
			
			
			var cashpay=document.getElementById("cashgivenbycustomer").value;
			var mpaypay=document.getElementById("creditamount").value;
			var cheqpay=document.getElementById("chequeamount").value;
			var cardpay=document.getElementById("cardamount").value;
			var onlipay=document.getElementById("onlineamount").value;
			var adjustpay=document.getElementById("adjustamount").value;
			var allcash=parseFloat(cashpay)+parseFloat(mpaypay)+parseFloat(cheqpay)+parseFloat(cardpay)+parseFloat(onlipay)+parseFloat(adjustpay);
			console.log('allcash'+allcash)
			console.log('totalamt'+totalamount)
			var balanceinfo=parseFloat(totalamount)-parseFloat(allcash);
			console.log('bal'+balanceinfo)
			if(parseFloat(balanceinfo)>0)
			{
				document.getElementById("balanceamt").value=balanceinfo;
				document.getElementById("tdShowTotal").innerHTML =balanceinfo;
			}
			else
			{
				document.getElementById("balanceamt").value=0.00;
				document.getElementById("tdShowTotal").innerHTML =0.00;			
			}
		
		}
		
	//	alert(curamount);
		
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		//amounttot[2]
		//var curamount = document.getElementById('amounttot'+varDeleteID); // currency amount
		//alert(curamount);
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	var currenttotal4=document.getElementById('amounttot').value;
	//alert(currenttotal);
	newtotal4= currenttotal4-varDeleteID;
	
	newtotal4 = newtotal4.toFixed(2);
	
	document.getElementById('amounttot').value=0.00;
	
	funcPaymentInfoCalculation1();
}*/
</script>
<script type="text/javascript" src="js/insertitemcurrencyfx.js"></script>
<script>
function btnDeleteClick4(delID)
{
	
//var pharmamount=pharmamount;
	//alert ("Inside btnDeleteClick.");
	var newtotal4;
	//alert(pharmamount);
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert('amounttot['+varDeleteID+']');
		var curamount = document.getElementById('amounttot['+varDeleteID+']').value; // currency amount
		var totalcashgiven = document.getElementById("cashgivenbycustomer").value;
		
		document.getElementById("cashgivenbycustomer").value=parseFloat(document.getElementById("cashgivenbycustomer").value)-parseFloat(curamount);
		document.getElementById("cashamount").value=document.getElementById("cashgivenbycustomer").value;
		//funcbillamountcalc1();
		var totalamount = document.getElementById("totalamount").value ;
		if (document.getElementById("billtype").value == "CASH")
		{
			var cashgiventocustomer=document.getElementById("cashgiventocustomer").value;
			var totalamt=document.getElementById("totalamount").value;
			if(parseFloat(totalamt)<=parseFloat(document.getElementById("cashgivenbycustomer").value))
			{
				document.getElementById("cashgiventocustomer").value=parseFloat(document.getElementById("cashgivenbycustomer").value)-parseFloat(totalamt);
			}
			else {document.getElementById("cashgiventocustomer").value=0;}
			
			var balanceinfo=parseFloat(totalamount)-parseFloat(document.getElementById("cashgivenbycustomer").value);
			if(parseFloat(balanceinfo)>0)
			{
				document.getElementById("balanceamt").value=balanceinfo;
				document.getElementById("tdShowTotal").innerHTML =balanceinfo;
			}
			else
			{
				document.getElementById("balanceamt").value=0.00;
				document.getElementById("tdShowTotal").innerHTML =0.00;			
			}
							
		}
	
		if (document.getElementById("billtype").value == "SPLIT")
		{
			var cashgiventocustomer=document.getElementById("cashgiventocustomer").value;
			var totalamt=document.getElementById("totalamount").value;
			
			var cashpay=document.getElementById("cashgivenbycustomer").value;
			var mpaypay=document.getElementById("creditamount").value;
			var cheqpay=document.getElementById("chequeamount").value;
			var cardpay=document.getElementById("cardamount").value;
			var onlipay=document.getElementById("onlineamount").value;
			var adjustpay=document.getElementById("adjustamount").value;
			
			var allcash=parseFloat(cashpay)+parseFloat(mpaypay)+parseFloat(cheqpay)+parseFloat(cardpay)+parseFloat(onlipay)+parseFloat(adjustpay);
			//alert(allcash);
			if(parseFloat(totalamt)<=parseFloat(allcash))
			{
				var cashgtocst=parseFloat(document.getElementById("cashgivenbycustomer").value)-parseFloat(totalamt);
				document.getElementById("cashgiventocustomer").value=parseFloat(cashgtocst);
				if(parseFloat(cashgtocst)>=parseFloat(cashpay))
				{
					alert("Change is more than cash taken!");
					document.getElementById("cashgiventocustomer").value=0;
				}
			}
			else {document.getElementById("cashgiventocustomer").value=0;}
			
			
			var cashpay=totalcashgiven;
			var mpaypay=document.getElementById("creditamount").value;
			var cheqpay=document.getElementById("chequeamount").value;
			var cardpay=document.getElementById("cardamount").value;
			var onlipay=document.getElementById("onlineamount").value;
			var adjustpay=document.getElementById("adjustamount").value;
			var allcash=parseFloat(cashpay)+parseFloat(mpaypay)+parseFloat(cheqpay)+parseFloat(cardpay)+parseFloat(onlipay)+parseFloat(adjustpay);
			var balanceinfo=parseFloat(totalamount)- ( parseFloat(allcash) - parseFloat(curamount) );
			if(parseFloat(balanceinfo)>0)
			{
				document.getElementById("balanceamt").value=balanceinfo;
				document.getElementById("tdShowTotal").innerHTML =balanceinfo;
			}
			else
			{
				document.getElementById("balanceamt").value=0.00;
				document.getElementById("tdShowTotal").innerHTML =0.00;			
			}
		
		}
		
	//	alert(curamount);
		
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		//amounttot[2]
		//var curamount = document.getElementById('amounttot'+varDeleteID); // currency amount
		//alert(curamount);
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	var currenttotal4=document.getElementById('amounttot').value;
	//alert(currenttotal);
	newtotal4= currenttotal4-varDeleteID;
	
	newtotal4 = newtotal4.toFixed(2);
	
	document.getElementById('amounttot').value=0.00;
	
	funcPaymentInfoCalculation1();
}
</script>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext4 {	FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
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
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script>
$( document ).ready(function() {
var values = $('#currency').val().split(",");
document.getElementById('fxamount').value=values[0]; 
document.getElementById('ledgername').value=values[2];
document.getElementById('ledgercode').value=values[3];   
 
  
});
</script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="form1" method="post" action="consultationbillingfx.php" onKeyDown="return disableEnterKey(event);" >
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
			<tr>
			<td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext4"><strong>Patient Details</strong>			</td>
			</tr>
              <tr>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                </tr>
                <?php $query="select locationcode,locationname from master_location where locationcode = '".$locationcode."' and status = ''";
			 
			 $exec1print = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1print.".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1print = mysqli_fetch_array($exec1print);
				$locationname = $res1print["locationname"];
	?>
                <tr><td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong> </td>
              <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <?php  echo $locationname; ?></td>
			  
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  * </strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="customername" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly type="hidden"/><?php echo $patientname; ?>
                <input type="hidden" name="patientfirstname" value="<?php echo $patientfirstname; ?>">
				<input type="hidden" name="patientmiddlename" value="<?php echo $patientmiddlename; ?>">
				<input type="hidden" name="patientlastname" value="<?php echo $patientlastname; ?>">				  </td>
                    
                 <input type="hidden" name="consultationcoa" value="<?php echo $consultationcoa; ?>">
				<input type="hidden" name="copaycoa" value="<?php echo $copaycoa; ?>">
				<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
				<input type="hidden" name="locationcode" value="<?php echo $locationcode; ?>">
                <input type="hidden" name="locationname" value="<?php  echo $locationname; ?>">
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Type</strong></td>
                <td class="bodytext3" align="left" valign="middle" >
				<input name="paymenttype" id="paymenttype" type="hidden" value="<?php echo $paymenttype; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $paymenttype; ?>				</td>
              </tr>
			 
		
			  <tr>
			   
                 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
               <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Sub Type</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input name="subtype" id="subtype" type="hidden" value="<?php echo $subtype; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $subtype; ?>				</td>
			    </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>				</td>
					    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td class="bodytext3" align="left" valign="middle" >
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input name="accountcode" id="accountcode" type="hidden" value="<?php echo $accountcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input name="accountnameano" id="accountnameano" type="hidden" value="<?php echo $accountnameano; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<?php echo $accountname; ?></td>
				  </tr>
				  <tr>
				     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>OP Date</strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="opdate" id="opdate" type="hidden" value="<?php echo $opdate; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $opdate; ?>				</td>
			
				    
     	<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Plan Name</strong></td>
                <td class="bodytext3" align="left" valign="top" >
				<input name="planname" id="planname" type="hidden" value="<?php echo $planname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $planname; ?>				</td>
				  </tr>
				  <tr>
				    <td class="bodytext3"><strong>    Bill No. </strong></td>
	 <td class="bodytext3"> <input name="billnumber" id="billnumber" value="<?php echo $billnumbercode; ?>" <?php echo $billnumbertextboxvalidation; ?> style="border: 1px solid #001E6A; text-align:left" size="18" readonly type="hidden"/><?php echo $billnumbercode; ?></td>
                  <td class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Bill Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
             
				     <td class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>				</td>
				  </tr>
            </tbody>
        </table></td>
      </tr>
      <tr>
			<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext4"><strong>Transaction Details</strong>
			</td>
			</tr>
			
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
              <td width="18%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Dept</strong></div></td>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Consulting Doctor </strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Consultation Type</strong></div></td>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Consultation Fees </strong></div></td>
					<td width="13%"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Copay Amount </strong></div></td>
				<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Copay% </strong></div></td>
               <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Discount Amount </strong></div></td>
                  </tr>
	
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $department; ?></div></td>
			 <input type="hidden" name="department" value="<?php echo $department; ?>">
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultingdoctor; ?></div></td>
				<input type="hidden" name="consultingdoctor" value="<?php echo $consultingdoctor; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationtypes; ?></div></td>
			 <input type="hidden" name="consultationtype" value="<?php echo $consultationtypes; ?>">
			    <td class="bodytext31" valign="center"  align="left"><div align="center"> <?= number_format($consultationfees,2,'.',','); ?></div></td>
				<input type="hidden" name="consultationfees" value="<?php echo $consultationfees; ?>">
				<input type="hidden" name="patientbilltype" value="<?php echo $patientbilltype; ?>">
				<input type="hidden" name="billamount" value="<?php echo $consultationfees; ?>">
				<input type="hidden" name="patientbillamount" value="<?php echo $billamountpatient; ?>">
				<input type="hidden" name="copay_forcecheck" value="<?php echo $copay_forcecheck; ?>">
				 <input type="hidden" name="billentryby" id="billentryby" value="<?php echo $billentryby; ?>" readonly style="border: 1px solid #001E6A;">
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $planfixedamount; ?></div></td>
				 <input type="hidden" name="copayfixedamount" value="<?php echo $planfixedamount; ?>">
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $planpercentage; ?></div></td>
				  <input type="hidden" name="copaypercentageamount" value="<?php echo $planpercentage; ?>">
				   <input name="totalamountbeforediscount" type="hidden" id="totalamountbeforediscount" value="<?php echo $billamountpatient; ?>" readonly style="border: 1px solid #001E6A; background-color:#ecf0f5; text-align:right" size="10">
				<input type="hidden" name="totalamount" value="<?php echo $billamountpatient; ?>">
				<td align="left" valign="center" class="bodytext31"><div align="center"><?php echo $consult_discamount; ?></div>
				<input type="hidden" name="consultationdiscountfees" id="consultationdiscountfees" value="<?php echo $consult_discamount; ?>"></td>
				</tr>
			
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
             </tr>
           
          </tbody>
        </table>		</td>
      </tr>
     
      <tr>
        <td>
		<table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" bgcolor="#F3F3F3" id="AutoNumber3" style="BORDER-COLLAPSE: collapse">
            <tbody id="foo">
              <tr>
                <td width="1" align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <?php
				
				$originalamount = $billamountpatient;
			  	$billamountpatient = round($billamountpatient/5,2)*5;
			  	$roundoffamount = $originalamount - $billamountpatient;
			  	$roundoffamount = number_format($roundoffamount,2,'.','');
			  	$roundoffamount = -($roundoffamount);
			  	$billamountpatient = number_format($billamountpatient,2,'.','');
			  ?>
                <td width="48" rowspan="3" align="right" valign="top"  
                bgcolor="#F3F3F3" class="style1" id="tdShowTotal"> <?= number_format($billamountpatient,2,'.',','); ?></td>
                <td width="108" align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Sub Total </strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="128">&nbsp;</td>
                <td align="left" valign="top" bgcolor="#F3F3F3" ><span class="bodytext31">
                  <input name="subtotal" id="subtotal" value="<?php echo $originalamount; ?>" style="text-align:right" size="8"  readonly="readonly" />
                </span></td>
				
                <td align="left" valign="top" bgcolor="#F3F3F3" width="52">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="136"><div align="right"><strong>Bill Amt </strong></div></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="83">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="74"><span class="bodytext311">
                  <input name="totalamount" id="totalamount" value="<?php echo $billamountpatient; ?>" style="text-align:right" size="8"  readonly="readonly" />
                </span></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="109">&nbsp;</td>
              </tr>
			  
              <tr>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Round Off </strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="128">&nbsp;</td>
                <td align="left" valign="top" bgcolor="#F3F3F3" ><span class="bodytext311">
				 <input name="roundoff" id="roundoff" value="<?php echo $roundoffamount; ?>" style="text-align:right"  readonly="readonly" size="8"/>
                  <input name="totalaftercombinediscount" id="totalaftercombinediscount" value="0.00" style="text-align:right" size="8"  readonly="readonly" type="hidden"/>
                </span></td>
                <td align="left" valign="top" bgcolor="#F3F3F3" width="52">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="136"><div align="right"><strong>Nett Amt</strong></div></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="83">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="74"><span class="bodytext31">
                  <input name="nettamount" id="nettamount" value="0.00" style="text-align:right" size="8" readonly />
                </span></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="109">&nbsp;</td>
              </tr>
                <input type="hidden" name="totalaftertax" id="totalaftertax" value="0.00"  onKeyDown="return disableEnterKey()" onBlur="return funcSubTotalCalc()" style="text-align:right" size="8"  readonly="readonly"/>
              
               
              <tr>
                <td align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Mode </strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="128">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><select name="billtype" id="billtype" onChange="return paymentinfo();">
                  <option value="">SELECT BILL TYPE</option>
                  <?php
					$query1billtype = "select * from master_billtype where status = '' order by listorder";
					$exec1billtype = mysqli_query($GLOBALS["___mysqli_ston"], $query1billtype) or die ("Error in Query1billtype".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res1billtype = mysqli_fetch_array($exec1billtype))
					{
					$billtype = $res1billtype["billtype"];
					?>
                  <option value="<?php echo $billtype; ?>"><?php echo $billtype; ?></option>
                  <?php
					}
					?>
                  <!--					
                    <option value="CASH">CASH</option>
                    <option value="CREDIT">CREDIT</option>
                    <option value="CHEQUE">CHEQUE</option>
                    <option value="CREDIT CARD">CREDIT CARD</option>
                    <option value="ONLINE">ONLINE</option>
                    <option value="SPLIT">SPLIT</option>
-->
                </select></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="52">&nbsp;</td>
                <td align="left" valign="center" style="display: none;" bgcolor="#F3F3F3" class="bodytext311" width="136"><div align="right"><strong>Doctor Sharing</strong></div></td>
                <?php $sharingamt = $originalamount * ($consultationpercentage/100); ?>
                <td align="left" valign="middle" bgcolor="#F3F3F3" width="74">&nbsp;</td><td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="74"><span class="bodytext31">
                  <input name="sharingamt" id="sharingamt" type="hidden" value="<?php echo $sharingamt; ?>" style="text-align:right" size="8" readonly />
                  <input name="doctorcode" id="doctorcode" value="<?php echo $consultingdoctorcode; ?>" type="hidden" style="text-align:right" size="8" readonly />
                  <input name="conspercentage" id="conspercentage" value="<?php echo $consultationpercentage; ?>" type="hidden" style="text-align:right" size="8" readonly />
				  <input name="visittype" id="visittype" value="<?php echo $pvtype; ?>" type="hidden" style="text-align:right" size="8" readonly />

				  
                </span></td>
                <td align="left" valign="middle" bgcolor="#F3F3F3" width="109">&nbsp;</td>
              </tr>
			  <tr>
			 <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>    
			  </tr>
              	<tr>
                 <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td align="center" colspan="12"  id="insertrow" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
			 </tr>
			  <tr>
			   <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
			  </tr>
              		
                <tr class="cc">
                <td align="left" valign="center"  bgcolor="#F3F3F3" class="bodytext31"></td>
                     </tr>
					  <tr id="cashamounttr" class="cc">
					</tr>
                     
					 
					  <tr id="cashamounttr" class="cc" >
                        
                <td align="left" valign="center"  bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td align="right" valign="center" colspan="2"  bgcolor="#F3F3F3" class="bodytext31"><strong>Currency</strong></td>
					    <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="currencyid" id="currencyid" value="" >
				   <td  ><select  name="currency1" id="currency"   onChange="return functioncurrencyfx(this.value)">
                   <option value="">Select Currency</option>
                                    
                    <?php
					$query1currency = "select * from master_currency where recordstatus = '' ";
					$exec1currency = mysqli_query($GLOBALS["___mysqli_ston"], $query1currency) or die ("Error in Query1currency".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res1currency = mysqli_fetch_array($exec1currency))
					{
					$currency = $res1currency["currency"];
					$rate = $res1currency["rate"];
					$ledgername = $res1currency["ledgername"];
					$ledgercode = $res1currency["ledgercode"];
					$defaultstatus=$res1currency["defaultcurr"];
					?>
 <option value="<?php echo $rate.','.$currency.','.$ledgername.','.$ledgercode;  ?>" <?php if( $defaultstatus =='yes'){ echo 'selected="selected"';} ?>>
 <?php  echo $currency; ?></option>
                  <?php
					}
					?>
                  </select></td>
                   <td align="right" valign="center" class="bodytext3"><strong>FX Rate</strong></td>
				    <td width="52"><input name="fxamount[]" type="text" id="fxamount" size="8" readonly>
                    
                    <input name="ledgername[]" type="hidden" id="ledgername" size="8" readonly>
                    <input name="ledgercode[]" type="hidden" id="ledgercode" size="8" readonly>
                    
                    </td>
                   <td align="right" valign="center" class="bodytext3" colspan="2"><strong> Amount</strong></td>
				    <td width="83"><input name="currencyamt[]" type="text" id="currencyamt" size="8" onKeyUp="return funcamountcalc()"></td>
                     
                    <td align="right" valign="center" class="bodytext3"><strong>Total</strong></td>
					  <td width="109"><input name="amounttot[]" type="text" id="amounttot" readonly size="8"></td>
					   <td width="45"><label>
                       <input type="button" name="Add4" id="Add4" value="Add" onClick="return insertitemcurrency()" class="button">
                       </label></td>
					   
			    </tr>
                <tr>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                </tr>
			
              <tr id="cashamounttr" class="cc" >
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="right" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash </strong></div></td>
                <td width="128" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cashamount" id="cashamount" onBlur="return funcbillamountcalc1()" tabindex="1" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('1')"/></td>
                <td width="142" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash Recd </strong></div></td>
                <td width="52" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cashgivenbycustomer" id="cashgivenbycustomer" onKeyUp="return funcbillamountcalc1()" onFocus="return cashentryonfocus1()" tabindex="2" style="text-align:right" size="8" autocomplete="off" value="0"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="136" colspan="2"><div align="right"><strong>Change   </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="83"><input name="cashgiventocustomer" id="cashgiventocustomer" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8" readonly  /></td>
               
                <td align="right" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="74"><strong>Balance Amt </strong></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="109"><input name="balanceamt" id="balanceamt"  value="0.00" style="text-align:right" size="8" readonly  /></td>
               <input name="totalamountadd" type="hidden" id="totalamountadd"  value="0.00" style="text-align:right" size="8" readonly  />
              </tr>
              
              
              
              
<!--                            <tr id="cashamounttr">
			 
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="right" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash </strong></div></td>
                <td width="6%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cashamount" id="cashamount" onBlur="return funcbillamountcalc1()" tabindex="1" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('1')"/></td>
                <td width="15%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash Recd </strong></div></td>
                <td width="10%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cashgivenbycustomer" id="cashgivenbycustomer" onKeyUp="return funcbillamountcalc1()" onFocus="return cashentryonfocus1()" tabindex="2" style="text-align:right" size="8" autocomplete="off"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="12%"><div align="right"><strong>Change   </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="6%"><input name="cashgiventocustomer" id="cashgiventocustomer" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8" readonly  /></td>
               
               
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="9%">&nbsp;</td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="23%">&nbsp;</td>
              </tr>
-->
			
              <tr id="creditamounttr">
              
              
              
              
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="creditamount" id="creditamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="balancecalc('2'); getEncAmount();"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA No. </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="52"><input name="mpesanumber" id="mpesanumber" value="" style="text-align:left; text-transform:uppercase" size="8"  <?php if($mpesa_integration == 0){ echo "readonly"; } ?> /></td>
			<td>	
			<?php 
				$query = "select mobilenumber from master_customer where customercode = '$patientcode'";
				$execquery = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resquery = mysqli_fetch_array($execquery);
				$mobilenumber = $resquery['mobilenumber'];
			?>
            <!-- iPayments HTML/PHP Code Start -->
            <?php
            	$mpesa_amount = $billamount;
                $mpesa_secret_key = $mpesa_secret;
                $mpesa_result_field = "mpesanumber";
                $mpesa_amount_field = "creditamount";
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
            <?php if($mpesa_integration == 1){ ?><span id="iPaymentsIcon" onclick="OpenMpesa()" style="padding: 3px;background-color: #fff;border-radius: 20px;border: 1px solid;cursor: pointer;" title="Lipa na MPESA - iPayments">⚡</span> <?php } ?>
            
            <!-- iPayments HTML/PHP Code End -->
			</td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="136"></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="83"></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="74"></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="109"></td>
              </tr>
              <tr id="chequeamounttr">
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cheque  </strong></div></td>
                <td width="128" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="chequeamount" id="chequeamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('3')"/></td>
                <td width="142" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Chq No. </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="52"><input name="chequenumber" id="chequenumber" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="136" colspan="2"><div align="right"><strong> Date </strong></div></td>
                <td width="83" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">  <input name="chequedate" id="chequedate" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td width="74" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Bank  </strong></div></td>
                <td width="109" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"> <input name="chequebank" id="chequebank" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                </tr>
			  
              <tr id="cardamounttr">
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Card  </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cardamount" id="cardamount" onBlur="return funcbillamountcalc1()" style="text-align:right" size="8"  readonly="readonly" onKeyUp="getBarclayAmount(); return balancecalc('4');"/></td>

                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Transaction No </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="52"><input name="cardnumber" id="cardnumber" value="" style="text-align:left; text-transform:uppercase" size="8"  <?php if($barclayscard_integration == 1){ echo "readonly"; } ?>/></td>
				
				<td>
				<!-- iPayments HTML/PHP Code Start -->
	            <?php
	                $barclays_amount = $billamount;
	                $barclays_secret_key = $barclays_secret;
	                $barclays_result_field = "cardnumber";
	                $barclays_amount_field = "cardamount";
	                $barclays_user_id = "1"; // Must be an interger value
	            ?>
	            <input type="hidden" name="barclayscard_url" id="barclayscard_url" value="<?= $barclayscard_url ?>" placeholder="Barclays Card Url">
	            <input type="hidden" name="barclays_result_field" id="barclays_result_field" value="<?= $barclays_result_field ?>" placeholder="Mpesa Result">
	            <input type="hidden" name="barclays_amount" id="barclays_amount" value="<?= iPayment_encrypt('$barclays_amount','$barclays_secret_key') ?>" placeholder="Amount">
	            <input type="hidden" name="barclays_amount_field" id="barclays_amount_field" value="<?= $barclays_amount_field ?>">
	            <input type="hidden" name="barclays_secret_key" id="barclays_secret_key" value="<?= $barclays_secret_key ?>" placeholder="Secret Key">
	            <input type="hidden" name="barclays_user_id" id="barclays_user_id" value="<?= $barclays_user_id ?>" placeholder="User">
	            <?php if($barclayscard_integration == 1){ ?><span onclick="OpenBarclays()" style="padding: 3px;background-color: #fff;border-radius: 20px;border: 1px solid;cursor: pointer;" id="iPaymentsIconBarclays" title="Card Payments - iPayments">⚡</span><?php } ?>
	            <!-- iPayments HTML/PHP Code End -->
				</td>

                <!-- <td width="136" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Name  </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="83"><input type="text" name="cardname" id="cardname" size="8" style="text-align:left;"> -->
                <!--<select name="cardname" id="cardname">
                  <option value="">SELECT CARD</option>
                  <?php
				$querycom="select * from master_creditcard where status <> 'deleted'";
				$execcom=mysqli_query($GLOBALS["___mysqli_ston"], $querycom) or die("Error in querycom".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rescom=mysqli_fetch_array($execcom))
				{
				$creditcardname=$rescom["creditcardname"];
				?>
                  <option value="<?php echo $creditcardname;?>"><?php echo $creditcardname;?></option>
                  <?php
				}
				?>
                </select>--><!-- </td>
                <td align="left" valign="center" class="bodytext31" width="74"><div align="right"><strong> Bank  </strong></div></td>
                <td align="left" valign="center" class="bodytext31" width="109"><input name="bankname1" id="bankname" value="" style="text-align:left; text-transform:uppercase"  size="8"  /></td> -->
              </tr>
              <tr id="onlineamounttr">
			  <td align="left" valign="center"
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
			    <td colspan="2" align="left" valign="center" 
                bgcolor="#F3F3F3" class="bodytext31">
                 <div align="right"><strong>Online  </strong></div>                  </td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><input name="onlineamount" id="onlineamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8" readonly onKeyUp="return balancecalc('5')"/></td>
                 <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Online No </strong></div></td>
                <td align="left" valign="center"  
                 class="bodytext31" width="52"><input name="onlinenumber" id="onlinenumber" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
                 class="bodytext31" width="136">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="74">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="109">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
              </tr>
				
              
              <!-- New adjust option -->
               <tr id="adjustamounttr">
			  <td align="left" valign="center"
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
			    <td colspan="2" align="left" valign="center" 
                bgcolor="#F3F3F3" class="bodytext31">
                 <div align="right"><strong>Adjust  </strong></div>                  </td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><input name="adjustamount" id="adjustamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8" readonly onKeyUp="return balancecalc('5')"/>
               </td>
                <td align="left" valign="center"  
                 class="bodytext31" width="136">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="136">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="74">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="109">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
              </tr>
              
              
              <tr>
                
                <td colspan="14" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                  <input name="delbillst" id="delbillst" type="hidden" value="billedit">
                  <input name="delbillautonumber" id="delbillautonumber" type="hidden" value="<?php echo $delbillautonumber;?>">
                  <input name="delbillnumber" id="delbillnumber" type="hidden" value="<?php echo $delbillnumber;?>">
                  <input name="form_flag" id="form_flag" type="hidden" value="consultation">
				  <input name="Submit2223" id="Submit2223" type="submit" onClick="return funcSaveBill1()" value="Save Bill(Alt+s)" accesskey="s" class="button"/>
                </font></font></font></font></font></div></td>
              </tr>
			  
			 <!-- <tr>
                <td colspan="8" class="bodytext32">
				<div align="right"><span class="bodytext31">
                <strong>Print Bill No: </strong>
                <input name="quickprintbill" id="quickprintbill" value="<?php echo $billnumber; ?>" style="border: 1px solid #001E6A; text-align:right; text-transform:uppercase"  size="7"  />
                <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                <input name="print4inch2" type="hidden" class="button" id="print4inch2" style="border: 1px solid #001E6A" 
				  onClick="return quickprintbill1sales()" value="Print 40" accesskey="p"/>
                </font></font></font></font></font></font></font></font></font>                <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="print4inch" type="button" class="button" id="print4inch" style="border: 1px solid #001E6A" 
				  onClick="return quickprintbill2sales()" value="View 40" accesskey="p"/>
                  <input onClick="return loadprintpage1('A4<?php //echo $previousbillnumber; ?>')" value="View A4" 
				  name="printA4" type="button" class="button" id="printA4" style="border: 1px solid #001E6A"/>
                  <input onClick="return loadprintpage1('A5<?php //echo $previousbillnumber; ?>')" value="View A5" 
				  name="printA5" type="button" class="button" id="printA5" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></font></font></font></font></span></div>
				</td>
			 </tr>-->
			 
            </tbody>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
          
            <!-- NEW CODE STARTS -->
             <tr>
	   
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
			<td colspan="6" bgcolor="#ecf0f5" class="bodytext311"><strong>Advance Deposits</strong></td>
			
				</tr>
			 <tr>
               <td width="5%"align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> No </strong></div></td>
		
				 <td width="22%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				
				 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount  </strong></div></td>
                 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bal Amt</strong></div></td>
				 <!-- <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Select </strong></div></td> -->
		
              </tr>
			  <?php
			   $colorloopcount ='';
			   $sno = '';
			   
			  $query43 = "select patientname,patientcode,sum(transactionamount) amt from master_transactionadvancedeposit where patientcode='$patientcode' and recordstatus='' group by patientcode";
			  $exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num43 = mysqli_num_rows($exec43);
			  while($res43 = mysqli_fetch_array($exec43))
			  {
			  
			  $patientname1 = $res43['patientname']; 
			  $patientcode1 = $res43['patientcode'];
			
			  $deposit_totalamt = $res43['amt'];
			  $deposit_bal_amt = $deposit_totalamt;//for first time consulation they are same
			  $all_adjust_amt = 0;
			  $all_refund_amt = 0;
			  // 
			 // $deposit_amt_bal_query = "SELECT balamt FROM `adjust_advdeposits` WHERE `patientcode` = '$patientcode' order by id desc limit 1";
			  $deposit_amt_bal_query = "SELECT sum(adjustamount) usedamt FROM `adjust_advdeposits` WHERE `patientcode` = '$patientcode'";
			   $bal_exec = mysqli_query($GLOBALS["___mysqli_ston"], $deposit_amt_bal_query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			   if(mysqli_num_rows($bal_exec) > 0)
			   {
			   	   $bal_res = mysqli_fetch_array($bal_exec);
			   	   $all_adjust_amt = $bal_res['usedamt']; 
			   	   //$deposit_bal_amt = $deposit_totalamt - $all_adjust_amt;
			   	   //$deposit_bal_amt = $bal_res['balamt']; 
			   }
			   $refund_amt_bal_query = "SELECT sum(amount) as refundamt from deposit_refund where patientcode = '$patientcode' and visitcode='' ";
			    $refund_bal_exec = mysqli_query($GLOBALS["___mysqli_ston"], $refund_amt_bal_query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			   if(mysqli_num_rows($refund_bal_exec) > 0)
			   {
			   	   $refund_bal_res = mysqli_fetch_array($refund_bal_exec);
			   	   $all_refund_amt = $refund_bal_res['refundamt']; 
			   	 
			   }
			   $deposit_bal_amt = ($deposit_totalamt - ($all_adjust_amt + $all_refund_amt) );
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
				 <td  align="center" valign="center" class="bodytext31"><?php echo $sno = $sno +1; ?></td>
				 <td  align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname1; ?></div></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $patientcode1; ?></td>
				
				
				<input type="hidden" name="advancedocno[]" id="advancedocno" value="<?php echo $docnum; ?>">
				<td  align="center" valign="center" class="bodytext31" id="adv_dep_total_amt"><?php echo number_format($deposit_totalamt,'2','.',','); ?></td>
				<td  align="center" valign="center" class="bodytext31" id="adv_dep_bal_amt"><strong><?php echo number_format($deposit_bal_amt,'2','.',','); ?></strong></td>
				<input type="hidden" name="net_deposit_amt" id="net_deposit_amt" value="<?php echo $deposit_bal_amt; ?>" />
				<input type="hidden" name="hid_bal_amt" id="hid_bal_amt" value="<?php echo $deposit_bal_amt; ?>" />
			<!-- <td  align="center" valign="center" class="bodytext31"><input type="checkbox" name="ack[]" id="ack<?php echo $sno; ?>" onClick="return funpaymentamount('<?php echo $sno; ?>','<?php echo $transactionamount; ?>')"></td> -->
				</tr>
				<?php 
				}
				if($num43 == 0)
				{ ?>
					<tr><td class="bodytext31" colspan="6" align="center">There are No Advance Deposits Found</td>
						<input type="hidden" name="has_adv_deposit_amt" id="has_adv_deposit_amt" value="0" >
						<input type="hidden" name="adv_dep_total_amt" id="adv_dep_total_amt" value="0" />
			  		<input type="hidden" name="net_deposit_amt" id="net_deposit_amt" value="0" />
					<input type="hidden" name="hid_bal_amt" id="hid_bal_amt" value="0" />
					</tr>
				<?php }
				else
				{ ?>
					<input type="hidden" name="has_adv_deposit_amt" id="has_adv_deposit_amt" value="1" >
				<?php }
				?>
			</tbody>
			</table>
		</td>
      </tr>
            <!-- NEW CODE ENDS -->
              <tr>
              <td width="54%" align="left" valign="top" ><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
               <strong>User Name</strong><input type="text" name="username" value="<?php echo $username; ?>" size="5">
			    <input name="Button1" type="hidden" class="button" id="Button1" accesskey="c" style="border: 1px solid #001E6A" onClick="return funcRedirectWindow1()" value="Clear All"/>
                <input type="hidden" name="customersearch2" onClick="javascript:customersearch1('sales')" value="Customer Alt+M" accesskey="m" style="border: 1px solid #001E6A">
                <span class="bodytext31">
                <input type="hidden" name="itemsearch22" onClick="javascript:itemsearch1('sales')" style="border: 1px solid #001E6A">
                <span class="bodytext3">
				<?php
				if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
				//$src = $_REQUEST["src"];
				if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
				//$st = $_REQUEST["st"];
				if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
				//$previousbillnumber = $_REQUEST["billnumber"];
				
				if ($src == 'frm1submit1' && $st == 'success')
				{
				?>
				<!--
                <input onClick="return loadprintpage1('<?php echo $previousbillnumber; ?>')" value="A4 View Bill <?php echo $previousbillnumber; ?>" name="Button12" type="button" class="button" id="Button12" style="border: 1px solid #001E6A"/>
				-->
				<?php
				}
				?>
                </span></span></font></font></font></font></font></td>
              <!--
			  <td width="46%" align="left" valign="top" ><div align="right"><span class="bodytext31">
                <strong>Print Bill No: </strong>
                <input name="quickprintbill" id="quickprintbill" value="<?php echo $billnumber; ?>" style="border: 1px solid #001E6A; text-align:right; text-transform:uppercase"  size="7"  />
                <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                <input name="print4inch2" type="button" class="button" id="print4inch2" style="border: 1px solid #001E6A" 
				  onClick="return quickprintbill1sales()" value="Print 40" accesskey="p"/>
                </font></font></font></font></font></font></font></font></font>                <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="print4inch" type="button" class="button" id="print4inch" style="border: 1px solid #001E6A" 
				  onClick="return quickprintbill2sales()" value="View 40" accesskey="p"/>
                  <input onClick="return loadprintpage1('A4<?php //echo $previousbillnumber; ?>')" value="View A4" 
				  name="printA4" type="button" class="button" id="printA4" style="border: 1px solid #001E6A"/>
                  <input onClick="return loadprintpage1('A5<?php //echo $previousbillnumber; ?>')" value="View A5" 
				  name="printA5" type="button" class="button" id="printA5" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></font></font></font></font></span></div></td>
				-->
			
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
</form>
<script type="text/javascript">
function getEncAmount(){
	var amount = document.getElementById('creditamount').value;
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
var amount = document.getElementById('cardamount').value;
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
    $encrypted =openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);} ?>
<!-- iPayments Encryption End -->
<!-- iPayments Mobile Start -->
<?php
    function iPayment_mobileTrim($data){
        return ($data!="")?"254".substr($data, -9):"";
    }
?>
<!-- iPayments Mobile End -->
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
<?php 
ob_end_flush();
?>
