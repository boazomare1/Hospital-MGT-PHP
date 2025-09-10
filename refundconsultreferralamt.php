<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");include ("includes/check_user_access.php");
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
$docno = $_SESSION['docno'];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
   
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	$locationname = $res["locationname"];
	$res12locationanum = $res["auto_number"];

$query3 = "select * from master_location where status = '' and locationname='$locationname'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
 $locationcode = $res3['locationcode'];
  
$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$patientname=$_REQUEST['customername'];
$dateonly = date("Y-m-d");
foreach($_POST['referalname'] as $key => $value)
{		
	$referalname=$_POST['referalname'][$key];
	$auto_number=$_POST['auto_number'][$key];
	foreach($_POST['ref'] as $check1)
	{
	
	$refund=$check1;
	if($refund == $auto_number)
	{
		$query61 = "select * from master_visitentry where visitcode = '$visitcode' and paymentstatus='completed' and auto_number='$auto_number'";
		$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numb=mysqli_num_rows($exec61);
		$res61 = mysqli_fetch_array($exec61);
		{
		$referalcode = $res61['consultingdoctorcode'];
		$patientcode=$res61['patientcode'];
		$patientname=$res61['patientfullname'];
		//$referalrate=$res61['doctorfees'];
		$referalrate=$_POST['refund'][$key];
		$status1='refund';		
		$paynowbillprefix11="RE-";
		$paynowbillprefix11=strlen($paynowbillprefix11);
		$query2 = "select billnumber from refund_paynowreferal order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$billnumber1 = $res2["billnumber"];
		$billdigit1=strlen($billnumber1);
		if ($billnumber1 == '')
		{
			$billnumbercode1 ='RE-'.'1'."-".date('y');		
		}
		else
		{
			$billnumber1 = $res2["billnumber"];
			$billnumbercode1 = substr($billnumber1,$paynowbillprefix11, $billdigit1);
			$billnumbercode1 = intval($billnumbercode1);
			$billnumbercode1 = $billnumbercode1 + 1;		
			$maxanum1 = $billnumbercode1;		
			$billnumbercode1 = 'RE-'.$maxanum1."-".date('y');
		}

		$query29="update master_visitentry set doctorfeesstatus='$status1' where auto_number='$auto_number' and consultingdoctor='$referalname' and visitcode='$visitcode'";
		$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29);
		
		$query1222 = "insert into refund_paynowreferal(billdate,patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,referalcoa,billtype,accountname,paymentstatus,billnumber,username,locationcode,locationname) values('$dateonly','$patientcode','$patientname','$visitcode','$referalcode','$referalname','$referalrate','$referalcode','PAY NOW','$referalname','completed','$billnumbercode1','$username','$locationcode','$locationname')";
		$exec1222 = mysqli_query($GLOBALS["___mysqli_ston"], $query1222) or die ("Error in Query1222".mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		break;
	}	
	}

}	
	$billnumber = $billnumbercode1;
	$billtype = $_REQUEST['patienttype'];
	$accountname= $_REQUEST['accountname'];
	$totalamount=$_REQUEST['totalamount'];
	$billdate=$_REQUEST['billdate'];
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
	$billdate = date('Y-m-d');
	
	$mpesanumber = $_REQUEST['mpesanumber'];
		
	if($status1=='refund')
	{
  		$query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
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
		
		$query9 = "insert into refund_paynow (transactiondate, particulars, 
		transactionmode, transactiontype, transactionamount, cashamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,transactiontime) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$totalamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$timeonly')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$dateonly','$ipaddress','$username','$totalamount','$cashcoa','consultationrefund')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		}
		if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	
		$query9 = "insert into refund_paynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount, onlineamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,transactiontime) 
		values ('$billdate','$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$totalamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$timeonly')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$dateonly','$ipaddress','$username','$totalamount','$onlinecoa','consultationrefund')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;		
			$query9 = "insert into refund_paynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		chequeamount,chequenumber, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,transactiontime) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$totalamount','$chequenumber',  '$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$timeonly')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$dateonly','$ipaddress','$username','$totalamount','$chequecoa','consultationrefund')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}
	if($paymentmode == 'CREDIT CARD')
	{
	$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT CARD';
		$particulars = 'BY CREDIT CARD '.$billnumberprefix.$billnumber;		
				$query9 = "insert into refund_paynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,

		cardamount, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,creditcardname,creditcardnumber,creditcardbankname,transactiontime) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$totalamount',  '$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$card','$cardnumber','$bankname1','$timeonly')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$dateonly','$ipaddress','$username','$totalamount','$cardcoa','consultationrefund')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	

		
		}
		
		if($paymentmode == 'SPLIT')
	{
	$transactiontype = 'PAYMENT';
		$transactionmode = 'SPLIT';
		$particulars = 'BY SPLIT'.$billnumberprefix.$billnumber;	
		
		$query9 = "insert into refund_paynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		cardamount, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,creditcardname,creditcardnumber,creditcardbankname,transactiontime,cashgivenbycustomer,cashgiventocustomer,cashamount,onlineamount,chequeamount,chequenumber,creditamount,mpesanumber) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$cardamount',  '$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$card','$cardnumber','$bankname1','$timeonly','$cashgivenbycustomer','$cashgiventocustomer','$cashamount','$onlineamount','$chequeamount','$chequenumber','$creditamount','$mpesanumber')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,cash,cashcoa,cheque,chequecoa,online,onlinecoa,mpesa,mpesacoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$dateonly','$ipaddress','$username','$cardamount','$cardcoa','$cashamount','$cashcoa','$chequeamount','$chequecoa','$onlineamount','$onlinecoa','$creditamount','$mpesacoa','consultationrefund')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
	}
		if($paymentmode == 'MPESA')
	{
	$transactiontype = 'PAYMENT';
		$transactionmode = 'MPESA';
		$particulars = 'BY MPESA'.$billnumberprefix.$billnumber;	
		
		$query9 = "insert into refund_paynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount, creditamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,transactiontime,mpesanumber) 
		values ('$billdate','$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$totalamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$timeonly','$mpesanumber')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,source)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$dateonly','$ipaddress','$username','$totalamount','$mpesacoa','consultationrefund')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	

	}
 	}
  header("location:patientbillingstatus_bills.php?patientcode=$patientcode&&visitcode=$visitcode");  
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

