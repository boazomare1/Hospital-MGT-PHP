<?php

session_start();

error_reporting(0);

set_time_limit(0);

//date_default_timezone_set('Asia/Calcutta');

include ("db/db_connect.php");

include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");

$indiandatetime = date ("d-m-Y H:i:s");

$dateonly = date("Y-m-d");

$timeonly = date("H:i:s");

$username = $_SESSION["username"];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];



$titlestr = 'SALES BILL';

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{

    $visitcode = $_REQUEST["visitcode"];

	$patientcode = $_REQUEST["customercode"];

	$patientname = $_REQUEST["customername"];

	$consultationdate = date("Y-m-d");

	$accountname = $_REQUEST["account"];

	$billtype = $_REQUEST['billtype'];

	$subtypeano = $_REQUEST['subtypeano'];

	$patientage = $_REQUEST['patientage'];

	$patientgender = $_REQUEST['patientgender'];

	$dispensingfee = $_REQUEST['dispensingfee'];

	$locationname = $_REQUEST['locationname'];

	$locationcode = $_REQUEST['locationcode'];

	$planforall = $_REQUEST['planforall'];

	$approvecomment = isset($_REQUEST['approvecomment'])?$_REQUEST['approvecomment']:'';

	$override = isset($_REQUEST['approve'])?$_REQUEST['approve']:'';

	$schemecode = isset($_REQUEST['approvecomment'])?$_REQUEST['approvecomment']:'';

	$approvallimit = isset($_REQUEST['approvallimit'])?$_REQUEST['approvallimit']:'';

	$availablelimit = isset($_REQUEST['availablelimit'])?$_REQUEST['availablelimit']:'';

	

	$counter='';

	$qrytemplate = "select * from master_subtype where auto_number= $subtypeano";

	$exectemplate = mysqli_query($GLOBALS["___mysqli_ston"], $qrytemplate) or die ("Error in qrytemplate".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	$restemplate = mysqli_fetch_array($exectemplate);

	 $currency = $restemplate['currency'];

	 $labtemplate = $restemplate['labtemplate'];

	 $radtemplate = $restemplate['radtemplate'];

	 $sertemplate = $restemplate['sertemplate'];

	 

/*	$queryapprove = "INSERT INTO completed_billingpaylater(override,comments,schemecode,netbillamount, availablelimit) VALUES($override, $schemecode, $approvallimit, $availablelimit)";

	$execapprove = mysql_query($queryapprove) or die ("Error in Queryapprove".mysql_error().__LINE__);

*/	

	 $query221 = "select * from master_consultation where patientcode='$patientcode' and patientvisitcode='$visitcode' ";

	 $exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	 $rowcount221 = mysqli_num_rows($exec221);

	 $res221=mysqli_fetch_array($exec221);

	 $patientauto_number=$res221['patientauto_number'];

	 $patientvisitauto_number=$res221['patientvisitauto_number'];

	 $consultationid=$res221['consultation_id'];

	

	

	mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultation set approvalstatus='completed' where patientcode='$patientcode' and patientvisitcode='$visitcode' ");

	

	if($billtype =='PAY NOW' || $planforall == 'yes')

	{

	$status='pending';

	}

	else

	{

	$status='completed';

	}

	

	$query2 = "select * from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number desc limit 0, 1";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	$res2 = mysqli_fetch_array($exec2);

	$medrefnonumber = $res2["refno"];



	foreach($_POST['aitemcode'] as $key => $value)

	{

	$aitemcode = $_POST['aitemcode'][$key];

	$adays = $_POST['adays'][$key];

	$adose = $_POST['adose'][$key];

	$aquantity = $_POST['aquantity'][$key];

	$aroute = $_POST['aroute'][$key];

	$ainstructions = $_POST['ainstructions'][$key];

	$aamount =  $_POST['aamount'][$key];

	$afrequency = $_POST['afrequency'][$key];

	

	$sele=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_frequency where frequencycode='$afrequency'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	$ress=mysqli_fetch_array($sele);

	$frequencyautonumber=$ress['auto_number'];

	$frequencycode=$ress['frequencycode'];

	

	$query34 = "update master_consultationpharm set days='$adays',dose='$adose',quantity='$aquantity',route='$aroute',instructions='$ainstructions',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode'";

	$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__); 

	

	$query35 = "update master_consultationpharmissue set days='$adays',dose='$adose',prescribed_quantity='$aquantity',quantity='$aquantity',route='$aroute',instructions='$ainstructions',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode'";

	$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__); 

	

	}



	

	/*for ($p=1;$p<=20;$p++)

	{*/

	foreach($_POST['medicinename'] as $key => $value)

	{	

	

	 $key;

		

		

		$medicinename = $_REQUEST['medicinename'][$key];

		$query77="select * from master_medicine where itemname='$medicinename'";

		$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);

		$res77=mysqli_fetch_array($exec77);

		$medicinecode=$res77['itemcode'];

		$dose = $_REQUEST['dose'][$key];

		$frequency = $_REQUEST['frequency'][$key];

		$sele=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_frequency where frequencycode='$frequency'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$ress=mysqli_fetch_array($sele);

		$frequencyautonumber=$ress['auto_number'];

		$frequencycode=$ress['frequencycode'];

		$frequencynumber=$ress['frequencynumber'];

		$days = $_REQUEST['days'][$key];

		$quantity = $_REQUEST['quantity'][$key];

		$route = $_REQUEST['route'][$key];

		$instructions = $_REQUEST['instructions'][$key];

		$rate = $_REQUEST['rates'][$key];

		$amount = $_REQUEST['amount'][$key];

		$exclude = $_REQUEST['exclude'][$key];

		 $dosemeasure = $_REQUEST['dosemeasure'][$key];

		

		

		$serquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultationpharm where  patientcode='$patientcode' and patientvisitcode='$visitcode'");

		if(mysqli_num_rows($serquery)!=0)

		{

		$execser=mysqli_fetch_array($serquery);

		$consultationtime=$execser['consultationtime'];

		$refno=$execser['refno'];

		$consultingdoctor=$execser['consultingdoctor'];

		}

		else

		{

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

		$consultationtime =date("H:i:s");;

		$consultingdoctor=$res221['consultingdoctor'];

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

		

		$pharamapprovalstatus = isset($_REQUEST['pharamcheck'][$key]);

		$pharamapprovalstatus1 = isset($_REQUEST['pharamlatertonow'][$key]);

		 

		if ($medicinename != "")

		{

		

		 if($pharamapprovalstatus=='1')

		{

			if($planforall!='yes')

			{

			$status='completed';

			}

			else

			{

			$status='pending';

			}

			$approvalstatus=1;

			

		 $query2 = "insert into master_consultationpharm(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,pharmacybill,medicineissue,source,route,approvalstatus,excludestatus,locationname, locationcode,dosemeasure) 

			values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisitauto_number','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','pending','$medicinecode','$medrefnonumber','$status','pending','doctorconsultation','$route','$approvalstatus','$exclude','$locationname', '$locationcode','$dosemeasure')";   

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			

			$query29 = "insert into master_consultationpharmissue(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,prescribed_quantity,source,route,approvalstatus,excludestatus,locationname, locationcode,dosemeasure) 

			values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisitauto_number','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','$status','$medicinecode','$medrefnonumber','$quantity','doctorconsultation','$route','$approvalstatus','$exclude','$locationname', '$locationcode','$dosemeasure')";

			$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$counter=$counter + 1;

			

		}

		else if($pharamapprovalstatus1=='1')

		{ 

			$status='pending';

			$approvalstatus=2;

		

		//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")

		

			//echo '<br>'. 

			$query2 = "insert into master_consultationpharm(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,pharmacybill,medicineissue,source,route,approvalstatus,excludestatus,locationname, locationcode) 

			values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisitauto_number','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','pending','$medicinecode','$medrefnonumber','$status','pending','doctorconsultation','$route','$approvalstatus','$exclude','$locationname', '$locationcode')";   

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			

			$query29 = "insert into master_consultationpharmissue(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,prescribed_quantity,source,route,approvalstatus,excludestatus,locationname, locationcode) 

			values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisitauto_number','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','$status','$medicinecode','$medrefnonumber','$quantity','doctorconsultation','$route','$approvalstatus','$exclude','$locationname', '$locationcode')";

		$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$counter=$counter + 1;

		}

		} 

	} 

	for($i=1;$i<20;$i++)

	{		

	

	    $pharamapprovalstatus = isset($_POST['pharamcheck'][$i])?'1':'0';

		$pharamapprovalstatus = isset($_POST['pharamlatertonow'][$i])?'2':$pharamapprovalstatus; 

		$pharamcheck=trim($_POST['pharamanum'][$i]);  

		

		if($pharamcheck!='' && $pharamapprovalstatus=='0')

		{ //echo "update master_consultationpharmissue set approvalstatus='$pharamapprovalstatus',paymentstatus='pending'  where auto_number='$pharamcheck' and patientvisitcode='$visitcode'";

			mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharmissue set approvalstatus='$pharamapprovalstatus',paymentstatus='pending'  where auto_number='$pharamcheck' and patientvisitcode='$visitcode'");

			mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharm set approvalstatus='$pharamapprovalstatus', paymentstatus='pending', pharmacybill='pending'  where auto_number='$pharamcheck' and patientvisitcode='$visitcode'");

			$counter=$counter + 1;

		}

		

	else if($pharamcheck!='' && $pharamapprovalstatus=='1' && $planforall!='yes')

		{ 

			mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharmissue set approvalstatus='$pharamapprovalstatus',paymentstatus='completed'  where auto_number='$pharamcheck' and patientvisitcode='$visitcode'");

			mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharm set approvalstatus='$pharamapprovalstatus', paymentstatus='completed',pharmacybill='$status'  where auto_number='$pharamcheck' and patientvisitcode='$visitcode'");

			$counter=$counter + 1;

		}

		else if($pharamcheck!='' && $pharamapprovalstatus=='2')

		{ //echo "update master_consultationpharmissue set approvalstatus='$pharamapprovalstatus',paymentstatus='pending'  where auto_number='$pharamcheck' and patientvisitcode='$visitcode'";

			mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharmissue set approvalstatus='$pharamapprovalstatus',paymentstatus='pending'  where auto_number='$pharamcheck' and patientvisitcode='$visitcode'");

			mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharm set approvalstatus='$pharamapprovalstatus',pharmacybill='pending'  where auto_number='$pharamcheck' and patientvisitcode='$visitcode'");

			$counter=$counter + 1;

		}

	}  

	foreach($_POST['labanum'] as $key => $value)

	{

	

					 $key;

		$labname=$_POST['lab'][$key];

		$labquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_lab where itemname='$labname'");

		$execlab=mysqli_fetch_array($labquery);

		$labcode=$execlab['itemcode'];

		$labrate=$_POST['rate5'][$key];

		

		$labchecknow = isset($_POST['labcheck'][$key]);

		$lablater = isset($_POST['lablatertonow'][$key]);

		//if($labapprovalstatus1==1){echo $labapprovalstatus1=2;} 

		

		

		$serquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_lab where  patientcode='$patientcode' and patientvisitcode='$visitcode'");

		if(mysqli_num_rows($serquery)!=0)

		{

		$execser=mysqli_fetch_array($serquery);

		$consultationtime=$execser['consultationtime'];

		$refno=$execser['refno'];

		}

		else

		{

		$query31 = "select * from master_company where companystatus = 'Active'";

		$exec31= mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$res31 = mysqli_fetch_array($exec31);

		$radrefnoprefix = $res31['labrefnoprefix'];

		$radrefnoprefix1=strlen($radrefnoprefix);

		$query21 = "select * from consultation_lab order by auto_number desc limit 0, 1";

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

		$refno = $radrefnoprefix.$maxanum;

		$consultationtime =date("H:i:s");;

		$openingbalance = '0.00';

		}

		}



		 

		

		if(($labname!='')&&($labrate!=''))

		{

		

		

		 if($labchecknow==1)

		{

			if($planforall!='yes')

			{

			$status='completed';

			}

			else

			{

			$status='pending';

			}

			$approvalstatus=1;

			

		

				  

		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_lab(consultationid,patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billtype,accountname,consultationdate,paymentstatus,labsamplecoll,resultentry,labrefund,approvalstatus,locationname, locationcode,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$billtype','$accountname','$consultationdate','$status','pending','pending','norefund','$approvalstatus', '$locationname', '$locationcode','$username','$refno','$consultationtime')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$counter=$counter + 1;

			

		}

		else if($lablater=='1')

		{ 

			$status='pending';

			$approvalstatus=2;

		

		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_lab(consultationid,patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billtype,accountname,consultationdate,paymentstatus,labsamplecoll,resultentry,labrefund,approvalstatus,locationname, locationcode,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$billtype','$accountname','$consultationdate','$status','pending','pending','norefund','$approvalstatus', '$locationname', '$locationcode','$username','$refno', '$consultationtime')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$counter=$counter + 1;

		}

		}

	}   

	for($i=0;$i<20;$i++)

	{		

		$labapprovalstatus = isset($_POST['labcheck'][$i])?'1':'0';
		if($_REQUEST["labcopayamount".$i] == $_REQUEST["labcashfixed".$i]){
			$labapprovalstatus = isset($_POST['laboverride'][$i])?'1':$labapprovalstatus;
		} else {
			$labapprovalstatus = isset($_POST['laboverride'][$i])?'2':$labapprovalstatus;
		}
		$labapprovalstatus = isset($_POST['lablatertonow'][$i])?'2':$labapprovalstatus;
		if (isset($_REQUEST["labcashinput".$i])) { $labcashcopay = $_REQUEST["labcashinput".$i]; } else { $labcashcopay = "0"; }
		$labcheck=$_POST['labanum'][$i];

		if($labcheck!='' && $labapprovalstatus=='0')

		{ 

	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set approvalstatus='$labapprovalstatus',cash_copay='$labcashcopay',paymentstatus='pending'  where auto_number='$labcheck' and patientvisitcode='$visitcode'");		

			$counter=$counter + 1;

		}

		if($labcheck!='' && $labapprovalstatus=='1')

		{

		$rateup='';

		if(strtoupper($currency)=='USD')

		{

		$qryrate = "select rateperunit as rate from $labtemplate where itemcode in (select labitemcode from consultation_lab where auto_number = $labcheck and patientvisitcode='$visitcode')";

		$execrate=mysqli_query($GLOBALS["___mysqli_ston"], $qryrate) or die("Error in qryrate".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$resrate = mysqli_fetch_array($execrate); 

		$rate =  $resrate['rate'];

		$rateup=",labitemrate='$rate'";

		} 

 mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set approvalstatus='$labapprovalstatus',cash_copay='$labcashcopay',paymentstatus='$status'".$rateup."  where auto_number='$labcheck' and patientvisitcode='$visitcode'");		

			$counter=$counter + 1;

		}

		

		else if($labcheck!='' && $labapprovalstatus=='2')

		{

		$rateup='';

		if(strtoupper($currency)=='USD')

		{

		$qryrate = "select rateperunit as rate from master_lab where itemcode in (select labitemcode from consultation_lab where auto_number = $labcheck and patientvisitcode='$visitcode')";

		$execrate=mysqli_query($GLOBALS["___mysqli_ston"], $qryrate) or die("Error in qryrate".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$resrate = mysqli_fetch_array($execrate); 

		$rate =  $resrate['rate'];

		$rateup=",labitemrate='$rate'";

		}

		mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set approvalstatus='$labapprovalstatus',cash_copay='$labcashcopay',paymentstatus='pending'".$rateup." where auto_number='$labcheck' and patientvisitcode='$visitcode'");		

     $counter=$counter + 1;

		}

	} 

	foreach($_POST['radiology'] as $key=>$value)

	{	

			//echo '<br>'.

		$pairs= $_POST['radiology'][$key];

		$pairvar= $pairs;

	    $pairs1= $_POST['rate8'][$key];

		$pairvar1= $pairs1;

		

		$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_radiology where itemname='$pairvar'");

		$execradiology=mysqli_fetch_array($radiologyquery);

		$radiologycode=$execradiology['itemcode'];

		

		

		$serquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_radiology where  patientcode='$patientcode' and patientvisitcode='$visitcode'");

		if(mysqli_num_rows($serquery)!=0)

		{

		$execser=mysqli_fetch_array($serquery);

		$consultationtime=$execser['consultationtime'];

		$refno=$execser['refno'];

		}

		else

		{

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

		$refno = $radrefnoprefix.$maxanum;

		$consultationtime =date("H:i:s");;

		$openingbalance = '0.00';

		}

		}

		$radapprovalstatus = isset($_POST['radcheck'][$key]);

		$radapprovalstatus1 = isset($_POST['radlatertonow'][$key]);

		

		

		if(($pairvar!="")&&($pairvar1!=""))

		{

		 if( $radapprovalstatus=='1')

		{ 

			if($planforall!='yes')

			{

			$status='completed';

			}

			else

			{

			$status='pending';

			}

			$approvalstatus=1;

			

		$radiologyquery1="insert into consultation_radiology(consultationid,patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billtype,accountname,consultationdate,paymentstatus,resultentry,approvalstatus,locationname, locationcode,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$radiologycode','$pairvar','$pairvar1','$billtype','$accountname','$consultationdate','$status','pending','$approvalstatus','$locationname', '$locationcode','$username','$refno', '$consultationtime')";

		$radiologyexecquery1=mysqli_query($GLOBALS["___mysqli_ston"], $radiologyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$radiologyquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set radiologybill='pending' where visitcode='$visitcode'");

		$counter=$counter + 1;

		}

		else if( $radapprovalstatus1=='1')

		{

			$status='pending';

			$approvalstatus=2;

		

		

		$radiologyquery1="insert into consultation_radiology(consultationid,patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billtype,accountname,consultationdate,paymentstatus,resultentry,approvalstatus,locationname, locationcode,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$radiologycode','$pairvar','$pairvar1','$billtype','$accountname','$consultationdate','$status','pending','$approvalstatus','$locationname', '$locationcode','$username','$refno', '$consultationtime' )";

		$radiologyexecquery1=mysqli_query($GLOBALS["___mysqli_ston"], $radiologyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$radiologyquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set radiologybill='pending' where visitcode='$visitcode'");

		$counter=$counter + 1;

		}

		}

	}

	for($i=0;$i<20;$i++)

	{		

		$radapprovalstatus = isset($_POST['radcheck'][$i])?'1':'0';
		if($_REQUEST["radcopayamount".$i] == $_REQUEST["radcashfixed".$i]){
			$radapprovalstatus = isset($_POST['radoverride'][$i])?'1':$radapprovalstatus;
		} else {
			$radapprovalstatus = isset($_POST['radoverride'][$i])?'2':$radapprovalstatus;
		}
		$radapprovalstatus = isset($_POST['radlatertonow'][$i])?'2':$radapprovalstatus;
		if (isset($_REQUEST["radcashinput".$i])) { $radcashcopay = $_REQUEST["radcashinput".$i]; } else { $radcashcopay = "0"; }
		if (isset($_REQUEST["raddiscountinput".$i])) { $raddiscount = $_REQUEST["raddiscountinput".$i]; } else { $raddiscount = "0"; }
		if (isset($_REQUEST["raditemrate".$i])) { $raditemrate1 = $_REQUEST["raditemrate".$i]; }
		$radcheck=$_POST['radanum'][$i];

		if($radcheck!='' && $radapprovalstatus=='0')

		{ 

			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set approvalstatus='$radapprovalstatus',cash_copay='$radcashcopay',discount='$raddiscount',paymentstatus='pending',radiologyitemrate='$raditemrate1' where auto_number='$radcheck' and patientvisitcode='$visitcode'");

			$counter=$counter + 1;

		}

		

		else if($radcheck!='' && $radapprovalstatus=='1')

		{ 

		$rateup='';

		if(strtoupper($currency)=='USD')

		{  

		$qryrate = "select rateperunit as rate from $radtemplate where itemcode in (select radiologyitemcode from consultation_radiology where auto_number = $radcheck and patientvisitcode='$visitcode')";

		$execrate=mysqli_query($GLOBALS["___mysqli_ston"], $qryrate) or die("Error in qryrate".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$resrate = mysqli_fetch_array($execrate); 

		$rate =  $resrate['rate'];

		$rateup=",radiologyitemrate='$rate' ";

		}

			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set approvalstatus='$radapprovalstatus',cash_copay='$radcashcopay',discount='$raddiscount',paymentstatus='$status'".$rateup.",radiologyitemrate='$raditemrate1'  where auto_number='$radcheck' and patientvisitcode='$visitcode'");

			$counter=$counter + 1;

		}

		else if($radcheck!='' && $radapprovalstatus=='2')

		{

		$rateup='';

		if(strtoupper($currency)=='USD')

		{  

		$qryrate = "select rateperunit as rate from master_radiology where itemcode in (select radiologyitemcode from consultation_radiology where auto_number = $radcheck and patientvisitcode='$visitcode')";

		$execrate=mysqli_query($GLOBALS["___mysqli_ston"], $qryrate) or die("Error in qryrate".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$resrate = mysqli_fetch_array($execrate); 

		$rate =  $resrate['rate'];

		$rateup=",radiologyitemrate='$rate' ";

		}

			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set approvalstatus='$radapprovalstatus',cash_copay='$radcashcopay',discount='$raddiscount',paymentstatus='pending'".$rateup.",radiologyitemrate='$raditemrate1' where auto_number='$radcheck' and patientvisitcode='$visitcode'");

			$counter=$counter + 1;

		}

	} 

	foreach($_POST['services'] as $key => $value)

	{

				    //echo '<br>'.$k;

		$servicesname=$_POST["services"][$key];

		$servicequery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_services where itemname='$servicesname'");

		$execservice=mysqli_fetch_array($servicequery);

		$servicescode=$execservice['itemcode'];

		

		$serquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_services where  patientcode='$patientcode' and patientvisitcode='$visitcode'");

		if(mysqli_num_rows($serquery)!=0)

		{

		$execser=mysqli_fetch_array($serquery);

		$consultationtime=$execser['consultationtime'];

		$refno=$execser['refno'];

		}

		else

		{

		$query31 = "select * from master_company where companystatus = 'Active'";

		$exec31= mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$res31 = mysqli_fetch_array($exec31);

		$radrefnoprefix = $res31['serrefnoprefix'];

		$radrefnoprefix1=strlen($radrefnoprefix);

		$query21 = "select * from consultation_lab order by auto_number desc limit 0, 1";

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

		$refno = $radrefnoprefix.$maxanum;

		$consultationtime =date("H:i:s");;

		$openingbalance = '0.00';

		}

		}

		

		$servicesrate=$_POST["rate3"][$key];

		$serviceqty=$_POST['serviceqty'][$key];

		$seramount=$serviceqty*$servicesrate;

		

		$serapprovalstatus = isset($_POST['sercheck'][$key]);

		$serapprovalstatus1 = isset($_POST['serlatertonow'][$key]);

		$sercheck=$_POST['seranum'][$i];

		

		/*for($se=1;$se<=$serviceqty;$se++)

		{

		*/

		if(($servicesname!="")&&($servicesrate!=''))

		{

		

		 if( $serapprovalstatus=='1')

		{

			if($planforall!='yes')

			{

			$status='completed';

			}

			else

			{

			$status='pending';

			}

			$approvalstatus=1;

			

			$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_services(consultationid,patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,billtype,accountname,consultationdate,paymentstatus,process,approvalstatus,locationname, locationcode, serviceqty,amount,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$billtype','$accountname','$consultationdate','$status','pending','$approvalstatus', '$locationname', '$locationcode','$serviceqty','$seramount','$username','$refno', '$consultationtime')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$servicesquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set servicebill='pending' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			$counter=$counter + 1;

			

		}

		else if( $serapprovalstatus1=='1')

		{

			$status='pending';

			$approvalstatus=2;

		

		

			$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_services(consultationid,patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,billtype,accountname,consultationdate,paymentstatus,process,approvalstatus,locationname, locationcode,serviceqty,amount,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$billtype','$accountname','$consultationdate','$status','pending','$approvalstatus', '$locationname', '$locationcode','$serviceqty','$seramount','$username','$refno', '$consultationtime')") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$servicesquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set servicebill='pending' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			$counter=$counter + 1;

		}

		}

		//}

	}

	

	for($i=0;$i<20;$i++)

	{		

		$refapprovalstatus = isset($_POST['refcheck'][$i])?'1':'0';

		echo $refcheck = $_POST['refanum'][$i];

		

		if($refcheck!='' && $refapprovalstatus=='1')

		{

		

			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_referal set paymentstatus='completed' where auto_number='$refcheck' and patientvisitcode='$visitcode'")or die("error ref update");

			

			$counter=$counter + 1;

		}

	} 

	

	for($i=0;$i<20;$i++)

	{		

		$deprefapprovalstatus = isset($_POST['deprefcheck'][$i])?'1':'0';

		echo $deprefcheck = $_POST['deprefanum'][$i];

		

		if($deprefcheck!='' && $deprefapprovalstatus=='1')

		{

		

			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_departmentreferal set paymentstatus='completed' where auto_number='$deprefcheck' and patientvisitcode='$visitcode'")or die("error ref update");

			

			$counter=$counter + 1;

		}

	} 



	for($i=0;$i<20;$i++)

	{

		$serapprovalstatus = isset($_POST['sercheck'][$i])?'1':'0';
		if($_REQUEST["sercopayamount".$i] == $_REQUEST["sercashfixed".$i]){
			$serapprovalstatus = isset($_POST['seroverride'][$i])?'1':$serapprovalstatus;
		} else {
			$serapprovalstatus = isset($_POST['seroverride'][$i])?'2':$serapprovalstatus;
		}
		$serapprovalstatus = isset($_POST['serlatertonow'][$i])?'2':$serapprovalstatus;
		if (isset($_REQUEST["sercashinput".$i])) { $sercashcopay = $_REQUEST["sercashinput".$i]; } else { $sercashcopay = "0"; }
		$sercheck=$_POST['seranum'][$i];

		if($sercheck!='' && $serapprovalstatus=='0')

		{

			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set approvalstatus='$serapprovalstatus',cash_copay='$sercashcopay',paymentstatus='pending'  where auto_number='$sercheck' and patientvisitcode='$visitcode'");		

			$counter=$counter + 1;

		}

		

		else if($sercheck!='' && $serapprovalstatus=='1')

		{

		$rateup='';

		if(strtoupper($currency)=='USD')

		{ 

		$qryrate = "select rateperunit as rate from $sertemplate where itemcode in (select servicesitemcode from consultation_services where auto_number = $sercheck and patientvisitcode='$visitcode')";

		$execrate=mysqli_query($GLOBALS["___mysqli_ston"], $qryrate) or die("Error in qryrate".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$resrate = mysqli_fetch_array($execrate); 

		$rate =  $resrate['rate'];

		$rateup=",servicesitemrate='$rate',amount=$rate*serviceqty";

		}

			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set approvalstatus='$serapprovalstatus',cash_copay='$sercashcopay',paymentstatus='$status'".$rateup."  where auto_number='$sercheck' and patientvisitcode='$visitcode'");		

			$counter=$counter + 1;

			

			$query21 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode'    and wellnesspkg = '1' and auto_number='$sercheck'  ";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			while($res21 = mysqli_fetch_array($exec21))

			{

			

		

		$servicescode=$res21['servicesitemcode'];



	 $qryhcser = "select * from healthcarepackagelinking where servicecode like '$servicescode'  and recordstatus <> 'deleted' ";

	$exechcser = mysqli_query($GLOBALS["___mysqli_ston"], $qryhcser) or die("Error in Qryhcser ".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	while($resser = mysqli_fetch_array($exechcser))

	{

		 $servcode = $resser['itemcode'];

		

		mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set approvalstatus='$serapprovalstatus',cash_copay='$sercashcopay',paymentstatus='$status'".$rateup."  where servicesitemcode='$servcode' and patientvisitcode='$visitcode'");	

		

	}

	

}

		}

		else if($sercheck!='' && $serapprovalstatus=='2')

		{

		$rateup='';

		if(strtoupper($currency)=='USD')

		{ 

		$qryrate = "select rateperunit as rate from master_services where itemcode in (select servicesitemcode from consultation_services where auto_number = $sercheck and patientvisitcode='$visitcode')";

		$execrate=mysqli_query($GLOBALS["___mysqli_ston"], $qryrate) or die("Error in qryrate".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$resrate = mysqli_fetch_array($execrate); 

		$rate =  $resrate['rate'];

		$rateup=",servicesitemrate='$rate',amount=$rate*serviceqty";

		}

			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set approvalstatus='$serapprovalstatus',cash_copay='$sercashcopay',paymentstatus='pending'".$rateup."  where auto_number='$sercheck' and patientvisitcode='$visitcode'");		

			$counter=$counter + 1;

			

			 $query21 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and  wellnesspkg = '1' and auto_number='$sercheck'  ";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			while($res21 = mysqli_fetch_array($exec21))

			{

			

		

		$servicescode=$res21['servicesitemcode'];



	$qryhcser = "select * from healthcarepackagelinking where servicecode like '$servicescode'  and recordstatus <> 'deleted' ";

	$exechcser = mysqli_query($GLOBALS["___mysqli_ston"], $qryhcser) or die("Error in Qryhcser ".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	while($resser = mysqli_fetch_array($exechcser))

	{

		$servcode = $resser['itemcode'];

				mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set approvalstatus='$serapprovalstatus',cash_copay='$sercashcopay',paymentstatus='pending'".$rateup."  where servicesitemcode='$servcode' and patientvisitcode='$visitcode'");	

		

	}

	

}

		}

	}

	//exit;

	if($counter>0)

	{

		$query2bill = "select * from approvalstatus order by auto_number desc limit 0, 1";

		$exec2bill = mysqli_query($GLOBALS["___mysqli_ston"], $query2bill) or die ("Error in Query2bill".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$res2bill = mysqli_fetch_array($exec2bill);

		$billnumber = $res2bill["docno"];

		if ($billnumber == '')

		{

			$billnumbercode ='APP-'.'1';

			$openingbalance = '0.00';

		}

		else

		{

			$billnumber = $res2bill["docno"];

			$billnumbercode = substr($billnumber, 4, 8);

			$billnumbercode = intval($billnumbercode);

			$billnumbercode = $billnumbercode + 1;		

			$maxanum = $billnumbercode;						

			$billnumbercode = 'APP-' .$maxanum;

			$openingbalance = '0.00';

			//echo $companycode;

		}

		/*$queryapprove = "INSERT INTO completed_billingpaylater(override,comments,schemecode,netbillamount, availablelimit) VALUES($override, $schemecode, $approvallimit, $availablelimit)";

	$execapprove = mysql_query($queryapprove) or die ("Error in Queryapprove".mysql_error().__LINE__);*/

	

	if($override==1)

	{

		$query2bill1 = "select auto_number from master_planname where accountname = '".$accountname."'";

		$exec2bill1 = mysqli_query($GLOBALS["___mysqli_ston"], $query2bill1) or die ("Error in Query2bill".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$res2bill1 = mysqli_fetch_array($exec2bill1);

		$schemecode = $res2bill1["auto_number"];

		}

	

		$queryinsert = "insert into approvalstatus (recorddate,recordtime,docno,patientname,visitcode,patientcode,age,gender,billtype,accountname,ipaddress,username,override,comments,schemecode,netbilledamount, availablelimit,locationname,locationcode) values

		('$dateonly','$timeonly','$billnumbercode','$patientname','$visitcode','$patientcode','$patientage','$patientgender','$billtype','$accountname','$ipaddress','$username','$override','$approvecomment', '$schemecode', '$approvallimit', '$availablelimit','".$locationname."','".$locationcode."')";

		mysqli_query($GLOBALS["___mysqli_ston"], $queryinsert) or die ("Error in Queryinsert".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		

	}

	if($dispensingfee != '')

	{

	    $query2bill1 = "select * from dispensingfee order by auto_number desc limit 0, 1";

		$exec2bill1 = mysqli_query($GLOBALS["___mysqli_ston"], $query2bill1) or die ("Error in Query2bill".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$res2bill1 = mysqli_fetch_array($exec2bill1);

		$billnumber1 = $res2bill1["docno"];

		if ($billnumber1 == '')

		{

			$billnumbercode1 ='DSF-'.'1';

			$openingbalance = '0.00';

		}

		else

		{

			$billnumber1 = $res2bill1["docno"];

			$billnumbercode1 = substr($billnumber1, 4, 8);

			$billnumbercode1 = intval($billnumbercode1);

			$billnumbercode1 = $billnumbercode1 + 1;		

			$maxanum1 = $billnumbercode1;						

			$billnumbercode1 = 'DSF-' .$maxanum1;

			$openingbalance = '0.00';

			//echo $companycode;

		}

	   $queryinsert1 = "insert into dispensingfee (recorddate,recordtime,patientname,visitcode,patientcode,age,gender,billtype,accountname,ipaddress,username,dispensingfee,docno) values

		('$dateonly','$timeonly','$patientname','$visitcode','$patientcode','$patientage','$patientgender','$billtype','$accountname','$ipaddress','$username','$dispensingfee','$billnumbercode1')";

		mysqli_query($GLOBALS["___mysqli_ston"], $queryinsert1) or die ("Error in Queryinsert1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		}

		header("location:approvallist.php");

		exit;

}





//to redirect if there is no entry in masters category or item or customer or settings







//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.

if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }

if(isset($_REQUEST['delete']))

{

$auto_number=$_REQUEST['delete'];

$viscode=$_REQUEST['visitcode'];



$remove=$_REQUEST['remove'];

if($remove=='pharm'){

mysqli_query($GLOBALS["___mysqli_ston"], "delete from master_consultationpharm where auto_number='$auto_number' and patientvisitcode='$viscode'");

mysqli_query($GLOBALS["___mysqli_ston"], "delete from master_consultationpharmissue where auto_number='$auto_number' and patientvisitcode='$viscode'");

}

if($remove=='lab'){

mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_lab where auto_number='$auto_number' and patientvisitcode='$viscode'");

}

if($remove=='radiology'){

mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_radiology where auto_number='$auto_number' and patientvisitcode='$viscode'");

}

if($remove=='service'){

mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_services where auto_number='$auto_number' and patientvisitcode='$viscode'");

}

if($remove=='referal'){

mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_referal where auto_number='$auto_number' and patientvisitcode='$viscode'");

}

if($remove=='depreferal'){

mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_departmentreferal where auto_number='$auto_number' and patientvisitcode='$viscode'");

}

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

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";

$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

$res78=mysqli_fetch_array($exec78);

$patientage=$res78['age'];

$patientgender=$res78['gender'];

$subtypeanum = $res78['subtype'];

$availableilimit = $res78['availableilimit'];

$patientname=$res78['patientfullname'];

$patientaccount=$res78['accountfullname'];

$res111paymenttype = $res78['paymenttype'];

$locationcode = $res78['locationcode'];

$planname=$res78['planname'];

$res111subtype=$subtypeanum;





$query1211 = "select * from master_location where locationcode = '$locationcode'";

$exec1211 = mysqli_query($GLOBALS["___mysqli_ston"], $query1211) or die (mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

$res1211 = mysqli_fetch_array($exec1211);

 $locationname = $res1211['locationname'];





$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";

$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die (mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

$res121 = mysqli_fetch_array($exec121);

$res121paymenttype = $res121['paymenttype'];



$query131 = "select * from master_subtype where auto_number = '$subtypeanum'";

$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

$res131 = mysqli_fetch_array($exec131);

$res131subtype = $res131['subtype'];



$queryplanname = "select * from master_planname where auto_number ='".$planname."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//

			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			$resplanname = mysqli_fetch_array($execplanname);

		 	$planforall = $resplanname['forall'];

?>



<?php

$querylab7=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'");

$execlab7=mysqli_fetch_array($querylab7);

$billtype=$execlab7['billtype'];



?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

$res3 = mysqli_fetch_array($exec3);

$labprefix = $res3['labprefix'];



$query2 = "select * from approvalstatus order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];



if ($billnumber == '')

{

	$billnumbercode ='APP-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["docno"];

	$billnumbercode = substr($billnumber, 4, 8);

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = 'APP-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}


?>

<link href="css/jquery-ui.css" rel="stylesheet">

<script type="text/javascript" src="jquery/jquery-1.11.3.min.js"></script>

<script type="text/javascript" src="jquery/jquery-ui.js"></script>

<script language="javascript">

$('#medicinename').autocomplete({

source:"ajaxmedicine1search.php",

select:function (){

funcmedicinesearch4();

}

});

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

function Functionfrequency(i)

{

var i = i;



var formula = document.getElementById("aformula"+i+"").value;

formula = formula.replace(/\s/g, '');

//alert(formula);

if(formula == 'INCREMENT')

{

var ResultFrequency;

 var frequencyanum = document.getElementById("afrequency"+i+"").value;

var medicinedose=document.getElementById("adose"+i+"").value;

 var VarDays = document.getElementById("adays"+i+"").value; 



 if((frequencyanum != '') && (VarDays != ''))

 {

  ResultFrequency = medicinedose*frequencyanum * VarDays;

 }

 else

 {

 ResultFrequency =0;

 }

 document.getElementById("aquantity"+i+"").value = ResultFrequency;

var VarRate = document.getElementById("arate"+i+"").value;

var ResultAmount = parseFloat(VarRate * ResultFrequency);

  document.getElementById("aamount"+i+"").value = ResultAmount.toFixed(2);

}



else if(formula == 'CONSTANT')

{

var ResultFrequency;

var strength = document.getElementById("astrength"+i+"").value;

 var frequencyanum = document.getElementById("afrequency"+i+"").value;

var medicinedose=document.getElementById("adose"+i+"").value;

 var VarDays = document.getElementById("adays"+i+"").value; 

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

 document.getElementById("aquantity"+i+"").value = ResultFrequency;

 

 

var VarRate = document.getElementById("arate"+i+"").value;

var ResultAmount = parseFloat(VarRate * ResultFrequency);

  document.getElementById("aamount"+i+"").value = ResultAmount.toFixed(2);

}

}



function Functionfrequency1()

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



function deletevalid()

{

var del;

del=confirm("Do You want to delete this item ?");

if(del == false)

{

return false;

}

}

function btnDeleteClick10(delID,pharmamount, nam)

{

	//alert ("Inside btnDeleteClick.");

	var newtotal4;

	//alert(pharmamount);

	var varDeleteID = delID;

	var amount=pharmamount;

	//alert (varDeleteID);

	var fRet3; 

	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 

	//alert(fRet); 

	if (fRet3 == false)

	{

		//alert ("Item Entry Not Deleted.");

		return false;

	}



	if(document.getElementById(nam).checked==true)

	{

		//alert(amount);

		document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(' ', '').replace('.', '.').replace(/,/g,''))-parseFloat(amount.replace(' ', '').replace('.', '.').replace(/,/g,'')));

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

	

	document.getElementById('total').value=newtotal4;

	

	//grandtotalminus(pharmamount);

}

function btnDeleteClick6(delID1,vrate1, nam)

{

	//alert ("Inside btnDeleteClick.");

	var newtotal3;

	//alert(vrate1);

	var varDeleteID1 = delID1;

	var amount=vrate1;

	//alert(varDeleteID1);

	var fRet4; 

	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 

	//alert(fRet4); 

	if (fRet4 == false)

	{

		//alert ("Item Entry Not Deleted.");

		return false;

	}

	

	if(document.getElementById(nam).checked==true)

	{

		//alert(amount);

		document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(' ', '').replace('.', '.').replace(/,/g,''))-parseFloat(amount.replace(' ', '').replace('.', '.').replace(/,/g,'')));

		

		}

	

//alert(varDeleteID1);

	var child1 = document.getElementById('labidTR'+varDeleteID1);  //tr name

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

	newtotal3= currenttotal3-vrate1;                                      //when delete the row it will update the total

	

	//alert(newtotal3);

	

	document.getElementById('total1').value=newtotal3.toFixed(2);

	

	//grandtotalminus(vrate1);



}

function btnDeleteClick9(delID5,radrate, nam)

{

	//alert ("Inside btnDeleteClick.");

	var newtotal2;

	//alert(radrate);

	var varDeleteID2= delID5;

	var amount=radrate;

	//alert (varDeleteID2);

	var fRet5; 

	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 

	

	

	//alert(fRet); 

	if (fRet5 == false)

	{

		//alert ("Item Entry Not Deleted.");

		return false;

	}

	

	if(document.getElementById(nam).checked==true)

	{

		//alert(amount);

		document.getElementById("approvallimit").value=formatMonet(parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount));

		

		}

	



	var child2= document.getElementById('radidTR'+varDeleteID2);  //tr name

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

	

	//grandtotalminus(radrate);

	



	

}

function btnDeleteClick12(delID3,vrate3, nam)

{

	//alert (nam);

	var newtotal1;

	var varDeleteID3= delID3;

	var amount=vrate3;

	//alert (varDeleteID3);

	

	var fRet6; 

	fRet6 = confirm('Are You Sure Want To Delete This Entry?'); 

	//alert(fRet); 

	if (fRet6 == false)

	{

		//alert ("Item Entry Not Deleted.");

		return false;

	}

if(document.getElementById(nam).checked==true)

	{

		//alert(amount);

		document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount));

		

		}

	

	var child3 = document.getElementById('seridTR'+varDeleteID3);  

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

	//grandtotalminus(vrate3);

	

	

}





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

	

	// To handle ajax dropdown list.

	//funcCustomerDropDownSearch4();

	funcPopupPrintFunctionCall();

	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.	

	funcPopupPrintFunctionCall();

	funcCustomerDropDownSearch2(); 

	funcCustomerDropDownSearch3();

	

	/*funcCustomerDropDownSearch1();

	funcCustomerDropDownSearch2();	

	funcCustomerDropDownSearch3();

	funcCustomerDropDownSearch4(); 

	//funcCustomerDropDownSearch7();

	//funcCustomerDropDownSearch10();

	//funcCustomerDropDownSearch15();

	//funcOnLoadBodyFunctionCall1();//To handle ajax dropdown list.*/



		

}



function sertotal()

{

	var varquantityser = document.getElementById("serviceqty").value;

	var varserRates = document.getElementById("rate3").value;

	var totalservi = parseFloat(varquantityser) * parseFloat(varserRates);

	document.getElementById("serviceamount").value=totalservi.toFixed(2);

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



function selectall() {

//alert("check");

if(document.getElementById('selectalll').checked==true)

{

	for (i=1;i<20;i++){	

	if(document.getElementById('pharamcheck'+i))

	{

		if(document.getElementById('pharamcheck'+i).checked==false)

		{

   		 	pharamcheck = document.getElementById('pharamcheck'+i).checked = true ; 

			document.getElementById('pharamlatertonow'+i).checked = false;

			document.getElementById('pharamlatertonow'+i).disabled = true;

			var x = document.getElementById('pharamcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('amount'+i).value ;

			}

			approvalfunction(x.id,y);   		

		}

	}

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('labcheck'+i))

	{

		if(document.getElementById('labcheck'+i).checked==false)

		{

			labcheck = document.getElementById('labcheck'+i).checked = true;

			document.getElementById('lablatertonow'+i).checked = false;

			document.getElementById('lablatertonow'+i).disabled = true;

			var x = document.getElementById('labcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('rate5'+i).value ;

			}

			approvalfunction(x.id,y);

		}

	}	

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('radcheck'+i))

	{

		if(document.getElementById('radcheck'+i).checked==false)

		{

			radcheck = document.getElementById('radcheck'+i).checked = true;

			document.getElementById('radlatertonow'+i).checked = false;

			document.getElementById('radlatertonow'+i).disabled = true;

			var x = document.getElementById('radcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('rate8'+i).value ;

			}

			approvalfunction(x.id,y);	

		}

	}

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('sercheck'+i))

	{

		if(document.getElementById('sercheck'+i).checked==false)

		{

			sercheck = document.getElementById('sercheck'+i).checked = true;

			document.getElementById('serlatertonow'+i).checked = false;

			document.getElementById('serlatertonow'+i).disabled = true;

			var x = document.getElementById('sercheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('serviceamount'+i).value ;

			}

			approvalfunction(x.id,y);

		}

	}	

	}

	if(document.getElementById("availablelimit").value.replace(/,/g,'')<document.getElementById("approvallimit").value.replace(/,/g,'')) 
	{

		if(document.getElementById("approve").checked == false){
		alert("Approval Limit is exceeded Available Limit");

		}
	}

	if(parseFloat(document.getElementById("availablelimit").value.replace(/,/g,'')) < parseFloat(document.getElementById("approvallimit").value.replace(/,/g,'')))

	{

		if(document.getElementById("approve").checked ==false){

			alert("Approval limit is greater than Available limit");

			document.getElementById("approvallimit").value = '';

		
			for (i=1;i<20;i++){

				if(document.getElementById('pharamcheck'+i))

			{

			document.getElementById('pharamcheck'+i).checked=false;

			}

			}

			

			for (i=1;i<20;i++){

				if(document.getElementById('labcheck'+i))

			{

			document.getElementById('labcheck'+i).checked=false;

			}

			}

			

			for (i=1;i<20;i++){

				if(document.getElementById('radcheck'+i))

			{

			document.getElementById('radcheck'+i).checked=false;

			}

			}

			

			for (i=1;i<20;i++){

				if(document.getElementById('sercheck'+i))

			{

			document.getElementById('sercheck'+i).checked=false;

			}

			}

			document.getElementById('selectalll'+i).checked=false;

		}

	}

}

else

{

	for (i=1;i<20;i++){	

	if(document.getElementById('pharamcheck'+i))

	{

   		 if(document.getElementById('pharamcheck'+i).checked==false)

		{

		 	pharamcheck = document.getElementById('pharamcheck'+i).checked = false ;   

			document.getElementById('pharamlatertonow'+i).disabled = false;

			var x = document.getElementById('pharamcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('amount'+i).value ;

			}

			approvalfunction(x.id,y); 		

		}

	}

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('labcheck'+i))

	{

		if(document.getElementById('labcheck'+i).checked==false)

		{

			labcheck = document.getElementById('labcheck'+i).checked = false;

			document.getElementById('lablatertonow'+i).disabled = false;

			var x = document.getElementById('labcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('rate5'+i).value ;

			}

			approvalfunction(x.id,y);

		}

	}	

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('radcheck'+i))

	{

		if(document.getElementById('radcheck'+i).checked==false)

		{

			radcheck = document.getElementById('radcheck'+i).checked = false;

			document.getElementById('radlatertonow'+i).disabled = false;

			var x = document.getElementById('radcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('rate8'+i).value ;

			}

			approvalfunction(x.id,y);

		}	

	}

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('sercheck'+i))

	{

		if(document.getElementById('sercheck'+i).checked==false)

		{

			sercheck = document.getElementById('sercheck'+i).checked = false;

			document.getElementById('serlatertonow'+i).disabled = false;

			var x = document.getElementById('sercheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('serviceamount'+i).value ;

			}

			approvalfunction(x.id,y);

		}

	}	

	}

}

}

function approvecheck(){

	if(document.getElementById('approve').checked==true)

{

	for (i=1;i<20;i++){	

	if(document.getElementById('pharamcheck'+i))

	{

		if(document.getElementById('pharamcheck'+i).checked==false)

		{

   		 	pharamcheck = document.getElementById('pharamcheck'+i).checked = true ; 

			document.getElementById('pharamlatertonow'+i).checked = false; 

			document.getElementById('pharamlatertonow'+i).disabled = true; 

			var x = document.getElementById('pharamcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('amount'+i).value ;

			}

			approvalfunction(x.id,y); 		

		}

	}

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('labcheck'+i))

	{

		if(document.getElementById('labcheck'+i).checked==false)

		{

			labcheck = document.getElementById('labcheck'+i).checked = true;

			document.getElementById('lablatertonow'+i).checked = false;

			document.getElementById('lablatertonow'+i).disabled = true;

			var x = document.getElementById('labcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('rate5'+i).value ;

			}

			approvalfunction(x.id,y);

		}

	}	

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('radcheck'+i))

	{

		if(document.getElementById('radcheck'+i).checked==false)

		{

			radcheck = document.getElementById('radcheck'+i).checked = true;

			document.getElementById('radlatertonow'+i).checked = false;	

			document.getElementById('radlatertonow'+i).disabled = true;	

			var x = document.getElementById('radcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('rate8'+i).value ;

			}

			approvalfunction(x.id,y);

		}

	}

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('sercheck'+i))

	{

		if(document.getElementById('sercheck'+i).checked==false)

		{

			sercheck = document.getElementById('sercheck'+i).checked = true;

			document.getElementById('serlatertonow'+i).checked = false;

			document.getElementById('serlatertonow'+i).disabled = true;

			var x = document.getElementById('sercheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('serviceamount'+i).value ;

			}

			approvalfunction(x.id,y);

		}

	}	

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('refcheck'+i))

	{

		if(document.getElementById('refcheck'+i).checked==false)

		{

			rcheck = document.getElementById('refcheck'+i).checked = true;

			var x = document.getElementById('refcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}

			approvalfunction(x.id,y);

		}

	}	

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('deprefcheck'+i))

	{

		if(document.getElementById('deprefcheck'+i).checked==false)

		{

			rcheck = document.getElementById('deprefcheck'+i).checked = true;

			var x = document.getElementById('deprefcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}

			approvalfunction(x.id,y);

		}

	}	

	}

	document.getElementById('approvecomment').style.display = '';

}

else

{

	for (i=1;i<20;i++){	

	if(document.getElementById('pharamcheck'+i))

	{

   		 if(document.getElementById('pharamcheck'+i).disabled==false)

		{

		 	pharamcheck = document.getElementById('pharamcheck'+i).checked = false ;   

			document.getElementById('pharamlatertonow'+i).disabled = false; 

			var x = document.getElementById('pharamcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('amount'+i).value ;

			}

			approvalfunction(x.id,y);		

		}

	}

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('labcheck'+i))

	{

		if(document.getElementById('labcheck'+i).disabled==false)

		{

			labcheck = document.getElementById('labcheck'+i).checked = false;

			document.getElementById('lablatertonow'+i).disabled = false;

			var x = document.getElementById('labcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('rate5'+i).value ;

			}

			approvalfunction(x.id,y);

		}

	}	

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('radcheck'+i))

	{

		if(document.getElementById('radcheck'+i).disabled==false)

		{

			radcheck = document.getElementById('radcheck'+i).checked = false;

			document.getElementById('radlatertonow'+i).disabled = false;

			var x = document.getElementById('radcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('rate8'+i).value ;

			}

			approvalfunction(x.id,y);

		}	

	}

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('sercheck'+i))

	{

		if(document.getElementById('sercheck'+i).disabled==false)

		{

			sercheck = document.getElementById('sercheck'+i).checked = false;

			document.getElementById('serlatertonow'+i).disabled = false;

			var x = document.getElementById('sercheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}else{

			var y = document.getElementById('serviceamount'+i).value ;

			}

			approvalfunction(x.id,y);

		}

	}	

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('refcheck'+i))

	{

		if(document.getElementById('refcheck'+i).disabled==false)

		{

			rcheck = document.getElementById('refcheck'+i).checked = false;

			var x = document.getElementById('refcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}

			approvalfunction(x.id,y);

		}

	}	

	}

	for (i=1;i<20;i++){	

	if(document.getElementById('deprefcheck'+i))

	{

		if(document.getElementById('deprefcheck'+i).disabled==false)

		{

			rcheck = document.getElementById('deprefcheck'+i).checked = false;

			var x = document.getElementById('deprefcheck'+i);

			if(x.hasAttribute("onclick")){

			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);

			}

			approvalfunction(x.id,y);

		}

	}	

	}

	document.getElementById('approvecomment').style.display = "none";



}

	

}

