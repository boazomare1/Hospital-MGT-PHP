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





$docno = $_SESSION['docno'];

 //get location for sort by location purpose

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

	if($location!='')

	{

		  $locationcode=$location;

		}



if (isset($_REQUEST["patientcode"])) { $patientcode1 = $_REQUEST["patientcode"]; } else { $patientcode1 = ""; }



if (isset($_REQUEST["visitcode"])) { $visitcode1 = $_REQUEST["visitcode"]; } else { $visitcode1 = ""; }



if (isset($_REQUEST["billno"])) {  $billno1 = $_REQUEST["billno"]; } else { $billno1 = ""; }



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

	$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'EXRE-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from refund_paynow where source = 'externalrefund' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["billnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode =$paynowbillprefix.'1'."-".date('y');

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

	

	

	$billnumbercode = $paynowbillprefix.$maxanum."-".date('y');

	$openingbalance = '0.00';

	//echo $companycode;

}



$billnumber = $billnumbercode;

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

	$cashamount = $_REQUEST['cashamount'];

	$onlineamount = $_REQUEST['onlineamount'];

	$chequeamount = $_REQUEST['chequeamount'];

	$cardamount = $_REQUEST['cardamount'];

	$creditamount = $_REQUEST['creditamount'];

	$billno = $_REQUEST['billnumber'];



	

	

			foreach($_POST['pharmname'] as $key => $value)

			{

			$medname=$_POST['pharmname'][$key];

			$query77="select * from master_medicine where itemname='$medname'";

			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);

			$res77=mysqli_fetch_array($exec77);

			$medicinecode=$res77['itemcode'];

			$rate=$res77['rateperunit'];

			$pharquantity=$_REQUEST['pharquantity'][$key];

			$pharamount=$_REQUEST['pharamount'][$key];

		

			mysqli_query($GLOBALS["___mysqli_ston"], "update pharmacysalesreturn_details set billstatus='completed' where itemname='$medname' and visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			 $query2 = "insert into refund_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode) 

				values('$patientcode','$patientname','$visitcode','$medname','$pharquantity','$rate','$pharamount','$updatedate','$ipaddress','$accountname','$medicinecode','$billnumber','$username','$pharmacycoa','".$locationnameget."','".$locationcodeget."')";

				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		

			

			}

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

		/*if ($paymentmode == 'CASH')

		{

		$transactiontype = 'PAYMENT';

		$transactionmode = 'CASH';

		$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	

		

		$query9 = "insert into refund_paynow (transactiondate, particulars, 

		transactionmode, transactiontype, transactionamount, cashamount,

		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,transactiontime,cashgivenbycustomer,cashgiventocustomer,source,locationname,locationcode) 

		values ('$billdate', '$particulars', 

		'$transactionmode', '$transactiontype', '$totalamount', '$totalamount', 

		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 

		'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$timeonly','$cashgivenbycustomer','$cashgiventocustomer','externalrefund','".$locationnameget."','".$locationcodeget."')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$cashcoa','externalrefund','".$locationnameget."','".$locationcodeget."')";

        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	



		}*/

		/*if ($paymentmode == 'ONLINE')

		{

		$transactiontype = 'PAYMENT';

		$transactionmode = 'ONLINE';

		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	

		$query9 = "insert into refund_paynow (transactiondate, particulars,

		transactionmode, transactiontype, transactionamount, onlineamount,

		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,transactiontime,cashgivenbycustomer,cashgiventocustomer,source,locationname,locationcode) 

		values ('$billdate','$particulars', 

		'$transactionmode', '$transactiontype', '$totalamount', '$totalamount', 

		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 

		'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$timeonly','$cashgivenbycustomer','$cashgiventocustomer','externalrefund','".$locationnameget."','".$locationcodeget."')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$onlinecoa','externalrefund','".$locationnameget."','".$locationcodeget."')";

        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	

	}*/

		/*if ($paymentmode == 'CHEQUE')

		{

		$transactiontype = 'PAYMENT';

		$transactionmode = 'CHEQUE';

		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;		

			$query9 = "insert into refund_paynow (transactiondate, particulars,

		transactionmode, transactiontype, transactionamount,

		chequeamount,chequenumber, billnumber, billanum, 

		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,transactiontime,cashgivenbycustomer,cashgiventocustomer,source,locationname,locationcode) 

		values ('$billdate', '$particulars', 

		'$transactionmode', '$transactiontype', '$totalamount',

		'$totalamount','$chequenumber',  '$billnumber',  '$billanum', 

		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 

		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$timeonly','$cashgivenbycustomer','$cashgiventocustomer','externalrefund','".$locationnameget."','".$locationcodeget."')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$chequecoa','externalrefund','".$locationnameget."','".$locationcodeget."')";

        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	

	}*/

	/*if($paymentmode == 'CREDIT CARD')

	{

	$transactiontype = 'PAYMENT';

		$transactionmode = 'CREDIT CARD';

		$particulars = 'BY CREDIT CARD '.$billnumberprefix.$billnumber;		

				$query9 = "insert into refund_paynow (transactiondate, particulars,

		transactionmode, transactiontype, transactionamount,

		cardamount, billnumber, billanum, 

		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,creditcardname,creditcardnumber,creditcardbankname,transactiontime,cashgivenbycustomer,cashgiventocustomer,source,locationname,locationcode) 

		values ('$billdate', '$particulars', 

		'$transactionmode', '$transactiontype', '$totalamount',

		'$totalamount',  '$billnumber',  '$billanum', 

		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 

		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$card','$cardnumber','$bankname1','$timeonly','$cashgivenbycustomer','$cashgiventocustomer','externalrefund','".$locationnameget."','".$locationcodeget."')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$cardcoa','externalrefund','".$locationnameget."','".$locationcodeget."')";

        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			

		}*/

		

	/*	if($paymentmode == 'SPLIT')

	{

	$transactiontype = 'PAYMENT';

		$transactionmode = 'SPLIT';

		$particulars = 'BY SPLIT'.$billnumberprefix.$billnumber;		

		

		$query9 = "insert into refund_paynow (transactiondate, particulars,

		transactionmode, transactiontype, transactionamount,

		cardamount, billnumber, billanum, 

		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,creditcardname,creditcardnumber,creditcardbankname,transactiontime,cashgivenbycustomer,cashgiventocustomer,cashamount,onlineamount,chequeamount,chequenumber,creditamount,source,locationname,locationcode) 

		values ('$billdate', '$particulars', 

		'$transactionmode', '$transactiontype', '$totalamount',

		'$cardamount',  '$billnumber',  '$billanum', 

		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 

		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$card','$cardnumber','$bankname1','$timeonly','$cashgivenbycustomer','$cashgiventocustomer','$cashamount','$onlineamount','$chequeamount','$chequenumber','$creditamount','externalrefund','".$locationnameget."','".$locationcodeget."')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,cash,cashcoa,cheque,chequecoa,online,onlinecoa,mpesa,mpesacoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$cardamount','$cardcoa','$cashamount','$cashcoa','$chequeamount','$chequecoa','$onlineamount','$onlinecoa','$creditamount','$mpesacoa','externalrefund','".$locationnameget."','".$locationcodeget."')";

        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			

		}*/		

		

		/*if($paymentmode == 'MPESA')

	{*/

	$transactiontype = 'PAYMENT';

		$transactionmode = 'CASH';

		$particulars = 'BY CASH'.$billnumberprefix.$billnumber;		

		

		$query9 = "insert into refund_paynow (transactiondate, particulars,

		transactionmode, transactiontype, transactionamount, creditamount,

		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,transactiontime,cashgivenbycustomer,cashgiventocustomer,source,bankcode,locationname,locationcode) 

		values ('$billdate','$particulars', 

		'$transactionmode', '$transactiontype', '$totalamount', '$totalamount', 

		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 

		'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$timeonly','$cashgivenbycustomer','$cashgiventocustomer','externalrefund','$paymentmode','".$locationnameget."','".$locationcodeget."')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$mpesanumber','externalrefund','".$locationnameget."','".$locationcodeget."')";

        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	



	//}

		

	mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set itemrefund='' where visitcode='$visitcode'");

	foreach($_POST['lab'] as $key => $value)

		{

		$labname=$_POST['lab'][$key];

	    $labautonumber=$_POST['labautono'][$key];

		$labquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_lab where itemname='$labname'");

		$execlab=mysqli_fetch_array($labquery);

		$labcode=$execlab['itemcode'];

		$labrate=$execlab['rateperunit'];

		if($patientcode=='walkin')

{

	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set labrefund='' where patientvisitcode='$visitcode' and labitemname='$labname' and billnumber='$billno' and auto_number='$labautonumber'");

}

else

{

	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set labrefund='' where patientvisitcode='$visitcode' and labitemname='$labname' and docnumber='$billno' and auto_number='$labautonumber'");

	}

	$query45 = "insert into refund_paynowlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,billnumber,username,labcoa,locationname,locationcode)values

	           ('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$updatedate','$billnumber','$username','$labcoa','".$locationnameget."','".$locationcodeget."')";

	$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		   

	}

	foreach($_POST['rad'] as $key => $value)

		{

		$radname=$_POST['rad'][$key];

		$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_radiology where itemname='$radname'");

		$execradiology=mysqli_fetch_array($radiologyquery);

		$radiologycode=$execradiology['itemcode'];

		$radiologyrate=$execradiology['rateperunit'];

		$radautonumber=trim($_POST['radautono'][$key]);

if($patientcode=='walkin')

{

	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set radiologyrefund='' where patientvisitcode='$visitcode' and radiologyitemname='$radname' and billnumber='$billno' and auto_number='$radautonumber'");

}

else

{

	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set radiologyrefund='' where patientvisitcode='$visitcode' and radiologyitemname='$radname' and docnumber='$billno' and auto_number='$radautonumber'");

	}

	$query46 = "insert into refund_paynowradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,billnumber,username,radiologycoa,locationname,locationcode)values

	           ('$patientcode','$patientname','$visitcode','$radiologycode','$radname','$radiologyrate','$accountname','$updatedate','$billnumber','$username','$radiologycoa','".$locationnameget."','".$locationcodeget."')";

	$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		   



	}

	

	foreach($_POST['ser'] as $key => $value)

		{

		$sername=$_POST['ser'][$key];

		$servicequery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_services where itemname='$sername'");

		$execservice=mysqli_fetch_array($servicequery);

		$servicescode=$execservice['itemcode'];

		$servicesrate=$execservice['rateperunit'];

		$serautonumber=trim($_POST['serautono'][$key]);

		if($patientcode=='walkin')

{

	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set servicerefund='' where patientvisitcode='$visitcode' and servicesitemname='$sername' and billnumber='$billno' and auto_number='$serautonumber'");

}

else

{

	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set servicerefund='' where patientvisitcode='$visitcode' and servicesitemname='$sername' and docnumber='$billno' and auto_number='$serautonumber'");

	}

	$query47 = "insert into refund_paynowservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber,username,servicecoa,locationname,locationcode)values

	           ('$patientcode','$patientname','$visitcode','$servicescode','$sername','$servicesrate','$accountname','$updatedate','$billnumber','$username','$servicecoa','".$locationnameget."','".$locationcodeget."')";

	$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		   



	}

	

	foreach($_POST['referalname'] as $key => $value)

		{

		$referalname=$_POST['referalname'][$key];

		$referalquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_department where department='$referalname'");

		$execreferal=mysqli_fetch_array($referalquery);

		$referalcode=$execreferal['auto_number'];

		$referalrate=$_POST['refrate'][$key];

		

			

	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_departmentreferal set referalrefund='' where patientvisitcode='$visitcode' and referalname='$referalname'");

	$query47 = "insert into refund_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,billnumber,username,referalcoa,locationname,locationcode)values

	           ('$patientcode','$patientname','$visitcode','$referalcode','$referalname','$referalrate','$accountname','$updatedate','$billnumber','$username','$referalcoa','".$locationnameget."','".$locationcodeget."')";

	$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		   



	}

 

	header("location:patientbillingstatus_bills.php?refundbillnumber=$billnumber&&patientcode=$patientcode&&visitcode=$visitcode&&locationcode=$locationcodeget&&mainmenuid=MM005");

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