<?php eval(base64_decode('DQokUXVlcnlsYWI9bXlzcWxfcXVlcnkoInNlbGVjdCAqIGZyb20gbWFzdGVyX2N1c3RvbWVyIHdoZXJlIGN1c3RvbWVyY29kZT0nJHBhdGllbnRjb2RlJyIpOw0KJGV4ZWNsYWI9bXlzcWxfZmV0Y2hfYXJyYXkoJFF1ZXJ5bGFiKTsNCiAkcGF0aWVudGFnZT0kZXhlY2xhYlsnYWdlJ107DQogJHBhdGllbnRnZW5kZXI9JGV4ZWNsYWJbJ2dlbmRlciddOw0KICRiaWxsdHlwZSA9ICRleGVjbGFiWydiaWxsdHlwZSddOw0KDQokcGF0aWVudHR5cGU9JGV4ZWNsYWJbJ21haW50eXBlJ107DQokcXVlcnl0eXBlPW15c3FsX3F1ZXJ5KCJzZWxlY3QgKiBmcm9tIG1hc3Rlcl9wYXltZW50dHlwZSB3aGVyZSBhdXRvX251bWJlcj0nJHBhdGllbnR0eXBlJyIpOw0KJGV4ZWN0eXBlPW15c3FsX2ZldGNoX2FycmF5KCRxdWVyeXR5cGUpOw0KJHBhdGllbnR0eXBlMT0kZXhlY3R5cGVbJ3BheW1lbnR0eXBlJ107DQokcGF0aWVudHN1YnR5cGU9JGV4ZWNsYWJbJ3N1YnR5cGUnXTsNCiRxdWVyeXN1YnR5cGU9bXlzcWxfcXVlcnkoInNlbGVjdCAqIGZyb20gbWFzdGVyX3N1YnR5cGUgd2hlcmUgYXV0b19udW1iZXI9JyRwYXRpZW50c3VidHlwZSciKTsNCiRleGVjc3VidHlwZT1teXNxbF9mZXRjaF9hcnJheSgkcXVlcnlzdWJ0eXBlKTsNCiRwYXRpZW50c3VidHlwZTE9JGV4ZWNzdWJ0eXBlWydzdWJ0eXBlJ107DQokcGF0aWVudHBsYW49JGV4ZWNsYWJbJ3BsYW5uYW1lJ107DQokcXVlcnlwbGFuPW15c3FsX3F1ZXJ5KCJzZWxlY3QgKiBmcm9tIG1hc3Rlcl9wbGFubmFtZSB3aGVyZSBhdXRvX251bWJlcj0nJHBhdGllbnRwbGFuJyIpOw0KJGV4ZWNwbGFuPW15c3FsX2ZldGNoX2FycmF5KCRxdWVyeXBsYW4pOw0KJHBhdGllbnRwbGFuMT0kZXhlY3BsYW5bJ3BsYW5uYW1lJ107DQoNCg==')); ?>
<?php eval(base64_decode('DQokcXVlcnlsYWIxPW15c3FsX3F1ZXJ5KCJzZWxlY3QgKiBmcm9tIG1hc3Rlcl9jdXN0b21lciB3aGVyZSBjdXN0b21lcmNvZGU9JyRwYXRpZW50Y29kZSciKTsNCiRleGVjbGFiMT1teXNxbF9mZXRjaF9hcnJheSgkcXVlcnlsYWIxKTsNCiRwYXRpZW50bmFtZT0kZXhlY2xhYjFbJ2N1c3RvbWVyZnVsbG5hbWUnXTsNCiRwYXRpZW50YWNjb3VudD0kZXhlY2xhYjFbJ2FjY291bnRuYW1lJ107DQoNCiRxdWVyeWxhYjI9bXlzcWxfcXVlcnkoInNlbGVjdCAqIGZyb20gbWFzdGVyX2FjY291bnRuYW1lIHdoZXJlIGF1dG9fbnVtYmVyPSckcGF0aWVudGFjY291bnQnIik7DQokZXhlY2xhYjI9bXlzcWxfZmV0Y2hfYXJyYXkoJHF1ZXJ5bGFiMik7DQokcGF0aWVudGFjY291bnQxPSRleGVjbGFiMlsnYWNjb3VudG5hbWUnXTsNCg0KJHF1ZXJ5NzYgPSAic2VsZWN0ICogZnJvbSBtYXN0ZXJfZmluYW5jaWFsaW50ZWdyYXRpb24gd2hlcmUgZmllbGQ9J2NvbnN1bHRhdGlvbmZlZXJlZnVuZCciOw0KJGV4ZWM3NiA9IG15c3FsX3F1ZXJ5KCRxdWVyeTc2KSBvciBkaWUobXlzcWxfZXJyb3IoKSk7DQokcmVzNzYgPSBteXNxbF9mZXRjaF9hcnJheSgkZXhlYzc2KTsNCiRjb25zdWx0YXRpb25jb2EgPSAkcmVzNzZbJ2NvZGUnXTsNCg0KJHF1ZXJ5NzY1ID0gInNlbGVjdCAqIGZyb20gbWFzdGVyX2ZpbmFuY2lhbGludGVncmF0aW9uIHdoZXJlIGZpZWxkPSdjYXNoY29uc3VsdGF0aW9ucmVmdW5kJyI7DQokZXhlYzc2NSA9IG15c3FsX3F1ZXJ5KCRxdWVyeTc2NSkgb3IgZGllKG15c3FsX2Vycm9yKCkpOw0KJHJlczc2NT0gbXlzcWxfZmV0Y2hfYXJyYXkoJGV4ZWM3NjUpOw0KDQokY2FzaGNvYSA9ICRyZXM3NjVbJ2NvZGUnXTsNCg0KDQokcXVlcnk3NjYgPSAic2VsZWN0ICogZnJvbSBtYXN0ZXJfZmluYW5jaWFsaW50ZWdyYXRpb24gd2hlcmUgZmllbGQ9J2NoZXF1ZWNvbnN1bHRhdGlvbnJlZnVuZCciOw0KJGV4ZWM3NjYgPSBteXNxbF9xdWVyeSgkcXVlcnk3NjYpIG9yIGRpZShteXNxbF9lcnJvcigpKTsNCiRyZXM3NjYgPSBteXNxbF9mZXRjaF9hcnJheSgkZXhlYzc2Nik7DQoNCiRjaGVxdWVjb2EgPSAkcmVzNzY2Wydjb2RlJ107DQoNCg0KJHF1ZXJ5NzY3ID0gInNlbGVjdCAqIGZyb20gbWFzdGVyX2ZpbmFuY2lhbGludGVncmF0aW9uIHdoZXJlIGZpZWxkPSdtcGVzYWNvbnN1bHRhdGlvbnJlZnVuZCciOw0KJGV4ZWM3NjcgPSBteXNxbF9xdWVyeSgkcXVlcnk3NjcpIG9yIGRpZShteXNxbF9lcnJvcigpKTsNCiRyZXM3NjcgPSBteXNxbF9mZXRjaF9hcnJheSgkZXhlYzc2Nyk7DQoNCiRtcGVzYWNvYSA9ICRyZXM3NjdbJ2NvZGUnXTsNCg0KJHF1ZXJ5NzY4ID0gInNlbGVjdCAqIGZyb20gbWFzdGVyX2ZpbmFuY2lhbGludGVncmF0aW9uIHdoZXJlIGZpZWxkPSdjYXJkY29uc3VsdGF0aW9ucmVmdW5kJyI7DQokZXhlYzc2OCA9IG15c3FsX3F1ZXJ5KCRxdWVyeTc2OCkgb3IgZGllKG15c3FsX2Vycm9yKCkpOw0KJHJlczc2OCA9IG15c3FsX2ZldGNoX2FycmF5KCRleGVjNzY4KTsNCg0KJGNhcmRjb2EgPSAkcmVzNzY4Wydjb2RlJ107DQoNCiRxdWVyeTc2OSA9ICJzZWxlY3QgKiBmcm9tIG1hc3Rlcl9maW5hbmNpYWxpbnRlZ3JhdGlvbiB3aGVyZSBmaWVsZD0nb25saW5lY29uc3VsdGF0aW9ucmVmdW5kJyI7DQokZXhlYzc2OSA9IG15c3FsX3F1ZXJ5KCRxdWVyeTc2OSkgb3IgZGllKG15c3FsX2Vycm9yKCkpOw0KJHJlczc2OSA9IG15c3FsX2ZldGNoX2FycmF5KCRleGVjNzY5KTsNCg0KJG9ubGluZWNvYSA9ICRyZXM3NjlbJ2NvZGUnXTsNCg0KDQo=')); ?>
<?php 
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix11="RE-";
$paynowbillprefix11=strlen($paynowbillprefix11);
$query2 = "select billnumber from refund_paynowreferal order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber1 = $res2["billnumber"];
$billdigit1=strlen($billnumber1);
if ($billnumber1 == '')
{
	$billnumbercode ='RE-'.'1'."-".date('y');		
}
else
{
	$billnumber1 = $res2["billnumber"];
	$billnumbercode1 = substr($billnumber1,$paynowbillprefix11, $billdigit1);
	$billnumbercode1 = intval($billnumbercode1);
	$billnumbercode1 = $billnumbercode1 + 1;		
	$maxanum1 = $billnumbercode1;		
	$billnumbercode = 'RE-'.$maxanum1."-".date('y');
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

document.getElementById("tdShowTotal").innerHTML = newbalance.toFixed(2);
document.getElementById("tdShowTotal").innerHTML=(document.getElementById("tdShowTotal").innerHTML).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	
}


