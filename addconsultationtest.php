<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

error_reporting(0);
$curdate=date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$patientcode=$_REQUEST["patientcode"];
	$query34="select * from master_visitentry where patientcode='$patientcode'";
	$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34);
	$res34=mysqli_fetch_array($exec34);
	$billingtype=$res34['billtype'];
	if($billingtype =='PAY NOW')
	{
	$status='pending';
	}
	else
	{
	$status='completed';
	}
	$consultationid=$_REQUEST["consultationid"];
	$visitcode = $_REQUEST["visitcodenum"];
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
$currentdate=$_REQUEST['date'];
$times=$_REQUEST['times'];
	$consultationtime  = $_REQUEST["consultationtime"];
	$consultationfees  = $_REQUEST["consultationfees"];
	$referredby = $_REQUEST["referredby"];
	$consultationremarks = $_REQUEST["consultationremarks"];
	$complaint = $_REQUEST["complanits"];
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
	$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
	
    $query2 = "select * from master_triage where auto_number= '$autonumber'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec2);
	$res1patientcode = $res1["patientcode"];
	$res1visitcount = $res1["visitcount"];
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
		
        $query1 = "insert into master_consultationlist (patientcode,patientfirstname,patientmiddlename,patientlastname,consultingdoctor,consultationtype,department,consultationdate,consultationtime,consultationfees,referredby,consultationremarks,visitcount,complaints,registrationdate,recordstatus,pulse,consultation,labitems,radiologyitems,serviceitems,refferal,consultationstatus) 
		values('$patientcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultingdoctor','$consultationtype','$department','$currentdate','$consultationtime','$consultationfees','$referredby','$consultationremarks','$visitcount','$complaints','$registrationdate','$recordstatus','$pulse','$consultation','$labitems','$radiologyitems','$serviceitems','$refferal','completed')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
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
		
		$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_radiology where itemname='$pairvar'");
		$execradiology=mysqli_fetch_array($radiologyquery);
		$radiologycode=$execradiology['itemcode'];
		
		
		if($pairvar!="")
		{
		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_radiology(consultationid,patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billtype,accountname,consultationdate,paymentstatus,refno,resultentry)values('$consultationid','$patientcode','$patientfullname','$visitcode','$radiologycode','$pairvar','$pairvar1','$billingtype','$accountname','$currentdate','$status','$radrefcode','pending')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
		    //echo '<br>'.$i;
			//echo '<br>'.
			//$autonumber = $_REQUEST['autonumber'.$p];	
			//echo '<br>'.
		    $medicinename = $_REQUEST['medicinename'.$p];
			$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
			$res77=mysqli_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			$dose = $_REQUEST['dose'.$p];
		    $frequency = $_REQUEST['frequency'.$p];
			$sele=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_frequency where frequencycode='$frequency'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress=mysqli_fetch_array($sele);
			$frequencyautonumber=$ress['auto_number'];
			$frequencycode=$ress['frequencycode'];
			$frequencynumber=$ress['frequencynumber'];
			$days = $_REQUEST['days'.$p];
			$quantity = $_REQUEST['quantity'.$p];
			$instructions = $_REQUEST['instructions'.$p];
			$rate = $_REQUEST['rate'.$p];
			$amount = $_REQUEST['amount'.$p];
			
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
		        //echo '<br>'. 
		        $query2 = "insert into master_consultationpharm(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,pharmacybill,medicineissue) 
				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$currentdate','$ipaddress','$consultingdoctor','$billingtype','$accountname','pending','$medicinecode','$pharefcode','$status','pending')";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$query29 = "insert into master_consultationpharmissue(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno) 
				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$currentdate','$ipaddress','$consultingdoctor','$billingtype','$accountname','$status','$medicinecode','$pharefcode')";
				$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				
				$newquery=mysqli_query($GLOBALS["___mysqli_ston"], "update master_triage set consultation='completed' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					
			}
		
		}
		$query88 = "insert into master_consultation(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,sys,dia,pulse,temp,complaint,drugallergy,foodallergy) 
				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','completed','$currentdate','$ipaddress','$consultingdoctor','$billingtype','$accountname','pending','$bpsystolic','$bpdiastolic','$pulse','$celsius','$complaint','$drugallergy','$foodallergy')";
				$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
			$query93=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set overallpayment='' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
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
	
			
		foreach($_POST['lab'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$labname=$_POST['lab'][$key];
		$labquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_lab where itemname='$labname'");
		$execlab=mysqli_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate5'][$key];
		
		if($labname!="")
		{
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_lab(consultationid,patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billtype,accountname,consultationdate,paymentstatus,refno,labsamplecoll,resultentry)values('$consultationid','$patientcode','$patientfullname','$visitcode','$labcode','$labname','$labrate','$billingtype','$accountname','$currentdate','$status','$labrefcode','pending','pending')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
		$servicequery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_services where itemname='$servicesname'");
		$execservice=mysqli_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		
		$servicesrate=$_POST["rate3"][$key];
		
		if($servicesname!="")
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_services(consultationid,patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,billtype,accountname,consultationdate,paymentstatus,refno,process)values('$consultationid','$patientcode','$patientfullname','$visitcode','$servicescode','$servicesname','$servicesrate','$billingtype','$accountname','$currentdate','$status','$serrefcode','pending')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_referal(consultationid,patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,billtype,accountname,consultationdate,paymentstatus,refno)values('$consultationid','$patientcode','$patientfullname','$visitcode','$referalcode','$pairvar2','$pairvar3','$billingtype','$accountname','$currentdate','pending','$refrefcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$referalquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set referalbill='pending' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		
		
		$newquery1=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set doctorconsultation='completed' where visitcode='$visitcode'");
		
		
			
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
		
		header ("location:consultationlist1.php?patientcode=$patientcode&&st=success");
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
    $query2 = "select * from master_triage where patientcode = '$patientcode' and visitcode='$viscode'";//order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
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
include ("autocompletebuild_labcategory.php");
include ("autocompletebuild_lab1.php");
include ("autocompletebuild_radiology1.php");
include ("autocompletebuild_services1.php");
include ("autocompletebuild_referal.php");
include ("autocompletebuild_medicine11.php");
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

<script type="text/javascript" src="js/deletescriptingconsultation.js"></script>
<script language="javascript">

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
var VarRate = document.getElementById("rate").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
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
    funcHideView();
	funcpresHideView();
	funcLabHideView();
	funcRadHideView();
	funcSerHideView();
	funcRefferalHideView();
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
	funcCustomerDropDownSearch8();
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
  if (document.getElementById("consltid") != null) 
     {
	 document.getElementById("consltid").style.display = 'none';
	}
	if (document.getElementById("consltid") != null) 
	  {
	  document.getElementById("consltid").style.display = '';
	 }
}
function funcHideView()
{		
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
	 if (document.getElementById("labcategoryid") != null) 
	 {
	document.getElementById("labcategoryid").style.display = '';
	}
}
	
function funcLabHideView()
{	
 if (document.getElementById("labid") != null) 
	{
	document.getElementById("labid").style.display = 'none';
	}			
	 if (document.getElementById("labcategoryid") != null) 
	 {
	document.getElementById("labcategoryid").style.display = 'none';
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

<?php include ("js/dropdownlist1scriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestmedicine1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_medicine1.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch2.js"></script>

<?php include("js/dropdownlist1scriptingcategorylab.php"); ?>
<script type="text/javascript" src="js/autocomplete_categorylab1.js"></script>
<script type="text/javascript" src="js/autosuggestcategorylab1.js"></script>
<script type="text/javascript" src="js/autocategorylabcodesearch2.js"></script> 

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


      	  <form name="form1" id="form1" method="post" action="addconsultationtest.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1();">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="103%"><table   border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td colspan="6" bgcolor="#ecf0f5" class="style2">Consultation</td>
				 <td colspan="4" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>EMR</strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                </tr>
              <tr>
                <td colspan="6" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo ''; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
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
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext3"><strong>Patient Name</strong>
				  <input type="hidden" name="billtype" value="<?php echo $billtype; ?>">
				    <input name="customercode" id="customercode" value="" type="hidden">
					<input type="hidden" name="dates" id="dates" value="<?php echo $consultationdate; ?>">
					<input type="hidden" name="times" id="times" value="<?php echo $time; ?>">
				  </span></td>
				  <td colspan="2" align="left" valign="middle" bgcolor="#ecf0f5"><span class="bodytext3"><?php echo $patientfirstname.' '.$patientmiddlename.' '.$patientlastname; ?></span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Department</strong>
                      <input type="hidden" name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly />
                  </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext3"><?php echo $department;?>
                      <input type="hidden" name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly />
                  </span></td>
				  <td width="110" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Reg No</strong></td>
				  <td width="122" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $patientcode; ?>
				  <input type="hidden" name="consultationid" value="<?php echo $consultationcode; ?>">
				  <input type="hidden" name="patientauto_number" value="<?php echo $patientauto_number; ?>">
				  <?php $code=$_REQUEST['visitcode']; ?>
				  <input type="hidden" name="visitcode" value="<?php echo $code; ?>">
				  <input type="hidden" name="patientfirstname" id="patientfirstname" value="<?php echo $patientfirstname; ?>" readonly /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" width="115"><span class="bodytext3"><strong>Consulting Doctor</strong></span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" width="113"><span class="bodytext3"><?php echo $consultingdoctor;?>
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
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><?php echo $res2patientaccountname; ?>
                      <input type="hidden" name="consultingdoctor" id="consultingdoctor" value="<?php echo $consultingdoctor;?>">
                  </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td> </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>OP Date</strong></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label><?php echo $consultationdate; ?>
				    <input type="hidden" name="visitcodenum" size="20" value="<?php echo $visitcodenum; ?>">
							  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>Consultation Date</strong></span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><?php echo $curdate; ?>
                      <input type="hidden" name="consultingdoctor" id="consultingdoctor" value="<?php echo $consultingdoctor;?>">
					  <input type="hidden" name="date" id="date" value="<?php echo $curdate;?>">
                  </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"> </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="hidden" name="consultationtime" id="consultationtime" value="<?php echo $consultationtime; ?>" readonly   size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext3"><strong>
				    <input type="hidden" name="accountname" id="accountname"  value="<?php echo $res2patientaccountname; ?>" >
				  </strong></span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"></td>
			      </tr>
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
					 <input type="hidden" name="billtype" value="<?php echo $res2billtype; ?>">
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
				   <td align="left" valign="middle"  bgcolor=""><span class="bodytext32"><?php echo $celsius;?>
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
				   <td align="left" valign="middle"  bgcolor="">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="">&nbsp;</td>
		          </tr>
				 <tr bgcolor="">
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><label class="bodytext32"><strong>Food Allergy</strong></label></td>
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><?php echo $foodallergy;  ?>
				     <input type="hidden" name="foodallergy" id="foodallergy" class="bodytext32" value="<?php echo $foodallergy;  ?>" >
                   </span></td>
				   </tr>
				   <tr>
				   <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><strong>Drug Allergy</strong></span></td>
				   <td align="left" valign="middle"  bgcolor=""><span class="bodytext32"><?php echo  $drugallergy; ?>
                       <input type="hidden" name="drugallergy" class="bodytext32" id="drugallergy" value="<?php echo  $drugallergy; ?>">
                   </span></td>
				   </tr>
				   <tr>
				   <td align="left" valign="middle"  bgcolor=""><span class="bodytext32"><strong>Complaints</strong></span></td>
				   <td align="left" valign="middle"  bgcolor=""><label class="bodytext32"><?php echo $complanits; ?>
                       <input type="hidden" name="complanits" id="complanits" class="bodytext32" value="<?php echo $complanits; ?>">
                   </label></td>
			      </tr>
				 
				 <tr>
				  <td align="left" valign="middle"  bgcolor="">&nbsp;</td>
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
                       <td width="150" class="bodytext3">Medicine Name</td>
                       <td width="48" class="bodytext3">Dose</td>
                       <td width="41" class="bodytext3">Freq</td>
                       <td width="48" class="bodytext3">Days</td>
                       <td width="48" class="bodytext3">Quantity</td>
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
                       <td><input name="medicinename" type="text" id="medicinename" size="25" autocomplete="off"></td>
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
				$res5num = $res5["auto_number"];
				$res5code = $res5["frequencycode"];
				?>
                <option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
                 <?php
				}
				?>
               </select>				</td>	
                       <td><input name="days" type="text" id="days" size="8" onKeyUp="return Functionfrequency()" onFocus="return frequencyitem()"></td>
                       <td><input name="quantity" type="text" id="quantity" size="8" readonly></td>
                       <td><input name="instructions" type="text" id="instructions" size="20"></td>
                       <td width="48"><input name="rate" type="text" id="rate" readonly size="8"></td>
                       <td>
                         <input name="amount" type="text" id="amount" readonly size="8"></td>
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem1()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
				 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span><input type="text" id="total" readonly size="7"></td>
			      </tr>
			  
				 <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><span class="style2">Lab <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcLabHideView()"  onClick="return funcLabShowView()"> </span></span></td>
			      </tr>
				  <tr id="labcategoryid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				     <table width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Lab Category</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow33">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber8" id="serialnumber8" value="1">
					  <input type="hidden" name="categorylabcode" id="categorylabcode" value="">
				      <td width="30"><input name="categorylab[]" id="categorylab" type="text" size="69" autocomplete="off" ></td>
				      <td width="30"><input name="categoryrate5[]" type="text" id="categoryrate5" readonly size="8"></td>
					  <td><label>
                       <input type="button" name="Add33" id="Add33" value="Add" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table>	  </td> 
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
					  <input type="hidden" name="serialnumber8" id="serialnumber8" value="1">
					  <input type="hidden" name="labcode" id="labcode" value="">
				      <td width="30"><input name="lab[]" id="lab" type="text" size="69" autocomplete="off" ></td>
				      <td width="30"><input name="rate5[]" type="text" id="rate5" readonly size="8"></td>
					  <td><label>
                       <input type="button" name="Add1" id="Add1" value="Add" onClick="return insertitem22()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table>	  </td> 
				  </tr>   
				 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span><input type="text" id="total97" readonly size="7"></td>
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
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem3()" class="button" style="border: 1px solid #001E6A">
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
				   <td width="30"><input name="services[]" type="text" id="services" size="69"></td>
				    <td width="30"><input name="rate3[]" type="text" id="rate3" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add3" id="Add3" value="Add" onClick="return insertitem4()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table></td>
		       </tr>
				 
				 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span><input type="text" id="total3" readonly size="7"></td>
				   </tr>
		        
				 <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><span class="style2">Referrel <img src="images/plus1.gif" width="13" height="13"  onDblClick="return  funcRefferalHideView()" onClick="return funcRefferalShowView()"> </span></span></td>
		        </tr>
				 <tr id="reffid">
				    <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Department</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow4">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber4" id="serialnumber4" value="1">
					  <input type="hidden" name="referalcode" id="referalcode" value="">
				   <td width="30"><input name="referal[]" type="text" id="referal" size="69"></td>
				    <td width="30"><input name="rate4[]" type="text" id="rate4" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add4" id="Add4" value="Add" onClick="return insertitem5()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table></td>
		        </tr>
				 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span><input type="text" id="total5" readonly size="7"></td>
				    <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"></td>
		        </tr>
				
				 <tr>
				 
				    <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Grand Total Amount</strong>
			        <input type="text" id="total4" readonly size="7"></td>
		        </tr> 
				  <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">User Name </div></td>
                <td height="32" colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="user" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>"></td>
                </tr>
                 <tr>
				 
				 
                <td colspan="6" align="middle"  bgcolor="#ecf0f5"><div align="right" > <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="Submit222" type="submit"  value="Save Consultation" class="button" style="border: 1px solid #001E6A"/>
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