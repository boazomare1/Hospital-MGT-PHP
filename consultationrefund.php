<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
//echo $menu_id;
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
$updatedate = date("Y-m-d");
$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	$patientname = $_REQUEST["patientname"];
	if(isset($_REQUEST['billnumbers']))
		$billnumbers=$_REQUEST['billnumbers'];
	else
		$billnumbers='';

	$query3 = "select * from master_company where companystatus = 'Active'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$paynowbillprefix = 'OPR-';
	$paynowbillprefix1=strlen($paynowbillprefix);
	$query2 = "select * from refund_consultation order by auto_number desc limit 0, 1";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$billnumber = $res2["billnumber"];
	$billdigit=strlen($billnumber);
	if ($billnumber == '')
	{
		$billnumbercode =$paynowbillprefix.'1';
		$openingbalance = '0.00';
	}
	else
	{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
	$billnumber = $billnumbercode;

	$billtype = $_REQUEST['patienttype'];
	$accountname= $_REQUEST['accountname'];
	$totalamount=$_REQUEST['totalamount'];
	$billdate=$_REQUEST['billdate'];
	$referalname=$_REQUEST['referalname'];
	$paymentmode = $_REQUEST['billtype'];
	$chequenumber = $_REQUEST['chequenumber'];
	$chequedate = $_REQUEST['ADate1'];
	$bankname = $_REQUEST['bankname'];
	$bankbranch = $_REQUEST['bankbranch'];
	$remarks = $_REQUEST['remarks'];
	$card = $_REQUEST['cardname'];
	$cardnumber = $_REQUEST['cardnumber'];
	$bankname1 = $_REQUEST['bankname1'];
	$cashgivenbycustomer = $_REQUEST['cashgivenbycustomer'];
	$cashgiventocustomer = $_REQUEST['cashgiventocustomer'];
	$cashamount = $_REQUEST['cashamount'];
	$onlineamount = $_REQUEST['onlineamount'];
	$chequeamount = $_REQUEST['chequeamount'];
	$cardamount = $_REQUEST['cardamount'];
	$creditamount = $_REQUEST['creditamount'];
	$consultationcoa = $_REQUEST['consultationcoa'];
	$cashcoa = $_REQUEST['cashcoa'];
	$chequecoa = $_REQUEST['chequecoa'];
	$cardcoa = $_REQUEST['cardcoa'];
	$mpesacoa = $_REQUEST['mpesacoa'];
	$onlinecoa = $_REQUEST['onlinecoa'];
	$docno = $_SESSION['docno'];
	$doctorcode = $_REQUEST['doctorcode'];
	$doctorname = $_REQUEST['doctorname'];
	$consultation_percentage = $_REQUEST['consultationperc'];
	$against_refbill = $_REQUEST['against_refbill'];
	
	$sharingamount = $_REQUEST['sharingamt'];
	$mpesanumber = $_REQUEST['mpesanumber'];
	$billstatus = 'paid';
	$doctorstatus = 'unpaid';
	if($paymentmode == 'CASH'){$cashamount=$totalamount;} else {$cashamount='0';}
	if($paymentmode == 'ONLINE'){$onlineamount=$totalamount;} else {$onlineamount='0';}
	if($paymentmode == 'CHEQUE'){$chequeamount=$totalamount;} else {$chequeamount='0';}
	if($paymentmode == 'CREDIT CARD'){$ccamount=$totalamount;} else {$ccamount='0';}
	if($paymentmode == 'MPESA'){$creditamount=$totalamount;} else {$creditamount='0';}

	$query10 = "select ledger_id from finance_ledger_mapping where auto_number = '6'";
	$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res10 = mysqli_fetch_array($exec10);
	$coa = $res10['ledger_id'];
						
	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname limit 0,1";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1 = mysqli_fetch_array($exec1))
	{
	$locationname = $res1["locationname"];
	$locationcode = $res1["locationcode"];
	}
		$query22 = "insert into refund_consultation(billdate,patientcode,patientname,patientvisitcode,consultation,consultationcoa,accountname,billnumber,ipaddress,username,billtype,locationcode,locationname,doctorcode,doctorname,consultation_percentage,sharingamount,against_refbill)values('$dateonly','$patientcode','$patientname','$visitcode','$totalamount','$consultationcoa','$accountname','$billnumber','$ipaddress','$username','$billtype','$locationcode','$locationname','$doctorcode','$doctorname','$consultation_percentage','$sharingamount','$against_refbill')";
	    $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	    $query23 = "insert into billing_ipprivatedoctor_refund(docno, patientname, patientcode, visitcode, accountname, description, doccoa, coa, quantity, rate, amount, recordtime, recorddate, username, billstatus, doctorstatus, billtype, locationname, locationcode, transactionamount, cashamount, chequeamount, cardamount, onlineamount, creditamount, transactionmode, rateuhx, amountuhx, doctorcode, doctorname, visittype, original_amt, percentage, sharingamount, against_refbill) VALUES ('$billnumber', '$patientname', '$patientcode', '$visitcode', '$accountname','$doctorname','$doctorcode', '$coa', '1', '$sharingamount', '$sharingamount', '$timeonly', '$dateonly', '$username', '$billstatus', '$doctorstatus', '$billtype', '$locationname', '$locationcode', '$sharingamount', '$cashamount', '$chequeamount', '$ccamount', '$onlineamount', '$creditamount', '$paymentmode', '$sharingamount', '$sharingamount', '$doctorcode', '$doctorname', 'OP', '$totalamount', '$consultation_percentage', '$sharingamount','$against_refbill')";
	    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
		$transactionmode = $paymentmode;
		if ($transactionmode == 'TDS')
		{
			$transactiontype = 'TDS';
		}
		else
		{
			$transactiontype = 'PAYMENT';
		}
		$transactionmodule = 'PAYMENT';
		if ($paymentmode == 'CASH')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	
		
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $cashcode = $res55['ledgercode'];
		
		$query9 = "insert into refund_paynow (transactiondate, particulars, 
		transactionmode, transactiontype, transactionamount, cashamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,transactiontime,cashcode,locationcode,locationname) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$totalamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$timeonly','$cashcode','$locationcode','$locationname')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$dateonly','$ipaddress','$username','$totalamount','$cashcoa','consultationrefund')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		}
	/*	if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	
		
		$query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
		 
		$query9 = "insert into refund_paynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount, onlineamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,transactiontime,bankcode,locationcode,locationname) 
		values ('$billdate','$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$totalamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$timeonly','$bankcode','$locationcode','$locationname')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$dateonly','$ipaddress','$username','$totalamount','$onlinecoa','consultationrefund')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}*/
		/*if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;	
		
		$query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
		 	
		$query9 = "insert into refund_paynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		chequeamount,chequenumber, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,transactiontime,bankcode,locationcode,locationname) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$totalamount','$chequenumber',  '$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$timeonly','$bankcode','$locationcode','$locationname')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$dateonly','$ipaddress','$username','$totalamount','$chequecoa','consultationrefund')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}*/
	/*if($paymentmode == 'CREDIT CARD')
	{
	$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT CARD';
		$particulars = 'BY CREDIT CARD '.$billnumberprefix.$billnumber;	
		
		$query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
		 	
		$query9 = "insert into refund_paynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		cardamount, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,creditcardname,creditcardnumber,creditcardbankname,transactiontime,bankcode,locationcode,locationname) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$totalamount',  '$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$card','$cardnumber','$bankname1','$timeonly','$bankcode','$locationcode','$locationname')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$dateonly','$ipaddress','$username','$totalamount','$cardcoa','consultationrefund')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		
		}*/
		
		/*if($paymentmode == 'SPLIT')
	{
	$transactiontype = 'PAYMENT';
		$transactionmode = 'SPLIT';
		$particulars = 'BY SPLIT'.$billnumberprefix.$billnumber;
		
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $cashcode = $res55['ledgercode'];
		 
		 $query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
		 $exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die ("Error in Query551".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res551 = mysqli_fetch_array($exec551);
		 $bankcode = $res551['ledgercode'];
		 
		 $query552 = "select * from financialaccount where transactionmode = 'MPESA'";
		 $exec552 = mysqli_query($GLOBALS["___mysqli_ston"], $query552) or die ("Error in Query552".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res552 = mysqli_fetch_array($exec552);
		 $mpesacode = $res552['ledgercode'];	
		
		$query9 = "insert into refund_paynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		cardamount, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,creditcardname,creditcardnumber,creditcardbankname,transactiontime,cashgivenbycustomer,cashgiventocustomer,cashamount,onlineamount,chequeamount,chequenumber,creditamount,cashcode, bankcode, mpesacode,locationcode,locationname,mpesanumber) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$cardamount',  '$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$card','$cardnumber','$bankname1','$timeonly','$cashgivenbycustomer','$cashgiventocustomer','$cashamount','$onlineamount','$chequeamount','$chequenumber','$creditamount','$cashcode','$bankcode','$mpesacode','$locationcode','$locationname','$mpesanumber')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,cash,cashcoa,cheque,chequecoa,online,onlinecoa,mpesa,mpesacoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$dateonly','$ipaddress','$username','$cardamount','$cardcoa','$cashamount','$cashcoa','$chequeamount','$chequecoa','$onlineamount','$onlinecoa','$creditamount','$mpesacoa','consultationrefund')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
	}*/
		/*if($paymentmode == 'MPESA')
	{*/
