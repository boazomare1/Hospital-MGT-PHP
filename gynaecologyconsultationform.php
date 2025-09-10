<?php 
session_start();
set_time_limit(0);
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
error_reporting(0);
$curdate=date('Y-m-d');
$currenttime = date("H:i:s");
$updatedatetime = date ("d-m-Y H:i:s");
$errmsg = "";

$bgcolorcode = "";
$pagename = "";

$patientcode=$_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];

$companyanum = $_SESSION["companyanum"];
$ipaddress = $_SESSION['ipaddress'];
$username = $_SESSION["username"];
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$patientcode=$_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcodenum"];
	$timestamp = $_REQUEST['currenttime'];
	$query34="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
	$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34);
	$res34=mysqli_fetch_array($exec34);
	$billingtype=$res34['billtype'];
	$age=$res34['age'];
	if($billingtype =='PAY NOW')
	{
	$status='pending';
	}
	else
	{
	$status='completed';
	}
		$query21 = "select * from master_consultation order by auto_number desc limit 0, 1";
	 $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	 $rowcount21 = mysqli_num_rows($exec21);
	if ($rowcount21 == 0)
	{
		$consultationcode = 'CON001';
	}
	else
	{
		$res21 = mysqli_fetch_array($exec21);
		 $consultationcode = $res21['consultation_id'];
		 $consultationcode = substr($consultationcode, 3, 7);
		$consultationcode= intval($consultationcode);
		$consultationcode = $consultationcode + 1;
	
		
		
		
		if (strlen($consultationcode) == 2)
		{
			$consultationcode= '0'.$consultationcode;
		}
		if (strlen($consultationcode) == 1)
		{
			$consultationcode= '00'.$consultationcode;
		}
		$consultationcode = 'CON'.$consultationcode;
		}
	

	$consultationid=$consultationcode;
	
	$queryy=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where visitcode='$visitcode'");
	$res6=mysqli_fetch_array($queryy);
	$patientvisit=$res6['auto_number'];
	
	$patientfirstname = $_REQUEST["patientfirstname"];
	$patientfirstname = strtoupper($patientfirstname);
	$patientmiddlename = $_REQUEST['patientmiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);
	$patientlastname = $_REQUEST["patientlastname"];
	$patientlastname = strtoupper($patientlastname);
	$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
	$patientauto_number=$_REQUEST['patientauto_number'];
	$consultingdoctor = $_REQUEST["consultingdoctor"];
	$consultationtype = $_REQUEST["consultationtype"];
	$department = $_REQUEST["department"];
	 $billtype=$_REQUEST['visittype'];
	 $accountname=$_REQUEST['accountname'];
	 $paymenttype = $_REQUEST['paymenttype'];
	$currentdate=$_REQUEST['date'];
	$times=$_REQUEST['times'];
	$consultationtime  = $_REQUEST["consultationtime"];
	$consultationfees  = $_REQUEST["consultationfees"];
	$referredby = $_REQUEST["referredby"];
	$consultationremarks = $_REQUEST["consultationremarks"];
	$complaint = $_REQUEST["complanits"];
	$complaint = addslashes($complaint);
	$registrationdate = $_REQUEST["registrationdate"];
	$nursename = $_REQUEST["nursename"];
	$pulse = $_REQUEST["pulse"];
	$height = $_REQUEST["height"];
	$weight = $_REQUEST["weight"];
	$bmi = $_REQUEST["bmi"];
	$respiration = $_REQUEST["respiration"];
	$headcircumference = $_REQUEST["headcircumference"];
	$bsa = $_REQUEST["bsa"];
	$fahrenheit = $_REQUEST["fahrenheit"];
	$celsius = $_REQUEST["celsius"];
	$bpsystolic = $_REQUEST["bpsystolic"];
	$bpdiastolic = $_REQUEST["bpdiastolic"];
	$drugallergy = $_REQUEST["drugallergy"];
	$complanits = $_REQUEST["complanits"];
	$foodallergy = $_REQUEST["foodallergy"];	
	$consultation = $_REQUEST["consultation"];
	$labitems = $_REQUEST["labitems"];
	$radiologyitems = $_REQUEST["radiologyitems"];
	$serviceitems = $_REQUEST["serviceitems"];
	$refferal = $_REQUEST["refferal"];
    $consultationstatus	= $_REQUEST["consultationstatus"];
	$departmentreferal = $_REQUEST['departmentreferal'];
	
	 $query331 = "select * from master_department where auto_number = '$departmentreferal' and recordstatus = ''";
	 $exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	 $res331 = mysqli_fetch_array($exec331);
	 $departmentreferalname = $res331['department'];
	 $rate1 = $res331['rate1'];
	 $rate2 = $res331['rate2'];
	 if($billingtype == "PAY LATER")
	 {
	 $departmentreferalrate = $rate2;
	 }
	 else
	 {
	 $departmentreferalrate = $rate1;
	 }

	
	$ipaddress = $_SERVER["REMOTE_ADDR"];
	  $urgentstatus = $_REQUEST["urgentstatus"];	
	  $urgentstatus = isset($_POST["urgentstatus"])? 1 : 0;
	  $ipadmit = isset($_POST["ipadmit"])? 1 : 0;
	  $ipnotes = $_REQUEST['ipnotes'];
	   $ipnotes = addslashes($ipnotes);
	  if($ipadmit == 1)
	  {
	  $query67 = "insert into consultation_ipadmission(patientcode,patientname,visitcode,accountname,admissiondoctor,username,ipaddress,companyanum,notes,status)values('$patientcode','$patientfullname','$visitcode','$accountname','$consultingdoctor','$username','$ipaddress','$companyanum','$ipnotes','pending')";
	  $exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67);
	  
	  $query877 = "update master_triage set ipconvert='yes' where patientcode='$patientcode' and visitcode='$visitcode'";
	  $exec877 = mysqli_query($GLOBALS["___mysqli_ston"], $query877) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	  }
	 