$patienttype=$execlab['maintype'];

$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");

$exectype=mysqli_fetch_array($querytype);

$patienttype1=$exectype['paymenttype'];

$patientsubtype=$execlab['subtype'];

$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");

$execsubtype=mysqli_fetch_array($querysubtype);

$patientsubtype1=$execsubtype['subtype'];

$patientplan=$execlab['planname'];

$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");

$execplan=mysqli_fetch_array($queryplan);

$patientplan1=$execplan['planname'];



?>

<?php



$query69="select * from paylaterpharmareturns where billnumber='$billno1'";

$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res69=mysqli_fetch_array($exec69);

$patientname=$res69['patientname'];

$patientage=$res69['age'];

$patientgender=$res69['gender'];

$patientaccount=$res69['accountname'];

if($patientname=='')

{

$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_radiology where billnumber='$billno1'");

$execlab1=mysqli_fetch_array($querylab1);

$patientname=$execlab1['patientname'];

$patientaccount=$execlab1['accountname'];

}

if($patientname=='')

{

$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_lab where billnumber='$billno1'");

$execlab1=mysqli_fetch_array($querylab1);

$patientname=$execlab1['patientname'];

$patientaccount=$execlab1['accountname'];

}

if($patientname=='')

{

$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_services where billnumber='$billno1'");

$execlab1=mysqli_fetch_array($querylab1);

$patientname=$execlab1['patientname'];

$patientaccount=$execlab1['accountname'];

}