function selectcash(checkname,sno)

{



var sno = sno;



if(checkname=='pharam')

{

	if(document.getElementById('pharamlatertonow'+sno).checked == true)

	{

		document.getElementById('pharamcheck'+sno).checked =false;

		

	}

	else

	{

		//alert(sno);

		document.getElementById('pharamcheck'+sno).disabled =false;

	}

}

if(checkname=='lab')

{



	if(document.getElementById('lablatertonow'+sno).checked == true)

	{
		document.getElementById('labcashinput'+sno).readOnly =false;
        document.getElementById('labcashinput'+sno).value =document.getElementById('pharmitemrate'+sno).value;
		document.getElementById('labcashfixed'+sno).value =document.getElementById('pharmitemrate'+sno).value;
		document.getElementById('labcheck'+sno).checked =false;
		document.getElementById('labcheck'+sno).disabled =true;
		document.getElementById('laboverride'+sno).checked =false;
		document.getElementById('labcashinput'+sno).readOnly =true;

	}

	else

	{
        
		
		document.getElementById('labcheck'+sno).disabled=false;
		document.getElementById('labcashinput'+sno).value =0;
		document.getElementById('labcashfixed'+sno).value =0;

	}

}

if(checkname=='rad')

{

	if(document.getElementById('radlatertonow'+sno).checked == true)

	{
		document.getElementById('radcashinput'+sno).readOnly =false;
        document.getElementById('radcashinput'+sno).value =document.getElementById('radrate'+sno).value;
		document.getElementById('radcashfixed'+sno).value =document.getElementById('radrate'+sno).value;

		document.getElementById('radcheck'+sno).checked =false;
		document.getElementById('radcheck'+sno).disabled =true;
		document.getElementById('radoverride'+sno).checked =false;
		//document.getElementById('sercheck'+sno).disabled =true;
		//document.getElementById('seroverride'+sno).checked =false;
		document.getElementById('radcashinput'+sno).readOnly =true;

	}

	else

	{

		document.getElementById('radcheck'+sno).disabled=false;
		document.getElementById('radcashinput'+sno).value =0;
		document.getElementById('radcashfixed'+sno).value =0;

	}

}

if(checkname=='ser')

{

	if(document.getElementById('serlatertonow'+sno).checked == true)

	{ 

        document.getElementById('sercashinput'+sno).readOnly =false;
        document.getElementById('sercashinput'+sno).value =document.getElementById('seritemrate'+sno).value;
		document.getElementById('sercashfixed'+sno).value =document.getElementById('seritemrate'+sno).value;
        document.getElementById('sercashinput'+sno).readOnly =true;
		document.getElementById('sercheck'+sno).checked =false;

	}

	else

	{

        document.getElementById('sercashinput'+sno).value =0;
		document.getElementById('sercashfixed'+sno).value =0;
		document.getElementById('sercheck'+sno).disabled=false;

	}

}

if(checkname=='laboverride')
{	
	if(document.getElementById('laboverride'+sno).checked == true)
	{
		document.getElementById('lablatertonow'+sno).checked =false;
		document.getElementById('labcheck'+sno).checked =false;
		document.getElementById('labcheck'+sno).disabled = true;
	}
	else
	{
		document.getElementById('labcheck'+sno).disabled=true;
		// document.getElementById('lablatertonow'+sno).checked=true;
	}
}

if(checkname=='radoverride')
{
	if(document.getElementById('radoverride'+sno).checked == true)
	{
		document.getElementById('radlatertonow'+sno).checked =false;
		document.getElementById('radcheck'+sno).checked =false;
		document.getElementById('radcheck'+sno).disabled = true;
	}
	else
	{
		document.getElementById('radcheck'+sno).disabled=false;
	}
}

if(checkname=='seroverride')
{
	if(document.getElementById('seroverride'+sno).checked == true)
	{
		document.getElementById('serlatertonow'+sno).checked =false;
		document.getElementById('sercheck'+sno).checked =false;
		document.getElementById('sercheck'+sno).disabled =true;
	}
	else
	{
		document.getElementById('sercheck'+sno).disabled=false;
	}
}

}