$transactiontype = 'PAYMENT';
$transactionmode = 'CASH';
$particulars = 'BY CASH'.$billnumberprefix.$billnumber;	
/*
$query55 = "select * from financialaccount where transactionmode = 'MPESA'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$mpesacode = $res55['ledgercode'];
*/
$query9 = "insert into refund_paynow (transactiondate, particulars,
transactionmode, transactiontype, transactionamount, creditamount,
billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,transactiontime,bankcode,locationcode,locationname,mpesanumber) 
values ('$billdate','$particulars', 
'$transactionmode', '$transactiontype', '$totalamount', '$totalamount', 
'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$timeonly','$paymentmode','$locationcode','$locationname','$mpesanumber')";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,mpesacoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$dateonly','$ipaddress','$username','$totalamount','$mpesanumber','consultationrefund')";
$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	//}
mysqli_query($GLOBALS["___mysqli_ston"], "update master_billing set refund_status='completed' where visitcode='$visitcode' and billnumber='$billnumbers'");
	
	
		header("location:patientbillingstatus_ref.php");
		exit;
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
$billnumbers='';

if(isset($_REQUEST["billnumber"]))
{
$billnumbers=$_REQUEST["billnumber"];
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
$res99 = mysqli_fetch_array($exec99);
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
<?php $Querylab=mysqli_query($GLOBALS["___mysqli_ston"],"select * from master_customer where customercode='$patientcode'") or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$execlab=mysqli_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];
 $billtype = $execlab['billtype'];

