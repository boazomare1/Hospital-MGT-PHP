<?php 
session_start();
set_time_limit(0);
error_reporting(0);
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];

$curdate=date('Y-m-d');
$currenttime = date("H:i:s");
$updatedatetime = date ("d-m-Y H:i:s");
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
 

	 $docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	$res12locationanum = $res["auto_number"];
	
$patientcode=$_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];

$companyanum = $_SESSION["companyanum"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION["username"];

 
 $query6=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$result6=mysqli_fetch_array($query6);
 $planname=$result6['planname'];


 $query7=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$planname'");
$result7=mysqli_fetch_array($query7);
$exclusions=$result7['exclusions'];


$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];

  $query111 = "select * from master_consultation where patientcode='$patientcode'  order by auto_number desc";
$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$rowcount111 = mysqli_num_rows($exec111);
$res111=mysqli_fetch_array($exec111);
 $murphing=$res111['murphing'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$patientcode=$_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcodenum"];
	$timestamp = $_REQUEST['currenttime'];
	$locationcodeget=$_REQUEST['locationcodeget'];
	$locationnameget=$_REQUEST['locationnameget'];
	
	$subtypeano=$_REQUEST['subtypeano'];
	$subtypeano=trim($subtypeano);
	
	 $grandtotal1=$_REQUEST["grandtotal1"];
	  $grandtotal1=(int)preg_replace('[,]','',$grandtotal1);
   $availablelimit=$_REQUEST["availablelimit"]; 
	  $availablelimit=intval($availablelimit);
	
	$query34="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
	$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34);
	$res34=mysqli_fetch_array($exec34);
	$billingtype=$res34['billtype'];	
	$planpercentage=$res34['planpercentage'];
	$planname = $res34['planname'];
	
	$query222 = "select * from master_planname where auto_number = '$planname'";
   $exec222=mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res222=mysqli_fetch_array($exec222);
	$forall=$res222['forall'];
	
	