function selectselect(checkname,sno)

{

//alert(checkname);	

var sno = sno;

if(checkname=='pharam')

{

	if(document.getElementById('pharamcheck'+sno).checked == true)

	{

		//alert(sno);

		document.getElementById('pharamlatertonow'+sno).checked = false;

		

		if(parseFloat(document.getElementById("availablelimit").value.replace(/,/g,''))>parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))+parseFloat(document.getElementById('rate5'+sno).value))

		{

		document.getElementById('pharamlatertonow'+sno).disabled=true;

	}

		

	}

	else

	{

		document.getElementById('pharamlatertonow'+sno).disabled=false;

		document.getElementById('selectalll').checked = false;

		document.getElementById('approve').checked = false;

	}

}

if(checkname=='lab')

{

	if(document.getElementById('labcheck'+sno).checked == true)

	{

	

		document.getElementById('lablatertonow'+sno).checked = false;

		if(parseFloat(document.getElementById("availablelimit").value.replace(/,/g,''))>parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))+parseFloat(document.getElementById('rate5'+sno).value))

		{

		document.getElementById('lablatertonow'+sno).disabled=true;

		

			}

	}

	else

	{

		document.getElementById('lablatertonow'+sno).disabled=false;

		document.getElementById('selectalll').checked = false;

		document.getElementById('approve').checked = false;

	}

}

if(checkname=='rad')

{

	if(document.getElementById('radcheck'+sno).checked == true)

	{

		document.getElementById('radlatertonow'+sno).checked = false;

		if(parseFloat(document.getElementById("availablelimit").value.replace(/,/g,''))>parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))+parseFloat(document.getElementById('rate8'+sno).value))

		{

		document.getElementById('radlatertonow'+sno).disabled=true;

		}

	}

	else

	{

		document.getElementById('radlatertonow'+sno).disabled=false;

		document.getElementById('selectalll').checked = false;

		document.getElementById('approve').checked = false;

	}

}

if(checkname=='ser')

{ //alert('ok');

	if(document.getElementById('sercheck'+sno).checked == true)

	{

		document.getElementById('serlatertonow'+sno).checked = false;

		if(parseFloat(document.getElementById("availablelimit").value.replace(/,/g,''))>parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))+parseFloat(document.getElementById('serviceamount'+sno).value))

		{

		document.getElementById('serlatertonow'+sno).disabled=true;

		}

		//alert(document.getElementById("availablelimit").value);

		

	}

	else

	{

		document.getElementById('serlatertonow'+sno).disabled=false;

		document.getElementById('selectalll').checked = false;

		document.getElementById('approve').checked = false;

	}

	

}



}

function grandtotl(vrate)

