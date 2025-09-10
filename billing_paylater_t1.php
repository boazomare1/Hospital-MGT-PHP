<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatetime = date("H:i:s");
$updatedatetime = date ("Y-m-d H:i:s");  
$dateonly = date("Y-m-d");
$currentdate = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$printbill = $_REQUEST["printbill"];
$docno=$_SESSION["docno"];
$totalcopayfixedamount='';
$totalcopay='';
$consult_fxdiscamount = 0;
$pharmacy_fxdiscamount = 0;
$lab_fxdiscamount = 0;
$radiology_fxdiscamount = 0;
$services_fxdiscamount = 0;

$pharmacy_fxrate=2872.49;
	
			
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
$billno='';
 $ambcount=isset($_REQUEST['ambcount'])?$_REQUEST['ambcount']:'';
 $ambcount1=isset($_REQUEST['ambcount1'])?$_REQUEST['ambcount1']:'';
 $locationname=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		 $locationcode=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["patientname"])) { $patientname = $_REQUEST["patientname"]; } else { $patientname = ""; }

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if($frm1submit1 =='seekapproval')
{
	$patientcode = isset($_REQUEST["customercode"])?$_REQUEST["customercode"]:'';
	 $query2 = "UPDATE master_consultation SET consolidateapproval = '1' WHERE patientcode = '".$patientcode."' AND patientvisitcode='".$visitcode."'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	header("location:approvallist2.php?visitcode=$visitcode&&cbfrmflag1=cbfrmflag1&&patientcode=$patientcode&&location=$locationcode");
	}
