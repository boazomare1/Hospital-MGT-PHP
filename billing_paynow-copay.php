<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
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
$query1111 = "select * from master_employee where username = '$username'";
$exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
while ($res1111 = mysqli_fetch_array($exec1111))
{
$locationnumber = $res1111["location"];
$query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'deleted'";
$exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	
	$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
	$execlab=mysqli_fetch_array($Querylab);
	$patientpaymenttype = $execlab['billtype'];
	$patientname = $_REQUEST["patientname"];
	
	$query43 = "select * from master_consultation where patientvisitcode='$visitcode' order by auto_number desc";
	$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res43 = mysqli_fetch_array($exec43);
	$consultationid = $res43['consultation_id'];
	
	
	if($consultationid == '')
	{
	$query431 = "select * from master_triagebilling where patientvisitcode='$visitcode' order by auto_number desc";
	$exec431 = mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res431 = mysqli_fetch_array($exec431);
	$consultationid = $res431['docnumber'];
	}
	
	/*if($patientpaymenttype == 'PAY LATER')
	{
	$query4311 = "select * from approvalstatus where visitcode='$visitcode' order by auto_number desc";
	$exec4311 = mysql_query($query4311) or die(mysql_error().__LINE__);
	$res4311 = mysql_fetch_array($exec4311);
	$consultationid = $res4311['docno'];
	}*/
	
	
	$accountname= $_REQUEST['accountname'];
	$subtype = $_REQUEST['subtype'];
	$totalamount=$_REQUEST['totalamount'];
	$billdate=$_REQUEST['billdate'];
	$referalname=$_REQUEST['referalname'];
	$paymentmode = $_REQUEST['billtype'];
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
		$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
		$visittype = $_REQUEST['visittype'];
		
		
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
		$exec7691 = mysqli_query($GLOBALS["___mysqli_ston"], $query7691) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$res7691 = mysqli_fetch_array($exec7691);
		
		$debitcoa = $res7691['code'];
			
		$query78 = "select * from master_doctor where auto_number='$doctor'";
		$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$res78 = mysqli_fetch_array($exec78);
		$doctorname = $res78['doctorname'];
		
	$query3 = "select * from master_company where companystatus = 'Active'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res3 = mysqli_fetch_array($exec3);
	$paynowbillprefix = $res3['paynowbillnoprefix'];
	$paynowbillprefix1=strlen($paynowbillprefix);
	$query2 = "select * from billing_paynow order by auto_number desc limit 0, 1";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res2 = mysqli_fetch_array($exec2);
	$billnumber = $res2["billno"];
	$billdigit=strlen($billnumber);
	
	$dispensingkey=isset($_REQUEST['dispensingkey'])?$_REQUEST['dispensingkey']:'';
	
	
	if ($billnumber == '')
	{
		$billnumbercode =$paynowbillprefix.'1'."-".date('y');
			$openingbalance = '0.00';
	
	}
	else
	{
		$billnumber = $res2["billno"];
		$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
		//echo $billnumbercode;
		$billnumbercode = intval($billnumbercode);
		$billnumbercode = $billnumbercode + 1;
	
		$maxanum = $billnumbercode;
		
		
		$billnumbercode = $paynowbillprefix .$maxanum."-".date('y');
		$openingbalance = '0.00';
		//echo $companycode;
	}
	
	$billnumber = $billnumbercode;
		
		$query386="select * from billing_paynow where billno='$billnumber'";
		$exec386=mysqli_query($GLOBALS["___mysqli_ston"], $query386) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num386=mysqli_num_rows($exec386);
	if($num386 == 0)
	{
	
		//inserting ambulance bill details
		//echo $quantity;
		if($ambcount>0)
		{
			
			foreach($_POST['ambulancecount'] as $key)
			{ $key=$key-1;
				$amdocno=$_REQUEST['amdocno'][$key];
				$accountname=$_REQUEST['accountname'][$key];
				$description=$_REQUEST['description'][$key];
				$quantity=$_REQUEST['quantityop'][$key]; 
				$rate=$_REQUEST['rateop'][$key];
				$amount=$_REQUEST['amountop'][$key];
				$ambfxamount=$_REQUEST['copayfxopamb'][$key];
				$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_opambulance(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,fxrate,fxamount)values('".$amdocno."','$patientcode','$patientname','$visitcode','$accountname','".$description."','".$quantity."','".$rate."','".$amount."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','$fxrate','$ambfxamount')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				}
				
				mysqli_query($GLOBALS["___mysqli_ston"], "update op_ambulance set paymentstatus='completed' where patientvisitcode='$visitcode'");
			}
			//insert query  for homecare
			if($ambcount1>0)
		{
			
			foreach($_POST['ambulancecounthom'] as $key)
			{ 
				$amdocno1=$_REQUEST['amdocnohom'][$key];
				$accountname1=$_REQUEST['accountnamehom'][$key];
				$description1=$_REQUEST['descriptionhom'][$key];
				$quantity1=$_REQUEST['quantityhom'][$key];
				$rate1=$_REQUEST['ratehom'][$key];
				$amount1=$_REQUEST['amounthom'][$key];
				$homefxamount=$_REQUEST['copayfxophome'][$key];
				$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_homecare(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,fxrate,fxamount)values('".$amdocno1."','$patientcode','$patientname','$visitcode','$accountname1','".$description1."','".$quantity1."','".$rate1."','".$amount1."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','$fxrate','$homefxamount')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				}
				
				mysqli_query($GLOBALS["___mysqli_ston"], "update homecare set paymentstatus='completed' where patientvisitcode='$visitcode'");
			}
			//ends here
		$query3861="select * from billing_paynow where visitcode='$visitcode' and consultationid='$consultationid' and billno='$billnumber'";
		$exec3861=mysqli_query($GLOBALS["___mysqli_ston"], $query3861) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num3861=mysqli_num_rows($exec3861);//echo 'ok';
	
	if($num3861 == 0)
	{
	
			
		    $query29 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$num29=mysqli_num_rows($exec29);
			
		if($num29 != 0)
		{
		//mysql_query("update master_visitentry set pharmacybill='completed' where visitcode='$visitcode'");
		//mysql_query("update master_consultationpharm set pharmacybill='completed' where patientvisitcode='$visitcode'"); 
		}
			$query23 = "select * from billing_pharmacy where billnumber = '$billnumber'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res23 = mysqli_num_rows($exec233);
	if ($res23 == 0)
	{
	$query24=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_pharmacy(billnumber,patientcode,patientvisitcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$visitcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
	$query30=mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultation set paymentstatus='completed' where patientvisitcode='$visitcode'");
		foreach($_POST['pharmname'] as $key => $value)
		{
		$pharmname=$_POST['pharmname'][$key];
		$pharmname =addslashes($pharmname);
	
	//$query34=mysql_query("update master_consultationpharm set billing='completed' where medicinename='$pharmname' and patientvisitcode='$visitcode'") or die(mysql_error().__LINE__);
	//$query38=mysql_query("update master_consultationpharmissue set paymentstatus='completed' where medicinename='$pharmname' and patientvisitcode='$visitcode'");
	}
		
		  $query30 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num30=mysqli_num_rows($exec30);
		if($num30 != 0)
		{
		mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set labbill='completed' where visitcode='$visitcode'");
		}
		$query23 = "select * from billing_lab where billnumber = '$billnumber'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res23 = mysqli_num_rows($exec233);
	if ($res23 == 0)
	{
	$query24=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_lab(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	}
	
	//echo "update consultation_lab set paymentstatus='completed' , copay = 'completed' where patientvisitcode='$visitcode'";
	//$query27=mysql_query("update consultation_lab set paymentstatus='completed' , copay = 'completed' where patientvisitcode='$visitcode'");
	
		 $query31 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$num31=mysqli_num_rows($exec31);
			if($num31 != 0)
			{
			mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set radiologybill='completed' where visitcode='$visitcode'");
			}
			$query23 = "select * from billing_radiology where billnumber = '$billnumber'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res23 = mysqli_num_rows($exec233);
	if ($res23 == 0)
	{
	
	$query24=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_radiology(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
	}
//$query28=mysql_query("update consultation_radiology set paymentstatus='completed' where patientvisitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $query32 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num32=mysqli_num_rows($exec32);
		if($num32 != 0)
		{
			mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set servicebill='completed' where visitcode='$visitcode'");
		}
		$query23 = "select * from billing_services where billnumber = '$billnumber'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res23 = mysqli_num_rows($exec233);
	if ($res23 == 0)
	{
	//echo "insert into billing_services(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')";
	$query24=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_services(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
	}
	//$query29=mysql_query("update consultation_services set paymentstatus='completed' where patientvisitcode='$visitcode'");
	
	
			  $query33 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num33=mysqli_num_rows($exec33);
		if($num33 != 0)
		{
		mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set referalbill='completed' where visitcode='$visitcode'");
		}
		$query23 = "select * from billing_referal where billnumber = '$billnumber'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res23 = mysqli_num_rows($exec233);
	if ($res23 == 0)
	{
	
	$query24=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_referal(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
	}
	$query30=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_referal set paymentstatus='completed' where patientvisitcode='$visitcode'");
	$query301=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_departmentreferal set paymentstatus='completed' where patientvisitcode='$visitcode'");
	
	$disp_flag = 0;
foreach($_POST['medicinename'] as $key=>$value)
		{	
		    
		    $medicinename = $_POST['medicinename'][$key];
			$medicinename = addslashes($medicinename);
			/* $query77="select * from master_medicine where itemname='$medicinename' and status <> 'deleted'";
			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
			$res77=mysqli_fetch_array($exec77);
			$medicinecode=$res77['itemcode']; */
			//$rate=$res77['rateperunit'];
			$medicinecode=$_POST['medicinecode'][$key];
			$medicine_auto_number=$_POST['medicine_auto_number'][$key];
			$rate=$_POST['rate'][$key];
			$quantity = $_POST['quantity'][$key];
				$amount = $_POST['amount'][$key];
				$pharfxamount = $_REQUEST['copayfxphar'][$key];
			if($pharfxamount==0){
				$pharfxamount=$amount*$fxrate;
			}
			
			if($rate!=0.00 && $quantity!=0 && ($amount==0.00 || $amount=='')){
				continue;
			}	
			
			$query6 = "select ledgername, ledgercode, ledgerautonumber,incomeledger,incomeledgercode from master_medicine where itemcode = '$medicinecode' and status <> 'deleted'"; 
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
	$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $querydisp) or die ("Error in Querydisp".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
			
			if ($medicinename != "" && $medicinename!='Dispensing Fee')
			{
			
			$disp_flag = 1;	
		      
		        $query2 = "insert into billing_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode,ledgercode,ledgername,fxrate,fxamount,incomeledger,incomeledgercode) 
				values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$billdate','$ipaddress','$accountname','unpaid','$medicinecode','$billnumber','$username','$pharmacycoa','$locationname','$locationcode','$ledgercode','$ledgername','$fxrate','$pharfxamount','$incomeledger','$incomeledgercode')";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			
				if($amount != 0)
				{
					$query34=mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharm set billing='completed',pharmacybill='completed' where medicinecode='$medicinecode' and patientvisitcode='$visitcode' and auto_number='$medicine_auto_number'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
					$query341=mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharm set paymentstatus='completed',approvalstatus='1'  where medicinecode='$medicinecode' and patientvisitcode='$visitcode' and billtype='PAY LATER' and auto_number='$medicine_auto_number'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
					$query38=mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharmissue set paymentstatus='completed' where medicinecode='$medicinecode' and patientvisitcode='$visitcode' and auto_number='$medicine_auto_number'");
				}
							
			}
			
			
			$query54 = "update master_consultationpharm set excludebill='completed' where medicinecode='$medicinecode' and patientvisitcode='$visitcode' and excludestatus='excluded'";
			$exec54 = mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			
			$query55 = "update master_consultationpharmissue set excludebill='completed' where medicinecode='$medicinecode' and patientvisitcode='$visitcode' and excludestatus='excluded'";
			$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		
		if($disp_flag > 0)
		{
				$query551 = "insert into billing_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode) 
				values('$patientcode','$patientname','$visitcode','Dispensing Fee','1','$dispensingfee','$dispensingfee','$billdate','$ipaddress','$accountname','unpaid','DISPENS','$billnumber','$username','$pharmacycoa','$locationname','$locationcode')";
				$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die ("Error in Query551".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				
				$query552 = "update dispensingfee set status='completed' where docno='$dispensingdocno'";
				$exec552 = mysqli_query($GLOBALS["___mysqli_ston"], $query552) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			
		}
		
		foreach($_POST['lab'] as $key=>$value)
		{
				    //echo '<br>'.$k;
		$labname=$_POST['lab'][$key];
		$labcode=$_POST['labcode'][$key];
		//$labquery=mysql_query("select * from master_lab where itemname='$labname'");
		//$execlab=mysql_fetch_array($labquery);
		//$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate5'][$key];
		$copaylab=$_POST['copaylab'][$key];
		$copayfxlab=$_POST['copayfxlab'][$key];
		
		if($labname!="")
		{
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paynowlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,username,labcoa,locationname,locationcode,copayamount,fxrate,fxamount)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$billdate','unpaid','$billnumber','$username','$labcoa','$locationname','$locationcode','".$copaylab."','$fxrate','$copayfxlab')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			
			$query27=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set paymentstatus='completed' , copay = 'completed' where patientvisitcode='$visitcode' and labitemcode='$labcode'");
			}
		}
		
		foreach($_POST['radiology'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['radiology'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
         
		$radiologycode= $_POST['radiologyitemcode'][$key];
		
		//$radiologyquery=mysql_query("select * from master_radiology where itemname='$pairvar'");
		//$execradiology=mysql_fetch_array($radiologyquery);
		//$radiologycode=$execradiology['itemcode'];
		$copayrad=$_POST['copayrad'][$key];
		$copayfxrad=$_POST['copayfxrad'][$key];
		
		if($pairvar!="")
		{
		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paynowradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,paymentstatus,billnumber,username,radiologycoa,locationname,locationcode,copayamount,fxrate,fxamount)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$billdate','unpaid','$billnumber','$username','$radiologycoa','$locationname','$locationcode','".$copayrad."','$fxrate','$copayfxrad')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query28=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set paymentstatus='completed' where patientvisitcode='$visitcode' and radiologyitemcode='$radiologycode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;
		$servicesname=$_POST["services"][$key];
		$servicescode=$_POST["servicesitemcode"][$key];
		
		//$servicequery=mysql_query("select * from master_services where itemname='$servicesname'");
		//$execservice=mysql_fetch_array($servicequery);
		//$servicescode=$execservice['itemcode'];
		
		$servicesrate=$_POST["rate3"][$key];
		$quantityser=$_POST['quantityser'][$key];
		$seramount=$_POST['seramount'][$key];
		$copayser=$_POST['copayser'][$key];
		$copayfxser=$_POST['copayfxser'][$key];
				$wellnesspkg=$_POST["wellnesspkg"][$key];
		/*for($se=1;$se<=$quantityser;$se++)
		{	*/
		if($servicesname!="")
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paynowservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,username,servicecoa,locationname,locationcode,serviceqty,amount,copayamount,fxrate,fxamount,wellnesspkg)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$billdate','unpaid','$billnumber','$username','$servicecoa','$locationname','$locationcode','".$quantityser."','".$seramount."','".$copayser."','$fxrate','$copayfxser','$wellnesspkg')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$query21 = "select a.* from consultation_services as a join healthcarepackagelinking as b on (a.servicesitemcode = b.itemcode and b.servicecode = '$servicescode') where patientvisitcode='$visitcode' and patientcode='$patientcode'  and approvalstatus !='0' and wellnessitem = '1' group by servicesitemcode";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res21 = mysqli_fetch_array($exec21))
			{
	
		
		
		
		$servicesname=$res21["servicesitemname"];
		
		$servicescode=$res21['servicesitemcode'];
		
		$servicesrate=$res21["servicesitemrate"];
		
		$serfxrateqty=$res21["servicesitemrate"]*$fxrate;
		
	
		$copayser=($servicesrate/100)*$copayhidden;
		$copayfxser=(($servicesrate/100)*$copayhidden)*$fxrate;
		
		/*for($se=1;$se<=$quantityser;$se++)
		{	*/
		if($servicesname!="")
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paynowservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,username,servicecoa,locationname,locationcode,serviceqty,amount,copayamount,fxrate,fxamount,wellnessitem)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$billdate','unpaid','$billnumber','$username','$servicecoa','$locationname','$locationcode','".$quantityser."','".$seramount."','".$copayser."','$fxrate','$copayfxser','1')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query29=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set paymentstatus='completed' where patientvisitcode='$visitcode' and servicesitemcode='$servicescode'");
		}
		}
		$query29=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set paymentstatus='completed' where patientvisitcode='$visitcode' and servicesitemcode='$servicescode'");
		}
		/*}*/
		}
						$copayhidden=$_POST["copayhidden"];
		
		 	
		
		foreach($_POST['departmentreferal'] as $key=>$value)
		{
		$pairs21= $_POST['departmentreferal'][$key];
		$pairvar21= $pairs21;
	    $pairs31= $_POST['copaydepartmentref'][$key];
		$pairvar31= $pairs31;
	    $pairs311= $_POST['copaydepartmentref'][$key];
		$pairvar311= $pairs311;
		$copayfxdepartmentref= $_POST['copayfxdepartmentref'][$key];
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_department where department ='$pairvar21'");
		$execreferal1=mysqli_fetch_array($referalquery1);
		$referalcode1=$execreferal1['auto_number'];
		
		
		
		//echo $pairs2;
		if($pairvar21!="")
		{
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,copayamount,fxrate,fxamount)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','$pairvar311','$fxrate','$copayfxdepartmentref')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		}
		}
		
		foreach($_POST['referal'] as $key=>$value)
		{
		$pairs2= $_POST['referal'][$key];
		$pairvar2= $pairs2;
	    $pairs3= $_POST['refrate4'][$key];
		$pairvar3= $pairs3;
		
		$referalquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_doctor where doctorname='$pairvar2'");
		$execreferal=mysqli_fetch_array($referalquery);
		$referalcode=$execreferal['doctorcode'];
		
		if($visittype=='private')
				$sharingperc = $execreferal['op_consultation_private_sharing'];
			else
				$sharingperc = $execreferal['consultation_percentage'];
		$copayref=$_POST['copayref'][$key];
		$sharingamt = $copayref * ($sharingperc/100);
		//echo $pairs2;
		if($pairvar2!="")
		{
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,copayamount,fxrate,fxamount,consultation_percentage,sharingamount,doctorcode,doctorname)values('$patientcode','$patientname','$visitcode','$referalcode','$pairvar2','$pairvar3','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','".$copayref."','$fxrate','$pairvar3','$sharingperc','$sharingamt','$referalcode','$pairvar2')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		}
		}
	if($referalcode == '')
		{
		$debitcoa = '';
		}
		$totalfxamount = ($totalamount/$fxrate);
	mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paynow(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,referalname,doctorstatus,billstatus,username,subtype,consultationid,creditcoa,debitcoa,locationname,locationcode,fxrate,fxamount)values('$billnumber','$patientname','$patientcode','$visitcode','$totalamount','$billdate','$accountname','$referalname','unpaid','paid','$username','$subtype','$consultationid','$referalcode','$debitcoa','$locationname','$locationcode','$fxrate','$totalfxamount')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	if($patientpaymenttype == 'PAY NOW')
	{
		mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set overallpayment='completed' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	mysqli_query($GLOBALS["___mysqli_ston"], "update master_triage set overallpayment='completed' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	
	    //$billnumber= $_REQUEST['billno'];
		
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		 $res55 = mysqli_fetch_array($exec55);
		 $cashcode = $res55['ledgercode']; 
		
		$query9 = "insert into master_transactionpaynow (transactiondate, transactiontime, particulars, patientcode,patientname,  visitcode, paymenttype, subtype,  
	    accountname, transactionmode, transactiontype, transactionmodule, transactionamount, cashamount, balanceamount, billnumber, billanum, remarks, ipaddress, updatedate, companyanum,
		companyname, financialyear, doctorname, billstatus, username, cashgiventocustomer, cashgivenbycustomer,locationname,locationcode,cashcode)
		values ('$billdate', '$timeonly', '$particulars', '$patientcode', '$patientname', '$visitcode', '$paymenttype', '$subtype', '$accountname', '$transactionmode', '$transactiontype',
	    '$transactionmodule', '$totalamount', '$totalamount', '$balanceamount', '$billnumber', '$billanum', '$remarks', '$ipaddress', '$updatedate', '$companyanum', '$companyname' ,  
        '$financialyear', '$doctorname', 'paid', '$username', '$cashgiventocustomer','$cashgivenbycustomer','$locationname','$locationcode','$cashcode')";
		
		
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$cashcoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	
		
		$query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$onlinecoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
	}
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;	
		
		$query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$chequecoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
	}
	
	if($paymentmode == 'CREDIT CARD')
	{
	$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT CARD';
		$particulars = 'BY CREDIT CARD '.$billnumberprefix.$billnumber;	
		
		$query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode']; 
		 	
			$query9 = "insert into master_transactionpaynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		cardamount, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,creditcardname,creditcardnumber,creditcardbankname,paymenttype,subtype,transactiontime,cashgiventocustomer,cashgivenbycustomer,locationname,locationcode,bankcode) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$totalamount','$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$card','$cardnumber','$bankname1','$paymenttype','$subtype','$timeonly','$cashgiventocustomer','$cashgivenbycustomer','$locationname','$locationcode','$bankcode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$cardcoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
	}
	
		if ($paymentmode == 'SPLIT')
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
		$query55 = "select * from financialaccount where transactionmode = 'SPLIT'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		 $res55 = mysqli_fetch_array($exec55);
		 $cashcode = $res55['ledgercode'];
	
		$query9 = "insert into master_transactionpaynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		cardamount, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,creditcardname,creditcardnumber,creditcardbankname,paymenttype,subtype,transactiontime,cashgiventocustomer,cashgivenbycustomer,cashamount,onlineamount,chequeamount,chequenumber,creditamount,onlinenumber,mpesanumber,locationname,locationcode,cashcode,adjustamount) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$cardamount','$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$card','$cardnumber','$bankname1','$paymenttype','$subtype','$timeonly','$cashgiventocustomer','$cashgivenbycustomer','$cashamount','$onlineamount','$chequeamount','$chequenumber','$creditamount','$onlinenumber','$mpesanumber','$locationname','$locationcode','$cashcode','$adjustamount')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,cash,cashcoa,cheque,chequecoa,online,onlinecoa,mpesa,mpesacoa,source,locationname,locationcode,adjust)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$cardamount','$cardcoa','$cashamount','$cashcoa','$chequeamount','$chequecoa','$onlineamount','$onlinecoa','$creditamount','$mpesacoa','billingpaynow','$locationname','$locationcode','$adjustamount')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		// Check if the patient has advance deposit amount
		 $query_dep = "select patientname,patientcode,sum(transactionamount) amt from master_transactionadvancedeposit where patientcode='$patientcode' group by patientcode";
		 $exec_dep = mysqli_query($GLOBALS["___mysqli_ston"], $query_dep) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		 $num_dep_rows = mysqli_num_rows($exec_dep);	
		 if($num_dep_rows)
		 {
		 	
			if($adjustamount > 0)
			{
				echo 'before insert';
				$query_adjust = "INSERT INTO `adjust_advdeposits` (`id`, `locationcode`, `patientcode`, `visitcode`, `billno`, `adjustamount`, `balamt`, `billdate`, `username`, `ipaddress`, `createdon`) VALUES (NULL, '$locationcode', '$patientcode', '$visitcode', '$billnumbercode', '$adjustamount', '$adv_dep_bal_amt', '$consultationdate', '$username', '$ipaddress', CURRENT_TIMESTAMP)";
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
		 $exec552 = mysqli_query($GLOBALS["___mysqli_ston"], $query552) or die ("Error in Query552".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$mpesacoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
		}
		
		header("location:patientbillingstatus_bills.php?paynowpatientcode1=$patientcode&&paynowbillnumber=$billnumber");
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
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77["allowed"];
/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error().__LINE__);
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
$patientplan=$execlab['planname'];
$currency=$execsubtype['currency'];
//$fxrate=$execsubtype['fxrate'];
$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");
$execplan=mysqli_fetch_array($queryplan);
$patientplan1=$execplan['planname'];
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
$patientaccount=$execlab1['accountname'];
//location get here
 $locationcode=$execlab1['locationcode'];
//get locationname from location code
$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select locationname from master_location where locationcode='".$locationcode."'");
$execlab2=mysqli_fetch_array($querylab2);
 $locationname=$execlab2['locationname'];
$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];
$query76 = "select * from master_financialintegration where field='labpaynow'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res76 = mysqli_fetch_array($exec76);
$labcoa = $res76['code'];
$query761 = "select * from master_financialintegration where field='radiologypaynow'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res761 = mysqli_fetch_array($exec761);
$radiologycoa = $res761['code'];
$query762 = "select * from master_financialintegration where field='servicepaynow'";
$exec762 = mysqli_query($GLOBALS["___mysqli_ston"], $query762) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res762 = mysqli_fetch_array($exec762);
$servicecoa = $res762['code'];
$query763 = "select * from master_financialintegration where field='referalpaynow'";
$exec763 = mysqli_query($GLOBALS["___mysqli_ston"], $query763) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res763 = mysqli_fetch_array($exec763);
$referalcoa = $res763['code'];
$query764 = "select * from master_financialintegration where field='pharmacypaynow'";
$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res764 = mysqli_fetch_array($exec764);
$pharmacycoa = $res764['code'];
$query765 = "select * from master_financialintegration where field='cashpaynow'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res765= mysqli_fetch_array($exec765);
$cashcoa = $res765['code'];
$query766 = "select * from master_financialintegration where field='chequepaynow'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res766 = mysqli_fetch_array($exec766);
$chequecoa = $res766['code'];
$query767 = "select * from master_financialintegration where field='mpesapaynow'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res767 = mysqli_fetch_array($exec767);
$mpesacoa = $res767['code'];
$query768 = "select * from master_financialintegration where field='cardpaynow'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res768 = mysqli_fetch_array($exec768);
$cardcoa = $res768['code'];
$query769 = "select * from master_financialintegration where field='onlinepaynow'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res769 = mysqli_fetch_array($exec769);
$onlinecoa = $res769['code'];
$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select locationcode,paymenttype,subtype,planname,visittype from master_visitentry where visitcode='$visitcode'");
$execlab2=mysqli_fetch_array($querylab2);
 $locationcode=$execlab2['locationcode'];
 $subtype=$execlab2['subtype'];
 $plannumber = $execlab2['planname'];
 $visittype = $execlab2['visittype'];
// echo $planpercentage =  $execlab2['planpercenteage'];
			
			$queryplanname = "select forall, planpercentage from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			$copay1 = $resplanname['planpercentage'];
/*$query40=mysql_query("select * from master_accountname where auto_number='$accname'");
			$res40=mysql_fetch_array($query40);
			$accountname=$res40['accountname'];
			$patientvisitcode=$exec31['visitcode'];
			$patientname=$exec31['patientfullname'];
			$consultationdate=$exec31['consultationdate'];
			
			 $paymenttypeanum = $exec31['paymenttype'];
			  
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysql_query($query3) or die ("Error in Query5".mysql_error().__LINE__);
			  $res3 = mysql_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];*/
			  
			  
 
$query768 = "select locationname from master_location where locationcode='$locationcode'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res768 = mysqli_fetch_array($exec768);
 $locationname = $res768['locationname'];
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = $res3['paynowbillnoprefix'];
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from billing_paynow order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1'."-".date('y');
		$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum."-".date('y');
	$openingbalance = '0.00';
	//echo $companycode;
}
$query3 = "select count(auto_number) as counts from billing_pharmacy where patientcode = '".$patientcode."' AND patientvisitcode='".$visitcode."'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
	$exec1print = mysqli_query($GLOBALS["___mysqli_ston"], $query1print) or die ("Error in Query1print.".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
<script>
function functioncurrencyfx(val)
{	
	var myarr = val.split(",");
	var currate=myarr[0];
	var currency=myarr[1];
	
	var ledgername=myarr[2];
	var ledgercode=myarr[3];
	if(currate=='')
	{
		currate='1';
	}
	//alert(currate);
	//alert(currency);
	document.getElementById("fxamount").value=  currate;
	
	document.getElementById("ledgername").value=  ledgername;
	document.getElementById("ledgercode").value=  ledgercode;
	
	document.getElementById("amounttot").value='';
	document.getElementById("currencyamt").value='';
	var originalamt = document.getElementById("originalamt").value;
	//var originalamtvar = parseFloat(originalamt)*parseFloat(currate);
	var originalamtvar = parseFloat(originalamt);
	document.getElementById("subtotal").value=originalamtvar.toFixed(2);
	//var roundoff = originalamtvar.toFixed(2)-originalamtvar.toFixed(0);
	document.getElementById("roundoff").value='0.00';
	document.getElementById("totalamount").value=originalamtvar.toFixed(2);
	document.getElementById("nettamount").value=originalamtvar.toFixed(2);
	document.getElementById("tdShowTotal").innerHTML=originalamtvar.toFixed(2);
	document.getElementById("cashamount").value=originalamtvar.toFixed(2);
}
function functionchangemode()
{
	var originalamt = document.getElementById("originalamt").value;
	var originalamtvar = parseFloat(originalamt);
	document.getElementById("subtotal").value=originalamtvar.toFixed(2);
	//var roundoff = originalamtvar.toFixed(2)-originalamtvar.toFixed(0);
	document.getElementById("roundoff").value='0.00';
	document.getElementById("totalamount").value=originalamtvar.toFixed(2);
	document.getElementById("nettamount").value=originalamtvar.toFixed(2);
	document.getElementById("tdShowTotal").innerHTML=originalamtvar.toFixed(2);
	
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
			
			var allcash=parseFloat(cashpay)+parseFloat(mpaypay)+parseFloat(cheqpay)+parseFloat(cardpay)+parseFloat(onlipay);
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
			
			var allcash=parseFloat(cashpay)+parseFloat(mpaypay)+parseFloat(cheqpay)+parseFloat(cardpay)+parseFloat(onlipay);
			var balanceinfo=parseFloat(totalamount)-parseFloat(allcash);
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
<script type="text/javascript" src="js/insertitemcurrencyfx.js"></script>
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
		document.getElementById("cashamount").value = (parseFloat(balance) - (parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount) + parseFloat(adjustamount))).toFixed(2);
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
}
</script>
<script src="js/jquery-1.11.1.min.js"></script>
<script>
$( document ).ready(function() {
var values = $('#currency').val().split(",");
document.getElementById('fxamount').value=values[0];    
 document.getElementById('ledgername').value=values[2];
document.getElementById('ledgercode').value=values[3];  
  
});
</script>
<?php include ("js/sales1scripting_new_adjcopay.php"); ?>
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
<script>
function printPaynowBill()
 {
var popWin; 
popWin = window.open("print_billpaynowbill_dmp4inch_copay.php?patientcode=<?php echo $patientcode; ?>&&billautonumber=<?php echo $billnumbercode; ?>&&ranum=<?php echo (rand(10,100)); ?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
 }
</script>
<script>
function funcSaveBill13()
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
<form name="form1" id="form1" method="post" action="billing_paynow-copay.php" onKeyDown="return disableEnterKey(event)">
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
				<input type="hidden" name="patientname" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>                  </td>
                 
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
				                <input type="hidden" name="copayhidden" value="<?php echo $copay1; ?>">
								<input type="hidden" name="visittype" value="<?php echo $visittype; ?>">
				<?php echo $billnumbercode; ?>
				
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
				    <td align="left" valign="top" class="bodytext3"><strong>Bill Date</strong></td>
				    <td align="left" valign="top" class="bodytext3"><?php echo $dateonly; ?></td>
				    <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				<?php echo $patientaccount1; ?></td>
              	<input type="hidden" name="account" id="account" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
			  </tr>
				 	<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>								<input type="hidden" name="accountname" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
				 
                  <input type="hidden" name="account" id="account" value="<?php echo $patientplan1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>			
				  <input type="hidden" name="account" id="account" value="" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
				  <input type="hidden" name="fxrate" id="fxrate" value="<?php echo $currconvertrate; ?>">
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
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32"><strong>Transaction Details</strong></td>
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
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Fx Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Fx Amount </strong></div></td>
				<td width="1%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
                  </tr>
                  
                   <?php 
				   $totalfxrate = '0.00';
				   $totalfxamount = '0.00';
			$query18 = "select * from master_billing where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res18 = mysqli_fetch_array($exec18);
			$billingdatetime=$res18['billingdatetime'];
			$billno=$res18['billnumber'];
			//$copay1=$res18['copaypercentageamount'];
			//echo $labrate;
			 $copay=($labrate/100)*$copay1;
			/*if($copay != 0.00)
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
			$totalcopay=$copay;*/
			 ?>
		<!--	<?php /*?> <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
			  <?php 
			  } 
			  ?><?php */?>
			 <?php /*?> <?php 
			  $totallab=0;
			  $query19 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and (paymentstatus='completed' AND copay <> 'completed') ";
			$exec19 = mysql_query($query19) or die ("Error in Query1".mysql_error().__LINE__);
			while($res19 = mysql_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labrate=$res19['labitemrate'];
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
              <?php  $copay=($labrate/100)*$copay1; $totalcopay=$totalcopay+$copay;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			  <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $labrate; ?>">
              <input name="copay[]" id="copay" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $labrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $labrate; ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
            
             <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
			  
			  <?php }
			 
			  ?><?php */?>-->
              
              
              <?php 
			  $totallab=0;
	  $query19 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode'and paymentstatus='pending' and approvalstatus='1'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res19 = mysqli_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labrate=$res19['labitemrate'];
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
			
			$totlabratecopay=$labrate;
			if($planforall=='yes'){
			//	$refratecopay=($radrate/100)*$copay1;
				$totlabratecopay= ($labrate/100)*$copay1;
				}
			?>
			 <tr <?php echo $colorcode; ?>>
             
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			  <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $totlabratecopay; ?>">
             
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate*$currconvertrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate*$currconvertrate, 2, '.', ','); ?></div></td>
			 <?php
			 if($res19['approvalstatus']==2){
			 ?>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
			 </tr>
			  <?php 
			  $totalfxrate += $labrate*$currconvertrate;
			  $totalfxamount += $labrate*$currconvertrate;
			  }
			   else
			   {
			 ?>
			 <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
              </tr>
            <?php
			} 
			if($planforall=='yes'  && $res19['approvalstatus']!=2){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=($labrate/100)*$copay1; $totalcopay=$totalcopay+$copay;
			  $totalfxrate += $copay*$currconvertrate;
			  $totalfxamount += $copay*$currconvertrate;
			  ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay, 2, '.', ','); ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay*$currconvertrate, 2, '.', ','); ?></div></td>
			   <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
            
             
			  </tr>
			  <input name="copaylab[]" id="copaylab" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <input name="copayfxlab[]" id="copayfxlab" readonly size="8" type="hidden" value="<?php echo number_format($copay*$currconvertrate, 2, '.', ''); ?>">
			  <?php } else {?>
			   <input name="copaylab[]" id="copaylab" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			   <input name="copayfxlab[]" id="copayfxlab" readonly size="8" type="hidden" value="0.00">
			  <?php
			  }
			  }
			 
			  ?>
              
             <?php /*?> <?php 
			$query18 = "select * from master_billing where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error().__LINE__);
			$res18 = mysql_fetch_array($exec18);
			$billingdatetime=$res18['billingdatetime'];
			$billno=$res18['billnumber'];
			$copay1=$res18['copaypercentageamount'];
			//echo $labrate;
			 $copay=($labrate/100)*$copay1;
			if($copay != 0.00)
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
			$totalcopay=$copay;
			 ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
			  <?php 
			  } 
			  ?><?php */?>
              
			   <?php
		
			   $totalpharm=0;
			   $pharmno=0;
			$phaamount=0;
			$query23 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and (approvalstatus='2' or approvalstatus='' ) and pharmacybill='pending' and medicineissue='pending' and billing=''";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$pharmtotalno=mysqli_num_rows($exec23);
			while($res23 = mysqli_fetch_array($exec23))
			{
				
			$phaamount=0;
			$phadate=$res23['recorddate'];
			$auto_number=$res23['auto_number'];
			$phaname=$res23['medicinename'];
			$phacode=$res23['medicinecode'];
			$phaquantity=$res23['quantity'];
			$pharate=$res23['rate']/$fxrate;
			$amendstatus=$res23['amendstatus'];
			if($amendstatus=='2')
			{
			$phaamount=$phaquantity * $pharate;
			}
			//$phaamount=$phaquantity * $pharate;
			
			$pharefno=$res23['refno'];
			$billtype=$res23['billtype'];
			$excludestatus=$res23['excludestatus'];
			$excludebill = $res23['excludebill'];
			$approvalstatus = $res23['approvalstatus'];
			/*if($billtype == 'PAY LATER')
			{
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
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			  <input type="hidden" name="pharmname[]" value="<?php echo $phaname; ?>">
			  <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $phaquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $phaamount; ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phaquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $pharate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount,2); ?></div></td>
             
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>copay</strong></div></td>
             
			  
			  <?php 
			 }
			  }*/
			  
			  if(($billtype == 'PAY LATER') && ($copay1>0.00))
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
			$phamratecopay=$pharate;
			$totphamratecopay=$phaamount;
//			if($planforall=='yes'){ 
			if($planforall=='yes' && $approvalstatus!=2){
				$phamratecopay=(($pharate/100)*$copay1);
			 	$totphamratecopay= ($phaamount/100)*$copay1;
				}
			else{
			$totalpharm=$totalpharm+$phaamount;
			$pharmno=$pharmno+1;
			$totalcopay+=$phaamount;
			$totalfxrate += $pharate*$currconvertrate;
			  $totalfxamount += $phaamount*$currconvertrate;
			}
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			  <input type="hidden" name="pharmname[]" value="<?php echo $phaname; ?>">
			  <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			  <input name="medicine_auto_number[]" type="hidden" id="medicine_auto_number" size="25" value="<?php echo $auto_number; ?>">
			  <input name="medicinecode[]" type="hidden" id="medicinecode" size="25" value="<?php echo $phacode; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $phaquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo number_format($phamratecopay, 2, '.', ''); ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo number_format($totphamratecopay, 2, '.', ''); ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phaquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharate*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount*$currconvertrate, 2, '.', ','); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31">
                              <div align="right"><strong><?php if($amendstatus=='2'){?><img src="img/selected.png" width="15" height="15"><?php }?>&nbsp;</strong></div></td>
             </tr>
             <?php 
			 	if($planforall=='yes' && $approvalstatus!=2){
						?>
             <tr <?php echo $colorcode; ?>>
              <?php  
			  $copay=($phaamount/100)*$copay1; 
			  $totalcopay=$totalcopay+$copay;
			  $indcopay=$copay/$phaquantity;
			  $totalfxrate += $indcopay*$currconvertrate;
			  $totalfxamount += $copay*$currconvertrate;
			  ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phaquantity; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($indcopay, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay, 2, '.', ','); ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($indcopay*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><?php if($amendstatus=='2'){?><img src="img/selected.png" width="15" height="15"><?php }?>&nbsp;</strong></div></td>
              
             
			  </tr>
			  <input name="copayphar[]" id="copayphar" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <input name="copayfxphar[]" id="copayfxphar" readonly size="8" type="hidden" value="<?php echo number_format($copay*$currconvertrate, 2, '.', ''); ?>">
			  <?php } else{?>
			   <input name="copayphar[]" id="copayphar" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			   <input name="copayfxphar[]" id="copayfxphar" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
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
			
			$totalfxrate += $pharate*$currconvertrate;
			  $totalfxamount += $phaamount*$currconvertrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			  <input type="hidden" name="pharmname[]" value="<?php echo $phaname; ?>">
			  <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			  <input name="medicinecode[]" type="hidden" id="medicinecode" size="25" value="<?php echo $phacode; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $phaquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $phaamount; ?>">
		    <input name="copayfxphar[]" id="copayfxphar" readonly size="8" type="hidden" value="<?php echo number_format($phaamount*$currconvertrate, 2, '.', ''); ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phaquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharate*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount*$currconvertrate, 2, '.', ','); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><?php if($amendstatus=='2'){?><img src="img/selected.png" width="15" height="15"><?php }?>&nbsp;</strong></div></td>
             
			  
			  <?php 
			  }
			  }
			   if(($dispensingcount==0)&&($pharmtotalno>0))
			{
			$query3 = "select dispensing from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res3 = mysqli_fetch_array($exec3);
$dispensingamount = $res3['dispensing'];
if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			$dispensingfee1=$dispensingfee1+$dispensingamount; 
			
			$desratecopay=$dispensingfee1;
			if($planforall=='yes'){
				$desratecopay=($dispensingfee1/100)*$copay1;
			//	$totdesratecopay= ($dispensingfee1/100)*$copay1;
				}
			  ?>
              
               <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo "Dispensing Fee"; ?></div></td>
              <input type="hidden" name="pharmname[]" value="<?php echo "Dispensing Fee"; ?>">
			  <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo  "Dispensing Fee";  ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo "1"; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $desratecopay; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $desratecopay; ?>">
             <input name="dispensingkey" id="dispensingkey" readonly size="8" type="hidden" value="1">
             <input name="desipaddress" id="desipaddress" readonly  type="hidden" value="<?php echo $_SERVER['REMOTE_ADDR'];?>">
             <input name="desusername" id="desusername" readonly  type="hidden" value="<?php echo $username;?>">
             
			 <?php /*?> <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo "Dispensingamount"; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $dispensingamount; ?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo 'DISPENS'; ?>">
              <input name="dispensingkey" id="dispensingkey" readonly size="8" type="hidden" value="1"><?php */?>
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($dispensingamount, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($dispensingamount, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($dispensingamount, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($dispensingamount, 2, '.', ','); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
              
              
              </tr>
               <?php if($planforall=='yes'){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=($dispensingfee1/100)*$copay1; $totalcopay=$totalcopay+$copay; $indcopay=$copay;
			  $totalfxrate += $indcopay*$currconvertrate;
			  $totalfxamount += $copay*$currconvertrate;
			  ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo "1"; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($indcopay, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay, 2, '.', ','); ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($indcopay, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay, 2, '.', ','); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
			 <?php /*?> <input name="copayphar[]" id="copayphar" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <?php } else{?>
			   <input name="copayphar[]" id="copayphar" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>"><?php */?>
			  <?php
			  }
			   }
			if($pharmno > 0)
			{
			 $query201 = "select * from dispensingfee where visitcode='$visitcode' and patientcode='$patientcode' and status = '' order by auto_number desc limit 0,1";
			$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res201 = mysqli_fetch_array($exec201);
			
			$recorddate=$res201['recorddate'];
			$dispensingfee=$res201['dispensingfee'];
			$docno=$res201['docno'];
			
			if($dispensingfee != '')
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
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $recorddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo "Dispensing Fee"; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($dispensingfee, 2, '.', ','); ?></div></td>
			 <input type="hidden" name="dispensingfee" id="dispensingfee" value="<?php echo $dispensingfee; ?>">
			 <input type="hidden" name="dispensingdocno" id="dispensingdocno" value="<?php echo $docno; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($dispensingfee, 2, '.', ','); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
			  
			  <?php }
			  
			  }
			  ?>
			  
			    <?php 
				$totalrad=0;
			$query20 = "select * from consultation_radiology where patientvisitcode='$visitcode'  and patientcode='$patientcode' and paymentstatus='pending' and approvalstatus='1'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radiologyitemcode=$res20['radiologyitemcode'];
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
			$totrefratecopay=$radrate;
			if($planforall=='yes' && $res20['approvalstatus']!=2){
			//	$refratecopay=($radrate/100)*$copay1;
				$totrefratecopay= ($radrate/100)*$copay1;
				}
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>
			  <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			  <input name="radiologyitemcode[]" id="radiologyitemcode" type="hidden" size="69" autocomplete="off" value="<?php echo $radiologyitemcode; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $totrefratecopay; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate*$currconvertrate, 2, '.', ','); ?></div></td>
			 <?php
			 if($res20['approvalstatus']==2){
			 ?>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
			 </tr>
			  <?php 
			  $totalfxrate += $radrate*$currconvertrate;
			  $totalfxamount += $radrate*$currconvertrate;
			  }
			   else
			   {
			 ?>
			 <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
              </tr>
            <?php
			} 
			 if($planforall=='yes' && $res20['approvalstatus']!=2){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=($radrate/100)*$copay1; $totalcopay=$totalcopay+$copay;
			  $totalfxrate += $copay*$currconvertrate;
			  $totalfxamount += $copay*$currconvertrate;
			  ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
              
             
			  </tr>
			  <input name="copayrad[]" id="copayrad" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <input name="copayfxrad[]" id="copayfxrad" readonly size="8" type="hidden" value="<?php echo number_format($copay*$currconvertrate, 2, '.', ''); ?>">
			  <?php } else{?>
			   <input name="copayrad[]" id="copayrad" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			   <input name="copayfxrad[]" id="copayfxrad" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			  <?php
			  }
			  }
			  ?>
			  	    <?php 
					
					$totalser=0;
			  $query21 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and  paymentstatus='pending' and approvalstatus='1' and wellnessitem <> '1' group by servicesitemcode";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$sercode=$res21['servicesitemcode'];
			 $serrate=$res21['servicesitemrate'];
			$serref=$res21['refno'];
			
			 $quantity=$res21['serviceqty'];
			 $totserrate=$res21['amount'];
									$wellnesspkg=$res21['wellnesspkg'];
			$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and paymentstatus='pending'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$numrow2111 = mysqli_num_rows($exec2111);
			
			//$rateperservice=$totserrate/$numrow2111;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$serratecopay=$serrate;
			
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
			$totserratecopay=$totserrate;
			
			if($planforall=='yes'){
				$serratecopay=(($totserrate/100)*$copay1)/$quantity;
				$totserratecopay= ($totserrate/100)*$copay1;
				}
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			  <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			  			 <input name="servicesitemcode[]" type="hidden" id="servicesitemcode" size="69" value="<?php echo $sercode; ?>">
			              <input name="wellnesspkg[]" type="hidden" id="wellnesspkg" readonly size="8" value="<?php echo $wellnesspkg; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $serratecopay; ?>">
		 	 <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $quantity; ?>">
             <input name="seramount[]" type="hidden" id="seramount" readonly size="8" value="<?php echo $totserratecopay; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totserrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totserrate*$currconvertrate, 2, '.', ','); ?></div></td>
			  <?php
			 if($res21['approvalstatus']==2){
			 ?>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
			   </tr>
			  <?php 
			  $totalfxrate += $radrate*$currconvertrate;
			  $totalfxamount += $radrate*$currconvertrate;
			  }
			   else
			   {
			 ?>
			 <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
              </tr>
            <?php
			} 
			if($planforall=='yes' && $res21['approvalstatus']!=2){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=($totserrate/100)*$copay1; $totalcopay=$totalcopay+$copay; $copayperser=$copay/$quantity;
			  $totalfxrate += $copayperser*$currconvertrate;
			  $totalfxamount += $copay*$currconvertrate;
			  ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayperser, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayperser*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
              
             
			  </tr>
			  <input name="copayser[]" id="copayser" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <input name="copayfxser[]" id="copayfxser" readonly size="8" type="hidden" value="<?php echo number_format($copay*$currconvertrate, 2, '.', ''); ?>">
			  <?php }
			  else{?>
			  <input name="copayser[]" id="copayser" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			  <input name="copayfxser[]" id="copayfxser" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			  <?php }
			  }
			  ?>
			   <?php 
			   $totalref=0;
			  $query22 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
			
			$totrefrratecopay=$refrate;
			
			if($planforall=='yes'){
				//$serratecopay=(($totserrate/100)*$copay1)/$quantity;
				$totrefrratecopay= ($refrate/100)*$copay1;
				}
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			  <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="refrate4[]" type="hidden" id="refrate4" readonly size="8" value="<?php echo $totrefrratecopay; ?>">
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate, 2, '.', ','); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
             <?php if($planforall=='yes'){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=($refrate/100)*$copay1; $totalcopay=$totalcopay+$copay;
			  $totalfxrate += $copay*$currconvertrate;
			  $totalfxamount += $copay*$currconvertrate;
			  ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay, 2, '.', ','); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
              
             
			  </tr>
			  <input name="copayref[]" id="copayref" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <input name="copayfxref[]" id="copayfxref" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <?php } else{?>
			   <input name="copayref[]" id="copayref" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			   <input name="copayfxref[]" id="copayfxref" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			  <?php
			  }
			  
			   }
			  ?>
              
              
              
              
              
              
              
              
              <?php 
			   $totalopa=0;
			  $query22 = "select * from op_ambulance where patientvisitcode='$visitcode' and billtype='PAY LATER' and patientcode='$patientcode' and paymentstatus='completed'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$ambcount=mysqli_num_rows($exec22);
			while($res22 = mysqli_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['description'];
			$refrate=$res22['rate'];
			$refrate=$refrate/$fxrate;
			$refamount=$res22['amount'];
			$refamount=$refamount/$fxrate;
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
			$totalopa=$totalopa+$refamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <?php /*?><input type="hidden" name="referalname" value="<?php echo $refname; ?>"><?php */?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			  <input name="opname[]" type="hidden" id="opname" size="69" value="<?php echo $refname; ?>">
			 <input name="oprate4[]" type="hidden" id="oprate4" readonly size="8" value="<?php echo $refrate; ?>">
             <input type="hidden" name="ambulancecount[]" value="<?php echo $sno-1;?>">
              <input name="accountname[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
               <input name="description[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
                <input name="quantityop[]" type="hidden" id="quantityop" readonly size="8" value="<?php echo $qty; ?>">
                 <input name="rateop[]" type="hidden" id="rateop" readonly size="8" value="<?php echo $refrate; ?>">
                  <input name="amountop[]" type="hidden" id="amountop" readonly size="8" value="<?php echo $refamount; ?>">
                   <input name="amdocno[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>">
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refamount, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate*$currconvertrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refamount*$currconvertrate, 2, '.', ','); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if($planforall=='yes'){?>
             <tr <?php echo $colorcode; ?>>
              <?php   $copay=(($refrate*$qty)/100)*$copay1; $totalcopay=$totalcopay+$copay;
			  
			  $totalfxrate += ($copay/$qty)*$currconvertrate;
			  $totalfxamount += $copay*$currconvertrate;
			  ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($copay/$qty), 2, '.', ',');?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay, 2, '.', ','); ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($copay/$qty)*$currconvertrate, 2, '.', ',');?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
             
			  </tr>
			  <input name="copayopamb[]" id="copayopamb" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <input name="copayfxopamb[]" id="copayfxopamb" readonly size="8" type="hidden" value="<?php echo number_format($copay*$currconvertrate, 2, '.', ''); ?>">
			  <?php } else{?>
			   <input name="copayopamb[]" id="copayopamb" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			   <input name="copayfxopamb[]" id="copayfxopamb" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			  <?php
			  }}
			  ?><input type="hidden" name="ambcount" value="<?php echo $ambcount;?>">
              
               <?php 
			   $totalhom=0;
			   $snohome='0';
			  $query22 = "select * from homecare where patientvisitcode='$visitcode' and billtype='PAY LATER' and patientcode='$patientcode' and paymentstatus='completed'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$ambcount1=mysqli_num_rows($exec22);
			while($res22 = mysqli_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['description'];
			$refrate=$res22['rate'];
			$refrate=$refrate/$fxrate;
			$refamount=$res22['amount'];
			$refamount=$refamount/$fxrate;
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
			$totalhom=$totalhom+$refamount;
			
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <?php /*?><input type="hidden" name="referalname" value="<?php echo $refname; ?>"><?php */?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			  <input name="homecare[]" type="hidden" id="homecare" size="69" value="<?php echo $refname; ?>">
			 <input name="homerate4[]" type="hidden" id="homerate4" readonly size="8" value="<?php echo $refrate; ?>">
             <input type="hidden" name="ambulancecounthom[]" value="<?php echo $snohome;?>">
              <input name="accountnamehom[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
               <input name="descriptionhom[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
                <input name="quantityhom[]" type="hidden" id="quantityhom" readonly size="8" value="<?php echo $qty; ?>">
                 <input name="ratehom[]" type="hidden" id="ratehom" readonly size="8" value="<?php echo $refrate; ?>">
                  <input name="amounthom[]" type="hidden" id="amounthom" readonly size="8" value="<?php echo $refamount; ?>">
                   <input name="amdocnohom[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>">
			<?php $snohome=$snohome+1;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refamount, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate*$currconvertrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refamount*$currconvertrate, 2, '.', ','); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
             <?php if($planforall=='yes'){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=(($refrate*$qty)/100)*$copay1; $totalcopay=$totalcopay+$copay;
			  
			  $totalfxrate += ($copay/$qty)*$currconvertrate;
			  $totalfxamount += $copay*$currconvertrate;
			  ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($copay/$qty), 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay, 2, '.', ','); ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($copay/$qty)*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
             
			  </tr>
			  <input name="copayopamb[]" id="copayopamb" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <input name="copayfxophome[]" id="copayfxophome" readonly size="8" type="hidden" value="<?php echo number_format($copay*$currconvertrate, 2, '.', ''); ?>">
			  <?php } else{?>
			   <input name="copayopamb[]" id="copayopamb" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			   <input name="copayfxophome[]" id="copayfxophome" readonly size="8" type="hidden" value="0.00">
			  <?php
			  } }
			  ?><input type="hidden" name="ambcount1" value="<?php echo $ambcount1;?>">
              
              
              
              
              
              
              
              
              
              
              
              
			   <?php 
			   $totaldepartmentref=0;
			  $query231 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'";
			$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res231 = mysqli_fetch_array($exec231))
			{
			$departmentrefdate=$res231['consultationdate'];
			$departmentrefname=$res231['referalname'];
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
			 <input name="departmentreferalrate4[]" type="hidden" id="departmentreferalrate4" readonly size="8" value="<?php echo $departmentrefrate; ?>">
			  <input name="fxdepartmentref[]" type="hidden" id="fxdepartmentref" readonly size="8" value="<?php echo $departmentrefrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($departmentrefrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($departmentrefrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($departmentrefrate, 2, '.', ','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($departmentrefrate, 2, '.', ','); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
              </tr>
             <?php if($planforall=='yes'){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=(($departmentrefrate*$qty)/100)*$copay1; $totalcopay=$totalcopay+$copay;
			  
			  $totalfxrate += ($copay/$qty)*$currconvertrate;
			  $totalfxamount += $copay*$currconvertrate;
			  ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($copay/$qty), 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay, 2, '.', ','); ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($copay/$qty)*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay*$currconvertrate, 2, '.', ','); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong><img src="img/selected.png" width="15" height="15"></strong></div></td>
             
			  </tr>
			  <input name="copaydepartmentref[]" id="copaydepartmentref" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <input name="copayfxdepartmentref[]" id="copayfxdepartmentref" readonly size="8" type="hidden" value="<?php echo number_format($copay*$currconvertrate, 2, '.', ''); ?>">
			  <?php } else{?>
			   <input name="copaydepartmentref[]" id="copaydepartmentref" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			   <input name="copayfxdepartmentref[]" id="copayfxdepartmentref" readonly size="8" type="hidden" value="0.00">
			  <?php
			  } 
			  ?>
			  
			  <?php }
			  ?>
			  <?php 
			  if($planforall=='yes'){ //echo $dispensingfee;
			  //$overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totaldepartmentref+$dispensingfee)-$totalcopay;
			  $overalltotal=$totalcopay;
			   $overalltotal=number_format($overalltotal,2,'.','');
			   $consultationtotal=$totalcopay;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $totalcopay;
			   $netpay=number_format($netpay,2,'.','');
			   $totalamount=$overalltotal;
			
			   }
			  else
			  { 
			   $overalltotal=($totallab+$totalpharm+$totalrad+$totalser+$totalref+$totaldepartmentref+$desratecopay+$totalopa+$totalhom)+$totalcopay;
			   $overalltotal=number_format($overalltotal,2,'.','');
			   $consultationtotal=$totalcopay;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totaldepartmentref+$desratecopay+$totalopa+$totalhom;
			   $netpay=number_format($netpay,2,'.','');
			   $totalamount=$overalltotal;
				  
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
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Total</strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($overalltotal, 2, '.', ','); ?></strong></td>
				 <td width="4%"  align="left" valign="center" 
               class="bodytext31" bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totalfxamount, 2, '.', ','); ?></strong></td>
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
				//$overalltotal = $overalltotal * $currconvertrate;
				$overalltotal = $totalfxamount;
				$billamountpatient=$overalltotal;
				
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
                  <input type="hidden" name="originalamt" id="originalamt" value="<?php echo $originalamount; ?>" style="text-align:right" size="8"  readonly="readonly" />
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
                bgcolor="#F3F3F3" class="bodytext31"><select name="billtype" id="billtype" onChange="functionchangemode(); return paymentinfo(); ">
                  <option value="">SELECT BILL TYPE</option>
                  <?php
					$query1billtype = "select * from master_billtype where status = '' order by listorder";
					$exec1billtype = mysqli_query($GLOBALS["___mysqli_ston"], $query1billtype) or die ("Error in Query1billtype".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
                <td align="left" valign="middle" bgcolor="#F3F3F3" class="bodytext31" width="136">
				<!--<select name="billtype" id="billtype" onChange="return paymentinfo()" onFocus="return funcbillamountcalc1()">--></td>
                
                <td align="left" valign="middle" bgcolor="#F3F3F3" class="bodytext31" width="83">&nbsp;</td>
                <td align="left" valign="middle" bgcolor="#F3F3F3" width="74">&nbsp;</td>
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
				   <td ><select  name="currency1" id="currency" onChange="return functioncurrencyfx(this.value)">
                   <option value="">Select Currency</option>
                                    
                    <?php
					$query1currency = "select * from master_currency where recordstatus = '' ";
					$exec1currency = mysqli_query($GLOBALS["___mysqli_ston"], $query1currency) or die ("Error in Query1currency".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
bgcolor="#F3F3F3" class="bodytext31"><input name="creditamount" id="creditamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="getEncAmount(); return balancecalc('2');"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA No. </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="52"><input name="mpesanumber" id="mpesanumber" value="" style="text-align:left; text-transform:uppercase" size="8"  <?php if($mpesa_integration == 9){ echo "readonly"; } ?> /></td>
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
bgcolor="#F3F3F3" class="bodytext31"><input name="cardamount" id="cardamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="getBarclayAmount(); return balancecalc('4')"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Transaction No </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="52"><input name="cardnumber" id="cardnumber" value="" style="text-align:left; text-transform:uppercase" size="8" <?php if($barclayscard_integration == 1){ echo "readonly"; } ?> /></td>
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
				$execcom=mysqli_query($GLOBALS["___mysqli_ston"], $querycom) or die("Error in querycom".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
					<input name="form_flag" id="form_flag" type="hidden" value="copay">
                  <input name="delbillst" id="delbillst" type="hidden" value="billedit">
                  <input name="delbillautonumber" id="delbillautonumber" type="hidden" value="<?php echo $delbillautonumber;?>">
                  <input name="delbillnumber" id="delbillnumber" type="hidden" value="<?php echo $delbillnumber;?>">
                <!--  <input name="adjustamount" id="adjustamount" value="0.00" style="text-align:right" size="8" type="hidden"/> -->
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
			      
            <!-- NEW CODE STARTS -->
             <tr>
	   
        
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="100%" 
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
		
      </tr>
            <!-- NEW CODE ENDS -->
            </tbody>
        </table></td>
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