{

//alert(vrate);

var varserRate=vrate;



if(document.getElementById('grandtotal').value=='')

	{

	grandtotal=0;

	}

	else

	{

	grandtotal=document.getElementById('grandtotal').value;

	}

	

	grandtotal=grandtotal.replace(/,/g,'');

	grandtotal=parseInt(grandtotal,10);



	grandtotal=parseInt(grandtotal) + parseInt(varserRate);

	document.getElementById("grandtotal").value=formatMoney(grandtotal.toFixed(2));

}

function grandtotalminus(vrate)

{



var varserRate=vrate;



	grandtotal=document.getElementById('grandtotal').value;

	grandtotal=grandtotal.replace(/,/g,'');

	grandtotal=parseInt(grandtotal,10);

	grandtotal=parseInt(grandtotal) - parseInt(varserRate);

	document.getElementById("grandtotal").value=formatMoney(grandtotal.toFixed(2));

}

function calculate()

{

var dispensingfee = document.getElementById("dispensingfee").value;

var grandtotal = document.getElementById("hidgrandtotal").value;

grandtotal=grandtotal.replace(/,/g,'');

var newgrandtotal = parseFloat(dispensingfee) + parseFloat(grandtotal);

if(dispensingfee != '')

{

document.getElementById("grandtotal").value = formatMoney(newgrandtotal.toFixed(2));

}

else

{

document.getElementById("grandtotal").value = formatMoney(grandtotal);

}

}



/*function alertfun()

{	

    var r;

	r=confirm("Please Ensure All The Checkbox Are Selected..!");

	if(r == false)

	{

		alert(r);

	return false;

	}

}*/

function alertfun() { 



	var labasno=document.getElementById("labsno").value;

	

	for(i=1;i<=labasno;i++)

	{



		var s=i;

		if( document.getElementById("labcheck"+s) !== null && document.getElementById("labcheck"+s).checked==false && document.getElementById("lablatertonow"+s).checked==false)

		{

			// alert("You have to select all");

			// 		return false;



		}

	}



	var radisno=document.getElementById("radsno").value;

	//alert(pharmsno); 

	//return false;

	for(i=1;i<=radisno;i++)

	{

		var s=i;

	if(document.getElementById("radcheck"+s) !== null && document.getElementById("radcheck"+s).checked==false && document.getElementById("radlatertonow"+s).checked==false)

	{

		// alert("You have to select all");

		// 		return false;



	}

	}



	var servicesno=document.getElementById("sersno").value; 

	//alert(pharmsno); 

	//return false;

	for(i=1;i<=servicesno;i++)

	{

		var s=i;

	if(document.getElementById("sercheck"+s) !== null && document.getElementById("sercheck"+s).checked==false && document.getElementById("serlatertonow"+s).checked==false)

	{

		// alert("You have to select all");

		// 		return false;



	}

	}



	   if(parseFloat(document.getElementById("availablelimit").value.replace(/,/g,''))<(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),'')) ))
		{
		  // alert("Approval Limit is exceeded Available Limit");

		   //return false;		
		}


	if(document.getElementById("approve").checked==true){

				if(document.getElementById("approvecomment").value == ''){

					alert("Please Enter the approval comment");

					

					document.getElementById("approvecomment").focus();

					return false;

				}

			}

			else

			{

            var result = confirm("Do you want to save this entry?");
			if (result) {
				$("input").removeAttr("disabled");
			    return true;
			} else {
				return false;
			}


			//	alert("Please check approval box for approving this transaction.");

			//	return false;

			}

	

}



function approvalfunction3(nam,amount)

{

	if(document.getElementById(nam).checked==true)

	{

	//alert(amount);

	 document.getElementById("grandtotal").value=formatMoney(parseFloat(document.getElementById("grandtotal").value.replace(RegExp(',', 'g'),''))+parseFloat(amount));

		

		//alert(document.getElementById("availablelimit").value);

		//alert(document.getElementById("approvallimit").value);

		if(document.getElementById("approve").checked==false){

		//alert(document.getElementById("approvallimit").value.replace(/,/g,''));

		if(parseFloat(document.getElementById("availablelimit").value.replace(/,/g,''))<(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),'')) + parseFloat(document.getElementById("grandtotal").value.replace(RegExp(',', 'g'),''))))

		{	

			alert("Approval Limit is greater than Available Limit");

			document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount));

			document.getElementById(nam).checked = false;

			if(document.getElementById("selectalll").checked == true){

				document.getElementById("selectalll").checked =false;

				}

			}

		}

		/*if(document.getElementById(nam).value==delete)

		{

		document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount);	

		}*/

		//alert(document.getElementById("availablelimit").value);

		//alert(document.getElementById("approvallimit").value);

		

		}

	else

	{

		//alert(amount);

		if(parseFloat(document.getElementById("grandtotal").value.replace(/,/g,''))-parseFloat(amount)>0)

		{

		document.getElementById("grandtotal").value=formatMoney(parseFloat(document.getElementById("grandtotal").value.replace(/,/g,''))-parseFloat(amount));

		}

		else

		{

		document.getElementById("grandtotal").value='0.00';

		}

		}

}

function approvalfunction2(nam,amount)

{

   /*if(document.getElementById(nam).checked==true)

	{

	   document.getElementById("grandtotal").value=formatMoney(parseFloat(document.getElementById("grandtotal").value.replace(RegExp(',', 'g'),''))-parseFloat(amount));

		

		

		

	}

	else

	{

		//alert(amount);

		if(parseFloat(document.getElementById("grandtotal").value.replace(/,/g,''))-parseFloat(amount)>0)

		{

		document.getElementById("grandtotal").value=formatMoney(parseFloat(document.getElementById("grandtotal").value.replace(/,/g,''))+parseFloat(amount));

		}

		else

		{

		document.getElementById("grandtotal").value='0.00';

		}

	} */

}



function approvalfunction(nam,amount)

{//alert(nam);

//alert(amount);

	if(document.getElementById(nam).checked==true)

	{

	//alert(amount);

	document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),''))+parseFloat(amount));

		

		//alert(document.getElementById("availablelimit").value);

		//alert(document.getElementById("approvallimit").value);

		if(document.getElementById("approve").checked==false){

		//alert(document.getElementById("approvallimit").value.replace(/,/g,''));

		if(parseFloat(document.getElementById("availablelimit").value.replace(/,/g,''))<(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),''))))

		{	

			alert("Approval Limit is greater than Available Limit");

			document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount));

			document.getElementById(nam).checked = false;

			if(document.getElementById("selectalll").checked == true){

				document.getElementById("selectalll").checked =false;

				}

			}

		}

		/*if(document.getElementById(nam).value==delete)

		{

		document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount);	

		}*/

		//alert(document.getElementById("availablelimit").value);

		//alert(document.getElementById("approvallimit").value);

		

		}

	else

	{

		//alert(amount);

		if(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount)>0)

		{

		document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount));

		}

		else

		{

		document.getElementById("approvallimit").value='0.00';

		}

		}

	//var rate=amount;

	//alert(rate);

	

}



function approvalfunction1(nam,amount)