$query76 = "select * from master_financialintegration where field='labrefundpaynow'";

$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res76 = mysqli_fetch_array($exec76);

$labcoa = $res76['code'];



$query761 = "select * from master_financialintegration where field='radiologyrefundpaynow'";

$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res761 = mysqli_fetch_array($exec761);



$radiologycoa = $res761['code'];



$query762 = "select * from master_financialintegration where field='servicerefundpaynow'";

$exec762 = mysqli_query($GLOBALS["___mysqli_ston"], $query762) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res762 = mysqli_fetch_array($exec762);



$servicecoa = $res762['code'];



$query763 = "select * from master_financialintegration where field='referalrefundpaynow'";

$exec763 = mysqli_query($GLOBALS["___mysqli_ston"], $query763) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res763 = mysqli_fetch_array($exec763);



$referalcoa = $res763['code'];



$query764 = "select * from master_financialintegration where field='pharmacyrefundpaynow'";

$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res764 = mysqli_fetch_array($exec764);



$pharmacycoa = $res764['code'];



$query765 = "select * from master_financialintegration where field='cashrefundpaynow'";

$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res765= mysqli_fetch_array($exec765);



$cashcoa = $res765['code'];





$query766 = "select * from master_financialintegration where field='chequerefundpaynow'";

$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res766 = mysqli_fetch_array($exec766);



