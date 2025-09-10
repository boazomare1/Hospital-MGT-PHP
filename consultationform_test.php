<?php 

ob_start();

session_start();

set_time_limit(0);

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



    if(isset($_REQUEST['mcc']) && $_REQUEST['mcc']!='' && $_REQUEST['subtyp_mcc']==1)

	   $mcc=$_REQUEST['mcc'];

	else

		$mcc='';

	

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

	$accountnameano = $res34['accountname'];

	

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

	 	if($approvalrequired=='1')
		{
		 	$status='pending';
		 	$approvalstatus='';
			$approvalvalue=1;
		}
		else
		{
        $status='completed';
		}  

		/*if($accountnameano==194 || $subtypeano==0 || $subtypeano==0)
	  	{
			$status='pending';
			$approvalstatus='';
			$approvalvalue=1;
		}*/

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

	$refferal = $_REQUEST["refferal"];

    $consultationstatus	= $_REQUEST["consultationstatus"];

	$departmentreferal = $_REQUEST['departmentreferal'];

	$getdata = $_REQUEST["getdata"];

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

	 

					  $rate1 = $rate1-$consultationfees_visit;

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

   	

	  $ipadmit = isset($_POST["ipadmit"])? 1 : 0;

	  $ipnotes = $_REQUEST['ipnotes'];

	  $ipnotes = addslashes($ipnotes);

	  if($ipadmit == 1)

	  {

	  $query67 = "insert into consultation_ipadmission(patientcode,patientname,visitcode,accountname,admissiondoctor,username,ipaddress,companyanum,notes,status,locationname,locationcode)values('$patientcode','$patientfullname','$visitcode','$accountname','$consultingdoctor','$username','$ipaddress','$companyanum','$ipnotes','pending','$locationnameget','$locationcodeget')";

	  $exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67);

	  

	  $query877 = "update master_triage set ipconvert='yes' where patientcode='$patientcode' and visitcode='$visitcode'";

	  $exec877 = mysqli_query($GLOBALS["___mysqli_ston"], $query877) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	  }

	 