{//alert(nam);

	if(document.getElementById(nam).checked==true)

	{

		//alert(amount);

		document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount));

		/*if(document.getElementById(nam).value==delete)

		{

		document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount);	

		}*/

		}

	

	

}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function myLabCalculateFunction(sno, evt){
	
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if ( (charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode == 8 ){
		var cashamount = document.getElementById('labcashinput'+sno).value;
		var labcopayamount = document.getElementById('labcashfixed'+sno).value;
		var balance = labcopayamount - cashamount;
		document.getElementById('labcopayamount'+sno).value = balance.toFixed(2);
	}
}

function myRadCalculateFunction(sno, evt){
	
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if ( (charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode == 8 ){
		var cashamount = document.getElementById('radcashinput'+sno).value;
		var radcopayamount = document.getElementById('radcashfixed'+sno).value;
		var balance = radcopayamount - cashamount;
		document.getElementById('radcopayamount'+sno).value = balance.toFixed(2);
	}
}

function mySerCalculateFunction(sno, evt){
	
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if ( (charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode == 8 ){
		var cashamount = document.getElementById('sercashinput'+sno).value;
		var sercopayamount = document.getElementById('sercashfixed'+sno).value;
		var balance = sercopayamount - cashamount;
		document.getElementById('sercopayamount'+sno).value = balance.toFixed(2);
	}
}

function myRadDiscountCalcultateFunc(sno, evt){
	
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if ( (charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode == 8 ){
		var discount = document.getElementById('raddiscountinput'+sno).value;
		var raditemrate = document.getElementById('radrate'+sno).value;
		var newamount = raditemrate - discount;
		if(newamount <= raditemrate && newamount >= 0) { 
			document.getElementById('radtotal'+sno).innerText = newamount.toFixed(2);
			document.getElementById('raditemrate'+sno).value = newamount.toFixed(2);
		} else {
			alert("Discount amount cannot be greater than rate");
			document.getElementById('raddiscountinput'+sno).value = Number(0).toFixed(2);
			document.getElementById('radtotal'+sno).innerText = raditemrate;
			document.getElementById('raditemrate'+sno).value = raditemrate;
		}

		if(discount != 0){
			document.getElementById('radoverride'+sno).disabled = true;
		}
	}
}


</script>



<?php $locationcode; ?>



<?php

// include ("js/dropdownlist1newscriptingmedicine1.php"); ?> 

<!-- <script type="text/javascript" src="js/autosuggestnewmedicine1.js"></script> <!-- For searching customer -->

<!-- <script type="text/javascript" src="js/autocomplete_newmedicineq.js"></script>

<script type="text/javascript" src="js/automedicinecodesearch2.js"></script>

<!--<script type="text/javascript" src="js/insertnewitemforallamendpharam1.js"></script>

-->

<script type="text/javascript" src="js/insertnewitemforallamendpharam1new.js"></script>



<?php  include ("autocompletebuild_lab1.php"); ?>

<?php include ("js/dropdownlist1scriptinglab1.php"); ?>

<script type="text/javascript" src="js/autocomplete_lab1.js"></script>

<script type="text/javascript" src="js/autosuggestlab1.js"></script> 

<script type="text/javascript" src="js/autolabcodesearch12_new.js"></script>

<script type="text/javascript" src="js/insertnewitemforallamendlab1.js"></script>







<?php include ("js/dropdownlist1scriptingradiology1.php"); ?>

<?php include("autocompletebuild_radiology1.php"); ?>

<script type="text/javascript" src="js/autocomplete_radiology1.js"></script>

<script type="text/javascript" src="js/autosuggestradiology1.js"></script> 

<script type="text/javascript" src="js/autoradiologycodesearch22.js"></script>

<script type="text/javascript" src="js/insertnewitemforallamendrad1.js"></script>





<?php include ("js/dropdownlist1scriptingservices1.php"); ?>

<?php include ("autocompletebuild_services1.php");?>

<script type="text/javascript" src="js/autocomplete_services1.js"></script>

<script type="text/javascript" src="js/autosuggestservices1.js"></script>

<script type="text/javascript" src="js/autoservicescodesearch22.js"></script>

<script type="text/javascript" src="js/insertnewitemforallamend1.js"></script>



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

.style2 {

	font-size: 18px;

	font-weight: bold;

}

.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }

.bal

{

border-style:none;

background:none;

text-align:right;

FONT-FAMILY: Tahoma;

FONT-SIZE: 11px;

}

</style>
<script type="text/javascript">
$( document ).ready(function() {

	if(document.getElementById('labsno').value > 0){
		var labdptlimit = document.getElementById('dptlimitcheck').value;
		var labdptlimitcheck = parseInt(labdptlimit,10);
		var labcopayamount;

		var labsno = document.getElementById("labsno").value;
		var labids = [];
		for(var i=1;i<=labsno;i++)
		{

			labids.push(i);
			var labitemrate = document.getElementById('pharmitemrate'+i).value;
			(function (i) {

		        /*document.getElementById('lablatertonow'+i).addEventListener('change', (event) => {
				  if(event.target.checked){
				  	document.getElementById('labcopayamount'+i).value = Number(0).toFixed(2);
				  	document.getElementById('labcashfixed'+i).value = Number(0).toFixed(2);
				  	document.getElementById('labcashinput'+i).value = Number(0).toFixed(2);
				  	document.getElementById('labcashinput'+i).readOnly = true;
				  	labids.push(i);
				  	labids.sort();
				  	mylabfunction(labids);
				  } else {
				  	var labitemrate1 = document.getElementById('pharmitemrate'+i).value;
				  	document.getElementById('labcopayamount'+i).value = labitemrate1;
				  	document.getElementById('labcashfixed'+i).value = labitemrate1;
				  	document.getElementById('labcashinput'+i).value = labitemrate1;
				  	document.getElementById('labcashinput'+i).readOnly = true;
				  	var index = labids.indexOf(i);
				  	if (index > -1) {
					  labids.splice(index, 1);
					}
				  	mylabfunction(labids);
				  }
				});*/


				document.getElementById('laboverride'+i).addEventListener('change', (event) => {
				  if(event.target.checked){
				  	var labitemrate1 = document.getElementById('pharmitemrate'+i).value;
				  	document.getElementById('labcopayamount'+i).value = labitemrate1;
				  	document.getElementById('labcashfixed'+i).value = labitemrate1;
				  	document.getElementById('labcashinput'+i).value = Number(0).toFixed(2);
				  	document.getElementById('labcashinput'+i).readOnly = false;
				  	var index = labids.indexOf(i);
				  	if (index > -1) {
					  labids.splice(index, 1);
					}
				  	mylabfunction(labids);
				  } else {
				  	document.getElementById('labcopayamount'+i).value = Number(0).toFixed(2);
				  	document.getElementById('labcashfixed'+i).value = Number(0).toFixed(2);
				  	document.getElementById('labcashinput'+i).value = Number(0).toFixed(2);
				  	document.getElementById('labcashinput'+i).readOnly = true;
				  	labids.push(i);
				  	labids.sort();
				  	mylabfunction(labids);
				  }
				});

				// document.getElementById('labcheck'+i).addEventListener('change', (event) => {
				//   if(event.target.checked){
				//   	var pharmitemrate1 = document.getElementById('pharmitemrate'+i).value;
				//   	document.getElementById('copayamount'+i).value = pharmitemrate1;
				//   	var index = labids.indexOf(i);
				//   	if (index > -1) {
				// 	  labids.splice(index, 1);
				// 	}
				//   	mylabfunction(labids);
				//   } else {
				//   	document.getElementById('copayamount'+i).value = 0;
				//   	labids.push(i);
				//   	labids.sort();
				//   	mylabfunction(labids);
				//   }
				// });

				if(document.getElementById('lablatertonow'+i).checked == true){
					document.getElementById('labcopayamount'+i).value = labitemrate;
					document.getElementById('labcashfixed'+i).value = labitemrate;
					document.getElementById('labcashinput'+i).value = labitemrate;
					document.getElementById('labcashinput'+i).readOnly = true;
					var index = labids.indexOf(i);
				  	if (index > -1) {
					  labids.splice(index, 1);
					}
				  	mylabfunction(labids);
				} else {
			        if(labdptlimitcheck >= labitemrate){
			        	var approvallimit = parseInt(document.getElementById('approvallimit').value);
			        	var approvallimit1 = approvallimit + parseInt(labitemrate);
			        	document.getElementById('approvallimit').value = approvallimit1.toFixed(2);

			  			copayamount = 0;
			  			labdptlimitcheck -= labitemrate;
			  			document.getElementById('labcopayamount'+i).value = copayamount.toFixed(2);
			  			document.getElementById('labcashfixed'+i).value = copayamount.toFixed(2);
			  			document.getElementById('labcashinput'+i).value = copayamount.toFixed(2);
			  			document.getElementById('labcashinput'+i).readOnly = true;
			  			document.getElementById('labcheck'+i).checked = true;
			  		} else if (labdptlimitcheck < labitemrate) {
			  			copayamount = Math.abs(labdptlimitcheck - labitemrate);
						var approvallimit = parseInt(document.getElementById('approvallimit').value);
			        	var approvallimit1 = approvallimit + parseInt(labdptlimitcheck);
			        	document.getElementById('approvallimit').value = approvallimit1.toFixed(2);
			  			labdptlimitcheck = 0;	
			  			document.getElementById('labcopayamount'+i).value = copayamount.toFixed(2);
			  			document.getElementById('labcashfixed'+i).value = copayamount.toFixed(2);
			  			document.getElementById('labcashinput'+i).value = copayamount.toFixed(2);
			  			document.getElementById('labcashinput'+i).readOnly = true;
			  			document.getElementById('lablatertonow'+i).checked = true;
			  			document.getElementById('labcheck'+i).disabled = true;
			  		}
			  	}
		    })(i);
		}

		function mylabfunction(labids){
			var labdptlimit = document.getElementById('dptlimitcheck').value;
			var labdptlimitcheck = parseInt(labdptlimit,10);
			var copayamount;
			var totalcopayamount = 0;

			/*labids.forEach(function(id) {
				var labitemrate = document.getElementById('pharmitemrate'+id).value;
                console.log(labitemrate);
				if(labdptlimitcheck >= labitemrate){
		 			copayamount = 0;
		 			labdptlimitcheck -= labitemrate;
		 			document.getElementById('labcopayamount'+id).value = copayamount.toFixed(2);
		 			document.getElementById('labcashfixed'+id).value = copayamount.toFixed(2);
		 			document.getElementById('labcashinput'+id).value = copayamount.toFixed(2);
		 			document.getElementById('lablatertonow'+id).checked = false;
		  			document.getElementById('labcheck'+id).disabled = false;
		  			document.getElementById('labcheck'+id).checked = true;
		  			totalcopayamount += copayamount;
		  		} else if (labdptlimitcheck < labitemrate) {
		 			copayamount = Math.abs(labdptlimitcheck - labitemrate);
		 			labdptlimitcheck = 0;	
		 			document.getElementById('labcopayamount'+id).value = copayamount.toFixed(2);
		 			document.getElementById('labcashfixed'+id).value = copayamount.toFixed(2);
		 			document.getElementById('labcashinput'+id).value = copayamount.toFixed(2);
		 			document.getElementById('lablatertonow'+id).checked = true;
		  			document.getElementById('labcheck'+id).disabled = true;
		  			document.getElementById('labcheck'+id).checked = false;
		  			totalcopayamount += copayamount;
		  		}
			}); */
			
		//	document.getElementById('totalcopayamount').value = totalcopayamount.toFixed(2);
		}
	}

	if(document.getElementById('radsno').value > 0){
		var raddptlimit = document.getElementById('raddptlimitcheck').value;
		var raddptlimitcheck = parseInt(raddptlimit,10);
		var radcopayamount;

		var radsno = document.getElementById("radsno").value;
		var radids = [];
		for(i=1;i<=radsno;i++)
		{
			radids.push(i);
			var raditemrate = document.getElementById('raditemrate'+i).value;

			(function (i) {
		       /* document.getElementById('radlatertonow'+i).addEventListener('change', (event) => {
				  if(event.target.checked){
				  	document.getElementById('radcopayamount'+i).value = Number(0).toFixed(2);
				  	document.getElementById('radcashfixed'+i).value = Number(0).toFixed(2);
				  	document.getElementById('radcashinput'+i).value = Number(0).toFixed(2);
				  	document.getElementById('radcashinput'+i).readOnly = true;
				  	radids.push(i);
				  	radids.sort();
				  	myradfunction(radids);
				  } else {
				  	var raditemrate1 = document.getElementById('raditemrate'+i).value;
				  	document.getElementById('radcopayamount'+i).value = raditemrate1;
				  	document.getElementById('radcashfixed'+i).value = raditemrate1;
				  	document.getElementById('radcashinput'+i).value = raditemrate1;
				  	document.getElementById('radcashinput'+i).readOnly = true;
				  	var index = radids.indexOf(i);
				  	if (index > -1) {
					  radids.splice(index, 1);
					}
				  	myradfunction(radids);
				  }
				});*/

				document.getElementById('radoverride'+i).addEventListener('change', (event) => {
				  if(event.target.checked){
				  	var raditemrate1 = document.getElementById('raditemrate'+i).value;
				  	document.getElementById('radcopayamount'+i).value = raditemrate1;
				  	document.getElementById('radcashfixed'+i).value = raditemrate1;
				  	document.getElementById('radcashinput'+i).value = Number(0).toFixed(2);
				  	document.getElementById('radcashinput'+i).readOnly = false;
				  	var index = radids.indexOf(i);
				  	if (index > -1) {
					  radids.splice(index, 1);
					}
				  	myradfunction(radids);
				  } else {
				  	document.getElementById('radcopayamount'+i).value = Number(0).toFixed(2);
				  	document.getElementById('radcashfixed'+i).value = Number(0).toFixed(2);
				  	document.getElementById('radcashinput'+i).value = Number(0).toFixed(2);
				  	document.getElementById('radcashinput'+i).readOnly = true;
				  	radids.push(i);
				  	radids.sort();
				  	myradfunction(radids);
				  }
				});

				// document.getElementById('labcheck'+i).addEventListener('change', (event) => {
				//   if(event.target.checked){
				//   	var pharmitemrate1 = document.getElementById('pharmitemrate'+i).value;
				//   	document.getElementById('copayamount'+i).value = pharmitemrate1;
				//   	var index = radids.indexOf(i);
				//   	if (index > -1) {
				// 	  radids.splice(index, 1);
				// 	}
				//   	myradfunction(radids);
				//   } else {
				//   	document.getElementById('copayamount'+i).value = 0;
				//   	radids.push(i);
				//   	radids.sort();
				//   	myradfunction(radids);
				//   }
				// });

				if(document.getElementById('radlatertonow'+i).checked == true){
					document.getElementById('radcopayamount'+i).value = raditemrate;
					document.getElementById('radcashfixed'+i).value = raditemrate;
					document.getElementById('radcashinput'+i).value = raditemrate;
					document.getElementById('radcashinput'+i).readOnly = true;
					var index = radids.indexOf(i);
				  	if (index > -1) {
					  radids.splice(index, 1);
					}
				  	myradfunction(radids);
				} else {
			        if(raddptlimitcheck >= raditemrate){
			        	var approvallimit = parseInt(document.getElementById('approvallimit').value);
			        	var approvallimit1 = approvallimit + parseInt(raditemrate);
			        	document.getElementById('approvallimit').value = approvallimit1.toFixed(2);

			  			copayamount = 0;
			  			raddptlimitcheck -= raditemrate;
			  			document.getElementById('radcopayamount'+i).value = copayamount.toFixed(2);
			  			document.getElementById('radcashfixed'+i).value = copayamount.toFixed(2);
			  			document.getElementById('radcashinput'+i).value = copayamount.toFixed(2);
			  			document.getElementById('radcashinput'+i).readOnly = true;
			  			document.getElementById('radcheck'+i).checked = true;
			  		} else if (raddptlimitcheck < raditemrate) {
			  			copayamount = Math.abs(raddptlimitcheck - raditemrate);
						var approvallimit = parseInt(document.getElementById('approvallimit').value);
			        	var approvallimit1 = approvallimit + parseInt(raddptlimitcheck);
			        	document.getElementById('approvallimit').value = approvallimit1.toFixed(2);
			  			raddptlimitcheck = 0;	
			  			document.getElementById('radcopayamount'+i).value = copayamount.toFixed(2);
			  			document.getElementById('radcashfixed'+i).value = copayamount.toFixed(2);
			  			document.getElementById('radcashinput'+i).value = copayamount.toFixed(2);
			  			document.getElementById('radcashinput'+i).readOnly = true;
			  			document.getElementById('radlatertonow'+i).checked = true;
			  			document.getElementById('radcheck'+i).disabled = true;
			  		}
			  	}
		    })(i);
		}
	}

	if(document.getElementById('sersno').value > 0){
		var serdptlimit = document.getElementById('serdptlimitcheck').value;
		var serdptlimitcheck = parseInt(serdptlimit,10);
		var sercopayamount;

		var sersno = document.getElementById("sersno").value;
		var serids = [];
		for(i=1;i<=sersno;i++)
		{
			serids.push(i);
			var seritemrate = document.getElementById('seritemrate'+i).value;

			(function (i) {
		       /* document.getElementById('serlatertonow'+i).addEventListener('change', (event) => {
				  if(event.target.checked){
				  	document.getElementById('sercopayamount'+i).value = Number(0).toFixed(2);
				  	document.getElementById('sercashfixed'+i).value = Number(0).toFixed(2);
				  	document.getElementById('sercashinput'+i).value = Number(0).toFixed(2);
				  	document.getElementById('sercashinput'+i).readOnly = true;
				  	serids.push(i);
				  	serids.sort();
				  	myserfunction(serids);
				  } else {
				  	var seritemrate1 = document.getElementById('seritemrate'+i).value;
				  	document.getElementById('sercopayamount'+i).value = seritemrate1;
				  	document.getElementById('sercashfixed'+i).value = seritemrate1;
				  	document.getElementById('sercashinput'+i).value = seritemrate1;
				  	document.getElementById('sercashinput'+i).readOnly = true;
				  	var index = serids.indexOf(i);
				  	if (index > -1) {
					  serids.splice(index, 1);
					}
				  	myradfunction(serids);
				  }
				});*/

				document.getElementById('seroverride'+i).addEventListener('change', (event) => {
				  if(event.target.checked){
				  	var seritemrate1 = document.getElementById('seritemrate'+i).value;
				  	document.getElementById('sercopayamount'+i).value = seritemrate1;
				  	document.getElementById('sercashfixed'+i).value = seritemrate1;
				  	document.getElementById('sercashinput'+i).value = Number(0).toFixed(2);
				  	document.getElementById('sercashinput'+i).readOnly = false;
				  	var index = serids.indexOf(i);
				  	if (index > -1) {
					  serids.splice(index, 1);
					}
				  	myserfunction(serids);
				  } else {
				  	document.getElementById('sercopayamount'+i).value = Number(0).toFixed(2);
				  	document.getElementById('sercashfixed'+i).value = Number(0).toFixed(2);
				  	document.getElementById('sercashinput'+i).value = Number(0).toFixed(2);
				  	document.getElementById('sercashinput'+i).readOnly = true;
				  	serids.push(i);
				  	serids.sort();
				  	myserfunction(serids);
				  }
				});

				// document.getElementById('labcheck'+i).addEventListener('change', (event) => {
				//   if(event.target.checked){
				//   	var pharmitemrate1 = document.getElementById('pharmitemrate'+i).value;
				//   	document.getElementById('copayamount'+i).value = pharmitemrate1;
				//   	var index = serids.indexOf(i);
				//   	if (index > -1) {
				// 	  serids.splice(index, 1);
				// 	}
				//   	myradfunction(serids);
				//   } else {
				//   	document.getElementById('copayamount'+i).value = 0;
				//   	serids.push(i);
				//   	serids.sort();
				//   	myradfunction(serids);
				//   }
				// });

				if(document.getElementById('serlatertonow'+i).checked == true){
					document.getElementById('sercopayamount'+i).value = seritemrate;
					document.getElementById('sercashfixed'+i).value = seritemrate;
					document.getElementById('sercashinput'+i).value = seritemrate;
					document.getElementById('sercashinput'+i).readOnly = true;
					var index = serids.indexOf(i);
				  	if (index > -1) {
					  serids.splice(index, 1);
					}
				  	myserfunction(serids);
				} else {
			        if(serdptlimitcheck >= seritemrate){
			        	var approvallimit = parseInt(document.getElementById('approvallimit').value);
			        	var approvallimit1 = approvallimit + parseInt(seritemrate);
			        	document.getElementById('approvallimit').value = approvallimit1.toFixed(2);

			  			copayamount = 0;
			  			serdptlimitcheck -= seritemrate;
			  			document.getElementById('sercopayamount'+i).value = copayamount.toFixed(2);
			  			document.getElementById('sercashfixed'+i).value = copayamount.toFixed(2);
			  			document.getElementById('sercashinput'+i).value = copayamount.toFixed(2);
			  			document.getElementById('sercashinput'+i).readOnly = true;
			  			document.getElementById('sercheck'+i).checked = true;
			  		} else if (serdptlimitcheck < seritemrate) {
			  			copayamount = Math.abs(serdptlimitcheck - seritemrate);
						var approvallimit = parseInt(document.getElementById('approvallimit').value);
			        	var approvallimit1 = approvallimit + parseInt(serdptlimitcheck);

			        	document.getElementById('approvallimit').value = approvallimit1.toFixed(2);

			  			serdptlimitcheck = 0;	
			  			document.getElementById('sercopayamount'+i).value = copayamount.toFixed(2);
			  			document.getElementById('sercashfixed'+i).value = copayamount.toFixed(2);
			  			document.getElementById('sercashinput'+i).value = copayamount.toFixed(2);
			  			document.getElementById('sercashinput'+i).readOnly = true;
			  			document.getElementById('serlatertonow'+i).checked = true;
			  			document.getElementById('sercheck'+i).disabled = true;
			  		}
			  	}
		    })(i);
		}

		function myserfunction(serids){
			var serdptlimit = document.getElementById('serdptlimitcheck').value;
			var serdptlimitcheck = parseInt(serdptlimit,10);
			var copayamount;
			var totalcopayamount = 0;

			/*serids.forEach(function(id) {
				var seritemrate = document.getElementById('seritemrate'+id).value;

				if(serdptlimitcheck >= seritemrate){
		  			copayamount = 0;
		  			serdptlimitcheck -= seritemrate;
		  			document.getElementById('sercopayamount'+id).value = copayamount.toFixed(2);
		  			document.getElementById('sercashfixed'+id).value = copayamount.toFixed(2);
		 			document.getElementById('sercashinput'+id).value = copayamount.toFixed(2);
		  			document.getElementById('serlatertonow'+id).checked = false;
		  			document.getElementById('sercheck'+id).disabled = false;
		  			document.getElementById('sercheck'+id).checked = true;
		  			totalcopayamount += copayamount;
		  		} else if (serdptlimitcheck < seritemrate) {
		  			copayamount = Math.abs(serdptlimitcheck - seritemrate);
		  			serdptlimitcheck = 0;	
		  			document.getElementById('sercopayamount'+id).value = copayamount.toFixed(2);
		  			document.getElementById('sercashfixed'+id).value = copayamount.toFixed(2);
		 			document.getElementById('sercashinput'+id).value = copayamount.toFixed(2);
		  			document.getElementById('serlatertonow'+id).checked = true;
		  			document.getElementById('sercheck'+id).disabled = true;
		  			document.getElementById('sercheck'+id).checked = false;
		  			totalcopayamount += copayamount;
		  		}
			});*/
			document.getElementById('totalcopayamount').value = totalcopayamount.toFixed(2);
		}
	}
});

function checkfunction(sno, event){
	var radsno = document.getElementById("radsno").value;
	var radids = [];
	for(i=1;i<=radsno;i++)
	{
		radids.push(i);
		myradfunction(radids);
	}
}

function myradfunction(radids){
	var raddptlimit = document.getElementById('raddptlimitcheck').value;
	var raddptlimitcheck = parseInt(raddptlimit,10);
	var copayamount;
	var totalcopayamount = 0;

	/*radids.forEach(function(id) {
		var raditemrate = document.getElementById('raditemrate'+id).value;

		if(raddptlimitcheck >= raditemrate){
 			copayamount = 0;
 			raddptlimitcheck -= raditemrate;
 			document.getElementById('radcopayamount'+id).value = copayamount.toFixed(2);
 			document.getElementById('radcashfixed'+id).value = copayamount.toFixed(2);
 			document.getElementById('radcashinput'+id).value = copayamount.toFixed(2);
 			document.getElementById('radlatertonow'+id).checked = false;
  			document.getElementById('radcheck'+id).disabled = false;
  			document.getElementById('radcheck'+id).checked = true;
  			totalcopayamount += copayamount;
  		} else if (raddptlimitcheck < raditemrate) {
 			copayamount = Math.abs(raddptlimitcheck - raditemrate);
 			raddptlimitcheck = 0;	
 			document.getElementById('radcopayamount'+id).value = copayamount.toFixed(2);
 			document.getElementById('radcashfixed'+id).value = copayamount.toFixed(2);
 			document.getElementById('radcashinput'+id).value = copayamount.toFixed(2);
 			document.getElementById('radlatertonow'+id).checked = true;
  			document.getElementById('radcheck'+id).disabled = true;
  			document.getElementById('radcheck'+id).checked = false;
  			totalcopayamount += copayamount;
  		}
	}); */
	// document.getElementById('totalcopayamount').value = totalcopayamount.toFixed(2);
}
</script>


<script src="js/datetimepicker_css.js"></script>



</head>

 <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  

<body onLoad="return funcOnLoadBodyFunctionCall();">

<form name="form1" id="frmsales" method="post" action="opamend_seek.php">

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

    <td width="99%" valign="top"><table width="1031" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

            <tbody>

              

			 

		

			  <tr>

			    <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient</strong></td>

                <td width="36%" align="left" valign="middle" class="bodytext3">

				<input name="customername" id="customer" type="hidden" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>

                  </td>

                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>

                <td colspan="3" align="left" valign="middle" class="bodytext3">

				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>

				<input type="hidden" value="<?php echo $planforall;?>" name="planforall" >

				

				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>

             

			    </tr>

			   <tr>

			    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>

			    <td align="left" valign="middle" class="bodytext3">

				<input name="patientage" type="hidden" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientage; ?>

				&

				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>

				<input type="hidden" name="address1" id="address1" value="<?php echo $res41address1; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="30" />

                <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>" >

                <input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>" >

				<input type="hidden" name="subtypeano" id="subtypeano" value="<?php echo $res111subtype;?>">

			      <span class="style4"><!--Area--> </span>

			      <input type="hidden" name="area" id="area" value="<?php echo $res41area; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="10" />

				  <input type="hidden" name="subtype" id="subtype" value="<?php echo $res131subtype; ?>">

				  </td>

				    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" style="color:red;" class="bodytext3"><strong>Company</strong></td>

                <td colspan="3" align="left" valign="middle" class="bodytext3" style="color:red;">

				<input name="account" id="account" type="hidden" value="<?php echo $patientaccount; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>

				<strong><?php echo $patientaccount; ?></strong>

				<input type="hidden" name="billtype" value="<?php echo $billtype; ?>">		

				<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>">	

				

				<input type="hidden" name="paymenttype" id="payment" value="<?php echo $res121paymenttype; ?>" readonly   size="20" />			  		  </tr>

				  <tr>

				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>

                <td colspan="1" align="left" valign="top" class="bodytext3" >

				<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>

				<td colspan="1" align="left" valign="top" class="bodytext3" ><strong>Doc Number</strong></td>

				<td colspan="1" align="left" valign="top" class="bodytext3" ><?php echo $billnumbercode; ?></td>

				  </tr>

				  <tr>

				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5"  style="color:red;" class="bodytext3"><strong>Insurance</strong></td>

                <td colspan="1" align="left" valign="top" class="bodytext3"  style="color:red;"><strong><?php echo $res131subtype; ?></strong></td>

				<td colspan="1" align="left" valign="top" class="bodytext3" ><strong></strong></td>

				<td colspan="1" align="left" valign="top" class="bodytext3" ></td>

				  </tr>

            

           <?php 

            $selecttotal=0;

			

             $availablelimit1=0;

				   $consultationfees=0;

				   $planfixedamount=0;

				   $visitlimit1=0;

				   $overalllimit1=0;

				  $query223="select * from master_visitentry where patientcode = '$patientcode' and visitcode='$visitcode'";

					$exec223=mysqli_query($GLOBALS["___mysqli_ston"], $query223) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

					$res223=mysqli_fetch_array($exec223);

					 mysqli_num_rows($exec223);

					 

				   $availablelimit1=$res223['availablelimit'];

				   $overalllimit1=$res223['overalllimit'];

					$planper=$res223['planpercentage'];

				   $planname=$res223['planname'];

				   $consultationfees=$res223['consultationfees'];

				   

				   //$availableilimit = 

				   $query222 = "select * from master_planname where auto_number = '$planname'";

				   $exec222=mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

					$res222=mysqli_fetch_array($exec222);

					$planfixedamount=$res222['planfixedamount'];

					$visitlimit1=$res222['opvisitlimit'];

				// echo $availablelimit1;

				

				//   to find the available limit by deducting the prev billed amount 

				if($billtype!="PAY NOW")

				   {

				   $viscode = $_REQUEST["visitcode"];

					 

					    $billedrate=0;

				    $querybilrad="select sum(radiologyitemrate) as radiologyrate,sum(cash_copay) as cash_copay from consultation_radiology where patientcode = '$patientcode' and patientvisitcode='$viscode' and paymentstatus = 'completed' and  approvalstatus <> '1'  and radiologyrefund <> 'refund'";

					$execbilrad=mysqli_query($GLOBALS["___mysqli_ston"], $querybilrad) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

					$resbilrad=mysqli_fetch_array($execbilrad);

					$radrate=$resbilrad['radiologyrate']-$resbilrad['cash_copay'];

					$billedrate = $billedrate+$radrate;

				

				 

				    $querybilref="select sum(referalrate) as referalrate from consultation_referal where patientcode = '$patientcode' and patientvisitcode='$viscode' and paymentstatus = 'completed' and referalrefund <> 'refund'";

					$execbilref=mysqli_query($GLOBALS["___mysqli_ston"], $querybilref) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

					$resbilref=mysqli_fetch_array($execbilref);

					$refrate=$resbilref['referalrate'];

					$billedrate = $billedrate+$refrate;

				

				  $querybilref1="select sum(referalrate) as referalrate from consultation_departmentreferal where patientcode = '$patientcode' and patientvisitcode='$viscode' and paymentstatus = 'completed' and referalrefund <> 'refund'";

					$execbilref1=mysqli_query($GLOBALS["___mysqli_ston"], $querybilref1) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

					$resbilref1=mysqli_fetch_array($execbilref1);

					$refrate1=$resbilref1['referalrate'];

					$billedrate = $billedrate+$refrate1;

				

				$serrate=0;

				  $querybilser="select servicesitemrate*(serviceqty-refundquantity) as servicerate,cash_copay from consultation_services where patientcode = '$patientcode' and patientvisitcode='$viscode' and paymentstatus = 'completed' and  approvalstatus <> '1' ";

					$execbilser=mysqli_query($GLOBALS["___mysqli_ston"], $querybilser) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

					while($resbilser=mysqli_fetch_array($execbilser))

					{

					$serrate1=$resbilser['servicerate']-$resbilser['cash_copay'];

					$serrate=$serrate+$serrate1;

					}

					$billedrate = $billedrate+$serrate;

				

				  $querybillab="select sum(labitemrate) as labrate,sum(cash_copay) as cash_copay from consultation_lab where patientcode = '$patientcode' and patientvisitcode='$viscode' and paymentstatus = 'completed'  and labrefund <> 'refund' and  approvalstatus <> '1'";

					$execbillab=mysqli_query($GLOBALS["___mysqli_ston"], $querybillab) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

					$resbillab=mysqli_fetch_array($execbillab);

					$labrate=$resbillab['labrate']-$resbillab['cash_copay'];

					$billedrate = $billedrate+$labrate;

				

					}

					$pharmrefund=0;

					 $querybilpharm="select amount as pharmrate,medicinecode from master_consultationpharm  where patientcode = '$patientcode' and  patientvisitcode='$viscode' and  paymentstatus = 'completed' and  approvalstatus <> '2' ";

					$execbilpharm=mysqli_query($GLOBALS["___mysqli_ston"], $querybilpharm) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

					while ($resbilpharm=mysqli_fetch_array($execbilpharm))

					{

					$pharmrate=$resbilpharm['pharmrate'];

					$medicinecode=$resbilpharm['medicinecode'];

					 $querybilpharm1="select totalamount as refundpharm from pharmacysalesreturn_details  where patientcode = '$patientcode' and  visitcode='$viscode' and itemcode ='".$medicinecode."' ";

					 $execbilpharm1=mysqli_query($GLOBALS["___mysqli_ston"], $querybilpharm1) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

					while ($resbilpharm1=mysqli_fetch_array($execbilpharm1))

					{

						$pharmrate1=$resbilpharm1['refundpharm'];

						$pharmrefund=$pharmrefund+$pharmrate1;

						}

						$pharmcalcrate=$pharmcalcrate+($pharmrate-$pharmrefund);

					}

					//$pharmrate1=$resbilpharm['refundpharm'];

					//echo ">",$pharmrate,"<";

					//echo 'pharm',$pharmrate,',',$pharmrate1;

					/*$querybilpharm1="select sum(totalamount) as pharmrate1 from pharmacysalesreturn_details where patientcode = '$patientcode' and patientvisitcode='$viscode' and paymentstatus = 'completed' and approvalstatus <> '2' and radiologyrefund <> 'refund'";

					$execbilpharm1=mysql_query($querybilpharm1) or die(mysql_error().__LINE__);

					$resbilpharm1=mysql_fetch_array($execbilpharm1);

					$pharmrate1=$resbilpharm1['pharmrate1'];*/

					

				//	$pharmratevalue= $pharmrate-$pharmrate1;

				 	$billedrate = $billedrate+$pharmcalcrate;

					$availablelimit;

				 /*if($billedrate >= $availablelimit)

				 { $availablelimitshow=0;}

				 else

				 {*/

				 

				 

					 /*}*/

				

				

				

				//$billedrate;

				  $availablelimit=$availablelimit1+$planfixedamount-($consultationfees-($consultationfees*$planper/100));

				   $availablelimit=$availablelimit-$billedrate;

            ?>

      

	  

	  <tr>

	  <td  colspan="1" class="bodytext3"><input type="checkbox" value="selectall" name="selectalll" id="selectalll" onClick="selectall();" hidden> </td>

    

	    <td class="bodytext3"><strong>Available limit:</strong>

        

        <input size="8" type="text" name="availablelimit" id="availablelimit"  value="<?php echo number_format($availablelimit, 2, '.', ','); ?>" readonly ><span class="bodytext3" ><strong>&nbsp;&nbsp;Approved Amount :</strong></span></td>

        

		 	  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" id="grandtotal" value="<?php echo number_format($grandtotal,2,'.',','); ?>" readonly size="7"></td>

		   <input type="hidden" name="hidgrandtotal" id="hidgrandtotal" value="<?php echo number_format($grandtotal,2,'.',','); ?>">

        <td class="bodytext3"><strong>Approval limit:</strong></td>

        <td class="bodytext3">

        <input size="8" type="text" name="approvallimit" id="approvallimit"  value="<?php echo number_format($approvallimit, 2, '.', ','); ?>" readonly  ></td>

     	

	  </tr>

      </tbody>

        </table></td>

	

	  <?php

	  if($billtype == 'PAY NOW')

			{

				$status='pending';

			}

			else

			{

				$status='pending';

			}

		$query171nums = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicineissue='pending' and paymentstatus!='completed' and approvalstatus<>'2'";

		$exec171nums = mysqli_query($GLOBALS["___mysqli_ston"], $query171nums) or die ("Error in Query171nums".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$nums171 = mysqli_num_rows($exec171nums);

		$query172nums = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicineissue='pending' and pharmacybill='pending' and approvalstatus='2'";

		$exec172nums = mysqli_query($GLOBALS["___mysqli_ston"], $query172nums) or die ("Error in Query172nums".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$nums172=mysqli_num_rows($exec172nums);

		$query173nums = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicineissue='pending' and paymentstatus='completed' and approvalstatus='1'";

		$exec173nums = mysqli_query($GLOBALS["___mysqli_ston"], $query173nums) or die ("Error in Query173nums".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$nums173 = mysqli_num_rows($exec173nums);

		$nums17pharam = $nums171 + $nums172 + $nums173;

	  ?>

	 

<!--	  <tr>

	  <td width="90%" bgcolor="#ecf0f5" class="bodytext3"><strong>Prescription </strong></td>

	  </tr>

	  -->

       <?php

	  //if($nums17pharam>0)

	  if(0)

	  {

	  ?>

      <tr>

        <td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 

            align="left" border="0">

          <tbody id="foo">

            <tr>

			<?php if($billtype == 'PAY LATER')

				{

				?>

			<td width="6%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>

				<?php } ?>

              <td width="6%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

				

				<td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Medicine Name</strong></div></td>

				<td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Dose</strong></div></td>

				<td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Dose Measure</strong></div></td>

			

			<td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Freq</strong></div></td>

			

			<td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days </strong></div></td>

				<td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Quantity </strong></div></td>

			<td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Route </strong></div></td>

				<td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Instructions </strong></div></td>



				<td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>

					<td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>

				<td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?>

				<td width="18%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>

				<?php } ?>

                  </tr>

				  

			<?php

			

			$grandtotal='';

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			

			if($billtype == 'PAY NOW')

			{

				$status='pending';

			}

			else

			{

				$status='pending';

			}

	

			$query17 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicineissue='pending' and  ((billing <> 'completed' and approvalstatus <> '1') OR (approvalstatus <> '2'))";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			$nums=mysqli_num_rows($exec17);

			while ($res17 = mysqli_fetch_array($exec17))

			{

			

				$paharmitemname=$res17['medicinename'];

				$pharmitemcode=$res17['medicinecode'];

				$pharmdose=$res17['dose'];

				$pharmfrequency=$res17['frequencynumber'];

				$pharmdays=$res17['days'];

				$pharmquantity=$res17['quantity'];

				$pharmitemrate=$res17['rate'];

				$pharmamount=$res17['amount'];

				$route = $res17['route'];

				$dosemeasure=$res17['dosemeasure'];

				$instructions = $res17['instructions'];

				$medanum = $res17['auto_number'];

				$excludestatus=$res17['excludestatus'];

				$excludebill = $res17['excludebill'];

				$approvalstatus=$res17['approvalstatus'];

				$pharmacybill = $res17['pharmacybill'];

				$query77="select * from master_medicine where itemcode='$pharmitemcode'";

				$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);

				$res77=mysqli_fetch_array($exec77);

				$formula = $res77['formula'];

				$strength = $res77['roq'];

			

		if((($excludestatus == '')&&($excludebill == ''))||(($excludestatus == 'excluded')&&($excludebill == '')))

			{

			$grandtotal = $grandtotal + $pharmamount;

			$colorloopcount = $colorloopcount + 1;

			$sno = $sno + 1;

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

			if($excludestatus == 'excluded'){$colorcode = 'bgcolor="#FF99FF"';}

			$totalamount=$totalamount+$pharmitemrate;

			$totalamount=number_format($totalamount,2);

			?>

			  <tr <?php echo $colorcode; ?>>

			  <?php if($billtype == 'PAY LATER')

				{

				?>

			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="pharamcheck<?php echo $sno; ?>" name="pharamcheck[<?php echo $sno; ?>]" value="<?php echo $medanum; ?>" <?php if($approvalstatus=='1'){ echo "checked=checked";}?> onClick=" approvalfunction(this.id,<?php echo $pharmamount; ?>),selectselect('pharam','<?php echo $sno; ?>')"/>

			  <input type="hidden" name="pharamanum[<?php echo $sno; ?>]" id="pharamanum<?php echo $sno; ?>"  value="<?php echo $medanum; ?>">

			  </div></td>

			  <?php } ?>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>

			    <input type="hidden" name="aitemcode[]" id="aitemcode<?php echo $sno; ?>" value="<?php echo $pharmitemcode; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left"><div align="center">

                <input type="text" name="adose[]" id="adose<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdose; ?>" size="8" style="text-align:center;"></div>

                </td>

                

                

                

					   <td><select name="adosemeasure[]" id="dosemeasure<?php echo $sno; ?>">

                       <?php

					   				if ($dosemeasure == '')

				{

					echo '<option value="" selected="selected">Select Measure</option>';

				}

				else

				{

					?>   <option value="<?php echo $dosemeasure?>"><?php echo $dosemeasure?></option>

                    <?php

				}



					   ?>

					   <option value="mcg">mcg</option>

					   <option value="mg">mg</option>

					   <option value="g">g</option>

					   <option value="ml">ml</option>

					   <option value="l">l</option>

					   <option value="I.U">I.U</option>

					   <option value="meq">meq</option>

					   <option value="mmol">mmol</option>

					   </select></td>

                

                

				 <td class="bodytext31" valign="center"  align="left"><div align="center">

				 <input type="hidden" name="aformula" id="aformula<?php echo $sno; ?>" value="<?php echo $formula; ?>">

				 <input type="hidden" name="astrength" id="astrength<?php echo $sno; ?>" value="<?php echo $strength; ?>">

				 <input type="hidden" name="genericname" id="genericname">	

				  <input type="hidden" name="drugallergy" id="drugallergy">

				  <input type="hidden" name="exclude" id="exclude">	

				 <select name="afrequency[]" id="afrequency<?php echo $sno; ?>" onChange="return Functionfrequency('<?php echo $sno; ?>')">

				  <?php

				if ($pharmfrequency == '')

				{

					echo '<option value="select" selected="selected">Select frequency</option>';

				}

				else

				{

					$query51 = "select * from master_frequency where frequencynumber='$pharmfrequency' and recordstatus = ''";

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

				</select>

				 </div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="adays[]" id="adays<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdays; ?>" size="8" style="text-align:center;"></div></td>

				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aquantity[]" id="aquantity<?php echo $sno; ?>" value="<?php echo $pharmquantity; ?>" size="8" class="bal" readonly></div></td>

				<td class="bodytext31" valign="center"  align="left">

			<select name="aroute[]" id="aroute">

			  <?php

				if ($route == '')

				{

					echo '<option value="select" selected="selected">Select Route</option>';

				}

				else

				{

				

				echo '<option value="'.$route.'" selected="selected">'.$route.'</option>';

				}

				?>

					  

					   <option value="Oral">Oral</option>

					   <option value="Sublingual">Sublingual</option>

					   <option value="Rectal">Rectal</option>

					   <option value="Vaginal">Vaginal</option>

					   <option value="Topical">Topical</option>

					   <option value="Intravenous">Intravenous</option>

					   <option value="Intramuscular">Intramuscular</option>

					   <option value="Subcutaneous">Subcutaneous</option>



					   </select>	

				</td>

				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="ainstructions[]" id="ainstructions<?php echo $sno; ?>" value="<?php echo $instructions; ?>" size="15"></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="arate[]" id="arate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>" size="8" class="bal" readonly></div></td>

				

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aamount[]" id="aamount<?php echo $sno; ?>" value="<?php echo $pharmamount; ?>" size="8" class="bal" readonly></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center">

				<!-- <a onClick="return deletevalid()" href="opamend_seek.php?delete=<?php echo $medanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=pharm">Delete</a>-->

				 </div></td>

				 <?php if($billtype == 'PAY LATER')

				{

				?>

				<td class="bodytext31" valign="center"  align="left"><div align="center">

				<input type="checkbox" name="pharamlatertonow[<?php echo $sno; ?>]" id="pharamlatertonow<?php echo $sno; ?>" value="<?php echo $medanum; ?>" onClick="selectcash('pharam','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "disabled=disabled";} if($approvalstatus=='2'){ echo "checked=checked";}?>>

				</div></td>

				<?php } ?>

				</tr>

			<?php 

			} 

			}?>

            				  	



			<!--<?php 

			$query17 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicineissue='pending' and pharmacybill='pending' and approvalstatus='2'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			$nums=mysqli_num_rows($exec17);

			while ($res17 = mysqli_fetch_array($exec17))

			{

			

				$paharmitemname=$res17['medicinename'];

				$pharmitemcode=$res17['medicinecode'];

				$pharmdose=$res17['dose'];

				$pharmfrequency=$res17['frequencynumber'];

				$pharmdays=$res17['days'];

				$pharmquantity=$res17['quantity'];

				$pharmitemrate=$res17['rate'];

				$pharmamount=$res17['amount'];

				$route = $res17['route'];

				$instructions = $res17['instructions'];

				$medanum = $res17['auto_number'];

				$excludestatus=$res17['excludestatus'];

				$excludebill = $res17['excludebill'];

				$approvalstatus=$res17['approvalstatus'];

				$pharmacybill = $res17['pharmacybill'];

				$query77="select * from master_medicine where itemcode='$pharmitemcode'";

				$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);

				$res77=mysqli_fetch_array($exec77);

				$formula = $res77['formula'];

				$strength = $res77['roq'];

			

		if((($excludestatus == '')&&($excludebill == ''))||(($excludestatus == 'excluded')&&($excludebill == '')))

			{

			$grandtotal = $grandtotal + $pharmitemrate;

			$colorloopcount = $colorloopcount + 1;

			$sno=$sno+1;

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

			if($excludestatus == 'excluded'){$colorcode = 'bgcolor="#FF99FF"';}

			$totalamount=$totalamount+$pharmamount;

			$totalamount=number_format($totalamount,2);

			?>

			  <tr <?php echo $colorcode; ?>>

			  <?php if($billtype == 'PAY LATER')

				{

				?>

			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="pharamcheck<?php echo $sno; ?>" name="pharamcheck[<?php echo $sno; ?>]" value="<?php echo $medanum; ?>" <?php if($approvalstatus=='2'){ echo "disabled=disabled";}?> onClick="selectselect('pharam','<?php echo $sno; ?>')"/>

			  <input type="hidden" name="pharamanum[<?php echo $sno; ?>]" id="pharamanum<?php echo $sno; ?>"  value="<?php echo $medanum; ?>">

			  </div></td>

			  <?php } ?>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>

			    <input type="hidden" name="aitemcode[]" id="aitemcode<?php echo $sno; ?>" value="<?php echo $pharmitemcode; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="adose[]" id="adose<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdose; ?>" size="8" style="text-align:center;"></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center">

				 <input type="hidden" name="aformula" id="aformula<?php echo $sno; ?>" value="<?php echo $formula; ?>">

				 <input type="hidden" name="astrength" id="astrength<?php echo $sno; ?>" value="<?php echo $strength; ?>">



				  

				 <select name="afrequency[]" id="afrequency<?php echo $sno; ?>" onChange="return Functionfrequency('<?php echo $sno; ?>')">

				  <?php

				if ($pharmfrequency == '')

				{

					echo '<option value="select" selected="selected">Select frequency</option>';

				}

				else

				{

					$query51 = "select * from master_frequency where frequencynumber='$pharmfrequency' and recordstatus = ''";

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

				</select>

				 </div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="adays[]" id="adays<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdays; ?>" size="8" style="text-align:center;"></div></td>

				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aquantity[]" id="aquantity<?php echo $sno; ?>" value="<?php echo $pharmquantity; ?>" size="8" class="bal" readonly></div></td>

				<td class="bodytext31" valign="center"  align="left">

			<select name="aroute[]" id="aroute">

			  <?php

				if ($route == '')

				{

					echo '<option value="select" selected="selected">Select Route</option>';

				}

				else

				{

				

				echo '<option value="'.$route.'" selected="selected">'.$route.'</option>';

				}

				?>

					  

					   <option value="Oral">Oral</option>

					   <option value="Sublingual">Sublingual</option>

					   <option value="Rectal">Rectal</option>

					   <option value="Vaginal">Vaginal</option>

					   <option value="Topical">Topical</option>

					   <option value="Intravenous">Intravenous</option>

					   <option value="Intramuscular">Intramuscular</option>

					   <option value="Subcutaneous">Subcutaneous</option>

					   </select>	

				</td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="ainstructions[]" id="ainstructions<?php echo $sno; ?>" value="<?php echo $instructions; ?>" size="15"></div></td>



				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="arate[]" id="arate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>" size="8" class="bal" readonly></div></td>

				

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aamount[]" id="aamount<?php echo $sno; ?>" value="<?php echo $pharmamount; ?>" size="8" class="bal" readonly></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center">

				 <a onClick="return deletevalid()" href="opamend_seek.php?delete=<?php echo $medanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=pharm">Delete</a>

				 </div></td>

				 <?php if($billtype == 'PAY LATER')

				{

				?>

				<td class="bodytext31" valign="center"  align="left"><div align="center">

				<input type="checkbox" name="pharamlatertonow[<?php echo $sno; ?>]" id="pharamlatertonow<?php echo $sno; ?>" value="<?php echo $medanum; ?>" onClick="selectcash('pharam','<?php echo $sno; ?>')" <?php if($approvalstatus=='2'){ echo "checked=checked";}?>>

				</div></td>

				<?php } ?>

				</tr>

			<?php 

			} 

			}?>-->

			  

           

          </tbody>

        </table>		</td>

      </tr>

	  <?php } ?> 

	  <!--

	  <input type="hidden" name="pharmacysno" id="pharmacysno" value="<?php echo $sno; ?>">

      <tr>

	   <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Prescribe Medicine</strong></td>

	 

	  </tr>

     <tr id="pressid">

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				   <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">

                     <tr>

                       <td width="150" class="bodytext3">Medicine Name</td>

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

					   <input type="hidden" name="genericname" id="genericname">	

				  		<input type="hidden" name="drugallergy" id="drugallergy">

						<input type="hidden" name="exclude[]" id="exclude">	

                       <td><input name="medicinename" type="text" id="medicinename" size="40"></td>

                       <td><input name="dose[]" type="text" id="dose" size="8" onKeyUp="return Functionfrequency1()"></td>

					   <td><select name="dosemeasure[]" id="dosemeasure">

					   <option value="">Select Measure</option>

					   <option value="mcg">mcg</option>

					   <option value="mg">mg</option>

					   <option value="g">g</option>

					   <option value="ml">ml</option>

					   <option value="l">l</option>

					   <option value="I.U">I.U</option>

					   <option value="meq">meq</option>

					   <option value="mmol">mmol</option>

					   </select></td>

                       <td>

					    <input name="formula" type="hidden" id="formula" readonly size="8">

						<input name="strength" type="hidden" id="strength" readonly size="8">

					   <select name="frequency[]" id="frequency" onChange="return Functionfrequency1()">

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

                       <td><input name="days[]" type="text" id="days" size="8" onKeyUp="return Functionfrequency1()" onFocus="return frequencyitem()"></td>

                       <td><input name="quantity[]" type="text" id="quantity" size="8" readonly></td>

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

					   </select></td>

                       <td><input name="instructions[]" type="text" id="instructions" size="20"></td>

                       <td width="48"><input name="rates[]" type="text" id="rates" readonly size="8"></td>

                       <td>

                         <input name="amount[]" type="text" id="amount" readonly size="8"></td>

                       <td><label>

                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" >

                       </label></td>

				     </tr>

                     

					 <input type="hidden" name="h" id="h" value="0">

                   </table>				  </td>

          </tr>

		  <tr>

				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Dispensing Fee</span><input type="text" name="dispensingfee" id="dispensingfee" size="7" onKeyUp="return calculate();"></td>

			      </tr>

				    <tr>

				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total" readonly size="7"></td>

			      </tr>

			-->	  

				 <?php

				if($billtype == 'PAY NOW')

				{

				$status='pending';

				}

				else

				{

				$status='pending';

				}

				 $query171lab = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='$status'  and approvalstatus<>'2'";

				 $exec171lab = mysqli_query($GLOBALS["___mysqli_ston"], $query171lab) or die ("Error in Query171lab".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

				 $num171lab = mysqli_num_rows($exec171lab);

				 $query172lab = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'  and approvalstatus='2'";

				 $exec172lab = mysqli_query($GLOBALS["___mysqli_ston"], $query172lab) or die ("Error in Query172lab".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

				 $num172lab = mysqli_num_rows($exec172lab);

				  $query173lab = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed'  and approvalstatus='1'";

				 $exec173lab = mysqli_query($GLOBALS["___mysqli_ston"], $query173lab) or die ("Error in Query173lab".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

				 $num173lab = mysqli_num_rows($exec173lab);

				 $num17lab = $num171lab + $num172lab + $num173lab;

				 ?>

		 <tr>



	  <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Lab </strong></td>

	  </tr>

				  <tr>

        <td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 

            align="left" border="0">

          <tbody id="foo">

		  <?php if($num17lab > 0) {?>

            <tr>

			<?php if($billtype == 'PAY LATER')

				{

				?>

			<td width="6%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>

				<?php } ?>

              <td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

				

				<td width="22%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Lab</strong></div></td>

				<td width="15%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>

					<td width="15%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>

				<td width="15%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?>

				<td width="19%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>

				<?php } ?>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Cash Copay</strong></div></td>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Override</strong></div></td>

                  </tr>

				  		<?php

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			if($billtype == 'PAY NOW')

			{

			$status='pending';

			}

			else

			{

			$status='pending';

			}

			$query30 = "select lablimit, radiologylimit, serviceslimit, pharmacylimit from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";
			$exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res30 = mysqli_fetch_array($exec30);
			$labdptlimit = $res30['lablimit'];
			$raddptlimit = $res30['radiologylimit'];
			$serdptlimit = $res30['serviceslimit'];
			$pharmdptlimit = $res30['pharmacylimit'];
			
			if($labdptlimit == 0 && $raddptlimit == 0 && $serdptlimit == 0 && $pharmdptlimit == 0){
				$dptlimitcheck = $availablelimit;
			} else {
				if($availablelimit < $labdptlimit){
					$dptlimitcheck = $availablelimit;
				} else {
					$dptlimitcheck = $labdptlimit;
				}
			}

			$query17 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode'   and ((paymentstatus = 'pending' and approvalstatus <> '1') OR (approvalstatus <> '2'))"; 

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			while ($res17 = mysqli_fetch_array($exec17))

			{

			

				$paharmitemname=$res17['labitemname'];				

				$pharmitemcode=$res17['labitemcode'];

				$pharmitemrate=$res17['labitemrate'];

				$labamount=$res17['pharmitemrate'];

				$labanum=$res17['auto_number'];

				$approvalstatus=$res17['approvalstatus'];

			$grandtotal = $grandtotal + $pharmitemrate;

			$colorloopcount = $colorloopcount + 1;

			$sno=$sno+1;

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

			$totalamount=$totalamount+$pharmitemrate;

			?>

			  <tr <?php echo $colorcode; ?>>

			  <?php if($billtype == 'PAY LATER')

				{

				 if($res17['paymentstatus']=='completed'){



				?>

			   <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="labcheck<?php echo $sno; ?>" name="labcheck[<?php echo $sno; ?>]" value="<?php echo $labanum; ?>"  <?php if($approvalstatus=='1' && $res17['paymentstatus']=='completed'){ echo "checked=checked"; $selecttotal=$selecttotal+$pharmitemrate;}?> onClick="approvalfunction(this.id,<?php echo $pharmitemrate; ?>),selectselect('lab','<?php echo $sno; ?>')"  />

			   <input type="hidden" name="labanum[<?php echo $sno; ?>]" id="labanum<?php echo $sno; ?>"  value="<?php echo $labanum; ?>">

			   </div></td>

			   <?php }else{ echo "<td></td>"; }

			   } ?>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>

			    

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <input type="hidden" name="pharmitemrate<?php echo $sno; ?>" id="pharmitemrate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>">

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><!--<a onClick="return deletevalid()" href="opamend_seek.php?delete=<?php echo $labanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=lab">Delete</a>--></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?> 

				<td class="bodytext31" valign="center"  align="left"><div align="center">

				<input type="checkbox" name="lablatertonow[<?php echo $sno; ?>]" id="lablatertonow<?php echo $sno; ?>"  onClick="approvalfunction2(this.id,<?php echo $pharmitemrate; ?>),selectcash('lab','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "disabled=disabled";}if($approvalstatus=='2'){ echo "checked=checked";}?>>

				</div></td>

				<?php } ?>
				<td class="bodytext31" valign="center"  align="lefts">
					<input type="hidden" name="dptlimit" id="dptlimit" value="<?php echo $labdptlimit; ?>">
					<input type="hidden" name="dptlimitcheck" id="dptlimitcheck" value="<?php echo $dptlimitcheck; ?>">
					<input style="text-align: right;" type="hidden" name="labcopayamount<?php echo $sno; ?>" id="labcopayamount<?php echo $sno; ?>" size="8" readonly>
					<input style="text-align: right;" type="hidden" name="labcashfixed<?php echo $sno; ?>" id="labcashfixed<?php echo $sno; ?>" size="8" readonly>
					<input style="text-align: right;" type="text" name="labcashinput<?php echo $sno; ?>" id="labcashinput<?php echo $sno; ?>" size="8" onkeypress="return isNumberKey(event)" onkeyup="myLabCalculateFunction(<?php echo $sno; ?>, event)" >
				</td>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="laboverride[<?php echo $sno; ?>]" id="laboverride<?php echo $sno; ?>" onClick="selectcash('laboverride','<?php echo $sno; ?>')" value="<?php echo $labanum;?>"></div></td>
				</tr>

			<?php } ?>

            

			<!--<?php

			$query17 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'  and approvalstatus='2'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			while ($res17 = mysqli_fetch_array($exec17))

			{

			

				$paharmitemname=$res17['labitemname'];				

				$pharmitemcode=$res17['labitemcode'];

				$pharmitemrate=$res17['labitemrate'];

				$labanum=$res17['auto_number'];

				$approvalstatus=$res17['approvalstatus'];

			//$grandtotal = $grandtotal + $pharmitemrate;

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			$sno=$sno+1;

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

			//$totalamount=$totalamount+$pharmitemrate;

			

			?>

			  <tr <?php echo $colorcode; ?>>

			  <?php if($billtype == 'PAY LATER')

				{

				?>

			   <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="labcheck<?php echo $sno; ?>" name="labcheck[<?php echo $sno; ?>]" value="<?php echo $labanum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";}?> <?php if($approvalstatus=='2'){ echo "disabled=disabled";}?> onClick="selectselect('lab','<?php echo $sno; ?>')"/>

			   <input type="hidden" name="labanum[<?php echo $sno; ?>]" id="labanum<?php echo $sno; ?>"  value="<?php echo $labanum; ?>">

			   </div></td>

			   <?php } ?>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>

			    

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend_seek.php?delete=<?php echo $labanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=lab">Delete</a></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?>

				<td class="bodytext31" valign="center"  align="left"><div align="center">

				<input type="checkbox" name="lablatertonow[<?php echo $sno; ?>]" id="lablatertonow<?php echo $sno; ?>"  onClick="selectcash('lab','<?php echo $sno; ?>')" <?php if($approvalstatus=='2'){ echo "checked=checked";}?>>

				</div></td>

				<?php } ?>

				</tr>

			<?php } ?> -->

			 <tr>

			<?php } ?> <input type="hidden" name="labsno" id="labsno" value="<?php echo $sno; ?>">

	   <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Add Lab Tests</strong></td>

	 

	  </tr>

			<tr id="labid">

				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				     <table width="621" border="0" cellspacing="1" cellpadding="1">

                     <tr>

                       <td width="30" class="bodytext3">Laboratory Test</td>

                       <td class="bodytext3">Rate</td>

                       <td width="30" class="bodytext3">&nbsp;</td>

                     </tr>

					  <tr>

					 <div id="insertrow1">					 </div></tr>

					  <tr>

					  <input type="hidden" name="serialnumber1" id="serialnumber1" value="1">

					  <input type="hidden" name="labcode" id="labcode" value="">

					  <input type="hidden" name="hiddenlab" id="hiddenlab">

				      <td width="30"><input name="lab[]" id="lab" type="text" size="69" autocomplete="off" ></td>

				      <td width="30"><input name="rate5[]" type="text" id="rate5" readonly size="8"></td>

					  <td><label>

                       <input type="button" name="Add1" id="Add1" value="Add" onClick="return insertitem6()" class="button" >

                       </label></td>

					   </tr>

					    </table>	  </td> 

					

				      </tr>

					  <tr>

					  	<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" colspan="8">
			       			<table border="0" width="1050">
			       				<tr>
			       					<td width="790" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Lab Limit</span><input type="text" id="dptlimitcheck" readonly size="7" value="<?php echo number_format($dptlimitcheck,2); ?>"></td>
			       					<td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total1" readonly size="7" value="<?php echo number_format($totalamount,2); $labtotals=$totalamount;?>"></td>
			       				</tr>
			       			</table>
		       			</td>
				   <!-- <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Lab Limit</span><input type="text" id="dptlimitcheck" readonly size="7" value="<?php echo number_format($dptlimitcheck,2); ?>"></td>
				   <td colspan="3" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total1" readonly size="7" value="<?php echo number_format($totalamount,2); $totalamount=0;?>"></td> -->

				  </tr>			             

          </tbody>

        </table>		</td>

      </tr>

	  <?php 

	  if($billtype == 'PAY NOW')

	{

		$status='pending';

	}

	else

	{

		$status='pending';

	}

		$query171rad = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='$status'  and approvalstatus<>'2'";

		$exec171rad = mysqli_query($GLOBALS["___mysqli_ston"], $query171rad) or die ("Error in Query171rad".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$num171rad  = mysqli_num_rows($exec171rad);

		$query172rad = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'  and approvalstatus='2'";

		$exec172rad = mysqli_query($GLOBALS["___mysqli_ston"], $query172rad) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$num172rad  = mysqli_num_rows($exec172rad);

		$query173rad = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed'  and approvalstatus='1'";

		$exec173rad = mysqli_query($GLOBALS["___mysqli_ston"], $query173rad) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

		$num173rad  = mysqli_num_rows($exec173rad);

		$num17rad = $num171rad + $num172rad + $num173rad;

	  ?>

	   <tr>

	  <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Radiology </strong></td>

	  </tr>

	  <?php if($num17rad>0)

	  { ?>

	  <tr>	  

        <td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 

            align="left" border="0">

          <tbody id="foo">

            <tr>

			<?php if($billtype == 'PAY LATER')

				{

				?>

			<td width="5%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>

				<?php }?>

              <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

				

				<td width="21%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Radiology</strong></div></td>

				<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>


				<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Discount</strong></div></td>

				<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>

				<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?>

              	<td width="18%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>

				<?php } ?>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Cash Copay</strong></div></td>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Override</strong></div></td>
                  </tr>

				  		<?php 

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			if($billtype == 'PAY NOW')

			{

			$status='pending';

			}

			else

			{

			$status='pending';

			}


			$query30 = "select lablimit, radiologylimit, serviceslimit, pharmacylimit from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";;
			$exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res30 = mysqli_fetch_array($exec30);
			$labdptlimit = $res30['lablimit'];
			$raddptlimit = $res30['radiologylimit'];
			$serdptlimit = $res30['serviceslimit'];
			$pharmdptlimit = $res30['pharmacylimit'];

            $availablelimit=$availablelimit-$labtotals;
			if($availablelimit<0)
				$availablelimit =0;
			
			if($labdptlimit == 0 && $raddptlimit == 0 && $serdptlimit == 0 && $pharmdptlimit == 0){
				$raddptlimitcheck = $availablelimit;
			} else {
				if($availablelimit < $raddptlimit){
					$raddptlimitcheck = $availablelimit;
				} else {
					$raddptlimitcheck = $raddptlimit;
				}
			}


			$query17 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode'   and ((paymentstatus = 'pending' and approvalstatus <> '1') OR (approvalstatus <> '2'))";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			while ($res17 = mysqli_fetch_array($exec17))

			{

			

			$paharmitemname=$res17['radiologyitemname'];				

			$pharmitemcode=$res17['radiologyitemcode'];


			$pharmitemrate=$res17['radiologyitemrate'];

			$radanum=$res17['auto_number'];

			$approvalstatus=$res17['approvalstatus'];	

			$grandtotal = $grandtotal + $pharmitemrate;

			$querydisc = "select discount from master_radiology where itemcode = '$pharmitemcode'";
			$execdisc = mysqli_query($GLOBALS["___mysqli_ston"], $querydisc) or die("Error in Querydisc".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resdisc = mysqli_fetch_array($execdisc);
			$discount = $resdisc['discount'];

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			$sno=$sno+1;

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

			$totalamount=$totalamount+$pharmitemrate;

			?>

			  <tr <?php echo $colorcode; ?>>

			  <?php if($billtype == 'PAY LATER')

				{

				 if($res17['paymentstatus']=='completed'){

				?>

			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="radcheck<?php echo $sno; ?>" name="radcheck[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>"  <?php if($approvalstatus=='1' && $res17['paymentstatus']=='completed'){ echo "checked=checked";  $selecttotal=$selecttotal+$pharmitemrate;}?> onClick="approvalfunction3(this.id,<?php echo $pharmitemrate; ?>),selectselect('rad','<?php echo $sno; ?>')"   />

			  <input type="hidden" name="radanum[<?php echo $sno; ?>]" id="radanum<?php echo $sno; ?>"  value="<?php echo $radanum; ?>">

			  </div></td>

			  <?php }else{ echo "<td></td>"; }

			  } ?>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
			    <input type="hidden" name="radrate<?php echo $sno; ?>" id="radrate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>">
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php if($discount=='yes'){ ?><input style="text-align: right;" type="text" name="raddiscountinput<?php echo $sno; ?>" id="raddiscountinput<?php echo $sno; ?>" value="0.00" size="8" onkeypress="return isNumberKey(event)" onkeyup="myRadDiscountCalcultateFunc(<?php echo $sno; ?>, event); checkfunction(<?php echo $sno; ?>, event);" ><?php } ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><label id="radtotal<?php echo $sno; ?>"><?php echo $pharmitemrate; ?></label></div></td>
				 <input type="hidden" name="raditemrate<?php echo $sno; ?>" id="raditemrate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>">

				  <td class="bodytext31" valign="center"  align="left"><div align="center"><!--<a onClick="return deletevalid()" href="opamend_seek.php?delete=<?php echo $radanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=radiology">Delete</a>--></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?>  

				<td class="bodytext31" valign="center"  align="left"><div align="center">

				<input type="checkbox" name="radlatertonow[<?php echo $sno; ?>]" id="radlatertonow<?php echo $sno; ?>" onClick="approvalfunction2(this.id,<?php echo $pharmitemrate; ?>),selectcash('rad','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "disabled=disabled";}if($approvalstatus=='2'){ echo "checked=checked";}?>>

				</div></td>

				<?php } ?>
				<td class="bodytext31" valign="center"  align="lefts">
					<input type="hidden" name="raddptlimit" id="raddptlimit" value="<?php echo $raddptlimit; ?>">
					<input type="hidden" name="raddptlimitcheck" id="raddptlimitcheck" value="<?php echo $raddptlimitcheck; ?>">
					<input style="text-align: right;" type="hidden" name="radcopayamount<?php echo $sno; ?>" id="radcopayamount<?php echo $sno; ?>" size="8" readonly>
					<input style="text-align: right;" type="hidden" name="radcashfixed<?php echo $sno; ?>" id="radcashfixed<?php echo $sno; ?>" size="8" readonly>
					<input style="text-align: right;" type="text" name="radcashinput<?php echo $sno; ?>" id="radcashinput<?php echo $sno; ?>" size="8" onkeypress="return isNumberKey(event)" onkeyup="myRadCalculateFunction(<?php echo $sno; ?>, event)" >
				</td>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="radoverride[<?php echo $sno; ?>]" id="radoverride<?php echo $sno; ?>" onClick="selectcash('radoverride','<?php echo $sno; ?>')"></div></td>

				</tr>

			<?php } ?> 

			<!-- <?php

            $query17 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'  and approvalstatus='2'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			while ($res17 = mysqli_fetch_array($exec17))

			{

			

			$paharmitemname=$res17['radiologyitemname'];				

			$pharmitemcode=$res17['radiologyitemcode'];

			$pharmitemrate=$res17['radiologyitemrate'];

			$radanum=$res17['auto_number'];

			$approvalstatus=$res17['approvalstatus'];	

			//$grandtotal = $grandtotal + $pharmitemrate;

			$colorloopcount = $colorloopcount + 1;

			$sno=$sno+1;

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

			//$totalamount=$totalamount+$pharmitemrate;

						?>

			  <tr <?php echo $colorcode; ?>>

			  <?php if($billtype == 'PAY LATER')

				{

				?>

			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="radcheck<?php echo $sno; ?>" name="radcheck[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";}?> <?php if($approvalstatus=='2'){ echo "disabled=disabled";}?> onClick="selectselect('rad','<?php echo $sno; ?>')"/>

			  <input type="hidden" name="radanum[<?php echo $sno; ?>]" id="radanum<?php echo $sno; ?>"  value="<?php echo $radanum; ?>">

			  </div></td>

			  <?php } ?>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>

			   

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend_seek.php?delete=<?php echo $radanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=radiology">Delete</a></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?>

				<td class="bodytext31" valign="center"  align="left"><div align="center">

				<input type="checkbox" name="radlatertonow[<?php echo $sno; ?>]" id="radlatertonow<?php echo $sno; ?>" onClick="selectcash('rad','<?php echo $sno; ?>')" <?php if($approvalstatus=='2'){ echo "checked=checked";}?>>

				</div></td>

				<?php } ?>

				</tr>

			<?php } ?>-->

          </tbody>

        </table>		</td>

      </tr>

	  <?php } ?> <input type="hidden" name="radsno" id="radsno" value="<?php echo $sno; ?>">

      <tr>

	   <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Add Radiology Tests</strong></td>

	 

	  </tr>

     <tr id="radid">

				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

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

					  <input type="hidden" name="hiddenradiology" id="hiddenradiology">

				   <td width="30"> <input name="radiology[]" id="radiology" type="text" size="69" autocomplete="off"></td>

				      <td width="30"><input name="rate8[]" type="text" id="rate8" readonly size="8"></td>

					   <td><label>

                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem7()" class="button" >

                       </label></td>

					   </tr>

					    </table>

						</td>

						

		       </tr>

				

				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		       			<table border="0" width="1050">
		       				<tr>
		       					<td width="790" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Rad Limit</span><input type="text" id="total1" readonly size="7" value="<?php echo number_format($raddptlimitcheck,2); ?>"></td>
		       					<td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total2" readonly size="7" value="<?php echo number_format($totalamount,2); $radtotals=$totalamount;?>"></td>
		       				</tr>
		       			</table>
		       		</td>
				   </tr>

				   <?php 

			   if($billtype == 'PAY NOW')

				{

					$status='pending';

				}

				else

				{

					$status='pending';

				}

			$query171ser = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='$status'  and approvalstatus<>'2'";

			$exec171ser = mysqli_query($GLOBALS["___mysqli_ston"], $query171ser) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			$num171ser = mysqli_num_rows($exec171ser);

			$query172ser = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'  and approvalstatus='2'";

			$exec172ser = mysqli_query($GLOBALS["___mysqli_ston"], $query172ser) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			$num172ser = mysqli_num_rows($exec172ser);

			 $query173ser = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed'  and approvalstatus='1'";

			$exec173ser = mysqli_query($GLOBALS["___mysqli_ston"], $query173ser) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			$num173ser = mysqli_num_rows($exec173ser);

			$num17ser = $num171ser + $num172ser+ $num173ser;

			?>

			 <tr>

	  <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Services </strong></td>

	  </tr>

	  <?php

	  if($num17ser>0)

	  {

	  ?>

		<tr>

        <td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 

            align="left" border="0">

          <tbody id="foo">

            <tr>

			<?php if($billtype == 'PAY LATER')

				{

				?>

			<td width="5%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>

				<?php } ?>

              <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

				

				<td width="21%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Services</strong></div></td>

				<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>

                <td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Service Qty  </strong></div></td>

					<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>

				<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?>

              	<td width="18%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>

				<?php } ?>

				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Cash Copay</strong></div></td>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Override</strong></div></td>

                  </tr>

				  		<?php

						

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			if($billtype == 'PAY NOW')

			{

			$status='pending';

			}

			else

			{

			$status='pending';

			}

			$query30 = "select lablimit, radiologylimit, serviceslimit, pharmacylimit from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";
			$exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res30 = mysqli_fetch_array($exec30);
			$labdptlimit = $res30['lablimit'];
			$raddptlimit = $res30['radiologylimit'];
			$serdptlimit = $res30['serviceslimit'];
			$pharmdptlimit = $res30['pharmacylimit'];

			$availablelimit=$availablelimit-$radtotals;
			if($availablelimit<0)
				$availablelimit =0;
			
			if($labdptlimit == 0 && $raddptlimit == 0 && $serdptlimit == 0 && $pharmdptlimit == 0){
				$serdptlimitcheck = $availablelimit;
			} else {
				if($availablelimit < $serdptlimit){
					$serdptlimitcheck = $availablelimit;
				} else {
					$serdptlimitcheck = $serdptlimit;
				}
			}

			$query17 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode'   and wellnessitem <> '1' and ((paymentstatus = 'pending' and approvalstatus <> '1') OR (approvalstatus <> '2'))";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			while ($res17 = mysqli_fetch_array($exec17))

			{

			

			$paharmitemname=$res17['servicesitemname'];

			$pharmitemcode=$res17['servicesitemcode'];

			$pharmitemrate=$res17['servicesitemrate'];

			$seranum = $res17['auto_number'];

			$serqty = $res17['serviceqty'];

			$amount11 = $res17['amount'];

			$approvalstatus=$res17['approvalstatus'];

			$pharmitemrate1=$pharmitemrate*$serqty;

			$grandtotal = $grandtotal + $pharmitemrate1;

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			$sno=$sno+1;

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

			$totalamount=$totalamount+$amount11;

					

			?>

			  <tr <?php echo $colorcode; ?>>

			  <?php if($billtype == 'PAY LATER')

				{

				 if($res17['paymentstatus']=='completed'){

				?>

			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="sercheck<?php echo $sno; ?>" name="sercheck[<?php echo $sno; ?>]" value="<?php echo $seranum; ?>"  <?php if($approvalstatus=='1' && $res17['paymentstatus']=='completed'){ echo "checked=checked"; $selecttotal=$selecttotal+$amount11;}?> onClick="approvalfunction3(this.id,<?php echo $amount11; ?>),selectselect('ser','<?php echo $sno; ?>')"  />

			  <input type="hidden" name="seranum[<?php echo $sno; ?>]" id="seranum<?php echo $sno; ?>" value="<?php echo $seranum; ?>">

	

			  </div></td>

			  <?php }else{ echo "<td></td>"; }

			  } ?>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>

			    

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $amount11; ?></div></td>
				 <input type="hidden" name="seritemrate<?php echo $sno; ?>" id="seritemrate<?php echo $sno; ?>" value="<?php echo $amount11; ?>">
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><!--<a onClick="return deletevalid()" href="opamend_seek.php?delete=<?php echo $seranum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=service">Delete</a>--></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?> 

				<td class="bodytext31" valign="center"  align="left"><div align="center">

				<input type="checkbox" name="serlatertonow[<?php echo $sno; ?>]" id="serlatertonow<?php echo $sno; ?>"  onClick="approvalfunction2(this.id,<?php echo $amount11; ?>),selectcash('ser','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "disabled=disabled";}if($approvalstatus=='2'){ echo "checked=checked";}?>>

				</div></td>

				<?php }?>

				<td class="bodytext31" valign="center"  align="lefts">
					<input type="hidden" name="serdptlimit" id="serdptlimit" value="<?php echo $serdptlimit; ?>">
					<input type="hidden" name="serdptlimitcheck" id="serdptlimitcheck" value="<?php echo $serdptlimitcheck; ?>">
					<input style="text-align: right;" type="hidden" name="sercopayamount<?php echo $sno; ?>" id="sercopayamount<?php echo $sno; ?>" size="8" readonly>
					<input style="text-align: right;" type="hidden" name="sercashfixed<?php echo $sno; ?>" id="sercashfixed<?php echo $sno; ?>" size="8" readonly>
					<input style="text-align: right;" type="text" name="sercashinput<?php echo $sno; ?>" id="sercashinput<?php echo $sno; ?>" size="8" onkeypress="return isNumberKey(event)" onkeyup="mySerCalculateFunction(<?php echo $sno; ?>, event)" >
				</td>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="seroverride[<?php echo $sno; ?>]" id="seroverride<?php echo $sno; ?>" onClick="selectcash('seroverride','<?php echo $sno; ?>')"></div></td>

				</tr>

			<?php } ?> 

			 <!-- <?php

			  $query17 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and wellnessitem <> '1'  and approvalstatus='2'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			while ($res17 = mysqli_fetch_array($exec17))

			{

			

			$paharmitemname=$res17['servicesitemname'];

			$pharmitemcode=$res17['servicesitemcode'];

			$pharmitemrate=$res17['servicesitemrate'];

			$seranum = $res17['auto_number'];

			$serqty = $res17['serviceqty'];

			$amount1 = $res17['amount'];

			$approvalstatus=$res17['approvalstatus'];

			//$grandtotal = $grandtotal + $pharmitemrate;

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			$sno=$sno+1;

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

			//$totalamount=$totalamount+$amount1;

			

		

			?>

			  <tr <?php echo $colorcode; ?>>

			  <?php if($billtype == 'PAY LATER')

				{

				?>

			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="sercheck<?php echo $sno; ?>" name="sercheck[<?php echo $sno; ?>]" value="<?php echo $seranum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";}?> <?php if($approvalstatus=='2'){ echo "disabled=disabled";}?> onClick="selectselect('ser','<?php echo $sno; ?>')"/>

			  <input type="hidden" name="seranum[<?php echo $sno; ?>]" id="seranum<?php echo $sno; ?>" value="<?php echo $seranum; ?>">

	

			  </div></td>

			  <?php } ?>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>

			    

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>

                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $amount1; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend_seek.php?delete=<?php echo $seranum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=service">Delete</a></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?>

				<td class="bodytext31" valign="center"  align="left"><div align="center">

				<input type="checkbox" name="serlatertonow[<?php echo $sno; ?>]" id="serlatertonow<?php echo $sno; ?>"  onClick="selectcash('ser','<?php echo $sno; ?>')"  <?php if($approvalstatus=='2'){ echo "checked=checked";}?>>

				</div></td>

				<?php }?>

				</tr>

			<?php } ?>-->

           

          </tbody>

        </table>		</td>

      </tr>

	  <?php } ?> <input type="hidden" name="sersno" id="sersno" value="<?php echo $sno; ?>">

      <tr>

	   <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Add Service</strong></td>

	 

	  </tr>

     <tr id="serid">

				   <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">

                     <tr>

                       <td width="30" class="bodytext3">Services</td>

					    <td width="30" class="bodytext3">Qty</td>

                       <td class="bodytext3">Rate</td>

                       <td width="30" class="bodytext3">Amount</td>

                     </tr>

					  <tr>

					 <div id="insertrow3">					 </div></tr>

					  <tr>

					  <input type="hidden" name="serialnumber3" id="serialnumber3" value="1">

					  <input type="hidden" name="servicescode" id="servicescode" value="">

					  <input type="hidden" name="hiddenservices" id="hiddenservices">

				   <td width="30"><input name="services[]" type="text" id="services" size="69" autocomplete="off"></td>

				    <td width="30"><input name="serviceqty[]" type="text" id="serviceqty" size="8" autocomplete="off" onKeyUp="return sertotal()"></td>

				    <td width="30"><input name="rate3[]" type="text" id="rate3" readonly size="8"></td>

					<td width="30"><input name="serviceamount[]" type="text" id="serviceamount" readonly size="8"></td>

					   <td><label>

                       <input type="button" name="Add3" id="Add3" value="Add" onClick="return insertitem8()" class="button">

                       </label></td>

					   </tr>

					    </table></td>

		       </tr>

			   <tr>

				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		       			<table border="0" width="1050">
		       				<tr>
		       					<td width="790" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Ser. Limit</span><input type="text" id="total1" readonly size="7" value="<?php echo number_format($serdptlimitcheck,2); ?>"></td>
		       					<td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total3" readonly size="7" value="<?php echo number_format($totalamount,2); $totalamount=0; ?>"></td>
		       				</tr>
		       			</table>
		       		</td>

				   </tr>

 <tr>

	  <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Referral </strong></td>

	  </tr>

	  <?php

	  ?>

		<tr>

        <td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 

            align="left" border="0">

          <tbody id="foo">

            <tr>

			<?php if($billtype == 'PAY LATER')

				{

				?>

			<td width="5%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>

				<?php } ?>

              <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

				

				<td width="21%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Referral</strong></div></td>

				<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>

					<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>

				<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?>

              	<td width="18%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>

				<?php } ?>

                  </tr>

				  		<?php

						

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			if($billtype == 'PAY NOW')

			{

			$status='pending';

			}

			else

			{

			$status='pending';

			}

			$query17 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode'  and paymentstatus='pending'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			while ($res17 = mysqli_fetch_array($exec17))

			{

			

			$paharmitemname=$res17['referalname'];

			$pharmitemcode=$res17['referalcode'];

			$pharmitemrate1=$res17['referalrate'];

			$refanum = $res17['auto_number'];

			$amount11 = $res17['referalrate'];

			$grandtotal = $grandtotal + $pharmitemrate1;

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			$sno=$sno+1;

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

			$totalamount=$totalamount+$amount11;

					

			?>

			  <tr <?php echo $colorcode; ?>>

			  <?php if($billtype == 'PAY LATER')

				{

				 if($res17['paymentstatus']!='completed'){

				?>

			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="refcheck<?php echo $sno; ?>" name="refcheck[<?php echo $sno; ?>]" value="<?php echo $refanum; ?>"  <?php if($res17['paymentstatus']!='completed'){ echo "checked=checked"; $selecttotal=$selecttotal+$amount11;}?> onClick="approvalfunction3(this.id,<?php echo $amount11; ?>),selectselect('ref','<?php echo $sno; ?>')"  />

			  <input type="hidden" name="refanum[<?php echo $sno; ?>]" id="refanum<?php echo $sno; ?>" value="<?php echo $refanum; ?>">

	

			  </div></td>

			  <?php }else{ echo "<td></td>"; }

			  } ?>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>

			    

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate1; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $amount11; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><!--<a onClick="return deletevalid()" href="opamend_seek.php?delete=<?php echo $refanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=referal">Delete</a>--></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?> 

				<td class="bodytext31" valign="center"  align="left"><div align="center">

				

				</div></td>

				<?php }?>

				</tr>

			<?php } ?> 

			

           

          </tbody>

        </table>		</td>

      </tr>

	  <tr>

				   <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total3" readonly size="7" value="<?php echo number_format($totalamount,2); $totalamount=0; ?>"></td>

				   </tr>

	   <tr>

	  <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Departmental Referral </strong></td>

	  </tr>

	  <?php

	  ?>

		<tr>

        <td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 

            align="left" border="0">

          <tbody id="foo">

            <tr>

			<?php if($billtype == 'PAY LATER')

				{

				?>

			<td width="5%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>

				<?php } ?>

              <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

				

				<td width="21%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Referral</strong></div></td>

				<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>

					<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>

				<td width="14%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?>

              	<td width="18%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>

				<?php } ?>

                  </tr>

				  		<?php

						

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			if($billtype == 'PAY NOW')

			{

			$status='pending';

			}

			else

			{

			$status='pending';

			}

			$query17 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode'  and paymentstatus='pending'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

			while ($res17 = mysqli_fetch_array($exec17))

			{

			

			$paharmitemname=$res17['referalname'];

			$pharmitemcode=$res17['referalcode'];

			$pharmitemrate1=$res17['referalrate'];

			$deprefanum = $res17['auto_number'];

			$amount11 = $res17['referalrate'];

			$grandtotal = $grandtotal + $pharmitemrate1;

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			$sno=$sno+1;

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

			$totalamount=$totalamount+$amount11;

					

			?>

			  <tr <?php echo $colorcode; ?>>

			  <?php if($billtype == 'PAY LATER')

				{

				 if($res17['paymentstatus']!='completed'){

				?>

			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="deprefcheck<?php echo $sno; ?>" name="deprefcheck[<?php echo $sno; ?>]" value="<?php echo $deprefanum; ?>"  <?php if($res17['paymentstatus']!='completed'){ echo "checked=checked"; $selecttotal=$selecttotal+$amount11;}?> onClick="approvalfunction3(this.id,<?php echo $amount11; ?>),selectselect('depref','<?php echo $sno; ?>')"  />

			  <input type="hidden" name="deprefanum[<?php echo $sno; ?>]" id="deprefanum<?php echo $sno; ?>" value="<?php echo $deprefanum; ?>">

	

			  </div></td>

			  <?php }else{ echo "<td></td>"; }

			  } ?>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>

			    

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate1; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $amount11; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><!--<a onClick="return deletevalid()" href="opamend_seek.php?delete=<?php echo $deprefanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=depreferal">Delete</a>--></div></td>

				<?php if($billtype == 'PAY LATER')

				{

				?> 

				<td class="bodytext31" valign="center"  align="left"><div align="center">

				

				</div></td>

				<?php }?>

				</tr>

			<?php } ?> 

			

           

          </tbody>

        </table>		</td>

      </tr>

			   <tr>

				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total5" readonly size="7" value="<?php echo number_format($totalamount,2); $totalamount=0;?>"></td>

				  </tr>

				 

		

      <tr>        

		 <td colspan="2" align="right" valign="top"  bgcolor="#ecf0f5" class="bodytext3">

		 <textarea name="approvecomment" id="approvecomment" style="display:none"></textarea>

		 Approve check <input type="checkbox" value="1"  name="approve" id="approve" onClick="approvecheck();"> 

		  <input type="hidden" name="frm1submit1" value="frm1submit1" />

                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />

               <input name="Submit222" type="submit"  value="Approve" onClick="return alertfun()" class="button" />

			   <?php $grandtotal=number_format($grandtotal,2); echo '<script>document.getElementById("grandtotal").value="'.$grandtotal.'";</script>'?>

		 </td>

      </tr>

	  </table>

      </td>

      </tr>    

  </table>