/*	if(($billingtype =='PAY LATER') && ($planpercentage == 0.00))
		{
		if($grandtotal1 > $availablelimit)
		{
		$pending='pending';
		}
		else
		{
		$pending='completed';
		}
		}
		else
		{
		$status='pending';
		}*/ 
		$query13r = "select approvalrequired from master_subtype where auto_number = '$subtypeano' order by subtype";
		$exec13r = mysqli_query($GLOBALS["___mysqli_ston"], $query13r) or die ("Error in Query13r".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$res13r = mysqli_fetch_array($exec13r);
		$approvalrequired = $res13r['approvalrequired'];
	
		$approvalstatus='1';
		$approvalvalue=0;

	if($billingtype =='PAY NOW')
	{
	$status='pending';
	}
	else
	{
			

		 if($approvalrequired==1 )
		{
			 $status='pending';
			 	$approvalstatus='';
				$approvalvalue=1;

			}
			else
			{
	$status='completed';
			}
			
		if(($planpercentage > 0.00 && $forall != ''))
		{
			$status='pending';
				$approvalstatus='';
				$approvalvalue=1;

			}
	}
	
	
	$query21 = "select * from master_consultation order by auto_number desc limit 0, 1";
	 $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
	$age = $res6['age'];
	
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
	$murphing = $_REQUEST["murphing"];
	$foodallergy = $_REQUEST["foodallergy"];	
	$consultation = $_REQUEST["consultation"];
	$labitems = $_REQUEST["labitems"];
	$radiologyitems = $_REQUEST["radiologyitems"];
	$serviceitems = $_REQUEST["serviceitems"];
	$refferal = isset($_REQUEST["refferal"])?$_REQUEST["refferal"]:'';
    $consultationstatus	= isset($_REQUEST["consultationstatus"])?$_REQUEST["consultationstatus"]:'';//$_REQUEST["consultationstatus"];
	$departmentreferal = $_REQUEST['departmentreferal'];
	$getdata = isset($_REQUEST["getdata"])?$_REQUEST["getdata"]:'';// $_REQUEST["getdata"];
	$filename=explode('.',basename($_SERVER['PHP_SELF']))[0];
	
	/*// $grandtotal1=$_REQUEST["grandtotal1"];
	  //$grandtotal1=intval($grandtotal1);
  $availablelimit=$_REQUEST["availablelimit"]; 
	  $availablelimit=intval($availablelimit);*/


	
	
	 $query331 = "select * from master_department where auto_number = '$departmentreferal' and recordstatus = ''";
	 $exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	 $res331 = mysqli_fetch_array($exec331);
	 $departmentreferalname = $res331['department'];
	  $rate1 = $res331['rate1'];
	  
	  $query332 = "select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
	 $exec332 = mysqli_query($GLOBALS["___mysqli_ston"], $query332) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	 $res332 = mysqli_fetch_array($exec332);
	 $consultationfees_visit = $res332['consultationfees'];
	 
					  $rate1 = $rate1;
					  if($rate1 < 0)
					  {
						  $rate1 = 0;
					  }
	 $departmentreferalrate = $rate1;

	
	  $ipaddress = $_SERVER["REMOTE_ADDR"];
	 //$urgentstatus = $_REQUEST["urgentstatus"];	
	  $urgentstatus = isset($_POST["urgentstatus"])? 1 : 0;
	//   $urgentstatus1 = $_REQUEST["urgentstatus1"];	
   $urgentstatus1 = isset($_POST["urgentstatus1"])? 1 : 0;  
   	
	 
	 
$updatedatetime = date('Y-m-d H:i:s');
	
		$query1 = "insert into master_consultationlist (patientcode,visitcode,patientfirstname,patientmiddlename,patientlastname,consultingdoctor,consultationtype,department,consultationdate,consultationtime,consultationfees,referredby,consultationremarks,visitcount,complaints,registrationdate,recordstatus,pulse,consultation,labitems,radiologyitems,serviceitems,refferal,consultationstatus,username,templatedata,date,locationname,locationcode,approval,priliminarysis,consultationicdform,formflag) 
		values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultingdoctor','$consultationtype','$department','$updatedatetime','$consultationtime','$consultationfees','$referredby','$consultationremarks','$visitcount','$complaints','$registrationdate','$recordstatus','$pulse','$consultation','$labitems','$radiologyitems','$serviceitems','$refferal','completed','$username','$getdata','$curdate','$locationnameget','$locationcodeget','$approvalvalue','$prilim','$filename',1)";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		
		$query88 = "insert into master_consultation(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,sys,dia,pulse,temp,complaint,murphing,drugallergy,foodallergy,consultationtime,locationname,locationcode,approval,consultationicdform,formflag) 
				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','completed','$currentdate','$ipaddress','$consultingdoctor','$billingtype','$accountname','pending','$bpsystolic','$bpdiastolic','$pulse','$celsius','$complaint','$murphing','$drugallergy','$foodallergy','$timestamp','$locationnameget','$locationcodeget','$approvalvalue','$filename',1)";
				$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			
		$referalquery3=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set doctorconsultation='completed' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);	
			
		
		
		$query33 = "select * from master_company where companystatus = 'Active'";
		$exec33= mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$res33 = mysqli_fetch_array($exec33);
		$refrefnoprefix = $res33['refrefnoprefix'];
		$refrefnoprefix1=strlen($refrefnoprefix);
		$query23 = "select * from consultation_referal order by auto_number desc limit 0, 1";
	    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
		$pairvar3= (int)preg_replace('[,]','',$pairs3);
		
		$referalquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_doctor where doctorname='$pairvar2'");
		$execreferal=mysqli_fetch_array($referalquery);
		$referalcode=$execreferal['doctorcode'];
		
		
		if($pairvar2!="")
		{
		$query68 = "select * from consultation_referal where patientcode='$patientcode' and patientvisitcode='$visitcode' and consultationid='$consultationid' and consultationtime = '$timestamp' and referalcode='$referalcode'";
		$exec68 = mysqli_query($GLOBALS["___mysqli_ston"], $query68) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num68 = mysqli_num_rows($exec68);
		if($num68 == 0)
		{
	
		$referalquery1="insert into consultation_referal(consultationid,patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,billtype,accountname,consultationdate,paymentstatus,refno,consultationtime,locationname,locationcode)values('$consultationid','$patientcode','$patientfullname','$visitcode','$referalcode','$pairvar2','$pairvar3','$billingtype','$accountname','$currentdate','$status','$refrefcode','$timestamp','$locationnameget','$locationcodeget')";
		$execreferalquery1=mysqli_query($GLOBALS["___mysqli_ston"], $referalquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			
		$referalquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set referalbill='pending' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		if($pairvar3 == '0.00')
		{
		if($billingtype == "PAY NOW")
		{
	    $query591 = "update consultation_referal set paymentstatus='completed' where patientvisitcode='$visitcode' and referalcode='$referalcode'";
		$exec591 = mysqli_query($GLOBALS["___mysqli_ston"], $query591) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query592 = "update master_visitentry set referalbill='completed' where visitcode='$visitcode'";
		$exec592 = mysqli_query($GLOBALS["___mysqli_ston"], $query592) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		}
		}
		}
		
		$query453 = "update consultation_departmentreferal set consultation='completed' where patientvisitcode='$visitcode'";
		$exec453 = mysqli_query($GLOBALS["___mysqli_ston"], $query453) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		if($departmentreferal != '')
		{
		$query61 = "insert into consultation_departmentreferal(consultationid,patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,billtype,accountname,consultationdate,paymentstatus,refno,consultationtime,username,locationname,locationcode)values('$consultationid','$patientcode','$patientfullname','$visitcode','$departmentreferal','$departmentreferalname','$departmentreferalrate','$billingtype','$accountname','$currentdate','$status','$refrefcode','$timestamp','$username','$locationnameget','$locationcodeget')";
		$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
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
		$exec591 = mysqli_query($GLOBALS["___mysqli_ston"], $query591) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query592 = "update master_visitentry set referalbill='completed' where visitcode='$visitcode'";
		$exec592 = mysqli_query($GLOBALS["___mysqli_ston"], $query592) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		
		$newquery=mysqli_query($GLOBALS["___mysqli_ston"], "update master_triage set consultation='completed',urgentstatus='0',complanits='$complaint' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
		$query93=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set overallpayment='',pharmacybill='',labbill='',servicebill='' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		
	
		//	
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
		
		header ("location:extreferrallist.php?patientcode=$patientcode&&st=success");
		exit;
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
 

 
 
         $query88 = "select * from master_customer where customercode ='$patientcode'";
		 $exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		 $res88 = mysqli_fetch_array($exec88);
	     $patienttype = $res88['billtype'];
		  $paymenttypenew = $res88['paymenttype'];
		
    $query2 = "select * from master_triage where patientcode = '$patientcode' and visitcode='$viscode' order by auto_number desc";//order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$res2 = mysqli_fetch_array($exec2);
		$num=mysqli_num_rows($exec2);
		if($num > 0)
		{
		$sysclr = $res2['sysclr'];
		$diaclr = $res2['diaclr'];
		$tempclr = $res2['tempclr'];
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
		$spo2 = $res2['spo2'];
		$intdrugs = $res2['intdrugs'];
		$dose = $res2['dose'];
		$route = $res2['route'];
		 $locationname = $res2["locationname"];
		 $locationcode = $res2["locationcode"];
	   
	     $res2billtype = $res2['billtype'];
		$quer=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
		$result=mysqli_fetch_array($quer);
		$patientauto_number=$result['auto_number'];
	$time=date('H-i-s');
	}
	else
	{
 $query23="select * from master_visitentry where patientcode = '$patientcode' and visitcode='$viscode'";
 $exec23=mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
 $res23=mysqli_fetch_array($exec23);
 $numm=mysqli_num_rows($exec23);

$patientfirstname = $res23['patientfirstname'];
$availablelimit=$res23['availablelimit'];
		$consultationfees  = $res23["consultationfees"];
		$billamount = $consultationfees;

//$paymenttypenew=$res23['paymenttype'];

		 $patientfirstname = strtoupper($patientfirstname);
	    $patientmiddlename = $res23['patientmiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $res23['patientlastname'];
		 $patientlastname = strtoupper($patientlastname);
		 $patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;

 $departmentname=$res23['department'];
 
 $query231="select * from master_department where auto_number='$departmentname'";
 $exec231=mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
 $res231=mysqli_fetch_array($exec231);
 $department=$res231['department'];
 
 $consultingdoctorname=$res23['consultingdoctor'];
  $query232="select * from master_doctor where auto_number='$consultingdoctorname'";
 $exec232=mysqli_query($GLOBALS["___mysqli_ston"], $query232) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
 $res232=mysqli_fetch_array($exec232);
 $consultingdoctor=$res232['doctorname'];

 $accountname=$res23['accountname'];

 $query233="select * from master_accountname where auto_number='$accountname'";
 $exec233=mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
 $res233=mysqli_fetch_array($exec233);
 
$res2patientaccountname = $res233['accountname'];
 
 $consultationdate = $res23["consultationdate"];
$visitcodenum=$viscode;
	}

$query111  = "select * from master_customer where customercode = '$patientcode'";
$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res111 = mysqli_fetch_array($exec111);
$res111paymenttype = $res111['paymenttype'];
$res111maintype = $res111['maintype'];
$res111subtype = $res111['subtype'];
$res111subtype=trim($res111subtype);
$occupation = $res111['occupation'];	 
$address = $res111['area'];  
$dob = $res111['dateofbirth'];

$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";
$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die (mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res121 = mysqli_fetch_array($exec121);
$res121paymenttype = $res121['paymenttype'];

$query131 = "select * from master_subtype where auto_number = '$res111subtype'";
$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res131 = mysqli_fetch_array($exec131);
$res131subtype = $res131['subtype'];

$query59 = "select * from master_visitentry where visitcode='$viscode'";
$exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res59 = mysqli_fetch_array($exec59);

$gender = $res59['gender'];
$consultationfeetype = $res59['consultationfees'];
$visitconsultationdate= $res59['consultationdate'];
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
	//$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error().__LINE__);
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

include ("autocompletebuild_referal.php");

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style5 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #1111EE !important; FONT-FAMILY: Tahoma;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/insertnewitem15_new1.js"></script>
<script type="text/javascript" src="js/insertreferrate_new.js"></script>
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
var totalamountrr;
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
	currenttot=Number(currenttotal4.replace(/[^0-9\.]+/g,""));
	//alert(currenttotal);
	newtotal4= currenttot-pharmamount;
	
	//alert(newtotal);
	
	document.getElementById('total').value=formatMoney(newtotal4);
	
	var currentgrandtotal4=document.getElementById('total4').value;
	
	if(document.getElementById('total1').value=='')
	{
	totalamount11=0;
	}
	else
	{
	total11=document.getElementById('total1').value;
	totalamount11=Number(total11.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount21=0;
	}
	else
	{
	total21=document.getElementById('total2').value;
	totalamount21=Number(total21.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	total31=document.getElementById('total3').value;
	totalamount31=Number(total31.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount41=0;
	}
	else
	{
	total41=document.getElementById('total5').value;
	totalamount41=Number(total41.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountrr=0;
	}
	else
	{
	totalrr=document.getElementById('totalr').value;
	totalamountrr=Number(totalrr.replace(/[^0-9\.]+/g,""));
	}
	
	var newgrandtotal4=parseFloat(newtotal4)+parseFloat(totalamount11)+parseFloat(totalamount21)+parseFloat(totalamount31)+parseFloat(totalamount41)+parseFloat(totalamountrr);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal4.toFixed(2);
	
	
}
function btnDeleteClick12(delID1)
{

	var newtotal3;
//alert(delID1.substr(4));
	var varDeleteID1 = delID1;
	//alert(varDeleteID1);
	rateid= 'rate5'+delID1.substr(4)+'';
	vrate1=parseFloat(document.getElementById(rateid).value.replace(/[^0-9\.]+/g,""));
	var fRet4; 
	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet4); 
	if (fRet4 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	var child1 = document.getElementById(varDeleteID1); //tr name
    var parent1 = document.getElementById('insertrow1'); // tbody name.
	document.getElementById ('insertrow1').removeChild(child1);
	var currenttotal3=document.getElementById('total1').value;
	var current=Number(currenttotal3.replace(/[^0-9\.]+/g,""));
	//alert(currenttotal);
	newtotal3= current-vrate1;
	//newtotal3=newtotal3	//alert(newtotal3);
	
	document.getElementById('total1').value=formatMoney(newtotal3);
	if(document.getElementById('total').value=='')
	{
	 totalamount11=0;
	//alert(totalamount11);
	}
	else
	{
	total11=document.getElementById('total').value;
	totalamount11=Number(total11.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total2').value=='')
	{
	 totalamount21=0;
	//alert(totalamount21);
	}
	else
	{
	total21=document.getElementById('total2').value;
	totalamount21=Number(total21.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	 totalamount31=0;
	//alert(totalamount31);
	}
	else
	{
	 total31=document.getElementById('total3').value;
	 totalamount31=Number(total31.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total5').value=='')
	{
	 totalamount41=0;
	//alert(totalamount41);
	}
	else
	{
	 total41=document.getElementById('total5').value;
	 totalamount41=Number(total41.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountrr=0;
	}
	else
	{
	totalrr=document.getElementById('totalr').value;
	totalamountrr=Number(totalrr.replace(/[^0-9\.]+/g,""));
	}
	
	
	newgrandtotal3=parseFloat(totalamount11)+parseFloat(newtotal3)+parseFloat(totalamount21)+parseFloat(totalamount31)+parseFloat(totalamount41)+parseFloat(totalamountrr);
	//alert(newgrandtotal3);
	document.getElementById('total4').value=formatMoney(newgrandtotal3);
	
	

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
	var current=Number(currenttotal3.replace(/[^0-9\.]+/g,""));
	//alert(currenttotal);
	newtotal3= current-vrate1;
	//newtotal3=newtotal3	//alert(newtotal3);
	
	document.getElementById('total1').value=formatMoney(newtotal3);
	if(document.getElementById('total').value=='')
	{
	 totalamount11=0;
	//alert(totalamount11);
	}
	else
	{
	total11=document.getElementById('total').value;
	totalamount11=Number(total11.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total2').value=='')
	{
	 totalamount21=0;
	//alert(totalamount21);
	}
	else
	{
	total21=document.getElementById('total2').value;
	totalamount21=Number(total21.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	 totalamount31=0;
	//alert(totalamount31);
	}
	else
	{
	 total31=document.getElementById('total3').value;
	 totalamount31=Number(total31.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total5').value=='')
	{
	 totalamount41=0;
	//alert(totalamount41);
	}
	else
	{
	 total41=document.getElementById('total5').value;
	 totalamount41=Number(total41.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountrr=0;
	}
	else
	{
	totalrr=document.getElementById('totalr').value;
	totalamountrr=Number(totalrr.replace(/[^0-9\.]+/g,""));
	}
	
	
	newgrandtotal3=parseFloat(totalamount11)+parseFloat(newtotal3)+parseFloat(totalamount21)+parseFloat(totalamount31)+parseFloat(totalamount41)+parseFloat(totalamountrr);
	//alert(newgrandtotal3);
	document.getElementById('total4').value=formatMoney(newgrandtotal3);
	
	

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
	var current=Number(currenttotal2.replace(/[^0-9\.]+/g,""));
	//alert(currenttotal);
	newtotal2= current-radrate;
	
	//alert(newtotal);
	
	document.getElementById('total2').value=formatMoney(newtotal2);
	if(document.getElementById('total').value=='')
	{
	totalamount11=0;
	}
	else
	{
	total11=document.getElementById('total').value;
	totalamount11=Number(total11.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	total21=document.getElementById('total1').value;
	totalamount21=Number(total21.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	total31=document.getElementById('total3').value;
	totalamount31=Number(total31.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount41=0;
	}
	else
	{
	total41=document.getElementById('total5').value;
	totalamount41=Number(total41.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountrr=0;
	}
	else
	{
	totalrr=document.getElementById('totalr').value;
	totalamountrr=Number(totalrr.replace(/[^0-9\.]+/g,""));
	}
	
    var newgrandtotal2=parseFloat(totalamount11)+parseFloat(totalamount21)+parseFloat(newtotal2)+parseFloat(totalamount31)+parseFloat(totalamount41)+parseFloat(totalamountrr);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=formatMoney(newgrandtotal2);
	
	
	

	
}
function btnDeleteClick3(delID3,vrate3)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal1;
	var varDeleteID3= delID3;
	var vrate3 = vrate3;
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
var current=Number(currenttotal1.replace(/[^0-9\.]+/g,""));
	//alert(currenttotal);
	newtotal1= current-vrate3;
	
	//alert(newtotal1);
	
	document.getElementById('total3').value=newtotal1;
	if(document.getElementById('total').value=='')
	{
	totalamount11=0;
	}
	else
	{
	total11=document.getElementById('total').value;
	totalamount11=Number(total11.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	total21=document.getElementById('total1').value;
	totalamount21=Number(total21.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount31=0;
	}
	else
	{
	total31=document.getElementById('total2').value;
	totalamount31=Number(total31.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount41=0;
	}
	else
	{
	total41=document.getElementById('total5').value;
	totalamount41=Number(total41.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountrr=0;
	}
	else
	{
	totalrr=document.getElementById('totalr').value;
	totalamountrr=Number(totalrr.replace(/[^0-9\.]+/g,""));
	}
	var newgrandtotal1=parseFloat(totalamount11)+parseFloat(totalamount21)+parseFloat(totalamount31)+parseFloat(newtotal1)+parseFloat(totalamount41)+parseFloat(totalamountrr);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=formatMoney(newgrandtotal1);	
	
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
	var current =Number(currenttotal.replace(/[^0-9\.]+/g,""));
	//alert(currenttotal);
	newtotal= current-vrate4;
	
	//alert(newtotal);
	
	document.getElementById('total5').value=formatMoney(newtotal);
	if(document.getElementById('total').value=='')
	{
	totalamount11=0;
	}
	else
	{
	total11=document.getElementById('total').value;
	totalamount11=Number(total11.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	total21=document.getElementById('total1').value;
	totalamount21=Number(total21.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount31=0;
	}
	else
	{
	total31=document.getElementById('total2').value;
	totalamount31=Number(total31.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount41=0;
	}
	else
	{
	total41=document.getElementById('total3').value;
	totalamount41=Number(total41.replace(/[^0-9\.]+/g,""));
	}
	
		if(document.getElementById('totalr').value=='')
	{
	totalamountr=0;
	}
	else
	{
	totalr=document.getElementById('totalr').value;
	totalamountr=Number(totalr.replace(/[^0-9\.]+/g,""));
	}
	
	var newgrandtotal=parseFloat(totalamount11)+parseFloat(totalamount21)+parseFloat(totalamountr)+parseFloat(totalamount31)+parseFloat(totalamount41)+parseFloat(newtotal);
	
//	var newgrandtotal=parseFloat(totalamount11)+parseFloat(totalamount21)+parseFloat(totalamount31)+parseFloat(totalamount41)+parseFloat(newtotal);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=formatMoney(newgrandtotal);	
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
function sertotal()
{
	var varquan = document.getElementById("serviceqty").value;
	var varquantityser =Number(varquan.replace(/[^0-9\.]+/g,""));
	
	var  varser= document.getElementById("rate3").value;
	var varserRates=Number(varser.replace(/[^0-9\.]+/g,""));
	
	var varserbase = document.getElementById("baseunit").value;
	var varserBaseunit=Number(varserbase.replace(/[^0-9\.]+/g,""));
	
	var varserqty = document.getElementById("incrqty").value;
	var varserIncrqty=Number(varserqty.replace(/[^0-9\.]+/g,""));
	
	var varinc = document.getElementById("incrrate").value;
	var varserIncrrate=Number(varinc.replace(/[^0-9\.]+/g,""));
	
	var varserSlab = document.getElementById("slab").value;
	//alert(varquantityser+varserBaseunit);
	//alert(document.getElementById("slab").value);
	if(varserSlab=='')
	{
		if(parseInt(varquantityser)==0)
		{document.getElementById("serviceamount").value=0}
		if(parseInt(varquantityser)>0)
		{
		var seram=(parseInt(varserRates)*parseInt(varquantityser)).toFixed(2);
		document.getElementById("serviceamount").value=formatMoney(seram);
		}
		}
	if(parseInt(varserSlab)==1)
	{
		if(parseInt(varquantityser)==0)
		{document.getElementById("serviceamount").value=0}
		if(parseInt(varquantityser)>0)
		{
		if(parseInt(varquantityser) <= parseInt(varserBaseunit))
		{ document.getElementById("serviceamount").value=formatMoney(varserRates);
		
			
		}
		//parseInt(varquantityser)+parseInt(varserIncrqty);
		if (parseInt(varquantityser) > parseInt(varserBaseunit))
		{
			var result11 = parseInt(varquantityser) - parseInt(varserBaseunit);
			var rem = parseInt(result11)/parseInt(varserIncrqty);
			var rem= Math.ceil(rem);
			//alert(rem);
			var resultfinal =parseInt(rem)*parseInt(varserIncrrate);//alert(resultfinal);
			var seram2=parseInt(varserRates)+parseInt(resultfinal);
			document.getElementById("serviceamount").value=formatMoney(seram2);
		}
	}
	/*var totalservi = parseFloat(varquantityser) * parseFloat(varserRates);
	document.getElementById("serviceamount").value=totalservi.toFixed(2);*/
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

	
}</script>
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
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
</head>
<script language="javascript">


function fortreatment()
{
var var2=document.getElementById("billtype").value;
if(var2!="PAY NOW")
{

	
var var1=document.getElementById("availablelimit").value;


var var111=document.getElementById("overalllimit").value;

var var12=document.getElementById("visitlimit").value;
var var110=document.getElementById("total4").value;
var var11=Number(var110.replace(/[^0-9\.]+/g,""));

;
if((var12==0 ) && (var111!=0))
{

if(parseInt(var1) <= parseInt(var11))
{
//var confirm1=confirm("Available Limit is Less than Grand Total! Do you want to proceed");
//
//if(confirm1 == false) 
//{
////window.location.reload();	
//alert("Please Delete Previous Added Item..!");
//return false;
//}
}

}
else if ((var12!=0 ) && (var111==0))
{
	
	
//	if(parseInt(var12) < parseInt(var11))
//{
//alert("Visit Limit is Less than Grand Total.. You Can't Proceed Further..! ");
//return false;	
//}
}
}
}
function formatMoney(number, places, thousand, decimal) {
	number = number || 0;
	places = !isNaN(places = Math.abs(places)) ? places : 2;
	
	thousand = thousand || ",";
	decimal = decimal || ".";
	var negative = number < 0 ? "-" : "",
	    i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
	    j = (j = i.length) > 3 ? j % 3 : 0;
	return  negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");

}


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
var varr1 = document.getElementById("rates").value;

var varr2=varr1.replace(",","");
var varr3=varr2.replace(",","");
var varr=varr3.replace(",","");
var VarRate = parseInt(varr);

var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = formatMoney(ResultAmount);
  
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
var varr=parseFloat(VarRate.replace(/[^0-9\.]+/g,""));
var ResultAmount = parseFloat(varr * ResultFrequency);
 document.getElementById("amount").value = formatMoney(ResultAmount);
}
}
function process1()
{
var content = CKEDITOR.instances.editor1.getData();
document.getElementById("getdata").value = content;
if(document.getElementById("insertrow13").childNodes.length < 2)
	{
	funcShowView();
	alert("Please Enter the primary disease");
	 document.getElementById("dis").focus();
		return false;
	}

}
function toredirect()
{ 
var content = CKEDITOR.instances.editor1.getData();
document.getElementById("getdata").value = content;
//alert(content);
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
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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
    
	//funcRefferalHideView();
	//funcExRefferalHideView();
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
 
	funcCustomerDropDownSearch7();//To handle ajax dropdown list..
	funcOnLoadBodyFunctionCall1();
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
function funcsickleavehide()
{
	if (document.getElementById("sickleaveid") != null) 
	{
	document.getElementById("sickleaveid").style.display = 'none';
	}		
	
	
}
function funcsickleavehideview()
{
	if (document.getElementById("sickleaveid") != null) 
	{
	document.getElementById("sickleaveid").style.display = '';
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

function funcExRefferalShowView()
{
  if (document.getElementById("exreffid") != null) 
     {
	 document.getElementById("exreffid").style.display = 'none';
	}
	if (document.getElementById("exreffid") != null) 
	  {
	  document.getElementById("exreffid").style.display = '';
	 }
	 if (document.getElementById("exreffid1") != null) 
     {
	 document.getElementById("exreffid1").style.display = 'none';
	}
	if (document.getElementById("exreffid1") != null) 
	  {
	  document.getElementById("exreffid1").style.display = '';
	 }
}
	
function funcExRefferalHideView()
{		
 if (document.getElementById("exreffid") != null) 
	{
	document.getElementById("exreffid").style.display = 'none';
	}		
	if (document.getElementById("exreffid1") != null) 
	{
	document.getElementById("exreffid1").style.display = 'none';
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
function sertotal()
{
	var varquantityser = document.getElementById("serviceqty").value;
	var varserRate = document.getElementById("rate3").value;
	var varserBaseunit = document.getElementById("baseunit").value;
	
	var varserIncrqty = document.getElementById("incrqty").value;
	
	var varserIncrrate = document.getElementById("incrrate").value;
	
	var varserSlab = document.getElementById("slab").value;
	//alert(varquantityser+varserBaseunit);
	//alert(document.getElementById("slab").value);
	var varser=varserRate.replace(",","");
	var varser2=varser.replace(",","");
	var varserRates =parseInt(varser2);
//	var varser2=parseInt(varser);
	//alert (varser2);
	if(varserSlab=='')
	{
		if(parseInt(varquantityser)==0)
		{document.getElementById("serviceamount").value=0}
		if(parseInt(varquantityser)>0)
		{
		var seram=(parseInt(varserRates)*parseInt(varquantityser));
		document.getElementById("serviceamount").value = formatMoney(seram);
		}
		}
	if(parseInt(varserSlab)==1)
	{
		if(parseInt(varquantityser)==0)
		{document.getElementById("serviceamount").value=0}
		if(parseInt(varquantityser)>0)
		{
		if(parseInt(varquantityser) <= parseInt(varserBaseunit))
		{ document.getElementById("serviceamount").value=formatMoney(varserRates);
		
			
		}
		//parseInt(varquantityser)+parseInt(varserIncrqty);
		if (parseInt(varquantityser) > parseInt(varserBaseunit))
		{
			var result11 = parseInt(varquantityser) - parseInt(varserBaseunit);
			var rem = parseInt(result11)/parseInt(varserIncrqty);
			var rem= Math.ceil(rem);
			//alert(rem);
			var resultfinal =parseInt(rem)*parseInt(varserIncrrate);//alert(resultfinal);
			var seram=parseInt(varserRates)+parseInt(resultfinal);
			document.getElementById("serviceamount").value=formatMoney(seram);
		}
	}
	/*var totalservi = parseFloat(varquantityser) * parseFloat(varserRates);
	document.getElementById("serviceamount").value=totalservi.toFixed(2);*/
}
}
function shortcodes()
{

var instructions = document.getElementById("instructions").value;
instructions = instructions.toUpperCase();
var shortcode = instructions.substr(0,3);
if(shortcode == 'AC ')
{
var fullcode = "Before Meals ";
}
else if(shortcode == 'HS ')
{
var fullcode = "At Bedtime ";
}
else if(shortcode == "PC ")
{
var fullcode = "After Meals ";
}
else if(shortcode == "INT")
{
var fullcode = "Between Meals ";
}
else
{
var fullcode = instructions;
}
document.getElementById("instructions").value = fullcode;
}




</script>
<?php
	$query21 = "select * from master_consultation order by auto_number desc limit 0, 1";
	 $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
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


<?php include ("js/dropdownlist1scriptingreferal.php"); ?>
<script type="text/javascript" src="js/autocomplete_referal.js"></script>
<script type="text/javascript" src="js/autosuggestreferal1.js"></script>
<script type="text/javascript" src="js/autoreferalcodesearch12_new.js"></script>



<?php
				
				$query41 = "select * from master_employee where username='$username'";
				$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				$res41 = mysqli_fetch_array($exec41);
		 $employeename = $res41['employeename'];
				?>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script src="js/datetimepicker_css.js"></script>


<script type="text/javascript">
function numbervaild(key)
{
	var keycode = (key.which) ? key.which : key.keyCode;

	 if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))
	{
		return false;
	}
}
function labFunction() {
var subtype = document.getElementById("subtypeano").value;
    var myWindow = window.open("addlabtest.php?subtype="+subtype, "MsgWindow" ,'width='+screen.availWidth+',height='+screen.availHeight+',toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=1,resizable=1,left=0,top=0','fullscreen');
    //myWindow.document.write("<p>This is 'MsgWindow'. I am 200px wide and 100px tall!</p>");
	if (myWindow) {
       myWindow.onclose = function () { alert("close window"); }
	}
}

</script>
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
     <form name="form1" id="form1" method="post" action="consultationreferral.php"   onKeyDown="return disableEnterKey(event)">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="103%"><table   border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td colspan="4" bgcolor="#ecf0f5" class="style2">Consultation Referral </td>
                <td bgcolor="#ecf0f5" colspan="2"  class="style2">Location:&nbsp;&nbsp; <?php echo $locationname ?></td>
                <input type="hidden" name="locationnameget" id="locationname" value="<?php echo $locationname;?>">
                <input type="hidden" name="locationcodeget" id="locationcode" value="<?php echo $locationcode;?>">
				<input type="hidden" name="subtypeano" id="subtypeano" value="<?php echo $res111subtype;?>">
				
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                </tr>
              <tr>
                <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo ''; } else { echo '#AAFF00'; } ?>" class="bodytext3"><strong>
				
				<?php 
					
				
				$get_curreny_query=mysqli_query($GLOBALS["___mysqli_ston"], "select currency from master_subtype where auto_number='$res111subtype' ");
				$res_currency=mysqli_fetch_array($get_curreny_query);
				$currency_name=$res_currency['currency'];
				
				echo $patientfirstname.' '.$patientmiddlename.' '.$patientlastname; ?> , <?php echo $age; ?> , <?php echo $gender; ?></strong> 
			</td>
			<td class="bodytext3" colspan="2">				
				<span style="font-size:18px;font-weight:bold;color:red;"> <?= "(".ucwords(strtolower($currency_name))." Patient)" ?> </span> </td>
             
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
                                  <input type="hidden" name="paymenttypenew" id="paymenttypenew" value="<?php echo $paymenttypenew;?>">
				 
				    <input name="customercode" id="customercode" value="" type="hidden">
					<input type="hidden" name="dates" id="dates" value="<?php echo $consultationdate; ?>">
					<input type="hidden" name="times" id="times" value="<?php echo $time; ?>">
					<input type="hidden" name="consultationfeetype" id="consultationfeetype" value="<?php echo $consultationfeetype; ?>">
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
                   <?php 
				   $availablelimit1=0;
				   $consultationfees=0;
				   $planfixedamount=0;
				   $visitlimit1=0;
				   $overalllimit1=0;
				  $query223="select * from master_visitentry where patientcode = '$patientcode' and visitcode='$viscode'";
					$exec223=mysqli_query($GLOBALS["___mysqli_ston"], $query223) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
					$res223=mysqli_fetch_array($exec223);
					 mysqli_num_rows($exec223);
					 
				   $availablelimit1=$res223['availablelimit'];
				   $overalllimit1=$res223['overalllimit'];
				   
				   $planname=$res223['planname'];
				   $consultationfees=$res223['consultationfees'];
				   
				   //$availableilimit = 
				   $query222 = "select * from master_planname where auto_number = '$planname'";
				   $exec222=mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
					$res222=mysqli_fetch_array($exec222);
					$planfixedamount=$res222['planfixedamount'];
					$visitlimit1=$res222['opvisitlimit'];
				  // echo $planfixedamount;
				   $availablelimit=$availablelimit1+$planfixedamount-($consultationfees);
				   if($patienttype!="PAY NOW")
				   {
				   ?>
                   
                   <input size="10" type="hidden" name="availablelimit" id="availablelimit"  value="<?php echo $availablelimit; ?>" >
                   <input size="10" type="hidden" name="overalllimit" id="overalllimit"  value="<?php echo $overalllimit1; ?>" >
                   <?php if($visitlimit1==0){ ?>
                   <td width="300" align="left" valign="top"  bgcolor=""><span class="bodytext32"><strong>Available limit:</strong></span>
                   <input size="8" type="text" name="availablelimit100" id="availablelimit100"  value="<?php echo number_format($availablelimit, 2, '.', ','); ?>" disabled >
				    </td>
                   <?php } ?>
                  
                   <td width="300" align="left" valign="top"  bgcolor=""><span class="bodytext32"><strong>Visit limit:</strong></span>
                   <input size="10" type="hidden" name="visitlimit" id="visitlimit"  value="<?php echo $visitlimit1; ?>" >
                   <input size="8" type="text" name="visitlimit12" id="visitlimit12"  value="<?php echo number_format($visitlimit1, 2, '.', ','); ?>" disabled >
                   </td>
                   <?php
				   }
				  ?>
			      </tr>
				
				  
				 
		       
				
				 
		        
				 <tr>
				 <!--  <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"   onDblClick="return  funcRefferalHideView()" onClick="return funcRefferalShowView()"><span class="bodytext32"><span class="style2">Referral <img src="images/plus1.gif" width="13" height="13"  onDblClick="return  funcRefferalHideView()" onClick="return funcRefferalShowView()"> </span></span></td>
		        </tr>
				 <tr id="reffid">
				    <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
					
					<tr>
					 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Department</td>
					  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">
					    <select name="departmentreferal" id="departmentreferal" onChange="( insertitemr(),  fortreatment())">
                          <option value="">Select </option>
                          <?php
					  $query33 = "select * from master_department where recordstatus = '' AND locationcode = '".$locationcode."'";
					  $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
					  while($res33=mysqli_fetch_array($exec33))
					  {
					  $referaldepartmentanum = $res33['auto_number'];
					  $referaldepartmentname = $res33['department'];
					  $referalrate1 = $res33['rate1'];
					  $referalrate1 = $referalrate1-$consultationfees;
					  if($referalrate1 < 0)
					  {
						  $referalrate1 = 0;
					  }
					  ?>
                          <option value="<?php echo $referaldepartmentanum; ?>"><?php echo $referaldepartmentname; ?></option>
						  
                          <?php
					  }
					  ?>
                        </select>
						 <?php
					  $query33 = "select * from master_department where recordstatus = '' AND locationcode = '".$locationcode."'";
					  $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
					  while($res33=mysqli_fetch_array($exec33))
					  {
					  $referaldepartmentanum = $res33['auto_number'];
					  $referaldepartmentname = $res33['department'];
					  $referalrate1 = $res33['rate1'];
					  $referalrate1 = $referalrate1;
					  if($referalrate1 < 0)
					  {
						  $referalrate1 = 0;
					  }
					  ?>
                          
						  <input type="hidden" id="<?php echo "refer".$referaldepartmentanum; ?>"value="<?php echo number_format($referalrate1,2); ?>">
                          <?php
					  }
					  ?>
					  </span></td>
					  
				    
                  
					    </table></td>
						 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span>
                   <input type="text" id="totalr" readonly size="7">
                  <!-- <input type="hidden" id="tr" readonly size="7">
                   </td></tr>-->
				  
		       
				  <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"  onDblClick="return  funcExRefferalHideView()" onClick="return funcExRefferalShowView()"><span class="bodytext32"><span class="style2">External Referral <img src="images/plus1.gif" width="13" height="13"  onDblClick="return  funcExRefferalHideView()" onClick="return funcExRefferalShowView()"> </span></span></td>
		        </tr>
				<tr id="exreffid">
				 <td colspan="8" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				 
				 <!--<a target="_blank" href="appointmentscheduleentry.php?patientcode=<?php echo $patientcode; ?>">Special Clinic Appointment</a> -->
				 
				 </td>
				</tr>
				 <tr id="exreffid1">
				    <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="417" border="0" cellspacing="1" cellpadding="1">
					  <tr>
                       <td width="284" class="bodytext3">Department</td>
					   <td width="284" class="bodytext3">Doctor</td>
                       <td width="284" class="bodytext3">Type</td>
                       <td width="48" class="bodytext3">Rate</td>
                       <td width="75" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow4">					 </div></tr>

					  <tr>
					  <td>
                        <select name="department" id="department" onChange="return funcDepartmentChange()"></select>
					  </td>
					  <td>
					  <input type="hidden" name="serialnumber4" id="serialnumber4" value="1">
					  <input type="hidden" name="referalcode" id="referalcode" value="">
				   	  <input name="referal[]" type="text" id="referal" size="40" autocomplete="off"></td>
				      <td><input name="rate4[]" type="text" id="rate4" size="8" readonly></td>
					   
                     <td>  <input type="button" name="Add4" id="Add4" value="Add" onClick="(insertitem5(),fortreatment())" class="button">
                      </td>
					   </tr>
				      </table></td></tr>
						 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span>
				  <input type="text" id="total5" readonly size="7">
            <!--      <input type="hidden" id="t6" readonly size="7">-->
                  </td></tr>
				          
						
				
	
				 <tr>
				 
				    <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong></strong>
			        <input type="hidden" id="total4" name="grandtotal1" readonly size="7">
                   <!-- <input type="hidden" id="gt" name="grandtotal1" readonly size="7">-->
                    </td>
		        </tr> 
				
				  <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">User Name </div></td>
                <td height="32" colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $_SESSION['username']; ?></td>
                </tr>
                 <tr>
				 
				 
                <td colspan="6" align="middle"  bgcolor="#ecf0f5"><div align="right" > <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="Submit222" type="submit"  value="Save Consultation (Alt+S)" accesskey="s" class="button"  onClick="return fortreatment()" />
                </font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font>
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