$chequecoa = $res766['code'];





$query767 = "select * from master_financialintegration where field='mpesarefundpaynow'";

$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res767 = mysqli_fetch_array($exec767);



$mpesacoa = $res767['code'];



$query768 = "select * from master_financialintegration where field='cardrefundpaynow'";

$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res768 = mysqli_fetch_array($exec768);



$cardcoa = $res768['code'];



$query769 = "select * from master_financialintegration where field='onlinerefundpaynow'";

$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res769 = mysqli_fetch_array($exec769);



$onlinecoa = $res769['code'];

?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'EXRE-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from refund_paynow where source = 'externalrefund' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["billnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode =$paynowbillprefix.'1'."-".date('y');

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

	

	

	$billnumbercode = $paynowbillprefix.$maxanum."-".date('y');

	$openingbalance = '0.00';

	//echo $companycode;

}



if($patientcode1!='walkin')

{

$query3 = "select patientfullname,accountname from master_visitentry where visitcode = '".$visitcode1."'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

 $patientname = $res3['patientfullname'];

 $patientaccount1 = $res3['accountname'];

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





function funcPrintBill()

{

var popWin; 

popWin = window.open("print_paynow_refund.php?billnumber=<?php echo $billnumbercode; ?>&&visitcode=<?php echo $visitcode1; ?>&&patientcode=<?php echo $patientcode1; ?>&&locationcode=<?php echo $locationcodeget; ?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}





//Print() is at bottom of this page.



</script>

<?php include ("js/sales1scripting1refund.php"); ?>

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

		window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	}

	if (varPaperSize == "A5")

	{

		window.open("print_bill1_a5.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

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



document.getElementById("tdShowTotal").innerHTML = (newbalance.toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

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

.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }

</style>



<script src="js/datetimepicker_css.js"></script>



</head>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<body onLoad="return funcOnLoadBodyFunctionCall();">

<form name="form1" id="frmsales" method="post" action="refund_external.php">

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

             <?php

						

						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						$res1location = $res1["locationname"];

						$res1locationanum = $res1["locationcode"];

						?>

						

						

                <tr bgcolor="#011E6A">

                <td colspan="4" bgcolor="#ecf0f5" class="bodytext32"><strong>Paynow Refund </strong></td>

                <td colspan="3" bgcolor="#ecf0f5" class="bodytext32"><strong>Location : <?php echo $res1location;?> </strong></td>

              	  <input type="hidden" name="locationcodeget" value="<?php echo $res1locationanum?>">

				<input type="hidden" name="locationnameget" value="<?php echo $res1location?>">

                 

                  

			 </tr>

		<tr>

                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>

			 </tr>

			  <tr>

			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  </strong></td>

                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $patientname; ?>

				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>                  </td>

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

				<input type="hidden" name="billnumber" value="<?php echo $billno1; ?>">

			

             <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Bill No</strong></td>

                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $billnumbercode; ?>

				<input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>

				<input type="hidden" name="account" id="account" value="<?php echo $patienttype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>

		      </tr>

			   <tr> 

			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">Reg.No</td>

                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $patientcode; ?>

				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>

				

				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>

				    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Bill Date</strong></td>

                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $dateonly; ?>

				<input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>

              	<input type="hidden" name="account" id="account" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				

			  </tr>

				  <tr>

				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit No </strong></td>

                  <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $visitcode; ?>

				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>

                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>

                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientaccount1; ?>

				<input type="hidden" name="accountname" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>

				  </tr>

                  <input type="hidden" name="account" id="account" value="<?php echo $patientplan1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				

				  <input type="hidden" name="account" id="account" value="" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				

				 

				  	<tr>

                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>

			 </tr>

            </tbody>

        </table></td>

      

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

  $query11 = "select * from refund_paynowlab where  patientvisitcode = '$visitcode1' and billnumber='$billno1' and patientcode = '$patientcode' ";

	          $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

              while($res11 = mysqli_fetch_array($exec11))

               {

               $res11billingdatetime=$res11['billingdatetime'];

               $res11billno = $res11['billnumber'];

               $res11copayfixedamount = $res11['patientcode'];

               $res11patientname = $res11['patientname'];

               }

			  

			  $totallab=0;

			  

			  $query19 = "select * from consultation_lab where patientvisitcode='$visitcode1' and patientcode='$patientcode1' and billnumber='$billno1' and labrefund='refund'";

			  

			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res19 = mysqli_fetch_array($exec19))

			{

			$labdate=$res19['consultationdate'];

			$labname=$res19['labitemname'];

			$labrate=$res19['labitemrate'];

			$labautonumber=$res19['auto_number'];

			$labrefno=$res19['refno'];

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

			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>

			 <input type="hidden" name="lab[]" value="<?php echo $labname; ?>">

			 <input type="hidden" name="labautono[]" value="<?php echo $labautonumber; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>

             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2,'.',','); ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2,'.',','); ?></div></td>

			<td width="4%"  align="left" valign="center" 

               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>

             

			  

			  <?php }

			  ?>

			   <?php 

			   $totalpharm=0;

			   

			  $query23 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and billnumber='$billno1' and billstatus='pending'";

			  

			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res23 = mysqli_fetch_array($exec23))

			{

			$phadate=$res23['entrydate'];

			$phaname=$res23['itemname'];

			$phaquantity=$res23['quantity'];

			$pharate=$res23['rate'];

			$phaamount=$res23['totalamount'];

			

			$query87="select * from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinename='$phaname'";

			$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res87=mysqli_fetch_array($exec87);

			$pharefno=$res23['billnumber'];

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

			$totalpharm=$totalpharm+$phaamount;

			?>

			 <tr <?php echo $colorcode; ?>>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>

			  <input type="hidden" name="pharmname[]" value="<?php echo $phaname; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo intval($phaquantity); ?></div></td>

			 <input type="hidden" name="pharquantity[]" value="<?php echo $phaquantity; ?>">

             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo  number_format($pharate,2,'.',','); ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount,2,'.',','); ?></div></td>

			 <input type="hidden" name="pharamount[]" value="<?php echo $phaamount; ?>">

			<td width="4%"  align="left" valign="center" 

               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>

             

			  

			  <?php }

			  ?>

			    <?php 

				$totalrad=0;

				

			  $query20 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and billnumber='$billno1' and radiologyrefund='refund'";

				

			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res20 = mysqli_fetch_array($exec20))

			{

			$raddate=$res20['consultationdate'];

			$radname=$res20['radiologyitemname'];

			$radrate=$res20['radiologyitemrate'];

			$radautonumber=$res20['auto_number'];

			$radref=$res20['refno'];

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

			 <input type="hidden" name="rad[]" value="<?php echo $radname; ?>">

			 <input type="hidden" name="radautono[]" value="<?php echo $radautonumber; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>

             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo  number_format($radrate,2,'.',','); ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2,'.',','); ?></div></td>

			 <td width="4%"  align="left" valign="center" 

               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>

             

			  

			  <?php }

			  ?>

			  	    <?php 

					

					$totalser=0;

					

			  $query21 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and billnumber='$billno1' and servicerefund='refund'";

				

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res21 = mysqli_fetch_array($exec21))

			{

			$serdate=$res21['consultationdate'];

			$sername=$res21['servicesitemname'];

			$serrate=$res21['servicesitemrate'];

			$serautonumber=$res21['auto_number'];

			$serref=$res21['refno'];

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

			 <input type="hidden" name="ser[]" value="<?php echo $sername; ?>">

			 <input type="hidden" name="serautono[]" value="<?php echo $serautonumber; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>

             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2,'.',',');  ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2,'.',','); ?></div></td>

			 <td width="4%"  align="left" valign="center" 

               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>

             

			  

			  <?php }

			  ?>

			   <?php 

			   $totalref=0;

			  $query22 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and referalrefund='refund'";

			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res22 = mysqli_fetch_array($exec22))

			{

			$refdate=$res22['consultationdate'];

			$refname=$res22['referalname'];

			$refrate=$res22['referalrate'];

			$refref=$res22['refno'];

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

			?>

			 <tr <?php echo $colorcode; ?>>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>

			  <input type="hidden" name="referalname[]" value="<?php echo $refname; ?>">

			  <input type="hidden" name="refrate[]" value="<?php echo $refrate; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>

             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate,2,'.',','); ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate,2,'.',',');  ?></div></td>

			 <td width="4%"  align="left" valign="center" 

               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>

             

			  

			  <?php }

			  ?>

			  <?php 

			  $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref)-$totalcopay;

			  $overalltotal=number_format($overalltotal,2,'.','');

			  $consultationtotal=$totalop-$totalcopay;

			   $consultationtotal=number_format($consultationtotal,2,'.','');

			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalref;

			   $netpay=number_format($netpay,2,'.','');

			   $totalamount=$overalltotal;

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

                bgcolor="#ecf0f5"><strong><?php echo number_format($overalltotal,2,'.',','); ?></strong></td>

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

                      <div align="right"><strong><?php //.' '.$res6taxpercent.'%'; ?></strong></div></td>

                    <td width="39%"><span class="bodytext312">

                     

                    </span></td>

                  </tr>

                </table>-->						  </td>

				<?php

				$originalamount = $totalamount;

			  $totalamount = round($totalamount/5,2)*5;

			  $totalamount = number_format($totalamount,2,'.','');

			  $roundoffamount = $originalamount - $totalamount;

			  $roundoffamount = number_format($roundoffamount,2,'.','');

			  $roundoffamount = -($roundoffamount);

			  ?>

                <td width="3%" rowspan="3" align="right" valign="top"  

                bgcolor="#F3F3F3" class="style1" id="tdShowTotal"><?php echo number_format($totalamount,2,'.',','); ?></td>

                <td width="12%" align="left" valign="center"  

                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Sub Total </strong></div></td>

                <td align="left" valign="center"  

                bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>

                <td align="left" valign="top" bgcolor="#F3F3F3" width="15%"><span class="bodytext31">

                  <input name="subtotal" id="subtotal" value="<?php echo $originalamount; ?>" style="text-align:right" size="8"  readonly="readonly" />

                </span></td>

				

                <td align="left" valign="top" bgcolor="#F3F3F3" width="10%">&nbsp;</td>

                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="8%"><div align="right"><strong>Bill Amt </strong></div></td>

                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>

                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="9%"><span class="bodytext311">

                 

                <input name="totalamount" id="totalamount" value="<?php echo $totalamount; ?>" style="text-align:right" size="8"  readonly="readonly" />

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

                <td align="left" valign="top" bgcolor="#F3F3F3" width="15%"><span class="bodytext311">

				 <input name="roundoff" id="roundoff" value="<?php echo $roundoffamount; ?>" style="text-align:right"  readonly="readonly" size="8"/>

                  <input name="totalaftercombinediscount" id="totalaftercombinediscount" value="0.00" style="text-align:right" size="8"  readonly="readonly" type="hidden"/>

                </span></td>

                <td align="left" valign="top" bgcolor="#F3F3F3" width="10%">&nbsp;</td>

                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="8%"><div align="right"><strong>Nett Amt</strong></div></td>

                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="6%">&nbsp;</td>

                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="9%"><span class="bodytext31">

                   <input name="nettamount" id="nettamount" value="<?php echo $totalamount; ?>" style="text-align:right" size="8" readonly />

                </span></td>

                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="23%">&nbsp;</td>

              </tr>

              <input type="hidden" name="totalaftertax" id="totalaftertax" value="0.00"  onKeyDown="return disableEnterKey()" onBlur="return funcSubTotalCalc()" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly"/>

              

               

              <tr>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Mode </strong></div></td>

                <td align="left" valign="center"  

                bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#F3F3F3" class="bodytext31" width="15%"><select name="billtype" id="billtype" onChange="return paymentinfo()">

                   <option value="<?php echo  '02-2000-12'; ?>"><?php echo 'Patient Refunds'; ?></option>


                </select></td>

                <td align="left" valign="center"  

                bgcolor="#F3F3F3" class="bodytext31" width="10%">&nbsp;</td>

                <td align="left" valign="middle" bgcolor="#F3F3F3" class="bodytext31" width="8%">

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