$updatedatetime = date('Y-m-d H:i:s');

	

  $query2 = "select * from master_triage where auto_number= '$autonumber'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	$res1 = mysqli_fetch_array($exec2);

	$res1patientcode = $res1["patientcode"];

	$res1visitcount = $res1["visitcount"];

	$res1notes = $res1['notes'];

	

	$res2 = mysqli_num_rows($exec2);

	if ($res2 == 0)

	{

		$query3 = "select * from master_triage where recordstatus = ''";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$rowcount3 = mysqli_num_rows($exec3);

		if ($rowcount3 != 0)

		{

			foreach($_POST['dis2'] as $key=>$value)

		{

		$priliminary = $_POST['dis2'][$key];

		$prilim = $priliminary;

		}

			

		

       $query1 = "insert into master_consultationlist (patientcode,visitcode,patientfirstname,patientmiddlename,patientlastname,consultingdoctor,consultationtype,department,consultationdate,consultationtime,consultationfees,referredby,consultationremarks,visitcount,complaints,registrationdate,recordstatus,pulse,consultation,labitems,radiologyitems,serviceitems,refferal,consultationstatus,username,templatedata,date,locationname,locationcode,approval,priliminarysis,consultationicdform,formflag) 

		values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultingdoctor','$consultationtype','$department','$updatedatetime','$consultationtime','$consultationfees','$referredby','$consultationremarks','$visitcount','$complaints','$registrationdate','$recordstatus','$pulse','$consultation','$labitems','$radiologyitems','$serviceitems','$refferal','completed','$username','$getdata','$curdate','$locationnameget','$locationcodeget','$approvalvalue','$prilim','$filename',1)";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		

		$query88 = "insert into master_consultation(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,sys,dia,pulse,temp,complaint,murphing,drugallergy,foodallergy,consultationtime,locationname,locationcode,approval,consultationicdform,formflag) 

				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','completed','$currentdate','$ipaddress','$consultingdoctor','$billingtype','$accountname','pending','$bpsystolic','$bpdiastolic','$pulse','$celsius','$complaint','$murphing','$drugallergy','$foodallergy','$timestamp','$locationnameget','$locationcodeget','$approvalvalue','$filename',1)";

				$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

				

					$query81 = "select * from master_visitentry where visitcode='$visitcode'";

		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$res81 = mysqli_fetch_array($exec81);

		$triageconsultation = $res81['triageconsultation'];

		$overallpayment = $res81['overallpayment'];

		if(($overallpayment == '')&&($triageconsultation == 'completed'))

		{

		$newquery1=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set doctorconsultation='' where visitcode='$visitcode'");

		}

		else

		{

		$newquery1=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set doctorconsultation='completed' where visitcode='$visitcode'");

		}

		



		

		$query31 = "select * from master_company where companystatus = 'Active'";

		$exec31= mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$res31 = mysqli_fetch_array($exec31);

		$radrefnoprefix = $res31['radrefnoprefix'];

		$radrefnoprefix1=strlen($radrefnoprefix);

		$query21 = "select * from consultation_radiology order by auto_number desc limit 0, 1";

	    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

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

		

		foreach($_POST['radiologycode1'] as $key=>$value){	

			//echo '<br>'.

		

		$pairs= $_POST['radiology'][$key];

		 $radiologyinstructions = $_REQUEST['radiologyinstructions'][$key];

     

		$pairvar= addslashes($pairs);

	    $pairs1= $_POST['rate8'][$key];

		$pairvar1= (int)preg_replace('[,]','',$pairs1);

		



		$query13r = "select radtemplate from master_subtype where auto_number = '$subtypeano' order by subtype";

		$exec13r = mysqli_query($GLOBALS["___mysqli_ston"], $query13r) or die ("Error in Query13r".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$res13r = mysqli_fetch_array($exec13r);

		$tablenamer = $res13r['radtemplate'];

		if($tablenamer == '')

		{

		  $tablenamer = 'master_radiology';

		}

		

		$stringbuild1 = "";

		$query1 = "select itemcode from $tablenamer where status = '' AND itemname = '$pairvar'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$execradiology=mysqli_fetch_array($exec1);

		$radiologycode=$execradiology['itemcode'];

		

		if(($pairvar!="")&&($pairvar1!=""))

		{

		$query61 = "select * from consultation_radiology where patientcode='$patientcode' and patientvisitcode='$visitcode' and consultationid='$consultationid' and consultationtime = '$timestamp' and radiologyitemname = '$pairvar'";

		$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$num61 = mysqli_num_rows($exec61);

		if($num61 == 0)

		{

		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_radiology(consultationid,patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billtype,accountname,consultationdate,paymentstatus,refno,resultentry,consultationtime,username,locationname,locationcode,urgentstatus,radiologyinstructions,approvalstatus,mcc)values('$consultationid','$patientcode','$patientfullname','$visitcode','$radiologycode','".$pairvar."', '$pairvar1','$billingtype','$accountname','$currentdate','$status','$radrefcode','pending','$timestamp','$username','$locationnameget','$locationcodeget','$urgentstatus1','$radiologyinstructions','$approvalstatus','$mcc')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		}

		}

		}

			

			

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

		

		$icdquery1 = "insert into consultation_icd(consultationid,patientcode,patientname,patientvisitcode,accountname,consultationdate,consultationtime,primarydiag,primaryicdcode,secondarydiag,secicdcode,age,locationname,locationcode)values('$consultationid','$patientcode','$patientfullname','$visitcode','$accountname','$currentdate','$timestamp','$pairs111','$pairs112','$pairs113','$pairs114','$age','$locationnameget','$locationcodeget')";

		$execicdquery = mysqli_query($GLOBALS["___mysqli_ston"], $icdquery1) or die("Error in icdquery1". mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		

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

		$exec70 = mysqli_query($GLOBALS["___mysqli_ston"], $query70) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$num70 = mysqli_num_rows($exec70);

		if($num70 == 0)

		{

		$icdquery2 = "insert into consultation_icd1(consultationid,patientcode,patientname,patientvisitcode,disease,icdcode,accountname,consultationdate,consultationtime,locationname,locationcode)

		values('$consultationid','$patientcode','$patientfullname','$visitcode','$pairvar113','$pairvar114','$accountname','$currentdate','$timestamp','$locationnameget','$locationcodeget')";

		$execicdquery2 = mysqli_query($GLOBALS["___mysqli_ston"], $icdquery2) or die("Error in icdquery2". mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		}

		}

		}

		$query34 = "select * from master_company where companystatus = 'Active'";

		$exec34= mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$res34 = mysqli_fetch_array($exec34);

		$pharefnoprefix = $res34['pharefnoprefix'];

		$pharefnoprefix1=strlen($pharefnoprefix);

		$query24 = "select * from master_consultationpharm order by auto_number desc limit 0, 1";

	    $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

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

		if(isset($_REQUEST['medicinename'.$p]))

		{

		    $medicinename = $_REQUEST['medicinename'.$p];

			$medicinename = addslashes($medicinename);

			

			$medicinecode = isset($_REQUEST['medicinecode'.$p])?trim($_REQUEST['medicinecode'.$p]):"";

			if($medicinecode==""){

				$query77="select * from master_medicine where itemname='$medicinename' and status <> 'deleted'";

			}

			else{

				$query77="select * from master_medicine where TRIM(itemcode)='$medicinecode' and status <> 'deleted'";

			}

		

			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);

			$res77=mysqli_fetch_array($exec77);

			$medicinecode=$res77['itemcode'];

			if($subtypeano != '')

			{

				$rate=$res77['subtype_'.$subtypeano];

			}

			else{			

			$rate=$res77[$locationcodeget.'_rateperunit'];

			}

			

			$dose = $_REQUEST['dose'.$p];

		    $frequency = $_REQUEST['frequency'.$p];

			$sele=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_frequency where frequencycode='$frequency'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			$ress=mysqli_fetch_array($sele);

			$frequencyautonumber=$ress['auto_number'];

			$frequencycode=$ress['frequencycode'];

			$frequencynumber=$ress['frequencynumber'];

			$days = $_REQUEST['days'.$p];

			$quantity = $_REQUEST['quantity'.$p];

			$route = $_REQUEST['route'.$p];

			$instructions = $_REQUEST['instructions'.$p];

			$amount1 = $_REQUEST['amount'.$p];

			$amount=(int)preg_replace('[,]','',$amount1);

			$exclude = $_REQUEST['exclude'.$p];

			$dosemeasure = $_REQUEST['dosemeasure'.$p];

			

			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")

			if ($medicinename != ""  && $medicinecode!="")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")

			{

		        //echo '<br>'. 

				$query65 = "select * from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' and consultation_id='$consultationid' and consultationtime = '$timestamp' and medicinename='$medicinename'";

		$exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$num65 = mysqli_num_rows($exec65);

		if($num65 == 0)

		{

		         $query2 = "insert into master_consultationpharm(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,pharmacybill,medicineissue,consultationtime,source,route,excludestatus,locationname,locationcode,dosemeasure,mcc) 

				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$currentdate','$ipaddress','$username','$billingtype','$accountname','pending','$medicinecode','$pharefcode','$status','pending','$timestamp','doctorconsultation','$route','$exclude','$locationnameget','$locationcodeget','$dosemeasure','$mcc')";

				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

				

				$query29 = "insert into master_consultationpharmissue(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,prescribed_quantity,source,route,excludestatus,locationname,locationcode,dosemeasure,mcc) 

				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$currentdate','$ipaddress','$username','$billingtype','$accountname','$status','$medicinecode','$pharefcode','$quantity','doctorconsultation','$route','$exclude','$locationnameget','$locationcodeget','$dosemeasure','$mcc')";

				$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	

				}

				

			}

		

		}

	}

							

	

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

$res3 = mysqli_fetch_array($exec3);

$labrefnoprefix = $res3['labrefnoprefix'];

$labrefnoprefix1=strlen($labrefnoprefix);

$query2 = "select * from consultation_lab order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

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



	

	

		

		foreach($_POST['labcode1'] as $key=>$value)

		{

				    //echo '<br>'.$k;



		$labname=$_POST['lab'][$key];

		$labname = addslashes($labname);

		

		$query13l = "select * from master_subtype where auto_number = '$subtypeano' and recordstatus<>'deleted' order by subtype";

		$exec13l = mysqli_query($GLOBALS["___mysqli_ston"], $query13l) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$res13l = mysqli_fetch_array($exec13l);

		$tablenamel = $res13l['labtemplate'];

		if($tablenamel == '')

		{

		  $tablenamel = 'master_lab';

		}

		

		$stringbuild1 = "";

		$query1 = "select itemcode from $tablenamel where status = '' AND itemname='$labname'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$numb=mysqli_num_rows($exec1);

		$execlab = mysqli_fetch_array($exec1);

	

		

		$labcode=$execlab['itemcode'];

		$labrate1=$_POST['rate5'][$key];

        

		$labrate= (int) preg_replace('[,]','', $labrate1);

		

		if(($labname!="")&&($labrate!=''))

		{

		$query63 = "select * from consultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and consultationid='$consultationid' and consultationtime = '$timestamp' and labitemcode ='$labcode'";

		$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$num63 = mysqli_num_rows($exec63);

		if($num63 == 0)
		{

		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_lab(consultationid,patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billtype,accountname,consultationdate,paymentstatus,refno,labsamplecoll,resultentry,labrefund,urgentstatus,consultationtime,username,locationname,locationcode,approvalstatus,mcc)values('$consultationid','$patientcode','$patientfullname','$visitcode','$labcode','".$labname."','$labrate','$billingtype','$accountname','$currentdate','$status','$labrefcode','pending','pending','norefund','$urgentstatus','$timestamp','$username','$locationnameget','$locationcodeget','$approvalstatus','$mcc')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			}

			}

		}

		$query32 = "select * from master_company where companystatus = 'Active'";

		$exec32= mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$res32 = mysqli_fetch_array($exec32);

		$serrefnoprefix = $res32['serrefnoprefix'];

		$serrefnoprefix1=strlen($serrefnoprefix);

		$query22 = "select * from consultation_services order by auto_number desc limit 0, 1";

	    $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

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

		

		foreach($_POST['servicescode1'] as $key => $value)

		{

				    //echo '<br>'.$k;

		if(($billingtype =='PAY LATER') && ($planpercentage==0))

		{

		if($grandtotal1 > 0)

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

		$pending='pending';

		} 

		$servicesname=$_POST["services"][$key];

$servicescode=$_POST["servicescode1"][$key];

$wellnesspkg='';



		$query13s = "select sertemplate from master_subtype where auto_number = '$subtypeano' order by subtype";

		$exec13s = mysqli_query($GLOBALS["___mysqli_ston"], $query13s) or die ("Error in Query13s".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$res13s = mysqli_fetch_array($exec13s);

		$tablenames = $res13s['sertemplate'];

		if($tablenames == '')

		{

		  $tablenames = 'master_services';

		}

		

		$stringbuild1 = "";

 	/* 	$query1 = "select itemcode from $tablenames where status = '' AND itemname='$servicesname'";

		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error().__LINE__);

		$execservice=mysql_fetch_array($exec1);

		$servicescode=$execservice['itemcode']; */

		

		$servicesrate=$_POST["rate3"][$key];

		$serviceqty=$_POST['serviceqty'][$key];

		

		//$serviceqty=$_POST['serviceqty'][$key];

		$serviceamount1=$_POST['serviceamount'][$key];

		$serviceamount=(int)preg_replace('[,]','',$serviceamount1);

		$servicesrate=(int)preg_replace('[,]','',$servicesrate);

		

		$qrycheckhc = "select wellnesspkg,itemname from master_services where itemcode like '$servicescode' and status <> 'deleted'";

$execcheckhc = mysqli_query($GLOBALS["___mysqli_ston"], $qrycheckhc) or die("Error in Qrycheckhc ".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

$rescheckhc = mysqli_fetch_array($execcheckhc);

$wellnesspkg=$rescheckhc['wellnesspkg'];





			//for($i=0; $i<$serviceqty; $i++)

	//{ 

		if(($servicesname!="")&&($servicesrate!=''))

		{

		$query67 = "select * from consultation_services where patientcode='$patientcode' and patientvisitcode='$visitcode' and consultationid='$consultationid' and consultationtime = '$timestamp'";

		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$num67 = mysqli_num_rows($exec67);

		

		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_services(consultationid,patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,billtype,accountname,consultationdate,paymentstatus,refno,process,consultationtime,username,locationname,locationcode,serviceqty,amount,wellnesspkg,approvalstatus,mcc)values('$consultationid','$patientcode','$patientfullname','$visitcode','$servicescode','".$servicesname."','$servicesrate','$billingtype','$accountname','$currentdate','$status','$serrefcode','pending','$timestamp','$username','$locationnameget','$locationcodeget','$serviceqty','".$serviceamount."','$wellnesspkg','$approvalstatus','$mcc')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		include("hcpacakge_consultation.php");

		}

	//}

		

		

		}

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

	

		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_referal(consultationid,patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,billtype,accountname,consultationdate,paymentstatus,refno,consultationtime,locationname,locationcode)values('$consultationid','$patientcode','$patientfullname','$visitcode','$referalcode','$pairvar2','$pairvar3','$billingtype','$accountname','$currentdate','$status','$refrefcode','$timestamp','$locationnameget','$locationcodeget')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

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

		

		$sickquery="select visitcode from sickleave_entry where visitcode='$visitcode' and patientcode='$patientcode' order by auto_number desc";

   $exesick=mysqli_query($GLOBALS["___mysqli_ston"], $sickquery);

   $sicknum=mysqli_num_rows($exesick);

   if($sicknum <1)

   {

 $query2221 = "select sickoffnumber from sickleave_entry order by auto_number desc limit 0, 1";

$exec2221 = mysqli_query($GLOBALS["___mysqli_ston"], $query2221) or die ("Error in Query22221".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

$res2221 = mysqli_fetch_array($exec2221);

 $res2221sickoffnumber = $res2221["sickoffnumber"];



$billdigit11=strlen($res2221sickoffnumber);

if ($res2221sickoffnumber == '')

{

	$billnumbercode1 ='1';

}

else

{

	$billnumber1 = $res2221["sickoffnumber"];

	$billnumbercode1 =$billnumber1;

	

	$billnumbercode1 = $billnumbercode1 + 1;



}

 $billnumbercode1= str_pad($billnumbercode1,5,"0",STR_PAD_LEFT);



 $fromdate1 = $_REQUEST['ADate1'];

   $todate1 = $_REQUEST['ADate2'];

   $fromreview = $_REQUEST['ADate3'];

   //$toreview = $_REQUEST['ADate4'];

   $fromduty = $_REQUEST['ADate5'];

   $toduty = $_REQUEST['ADate6'];

   $nodays1 = $_REQUEST['nodays1'];

   $nodays2 = $_REQUEST['nodays2'];

   $work = $_REQUEST['work'];

   $sicktype = $_REQUEST['sicktype'];

   $remarks = $_REQUEST['remarks'];

   $dateonly2 = date('Y-m-d');

   $timeonly = date('H:i:s');

   

  

    if($fromduty!='' && $nodays2 != '')

	 {	

	$query26="insert into sickleave_entry(patientname,patientcode,sickoffnumber,visitcode,recorddate,fromdate,todate,fromreview,toreview,fromduty,toduty,work,nodays1,nodays2,sicktype,remarks,preparedby,status,recordtime,locationname,locationcode)values('$patientfullname',

'$patientcode','$billnumbercode1','$visitcode','$dateonly2','$fromdate1','$todate1','$fromreview','$toreview','$fromduty','$toduty','$work','$nodays1','$nodays2','$sicktype','$remarks','$username','completed','$timeonly','$locationnameget','$locationcodeget')";

	$exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	header ("location:iframeconsultationlist.php?patientcode=$patientcode&&visitcode=$visitcode&&st=success&&sickleave=1");

	exit;

    }

	else if($fromdate1!='' && $nodays1 != '')

	 {	

	$query26="insert into sickleave_entry(patientname,patientcode,sickoffnumber,visitcode,recorddate,fromdate,todate,fromreview,fromduty,toduty,work,nodays1,nodays2,sicktype,remarks,preparedby,status,recordtime,locationname,locationcode)values('$patientfullname',

'$patientcode','$billnumbercode1','$visitcode','$dateonly2','$fromdate1','$todate1','$fromreview','$fromduty','$toduty','$work','$nodays1','$nodays2','$sicktype','$remarks','$username','completed','$timeonly','$locationnameget','$locationcodeget')";

	$exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	header ("location:iframeconsultationlist.php?patientcode=$patientcode&&visitcode=$visitcode&&st=success&&sickleave=1");

	exit;

    }

else if($fromreview!='' )

	 {	

	$query26="insert into sickleave_entry(patientname,patientcode,sickoffnumber,visitcode,recorddate,fromdate,todate,fromreview,toreview,fromduty,toduty,work,nodays1,nodays2,sicktype,remarks,preparedby,status,recordtime,locationname,locationcode)values('$patientfullname',

'$patientcode','$billnumbercode1','$visitcode','$dateonly2','$fromdate1','$todate1','$fromreview','$toreview','$fromduty','$toduty','$work','$nodays1','$nodays2','$sicktype','$remarks','$username','completed','$timeonly','$locationnameget','$locationcodeget')";

	$exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	header ("location:iframeconsultationlist.php?patientcode=$patientcode&&visitcode=$visitcode&&st=success&&sickleave=1");

	exit;

    }

	

   }

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

		

		header ("location:iframeconsultationlist.php?patientcode=$patientcode&&st=success");

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

 

 $query67 = "update master_triage set consultation='Inprogress',consultationtype='$username' where patientcode='$patientcode' and visitcode='$viscode'";

 $exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

 

		$querytr1="update master_visitentry set triagestatus='completed' where visitcode='$viscode'";

		$exectr1=mysqli_query($GLOBALS["___mysqli_ston"], $querytr1) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$querytr="update master_billing set triagestatus='completed' where visitcode='$viscode'";

		$exectr=mysqli_query($GLOBALS["___mysqli_ston"], $querytr) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

 

 

 $query679 = "update consultation_departmentreferal set status='Inprogress',consultant='$username' where referalcode='1' and patientcode='$patientcode' and patientvisitcode='$viscode' order by auto_number desc";

 $exec679 = mysqli_query($GLOBALS["___mysqli_ston"], $query679) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

 

 

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

$availablelimit=$res23['availableilimit'];

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



$occupation = $res111['occupation'];	 

$address = $res111['area'];  

$dob = $res111['dateofbirth'];



$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";

$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die (mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

$res121 = mysqli_fetch_array($exec121);

$res121paymenttype = $res121['paymenttype'];

$query59 = "select * from master_visitentry where visitcode='$viscode'";

$exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

$res59 = mysqli_fetch_array($exec59);

$mcc = $res59['mcc'];

$mccaccountname = $res59['accountname'];

$gender = $res59['gender'];

$consultationfeetype = $res59['consultationfees'];

$visitconsultationdate= $res59['consultationdate'];

$age = calculate_age($dob);

$res111subtype = $res59['subtype'];

$res111subtype=trim($res111subtype);

$query131 = "select * from master_subtype where auto_number = '$res111subtype'";

$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

$res131 = mysqli_fetch_array($exec131);

$res131subtype = $res131['subtype'];



$query424 = "select mcc from master_accountname where auto_number = '$mccaccountname'";

$exec424 = mysqli_query($GLOBALS["___mysqli_ston"], $query424) or die ("Error in query424".mysqli_error($GLOBALS["___mysqli_ston"]));

$res424 = mysqli_fetch_array($exec424);

$res131subtype_mcc = $res424['mcc'];



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

.style5 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #1111EE !important; FONT-FAMILY: Tahoma;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<!--<script type="text/javascript" src="js/insertnewitem1.js"></script>

-->

<!--

<script type="text/javascript" src="js/insertnewitem1new_1.js"></script>

<script type="text/javascript" src="js/insertnewitem2_2.js"></script>

<script type="text/javascript" src="js/insertnewitem3_3.js"></script>

<script type="text/javascript" src="js/insertnewitem4_4.js"></script>

<script type="text/javascript" src="js/insertnewitem5_5.js"></script>

<script type="text/javascript" src="js/insertnewitem13.js"></script>

<script type="text/javascript" src="js/insertnewitem14.js"></script>

<script type="text/javascript" src="js/insertreferrate_r.js"></script>-->

<script type="text/javascript" src="js/insertnewitem11_new1.js"></script>

<script type="text/javascript" src="js/insertnewitem12_new.js"></script>

<script type="text/javascript" src="js/insertnewitem12_new1.js"></script>

<script type="text/javascript" src="js/insertnewitem13_new.js"></script>

<script type="text/javascript" src="js/insertnewitem14_new.js"></script>

<script type="text/javascript" src="js/insertnewitem15_new.js"></script>

<script type="text/javascript" src="js/insertnewitem13.js"></script>

<script type="text/javascript" src="js/insertnewitem14.js"></script>

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
.ui-autocomplete { height: 300px; overflow-y: scroll; overflow-x: hidden;}
.suggestions { height: 300px; overflow-y: scroll; overflow-x: hidden;}
</style>

<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>

<script src="js/jquery-ui.js" type="text/javascript"></script>

<link href="js/jquery-ui.css" rel="stylesheet">

</head>

<script language="javascript">

$(function() {

	$('#medicinename').autocomplete({

	source:'ajaxdrugsearch_test.php', 

	html: true, 

		select: function(event,ui){

			var medicine = ui.item.value;

			var medicinecode = ui.item.medicinecode;

			var stock = ui.item.stk;

			
			$('#searchmedicineanum1').val(medicinecode);

			$('#medicinecode').val(medicinecode);

			$('#medicinename').val(medicine);

			$('#hiddenmedicinename').val(medicine);
			if(stock > 0)
			{
				$('#toavlquantity1').val(stock);
			}
			
			funcmedicinesearch4();

			},

    });

});



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

var confirm1=confirm("Available Limit is Less than Grand Total! Do you want to proceed");
if(confirm1 == false) 
{
  return false;
}

}



}