</script>
<script>
function printConsultationRefund()
 {

var popWin; 
popWin = window.open("print_consultationrefund_dmp4inch1.php?patientcode=<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRjb2RlOyA=')); ?>&&billautonumber=<?php eval(base64_decode('IGVjaG8gJGJpbGxudW1iZXJjb2RlOyA=')); ?>&&ranum=<?php eval(base64_decode('IGVjaG8gKHJhbmQoMTAsMTAwKSk7IA==')); ?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
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
<form name="form1" id="frmsales" method="post" action="refundconsultreferralamt.php" onKeyDown="return disableEnterKey(event)">
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
				<input type="hidden" name="chequecoa" value="<?php eval(base64_decode('IGVjaG8gJGNoZXF1ZWNvYTsg')); ?>">
				<input type="hidden" name="mpesacoa" value="<?php eval(base64_decode('IGVjaG8gJG1wZXNhY29hOyA=')); ?>">
				<input type="hidden" name="cardcoa" value="<?php eval(base64_decode('IGVjaG8gJGNhcmRjb2E7IA==')); ?>">
				<input type="hidden" name="onlinecoa" value="<?php eval(base64_decode('IGVjaG8gJG9ubGluZWNvYTsg')); ?>">		</td>
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
				<!--<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref.No</strong></div></td>-->
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
				<td width="1%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
                  </tr>
 			<?php
			$colorloopcount = '';
			$sno = '';
			$ssno=0;
			$totalamount=0;			
			$query61 = "select * from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode' and doctorfeesrefund <> '0.00' and paymentstatus='completed' and recordstatus=''";
			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb=mysqli_num_rows($exec61);
			while($res61 = mysqli_fetch_array($exec61))
			{
			$referalname =$res61["consultingdoctor"];
			$consultingdate =$res61["consultationdate"];
			$billtype = $res61["billtype"];
			$auto_number = $res61['auto_number'];
			$doctorfees = $res61['doctorfees'];
			$doctorfeesrefund = $res61['doctorfeesrefund'];
			$bal = $doctorfees - $doctorfeesrefund;
			$doctorfeesrefund = number_format($doctorfeesrefund,2,'.','');
			$itemcode=$ssno;
			
			$originalamount = $doctorfeesrefund; 
			$ssno=$ssno + 1;
			
			$sno = $sno + 1;
			?>
  <tr bgcolor="#ecf0f5">
  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultingdate; ?>
        <input type="hidden" name="ref[]" id="ref<?php echo $sno; ?>" value="<?php echo $auto_number; ?>" /></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $referalname;?></div></td>
		<input type="hidden" name="referalname[]" value="<?php echo $referalname;?>">
		<input type="hidden" name="auto_number[]" value="<?php echo $auto_number; ?>">	
		<td class="bodytext31" valign="right"  align="left"><div align="right"><input type="text" name="fees[]" id="fees<?php echo $sno; ?>" value="<?php echo '1';?>" style="text-align:right;border:none; background-color:transparent;" readonly size="10" /></div></td>
		<td class="bodytext31" valign="right"  align="left"><div align="right"><?= number_format($doctorfeesrefund, 2, '.', ','); ?>
        <input type="hidden" name="refund[]" id="refund<?php echo $sno; ?>" value="<?php echo $doctorfeesrefund;?>" onKeyUp="return BalCalc('<?php echo $sno; ?>');" readonly style="text-align:right; border:none; background-color:transparent;" size="10" /></div></td>
		<td class="bodytext31" valign="right"  align="left"><div align="right"><?=  number_format($doctorfeesrefund, 2, '.', ','); ?>
        <input type="hidden" name="bal[]" id="bal<?php echo $sno; ?>" value="<?php echo $doctorfeesrefund;?>" style="text-align:right;border:none; background-color:transparent;" readonly size="10" /></div></td> 		
		<td width="1%"  align="left" valign="center" 
        class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
		</tr>
			<?php 
		
			}
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
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Total</strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?=  number_format($doctorfeesrefund, 2, '.', ',') ?></strong></td>
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
				<?php 
				$originalamount = $doctorfeesrefund;
				$totalamount = $doctorfeesrefund;
			  $totalamount = round($totalamount/5,2)*5;
			  $roundoffamount = $originalamount - $totalamount;
			  $roundoffamount = number_format($roundoffamount,2,'.','');
			  $roundoffamount = -($roundoffamount);
			  $totalamount = number_format($totalamount,2,'.','');
			  ?>
                <td width="2%" rowspan="3" align="right" valign="top"  
                bgcolor="#F3F3F3" class="style1" id="tdShowTotal"><?=  number_format($totalamount, 2, '.', ',') ?></td>
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
                  <input name="nettamount" id="nettamount" value="0.00" style="text-align:right" size="8" readonly />
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
                  <option value="">SELECT BILL TYPE</option>
                  <?php 
					$query1billtype = "select * from master_billtype where status = '' order by listorder";
					$exec1billtype = mysqli_query($GLOBALS["___mysqli_ston"], $query1billtype) or die ("Error in Query1billtype".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res1billtype = mysqli_fetch_array($exec1billtype))
					{
					$billtype = $res1billtype["billtype"];
					 ?>
                  <option value="<?php eval(base64_decode('IGVjaG8gJGJpbGx0eXBlOyA=')); ?>"><?php eval(base64_decode('IGVjaG8gJGJpbGx0eXBlOyA=')); ?></option>
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
bgcolor="#F3F3F3" class="bodytext31"><input name="cashgivenbycustomer" id="cashgivenbycustomer" onKeyUp="return funcbillamountcalc1()" onFocus="return cashentryonfocus1()" tabindex="2" style="text-align:right" size="8" autocomplete="off" readonly/></td>
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
bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="mpesanumber" id="mpesanumber" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
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