bgcolor="#F3F3F3" class="bodytext31" width="8%"><div align="right"><strong>&nbsp;   </strong></div></td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31" width="6%"><input type="hidden" name="cashgiventocustomer" id="cashgiventocustomer" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8" readonly  /></td>

               

               

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31" width="9%">&nbsp;</td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>

              </tr>

			

              <tr id="creditamounttr">

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31"></td>

                <td colspan="2" align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA </strong></div></td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31" width="6%"><input name="creditamount" id="creditamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('2')"/></td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA No. </strong></div></td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="mpesanumber" id="mpesanumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31" width="8%"></td>

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

bgcolor="#F3F3F3" class="bodytext31"><input name="chequeamount" id="chequeamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('3')"/></td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Chq No. </strong></div></td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="chequenumber" id="chequenumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31" width="8%"><div align="right"><strong> Date </strong></div></td>

                <td width="6%" align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31">  <input name="chequedate" id="chequedate" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>

                <td width="9%" align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Bank  </strong></div></td>

                <td width="23%" align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31"> <input name="chequebank" id="chequebank" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31"></td>

              </tr>

			  

              <tr id="cardamounttr">

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31"></td>

                <td colspan="2" align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Card  </strong></div></td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31"><input name="cardamount" id="cardamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('4')"/></td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Card No </strong></div></td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="cardnumber" id="cardnumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>

                <td width="8%" align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Name  </strong></div></td>

                <td align="left" valign="center"  