if ($frm1submit1 == 'frm1submit1')
{ 
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	$patientname = $_REQUEST["patientname"];
	$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res3 = mysqli_fetch_array($exec3);
$paylaterbillprefix = $res3['paylaterbillprefix'];
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_paylater where patientcode <> '' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1'."-".date('y');
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
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum."-".date('y');
	$openingbalance = '0.00';
	//echo $companycode;
}

	$billno = $billnumbercode;
	$accountname= $_REQUEST['accountname'];
	$accountcode = $_REQUEST['accountcode'];
	$accountnameano = $_REQUEST['accountnameano'];
	$subtype = $_REQUEST['subtype'];
	$subtypeano = $_REQUEST['subtypeano'];
	$paymenttype = $_REQUEST['paymenttype'];
	$totalamount=$_REQUEST['totalamount'];
	$totalfxamount=$_REQUEST['totalfxamount'];
	$currency=$_REQUEST['currency'];
	$fxrate=$_REQUEST['fxrate'];
	$billdate=$_REQUEST['billdate'];
	$consultationamount=$_REQUEST['consultation'];
	$consultationfxamount=$_REQUEST['consultationfxamount'];
	$consulatationfxrate=$consultationfxamount;
	$consultationfxamount=$consultationamount*$fxrate;
	$labcoa = $_REQUEST['labcoa'];
		$radiologycoa = $_REQUEST['radiologycoa'];
		$servicecoa = $_REQUEST['servicecoa'];
		$pharmacycoa = $_REQUEST['pharmacycoa'];
		$referalcoa = $_REQUEST['referalcoa'];
		$consultationcoa = $_REQUEST['consultationcoa'];

		$overalltotal = $_REQUEST['overalltotal'];		

		$query7691 = "select * from master_financialintegration where field='externaldoctors'";
		$exec7691 = mysqli_query($GLOBALS["___mysqli_ston"], $query7691) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$res7691 = mysqli_fetch_array($exec7691);
		
		$debitcoa = $res7691['code'];

	$referalname=$_REQUEST['referalname'];
	$query77 = "select * from master_visitentry where visitcode='$visitcode'";
		$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$res77 = mysqli_fetch_array($exec77);
		$doctor = $res77['consultingdoctor'];
		
		$query78 = "select * from master_doctor where auto_number='$doctor'";
		$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$res78 = mysqli_fetch_array($exec78);
		$doctorname = $res78['doctorname'];
		
		//this is for updating the opdue in master_custormer table
		$opduevalue=0;
		$query78 = "select opdue, plandue from master_customer where customercode='$patientcode'";
		$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$opdue = mysqli_fetch_array($exec78);
		$opduevalue  =  $opdue['opdue'];
		$plandue  =  $opdue['plandue'];
		
		$opduevalue=$opduevalue+$overalltotal;
		$planduevalue=$plandue+$overalltotal;
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE master_customer SET opdue = '".$opduevalue."', plandue = '".$planduevalue."' where customercode='$patientcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query2 = "select * from billing_paylater where billno = '$billnumbercode'";
	 $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
     $res29 = mysqli_num_rows($exec2);
	if ($res29 == 0)
	{
		//inserting ambulance bill details
		//echo $quantity;
		//echo $ambcount;
		if($ambcount>0)
		{//echo "ok";
			
			foreach($_POST['ambulancecount'] as $key)
			{ 
				 $amdocno=$_REQUEST['amdocno'][$key];
				 $accountname=$_REQUEST['accountname'][$key];
				$description=$_REQUEST['description'][$key];
				$quantity=$_REQUEST['quantityamb'][$key];
				$rate=$_REQUEST['rateamb'][$key];
				$amount=$_REQUEST['amountamb'][$key];
				$actualamount=$_REQUEST['actualamount'][$key];
				$ambfxrate=$_REQUEST['ambfxrate'][$key];
				$ambfxamount=$_REQUEST['ambfxamount'][$key];
				$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_opambulancepaylater(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,actualamount,billnumber,currency,exchrate,fxrate,fxamount)values('".$amdocno."','$patientcode','$patientname','$visitcode','$accountname','".$description."','".$quantity."','".$rate."','".$amount."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','".$actualamount."','".$billno."','$currency','$fxrate','$ambfxrate','$ambfxamount')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				}
				
				mysqli_query($GLOBALS["___mysqli_ston"], "update op_ambulance set paymentstatus='completed' where patientvisitcode='$visitcode' and description = '$description'");
			}
			
			//inserting ambulance ends here
			if($ambcount1>0)
		{//echo "ok";
			
			foreach($_POST['ambulancecounthom'] as $key)
			{ 
				 $amdocno2=$_REQUEST['amdocnohom'][$key];
				 $accountname2=$_REQUEST['accountnamehom'][$key];
				$description2=$_REQUEST['descriptionhom'][$key];
				 $quantity2=$_REQUEST['quantityhom'][$key];
				$rate2=$_REQUEST['ratehom'][$key];
				$amount2=$_REQUEST['amounthom'][$key];
				$actualamount2=$_REQUEST['actualamounthom'][$key];
				$homefxrate=$_REQUEST['homefxrate'][$key];
				$homefxamount=$_REQUEST['homefxamount'][$key];
				$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_homecarepaylater(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,actualamount,billnumber,currency,exchrate,fxrate,fxamount)values('".$amdocno2."','$patientcode','$patientname','$visitcode','$accountname2','".$description2."','".$quantity2."','".$rate2."','".$amount2."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','".$actualamount2."','".$billno."','$currency','$fxrate','$homefxrate','$homefxamount')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				}
				//exit();
				mysqli_query($GLOBALS["___mysqli_ston"], "update homecare set paymentstatus='completed' where patientvisitcode='$visitcode' and description = '$description2'");
			}
			
			//inserting ambulance ends here
		 $query291 = "select * from billing_paylater where visitcode='$visitcode'";
	 $exec291 = mysqli_query($GLOBALS["___mysqli_ston"], $query291) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	 $num291 = mysqli_num_rows($exec291);
	if($num291 == 0)
	{
		
				
		  $query29 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$num29=mysqli_num_rows($exec29);
		if($num29 != 0)
		{
		mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set pharmacybill='completed' where visitcode='$visitcode'");
		}
		  $query30 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num30=mysqli_num_rows($exec30);
		if($num30 != 0)
		{
		mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set labbill='completed' where visitcode='$visitcode'");
		}
		 $query31 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$num31=mysqli_num_rows($exec31);
			if($num31 != 0)
			{
			mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set radiologybill='completed' where visitcode='$visitcode'");
			}
			  $query32 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num32=mysqli_num_rows($exec32);
		if($num32 != 0)
		{
			mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set servicebill='completed' where visitcode='$visitcode'");
		}
			  $query33 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num33=mysqli_num_rows($exec33);
		if($num33 != 0)
		{
		mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set referalbill='completed' where visitcode='$visitcode'");
		}
		
				foreach($_POST['medicinename'] as $key=>$value)
		{	
		    //echo '<br>'.$i;
			//echo '<br>'.
			//$autonumber = $_REQUEST['autonumber'.$p];	
			//echo '<br>'.
		    $medicinename = $_POST['medicinename'][$key];
			$medicinename = addslashes($medicinename);
			$query77="select * from master_medicine where itemname='$medicinename' and status <> 'deleted'";
			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
			$res77=mysqli_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			//$rate=$res77['rateperunit'];
			$quantity = $_POST['quantity'][$key];
			$amount = $_POST['amount'][$key];
			$pharfxrate = $_POST['pharfxrate'][$key];
			$pharfxamount = $_POST['pharfxamount'][$key];
			$rate = $_REQUEST['rate'][$key];
			
			$query6 = "select ledgername, ledgercode, ledgerautonumber,incomeledger,incomeledgercode from master_medicine where itemcode = '$medicinecode'"; 
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
		        $query2 = "insert into billing_paylaterpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,pharmacycoa,username,locationname,locationcode,currency,exchrate,fxrate,fxamount,ledgercode,ledgername,incomeledger,incomeledgercode) 
				values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$currentdate','$ipaddress','$accountname','unpaid','$medicinecode','$billno','$pharmacycoa','$username','".$locationname."','".$locationcode."','$currency','$fxrate','$pharfxrate','$pharfxamount','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			$fxrate = $original_fxrate;
										
			}
		
		}


		foreach($_POST['lab'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$labname=$_POST['lab'][$key];
		$labcode=$_POST['labcode'][$key];
		if($labcode==''){
			$labquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_lab where itemname='$labname' and status <> 'deleted'");
			$execlab=mysqli_fetch_array($labquery);
			$labcode=$execlab['itemcode'];
		}
		$labrate=$_POST['rate5'][$key];
		$labfxrate=$_POST['labfxrate'][$key];
		if($labname!="")
		{
			
			 /*"insert into billing_paylaterlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,labcoa,username,locationname,locationcode)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$currentdate','unpaid','$billno','$labcoa','$username','".$locationname."','".$locationcode."')"; exit;*/
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paylaterlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,labcoa,username,locationname,locationcode,currency,exchrate,fxrate,fxamount)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$currentdate','unpaid','$billno','$labcoa','$username','".$locationname."','".$locationcode."','$currency','$fxrate','$labfxrate','$labfxrate')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}
		
		foreach($_POST['radiology'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['radiology'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$radfxrate= $_POST['radfxrate'][$key];
		$pairvar1= $pairs1;
		$radiologycode= $_POST['radcode'][$key];

		if($radiologycode==''){
			$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_radiology where itemname='$pairvar' and status <> 'deleted'");
			$execradiology=mysqli_fetch_array($radiologyquery);
			$radiologycode=$execradiology['itemcode'];
		}
		
		
		if($pairvar!="")
		{
		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paylaterradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,paymentstatus,billnumber,radiologycoa,username,locationname,locationcode,currency,exchrate,fxrate,fxamount)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$currentdate','unpaid','$billno','$radiologycoa','$username','".$locationname."','".$locationcode."','$currency','$fxrate','$radfxrate','$radfxrate')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$servicesname=$_POST["services"][$key];
		$servicescode=$_POST["sercode"][$key];
	
		if($servicescode==''){
		$servicequery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_services where itemname='$servicesname' and status <> 'deleted'");
		$execservice=mysqli_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		}
		
		$servicesrate=$_POST["rate3"][$key];
		$quantityser=$_POST['quantityser'][$key];
		$seramount=$_POST['totalservice3'][$key];
				$wellnesspkg=$_POST["wellnesspkg"][$key];

		$serfxrate=$_POST['serfxrate'][$key];
		$serfxrateqty=$_POST['serfxrateqty'][$key];
		/*for($se=1;$se<=$quantityser;$se++)
		{*/			
		if($servicesname!="")
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paylaterservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,servicecoa,username,locationname,locationcode,serviceqty,amount,currency,exchrate,fxrate,fxamount,wellnesspkg)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$currentdate','unpaid','$billno','$servicecoa','$username','".$locationname."','".$locationcode."','".$quantityser."','".$seramount."','$currency','$fxrate','$serfxrate','$serfxrateqty','$wellnesspkg')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		/*}*/
		
		
		
		}
		
		  $query21 = "select * from consultation_services where servicesitemcode NOT IN (SELECT servicesitemcode FROM billing_paynowservices WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''   and  paymentstatus = 'completed' and wellnessitem = '1' and approvalstatus <> '2' and approvalstatus = '1' group by servicesitemcode";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$row21 = mysqli_num_rows($exec21);
			while($res21 = mysqli_fetch_array($exec21))
			{
	
		
		$servicesname=$res21["servicesitemname"];
		
		$servicescode=$res21['servicesitemcode'];
		
		$servicesrate=$res21["servicesitemrate"];
		
		$serfxrateqty=$res21["servicesitemrate"]*$fxrate;
		
	
				
		if($servicesname!="")
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paylaterservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,servicecoa,username,locationname,locationcode,serviceqty,amount,currency,exchrate,fxrate,fxamount,wellnessitem)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$currentdate','unpaid','$billno','$servicecoa','$username','".$locationname."','".$locationcode."','1','".$servicesrate."','$currency','$fxrate','$serfxrateqty','$serfxrateqty','1')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		
		foreach($_POST['referal'] as $key=>$value)
		{
		$pairs2= $_POST['referal'][$key];
		$pairvar2= $pairs2;
	    $pairs3= $_POST['rateref'][$key];
		$pairs3amt= $_POST['raterefamt'][$key];
		$reffxrate= $_POST['reffxrate'][$key];
		$reffxrate= $_POST['reffxrate'][$key];
		$pairvar3= $pairs3;
		
		$referalquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_doctor where doctorname='$pairvar2'");
		$execreferal=mysqli_fetch_array($referalquery);
		$referalcode=$execreferal['doctorcode'];
		
		//echo $pairs2;
		if($pairvar2!="")
		{
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paylaterreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,referalcoa,locationname,locationcode,referalamount,currency,exchrate,fxrate,fxamount)values('$patientcode','$patientname','$visitcode','$referalcode','$pairvar2','$pairvar3','$accountname','$currentdate','unpaid','$billno','$referalcoa','".$locationname."','".$locationcode."','".$pairs3amt."','$currency','$fxrate','$reffxrate','$reffxrate')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		}
		}
		if($referalcode == '')
		{
		$debitcoa = '';
		}
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paylater(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,referalname,doctorstatus,billstatus,subtype,creditcoa,debitcoa,locationname,locationcode,currency,exchrate,fxamount,accountcode,accountnameid,accountnameano)values('$billno','$patientname','$patientcode','$visitcode','$totalamount','$billdate','$accountname','$referalname','unpaid','unpaid','$subtype','$referalcode','$debitcoa','".$locationname."','".$locationcode."','$currency','$fxrate','$totalfxamount','$accountcode','$accountcode','$accountnameano')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		foreach($_POST['departmentreferal'] as $key=>$value)
		{
		$pairs21= $_POST['departmentreferal'][$key];
		$pairvar21= $pairs21;
	    $pairs31= $_POST['departmentreferalrate4'][$key];
		$deptfxrate= $_POST['deptfxrate'][$key];
		$deptfxamount= $_POST['deptfxamount'][$key];
		$pairvar31= $pairs31;
		
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_department where department ='$pairvar21'");
		$execreferal1=mysqli_fetch_array($referalquery1);
		$referalcode1=$execreferal1['auto_number'];
		
		//echo $pairs2;
		if($pairvar21!="")
		{
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paylaterreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,currency,exchrate,fxrate,fxamount)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billno','$username','$referalcoa','".$locationname."','".$locationcode."','$currency','$fxrate','$deptfxrate','$deptfxamount')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		}
		}
		
		foreach($_POST['consult_discamount'] as $key=>$value)
		{
			$pw_consult = $_POST['consult_discamount'][$key];
			$pw_fxconsult = $_POST['consult_fxdiscamount'][$key];
			
			$querypwc = "select visitcode from billing_patientweivers where patientcode = '$patientcode' and visitcode = '$visitcode'";
			$execpwc = mysqli_query($GLOBALS["___mysqli_ston"], $querypwc) or die ("Error in Querypwc".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$rowpwc = mysqli_num_rows($execpwc);
			if($rowpwc == 0)
			{
				$querypwc1 = "INSERT INTO `billing_patientweivers`(`billno`, `entrydate`, `patientcode`, `visitcode`, `patientname`, `billtype`, `accountnameid`, `accountnameano`, `accountname`, `consultationamount`, `consultationfxamount`, `locationcode`, `locationname`, `username`, `ipaddress`, `updatedatetime`) 
							  VALUES('$billno','$billdate','$patientcode','$visitcode','$patientname','PAY LATER','$accountcode','$accountnameano','$accountname','$pw_consult','$pw_fxconsult','$locationcode','$locationname','$username','$ipaddress','$updatedatetime')";							  
				$execpwc1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwc1) or die ("Error in Querypwc1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
			else
			{
				$querypwc1 = "UPDATE `billing_patientweivers` SET `consultationamount` = '$pw_consult', `consultationfxamount` = '$pw_fxconsult' WHERE patientcode = '$patientcode' and visitcode = '$visitcode'";
				$execpwc1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwc1) or die ("Error in Querypwc1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}
		
		foreach($_POST['pharmacy_discamount'] as $key=>$value)
		{
			$pw_pharmacy = $_POST['pharmacy_discamount'][$key];
			$pw_fxpharmacy = $_POST['pharmacy_fxdiscamount'][$key];
			
			$querypwp = "select visitcode from billing_patientweivers where patientcode = '$patientcode' and visitcode = '$visitcode'";
			$execpwp = mysqli_query($GLOBALS["___mysqli_ston"], $querypwp) or die ("Error in Querypwp".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$rowpwp = mysqli_num_rows($execpwp);
			if($rowpwp == 0)
			{
				$querypwp1 = "INSERT INTO `billing_patientweivers`(`billno`, `entrydate`, `patientcode`, `visitcode`, `patientname`, `billtype`, `accountnameid`, `accountnameano`, `accountname`, `pharmacyamount`, `pharmacyfxamount`, `locationcode`, `locationname`, `username`, `ipaddress`, `updatedatetime`) 
							  VALUES('$billno','$billdate','$patientcode','$visitcode','$patientname','PAY LATER','$accountcode','$accountnameano','$accountname','$pw_pharmacy','$pw_fxpharmacy','$locationcode','$locationname','$username','$ipaddress','$updatedatetime')";							  
				$execpwp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwp1) or die ("Error in Querypwp1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
			else
			{
				$querypwp1 = "UPDATE `billing_patientweivers` SET `pharmacyamount` = '$pw_pharmacy', `pharmacyfxamount` = '$pw_fxpharmacy' WHERE patientcode = '$patientcode' and visitcode = '$visitcode'";
				$execpwp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwp1) or die ("Error in Querypwp1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}
		
		foreach($_POST['lab_discamount'] as $key=>$value)
		{
			$pw_lab = $_POST['lab_discamount'][$key];
			$pw_fxlab = $_POST['lab_fxdiscamount'][$key];
			
			$querypwl = "select visitcode from billing_patientweivers where patientcode = '$patientcode' and visitcode = '$visitcode'";
			$execpwl = mysqli_query($GLOBALS["___mysqli_ston"], $querypwl) or die ("Error in Querypwl".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$rowpwl = mysqli_num_rows($execpwl);
			if($rowpwl == 0)
			{
				$querypwl1 = "INSERT INTO `billing_patientweivers`(`billno`, `entrydate`, `patientcode`, `visitcode`, `patientname`, `billtype`, `accountnameid`, `accountnameano`, `accountname`, `labamount`, `labfxamount`, `locationcode`, `locationname`, `username`, `ipaddress`, `updatedatetime`) 
							  VALUES('$billno','$billdate','$patientcode','$visitcode','$patientname','PAY LATER','$accountcode','$accountnameano','$accountname','$pw_lab','$pw_fxlab','$locationcode','$locationname','$username','$ipaddress','$updatedatetime')";							  
				$execpwl1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwl1) or die ("Error in Querypwl1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
			else
			{
				$querypwl1 = "UPDATE `billing_patientweivers` SET `labamount` = '$pw_lab', `labfxamount` = '$pw_fxlab' WHERE patientcode = '$patientcode' and visitcode = '$visitcode'";
				$execpwl1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwl1) or die ("Error in Querypwl1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}
		
		foreach($_POST['radiology_discamount'] as $key=>$value)
		{
			$pw_radiology = $_POST['radiology_discamount'][$key];
			$pw_fxradiology = $_POST['radiology_fxdiscamount'][$key];
			
			$querypwr = "select visitcode from billing_patientweivers where patientcode = '$patientcode' and visitcode = '$visitcode'";
			$execpwr = mysqli_query($GLOBALS["___mysqli_ston"], $querypwr) or die ("Error in Querypwr".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$rowpwr = mysqli_num_rows($execpwr);
			if($rowpwr == 0)
			{
				$querypwr1 = "INSERT INTO `billing_patientweivers`(`billno`, `entrydate`, `patientcode`, `visitcode`, `patientname`, `billtype`, `accountnameid`, `accountnameano`, `accountname`, `radiologyamount`, `radiologyfxamount`, `locationcode`, `locationname`, `username`, `ipaddress`, `updatedatetime`) 
							  VALUES('$billno','$billdate','$patientcode','$visitcode','$patientname','PAY LATER','$accountcode','$accountnameano','$accountname','$pw_radiology','$pw_fxradiology','$locationcode','$locationname','$username','$ipaddress','$updatedatetime')";							  
				$execpwr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwr1) or die ("Error in Querypwr1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
			else
			{
				$querypwr1 = "UPDATE `billing_patientweivers` SET `radiologyamount` = '$pw_radiology', `radiologyfxamount` = '$pw_fxradiology' WHERE patientcode = '$patientcode' and visitcode = '$visitcode'";
				$execpwr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypwr1) or die ("Error in Querypwr1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}
		
		foreach($_POST['services_discamount'] as $key=>$value)
		{
			$pw_services = $_POST['services_discamount'][$key];
			$pw_fxservices = $_POST['services_fxdiscamount'][$key];
			
			$querypws = "select visitcode from billing_patientweivers where patientcode = '$patientcode' and visitcode = '$visitcode'";
			$execpws = mysqli_query($GLOBALS["___mysqli_ston"], $querypws) or die ("Error in Querypws".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$rowpws = mysqli_num_rows($execpws);
			if($rowpws == 0)
			{
				$querypws1 = "INSERT INTO `billing_patientweivers`(`billno`, `entrydate`, `patientcode`, `visitcode`, `patientname`, `billtype`, `accountnameid`, `accountnameano`, `accountname`, `servicesamount`, `servicesfxamount`, `locationcode`, `locationname`, `username`, `ipaddress`, `updatedatetime`) 
							  VALUES('$billno','$billdate','$patientcode','$visitcode','$patientname','PAY LATER','$accountcode','$accountnameano','$accountname','$pw_services','$pw_fxservices','$locationcode','$locationname','$username','$ipaddress','$updatedatetime')";							  
				$execpws1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypws1) or die ("Error in Querypws1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
			else
			{
				$querypws1 = "UPDATE `billing_patientweivers` SET `servicesamount` = '$pw_services', `servicesfxamount` = '$pw_fxservices' WHERE patientcode = '$patientcode' and visitcode = '$visitcode'";
				$execpws1 = mysqli_query($GLOBALS["___mysqli_ston"], $querypws1) or die ("Error in Querypws1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			}
		}


	mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_paylaterconsultation(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,billstatus,consultationcoa,locationname,locationcode,currency,exchrate,fxrate,fxamount)values('$billno','$patientname','$patientcode','$visitcode','$consultationamount','$billdate','$accountname','unpaid','$consultationcoa','".$locationname."','".$locationcode."','$currency','$fxrate','$consultationfxamount','$consultationfxamount')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	$query43="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountcode,accountname,billnumber,ipaddress,companyanum,companyname,financialyear,transactiontype,paymenttype,subtype,transactionamount,doctorname,username,transactiontime,locationname,locationcode,billamount,currency,exchrate,fxamount,accountnameano,accountnameid,subtypeano,billbalanceamount)values('$patientname','$patientcode','$visitcode','$billdate','$accountcode','$accountname','$billno','$ipaddress','$companyanum','$companyname','$financialyear','finalize','$paymenttype','$subtype','$totalamount','$doctorname','$username','$updatedatetime','".$locationname."','".$locationcode."','$totalamount','$currency','$fxrate','$totalfxamount','$accountnameano','$accountcode','$subtypeano','$totalfxamount')";
	$exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die("error in query43".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);		  
	mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set overallpayment='completed' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	mysqli_query($GLOBALS["___mysqli_ston"], "update master_triage set overallpayment='completed' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
		//header("location:billing_pending_op2.php?billautonumber=$billno&&st=success&&printbill=$printbill");
		//exit;
		header("location:writexml.php?billautonumber=$billno&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode");
		}
		else
		{
		header("location:billing_pending_op2.php");
		}
		
		}
		else
		{
		header("location:billing_pending_op2.php");
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

$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$patientsubtypeano=$execsubtype['auto_number'];
$patientplan=$execlab['planname'];
$currency=$execsubtype['currency'];
$fxrate=$execsubtype['fxrate'];

if($currency=='')
{
	$currency='UGX';
}
$labtemplate = $execsubtype['labtemplate'];
if($labtemplate == '') { $labtemplate = 'master_lab'; }
$radtemplate = $execsubtype['radtemplate'];
if($radtemplate == '') { $radtemplate = 'master_radiology'; }
$sertemplate = $execsubtype['sertemplate'];
if($sertemplate == '') { $sertemplate = 'master_services'; }


$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");
$execplan=mysqli_fetch_array($queryplan);
$patientplan1=$execplan['planname'];
$smartap=$execplan['smartap'];

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

$query76 = "select * from master_financialintegration where field='labpaylater'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res76 = mysqli_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologypaylater'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res761 = mysqli_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='servicepaylater'";
$exec762 = mysqli_query($GLOBALS["___mysqli_ston"], $query762) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res762 = mysqli_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalpaylater'";
$exec763 = mysqli_query($GLOBALS["___mysqli_ston"], $query763) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res763 = mysqli_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacypaylater'";
$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res764 = mysqli_fetch_array($exec764);

$pharmacycoa = $res764['code'];

$query76 = "select * from master_financialintegration where field='consultationfee'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res76 = mysqli_fetch_array($exec76);
$consultationcoa = $res76['code'];

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res3 = mysqli_fetch_array($exec3);
$paylaterbillprefix = $res3['paylaterbillprefix'];
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_paylater where patientcode <> '' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1'."-".date('y');
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
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum."-".date('y');
	$openingbalance = '0.00';
	//echo $companycode;
}

$query85 = "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
$exec85 = mysqli_query($GLOBALS["___mysqli_ston"], $query85) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res85 = mysqli_fetch_array($exec85);
$consultationfee=$res85['consultationfees'];
$consultationfee = number_format($consultationfee,2,'.','');
$viscode=$res85['visitcode'];
$consultationdate=$res85['consultationdate'];
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
<?php include ("js/sales1scripting1.php"); ?>
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
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
</style>

<script src="js/datetimepicker_css.js"></script>
<script>
function loadprintpage1(banum)
{
	var banum = banum;
	window.open("print_paylater_summary.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function funcSaveBill1()
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
<script src="js/autocustomersmartsearch_new.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" onKeyDown="return disableEnterKey(event)" onSubmit="return funcSaveBill1()">
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
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
						$res1 = mysqli_fetch_array($exec1);
						
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						
                <tr bgcolor="#011E6A">
                <td colspan="4" bgcolor="#ecf0f5" class="bodytext32"><strong>Pay Later Patient Details</strong></td>
                <td  colspan="4" bgcolor="#ecf0f5" class="bodytext32"><strong>Location:&nbsp;&nbsp;<?php echo $locationname ?> </strong></td>
                 <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>">
                 <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>">
			 </tr>
			 
		<?php
			if ($st == 'success' && $billautonumber != '' && $patientname != '' && $patientcode !='' && $visitcode !='')
			{
			?>
            <tr>
              <td colspan="8"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage1('<?php echo $billautonumber; ?>')" value="Click Here To Print Summary" class="button" style="border: 1px solid #001E6A"/>
			  <input name="billprint" type="button" onClick="return loadprintpage2('<?php echo $billautonumber; ?>')" value="Click Here To Print Detailed" class="button" style="border: 1px solid #001E6A"/>
			  </td>
              
            </tr>
			<?php
			}
			?>
			
			  <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $patientname; ?>
				<input type="hidden" name="patientname" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>                  </td>
                 
             <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Type</strong></td>
                <td width="28%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patienttype1; ?>
								</td>
		      </tr>
			   <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style4">Reg.No</td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $patientcode; ?>
				<input type="hidden" name="customercode" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="registrationdate" id="registrationdate" value="<?php echo date('Y-m-d'); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="labcoa" value="<?php echo $labcoa; ?>">
				<input type="hidden" name="radiologycoa" value="<?php echo $radiologycoa; ?>">
				<input type="hidden" name="servicecoa" value="<?php echo $servicecoa; ?>">
				<input type="hidden" name="pharmacycoa" value="<?php echo $pharmacycoa; ?>">
				<input type="hidden" name="referalcoa" value="<?php echo $referalcoa; ?>">
				<input type="hidden" name="consultationcoa" value="<?php echo $consultationcoa; ?>">
		
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
				    <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Sub Type</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientsubtype1; ?>
				<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="subtypeano" id="subtypeano" value="<?php echo $patientsubtypeano; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>">			</td>
			  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit No </strong></td>
                  <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $visitcode; ?>
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientaccount1; ?>
				<input type="hidden" name="accountname" id="accountname" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="accountcode" id="accountcode" value="<?php echo $patientaccountid1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="accountnameano" id="accountnameano" value="<?php echo $accountnameano; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				</td>
				  </tr>
                   <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Bill No</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $billnumbercode; ?>
				<input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Plan Name</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientplan1; ?>
				<input type="hidden" name="account1" id="account1" value="<?php echo $patientplan1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  </tr>
                   <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Bill Date</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $dateonly; ?>
				<input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Currency/Fx Rate</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $currency.'/'.$fxrate; ?>
                <input type="hidden" name="currency" id="currency" value="<?php echo $currency; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
                <input type="hidden" name="fxrate" id="fxrate" value="<?php echo $fxrate; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  </tr>
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
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong><?php echo $currency; ?> Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong><?php echo $currency; ?> Amount </strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>UGX Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>UGX Amount </strong></div></td>
				
                  </tr>
				  		<?php
						$admitid='';
			$colorloopcount = '';
			$totalcopayconsult='';
			$sno = '';
			$totalamount=0;
			$totalfxamount=0;
			$totalfxcopay=0;
			$consfxrate=0;
			$conscopayfxrate=0;
			
			$query77 = "select * from billing_paylater where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$rows77 = mysqli_num_rows($exec77);
			if(0 == 0)
			{
			
			
			$query17 = "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee=$res17['consultationfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$plannumber = $res17['planname'];
			$consultingdoctor = $res17['consultingdoctor'];
			
			$admitid = $res17['admitid'];
			$availablelimit = $res17['availablelimit'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			$planpercentage=$res17['planpercentage'];
			$copay=($consultationfee/100)*$planpercentage;
			
			$query_pw = "select `docno`, `entrydate`, `consult_discamount`, `pharmacy_discamount`, `lab_discamount`, `radiology_discamount`, `services_discamount` from patientweivers where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec_pw = mysqli_query($GLOBALS["___mysqli_ston"], $query_pw) or die ("Error in Query_pw".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res_pw = mysqli_fetch_array($exec_pw);
			$consult_discamount = $res_pw['consult_discamount'];
			$pharmacy_discamount = $res_pw['pharmacy_discamount'];
			$lab_discamount = $res_pw['lab_discamount'];
			$radiology_discamount = $res_pw['radiology_discamount'];
			$services_discamount = $res_pw['services_discamount'];
			$pw_docno = $res_pw['docno'];
			$pw_entrydate = $res_pw['entrydate'];
			 
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
			$consultationfee = number_format($consultationfee,2,'.','');
			$consfxrate=$consultationfee*$fxrate;
			$conscopayfxrate=$copay*$fxrate;
			
			$query33 = "select consultation from billing_consultation where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			 $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			 $row33 = mysqli_num_rows($exec33);
 
			if($planpercentage!=0.00 && $row33 > 0)
			{
			 $totalop=$consultationfee; 
			 $totalcopay=$totalcopay+$copay;
			 $totalcopayconsult=$totalcopayconsult+$copay;
			 $totalfxamount=$totalfxamount+$consfxrate;
			 $totalfxcopay=$totalfxcopay+$conscopayfxrate;
			}
			else
			{
				$totalop=$consultationfee; 
	        	$totalcopay=$totalcopay+$copay;
				$totalcopayconsult=$totalcopayconsult+$copay;
				$totalfxamount=$totalfxamount+$consfxrate;
				$totalfxcopay=$totalfxcopay+$conscopayfxrate;
			}
			
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $viscode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $consultingdoctor; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationfee,2); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationfee,2); ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consfxrate,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consfxrate,2,'.',','); ?>
                 <input type="hidden" name="consultationfxamount" id="consultationfxamount" value="<?php echo $consfxrate; ?>">
                 </div></td>
				 
             
				</tr>
                
                <?php if(($planpercentage!=0.00)){
					 $totalfxamount-=$conscopayfxrate;
					 $consfxrate-=$conscopayfxrate;
					?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($conscopayfxrate,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($conscopayfxrate,2); ?></div></td>
			   </tr>
				 
			<?php 
			}
			$query18 = "select * from master_billing where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res18 = mysqli_fetch_array($exec18);
			$billingdatetime=$res18['billingdatetime'];
			$billno=$res18['billnumber'];
			$copayfixed=$res18['copayfixedamount'];
			if($copayfixed > 0)
			{
			$consfxrate=$consfxrate-$copayfixed;
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
			 $conscopayfxrate=$copayfixed*$fxrate;
			 $totalfxamount=$totalfxamount-$conscopayfxrate;
			 $totalcopayfixedamount=$copayfixed;
			 $totalfxcopay=$totalfxcopay+$conscopayfxrate;
			 ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Fixed Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayfixed,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copayfixed,2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($conscopayfxrate,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($conscopayfxrate,2); ?></div></td>
			  
             
			  </tr>
			  <?php 
			} 
			$consfxrefund=0;
			$query11 = "select * from refund_consultation where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$num=mysqli_num_rows($exec11);
			$res11 = mysqli_fetch_array($exec11);
			$res11billnumber = $res11['billnumber'];
			if($num > 0)
			{
			$consultationrefund = $res11['consultation'];
			$res11transactiondate= $res11['billdate'];
			$res11transactiontime= $res11['transactiontime'];
			$consfxrefund=$consultationrefund*$fxrate;
			$consfxrate+=$consfxrefund;
			$totalfxamount=$totalfxamount+$consfxrefund;
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
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res11transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res11billnumber; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Consultation Refund'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationrefund,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationrefund,2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consfxrefund,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consfxrefund,2); ?></div></td>
			  </tr>
			  <?php 
			} 
			
			if($consult_discamount > 0)
			{
			$consult_fxdiscamount = $consult_discamount * $fxrate;
			$totalfxamount=$totalfxamount-$consult_fxdiscamount;
			?>
			<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Consultation Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($consult_discamount,2); ?></div>
			  <input type="hidden" name="consult_discamount[]" id="consult_discamount[]" value="<?php echo $consult_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($consult_discamount,2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($consult_fxdiscamount,2); ?></div>
			  <input type="hidden" name="consult_fxdiscamount[]" id="consult_fxdiscamount[]" value="<?php echo $consult_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($consult_fxdiscamount,2); ?></div></td>
			  </tr>
			<?php
			}
			
			  $totallab=0;
			  $labfxrate=0;
			  $labfxcopay=0;
			  $totalfxlab=0;
			  $labfxcopay=0;
			  $query19 = "select * from consultation_lab where labitemcode NOT IN (SELECT labitemcode FROM billing_paynowlab WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND  patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and freestatus <> 'yes'  AND labrefund <> 'completed' AND labrefund <> 'refund' and  paymentstatus = 'completed' and sampleid <> '' and approvalstatus <> '2' and approvalstatus = '1'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$row19 = mysqli_num_rows($exec19);
			while($res19 = mysqli_fetch_array($exec19))
			{
				$labdate=$res19['consultationdate'];
				$labname=$res19['labitemname'];
				$labcode=$res19['labitemcode'];
				//$labrate=$res19['labitemrate'];
				$labrefno=$res19['refno'];
				
				$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
				$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				$resfx = mysqli_fetch_array($execfx);
				$labrate=$resfx['rateperunit'];
		
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$labrate = number_format($labrate,2,'.','');
			$labfxrate=($labrate*$fxrate);
			$copay=($labrate/100)*$planpercentage;
			$labfxcopay=$copay*$fxrate;
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
              <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totallab=$totallab+$labrate; 
				$totalcopaylab=$totalcopaylab+$copay;
				$totalfxcopay=$totalfxcopay+$labfxcopay;
				$totalfxlab=$totalfxlab+$labfxrate;
				$totalfxcopaylab=$totalfxcopaylab+$labfxcopay; 
				$totalfxamount=$totalfxamount+$labfxrate;
			   }
			   else
			  {$totallab=$totallab+$labrate;$totalfxamount=$totalfxamount+$labfxrate;$totalfxlab=$totalfxlab+$labfxrate; }
			  ?>
              
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $labrate-$copay; } else { echo $labrate;}?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
             <input name="labfxrate[]" id="labfxrate" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $labfxrate-$labfxcopay; } else { echo $labfxrate;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labfxrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labfxrate,2,'.',','); ?></div></td>
			
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;
			   $totalfxamount-=$labfxcopay;
			    $totalfxlab-=$labfxcopay;
			  ?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labfxcopay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($labfxcopay,2); ?></div></td>
			  </tr>
				<?php }?>
			  
			  <?php } 
			  
			if($lab_discamount > 0 && $row19 > 0)
			{
			$lab_fxdiscamount = $lab_discamount * $fxrate;
			$totalfxamount=$totalfxamount-$lab_fxdiscamount;
			?>
			<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Lab Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_discamount,2); ?></div>
			   <input type="hidden" name="lab_discamount[]" id="lab_discamount[]" value="<?php echo $lab_discamount; ?>"></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_discamount,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_fxdiscamount,2); ?></div>
			   <input type="hidden" name="lab_fxdiscamount[]" id="lab_fxdiscamount[]" value="<?php echo $lab_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_fxdiscamount,2); ?></div></td>
			  </tr>
			<?php
			}
			
			  //copay
			   //$totallab=0;
			  $query19 = "select * from consultation_lab where labitemcode  IN (SELECT labitemcode FROM billing_paynowlab WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND  patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and freestatus <> 'yes'  AND labrefund <> 'completed' AND labrefund <> 'refund' and  paymentstatus = 'completed' and sampleid <> '' and approvalstatus <> '2' and approvalstatus = '1'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$row19 = mysqli_num_rows($exec19);
			while($res19 = mysqli_fetch_array($exec19))
			{
				$labdate=$res19['consultationdate'];
				$labname=$res19['labitemname'];
				$labcode=$res19['labitemcode'];
				//$labrate=$res19['labitemrate'];
				$labrefno=$res19['refno'];
				
				$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
				$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				$resfx = mysqli_fetch_array($execfx);
				$labrate=$resfx['rateperunit'];
				
				$labfxrate=($labrate*$fxrate);
				
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			$copay=($labrate/100)*$planpercentage;
			$labfxcopay=$copay*$fxrate;
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
              <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totallab=$totallab+$labrate; 
				$totalcopaylab=$totalcopaylab+$copay;
				$totalfxamount=$totalfxamount+$labfxrate;
				$totalfxcopay=$totalfxcopay+$labfxcopay;
				$totalfxlab=$totalfxlab+$labfxrate;
				$totalfxcopaylab=$totalfxcopaylab+$labfxcopay; 
			   }
			   else
			  {$totallab=$totallab+$labrate;$totalfxamount=$totalfxamount+$labfxrate;$totalfxlab=$totalfxlab+$labfxrate;}
			  ?>
              
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $labrate-$copay; } else { echo $labrate;}?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
             <input name="labfxrate[]" id="labfxrate" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $labfxrate-$labfxcopay; } else { echo $labfxrate;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labfxrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labfxrate,2); ?></div></td>
			
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;
			   $totalfxamount-=$labfxcopay;
			     $totalfxlab-=$labfxcopay;
			  ?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labfxcopay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($labfxcopay,2); ?></div></td>
              </tr>
				<?php }?>
			  
			  <?php } 
	
			if($lab_discamount > 0 && $row19 > 0)
			{
			$lab_fxdiscamount = $lab_discamount * $fxrate;
			$totalfxamount=$totalfxamount-$lab_fxdiscamount;
			?>
			<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Lab Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_discamount,2); ?></div>
			   <input type="hidden" name="lab_discamount[]" id="lab_discamount[]" value="<?php echo $lab_discamount; ?>"></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_discamount,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_fxdiscamount,2); ?></div>
			   <input type="hidden" name="lab_fxdiscamount[]" id="lab_fxdiscamount[]" value="<?php echo $lab_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_fxdiscamount,2); ?></div></td>
			 </tr>
			<?php
			}
			
			$original_fxrate= $fxrate;
			if(strtoupper($currency)=="USD"){
				$fxrate = $pharmacy_fxrate;
			}
			
			   $totalpharm=0;
			   $totalfxpharm=0;
			   $totalfxcopaypharm=0;
			   $pharno1=1;
			  $query23 = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$pharno = mysqli_num_rows($exec23);
			while($res23 = mysqli_fetch_array($exec23))
			{
				$phaquantity=0;
			$phaamount=0;
			$totalrefquantity=0;
			$reftotalamount=0;
			$phadate=$res23['entrydate'];
			echo '<br>'.$phaname=$res23['itemname'];
			$phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];


$serviceitemcode199b=array();
		$query199b = mysqli_query($GLOBALS["___mysqli_ston"], "select a.auto_number,b.itemcode as itemcode from consultation_services as a JOIN master_services as b ON a.servicesitemcode=b.itemcode where a.patientvisitcode = '$visitcode' and b.pkg='Yes'");
/*  		$query199b = mysql_query("select a.auto_number,b.itemcode as itemcode from consultation_services as a JOIN master_services as b ON a.servicesitemcode=b.itemcode where b.pkg='Yes' limit 0,50");
	*/
		$count199b = mysqli_num_rows($query199b);
		if($count199b>0){
  	    while($fetch199b = mysqli_fetch_array($query199b)){			
			array_push($serviceitemcode199b,$fetch199b['itemcode']);
			//$serviceitemcode199b=$fetch199b['itemcode'];
		}
		}
		
 $serviceitemcode=implode("','",$serviceitemcode199b);
		echo ("select auto_number, servicecode from master_serviceslinking where servicecode IN('$serviceitemcode') and itemcode = '$phaitemcode' and recordstatus<>'deleted'");
		$query199a = mysqli_query($GLOBALS["___mysqli_ston"], "select auto_number from master_serviceslinking where servicecode IN('$serviceitemcode') and servicecode <> '' and itemcode = '$phaitemcode' and recordstatus<>'deleted'");
		echo '<br>'.$count199a = mysqli_num_rows($query199a);
		if($count199a>0){
			$pharno-=1; 			
			continue;
		}
			//$pharno1=0;
				 $queryphar = "select auto_number from billing_paynowpharmacy where medicinecode='".$phaitemcode."' and patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$execphar = mysqli_query($GLOBALS["___mysqli_ston"], $queryphar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$pharno1 = mysqli_num_rows($execphar);
				if($pharno1==0){
			$pharno1=3;
			$query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' ";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		    while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query47 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res47 = mysqli_fetch_array($exec47))
			{
			$refquantity = $res47['quantity'];
			$refamount = $res47['totalamount'];
			$totalrefquantity =  $totalrefquantity + $refquantity;
			$reftotalamount = $reftotalamount + $refamount;
			}
		
		
			 $query28 = "select sum(quantity) as quantity from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode' and approvalstatus = '2'";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res28 = mysqli_fetch_array($exec28)){		
				$totalrefquantity+=$res28['quantity'];
							
			}
			
			echo '<br>cc-->'.$realquantity = $phaquantity - $totalrefquantity;

			if($realquantity<=0){
				continue;
			}
			$phaamount = $phaamount - $reftotalamount;
			$pharfxrate=$pharate;
			$pharfxamount=$pharate*$realquantity;
			
			$pharate=number_format($pharate/$fxrate,2,'.','');
			$phaamount=number_format($pharate*$realquantity,2,'.','');
			$phaamount=number_format($phaamount,2,'.','');
			 $query28 = "select * from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode'";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res28 = mysqli_fetch_array($exec28);
			$pharefno=$res28['refno'];
			$excludestatus=$res28['excludestatus'];
			$approvalstatus = $res28['approvalstatus'];
			
			
			if($excludestatus == '')
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
			//$totalpharm=$totalpharm+$phaamount;
			?>
            <?php 
			$copayfxamount=(($pharate*$realquantity)/100)*$planpercentage;
			$copay=($copayfxamount/$fxrate);
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalpharm=$totalpharm+$phaamount;
				$totalcopaypharm=$totalcopaypharm+$copay;
				
				$totalpharm=$totalpharm+$phaamount;
				$totalcopaypharm=$totalcopaypharm+$copay;
				$totalfxpharm=$totalfxpharm+$pharfxamount;
				$totalfxcopaypharm=$totalfxcopaypharm+$copayfxamount;
				$totalfxcopay=$totalfxcopay+$copayfxamount;

				$totalfxamount=$totalfxamount+$pharfxamount;
			   }
			   else
			  {$totalpharm=$totalpharm+$phaamount;$totalfxamount=$totalfxamount+$pharfxamount;$totalfxpharm=$totalfxpharm+$pharfxamount;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $realquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php   echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $phaamount-$copay; } else { echo $phaamount;}  ?>">
             <input name="pharfxrate[]" id="pharfxrate" readonly size="8" type="hidden" value="<?php echo $pharfxrate; ?>">
             <input name="pharfxamount[]" id="pharfxamount" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $pharfxamount-$copayfxamount; } else { echo $pharfxamount;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $realquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount,2); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharfxrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharfxamount,2,'.',','); ?></div></td>
			
             </tr>
             <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;
			  $totalfxamount-=$copay*$realquantity;
			    $totalfxpharm-=$copay*$realquantity;
			 ?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format($realquantity,2); ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay*$realquantity,2); ?></div></td>
			  
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  }}
			  ?>
              <?php
			  if($pharmacy_discamount > 0 && $pharno > 0 && $pharno1==1)
			  {
			  $queryphar = "select auto_number from billing_paynowpharmacy where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			  $execphar = mysqli_query($GLOBALS["___mysqli_ston"], $queryphar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			  $pharno1 = mysqli_num_rows($execphar);
			  if($pharno1==0){
			  $pharmacy_fxdiscamount = $pharmacy_discamount * $fxrate;
			  $totalfxamount=$totalfxamount-$pharmacy_fxdiscamount;
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Pharmacy Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format(1,0); ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharmacy_discamount,2); ?></div>
			   <input type="hidden" name="pharmacy_discamount[]" id="pharmacy_discamount[]" value="<?php echo $pharmacy_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_discamount,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharmacy_fxdiscamount,2); ?></div>
			  <input type="hidden" name="pharmacy_fxdiscamount[]" id="pharmacy_fxdiscamount[]" value="<?php echo $pharmacy_fxdiscamount; ?>"></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_fxdiscamount,2); ?></div></td>
			  </tr>
			  <?php
			  }
			  }
			  ?>
              <!--copay-->
               <?php 
			   //$totalpharm=0;
			  $query23 = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$pharno = mysqli_num_rows($exec23);
			while($res23 = mysqli_fetch_array($exec23))
			{
				$phaquantity=0;
			$phaamount=0;
			$totalrefquantity=0;
			$reftotalamount=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			$phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];


$serviceitemcode199b=array();
		$query199b = mysqli_query($GLOBALS["___mysqli_ston"], "select a.auto_number,b.itemcode as itemcode from consultation_services as a JOIN master_services as b ON a.servicesitemcode=b.itemcode where a.patientvisitcode = '$visitcode' and b.pkg='Yes'");
/*  		$query199b = mysql_query("select a.auto_number,b.itemcode as itemcode from consultation_services as a JOIN master_services as b ON a.servicesitemcode=b.itemcode where b.pkg='Yes' limit 0,50");
	*/
		$count199b = mysqli_num_rows($query199b);
		if($count199b>0){
  	    while($fetch199b = mysqli_fetch_array($query199b)){			
			array_push($serviceitemcode199b,$fetch199b['itemcode']);
			//$serviceitemcode199b=$fetch199b['itemcode'];
		}
		}
		
 $serviceitemcode=implode("','",$serviceitemcode199b);


 	$query199a = mysqli_query($GLOBALS["___mysqli_ston"], "select auto_number from master_serviceslinking where servicecode IN('$serviceitemcode') and itemcode = '$phaitemcode' and recordstatus<>'deleted'");
		$count199a = mysqli_num_rows($query199a);
		if($count199a>0){
			$pharno-=1; 			
			continue;
		}
			//$pharno1=0;
			
				 $queryphar = "select auto_number from billing_paynowpharmacy where medicinecode='".$phaitemcode."' and patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$execphar = mysqli_query($GLOBALS["___mysqli_ston"], $queryphar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$pharno1 = mysqli_num_rows($execphar);
				if($pharno1>0){

if($planforall!='yes' && $pharno1>0){
	continue;
}
			
			$query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		    while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query47 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res47 = mysqli_fetch_array($exec47))
			{
			$refquantity = $res47['quantity'];
			$refamount = $res47['totalamount'];
			$totalrefquantity =  $totalrefquantity + $refquantity;
			$reftotalamount = $reftotalamount + $refamount;
			}
			
				 $query28 = "select sum(quantity) as quantity from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode' and approvalstatus = '2'";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1sd".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res28 = mysqli_fetch_array($exec28)){		
				$totalrefquantity+=$res28['quantity'];
							
			}
			
			$realquantity = $phaquantity - $totalrefquantity;

			if($realquantity<=0){
				continue;
			}
			$phaamount = $phaamount - $reftotalamount;
			$pharfxrate=$pharate;
//			$pharfxamount=$phaamount;
			
						$pharfxamount=$pharate*$realquantity;

			$pharate=number_format($pharate/$fxrate,2,'.','');
			$phaamount=number_format($pharate*$realquantity,2,'.','');
			$phaamount=number_format($phaamount,2,'.','');
			 $query28 = "select * from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode'";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1as".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res28 = mysqli_fetch_array($exec28);
			$pharefno=$res28['refno'];
			$excludestatus=$res28['excludestatus'];
			$approvalstatus = $res28['approvalstatus'];
			
			
			if($excludestatus == '')
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
			//$totalpharm=$totalpharm+$phaamount;
			?>
            <?php 
			$copayfxamount=(($pharate*$realquantity)/100)*$planpercentage;
				
			 $copay=(($pharate)/100)*$planpercentage;
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			   $totalpharm=$totalpharm+$phaamount;
				$totalcopaypharm=$totalcopaypharm+$copay*$realquantity;
				 $totalfxpharm=$totalfxpharm+$pharfxamount;
				$totalfxcopaypharm=$totalfxcopaypharm+$copayfxamount;
				$totalfxcopay=$totalfxcopay+$copayfxamount;

				$totalfxamount=$totalfxamount+$pharfxamount;
				
			   }
			   else
			  {$totalpharm=$totalpharm+$phaamount;$totalfxamount=$totalfxamount+$pharfxamount;$totalfxpharm=$totalfxpharm+$pharfxamount;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $realquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $pharate-$copay; } else { echo $pharate;} ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo ($pharate-$copay)*$realquantity; } else { echo $pharate*$realquantity;} ?>">
             <input name="pharfxrate[]" id="pharfxrate" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo ($pharate-$copay)*$fxrate; } else { echo $pharate*$fxrate;} ?>">
             <input name="pharfxamount[]" id="pharfxamount" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo ($pharate-$copay)*$realquantity*$fxrate; } else { echo $pharate*$realquantity*$fxrate;} ?>"></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $realquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount,2); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharfxrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharfxamount,2); ?></div></td>
			
             </tr>
             <?php if(($planpercentage!=0.00)&&($planforall=='yes')){
				 			 $pharfxrate=number_format($copay*$fxrate,5,'.','');
				 			 $pharfxamount=number_format($pharfxrate*$realquantity,5,'.','');
							 $copay*$realquantity;
							 $totalcopay=$totalcopay+($copay*$realquantity);
							 	$totalfxamount-=$pharfxamount;
								$totalfxpharm-=$pharfxamount;
			 ?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $realquantity; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay*$realquantity,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharfxrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharfxamount,2); ?></div></td>
			
			  </tr>
				<?php }?>
			  
			  <?php }
			  }}
			  ?>
			  <?php
			  if($pharmacy_discamount > 0 && $pharno > 0)
			  {
			  $pharmacy_fxdiscamount = $pharmacy_discamount * $fxrate;
			  $totalfxamount=$totalfxamount-$pharmacy_fxdiscamount;
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Pharmacy Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format(1,0); ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_discamount,2); ?></div>
			   <input type="hidden" name="pharmacy_discamount[]" id="pharmacy_discamount[]" value="<?php echo $pharmacy_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_discamount,2); ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_fxdiscamount,2); ?></div>
				<input type="hidden" name="pharmacy_fxdiscamount[]" id="pharmacy_fxdiscamount[]" value="<?php echo $pharmacy_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_fxdiscamount,2); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
                <?php 
				if($pharno>0){
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
			$desprate=0;
			$despratetotal=0;
			$totalcopaydesp=0;
			 
			 if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $desprate=($desprate/100)*$planpercentage;
				$totalcopaydesp=$desprate;
			   }
			  ?>
			 <tr <?php echo $colorcode; ?>>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo "DISPENSING"; ?></div></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo "DISPENSING"; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo "1"; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php   echo $desprate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $desprate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($despratetotal,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($despratetotal,2); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($despratetotal,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($despratetotal,2); ?></div></td>
			 
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $copay=$desprate; $totalcopay=$totalcopay+$copay;
			   $totalfxamount-=$copay;
			    $totalfxpharm-=$copay;
			   ?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			
			  </tr>
				
			  
			  <?php }}
			  ?>
			    <?php 


			 $fxrate = $original_fxrate;

				$totalrad=0;
				$totalcopayrad='';
				$radfxrate=0;
				$totalfxrad=0;
				$totalfxcopayrad=0;
				$radfxcopay=0;
			  $query20 = "select * from consultation_radiology where radiologyitemcode NOT IN (SELECT radiologyitemcode FROM billing_paynowradiology WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and radiologyrefund <> 'completed' and  paymentstatus = 'completed' and approvalstatus <> '2' and approvalstatus = '1'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$row20 = mysqli_num_rows($exec20);
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radcode=$res20['radiologyitemcode'];
			
			$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$resfx = mysqli_fetch_array($execfx);
			$radrate=$resfx['rateperunit'];
				
			//$radrate=$res20['radiologyitemrate'];
			$radref=$res20['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$radrate = number_format($radrate,2,'.','');
			$copay=($radrate/100)*$planpercentage;
			$radfxrate=($radrate*$fxrate);
			$radfxcopay=$copay*$fxrate;
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
			
			//$totalrad=$totalrad+$radrate;
			?>
            <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalrad=$totalrad+$radrate; 
				$totalcopayrad=$totalcopayrad+$copay;
				$totalfxcopay=$totalfxcopay+$radfxcopay;
				$totalfxamount=$totalfxamount+$radfxrate;				
				$totalfxrad=$totalfxrad+$radfxrate;
				$totalfxcopayrad=$totalfxcopayrad+$radfxcopay; 
			   }
			   else
			  {$totalrad=$totalrad+$radrate;$totalfxamount=$totalfxamount+$radfxrate;$totalfxrad=$totalfxrad+$radfxrate;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>
			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="radcode[]" id="radcode" type="hidden" value="<?php echo $radcode; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $radrate-$copay; } else { echo $radrate;}?>">
             <input name="radfxrate[]" type="hidden" id="radfxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $radfxrate-$radfxcopay; } else { echo $radfxrate;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radfxrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radfxrate,2,'.',','); ?></div></td>
			 
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;
			  							 	$totalfxamount-=$radfxcopay;
											  $totalfxrad-=$radfxcopay;
 	
			  ?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radfxcopay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radfxcopay,2); ?></div></td>
			  
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
			  <?php
			  if($radiology_discamount > 0 && $row20 > 0)
			  {
			  $radiology_fxdiscamount = $radiology_discamount * $fxrate;
			  $totalfxamount=$totalfxamount-$radiology_fxdiscamount;
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Radiology Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format(1,0); ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_discamount,2); ?></div>
			   <input type="hidden" name="radiology_discamount[]" id="radiology_discamount[]" value="<?php echo $radiology_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_discamount,2); ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_fxdiscamount,2); ?></div>
				<input type="hidden" name="radiology_fxdiscamount[]" id="radiology_fxdiscamount[]" value="<?php echo $radiology_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_fxdiscamount,2); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
              <!--copay-->
                <?php 
				//$totalrad=0;
				//$totalcopayrad='';
			  $query20 = "select * from consultation_radiology where radiologyitemcode  IN (SELECT radiologyitemcode FROM billing_paynowradiology WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and radiologyrefund <> 'completed' and  paymentstatus = 'completed' and approvalstatus <> '2' and approvalstatus = '1'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$row20 = mysqli_num_rows($exec20);
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radcode=$res20['radiologyitemcode'];
			
			$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$resfx = mysqli_fetch_array($execfx);
			$radrate=$resfx['rateperunit'];
			
			//$radrate=$res20['radiologyitemrate'];
			$radref=$res20['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$copay=($radrate/100)*$planpercentage;
			$radfxrate=($radrate*$fxrate);
			$radfxcopay=$copay*$fxrate;
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
			
			//$totalrad=$totalrad+$radrate;
			?>
            <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalrad=$totalrad+$radrate; 
				$totalcopayrad=$totalcopayrad+$copay;
				$totalfxcopay=$totalfxcopay+$radfxcopay;
				$totalfxamount=$totalfxamount+$radfxrate;				
				$totalfxrad=$totalfxrad+$radfxrate;
				$totalfxcopayrad=$totalfxcopayrad+$radfxcopay; 
			   }
			   else
			  {$totalrad=$totalrad+$radrate;$totalfxamount=$totalfxamount+$radfxrate;$totalfxrad=$totalfxrad+$radfxrate;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>
			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="radcode[]" id="radcode" type="hidden" value="<?php echo $radcode; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $radrate-$copay; } else { echo $radrate;}?>">
             <input name="radfxrate[]" type="hidden" id="radfxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $radfxrate-$radfxcopay; } else { echo $radfxrate;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radfxrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radfxrate,2); ?></div></td>
			 
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;
			  	$totalfxamount-=$radfxcopay;
				  $totalfxrad-=$radfxcopay;
				
			  ?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radfxcopay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radfxcopay,2); ?></div></td>
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
			   <?php
			  if($radiology_discamount > 0 && $row20 > 0)
			  {
			  $radiology_fxdiscamount = $radiology_discamount * $fxrate;
			  $totalfxamount=$totalfxamount-$radiology_fxdiscamount;
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Radiology Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format(1,0); ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_discamount,2); ?></div>
			   <input type="hidden" name="radiology_discamount[]" id="radiology_discamount[]" value="<?php echo $radiology_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_discamount,2); ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_fxdiscamount,2); ?></div>
				<input type="hidden" name="radiology_fxdiscamount[]" id="radiology_fxdiscamount[]" value="<?php echo $radiology_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_fxdiscamount,2); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
			  	    <?php 
					
					$totalser=0;
					$serfxrate=0;
					$serfxcopay=0;
					$totalfxser=0;
					$totalfxcopayser=0;
					$serfxcopayqty=0;
					$serfxrateqty=0;
			  $query21 = "select * from consultation_services where servicesitemcode NOT IN (SELECT servicesitemcode FROM billing_paynowservices WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''   and  paymentstatus = 'completed' and wellnessitem <> '1' and approvalstatus <> '2' and approvalstatus = '1' group by servicesitemcode ";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$row21 = mysqli_num_rows($exec21);
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			//$serrate=$res21['servicesitemrate'];
			$sercode=$res21['servicesitemcode'];
			$wellnessitem=$res21['wellnessitem'];
			$wellnesspkg=$res21['wellnesspkg'];

			$queryfx = "select rateperunit from $sertemplate where itemcode = '$sercode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$resfx = mysqli_fetch_array($execfx);
			$serrate=$resfx['rateperunit'];
			
			$serref=$res21['refno'];
			
			$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' ";//and approvalstatus <> '2' and approvalstatus = '1'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$numrow2111 = mysqli_num_rows($exec2111);
			$resqty = mysqli_fetch_array($exec2111);
			$serqty=$resqty['serviceqty'];
			$serrefqty=$resqty['refundquantity'];
			
			$serqty = $serqty-$serrefqty;
			$totserrate=$resqty['amount'];
		    //$perrate=$resqty['servicesitemrate'];
			$perrate = $serrate;
			//$totserrate=$serrate*$serqty;
			//echo $serrate;
			$serrate = number_format($serrate,2,'.','');
			$perrate = number_format($perrate,2,'.','');
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$copay=(($serrate*$serqty)/100)*$planpercentage;
			$copaysingle=($serrate/100)*$planpercentage;
		 	$copayperservice=$copay/$serqty;
			$totamt=$perrate*$serqty;
			$serfxrate=($perrate*$fxrate);
			$serfxcopay=$copaysingle*$fxrate;
			$serfxcopayqty=$serfxcopay*$serqty;
			$serfxrateqty = $serfxrate*$serqty;
			$totserrate=$totamt;
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
			//$totalser=$totalser+$totserrate;
			?>
             <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			   
				$serratetot=$serrate;
				//$totalser=$totalser+$serratetot; 
				$totserrate = $totamt-$copay;
				$totalser=$totalser+$totamt;
				
				$totalcopayser=$totalcopayser+$copay;
				$totalfxcopay=$totalfxcopay+$serfxcopayqty;
				$totalfxamount=$totalfxamount+$serfxrateqty;
				$totalfxser=$totalfxser+$serfxrateqty;
				$totalfxcopayser=$totalfxcopayser+$serfxcopayqty;
			   }
			   else if(($planpercentage!=0.00)&&($planforall==''))
			  { 
			    $serratetot=$serrate;
				//$totamt=$perrate*$numrow2111;
			    $totalser=$totalser+$totamt; 
				//$totalcopayser=$totalcopayser+$copay;
				
				$totalfxcopay=$totalfxcopay+$serfxcopayqty;
				$totalfxamount=$totalfxamount+$serfxrateqty;
				$totalfxser=$totalfxser+$serfxrateqty;
				$totalfxcopayser=$totalfxcopayser+$serfxcopayqty;
			   }
			   
			   else
			  {
				   	$serratetot=$serrate;
				  	$totalser=$totalser+$totamt;
				  	$totalfxamount=$totalfxamount+$serfxrateqty;
					$totalfxser=$totalfxser+$serfxrateqty;
			  }
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 			              <input name="wellnesspkg[]" type="hidden" id="wellnesspkg" readonly size="8" value="<?php echo $wellnesspkg; ?>">

			 			 <input name="servicesitemcode[]" type="hidden" id="servicesitemcode" size="69" value="<?php echo $sercode; ?>">

			 <input name="sercode[]" type="hidden" id="sercode" size="69" value="<?php echo $sercode; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serratetot-$copaysingle; } else { echo $serratetot;}?>">
             <input name="serfxrate[]" type="hidden" id="serfxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serfxrate; } else { echo $serfxrate;}?>">
             <input name="serfxrateqty[]" type="hidden" id="serfxrateqty" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serfxrateqty-$serfxcopayqty; } else { echo $serfxrateqty;}?>">
			  <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $serqty; ?>">
              <input name="totalservice3[]" type="hidden" id="totalservice3" readonly size="8" value="<?php echo $totserrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totamt,2,'.',','); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serfxrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serfxrateqty,2,'.',','); ?></div></td>
			 
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;  $copayperser=$copay/$serqty;
			  	$totalfxamount-=$serfxcopayqty;
			    $totalfxser-=$serfxcopayqty;
			  ?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayperser,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serfxcopay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($serfxcopayqty,2); ?></div></td>
			 
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
			   <?php
			  if($services_discamount > 0 && $row21 > 0)
			  {
			  $services_fxdiscamount = $services_discamount * $fxrate;
			  $totalfxamount=$totalfxamount-$services_fxdiscamount;
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Services Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format(1,0); ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_discamount,2); ?></div>
			   <input type="hidden" name="services_discamount[]" id="services_discamount[]" value="<?php echo $services_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_discamount,2); ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_fxdiscamount,2); ?></div>
				<input type="hidden" name="services_fxdiscamount[]" id="services_fxdiscamount[]" value="<?php echo $services_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_fxdiscamount,2); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
              <!--copay-->
              <?php 
					
					//$totalser=0;
			  $query21 = "select * from consultation_services where servicesitemcode  IN (SELECT servicesitemcode FROM billing_paynowservices WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''   and  paymentstatus = 'completed' and approvalstatus <> '2' and approvalstatus = '1' group by servicesitemcode ";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$row21 = mysqli_num_rows($exec21);
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$sercode=$res21['servicesitemcode'];
			$serref=$res21['refno'];
			
			$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' ";//and approvalstatus <> '2' and approvalstatus = '1'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$numrow2111 = mysqli_num_rows($exec2111);
			$resqty = mysqli_fetch_array($exec2111);
			$serqty=$resqty['serviceqty'];
			$serrefqty=$resqty['refundquantity'];
			
			$serqty = $serqty-$serrefqty;
			$totserrate=$resqty['amount'];
		    $perrate=$resqty['servicesitemrate'];
			//$totserrate=$serrate*$serqty;
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$copay=(($serrate*$serqty)/100)*$planpercentage;
			$copaysingle=($serrate/100)*$planpercentage;
		 	$copayperservice=$copay/$serqty;
			$totamt=$perrate*$serqty;
			$serfxrate=($perrate*$fxrate);
			$serfxcopay=$copaysingle*$fxrate;
			$serfxcopayqty=$serfxcopay*$serqty;
			$serfxrateqty = $serfxrate*$serqty;
			$totserrate=$totamt;
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
			//$totalser=$totalser+$totserrate;
			?>
             <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			   
				$serratetot=$serrate;
				//$totalser=$totalser+$serratetot; 
				$totserrate = $totamt-$copay;
				$totalser=$totalser+$totamt;
				
				$totalcopayser=$totalcopayser+$copay;
				$totalfxcopay=$totalfxcopay+$serfxcopayqty;
				$totalfxamount=$totalfxamount+$serfxrateqty;
				$totalfxser=$totalfxser+$serfxrateqty;
				$totalfxcopayser=$totalfxcopayser+$serfxcopayqty;
			   }
			   else if(($planpercentage!=0.00)&&($planforall==''))
			  { 
			    $serratetot=$serrate;
				//$totamt=$perrate*$numrow2111;
			    $totalser=$totalser+$totamt; 
				//$totalcopayser=$totalcopayser+$copay;
				$totalfxcopay=$totalfxcopay+$serfxcopayqty;
				$totalfxamount=$totalfxamount+$serfxrateqty;
				$totalfxser=$totalfxser+$serfxrateqty;
				$totalfxcopayser=$totalfxcopayser+$serfxcopayqty;
			   }
			   
			   else
			  {
				   $serratetot=$serrate;
				  	$totalser=$totalser+$totamt;
				  	$totalfxamount=$totalfxamount+$serfxrateqty;
					$totalfxser=$totalfxser+$serfxrateqty;
				}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="sercode[]" type="hidden" id="sercode" size="69" value="<?php echo $sercode; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serratetot-$copaysingle; } else { echo $serratetot;}?>">
			  <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $serqty; ?>">
              <input name="totalservice3[]" type="hidden" id="totalservice3" readonly size="8" value="<?php echo $totserrate; ?>">
              <input name="serfxrate[]" type="hidden" id="serfxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serfxrate; } else { echo $serfxrate;}?>">
             <input name="serfxrateqty[]" type="hidden" id="serfxrateqty" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serfxrateqty-$serfxcopayqty; } else { echo $serfxrateqty;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totamt,2,'.',','); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serfxrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serfxrateqty,2,'.',','); ?></div></td>
			 
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;  $copayperser=$copay/$serqty;
			  $totalfxamount-=$serfxcopayqty;
			  			  $totalfxser-=$serfxcopayqty;
	
			  ?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayperser,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serfxcopay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($serfxcopayqty,2); ?></div></td>
			  
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
			   <?php
			  if($services_discamount > 0 && $row21 > 0)
			  {
			  $services_fxdiscamount = $services_discamount * $fxrate;
			  $totalfxamount=$totalfxamount-$services_fxdiscamount;
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Services Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format(1,0); ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_discamount,2); ?></div>
			   <input type="hidden" name="services_discamount[]" id="services_discamount[]" value="<?php echo $services_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_discamount,2); ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_fxdiscamount,2); ?></div>
				<input type="hidden" name="services_fxdiscamount[]" id="services_fxdiscamount[]" value="<?php echo $services_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_fxdiscamount,2); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
			   <?php 
			   $totalref=0;
			   $totalfxref=0;
			   $totalfxrefcopay=0;
			  $query22 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res22 = mysqli_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['referalname'];
			$refrate=$res22['referalrate'];
			$refref=$res22['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$reffxrate=$refrate;
			$refrate=number_format($reffxrate,2,'.','');
			$copay=($refrate/100)*$planpercentage;
			$refcopayfxrate=($reffxrate/100)*$planpercentage;
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
			//$totalref=$totalref+$refrate;
			?>
             <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalref=$totalref+$refrate; 
				$totalcopayref=$totalcopayref+$copay;
				$totalfxref=$totalfxref+$reffxrate; 
				$totalfxrefcopay=$totalfxrefcopay+$refcopayfxrate;
				$totalfxcopay=$totalfxcopay+$refcopayfxrate;
				$totalfxamount=$totalfxamount+$reffxrate;
			   }
			   else
			  {$totalref=$totalref+$refrate;$totalfxref=$totalfxref+$reffxrate;$totalfxamount=$totalfxamount+$reffxrate; }
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			 <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="rateref[]" type="hidden" id="rateref" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  
			 echo $refrate-$copay; } else { echo $refrate;}  ?>">
              <input name="raterefamt[]" type="hidden" id="raterefamt" readonly size="8" value="<?php echo $refrate;  ?>">
              <input name="reffxrate[]" type="hidden" id="reffxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  
			 echo $reffxrate; } else { echo $reffxrate;}  ?>">
              
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate,2); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxrate,2); ?></div></td>
			 
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;
			  $totalfxamount-=$copay;
			  $totalfxref-=$copay;
			  ?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
              
              
              
            <?php /*?>  <!--copay-->
               <?php 
			   $totalref=0;
			  $query22 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec22 = mysql_query($query22) or die ("Error in Query1".mysql_error().__LINE__);
			while($res22 = mysql_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['referalname'];
			$refrate=$res22['referalrate'];
			$refref=$res22['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$copay=($refrate/100)*$planpercentage;
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
			//$totalref=$totalref+$refrate;
			?>
             <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalref=$totalref+$refrate; 
				$totalcopayref=$totalcopayref+$copay;
			   }
			   else
			  {$totalref=$totalref+$refrate;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			 <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="rateref[]" type="hidden" id="rateref" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  
			 echo $refrate-$copay; } else { echo $refrate;}  ?>">
              <input name="raterefamt[]" type="hidden" id="raterefamt" readonly size="8" value="<?php echo $refrate;  ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?><?php */?>
              
              
              
              
              
              
              
              
              
              
              
              
               <?php 
			   $totalamb=0;
			    $snohome='0';
				$totalfxambcopay=0;
				$totalfxamb=0;
			  $query22 = "select * from op_ambulance where patientvisitcode='$visitcode' and billtype = 'PAY LATER' and patientcode='$patientcode' and paymentstatus='completed'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$ambcount=mysqli_num_rows($exec22);
			while($res22 = mysqli_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['description'];
			$refrate=$res22['rate'];
			$refamount=$res22['amount'];
			$refref=$res22['docno'];
			$qty=$res22['units'];
			$reffxrate=$refrate;
			$reffxamount=$refamount;
			$refrate=number_format($reffxrate,2,'.','');
			$refamount=number_format($refrate*$qty,2,'.','');
			$accountname=$res22['accountname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$copay=(($refrate*$qty)/100)*$planpercentage;
			$refcopayfxrate=($reffxrate/100)*$planpercentage;
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
			//$totalamb=$totalamb+$refamount;
			//$totalambulance=$totalamb;
			?>
            <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalamb=$totalamb+$refamount;
				$totalcopayamb=$totalcopayamb+$copay;
				$totalambulance=$totalamb;
				$totalfxamb=$totalfxamb+$reffxamount; 
				$totalfxambcopay=$totalfxambcopay+$refcopayfxrate;
				$totalfxcopay=$totalfxcopay+$refcopayfxrate;
				$totalfxamount=$totalfxamount+$reffxamount;
			   }
			   else
			  {
			  $totalamb=$totalamb+$refamount;
			  $totalambulance=$totalamb;
			  $totalfxamb=$totalfxamb+$reffxamount; 
				$totalfxamount=$totalfxamount+$reffxamount;
			  }
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno1 = $sno1 + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			 <?php /*?> <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="rate4[]" type="hidden" id="rate4" readonly size="8" value="<?php echo $refrate; ?>"><?php */?>
             <input type="hidden" name="ambulancecount[]" value="<?php echo $snohome;?>">
              <input name="accountname[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
               <input name="description[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
                <input name="quantityamb[]" type="hidden" id="quantity" readonly size="8" value="<?php echo $qty; ?>">
                 <input name="rateamb[]" type="hidden" id="rateamb" readonly size="8" value="<?php echo $refrate; ?>">
                  <input name="amountamb[]" type="hidden" id="amountamb" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){   echo $refamount-$copay; } else { echo $refamount;}  ?>">
                   <input name="actualamount[]" type="hidden" id="actualamount" readonly size="8" value="<?php echo $refamount; ?>">
                   <input name="amdocno[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>">
                   <input name="ambfxrate[]" type="hidden" id="ambfxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $reffxrate; } else { echo $reffxrate;}  ?>">
                   <input name="ambfxamount[]" type="hidden" id="ambfxamount" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $reffxamount; } else { echo $reffxamount;}  ?>">
			<?php $snohome=$snohome+1;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refamount,2); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxamount,2,'.',','); ?></div></td>
			 
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;
			  $totalfxamount-=$copay;
			  $totalfxamb-=$copay;
			  ?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay/$qty,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?><input type="hidden" name="ambcount" value="<?php echo $ambcount;?>">
               <?php 
			   $totalhom=0;
			   $snohome='0';
			   $totalfxhome=0;
			   $totalfxhomecopay=0;
			  $query22 = "select * from homecare where patientvisitcode='$visitcode' and billtype = 'PAY LATER' and patientcode='$patientcode' and paymentstatus='completed'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$ambcount1=mysqli_num_rows($exec22);
			while($res22 = mysqli_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['description'];
			$refrate=$res22['rate'];
			$refamount=$res22['amount'];
			$refref=$res22['docno'];
			$qty=$res22['units'];
			$reffxrate=$refrate;
			$reffxamount=$refamount;
			$refrate=number_format($refrate,2,'.','');
			$refamount=number_format($refrate*$qty,2,'.','');
			$accountname=$res22['accountname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$copay=(($refrate*$qty)/100)*$planpercentage;
			$refcopayfxrate=($reffxrate/100)*$planpercentage;
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
            <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalhom=$totalhom+$refamount;
				$totalcopayhom=$totalcopayhom+$copay;
				$totalhomecare=$totalhom;
				$totalfxhome=$totalfxhome+$reffxamount; 
				$totalfxhomecopay=$totalfxhomecopay+$refcopayfxrate;
				$totalfxcopay=$totalfxcopay+$refcopayfxrate;
				$totalfxamount=$totalfxamount+$reffxamount;
			   }
			   else
			  {
				  $totalhom=$totalhom+$refamount;
				$totalhomecare=$totalhom;
				$totalfxhome=$totalfxhome+$reffxamount; 
				$totalfxcopay=$totalfxcopay+$refcopayfxrate;
				$totalfxamount=$totalfxamount+$reffxamount;
				 // $totalamb=$totalamb+$refamount;
				  }
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno2 = $sno2 + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			<?php /*?>  <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="rate4[]" type="hidden" id="rate4" readonly size="8" value="<?php echo $refrate; ?>"><?php */?>
             <input type="hidden" name="ambulancecounthom[]" value="<?php echo $snohome;?>">
             <?php /*?> <input name="accountname2[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
               <input name="description2[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
                <input name="quantity2[]" type="hidden" id="quantity" readonly size="8" value="<?php echo $qty; ?>">
                 <input name="rate2[]" type="hidden" id="rate" readonly size="8" value="<?php echo $refrate; ?>">
                  <input name="amount2[]" type="hidden" id="amount" readonly size="8" value="<?php echo $refamount; ?>">
                   <input name="amdocno2[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>"><?php */?>
               <input name="accountnamehom[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
               <input name="descriptionhom[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
                <input name="quantityhom[]" type="hidden" id="quantityhom" readonly size="8" value="<?php echo $qty; ?>">
                 <input name="ratehom[]" type="hidden" id="ratehom" readonly size="8" value="<?php echo $refrate; ?>">
                  <input name="amounthom[]" type="hidden" id="amounthom" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $refamount-$copay; } else { echo $refamount;} ?>">
                   <input name="actualamounthom[]" type="hidden" id="actualamounthom" readonly size="8" value="<?php echo $refamount; ?>">
                   <input name="amdocnohom[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>">
                   <input name="homefxrate[]" type="hidden" id="homefxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $reffxrate; } else { echo $reffxrate;}  ?>">
                   <input name="homefxamount[]" type="hidden" id="homefxamount" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $reffxamount; } else { echo $reffxamount;}  ?>">
			<?php $snohome=$snohome+1;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refamount,2); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxamount,2,'.',','); ?></div></td>
			 
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;
			   $totalfxamount-=$copay;
			   $totalfxhome-=$copay;
			  ?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay/$qty,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
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
			$reffxrate=$departmentrefrate;
			$reffxamount=$departmentrefrate;
			$refrate=number_format($refamount/$fxrate,2,'.','');
			$refamount=number_format($refrate*1,2,'.','');
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
			$totalfxamount=$totalfxamount+$reffxamount;
			$totaldepartmentref=$totaldepartmentref+$departmentrefrate;
			$totalfxref=$totalfxref+$reffxamount; 
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $departmentrefdate; ?></div></td>
			  <input type="hidden" name="departmentreferalname" value="<?php echo $departmentrefname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $departmentrefref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left">Referral Fee - <?php echo $departmentrefname; ?></div></td>
			  <input name="departmentreferal[]" type="hidden" id="departmentreferal" size="69" value="<?php echo $departmentrefname; ?>">
			 <input name="departmentreferalrate4[]" type="hidden" id="departmentreferalrate4" readonly size="8" value="<?php echo $departmentrefrate; ?>">
			<input name="deptfxrate[]" type="hidden" id="deptfxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $reffxrate; } else { echo $reffxrate;}  ?>">
             <input name="deptfxamount[]" type="hidden" id="deptfxamount" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $reffxamount; } else { echo $reffxamount;}  ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($departmentrefrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($departmentrefrate,2); ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxrate,2); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxamount,2); ?></div></td>
			 
             
			  
			  <?php }
			  ?>

			  <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes')){ 
			
				  $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhomecare+$totaldepartmentref+$despratetotal)-$totalcopay-$totalcopayfixedamount+$consultationrefund;
			  $overalltotal = $overalltotal - ($consult_discamount+$pharmacy_discamount+$lab_discamount+$radiology_discamount+$services_discamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			   $consultationtotal=$totalop-$totalcopayconsult+$consultationrefund-$totalcopayfixedamount;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $overalltotal;
			   $netpay=number_format($netpay,2,'.','');
			  }
			 else if(($planpercentage!=0.00)&&($planforall=='')){
			 
			 // echo $totalser;
				   $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhomecare+$totaldepartmentref+$despratetotal)-$totalcopay-$totalcopayfixedamount+$consultationrefund;
			  $overalltotal = $overalltotal - ($consult_discamount+$pharmacy_discamount+$lab_discamount+$radiology_discamount+$services_discamount);
			   $consultationtotal=$totalop-$totalcopayconsult+$consultationrefund-$totalcopayfixedamount;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $overalltotal;
			   $netpay=number_format($netpay,2,'.','');
			  }
			  else{
			  
				  $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhomecare+$totaldepartmentref+$despratetotal)-$totalcopay+$consultationrefund-$totalcopayfixedamount;
			  $overalltotal = $overalltotal - ($consult_discamount+$pharmacy_discamount+$lab_discamount+$radiology_discamount+$services_discamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			  //echo $totalcopay;
			  $consultationtotal=$totalop-$totalcopayconsult+$consultationrefund-$totalcopayfixedamount;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totaldepartmentref+$totalambulance+$totalhomecare+$despratetotal;
			   $netpay= $overalltotal;
			   $netpay=number_format($netpay,2,'.','');
			  }
			  ?>
			  
			  <?php
			  }   //for checking whether patient finalized
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
                bgcolor="#ecf0f5"><strong><?php echo number_format($overalltotal,2,'.',''); ?>
	            <input name="overalltotal" type="hidden" id="overalltotal" readonly size="8" value="<?php  echo $overalltotal; ?>" />
				</strong></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totalfxamount,2,'.','');?></strong></td>
				
             
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
		    <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
              <td width="21%" class="bodytext31" valign="center" align="left" 
                bgcolor="#CBDBFA"><div align="left">Total for Consultation</div></td>
				<td width="25%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($consultationtotal-$consult_discamount,2,'.',''); ?></div>
				<input type="hidden" name="consultation" value="<?php echo $consultationtotal-$consult_discamount; ?>"></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#CBDBFA"><div align="right"><?php echo number_format($consfxrate-$consult_fxdiscamount,2,'.',''); ?></div></td>
			
			</tr>
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Pharmacy </div></td>
				<td width="25%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($totalpharm-$totalcopaypharm-$pharmacy_discamount,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><div align="right"><?php echo number_format($totalfxpharm-$pharmacy_fxdiscamount,2,'.',''); ?></div></td>
			
				</tr>
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
                <td width="21%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Laboratory</div></td>
				<td width="25%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($totallab-$totalcopaylab-$lab_discamount,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#CBDBFA"><div align="right"><?php echo number_format($totalfxlab-$lab_fxdiscamount,2,'.','');?></div></td>
			
				</tr>
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
					<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Radiology </div></td>
				<td width="25%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($totalrad-$totalcopayrad-$radiology_discamount,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><div align="right"><?php echo number_format($totalfxrad-$radiology_fxdiscamount,2,'.','');?></div></td>
			
				</tr>
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="21%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Service	</div></td>
				<td width="25%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($totalser-$totalcopayser-$services_discamount,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#CBDBFA"><div align="right"><?php echo number_format($totalfxser-$services_fxdiscamount,2,'.','');?></div></td>
			
				</tr>
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Referral		</div></td>
				<td width="25%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($totalref-$totalcopayref,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><div align="right"><?php echo number_format($totalfxref,2,'.','');?></div></td>
			
				</tr>
                <tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
                 bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="21%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Ambulance		</div></td>
				<td width="25%"  align="left" valign="center" 
                 bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($totalambulance-$totalcopayamb,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
                 bgcolor="#CBDBFA"><div align="right"><?php echo number_format($totalfxamb,2,'.','');?></div></td>
			
				</tr>
                <tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Homecare		</div></td>
				<td width="25%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($totalhomecare-$totalcopayhom,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><div align="right"><?php echo number_format($totalfxhome,2,'.','');?></div></td>
			
				</tr>
                
                
                 <tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Dispensing Fee		</div></td>
				<td width="25%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($despratetotal-$totalcopaydesp,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><div align="right"><strong>&nbsp;</strong></div></td>
			
				</tr>
                
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="center"><strong>&nbsp;</strong></div></td>
			
              <td width="21%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Net Payable	</strong></div></td>
				<td width="25%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><?php echo  $netpay; ?></strong></div></td>
				<input type="hidden" name="totalamount" id="totalamount" value="<?php echo  $netpay; ?>">
                <input type="hidden" name="totalfxamount" id="totalfxamount" value="<?php echo  $totalfxamount; ?>">
				<input type="hidden" id="smartbenefitno">
				<input type="hidden" id="admitid">
				  <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalfxamount,2,'.','');?></strong></div></td>
			
            </tr>
				  </tbody>
				  </table>				  </td>
				    <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="left"><strong>User Name</strong> <span class="bodytext3">
                 <?php echo $_SESSION['username']; ?>
                </span>&nbsp;&nbsp;&nbsp;&nbsp;<b><input type="text" name="availablelimite" id="availablelimit" value="<?php echo $availablelimit;?>" <?php  if($availablelimit < $netpay){?> style="background:#F00;color:#FFF" <?php }?> readonly ></td>
                <td height="32" colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				    </tr>
				  	


		<?php
		$copay_confirm=true;	
		 if($conscopayfxrate>0){
			$select_copay=mysqli_query($GLOBALS["___mysqli_ston"], "select auto_number from billing_consultation	where patientcode='$patientcode' and patientvisitcode='$visitcode'");
			if(mysqli_num_rows($select_copay)<=0){
						$copay_confirm=false;	
			}
		}
    			?>  
	        <tr>
         <?php if($copay_confirm && !($totalfxamount<0.00)){ 
		 ?>
		 <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		 
		 <select name="printbill">
                      <option value="detailed">Detailed</option>
                      <option value="summary">Summary</option>
                    </select>
					                  
		  <input type="hidden" name="frm1submit1" value="" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <?php if($admitid!=''){?>
				  <input name="fetch" type="button" value="FETCH" style="height:40px; width:100px; background-color:#FFCC00;" onClick="return funcCustomerSmartSearch()"/>
				  <?php }?>
                  
                   <?php if($smartap==1)
				   { 
				   if($availablelimit >= $netpay){?>
				   <input name="Submit222" id="smartfrm" type="button" onclick = "return loadprintpage4('smart')" value="Save and Post To Smart" class="button" disabled />
				  <?php }?>
                  
                    <?php if($availablelimit < $netpay){?>
				   <input name="seekapproval" type="button" onclick = "return loadprintpage4('seek')" value="Seek Approval" class="button"/>
				  <?php }}
				  if($smartap==0){
				  ?>
               <input name="Submit222" type="button" onclick = "return loadprintpage4('submit')" value="Save Bill" class="button"/>
               <?php }?>
               		 </td>
                     
    	<?php } else{ if(!$copay_confirm)
		{
		?>
        <td colspan="2"  class="bodytext31" valign="center"  align="right" style="color:red" >
        	Please collect the consultation copay amount
        </td>
        <?php }
		else{?>
        <td colspan="2"  class="bodytext31" valign="center"  align="right" style="color:red" >
        	Please Refund Aditional Fund or complete the services.
        </td>
        <?php
		}
		}?>
      </tr>	
    </table>

</form>
<script>

function loadprintpage4(btn)
{
	form1.method="POST";
	if(btn=='smart')
	{
	form1.frm1submit1.value="frm1submit1";
	}
	if(btn=='seek')
	{
	form1.frm1submit1.value="seekapproval";
	}
	if(btn=='submit')
	{
	form1.frm1submit1.value="frm1submit1";
	}
	form1.action="billing_paylater.php" 
	form1.submit();
	}
	
</script>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
