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
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	$patientname = $_REQUEST["customername"];
	$consultationdate = date("Y-m-d");
	$accountname = $_REQUEST["account"];
	$billtype = $_REQUEST['billtype'];
	$patientage = $_REQUEST['patientage'];
	$patientgender = $_REQUEST['patientgender'];
	$dispensingfee = $_REQUEST['dispensingfee'];
	$locationcode = $_REQUEST['locationcode'];
	$locationname = $_REQUEST['locationname'];
	$counter='';
	if($billtype =='PAY NOW')
	{
	$status='pending';
	}
	else
	{
	$status='completed';
	}
	$query2 = "select * from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number desc limit 0, 1";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
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
	
	$sele=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_frequency where frequencycode='$afrequency'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$ress=mysqli_fetch_array($sele);
	$frequencyautonumber=$ress['auto_number'];
	$frequencycode=$ress['frequencycode'];
	
	$query34 = "update master_consultationpharm set days='$adays',dose='$adose',quantity='$aquantity',route='$aroute',instructions='$ainstructions',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode'";
	$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 
	
	$query35 = "update master_consultationpharmissue set days='$adays',dose='$adose',prescribed_quantity='$aquantity',quantity='$aquantity',route='$aroute',instructions='$ainstructions',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode'";
	$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 
	
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
		$route = $_REQUEST['route'.$p];
		$instructions = $_REQUEST['instructions'.$p];
		$rate = $_REQUEST['rates'.$p];
		$amount = $_REQUEST['amount'.$p];
		$exclude = $_REQUEST['exclude'.$p];
		//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
		if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
		{
			//echo '<br>'. 
			$query2 = "insert into master_consultationpharm(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,pharmacybill,medicineissue,source,route,approvalstatus,excludestatus,locationcode,locationname) 
			values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','pending','$medicinecode','$medrefnonumber','$status','pending','doctorconsultation','$route','1','$exclude','$locationcode','$locationname')";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query29 = "insert into master_consultationpharmissue(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,prescribed_quantity,source,route,approvalstatus,excludestatus,locationcode,locationname) 
			values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','$status','$medicinecode','$medrefnonumber','$quantity','doctorconsultation','$route','1','$exclude','$locationcode','$locationname')";
			$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
		$counter=$counter + 1;
		}
	}
	for($i=1;$i<20;$i++)
	{		
		$pharamapprovalstatus = isset($_POST['pharamcheck'][$i])?'1':'0';
		$pharamapprovalstatus = isset($_POST['pharamlatertonow'][$i])?'2':$pharamapprovalstatus;		
		$pharamcheck=trim($_POST['pharamanum'][$i]);
		
		if($pharamcheck!='' && $pharamapprovalstatus!='2')
		{
			mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharmissue set approvalstatus='$pharamapprovalstatus',paymentstatus='$status'  where auto_number='$pharamcheck' and patientvisitcode='$visitcode'");
			mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharm set approvalstatus='$pharamapprovalstatus',pharmacybill='$status'  where auto_number='$pharamcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
		else if($pharamcheck!='' && $pharamapprovalstatus=='2')
		{
			mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharmissue set approvalstatus='$pharamapprovalstatus',paymentstatus='pending'  where auto_number='$pharamcheck' and patientvisitcode='$visitcode'");
			mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharm set approvalstatus='$pharamapprovalstatus',pharmacybill='pending'  where auto_number='$pharamcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
	}
	foreach($_POST['lab'] as $key => $value)
	{
					//echo '<br>'.$k;
		$labname=$_POST['lab'][$key];
		$labquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_lab where itemname='$labname'");
		$execlab=mysqli_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate5'][$key];
		
		if(($labname!="")&&($labrate!=''))
		{
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_lab(consultationid,patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billtype,accountname,consultationdate,paymentstatus,refno,labsamplecoll,resultentry,labrefund,approvalstatus,locationcode,locationname)values('$consultationid','$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$billtype','$accountname','$consultationdate','$status','$labrefnonumber','pending','pending','norefund','1','$locationcode','$locationname')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$counter=$counter + 1;
		}
	}
	for($i=0;$i<20;$i++)
	{		
		$labapprovalstatus = isset($_POST['labcheck'][$i])?'1':'0';
		$labapprovalstatus = isset($_POST['lablatertonow'][$i])?'2':$labapprovalstatus;
		$labcheck=$_POST['labanum'][$i];
		if($labcheck!='' && $labapprovalstatus!='2')
		{
			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set approvalstatus='$labapprovalstatus',paymentstatus='$status'  where auto_number='$labcheck' and patientvisitcode='$visitcode'");		
			$counter=$counter + 1;
		}
		else if($labcheck!='' && $labapprovalstatus=='2')
		{
			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set approvalstatus='$labapprovalstatus',paymentstatus='pending' where auto_number='$labcheck' and patientvisitcode='$visitcode'");		
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
		
		
		if(($pairvar!="")&&($pairvar1!=""))
		{
		$radiologyquery1="insert into consultation_radiology(consultationid,patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billtype,accountname,consultationdate,paymentstatus,refno,resultentry,approvalstatus,locationcode,locationname)values('$consultationid','$patientcode','$patientname','$visitcode','$radiologycode','$pairvar','$pairvar1','$patientpaymentmode','$accountname','$consultationdate','$status','$radrefnonumber','pending','1','$locationcode','$locationname')";
		$radiologyexecquery1=mysqli_query($GLOBALS["___mysqli_ston"], $radiologyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$radiologyquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set radiologybill='pending' where visitcode='$visitcode'");
		$counter=$counter + 1;
		}
	}
	for($i=0;$i<20;$i++)
	{		
		$radapprovalstatus = isset($_POST['radcheck'][$i])?'1':'0';
		$radapprovalstatus = isset($_POST['radlatertonow'][$i])?'2':$radapprovalstatus;
		$radcheck=$_POST['radanum'][$i];
		if($radcheck!='' && $radapprovalstatus!='2')
		{
			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set approvalstatus='$radapprovalstatus',paymentstatus='$status'  where auto_number='$radcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
		else if($radcheck!='' && $radapprovalstatus=='2')
		{
			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set approvalstatus='$radapprovalstatus',paymentstatus='pending'  where auto_number='$radcheck' and patientvisitcode='$visitcode'");
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
		
		$servicesrate=$_POST["rate3"][$key];
		$serviceqty=$_POST['serviceqty'][$key];
		for($se=1;$se<=$serviceqty;$se++)
		{
		
		if(($servicesname!="")&&($servicesrate!=''))
		{
			$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_services(consultationid,patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,billtype,accountname,consultationdate,paymentstatus,refno,process,approvalstatus,locationcode,locationname)values('$consultationid','$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$patientpaymentmode','$accountname','$consultationdate','$status','$serrefnonumber','pending','1','$locationcode','$locationname')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$servicesquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set servicebill='pending' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$counter=$counter + 1;
		}
		}
	}
	for($i=0;$i<20;$i++)
	{
		$serapprovalstatus = isset($_POST['sercheck'][$i])?'1':'0';
		$serapprovalstatus = isset($_POST['serlatertonow'][$i])?'2':$serapprovalstatus;
		$sercheck=$_POST['seranum'][$i];
		if($sercheck!='' && $serapprovalstatus!='2')
		{
			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set approvalstatus='$serapprovalstatus',paymentstatus='$status'  where auto_number='$sercheck' and patientvisitcode='$visitcode'");		
			$counter=$counter + 1;
		}
		else if($sercheck!='' && $serapprovalstatus=='2')
		{
			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set approvalstatus='$serapprovalstatus',paymentstatus='pending'  where auto_number='$sercheck' and patientvisitcode='$visitcode'");		
			$counter=$counter + 1;
		}
	}
	
	if($counter>0)
	{
		$query2bill = "select * from approvalstatus order by auto_number desc limit 0, 1";
		$exec2bill = mysqli_query($GLOBALS["___mysqli_ston"], $query2bill) or die ("Error in Query2bill".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		$queryinsert = "insert into approvalstatus (recorddate,recordtime,docno,patientname,visitcode,patientcode,age,gender,billtype,accountname,ipaddress,username) values
		('$dateonly','$timeonly','$billnumbercode','$patientname','$visitcode','$patientcode','$patientage','$patientgender','$billtype','$accountname','$ipaddress','$username')";
		mysqli_query($GLOBALS["___mysqli_ston"], $queryinsert) or die ("Error in Queryinsert".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	if($dispensingfee != '')
	{
	    $query2bill1 = "select * from dispensingfee order by auto_number desc limit 0, 1";
		$exec2bill1 = mysqli_query($GLOBALS["___mysqli_ston"], $query2bill1) or die ("Error in Query2bill".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		mysqli_query($GLOBALS["___mysqli_ston"], $queryinsert1) or die ("Error in Queryinsert1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		header("location:opamendlist.php");
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
$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];
$subtypeanum = $res78['subtype'];
$patientname=$res78['patientfullname'];
$patientaccount=$res78['accountfullname'];
$res111paymenttype = $res78['paymenttype'];
$locationcode = $res78['locationcode'];
//$locationname = $res78['locationname'];

$query5 = "select * from master_location where locationcode = '$locationcode'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$locationname = $res5['locationname'];

$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";
$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
$res121 = mysqli_fetch_array($exec121);
$res121paymenttype = $res121['paymenttype'];

$query131 = "select * from master_subtype where auto_number = '$subtypeanum'";
$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
$res131 = mysqli_fetch_array($exec131);
$res131subtype = $res131['subtype'];
?>

<?php
$querylab7=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'");
$execlab7=mysqli_fetch_array($querylab7);
$billtype=$execlab7['billtype'];

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$labprefix = $res3['labprefix'];

$query2 = "select * from approvalstatus order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
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
function btnDeleteClick10(delID,pharmamount)
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
	
	document.getElementById('total').value=newtotal4;
	
	grandtotalminus(pharmamount);
}
function btnDeleteClick6(delID1,vrate1)
{
	//alert ("Inside btnDeleteClick.");
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
	newtotal3= currenttotal3-vrate1;
	
	//alert(newtotal3);
	
	document.getElementById('total1').value=newtotal3.toFixed(2);
	
	grandtotalminus(vrate1);

}
function btnDeleteClick9(delID5,radrate)
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
	
	grandtotalminus(radrate);
	

	
}
function btnDeleteClick12(delID3,vrate3)
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
	grandtotalminus(vrate3);
	
	
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
	
	 //To handle ajax dropdown list.
	funcCustomerDropDownSearch4();
	funcPopupPrintFunctionCall();
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.	
	funcPopupPrintFunctionCall();
	funcCustomerDropDownSearch2(); 
	funcCustomerDropDownSearch3();	
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
		if(document.getElementById('pharamcheck'+i).disabled==false)
		{
   		 	pharamcheck = document.getElementById('pharamcheck'+i).checked = true ; 
			document.getElementById('pharamlatertonow'+i).disabled = true;   		
		}
	}
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('labcheck'+i))
	{
		if(document.getElementById('labcheck'+i).disabled==false)
		{
			labcheck = document.getElementById('labcheck'+i).checked = true;
			document.getElementById('lablatertonow'+i).disabled = true;
		}
	}	
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('radcheck'+i))
	{
		if(document.getElementById('radcheck'+i).disabled==false)
		{
			radcheck = document.getElementById('radcheck'+i).checked = true;
			document.getElementById('radlatertonow'+i).disabled = true;	
		}
	}
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('sercheck'+i))
	{
		if(document.getElementById('sercheck'+i).disabled==false)
		{
			sercheck = document.getElementById('sercheck'+i).checked = true;
			document.getElementById('serlatertonow'+i).disabled = true;
		}
	}	
	}
	
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
		}
	}	
	}
}
}
function selectcash(checkname,sno)
{

var sno = sno;
if(checkname=='pharam')
{
	if(document.getElementById('pharamlatertonow'+sno).checked == true)
	{
		document.getElementById('pharamcheck'+sno).disabled =true;
	}
	else
	{
		document.getElementById('pharamcheck'+sno).disabled = false;
	}
}
if(checkname=='lab')
{
	if(document.getElementById('lablatertonow'+sno).checked == true)
	{
		document.getElementById('labcheck'+sno).disabled=true;
	}
	else
	{
		document.getElementById('labcheck'+sno).disabled=false;
	}
}
if(checkname=='rad')
{
	if(document.getElementById('radlatertonow'+sno).checked == true)
	{
		document.getElementById('radcheck'+sno).disabled=true;
	}
	else
	{
		document.getElementById('radcheck'+sno).disabled=false;
	}
}
if(checkname=='ser')
{
	if(document.getElementById('serlatertonow'+sno).checked == true)
	{
		document.getElementById('sercheck'+sno).disabled=true;
	}
	else
	{
		document.getElementById('sercheck'+sno).disabled=false;
	}
}
}
function selectselect(checkname,sno)
{
//alert(sno);
var sno = sno;
if(checkname=='pharam')
{
	if(document.getElementById('pharamcheck'+sno).checked == true)
	{
		document.getElementById('pharamlatertonow'+sno).disabled=true;
	}
	else
	{
		document.getElementById('pharamlatertonow'+sno).disabled=false;
	}
}
if(checkname=='lab')
{
	if(document.getElementById('labcheck'+sno).checked == true)
	{
		document.getElementById('lablatertonow'+sno).disabled=true;
	}
	else
	{
		document.getElementById('lablatertonow'+sno).disabled=false;
	}
}
if(checkname=='rad')
{
	if(document.getElementById('radcheck'+sno).checked == true)
	{
		document.getElementById('radlatertonow'+sno).disabled=true;
	}
	else
	{
		document.getElementById('radlatertonow'+sno).disabled=false;
	}
}
if(checkname=='ser')
{
	if(document.getElementById('sercheck'+sno).checked == true)
	{
		document.getElementById('serlatertonow'+sno).disabled=true;
	}
	else
	{
		document.getElementById('serlatertonow'+sno).disabled=false;
	}
	
}
}
function grandtotl(vrate)
{
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
	document.getElementById("grandtotal").value=grandtotal.toFixed(2);
}
function grandtotalminus(vrate)
{
var varserRate=vrate;

	grandtotal=document.getElementById('grandtotal').value;
	grandtotal=grandtotal.replace(/,/g,'');
	grandtotal=parseInt(grandtotal,10);
	grandtotal=parseInt(grandtotal) - parseInt(varserRate);
	document.getElementById("grandtotal").value=grandtotal.toFixed(2);
}
function calculate()
{
var dispensingfee = document.getElementById("dispensingfee").value;
var grandtotal = document.getElementById("hidgrandtotal").value;
grandtotal=grandtotal.replace(/,/g,'');
var newgrandtotal = parseFloat(dispensingfee) + parseFloat(grandtotal);
if(dispensingfee != '')
{
document.getElementById("grandtotal").value = newgrandtotal.toFixed(2);
}
else
{
document.getElementById("grandtotal").value = grandtotal;
}
}
</script>
<?php include ("js/dropdownlist1newscriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewmedicine1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newmedicineq.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch2.js"></script>
<script type="text/javascript" src="js/insertnewitemforallamendpharam.js"></script>
<?php include ("autocompletebuild_lab1.php"); ?>
<?php include ("js/dropdownlist1scriptinglab1.php"); ?>
<script type="text/javascript" src="js/autocomplete_lab1.js"></script>
<script type="text/javascript" src="js/autosuggestlab1.js"></script> 
<script type="text/javascript" src="js/autolabcodesearch2.js"></script>
<script type="text/javascript" src="js/insertnewitemforallamendlab.js"></script>
<?php include ("js/dropdownlist1scriptingradiology1.php"); ?>
<?php include("autocompletebuild_radiology1.php"); ?>
<script type="text/javascript" src="js/autocomplete_radiology1.js"></script>
<script type="text/javascript" src="js/autosuggestradiology1.js"></script> 
<script type="text/javascript" src="js/autoradiologycodesearch2.js"></script>
<script type="text/javascript" src="js/insertnewitemforallamendrad.js"></script>
<?php include ("js/dropdownlist1scriptingservices1.php"); ?>
<?php include ("autocompletebuild_services1.php");?>
<script type="text/javascript" src="js/autocomplete_services1.js"></script>
<script type="text/javascript" src="js/autosuggestservices1.js"></script>
<script type="text/javascript" src="js/autoservicescodesearch2.js"></script>
<script type="text/javascript" src="js/insertnewitemforallamend.js"></script>
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

<script src="js/datetimepicker_css.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="opamend1.php" onKeyDown="return disableEnterKey(event)">
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
				<input name="customername" id="customer" type="hidden" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly="readonly"/><?php echo $patientname; ?>
                  </td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    </tr>
			   <tr>
			    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input name="patientage" type="hidden" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly="readonly"><?php echo $patientage; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly="readonly"><?php echo $patientgender; ?>
				<input type="hidden" name="address1" id="address1" value="<?php echo $res41address1; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="30" />
			      <span class="style4"><!--Area--> </span>
			      <input type="hidden" name="area" id="area" value="<?php echo $res41area; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="10" />
				  <input type="hidden" name="subtype" id="subtype" value="<?php echo $res131subtype; ?>">
				  </td>
				    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $patientaccount; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/><?php echo $patientaccount; ?>
				<input type="hidden" name="billtype" value="<?php echo $billtype; ?>">		
				<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>">	
				
				<input type="hidden" name="paymenttype" id="payment" value="<?php echo $res121paymenttype; ?>" readonly   size="20" />			  		  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td colspan="1" align="left" valign="top" class="bodytext3" >
				<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/><?php echo $visitcode; ?>
				<td colspan="1" align="left" valign="top" class="bodytext3" ><strong>Doc Number</strong></td>
				<td colspan="1" align="left" valign="top" class="bodytext3" ><?php echo $billnumbercode; ?></td>
				  </tr>
				   <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location Code</strong></td>
                <td colspan="1" align="left" valign="top" class="bodytext3" >
				<input name="locationcode" id="locationcode" type="hidden" value="<?php echo $locationcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/><?php echo $locationcode; ?>
				<td colspan="1" align="left" valign="top" class="bodytext3" ><strong>Location</strong></td>
				<td colspan="1" align="left" valign="top" class="bodytext3" >
				<input name="locationname" id="locationname" type="hidden" value="<?php echo $locationname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/><strong><?php echo $locationname; ?></strong></td>
				  </tr>
            </tbody>
        </table></td>
      </tr>
	  <?php if($billtype == 'PAY LATER')
				{
				?>
	  <tr>
	  <td colspan="2"  class="bodytext3"><input type="hidden" value="selectall" name="selectalll" id="selectalll" onClick="selectall();"></td>
	  </tr>
	  <?php } ?>
	  <?php
	  if($billtype == 'PAY NOW')
			{
				$status='pending';
			}
			else
			{
				$status='completed';
			}
		$query171nums = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and medicineissue='pending'and approvalstatus<>'2'";
		$exec171nums = mysqli_query($GLOBALS["___mysqli_ston"], $query171nums) or die ("Error in Query171nums".mysqli_error($GLOBALS["___mysqli_ston"]));
		$nums171 = mysqli_num_rows($exec171nums);
		$query172nums = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and medicineissue='pending' and pharmacybill='pending' and approvalstatus='2'";
		$exec172nums = mysqli_query($GLOBALS["___mysqli_ston"], $query172nums) or die ("Error in Query172nums".mysqli_error($GLOBALS["___mysqli_ston"]));
		$nums172=mysqli_num_rows($exec172nums);
		$nums17pharam = $nums171 + $nums172;
	  ?>
	 
	  <tr>
	  <td width="90%" bgcolor="#ecf0f5" class="bodytext3"><strong>Prescription </strong></td>
	  </tr>
       <?php
	  if($nums17pharam>0)
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
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
				<?php } ?>
              <td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				
				<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Medicine Name</strong></div></td>
				<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Dose</strong></div></td>
			
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
				$status='completed';
			}
	
			$query17 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and medicineissue='pending'and approvalstatus<>'2'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="hidden" id="pharamcheck<?php echo $sno; ?>" name="pharamcheck[<?php echo $sno; ?>]" value="<?php echo $medanum; ?>" <?php if($approvalstatus=='1'){ echo "checked=checked";}?> onClick="selectselect('pharam','<?php echo $sno; ?>')"/>
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
				</select>
				 </div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="adays[]" id="adays<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdays; ?>" size="8" style="text-align:center;"></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aquantity[]" id="aquantity<?php echo $sno; ?>" value="<?php echo $pharmquantity; ?>" size="8" class="bal" readonly="readonly"></div></td>
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
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="arate[]" id="arate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>" size="8" class="bal" readonly="readonly"></div></td>
				
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aamount[]" id="aamount<?php echo $sno; ?>" value="<?php echo $pharmamount; ?>" size="8" class="bal" readonly="readonly"></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center">
				 <a onClick="return deletevalid()" href="opamend1.php?delete=<?php echo $medanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=pharm">Delete</a>
				 </div></td>
				 <?php if($billtype == 'PAY LATER')
				{
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="pharamlatertonow[<?php echo $sno; ?>]" id="pharamlatertonow<?php echo $sno; ?>" value="<?php echo $medanum; ?>" onClick="selectcash('pharam','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php 
			} 
			}?>
			<?php 
			$query17 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and medicineissue='pending' and pharmacybill='pending' and approvalstatus='2'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="hidden" id="pharamcheck<?php echo $sno; ?>" name="pharamcheck[<?php echo $sno; ?>]" value="<?php echo $medanum; ?>" <?php if($approvalstatus=='2'){ echo "";}?> onClick="selectselect('pharam','<?php echo $sno; ?>')"/>
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
				</select>
				 </div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="adays[]" id="adays<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdays; ?>" size="8" style="text-align:center;"></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aquantity[]" id="aquantity<?php echo $sno; ?>" value="<?php echo $pharmquantity; ?>" size="8" class="bal" readonly="readonly"></div></td>
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

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="arate[]" id="arate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>" size="8" class="bal" readonly="readonly"></div></td>
				
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aamount[]" id="aamount<?php echo $sno; ?>" value="<?php echo $pharmamount; ?>" size="8" class="bal" readonly="readonly"></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center">
				 <a onClick="return deletevalid()" href="opamend1.php?delete=<?php echo $medanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=pharm">Delete</a>
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
			}?>
			  
           
          </tbody>
        </table>		</td>
      </tr>
	  <?php } ?>
      <tr>
	   <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Prescribe Medicine</strong></td>
	 
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
					   <input type="hidden" name="genericname" id="genericname">	
				  		<input type="hidden" name="drugallergy" id="drugallergy">
						<input type="hidden" name="exclude" id="exclude">	
                       <td><input name="medicinename" type="text" id="medicinename" size="40" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()"></td>
                       <td><input name="dose" type="text" id="dose" size="8" onKeyUp="return Functionfrequency1()"></td>
                       <td>
					    <input name="formula" type="hidden" id="formula" readonly size="8">
						<input name="strength" type="hidden" id="strength" readonly size="8">
					   <select name="frequency" id="frequency" onChange="return Functionfrequency1()">
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
                       <td><input name="days" type="text" id="days" size="8" onKeyUp="return Functionfrequency1()" onFocus="return frequencyitem()"></td>
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
					   </select></td>
                       <td><input name="instructions" type="text" id="instructions" size="20"></td>
                       <td width="48"><input name="rates" type="text" id="rates" readonly size="8"></td>
                       <td>
                         <input name="amount" type="text" id="amount" readonly size="8"></td>
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" >
                       </label></td>
				     </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
          </tr>
		  <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2"></span><input type="hidden" name="dispensingfee" id="dispensingfee" size="7" onKeyUp="return calculate();"></td>
			      </tr>
				    <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total" readonly size="7"></td>
			      </tr>
				  
				 <?php
				if($billtype == 'PAY NOW')
				{
				$status='pending';
				}
				else
				{
				$status='completed';
				}
				 $query171lab = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and paymentstatus='$status' and labsamplecoll='pending' and approvalstatus<>'2'";
				 $exec171lab = mysqli_query($GLOBALS["___mysqli_ston"], $query171lab) or die ("Error in Query171lab".mysqli_error($GLOBALS["___mysqli_ston"]));
				 $num171lab = mysqli_num_rows($exec171lab);
				 $query172lab = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and paymentstatus='pending' and labsamplecoll='pending' and approvalstatus='2'";
				 $exec172lab = mysqli_query($GLOBALS["___mysqli_ston"], $query172lab) or die ("Error in Query172lab".mysqli_error($GLOBALS["___mysqli_ston"]));
				 $num172lab = mysqli_num_rows($exec172lab);
				 $num17lab = $num171lab + $num172lab;
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
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
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
			$status='completed';
			}
			$query17 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and paymentstatus='$status' and labsamplecoll='pending' and approvalstatus<>'2'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res17 = mysqli_fetch_array($exec17))
			{
			
				$paharmitemname=$res17['labitemname'];				
				$pharmitemcode=$res17['labitemcode'];
				$pharmitemrate=$res17['labitemrate'];
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
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="hidden" id="labcheck<?php echo $sno; ?>" name="labcheck[<?php echo $sno; ?>]" value="<?php echo $labanum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";}?> onClick="selectselect('lab','<?php echo $sno; ?>')"/>
			   <input type="hidden" name="labanum[<?php echo $sno; ?>]" id="labanum<?php echo $sno; ?>"  value="<?php echo $labanum; ?>">
			   </div></td>
			   <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			    
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend1.php?delete=<?php echo $labanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=lab">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="lablatertonow[<?php echo $sno; ?>]" id="lablatertonow<?php echo $sno; ?>"  onClick="selectcash('lab','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php } ?>
			<?php
			$query17 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and paymentstatus='pending' and labsamplecoll='pending' and approvalstatus='2'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res17 = mysqli_fetch_array($exec17))
			{
			
				$paharmitemname=$res17['labitemname'];				
				$pharmitemcode=$res17['labitemcode'];
				$pharmitemrate=$res17['labitemrate'];
				$labanum=$res17['auto_number'];
				$approvalstatus=$res17['approvalstatus'];
			$grandtotal = $grandtotal + $pharmitemrate;
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
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="hidden" id="labcheck<?php echo $sno; ?>" name="labcheck[<?php echo $sno; ?>]" value="<?php echo $labanum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";}?> <?php if($approvalstatus=='2'){ echo "";}?> onClick="selectselect('lab','<?php echo $sno; ?>')"/>
			   <input type="hidden" name="labanum[<?php echo $sno; ?>]" id="labanum<?php echo $sno; ?>"  value="<?php echo $labanum; ?>">
			   </div></td>
			   <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			    
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend1.php?delete=<?php echo $labanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=lab">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="lablatertonow[<?php echo $sno; ?>]" id="lablatertonow<?php echo $sno; ?>"  onClick="selectcash('lab','<?php echo $sno; ?>')" <?php if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php } ?>
			 <tr>
			<?php } ?> 
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
				      <td width="30"><input name="lab[]" id="lab" type="text" size="69" autocomplete="off" ></td>
				      <td width="30"><input name="rate5[]" type="text" id="rate5" readonly size="8"></td>
					  <td><label>
                       <input type="button" name="Add1" id="Add1" value="Add" onClick="return insertitem6()" class="button" >
                       </label></td>
					   </tr>
					    </table>	  </td> 
					
				      </tr>
					  <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total1" readonly size="7"></td>
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
		$status='completed';
	}
		$query171rad = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and paymentstatus='$status' and resultentry='pending' and approvalstatus<>'2'";
		$exec171rad = mysqli_query($GLOBALS["___mysqli_ston"], $query171rad) or die ("Error in Query171rad".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num171rad  = mysqli_num_rows($exec171rad);
		$query172rad = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and paymentstatus='pending' and resultentry='pending' and approvalstatus='2'";
		$exec172rad = mysqli_query($GLOBALS["___mysqli_ston"], $query172rad) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num172rad  = mysqli_num_rows($exec172rad);
		$num17rad = $num171rad + $num172rad;
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
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
				<?php }?>
              <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Radiology</strong></div></td>
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
			$status='completed';
			}
			$query17 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and paymentstatus='$status' and resultentry='pending' and approvalstatus<>'2'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res17 = mysqli_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['radiologyitemname'];				
			$pharmitemcode=$res17['radiologyitemcode'];
			$pharmitemrate=$res17['radiologyitemrate'];
			$radanum=$res17['auto_number'];
			$approvalstatus=$res17['approvalstatus'];	
			$grandtotal = $grandtotal + $pharmitemrate;
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
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="hidden" id="radcheck<?php echo $sno; ?>" name="radcheck[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";}?> onClick="selectselect('rad','<?php echo $sno; ?>')"/>
			  <input type="hidden" name="radanum[<?php echo $sno; ?>]" id="radanum<?php echo $sno; ?>"  value="<?php echo $radanum; ?>">
			  </div></td>
			  <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			   
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend1.php?delete=<?php echo $radanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=radiology">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="radlatertonow[<?php echo $sno; ?>]" id="radlatertonow<?php echo $sno; ?>" onClick="selectcash('rad','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php } ?>
			 <?php
            $query17 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and paymentstatus='pending' and resultentry='pending' and approvalstatus='2'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res17 = mysqli_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['radiologyitemname'];				
			$pharmitemcode=$res17['radiologyitemcode'];
			$pharmitemrate=$res17['radiologyitemrate'];
			$radanum=$res17['auto_number'];
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
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="hidden" id="radcheck<?php echo $sno; ?>" name="radcheck[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";}?> <?php if($approvalstatus=='2'){ echo "";}?> onClick="selectselect('rad','<?php echo $sno; ?>')"/>
			  <input type="hidden" name="radanum[<?php echo $sno; ?>]" id="radanum<?php echo $sno; ?>"  value="<?php echo $radanum; ?>">
			  </div></td>
			  <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			   
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend1.php?delete=<?php echo $radanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=radiology">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="radlatertonow[<?php echo $sno; ?>]" id="radlatertonow<?php echo $sno; ?>" onClick="selectcash('rad','<?php echo $sno; ?>')" <?php if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php } ?>
          </tbody>
        </table>		</td>
      </tr>
	  <?php } ?>
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
				   <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total2" readonly size="7"></td>
				   </tr>
				   <?php 
			   if($billtype == 'PAY NOW')
				{
					$status='pending';
				}
				else
				{
					$status='completed';
				}
			$query171ser = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and paymentstatus='$status' and process='pending' and approvalstatus<>'2'";
			$exec171ser = mysqli_query($GLOBALS["___mysqli_ston"], $query171ser) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num171ser = mysqli_num_rows($exec171ser);
			$query172ser = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and paymentstatus='pending' and process='pending' and approvalstatus='2'";
			$exec172ser = mysqli_query($GLOBALS["___mysqli_ston"], $query172ser) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num172ser = mysqli_num_rows($exec172ser);
			$num17ser = $num171ser + $num172ser;
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
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
				<?php } ?>
              <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Services</strong></div></td>
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
			$status='completed';
			}
			$query17 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and paymentstatus='$status' and process='pending' and approvalstatus<>'2'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res17 = mysqli_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['servicesitemname'];
			$pharmitemcode=$res17['servicesitemcode'];
			$pharmitemrate=$res17['servicesitemrate'];
			$seranum = $res17['auto_number'];
			$approvalstatus=$res17['approvalstatus'];
			$grandtotal = $grandtotal + $pharmitemrate;
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
			$totalamount=number_format($totalamount,2);
		
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="hidden" id="sercheck<?php echo $sno; ?>" name="sercheck[<?php echo $sno; ?>]" value="<?php echo $seranum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";}?> onClick="selectselect('ser','<?php echo $sno; ?>')"/>
			  <input type="hidden" name="seranum[<?php echo $sno; ?>]" id="seranum<?php echo $sno; ?>" value="<?php echo $seranum; ?>">
	
			  </div></td>
			  <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			    
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend1.php?delete=<?php echo $seranum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=service">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="serlatertonow[<?php echo $sno; ?>]" id="serlatertonow<?php echo $sno; ?>"  onClick="selectcash('ser','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "";}?>>
				</div></td>
				<?php }?>
				</tr>
			<?php } ?>
			  <?php
			  $query17 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and locationcode = '$locationcode' and paymentstatus='pending' and process='pending' and approvalstatus='2'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res17 = mysqli_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['servicesitemname'];
			$pharmitemcode=$res17['servicesitemcode'];
			$pharmitemrate=$res17['servicesitemrate'];
			$seranum = $res17['auto_number'];
			$approvalstatus=$res17['approvalstatus'];
			$grandtotal = $grandtotal + $pharmitemrate;
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
			$totalamount=number_format($totalamount,2);
		
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="hidden" id="sercheck<?php echo $sno; ?>" name="sercheck[<?php echo $sno; ?>]" value="<?php echo $seranum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";}?> <?php if($approvalstatus=='2'){ echo "";}?> onClick="selectselect('ser','<?php echo $sno; ?>')"/>
			  <input type="hidden" name="seranum[<?php echo $sno; ?>]" id="seranum<?php echo $sno; ?>" value="<?php echo $seranum; ?>">
	
			  </div></td>
			  <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			    
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend1.php?delete=<?php echo $seranum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=service">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="serlatertonow[<?php echo $sno; ?>]" id="serlatertonow<?php echo $sno; ?>"  onClick="selectcash('ser','<?php echo $sno; ?>')"  <?php if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php }?>
				</tr>
			<?php } ?>
           
          </tbody>
        </table>		</td>
      </tr>
	  <?php } ?>
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
				   <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total3" readonly size="7"></td>
				   </tr>
		<tr>
		 	  <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Grand Total</span><input type="text" id="grandtotal" value="<?php echo number_format($grandtotal,2,'.',','); ?>" readonly size="7"></td>
		   </tr><input type="hidden" name="hidgrandtotal" id="hidgrandtotal" value="<?php echo number_format($grandtotal,2,'.',','); ?>">
      <tr>        
		 <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
               <input name="Submit222" type="submit"  value="Submit" class="button"/>
		 </td>
      </tr>
	  </table>
      </td>
      </tr>    
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>