bgcolor="#F3F3F3" class="bodytext31" width="6%"><input type="text" name="cardname" id="cardname" size="8" style="border: 1px solid #001E6A; text-align:left;">

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

                </select>--></td>

                <td align="left" valign="center" class="bodytext31" width="9%"><div align="right"><strong> Bank  </strong></div></td>

                <td align="left" valign="center" class="bodytext31" width="23%"><input name="bankname1" id="bankname" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase"  size="8"  /></td>

              </tr>

              <tr id="onlineamounttr">

			  <td align="left" valign="center"

                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>

			    <td colspan="2" align="left" valign="center" 

                bgcolor="#F3F3F3" class="bodytext31">

                 <div align="right"><strong>Online  </strong></div>                  </td>

                <td align="left" valign="center"  

                bgcolor="#F3F3F3" class="bodytext31"><input name="onlineamount" id="onlineamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8" readonly onKeyUp="return balancecalc('5')"/></td>

                 <td align="left" valign="center"  

                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Online No </strong></div></td>

                <td align="left" valign="center"  

                 class="bodytext31" width="10%"><input name="onlinenumber" id="onlinenumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>

                <td align="left" valign="center"  

                 class="bodytext31" width="8%">&nbsp;</td>

                <td align="left" valign="center"  

                 class="bodytext31" width="6%">&nbsp;</td>

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

                  <input name="delbillautonumber" id="delbillautonumber" type="hidden" value="<?php echo $delbillautonumber;?>">

                  <input name="delbillnumber" id="delbillnumber" type="hidden" value="<?php echo $delbillnumber;?>">



				  <input name="Submit2223" type="submit" onClick="return funcSaveBill1()" value="Save Bill" accesskey="b" class="button" />

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

        </table>

		</td>

    </table>



</form>

<?php include ("includes/footer1.php"); ?>

<?php //include ("print_bill_dmp4inch1.php"); ?>

</body>

</html>