else if ((var12!=0 ) && (var111==0))

{

	

	

if(parseInt(var12) < parseInt(var11))
{
var confirm1=confirm("Visit Limit is Less than Grand Total! Do you want to proceed");
if(confirm1 == false) 
{
  return false;
}	
}

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

var VarRate=parseFloat(varr1.replace(/[^0-9\.]+/g,""));



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

    funcHideView();

	funcpresHideView();

	funcLabHideView();

	funcRadHideView();

	funcSerHideView();

	funcRefferalHideView();

	funcExRefferalHideView();

	funcsickleavehide();

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

	//funcCustomerDropDownSearch4(); 

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

<?php include ("js/dropdownlist1icd.php"); ?>

<script type="text/javascript" src="js/autosuggestnewicdcode.js"></script> <!-- For searching customer -->

<script type="text/javascript" src="js/autocomplete_newicd.js"></script>





<?php include ("js/dropdownlist1icd1.php"); ?>

<script type="text/javascript" src="js/autosuggestnewicdcode1.js"></script> <!-- For searching customer -->

<script type="text/javascript" src="js/autocomplete_newicd1.js"></script>

<script type="text/javascript" src="js/automedicinecodesearch12_new.js"></script>



<?php include ("js/dropdownlist1scriptinglab1.php"); ?>

<script type="text/javascript" src="js/autocomplete_lab1.js"></script>

<script type="text/javascript" src="js/autosuggestlab1.js"></script> 

<script type="text/javascript" src="js/autolabcodesearch12_new.js"></script>





<?php include ("js/dropdownlist1scriptingradiology1.php"); ?>

<script type="text/javascript" src="js/autocomplete_radiology1.js"></script>

<script type="text/javascript" src="js/autosuggestradiology1.js"></script> 

<script type="text/javascript" src="js/autoradiologycodesearch12_new.js"></script>





<?php include ("js/dropdownlist1scriptingservices1.php"); ?>

<script type="text/javascript" src="js/autocomplete_services1.js"></script>

<script type="text/javascript" src="js/autosuggestservices1.js"></script>

<script type="text/javascript" src="js/autoservicescodesearch12_new_live.js"></script>



<?php include ("js/dropdownlist1scriptingreferal.php"); ?>

<script type="text/javascript" src="js/autocomplete_referal.js"></script>

<script type="text/javascript" src="js/autosuggestreferal1.js"></script>

<script type="text/javascript" src="js/autoreferalcodesearch12_new.js"></script>


<script type="text/javascript">
	$(function(){
	$('#icdsearch').click(function(){
		var searchdisease1 = $('#dis').val();
		// var searchdisease1_icd_dept = $('#icd_dept').val();
		var dataString = 'searchdisease1='+searchdisease1+'&&dept=""';
		window.open("icddbsearch2.php?"+dataString,"OriginalWindowA4",'width=722,height=450,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=1,resizable=1,left=225,top=100');
	});
	
	$('#icdsearch1').click(function(){
		var searchdisease1 = $('#dis1').val();
		// var searchdisease1_icd_dept = $('#icd_dept').val();
		var dataString = 'searchdisease1='+searchdisease1+'&&dept=""';
		window.open("icddbsearch12.php?"+dataString,"OriginalWindowA4",'width=722,height=450,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=1,resizable=1,left=225,top=100');
	});
});
</script>




<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>



<?php

				$query78="select * from master_consultationtemplate where auto_number='2' ";

				$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

				$res78=mysqli_fetch_array($exec78);

				$templatedata=$res78['templatedata'];

				

				$query41 = "select * from master_employee where username='$username'";

				$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

				$res41 = mysqli_fetch_array($exec41);

		 $employeename = $res41['employeename'];

				?>



<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script src="js/datetimepicker_css.js"></script>

<script>

function datevalidation(seldate)

{



	var consuldate=document.getElementById("visitconsultationdate").value;

	//alert(consuldate);

	var date=document.getElementById(seldate).value;

	//alert(date);

	var currentdate=document.getElementById("currentdate").value;

	var fromdate=document.getElementById("ADate1").value;

var todate=document.getElementById("ADate2").value;

var fromduty=document.getElementById("ADate5").value;

var toduty=document.getElementById("ADate6").value;

		if(seldate =='ADate3')

		{

		if (date< currentdate || todate =='')

		{

		document.getElementById(seldate).value='';

		alert("Please Select Date Greater Than Today");

		document.getElementById("nodays1").focus();

		}

		}

		else if(seldate =='ADate1') {

		if (date < consuldate || date>currentdate)

		{

		document.getElementById(seldate).value='';

		alert("Please Select Date Between Visit Date And Today");

		document.getElementById("nodays1").focus();

		datevalidation1();

		return false;

		}

		else{

		return true;

		}

		}

		else if( seldate =='ADate5' || seldate=='ADate6')

		{

		if(date>todate || date <fromdate)

		{

		document.getElementById(seldate).value='';

		alert("Please Select Date Between From Date And To Date");

		document.getElementById("nodays1").focus();

		datevalidation1();

		return false;

		}

		else

		{

		datevalidation1();

		return true

		}

		}

		else

		{

		datevalidation1();

		}

		

}

function datevalidation1()

{

	var fromdate=document.getElementById("ADate1").value;

var todate=document.getElementById("ADate2").value;

var fromduty=document.getElementById("ADate5").value;

var toduty=document.getElementById("ADate6").value;





if(todate<fromdate || fromdate=='')

{

	document.getElementById("ADate2").value='';

	document.getElementById("nodays1").value='';

	if(fromdate!='')

	{

	alert("Please Select Date Greater than From Date");

	document.getElementById("nodays1").focus();

	}

}

if(toduty<fromduty || fromduty=='' || toduty > todate)

{

	document.getElementById("ADate6").value='';

	document.getElementById("nodays2").value='';

	if(fromduty!='' && toduty != '')

	{

	alert("Please Select Date Between From Date and To Date");

	document.getElementById("nodays1").focus();

	}

}

	



}



	function DateDiff() {

		var date1 = document.getElementById("ADate1").value;

		var date2 = document.getElementById("ADate2").value;

		if(date1 !='' && date2 !='')

		{

		

		date1 = date1.split('-');

		date2 = date2.split('-');

		

		// Now we convert the array to a Date object, which has several helpful methods

		date1 = new Date(date1[0], date1[1], date1[2]);

		date2 = new Date(date2[0], date2[1], date2[2]);

		

		// We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)

		date1_unixtime = parseInt(date1.getTime() / 1000);

		date2_unixtime = parseInt(date2.getTime() / 1000);

		

		// This is the calculated difference in seconds

		var timeDifference = date2_unixtime - date1_unixtime;

		// in Hours

		var timeDifferenceInHours = timeDifference / 60 / 60;

		// and finaly, in days :)

		var timeDifferenceInDays = timeDifferenceInHours  / 24;

		if(timeDifferenceInDays!=0)

		{

			timeDifferenceInDays+=1;

		}

		if(timeDifferenceInDays==0)

		{

			timeDifferenceInDays=1;

		}

		document.getElementById("nodays1").value = timeDifferenceInDays;	

		}

	}

	

	function DateDiff1() {

		var date1 = document.getElementById("ADate5").value;

		var date2 = document.getElementById("ADate6").value;

		if(date1 !='' && date2 !='')

		{

		

		date1 = date1.split('-');

		date2 = date2.split('-');

		

		// Now we convert the array to a Date object, which has several helpful methods

		date1 = new Date(date1[0], date1[1], date1[2]);

		date2 = new Date(date2[0], date2[1], date2[2]);

		

		// We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)

		date1_unixtime = parseInt(date1.getTime() / 1000);

		date2_unixtime = parseInt(date2.getTime() / 1000);

		

		// This is the calculated difference in seconds

		var timeDifference = date2_unixtime - date1_unixtime;

		// in Hours

		var timeDifferenceInHours = timeDifference / 60 / 60;

		// and finaly, in days :)

		var timeDifferenceInDays = timeDifferenceInHours  / 24;

		//alert(timeDifferenceInDays);

		if(timeDifferenceInDays!=0)

		{

			timeDifferenceInDays+=1;

		}

		if(timeDifferenceInDays==0)

		{

			timeDifferenceInDays=1;

		}

		document.getElementById("nodays2").value = timeDifferenceInDays;

		}

	}



</script>



<script type="text/javascript">

function numbervaild(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if( (charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode == 8 || charCode == 9 )
		return true;
	return false;
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

     <form name="form1" id="form1" method="post" action="consultationform_test.php" onSubmit="return process1();"  onKeyDown="return disableEnterKey(event)">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="103%"><table   border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

            <tbody>

              <tr bgcolor="#011E6A">

                <td colspan="4" bgcolor="#ecf0f5" class="style2">Consultation </td>

                <td bgcolor="#ecf0f5" colspan="2"  class="style2">Location:&nbsp;&nbsp; <?php echo $locationname ?></td>

                <input type="hidden" name="locationnameget" id="locationname" value="<?php echo $locationname;?>">

                <input type="hidden" name="locationcodeget" id="locationcode" value="<?php echo $locationcode;?>">

				<input type="hidden" name="subtypeano" id="subtypeano" value="<?php echo $res111subtype;?>">

				<input type="hidden" name="subtyp_mcc" id="subtyp_mcc" value="<?php echo $res131subtype_mcc;?>">

				<input type="hidden" name="mcc" id="mcc" value="<?php echo $mcc;?>">

				 <td colspan="4" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong><a target="_blank" href="emrresultsviewlist.php?patientcode=<?php echo $patientcode; ?>">EMR</a></strong></td>

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

					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

					$res51 = mysqli_fetch_array($exec51);

					$res51visittype = $res51["visittype"];

					//echo '<option value="">Select Normal Tax</option>';

					echo '<option value="'.$res51visittype.'" selected="selected">'.$res51visittype.'</option>';

				}

				

				$query5 = "select * from master_visittype where recordstatus = '' order by visittype";

				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

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

					  <td align="left" valign="middle" class="bodytext3"><span class="bodytext32"><label  <?php if($sysclr != ''){ ?> style=" background-color:#FF6666" <?php } ?>><?php echo $bpsystolic;?></label>

                          <input name="bpsystolic" type="hidden" id="bpsystolic"  readonly="readonly" value="<?php echo $bpsystolic;?>" onBlur="return MinimumBP()" size="10">

					  </span> </td>

					  <td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32"><strong>Dia</strong></span>

                        <label class="bodytext32"></label></td>

					  <td align="left" valign="middle" class="bodytext3"><span class="bodytext32"><label <?php if($diaclr != ''){ ?> style=" background-color:#FF6666" <?php } ?>><?php echo $bpdiastolic;?> </label>

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

				   <td align="left" valign="middle"><span class="bodytext32"><label <?php if($tempclr != ''){ ?> style=" background-color:#FF6666"<?php } ?>><?php echo number_format($celsius,2,'.','');?> </label>

                       <input name="celsius" type="hidden" id="celsius" readonly value="<?php echo $celsius;?>" size="10">

				   </span></td>

				   <td align="left" valign="middle"  bgcolor=""><label class="bodytext32">

				    <strong>SPO2</strong>

				   </label></td>

				   <td align="left" valign="middle"  bgcolor="">

				 

			         <label></label>

		            <label class="bodytext3"><span class="bodytext32"><?php echo $spo2;?>

                    <input type="hidden" name="fahrenheit" id="fahrenheit" value="<?php echo $fahrenheit;?>" readonly  onBlur="return FunctionTemperature()" size="10">

		            </span></label></td>

		          </tr>

				 <!--<tr bgcolor="">

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

		          </tr>-->

				  <?php

					$query667 = "select * from master_consultationlist where patientcode = '$patientcode' and visitcode = '$visitcodenum'";

					$exec667 = mysqli_query($GLOBALS["___mysqli_ston"], $query667) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

					$res667 = mysqli_fetch_array($exec667);

					$consultationnotes = $res667['consultation'];

					$comconsultationdoctor = $res667['username'];

					$query45 = "select * from master_triage where patientcode = '$patientcode' and visitcode = '$visitcodenum' order by auto_number desc";

					$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

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

					$lmp = $res45['lmp'];

					$edt = $res45['edt'];

					?>

				<tr>

				<td align="left" valign="middle"  bgcolor="" class="bodytext3"><label class="bodytext32"><strong>Intdrugs</strong></label></td>

				<td align="left" valign="middle"  bgcolor="" class="bodytext3 "><span class="bodytext32 style5"><?php echo $intdrugs;?></span></td>

				<td align="left" valign="middle"  bgcolor="" class="bodytext3"><label class="bodytext32"><strong>Dose</strong></label></td>

				<td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32 style5"><?php echo $dose;?></span></td>

				<td align="left" valign="middle"  bgcolor="" class="bodytext3"><label class="bodytext32"><strong>Route</strong></label></td>

				<td align="left" valign="middle"  bgcolor="" class="bodytext3"><span class="bodytext32 style5"><?php echo $route;?></span></td>

				</tr>	

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

				   <?php } $other = trim($other);?>

				   

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

				   <?php if($lmp !=''){ ?>

				   LMP (<label style="color:red;"><?php echo $lmp; ?></label>)&nbsp;

				   <?php } ?>

				   

				   <?php if($edt !=''){ ?>

				   EDT (<label style="color:red;"><?php echo $edt; ?></label>)&nbsp;

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

				   <?php } ?></label>                 </td>

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

				   <td align="left" valign="top"  bgcolor=""><span class="bodytext32"><strong>Murphing</strong></span></td>

				   <td align="left" valign="top"  bgcolor=""><label class="bodytext32">

                       <textarea name="murphing" id="murphing" class="bodytext32"><?php echo $murphing; ?></textarea>

                   </label></td>

				    <td align="left" valign="top"  bgcolor=""><span class="bodytext32"><strong>Exclusions</strong></span></td>

				   <td align="left" valign="top"   bgcolor=""><label class="bodytext32">

                       <textarea name="elclusions" style="border: 1px solid #FF0000"; readonly id="elclusions"  class="bodytext32"><?php echo $exclusions; ?></textarea>

                   </label></td>

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

					$overalllimit1=$res222['overalllimitop'];

                    $query223="select consultation from billing_consultation where patientcode = '$patientcode' and patientvisitcode='$viscode'";

					$exec223=mysqli_query($GLOBALS["___mysqli_ston"], $query223) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$res223=mysqli_fetch_array($exec223);

					$planfixedamount=$res223['consultation'];

					if($visitlimit1 != 0)

					{

					    $visitlimit1 = $visitlimit1+$planfixedamount - $consultationfees;

					}

					else

					{

					    $visitlimit1 = 0;

					}

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

                   <?php } ?>

                   </td>

                   <td width="300" align="left" valign="top"  bgcolor=""><span class="bodytext32"><strong>Visit limit:</strong></span>

                   <input size="10" type="hidden" name="visitlimit" id="visitlimit"  value="<?php echo $visitlimit1; ?>" >

                   <input size="8" type="text" name="visitlimit12" id="visitlimit12"  value="<?php echo number_format($visitlimit1, 2, '.', ','); ?>" style='font-size:16px;font-weight:bold;' disabled >

                   </td>

                   <?php

				   }

				  ?>

			      </tr>

				 <tr>

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="style2"  onDblClick="return funcHideView()"  onClick="return funcShowView()">

				   Consultation 

				   <span class="bodytext32">

				   <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcHideView()"  onClick="return funcShowView()">				   </span>				   </td>

			      </tr>

				 <tr id="consltid">

				   <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				   <input type="hidden" name="consultation" id="consultation">

				   <input type="hidden" name="getdata" id="getdata">

				   <span class="bodytext32">

				   <textarea name="editor" id="editor1">

				   <?php echo "Doctor : ".$employeename; ?><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date : ".$curdate; ?>

				   <?php echo $templatedata; ?>

				   </textarea>

				   </span>

				   <script>

						CKEDITOR.replace( 'editor1',

						null,

						''

						);

					</script>	   			    </td>

			       <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

			       <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

			       <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

			       <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

				 </tr>

				  

				  <tr id="disease">

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				    <table id="presid" width="767" border="0" cellspacing="1" cellpadding="1">

                     <!--

					 <tr>

                     <td class="bodytext3">Priliminary Diseases</td>

				   <td width="423"> <input name="dis2[]" id="dis2" type="text" size="69" autocomplete="off"></td>

                   </tr> -->

                     



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

                       <td> <input type="button" id="icdsearch" value="Search full ICD" style="border: 1px solid #001E6A"></td>
					  </td>

					   </tr>

				      </table>						</td>

		        </tr>

				

				 

				  <tr id="disease1">

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				    <table id="presid" width="769" border="0" cellspacing="1" cellpadding="1">

                     <tr>

					 <td width="72" class="bodytext3"></td>

                       <td width="423" class="bodytext3">Disease</td>

                       <td class="bodytext3">Code</td>

					   <td class="bodytext3"></td>

                     </tr>

					  <tr>

					 <div id="insertrow14">					 </div></tr>

					  <tr>

					  <input type="hidden" name="serialnumberdisease1" id="serialnumberdisease1" value="1">

					  <input type="hidden" name="diseas1" id="diseas1" value="">

					  <td class="bodytext3">Secondary </td>

				   <td width="423"> <input name="dis1[]" id="dis1" type="text" size="69" autocomplete="off"></td>

				      <td width="101"><input name="code1[]" type="text" id="code1" readonly size="8">

					  <input name="autonum1" type="hidden" id="autonum1" readonly size="8">

					  <input name="searchdisease1hiddentextbox1" type= "hidden" id = "searchdisease1hiddentextbox1" >

					  <input name="chapter1[]" type="hidden" id="chapter1" readonly size="8"></td>

					   <td><label>

                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem14()" class="button" style="border: 1px solid #001E6A">

                       </label></td>
                       <td> <input type="button" id="icdsearch1" value="Search full ICD" style="border: 1px solid #001E6A"></td>

				      </tr>

				      </table>						</td>

		        </tr>

				  

				 <tr>

				   <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

				   <td width="2" colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

			      </tr>

				  

				 <tr>

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"  onDblClick="return funcpresHideView()" onClick="return funcpresShowView()"><strong>Prescription</strong> <span class="bodytext32"> <img src="images/plus1.gif" width="13" height="13"   onDblClick="return funcpresHideView()" onClick="return funcpresShowView()"> </span></td>

			      </tr>

				 <tr id="pressid">

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				   <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">

                     <tr>

                       <td width="200" class="bodytext3">Medicine Name</td>
                        <td width="48" class="bodytext3">Stk</td>

                       <td width="48" class="bodytext3">Dose</td>

                       <td width="48" class="bodytext3">Dose.Measure</td>

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

						<input name="hiddenmedicinename" id="hiddenmedicinename" value="" type="hidden">

                       <td><input name="medicinename" type="text" id="medicinename" size="40" autocomplete="off">					   </td>
                         <td>
                      		<input name="toavlquantity1" type="text" id="toavlquantity1" size="8" readonly  > 
                      	</td>

                       <td><input name="dose" type="text" id="dose" size="8" onKeyUp="return Functionfrequency()"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>

					   <td>
					   <!-- 	<select name="dosemeasure" id="dosemeasure">

					   <option value="">Select Measure</option>

					   <option value="suppositories">suppositories</option>
					   <option value="tabs">tabs</option>
					   <option value="caps">caps</option>
					   <option value="ml">ml</option>
					   <option value="vial">vial</option>
					   <option value="inj">inj</option>
					   <option value="amp">amp</option>
					    <option value="gel">Gel</option>
					   <option value="tube">tube</option>
					   <option value="mg">mg</option>
					   <option value="drops">drops</option>
					   <option value="pcs">pcs</option>

					   </select> -->
					   	 <select class="dose_measure" name="dosemeasure" id="dosemeasure" >
								 <option value="">Select Measure</option>
								 <?php
								 // $dose_measure='3';
								     $query_prod_type = "select * from dose_measure where status = '1' ";
								     $exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die ("Error in query_prod_type".mysqli_error($GLOBALS["___mysqli_ston"]));
								 while ($res_prod_type = mysqli_fetch_array($exec_prod_type))
								 {
								     $res_prod_id3 = $res_prod_type['id'];
								     $res_prod_name3 = $res_prod_type['name'];

								 ?>
		                          <option value="<?php echo $res_prod_name3; ?>"  ><?php echo $res_prod_name3; ?></option>
								 <?php
								     }
								 ?>
						    </select> 

					   </td>

                       <td>

					   <select name="frequency" id="frequency" onChange="( Functionfrequency())">

					     <?php

				if ($frequncy == '')

				{

					echo '<option value="select" selected="selected">Select frequency</option>';

				}

				else

				{

					$query51 = "select * from master_frequency where recordstatus = ''";

					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

					$res51 = mysqli_fetch_array($exec51);

					$res51code = $res51["frequencycode"];

					$res51num = $res51['frequencynumber'];

					echo '<option value="'.$res51num.'" selected="selected">'.$res51code.'</option>';

				}

				$query5 = "select * from master_frequency where recordstatus = '' order by auto_number";

				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

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

                       <td><input name="days" type="text" id="days" size="8" onKeyUp="return Functionfrequency()" onFocus="return frequencyitem()"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>

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

                       <td><input name="instructions" type="text" id="instructions" onKeyUp="return shortcodes();" size="20"></td>

                       <td width="48">

                       <input name="rates" type="text" id="rates" readonly size="8">

                       </td>

                       <td>

                         <input name="amount" type="text" id="amount" readonly size="8"></td>

						  <td>

						  <input name="exclude" type="hidden" id="exclude" readonly size="8">

                         <input name="formula" type="hidden" id="formula" readonly size="8"></td>

						 <td>

                         <input name="strength" type="hidden" id="strength" readonly size="8"></td>

                       <td><label>

                       <input type="button" name="Add" id="Add" value="Add" onClick="( insertitem(), fortreatment())" class="button" >

                       </label></td>

					   </tr>

                     

					 <input type="hidden" name="h" id="h" value="0">

                   </table>				  </td>

			       </tr>

				 <tr>

				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span><span class="bodytext32">

				<!--<input name="text" type="hidden" id="t1" size="7" readonly>-->

                     <input name="text" type="text" id="total" size="7" readonly>

                         

				   </span></td>

				 </tr>

			  

				 <tr>

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"  onDblClick="return funcLabHideView()"  onClick="return funcLabShowView()"><span class="bodytext32"><span class="style2">Lab <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcLabHideView()"  onClick="return funcLabShowView()"> </span></span></td>

			      </tr>

				  

				 <tr id="labid">

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				     <table width="621" border="0" cellspacing="1" cellpadding="1">

                     <tr>

                       <td width="30" class="bodytext3">Laboratory Test</td>

                       <td class="bodytext3">Rate</td>

                       <td width="30" class="bodytext3"><!--<button type="button" id="addlabtesta" onClick="labFunction()" title="Lab Request Form"><img src="images/addbutton.png" /></button>--></td>

                     </tr>

					  <tr>

					 <div id="insertrow1">					 </div></tr>

					  <tr>

					  <input type="hidden" name="serial1" id="serial1" value="1"> 

					  <input type="hidden" name="serialnumber1" id="serialnumber1" value="1">

					  <input type="hidden" name="labcode" id="labcode" value="">

				      <td width="30"><input name="lab[]" id="lab" type="text" size="69" autocomplete="off"></td>

				      <td width="30">

                      <input name="rate5[]" type="text" id="rate5" readonly size="8">

                      <input  type="hidden" id="r1" readonly size="8">

                      <!--<input name="t2r[]" type="tex" id="t2r" readonly size="8">-->

                      </td>

					  <td><label>

					  <input type="hidden" name="hiddenlab" id="hiddenlab">

                       <input type="button" name="Add1" id="Add1" value="Add" onClick="( insertitem2(),  fortreatment()) " class="button" >

                       </label></td>

					   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">&nbsp;</div></td>

					   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">Urgent</div></td>

					   <td height="28" colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5">

				  <input name="urgentstatus" id="urgentstatus" type="checkbox" value="Checked" ></td>

					   </tr>

					    </table>	  </td> 

				  </tr>   

				 <tr>

				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span>

                   <input type="text" id="total1" readonly size="7">

                <!--   <input type="hidden" id="t2"  size="7"></td> -->

				  

                  </tr> 

		        

				 <tr>

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"  onDblClick="return funcRadHideView()"  onClick="return funcRadShowView()"><span class="bodytext32"><span class="style2">Radiology <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcRadHideView()"  onClick="return funcRadShowView()"> </span></span></td>

		        </tr>

				 <tr id="radid">

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">

                     <tr>

                       <td width="30" class="bodytext3">Radiology Test</td>

					                          <td class="bodytext3">Instructions</td>

                       <td class="bodytext3">Rate</td>

                       <td width="30" class="bodytext3">&nbsp;</td>

                     </tr>

					  <tr>

					 <div id="insertrow2">					 </div></tr>

					  <tr>

					  <input type="hidden" name="serialnumber2" id="serialnumber2" value="1">

					  <input type="hidden" name="radiologycode" id="radiologycode" value="">

					  <input type="hidden" name="hiddenradiology" id="hiddenradiology">

				   <td width="30"> <input name="radiology[]" id="radiology" type="text" size="69" autocomplete="off"></td>

				     <td><input name="radiologyinstructions[]" type="text" id="radiologyinstructions" size="20"></td>

				      <td width="30"><input name="rate8[]" type="text" id="rate8" readonly size="8"></td>

					   <td><label>

                       <input type="button" name="Add2" id="Add2" value="Add" onClick="( insertitem3(),  fortreatment())" class="button">

                       </label></td>

                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">&nbsp;</div></td>

					   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">Urgent</div></td>

					   <td height="28" colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5">

				  <input name="urgentstatus1" id="urgentstatus1" type="checkbox" value="Checked" ></td>

					   </tr>

					    </table>						</td>

		        </tr>

				

				 <tr>

				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span>

                   <input type="text" id="total2" readonly size="7">

                 <!--  <input  type="hidden" id="t3" size="7">--></td>

				   

                   </tr>

		       

				

				 <tr>

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"  onDblClick="return funcSerHideView()" onClick="return funcSerShowView()"><span class="bodytext32"><span class="style2">Service, Procedures and Package Billing <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcSerHideView()" onClick="return funcSerShowView()"> </span></span></td>

		        </tr>

				 <tr id="serid">

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">

                     <tr>

                       <td width="30" class="bodytext3">Services</td>

					   

                       <td class="bodytext3">Base Rate</td>

                       <td class="bodytext3">Base Unit</td>

                       <td class="bodytext3">Incr Qty</td>

                       <td class="bodytext3">Incr Rate</td>

                        <td width="30" class="bodytext3">Qty</td>

                       <td width="30" class="bodytext3">Amount</td>

                     </tr>

					  <tr>

					 <div id="insertrow3">					 </div></tr>

					  <tr>

					  <input type="hidden" name="serialnumber3" id="serialnumber3" value="1">

					  <input type="hidden" name="servicescode" id="servicescode" value="">

					  <input type="hidden" name="hiddenservices" id="hiddenservices">

				   <td width="30"><input name="services[]" type="text" id="services" size="69" autocomplete="off"></td>

				   

				    <td width="30"><input name="rate3[]" type="text" id="rate3" readonly size="8"></td>

                    <td width="30"><input name="baseunit[]" type="text" id="baseunit" readonly size="8"></td>

                    <td width="30"><input name="incrqty[]" type="text" id="incrqty" readonly size="8"></td>

                    <td width="30"><input name="incrrate[]" type="text" id="incrrate" readonly size="8">

                    <input name="slab[]" type="hidden" id="slab" readonly size="8">

			<input type='hidden' name='pkg2[]' id='pkg2'>

                    </td>

                     <td widthd="30"><input name="serviceqty[]" type="text" id="serviceqty" size="8" autocomplete="off" onKeyDown="return numbervaild(event)" oninput="return sertotal()"></td>

					<td width="30"><input name="serviceamount[]" type="text" id="serviceamount" readonly size="8"></td>

					   <td><label>

                       <input type="button" name="Add3" id="Add3" value="Add" onClick=" ( insertitem4(),fortreatment())" class="button">

                       </label></td>

					   </tr>

					    </table></td>

		       </tr>

				 

				 <tr>

				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span>

                   <input type="text" id="total3" readonly size="7">

                 <!--  <input type="hidden" id="t4" readonly size="7">--></td>

				   </tr>

		        

				 <!--<tr>

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"   onDblClick="return  funcRefferalHideView()" onClick="return funcRefferalShowView()"><span class="bodytext32"><span class="style2">Referral <img src="images/plus1.gif" width="13" height="13"  onDblClick="return  funcRefferalHideView()" onClick="return funcRefferalShowView()"> </span></span></td>

		        </tr>-->

				 <tr id="reffid">

				    <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">

					

					<tr style="display:none;">

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

					  $referalrate1 = $referalrate1-$consultationfees;

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

						 <tr style="display:none;">

				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span>

                   <input type="text" id="totalr" readonly size="7">

                  <!-- <input type="hidden" id="tr" readonly size="7">-->

                   </td></tr>

				  

		       

				  <tr>

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"  onDblClick="return  funcExRefferalHideView()" onClick="return funcExRefferalShowView()" style="display: none"><span class="bodytext32"><span class="style2">External Referral <img src="images/plus1.gif" width="13" height="13"  onDblClick="return  funcExRefferalHideView()" onClick="return funcExRefferalShowView()"> </span></span></td>

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

                       <td width="284" class="bodytext3">Doctor</td>

                       <td width="48" class="bodytext3">Rate</td>

                       <td width="75" class="bodytext3">&nbsp;</td>

                     </tr>

					  <tr>

					 <div id="insertrow4">					 </div></tr>

					  <tr>

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

				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" style="display: none"><span class="style2">Total</span>

				  <input type="text" id="total5" readonly size="7" style="display: none">

                  <input type="hidden" id="t6" readonly size="7">

                  </td></tr>

				                <?php 

				   $sickquery="select visitcode from sickleave_entry where visitcode='$viscode' and patientcode='$patientcode' order by auto_number desc";

   $exesick=mysqli_query($GLOBALS["___mysqli_ston"], $sickquery);

   $sicknum=mysqli_num_rows($exesick);

   if($sicknum <1)

   {

				  ?>

                  

																																																					   <tr>

																																																<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"  onDblClick="return  funcsickleavehide()" onClick="return funcsickleavehideview()"><span class="bodytext32"><span class="style2">Sick Leave

																																																<img src="images/plus1.gif" width="13" height="13"  onDblClick="return  funcsickleavehide()" onClick="return funcsickleavehideview()"> </span></span></td>

																																																				</tr>

																																																				<tr id="sickleaveid">

																																																					<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

																																																				   <table width="1336" height="96" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">

																																																			<tbody>

																																																				

																																																				<tr>

																																																				 <td width="143" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">FROM DATE: </td>

																																																				 <td width="160" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">

	<input type="hidden" id="currentdate" name="currentdate" value="<?= $s=date('Y-m-d');?>">		

	<input type="hidden" name="visitconsultationdate" id="visitconsultationdate" value="<?= $visitconsultationdate;?>">																																																	   <input name="ADate1" id="ADate1" value="<?php //echo $visitconsultationdate; ?>"  size="10"   onFocus="return datevalidation('ADate1')" onKeyDown="return disableEnterKey()" onChange="return DateDiff();" readonly />

																																																				  <img  src="images2/cal.gif" style="cursor:pointer"  onClick="javascript:NewCssCal('ADate1')" /></span><span class="bodytext32"></span>&nbsp;

																																																				  <img  src="images25/cancel.png" style="cursor:pointer"  height="12" width="15"   onClick="return dateclear('ADate1');"/></td>

																																																				 <td width="118" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">TO DATE: </td>

																																																				 <td width="163" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">

																																																				   <input name="ADate2" id="ADate2" onFocus="return datevalidation1()" value="<?php //echo $transactiondateto; ?>"  size="10"    onKeyDown="return disableEnterKey()" onChange="return DateDiff();" readonly/>

																																																				  <img  src="images2/cal.gif"   onClick="javascript:NewCssCal('ADate2')" />&nbsp;<img  src="images25/cancel.png" style="cursor:pointer"  height="12" width="15" onClick="return dateclear('ADate2');"/></span></td>

																																																				  <td width="89" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">No. of DAYS:</span></td>

																																																				 <td  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <span class="bodytext31">

																																																				   <input name="nodays1" id="nodays1" value=""  size="7"  readonly="readonly" onKeyDown="return disableEnterKey()" />

																																																				 </span></td>

																																																				 <td width="74" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Work Related: </td>

																																																				 <td width="58" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><select name="work" id="work">

																																																				   <option value="1">No</option>

																																																				   <option value="2">Yes</option>

																																																				 </select></td>

																																																				 <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">TYPE OF SICK OFF: </td>

																																																				 <td width="120" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">

																																																				   <input name="sicktype" id="sicktype" value=""  size="20" onKeyDown="return disableEnterKey()" />

																																																				 </span></td>

																																																			   </tr>

																																																			   

																																																			   <tr>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">DATE  OF REVIEW : </td>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">

																																																				   <input name="ADate3" id="ADate3" onFocus="return datevalidation('ADate3')" value="<?php //echo $transactiondatefrom; ?>"  size="10"   onKeyDown="return disableEnterKey()" readonly />

																																																				   <img  src="images2/cal.gif" style="cursor:pointer"  onClick="javascript:NewCssCal('ADate3')" />&nbsp;<img  src="images25/cancel.png"  style="cursor:pointer" height="12" width="15" onClick="return dateclear('ADate3');"/></span></td>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">LIGHT DUTY FROM :</td>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <input name="ADate5" id="ADate5" onFocus="return datevalidation('ADate5')" value="<?php //echo $visitconsultationdate; ?>"  size="10"   onKeyDown="return disableEnterKey()" onChange="return DateDiff1();"  readonly/>

																																																				   <img  src="images2/cal.gif" style="cursor:pointer"  onClick="javascript:NewCssCal('ADate5')" />&nbsp;<img  src="images25/cancel.png" style="cursor:pointer"  height="12" width="15" onClick="return dateclear('ADate5');"/></td>

																																																				 <td width="89" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">LIGHT DUTY TO :</span></td>

																																																				 <td width="167" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="ADate6" id="ADate6" onFocus="return datevalidation1()" value="<?php //echo $transactiondatefrom; ?>"  size="10"   onKeyDown="return disableEnterKey()" onChange="return DateDiff1();" readonly/>

																																																				   <img  src="images2/cal.gif" style="cursor:pointer"  onClick="javascript:NewCssCal('ADate6')" />&nbsp;<img  src="images25/cancel.png" style="cursor:pointer"  height="12" width="15" onClick="return dateclear('ADate6');"/></td>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">No. of Days : </span></td>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="nodays2" id="nodays2" value="<?php //echo $transactiondatefrom; ?>"  size="7"  readonly="readonly" onKeyDown="return disableEnterKey()" /></td>

																																																				 <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

																																																				</tr>

																																																				

																																																			   <tr>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">REMARKS : </span></td>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">

																																																				   <input name="remarks" id="remarks" value=""  size="15"  onKeyDown="return disableEnterKey()" /></span></td>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> </td>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">

																																																				  </span></td>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

																																																				 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

																																																				 <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

																																																				</tr>

			  

            </tbody>

          </table>

				   </td>

                     </tr>

                     

                     

                 <?php } ?>     

						

				

	

				 <tr>

				 

				    <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Grand Total Amount</strong>

			        <input type="text" id="total4" name="grandtotal1" readonly size="7">

                   <!-- <input type="hidden" id="gt" name="grandtotal1" readonly size="7">-->

                    </td>

		        </tr> 

				<tr>

                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center">IP Admit</div></td>

                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="ipadmit" id="ipadmit" onClick="return notescheck();"></td>

				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="center" id="noteslable">Notes</div></td>

                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><textarea name="ipnotes" id="ipnotes"></textarea></td>

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



<?php include ("includes/footer1.php"); 

ob_end_flush();

?>

</body>

</html>