</form>

<script type="text/javascript" src="js/jquery-ui.js"></script>

<link rel="stylesheet" href="js/jquery-ui.css"/> 



<script type="text/javascript">

$(document).ready(function(){

	

	$(function() {

		$( "#medicinename" ).autocomplete({

			source: 'autosearchmedicine.php',

			minLength:1,

			delay: 0,

			html: true, 

			select: function(event,ui){

				var mediciencode = ui.item.itemcode;

				/*var mediciennames = ui.item.itemname;

				var medicienrates = ui.item.rateperunit;

				var disease = ui.item.disease;

				var genericname = ui.item.genericname;*/

				funcmedicinesearch(mediciencode);

			},

		   

		});

	});	



	function funcmedicinesearch(itemcode){

		var medicinesearch = itemcode;

		var accountname = $("#subtype").val();

		//alert(accountname);

		$.post("automedicinecodesearch2.php",{ "medicinesearch" : medicinesearch,"accountname" : accountname },function(data){ 

			//alert(data);

			var t = "";

			t=t+data;

			//alert(t);

			var varCompleteStringReturned=t;

			var varNewLineValue=varCompleteStringReturned.split("||");

			//alert(varNewLineValue[7]);

			var varNewLineLength = varNewLineValue.length;

			

			if(varNewLineValue[7]>0){

		

				var varMedicineCode = varNewLineValue[0];

				//alert (varMedicineCode);

				$("#medicinecode").val(varMedicineCode);

				

				var varMedicineName = varNewLineValue[1];

				//alert (varMedicineName);

				$("#medicinename").val(varMedicineName);

				

				var varMedicineRate = varNewLineValue[2];

				//alert (varMedicineName);

				$("#rates").val(varMedicineRate);

				

			    var varFormula = varNewLineValue[3];

				//alert (varFormula);

				$("#formula").val(varFormula);

			

			    var varStrength = varNewLineValue[4];

				

				$("#strength").val(varStrength);

				

				var vargenericname1 = varNewLineValue[5];

				

				$("#genericname").val(vargenericname1);

				

				var drugallergy = $("#drugallergy").val();

				

				vargenericname1 = vargenericname1.toUpperCase();

		

		if((vargenericname1 != '')&&(drugallergy != ''))

		{

		

		if(drugallergy == vargenericname1)

		{

			var check=confirm('Patient is Allergic to this drug, Do you like to Proceed?');

			//alert(check);

			if(check == false)

			{

				$("#medicinename").val('');

				$("#rates").val('');

				

			}

			

		}

		}

		

		var status = varNewLineValue[6];

		

		if(status > 0)

		{

			

			var check=confirm('Medicine is Excluded for Patient Account');

			//alert(check);

			if(check == false)

			{

				$("#medicinename").val('');

				$("#rates").val('');

				

			}

			else

			{

				$("#exclude").val('excluded');

			}

		}

	

		//$("#serialnumber").val('');

		//$("#medicinename").val('');

		$("medicinename").val(varMedicineName);

		}

		else

		{

			alert('Medicine Is Out of stock');

			$("#medicinecode").val('');

			$("#medicinename").val('');

			$("#rates").val('');

			return false;

		}

	



		});





	}



$("#medicinename").keyup(function(){

	$("#medicinename").val(($("#medicinename").val()).toUpperCase());

	if($("#medicinename").val().length==0){



			$("#medicinecode").val('');

			$("#medicinename").val('');

			$("#rates").val('');



	}



});







});



</script>





<?php



			



$zero=0;



  echo "<script> if(".$selecttotal." >=0){document.getElementById('approvallimit').value=".$selecttotalf.";}else{document.getElementById('approvallimit').value=".$zero.";}</script>";?>

<?php include ("includes/footer1.php"); ?>

<?php //include ("print_bill_dmp4inch1.php"); ?>

</body>

</html>