$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"],"select * from master_paymenttype where auto_number='$patienttype'") or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"],"select * from master_subtype where auto_number='$patientsubtype'") or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$patientplan=$execlab['planname'];
$queryplan=mysqli_query($GLOBALS["___mysqli_ston"],"select * from master_planname where auto_number='$patientplan'") or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$execplan=mysqli_fetch_array($queryplan);
$patientplan1=$execplan['planname'];
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"],"select * from master_customer where customercode='$patientcode'") or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"],"select * from master_accountname where auto_number='$patientaccount'") or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

$query76 = "select * from master_financialintegration where field='consultationfeerefund'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"],$query76) or die ("Error in query76".mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$consultationcoa = $res76['code'];

$query765 = "select * from master_financialintegration where field='cashconsultationrefund'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"],$query765)  or die ("Error in query765".mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeconsultationrefund'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"],$query766)  or die ("Error in query766".mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaconsultationrefund'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"],$query767)  or die ("Error in query767".mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardconsultationrefund'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"],$query768)  or die ("Error in query768".mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineconsultationrefund'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"],$query769)  or die ("Error in query769".mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);

$onlinecoa = $res769['code'];

?>

<?php 
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'OPR-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from refund_consultation order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

$query10 = "select * from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
$res10 = mysqli_fetch_array($exec10);
$consultingdoccode = $res10['consultingdoctorcode'];

$query11 = "select * from master_doctor where doctorcode = '$consultingdoccode'";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$doctorname = $res11['doctorname'];
$consultationpercentage = $res11['consultation_percentage'];

$query101 = "select * from billing_consultation where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and billnumber='$billnumbers'";
$exec101 = mysqli_query($GLOBALS["___mysqli_ston"], $query101) or die("Error in Query101".mysqli_error($GLOBALS["___mysqli_ston"]));
$res101 = mysqli_fetch_array($exec101);
$res101billnumber = $res101['billnumber'];


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
	funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	
	funcPopupPrintFunctionCall();
	
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
<?php eval(base64_decode('IGluY2x1ZGUgKCJqcy9zYWxlczFzY3JpcHRpbmcxcmVmdW5kLnBocCIpOyA=')); ?>
</script>
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
function balancecalc(mode)
{
var mode = mode;
var cashamount = document.getElementById("cashamount").value;
//alert(cashamount);
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
var mpesaamount = document.getElementById("creditamount").value;
if(mpesaamount == '')
{
mpesaamount = 0;
}
var balance =  document.getElementById("subtotal").value;
var totalamount = parseFloat(cashamount)+parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount);
var newbalance=parseFloat(balance) - parseFloat(totalamount);
if(newbalance < 0)
{
alert("Entered Amount is greater than Bill Amount");
if(mode == '1')
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
          
return false;
}
document.getElementById("tdShowTotal").innerHTML = newbalance.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
;
}
</script>
<script>
function printConsultationRefund()
 {
var popWin; 
popWin = window.open("print_consultationrefund_dmp4inch1.php?patientcode=<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRjb2RlOyA=')); ?>&&billautonumber=<?php eval(base64_decode('IGVjaG8gJGJpbGxudW1iZXJjb2RlOyA=')); ?>&&locationcode=LTC-1","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
 }
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
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
<script src="js/datetimepicker_css.js"></script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="consultationrefund.php" onKeyDown="return disableEnterKey(event)" onSubmit="return printConsultationRefund();">
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
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                <td colspan="7" bgcolor="#ecf0f5" class="bodytext32"><strong>Patient Details</strong></td>
			 </tr>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			  <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHBhdGllbnRuYW1lOyA=')); ?>
				<input type="hidden" name="patientname" id="customer" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRuYW1lOyA=')); ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>                  </td>
                 
             <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Bill No</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGJpbGxudW1iZXJjb2RlOyA=')); ?>
				<input type="hidden" name="billno" id="billno" value="<?php eval(base64_decode('IGVjaG8gJGJpbGxudW1iZXJjb2RlOyA=')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="account" id="account" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnR0eXBlMTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="patienttype" id="patienttype" value="<?php eval(base64_decode('IGVjaG8gJGJpbGx0eXBlOyA=')); ?>">	
				  <input type="hidden" name="consultationcoa" value="<?php eval(base64_decode('IGVjaG8gJGNvbnN1bHRhdGlvbmNvYTsg')); ?>">
				
				<input type="hidden" name="cashcoa" value="<?php eval(base64_decode('IGVjaG8gJGNhc2hjb2E7IA==')); ?>">

				<input type="hidden" name="billnumbers" value="<?php echo $billnumbers; ?>">

				<input type="hidden" name="chequecoa" value="<?php eval(base64_decode('IGVjaG8gJGNoZXF1ZWNvYTsg')); ?>">
				<input type="hidden" name="mpesacoa" value="<?php eval(base64_decode('IGVjaG8gJG1wZXNhY29hOyA=')); ?>">
				<input type="hidden" name="cardcoa" value="<?php eval(base64_decode('IGVjaG8gJGNhcmRjb2E7IA==')); ?>">
				<input type="hidden" name="onlinecoa" value="<?php eval(base64_decode('IGVjaG8gJG9ubGluZWNvYTsg')); ?>">		</td>
				<input type="hidden" name="doctorcode" value="<?php echo $consultingdoccode; ?>">		</td>
				<input type="hidden" name="doctorname" value="<?php echo $doctorname; ?>">		</td>
				<input type="hidden" name="consultationperc" value="<?php echo $consultationpercentage; ?>">
				<input type="hidden" name="against_refbill" value="<?php echo $res101billnumber; ?>">				</td>
		      </tr>
			   <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHBhdGllbnRjb2RlOyA=')); ?>
				<input type="hidden" name="customercode" id="customercode" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRjb2RlOyA=')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php eval(base64_decode('IC8vZWNobyAkcmVzNDFkZWxpdmVyeWFkZHJlc3M7IA==')); ?></textarea>--></td>
				    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Bill Date</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGRhdGVvbmx5OyA=')); ?>
				<input type="hidden" name="billdate" id="billdate" value="<?php eval(base64_decode('IGVjaG8gJGRhdGVvbmx5OyA=')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
              	<input type="hidden" name="account" id="account" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRzdWJ0eXBlMTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
			  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHZpc2l0Y29kZTsg')); ?>
				<input type="hidden" name="visitcode" id="visitcode" value="<?php eval(base64_decode('IGVjaG8gJHZpc2l0Y29kZTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHBhdGllbnRhY2NvdW50MTsg')); ?>
				<input type="hidden" name="accountname" id="account" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRhY2NvdW50MTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  </tr>
                  <input type="hidden" name="account" id="account" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRwbGFuMTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
				  <input type="hidden" name="account" id="account" value="" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
				 
				  	<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
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
                <td colspan="8" bgcolor="#ecf0f5" class="bodytext32"><strong>Transaction Details</strong></td>
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
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
				<td width="1%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
                  </tr>
 <?php  
			  
			$query89 = "select * from master_billing where visitcode='$visitcode' and patientcode='$patientcode' and billnumber='$billnumbers'";
			$exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res89 = mysqli_fetch_array($exec89);
			
			$consultationdate=$res89['consultationdate'];
			$patientbillamount = $res89['patientbillamount'];
			
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
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNubyA9ICRzbm8gKyAxOyA=')); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJGNvbnN1bHRhdGlvbmRhdGU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHZpc2l0Y29kZTsg')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php eval(base64_decode('IGVjaG8gJ09QIENvbnN1bHRhdGlvbic7IA==')); ?></div></td>
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($patientbillamount, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($patientbillamount, 2, '.', ','); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
			   </tr>
             
				 <?php eval(base64_decode('ICR0b3RhbGFtb3VudCA9ICRwYXRpZW50YmlsbGFtb3VudDsg')); ?>
				 <?php
				 	$sharingamt = ($patientbillamount*$consultationpercentage)/100;
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
                bgcolor="#ecf0f5"><strong>Total</strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php eval(base64_decode('IGVjaG8gJHBhdGllbnRiaWxsYW1vdW50OyA=')); ?></strong>
                <input type="hidden" name="sharingamt" value="<?php echo $sharingamt; ?>">
            	</td>
				 <td width="4%"  align="left" valign="center" 
               class="bodytext31" bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>
             
			 </tr>
          </tbody>
        </table>		</td>
		</tr>
		<tr>
		 <td colspan="7" class="bodytext31" valign="center"  align="left" >&nbsp;</td>
		</tr>
		<tr>
		<td>
		<table width="99%" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" bgcolor="#F3F3F3" id="AutoNumber3" style="BORDER-COLLAPSE: collapse">
            <tbody id="foo">
              <tr>
                <td width="1%" align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td colspan="4" rowspan="10" align="left" valign="top"  
                bgcolor="#F3F3F3" class="bodytext31">		
				<!--<table width="99%" border="0" align="right" cellpadding="2" cellspacing="0"  style="BORDER-COLLAPSE: collapse">
				<tr>
				  <td width="53%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong> Disc %                  </strong></span></div></td>
				  <td><span class="bodytext311"><strong>
				    <input name="allitemdiscountpercent" id="allitemdiscountpercent" onKeyUp="return funcAllItemDiscountApply1()" 
				style="border: 1px solid #001E6A; text-align:right;" value="0.00" size="4" />
				  <input name="allitemdiscountpercent1" id="allitemdiscountpercent1" onKeyUp="return funcAllItemDiscountApply1()" 
				style="border: 1px solid #001E6A; text-align:right;background-color:#ecf0f5" value="0.00" size="4"  />
				  <input name="subtotaldiscountpercent" id="subtotaldiscountpercent" onKeyDown="return funcResetPaymentInfo1()" 
					 type="hidden" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8" />
				    <input name="totaldiscountamount" id="totaldiscountamount" value="0.00" type="hidden" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" />
				    <input type="hidden" name="subtotaldiscountrupees" id="subtotaldiscountrupees" onKeyDown="return funcResetPaymentInfo1()" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8" />
				    <input type="hidden" name="afterdiscountamount" id="afterdiscountamount" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" />
				  </strong></span></td>
				  </tr>
				 
				  <tr bordercolor="#f3f3f3">
                    <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>  Disc Amt </strong></span></div></td>
				    <td><span class="bodytext311"><strong>
                      <input name="totaldiscountamountonlyapply1" id="totaldiscountamountonlyapply1" onKeyUp="return funcDiscountAmountCalc1()" 
				type="text" style="border: 1px solid #001E6A; text-align:right;" value="0.00" size="4" />
                      <input name="totaldiscountamountonlyapply2" id="totaldiscountamountonlyapply2" onKeyUp="return funcDiscountAmountCalc1()" readonly  
				type="text" style="border: 1px solid #001E6A; text-align:right; background-color:#ecf0f5" value="0.00" size="4" />
                    </strong></span></td>
				    </tr>
			
				  
 				
				  <tr>
                    <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><span class="bodytext311">
                     
                    </span>
                      <div align="right"><strong><?php eval(base64_decode('IC8vLicgJy4kcmVzNnRheHBlcmNlbnQuJyUnOyA=')); ?></strong></div></td>
                    <td width="39%"><span class="bodytext312">
                     
                    </span></td>
                  </tr>
                </table>-->						  </td>
				<?php eval(base64_decode('DQoJCQkJDQoJCQkJJG9yaWdpbmFsYW1vdW50ID0gJHRvdGFsYW1vdW50Ow0KCQkJICAkdG90YWxhbW91bnQgPSByb3VuZCgkdG90YWxhbW91bnQvNSwyKSo1Ow0KCQkJICAkcm91bmRvZmZhbW91bnQgPSAkb3JpZ2luYWxhbW91bnQgLSAkdG90YWxhbW91bnQ7DQoJCQkgICRyb3VuZG9mZmFtb3VudCA9IG51bWJlcl9mb3JtYXQoJHJvdW5kb2ZmYW1vdW50LDIsJy4nLCcnKTsNCgkJCSAgJHJvdW5kb2ZmYW1vdW50ID0gLSgkcm91bmRvZmZhbW91bnQpOw0KCQkJICAkdG90YWxhbW91bnQgPSBudW1iZXJfZm9ybWF0KCR0b3RhbGFtb3VudCwyLCcuJywnJyk7DQoJCQkgIA==')); ?>
                <td width="2%" rowspan="3" align="right" valign="top"  
                bgcolor="#F3F3F3" class="style1" id="tdShowTotal">
				<?= number_format($totalamount,2,'.',','); ?>
				</td>
                <td width="11%" align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Sub Total </strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="top" bgcolor="#F3F3F3" ><span class="bodytext31">
                  <input name="subtotal" id="subtotal" value="<?php eval(base64_decode('IGVjaG8gJG9yaWdpbmFsYW1vdW50OyA=')); ?>" style="text-align:right" size="8"  readonly="readonly" />
                </span></td>
				
                <td align="left" valign="top" bgcolor="#F3F3F3" width="10%">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="12%"><div align="right"><strong>Bill Amt </strong></div></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="9%"><span class="bodytext311">
                  <input name="totalamount" id="totalamount" value="<?php eval(base64_decode('IGVjaG8gJHRvdGFsYW1vdW50OyA=')); ?>" style="text-align:right" size="8"  readonly="readonly" />
                </span></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="23%">&nbsp;</td>
              </tr>
			  
              <tr>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Round Off </strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="top" bgcolor="#F3F3F3" ><span class="bodytext311">
				 <input name="roundoff" id="roundoff" value="<?php eval(base64_decode('IGVjaG8gJHJvdW5kb2ZmYW1vdW50OyA=')); ?>" style="text-align:right"  readonly="readonly" size="8"/>
                  <input name="totalaftercombinediscount" id="totalaftercombinediscount" value="0.00" style="text-align:right" size="8"  readonly="readonly" type="hidden"/>
                </span></td>
                <td align="left" valign="top" bgcolor="#F3F3F3" width="10%">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="12%"><div align="right"><strong>Nett Amt</strong></div></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="6%">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="9%"><span class="bodytext31">
                  <input name="nettamount" id="nettamount" value="<?php eval(base64_decode('IGVjaG8gJHRvdGFsYW1vdW50OyA=')); ?>" style="text-align:right" size="8" readonly />
                </span></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="23%">&nbsp;</td>
              </tr>
                <input type="hidden" name="totalaftertax" id="totalaftertax" value="0.00"  onKeyDown="return disableEnterKey()" onBlur="return funcSubTotalCalc()" style="text-align:right" size="8"  readonly="readonly"/>
              
               
              <tr>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Mode </strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><select name="billtype" id="billtype" onChange="return paymentinfo()">
                    <option value="<?php echo  '02-2000-12'; ?>" ><?php echo 'Patient Refunds'; ?></option>
                </select></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="10%">&nbsp;</td>
                <td align="left" valign="middle" bgcolor="#F3F3F3" class="bodytext31" width="12%">
				<!--<select name="billtype" id="billtype" onChange="return paymentinfo()" onFocus="return funcbillamountcalc1()">--></td>
                
                <td align="left" valign="middle" bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="middle" bgcolor="#F3F3F3" width="9%">&nbsp;</td>
                <td align="left" valign="middle" bgcolor="#F3F3F3" width="23%">&nbsp;</td>
              </tr>
			  <tr>
			   <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
			  </tr>
			  <tr>
			   <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
			  </tr>
              <tr id="cashamounttr">
			 
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="right" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash </strong></div></td>
                                <td width="6%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cashamount" id="cashamount" onBlur="return funcbillamountcalc1()" tabindex="1" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('1')"/></td>
                                <td width="15%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash Returned </strong></div></td>
                <td width="10%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cashgivenbycustomer" id="cashgivenbycustomer" onKeyUp="return funcbillamountcalc1()" onFocus="" tabindex="2" style="text-align:right" size="8" autocomplete="off" readonly/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="12%"><div align="right"><strong>&nbsp;  </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="6%"><input type="hidden" name="cashgiventocustomer" id="cashgiventocustomer" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8" readonly  /></td>
               
               
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="9%">&nbsp;</td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="23%">&nbsp;</td>
              </tr>
			
              <tr id="creditamounttr">
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="creditamount" id="creditamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('2')"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA No. </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="mpesanumber" id="mpesanumber" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="12%"></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="6%"></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="9%"></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="23%"></td>
                <td width="1%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
              </tr>
              <tr id="chequeamounttr">
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cheque  </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="chequeamount" id="chequeamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('3')"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Chq No. </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="chequenumber" id="chequenumber" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="12%"><div align="right"><strong> Date </strong></div></td>
                <td width="6%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">  <input name="chequedate" id="chequedate" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td width="9%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Bank  </strong></div></td>
                <td width="23%" align="left" valign="center"  
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
bgcolor="#F3F3F3" class="bodytext31"><input name="cardamount" id="cardamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('4')"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Card No </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="cardnumber" id="cardnumber" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td width="12%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Name  </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="6%"><input type="text" name="cardname" id="cardname" size="8" style="text-align:left;">
                <!--<select name="cardname" id="cardname">
                  <option value="">SELECT CARD</option>
                  <?php 
				$querycom="select * from master_creditcard where status <> 'deleted'";
				$execcom=mysqli_query($GLOBALS["___mysqli_ston"], $querycom) or die("Error in querycom".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rescom=mysqli_fetch_array($execcom))
				{
				$creditcardname=$rescom["creditcardname"];
				 ?>
                  <option value="<?php eval(base64_decode('IGVjaG8gJGNyZWRpdGNhcmRuYW1lOw==')); ?>"><?php eval(base64_decode('IGVjaG8gJGNyZWRpdGNhcmRuYW1lOw==')); ?></option>
                  <?php 
				}
				 ?>
                </select>--></td>
                <td align="left" valign="center" class="bodytext31" width="9%"><div align="right"><strong> Bank  </strong></div></td>
                <td align="left" valign="center" class="bodytext31" width="23%"><input name="bankname1" id="bankname" value="" style="text-align:left; text-transform:uppercase"  size="8"  /></td>
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
                 class="bodytext31" width="10%"><input name="onlinenumber" id="onlinenumber" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
                 class="bodytext31" width="12%">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="9%">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="23%">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
              </tr>
				
              
              
              
              <tr>
                
                <td colspan="14" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                  <input name="delbillst" id="delbillst" type="hidden" value="billedit">
                  <input name="delbillautonumber" id="delbillautonumber" type="hidden" value="<?php eval(base64_decode('IGVjaG8gJGRlbGJpbGxhdXRvbnVtYmVyOw==')); ?>">
                  <input name="delbillnumber" id="delbillnumber" type="hidden" value="<?php eval(base64_decode('IGVjaG8gJGRlbGJpbGxudW1iZXI7')); ?>">
				  <input name="Submit2223" type="submit" onClick="return funcSaveBill1()" value="Save Bill" accesskey="b" class="button"/>
                </font></font></font></font></font></div></td>
              </tr>
			  
			 <!-- <tr>
                <td colspan="8" class="bodytext32">
				<div align="right"><span class="bodytext31">
                <strong>Print Bill No: </strong>
                <input name="quickprintbill" id="quickprintbill" value="<?php eval(base64_decode('IGVjaG8gJGJpbGxudW1iZXI7IA==')); ?>" style="border: 1px solid #001E6A; text-align:right; text-transform:uppercase"  size="7"  />
                <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                <input name="print4inch2" type="hidden" class="button" id="print4inch2" style="border: 1px solid #001E6A" 
				  onClick="return quickprintbill1sales()" value="Print 40" accesskey="p"/>
                </font></font></font></font></font></font></font></font></font>                <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="print4inch" type="button" class="button" id="print4inch" style="border: 1px solid #001E6A" 
				  onClick="return quickprintbill2sales()" value="View 40" accesskey="p"/>
                  <input onClick="return loadprintpage1('A4<?php eval(base64_decode('IC8vZWNobyAkcHJldmlvdXNiaWxsbnVtYmVyOyA=')); ?>')" value="View A4" 
				  name="printA4" type="button" class="button" id="printA4" style="border: 1px solid #001E6A"/>
                  <input onClick="return loadprintpage1('A5<?php eval(base64_decode('IC8vZWNobyAkcHJldmlvdXNiaWxsbnVtYmVyOyA=')); ?>')" value="View A5" 
				  name="printA5" type="button" class="button" id="printA5" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></font></font></font></font></span></div>
				</td>
			 </tr>-->
			 
            </tbody>
        </table>
		</td>
		</tr>
      
     
   
     
    </table>
</form>
<?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9mb290ZXIxLnBocCIpOyA=')); ?>
<?php eval(base64_decode('IC8vaW5jbHVkZSAoInByaW50X2JpbGxfZG1wNGluY2gxLnBocCIpOyA=')); ?>
</body>
</html>