$updatedatetime = date('Y-m-d H:i:s');
	
    $query2 = "select * from master_triage where auto_number= '$autonumber'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec2);
	$res1patientcode = $res1["patientcode"];
	$res1visitcount = $res1["visitcount"];
	$res1notes = $res1['notes'];
	
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query3 = "select * from master_triage where recordstatus = ''";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rowcount3 = mysqli_num_rows($exec3);
		if ($rowcount3 != 0)
		{
			//header ("location:addtriage1.php?errorcode=errorcode1failed");
			//exit;
		
        $query1 = "insert into master_consultationlist (patientcode,patientfirstname,patientmiddlename,patientlastname,consultingdoctor,consultationtype,department,consultationdate,consultationtime,consultationfees,referredby,consultationremarks,visitcount,complaints,registrationdate,recordstatus,pulse,consultation,labitems,radiologyitems,serviceitems,refferal,consultationstatus,username,visitcode,date) 
		values('$patientcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultingdoctor','$consultationtype','$department','$updatedatetime','$consultationtime','$consultationfees','$referredby','$consultationremarks','$visitcount','$complaints','$registrationdate','$recordstatus','$pulse','$consultation','$labitems','$radiologyitems','$serviceitems','$refferal','completed','$username','$visitcode','$curdate')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query88 = "insert into master_consultation(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,sys,dia,pulse,temp,complaint,drugallergy,foodallergy,consultationtime) 
				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','completed','$currentdate','$ipaddress','$consultingdoctor','$billingtype','$accountname','pending','$bpsystolic','$bpdiastolic','$pulse','$celsius','$complaint','$drugallergy','$foodallergy','$timestamp')";
				$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
					$query93=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set overallpayment='' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$newquery1=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set doctorconsultation='completed' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query31 = "select * from master_company where companystatus = 'Active'";
		$exec31= mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res31 = mysqli_fetch_array($exec31);
		$radrefnoprefix = $res31['radrefnoprefix'];
		$radrefnoprefix1=strlen($radrefnoprefix);
		$query21 = "select * from consultation_radiology order by auto_number desc limit 0, 1";
	    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res21 = mysqli_fetch_array($exec21);
		$radrefnonumber = $res21["refno"];
		$billdigit1=strlen($radrefnonumber);
		if ($radrefnonumber == '')
		{
		$radrefcode =$radrefnoprefix.'1';
		$openingbalance = '0.00';
		}
		else
		{
		$radrefnonumber = $res21["refno"];
		$radrefcode = substr($radrefnonumber,$radrefnoprefix1, $billdigit1);
		$radrefcode = intval($radrefcode);
		$radrefcode = $radrefcode + 1;
		$maxanum = $radrefcode;
		$radrefcode = $radrefnoprefix.$maxanum;
		$openingbalance = '0.00';
		//echo $companycode;
		}
		
		$rad= $_POST['radiology'];
		$rat=$_POST['rate8'];
		$items = array_combine($rad,$rat);
		$pairs = array();
		
		foreach($_POST['radiology'] as $key=>$value){	
			//echo '<br>'.
		
		 $pairs= $_POST['radiology'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
		


		$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_radiology where itemname='$pairvar' and status <> 'deleted'");
		$execradiology=mysqli_fetch_array($radiologyquery);
		$radiologycode=$execradiology['itemcode'];
		
		if(($pairvar!="")&&($pairvar1!=""))
		{
		$query61 = "select * from consultation_radiology where patientcode='$patientcode' and patientvisitcode='$visitcode' and consultationid='$consultationid' and consultationtime = '$timestamp' and radiologyitemname = '$pairvar'";
		$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num61 = mysqli_num_rows($exec61);
		if($num61 == 0)
		{
		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_radiology(consultationid,patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billtype,accountname,consultationdate,paymentstatus,refno,resultentry,consultationtime,username)values('$consultationid','$patientcode','$patientfullname','$visitcode','$radiologycode','$pairvar','$pairvar1','$billingtype','$accountname','$currentdate','$status','$radrefcode','pending','$timestamp','$username')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		}
		$disease111 = $_POST['dis'];
		$code111 = $_POST['code'];
		$items111 = array_combine($disease111,$code111);
		$pairs111 = array();
		foreach($_POST['dis'] as $key=>$value)
		{
		$pairs111 = $_POST['dis'][$key];
		$pairvar111 = $pairs111;
		$pairs112 = $_POST['code'][$key];
		$pairvar112 = $pairs112;
		$pairs113 = $_POST['dis1'][$key];
		$pairs114 = $_POST['code1'][$key];
		
		$icdquery = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_icd where disease = '$pairvar111'"); 
		$execicd = mysqli_fetch_array($icdquery);
		$diseasecode = $execicd['icdcode'];
		
		if($pairvar111 != "")
		{
		
		$icdquery1 = "insert into consultation_icd(consultationid,patientcode,patientname,patientvisitcode,accountname,consultationdate,consultationtime,primarydiag,primaryicdcode,secondarydiag,secicdcode,age)values('$consultationid','$patientcode','$patientfullname','$visitcode','$accountname','$currentdate','$timestamp','$pairs111','$pairs112','$pairs113','$pairs114','$age')";
		$execicdquery = mysqli_query($GLOBALS["___mysqli_ston"], $icdquery1) or die("Error in icdquery1". mysqli_error($GLOBALS["___mysqli_ston"]));
		
		}
		}
		$disease113 = $_POST['dis1'];
		$code113 = $_POST['code1'];
		$items113 = array_combine($disease113,$code113);
		$pairs113 = array();
		foreach($_POST['dis1'] as $key=>$value)
		{
		$pairs113 = $_POST['dis1'][$key];
		$pairvar113 = $pairs113;
		$pairs114 = $_POST['code1'][$key];
		$pairvar114 = $pairs114;
		
		$icdquery31 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_icd where disease = '$pairvar113'"); 
		$execicd31 = mysqli_fetch_array($icdquery31);
		$diseasecode31 = $execicd['icdcode'];
		
		if($pairvar113 != "")
		{
		$query70 = "select * from consultation_icd1 where patientcode='$patientcode' and patientvisitcode='$visitcode' and consultationid='$consultationid' and consultationtime = '$timestamp' and disease = '$pairvar113'";
		$exec70 = mysqli_query($GLOBALS["___mysqli_ston"], $query70) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num70 = mysqli_num_rows($exec70);
		if($num70 == 0)
		{
		$icdquery2 = "insert into consultation_icd1(consultationid,patientcode,patientname,patientvisitcode,disease,icdcode,accountname,consultationdate,consultationtime)
		values('$consultationid','$patientcode','$patientfullname','$visitcode','$pairvar113','$pairvar114','$accountname','$currentdate','$timestamp')";
		$execicdquery2 = mysqli_query($GLOBALS["___mysqli_ston"], $icdquery2) or die("Error in icdquery2". mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		}
		$query34 = "select * from master_company where companystatus = 'Active'";
		$exec34= mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res34 = mysqli_fetch_array($exec34);
		$pharefnoprefix = $res34['pharefnoprefix'];
		$pharefnoprefix1=strlen($pharefnoprefix);
		$query24 = "select * from master_consultationpharm order by auto_number desc limit 0, 1";
	    $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res24 = mysqli_fetch_array($exec24);
		$pharefnonumber = $res24["refno"];
		$billdigit4=strlen($pharefnonumber);
		if ($pharefnonumber == '')
		{
		$pharefcode =$pharefnoprefix.'1';
		$openingbalance = '0.00';
		}
		else
		{
		$pharefnonumber = $res24["refno"];
		$pharefcode = substr($pharefnonumber,$pharefnoprefix1, $billdigit4);
		$pharefcode = intval($pharefcode);
		$pharefcode = $pharefcode + 1;
		$maxanum = $pharefcode;
		$pharefcode = $pharefnoprefix.$maxanum;
		$openingbalance = '0.00';
		//echo $companycode;
		}
		
		for ($p=1;$p<=20;$p++)
		{	
		    $medicinename = $_REQUEST['medicinename'.$p];
			$medicinename = addslashes($medicinename);
			$query77="select * from master_medicine where itemname='$medicinename' and status <> 'deleted'";
			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
			$res77=mysqli_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			$rate=$res77['rateperunit'];
			
			$dose = $_REQUEST['dose'.$p];
		    $frequency = $_REQUEST['frequency'.$p];
			$sele=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_frequency where frequencycode='$frequency'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress=mysqli_fetch_array($sele);
			$frequencyautonumber=$ress['auto_number'];
			$frequencycode=$ress['frequencycode'];
			$frequencynumber=$ress['frequencynumber'];
			$days = $_REQUEST['days'.$p];
			$quantity = $_REQUEST['quantity'.$p];
			$route = $_REQUEST['route'.$p];
			$instructions = $_REQUEST['instructions'.$p];
			$amount = $_REQUEST['amount'.$p];
			
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
		        //echo '<br>'. 
				$query65 = "select * from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' and consultation_id='$consultationid' and consultationtime = '$timestamp' and medicinename='$medicinename'";
		$exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num65 = mysqli_num_rows($exec65);
		if($num65 == 0)
		{
		        $query2 = "insert into master_consultationpharm(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,pharmacybill,medicineissue,consultationtime,source,route) 
				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$currentdate','$ipaddress','$consultingdoctor','$billingtype','$accountname','pending','$medicinecode','$pharefcode','$status','pending','$timestamp','doctorconsultation','$route')";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$query29 = "insert into master_consultationpharmissue(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,prescribed_quantity,source,route) 
				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$currentdate','$ipaddress','$consultingdoctor','$billingtype','$accountname','$status','$medicinecode','$pharefcode','$quantity','doctorconsultation','$route')";
				$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
	
				}
				
			}
		
		}
	
		
	
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$labrefnoprefix = $res3['labrefnoprefix'];
$labrefnoprefix1=strlen($labrefnoprefix);
$query2 = "select * from consultation_lab order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$labrefnonumber = $res2["refno"];
$billdigit=strlen($labrefnonumber);
if ($labrefnonumber == '')
{
	$labrefcode =$labrefnoprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$labrefnonumber = $res2["refno"];
	$labrefcode = substr($labrefnonumber,$labrefnoprefix1, $billdigit);
	$labrefcode = intval($labrefcode);
	$labrefcode = $labrefcode + 1;
$maxanum = $labrefcode;
	$labrefcode = $labrefnoprefix.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

	foreach($_POST['categorylab'] as $key=>$value)
	{
	
	$categorylabname=$_POST['categorylab'][$key];
	
	
	$categorylabrate=$_POST['categoryrate5'][$key];
	if($categorylabname != "")
	{
	$categorylabquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_lab(consultationid,patientcode,patientname,patientvisitcode,labitemname,labitemrate,billtype,accountname,consultationdate,paymentstatus,refno,labsamplecoll,resultentry,labrefund)values('$consultationid','$patientcode','$patientfullname','$visitcode','$categorylabname','$categorylabrate','$billingtype','$accountname','$currentdate','$status','$labrefcode','pending','pending','norefund')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}	
	}
	
			
		foreach($_POST['lab'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$labname=$_POST['lab'][$key];
		$labname = addslashes($labname);
		$labquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_lab where itemname='$labname' and status <> 'deleted'");
		$execlab=mysqli_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate5'][$key];
		
		if(($labname!="")&&($labrate!=''))
		{
		$query63 = "select * from consultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and consultationid='$consultationid' and consultationtime = '$timestamp' and labitemcode ='$labcode'";
		$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num63 = mysqli_num_rows($exec63);
		if($num63 == 0)
		{
	
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_lab(consultationid,patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billtype,accountname,consultationdate,paymentstatus,refno,labsamplecoll,resultentry,labrefund,urgentstatus,consultationtime,username)values('$consultationid','$patientcode','$patientfullname','$visitcode','$labcode','$labname','$labrate','$billingtype','$accountname','$currentdate','$status','$labrefcode','pending','pending','norefund','$urgentstatus','$timestamp','$username')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			}
		}
		$query32 = "select * from master_company where companystatus = 'Active'";
		$exec32= mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res32 = mysqli_fetch_array($exec32);
		$serrefnoprefix = $res32['serrefnoprefix'];
		$serrefnoprefix1=strlen($serrefnoprefix);
		$query22 = "select * from consultation_services order by auto_number desc limit 0, 1";
	    $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res22 = mysqli_fetch_array($exec22);
		$serrefnonumber = $res22["refno"];
		$billdigit2=strlen($serrefnonumber);
		if ($serrefnonumber == '')
		{
		$serrefcode =$serrefnoprefix.'1';
		$openingbalance = '0.00';
		}
		else
		{
		$serrefnonumber = $res22["refno"];
		$serrefcode = substr($serrefnonumber,$serrefnoprefix1, $billdigit2);
		$serrefcode = intval($serrefcode);
		$serrefcode = $serrefcode + 1;
		$maxanum = $serrefcode;
		$serrefcode = $serrefnoprefix.$maxanum;
		$openingbalance = '0.00';
		//echo $companycode;
		}
		
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$servicesname=$_POST["services"][$key];
		$servicequery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_services where itemname='$servicesname' and status <> 'deleted'");
		$execservice=mysqli_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		
		$servicesrate=$_POST["rate3"][$key];
		
		if(($servicesname!="")&&($servicesrate!=''))
		{
		$query67 = "select * from consultation_services where patientcode='$patientcode' and patientvisitcode='$visitcode' and consultationid='$consultationid' and consultationtime = '$timestamp' and servicesitemcode='$servicescode'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num67 = mysqli_num_rows($exec67);
		
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_services(consultationid,patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,billtype,accountname,consultationdate,paymentstatus,refno,process,consultationtime,username)values('$consultationid','$patientcode','$patientfullname','$visitcode','$servicescode','$servicesname','$servicesrate','$billingtype','$accountname','$currentdate','$status','$serrefcode','pending','$timestamp','$username')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		
		}
		}
		$query33 = "select * from master_company where companystatus = 'Active'";
		$exec33= mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res33 = mysqli_fetch_array($exec33);
		$refrefnoprefix = $res33['refrefnoprefix'];
		$refrefnoprefix1=strlen($refrefnoprefix);
		$query23 = "select * from consultation_referal order by auto_number desc limit 0, 1";
	    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res23 = mysqli_fetch_array($exec23);
		$refrefnonumber = $res23["refno"];
		$billdigit3=strlen($refrefnonumber);
		if ($refrefnonumber == '')
		{
		$refrefcode =$refrefnoprefix.'1';
		$openingbalance = '0.00';
		}
		else
		{
		$refrefnonumber = $res23["refno"];
		$refrefcode = substr($refrefnonumber,$refrefnoprefix1, $billdigit3);
		$refrefcode = intval($refrefcode);
		$refrefcode = $refrefcode + 1;
		$maxanum = $refrefcode;
		$refrefcode = $refrefnoprefix.$maxanum;
		$openingbalance = '0.00';
		//echo $companycode;
		}
		foreach($_POST['referal'] as $key=>$value)
		{
		$pairs2= $_POST['referal'][$key];
		$pairvar2= $pairs2;
	    $pairs3= $_POST['rate4'][$key];
		$pairvar3= $pairs3;
		
		$referalquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_doctor where doctorname='$pairvar2'");
		$execreferal=mysqli_fetch_array($referalquery);
		$referalcode=$execreferal['doctorcode'];
		
		
		if($pairvar2!="")
		{
		$query68 = "select * from consultation_referal where patientcode='$patientcode' and patientvisitcode='$visitcode' and consultationid='$consultationid' and consultationtime = '$timestamp' and referalcode='$referalcode'";
		$exec68 = mysqli_query($GLOBALS["___mysqli_ston"], $query68) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num68 = mysqli_num_rows($exec68);
		if($num68 == 0)
		{
	
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_referal(consultationid,patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,billtype,accountname,consultationdate,paymentstatus,refno,consultationtime)values('$consultationid','$patientcode','$patientfullname','$visitcode','$referalcode','$pairvar2','$pairvar3','$billingtype','$accountname','$currentdate','pending','$refrefcode','$timestamp')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$referalquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set referalbill='pending' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		}
		$query453 = "update consultation_departmentreferal set consultation='completed' where patientvisitcode='$visitcode'";
		$exec453 = mysqli_query($GLOBALS["___mysqli_ston"], $query453) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if($departmentreferal != '')
		{
		
		
		$query61 = "insert into consultation_departmentreferal(consultationid,patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,billtype,accountname,consultationdate,paymentstatus,refno,consultationtime,username)values('$consultationid','$patientcode','$patientfullname','$visitcode','$departmentreferal','$departmentreferalname','$departmentreferalrate','$billingtype','$accountname','$currentdate','pending','$refrefcode','$timestamp','$username')";
		$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$newquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set referalconsultation='' where visitcode='$visitcode' and referalbill='completed'");
		}
		else
		{
		$newquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set referalconsultation='completed' where visitcode='$visitcode' and referalbill='completed'");
		}
		
			
		
		if($departmentreferalrate == '0.00')
		{
		if($billingtype == "PAY NOW")
		{
	    $query591 = "update consultation_departmentreferal set paymentstatus='completed' where patientvisitcode='$visitcode' and referalcode='$departmentreferal'";
		$exec591 = mysqli_query($GLOBALS["___mysqli_ston"], $query591) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query592 = "update master_visitentry set referalbill='completed' where visitcode='$visitcode'";
		$exec592 = mysqli_query($GLOBALS["___mysqli_ston"], $query592) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		
		if($billingtype == "PAY LATER")
		{
		if($departmentreferal != '')
		{
		$newquery3=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set referalconsultation='' where visitcode='$visitcode'");
		}
		else
		{
		$newquery3=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set referalconsultation='completed' where visitcode='$visitcode'");
		}
		}
		
		$newquery=mysqli_query($GLOBALS["___mysqli_ston"], "update master_triage set consultation='completed',urgentstatus='0',complanits='$complaint' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
		//$patientcode = '';
		//$visitcode = '';
		$patientcode = '';
		$patientfirstname = '';
		$patientmiddlename = '';
		$patientlastname = '';
		$consultingdoctor = '';
		$consultationtype = '';
		$department = '';
		$consultationdate = '';
		$consultationtime = '';
		$consultationfees = '';
		$referredby = '';
		$consultationremarks = '';
		$complaints = '';
		$registrationdate = '';
		$recordstatus = '';
		$nursename = '';
		$pulse = '';
		$height = '';
		$weight = '';
		$bmi = '';
		$respiration = '';
		$headcircumference = '';
		$bsa = '';
		$fahrenheit = '';
		$celsius = '';
		$bpsystolic = '';
		$bpdiastolic = '';
		$drugallergy = '';
		$foodallergy = '';
		$consultation = '';
		$labitems = '';
		$radiologyitems = '';
		$serviceitems = '';
		$refferal = '';	
		$sno = '';
     	$code = '';
	    $name = '';
	    $dose = '';
	    $frequency = '';
	    $days = '';
	    $quantity = '';
	    $instructions = '';
	    $rate = '';
	    $amount = '';
		$consultationstatus = '';
		
		header ("location:gynaecologylist.php?patientcode=$patientcode&&st=success");
		exit;
		}
	}
	else
	{
		header ("location:addtriage1.php?patientcode=$patientcode&&st=failed");
	}

}
else
{
	$patientcode = '';
	$visitcode = '';
	$patientfirstname = '';
	$patientmiddlename = '';
	$patientlastname = '';
	$consultationtype = '';
	$consultingdoctor = '';
	$consultationdate = '';
	$consultationtime = '';
	$consultationfees = '';
	$referredby = '';
	$consultationremarks = '';
	$complaints = '';
	$registrationdate = '';
    $recordstatus = '';
	$nursename = '';
	$pulse = '';
	$height = '';
	$weight = '';
	$bmi = '';
	$respiration = '';
	$headcircumference = '';
	$bsa = '';
	$fahrenheit = '';
	$celsius = '';
	$bpsystolic = '';
	$bpdiastolic = '';
	$drugallergy = '';
	$foodallergy = '';
	$consultation = '';
	$labitems = '';
	$radiologyitems = '';
	$serviceitems = '';
	$refferal = '';	
	$sno = '';
	$code = '';
	$name = '';
	$dose = '';
	$frequency = '';
	$days = '';
	$quantity = '';
	$instructions = '';
	$rate = '';
	$amount = '';
	$consultationstatus = '';
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. New Visit Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Visit Updated.";
		}
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Visit Code Already Exists.";
}

if (isset($_REQUEST["patientcode"])) 
{ 
$patientcode = $_REQUEST["patientcode"];
$viscode=$_REQUEST['visitcode'];
 } else { $patientcode = "";
 $viscode=""; }
 
 $query67 = "update master_triage set consultation='Inprogress' where patientcode='$patientcode' and visitcode='$viscode'";
 $exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 
 $querytr1="update master_visitentry set triagestatus='completed' where visitcode='$viscode'";
		$exectr1=mysqli_query($GLOBALS["___mysqli_ston"], $querytr1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$querytr="update master_billing set triagestatus='completed' where visitcode='$viscode'";
		$exectr=mysqli_query($GLOBALS["___mysqli_ston"], $querytr) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 
         $query88 = "select * from master_customer where customercode ='$patientcode'";
		 $exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res88 = mysqli_fetch_array($exec88);
	     $patienttype = $res88['billtype'];
		
    $query2 = "select * from master_triage where patientcode = '$patientcode' and visitcode='$viscode' order by auto_number desc";//order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$num=mysqli_num_rows($exec2);
		if($num > 0)
		{
		$patientcode = $res2['patientcode'];
		$res2patientaccountname = $res2['accountname'];
		$patientfirstname = $res2['patientfirstname'];
		 $patientfirstname = strtoupper($patientfirstname);
	    $patientmiddlename = $res2['patientmiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $res2['patientlastname'];
		 $patientlastname = strtoupper($patientlastname);
		 $patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
		$registrationdate = $res2["registrationdate"];
		$consultingdoctor = $res2['consultingdoctor'];
		$department = $res2['department'];
		$consultationtype = $res2["consultationtype"];
		$consultationdate = $res2["registrationdate"];
		$consultationtime  = $res2["consultationtime"];
		$consultationfees  = $res2["consultationfees"];
		$billamount = $consultationfees;
		$referredby = $res2["referredby"];
		
		$consultationremarks = $res2["consultationremarks"];
		$complaint = $res2["complaint"];
		$visitcount = $res2['visitcount'];
		$visitcodenum=$res2['visitcode'];
	    $pulse = $res2["pulse"];
		$height = $res2["height"];
		$weight = $res2["weight"];
		$bmi = $res2["bmi"];
		$notes = $res2['notes'];
		$respiration = $res2["respiration"];
		$headcircumference =$res2["headcircumference"];
		$bsa = $res2["bsa"];
		$fahrenheit = $res2["fahrenheit"];
		$celsius = $res2["celsius"];
		$bpsystolic = $res2["bpsystolic"];
		$bpdiastolic = $res2["bpdiastolic"];
		$drugallergy = $res2["drugallergy"];
		$foodallergy = $res2["foodallergy"];
		$complanits = $res2["complanits"];
		$consultation = $res2["consultation"];
	   
	     $res2billtype = $res2['billtype'];
		$quer=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
		$result=mysqli_fetch_array($quer);
		$patientauto_number=$result['auto_number'];
	$time=date('H-i-s');
	}
	else
	{
 $query23="select * from master_visitentry where patientcode = '$patientcode' and visitcode='$viscode'";
 $exec23=mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 $res23=mysqli_fetch_array($exec23);
 $numm=mysqli_num_rows($exec23);

$patientfirstname = $res23['patientfirstname'];
		 $patientfirstname = strtoupper($patientfirstname);
	    $patientmiddlename = $res23['patientmiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $res23['patientlastname'];
		 $patientlastname = strtoupper($patientlastname);
		 $patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;

 $departmentname=$res23['department'];
 
 $query231="select * from master_department where auto_number='$departmentname'";
 $exec231=mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 $res231=mysqli_fetch_array($exec231);
 $department=$res231['department'];
 
 $consultingdoctorname=$res23['consultingdoctor'];
  $query232="select * from master_doctor where auto_number='$consultingdoctorname'";
 $exec232=mysqli_query($GLOBALS["___mysqli_ston"], $query232) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 $res232=mysqli_fetch_array($exec232);
 $consultingdoctor=$res232['doctorname'];

 $accountname=$res23['accountname'];

 $query233="select * from master_accountname where auto_number='$accountname'";
 $exec233=mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 $res233=mysqli_fetch_array($exec233);
 
$res2patientaccountname = $res233['accountname'];
 
 $consultationdate = $res23["consultationdate"];
$visitcodenum=$viscode;
	}

$query111  = "select * from master_customer where customercode = '$patientcode'";
$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
$res111 = mysqli_fetch_array($exec111);
$res111paymenttype = $res111['paymenttype'];
$res111maintype = $res111['maintype'];
$res111subtype = $res111['subtype'];
$occupation = $res111['occupation'];	 
$address = $res111['area']; 	   
$dob = $res111['dateofbirth']; 

$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";
$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
$res121 = mysqli_fetch_array($exec121);
$res121paymenttype = $res121['paymenttype'];

$query131 = "select * from master_subtype where auto_number = '$res111subtype'";
$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
$res131 = mysqli_fetch_array($exec131);
$res131subtype = $res131['subtype'];

$query59 = "select * from master_visitentry where visitcode='$viscode'";
$exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res59 = mysqli_fetch_array($exec59);
$gender = $res59['gender'];

$age = calculate_age($dob);

function calculate_age($birthday)
{
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));

    if ($diff->y)
    {
        return $diff->y . ' Years';
    }
    elseif ($diff->m)
    {
        return $diff->m . ' Months';
    }
    else
    {
        return $diff->d . ' Days';
    }
}

	
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
//$patientcode = 'MSS00000009';

if ($patientcode != '')
{
	//echo 'Inside Patient Code Condition.';
	//$query3 = "select * from master_billing where recordstatus = ''";
	//$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	//$res3 = mysql_fetch_array($exec3);
	//$registrationdate = $res['registrationdate'];
	//$consultingdoctor = $res2['consultingdoctor'];
	//$department = $res2['department'];
	//$visitcount = $res2['visitcount'];
	//$consultationremarks = $res2["consultationremarks"];
	//$complaint = $res2["complaint"];
	//$consultationtype = $res2['consultationtype'];
	//$referredby = $res2["referredby"];

}
//$registrationdate = date('Y-m-d');
//$consultationdate = date('Y-m-d');
//$consultationtime = date('H:i');
//$consultationfees = '500';

//if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
//$patientcode = 'MSS00000009';
//if ($errorcode == 'errorcode1failed')
//{
	//$errmsg = 'Patient Already Visited Today. Cannot Proceed With Visit Entry. Save Not Completed.';	
//}
include("autocompletebuild_medicine1.php");
include ("autocompletebuild_lab1.php");
include ("autocompletebuild_radiology1.php");
include ("autocompletebuild_services1.php");
include ("autocompletebuild_referal.php");

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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/insertnewitem1.js"></script>
<script type="text/javascript" src="js/insertnewitem2.js"></script>
<script type="text/javascript" src="js/insertnewitem3.js"></script>
<script type="text/javascript" src="js/insertnewitem4.js"></script>
<script type="text/javascript" src="js/insertnewitem5.js"></script>
<script type="text/javascript" src="js/insertnewitem13.js"></script>
<script type="text/javascript" src="js/insertnewitem14.js"></script>
<script type="text/javascript" src="js/insertreferrate.js"></script>
<script language="javascript">
var totalamount=0;
var totalamount1=0;
var totalamount2=0;
var totalamount3=0;
var totalamount4=0;
var totalamount11;
var totalamount21;
var totalamount31;
var totalamount41;
var grandtotal=0;
function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function processflowitem(varstate)
{
	//alert ("Hello World.");
	var varProcessID = varstate;
	//alert (varProcessID);
	var varItemNameSelected = document.getElementById("state").value;
	//alert (varItemNameSelected);
	ajaxprocess5(varProcessID);
	//totalcalculation();
}

function processflowitem1()
{
}
function btnDeleteClick(delID,pharmamount)
{
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
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	var currenttotal4=document.getElementById('total').value;
	//alert(currenttotal);
	newtotal4= currenttotal4-pharmamount;
	
	//alert(newtotal);
	
	document.getElementById('total').value=newtotal4.toFixed(2);
	
	var currentgrandtotal4=document.getElementById('total4').value;
	
	if(document.getElementById('total1').value=='')
	{
	totalamount11=0;
	}
	else
	{
	totalamount11=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total3').value;
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount41=0;
	}
	else
	{
	totalamount41=document.getElementById('total5').value;
	}
	
	
	var newgrandtotal4=parseFloat(newtotal4)+parseFloat(totalamount11)+parseFloat(totalamount21)+parseFloat(totalamount31)+parseFloat(totalamount41);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal4.toFixed(2);
	
	
}
function btnDeleteClick1(delID1,vrate1)
{

	var newtotal3;
	//alert(vrate1);
	var varDeleteID1 = delID1;
	//alert(varDeleteID1);
	var fRet4; 
	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet4); 
	if (fRet4 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	var child1 = document.getElementById('idTR'+varDeleteID1); //tr name
    var parent1 = document.getElementById('insertrow1'); // tbody name.
	document.getElementById ('insertrow1').removeChild(child1);
	
	var child1= document.getElementById('idTRaddtxt'+varDeleteID1);  //tr name
    var parent1= document.getElementById('insertrow1'); // tbody name.
	//alert (child);
	if (child1 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow1').removeChild(child1);
	}
	
	var currenttotal3=document.getElementById('total1').value;
	//alert(currenttotal);
	newtotal3= currenttotal3-vrate1;
	newtotal3=newtotal3.toFixed(2);
	//alert(newtotal3);
	
	document.getElementById('total1').value=newtotal3;
	if(document.getElementById('total').value=='')
	{
	 totalamount11=0;
	//alert(totalamount11);
	}
	else
	{
	totalamount11=document.getElementById('total').value;
	}
	if(document.getElementById('total2').value=='')
	{
	 totalamount21=0;
	//alert(totalamount21);
	}
	else
	{
	totalamount21=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	 totalamount31=0;
	//alert(totalamount31);
	}
	else
	{
	 totalamount31=document.getElementById('total3').value;
	}
	if(document.getElementById('total5').value=='')
	{
	 totalamount41=0;
	//alert(totalamount41);
	}
	else
	{
	 totalamount41=document.getElementById('total5').value;
	}
	
	
	
		 newgrandtotal3=parseFloat(totalamount11)+parseFloat(newtotal3)+parseFloat(totalamount21)+parseFloat(totalamount31)+parseFloat(totalamount41);
	//alert(newgrandtotal3);
	document.getElementById('total4').value=newgrandtotal3;
	
	

}

function btnDeleteClick5(delID5,radrate)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal2;
	//alert(radrate);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	document.getElementById ('insertrow2').removeChild(child2);
	
	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow2').removeChild(child2);
	}
	
	var currenttotal2=document.getElementById('total2').value;
	//alert(currenttotal);
	newtotal2= currenttotal2-radrate;
	
	//alert(newtotal);
	
	document.getElementById('total2').value=newtotal2;
	if(document.getElementById('total').value=='')
	{
	totalamount11=0;
	}
	else
	{
	totalamount11=document.getElementById('total').value;
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total3').value;
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount41=0;
	}
	else
	{
	totalamount41=document.getElementById('total5').value;
	}
	
	
    var newgrandtotal2=parseFloat(totalamount11)+parseFloat(totalamount21)+parseFloat(newtotal2)+parseFloat(totalamount31)+parseFloat(totalamount41);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal2;
	
	
	

	
}
function btnDeleteClick3(delID3,vrate3)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal1;
	var varDeleteID3= delID3;
	//alert (varDeleteID3);
	//alert(vrate3);
	var fRet6; 
	fRet6 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet6 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child3 = document.getElementById('idTR'+varDeleteID3);  
	//alert (child3);//tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	document.getElementById ('insertrow3').removeChild(child3);
	
	var child3= document.getElementById('idTRaddtxt'+varDeleteID3);  //tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	
	if (child3 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow3').removeChild(child3);
	}
var currenttotal1=document.getElementById('total3').value;
	//alert(currenttotal);
	newtotal1= currenttotal1-vrate3;
	
	//alert(newtotal);
	
	document.getElementById('total3').value=newtotal1;
	if(document.getElementById('total').value=='')
	{
	totalamount11=0;
	}
	else
	{
	totalamount11=document.getElementById('total').value;
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total2').value;
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount41=0;
	}
	else
	{
	totalamount41=document.getElementById('total5').value;
	}
	
	var newgrandtotal1=parseFloat(totalamount11)+parseFloat(totalamount21)+parseFloat(totalamount31)+parseFloat(newtotal1)+parseFloat(totalamount41);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal1;	
	
}

function btnDeleteClick4(delID4,vrate4)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal;
	//alert(delID4);
	var varDeleteID4= delID4;
	//alert(varDeleteID4);
	
	//alert(rateref);
	//alert (varDeleteID3);
	var fRet7; 
	fRet7 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet7 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child4 = document.getElementById('idTR'+varDeleteID4);  
	//alert (child3);//tr name
    var parent4 = document.getElementById('insertrow4'); // tbody name.
	document.getElementById ('insertrow4').removeChild(child4);
	
	var child4= document.getElementById('idTRaddtxt'+varDeleteID4);  //tr name
    var parent4 = document.getElementById('insertrow4'); // tbody name.
	
	if (child4 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow4').removeChild(child4);
	}

	var currenttotal=document.getElementById('total5').value;
	//alert(currenttotal);
	newtotal= currenttotal-vrate4;
	
	//alert(newtotal);
	
	document.getElementById('total5').value=newtotal;
	if(document.getElementById('total').value=='')
	{
	totalamount11=0;
	}
	else
	{
	totalamount11=document.getElementById('total').value;
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount41=0;
	}
	else
	{
	totalamount41=document.getElementById('total3').value;
	}
	var newgrandtotal=parseFloat(totalamount11)+parseFloat(totalamount21)+parseFloat(totalamount31)+parseFloat(totalamount41)+parseFloat(newtotal);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal;	
}

function btnDeleteClick13(delID13)
{
	//alert ("Inside btnDeleteClick.");
	//var newtotal;
	//alert(delID4);
	var varDeleteID13= delID13;
	//alert(varDeleteID4);
	
	//alert(rateref);
	//alert (varDeleteID3);
	var fRet13; 
	fRet13 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet13 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child13 = document.getElementById('idTR'+varDeleteID13);  
	//alert (child3);//tr name
    var parent13 = document.getElementById('insertrow13'); // tbody name.
	document.getElementById ('insertrow13').removeChild(child13);
	
	var child13= document.getElementById('idTRaddtxt'+varDeleteID13);  //tr name
    var parent13 = document.getElementById('insertrow13'); // tbody name.
	
	if (child13 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow13').removeChild(child13);
	}

	
}
function btnDeleteClick14(delID14)
{
	//alert ("Inside btnDeleteClick.");
	//var newtotal;
	//alert(delID4);
	var varDeleteID14= delID14;
	//alert(varDeleteID4);
	
	//alert(rateref);
	//alert (varDeleteID3);
	var fRet14; 
	fRet14 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet14 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child14 = document.getElementById('idTR'+varDeleteID14);  
	//alert (child3);//tr name
    var parent14 = document.getElementById('insertrow14'); // tbody name.
	document.getElementById ('insertrow14').removeChild(child14);
	
	var child14= document.getElementById('idTRaddtxt'+varDeleteID14);  //tr name
    var parent14 = document.getElementById('insertrow14'); // tbody name.
	
	if (child14 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow14').removeChild(child14);
	}

	
}
function notescheck()
{
if(document.getElementById('ipadmit').checked == true)
{
document.getElementById('ipnotes').style.display = '';
document.getElementById('noteslable').style.display = '';
}
else
{
document.getElementById('ipnotes').style.display = 'none';
document.getElementById('noteslable').style.display = 'none';
}
}
</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
#drugallergy
{

}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
<script language="javascript">

function frequencyitem()
{
if(document.form1.frequency.value=="select")
{
alert("please select a frequency");
document.form1.frequency.focus();
return false;
}
return true;
}

function Functionfrequency()
{
var formula = document.getElementById("formula").value;
formula = formula.replace(/\s/g, '');
//alert(formula);
if(formula == 'INCREMENT')
{
var ResultFrequency;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum * VarDays;
 }
 else
 {
 ResultFrequency =0;
 }
 document.getElementById("quantity").value = ResultFrequency;
var VarRate = document.getElementById("rates").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
}

else if(formula == 'CONSTANT')
{
var ResultFrequency;
var strength = document.getElementById("strength").value;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum*VarDays/strength;
 }
 else
 {
 ResultFrequency =0;
 }
 //ResultFrequency = parseInt(ResultFrequency);

 ResultFrequency = Math.ceil(ResultFrequency);
 //alert(ResultFrequency);
 document.getElementById("quantity").value = ResultFrequency;
 
 
var VarRate = document.getElementById("rates").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
}
}
function process1()
{

	
	}

<?php /*?> /*  <?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
	$currentdate = date("Y/m/d",$date);
	?>*/
/*	var currentdate = "<?php echo $currentdate; ?>";<?php */?>
/*	var expirydate = document.getElementById("accountexpirydate").value; 
	var currentdate = Date.parse(currentdate);
	var expirydate = Date.parse(expirydate);
	
	if( expirydate > currentdate)
	{
		alert("Please Select Correct Account Expiry date");
		//document.getElementById("accountexpirydate").focus();
		//return false;
	}*/
	
	

/*
function funcVisitLimt()
{
<?php
	$query11 = "select * from master_customer where status = 'ACTIVE'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11customername = $res11["customername"];
	$res11visitlimit = $res11['visitlimit'];
	$res11patientfirstname = $res11patientfirstname['patientfirstname'];
		?>
		if(document.getElementById("customername").value == "<?php echo $res11customername; ?>")
		{
			document.getElementById("visitlimit").value = <?php echo $res11visitlimit; ?>;
			document.getElementById("patientfirstname").value = <?php echo $res11patientfirstname; ?>;
			document.getElementById("customername").value = <?php echo $res11customername; ?>;
	
			return false;
		}
	<?php
	}
	?>
}
*/

function funcDepartmentChange()
{
	<?php
	$query11 = "select * from master_department where recordstatus = ''";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11departmentanum = $res11['auto_number'];
	$res11department = $res11["department"];
	?>
		if(document.getElementById("department").value == "<?php echo $res11departmentanum; ?>")
		{
		document.getElementById("consultingdoctor").options.length=null; 
		var combo = document.getElementById('consultingdoctor'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Doctor Name", ""); 
		<?php
		$query10 = "select * from master_doctor where department = '$res11departmentanum' order by doctorname";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10doctoranum = $res10['auto_number'];
		$res10doctorcode = $res10["doctorcode"];
		$res10doctorname = $res10["doctorname"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10doctorname;?>", "<?php echo $res10doctoranum;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>
	<?php
	$query11 = "select * from master_department where recordstatus = ''";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11departmentanum = $res11['auto_number'];
	$res11department = $res11["department"];
	?>
		if(document.getElementById("department").value == "<?php echo $res11departmentanum; ?>")
		{
		document.getElementById("consultationtype").options.length=null; 
		var combo = document.getElementById('consultationtype'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Consultation Type", ""); 
		<?php
		$query10 = "select * from master_consultationtype where department = '$res11departmentanum' order by consultationtype";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10consultationtypeanum = $res10['auto_number'];
		$res10consultationtype = $res10["consultationtype"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10consultationtype;?>", "<?php echo $res10consultationtypeanum;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>


}
function funcConsultationTypeChange()
{
	<?php
	$query11 = "select * from master_consultationtype where recordstatus = ''";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11consultationanum = $res11["auto_number"];
	$res11consultationtype = $res11["consultationtype"];
	$res11consultationfees = $res11["consultationfees"];
	?>
		if(document.getElementById("consultationtype").value == "<?php echo $res11consultationanum; ?>")
		{
			document.getElementById("consultationfees").value = <?php echo $res11consultationfees; ?>;
			document.getElementById("consultationfees").focus();
		}
	<?php
	}
	?>
}
function funcOnLoadBodyFunctionCall1()
{
    
	//alert(oTextbox);
    funcHideView();
	funcpresHideView();
	funcLabHideView();
	funcRadHideView();
	funcSerHideView();
	funcRefferalHideView();
	document.getElementById('ipnotes').style.display = 'none';
	document.getElementById('noteslable').style.display = 'none';
	//var oTextbox = new AutoSuggestControl17(document.getElementById("dis"), new StateSuggestions17());
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	funcCustomerDropDownSearch1();
	funcCustomerDropDownSearch2();	
	funcCustomerDropDownSearch3();
	funcCustomerDropDownSearch4(); 
	funcCustomerDropDownSearch7();
	funcCustomerDropDownSearch10();
	funcCustomerDropDownSearch15();
	funcOnLoadBodyFunctionCall1();//To handle ajax dropdown list.
}
function funcaccountexpiry()
{
    <?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
	$currentdate = date("Y/m/d",$date);
	?>
	var currentdate = "<?php echo $currentdate; ?>";
	var expirydate = document.getElementById("expirydate").value; 
	var currentdate = Date.parse(currentdate);
	var expirydate = Date.parse(expirydate);
	
if( expirydate < currentdate)
  {
	alert("Please Select Correct Account Expiry date");
	document.getElementById("expirydate").focus();
	return false;
  }
}
if (document.getElementById("consltid") != null) 
{
	document.getElementById("consltid").style.display = 'none';
}

function funcShowView()
{
  if (document.getElementById("disease") != null) 
     {
	 document.getElementById("disease").style.display = '';
	}
	if (document.getElementById("disease1") != null) 
	  {
	  document.getElementById("disease1").style.display = '';
	 }
	  if (document.getElementById("consltid") != null) 
	 {
	document.getElementById("consltid").style.display = '';
	}
}
	
function funcHideView()
{		
 if (document.getElementById("disease") != null) 
	{
	document.getElementById("disease").style.display = 'none';
	}
 if(document.getElementById("disease1") != null)
 {
 document.getElementById("disease1").style.display = 'none';
 }			
	 if (document.getElementById("consltid") != null) 
	 {
	document.getElementById("consltid").style.display = 'none';
	}	
}
function funcpresShowView()
{
  if (document.getElementById("pressid") != null) 
     {
	 document.getElementById("pressid").style.display = 'none';
	}
	if (document.getElementById("pressid") != null) 
	  {
	  document.getElementById("pressid").style.display = '';
	 }
}
function funcpresHideView()
{		
 if (document.getElementById("pressid") != null) 
	{
	document.getElementById("pressid").style.display = 'none';
	}	
}
function funcLabShowView()
{
  if (document.getElementById("labid") != null) 
     {
	 document.getElementById("labid").style.display = 'none';
	}
	if (document.getElementById("labid") != null) 
	  {
	  document.getElementById("labid").style.display = '';
	 }
	
}
	
function funcLabHideView()
{		
 if (document.getElementById("labid") != null) 
	{
	document.getElementById("labid").style.display = 'none';
	}		
	 
}

function funcRadShowView()
{
  if (document.getElementById("radid") != null) 
     {
	 document.getElementById("radid").style.display = 'none';
	}
	if (document.getElementById("radid") != null) 
	  {
	  document.getElementById("radid").style.display = '';
	 }
}
	
function funcSerHideView()
{		
 if (document.getElementById("serid") != null) 
	{
	document.getElementById("serid").style.display = 'none';
	}			
}
function funcSerShowView()
{
  if (document.getElementById("serid") != null) 
     {
	 document.getElementById("serid").style.display = 'none';
	}
	if (document.getElementById("serid") != null) 
	  {
	  document.getElementById("serid").style.display = '';
	 }
}
	
function funcRadHideView()
{		
 if (document.getElementById("radid") != null) 
	{
	document.getElementById("radid").style.display = 'none';
	}			
}
function funcRefferalShowView()
{
  if (document.getElementById("reffid") != null) 
     {
	 document.getElementById("reffid").style.display = 'none';
	}
	if (document.getElementById("reffid") != null) 
	  {
	  document.getElementById("reffid").style.display = '';
	 }
}
	
function funcRefferalHideView()
{		
 if (document.getElementById("reffid") != null) 
	{
	document.getElementById("reffid").style.display = 'none';
	}			
}
</script>
<?php
	$query21 = "select * from master_consultation order by auto_number desc limit 0, 1";
	 $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	 $rowcount21 = mysqli_num_rows($exec21);
	if ($rowcount21 == 0)
	{
		$consultationcode = 'CON001';
	}
	else
	{
		$res21 = mysqli_fetch_array($exec21);
		 $consultationcode = $res21['consultation_id'];
		 $consultationcode = substr($consultationcode, 3, 7);
		$consultationcode= intval($consultationcode);
		$consultationcode = $consultationcode + 1;
	
		
		
		
		if (strlen($consultationcode) == 2)
		{
			$consultationcode= '0'.$consultationcode;
		}
		if (strlen($consultationcode) == 1)
		{
			$consultationcode= '00'.$consultationcode;
		}
		$consultationcode = 'CON'.$consultationcode;
		}
	
?>
<?php include ("js/dropdownlist1icd.php"); ?>
<script type="text/javascript" src="js/autosuggestnewicdcode.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newicd.js"></script>

<?php include ("js/dropdownlist1icd1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewicdcode1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newicd1.js"></script>

<?php include ("js/dropdownlist1newscriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewmedicine1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newmedicineq.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch2.js"></script>

<?php include ("js/dropdownlist1scriptinglab1.php"); ?>
<script type="text/javascript" src="js/autocomplete_lab1.js"></script>
<script type="text/javascript" src="js/autosuggestlab1.js"></script> 
<script type="text/javascript" src="js/autolabcodesearch2.js"></script>


<?php include ("js/dropdownlist1scriptingradiology1.php"); ?>
<script type="text/javascript" src="js/autocomplete_radiology1.js"></script>
<script type="text/javascript" src="js/autosuggestradiology1.js"></script> 
<script type="text/javascript" src="js/autoradiologycodesearch2.js"></script>


<?php include ("js/dropdownlist1scriptingservices1.php"); ?>
<script type="text/javascript" src="js/autocomplete_services1.js"></script>
<script type="text/javascript" src="js/autosuggestservices1.js"></script>
<script type="text/javascript" src="js/autoservicescodesearch2.js"></script>

<?php include ("js/dropdownlist1scriptingreferal.php"); ?>
<script type="text/javascript" src="js/autocomplete_referal.js"></script>
<script type="text/javascript" src="js/autosuggestreferal1.js"></script>
<script type="text/javascript" src="js/autoreferalcodesearch2.js"></script>


<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script src="js/datetimepicker_css.js"></script>


 <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
<body onLoad="return funcOnLoadBodyFunctionCall();">

<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%" height="1426">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
     <form name="form1" id="form1" method="post" action="gynaecologyconsultationform.php" onSubmit="return process1();">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="103%"><table   border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td colspan="6" bgcolor="#ecf0f5" class="style2">Consultation</td>
				 <td colspan="4" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong><a target="_blank" href="emrresultsviewlist.php?patientcode=<?php echo $patientcode; ?>">EMR</a></strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                </tr>
              <tr>
                <td colspan="6" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo ''; } else { echo '#AAFF00'; } ?>" class="bodytext3"><strong><?php echo $patientfirstname.' '.$patientmiddlename.' '.$patientlastname; ?> , <?php echo $age; ?> , <?php echo $gender; ?></strong></td>
              <td width="454" rowspan="16"  align="left" valign="middle" bgcolor="#ecf0f5" >
                  <iframe src="preconsultation.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcodenum; ?>&&date=<?php echo $consultationdate; ?>" width="450" height="450" frameborder="0">                  </iframe>                  </td>
			  </tr>
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>Occupation</strong></span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><lable><?php echo $occupation; ?></label>				 </td>
				 
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Residence</strong></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><lable><?php echo $address; ?></lable>                       </td>
				  </tr>
								  <input type="hidden" name="billtype" id="billtype" value="<?php echo $patienttype; ?>">
				 
				    <input name="customercode" id="customercode" value="" type="hidden">
					<input type="hidden" name="dates" id="dates" value="<?php echo $consultationdate; ?>">
					<input type="hidden" name="times" id="times" value="<?php echo $time; ?>">
				    <input type="hidden" name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly />
                   <input type="hidden" name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly />
                 
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Reg No</strong></td>
				  <td width="122" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $patientcode; ?>
				  <input type="hidden" name="consultationid" value="<?php echo $consultationcode; ?>">
				  <input type="hidden" name="codevalue" id="codevalue" value="0">
				  <input type="hidden" name="patientauto_number" value="<?php echo $patientauto_number; ?>">
				  <?php $code=$_REQUEST['visitcode']; ?>
				  <input type="hidden" name="visitcode" value="<?php echo $code; ?>">
				  <input type="hidden" name="patientfirstname" id="patientfirstname" value="<?php echo $patientfirstname; ?>" readonly /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" width="115"><span class="bodytext3"><strong>Department</strong></span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" width="113"><span class="bodytext3"><?php echo $department;?>
                      <input type="hidden" id="department" name="department" value="<?php echo $department;?>" >
                  </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>
				<tr>
				  <td width="129" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <strong>OP Visit</strong></td>
				  <td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $visitcodenum; ?>
				  <input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>"  readonly="readonly"  /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" width="108" class="bodytext3">&nbsp;</td>
				 <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>Account</strong></span></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><?php echo $res2patientaccountname; ?>
                      <input type="hidden" name="consultingdoctor" id="consultingdoctor" value="<?php echo $consultingdoctor;?>">
					   <input type="hidden" name="currenttime" value="<?php echo $currenttime; ?>">
                  </span></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>OP Date</strong></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label><?php echo $consultationdate; ?>
				    <input type="hidden" name="visitcodenum" size="20" value="<?php echo $visitcodenum; ?>">
							  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"><strong>Consultant</strong></span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                      <input type="hidden" name="consultingdoctor" id="consultingdoctor" value="<?php echo $consultingdoctor;?>">
					  <input type="hidden" name="date" id="date" value="<?php echo $curdate;?>">
                      <span class="bodytext32"><?php echo strtoupper($username);?></span></span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>
				  <input type="hidden" name="paymenttype" id="payment" value="<?php echo $res121paymenttype; ?>" readonly   size="20" />
				  <input type="hidden" name="accountname" id="accountname" value="<?php echo $res2patientaccountname; ?>" readonly   size="20" />
				 
				                      <input type="hidden" name="subtype" id="subtype"  value="<?php echo $res131subtype; ?>" >                  
				  

				<tr>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2"><strong><!--				   
				    <select name="hidden" id="visittype" >
                      <?php
				if ($visittype == '')
				{
					echo '<option value="" selected="selected">Select Visit Type</option>';
				}
				else
				{
					$query51 = "select * from master_visittype where recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51visittype = $res51["visittype"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51visittype.'" selected="selected">'.$res51visittype.'</option>';
				}
				
				$query5 = "select * from master_visittype where recordstatus = '' order by visittype";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5visittype = $res5["visittype"];
				?>
                      <option value="<?php echo $res5visittype; ?>"><?php echo $res5visittype; ?></option>
                      <?php
				}
				?>
                    </select>
-->
				  </strong>
				    <!--<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />-->
				    <label>Triage Details </label></td>
				  </tr>
				<tr>
				<td colspan="6" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo ''; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
				</tr>
				 <tr bgcolor="">
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><strong>Height</strong> </td>
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><label><?php echo $height;?>
                     <input type="hidden" name="height" id="height" value="<?php echo $height;?>" readonly size="10">
					 <input type="hidden" name="billtype" id="billtypes" value="<?php echo $res2billtype; ?>">
                   </label></td>
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><strong>Weight</strong></td>
				   <td align="left" valign="middle"  bgcolor=""><span class="bodytext32"><?php echo $weight?>
                       <input type="hidden" name="weight" id="weight" value="<?php echo $weight?>" readonly  size="10">
                   </span></td>
				   <td align="left" valign="middle"  bgcolor=""><span class="bodytext32"><strong>BMI</strong></span></td>
				   <td align="left" valign="middle"  bgcolor=""><span class="bodytext32"><?php echo $bmi?>
                       <input name="bmi" type="hidden" id="bmi"  value="<?php echo $bmi?>" onBlur="return FunctionBMI()" readonly  size="10">
                   </span></td>
			      </tr>
				  <tr bgcolor="">
				    <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><strong>Sys</strong></span> </td>
					  <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><?php echo $bpsystolic;?>
                          <input name="bpsystolic" type="hidden" id="bpsystolic"  readonly="readonly" value="<?php echo $bpsystolic;?>" onBlur="return MinimumBP()" size="10">
					  </span> </td>
					  <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><strong>Dia</strong></span>
                        <label class="bodytext32"></label></td>
					  <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><?php echo $bpdiastolic;?>
                          <input name="bpdiastolic" type="hidden" id="bpdiastolic" readonly value="<?php echo $bpdiastolic;?>"onBlur="return MaximumBP()" size="10">
					  </span></td>
					  <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><strong>Pulse</strong></span></td>
					  <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><?php echo $pulse;?>
                          <input name="pulse" type="hidden" id="pulse" readonly  value="<?php echo $pulse;?>" size="10">
                      </span></td>
			      </tr>
				 <tr bgcolor="">
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><strong>Respiration</strong></span></td>
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><?php echo $respiration;?>
                       <input name="respiration" type="hidden" value="<?php echo $respiration;?>" readonly id="respiration" size="10">
				   </span></td>
				   <td align="left" valign="middle"  bgcolor=""><label class="bodytext32"><strong>Temp-C</strong></label></td>
				   <td align="left" valign="middle"  bgcolor=""><span class="bodytext32"><?php echo number_format($celsius,2,'.','');?>
                       <input name="celsius" type="hidden" id="celsius" readonly value="<?php echo $celsius;?>" size="10">
				   </span></td>
				   <td align="left" valign="middle"  bgcolor=""><label class="bodytext32">
				    <strong>Temp-F</strong>
				   </label></td>
				   <td align="left" valign="middle"  bgcolor="">
				 
			         <label></label>
		            <label class="bodytext3"><span class="bodytext32"><?php echo $fahrenheit;?>
                    <input type="hidden" name="fahrenheit" id="fahrenheit" value="<?php echo $fahrenheit;?>" readonly  onBlur="return FunctionTemperature()" size="10">
		            </span></label></td>
		          </tr>
				 <tr bgcolor="">
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><strong>Head Cir.</strong> </span></td>
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><label><span class="bodytext32"><?php echo $headcircumference;?>
                         <input name="headcircumference" type="hidden" readonly  value="<?php echo $headcircumference;?>" id="headcircumference" size="10">
				   </span></label></td>
				   <td align="left" valign="middle"  bgcolor=""><span class="bodytext32"><strong>BSA</strong></span></td>
				   <td align="left" valign="middle"  bgcolor=""><span class="bodytext32"><?php echo $bsa;?>
                       <input name="bsa" type="hidden" id="bsa" readonly value="<?php echo $bsa;?>" size="10">
				   </span></td>
				   <td align="left" valign="middle"  class="bodytext3" bgcolor=""><a href="guidelinesentry.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcodenum;; ?>" style="text-decoration: none"><strong>Guidelines</strong></a></td>
				   <td align="left" valign="middle"  bgcolor="">&nbsp;</td>
		          </tr>
				  <?php
					
					$query45 = "select * from master_triage where patientcode = '$patientcode' and visitcode = '$visitcodenum' order by auto_number desc";
					$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num45 = mysqli_num_rows($exec45);
					$res45 = mysqli_fetch_array($exec45);
					$dm = $res45['dm'];
					if($dm == '1')
					{
					$dm = 'YES';
					}
					else
					{
					$dm = '';
					}
					$cardiac = $res45['cardiac'];
					if($cardiac == '1')
					{
					$cardiac = 'YES';
					}
					else
					{
					$cardiac = '';
					}
					$hypertension = $res45['hypertension'];
					if($hypertension == '1')
					{
					$hypertension = 'YES';
					}
					else
					{
					$hypertension = '';
					}
					$epilepsy = $res45['epilepsy'];
					if($epilepsy == '1')
					{
					$epilepsy = 'YES';
					}
					else
					{
					$epilepsy = '';
					}
					$respiratory = $res45['respiratory'];
					if($respiratory == '1')
					{
					$respiratory = 'YES';
					}
					else
					{
					$respiratory = '';
					}
					$renal = $res45['renal'];
					if($renal == '1')
					{
					$renal = 'YES';
					}
					else
					{
					$renal = '';
					}
					$none = $res45['none'];
					if($none == '1')
					{
					$none = 'YES';
					}
					else
					{
					$none = '';
					}
					$other = $res45['other'];
					$triagedate = $res45['registrationdate'];
					$triageuser = $res45['user'];
					$smoking = $res45['smoking'];
					if($smoking == '1')
					{
					$smoking = 'YES';
					}
					else
					{
					$smoking = '';
					}
					$alcohol = $res45['alcohol'];
					if($alcohol == '1')
					{
					$alcohol = 'YES';
					}
					else
					{
					$alcohol = '';
					}
					$drugs = $res45['drugs'];
					if($drugs == '1')
					{
					$drugs = 'YES';
					}
					else
					{
					$drugs = '';
					}
					$gravida = $res45['gravida'];
					$para = $res45['para'];
					$abortion = $res45['abortion'];
					$familyhistory = $res45['familyhistory'];
					$surgicalhistory = $res45['surgicalhistory'];
					$transfusionhistory = $res45['transfusionhistory'];
					?>
				 <tr bgcolor="">
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><label class="bodytext32"><strong>Food Allergy</strong></label></td>
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><?php echo $foodallergy;  ?>
				     <input type="hidden" name="foodallergy" id="foodallergy" class="bodytext32" value="<?php echo $foodallergy;  ?>" >
                   </span></td>
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32">
				  <strong>Medical History</strong>
				   </span></td>
				     <td colspan="3" align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32">
					  <?php if($dm =='YES'){ ?>
				   DM (<label style="color:red;"><?php echo $dm; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($cardiac =='YES'){ ?>
				   Cardiac (<label style="color:red;"><?php echo $cardiac; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($hypertension =='YES'){ ?>
				   Hypertension (<label style="color:red;"><?php echo $hypertension; ?></label>)&nbsp;
				   <?php } ?>
				   </span><span class="bodytext32">
				       <?php if($epilepsy =='YES'){ ?>
				   Epilepsy (<label style="color:red;"><?php echo $epilepsy; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($renal =='YES'){ ?>
				   Renal (<label style="color:red;"><?php echo $renal; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($respiratory =='YES'){ ?>
				   Respiratory (<label style="color:red;"><?php echo $respiratory; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($none =='YES'){ ?>
				   None (<label style="color:red;"><?php echo $none; ?></label>)&nbsp;
				   <?php } ?>
				   <?php if($other !=''){ ?>
				   Other (<label style="color:red;"><?php echo $other; ?></label>)
				   <?php } ?>
				   </span></td>
				   </tr>
				   <tr>
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><strong>Drug Allergy</strong></span></td>
				  
				   <td  align="left" valign="middle" <?php if($drugallergy == '') { ?> bgcolor="" <?php }else{ ?>style="border: 1px solid #FF0000 ;"<?php } ?>><span class="bodytext32"><strong><?php echo  $drugallergy; ?></strong>
                       <input type="hidden" name="drugallergy" class="bodytext32" id="drugallergy" value="<?php echo  $drugallergy; ?>">
					   <input type="hidden" name="genericname" class="bodytext32" id="genericname" value="">
                   </span></td>
				    <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><strong>Obstetrical History</strong></span></td>
				     <td colspan="3" align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32">
					  <?php if($gravida !=''){ ?>
				   Gravida (<label style="color:red;"><?php echo $gravida; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($para !=''){ ?>
				   Para (<label style="color:red;"><?php echo $para; ?></label>)&nbsp;
				   <?php } ?>
				   <?php if($abortion !=''){ ?>
				   Abortion (<label style="color:red;"><?php echo $abortion; ?></label>)&nbsp;
				   <?php } ?>
					 </span></td>
				   </tr>
				  
				 
				<tr>
				 <td align="left" valign="middle"  bgcolor=""><span class="bodytext32"><strong>Notes</strong></span></td>
				 <td align="left" valign="middle"  bgcolor=""><label class="bodytext32"><?php echo $notes; ?></label>
                 <input type="hidden" name="notes" id="notes" value="<?php echo $notes; ?>"></td>
				  <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32">
				  <strong>Surgical History</strong></span></td>
				     <td colspan="3" align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32">
					 <?php if($surgicalhistory !=''){ ?>
				   <label style="color:red;"><?php echo $surgicalhistory; ?></label>
				   <?php } ?>
					 </span></td>
			      </tr>
				   <tr>
				 <td align="left" valign="middle"  bgcolor=""><span class="bodytext32"><strong>Transfusion History</strong></span></td>
				 <td align="left" valign="middle"  bgcolor=""><label class="bodytext32">
				  <?php if($transfusionhistory !=''){ ?>
				   <label style="color:red;"><?php echo $transfusionhistory; ?></label>
				   <?php } ?></label>
                 </td>
				  <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32">
				  <strong>Intoxications</strong></span></td>
				     <td colspan="3" align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32">
					  <?php if($smoking =='YES'){ ?>
				   Smoking (<label style="color:red;"><?php echo $smoking; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($alcohol =='YES'){ ?>
				   Alcohol (<label style="color:red;"><?php echo $alcohol; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($drugs =='YES'){ ?>
				   Drugs (<label style="color:red;"><?php echo $drugs; ?></label>)&nbsp;
				   <?php } ?>
					 </span></td>
			      </tr>
				  <tr>
				   <td align="left" valign="top"  bgcolor=""><span class="bodytext32"><strong>Complaints</strong></span></td>
				   <td align="left" valign="top"  bgcolor=""><label class="bodytext32">
                       <textarea name="complanits" id="complanits" class="bodytext32"><?php echo $complanits; ?></textarea>
                   </label></td>
				    <td align="left" valign="top"  bgcolor="" class="bodytext3"><span class="bodytext32"><strong>Family History</strong></span></td>
				     <td colspan="3" align="left" valign="top"  bgcolor="" class="bodytext3"><span class="bodytext32">
					 <?php if($familyhistory !=''){ ?>
				   <label style="color:red;"><?php echo $familyhistory; ?></label>
				   <?php } ?>
					 </span></td>
			      </tr>
				 <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2">
				   Consultation 
				   <span class="bodytext32">
				   <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcHideView()"  onClick="return funcShowView()">				   </span>				   </td>
			      </tr>
				 <tr id="consltid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><textarea name="consultation"  id="consultation" cols="75"></textarea></td>
			      </tr>
				  
				  <tr id="disease">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="767" border="0" cellspacing="1" cellpadding="1">
                     <tr>
					 <td width="72" class="bodytext3"></td>
                       <td width="423" class="bodytext3">Disease</td>
                       <td class="bodytext3">Code</td>
					   <td class="bodytext3"></td>
                     </tr>
					  <tr>
					 <div id="insertrow13">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumberdisease" id="serialnumberdisease" value="1">
					  <input type="hidden" name="diseas" id="diseas" value="">
					  <td class="bodytext3">Primary</td>
				   <td width="423"> <input name="dis[]" id="dis" type="text" size="69" autocomplete="off"></td>
				      <td width="101"><input name="code[]" type="text" id="code" readonly size="8">
					  <input name="autonum" type="hidden" id="autonum" readonly size="8">
					  <input name="searchdisease1hiddentextbox" type= "hidden" id = "searchdisease1hiddentextbox" >
					  <input name="chapter[]" type="hidden" id="chapter" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem13()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
				      </table>						</td>
		        </tr>
				
				 
				  <tr id="disease1">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="769" border="0" cellspacing="1" cellpadding="1">
                     <tr>
					 <td width="72" class="bodytext3"></td>
                       <td width="425" class="bodytext3">Disease</td>
                       <td class="bodytext3">Code</td>
					   <td class="bodytext3"></td>
                     </tr>
					  <tr>
					 <div id="insertrow14">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumberdisease1" id="serialnumberdisease1" value="1">
					  <input type="hidden" name="diseas1" id="diseas1" value="">
					  <td class="bodytext3">Secondary </td>
				   <td width="425"> <input name="dis1[]" id="dis1" type="text" size="69" autocomplete="off"></td>
				      <td width="99"><input name="code1[]" type="text" id="code1" readonly size="8">
					  <input name="autonum1" type="hidden" id="autonum1" readonly size="8">
					  <input name="searchdisease1hiddentextbox1" type= "hidden" id = "searchdisease1hiddentextbox1" >
					  <input name="chapter1[]" type="hidden" id="chapter1" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem14()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
				      </table>						</td>
		        </tr>
				  
				 <tr>
				   <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td width="2" colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			      </tr>
				  
				 <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Prescription</strong> <span class="bodytext32"> <img src="images/plus1.gif" width="13" height="13"   onDblClick="return funcpresHideView()" onClick="return funcpresShowView()"> </span></td>
			      </tr>
				 <tr id="pressid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="200" class="bodytext3">Medicine Name</td>
                       <td width="48" class="bodytext3">Dose</td>
                       <td width="41" class="bodytext3">Freq</td>
                       <td width="48" class="bodytext3">Days</td>
                       <td width="48" class="bodytext3">Quantity</td>
					    <td width="48" class="bodytext3">Route</td>
                       <td width="120" class="bodytext3">Instructions</td>
                       <td class="bodytext3">Rate</td>
                       <td width="48" class="bodytext3">Amount</td>
                       <td width="42" class="bodytext3">&nbsp;</td>
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
					   <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			           <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
			
                       <td><input name="medicinename" type="text" id="medicinename" size="40" autocomplete="off">					   </td>
                       <td><input name="dose" type="text" id="dose" size="8" onKeyUp="return Functionfrequency()"></td>
                       <td>
					   <select name="frequency" id="frequency" onChange="return Functionfrequency()">
					     <?php
				if ($frequncy == '')
				{
					echo '<option value="select" selected="selected">Select frequency</option>';
				}
				else
				{
					$query51 = "select * from master_frequency where recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51code = $res51["frequencycode"];
					$res51num = $res51['frequencynumber'];
					echo '<option value="'.$res51num.'" selected="selected">'.$res51code.'</option>';
				}
				$query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5num = $res5["frequencynumber"];
				$res5code = $res5["frequencycode"];
				?>
                <option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
                 <?php
				}
				?>
               </select>				</td>	
                       <td><input name="days" type="text" id="days" size="8" onKeyUp="return Functionfrequency()" onFocus="return frequencyitem()"></td>
                       <td><input name="quantity" type="text" id="quantity" size="8" readonly></td>
					   <td><select name="route" id="route">
					   <option value="">Select Route</option>
					   <option value="Oral">Oral</option>
					   <option value="Sublingual">Sublingual</option>
					   <option value="Rectal">Rectal</option>
					   <option value="Vaginal">Vaginal</option>
					   <option value="Topical">Topical</option>
					   <option value="Intravenous">Intravenous</option>
					   <option value="Intramuscular">Intramuscular</option>
					   <option value="Subcutaneous">Subcutaneous</option>
					    <option value="Intranasal">Intranasal </option>
						<option value="Intraauditory">Intraauditory </option>
						 <option value="Eye">Eye</option>
					   </select></td>
                       <td><input name="instructions" type="text" id="instructions" size="20"></td>
                       <td width="48"><input name="rates" type="text" id="rates" readonly size="8"></td>
                       <td>
                         <input name="amount" type="text" id="amount" readonly size="8"></td>
						  <td>
						  <input name="exclude" type="hidden" id="exclude" readonly size="8">
                         <input name="formula" type="hidden" id="formula" readonly size="8"></td>
						 <td>
                         <input name="strength" type="hidden" id="strength" readonly size="8"></td>
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem()" class="button" >
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
				 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span><span class="bodytext32">
				     <input name="text" type="text" id="total" size="7" readonly>
				   </span></td>
				 </tr>
			  
				 <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><span class="style2">Lab <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcLabHideView()"  onClick="return funcLabShowView()"> </span></span></td>
			      </tr>
				  
				 <tr id="labid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				     <table width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Laboratory Test</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow1">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serial1" id="serial1" value="1"> 
					  <input type="hidden" name="serialnumber1" id="serialnumber1" value="1">
					  <input type="hidden" name="labcode" id="labcode" value="">
				      <td width="30"><input name="lab[]" id="lab" type="text" size="69" autocomplete="off"></td>
				      <td width="30"><input name="rate5[]" type="text" id="rate5" readonly size="8"></td>
					  <td><label>
                       <input type="button" name="Add1" id="Add1" value="Add" onClick="return insertitem2()" class="button" >
                       </label></td>
					   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">&nbsp;</div></td>
					   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">Urgent</div></td>
					   <td height="28" colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="urgentstatus" id="urgentstatus" type="checkbox" value="Checked" ></td>
					   </tr>
					    </table>	  </td> 
				  </tr>   
				 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span><input type="text" id="total1" readonly size="7"></td>
				  </tr> 
		        
				 <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><span class="style2">Radiology <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcRadHideView()"  onClick="return funcRadShowView()"> </span></span></td>
		        </tr>
				 <tr id="radid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Radiology Test</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow2">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber2" id="serialnumber2" value="1">
					  <input type="hidden" name="radiologycode" id="radiologycode" value="">
				   <td width="30"> <input name="radiology[]" id="radiology" type="text" size="69" autocomplete="off"></td>
				      <td width="30"><input name="rate8[]" type="text" id="rate8" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem3()" class="button">
                       </label></td>
					   </tr>
					    </table>						</td>
		        </tr>
				
				 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span><input type="text" id="total2" readonly size="7"></td>
				   </tr>
		       
				
				 <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><span class="style2">Services <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcSerHideView()" onClick="return funcSerShowView()"> </span></span></td>
		        </tr>
				 <tr id="serid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Services</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow3">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber3" id="serialnumber3" value="1">
					  <input type="hidden" name="servicescode" id="servicescode" value="">
				   <td width="30"><input name="services[]" type="text" id="services" size="69" autocomplete="off"></td>
				    <td width="30"><input name="rate3[]" type="text" id="rate3" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add3" id="Add3" value="Add" onClick="return insertitem4()" class="button">
                       </label></td>
					   </tr>
					    </table></td>
		       </tr>
				 
				 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span><input type="text" id="total3" readonly size="7"></td>
				   </tr>
		        
				 <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><span class="style2">Referral <img src="images/plus1.gif" width="13" height="13"  onDblClick="return  funcRefferalHideView()" onClick="return funcRefferalShowView()"> </span></span></td>
		        </tr>
				 <tr id="reffid">
				    <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
					
					<tr>
					 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Department</td>
					  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">
					    <select name="departmentreferal" id="departmentreferal" onChange="return insertitemr()">
                          <option value="">Select </option>
                          <?php
					  $query33 = "select * from master_department where recordstatus = ''";
					  $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					  while($res33=mysqli_fetch_array($exec33))
					  {
					  $referaldepartmentanum = $res33['auto_number'];
					  $referaldepartmentname = $res33['department'];
					  ?>
                          <option value="<?php echo $referaldepartmentanum; ?>"><?php echo $referaldepartmentname; ?></option>
                          <?php
					  }
					  ?>
                        </select>
						 <?php
					  $query33 = "select * from master_department where recordstatus = ''";
					  $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					  while($res33=mysqli_fetch_array($exec33))
					  {
					  $referaldepartmentanum = $res33['auto_number'];
					  $referaldepartmentname = $res33['department'];
					  $referalrate1 = $res33['rate1'];
					  
					   if($patienttype == 'PAY LATER')
					  {
					   $referalrate1 = $res33['rate2'];
					  }
					  ?>
                          
						  <input type="hidden" id="<?php echo "refer".$referaldepartmentanum; ?>"value="<?php echo $referalrate1; ?>">
                          <?php
					  }
					  ?>
					  </span></td>
					</tr>
                     <!--<tr>
                       <td width="30" class="bodytext3">Department</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>-->
					  <!--<tr>
					 <div id="insertrow4">					 </div></tr>
					  <tr>-->
					  <input type="hidden" name="serialnumber4" id="serialnumber4" value="1">
					  <input type="hidden" name="referalcode" id="referalcode" value="">
				   <input name="referal[]" type="hidden" id="referal" size="69" autocomplete="off">
				    <input name="rate4[]" type="hidden" id="rate4" readonly size="8">
					  <!-- <td><label>
                       <input type="button" name="Add4" id="Add4" value="Add" onClick="return insertitem5()" class="button">
                       </label></td>
					   </tr>-->
					    </table></td>
		        <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2"></span><input type="hidden" id="totalr" readonly size="7"></td></tr>
				
				  <input type="hidden" id="total5" readonly size="7">
				
				 <tr>
				 
				    <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Grand Total Amount</strong>
			        <input type="text" id="total4" readonly size="7"></td>
		        </tr> 
				<tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">IP Admit</div></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="ipadmit" id="ipadmit"  onClick="return notescheck();"></td>
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center"  id="noteslable">Notes</div></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><textarea name="ipnotes" id="ipnotes"></textarea></td>
                </tr>
				  <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">User Name </div></td>
                <td height="32" colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $_SESSION['username']; ?></td>
                </tr>
                 <tr>
				 
				 
                <td colspan="6" align="middle"  bgcolor="#ecf0f5"><div align="right" > <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="Submit222" type="submit"  value="Save Consultation" class="button"/>
                  </font></font></font></font></font></font></font></font>
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                </font></font></font></font></font></div></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>
<script language="javascript">
</script>
</td>
</tr>
</table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>