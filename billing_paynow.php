<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
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
$docno=$_SESSION["docno"];

$query01="select locationcode from login_locationdetails where docno ='$docno' and username='$username' order by auto_number desc";
$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01=mysqli_fetch_array($exc01);
$main_locationcode = $res01['locationcode'];

$query018="select auto_number from master_location where locationcode='$main_locationcode'";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];

$query1111 = "select * from master_employee where username = '$username'";
			$exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while ($res1111 = mysqli_fetch_array($exec1111))
			 {
			   $locationnumber = $res1111["location"];
			   $query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'deleted'";
				$exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while ($res1112 = mysqli_fetch_array($exec1112))
			 {
			   $locationname = $res1112["locationname"];    
				$locationcode = $res1112["locationcode"];
			 }
			 }
			
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
  billnumbercreate:
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	
	$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
	$execlab=mysqli_fetch_array($Querylab);
	$patientpaymenttype = $execlab['billtype'];
	$patientname = $_REQUEST["patientname"];
	
	$query43 = "select * from master_consultation where patientvisitcode='$visitcode' order by auto_number desc";
	$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res43 = mysqli_fetch_array($exec43);
	$consultationid = $res43['consultation_id'];
	
	
	if($consultationid == '')
	{
	$query431 = "select * from master_triagebilling where patientvisitcode='$visitcode' order by auto_number desc";
	$exec431 = mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res431 = mysqli_fetch_array($exec431);
	$consultationid = $res431['docnumber'];
	}
	
	if($patientpaymenttype == 'PAY LATER')
	{
	$query4311 = "select * from approvalstatus where visitcode='$visitcode' order by auto_number desc";
	$exec4311 = mysqli_query($GLOBALS["___mysqli_ston"], $query4311) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4311 = mysqli_fetch_array($exec4311);
	$consultationid = $res4311['docno'];
	}
	
	
	$accountname= $_REQUEST['p_accountname'];
	$accountcode= $_REQUEST['p_accountcode'];
	$accountnameano= $_REQUEST['p_accountnameano'];
	$subtype = $_REQUEST['subtype'];
	$totalamount=$_REQUEST['totalamount'];
	$billdate=$_REQUEST['billdate'];
	$entrydate = $billdate;
	$referalname=$_REQUEST['referalname'];
	$paymentmode = $_REQUEST['billtype'];
	$billtype = $_REQUEST['billtype'];
	$chequenumber = $_REQUEST['chequenumber'];
		$chequedate = $_REQUEST['chequedate'];
		$bankname = $_REQUEST['chequebank'];
		$bankbranch = $_REQUEST['bankbranch'];
		$remarks = $_REQUEST['remarks'];
		$card = $_REQUEST['cardname'];
		$cardnumber = $_REQUEST['cardnumber'];
		$bankname1 = $_REQUEST['bankname1'];
		$paymenttype = $_REQUEST['paymenttype'];
		$query77 = "select * from master_visitentry where visitcode='$visitcode'";
		$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res77 = mysqli_fetch_array($exec77);
		$doctor = $res77['consultingdoctor'];
		$cashgiventocustomer = $_REQUEST['cashgiventocustomer'];
		$cashgivenbycustomer = $_REQUEST['cashgivenbycustomer'];
		$cashamount = $_REQUEST['cashamount'];
		$onlineamount = $_REQUEST['onlineamount'];
		$chequeamount = $_REQUEST['chequeamount'];
		$cardamount = $_REQUEST['cardamount'];
		$creditamount = $_REQUEST['creditamount'];
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
		$mpesanumber = $_REQUEST['mpesanumber'];
		$onlinenumber = $_REQUEST['onlinenumber'];
		$dispensingfee = $_REQUEST['dispensingfee'];
		$dispensingdocno = $_REQUEST['dispensingdocno'];
		
		$patientfirstname = $_REQUEST['patientfirstname'];
		$patientmiddlename=$_REQUEST['patientmiddlename'];
		$patientlastname = $_REQUEST["patientlastname"];
		
		$chequecode = '';
		$cashcode = '';
		$mpesacode = '';
		$bankcode = '';
		$onlinecode = '';
	
		//get location from form
		 $locationname=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		 $locationcode=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
		 
		 $ambcount=isset($_REQUEST['ambcount'])?$_REQUEST['ambcount']:'';
		  $ambcount1=isset($_REQUEST['ambcount1'])?$_REQUEST['ambcount1']:'';
		 
		$patientage = $_REQUEST['patientage'];
		$patientgender = $_REQUEST['patientgender'];
		$desipaddress=$_REQUEST['desipaddress'];
		$desusername=$_REQUEST['desusername'];
		$fxrate = $_REQUEST['fxrate'];
	
		
		$query7691 = "select * from master_financialintegration where field='externaldoctors'";
		$exec7691 = mysqli_query($GLOBALS["___mysqli_ston"], $query7691) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res7691 = mysqli_fetch_array($exec7691);
		
		$debitcoa = $res7691['code'];
			
		$query78 = "select * from master_doctor where auto_number='$doctor'";
		$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res78 = mysqli_fetch_array($exec78);
		$doctorname = $res78['doctorname'];
		
	$query3 = "select * from bill_formats where description = 'bill_paynow'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$paynowbillprefix = $res3['prefix'];
	$paynowbillprefix1=strlen($paynowbillprefix);
	$query2 = "select * from billing_paynow order by auto_number desc limit 0, 1";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$billnumber = $res2["billno"];
	$billdigit=strlen($billnumber);
	
	$dispensingkey=isset($_REQUEST['dispensingkey'])?$_REQUEST['dispensingkey']:'';
	
	
	if ($billnumber == '')
	{
		$billnumbercode =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
			$openingbalance = '0.00';
	
	}
	else
	{
		/*$billnumber = $res2["billno"];
		$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
		//echo $billnumbercode;
		$billnumbercode = intval($billnumbercode);
		$billnumbercode=abs($billnumbercode);
		$billnumbercode = $billnumbercode + 1;
	
		$maxanum = $billnumbercode;*/
		
		$billnumber = $res2["billno"];
		$maxcount=split("-",$billnumber);
		$maxcount1=$maxcount[1];
		$maxanum = $maxcount1+1;
		
		
		$billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
		$openingbalance = '0.00';
		//echo $companycode;
	}
	
	$billnumber = $billnumbercode;
		
		$query386="select * from billing_paynow where billno='$billnumber'";
		$exec386=mysqli_query($GLOBALS["___mysqli_ston"], $query386) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num386=mysqli_num_rows($exec386);
	if($num386 == 0)
	{
		$query3861="select * from billing_paynow where visitcode='$visitcode' and consultationid='$consultationid' ";
		$exec3861=mysqli_query($GLOBALS["___mysqli_ston"], $query3861) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num3861=mysqli_num_rows($exec3861);
	if(1)
	{
	
	
	
	$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paynow(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,referalname,doctorstatus,billstatus,username,subtype,consultationid,creditcoa,debitcoa,locationname,locationcode,fxrate,fxamount)values('$billnumber','$patientname','$patientcode','$visitcode','$totalamount','$billdate','$accountname','$referalname','unpaid','paid','$username','$subtype','$consultationid','$referalcode','$debitcoa','$locationname','$locationcode','$fxrate','$totalamount')") ;
	
		        if( mysqli_errno($GLOBALS["___mysqli_ston"]) == 1062) 
				{
				   goto billnumbercreate;
				}
				else if(mysqli_errno($GLOBALS["___mysqli_ston"]) > 0)
				{
				   die ("Error in referalquery1".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
	
		//inserting ambulance bill details
		//echo $quantity;
		if($ambcount>0)
		{
			
			foreach($_POST['ambulancecount'] as $key)
			{ 
				$amdocno=$_REQUEST['amdocno'][$key];
				$accountname=$_REQUEST['accountname'][$key];
				$description=$_REQUEST['description'][$key];
				$quantity=$_REQUEST['quantity'][$key];
				$rate=$_REQUEST['rate'][$key];
				$amount=$_REQUEST['amount'][$key];
				 
					 $referalquery178=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_opambulance(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,fxrate,fxamount)values('".$amdocno."','$patientcode','$patientname','$visitcode','$accountname','".$description."','".$quantity."','".$rate."','".$amount."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','','$amount','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$fxrate','$amount')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				//$referalquery1=mysql_query("insert into billing_opambulance(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username)values('".$amdocno."','$patientcode','$patientname','$visitcode','$accountname','".$description."','".$quantity."','".$rate."','".$amount."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."')") or die(mysql_error());
			}
				
				mysqli_query($GLOBALS["___mysqli_ston"], "update op_ambulance set paymentstatus='completed' where patientvisitcode='$visitcode'");
			}
			//insert query  for homecare
			if($ambcount1>0)
		{
			
			foreach($_POST['ambulancecount1'] as $key)
			{ 
				$amdocno1=$_REQUEST['amdocno1'][$key];
				$accountname1=$_REQUEST['accountname1'][$key];
				$description1=$_REQUEST['description1'][$key];
				$quantity1=$_REQUEST['quantity1'][$key];
				$rate1=$_REQUEST['rate1'][$key];
				$amount1=$_REQUEST['amount1'][$key];
					 
					 $referalquery199=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_homecare(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,fxrate,fxamount)values('".$amdocno1."','$patientcode','$patientname','$visitcode','$accountname1','".$description1."','".$quantity1."','".$rate1."','".$amount1."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','','$amount1','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$fxrate','$amount1')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					
				//$referalquery1=mysql_query("insert into billing_homecare(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username)values('".$amdocno1."','$patientcode','$patientname','$visitcode','$accountname1','".$description1."','".$quantity1."','".$rate1."','".$amount1."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."')") or die(mysql_error());
				}
				
				mysqli_query($GLOBALS["___mysqli_ston"], "update homecare set paymentstatus='completed' where patientvisitcode='$visitcode'");
			}
			//ends here
		/*$query3861="select * from billing_paynow where visitcode='$visitcode' and consultationid='$consultationid' and billno='$billnumber'";
		$exec3861=mysql_query($query3861) or die(mysql_error());
		$num3861=mysql_num_rows($exec3861);
	if($num3861 == 0)
	{ */
	
			
		    $query29 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and amendstatus ='2'";
			$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num29=mysqli_num_rows($exec29);
			
		if($num29 != 0)
		{
		mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set pharmacybill='completed' where visitcode='$visitcode' ");
		//mysql_query("update master_consultationpharm set pharmacybill='completed' where patientvisitcode='$visitcode' and amendstatus ='2'"); 
		}
			$query23 = "select * from billing_pharmacy where billnumber = '$billnumber'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res23 = mysqli_num_rows($exec233);
	if ($res23 == 0)
	{
	$query24=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_pharmacy(billnumber,patientcode,patientvisitcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$visitcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	$query30=mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultation set paymentstatus='completed' where patientvisitcode='$visitcode'");
		foreach($_POST['pharmname'] as $key => $value)
		{
		$pharmname=$_POST['pharmname'][$key];
		$pharmname =addslashes($pharmname);
	
	//$query34=mysql_query("update master_consultationpharm set billing='completed' where medicinename='$pharmname' and patientvisitcode='$visitcode' and amendstatus ='2' ") or die(mysql_error());
	//$query38=mysql_query("update master_consultationpharmissue set paymentstatus='completed' where medicinename='$pharmname' and patientvisitcode='$visitcode' and amendstatus ='2'");
	}
		
		  $query30 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and approvalstatus !='0'";
			$exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num30=mysqli_num_rows($exec30);
		if($num30 != 0)
		{
		mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set labbill='completed' where visitcode='$visitcode'");
		}
		$query23 = "select * from billing_lab where billnumber = '$billnumber'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res23 = mysqli_num_rows($exec233);
	if ($res23 == 0)
	{
	$query24=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_lab(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	$query27=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set paymentstatus='completed' where patientvisitcode='$visitcode' and approvalstatus !='0'");
	
		 $query31 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and approvalstatus !='0' ";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num31=mysqli_num_rows($exec31);
			if($num31 != 0)
			{
			mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set radiologybill='completed' where visitcode='$visitcode'");
			}
			$query23 = "select * from billing_radiology where billnumber = '$billnumber'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res23 = mysqli_num_rows($exec233);
	if ($res23 == 0)
	{
	
	$query24=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_radiology(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}
$query28=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set paymentstatus='completed' where patientvisitcode='$visitcode' and approvalstatus !='0'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $query32 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and approvalstatus !='0'";
			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num32=mysqli_num_rows($exec32);
		if($num32 != 0)
		{
			mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set servicebill='completed' where visitcode='$visitcode'");
		}
		$query23 = "select * from billing_services where billnumber = '$billnumber'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res23 = mysqli_num_rows($exec233);
	if ($res23 == 0)
	{
	//echo "insert into billing_services(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')";
	$query24=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_services(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}
	$query29=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set paymentstatus='completed' where patientvisitcode='$visitcode' and approvalstatus !='0'");
	
	
			  $query33 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num33=mysqli_num_rows($exec33);
		if($num33 != 0)
		{
		mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set referalbill='completed' where visitcode='$visitcode'");
		}
		$query23 = "select * from billing_referal where billnumber = '$billnumber'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res23 = mysqli_num_rows($exec233);
	if ($res23 == 0)
	{
	
	$query24=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_referal(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}
	$query30=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_departmentreferal set paymentstatus='completed' where patientvisitcode='$visitcode'");
	$query30=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_referal set paymentstatus='completed' where patientvisitcode='$visitcode'");
	
        foreach($_POST['medicinename'] as $key=>$value)
		{	
		    
		    $medicinename = $_POST['medicinename'][$key];
		    $medicinecode = $_POST['medicinecode1'][$key];
			$pharmano = $_POST['pharmano'][$key];
			
			$medicinename = addslashes($medicinename);

			if($medicinecode==''){
					$query77="select * from master_medicine where itemname='$medicinename' and status <> 'deleted' ";
					$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
					$res77=mysqli_fetch_array($exec77);
					$medicinecode=$res77['itemcode'];
			}

			$rate=$_POST['rate'][$key];
			$quantity = $_POST['quantity'][$key];
			$amount = $_POST['amount'][$key];
			if($rate!=0.00 && $quantity!=0 && ($amount==0.00 || $amount=='')){
				continue;
			}	
				
			$query6 = "select ledgername, ledgercode, ledgerautonumber,incomeledger,incomeledgercode from master_medicine where itemcode = '$medicinecode' and status <> 'deleted'"; 
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$ledgername = $res6['ledgername'];
			$ledgercode = $res6['ledgercode'];
			$ledgeranum = $res6['ledgerautonumber'];
			$incomeledger =$res6['incomeledger'];
			$incomeledgercode = $res6['incomeledgercode'];
				
				if($dispensingkey==1 && $medicinename=='Dispensing Fee')
	{
			 $query7q="select docno from dispensingfee where 1 order by auto_number desc limit 0,1";
			$exec7q=mysqli_query($GLOBALS["___mysqli_ston"], $query7q);
			$res7q=mysqli_fetch_array($exec7q);
			$docno1=$res7q['docno'];
			$medicinecode='DISPENS';
			$rate=$amount;
		if($docno1=='')
		{
			$docno1="DSF-1";
			}
			else
			{
				 $docadd=substr($docno1,4,15);
				 $docno1=$docadd+1;
				 $docno1='DSF-'.$docno1;
				}
			
		$querydisp="insert into dispensingfee(recorddate,recordtime,patientname,visitcode,patientcode,age,gender,billtype,accountname,dispensingfee,docno,status,locationname,locationcode,ipaddress,username)values('".date('Y-m-d')."','".date('h:i:s')."','$patientname','$visitcode','$patientcode','$patientage','$patientgender','$paymentmode','$accountname','$amount','$docno1','completed','$locationname','$locationcode','$desipaddress','$desusername')";
	$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $querydisp) or die ("Error in Querydisp".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
			
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
		        //echo '<br>'. 
			
					
					$query21 = "insert into billing_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,ledgercode,ledgername,incomeledger,incomeledgercode,fxrate,fxamount) 
				     values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$billdate','$ipaddress','$accountname','unpaid','$medicinecode','$billnumber','$username','$pharmacycoa','$locationname','$locationcode','','$amount','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$ledgercode','$ledgername','$incomeledger','$incomeledgercode','$fxrate','$amount')";
					$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"])); 
	
				 
		        //$query2 = "insert into billing_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode) 
				//values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$billdate','$ipaddress','$accountname','unpaid','$medicinecode','$billnumber','$username','$pharmacycoa','$locationname','$locationcode')";
				//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			
							
			}


			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharm set billing='completed',pharmacybill='completed' where medicinecode='$medicinecode' and patientvisitcode='$visitcode' and amendstatus ='2' and auto_number='$pharmano'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query314=mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharm set paymentstatus='completed',approvalstatus='1' where medicinecode='$medicinecode' and patientvisitcode='$visitcode' and amendstatus ='2' and auto_number='$pharmano' and billtype='PAY LATER'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	        $query38=mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharmissue set paymentstatus='completed' where medicinecode='$medicinecode' and patientvisitcode='$visitcode' and amendstatus ='2' and auto_number='$pharmano'");

			
			$query54 = "update master_consultationpharm set excludebill='completed' where medicinecode='$medicinecode' and patientvisitcode='$visitcode' and excludestatus='excluded' and amendstatus ='2' and auto_number='$pharmano'";
			$exec54 = mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query55 = "update master_consultationpharmissue set excludebill='completed' where medicinecode='$medicinecode' and patientvisitcode='$visitcode' and excludestatus='excluded' and amendstatus ='2' and auto_number='$pharmano'";
			$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		if($dispensingfee != '')
		{
				$query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
					 $res55 = mysqli_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
				$query551 = "insert into billing_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode,transactionmode,cashamount,cashcode,ledgercode,ledgername,incomeledger,incomeledgercode) 
				values('$patientcode','$patientname','$visitcode','Dispensing Fee','1','$dispensingfee','$dispensingfee','$billdate','$ipaddress','$accountname','unpaid','dispensingfee','$billnumber','$username','$pharmacycoa','$locationname','$locationcode','CASH','$dispensingfee','$cashcode','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";
				//$exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
				
				$query552 = "update dispensingfee set status='completed' where docno='$dispensingdocno'";
				$exec552 = mysqli_query($GLOBALS["___mysqli_ston"], $query552) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
		}
		foreach($_POST['lab'] as $key=>$value)
		{
				    //echo '<br>'.$k;
		$labname=$_POST['lab'][$key];
		$labcode=$_POST['labcode'][$key];
		if($labcode==''){
				$labquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_lab where itemname='$labname'");
				$execlab=mysqli_fetch_array($labquery);
				$labcode=$execlab['itemcode'];
		}
		$labrate=$_POST['rate5'][$key];
		
			if($labname!="")
			{					
				$labquery124 =mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paynowlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,username,labcoa,locationname,locationcode,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,fxrate,fxamount,billingdatetime)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$billdate','unpaid','$billnumber','$username','$labcoa','$locationname','$locationcode','','$labrate','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$fxrate','$labrate','$updatedatetime')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		//$labquery1=mysql_query("insert into billing_paynowlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,username,labcoa,locationname,locationcode)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$billdate','unpaid','$billnumber','$username','$labcoa','$locationname','$locationcode')") or die(mysql_error());
			}
		}
		
		foreach($_POST['radiology'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['radiology'][$key];
		$radiologycode= $_POST['radiologyitemcode1'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
		
			if($radiologycode==''){
				$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_radiology where itemname='$pairvar'");
				$execradiology=mysqli_fetch_array($radiologyquery);
				$radiologycode=$execradiology['itemcode'];
				}
		
		
				if($pairvar!="")
				{	
				
					$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paynowradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,paymentstatus,billnumber,username,radiologycoa,locationname,locationcode,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,fxrate,fxamount)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$billdate','unpaid','$billnumber','$username','$radiologycoa','$locationname','$locationcode','','$pairs1','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$fxrate','$pairs1')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
											
				 }
		//$radiologyquery1=mysql_query("insert into billing_paynowradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,paymentstatus,billnumber,username,radiologycoa,locationname,locationcode)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$billdate','unpaid','$billnumber','$username','$radiologycoa','$locationname','$locationcode')") or die(mysql_error());
		}
		
		
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;
		$servicesname=$_POST["services"][$key];
		$servicescode=$_POST["sercode"][$key];

		if($servicescode==''){
				$servicequery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_services where itemname='$servicesname'");
				$execservice=mysqli_fetch_array($servicequery);
				$servicescode=$execservice['itemcode'];
		}
		
		$servicesrate=$_POST["rate3"][$key];
		$quantityser=$_POST['quantityser'][$key];
		$seramount=$_POST['seramount'][$key];
		$seramountfx=($servicesrate*$quantityser*$fxrate);
				/*for($se=1;$se<=$quantityser;$se++)
		{	*/
		if($servicesname!="")
		{	
			$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paynowservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,username,servicecoa,locationname,locationcode,serviceqty,amount,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,fxrate,fxamount)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$billdate','unpaid','$billnumber','$username','$servicecoa','$locationname','$locationcode','".$quantityser."','".$seramount."','','$seramount','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$fxrate','$seramountfx')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));											
		//$servicesquery1=mysql_query("insert into billing_paynowservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,username,servicecoa,locationname,locationcode,serviceqty,amount)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$billdate','unpaid','$billnumber','$username','$servicecoa','$locationname','$locationcode','".$quantityser."','".$seramount."')") or die(mysql_error());
		}
		/*}*/
		}
		
		foreach($_POST['departmentreferal'] as $key=>$value)
		{
		$pairs21= $_POST['departmentreferal'][$key];
		
		$pairvar21= $pairs21;
	    $pairs31= $_POST['departmentreferalrate4'][$key];
		$pairvar31= $pairs31;
		
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_department where department ='$pairvar21'");
		$execreferal1=mysqli_fetch_array($referalquery1);
		$referalcode1=$execreferal1['auto_number'];
			if($referalcode1==''){ 
						$referalcode1= $_POST['departmentrefcode'][$key];
				}

		//echo $pairs2;
		if($pairvar21!="")
		{	
			 
		$referalquery122=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,fxrate,fxamount)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','','$pairvar31','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$fxrate','$pairvar31')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		//$referalquery1=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode')") or die(mysql_error());
		
		}
		}
		
		foreach($_POST['referal'] as $key=>$value)
		{
		$pairs2= $_POST['referal'][$key];
		$pairvar21= $pairs2;
	    $pairs3= $_POST['rate4'][$key];
		$pairvar31= $pairs3;

		$refdoccode = $_POST['refdoccode'][$key];
		$refdocname = $_POST['refdocname'][$key];
		$refsharingpercentage = $_POST['refsharingperc'][$key];
		$refsharingamount = $_POST['refsharingamt'][$key];
		$visittype = $_POST['visittype'][$key];


//residental doctor

	$rsltr_sharing= resident_doctor_sharing($refdoccode,$billdate,$pairvar31);

     $is_resdoc=$rsltr_sharing['is_resident'];
	 if($is_resdoc==1){
	 $refsharingamount=$rsltr_sharing['sharing_amt'];
	 $refsharingpercentage=$rsltr_sharing['sharing_per'];
	 }

   /// residental doctor

   
		
		$referalquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_doctor where doctorname='$pairvar21'");
		$execreferal=mysqli_fetch_array($referalquery);
		$referalcode1=$execreferal['doctorcode'];
		
		//echo $pairs2;
		if($pairvar21!="")
		{	
					 
			$referalquery122=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,fxrate,fxamount,doctorcode,doctorname,consultation_percentage,sharingamount,visittype,is_resdoc)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','SPLIT','$pairvar31','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$fxrate','$pairvar31','$refdoccode','$refdocname','$refsharingpercentage','$refsharingamount','$visittype','$is_resdoc')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		//$referalquery1=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode)values('$patientcode','$patientname','$visitcode','$referalcode','$pairvar2','$pairvar3','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode')") or die(mysql_error());
		
		}
		}
	if($referalcode == '')
		{
		//$debitcoa = '';
		mysqli_query($GLOBALS["___mysqli_ston"], "update billing_paylater set debitcoa='' where visitcode='$visitcode'");
		}
	//mysql_query("insert into billing_paynow(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,referalname,doctorstatus,billstatus,username,subtype,consultationid,creditcoa,debitcoa,locationname,locationcode,fxrate,fxamount)values('$billnumber','$patientname','$patientcode','$visitcode','$totalamount','$billdate','$accountname','$referalname','unpaid','paid','$username','$subtype','$consultationid','$referalcode','$debitcoa','$locationname','$locationcode','$fxrate','$totalamount')") or die(mysql_error());
		foreach($_POST['pharmacy_discamount'] as $key=>$value)
		{
			$pw_pharmacy = $_POST['pharmacy_discamount'][$key];
			$pw_fxpharmacy = $pw_pharmacy;
			
			$querypwp = "select visitcode from billing_patientweivers where patientcode = '$patientcode' and visitcode = '$visitcode' and billno = '$billnumber'";
			$execpwp = mysqli_query($GLOBALS["___mysqli_ston"], $querypwp) or die ("Error in Querypwp".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowpwp = mysqli_num_rows($execpwp);
			if($rowpwp == 0)
			{
				$querypwp1 = "INSERT INTO `billing_patientweivers`(`billno`, `entrydate`, `patientcode`, `visitcode`, `patientname`, `billtype`, `accountnameid`, `accountnameano`, `accountname`, `pharmacyamount`, `pharmacyfxamount`, `locationcode`, `locationname`, `username`, `ipaddress`, `updatedatetime`) 
							  VALUES('$billnumber','$billdate','$patientcode','$visitcode','$patientname','PAY NOW','$accountcode','$accountnameano','$accountname','$pw_pharmacy','$pw_fxpharmacy','$locationcode','$locationname','$username','$ipaddress','$updatedatetime')";							  
				$execpwp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwp1) or die ("Error in Querypwp1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$querypwp1 = "UPDATE `billing_patientweivers` SET `pharmacyamount` = '$pw_pharmacy', `pharmacyfxamount` = '$pw_fxpharmacy' WHERE patientcode = '$patientcode' and visitcode = '$visitcode' and billno = '$billnumber'";
				$execpwp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwp1) or die ("Error in Querypwp1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
		foreach($_POST['lab_discamount'] as $key=>$value)
		{
			$pw_lab = $_POST['lab_discamount'][$key];
			$pw_fxlab = $pw_lab;
			
			$querypwl = "select visitcode from billing_patientweivers where patientcode = '$patientcode' and visitcode = '$visitcode' and billno = '$billnumber'";
			$execpwl = mysqli_query($GLOBALS["___mysqli_ston"], $querypwl) or die ("Error in Querypwl".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowpwl = mysqli_num_rows($execpwl);
			if($rowpwl == 0)
			{
				$querypwl1 = "INSERT INTO `billing_patientweivers`(`billno`, `entrydate`, `patientcode`, `visitcode`, `patientname`, `billtype`, `accountnameid`, `accountnameano`, `accountname`, `labamount`, `labfxamount`, `locationcode`, `locationname`, `username`, `ipaddress`, `updatedatetime`) 
							  VALUES('$billnumber','$billdate','$patientcode','$visitcode','$patientname','PAY NOW','$accountcode','$accountnameano','$accountname','$pw_lab','$pw_fxlab','$locationcode','$locationname','$username','$ipaddress','$updatedatetime')";							  
				$execpwl1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwl1) or die ("Error in Querypwl1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$querypwl1 = "UPDATE `billing_patientweivers` SET `labamount` = '$pw_lab', `labfxamount` = '$pw_fxlab' WHERE patientcode = '$patientcode' and visitcode = '$visitcode' and billno = '$billnumber'";
				$execpwl1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwl1) or die ("Error in Querypwl1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
		foreach($_POST['radiology_discamount'] as $key=>$value)
		{
			$pw_radiology = $_POST['radiology_discamount'][$key];
			$pw_fxradiology = $pw_radiology;
			
			$querypwr = "select visitcode from billing_patientweivers where patientcode = '$patientcode' and visitcode = '$visitcode' and billno = '$billnumber'";
			$execpwr = mysqli_query($GLOBALS["___mysqli_ston"], $querypwr) or die ("Error in Querypwr".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowpwr = mysqli_num_rows($execpwr);
			if($rowpwr == 0)
			{
				$querypwr1 = "INSERT INTO `billing_patientweivers`(`billno`, `entrydate`, `patientcode`, `visitcode`, `patientname`, `billtype`, `accountnameid`, `accountnameano`, `accountname`, `radiologyamount`, `radiologyfxamount`, `locationcode`, `locationname`, `username`, `ipaddress`, `updatedatetime`) 
							  VALUES('$billnumber','$billdate','$patientcode','$visitcode','$patientname','PAY NOW','$accountcode','$accountnameano','$accountname','$pw_radiology','$pw_fxradiology','$locationcode','$locationname','$username','$ipaddress','$updatedatetime')";							  
				$execpwr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwr1) or die ("Error in Querypwr1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$querypwr1 = "UPDATE `billing_patientweivers` SET `radiologyamount` = '$pw_radiology', `radiologyfxamount` = '$pw_fxradiology' WHERE patientcode = '$patientcode' and visitcode = '$visitcode' and billno = '$billnumber'";
				$execpwr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwr1) or die ("Error in Querypwr1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
		foreach($_POST['services_discamount'] as $key=>$value)
		{
			$pw_services = $_POST['services_discamount'][$key];
			$pw_fxservices = $pw_services;
			
			$querypws = "select visitcode from billing_patientweivers where patientcode = '$patientcode' and visitcode = '$visitcode' and billno = '$billnumber'";
			$execpws = mysqli_query($GLOBALS["___mysqli_ston"], $querypws) or die ("Error in Querypws".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowpws = mysqli_num_rows($execpws);
			if($rowpws == 0)
			{
				$querypws1 = "INSERT INTO `billing_patientweivers`(`billno`, `entrydate`, `patientcode`, `visitcode`, `patientname`, `billtype`, `accountnameid`, `accountnameano`, `accountname`, `servicesamount`, `servicesfxamount`, `locationcode`, `locationname`, `username`, `ipaddress`, `updatedatetime`) 
							  VALUES('$billnumber','$billdate','$patientcode','$visitcode','$patientname','PAY NOW','$accountcode','$accountnameano','$accountname','$pw_services','$pw_fxservices','$locationcode','$locationname','$username','$ipaddress','$updatedatetime')";							  
				$execpws1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypws1) or die ("Error in Querypws1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$querypws1 = "UPDATE `billing_patientweivers` SET `servicesamount` = '$pw_services', `servicesfxamount` = '$pw_fxservices' WHERE patientcode = '$patientcode' and visitcode = '$visitcode' and billno = '$billnumber'";
				$execpws1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypws1) or die ("Error in Querypws1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	if($patientpaymenttype == 'PAY NOW')
	{
		mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set overallpayment='completed' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_query($GLOBALS["___mysqli_ston"], "update master_triage set overallpayment='completed' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
		if ($paymentmode == 'CASH')
		{
			
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
		
		
		$queryforex = "insert into forex_billing (patientfirstname,patientmiddlename, patientlastname,patientcode, visitcode, billnumber,
		 billingdatetime, billentryby,ipaddress, username, recordstatus,patientfullname,currency,currencyrate,currencyqty,currencytotal,billtype,patienttype,locationname,locationcode) 
		values('$patientfirstname','$patientmiddlename','$patientlastname','$patientcode','$visitcode','$billnumbercode', '$billingdatetime', '$username',  '$ipaddress','$username','$recordstatus','$patientname','".$currencyname."','".$currencyamt."','".$fxamount."','".$amounttot."','".$billtype."','".$paymenttype."','$locationname','$locationcode')";
		$execforex = mysqli_query($GLOBALS["___mysqli_ston"], $queryforex) or die ("Error in Queryforex".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo '<br>';
		}
		
	    //$billnumber= $_REQUEST['billno'];
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $cashcode = $res55['ledgercode']; 
					
		$query9 = "insert into master_transactionpaynow (transactiondate, transactiontime, particulars, patientcode,patientname,  visitcode, paymenttype, subtype,  
	    accountname, transactionmode, transactiontype, transactionmodule, transactionamount, cashamount, balanceamount, billnumber, billanum, remarks, ipaddress, updatedate, companyanum,
		companyname, financialyear, doctorname, billstatus, username, cashgiventocustomer, cashgivenbycustomer,locationname,locationcode,cashcode)
		values ('$billdate', '$timeonly', '$particulars', '$patientcode', '$patientname', '$visitcode', '$paymenttype', '$subtype', '$accountname', '$transactionmode', '$transactiontype',
	    '$transactionmodule', '$totalamount', '".$cashtakenfromcustomer."', '$balanceamount', '$billnumber', '$billanum', '$remarks', '$ipaddress', '$updatedate', '$companyanum', '$companyname' ,  
        '$financialyear', '$doctorname', 'paid', '$username', '$cashgiventocustomer','$cashgivenbycustomer','$locationname','$locationcode','$cashcode')";
		
		
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$cashcoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	
		
		$query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode']; 
		 
		$query9 = "insert into master_transactionpaynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount, onlineamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,paymenttype,subtype,transactiontime,cashgiventocustomer,cashgivenbycustomer,onlinenumber,locationname,locationcode,bankcode) 
		values ('$billdate','$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$totalamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$paymenttype','$subtype','$timeonly','$cashgiventocustomer','$cashgivenbycustomer','$onlinenumber','$locationname','$locationcode','$bankcode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$onlinecoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;	
		
		$query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode']; 
		 	
			$query9 = "insert into master_transactionpaynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		chequeamount,chequenumber, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,paymenttype,subtype,transactiontime,cashgiventocustomer,cashgivenbycustomer,locationname,locationcode,bankcode) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$totalamount','$chequenumber',  '$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$paymenttype','$subtype','$timeonly','$cashgiventocustomer','$cashgivenbycustomer','$locationname','$locationcode','$bankcode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$chequecoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}
	
	if($paymentmode == 'CREDIT CARD')
	{
	$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT CARD';
		$particulars = 'BY CREDIT CARD '.$billnumberprefix.$billnumber;		
		
		$query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode']; 
		 
			$query9 = "insert into master_transactionpaynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		cardamount, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, transactionmodule, patientname, patientcode, visitcode, accountname, doctorname, billstatus, financialyear, username, creditcardname, creditcardnumber, creditcardbankname, paymenttype, subtype, transactiontime, cashgiventocustomer, cashgivenbycustomer, locationname, locationcode, bankcode) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$totalamount','$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$card','$cardnumber','$bankname1','$paymenttype','$subtype','$timeonly','$cashgiventocustomer','$cashgivenbycustomer','$locationname','$locationcode','$bankcode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$cardcoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}
	
		if ($paymentmode == 'SPLIT')
		{
			$adjustamount = $_REQUEST['adjustamount'];
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
		$transactiontype = 'PAYMENT';
		$transactionmode = 'SPLIT ';
		$particulars = 'BY SPLIT'.$billnumberprefix.$billnumber.'';	
	//echo '<br>';
		
		
		$queryforex = "insert into forex_billing (patientfirstname,patientmiddlename, patientlastname,patientcode, visitcode, billnumber,
		 billingdatetime, billentryby,ipaddress, username, recordstatus,patientfullname,currency,currencyrate,currencyqty,currencytotal,billtype,patienttype,locationname,locationcode) 
		values('$patientfirstname','$patientmiddlename','$patientlastname','$patientcode','$visitcode','$billnumbercode', '$billingdatetime', '$username',  '$ipaddress','$username','$recordstatus','$patientname','".$currencyname."','".$currencyamt."','".$fxamount."','".$amounttot."','".$billtype."','".$paymenttype."','$locationname','$locationcode')";
		$execforex = mysqli_query($GLOBALS["___mysqli_ston"], $queryforex) or die ("Error in Queryforex".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo '<br>';
		}
		
		$query55 = "select * from financialaccount where transactionmode = 'SPLIT'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $cashcode = $res55['ledgercode'];
		
		 $bankcode = '';
		 
		 $mpesacode = '';
					 
		$query9 = "insert into master_transactionpaynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		cardamount, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,creditcardname,creditcardnumber,creditcardbankname,paymenttype,subtype,transactiontime,cashgiventocustomer,cashgivenbycustomer,cashamount,onlineamount,chequeamount,chequenumber,creditamount,onlinenumber,mpesanumber,locationname,locationcode,cashcode, bankcode, mpesacode,adjustamount) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$cardamount','$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$card','$cardnumber','$bankname1','$paymenttype','$subtype','$timeonly','$cashgiventocustomer','$cashgivenbycustomer','".$cashtakenfromcustomer."','$onlineamount','$chequeamount','$chequenumber','$creditamount','$onlinenumber','$mpesanumber','$locationname','$locationcode','$cashcode', '$bankcode', '$mpesacode','$adjustamount')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,cash,cashcoa,cheque,chequecoa,online,onlinecoa,adjust,mpesa,mpesacoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$cardamount','$cardcoa','$cashamount','$cashcoa','$chequeamount','$chequecoa','$onlineamount','$onlinecoa','$adjustamount','$creditamount','$mpesacoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    	
		if (isset($_REQUEST["net_deposit_amt"])) 
		{ 
			$adv_dep_bal_amt = $_REQUEST["net_deposit_amt"]; 
		} 
		else 
		{ 
			$adv_dep_bal_amt = 0; 
		}
		 // Check if the patient has advance deposit amount
		 $query_dep = "select patientname,patientcode,sum(transactionamount) amt from master_transactionadvancedeposit where patientcode='$patientcode' group by patientcode";
		 $exec_dep = mysqli_query($GLOBALS["___mysqli_ston"], $query_dep) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		 $num_dep_rows = mysqli_num_rows($exec_dep);	
		 if($num_dep_rows)
		 {
		 	// the patient has advance deposit amount
		 	if($adjustamount > 0)
			{
				$query_adjust = "INSERT INTO `adjust_advdeposits` (`id`, `locationcode`, `patientcode`, `visitcode`, `billno`, `adjustamount`, `balamt`, `billdate`, `username`, `ipaddress`) VALUES (NULL, '$locationcode', '$patientcode', '$visitcode', '$billnumber', '$adjustamount', '$adv_dep_bal_amt', '$billdate', '$username', '$ipaddress')";
				$exec_adjust = mysqli_query($GLOBALS["___mysqli_ston"], $query_adjust) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		 }
		}
		
		if ($paymentmode == 'MPESA')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'MPESA';
		$particulars = 'BY MPESA'.$billnumberprefix.$billnumber.'';	
		
		$query552 = "select * from financialaccount where transactionmode = 'MPESA'";
		 $exec552 = mysqli_query($GLOBALS["___mysqli_ston"], $query552) or die ("Error in Query552".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res552 = mysqli_fetch_array($exec552);
		 $mpesacode = $res552['ledgercode'];
	
		$query9 = "insert into master_transactionpaynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount, creditamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,paymenttype,subtype,transactiontime,cashgiventocustomer,cashgivenbycustomer,mpesanumber,locationname,locationcode,mpesacode) 
		values ('$billdate','$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$totalamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$paymenttype','$subtype','$timeonly','$cashgiventocustomer','$cashgivenbycustomer','$mpesanumber','$locationname','$locationcode','$mpesacode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$mpesacoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		}
		
		header("location:patientbillingstatus_bills.php?paynowpatientcode=$patientcode&&paynowbillnumber=$billnumber");
		exit;
		}
		
		else
		{
		header("location:patientbillingstatus_bills.php");
		}
		}
		else
		{
		header("location:patientbillingstatus_bills.php");
		}
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
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];
$patientpaymenttype = $execlab['billtype'];
$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$currency=$execsubtype['currency'];
//$fxrate=$execsubtype['fxrate'];
if($currency != 'UGX')
{
	$query = mysqli_query($GLOBALS["___mysqli_ston"], "select rate from master_currency where currency = '$currency'");
	$res = mysqli_fetch_array($query);
	$num = mysqli_num_rows($query);
	if($num > 0){
	$currconvertrate = $res['rate'];
	$fxrate= $res['rate'];
	} else {
	$currconvertrate = '1';
	$fxrate= '1';
	}
}else{
$currency='UGX';
$currconvertrate = '1';
$fxrate= '1';
}
?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
 $patientname=$execlab1['customerfullname'];
 
 $patientfirstname=$execlab1['customername'];
 $patientmiddlename=$execlab1['customermiddlename'];
 $patientlastname=$execlab1['customerlastname'];
 
 $querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select locationcode,accountname,visittype from master_visitentry where visitcode='$visitcode'");
$execlab2=mysqli_fetch_array($querylab2);
 $locationcode=$execlab2['locationcode'];

$patientaccount=$execlab2['accountname'];
$pvtype = $execlab2["visittype"];

//location get here
 //$locationcode=$execlab1['locationcode'];
//get locationname from location code
$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select locationname from master_location where locationcode='".$locationcode."'");
$execlab2=mysqli_fetch_array($querylab2);
 $locationname=$execlab2['locationname'];
$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];
$accountcode = $execlab2['id'];
$accountnameano = $execlab2['auto_number'];
$query76 = "select * from master_financialintegration where field='labpaynow'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$labcoa = $res76['code'];
$query761 = "select * from master_financialintegration where field='radiologypaynow'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res761 = mysqli_fetch_array($exec761);
$radiologycoa = $res761['code'];
$query762 = "select * from master_financialintegration where field='servicepaynow'";
$exec762 = mysqli_query($GLOBALS["___mysqli_ston"], $query762) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res762 = mysqli_fetch_array($exec762);
$servicecoa = $res762['code'];
$query763 = "select * from master_financialintegration where field='referalpaynow'";
$exec763 = mysqli_query($GLOBALS["___mysqli_ston"], $query763) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res763 = mysqli_fetch_array($exec763);
$referalcoa = $res763['code'];
$query764 = "select * from master_financialintegration where field='pharmacypaynow'";
$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res764 = mysqli_fetch_array($exec764);
$pharmacycoa = $res764['code'];
$query765 = "select * from master_financialintegration where field='cashpaynow'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);
$cashcoa = $res765['code'];
$query766 = "select * from master_financialintegration where field='chequepaynow'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);
$chequecoa = $res766['code'];
$query767 = "select * from master_financialintegration where field='mpesapaynow'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);
$mpesacoa = $res767['code'];
$query768 = "select * from master_financialintegration where field='cardpaynow'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);
$cardcoa = $res768['code'];
$query769 = "select * from master_financialintegration where field='onlinepaynow'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);
$onlinecoa = $res769['code'];

$query768 = "select locationname from master_location where locationcode='$locationcode'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);
 $locationname = $res768['locationname'];
?>
<?php
$query3 = "select * from bill_formats where description = 'bill_paynow'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = $res3['prefix'];
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from billing_paynow order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{

		$billnumbercode =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
		$openingbalance = '0.00';
}
else
{
	/*$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode=abs($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;*/
	
	$billnumber = $res2["billno"];
	$maxcount=split("-",$billnumber);
	$maxcount1=$maxcount[1];
	$maxanum = $maxcount1+1;

	$billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
	$openingbalance = '0.00';
	//echo $companycode;
}
$query3 = "select count(auto_number) as counts from billing_pharmacy where patientcode = '".$patientcode."' AND patientvisitcode='".$visitcode."'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
 $dispensingcount = $res3['counts'];
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
	funcPopupPrintFunctionCall();
	//alert ("Auto Print Function Runs Here.");	
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
	//alert ("Auto Print Function Runs Here.");
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
	//alert(varBillNumber);
	var varBillAutoNumber ="<?php //echo $previousbillautonumber; ?>" ;
	//alert(varBillAutoNumber);
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
		window.open("print_paynow.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_paynow_a5.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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
		window.location="billing_paynow.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";
		<?php
		}
		else
		{
		?>
		window.location="billing_paynow.php?defaulttax="+varDefaultTax+"";
		<?php
		}
		?>
	}
	else
	{
		window.location="billing_paynow.php";
	}
	//return false;
}
</script>
<script type="text/javascript">
/*function balancecalc(mode)
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
var balance =  document.getElementById("totalamount").value;
var totalamount = parseFloat(cashamount)+parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount);
var newbalance=parseFloat(balance) - parseFloat(totalamount);
newbalance = newbalance.toFixed(2);
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
if(newbalance == -0.00)
{
newbalance = 0;
newbalance = newbalance.toFixed(2);
}
document.getElementById("tdShowTotal").innerHTML = newbalance;
}*/
function balancecalc(mode)
{
	var mode = mode;
	
	var cashgivenbycustomer = document.getElementById("cashgivenbycustomer").value;
	if(cashgivenbycustomer == '')
	{
		cashgivenbycustomer = 0;
	}
	var billtype = document.getElementById("billtype").value;
	//alert(cashamount);
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
	var balance =  document.getElementById("totalamount").value;
	var totalamount = parseFloat(cashgivenbycustomer)+parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount) + parseFloat(adjustamount);
	
	//alert(totalamount);
	var newbalance=parseFloat(balance) - parseFloat(totalamount);
	
	if(newbalance < 0)
	{
		alert("Given amount already exits the Bill amount!");
		
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
		
		/*var cashpay=document.getElementById("cashgivenbycustomer").value;
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
		}*/
		return false;
	}
	
	var balance =  document.getElementById("totalamount").value;
	var cashpay=document.getElementById("cashgivenbycustomer").value;
	if(cashpay==''){
		cashpay=0.00;
	}
	var mpaypay=document.getElementById("creditamount").value;
	var cheqpay=document.getElementById("chequeamount").value;
	var cardpay=document.getElementById("cardamount").value;
	var onlipay=document.getElementById("onlineamount").value;
	var totalamount = parseFloat(cashpay)+parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount)+ parseFloat(adjustamount);
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
	
document.getElementById("tdShowTotal").innerHTML=(document.getElementById("tdShowTotal").innerHTML).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//document.getElementById("tdShowTotal").innerHTML = newbalance.toFixed(2);
}
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
				if(cashpay==''){
						cashpay=0.00;
				}
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
				if(cashpay==''){
					cashpay=0.00;
				}
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
	
	document.getElementById("tdShowTotal").innerHTML=(document.getElementById("tdShowTotal").innerHTML).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	
	funcPaymentInfoCalculation1();
}
</script>
<?php include ("js/sales1scripting_new_adj.php"); ?>
<script type="text/javascript" src="js/insertitemcurrencyfx.js"></script>
<script type="text/javascript" src="js/insertnewitem7.js"></script>
<style type="text/css">
.bodytext3 {
	FONT-WEIGHT: normal;
	FONT-SIZE: 11px;
	/* [disabled]COLOR: #3B3B3C; */
	FONT-FAMILY: Tahoma
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
<script>
function printPaynowBill()
 {
var popWin; 
popWin = window.open("print_billpaynowbill_dmp4inch1.php?patientcode=<?php echo $patientcode; ?>&&billautonumber=<?php echo $billnumbercode; ?>&&ranum=<?php echo (rand(10,100)); ?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
 }
</script>
<script>
function funcSaveBill13()
{
	
var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry.....?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
	else
	{
		//alert ("Entry Saved.");
		document.frmsales.submit();
		//return true;
	}
	}
	</script>
	
<script>	
function loadprintpage3()
{
	var varBillNumber1 = document.getElementById("quickprintbill").value;
	
	window.open("print_paynow.php?billautonumber="+varBillNumber1+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
<script>	
function quickprintbill2sales()
{
   
	var varBillNumber1 = document.getElementById("quickprintbill").value;
	
	window.open("print_paynow_dmp4inch1view1.php?billautonumber="+varBillNumber1+"","OriginalWindowA4<?php echo $banum; ?>",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
</head>
<script>
function funcPopupOnLoader()
{
funcOnLoadBodyFunctionCall();
<?php 
if (isset($_REQUEST["savedpatientcode"])) { $savedpatientcode = $_REQUEST["savedpatientcode"]; } else { $savedpatientcode = ""; }
?>
var patientcodes;
var patientcodes = "<?php echo $savedpatientcode; ?>";
//alert(patientcodes);
if(patientcodes != "") 
{
	window.open("print_registration_label.php?previouspatientcode="+patientcodes+" ","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
}
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall()">
<form name="form1" id="form1" method="post" action="billing_paynow.php" onKeyDown="return disableEnterKey(event)" onSubmit="return funcSaveBill1()">
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
                <tr >
                <td colspan="6" bgcolor="#ecf0f5" class="bodytext32"><strong>Pay Now Patient Details</strong></td>
                
                <td  bgcolor="#ecf0f5" class="bodytext32"><strong>Location:&nbsp;&nbsp;<?php echo $locationname ?> </strong></td>
                 <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>">
                <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>">
			 </tr>
			 <?php
			 if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
			 if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
				//$st = $_REQUEST["st"];
				
     		 if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
			if ($st == 'success' && $billautonumber != '')
			{
			?>
            <tr>
             
              <td colspan="8"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage3()" value="Click Here To Print Invoice" class="button" style="border: 1px solid #001E6A"/>			  </td>
            </tr>
			<?php
			}
			?>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			  <tr>
			    <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  </strong></td>
                <td width="20%" align="left" valign="top" class="bodytext3"><?php echo $patientname; ?>
				<input type="hidden" name="patientname" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>                  
                <input type="hidden" name="patientfirstname" value="<?php echo $patientfirstname;?>">
                <input type="hidden" name="patientmiddlename" value="<?php echo $patientmiddlename;?>">
                <input type="hidden" name="patientlastname" value="<?php echo $patientlastname;?>">
                </td>
                 
                <td width="17%" align="left" valign="top" class="bodytext3"><strong>Reg.No</strong></td>
                <td width="15%" align="left" valign="top" class="bodytext3"><?php echo $patientcode; ?></td>
                <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="22%" colspan="3" align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>			<?php echo $visitcode; ?></td>
		      </tr>
			   <tr>
			    <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Bill No</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="hidden" name="customercode" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
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
                <input type="hidden" name="patientage" value="<?php echo $patientage; ?>">
                <input type="hidden" name="patientgender" value="<?php echo $patientgender; ?>">
				<?php echo $billnumbercode; ?>
				
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
				    <td align="left" valign="top" class="bodytext3"><strong>Bill Date</strong></td>
				    <td align="left" valign="top" class="bodytext3"><?php echo $dateonly; ?></td>
				    <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				<?php echo $patientaccount1; ?></td>
              	<input type="hidden" name="account" id="account" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
			  </tr>
				 	<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>								
					<input type="hidden" name="p_accountname" id="p_accountname" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
					<input type="hidden" name="p_accountcode" id="p_accountcode" value="<?php echo $accountcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
					<input type="hidden" name="p_accountnameano" id="p_accountnameano" value="<?php echo $accountnameano; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
				 
                  <input type="hidden" name="account1" id="account1" value="<?php echo $patientplan1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>			
				  <input type="hidden" name="account2" id="account2" value="" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
				 <input type="hidden" name="fxrate" id="fxrate" value="<?php echo $fxrate; ?>">
				  	<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
            </tbody>
        </table>
   </td>
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
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Check</strong></div></td>
                  </tr>
			  <?php 
			  $query_pw = "select `docno`, `entrydate`, `consult_discamount`, `pharmacy_discamount`, `lab_discamount`, `radiology_discamount`, `services_discamount` from patientweivers where visitcode='$visitcode' and patientcode='$patientcode' order by auto_number desc";
			$exec_pw = mysqli_query($GLOBALS["___mysqli_ston"], $query_pw) or die ("Error in Query_pw".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_pw = mysqli_fetch_array($exec_pw);
			$consult_discamount = $res_pw['consult_discamount'];
			$pharmacy_discamount = $res_pw['pharmacy_discamount'];
			$lab_discamount = $res_pw['lab_discamount'];
			$radiology_discamount = $res_pw['radiology_discamount'];
			$services_discamount = $res_pw['services_discamount'];+
			$pw_docno = $res_pw['docno'];
			$pw_entrydate = $res_pw['entrydate'];
			 
			  $totallab=0;
			  $query19 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and approvalstatus !='0' ";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$labrec = mysqli_num_rows($exec19);
			while($res19 = mysqli_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			// $labitemcode=$res19['labitemcode'];
			if($res19['billtype'] == 'PAY LATER'){
				$labrate=$res19['cash_copay'];
			} else {
				$labrate=$res19['labitemrate'];
			}
			$labcode=$res19['labitemcode'];
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
			  <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $labrate; ?>">
			 <input name="labcode[]" id="labcode" type="hidden" value="<?php echo $labcode; ?>">
			 <input name="refno<?php echo $sno; ?>" id="refno<?php echo $sno; ?>" type="hidden" value="<?php echo $labrefno; ?>">
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate, 2, '.', ','); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
             </tr>
			  
			  <?php 
			  }
			  if($lab_discamount > 0 && $labrec>0)
			  {
			  $totallab=$totallab-$lab_discamount;
			  ?>
              <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Lab Discount'; ?></div></td>
			  <input name="lab_discamount[]" id="lab_discamount" type="hidden" value="<?php echo $lab_discamount; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_discamount, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_discamount, 2, '.', ','); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
             </tr>
			  <?php
			  }
			  ?>
			   <?php
		
			   $totalpharm=0;
			   $pharmno=0;
			$query23 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and pharmacybill='pending' and medicineissue='pending' and billing='' and approvalstatus !='0' and (amendstatus='1' OR amendstatus=2)";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$pharmtotalno=mysqli_num_rows($exec23);
			while($res23 = mysqli_fetch_array($exec23))
			{
			$phadate=$res23['recorddate'];
			$phaname=$res23['medicinename'];
			$medicinecode1=$res23['medicinecode'];
			$phaquantity=$res23['quantity'];
			$pharate=$res23['rate'];
			$pharm_auto_number=$res23['auto_number'];
			$pharm_cash_copay=$res23['cash_copay'];
			
			if($pharate=='0.00'){
				$query77="select rateperunit from master_medicine where itemcode='$medicinecode1' and status <> 'deleted'";
				// $query77="select rateperunit from master_medicine where itemname='$phaname' and status <> 'deleted'";
				$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
				$res77=mysqli_fetch_array($exec77);
				$pharate=$res77['rateperunit'];
			}
	
			$amendstatus=$res23['amendstatus'];
			$phaamount=0;
			if($amendstatus=='2')
			{
			$phaamount=$phaquantity * $pharate;
			}
			//$phaamount = ceil($phaamount/5) * 5;
			$pharefno=$res23['refno'];
			$billtype=$res23['billtype'];
			$excludestatus=$res23['excludestatus'];
			$excludebill = $res23['excludebill'];
			$approvalstatus = $res23['approvalstatus'];
			if($billtype == 'PAY LATER')
			{
				
			if($pharm_cash_copay>0){
			$phaquantity=1;		
			$pharate=$phaamount=$pharm_cash_copay;
			}
			
			if(($excludestatus == 'excluded')&&($excludebill == '') || $approvalstatus=='2')
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
			$totalpharm=$totalpharm+$phaamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phaname; ?></div></td>
			  <input type="hidden" name="pharmname[]" value="<?php echo $phaname; ?>">			  
			  <input name="pharmano[]" type="hidden" id="pharmano" size="25" value="<?php echo $pharm_auto_number; ?>">
			  <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			   <input name="medicinecode1[]" type="hidden" id="medicinecode1" size="25" value="<?php echo $medicinecode1; ?>">
		 <input name="refno<?php echo $sno; ?>" id="refno<?php echo $sno; ?>" type="hidden" value="<?php echo $pharefno; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $phaquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $phaamount; ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phaquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount, 2, '.', ','); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><?php if($amendstatus=='2'){?><img src="img/selected.png" width="15" height="15"><?php }?>&nbsp;</strong></div></td>
             </tr>
			  
			  <?php 
			 }
			  }
			  if($billtype == 'PAY NOW')
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
			$totalpharm=$totalpharm+$phaamount;
			$pharmno=$pharmno+1;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			  <input type="hidden" name="pharmname[]" value="<?php echo $phaname; ?>">
			  <input name="pharmano[]" type="hidden" id="pharmano" size="25" value="<?php echo $pharm_auto_number; ?>">
			  <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			   <input name="medicinecode1[]" type="hidden" id="medicinecode1" size="25" value="<?php echo $medicinecode1; ?>">

			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $phaquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $phaamount; ?>">
		<input name="refno<?php echo $sno; ?>" id="refno<?php echo $sno; ?>" type="hidden" value="<?php echo $pharefno; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phaquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount, 2, '.', ','); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><?php if($amendstatus=='2'){?><img src="img/selected.png" width="15" height="15"><?php }?>&nbsp;</strong></div></td>
             
			  
			  <?php 
			  }
			  }
			  if($pharmacy_discamount > 0 && $pharmtotalno > 0)
			  {
			  if($amendstatus=='2'){
			  $totalpharm=$totalpharm-$pharmacy_discamount;
			  }
			  else
			  {
			  $pharmacy_discamount=0;
			  }
			  ?>
              <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Pharmacy Discount'; ?></div></td>
			  <input name="pharmacy_discamount[]" id="pharmacy_discamount" type="hidden" value="<?php echo $pharmacy_discamount; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_discamount, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_discamount, 2, '.', ','); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><?php if($amendstatus=='2'){?><img src="img/selected.png" width="15" height="15"><?php } ?></strong></div></td>
             </tr>
			  <?php
			  }
			  ?>
			  
			    <?php 
				$totalrad=0;
			  $query20 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and approvalstatus !='0' ";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$radrec=mysqli_num_rows($exec20);
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radiologyitemcode1=$res20['radiologyitemcode'];
			if($res20['billtype'] == 'PAY LATER'){
				$radrate=$res20['cash_copay'];
			} else {
				$radrate=$res20['radiologyitemrate'];
			}
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
			  <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			  <input name="radiologyitemcode1[]" id="radiologyitemcode1" type="hidden" size="69" autocomplete="off" value="<?php echo $radiologyitemcode1; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $radrate; ?>">
		<input name="refno<?php echo $sno; ?>" id="refno<?php echo $sno; ?>" type="hidden" value="<?php echo $radref; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate, 2, '.', ','); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
             
			  
			  <?php 
			  }
			  if($radiology_discamount > 0 && $radrec >0)
			  {
			  $totalrad=$totalrad-$radiology_discamount;
			  ?>
              <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Radiology Discount'; ?></div></td>
			  <input name="radiology_discamount[]" id="radiology_discamount" type="hidden" value="<?php echo $radiology_discamount; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_discamount, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_discamount, 2, '.', ','); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
             </tr>
			  <?php
			  }
			  ?>
			  	    <?php 
					
					$totalser=0;
			  $query21 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and approvalstatus !='0' group by servicesitemcode";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$serrec=mysqli_num_rows($exec21);
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$sercode=$res21['servicesitemcode'];
			if($res21['billtype'] == 'PAY LATER'){
				$serrate=$res21['cash_copay'];
			} else {
				$serrate=$res21['servicesitemrate'];
			}
			$serref=$res21['refno'];
			$quantity=$res21['serviceqty'];
			if($res21['billtype'] == 'PAY LATER'){
				$totserrate=$res21['cash_copay'];
			} else {
				$totserrate=$res21['amount'];
			}
			 
			
			$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and paymentstatus='pending' and approvalstatus !='0'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			
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
			$totalser=$totalser+$totserrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			  <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			  <input name="sercode[]" type="hidden" id="sercode" size="69" value="<?php echo $sercode; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $serrate; ?>">
		 	 <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $quantity; ?>">
             <input name="seramount[]" type="hidden" id="seramount" readonly size="8" value="<?php echo $totserrate; ?>">
		<input name="refno<?php echo $sno; ?>" id="refno<?php echo $sno; ?>" type="hidden" value="<?php echo $serref; ?>">	 
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totserrate,2,'.',','); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
             
			  
			  <?php 
			  }
			 if($services_discamount > 0 && $serrec > 0)
			  {
			  $totalser=$totalser-$services_discamount;
			  ?>
              <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Services Discount'; ?></div></td>
			  <input name="services_discamount[]" id="services_discamount" type="hidden" value="<?php echo $services_discamount; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_discamount, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_discamount, 2, '.', ','); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
             </tr>
			  <?php
			  }
			  ?>
			   <?php 
			   $totalconref=0;
			  $query22 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res22 = mysqli_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['referalname'];
			$refrate=$res22['referalrate'];
			$refref=$res22['refno'];

			$doccode=$res22['referalcode'];
			$docname=$res22['referalname'];
			$sharingq = "select consultation_percentage,op_consultation_private_sharing from master_doctor where doctorcode = '$doccode'";
			$execsharingq = mysqli_query($GLOBALS["___mysqli_ston"], $sharingq) or die ("Error in SharingQ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$ressharingq = mysqli_fetch_array($execsharingq);
			//$sharingperc = $ressharingq['consultation_percentage'];

			if($pvtype=='private')
				$sharingperc = $ressharingq['op_consultation_private_sharing'];
			else
				$sharingperc = $ressharingq['consultation_percentage'];

			$sharingamt = $refrate*($sharingperc/100);

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
			$totalconref=$totalconref+$refrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			  <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="rate4[]" type="hidden" id="rate4" readonly size="8" value="<?php echo $refrate; ?>">
			<input name="refdoccode[]" type="hidden" id="refdoccode" readonly size="8" value="<?php echo $doccode; ?>">
			 <input name="refdocname[]" type="hidden" id="refdocname" readonly size="8" value="<?php echo $docname; ?>">
			 <input name="refsharingperc[]" type="hidden" id="refsharingperc" readonly size="8" value="<?php echo $sharingperc; ?>">
			 <input name="refsharingamt[]" type="hidden" id="refsharingamt" readonly size="8" value="<?php echo $sharingamt; ?>">
		<input name="refno<?php echo $sno; ?>" id="refno<?php echo $sno; ?>" type="hidden" value="<?php echo $refref; ?>">	 
			 
			 <input name="visittype[]" id="visittype" value="<?php echo $pvtype; ?>" type="hidden" style="text-align:right" size="8" readonly />

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate, 2, '.', ','); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
             
			  
			  <?php }
			  ?>
             
              <?php 
			   $totalampref=0;
			  $query22 = "select * from op_ambulance where patientvisitcode='$visitcode' and billtype='PAY NOW' and patientcode='$patientcode' and paymentstatus='pending'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$ambcount=mysqli_num_rows($exec22);
			while($res22 = mysqli_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['description'];
			$refrate=$res22['rate'];
			$refamount=$res22['amount'];
			$refref=$res22['docno'];
			$qty=$res22['units'];
			
			$accountname=$res22['accountname'];
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
			$totalampref=$totalampref+$refamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			 <input name="rate4[]" type="hidden" id="rate4" readonly size="8" value="<?php echo $refrate; ?>">
             <input type="hidden" name="ambulancecount[]" value="<?php echo $sno-1;?>">
              <input name="accountname[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
               <input name="description[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
                <input name="quantity[]" type="hidden" id="quantity" readonly size="8" value="<?php echo $qty; ?>">
                 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $refrate; ?>">
                  <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $refamount; ?>">
                   <input name="amdocno[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>">
		<input name="refno<?php echo $sno; ?>" id="refno<?php echo $sno; ?>" type="hidden" value="<?php echo $refref; ?>">	 
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refamount, 2, '.', ','); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
             
			  
			  <?php }
			  ?><input type="hidden" name="ambcount" value="<?php echo $ambcount;?>">
              
               <?php 
			   $totalhomref=0;
			  $query22 = "select * from homecare where patientvisitcode='$visitcode' and billtype='PAY NOW' and patientcode='$patientcode' and paymentstatus='pending'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$ambcount1=mysqli_num_rows($exec22);
			while($res22 = mysqli_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['description'];
			$refrate=$res22['rate'];
			$refamount=$res22['amount'];
			$refref=$res22['docno'];
			$qty=$res22['units'];
			
			$accountname=$res22['accountname'];
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
			$totalhomref=$totalhomref+$refamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno1 = $sno1 + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			 <input name="rate4[]" type="hidden" id="rate4" readonly size="8" value="<?php echo $refrate; ?>">
             <input type="hidden" name="ambulancecount1[]" value="<?php echo $sno1-1;?>">
              <input name="accountname1[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
               <input name="description1[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
                <input name="quantity1[]" type="hidden" id="quantity" readonly size="8" value="<?php echo $qty; ?>">
                 <input name="rate1[]" type="hidden" id="rate" readonly size="8" value="<?php echo $refrate; ?>">
                  <input name="amount1[]" type="hidden" id="amount" readonly size="8" value="<?php echo $refamount; ?>">
                   <input name="amdocno1[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>">
			<input name="refno<?php echo $sno; ?>" id="refno<?php echo $sno; ?>" type="hidden" value="<?php echo $refref; ?>">	 
		
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refamount, 2, '.', ','); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
             
			  
			  <?php }
			  ?><input type="hidden" name="ambcount1" value="<?php echo $ambcount1;?>">
              
              
              
              
              
              
              
              
              
              
              
              
			   <?php 
			   $totaldepartmentref=0;
			  $query231 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'";
			$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res231 = mysqli_fetch_array($exec231))
			{
			$departmentrefdate=$res231['consultationdate'];
			$departmentrefname=$res231['referalname'];
			$departmentrefcode=$res231['referalcode'];
			$departmentrefrate=$res231['referalrate'];
			$departmentrefref=$res231['refno'];
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
			$totaldepartmentref=$totaldepartmentref+$departmentrefrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $departmentrefdate; ?></div></td>
			  <input type="hidden" name="departmentreferalname" value="<?php echo $departmentrefname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $departmentrefref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left">Referral Fee - <?php echo $departmentrefname; ?></div></td>
			  <input name="departmentreferal[]" type="hidden" id="departmentreferal" size="69" value="<?php echo $departmentrefname; ?>">
			  <input name="departmentrefcode[]" type="hidden" id="departmentrefcode" size="69" value="<?php echo $departmentrefcode; ?>">

			 <input name="departmentreferalrate4[]" type="hidden" id="departmentreferalrate4" readonly size="8" value="<?php echo $departmentrefrate; ?>">
			<input name="refno<?php echo $sno; ?>" id="refno<?php echo $sno; ?>" type="hidden" value="<?php echo $departmentrefref; ?>">	 
		
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($departmentrefrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($departmentrefrate, 2, '.', ','); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
             
			  
			  <?php }
			  ?>
			  <?php 
			  $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalampref+$totalhomref+$totalconref+$totalref+$totaldepartmentref+$dispensingfee)-$totalcopay;
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop-$totalcopay;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totaldepartmentref+$dispensingfee;
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
                bgcolor="#ecf0f5"><strong><?php echo $overalltotal; ?></strong></td>
				 <td width="4%"  align="left" valign="center" 
               class="bodytext31" bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>
             
			 </tr>
			  <input type="hidden" id="ref_count" name="ref_count" value="<?php echo $sno; ?>">
          </tbody>
        </table>		</td>
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
                <td colspan="4" rowspan="20" align="left" valign="top"  
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
			  $totalamount = round($totalamount);
			  $totalamount = number_format($totalamount,2,'.','');
			  $roundoffamount = $originalamount - $totalamount;
			  $roundoffamount = number_format($roundoffamount,2,'.','');
			  $roundoffamount = -($roundoffamount);
			  ?>
                <td width="3%" rowspan="3" align="right" valign="top"  
                bgcolor="#F3F3F3" class="style1" id="tdShowTotal"><?php echo number_format($totalamount, 2, '.', ','); ?></td>
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
                   <input name="nettamount" id="nettamount" value="0.00" style="text-align:right" size="8" readonly />
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
				   <td ><select  name="currency1" id="currency"   onChange="return functioncurrencyfx(this.value)">
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
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash Recd11 </strong></div></td>
                <td width="52" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input type="text" name="cashgivenbycustomer" id="cashgivenbycustomer"  tabindex="2" style="text-align:right" size="8" autocomplete="off" /></td>
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
bgcolor="#F3F3F3" class="bodytext31"><input name="creditamount" id="creditamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="getEncAmount(); return balancecalc('2');"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA No. </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="52"><input name="mpesanumber" id="mpesanumber" value="" style="text-align:left; text-transform:uppercase" size="8" <?php if($mpesa_integration == 0){ echo "readonly"; } ?> /></td>
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
            <?php if($mpesa_integration == 1){ ?><span id="iPaymentsIcon" onClick="OpenMpesa()" style="padding: 3px;background-color: #fff;border-radius: 20px;border: 1px solid;cursor: pointer;" title="Lipa na MPESA - iPayments">⚡</span> <?php } ?>
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
bgcolor="#F3F3F3" class="bodytext31"><input name="cardamount" id="cardamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="getBarclayAmount(); return balancecalc('4');"/></td>

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
	            <?php if($barclayscard_integration == 1){ ?><span onClick="OpenBarclays()" style="padding: 3px;background-color: #fff;border-radius: 20px;border: 1px solid;cursor: pointer;" id="iPaymentsIconBarclays" title="Card Payments - iPayments">⚡</span><?php } ?>
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
                
                <td colspan="16" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                  <input name="delbillst" id="delbillst" type="hidden" value="billedit">
                  <input name="delbillautonumber" id="delbillautonumber" type="hidden" value="<?php echo $delbillautonumber;?>">
                  <input name="delbillnumber" id="delbillnumber" type="hidden" value="<?php echo $delbillnumber;?>">
				   <input name="form_flag" id="form_flag" type="hidden" value="paynow">
				 <?php if($totalamount!=0){?> <input name="Submit2223" id="Submit2223" type="submit"value="Save Bill(Alt+S)" accesskey="s" class="button"/><?php }?> 
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
   </tr>
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
			  if($num43)
			  {
				  while($res43 = mysqli_fetch_array($exec43))
				  {
				  
				  $patientname1 = $res43['patientname']; 
				  $patientcode1 = $res43['patientcode'];
				
				  $deposit_totalamt = $res43['amt'];
				  $deposit_bal_amt = $deposit_totalamt;//for first time consulation they are same
				  $all_adjust_amt = 0;
				  $all_refund_amt = 0;
				  // 
				  //$deposit_amt_bal_query = "SELECT balamt FROM `adjust_advdeposits` WHERE `patientcode` = '$patientcode' order by id desc limit 1";
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
			
			  }
			  else
			  { ?>
			  	<input type="hidden" name="adv_dep_total_amt" id="adv_dep_total_amt" value="0" />
			  		<input type="hidden" name="net_deposit_amt" id="net_deposit_amt" value="0" />
					<input type="hidden" name="hid_bal_amt" id="hid_bal_amt" value="0" />
			 <?php  }
			 
				if($num43 == 0)
				{ ?>
					<tr><td class="bodytext31" colspan="6" align="center">There are No Advance Deposits Found</td>
						<input type="hidden" name="has_adv_deposit_amt" id="has_adv_deposit_amt" value="0" >
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
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
